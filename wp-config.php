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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sps_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'T/DXBt6VLK`YRxvA7oLb)%5D;iW WGV{uq.[ )^|}16E4roB6dMRz&R.>Fe]Ve%y' );
define( 'SECURE_AUTH_KEY',  'g8$d|O#L^a:q{i?1*CC8Wk|%Z-!|#UQ=z>NnoG~T^f8tG/Z8g%fYns>z[+R(6}Q7' );
define( 'LOGGED_IN_KEY',    ' bo(UKF9M[mLLEURyT<V$N:_K`~jcGwg<tt RDO|>iItt6rlsw4pR^^Rqal}(pJ=' );
define( 'NONCE_KEY',        'oj@pZ`u2h5u)ZDN}}*Io7yfvDT=.k3QR}+We-*leZ4V2?omcL(|{x`00^qr}GE/.' );
define( 'AUTH_SALT',        'P9?!|efVm0MGYp?POOa0bLRlzc??[XtMj.t#CRYpw;v$yoOXKi_(o!lmj9h~^i>6' );
define( 'SECURE_AUTH_SALT', 'fg/[Por%ER.cpKp`f)_Ub>X<@=bDM`J38Csj Z@ZCcCz_b^+7&^?_u!Rj(0$X>b;' );
define( 'LOGGED_IN_SALT',   '15aa$ddWn,UY-J!-KYMuvcn]M:B*(~;da~a&nDg+CS4iG&8`gqfMV6q%r+aa:A)Z' );
define( 'NONCE_SALT',       'aCxv%,/a!me-Ad6hE).0-Q[kL$uyyV$6o2M<WCKugP(.:+;.|FJ!Wo?ijs6QYF<O' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
