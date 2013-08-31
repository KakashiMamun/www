<?php
  include_once('noCacheHeader.php');   
  require_once('userConnection.php');
  require_once('directories.php');   
  require_once('configFile.php');
  require_once('library.php');        
  require_once('commonFunctions.php');

  require_once('../classes/Cart.class.php');
  require_once('../classes/Category.class.php');
  require_once('../classes/Country.class.php');
  require_once('../classes/Graphics.class.php');
  require_once('../classes/ICodeDB.class.php');
  require_once('../classes/ICodeError.class.php');
  require_once('../classes/ICodeFormValidation.class.php');
  require_once('../classes/ICodePaypal.class.php');
  require_once('../classes/ICodeTools.class.php');
  require_once('../classes/Member.class.php');


  $memberId="";
  $memberPassword="";//this 2 vars must be initialized for forum login
  $verifiedMember=0;
  $remember=3600;
  $_COOKIE=ICodeFormValidation::ProcessFormData($_COOKIE);
  $_POST=ICodeFormValidation::ProcessFormData($_POST);
  $_GET=ICodeFormValidation::ProcessFormData($_GET);
  if(isset($_COOKIE['memberId']))
  {
    $verifiedMember=LoginMember($_COOKIE['memberId'],$_COOKIE['memberPassword']);
  }

  if($verifiedMember!=0)
  {
    $memberId=$_COOKIE['memberId'];
    $memberPassword=$_COOKIE['memberPassword'] ;
    $remember=$_COOKIE['remember'];
  }
  else
  {
      //check post   
      if(isset($_POST['userId']))
      {
        $verifiedMember=LoginMember($_POST['userId'],$_POST['password']);
        if($verifiedMember!=0)
        {                                                            
          $memberId=$_POST['userId'];
          $memberPassword=$_POST['password'];
          if(isset($_POST['remember']))
              if($_POST['remember']!='')
                  $remember=$_POST['remember'];
        }
      }

  }
  if($verifiedMember>0)
  {
    setcookie('memberId',StripSlashes($memberId),time()+$remember,'/');
    setcookie('memberPassword',StripSlashes($memberPassword),time()+$remember,'/');
    setcookie('remember',$remember,time()+$remember,'/');
    $memberInfo=Member::GetInfo($memberId);
  }
  print_r($_COOKIE);
  echo $verifiedMember;    
  //RequireVerification($BASE_URL.'login.php');
?>