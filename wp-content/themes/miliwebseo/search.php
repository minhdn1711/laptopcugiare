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

            <?php if ( get_query_var( 'post_type' ) === 'post' ) : ?>
                <!-- Blog Post Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-all duration-300 flex flex-col h-full' ); ?>>
                            <!-- Featured Image with Flatsome Date Badge -->
                            <div class="relative overflow-hidden aspect-[16/10] bg-gray-100 flex-shrink-0">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="block w-full h-full">
                                        <?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-all duration-500' ) ); ?>
                                    </a>
                                <?php else : ?>
                                    <a href="<?php the_permalink(); ?>" class="block w-full h-full flex items-center justify-center text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </a>
                                <?php endif; ?>
                                
                                <!-- Flatsome Style Date Badge -->
                                <div class="absolute top-4 left-4 bg-white text-center rounded-xl shadow-md px-3.5 py-2 z-10 border border-gray-100/50 min-w-[50px]">
                                    <span class="block text-2xl font-black text-secondary leading-none"><?php echo get_the_date('d'); ?></span>
                                    <span class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">T<?php echo get_the_date('m'); ?></span>
                                </div>
                            </div>

                            <!-- Post Content Wrapper -->
                            <div class="p-6 flex flex-col flex-grow">
                                <div class="flex-grow space-y-3">
                                    <!-- Category -->
                                    <?php
                                    $categories = get_the_category();
                                    if ( ! empty( $categories ) ) :
                                        ?>
                                        <div class="flex flex-wrap gap-2">
                                            <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline leading-none">
                                                <?php echo esc_html( $categories[0]->name ); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Title -->
                                    <h2 class="text-lg md:text-xl font-bold text-secondary group-hover:text-primary transition-colors leading-snug line-clamp-2">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>

                                    <!-- Excerpt -->
                                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-3">
                                        <?php echo wp_trim_words( get_the_excerpt(), 28, '...' ); ?>
                                    </p>
                                </div>

                                <!-- Meta & Read More Link -->
                                <div class="pt-5 mt-5 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400 flex-shrink-0">
                                    <span class="flex items-center gap-1.5 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <?php the_author(); ?>
                                    </span>
                                    
                                    <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-1 font-black text-primary hover:underline uppercase text-[10px] tracking-wider transition-colors">
                                        Đọc tiếp
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    <?php
                    the_posts_pagination( array(
                        'prev_text'          => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>',
                        'next_text'          => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>',
                        'before_page_number' => '',
                    ) );
                    ?>
                </div>

            <?php else : ?>

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

            <?php endif; ?>

        <?php else : ?>

            <!-- Empty State -->
            <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold text-gray-400">
                    Không tìm thấy kết quả cho "<?php echo esc_html( get_search_query() ); ?>"
                </h3>
                <p class="text-gray-500 mt-2">Vui lòng thử từ khóa khác</p>
                <?php if ( get_query_var( 'post_type' ) === 'post' ) : ?>
                    <a href="<?php echo esc_url( home_url( '/tin-tuc/' ) ); ?>" 
                       class="inline-block mt-6 bg-primary text-black px-6 py-2 rounded-full font-bold hover:bg-yellow-400 transition">
                        Xem tất cả bài viết
                    </a>
                <?php else : ?>
                    <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" 
                       class="inline-block mt-6 bg-primary text-black px-6 py-2 rounded-full font-bold hover:bg-yellow-400 transition">
                        Xem tất cả sản phẩm
                    </a>
                <?php endif; ?>
            </div>

        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>
