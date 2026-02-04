<?php include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="03-0000150"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?php }
$cedula_d="";$cedula_h="";$tipo_planilla_d="01";$tipo_planilla_h="99";$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$tasa_d="0";$tasa_h="999.99";$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Reporte Listado Impuesto Enterado)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></scrip
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
function Llama_Rpt_List_Impuesto_Ente(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Listado de Impuestos Enterados?");
  if (r==true){
    url=murl+"?cedula_d="+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value+"&tipo_planilla_d="+document.form1.txttipo_planilla_ret_d.value+"&tipo_planilla_h="+document.form1.txttipo_planilla_ret_h.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&tasa_d="+document.form1.txttasa_d.value+"&tasa_h="+document.form1.txttasa_h.value+"&tipo_rep="+document.form1.tipo_rep.value;
    window.open(url,"Reporte Listado de Impuestos Enterados")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>
</head>
<?php 
$sql="SELECT MAX(Ced_Rif) As Max_Ced_Rif, MIN(Ced_Rif) As Min_Ced_Rif FROM PRE099";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cedula_d=$registro["min_ced_rif"];$cedula_h=$registro["max_ced_rif"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE LISTADO IMPUESTO ENTERADO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="368" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="362">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:337px; z-index:1; top: 75px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="328" border="0">
    <tr>
      <td width="958" height="324" align="center" valign="top"><table width="783" height="317" border="0" cellpadding="0" cellspacing="0">
       
        <tr>
		  <td height="19" ><table width="784" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="241">&nbsp;</td>
				<td width="198"><strong><span class="Estilo10">DESDE</span></strong></td>
				<td width="249"><strong><span class="Estilo10">HASTA</span></strong></td>
			  </tr>
		  </table></td>
		</tr>
		<tr>
          <td height="19" colspan="5" >&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="5" ><table width="784" border="0">
            <tr>
              <td width="241" height="26">
                <div align="left"><span class="Estilo5">CEDULA /RIF DESDE : </span></div></td>
              <td width="93"><span class="Estilo5"><input class="Estilo10" name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_d?>" size="15" maxlength="12"> </span></td>
              <td width="99"><span class="Estilo5"><input class="Estilo10" name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Beneficiariosd.php?criterio=','SIPAP','','750','500','true')" value="...">  </span></td>
              <td width="90"><span class="Estilo5"><input class="Estilo10" name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_h?>" size="15" maxlength="12">  </span></td>
              <td width="239"><span class="Estilo5"><input class="Estilo10" name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Beneficiariosh.php?criterio=','SIPAP','','750','500','true')" value="...">   </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="5" >&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="5" ><table width="776" border="0">
            <tr>
              <td width="224" height="26"> <div align="left"><span class="Estilo5">TIPO PLANILLA DESDE : </span></div></td>
              <td width="195"><span class="Estilo5"> <input class="Estilo10" name="txttipo_planilla_ret_d" type="text" id="txttipo_planilla_ret_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_planilla_d?>" size="5" maxlength="4">  </span> </td>
              <td width="10">&nbsp;</td>
              <td width="329"><span class="Estilo5"><input class="Estilo10" name="txttipo_planilla_ret_h" type="text" id="txttipo_planilla_ret_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_planilla_h?>" size="5" maxlength="4">  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="5"><table width="783" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="229" align="left"><p align="left"><span class="Estilo5">FECHA ENTERADO DESDE : </span></p> </div></td>
              <td width="216" align="left"><span class="Estilo5"><input class="Estilo10" name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></td>
              <td width="338" align="left"><span class="Estilo5"><input class="Estilo10" name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="5"><table width="782" border="0">
            <tr>
              <td width="227" height="26"><p align="left"><span class="Estilo5">TASA :</span></p></td>
              <td width="183"><span class="Estilo5"> <input class="Estilo10" name="txttasa_d" type="text" id="txttasa_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tasa_d?>" size="15" maxlength="15">  </span></td>
              <td width="19">&nbsp;</td>
              <td width="335"><span class="Estilo5"> <input class="Estilo10" name="txttasa_h" type="text" id="txttasa_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tasa_h?>" size="15" maxlength="15">  </span></td>
            </tr>
          </table></td>
        </tr>
		 <tr>
          <td height="19" colspan="5">&nbsp;</td>
        </tr>  
        <tr>
		  <td height="19"><table width="783" border="0">
			  <tr>
				<td width="227" class="Estilo5"> TIPO DE REPORTE :</td>
				<td width="202"><span class="Estilo5"> <select class="Estilo10" name="tipo_rep" id="tipo_rep">
				  <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select></span></td>
				<td width="335" align="left"></td>
			  </tr>
		  </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rep.options[1].selected = true;}else{document.form1.tipo_rep.options[0].selected = true;} </script>
  
		<tr>
          <td height="19" colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_List_Impuesto_Ente('Rpt_List_Impuesto_Ente.php');"> </div></td>
              <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">   </div></td>
		    </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
        </form>
    </div>
</tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>
