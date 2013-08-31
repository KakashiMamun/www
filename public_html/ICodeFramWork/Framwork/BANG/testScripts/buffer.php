<?php
    ob_start();
    print "Hello first!\n";

    ob_start();
    print "Hello second!\n";

    ob_flush();
?> 

