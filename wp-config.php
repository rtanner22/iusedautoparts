<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'rtanner2_cpl');

/** MySQL database username */
define('DB_USER', 'rtanner2_38');

/** MySQL database password */
define('DB_PASSWORD', 'e9!R7a03raa');

/** MySQL hostname */
define('DB_HOST', 'qs3505.pair.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'UMlVx1P-n&C#t+V{B+injr5f!.[|_U!8oi::j])^R|[B+TxYue=.O:t!.UO6[t5:');
define('SECURE_AUTH_KEY',  '-!)@c)icp_(O>*|Z@|E1{%gxQSv@V(Gjj*{Aa&u{:JtB+.XXDrBh5k~c:SbEjJj[');
define('LOGGED_IN_KEY',    '+VffdQ+2/lR{@]m-C]4>6LnLR`YDk2-OzM+ljo5R)z[)%3_Kw8!)gQamjh:{044:');
define('NONCE_KEY',        '>}kRZ_FP/|dQKjm{Y(y)]%M%m=ORMoHnGYA*|OimbRNHz,Ui4g>Vc4Mj)w{zqrPe');
define('AUTH_SALT',        '.ij>[t>7!8$KO&&aUf|w$MwRgy4z#YsD+|J38a`)dM dl7%$mQ5Y8$+FA_.5Kwf ');
define('SECURE_AUTH_SALT', '*8~Uw2_K7aA}C-gE$E2YWo[(N2|S1H89Td#2R-Ai-c6;}HB=|X,l,o|1+7Bu^SMs');
define('LOGGED_IN_SALT',   'YF|7=Cq<~Vkbw|^1$YmRY<pu4{c_p%ki$.Y]&<yDf<_[ Su27.47<&qMQtZyb!Fi');
define('NONCE_SALT',       '2)9 (2N(IBfYyXsj@Yhm%+CV}2gMJ|W|sHiksp51@3}4TD#n[dm[QM7l;Ezn#wZ[');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'iuap_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
define( 'FTP_USER', 'rtanner2' );
define( 'FTP_PASS', 'DN4uAqHS' );
define( 'FTP_HOST', 'iusedautoparts.com' );
