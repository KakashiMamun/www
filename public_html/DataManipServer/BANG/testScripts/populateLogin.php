<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 8/19/13
 * Time: 11:45 AM
 * To change this template use File | Settings | File Templates.
 **/

require_once('../includes/frontIncludes.php');


$resultSet = ICodeDB::GetResultsSet('Select user_id,email,password from Bang.user');

foreach($resultSet as $user){
//    print_r($user);
//    echo '<br>';
    postData($user);
}



?>
<?php

function postData($user){
    $url = 'http://banghost.com/loginAPI.php';
    $fields = $user;
    $fields_string = '';
//url-ify the data for the POST
    foreach($fields as $key=>$value)
    {
        $fields_string .= $key.'='.$value.'&';
    }
    trim($fields_string, '&');
//var_dump($fields_string);
//open connection
    $ch = curl_init();

//set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//execute post
    $result = curl_exec($ch);

//close connection
    curl_close($ch);
}

