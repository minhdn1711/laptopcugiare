<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see              https://docs.woocommerce.com/document/template-structure/
 * @package          WooCommerce\Templates
 * @version          7.0.1
 * @flatsome-version 3.16.2
 *
 * @flatsome-parallel-template {
 * form-login-lightbox-left-panel.php
 * form-login-lightbox-right-panel.php
 * }
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
do_action('woocommerce_before_customer_login_form'); ?>

<div class="form-account">
    
    <?php if (isset($_GET['action_account']) && get_option('woocommerce_myaccount_page_id') != get_the_ID()): ?>
        <script>
            setTimeout(function(){
                document.querySelector(".nav-top-not-logged-in").click();
            }, 500);
        </script>
    <?php endif;?>
    <?php if (!empty($_GET['action_account']) && $_GET['action_account'] == 'register') : ?>

        <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')): ?>

            <h2><?php esc_html_e('Register', 'woocommerce'); ?></h2>

            <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?>>

                <?php do_action('woocommerce_register_form_start'); ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
				</p>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?></label>
					<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
				</p>

                <?php if ('no' === get_option('woocommerce_registration_generate_password')): ?>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                        <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
                    </p>

                <?php else: ?>

                    <p><?php esc_html_e('A link to set a new password will be sent to your email address.', 'woocommerce'); ?></p>

                <?php endif; ?>

                <?php do_action('woocommerce_register_form'); ?>

                <p class="woocommerce-form-row form-row">
                    <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                    <button type="submit" class="woocommerce-Button woocommerce-button button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?> woocommerce-form-register__submit" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
                </p>

                <p class="woocommerce-Register action-register">
                    Nếu bạn đã có tài khoản, <a href="?action_account=login"><?php esc_html_e('Hãy đăng nhập!', 'woocommerce'); ?></a>
                </p>

                <?php do_action('woocommerce_register_form_end'); ?>

            </form>
        <?php endif; ?>
    <?php else: ?>
        <h2><?php esc_html_e('Login', 'woocommerce'); ?></h2>
        <form class="woocommerce-form woocommerce-form-login login" method="post">

            <?php do_action('woocommerce_login_form_start'); ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="username"><?php esc_html_e('Username', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine 
                                                                                                                                                                                                                                                            ?>
            </p>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
            </p>

            <?php do_action('woocommerce_login_form'); ?>

            <p class="form-row">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
                </label>
                <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                <button type="submit" class="woocommerce-button button woocommerce-form-login__submit<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="login" value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"><?php esc_html_e('Log in', 'woocommerce'); ?></button>
            </p>
            <p class="woocommerce-Register action-register">
                Nếu bạn chưa có tài khoản, <a href="?action_account=register"><?php esc_html_e('Hãy đăng ký!', 'woocommerce'); ?></a>
            </p>
            <p class="woocommerce-LostPassword lost_password">
                <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
            </p>

            <?php do_action('woocommerce_login_form_end'); ?>

        </form>
    <?php endif; ?>
</div>

<style>
/* Ẩn giá trị email nếu được tự động sinh */
#reg_email.auto-generated {
    color: transparent; /* Ẩn giá trị */
    caret-color: black; /* Hiển thị con trỏ để người dùng nhập */
}

/* Khi người dùng nhập vào trường email, hiển thị giá trị */
#reg_email:not(.auto-generated) {
    color: black; /* Hiển thị giá trị bình thường */
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const usernameField = document.getElementById('reg_username');
    const emailField = document.getElementById('reg_email');

    usernameField.addEventListener('input', function() {
        // Nếu trường email trống hoặc chưa được người dùng chỉnh sửa, tự động điền giá trị
        if (!emailField.value || !emailField.dataset.userModified) {
            emailField.value = usernameField.value + '@gmail.com';
            emailField.classList.add('auto-generated'); // Thêm lớp để ẩn giá trị
        }
    });

    emailField.addEventListener('input', function() {
        // Khi người dùng tự nhập email, bỏ lớp ẩn
        if (emailField.value) {
            emailField.dataset.userModified = "true";
            emailField.classList.remove('auto-generated'); // Bỏ lớp để hiển thị giá trị
        }
    });

    emailField.addEventListener('blur', function() {
        // Nếu người dùng không nhập gì và giá trị là tự động, giữ lớp ẩn
        if (!emailField.value && !emailField.dataset.userModified) {
            emailField.classList.add('auto-generated');
        }
    });

    usernameField.addEventListener('input', function() {
        // Cập nhật giá trị email nếu chưa chỉnh sửa
        if (!emailField.dataset.userModified) {
            emailField.value = usernameField.value + '@gmail.com';
            emailField.classList.add('auto-generated');
        }
    });
});
</script>

<?php do_action('woocommerce_after_customer_login_form'); ?>
