<?php
class Kpoint_Setting{
	
	public static $instance;
	private $settings;
	public static function instance(){
		if(!Kpoint_Setting::$instance){
			Kpoint_Setting::$instance = new Kpoint_Setting();
		}
		return Kpoint_Setting::$instance;
	}
	private function __construct (){
		add_action('admin_menu', array($this, 'register_settings_page'));
		add_action('admin_init', array($this, 'options_init'));
		add_action('wp_ajax_kpoint_update_user_point', array($this, 'update_user_point'));

		add_action( 'wp_ajax_search_gateway_product_category', array($this, 'search_gateway_product_category') ); 
		add_action( 'wp_ajax_search_gateway_product_tag', array($this, 'search_gateway_product_tag') ); 
	}

	function search_gateway_product_category(){
		$query = isset($_GET['q']) ? esc_attr( $_GET['q'] ) : "";
		$data = $this->query_product_taxonomy("product_cat");
		echo json_encode($data);
		die();
	}

	function query_product_taxonomy($taxonomy){

		

		$orderby = 'name';
		$order = 'asc';
		$hide_empty = false ;
		$cat_args = array(
		    'orderby'    => $orderby,
		    'order'      => $order,
		    'hide_empty' => $hide_empty,
		    'search' => $query,
		);
		 
		$product_categories = get_terms($taxonomy, $cat_args );
		$data = array();
		foreach ($product_categories as $key => $category) {
			$data[] = array(
				'label' => $category->name, 
				'value' => $category->term_id
			);
				
		}
		return $data;
		
	}

	function search_gateway_product_tag(){
		$query = isset($_GET['q']) ? esc_attr( $_GET['q'] ) : "";
		$data = $this->query_product_taxonomy("product_tag");
		echo json_encode($data);
		die();
	}

	function update_user_point(){
		if(!current_user_can('administrator')){
			echo "Bạn không đủ quyền để truy cập tính năng này!";
			die();
		}

		$user_id =  isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
		$new_amount = isset($_POST['new_amount']) ? floatval($_POST['new_amount']) : "not_ok";
		$note = isset($_POST['note']) ? sanitize_text_field($_POST['note']) : "";
		$nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : "";


		if( !wp_verify_nonce($nonce, 'edit_point_' . $user_id)) {
			wp_send_json(array(
				'status' => 'fail',
				'message' => "Lược chỉnh sửa hết hạn. Vui lòng tải lại trang"
			));
		  	wp_die();
		}

		if($user_id == 0 || $new_amount === "not_ok"){
			
			wp_send_json(array(
				'status' => 'fail',
				'message' => "thông tin không hợp lệ"
			));
			die();
		}

		$user_point = new KPoint($user_id);
		$current_amount = $user_point->get_balance();
		$change_value = floatval($new_amount) - $current_amount;

		if($change_value >= 0){
			$note .= ". Tăng " .KPoint::get_display_balance($change_value) . ' bởi admin';
			$user_point->increse_point(abs($change_value), "admin", date("d-m-y H:i:s"), $note);
		}else{
			$note .= ". Giảm " . KPoint::get_display_balance($change_value) . ' bởi admin';
			$user_point->decrese_point(abs($change_value), "admin", date("d-m-y H:i:s"), $note);
		}

		wp_send_json(array(
			'status' => 'done',
			'message' => $user_point->display_balance()
		));
		

		die();
	}

	function options_init() {
		
	}

	function register_settings_page() {

		$page = add_submenu_page('options-general.php', 
			KPOINT_PLUGIN_TITLE, 
			KPOINT_PLUGIN_TITLE, 
			'manage_options', 
			KPOINT_PLUGIN_SLUG,
			array($this, 'settings_page')
		);
	}

	public function get_buy_point_product(){
		$buy_point_product_id = $this->get_setting("buy_point_product_id");
		$product = wc_get_product($buy_point_product_id);

		if(!$product || $product->get_status() == "trash"){
			$product = $this->create_product_buy_point();
			$this->update_setting("buy_point_product_id", $product->get_id());
		}
		return $product;
	}

	public function create_product_buy_point(){
		$post = array(		    
		    'post_content' => '',
		    'post_status' => "publish",
		    'post_title' => "Nạp " . KPOINT_UNIT_NAME,
		    'post_parent' => '',
		    'post_type' => "product",
		);
		$post_id = wp_insert_post( $post );
		
		if($post_id){
			$product = wc_get_product($post_id);
			$product->set_regular_price(1);
			$product->set_sold_individually( true );
			$product->set_virtual( true );
			$product->set_manage_stock( false );
			$product->save();
		    update_post_meta($post_id, 'kpoint_buy_point_product', 1);
		    update_post_meta($post_id, 'kiot_unassigned', 1);
		    $terms = array( 'exclude-from-search', 'exclude-from-catalog' ); // for hidden..
			wp_set_post_terms( $post_id, $terms, 'product_visibility', false );
		}
		return $product;

	}

