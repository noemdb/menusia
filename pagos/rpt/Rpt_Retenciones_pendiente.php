<?php include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$formato_presup="XX-XX-XX-XXX-XX-XX-XX"; $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];} $long_c=strlen($formato_presup); 
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="03-0000030"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?php }
$cedula_d="";$cedula_h="";$tipo_retencion_d="";$tipo_retencion_h="";$numero_orden_d="";$numero_orden_h="";$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$status_orden="";$vurl;
$codigo_presu_d="";$codigo_presu_h=""; $cod_fuente_d="00"; $cod_fuente_h="99";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGO (Reporte Retenciones Pendientes)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
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
function checkreferenciad(mform){var mref;
   mref=mform.txtnro_orden_d.value;   mref = Rellenarizq(mref,"0",8);  mform.txtnro_orden_d.value=mref;
return true;}
function checkreferenciah(mform){var mref;
   mref=mform.txtnro_orden_h.value;   mref = Rellenarizq(mref,"0",8);  mform.txtnro_orden_h.value=mref;
return true;}
function checktipod(mform){var mref;
   mref=mform.txttipo_reten_d.value;   mref = Rellenarizq(mref,"0",3);  mform.txttipo_reten_d.value=mref;
return true;}
function checktipoh(mform){var mref;
   mref=mform.txttipo_reten_h.value;   mref = Rellenarizq(mref,"0",3);  mform.txttipo_reten_h.value=mref;
return true;}
function Llama_Rpt_Retenciones_Pendientes(murl){var url;var r;var st="S";  
  if(document.form1.opprinccanc[0].checked==true){st="S";}
  if(document.form1.opprinccanc[1].checked==true){st="N";}
  r=confirm("Desea Generar el Reporte Retenciones Pendientes ?");
  if (r==true) {url=murl+"?tipo_retencion_d="+document.form1.txttipo_reten_d.value+"&tipo_retencion_h="+document.form1.txttipo_reten_h.value+"&numero_orden_d="+document.form1.txtnro_orden_d.value+"&numero_orden_h="+document.form1.txtnro_orden_h.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&codigo_presu_d="+document.form1.txtcod_presupd.value+"&codigo_presu_h="+document.form1.txtcod_presuph.value+"&cod_fuented="+document.form1.txtcod_fuented.value+"&cod_fuenteh="+document.form1.txtcod_fuenteh.value+"&principal_canc="+st+"&tipo_rpt="+document.form1.tipo_rpt.value;
    window.open(url,"Reporte Relacion Retenciones Pendientes")
  }
}
function Llama_Menu_Rpt(murl){var url;   url="../"+murl;   LlamarURL(url);}

