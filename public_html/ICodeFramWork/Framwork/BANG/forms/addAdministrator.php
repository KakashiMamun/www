<?php
    $formError='';
    $form='administrator';
    /***actual printing starts here ***/
    //get sites which has atleast 1 workgroup
    $formError=Invitation::ProcessAdministratorInvitationForm();
    //echo $formError;
    $sites=Site::Get(0,0,$currentUserId);     
    $sitesHavingWG=Site::GetHavingWorkgroup($currentUserId);
    //print_r($sitesHavingWG);
    if(count($sites)==0)
    {
        $formError="No active site found.";
        $form='';
    }
    else
    {                                      
        require_once('siteHtml.php');
        require_once('workgroupHtml.php');
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
<?php
    if($form=='administrator')
    {
?>
                             
            <div class='subHead'>
                 <span class='subHeadLeft'>
                       <div>Add an administrator</div>
                 </span><span class='subHeadRight'>
                 </span>
            </div>  
            <form action='' id='addAdministrator' method='post' enctype='multipart/form-data'>
                <div class='smartForm'>
                    <span>
                        Email Address
                        <br>
                        <input type='text' name='email' id='email'>
                    </span><span> 
                        Surname
                        <br>
                        <input type='text' name='lName' id=''>
                    </span><span>  
                        Forename
                        <br>
                        <input type='text' name='fName' id=''>
                    </span><span>
                            <a href='javascript:void(0)' onclick='AddAdministrator()'><img src='../images/addAdministrator.png'></a>

                    </span>
                </div>     
                <input type='hidden' name='formSubmitted' value='yes'>
            </form>
            <div id='lookUpForm'>
            </div>

            <table class='userList'>
                 <tbody id='administratorListTbl'>
                 </tbody>
            </table>                    
            <p>Select the Site(s) you wish to invite the above person(s) to join and act as <b>super users</b>. For this sites they will be able to
            create work groups and recipients to those.
            </p> 
            <form id='siteList' method='post' action=''  onsubmit='return ValidateAdministratorList();'>
                <?php
                    echo $siteHtml;
                ?>
            <p>Select the workgroups(s) you wish to invite the above person(s) to join and act as <b>recipients</b>. They will get notifications only for
                      these workgroups.
            </p>
                <?php
                    echo $workgroupHtml;
                ?>
                <input type='hidden' id='administratorIdList' name='administratorIdList' value=''>       
                    <input type='image' class='button border0' src='../images/updateAdministratorList.png' name='' id='submit' value=' Submit '>
            </form>
<?php
    }
?>                        
              </div>           
              <!--content ends-->
         </div>
         <!--contentArea ends-->