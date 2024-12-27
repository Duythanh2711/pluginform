<?php
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
define( 'DB_NAME', 'dhmo' );

/** Database username */
define( 'DB_USER', 'dhmo' );

/** Database password */
define( 'DB_PASSWORD', '123456' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'rJ+8._#eD1H9-U9sCz|Um;I$yQi,.0,`o1`m%c2*0>z[vh_9n;$ %E,Fu+O:so)m' );
define( 'SECURE_AUTH_KEY',  '$u Zbe.h@c3OA?@FcCmMJa)L,Si1ndw?EZ33WnKZ) p`E+(bRsjv},fH?gf3)`vG' );
define( 'LOGGED_IN_KEY',    'T;el=A~>{]!5b<t!JtR(uvA;!qXbGiIE+szSEuV1^m[u2KoH)X)jP7>:QNQw;*N/' );
define( 'NONCE_KEY',        '6JM`j+G0b}.bVaKc_!O4IZBzjfU<NKebY.^E(Q:3[>CSAfo}}k*8Zxl*YOiD=3Vs' );
define( 'AUTH_SALT',        'sXX+h%GbpWG@Yq57ea!uquW#otpB=J+=8{pGN.q>3?xCaRrKsKz9TC..C vJ|tR<' );
define( 'SECURE_AUTH_SALT', '6b}GL{I*}d~):kgY+jzY,b(;;^8l=[wa(ziDksbCjO9~F~uq_@*L5Poc^m2_c_l|' );
define( 'LOGGED_IN_SALT',   '/zh>3lsY+O?Z)X$Ud4Qu?}>s~R%&=IT}))F3?e!k}vUM8ZrwfWcZAf[EIC<^(HDI' );
define( 'NONCE_SALT',       '4s*np#8=F%{Mcc|k;<S(W,X7_Q^puK`bFw$?O@5/xRUw+)]Ew/tdzP#cm+AKhn7]' );

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
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
