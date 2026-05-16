<div class="product-card group relative bg-white p-4 flex flex-col h-full hover:shadow-2xl transition-all duration-300 border border-gray-100 rounded-xl overflow-hidden">
    <!-- Link Overlay (Invisible but covers whole card) -->
    <a href="#" class="absolute inset-0 z-[35]"></a>
    
    <!-- Discount Badge -->
    <div class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded-sm z-40">
        -15%
    </div>
    
    <!-- Product Image -->
    <div class="relative mb-4 aspect-[4/3] overflow-hidden z-10">
        <img src="https://placehold.co/300x225?text=Laptop+Image" alt="Laptop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
    </div>

    <!-- Product Info -->
    <div class="flex-grow z-10">
        <h3 class="text-sm font-semibold mb-2 line-clamp-2 group-hover:text-primary transition-colors h-10">
            Laptop Gaming Acer Nitro V ANV15-51-57ND Intel Core i5-13420H
        </h3>
        
        <!-- Price -->
        <div class="flex items-center flex-wrap gap-x-2 gap-y-1 mb-2">
            <span class="text-primary font-black text-lg leading-none">19.490.000đ</span>
            <span class="text-[11px] text-gray-400 line-through">22.900.000đ</span>
        </div>
        
        <!-- Tags -->
        <div class="flex flex-wrap gap-1 mb-3">
            <span class="text-[9px] bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded border border-blue-100 font-bold uppercase tracking-tighter">Trả góp 0%</span>
            <span class="text-[9px] bg-green-50 text-green-600 px-1.5 py-0.5 rounded border border-green-100 font-bold uppercase tracking-tighter italic">Có sẵn</span>
        </div>
    </div>

    <!-- Action Button -->
    <div class="mt-auto z-40 relative">
        <a href="#" class="block w-full bg-gray-50 border border-gray-200 group-hover:bg-primary group-hover:border-primary group-hover:text-black text-gray-600 font-bold py-2 rounded text-xs transition-colors uppercase text-center">
            Xem chi tiết
        </a>
    </div>

    <!-- Hover Specs Overlay (Desktop - Full Height) -->
    <div class="absolute inset-0 bg-black bg-opacity-80 text-white p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 text-xs flex flex-col justify-center z-20 hidden md:flex">
        <p class="font-bold mb-2 text-primary text-sm">Thông số kỹ thuật:</p>
        <ul class="space-y-1.5">
            <li class="flex items-start gap-1"><span class="text-gray-400">CPU:</span> Intel Core i5-13500H</li>
            <li class="flex items-start gap-1"><span class="text-gray-400">RAM:</span> 16GB DDR5</li>
            <li class="flex items-start gap-1"><span class="text-gray-400">SSD:</span> 512GB Gen 4</li>
            <li class="flex items-start gap-1"><span class="text-gray-400">VGA:</span> RTX 4050 6GB</li>
            <li class="flex items-start gap-1"><span class="text-gray-400">Màn:</span> 15.6" FHD 144Hz</li>
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
