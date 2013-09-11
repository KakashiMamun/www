<?php
    require_once('../includes/backIncludes.php');
    $formError='';
    $_SESSION['formHidden']['siteId']=$_POST['siteId'];
    $siteInfo=Site::GetInfo($_POST['siteId']);
?>
                           <form enctype="multipart/form-data" method="post" action="">
                               <div class='form dialogForm'>
                                    <div class='formHead dialogHead'>
                                         Site details
                                    </div>
                                    <div class='bigPadder'>  
                                         <table cellspacing="0" cellpadding="0" class="profile">
                                                <tr>     
                                                    <td class='leftTd'> <b>Site Name</b>:
                                                    </td>
                                                    <td class='rightTd'><input type='text' name='name' id='' value="<?php echo $siteInfo['name']; ?>">
                                                    </td>
                                                </tr>
                                                <tr>     
                                                    <td class='leftTd'> Description:
                                                    </td>
                                                    <td class='rightTd'><textarea  name='description' id=''><?php echo $siteInfo['description']; ?></textarea>
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