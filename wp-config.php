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
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '123techneS' );

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
define( 'AUTH_KEY',         '~N<q9oKAo2Sd39i+~23?t1Hr)Mb8F?zGB?H@##;+#T]aWK<~9]O+Ut.B~5cM1+!-' );
define( 'SECURE_AUTH_KEY',  'O$ycFJQNG]nG;nWodORAD~Xx|nk#?(MKGE::YZgH7[$dMH+urciA^<N:fr[B^03E' );
define( 'LOGGED_IN_KEY',    'h!=8:s7Q`3A3xo,hR:T>]BF[?&Ea<sd{=**Y,ii^tzq)t6BUWumdF)nsbJT [x&[' );
define( 'NONCE_KEY',        'fKQ^L.V?NR(syT:5ZC^3W[8=S:L]gL|XnGy3R/v),hl;Xos8d$L!,pz?#uG73Vvh' );
define( 'AUTH_SALT',        'njc^ $fi[k$Ri?Q3#g3S-!MWi5*O2A+hq@;`,yMvX8I?K{q~PcgKD5@{$DgQC<B5' );
define( 'SECURE_AUTH_SALT', 'BhfR^x5PrcPeVUpQ?XsO{,Xp)vXRW>;_UmNXzD!-jiv!5L{51<JV_,cOO|Kv`6vQ' );
define( 'LOGGED_IN_SALT',   '*Lxj.U*6#E38N =mP*/Acr&qkEVEal!=CkLEr)g<m4_s7&><.+efj-Jf+Yd%dQC!' );
define( 'NONCE_SALT',       'qYg3GDQ$KDA>E~y9QNX35ts+:DjRw t)iZ3j]C8?!|v3Ri^[U1s<i*)0]W4b/D9~' );

/**#@-*/

/**
 * WordPress database table prefix.
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
