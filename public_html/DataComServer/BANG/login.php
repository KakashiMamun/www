<?php                                                
    require_once('includes/frontIncludes.php');
    User::Logout();
    $error=$loginError;
    $form='login';
    if(isset($_GET['forgot']))
    {
        $form='forgot';
    }
    if(isset($_POST['forgotEmail']))
    {
        $error=User::EmailPasswordResetLink($_POST['forgotEmail']);
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
    if($form=='login')
    {
?>

                   <div class='subHead'>
                        <span class='subHeadLeft'>
                              <div>Login</div>
                        </span><span class='subHeadRight'>
                        </span>
                   </div>            

                   <form enctype="multipart/form-data" method="post"  action='member/'>
                       <div class='form'>
                            <div class='formHead'>
                                 Your details
                            </div>
                            <div class='bigPadder'>
                                 Email:
                                 <br>
                                 <input type="text" name='loginEmail'>
                                 <br>
                                 Password:
                                 <br>
                                 <input type='password' name='password'>
                                 <br>
                                 <input type='image' class='button border0' src='images/login.png' name='' id='submit' value=' Submit '>
                                 <br>
                                 <br>
                                 <a href='login.php?forgot=yes'>Click here</a> if you forgot your password. You will get the password changing link in your email. Link will expire in 1 hour.
        
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
    else if($form=='forgot')
    {
?>
                   <div class='subHead'>
                        <span class='subHeadLeft'>
                              <div>Recover Password</div>
                        </span><span class='subHeadRight'>
                        </span>
                   </div>   
                   <form enctype="multipart/form-data" method="post"  action=''>
                       <div class='form'>
                            <div class='formHead'>
                                 Your details
                            </div>
                            <div class='bigPadder'>
                                 Email:
                                 <br>
                                 <input type="text" name='forgotEmail'>
                                 <br>
                                 <input type='image' class='button border0' src='images/submit.png' name='' id='submit' value=' Submit '>
                                 <br>
                                 <br>
                                 <a href='login.php'>Click here</a> to go back to the login page.
        
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
        
        