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
    </div>

    <!-- Product Info -->
    <div class="flex-grow z-10">
        <h3 class="text-sm font-semibold mb-2 line-clamp-2 group-hover:text-primary transition-colors h-10">
            <?php the_title(); ?>
        </h3>
        
        <!-- Rating (Compact) -->
        <?php $rating = $product->get_average_rating(); ?>
        <div class="flex items-center gap-1.5 mb-1.5 h-4">
            <?php if ( $rating > 0 ) : ?>
                <div class="flex items-center gap-0.5 text-yellow-500 font-bold text-[10px]">
                    <span><?php echo number_format($rating, 1); ?></span>
                    <?php echo miliwebseo_icon('star', 'h-2.5 w-2.5 fill-current'); ?>
                </div>
                <span class="text-[9px] text-gray-400 font-medium">(<?php echo $product->get_review_count(); ?>)</span>
            <?php endif; ?>
        </div>

        <!-- Price -->
        <div class="flex items-center flex-wrap gap-x-2 gap-y-1 mb-2">
            <?php if ( $product->is_on_sale() ) : ?>
                <span class="text-primary font-black text-lg leading-none">
                    <?php echo wc_price( $product->get_sale_price() ); ?>
                </span>
                <span class="text-[11px] text-gray-400 line-through">
                    <?php echo wc_price( $product->get_regular_price() ); ?>
                </span>
            <?php else : ?>
                <span class="text-primary font-black text-lg leading-none">
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

    <!-- Hover Specs Overlay (Desktop - Full Height) -->
    <div class="absolute inset-0 bg-black bg-opacity-80 text-white p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 text-xs flex flex-col justify-center z-20 hidden md:flex">
        <p class="font-bold mb-2 text-primary text-sm">Thông số kỹ thuật:</p>
        <ul class="space-y-1.5">
            <?php
            $cpu = get_the_terms( get_the_ID(), 'cpu' );
            $ram = get_the_terms( get_the_ID(), 'ram' );
            $ssd = get_the_terms( get_the_ID(), 'ssd' );
            $vga = get_the_terms( get_the_ID(), 'vga' );
            $screen = get_the_terms( get_the_ID(), 'screen_size' );
            
            if($cpu) echo '<li class="flex items-start gap-1"><span class="text-gray-400">CPU:</span> ' . esc_html($cpu[0]->name) . '</li>';
            if($ram) echo '<li class="flex items-start gap-1"><span class="text-gray-400">RAM:</span> ' . esc_html($ram[0]->name) . '</li>';
            if($ssd) echo '<li class="flex items-start gap-1"><span class="text-gray-400">SSD:</span> ' . esc_html($ssd[0]->name) . '</li>';
            if($vga) echo '<li class="flex items-start gap-1"><span class="text-gray-400">VGA:</span> ' . esc_html($vga[0]->name) . '</li>';
            if($screen) echo '<li class="flex items-start gap-1"><span class="text-gray-400">Màn:</span> ' . esc_html($screen[0]->name) . '</li>';
            ?>
        </ul>
        <div class="mt-4 p-3 bg-gray-800/50 rounded-lg border border-gray-700/50 backdrop-blur-sm">
            <p class="text-primary font-bold flex items-center gap-1.5 mb-1">
                <?php echo miliwebseo_icon('gift', 'h-4 w-4'); ?>
                Quà tặng:
            </p>
            <p class="text-[11px] text-gray-200">Balo + Chuột + Lót chuột</p>
        </div>
    </div>
</div>
