<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_filter( 'woocommerce_payment_gateways', 'kpoint_add_getway' );

function kpoint_add_getway( $methods ) {
    global $kpoint_settings;
    if($kpoint_settings['using_enable_getway']){
        $methods[] = 'WC_Getway_KPoint';     
    }
    
    return $methods;
}


add_filter( 'woocommerce_available_payment_gateways', 'kpoint_check_hide_getway' );
add_filter( 'woocommerce_available_payment_gateways', 'kpoint_just_only_kpoint_getway' );


function kpoint_just_only_kpoint_getway( $available_gateways){
    if ( ! is_checkout() ) return $available_gateways;

    if(!isset($available_gateways['kpoint'])) return $available_gateways;

    $has_product_not_belong_only_getway = false;
    global $kpoint_settings;
    $only_getway_cats = $kpoint_settings["only_product_categories_for_gateway"];
    $only_getway_tags = $kpoint_settings["only_product_tags_for_gateway"];

    // check chi co duy nhat sp only getway
    // tat het getway khac
    if($only_getway_cats || $only_getway_tags){
        foreach ( WC()->cart->get_cart_contents() as $key => $values ) {
           
            $product_id = $values['product_id'];
            
            if( !has_term( $only_getway_cats, 'product_cat', $product_id )
            && !has_term( $only_getway_tags, 'product_tag', $product_id ) ){
                $has_product_not_belong_only_getway = true;
                break;
            }
        }
    }else{
        return $available_gateways;
    }
    

    if(!$has_product_not_belong_only_getway){
        foreach($available_gateways as $gateway_id => $gateway){
            if($gateway_id != "kpoint"){
                unset($available_gateways[$gateway_id]);
            }
        }        
    }
    
    return $available_gateways;
}

function kpoint_check_hide_getway( $available_gateways){
    if ( ! is_checkout() ) return $available_gateways;
    $unset = false;
    global $kpoint_settings;
    $getway_cats = $kpoint_settings["product_categories_for_gateway"];
    $getway_tags = $kpoint_settings["product_tags_for_gateway"];
    if($getway_tags || $getway_cats){
        foreach ( WC()->cart->get_cart_contents() as $key => $values ) {
           
            $product_id = $values['product_id'];
            if( !has_term( $getway_cats, 'product_cat', $product_id )
            && !has_term( $getway_tags, 'product_tag', $product_id ) ){
                $unset = true;
                break;
            }
        }
    }
    

    $woo_kpoint = WooKPoint::instance();

    if($woo_kpoint->check_has_buy_point_product_in_cart()){
        $unset = true;
    }

    if ( $unset == true ) unset( $available_gateways['kpoint'] );
    return $available_gateways;
}

add_action( 'plugins_loaded', 'kpoint_init_getway' );

