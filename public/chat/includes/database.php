<?php
require("medoo.php");
$mode="development";
if($mode=="development"){
$db = new medoo([
      // required
      'database_type' => 'mysql',
      'database_name' => 'chat',
      'server' => 'localhost',
      'username' => 'root',
      'password' => '',
      'charset' => 'utf8',

      // optional
      'port' => 3306,
      // driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
      'option' => [
            PDO::ATTR_CASE => PDO::CASE_NATURAL
      ]
]);
}
else
{
   $db = new medoo([
      // required
      'database_type' => 'mysql',
      'database_name' => 'chat',
      'server' => 'localhost',
      'username' => 'root',
      'password' => '',
      'charset' => 'utf8',


      /*
	  'database_type' => 'mysql',
	  'database_name' => 'test_chat',
	  'server' => '10.11.0.187',
	  'username' => 'followondbuser',
	  'password' => 'followondbpa55',
	  'charset' => 'utf8',
      */

      // optional
      'port' => 3306,
      // driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
      'option' => [
            PDO::ATTR_CASE => PDO::CASE_NATURAL
      ]
]);
}
?>