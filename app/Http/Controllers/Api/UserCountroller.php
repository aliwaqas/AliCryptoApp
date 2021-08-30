<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UserCountroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllUsers()
    {
        $data = User::get()->toJson(JSON_PRETTY_PRINT);
        return response($data, 200);
    }

    public function getUserbyId($id) 
    {
        if (User::where('id', $id)->exists()) {
          $data = User::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
          return response($data, 200);
        } else {
          return response()->json([
            "message" => "User not found"
          ], 404);
        }
    }

    public function getUserbyWallet($id) 
    {
      if (User::where('id', $id)->exists()) {
        $data = User::where('id', $id)->with('getUserbyWallet')->get();
        return response()->json(['message'=>'Success','timestamp' => time() , 'data'=>$data],200);
      } else {
        return response()->json([
          "message" => 'failed',
        ], 404);
      }
      
    }

    public function createUser(Request $request) 
    {
        $user = new User;
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
  
        return response()->json([
          "message" => "User record created"
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
