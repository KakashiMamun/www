<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 8/17/13
 * Time: 9:43 PM
 * To change this template use File | Settings | File Templates.
 */


      require_once('DBConfig.php');
      //Simply include this file on your page
      require_once('DBConnect.php');


  class Database {

  public static function getResult($sql){
  //Set up all yor paramaters for connection
        $db = new DbConnect(DB_HOST,DB_USER,DB_PASS,DB_NAME,true,false);


   //Open the connection to your database
       $db->open() or die($db->error());

      //Query the database now the connection has been made
       $db->query($sql) or die($db->error());

       //You have several options on ways of fetching the data

       //as an example I shall use

      //var_dump($db->fetcharray());
//      var_dump($db->fetchassoc());

//      var_dump($db->freeresult());

      $result =  $db->fetchassoc();

      //close your connection
        $db->close();

      return $result;

    }
  }

?>
