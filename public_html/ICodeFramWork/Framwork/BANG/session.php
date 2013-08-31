<?php               
    require_once('includes/frontIncludes.php');
    User::Logout();
    $fatalError='';
    $error='';
    $form='login';
    if(!isset($_REQUEST['userId']))
    {
        $fatalError='No user type defined for registration or no session to restore.';
    }

    if(isset($_REQUEST['userId']))
    {
        //restore some session?
        $userId=$_REQUEST['userId'];
        $userInfo=User::GetInfo($userId);
        switch($userInfo['class'])
        {
            
        }
    }

?>
<?php
    if($fatalError!='')
    {
        echo"<div id = 'status'>
            $fatalError
            </div>";
    }
    else
    {         
        if($error!='')
        {
            echo"<div id = 'status'>
                $error
                </div>";
        }
        require_once('forms/register'.ucfirst($_GET['class']).'gte.php');
    }
?>
        