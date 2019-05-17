<?include ("../class/ventana.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (INCLUIR POLIZA DE SEGURO BIENES MUBLES )</title>
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
    if(f.txtcod_bien_mue.value==""){alert("El Codigo del Bien Inmueble no puede estar Vacio");return false;}else{f.txtcod_bien_mue.value=f.txtcod_bien_mue.value.toUpperCase();}
    if(f.txtnumero_poliza.value==""){alert("El Numero de Poliza no puede estar Vacio"); return false; } else{f.txtnumero_poliza.value=f.txtnumero_poliza.value.toUpperCase();}
    if(f.txtced_rif_proveedor.value==""){alert("La Cedula no puede estar Vacio");return false;}else{f.txtced_rif_proveedor.value=f.txtced_rif_proveedor.value.toUpperCase();}
    if(f.txtfecha_poliza.value==""){alert("La Fecha no puede estar Vacio"); return false; } else{f.txtfecha_poliza.value=f.txtfecha_poliza.value.toUpperCase();}
    if(f.txtfecha_desde.value==""){alert("La Fecha no puede estar Vacio"); return false; } else{f.txtfecha_desde.value=f.txtfecha_desde.value.toUpperCase();}
    if(f.txtfecha_hasta.value==""){alert("La Fecha no puede estar Vacio"); return false; } else{f.txtfecha_hasta.value=f.txtfecha_hasta.value.toUpperCase();}
    if(f.txtmonto_poliza.value==""){alert("El Monto de Poliza no puede estar Vacio"); return false; } else{f.txtmonto_poliza.value=f.txtmonto_poliza.value.toUpperCase();}
    if(f.txttasa_cobertura.value==""){alert("La Tasa de Poliza no puede estar Vacio"); return false; } else{f.txttasa_cobertura.value=f.txttasa_cobertura.value.toUpperCase();}
    if(f.txtmonto_cobertura.value==""){alert("El Monto de Poliza no puede estar Vacio"); return false; } else{f.txtmonto_cobertura.value=f.txtmonto_cobertura.value.toUpperCase();}
    if(f.txtobservacion.value==""){alert("La Observacion no puede estar Vacio"); return false; } else{f.txtobservacion.value=f.txtobservacion.value.toUpperCase();}
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
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR POLIZA DE SEGURO BIENES MUBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="446" border="1" id="tablacuerpo">
  <td ><tr>
    <td width="92" height="436"><table width="92" height="446" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_bienes_muebles_pro_poli_segu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_bienes_muebles_pro_poli_segu.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Polizas De Seguros </A></td>
      </tr>
  <td height="377">&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:274px; z-index:1; top: 78px; left: 119px;">
            <form name="form1" method="post" action="Insert_bienes_muebles_pro_poli_segu.php" onSubmit="return revisar()">
        <table width="828" border="0" align="center" >
          <tr>
            <td><table width="962">
              <tr>
                <td width="111" scope="col"><span class="Estilo5">C&Oacute;DIGO DE L BIEN MUEBLES :</span></td>
                <td width="839" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtcod_bien_mue" type="text" id="txtcod_bien_mue" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <strong><strong>
                     <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo de Bienes Inmuebles" onClick="VentanaCentrada('Cat_bienes_mueblesd.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="103" scope="col"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                <td width="847" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtdenominacion" type="text" id="txtdenominacion" size="85" maxlength="100"  readonly class="Estilo5">
                </strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="52" scope="col"><div align="left"><span class="Estilo5">MARCA :</span></div></td>
                <td width="210" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo5">
                    <input name="txtmarca" type="text" id="txtmarca" size="30" maxlength="30"   readonly>
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="61" scope="col"><div align="left"><span class="Estilo5">MODELO :</span></div></td>
                <td width="620" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtmodelo" type="text" id="txtmodelo" size="30" maxlength="30"   readonly class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="55" scope="col"><div align="left"><span class="Estilo5">COLOR :</span></div></td>
                <td width="208" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo5">
                    <input name="txtcolor" type="text" id="txtcolor" size="30" maxlength="30"   readonly class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="79" scope="col"><div align="left"><span class="Estilo5">MATRICULA :</span></div></td>
                <td width="601" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtmatricula" type="text" id="txtmatricula" size="30" maxlength="30"   readonly class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="52" scope="col"><div align="left"><span class="Estilo5">SERIAL :</span></div></td>
                <td width="213" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtserial1" type="text" id="txtserial1" size="30" maxlength="30"   readonly class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="64" scope="col"><div align="left"><span class="Estilo5">SERIAL 2 :</span></div></td>
                <td width="614" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtserial2" type="text" id="txtserial2" size="30" maxlength="30"  readonly class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="145" scope="col"><span class="Estilo5">C&Eacute;DULA/RIF COMPA&Ntilde;IA :</span></td>
                <td width="805" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtced_rif_proveedor" type="text" id="txtced_rif_proveedor" size="15" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_proveedoresd.php?criterio=','SIA','','750','500','true')" value="...">
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
                <td width="125" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO DE P&Oacute;LIZA :</span></div></td>
                <td width="92" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtnumero_poliza" type="text" id="txtnumero_poliza" size="20" maxlength="20"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="146" scope="col"><div align="left"><span class="Estilo5">FECHA EMISI&Oacute;N P&Oacute;LIZA :</span></div></td>
                <td width="580" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtfecha_poliza" type="text" id="txtfecha_poliza" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
        </table>
        <table width="828" align="center">
          <tr>
            <td><table width="963">
              <tr>
                <td width="138" scope="col"><div align="left"><span class="Estilo5">PERIODO COBERTURA DE P&Oacute;LIZA DESDE :</span></div></td>
                <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtfecha_desde" type="text" id="txtcant_vence_fact225332223227" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="50" scope="col"><div align="left"><span class="Estilo5">HASTA :</span></div></td>
                <td width="635" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="134" scope="col"><div align="left"><span class="Estilo5">MONTO DE LA P&Oacute;LIZA :</span></div></td>
                <td width="147" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtmonto_poliza" type="text" id="txtmonto_poliza" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="82" scope="col"><div align="left"><span class="Estilo5">TASA DE COBERTURA :</span></div></td>
                <td width="85" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txttasa_cobertura" type="text" id="txttasa_cobertura" size="10" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="150" scope="col"><span class="Estilo5">MONTO DEL COBERTURA :</span></td>
                <td width="337" scope="col"><span class="Estilo5">
                  <input name="txtmonto_cobertura" type="text" id="txtmonto_cobertura" size="25" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="95" scope="col"><div align="left"><span class="Estilo5">OBSERVACI&Oacute;N :</span></div></td>
                <td width="855" scope="col"><div align="left">
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
