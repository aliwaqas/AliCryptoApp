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