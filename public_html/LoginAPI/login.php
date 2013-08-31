<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 8/17/13
 * Time: 3:08 PM
 * To change this template use File | Settings | File Templates.
 */

require_once('DBStuff/Database.php');
require_once('DBStuff/ICodeDB.class.php');
$salt = 'urboshiLogin';
if(isset($_POST['user_name'])){

    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $TTL  = $_POST['TTL'];
    $sql = 'SELECT * FROM loginAPI.user where user_name =\''.$user_name.'\' and password=\''.$password.'\'';

    echo $sql;
    $result = Database::getResult($sql);

    var_dump($result);

}else{

    echo 'no such user';
}