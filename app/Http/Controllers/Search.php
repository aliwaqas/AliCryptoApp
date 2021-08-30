<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Search extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request , $model , $filter)
    {
        $model = "\\App\\".ucfirst($model);
        if($filter ==  'search')
        {
            return $model::orWhere($request->all())->get();
        }
        return $model::where($request->all())->get();
    }
}
