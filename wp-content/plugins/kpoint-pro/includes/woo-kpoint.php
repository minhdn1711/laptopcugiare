<?php

//buying kpoint

class WooKPoint{

	//add product => checkout => completed => add point
	//quy doi tien => kpoint

	// dung point mua hang

	
	public static $instance;
	private $settings;
	public static function instance(){
		if(!WooKPoint::$instance){
			WooKPoint::$instance = new WooKPoint();
		}
		return WooKPoint::$instance;
	}
	private function __construct (){
		$this->settings = Kpoint_Setting::instance();
		add_filter( 'woocommerce_product_data_tabs', array($this,'custom_product_tabs') );
		//add_filter( 'woocommerce_product_data_tabs', array('WooKPoint','options_product_tab_content' ));
		add_action( 'woocommerce_product_data_panels', array($this,'options_product_tab_content' ));
		add_action( 'woocommerce_process_product_meta_simple', array($this,'save_option_fields'  ));
		add_action( 'woocommerce_process_product_meta_variable', array($this,'save_option_fields'  ));

		add_action( 'woocommerce_before_calculate_totals', array($this,'add_custom_price' ));
		add_action('woocommerce_after_order_itemmeta', array($this,'admin_item_order_meta_display'),10,3);
		add_filter('woocommerce_cart_item_name', array($this,'display_cart_item_detail'),10,3);
		add_filter('woocommerce_order_item_name', array($this,'display_order_item_name'),10,3);
		add_action('woocommerce_add_order_item_meta',array($this,'add_cart_item_to_order'),10,2);

		/*add_action('woocommerce_order_status_cancelled', array($this,'handle_order_status_changed'), 10,1);
		add_action('woocommerce_order_status_refunded', array($this,'handle_order_status_changed'), 10,1);
		add_action('woocommerce_order_status_failed', array($this,'handle_order_status_changed'), 10,1);
		add_action('woocommerce_order_status_completed', array($this,'handle_order_status_changed'), 10,1);*/
		add_action('woocommerce_order_status_changed', array($this,'handle_order_status_changed_old_and_new_status'), 10,4);
		

		//chua xu  ly xong tru tien tai khoan khac khi giam gia. Se su ly bang dong bang 1 khoan tien cua khach
		//add_action( 'delete_post', array($this,'handle_delete_order'), 10 );
		//add_action( 'untrashed_post', array($this,'handle_untrashed_order'), 10, 2 );

		add_action('woocommerce_checkout_order_review', array($this,'show_price_discount_from_point'),9);
		add_action('woocommerce_checkout_order_created', array($this,'handle_point_using'),10,1);

		add_action('wp_ajax_apply_discount_by_point', array($this,'apply_discount_by_point'));
		add_action('woocommerce_checkout_order_review', array($this,'show_gift_point_in_checkout'),21);
		//add_action('woocommerce_checkout_order_review', array($this,'show_info_discount_in_checkout'),11);

		add_filter( 'woocommerce_add_cart_item_data', array($this,'handle_cart_item_data'), 10,  3);
		add_filter( 'woocommerce_update_order_review_fragments', array($this,'update_order_review_fragments'), 10,  1);

		add_action('woocommerce_order_details_before_order_table', array($this, 'check_and_show_up_bill'));
		add_action( 'wp_ajax_kp_upload_bill', array($this,'handle_upload_bill') );
		add_action( 'wp_ajax_nopriv_kp_upload_bill', array($this,'handle_upload_bill') );

		add_action( 'wp_ajax_kp_delete_bill_name', array($this,'handle_delete_bill') );
		add_action( 'wp_ajax_nopriv_kp_delete_bill_name', array($this,'handle_delete_bill') );

		add_action( 'add_meta_boxes', array($this,'add_bill_meta_box') );

		//add_filter( 'woocommerce_get_discounted_price', array($this,'filter_woocommerce_get_discounted_price'), 10,  3);
		add_action( 'woocommerce_cart_calculate_fees', array($this,'add_fee_discount_by_point'), 10, 1 );
		add_action( 'wp_head', array($this, 'inline_css') );
		if($this->settings->get_setting('gif_point_when_buy') > 0){
			add_action('woocommerce_order_status_completed', array($this,'add_free_point_when_bough'), 10,1);
		}

		if($this->settings->get_setting('show_point_in_product')){
			add_action('woocommerce_after_shop_loop_item_title', array($this,'show_point_in_product_item_list'), 11);
			add_action('woocommerce_single_product_summary', array($this,'show_point_in_product_detail'), 11);
		}
	}

	function show_point_in_product_detail(){
		
		global $product;
		if($product->get_type() =="variable"){
			$min = $product->get_variation_price( 'min', false );
			$max = $product->get_variation_price( 'max', false );
			$min = KPoint::cal_point_by_price($min);
			//$min = KPoint::get_display_balance($min);
			$max = KPoint::cal_point_by_price($max);
			$max = KPoint::get_display_balance($max);

			echo "$min - $max";
		}else{
			$point = KPoint::cal_point_by_price($product->get_price());
        	echo KPoint::get_display_balance($point);
		}
        
	}

