<?php
if (!function_exists('mac_menu_elementor_render')) {
    function mac_menu_elementor_render($settings) {

        $moduleConfigs = array();
        $moduleConfigs['id_category'] = $settings['id_category'];
        $moduleConfigs['limit_list_item'] = $settings['limit_list_item'];
        
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
