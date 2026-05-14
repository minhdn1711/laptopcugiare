<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        [x-cloak] { display: none !important; }
        /* Force container width like Laptop88 */
        .container {
            max-width: 1230px !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        /* Price Styling */
        .price del {
            opacity: 0.5;
            text-decoration: line-through;
            font-size: 0.8em;
            margin-right: 0.5rem;
            font-weight: normal;
        }
        .price ins {
            text-decoration: none;
            font-weight: 900;
        }
        /* Pagination Styling */
        .pagination-list {
            display: flex;
            gap: 0.5rem;
            list-style: none;
            padding: 0;
        }
        .pagination-list li a, .pagination-list li span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: white;
            border: 1px solid #e5e7eb;
            color: #374151;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .pagination-list li span.current {
            background: #ff9300;
            color: black;
            border-color: #ff9300;
        }
        .pagination-list li a:hover {
            border-color: #ff9300;
            color: #ff9300;
        }
        /* Ordering Select Styling */
        .wc-ordering-wrapper select {
            background-color: transparent;
            border: none;
            font-size: 0.875rem;
            font-weight: 700;
            color: #1f2937;
            padding-right: 2rem;
            cursor: pointer;
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right center;
            background-size: 1.25rem;
        }
        /* Fix woocommerce result count p tag */
        .wc-result-count {
            margin: 0 !important;
            display: inline-block !important;
        }
    </style>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-gray-100' ); ?> x-data="{ mobileMenuOpen: false }">

