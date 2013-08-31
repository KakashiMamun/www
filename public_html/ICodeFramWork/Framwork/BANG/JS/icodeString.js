/* want to make a list of ID's? */

function AddToList(item,string)
{
   RemoveFromList(item,string);
   string+=item+';';
   //alert(item);
   //alert(string);
   return string;
}

function RemoveFromList(item,string)
{
   //alert(item+';');
   //alert(string);
   string=string.replace(item+';','');
   return string;
}

function InList(item,string)
{
    if(string.indexOf(item)<0)
        return false;
    return true;
}