<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS Play CDN (Fallback) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#f59e0b',
                            dark: '#d97706',
                        },
                        secondary: '#000000',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <!-- AlpineJS CDN (Fallback) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-gray-100' ); ?> x-data="{ mobileMenuOpen: false }">

<header class="sticky top-0 z-50 bg-secondary text-white shadow-md">
    <!-- Top Bar -->
    <div class="bg-gray-900 text-xs py-1 px-4 hidden md:block">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex space-x-4">
                <span>📍 Hệ thống cửa hàng</span>
                <span>📞 Hotline: 1900.xxxx</span>
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

        <!-- Category Toggle & Mega Menu -->
        <div class="relative group hidden lg:block" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
            <button class="bg-primary hover:bg-primary-dark text-black px-4 py-2 rounded font-bold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                DANH MỤC SẢN PHẨM
            </button>
            
            <!-- Mega Menu Content -->
            <div x-show="open" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
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
        <div class="flex-grow max-w-2xl relative">
            <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="relative">
                <input type="text" name="s" placeholder="Bạn tìm laptop gì?..." class="w-full py-2 px-4 rounded-full bg-white text-black focus:outline-none focus:ring-2 focus:ring-primary">
                <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- Header Icons -->
        <div class="flex items-center space-x-6 text-sm font-medium">
            <div class="hidden xl:flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <div class="leading-tight">Tin tức<br>Công nghệ</div>
            </div>
            
            <?php if ( function_exists( 'YITH_WCWL' ) ) : ?>
            <a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>" class="relative flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <span class="text-xs">Yêu thích</span>
            </a>
            <?php endif; ?>

            <a href="<?php echo wc_get_cart_url(); ?>" class="relative flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="text-xs">Giỏ hàng</span>
                <span class="absolute -top-1 -right-2 bg-primary text-black rounded-full text-[10px] w-4 h-4 flex items-center justify-center font-bold"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            </a>
        </div>
    </div>
</header>
