<?php
    $formError='';
    if(isset($_POST['formSubmitted']))
    {
        ICodeConfig::Write($_POST['newConfiguration'],'',$_POST['type']);

    }   
    if(isset($_POST['configurationsSubmitted']))
    {                     
        unset($_POST['configurationsSubmitted']);
        unset($_POST['submit']);
        foreach($_POST as $name=>$val)
            ICodeConfig::Update($name,$val);
    }
    //populate current ones
    $allConfs=ICodeConfig::Get();
    $confRows='';
    foreach($allConfs as $aConf)
    {
        $confRows.="<tr>
                       <td class='leftTd'> {$aConf['name']}:
                       </td>
                       <td class='rightTd'><input type='text' name='{$aConf['name']}' id='' value='{$aConf['value']}'>
                       </td>
                   </tr>";
        
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
                           <div class='subHead'>
                               <span class='subHeadLeft'>
                                     <div>New configuration</div>
                               </span><span class='subHeadRight'>
                               </span>
                           </div>
                           <form enctype="multipart/form-data" method="post" action="">
                               <div class='form'>
                                    <div class='formHead'>
                                         Configuration details
                                    </div>
                                    <div class='bigPadder'>  
                                         <table cellspacing="0" cellpadding="0" class="profile">
                                                <tr>     
                                                    <td class='leftTd'> New Configuration Name:
                                                    </td>
                                                    <td class='rightTd'><input type='text' name='newConfiguration' id='' value="<?php echo ICodeTools::GetRawValue('newConfiguration'); ?>">
                                                    </td>
                                                </tr>     
                                                <tr>     
                                                    <td class='leftTd'> Type:
                                                    </td>
                                                    <td class='rightTd'> 
                                                        <select name='type' id=''>
                                                             <option  <?php echo ICodeTools::IfSelected('type','developer'); ?>  value="developer">developer</option>
                                                             <option  <?php echo ICodeTools::IfSelected('type','pagination'); ?>  value="pagination">pagination</option>
                                                             <option  <?php echo ICodeTools::IfSelected('type','server'); ?>  value="server">server</option>
                                                             <option  <?php echo ICodeTools::IfSelected('type','email'); ?>  value="email">email</option>
                                                        </select>
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
                if(isset($_SESSION['formHidden']))
                {
                    foreach($_SESSION['formHidden'] as $key=>$val)
                       echo "<input type='hidden' name='$key' value='$val' />";
                }
            ?>          
            <input type='hidden' name='formSubmitted' value='yes'>
        </form>
<?php
    //print_r($CONFIGURATIONS);
?>                                                                             
                           <div class='subHead'>
                               <span class='subHeadLeft'>
                                     <div>Configurations</div>
                               </span><span class='subHeadRight'>
                               </span>
                           </div>
                           <form enctype="multipart/form-data" method="post" action="">
                               <div class='form'>
                                    <div class='formHead'>
                                        All configuration data
                                    </div>
                                    <div class='bigPadder'>  
                                         <table cellspacing="0" cellpadding="0" class="profile">

                                                <?php
                                                    echo $confRows;
                                                ?>
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
                                    <input type="hidden" value="yes" name="configurationsSubmitted">

                                </div>
                           </form>
              </div>           
              <!--content ends-->
         </div>
         <!--contentArea ends-->