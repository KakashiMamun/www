<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 8/29/13
 * Time: 10:08 PM
 * To change this template use File | Settings | File Templates.
 */


require_once('ICodeMongoDB.class.php');

class UrboshiArticle {

public static function createNewArticle($title,
                                        $content,
                                        $meta_tags=array(),
                                        $meta_description,
                                        $meta_image,
                                        $author = array(),
                                        $tags = array(),
                                        $uploader_id,
                                        $category = array()
){




    $DB = 'Urboshi';
    $Collection = 'Articles';
    $ID = UrboshiArticle::GetNextArticleID();

    $article = array(

        'id' => $ID,
        'category'=> $category,
        'title' => $title,
        'content' => $content,
        'meta_tags'=> $meta_tags,
        'meta_description'=> $meta_description,
        'meta_iamge' => $meta_image,
        'author' => $author,
        'tags' => $tags,
        'uploader_id'=> $uploader_id
    );

    ICodeMongoDB::Insert($article,)
    }

    public static function GetNextArticleID(){

        $command  = 'db.eval("getNextSequence(\'next_article_no\')")';

        $record = ICodeMongoDB::Execute($command, 'Urboshi');


        if(isset($record['retval'])){
            return $record['retval'];
        }else{

            echo 'Error in Next article ID generation';
        }

    }
}