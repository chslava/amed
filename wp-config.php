<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

if ( file_exists( dirname( __FILE__ ) . '/local-config.php' ) ) {
  include( dirname( __FILE__ ) . '/local-config.php' );
  define( 'WP_LOCAL_DEV', true ); // We'll talk about this later
} else {
  define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
  define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] . '/');
  switch($_SERVER['HTTP_HOST'])
  {

    default:
      define( 'DB_NAME','dig_amedical');
      define( 'DB_USER','dig_amedical');
      define( 'DB_PASSWORD','8R7bRuWa?ReS');
      define( 'DB_HOST','localhost');
          break;
  }

}

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'V9)1Ba|HTN ev.L&Ne6JR~b;uCuo r]0/,OaGYH)Kz|ceoqj: pWO)6k~J9Hm1uI');
define('SECURE_AUTH_KEY',  'L7LE2RW1$l}?=lcup o_kI{zp>z0p1hPS4acw8{npW6utd ^GKK74II~!Kx@c^m1');
define('LOGGED_IN_KEY',    'X1I]h~$Sr^gfD5]Ne`7S.SkE}<owg&/:pD-)*<U2(z7{D@VGtx$U>OMOVXqT2H7H');
define('NONCE_KEY',        ':K7p&]Pk@OD4i,4lu8h/?Jmw<Yk #FI;tj#[$hVI5~1PXw74,Kf1{Ab[brkT-G_L');
define('AUTH_SALT',        '>P^AY5Srz%+3Z,/als>EB`lzvV-SqO6-zm$oiA5cr=Szp3m-7|3(U1rpgg.dm(n$');
define('SECURE_AUTH_SALT', 'eY7)O6={#K}vEPP6>OTCZ=,&yx5~-OF{mpTBXC+bc;p+C~j?w1dn$YSDJ=KCWJ{4');
define('LOGGED_IN_SALT',   'QHE,j,gl=oIN{zbL!Zvs>DYdj/#u8,sp_1$3DZxq]?d?r5vgCus`2{vO!I9^frGi');
define('NONCE_SALT',       '-&n)nlu.<AaR:v,MD%~t+f3?of^|iw4aS7T<.RJywmv!0;[4FUm*9hig=|<>-?.?');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
