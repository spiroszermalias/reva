<?php
/**
 * Core\Db class performs checks and performs actions relating to the database entity structure.
 * 
 * @link https://github.com/spiroszermalias/reva
 * @package reva
 * @subpackage core
 * @author Spiros Zermalias <me@spiroszermalias.com>
 */

namespace Core;

class Db
{

    /**
     * $tables contains the required tables.
     * Key should be table name and value the SQL syntax describing the attribute
     */
    private static $tables = array(
        'users' =>"
            `user_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `first_name` tinytext COLLATE utf8mb4_unicode_ci,
            `last_name` tinytext COLLATE utf8mb4_unicode_ci,
            `role` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
            `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            UNIQUE (`user_email`),
            INDEX (`user_email`)
        ",
        'token_auth' => "
            `id` int(11) NOT NULL PRIMARY KEY,
            `username` varchar(255) NOT NULL,
            `password_hash` varchar(255) NOT NULL,
            `selector_hash` varchar(255) NOT NULL,
            `is_expired` int(11) NOT NULL DEFAULT '0',
            `expiry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ",
        'applications' => "
            `id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `submit_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `from_datetime` datetime NOT NULL,
            `to_datetime` datetime NOT NULL,
            `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
            `status` tinytext COLLATE utf8mb4_unicode_ci NOT NULL
        "
    );

    public function __construct() {
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

//end class
}
