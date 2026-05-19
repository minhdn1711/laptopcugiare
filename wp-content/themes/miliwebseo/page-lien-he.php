<?php
/**
 * The template for displaying the contact page (slug: lien-he)
 *
 * @package Miliwebseo
 */

get_header();
?>

<!-- Glowing Hero Header -->
<div class="relative bg-gradient-to-r from-secondary via-gray-900 to-secondary text-white py-24 px-4 md:px-6 overflow-hidden">
    <!-- Blurry Ambient Spheres -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-accent/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:20px_20px] pointer-events-none"></div>

    <div class="container mx-auto max-w-4xl text-center relative z-10 space-y-6">
        <h1 class="text-3xl md:text-5xl font-black italic tracking-wider uppercase leading-tight drop-shadow-md">
            Xin chào, chúng tôi có thể giúp gì cho bạn?
        </h1>
        <p class="text-gray-400 text-sm md:text-base max-w-lg mx-auto leading-relaxed">
            Tìm kiếm thông tin sản phẩm, chính sách mua hàng hoặc gửi thắc mắc của bạn trực tiếp cho đội ngũ hỗ trợ.
        </p>
        
        <!-- Search bar targeting products -->
        <form role="search" method="get" class="max-w-xl mx-auto relative group mt-8" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <input type="search" name="s" class="w-full py-4 pl-6 pr-14 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-white placeholder-white/40 text-sm md:text-base focus:outline-none focus:ring-4 focus:ring-primary/20 focus:border-primary focus:bg-white focus:text-secondary transition-all shadow-2xl" placeholder="Nhập tên sản phẩm cần tìm..." required />
            <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/50 group-hover:text-primary transition-colors focus:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </form>
    </div>
</div>

