<?php

namespace App\Http\Controllers\REST;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\CustomerAccount;
use App\Classes\DatabaseHandler;

class Authenticate extends Controller
{
    public function getUserProfile(Request $request) {
        $customer_account = new CustomerAccount();
        $customer_account->setUsername($request['username']);
        $customer_account->setPassword($request['password']);

        $dbHandler = new DatabaseHandler();
        $result = $dbHandler->authenticateUser($customer_account);

        return json_encode($result);
    }
}