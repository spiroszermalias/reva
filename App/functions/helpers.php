<?php
/**
 * A series of functions to with a global scope of use
 * 
 * @link https://github.com/spiroszermalias/reva
 * @author Spiros Zermalias <me@spiroszermalias.com>
 */

/**
 * Get the time now in the timezone that is set in the project's config
 *
 * @param string $format Either 'datetime' or 'timestamp'. Datetime returns the datetime in format as specified in config. Default: 'datetime'
 * @return string Datetime string or unix time
 */
function now( $format = 'datetime' ) {
    $time = new stdClass();
    $datetime = '';
    $timestamp = '';

    /** Perfom call to API */
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://worldtimeapi.org/api/timezone/'.TIMEZONE,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    
    /** If API call is successful, extract datetime */
    if ($httpcode === 200) :
        $response_obj = json_decode($response);
        $datetime_unformatted_string = $response_obj->datetime;

        $datetime_obj = date_create($datetime_unformatted_string);
        $datetime = date_format($datetime_obj, DATETIME_FORMAT);
        
        $datetime = $datetime;
        $timestamp_utc_0 = $datetime_obj->getTimestamp();
        
        //Retrieve the UTC offset in unix time
        $target_time_zone = new DateTimeZone( TIMEZONE );
        $date_time = new DateTime('now', $target_time_zone);
        $timestamp_utc_offset = $date_time->format('Z');
        
        //Timestamp with UTC offset
        $timestamp = $timestamp_utc_0 + $timestamp_utc_offset;
        
        return ($format === 'timestamp')? $timestamp : $datetime;
    endif;
    
    /** If API call wasn't successful, fall-back to system time */
    $datetime_obj = new DateTime("now", new DateTimeZone( TIMEZONE ) );
    $datetime = $datetime_obj->format( DATETIME_FORMAT );
    $timestamp_utc_0 = $datetime_obj->getTimestamp();

    //Retrieve the UTC offset in unix time
    $target_time_zone = new DateTimeZone( TIMEZONE );
    $date_time = new DateTime('now', $target_time_zone);
    $timestamp_utc_offset = $date_time->format('Z');
    
    //Timestamp with UTC offset
    $timestamp = $timestamp_utc_0 + $timestamp_utc_offset;
    
    return ($format === 'timestamp')? $timestamp : $datetime;
}

/**
 * An alias for Core\Session_Validate::logged_in()
 *
 * @return boolean True if user is logged in, false otherwise
 */
function logged_in() {
    $instance = new Core\Session_Validate;
    return $instance->logged_in();
}

/**
 * Checks whether or not the user is an admin or not
 *
 * @return boolean True if user is logged in and an admin, false in any other case.
 */
function is_admin() {
    $is_admin = false;
    if ( logged_in() ) :
        $instance = new Core\Auth;
        $user = $instance->get_user_by_user_email( $_COOKIE['user_login'] );
        $is_admin = ( $user['role'] === 'admin' )? true : false ;
    endif;
    $ins = new \Model\User;
    $fresh_install = $ins->check_init_setup();
    //If we're in the initial instalation/setup of the project, grant admin privileges anyway
    if ( $fresh_install ) return true;
    return $is_admin;
}

/**
 * Renders a template under the view directory
 *
 * @param string $template the template name without the file extension.
 * @param array $vars An optional array of passed variables to the template. Array keys will become available as variable names in the template.
 * @return void
 */
function render( string $template = '', $vars = [] ) {
    if ( $template == '' ) return '';
    
    $template_no_slashes = str_replace('/', '', $template);
    
    $template_clean = str_replace('.php', '', $template_no_slashes); 
    if ( $template_clean == null ) return '';

    if ( gettype($vars) === 'array' && !empty($vars))
        extract($vars);

    ob_start();
    include dirname(__DIR__, 1) . "/views/{$template_clean}.php";
    $output = ob_get_contents();
    ob_end_clean();

    echo $output;
    exit;
}

/**
 * Includes the global site header
 *
 * @return void
 */
function head() {
    include dirname(__DIR__, 1) . "/views/global/head.php";
}

/**
 * Includes the global site footer
 *
 * @return void
 */
function footer() {
    include dirname(__DIR__, 1) . "/views/global/footer.php";
}

/**
 * Retrieves the current user information
 *
 * @return array Empty array if error or the user is not found, the user info otherwise.
 */
function get_user_info() {
    $user_model_ins = new \Model\User;
    $current_user_id = $user_model_ins->get_user_id();
    $user_info = $user_model_ins->get_user($current_user_id);
    return ( !empty($user_info) )? $user_info : array();
}