	function show_point_in_product_item_list(){
		
		global $product;
		if($product->get_type() =="variable"){
			$min = $product->get_variation_price( 'min', false );
			$max = $product->get_variation_price( 'max', false );
			$min = KPoint::cal_point_by_price($min);
			//$min = KPoint::get_display_balance($min);
			$max = KPoint::cal_point_by_price($max);
			$max = KPoint::get_display_balance($max);

			echo "$min - $max";
		}else{
			$point = KPoint::cal_point_by_price($product->get_price());
        	echo KPoint::get_display_balance($point);
		}
        
	}

	function add_bill_meta_box(){
		add_meta_box( 'bill_image', __('Bill nạp tiền','woocommerce'), array($this, 'bill_meta_box'), 'shop_order', 'side', 'core' );
	}

	function bill_meta_box(){
		global $post;
		add_thickbox();
		$bills = get_post_meta($post->ID, "kp_bill_image_name", true);
		$bills = $bills ? $bills : array();
		echo "<ul class='kp_list_bill'>";
		$upload_dir   = wp_upload_dir();		
		$upload_folder_url = $upload_dir['baseurl'] . '/kpoint_customer_bill';
		foreach($bills as $name){
			$link = "$upload_folder_url/$name";
			echo "<li><a href='$link?TB_iframe=true&width=600&height=550' class='thickbox'><img src='$link' alt='$name' /></a></li>";
		}
		echo "</ul>";
	}

	function handle_delete_bill(){
		$name = isset($_POST["name"]) ? $_POST["name"] : "";
		$order_id = isset($_POST["order_id"]) ? intval($_POST["order_id"]) : "";
		$name = str_replace("/","", $name);
		if($name){
			$upload_dir   = wp_upload_dir();
			$upload_path = $upload_dir['basedir'] . '/kpoint_customer_bill';
			if(file_exists($upload_path . "/".$name)){
				unlink($upload_path . "/".$name);
			}
			$bills = get_post_meta($order_id, "kp_bill_image_name", true);
			foreach($bills as $id => $uploaded){
				if($uploaded == $name){
					unset($bills[$id]);
				}
			}
			update_post_meta($order_id, "kp_bill_image_name", $bills);
		}
		die();
	}

	function check_and_show_up_bill($order){
		if($order->get_status() == "completed") return;
		if($this->settings->get_setting("enable_up_bill") == "no") return;
		$items = $order->get_items(); 
		$is_buy_point_order = false;
		foreach($items as $item_order){			
			if($item_order->get_meta("_kpoint_custom_amount", true)){
				$is_buy_point_order = true;
			}
		}

		if(!$is_buy_point_order) return;

		wp_enqueue_style('dropzone_css');
		wp_enqueue_style('basic_css');
		wp_enqueue_script('dropzone');
		wp_enqueue_script('kp_upload_bill');
		
		$bills = get_post_meta($order->get_id(), "kp_bill_image_name", true);
		$bills = $bills ? $bills : array();



		$upload_dir   = wp_upload_dir();
		$upload_path = $upload_dir['basedir'] . '/kpoint_customer_bill';
		$upload_folder_url = $upload_dir['baseurl'] . '/kpoint_customer_bill';

		$list_bill = array();
		foreach($bills as $name){
			if(file_exists($upload_path . "/" . $name)){
				$size = filesize($upload_path . "/" . $name);
			}else{
				$size = 0;
			}
			
			$list_bill[] = array(
				"name" => $name,
				"size" => $size
			);
		}

		$ajax_array = array(
			'admin_ajax'		=>	admin_url( 'admin-ajax.php'),
			'uploaded_list'		=>	$list_bill,
			'uploaded_url_folder'		=>	$upload_folder_url,
		);

		wp_localize_script( 'kp_upload_bill', 'kp_upload_bill', $ajax_array ); 


		?>
	<div class="upload-zone">
		<div id="myUploadZone" class="dropzone1">
	      	<div class="dz-message needsclick">
	      	<h3 style="text-align: center;">Upload Bill Nạp Tiền</h3>
		    <button type="button" class="dz-button fileinput-button">Kéo file hoặc Click vào đây.</button><br />
		    <span class="note needsclick">Chỉ hỗ trợ file hình jpg, png</span>
		    <input type="hidden" id="upload_session_id" name="upload_session_id" value="<?php echo date("dmyHis")?>">
		  </div>	      
	    </div>
	    <input type="hidden" name="" id="order_id_up_bill" value="<?php echo $order->get_id(); ?>">
	</div>
	<?php
	}

