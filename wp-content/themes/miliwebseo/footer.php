</main>
<footer class="bg-secondary text-gray-300 pt-12 pb-6 mt-12">
    <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div>
            <h3 class="text-white font-bold text-lg mb-4">VỀ LAPTOP CŨ GIÁ RẺ</h3>
            <p class="text-sm leading-relaxed mb-4">
                <?php echo get_theme_mod('footer_about', 'Hệ thống bán lẻ laptop uy tín hàng đầu.'); ?>
            </p>
            <div class="flex space-x-4">
                <!-- Social Icons -->
                <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-primary hover:text-black transition-all transform hover:-translate-y-1">
                    <?php echo miliwebseo_icon('chevron-right', 'h-5 w-5'); ?>
                </a>
                <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-primary hover:text-black transition-all transform hover:-translate-y-1">
                    <?php echo miliwebseo_icon('flame', 'h-5 w-5'); ?>
                </a>
                <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-primary hover:text-black transition-all transform hover:-translate-y-1">
                    <?php echo miliwebseo_icon('zap', 'h-5 w-5'); ?>
                </a>
            </div>
        </div>
        <div>
            <h3 class="text-white font-bold text-lg mb-4">HỖ TRỢ KHÁCH HÀNG</h3>
            <?php echo get_theme_mod('footer_support_html', '<ul class="space-y-2 text-sm">
<li><a href="#" class="hover:text-primary">Hướng dẫn mua hàng online</a></li>
<li><a href="#" class="hover:text-primary">Chính sách bảo hành</a></li>
<li><a href="#" class="hover:text-primary">Chính sách đổi trả</a></li>
<li><a href="#" class="hover:text-primary">Chính sách vận chuyển</a></li>
<li><a href="#" class="hover:text-primary">Hướng dẫn thanh toán</a></li>
</ul>'); ?>
        </div>
        <div>
            <h3 class="text-white font-bold text-lg mb-4">DANH MỤC PHỔ BIẾN</h3>
            <?php echo get_theme_mod('footer_categories_html', '<ul class="space-y-2 text-sm">
<li><a href="#" class="hover:text-primary">Laptop Gaming</a></li>
<li><a href="#" class="hover:text-primary">Laptop Văn Phòng</a></li>
<li><a href="#" class="hover:text-primary">Macbook Air / Pro</a></li>
<li><a href="#" class="hover:text-primary">Laptop Cũ Giá Rẻ</a></li>
</ul>'); ?>
        </div>
        <div>
            <h3 class="text-white font-bold text-lg mb-4">LIÊN HỆ</h3>
            <?php echo get_theme_mod('footer_contact_html', '<ul class="space-y-4 text-sm">
<li class="flex items-start gap-3">
<span class="text-primary mt-0.5">📍</span>
<span>Địa chỉ: 123 Đường ABC, Quận XYZ, TP. HCM</span>
</li>
<li class="flex items-center gap-3">
<span class="text-primary">☎</span>
<span>Hotline: 1900.xxxx</span>
</li>
<li class="flex items-center gap-3">
<span class="text-primary">✉</span>
<span>Email: contact@miliweb.vn</span>
</li>
</ul>'); ?>
        </div>
    </div>
    <div class="container mx-auto px-4 mt-12 pt-6 border-t border-gray-800 text-center text-xs">
        <p>&copy; <?php echo date('Y'); ?> LAPTOP CŨ GIÁ RẺ. All rights reserved. Designed by Antigravity.</p>
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
                <?php echo miliwebseo_icon('check-circle', 'h-6 w-6'); ?>
            </template>
            <template x-if="type === 'error'">
                <?php echo miliwebseo_icon('x-circle', 'h-6 w-6'); ?>
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
