
<?php
    $formError='';
    $numberOfSites=0;
    if($numberOfSites<=0)
        $formError="Please Fill everything";
    $form='site';
    $editUrl="index.php?page=editArticle&";

if(isset($_POST['formSubmitted']))
{
         $_POST = ICodeFormValidation::ProcessFormData($_POST);

//            var_dump($_POST);
//            var_dump($_FILES);
        //set POST variables

        //url to article server
        $url = 'http://data.com/DataAPI.php';

        $fields = array();
        $error = array();
        if(isset($_POST['Title'])){
            $fields['title'] = $_POST['Title'];
        }else{
            array_push($error,'No title');
        }

        if(isset($_POST['Content'])){
            $fields ['content']= ($_POST['Content']);
            echo ($_POST['Content']);
        }else{
            array_push($error,'No Article Body');
        }

        if(isset($_POST['Tags'])){

            $_POST['Tags'] = trim($_POST['Tags'], ',');
            $tags = explode(',',$_POST['Tags']);
            $tags = serialize($tags);
            $fields['tags'] = $tags;
        }else{
            array_push($error,'No tag attached');
        }

        if(isset($_POST['meta_tags'])){
            $fields['meta_tags'] = $_POST['meta_tags'];
        }else{
            array_push($error,'No meta_tag attached');
        }
        if(isset($_POST['meta_Desc'])){
            $fields['meta_Desc'] = $_POST['meta_Desc'];
        }else{
            array_push($error,'No meta_Desc attached');
        }

        if(isset($_POST['Categories'])){

            $_POST['Categories'] = trim($_POST['Categories'], ",");
            $categories = explode(',',$_POST['Categories']);
            $categories = serialize($categories);
            $fields['categories'] = $categories;
        }else{
            array_push($error,'No category attached');
        }

        if(isset($_POST['authorInfo'])){
//        $fields = array_push($fields, 'authorInfo' => $_POST['authorInfo']));
            $authors = array(1,4,5);
            $authors = serialize($authors);
            $fields['authors'] = $authors;
        }else{
            array_push($error,'No authors attached');
        }

        if(isset($_POST['uploaderInfo'])){
            $fields['uploaderid'] = 420;
        }else{
            array_push($error,'No uploader info attached');
        }
        if(isset($_FILES['meta_img'])){
            $meta_img = serialize($_FILES);
            $fields['meta_img'] = $meta_img;
        }else{
            array_push($error,'No imgae attached');
        }

        if(isset($_POST['ActionType'])){
            $fields['type'] = $_POST['ActionType'];
        }else{
            array_push($error,'post Type attached');
        }
        print_r($error);
        //if no error then
        if(empty($error)){
            //get new article ID from DatacomServerDB
            $ID = UrboshiNextID::getNextArticleID();
            $fields['ID'] = $ID;
            $url = 'http://data.com/DataAPI.php';

//            $result = CurlLib::curlPost($url,$fields);
//            var_dump($fields);
        }else{
            $formError = ($error);
            var_dump($error);
        }

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

                            <td class='rightTd'><input class="autocomplete_Multiple  ui-widget" size="40" type='text' name='Categories' id='Categories' value="">
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

