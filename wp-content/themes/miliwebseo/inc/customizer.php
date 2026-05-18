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

    // ===== HEADER TOP BAR =====
    $wp_customize->add_section( 'miliwebseo_header_top', [
        'title'    => 'Header Top Bar',
        'section'  => 'miliwebseo_header_settings',
        'priority' => 10,
    ]);

    $wp_customize->add_setting( 'header_top_store', [ 'default' => 'Hệ thống 15 cửa hàng', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'header_top_store', [
        'label'   => 'Text cửa hàng',
        'section' => 'miliwebseo_header_top',
    ]);

    $wp_customize->add_setting( 'header_top_hotline', [
        'default'           => '<span class="flex items-center gap-1.5 hover:text-primary cursor-pointer transition-colors"><svg>...</svg> Hotline: 1900.xxxx</span>',
        'sanitize_callback' => 'miliwebseo_sanitize_html_with_svg',
    ]);
    $wp_customize->add_control( 'header_top_hotline', [
        'label'       => 'Hotline (HTML)',
        'type'        => 'textarea',
        'section'     => 'miliwebseo_header_top',
        'description' => 'Nhập HTML cho phần hotline (có thể thêm icon)',
    ]);

    $wp_customize->add_setting( 'header_top_links_html', [
        'default'           => '<a href="#" class="hover:text-primary transition-colors">Góp ý / Khiếu nại</a>
<a href="#" class="hover:text-primary transition-colors">Tra cứu bảo hành</a>
<a href="#" class="hover:text-primary transition-colors">Tin công nghệ</a>',
        'sanitize_callback' => 'miliwebseo_sanitize_html_with_svg',
    ]);
    $wp_customize->add_control( 'header_top_links_html', [
        'label'       => 'HTML Links (bên phải)',
        'type'        => 'textarea',
        'section'     => 'miliwebseo_header_top',
        'description' => 'Bạn có thể paste HTML <a> tags ở đây',
    ]);

    // ===== FOOTER =====
    $wp_customize->add_section( 'miliwebseo_footer', [
        'title'    => 'Footer',
        'priority' => 40,
    ]);

    $wp_customize->add_setting( 'footer_about', [
        'default'           => 'Hệ thống bán lẻ laptop uy tín hàng đầu.',
        'sanitize_callback' => 'wp_kses_post',
    ]);
    $wp_customize->add_control( 'footer_about', [
        'label'   => 'Mô tả công ty',
        'type'    => 'textarea',
        'section' => 'miliwebseo_footer',
    ]);

    $wp_customize->add_setting( 'footer_support_html', [
        'default' => '<ul class="space-y-2 text-sm">
<li><a href="#" class="hover:text-primary">Hướng dẫn mua hàng online</a></li>
<li><a href="#" class="hover:text-primary">Chính sách bảo hành</a></li>
<li><a href="#" class="hover:text-primary">Chính sách đổi trả</a></li>
<li><a href="#" class="hover:text-primary">Chính sách vận chuyển</a></li>
<li><a href="#" class="hover:text-primary">Hướng dẫn thanh toán</a></li>
</ul>',
        'sanitize_callback' => 'miliwebseo_sanitize_html_with_svg',
    ]);
    $wp_customize->add_control( 'footer_support_html', [
        'label'       => 'Cột Hỗ trợ khách hàng (HTML)',
        'type'        => 'textarea',
        'section'     => 'miliwebseo_footer',
    ]);

    $wp_customize->add_setting( 'footer_categories_html', [
        'default' => '<ul class="space-y-2 text-sm">
<li><a href="#" class="hover:text-primary">Laptop Gaming</a></li>
<li><a href="#" class="hover:text-primary">Laptop Văn Phòng</a></li>
<li><a href="#" class="hover:text-primary">Macbook Air / Pro</a></li>
<li><a href="#" class="hover:text-primary">Laptop Cũ Giá Rẻ</a></li>
</ul>',
        'sanitize_callback' => 'miliwebseo_sanitize_html_with_svg',
    ]);
    $wp_customize->add_control( 'footer_categories_html', [
        'label'       => 'Cột Danh mục phổ biến (HTML)',
        'type'        => 'textarea',
        'section'     => 'miliwebseo_footer',
    ]);

    $wp_customize->add_setting( 'footer_contact_html', [
        'default' => '<ul class="space-y-4 text-sm">
<li class="flex items-start gap-3">
<span class="text-primary mt-0.5">📍</span>
<span>Địa chỉ: 123 Đường ABC, Quận XYZ, TP. HCM</span>
</li>
<li class="flex items-center gap-3">
<span class="text-primary">☎</span>
<span>Hotline: 1900.xxxx</span>
</li>
<li class="flex items-center gap-3">
<span class="text-primary">✉</span>
<span>Email: contact@miliweb.vn</span>
</li>
</ul>',
        'sanitize_callback' => 'miliwebseo_sanitize_html_with_svg',
    ]);
    $wp_customize->add_control( 'footer_contact_html', [
        'label'       => 'Cột Liên hệ (HTML)',
        'type'        => 'textarea',
        'section'     => 'miliwebseo_footer',
    ]);
}
add_action( 'customize_register', 'miliwebseo_customize_register' );
