<?php
/**
 * Contains methods with a global use scope for various purposes
 * 
 * @link https://github.com/spiroszermalias/reva
 * @package App
 * @subpackage Core
 * @author Spiros Zermalias <me@spiroszermalias.com>
 */

namespace Core;

class Util
{
    /**
     * Send redirection headers to the client
     *
     * @param string $redirect_to The url to redirect to.
     * @return void
     */
    public function redirect( string $redirect_to = '' ) {
        if ( !empty( $redirect_to ) )
            header("Location: {$redirect_to}");
            exit;
    }

//end class
}