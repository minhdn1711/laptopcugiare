<?php

//Chuyển hướng đăng nhập
add_action('template_redirect', 'redirect_non_logged_in_users_to_account_page_with_message');

function redirect_non_logged_in_users_to_account_page_with_message() {
    if (is_checkout() && !is_user_logged_in()) {
        wc_add_notice('Bạn phải đăng nhập hoặc tạo tài khoản để tiến hành thanh toán.', 'notice');

        // Lấy URL của trang tài khoản
        $account_page_url = get_permalink(get_option('woocommerce_myaccount_page_id'));
        wp_redirect($account_page_url);
        exit;
    }
}




//Thay chữ trong web
add_filter( 'gettext', 'hocwordpress_translate_woocommerce_strings', 999 );

function hocwordpress_translate_woocommerce_strings( $translated ) {

$translated = str_ireplace( 'Quick View', 'Xem nhanh', $translated );
$translated = str_ireplace( 'Thoát', 'Đăng xuất', $translated );
return $translated;
}

// Chèn câu hỏi và trả lời sau sản phẩm
add_action('woocommerce_after_single_product', 'display_product_questions_answers', 20);

function display_product_questions_answers() {
    echo do_shortcode('[yith_woocommerce_questions_and_answers]');
}



//Mã ưu đãi
add_action( 'woocommerce_after_cart_totals', 'add_custom_coupon_section' );
function add_custom_coupon_section() {
    ?>
    <?php echo do_shortcode('[block id="ma-uu-dai"]'); ?>
    <?php
}

//Việt hoá
function my_custom_translations( $translated_text, $text, $domain ) {
    // Kiểm tra và thay đổi các chuỗi cần việt hóa
    switch ( $translated_text ) {
        case 'Product name':
            $translated_text = 'Tên sản phẩm';
            break;
        case 'Unit price':
            $translated_text = 'Đơn giá';
            break;
        case 'Stock status':
            $translated_text = 'Tình trạng kho';
            break;
        case 'Wishlist':
            $translated_text = 'Danh sách yêu thích';
            break;
        case 'No products added to the wishlist':
            $translated_text = 'Chưa có sản phẩm nào trong danh sách yêu thích';
            break;
    }
    return $translated_text;
}
add_filter( 'gettext', 'my_custom_translations', 20, 3 );



//Tắt thông báo bảng tin
add_action('admin_head', 'wpcb_disable_notice'); 
function wpcb_disable_notice() { ?> <style> .notice { display: none;} </style> <?php }

// Dich tieng viet
function ra_change_translate_text($translated_text)
{
    if ($translated_text == 'Old Text') {
        $translated_text = 'New Translation';
    }
    return $translated_text;
}

add_filter('gettext', 'ra_change_translate_text', 20);
function ra_change_translate_text_multiple($translated)
{
    $text = array(
        'Lưu trữ Danh mục: ' => '',
    );
    $translated = str_ireplace(array_keys($text), $text, $translated);
    return $translated;
}

add_filter('gettext', 'ra_change_translate_text_multiple', 20);


// Khuyến mại
function display_khuyen_mai()
{
    if (get_field('khuyen_mai')) {
        echo '<div class="block-promotion"><div class="heading-promo">
<i class="fas fa-gift"></i> Khuyến mãi đặc biệt</div><div class="promo-content"><p>' . get_field('khuyen_mai') . '</p></div></div>';
    }
}

add_action('flatsome_custom_single_product_1', 'display_khuyen_mai', 1);

// Thông số kỹ thuật
function display_thong_so_ky_thuat()
{
    if (get_field('thong_so_ky_thuat')) {
        echo '<h3 style="margin-top: 20px">GIỚI THIỆU</h3><div class="bgthongso"><p>' . get_field('thong_so_ky_thuat') . '</p></div>';
    }
}

add_action('flatsome_custom_single_product_3', 'display_thong_so_ky_thuat', 1);

//  Xóa bộ lọc mặc định của Woocommerce

function removedefault()
{
    remove_action('flatsome_category_title_alt', 'woocommerce_result_count', 20);
    remove_action('flatsome_category_title_alt', 'woocommerce_catalog_ordering', 30);
}

