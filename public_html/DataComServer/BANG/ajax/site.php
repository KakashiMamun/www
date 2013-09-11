<?php
    require_once('../includes/backIncludes.php');
    if(isset($_POST['task']))
    {
        $data=call_user_func(array('Site',$_POST['task']),$_POST['userId'],$currentUserId);
        //print_r($data);
        echo ICodeTools::ArrayToJSON($data);
    }
    else
        return 0;
?>