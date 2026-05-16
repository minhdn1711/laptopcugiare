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
        /* Premium WooCommerce Pagination Reset */
        .woocommerce nav.woocommerce-pagination ul, 
        nav.woocommerce-pagination ul, .pagination-list, .page-numbers {
            display: flex !important;
            gap: 1rem !important;
            list-style: none !important;
            padding: 0 !important;
            margin: 3rem 0 0 0 !important;
            justify-content: center !important;
            align-items: center !important;
            border: none !important;
        }
        .woocommerce nav.woocommerce-pagination ul li,
        nav.woocommerce-pagination ul li, .pagination-list li, .page-numbers li {
            border: none !important;
            margin: 0 !important;
            padding: 0 !important;
            background: none !important;
        }
        nav.woocommerce-pagination ul li a, nav.woocommerce-pagination ul li span,
        .pagination-list li a, .pagination-list li span, 
        .page-numbers li a, .page-numbers li span.page-numbers {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 44px !important;
            height: 44px !important;
            padding: 0 14px !important;
            border-radius: 12px !important;
            background: white !important;
            border: 1px solid #f1f1f1 !important;
            color: #4b5563 !important;
            font-size: 14px !important;
            font-weight: 900 !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02) !important;
            text-decoration: none !important;
        }
        nav.woocommerce-pagination ul li span.current, 
        .pagination-list li span.current, 
        .page-numbers li span.current {
            background: #10B981 !important;
            color: white !important;
            border-color: #10B981 !important;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.25) !important;
            transform: translateY(-2px) !important;
        }
        nav.woocommerce-pagination ul li a:hover,
        .pagination-list li a:hover, 
        .page-numbers li a:hover {
            border-color: #10B981 !important;
            color: #10B981 !important;
            background: white !important;
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.1) !important;
            transform: translateY(-2px) !important;
        }
        .page-numbers .prev, .page-numbers .next {
            background: #f9fafb !important;
            font-size: 18px !important;
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
        .woocommerce-result-count, .woocommerce-ordering {
            margin: 0 !important;
            display: inline-block !important;
        }
        /* Mega Menu Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(10px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* Dynamic Customizer Settings */
        :root {
            --logo-width: <?php echo get_theme_mod('logo_width', '246'); ?>px;
            --menu-height: <?php echo get_theme_mod('menu_height', '50'); ?>px;
            --header-padding: 10px;
        }
    </style>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-gray-100' ); ?> x-data="{ mobileMenuOpen: false }">
    <div x-data="{ active: true }" x-show="active" class="bg-red-500 text-white text-[10px] py-1 text-center font-bold fixed top-0 left-0 w-full z-[9999]">
        ALPINE JS ĐANG HOẠT ĐỘNG
    </div>
    <?php wp_body_open(); ?>

<header class="sticky top-0 z-50 bg-white shadow-sm">
    <!-- Top Bar -->
    <div class="bg-gray-900 text-white text-[11px] py-1.5 hidden md:block">
        <div class="container mx-auto px-4 flex justify-between items-center opacity-80">
            <div class="flex space-x-6">
                <span class="flex items-center gap-1.5 hover:text-primary cursor-pointer transition-colors"><?php echo miliwebseo_icon('map-pin', 'h-3.5 w-3.5'); ?> Hệ thống 15 cửa hàng</span>
                <span class="flex items-center gap-1.5 hover:text-primary cursor-pointer transition-colors"><?php echo miliwebseo_icon('phone', 'h-3.5 w-3.5'); ?> Hotline: 1900.xxxx</span>
            </div>
            <div class="flex space-x-6 font-medium">
                <a href="#" class="hover:text-primary transition-colors">Góp ý / Khiếu nại</a>
                <a href="#" class="hover:text-primary transition-colors">Tra cứu bảo hành</a>
                <a href="#" class="hover:text-primary transition-colors">Tin công nghệ</a>
            </div>
        </div>
    </div>

    <!-- Main Header (Desktop) -->
    <div class="hidden md:block bg-secondary text-white border-b border-white/5" style="padding: var(--header-padding) 0;">
        <div class="container mx-auto px-4 flex items-center justify-between gap-8">
            <!-- Logo Area (Fixed Width from Customizer) -->
            <div class="flex-shrink-0 w-[var(--logo-width)] flex items-center">
                <?php 
                $dark_logo = get_theme_mod('dark_logo');
                if ( $dark_logo ) : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center">
                        <img src="<?php echo esc_url($dark_logo); ?>" alt="<?php bloginfo('name'); ?>" class="h-10 w-auto object-contain">
                    </a>
                <?php elseif ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-footer.svg" alt="<?php bloginfo('name'); ?>" class="h-10 w-auto object-contain">
                    </a>
                <?php endif; ?>
            </div>

            <!-- Search Center -->
            <div class="flex-grow max-w-2xl relative" x-data="searchComponent()" @click.away="results = []">
                <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="relative group">
                    <input type="text" name="s" x-model="query" @input.debounce.300ms="search()" placeholder="Tìm kiếm sản phẩm..." 
                           class="w-full py-2.5 px-6 rounded-full bg-white/10 border border-white/10 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white focus:text-black transition-all">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 bg-primary text-black rounded-full hover:bg-yellow-400 transition-all shadow-lg">
                        <div x-show="!loading"><?php echo miliwebseo_icon('search', 'h-4 w-4'); ?></div>
                        <div x-show="loading" class="animate-spin text-black"><?php echo miliwebseo_icon('refresh-cw', 'h-4 w-4'); ?></div>
                    </button>
                </form>
                <!-- Results Dropdown -->
                <div x-show="results.length > 0" x-cloak class="absolute top-full left-0 right-0 mt-3 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-[110] text-black">
                    <div class="p-3 space-y-1">
                        <template x-for="item in results" :key="item.url">
                            <a :href="item.url" class="flex items-center gap-4 p-2.5 hover:bg-gray-50 rounded-xl transition-colors group">
                                <div class="w-14 h-14 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0"><img :src="item.image" class="w-full h-full object-cover"></div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="text-sm font-bold truncate group-hover:text-primary transition-colors" x-text="item.title"></h4>
                                    <p class="text-xs text-primary font-black" x-html="item.price"></p>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Header Action Icons -->
            <div class="flex items-center space-x-5">
                <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="flex items-center gap-2.5 hover:text-primary transition-all group">
                    <div class="p-2.5 bg-white/5 rounded-xl group-hover:bg-primary group-hover:text-black transition-all">
                        <?php echo miliwebseo_icon('user', 'h-5 w-5'); ?>
                    </div>
                    <div class="hidden lg:block text-left leading-tight">
                        <p class="text-[10px] text-white/50 uppercase font-bold">Tài khoản</p>
                        <p class="text-xs font-black">Đăng nhập</p>
                    </div>
                </a>
                
                <a href="<?php echo wc_get_cart_url(); ?>" class="relative group flex items-center gap-2.5">
                    <div class="p-2.5 bg-primary text-black rounded-xl hover:scale-105 transition-all shadow-lg shadow-primary/20">
                        <?php echo miliwebseo_icon('shopping-cart', 'h-5 w-5'); ?>
                    </div>
                    <div class="hidden lg:block text-left leading-tight">
                        <p class="text-[10px] text-white/50 uppercase font-bold">Giỏ hàng</p>
                        <p class="text-xs font-black"><?php echo WC()->cart->get_cart_total(); ?></p>
                    </div>
                    <span class="absolute -top-2 -left-2 bg-red-600 text-white rounded-full text-[10px] w-5 h-5 flex items-center justify-center font-bold border-2 border-secondary shadow-lg cart-count">
                        <?php echo WC()->cart->get_cart_contents_count(); ?>
                    </span>
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom Header / Nav Bar (Desktop) -->
    <div class="hidden md:block bg-white border-b border-gray-100 shadow-sm h-[var(--menu-height)] sticky top-[80px] z-[40]" 
         x-init="console.log('Alpine Mega Menu Ready')"
         x-data="{ 
            activeTab: null, 
            menuContent: {},
            loading: false,
            loadSubMenu(id) {
                console.log('Hovering Category ID:', id);
                this.activeTab = id;
                if (this.menuContent[id]) return;

                this.loading = true;
                let formData = new FormData();
                formData.append('action', 'load_mega_menu');
                formData.append('parent_id', id);

                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(res => {
                    console.log('AJAX Response:', res);
                    if (res.success) {
                        this.menuContent[id] = res.data;
                    }
                    this.loading = false;
                });
            },
            closeMenu() {
                this.activeTab = null;
            }
         }" @mouseleave="closeMenu()">
        <div class="container mx-auto px-4 flex items-center justify-between h-full relative">
            <div class="flex items-center space-x-8 h-full">
                <!-- Mega Menu Trigger Button -->
                <div class="relative h-full flex items-center group">
                    <div class="bg-primary text-black w-[var(--logo-width)] h-full font-black text-xs flex items-center justify-center gap-3 cursor-pointer uppercase tracking-wider">
                        <?php echo miliwebseo_icon('menu', 'h-5 w-5'); ?>
                        DANH MỤC SẢN PHẨM
                    </div>

                    <!-- Level 1 SSR Menu -->
                    <div class="absolute top-full left-0 w-[var(--logo-width)] bg-white shadow-2xl border border-gray-100 z-[100] py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <?php
                        $l1_categories = get_terms(['taxonomy' => 'product_cat', 'parent' => 0, 'hide_empty' => false]);
                        foreach ($l1_categories as $cat) :
                        ?>
                            <div class="relative" @mouseenter="loadSubMenu(<?php echo $cat->term_id; ?>)">
                                <a href="<?php echo get_term_link($cat); ?>" 
                                   class="flex items-center justify-between px-6 py-3 text-[13px] font-bold text-gray-700 hover:bg-gray-50 hover:text-primary transition-all">
                                    <span class="flex items-center gap-3 uppercase">
                                        <img src="<?php echo get_term_meta($cat->term_id, 'icon', true); ?>" class="w-4 h-4 opacity-70">
                                        <?php echo get_term_meta($cat->term_id, 'menu_title', true) ?: $cat->name; ?>
                                    </span>
                                    <?php echo miliwebseo_icon('chevron-right', 'h-3.5 w-3.5 opacity-30'); ?>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Horizontal Navigation -->
                <nav class="flex items-center space-x-10 h-full">
                    <?php miliwebseo_render_primary_menu(); ?>
                </nav>
            </div>

            <div class="flex items-center gap-4">
                 <span class="text-xs font-bold text-secondary flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    250+ Laptop đang sẵn hàng
                 </span>
            </div>

            <!-- MEGA DROPDOWN PANEL (Full-width Content) -->
            <div class="absolute top-full left-0 w-full z-[110] bg-white shadow-2xl border-4 border-red-500" 
                 x-show="activeTab !== null" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-2"
                 style="display: none; min-height: 200px;">
                
                <div x-show="loading" class="p-20 flex justify-center items-center">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-primary"></div>
                </div>

                <template x-if="activeTab && menuContent[activeTab]">
                    <div x-html="menuContent[activeTab]"></div>
                </template>
            </div>
        </div>
    </div>
        </div>
    </div>

    <!-- Mobile Header Redesign -->
    <div class="md:hidden bg-secondary text-white">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between gap-4">
            <button @click="mobileMenuOpen = true" class="p-2 -ml-2 text-primary bg-white/5 rounded-lg">
                <?php echo miliwebseo_icon('menu', 'h-6 w-6'); ?>
            </button>

            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex-grow flex justify-center">
                <?php 
                $dark_logo = get_theme_mod('dark_logo');
                if ( $dark_logo ) : ?>
                    <img src="<?php echo esc_url($dark_logo); ?>" alt="<?php bloginfo('name'); ?>" class="h-8 w-auto object-contain">
                <?php elseif ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-footer.svg" alt="<?php bloginfo('name'); ?>" class="h-8 w-auto">
                <?php endif; ?>
            </a>

            <a href="<?php echo wc_get_cart_url(); ?>" class="relative p-2 bg-primary text-black rounded-lg">
                <?php echo miliwebseo_icon('shopping-cart', 'h-6 w-6'); ?>
                <span class="absolute -top-1 -right-1 bg-red-600 text-white rounded-full text-[9px] w-4 h-4 flex items-center justify-center font-bold"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            </a>
        </div>
        
        <!-- Mobile Search -->
        <div class="container mx-auto px-4 pb-3" x-data="searchComponent()" @click.away="results = []">
            <div class="relative">
                <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
                    <input type="text" name="s" x-model="query" @input.debounce.300ms="search()" placeholder="Bạn tìm gì hôm nay?..." 
                           class="w-full py-2.5 px-5 rounded-full bg-white/10 border border-white/10 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-primary text-sm">
                </form>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Menu Drawer (Hybrid AJAX Redesign) -->
