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
 * Render Vertical Menu (Flatsome Style)
 */
function miliwebseo_render_vertical_menu() {
    $menu_name = 'vertical';
    $locations = get_nav_menu_locations();
    
    // Fallback: If no menu assigned, show product categories
    if ( ! isset( $locations[ $menu_name ] ) ) {
        $categories = get_terms( 'product_cat', array( 'hide_empty' => false, 'parent' => 0 ) );
        if ( empty( $categories ) ) return false;
        
        echo '<ul class="divide-y divide-gray-100">';
        foreach ( $categories as $cat ) {
            echo '<li><a href="' . esc_url( get_term_link( $cat ) ) . '" class="block px-4 py-3 hover:bg-gray-50 hover:text-primary transition-colors flex items-center justify-between group">';
            echo esc_html( $cat->name ) . ' <span class="text-gray-300 group-hover:text-primary">' . miliwebseo_icon('chevron-right', 'h-3 w-3') . '</span>';
            echo '</a></li>';
        }
        echo '</ul>';
        return true;
    }

    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
    $menu_items = wp_get_nav_menu_items( $menu->term_id );

    if ( empty( $menu_items ) ) return false;

    echo '<ul class="divide-y divide-gray-100">';
    foreach ( $menu_items as $item ) {
        if ( ! $item->menu_item_parent ) {
            echo '<li><a href="' . esc_url( $item->url ) . '" class="block px-4 py-3 hover:bg-gray-50 hover:text-primary transition-colors flex items-center justify-between group">';
            echo '<span class="flex items-center gap-3">' . esc_html( $item->title ) . '</span>';
            echo '<span class="text-gray-300 group-hover:text-primary">' . miliwebseo_icon('chevron-right', 'h-3 w-3') . '</span>';
            echo '</a></li>';
        }
    }
    echo '</ul>';
    return true;
}
