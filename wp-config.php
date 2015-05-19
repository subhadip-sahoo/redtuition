<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('FS_METHOD', 'direct');
define('DB_NAME', 'RedTution');

/** MySQL database username */
define('DB_USER', 'RedTution');

/** MySQL database password */
define('DB_PASSWORD', 'Reg$56$#');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '`+Lc^:8mH<Hd8C{Xjq(tSJ~(r~58Oe=9Rod7qaS&?,+V:eiSf#OI;G(>xod2vIyj');
define('SECURE_AUTH_KEY',  'uJ3gj6`a`mI1jK,OKP^}EjmP>I_gomMr?TaC{Rv4$Ldl*M`/9G0}DET&M,/V];D(');
define('LOGGED_IN_KEY',    'zJQx/<`O$mPtt{PSe!~MgfjU_7^+T^8? ]`6+b(;>zpQM@{<h$AC[L5_Qy tYSTB');
define('NONCE_KEY',        'o&Fq!`rC,Dwj!8zF]T`gfV71!0}5f/s%E2XA%2XGLy/|.7q>;MUR~xr#<t$,xYCR');
define('AUTH_SALT',        'AIB}u@2`}C{rEZ@x9C2w)x5U*/z(;clbw(w{2Eb}kho^&MIB^w>uRxm;%-0t.X,V');
define('SECURE_AUTH_SALT', 'MGnVpZDY`42g=IxT!<h_K{U)Ve|hH#[Rg[qp(hg<[;B[`[~x@-Dm:qHE7B0O(qNk');
define('LOGGED_IN_SALT',   'Y7QfGr>%lSJUbj6)CmaZQIir.D:)V[t+G>(^zFKd9FFSrO!5h 8t,=<}DB$cA;O}');
define('NONCE_SALT',       'Z`mTF?Wmj;{^|+YD9;&{]~rciHi|s|>|sFIdwpqD($*,{B>5BOe0]JS14]_jKPNE');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */
define( 'WP_AUTO_UPDATE_CORE', false );
/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
