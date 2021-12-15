<?php

namespace app\models;

use app\Database;

class User {
    public string $email = "";
    public ?int $verification_code = null;
    public bool $is_verified = false;


    public function __construct ($email) {
        $db = Database::$db;
        $this->email = $email;
        $user = $db->getUser($email);

        if($user) {
            $this->load($user);
        } else {
            $db->createUser($this);
        }
    } 

    public function load ($user) {
        $this->email = $user["email"];
        $this->verification_code = $user["verification_code"] ?? $this->verification_code;
        $this->is_verified = $user["is_verified"] ?? $this->is_verified;
    }

    public function reset_verification_code () {
        if ($this->is_verified) return false;
        $this->verification_code = random_int(100000, 999999);
        $this->update();
        return $this->verification_code;
    }

    public function verify($user_code)
    {
        if (strval($this->verification_code) === $user_code) {
            return $this->mark_verified();
        }
        
        return false;  
    }

    public function mark_verified () {
        $this->is_verified = true;
        $this->update();
        return true;
    }

    public function update () {
        $db = Database::$db;
        $db->updateUser($this);
    }

    public function verify_delete($otp)
    {
        $db = Database::$db;
        if ($otp === $this->verification_code) $db->deleteUser($this->email);
    }
}
