<?php

namespace Controller;

use \Bramus\Router\Router;

class MainController
{
    private $router = NULL;

    public function __construct() {
        $this->router = new Router();
        $this->routes();
        $this->router->run();
    }

    private function routes() {
        $this->router->before('GET|POST', '/[^\/login]*', function() {
            $util = new \Core\Util();
            if ( !logged_in() ) :
                $util->redirect( '/login' );
            endif;
        });

        $this->router->get('/', function() {
            $util = new \Core\Util();
            $util->redirect( '/dashboard' );
        });

        $this->router->get( '/login', function() {
            $util = new \Core\Util();
            if ( logged_in() ) :
                $util->redirect( '/dashboard' );
            endif;
            render( 'login' );
        });

        $this->router->post( '/login', function() {
            $util = new \Core\Util();
            if ( logged_in() ) :
                $util->redirect( '/dashboard' );
            endif;

            if ( isset($_POST['login']) ) :
                $login = new \Core\Login;
                $status = $login->login();
                if (!$status) $util->redirect( '/login' );
            endif;
        });
        
        $this->router->get('/dashboard', function() {
            
        });

    }

//end class
}