<?php include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="03-0000054"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?php }
$tipo_retencion_d="";$tipo_retencion_h="";$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGO (Reporte Listado Tipos Retencion)</title>
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
function Llama_Rpt_Listado_Tipos_Reten(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Listado Tipos de Retencion?");
  if (r==true) {url=murl+"?tipo_retencion_d="+document.form1.txttipo_reten_d.value+"&tipo_retencion_h="+document.form1.txttipo_reten_h.value+"&tipo_rpt="+document.form1.tipo_rpt.value;
    window.open(url,"Reporte Listado Tipos de Retencion")
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
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="45"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE LISTADO TIPOS DE RETENCION</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="230" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="205">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:490px; z-index:1; top: 63px; left: 23px;">
        <form name="form1" method="get">
           <table width="950" height="210" border="0">
    <tr>
      <td width="958" height="200" align="center" valign="top"><table width="783" height="200" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19" colspan="3" align="center"  >&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center"  ><table width="757" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="182">&nbsp;</td>
              <td width="237"><span class="Estilo13">DESDE</span></td>
              <td width="338"><span class="Estilo13">HASTA</span></td>
            </tr>
          </table></td>
        </tr>          
        <tr>
          <td height="21" colspan="3" align="center"  >&nbsp;</td>
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
          <td height="21" colspan="3" align="center"  >&nbsp;</td>
        </tr>
		<tr>
		  <td height="19"><table width="771" border="0">
			  <tr>
				<td width="186" class="Estilo5"> TIPO DE REPORTE :</td>
				<td width="585"><span class="Estilo5"> <select class="Estilo10" name="tipo_rpt" id="tipo_rpt"> <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select> </span></td>
			  </tr>
		  </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>
        <tr>
          <td width="42" height="21">&nbsp;</td>
        </tr>
        <tr>
          <td height="59" colspan="3"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Listado_Tipos_Reten('Rpt_Listado_Tipos_Reten.php');"> </div></td>
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
