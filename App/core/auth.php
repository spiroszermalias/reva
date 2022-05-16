<?php
/**
 * \Core\Auth is used to get or set stuff relating to user sessions
 * 
 * @link https://github.com/spiroszermalias/reva
 * @package App
 * @subpackage Core
 * @author Spiros Zermalias <me@spiroszermalias.com>
 */

namespace Core;

class Auth {
    /**
     * Retrieves an array with the user info, by providing the user email
     *
     * @param string $user_email The user email.
     * @return mixed An array with the user information. Null if the user does not exist.
     */
    public function get_user_by_user_email($user_email) {
        $table = USERS_TBL;
        $query = "Select * from {$table} where user_email = %s";
        $result = \DB::queryFirstRow($query, $user_email);
        return $result;
    }
    
    /**
     * Retrieves a user's authentication token
     *
     * @param string $user_email The user email.
     * @param int $expired Whether or not to retrieve expired or non-expired token.
     * @return mixed Null if token is not found or the array with all the token information.
     */
	protected function get_token_by_email($user_email, $expired) {
	    $table = TOKENS_TBL;
        $query = "Select * from {$table} where user_email = %s and is_expired = %i";
	    $result = \DB::queryFirstRow($query, $user_email, $expired);
	    return $result;
    }
    
    /**
     * Set a token as expired
     *
     * @param int $tokenId The token_id as registered in the database.
     * @return void
     */
    protected function mark_as_expired($tokenId) {
        $expired = 1;
        $table = TOKENS_TBL;
        $query = "UPDATE {$table} SET is_expired = %i WHERE id = %i";
        $result = \DB::query($query, $expired, $tokenId);
    }
    
    /**
     * Register a user session token to the database
     *
     * @param string $user_email The ezisting user's email.
     * @param string $random_password_hash A random password hash.
     * @param string $random_selector_hash A random hash stored as a cookie as well.
     * @param string $expiry_date The mysql formatted datetime of when the token will be considered invalid/expired.
     * @return void
     */
    protected function insert_token($user_email, $random_password_hash, $random_selector_hash, $expiry_date) {
        $table = TOKENS_TBL;
        $query = "INSERT INTO {$table} (user_email, password_hash, selector_hash, expiry_date) values (%s, %s, %s,%s)";
        $result = \DB::query($query, $user_email, $random_password_hash, $random_selector_hash, $expiry_date);
        return $result;
    }

    /**
     * Produce a cryptographically-secure value.
     *
     * @param integer $length The desired value returned length.
     * @return string A random series of characters.
     */
    public function get_token( int $length ) {
        return bin2hex( random_bytes( $length ) );
    }

    /**
     * Removes all information that bind the user to a persistent session.
     *
     * @return void
     */
    public function clear_auth_cookie() {
        session_start();
        //Clear Session
        $_SESSION["user_id"] = '';
        session_destroy();
        session_write_close();
        
        /** Clear cookies */
        $cookies = $_COOKIE;
        foreach($cookies as $cookie_name=>$cookie_value) {
            setcookie($cookie_name, '', time()-3600);
        }
    }
    
    /**
     * Sets the uer session cookies
     *
     * @param string $user_email The user email
     * @return void
     */
    public function set_auth_cookie( $user_email ) {
        // Set Cookie expiration for 1 month
        $cookie_expiration_time = now('timestamp') + (30 * 24 * 60 * 60);
        setcookie('user_login', $user_email, $cookie_expiration_time);

        $random_password = $this->get_token(16);
        setcookie('random_password', $random_password, $cookie_expiration_time);

        $random_selector = $this->get_token(32);
        setcookie('random_selector', $random_selector, $cookie_expiration_time);

        $random_password_hash = password_hash($random_password, PASSWORD_BCRYPT);
        $random_selector_hash = password_hash($random_selector, PASSWORD_BCRYPT);

        $expiry_date = date(DATETIME_FORMAT, $cookie_expiration_time);

        /** Mark existing token as expired */
        $user_token = $this->get_token_by_email($user_email, 0);
        if ( !empty($user_token['id']) ) :
            $this->mark_as_expired( $user_token['id'] );
        endif;
        
        /** Insert new token */
        $this->insert_token($user_email, $random_password_hash, $random_selector_hash, $expiry_date);
    }

//end class
}