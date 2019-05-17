<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="03"; $opcion="03-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD (Reporte Catalogo de Asientos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_Catalogo_Cuen(murl){var url;var r;var st;
  r=confirm("Desea Generar el Reporte Catalogo Tipos de Asientos ?");
  if (r==true) {
    url=murl+"?tipo_asiento_d="+document.form1.txtTipo_Asientod.value+"&tipo_asiento_h="+document.form1.txtTipo_Asientoh.value+"&tipo_rpt="+document.form1.tipo_rpt.value;
    window.open(url,"Reporte Catalogo de Cuentas")
  }
}
function Llama_Menu_Rpt(murl){var url;    url="../"+murl;  LlamarURL(url);}
</script>  
</head>
<?  $tipo_asiento_d="";$tipo_asiento_h="";
$sql="SELECT MAX(tipo_asiento) As Max_tipo_asiento, MIN(tipo_asiento) As Min_tipo_asiento FROM con009";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;} else{$encontro=false;}
if($encontro=true){ $tipo_asiento_d=$registro["min_tipo_asiento"];$tipo_asiento_h=$registro["max_tipo_asiento"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE CATALOGO DE ASIENTOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="205" border="1" id="tablacuerpo">
  <tr>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:194px; z-index:1; top: 68px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" border="0">
    <tr>
      <td width="958" align="center" valign="top"><table width="783" border="0" cellspacing="0" cellpadding="0">
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td><div align="center">
               <table width="587" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="250" align="center"><div align="center"><span class="Estilo5">DESDE : </span></div></td>
                  <td width="330" align="center"> <div align="left"><span class="Estilo5">
                      <input name="txtTipo_Asientod" type="text" id="txtTipo_Asientod" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_asiento_d?>" size="5" maxlength="3"> </span></div></td>
                  </tr>
              </table>
          </div></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td><table width="587" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="250" align="center"><div align="center"><span class="Estilo5">HASTA : </span></div></td>
            <td width="330" align="center">  <div align="left"><span class="Estilo5">
                <input name="txtTipo_Asientoh" type="text" id="txtTipo_Asientoh" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_asiento_h?>" size="5" maxlength="3">
            </span></div></td>
          </tr>
        </table></td></tr>
           <tr><td>&nbsp;</td></tr>
	   <tr>
            <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0" >
               <tr>
                 <td width="420"  align="left" class="Estilo5"><div align="center">TIPO SALIDA DEL REPORTE :</div></td>
				 <td width="483" align="left"><span class="Estilo5">
				   <select name="tipo_rpt" id="tipo_rpt"> <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option>  </select></span></td>
              </tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>
           <tr> <td>&nbsp;</td> </tr>
           <tr> <td>&nbsp;</td> </tr>  <tr>
          <td colspan="2"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Catalogo_Cuen('Rpt_Catalogo_Asien.php');">
                      </div></td>
              <td>
                      <div align="left">
                        <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                      </div></td></tr>
          </table></td>
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
