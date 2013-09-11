<?php
    //$currentUserLoginInfo            
    //print_r($CONFIGURATIONS);
    $topNavigation=array();
    if($currentUserId!=0)
    {
        $class=$currentUserLoginInfo['class'];
        $topNavigation = call_user_func(array($class,'GetNavigation'),'top');
    }
    //echo "i am here";
    $ADMIN_URL='index.php?';

    require_once('htmlHead.php');
?>                 
    <!-- Now the hidden elements -->
    <!-- Menu thing -->
    <?php            
        $subSubMenuhtml='';
        foreach($topNavigation as $navTitle=>$aNav)
        {
            if(is_array($aNav))
            {                     
                $cssId='sub'.str_replace(array(' ','+'),array('-','-'),$navTitle);    
                echo"<div id='$cssId' class='subMenu'>";
                foreach($aNav as $childName=>$childLink)
                {
                    $count=0;
                    if(!is_array($childLink))
                    {  
                        $anchorClass=ICodeTools::IfCurrentPage($childLink,'selectedLinkAdmin');
                        echo"<a $anchorClass href='{$ADMIN_URL}page=$childLink'>$childName</a>";
                    }
                    else
                    { 
                        $uniqueSubSubMenuId=str_replace(array(' ','+'),array('-','-'),$childName);
                        echo"<a href='javascript:void(0);'  onmouseover='ShowSubSubMenu(\"$cssId\",\"$uniqueSubSubMenuId\")'>$childName</a>";
                        $subSubMenuhtml.="<div class='subSubMenu' id='$uniqueSubSubMenuId'>";
                        //now print third level menus
                        foreach($childLink as $subChildName=>$subChildLink)
                        {       
                            $anchorClass=ICodeTools::IfCurrentPage($subChildLink,'selectedLinkAdmin');
                            $subSubMenuhtml.="<a $anchorClass href='{$ADMIN_URL}page=$subChildLink'>$subChildName</a>";
                        }
                        $subSubMenuhtml.="</div>";
                    }
                }
                echo"</div>";
            }
        }
        echo $subSubMenuhtml;
    ?>
    <!--Menu thing ends -->
    <!--hidden things end -->   
    <div id='wrapper'>
         <div id='top'>
              <span id='topLogo' class='inlineBlock'>
                   <img src='images/logo.png'>
              </span><span id='topNavigation' class='inlineBlock'>       
                     <table cellspacing='0' cellpadding='0'>
                          <tr>            
                              <?php
                                  foreach($topNavigation as $navTitle=>$aNav)
                                  {               
                                      $cssId=str_replace(array(' ','+'),array('-','-'),$navTitle);
                                      if(!is_array($aNav))
                                      {
                                          $anchorClass=ICodeTools::IfCurrentPage($aNav,'selectedLinkAdmin');
                                          echo"<td class='mainMenu' id='$cssId' onmouseover='ShowSubMenu(\"$cssId\")'>
                                                   <img src='images/magicMenu.png'>
                                                   <a $anchorClass href='{$ADMIN_URL}page=$aNav'>$navTitle</a>
                                               </td>";
                                      }
                                      else
                                      {
                                          echo"<td class='mainMenu' id='$cssId' onmouseover='ShowSubMenu(\"$cssId\")'>
                                                   <img src='images/magicMenu.png'>
                                                   <a href='javascript:void(0);'>$navTitle</a>
                                               </td>";
                                      }
                                  }
                              ?>
                          </tr>
                     </table>
              </span>
         </div> 
         <div id='breadCrumb' class='sitecomPadder'>
              <div class='sidePadder20'>
                   <!--<a href=''>Home</a> > <a href=''>Notifications</a>-->
              </div>
         </div>

