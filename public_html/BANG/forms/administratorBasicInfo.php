<?php
    $stateOptions=Country::GetStateOptions((int)ICodeTools::GetRawValue('stateId','state_id'));   
    $titleOptions=User::GetTitleOptions(ICodeTools::GetRawValue('title'));
    $ownerId=Administrator::GetOwnerId($currentUserId);
    $companyInfo=Company::GetByUser($currentUserId,$ownerId);
    $companyOptions=Company::GetHtmlOptions($ownerId,$companyInfo['company_id']);
?>                                                                           
                   <form enctype="multipart/form-data" method="post" action="">
                       <div class='form'>
                            <div class='formHead'>
                                 Your details
                            </div>
                            <div class='bigPadder'>
                                 <table cellspacing="0" cellpadding="0" class="profile">
                                        <tr>     
                                            <td class='leftTd'> Title:
                                            </td>
                                            <td class='rightTd'> 
                                                <select name='title'>                       
                                                <?php
                                                    echo $titleOptions;
                                                ?>
                                                </select>
                                                <input type='hidden' name='customTitle' id='' value="">
                                            </td>
                                        </tr>        
                                        <tr>     
                                            <td class='leftTd'> First Name:
                                            </td>
                                            <td class='rightTd'><input type='text' name='fName' id='' value="<?php echo ICodeTools::GetRawValue('fName','f_name'); ?>">
                                            </td>
                                        </tr>                                                            
                                        <tr>     
                                            <td class='leftTd'> Surname:
                                            </td>
                                            <td class='rightTd'><input type='text' name='lName' id='' value="<?php echo ICodeTools::GetRawValue('lName','l_name'); ?>">
                                            </td>
                                        </tr>      
                                        <tr>     
                                            <td class='leftTd'> Job Title:
                                            </td>
                                            <td class='rightTd'><input type='text' name='jobTitle' id='' value="<?php echo ICodeTools::GetRawValue('jobTitle','job_title'); ?>">
                                            </td>
                                        </tr>
                                        <tr>     
                                            <td class='leftTd'> Company:
                                            </td>
                                            <td class='rightTd'> 
                                                <select name='companyId' id=''>
                                                      <?php echo $companyOptions; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>     
                                            <td class='leftTd'> Email: (leave blank for no change)
                                            </td>
                                            <td class='rightTd'><input type='text' name='email' id='' value="<?php echo ICodeTools::GetRawValue('email'); ?>">
                                            </td>
                                        </tr>            
                                        <tr>     
                                            <td class='leftTd'> Retype Email:
                                            </td>
                                            <td class='rightTd'><input type='text' name='email2' id='' value="<?php echo ICodeTools::GetRawValue('email'); ?>">
                                            </td>
                                        </tr>   
                                        <tr>     
                                            <td class='leftTd'> Mobile Phone Number:
                                            </td>
                                            <td class='rightTd'><input type='text' name='mobile' id='' value="<?php echo ICodeTools::GetRawValue('mobile'); ?>">
                                            </td>
                                        </tr>
                                        <tr>     
                                            <td class='leftTd'>
                                            </td>
                                            <td class='rightTd'>
                                            <input type='image' class='button border0' src='../images/update.png' name='' id='submit' value=' Submit '>
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