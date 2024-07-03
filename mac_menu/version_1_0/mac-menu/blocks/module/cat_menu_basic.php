<?php
if (!class_exists('Mac_Category_Menu')) {
    class Mac_Category_Menu {
        function render($catMenuAttr) {
            $id = $catMenuAttr['id'];
            $class = isset($catMenuAttr['class']) ? $catMenuAttr['class'] : "";
            $limit_item = isset($catMenuAttr['limit_item']) ? $catMenuAttr['limit_item'] : "";
            $objmacMenu = new macMenu();
            $isCat = $objmacMenu->find_cat_menu($id);
            ob_start();
            ?>
                <div id="<?= isset($isCat[0]->slug_category) ? $isCat[0]->slug_category : ''  ?>" class="module-category-menu<?= $class; ?>">
                    <div class="cat-menu-text">
                        <div class="cat-menu-head">
                            <?php if (isset($isCat[0]->category_name) && !empty($isCat[0]->category_name) ): ?>
                                <span class="cat-menu-name"><?= $isCat[0]->category_name ?></span>
                            <?php endif; ?>
                            <?php if (isset($isCat[0]->price) && !empty($isCat[0]->price) ): ?>
                                <div class="cat-menu-price"><?= $isCat[0]->price ?></div>
                            <?php endif; ?>
                        </div>
                        <?php if (isset($isCat[0]->category_description) && !empty($isCat[0]->category_description) ): ?>
                            <div class="cat-menu-description"><?= $isCat[0]->category_description ?></div>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($isCat[0]->featured_img) && !empty($isCat[0]->featured_img) ): ?>
                    <div class="cat-menu-img">
                        
                        <?php
                            echo getGalleryFromIds($isCat[0]->featured_img,'url');
                        ?>
                    </div>
                    <?php endif; ?>
                    <?php $json = isset($isCat[0]->group_repeater) ? $isCat[0]->group_repeater : ""; 
                        if( ($isCat[0]->group_repeater) != "[]"):
                    ?>

                    <div class="cat-menu-list-item mac-menu-basic" data-limit="<?= $limit_item ?>">
                            <?php 
                                $data = json_decode($json, true);
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
                                        
                                        if (isset($item['fullwidth']) && !empty($item['fullwidth'])) {
                                            echo '<div class="mac-menu-item">';
                                        }
                                        else{
                                            echo '<div class="mac-menu-item item-not-fw">';
                                        }
                                        
                                        if (isset($item['featured_img']) && !empty($item['featured_img'])) {
                                            echo '<div class="mac-menu-item-img">';
                                            echo '<img src="'.$item['featured_img'].'" alt="image">';
                                            echo '</div>';
                                        }
                                        echo '<div class="mac-menu-item-text">';
                                            echo '<div class="mac-menu-item-head">';
                                                if (isset($item['name']) && !empty($item['name'])) {
                                                    echo '<span class="mac-menu-item-name">'.$item['name'].'</span>';
                                                }
                                                if(isset($item['price-list'])):
                                                    foreach( $item['price-list'] as $itemPrice ){
                                                        echo '<div class="mac-menu-item-price">'.$itemPrice['price'].'</div>';
                                                    }
                                                endif;
                                            echo '</div>';
                                            if (isset($item['description']) && !empty($item['description'])) {
                                                echo '<div class="mac-menu-item-description">'.$item['description'].'</div>';
                                            }
                                            echo '</div>';
                                        echo '</div><!-- cat-menu-item -->';
                                        
                                    }
                                }

                            ?>
                    </div><!-- cat-menu-list-item -->
                    <?php endif; ?>
                </div>
            <?php return ob_get_clean();
        }
        
    }
}
?>