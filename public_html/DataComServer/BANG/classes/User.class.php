<?php
class User
{
                        
    /* member type is the class name of that member */
    /*
    public static $insertFields=array('class','password','password2','status',
                              'fName','lName','jobTitle','companyName','address1',
                              'stateId','city','postcode','email','email2','mobile'
                              );
   */
    public static $insertFields=array('class','password','password2','status',
                              'fName','lName',
                              'email','email2'
                              );
    public static $updateFields=array('userId');
    public static $tableName='user';
    public static $idName='user_id';
    public static $formIdName='userId';
    public static $className='User';
                                    
    public static function PushIntoREQUEST()
    {                   
        global $currentUserId, $currentUserLoginInfo, $currentUserDetails,  $STATUSES;    
        $_REQUEST=array_merge($_REQUEST,$currentUserLoginInfo,$currentUserDetails);
        //print_r($_REQUEST);
        $address=unserialize($currentUserDetails['address']);
        $_REQUEST['address1']=$address[0];
        $_REQUEST['address2']=(isset($address[1]))?$address[1]:'';
        $_REQUEST['address3']=(isset($address[2]))?$address[2]:'';
        $_REQUEST['city']=City::GetCityName($_REQUEST['city_id']);
    }
    public static function PushIntoPOST()
    {                   
        global $currentUserId, $currentUserLoginInfo, $currentUserDetails,  $STATUSES;    
        $_POST=array_merge($_POST,$currentUserLoginInfo,$currentUserDetails);
        //print_r($_POST);
        $address=unserialize($currentUserDetails['address']);
        $_POST['address1']=$address[0];
        $_POST['address2']=(isset($address[1]))?$address[1]:'';
        $_POST['address3']=(isset($address[2]))?$address[2]:'';    
        $_POST['city']=City::GetCityName($_REQUEST['city_id']);
    }
    public static function RefreshCurrentUser()
    {
        global $currentUserId, $currentUserLoginInfo, $currentUserDetails,  $STATUSES;                
        $currentUserLoginInfo=User::GetInfo($currentUserId);
        $currentUserDetails=User::GetDetailInfo($currentUserId);
    }
    public static function Logout()
    {                               
        SystemController::SetupGlobals();
        setcookie('auth','',0,'/');
    }
    public static function DoTestLogin($userId)
    {
        //this is a very sensitive function and hackable. This is for users who needs password
        $userInfo=User::Getinfo($userId);
        unset($_COOKIE['auth']);                
        $_POST['loginEmail']=$userInfo['email'];
        $_POST['password']='test';
        return User::Login();
    }
    public static function Login()
    {
        global $currentUserId, $currentUserLoginInfo, $currentUserDetails, $loginError, $STATUSES;
        if(isset($_COOKIE['auth']))
        {
            //echo "I am here";
            //print_r($_COOKIE);
            $currentUserId=User::VerifyAuthCookie($_COOKIE['auth']);
            if($currentUserId<0)
            {
                $loginError='Login time out. Please <a href="login.php">login</a> again.';
                $currentUserId=0;
            }
            else if($currentUserId==0)
            {    
                $loginError='Invalid login. Please <a href="login.php">login</a> again.';
            }
            else
                User::RefreshCurrentUser();
            //User::SetupAuthCookie();
        }
        //echo "current user id: $currentUserId";
        if($currentUserId==0)
        {                
            if(isset($_POST['loginEmail']) && isset($_POST['password']))
            {
                //echo "here";
                $loginEmail=$_POST['loginEmail'];                     
                $password=User::EncryptPassword($_POST['password']);
                //echo "Pass: $password";
                //$password=User::EncryptPassword('test');
                //echo "Pass: $password";
                $userInfo=User::GetInfoByEmail($loginEmail);
                if($password==$userInfo['password'])
                {
                    $currentUserId=$userInfo['user_id'];
                    User::RefreshCurrentUser();
                    User::SetupAuthCookie();
                    $loginError='';
                }
                else
                {
                    $loginError='login failed due to invalid id or password';
                }
            }   
            else
            {
                $loginError='Please login to continue.';
            }
        }
        else
        {  
            switch($currentUserLoginInfo['status'])
            {                    
                case 'inactive':   
                     $loginError='Account suspended.';
                     break;   
                case 'pending':
                     $loginError='Account pending.';
                     break;
                case 'needPassword':
                     $loginError="Account needs password to complete.";
                     break;          
                case 'pendingEmailVerification':
                     $loginError='Account pending email verification.';
                     break;
                case 'pendingMobileVerification':
                     $loginError='Account pending mobile verification.';
                     break;
            }
        }
        return $loginError;
        /*
        echo "Error: $loginError <br> UserId: $currentUserId <br>";
        print_r($currentUserLoginInfo);
        echo"<br> current time",time();
        */
        //exit();
    }      
    public static function SetupAuthCookie() //we can use it any time to set up authentication. Be sure that userId and info are populated
    {                
        global $currentUserId, $currentUserLoginInfo, $currentUserDetails;
        $time=0;
        if(isset($_POST['remember']))
        {
            $time= time() + 1209600;    //two weeks
        }

        $toEncode=$currentUserId."-".$currentUserLoginInfo['password']."-".$time;
        //echo "to encode: $toEncode";
        $auth=base64_encode($toEncode);
        //echo "encoded: $auth";
        setcookie('auth',$auth,$time,'/');
        return $auth;
        //also in this session
        //setcookie('wpLogin','donor_'.$memberLoginInfo['username'],$time,'/');
    }
    public static function VerifyAuthCookie($authCookie) //returns userId on OK, 0 otherwise. Didn't manipulate userId here to ensure no ambiguity
    {
        $newId=0;
        if(isset($_COOKIE['auth']))
        {
            $decoded=base64_decode(stripslashes($_COOKIE['auth']));
            //echo($decoded);
            $data=explode('-',$decoded);
            //print_r($data);
            $expiryTime=$data[2];
            //check date first. if older than 2 weeks, discard
            if($expiryTime!=0 && (time()>$expiryTime))
            {
                return -1;
            }
            $newId=$data[0];
            $encryptedPass=$data[1];

            $userInfo=User::GetInfo($newId);
            if($userInfo['password']==$encryptedPass)
                return $newId;
            return 0;
        }
        return $newId;
    }                                    
    
