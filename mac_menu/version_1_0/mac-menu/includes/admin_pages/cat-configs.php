<?php
if (!class_exists('Mac_Cat_Config_Settings')) {
    class Mac_Cat_Config_Settings {
        function render($catAttr) {
            $id_category          = $catAttr['id_category'];
            $category_name        = $catAttr['category_name'];
            $slug_category        = $catAttr['slug_category'];
            $category_description = $catAttr['category_description'];
            $price                = $catAttr['price'];
            $featured_img         = $catAttr['featured_img'];
            $parents_category     = $catAttr['parents_category'];
            $order                = $catAttr['order'];
            $group_repeater       = $catAttr['group_repeater'];
            $is_hidden            = $catAttr['is_hidden'];
            $is_table             = $catAttr['is_table'];
            $table_col            = $catAttr['table_col'];

            if($table_col) {
                $tableColData = json_decode($table_col, true);
                $resultTableCol = array();
                foreach ($tableColData as $item) {
                    $resultTableCol[] = $item;
                    
                }
                $resultTableColJson = json_encode($resultTableCol);
                $table_col = $resultTableColJson;
            }else {
                $table_col = [];
            }

            if($group_repeater) {
                $repeaterData = json_decode($group_repeater, true);
                $resultRepeate = array();
                foreach ($repeaterData as $item) {
                    if (!empty($item['name'])) {
                        $resultRepeate[] = $item;
                    }
                }
                $resultRepeateJson = json_encode($resultRepeate);
                $group_repeater = $resultRepeateJson;
            }else {
                $group_repeater = [];
            }

            $objmacMenu = new macMenu();
            if($id_category == 'new' || $id_category == '' ) {
                
                $id_category_parent = isset( $_GET['id_child'] ) ? $_GET['id_child'] : "0";
                $objmacMenu->save_cat([
                    'category_name'        => $category_name,
                    'slug_category'        => $slug_category,
                    'category_description' => $category_description,
                    'price'                => $price,
                    'featured_img'         => $featured_img,
                    'parents_category'     => $id_category_parent,
                    'order'                => $order,
                    'group_repeater'       => $group_repeater,
                    'is_hidden'             => $is_hidden,
                    'is_table'             => $is_table,
                    'data_table'           => $table_col
                    
                ]);
                if($id_category_parent != ''){
                    mac_redirect('admin.php?page=mac-cat-menu&id='.$id_category_parent);
                }else{
                    mac_redirect('admin.php?page=mac-cat-menu');
                }
                
            }else {
                
                if( isset($id_category) ){
                    $objmacMenu->update_cat($id_category,[
                        'category_name'        => $category_name,
                        'slug_category'        => $slug_category,
                        'category_description' => $category_description,
                        'price'                => $price,
                        'featured_img'         => $featured_img,
                        'parents_category'     => $parents_category,
                        'group_repeater'       => $group_repeater,
                        'is_hidden'             => $is_hidden,
                        'is_table'             => $is_table,
                        'data_table'           => $table_col
                    ]);
                }
            }
        }
        
    }
}