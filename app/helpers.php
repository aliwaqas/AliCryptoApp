<?php

use Illuminate\Http\Request;

if(!function_exists('user_ip'))
{
    function user_ip(Request $request) {
        return "its work";
    }
}


if(!function_exists('helper_user_name'))
{
    function helper_user_name() {
        return ucwords(Auth::user()->firstName. ' ' . Auth::user()->lastName);
    }
}


if(!function_exists('getIp'))
{
    function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }
}


