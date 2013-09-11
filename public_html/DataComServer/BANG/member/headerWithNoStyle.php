<?php
    //$currentUserLoginInfo            
    //print_r($CONFIGURATIONS);
    $class=$currentUserLoginInfo['class'];
    $topNavigation = call_user_func(array($class,'GetNavigation'),'top');
    //echo "i am here";
    $ADMIN_URL='index.php?';
    //print_r($topNavigation);
    switch($class)
    {
        case 'Admin':
             
                 break;
    }

    require_once('htmlHead.php');
?>
    <table>
        <tr>
            <?php
                foreach($topNavigation as $navTitle=>$aNav)
                {
                    if(!is_array($aNav))
                    {                      
                        $anchorClass=ICodeTools::IfCurrentPage($aNav,'selectedLinkAdmin');
                        echo"<th><a $anchorClass href='{$ADMIN_URL}page=$aNav'>$navTitle</a></th>";
                    }
                    else
                        echo"<th><a href='javascript:void(0);'>$navTitle</a></th>";
                }
            ?>
        </tr>
        <tr>
            <?php
                foreach($topNavigation as $navTitle=>$aNav)
                {
                    echo"<td> ";
                    if(is_array($aNav))
                    {
                        foreach($aNav as $childName=>$childLink)
                        {                    
                            if(!is_array($childLink))
                            {  
                                $anchorClass=ICodeTools::IfCurrentPage($childLink,'selectedLinkAdmin');
                                echo"<a $anchorClass href='{$ADMIN_URL}page=$childLink'>$childName</a><br>";
                            }
                            else
                            { 
                                echo"<a href='javascript:void(0);'>$childName</a><br>";
                                echo"<div class='subChildLink'>";
                                //now print third level menus
                                foreach($childLink as $subChildName=>$subChildLink)
                                {       
                                    $anchorClass=ICodeTools::IfCurrentPage($subChildLink,'selectedLinkAdmin');
                                    echo"<a $anchorClass href='{$ADMIN_URL}page=$subChildLink'>$subChildName</a><br>";
                                }
                                echo"</div>";
                            }
                        }
                    }     
                    echo"</td>";
                }
            ?>
        </tr>
    </table>