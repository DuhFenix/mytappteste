<?php 
 

class Env {
   
    private static $localhost;

   
    public static function getEnv(){
        include "./domainslist.php";

        static::$localhost = (object)[
            "host"      =>  "localhost",
            "dbname"        => "mytap",
            "username"      => "root",
            "password"      => "",
            "timezone"  => "America/Sao_Paulo",
            "write" =>(object)[
                "host"      =>  "localhost",
                "dbname"    => "mytap",
                "username"      => "root",
                "password"      => "",
            ],
            "read" =>(object)[
                "host"      =>  "localhost",
                "dbname"    => "mytap",
                "username"      => "root",
                "password"      => "",
            ],
        ];
     
        # Store the strings that defines the enviroment
        return static::$localhost;
    } 
}