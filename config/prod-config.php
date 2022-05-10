<?php
/**
 * The base configuration of the project for the production mode
 * 
 * @link https://github.com/spiroszermalias/reva
 * @package reva
 * @author Spiros Zermalias <me@spiroszermalias.com>
 */

 /* Set internal character encoding to UTF-8 */
 mb_internal_encoding("UTF-8");

ini_set('display_errors', DISPLAY_ERRORS);

// ** MySQL credentials ** //
/** The name of the database*/
define( 'DB_NAME', '' );

/** MySQL database username */
define( 'DB_USER', '' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** MySQL port */
define( 'DB_PORT', '3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/** The table prefix */
define( 'DB_PREFIX', '' );