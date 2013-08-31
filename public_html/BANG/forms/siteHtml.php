<?php
        $siteHtml="
            <table id='sitesHtml' class='backTable' cellpadding='0' cellspacing='0'>
                <tr>              
                    <th>
                        Sites
                    </th>
                </tr>";        
        $count=0;
        $checked='';
        if(isset($hideUnassociated))
            $checked='';
        foreach($sites as $aSite)
        {             
            if($count%2 ==0)
                $rowClass='evenRow';
            else         
                $rowClass='oddRow';
            ++$count;
            $siteHtml.="
                <tr class='$rowClass'>
                    <td>
                        <input $checked class='checkbox siteCheckbox' type='checkbox' name='siteId[]' value='{$aSite['site_id']}'>{$aSite['name']}
                    </td>
                </tr>
            ";
        }
              
        $siteHtml.='
            </table>
        ';
?>