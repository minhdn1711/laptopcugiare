<?php
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class KP_UserPoint_Table extends WP_List_Table
{
    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items()
    {

        $user_search_key = isset( $_REQUEST['s'] ) ? wp_unslash( trim( $_REQUEST['s'] ) ) : '';
    
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data($user_search_key);
        usort( $data, array( &$this, 'sort_data' ) );

        $perPage = 30;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );

        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns()
    {
        $columns = array(
            'user_id'          => 'ID Tài khoản',       
            'user_name'          => 'Tên tài khoản',       
            'balance'          => 'Số dư',       
        );

        return $columns;
    }

    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array();
    }

    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
        return array(
            'user_id' => array('user_id', false),
            'balance' => array('balance', false),
        );
    }

    function get_list_user($search = ""){
        $args = array ( 'orderby' => 'user_id', 'order' => 'DESC' );
        if($search){
            $args["search"] = "*".$search."*";
            //$args["search_columns"] = array( 'user_login', 'user_email' );
        }
        $users = new WP_User_Query( $args );

        return  $users->get_results();
    }


    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data($search = "")
    {
        $data = array();

        $list_user = $this->get_list_user($search);
        $list_user = $list_user ? $list_user : array();
        foreach ($list_user as  $user) {
            $user_point = new KPoint($user->ID);
            $data[] = array(
                'user_id'          => $user->ID,
                'user_name'          => $user->display_name,
                'balance'          => $user_point->get_balance(),
            );

        }

        
        return $data;
    }

    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item        Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default( $item, $column_name )
    {

       
        $current_val = $item[$column_name];
        switch( $column_name ) {
            case "balance":
                $user_id = $item["user_id"];
                $user_point = new KPoint($user_id);
                ob_start();
                ?>
                <div class="view-edit-wrapper" id="kp_user_id<?php echo  $user_id; ?>">
                    <div class="kp-view">
                        <div class="kp-value">
                            <?php  echo $user_point->display_balance(); ?> 
                            <span class="dashicons dashicons-edit kp_edit_user_point" data-user_id="<?php echo  $user_id; ?>"></span>
                        </div>
                        
                        
                    </div>
                    <div class="kp-edit" >
                        <input type="number" name="kp_new_value" value="<?php echo $user_point->get_balance(); ?>">
                        <input type="text" name="kp_update_note" placeholder="ghi chú cho user">
                        <?php wp_nonce_field('edit_point_' . $user_id); ?>
                        <button class="kp_update_user_point_btn" data-user_id="<?php echo  $user_id; ?>">
                            <span class='dashicons dashicons-saved'></span>
                        </button>
                        <br>
                        <p class="error"></p>

                    </div>
                </div>
                <?php
                return ob_get_clean();
                break;
            default:
                return $item[$column_name] ;
        }

        return "";
    }

    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b )
    {
        // Set defaults
        $orderby = 'balance';
        $order = 'desc';

        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }

        // If order is set use this as the order
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }


        $result = strcmp( $a[$orderby], $b[$orderby] );

        if($order === 'asc')
        {
            return $result;
        }

        return -$result;
    }
}