	function handle_upload_bill(){
		$upload = new \Delight\FileUpload\FileUpload();
		$upload_dir   = wp_upload_dir();
		$upload_path = $upload_dir['basedir'] . '/kpoint_customer_bill';
		$upload_folder_url = $upload_dir['baseurl'] . '/kpoint_customer_bill';

		if (! is_dir($upload_path)) {
	       mkdir( $upload_path, 0755 );
	    }

		$result = array(
			'status' => 0,
			'data' => '',
			'message' => ''
		);

		$upload->withAllowedExtensions( array('jpeg', 'jpg', 'png') );
		$upload->withTargetDirectory($upload_path);

		$upload->from('file');

		$data = $_FILES[$upload->getSourceInputName()];
		$origin_name = isset($data['name']) ? $data['name'] : $uploadedFile->getFilenameWithExtension();
		
		$new_name = uniqid();
		$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : '';
		$upload->withTargetFilename($new_name);
		
		try {
		
		    $uploadedFile = $upload->save();
		
		    $full_url = $upload_folder_url.'/'.$uploadedFile->getFilenameWithExtension();
		    $result = array(
				'status' => 1,
				'full_url' => $full_url,
				'filename' => $origin_name,
				'data' => $uploadedFile->getFilenameWithExtension(),
				'message' => ''
			);

			if($order_id){
				$bill = get_post_meta($order_id, "kp_bill_image_name", true);
				$bill = $bill ? $bill : array();
				
				$bill[] = $uploadedFile->getFilenameWithExtension();
				update_post_meta($order_id, "kp_bill_image_name", $bill);
			}
		    
		    header('Content-Type: application/json');
		    echo json_encode($result);
		    die();
		    
		}
		catch (\Delight\FileUpload\Throwable\InputNotFoundException $e) {
		    
		    $result["message"] = $e->getMessage();
		}
		catch (\Delight\FileUpload\Throwable\InvalidFilenameException $e) {
		    $result["message"] = $e->getMessage();
		}
		catch (\Delight\FileUpload\Throwable\InvalidExtensionException $e) {
		    $result["message"] = $e->getMessage();
		}
		catch (\Delight\FileUpload\Throwable\FileTooLargeException $e) {
		    $result["message"] = $e->getMessage();
		}
		catch (\Delight\FileUpload\Throwable\UploadCancelledException $e) {
		    $result["message"] = $e->getMessage();
		}

		if($result["status"] == 0){
			header("HTTP/1.0 400 Bad Request");
			echo $result["message"];
		}else{
			header('Content-Type: application/json');
	    	echo json_encode($result);	
		}
		
	    die();
	}
	public function display_order_item_name($name, $item, $is_visible){
		$amount = $item->get_meta("_kpoint_custom_amount");
		$amount = $amount ? " ". $amount . " " . KPOINT_UNIT_NAME : "";
		if($amount){
			$name = str_replace(KPOINT_UNIT_NAME,"", $name);
			return $name . $amount;
		}
		return $name;
	}

	public function add_custom_price( $cart_object ) {
	    

	    foreach ( $cart_object->cart_contents as $key => $value ) { 
	        if(isset($value['custom_amount'])){
	        	$price = KPoint::cal_price_by_point($value['custom_amount']);
	        	$value['data']->set_price($price);	
	        }
	        
	    }
	}

	public function admin_item_order_meta_display($item_id, $item, $product){
		$custom_amount = wc_get_order_item_meta($item_id, '_kpoint_custom_amount');
		if($custom_amount){
			
	    	$return_string = "<span>Nạp <strong>$custom_amount </strong>".KPOINT_UNIT_NAME."</span>";
	    	
	    	echo $return_string;
		}
	}

	public function check_has_buy_point_product_in_cart(){
		global $woocommerce;
		$items = $woocommerce->cart->get_cart();
		foreach($items as $item => $values) {
			if(isset($values["custom_amount"])) return true;
		} 
		return false;
	}

	public function display_cart_item_detail($name, $cart_item, $cart_item_key )
	{

	    if(isset($cart_item['custom_amount']))
	    {	
	    	$name = str_replace(KPOINT_UNIT_NAME,"", $name);
	    	return $name . " " . $cart_item['custom_amount'] . " " .KPOINT_UNIT_NAME;
	    	
	    }
	    else
	    {
	        return $name;
	    }
	}

	public function add_cart_item_to_order($item_id, $values)
	{
	    global $woocommerce,$wpdb;
	    $custom_amount = $values['custom_amount'];
	    if(!empty($custom_amount))
	    {
	        wc_add_order_item_meta($item_id,'_kpoint_custom_amount',$custom_amount);  
	    }
	}

	function show_info_discount_in_checkout(){
		?>
		<div class="kp-notice kp-discount-checkout-info"></div>
		<?php
	}

