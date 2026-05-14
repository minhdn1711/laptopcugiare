<?php get_header(); ?>

<main class="container mx-auto px-4 py-6">
    <!-- Hero Section -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
        <!-- Sidebar Category Menu (Desktop) -->
        <div class="hidden lg:block lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden sticky top-[130px]">
                <div class="bg-gray-50 text-secondary font-black px-5 py-4 flex items-center gap-3 border-b border-gray-100 text-sm uppercase tracking-tight">
                    <?php echo miliwebseo_icon('menu', 'h-5 w-5 text-primary'); ?>
                    DANH MỤC LAPTOP
                </div>
                <div class="vertical-menu-container">
                    <?php miliwebseo_render_vertical_menu(); ?>
                </div>
                <!-- Banner Quảng cáo nhỏ ở Sidebar -->
                <div class="p-4 bg-primary/5 border-t border-gray-100">
                    <a href="#" class="block overflow-hidden rounded-lg group">
                        <img src="https://placehold.co/200x120?text=Sửa+Chữa+Laptop" class="w-full h-auto group-hover:scale-110 transition-transform duration-500">
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 space-y-6">
            <!-- Slider -->
            <div id="hero-slider" class="splide bg-white rounded-2xl shadow-xl overflow-hidden h-[450px] border-4 border-white">
                <div class="splide__track h-full">
                    <ul class="splide__list h-full">
                        <?php 
                        $banners = miliwebseo_get_hero_banners();
                        if ( ! empty( $banners ) ) :
                            foreach ( $banners as $banner ) : ?>
                                <li class="splide__slide h-full">
                                    <a href="<?php echo esc_url( $banner['link'] ); ?>" class="block h-full">
                                        <img src="<?php echo esc_url( $banner['image'] ); ?>" class="w-full h-full object-cover">
                                    </a>
                                </li>
                            <?php endforeach;
                        else : ?>
                            <li class="splide__slide h-full relative group">
                                <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?q=80&w=2071&auto=format&fit=crop" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent flex items-center p-12">
                                    <div class="max-w-md text-white space-y-4">
                                        <span class="bg-primary text-black px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest">Khuyến mãi cực hời</span>
                                        <h2 class="text-5xl font-black leading-tight italic">LAPTOP GAMING <br>THẾ HỆ MỚI</h2>
                                        <p class="text-lg opacity-90 font-medium">Giảm giá lên đến 30% cho tất cả dòng máy gaming cao cấp.</p>
                                        <a href="#" class="inline-block bg-white text-black px-8 py-3 rounded-full font-black hover:bg-primary transition-all">MUA NGAY</a>
                                    </div>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <!-- UX Builder Info Boxes -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 group hover:shadow-md transition-all">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <?php echo miliwebseo_icon('truck', 'h-6 w-6'); ?>
                    </div>
                    <div>
                        <p class="text-sm font-black text-secondary">Miễn phí giao hàng</p>
                        <p class="text-[10px] text-gray-500 font-medium">Đơn hàng từ 10 Triệu</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 group hover:shadow-md transition-all">
                    <div class="w-12 h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-all">
                        <?php echo miliwebseo_icon('shield-check', 'h-6 w-6'); ?>
                    </div>
                    <div>
                        <p class="text-sm font-black text-secondary">Bảo hành 12 tháng</p>
                        <p class="text-[10px] text-gray-500 font-medium">Lỗi là đổi mới ngay</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 group hover:shadow-md transition-all">
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center group-hover:bg-orange-600 group-hover:text-white transition-all">
                        <?php echo miliwebseo_icon('refresh-cw', 'h-6 w-6'); ?>
                    </div>
                    <div>
                        <p class="text-sm font-black text-secondary">7 Ngày đổi trả</p>
                        <p class="text-[10px] text-gray-500 font-medium">Hoàn tiền 100%</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 group hover:shadow-md transition-all">
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-all">
                        <?php echo miliwebseo_icon('headphones', 'h-6 w-6'); ?>
                    </div>
                    <div>
                        <p class="text-sm font-black text-secondary">Hỗ trợ 24/7</p>
                        <p class="text-[10px] text-gray-500 font-medium">Zalo / Facebook</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Banner Quảng cáo giữa trang (UX Builder Style) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <div class="relative overflow-hidden rounded-2xl group h-48 md:h-64 shadow-lg border-4 border-white">
            <img src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?q=80&w=1932&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            <div class="absolute inset-0 bg-black/40 flex flex-col justify-center p-8 text-white">
                <p class="text-xs font-black text-primary uppercase tracking-widest mb-1">Dành cho sinh viên</p>
                <h3 class="text-3xl font-black mb-4 italic leading-tight">MÁY VĂN PHÒNG <br>GIÁ SIÊU RẺ</h3>
                <div>
                    <a href="#" class="inline-block bg-white text-black px-6 py-2 rounded-full text-xs font-black hover:bg-primary transition-all">XEM NGAY</a>
                </div>
            </div>
        </div>
        <div class="relative overflow-hidden rounded-2xl group h-48 md:h-64 shadow-lg border-4 border-white">
            <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            <div class="absolute inset-0 bg-gradient-to-r from-red-600/80 to-transparent flex flex-col justify-center p-8 text-white">
                <p class="text-xs font-black text-yellow-400 uppercase tracking-widest mb-1">Cấu hình khủng</p>
                <h3 class="text-3xl font-black mb-4 italic leading-tight">WORKSTATION <br>CHUYÊN NGHIỆP</h3>
                <div>
                    <a href="#" class="inline-block border-2 border-white text-white px-6 py-2 rounded-full text-xs font-black hover:bg-white hover:text-red-600 transition-all uppercase">Khám phá</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Sale Section (Refined) -->
    <section class="mb-12 bg-white rounded-3xl p-8 shadow-xl overflow-hidden relative border border-gray-100">
        <div class="absolute top-0 right-0 w-64 h-64 bg-red-600/5 rounded-full -mr-32 -mt-32"></div>
        <div class="flex flex-col md:flex-row items-center justify-between mb-8 relative z-10 gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-red-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-red-200 rotate-3 animate-bounce">
                    <?php echo miliwebseo_icon('flash', 'h-8 w-8'); ?>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-secondary italic leading-tight">FLASH SALE</h2>
                    <p class="text-xs text-red-600 font-bold uppercase tracking-widest">Giờ vàng giá sốc</p>
                </div>
            </div>
            
            <div class="flex flex-col items-center md:items-end gap-2">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-black uppercase tracking-wider text-gray-400">Kết thúc sau:</span>
                    <div class="flex gap-2" id="flash-sale-countdown">
                        <div class="flex flex-col items-center">
                            <span class="bg-secondary text-white w-10 h-10 flex items-center justify-center rounded-lg font-mono text-xl shadow-inner" id="hours">00</span>
                        </div>
                        <span class="text-secondary font-black text-xl">:</span>
                        <div class="flex flex-col items-center">
                            <span class="bg-secondary text-white w-10 h-10 flex items-center justify-center rounded-lg font-mono text-xl shadow-inner" id="minutes">00</span>
                        </div>
                        <span class="text-secondary font-black text-xl">:</span>
                        <div class="flex flex-col items-center">
                            <span class="bg-secondary text-white w-10 h-10 flex items-center justify-center rounded-lg font-mono text-xl shadow-inner" id="seconds">00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            <?php
            $args = miliwebseo_get_flash_sale_args();
            $loop = new WP_Query( $args );
            if ( $loop->have_posts() ) {
                while ( $loop->have_posts() ) : $loop->the_post();
                    wc_get_template_part( 'woocommerce/content', 'product' );
                endwhile;
            } else {
                for($i=0; $i<5; $i++) include MILIWEBSEO_DIR . '/template-parts/product-card-demo.php';
            }
            wp_reset_postdata();
            ?>
        </div>
    </section>

    <?php
    // Get all terms from usage_needs taxonomy
    $usage_terms = get_terms([
        'taxonomy'   => 'usage_needs',
        'hide_empty' => true, // Only show terms that have products
    ]);

    if ( ! empty( $usage_terms ) && ! is_wp_error( $usage_terms ) ) :
        foreach ( $usage_terms as $term ) :
            // Skip 'office' or other slugs if you want a specific order, 
            // but here we loop through all for maximum flexibility.
            
            // Custom titles based on slug if needed
            $title = $term->name;
            if ($term->slug === 'gaming') $title = 'Laptop Gaming Nổi Bật';
            if ($term->slug === 'office') $title = 'Laptop học tập - văn phòng';
    ?>
    <section class="mb-12">
        <div class="flex flex-col md:flex-row items-baseline justify-between mb-6 border-b-2 border-primary pb-2 gap-4">
            <h2 class="text-xl font-black uppercase text-secondary"><?php echo esc_html($title); ?></h2>
            <div class="flex flex-wrap gap-x-4 gap-y-2 text-xs">
                <?php 
                // Get all products IDs in this usage_need term
                $product_ids = get_posts([
                    'post_type' => 'product',
                    'numberposts' => -1,
                    'fields' => 'ids',
                    'tax_query' => [
                        [
                            'taxonomy' => 'usage_needs',
                            'field' => 'slug',
                            'terms' => $term->slug,
                        ]
                    ]
                ]);

                if (!empty($product_ids)) {
                    // Get unique brands from these products using the correct 'brand' taxonomy
                    $brands = wp_get_object_terms($product_ids, 'brand');
                    if (!is_wp_error($brands) && !empty($brands)) {
                        foreach ($brands as $brand) : ?>
                            <a href="<?php echo get_term_link($brand); ?>" class="text-gray-500 hover:text-primary font-bold transition-colors">Laptop <?php echo esc_html($brand->name); ?></a>
                        <?php endforeach;
                    }
                }
                ?>
                <a href="<?php echo get_term_link($term); ?>" class="text-blue-600 hover:underline font-bold">Xem tất cả ></a>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <?php
            $args = array(
                'post_type'      => 'product',
                'posts_per_page' => 10,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'usage_needs',
                        'field'    => 'slug',
                        'terms'    => $term->slug,
                    ),
                ),
            );
            $loop = new WP_Query( $args );
            if ( $loop->have_posts() ) {
                while ( $loop->have_posts() ) : $loop->the_post();
                    wc_get_template_part( 'woocommerce/content', 'product' );
                endwhile;
            } else {
                for($i=0; $i<5; $i++) include MILIWEBSEO_DIR . '/template-parts/product-card-demo.php';
            }
            wp_reset_postdata();
            ?>
        </div>
    </section>
    <?php 
        endforeach; 
    endif;
    ?>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hero Slider
        if (typeof Splide !== 'undefined' && document.querySelector('#hero-slider')) {
            new Splide('#hero-slider', { type: 'loop', autoplay: true, arrows: false }).mount();
        }

        // Flash Sale Countdown
        const flashSaleTime = "<?php echo miliwebseo_get_flash_sale_time(); ?>";
        const countdownDate = new Date(flashSaleTime).getTime();
        
        const timer = setInterval(function() {
            const now = new Date().getTime();
            const distance = countdownDate - now;
            
            if (distance < 0) {
                clearInterval(timer);
                const countdownEl = document.getElementById("flash-sale-countdown");
                if(countdownEl) countdownEl.innerHTML = "<span class='text-xs uppercase bg-white/20 px-3 py-1 rounded'>Đã kết thúc</span>";
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            const hoursEl = document.getElementById("hours");
            const minutesEl = document.getElementById("minutes");
            const secondsEl = document.getElementById("seconds");

            if(hoursEl) hoursEl.innerHTML = hours.toString().padStart(2, '0');
            if(minutesEl) minutesEl.innerHTML = minutes.toString().padStart(2, '0');
            if(secondsEl) secondsEl.innerHTML = seconds.toString().padStart(2, '0');
        }, 1000);
    });
</script>

<?php get_footer(); ?>
