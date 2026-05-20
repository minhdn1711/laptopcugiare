<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* ────────────────────────────────────────────────────────────
           CRITICAL INLINE CSS - Only above-the-fold styles
           ─────────────────────────────────────────────────────────── */
        [x-cloak] { display: none !important; }
        
        /* Container & layout */
        .container {
            max-width: 1230px !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        
        /* Price styling (product pages) */
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
        
        /* Mega Menu Animations (Critical for UX) */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(10px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* Dynamic Customizer Settings (Critical for layout) */
        :root {
            --logo-width: <?php echo get_theme_mod('logo_width', '246'); ?>px;
            --menu-height: <?php echo get_theme_mod('menu_height', '50'); ?>px;
            --header-padding: 10px;
        }
    </style>
    
    <!-- PERFORMANCE: Reduce inline CSS, move non-critical to main.css -->
    <!-- Pagination, forms, checkout styles moved to dist/assets/style.css -->
    
    <?php if (is_front_page()): ?>
    <meta name="description" content="Laptop cũ giá rẻ uy tín - Mua laptop cũ, laptop gaming, workstation chất lượng cao tại Laptop Cũ Giá Rẻ. Giao hàng toàn quốc, bảo hành 12 tháng.">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-gray-100' ); ?> x-data="{ mobileMenuOpen: false }">
    <?php wp_body_open(); ?>

<header class="sticky top-0 z-[9999] bg-white shadow-sm">
    <!-- Top Bar -->
    <div class="bg-gray-900 text-white text-[11px] py-1.5 hidden md:block">
        <div class="container mx-auto px-4 flex justify-between items-center opacity-80">
            <div class="flex space-x-6">
                <span class="flex items-center gap-1.5 hover:text-primary cursor-pointer transition-colors"><?php echo miliwebseo_icon('map-pin', 'h-3.5 w-3.5'); ?> <?php echo get_theme_mod('header_top_store', 'Hệ thống 15 cửa hàng'); ?></span>
                <?php echo get_theme_mod('header_top_hotline', '<span class="flex items-center gap-1.5 hover:text-primary cursor-pointer transition-colors">' . miliwebseo_icon('phone', 'h-3.5 w-3.5') . ' Hotline: 1900.xxxx</span>'); ?>
            </div>
            <div class="flex space-x-6 font-medium header-top-links">
                <?php echo get_theme_mod('header_top_links_html', '<a href="#" class="hover:text-primary transition-colors">Góp ý / Khiếu nại</a>
<a href="#" class="hover:text-primary transition-colors">Tra cứu bảo hành</a>
<a href="#" class="hover:text-primary transition-colors">Tin công nghệ</a>'); ?>
            </div>
        </div>
    </div>

    <!-- Main Header (Desktop) -->
    <div class="hidden md:block bg-secondary text-white border-b border-white/5 transition-all duration-300" style="padding: var(--header-padding) 0;">
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
    <div class="hidden md:block bg-white border-b border-gray-100 shadow-sm sticky z-40" style="top: 80px; height: var(--menu-height);">
        <div class="container mx-auto px-4 flex items-center h-full">

            <?php
            /* ──────────────────────────────────────────────────────────
             * PRE-LOAD: Lấy toàn bộ cây danh mục 1 lần để render SSR
             * ─────────────────────────────────────────────────────── */
            $mega_l1 = get_terms([
                'taxonomy'   => 'product_cat',
                'parent'     => 0,
                'hide_empty' => false,
                'meta_key'   => 'order_index',
                'orderby'    => 'meta_value_num',
                'order'      => 'ASC',
                'meta_query' => [['key' => 'show_in_mega', 'value' => '1']],
            ]);
            // fallback nếu chưa set show_in_mega
            if (is_wp_error($mega_l1) || empty($mega_l1)) {
                $mega_l1 = get_terms([
                    'taxonomy'   => 'product_cat',
                    'parent'     => 0,
                    'hide_empty' => false,
                ]);
            }
            // Loại bỏ "Uncategorized"
            $mega_l1 = array_filter((array) $mega_l1, fn($c) => $c->slug !== 'uncategorized' && !is_wp_error($c));
            $mega_l1 = array_values($mega_l1);

            // Pre-load L2 + L3 ngay tại đây (tất cả SSR, zero AJAX)
            $mega_tree = [];
            foreach ($mega_l1 as $cat1) {
                $l2_list = get_terms(['taxonomy' => 'product_cat', 'parent' => $cat1->term_id, 'hide_empty' => false, 'orderby' => 'name']);
                $l2_list = is_wp_error($l2_list) ? [] : $l2_list;
                $brands_data = [];
                foreach ($l2_list as $brand) {
                    $l3_list = get_terms(['taxonomy' => 'product_cat', 'parent' => $brand->term_id, 'hide_empty' => false, 'orderby' => 'name']);
                    $brands_data[] = [
                        'brand'  => $brand,
                        'series' => is_wp_error($l3_list) ? [] : $l3_list,
                    ];
                }
                $mega_tree[] = ['cat' => $cat1, 'brands' => $brands_data];
            }
            ?>

            <!-- ===== MEGA MENU WRAPPER ===== -->
            <?php if (!empty($mega_tree)) : ?>
            <div class="relative h-full flex-shrink-0"
                 x-data="{ open: false, tab: null }"
                 @mouseenter="open = true"
                 @mouseleave="open = false; tab = null">

                <!-- Trigger Button -->
                <div class="bg-primary text-black h-full font-black text-[11px] flex items-center justify-center gap-2 cursor-pointer uppercase tracking-wider select-none px-4"
                     style="width: var(--logo-width);">
                    <?php echo miliwebseo_icon('menu', 'h-4 w-4'); ?>
                    DANH MỤC SẢN PHẨM
                </div>

                <!-- ── MEGA PANEL (full SSR, hiện ngay khi hover) ── -->
                <div x-show="open"
                     x-cloak
                     x-transition:enter="transition-opacity ease-out duration-100"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-in duration-75"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute top-full left-0 z-[300] flex bg-white border border-gray-200 rounded-b-lg overflow-hidden transition-all duration-300"
                     style="box-shadow: 0 8px 30px rgba(0,0,0,.12); background-color: #ffffff !important; opacity: 1 !important; z-index: 99999 !important;">

                    <!-- ── CỘT TRÁI: Danh mục cấp 1 ── -->
                    <div class="bg-secondary flex-shrink-0 overflow-y-auto" style="width: 220px; max-height: 460px; background-color: #1a1a1a !important; position: relative; z-index: 999999 !important;">
                        <?php foreach ($mega_tree as $idx => $node) :
                            $cat1     = $node['cat'];
                            $title    = get_term_meta($cat1->term_id, 'menu_title', true) ?: $cat1->name;
                            $icon_val = get_term_meta($cat1->term_id, 'icon', true);
                            $icon_url = $icon_val ? (strpos($icon_val, 'http') === 0 ? $icon_val : get_template_directory_uri() . '/assets/images/' . $icon_val) : '';
                        ?>
                        <div @mouseenter="tab = <?php echo $idx; ?>"
                             :class="tab === <?php echo $idx; ?> ? 'bg-primary' : 'hover:bg-white/10'"
                             class="border-b border-white/[.08] transition-colors duration-100 cursor-pointer">
                            <a href="<?php echo esc_url(get_term_link($cat1)); ?>"
                               :class="tab === <?php echo $idx; ?> ? 'text-black' : 'text-white'"
                               class="flex items-center justify-between px-4 py-[11px] text-[12px] font-bold gap-2 transition-colors"
                               @click.stop>
                                 <span class="flex items-center gap-2.5 min-w-0 truncate">
                                     <?php if ($icon_url) : ?>
                                     <img src="<?php echo esc_url($icon_url); ?>" alt="" class="w-4 h-4 flex-shrink-0" onerror="this.remove()">
                                     <?php endif; ?>
                                     <span class="truncate uppercase tracking-wide"><?php echo esc_html($title); ?></span>
                                 </span>
                                <svg class="w-3 h-3 flex-shrink-0 opacity-40" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- ── CỘT PHẢI: Brands + Series theo tab ── -->
                    <?php foreach ($mega_tree as $idx => $node) : ?>
                    <div x-show="tab === <?php echo $idx; ?>"
                         class="bg-white overflow-y-auto p-6"
                         style="width: 760px; max-height: 460px; background-color: #ffffff !important; position: relative; z-index: 999999 !important;">
                        <?php if (empty($node['brands'])) : ?>
                        <p class="text-gray-400 text-sm italic py-8 text-center">Đang cập nhật danh mục...</p>
                        <?php else : ?>

                        <?php
                        // Tính số cột phù hợp: 4 brands → 4 cols, ít hơn thì bớt
                        $brand_count = count($node['brands']);
                        $cols = $brand_count >= 4 ? 4 : max(2, $brand_count);
                        ?>
                        <div class="grid gap-x-6 gap-y-5" style="grid-template-columns: repeat(<?php echo $cols; ?>, minmax(0,1fr));">
                            <?php foreach ($node['brands'] as $item) :
                                $brand = $item['brand'];
                            ?>
                            <div>
                                <!-- Brand (L2) -->
                                <a href="<?php echo esc_url(get_term_link($brand)); ?>"
                                   class="block font-extrabold text-secondary hover:text-primary text-[12px] uppercase tracking-wide pb-1.5 mb-2 border-b border-gray-100 transition-colors leading-tight">
                                    <?php echo esc_html($brand->name); ?>
                                    <span class="font-normal text-gray-400 text-[10px] normal-case">(<?php echo $brand->count; ?>)</span>
                                </a>
                                <!-- Series (L3) -->
                                <?php if (!empty($item['series'])) : ?>
                                <ul class="space-y-1.5">
                                    <?php foreach ($item['series'] as $s) : ?>
                                    <li>
                                        <a href="<?php echo esc_url(get_term_link($s)); ?>"
                                           class="flex items-center gap-1.5 text-[11px] text-gray-500 hover:text-primary transition-colors group leading-tight">
                                            <span class="w-[5px] h-[5px] rounded-full bg-gray-300 flex-shrink-0 group-hover:bg-primary transition-colors"></span>
                                            <?php echo esc_html($s->name); ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Xem tất cả link -->
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <a href="<?php echo esc_url(get_term_link($node['cat'])); ?>"
                               class="inline-flex items-center gap-1.5 text-[11px] font-bold text-primary hover:underline">
                                Xem tất cả <?php echo esc_html(get_term_meta($node['cat']->term_id, 'menu_title', true) ?: $node['cat']->name); ?>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>

                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>

                </div>
                <!-- ── END MEGA PANEL ── -->

            </div>
            <?php endif; ?>

            <!-- Horizontal Navigation -->
            <nav class="flex items-center h-full ml-8 space-x-8">
                <?php miliwebseo_render_primary_menu(); ?>
            </nav>

            <!-- Right: badge -->
            <div class="ml-auto flex items-center gap-4">
                <span class="text-xs font-bold text-secondary flex items-center gap-1.5">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse inline-block"></span>
                    250+ Laptop sẵn hàng
                </span>
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
                                         <?php 
                                         $icon = get_term_meta($cat->term_id, 'icon', true);
                                         if ($icon) : 
                                             $icon_url = (strpos($icon, 'http') === 0 ? $icon : get_template_directory_uri() . '/assets/images/' . $icon);
                                         ?>
                                         <img src="<?php echo esc_url($icon_url); ?>" class="w-5 h-5 opacity-60" onerror="this.remove()">
                                         <?php endif; ?>
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

    /* === Mobile Pagination - Better UX/UI === */
    @media (max-width: 640px) {
        nav.woocommerce-pagination ul,
        .pagination-list,
        .page-numbers {
            gap: 8px !important;
            flex-wrap: wrap;
            justify-content: center;
        }

        nav.woocommerce-pagination ul li a,
        nav.woocommerce-pagination ul li span,
        .page-numbers li a,
        .page-numbers li span {
            min-width: 42px !important;
            height: 42px !important;
            font-size: 15px !important;
            padding: 0 12px !important;
            border-radius: 10px !important;
            font-weight: 600 !important;
        }

        .page-numbers .prev,
        .page-numbers .next {
            font-size: 16px !important;
            background: #f3f4f6 !important;
        }
    }

    /* === Force Checkout Page Width Fix === */
    .woocommerce-checkout {
        overflow-x: hidden !important;
    }
    .woocommerce-checkout,
    .woocommerce-checkout .container,
    .woocommerce-checkout .bg-gray-50 {
        width: 100% !important;
    }

    /* Hide default WordPress page header on checkout & cart */
    .woocommerce-checkout .entry-header,
    .woocommerce-checkout article > header.entry-header,
    .woocommerce-cart .entry-header,
    .woocommerce-cart article > header.entry-header {
        display: none !important;
    }

    /* Remove padding from article on checkout & cart */
    .woocommerce-checkout article,
    .woocommerce-cart article {
        padding: 0 !important;
        background: transparent !important;
        box-shadow: none !important;
        border-radius: 0 !important;
    }

    /* Pull breadcrumb outside article on checkout & cart */
    .woocommerce-checkout .entry-content > .woocommerce > .bg-gray-50:first-child,
    .woocommerce-cart .entry-content > .woocommerce > .bg-gray-50:first-child {
        margin-top: -70px;
        position: relative;
        z-index: 20;
    }
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
    <?php else : ?>
    <a href="#" class="flex flex-col items-center text-gray-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <span class="text-[10px] mt-1 font-medium">Giỏ hàng</span>
    </a>
    <?php endif; ?>
</div>

<script>
    // Sticky Header Scroll Effect
    window.addEventListener('scroll', function() {
        const header = document.querySelector('header');
        if (window.scrollY > 100) {
            header.classList.add('shadow-xl');
            document.documentElement.style.setProperty('--header-padding', '5px');
        } else {
            header.classList.remove('shadow-xl');
            document.documentElement.style.setProperty('--header-padding', '10px');
        }
    });
</script>