<header class="sticky top-0 z-50 bg-secondary text-white shadow-md">
    <!-- Top Bar -->
    <div class="bg-gray-900 text-xs py-1 hidden md:block border-b border-gray-800">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex space-x-4">
                <span class="flex items-center gap-1"><?php echo miliwebseo_icon('map-pin', 'h-3 w-3'); ?> Hệ thống cửa hàng</span>
                <span class="flex items-center gap-1"><?php echo miliwebseo_icon('phone', 'h-3 w-3'); ?> Hotline: 1900.xxxx</span>
            </div>
            <div class="flex space-x-4">
                <span>Góp ý</span>
                <span>Liên hệ</span>
                <span>Bảo hành</span>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="container mx-auto px-4 py-3 flex items-center justify-between gap-4">
        <!-- Logo -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex-shrink-0">
            <h1 class="text-2xl font-bold text-primary">MILIWEBSEO</h1>
        </a>

        <!-- Mobile Menu Toggle -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-primary">
            <?php echo miliwebseo_icon('menu', 'h-8 w-8'); ?>
        </button>

        <!-- Category Toggle & Mega Menu -->
        <div class="relative group hidden md:block flex-shrink-0" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
            <button class="bg-primary hover:bg-primary-dark text-black px-4 py-2 rounded font-bold flex items-center gap-2 whitespace-nowrap min-w-[200px] justify-center">
                <?php echo miliwebseo_icon('menu', 'h-5 w-5'); ?>
                DANH MỤC SẢN PHẨM
            </button>
            
            <!-- Mega Menu Content -->
            <div x-show="open" 
                 x-cloak
                 class="absolute top-full left-0 w-[800px] bg-white text-black shadow-xl rounded-b-lg border-t-4 border-primary grid grid-cols-4 p-6 gap-6 mt-0 z-[100]">
                
                <?php if ( ! miliwebseo_render_mega_menu() ) : ?>
                    <!-- Fallback hardcoded if menu not set in admin -->
                    <div>
                        <h3 class="font-bold border-b pb-2 mb-3 text-secondary uppercase text-xs">Laptop theo thương hiệu</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-primary transition-colors">Laptop Dell</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Laptop HP</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Laptop Asus</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Laptop Lenovo</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Laptop MSI</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Macbook</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold border-b pb-2 mb-3 text-secondary uppercase text-xs">Laptop theo nhu cầu</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-primary transition-colors">Laptop Gaming</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Văn phòng / Sinh viên</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Đồ họa chuyên nghiệp</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Mỏng nhẹ cao cấp</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold border-b pb-2 mb-3 text-secondary uppercase text-xs">Laptop theo giá</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-primary transition-colors">Dưới 10 triệu</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">10 - 15 triệu</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">15 - 20 triệu</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Trên 20 triệu</a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="bg-gray-100 p-4 rounded">
                    <img src="https://placehold.co/200x250?text=Mega+Menu+Banner" alt="Banner" class="w-full h-auto rounded">
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="flex-grow max-w-2xl relative" 
             x-data="{ 
                query: '', 
                results: [], 
                loading: false,
                search() {
                    if (this.query.length < 2) {
                        this.results = [];
                        return;
                    }
                    this.loading = true;
                    let formData = new FormData();
                    formData.append('action', 'miliwebseo_search');
                    formData.append('query', this.query);

                    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.results = data.success ? data.data : [];
                        this.loading = false;
                    });
                }
             }"
             @click.away="results = []">
            <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="relative">
                <input type="text" 
                       name="s" 
                       x-model="query"
                       @input.debounce.300ms="search()"
                       placeholder="Bạn tìm laptop gì?..." 
                       class="w-full py-2 px-4 rounded-full bg-white text-black focus:outline-none focus:ring-2 focus:ring-primary">
                <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <div x-show="!loading">
                        <?php echo miliwebseo_icon('search', 'h-5 w-5'); ?>
                    </div>
                    <div x-show="loading" class="animate-spin text-primary">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </button>
            </form>

            <!-- Search Results Dropdown -->
            <div x-show="results.length > 0" 
                 x-cloak
                 class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden z-[110] text-black">
                <div class="p-2 space-y-1">
                    <template x-for="item in results" :key="item.url">
                        <a :href="item.url" class="flex items-center gap-4 p-2 hover:bg-gray-50 rounded-lg transition-colors group">
                            <div class="w-12 h-12 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                <img :src="item.image" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-grow min-w-0">
                                <h4 class="text-sm font-bold truncate group-hover:text-primary transition-colors" x-text="item.title"></h4>
                                <p class="text-xs text-primary font-bold" x-html="item.price"></p>
                            </div>
                        </a>
                    </template>
                </div>
                <div class="bg-gray-50 p-2 text-center">
                    <a :href="'<?php echo home_url('/?s='); ?>' + query" class="text-xs font-bold text-blue-600 hover:underline">Xem tất cả kết quả cho "<span x-text="query"></span>"</a>
                </div>
            </div>
        </div>

        <!-- Header Icons -->
        <div class="flex items-center space-x-6 text-sm font-medium">
            <div class="hidden xl:flex items-center gap-2 group cursor-pointer hover:text-primary transition-colors">
                <?php echo miliwebseo_icon('newspaper', 'h-6 w-6 text-primary group-hover:scale-110 transition-transform'); ?>
                <div class="leading-tight">Tin tức<br>Công nghệ</div>
            </div>
            
            <?php if ( function_exists( 'YITH_WCWL' ) ) : ?>
            <a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>" class="relative flex flex-col items-center hover:text-primary transition-colors group">
                <?php echo miliwebseo_icon('heart', 'h-6 w-6 group-hover:scale-110 transition-transform'); ?>
                <span class="text-xs mt-1">Yêu thích</span>
            </a>
            <?php endif; ?>

            <?php if ( class_exists( 'WooCommerce' ) ) : ?>
            <a href="<?php echo wc_get_cart_url(); ?>" class="relative flex flex-col items-center hover:text-primary transition-colors group">
                <?php echo miliwebseo_icon('shopping-cart', 'h-6 w-6 group-hover:scale-110 transition-transform'); ?>
                <span class="text-xs mt-1">Giỏ hàng</span>
                <?php if ( WC()->cart ) : ?>
                <span class="absolute -top-1 -right-2 bg-primary text-black rounded-full text-[10px] w-4 h-4 flex items-center justify-center font-bold cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                <?php endif; ?>
            </a>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Mobile Menu Drawer -->
