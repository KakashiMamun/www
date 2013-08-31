<?php
function parse_mysql_dump($url)
      {
          global $wpdb;  
          $wpdb->show_errors();
          $file_content = file($url);
          $query='';
          foreach($file_content as $sql_line)
          {
              if(trim($sql_line) != "" && strpos($sql_line, "--") === false)
              {
                  //echo $sql_line . '<br>';
                  $query.=' '.$sql_line;
                  if(strpos($sql_line,";")!==false)
                  {
                      //echo $query. '<br>';      //make the table
                      if($wpdb->query($query)===false) echo"<br> couldn't execute<br>";
                      $query='';
                  }
              }
          }
          
          $wpdb->hide_errors();
      }
?>