//add_action('init', 'removedefault');

// // Thêm bộ lọc sản phẩm giống thế giới di động

function filter_new_giuseart()
{
    if (!is_product()): ; ?>
        <?php if (!wp_is_mobile()) {
            ; ?>
            <div class="sort_giuseart">
                <div class="titlesort">Sắp xếp theo:</div>
                <form id="pricedesc">
                    <div class="range-check">
                        <input class="pt-checkbox" type="checkbox" value="price-desc" id="price-desc" name="orderby"
                               onChange="this.form.submit()"/>
                        <label for="price-desc">Giá giảm dần</label>
                    </div>
                </form>
                <form id="pricesmall">
                    <div class="range-check">
                        <input class="pt-checkbox" type="checkbox" value="price" id="price" name="orderby"
                               onChange="this.form.submit()"/>
                        <label for="price">Giá tăng dần</label>
                    </div>
                </form>
                <form id="datecheck">
                    <div class="range-check">
                        <input class="pt-checkbox" type="checkbox" value="date" id="date" name="orderby"
                               onChange="this.form.submit()"/>
                        <label for="date">Mới nhất</label>
                    </div>
                </form>
                <form id="oldproduct">
                    <div class="range-check">
                        <input class="pt-checkbox" type="checkbox" value="old-product" id="old-product" name="orderby"
                               onChange="this.form.submit()"/>
                        <label for="old-product">Cũ nhất</label>
                    </div>
                </form>
            </div>
        <?php } else {
            echo '<div class="sapxep">Sắp xếp: ';
            woocommerce_catalog_ordering();
        };
    endif;
}

;
//add_action('woocommerce_before_main_content', 'filter_new_giuseart');
function add_js()
{
    ; ?>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            if (window.location.href.indexOf("price-desc") > -1) {
                jQuery('#pricedesc input[type="checkbox"]').prop('checked', true);
            } else if (window.location.href.indexOf("price") > -1) {
                jQuery('#pricesmall input[type="checkbox"]').prop('checked', true);
            } else if (window.location.href.indexOf("date") > -1) {
                jQuery('#datecheck input[type="checkbox"]').prop('checked', true);
            } else if (window.location.href.indexOf("old-product") > -1) {
                jQuery('#oldproduct input[type="checkbox"]').prop('checked', true);
            }
        });
        jQuery("a.deselect").each(function () {
            this.search = "";
        });
    </script>
<?php }

;
add_action('wp_footer', 'add_js');

function filter_woocommerce_admin_get_feature_config($feature_config)
{
    $feature_config['marketing'] = false;

    return $feature_config;
}

add_filter('woocommerce_admin_get_feature_config', 'filter_woocommerce_admin_get_feature_config', 10, 1);

function delete_all_attached_media($post_id)
{
    if (get_post_type($post_id) == "product") {
        $attachments = get_attached_media('', $post_id);
        foreach ($attachments as $attachment) {
            wp_delete_attachment($attachment->ID, 'true');
        }
    }
}

add_action('before_delete_post', 'delete_all_attached_media');

// xoá thông báo Flatsome issues
add_action('init', 'hide_notice');
function hide_notice()
{
    remove_action('admin_notices', 'flatsome_maintenance_admin_notice');
}


/*
* Add quick buy button go to checkout after click
*/

//add_action('woocommerce_after_add_to_cart_button', 'devvn_quickbuy_after_addcart_button');
function devvn_quickbuy_after_addcart_button()
{
    echo do_shortcode('[devvn_quickbuy]');
}

