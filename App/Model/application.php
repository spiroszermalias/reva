<?php
/**
 * The applications model
 * 
 * @link https://github.com/spiroszermalias/reva
 * @package App
 * @subpackage Model
 * @author Spiros Zermalias <me@spiroszermalias.com>
 */

namespace Model;

class Application extends \Model\User
{
    /**
     * Retrieves all the current user's applications
     *
     * @return array An array of the applications data.
     */
    public function get_applications() {
        $current_user_id = $this->get_user_id();
        if (!$current_user_id) return array();
        
        $table = APPL_TBL;
        $query = "SELECT * FROM {$table} WHERE `user_id` = %i ORDER BY `submit_datetime` DESC";
        $results = \DB::query($query, $current_user_id);

        $data = array();
        if ( !empty($results) ) :
            foreach ( $results as $row ) :
                //Build the template data
                $appl_id = $row['id'];
                
                //Submission date and time
                $date = date( DATE_FORMAT, strtotime($row['submit_datetime']) );
                $time = date( TIME_FORMAT, strtotime($row['submit_datetime']) );
                $data[$appl_id]['submit_date'] = $date;
                $data[$appl_id]['submit_time'] = $time;
                $date = ''; $time = '';
                
                //From date and time
                $date = date( DATE_FORMAT, strtotime($row['from_datetime']) );
                $time = date( TIME_FORMAT, strtotime($row['from_datetime']) );
                $data[$appl_id]['from_date'] = $date;
                $data[$appl_id]['from_time'] = $time;
                $date = ''; $time = '';
                
                //To date and time
                $date = date( DATE_FORMAT, strtotime($row['to_datetime']) );
                $time = date( TIME_FORMAT, strtotime($row['to_datetime']) );
                $data[$appl_id]['to_date'] = $date;
                $data[$appl_id]['to_time'] = $time;
                $date = ''; $time = '';

                //Duration in days
                $from_date = date_create_from_format( DATETIME_FORMAT, $row['from_datetime'] );
                $to_date = date_create_from_format( DATETIME_FORMAT, $row['to_datetime'] );
                $days_diff = date_diff($from_date, $to_date);
                $data[$appl_id]['days_interval'] = $days_diff->format('%a');

                //Status
                $data[$appl_id]['status'] = strtoupper($row['status']);
            endforeach;    
        endif;

        return $data;
    }

    /**
     * Validates newle requested applications for vacation
     *
     * @return int The new application unique id
     */
    public function submit_application() {
        if ( 
            !isset($_POST['reason'])  ||
            !isset($_POST['start'])   ||
            !isset($_POST['end'])     ||
            empty( $_POST['reason'] ) ||
            empty( $_POST['start'] )  ||
            empty( $_POST['end'] )
            ) :
            //In case $reason text is already supplied, return in and repopulate the form with it
            $reason = ( isset($_POST['reason']) )? $_POST['reason'] : '';
            return array('msg'=>'Please fill all the fields', 'reason'=>$reason);
        endif;
        
        //Reason to apply
        $reason = htmlentities($_POST['reason']);
        
        //Dates
        $start = $_POST['start'];
        $end = $_POST['end'];
        if ( !isValid($start) || !isValid($end) ) :
            //Also return $reason and repopulate the form with it
            return array('msg'=>'Invalid date(s) provided', 'reason'=>$reason);
        endif;
        $start_obj = new \DateTime($start);
        $end_obj    = new \DateTime($end);
        if ( $end_obj < $start_obj ) :
            return array( 'msg'=>'End date must be later than start date', 'reason'=>$reason);
        endif;
        
        $new_appl_id = $this->insert_application($reason, $start, $end);
        if ($new_appl_id != false) :
            email_request_to_admins($new_appl_id);
        endif;

        return $new_appl_id;
    }

    /**
     * Gets info for a single application
     *
     * @param int $appl_id The application id
     * @return array An array with the application info. NUll if not found.
     */
    public function get_application($appl_id) {
        $table = APPL_TBL;
        $query = "SELECT * FROM {$table} WHERE `id` = %i";
        $application = \DB::queryFirstRow($query, $appl_id);
        return $application;
    }

    /**
     * Inserts a new application to the database
     *
     * @param string $reason The reason for which the user states he needs to take time off.
     * @param string $start The requested start date.
     * @param string $end The requested end date.
     * @return mixed The new application id. False if error.
     */
    protected function insert_application($reason, $start, $end) {
        $user = get_user_info();
        $user_id = $user['user_id'];
        $table = APPL_TBL;
        $result = \DB::insert($table, array(
            'user_id' => $user_id,
            'submit_datetime' => now(),
            'from_datetime' => $start,
            'to_datetime' => $end,
            'reason' => $reason,
            'status' => 'pending'
        ));
        $new_appl_id = \DB::insertId();
        return ($result != 0)? $new_appl_id : false;
    }

    /**
     * Change an request status to approved
     *
     * @param int $appl_id The application id
     * @return void
     */
    public function approve($appl_id) {
        \DB::update(APPL_TBL, array(
            'status' => 'approved'
        ), 'id=%i', $appl_id);

        $appl = $this->get_application($appl_id);
        $submision_date = date(DATE_FORMAT, strtotime($appl['submit_datetime']) );
        $user = $this->get_user( $appl['user_id'] );
        $user_email = $user['user_email'];
        notify_user(true, $submision_date, $user_email);
    }

    /**
     * * Change an request status to rejected
     *
     * @param int $appl_id The application id
     * @return void
     */
    public function reject($appl_id) {
        \DB::update(APPL_TBL, array(
            'status' => 'rejected'
        ), 'id=%i', $appl_id);

        $appl = $this->get_application($appl_id);
        $submision_date = date(DATE_FORMAT, strtotime($appl['submit_datetime']) );
        $user = $this->get_user( $appl['user_id'] );
        $user_email = $user['user_email'];
        notify_user(false, $submision_date, $user_email);
    }

//end class
}