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
define('DB_NAME', 'nikmelhd_wp1');

/** MySQL database username */
define('DB_USER', 'nikmelhd_wp1');

/** MySQL database password */
define('DB_PASSWORD', '&!qvZ&*g');

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
define('AUTH_KEY',         'h9B;f+N<r@[I6LpEiDuo>D5C&4KX+ZI~LQ1jFt^@%]@GvV)hh0y^JN-gILlq;X<j');
define('SECURE_AUTH_KEY',  '/fdH/.8@}l0cx#h#QW>>5v#u1 DgG!2RJI|a_taUER4$e1iOgQ~_,6e`VZLB/7>~');
define('LOGGED_IN_KEY',    'NB578EPy|8)d*}KkS(ct[ HHH `~L(><Sd^oEGsV%~unKpi.[b8O2(kY2&T)PW[&');
define('NONCE_KEY',        '>B*y+:mR6.1CQ7J=jz<j*f},7C-zKu~.51CN/5DQ(y?+6WgT6+0Oqokdv$x*7/]p');
define('AUTH_SALT',        'DA.zgg)hB2R0JfXU=_^T!#5Yhfw:6>Sl0[VLIy}+l6|Xi(gWF~$6^@<$v=*HdJ}L');
define('SECURE_AUTH_SALT', 'YEWf[E?4xS`5@bRhbK}=i7I^Q:E2]nwxY7dz#&gc]I`j;)@2,Gu7.&T%I4l:>MV.');
define('LOGGED_IN_SALT',   'o1v_UQk/VS*/U`Fc,4VlA$OkJ=l]3^DKP}1W|)/Ma0@F%.! zD{,^@.Ei@OAHmoQ');
define('NONCE_SALT',       'wIW%L#imqa2j6qpx5}SLG@C1=/ tH7=+ZV[LJ^,t7]d`*=-I|FU}dFH_FpKe~ShL');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');