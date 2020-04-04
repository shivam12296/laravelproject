<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ShopAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create new shop profile
        $seed_shop = new App\ShopProfile;
        $seed_shop->shop_name = 'Concept Store';
        $seed_shop->shop_address = 'Batangas City';
        $seed_shop->contact_number = '09171234567';
        $seed_shop->email_address = 'concept@default.com';
        $seed_shop->save();

        // get created id for reference
        $seed_shop_id = $seed_shop->id;

        // save user account
        $seed_account = new App\User;
        $seed_account->username = 'conceptstore';
        $seed_account->password = Hash::make('password123');
        $seed_account->user_type = '1';
        $seed_account->profile_id = $seed_shop_id;
        $seed_account->save();

        // save created id of user account to shop profiles
        $seed_shop = App\ShopProfile::find($seed_shop_id);
        $seed_shop->user_id = $seed_account->id;
        $seed_shop->save();
    }
}