<?php
   $CONN= mysql_connect('localhost','root','123') or die('could not connect to db');
   mysql_select_db('loginserver');
   mysql_query("SET NAMES utf8");
?>