    public static function RestrictAccess($requiredClass='Admin')
    {                                 
        global $currentUserId, $currentUserLoginInfo, $currentUserDetails,  $STATUSES;
        if($currentUserLoginInfo['class']!=$requiredClass)
        {
            header('Location:../login.php?loginError='.$STATUSES['RESTRICTED']);
            exit();
        }
    }
    
    public static function RestrictMemberZone()
    {                                 
        global $currentUserId, $currentUserLoginInfo, $currentUserDetails,  $STATUSES;
        //echo "UserId: $currentUserId <br>";
        //print_r($currentUserLoginInfo);
        //exit();
        if($currentUserId==0)
        {
            header('Location:../login.php?loginError='.$STATUSES['NOT_LOGGED_IN']);
            exit();   
        }
        else if($currentUserLoginInfo['status']=='inactive')
        {        
            header('Location:../login.php?loginError='.$STATUSES['SUSPENDED']);
            exit();
        }
    }
    public static function EncryptPassword($password)
    {
        $salt='!whY1One';
        $toHash=$salt.$password;
        $encryptedPass=md5($toHash);   
        //EchoPre('Pass given:'.$password.'<br>');
        //EchoPre('Pass enc:'.$encryptedPass.'<br>');
        return $encryptedPass;
    }

    public static function GetPasswordResetLink($email)
    {                                    
        global $CONFIGURATIONS;
        $userLoginInfo=User::GetInfoByEmail($email);
        $encryptedPass=$userLoginInfo['password'];

        $time=time()+$CONFIGURATIONS['FORGET_HOURS']*3600;
        $magic=rand(1,9);
        $magicTime=$time * $magic;

        $toEncode=$userLoginInfo['user_id']."-".$encryptedPass."-".$magicTime.'-'.$magic;
        $resetCode=rawurlencode(base64_encode($toEncode));
        return $CONFIGURATIONS['BASE_URL'].'setPassword.php?tokenMagic='.$resetCode;
    }

