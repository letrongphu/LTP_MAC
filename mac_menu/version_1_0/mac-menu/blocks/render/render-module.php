<?php
if (!class_exists('Render_Module')) {
    class Render_Module {
        function render($moduleInfo) {
            $render_modules = '';
            $id_category = isset($moduleInfo['id_category']) ? $moduleInfo['id_category'] : array('all');
            $limit_item = isset($moduleInfo['limit_list_item']) ? $moduleInfo['limit_list_item'] : '';

            /**  call data menu */
            $objmacMenu = new macMenu();
            $categoryMenuHTML = new Mac_Category_Menu;
            $categoryMenuTableHTML = new Mac_Category_Menu_Table;

            if (in_array('all', $id_category)) {
                
                $results = $objmacMenu->all_cat_menu_has_item();

                foreach ($results as $item ) {
                    
                    if($item->is_table == '0'){
                        $categoryMenuAttr = array (
                            'id' => $item->id,
                            'limit_item' => $limit_item
                        );  
                        $render_modules .='<div class="module-menu">';
                        $render_modules .= $categoryMenuHTML->render($categoryMenuAttr);
                        $childCat = $objmacMenu->all_cat_by_parent_cat_menu($item->id);
                        if(isset($childCat) && count($childCat) > 0 ) {
                            $render_modules .='<div class="module-menu-child-cat-wrap">';
                            $index_cat_child = 0;
                            foreach ($childCat as $itemChild ) {
                                $childCategoryMenuAttr = array (
                                    'id' => $itemChild->id,
                                    'class' => ' module-child-cat module-child-cat-index-'.$index_cat_child
                                );
                                if($itemChild->is_table == '0'){
                                    $render_modules .= $categoryMenuHTML->render($childCategoryMenuAttr);
                                }
                                else
                                {
                                    $render_modules .= $categoryMenuTableHTML->render($childCategoryMenuAttr);
                                }
                                $index_cat_child++;
                            }
                            $render_modules .= '</div>';
                        }
                        $render_modules .= '</div>';
                    }
                    else {
                        $categoryMenuTableAttr = array (
                            'id' => $item->id,
                            'limit_item' => $limit_item
                        );
                        $render_modules .='<div class="module-menu module-menu-table-style">';
                        $render_modules .= $categoryMenuTableHTML->render($categoryMenuTableAttr);
                        $childCat = $objmacMenu->all_cat_by_parent_cat_menu($item->id);
                        if(isset($childCat) && count($childCat) > 0 ) {
                            $render_modules .='<div class="module-menu-child-cat-wrap">';
                            $index_cat_child = 0;
                            foreach ($childCat as $itemChild ) {
                                $childCategoryMenuAttr = array (
                                    'id' => $itemChild->id,
                                    'class' => ' module-child-cat module-child-cat-index-'.$index_cat_child,
                                );
                                if($itemChild->is_table == '0'){
                                    $render_modules .= $categoryMenuHTML->render($childCategoryMenuAttr);
                                }
                                else
                                {
                                    $render_modules .= $categoryMenuTableHTML->render($childCategoryMenuAttr);
                                }
                                $index_cat_child++;
                            }
                            $render_modules .= '</div>';
                        }
                        $render_modules .= '</div>';
                    }
                    
                }

            } 
            else {
                $total_cat = count($id_category);
                
                foreach ($id_category as $itemCat ) {
                    $results = $objmacMenu->find_cat_menu($itemCat);
                    foreach ($results as $item ) {
                        if($item->is_table == '0'){
                            $categoryMenuAttr = array (
                                'id' => $itemCat,
                                'limit_item' => $limit_item
                            );  
                            $render_modules .='<div class="module-menu">';
                            $render_modules .= $categoryMenuHTML->render($categoryMenuAttr);
                            $childCat = $objmacMenu->all_cat_by_parent_cat_menu($itemCat);
                            if(isset($childCat) && count($childCat) > 0 ) {
                                $render_modules .='<div class="module-menu-child-cat-wrap">';
                                $index_cat_child = 0;
                                foreach ($childCat as $itemChild ) {
                                    $childCategoryMenuAttr = array (
                                        'id' => $itemChild->id,
                                        'class' => ' module-child-cat module-child-cat-index-'.$index_cat_child
                                    );
                                    if($itemChild->is_table == '0'){
                                        $render_modules .= $categoryMenuHTML->render($childCategoryMenuAttr);
                                    }
                                    else
                                    {
                                        $render_modules .= $categoryMenuTableHTML->render($childCategoryMenuAttr);
                                    }
                                    $index_cat_child++;
                                }
                                $render_modules .= '</div>';
                            }
                            $render_modules .= '</div>';
                        }
                        else {
                            $categoryMenuTableAttr = array (
                                'id' => $itemCat,
                                'limit_item' => $limit_item
                            );
                            $render_modules .='<div class="module-menu module-menu-table-style">';
                            $render_modules .= $categoryMenuTableHTML->render($categoryMenuTableAttr);
                            $childCat = $objmacMenu->all_cat_by_parent_cat_menu($itemCat);

                            if(isset($childCat) && count($childCat) > 0 ) {
                                $render_modules .='<div class="module-menu-child-cat-wrap">';
                                $index_cat_child = 0;
                                foreach ($childCat as $itemChild ) {
                                    $childCategoryMenuAttr = array (
                                        'id' => $itemChild->id,
                                        'class' => ' module-child-cat module-child-cat-index-'.$index_cat_child,
                                    );
                                    if($itemChild->is_table == '0'){
                                        $render_modules .= $categoryMenuHTML->render($childCategoryMenuAttr);
                                    }
                                    else
                                    {
                                        $render_modules .= $categoryMenuTableHTML->render($childCategoryMenuAttr);
                                    }
                                    $index_cat_child++;
                                }
                                $render_modules .= '</div>';
                            }


                            $render_modules .= '</div>';
                        }
                        
                    }
                    
                }

            }

            return $render_modules; 
        }
        
    }
}
