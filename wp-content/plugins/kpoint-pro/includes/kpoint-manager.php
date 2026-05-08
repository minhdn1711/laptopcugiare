<?php

class KPoint_Manager{
	public static $instance;
	private $settings;
	public static function instance(){
		if(!KPoint_Manager::$instance){
			KPoint_Manager::$instance = new KPoint_Manager();
		}
		return KPoint_Manager::$instance;
	}
	private function __construct (){
		add_shortcode('kpoint_balance', array($this, 'get_balance_current_user'));
		add_action('after_user_packages', array($this,'display_balance_current_user'), 10,1);
		add_action('woocommerce_account_dashboard', array($this,'display_balance_current_user'), 10,1);
		add_action('wp_ajax_frame_add_kpoint', array($this,'frame_add_kpoint'),);
		
		add_filter("body_class", array($this, 'body_class'));
		add_action("wp_head", array($this, 'inline_style_global'));

		$this->settings = Kpoint_Setting::instance();
		if($this->settings->get_setting('free_point_register') > 0){
			add_action('user_register', array($this,'add_free_point_when_registered'), 10,1);
		}

		
		
	}

	function inline_style_global(){
		?>
		<style type="text/css">
			.kpoint_popup_inline #header,
			.kpoint_popup_inline #footer,
			.kpoint_popup_inline #wpadminbar
			{
				display: none;
			}
		</style>
		<?php
	}

	function body_class($classes){
		if(isset($_GET["kpoint_popup_inline"])){
			$classes[]= "kpoint_popup_inline";
		}

		return $classes;
	}

	function frame_add_kpoint(){

		global $kpoint_settings;
        $rate_point_to_currency = $kpoint_settings['rate_point_to_currency'];

        $getway_id = isset($_POST["getway_id"]) ? sanitize_text_field($_POST['getway_id']) : 'bacs';
		$custom_amount = isset($_POST["custom_amount"]) ? sanitize_text_field($_POST['custom_amount']) : 0;
		if(isset($_POST["process-charge-point"])){
			
			$custom_amount = str_replace(",","",$custom_amount);
			$custom_amount = str_replace(".","",$custom_amount);
			$custom_amount = floatval($custom_amount);

			if(!$custom_amount || $custom_amount <= 0){
				echo "<p class='mc-notice mc-error'>Số lượng nạp không hợp lệ</p>";
			}else{
				$order_data = array(
					'status' => 'processing',
					'customer_id' => get_current_user_id()
				);
				$order = wc_create_order($order_data);
				$settings = Kpoint_Setting::instance();

				$product = $settings->get_buy_point_product();
				$price = $custom_amount * $rate_point_to_currency;
				$order_item_id = $order->add_product( $product, 1, array("subtotal" => $price, "total" => $price));
				wc_add_order_item_meta($order_item_id,'_kpoint_custom_amount',$custom_amount);  
				$order->set_payment_method($getway_id);
				$order->calculate_totals(); 
				$order->save();

				$payment_gateways   = WC_Payment_Gateways::instance();
		        $enabled_gateways = $payment_gateways->payment_gateways();

				// Get the desired WC_Payment_Gateway object
				$payment_gateway    = $enabled_gateways[$getway_id];
				if($payment_gateway) {
					$process_data = $payment_gateway->process_payment($order->get_id());
					if($process_data && isset($process_data["redirect"])){
						$pay_url = $process_data["redirect"];
						$pay_url = add_query_arg("kpoint_popup_inline", "true", $pay_url);
						wp_redirect($pay_url);
						die();
					}
				}else{
					$order_thankyou_url = $order->get_checkout_order_received_url();
					$order_thankyou_url = add_query_arg("kpoint_popup_inline", "true", $order_thankyou_url);
					wp_redirect($order_thankyou_url);
					die();
				}
			}
			
		}
		


		$gateways = WC()->payment_gateways->get_available_payment_gateways();
		unset($gateways['kpoint']);

		
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Nạp <?php echo KPOINT_UNIT_NAME ?></title>
			<link rel="stylesheet" type="text/css" href="<?php echo KPOINT_PLUGIN_URL . 'public/css/style.css?ver=' . KPOINT_VERSION ?>">
		</head>
		<body>
		<form method="POST">
		<div class="themebg kpoint-panel popup-charge">
			<div class="mp_wrapper " style="padding: 8px 10px;">
				<?php echo "Bạn đang có: ".$this->get_balance_current_user(); ?>
				<h3>Chọn số lượng</h3>
				<?php
				$this->display_charge_point_frame($popup_context = true);
				?>

				<p></p>
				<div class="getways">
					<h3>Chọn cách thanh toán</h3>

					<ul class="usr-getways wc_payment_methods payment_methods methods" >
						<?php
						
						$enabled_gateways = [];

						if( $gateways ) {
						    foreach( $gateways as $gateway ) {

						        if( $gateway->enabled == 'yes' ) {

						            $enabled_gateways[] = $gateway;

						        }
						    }
						}
						foreach ($gateways as $g) {
							$selected = $getway_id == $g->id ? 'checked' : '';
							/*echo "<li class='wc_payment_method payment_method_$g->id'>
									<details>
									<summary><input type=\"radio\" $selected name=\"getway_id\" id=\"$g->id\" value=\"$g->id\" > <label for=\"$g->id\">$g->title</label>  </summary>
									<div class='form-fields'>";
							$g->payment_fields();
							echo "</div></details></li>";*/

							echo "<li class='wc_payment_method payment_method_$g->id'>									
									<input type=\"radio\" $selected name=\"getway_id\" id=\"$g->id\" value=\"$g->id\" > <label for=\"$g->id\">$g->title</label>";									
							
							echo "</li>";
						}

						?>
						
						
					</ul>
					
				</div>
				<p></p>
				<div class="process-charge-point">
					<input type="submit" class="button" name="process-charge-point" id="process-charge-point" value="Nạp" />
				</div>
			</div>

		</div>
		</form>
		<style type="text/css">
			a{
				text-decoration: none
			}
			.usr-getways {
				list-style: none;
				padding: 0 0;
			}

			
		</style>
		<script type="text/javascript">

			var rate_point_to_currency = "<?php echo $rate_point_to_currency; ?>";
			var point_label = "<?php echo KPOINT_UNIT_NAME; ?>";
			var currency_symbol = "<?php echo get_woocommerce_currency(); ?>";
		</script>
		<script type="text/javascript" src="<?php echo KPOINT_PLUGIN_URL . 'public/js/jquery-3.6.0.min.js?ver=' .KPOINT_VERSION ?>"></script>
		<script type="text/javascript" src="<?php echo KPOINT_PLUGIN_URL . 'public/js/scripts.js?ver='. KPOINT_VERSION ?>"></script>
		
		</body>
		</html>
		<?php
		die();
	}

