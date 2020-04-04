<?php

namespace App\Classes;


class CustomerAccount{
    private $first_name;
    private $last_name;
    private $username;
    private $email_address;
    private $password;
    private $conf_password;

    function __construct(){
        $this->first_name = "";
        $this->last_name = "";
        $this->username = "";
        $this->email_address = "";
        $this->password = "";
        $this->conf_password = "";
    }

    public function setFirstName($first_name){
        $this->first_name = $first_name;
    }
    public function setLastName($last_name){
        $this->last_name = $last_name;
    }
    public function setUsername($username){
        $this->username = $username;
    }
    public function setEmailAddress($email_address){
        $this->email_address = $email_address;
    }
    public function setPassword($password){
        $this->password = $password;
    }

    public function setConfPassword($conf_password){
        $this->conf_password = $conf_password;
    }

    public function getFirstName(){
        return $this->first_name;
    }
    public function getLastName(){
        return $this->last_name;
    }
    public function getUsername(){
        return $this->username;
    }
    public function getEmailAddress(){
        return $this->email_address;
    }
    public function getPassword(){
        return $this->password;
    }

    public function getConfPassword(){
        return $this->conf_password;
    }

    public function passwordMatches(){
        return $this->password == $this->conf_password;
    }
}