function kpoint_init_getway(){
    class WC_Getway_KPoint extends WC_Payment_Gateway {

        /** @var bool Whether or not logging is enabled */
        public static $log_enabled = false;

        /** @var WC_Logger Logger instance */
        public static $log = false;

        /**
         * Constructor for the gateway.
         */
        public function __construct() {
            $this->id                 = 'kpoint';
            $this->has_fields         = true;
            //$this->order_button_text  = __( 'Thanh Toán', 'woocommerce' );
            $this->method_title       = __( 'Điểm K-Point' , 'woocommerce' );
            $this->method_description = 'Dùng điểm K-Point để thanh toán';
           
            $this->supports           = array(
                'products',
                'refunds',
            );
            // Load the settings.
            $this->init_form_fields();
            $this->init_settings();

            // Define user set variables.
            $this->title          = $this->get_option( 'title' );
            $this->description    = $this->get_option( 'description' );
            $this->testmode       = 'yes' === $this->get_option( 'testmode', 'no' );
            $this->debug          = 'yes' === $this->get_option( 'debug', 'no' );

            //$this->merchant_email          = $this->get_option( 'email' );
            self::$log_enabled    = $this->debug;


            
            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

            $this->enabled = $this->get_option( 'enabled' );
        }

        public function payment_fields() {
            wp_enqueue_script("popup_iframe");
            wp_enqueue_style("popup_iframe");
            global $kpoint_settings;
            $rate_currency_to_point = $kpoint_settings['rate_currency_to_point'];
            //$total = $woocommerce->cart->get_total();
            if(is_user_logged_in()){
                echo "<p>". $this->description."</p><hr>";
                $user =wp_get_current_user();
                $kpoint = new KPoint($user->ID);
                $balance = $kpoint->display_balance();
                $label = KPOINT_UNIT_NAME;
                $cart_total =  WC()->cart->get_cart_contents_total();

                $cart_point =  KPoint::cal_point_by_price($cart_total);
                $cart_point = KPoint::get_display_balance($cart_point);
                echo "<p>Thanh toán đơn hàng cần: <strong>$cart_point</strong></p>";
                echo "<p>Bạn đang có <strong>$balance</strong>. <a href='/wp-admin/admin-ajax.php?action=frame_add_kpoint' class='charge-kpoint button' style='display: none'>Nạp $label</a></p>";
                echo "<br><i>Ghi chú: " .wc_price(1) .' đổi được ' . $rate_currency_to_point . ' ' .KPOINT_UNIT_NAME  . "</i><p></p>";

            }else{
                echo "Bạn cần đăng nhập để sử dụng cổng thanh toán này!";
            }
            

            //ban can x point de thanh toan
            //hien so du
            // khong du => hien link dat mua point hoặc chọn phương thức khác
            // đủ thì cho mua
            ?>
            <?php
        }

        /**
         * Logging method.
         *
         * @param string $message Log message.
         * @param string $level   Optional. Default 'info'.
         *     emergency|alert|critical|error|warning|notice|info|debug
         */
        public static function log( $message, $level = 'info' ) {
            if ( self::$log_enabled ) {
                if ( empty( self::$log ) ) {
                    self::$log = wc_get_logger();
                }
                self::$log->log( $level, $message, array( 'source' => 'nganluongpro' ) );
            }
        }

        /**
         * Check if this gateway is enabled and available in the user's country.
         * @return bool
         */
        public function is_valid_for_use() {
            return true;
        }

        /**
         * Initialise Gateway Settings Form Fields.
         */
        public function init_form_fields() {
            $this->form_fields = array(
                'enabled' => array(
                    'title' => __( 'Bật/Tắt', 'woocommerce' ),
                    'type' => 'checkbox',
                    'label' => __( 'Bật cổng thanh toán', 'woocommerce' ),
                    'default' => 'yes'
                ),
                'title' => array(
                    'title' => __( 'Tên Cổng', 'woocommerce' ),
                    'type' => 'text',
                    'description' => __( 'Tên cổng để khách chọn khi thanh toán.', 'woocommerce' ),
                    'default' => 'Tài khoản ' . KPOINT_UNIT_NAME ,
                    'desc_tip'      => true,
                ),
                'description' => array(
                    'title' => __( 'Mô tả về cách thức thanh toán này', 'woocommerce' ),
                    'type' => 'textarea',
                    'default' => 'Dùng số điểm trong tài khoản ' . KPOINT_UNIT_NAME. ' để thanh toán'
                )
            );
        }

        function process_payment( $order_id ) {
            global $woocommerce;

            if(!is_user_logged_in()){
                wc_add_notice( __('Lỗi:', 'kpoint') . __('Bạn cần đăng nhập để dùng tài khoản ','kpoint') . KPOINT_UNIT_NAME, 'error' );
                return;
            }

            $order = new WC_Order( $order_id );
            global $kpoint_settings;
            $rate_currency_to_point = $kpoint_settings['rate_currency_to_point'];
            $default_order_status = $kpoint_settings['default_order_completed_status_point_getway'];

            $need_amount = $order->get_total() * $rate_currency_to_point;
            $user = wp_get_current_user();
            $kpoint = new KPoint($user->ID);
            $balance = $kpoint->get_balance();
            
            if($balance < $need_amount){
                wc_add_notice( 
                    __('Lỗi:', 'kpoint') . sprintf(
                        __('Tài khoản %s không đủ số dư (%s). <br>Bạn cần %s .<br>Hãy nạp thêm %s để sử dụng cách thanh toán này','kpoint'), KPOINT_UNIT_NAME, 
                            KPoint::get_display_balance($balance), 
                            KPoint::get_display_balance($need_amount), 
                            KPOINT_UNIT_NAME), 
                'error' );
                return;
            }else{
                $ok = $kpoint->decrese_point($need_amount, 'woocommerce', $order_id, "thanh toán cho hóa đơn #$order_id");
                if($ok){

                    $order->payment_complete();
                    $order->add_order_note("{$user->display_name} đã sử dụng $need_amount để thanh toán");
                    $order->update_status($default_order_status );
                    $order->save();


                    $woocommerce->cart->empty_cart();

                    // Return thankyou redirect
                    return array(
                        'result' => 'success',
                        'redirect' => $this->get_return_url( $order )
                    );

                }else{
                    wc_add_notice( __('Lỗi:', 'kpoint') . __('Xử lý giao dịch thất bại','kpoint') . KPOINT_UNIT_NAME, 'error' );
                    return;
                }
            }

        }

    }


}