	function add_free_point_when_registered($user_id){
		$kpoint = new KPoint($user_id);
		$free_point = $this->settings->get_setting('free_point_register');
		$note = sprintf('%s đã được tăng %s khi đăng ký tài khoản.', $user->user_login, KPoint::get_display_balance($free_point) );
		$kpoint->increse_point($free_point, "wp", 'create_account', $note);
	}

	public function get_balance_current_user(){
		$user =wp_get_current_user();
		if($user && isset($user->ID)){
			$user_id = $user->ID;
			$kpoint = new KPoint($user_id);
			
			return $kpoint->display_balance();
		}
		return "";
		
	}

	function display_charge_point_frame($popup_context = false){
		$products_buy = $this->settings->get_setting("list_num_point_to_buy");
		$product = $this->settings->get_buy_point_product();
		$product_id = $product->get_id();
		$link_product = get_the_permalink($product_id);
		$checkout_link = wc_get_checkout_url();
		$current_user_point = new KPoint();

    	
    	?>    	
    	
		<hr>
    	<div class="buy-point">
    		<h4 class="kp-title">Nạp <?php echo KPOINT_UNIT_NAME; ?></h4>
    		<?php if ($products_buy && count($products_buy) > 0) : ?>
		    	<?php 
		    		foreach ($products_buy as $point) : 
		    		
		    	?>
		    		<a href="<?php echo add_query_arg( array('add-to-cart' => $product_id,'custom_amount' => $point, 'reset_cart' => '1'), $checkout_link); ?>"><?php  echo KPoint::get_display_balance($point, false); ?></a>
		    	<?php endforeach; ?>
	    	<?php endif; ?>
	    	<a href="" id="buy_other_point">Khác</a>
	    	<br>

	    	<div id="other-amount-block" class="other-amount" style="display: none;">
	    		<form method="GET" action="<?php echo $checkout_link; ?>">
	    		<div class="input-group">
	    			<span class="input-group-addon"><?php echo KPOINT_UNIT_NAME; ?>:</span>
	    			<input type="text" id="kp-custom-amount" class="form-control numbers_only" value="" placeholder="Nhập số lượng" maxlength="12" autocomplete="off" name="custom_amount" style="border-color: rgb(30, 136, 229);">
	    		</div>
	    		<?php if(!$popup_context) { ?>
	    		<div class="input-group">
	    			<input type="hidden" name="add-to-cart" value="<?php echo $product_id; ?>">
	    			<input type="hidden" name="reset_cart" value="1">
	    			<input type="submit" class="button buy-point" name="submit" value="NẠP">
	    		</div>
	    		<?php } ?>
	    		</form>
	    	</div>
    	</div>
    	<?php
	}

	public function display_balance_current_user(){
		$products_buy = $this->settings->get_setting("list_num_point_to_buy");
		$product = $this->settings->get_buy_point_product();
		$product_id = $product->get_id();
		$link_product = get_the_permalink($product_id);
		$checkout_link = wc_get_checkout_url();
		$current_user_point = new KPoint();
		?>
		<div class="themebg kpoint-panel">
			<div class="mp_wrapper" style="padding: 8px 10px;">
				<?php echo "Bạn đang có: ".$this->get_balance_current_user(); ?>
		    	<?php $this->display_charge_point_frame(); ?>
		   	 	

		    	<hr>
		    	

		    	<div id="kp-logs-wrapper" class="">
		    		<a href="javascript: void(0)" id="view_kp_logs">Xem lịch sử giao dịch <span class="down">&darr;</span> <span class="up">&uarr;</span></a>
		    		<div id="kp-logs-inner" >
		    			<?php $current_user_point->show_logs_table(true) ?>	
		    		</div>
		    		
		    	</div>
		  	</div>
		</div>
		<?php
		
	}
}

KPoint_Manager::instance();