<?php
/*
Plugin Name:  MAC Menu
Plugin URI:   https://macmarketing.us/
Description:  menu
Version:      1.1
Author:       MAC LTP Coder
Author URI:   https://macmarketing.us/
License:      GPL v1
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  mac-plugin
Domain Path:  /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
define('MAC_PATH', plugin_dir_path( __FILE__ ) );
define('MAC_URI', plugin_dir_url( __FILE__ ) );

/* xây lớp bảo mật */
/**  Bảo vệ tệp wp-config.php */
function protect_wp_config() {
    $htaccess_file = ABSPATH . '.htaccess';
    if (file_exists($htaccess_file) && is_writable($htaccess_file)) {
        $rules = "\n<files wp-config.php>\norder allow,deny\ndenY from all\n</files>\n";
        file_put_contents($htaccess_file, $rules, FILE_APPEND);
    }
}
register_activation_hook(__FILE__, 'protect_wp_config');

/**  Chặn XML-RPC */
add_filter('xmlrpc_enabled', '__return_false');

/** Giới hạn số lần đăng nhập thất bại */
function limit_login_attempts($username) {
    $max_attempts = 5;
    $lockout_time = 60 * 15; // 15 phút

    if (get_transient('limit_login_attempts_' . $username)) {
        $attempts = get_transient('limit_login_attempts_' . $username);
        if ($attempts >= $max_attempts) {
            wp_die('Too many failed login attempts. Please try again later.');
        }
    }
}

function increase_login_attempts($username) {
    $attempts = get_transient('limit_login_attempts_' . $username);
    if (!$attempts) {
        $attempts = 0;
    }
    $attempts++;
    set_transient('limit_login_attempts_' . $username, $attempts, 60 * 15);
}

add_action('wp_login_failed', 'increase_login_attempts');
add_action('wp_authenticate', 'limit_login_attempts');

/**  */

add_action('admin_menu','mac_admin_menu');
function mac_admin_menu(){
    // Thêm menu cha
        add_menu_page(
            'MAC Menu',
            'MAC Menu',
            'edit_published_pages',
            'mac-cat-menu',//menu_slug
            'mac_menu_admin_page_cat_menu',
            'dashicons-admin-page',
            26
        );
        add_submenu_page(
            'mac-cat-menu',
            'New Cat Menu',
            'New Cat Menu',
            'edit_published_pages',
            'mac-new-cat-menu',
            'mac_menu_admin_page_news_cat_menu',
            26
        );
        add_submenu_page(
            'mac-cat-menu',
            'Settings/Import',
            'Settings/Import',
            'edit_published_pages',
            'mac-menu',
            'mac_menu_admin_page_dashboard',
            26
        );
}

function change_media_label(){
    global $submenu;
    if(isset($submenu['mac-cat-menu'])):
        $submenu['mac-cat-menu'][0][0] = 'All Cat Menu';
    endif;
}
add_action( 'admin_menu', 'change_media_label' );
function mac_menu_admin_page_dashboard(){
    include_once MAC_PATH.'includes/admin_pages/dashboard.php';
}

function mac_menu_admin_page_cat_menu(){
    include_once MAC_PATH.'includes/admin_pages/cat.php';
}

function mac_menu_admin_page_news_cat_menu(){
    mac_redirect('admin.php?page=mac-cat-menu&id=new');
}

if( !function_exists('mac_redirect') ){
    function mac_redirect($url){
        echo("<script>location.href = '".$url."'</script>");
    }
}

// Làm việc với CSDL trong wordpress
include_once MAC_PATH.'includes/classes/macMenu.php';

include_once MAC_PATH.'/blocks/render/render-module.php';
include_once MAC_PATH.'/blocks/module/cat_menu_basic.php';
include_once MAC_PATH.'/blocks/module/cat_menu_table.php';

