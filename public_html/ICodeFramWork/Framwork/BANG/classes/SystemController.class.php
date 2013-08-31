<?php
Class SystemController
{
    public static function StartUp()
    {
        spl_autoload_register(array('SystemController','AutoLoadClass')); // Autoloads any classes from classes folder
        $_COOKIE=ICodeFormValidation::ProcessFormData($_COOKIE);
        $_POST=ICodeFormValidation::ProcessFormData($_POST);
        $_GET=ICodeFormValidation::ProcessFormData($_GET);
        SystemController::SetupGlobals();
        SystemController::ProcessUserState();
    }

    public static function SetupGlobals()
    {        
        global $currentUserId, $currentUserLoginInfo, $currentUserDetails,$loginError, $STATUSES, $ACRONYMS, $CONFIGURATIONS;
        $currentUserId=0;
        $currentUserLoginInfo=array();
        $currentUserDetails=array();
        $loginError='';
        $STATUSES=array();
        $ACRONYMS=array();
        $CONFIGURATIONS=array();   
        ICodeConfig::Load();
        User::Login();    

    }

    public static function ClearGlobals()
    {     
        global $currentUserId, $currentUserLoginInfo, $currentUserDetails,$loginError, $STATUSES, $ACRONYMS, $CONFIGURATIONS;
        $currentUserId=0;
        $currentUserLoginInfo=array();
        $currentUserDetails=array();
        $loginError='';
        $STATUSES=array();
        $ACRONYMS=array();
        $CONFIGURATIONS=array();   
        ICodeConfig::Load();
    }

    public static function AutoLoadClass($className)   // when you use a class in your code, if it's not loaded statically, it's loaded dynamically
    {
        global $CONFIGURATIONS;
        $classPath=$CONFIGURATIONS['CLASS_DIR'].$className.'.class.php';
        require_once($classPath);
        if(!class_exists($className))
            die("Fatal Error loading $classPath");
    }

    public static function ProcessUserState()
    {   
        global $currentUserId, $currentUserLoginInfo, $currentUserDetails, $STATUSES, $ACRONYMS, $CONFIGURATIONS;

        if($currentUserId==0)
            return;
        $dontRedirectArr=array('logout.php','register.php','invitation.php','setPassword.php','reinstateOther.php'
                        );
        $dontRedirectFolders=array('/api/');
        if(in_array(ICodeTools::CurrentScriptName(),$dontRedirectArr))
            return;
        foreach($dontRedirectFolders as $aF)
        {
            if(strrpos($_SERVER["SCRIPT_NAME"],$aF)!==false)
                return;
        }
        switch($currentUserLoginInfo['class'])
        {
            case 'SuperAdministrator':
                $activeSites=Site::GetTotal($currentUserId,'active');
                //die($activeSites);
                if($activeSites<=0 && $currentUserLoginInfo['status']=='active')
                {          
                    if(!(ICodeTools::IfCurrentPage('addSite') || ICodeTools::IfCurrentPage('payForSite')))
                    {
                        Header("Location: {$CONFIGURATIONS['BASE_URL']}member/index.php?page=addSite&siteForm=yes");
                        exit();
                    }
                }
            default:  
                switch($currentUserLoginInfo['status'])
                {
                    case 'needPassword':
                        if(ICodeTools::CurrentScriptName()!='setPassword.php')
                        {
                            Header("Location: {$CONFIGURATIONS['BASE_URL']}setPassword.php");
                            exit();
                        }
                        break;
                }
                    /*
                if($currentUserLoginInfo['class']!='Admin' && !(ICodeTools::IfCurrentPage('editProfile')))
                {
                    //check if mobile number is available.
                    if($currentUserDetails['mobile']=='')
                    {   
                        Header("Location: {$CONFIGURATIONS['BASE_URL']}member/index.php?page=editProfile");
                        exit();
                    }
                }
                    */
        }

    }
}
?>