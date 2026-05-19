<?php
/**
 * The template for displaying the blog posts page (news page)
 *
 * @package Miliwebseo
 */

get_header();
?>

<!-- Hero / Breadcrumb Header -->
<div class="bg-gray-50 border-b border-gray-100 py-8 mb-10">
    <div class="container mx-auto px-4 md:px-6">
        <h1 class="text-3xl font-black text-secondary uppercase tracking-wider italic mb-2">Tin Tức</h1>
        <!-- Breadcrumbs -->
        <nav class="text-[11px] text-gray-500 uppercase font-bold" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary transition-colors">Trang chủ</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="mx-2 text-gray-300">/</span>
                        <span class="text-gray-400">Tin tức</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="container mx-auto px-4 md:px-6 pb-16">
    <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
        <!-- Left Column: Posts List -->
        <main id="primary" class="w-full lg:w-3/4">
            <?php if ( have_posts() ) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col h-full' ); ?>>
                            <!-- Featured Image with Flatsome Date Badge -->
                            <div class="relative overflow-hidden aspect-[16/10] bg-gray-100 flex-shrink-0">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="block w-full h-full">
                                        <?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-all duration-500' ) ); ?>
                                    </a>
                                <?php else : ?>
                                    <a href="<?php the_permalink(); ?>" class="block w-full h-full relative flex items-center justify-center bg-gradient-to-br from-emerald-500/10 via-teal-500/5 to-transparent overflow-hidden">
                                        <!-- Decorative Background shapes -->
                                        <div class="absolute inset-0 opacity-30 bg-[radial-gradient(#10B981_1px,transparent_1px)] [background-size:16px_16px]"></div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-primary/30 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </a>
                                <?php endif; ?>
                                
                                <!-- Flatsome Style Date Badge -->
                                <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-md text-center rounded-2xl shadow-lg px-4 py-2.5 z-10 border border-white/20 min-w-[55px] transform group-hover:scale-105 transition-transform duration-300">
                                    <span class="block text-2xl font-black text-secondary leading-none tracking-tight"><?php echo get_the_date('d'); ?></span>
                                    <span class="block text-[9px] font-extrabold text-primary uppercase tracking-widest mt-1">T.<?php echo get_the_date('m'); ?></span>
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
                                            <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="text-[10px] font-extrabold text-primary uppercase tracking-widest hover:underline leading-none">
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
                                <div class="pt-5 mt-5 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400 flex-grow-0">
                                    <span class="flex items-center gap-1.5 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <?php the_author(); ?>
                                    </span>
                                    
                                    <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-1 font-black text-primary hover:underline uppercase text-[10px] tracking-wider transition-colors group/btn">
                                        Đọc tiếp
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transform group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
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
                <div class="text-center py-16 bg-white rounded-2xl border border-gray-100 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0V9a2 2 0 00-2-2H6a2 2 0 00-2 2v4h16z" />
                    </svg>
                    <p class="text-gray-500 font-medium">Chưa có bài viết nào được đăng tải.</p>
                </div>
            <?php endif; ?>
        </main>

        <!-- Right Column: Sidebar -->
        <aside class="w-full lg:w-1/4 space-y-8">
            <!-- Search Widget -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm transition-all duration-300 hover:shadow-md">
                <h3 class="text-xs font-black text-secondary uppercase tracking-widest mb-4 pb-2 border-b border-gray-100">Tìm kiếm</h3>
                <form role="search" method="get" class="relative" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input type="search" class="w-full py-2.5 pl-4 pr-10 rounded-xl bg-gray-50 border border-gray-100 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white transition-all placeholder-gray-400" placeholder="Tìm kiếm bài viết..." value="<?php echo get_search_query(); ?>" name="s" />
                    <input type="hidden" name="post_type" value="post" />
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Categories Widget -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm transition-all duration-300 hover:shadow-md">
                <h3 class="text-xs font-black text-secondary uppercase tracking-widest mb-4 pb-2 border-b border-gray-100">Chuyên mục</h3>
                <ul class="space-y-3">
                    <?php
                    $cats = get_categories( array( 'orderby' => 'name', 'order' => 'ASC' ) );
                    foreach( $cats as $cat ) :
                        ?>
                        <li class="flex justify-between items-center text-sm group/item">
                            <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="text-gray-600 group-hover/item:text-primary transition-colors font-semibold flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-300 group-hover/item:text-primary transition-colors transform group-hover/item:translate-x-0.5 duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                                <?php echo esc_html( $cat->name ); ?>
                            </a>
                            <span class="text-[10px] font-bold bg-gray-50 text-gray-400 group-hover/item:bg-primary/10 group-hover/item:text-primary group-hover/item:border-primary/10 px-2.5 py-0.5 rounded-full border border-gray-100 transition-all duration-300">
                                <?php echo esc_html( $cat->count ); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Recent Posts Widget -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm transition-all duration-300 hover:shadow-md">
                <h3 class="text-xs font-black text-secondary uppercase tracking-widest mb-4 pb-2 border-b border-gray-100">Bài viết mới</h3>
                <div class="space-y-4">
                    <?php
                    $recent_posts = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 5, 'post_status' => 'publish' ) );
                    if ( $recent_posts->have_posts() ) :
                        while ( $recent_posts->have_posts() ) : $recent_posts->the_post();
                            ?>
                            <a href="<?php the_permalink(); ?>" class="flex gap-3.5 group">
                                <div class="w-14 h-14 rounded-xl bg-gray-50 border border-gray-100 overflow-hidden flex-shrink-0 relative">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-all duration-300' ) ); ?>
                                    <?php else : ?>
                                        <div class="w-full h-full bg-gradient-to-br from-emerald-500/10 to-transparent flex items-center justify-center text-primary/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="text-xs font-bold text-secondary group-hover:text-primary transition-colors line-clamp-2 leading-snug">
                                        <?php the_title(); ?>
                                    </h4>
                                    <span class="text-[9px] font-black text-gray-400 mt-1 block uppercase">
                                        <?php echo get_the_date('d/m/Y'); ?>
                                    </span>
                                </div>
                            </a>
                        <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </aside>
    </div>
</div>

<?php
get_footer();
