<?php
    User::PushIntoREQUEST();
    //print_r($_REQUEST);
    $formError='';
    $_SESSION['formHidden']['updateLogin']='';
    if(isset($_POST['formSubmitted']))
    {                                                     
        $_POST['userId']=$currentUserId;
        $_POST['class']=$currentUserLoginInfo['class'];
        $formError=User::Update();                
        User::PushIntoREQUEST();
    }
    /** printing starts **/
    echo"<div id='status' class='formError'>
              <img src='../images/magicStatus.png'><span>$formError</span>    
              <span id='jsError'>
              </span>
       </div>";
?>                       
         <!--content area starts-->
         <div id='contentArea' class='sitecomPadder'>
              <!--content starts-->
              <div id='content'>
                            
                   <div class='subHead'>
                        <span class='subHeadLeft'>
                              <div>Menu timeout</div>
                        </span><span class='subHeadRight'>
                        </span>
                   </div>      
                   <form action='' method='post' enctype='multipart/form-data'>
                       <div class='form'>
                            <div class='formHead'>
                                Minutes to logout automatically after no activity
                            </div>
                            <div class='bigPadder'>
                                 <b>Make it long enough otherwise you may lose any unsaved work here.</b>
                                 <table class='profile' cellpadding='0' cellspacing='0'>
                                      <tr>     
                                          <td class='leftTd'> Timeout in minutes:
                                          </td>
                                          <td class='rightTd'><input type='text' name='forgetMinutes' id='' value="<?php echo ICodeTools::GetRawValue('forgetMinutes','forget_minutes'); ?>">
                                          </td>
                                      </tr>
                                      <tr>     
                                          <td class='leftTd'>
                                          </td>
                                          <td class='rightTd'>
                                              <input type='image' class='button border0' src='../images/submit.png' name='' id='submit' value=' Submit '>
                                          </td>
                                      </tr>
                                 </table>         
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
              </div>           
              <!--content ends-->
         </div>
         <!--contentArea ends-->