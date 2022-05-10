<?php
/**
 * The base configuration of the app
 * 
 * Config.php includes global configuration settings of the codebase.
 * 
 * @link https://github.com/spiroszermalias/reva
 * @package reva
 * @author Spiros Zermalias <me@spiroszermalias.com>
 */

// ** Edit with care! The constant controls whether the app is in development or production mode ** //
/** Set to 'dev' or 'prod' */
define('APP_MODE', 'prod');

/** Absolute path to the root directory */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Nope :)' );
}

/** App public url */
define('APP_URL', filter_var( $_SERVER['SERVER_NAME'], FILTER_SANITIZE_URL ) );

/** Define global date and time formats */
define( 'DATE_FORMAT', 'd-m-Y' );
define( 'TIME_FORMAT', 'H:i:s' );
define( 'DATETIME_FORMAT', 'Y-m-d H:i:s' );

/** Enable or disable error display */
define('DISPLAY_ERRORS', '0');

/** Enable or disable error logging */
ini_set('log_errors', 'On');

/** Specify the log file path. Preferably, keep log file in a non-public dir */
ini_set('error_log', ABSPATH . '/error-log.log');

/** Load the correct context-based config file */
if ( APP_MODE === 'dev' ) :
	require_once ABSPATH . 'config/dev-config.php';
elseif ( APP_MODE === 'prod' ) :
	require_once ABSPATH . 'config/prod-config.php';
endif;

/** Apply the appropriate DB settings */
DB::$dbName = DB_NAME;
DB::$user = DB_USER;
DB::$password = DB_PASSWORD;
DB::$host = DB_HOST;
DB::$port = DB_PORT;
DB::$encoding = DB_CHARSET;