    public static function VerifyResetToken($tokenMagic)
    {   
        $decoded=rawurldecode(base64_decode(stripslashes($tokenMagic)));
        $data=explode('-',$decoded);
        print_r($data);
        if(count($data)!=4)
            return 'Invalid Token';          
        $expiryTime=$data[2];
        $magic=$data[3];
        $expiryTime=$expiryTime/$magic;
        //check date first. if older than 2 weeks, discard
        if($expiryTime!=0 && (time()>$expiryTime))
        {
            return 'Token Expired';
        }
        $newId=$data[0];
        $encryptedPass=$data[1];

        $userInfo=User::GetInfo($newId);
        if($userInfo['password']==$encryptedPass)
        {
            $newEncPass=User::EncryptPassword('test');
            if(User::ChangePassword($newId,$encryptedPass,$newEncPass))
            {             
                if(User::ChangeStatus($newId,'needPassword'))
                {             
                     return $newId;
                }
                return 'Status was not updated';
            }
            return 'Could not reset password.';
        }
        return 'Security check failed for the token.';

        
    }
                                   
    public static function EmailPasswordResetLink($email)
    {
        global $CONFIGURATIONS;
        $link=User::GetPasswordResetLink($email);
                              
        $body="
        Password reset link <a href='$link'>here</a>.
        ";
        //echo $body;
        if(ICodeTools::ICodeMail(StripSlashes($_POST['forgotEmail']), $CONFIGURATIONS['SYSTEM_EMAIL_ADDRESS'], "[{$CONFIGURATIONS['WEBSITE_NAME']}]: Password Reset Link", $body,$CONFIGURATIONS['WEBSITE_NAME']))
           return 'Please check your inbox for reset link';
        return 'Emailing failed due to server error';
    }
    public static function EmailLoginLink($userId)
    {
        global $CONFIGURATIONS;          
        $userInfo=User::GetInfo($userId);
        $subject= "[{$CONFIGURATIONS['WEBSITE_NAME']}]: Account created";
        $body="
        You are registered at {$CONFIGURATIONS['WEBSITE_NAME']}.
        Temporary Login Link <a href='{$CONFIGURATIONS['BASE_URL']}firstTime.php?userId=$userId'>here</a> if you didn't set a password for your account.
        ";
        //echo $userInfo['email'], $CONFIGURATIONS['SYSTEM_EMAIL_ADDRESS'], "[{$CONFIGURATIONS['WEBSITE_NAME']}]: Super user account created", $body,$CONFIGURATIONS['WEBSITE_NAME'];
        //exit();

        if(ICodeTools::ICodeMail($userInfo['email'], $CONFIGURATIONS['SYSTEM_EMAIL_ADDRESS'],$subject, $body,$CONFIGURATIONS['WEBSITE_NAME']))
           return 'Please check your inbox for login link';
        return 'Emailing login link failed due to server error';
    }

    /* login ends */

