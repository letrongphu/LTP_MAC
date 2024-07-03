<?php
    global $wpdb;
    // Tên bảng
    $cattablename = $wpdb->prefix . 'mac_cat_menu';
    // Kiểm tra sự tồn tại của bảng
    $table_exists_query = $wpdb->prepare("SHOW TABLES LIKE %s", $cattablename);
    $table_exists = $wpdb->get_var($table_exists_query);
    if ($table_exists != $cattablename):
        mac_redirect('admin.php?page=mac-menu');
    else:
        $entriesList = $wpdb->get_results("SELECT  * FROM ".$cattablename."");
        $objmacMenu = new macMenu();
        $result = $objmacMenu->paginate_cat(10);
        extract($result);
        if(!empty($entriesList)) {
    
            if( isset( $_GET['id'] ) && $_GET['id'] != '' ){
                require_once 'cat-detail.php';
            }elseif( isset( $_GET['id'] ) && $_GET['id'] == 'new' ) {
                require_once 'cat-detail.php';
            }
            else{
                require_once 'cat-list.php';
            }
        }

    endif;
?>