add_action('woocommerce_after_add_to_cart_button', 'devvn_quickbuy_after_addtocart_button');
function devvn_quickbuy_after_addtocart_button()
{
    global $product;
    ?>
    <style>
        .devvn-quickbuy button.single_add_to_cart_button.loading:after {
            display: none;
        }

        .devvn-quickbuy button.single_add_to_cart_button.button.alt.loading {
            color: #fff;
            pointer-events: none !important;
        }

        .devvn-quickbuy button.buy_now_button {
            position: relative;
            color: rgba(255, 255, 255, 0.05);
        }

        .devvn-quickbuy button.buy_now_button:after {
            animation: spin 500ms infinite linear;
            border: 2px solid #fff;
            border-radius: 32px;
            border-right-color: transparent !important;
            border-top-color: transparent !important;
            content: "";
            display: block;
            height: 16px;
            top: 50%;
            margin-top: -8px;
            left: 50%;
            margin-left: -8px;
            position: absolute;
            width: 16px;
        }
    </style>


    <div class="isures-btn--order_wrap">

        <button type="button" class="button buy_now_button">
            <?php _e('<span class="span1">Mua ngay</span>', 'devvn'); ?>
        </button>
        <!--        <button type="submit" name="add-to-cart" value="--><?php //echo esc_attr($product->get_id());
        ?><!--"-->
        <!--                class="isures-btn--cta_global isures-btn--atc wc-variation-selection-needed single_add_to_cart_button button alt-->
        <?php //echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '');
        ?><!--">-->
        <!--            <span><i class="fa-solid fa-cart-plus"></i></br>Thêm vào giỏ</span></button>-->
    </div>
    <input type="hidden" name="is_buy_now" class="is_buy_now" value="0" autocomplete="off"/>
    <script>
        jQuery(document).ready(function () {
            jQuery('.is_buy_now').val('0');
            jQuery('body').on('click', '.buy_now_button', function (e) {
                e.preventDefault();
                var thisParent = jQuery(this).parents('form.cart');
                if (jQuery('.single_add_to_cart_button', thisParent).hasClass('disabled')) {
                    jQuery('.single_add_to_cart_button', thisParent).trigger('click');
                    return false;
                }
                thisParent.addClass('devvn-quickbuy');
                jQuery('.is_buy_now', thisParent).val('1');
                jQuery('.single_add_to_cart_button', thisParent).trigger('click');
            });
        });
        jQuery(document.body).on('added_to_cart', function (e, fragments, cart_hash, addToCartButton) {
            let thisForm = addToCartButton.closest('.cart');
            let is_buy_now = parseInt(jQuery('.is_buy_now', thisForm).val()) || 0;
            if (is_buy_now === 1 && typeof wc_add_to_cart_params !== "undefined") {
                window.location = wc_add_to_cart_params.cart_url;
            }
        });
    </script>
    <?php
}

add_filter('woocommerce_add_to_cart_redirect', 'redirect_to_checkout');
function redirect_to_checkout($redirect_url)
{
    if (!get_theme_mod('ajax_add_to_cart')) {
        if (isset($_REQUEST['is_buy_now']) && $_REQUEST['is_buy_now'] && get_option('woocommerce_cart_redirect_after_add') !== 'yes') {
            $redirect_url = wc_get_checkout_url(); //or wc_get_cart_url()
        }
    }
    return $redirect_url;
}

add_filter('woocommerce_get_script_data', 'devvn_woocommerce_get_script_data', 10, 2);
function devvn_woocommerce_get_script_data($params, $handle)
{
    if ($handle == 'wc-add-to-cart') {
        $params['cart_url'] = wc_get_checkout_url();
    }
    return $params;
}

// Đoạn code thu gọn nội dung bao gồm cả nút xem thêm và thu gọn lại sau khi đã click vào xem thêm

