<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/9/13
 * Time: 5:29 PM
 * To change this template use File | Settings | File Templates.
 */

if(isset($_POST['slug'])){

    switch($_POST['slug']){

        default: echo json_encode($_POST['slug']);
    }
}

//echo json_encode(array('slug' =>'slug ok'));

