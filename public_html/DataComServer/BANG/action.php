<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/1/13
 * Time: 8:45 PM
 * To change this template use File | Settings | File Templates.
 */

require_once('classes/UrboshiNextID.class.php');
if($_POST){
//    var_dump($_POST);
//    var_dump($_FILES);
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


    //if no error then
    if(empty($error)){
        //get new article ID from DatacomServerDB
        $ID = UrboshiNextID::getNextArticleID();

        $fields['ID'] = $ID;
    }else{
        var_dump($error);
    }


    $fields_string = '';
//url-ify the data for the POST
    foreach($fields as $key=>$value)
    {
        $fields_string .= $key.'='. urlencode($value) . '&';
    }
    $fields_string = trim($fields_string, "&");
    var_dump($fields_string);

//
//open connection
    $ch = curl_init();

//set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

//execute post
    $result = curl_exec($ch);

//close connection
    curl_close($ch);
    echo $result;

}
