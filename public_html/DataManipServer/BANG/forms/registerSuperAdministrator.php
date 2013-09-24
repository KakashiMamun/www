<?php
    $stateOptions=Country::GetStateOptions(0); 
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
                                                     <option value=''></option>
                                                     <option value='Mr'>Mr</option>
                                                     <option value='Ms'>Ms</option>
                                                     <option value='Mrs'>Mrs</option>
                                                </select>
                                                <input type='hidden' name='customTitle' id='' value="">
                                            </td>
                                        </tr>        
                                        <tr>     
                                            <td class='leftTd'> First Name:
                                            </td>
                                            <td class='rightTd'><input type='text' name='fName' id='' value="<?php echo ICodeTools::GetRawValue('fName'); ?>">
                                            </td>
                                        </tr>                                                            
                                        <tr>     
                                            <td class='leftTd'> Surname:
                                            </td>
                                            <td class='rightTd'><input type='text' name='lName' id='' value="<?php echo ICodeTools::GetRawValue('lName'); ?>">
                                            </td>
                                        </tr>      
                                        <tr>     
                                            <td class='leftTd'> Job Title:
                                            </td>
                                            <td class='rightTd'><input type='text' name='jobTitle' id='' value="<?php echo ICodeTools::GetRawValue('jobTitle'); ?>">
                                            </td>
                                        </tr>      
                                        <tr>     
                                            <td class='leftTd'> Company Name:
                                            </td>
                                            <td class='rightTd'><input type='text' name='companyName' id='' value="<?php echo ICodeTools::GetRawValue('companyName'); ?>">
                                            </td>
                                        </tr>                      
                                        <tr>     
                                            <td class='leftTd'> Address Line 1:
                                            </td>
                                            <td class='rightTd'><input type='text' name='address1' id='' value="<?php echo ICodeTools::GetRawValue('address1'); ?>">
                                            </td>
                                        </tr>    
                                        <tr>     
                                            <td class='leftTd'> Address Line 2:
                                            </td>
                                            <td class='rightTd'><input type='text' name='address2' id='' value="<?php echo ICodeTools::GetRawValue('address2'); ?>">
                                            </td>
                                        </tr>    
                                        <tr>     
                                            <td class='leftTd'> Address Line 3:
                                            </td>
                                            <td class='rightTd'><input type='text' name='address3' id='' value="<?php echo ICodeTools::GetRawValue('address3'); ?>">
                                            </td>
                                        </tr>        
                                        <tr>     
                                            <td class='leftTd'> Town/City:
                                            </td>
                                            <td class='rightTd'>    
                                                <input type='text' name='city' id='' value="<?php echo ICodeTools::GetRawValue('city'); ?>">
                                            </td>
                                        </tr>       
                                        <tr>     
                                            <td class='leftTd'> County:
                                            </td>
                                            <td class='rightTd'> 
                                                <select name='stateId' id=''>
                                                      <?php echo $stateOptions;?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>     
                                            <td class='leftTd'> Post Code:
                                            </td>
                                            <td class='rightTd'><input type='text' name='postcode' id='' value="<?php echo ICodeTools::GetRawValue('postcode'); ?>">
                                            </td>
                                        </tr>
                                        <tr>     
                                            <td class='leftTd'> Email:
                                            </td>
                                            <td class='rightTd'><input type='text' name='email' id='' value="<?php echo ICodeTools::GetRawValue('email'); ?>">
                                            </td>
                                        </tr>            
                                        <tr>     
                                            <td class='leftTd'> Retype Email:
                                            </td>
                                            <td class='rightTd'><input type='text' name='email2' id='' value="<?php echo ICodeTools::GetRawValue('email2'); ?>">
                                            </td>
                                        </tr>            
                                        <tr>     
                                            <td class='leftTd'> Telephone:
                                            </td>
                                            <td class='rightTd'><input type='text' name='phone' id='' value="<?php echo ICodeTools::GetRawValue('phone'); ?>">
                                            </td>
                                        </tr>
                                        <tr>     
                                            <td class='leftTd'> Tick if this will be the same as your invoice address:
                                            </td>
                                            <td class='rightTd'><input <?php echo ICodeTools::IfChecked('sameInvoiceAddress'); ?> type='checkbox' class='checkbox' name='sameInvoiceAddress' id='sameInvoiceAddress' value="yes">
                                            </td>
                                        </tr>
                                        <tr>     
                                            <td class='leftTd'> Company Name:
                                            </td>
                                            <td class='rightTd'><input type='text' name='companyNameInv' id='' value="<?php echo ICodeTools::GetRawValue('companyNameInv'); ?>">
                                            </td>
                                        </tr>                      
                                        <tr>     
                                            <td class='leftTd'> Address Line 1:
                                            </td>
                                            <td class='rightTd'><input type='text' name='address1Inv' id='' value="<?php echo ICodeTools::GetRawValue('address1Inv'); ?>">
                                            </td>
                                        </tr>    
                                        <tr>     
                                            <td class='leftTd'> Address Line 2:
                                            </td>
                                            <td class='rightTd'><input type='text' name='address2Inv' id='' value="<?php echo ICodeTools::GetRawValue('address2Inv'); ?>">
                                            </td>
                                        </tr>    
                                        <tr>     
                                            <td class='leftTd'> Address Line 3:
                                            </td>
                                            <td class='rightTd'><input type='text' name='address3Inv' id='' value="<?php echo ICodeTools::GetRawValue('address3Inv'); ?>">
                                            </td>
                                        </tr>    
                                        <tr>     
                                            <td class='leftTd'> Town/City:
                                            </td>
                                            <td class='rightTd'>
                                                <input type='text' name='cityInv' id='' value="<?php echo ICodeTools::GetRawValue('cityInv'); ?>">
                                            </td>
                                        </tr>                
                                        <tr>     
                                            <td class='leftTd'> County:
                                            </td>
                                            <td class='rightTd'> 
                                                <select name='stateIdInv' id=''>
                                                      <?php echo $stateOptions;?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>     
                                            <td class='leftTd'> Post Code:
                                            </td>
                                            <td class='rightTd'><input type='text' name='postcodeInv' id='' value="<?php echo ICodeTools::GetRawValue('postcodeInv'); ?>">
                                            </td>
                                        </tr>
                                        <tr>     
                                            <td class='leftTd'>
                                            </td>
                                            <td class='rightTd'>

                                            <input type='image' class='button border0' src='images/register.png' name='' id='submit' value=' Submit '>

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