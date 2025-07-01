<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => 'required',
            'nik' => 'required|unique:users',
            'usia' => 'required|numeric',
            'alamat' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'level' => 2,
            'foto' => 'user.jpg',
            'nik' => $input['nik'],
            'phone' => $input['phone'],
            'usia' => $input['usia'],
            'alamat' => $input['alamat'],
        ]);
    }
}
