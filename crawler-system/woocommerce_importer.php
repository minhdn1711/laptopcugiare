<?php
/**
 * WooCommerce Importer Engine
 */
require_once( dirname(__DIR__) . '/wp-load.php' );

class L88_Importer {
    public function import_item($item) {
        // 1. Build 3-Level Category Tree: Root -> Brand -> Series
        $l1_id = $this->ensure_taxonomy($item['taxonomies']['product_cat'], 'product_cat', 0);
        $l2_id = $this->ensure_taxonomy($item['taxonomies']['product_brand'], 'product_cat', $l1_id);
        $l3_id = $this->ensure_taxonomy($item['taxonomies']['product_series'], 'product_cat', $l2_id);

        // 2. Create Product Post
        $post_id = wp_insert_post([
            'post_title'   => $item['title'],
            'post_name'    => $item['slug'],
            'post_type'    => 'product',
            'post_status'  => 'publish',
            'post_content' => $item['content']
        ]);

        if (is_wp_error($post_id)) return false;

        // 3. WooCommerce Meta Data
        update_post_meta($post_id, '_sku', $item['sku']);
        update_post_meta($post_id, '_regular_price', $item['price']);
        update_post_meta($post_id, '_price', $item['price']);
        update_post_meta($post_id, '_stock_status', 'instock');

        // 4. Assign Category Tree
        wp_set_object_terms($post_id, [$l1_id, $l2_id, $l3_id], 'product_cat');
        
        // Also assign to separate taxonomies for advanced filtering
        wp_set_object_terms($post_id, $item['taxonomies']['product_brand'], 'product_brand');
        wp_set_object_terms($post_id, $item['taxonomies']['product_series'], 'product_series');

        // 5. Attributes Mapping
        foreach ($item['attributes'] as $tax => $val) {
            if ($val) wp_set_object_terms($post_id, $val, $tax);
        }

        // 6. Automatic Usage Needs Mapping
        $this->map_usage_needs($post_id, $item['title']);

        return $post_id;
    }

    private function map_usage_needs($post_id, $title) {
        $title_lc = strtolower($title);
        $needs = [
            'office'      => ['Laptop sinh viên - văn phòng', ['office', 'văn phòng', 'sinh viên']],
            'gaming'      => ['Laptop Gaming', ['gaming', 'rog', 'legion', 'victus', 'nitro', 'predator', 'alienware', 'tuf']],
            'workstation' => ['Laptop đồ họa', ['workstation', 'đồ họa', 'precision', 'proart', 'quadro', 'zbook']],
            'ultrabook'   => ['Laptop mỏng nhẹ', ['air', 'thin', 'slim', 'gram', 'ultrabook', 'xps', 'zenbook']],
            'ai-laptop'   => ['Laptop AI', ['ai', 'npu', 'ultra', 'meteor lake']]
        ];

        $assigned_ids = [];
        foreach ($needs as $slug => $data) {
            $found = false;
            foreach ($data[1] as $keyword) {
                if (strpos($title_lc, $keyword) !== false) {
                    $found = true;
                    break;
                }
            }
            if ($found) {
                $assigned_ids[] = $this->ensure_taxonomy($data[0], 'usage_needs', 0);
            }
        }

        // Default to Office if nothing found
        if (empty($assigned_ids)) {
            $assigned_ids[] = $this->ensure_taxonomy($needs['office'][0], 'usage_needs', 0);
        }

        wp_set_object_terms($post_id, $assigned_ids, 'usage_needs');
    }

    private function ensure_taxonomy($name, $tax, $parent = 0) {
        $term = get_term_by('name', $name, $tax);
        if (!$term) {
            $new = wp_insert_term($name, $tax, ['parent' => $parent]);
            return is_wp_error($new) ? 0 : $new['term_id'];
        }
        return $term->term_id;
    }
}
