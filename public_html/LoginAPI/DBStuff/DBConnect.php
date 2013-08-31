<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 8/17/13
 * Time: 9:49 PM
 * To change this template use File | Settings | File Templates.
 */

Class DbConnect {

    var $host = '';
    var $user = '';
    var $password = '';
    var $database = '';
    var $persistent = false;

    var $conn = NULL;

    var $result= false;
    var $error_reporting = false;

    /*constructor function this will run when we call the class */

    function DbConnect ($host, $user, $password, $database, $error_reporting=true, $persistent=false) {

        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->persistent = $persistent;
        $this->error_reporting = $error_reporting;
    }

    function open() {

        if ($this->persistent) {

            $func = 'mysqli_pconnect';

        } else {

            $func = 'mysqli_connect';

        }

        /* Connect to the MySQl Server */

        $this->conn = $func($this->host, $this->user, $this->password);

        if (!$this->conn) {

            return false;

        }

        /* Select the requested DB */

        if (@!mysqli_select_db( $this->conn, $this->database)) {

            return false;
        }
        return true;
    }

    /*close the connection */

    function close() {

        return (@mysqli_close($this->conn));
    }

    /* report error if error_reporting set to true */

    function error() {

        if ($this->error_reporting) {

            return (mysqli_error($this->conn)) ;
        }

    }

    function query($sql) {

        $this->result = @mysqli_query($this->conn, $sql);

        return($this->result != false);

    }
    function affectedrows() {

        return(@mysqli_affected_rows($this->conn));
    }

    function numrows() {

        return(@mysqli_num_rows($this->result));

    }
    function fetchobject() {

        return(@mysqli_fetch_object($this->result, MYSQL_ASSOC));

    }
    function fetcharray() {

        return(mysqli_fetch_array($this->result));

    }

    function fetchassoc() {

        return(@mysqli_fetch_assoc($this->result));
    }

    function freeresult() {

        return(@mysqli_free_result($this->result));

    }

}
