<div class="product-card group relative bg-white p-4 flex flex-col h-full hover:shadow-2xl transition-all duration-300">
    <!-- Link Overlay -->
    <a href="#" class="absolute inset-0 z-10"></a>
    
    <!-- Discount Badge -->
    <div class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded z-10">
        -15%
    </div>
    
    <!-- Product Image -->
    <div class="relative mb-4 aspect-[4/3] overflow-hidden">
        <img src="https://placehold.co/300x225?text=Laptop+Image" alt="Laptop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        
        <!-- Hover Specs Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-80 text-white p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 text-xs flex flex-col justify-center">
            <p class="font-bold mb-2 text-primary">Thông số kỹ thuật:</p>
            <ul class="space-y-1">
                <li>CPU: Intel Core i5-13500H</li>
                <li>RAM: 16GB DDR5</li>
                <li>SSD: 512GB Gen 4</li>
                <li>VGA: RTX 4050 6GB</li>
                <li>Màn: 15.6" FHD 144Hz</li>
            </ul>
            <div class="mt-4 p-2 bg-gray-800 rounded border border-gray-700">
                <p class="text-primary font-bold flex items-center gap-1">
                    <?php echo miliwebseo_icon('gift', 'h-4 w-4'); ?>
                    Quà tặng:
                </p>
                <p>Balo + Chuột + Lót chuột</p>
            </div>
        </div>
    </div>

    <!-- Product Info -->
    <div class="flex-grow">
        <h3 class="text-sm font-semibold mb-2 line-clamp-2 hover:text-primary cursor-pointer">
            Laptop Gaming Acer Nitro V ANV15-51-57ND Intel Core i5-13420H
        </h3>
        
        <!-- Price -->
        <div class="flex items-baseline gap-2 mb-2">
            <span class="text-primary font-bold text-lg">19.490.000đ</span>
            <span class="text-gray-400 line-through text-xs">22.900.000đ</span>
        </div>
        
        <!-- Tags -->
        <div class="flex gap-2 mb-3">
            <span class="text-[10px] bg-blue-50 text-blue-600 px-2 py-0.5 rounded border border-blue-100 italic">Trả góp 0%</span>
            <span class="text-[10px] bg-green-50 text-green-600 px-2 py-0.5 rounded border border-green-100 font-bold">SẴN HÀNG</span>
        </div>
    </div>

    <!-- Action Button -->
    <div class="mt-auto">
        <button class="w-full bg-primary hover:bg-primary-dark text-black font-bold py-2 rounded text-sm transition-colors uppercase">
            Xem chi tiết
        </button>
    </div>
</div>
