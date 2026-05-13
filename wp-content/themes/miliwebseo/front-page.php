<?php get_header(); ?>

<main class="container mx-auto px-4 py-6">
    <!-- Hero Section -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 mb-8">
        <!-- Sidebar Category Menu (Desktop) -->
        <div class="hidden lg:block lg:col-span-1 bg-white rounded-lg shadow overflow-hidden">
            <div class="bg-primary text-black font-bold px-4 py-3 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                DANH MỤC
            </div>
            <ul class="divide-y divide-gray-100">
                <li><a href="#" class="block px-4 py-3 hover:bg-gray-50 hover:text-primary transition-colors flex items-center justify-between group">
                    Laptop Dell <span class="text-gray-300 group-hover:text-primary">></span>
                </a></li>
                <li><a href="#" class="block px-4 py-3 hover:bg-gray-50 hover:text-primary transition-colors flex items-center justify-between group">
                    Laptop HP <span class="text-gray-300 group-hover:text-primary">></span>
                </a></li>
                <li><a href="#" class="block px-4 py-3 hover:bg-gray-50 hover:text-primary transition-colors flex items-center justify-between group">
                    Laptop Asus <span class="text-gray-300 group-hover:text-primary">></span>
                </a></li>
                <li><a href="#" class="block px-4 py-3 hover:bg-gray-50 hover:text-primary transition-colors flex items-center justify-between group">
                    Laptop Lenovo <span class="text-gray-300 group-hover:text-primary">></span>
                </a></li>
                <li><a href="#" class="block px-4 py-3 hover:bg-gray-50 hover:text-primary transition-colors flex items-center justify-between group">
                    Laptop Gaming <span class="text-gray-300 group-hover:text-primary">></span>
                </a></li>
                <li><a href="#" class="block px-4 py-3 hover:bg-gray-50 hover:text-primary transition-colors flex items-center justify-between group">
                    Macbook <span class="text-gray-300 group-hover:text-primary">></span>
                </a></li>
                <li><a href="#" class="block px-4 py-3 hover:bg-gray-50 hover:text-primary transition-colors flex items-center justify-between group">
                    Máy trạm Workstation <span class="text-gray-300 group-hover:text-primary">></span>
                </a></li>
            </ul>
        </div>

        <div class="lg:col-span-3">
            <div id="hero-slider" class="splide bg-white rounded-lg shadow overflow-hidden h-[400px]">
                <div class="splide__track h-full">
                    <ul class="splide__list h-full">
                        <li class="splide__slide h-full">
                            <img src="https://placehold.co/1200x400?text=Banner+1" class="w-full h-full object-cover">
                        </li>
                        <li class="splide__slide h-full">
                            <img src="https://placehold.co/1200x400?text=Banner+2" class="w-full h-full object-cover">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="hidden lg:flex flex-col gap-4 lg:col-span-1">
            <div class="bg-white rounded-lg shadow overflow-hidden flex-1">
                <img src="https://placehold.co/400x190?text=Side+Banner+1" class="w-full h-full object-cover">
            </div>
            <div class="bg-white rounded-lg shadow overflow-hidden flex-1">
                <img src="https://placehold.co/400x190?text=Side+Banner+2" class="w-full h-full object-cover">
            </div>
        </div>
    </div>

    <!-- Flash Sale Section -->
    <section class="mb-12 bg-red-600 rounded-xl p-6 shadow-xl overflow-hidden relative">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>
        <div class="flex flex-col md:flex-row items-center justify-between mb-6 text-white relative z-10 gap-4">
            <h2 class="text-2xl font-black flex items-center gap-3 italic">
                <?php echo miliwebseo_icon('flash', 'h-8 w-8 text-yellow-300 animate-pulse'); ?>
                FLASH SALE GIÁ SỐC
            </h2>
            <div class="flex items-center gap-3">
                <span class="text-sm font-bold uppercase tracking-wider opacity-80">Kết thúc sau:</span>
                <div class="flex gap-2" id="flash-sale-countdown">
                    <span class="bg-black text-white px-2 py-1 rounded font-mono text-lg shadow-inner" id="hours">00</span>
                    <span class="text-white font-bold">:</span>
                    <span class="bg-black text-white px-2 py-1 rounded font-mono text-lg shadow-inner" id="minutes">00</span>
                    <span class="text-white font-bold">:</span>
                    <span class="bg-black text-white px-2 py-1 rounded font-mono text-lg shadow-inner" id="seconds">00</span>
                </div>
            </div>
            <a href="#" class="bg-white text-red-600 px-4 py-2 rounded-full text-sm font-bold hover:bg-yellow-300 hover:text-black transition-all">Xem tất cả ></a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <?php
            $args = array(
                'post_type'      => 'product',
                'posts_per_page' => 5,
                'meta_query'     => array(
                    array(
                        'key'     => '_sale_price',
                        'value'   => 0,
                        'compare' => '>',
                        'type'    => 'NUMERIC',
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
    $sections = [
        ['title' => 'Laptop Gaming Nổi Bật', 'slug' => 'gaming', 'brands' => ['Dell', 'Asus', 'MSI', 'Acer']],
        ['title' => 'Laptop học tập - văn phòng', 'slug' => 'office', 'brands' => ['Dell', 'HP', 'Lenovo', 'Asus']],
    ];

    foreach ($sections as $section) :
    ?>
    <section class="mb-12">
        <div class="flex flex-col md:flex-row items-baseline justify-between mb-6 border-b-2 border-primary pb-2 gap-4">
            <h2 class="text-xl font-black uppercase text-secondary"><?php echo $section['title']; ?></h2>
            <div class="flex flex-wrap gap-x-4 gap-y-2 text-xs">
                <?php foreach ($section['brands'] as $brand) : ?>
                    <a href="#" class="text-gray-500 hover:text-primary font-bold transition-colors">Laptop <?php echo $brand; ?></a>
                <?php endforeach; ?>
                <a href="#" class="text-blue-600 hover:underline font-bold">Xem tất cả ></a>
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
                        'terms'    => $section['slug'],
                    ),
                ),
            );
            $loop = new WP_Query( $args );
            if ( $loop->have_posts() ) {
                while ( $loop->have_posts() ) : $loop->the_post();
                    wc_get_template_part( 'woocommerce/content', 'product' );
                endwhile;
            } else {
                for($i=0; $i<10; $i++) include MILIWEBSEO_DIR . '/template-parts/product-card-demo.php';
            }
            wp_reset_postdata();
            ?>
        </div>
    </section>
    <?php endforeach; ?>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hero Slider
        if (typeof Splide !== 'undefined' && document.querySelector('#hero-slider')) {
            new Splide('#hero-slider', { type: 'loop', autoplay: true, arrows: false }).mount();
        }

        // Flash Sale Countdown
        const countdownDate = new Date().getTime() + (5 * 60 * 60 * 1000); // 5 hours from now
        const timer = setInterval(function() {
            const now = new Date().getTime();
            const distance = countdownDate - now;
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("hours").innerHTML = hours.toString().padStart(2, '0');
            document.getElementById("minutes").innerHTML = minutes.toString().padStart(2, '0');
            document.getElementById("seconds").innerHTML = seconds.toString().padStart(2, '0');

            if (distance < 0) {
                clearInterval(timer);
                document.getElementById("flash-sale-countdown").innerHTML = "HẾT HẠN";
            }
        }, 1000);
    });
</script>

<?php get_footer(); ?>
