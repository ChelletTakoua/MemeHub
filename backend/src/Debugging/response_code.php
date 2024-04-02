<?php

/**
 * Display the response status code in a colored box
 * @param int $code the response status code
 * @return string the response status code in a colored box
 */


function displayResponseCode($code)
{
    $class = '';
    $error="";
    if ($code >= 200 && $code < 300) {
        $class = 'success';
        $error="OK";
    } elseif ($code >= 300 && $code < 400) {
        $class = 'redirection';
        $error="Redirection";
    } elseif ($code >= 400 && $code < 500) {
        $class = 'client-error';
        $error="Client Error";
    } elseif ($code >= 500 && $code < 600) {
        $class = 'server-error';
        $error="Server Error";
    }
    else{
        return $code;
    }

    return "<span class='".$class."'><span class='status-point'>●</span>  ".$code."   ".$error."</span>";
}