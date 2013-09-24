<?php               
    require_once('includes/frontIncludes.php');
    User::Logout();
    $fatalError='';
    $error='';
    $formError='';
    $form='login';
    $PUBLIC_CLASSES=array('Manager', 'Director', 'Accountant','Employee', 'Contact');
    if(!isset($_REQUEST['class']))
    {
        $fatalError='No user type defined for registration or no session to restore.';
    }
    else if(isset($_POST['formSubmitted']))
    {
        //ExtractVars();
        $cityIdInv=City::Add($_POST['cityInv'],$_POST['stateIdInv']);
        $_POST['cityIdInv']=$cityIdInv;

        $_POST['class']=$_REQUEST['class'];
        $_POST['status']='needPassword';
        $_POST['password']='test';
        $_POST['password2']='test';    
        $_POST['mobile']='00000000';

        //Public registration permission

        if(in_array($_POST['class'],$PUBLIC_CLASSES))
        {

            $error=User::Add();
            if(is_numeric($error) && $error>0)
            {
                $_REQUEST['userId']=$error;   
                if(($error=User::DoTestLogin($error))=='')
                {
                    //echo 'header?';
                    Header('Location: member/');
                    exit();
                }
            }
        }
        else
        {
            $error='This registration is not open for public';
        }

    }
    else if(isset($_REQUEST['class']))
    {
        $_SESSION['formHidden']['class']=stripslashes($_GET['class']);
    }
    /* start echo */
    require_once('header.php');    
    /** printing starts **/
    echo"<div id='status' class='formError'>
              <img src='images/magicStatus.png'><span>$formError $fatalError $error</span>
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
                              <div>Register</div>
                        </span><span class='subHeadRight'>
                        </span>
                   </div>
              <?php
                  if($fatalError=='')
                  {
                      require_once('forms/register'.ucfirst($_GET['class']).'.php');
                  }
              ?>   
              </div>           
              <!--content ends-->
         </div>
         <!--contentArea ends-->
<?php

    require_once('footer.php');
?>
        