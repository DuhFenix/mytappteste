<?php
namespace Connection;

use PDO;
use  Env; 

ini_set('display_errors', 0);
ini_set('display_startup_erros', 0);
error_reporting(0);
date_default_timezone_set('America/Sao_Paulo');

class Conexao
{

    public static $instance;
    public static $instanceRead;
    public static $instanceWriter;
    public static $instanceWriterLog;
    private static $env;

    private function __construct(){}

    public static function getInstance()
    {
        static::$env = Env::getEnv(); 

        $timezone = static::$env->timezone; 
        $host     = static::$env->host; 
        $dbname   = static::$env->dbname;
        $username = static::$env->username;
        $password = static::$env->password;   

        $configDb = "mysql:host={$host};dbname={$dbname};charset=utf8";

        if (!isset(self::$instance)) {
            self::$instance = new PDO($configDb, $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));// array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8, time_zone = "-6:00";"));
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
        }
        return self::$instance;
    }
    public static function getInstanceWrite()
    {
        static::$env =  Env::getEnv(); 
       
        
        $host     = static::$env->write->host;
        $dbname   = static::$env->write->dbname;
        $username = static::$env->write->username;
        $password = static::$env->write->password;  


        $configDb = "mysql:host={$host};dbname={$dbname};charset=utf8";

        if (!isset(self::$instanceWriter)) {
            self::$instanceWriter = new PDO($configDb, $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$instanceWriter->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instanceWriter->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
        }

        return self::$instanceWriter;
    }

    public static function getInstanceRead()
    {   
        static::$env =  Env::getEnv(); 
        
        $host     = static::$env->read->host;
        $dbname   = static::$env->read->dbname;
        $username = static::$env->read->username;
        $password = static::$env->read->password;   

        $configDb = "mysql:host={$host};dbname={$dbname};charset=utf8";

        if (!isset(self::$instanceRead)) {
            self::$instanceRead = new PDO($configDb, $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$instanceRead->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instanceRead->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
        }

        return self::$instanceRead;
    }

    public static function getInstanceWriteLog()
    {
        static::$env =  Env::getEnv();  
        
        $host     = static::$env->writeLog->host;
        $dbname   = static::$env->writeLog->dbname;
        $username = static::$env->writeLog->username;
        $password = static::$env->writeLog->password;  
       

        $configDb = "mysql:host={$host};dbname={$dbname};charset=utf8";

        if (!isset(self::$instanceWriterLog)) {
            self::$instanceWriterLog = new PDO($configDb, $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$instanceWriterLog->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instanceWriterLog->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
        }

        return self::$instanceWriterLog;
    }

}
