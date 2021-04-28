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
define( 'DB_NAME', 'first_online_selling_db' );

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
define( 'AUTH_KEY',         'BWK[OsWG~Tmw68IK_z(/ LQ0mKXRNO_u0N]6^st7Y3I.:vc/T,6W[(:(tv%bT|8z' );
define( 'SECURE_AUTH_KEY',  'W.t$u,*W^`Fi2LrK`>n:A?^{}EKz964El|dN}4N{OK,aN/C&LVJGA~kewR/V:lxC' );
define( 'LOGGED_IN_KEY',    'cm[wgnb[ 9hL=>q<Tv{um,f2t{fH%5(,@P}{GL]9Q$qqTWgRK:MT+)O+dJk(Q@!o' );
define( 'NONCE_KEY',        'QzFy`Vyty-Aw{D7p?wv ;3om}KzJJdz7z:RG#}%vN0sP2Ez#FD,YF41x](vY[@2>' );
define( 'AUTH_SALT',        'fWs<_xztpI.$VuFwE8|4-/ %=Kq.#zL+U]kqGjSfOQ.z@N*E}trQ6v?7*N^8ZL_]' );
define( 'SECURE_AUTH_SALT', '$6q7=UG`5 XX*2nyvn]sbfNXui>*&T>Zt=^n#NGK_*M4,I0_W8G}SdTZaie`x8K|' );
define( 'LOGGED_IN_SALT',   'M[| i_;:|welx*NO1_S^,@pv$s[rtIfJW[jr|mnKy..-@&|fh[YV$4SLm=D?/>c]' );
define( 'NONCE_SALT',       'swDfO[^1-sTl__|duGQ7! ~(h(H#++!qWuxTu]L>NBzb@#cozfgsD=me-#>oHt2g' );

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
