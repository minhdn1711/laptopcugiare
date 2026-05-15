<?php
/**
 * Helper functions
 */
function miliwebseo_get_svg( $icon ) {
    // Helper to load SVG icons
}

function miliwebseo_render_mega_menu() {
    $menu_name = 'mega_menu';
    $locations = get_nav_menu_locations();
    
    if ( ! isset( $locations[ $menu_name ] ) ) {
        return false;
    }

    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
    $menu_items = wp_get_nav_menu_items( $menu->term_id );

    if ( empty( $menu_items ) ) return false;

    $menu_tree = array();
    foreach ( $menu_items as $item ) {
        if ( ! $item->menu_item_parent ) {
            $menu_tree[ $item->ID ] = array(
                'title' => $item->title,
                'url'   => $item->url,
                'children' => array()
            );
        } else {
            if ( isset( $menu_tree[ $item->menu_item_parent ] ) ) {
                $menu_tree[ $item->menu_item_parent ]['children'][] = array(
                    'title' => $item->title,
                    'url'   => $item->url
                );
            }
        }
    }

    foreach ( $menu_tree as $id => $column ) : ?>
        <div>
            <h3 class="font-bold border-b pb-2 mb-3 text-secondary uppercase text-xs"><?php echo esc_html( $column['title'] ); ?></h3>
            <ul class="space-y-2 text-sm">
                <?php foreach ( $column['children'] as $child ) : ?>
                    <li><a href="<?php echo esc_url( $child['url'] ); ?>" class="hover:text-primary transition-colors"><?php echo esc_html( $child['title'] ); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach;
    return true;
}

/**
 * Render Header Mega Menu (Side-Flyout Style)
 * Supports up to 3 levels: Level 1 (Sidebar), Level 2 (Column Headers), Level 3 (Links)
 */
function miliwebseo_render_header_mega_menu() {
    $menu_name = 'vertical';
    $locations = get_nav_menu_locations();
    
    if ( ! isset( $locations[ $menu_name ] ) ) {
        // Simple fallback to categories if no menu is assigned
        $categories = get_terms( 'product_cat', array( 'hide_empty' => false, 'parent' => 0 ) );
        if ( empty( $categories ) ) {
            echo '<div class="p-4 text-xs text-gray-400 italic">Chưa có danh mục nào.</div>';
            return false;
        }
        echo '<ul class="w-[240px] divide-y divide-gray-100">';
        foreach ( $categories as $cat ) {
            echo '<li><a href="' . esc_url( get_term_link( $cat ) ) . '" class="block px-4 py-3 hover:bg-gray-50 hover:text-primary transition-colors font-bold text-sm">';
            echo esc_html( $cat->name ) . '</a></li>';
        }
        echo '</ul>';
        return true;
    }

    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
    $menu_items = wp_get_nav_menu_items( $menu->term_id );

    if ( empty( $menu_items ) ) return false;

    // Build 3-level tree
    $menu_tree = array();
    $items_by_id = array();
    foreach ( $menu_items as $item ) {
        $item->children = array();
        $items_by_id[$item->ID] = $item;
    }

    foreach ( $menu_items as $item ) {
        if ( ! $item->menu_item_parent ) {
            $menu_tree[] = $item;
        } else {
            if ( isset( $items_by_id[$item->menu_item_parent] ) ) {
                $items_by_id[$item->menu_item_parent]->children[] = $item;
            }
        }
    }

    // Render HTML with Alpine logic for side-flyout
    echo '<div class="flex bg-white min-h-[450px]" x-data="{ activeCategory: ' . ($menu_tree ? $menu_tree[0]->ID : 0) . ' }">';
    
    // Left Sidebar (Level 1)
    echo '<div class="w-[260px] border-r border-gray-100 py-1 bg-white flex-shrink-0">';
    echo '<ul class="flex flex-col h-full">';
    foreach ( $menu_tree as $item ) {
        $has_children = ! empty( $item->children );
        echo '<li @mouseenter="activeCategory = ' . $item->ID . '" class="group/item">';
        echo '<a href="' . esc_url( $item->url ) . '" :class="activeCategory == ' . $item->ID . ' ? \'bg-primary text-black\' : \'text-gray-700 hover:bg-gray-50\'" class="flex items-center justify-between px-5 py-3.5 transition-all font-bold text-[13px] uppercase tracking-tight border-b border-gray-50">';
        echo '<span class="flex items-center gap-3">' . esc_html( $item->title ) . '</span>';
        if ( $has_children ) {
            echo miliwebseo_icon('chevron-right', 'h-3.5 w-3.5 opacity-50');
        }
        echo '</a>';
        echo '</li>';
    }
    echo '</ul>';
    echo '</div>';

    // Right Content (Level 2 & 3)
    echo '<div class="flex-grow p-8 bg-gray-50/50 relative overflow-hidden">';
    foreach ( $menu_tree as $item ) {
        if ( ! empty( $item->children ) ) {
            echo '<div x-show="activeCategory == ' . $item->ID . '" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="grid grid-cols-3 gap-10">';
            foreach ( $item->children as $column ) {
                echo '<div>';
                echo '<h4 class="font-black text-secondary uppercase text-[12px] tracking-widest border-b-2 border-primary w-fit pb-1 mb-5">' . esc_html( $column->title ) . '</h4>';
                if ( ! empty( $column->children ) ) {
                    echo '<ul class="space-y-2.5">';
                    foreach ( $column->children as $sub_item ) {
                        echo '<li><a href="' . esc_url( $sub_item->url ) . '" class="text-[13px] text-gray-600 hover:text-primary transition-colors font-semibold flex items-center gap-2 group/link">';
                        echo '<span class="w-1 h-1 bg-gray-300 rounded-full group-hover/link:bg-primary group-hover/link:scale-150 transition-all"></span>';
                        echo esc_html( $sub_item->title );
                        echo '</a></li>';
                    }
                    echo '</ul>';
                }
                echo '</div>';
            }
            echo '</div>';
        } else {
            // If Level 1 item has no children, we can show a placeholder or nothing
            echo '<div x-show="activeCategory == ' . $item->ID . '" x-cloak class="flex flex-col items-center justify-center h-full text-center space-y-4 opacity-20">';
                 echo miliwebseo_icon('package', 'h-20 w-20 text-gray-400');
                 echo '<p class="text-sm font-bold uppercase tracking-widest text-gray-400">Danh mục này hiện chưa có tiểu mục</p>';
            echo '</div>';
        }
    }
    // Decorative background icon
    echo '<div class="absolute bottom-[-20px] right-[-20px] opacity-[0.03] rotate-12 pointer-events-none">' . miliwebseo_icon('cpu', 'h-64 w-64') . '</div>';
    echo '</div>';
    
    echo '</div>';
}

