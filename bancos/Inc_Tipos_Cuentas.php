<?include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Tipos de Cuentas)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url)
{
var murl;
var Gcodigo_cuenta=document.form1.txtCodigo_Cuenta.value;
    murl=url+Gcodigo_cuenta;
    if (Gcodigo_cuenta=="")
        {alert("Código de Cuenta debe ser Seleccionada");}
        else {document.location = murl;}
}
function Mover_Registro(MPos)
{
var murl;
   murl="Act_cuentas.php";
   if(MPos=="P"){murl="Act_cuentas.php?Gcodigo_cuenta=P"}
   if(MPos=="U"){murl="Act_cuentas.php?Gcodigo_cuenta=U"}
   if(MPos=="S"){murl="Act_cuentas.php?Gcodigo_cuenta=S"+document.form1.txtCodigo_Cuenta.value;}
   if(MPos=="A"){murl="Act_cuentas.php?Gcodigo_cuenta=A"+document.form1.txtCodigo_Cuenta.value;}
   document.location = murl;
}
function Llama_Eliminar(){
var url;
var r;
  if (document.form1.txtCargable.value=="CARGABLE"){
  r=confirm("Esta seguro en Eliminar la Cuenta ?");
  if (r==true) {
    r=confirm("Esta Realmente seguro en Eliminar la Cuenta ?");
    if (r==true) {
       url="Delete_cuentas.php?txtCodigo_Cuenta="+document.form1.txtCodigo_Cuenta.value;
       VentanaCentrada(url,'Eliminar Plan Cuentas','','400','400','true');}
    }
   else { url="Cancelado, no elimino"; }
  }
  else { alert("CUENTA NO ES CARGABLE, NO PUEDE SER ELIMINADA"); }
}
</script>
<SCRIPT language=JavaScript
src="../class/sia.js"
type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 10px}
.Estilo2 {color: #FFFFFF}
.Estilo6 {
        font-size: 16pt;
        font-weight: bold;
}
.Estilo9 {font-size: 8pt}
.Estilo10 {font-size: 12px}
-->
</style>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR TIPOS DE CUENTAS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="359" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Tipos_Cuentas.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="center"><A class=menu
            href="Act_Tipos_Cuentas.php">Atras</A></div></td>
      </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu</a></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:862px; height:343px; z-index:1; top: 70px; left: 116px;">
            <form name="form1" method="post">
              <table width="839" height="110" border="0" align="center" >
                <tr>
                  <td width="827" height="24"><table width="227" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="105"><span class="Estilo10">TIPO CUENTA :</span></td>
                        <td width="122"><span class="Estilo10">
                          <input name="txttipo_cuenta" type="text" class="Estilo5" id="txttipo_cuenta"  onFocus="encender(this)" onBlur="apagar(this)" size="13" maxlength="12">
                        </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="830" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="188"><span class="Estilo10">DESCRIPCI&Oacute;N TIPO CUENTA : </span></td>
                      <td width="642"><span class="Estilo10">
                        <input name="txtdescripcion_tipo" type="text" class="Estilo5" id="txtced_rif22"  onFocus="encender(this)" onBlur="apagar(this)" size="118" maxlength="117">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="830" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="106" height="22"><span class="Estilo10">CONCILIABLE :</span></td>
                      <td width="724"><div align="left"><span class="Estilo10">
                          <input name="txtconciliable" type="text" class="Estilo5" id="txtced_rif4"  onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="9">
                      </span></div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
            </form>
            <table width="812">
              <tr>
                <td width="664">&nbsp;</td>
                <td width="88"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
                <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
              </tr>
            </table>
      </div>
    </td>
</tr>
</table>
</body>
</html>
