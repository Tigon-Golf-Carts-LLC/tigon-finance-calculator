<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Core shortcode: [tigon_finance_calculator]
 *
 * Optional attributes:
 *   price        – override the WooCommerce product price
 *   label        – CTA button text (default "Apply for Financing")
 *   url          – CTA button link (default "https://tigongolfcarts.com/apply-for-financing")
 *   manufacturer – manufacturer slug for branding (denago, evolution, teko, tara, atlas, clubcar, ezgo, swiftev, used)
 */
function tigon_finance_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'price'        => '',
        'label'        => 'Apply for Financing',
        'url'          => 'https://tigongolfcarts.com/apply-for-financing',
        'manufacturer' => '',
        'best_fee'     => '',
    ), $atts, 'tigon_finance_calculator' );

    // Determine price: explicit attribute > current WooCommerce product.
    $price = '';
    if ( ! empty( $atts['price'] ) ) {
        $price = floatval( $atts['price'] );
    } elseif ( function_exists( 'wc_get_product' ) ) {
        global $product;
        $wc_product = $product;
        if ( ! $wc_product && get_the_ID() ) {
            $wc_product = wc_get_product( get_the_ID() );
        }
        if ( $wc_product ) {
            $price = floatval( $wc_product->get_price() );
        }
    }

    if ( empty( $price ) || $price <= 0 ) {
        return '<!-- TIGON Finance: no valid price found -->';
    }

    // LOWEST PAYMENT: 60 months @ 7.99% APR (standard amortization).
    $annual_rate       = 7.99;
    $monthly_rate      = ( $annual_rate / 100 ) / 12;
    $num_payments_low  = 60;
    $lowest_payment    = ( $price * $monthly_rate * pow( 1 + $monthly_rate, $num_payments_low ) )
                         / ( pow( 1 + $monthly_rate, $num_payments_low ) - 1 );
    $lowest_total      = $lowest_payment * $num_payments_low;

    // BEST DEAL: 0% for 36 months + fee (default 5.25%, Used = 10%).
    $fee_rate          = ! empty( $atts['best_fee'] ) ? floatval( $atts['best_fee'] ) : 5.25;
    $num_payments_best = 36;
    $best_total        = $price * ( 1 + $fee_rate / 100 );
    $best_payment      = $best_total / $num_payments_best;

    $currency_symbol = function_exists( 'get_woocommerce_currency_symbol' )
        ? get_woocommerce_currency_symbol()
        : '$';

    $apply_url    = esc_url( $atts['url'] );
    $manufacturer = sanitize_key( $atts['manufacturer'] );

    $manufacturer_labels = tigon_finance_get_manufacturer_labels();
    $mfr_display = '';
    if ( $manufacturer && isset( $manufacturer_labels[ $manufacturer ] ) ) {
        $mfr_display = $manufacturer_labels[ $manufacturer ];
    }

    $box_classes = 'tigon-finance-box';
    if ( $manufacturer ) {
        $box_classes .= ' tigon-finance-mfr-' . $manufacturer;
    }

    ob_start();
    ?>
    <div class="<?php echo esc_attr( $box_classes ); ?>"
         data-price="<?php echo esc_attr( $price ); ?>"
         data-apply-url="<?php echo $apply_url; ?>"
         data-manufacturer="<?php echo esc_attr( $manufacturer ); ?>"
         data-best-fee="<?php echo esc_attr( $fee_rate ); ?>">

        <div class="tigon-finance-header">
            <span class="tigon-finance-header-icon">&#9733;</span>
            <span class="tigon-finance-header-text">0% Financing Available</span>
            <span class="tigon-finance-header-icon tigon-finance-header-icon-after">&#9733;</span>
        </div>

        <div class="tigon-finance-tabs">
            <button class="tigon-finance-tab active" data-tab="lowest" type="button">Lowest Payment</button>
            <button class="tigon-finance-tab" data-tab="best" type="button">Best Deal</button>
        </div>

        <div class="tigon-finance-panels">
            <div class="tigon-finance-panel active" data-tab="lowest">
                <p class="tigon-finance-as-low">As low as</p>
                <p class="tigon-finance-amount">
                    <span class="tigon-finance-currency"><?php echo esc_html( $currency_symbol ); ?></span>
                    <span class="tigon-finance-value"><?php echo esc_html( number_format( $lowest_payment, 2 ) ); ?></span>
                    <span class="tigon-finance-per">/mo</span>
                </p>
                <p class="tigon-finance-details">for <?php echo $num_payments_low; ?> months</p>
            </div>

            <div class="tigon-finance-panel" data-tab="best">
                <p class="tigon-finance-as-low">Best Deal</p>
                <p class="tigon-finance-amount">
                    <span class="tigon-finance-currency"><?php echo esc_html( $currency_symbol ); ?></span>
                    <span class="tigon-finance-value"><?php echo esc_html( number_format( $best_payment, 2 ) ); ?></span>
                    <span class="tigon-finance-per">/mo</span>
                </p>
                <p class="tigon-finance-details">for <?php echo $num_payments_best; ?> months &bull; 0% APR</p>
            </div>
        </div>

        <a href="<?php echo $apply_url; ?>" target="_blank" rel="noopener noreferrer" class="tigon-finance-cta-link" aria-label="Apply for financing">
            <span class="tigon-finance-cta">
                <?php echo esc_html( $atts['label'] ); ?>
            </span>
        </a>
        <?php if ( 'used' === $manufacturer ) : ?>
            <p class="tigon-finance-disclaimer tigon-finance-disclaimer-used">* 0% financing is only available on vehicles 2016 or newer.</p>
        <?php endif; ?>
        <p class="tigon-finance-disclaimer"><strong>Promo rates available as low as 0% up to 48 Months.</strong> All Financing options are subject to credit approval. Terms, Rates, and Conditions may vary based on the Applicant's credit profile, and lender requirements. Additional fees may apply.</p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'tigon_finance_calculator', 'tigon_finance_shortcode' );

