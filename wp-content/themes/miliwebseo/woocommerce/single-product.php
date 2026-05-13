<?php
/**
 * Custom WooCommerce Single Product Template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

get_header(); ?>

<div class="bg-white">
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
                    <span class="text-yellow-500">⭐⭐⭐⭐⭐ (12 đánh giá)</span>
                    <span class="text-gray-400">| SKU: <?php echo $product->get_sku(); ?></span>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                    <div class="flex items-baseline gap-3 mb-1">
                        <span class="text-3xl font-bold text-primary"><?php echo $product->get_price_html(); ?></span>
                    </div>
                    <?php if ( $product->is_on_sale() ) : ?>
                        <div class="text-sm text-gray-500 italic">Tiết kiệm: <?php echo wc_price( $product->get_regular_price() - $product->get_sale_price() ); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Variations / Configuration Selection -->
                <div class="mb-6">
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
                    <button class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-lg text-lg uppercase transition-colors">
                        MUA NGAY (Giao nhanh 2h)
                    </button>
                    <div class="grid grid-cols-2 gap-3">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg text-sm transition-colors uppercase">
                            TRẢ GÓP 0%
                        </button>
                        <button class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-3 rounded-lg text-sm transition-colors uppercase">
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
                        <button class="w-full text-blue-600 font-medium py-2 hover:underline">Xem chi tiết cấu hình ↓</button>
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
        <div class="mt-12 grid grid-cols-1 lg:grid-cols-12 gap-12">
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
                    <div class="mt-6 rounded-xl overflow-hidden shadow-lg transform hover:-translate-y-1 transition-transform cursor-pointer">
                        <img src="https://placehold.co/400x200?text=Khuyến+Mãi+Tháng+5" alt="Promo" class="w-full h-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
