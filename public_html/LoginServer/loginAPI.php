<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 8/17/13
 * Time: 3:08 PM
 * To change this template use File | Settings | File Templates.
 */
require_once('includes/frontIncludes.php');
require_once('classes/LoginModule.php');

if(isset($_POST)){
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    if(isset($_POST['TTL']))
        $TTL  = $_POST['TTL'];
    else
        $TTL  = rand(0,10);

    $result = LoginModule::GetUser($email, $password);

    if(!empty($result)){
            LoginModule::CreateOrUpdateSession($result,$TTL);
            $user_id = $result['user_id'];
            $sessiondata = LoginModule::GenerateSessionData($user_id);


            ob_start();
            $encryted = ICodeTools::SimpleEncrypt($sessiondata['session_key']);
            echo $encryted;
            $outPut = ob_get_contents();



            header('Content-Type: text/html'); // plain text file
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header('Content-Length: '.filesize($outPut));


            ob_end_flush();

            fastcgi_finish_request();

//            $sql = "INSERT INTO session_history values(NOW());";
//
//            ICodeDB::FreshInsert($sql);

            exit();
    }else
    {

        echo 'Incorrect Login Info';
    }

}else
{
    echo 'no such user';
}
?>

<?php