/**
 * Original Vertical Menu (used in Sidebar)
 */
function miliwebseo_render_vertical_menu() {
    // Keep this for the front-page sidebar as a simpler list
    $menu_name = 'vertical';
    $locations = get_nav_menu_locations();
    
    if ( ! isset( $locations[ $menu_name ] ) ) {
        $categories = get_terms( 'product_cat', array( 'hide_empty' => false, 'parent' => 0 ) );
        if ( empty( $categories ) ) {
            echo '<div class="p-4 text-xs text-gray-400 italic">Chưa có danh mục sản phẩm nào.</div>';
            return false;
        }
        
        echo '<ul class="divide-y divide-gray-100">';
        foreach ( $categories as $cat ) {
            echo '<li><a href="' . esc_url( get_term_link( $cat ) ) . '" class="block px-4 py-3 hover:bg-gray-50 hover:text-primary transition-colors flex items-center justify-between group">';
            echo '<span class="font-bold text-sm text-secondary">' . esc_html( $cat->name ) . '</span> <span class="text-gray-300 group-hover:text-primary">' . miliwebseo_icon('chevron-right', 'h-3 w-3') . '</span>';
            echo '</a></li>';
        }
        echo '</ul>';
        return true;
    }

    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
    if ( ! $menu ) return false;

    $menu_items = wp_get_nav_menu_items( $menu->term_id );
    if ( empty( $menu_items ) ) return false;

    echo '<ul class="divide-y divide-gray-100">';
    foreach ( $menu_items as $item ) {
        if ( ! $item->menu_item_parent ) {
            echo '<li><a href="' . esc_url( $item->url ) . '" class="block px-4 py-3 hover:bg-gray-50 hover:text-primary transition-colors flex items-center justify-between group">';
            echo '<span class="font-bold text-sm text-secondary">' . esc_html( $item->title ) . '</span>';
            echo '<span class="text-gray-300 group-hover:text-primary">' . miliwebseo_icon('chevron-right', 'h-3 w-3') . '</span>';
            echo '</a></li>';
        }
    }
    echo '</ul>';
    return true;
}
/**
 * Render Primary Menu (Top Navigation)
 */
