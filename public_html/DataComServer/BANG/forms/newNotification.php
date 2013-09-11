<?php
    $formError='';
    $activeSites=Site::GetTotal($currentUserId,'active');
    if($activeSites<=0)
        $formError="Please create the first site to get started";
    $sitesHavingWG=Site::Get(0,0,$currentUserId,'active');
    $form='new';
    $allSelected='';
    $checkedCompany=0;
    $checkedSMS='';
    if(isset($_GET['notificationId']))
    {
        if(isset($_GET['resend']))
        {                  
            $notificationId=Notification::MakeClone($_GET['notificationId']);
            if(is_numeric($notificationId) && $notificationId>0)
            {
                $form='done';    
                $formError="Notification made successfully. Emails will be sent out shortly.";
            }
            else
            {
                $formError=$notificationId;
            }
            
        }
        else if(isset($_GET['reuse']))
        {
            $notificationInfo=Notification::GetInfo($_GET['notificationId']);     
            $_REQUEST['head']=$notificationInfo['head'];        
            $_REQUEST['body']=$notificationInfo['body'];
            $_REQUEST['replyTo']=$notificationInfo['reply_to'];
            $_REQUEST['method']=$notificationInfo['method'];
            $form='new';
            $checkedWGIds=NotificationTarget::GetTargetIds($_GET['notificationId'],'workgroup');
            //print_r($checkedWGIds);                                                             
            $checkedSiteIds=NotificationTarget::GetTargetIds($_GET['notificationId'],'site');   
            $checkedCompanyIds=NotificationTarget::GetTargetIds($_GET['notificationId'],'company');
            if(count($checkedCompanyIds)>1)
                $allSelected='selected';
            else if(!empty($checkedCompanyIds))
                $checkedCompany=array_pop($checkedCompanyIds);
            //print_r($checkedCompanyIds);
            if(in_array($notificationInfo['method'],array('SMS','both')))
                $checkedSMS='checked';
        }
    }
    if(isset($_POST['formSubmitted']))
    {                                       
        $_POST['senderId']=$currentUserId;
        $_POST['method']='email';
        if(isset($_POST['isSMS']) && $_POST['isSMS']=='yes')       
            $_POST['method']='both';
                                    
        //ExtractVars();
        $notificationId=Notification::Add();
        if(is_numeric($notificationId) && $notificationId>0)
        {
            $form='done';    
            $formError="Notification made successfully. Emails will be sent out shortly.";
        }
        else
        {
            $formError=$notificationId;
        }
    }
    if($form=='new')
    {
        $siteCheckbox=true;
        require_once('workgroupHtml.php');
        $companyOptionHtml=Company::GetHtmlOptions($currentUserId,$checkedCompany,'active');
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
                       if($form=='new')
                       {
                   ?>                       
                           <div class='subHead'>
                               <span class='subHeadLeft'>
                                     <div>Notification Form</div>
                               </span><span class='subHeadRight'>
                               </span>
                           </div>
                           <form id='newNotification' enctype="multipart/form-data" method="post" action="index.php?page=newNotification">
                               <div class='form'>                                              
                                    <div class='formHead'>
                                         Notification
                                    </div>
                                    <div class='bigPadder'>  
                                         <table cellspacing="0" cellpadding="0" class="profile">
                                                <tr>     
                                                    <td class='leftTd'> <b>Title</b>:
                                                    </td>
                                                    <td class='rightTd'><input type='text' name='head' id='' value="<?php echo ICodeTools::GetRawValue('head'); ?>">
                                                    </td>
                                                </tr>
                                                <tr>     
                                                    <td class='leftTd'>Full text:
                                                    </td>
                                                    <td class='rightTd'><textarea  name='body' id=''><?php echo ICodeTools::GetRawValue('body'); ?></textarea>
                                                    </td>
                                                </tr>
                                         </table>
                                    </div>   
                                    <div class='formHead'>
                                         Attachment
                                    </div>
                                    <div class='bigPadder'>  
                                         <b> Please note that attachment(s) will be delivered by email and not by SMS if that option is selected.</b>
                                         <table cellspacing="0" cellpadding="0" class="profile">
                                                <tr>     
                                                    <td class='leftTd'>Document:
                                                    </td>
                                                    <td class='rightTd'><input type='file' name='attachment'>
                                                    </td>
                                                </tr>
                                         </table>
                                    </div>   
                                    <div class='formHead'>
                                         Delivery Options
                                    </div>
                                    <div class='bigPadder'>  
                                         <table cellspacing="0" cellpadding="0" class="profile">
                                                <tr>     
                                                    <td class='leftTd'> <b>Send via SMS text</b>:
                                                    </td>
                                                    <td class='rightTd'>
                                                        <input <?php echo $checkedSMS; ?>  type='checkbox' class='checkbox' name='isSMS' id='isSMS' value="yes">
                                                    </td>
                                                </tr>
                                                <tr>     
                                                    <td class='leftTd'>Reply mobile number:
                                                    </td>
                                                    <td class='rightTd'><input type='text' name='replyTo' id='' value="<?php echo ICodeTools::GetRawValue('replyTo'); ?>">
                                                    </td>
                                                </tr>
                                         </table>
                                    </div>   
                                    <div class='formHead'>
                                         Recipient companies
                                    </div>
                                    <div class='bigPadder'>                            
                                         <select name='companyId[]' id='companyId'>
                                              <option value=""></option>
                                              <option <?php echo $allSelected;?> value="all">All</option>
                                              <?php
                                                  echo $companyOptionHtml;
                                              ?>
                                         </select>
                                    </div>   
                                    <div class='formHead'>
                                         Work groups
                                    </div>
                                    <div class='bigPadder'>
                                         <b>Selecting a site means all the users (including site super user and users) associated with the site and workgroups of that site will be sent the notification.</b>
                                         <?php
                                             echo $workgroupHtml;
                                         ?>
                                    </div>
                                    <?php
                                        if(isset($_SESSION['formHidden']))
                                        {
                                            foreach($_SESSION['formHidden'] as $key=>$val)
                                               echo "<input type='hidden' name='$key' value='$val' />";
                                        }
                                    ?>
                                    <input type="hidden" value="yes" name="formSubmitted">

                                </div>
                                <div id='smsCredit'>
                                </div>
                                <input type='image' class='button border0' src='../images/submit.png' name='' id='submit' value=' Submit '>
                           </form>
                   <?php
                       }
                       else if($form=='payment')
                       {
                   ?>                    
                           <div class='subHead'>
                                <span class='subHeadLeft'>
                                      <div>Payment for <?php echo $siteInfo['name']; ?></div>
                                </span><span class='subHeadRight'>
                                </span>
                           </div>    
                           <a class='anchorButton' href="<?php echo $CONFIGURATIONS['BASE_URL'];?>member/index.php?page=payForSite&siteId=<?php echo $siteId;?>">Proceed to Payment</a>
                   <?php
                       }
                   ?>    
              </div>           
              <!--content ends-->
         </div>
         <!--contentArea ends-->