add_action('wp_footer', 'devvn_readmore_flatsome');
function devvn_readmore_flatsome()
{
    ?>
    <style>
        .single-product div#tab-description {
            overflow: hidden;
            position: relative;
            padding-bottom: 25px;
        }

        .fix_height {
            max-height: 500px;
            overflow: hidden;
            position: relative;
        }

        .single-product .tab-panels div#tab-description.panel:not(.active) {
            height: 0 !important;
        }

        .devvn_readmore_flatsome {
            text-align: center;
            cursor: pointer;
            position: absolute;
            z-index: 10;
            bottom: 0;
            width: 100%;
            background: #fff;
        }

        .devvn_readmore_flatsome:before {
            height: 55px;
            margin-top: -45px;
            content: "";
            background: -moz-linear-gradient(top, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
            background: -webkit-linear-gradient(top, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff00', endColorstr='#ffffff', GradientType=0);
            display: block;
        }

        .devvn_readmore_flatsome a {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: auto;
            line-height: 40px;
            height: auto;
            border: 1px solid #0b3b3b;
            color: #0b3b3b;
            font-weight: 500;
            background: #fff;
            padding: 0 25px;
            border-radius: 20px;
            transition: background-color .5s ease;
            gap: 15px;
        }

        .devvn_readmore_flatsome a:after {
            content: '';
            width: 0;
            right: 0;
            border-top: 6px solid #318A00;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            display: inline-block;
            vertical-align: middle;
            margin: -2px 0 0 5px;
        }

        .devvn_readmore_flatsome_less a:after {
            border-top: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-bottom: 6px solid #318A00;
        }

        .devvn_readmore_flatsome_less:before {
            display: none;
        }
    </style>
    <script>
        (function ($) {
            $(window).on('load', function () {
                if ($('.single-product div#tab-description').length > 0) {
                    let wrap = $('.single-product div#tab-description');
                    let current_height = wrap.height();
                    let your_height = 500;
                    if (current_height > your_height) {
                        wrap.addClass('fix_height');
                        wrap.append(function () {
                            return '<div class="devvn_readmore_flatsome devvn_readmore_flatsome_more"><a title="Xem thêm" href="javascript:void(0);">Xem thêm</a></div>';
                        });
                        wrap.append(function () {
                            return '<div class="devvn_readmore_flatsome devvn_readmore_flatsome_less" style="display: none;"><a title="Xem thêm" href="javascript:void(0);">Thu gọn</a></div>';
                        });
                        $('body').on('click', '.devvn_readmore_flatsome_more', function () {
                            wrap.removeClass('fix_height');
                            $('body .devvn_readmore_flatsome_more').hide();
                            $('body .devvn_readmore_flatsome_less').show();
                        });
                        $('body').on('click', '.devvn_readmore_flatsome_less', function () {
                            wrap.addClass('fix_height');
                            $('body .devvn_readmore_flatsome_less').hide();
                            $('body .devvn_readmore_flatsome_more').show();
                        });
                    }
                }
            });
        })(jQuery);
    </script>
    <?php
}


function show_viewed_shortcode() {
    ob_start(); // Bắt đầu ghi đệm đầu ra
    ?>
    <div class="viewed_pt">
        <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/imgs/icon-eye.png'); ?>" width="20px">&nbsp;<strong id="viewed-count"><?php echo(rand(10, 100)); ?></strong>&nbsp;người đang xem sản phẩm này
    </div>

    <script>
        function updateViewedCount() {
            // Tạo một số ngẫu nhiên mới từ 10 đến 100
            var newCount = Math.floor(Math.random() * (100 - 10 + 1)) + 10;
            document.getElementById('viewed-count').innerHTML = newCount;
        }

        // Cập nhật số lượng mỗi 3 giây
        setInterval(updateViewedCount, 10000);
    </script>
    <?php
    return ob_get_clean(); // Trả về nội dung đã ghi đệm
}
add_shortcode('viewed_products', 'show_viewed_shortcode');

function buy_viewed_shortcode() {
    ob_start(); // Bắt đầu ghi đệm đầu ra
    ?>
    <div class="viewed_pt">
        <img src="<?php echo get_stylesheet_directory_uri() . '/imgs/flame.png';?>" width="20px">&nbsp<strong><?php echo(rand(1,10)); ?>&nbsp</strong>sản phẩm được bán trong 3 giờ qua
    </div>
    <?php
    return ob_get_clean(); // Trả về nội dung đã ghi đệm
}
add_shortcode('buy_products', 'buy_viewed_shortcode');

function display_all_coupons_shortcode() {
    // Lấy tất cả các mã giảm giá
    $coupons = new WP_Query(array(
        'post_type' => 'shop_coupon',
        'posts_per_page' => -1, // Lấy tất cả các mã
    ));

    // Bắt đầu ghi đệm đầu ra
    ob_start();

    // Kiểm tra nếu có mã giảm giá
    if ($coupons->have_posts()) {
        echo '<div class="coupons-list">';
        echo '<h2>Gửi tặng bạn mã giảm giá</h2>';
        echo '<ul>';

        while ($coupons->have_posts()) {
            $coupons->the_post();
            $coupon_code = get_the_title(); // Lấy mã giảm giá
//            $coupon_description = get_post_meta(get_the_ID(), 'description', true);
            $coupon_description = get_the_excerpt();

            echo '<li>';
            echo '<strong>' . esc_html($coupon_code) . '</strong>';
            if ($coupon_description) {
                echo ' - ' . esc_html($coupon_description);
            }
            echo '</li>';
        }

        echo '</ul>';
        echo '</div>';
    } else {
        echo '<p>Không có mã giảm giá nào hiện có.</p>';
    }

    // Đặt lại truy vấn
    wp_reset_postdata();

    // Trả về nội dung đã ghi đệm
    return ob_get_clean();
}
add_shortcode('all_coupons', 'display_all_coupons_shortcode');


// Đăng ký shortcode để hiển thị danh mục của sản phẩm cùng với liên kết
function show_product_categories_shortcode() {
    global $product;

    // Lấy danh mục của sản phẩm
    $terms = get_the_terms($product->get_id(), 'product_cat');

    if ($terms && !is_wp_error($terms)) {
        $category_list = array();

        // Lặp qua từng danh mục và lấy tên cùng với liên kết
        foreach ($terms as $term) {
            $category_link = get_term_link($term);  // Lấy liên kết của danh mục
            if (!is_wp_error($category_link)) {
                // Thêm liên kết cùng tên danh mục vào danh sách
                $category_list[] = '<a class="product_categories" href="' . esc_url($category_link) . '">' . esc_html($term->name) . '</a>';
            }
        }

        // Trả về danh sách các danh mục với liên kết
        return implode(', ', $category_list);  // Hiển thị tên danh mục với liên kết
    }

    return '';  // Nếu không có danh mục nào, trả về chuỗi rỗng
}

// Đăng ký shortcode
add_shortcode('product_categories_shortcode', 'show_product_categories_shortcode');

function custom_product_brand_sku_shortcode($atts) {
    // Lấy ID sản phẩm từ tham số shortcode
    $atts = shortcode_atts(array(
        'id' => null, // Nếu không có ID, sẽ lấy ID của sản phẩm hiện tại
    ), $atts);

    // Nếu không có ID sản phẩm, lấy ID của sản phẩm hiện tại
    $product_id = $atts['id'] ? $atts['id'] : get_the_ID();

    // Lấy thông tin sản phẩm
    $product = wc_get_product($product_id);

    // Kiểm tra nếu sản phẩm tồn tại
    if ($product) {
        ob_start();

        // Hiển thị SKU
        $sku = $product->get_sku();
        if ($sku) {
            echo '<p><strong>SKU:</strong> ' . $sku . '</p>';
        } else {
            echo '<p><strong>SKU:</strong> N/A</p>';
        }

        // Hiển thị Brand (nếu có plugin WooCommerce Brands)
        if (taxonomy_exists('product_brand')) {
            $brands = wp_get_post_terms($product_id, 'product_brand');
            if (!empty($brands)) {
                echo '<p><strong>Brand:</strong> ' . esc_html($brands[0]->name) . '</p>';
            } else {
                echo '<p><strong>Brand:</strong> N/A</p>';
            }
        }

        return ob_get_clean();
    }

    return 'Không tìm thấy sản phẩm.';
}
add_shortcode('product_brand_sku', 'custom_product_brand_sku_shortcode');

function display_brand_and_sku() {
    global $product;
    $sku = $product->get_sku();
    $brand = get_the_terms($product->get_id(), 'berocket_brand');
    if ($brand && !is_wp_error($brand)) {
        $brand_name = $brand[0]->name; // Lấy tên thương hiệu đầu tiên
    }
    return '<div class="brand-sku-info">
                <p><strong>Thương hiệu: </strong>' . esc_html($brand_name) . '</p>
                <p><strong>SKU: </strong>' . esc_html($sku) . '</p>
            </div>';
}

// Đăng ký shortcode
add_shortcode('brand_sku_info', 'display_brand_and_sku');


function custom_woo_product_gallery() {
    global $post;

    // Lấy sản phẩm hiện tại
    $product = wc_get_product($post->ID);

    // Lấy ảnh chính (ảnh lớn) của sản phẩm
    $main_image = wp_get_attachment_image_url($product->get_image_id(), 'full');

    // Lấy các ảnh thu nhỏ (gallery) của sản phẩm
    $attachment_ids = $product->get_gallery_image_ids();
    $thumbnails = '';
    $main_images = '';

    // Thêm ảnh chính vào slider
    $thumbnails .= '<div><img src="' . esc_url($main_image) . '" alt="Thumbnail"></div>';
    $main_images .= '<div><img src="' . esc_url($main_image) . '" alt="Main Image"></div>';

    // Kiểm tra và tạo các phần tử cho ảnh chính (full-size) và ảnh thu nhỏ
    if ($attachment_ids) {
        foreach ($attachment_ids as $attachment_id) {
            // Lấy URL của ảnh thu nhỏ (thumbnail) và ảnh full-size
            $thumbnail_url = wp_get_attachment_image_url($attachment_id, 'thumbnail');
            $full_image_url = wp_get_attachment_image_url($attachment_id, 'full');

            // Thêm ảnh thu nhỏ và ảnh chính vào các slider
            $thumbnails .= '<div><img src="' . esc_url($thumbnail_url) . '" alt="Thumbnail"></div>';
            $main_images .= '<div><img src="' . esc_url($full_image_url) . '" alt="Main Image"></div>';
        }
    }

    // HTML trả về cho slider ảnh chính và ảnh thu nhỏ
    return '
    <div class="custom-product-gallery">
        <!-- Slider ảnh thu nhỏ -->
        <div class="slider-nav">
            ' . $thumbnails . '
        </div>

        <!-- Slider ảnh chính (full-size) -->
        <div class="slider-for">
            ' . $main_images . '
        </div>
    </div>';
}
add_shortcode('custom_product_gallery', 'custom_woo_product_gallery');

function load_slick_slider() {
    // Tải Slick CSS
    wp_enqueue_style('slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css');
    wp_enqueue_style('slick-theme-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css');

    // Tải Slick JS
    wp_enqueue_script('slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), null, true);

    // Thêm JavaScript khởi tạo Slick Slider
    $inline_script = "
    jQuery(document).ready(function($) {
        // Khởi tạo Slick cho slider ảnh chính
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
        });

        // Khởi tạo Slick cho slider ảnh thu nhỏ
        $('.slider-nav').slick({
            
			slidesToShow: 4,
			slidesToScroll: 1,
			vertical:true,
			asNavFor: '.slider-for',
			dots: false,
			focusOnSelect: true,
			verticalSwiping:true
        });
    });
    ";
    wp_add_inline_script('slick-js', $inline_script);
}
add_action('wp_enqueue_scripts', 'load_slick_slider');

