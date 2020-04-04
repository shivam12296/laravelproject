<?php

namespace App\Http\Controllers\Auth;

use App\User as User;
use App\ShopProfile as ShopProfile;
use App\Http\Controllers\Controller;
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
    protected $redirectTo = '/';

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
            'username' => 'required|string|max:12|unique:users',
            'email_address' => 'required|string|email|max:191|unique:shop_profiles',
            'password' => 'required|string|min:6|confirmed',
            'shop_name' => 'required|string|unique:shop_profiles',
            'shop_address' => 'required|string',
            'contact_number' => 'required|numeric|min:7'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // create new shop profile
        $new_shop = new ShopProfile;
        $new_shop->shop_name = $data['shop_name'];
        $new_shop->shop_address = $data['shop_address'];
        $new_shop->contact_number = $data['contact_number'];
        $new_shop->email_address = $data['email_address'];
        $new_shop->save();
        
        // get created id for reference
        $new_shop_id = $new_shop->id;

        // save user account
        $new_account = new User;
        $new_account->username = $data['username'];
        $new_account->password = Hash::make($data['password']);
        $new_account->user_type = '1';
        $new_account->profile_id = $new_shop_id;
        $new_account->save();

        // save created id of user account to shop profiles
        $new_shop = ShopProfile::find($new_shop_id);
        $new_shop->user_id = $new_account->id;
        $new_shop->save();
        return $new_account;
    }
}