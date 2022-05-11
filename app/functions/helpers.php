<?php

function now() {
    /** Perfom call to API */
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://worldtimeapi.org/api/timezone/'.TIMEZONE,
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
    if ($httpcode === '200') :
        $response_obj = json_decode($response);
        $datetime_unformatted_string = $response_obj->datetime;

        $datetime_obj = date_create($datetime_unformatted_string);
        return date_format($datetime_obj, DATETIME_FORMAT);
    endif;
    
    /** If API call wasn't successful, fall-back to system time */
    $date = new DateTime("now", new DateTimeZone( TIMEZONE ) );
    return $date->format( DATETIME_FORMAT );
}