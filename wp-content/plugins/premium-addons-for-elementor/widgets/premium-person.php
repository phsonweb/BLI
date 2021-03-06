<?php

namespace PremiumAddons\Widgets;

use PremiumAddons\Helper_Functions;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Premium_Person extends Widget_Base {
    
    public function get_name() {
        return 'premium-addon-person';
    }

    public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __('Person', 'premium-addons-for-elementor') );
	}

    public function get_icon() {
        return 'pa-person';
    }
    
    public function get_style_depends() {
        return [
            'premium-addons'
        ];
    }

    public function get_categories() {
        return [ 'premium-elements' ];
    }
    
    public function get_keywords() {
		return [ 'team', 'member' ];
	}
    
    public function get_custom_help_url() {
		return 'https://premiumaddons.com/support/';
	}

    // Adding the controls fields for the premium person
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {

        /*Start Premium Person Section*/
        $this->start_controls_section('premium_person_general_settings',
            [
                'label'         => __('Image', 'premium-addons-for-elementor')
            ]
        );
        
        $this->add_control('premium_person_style',
            [
                'label'         => __('Style', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'style1',
                'options'       => [
                    'style1'        => __('Style 1', 'premium-addons-for-elementor'),
                    'style2'        => __('Style 2', 'premium-addons-for-elementor')
                ],
                'label_block'   =>  true,
            ]
        );
        
        $this->add_control('premium_person_image',
            [
                'label'         => __('Image', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::MEDIA,
                'dynamic'       => [ 'active' => true ],
                'default'       => [
                    'url'	=> Utils::get_placeholder_image_src()
            ],
                'label_block'   => true
            ]
        );
                
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'full',
				'separator' => 'none',
			]
		);
        
        $this->add_responsive_control('premium_person_image_width',
            [
                'label'         => __('Width', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'description'   => __('Enter image width in (PX, EM, %), default is 100%', 'premium-addons-for-elementor'),
                'size_units'    => ['px', 'em', '%'],
                'range'         => [
                    'px'    => [
                        'min'       => 1,
                        'max'       => 800,
                    ],
                    'em'    => [
                        'min'       => 1,
                        'max'       => 50,
                    ],
                ],
                'default'       => [
                    'unit'  => '%',
                    'size'  => '100',
                ],
                'label_block'   => true,
                'selectors'     => [
                    '{{WRAPPER}} .premium-person-container' => 'width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
        
        $this->add_responsive_control('premium_person_align',
            [
                'label'         => __( 'Alignment', 'premium-addons-for-elementor' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'flex-start'      => [
                        'title'=> __( 'Left', 'premium-addons-for-elementor' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title'=> __( 'Center', 'premium-addons-for-elementor' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end'     => [
                        'title'=> __( 'Right', 'premium-addons-for-elementor' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default'       => 'center',
                'selectors'     => [
                    '{{WRAPPER}} .elementor-widget-container' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control('premium_person_hover_image_effect',
            [
                'label'         => __('Hover Effect', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'none'          => __('None', 'premium-addons-for-elementor'),
                    'zoomin'        => __('Zoom In', 'premium-addons-for-elementor'),
                    'zoomout'       => __('Zoom Out', 'premium-addons-for-elementor'),
                    'scale'         => __('Scale', 'premium-addons-for-elementor'),
                    'grayscale'     => __('Grayscale', 'premium-addons-for-elementor'),
                    'blur'          => __('Blur', 'premium-addons-for-elementor'),
                    'bright'        => __('Bright', 'premium-addons-for-elementor'),
                    'sepia'         => __('Sepia', 'premium-addons-for-elementor'),
                    'trans'         => __('Translate', 'premium-addons-for-elementor'),
                ],
                'default'       => 'zoomin',
                'label_block'   => true
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('premium_person_person_details_section',
            [
                'label'         => __('Person', 'premium-addons-for-elementor'),
            ]
        );
        
        $this->add_control('premium_person_name',
            [
                'label'         => __('Name', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => 'John Frank',
                'label_block'   => true,
            ]
        );
        
        $this->add_control('premium_person_name_heading',
            [
                'label'         => __('HTML Tag', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'h2',
                'options'       => [
                    'h1'    => 'H1',
                    'h2'    => 'H2',
                    'h3'    => 'H3',
                    'h4'    => 'H4',
                    'h5'    => 'H5',
                    'h6'    => 'H6',
                ],
                'label_block'   =>  true,
            ]
        );
        
        $this->add_control('premium_person_title',
            [
                'label'         => __('Job Title', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('Senior Developer', 'premium-addons-for-elementor'),
                'label_block'   => true,
            ]
        );
        
        $this->add_control('premium_person_title_heading',
            [
                'label'         => __('HTML Tag', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'h4',
                'options'       => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6'
                ],
                'label_block'   =>  true,
            ]
        );
        
        $this->add_control('premium_person_content',
            [
                'label'         => __('Description', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::WYSIWYG,
                'dynamic'       => [ 'active' => true ],
                'default'       => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ullamcorper nulla non metus auctor fringilla','premium-addons-for-elementor'),
            ]
        );
        
        $this->add_responsive_control('premium_person_text_align',
            [
                'label'         => __( 'Alignment', 'premium-addons-for-elementor' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'      => [
                        'title'=> __( 'Left', 'premium-addons-for-elementor' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title'=> __( 'Center', 'premium-addons-for-elementor' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right'     => [
                        'title'=> __( 'Right', 'premium-addons-for-elementor' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default'       => 'center',
                'selectors'     => [
                    '{{WRAPPER}} .premium-person-info' => 'text-align: {{VALUE}};',
                ]
            ]
        );
        
        $this->end_controls_section();
        
        $this->start_controls_section('premium_person_social_section',
            [
                'label'         => __('Social Icons', 'premium-addons-for-elementor'),
            ]
        );
        
        $this->add_control('premium_person_social_enable',
            [
                'label'         => __( 'Enable Social Icons', 'premium-addons-for-elementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );
        
        $this->add_control('premium_person_facebook',
            [
                'label'         => __('Facebook', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '#',
                'label_block'   => true,
                'condition'     => [
                    'premium_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        /*Person Twitter*/
        $this->add_control('premium_person_twitter',
            [
                'label'         => __('Twitter', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '#',
                'label_block'   => true,
                'condition'     => [
                    'premium_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        /*Person Linkedin*/
        $this->add_control('premium_person_linkedin',
            [
                'label'         => __('LinkedIn', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '#',
                'label_block'   => true,
                'condition'     => [
                    'premium_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        /*Person Google*/
        $this->add_control('premium_person_google',
            [
                'label'         => __('Google+', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '#',
                'label_block'   => true,
                'condition'     => [
                    'premium_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        /*Person Youtube*/
        $this->add_control('premium_person_youtube',
            [
                'label'         => __('Youtube', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'premium_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        /*Person Instagram*/
        $this->add_control('premium_person_instagram',
            [
                'label'         => __('Instagram', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'premium_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        /*Person Skype*/
        $this->add_control('premium_person_skype',
            [
                'label'         => __('Skype', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'label_block'   => true,
                'condition'     => [
                    'premium_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        /*Person Pinterest*/
        $this->add_control('premium_person_pinterest',
            [
                'label'         => __('Pinterest', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '#',
                'label_block'   => true,
                'condition'     => [
                    'premium_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        /*Person Dribble*/
        $this->add_control('premium_person_dribbble',
            [
                'label'         => __('Dribbble', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '#',
                'label_block'   => true,
                'condition'     => [
                    'premium_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        /*Person Dribble*/
        $this->add_control('premium_person_behance',
            [
                'label'         => __('Behance', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '#',
                'label_block'   => true,
                'condition'     => [
                    'premium_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        /*Person Google*/
        $this->add_control('premium_person_mail',
            [
                'label'         => __('Email Address', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'dynamic'       => [ 'active' => true ],
                'default'       => '#',
                'label_block'   => true,
                'condition'     => [
                    'premium_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        /*End Social Links Section*/
        $this->end_controls_section();
        
        /*Start Image Style Section*/
        $this->start_controls_section('premium_person_image_style', 
                [
                    'label'         => __('Image', 'premium-addons-for-elementor'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                ]
                );
        
        /*Image CSS Filter */
        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .premium-person-image-container img',
			]
		);
        
        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'      => 'hover_css_filters',
                'label'     => __('Hover CSS Filters', 'premium-addons-for-elementor'),
				'selector'  => '{{WRAPPER}} .premium-person-image-container:hover img'
			]
		);
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'premium_person_shadow',
                'selector'      => '{{WRAPPER}} .premium-person-social',
                'condition'     => [
                    'premium_person_style'  => 'style2'
                ]
            ]
        );
        
        $this->add_control('blend_mode',
			[
				'label'     => __( 'Blend Mode', 'elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''              => __( 'Normal', 'elementor' ),
					'multiply'      => 'Multiply',
					'screen'        => 'Screen',
					'overlay'       => 'Overlay',
					'darken'        => 'Darken',
					'lighten'       => 'Lighten',
					'color-dodge'   => 'Color Dodge',
					'saturation'    => 'Saturation',
					'color'         => 'Color',
					'luminosity'    => 'Luminosity',
				],
                'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .premium-person-image-container img' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);
        
        /*End Image Style Section*/
        $this->end_controls_section();
        
        /*Start Name Style Section*/
         $this->start_controls_section('premium_person_name_style', 
                [
                    'label'         => __('Name', 'premium-addons-for-elementor'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                ]
                );
         
         
        /*Name Color*/
        $this->add_control('premium_person_name_color',
                [
                    'label'         => __('Color', 'premium-addons-for-elementor'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_1,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .premium-person-name'  => 'color: {{VALUE}};',
                        ]
                    ]
                );
         
        /*Name Typography*/ 
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'name_typography',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .premium-person-name',
                ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'name_shadow',
                'selector'      => '{{WRAPPER}} .premium-person-name',
            ]
        );
        
        /*End Name Style Section*/
        $this->end_controls_section();
        
        /*Start Title Style Section*/
        $this->start_controls_section('premium_person_title_style', 
                [
                    'label'         => __('Job Title', 'premium-addons-for-elementor'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                ]
                );
        
        /*Title Color*/
        $this->add_control('premium_person_title_color',
                [
                    'label'         => __('Color', 'premium-addons-for-elementor'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_2,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .premium-person-title'  => 'color: {{VALUE}};',
                        ]
                    ]
                );
        
        /*Title Typography*/
        $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'          => 'title_typography',
                    'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                    'selector'      => '{{WRAPPER}} .premium-person-title',
                ]
                );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'title_shadow',
                'selector'      => '{{WRAPPER}} .premium-person-title',
            ]
        );
        
        /*End Title Style Section*/
        $this->end_controls_section();
        
        /*Start Description Style Section*/
        $this->start_controls_section('premium_person_description_style', 
                [
                    'label'         => __('Description', 'premium-addons-for-elementor'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                ]
                );
        
        /*Title Color*/
        $this->add_control('premium_person_description_color',
                [
                    'label'         => __('Color', 'premium-addons-for-elementor'),
                    'type'          => Controls_Manager::COLOR,
                    'scheme'        => [
                        'type'  => Scheme_Color::get_type(),
                        'value' => Scheme_Color::COLOR_3,
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .premium-person-content'  => 'color: {{VALUE}};',
                        ]
                    ]
                );
        
        /*Title Typography*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'description_typography',
                'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
                'selector'      => '{{WRAPPER}} .premium-person-content',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'          => 'description_shadow',
                'selector'      => '{{WRAPPER}} .premium-person-content',
            ]
        );
        
        /*End Description Style Section*/
        $this->end_controls_section();
        
        /*Start Social Icon Style Section*/
        $this->start_controls_section('premium_person_social_icon_style', 
            [
                'label'         => __('Social Icons', 'premium-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'premium_person_social_enable'  => 'yes'
                ]
            ]
        );
        
        /*Social Color*/
        $this->add_control('premium_person_social_color',
            [
                'label'         => __('Color', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-person-list-item i'  => 'color: {{VALUE}};',
                ]
            ]
        );

        /*Social Hover Color*/
        $this->add_control('premium_person_social_hover_color',
            [
                'label'         => __('Hover Color', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'scheme'        => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .premium-person-list-item:hover i'  => 'color: {{VALUE}}',
                ]
            ]
        );
        
        $this->add_control('premium_person_social_background',
            [
                'label'             => __('Background Color', 'premium-addons-for-elementor'),
                'type'              => Controls_Manager::COLOR,
                'selectors'      => [
                    '{{WRAPPER}} .premium-person-list-item a'  => 'background-color: {{VALUE}}',
                ]
            ]
        );
        
        $this->add_control('premium_person_social_default_colors',
            [
                'label'         => __( 'Brands Default Colors', 'premium-addons-for-elementor' ),
                'type'          => Controls_Manager::SWITCHER,
                'prefix_class'  => 'premium-person-defaults-'
            ]
        );
        
        $this->add_control('premium_person_social_hover_background',
            [
                'label'             => __('Hover Background Color', 'premium-addons-for-elementor'),
                'type'              => Controls_Manager::COLOR,
                'selectors'      => [
                    '{{WRAPPER}} li.premium-person-list-item:hover a'  => 'background-color: {{VALUE}}',
                ],
                'condition'         => [
                    'premium_person_social_default_colors!'   => 'yes'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'          => 'premium_person_social_border',
                'selector'      => '{{WRAPPER}} .premium-person-list-item a',
            ]
        );
        
        $this->add_responsive_control('premium_person_social_radius',
            [
                'label'         => __('Border Radius', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-person-list-item a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        
        $this->add_responsive_control('premium_person_social_margin',
            [
                'label'         => __('Margin', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-person-list-item a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        $this->add_responsive_control('premium_person_social_padding',
            [
                'label'         => __('Padding', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-person-list-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        /*End Description Style Section*/
        $this->end_controls_section();
        
        /*Start Content Style Section*/
        $this->start_controls_section('premium_person_general_style', 
                [
                    'label'         => __('Content', 'premium-addons-for-elementor'),
                    'tab'           => Controls_Manager::TAB_STYLE,
                ]
                );
        
        /*Content Background Color*/
        $this->add_control('premium_person_content_background_color',
                [
                    'label'         => __('Color', 'premium-addons-for-elementor'),
                    'type'          => Controls_Manager::COLOR,
                    'default'       => 'rgba(245,245,245,0.97)',
                    'selectors'     => [
                        '{{WRAPPER}} .premium-person-info'  => 'background-color: {{VALUE}};',
                        ]
                    ]
                );
        
        /*Border Bottom Width*/
        $this->add_responsive_control('premium_person_border_bottom_width',
            [
                'label'         => __('Bottom Offset', 'premium-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px', 'em', '%'],
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 700,
                    ]
                ],
                'default'       => [
                    'size'  => 20,
                    'unit'  => 'px'
                ],
                'label_block'   => true,
                'selectors'     => [
                    '{{WRAPPER}} .premium-person-info' => 'bottom: {{SIZE}}{{UNIT}}',
                ]
            ]
        );
        
        $this->add_responsive_control('premium_person_content_speed',
            [
                'label'			=> __( 'Transition Duration (sec)', 'premium-addons-for-elementor' ),
                'type'			=> Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 5,
                        'step'  => 0.1
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .premium-person-info, {{WRAPPER}} .premium-person-image-container img'   => 'transition-duration: {{SIZE}}s',
                ]
            ]
        );
        
        $this->add_responsive_control('premium_person_content_padding',
            [
                'label'         => __('Padding', 'premium-addons-pro'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .premium-person-info-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        
        /*End Content Style Section*/
        $this->end_controls_section();
        
    }

    /**
	 * Render Grid output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
    protected function render() {
        
        $settings = $this->get_settings_for_display();
        
        $this->add_inline_editing_attributes('premium_person_name');
        
        $this->add_inline_editing_attributes('premium_person_title');
        
        $this->add_inline_editing_attributes('premium_person_content','advanced');
        
        $name_heading = $settings['premium_person_name_heading'];
        
        $title_heading = $settings['premium_person_title_heading'];
        
        $image_effect = $settings['premium_person_hover_image_effect'];

        $image_html = '';
        if ( ! empty( $settings['premium_person_image']['url'] ) ) {
			$this->add_render_attribute( 'image', 'src', $settings['premium_person_image']['url'] );
			$this->add_render_attribute( 'image', 'alt', Control_Media::get_image_alt( $settings['premium_person_image'] ) );
			$this->add_render_attribute( 'image', 'title', Control_Media::get_image_title( $settings['premium_person_image'] ) );

			$image_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'premium_person_image' );
		}
        
        $this->add_render_attribute( 'container', 'class', [
            'premium-person-container',
            'premium-person-' . $image_effect . '-effect',
            'premium-person-' . $settings['premium_person_style']  
        ]);

    ?>

    <div <?php echo $this->get_render_attribute_string( 'container' ) ?>>
        <div class="premium-person-image-container">
            <div class="premium-person-image-wrap">
                <?php echo $image_html; ?>
            </div>
            <?php if( 'style2' === $settings['premium_person_style'] && 'yes' === $settings['premium_person_social_enable'] ) : ?>
            <div class="premium-person-social">
                <?php $this->get_social_icons(); ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="premium-person-info">
            <div class="premium-person-info-container">
                <?php if( ! empty( $settings['premium_person_name'] ) ) : ?><<?php echo $name_heading; ?> class="premium-person-name"><span <?php echo $this->get_render_attribute_string('premium_person_name'); ?>><?php echo $settings['premium_person_name']; ?></span></<?php echo $name_heading; ?>><?php endif; ?>
                <?php if( ! empty( $settings['premium_person_title'] ) ) : ?><<?php echo $title_heading; ?> class="premium-person-title"><span <?php echo $this->get_render_attribute_string('premium_person_title'); ?>><?php echo $settings['premium_person_title']; ?></span></<?php echo $title_heading; ?>><?php endif; ?>
                <?php if( ! empty( $settings['premium_person_content'] ) ) : ?>
                    <div class="premium-person-content">
                        <div <?php echo $this->get_render_attribute_string('premium_person_content'); ?>>
                            <?php echo $settings['premium_person_content']; ?>
                        </div>
                    </div>
                <?php endif;
                if( 'style1' === $settings['premium_person_style'] && 'yes' === $settings['premium_person_social_enable'] ) :
                    $this->get_social_icons();
                endif; ?>
            </div>
        </div>
    </div>
    <?php
    }
    
    /*
     * Get Social Icons
     * 
     * Render person social icons list
     * 
     * @since 3.8.4
     * @access protected
     * 
     */
    private function get_social_icons() {
        
        $settings = $this->get_settings_for_display();
        
        ?>
        
        <ul class="premium-person-social-list">
            <?php if( ! empty( $settings['premium_person_facebook'] ) ) : ?>
                <li class="elementor-icon premium-person-list-item premium-person-facebook"><a href="<?php echo $settings['premium_person_facebook']; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
            <?php endif;

            if( ! empty( $settings['premium_person_twitter'] ) ) : ?>
                <li class="elementor-icon premium-person-list-item premium-person-twitter"><a href="<?php echo $settings['premium_person_twitter']; ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
            <?php endif;

            if( ! empty( $settings['premium_person_linkedin'] ) ) : ?>
                <li class="elementor-icon premium-person-list-item premium-person-linkedin"><a href="<?php echo $settings['premium_person_linkedin']; ?>" target="_blank"><i class="fab fa-linkedin"></i></a></li>
            <?php endif;
            if( ! empty( $settings['premium_person_google'] ) ) : ?>
                <li class="elementor-icon premium-person-list-item premium-person-google"><a href="<?php echo $settings['premium_person_google']; ?>" target="_blank"><i class="fab fa-google-plus-g"></i></a></li>
            <?php endif;

            if( ! empty( $settings['premium_person_youtube'] ) ) : ?>
                <li class="elementor-icon premium-person-list-item premium-person-youtube"><a href="<?php echo $settings['premium_person_youtube']; ?>" target="_blank"><i class="fab fa-youtube"></i></a></li>
            <?php endif;

            if( ! empty( $settings['premium_person_instagram'] ) ) : ?>
                <li class="elementor-icon premium-person-list-item premium-person-instagram"><a href="<?php echo $settings['premium_person_instagram']; ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
            <?php endif;

            if( ! empty( $settings['premium_person_skype'] ) ) : ?>
                <li class="elementor-icon premium-person-list-item premium-person-skype"><a href="<?php echo $settings['premium_person_skype']; ?>" target="_blank"><i class="fab fa-skype"></i></a></li>
            <?php endif;

            if( ! empty( $settings['premium_person_pinterest'] ) ) : ?>
                <li class="elementor-icon premium-person-list-item premium-person-pinterest"><a href="<?php echo $settings['premium_person_pinterest']; ?>" target="_blank"><i class="fab fa-pinterest"></i></a></li>
            <?php endif;

            if( ! empty( $settings['premium_person_dribbble'] ) ) : ?>
                <li class="elementor-icon premium-person-list-item premium-person-dribbble"><a href="<?php echo $settings['premium_person_dribbble']; ?>" target="_blank"><i class="fab fa-dribbble"></i></a></li>
            <?php endif;

            if( ! empty( $settings['premium_person_behance'] ) ) : ?>
                <li class="elementor-icon premium-person-list-item premium-person-behance"><a href="<?php echo $settings['premium_person_behance']; ?>" target="_blank"><i class="fab fa-behance"></i></a></li>
            <?php endif;

            if( ! empty( $settings['premium_person_mail'] ) ) : ?>
                <li class="premium-person-list-item premium-person-mail"><a class="elementor-icon" href="<?php echo $settings['premium_person_mail']; ?>" target="_blank"><i class="far fa-envelope"></i></a></li>
            <?php endif; ?>
        </ul>
        <?php
    }
    
    protected function _content_template() {
        ?>
        <#
        
        view.addInlineEditingAttributes( 'premium_person_name' );
        
        view.addInlineEditingAttributes( 'premium_person_title' );
        
        view.addInlineEditingAttributes( 'premium_person_content', 'advanced' );
        
        var nameHeading = settings.premium_person_name_heading,
        
        titleHeading = settings.premium_person_title_heading,
        
        imageEffect = 'premium-person-' + settings.premium_person_hover_image_effect + '-effect' ;
        
        skin        = 'premium-person-' + settings.premium_person_style;
        
        view.addRenderAttribute('container', 'class', [ 'premium-person-container', imageEffect, skin ] );

        var imageHtml = '';
        if ( settings.premium_person_image.url ) {
			var image = {
				id: settings.premium_person_image.id,
				url: settings.premium_person_image.url,
				size: settings.thumbnail_size,
				dimension: settings.thumbnail_custom_dimension,
				model: view.getEditModel()
			};

			var image_url = elementor.imagesManager.getImageUrl( image );

			imageHtml = '<img src="' + image_url + '"/>';

		}
        
        function getSocialIcons() {
            #>
            <ul class="premium-person-social-list">
                <# if( '' != settings.premium_person_facebook  ) { #>
                    <li class="elementor-icon premium-person-list-item premium-person-facebook"><a href="{{ settings.premium_person_facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                <# } #>

                <# if( '' != settings.premium_person_twitter  ) { #>
                    <li class="elementor-icon premium-person-list-item premium-person-twitter"><a href="{{ settings.premium_person_twitter }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                <# } #>

                <# if( '' != settings.premium_person_linkedin  ) { #>
                    <li class="elementor-icon premium-person-list-item premium-person-linkedin"><a href="{{ settings.premium_person_linkedin }}" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                <# } #>

                <# if( '' != settings.premium_person_google  ) { #>
                    <li class="elementor-icon premium-person-list-item premium-person-google"><a href="{{ settings.premium_person_google }}" target="_blank"><i class="fab fa-google-plus-g"></i></a></li>
                <# } #>

                <# if( '' != settings.premium_person_youtube  ) { #>
                    <li class="elementor-icon premium-person-list-item premium-person-youtube"><a href="{{ settings.premium_person_youtube }}" target="_blank"><i class="fab fa-youtube"></i></a></li>
                <# } #>

                <# if( '' != settings.premium_person_instagram ) { #>
                    <li class="elementor-icon premium-person-list-item premium-person-instagram"><a href="{{ settings.premium_person_instagram }}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                <# } #>

                <# if( '' != settings.premium_person_skype) { #>
                    <li class="elementor-icon premium-person-list-item premium-person-skype"><a href="{{ settings.premium_person_skype }}" target="_blank"><i class="fab fa-skype"></i></a></li>
                <# } #>

                <# if( '' != settings.premium_person_pinterest  ) { #>
                    <li class="elementor-icon premium-person-list-item premium-person-pinterest"><a href="{{ settings.premium_person_pinterest }}" target="_blank"><i class="fab fa-pinterest"></i></a></li>
                <# } #>

                <# if( '' != settings.premium_person_dribbble  ) { #>
                    <li class="elementor-icon premium-person-list-item premium-person-dribbble"><a href="{{ settings.premium_person_dribbble }}" target="_blank"><i class="fab fa-dribbble"></i></a></li>
                <# } #>

                <# if( '' != settings.premium_person_behance  ) { #>
                    <li class="elementor-icon premium-person-list-item premium-person-behance"><a href="{{ settings.premium_person_behance }}" target="_blank"><i class="fab fa-behance"></i></a></li>
                <# } #>

                <# if( '' != settings.premium_person_mail  ) { #>
                    <li class="elementor-icon premium-person-list-item premium-person-mail"><a href="{{ settings.premium_person_mail }}" target="_blank"><i class="far fa-envelope"></i></a></li>
                <# } #>

            </ul>
            <# }
        #>
        
        <div {{{ view.getRenderAttributeString('container') }}} >
            <div class="premium-person-image-container">
                <div class="premium-person-image-wrap">
                    {{{imageHtml}}}
                </div>
                <# if ( 'style2' === settings.premium_person_style && 'yes' === settings.premium_person_social_enable ) { #>
                    <div class="premium-person-social">
                        <# getSocialIcons(); #>
                    </div>
                <# } #>
            </div>
            <div class="premium-person-info">
                <div class="premium-person-info-container">
                    <# if( '' != settings.premium_person_name  ) { #>
                    <{{{nameHeading}}} class="premium-person-name">
                    <span {{{ view.getRenderAttributeString('premium_person_name') }}}>
                        {{{ settings.premium_person_name }}}
                    </span></{{{nameHeading}}}>
                    <# }
                    if( '' != settings.premium_person_title  ) { #>
                    <{{{titleHeading}}} class="premium-person-title">
                    <span {{{ view.getRenderAttributeString('premium_person_title') }}}>
                        {{{ settings.premium_person_title }}}
                    </span></{{{titleHeading}}}>
                    <# }
                    if( '' != settings.premium_person_content ) { #>
                        <div class="premium-person-content">
                            <div {{{ view.getRenderAttributeString('premium_person_content') }}}>
                                {{{ settings.premium_person_content }}}
                            </div>
                        </div>
                    <# }
                    if ( 'style1' === settings.premium_person_style && 'yes' === settings.premium_person_social_enable ) {
                        getSocialIcons();
                    } #>
                </div>
            </div>
        </div>
        <?php 
    }
}
