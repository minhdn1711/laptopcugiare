<?php
/**
 * Custom WooCommerce Single Product Template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

get_header(); ?>

<style>
    .product-actions-wrapper .single_add_to_cart_button {
        display: none !important;
    }
</style>

<div class="bg-white">
    <script>
        function miliwebseoNotify(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-24 right-4 z-[999] p-4 rounded-lg shadow-2xl text-white font-bold transform transition-all duration-500 translate-x-full ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
            toast.innerText = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.classList.remove('translate-x-full'), 100);
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        }

        function miliwebseoAddToCart(redirect = false, btn = null) {
            if (!btn) btn = event.currentTarget;
            const originalContent = btn.innerHTML;
            btn.disabled = true;
            btn.classList.add('flex', 'items-center', 'justify-center');
            
            // Add spinner
            btn.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="ml-2">${redirect ? 'ĐANG XỬ LÝ...' : 'ĐANG THÊM...'}</span>
            `;
            
            let formData = new FormData();
            formData.append('action', 'miliwebseo_ajax_add_to_cart');
            formData.append('product_id', <?php echo get_the_ID(); ?>);
            
            let qtyInput = document.querySelector('input[name=quantity]');
            let qty = qtyInput ? qtyInput.value : 1;
            formData.append('quantity', qty);

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.classList.remove('flex', 'justify-center');
                btn.innerHTML = originalContent;
                
                if (data.success) {
                    // Always use the robust notification
                    miliwebseoNotify(data.data.message);
                    
                    document.querySelectorAll('.cart-count').forEach(el => {
                        el.innerText = data.data.cart_count;
                    });

                    if (redirect) {
                        window.location.href = '<?php echo wc_get_checkout_url(); ?>';
                    }
                } else {
                    miliwebseoNotify(data.data.message || 'Lỗi khi thêm vào giỏ hàng', 'error');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.classList.remove('flex', 'justify-center');
                btn.innerHTML = originalContent;
                console.error('Ajax Error:', err);
                miliwebseoNotify('Lỗi kết nối máy chủ', 'error');
            });
        }
    </script>
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-6">
            <?php woocommerce_breadcrumb(); ?>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left: Gallery -->
            <div class="lg:col-span-5">
                <div class="sticky top-24">
                    <?php woocommerce_show_product_images(); ?>
                </div>
            </div>

            <!-- Middle: Info & Purchase -->
            <div class="lg:col-span-4">
                <h1 class="text-2xl font-bold mb-2 text-secondary"><?php the_title(); ?></h1>
                
                <div class="flex items-center gap-4 mb-4 text-sm">
                    <div class="flex items-center gap-1">
                        <div class="flex text-yellow-400">
                            <?php 
                            $rating = $product->get_average_rating();
                            $count = $product->get_review_count();
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $rating) {
                                    echo '★';
                                } else {
                                    echo '☆';
                                }
                            }
                            ?>
                        </div>
                        <span class="text-gray-500 font-medium">(<?php echo $count; ?> đánh giá)</span>
                    </div>
                    <span class="text-gray-400">| SKU: <?php echo $product->get_sku(); ?></span>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 mb-6">
                    <div class="flex items-center gap-4">
                        <?php if ( $product->is_on_sale() ) : ?>
                            <span class="text-3xl font-black text-primary">
                                <?php echo wc_price( $product->get_sale_price() ); ?>
                            </span>
                            <span class="text-lg text-gray-400 line-through">
                                <?php echo wc_price( $product->get_regular_price() ); ?>
                            </span>
                            <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-1 rounded">
                                -<?php echo round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 ); ?>%
                            </span>
                        <?php else : ?>
                            <span class="text-3xl font-black text-primary">
                                <?php echo $product->get_price_html(); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <?php if ( $product->is_on_sale() ) : ?>
                        <p class="text-xs text-green-600 font-bold mt-2 italic flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Tiết kiệm ngay <?php echo wc_price( $product->get_regular_price() - $product->get_sale_price() ); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Variations / Configuration Selection -->
                <div class="mb-6 product-actions-wrapper bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <p class="text-xs font-bold text-gray-500 mb-3 uppercase tracking-wider">Lựa chọn số lượng:</p>
                    <?php woocommerce_template_single_add_to_cart(); ?>
                </div>

                <!-- Gifts Section -->
                <div class="border-2 border-primary rounded-lg overflow-hidden mb-6">
                    <div class="bg-primary px-4 py-2 text-black font-bold flex items-center gap-2">
                        🎁 QUÀ TẶNG ƯU ĐÃI
                    </div>
                    <div class="p-4 bg-yellow-50 text-sm space-y-2">
                        <p>✅ Balo Laptop cao cấp</p>
                        <p>✅ Chuột không dây chính hãng</p>
                        <p>✅ Bộ vệ sinh laptop 4 món</p>
                        <p>✅ Miễn phí cài đặt phần mềm trọn đời</p>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <button onclick="miliwebseoAddToCart(true)"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-lg text-lg uppercase transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0 flex flex-col items-center leading-tight">
                        <span>MUA NGAY</span>
                        <span class="text-xs font-normal opacity-90 uppercase">Giao nhanh 2h hoặc nhận tại cửa hàng</span>
                    </button>
                    <div class="grid grid-cols-2 gap-3">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg text-sm transition-colors uppercase shadow hover:shadow-md">
                            TRẢ GÓP 0%
                        </button>
                        <button onclick="miliwebseoAddToCart(false)"
                                class="bg-secondary hover:bg-black text-white font-bold py-3 rounded-lg text-sm transition-colors uppercase shadow hover:shadow-md">
                            THÊM GIỎ HÀNG
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right: Quick Specs & Policy -->
            <div class="lg:col-span-3">
                <div class="bg-white border rounded-lg overflow-hidden mb-6">
                    <div class="bg-gray-100 px-4 py-2 font-bold border-b">Thông số kỹ thuật</div>
                    <div class="p-4 text-sm space-y-3">
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">CPU</span>
                            <span class="font-medium text-right"><?php echo strip_tags( get_the_term_list( get_the_ID(), 'cpu', '', ', ' ) ); ?></span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">RAM</span>
                            <span class="font-medium text-right"><?php echo strip_tags( get_the_term_list( get_the_ID(), 'ram', '', ', ' ) ); ?></span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Ổ cứng</span>
                            <span class="font-medium text-right"><?php echo strip_tags( get_the_term_list( get_the_ID(), 'ssd', '', ', ' ) ); ?></span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Card đồ họa</span>
                            <span class="font-medium text-right"><?php echo strip_tags( get_the_term_list( get_the_ID(), 'vga', '', ', ' ) ); ?></span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Màn hình</span>
                            <span class="font-medium text-right"><?php echo strip_tags( get_the_term_list( get_the_ID(), 'screen_size', '', ', ' ) ); ?></span>
                        </div>
                        <a href="#full-specs" class="w-full text-blue-600 font-medium py-2 hover:underline block text-center">Xem chi tiết cấu hình ↓</a>
                    </div>
                </div>

                <div class="bg-white border rounded-lg p-4 space-y-4">
                    <div class="flex items-start gap-3">
                        <span class="text-xl">🚚</span>
                        <div class="text-xs">
                            <p class="font-bold">MIỄN PHÍ VẬN CHUYỂN</p>
                            <p class="text-gray-500">Cho đơn hàng từ 10 triệu đồng</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-xl">🛡️</span>
                        <div class="text-xs">
                            <p class="font-bold">BẢO HÀNH CHÍNH HÃNG</p>
                            <p class="text-gray-500">12 tháng, lỗi 1 đổi 1 trong 15 ngày</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs & Details Section -->
        <div id="full-specs" class="mt-12 grid grid-cols-1 lg:grid-cols-12 gap-12 scroll-mt-24">
            <!-- Left: Description & Reviews -->
            <div class="lg:col-span-8">
                <!-- Description -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-secondary uppercase tracking-wider">Đặc điểm nổi bật</h2>
                    </div>
                    <div class="p-6 prose prose-blue max-w-none prose-img:rounded-lg">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- Reviews Section -->
                <div id="reviews" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-secondary uppercase tracking-wider">Đánh giá từ khách hàng</h2>
                    </div>
                    <div class="p-6">
                        <?php
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                        ?>
                    </div>
                </div>
            </div>

            <!-- Right: Related Products Sidebar -->
            <div class="lg:col-span-4">
                <div class="sticky top-24">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-primary px-6 py-4">
                            <h2 class="text-lg font-bold text-black uppercase tracking-wider text-center">Sản phẩm tương tự</h2>
                        </div>
                        <div class="p-4 space-y-6">
                            <?php 
                            // Custom related products query to match theme style
                            $related = wc_get_related_products( get_the_ID(), 4 );
                            if ( $related ) :
                                foreach ( $related as $related_id ) :
                                    $rel_product = wc_get_product( $related_id );
                                    ?>
                                    <a href="<?php echo get_permalink( $related_id ); ?>" class="flex gap-4 group">
                                        <div class="w-20 h-20 flex-shrink-0 bg-gray-50 rounded-lg overflow-hidden border border-gray-100">
                                            <?php echo $rel_product->get_image( 'thumbnail', ['class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform'] ); ?>
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h4 class="text-sm font-semibold line-clamp-2 group-hover:text-primary transition-colors"><?php echo $rel_product->get_name(); ?></h4>
                                            <p class="text-primary font-bold mt-1"><?php echo $rel_product->get_price_html(); ?></p>
                                        </div>
                                    </a>
                                <?php endforeach; 
                            else:
                                echo '<p class="text-sm text-gray-500 text-center py-4 italic">Đang cập nhật sản phẩm liên quan...</p>';
                            endif;
                            ?>
                        </div>
                        <div class="p-4 bg-gray-50 border-t border-gray-100 text-center">
                            <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="text-sm font-bold text-blue-600 hover:underline">Xem thêm sản phẩm khác ></a>
                        </div>
                    </div>

                    <!-- Side Banner / Promo -->
                    <!-- <div class="mt-6 rounded-xl overflow-hidden shadow-lg transform hover:-translate-y-1 transition-transform cursor-pointer">
                        <img src="https://placehold.co/400x200?text=Khuyến+Mãi+Tháng+5" alt="Promo" class="w-full h-auto">
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sticky Add to Cart (Mobile) -->
<?php
$current_product = wc_get_product(get_the_ID());
if ($current_product) :
?>
<div x-data="{ showSticky: false }" 
     x-init="window.addEventListener('scroll', () => { showSticky = window.scrollY > 600 })"
     x-show="showSticky"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="translate-y-full"
     x-transition:enter-end="translate-y-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="translate-y-0"
     x-transition:leave-end="translate-y-full"
     class="fixed bottom-[60px] left-0 right-0 bg-white border-t border-gray-200 p-3 z-[90] md:hidden flex items-center gap-3 shadow-[0_-5px_15px_rgba(0,0,0,0.05)]">
    <div class="flex-shrink-0 w-12 h-12 bg-gray-50 rounded border border-gray-100 overflow-hidden">
        <?php echo $current_product->get_image('thumbnail', ['class' => 'w-full h-full object-cover']); ?>
    </div>
    <div class="flex-grow min-w-0">
        <h4 class="text-xs font-bold truncate"><?php echo get_the_title(); ?></h4>
        <p class="text-primary font-bold text-sm leading-none mt-1"><?php echo $current_product->get_price_html(); ?></p>
    </div>
    <button onclick="miliwebseoAddToCart(true)" class="bg-red-600 text-white font-bold px-4 py-2 rounded text-xs uppercase flex-shrink-0">
        Mua ngay
    </button>
</div>
<?php endif; ?>

<?php get_footer(); ?>
