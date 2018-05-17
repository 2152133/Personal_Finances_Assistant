<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $id;
    public $owner_id;
    public $account_type_id;
    public $date;
    public $code;
    public $description;
    public $start_balance;
    public $current_balance;
    public $last_movement_date;

    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $name => $value) {
            $this->$name = $value;
        }
    }

    public static function all()
    {
        $pdo =  Account::dbConn();

        $sql = "SELECT * FROM accounts";
        $stmt= $pdo->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        User::closeDBConn($pdo);

        return $result;
    }

    public static function accountsFromUser($user_id)
    {
        $pdo =  Account::dbConn();

        $sql = "SELECT * FROM accounts WHERE owner_id = :user_id ";
        $stmt= $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        User::closeDBConn($pdo);

        return $result;
    }

    public static function dbConn() {
        $host= 'localhost';
        $dbname= 'Personal_Finances_Assistant_DB';
        $user= 'homestead';
        $password= 'secret';
        $charset= 'utf8';
        $dsn= "mysql:host=$host;dbname=$dbname;charset=$charset";
        $opt= [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        $pdo = new PDO($dsn, $user, $password, $opt);
        
        return $pdo; 
    }



}
