var timeOutId=0;
var timeOutPeriod=1000;
$(document).ready(function()
{
    Initialize();

});
                 
function ShowSubMenu(cssId)
{                        
    HideAllSubMenu(0);
    //alert(cssId);
    ChangeMenuClass(cssId,'selectedTop');
    if(cssId=='')
        return;
    var absPos=jQuery('#'+cssId).offset();
    //alert(absPos.left);
    //alert(absPos.top);
    X=absPos.left;
    width=jQuery('#'+cssId).width();
    height=jQuery('#'+cssId).height();
    //alert(nextDivPos.left);
    //alert(nextDivPos.top);
    //Y=nextDivPos.top;
    Y=absPos.top+height;
    //alert('#sub'+cssId);
    //alert($('#sub'+cssId).css('top'));
    $('#sub'+cssId).css('top',Y);    
    //alert($('#sub'+cssId).css('top'));
    $('#sub'+cssId).css('left',X);
    $('#sub'+cssId).css('width',width);
    $('#sub'+cssId).css('opacity','1');
}

function ShowSubSubMenu(cssId,subCssId)
{                                             
    $('.subSubMenu').css('opacity','0');   
    $('.subSubMenu').css('left','auto');   
    $('.subSubMenu').css('right',0);
    //alert(subCssId);
    if(jQuery('#'+cssId).css('opacity')==0)
        return;
    var absPos=jQuery('#'+cssId).offset();  
    X=absPos.left+ jQuery('#'+cssId).outerWidth();
    //var absPos=jQuery(pointer).offset();
    //alert(absPos.left);
    //alert(absPos.top);
    width=jQuery('#'+cssId).width();
    Y=absPos.top +5;
    //alert(subCssId);
    //alert($(pointer).html());
    //alert();   
    //alert(X);
    //alert(Y);
    //alert(subCssId);
    $('#'+subCssId).css('top',Y);
    $('#'+subCssId).css('left',X);
    $('#'+subCssId).css('width',width);
    $('#'+subCssId).css('opacity','1');
}
                 
function HideAllSubMenu(timeout)
{
    //return;
    ClearTimeOut();
    //alert('hiding'+timeout);
    if(timeout==0)
    {                                            
        $('.subMenu').css('opacity','0');
        $('.subSubMenu').css('opacity','0');     
        $('.subMenu').css('left','auto');
        $('.subSubMenu').css('left','auto');
        $('.subMenu').css('right',0);
        $('.subSubMenu').css('right',0);
        ChangeMenuClass('','selectedTop');
    }
    else
        timeOutId=setTimeout("HideAllSubMenu(0)",timeout);
    //alert('time out id #'+timeOutId);
}

function ClearTimeOut()
{   
    if(timeOutId!=0)
       clearTimeout(timeOutId);
    timeOutId=0;
}

function Initialize()
{                                    
    $('.mainMenu').mouseout(function()
    {
         HideAllSubMenu(timeOutPeriod);
    });
    $('.mainMenu').mouseover(function()
    {
         ClearTimeOut();
    });
    $('.subMenu').mouseout(function()
    {
         HideAllSubMenu(timeOutPeriod);
    });
    $('.subMenu').mouseover(function()
    {
         ClearTimeOut();
    });
    $('.subSubMenu').mouseout(function()
    {
         HideAllSubMenu(timeOutPeriod);
    });
    $('.subSubMenu').mouseover(function()
    {
         ClearTimeOut();
    });
}

function ChangeMenuClass(id,classi)
{

    $('.'+classi).removeClass(classi);
    if(id!='')
        $('#'+id).addClass(classi);

}