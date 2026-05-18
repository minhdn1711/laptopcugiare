<?php get_header(); ?>

<!-- Hero Slider - Full Width -->
<div class="container relative mb-8">
    <div id="hero-slider" class="splide bg-white overflow-hidden h-[450px]">
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
</div>

<main class="container mx-auto px-4 py-6">
    <!-- Hero Section -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
        <div class="lg:col-span-4 space-y-6">
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
            $loop = new WP_Query($args);
            if ($loop->have_posts()) {
                while ($loop->have_posts()):
                    $loop->the_post();
                    wc_get_template_part('content', 'product');
                endwhile;
            } else {
                for ($i = 0; $i < 5; $i++)
                    include MILIWEBSEO_DIR . '/template-parts/product-card-demo.php';
            }
            wp_reset_postdata();
            ?>
        </div>
    </section>

    <?php
    // Get all terms from usage_needs taxonomy
    $usage_terms = get_terms([
        'taxonomy' => 'usage_needs',
        'hide_empty' => false,
    ]);

    if (!empty($usage_terms) && !is_wp_error($usage_terms)):
        foreach ($usage_terms as $term):
            $title = $term->name;
            if ($term->slug === 'gaming')
                $title = 'Laptop Gaming Nổi Bật';
            if ($term->slug === 'office')
                $title = 'Laptop học tập - văn phòng';
            ?>
            <section class="mb-12">
                <div class="flex flex-col md:flex-row items-baseline justify-between mb-6 border-b-2 border-primary pb-2 gap-4">
                    <h2 class="text-xl font-black uppercase text-secondary"><?php echo esc_html($title); ?></h2>
                    <div class="flex flex-wrap gap-x-4 gap-y-2 text-xs">
                        <?php
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
                            // Using 'product_brand' as established in our new architecture
                            $brands = wp_get_object_terms($product_ids, 'product_brand');
                            if (!is_wp_error($brands) && !empty($brands)) {
                                foreach ($brands as $brand): ?>
                                    <a href="<?php echo get_term_link($brand); ?>"
                                        class="text-gray-500 hover:text-primary font-bold transition-colors">Laptop <?php echo esc_html($brand->name); ?></a>
                                <?php endforeach;
                            }
                        }
                        ?>
                        <a href="<?php echo get_term_link($term); ?>"
                            class="text-blue-600 hover:underline font-bold">Xem tất cả ></a>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    <?php
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 10,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'usage_needs',
                                'field' => 'slug',
                                'terms' => $term->slug,
                            ),
                        ),
                    );
                    $loop = new WP_Query($args);
                    if ($loop->have_posts()) {
                        while ($loop->have_posts()):
                            $loop->the_post();
                            wc_get_template_part('content', 'product');
                        endwhile;
                    } else {
                        for ($i = 0; $i < 5; $i++)
                            include MILIWEBSEO_DIR . '/template-parts/product-card-demo.php';
                    }
                    wp_reset_postdata();
                    ?>
                </div>
            </section>
        <?php
        endforeach;
    endif;
    ?>
    <?php
    // News Section
    $news_args = array(
        'post_type' => 'post',
        'posts_per_page' => 4,
        'post_status' => 'publish'
    );
    $news_query = new WP_Query($news_args);
    ?>
    <section class="mb-12">
        <div class="flex items-center justify-between mb-8 border-b-2 border-primary pb-2">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-secondary text-primary rounded-xl flex items-center justify-center shadow-lg">
                    <?php echo miliwebseo_icon('book-open', 'h-6 w-6'); ?>
                </div>
                <div>
                    <h2 class="text-xl font-black uppercase text-secondary">TIN TỨC CÔNG NGHỆ</h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Cập nhật xu hướng mới nhất</p>
                </div>
            </div>
            <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="text-blue-600 hover:underline font-bold text-xs uppercase tracking-wider">Xem tất cả ></a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            if ($news_query->have_posts()) :
                while ($news_query->have_posts()) : $news_query->the_post(); ?>
                    <article class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 group hover:shadow-xl transition-all duration-500">
                        <a href="<?php the_permalink(); ?>" class="block relative h-48 overflow-hidden">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-700']); ?>
                            <?php else : ?>
                                <img src="https://placehold.co/600x400?text=News" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <?php endif; ?>
                            <div class="absolute top-4 left-4">
                                <span class="bg-primary text-black text-[10px] font-black px-2 py-1 rounded uppercase tracking-tighter">
                                    <?php echo get_the_date('d M, Y'); ?>
                                </span>
                            </div>
                        </a>
                        <div class="p-5">
                            <h3 class="font-black text-secondary leading-tight mb-3 line-clamp-2 group-hover:text-primary transition-colors">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="text-gray-500 text-xs line-clamp-2 mb-4 leading-relaxed">
                                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                            </p>
                            <a href="<?php the_permalink(); ?>" class="text-[10px] font-black uppercase tracking-widest text-secondary flex items-center gap-2 group/btn">
                                Đọc tiếp
                                <span class="group-hover/btn:translate-x-1 transition-transform"><?php echo miliwebseo_icon('arrow-right', 'h-3 w-3'); ?></span>
                            </a>
                        </div>
                    </article>
                <?php endwhile;
                wp_reset_postdata();
            else :
                // Demo News Cards
                for ($i = 1; $i <= 4; $i++) : ?>
                    <article class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 group hover:shadow-xl transition-all duration-500">
                        <div class="block relative h-48 overflow-hidden bg-gray-100">
                            <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?q=80&w=2071&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-80">
                            <div class="absolute top-4 left-4">
                                <span class="bg-primary text-black text-[10px] font-black px-2 py-1 rounded uppercase tracking-tighter">
                                    <?php echo date('d M, Y'); ?>
                                </span>
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="font-black text-secondary leading-tight mb-3 line-clamp-2 group-hover:text-primary transition-colors">
                                Hướng dẫn chọn mua Laptop cũ giá rẻ mà vẫn cực ngon cho sinh viên
                            </h3>
                            <p class="text-gray-500 text-xs line-clamp-2 mb-4 leading-relaxed">
                                Bạn đang tìm kiếm một chiếc laptop để phục vụ nhu cầu học tập nhưng kinh phí lại hạn hẹp? Đừng lo...
                            </p>
                            <div class="text-[10px] font-black uppercase tracking-widest text-secondary flex items-center gap-2">
                                Đọc tiếp <?php echo miliwebseo_icon('arrow-right', 'h-3 w-3'); ?>
                            </div>
                        </div>
                    </article>
                <?php endfor;
            endif; ?>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Hero Slider
        if (typeof Splide !== 'undefined' && document.querySelector('#hero-slider')) {
            new Splide('#hero-slider', { type: 'loop', autoplay: true, arrows: false }).mount();
        }

        // Flash Sale Countdown
        const flashSaleTime = "<?php echo miliwebseo_get_flash_sale_time(); ?>";
        const countdownDate = new Date(flashSaleTime).getTime();

        const timer = setInterval(function () {
            const now = new Date().getTime();
            const distance = countdownDate - now;

            if (distance < 0) {
                clearInterval(timer);
                const countdownEl = document.getElementById("flash-sale-countdown");
                if (countdownEl) countdownEl.innerHTML = "<span class='text-xs uppercase bg-white/20 px-3 py-1 rounded'>Đã kết thúc</span>";
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            const hoursEl = document.getElementById("hours");
            const minutesEl = document.getElementById("minutes");
            const secondsEl = document.getElementById("seconds");

            if (hoursEl) hoursEl.innerHTML = hours.toString().padStart(2, '0');
            if (minutesEl) minutesEl.innerHTML = minutes.toString().padStart(2, '0');
            if (secondsEl) secondsEl.innerHTML = seconds.toString().padStart(2, '0');
        }, 1000);
    });
</script>

<?php get_footer(); ?>
