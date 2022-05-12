<?php

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