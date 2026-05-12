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
