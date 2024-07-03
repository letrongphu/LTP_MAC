<?php
if (!class_exists('Mac_Cat_HTML')) {
    class Mac_Cat_HTML {
        function render($catAttr) {
            ob_start();
            $id = $catAttr['id_category'];
            $objmacMenu = new macMenu();
            if( isset($id) && $id != 'new' ){
                $itemCatMenu = $objmacMenu->find_cat_menu($id);
            }else{
                $itemCatMenu = array();
            }
            ?>
            <table class="form-table">
                <tr style="display: none;">
                    <td>ID</td>
                    <td><input name="form_cat[id][]" class="large-text id-cat-menu" value="<?= isset($itemCatMenu[0]->id) ? $itemCatMenu[0]->id : "" ; ?>" readonly></input></td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><input name="form_<?= $id; ?>_category_name" class="large-text" value="<?= isset($itemCatMenu[0]->category_name) ? $itemCatMenu[0]->category_name : "" ; ?>"> </input></td>
                </tr>
                <tr>
                    <td>Slug</td>
                    <td><input name="form_<?= $id; ?>_slug_category" class="large-text" value="<?= isset($itemCatMenu[0]->slug_category) ? $itemCatMenu[0]->slug_category : "" ; ?>"> </input></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name="form_<?= $id; ?>_category_description" rows="5" class="large-text"><?= isset($itemCatMenu[0]->category_description) ? esc_html($itemCatMenu[0]->category_description) : "" ; ?> </textarea></td>
                </tr>

                <tr>
                    <td>Price</td>
                        <td><input name="form_<?= $id; ?>_price" class="large-text" value="<?= isset($itemCatMenu[0]->price) ? $itemCatMenu[0]->price : "" ; ?>"> </input></td>
                </tr>
                <tr>
                    <td>Featured Image</td>
                    <td class="mac-gallery-wrap" >
                        <button class="upload-gallery-button">Upload Images</button>
                        <?php if( isset($itemCatMenu[0]->featured_img) && !empty($itemCatMenu[0]->featured_img) ):?> 
                        <div class="gallery mac-gallery-list">
                            <?php 
                                echo ''.getGalleryFromIds($itemCatMenu[0]->featured_img);
                            ?>
                        </div>
                        <input type="hidden" class="image-attachment-ids" name="form_<?= $id; ?>_featured_img" value="<?= $itemCatMenu[0]->featured_img; ?>">
                        <?php else: ?>
                            <div class="gallery mac-gallery-list"></div>
                            <input type="hidden" class="image-attachment-ids" name="form_<?= $id; ?>_featured_img" value="">
                        <?php endif; ?> 
                    </td>
                </tr>       
                <tr>
                    <td>Parent</td>
                    <?php
                        $id_category_parent = isset( $_GET['id_child'] ) ? $_GET['id_child'] : "";
                        $parents_category = '';
                        if ($id_category_parent != "") {
                            $parents_category = $id_category_parent;
                        }else {
                            $parents_category = isset($itemCatMenu[0]->parents_category) ? $itemCatMenu[0]->parents_category : "0";
                        }
                    ?>
                    <?php 
                        $allCat = $objmacMenu->all_cat();//all_cat_by_not_is_table
                    ?>
                    <td>
                        <select class="mac-is-selection-parents" name="form_<?= $id; ?>_parents_category">
                            <option value="0" <?= ($parents_category == 0) ? "selected" : ""  ?>>Null</option>
                            
                            <?php foreach( $allCat as $item ): ?>
                                <?php if($item->parents_category == "0"): ?>
                                <option value="<?= $item->id; ?>" <?= ($parents_category == $item->id) ? "selected" : ""  ?>><?= $item->category_name; ?></option>
                                    <?php foreach( $allCat as $i ): ?>
                                        <?php if($i->parents_category == $item->id): ?>
                                        <option class="child-cat-<?= $item->id; ?>" value="<?= $i->id; ?>" <?= ($parents_category == $i->id) ? "selected" : ""  ?>>&nbsp;-<?= $i->category_name; ?></option>
                                            <?php foreach( $allCat as $y ): ?>
                                                <?php if($y->parents_category == $i->id): ?>
                                                <option class="child-cat-<?= $i->id; ?>" value="<?= $y->id; ?>" <?= ($parents_category == $y->id) ? "selected" : ""  ?>>&nbsp;&nbsp;--<?= $i->category_name; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Hidden Menu</td>
                    <td>
                        <div class="mac-switcher-wrap mac-switcher-btn<?= (isset($itemCatMenu[0]->is_hidden) && ($itemCatMenu[0]->is_hidden == '1' )) ? ' active' : ''  ?>">
                            <span class="mac-switcher-true">On</span>
                            <span class="mac-switcher-false">Off</span>
                            <input type="text" name="form_<?= $id; ?>_is_hidden" value="<?= isset($itemCatMenu[0]->is_hidden) ? $itemCatMenu[0]->is_hidden : "0"  ?>" readonly/>
                        </div>
                    </td>
                </tr>
                <?php $data_table = !empty( $itemCatMenu[0]->data_table) ? json_decode($itemCatMenu[0]->data_table, true) : []; ?>
                <tr>
                    <td>On / Off Table Layout</td>
                    <td>
                        <div class="mac-is-table mac-switcher-wrap mac-switcher-btn<?= (isset($itemCatMenu[0]->is_table) && ($itemCatMenu[0]->is_table == '1' )) ? ' active' : ''  ?>">
                            <span class="mac-switcher-true">On</span>
                            <span class="mac-switcher-false">Off</span>
                            <input type="text" name="form_<?= $id; ?>_is_table" value="<?= isset($itemCatMenu[0]->is_table) ? $itemCatMenu[0]->is_table : "0"  ?>" readonly/>
                        </div>
                    </td>
                </tr>
                <tr class="mac-table-total-col">
                    <td>Table Col </td>
                    <td>
                        <?php $totalColNumber = 1; if(isset($data_table) ): $totalColNumber = count($data_table);  endif; ?>
                        <select class="mac-is-selection">
                            <option value="1" <?= ($totalColNumber == 1) ? "selected" : ""  ?>>1</option>
                            <option value="2" <?= ($totalColNumber == 2) ? "selected" : ""  ?>>2</option>
                            <option value="3" <?= ($totalColNumber == 3) ? "selected" : ""  ?>>3</option>
                            <option value="4" <?= ($totalColNumber == 4) ? "selected" : ""  ?>>4</option>
                            <option value="5" <?= ($totalColNumber == 5) ? "selected" : ""  ?>>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="mac-table-col-heading">
                    <td>Heading Name Col</td>
                    <td>
                        <table class="data_table">
                            <tr> 
                                <?php if(isset($data_table) && !empty($data_table) ): ?>
                                    <?php foreach($data_table as $item => $value ): 
                                        ?>
                                        <td>
                                            <lable>Heading Name</lable>
                                            <input name="form_<?= $id; ?>_table_col[]" class="large-text" value="<?= isset($value) ? $value : ''; ?>"> </input>
                                        </td>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <td>
                                        <lable>Heading Name</lable>
                                        <input name="form_<?= $id; ?>_table_col[]" class="large-text" value=""> </input>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td> List item Menu </td>
                    <td>
                    <?php  $group_repeater = !empty( $itemCatMenu[0]->group_repeater) ? json_decode($itemCatMenu[0]->group_repeater, true) : []; ?>
                        <div class="form-repeater" name="form_<?= $id; ?>_form-repeater">
                            <div data-repeater-list="form_<?= $id; ?>_group-repeater" class="repeater-list-item sortable">
                                <?php if ( !empty($group_repeater) ): ?>
                                    <div class="mac-first-item-hidden" data-repeater-item >
                                        <div class="repater-item-wrap">
                                            <input data-repeater-delete type="button" value="Delete"/>
                                            <div class="mac-list-heading mac-collapsible mac-collapsible-btn">
                                                <h4 class="mac-heading-title"></h4>
                                                <div class="mac-heading-button "><span>+</span><span>-</span></div>
                                            </div>
                                            <div class="content">
                                                <label>Name: </label>
                                                <input type="text" name="name" />
                                                <label>Image: </label>
                                                <div class="mac-add-media">
                                                    <input type="text" class="custom_media_url" name="featured_img" size="25" value="" readonly style="display:none"/>
                                                    <button type="button" class="add_media_button">Add Media</button>
                                                    <button type="button" class="remove_media_button" style="display: none;">Remove img</button>
                                                    <img class="media_preview" src="" style="max-width: 200px; display:none;" alt="featured-img" />
                                                </div>
                                                <label>Description: </label>
                                                <textarea type="textarea" name="description" value="" rows="10" cols="20"></textarea>
                                                <label>FullWidth: </label>

                                                <div class="mac-switcher-wrap mac-switcher-btn">
                                                    <span class="mac-switcher-true">On</span>
                                                    <span class="mac-switcher-false">Off</span>
                                                    <input type="text" name="fullwidth" value="0" readonly/>
                                                </div>

                                                <div class="price-list">
                                                    <div class="form-repeater-child">
                                                        <div data-repeater-list="price-list" class="repeater-list-item">
                                                            <div data-repeater-item>
                                                                <label>Price: </label>
                                                                <input type="text" name="price" value=""/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- mac-first-item-hidden -->
                                    <?php 
                                        $htmlItemRepeater = '';
                                        foreach($group_repeater as $itemRepeater) {

                                            $checkedFW = '0';
                                            $checkedFWText = '';

                                            $htmlImg = '';

                                            if( !empty($itemRepeater['fullwidth']) ) {
                                                $checkedFW = '1';
                                                $checkedFWText = ' active';
                                            }

                                            if( !empty($itemRepeater['featured_img']) ) {
                                                $htmlImg .= '<input type="text" class="custom_media_url" name="featured_img" size="25" value="'.$itemRepeater['featured_img'].'" readonly style="display:none" />';
                                                $htmlImg .= '<button type="button" class="add_media_button">Add Media</button>';
                                                $htmlImg .= '<button type="button" class="remove_media_button" style="">Remove img</button>';
                                                $htmlImg .= '<img class="media_preview" src="'.$itemRepeater['featured_img'].'" style="max-width: 200px; " alt="featured-img" />';
                                            }else{
                                                $htmlImg .= '<input type="text" class="custom_media_url" name="featured_img" size="25" value=""  readonly style="display:none"/>';
                                                $htmlImg .= '<button type="button" class="add_media_button">Add Media</button>';
                                                $htmlImg .= '<button type="button" class="remove_media_button" style="display:none;">Remove img</button>';
                                                $htmlImg .= '<img class="media_preview" src="" style="max-width: 200px; display:none;" alt="featured-img" />';
                                            }
                                            $htmlItemRepeater .= '<div data-repeater-item>';
                                                $htmlItemRepeater .= '<div class="repater-item-wrap">';
                                                
                                                    $htmlItemRepeater .= '<input data-repeater-delete type="button" value="Delete"/>';
                                                    $htmlItemRepeater .= '<div class="mac-list-heading mac-collapsible mac-collapsible-btn">';
                                                        $htmlItemRepeater .= '<h4 class="mac-heading-title">'.$itemRepeater['name'].'</h4>';
                                                        $htmlItemRepeater .= '<div class="mac-heading-button"><span>+</span><span>-</span></div>';
                                                    $htmlItemRepeater .= '</div>';

                                                    $htmlItemRepeater .= '<div class="content">';
                                                        $htmlItemRepeater .= '<label>Name: </label>';
                                                        $htmlItemRepeater .= '<input type="text" name="name" value="'.$itemRepeater['name'].'" />';
                                                        
                                                        $htmlItemRepeater .= '<label>Image: </label>';
                                                        $htmlItemRepeater .= '<div class="mac-add-media">';
                                                            
                                                            $htmlItemRepeater .= $htmlImg;
                                                        $htmlItemRepeater .= '</div>';
                                                        $htmlItemRepeater .= '<label>Description: </label>';
                                                        $htmlItemRepeater .= '<textarea type="textarea" name="description" value="" rows="10" cols="20">'.$itemRepeater['description'].'</textarea>';
                                                        $htmlItemRepeater .= '<label>FullWidth: </label>';

                                                        $htmlItemRepeater .= '<div class="mac-switcher-wrap mac-switcher-btn'.$checkedFWText.'">';
                                                            $htmlItemRepeater .= '<span class="mac-switcher-true">On</span>';
                                                            $htmlItemRepeater .= '<span class="mac-switcher-false">Off</span>';
                                                            $htmlItemRepeater .= '<input type="text" name="fullwidth" value="'.$checkedFW.'" readonly/>';
                                                        $htmlItemRepeater .= '</div>';

                                                        $htmlItemRepeater .= '<div class="price-list">';
                                                            $htmlItemRepeater .= '<div class="form-repeater-child">';
                                                            $htmlItemRepeater .= '<div data-repeater-list="price-list" class="repeater-list-item">';

                                                            foreach($itemRepeater['price-list'] as $itemPrice) {
                                                                    $htmlItemRepeater .= '<div data-repeater-item>';
                                                                    $htmlItemRepeater .= '<label>Price: </label>';
                                                                    $htmlItemRepeater .= '<input type="text" name="price" value="'.$itemPrice['price'].'"/>';
                                                                    $htmlItemRepeater .= '</div>';
                                                            }
                                                                    $htmlItemRepeater .= '</div>';
                                                            $htmlItemRepeater .= '</div>';
                                                        $htmlItemRepeater .= '</div> <!-- price-list -->';
                                                        $htmlItemRepeater .= '</div>';
                                                    $htmlItemRepeater .= '</div>';
                                            $htmlItemRepeater .= '</div><!-- htmlItemRepeater -->';

                                        }
                                    echo $htmlItemRepeater;
                                    ?>
                                <?php else: ?>   
                                <div data-repeater-item>
                                    <div class="repater-item-wrap">
                                        
                                        <input data-repeater-delete type="button" value="Delete"/>
                                        <div class="mac-list-heading mac-collapsible mac-collapsible-btn">
                                            <h4 class="mac-heading-title"></h4>
                                            <div class="mac-heading-button"><span>+</span><span>-</span></div>
                                        </div>
                                        <div class="content">
                                            <label>Name: </label>
                                            <input type="text" name="name" />
                                            
                                            <label>Image: </label>
                                            <div class="mac-add-media">
                                                <input type="text" class="custom_media_url" name="featured_img" size="25" value=""  readonly style="display:none" />
                                                <button type="button" class="add_media_button">Add Media</button>
                                                <button type="button" class="remove_media_button" style="display: none;">Remove img</button>
                                                <img class="media_preview" src="" style="max-width: 200px; display:none;" alt="featured-img" />
                                            </div>
                                            <label>Description: </label>
                                            <textarea type="textarea" name="description" value="" rows="10" cols="20"></textarea>
                                            <label>FullWidth: </label>
                                            <div class="mac-switcher-wrap mac-switcher-btn">
                                                <span class="mac-switcher-true">On</span>
                                                <span class="mac-switcher-false">Off</span>
                                                <input type="text" name="fullwidth" value="0" readonly/>
                                            </div>
                                            <div class="price-list">
                                                <div class="form-repeater-child">
                                                    <div data-repeater-list="price-list" class="repeater-list-item">
                                                        <div data-repeater-item>
                                                            <label>Price: </label>
                                                            <input type="text" name="price" value=""/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <input data-repeater-create type="button" value="Add"/>
                        </div>
                    <td>
                </tr>
            </table>

            <?php return ob_get_clean();
        }
        
    }
}




