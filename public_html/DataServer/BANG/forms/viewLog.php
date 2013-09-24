<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 9/24/13
 * Time: 5:07 AM
 * To change this template use File | Settings | File Templates.
 */


require_once('../includes/frontIncludes.php');


$logs = (ICodeDB::GetResultsSet('Select * from icode_error_log'));
$count = count($logs);
/** printing starts **/
echo"<div id='status' class='formError'>
              <img src='../images/magicStatus.png'><span>$formError</span>
              <span id='jsError'>
              </span>
       </div>";
?>


        <div class='subHead'>
            <span class='subHeadLeft'>
                  <div>View Log</div>
            </span><span class='subHeadRight'>
                  <img src='images/subHeadIcon.png'>
            </span>
        </div>
        <table class='backTable' cellspacing=0 cellpadding=0>
            <tr>
                <th>ID
                </th>
                <th>URI
                </th>
                <th>Content
                </th>
                <th>Module
                </th>
                <th>Function
                </th>
                <th>Type
                </th>
                <th>Time
                </th>
            <tr>
          <?php
            foreach($logs as $log)
            {
                if(!($log['type'] === 'Error'))
                    $rowType = 'oddRow';
                else
                    $rowType = 'evenRow highlight';
                echo "
                <tr class='$rowType'>
                    <td> $log[id]
                    </td>
                    <td> $log[uri]
                    </td>
                    <td> $log[content]
                    </td>
                    <td> $log[module]
                    </td>
                    <td> $log[function]
                    </td>
                    <td> $log[type]
                    </td>
                    <td> $log[time]
                    </td>
                </tr>
                ";
                }
?>
        </table>"

