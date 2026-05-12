<?php
/**
 * Custom Taxonomies Registration
 */

function miliwebseo_register_taxonomies() {
	$taxonomies = array(
		'brand'       => array( 'name' => 'Thương hiệu', 'plural' => 'Thương hiệu' ),
		'cpu'         => array( 'name' => 'CPU', 'plural' => 'Dòng CPU' ),
		'ram'         => array( 'name' => 'RAM', 'plural' => 'Dung lượng RAM' ),
		'ssd'         => array( 'name' => 'Ổ cứng (SSD)', 'plural' => 'Dung lượng ổ cứng' ),
		'vga'         => array( 'name' => 'Card đồ họa (VGA)', 'plural' => 'Dòng VGA' ),
		'screen_size' => array( 'name' => 'Kích thước màn hình', 'plural' => 'Kích thước màn hình' ),
		'usage_needs' => array( 'name' => 'Nhu cầu sử dụng', 'plural' => 'Nhu cầu' ),
	);

	foreach ( $taxonomies as $slug => $args ) {
		$labels = array(
			'name'              => $args['name'],
			'singular_name'     => $args['name'],
			'search_items'      => 'Tìm ' . $args['name'],
			'all_items'         => 'Tất cả ' . $args['plural'],
			'parent_item'       => 'Cha',
			'parent_item_colon' => 'Cha:',
			'edit_item'         => 'Sửa ' . $args['name'],
			'update_item'       => 'Cập nhật ' . $args['name'],
			'add_new_item'      => 'Thêm mới ' . $args['name'],
			'new_item_name'     => 'Tên ' . $args['name'] . ' mới',
			'menu_name'         => $args['name'],
		);

		register_taxonomy( $slug, array( 'product' ), array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => $slug ),
			'show_in_rest'      => true,
		) );
	}
}
add_action( 'init', 'miliwebseo_register_taxonomies' );
