<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Models\Countrylist;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {

        Validator::make($input, [
            'userName' => ['required', 'string', 'max:255', 'alpha'],
            'firstName' => ['required', 'string', 'max:255', 'alpha'],
            'lastName' => ['required', 'string', 'max:255', 'alpha'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'userName' => [
                'required',
                'string',
                'alpha_dash',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $userIP = request()->ip();
        $data = geoip($ip = $userIP);
        $country = Countrylist::where('slug' , $data->iso_code)->first();

        return User::create([
            'userName' => $input['userName'],
            'firstName' => $input['firstName'],
            'lastName' => $input['lastName'],
            'email' => $input['email'],
            'ip' => $userIP,
            'countrylist_id' => $country->id,
            'password' => Hash::make($input['password']),
        ]);
    }
}
