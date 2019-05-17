function ajaxSenddoc(ajaxMethod, ajaxUrl, ajaxDiv, ajaxOutput){ 
function ajaxObject(){ 
if (document.all && !window.opera){ obj = new ActiveXObject("Microsoft.XMLHTTP");}
else{ obj = new XMLHttpRequest();}
return obj;}
var ajaxHttp = ajaxObject(); ajaxHttp.open(ajaxMethod, ajaxUrl);
ajaxHttp.onreadystatechange = function(){ 
 if(ajaxHttp.readyState == 4){ var ajaxResponse = ajaxHttp.responseText; 
  if (ajaxOutput == "innerHTML") { document.getElementById(ajaxDiv).innerHTML = ajaxResponse;}
  else if (ajaxOutput == "value"){document.getElementById(ajaxDiv).value = ajaxResponse;}
 }
}
ajaxHttp.send('');}