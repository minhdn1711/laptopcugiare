<?php
/**
 * Flash Sale Settings and Logic
 */

// Register Customizer Settings
add_action( 'customize_register', function( $wp_customize ) {
    $wp_customize->add_section( 'miliwebseo_flash_sale', array(
        'title'    => __( 'Flash Sale Settings', 'miliwebseo' ),
        'priority' => 30,
    ) );

    // End Date Time
    $wp_customize->add_setting( 'flash_sale_end_time', array(
        'default'   => date('Y-m-d H:i:s', strtotime('+5 hours')),
        'transport' => 'refresh',
    ) );
    $wp_customize->add_control( 'flash_sale_end_time', array(
        'label'    => __( 'Flash Sale End Time (YYYY-MM-DD HH:MM:SS)', 'miliwebseo' ),
        'section'  => 'miliwebseo_flash_sale',
        'type'     => 'text',
        'description' => 'Ví dụ: 2026-05-20 23:59:59',
    ) );

    // Category Filter
    $wp_customize->add_setting( 'flash_sale_category', array(
        'default'   => '',
        'transport' => 'refresh',
    ) );
    
    $categories = get_terms( 'product_cat', array( 'hide_empty' => false ) );
    $cat_options = array( '' => 'Tất cả sản phẩm đang giảm giá' );
    foreach ( $categories as $cat ) {
        $cat_options[$cat->slug] = $cat->name;
    }

    $wp_customize->add_control( 'flash_sale_category', array(
        'label'    => __( 'Category for Flash Sale', 'miliwebseo' ),
        'section'  => 'miliwebseo_flash_sale',
        'type'     => 'select',
        'choices'  => $cat_options,
    ) );
    // --- Hero Banners Section ---
    $wp_customize->add_section( 'miliwebseo_hero_banners', array(
        'title'    => __( 'Hero Banners (Trang chủ)', 'miliwebseo' ),
        'priority' => 20,
    ) );

    for ( $i = 1; $i <= 5; $i++ ) {
        // Image
        $wp_customize->add_setting( "hero_banner_{$i}", [
            'default'   => '',
            'transport' => 'refresh',
        ]);
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "hero_banner_{$i}", [
            'label'    => __( "Banner {$i} - Ảnh", 'miliwebseo' ),
            'section'  => 'miliwebseo_hero_banners',
        ]));

        // Title
        $wp_customize->add_setting( "hero_banner_title_{$i}", [
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control( "hero_banner_title_{$i}", [
            'label'   => __( "Banner {$i} - Tiêu đề", 'miliwebseo' ),
            'section' => 'miliwebseo_hero_banners',
            'type'    => 'text',
        ]);

        // Subtitle
        $wp_customize->add_setting( "hero_banner_subtitle_{$i}", [
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control( "hero_banner_subtitle_{$i}", [
            'label'   => __( "Banner {$i} - Phụ đề", 'miliwebseo' ),
            'section' => 'miliwebseo_hero_banners',
            'type'    => 'text',
        ]);

        // Button text
        $wp_customize->add_setting( "hero_banner_btn_text_{$i}", [
            'default' => 'MUA NGAY',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control( "hero_banner_btn_text_{$i}", [
            'label'   => __( "Banner {$i} - Text nút", 'miliwebseo' ),
            'section' => 'miliwebseo_hero_banners',
            'type'    => 'text',
        ]);

        // Link
        $wp_customize->add_setting( "hero_banner_link_{$i}", [
            'default'   => '#',
            'transport' => 'refresh',
        ]);
        $wp_customize->add_control( "hero_banner_link_{$i}", [
            'label'    => __( "Banner {$i} - Link", 'miliwebseo' ),
            'section'  => 'miliwebseo_hero_banners',
            'type'     => 'url',
        ]);
    }
} );

/**
 * Get Flash Sale End Time for JS
 */
function miliwebseo_get_flash_sale_time() {
    return get_theme_mod( 'flash_sale_end_time', date('Y-m-d H:i:s', strtotime('+5 hours')) );
}

/**
 * Get Hero Banners
 */
function miliwebseo_get_hero_banners() {
    $banners = [];
    for ( $i = 1; $i <= 5; $i++ ) {
        $img = get_theme_mod( "hero_banner_{$i}" );
        if ( $img ) {
            $banners[] = [
                'image'     => $img,
                'title'     => get_theme_mod( "hero_banner_title_{$i}", '' ),
                'subtitle'  => get_theme_mod( "hero_banner_subtitle_{$i}", '' ),
                'btn_text'  => get_theme_mod( "hero_banner_btn_text_{$i}", 'MUA NGAY' ),
                'link'      => get_theme_mod( "hero_banner_link_{$i}", '#' ),
            ];
        }
    }
    return $banners;
}

/**
 * Get Flash Sale Query Args
 */
function miliwebseo_get_flash_sale_args() {
    $cat = get_theme_mod( 'flash_sale_category', '' );
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 5,
        'meta_query'     => array(
            array(
                'key'     => '_sale_price',
                'value'   => 0,
                'compare' => '>',
                'type'    => 'NUMERIC',
            ),
        ),
    );

    if ( ! empty( $cat ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $cat,
            ),
        );
    }

    return $args;
}
