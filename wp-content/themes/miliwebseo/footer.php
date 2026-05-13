</main>
<footer class="bg-secondary text-gray-300 pt-12 pb-6 mt-12">
    <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div>
            <h3 class="text-white font-bold text-lg mb-4">VỀ MILIWEBSEO</h3>
            <p class="text-sm leading-relaxed mb-4">
                Hệ thống bán lẻ laptop uy tín hàng đầu. Chuyên cung cấp laptop gaming, văn phòng, đồ họa chính hãng và nhập khẩu.
            </p>
            <div class="flex space-x-4">
                <!-- Social Icons -->
                <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-primary transition-colors">FB</a>
                <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-primary transition-colors">YT</a>
                <a href="#" class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center hover:bg-primary transition-colors">TT</a>
            </div>
        </div>
        <div>
            <h3 class="text-white font-bold text-lg mb-4">HỖ TRỢ KHÁCH HÀNG</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:text-primary">Hướng dẫn mua hàng online</a></li>
                <li><a href="#" class="hover:text-primary">Chính sách bảo hành</a></li>
                <li><a href="#" class="hover:text-primary">Chính sách đổi trả</a></li>
                <li><a href="#" class="hover:text-primary">Chính sách vận chuyển</a></li>
                <li><a href="#" class="hover:text-primary">Hướng dẫn thanh toán</a></li>
            </ul>
        </div>
        <div>
            <h3 class="text-white font-bold text-lg mb-4">DANH MỤC PHỔ BIẾN</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:text-primary">Laptop Gaming</a></li>
                <li><a href="#" class="hover:text-primary">Laptop Văn Phòng</a></li>
                <li><a href="#" class="hover:text-primary">Macbook Air / Pro</a></li>
                <li><a href="#" class="hover:text-primary">Laptop Cũ Giá Rẻ</a></li>
            </ul>
        </div>
        <div>
            <h3 class="text-white font-bold text-lg mb-4">LIÊN HỆ</h3>
            <ul class="space-y-2 text-sm">
                <li class="flex items-start gap-2">
                    <span>📍</span>
                    <span>Địa chỉ: 123 Đường ABC, Quận XYZ, TP. HCM</span>
                </li>
                <li class="flex items-center gap-2">
                    <span>📞</span>
                    <span>Hotline: 1900.xxxx</span>
                </li>
                <li class="flex items-center gap-2">
                    <span>✉️</span>
                    <span>Email: contact@miliweb.vn</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="container mx-auto px-4 mt-12 pt-6 border-t border-gray-800 text-center text-xs">
        <p>&copy; <?php echo date('Y'); ?> MILIWEBSEO. All rights reserved. Designed by Antigravity.</p>
    </div>
</footer>

<!-- Global Toast Notification System -->
<div x-data="{ 
    show: false, 
    message: '', 
    type: 'success',
    init() {
        <?php 
        $notices = wc_get_notices('success');
        if ( !empty($notices) ) : 
            $message = reset($notices)['notice'];
        ?>
            this.showToast('<?php echo $message; ?>', 'success');
            <?php wc_clear_notices(); ?>
        <?php endif; ?>
    },
    showToast(msg, type) {
        this.message = msg;
        this.type = type;
        this.show = true;
        setTimeout(() => { this.show = false; }, 5000);
    }
}" 
@show-toast.window="showToast($event.detail.message, $event.detail.type)"
x-show="show" 
x-cloak
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="translate-x-full opacity-0"
x-transition:enter-end="translate-x-0 opacity-100"
x-transition:leave="transition ease-in duration-300"
x-transition:leave-start="translate-x-0 opacity-100"
x-transition:leave-end="translate-x-full opacity-0"
class="fixed top-24 right-4 z-[200] max-w-sm w-full">
    <div :class="type === 'success' ? 'bg-green-600' : 'bg-red-600'" 
         class="text-white p-4 rounded-xl shadow-2xl flex items-center gap-4 border border-white/20 backdrop-blur-md bg-opacity-90">
        <div class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
            <template x-if="type === 'success'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </template>
        </div>
        <div class="flex-grow">
            <p class="font-bold text-sm" x-html="message"></p>
            <div class="mt-1 flex gap-3">
                <a href="<?php echo wc_get_cart_url(); ?>" class="text-[10px] font-black uppercase underline hover:no-underline">Xem giỏ hàng</a>
                <button @click="show = false" class="text-[10px] font-black uppercase opacity-70">Đóng</button>
            </div>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
