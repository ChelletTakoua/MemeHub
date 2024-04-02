<?php


function displayResponseCode($code)
{
    $class = '';
    if ($code >= 200 && $code < 300) {
        $class = 'success';
    } elseif ($code >= 300 && $code < 400) {
        $class = 'redirection';
    } elseif ($code >= 400 && $code < 500) {
        $class = 'client-error';
    } elseif ($code >= 500 && $code < 600) {
        $class = 'server-error';
    }
    else{
        return $code;
    }

    return "<span class='$class'>$code</span>";
}


