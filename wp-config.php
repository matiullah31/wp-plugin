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
define('DB_NAME', 'wpcustomsearch');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         ' 3h1yiIZ2rPFn`TZ+v>@Idj-zfmIi8< &[u9O>, jT3XlB]-<o_h<4lLy~$QqVaQ');
define('SECURE_AUTH_KEY',  'Iu|LWv8Ar$Te{.@(!^jW73us,WAe4;HpXEvh[O(`(|9uKh^|$$Unt95;g$=}_5}>');
define('LOGGED_IN_KEY',    'L:drq6XblVs.%h>^D_-Y>oIx5.64/M^#,C[.i-{Ony2`VckpUFt50R^)PV|r5z<-');
define('NONCE_KEY',        'ajGWzSd]R@XO&P?_]v%hjHY9Ss3K/YT=E!()U{)DDWGf6Xxi!4I.WG&H )_rQ(O7');
define('AUTH_SALT',        '>,</<R5v`QON)N|hV.v3_BS[O>2$9MiNE&.^x+&o[*2@O!eosUC*|sBen2pWlvwH');
define('SECURE_AUTH_SALT', ':25OpF+gvVgL1nw>2aI|p`DYu^?3#@HgfD`DwncXLf!VH^e}BW=y,s_IdzwT[#i<');
define('LOGGED_IN_SALT',   'fn:cx(!srUqYV3?b[ycrz8ST!*2Rt/sqTcn>Kw!.o`YU0h3UES:o>A#$7h{h#} e');
define('NONCE_SALT',       'g#A Mxi%n@vMf*tsGVNp~T).{7 A,DtxL3FqdQ6!EcX4MSKd6:}!,6%m86jIIMK:');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define( 'SAVEQUERIES', true );
define( 'SCRIPT_DEBUG', true );
define('WP_DEBUG_LOG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
