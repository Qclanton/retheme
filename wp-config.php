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
define('DB_NAME', 'retheme');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '111222');

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
define('AUTH_KEY',         ',}u}EPXgH$i^m|Kh[D6m&2#84XB<TQ,%CbwiCm%4o>Sz/dH88h-d{BC 6;>{=@Pi');
define('SECURE_AUTH_KEY',  'sygy##%0iWj9M<C_^2 :^o6!uLQ@#>sSh<wCgf9ZHa+yb@#e$ddOX)*/}6Vz>%n1');
define('LOGGED_IN_KEY',    'c}*)6DklPS9*C#AY]TM|}$|]oPLtbz-1];iCB^HvZ7d^)%}|t7S$?MK8C]Y.a+%H');
define('NONCE_KEY',        'L&.]0H.%CV-TZN&8CoMyJ/7hc1~!x0#E+!#f:+Kew,SZ$*M4}cs37oSsC+axf&o#');
define('AUTH_SALT',        'aOr%H2x}y1,}`3=;Ic+Z{%[V?!?)=K9+U*}XwMw*iEM2=O-UcDQZRF{Y?<;f4gU.');
define('SECURE_AUTH_SALT', '=+f|2r-76+MnX/z/2OsYp9{,+B6<7pSO}- !<Y`qc3,5><y$5se/:}KpYhz|n`UR');
define('LOGGED_IN_SALT',   '>71_tD*7PdH#`.HVR-(>2JkU!{=n:tq|Vyu3M5PL(||~]&l#scEXBA&VU:K_P.x;');
define('NONCE_SALT',       'G(S&vfX&T|*F7Zt*n</,.N-ShZIgzyjPeC#d8T?JjXHfi9};lCY`{?iiF*O#%,h/');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'rt_';

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
