<?php
/**
 * The Template for displaying all product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<div class="container mx-auto px-4">
    <!-- Breadcrumb & Title -->
    <nav class="flex py-4 text-[10px] text-gray-500 uppercase font-bold" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
                <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors">Trang chủ</a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="mx-2 text-gray-300">/</span>
                    <span class="text-gray-400"><?php woocommerce_page_title(); ?></span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <header class="mb-8">
            <h1 class="text-3xl font-black text-secondary uppercase italic">
                <?php woocommerce_page_title(); ?>
            </h1>
            <?php do_action( 'woocommerce_archive_description' ); ?>
        </header>

        <div class="flex flex-col lg:flex-row gap-8" 
             x-data="{ 
                loading: false, 
                brands: [], 
                cpus: [], 
                price: '',
                current_tax: '<?php echo is_tax() ? get_queried_object()->taxonomy : ''; ?>',
                current_term: '<?php echo is_tax() ? get_queried_object()->slug : ''; ?>',
                filterProducts() {
                    this.loading = true;
                    let formData = new FormData();
                    formData.append('action', 'miliwebseo_filter_products');
                    
                    // If we are on a specific brand page and no other brands are selected, 
                    // we should ensure the current brand is preserved.
                    if (this.current_tax === 'product_brand' && this.brands.length === 0) {
                        formData.append('brands[]', this.current_term);
                    } else {
                        this.brands.forEach(b => formData.append('brands[]', b));
                    }

                    this.cpus.forEach(c => formData.append('cpus[]', c));
                    formData.append('price', this.price);
                    
                    // Always send current context if not shop page
                    if (this.current_tax && this.current_tax !== 'product_brand') {
                        formData.append('current_tax', this.current_tax);
                        formData.append('current_term', this.current_term);
                    }

                    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('product-grid-container').innerHTML = data.data;
                        }
                        this.loading = false;
                    });
                }
             }">
            <!-- Sidebar: Filters -->
            <aside class="w-full lg:w-1/4 flex-shrink-0">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h2 class="font-bold text-lg mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        BỘ LỌC TÌM KIẾM
                    </h2>

                    <!-- Filter by Brand -->
                    <div class="mb-8">
                        <h3 class="font-bold text-sm uppercase text-gray-400 mb-4 tracking-wider">Thương hiệu</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <?php
                            $brands = get_terms(['taxonomy' => 'product_brand', 'hide_empty' => true]);
                            foreach ($brands as $brand) :
                            ?>
                                <label class="flex items-center gap-2 p-2 border border-gray-100 rounded-lg cursor-pointer hover:border-primary transition-all has-[:checked]:border-primary has-[:checked]:bg-yellow-50">
                                    <input type="checkbox" value="<?php echo $brand->slug; ?>" x-model="brands" @change="filterProducts()" class="rounded text-primary focus:ring-primary h-4 w-4">
                                    <span class="text-xs font-medium truncate"><?php echo $brand->name; ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Filter by Specs (CPU) -->
                    <div class="mb-8">
                        <h3 class="font-bold text-sm uppercase text-gray-400 mb-4 tracking-wider">Dòng CPU</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <?php
                            $cpus = get_terms(['taxonomy' => 'cpu', 'hide_empty' => true]);
                            foreach ($cpus as $cpu) :
                            ?>
                                <label class="flex items-center gap-2 p-2 border border-gray-100 rounded-lg cursor-pointer hover:border-primary transition-all has-[:checked]:border-primary has-[:checked]:bg-yellow-50">
                                    <input type="checkbox" value="<?php echo $cpu->slug; ?>" x-model="cpus" @change="filterProducts()" class="rounded text-primary focus:ring-primary h-4 w-4">
                                    <span class="text-xs font-medium truncate"><?php echo $cpu->name; ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Filter by Price -->
                    <div class="mb-8">
                        <h3 class="font-bold text-sm uppercase text-gray-400 mb-4 tracking-wider">Khoảng giá</h3>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm cursor-pointer hover:text-primary">
                                <input type="radio" name="price_filter" value="under-10" x-model="price" @change="filterProducts()" class="text-primary"> Dưới 10 triệu
                            </label>
                            <label class="flex items-center gap-2 text-sm cursor-pointer hover:text-primary">
                                <input type="radio" name="price_filter" value="10-20" x-model="price" @change="filterProducts()" class="text-primary"> 10 - 20 triệu
                            </label>
                            <label class="flex items-center gap-2 text-sm cursor-pointer hover:text-primary">
                                <input type="radio" name="price_filter" value="over-20" x-model="price" @change="filterProducts()" class="text-primary"> Trên 20 triệu
                            </label>
                        </div>
                    </div>

                    <button @click="brands=[]; cpus=[]; price=''; filterProducts();" class="w-full border-2 border-gray-200 text-gray-500 py-2 rounded-lg font-bold text-xs uppercase hover:bg-gray-100 transition-colors">
                        Xóa tất cả lọc
                    </button>
                </div>
            </aside>

            <!-- Main Content: Product Grid -->
            <main class="w-full lg:w-3/4 relative">
                <!-- Loading Overlay -->
                <div x-show="loading" class="absolute inset-0 bg-white bg-opacity-70 z-50 flex items-center justify-center rounded-xl">
                    <div class="animate-spin rounded-full h-12 w-12 border-4 border-primary border-t-transparent"></div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-8 bg-primary rounded-full"></div>
                        <p class="text-sm font-bold text-secondary uppercase tracking-wider">
                            Hiển thị: <span class="text-primary"><?php echo woocommerce_result_count(); ?></span>
                        </p>
                    </div>
                    <div class="flex items-center gap-4 bg-gray-50 px-4 py-2 rounded-lg border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-tighter">Sắp xếp theo:</span>
                        <div class="wc-ordering-wrapper">
                            <?php woocommerce_catalog_ordering(); ?>
                        </div>
                    </div>
                </div>

                <div id="product-grid-container">
                    <?php if ( woocommerce_product_loop() ) : ?>
                        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                            <?php
                            while ( have_posts() ) :
                                the_post();
                                wc_get_template_part( 'content', 'product' );
                            endwhile;
                            ?>
                        </div>
                        
                        <div class="mt-12">
                            <?php woocommerce_pagination(); ?>
                        </div>
                    <?php else : ?>
                        <div class="bg-white rounded-xl p-12 text-center shadow-sm border border-gray-100">
                            <img src="https://placehold.co/200x200?text=Empty" alt="No product" class="mx-auto mb-4 opacity-20">
                            <h3 class="text-xl font-bold text-gray-400">Không tìm thấy sản phẩm nào</h3>
                            <p class="text-gray-400 mt-2">Vui lòng thử lại với bộ lọc khác</p>
                            <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="inline-block mt-6 bg-primary text-black px-6 py-2 rounded-full font-bold">Quay lại cửa hàng</a>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
</div>

<?php get_footer(); ?>
