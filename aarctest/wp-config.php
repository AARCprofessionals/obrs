<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */



// ** MySQL settings - You can get this info from your web host ** //

/** The name of the database for WordPress */
define('DB_NAME', 'aarcTest');

/** MySQL database username */
define('DB_USER', 'aarcTest');

/** MySQL database password */
define('DB_PASSWORD', 'aarcTest');

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
define('AUTH_KEY',         'JY|ySH8R.taG5s-jPo!fUZI~ruJex(t3L3A-me[|8+~* NA@XFG;iDtN n47c|M[');
define('SECURE_AUTH_KEY',  'S8$xOZUn-XV,PqhhVKeQuWyptY2|p^E#`.~OKd4HUw8Cee-% N;b>)5w~X{2^nQ!');
define('LOGGED_IN_KEY',    'sXg*C1r><R*&gTjHalUhBbg|_4tQ[ ~Tc|J c[)ls$VObf$FQKrO-CGH[.E0cD+Y');
define('NONCE_KEY',        ';@6+@_@1s?q4$Zy>qxJ018J-E+/2u.,rXe-KF.R<40#Xh*XPn}|YG`_9Eg~a6m%M');
define('AUTH_SALT',        '`gacnmv|Pi[;7{]9v(-+lVdRYA9]s.X`.K$Y4LuLTF+a7|k]49=Q|W;/:Ok+g?m7');
define('SECURE_AUTH_SALT', '2(v-5;4?N3x`[^oNm%rf_d*%Rppww>+.j*lUL_yQgH!~=_kKv{ORgQnu-EFQ0e|:');
define('LOGGED_IN_SALT',   'D7^X:tm67oWY-Nr$yhhCS,>k71`ykMtA:NTRBaBRJA{b &~#<f8[0?c:|?v$lPWs');
define('NONCE_SALT',       'o4[Nf8R+D<y`i]RKo/5.rcl.x%s`(ah|J!%N^T3.D#,Y.]x,A+_{/;8s#&q3DTDW');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/* Define relative URL for wp-content folder */

define('WP_CONTENT_URL', 'http://ethics.aarc.org/aarctest/wp-content');
define('WP_CONTENT_URL', '/aarctest/wp-content');

/*
define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST']. '/wordpress');
define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST']. '/wordpress');
define('WP_CONTENT_URL', '/wp-content');
define('DOMAIN_CURRENT_SITE', $_SERVER['HTTP_HOST']);
*/





/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');