<div x-show="mobileMenuOpen" 
     x-cloak
     class="fixed inset-0 z-[100] md:hidden" 
     role="dialog" 
     aria-modal="true">
    <!-- Backdrop -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="transition-opacity ease-linear duration-300" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         @click="mobileMenuOpen = false" 
         class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
    
    <!-- Drawer Content -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-in-out duration-300 transform" 
         x-transition:enter-start="-translate-x-full" 
         x-transition:enter-end="translate-x-0" 
         x-transition:leave="transition ease-in-out duration-300 transform" 
         x-transition:leave-start="translate-x-0" 
         x-transition:leave-end="-translate-x-full" 
         class="fixed inset-y-0 left-0 w-[85%] max-w-sm bg-white shadow-2xl flex flex-col overflow-hidden">
        
        <!-- Drawer Header -->
        <div class="bg-secondary p-6 flex items-center justify-between text-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-black">
                    <?php echo miliwebseo_icon('user', 'h-6 w-6'); ?>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Xin chào!</p>
                    <p class="font-bold">Khách hàng</p>
                </div>
            </div>
            <button @click="mobileMenuOpen = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition-all">
                <?php echo miliwebseo_icon('x', 'h-5 w-5'); ?>
            </button>
        </div>

        <div class="flex-grow overflow-y-auto" x-data="{ 
            openTab: null, 
            menuContent: {}, 
            loading: false,
            toggleTab(id) {
                this.openTab = this.openTab === id ? null : id;
                if (this.openTab && !this.menuContent[id]) {
                    this.loading = true;
                    let formData = new FormData();
                    formData.append('action', 'load_mega_menu');
                    formData.append('parent_id', id);

                    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            this.menuContent[id] = res.data;
                        }
                        this.loading = false;
                    });
                }
            }
        }">
            <nav class="p-4 space-y-6">
                <!-- Categories Section -->
                <div class="space-y-3">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Danh mục sản phẩm</p>
                    <ul class="space-y-1">
                        <?php
                        $l1_categories = get_terms(['taxonomy' => 'product_cat', 'parent' => 0, 'hide_empty' => false]);
                        foreach ($l1_categories as $cat) :
                        ?>
                            <li class="border-b border-gray-50 last:border-0">
                                <div class="flex items-center justify-between">
                                    <a href="<?php echo get_term_link($cat); ?>" class="flex-grow py-3 px-2 text-sm font-bold text-gray-800 flex items-center gap-3">
                                        <img src="<?php echo get_term_meta($cat->term_id, 'icon', true) ?: get_template_directory_uri() . '/assets/images/cat-default.svg'; ?>" class="w-5 h-5 opacity-60">
                                        <?php echo get_term_meta($cat->term_id, 'menu_title', true) ?: $cat->name; ?>
                                    </a>
                                    <button @click="toggleTab(<?php echo $cat->term_id; ?>)" 
                                            class="p-3 text-gray-400 hover:text-primary transition-colors"
                                            :aria-expanded="openTab === <?php echo $cat->term_id; ?>">
                                        <div :class="openTab === <?php echo $cat->term_id; ?> ? 'rotate-180' : ''" class="transition-transform duration-300">
                                            <?php echo miliwebseo_icon('chevron-down', 'h-4 w-4'); ?>
                                        </div>
                                    </button>
                                </div>
                                
                                <div x-show="openTab === <?php echo $cat->term_id; ?>" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 -translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="bg-gray-50 rounded-lg mb-2 overflow-hidden">
                                    
                                    <div x-show="loading && openTab === <?php echo $cat->term_id; ?>" class="p-6 flex justify-center">
                                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-primary"></div>
                                    </div>

                                    <template x-if="menuContent[<?php echo $cat->term_id; ?>]">
                                        <div class="p-2 mobile-mega-content" x-html="menuContent[<?php echo $cat->term_id; ?>]"></div>
                                    </template>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Support Section -->
                <div class="space-y-3">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Hỗ trợ</p>
                    <div class="grid grid-cols-1 gap-2">
                        <a href="#" class="flex items-center gap-3 text-sm font-medium text-gray-600 hover:text-primary">
                            <?php echo miliwebseo_icon('help-circle', 'h-4 w-4'); ?> Hướng dẫn mua hàng
                        </a>
                        <a href="#" class="flex items-center gap-3 text-sm font-medium text-gray-600 hover:text-primary">
                            <?php echo miliwebseo_icon('shield-check', 'h-4 w-4'); ?> Chính sách bảo hành
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        
        <!-- Drawer Footer -->
        <div class="p-6 border-t border-gray-100 bg-gray-50">
            <div class="flex items-center gap-4">
                <div class="flex-grow">
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Hotline hỗ trợ</p>
                    <p class="text-lg font-black text-secondary tracking-tighter">1900.xxxx</p>
                </div>
                <a href="tel:1900xxxx" class="w-12 h-12 bg-primary rounded-full flex items-center justify-center shadow-lg shadow-primary/30">
                    <?php echo miliwebseo_icon('phone', 'h-6 w-6 text-black'); ?>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS override for mobile mega content grid */
    .mobile-mega-content .grid { display: block !important; padding: 0 !important; }
    .mobile-mega-content .grid-cols-5 { grid-template-cols: 1fr !important; }
    .mobile-mega-content .col-span-4 { grid-template-cols: 1fr !important; display: block !important; }
    .mobile-mega-content .col-span-1 { display: none !important; }
    .mobile-mega-content .grid-cols-4 { grid-template-cols: 1fr !important; display: block !important; }
    .mobile-mega-content .space-y-4 { margin-bottom: 1rem; padding: 0.5rem; }
    .mobile-mega-content a { font-size: 13px !important; color: #1f2937 !important; }
    .mobile-mega-content ul { margin-top: 0.5rem !important; padding-left: 1rem !important; border-left: 1px solid #e5e7eb; }
    .mobile-mega-content ul li a { color: #6b7280 !important; font-weight: 500 !important; }
</style>

<script>
    function searchComponent() {
        return {
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
        }
    }
</script>

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
