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
define( 'DB_NAME', 'property-crust' );

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
define( 'AUTH_KEY',         '`Fo#mH#l OGZci[;2ghj[7M!tX?jh9&X@xyH @tYD+ULQ6@ sVnA.q7K)i?G59^S' );
define( 'SECURE_AUTH_KEY',  'G= P)AZ0R{[RdkzLd{,yX,.+K^?EgyUQ0!4c(rjj9&ank~3se!bY3DuU|i1X/}G^' );
define( 'LOGGED_IN_KEY',    'NM`Cr/_mAx1s2o|5f!X +dq$FII(T@eZUwH7HsE T<>s2`U}#%K(rD ^Qhbc.ODm' );
define( 'NONCE_KEY',        '-nf4%qBxsw=nrTT{@c1gWqWjR`N %C@Q9_i(f6JwL~I]+nrzhZ 2Ng[@8Rv.x%8}' );
define( 'AUTH_SALT',        'AeE?k?:UUiu4yBW1p`mu}qr2f2V>cY1S)O~3Kg~#<M,LB=bx|KPBtgu8dycgDs?k' );
define( 'SECURE_AUTH_SALT', '5:<`z4j,fHI|,Jw_=:d1$hJ-;9<{QG;{z<;z?Gxu>^;j~2X=U]S#1&[f!6eNok+4' );
define( 'LOGGED_IN_SALT',   '-B=c^&UsKh*#b|?K^V7IF]KFm[QPAaM(fj[KIX.l${YyAwB|c?a?2&|[Vy)4fam:' );
define( 'NONCE_SALT',       '$/hK^xwsTE;G*V~fH8YH8J&J0/E&R>k.3;?pqv9I`V 6. M?B)4PP ;9NC~[*Q7i' );

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