</script>
</head>
<?php 
$sql="SELECT MAX(Ced_Rif) As Max_Ced_Rif, MIN(Ced_Rif) As Min_Ced_Rif FROM PRE099";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $cedula_d=$registro["min_ced_rif"];  $cedula_h=$registro["max_ced_rif"];}
$sql="SELECT MAX(Tipo_Retencion) As Max_Tipo_Retencion, MIN(Tipo_Retencion) As Min_Tipo_Retencion FROM RETENCIONES";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $tipo_retencion_d=$registro["min_tipo_retencion"];  $tipo_retencion_h=$registro["max_tipo_retencion"];}
$sql="SELECT MAX(nro_orden) As Max_Nro_Orden, MIN(nro_orden) As Min_Nro_Orden FROM ORD_PAGO";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$numero_orden_d=$registro["min_nro_orden"]; $numero_orden_h=$registro["max_nro_orden"];}
$sql="Select max(cod_presup) As max_cod_presup, min(cod_presup) As min_cod_presup from pre001 where (length(Cod_Presup)=".$long_c.")"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $codigo_presu_d=$registro["min_cod_presup"];  $codigo_presu_h=$registro["max_cod_presup"];}
$sql="SELECT min(cod_fuente_financ) as min_fuente, max(cod_fuente_financ) as max_fuente  from pre095"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_fuente_d=$registro["min_fuente"];  $cod_fuente_h=$registro["max_fuente"];}
$codigo_presu_d=str_replace("X","?",$formato_presup); $codigo_presu_h=str_replace("X","?",$formato_presup);
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="45"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE RETENCIONES PENDIENTES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="470" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="450">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:490px; z-index:1; top: 63px; left: 23px;">
        <form name="form1" method="get">
           <table width="950" height="387" border="0">
    <tr>
      <td width="958" height="383" align="center" valign="top"><table width="783" height="352" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19" colspan="3" align="center"  >&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center"  ><table width="757" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="197">&nbsp;</td>
              <td width="237"><span class="Estilo13">DESDE</span></td>
              <td width="323"><span class="Estilo13">HASTA</span></td>
            </tr>
          </table></td>
        </tr>          
        <tr>
          <td height="19" colspan="3" align="center"  >&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center"  ><table width="776" border="0">
            <tr>
              <td width="182" height="26"><div align="left"><span class="Estilo5">TIPO RETENCION : </span></div></td>
              <td width="69"><span class="Estilo5"><input class="Estilo10" name="txttipo_reten_d" type="text" id="txttipo_reten_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_retencion_d?>" size="6" maxlength="3"  onchange="checktipod(this.form)" class="Estilo5"> </span></td>
              <td width="148"><span class="Estilo5"><input class="Estilo10" name="Catalogo3" type="button" id="Catalogo3" title="Abrir Catalogo de Tipos de Retenciones" onClick="VentanaCentrada('../Cat_Tipo_Retencionesd.php?criterio=','SIPAP','','750','500','true')" value="...">  </span></td>
              <td width="69"><span class="Estilo5"> <input class="Estilo10" name="txttipo_reten_h" type="text" id="txttipo_reten_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_retencion_h?>" size="6" maxlength="3" onchange="checktipoh(this.form)" class="Estilo5"> </span></td>
              <td width="296"><span class="Estilo5"><input class="Estilo10" name="Catalogo4" type="button" id="Catalogo4" title="Abrir Catalogo de Tipos de Retenciones" onClick="VentanaCentrada('../Cat_Tipo_Retencionesh.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center"  >&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center"  ><table width="776" border="0">
            <tr>
              <td width="184" height="26"><div align="left"><span class="Estilo5">NUMERO DE ORDEN : </span></div></td>
	          <td width="225"><span class="Estilo5"><input class="Estilo10" name="txtnro_orden_d" type="text" id="txtnro_orden_d" onFocus="encender(this)" onBlur="apagar(this)" onchange="checkreferenciad(this.form)" value="<?php echo $numero_orden_d?>" size="12" maxlength="8" class="Estilo5"></span></td>
              <td width="353"><span class="Estilo5"><input class="Estilo10" name="txtnro_orden_h" type="text" id="txtnro_orden_h" onFocus="encender(this)" onBlur="apagar(this)" onchange="checkreferenciah(this.form)" value="<?php echo $numero_orden_h?>" size="12" maxlength="8" class="Estilo5"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3"><table width="771" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="186" align="center"><div align="left"><span class="Estilo5">FECHA ORDEN : </span></div></td>
              <td width="233" align="center"><div align="left"><span class="Estilo5">
                  <input class="Estilo10" name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)" class="Estilo5">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="352" align="center"><div align="left"><span class="Estilo5">
                  <input class="Estilo10" name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)" class="Estilo5">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="30" colspan="3"><table width="771" border="0">
            <tr>
              <td width="186" height="26"><span class="Estilo5">CODIGOS PRESUPUESTARIO: </span></td>
              <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtcod_presupd" type="text" id="txtcod_presupd" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $codigo_presu_d?>" size="36" maxlength="30" class="Estilo5"></span></td>
              <td width="92"><span class="Estilo5"><input class="Estilo10" name="cat_cod_pred" type="button" id="cat_cod_pred" title="Abrir Catalogo Codigo Presupuestario" onClick="VentanaCentrada('../Cat_codigos_presupd.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
              <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtcod_presuph" type="text" id="txtcod_presuph" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $codigo_presu_h?>" size="36" maxlength="30" class="Estilo5"></span></td>
              <td width="93"><span class="Estilo5"><input class="Estilo10" name="cat_cod_preh" type="button" id="cat_cod_preh" title="Abrir Catalogo Codigo Presupuestario" onClick="VentanaCentrada('../Cat_codigos_presuph.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
            </tr>
          </table></td>
        </tr>
		<tr>
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
		<tr>
          <td height="30" colspan="3"><table width="771" border="0">
            <tr>
              <td width="186" height="26"><span class="Estilo5">CODIGOS FUENTE: </span></td>
			  <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuented" type="text" id="txtcod_fuented" value="<?php echo $cod_fuente_d?>" onFocus="encender(this)" onBlur="apagar(this)" maxlength="2" size="5" class="Estilo5"> </span></td>
              <td width="92"><span class="Estilo5"><input class="Estilo10" name="btfuente" type="button" id="btfuente" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('../../presupuesto/rpt/Cat_fuentesd.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
              <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuented" type="hidden" id="txtdes_fuented" ></span></td>
              <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuenteh" type="text" id="txtcod_fuenteh" value="<?php echo $cod_fuente_h?>" onFocus="encender(this)" onBlur="apagar(this)" maxlength="2"  size="5" class="Estilo5"> </span></td>
              <td width="92"><span class="Estilo5"><input class="Estilo10" name="btfuente2" type="button" id="btfuente2" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('../../presupuesto/rpt/Cat_fuentesh.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
              <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuenteh" type="hidden" id="txtdes_fuenteh" ></span></td>
             </tr>
          </table></td>
        </tr>
		<tr>
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="3"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="351"><span class="Estilo5">IMPRIMIR SOLO ORDENES CON PRINCIPAL CANCELADA:</span></td>
              <td width="420"><table width="112" height="30" border="1">
                <tr>
                  <td width="113" valign="top"><label>
                    <input class="Estilo10" name="opprinccanc" type="radio" value="S"><span class="Estilo5">SI </span></label>  <label>
                      <input class="Estilo10" name="opprinccanc" type="radio" value="N" checked><span class="Estilo5">NO </span></label></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td height="18" colspan="3">&nbsp;</td>  </tr> 
		<tr>
		  <td height="19"><table width="771" border="0">
			  <tr>
				<td width="186" class="Estilo5"> TIPO DE REPORTE :</td>
				<td width="585"><span class="Estilo5"> <select class="Estilo10" name="tipo_rpt" id="tipo_rpt"><option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select></span></td>
			  </tr>
		  </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>

        <tr>
          <td width="42" height="18">&nbsp;</td>
        </tr>
        <tr>
          <td height="59" colspan="3"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"> <input  name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Retenciones_Pendientes('Rpt_Retenc_pendientes.php');"> </div></td>
              <td><div align="center">  <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">  </div></td></tr>
          </table></td>
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
