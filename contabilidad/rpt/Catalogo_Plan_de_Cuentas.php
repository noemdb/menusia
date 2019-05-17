<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="03"; $opcion="03-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
 $cod_cuenta_d="";$cod_cuenta_h="9-9-999-99-99-9999";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD (Reporte Catalogo Plan de Cuentas)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_Catalogo_Plan_de_Cuen(murl){var url;var r;var st;
  r=confirm("Desea Generar el Reporte Catalogo Plan de Cuentas ?");
  if (r==true) {url=murl+"?cod_cuenta_d="+document.form1.txtCodigo_Cuentad.value+"&cod_cuenta_h="+document.form1.txtCodigo_Cuentah.value+"&tipo_rpt="+document.form1.tipo_rpt.value;
    window.open(url,"Reporte Catalogo Plan de Cuentas"); }}
function Llama_Menu_Rpt(murl){var url; url="../"+murl; LlamarURL(url);}
</script>

</head>
<?$sql="SELECT MAX(codigo_cuenta) As max_codigo_cuenta, MIN(codigo_cuenta) As min_codigo_cuenta FROM con001";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cod_cuenta_d=$registro["min_codigo_cuenta"];$cod_cuenta_h=$registro["max_codigo_cuenta"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE CATALOGO PLAN DE CUENTAS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="207" border="1" id="tablacuerpo">
  <tr>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:179px; z-index:1; top: 68px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="173" border="0">
    <tr>
      <td width="958" align="center" valign="top"><table width="783" border="0" cellspacing="0" cellpadding="0">
        <tr>  <td>&nbsp;</td> </tr>
        <tr>
          <td><div align="center">
               <table width="587" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="113"  align="left"><span class="Estilo5">CUENTA DESDE: </span></td>
                  <td width="280" align="center">
                    <div align="left"><span class="Estilo5">
                      <input name="txtCodigo_Cuentad" type="text" id="txtCodigo_Cuentad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_cuenta_d?>" size="30" maxlength="20">
                      <input name="Catalogo12" type="button" id="Catalogo12" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentasd.php?criterio=','SIA','','750','500','true')" value="..."></span></div></td>
                  </tr>
              </table>
          </div></td>
        </tr>
        <tr>  <td>&nbsp;</td> </tr>
        <tr>
          <td><div align="center">
            <table width="587" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="113" align="left"><span class="Estilo5">CUENTA HASTA: </span></td>
                <td width="280" align="center">
                  <div align="left"><span class="Estilo5">
                    <input name="txtCodigo_Cuentah" type="text" id="txtCodigo_Cuentah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_cuenta_h?>" size="30" maxlength="20">
                    <input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo de Cuentas" onclick="VentanaCentrada('../Cat_cuentash.php?criterio=','SIA','','750','500','true')" value="...">
</span></div></td>
                </tr>
            </table>
          </div></td>
        </tr>
           <tr>  <td>&nbsp;</td> </tr>
	   <tr>
            <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0" >
               <tr>
                 <td width="327"  align="left" class="Estilo5"><div align="center">TIPO SALIDA DEL REPORTE :</div></td>
				 <td width="576" align="left"><span class="Estilo5">
				   <select name="tipo_rpt" id="tipo_rpt"> <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option>  </select></span></td>
              </tr>
             </table></td>
           </tr>
           <tr>  <td>&nbsp;</td> </tr>
		   <tr>  <td>&nbsp;</td> </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>
        <tr>
          <td colspan="2"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Catalogo_Plan_de_Cuen('Rpt_Catalogo_Plan_de_Cuen.php');"></div></td>
              <td><div align="left"> <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">   </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
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
<? pg_close();?>
