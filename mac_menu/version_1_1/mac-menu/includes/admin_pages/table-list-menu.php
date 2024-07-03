<?php
global $wpdb;
function create_table_cat(){
    global $wpdb;
    $cattablename = $wpdb->prefix."mac_cat_menu";
    $charset_collate = $wpdb->get_charset_collate();
    $stringSQL = "
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `category_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
        `slug_category` text COLLATE utf8_unicode_ci DEFAULT NULL,
        `category_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
        `price` text COLLATE utf8_unicode_ci DEFAULT NULL,
        `featured_img` text COLLATE utf8_unicode_ci DEFAULT NULL,
        `parents_category` text COLLATE utf8_unicode_ci DEFAULT NULL,
        `order` int(11) DEFAULT NULL,
        `group_repeater` text COLLATE utf8_unicode_ci DEFAULT NULL,
        `is_table` int(11) DEFAULT NULL,
        `is_hidden` int(11) DEFAULT NULL,
        `data_table` text COLLATE utf8_unicode_ci DEFAULT NULL,
        PRIMARY KEY (id)
    ";
    $sql = "CREATE TABLE `$cattablename` (
        ".$stringSQL."
      ) ".$charset_collate.";";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    register_activation_hook( __FILE__, 'plugin_cat_table' );
}
function plugin_cat_table($cat_csv_to_array){
    global $wpdb;
    $cattablename = $wpdb->prefix."mac_cat_menu";
    $dataCSV = array();
    $new_array = array();
    create_table_cat();
    $orderIndex = 0;
    foreach ($cat_csv_to_array as $item):
        $wpdb->insert( $cattablename, 
            array(
                'category_name' => $item['category_name'],
                'slug_category' => create_slug($item['category_name']),
                'category_description' => $item['category_description'],
                'price' => $item['price'],
                'featured_img' => $item['featured_img'],
                'order' => $orderIndex,
                'is_table' => $item['is_table'],
                'is_hidden' => $item['is_hidden'],
                'parents_category' => $item['parents_category'],
                'data_table' => json_encode(create_array($item['data_table'])),
                'group_repeater' => json_encode($item['group_repeater'])
            )
        );
        $orderIndex++;
    endforeach;
    // Kiểm tra sự tồn tại của bảng
    $table_exists_query = $wpdb->prepare("SHOW TABLES LIKE %s", $cattablename);
    $table_exists = $wpdb->get_var($table_exists_query);
    if ($table_exists === $cattablename) {
        mac_redirect('admin.php?page=mac-cat-menu');
        exit();
    } else {
        echo "Bảng '$cattablename' không tồn tại.";
    }
}