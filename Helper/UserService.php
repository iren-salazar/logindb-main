<?php

namespace App\Helper;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;


class UserService {
    public $email, $password;

    public function __construct($email, $password) 
    {
        $this->email = $email;
        $this->password = $password;
    }
        
    public function validateInput() 
    {
        $validator = validator::make(['email' => $this->email, 'password'=>$this->password],
        [
            'email' => ['required', 'email:rfc,dns','unique:users'],
            'password' => ['required', 'string', Password::min(8)]
        ]
        );

        if ($validator->fails())
        {
            return ['status' => false, 'messages'=> $validator->messages()];
        }
        else {
            return ['status' => true];
        }
    }

    public function register($deviceName)
    {
        $validate =$this->validateInput();
        if ($validate['status'] == false)
        {
            return $validate;
        }
        else {

            $user = User::create(['email'=> $this->email,'password'=>Hash::make($this->password)]);
            $token = $user->createToken($deviceName)->plainTextToken;
            return ['status' => true, 'token' => $token, 'user' => $user];
        }
    }
}