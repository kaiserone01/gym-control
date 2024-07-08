<?php
define( 'WP_CACHE', true );
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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u593366054_sITjl' );

/** Database username */
define( 'DB_USER', 'u593366054_0VU6B' );

/** Database password */
define( 'DB_PASSWORD', 'u593366054_Gamarista123++' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          ']um>{j?{a>iH*m$5B-Q+tutLFycXe{xK6T|YTwBQq1VS(}V=u#M#iL]o0jDg.3wh' );
define( 'SECURE_AUTH_KEY',   '1:H+-G=3A&rsbT-,|$PKCL*^[0d27tyYBfjO)vKdJGvLB4B U7=>[qndKk7q#,$b' );
define( 'LOGGED_IN_KEY',     'pVJUT!`7tB;Kl>;{rmU IwE_4v=d&$t(#bU-uc=s&iN,}^.EF8dmSey*3lqt}i%E' );
define( 'NONCE_KEY',         '}R5@%LP=R(DE8x6>dsh`2En;cf78b5AmF5;Uk9v35Ap{58$gJK.= F.eoS7_P:0T' );
define( 'AUTH_SALT',         'w)1baUN-4d,/L>Dkq_JV8FxlcD[Y4_|X-kp8ZuVqx2-f3DoOOoAT@U@jvD4]o?rl' );
define( 'SECURE_AUTH_SALT',  '+xa|`Q0%Y.y`=Z=HZ#!/W1tm.*3oSJ7I1K!D<9{_ f:8-Z:mn=6iz(iQai NcZ+2' );
define( 'LOGGED_IN_SALT',    '9?wb;0v8WxJ&@8iQ09 }c`a}:^$fD#6-hn^H* tFJ|/.tAK*n5]UJ%*U=V?<XU=E' );
define( 'NONCE_SALT',        'ss2BHA7?BH_HrwBwp4j^Jm^/T$GK}(Y0+<BlA#qiSu-^6q}-T&ys5.X)}0]}!`DR' );
define( 'WP_CACHE_KEY_SALT', '%F>-YpRe({jtqW{D~{2ULyp&It3^hXokdP+$_(@uf:H_4C](#Simr:(N5$71-xv7' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


// wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
