<?php
class user_payment_details_list_table extends WP_List_Table {
    function __construct(){
        global $status, $page;

        parent::__construct(array(
            'singular' => '',
            'plural' => '',
            'ajax' => false
        ));
    }
    function column_default($item, $column_name){
        return $item[$column_name];
    }

//    function column_display_name($item){
//        $actions = array(
//            'edit' => sprintf('<a href="?page=edit-user-details&id=%s">%s</a>', $item['id'], __('Edit', 'user_payment_details')),
//            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['id'], __('Delete', 'user_payment_details')),
//        );
//
//        return sprintf('%s %s', $item['username'], $this->row_actions($actions));
//    }
//
//    function column_cb($item){
//        return sprintf(
//            '<input type="checkbox" name="id[]" value="%s" />',
//            $item['id']
//        );
//    }

    function get_columns(){
        $columns = array(
//            'cb' => '<input type="checkbox" />', 
            'username' => __('Name', 'user_payment_details'),
            'package_name' => __('Package Name', 'user_payment_details'),
            'payment_date' => __('Payment Date', 'user_payment_details')
        );
        return $columns;
    }

    function get_sortable_columns(){
        $sortable_columns = array(
            'username' => array('username', true),
            'package_name' => array('package_name', false),
            'payment_date' => array('paymnet_date', false)
        );
        return $sortable_columns;
    }

//    function get_bulk_actions(){
//        $actions = array(
//            'delete' => 'Delete'
//        );
//        return $actions;
//    }

//    function process_bulk_action(){
//        global $wpdb, $table_name_users;
//
//        if ('delete' === $this->current_action()) {
//            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
//            if (is_array($ids)) $ids = implode(',', $ids);
//
//            if (!empty($ids)) {
//                $wpdb->query("DELETE FROM $table_name_users WHERE id IN($ids)");
//            }
//        }
//    }
    function prepare_items(){
        global $wpdb, $table_name_users;
        $user = get_current_user_id();
        $screen = get_current_screen();
        $option = $screen->get_option('per_page', 'option');
        $per_page = get_user_meta($user, $option, true);

        if ( empty ( $per_page) || $per_page < 1 ) {
            $per_page = $screen->get_option( 'per_page', 'default');
        }
        $this->_column_headers = $this->get_column_info();
        //$this->process_bulk_action();
        $args = array(
                'posts_per_page' => $per_page,
                'orderby' => 'id',
                'order' => 'DESC',
                'offset' => ( $this->get_pagenum() - 1 ) * $per_page );
        $where = '';
        if (isset($_REQUEST['s']) && ! empty( $_REQUEST['s'] ) ){
            $where = " WHERE u.display_name LIKE '%%".$_REQUEST['s']."%%' OR p.post_title LIKE '%%".$_REQUEST['s']."%%' OR date_format(up.payment_date, '%D %b, %Y at %l:%i %p') LIKE '%%".$_REQUEST['s']."%%'";
        }
        if ( ! empty( $_REQUEST['orderby'] ) ) {
            if ( 'username' == $_REQUEST['orderby'] ){
                $args['orderby'] = 'username';
            }
            elseif ( 'package_name' == $_REQUEST['orderby'] ){
                $args['orderby'] = 'package_name';
            }
            elseif ( 'payment_date' == $_REQUEST['orderby'] ){
                $args['orderby'] = 'payment_date';
            }
        }
        
        if ( ! empty( $_REQUEST['order'] ) ) {
            if ( 'asc' == strtolower( $_REQUEST['order'] ) ){
                $args['order'] = 'ASC';
            }
            elseif ( 'desc' == strtolower( $_REQUEST['order'] ) ){
                $args['order'] = 'DESC';
            }
        }
        $query = "SELECT u.display_name as username, p.post_title as package_name, date_format(up.payment_date, '%D %b, %Y at %l:%i %p') as payment_date, up.id FROM $table_name_users as up inner join wp_users as u on up.id_user = u.ID inner join wp_posts as p on up.id_package = p.ID";
        $this->items = $wpdb->get_results("$query $where ORDER BY ".$args['orderby']." ".$args['order']." LIMIT $per_page OFFSET ".$args['offset'], ARRAY_A);
        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name_users $where");
        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'total_pages' => ceil($total_items / $per_page),
            'per_page' => $per_page
        ));
    }
}

?>
