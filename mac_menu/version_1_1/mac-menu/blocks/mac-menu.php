<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

class Mac_Module_Widget extends Widget_Base {

    public function get_name() {
        return 'module_mac_menu';
    }

    public function get_title() {
        return __( 'Mac Menu', 'mac-plugin' );
    }

    public function get_icon() {
        return 'eicon-menu-card';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'mac-plugin' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'id_category',
            [
                'label' => __( 'Select Option', 'mac-plugin' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'default' => array('all'),
                'options' => $this->get_select_cat_menu(),
            ]
        );
        $this->add_control(
            'limit_list_item',
            [
                'label' => __( 'Limit List Item', 'mac-plugin' ),
                'type' => Controls_Manager::NUMBER
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'content_cat_menu_section',
            [
                'label' => __( 'Cat Menu', 'mac-plugin' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        // Heading Control
        $this->add_control(
            'content_heading_control',
            [
                'label' => __('Cat Menu', 'mac-plugin'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        // All Settings Of Catmenu
        $this->add_control(
            'cat_menu_is_img',
            [
                'label' => __( 'Image Hidden', 'mac-plugin' ),
                'type' => Controls_Manager::SWITCHER,
                'label_enable' => __( 'On', 'mac-plugin' ),
                'label_disable' => __( 'Off', 'mac-plugin' ),
                'return_value' => 'off',
                'default' => 'on',
            ]
        );
        $this->add_control(
            'cat_menu_is_description',
            [
                'label' => __( 'Description Hidden', 'mac-plugin' ),
                'type' => Controls_Manager::SWITCHER,
                'label_enable' => __( 'On', 'mac-plugin' ),
                'label_disable' => __( 'Off', 'mac-plugin' ),
                'return_value' => 'off',
                'default' => 'on',
            ]
        );
        $this->add_control(
            'cat_menu_is_price',
            [
                'label' => __( 'Price Hidden', 'mac-plugin' ),
                'type' => Controls_Manager::SWITCHER,
                'label_enable' => __( 'On', 'mac-plugin' ),
                'label_disable' => __( 'Off', 'mac-plugin' ),
                'return_value' => 'off',
                'default' => 'on',
            ]
        );
        // Heading Control
        $this->add_control(
            'content_item_heading_control',
            [
                'label' => __('Cat Item Menu', 'mac-plugin'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'classes' => 'elementor-control-separator-before'
            ]
        );
        // All Settings Of Cat menu item
        $this->add_control(
            'cat_menu_item_is_img',
            [
                'label' => __( 'Image Hidden', 'mac-plugin' ),
                'type' => Controls_Manager::SWITCHER,
                'label_enable' => __( 'On', 'mac-plugin' ),
                'label_disable' => __( 'Off', 'mac-plugin' ),
                'return_value' => 'off',
                'default' => 'on',
            ]
        );
        $this->add_control(
            'cat_menu_item_is_description',
            [
                'label' => __( 'Description Hidden', 'mac-plugin' ),
                'type' => Controls_Manager::SWITCHER,
                'label_enable' => __( 'On', 'mac-plugin' ),
                'label_disable' => __( 'Off', 'mac-plugin' ),
                'return_value' => 'off',
                'default' => 'on',
            ]
        );
        $this->add_control(
            'cat_menu_item_is_price',
            [
                'label' => __( 'Price Hidden', 'mac-plugin' ),
                'type' => Controls_Manager::SWITCHER,
                'label_enable' => __( 'On', 'mac-plugin' ),
                'label_disable' => __( 'Off', 'mac-plugin' ),
                'return_value' => 'off',
                'default' => 'on',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'content_cat_menu_table_section',
            [
                'label' => __( 'Cat Menu Table', 'mac-plugin' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Heading Control
        $this->add_control(
            'content_table_heading_control',
            [
                'label' => __('Cat Menu Table', 'mac-plugin'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // All Settings Of Catmenu
        $this->add_control(
            'cat_menu_table_is_img',
            [
                'label' => __( 'Image Hidden', 'mac-plugin' ),
                'type' => Controls_Manager::SWITCHER,
                'label_enable' => __( 'On', 'mac-plugin' ),
                'label_disable' => __( 'Off', 'mac-plugin' ),
                'return_value' => 'off',
                'default' => 'on',
            ]
        );
        $this->add_control(
            'cat_menu_table_is_description',
            [
                'label' => __( 'Description Hidden', 'mac-plugin' ),
                'type' => Controls_Manager::SWITCHER,
                'label_enable' => __( 'On', 'mac-plugin' ),
                'label_disable' => __( 'Off', 'mac-plugin' ),
                'return_value' => 'off',
                'default' => 'on',
            ]
        );
        $this->add_control(
            'cat_menu_table_is_price',
            [
                'label' => __( 'Price Hidden', 'mac-plugin' ),
                'type' => Controls_Manager::SWITCHER,
                'label_enable' => __( 'On', 'mac-plugin' ),
                'label_disable' => __( 'Off', 'mac-plugin' ),
                'return_value' => 'off',
                'default' => 'on',
            ]
        );

        // Heading Control
        $this->add_control(
            'content_table_item_heading_control',
            [
                'label' => __('Cat Item Menu', 'mac-plugin'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'classes' => 'elementor-control-separator-before'
            ]
        );

        // All Settings Of Cat menu item

        $this->add_control(
            'cat_menu_table_item_is_img',
            [
                'label' => __( 'Image Hidden', 'mac-plugin' ),
                'type' => Controls_Manager::SWITCHER,
                'label_enable' => __( 'On', 'mac-plugin' ),
                'label_disable' => __( 'Off', 'mac-plugin' ),
                'return_value' => 'off',
                'default' => 'on',
            ]
        );
        $this->add_control(
            'cat_menu_table_item_is_description',
            [
                'label' => __( 'Description Hidden', 'mac-plugin' ),
                'type' => Controls_Manager::SWITCHER,
                'label_enable' => __( 'On', 'mac-plugin' ),
                'label_disable' => __( 'Off', 'mac-plugin' ),
                'return_value' => 'off',
                'default' => 'on',
            ]
        );
        $this->add_control(
            'cat_menu_table_item_is_price',
            [
                'label' => __( 'Price Hidden', 'mac-plugin' ),
                'type' => Controls_Manager::SWITCHER,
                'label_enable' => __( 'On', 'mac-plugin' ),
                'label_disable' => __( 'Off', 'mac-plugin' ),
                'return_value' => 'off',
                'default' => 'on',
            ]
        );
        $this->end_controls_section();

        // Tab Style Cat Settings
        $this->start_controls_section(
			'style_cat_basic_section',
			[
				'label' => esc_html__( 'Cat Menu', 'mac-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

            // Heading Control
            $this->add_control(
                'heading_control',
                [
                    'label' => __('Cat Menu', 'mac-plugin'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

                // Name Setting
                
            $this->add_responsive_control(
                'name_text_color',
                [
                    'label' => __('Name Text Color', 'mac-plugin'),
                    'type' => Controls_Manager::COLOR,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selectors' => [
                        '{{WRAPPER}} .cat-menu-name' => 'color: {{VALUE}};',
                    ],
                    'classes' => 'elementor-control-separator-before'
                    
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'name_typography',
                    'label' => __('Name Typography', 'mac-plugin'),
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selector' => '{{WRAPPER}} .cat-menu-name',
                ]
            );
                // Price Setting
                
            $this->add_control(
                'price_text_color',
                [
                    'label' => __('Price Color', 'mac-plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cat-menu-price' => 'color: {{VALUE}};',
                    ],
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'classes' => 'elementor-control-separator-before'
                    
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'price_typography',
                    'label' => __('Price Typography', 'mac-plugin'),
                    'selector' => '{{WRAPPER}} .cat-menu-price',
                ]
            );
                // Description Setting
            $this->add_control(
                'description_text_color',
                [
                    'label' => __('Description Color', 'mac-plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cat-menu-description' => 'color: {{VALUE}};',
                    ],
                    'classes' => 'elementor-control-separator-before'
                    
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'description_typography',
                    'label' => __('Description Typography', 'mac-plugin'),
                    'selector' => '{{WRAPPER}} .cat-menu-description',
                ]
            );

            // Heading Control
            $this->add_control(
                'item_heading_control',
                [
                    'label' => __('Cat Item Menu', 'mac-plugin'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'classes' => 'elementor-control-separator-before'
                ]
            );

            // Item Name Setting
                
            $this->add_responsive_control(
                'item_name_text_color',
                [
                    'label' => __('Name Text Color', 'mac-plugin'),
                    'type' => Controls_Manager::COLOR,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selectors' => [
                        '{{WRAPPER}} .mac-menu-item-name' => 'color: {{VALUE}};',
                    ]
                    
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'item_name_typography',
                    'label' => __('Name Typography', 'mac-plugin'),
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selector' => '{{WRAPPER}} .mac-menu-item-name',
                ]
            );
                // Item Price Setting
                
            $this->add_control(
                'item_price_text_color',
                [
                    'label' => __('Price Color', 'mac-plugin'),
                    'type' => Controls_Manager::COLOR,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selectors' => [
                        '{{WRAPPER}} .mac-menu-item-price' => 'color: {{VALUE}};',
                    ],
                    'classes' => 'elementor-control-separator-before'
                    
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'item_price_typography',
                    'label' => __('Price Typography', 'mac-plugin'),
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selector' => '{{WRAPPER}} .mac-menu-item-price',
                ]
            );
                // Item Description Setting
            $this->add_control(
                'item_description_text_color',
                [
                    'label' => __('Description Color', 'mac-plugin'),
                    'type' => Controls_Manager::COLOR,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selectors' => [
                        '{{WRAPPER}} .mac-menu-item-description' => 'color: {{VALUE}};',
                    ],
                    'classes' => 'elementor-control-separator-before'
                    
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'item_description_typography',
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'label' => __('Description Typography', 'mac-plugin'),
                    'selector' => '{{WRAPPER}} .mac-menu-item-description',
                ]
            );

        $this->end_controls_section();
        // End Tab Style Cat Settings
        
        // Tab Style Cat Table Settings
        $this->start_controls_section(
			'style_cat_table_section',
			[
				'label' => esc_html__( 'Cat Menu Table', 'mac-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

            // Heading Control
            $this->add_control(
                'table_heading_control',
                [
                    'label' => __('Cat Menu Table', 'mac-plugin'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

                // Name Setting
                
            $this->add_responsive_control(
                'table_name_text_color',
                [
                    'label' => __('Name Text Color', 'mac-plugin'),
                    'type' => Controls_Manager::COLOR,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selectors' => [
                        '{{WRAPPER}} .cat-menu-table-name' => 'color: {{VALUE}};',
                    ],
                    'classes' => 'elementor-control-separator-before'
                    
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'table_name_typography',
                    'label' => __('Name Typography', 'mac-plugin'),
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selector' => '{{WRAPPER}} .cat-menu-table-name',
                ]
            );
                // Price Setting
                
            $this->add_control(
                'table_price_text_color',
                [
                    'label' => __('Price Color', 'mac-plugin'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cat-menu-table-price' => 'color: {{VALUE}};',
                    ],
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'classes' => 'elementor-control-separator-before'
                    
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'table_price_typography',
                    'label' => __('Price Typography', 'mac-plugin'),
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selector' => '{{WRAPPER}} .cat-menu-table-price',
                ]
            );
                // Description Setting
            $this->add_control(
                'table_description_text_color',
                [
                    'label' => __('Description Color', 'mac-plugin'),
                    'type' => Controls_Manager::COLOR,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selectors' => [
                        '{{WRAPPER}} .cat-menu-table-description' => 'color: {{VALUE}};',
                    ],
                    'classes' => 'elementor-control-separator-before'
                    
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'table_description_typography',
                    'label' => __('Description Typography', 'mac-plugin'),
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selector' => '{{WRAPPER}} .cat-menu-table-description',
                ]
            );

            // Heading Control
            $this->add_control(
                'table_item_heading_control',
                [
                    'label' => __('Cat Item Menu', 'mac-plugin'),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'classes' => 'elementor-control-separator-before'
                ]
            );

            // Item Heding Name Setting
                
            $this->add_responsive_control(
                'table_item_heading_text_color',
                [
                    'label' => __('Heading Text Color', 'mac-plugin'),
                    'type' => Controls_Manager::COLOR,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selectors' => [
                        '{{WRAPPER}} .mac-menu-table-heading > div' => 'color: {{VALUE}};',
                    ]
                    
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'table_item_heading_typography',
                    'label' => __('Heading Typography', 'mac-plugin'),
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selector' => '{{WRAPPER}} .mac-menu-table-heading > div',
                ]
            );

            // Item Name Setting
                
            $this->add_responsive_control(
                'table_item_name_text_color',
                [
                    'label' => __('Name Text Color', 'mac-plugin'),
                    'type' => Controls_Manager::COLOR,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selectors' => [
                        '{{WRAPPER}} .mac-menu-table-item-name' => 'color: {{VALUE}};',
                    ]
                    
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'table_item_name_typography',
                    'label' => __('Name Typography', 'mac-plugin'),
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selector' => '{{WRAPPER}} .mac-menu-table-item-name',
                ]
            );
                // Item Price Setting
                
            $this->add_control(
                'table_item_price_text_color',
                [
                    'label' => __('Price Color', 'mac-plugin'),
                    'type' => Controls_Manager::COLOR,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selectors' => [
                        '{{WRAPPER}} .mac-menu-table-item-price' => 'color: {{VALUE}};',
                    ],
                    'classes' => 'elementor-control-separator-before'
                    
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'table_item_price_typography',
                    'label' => __('Price Typography', 'mac-plugin'),
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selector' => '{{WRAPPER}} .mac-menu-table-item-price',
                ]
            );
                // Item Description Setting
            $this->add_control(
                'table_item_description_text_color',
                [
                    'label' => __('Description Color', 'mac-plugin'),
                    'type' => Controls_Manager::COLOR,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'selectors' => [
                        '{{WRAPPER}} .mac-menu-table-item-description' => 'color: {{VALUE}};',
                    ],
                    'classes' => 'elementor-control-separator-before'
                    
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'table_item_description_typography',
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'label' => __('Description Typography', 'mac-plugin'),
                    'selector' => '{{WRAPPER}} .mac-menu-table-item-description',
                ]
            );

        $this->end_controls_section();
        // End Tab Style Cat Settings
        

    }

    public function get_select_cat_menu() {
        $objmacMenu = new macMenu();
        $results = $objmacMenu->all_cat();

        $newArray = array();
        foreach($results as $item ){
            $newArray[$item->id] = $item->category_name;
        }
        $newArray['all'] = esc_html__( 'All', 'mac-plugin');

        return $newArray;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        include MAC_PATH.'/blocks/render/mac-menu-render.php';
        if ( function_exists( 'mac_menu_elementor_render' ) ) {
            $settings    = $this->get_settings();
            echo \mac_menu_elementor_render( $settings );
        }

    }

    
}
