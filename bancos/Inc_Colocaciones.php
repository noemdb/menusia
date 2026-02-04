<?php include ("../class/seguridad.inc");?>
<?php include ("../class/ventana.php");?>
<?php include ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy(); $fecha=$fecha_hoy;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Tipos de Cuentas)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type="text/css" rel=stylesheet>
<SCRIPT language="JavaScript" src="../class/sia.js"  type=text/javascript></SCRIPT>
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
<script language="JavaScript" type="text/JavaScript">
function apaga_referencia(mthis){
var mref;
   apagar(mthis); mref=document.form1.txtreferencia.value;  mref=Rellenarizq(mref,"0",8);  document.form1.txtreferencia.value=mref;
return true;}
function revisar(){
var f=document.form1;
  if(f.txtreferencia.value==""){alert("Referencia no puede estar Vacio");return false;}else{f.txtreferencia.value=f.txtreferencia.value.toUpperCase();}
  if(f.txtdescripcion.value==""){alert("Descripci�n no puede estar Vacia"); return false; } else{f.txtdescripcion.value=f.txtdescripcion.value.toUpperCase();}
  if(f.txtCodigo_Cuenta.value==""){alert("C�digo de Cuenta no puede estar Vacio");return false;}
  document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 10px}
.Estilo2 {color: #FFFFFF}
.Estilo6 {font-size: 16pt;  font-weight: bold;}
.Estilo9 {font-size: 8pt}
.Estilo10 {font-size: 12px}
-->
</style>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR COLOCACIONES BANCARIAS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="390" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="385"><table width="92" height="382" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Colocaciones.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_Colocaciones.php">Atras</a></td>
      </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:858px; height:290px; z-index:1; top: 70px; left: 115px;">
         <form name="form1" method="post" action="Insert_colocaciones.php" onSubmit="return revisar()">
          <table width="856" border="0" cellspacing="1" cellpadding="1">
                <tr>
                 <td width="855"><table width="854" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td width="180"><span class="Estilo5">REFERENCIA DE COLOCACI&Oacute;N :</span></td>
                      <td width="250"><span class="Estilo5"><input name="txtreferencia" type="text" id="txtreferencia"  size="10" maxlength="10" onFocus="encender(this)" onBlur="apaga_referencia(this)"> </span></td>
                      <td width="140"><span class="Estilo5">TIPO  DE INVERSI&Oacute;N :</span></td>
                      <td width="280"><span class="Estilo5"> <select name="txttipo_inv" size="1" id="txttipo_inv" onFocus="encender(this)" onBlur="apagar(this)">
                         <option>TEMPORALES</option> <option>FIDECOMISO</option> </select> </span></div></td>
                     </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td width="855"><table width="854" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td width="180"><span class="Estilo5">C&Oacute;DIGO CONTABLE :</span></td>
                      <td width="250"><span class="Estilo5"> <input name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta"  size="30" maxlength="30" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                      <td width="420"><input name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo C&oacute;digo de Cuentas"  onClick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td width="855"><table width="854" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td width="180"><span class="Estilo5">NOMBRE C&Oacute;DIGO CONTABLE :</span></td>
                      <td width="670"><span class="Estilo5"><input name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta"  size="100" maxlength="99" readonly >  </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td width="855"><table width="854" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td width="120"><span class="Estilo5">FECHA DE INICIO :</span></td>
                      <td width="180"><span class="Estilo5"><input name="txtfecha_inicio" type="text" id="txtfecha_inicio"  value="<?php echo $fecha?>" size="12" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                      <td width="100"><span class="Estilo5">PLAZO D&Iacute;AS :</span></td>
                      <td width="150"><span class="Estilo5"><input name="txtdias_inv" type="text" id="txtdias_inv"  value="0" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                      <td width="150"><span class="Estilo5">FECHA DE VENCIMIENTO :</span></td>
                      <td width="150"><span class="Estilo5"><input name="txtfecha_vencimiento" type="text" id="txtfecha_vencimiento"  value="<?php echo $fecha?>" size="12" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td width="855"><table width="854" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td width="80"><span class="Estilo5">TASA % :</span></td>
                      <td width="400"><span class="Estilo5"><input name="txttasa_inv" type="text" id="txttasa_inv"  value="0" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                      <td width="200"><span class="Estilo5">MONTO DE LA COLOCACI&Oacute;N  :</span></td>
                      <td width="170"><span class="Estilo5"><input name="txtmonto_inv"  align="right" type="text" id="txtmonto_inv"  value="0" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                 <td width="855"><table width="854" border="0" cellspacing="1" cellpadding="1">
                      <tr>
                        <td width="100"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                        <td width="750"><span class="Estilo5"><textarea name="txtdescripcion" cols="85" onFocus="encender(this)" onBlur="apagar(this)" id="txtdescripcion_banco"></textarea>
                        </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
          </table>
          <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>