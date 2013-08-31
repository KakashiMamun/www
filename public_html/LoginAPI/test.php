<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 8/17/13
 * Time: 3:42 PM
 * To change this template use File | Settings | File Templates.
 */
//extract data from the post
//extract($_POST);
if(isset($_POST['user_name']) && isset($_POST['password']) && isset($_POST['TTL']))
{
//set POST variables

$url = 'http://testhost.com/LoginAPI/login.php';
$fields = array(
    'user_name' => urlencode($_POST['user_name']),
    'password' => urlencode($_POST['password']),
    'TTL' => urlencode($_POST['TTL']),
);
$fields_string = '';
//url-ify the data for the POST
foreach($fields as $key=>$value)
{
    $fields_string .= $key.'='.$value.'&';
}
trim($fields_string, '&');
var_dump($fields_string);
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
else
{
    echo 'Login Error!!';
}
?>

<form method="post" action="" xmlns="http://www.w3.org/1999/html">
    Username:
    <input type="text" name="user_name"></input>
    Password:
    <input type="password" name="password"></input>
    TTL:
    <input type="number" name="TTL"/>
    <input type="submit" value="login"/>
</form>
