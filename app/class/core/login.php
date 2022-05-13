<?php

namespace Core;

class Login
{
    private $auth = NULL;

    public function login() {

        $this->auth = new Auth;
        $is_authenticated = $this->is_authenticated();
        
        if ( $is_authenticated ) :
            
            $username = $_POST['username'];
            $password = $_POST['user_psw'];

            $user = $this->auth->get_user_by_username($username);

            $_SESSION['user_id'] = $user['user_id'];

            /** Set Auth Cookies if 'Remember Me' checked */
            if ( isset($_POST['remember']) ) :
                $this->auth->set_auth_cookie( $username );
            else :
                $this->auth->clear_auth_cookie();
            endif;
        else :
            return false;
        endif;
    }

    private function is_authenticated() {
        $isAuthenticated = false;
        $username = isset( $_POST['username'] )? $_POST['username'] : '';
        $password = isset( $_POST['user_psw'] )? $_POST['user_psw'] : '' ;
        if ( !empty($username) && !empty($password) ) :
            
            //Verify password match    
            $user = $this->auth->get_user_by_username($username);

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