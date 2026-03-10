<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Shortcode: [tigon_finance-calculator]
 *
 * Optional attributes:
 *   price  – override the WooCommerce product price (useful outside single-product pages)
 *   label  – CTA button text (default "Apply for 0% Financing")
 *   url    – CTA button link (default "https://tigongolfcarts.com/apply-for-financing")
 */
function tigon_finance_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'price' => '',
        'label' => 'Apply for 0% Financing',
        'url'   => 'https://tigongolfcarts.com/apply-for-financing',
    ), $atts, 'tigon_finance-calculator' );

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

    $payment_60 = $price / 60;
    $payment_48 = $price / 48;
    $payment_36 = $price / 36;

    $currency_symbol = function_exists( 'get_woocommerce_currency_symbol' )
        ? get_woocommerce_currency_symbol()
        : '$';

    $apply_url = esc_url( $atts['url'] );

    ob_start();
    ?>
    <div class="tigon-finance-box" data-price="<?php echo esc_attr( $price ); ?>" data-apply-url="<?php echo $apply_url; ?>">
        <a href="<?php echo $apply_url; ?>" target="_blank" rel="noopener noreferrer" class="tigon-finance-box-link" aria-label="Apply for 0% financing">
        <div class="tigon-finance-header">
            <span class="tigon-finance-header-icon">&#9733;</span>
            <span class="tigon-finance-header-text">0% Financing Available</span>
        </div>

        <div class="tigon-finance-tabs">
            <button class="tigon-finance-tab active" data-months="60" type="button">60 Months</button>
            <button class="tigon-finance-tab" data-months="48" type="button">48 Months</button>
            <button class="tigon-finance-tab" data-months="36" type="button">36 Months</button>
        </div>

        <div class="tigon-finance-panels">
            <div class="tigon-finance-panel active" data-months="60">
                <p class="tigon-finance-as-low">As low as</p>
                <p class="tigon-finance-amount">
                    <span class="tigon-finance-currency"><?php echo esc_html( $currency_symbol ); ?></span>
                    <span class="tigon-finance-value"><?php echo esc_html( number_format( $payment_60, 2 ) ); ?></span>
                    <span class="tigon-finance-per">/mo</span>
                </p>
                <p class="tigon-finance-details">for 60 months &bull; 0% APR &bull; <?php echo esc_html( $currency_symbol . number_format( $price, 2 ) ); ?> total</p>
            </div>

            <div class="tigon-finance-panel" data-months="48">
                <p class="tigon-finance-as-low">As low as</p>
                <p class="tigon-finance-amount">
                    <span class="tigon-finance-currency"><?php echo esc_html( $currency_symbol ); ?></span>
                    <span class="tigon-finance-value"><?php echo esc_html( number_format( $payment_48, 2 ) ); ?></span>
                    <span class="tigon-finance-per">/mo</span>
                </p>
                <p class="tigon-finance-details">for 48 months &bull; 0% APR &bull; <?php echo esc_html( $currency_symbol . number_format( $price, 2 ) ); ?> total</p>
            </div>

            <div class="tigon-finance-panel" data-months="36">
                <p class="tigon-finance-as-low">As low as</p>
                <p class="tigon-finance-amount">
                    <span class="tigon-finance-currency"><?php echo esc_html( $currency_symbol ); ?></span>
                    <span class="tigon-finance-value"><?php echo esc_html( number_format( $payment_36, 2 ) ); ?></span>
                    <span class="tigon-finance-per">/mo</span>
                </p>
                <p class="tigon-finance-details">for 36 months &bull; 0% APR &bull; <?php echo esc_html( $currency_symbol . number_format( $price, 2 ) ); ?> total</p>
            </div>
        </div>

        <span class="tigon-finance-cta">
            <?php echo esc_html( $atts['label'] ); ?>
        </span>
        </a>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'tigon_finance-calculator', 'tigon_finance_shortcode' );
