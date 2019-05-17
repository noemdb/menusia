<?include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="03-0000056"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
 $codigo_estrucrura_d='';$codigo_estrucrura_h='';$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Reporte Relacion Estructura de Codigo)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<SCRIPT language="JavaScript" src="../../class/sia.js" type="text/javascript"></SCRIPT>
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
   mref=mform.txtcod_estructura_d.value;   mref = Rellenarizq(mref,"0",8);  mform.txtcod_estructura_d.value=mref;
return true;}
function checkreferenciah(mform){var mref;
   mref=mform.txtcod_estructura_h.value;   mref = Rellenarizq(mref,"0",8);  mform.txtcod_estructura_h.value=mref;
return true;}
function Llama_Rpt_Rel_Estructura_Cod(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Relacion Estructura de Codigo?");
  if (r==true) {url=murl+"?codigo_estrucrura_d="+document.form1.txtcod_estructura_d.value+"&codigo_estrucrura_h="+document.form1.txtcod_estructura_h.value+"&tipo_rpt="+document.form1.tipo_rpt.value;
    window.open(url,"Reporte Relacion Estructura de Codigo")}}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

</head>
<?
$sql="SELECT MAX(cod_estructura) As Max_cod_estructura, MIN(cod_estructura) As Min_cod_estructura FROM PAG006";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$codigo_estrucrura_d=$registro["min_cod_estructura"];$codigo_estrucrura_h=$registro["max_cod_estructura"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="45"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE RELACION ESTRUCTURA DE CODIGO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="237" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="231">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:209px; z-index:1; top: 73px; left: 23px;">
        <form name="form1" method="get">
           <table width="950" height="205" border="0">
    <tr>
      <td width="958" height="201" align="center" valign="top"><table width="783" height="194" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="783" height="19" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" align="center" class="Estilo16"><table width="757" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="245">&nbsp;</td>
              <td width="177"><span class="Estilo13">DESDE</span></td>
              <td width="335"><span class="Estilo13">HASTA</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="776" border="0">
            <tr>
              <td width="225" height="26"> <span class="Estilo5"><div align="left">CODIGO ESTRUCTURA: </div></span></td>
              <td width="110"><span class="Estilo5"><input class="Estilo10" name="txtcod_estructura_d" type="text" id="txtcod_estructura_d" onFocus="encender(this)" onBlur="apagar(this)" onchange="checkreferenciad(this.form)" value="<?echo $codigo_estrucrura_d?>" size="15" maxlength="8"> </span></td>
              <td width="61"></td>
              <td width="188"><span class="Estilo5"><input class="Estilo10" name="txtcod_estructura_h" type="text" id="txtcod_estructura_h" onFocus="encender(this)" onBlur="apagar(this)" onchange="checkreferenciah(this.form)" value="<?echo $codigo_estrucrura_h?>" size="15" maxlength="8"></span></td>
              <td width="170"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr> 
		<tr>
		  <td height="19"><table width="776" border="0">
			  <tr>
				<td width="226" class="Estilo5"> TIPO DE REPORTE :</td>
				<td width="550"><span class="Estilo5"> <select  class="Estilo10" name="tipo_rpt" id="tipo_rpt">
				  <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select> </span></td>
			  </tr>
		  </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>
        <tr>
          <td height="89"><table width="390" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td width="198"><div align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Rel_Estructura_Cod('Rpt_Rel_Estructura_Cod.php');"> </div></td>
              <td width="256"><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">  </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
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
<? pg_close();?>