	function inline_css(){
		if(is_checkout()) :
			?>
			<style type="text/css">
				.kp-notice {
					background: #f5d951;
					color: #333;
					padding: 10px 10px 10px 10px;
					border-radius: 3px;
					margin: 10px 0;
				}

				ul.kp-options-discount li {
					width: 50%;
					float: left;
					font-size: 14px;
				}

				@media(max-width: 768px){
					ul.kp-options-discount li {
						width: 100%;
						font-size: 14px;
					}
				}

			</style>
			<?php
		endif;
	}

	function update_order_review_fragments($fragments){
		ob_start();
		$this->show_gift_point_in_checkout();
		$html = ob_get_clean();
		$fragments['.discount-point-notice'] = $html;
		return $fragments;
	}

	function get_gift_point_in_checkout(){
		$has_buy_point_product = false;
		if($this->check_has_buy_point_product_in_cart()) $has_buy_point_product = true ;
		$cart_sub_total =  WC()->cart->get_subtotal();
		global $kpoint_settings;
		$gateway = WC()->session->get( 'chosen_payment_method');
		
		$not_add_gift_point_gateway = $kpoint_settings["not_add_gift_point_for_point_gateway"] && $gateway == "kpoint";
		if($not_add_gift_point_gateway || $has_buy_point_product){
			return "<p class=\"\"><strong>Không áp dụng điểm thưởng cho đơn hàng này</strong></p>";
		}else{
			$new_point = $this->get_gift_point_of_cart($cart_sub_total);
			if($new_point){
				// lay setting tinh ra so diem sẽ dc cong

				
				$text = $kpoint_settings['text_promo_cart'];
				$text = str_replace("{point}", KPoint::get_display_balance($new_point), $text);
				return "<p class=\"\"><strong>{$text}</strong></p>";			
			}else{
				return "<p class=\"\"><strong>Không có điểm thưởng cho đơn hàng này</strong></p>";
			}
		}
		return "";
	}

	function show_gift_point_in_checkout(){
		
		echo "<div class='kp-notice discount-point-notice' >";	
		echo $this->get_gift_point_in_checkout();
		echo "</div>";
		
	}


	// xu ly tru point khi ap dung giam gia
	function handle_point_using($order){
		
		if(!get_current_user_id()) return;

		$price_discount_from_point = WC()->session->get( 'price_discount_from_point');
		$key = WC()->session->get( 'kpoint_discount_item');
		$manual_point = WC()->session->get( 'manual_point');

		//valid again
		if($price_discount_from_point && $price_discount_from_point > 0){
			$data_discount = $this->get_discount_value($key, $manual_point);
			
			if($price_discount_from_point == $data_discount['discount']){
				
				// dua gia tri giam bang diem vao don hang
				$current_user_kp = new KPoint();
				$amount_point = KPoint::cal_point_by_price($price_discount_from_point);
				
				
				//$current_user_kp->decrese_point($amount_point, "dùng điểm thanh toán", $order->get_id(), "áp dụng giảm giá với điểm");
				$current_user = wp_get_current_user();
				
				$username =  $current_user->user_login;
				$order->add_order_note("áp dụng $amount_point điểm giảm giá ". wc_price($price_discount_from_point) . " cho " . $username);
				
				// tru so du tai khoan va danh dau la da tru
				
				
				$current_user_kp = new KPoint($current_user->ID);			
								

				$current_user_kp->decrese_point($amount_point, "dùng điểm thanh toán", $order->get_id(), "áp dụng giảm giá với điểm");
				$order->update_meta_data( 'kp_withdrawed_from_user', $amount_point);
				
				$order->add_order_note("trừ $amount_point vào tài khoản " . $username);
				//$order->delete_meta_data('kp_apply_disount_point');
				$order->save();
			
			}else{
				$order->add_order_note("điểm giảm giá không khớp");
				
			}
		}
		// valid -> tru so du
		// khong valid -> xoa giam gia, ghi chu don

		WC()->session->set( 'price_discount_from_point',  0 ); 
		WC()->session->set( 'kpoint_discount_item',  "" ); 
		WC()->session->set( 'manual_point',  0 );

	}
	function add_fee_discount_by_point($cart){
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;

		$discount = WC()->session->get( 'price_discount_from_point');
		if($discount){
			$cart->add_fee( "Giảm giá với " . KPOINT_UNIT_NAME  , -1 * $discount, false );	
		}
		
	}

	/*function filter_woocommerce_get_discounted_price( $price, $values, $instance ) { 
		$discount = WC()->session->get( 'price_discount_from_point');
		$total_product = 0;
		$cart_items = WC()->cart->get_cart();
		
		$total_product = count($cart_items);
		if($discount && is_checkout()){
			return ($price -  round($discount/$total_product)); 
		}
		return $price;		
	}*/

