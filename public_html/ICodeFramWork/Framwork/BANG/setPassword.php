<?php                                                
    require_once('includes/frontIncludes.php');
    //exit();       
    $error=$loginError;
    if(isset($_GET['tokenMagic']))
    {
        $error=User::VerifyResetToken($_GET['tokenMagic']);
        if(is_numeric($error) && $error>0)
        {
            Header("Location: firstTime.php?userId=$error");
            exit();
        }
        else
        {
            die($error);
        }
    }
    else if(isset($_POST['password']))
    {
        /* is it hackable */
        $_POST['userId']=$currentUserId;
        $_POST['email']=''; //means no change
        $status=User::UpdateLogin();
        if($status===true)
        {
            $status=User::ChangeStatus($currentUserId,'active');
            if($status===true)
            {     
                 Header('Location: member/');
                 exit();     
            }
            else
                $error=$status;

        }
        else
            $error=$status;
    }
    //echo "Iam here $loginError";
    if($currentUserId!=0)
    {                    
        switch($currentUserLoginInfo['status'])
        {
            case 'active': 
                 Header('Location: member/');
                 exit();      
            case 'needPassword':
                 $form='password';
                 break;
            default:
                 Header('Location: login.php');
                 exit();

        }
    }
    else
    {
        Header('Location: login.php');
        exit();
    }

                              
    /* start echo */
    require_once('header.php');    
    /** printing starts **/
    echo"<div id='status' class='formError'>
              <img src='images/magicStatus.png'><span> $error</span>
              <span id='jsError'>
              </span>
        </div>";
                    

?>            
         <!--content area starts-->
         <div id='contentArea' class='sitecomPadder'>
              <!--content starts-->
              <div id='content'>
<?php
    if($form=='password')
    {
?>
                                           
                   <div class='subHead'>
                        <span class='subHeadLeft'>
                              <div>Set Password</div>
                        </span><span class='subHeadRight'>
                        </span>
                   </div>            

                   <form enctype="multipart/form-data" method="post"  action=''>
                       <div class='form'>
                            <div class='formHead'>
                                 Create your password to proceed.
                            </div>
                            <div class='bigPadder'>
                                 Type Password:
                                 <br>
                                 <input type="password" name='password'>
                                 <br>
                                 Retype Password:
                                 <br>
                                 <input type='password' name='password2'>
                                 <br>                                                    
                                 <input type='image' class='button border0' src='images/submit.png' name='' id='submit' value=' Submit '>
                                 <input type='hidden' name='updateLogin' value='yes'>  
                            </div>                                                
                            <?php
                                if(isset($_SESSION['formHidden']))
                                {
                                    foreach($_SESSION['formHidden'] as $key=>$val)
                                       echo "<input type='hidden' name='$key' value='$val' />";
                                }
                            ?>

                            <input type="hidden" value="yes" name="formSubmitted">

                        </div>
                   </form>
<?php
    }
?>             
              </div>           
              <!--content ends-->
         </div>
         <!--contentArea ends-->
<?php

    require_once('footer.php');
?>
        

        