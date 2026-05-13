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
    <section class="mb-12 bg-red-600 rounded-xl p-6 shadow-xl">
        <div class="flex items-center justify-between mb-6 text-white">
            <h2 class="text-2xl font-bold flex items-center gap-2">
                ⚡ FLASH SALE GIÁ SỐC
                <span class="text-sm bg-black px-2 py-1 rounded" id="countdown">00 : 00 : 00</span>
            </h2>
            <a href="#" class="text-sm hover:underline">Xem tất cả ></a>
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
                    wc_get_template_part( 'content', 'product' );
                endwhile;
            } else {
                // Fallback for demo
                for($i=0; $i<5; $i++) {
                    include MILIWEBSEO_DIR . '/template-parts/product-card-demo.php';
                }
            }
            wp_reset_postdata();
            ?>
        </div>
    </section>

    <!-- Gaming Laptops Section -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6 border-b-2 border-primary pb-2">
            <h2 class="text-xl font-bold uppercase">Laptop Gaming Nổi Bật</h2>
            <div class="flex gap-4 text-sm">
                <a href="#" class="hover:text-primary font-medium">Asus ROG</a>
                <a href="#" class="hover:text-primary font-medium">MSI Katana</a>
                <a href="#" class="hover:text-primary font-medium">Acer Predator</a>
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
                        'terms'    => 'gaming',
                    ),
                ),
            );
            $loop = new WP_Query( $args );
            if ( $loop->have_posts() ) {
                while ( $loop->have_posts() ) : $loop->the_post();
                    wc_get_template_part( 'content', 'product' );
                endwhile;
            } else {
                // Demo cards
                for($i=0; $i<10; $i++) {
                   include MILIWEBSEO_DIR . '/template-parts/product-card-demo.php';
                }
            }
            wp_reset_postdata();
            ?>
        </div>
    </section>

    <!-- Office Laptops Section -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6 border-b-2 border-primary pb-2">
            <h2 class="text-xl font-bold uppercase">Laptop học tập - văn phòng</h2>
            <div class="flex gap-4 text-sm">
                <a href="#" class="hover:text-primary font-medium">Dell Latitude</a>
                <a href="#" class="hover:text-primary font-medium">HP Elitebook</a>
                <a href="#" class="hover:text-primary font-medium">Lenovo Thinkpad</a>
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
                        'terms'    => 'office', // Ensure this slug exists in usage_needs taxonomy
                    ),
                ),
            );
            $loop = new WP_Query( $args );
            if ( $loop->have_posts() ) {
                while ( $loop->have_posts() ) : $loop->the_post();
                    wc_get_template_part( 'content', 'product' );
                endwhile;
            } else {
                // Demo cards
                for($i=0; $i<10; $i++) {
                   include MILIWEBSEO_DIR . '/template-parts/product-card-demo.php';
                }
            }
            wp_reset_postdata();
            ?>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Splide !== 'undefined') {
            new Splide('#hero-slider', {
                type: 'loop',
                autoplay: true,
                arrows: false,
            }).mount();
        }
    });
</script>

<?php get_footer(); ?>
