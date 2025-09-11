<?php
/**
 * Modified wp-config.php for Heroku deployment
 *
 * This file contains the following configurations:
 * - Database settings (using Heroku environment variables)
 * - Authentication keys and salts
 * - Database table prefix
 * - ABSPATH
 */

// ** Heroku Postgres settings - from Heroku environment variables ** //
$url = parse_url(getenv('DATABASE_URL'));

/** The name of the database for WordPress */
define('DB_NAME', trim($url['path'], '/'));

/** Database username */
define('DB_USER', $url['user']);

/** Database password */
define('DB_PASSWORD', $url['pass']);

/** Database hostname */
define('DB_HOST', $url['host']);

/** Database charset to use in creating database tables */
define('DB_CHARSET', 'utf8');

/** The database collate type. Don't change this if in doubt */
define('DB_COLLATE', '');

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 */
define('AUTH_KEY',         getenv('AUTH_KEY'));
define('SECURE_AUTH_KEY',  getenv('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY',    getenv('LOGGED_IN_KEY'));
define('NONCE_KEY',        getenv('NONCE_KEY'));
define('AUTH_SALT',        getenv('AUTH_SALT'));
define('SECURE_AUTH_SALT', getenv('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT',   getenv('LOGGED_IN_SALT'));
define('NONCE_SALT',       getenv('NONCE_SALT'));

/**#@-*/

/**
 * WordPress database table prefix.
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 */
define('WP_DEBUG', false);

/**
 * Heroku specific config - For S3 uploads
 */
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' == $_SERVER['HTTP_X_FORWARDED_PROTO'] ) {
    $_SERVER['HTTPS'] = 'on';
}

/**
 * Define site URL
 */
define('WP_HOME', getenv('WP_HOME'));
define('WP_SITEURL', getenv('WP_SITEURL'));

/**
 * Handle SSL reverse proxy
 */
if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
    $_SERVER['HTTPS'] = 'on';
}

/**
 * Force SSL for admin and login
 */
define('FORCE_SSL_ADMIN', true);

/**
 * Disable automatic updates, as they won't work with the read-only filesystem
 */
define('AUTOMATIC_UPDATER_DISABLED', true);

/**
 * Disable file editing as this won't work on Heroku due to the read-only filesystem
 */
define('DISALLOW_FILE_EDIT', true);
define('DISALLOW_FILE_MODS', true);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
