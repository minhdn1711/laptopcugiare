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

<div <?php wc_product_class( 'product-card group relative bg-white p-4 flex flex-col h-full hover:shadow-2xl transition-all duration-300 border border-gray-100 rounded-xl overflow-hidden', $product ); ?>>
    <!-- Link wrapper -->
    <a href="<?php echo esc_url( get_permalink() ); ?>" class="absolute inset-0 z-30" aria-label="<?php the_title(); ?>"></a>
    
    <!-- Discount Badge -->
    <?php if ( $product->is_on_sale() ) : ?>
        <div class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded-sm z-40">
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
    <div class="relative mb-4 aspect-[4/3] overflow-hidden z-10">
        <?php echo $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500' ) ); ?>
        
        <!-- Hover Specs Overlay (Desktop) -->
        <div class="absolute inset-0 bg-black bg-opacity-80 text-white p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 text-xs flex flex-col justify-center z-20 hidden md:flex">
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
        </div>
    </div>

    <!-- Product Info -->
    <div class="flex-grow z-10">
        <h3 class="text-sm font-semibold mb-2 line-clamp-2 group-hover:text-primary transition-colors h-10">
            <?php the_title(); ?>
        </h3>
        
        <!-- Price -->
        <div class="flex items-baseline gap-2 mb-2">
            <?php if ( $product->is_on_sale() ) : ?>
                <span class="text-primary font-bold text-lg leading-none">
                    <?php echo wc_price( $product->get_sale_price() ); ?>
                </span>
                <span class="text-xs text-gray-400 line-through">
                    <?php echo wc_price( $product->get_regular_price() ); ?>
                </span>
            <?php else : ?>
                <span class="text-primary font-bold text-lg leading-none">
                    <?php echo $product->get_price_html(); ?>
                </span>
            <?php endif; ?>
        </div>

        <!-- Tags -->
        <div class="flex flex-wrap gap-1 mb-3">
            <span class="text-[9px] bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded border border-blue-100 font-bold uppercase tracking-tighter">Trả góp 0%</span>
            <span class="text-[9px] bg-green-50 text-green-600 px-1.5 py-0.5 rounded border border-green-100 font-bold uppercase tracking-tighter italic">Có sẵn</span>
        </div>
    </div>

    <!-- Action Button (Visual only) -->
    <div class="mt-auto z-10">
        <div class="w-full bg-gray-50 border border-gray-200 group-hover:bg-primary group-hover:border-primary group-hover:text-black text-gray-600 font-bold py-2 rounded text-xs transition-colors uppercase text-center">
            Xem chi tiết
        </div>
    </div>
</div>
