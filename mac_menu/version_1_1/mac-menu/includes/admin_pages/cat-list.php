<?php

    $objmacMenu = new macMenu();
    $result = $objmacMenu->paginate_cat(10);
    extract($result);

    $action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';
    
    if( $action == 'trash' ){
        $Ids = $_REQUEST['post'];
        if( count( $Ids ) ){
            foreach( $Ids as $Id ){
                $objmacMenu->trash($Id);
            }
        }
        mac_redirect('admin.php?page=mac-cat-menu');
        exit();
    }elseif( $action == 'destroy_Cat' ){
        if(isset($_REQUEST['post']) && !empty($_REQUEST['post']) ) :
            $Ids = $_REQUEST['post'];
            if( count( $Ids ) ){
                foreach( $Ids as $Id ){
                    $objmacMenu->destroy_Cat($Id);
                }
            }
            mac_redirect('admin.php?page=mac-cat-menu');
            exit();
        else:
            ?>
            <div class="overlay" id="overlay" style="display: block;"></div>
            <div class="confirm-dialog" id="confirmDialog" style="display: block;">
                <p>Please checkbox the menu!</p>
                <div class="btn-wrap">
                    <div id="confirmCancel">OK</div>
                </div>
            </div>
            <?php
        endif;
    }elseif( $action == 'save_position' ){
        if(isset($_REQUEST['post']) && !empty($_REQUEST['post']) ) :
            $Ids = $_REQUEST['post'];
            $index = 0;
            if( count( $Ids ) ){
                
                foreach( $Ids as $Id ){
                $objmacMenu->change_position($Id,$index);
                    $index++;
                }
            }
            mac_redirect('admin.php?page=mac-cat-menu');
            exit();
        else:
            ?>
            <div class="overlay" id="overlay" style="display: block;"></div>
            <div class="confirm-dialog" id="confirmDialog" style="display: block;">
                <p>Please checkbox the menu!</p>
                <div class="btn-wrap">
                    <div id="confirmCancel">OK</div>
                </div>
            </div>
            <?php
        endif;
    }
?>
<div class="wrap">
    <h1 class="wp-heading-inline"><?= __('Manage Cat Menu','mac-plugin');?></h1>
    <hr class="wp-header-end">
    <ul class="subsubsub">
        <li class="all"><a href="admin.php?page=mac-cat-menu" class="current"><?= __('All','mac-plugin');?> <span class="count">(<?= $total_items; ?>)</span></a>
            |</li>
        <li class="publish"><a href="admin.php?page=mac-cat-menu&id=new"><?= __('New Cat Menu','mac-plugin');?></a></li>
    </ul>
    <form id="posts-filter" method="get" action="" >
        <input type="hidden" name="page" value="mac-cat-menu">
        <!-- <input type="hidden" name="paged" value="1"> -->
        <div class="tablenav top">
            <div class="alignleft actions bulkactions">
                <label for="bulk-action-selector-top" class="screen-reader-text">Lựa chọn thao tác hàng loạt</label>
                <select name="action" id="bulk-action-selector-top">
                    <option value="-1">Action</option>
                    <option value="save_position">Save Position</option>
                    <option value="destroy_Cat">Delete</option>
                </select>
                <input type="submit" id="doaction" class="button action" value="Apply">
            </div>

            <?php
            include 'paginate_cat.php';
            ?>
            <br class="clear">
        </div>
        <h2 class="screen-reader-text">List Category</h2>
        <!-- id="sortable" -->
        <table class="sortable wp-list-table widefat fixed striped table-view-list posts">
            <thead>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1">Choose All</label>
                        <input id="cb-select-all-1" type="checkbox">
                    </td>
                    <th class="manage-column">Name</th>
                    <th class="manage-column">Table</th>
                </tr>
            </thead>
            <tbody id="the-list">
                <?php $index = 0; ?>
                <?php foreach( $items as $item ): ?>
                <?php if (isset($item->id) ): ?>
                <tr attr-id="<?= $item->id; ?>" class="iedit status-publish hentry">
                    <th scope="row" class="check-column">
                        <input id="cb-select-<?= $item->id; ?>" type="checkbox" name="post[]" value="<?= $item->id; ?>">
                    </th>
                    <td class="position" order=""><a class="row-title" href="admin.php?page=mac-cat-menu&id=<?= $item->id;?>"><?= $item->category_name; ?></a></td>
                    <td>
                        <?php  if( isset($item->is_table) && ($item->is_table == '1') ):
                            echo 'Enable';
                        else:
                            echo 'Disable';
                        endif;
                        ?>
                    
                    </td>
                </tr>
                <?php $index++; ?>
                <?php endif; ?>
                <?php endforeach;?>
                <div class="mac-order-data" name="order-data" value="0"></div>
            </tbody>
            <tfoot>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text"
                            for="cb-select-all-1">Choose All</label><input id="cb-select-all-1" type="checkbox"></td>
                    <th class="manage-column">Name</th>
                    <th class="manage-column">Table</th>
                </tr>
            </tfoot>
        </table>
        <div class="tablenav bottom">
            <div class="alignleft actions bulkactions">
                <label for="bulk-action-selector-bottom" class="screen-reader-text">Lựa chọn thao tác hàng loạt</label>
                <select name="action2" id="bulk-action-selector-bottom">
                    <option value="-1">Action</option>
                    <option value="save_position">Save Position</option>
                    <option value="destroy_Cat">Delete</option>
                </select>
                <input type="submit" id="doaction2" class="button action" value="Apply">
            </div>
            <div class="alignleft actions">
            </div>

            <?php include 'paginate_cat.php'; ?>
            <br class="clear">
        </div>
    </form>
</div>