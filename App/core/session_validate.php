<?php
/**
 * \Core\Session_Validate contains the user session validation methods as well as the login state
 * 
 * @link https://github.com/spiroszermalias/reva
 * @package App
 * @subpackage Core
 * @author Spiros Zermalias <me@spiroszermalias.com>
 */

namespace Core;

class Session_Validate extends Auth
{

    public function __contruct() {
        $this->checkSession();
    }

    /**
     * checkSession() initiates a series of checks to determine the session status
     *
     * @return void
     */
    private function checkSession() {
        $logged_in = $this->logged_in();
    }
    
    /**
     * Get the current user login status
     *
     * @return boolean True if user is logged in, false if not.
     */
    public function logged_in() {
        $login_state = false;
        $login_state = $this->is_cookie_session_valid();
        return $login_state;
    }

    /**
     * Determine if the user session is valid or expired
     *
     * @return boolean True if session is valid and not expired, false otherwise.
     */
    private function is_cookie_session_valid() {
        $login_state = false;

        if (!isset($_COOKIE['user_login']) || !isset($_COOKIE['random_selector']) || !isset($_COOKIE['random_password']) )
            return false;

        $user_login_coo = $_COOKIE['user_login'];
        $random_selector_coo = $_COOKIE['random_selector'];
        $random_password_coo = $_COOKIE['random_password'];

        /** If cookies are set */
        if ( !empty($user_login_coo) && !empty($random_selector_coo) && !empty($random_password_coo) ) :
            /** Initiate auth token verification directive to false */
            $isPasswordVerified = false;
            $isSelectorVerified = false;
            $isExpiryDateVerified = false;

            /** Get token for email */
            $user_token = $this->get_token_by_email($user_login_coo, 0);

            if ( empty($user_token) ) return false;

            /** Validate random password cookie with database */
            if ( password_verify($random_password_coo, $user_token['password_hash']) ) :
                $isPasswordVerified = true;
            endif;

            /** Validate random selector cookie with database */
            if ( password_verify($random_selector_coo, $user_token['selector_hash']) ) :
                $isSelectorVerified = true;
            endif;

            /** Check cookie expiration by date */
            
            $cookie_expiration_datetime = \DateTime::createFromFormat( DATETIME_FORMAT, $user_token['expiry_date'] );
            $cookie_expiration_timestamp = $cookie_expiration_datetime->getTimestamp();            
            if( $cookie_expiration_timestamp >= now('timestamp') ) :
                $isExpiryDateVerified = true;
            endif;

            /** If all checks are verified, set login state to true */
            if (!empty($user_token['id']) && $isPasswordVerified && $isSelectorVerified && $isExpiryDateVerified) :
                $login_state = true;
            else: 
                if( !empty($user_token['id']) ) :
                    $this->mark_as_expired($user_token['id']);
                endif;
                /** Clear cookies */
                //$this->clear_auth_cookie();
            endif;

        endif;
        return $login_state;
    }

//end class
}