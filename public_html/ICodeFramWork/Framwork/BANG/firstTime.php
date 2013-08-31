<?php
    require_once('includes/frontIncludes.php');
    User::Logout();
    if(($error=User::DoTestLogin($_REQUEST['userId']))=='')
    {
        //echo 'header?';
        Header('Location: member/');
        exit();
    }
    else
        echo $error;
?>