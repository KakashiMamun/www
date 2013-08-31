<?php
    $formError='';
    $activeSites=Site::GetTotal($currentUserId);
    if($activeSites<=0)
        $formError="Please create the first site to get started";     
    if(isset($_POST['formSubmitted']))
    {

        $_POST['ownerId']=$currentUserId;  
        $realOwnerId=Administrator::GetOwnerId($currentUserId);
        $siteId=$_POST['siteId'];
        $formError=Site::Update();      
        if($formError===true)
            $formError="Updated";

    }
    $form='site';
    $sites=Site::Get(0,0,$currentUserId);
    //print_r($sitesHavingWG);
    if(count($sites)==0)
    {
        $formError="No active site found.";
        $form='';
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
                       require_once('../forms/siteManagement.php');
                   ?>    
              </div>           
              <!--content ends-->
         </div>
         <!--contentArea ends-->