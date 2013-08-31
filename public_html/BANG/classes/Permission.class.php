<?php
class Permission
{                                                 
    //Common Page controls which belongs to all the users
    //this are the pages for which no navigation links are available. Those are actually linked in navigation pages.
    //So we will still check their permissions!
    public static $commonPages = array();
    /*Page control ends*/
    public static function ProcessPage($class,$page) //we can do anything with it
    {
        //check if the class has this page      $subPages                                 
        global $currentUserId, $currentUserLoginInfo, $currentUserDetails, $STATUSES, $ACRONYMS, $CONFIGURATIONS;
        //echo "<br><b>$class,$page</b><br>";
        $topNavigation = call_user_func(array($class,'GetNavigation'),'top');
        $subPages = call_user_func(array($class,'GetNavigation'),'sub');
        //print_r($topNavigation);
        if(ICodeTools::IsInObject($page,Permission::$commonPages) || ICodeTools::IsInObject($page,$topNavigation) || ICodeTools::IsInObject($page,$subPages))
        {
            
            require_once('../forms/'.$page.'.php');
            return true;
        }
        echo "Not enough permission to access the page";
        return false;
    }
    /*
    public static function ()
    {
    }
    */
}
?>