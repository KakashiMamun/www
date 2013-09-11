<?php
class ICodeRenderer
{
    public static function GetHtmlTable($items,$itemsPerRow,$tableClass='')
    {
        $html="<table class='$tableClass' cellspacing='0' cellpadding='0'>
             <tr>";
        $count=0;
        foreach($items as $item)
        {
            $html.="
                    <td>$item</td>";
            ++$count;
            if($count%$itemsPerRow==0)
                $html.="
                </tr><tr>";
        }
        $i=$count%$itemsPerRow;
        while($i)
        {
            $html.="<td></td>";
            --$i;
        }
        $html.="
                </tr>
                </table>";
        return $html;
    }
}
?>