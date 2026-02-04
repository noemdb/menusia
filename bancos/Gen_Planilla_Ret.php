<?php include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Generar Planillas de Retenmci&oacute;n)</title>
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
        {alert("C�digo de Cuenta debe ser Seleccionada");}
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
.Estilo12 {font-size: 12px}
.Estilo10 {	font-size: 12px;
	font-weight: bold;
	color: #0000FF;
}
.Estilo14 {font-size: 10px; color: #FF0000; }
.Estilo17 {font-size: 10px; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">GENERAR PLANILLAS DE RETENCI&Oacute;N </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="386" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="380"><table width="92" height="376" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Gen_Planilla_Ret.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu
            href="Act_Gen_Planilla_Ret.php">Atras</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu_p.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="890">       <div id="Layer1" style="position:absolute; width:882px; height:340px; z-index:1; top: 69px; left: 114px;">
      <form name="form1" method="post">
        <table width="880" border="0" >
          <tr>
            <td width="850" height="32"><table width="859" >
                <tr>
                  <td width="102" height="24"><span class="Estilo5">C&Oacute;DIGO BANCO :</span></td>
                  <td width="59"><span class="Estilo5"> <span class="Estilo12">
                    <input name="txtTipo_Cuenta2" type="text" class="Estilo5" id="txtTipo_Cuenta"  onFocus="encender(this)" onBlur="apagar(this)" size="11" maxlength="10">
                  </span> </span></td>
                  <td width="46"><input name="btCat_Cont2" type="button" class="Estilo5" id="btCat_Cont2" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                  <td width="571"><span class="Estilo12"><span class="Estilo5">
                    <input name="txtDes_Cod_Banco" type="text" class="Estilo5" id="txtDes_Cod_Banco"  value="<?php echo $Des_Cod_Banco?>" size="109" maxlength="109" readonly>
                  </span></span></td>
                  <td width="44"><img src="../imagenes/b_info.png" width="11" height="11" onClick="javascript:alert('<?php echo $inf_usuario?>');"></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="777" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="136"><span class="Estilo5">TIPO DE MOVIMIENTO : </span></td>
                  <td width="181"><span class="Estilo5"> <span class="Estilo12">
                    <select name="select">
                      <option>CHQ</option>
                      <option>NDB</option>
                    </select>
                  </span> </span></td>
                  <td width="241"><span class="Estilo5">REFERENCIA MOVIMIENTO / Nro. CHEQUE :</span></td>
                  <td width="219"><span class="Estilo5"><span class="Estilo12">
                    <input name="txtCod_Contable2" type="text" class="Estilo5" id="txtCod_Contable"  onFocus="encender(this)" onBlur="apagar(this)" size="9" maxlength="9">
                  </span> </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="724" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="69"><span class="Estilo5">C&Eacute;D/RIF :</span></td>
                  <td width="92"><span class="Estilo5"> <span class="Estilo12">
                    <input name="txtTipo_Cuenta22" type="text" class="Estilo5" id="txtTipo_Cuenta2"  onFocus="encender(this)" onBlur="apagar(this)" size="11" maxlength="10">
                  </span></span></td>
                  <td width="201"><input name="btCat_Cont3" type="button" class="Estilo5" id="btCat_Cont3" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                  <td width="468"><span class="Estilo5"> <span class="Estilo12"> </span> </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="809" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
                <tr>
                  <td width="65"><span class="Estilo5">NOMBRE :</span></td>
                  <td width="765"><span class="Estilo5"> <span class="Estilo12">
                    <input name="txtTipo_Cuenta222" type="text" class="Estilo5" id="txtTipo_Cuenta222"  onFocus="encender(this)" onBlur="apagar(this)" size="139" maxlength="138">
                  </span> </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="813" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                <tr>
                  <td width="111"><span class="Estilo5">FECHA DE PAGO :</span></td>
                  <td width="170"><span class="Estilo5"> <span class="Estilo12">
                    <input name="txtFecha" type="text" class="Estilo5" id="txtFecha"  value="<?php echo $Fecha?>" size="10" maxlength="9" readonly>
                  </span> </span></td>
                  <td width="87"><span class="Estilo5">MONTO PAGO :</span></td>
                  <td width="150"><span class="Estilo5"> <span class="Estilo12">
                    <input name="txtMonto_Movimiento" type="text" class="Estilo5" id="txtcod_titulo35"  value="<?php echo $Monto_Movimiento?>" size="17" maxlength="16" readonly>
                  </span> </span></td>
                  <td width="100"><span class="Estilo5">FECHA EMISI&Oacute;N :</span></td>
                  <td width="195"><span class="Estilo5"><span class="Estilo12">
                    <input name="txtMonto_Movimiento2" type="text" class="Estilo5" id="txtMonto_Movimiento"  value="<?php echo $Monto_Movimiento?>" size="17" maxlength="16" readonly>
                  </span></span></td>
                </tr>
            </table></td>
          </tr>
        </table>
        <p>&nbsp;</p>
      </form>
      <table width="812">
        <tr>
          <td width="664">&nbsp;</td>
          <td width="88"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
          <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
        </tr>
      </table>
    </div>      <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
    </td>
</tr>
</table>
</body>
</html>
