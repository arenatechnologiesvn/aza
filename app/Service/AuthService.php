<?php

namespace App\Service;

use App\User;
use App\VerifyUser;
use App\Mail\VerifyMail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class AuthService
{
    use RegistersUsers;

    public function __construct()
    {
        //
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function register(array $data)
    {
        try {
            DB::beginTransaction();
            $data['password'] = substr(uniqid(), 0, 6);
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role_id' => $data['role_id'],
                'password' => \Hash::make($data['password']),
                'phone' => $data['phone'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'address' => $data['address'],
                'is_verified' => $data['is_verified'],
                'is_active' => $data['is_verified']
            ]);

            // TODO: use for verifying email next developve time
            // $verifyUser = VerifyUser::create([
            //     'user_id' => $user->id,
            //     'token' => str_random(40)
            // ]);

            $user->randomPassword = $data['password'];
            \Mail::to($user->email)->send(new VerifyMail($user));

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            throw $e;
        }
    }
}
