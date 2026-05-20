<?php
// Close main tag for all pages
?>
</main><!-- #main or #primary -->

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
        <p>&copy; <?php echo date('Y'); ?> LAPTOP CŨ GIÁ RẺ. All rights reserved</p>
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

<!-- Floating Contact Buttons -->
<div class="fixed bottom-28 left-6 z-[150] flex flex-col gap-3">
    
    <!-- Hotline Button (Phone) -->
    <?php 
    $float_phone = get_theme_mod('floating_phone', '0393970681'); 
    if ( !empty($float_phone) ) : ?>
        <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $float_phone)); ?>" 
           class="w-12 h-12 rounded-full bg-red-600 hover:bg-red-700 text-white flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 relative group animate-pulse">
            <span class="absolute left-14 bg-gray-900 text-white text-xs font-bold py-1 px-3.5 rounded-lg opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity duration-300 shadow-md whitespace-nowrap">
                Hotline: <?php echo esc_html($float_phone); ?>
            </span>
            <?php 
            $phone_icon = get_theme_mod('floating_phone_icon');
            if ($phone_icon) {
                echo wp_get_attachment_image($phone_icon, [32, 32], false, ['class' => 'w-6 h-6 object-contain']);
            } else { ?>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
            <?php } ?>
        </a>
    <?php endif; ?>

    <!-- Zalo Button -->
    <?php 
    $float_zalo = get_theme_mod('floating_zalo', 'https://zalo.me/0393970681'); 
    if ( !empty($float_zalo) ) : ?>
        <a href="<?php echo esc_url($float_zalo); ?>" target="_blank" rel="noopener"
           class="w-12 h-12 rounded-full bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 relative group">
            <span class="absolute left-14 bg-gray-900 text-white text-xs font-bold py-1 px-3.5 rounded-lg opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity duration-300 shadow-md whitespace-nowrap">
                Chat Zalo
            </span>
            <?php 
            $zalo_icon = get_theme_mod('floating_zalo_icon');
            if ($zalo_icon) {
                echo wp_get_attachment_image($zalo_icon, [32, 32], false, ['class' => 'w-6 h-6 object-contain']);
            } else { ?>
                <span class="font-black text-[13px] italic tracking-tight">Zalo</span>
            <?php } ?>
        </a>
    <?php endif; ?>

    <!-- Messenger Button -->
    <?php 
    $float_fb = get_theme_mod('floating_messenger', 'https://m.me/yourusername'); 
    if ( !empty($float_fb) ) : ?>
        <a href="<?php echo esc_url($float_fb); ?>" target="_blank" rel="noopener"
           class="w-12 h-12 rounded-full bg-gradient-to-tr from-blue-500 via-purple-500 to-pink-500 hover:opacity-90 text-white flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 relative group">
            <span class="absolute left-14 bg-gray-900 text-white text-xs font-bold py-1 px-3.5 rounded-lg opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity duration-300 shadow-md whitespace-nowrap">
                Messenger
            </span>
            <?php 
            $messenger_icon = get_theme_mod('floating_messenger_icon');
            if ($messenger_icon) {
                echo wp_get_attachment_image($messenger_icon, [32, 32], false, ['class' => 'w-6 h-6 object-contain']);
            } else { ?>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.477 2 2 6.145 2 11.243c0 2.913 1.448 5.514 3.738 7.197.195.143.308.368.303.606l-.082 2.213c-.015.426.435.733.82.55l2.478-1.18c.18-.086.389-.092.573-.017A9.873 9.873 0 0 0 12 20.486c5.523 0 10-4.146 10-9.243S17.523 2 12 2zm1.03 11.89-2.39-2.548-4.662 2.548 5.125-5.442 2.454 2.548 4.598-2.548-5.125 5.442z"/>
                </svg>
            <?php } ?>
        </a>
    <?php endif; ?>

</div>

<!-- Back to Top Button -->
<div x-data="{ 
    showBackToTop: false,
    init() {
        window.addEventListener('scroll', () => {
            this.showBackToTop = window.scrollY > 300;
        });
    },
    scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}" class="fixed bottom-6 right-6 z-[150]">
    <button x-show="showBackToTop" @click="scrollToTop"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2 scale-90"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-2 scale-90"
            class="w-12 h-12 rounded-full bg-white hover:bg-gray-100 text-secondary border border-gray-100 flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 relative group focus:outline-none"
            style="display: none;">
        <span class="absolute right-14 bg-gray-900 text-white text-xs font-bold py-1 px-3.5 rounded-lg opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity duration-300 shadow-md whitespace-nowrap">
            Cuộn lên đầu
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform group-hover:-translate-y-0.5 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>
    </button>
</div>

<?php
// Home page popup implementation
$popup_enable = get_theme_mod('popup_enable', false);
$popup_image = get_theme_mod('popup_image');
$popup_link = get_theme_mod('popup_link');

if ( (is_front_page() || is_home()) && $popup_enable && !empty($popup_image) ) :
?>
<!-- Web Visit Popup Modal -->
<div x-data="{ 
    showPopup: false,
    init() {
        // Show after a short delay (1s) to make it feel premium and natural,
        // and only if they haven't seen/dismissed it in the current session
        if (!sessionStorage.getItem('miliwebseo_popup_shown')) {
            setTimeout(() => {
                this.showPopup = true;
            }, 1000);
        }
    },
    closePopup() {
        this.showPopup = false;
        sessionStorage.setItem('miliwebseo_popup_shown', 'true');
    }
}" 
x-show="showPopup"
x-cloak
class="fixed inset-0 z-[99999] flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100"
x-transition:leave="transition ease-in duration-200"
x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0"
@keydown.escape.window="closePopup()"
style="display: none;">

    <!-- Modal Content Panel -->
<div @click.away="closePopup()" 
          class="relative max-w-lg w-full overflow-hidden transform transition-all"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-90 translate-y-4">
        
        <!-- Close Button (Premium Floating Circle) -->
        <button @click="closePopup()" 
                class="absolute top-4 right-4 z-50 w-9 h-9 flex items-center justify-center text-white hover:text-primary transition-all duration-300 focus:outline-none"
                aria-label="Đóng popup">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Popup Image & Link Body -->
        <div class="relative overflow-hidden">
            <?php if (!empty($popup_link)) : ?>
                <a href="<?php echo esc_url($popup_link); ?>" class="block group" @click="closePopup()">
                    <img src="<?php echo esc_url($popup_image); ?>" alt="Popup khuyến mãi" class="w-full h-auto object-cover max-h-[75vh] group-hover:scale-[1.02] transition-transform duration-500">
                </a>
            <?php else : ?>
                <img src="<?php echo esc_url($popup_image); ?>" alt="Popup khuyến mãi" class="w-full h-auto object-cover max-h-[75vh]">
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
