function ShowError(error)
{
    alert(error);
    $('#jsError').html(error);
    return false;
}

function CountChecked(fieldName)
{
    return $("input[name^='"+fieldName+"']:checked").length;
}

function ReloadWindow()
{
    window.location.href=window.location.href;
}

function Redirect(url)
{   
    window.location.href=url;
}

function GetBaseUrl()
{
    //alert(window.location.protocol);
    return window.location.protocol+'//'+window.location.host+'/';
}

function GetDirUrl(back)
{
    //alert(window.location.pathname);
    var path=''
    var pathArray = window.location.pathname.split( '/' );
    pathArray.pop();
    for(var i=0;i<(pathArray.length-back);++i)
    {
        if(pathArray[i]=='')
            continue;
        path+=pathArray[i]+'/';
    }
    return GetBaseUrl()+path;
}