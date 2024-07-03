<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Mac_Module_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'module_mac_menu';
    }

    public function get_title() {
        return __( 'Mac Menu', 'mac-menu' );
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
                'label' => __( 'Content', 'mac-menu' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'id_category',
            [
                'label' => __( 'Select Option', 'mac-menu' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'default' => array('all'),
                'options' => $this->get_select_cat_menu(),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'list_item_section',
            [
                'label' => __( 'List Item', 'mac-menu' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'limit_list_item',
            [
                'label' => __( 'Limit List Item', 'mac-menu' ),
                'type' => \Elementor\Controls_Manager::NUMBER
            ]
        );

        $this->end_controls_section();

        /** tab style */
        $this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'textdomain' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'color',
			[
				'label' => esc_html__( 'Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#f00',
				'selectors' => [
					'{{WRAPPER}} h3' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
    }

    public function get_select_cat_menu() {
        $objmacMenu = new macMenu();
        $results = $objmacMenu->all_cat();

        $newArray = array();
        foreach($results as $item ){
            $newArray[$item->id] = $item->category_name;
        }
        $newArray['all'] = esc_html__( 'All', 'mac-menu');

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
