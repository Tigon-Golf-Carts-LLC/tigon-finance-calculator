<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Tigon_Finance_Elementor_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'tigon_finance_calculator';
    }

    public function get_title() {
        return __( 'TIGON 0% Finance Calculator', 'tigon-finance' );
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return [ 'tigon-financing', 'woocommerce-elements' ];
    }

    public function get_keywords() {
        return [ 'finance', 'payment', 'woocommerce', 'monthly', '0%', 'tigon' ];
    }

    protected function register_controls() {

        $this->start_controls_section( 'content_section', [
            'label' => __( 'Finance Calculator', 'tigon-finance' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'custom_price', [
            'label'       => __( 'Custom Price Override', 'tigon-finance' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => '',
            'description' => __( 'Leave blank to use the WooCommerce product price automatically.', 'tigon-finance' ),
        ] );

        $this->add_control( 'cta_label', [
            'label'   => __( 'CTA Button Text', 'tigon-finance' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Apply for 0% Financing',
        ] );

        $this->add_control( 'cta_url', [
            'label'   => __( 'CTA Button URL', 'tigon-finance' ),
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [
                'url'         => 'https://tigongolfcarts.com/apply-for-financing',
                'is_external' => true,
                'nofollow'    => false,
            ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $shortcode_atts = '';

        if ( ! empty( $settings['custom_price'] ) ) {
            $shortcode_atts .= ' price="' . esc_attr( $settings['custom_price'] ) . '"';
        }

        if ( ! empty( $settings['cta_label'] ) ) {
            $shortcode_atts .= ' label="' . esc_attr( $settings['cta_label'] ) . '"';
        }

        if ( ! empty( $settings['cta_url']['url'] ) ) {
            $shortcode_atts .= ' url="' . esc_attr( $settings['cta_url']['url'] ) . '"';
        }

        echo do_shortcode( '[tigon_finance-calculator' . $shortcode_atts . ']' );
    }
}
