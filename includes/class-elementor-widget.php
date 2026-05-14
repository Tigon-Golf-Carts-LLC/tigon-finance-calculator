<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Base TIGON Finance Elementor widget.
 * Manufacturer-specific widgets extend this class.
 */
class Tigon_Finance_Elementor_Widget extends \Elementor\Widget_Base {

    protected $manufacturer_slug = '';
    protected $manufacturer_label = '';

    public function get_name() {
        if ( $this->manufacturer_slug ) {
            return 'tigon_finance_' . $this->manufacturer_slug;
        }
        return 'tigon_finance_calculator';
    }

    public function get_title() {
        if ( $this->manufacturer_label ) {
            return __( $this->manufacturer_label . ' Financing', 'tigon-finance' );
        }
        return __( 'TIGON Financing Calculator', 'tigon-finance' );
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return [ 'tigon-financing', 'woocommerce-elements' ];
    }

    public function get_keywords() {
        $keywords = [ 'finance', 'payment', 'woocommerce', 'monthly', 'tigon' ];
        if ( $this->manufacturer_label ) {
            $keywords[] = strtolower( $this->manufacturer_label );
        }
        return $keywords;
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
            'default' => 'Apply for Financing',
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

        /* --------------------------------------------------------
         * STYLE TAB – Box
         * ------------------------------------------------------ */
        $this->start_controls_section( 'style_box', [
            'label' => __( 'Box', 'tigon-finance' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'box_border_color', [
            'label'     => __( 'Border Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-box' => 'border-color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'box_bg_color', [
            'label'     => __( 'Background Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-box' => 'background: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'box_border_radius', [
            'label'      => __( 'Border Radius', 'tigon-finance' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .tigon-finance-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
            ],
        ] );

        $this->add_responsive_control( 'box_padding', [
            'label'      => __( 'Padding', 'tigon-finance' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'selectors'  => [
                '{{WRAPPER}} .tigon-finance-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();

        /* --------------------------------------------------------
         * STYLE TAB – Header
         * ------------------------------------------------------ */
        $this->start_controls_section( 'style_header', [
            'label' => __( 'Header', 'tigon-finance' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'header_bg_color', [
            'label'     => __( 'Background Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-header' => 'background: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'header_text_color', [
            'label'     => __( 'Text Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-header' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'header_typography',
            'selector' => '{{WRAPPER}} .tigon-finance-header',
        ] );

        $this->end_controls_section();

        /* --------------------------------------------------------
         * STYLE TAB – Tabs
         * ------------------------------------------------------ */
        $this->start_controls_section( 'style_tabs', [
            'label' => __( 'Tabs', 'tigon-finance' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'tabs_bg_color', [
            'label'     => __( 'Background Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-tabs' => 'background: {{VALUE}};',
                '{{WRAPPER}} .tigon-finance-tab:not(.active)' => 'background: {{VALUE}} !important;',
            ],
        ] );

        $this->add_control( 'tabs_text_color', [
            'label'     => __( 'Text Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-tab' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'tabs_active_bg_color', [
            'label'     => __( 'Active Tab Background', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-tab.active' => 'background: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'tabs_active_border_color', [
            'label'     => __( 'Active Tab Border Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-tab.active' => 'border-bottom-color: {{VALUE}};',
                '{{WRAPPER}} .tigon-finance-tabs'       => 'border-bottom-color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'tabs_typography',
            'selector' => '{{WRAPPER}} .tigon-finance-tab',
        ] );

        $this->end_controls_section();

        /* --------------------------------------------------------
         * STYLE TAB – Price Display
         * ------------------------------------------------------ */
        $this->start_controls_section( 'style_price', [
            'label' => __( 'Price', 'tigon-finance' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'price_color', [
            'label'     => __( 'Price Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-amount' => 'color: {{VALUE}};',
                '{{WRAPPER}} .tigon-finance-per'    => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'label_color', [
            'label'     => __( 'Label Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-as-low'   => 'color: {{VALUE}};',
                '{{WRAPPER}} .tigon-finance-details'  => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'price_size', [
            'label'      => __( 'Price Font Size', 'tigon-finance' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 24, 'max' => 80 ] ],
            'selectors'  => [
                '{{WRAPPER}} .tigon-finance-value' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();

        /* --------------------------------------------------------
         * STYLE TAB – CTA Button
         * ------------------------------------------------------ */
        $this->start_controls_section( 'style_cta', [
            'label' => __( 'CTA Button', 'tigon-finance' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'cta_bg_color', [
            'label'     => __( 'Background Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-cta' => 'background: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'cta_text_color', [
            'label'     => __( 'Text Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-cta' => 'color: {{VALUE}} !important;',
            ],
        ] );

        $this->add_responsive_control( 'cta_border_radius', [
            'label'      => __( 'Border Radius', 'tigon-finance' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .tigon-finance-cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'cta_padding', [
            'label'      => __( 'Padding', 'tigon-finance' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'selectors'  => [
                '{{WRAPPER}} .tigon-finance-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'cta_typography',
            'selector' => '{{WRAPPER}} .tigon-finance-cta',
        ] );

        $this->end_controls_section();

        /* --------------------------------------------------------
         * STYLE TAB – Disclaimer
         * ------------------------------------------------------ */
        $this->start_controls_section( 'style_disclaimer', [
            'label' => __( 'Disclaimer', 'tigon-finance' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'disclaimer_text_color', [
            'label'     => __( 'Text Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-disclaimer' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'disclaimer_bg_color', [
            'label'     => __( 'Background Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-disclaimer' => 'background: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'disclaimer_typography',
            'selector' => '{{WRAPPER}} .tigon-finance-disclaimer',
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

        if ( $this->manufacturer_slug ) {
            $shortcode_atts .= ' manufacturer="' . esc_attr( $this->manufacturer_slug ) . '"';
        }

        echo do_shortcode( '[tigon_finance_calculator' . $shortcode_atts . ']' );
    }
}

/*
 * Manufacturer-specific Elementor widgets.
 * Each extends the base widget with a unique slug and display label.
 */

class Tigon_Finance_Widget_Denago extends Tigon_Finance_Elementor_Widget {
    protected $manufacturer_slug  = 'denago';
    protected $manufacturer_label = 'Denago';
}

class Tigon_Finance_Widget_Evolution extends Tigon_Finance_Elementor_Widget {
    protected $manufacturer_slug  = 'evolution';
    protected $manufacturer_label = 'Evolution';
}

class Tigon_Finance_Widget_Teko extends Tigon_Finance_Elementor_Widget {
    protected $manufacturer_slug  = 'teko';
    protected $manufacturer_label = 'TEKO';
}

class Tigon_Finance_Widget_Tara extends Tigon_Finance_Elementor_Widget {
    protected $manufacturer_slug  = 'tara';
    protected $manufacturer_label = 'TARA';
}

class Tigon_Finance_Widget_Atlas extends Tigon_Finance_Elementor_Widget {
    protected $manufacturer_slug  = 'atlas';
    protected $manufacturer_label = 'Atlas';
}

class Tigon_Finance_Widget_Clubcar extends Tigon_Finance_Elementor_Widget {
    protected $manufacturer_slug  = 'clubcar';
    protected $manufacturer_label = 'Club Car';
}

class Tigon_Finance_Widget_Ezgo extends Tigon_Finance_Elementor_Widget {
    protected $manufacturer_slug  = 'ezgo';
    protected $manufacturer_label = 'E-Z-GO';
}

class Tigon_Finance_Widget_Swiftev extends Tigon_Finance_Elementor_Widget {
    protected $manufacturer_slug  = 'swiftev';
    protected $manufacturer_label = 'Swift EV';
}

class Tigon_Finance_Widget_Used extends Tigon_Finance_Elementor_Widget {
    protected $manufacturer_slug  = 'used';
    protected $manufacturer_label = 'Used';
}

/**
 * User Financing Calculator – visitor enters their own price & picks a term.
 */
class Tigon_Finance_User_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'tigon_user_finance_calculator';
    }

    public function get_title() {
        return __( 'User Financing Calculator', 'tigon-finance' );
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return [ 'tigon-financing', 'woocommerce-elements' ];
    }

    public function get_keywords() {
        return [ 'finance', 'payment', 'monthly', 'tigon', 'user', 'calculator' ];
    }

    protected function register_controls() {

        $this->start_controls_section( 'content_section', [
            'label' => __( 'User Finance Calculator', 'tigon-finance' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'default_price', [
            'label'       => __( 'Default Price', 'tigon-finance' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => '',
            'description' => __( 'Optional starting value for the price input.', 'tigon-finance' ),
        ] );

        $this->add_control( 'default_term', [
            'label'   => __( 'Default Term', 'tigon-finance' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 60,
            'options' => [
                12 => '12 months (1 year)',
                24 => '24 months (2 years)',
                36 => '36 months (3 years)',
                48 => '48 months (4 years)',
                60 => '60 months (5 years)',
                72 => '72 months (6 years)',
                84 => '84 months (7 years)',
            ],
        ] );

        $this->add_control( 'annual_rate', [
            'label'       => __( 'Annual Rate (APR %)', 'tigon-finance' ),
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'min'         => 0,
            'step'        => 0.01,
            'default'     => 7.99,
        ] );

        $this->add_control( 'cta_label', [
            'label'   => __( 'CTA Button Text', 'tigon-finance' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Apply for Financing',
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

        /* Style sections — reuse the same selectors as the base widget. */
        $this->start_controls_section( 'style_box', [
            'label' => __( 'Box', 'tigon-finance' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'box_border_color', [
            'label'     => __( 'Border Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-box' => 'border-color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'box_bg_color', [
            'label'     => __( 'Background Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-box' => 'background: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'box_border_radius', [
            'label'      => __( 'Border Radius', 'tigon-finance' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .tigon-finance-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
            ],
        ] );

        $this->add_responsive_control( 'box_padding', [
            'label'      => __( 'Padding', 'tigon-finance' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'selectors'  => [
                '{{WRAPPER}} .tigon-finance-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'style_header', [
            'label' => __( 'Header', 'tigon-finance' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'header_bg_color', [
            'label'     => __( 'Background Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-header' => 'background: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'header_text_color', [
            'label'     => __( 'Text Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-header' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'header_typography',
            'selector' => '{{WRAPPER}} .tigon-finance-header',
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'style_price', [
            'label' => __( 'Price', 'tigon-finance' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'price_color', [
            'label'     => __( 'Price Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-amount' => 'color: {{VALUE}};',
                '{{WRAPPER}} .tigon-finance-per'    => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'label_color', [
            'label'     => __( 'Label Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-as-low'   => 'color: {{VALUE}};',
                '{{WRAPPER}} .tigon-finance-details'  => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'price_size', [
            'label'      => __( 'Price Font Size', 'tigon-finance' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 24, 'max' => 80 ] ],
            'selectors'  => [
                '{{WRAPPER}} .tigon-finance-value' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'style_cta', [
            'label' => __( 'CTA Button', 'tigon-finance' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'cta_bg_color', [
            'label'     => __( 'Background Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-cta' => 'background: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'cta_text_color', [
            'label'     => __( 'Text Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-cta' => 'color: {{VALUE}} !important;',
            ],
        ] );

        $this->add_responsive_control( 'cta_border_radius', [
            'label'      => __( 'Border Radius', 'tigon-finance' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
                '{{WRAPPER}} .tigon-finance-cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'cta_padding', [
            'label'      => __( 'Padding', 'tigon-finance' ),
            'type'       => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em' ],
            'selectors'  => [
                '{{WRAPPER}} .tigon-finance-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'cta_typography',
            'selector' => '{{WRAPPER}} .tigon-finance-cta',
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'style_disclaimer', [
            'label' => __( 'Disclaimer', 'tigon-finance' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'disclaimer_text_color', [
            'label'     => __( 'Text Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-disclaimer' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'disclaimer_bg_color', [
            'label'     => __( 'Background Color', 'tigon-finance' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .tigon-finance-disclaimer' => 'background: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
            'name'     => 'disclaimer_typography',
            'selector' => '{{WRAPPER}} .tigon-finance-disclaimer',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $shortcode_atts = '';

        if ( ! empty( $settings['default_price'] ) ) {
            $shortcode_atts .= ' price="' . esc_attr( $settings['default_price'] ) . '"';
        }

        if ( ! empty( $settings['default_term'] ) ) {
            $shortcode_atts .= ' term="' . esc_attr( $settings['default_term'] ) . '"';
        }

        if ( isset( $settings['annual_rate'] ) && '' !== $settings['annual_rate'] ) {
            $shortcode_atts .= ' annual_rate="' . esc_attr( $settings['annual_rate'] ) . '"';
        }

        if ( ! empty( $settings['cta_label'] ) ) {
            $shortcode_atts .= ' label="' . esc_attr( $settings['cta_label'] ) . '"';
        }

        if ( ! empty( $settings['cta_url']['url'] ) ) {
            $shortcode_atts .= ' url="' . esc_attr( $settings['cta_url']['url'] ) . '"';
        }

        echo do_shortcode( '[tigon_user_finance_calculator' . $shortcode_atts . ']' );
    }
}
