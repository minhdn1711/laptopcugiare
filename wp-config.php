<?php
define( 'WP_CACHE', true );
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "wordpress" );

/** Database username */
define( 'DB_USER', "wp_user" );

/** Database password */
define( 'DB_PASSWORD', "wp_password" );

/** Database hostname */
define( 'DB_HOST', "db" );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'H>jpcE^lf{_k8 f<|?8^.V.BNLjGGFbw*NVEb+l_A?Ebsl3/V=PJ9%^T,a:-86 )' );
define( 'SECURE_AUTH_KEY',  '<vdw19Om@W4?cpus!,Do0`aVfW6Sz=T5RPt@r0;.67F`K/+NAfob]1BJ>JdlI9FT' );
define( 'LOGGED_IN_KEY',    '3*=bJ2f*9nAq;0Q6H@v6KbxIbg{}(/#Rb![tHL5crlkZ3@3:_S|%:b{`lX+qc*b(' );
define( 'NONCE_KEY',        'z(2eN;X0]^C,/ir@:%S;Pq~Nj3R?`&g41>s9SA4/=nURpa*C`?hP X.}G%0Xx!F6' );
define( 'AUTH_SALT',        'n+0 daj({G~G+=ApqCv%@jGisBTnY3~[hHdUtwBn^quwBRO:Xxq)!PF7_b]-HY`~' );
define( 'SECURE_AUTH_SALT', 'Bg FUA3*ZMniR,9,Il8>DIDZTb2}A,$+SzbD*JO+}p^/uJ0yfZe<K[vZ#x#r)>J}' );
define( 'LOGGED_IN_SALT',   '}x18H0[|maqM06!Fw}/DO1H]5ef2eOGp+&M=}_2yZC>Ap8 GoQ=?1iSs?QbtXpKv' );
define( 'NONCE_SALT',       'qG9Hh64gjQ.iG21|%AZ;qrCx|:I<(3|x)9qouM9HBLPe$(2-=qYw0!S$:^7jivCM' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wpx_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

/* Add any custom values between this line and the "stop editing" line. */



define( 'DUPLICATOR_AUTH_KEY', 'FQ.Oy70y^k?dkq!<53K#fb];?YME#`;n8BO.rvD8_l:W`UNL5tw2ZuY$kB|#g Z6' );
define( 'FS_METHOD', 'direct' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
