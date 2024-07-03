<?php
if (!function_exists('mac_menu_elementor_render')) {
    function mac_menu_elementor_render($settings) {

        $moduleConfigs = array();
        $moduleConfigs['id_category'] = isset($settings['id_category']) ? $settings['id_category'] : '';
        $moduleConfigs['limit_list_item'] = isset($settings['limit_list_item']) ? $settings['limit_list_item'] : '';
        $moduleConfigs['cat_menu_is_img'] = isset($settings['cat_menu_is_img']) ? $settings['cat_menu_is_img'] : '';
        $moduleConfigs['cat_menu_is_description'] = isset($settings['cat_menu_is_description']) ? $settings['cat_menu_is_description'] : '';
        $moduleConfigs['cat_menu_is_price'] = isset($settings['cat_menu_is_price']) ? $settings['cat_menu_is_price'] : '';
        $moduleConfigs['cat_menu_item_is_img'] = isset($settings['cat_menu_item_is_img']) ? $settings['cat_menu_item_is_img'] : '';
        $moduleConfigs['cat_menu_item_is_description'] = isset($settings['cat_menu_item_is_description']) ? $settings['cat_menu_item_is_description'] : '';
        $moduleConfigs['cat_menu_item_is_price'] = isset($settings['cat_menu_item_is_price']) ? $settings['cat_menu_item_is_price'] : '';
        /** table */
        $moduleConfigs['cat_menu_table_is_img'] = isset($settings['cat_menu_table_is_img']) ? $settings['cat_menu_table_is_img'] : '';
        $moduleConfigs['cat_menu_table_is_description'] = isset($settings['cat_menu_table_is_description']) ? $settings['cat_menu_table_is_description'] : '';
        $moduleConfigs['cat_menu_table_is_price'] = isset($settings['cat_menu_table_is_price']) ? $settings['cat_menu_table_is_price'] : '';
        $moduleConfigs['cat_menu_table_item_is_img'] = isset($settings['cat_menu_table_item_is_img']) ? $settings['cat_menu_table_item_is_img'] : '';
        $moduleConfigs['cat_menu_table_item_is_description'] = isset($settings['cat_menu_table_item_is_description']) ? $settings['cat_menu_table_item_is_description'] : '';
        $moduleConfigs['cat_menu_table_item_is_price'] = isset($settings['cat_menu_table_item_is_price']) ? $settings['cat_menu_table_item_is_price'] : '';
        $block_str = '';
        $block_str .= '<div class="mac-menu">';
        $block_str .= '<div class="block-content">';
        $renderHTML = new Render_Module;
        $block_str .= $renderHTML->render($moduleConfigs);  
        $block_str .= '</div>';
        $block_str .= '</div>';
        return $block_str;    
    }
    
}  
