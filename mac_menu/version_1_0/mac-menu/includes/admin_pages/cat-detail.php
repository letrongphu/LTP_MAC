<?php
$id_category = isset( $_GET['id'] ) ? $_GET['id'] : "new";
$objmacMenu = new macMenu();
if( isset($id_category) && $id_category != 'new' ){
    $itemCatMenu = $objmacMenu->find_cat_menu($id_category);
}else{
    $itemCatMenu = array();
}  
$lastId = $wpdb->insert_id;

$idDelete = isset( $_POST['formIdDeledte'] ) ? $_POST['formIdDeledte'] : '';

if($idDelete != '') {
    $objmacMenu->destroy_Cat($idDelete);
    mac_redirect('admin.php?page=mac-cat-menu&id='.$id_category);
    exit();
}else {
    if( isset( $_POST['submit-form'] )) {
        check_admin_referer( 'mac-update_id_item');
        // Người dùng đang lưu
        $arrayForm_cat_id = [
            'id' => [
                '0' => "new"
            ]
        ];
        $form_cat_id = isset($_REQUEST['form_cat']) ? $_REQUEST['form_cat'] : $arrayForm_cat_id;
        foreach ($form_cat_id['id'] as $item_id ){
            if($item_id == ''):
                $item_id = 'new';
            endif;
            $category_name = isset($_REQUEST['form_'.$item_id.'_category_name']) ? stripslashes($_REQUEST['form_'.$item_id.'_category_name']) : '';
            $slug_category = isset($_REQUEST['form_'.$item_id.'_slug_category']) ? $_REQUEST['form_'.$item_id.'_slug_category'] : '';
            $category_description = isset($_REQUEST['form_'.$item_id.'_category_description']) ? stripslashes($_REQUEST['form_'.$item_id.'_category_description']) : '';
            $price = isset($_REQUEST['form_'.$item_id.'_price']) ? stripslashes($_REQUEST['form_'.$item_id.'_price']) : '';
            $featured_img = isset($_REQUEST['form_'.$item_id.'_featured_img']) ? $_REQUEST['form_'.$item_id.'_featured_img'] : '';
            $parents_category  = isset($_REQUEST['form_'.$item_id.'_parents_category']) ? $_REQUEST['form_'.$item_id.'_parents_category'] : '0';
            $order  = isset($_REQUEST['form_'.$item_id.'_order']) ? $_REQUEST['form_'.$item_id.'_order'] : '';
            $group_repeater = isset($_REQUEST['form_'.$item_id.'_group-repeater']) ? $_REQUEST['form_'.$item_id.'_group-repeater'] : [];
            /**/
            array_walk_recursive($group_repeater, 'remove_slashes_from_array');
            $group_repeater = json_encode($group_repeater);
            $is_hidden = isset($_REQUEST['form_'.$item_id.'_is_hidden']) ? $_REQUEST['form_'.$item_id.'_is_hidden'] : '0';
            $is_table = isset($_REQUEST['form_'.$item_id.'_is_table']) ? $_REQUEST['form_'.$item_id.'_is_table'] : '0';
            $table_col = isset($_REQUEST['form_'.$item_id.'_table_col']) ? $_REQUEST['form_'.$item_id.'_table_col'] : [];

            array_walk_recursive($table_col, 'remove_slashes_from_array');
            $table_col = json_encode($table_col);

            if(empty($slug_category)):
                $slug_category = create_slug($category_name);
            endif;
            include_once 'cat-configs.php';
            $catConfigSettings = array();
            /** chuyền dữ liệu sang cat-config */
            $catConfigSettings['id_category'] = $item_id;
            $catConfigSettings['category_name'] = $category_name;
            $catConfigSettings['slug_category'] = $slug_category;
            $catConfigSettings['category_description'] = $category_description;
            $catConfigSettings['price'] = $price;
            $catConfigSettings['featured_img'] = $featured_img;
            $catConfigSettings['parents_category'] = $parents_category;
            $catConfigSettings['order'] = $order;
            $catConfigSettings['group_repeater'] = $group_repeater;
            $catConfigSettings['is_hidden'] = $is_hidden;
            $catConfigSettings['is_table'] = $is_table;
            $catConfigSettings['table_col'] = $table_col;
            $renderCatConfigSettings = new Mac_Cat_Config_Settings;
            $renderCatConfigSettings->render($catConfigSettings);
        }
        mac_redirect('admin.php?page=mac-cat-menu&id='.$id_category);
        exit();
    }
}
include_once 'catHTML.php';
$catConfigs = array();
$catConfigs['id_category'] = $id_category;
$renderCatHTML = new Mac_Cat_HTML;
?>
<div class="wrap mac-dashboard">
    <h1 class="wp-heading-inline"></h1>
    <form id="posts-filter" method="post">
        <?php wp_nonce_field( 'mac-update_id_item');?>
        <div id="poststuff">
            <div id="post-body" class="metabox-holder columns-2" style="display: flex;">
                <!-- Left columns -->
                <div id="post-body-content">
                    <!-- Detail -->
                    <div class="postbox">
                        <div class="postbox-header">
                            <h2 class="hndle ui-sortable-handle">Detail Cat Menu</h2>
                        </div>
                        <div class="inside is-primary-category"> <?php echo $renderCatHTML->render($catConfigs); ?></div>
                    </div>
                    <?php if($id_category != 'new'):  ?>
                    <!-- list item in category -->
                     
                    <div class="postbox sub-category-list">
                        <div class="postbox-header">
                            <h2 class="hndle">List Cat Child Menu</h2>
                        </div>
                        <div class="inside is-child-category">
                            <?php 
                            include 'list-cat-child-in-cat.php'; 
                            ?>
                            <div class="add-cat-child">
                                <a href="admin.php?page=mac-cat-menu&id=new&id_child=<?= isset($itemCatMenu[0]->id) ? $itemCatMenu[0]->id : "" ; ?>" >Add New Cat Child</a>
                            </div>
                        </div><!-- inside -->
                    </div>
                    <!-- list item in category -->
                     <?php endif; ?>
                </div>
                <!-- Right columns -->
                <div id="postbox-container-1">
                    <div class="postbox">
                        <div class="postbox-header">
                            <h2 class="hndle">Action</h2>
                        </div>
                        <div class="inside">
                            <input type="submit" name="submit-form" id="doaction" class="button action" value="Save Changes">
                        </div>
                    </div><!-- .postbox -->
                </div>

            </div>
        </div>
    </form>
</div>