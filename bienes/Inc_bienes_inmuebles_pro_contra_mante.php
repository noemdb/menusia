<?php include ("../class/ventana.php");?>
<?php include ("../class/fun_fechas.php");
  $fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Incluir Bienes Inmuebles)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
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
<script language="JavaScript" type="text/JavaScript">
function revisar(){
var f=document.form1;
    if(f.txtcod_bien_inm.value==""){alert("El Codigo del Inmueble no puede estar Vacio");return false;}else{f.txtcod_bien_inm.value=f.txtcod_bien_inm.value.toUpperCase();}
    if(f.txtdireccion.value==""){alert("La Direccion no puede estar Vacia"); return false; } else{f.txtdireccion.value=f.txtdireccion.value.toUpperCase();}
    if(f.txtced_rif_proveedor.value==""){alert("La Cedula no puede estar Vacia"); return false; } else{f.txtced_rif_proveedor.value=f.txtced_rif_proveedor.value.toUpperCase();}
    if(f.txtnumero_contrato.value==""){alert("El Numero Contrato no puede estar Vacio");return false;}else{f.txtnumero_contrato.value=f.txtnumero_contrato.value.toUpperCase();}
    if(f.txtfecha_contrato.value==""){alert("La Fecha del Contrato no puede estar Vacio");return false;}else{f.txtfecha_contrato.value=f.txtfecha_contrato.value.toUpperCase();}
    if(f.txtfecha_desde.value==""){alert("La Fecha desde no puede estar Vacia");return false;}else{f.txtfecha_desde.value=f.txtfecha_desde.value.toUpperCase();}
    if(f.txtfecha_hasta.value==""){alert("La Fecha hasta no puede estar Vacia");return false;}else{f.txtfecha_hasta.value=f.txtfecha_hasta.value.toUpperCase();}
    if(f.txtmonto_contrato.value==""){alert("El Monto del Contrato no puede estar Vacio");return false;}else{f.txtmonto_contrato.value=f.txtmonto_contrato.value.toUpperCase();}
    if(f.txtobservacion.value==""){alert("La Observacion no puede estar Vacia");return false;}else{f.txtobservacion.value=f.txtobservacion.value.toUpperCase();}
document.form1.submit;
return true;}
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
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR CONTRATOS DE MANTENIMIENTOS  BIENES INMUBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="280" border="1" id="tablacuerpo">
  <td ><tr>
    <td width="92" height="270"><table width="92" height="376" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_bienes_inmuebles_pro_contra_mante.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_bienes_inmuebles_pro_contra_mante.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="42"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Contarto De Mantenimiento </A></td>
      </tr>
  <td height="350">&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:274px; z-index:1; top: 77px; left: 122px;">
            <form name="form1" method="post" action="Insert_bienes_inmuebles_pro_contra_mante.php" onSubmit="return revisar()">
        <table width="828" border="0" align="center" >
          <tr>
            <td><table width="962">
              <tr>
                <td width="170" scope="col"><span class="Estilo5">C&Oacute;DIGO DE L BIEN INMUEBLES :</span></td>
                <td width="839" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtcod_bien_inm" type="text" id="txtcod_bien_inm" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <strong><strong>
                     <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo de Bienes Inmuebles" onClick="VentanaCentrada('Cat_bienes_inmueblesd.php?criterio=','SIPAP','','750','500','true')" value="...">
                </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="170" scope="col"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                <td width="847" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtdenominacion" type="text" id="txtdenominacion" size="70" maxlength="100"  readonly class="Estilo5">
                    <strong><strong> </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="180" scope="col"><div align="left"><span class="Estilo5">DIRECCI&Oacute;N :</span></div></td>
                <td width="869" scope="col"><div align="left">
                    <textarea name="txtdireccion" cols="70" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" id="txtdireccion"></textarea>
                </div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="160" scope="col"><span class="Estilo5">C&Eacute;DULA/RIF DEL PROVEEDOR DEL SERVICIO DE MANTENIMIENTO</span></td>
                <td width="805" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtced_rif_proveedor" type="text" id="txtced_rif_proveedor" size="15" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_proveedoresd.php?criterio=','SIPAP','','750','500','true')" value="...">
                </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="158" scope="col"><span class="Estilo5">NOMBRE DEL PROVEEDOR :</span></td>
                <td width="792" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtnombre_proveedor" type="text" id="txtnombre_proveedor" size="80" maxlength="100" readonly class="Estilo5">
                    <strong><strong> </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="170" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO CONTRATO :</span></div></td>
                <td width="90" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtnumero_contrato" type="text" id="txtnumero_contrato" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="115" scope="col"><div align="left"><span class="Estilo5">FECHA CONTRATO :</span></div></td>
                <td width="611" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtfecha_contrato" type="text" id="txtfecha_contrato" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" value="<?php echo $fecha_hoy?>">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="170" scope="col"><div align="left"><span class="Estilo5">PERIODO CONTRATO DESDE :</span></div></td>
                <td width="122" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtfecha_desde" type="text" id="txtfecha_desde" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" value="<?php echo $fecha_hoy?>">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="51" scope="col"><div align="left"><span class="Estilo5">HASTA :</span></div></td>
                <td width="119" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" value="<?php echo $fecha_hoy?>">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="145" scope="col"><span class="Estilo5">MONTO DEL CONTRATO :</span></td>
                <td width="379" scope="col"><span class="Estilo5">
                  <input name="txtmonto_contrato" type="text" id="txtmonto_contrato" size="25" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="180" scope="col"><div align="left"><span class="Estilo5">OBSERVACI&Oacute;N :</span></div></td>
                <td width="869" scope="col"><div align="left">
                    <textarea name="txtobservacion" cols="70" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" id="txtobservacion"></textarea>
                </div></td>
              </tr>
            </table></td>
          </tr>
        </table>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
            </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