/**
 * Validates whether or not a provided datetime string matches with a given datetime format
 *
 * @param string $date The datetime to validate.
 * @param string $format The format to validate against. Default: DATETIME_FORMAT
 * @return boolean True if providded date matches the specified format. False if it does not.
 */
function isValid($date, $format = DATETIME_FORMAT){
	$dt = DateTime::createFromFormat($format, $date);
	return $dt && $dt->format($format) === $date;
}

 /**
  * Produces pagination numbers
  *
  * @param int $cur_page the current page
  * @param int $number_of_pages total number of pages
  * @param boolean $prev_next whether to show previous and next buttons
  * @return string
  */
  function insertPagination( $cur_page, $number_of_pages, $prev_next=false ) {
    $ends_count = 2;  //how many items at the ends (before and after [...])
    $middle_count = 1;  //how many items before and after current page
    $dots = false;
    ?>
    <div class="pagin"  data-selectd-page=<?=$cur_page?>>
    <?php
    if ($prev_next && $cur_page && 1 < $cur_page) : ?>
        <i class="prev bi bi-chevron-double-left"></i>
    <?php endif;
    for ($num = 1; $num <= $number_of_pages; $num++) :
         if ($num == $cur_page) :
            echo '<span data-page-number="'.$num.'" class="page active">'.$num.'</span>';
         $dots = true;
         else :
            if ($num <= $ends_count || ($cur_page && $num >= $cur_page - $middle_count && $num <= $cur_page + $middle_count) || $num > $number_of_pages - $ends_count) :
                echo '<span data-page-number="'.$num.'" class="page">'.$num.'</span>';
                $dots = true;
            elseif ( $dots ):
                echo '<i class="bi bi-three-dots"></i>';
                $dots = false;
            endif;
        endif;
    endfor;
    if ($prev_next && $cur_page && ($cur_page < $number_of_pages || -1 == $number_of_pages)) : //print next button?
        echo '<i class="next bi bi-chevron-double-right"></i>';
    endif ?>
    </div>
 <?php }

/**
 * Notifies admin(s) user(s) through email, about the receival of a new vacation request and exposes the approval/reject links to them
 *
 * @param int $appl_id The application id
 * @return void
 */
 function email_request_to_admins($appl_id) {
    //Since there may be multiple admins, get all admin emails
    $user_model_ins = new \Model\User;
    $admin_emails = $user_model_ins->get_admin_emails();

    $instance = new \Model\Application;
    $application = $instance->get_application($appl_id);
    
    $vacation_start = date(DATE_FORMAT, strtotime($application['from_datetime']));
    $vacation_end = date(DATE_FORMAT, strtotime($application['to_datetime']));
    $reason = $application['reason'];
    
    $user = $instance->get_user( $application['user_id'] );

    $approve_href = APP_URL_WITH_PROTOCOL."/approve/{$appl_id}";
    $approve_link = '<a href="'. $approve_href .'" >Approve</a>' ;
    
    $reject_href = APP_URL_WITH_PROTOCOL."/reject/{$appl_id}";
    $reject_link = '<a href="'. $reject_href .'" >Reject</a>' ;
    
    foreach ( $admin_emails as $email ) :
        $to = $email['user_email'];
        $from = GLOBAL_MAIL_FROM;
        $subject = "New request";
        
        $header = "MIME-Version: 1.0\r\n";
        $header .= "From: {$from} \r\n";
        $header .= "Content-type: text/html\r\n";
    
        $message = "Dear supervisor, employee {$user['first_name']} {$user['last_name']} requested for some time off, starting on
        {$vacation_start} and ending on {$vacation_end}, stating the reason:
        {$reason}
        Click on one of the below links to approve or reject the application:
        {$approve_link} - {$reject_link}";
    
        $status = mail ($to, $subject, $message, $header);
    endforeach;
 }

 /**
  * Sends an email to the appropriate user with the change of status of a vacation request
  *
  * @param string $approval_status The status of the request
  * @param string $submision_date The date on which the request was submitted
  * @param string $user_email The user email to which the notification should be sent to
  * @return void
  */
 function notify_user($approval_status, $submision_date, $user_email) {
    $appr_status = ($approval_status)? 'approved' : 'rejected' ;
    $to = $user_email;
    $from = GLOBAL_MAIL_FROM;
    $subject = "Your request status just got updated";
    
    $header = "MIME-Version: 1.0\r\n";
    $header .= "From: {$from} \r\n";
    $header .= "Content-type: text/html\r\n";

    $message = "Dear employee, your supervisor has {$appr_status} your application
    submitted on {$submision_date}.";

    $status = mail ($to, $subject, $message, $header);
 }