<?php
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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'omeo4');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '= /4`4XH=nEfkJ-+n|`&X3Ruj}0XSts!}q_wK,H;ys%6d=Zky.,JuL>)c&tO3q6*');
define('SECURE_AUTH_KEY',  'dsbMwMGy<}ed,.H4_6=^f th]Aa>]<]XeY]J)]?ylnfqb[_|h6m) a0;OG;l3Lk7');
define('LOGGED_IN_KEY',    '5~]M&xli&2nfz~=,?4C%)M_UoOzvSB8}HnT88fc^:Pjm4L?>h<[f3Pn/~B=<Q{%G');
define('NONCE_KEY',        'ec}Wa{J`gm0EY+sRl=v?9dGdx#*xCZf[F+]-t%$_$T)*O4-!DXF{PzWG/9SX*9p>');
define('AUTH_SALT',        '{?!LPXLpBEa2.RmeWY7Z7E$YW{OCL#iG:2RBpCF&Jp0a5fTo.`@%=[-{2*>JvMrI');
define('SECURE_AUTH_SALT', 'K8FR$!3M`le1HLpn2fa-vfaQiv$4-r{sJdVWHKFp1J2GI^!_kV/MAa65d#~/{gTo');
define('LOGGED_IN_SALT',   'jag&=KeH}$oU1oj--,c.IRErFt`yUV, W8OAlivF9h6bele$F*ssq=RJv=>TRG!^');
define('NONCE_SALT',       'yMlO9+}fs$)S3d+<tj32R yJ;@!aHE#_Y|ck<7miJ1Wz`=:c?=KkYkP.wEAueN;@');

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
