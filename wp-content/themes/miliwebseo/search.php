<?php
/**
 * Search Results Template - Product Search
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<div class="container mx-auto px-4">
    <!-- Breadcrumb -->
    <nav class="flex py-4 text-[10px] text-gray-500 uppercase font-bold" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
                <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors">Trang chủ</a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="mx-2 text-gray-300">/</span>
                    <span class="text-gray-400">Tìm kiếm</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">

        <header class="mb-8">
            <h1 class="text-2xl md:text-3xl font-black text-secondary">
                Kết quả tìm kiếm cho: 
                <span class="text-primary">"<?php echo esc_html( get_search_query() ); ?>"</span>
            </h1>
            <?php if ( have_posts() ) : ?>
                <p class="text-gray-500 mt-1">
                    Tìm thấy <?php echo $wp_query->found_posts; ?> sản phẩm
                </p>
            <?php endif; ?>
        </header>

        <?php if ( have_posts() ) : ?>

            <!-- Product Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                <?php
                while ( have_posts() ) :
                    the_post();
                    wc_get_template_part( 'content', 'product' );
                endwhile;
                ?>
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                <?php woocommerce_pagination(); ?>
            </div>

        <?php else : ?>

            <!-- Empty State -->
            <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold text-gray-400">
                    Không tìm thấy kết quả cho "<?php echo esc_html( get_search_query() ); ?>"
                </h3>
                <p class="text-gray-500 mt-2">Vui lòng thử từ khóa khác</p>
                <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" 
                   class="inline-block mt-6 bg-primary text-black px-6 py-2 rounded-full font-bold hover:bg-yellow-400 transition">
                    Xem tất cả sản phẩm
                </a>
            </div>

        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>
