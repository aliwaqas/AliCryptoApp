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
use DataTables;

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
                'c.name as countryName',
                'c.img',
                'c.time_zone',
                'c.id as cid'
                )->get();

                //return $result;
            return view('usermanagement.user_control');

        }
    }

    // GET ALL COUNTRIES
    public function getuserList(Request $request){

        $users =  DB::table('users AS u')
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
                'c.name as countryName',
                'c.img',
                'c.time_zone',
                'c.id as cid'
                )->get();

        $users[] = json_decode($users, true);
        $sdasdsa = 0;
        foreach($users as $user)
        {
            $sdasdsa = $sdasdsa+1;
            echo $sdasdsa. '<br>';

             //return $user;
            // if($user->status == 1)
            // {
            //     $user->status = 'Active';
            // }
            // if($user->status == 2)
            // {
            //     $user->status = 'Inactive';
            // }

        }
        return 'end';

        return DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('actions', function($row){
                    return '<div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item userUpdate" data-toggle="modal" data-id="'.$row['id'].'" data-target="#edit_user"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a class="dropdown-item userDelete" data-id="'.$row['id'].'"   ><i class="fa fa-trash-o m-r-5"></i> Delete</a>

                                </div>
                            </div>';
                })
                ->addColumn('flagImg', function($row){
                    return '<h2 class="table-avatar">
                                <a href="profile.html" class=""><img src="'.$row['img'].'" alt="" style="width:40px"></a>
                            </h2>';
                })
                ->addColumn('statusBtn', function($row){

                    if($row['status'] == 'Active')
                    {
                        $btnCode = ' <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false" data-id="'.$row['id'].'" >
                                    <i class="fa fa-dot-circle-o text-success"></i>
                                    <span class="statuss">Active</span>
                                </a>';


                    }
                    elseif($row['status'] == 'Inactive')
                    {

                        $btnCode = ' <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false" data-id="'.$row['id'].'" >
                                    <i class="fa fa-dot-circle-o text-info"></i>
                                    <span class="statuss">Inactive</span>
                            </a>';
                    }

                    else
                    {
                        $btnCode = '<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-dot-circle-o text-dark"></i>
                                        <span class="statuss">N/A</span>
                                    </a>';
                    }

                    return '<div class="dropdown action-label">'.$btnCode.'
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a  class="activeStatus dropdown-item" data-status="Active" data-id="'.$row['id'].'" >
                                        <i class="fa fa-dot-circle-o text-success"></i> Active
                                    </a>
                                    <a  class="activeStatus dropdown-item" data-status="Inactive" data-id="'.$row['id'].'" >
                                        <i class="fa fa-dot-circle-o text-warning"></i> Inactive
                                    </a>

                                </div>
                            </div>';
                })


                ->rawColumns(['actions','statusBtn','flagImg'])
                ->make(true);
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
