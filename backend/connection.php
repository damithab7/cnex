<?php

use Database as GlobalDatabase;
class Database{

   public static $connection;

   public static function setUpConnection()
   {
      if(!isset(Database::$connection)){

         Database::$connection = new mysqli("127.0.0.1","root","1234567","cnex");
 
      }
   }

   public static function iud($q){
      Database::setUpConnection();
      Database::$connection->query($q);
   }

   public static function search($q){
      Database::setUpConnection();
      $resultset = Database::$connection->query($q);
      return $resultset;
   }

}

?>