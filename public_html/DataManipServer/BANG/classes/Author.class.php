<?php
class Author
{                                  
    //Page controls
    //this are the pages for which no navigation links are available. Those are actually linked in navigation pages.
    //So we will still check their permissions!
    public static $subPages = array('viewArticle', 'editArticle','deleteArticle');
    //public static $navigationPages=array('Add Admin'=>'addAdmin', ''=>'', ''=>'', ''=>'', ''=>'', ''=>'');                   
    public static $leftNavigationPages=
        array(
              'SMS report'=>'smsReport',
              'Add Admin'=>'addAdmin',
              'Super Administrators'=>
                     array(    
                           'Add Super User'=>'addSuperUser',
                           'Manage Super Users'=>'manageSuperUsers'
                     )
             );
    public static $topNavigationPages=
        array(
              'Add Site'=>'addSite',
              'Manage Articles'=>'manageArticle',
               'Article Management' =>
                       array(
                           'New Article'=>'articleCompose',
                           'View Articles' => 'manageArticles'

                       ),
            'Create New Category' =>'createNewCategory',

              'Preferences'=>
                     array(
                           'Login'=>'loginCredential',
                           'Menu Timeout'=>'menuTimeout'
                     )
             );            
    public static function GetNavigation($type='top')
    {
        switch($type)
        {                                               
            case 'top':
                 return self::$topNavigationPages;
            case 'sub':
                 return self::$subPages;
        }
    }                                                   
    /*Page control ends*/
    public static function Add($id)
    {
        return true;
    }
    public static function Remove($id)
    {
        return"<br> I am called in admin with id $id";
    }       
    public static function Update($administratorId)
    {
        
        return true;
    }
    public static function Validate()
    {
        return 1;
    }



   //admin operations
}

