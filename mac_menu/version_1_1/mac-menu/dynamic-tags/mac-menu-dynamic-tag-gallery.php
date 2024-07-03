<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Elementor_Dynamic_Tag_Mac_Menu_Gallery extends \Elementor\Core\DynamicTags\Data_Tag {

    public function get_name() {
        return 'mac-menu-gallery';
    }

    public function get_title() {
        return esc_html__( 'Cat Menu Gallery', 'mac-plugin' );
    }

    public function get_group() {
        return [ 'request-mac-menu' ];
    }

    public function get_categories() {
        return  [ \Elementor\Modules\DynamicTags\Module::GALLERY_CATEGORY ];
    }

    protected function register_controls() {
        $objmacMenu = new macMenu();
        $results = $objmacMenu->all_cat();
        $newArray = array();
        foreach($results as $item) {
            $newArray[$item->id] = $item->category_name;
        }
        $this->add_control(
            'user_selected_cat_menu',
            [
                'type' => \Elementor\Controls_Manager::SELECT,
                'label' => esc_html__( 'Menu', 'mac-plugin' ),
                'options' => $newArray,
            ]
        );
    }

	public function render() {
        $images = $this->get_value();
        if ( empty( $images ) ) {
            echo 'No images found';
            return;
        }

        echo '<div class="elementor-gallery">';
        foreach ( $images as $image ) {
            echo '<img src="' . esc_url( $image['url'] ) . '" alt="" />';
        }
        echo '</div>';
    }

    public function get_value( array $options = [] ) {
        $selected_cat = $this->get_settings( 'user_selected_cat_menu' );
        if ( ! $selected_cat ) {
            return [];
        }

        $objmacMenu = new macMenu();
        $Cat = $objmacMenu->find_cat_menu($selected_cat);
		$ids = $Cat[0]->featured_img;
		
		$image_ids_array = explode('|', $ids);
        $images = [];
		if (!empty($image_ids_array)) {
			foreach ($image_ids_array as $image_id) {
				if(!empty($image_id)):
					$image_url = wp_get_attachment_image_src($image_id, 'full');
					$images[] = [
						'id' => $image_id,
						'url' => $image_url[0]
					];
				endif;
			}
		}

        return $images;
    }
}
