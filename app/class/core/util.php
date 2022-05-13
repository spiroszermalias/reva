<?php

namespace Core;

class Util
{
    public function redirect( string $redirect_to = '' ) {
        if ( !empty( $redirect_to ) )
            header("Location: {$redirect_to}");
            exit;
    }
}