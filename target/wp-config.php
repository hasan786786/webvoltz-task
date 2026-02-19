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
define( 'DB_NAME', 'wp_webvoltz_target' );

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
define( 'AUTH_KEY',         'f&MBj+.>_SX])_OY&uof/!q`$7rAGr2hw=)/xxl?pyT>)pxM=de#_vqR5FL{VEPA' );
define( 'SECURE_AUTH_KEY',  'aagsqhk<I<Q*A2~;:Ved(5eI/!7^lhD.]k^)ero]yarCb-Nuog<yCZ,JDgb:+70_' );
define( 'LOGGED_IN_KEY',    '$xM0$OnmXbHjeg55DlzA&,dfAaP?v^}z{F^g1~QFG/O)}u.Rj_94r>T3BVT2JB%H' );
define( 'NONCE_KEY',        'Iah0zXPs|9^VAcJuHmR[P?Vo+7FkipFYlI@vldMW(?B7l|q_}y<^`j3g-:X4NbR3' );
define( 'AUTH_SALT',        'e[2/C9rz2DS2RmBCAC@}.P9Q!~_#/mA[g^*~7H#<UE[/xHB,(F$XC?K n3REYQaT' );
define( 'SECURE_AUTH_SALT', 'CP/[EqT0LfZ4/4Or@`OL#YE:gX|ZY3|U4X`8{BQjD0Ljcj`dm,F?JZ<1ws-tM Q?' );
define( 'LOGGED_IN_SALT',   'kQE|Cam ]Gu>J>=Iq1OUG<-[QX;nFHl+nNgjO)NJZ]4rz F1wzTm5;`Jb0L8$eo+' );
define( 'NONCE_SALT',       'kljM4O|>Z@tA<Y+MjNNqbDj._I/_.-&l-h~44bp`hI_|pd2^|B<v^uXzlOe3cW{U' );

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
$table_prefix = 'target_';

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