// Keep legacy shortcode working.
add_shortcode( 'tigon_finance-calculator', 'tigon_finance_shortcode' );

/**
 * User-driven shortcode: [tigon_user_finance_calculator]
 *
 * Renders the same styled box as the standard calculator, but allows the visitor
 * to enter a custom price and pick a term length (1–7 years, displayed in months).
 *
 * Optional attributes:
 *   price       – initial price prefilled in the input
 *   term        – initial term in months (12, 24, 36, 48, 60, 72, 84)
 *   label       – CTA button text (default "Apply for Financing")
 *   url         – CTA button link (default "https://tigongolfcarts.com/apply-for-financing")
 *   header      – header bar text (default "Estimate Your Monthly Payment")
 *   annual_rate – APR used for amortization on the normal financing tab (default 7.99)
 *   best_fee    – % fee added to price on the 0% financing tab (default 5.25)
 */
function tigon_user_finance_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'price'       => '',
        'term'        => 60,
        'label'       => 'Apply for Financing',
        'url'         => 'https://tigongolfcarts.com/apply-for-financing',
        'annual_rate' => 7.99,
        'best_fee'    => 5.25,
        'header'      => 'Estimate Your Monthly Payment',
    ), $atts, 'tigon_user_finance_calculator' );

    $initial_price = floatval( $atts['price'] );
    $annual_rate   = floatval( $atts['annual_rate'] );
    $best_fee      = floatval( $atts['best_fee'] );
    $term_options  = array( 12, 24, 36, 48, 60, 72, 84 );
    $initial_term  = intval( $atts['term'] );
    if ( ! in_array( $initial_term, $term_options, true ) ) {
        $initial_term = 60;
    }

    $currency_symbol = function_exists( 'get_woocommerce_currency_symbol' )
        ? get_woocommerce_currency_symbol()
        : '$';

    $apply_url = esc_url( $atts['url'] );

    // Initial monthly payments (if a price was supplied).
    $normal_payment = 0;
    $zero_payment   = 0;
    if ( $initial_price > 0 ) {
        $monthly_rate   = ( $annual_rate / 100 ) / 12;
        $normal_payment = ( $initial_price * $monthly_rate * pow( 1 + $monthly_rate, $initial_term ) )
                          / ( pow( 1 + $monthly_rate, $initial_term ) - 1 );
        $zero_payment   = ( $initial_price * ( 1 + $best_fee / 100 ) ) / $initial_term;
    }

    ob_start();
    ?>
    <div class="tigon-finance-box tigon-finance-user"
         data-price="<?php echo esc_attr( $initial_price ); ?>"
         data-term="<?php echo esc_attr( $initial_term ); ?>"
         data-annual-rate="<?php echo esc_attr( $annual_rate ); ?>"
         data-best-fee="<?php echo esc_attr( $best_fee ); ?>"
         data-apply-url="<?php echo $apply_url; ?>">

        <div class="tigon-finance-header">
            <span class="tigon-finance-header-icon">&#9733;</span>
            <span class="tigon-finance-header-text"><?php echo esc_html( $atts['header'] ); ?></span>
            <span class="tigon-finance-header-icon tigon-finance-header-icon-after">&#9733;</span>
        </div>

        <div class="tigon-finance-tabs">
            <button class="tigon-finance-tab active" data-tab="normal" type="button">Financing</button>
            <button class="tigon-finance-tab" data-tab="zero" type="button">0% Financing</button>
        </div>

        <div class="tigon-finance-user-controls">
            <label class="tigon-finance-user-field">
                <span class="tigon-finance-user-label">Vehicle Price</span>
                <input type="number"
                       class="tigon-finance-user-input tigon-finance-user-price"
                       min="0"
                       step="100"
                       inputmode="decimal"
                       placeholder="<?php echo esc_attr( $currency_symbol ); ?> Enter price"
                       value="<?php echo $initial_price > 0 ? esc_attr( $initial_price ) : ''; ?>" />
            </label>

            <label class="tigon-finance-user-field">
                <span class="tigon-finance-user-label">Term Length</span>
                <select class="tigon-finance-user-input tigon-finance-user-term">
                    <?php foreach ( $term_options as $months ) : ?>
                        <option value="<?php echo esc_attr( $months ); ?>"
                            <?php selected( $initial_term, $months ); ?>>
                            <?php echo esc_html( $months . ' months' ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <div class="tigon-finance-panels">
            <div class="tigon-finance-panel active" data-tab="normal">
                <p class="tigon-finance-as-low">Estimated Monthly Payment</p>
                <p class="tigon-finance-amount">
                    <span class="tigon-finance-currency"><?php echo esc_html( $currency_symbol ); ?></span>
                    <span class="tigon-finance-value"><?php echo esc_html( number_format( $normal_payment, 2 ) ); ?></span>
                    <span class="tigon-finance-per">/mo</span>
                </p>
                <p class="tigon-finance-details">for <span class="tigon-finance-user-term-label"><?php echo esc_html( $initial_term ); ?></span> months &bull; <?php echo esc_html( number_format( $annual_rate, 2 ) ); ?>% APR</p>
            </div>

            <div class="tigon-finance-panel" data-tab="zero">
                <p class="tigon-finance-as-low">0% Financing</p>
                <p class="tigon-finance-amount">
                    <span class="tigon-finance-currency"><?php echo esc_html( $currency_symbol ); ?></span>
                    <span class="tigon-finance-value"><?php echo esc_html( number_format( $zero_payment, 2 ) ); ?></span>
                    <span class="tigon-finance-per">/mo</span>
                </p>
                <p class="tigon-finance-details">for <span class="tigon-finance-user-term-label"><?php echo esc_html( $initial_term ); ?></span> months &bull; 0% APR</p>
            </div>
        </div>

        <button type="button" class="tigon-finance-calculate">Calculate Price</button>

        <a href="<?php echo $apply_url; ?>" target="_blank" rel="noopener noreferrer" class="tigon-finance-cta-link" aria-label="Apply for financing">
            <span class="tigon-finance-cta">
                <?php echo esc_html( $atts['label'] ); ?>
            </span>
        </a>

        <p class="tigon-finance-disclaimer"><strong>Estimated payment is for illustrative purposes only.</strong> Actual rates and terms are subject to credit approval. Terms, Rates, and Conditions may vary based on the Applicant's credit profile, and lender requirements. Additional fees may apply.</p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'tigon_user_finance_calculator', 'tigon_user_finance_shortcode' );

/**
 * Return manufacturer display labels keyed by slug.
 */
function tigon_finance_get_manufacturer_labels() {
    return array(
        'denago'    => 'Denago',
        'evolution' => 'Evolution',
        'teko'      => 'TEKO',
        'tara'      => 'TARA',
        'atlas'     => 'Atlas',
        'clubcar'   => 'Club Car',
        'ezgo'      => 'E-Z-GO',
        'swiftev'   => 'Swift EV',
        'used'      => 'Used',
    );
}

/**
 * Register per-manufacturer shortcodes: [tigon_finance_denago], [tigon_finance_evolution], etc.
 */
function tigon_finance_register_manufacturer_shortcodes() {
    $manufacturers = tigon_finance_get_manufacturer_labels();
    $overrides     = tigon_finance_get_manufacturer_overrides();
    foreach ( $manufacturers as $slug => $label ) {
        add_shortcode( 'tigon_finance_' . $slug, function ( $atts ) use ( $slug, $overrides ) {
            $atts = is_array( $atts ) ? $atts : array();
            $atts['manufacturer'] = $slug;
            if ( isset( $overrides[ $slug ] ) ) {
                $atts = array_merge( $atts, $overrides[ $slug ] );
            }
            return tigon_finance_shortcode( $atts );
        } );
    }
}

/**
 * Per-manufacturer attribute overrides.
 */
function tigon_finance_get_manufacturer_overrides() {
    return array(
        'used' => array( 'best_fee' => '10' ),
    );
}
tigon_finance_register_manufacturer_shortcodes();
