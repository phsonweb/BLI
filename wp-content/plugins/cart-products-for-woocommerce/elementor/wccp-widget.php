<?php

namespace Elementor;

use ElementorPro\Modules\QueryControl\Controls\Group_Control_Posts;
use ElementorPro\Modules\QueryControl\Module;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WCCP_Shortcode_Widget extends Widget_Base {

    public function get_name() {
        return 'wccp-shortcode-widget';
    }
    
    public function get_title() {
        return __( 'Cart Products', 'wccp' );
    }

    public function get_icon() {
        return 'eicon-product-add-to-cart';
    }
    public function get_categories() {
        return [ 'wccp-addons' ];
    }
    public function get_script_depends() {
        return [];
    }

    public function get_keywords() {
        return [ 'cart', 'checkout', 'item', 'loop', 'list', 'products', 'quick' ];
    }


    public function get_query() {
        return $this->_query;
    }

    protected function _register_controls() {
        $this->register_query_section_controls();
    }

    private function register_query_section_controls() {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => __( 'Parameters', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );


            // $this->add_control(
            //     'per_page',
            //     [
            //         'label' => __( 'Products Per Page', 'elementor-pro' ),
            //         'type' => Controls_Manager::NUMBER,
            //         'default' => 6,
            //     ]
            // );



            $this->add_control(
                'wccp_show_table_footer',
                [
                    'label' => __( 'Show table footer', 'elementor-pro' ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'label_off' => __( 'No', 'elementor-pro' ),
                    'label_on' => __( 'Yes', 'elementor-pro' ),
                ]
            );
            $this->add_control(
                'wccp_show_footer_total',
                [
                    'label' => __( 'Footer "Total price"', 'elementor-pro' ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'label_off' => __( 'No', 'elementor-pro' ),
                    'label_on' => __( 'Yes', 'elementor-pro' ),
                    'condition' => [
                        'wccp_show_table_footer' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'wccp_show_table_thumb',
                [
                    'label' => __( 'Show Thumbnails', 'elementor-pro' ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'label_off' => __( 'No', 'elementor-pro' ),
                    'label_on' => __( 'Yes', 'elementor-pro' ),
                ]
            );
            /*
            'condition' => [
                'wccp_type' => 'bycategory',
            ],
            */


            $this->add_control(
                'wccp_type',
                [
                    'label' => __( 'Type', 'elementor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'default' => 'Default',
                        'bycategory' => 'By Categories',
                    ],
                    'default' => 'default'
                ]
            );

            $repeater = new \Elementor\Repeater();

            $repeater->add_control(
                'wccp_category',
                [
                    'label' => __( 'Category', 'elementor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    //'multiple' => true,
                    'options' => $this->get_terms(),
                    'default' => ''
                ]
            );

            $this->add_control(
                'wccp_categories',
                [
                    'separator' => 'before',
                    'label' => __( 'Categories', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [],
                    'title_field' => '{{{ wccp_category }}}',
                ]
            );

            $this->add_control(
                'wccp-affiliate-ad',
                [
                    'label' => __( 'Check this out!', 'plugin-name' ),
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => '<br><a href="https://www.cloudways.com/en/wordpress-cloud-hosting.php?id=151244&amp;a_bid=08e2b8f4" target="_top"><img src="//www.cloudways.com/affiliate/accounts/default1/banners/08e2b8f4.jpg" alt="Load WordPress Sites in as fast as 37ms!" title="Load WordPress Sites in as fast as 37ms!" width="300" height="600" /></a><img style="border:0" src="https://www.cloudways.com/affiliate/scripts/imp.php?id=151244&amp;a_bid=08e2b8f4" width="1" height="1" alt="" />',
                ]
            );



        $this->end_controls_section();

        
        /*
        Style
        */

        $this->start_controls_section(
            'section_design_layout',
            [
                'label' => __( 'Style', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


            /* Category name */
            $this->add_control(
                'wccp_cat_headings_heading',
                [
                    'label' => __( 'Category', 'plugin-name' ),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'condition' => [
                        'wccp_type' => 'bycategory',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'wccp_cat_headings',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .wccp-category-heading',
                    'condition' => [
                        'wccp_type' => 'bycategory',
                    ],
                    
                ]
            );
            $this->add_control(
                'wccp_cat_headings_color',
                [
                    'label' => __( 'Color', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => \Elementor\Scheme_Color::get_type(),
                        'value' => \Elementor\Scheme_Color::COLOR_1,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .wccp-category-heading' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'wccp_type' => 'bycategory',
                    ],
                ]
            );
            $this->add_control(
                'wccp_heading_gap',
                [
                    'label' => __( 'Heading Bottom Gap', 'elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'selectors' => [
                        '{{WRAPPER}} .wccp-category-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'frontend_available' => true,
                    'classes' => '',
                    'condition' => [
                        'wccp_type' => 'bycategory',
                    ],
                ]
            );
            $this->add_control(
                'wccp_wrap_gap',
                [
                    'label' => __( 'Category List Gap', 'elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'selectors' => [
                        '{{WRAPPER}} .wccp-product-list' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 150,
                            'step' => 5,
                        ],
                    ],
                    'frontend_available' => true,
                    'classes' => '',
                    'condition' => [
                        'wccp_type' => 'bycategory',
                    ],
                ]
            );


            /* Table */
            $this->add_control(
                'wccp_table_heading',
                [
                    'label' => __( 'Table', 'plugin-name' ),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_control(
                'wccp_table_background',
                [
                    'label' => __( 'Background', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => \Elementor\Scheme_Color::get_type(),
                        'value' => \Elementor\Scheme_Color::COLOR_1,
                    ],
                    'default' => '#fff',
                    'selectors' => [
                        '{{WRAPPER}} table.shop_table' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'wccp_table_border_style',
                [
                    'label' => __( 'Border Style', 'elementor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    //'multiple' => true,
                    'options' => [
                        'none' => 'None',
                        'solid' => 'Solid line',
                        'dotted' => 'Series of dots',
                        'dashed' => 'Series of dashes',
                        'double' => 'Two solid lines',
                        'groove' => 'Groove',
                        'ridge' => 'Ridge',
                        'inset' => 'Inset',
                        'outset' => 'Uutset'
                    ],
                    'default' => 'solid',
                    'selectors' => [
                        '{{WRAPPER}} table.shop_table' => 'border-style: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'wccp_table_border_color',
                [
                    'label' => __( 'Border Color', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => \Elementor\Scheme_Color::get_type(),
                        'value' => \Elementor\Scheme_Color::COLOR_1,
                    ],
                    'default' => '#f2f2f2',
                    'selectors' => [
                        '{{WRAPPER}} table.shop_table' => 'border-color: {{VALUE}}',
                        '{{WRAPPER}} table.shop_table td' => 'border-color: {{VALUE}}'
                    ],
                ]
            );
            $this->add_control(
                'wccp_table_border_width',
                [
                    'label' => __( 'Border Width', 'elementor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px' ],
                    'selectors' => [
                        '{{WRAPPER}} table.shop_table' => 'border-top-width: {{TOP}}{{UNIT}};border-right-width: {{RIGHT}}{{UNIT}}; border-bottom-width: {{BOTTOM}}{{UNIT}}; border-left-width: {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_control(
                'wccp_table_border_radius',
                [
                    'label' => __( 'Border Radius', 'elementor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px' ],
                    'selectors' => [
                        '{{WRAPPER}} table.shop_table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );



            /* Cell heading */
            $this->add_control(
                'wccp_table_headings_heading',
                [
                    'label' => __( 'Table heading', 'plugin-name' ),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'wccp_headings_cell',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .shop_table th',
                ]
            );
            $this->add_control(
                'wccp_headings_cell_text',
                [
                    'label' => __( 'Color', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => \Elementor\Scheme_Color::get_type(),
                        'value' => \Elementor\Scheme_Color::COLOR_1,
                    ],
                    'default' => '#000',
                    'selectors' => [
                        '{{WRAPPER}} .shop_table th' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'wccp_headings_cell_background',
                [
                    'label' => __( 'Background', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => \Elementor\Scheme_Color::get_type(),
                        'value' => \Elementor\Scheme_Color::COLOR_1,
                    ],
                    'default' => '#fff',
                    'selectors' => [
                        '{{WRAPPER}} .shop_table th' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'wccp_heading_cell_padding',
                [
                    'label' => __( 'Cell Padding', 'elementor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px' ],
                    'default' => [
                        'top' => 9,
                        'right' => 12,
                        'bottom' => 9,
                        'left' => 12,
                        'isLinked' => false
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );


            /* Cell  */
            $this->add_control(
                'wccp_table_cell_heading',
                [
                    'label' => __( 'Table cell', 'plugin-name' ),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'wccp_table_cell',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .shop_table td',
                ]
            );
            $this->add_control(
                'wccp_table_cell_border_style',
                [
                    'label' => __( 'Border Style', 'elementor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    //'multiple' => true,
                    'options' => [
                        'none' => 'None',
                        'solid' => 'Solid line',
                        'dotted' => 'Series of dots',
                        'dashed' => 'Series of dashes',
                        'double' => 'Two solid lines',
                        'groove' => 'Groove',
                        'ridge' => 'Ridge',
                        'inset' => 'Inset',
                        'outset' => 'Uutset'
                    ],
                    'default' => 'solid',
                    'selectors' => [
                        '{{WRAPPER}} table.shop_table td' => 'border-style: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'wccp_table_cell_border_color',
                [
                    'label' => __( 'Border Color', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => \Elementor\Scheme_Color::get_type(),
                        'value' => \Elementor\Scheme_Color::COLOR_1,
                    ],
                    'default' => '#f2f2f2',
                    'selectors' => [
                        '{{WRAPPER}} table.shop_table td' => 'border-color: {{VALUE}}'
                    ],
                ]
            );
            $this->add_control(
                'wccp_table_cell_border_width',
                [
                    'label' => __( 'Border Width', 'elementor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px' ],
                    'selectors' => [
                        '{{WRAPPER}} table.shop_table td' => 'border-top-width: {{TOP}}{{UNIT}};border-right-width: {{RIGHT}}{{UNIT}}; border-bottom-width: {{BOTTOM}}{{UNIT}}; border-left-width: {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_control(
                'wccp_cell_padding',
                [
                    'label' => __( 'Cell Padding', 'elementor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px' ],
                    'default' => [
                        'top' => 9,
                        'right' => 12,
                        'bottom' => 9,
                        'left' => 12,
                        'isLinked' => false
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );


            /* Thumbnail */
            $this->add_control(
                'wccp_thumb_size',
                [
                    'label' => __( 'Thumbnail size', 'elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'selectors' => [
                        '{{WRAPPER}} .product-thumbnail img' => 'max-width: {{SIZE}}{{UNIT}};',
                    ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 300,
                            'step' => 5,
                        ],
                    ],
                    'frontend_available' => true,
                    'classes' => '',
                ]
            );

            /* Cell Price */
            $this->add_control(
                'wccp_price_heading',
                [
                    'label' => __( 'Price', 'plugin-name' ),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    //'separator' => 'before',
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'wccp_cell_price',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} td.product-price',
                    
                ]
            );

            /* Cell Quantity */
            $this->add_control(
                'wccp_quantity_heading',
                [
                    'label' => __( 'Quantity', 'plugin-name' ),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    //'separator' => 'before',
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'wccp_cell_quantity',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} td.product-quantity .quantity .qty',
                    
                ]
            );
            $this->add_control(
                'wccp_cell_quantity_icons',
                [
                    'label' => __( 'Quantity "+ -" size', 'elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'selectors' => [
                        '{{WRAPPER}} .wccp-qty .wccp-qty-plus svg, .wccp-qty .wccp-qty-minus svg' => 'width: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .wccp-qty .wccp-qty-plus svg, .wccp-qty .wccp-qty-minus svg' => 'height: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} td.product-quantity .quantity .qty' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'frontend_available' => true,
                ]
            );




            /* Table footer */
            $this->add_control(
                'wccp_table_footer_heading',
                [
                    'label' => __( 'Footer', 'plugin-name' ),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'wccp_footer_text',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .wccp_cart_footer',
                    
                ]
            );
            $this->add_control(
                'wccp_table_footer_gap',
                [
                    'label' => __( 'Footer Top Margin', 'elementor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'selectors' => [
                        '{{WRAPPER}} .wccp_cart_footer' => 'margin-top: {{SIZE}}{{UNIT}};',
                    ],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'frontend_available' => true,
                    'classes' => '',
                    'condition' => [
                        'wccp_show_table_footer' => 'yes',
                    ],
                ]
            );
            $this->add_control(
                'wccp_footer_cell_text',
                [
                    'label' => __( 'Color', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => \Elementor\Scheme_Color::get_type(),
                        'value' => \Elementor\Scheme_Color::COLOR_1,
                    ],
                    'default' => '#000',
                    'selectors' => [
                        '{{WRAPPER}} .wccp_cart_footer td' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'wccp_footer_background',
                [
                    'label' => __( 'Background', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => \Elementor\Scheme_Color::get_type(),
                        'value' => \Elementor\Scheme_Color::COLOR_1,
                    ],
                    'default' => '#fff',
                    'selectors' => [
                        '{{WRAPPER}} table.shop_table.wccp_cart_footer' => 'background-color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'wccp_table_footer_border_style',
                [
                    'label' => __( 'Border Style', 'elementor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    //'multiple' => true,
                    'options' => [
                        'none' => 'None',
                        'solid' => 'Solid line',
                        'dotted' => 'Series of dots',
                        'dashed' => 'Series of dashes',
                        'double' => 'Two solid lines',
                        'groove' => 'Groove',
                        'ridge' => 'Ridge',
                        'inset' => 'Inset',
                        'outset' => 'Uutset'
                    ],
                    'default' => 'solid',
                    'selectors' => [
                        '{{WRAPPER}} table.shop_table.wccp_cart_footer' => 'border-style: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'wccp_footer_border_color',
                [
                    'label' => __( 'Border Color', 'plugin-domain' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => \Elementor\Scheme_Color::get_type(),
                        'value' => \Elementor\Scheme_Color::COLOR_1,
                    ],
                    'default' => '#f2f2f2',
                    'selectors' => [
                        '{{WRAPPER}} table.wccp_cart_footer' => 'border-color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_control(
                'wccp_table_footer_border_width',
                [
                    'label' => __( 'Border Width', 'elementor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px' ],
                    'selectors' => [
                        '{{WRAPPER}} table.shop_table.wccp_cart_footer' => 'border-top-width: {{TOP}}{{UNIT}};border-right-width: {{RIGHT}}{{UNIT}}; border-bottom-width: {{BOTTOM}}{{UNIT}}; border-left-width: {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_control(
                'wccp_footer_padding',
                [
                    'label' => __( 'Cell Padding', 'elementor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px' ],
                    'default' => [
                        'top' => 9,
                        'right' => 12,
                        'bottom' => 9,
                        'left' => 12,
                        'isLinked' => false
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .wccp_cart_footer td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );



            $this->add_control(
                'wccp-affiliate-ad-2',
                [
                    'label' => __( 'Check this out!', 'plugin-name' ),
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => '<br><a href="https://www.cloudways.com/en/wordpress-cloud-hosting.php?id=151244&amp;a_bid=08e2b8f4" target="_top"><img src="//www.cloudways.com/affiliate/accounts/default1/banners/08e2b8f4.jpg" alt="Load WordPress Sites in as fast as 37ms!" title="Load WordPress Sites in as fast as 37ms!" width="300" height="600" /></a><img style="border:0" src="https://www.cloudways.com/affiliate/scripts/imp.php?id=151244&amp;a_bid=08e2b8f4" width="1" height="1" alt="" />',
                ]
            );

        $this->end_controls_section();

    }

    public function get_terms() {
        $terms = get_terms( 'product_cat', 'orderby=count&hide_empty=0' );
        $list  = array( ' ' => __('All Categories', 'backpack-addon' ) ) ;
        foreach ( $terms as $key => $value ) {
            $list[$value->slug] = $value->name;
        }

        return $list;
    }

    public function query_posts() {
        $query_args = Module::get_query_args( 'posts', $this->get_settings() );

        $query_args['posts_per_page'] = $this->get_settings( 'posts_per_page' );

        $query_args['post_type'] = $this->get_settings( 'custom_post_type' );
        

        // print_r('<pre>');
        // print_r($query_args);
        // print_r('</pre>');

        $query_id = $this->get_settings( 'posts_query_id' );
        if ( ! empty( $query_id ) ) {
            add_action( 'pre_get_posts', [ $this, 'pre_get_posts_filter' ] );
            $this->_query = new \WP_Query( $query_args );
            remove_action( 'pre_get_posts', [ $this, 'pre_get_posts_filter' ] );
        } else {
            $this->_query = new \WP_Query( $query_args );
        }
    }


    public function render() {
        $params         = array();

        $table_footer   = $this->get_settings( 'wccp_show_table_footer' );
        $footer_total   = $this->get_settings( 'wccp_show_footer_total' );
        $show_thumb     = $this->get_settings( 'wccp_show_table_thumb' );
        $type           = $this->get_settings( 'wccp_type' );
        $categories     = $this->get_settings( 'wccp_categories' );


        if( $table_footer ){
            $params['actions'] = 'true';
        }else{
            $params['actions'] = 'false';
        }

        if( $show_thumb ){
            $params['show_thumb'] = 'true';
        }else{
            $params['show_thumb'] = 'false';
        }

        if( $footer_total ){
            $params['footer_total'] = 'true';
        }else{
            $params['footer_total'] = 'false';
        }

        if( $type != 'default' ){
            $params['type'] = $type;
        }
        
        if($categories){
            $cats = array();
            foreach($categories as $cat){
                $cats[] = $cat['wccp_category'];
            }
            $params['category'] = implode(',', $cats);
        }
        
        $params = $this->parse_array_to_params( $params );

        echo do_shortcode('[wc_cart_products '.$params.']');
    }

    public function parse_array_to_params( $params ){
        if( !$params || empty($params) ) return '';

        $return = array();
        foreach( $params as $key => $value ){
            $return[] = $key .'="'.$value.'"';
        }

        return implode(' ', $return);
    }


    public function render_plain_content() { }


    protected function content_template() { 
        
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new WCCP_Shortcode_Widget() );

