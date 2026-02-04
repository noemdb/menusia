<?php include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
 $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
 $referencia_d=""; $referencia_h="zzzzzzzz";  $tipo_asiento_d="";  $tipo_asiento_h="zzz"; $cedula_d="";$cedula_h="zzzzzzzzzzzz";
 $cod_cuenta_d=""; $cod_cuenta_h=""; $cta_unica=""; $vstatus="T";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD (Reporte Movimientos de Cuentas)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref; var mfec; mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7);mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref; var mfec; mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7);mform.txtFechah.value=mfec;}
return true;}
function Llama_Rpt_Asientos_D(murl){var url; var r; var st;
  if(document.form1.opcomprob[0].checked==true){st="A";}
  if(document.form1.opcomprob[1].checked==true){st="D";}
  if(document.form1.opcomprob[2].checked==true){st="T";}
  r=confirm("Desea Generar el Reporte Movimientos de Cuenta ?");
  if (r==true) {url=murl+"?fecha_d="+document.form1.txtFechad.value+"&referencia_d="+document.form1.txtReferenciad.value+"&ced_rif_d="+document.form1.txtcedula_d.value+"&cod_cuenta_d="+document.form1.txtCodigo_Cuenta_D.value+"&fecha_h="+document.form1.txtFechah.value+"&referencia_h="+document.form1.txtReferenciah.value+"&ced_rif_h="+document.form1.txtcedula_h.value+"&cod_cuenta_h="+document.form1.txtCodigo_Cuenta_H.value+"&vstatus="+st;
  window.open(url,"Reporte Asientos Diarios")
  }
}
function Llama_Menu_Rpt(murl){var url;    url="../"+murl;  LlamarURL(url);}
</script>
</head>
<?php 
$sql="SELECT MAX(Referencia) As Max_Referencia, MIN(Referencia) As Min_Referencia,MAX(Tipo_Asiento) As Max_Tipo,MIN(Tipo_Asiento) As Min_Tipo FROM CON002";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$referencia_d=$registro["min_referencia"];  $referencia_h=$registro["max_referencia"]; $tipo_asiento_d=$registro["min_tipo"]; $tipo_asiento_h=$registro["max_tipo"];}
$sql="SELECT MAX(ced_rif) As Max_Ced_Rif, MIN(ced_rif) As Min_Ced_Rif FROM PRE099";$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$cedula_d=$registro["min_ced_rif"];$cedula_h=$registro["max_ced_rif"];}
$sql="SELECT MAX(codigo_cuenta) As max_cod_cuenta, MIN(codigo_cuenta) As min_cod_cuenta FROM CON001 where cargable='C'";$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$cod_cuenta_d=$registro["min_cod_cuenta"];$cod_cuenta_h=$registro["max_cod_cuenta"];}

?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE MOVIMIENTOS DE CUENTAS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="980" height="396" border="1" id="tablacuerpo">
  <tr>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:392px; z-index:1; top: 68px; left: 18px;">
        <form method="get" name="form1" id="form1">
           <table width="950" height="387" border="0">
    <tr>
      <td width="958" align="center" valign="top"><table width="783" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><table width="590" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="170" align="center"><div align="left"><span class="Estilo5">FECHA DESDE: </span></div></td>
                <td width="160" align="center">
                  <div align="left"><span class="Estilo5">
                    <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                    <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
                <td width="70" align="center"><div align="left"><span class="Estilo5">HASTA:</span></div></td>
                <td width="190" align="center">
                  <div align="left"><span class="Estilo5">
                    <input name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                    <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2">
            <table width="590" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="170" align="center"><div align="left"><span class="Estilo5">REFERENCIA DESDE: </span></div></td>
                <td width="160" align="center">
                  <div align="left"><span class="Estilo5">
                    <input name="txtReferenciad" type="text" id="txtReferenciad" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $referencia_d?>" size="12" maxlength="8">
                </span></div></td>
                <td width="70" align="center"><div align="left"><span class="Estilo5">HASTA:</span></div></td>
                <td width="190" align="center">
                  <div align="left"><span class="Estilo5">
                    <input name="txtReferenciah" type="text" id="txtReferenciah" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $referencia_h?>" size="12" maxlength="8">
                </span></div></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2">
            <table width="590" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="170" align="left"><span class="Estilo5">CEDULA/RIF DESDE : </span></td>
                <td width="160" align="left"><span class="Estilo5">
                  <input name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_d?>" size="15" maxlength="12">
                  <input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo Beneficiario" onClick="VentanaCentrada('../Cat_Beneficiariosd.php?criterio=','SIPAP','','650','500','true')" value="...">
                </span></td>
                <td width="70" align="left"><span class="Estilo5">HASTA:</span></td>
                <td width="190" align="left"><span class="Estilo5">
                  <input name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_h?>" size="15" maxlength="12">
                  <input name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo Beneficiario" onClick="VentanaCentrada('../Cat_Beneficiariosh.php?criterio=','SIPAP','','650','500','true')" value="...">
                </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><table width="590" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="170"><div align="left"><span class="Estilo5">CODIGO DE CUENTA DESDE : </span></div></td>
                <td width="200"><span class="Estilo5">
                  <input name="txtCodigo_Cuenta_D" type="text" id="txtCodigo_Cuenta_D" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_cuenta_d?>" size="32" maxlength="32">
                </span></td>
                <td width="190"><span class="Estilo5">
                  <input name="Catalogo_ctad" type="button" id="Catalogo_ctad" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIPAP','','750','500','true')" value="...">
                </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><table width="590" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="170"><div align="left"><span class="Estilo5">CODIGO DE CUENTA HASTA : </span></div></td>
                <td width="200"><span class="Estilo5">
                  <input name="txtCodigo_Cuenta_H" type="text" id="txtCodigo_Cuenta_H" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_cuenta_h?>" size="32" maxlength="32">
                </span></td>
                <td width="190"><span class="Estilo5">
                  <input name="Catalogo_ctah" type="button" id="Catalogo_ctah" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesh.php?criterio=','SIPAP','','750','500','true')" value="...">
                </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2">
            <table width="590" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="170" align="left"><span class="Estilo5">COMPROBANTES : </span></td>
                <td width="338" align="left"><table width="317" height="32" border="1">
                    <tr>
                      <td width="288" height="30" valign="top"><label>
                        <input type="radio" name="opcomprob" value="A">
                        <span class="Estilo5"> Actuales</span></label>
                          <input type="radio" name="opcomprob" value="D">
                          <label><span class="Estilo5">Diferidos</span></label>
                          <input name="opcomprob" type="radio" value="T" checked>
                          <label><span class="Estilo5">Todos</span></label>
                      </td>
                    </tr>
                  </table>
                    <span class="Estilo5"> </span></td>
                <td width="47" align="left">&nbsp;</td>
                <td width="35" align="left"><span class="Estilo5"> </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
		 
          <td width="289"><input name="txtdesccedrifbenefh" type="hidden" id="txtdesccedrifbenefh" ></td>
          <td width="494"><input name="txtdesccedrifbenefd" type="hidden" id="txtdesccedrifbenefd"  ></td>
        </tr>
		<tr>
		  <td height="18" colspan="2">&nbsp;</td>
		  </tr>
		<tr>
          <td height="18" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr align="center" valign="middle">
                <td>
                  <div align="center">
                    <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Asientos_D('Rpt_Mov_ctas.php');">
                </div></td>
                <td>
                  <div align="center">
                    <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                </div></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="2">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>
