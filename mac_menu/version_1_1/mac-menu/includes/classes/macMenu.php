<?php
class macMenu {
    private $_cat_menu = '';
    public function __construct(){
        global $wpdb;
        $this->_cat_menu = $wpdb->prefix.'mac_cat_menu';
    }
    /* list cat */
    public function all_cat(){
        global $wpdb;
        $sql = "SELECT * FROM $this->_cat_menu ORDER BY `order` ASC";
        $items = $wpdb->get_results($sql);
        return $items;
    }
    public function find_cat_menu($id){
        global $wpdb;
        $sql = "SELECT * FROM $this->_cat_menu WHERE `id` = $id";
        $items = $wpdb->get_results($sql);
        return $items;
    }
    public function save_cat($data){
        global $wpdb;
        $wpdb->insert($this->_cat_menu, $data);
        $lastId = $wpdb->insert_id;
        $item = $this->find_cat_menu($lastId);
        return $item;
    }
    public function update_cat($id,$data){
        global $wpdb;
        
        $wpdb->update($this->_cat_menu, $data, [
            'ID' => $id
        ]);
        
        $result = $this->find_cat_menu($id);
        return $result;
    }
    public function destroy_Cat($id){
        global $wpdb;
        $wpdb->delete($this->_cat_menu,[
            'id' => $id
        ]);
        return true;
    }
    public function paginate_cat($limit = 10){
        global $wpdb;

        $s = isset( $_REQUEST['s'] ) ? $_REQUEST['s'] : '';
        $paged = isset( $_REQUEST['paged'] ) ? $_REQUEST['paged'] : 1;

        // Lấy tổng số records
        $sql = "SELECT count(id) FROM $this->_cat_menu ";
        // Tim kiếm
        if( $s ){
            $sql .= " AND ( id LIKE '%$s%' )";
        }
        $total_items = $wpdb->get_var($sql);
        
        // Thuật toán phân trang
        /*
        Limit: limit
        Tổng số trang: total_pages
        Tính offset
        */
        $total_pages    = ceil( $total_items / $limit );
        $offset         = ( $paged * $limit ) - $limit;

        $sql = "SELECT * FROM $this->_cat_menu WHERE `parents_category` = '0'";
        //$sql = "SELECT * FROM $this->_cat_menu ";
        // Tim kiếm
        if( $s ){
            $sql .= " AND ( id LIKE '%$s%' )";
        }
        $sql .= " ORDER BY `order` ASC";
        $sql .= " LIMIT $limit OFFSET $offset";


        $items = $wpdb->get_results($sql);

        return [
            'total_pages'   => $total_pages,
            'total_items'   => $total_items,
            'items'         => $items
        ];

    }
    /* all  */
    public function all_cat_by_not_is_table(){
        global $wpdb;
        $sql = "SELECT *
                FROM $this->_cat_menu WHERE 
                `is_table` = '0' ORDER BY `order` ASC ";

        $items = $wpdb->get_results($sql);
        return $items;
    }
    public function all_cat_menu_has_item(){
        global $wpdb;
        /*$sql = "SELECT *
                FROM $this->_cat_menu
                LEFT JOIN $this->_menu 
                ON $this->_cat_menu.id = $this->_menu.id ";*/

        $sql = "SELECT *
        FROM $this->_cat_menu WHERE `parents_category` = '0' and `is_hidden` = '0' ORDER BY `order` ASC";

        $items = $wpdb->get_results($sql);
        return $items;
    }
    public function all_cat_by_parent_cat_menu($id){
        global $wpdb;
        $sql = "SELECT *
                FROM $this->_cat_menu WHERE 
                `parents_category` = $id ORDER BY `order` ASC ";

        $items = $wpdb->get_results($sql);
        return $items;
    }
    public function change_status($order_id,$status){
        global $wpdb;
        $wpdb->update(
            $this->_menu, 
            [
                'status' => $status
            ], 
            [
                'id' => $order_id
            ]
        );
        return true;
    }
    public function change_position($id,$position){
        global $wpdb;
        // Lấy danh sách vị trí mới từ dữ liệu gửi từ máy khách
        // Cập nhật cơ sở dữ liệu với vị trí mới
       
        $wpdb->update(
            $this->_cat_menu, 
            
            [
                'order' => $position
            ],
            [
                'ID' => $id
            ]
        );
        
        return true;
    }
    public function change_position_cat($id,$position){
        global $wpdb;
        // Lấy danh sách vị trí mới từ dữ liệu gửi từ máy khách
        // Cập nhật cơ sở dữ liệu với vị trí mới
       
        $wpdb->update(
            $this->_menu, 
            
            [
                'order' => $position
            ],
            [
                'ID' => $id
            ]
        );
        
        return true;
    }
}