<div x-show="mobileMenuOpen" 
     x-cloak
     class="fixed inset-0 z-[100] lg:hidden" 
     role="dialog" aria-modal="true">
    <!-- Background backdrop -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="transition-opacity ease-linear duration-300" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         @click="mobileMenuOpen = false"
         class="fixed inset-0 bg-black bg-opacity-50"></div>

    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-in-out duration-300 transform" 
         x-transition:enter-start="-translate-x-full" 
         x-transition:enter-end="translate-x-0" 
         x-transition:leave="transition ease-in-out duration-300 transform" 
         x-transition:leave-start="translate-x-0" 
         x-transition:leave-end="-translate-x-full" 
         class="fixed inset-y-0 left-0 w-64 bg-white shadow-xl flex flex-col p-6 overflow-y-auto">
        
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-xl font-bold text-primary uppercase">Menu</h2>
            <button @click="mobileMenuOpen = false" class="text-gray-500 hover:text-red-500 transition-colors">
                <?php echo miliwebseo_icon('x-circle', 'h-7 w-7'); ?>
            </button>
        </div>

        <nav class="flex flex-col space-y-4">
            <a href="<?php echo home_url(); ?>" class="font-bold border-b pb-2">Trang chủ</a>
            
            <div x-data="{ open: true }">
                <button @click="open = !open" class="flex items-center justify-between w-full font-bold text-secondary">
                    DANH MỤC
                    <?php echo miliwebseo_icon('chevron-down', 'h-4 w-4 transform transition-transform', 3); ?>
                </button>
                <div x-show="open" class="mt-2 pl-4 space-y-2 text-sm">
                    <a href="#" class="block hover:text-primary">Laptop Dell</a>
                    <a href="#" class="block hover:text-primary">Laptop HP</a>
                    <a href="#" class="block hover:text-primary">Laptop Asus</a>
                    <a href="#" class="block hover:text-primary">Laptop Lenovo</a>
                    <a href="#" class="block hover:text-primary">Macbook</a>
                </div>
            </div>

            <a href="#" class="font-bold text-secondary">Tin tức</a>
            <a href="#" class="font-bold text-secondary">Khuyến mãi</a>
            <a href="#" class="font-bold text-secondary">Liên hệ</a>
        </nav>
    </div>
</div>

<!-- Mobile Bottom Navigation -->
<div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 py-2 px-4 flex justify-between items-center z-[100] md:hidden shadow-[0_-2px_10px_rgba(0,0,0,0.1)]">
    <a href="<?php echo home_url(); ?>" class="flex flex-col items-center text-gray-600 hover:text-primary transition-colors">
        <?php echo miliwebseo_icon('home', 'h-6 w-6'); ?>
        <span class="text-[10px] mt-1 font-medium">Trang chủ</span>
    </a>
    <a href="javascript:void(0)" @click="mobileMenuOpen = true" class="flex flex-col items-center text-gray-600 hover:text-primary transition-colors">
        <?php echo miliwebseo_icon('menu', 'h-6 w-6'); ?>
        <span class="text-[10px] mt-1 font-medium">Danh mục</span>
    </a>
    <?php if ( class_exists( 'WooCommerce' ) ) : ?>
    <a href="<?php echo wc_get_cart_url(); ?>" class="flex flex-col items-center text-gray-600 hover:text-primary transition-colors relative">
        <?php echo miliwebseo_icon('shopping-cart', 'h-6 w-6'); ?>
        <span class="text-[10px] mt-1 font-medium">Giỏ hàng</span>
        <?php if ( WC()->cart ) : ?>
        <span class="absolute -top-1 -right-1 bg-primary text-black rounded-full text-[9px] w-4 h-4 flex items-center justify-center font-bold cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        <?php endif; ?>
    </a>
    <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="flex flex-col items-center text-gray-600 hover:text-primary transition-colors">
        <?php echo miliwebseo_icon('user', 'h-6 w-6'); ?>
        <span class="text-[10px] mt-1 font-medium">Tài khoản</span>
    </a>
    <?php else : ?>
    <a href="#" class="flex flex-col items-center text-gray-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <span class="text-[10px] mt-1 font-medium">Giỏ hàng</span>
    </a>
    <a href="#" class="flex flex-col items-center text-gray-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <span class="text-[10px] mt-1 font-medium">Tài khoản</span>
    </a>
    <?php endif; ?>
</div>

<script>
    // Sticky Header Scroll Effect
    window.addEventListener('scroll', function() {
        const header = document.querySelector('header');
        if (window.scrollY > 100) {
            header.classList.add('shadow-xl');
            header.style.paddingTop = '5px';
            header.style.paddingBottom = '5px';
        } else {
            header.classList.remove('shadow-xl');
            header.style.paddingTop = '';
            header.style.paddingBottom = '';
        }
    });
</script>

<main class="min-h-[70vh] pb-12">
