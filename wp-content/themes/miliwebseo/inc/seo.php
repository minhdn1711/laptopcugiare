<?php
/**
 * SEO & Schema.org Implementation
 */

function miliwebseo_add_product_schema() {
    if ( ! is_product() ) {
        return;
    }

    global $product;

    if ( ! is_object( $product ) || ! is_a( $product, 'WC_Product' ) ) {
        $product = wc_get_product( get_the_ID() );
    }

    if ( ! $product ) {
        return;
    }

    $shop_name = get_bloginfo( 'name' );
    $product_name = $product->get_name();
    $product_url = get_permalink();
    $product_image = wp_get_attachment_url( $product->get_image_id() );
    $product_description = get_the_excerpt() ?: $product->get_short_description();
    $sku = $product->get_sku() ?: 'N/A';
    $price = $product->get_price();
    $currency = get_woocommerce_currency();
    $availability = $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock';

    ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Product",
      "name": "<?php echo esc_js( $product_name ); ?>",
      "image": "<?php echo esc_url( $product_image ); ?>",
      "description": "<?php echo esc_js( wp_strip_all_tags( $product_description ) ); ?>",
      "sku": "<?php echo esc_js( $sku ); ?>",
      "brand": {
        "@type": "Brand",
        "name": "<?php echo esc_js( strip_tags( get_the_term_list( get_the_ID(), 'product_brand', '', ', ' ) ) ?: $shop_name ); ?>"
      },
      "offers": {
        "@type": "Offer",
        "url": "<?php echo esc_url( $product_url ); ?>",
        "priceCurrency": "<?php echo esc_js( $currency ); ?>",
        "price": "<?php echo esc_js( $price ); ?>",
        "availability": "<?php echo esc_url( $availability ); ?>",
        "seller": {
          "@type": "Organization",
          "name": "<?php echo esc_js( $shop_name ); ?>"
        }
      }
    }
    </script>
    <?php
}
add_action( 'wp_head', 'miliwebseo_add_product_schema' );

/**
 * Breadcrumb Schema
 */
function miliwebseo_add_breadcrumb_schema() {
    if ( is_front_page() || is_404() ) {
        return;
    }

    $items = array();
    $items[] = array( 'name' => 'Trang chủ', 'url' => home_url() );

    if ( is_product() ) {
        $terms = get_the_terms( get_the_ID(), 'product_cat' );
        if ( $terms ) {
            $main_term = $terms[0];
            $items[] = array( 'name' => $main_term->name, 'url' => get_term_link( $main_term ) );
        }
        $items[] = array( 'name' => get_the_title(), 'url' => get_permalink() );
    } elseif ( is_shop() ) {
        $items[] = array( 'name' => 'Cửa hàng', 'url' => get_permalink( wc_get_page_id( 'shop' ) ) );
    } elseif ( is_tax() || is_category() ) {
        $queried_object = get_queried_object();
        $items[] = array( 'name' => $queried_object->name, 'url' => get_term_link( $queried_object ) );
    }

    if ( empty( $items ) ) return;

    ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [
        <?php foreach ( $items as $index => $item ) : ?>
        {
          "@type": "ListItem",
          "position": <?php echo $index + 1; ?>,
          "name": "<?php echo esc_js( $item['name'] ); ?>",
          "item": "<?php echo esc_url( $item['url'] ); ?>"
        }<?php echo ( $index < count( $items ) - 1 ) ? ',' : ''; ?>
        <?php endforeach; ?>
      ]
    }
    </script>
    <?php
}
add_action( 'wp_head', 'miliwebseo_add_breadcrumb_schema' );