	public function save_settings(){
		update_option(KPOINT_SETTING_OPTION_KEY,$this->settings);
	}

	public function update_setting($key, $value){
		$this->settings[$key] = $value;
		update_option(KPOINT_SETTING_OPTION_KEY,$this->settings);
	}

	public function get_settings(){
		//delete_option('ssa_settings');
		$buy_products = $this->get_products_to_buy();
		$default_options = array(
								  'point_unit_name' => 'Điểm K-Point',
								  'rate_currency_to_point' => 1000,
								  'rate_point_to_currency' => 0.001,
								  'products_to_buy' => $buy_products,
								  'text_promo_cart' => 'Bạn được tặng {point} với đơn hàng này',
								  'free_point_register' => 0,
								  'gif_point_when_buy' => 0,
								  'gif_point_type' => 'percent',
								  'gif_point_max_order' => 0,
								  'gif_point_min_order' => 200000,
								  'using_enable_getway' => 1,
								  'using_list_discount' => array(),
								  'using_enable_customer_input_discount' => 1,
								  'not_add_gift_point_for_point_gateway' => 1,
								  'buy_point_product_id' => 0,
								  'list_num_point_to_buy' => array(),
								  'number_decimal' => 0,
								  'limit_gif_point_per_order' => 0,
								  'max_input_discount_value' => "",
								  'enable_up_bill' => "no",
								  'default_order_completed_status_point_getway' => "completed",
								  'show_point_in_product' => 1,
								  'product_categories_for_gateway' => array(),
								  'only_product_categories_for_gateway' => array(),
								  'product_tags_for_gateway' => array(),
								  'only_product_tags_for_gateway' => array(),
								);
		if(!get_option(KPOINT_SETTING_OPTION_KEY)) { // Doesn't exist -> set defaults

			add_option(KPOINT_SETTING_OPTION_KEY,$default_options);
		}

		$current_options = get_option(KPOINT_SETTING_OPTION_KEY);

		$this->settings = array_merge($default_options, $current_options);
		
		
		$this->settings['products_to_buy'] = $buy_products;
		return $this->settings;
	}
	public function get_setting($name){
		if(isset($this->settings[$name])) return $this->settings[$name];
		return null;
	}

