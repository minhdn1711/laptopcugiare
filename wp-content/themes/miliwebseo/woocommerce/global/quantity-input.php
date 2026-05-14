<?php
/**
 * Product quantity inputs
 */

defined( 'ABSPATH' ) || exit;

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	?>
	<div class="quantity flex items-center bg-white rounded-full p-1 w-max border-2 border-gray-100 shadow-sm hover:border-primary/30 transition-all group">
		<button type="button" 
                onclick="var input = this.parentNode.querySelector('input'); var val = parseInt(input.value); if(val > parseInt(input.min)) input.value = val - 1;"
                class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-50 hover:bg-primary hover:text-white transition-all text-gray-400 hover:shadow-md active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4" />
            </svg>
        </button>
		
		<input
			type="number"
			id="<?php echo esc_attr( $input_id ); ?>"
			class="w-14 text-center bg-transparent border-0 focus:ring-0 font-black text-secondary text-lg [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
			step="<?php echo esc_attr( $step ); ?>"
			min="<?php echo esc_attr( $min_value > 0 ? $min_value : 1 ); ?>"
			max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
			name="<?php echo esc_attr( $input_name ); ?>"
            value="<?php echo esc_attr( $input_value > 0 ? $input_value : 1 ); ?>"
			size="4" />

		<button type="button" 
                onclick="var input = this.parentNode.querySelector('input'); var val = parseInt(input.value); var max = input.max ? parseInt(input.max) : 999; if(val < max) input.value = val + 1;"
                class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-50 hover:bg-primary hover:text-white transition-all text-gray-400 hover:shadow-md active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
            </svg>
        </button>
	</div>
	<?php
}
