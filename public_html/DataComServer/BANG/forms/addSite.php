<?php
    $formError='';
    $numberOfSites=0;
    if($numberOfSites<=0)
        $formError="Please create the first site to get started";
    $form='site';
    if(isset($_POST['formSubmitted']))
    {                                       
        $_POST['ownerId']=$currentUserId;
        $_POST['status']='inactive';
        //$siteId=Site::Add();
        if(is_numeric($siteId) && $siteId>0)
        {
            $form='payment';
        }
        else
        {
            $formError=$siteId;
        }
    }
    if($form=='payment')
    {
        //$siteInfo=Site::GetInfo($siteId);
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
                       if($form=='site')
                       {
                   ?>                       
                           <div class='subHead'>
                               <span class='subHeadLeft'>
                                     <div>Add a site</div>
                               </span><span class='subHeadRight'>
                               </span>
                           </div>
                           <form enctype="multipart/form-data" method="post" action="">
                               <div class='form'>
                                    <div class='formHead'>
                                         Site details
                                    </div>
                                    <div class='bigPadder'>  
                                         <table cellspacing="0" cellpadding="0" class="profile">
                                                <tr>     
                                                    <td class='leftTd'> <b>Site Name</b>:
                                                    </td>
                                                    <td class='rightTd'><input type='text' name='name' id='' value="<?php echo ICodeTools::GetRawValue('name'); ?>">
                                                    </td>
                                                </tr>
                                                <tr>     
                                                    <td class='leftTd'> Description:
                                                    </td>
                                                    <td class='rightTd'><textarea  name='description' id=''><?php echo ICodeTools::GetRawValue('description'); ?></textarea>
                                                    </td>
                                                </tr>

                                                <tr>     
                                                    <td class='leftTd'>
                                                    </td>
                                                    <td class='rightTd'>
                                                    
                                                    <input type='image' class='button border0' src='../images/submit.png' name='' id='submit' value=' Submit '>
                                                    </td>
                                                </tr>    
                                         </table>
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
                           </form>   
                           <?php                 
                               $sites=Site::Get(0,0,$currentUserId,'inactive');
                               if($numberOfSites>0 && count($sites)>0)
                               {
                           ?>

                                   <div class='subHead'>
                                       <span class='subHeadLeft'>
                                             <div>Or Renew a site</div>
                                       </span><span class='subHeadRight'>
                                       </span>
                                   </div>
                           <?php                                               
                                   //require_once('../forms/renewSites.php');
                                   require_once('../forms/siteManagement.php');
                               }
                           ?>

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