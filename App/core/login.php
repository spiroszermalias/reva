<?php
/**
 * \Core\Login takes control of the login action
 * 
 * @link https://github.com/spiroszermalias/reva
 * @package App
 * @subpackage Core
 * @author Spiros Zermalias <me@spiroszermalias.com>
 */

namespace Core;

class Login
{
    /** @var Auth $auth Holds an intance of the Auth class */
    private $auth = NULL;

    /**
     * Attempts to log the user in
     *
     * @return void
     */
    public function login() {

        $this->auth = new Auth;
        $is_authenticated = $this->is_authenticated();
        
        if ( $is_authenticated ) :
            
            $user_email = $_POST['user_email'];
            $password = $_POST['user_psw'];

            $user = $this->auth->get_user_by_user_email($user_email);

            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            session_write_close();

            /** Set Auth Cookies */
            $this->auth->set_auth_cookie( $user_email );
        else :
            return false;
        endif;
    }

    /**
     * Checks whether or not the user should be allowed access with the credentials they provided.
     *
     * @return boolean True if the user is authenticated, false otherwise.
     */
    private function is_authenticated() {
        $isAuthenticated = false;
        $user_email = isset( $_POST['user_email'] )? $_POST['user_email'] : '';
        $password = isset( $_POST['user_psw'] )? $_POST['user_psw'] : '' ;
        if ( !empty($user_email) && !empty($password) ) :
            
            //Verify password match    
            $user = $this->auth->get_user_by_user_email($user_email);

            if ( empty($user['user_pass']) )
                return false;

            if ( password_verify($password, $user['user_pass']) ) :
                $isAuthenticated = true;
            endif;
        
        endif;
        return $isAuthenticated;
    }

//end class
}