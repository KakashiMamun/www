<?php                                                
    require_once('includes/frontIncludes.php');
    User::Logout();
    $error=$loginError;
    $form='login';
    if(isset($_GET['token']))
    {
        $userId=Invitation::ProcessToken();
        //echo "userId:$userId";
        if(is_numeric($userId) && $userId>0)
        {
            //check user credential
            //do auto login
            if(($error=User::DoTestLogin($userId))=='')
            {
                //echo 'header?';
                Header('Location: member/');
                exit();
            }
            else
            {
                //echo $error;
                Header('Location: member/');
                exit();
            }
        }
        else
            $error=$userId;
    }
    else
        $error="no token found";

?>
<?php
    if($error!='')
      echo  "<div id = 'status'>
        $error
      </div>";
?>

        