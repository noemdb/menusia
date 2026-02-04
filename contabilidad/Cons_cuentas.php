<?include ("../class/ventana.php"); include ("../class/fun_fechas.php");
  $equipo = getenv("COMPUTERNAME");  $fecha_hoy=asigna_fecha_hoy();  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel=stylesheet>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_comp.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function revisar(){var f=document.form1;var Valido=true;
    if(f.txtCodigo_Cuenta.value==""){alert("Codigo de Cuenta no puede estar Vacio");return false;}    
    document.form1.submit;
return true;}
</script>

</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONSULTAR CUENTAS CONTABLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="307" border="0" id="tablacuerpo">
  <tr>
    <td><table width="92" height="305" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tablamenu">
        <td width="86">
      <td>
      <table width="92" height="305" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Cuentas.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_Cuentas.php">Atras</A></td>
      </tr>      
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
           onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
      </tr>
    <tr>
       <td>&nbsp;</td>
     </tr>
    </table></td>
        </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:874px; height:300px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="consult_cta.php" onSubmit="return revisar()">
      <table width="869" >
	          <tr> <td>&nbsp;</td>  </tr>
              <tr>
                <td>
                  <table width="861" border="0">
          <tr>
            <td width="432"><blockquote>
                <p><span class="Estilo5">C&Oacute;DIGO DE CUENTA :
                          <input name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" title="Registre el Codigo de la Cuenta"  size="30" maxlength="30" onFocus="encender(this); " onBlur="apagar(this);" onKeypress="return validarNum(event)">
                </span></p>
            </blockquote></td>
            <td width="419"></td>
          </tr>
        </table></td>
              </tr>
			  <tr> <td>&nbsp;</td>  </tr>
			  <tr> <td>&nbsp;</td>  </tr>
          </table>
        
          
        <table width="768">
          <tr>
            <td width="664"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Buscar"></td>
            <td width="88"><input name="Submit" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>

</table>
</body>
</html>