function custom_product_reviews_shortcode() {
    global $product;

    // Kiểm tra xem có sản phẩm không
    if ( ! $product ) {
        return '';
    }

    // Hiển thị phần đánh giá
    ob_start();
    
    // Hiển thị phần đánh giá nếu sản phẩm có đánh giá
    comments_template();
    
    return ob_get_clean();
}
add_shortcode( 'product_reviews', 'custom_product_reviews_shortcode' );

add_filter( 'woocommerce_product_tabs', 'delete_tab', 98 );
    function delete_tab( $tabs ) {
    unset($tabs['reviews']);
    return $tabs;
}


/*
* Code Bỏ /product/ hoặc /cua-hang/ hoặc /shop/ ... có hỗ trợ dạng %product_cat%
* Thay /cua-hang/ bằng slug hiện tại của bạn
*/
function devvn_remove_slug( $post_link, $post ) {
    if ( !in_array( get_post_type($post), array( 'product' ) ) || 'publish' != $post->post_status ) {
        return $post_link;
    }
    if('product' == $post->post_type){
        $post_link = str_replace( '/cua-hang/', '/', $post_link ); //Thay cua-hang bằng slug hiện tại của bạn
    }else{
        $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
    }
    return $post_link;
}
add_filter( 'post_type_link', 'devvn_remove_slug', 10, 2 );
/*Sửa lỗi 404 sau khi đã remove slug product hoặc cua-hang*/
function devvn_woo_product_rewrite_rules($flash = false) {
    global $wp_post_types, $wpdb;
    $siteLink = esc_url(home_url('/'));
    foreach ($wp_post_types as $type=>$custom_post) {
        if($type == 'product'){
            if ($custom_post->_builtin == false) {
                $querystr = "SELECT {$wpdb->posts}.post_name, {$wpdb->posts}.ID
                            FROM {$wpdb->posts} 
                            WHERE {$wpdb->posts}.post_status = 'publish' 
                            AND {$wpdb->posts}.post_type = '{$type}'";
                $posts = $wpdb->get_results($querystr, OBJECT);
                foreach ($posts as $post) {
                    $current_slug = get_permalink($post->ID);
                    $base_product = str_replace($siteLink,'',$current_slug);
                    add_rewrite_rule($base_product.'?$', "index.php?{$custom_post->query_var}={$post->post_name}", 'top');                    
                    add_rewrite_rule($base_product.'comment-page-([0-9]{1,})/?$', 'index.php?'.$custom_post->query_var.'='.$post->post_name.'&cpage=$matches[1]', 'top');
                    add_rewrite_rule($base_product.'(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?'.$custom_post->query_var.'='.$post->post_name.'&feed=$matches[1]','top');
                }
            }
        }
    }
    if ($flash == true)
        flush_rewrite_rules(false);
}
add_action('init', 'devvn_woo_product_rewrite_rules');
/*Fix lỗi khi tạo sản phẩm mới bị 404*/
function devvn_woo_new_product_post_save($post_id){
    global $wp_post_types;
    $post_type = get_post_type($post_id);
    foreach ($wp_post_types as $type=>$custom_post) {
        if ($custom_post->_builtin == false && $type == $post_type) {
            devvn_woo_product_rewrite_rules(true);
        }
    }
}
add_action('wp_insert_post', 'devvn_woo_new_product_post_save');

