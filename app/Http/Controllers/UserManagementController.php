<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DB;
use App\Models\User;
use App\Models\Form;
use App\Rules\MatchOldPassword;
use Carbon\Carbon;
use Session;
use Auth;
use Hash;

class UserManagementController extends Controller
{

    public function index()
    {
        if (Auth::guest())
        {

            return redirect()->route('admin.home');

        }
        else
        {
            $result =  DB::table('users AS u')
            ->leftJoin('countrylists AS c', 'u.countrylist_id', '=', 'c.id')
            ->select(
                'u.id',
                'u.userName',
                'u.countrylist_id' ,
                'u.ip' ,
                'u.firstName' ,
                'u.lastName' ,
                'u.phone',
                'u.avatar',
                'u.email',
                'u.bio',
                'u.status',
                'u.created_at',
                'c.slug',
                'c.name',
                'c.img',
                'c.time_zone',
                'c.id as cid'
                )->get();
            $result = json_encode($result);
            return $result;

            return view('usermanagement.user_control', ['result' => $result]);

            return view('usermanagement.user_control',compact('result'));
        }
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