	function get_discount_value($key, $manual_point){
		$current_user_kp = new KPoint();
		global $kpoint_settings;
		$list = $kpoint_settings['using_list_discount'];
		$max_input_discount_value = $kpoint_settings['max_input_discount_value'];
		$message = '';
		$discount = 0;
		switch ($key) {
			case 'no_using':
				$discount = 0;
				break;
			case 'manual':
				if($manual_point > $current_user_kp->get_balance()){
					$message = 'số điểm bạn nhập vượt quá số dư điểm hiện có trong tài khoản';

				}elseif ($max_input_discount_value && $manual_point > $max_input_discount_value){
					$message = "Quá số cho phép: " . KPoint::get_display_balance($max_input_discount_value, true);
				}else{
					$discount = KPoint::cal_price_by_point($manual_point);
				}
				break;
			case '';
					$message = 'bạn chưa chọn phương thức giảm giá nào';
				break;
			default:
				foreach ($list as $item) {
					if($key == $item['key']){
						if($item['type'] == "fixed"){
							$discount = $item['value'];
						}else{
							$cart_sub_total =  WC()->cart->get_subtotal();
							$number_kp = KPoint::cal_point_by_price(($item['value']/100) * $cart_sub_total);
							if($number_kp > $current_user_kp->get_balance()){
								
								$message = 'không đủ số dư điểm trong tài khoản';
							}else{
								$discount = ($item['value']/100) * $cart_sub_total;
							}
						}
						break;
					}
				}
				break;
		}
		return array(
			'message' => $message,
			'discount' => $discount
		);
	}

	function apply_discount_by_point(){


		$key = isset($_POST['kpoint_discount_item']) ? sanitize_text_field( $_POST['kpoint_discount_item'] ) : '';
		$manual_point = isset($_POST['manual_point']) ? intval($_POST['manual_point']) : 0;
		
		
		$discount_data = $this->get_discount_value($key, $manual_point);
		$discount = $discount_data['discount'];
		$message = $discount_data['message'];
		global $woocommerce;
		if($message){
			WC()->session->set( 'price_discount_from_point',  0 ); 
			WC()->session->set( 'kpoint_discount_item',  "" ); 
			WC()->session->set( 'manual_point',  0 ); 
			wp_send_json_error($message);
		}else{
			WC()->session->set( 'price_discount_from_point',  $discount ); 
			WC()->session->set( 'kpoint_discount_item',  $key ); 
			WC()->session->set( 'manual_point',  $manual_point ); 
			wp_send_json_success("giảm giá " . $discount);
		}
		
		
	}


