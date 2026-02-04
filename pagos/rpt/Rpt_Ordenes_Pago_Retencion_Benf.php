<?php include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$cedula_d="";$cedula_h="";$tipo_retencion_d="";$tipo_retencion_h="";$numero_orden_d="";$numero_orden_h="";$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$status_orden="";$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGO (Reporte Relacion Beneficiarios/Retencion)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref;var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref;var mfec;
  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechah.value=mfec;}
return true;}

function Llama_Rpt_Ordenes_Pago_Retencion_Be(murl){var url;var r;var st;
  if(document.form1.opestatus[0].checked==true){st="T";}
  if(document.form1.opestatus[1].checked==true){st="I";}
  if(document.form1.opestatus[2].checked==true){st="S";}
  if(document.form1.opestatus[3].checked==true){st="N";}
  if(document.form1.opestatus[4].checked==true){st="L";}

  r=confirm("Desea Generar el Reporte Relacion Beneficiarios/Retencion?");
  if (r==true)
  {url=murl+"?cedula_d="+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value+"&tipo_retencion_d="+document.form1.txttipo_reten_d.value+"&tipo_retencion_h="+document.form1.txttipo_reten_h.value+"&numero_orden_d="+document.form1.txtnro_orden_d.value+"&numero_orden_h="+document.form1.txtnro_orden_h.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+
    "&status_orden="+st;
    window.open(url,"Reporte Relacion Beneficiarios/Retencion")
  }
}

function Llama_Menu_Rpt(murl){
var url;
   url="../"+murl;
   LlamarURL(url);
}

</script>
</head>
<?php 
$sql="SELECT MAX(Ced_Rif) As Max_Ced_Rif, MIN(Ced_Rif) As Min_Ced_Rif FROM PRE099";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $cedula_d=$registro["min_ced_rif"];  $cedula_h=$registro["max_ced_rif"];}

$sql="SELECT MAX(Tipo_Retencion) As Max_Tipo_Retencion, MIN(Tipo_Retencion) As Min_Tipo_Retencion FROM RETENCIONES";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $tipo_retencion_d=$registro["min_tipo_retencion"];  $tipo_retencion_h=$registro["max_tipo_retencion"];}

$sql="SELECT MAX(nro_orden) As Max_Nro_Orden, MIN(nro_orden) As Min_Nro_Orden FROM ORD_PAGO";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$numero_orden_d=$registro["min_nro_orden"]; $numero_orden_h=$registro["max_nro_orden"];}


?>



<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="45"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE RELACION BENEFICIARIOS/RETENCION</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="521" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="515">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:490px; z-index:1; top: 73px; left: 23px;">
        <form name="form1" method="get">
           <table width="950" height="487" border="0">
    <tr>
      <td width="958" height="483" align="center" valign="top"><table width="783" height="352" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo16"><table width="757" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="197">&nbsp;</td>
              <td width="237"><span class="Estilo13">DESDE</span></td>
              <td width="323"><span class="Estilo13">HASTA</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo16"><table width="776" border="0">
            <tr>
              <td width="182" height="26">
                <div align="left">CEDULA/RIF: </div></td>
              <td width="99"><span class="Estilo5">
                <input name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_d?>" size="15" maxlength="15">
              </span></td>
              <td width="118"><span class="Estilo5">
                <input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Cat_Beneficiariosd.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
              <td width="102"><span class="Estilo5">
                 <input name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_h?>" size="15" maxlength="15">
              </span></td>
              <td width="253"><span class="Estilo5">
                <input name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Cat_Beneficiariosh.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo16"><table width="776" border="0">
            <tr>
              <td width="182" height="26">
                <div align="left">TIPO RETENCION: </div></td>
              <td width="99"><span class="Estilo5">
                <input name="txttipo_reten_d" type="text" id="txttipo_reten_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_retencion_d?>" size="15" maxlength="15">
              </span></td>
              <td width="118"><span class="Estilo5">
                <input name="Catalogo3" type="button" id="Catalogo3" title="Abrir Catalogo de Tipos de Retenciones" onClick="VentanaCentrada('../Cat_Tipo_Retencionesd.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
              <td width="102"><span class="Estilo5">
                <input name="txttipo_reten_h" type="text" id="txttipo_reten_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_retencion_h?>" size="15" maxlength="15">
              </span></td>
              <td width="253"><span class="Estilo5">
                <input name="Catalogo4" type="button" id="Catalogo4" title="Abrir Catalogo de Tipos de Retenciones" onClick="VentanaCentrada('../Cat_Tipo_Retencionesh.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo16"><table width="776" border="0">
            <tr>
              <td width="184" height="26">
                <div align="left">NUMERO DE ORDEN: </div></td>
              <td width="225"><span class="Estilo5">
                <input name="txtnro_orden_d" type="text" id="txtnro_orden_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $numero_orden_d?>" size="15" maxlength="15">
              </span></td>
              <td width="353"><span class="Estilo5">
                <input name="txtnro_orden_h" type="text" id="txtnro_orden_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $numero_orden_h?>" size="15" maxlength="15">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3"><table width="771" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="186" align="center"><div align="left">FECHA ORDEN : </div></td>
              <td width="233" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="352" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="3"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="390">ESTATUS DE LAS ORDENES:</td>
              <td width="374">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td width="42" height="18">&nbsp;</td>
          <td width="460"><table width="320" height="75" border="1">
            <tr>
              <td width="150" height="69" valign="top"><label>
               <input name="opestatus" type="radio" value="T" checked>
        TODAS</label>
                  <p>
                    <input name="opestatus" type="radio" value="I">
        CANCELADAS  </p>
                  <p>
                    <label>
                    <input name="opestatus" type="radio" value="S">
        ANULADAS</label>
                </p></td>
              <td width="154" valign="top"><p>
                  <input name="opestatus" type="radio" value="N">
        PENDIENTE</p>
                  <p>
                    <input name="opestatus" type="radio" value="L">
                    LIBERADAS                    </p></td>
            </tr>
          </table></td>
          <td width="281">&nbsp;</td>
        </tr>
        <tr>
          <td height="89" colspan="3"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Ordenes_Pago_Retencion_Be('Rpt_Ordenes_Pago_Retencion_Be.php');">
                      </div></td>
              <td>
                    <div align="center">
                      <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                      </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
        </form>
    </div>    </td>
</tr>
</table>
</body>
</html>

<?php  pg_close($conn);?>