function miliwebseo_render_primary_menu() {
    $menu_name = 'primary';
    $locations = get_nav_menu_locations();
    
    if ( ! isset( $locations[ $menu_name ] ) ) {
        // Fallback to hardcoded menu if no menu assigned
        ?>
        <a href="<?php echo home_url(); ?>" class="hover:text-primary transition-colors flex items-center gap-2"><?php echo miliwebseo_icon('home', 'h-4 w-4 text-primary'); ?> Trang chủ</a>
        <a href="#" class="hover:text-primary transition-colors">Sản phẩm mới</a>
        <a href="#" class="hover:text-primary transition-colors flex items-center gap-2"><?php echo miliwebseo_icon('flame', 'h-4 w-4 text-orange-500'); ?> Khuyến mãi</a>
        <a href="#" class="hover:text-primary transition-colors">Tin tức</a>
        <a href="#" class="hover:text-primary transition-colors">Liên hệ</a>
        <?php
        return;
    }

    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
    if ( ! $menu ) return;

    $menu_items = wp_get_nav_menu_items( $menu->term_id );
    if ( empty( $menu_items ) ) return;

    foreach ( $menu_items as $item ) {
        $classes = 'hover:text-primary transition-colors flex items-center gap-2';
        $icon = '';

        // Simple logic to add icons based on menu title or custom classes
        // In a real scenario, you might use a custom field or specific CSS class
        $title_lower = mb_strtolower($item->title);
        if (strpos($title_lower, 'trang chủ') !== false) {
            $icon = miliwebseo_icon('home', 'h-4 w-4 text-primary');
        } elseif (strpos($title_lower, 'khuyến mãi') !== false || strpos($title_lower, 'hot') !== false) {
            $icon = miliwebseo_icon('flame', 'h-4 w-4 text-orange-500');
        } elseif (strpos($title_lower, 'tin tức') !== false || strpos($title_lower, 'blog') !== false) {
            $icon = miliwebseo_icon('book-open', 'h-4 w-4 text-blue-500');
        } elseif (strpos($title_lower, 'liên hệ') !== false) {
            $icon = miliwebseo_icon('phone', 'h-4 w-4 text-green-500');
        }

        echo '<a href="' . esc_url( $item->url ) . '" class="' . esc_attr( $classes ) . '">';
        if ($icon) echo $icon . ' ';
        echo esc_html( $item->title );
        echo '</a>';
    }
}

/**
 * Render Mobile Menu Links
 */
function miliwebseo_render_mobile_menu() {
    $menu_name = 'mobile';
    $locations = get_nav_menu_locations();
    
    if ( ! isset( $locations[ $menu_name ] ) ) {
        // Fallback to hardcoded menu if no menu assigned
        ?>
        <a href="<?php echo home_url(); ?>" class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl font-bold text-secondary">
            <?php echo miliwebseo_icon('home', 'h-5 w-5 text-primary'); ?> Trang chủ
        </a>
        <a href="#" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-xl font-bold text-secondary transition-all">
            <?php echo miliwebseo_icon('flame', 'h-5 w-5 text-orange-500'); ?> Khuyến mãi hot
        </a>
        <?php
        return;
    }

    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
    if ( ! $menu ) return;

    $menu_items = wp_get_nav_menu_items( $menu->term_id );
    if ( empty( $menu_items ) ) return;

    foreach ( $menu_items as $item ) {
        $icon = miliwebseo_icon('chevron-right', 'h-5 w-5 text-gray-400');
        $title_lower = mb_strtolower($item->title);
        if (strpos($title_lower, 'trang chủ') !== false) {
            $icon = miliwebseo_icon('home', 'h-5 w-5 text-primary');
        } elseif (strpos($title_lower, 'khuyến mãi') !== false || strpos($title_lower, 'hot') !== false) {
            $icon = miliwebseo_icon('flame', 'h-5 w-5 text-orange-500');
        }

        echo '<a href="' . esc_url( $item->url ) . '" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-xl font-bold text-secondary transition-all">';
        echo $icon . ' ' . esc_html( $item->title );
        echo '</a>';
    }
}

