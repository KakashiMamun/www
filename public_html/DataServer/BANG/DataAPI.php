<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/1/13
 * Time: 8:45 PM
 * To change this template use File | Settings | File Templates.
 */

require_once('DataServerClasses/classes/DataLibrary.class.php');
require_once('classes/ICodeFormValidation.class.php');
if($_POST){
    if(isset($_POST['type'])){
        switch($_POST['type'])
        {
            case "articleCompose" :
            {
                $_POST['tags'] =  unserialize($_POST['tags']);
                $_POST['categories'] =  unserialize($_POST['categories']);
                $_POST['authors'] =  unserialize($_POST['authors']);
                $_POST['meta_img'] =  unserialize($_POST['meta_img']);
                $_POST['meta_img'] = $_POST['meta_img']['meta_img']['name'];
//                $_POST['content'] = utf8_encode( $_POST['content'] );
                $_POST = ICodeFormValidation::ProcessFormData($_POST);
    //          var_dump($_POST);
                  extract($_POST);
                $resutl = DataLibrary::createNewArticle($ID,$title,$content,$meta_tags,$meta_Desc,$meta_img,$authors,$tags,$uploaderid,$categories);
                if($resutl)
                    echo 'New Article created';
                else
                    echo 'Something Didnt work';
            }
            break;
            case "getArticles" :
            {
                $resutl = DataLibrary::getArticles();
                echo json_encode($resutl);
            }
            break;
            case "getArticle":
            {
//                echo 'works';
//                extract($_POST);
//                var_dump($_POST);
                $resutl = DataLibrary::getArticleByID($_POST['id']);
                echo json_encode($resutl);
            }
                break;
            case "updateArticle":
            {
                $_POST['tags'] =  unserialize($_POST['tags']);
                $_POST['categories'] =  unserialize($_POST['categories']);
                $_POST['authors'] =  unserialize($_POST['authors']);
                $_POST['meta_img'] =  unserialize($_POST['meta_img']);
                $_POST['meta_img'] = $_POST['meta_img']['meta_img']['name'];
                $_POST['content'] = utf8_encode( $_POST['content'] );
                $_POST = ICodeFormValidation::ProcessFormData($_POST);
                extract($_POST);
                $result = DataLibrary::updateArticle($ID,$title,$content,$meta_tags,$meta_Desc,$meta_img,$tags,$uploaderid);
//                var_dump($result);
                if(isset($result['updatedExisting']))
                    echo 'Article Updated';
                else
                    echo 'Something Didnt work';
            }
                break;
            case "createNewCategory":
            {

                $_POST['name'] = utf8_encode( $_POST['name'] );
                $_POST = ICodeFormValidation::ProcessFormData($_POST);
//                var_dump($_POST);
                extract($_POST);
                $result = DataLibrary::createNewCategory($ID,$name);
                var_dump($result);
                if(isset($result['ok']))
                    echo 'Category Created';
                else
                    echo 'Something Didnt work';
            }
                break;
        }
    }

}

//for category auto complete
if(isset($_GET['term'])){
    $categories = DataLibrary::getCategories($_GET['term']);

    $json = json_encode($categories);
    echo isset($_GET['callback'])
        ? $_GET['callback'] . '('.$json.')'
        : $json;
}


//var_dump(DataLibrary::getArticles());
//var_dump(DataLibrary::getArticleByID('70'));