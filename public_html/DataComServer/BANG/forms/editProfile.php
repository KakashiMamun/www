<?php
    User::PushIntoREQUEST();
    $formError='';
    $formName='genericEditProfile.php';
    if(isset($_POST['formSubmitted']))
    {                                                     
        //ExtractVars();
        //exit();
        $_POST['userId']=$currentUserId;
        $_POST['class']=$currentUserLoginInfo['class'];
        if($_POST['class']=='Administrator')
            $_POST['administratorId']=$currentUserId;
        $formError=User::Update();                
        User::PushIntoREQUEST();
    }
    switch($_REQUEST['class'])
    {                          
        case 'Recipient':
             $formName='recipientBasicInfo.php';
             break;
        case 'Administrator':
             $formName='administratorBasicInfo.php';
             break;
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
                              <div>Update profile</div>
                        </span><span class='subHeadRight'>
                        </span>
                   </div>
<?php
    $_SESSION['formHidden']['updateLogin']='';
    $_SESSION['formHidden']['updateDetail']='';
    if($formName!='')
    {
        require_once($formName);
    }
?>          
              </div>           
              <!--content ends-->
         </div>
         <!--contentArea ends-->