$(document).ready(function()
{
   PositionFooter();
});
$(window).scroll(function()
{
   PositionFooter();
});

function PositionFooter()
{
   var height = $(window).height();
   //alert(height);
   //alert($('#footerArea').css('top'));
   //$('#footerArea').css('top',100);
   $('#footerArea').css('top',($(window).scrollTop()+height-35)+'px');
   //alert($('#footerArea').css('top'));
   //alert($(window).scrollTop());
}