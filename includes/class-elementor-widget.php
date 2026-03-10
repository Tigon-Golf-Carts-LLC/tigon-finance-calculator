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
            return __( 'TIGON Finance — ' . $this->manufacturer_label, 'tigon-finance' );
        }
        return __( 'TIGON Finance Calculator', 'tigon-finance' );
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
