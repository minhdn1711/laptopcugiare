<?php
/**
 * SEO & Schema.org Implementation
 */

/**
 * Organization + WebSite Schema (Homepage)
 */
function miliwebseo_add_organization_schema() {
    if ( ! is_front_page() ) return;

    $name = get_bloginfo('name');
    $url  = home_url();
    $logo = get_theme_mod('custom_logo') ? wp_get_attachment_url(get_theme_mod('custom_logo')) : '';
    ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "Organization",
          "name": "<?php echo esc_js($name); ?>",
          "url": "<?php echo esc_url($url); ?>",
          <?php if ($logo) : ?>"logo": "<?php echo esc_url($logo); ?>",<?php endif; ?>
          "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+84-1900-xxxx",
            "contactType": "customer service"
          }
        },
        {
          "@type": "WebSite",
          "url": "<?php echo esc_url($url); ?>",
          "name": "<?php echo esc_js($name); ?>",
          "potentialAction": {
            "@type": "SearchAction",
            "target": "<?php echo esc_url($url); ?>/?s={search_term_string}",
            "query-input": "required name=search_term_string"
          }
        }
      ]
    }
    </script>
    <?php
}
add_action('wp_head', 'miliwebseo_add_organization_schema');

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
 * Generate Breadcrumb items
 */
function miliwebseo_get_breadcrumb_items() {
    $items = [];
    $items[] = ['name' => 'Trang chủ', 'url' => home_url()];

    if (is_product()) {
        $terms = get_the_terms(get_the_ID(), 'product_cat');
        if ($terms && !is_wp_error($terms)) {
            $term = array_shift($terms);
            $items[] = ['name' => $term->name, 'url' => get_term_link($term)];
        }
        $items[] = ['name' => get_the_title(), 'url' => get_permalink()];
    } elseif (is_shop()) {
        $items[] = ['name' => 'Cửa hàng', 'url' => get_permalink(wc_get_page_id('shop'))];
    } elseif (is_tax('product_cat') || is_tax('product_brand') || is_tax('product_series')) {
        $term = get_queried_object();
        if ($term->parent) {
            $parent = get_term($term->parent, $term->taxonomy);
            $items[] = ['name' => $parent->name, 'url' => get_term_link($parent)];
        }
        $items[] = ['name' => $term->name, 'url' => get_term_link($term)];
    } elseif (is_tax() || is_category()) {
        $term = get_queried_object();
        $items[] = ['name' => $term->name, 'url' => get_term_link($term)];
    } elseif (is_page()) {
        $items[] = ['name' => get_the_title(), 'url' => get_permalink()];
    }

    return $items;
}

/**
 * Breadcrumb Schema (improved)
 */
function miliwebseo_add_breadcrumb_schema() {
    if (is_front_page() || is_404()) return;

    $items = miliwebseo_get_breadcrumb_items();
    if (empty($items)) return;

    ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [
        <?php foreach ($items as $i => $item): ?>
        {
          "@type": "ListItem",
          "position": <?php echo $i + 1; ?>,
          "name": "<?php echo esc_js($item['name']); ?>",
          "item": "<?php echo esc_url($item['url']); ?>"
        }<?php echo ($i < count($items)-1) ? ',' : ''; ?>
        <?php endforeach; ?>
      ]
    }
    </script>
    <?php
}
add_action('wp_head', 'miliwebseo_add_breadcrumb_schema');

/**
 * Visible Breadcrumb HTML
 */
function miliwebseo_breadcrumb() {
    $items = miliwebseo_get_breadcrumb_items();
    if (count($items) <= 1) return;

    echo '<nav class="text-sm text-gray-500 mb-4" aria-label="Breadcrumb">';
    echo '<ol class="flex items-center space-x-2">';
    foreach ($items as $i => $item) {
        if ($i > 0) echo '<li class="text-gray-400">/</li>';
        if ($i === count($items) - 1) {
            echo '<li class="text-secondary font-medium">' . esc_html($item['name']) . '</li>';
        } else {
            echo '<li><a href="' . esc_url($item['url']) . '" class="hover:text-primary">' . esc_html($item['name']) . '</a></li>';
        }
    }
    echo '</ol></nav>';
}
