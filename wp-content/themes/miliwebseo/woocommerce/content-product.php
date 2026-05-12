<?php
/**
 * Custom WooCommerce Content Product (Grid)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>

<div <?php wc_product_class( 'product-card group relative bg-white p-4 flex flex-col h-full hover:shadow-2xl transition-all duration-300', $product ); ?>>
    <a href="<?php echo esc_url( get_permalink() ); ?>" class="absolute inset-0 z-10"></a>
    
    <!-- Discount Badge -->
    <?php if ( $product->is_on_sale() ) : ?>
        <div class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded z-20">
            -<?php 
                $regular_price = $product->get_regular_price();
                $sale_price = $product->get_sale_price();
                if($regular_price > 0) {
                    echo round(100 - ($sale_price / $regular_price * 100)); 
                }
            ?>%
        </div>
    <?php endif; ?>
    
    <!-- Product Image -->
    <div class="relative mb-4 aspect-[4/3] overflow-hidden z-0">
        <?php echo $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500' ) ); ?>
        
        <!-- Hover Specs Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-80 text-white p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 text-xs flex flex-col justify-center z-20">
            <p class="font-bold mb-2 text-primary">Thông số kỹ thuật:</p>
            <ul class="space-y-1">
                <?php
                $cpu = get_the_terms( get_the_ID(), 'cpu' );
                $ram = get_the_terms( get_the_ID(), 'ram' );
                $vga = get_the_terms( get_the_ID(), 'vga' );
                $ssd = get_the_terms( get_the_ID(), 'ssd' );
                if($cpu) echo "<li>CPU: {$cpu[0]->name}</li>";
                if($ram) echo "<li>RAM: {$ram[0]->name}</li>";
                if($ssd) echo "<li>SSD: {$ssd[0]->name}</li>";
                if($vga) echo "<li>VGA: {$vga[0]->name}</li>";
                ?>
            </ul>
            <?php 
            $gifts = get_post_meta( get_the_ID(), '_product_gifts', true );
            if($gifts): ?>
            <div class="mt-4 p-2 bg-gray-800 rounded border border-gray-700">
                <p class="text-primary font-bold">🎁 Quà tặng:</p>
                <p><?php echo esc_html($gifts); ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Product Info -->
    <div class="flex-grow z-0">
        <h3 class="text-sm font-semibold mb-2 line-clamp-2 hover:text-primary transition-colors">
            <?php the_title(); ?>
        </h3>
        
        <!-- Price -->
        <div class="flex items-baseline gap-2 mb-2">
            <span class="text-primary font-bold text-lg"><?php echo $product->get_price_html(); ?></span>
        </div>
        
        <!-- Tags -->
        <div class="flex gap-2 mb-3">
            <span class="text-[10px] bg-blue-50 text-blue-600 px-2 py-0.5 rounded border border-blue-100 italic">Trả góp 0%</span>
            <span class="text-[10px] bg-green-50 text-green-600 px-2 py-0.5 rounded border border-green-100 font-bold">SẴN HÀNG</span>
        </div>
    </div>

    <!-- Action Button -->
    <div class="mt-auto z-20">
        <button class="w-full bg-primary hover:bg-primary-dark text-black font-bold py-2 rounded text-sm transition-colors uppercase">
            Xem chi tiết
        </button>
    </div>
</div>