    public static function PassToSubClass($functionName,$id=0,$paramsArr=array())
    {                 
        if($id==0)
            return call_user_func(array($_POST['class'],$functionName));
        $userInfo=User::GetInfo($id);
        if(is_null($paramsArr) || empty($paramsArr))
            return call_user_func(array($userInfo['class'],$functionName),$id);
        else
            return call_user_func(array($userInfo['class'],$functionName),$id,$paramsArr);
    }
    public static function Add()
    {                              
        if(($status=User::Validate())!==1)
            return $status;
        //process password
        global $CONFIGURATIONS;
        $class=$_REQUEST['class'];
        $title=$_POST['title'];
        $customTitle=$_POST['customTitle'];
        $fName=$_POST['fName'];
        $lName=$_POST['lName'];
        $jobTitle=$_POST['jobTitle'];          
        $companyName=$_POST['companyName'];
        $companyId=$_POST['companyId'];
        $stateId=$_POST['stateId'];    
        $cityId=City::Add($_POST['city'],$_POST['stateId']);
        $postcode=$_POST['postcode'];
        $email=$_POST['email'];
        $email2=$_POST['email2'];
        $phone=$_POST['phone'];
        $address=serialize(array_filter(array($_POST['address1'],$_POST['address2'],$_POST['address3'])));
        //$sameInvoiceAddress=$_POST['sameInvoiceAddress'];
        if($customTitle!='')
            $title=$customTitle;
        $password=User::EncryptPassword($_POST['password']);
        $timeOut=(int)$CONFIGURATIONS['FORGET_HOURS'];
        $insert="insert into user (email,password,reg_date,class, status,forget_minutes)
                         values(
                         '$email', '$password',
                         now(),'".$_POST['class']."','".$_POST['status']."','$timeOut'
                         )";
        if(($userId=ICodeDB::FreshInsertAndGetId($insert,'user,user_detail'))>0)
        {
            $insertDetail="insert into user_detail (user_id,title,f_name,l_name,job_title,company_name,company_id,address,state_id,city_id,postcode,phone)
                         values(
                         $userId,'$title','$fName','$lName','$jobTitle','$companyName','$companyId','$address','$stateId','$cityId','$postcode','$phone'
                         )";
            //echo $insertDetail;
            if(!User::PassToSubClass('Add',$userId))
            {
                User::Remove($userId);
                return "Failed due to Subclass Add";
            }
            if(!ICodeDB::FreshInsert($insertDetail))
            {              
                User::Remove($userId);
                User::PassToSubClass('Remove',$userId);
                return "Failed due to details Add";
            }
            if(in_array($class,array('Recipient','Administrator')))
                return $userId;
            User::EmailLoginLink($userId);
            return $userId;
        }
        return 0;
    }
    public static function Update()
    {      
        if(($status=User::Validate())!==1)
            return $status;
        //process password
        $updateSql='';
        $error=array();

        if(isset($_POST['updateLogin'])) //detail changes
        {                      
            $updateOptions=array();
            if(isset($_POST['password']) && $_POST['password']!='')
            {                    
                $password=User::EncryptPassword($_POST['password']);
                $updateOptions[]=" password= '$password'";
            }        
            if(isset($_POST['email']) && $_POST['email']!='')
            {                                                    
                $updateOptions[]=" email= '{$_POST['email']}'";
            } 
            if(isset($_POST['forgetMinutes']) && (int)$_POST['forgetMinutes']>0)
            {                                                    
                $updateOptions[]=" forget_minutes= '{$_POST['forgetMinutes']}'";
            } 
            $updateSql="update user set ".implode(' , ',$updateOptions)." where user_id=".$_POST['userId'];
            if(!ICodeDB::Update($updateSql))
                $error[]="Login info update failed due to DB error";

        }
        if(isset($_POST['updateDetail'])) //detail changes
        {      
            $updateOptions=array();
            if(isset($_POST['capabilities']))
            {
                $updateOptions[]=" capabilities= '{$_POST['capabilities']}'";
            }  
            if(isset($_POST['countryCode']))
            {
                $updateOptions[]=" country_code= '{$_POST['countryCode']}'";
            }
            if(isset($_POST['postcode']))
            {
                $updateOptions[]=" postcode= '{$_POST['postcode']}'";
            }            
            if(isset($_POST['city']))
            {                           
                $cityId=City::Add($_POST['city'],$_POST['stateId']);
                $updateOptions[]=" city_id= '$cityId'";
            }
            if(isset($_POST['stateId']))
            {
                $updateOptions[]=" state_id= '{$_POST['stateId']}'";
            }
            if(isset($_POST['address1']))
            {                                      
                $address=serialize(array_filter(array($_POST['address1'],$_POST['address2'],$_POST['address3'])));
                $updateOptions[]=" state_id= '{$address}'";
            }
            if(isset($_POST['mobile']))
            {
                $updateOptions[]=" mobile= '{$_POST['mobile']}'";
            }
            if(isset($_POST['phone']))
            {
                $updateOptions[]=" phone= '{$_POST['phone']}'";
            }
            if(isset($_POST['companyName']))
            {
                $updateOptions[]=" company_name= '{$_POST['companyName']}'";
            }
            if(isset($_POST['jobTitle']))
            {
                $updateOptions[]=" job_title= '{$_POST['jobTitle']}'";
            }            
            if(isset($_POST['fName']))
            {
                $updateOptions[]=" f_name= '{$_POST['fName']}'";
            }
            if(isset($_POST['lName']))
            {
                $updateOptions[]=" l_name= '{$_POST['lName']}'";
            }
            if(isset($_POST['customTitle']) && $_POST['customTitle']!='')
            {
                $updateOptions[]=" title= '{$_POST['customTitle']}'";
            }              
            else if(isset($_POST['title']))
            {
                $updateOptions[]=" title= '{$_POST['title']}'";
            }
            $updateSql="update user_detail set ".implode(' , ',$updateOptions)." where user_id=".$_POST['userId'];   
            if(!ICodeDB::Update($updateSql))
                $error[]="Detail info update failed due to DB error";
        }                             
        User::RefreshCurrentUser();
        User::SetupAuthCookie();
        //must be refreshed before passing to subclass

        if(($errors=User::PassToSubClass('Update',$_POST['userId']))!==true)
            $error[]="Update failed in subclass. [$errors]";

        return implode('<br>',$error);
    }
    public static function Validate()
    {
        //check non empty, not isset, etc
        $update=false;
        if(isset($_POST[User::$formIdName]) && (int)$_POST[User::$formIdName]>0) //means update
            $update=true;
        if($update)
        {
            $mustFields=User::$updateFields;
        }
        else
            $mustFields=User::$insertFields;

        if(($status=ICodeFormValidation::ValidateNonEmpty($mustFields))!==1)
            return $status;

        //now custom validation
        if($update)
        {
            $uniqueCond='and user_id!='.$_POST['userId'];
            if((int)$_POST['userId']==0 && $_POST['userClass']!='Admin')
                return 'Invalid member id or you do not have the permission';
            if(isset($_POST['password']) && $_POST['password']!='')
            {        
                if($_POST['password']!=$_POST['password2'])
                    return "Passwords don't match";
                //validate password
            }
            if(isset($_POST['email']) && $_POST['email']!='')
            {        
                if($_POST['email']!=$_POST['email2'])
                    return "Emails don't match";    
                if(ICodeDB::IsKeyUsed(User::$tableName,'email',$_POST['email'],$uniqueCond))
                    return "Email already used for another account.";
                //validate password
            }
            return User::PassToSubClass('Validate',$_POST['userId'],array());;
        }
        else
        {
            if(ICodeDB::IsKeyUsed(User::$tableName,'email',$_POST['email']))
                return "Email already used for another account.";
            if($_POST['password']!=$_POST['password2'])
                return "Passwords don't match"; 
            if($_POST['email']!=$_POST['email2'])
                return "Emails don't match";
            //now validate email, password       
            return User::PassToSubClass('Validate',0,array());;
        }
    }

