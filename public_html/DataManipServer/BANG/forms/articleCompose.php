
<?php
require_once('../classes/Article.class.php');
$formError='';
    $numberOfSites=0;
    if($numberOfSites<=0)
        $formError="Please Fill everything";
    $editUrl="index.php?page=editArticle&";



if(isset($_POST['formSubmitted']))
{
         $_POST = ICodeFormValidation::ProcessFormData($_POST);
         $formError = Article::Add();
}


if(isset($_POST['formSubmitted']))
{
//    echo 'ok';
//    print_r($result);
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
                     <div>New Article</div>
               </span><span class='subHeadRight'>
               </span>
        </div>

        <form action='' method='post' enctype='multipart/form-data'>
            <div class='form'>
                <div class='formHead'>
                    Site details
                </div>
                <div class='bigPadder'>
                    <table cellpadding='0' cellspacing='0' class="profile">
                        <tr>
                            <td class='leftTd'> Ttile:
                            </td>
                            <td class='rightTd'><input size="80" type='text' name='title' value="">
                            </td>
                        </tr>

                        <tr>
                            <td class='leftTd'> Body:
                            </td>
                            <td class='rightTd '><textarea class="editme" name='content' ></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td class='leftTd'> Tags:
                            </td>
                            <td class='rightTd'><textarea  cols="80" rows="1" name='tags' id='tags'></textarea>
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
                            <td class='rightTd'><textarea  cols="30" rows="4" name='meta_desc' id='meta_desc'></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class='leftTd'>Categories :
                            </td>

                            <td class='rightTd'><input class="autocomplete_Multiple  ui-widget" size="40" type='text' name='categories'  value="">
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
                </div>
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

                <input type='hidden' name='ActionType' value='articleCompose'>

            </div>


        </form>

