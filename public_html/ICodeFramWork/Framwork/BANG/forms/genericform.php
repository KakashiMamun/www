<?php
    if(isset($_POST['formSubmitted']))
    {
        ICodeConfig::Write($_POST['newConfiguration'],'');

    }
?>
        <form action='' method='post' enctype='multipart/form-data'>
            <table class='form regForm' cellpadding='0' cellspacing='0'>            
                 <tr>     
                     <td class='leftTd'> :
                     </td>
                     <td class='rightTd'><input type='text' name='' id='' value="<?php echo ICodeTools::GetRawValue(); ?>">
                     </td>
                 </tr>
                 <tr>     
                     <td class='leftTd'> :
                     </td>
                     <td class='rightTd'><input type='password' name='' id='' value="<?php echo ICodeTools::GetRawValue(); ?>">
                     </td>
                 </tr>            
                 <tr>     
                     <td class='leftTd'> :
                     </td>
                     <td class='rightTd'><textarea  name='' id=''><?php echo ICodeTools::GetRawValue(); ?></textarea>
                     </td>
                 </tr>            
                 <tr>     
                     <td class='leftTd'> :
                     </td>
                     <td class='rightTd'><input <?php echo ICodeTools::IfChecked(); ?> type='radio' class='checkbox' name='' id='' value="">
                     </td>
                 </tr>
                 <tr>     
                     <td class='leftTd'> :
                     </td>
                     <td class='rightTd'><input <?php echo ICodeTools::IfChecked(); ?> type='checkbox' class='checkbox' name='' id='' value="">
                     </td>
                 </tr>            
                 <tr>     
                     <td class='leftTd'> :
                     </td>
                     <td class='rightTd'> 
                         <select name='' id=''>
                              <option  <?php echo ICodeTools::IfSelected(,); ?>  value=""></option>
                         </select>
                     </td>
                 </tr>
                 <tr>     
                     <td class='leftTd'>
                     </td>
                     <td class='rightTd'><input type='submit' class='button' name='' id='submit' value=' Submit '>
                     </td>
                 </tr>
            </table>
            <?php
                if(isset($_SESSION['formHidden']))
                {
                    foreach($_SESSION['formHidden'] as $key=>$val)
                       echo "<input type='hidden' name='$key' value='$val' />";
                }
            ?>          
            <input type='hidden' name='formSubmitted' value='yes'>
        </form>