/*
* Remove product-category in URL
* Thay product-category bằng slug hiện tại của bạn. Mặc định là product-category
*/
add_filter( 'term_link', 'devvn_product_cat_permalink', 10, 3 );
function devvn_product_cat_permalink( $url, $term, $taxonomy ){
    switch ($taxonomy):
        case 'product_cat':
            $taxonomy_slug = 'product-category'; //Thay bằng slug hiện tại của bạn. Mặc định là product-category
            if(strpos($url, $taxonomy_slug) === FALSE) break;
            $url = str_replace('/' . $taxonomy_slug, '', $url);
            break;
    endswitch;
    return $url;
}
// Add our custom product cat rewrite rules
function devvn_product_category_rewrite_rules($flash = false) {
    $terms = get_terms( array(
        'taxonomy' => 'product_cat',
        'post_type' => 'product',
        'hide_empty' => false,
    ));
    if($terms && !is_wp_error($terms)){
        $siteurl = esc_url(home_url('/'));
        foreach ($terms as $term){
            $term_slug = $term->slug;
            $baseterm = str_replace($siteurl,'',get_term_link($term->term_id,'product_cat'));
            add_rewrite_rule($baseterm.'?$','index.php?product_cat='.$term_slug,'top');
            add_rewrite_rule($baseterm.'/page/([0-9]{1,})?$', 'index.php?product_cat='.$term_slug.'&paged=$matches[1]','top');
            add_rewrite_rule($baseterm.'/(?:feed/)?(feed|rdf|rss|rss2|atom)?$', 'index.php?product_cat='.$term_slug.'&feed=$matches[1]','top');
        }
    }
    if ($flash == true)
        flush_rewrite_rules(false);
}
add_action('init', 'devvn_product_category_rewrite_rules');

/*Sửa lỗi khi tạo mới taxomony bị 404*/
add_action( 'create_term', 'devvn_new_product_cat_edit_success', 10, 2 );
function devvn_new_product_cat_edit_success( $term_id, $taxonomy ) {
    devvn_product_category_rewrite_rules(true);
}

