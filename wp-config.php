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
define('AUTH_KEY',         'T?`<^L>,zVmB/D:]p>I)-fP|/58o^(YGL[+M+wM{:6k?3G1hH%sWt.J% /|ZxdNX');
define('SECURE_AUTH_KEY',  '^y+#1A/IRi[:ju,%O26Gdlgt(TG+KC=-`O>xA0{:G-|B|oxOmk7A]!AaRYMFrV-|');
define('LOGGED_IN_KEY',    '5o5v.X?dx.i+x.t#n+O+(c@w?Av93Cha+^D `)BYx}P:SeOZiXpQxH{uPH!Dj++4');
define('NONCE_KEY',        '/eV}qD28{V1v#~l_^G51EstLIBR1?%4P+|LnZ8VNrvm5Yehc[>gICB|,=- <GdvV');
define('AUTH_SALT',        'GEv4wHY|q[9W<ah_1S]X6OmiEu@cm81L5=3]Z[FPdW.|?9)#]05!qZs 3oz@bI}I');
define('SECURE_AUTH_SALT', '2|CT__Z8MaoDvPh,yTfb_ IF:xxm+Rvl4W!v&O~Zq,8XT#<r?Bo^_d@3PEPJ3r6#');
define('LOGGED_IN_SALT',   '*U|qo]dGz_XTdg<3O7n>p,|5uh/~d-2MI)X1gA62-r-E#J({7oB$kAZrKy>?tJK2');
define('NONCE_SALT',       'f&qJw.46(&%1<S1Sr1zWzp~nkbc-=XbhCXmf+!:mLvy+W,r;Q0?+U{OSvUN6M;P5');

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

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
