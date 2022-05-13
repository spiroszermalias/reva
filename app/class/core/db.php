<?php
/**
 * Core\Db class (Singleton) performs checks and performs actions relating to the database entity structure.
 * 
 * @link https://github.com/spiroszermalias/reva
 * @package reva
 * @subpackage core
 * @author Spiros Zermalias <me@spiroszermalias.com>
 */

namespace Core;

class Db
{
    /** Hold the class instance. */
    private static $instance = NULL;

    /**
     * $tables contains the required tables.
     * Key should be table name and value the SQL syntax describing the attribute
     */
    private static $tables = array(
        'users' =>
        '`user_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR( 255 ) NOT NULL ,
        `user_email` VARCHAR( 60 ) NOT NULL ,
        `user_pass` VARCHAR( 255 ) NOT NULL ,
         UNIQUE (`user_name`),
         UNIQUE (`user_email`)'
        ,
        'token_auth' => "
        `id` int(11) NOT NULL PRIMARY KEY,
        `username` varchar(255) NOT NULL,
        `password_hash` varchar(255) NOT NULL,
        `selector_hash` varchar(255) NOT NULL,
        `is_expired` int(11) NOT NULL DEFAULT '0',
        `expiry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"
        ,
    );

    private function __construct() {
        $this->check_db();
    }

    /**
     * check_db checks whether or not the database is empty. If it is, then it structures it.
     *
     * @return void
     */
    private function check_db() {
        $db_tables = \DB::tableList();
        if ( empty($db_tables) ) :
            $this->build_db();
        endif;
    }

    private function build_db() {
        if ( !empty(self::$tables) ) :
            foreach ( self::$tables as $table_name=>$table_fields ) :
                \DB::query( "CREATE TABLE `{$table_name}` ( {$table_fields} ) ENGINE = InnoDB;" );
            endforeach;
        endif;
    }

    /**
     * Always returns the single, same instance of the class
     *
     * @return Db class object
     */
    public static function getInstance() : self {
        if (self::$instance == null) :
            self::$instance = new Db;
        endif;

        return self::$instance;
    }

//end class
}