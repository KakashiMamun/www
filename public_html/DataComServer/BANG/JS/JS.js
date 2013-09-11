<script type=”text/javascript”>
var EventUtil = new Object;
// only for bubbling
EventUtil.addEventHandler = function (oTarget, sEventType, fnHandler) {
   if (oTarget.addEventListener)
   { //for DOM-compliant browsers
     oTarget.addEventListener(sEventType, fnHandler, false);
   }
   else if (oTarget.attachEvent)
   { //for IE
     oTarget.attachEvent(“on” + sEventType, fnHandler);
   }
   else
   { //for all others
     oTarget[“on” + sEventType] = fnHandler;
   }
};

EventUtil.removeEventHandler = function (oTarget, sEventType, fnHandler)
{
  if (oTarget.removeEventListener
  ) { //for DOM-compliant browsers
    oTarget.removeEventListener(sEventType, fnHandler, false);
  }
  else if (oTarget.detachEvent)
  { //for IE
    oTarget.detachEvent(“on” + sEventType, fnHandler);
  }
  else
  { //for all others
    oTarget[“on” + sEventType] = null;
  }
};

//use this way. attach the events in onload event of window
function handleClick()
{
  alert(“Click!”);
  var oDiv = document.getElementById(“div1”);
  EventUtil.removeEventHandler(oDiv, “click”, handleClick);
}
window.onload = function()
{
  var oDiv = document.getElementById(“div1”);
  EventUtil.addEventHandler(oDiv, “click”, handleClick);
}

//event formatiing

EventUtil.formatEvent = function (oEvent) {
if (isIE && isWin) {
oEvent.charCode = (oEvent.type == “keypress”) ? oEvent.keyCode : 0;
oEvent.eventPhase = 2;
oEvent.isChar = (oEvent.charCode > 0);
oEvent.pageX = oEvent.clientX + document.body.scrollLeft;
oEvent.pageY = oEvent.clientY + document.body.scrollTop;
oEvent.preventDefault = function () {
this.returnValue = false;
};
if (oEvent.type == “mouseout”) {
oEvent.relatedTarget = oEvent.toElement;
} else if (oEvent.type == “mouseover”) {
oEvent.relatedTarget = oEvent.fromElement;
}
oEvent.stopPropagation = function () {
this.cancelBubble = true;
};
oEvent.target = oEvent.srcElement;
}
return oEvent;
};

</script>