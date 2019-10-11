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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '=(.|wrW+[ymG rIyKZE#SG j|mjNYLZAE~oO;jdWA{ckC)cIeq)4O&<}H#:}{^22' );
define( 'SECURE_AUTH_KEY',  '%c.+Eskt,wG+^O(qL.mQ5`{u#@,^aIS(>TmMi|~P(Ldv$P!x#hS69p[b7;u8D9!q' );
define( 'LOGGED_IN_KEY',    'hyjKMD;Z6Jp^,axGx3BOE;.FNU[AT6^?;GQTHcu{G9{M2@jKbB}$?G(%-_Iblz@/' );
define( 'NONCE_KEY',        '$aa:rAi9*5&u^ne!.5Q@hqW;-LK6&k`hO3hm.2f5MWYbf0$,Ucfmf+KQ(*6W_ g8' );
define( 'AUTH_SALT',        '<H!t&swYG$|Ys~-|2UzBd-:{[FW?h>{f~iuei8+[fj1Ad{q;N0r!Zx3@Xly5 iTP' );
define( 'SECURE_AUTH_SALT', '&{rU~UP9jT}ti*?H1zwHa~|&twSLm 4ecL8hIMvXo[iuB*U9KH|-(/SX w{5Ygsa' );
define( 'LOGGED_IN_SALT',   '2Ts[cn~Hj6C|u:ID9?AwbQ2GrxlTPkQN|E$OO7TgCSLflb6{Y~L4|S]mQgWVbhze' );
define( 'NONCE_SALT',       '_B+25BvcmqG9(M_<1Nwhx|G|y(5aI:0aLD>]PP,,*_)#iA:0Y.e`%5nzud>;4)xQ' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
