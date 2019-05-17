/**********************************************************************
        Version: FreeRichTextEditor.com (Free AJAX Version 1.00).
        License: http://creativecommons.org/licenses/by/2.5/
        Description: Example of how to add freeAJAX into a page.
        Author: Copyright (C) 2006  Steven Ewing
**********************************************************************/
function ajaxSend(ajaxMethod, ajaxUrl, ajaxDiv, ajaxOutput)
{ function ajaxObject()
{ if (document.all && !window.opera)
{ obj = new ActiveXObject("Microsoft.XMLHTTP");}
else
{ obj = new XMLHttpRequest();}
return obj;}
var ajaxHttp = ajaxObject(); ajaxHttp.open(ajaxMethod, ajaxUrl);

ajaxHttp.onreadystatechange = function()
{
if(ajaxHttp.readyState == 1)
{ var ajaxResponse = ajaxHttp.responseText; if (ajaxOutput == "innerHTML")
{  showContactTimer(0); }
else if (ajaxOutput == "value")
{ showContactTimer(0); }
}
if(ajaxHttp.readyState == 4)
{ var ajaxResponse = ajaxHttp.responseText; if (ajaxOutput == "innerHTML")
{ showContactTimer(1); document.getElementById("informe").innerHTML="<B><center>Consulta Ley de Politica Habitacional</b></center>"; document.getElementById(ajaxDiv).innerHTML = ajaxResponse;}
else if (ajaxOutput == "value")
{ showContactTimer(1); document.getElementById("informe").innerHTML="<B><center>Consulta Ley de Politica Habitacional</b></center>"; document.getElementById(ajaxDiv).value = ajaxResponse;}
}
}
ajaxHttp.send('');}
function ajaxSend1(ajaxMethod, ajaxUrl, ajaxDiv, ajaxOutput)
{ function ajaxObject()
{ if (document.all && !window.opera)
{ obj = new ActiveXObject("Microsoft.XMLHTTP");}
else
{ obj = new XMLHttpRequest();}
return obj;}
var ajaxHttp = ajaxObject(); ajaxHttp.open(ajaxMethod, ajaxUrl);

ajaxHttp.onreadystatechange = function()
{ 
 if(ajaxHttp.readyState == 4)
{ var ajaxResponse = ajaxHttp.responseText; if (ajaxOutput == "innerHTML")
{ document.getElementById(ajaxDiv).innerHTML = ajaxResponse;}
else if (ajaxOutput == "value")
{ document.getElementById(ajaxDiv).value = ajaxResponse;}
}
}
ajaxHttp.send('');}
function ajaxSend2(ajaxMethod, ajaxUrl, ajaxDiv, ajaxOutput)
{ function ajaxObject()
{ if (document.all && !window.opera)
{ obj = new ActiveXObject("Microsoft.XMLHTTP");}
else
{ obj = new XMLHttpRequest();}
return obj;}
var ajaxHttp = ajaxObject(); ajaxHttp.open(ajaxMethod, ajaxUrl);

ajaxHttp.onreadystatechange = function()
{ if(ajaxHttp.readyState == 4)
{ var ajaxResponse = ajaxHttp.responseText; if (ajaxOutput == "innerHTML")
{ document.getElementById(ajaxDiv).innerHTML = ajaxResponse;}
else if (ajaxOutput == "value")
{ document.getElementById(ajaxDiv).value = ajaxResponse;}
}
}
ajaxHttp.send('');}

function cambio()
{
	 if(document.form1.txtrequix.value=="")
	 {
		alert("Error...Falta el numero de requisicion Seleccione un tipo de Solicitud");
		return false;
	 }
	 if(document.form1.cmdcatego.value=="")
	 {
		alert("Error...Falta la Categoria Programatica");
		return false;
	 }	 
	  if(document.form1.cmdsoli.value=="")
	 {
		alert("Error...Falta la Unidad Solicitante");
		return false;
	 }	
}
function showContactTimer (tipo) {
	var loader = document.getElementById('loadBar');
	if (tipo==0) {
     	loader.style.display = 'block';
	sentTimer = setTimeout("hideContactTimer()",6000);
	} else
	loader.style.display = 'none';
}