function add_media_button_shortcode() {
    ob_start();
    ?>
    <div class="add-media-button-container">
        <input type="text" id="custom_media_url" name="custom_media_url" size="25" readonly />
        <button type="button" id="add_media_button">Add Media</button>
        <img id="media_preview" class="featured_img" src="" style="max-width: 200px; display: none;" />
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('add_media_button', 'add_media_button_shortcode');

// Kết hợp với enqueue scripts và styles
function mac_enqueue_scripts() {
    wp_enqueue_style( 'mac-style', MAC_URI . 'public/css/mac-menu-style.css' );
    wp_enqueue_script( 'mac-script', MAC_URI . 'public/js/mac-menu-script.js', array( 'jquery' ), '', true );
}
add_action( 'wp_enqueue_scripts', 'mac_enqueue_scripts' );

function mac_admin_enqueue_scripts() {
    global $pagenow;
    if ( isset( $_GET['page']) && 
            (   $_GET['page'] == 'mac-new-cat-menu' ||
                $_GET['page'] == 'mac-cat-menu' ||
                $_GET['page'] == 'mac-menu'
            )
            
        )  {
            wp_enqueue_media(); // Enqueue thư viện Media Uploader của WordPress
            /* jquery ui */
            wp_enqueue_style( 'jquery-ui', MAC_URI . 'admin/css/jquery-ui.css' );
            wp_enqueue_style( 'admin-style', MAC_URI . 'admin/css/admin-style.css' );
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-ui', MAC_URI . 'admin/js/jquery-ui.js', array( 'jquery' ), '', true );
            wp_enqueue_script( 'jquery-repeater', MAC_URI . 'admin/js/jquery.repeater.js', array( 'jquery' ), '', true );
            wp_enqueue_script( 'admin-script', MAC_URI . 'admin/js/admin-script.js', array( 'jquery-repeater' ), '', true );
    }
}
add_action( 'admin_enqueue_scripts', 'mac_admin_enqueue_scripts' );

function create_slug($string) {
    // Chuyển đổi tất cả các ký tự thành chữ thường
    $string = strtolower($string);
    // Thay thế các ký tự có dấu thành không dấu
    $string = preg_replace('/[áàảãạăắằẳẵặâấầẩẫậ]/u', 'a', $string);
    $string = preg_replace('/[éèẻẽẹêếềểễệ]/u', 'e', $string);
    $string = preg_replace('/[íìỉĩị]/u', 'i', $string);
    $string = preg_replace('/[óòỏõọôốồổỗộơớờởỡợ]/u', 'o', $string);
    $string = preg_replace('/[úùủũụưứừửữự]/u', 'u', $string);
    $string = preg_replace('/[ýỳỷỹỵ]/u', 'y', $string);
    $string = preg_replace('/[đ]/u', 'd', $string);
    
    // Xóa bỏ tất cả các ký tự đặc biệt
    $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
    
    // Thay thế khoảng trắng và các ký tự không hợp lệ bằng dấu gạch ngang (-)
    $string = preg_replace('/[\s-]+/', '-', $string);
    
    // Xóa bỏ dấu gạch ngang ở đầu và cuối chuỗi
    $string = trim($string, '-');
    
    return $string;
}
function create_array($string,$name=null) {
    $new_array = explode('|', $string);
    if(!empty($name)){
        $result = array();
        foreach ($new_array as $item) {
            $result[] = array($name => $item);
        }
        return $result;
    }else{
        return $new_array;
    }
}

function getGalleryFromIds($ids,$url = null) {
    $htmlGallery = '';
    // Convert the string of IDs into an array
    $image_ids_array = explode('|', $ids);
    // Loop through each ID and display the image
    if (!empty($image_ids_array)) {
        foreach ($image_ids_array as $image_id) {
            // Get the image URL
            $image_url = wp_get_attachment_image_src($image_id, 'full');
            // Check if the URL exists
            if ($image_url) {
                // Output the image HTML
                
                if( isset($url) ):
                    $htmlGallery .= '<img src="' . esc_url($image_url[0]) . '" alt="image">';
                else:
                    $htmlGallery .= '<div class="image-preview" data-id="' . $image_id . '">';
                    $htmlGallery .= '<img src="' . esc_url($image_url[0]) . '" alt="image">';
                    $htmlGallery .= '<span class="remove-img-button" data-id="' . $image_id . '">x</span>';
                    $htmlGallery .= '</div>';
                endif;
            }
        }
    } else {
        echo 'No images found.';
    }
    return $htmlGallery;
}

add_action( 'elementor/widgets/register', 'mac_register_custom_widget' );
function mac_register_custom_widget( $widgets_manager ) {
    require_once( plugin_dir_path( __FILE__ ) . '/blocks/mac-menu.php' );
    $widgets_manager->register( new \Mac_Module_Widget() );
}

// phân quyền admin

function add_custom_capabilities() {
    // Lấy vai trò người dùng
    $role = get_role('editor');
    // Thêm quyền cho vai trò
    if ($role) {
        $role->add_cap('edit_published_pages');
    }
}
add_action('init', 'add_custom_capabilities');

function remove_custom_capabilities() {
    // Lấy vai trò người dùng
    $role = get_role('editor');
    // Xóa quyền cho vai trò
    if ($role) {
        $role->remove_cap('edit_published_pages');
    }
}
//add_action('init', 'remove_custom_capabilities');

// Hàm để loại bỏ ký tự escape từ chuỗi
function remove_slashes_from_array(&$item, $key) {
    if (is_array($item)) {
        array_walk_recursive($item, 'remove_slashes_from_array');
    } else {
        $item = stripslashes($item);
    }
}




/** Dynamic */
function register_request_dynamic_tag_group( $dynamic_tags_manager ) {
	$dynamic_tags_manager->register_group(
		'request-mac-menu',
		[
			'title' => esc_html__( 'Mac Menu', 'mac-plugin' )
		]
	);
}
add_action( 'elementor/dynamic_tags/register', 'register_request_dynamic_tag_group' );

function register_request_dynamic_tag_item_menu_group( $dynamic_tags ) {
    $dynamic_tags->register_group(
        'request-mac-item-menu',
        [
            'title' => esc_html__( 'Mac Menu Item', 'mac-plugin' )
        ]
    );
}
add_action( 'elementor/dynamic_tags/register', 'register_request_dynamic_tag_item_menu_group' );

function register_dynamic_tag( $dynamic_tags_manager ) {
    require_once( __DIR__ . '/dynamic-tags/cat-menu/mac-menu-dynamic-tag-name.php' );
    require_once( __DIR__ . '/dynamic-tags/cat-menu/mac-menu-dynamic-tag-description.php' );
    require_once( __DIR__ . '/dynamic-tags/cat-menu/mac-menu-dynamic-tag-price.php' );
    require_once( __DIR__ . '/dynamic-tags/cat-menu/mac-menu-dynamic-tag-img.php' );
    require_once( __DIR__ . '/dynamic-tags/cat-menu/mac-menu-dynamic-tag-gallery.php' );
    require_once( __DIR__ . '/dynamic-tags/cat-menu/mac-menu-dynamic-tag-heading-col.php' );

    /** item menu */

    require_once( __DIR__ . '/dynamic-tags/item-menu/mac-menu-dynamic-tag-item-name.php' );
    require_once( __DIR__ . '/dynamic-tags/item-menu/mac-menu-dynamic-tag-item-description.php' );
    require_once( __DIR__ . '/dynamic-tags/item-menu/mac-menu-dynamic-tag-item-price.php' );
    require_once( __DIR__ . '/dynamic-tags/item-menu/mac-menu-dynamic-tag-item-img.php' );


	$dynamic_tags_manager->register( new \Elementor_Dynamic_Tag_Mac_Menu_Name );
    $dynamic_tags_manager->register( new \Elementor_Dynamic_Tag_Mac_Menu_Description );
    $dynamic_tags_manager->register( new \Elementor_Dynamic_Tag_Mac_Menu_Price );
    $dynamic_tags_manager->register( new \Elementor_Dynamic_Tag_Mac_Menu_Img );
    $dynamic_tags_manager->register( new \Elementor_Dynamic_Tag_Mac_Menu_Gallery );
    $dynamic_tags_manager->register( new \Elementor_Dynamic_Tag_Mac_Menu_Heading_Col );

    /** item menu */

    $dynamic_tags_manager->register( new \Elementor_Dynamic_Tag_Mac_Menu_Item_Name );
    $dynamic_tags_manager->register( new \Elementor_Dynamic_Tag_Mac_Menu_Item_Description );
    $dynamic_tags_manager->register( new \Elementor_Dynamic_Tag_Mac_Menu_Item_Price );
    $dynamic_tags_manager->register( new \Elementor_Dynamic_Tag_Mac_Menu_Item_Img );
}
add_action( 'elementor/dynamic_tags/register', 'register_dynamic_tag' );
