<?php
/**
 * Plugin Name: TIGON Financing Calculator
 * Plugin URI:  https://tigongolfcarts.com
 * Description: The TIGON enterprise WordPress plugin that bridges ZERO Percent Financing Option with WooCommerce — automatically syncing inventory pricing with monthly payments using product data in real time.
 * Version:     2.4.0
 * Author:      Noah Jaslow & Jaslow Digital
 * Author URI:  https://jaslowdigital.com
 * License:     Proprietary
 * Text Domain: tigon-finance
 * Requires at least: 6.0
 * Requires PHP: 8.1
 * Requires Plugins: woocommerce
 *
 * All rights reserved. © TIGON Golf Carts.
 * Plugin Developer: Noah Jaslow © Jaslow Digital — jaslowdigital.com | PH: 215-789-1955
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'TIGON_FINANCE_VERSION', '2.4.0' );
define( 'TIGON_FINANCE_PATH', plugin_dir_path( __FILE__ ) );
define( 'TIGON_FINANCE_URL', plugin_dir_url( __FILE__ ) );

/**
 * Enqueue frontend assets.
 */
function tigon_finance_enqueue_assets() {
    wp_enqueue_style(
        'tigon-finance-style',
        TIGON_FINANCE_URL . 'assets/css/tigon-finance.css',
        array(),
        TIGON_FINANCE_VERSION
    );

    wp_enqueue_script(
        'tigon-finance-script',
        TIGON_FINANCE_URL . 'assets/js/tigon-finance.js',
        array(),
        TIGON_FINANCE_VERSION,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'tigon_finance_enqueue_assets' );

// Load shortcode (registers base + all manufacturer shortcodes).
require_once TIGON_FINANCE_PATH . 'includes/class-shortcode.php';

/**
 * Register all Elementor widgets when Elementor is active.
 */
function tigon_finance_register_elementor_widgets( $widgets_manager ) {
    require_once TIGON_FINANCE_PATH . 'includes/class-elementor-widget.php';

    // Base widget (generic, no manufacturer).
    $widgets_manager->register( new \Tigon_Finance_Elementor_Widget() );

    // Manufacturer-specific widgets.
    $widgets_manager->register( new \Tigon_Finance_Widget_Denago() );
    $widgets_manager->register( new \Tigon_Finance_Widget_Evolution() );
    $widgets_manager->register( new \Tigon_Finance_Widget_Teko() );
    $widgets_manager->register( new \Tigon_Finance_Widget_Tara() );
    $widgets_manager->register( new \Tigon_Finance_Widget_Atlas() );
    $widgets_manager->register( new \Tigon_Finance_Widget_Clubcar() );
    $widgets_manager->register( new \Tigon_Finance_Widget_Ezgo() );
    $widgets_manager->register( new \Tigon_Finance_Widget_Swiftev() );
    $widgets_manager->register( new \Tigon_Finance_Widget_Used() );
}
add_action( 'elementor/widgets/register', 'tigon_finance_register_elementor_widgets' );

// Register an Elementor widget category.
function tigon_finance_elementor_category( $elements_manager ) {
    $elements_manager->add_category( 'tigon-financing', [
        'title' => __( 'TIGON Financing', 'tigon-finance' ),
        'icon'  => 'fa fa-dollar-sign',
    ] );
}
add_action( 'elementor/elements/categories_registered', 'tigon_finance_elementor_category' );
