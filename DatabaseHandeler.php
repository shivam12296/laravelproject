<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DatabaseHandler
 *
 * @author Power
 */

namespace App\Classes;

use App\Classes\CustomerAccount;
use App\Classes\Config;
use Illuminate\Support\Facades\Hash;

class DatabaseHandler{
    private $config;

    function __construct() {
        $this->config = new Config();
    }

    private function usernameDoesNotExist($account_username){
        $query = "CALL checkUsername('".$account_username."')" or die(mysqli_error($this->config->getLink()));
        $result = mysqli_query($this->config->getLink(), $query);

        return mysqli_num_rows($result) == 0 ? true : false;
    }

    public function addCustomerAccount($account) {
        if(empty($account->getFirstName()) ||
        empty($account->getLastName()) ||
        empty($account->getEmailAddress()) ||
        empty($account->getUsername()) ||
        empty($account->getPassword())){
        return array(
            "status" => "failed",
            "message" => "Incomplete Fields"
            );
        }

        if(!$account->passwordMatches()){
            return array(
                "status" => "failed",
                "message" => "Passwords do not match"
            );
        }
        
        if($this->usernameDoesNotExist($account->getUsername())){
            
            mysqli_next_result($this->config->getLink());

            $query = "CALL checkCustomerEmailAddress('".$account->getEmailAddress()."')" or die(mysqli_error($this->config->getLink()));
            $result = mysqli_query($this->config->getLink(), $query);
            
            if(mysqli_num_rows($result) == 0){

            mysqli_next_result($this->config->getLink());

            $query = "CALL addCustomerProfile('".$account->getFirstName()."', '".$account->getLastName()."', '".$account->getEmailAddress()."')" or die(mysqli_error($this->config->getLink()));

            $result = mysqli_query($this->config->getLink(), $query);

            if($result){
                $id = mysqli_fetch_assoc($result)['LAST_INSERT_ID()'];
                mysqli_next_result($this->config->getLink());

                $query = "CALL addCustomerAccount('".$account->getUsername()."', '".Hash::make($account->getPassword())."', '".$id."')" or die(mysqli_error($this->config->getLink()));
                $result = mysqli_query($this->config->getLink(), $query);

                if($result){
                    return array(
                        "status" => "success"
                    );
                } else {
                    return array(
                        "status" => "failed",
                        "message" => "Error creating account"
                    );
                }
            } else {
                return array(
                    "status" => "failed",
                    "message" => "Error creating account"
                );
            }
            } else {
                return array(
                    "status" => "failed",
                    "message" => "Email Address is already taken"
                );
            }
        } else {
            return array(
                    "status" => "failed",
                    "message" => "Username is already taken"
                );
        }
    }

    public function authenticateUser($account){
        if(empty($account->getUsername())
            || empty($account->getPassword())){
                return array(
                    "status" => "failed",
                    "message" => "Incomplete Fields"
                );
            }

        if($this->usernameDoesNotExist($account->getUsername())){
            return array(
                "status" => "failed",
                "message" => "Incorrect Username/Password"
            );
        }
        
        mysqli_next_result($this->config->getLink());

        $query = "CALL retrieveInfoForAuthentication('".$account->getUsername()."')" or die(mysqli_error($this->config->getLink()));
        $result = mysqli_query($this->config->getLink(), $query);

        $account_data = mysqli_fetch_assoc($result);

        if(Hash::check($account->getPassword(), $account_data['password'])){
            
            mysqli_next_result($this->config->getLink());
            $query = "CALL getProfileInformation('".$account->getUsername()."')" or die(mysqli_error($this->config->getLink()));
            $result = mysqli_query($this->config->getLink(), $query);

            if(mysqli_num_rows($result) > 0){
                $account_data = mysqli_fetch_assoc($result);
        
                return array(
                    "status" => "success",
                    "profile_data" => $account_data
                );
            } else {
                return array(
                    "status" => "failed",
                    "message" => "Error retrieving account"
                );
            }
        } else {
            return array(
                "status" => "failed",
                "message" => "Incorrect Username/Password"
            );
        }
    }
}