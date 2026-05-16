<?php
/**
 * Theme Customizer Settings
 */
function miliwebseo_customize_register( $wp_customize ) {
    // Add Header Section
    $wp_customize->add_section( 'miliwebseo_header_settings', [
        'title'    => 'Cấu hình Header',
        'priority' => 30,
    ]);

    // Logo Width Setting
    $wp_customize->add_setting( 'logo_width', [
        'default'           => '246',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control( 'logo_width', [
        'label'    => 'Chiều rộng Logo (px)',
        'section'  => 'miliwebseo_header_settings',
        'type'     => 'number',
        'input_attrs' => ['min' => 100, 'max' => 500],
    ]);

    // Menu Height Setting
    $wp_customize->add_setting( 'menu_height', [
        'default'           => '50',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control( 'menu_height', [
        'label'    => 'Chiều cao Menu (px)',
        'section'  => 'miliwebseo_header_settings',
        'type'     => 'number',
        'input_attrs' => ['min' => 30, 'max' => 100],
    ]);

    // Dark Header Logo Setting
    $wp_customize->add_setting( 'dark_logo', [
        'default'   => '',
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'dark_logo', [
        'label'    => 'Logo cho Header (Nền tối)',
        'section'  => 'miliwebseo_header_settings',
        'description' => 'Upload phiên bản logo màu trắng hoặc sáng màu.',
    ]));
}
add_action( 'customize_register', 'miliwebseo_customize_register' );
