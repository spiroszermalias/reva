<?php

namespace Core;

class Auth {
    public function get_user_by_username($username) {
        $table = USERS_TBL;
        $query = "Select * from {$table} where username = %s";
        $result = \DB::queryFirstRow($query, $username);
        return $result;
    }
    
	protected function get_token_by_username($username, $expired) {
	    $table = TOKENS_TBL;
        $query = "Select * from {$table} where username = %s and is_expired = %i";
	    $result = \DB::queryFirstRow($query, $username, $expired);
	    return $result;
    }
    
    protected function mark_as_expired($tokenId) {
        $expired = 1;
        $table = TOKENS_TBL;
        $query = "UPDATE {$table} SET is_expired = %i WHERE id = %i";
        $result = \DB::query($query, $expired, $tokenId);
        return $result;
    }
    
    protected function insert_token($username, $random_password_hash, $random_selector_hash, $expiry_date) {
        $table = TOKENS_TBL;
        $query = "INSERT INTO {$table} (username, password_hash, selector_hash, expiry_date) values (%s, %s, %s,%s)";
        $result = \DB::query($query, $username, $random_password_hash, $random_selector_hash, $expiry_date);
        return $result;
    }

    public function get_token( int $length ) {
        return bin2hex( random_bytes( $length ) );
    }

    public function clear_auth_cookie() {
        //Clear Session
        $_SESSION["user_id"] = '';
        session_destroy();
        
        /** Clear cookies */
        $cookies = $_COOKIE;
        foreach($cookies as $cookie_name=>$cookie_value) {
            setcookie($cookie_name, '', time()-3600);
        }
    }
    
    public function set_auth_cookie( $username  ) {
        // Set Cookie expiration for 1 month
        $cookie_expiration_time = now('timestamp') + (30 * 24 * 60 * 60);
        setcookie('user_login', $username, $cookie_expiration_time);

        $random_password = $this->get_token(16);
        setcookie('random_password', $random_password, $cookie_expiration_time);

        $random_selector = $this->get_token(32);
        setcookie('random_selector', $random_selector, $cookie_expiration_time);

        $random_password_hash = password_hash($random_password, PASSWORD_BCRYPT);
        $random_selector_hash = password_hash($random_selector, PASSWORD_BCRYPT);

        $expiry_date = date(DATETIME_FORMAT, $cookie_expiration_time);

        /** Mark existing token as expired */
        $user_token = $this->get_token_by_username($username, 0);
        if ( !empty($user_token['id']) ) :
            $this->mark_as_expired( $user_token['id'] );
        endif;
        
        /** Insert new token */
        $this->insert_token($username, $random_password_hash, $random_selector_hash, $expiry_date);
    }

//end class
}