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
define( 'DB_NAME', 'wp_bli' );

/** MySQL database username */
define( 'DB_USER', 'minhhp2410' );

/** MySQL database password */
define( 'DB_PASSWORD', '2016f2p258479' );

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
define( 'AUTH_KEY',         '1-|1DqsW{M|(}?T;Nj5uEIZI0D>Y]ui1Q$at1jZommVa1H) (K7YWjF,1e:{AkcI' );
define( 'SECURE_AUTH_KEY',  '79#r_PLgtHCk{D}S^7Ym`2b@}zc;*n:%@<Phk}(UUA-ak+n}v[=9q*[7OoF11o{4' );
define( 'LOGGED_IN_KEY',    '5UReLlE [SIJme)9-5=S#54TW1[!=AsF G^P[sOzY|KDd+|^NRJa$4EN 5DKg!D4' );
define( 'NONCE_KEY',        '-HxhMw<Om/XN*YObVz-,jX)ek!)KgFE(36/|c9]q.4QT(T~bph$b2`,V!|}D~%1p' );
define( 'AUTH_SALT',        'TUj~vJS])tXHg(X=PCr1J3MfY-sIzF$t>Cc0]++Aat)p-lA?ARv8o``d~!CwNe3H' );
define( 'SECURE_AUTH_SALT', '.<4dyl`*5(ohJ@I_B#L5pRukK9VF%YuXuNf8_^_/^!@LO,HsJ  E`&5d7=dgV?83' );
define( 'LOGGED_IN_SALT',   ')C -80:}3|8`v21A%l<,&>UJa#K2`V1,Sl8&W#, K<eQZ7K*s|R/S7R1D~POfYxj' );
define( 'NONCE_SALT',       'Glsr U0)4}e,MvfygMPgu-G8M1r}u_%y^N`!;L*F_IqDp;WmNfxDjzSMIQnR)g<{' );

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
