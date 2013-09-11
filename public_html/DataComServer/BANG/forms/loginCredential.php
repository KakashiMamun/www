<?php
    User::PushIntoREQUEST();
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
                              <div>Login</div>
                        </span><span class='subHeadRight'>
                        </span>
                   </div>      
                   <form action='' method='post' enctype='multipart/form-data'>
                       <div class='form'>
                            <div class='formHead'>
                                 Your details
                            </div>
                            <div class='bigPadder'>
                                 <table  cellpadding='0' cellspacing='0'>
                                      <tr>     
                                          <td class='leftTd'> Email: (leave blank for no change)
                                          </td>
                                          <td class='rightTd'><input type='text' name='email' id='' value="<?php echo ICodeTools::GetRawValue('email'); ?>">
                                          </td>
                                      </tr>            
                                      <tr>     
                                          <td class='leftTd'> Retype Email:
                                          </td>
                                          <td class='rightTd'><input type='text' name='email2' id='' value="<?php echo ICodeTools::GetRawValue('email'); ?>">
                                          </td>
                                      </tr>  
                                      <tr>     
                                          <td class='leftTd'> Password: (leave blank for no change)
                                          </td>
                                          <td class='rightTd'><input type='text' name='password' id='' value="">
                                          </td>
                                      </tr>            
                                      <tr>     
                                          <td class='leftTd'> Retype Password:
                                          </td>
                                          <td class='rightTd'><input type='text' name='password2' id='' value="">
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