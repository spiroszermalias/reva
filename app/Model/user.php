<?php

namespace Model;

class User
{
    private $allowed_roles = array(
        'admin',
        'employee'
    );

    protected function list_users( $current_page_number = 1 ) {
        $data = array();
        $table = USERS_TBL;

        // Calculate offset for the main query based on pagination
        $pre_query = "
            SELECT COUNT(*)
            FROM {$table}
            WHERE 1=1";
        $total_entries_count = \DB::queryFirstField($pre_query);
        $entries_per_page = 10;
        $total_page_numbers = $total_entries_count / $entries_per_page ;
        if ($total_entries_count % $entries_per_page != 0)
            $total_page_numbers++;
        $total_page_numbers = (int) $total_page_numbers;

        $offset = (int) (($current_page_number-1)*$entries_per_page);

        $query = "
            SELECT user_id, user_email, first_name, last_name, user_email, role
            FROM {$table}
            WHERE 1=1
            ORDER BY `last_name` ASC
            LIMIT {$entries_per_page}
            OFFSET {$offset}
            ";
        $users = \DB::query( $query );

        
        // Build the data array to be returned to controller
        $data['pages_num'] = $total_page_numbers;
        $data['current_page'] = $current_page_number;
        $data['user_count'] = $total_entries_count;
        $data['users'] = $users;

        return $data;
    }

    /**
     * check_init_setup, returns whether or not the app is at its fresh install.
     * Very useful to perform actions like registering the first admin user
     *
     * @return boolean: true if app fresh install, false otherwise
     */
    public function check_init_setup() {
        $table = USERS_TBL;
        $query = "
            SELECT COUNT(*)
            FROM {$table}
            WHERE 1=1";
        $total_users = \DB::queryFirstField($query);
        if ( $total_users === '0') {
            return true;
        }
        return false;
    }

    protected function create_user() {
        $first_name = filter_input(INPUT_POST, 'firstname-input', FILTER_SANITIZE_STRING);
        $last_name = filter_input(INPUT_POST, 'lastname-input', FILTER_SANITIZE_STRING);
        
        //Validate email
        $user_email = filter_input(INPUT_POST, 'email-input', FILTER_VALIDATE_EMAIL) ;
        if (!$user_email) return 'Please provide a valid email address';

        //Password sanitization and match check
        $pass_1 = filter_input(INPUT_POST, 'pswd', FILTER_SANITIZE_STRING);
        $pass_2 = filter_input(INPUT_POST, 'pswd-confirm', FILTER_SANITIZE_STRING);
        if ($pass_1 != $pass_2) return 'Passwords do not match!';
        
        //Get and check role
        $user_role = filter_input(INPUT_POST, 'user-type-input');
        if (!in_array($user_role, $this->allowed_roles)) return 'This user role is not permitted';

        if (
            empty($first_name) ||
            empty($last_name) ||
            empty($user_email) ||
            empty($pass_1) ||
            empty($pass_2) ||
            empty($user_role)

        ) :
            return 'Please fill in all the required information';
        endif;

        $password = $pass_1; //Any between $pass_1 and $pass_2 will do since they match up to that point
        
        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        
        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) :
            return("Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.");
        endif;

        //Check if user with the same email already exists
        $table = USERS_TBL;
        $existing_user = (int) \DB::queryFirstField("SELECT COUNT(*) FROM {$table} WHERE `user_email` = %s", $user_email);
        if ( $existing_user != 0 ) return 'A user with this email is already registered';

        $status = \DB::insert($table, array(
            'user_email' => $user_email,
            'user_pass' => password_hash($password, PASSWORD_BCRYPT),
            'first_name' => $first_name,
            'last_name' => $last_name,
            'role' => $user_role
        ));

        return ($status == 1)? true : false;
    }

    public function get_admin_emails() {
        $table = USERS_TBL;
        $query = "SELECT user_email FROM {$table} WHERE `role` = 'admin'";
        $admin_emails = \DB::query($query);
        return $admin_emails;
    }

    public function get_user_id() {
        $user_email = filter_var($_COOKIE['user_login'], FILTER_VALIDATE_EMAIL);
        if (!$user_email) return false;
        $table = USERS_TBL;
        $query = "SELECT user_id FROM {$table} WHERE `user_email` = '{$user_email}'";
        $user_id = (int) \DB::queryFirstField($query);
        return ( is_int($user_id) )? $user_id : false ;
    }

    public function get_user( $user_id ) {
        $table = USERS_TBL;
        $query = "SELECT * FROM {$table} WHERE `user_id` = '{$user_id}'";
        $user = \DB::queryFirstRow( $query );
        return $user;
    }

    protected function update_user() {
        $user_id = filter_input(INPUT_GET, 'user', FILTER_VALIDATE_INT);
        if ( !$user_id ) return 'Please provide a valid user id';
        $first_name = filter_input(INPUT_POST, 'firstname-input', FILTER_SANITIZE_STRING);
        $last_name = filter_input(INPUT_POST, 'lastname-input', FILTER_SANITIZE_STRING);

        $user_email = filter_input(INPUT_POST, 'email-input', FILTER_VALIDATE_EMAIL) ;
        if (!$user_email) return 'Please provide a valid email address';

        //Get and check role
        $user_role = filter_input(INPUT_POST, 'user-type-input');
        if (!in_array($user_role, $this->allowed_roles)) return 'This user role is not permitted';

        if (
            empty($first_name) ||
            empty($last_name)  ||
            empty($user_email) ||
            empty($user_role)

        ) :
            return 'Please fill in all the required information';
        endif;

        //Check if user with the same email already exists
        $table = USERS_TBL;
        $existing_user = (int) \DB::queryFirstField("SELECT COUNT(*) FROM {$table} WHERE `user_email` = %s AND `user_id` <> %i", $user_email, $user_id);
        if ( $existing_user != 0 ) return 'A user with this email is already registered';

        $status = \DB::update($table, array(
            'user_email' => $user_email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'role' => $user_role
        ), "user_id=%i", $user_id);

        return ($status == 1)? true : false;
    }


//end class
}