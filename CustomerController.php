<?php

namespace App\Http\Controllers\REST;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\CustomerAccount;
use App\Classes\DatabaseHandler;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        return response(json_encode(array("status" => "index")),200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer_account = new CustomerAccount();
        $customer_account->setFirstName($request['first_name']);
        $customer_account->setLastName($request['last_name']);
        $customer_account->setUsername($request['username']);
        $customer_account->setEmailAddress($request['email_address']);
        $customer_account->setPassword($request['password']);
        $customer_account->setConfPassword($request['confirm_password']);

        $dbHandler = new DatabaseHandler();
        $result = $dbHandler->addCustomerAccount($customer_account);

        return json_encode($result);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    public function getUserProfile(Request $request) {
        $customer_account = new CustomerAccount();
        $customer_account->setUsername($request['username']);
        $customer_account->setPassword($request['password']);

        $dbHandler = new DatabaseHandler();
        $result = $dbHandler->authenticateUser($customer_account);

        return json_encode($result);
    }
}