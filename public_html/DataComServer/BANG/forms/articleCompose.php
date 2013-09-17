
<script language="javascript" type="text/javascript" src="../tinymce/js/tinymce/tinymce.min.js"></script>
<script language="javascript" type="text/javascript" src="../JS/timeMCEConfig.js"></script>

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/11/13
 * Time: 7:56 PM
 * To change this template use File | Settings | File Templates.
 */


if(isset($_POST['formSubmitted']))
{
    ICodeConfig::Write($_POST['newConfiguration'],'');

}
?>
<form action='http://urboshi.com/UrboshiAction.php' method='post' enctype='multipart/form-data'>
    <table class='form regForm' cellpadding='0' cellspacing='0'>
        <tr>
            <td class='leftTd'> Ttile:
            </td>
            <td class='rightTd'><input size="80" type='text' name='Title' id='Title' value="">
            </td>
        </tr>

        <tr>
            <td class='leftTd'> Body:
            </td>
            <td class='rightTd '><textarea class="editme" name='Content' id='Content'></textarea>
            </td>
        </tr>

        <tr>
            <td class='leftTd'> Tags:
            </td>
            <td class='rightTd'><textarea  cols="80" rows="1" name='Tags' id='Tags'></textarea>
            </td>
        </tr>

        <tr>
            <td class='leftTd'> meta sTags:
            </td>
            <td class='rightTd'><textarea  cols="80" rows="1" name='meta_tags' id='meta_tags'></textarea>
            </td>
        </tr>
        <tr>
            <td class='leftTd'> meta Description:
            </td>
            <td class='rightTd'><textarea  cols="30" rows="4" name='meta_Desc' id='meta_Desc'></textarea>
            </td>
        </tr>
        <tr>
            <td class='leftTd'>Categories :
            </td>
            <td class='rightTd'>
                <select name='' id='Categories'>
                    <option   value="A"></option>
                </select>
            </td>
        </tr>
        <tr>
            <td class='leftTd'>Meta Image :
            </td>
            <td class='rightTd'><input type="file" name="meta_img" accept="image/*">
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

    <input type='hidden' name='authorInfo' value='yes'>

    <input type='hidden' name='uploaderInfo' value='yes'>

    <input type='hidden' name='formSubmitted' value='yes'>
</form>

