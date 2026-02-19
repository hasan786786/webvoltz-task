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
define( 'DB_NAME', 'wp_webvoltz_main' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'B$8H;.fVu)L9(e%?/wZ?(*E| @_KwAI1ODqn[>H:0nh,)?#|o6NWqj/1v^I._lb(' );
define( 'SECURE_AUTH_KEY',  'D$M3##pZsQT&eI>i*[2C8L_S8_K-8jmnUBdO5uETCe.B5hU#-#^,a-It~3LSWI1?' );
define( 'LOGGED_IN_KEY',    'g^tyz[H<&mY*.@eI4B:<[OOV>Q`bycn%AD 1DFi*XCRu$KjLfNI>#i,**3qY~:l3' );
define( 'NONCE_KEY',        'kh4m[9.,&#VeXum#fJ}!x/#Wm~nC.s{Ji^lQAx9[,i k04HsSOrx7yrtWr6VMO=s' );
define( 'AUTH_SALT',        'dy#50N%_DGXt|`Zw(v:&$9V8IE*eJ0sP] hhT33d7}7?_l;*O2]<BL6pC<9fe@c_' );
define( 'SECURE_AUTH_SALT', '8}W~tPqz28 0Ak2B^aE&TlG !nSestYm&Zv#k*$Skm;D_rMRz*rOCsrFCl-m[5|(' );
define( 'LOGGED_IN_SALT',   'ken+Fzv4=I+H)Ii[!U!rWV40-];Mpb2vcY3=Q`vw5IRYy&+np`5!{m4.D@Wpmw2Q' );
define( 'NONCE_SALT',       'J7YBB||lUl(~2jB/?Ks s*|26%zIhS_8W9n:)rR[yV4u[kxHt}VV3ZHM6A$zlaju' );

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
$table_prefix = 'local_';

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
