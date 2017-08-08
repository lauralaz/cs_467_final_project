<?php
class Database
{
    private static $dbName = 'cs_467' ;
    private static $dbHost = 'mysqldb.ctktrxaj5nit.us-west-2.rds.amazonaws.com' ;
    private static $dbUsername = 'cs467';
    private static $dbUserPassword = 'August2017';
     
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
