<?php

namespace SocialNetwork\Http\Controllers\Auth;

use SocialNetwork\User;
use SocialNetwork\Profile;
use SocialNetwork\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'gender' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \SocialNetwork\User
     */
    protected function create(array $data)
    {
        if($data['gender'] == 'male'){
            $pic_path = 'male.jpg';
        }else{
            $pic_path = 'female.jpg';
        }
        $user =  User::create([
            'name' => $data['name'],
            'gender' => $data['gender'],
            'slug' => str_slug($data['name'], '-'),
            'email' => $data['email'],
            'pic' => $pic_path,
            'password' => Hash::make($data['password']),
        ]);
        Profile::create(['user_id' => $user->id]);
        return $user;
    }
}