    public static function UpdateLogin()
    {
        $comma='';
        $updateSql='update user set ';
        if(isset($_POST['updateLogin'])) //detail changes
        {
            if($_POST['password']!='')
            {                           
                if($_POST['password']!=$_POST['password2'])
                    return "Passwords don't match";
                $password=User::EncryptPassword($_POST['password']);
                $updateSql.=$comma." password= '$password'";
                $comma=', ';
            }
            if($_POST['email']!='')
            {                    
                $uniqueCond='and user_id!='.$_POST['userId'];
                if(ICodeDB::IsKeyUsed(User::$tableName,'email',$_POST['email'],$uniqueCond))
                    return "Email already used for another account.";

                $updateSql.=$comma." email= '{$_POST['email']}'";
                $comma=', ';
            } 
        }
        if($comma=='')
            return "Must enter both the password";
        $updateSql.=" where user_id={$_POST['userId']}";
        if(ICodeDB::Update($updateSql))
        { 
            User::RefreshCurrentUser();
            User::SetupAuthCookie();
            return true;
        }
        else
            return 'Login Credential was not Updated';

    }
    public static function Remove($id)
    {
        $userInfo=User::GetInfo($id);
        ICodeDB::Delete("delete from user where user_id='$id' limit 1");
        ICodeDB::Delete("delete from user_detail where user_id='$id' limit 1");
        if(User::PassToSubClass('Remove',$id)==true)
        {
            if(1)
               return true;
            return false;
        }
        return false;
    }
    public static function Get($start=0,$limit=0,$class='', $status='', $from='',$to='')
    {       
        $upto='';
        $where='';

        $and='';
        $condition='';              
        if($from!='')
        {
            $condition.=$and." date>='$from'";
            $and=' and ';
        }
        if($to!='')
        {
            $condition.=$and." date<='$to'";
            $and=' and ';
        }        
                      
        if($status!='')
        {
            $condition.=$and." status = '$status'";   
            $and=' and ';
        }
        if($class!='')
        {
            $condition.=$and." class = '$class'";
            $and=' and ';
        }                     
        if($limit>0)
            $upto=" limit $start,$limit";

        $where.=$condition;
        if($where!='')
            $where=' where '. $where;
        return (ICodeDB::GetResultsSet("select * from user $where order by user_id $upto"));

    }    


    
    public static function GetTotal($class='', $status='', $from='',$to='')
    {
        $where='';

        $and='';
        $condition='';              
        if($from!='')
        {
            $condition.=$and." date>='$from'";
            $and=' and ';
        }
        if($to!='')
        {
            $condition.=$and." date<='$to'";
            $and=' and ';
        }        
                      
        if($status!='')
        {
            $condition.=$and." status = '$status'";   
            $and=' and ';
        }
        if($class!='')
        {
            $condition.=$and." class = '$class'";
            $and=' and ';
        }
        $where.=$condition;
        if($where!='')
            $where=' where '. $where;

        $row=ICodeDB::GetResultRow("select count(*) as count from user $where");
        return $row['count'];
    }                                         
    public static function GetDetailInfo($id)
    {
        return ICodeDB::GetResultRow("select * from user_detail where user_id='$id'");
    }                                 
    public static function GetInfo($id)
    {
        return ICodeDB::GetResultRow("select * from user where user_id='$id'");
    }
    public static function GetCompleteInfo($id)
    {
        return ICodeDB::GetResultRow("select * from user u,user_detail as ud where u.user_id =  ud.user_id and u.user_id='$id'");
    }
    public static function GetInfoByEmail($email)
    {
        //echo "<br>select * from user where email='$email'<br>";
        return ICodeDB::GetResultRow("select * from user where email='$email'");
    }

