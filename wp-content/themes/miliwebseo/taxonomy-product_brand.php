<?php
/**
 * Taxonomy Brand Archive Template
 */

get_header();
$current_term = get_queried_object();
$orderby = isset( $_GET['orderby'] ) ? sanitize_text_field( $_GET['orderby'] ) : 'date';
?>

<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="text-sm mb-6 flex items-center gap-2 text-gray-500">
            <a href="<?php echo home_url(); ?>" class="hover:text-primary">Trang chủ</a>
            <span>/</span>
            <span class="text-gray-900 font-medium"><?php echo $current_term->name; ?></span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar (Optional, can add filters here) -->
            <aside class="w-full lg:w-1/4">
                <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                    <h3 class="font-bold text-lg mb-4 border-b pb-2">Danh mục thương hiệu</h3>
                    <ul class="space-y-2">
                        <?php
                        $brands = get_terms( array( 'taxonomy' => 'product_brand', 'hide_empty' => true ) );
                        foreach ( $brands as $brand ) :
                            $active_class = ( $brand->term_id == $current_term->term_id ) ? 'text-primary font-bold' : 'text-gray-600 hover:text-primary';
                        ?>
                            <li>
                                <a href="<?php echo get_term_link( $brand ); ?>" class="<?php echo $active_class; ?>">
                                    <?php echo $brand->name; ?> (<?php echo $brand->count; ?>)
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="w-full lg:w-3/4">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 bg-white p-4 rounded-lg shadow-sm">
                    <h1 class="text-2xl font-bold text-secondary mb-4 md:mb-0">
                        <?php echo $current_term->name; ?>
                    </h1>

                    <!-- Sorting Filter -->
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-medium text-gray-500">Sắp xếp:</span>
                        <select onchange="location = this.value;" class="border-gray-300 rounded-md text-sm focus:ring-primary focus:border-primary">
                            <?php
                            $sort_options = array(
                                'date'       => 'Mới nhất',
                                'price'      => 'Giá tăng dần',
                                'price-desc' => 'Giá giảm dần',
                                'views'      => 'Lượt xem',
                                'rating'     => 'Đánh giá',
                                'title'      => 'Tên A->Z',
                            );
                            foreach ( $sort_options as $key => $label ) :
                                $selected = ( $orderby == $key ) ? 'selected' : '';
                                $url = add_query_arg( 'orderby', $key );
                            ?>
                                <option value="<?php echo esc_url( $url ); ?>" <?php echo $selected; ?>>
                                    <?php echo $label; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Products Grid -->
                <?php if ( have_posts() ) : ?>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php wc_get_template_part( 'content', 'product' ); ?>
                        <?php endwhile; ?>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 flex justify-center">
                        <?php
                        the_posts_pagination( array(
                            'mid_size'  => 2,
                            'prev_text' => '&larr; Trước',
                            'next_text' => 'Sau &rarr;',
                            'class'     => 'flex gap-2'
                        ) );
                        ?>
                    </div>
                <?php else : ?>
                    <div class="bg-white p-12 text-center rounded-lg shadow-sm">
                        <p class="text-gray-500 mb-4">Không tìm thấy sản phẩm nào trong thương hiệu này.</p>
                        <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="btn-primary inline-block">
                            Quay lại cửa hàng
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
