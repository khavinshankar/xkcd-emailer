<?php

namespace app;

use PDO;

class Database
{
    public $pdo;
    public static Database $db;

    public function __construct()
    {
        $dbhost = getenv("DB_HOST");
        $dbport = getenv("DB_PORT");
        $dbname = getenv("DB_NAME");
        $dbuser = getenv("DB_USER");
        $dbpass = getenv("DB_PASS");

        $this->pdo = new PDO("mysql:host=$dbhost;port=$dbport;dbname=$dbname", $dbuser, $dbpass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$db = $this;
    }

    public function getAllVerifiedUsers()
    {
        $query = $this->pdo->prepare("SELECT * FROM users WHERE is_verified = 1");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUser($email)
    {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserOtp($email)
    {
        $query = $this->pdo->prepare("SELECT verification_code FROM users WHERE email = :email");
        $query->bindValue(":email", $email);
        $query->execute();
        return $query->fetch();
    }

    public function createUser($user)
    {
        $query = $this->pdo->prepare("INSERT INTO users (email, verification_code, is_verified) 
        VALUES (:email, :verification_code, :is_verified)");

        $query->bindValue(":email", $user->email);
        $query->bindValue(":verification_code", $user->verification_code);
        $query->bindValue(":is_verified", $user->is_verified);

        $query->execute();
    }

    public function updateUser($user)
    {
        $statement = $this->pdo->prepare("UPDATE users SET verification_code = :verification_code, is_verified = :is_verified WHERE email = :email");
        $statement->bindValue(':verification_code', $user->verification_code);
        $statement->bindValue(':is_verified', $user->is_verified);
        $statement->bindValue(':email', $user->email);

        $statement->execute();
    }

    public function deleteUser($email)
    {
        $query = $this->pdo->prepare("DELETE FROM users WHERE email = :email");
        $query->bindValue(":email", $email);

        $query->execute();
    }
}
