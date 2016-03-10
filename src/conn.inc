<?php

class Conn{

    var $mysqli;
    private static $con = null;

    private function __construct($ip="114.215.113.71",
                         $user = "root",
                         $pwd = "aschen1243",
                         $dbname="questionnaire")
    {

        $this->mysqli = new mysqli($ip, $user, $pwd, $dbname);

        if(mysqli_connect_errno()){
            echo "Error:".mysqli_connect_error();
            exit;
        }


        $this->mysqli->set_charset("utf8");

    }

    public static function getInstence(){

        if(is_null(self::$con) || isset(self::$con)){

            self::$con = new Conn();

        }
        return self::$con;

    }

    public function query($sql){

        return mysql_query($sql, self::$con);

    }

}

