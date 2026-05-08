<?php

function kpoint_enqueue_admin_scripts( $hook ) {    
    wp_enqueue_style( 'kpoint_admin_scripts', KPOINT_PLUGIN_URL . 'admin/css/admin.css', array(), KPOINT_VERSION );
}
add_action( 'admin_enqueue_scripts', 'kpoint_enqueue_admin_scripts' );


add_filter('manage_edit-product_columns', 'kpoint_edit_product_columns',10, 1 ); 
add_filter('manage_edit-product_cat_columns', 'kpoint_edit_product_cat_columns',10, 1 ); 

add_action('manage_product_posts_custom_column', 'kpoint_diplay_product_custom_column', 10, 2 );    
add_action('manage_product_cat_custom_column', 'kpoint_diplay_product_cat_custom_column', 10, 3);    


add_action( 'product_cat_edit_form_fields', 'kpoint_product_cat_edit_meta_field', 10, 2 );
add_action( 'edited_product_cat', 'kpoint_save_taxonomy_custom_meta', 10, 2 );

function kpoint_save_taxonomy_custom_meta( $term_id ) {

    
    if ( isset( $_POST['kp_gift_amount'] ) ) {
        
        update_term_meta($term_id, 'kp_gift_amount', intval($_POST['kp_gift_amount']));
    }
}



function kpoint_product_cat_edit_meta_field($term) {

    $setting = Kpoint_Setting::instance();
    $type = $setting->get_setting('gif_point_type');

    if($type != "per_cat_and_product"){
        return;
    }
    // put the term ID into a variable
    $t_id = $term->term_id;
    // retrieve the existing value(s) for this meta field. This returns an array
    $amount = get_term_meta($t_id,'kp_gift_amount', true);
    
     ?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="kp_gift_amount"><?php _e( 'Điểm tặng', 'kpoint' ); ?></label></th>
        <td>
                <?php
                echo "<input type='number' value='$amount' name='kp_gift_amount' />"
                ?>
            <p class="description"><?php _e( 'Điểm tặng áp dụng cho sản phẩm trong danh mục này khi mua hàng','flatsome' ); ?></p>
        </td>
    </tr>
<?php
}


function kpoint_edit_product_columns( $columns ) {
    $setting = Kpoint_Setting::instance();
    $type = $setting->get_setting('gif_point_type');

    if($type == "per_cat_and_product"){
        $columns['kp_gift_point'] = 'Điểm Tặng';
    }
    
    return $columns;
}

function kpoint_edit_product_cat_columns( $columns ) {
    $setting = Kpoint_Setting::instance();
    $type = $setting->get_setting('gif_point_type');

    if($type == "per_cat_and_product"){
        $columns['kp_gift_point'] = 'Điểm Tặng';
    }
    
    return $columns;
}


function kpoint_diplay_product_custom_column( $column, $postid ) {
 
    if ( $column == 'kp_gift_point' ) {           

        $amount = get_post_meta($postid, "kp_gift_amount", true);
        if($amount){
            echo KPoint::get_display_balance($amount);
        }else{
            $setting = Kpoint_Setting::instance();
            $value = $setting->get_setting('gif_point_when_buy');
            echo $value ."%";
        }
    }
}

function kpoint_diplay_product_cat_custom_column( $value, $column_name, $tax_id ) {
  

    if ( $column_name == 'kp_gift_point' ) {           
        
        $amount = get_term_meta( $tax_id, 'kp_gift_amount', true );
        if($amount){
            
            echo KPoint::get_display_balance($amount);
        }else{
            $setting = Kpoint_Setting::instance();
            $value = $setting->get_setting('gif_point_when_buy');
            echo $value ."%";
        }
    }
}