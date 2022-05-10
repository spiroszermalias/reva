<?php
/**
 * Init.php autoloads the project and config(s)
 * 
 * Init.php takes care of the prerequisite declarations and normal loading sequence of the project.
 * 
 * @link https://github.com/spiroszermalias/reva
 * @package reva
 * @author Spiros Zermalias <me@spiroszermalias.com>
 */

 /** Define the public dir absolute path w/ trailing slash */
 if ( ! defined( 'ABSPATH' ) ) :
	define( 'ABSPATH', __DIR__ . '/' );
 endif;

 /** Require autoload.php */
 require_once 'vendor/autoload.php';

 /** Require the main config file */
 require_once ABSPATH . 'config/config.php';