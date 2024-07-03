<?php
if (!class_exists('Mac_Category_Menu_Table')) {
    class Mac_Category_Menu_Table {
        function render($catMenuAttr) {
            $id = $catMenuAttr['id'];
            $limit_item = isset($catMenuAttr['limit_item']) ? $catMenuAttr['limit_item'] : "";
            $objmacMenu = new macMenu();
            $isCat = $objmacMenu->find_cat_menu($id);
            ob_start();
            ?>
                <div class="module-category-menu-table">
                    <div class="cat-menu-table-text">
                        <div class="cat-menu-table-head">
                            <?php if (isset($isCat[0]->category_name) && !empty($isCat[0]->category_name) ): ?>
                                <span class="cat-menu-table-name"><?= $isCat[0]->category_name ?></span>
                            <?php endif; ?>
                            <?php if (isset($isCat[0]->price) && !empty($isCat[0]->price) ): ?>
                                <div class="cat-menu-table-price"><?= $isCat[0]->price ?></div>
                            <?php endif; ?>
                        </div>
                        <?php if (isset($isCat[0]->category_description) && !empty($isCat[0]->category_description) ): ?>
                            <div class="cat-menu-table-description"><?= $isCat[0]->category_description ?></div>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($isCat[0]->featured_img) && !empty($isCat[0]->featured_img) ): ?>
                    <div class="cat-menu-table-img">
                        
                        <?php
                            echo getGalleryFromIds($isCat[0]->featured_img,'url');
                        ?>
                    </div>
                    <?php endif; ?>
                    <div class="cat-menu-table-wrap">
                        
                        <div class="mac-menu-table" style="width:100%">
                            <div class="mac-menu-table-heading">
                                <div></div>
                                <?php
                                     $jsonHeading = isset($isCat[0]->data_table) ? $isCat[0]->data_table : [];
                                     $dataHeading = json_decode($jsonHeading, true);

                                    if (is_array($dataHeading)) {
                                        
                                        foreach ($dataHeading as $item) {
                                            echo '<div>';
                                            if (isset($item)) {
                                                echo ''. $item;
                                            }
                                            echo '</div>';
                                        }
                                    }
                                
                                ?>
                            </div>
                            <?php 
                                $json = isset($isCat[0]->group_repeater) ? $isCat[0]->group_repeater : [];
                                $data = json_decode($json, true);
                                echo '<div class="mac-menu-table-content"  data-limit="'.$limit_item.'" >';
                                if (is_array($data)) {
                                    $index = 0;
                                    foreach ($data as $item) {

                                        if($limit_item != '' && $limit_item != '0' ):
                                            if( $index < $limit_item ):
                                                $index++;
                                            else:
                                                break;
                                            endif;
                                        endif;

                                        echo '<div class="mac-menu-table-item">';
                                        echo '<div class="mac-menu-table-item-content">';

                                            if (isset($item['featured_img']) && !empty($item['featured_img'])) {
                                                echo '<div class="mac-menu-table-img"><img src="'.$item['featured_img'].'" alt="image"></div>';
                                            }
                                            echo '<div class="mac-menu-table-text">';
                                                if (isset($item['name']) && !empty($item['name'])) {
                                                    echo '<span class="mac-menu-table-item-name">'.$item['name'].'</span>';
                                                }
                                                if (isset($item['description']) && !empty($item['description'])) {
                                                    echo '<div class="mac-menu-table-item-description">'.$item['description'].'</div>';
                                                }
                                            echo '</div>';
                                        
                                        echo '</div>';
                                        if(isset($item['price-list'])):
                                            foreach( $item['price-list'] as $itemPrice ){
                                                echo '<div class="mac-menu-table-item-price">'.$itemPrice['price'].'</div>';
                                            }
                                        endif;
                                        echo '</div>';
                                    }
                                }
                                echo '</div>';

                            ?>
                        </div>
                    </div><!-- cat-menu-table -->
                </div>
            <?php return ob_get_clean();
        }
        
    }
}
