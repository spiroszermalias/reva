<?php
/**
 * The main application controller class
 * 
 * @link https://github.com/spiroszermalias/reva
 * @package App
 * @subpackage controller
 * @author Spiros Zermalias <me@spiroszermalias.com>
 */

namespace controller;

use \Bramus\Router\Router;
use \Core\Util;
use \Model\Application;

class MainController extends \Model\User
{
    /** @var \Bramus\Router\Router $router Holds an intance of the Router class */
    private $router = NULL;
    /** @var \Core\Util $util Holds an intance of the Util class */
    private $util = NULL;
    /** @var \Model\Application $appl Holds an intance of the Application class */
    private $appl = NULL;

    public function __construct() {
        new \Core\Db;
        $this->router = new Router();
        $this->util = new Util();
        $this->appl = new Application;
        //Define and run the routers
        $this->routes();
        $this->router->run();
    }

    /**
     * Define the controller's routes
     *
     * @return void
     */
    private function routes() {
        //This hook runs before any other router.
        $this->router->before('GET|POST', '/[^\/login].*', function() {
            $request_uri = filter_var( $_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL );
            $full_url = APP_URL_WITH_PROTOCOL.$request_uri;
            if ( !logged_in() && $request_uri != '/setup' ) :
                $this->util->redirect( "/login?redirect={$full_url}" );
            endif;
        });

        // /setup is used to render the "first user" creation page durng installation
        $this->router->get( '/setup', function() {
            $fresh_install = $this->check_init_setup();
            if ( $fresh_install ) :
                render('first-user');
            else:
                $this->util->redirect( '/' );
            endif;
        });

        $this->router->post( '/setup', function() {
            $fresh_install = $this->check_init_setup();
            if ( $fresh_install ) :
                $message = '';
                if ( isset($_POST['user-create']) ) :
                    $user_ins = new \Model\User;
                    $status = $user_ins->create_user();
                    if ( gettype($status)==='string' ) : //There's an error message
                        exit("{$status} Please go back and retry.");
                    elseif($status) :
                        $this->util->redirect( '/users' );
                    endif;
                endif;
            else:
                $this->util->redirect( '/' );
            endif;
        });

        $this->router->set404(function () {
            render('404');
        });

        $this->router->get('/', function() {
            if ( !is_admin() ) : 
                $this->util->redirect( '/dashboard' );
            else:
                $this->util->redirect( '/users' );
            endif;
        });

        //The login page
        $this->router->get( '/login', function() {            
            if ( logged_in() ) :
                if ( !is_admin() ) : 
                    $this->util->redirect( '/dashboard' );
                else:
                    $this->util->redirect( '/users' );
                endif;
            endif;
            render( 'login' );
        });

        $this->router->post( '/login', function() {
            if ( logged_in() ) :
                if ( !is_admin() ) : 
                    $this->util->redirect( '/dashboard' );
                else:
                    $this->util->redirect( '/users' );
                endif;
            endif;

            if ( isset($_POST['login']) ) :
                $login = new \Core\Login;
                $status = $login->login();
                if (!$status) :
                    $maybe_redirect = filter_var( $_GET['redirect'], FILTER_SANITIZE_URL );
                    $url = (!empty($maybe_redirect) && $maybe_redirect != '')? $maybe_redirect : '/login';
                    $this->util->redirect( $url );
                endif;
            endif;
        });
        
        //The user list display
        $this->router->get('/users', function() {
            $user_ins = new \Model\User;
            if ( !is_admin() ) : 
                $this->util->redirect( '/dashboard' );
            endif;

            if ( isset( $_GET['user'] ) ) :
                $user_id = filter_input(INPUT_GET, 'user', FILTER_VALIDATE_INT);
                //If $user_id is not a valid integer, redirect back to "all" users page and remove the 'user' paramater
                
                if (!$user_id) :
                    $this->util->redirect( '/users' );
                endif;
                
                $data = $user_ins->get_user($user_id);
                render('edit-user', $data);
            endif;

            //Default $page_number = 1
            $page_number = 1;
            if ( isset($_GET['page_number']) ) :
                $page_number_param = (int) trim( $_GET['page_number'] );
                if ( is_int($page_number_param) ) $page_number = $page_number_param;
            endif;

            $data = $user_ins->list_users( $page_number );

            render('users', $data);
        });

        $this->router->post('/users', function() {
            $user_ins = new \Model\User;
            if ( !is_admin() ) : 
                $this->util->redirect( '/dashboard' );
            endif;
            
            $user_id = filter_input(INPUT_GET, 'user', FILTER_VALIDATE_INT);
            $message = '';
            if ( isset($_POST['user-update']) && $user_id != false ) :
                $status = $this->update_user();
                if ( gettype($status)==='string' ) : //There's an error message
                    $message = $status;
                    $this->util->redirect( "/users?user={$user_id}&msg={$message}
                    " );
                    elseif($status) :
                        $this->util->redirect( '/users' );
                    endif;
                endif;
        });

        $this->router->get('/users/create', function() {
            
            if ( !is_admin() ) : 
                $this->util->redirect( '/dashboard' );
            endif;

            render('create-user');
        });

        $this->router->post('/users/create', function() {
            $user_ins = new \Model\User;
            
            if ( !is_admin() ) : 
                $this->util->redirect( '/dashboard' );
            endif;

            $message = '';
            if ( isset($_POST['user-create']) ) :
                $status = $user_ins->create_user();
                if ( gettype($status)==='string' ) : //There's an error message
                    $message = $status;
                elseif($status) :
                    $this->util->redirect( '/users' );
                endif;
            endif;
            
            render( 'create-user', array('msg'=>$message) );
        });

        $this->router->get('/dashboard', function() {
            $data['applications'] = $this->appl->get_applications();
            render('dashboard', $data);
        });

        $this->router->get('/dashboard/create', function() {
            render('create-appl');
        });

        $this->router->post('/dashboard/create', function() {
            $message = '';
            $reason  = '';
            if ( isset($_POST['appl-create']) ) :
                $status = $this->appl->submit_application();
                if ( !empty($status['msg']) ) : //There's an error message
                    $message = $status['msg'];
                    $reason = $status['reason'];
                elseif($status) :
                    $this->util->redirect( '/dashboard' );
                endif;
            endif;

            render('create-appl', array(
                    'msg'=> $message,
                    'reason' => $reason
                ));
        });

        $this->router->get('/approve/{appl_id}', function($appl_id) {
            if ( !is_admin() ) : 
                $this->util->redirect( '/dashboard' );
            endif;
            $this->appl->approve($appl_id);
            render('approve-reject', array('msg'=>'Your approved the vacation request! ????'));
        });

        $this->router->get('/reject/{appl_id}', function($appl_id) {
            if ( !is_admin() ) : 
                $this->util->redirect( '/dashboard' );
            endif;
            $this->appl->reject($appl_id);
            render('approve-reject', array('msg'=>'Your rejected the vacation request ????'));
        });

        $this->router->get('/logout', function() {
            render('logout');
        });

    }

//end class
}
