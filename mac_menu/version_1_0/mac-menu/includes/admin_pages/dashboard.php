
<div id="post-body" style="margin-top: 50px;">
    <?php 
        global $wpdb;
        // Tên bảng
        $cattablename = $wpdb->prefix . 'mac_cat_menu';
        // Kiểm tra sự tồn tại của bảng
        $table_exists_query = $wpdb->prepare("SHOW TABLES LIKE %s", $cattablename);
        $table_exists = $wpdb->get_var($table_exists_query);
        if ($table_exists === $cattablename):
            ?>
                <div class="form-add-cat-menu">
                    <h2> data exists! Please delete it to import </h2>
                    <form action="" method="post" id="posts-filter" style="visibility: hidden;">
                        <input id="input-delete-data" type="text" data-table="<?= $cattablename ?>" name="delete_data" value="" readonly>
                        <input id="input-export-table-data" type="text" name="export_table_data" value="" readonly>
                        <input type="submit" name="submit-delete-data" > 
                    </form>
                    <!-- <button id="export-table-data">Export Data</button> -->
                    <button type="button" class="btn-delete-menu">Delete Data</button>
                </div>
                <!-- -->
                <div class="overlay" id="overlay"></div>
                <div class="confirm-dialog" id="confirmDialog" >
                    <p>Are you sure want delete data?</p>
                    <div class="btn-wrap">
                        <div id="confirmOk">OK</div>
                        <div id="confirmCancel">Cancel</div>
                    </div>
                </div>
            <?php
        else:
            ?>
                <div class="form-add-cat-menu">
                    <h2> Form Import Data Category Menu</h2>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="file" name="csv_file_cat">
                        <input type="submit" name="submit-cat" value="submit">
                    </form>
                </div>
            <?php
        endif;
    ?>
</div>
<?php

$exportTableData = (isset($_REQUEST['export_table_data']) && $_REQUEST['export_table_data'] != '') ? $_REQUEST['export_table_data'] : '';

if ( $exportTableData != '') {
    global $wpdb;
    $table_name = $exportTableData;
    $data = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
    if (!empty($data)) {
        $output = fopen('php://output', 'w');
        // Thêm dòng tiêu đề
        fputcsv($output, array_keys($data[0]));
        // Thêm dữ liệu
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit();
    }
}

$deleteData = (isset($_REQUEST['delete_data']) && $_REQUEST['delete_data'] != '') ? $_REQUEST['delete_data'] : '';
if($deleteData != '') {
    $sql = "DROP TABLE IF EXISTS $deleteData";
    $wpdb->query( $sql );
    mac_redirect('admin.php?page=mac-menu');
    exit();
}
if(isset($_POST['submit-cat'])) :
    if  (!empty($_FILES['csv_file_cat'])  && $_FILES['csv_file_cat']['error'] === UPLOAD_ERR_OK ) {
        $csv_file = $_FILES['csv_file_cat'];
        $tmp_name = $csv_file["tmp_name"];
        // Đọc nội dung từ file CSV
        $handle = fopen($tmp_name, "r");
        // Kiểm tra xem file có tồn tại không
        if ($handle === FALSE) {
            die("Failed to open uploaded file.");
        }
        $header = array_flip(fgetcsv($handle)); // Read header row
        // Đọc từng dòng của file CSV và xử lý dữ liệu
        $itemMenuIndex = 0;
        $dataArray = [];
        while (($row = fgetcsv($handle)) !== FALSE) {
            if(!empty($row[$header['category_name']])){
                $dataArray[$itemMenuIndex] = [
                    "category_name" => $row[$header['category_name']],
                    "slug_category" => '',
                    "category_description" => $row[$header['category_description']],
                    "price" => $row[$header['price']],
                    "featured_img" => $row[$header['featured_img']],
                    "parents_category" => !empty($row[$header['parents_category']]) ? $row[$header['parents_category']] : "0" ,
                    "group_repeater" => [],
                    "is_table" => !empty($row[$header['is_table']]) ? $row[$header['is_table']] : "0",
                    "is_hidden" => !empty($row[$header['is_hidden']]) ? $row[$header['is_hidden']] : "0",
                    "data_table" => $row[$header['table_heading']],
                    "order" => '',
                ];
                if (!empty($row[$header['item_list_name']])) {
                    $dataArray[$itemMenuIndex]['group_repeater'][] = [
                        "name" => $row[$header['item_list_name']],
                        "featured_img" => $row[$header['item_list_img']],
                        "description" => $row[$header['item_list_description']],
                        "fullwidth" => $row[$header['item_list_fw']], 
                        "price-list" => create_array($row[$header['item_list_price']],'price')
                    ];
                }
                $itemMenuIndex++;
            }else{
                
                if (!empty($row[$header['item_list_name']])) {
                    $dataArray[($itemMenuIndex - 1)]['group_repeater'][] = [
                        "name" => $row[$header['item_list_name']],
                        "featured_img" => $row[$header['item_list_img']],
                        "description" => $row[$header['item_list_description']],
                        "fullwidth" => $row[$header['item_list_fw']], 
                        "price-list" => create_array($row[$header['item_list_price']],'price')
                    ];
                }
            }
        }
        fclose($handle);
        include 'table-list-menu.php';
        plugin_cat_table($dataArray);
    }else{
        echo 'Upload False';
    }
endif;
?>