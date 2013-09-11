<?php
    $formError='';
    $form='search';
    /***actual printing starts here ***/
    //get sites which has atleast 1 workgroup
    echo $formError;
    $sitesHavingWG=Site::GetHavingWorkgroup($currentUserId);
    //print_r($sitesHavingWG);
    if(count($sitesHavingWG)==0)
    {
        $formError="No workgroup found. Make sure you have created workgroups in your active sites";
        $form='';
    }
    else
    {
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
    if($form=='search')
    {
?>
                                    
            <div class='subHead'>
                 <span class='subHeadLeft'>
                       <div>Notification Search Form</div>
                 </span><span class='subHeadRight'>
                 </span>
            </div>     
            <form action='' id='searchFilters' method='post' enctype='multipart/form-data'>
                <b>Notification Type
                </b>
                <div class='verticalAlignMiddleChildren'>
                    <span>
                        &nbsp;&nbsp;&nbsp;&nbsp;<input class='checkbox' type='radio' name='method' id=''>SMS
                    </span><span>
                        &nbsp;&nbsp;&nbsp;&nbsp;<input class='checkbox' type='radio' name='' id=''>Email
                    </span><span>
                        &nbsp;&nbsp;&nbsp;&nbsp;<input class='checkbox' type='radio' name='' id=''>Both
                    </span>
                </div>
                          
                <br>
                <b>Date Sent
                </b>                             
                <div class='smartForm'>
                    <span>

                        From: <input type='text' name='from' id='from'>
                    </span><span>

                        To: <input type='text' name='to' id='to'>
                    </span>
                </div>
                <br>
                <b>Company
                </b>
                <select name='companyId[]' id='companyId'>
                     <option value=""></option>
                     <option value="all">All</option>
                     <?php
                         echo $companyOptionHtml;
                     ?>
                </select>
                <br>
                <b>Title contains
                </b>                   
                <br>
                <input type='text name='head' size='80'>
                <br>

                <?php
                    echo $workgroupHtml;
                ?>

                <input type='image' onclick='return Search();' class='button border0' src='../images/submit.png' name='' id='submit' value=' Submit '>
                
                <input type='hidden' name='formSubmitted' value='yes'>
            </form>
<?php
    }

?>                        
                   <!-- Dialogs -->                         
                   <div id='searchResultDialog' class='icodeDialog'> hi company
                   </div>
                   <div id='searchDialog' class='icodeDialog'>hi recp
                   </div>
                   <!-- Dialogs end-->
              </div>           
              <!--content ends-->
         </div>
         <!--contentArea ends-->