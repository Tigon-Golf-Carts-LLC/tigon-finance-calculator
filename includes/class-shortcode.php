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
        <a href="<?php echo $apply_url; ?>" target="_blank" rel="noopener noreferrer" class="tigon-finance-box-link" aria-label="Apply for financing">
        <div class="tigon-finance-header">
            <span class="tigon-finance-header-icon">&#9733;</span>
            <span class="tigon-finance-header-text">
                <?php if ( $mfr_display ) : ?>
                    <?php echo esc_html( $mfr_display ); ?> — Financing Available
                <?php else : ?>
                    Financing Available
                <?php endif; ?>
            </span>
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
                <p class="tigon-finance-details">for <?php echo $num_payments_low; ?> months &bull; <?php echo esc_html( $annual_rate ); ?>% APR &bull; <?php echo esc_html( $currency_symbol . number_format( $lowest_total, 2 ) ); ?> total</p>
            </div>

            <div class="tigon-finance-panel" data-tab="best">
                <p class="tigon-finance-as-low">Best Deal</p>
                <p class="tigon-finance-amount">
                    <span class="tigon-finance-currency"><?php echo esc_html( $currency_symbol ); ?></span>
                    <span class="tigon-finance-value"><?php echo esc_html( number_format( $best_payment, 2 ) ); ?></span>
                    <span class="tigon-finance-per">/mo</span>
                </p>
                <p class="tigon-finance-details">for <?php echo $num_payments_best; ?> months &bull; 0% APR + <?php echo esc_html( $fee_rate ); ?>% fee &bull; <?php echo esc_html( $currency_symbol . number_format( $best_total, 2 ) ); ?> total</p>
            </div>
        </div>

        <span class="tigon-finance-cta">
            <?php echo esc_html( $atts['label'] ); ?>
        </span>
        <?php if ( 'used' === $manufacturer ) : ?>
            <p class="tigon-finance-disclaimer tigon-finance-disclaimer-used">* 0% financing is only available on vehicles 2016 or newer.</p>
        <?php endif; ?>
        <p class="tigon-finance-disclaimer"><strong>Promo rates available as low as 0% up to 48 Months.</strong> All Financing options are subject to credit approval. Terms, Rates, and Conditions may vary based on the Applicant's credit profile, and lender requirements. Additional fees may apply.</p>
        </a>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'tigon_finance_calculator', 'tigon_finance_shortcode' );

// Keep legacy shortcode working.
add_shortcode( 'tigon_finance-calculator', 'tigon_finance_shortcode' );

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
