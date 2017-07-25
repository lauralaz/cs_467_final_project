<?php
class Database
{
    private static $dbName = 'zhaojing-db' ;
    private static $dbHost = 'oniddb.cws.oregonstate.edu' ;
    private static $dbUsername = 'zhaojing-db';
    private static $dbUserPassword = 'sbIDxOgerb8JEOiT';
     
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont )
       {     
        try
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
        }
        catch(PDOException $e)
        {
          die($e->getMessage()); 
        }
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>
