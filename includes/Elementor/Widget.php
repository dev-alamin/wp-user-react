<?php
namespace AA\WPUserReactionButton\Elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Widget extends Widget_Base {

    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
        
        // Enqueue the Elementor icon library
        wp_enqueue_style( 'elementor-icons' );
        wp_enqueue_style( 'font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css' );

    }

    public function get_name() {
        return 'wp-user-reaction-button';
    }

    public function get_title() {
        return 'Reaction Button';
    }

    public function get_icon() {
        return 'eicon-comments';
    }

    public function get_categories() {
        return [ 'general' ];
    }
    protected function _register_controls() {
        $this->start_controls_section(
            'settings',
            [
                'label' => __( 'Settings', 'wp-user-reaction-button' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
    
        $this->add_control(
            'icon_size',
            [
                'label' => __( 'Icon Size', 'wp-user-reaction-button' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 24,
                ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .your-icon-class' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    
        $this->add_control(
            'icon_color',
            [
                'label' => __( 'Icon Color', 'wp-user-reaction-button' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .your-icon-class' => 'color: {{VALUE}};',
                ],
            ]
        );
    
        $this->end_controls_section();
    }
    

    protected function render() {
        $html = new \AA\WPUserReactionButton\Frontend\Reaction();

        echo $html->icon_html();
    }
}
