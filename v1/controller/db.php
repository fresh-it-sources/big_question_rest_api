<?php

class DB {

    private static $hostName = 'localhost';
    private static $hostDBName = '31286422_bigquestions';
    private static $hostUser = '31286422_bigquestions';
    private static $hostPass = 'KLQm19pr';
 
    private static $writeDBConnection;
    private static $readDBConnection;

    public static function connectWriteDB()
    {
        if(self::$writeDBConnection === null){
            self::$writeDBConnection = new PDO('mysql:host=localhost; dbname=31286422_bigquestions; charset=utf8', $hostUser, $hostPass);
            self::$writeDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$writeDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }

        return self::$writeDBConnection;
    }

    public static function connectReadDB()
    {
        if(self::$readDBConnection === null){
            self::$readDBConnection = new PDO('mysql:host=localhost; dbname=31286422_bigquestions; charset=utf8', $hostUser, $hostPass);
            self::$readDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$readDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }

        return self::$readDBConnection;
    }
}
