<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/17/13
 * Time: 4:32 PM
 * To change this template use File | Settings | File Templates.
 */


require_once('UrboshiNextID.class.php');



for($i=1;$i<100;$i++){

    echo UrboshiNextID::getNextArticleID();
    echo '<br>';
    echo UrboshiNextID::getNextCategoryID();
    echo '<br>';
    echo '<br>';
}