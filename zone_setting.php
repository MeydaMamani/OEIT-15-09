<?php
    $defaultTimeZone='UTC';
    if(date_default_timezone_get()!=$defaultTimeZone) date_default_timezone_set($defaultTimeZone);
    function _date($format="r", $timestamp=false, $timezone=false){
        $userTimezone = new DateTimeZone(!empty($timezone) ? $timezone : 'GMT');
        $gmtTimezone = new DateTimeZone('GMT');
        $myDateTime = new DateTime(($timestamp!=false?date("r",(int)$timestamp):date("r")), $gmtTimezone);
        $offset = $userTimezone->getOffset($myDateTime);
        return date($format, ($timestamp!=false?(int)$timestamp:$myDateTime->format('U')) + $offset);
    }        
    // echo _date("Y-m-d | h:i:sa", false, 'America/Lima').'<br>';
?>