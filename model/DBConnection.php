<?php

namespace sql;

class DBConnection
{
    private static $host = "localhost";
    private static $user = "veena";
    private static $password = "dhruv1111";
    private static $database = "kbz_ticketing_prod";

    public static function createConnection(){
        return mysqli_connect(self::$host,self::$user,self::$password,self::$database);
    }

    public static function closeConnection($conn){
        mysqli_close($conn);
    }
}