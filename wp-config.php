<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'kapo' );

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
define( 'AUTH_KEY',         'Ul|L9tw<SLV$!-HRu2B$W,NQLR?7-{~c5X_mm0gky.4]v,.FuV@|J@! L)or_Gea' );
define( 'SECURE_AUTH_KEY',  'f5Qofv#Z:6_8/<y|g7 JU{JH:<qf9Oo2kR 6$lju0KbS|_2Wv#5$,v<|>ow2Um-o' );
define( 'LOGGED_IN_KEY',    '4>x6}G9(]mXT; MmXkX2)Y,UDbh4Q,3?0Ftn*,&Xk/*BZn/FhbhT4WN^&jD)a=bg' );
define( 'NONCE_KEY',        'B7UX-Jj PoV_lQyr(ve%&d}F^UO#hgHV+Gl.iH+L+QC$J=Q-]pGIXfBc)C!W.2GE' );
define( 'AUTH_SALT',        ']+NA?2Oa:ovde1-p>6%J#-?^i=#o1]_/EVi}?M4=]]MmH6_FSx>TuI{r9NK5jNA7' );
define( 'SECURE_AUTH_SALT', 'p,]wa(o0>VP=ae]{$3q)oOw.ZDn5!O46`yqf mW%Ss7)T$(#m2JYX@3)HgWX,BxY' );
define( 'LOGGED_IN_SALT',   '/zqFu~w0=?Y<vLX}+-e:NubF1!/zc3vd8-Js({Zb!adrR}oU`IE%J[<;B!Jyk<Hy' );
define( 'NONCE_SALT',       'maRq2?jLC>o0wK]8z@+5Eg l2X=Yipg?b]E%)$`>h14h~4?[;AsPwZ6y_]a D?63' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