    public static function ChangePassword($userId,$old,$new)
    {
        if($new=='')
            return;
        $loginInfo=User::GetInfo($userId);
        if($loginInfo['password']!=$old)
            return 0;
        $update="Update user set password='$new' where user_id='$userId'";
        if(ICodeDB::Update($update))
            return 1;
        return 0;
    }
    public static function ChangeStatus($userId,$status)
    {
        if(ICodeDB::Update("update user set status='$status' where user_id='$userId'"))
          return true;
        return false;
    }             
    public static function GetImage($id)
    {
        global $CAT_ICON_DIR,$CAT_ICON_URL;
        if(($ext=SearchImgFileExt($CAT_ICON_DIR.$id))===false)
            return $CAT_ICON_URL."noImg.png";
        return $CAT_ICON_URL.$id.".$ext";
    }  
    public static function GetImagePath($id)
    {
        global $CAT_ICON_DIR,$CAT_ICON_URL;
        if(($ext=SearchImgFileExt($CAT_ICON_DIR.$id))===false)
            return false;
        return $CAT_ICON_DIR.$id.".$ext";
    }  
    public static function GetCapabilities()
    {
    }      
               
    public static function SearchByEmail($email,$class='')
    {
        //echo "<br>select * from recipient where email='$email'<br>";
        if($class!='')
            $class=" and class='$class' ";
        return ICodeDB::GetResultsSet("select * from user where email like '%$email%' $class");
    }

    public static function SendSystemEmail($userId,$subject,$body)
    {      
        global $CONFIGURATIONS;     
        $fromName=$CONFIGURATIONS['WEBSITE_NAME'];
        $fromaddress=$CONFIGURATIONS['SYSTEM_EMAIL_ADDRESS'];

        $userInfo=User::GetInfo($userId);
        $emailaddress=$userInfo['email'];

        return ICodeTools::ICodeMail($emailaddress, $fromaddress, $emailsubject, $body,$fromName);
    }        
    public static function GetTitleOptions($title)
    {                
        $titles[]='';
        $titles[]='Mr';
        $titles[]='Ms';
        $titles[]='Mrs';
        $html='';
        foreach($titles as $aTitle)
        {
            if($title==$aTitle)
                $html.="<option selected value='{$aTitle}'>{$aTitle}</option>";
            else
                $html.="<option value='{$aTitle}'>{$aTitle}</option>";
        }
        return $html;
    }



    /*pemission*/

    /*
    public static function ()
    {
    }
    */

}

?>