<!-- Main Content Grid -->
<div class="bg-gray-50/50 pb-20 relative z-20">
    <div class="container mx-auto px-4 md:px-6">
        
        <!-- Row 1: FAQ, Review, Stores (pulled up slightly over hero) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 -mt-10">
            <!-- FAQ Card -->
            <a href="#" class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col items-center text-center space-y-4 group">
                <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-secondary group-hover:text-primary transition-colors">Các câu hỏi thường gặp</h3>
                <p class="text-xs text-gray-400 leading-relaxed max-w-[200px]">Xem giải đáp cho các câu hỏi phổ biến từ khách hàng.</p>
            </a>

            <!-- Review Card -->
            <a href="#" class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col items-center text-center space-y-4 group">
                <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.9 1.397-.9 1.697 0l2.214 6.748a1 1 0 00.95.69h7.105c.9 0 1.275 1.15.485 1.721l-5.748 4.18a1 1 0 00-.364 1.118l2.214 6.748c.3.9-.75 1.65-1.5 1.12c-5.748-4.18-5.748-4.18-11.5 0c-.75.53-1.8-.22-1.5-1.12l2.214-6.748a1 1 0 00-.364-1.118L2.98 12.08c-.79-.57-.415-1.721.485-1.721h7.105a1 1 0 00.95-.69l2.214-6.748z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-secondary group-hover:text-primary transition-colors">Đánh giá chất lượng dịch vụ</h3>
                <p class="text-xs text-gray-400 leading-relaxed max-w-[200px]">Đóng góp ý kiến để chúng tôi phục vụ bạn tốt hơn.</p>
            </a>

            <!-- Store Card -->
            <a href="#" class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col items-center text-center space-y-4 group">
                <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-secondary group-hover:text-primary transition-colors">Cửa hàng chúng tôi</h3>
                <p class="text-xs text-gray-400 leading-relaxed max-w-[200px]">Tìm địa chỉ đại lý hoặc showroom gần bạn nhất.</p>
            </a>
        </div>

        <!-- Section Heading -->
        <h2 class="text-xl md:text-3xl font-black text-secondary uppercase tracking-widest text-center mt-24 mb-12 max-w-2xl mx-auto leading-snug italic">
            Quý khách có thể liên hệ với chúng tôi qua các hình thức sau
        </h2>

        <!-- Row 2: Contact Info Grid (Phone, Email, Web) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 max-w-5xl mx-auto">
            <!-- Phone Box -->
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm flex flex-col items-center text-center space-y-4 group hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Gọi chúng tôi</h4>
                    <a href="tel:0393970681" class="text-lg font-bold text-secondary hover:text-primary transition-colors">
                        0393 970 681
                    </a>
                </div>
            </div>

            <!-- Email Box -->
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm flex flex-col items-center text-center space-y-4 group hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Gửi email cho chúng tôi</h4>
                    <a href="mailto:pickk.official@gmail.com" class="text-lg font-bold text-secondary hover:text-primary transition-colors break-all">
                        pickk.official@gmail.com
                    </a>
                </div>
            </div>

            <!-- Web Box -->
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm flex flex-col items-center text-center space-y-4 group hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Website chính thức</h4>
                    <a href="https://pickk.vn" target="_blank" rel="noopener" class="text-lg font-bold text-secondary hover:text-primary transition-colors">
                        pickk.vn
                    </a>
                </div>
            </div>
        </div>

        <!-- Section 3: Contact Form & Map (Premium Addition) -->
        <div class="mt-20 max-w-5xl mx-auto bg-white rounded-3xl border border-gray-100 shadow-md overflow-hidden flex flex-col lg:flex-row">
            <!-- Form Area -->
            <div class="w-full lg:w-1/2 p-8 md:p-12 space-y-6">
                <div class="space-y-2">
                    <h3 class="text-xl font-bold text-secondary">Gửi tin nhắn cho chúng tôi</h3>
                    <p class="text-xs text-gray-400">Chúng tôi sẽ phản hồi thắc mắc của bạn sớm nhất có thể.</p>
                </div>
                
                <form class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[11px] font-black text-gray-400 uppercase tracking-wider">Họ và tên</label>
                            <input type="text" class="w-full p-3 rounded-xl bg-gray-50 border border-gray-150 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white transition-all" placeholder="Hồng Minh..." required />
                        </div>
                        <div class="space-y-1">
                            <label class="text-[11px] font-black text-gray-400 uppercase tracking-wider">Số điện thoại</label>
                            <input type="tel" class="w-full p-3 rounded-xl bg-gray-50 border border-gray-150 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white transition-all" placeholder="0987xxxxxx" required />
                        </div>
                    </div>
                    
                    <div class="space-y-1">
                        <label class="text-[11px] font-black text-gray-400 uppercase tracking-wider">Địa chỉ Email</label>
                        <input type="email" class="w-full p-3 rounded-xl bg-gray-50 border border-gray-150 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white transition-all" placeholder="name@example.com" required />
                    </div>

                    <div class="space-y-1">
                        <label class="text-[11px] font-black text-gray-400 uppercase tracking-wider">Nội dung liên hệ</label>
                        <textarea rows="4" class="w-full p-3 rounded-xl bg-gray-50 border border-gray-150 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary focus:bg-white transition-all" placeholder="Hãy viết thắc mắc của bạn tại đây..." required></textarea>
                    </div>

                    <button type="button" class="w-full bg-primary text-black font-black uppercase text-xs tracking-widest py-4 rounded-xl hover:bg-emerald-600 hover:text-white transition-all duration-300 shadow-md">
                        Gửi lời nhắn
                    </button>
                </form>
            </div>

            <!-- Map Placeholder Area -->
            <div class="w-full lg:w-1/2 bg-gray-100 min-h-[350px] relative overflow-hidden flex flex-col justify-between p-8 md:p-12">
                <!-- Glowing effect -->
                <div class="absolute inset-0 opacity-40 bg-[radial-gradient(#10B981_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>
                
                <div class="space-y-2 relative z-10 text-secondary">
                    <h3 class="text-xl font-bold">Vị trí của chúng tôi</h3>
                    <p class="text-xs text-gray-500">Ghé thăm showroom trưng bày để được phục vụ tốt nhất.</p>
                </div>
                
                <!-- Address Details Box -->
                <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 border border-white/50 relative z-10 shadow-lg space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-primary/20 text-primary rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Trụ sở chính</h5>
                            <p class="text-sm font-bold text-secondary mt-0.5">123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-primary/20 text-primary rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Giờ mở cửa</h5>
                            <p class="text-sm font-bold text-secondary mt-0.5">Thứ 2 - Chủ nhật (08:00 - 21:00)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php
get_footer();
