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

    // ===== UX BUILDER INFO BOXES =====
    $wp_customize->add_section( 'miliwebseo_info_boxes', [
        'title'    => 'Info Boxes (UX Builder)',
        'priority' => 35,
    ]);

    $wp_customize->add_setting( 'info_boxes_columns', [
        'default'           => '4',
        'sanitize_callback' => 'absint',
    ]);
    $wp_customize->add_control( 'info_boxes_columns', [
        'label'   => 'Số cột',
        'section' => 'miliwebseo_info_boxes',
        'type'    => 'select',
        'choices' => [
            '2' => '2 cột',
            '3' => '3 cột',
            '4' => '4 cột',
        ],
    ]);

    // Box 1
    $wp_customize->add_setting( 'info_box_1_title', [ 'default' => 'Miễn phí giao hàng', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'info_box_1_title', [ 'label' => 'Box 1 - Tiêu đề', 'section' => 'miliwebseo_info_boxes' ] );

    $wp_customize->add_setting( 'info_box_1_desc', [ 'default' => 'Đơn hàng từ 10 Triệu', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'info_box_1_desc', [ 'label' => 'Box 1 - Mô tả', 'section' => 'miliwebseo_info_boxes' ] );

    // Box 2
    $wp_customize->add_setting( 'info_box_2_title', [ 'default' => 'Bảo hành 12 tháng', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'info_box_2_title', [ 'label' => 'Box 2 - Tiêu đề', 'section' => 'miliwebseo_info_boxes' ] );

    $wp_customize->add_setting( 'info_box_2_desc', [ 'default' => 'Lỗi là đổi mới ngay', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'info_box_2_desc', [ 'label' => 'Box 2 - Mô tả', 'section' => 'miliwebseo_info_boxes' ] );

    // Box 3
    $wp_customize->add_setting( 'info_box_3_title', [ 'default' => '7 Ngày đổi trả', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'info_box_3_title', [ 'label' => 'Box 3 - Tiêu đề', 'section' => 'miliwebseo_info_boxes' ] );

    $wp_customize->add_setting( 'info_box_3_desc', [ 'default' => 'Hoàn tiền 100%', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'info_box_3_desc', [ 'label' => 'Box 3 - Mô tả', 'section' => 'miliwebseo_info_boxes' ] );

    // Box 4
    $wp_customize->add_setting( 'info_box_4_title', [ 'default' => 'Hỗ trợ 24/7', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'info_box_4_title', [ 'label' => 'Box 4 - Tiêu đề', 'section' => 'miliwebseo_info_boxes' ] );

    $wp_customize->add_setting( 'info_box_4_desc', [ 'default' => 'Zalo / Facebook', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'info_box_4_desc', [ 'label' => 'Box 4 - Mô tả', 'section' => 'miliwebseo_info_boxes' ] );

    // ===== MIDDLE BANNERS =====
    $wp_customize->add_section( 'miliwebseo_middle_banners', [
        'title'    => 'Banner Quảng cáo giữa trang',
        'priority' => 36,
    ]);

    // Banner 1
    $wp_customize->add_setting( 'middle_banner_1_image', [ 'default' => '', 'transport' => 'refresh' ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'middle_banner_1_image', [
        'label'    => 'Banner 1 - Ảnh',
        'section'  => 'miliwebseo_middle_banners',
    ]));

    $wp_customize->add_setting( 'middle_banner_1_link', [ 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ] );
    $wp_customize->add_control( 'middle_banner_1_link', [ 'label' => 'Banner 1 - Link', 'section' => 'miliwebseo_middle_banners' ] );

    $wp_customize->add_setting( 'middle_banner_1_title', [ 'default' => 'MÁY VĂN PHÒNG GIÁ SIÊU RẺ', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'middle_banner_1_title', [ 'label' => 'Banner 1 - Tiêu đề', 'section' => 'miliwebseo_middle_banners' ] );

    $wp_customize->add_setting( 'middle_banner_1_subtitle', [ 'default' => 'Dành cho sinh viên', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'middle_banner_1_subtitle', [ 'label' => 'Banner 1 - Phụ đề', 'section' => 'miliwebseo_middle_banners' ] );

    // Banner 2
    $wp_customize->add_setting( 'middle_banner_2_image', [ 'default' => '', 'transport' => 'refresh' ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'middle_banner_2_image', [
        'label'    => 'Banner 2 - Ảnh',
        'section'  => 'miliwebseo_middle_banners',
    ]));

    $wp_customize->add_setting( 'middle_banner_2_link', [ 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ] );
    $wp_customize->add_control( 'middle_banner_2_link', [ 'label' => 'Banner 2 - Link', 'section' => 'miliwebseo_middle_banners' ] );

    $wp_customize->add_setting( 'middle_banner_2_title', [ 'default' => 'WORKSTATION CHUYÊN NGHIỆP', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'middle_banner_2_title', [ 'label' => 'Banner 2 - Tiêu đề', 'section' => 'miliwebseo_middle_banners' ] );

    $wp_customize->add_setting( 'middle_banner_2_subtitle', [ 'default' => 'Cấu hình khủng', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'middle_banner_2_subtitle', [ 'label' => 'Banner 2 - Phụ đề', 'section' => 'miliwebseo_middle_banners' ] );

    // ===== FLOATING CONTACT BUTTONS & BACK TO TOP =====
    $wp_customize->add_section( 'miliwebseo_floating_buttons', [
        'title'    => 'Nút liên hệ & Cuộn lên đầu',
        'priority' => 45,
    ]);

    // Enable Hotline button
    $wp_customize->add_setting( 'floating_phone', [
        'default'           => '0393970681',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control( 'floating_phone', [
        'label'       => 'Số Hotline gọi nhanh',
        'section'     => 'miliwebseo_floating_buttons',
        'type'        => 'text',
        'description' => 'Nhập số điện thoại (để trống để ẩn nút gọi)',
    ]);

    // Zalo link
    $wp_customize->add_setting( 'floating_zalo', [
        'default'           => 'https://zalo.me/0393970681',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control( 'floating_zalo', [
        'label'       => 'Link Zalo',
        'section'     => 'miliwebseo_floating_buttons',
        'type'        => 'url',
        'description' => 'Nhập link chat Zalo (để trống để ẩn)',
    ]);

    // Messenger link
    $wp_customize->add_setting( 'floating_messenger', [
        'default'           => 'https://m.me/yourusername',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control( 'floating_messenger', [
        'label'       => 'Link Facebook Messenger',
        'section'     => 'miliwebseo_floating_buttons',
        'type'        => 'url',
        'description' => 'Nhập link chat Facebook Messenger (để trống để ẩn)',
    ]);

    // Custom icons for floating buttons
    $wp_customize->add_setting( 'floating_phone_icon', [ 'sanitize_callback' => 'absint' ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'floating_phone_icon', [
        'label'       => 'Icon Hotline (ảnh)',
        'section'     => 'miliwebseo_floating_buttons',
        'description' => 'Upload icon thay thế cho nút Hotline (khuyến nghị 48x48px)',
    ]));

    $wp_customize->add_setting( 'floating_zalo_icon', [ 'sanitize_callback' => 'absint' ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'floating_zalo_icon', [
        'label'       => 'Icon Zalo (ảnh)',
        'section'     => 'miliwebseo_floating_buttons',
    ]));

    $wp_customize->add_setting( 'floating_messenger_icon', [ 'sanitize_callback' => 'absint' ] );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'floating_messenger_icon', [
        'label'       => 'Icon Messenger (ảnh)',
        'section'     => 'miliwebseo_floating_buttons',
    ]));

    // ===== POPUP CONFIGURATION =====
    $wp_customize->add_section( 'miliwebseo_popup_settings', [
        'title'    => 'Cấu hình Popup',
        'priority' => 50,
    ]);

    // Enable/Disable Popup
    $wp_customize->add_setting( 'popup_enable', [
        'default'           => false,
        'sanitize_callback' => 'miliwebseo_sanitize_checkbox',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control( 'popup_enable', [
        'label'    => 'Bật hiển thị Popup',
        'section'  => 'miliwebseo_popup_settings',
        'type'     => 'checkbox',
    ]);

    // Popup Image
    $wp_customize->add_setting( 'popup_image', [
        'default'   => '',
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'popup_image', [
        'label'       => 'Ảnh Popup',
        'section'     => 'miliwebseo_popup_settings',
        'description' => 'Chọn hoặc tải lên ảnh cho popup.',
    ]));

    // Popup Link
    $wp_customize->add_setting( 'popup_link', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control( 'popup_link', [
        'label'       => 'Link liên kết của Popup',
        'section'     => 'miliwebseo_popup_settings',
        'type'        => 'url',
        'description' => 'Đường dẫn khi click vào ảnh popup (ví dụ: link sản phẩm, khuyến mãi). Để trống nếu không cần link.',
    ]);
}
add_action( 'customize_register', 'miliwebseo_customize_register' );

/**
 * Sanitize checkbox values.
 */
if ( ! function_exists( 'miliwebseo_sanitize_checkbox' ) ) {
    function miliwebseo_sanitize_checkbox( $checked ) {
        return ( ( isset( $checked ) && true == $checked ) ? true : false );
    }
}
