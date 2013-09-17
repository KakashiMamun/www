<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/1/13
 * Time: 8:45 PM
 * To change this template use File | Settings | File Templates.
 */

require_once('UrboshiController.php');

if($_POST){





    if(isset($_POST['type'])){

        switch($_POST['type']){

            case "articleCompose" : {
            $_POST['tags'] =  unserialize($_POST['tags']);
            $_POST['categories'] =  unserialize($_POST['categories']);
            $_POST['authors'] =  unserialize($_POST['authors']);
            $_POST['meta_img'] =  unserialize($_POST['meta_img']);
            $_POST['content'] = ( $_POST['content'] );
//                                        var_dump($_POST);

             extract($_POST);
////                                        var_dump($categories);
            foreach($categories as $key => $cat){

                $categories[$key] = intval($cat);
            }
////                                        var_dump($categories);
            createNewArticle($ID,$title,$content,$meta_tags,$meta_Desc,$meta_img,$authors,$tags,$uploader_id,$categories);
///

                                    }
        }
    }

}