	public function get_products_to_buy($fields = 'ids'){
		return get_posts(array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'posts_per_page' => -1,	
			'meta_key' => 'keypoint_amount',
			'fields' => $fields
			)
		);
	}

	function settings_page() { 
		if(!current_user_can('administrator')){
			echo "you can not access this page!";
			return;
		}
		
		$buy_point_link = admin_url('options-general.php?page='.KPOINT_PLUGIN_SLUG.'&tab=buy_point');
		$using_point_link = admin_url('options-general.php?page='.KPOINT_PLUGIN_SLUG.'&tab=using_point');
		$users_tab_link = admin_url('options-general.php?page='.KPOINT_PLUGIN_SLUG.'&tab=users');
		$config_tab_link = admin_url('options-general.php?page='.KPOINT_PLUGIN_SLUG);
		$current_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : '';
		

		if(isset($_POST['cap_nhat_menh_gia'])){
			
			$list_num_point_to_buy = isset($_POST['list_num_point_to_buy']) ? sanitize_textarea_field($_POST['list_num_point_to_buy']) : '';
			$enable_up_bill = isset($_POST['enable_up_bill']) ? sanitize_textarea_field($_POST['enable_up_bill']) : 'no';
			$list_num_point_to_buy = explode("\n", $list_num_point_to_buy);
			$new_list = array();
			foreach($list_num_point_to_buy as $num){
				$num = trim($num);				
				if($num == "") continue;
				if(is_numeric($num)){
					$new_list[] = $num;
				}else{
					echo "<p style=\"color:red\">$num không phải là số hợp lệ</p>";
				}
			}

			
			$this->update_setting("list_num_point_to_buy",$new_list);
			$this->update_setting("enable_up_bill",$enable_up_bill);

			echo '<p style="color:green">Đã cập nhật các mệnh giá mới!</p>';
		}

		if(isset($_GET['thankyou'])){
			echo '<p style="color:green">Cám ơn bạn. Chúng tôi ghi nhận góp ý của bạn.</p>';
		}
		?>


		<div class="wrap" style="margin-top: 32px">	
			<h1><?php echo KPOINT_PLUGIN_TITLE;  ?> <span class="version">v<?php echo KPOINT_VERSION;?></span></h1>
			<div class="tab">
			<a href="<?php echo $config_tab_link;?>" class="<?php echo $current_tab == '' ? 'active': '' ;?>">Cấu hình chung</a> |
			<a href="<?php echo $using_point_link; ?>"class="<?php echo $current_tab == 'using_point' ? 'active': '' ;?>">Dùng <?php echo KPOINT_UNIT_NAME ?></a> | 
			<a href="<?php echo $users_tab_link; ?>" class="<?php echo $current_tab == 'users' ? 'active': '' ;?>">Quản lý <?php echo KPOINT_UNIT_NAME ?></a> |
			<a href="<?php echo $buy_point_link; ?>"class="<?php echo $current_tab == 'buy_point' ? 'active': '' ;?>">Mua <?php echo KPOINT_UNIT_NAME ?></a> 
			 
			
		</div>

			
		<?php

		$tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']): '';
		switch ($tab) {
			case 'buy_point':
				$this->buy_point_tab();
				break;
			case 'users':
				$this->users_tab();
				break;
			case 'using_point':
				$this->using_point_tab();
				break;
			default:
				$this->general_config_tab();
				break;
		}

		?>
		<br>
		<div id="gopy">
			<hr>
			<br>
			<form method="POST" action="http://mecode.pro/">
				<textarea rows="3" cols="100" placeholder="Bạn cần thêm tính năng gì? Chúng tôi đang nâng cấp K-POINT" name="request_detail"></textarea>
				<input type="hidden" name="plugin_name" value="kpoint">
				<input type="hidden" name="current_page" value="<?php echo home_url($_SERVER['REQUEST_URI']) ?>">
				<input type="hidden" name="action" value="send_custom_function_request">
				<p>
					<input type="submit" value="GỬI" name="">
				</p>
			</form>
			
		</div>
		<?php

	}

	function users_tab(){
		$all_users = get_users( );
		$user_table = new KP_UserPoint_Table();
	    $user_table->prepare_items();
		?>
		<div class="wrap">    
	    
	        <div id="nds-wp-list-table-demo">			
	            <div id="nds-post-body">		
				<form id="nds-user-list-form" method="get">
					<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
					<input type="hidden" name="tab" value="<?php echo $_REQUEST['tab'] ?>" />
					<?php 
						$user_table->search_box("Tìm" , 'kpoint');
						
					?>					
				</form>
	            </div>			
	        </div>
		</div>
		<?php 
		
	    $user_table->display();
		?>
		<br><br>
		
		<style type="text/css">
			input[name="kp_new_value"]{
			width: 230px;
			}

			.kp_update_user_point_btn{
			height: 30px;
			position: relative;
			bottom:3px;
			}

			.kp-edit{
			display: none;
			}

			.kp_edit_user_point{
			cursor: pointer;

			}

			.kp_edit_user_point:hover{
			font-weight: 700;
			}

			.view-edit-wrapper.editing .kp-view{
			display: none;
			}

			.view-edit-wrapper.editing .kp-edit{
			display: block;
			}

			.kp-edit .error{
			color: red;
			}
		</style>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('.kp_edit_user_point').click(function(){
				    var user_id = jQuery(this).data('user_id');
				    jQuery('#kp_user_id'+user_id).addClass('editing');
				});


				jQuery('.kp_update_user_point_btn').click(function(){
					var user_id = jQuery(this).data('user_id');
					var new_amount = jQuery('#kp_user_id'+user_id + ' input[name="kp_new_value"]').val();
					var note = jQuery('#kp_user_id'+user_id + ' input[name="kp_update_note"]').val();
					var nonce = jQuery('#kp_user_id'+user_id + ' input[name="_wpnonce"]').val();
					//kpoint_update_user_point
					var data = {
						new_amount : new_amount,
						nonce : nonce,
						note: note,
						user_id: user_id,
						action: 'kpoint_update_user_point'
					};
					jQuery.post(ajaxurl, data, function(res){
						if(res.status == 'done'){
							jQuery('#kp_user_id'+user_id + ' .kp-view .kp-value').text(res.message);
							jQuery('#kp_user_id'+user_id).removeClass('editing');
							jQuery('#kp_user_id'+user_id + ' .error').text("");
						}else{
							jQuery('#kp_user_id'+user_id + ' .error').text(res.message);
						}
					});
				});
			});


		</script>
		<?php

	}

	function buy_point_tab(){
		
		$sample_price = 1000;
		$sample_point = $sample_price * $this->settings['rate_currency_to_point'];
		$list_num_point_to_buy = $this->settings['list_num_point_to_buy'];
		$enable_up_bill = $this->settings['enable_up_bill'];
		if(count($list_num_point_to_buy) == 0){
			$products_buy = $this->get_products_to_buy('all');
			foreach ($products_buy as $post_product){
				$product = wc_get_product($post_product->ID);        		
        		$point = get_post_meta($post_product->ID,'keypoint_amount', true);
        		$list_num_point_to_buy[] = $point;
        		
			}
			$list_num_point_to_buy = array_reverse($list_num_point_to_buy);
			$this->update_setting("list_num_point_to_buy", $list_num_point_to_buy);
		        		
		}
		

		$list_num_point_to_buy = implode("\n", $list_num_point_to_buy);
		$place_holder = "Mệnh giá 1\nMệnh giá 2\nMệnh giá 3\n";

		if($list_num_point_to_buy == ""){
			echo "<p style='color: red'>Hãy lên mệnh giá nạp, ví dụ: 10,25,50,100,250</p>";
		}
		?>
			<div>
				<form method="post" action="" class="kpoint-container">					
					<p>
						Số mệnh giá <?php echo KPOINT_UNIT_NAME; ?> cần nạp
					</p>
					<p>
						<textarea name="list_num_point_to_buy" placeholder="<?php echo $place_holder ?>" rows="5" cols="50"><?php echo $list_num_point_to_buy; ?></textarea>

					</p>
					<p><input type="checkbox" <?php checked($enable_up_bill, "yes")?> name="enable_up_bill" value="yes"> Cho phép up bill nạp tiền (dành cho nạp tiền thủ công)</p>
					
					<input type="submit" value="Cập nhật" name="cap_nhat_menh_gia">	
				</form>
			</div>
		<?php

	}

	function using_point_tab(){
			
			wp_enqueue_script('select2');
			wp_enqueue_style( 'woocommerce_admin_styles' );

			if(isset($_POST['update'])){
				$using_enable_getway = isset($_POST['using_enable_getway']) ? 1 : 0;
				$using_enable_customer_input_discount = isset($_POST['using_enable_customer_input_discount']) ? 1 : 0;
				$not_add_gift_point_for_point_gateway = isset($_POST['not_add_gift_point_for_point_gateway']) ? 1 : 0;
				$max_input_discount_value = isset($_POST['max_input_discount_value']) ? intval($_POST['max_input_discount_value']) : "";
				$default_order_completed_status_point_getway = isset($_POST['default_order_completed_status_point_getway']) ? sanitize_text_field($_POST['default_order_completed_status_point_getway']) : "completed";
				$product_categories_for_gateway = isset($_POST['product_categories_for_gateway']) ? $_POST['product_categories_for_gateway'] : array();
				$product_tags_for_gateway = isset($_POST['product_tags_for_gateway']) ? $_POST['product_tags_for_gateway'] : array();

				$only_product_categories_for_gateway = isset($_POST['only_product_categories_for_gateway']) ? $_POST['only_product_categories_for_gateway'] : array();
				$only_product_tags_for_gateway = isset($_POST['only_product_tags_for_gateway']) ? $_POST['only_product_tags_for_gateway'] : array();

				if(is_array($product_categories_for_gateway)){
					$this->settings['product_categories_for_gateway'] = $product_categories_for_gateway;
				}

				if(is_array($product_tags_for_gateway)){
					$this->settings['product_tags_for_gateway'] = $product_tags_for_gateway;
				}

				if(is_array($only_product_categories_for_gateway)){
					$this->settings['only_product_categories_for_gateway'] = $only_product_categories_for_gateway;
				}

				if(is_array($only_product_tags_for_gateway)){
					$this->settings['only_product_tags_for_gateway'] = $only_product_tags_for_gateway;
				}

				$this->settings['using_enable_getway'] = $using_enable_getway;
				$this->settings['max_input_discount_value'] = $max_input_discount_value;
				$this->settings['using_enable_customer_input_discount'] = $using_enable_customer_input_discount;
				$this->settings['not_add_gift_point_for_point_gateway'] = $not_add_gift_point_for_point_gateway;
				$this->settings['default_order_completed_status_point_getway'] = $default_order_completed_status_point_getway;
				
				if(isset($_POST['using_list_discount_value']) && $_POST['using_list_discount_type']){
					$count = count($_POST['using_list_discount_value']);
					$list = array();
					for($i=0; $i < $count; $i++){
						$type = isset($_POST['using_list_discount_type'][$i]) ? $_POST['using_list_discount_type'][$i] : '';
						$value = isset($_POST['using_list_discount_value'][$i]) ? $_POST['using_list_discount_value'][$i] : '';
						$key = isset($_POST['using_list_discount_key'][$i]) ? $_POST['using_list_discount_key'][$i] : '';
						$value = floatval($value);
						$list[] = array(
							'type' => $type,
							'value' => $value,
							'key' => $key
						);
						$this->settings['using_list_discount'] = $list;
					}

				}
				$this->save_settings();
			}


			?>
			<div>
				<form method="post"  class="kpoint-container">
					<h3>Cổng Thanh Toán Bằng <?php echo KPOINT_UNIT_NAME ?></h3>					
					<p>
						<input  name="using_enable_getway" type="checkbox" <?php echo $this->settings['using_enable_getway'] == 1 ? 'checked' : ''; ?> />  Bật cổng thanh toán bằng <?php echo KPOINT_UNIT_NAME; ?> (<a href="<?php echo admin_url("admin.php?page=wc-settings&tab=checkout&section=kpoint") ?>">cấu hình payment gateway</a>)<br>
					        	<i></i>
					</p>
					<p>
						<label>Tình trạng đơn hàng mặc định sau khi thanh toán</label>
						<select name="default_order_completed_status_point_getway">
							<?php
								$all_status = wc_get_order_statuses();
								unset($all_status['wc-cancelled']);
								unset($all_status['wc-refunded']);
								unset($all_status['wc-failed']);
								$current_status = $this->settings['default_order_completed_status_point_getway'];
								foreach($all_status as $status_key => $status_label){
									$status_key = str_replace("wc-","",$status_key);
									$selected = selected($current_status, $status_key, false);
									echo "<option $selected value='$status_key'>{$status_label}</option>";
								}
							?>
						</select>
					</p>
					<p>
						<strong>Chỉ áp dụng cổng thanh toán cho:</strong><br>
						- Danh mục: 
						<select style="width: 250px" multiple name="product_categories_for_gateway[]" id="product_categories_for_gateway">
							<option>Chọn danh mục </option>
							<?php foreach($this->settings['product_categories_for_gateway'] as $cat_id){
								$cat_term = get_term( $cat_id );
								$cat_name = isset($cat_term->name) ? $cat_term->name : 'n/a';
								echo "<option value=\"$cat_id\" selected>$cat_name</option>";
							}?>
						</select> 
						<br>
						<br>
						- Từ khoá: 
						<select style="width: 250px" multiple name="product_tags_for_gateway[]" id="product_tags_for_gateway">
							<option>Chọn tag product </option>
							<?php foreach($this->settings['product_tags_for_gateway'] as $cat_id){
								$cat_term = get_term( $cat_id );
								$cat_name = isset($cat_term->name) ? $cat_term->name : 'n/a';
								echo "<option value=\"$cat_id\" selected>$cat_name</option>";
							}?>
						</select>
					</p>
					<p>
						<strong>Chỉ duy nhất cổng thanh toán KPoint (không hiện cách thanh toán khác) cho:</strong><br>

						- Danh mục: 
						<select style="width: 250px" multiple name="only_product_categories_for_gateway[]" id="only_product_categories_for_gateway">
							<option>Chọn danh mục </option>
							<?php foreach($this->settings['only_product_categories_for_gateway'] as $cat_id){
								$cat_term = get_term( $cat_id );
								$cat_name = isset($cat_term->name) ? $cat_term->name : 'n/a';
								echo "<option value=\"$cat_id\" selected>$cat_name</option>";
							}?>
						</select> 
						<br>
						<br>
						- Từ khoá: 
						<select style="width: 250px" multiple name="only_product_tags_for_gateway[]" id="only_product_tags_for_gateway">
							<option>Chọn tag product </option>
							<?php foreach($this->settings['only_product_tags_for_gateway'] as $cat_id){
								$cat_term = get_term( $cat_id );
								$cat_name = isset($cat_term->name) ? $cat_term->name : 'n/a';
								echo "<option value=\"$cat_id\" selected>$cat_name</option>";
							}?>
						</select>
					</p>

					<script type="text/javascript">
						jQuery(document).ready(function(){

							var processResultsFunc = function( data ) {
								var options = [];
								if ( data ) {					
									
									jQuery.each( data, function( index, item ) {
										options.push( { id: item.value, text: item.label  } );
									});
								
								}
								return {
									results: options
								};
						  	};

							var category_ajax_options = {
						  		url: ajaxurl,
							    dataType: 'json',
							    delay: 250,
							    cache: true,							   
							    
							};

							var tag_ajax_options = JSON.parse(JSON.stringify(category_ajax_options));

							category_ajax_options.data = function (params) {
			      				return {
			        				q: params.term, // search query
			        				action: 'search_gateway_product_category' // AJAX action for admin-ajax.php
			      				};
			    			};

			    			category_ajax_options.processResults = processResultsFunc;

							

							tag_ajax_options.data = function (params) {
			      				return {
			        				q: params.term, // search query
			        				action: 'search_gateway_product_tag' // AJAX action for admin-ajax.php
			      				};
			    			};

			    			tag_ajax_options.processResults = processResultsFunc;

							jQuery('#product_categories_for_gateway').select2({
							  	ajax: category_ajax_options,
								minimumInputLength: 3
							});

							jQuery('#product_tags_for_gateway').select2({
							  	ajax: tag_ajax_options,
								minimumInputLength: 3
							});

							jQuery('#only_product_categories_for_gateway').select2({
							  	ajax: category_ajax_options,
								minimumInputLength: 3
							});

							jQuery('#only_product_tags_for_gateway').select2({
							  	ajax: tag_ajax_options,
								minimumInputLength: 3
							});
						});
					</script>


					<h3>Chương trình giảm giá với điểm thưởng</h3>
					<table>
				    	<tr valign="top">							
							<th>Loại giảm giá</th>
							<th>Giá trị giảm</th>							
					    </tr>
					    <?php
					    $max = 5;
					    for($i =0 ; $i < $max; $i++) {
					    	$type = "fixed";
					    	$value = "";
					    	$checkFixed = "selected";
					    	$checkPercent = "";
					    	$key = 'key_'.uniqid();
					    	if($i < count($this->settings['using_list_discount'])){
					    		$item = $this->settings['using_list_discount'][$i];
					    		$type = $item['type'];
					    		$value = $item['value'];
					    		$key = $item['key'];
					    		if($type == "fixed"){
					    			$checkFixed = "selected";
					    			$checkPercent = "";
					    		}else{
					    			$checkFixed = "";
					    			$checkPercent = "selected";
					    		}
					    	}
					    	$key = $key ? $key : 'key_'.uniqid();
					    ?>
						    <tr>
						    	<td>
						    		<select name="using_list_discount_type[]">
						    			<option value="fixed" <?php echo $checkFixed ?> >Giá tiền cố định</option>
						    			<option value="percent" <?php echo $checkPercent ?> >Theo % đơn hàng</option>
						    		</select>
						    	</td>
						    	<td>
						    		<input type="hidden" name="using_list_discount_key[]" value="<?php echo $key; ?>">
						    		<input type="text" name="using_list_discount_value[]" value="<?php echo $value; ?>">
						    	</td>

						    	
						    </tr>
						<?php } ?>
					    
					</table>
					<p>
						<input  name="using_enable_customer_input_discount" id="using_enable_customer_input_discount" type="checkbox" <?php echo $this->settings['using_enable_customer_input_discount'] == 1 ? 'checked' : ''; ?> />  <label for="using_enable_customer_input_discount">Cho khách tuỳ chỉnh số điểm sử dụng khi thanh toán nhưng tối đa là </label><input type="number" style="width: 270px" placeholder="không giới hạn nếu để là 0 hoặc trống" name="max_input_discount_value" value="<?php echo $max_input_discount_value; ?>"> <br>
					        	<i></i>
					</p>
					<p>
						<input  name="not_add_gift_point_for_point_gateway" id="not_add_gift_point_for_point_gateway" type="checkbox" <?php echo $this->settings['not_add_gift_point_for_point_gateway'] == 1 ? 'checked' : ''; ?> />  <label for="not_add_gift_point_for_point_gateway">Không tặng <?php echo KPOINT_UNIT_NAME ?> cho đơn hành thanh toán bằng <?php echo KPOINT_UNIT_NAME; ?> (payment gateway)</label>
					</p>

					<br><br>
					<input type="submit" class="button" value="Cập Nhật" name="update">	
				</form>
			</div>
		<?php
	}

	function general_config_tab(){
			if(isset($_POST['update'])){
				$point_unit_name = isset($_POST['point_unit_name']) ? sanitize_text_field( $_POST['point_unit_name'] ) : 'điểm';
				$text_promo_single_product = isset($_POST['text_promo_single_product']) ? sanitize_text_field( $_POST['text_promo_single_product'] ) : '';
				$text_promo_cart = isset($_POST['text_promo_cart']) ? sanitize_text_field( $_POST['text_promo_cart'] ) : '';
				$gif_point_type = isset($_POST['gif_point_type']) ? sanitize_text_field( $_POST['gif_point_type'] ) : 'percent';
				$rate_currency_to_point = isset($_POST['rate_currency_to_point']) ? floatval( $_POST['rate_currency_to_point'] ) : 0;
				$rate_point_to_currency= isset($_POST['rate_point_to_currency']) ? floatval( $_POST['rate_point_to_currency'] ) : 0;
				$free_point_register = isset($_POST['free_point_register']) ? floatval( $_POST['free_point_register'] ) : 0;
				
				$gif_point_when_buy = isset($_POST['gif_point_when_buy']) ? floatval( $_POST['gif_point_when_buy'] ) : 0;
				$gif_point_min_order = isset($_POST['gif_point_min_order']) ? floatval( $_POST['gif_point_min_order'] ) : 0;
				$gif_point_max_order = isset($_POST['gif_point_max_order']) ? floatval( $_POST['gif_point_max_order'] ) : 0;
				$limit_gif_point_per_order = isset($_POST['limit_gif_point_per_order']) ? floatval( $_POST['limit_gif_point_per_order'] ) : 0;
				$show_point_in_product = isset($_POST['show_point_in_product']) ? sanitize_text_field( $_POST['show_point_in_product'] ) : 0;
				$number_decimal = isset($_POST['number_decimal']) ? floatval( $_POST['number_decimal'] ) : 0;
				$this->settings['point_unit_name'] = $point_unit_name;
				$this->settings['rate_currency_to_point'] = $rate_currency_to_point;
				$this->settings['rate_point_to_currency'] = $rate_point_to_currency;
				$this->settings['free_point_register'] = $free_point_register;
				$this->settings['gif_point_when_buy'] = $gif_point_when_buy;
				$this->settings['gif_point_min_order'] = $gif_point_min_order;
				$this->settings['gif_point_max_order'] = $gif_point_max_order;
				$this->settings['text_promo_single_product'] = $text_promo_single_product;
				$this->settings['text_promo_cart'] = $text_promo_cart;
				$this->settings['number_decimal'] = $number_decimal;
				$this->settings['limit_gif_point_per_order'] = $limit_gif_point_per_order;
				$this->settings['gif_point_type'] = $gif_point_type;
				$this->settings['show_point_in_product'] = $show_point_in_product;
				$this->save_settings();
			}
		
			?>
			<div>
				<form method="post"  class="kpoint-container">
					
					
					<table class="form-table">
				    	<tr valign="top">
							<th scope="row">Đơn vị điểm</th>
					    	<td class="activated">
					        	<input id="activated" name="point_unit_name" type="text" value="<?php echo $this->settings['point_unit_name']; ?>" />  &nbsp; &nbsp; <br>
					        	<i>Điểm, Xèng, Ngân Lượng, Xu, Mana ...</i>

					        </td>
					    </tr>
					    <tr valign="top">
							<th scope="row">Tỉ giá </th>
					    	<td class="activated">
					        	<?php echo wc_price(1) ?> đổi được bao nhiêu <?php echo KPOINT_UNIT_NAME; ?>? <input id="rate_currency_to_point" name="rate_currency_to_point" type="text" value="<?php echo $this->settings['rate_currency_to_point']; ?>" />  &nbsp; &nbsp; 
					        	
					        	<br>
					        	Hoặc 1 <?php echo KPOINT_UNIT_NAME; ?> đổi được bao nhiêu <?php echo get_woocommerce_currency_symbol() ?>?  <input id="rate_point_to_currency" name="rate_point_to_currency" type="text" value="<?php echo $this->settings['rate_point_to_currency']; ?>" />  &nbsp; &nbsp; <br>
					        	

					        </td>
					    </tr>

					     <tr valign="top">
							<th scope="row">Số dư thập phân</th>
					    	<td class="activated">
					        	<input id="activated" name="number_decimal" type="number" min="0" max="2" value="<?php echo $this->settings['number_decimal']; ?>" />  &nbsp; &nbsp; 
					        	<i>số . Ví dụ: 2 => 15.66 hoặc 1 => 15.6 hoặc 0 => 15</i>
					        	
					        	
					        </td>
					    </tr>

					    <tr valign="top">
							<th scope="row"><?php echo KPOINT_UNIT_NAME; ?> tặng khi tạo tài khoản </th>
					    	<td class="activated">
					        	<input id="activated" name="free_point_register" type="text" value="<?php echo $this->settings['free_point_register']; ?>" />  &nbsp; &nbsp; <br>
					        	<i>để 0 để không tặng khi đăng ký tài khoản</i>

					        </td>
					    </tr>

					    <tr valign="top">
							<th scope="row"><?php echo KPOINT_UNIT_NAME; ?> tặng khi mua hàng </th>
					    	<td class="activated">
					        	<input id="activated" name="gif_point_when_buy" type="text" value="<?php echo $this->settings['gif_point_when_buy']; ?>" />  
					        	<select name="gif_point_type">
					        		<option <?php  selected('percent', $this->settings['gif_point_type']) ?> value="percent">% Đơn Hàng</option>
					        		<option <?php  selected('fixed', $this->settings['gif_point_type']) ?> value="fixed">Cố định</option>
					        		<option <?php  selected('per_cat_and_product', $this->settings['gif_point_type']) ?> value="per_cat_and_product">Theo <?php echo KPOINT_UNIT_NAME; ?> nhập riêng</option>
					        	</select>
					        	<br><i>Theo <?php echo KPOINT_UNIT_NAME; ?> nhập riêng theo danh mục và sản phẩm: Bạn có thể nhập trong danh sách sản phẩm hoặc danh mục khi bật cài đặt này. <br> Danh mục hoặc sản phẩm nào không nhập sẽ tính theo phần trăm mặc định</i>
					        </td>
					    </tr>
					    <tr>
					    	<th scope="row">Tặng tối đa <?php echo KPOINT_UNIT_NAME; ?>  trên 1 đơn hàng</th>
					    	<td>
					    		<input name="limit_gif_point_per_order" type="text" value="<?php echo $this->settings['limit_gif_point_per_order']; ?>" />
					        	<i>để 0 để không khống chế số điểm tặng tối đa</i>
					    	</td>
					    </tr>
					    <tr>
					    	<th scope="row">Điều kiện đơn hàng</th>
					    	<td>
					    		Điều kiện số tiền tối thiểu đơn hàng<br><input id="activated" name="gif_point_min_order" type="text" value="<?php echo $this->settings['gif_point_min_order']; ?>" /> <i>để 0 để không ràng buột</i>
					        	<br>Điều kiện số tiền tối đa đơn hàng<br>
					        	<input id="activated" name="gif_point_max_order" type="text" value="<?php echo $this->settings['gif_point_max_order']; ?>" />
					        	<i>để 0 để không ràng buột</i>
					    	</td>
					    </tr>
					    

					    <tr valign="top">
							<th scope="row">Chú thích tặng điểm cho khách trong trang đặt hàng </th>
					    	<td >
					        	<input style="width: 400px"  name="text_promo_cart" type="text" value="<?php echo $this->settings['text_promo_cart']; ?>" />  &nbsp; &nbsp; <br>
					        	<i>{point} sẽ tự động điền thành số điểm thực tế</i>

					        </td>
					    </tr> 

					    <tr valign="top">
							<th scope="row">Hiện số <?php echo KPOINT_UNIT_NAME ?> tương ứng trong danh sách sản phẩm</th>
					    	<td >
					        	<input   name="show_point_in_product" type="checkbox" <?php checked($this->settings['show_point_in_product'], "1") ?> value="1" /> 

					        </td>
					    </tr>
					</table>
					<input type="submit" class="button" value="Cập Nhật" name="update">	
				</form>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					function update_point_to_currency(){
						var val = jQuery('#rate_point_to_currency').val();
						var rate = 1/val;
						jQuery('#rate_currency_to_point').val(rate);
					}

					function update_currency_to_point(){
						var val = jQuery('#rate_currency_to_point').val();
						var rate = 1/val;
						jQuery('#rate_point_to_currency').val(rate);
					}

					jQuery('#rate_point_to_currency').keypress(function(){
						update_point_to_currency();
					});
					jQuery('#rate_point_to_currency').change(function(){
						update_point_to_currency();
					});

					jQuery('#rate_currency_to_point').keypress(function(){
						update_currency_to_point();
					});
					jQuery('#rate_currency_to_point').change(function(){
						update_currency_to_point();
					});
				});
			</script>
		<?php
	}



}