	function show_price_discount_from_point(){
		if($this->check_has_buy_point_product_in_cart()) return;

		global $kpoint_settings;
		$list = $kpoint_settings['using_list_discount'];
		$max_input_discount_value = $kpoint_settings['max_input_discount_value'];
		$max_limit_input = $max_input_discount_value ? " max='$max_input_discount_value' " : "";
		if(!$list || count($list ) == 0) return;
		
		$null_check = true;
		foreach($list as $item){
			if($item['value'] != 0) $null_check = false;
		}
		
		if($null_check) return; 
		
		if(!get_current_user_id()){
			echo "<h5 class='disount-title-kp'>Áp dụng khuyến mãi</h5>";
			echo "<div class='kp-notice'><p style='cursor: pointer;' onClick='jQuery(\".showlogin\").click()'>Hãy đăng nhập để áp dụng giảm giá với điểm của bạn.</p></div>";			
			return;
		}
		$current_user_kp = new KPoint();
		if($current_user_kp->get_balance() == 0) return;
		

		$selected = WC()->session->get( 'kpoint_discount_item');
		$selected = $selected ? $selected : 'no_using';
		$manual_point = WC()->session->get( 'manual_point');
		$manual_point = $manual_point ? $manual_point : '';

		echo "<h5 class='disount-title-kp'>Áp dụng khuyến mãi</h5>";
		echo "<p>Bạn đang có: ".$current_user_kp->display_balance()."</p>";
		echo "<ul class='kp-options-discount'>";
		echo "<li>";
		echo '<input type="radio" value="no_using" '.checked( $selected, 'no_using' , false).' name="kpoint_discount_item" id="no_using" /> ';
		echo '<label for="no_using"> Không áp dụng</label>';
		echo "</li>";
		$index = 0;
		
		foreach ($list as $item) {
			if(!$item['value'] || $item['value'] == 0) continue;

			$key = $item['key'];
			if($item['type'] == "fixed"){
				$number_kp = KPoint::cal_point_by_price($item['value']);
				if($number_kp > $current_user_kp->get_balance()) continue;
				$number_kp = KPoint::get_display_balance($number_kp);				

				$promo_text = wc_price($item['value']) . " với " . $number_kp ;
			}else if ($item['type'] == "percent"){
				$cart_sub_total =  WC()->cart->get_subtotal();

				$number_kp = KPoint::cal_point_by_price(($item['value']/100) * $cart_sub_total);
				if($number_kp > $current_user_kp->get_balance()) continue;
				$number_kp = KPoint::get_display_balance($number_kp);
				$promo_text = $item['value'] . "% đơn với " . $number_kp;
			}

			
			?>
			<li>
				<input type="radio" value="<?php echo $key; ?>" <?php echo checked( $selected, $key , true); ?> name="kpoint_discount_item" id="kpoint_discount_item_<?php echo $index; ?>" value="<?php echo $key; ?>" /> 
				<label for="kpoint_discount_item_<?php echo $index; ?>"> <?php echo $promo_text ?></label></li>
			<?php
			
			$index++;
		}
		if($kpoint_settings['using_enable_customer_input_discount']){
			echo "<li>";
			echo '<input type="radio" value="manual" '.checked( $selected, 'manual' , false).' name="kpoint_discount_item" id="manual" /> ';
			echo '<label for="manual">';
			echo ' <input type="number" style="width: 100px; margin-bottom: 0;padding: 4px 5px;font-weight: 500;border-radius: 8px;" value="'.$manual_point.'" name="manual_point" min="0" '.$max_limit_input.' placeholder="Số điểm" /> ' . KPOINT_UNIT_NAME;
			echo "</label></li>";
		}
		echo "</ul>";

		?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('input[name="kpoint_discount_item"]').change(function(){
					apply_discount_by_point();
				});

				jQuery('input[name="manual_point"]').change(function(){
					apply_discount_by_point();
				});

				jQuery('body').on("change", 'input[name="payment_method"]', function(){
					jQuery('body').trigger('update_checkout');
				});
				

				function apply_discount_by_point(){
					var data = {
						action: "apply_discount_by_point",
						kpoint_discount_item: jQuery('input[name="kpoint_discount_item"]:checked').val(),
						manual_point: jQuery('input[name="manual_point"]').val()

					};
					jQuery.post(woocommerce_params.ajax_url, data, function(resp){
						console.log(resp);
						if(resp.success == false){
							alert(resp.data)
						}
						jQuery('body').trigger('update_checkout');
					});
				}
			});
		</script>
		
		<?php
		
	}

	function handle_cart_item_data( $cart_item_data, $product_id, $variation_id ){
		global $woocommerce;
		if(isset($_GET['reset_cart'])){
			$woocommerce->cart->empty_cart();	
		}

		if ( isset($_GET['custom_amount'])) {
	        $cart_item_data['custom_amount'] = sanitize_text_field( $_GET['custom_amount']);
	    }
	    
	    return $cart_item_data;
	}


	function handle_untrashed_order($post_id, $previus_status){
		$post_type = get_post_type($post_id);
		if($post_type == "shop_order"){
			$order = wc_get_order($post_id);
			if(!$order) return;
			$withdrawed_point = $order->get_meta("kp_withdrawed_from_user");
			if($withdrawed_point){
				// tra lai tien
				$user_id = $order->get_user_id();
				if(!$user_id) return;
				$kpoint = new KPoint($user_id);
				$note = sprintf('%s được trả lại %s ', $user->user_login, KPoint::get_display_balance($withdrawed_point) );
				$kpoint->increse_point($withdrawed_point , "woocommerce", $order_id, $note);
				$order->add_order_note($note);
				// tao meta khac
				$order->delete_meta_data('kp_withdrawed_from_user');
				$order->update_meta_data('kp_refunded_point_to_user', $withdrawed_point);
				$order->save();
			}
		}
	}

	function handle_delete_order($post_id){
		$post_type = get_post_type($post_id);
		if($post_type == "shop_order"){
			$order = wc_get_order($post_id);
			if(!$order) return;

			$user_id = $order->get_user_id();
			if(!$user_id) return;

			$user = $order->get_user();
			if(!$user) return;

			$refunded_point = $order->get_meta("kp_refunded_point_to_user");
			if($refunded_point){
				// tra lai tien
				$kpoint = new KPoint($user_id);
				$note = sprintf('%s bị thu hồi lại %s ', $user->user_login, KPoint::get_display_balance($refunded_point) );
				$kpoint->decrese_point($refunded_point , "woocommerce", $order_id, $note);
				$order->add_order_note($note);
				// tao meta khac
				$order->delete_meta_data('kp_refunded_point_to_user');
				$order->update_meta_data('kp_withdrawed_from_user', $refunded_point);
				$order->save();

			}
		}
	}

	function handle_order_status_changed_old_and_new_status($order_id, $old_status, $new_status, $order){
		$this->handle_add_or_remote_point($order_id, $old_status, $new_status, $order);

		$order_status = $order->get_status();
		$refunded_point = $order->get_meta("kp_refunded_point_to_user");
		$old_status_should_be = ($old_status == "cancelled" || $old_status == "refunded" || $old_status == "failed");
		$new_status_not_be = ($new_status != "cancelled" && $new_status != "refunded" && $new_status != "failed");
		$user_id = $order->get_user_id();
		if(!$user_id) return;

		$user = $order->get_user();
		if(!$user) return;

		if($refunded_point && $old_status_should_be && $new_status_not_be){
			// tra lai tien
			$kpoint = new KPoint($user_id);
			$note = sprintf('%s bị thu hồi lại %s ', $user->user_login, KPoint::get_display_balance($refunded_point) );
			$kpoint->decrese_point($refunded_point , "woocommerce", $order_id, $note);
			$order->add_order_note($note);
			// tao meta khac
			$order->delete_meta_data('kp_refunded_point_to_user');
			$order->update_meta_data('kp_withdrawed_from_user', $refunded_point);
			$order->save();

		}

		// tra lai tien cho user, neu don do khong hoan thanh
		
		$withdrawed_point = $order->get_meta("kp_withdrawed_from_user");
		if($withdrawed_point && ($order_status == "cancelled" || $order_status == "refunded" || $order_status == "failed")){
			// tra lai tien
			$kpoint = new KPoint($user_id);
			$note = sprintf('%s được trả lại %s ', $user->user_login, KPoint::get_display_balance($withdrawed_point) );
			$kpoint->increse_point($withdrawed_point , "woocommerce", $order_id, $note);
			$order->add_order_note($note);
			// tao meta khac
			$order->delete_meta_data('kp_withdrawed_from_user');
			$order->update_meta_data('kp_refunded_point_to_user', $withdrawed_point);
			$order->save();
		}
	}

	// xu ly tang, giam khi nap diem
	function handle_add_or_remote_point($order_id, $old_status, $new_status, $order){
		
		$order_items = $order->get_items();
		
		$user = $order->get_user();
		if(!$user) return;
		$user_id = $order->get_user_id();
		if(!$user_id) return;

		foreach ($order_items as $item) {
			//$product = $item->get_product();
			$quantity = $item->get_quantity();
			$point_amount = $item->get_meta("_kpoint_custom_amount", true);
			if($point_amount){
				if($new_status == 'completed'){
					$kpoint = new KPoint($user_id);
					$note = sprintf('%s đã được tăng %s %s.', $user->user_login, number_format($point_amount * $quantity, 0,',','.'), KPOINT_UNIT_NAME );
					$kpoint->increse_point($point_amount * $quantity, "woocommerce", $order_id, $note);
					$order->add_order_note($note);
					
				}else if( $old_status == 'completed' && $new_status != 'completed'){
					$kpoint = new KPoint($user_id);
					$note = sprintf('%s đã bị trừ %s %s do đơn chuyển trạng thái '. $order->get_status() , $user->user_login, number_format($point_amount * $quantity, 0,',','.'), KPOINT_UNIT_NAME );
					$kpoint->increse_point($point_amount * $quantity, "woocommerce", $order_id, $note);
					$order->add_order_note($note);			
				}
			}
		}


		
	}

	public function options_product_tab_content() {

		global $post;
		
		// Note the 'id' attribute needs to match the 'target' parameter set above
		?><div id='kpoint_options' class='panel woocommerce_options_panel'><?php

			?><div class='options_group'><?php

				woocommerce_wp_text_input( array(
					'id'				=> 'kp_gift_amount',
					'label'				=> __( KPOINT_UNIT_NAME.' tặng khi mua', 'woocommerce' ),
					'desc_tip'			=> true,
					'description'		=> __( 'Khi mua sản phẩm sẽ tặng số  '.KPOINT_UNIT_NAME.' này. Để trống sẽ tính theo phần trăm mặc định', 'woocommerce' ),
					'type' 				=> 'number',
					'custom_attributes'	=> array(
						'min'	=> '0',
					),
				) );

			?></div>

		</div><?php

	}

	public function save_option_fields( $post_id ) {
		
		$kp_gift_amount = isset( $_POST['kp_gift_amount'] ) ? intval($_POST['kp_gift_amount']) : "";
		update_post_meta( $post_id, 'kp_gift_amount', $kp_gift_amount );	
		
	}
	public function custom_product_tabs( $tabs) {

		$tabs['kpoint'] = array(
			'label'		=> __( 'K-Point', 'woocommerce' ),
			'target'	=> 'kpoint_options',
			'class'		=> array(   ),//'show_if_simple', 'show_if_variable'
		);

		return $tabs;

	}

	public function cal_gift_point_in_cart_by_product_and_cat(){
		global $woocommerce;
		$items = $woocommerce->cart->get_cart();
		$total_gift_amount = 0;

		$setting = Kpoint_Setting::instance();
        $percent = $setting->get_setting('gif_point_when_buy');
		foreach($items as $key => $values) {
			$product_id = $values['product_id'];
			$quantity = $values['quantity'];
			$line_total = $values['line_total'];

			$gift_amount = get_post_meta($product_id, 'kp_gift_amount', true);
			if(!$gift_amount){
				//tim tiep category
				$product = wc_get_product($product_id);
				$cat_ids = $product->get_category_ids();
				foreach($cat_ids as $cat_id){
				    $gift_amount = get_term_meta($cat_id, 'kp_gift_amount', true);
				    if($gift_amount) break;
				}
			}


			if($gift_amount){
				$total_gift_amount += $gift_amount * $quantity;
			}else{
				$total_gift_amount += ($percent/100) * $line_total;
			}

		}
		
		return $total_gift_amount;
	}

	public function cal_gift_point_in_order_by_product_and_cat($order){

		$total_gift_amount = 0;

		$setting = Kpoint_Setting::instance();
        $percent = $setting->get_setting('gif_point_when_buy');

        foreach ( $order->get_items() as $item_id => $item_values ) {

	        $product_id = $item_values->get_product_id(); 
	        $quantity = $item_values->get_quantity(); 
	        $line_total = $item_values->get_total(); 


			$gift_amount = get_post_meta($product_id, 'kp_gift_amount', true);
			if(!$gift_amount){
				//tim tiep category
				$product = wc_get_product($product_id);
				$cat_ids = $product->get_category_ids();
				foreach($cat_ids as $cat_id){
				    $gift_amount = get_term_meta($cat_id, 'kp_gift_amount', true);
				    if($gift_amount) break;
				}
			}


			if($gift_amount){
				$total_gift_amount += $gift_amount * $quantity;
			}else{
				$total_gift_amount += ($percent/100) * $line_total;
			}
	        
	    }
		
		
		return $total_gift_amount;
	}

	public function get_gift_point_of_order($order){
		
		$total = $order->get_subtotal();
		$value = $this->settings->get_setting('gif_point_when_buy');
		$type = $this->settings->get_setting('gif_point_type');
		$min = $this->settings->get_setting('gif_point_min_order');
		$max = $this->settings->get_setting('gif_point_max_order');
		$limit_gif_point_per_order = $this->settings->get_setting('limit_gif_point_per_order');
		if($min && $total < $min){
			return; 
		}
		if($max && $total > $max){
			return;
		}
		$price = 0;
		if($type == 'percent'){
			$price = $value / 100 * $total;
		}else{
			$price = $value;
		}
		if($type == 'per_cat_and_product'){
			$new_point = $this->cal_gift_point_in_order_by_product_and_cat($order);
		}else{
			$new_point = KPoint::cal_point_by_price($price);	
		}
		
		if($limit_gif_point_per_order && $new_point > $limit_gif_point_per_order) return $limit_gif_point_per_order;
		return $new_point;
	}

	public function get_gift_point_of_cart($total){
		

		$value = $this->settings->get_setting('gif_point_when_buy');
		$type = $this->settings->get_setting('gif_point_type');
		$min = $this->settings->get_setting('gif_point_min_order');
		$max = $this->settings->get_setting('gif_point_max_order');
		$limit_gif_point_per_order = $this->settings->get_setting('limit_gif_point_per_order');
		if($min && $total < $min){
			return; 
		}
		if($max && $total > $max){
			return;
		}
		$price = 0;
		if($type == 'percent'){
			$price = $value / 100 * $total;
		}else{
			$price = $value;
		}
		if($type == 'per_cat_and_product'){
			$new_point = $this->cal_gift_point_in_cart_by_product_and_cat();
		}else{
			$new_point = KPoint::cal_point_by_price($price);	
		}
		
		if($limit_gif_point_per_order && $new_point > $limit_gif_point_per_order) return $limit_gif_point_per_order;
		return $new_point;
	}

	function add_free_point_when_bough($order_id){
		global $kpoint_settings;
		$order = new WC_ORDER($order_id);
		$items = $order->get_items(); 
		// ko apply cho don mua point
		foreach($items as $item_order){			
			if($item_order->get_meta("_kpoint_custom_amount", true)){
				$order->add_order_note("Không tặng điểm do đơn hàng là đơn mua điểm");
				return;
			}
		}

		$gateway = $order->get_payment_method();
		if($kpoint_settings["not_add_gift_point_for_point_gateway"] && $gateway == "kpoint"){
			$order->add_order_note("Không tặng điểm do thanh toán bằng cổng thanh toán ". KPOINT_UNIT_NAME);
			return;
		}

		$total = $order->get_total();
		$sub_total = $order->get_subtotal();
		$new_point = $this->get_gift_point_of_order($order);
		$user = $order->get_user();
		if(!$user) return;
		$user_id = $order->get_user_id();
		if(!$user_id) return;

		$da_tang = $order->get_meta('added_point');
		if(!$da_tang ){
			$kpoint = new KPoint($user_id);
		
			$note = sprintf('%s đã được tăng %s khi mua hàng.', $user->user_login, KPoint::get_display_balance($new_point) );
			$kpoint->increse_point($new_point, "woocommerce", $order_id, $note);
			$order->add_order_note($note);
			$order->update_meta_data('added_point', 1);
			$order->save();
		}
		

	}
	
}

WooKPoint::instance();