<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
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
define('DB_NAME', 'wp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'lj}^~HV#I@%`g]rYhQugzIsk,V)({-U<Ob&q|&3FAk~b_}I``z/$8S0h8+a;wdx(');
define('SECURE_AUTH_KEY',  ']!O?M?L1wR MjM;y}nS2)bBC1cKk1M?dUJ/zOk{+(Y+](3k@a,p!/{V-)%pd!0<)');
define('LOGGED_IN_KEY',    '_,d@jHNw+4?KH%yp5B9-;sdL;T0+9-W?(0,k=S|?WyaF!34-9D|kHw#Ny5As:Zy`');
define('NONCE_KEY',        'LSb~q-A/,QdVg,u1BFc9A7.s9t:MP6C|L@vb4nZp:<]RU^>DZL58sf&Ux2P-dt Y');
define('AUTH_SALT',        'uw/!F]0g(xVV @S{eJ)cgY#y6j.ZrF`R_T!_qjbxZmCJ6_#/ozE$A:o+M:#R|el-');
define('SECURE_AUTH_SALT', 'eQS{&]ZH0P/CbkJ%#CH;XR,/D@fDU|aN#:c15i/pJyMAtc~-APrHUP`Vj~o?N?:C');
define('LOGGED_IN_SALT',   's!rx1=sdvA/)q[@|t2-7Qn4RL-[G)nORGj7Z-GUD;T<ntqinBOmacyo7]kspwc<J');
define('NONCE_SALT',       '9pgw [pu-VDl.aNAB${PH.%W+yQ2+Mg{Ty[g7ikZ=ut4Yz(+MFo1V=cf/j)]qyQ1');

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
