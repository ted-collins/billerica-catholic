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
define('DB_NAME', 'billerica_catholic');

/** MySQL database username */
define('DB_USER', 'wp');

/** MySQL database password */
define('DB_PASSWORD', 'SbEKDnbq');

/** MySQL hostname */
define('DB_HOST', '192.168.1.36:3306');

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
define('AUTH_KEY',         'Q+G^g+U7>Z_$3#AS5mVwI-/4)|-H%95%$P!Yf(!Q9EzefoyYsQ`dk8*fT8Yt6dlV');
define('SECURE_AUTH_KEY',  'NLsgj4#/Xmk-bMyYO.f@@_(ZSc7`5&g$L*Ku&#aXL7-)ub[_%}1Sj-tyFas.uV+-');
define('LOGGED_IN_KEY',    '^qAHMU({p|QorIK:Ul_t%%itna{gAR6K]|B=ot9+#^c0)[*#V=>0=P.*#rkb3D%|');
define('NONCE_KEY',        'Q#2sY/LDo{&<Pv3[CK<d.qB,eH7V.(OqCwL?#@ZPkghDO@3rs$jJ>-%S=Dw~d~Qi');
define('AUTH_SALT',        'f50{us[?FxD&Q]&)E9)Jf 5L2:F&`]Q+!@.}4x`<.#R_w.>D-H|Mz+Ik3EG3c+x`');
define('SECURE_AUTH_SALT', '0f[iBtEMwaO7d|k63$KO?M(r;<p{,s$ehxsL=[w5)Z]+|*WU;5;m_e|w0QyDq_L^');
define('LOGGED_IN_SALT',   '4ywhG~XJ|=h8-IBua[7Yh`F`j q4o5<8jK:ijP@-w=0IQy!D?J|$GlFEni!SF2~/');
define('NONCE_SALT',       '{VYFf6%,kB kQ./<$a.qUko|jl)k/,[bt,hj#/BFX2w2g4v!T<hTz+iR4,pA_5.^');

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
