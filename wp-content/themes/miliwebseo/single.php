<?php
/**
 * The template for displaying all single posts
 *
 * @package Miliwebseo
 */

get_header();
?>

<!-- Hero / Breadcrumb Header -->
<div class="bg-gray-50 border-b border-gray-100 py-8 mb-10">
    <div class="container mx-auto px-4 md:px-6">
        <!-- Breadcrumbs -->
        <nav class="text-[11px] text-gray-500 uppercase font-bold" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary transition-colors">Trang chủ</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <span class="mx-2 text-gray-300">/</span>
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ?: home_url( '/tin-tuc/' ) ); ?>" class="hover:text-primary transition-colors">Tin tức</a>
                    </div>
                </li>
                <?php
                $categories = get_the_category();
                if ( ! empty( $categories ) ) :
                    ?>
                    <li>
                        <div class="flex items-center">
                            <span class="mx-2 text-gray-300">/</span>
                            <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="hover:text-primary transition-colors"><?php echo esc_html( $categories[0]->name ); ?></a>
                        </div>
                    </li>
                <?php endif; ?>
                <li class="hidden md:inline-flex">
                    <div class="flex items-center min-w-0">
                        <span class="mx-2 text-gray-300">/</span>
                        <span class="text-gray-400 truncate max-w-[250px]"><?php the_title(); ?></span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="container mx-auto px-4 md:px-6 pb-16">
    <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
        <!-- Left Column: Article Content -->
        <main id="primary" class="w-full lg:w-3/4">
            <?php
            while ( have_posts() ) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-10 space-y-6' ); ?>>
                    <!-- Meta Info & Category -->
                    <div class="space-y-4">
                        <?php if ( ! empty( $categories ) ) : ?>
                            <div class="flex flex-wrap gap-2">
                                <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="text-[10px] font-black text-primary uppercase tracking-widest hover:underline leading-none">
                                    <?php echo esc_html( $categories[0]->name ); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- Title -->
                        <h1 class="text-2xl md:text-3.5xl font-black text-secondary leading-tight italic">
                            <?php the_title(); ?>
                        </h1>

                        <!-- Author, Date, Comments -->
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-xs text-gray-400 font-medium pb-4 border-b border-gray-100">
                            <span class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Đăng bởi: <strong class="text-gray-600 font-bold"><?php the_author(); ?></strong>
                            </span>
                            
                            <span class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <?php echo get_the_date('d/m/Y'); ?>
                            </span>

                            <span class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                <?php comments_number( 'Chưa có bình luận', '1 bình luận', '% bình luận' ); ?>
                            </span>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="rounded-2xl overflow-hidden aspect-[16/9] bg-gray-50 border border-gray-100">
                            <?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Article Content -->
                    <div class="prose prose-slate max-w-none text-gray-600 leading-relaxed text-sm md:text-base space-y-6">
                        <?php
                        the_content();

                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . esc_html__( 'Trang:', 'miliwebseo' ),
                            'after'  => '</div>',
                        ) );
                        ?>
                    </div>

                    <!-- Tags & Social Share -->
                    <?php
                    $tags = get_the_tags();
                    if ( ! empty( $tags ) ) :
                        ?>
                        <div class="pt-6 border-t border-gray-100 flex flex-wrap gap-2 items-center">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mr-2">Tags:</span>
                            <?php foreach ( $tags as $tag ) : ?>
                                <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="text-[11px] font-semibold text-gray-500 bg-gray-50 border border-gray-100 hover:bg-primary hover:text-white hover:border-primary px-3 py-1 rounded-full transition-all">
                                    #<?php echo esc_html( $tag->name ); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Navigation Next/Prev -->
                    <div class="pt-8 border-t border-gray-100 flex flex-col sm:flex-row justify-between gap-4">
                        <div class="w-full sm:w-1/2">
                            <?php
                            $prev_post = get_previous_post();
                            if ( ! empty( $prev_post ) ) :
                                ?>
                                <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="group block p-4 rounded-xl border border-gray-100 hover:border-primary/30 hover:bg-gray-50/50 transition-all h-full">
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-1">← Bài trước đó</span>
                                    <span class="text-xs font-bold text-secondary group-hover:text-primary transition-colors line-clamp-2 leading-snug"><?php echo esc_html( $prev_post->post_title ); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="w-full sm:w-1/2 text-right">
                            <?php
                            $next_post = get_next_post();
                            if ( ! empty( $next_post ) ) :
                                ?>
                                <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="group block p-4 rounded-xl border border-gray-100 hover:border-primary/30 hover:bg-gray-50/50 transition-all h-full">
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-1">Bài tiếp theo →</span>
                                    <span class="text-xs font-bold text-secondary group-hover:text-primary transition-colors line-clamp-2 leading-snug"><?php echo esc_html( $next_post->post_title ); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </main>

        <!-- Right Column: Sidebar -->
        <aside class="w-full lg:w-1/4 space-y-8">
            <!-- Search Widget -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <h3 class="text-xs font-black text-secondary uppercase tracking-widest mb-4 pb-2 border-b border-gray-100">Tìm kiếm</h3>
                <form role="search" method="get" class="relative" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input type="search" class="w-full py-2.5 pl-4 pr-10 rounded-xl bg-gray-50 border border-gray-100 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-all placeholder-gray-400" placeholder="Tìm kiếm bài viết..." value="<?php echo get_search_query(); ?>" name="s" />
                    <input type="hidden" name="post_type" value="post" />
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Categories Widget -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <h3 class="text-xs font-black text-secondary uppercase tracking-widest mb-4 pb-2 border-b border-gray-100">Chuyên mục</h3>
                <ul class="space-y-3">
                    <?php
                    $cats = get_categories( array( 'orderby' => 'name', 'order' => 'ASC' ) );
                    foreach( $cats as $cat ) :
                        ?>
                        <li class="flex justify-between items-center text-sm">
                            <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="text-gray-600 hover:text-primary transition-colors font-semibold">
                                <?php echo esc_html( $cat->name ); ?>
                            </a>
                            <span class="text-[10px] font-bold bg-gray-50 text-gray-400 px-2 py-0.5 rounded-full border border-gray-100">
                                <?php echo esc_html( $cat->count ); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Recent Posts Widget -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
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
                                        <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-300">
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
