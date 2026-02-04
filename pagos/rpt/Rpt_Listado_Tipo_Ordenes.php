<?php include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc"); 
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); 
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="03-0000055"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?php }
$nro_orden_d="";$nro_orden_h="";$documento_causado_d="";$documento_causado_h="";$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$cedula_d="";$cedula_h="";$tipo_orden_d="";$tipo_orden_h="";$status_orden="";$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Reporte Listado Tipo e Ordenes)</title>
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
function Llama_Rpt_Listado_Tipo_Orden(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Listado Tipos de Ordenes?");
  if (r==true) {url=murl+"?&tipo_orden_d="+document.form1.txttipo_ordend.value+"&tipo_orden_h="+document.form1.txttipo_ordenh.value+"&tipo_rpt="+document.form1.tipo_rpt.value;
    window.open(url,"Reporte Listado Tipos de Ordenes")
  }
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

</head>
<?php $sql="SELECT MAX(nro_orden) As Max_Nro_Orden, MIN(nro_orden) As Min_Nro_Orden FROM ORD_PAGO";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$nro_orden_d=$registro["min_nro_orden"];$nro_orden_h=$registro["max_nro_orden"];}
$sql="SELECT MAX(Ced_Rif) As Max_Ced_Rif, MIN(Ced_Rif) As Min_Ced_Rif FROM PRE099";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cedula_d=$registro["min_ced_rif"];$cedula_h=$registro["max_ced_rif"];}
$sql="SELECT MAX(Tipo_Orden) As Max_Tipo_Orden, MIN(Tipo_Orden) As Min_Tipo_Orden FROM TIPOS_ORDEN";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$tipo_orden_d=$registro["min_tipo_orden"];$tipo_orden_h=$registro["max_tipo_orden"];}
$sql="SELECT MAX(tipo_causado) As Max_tipo_causado, MIN(tipo_causado) As Min_tipo_causado FROM pre003 where tipo_causado<>'0000'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$documento_causado_d=$registro["min_tipo_causado"];$documento_causado_h=$registro["max_tipo_causado"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="45"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE LISTADO TIPO DE ORDENES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="230" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="215">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:220px; z-index:1; top: 73px; left: 23px;">
        <form name="form1" method="get">
           <table width="950" height="212" border="0">
    <tr>
      <td width="958" height="212" align="center" valign="top"><table width="783" height="210" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo5">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo5"><table width="757" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="230">&nbsp;</td>
              <td width="248"><span class="Estilo13">DESDE</span></td>
              <td width="279"><span class="Estilo13">HASTA</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="21" colspan="3" align="center" class="Estilo5">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="3"><table width="782" border="0">
                  <tr>
              <td width="228" class="Estilo5" height="26"><div align="left">TIPO DE ORDEN:</div></td>
              <td width="97"><span class="Estilo5"><input class="Estilo10" name="txttipo_ordend" type="text" id="txttipo_ordend" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_orden_d?>" size="6" maxlength="4">
              </span></td>
              <td width="126"><span class="Estilo5"><input class="Estilo10" name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo de Tipo Orden" onClick="VentanaCentrada('../Cat_tipo_ordend.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
              <td width="76"><span class="Estilo5"><input class="Estilo10" name="txttipo_ordenh" type="text" id="txttipo_ordenh" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_orden_h?>" size="6" maxlength="4">
              </span></td>
              <td width="233"><span class="Estilo5">
                <input class="Estilo10" name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo de Tipo Orden" onClick="VentanaCentrada('../Cat_tipo_ordenh.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td height="21" colspan="3">&nbsp;</td>  
        </tr> 
		<tr>
		  <td height="19"><table width="782" border="0">
			  <tr>
				<td width="228" class="Estilo5"> TIPO DE REPORTE :</td>
				<td width="554"><span class="Estilo5"> <select class="Estilo10" name="tipo_rpt" id="tipo_rpt">
				  <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select></span></td>
			  </tr>
		  </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script> 
	<tr>
          <td height="89" colspan="3"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Listado_Tipo_Orden('Rpt_Listado_Tipo_Orden.php');">
                      </div></td>
              <td>
                    <div align="center">
                      <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                      </div></td></tr>
          </table></td>
        </tr>
        <tr> <td height="18" colspan="3">&nbsp;</td>  </tr>  
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
