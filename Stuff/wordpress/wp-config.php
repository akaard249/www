<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'edudb' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'U[L{P`YLpc)CF4.%i_UG>E-aRH:*JZ8>tJu +.*`zLt|3m@jv)oCa7Ts*YM.WH-B' );
define( 'SECURE_AUTH_KEY',  'k^h{U4BQj^;lT$dj?O,y~)v6EOxot4rt6$Z&NTE,(8}RnoB?N`xB.?QC.)&ppBsH' );
define( 'LOGGED_IN_KEY',    '31+J#@@tf>`}K]W|fqbk#sjGx[Wwf]VZdV7K.B3+j@Exzh@>8}@HXM2PM2@bnT-o' );
define( 'NONCE_KEY',        'NG}G3;1Dy=fclOo50)J/a/3z)2PVHqxg2HYd(,v1Wn.13vuxdq0#qJ~ >2Hi99>*' );
define( 'AUTH_SALT',        'S)7GX/zgY=6BdSqS47 Vwii.WLku]y(Z5p|DvR=F sXnVdDA|(^6z&rL{RM`rMNV' );
define( 'SECURE_AUTH_SALT', '~1}^Kg/@QVR&veC4at2n1G1o4M&*LDtu8]PJP49psBV)#PzXl{)f$QY)~3SNLekL' );
define( 'LOGGED_IN_SALT',   'wXMDEV9ysih!g=+gtx{X*Tx9fT|Nxvd)Jc4pY3qu:9`W>V*W#P*O^*.},YC|#pdQ' );
define( 'NONCE_SALT',       '%YWJ:>b;7(TDSu8ySsSn)=YJ^Onc*p/*1gSz`E>!MY2-Yzh>9m5SE!GaR#E=5?R;' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'edu';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
