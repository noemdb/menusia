<?php include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="03-0000060"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?php }
$cod_banco_d="";$cod_banco_h="";$metodo_conci="";$periodod='01';$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Reporte Conciliaci&oacute;n Bancaria)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_Conciliacion_Banca(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Conciliacion Bancaria ?");
  if (r==true){url=murl+"?cod_banco_d="+document.form1.txtcod_banco_d.value+"&cod_banco_h="+document.form1.txtcod_banco_h.value+"&metodo_conci="+document.form1.selectmetodo_conciliacion.value+"&periodod="+document.form1.selectperiodo.value+"&tipo_rep="+document.form1.tipo_rep.value;
  window.open(url,"Reporte Conciliacion Bancaria")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>
</head>
<?php 
$sql="SELECT MAX(cod_banco) As Max_cod_banco, MIN(cod_banco) As Min_cod_banco FROM BAN002";$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$cod_banco_d=$registro["min_cod_banco"];$cod_banco_h=$registro["max_cod_banco"];}
$sql="Select nombre_banco from BAN002 where cod_banco='$cod_banco_d'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_banco_d=$registro["nombre_banco"];}
$sql="Select nombre_banco from BAN002 where cod_banco='$cod_banco_h'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_banco_h=$registro["nombre_banco"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE CONCILIACI&Oacute;N BANCARIA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="974" height="330" border="1" id="tablacuerpo">
  <tr>
    <td width="964" height="320">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:291px; z-index:1; top: 55px; left: 16px;">
        <form name="form1" method="get">
    <table width="950" height="315" border="0">
    <tr>
      <td width="958" height="315" align="center" valign="top"><table width="783" height="313" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="783" height="19" colspan="2" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="776" border="0">
            <tr>
              <td width="219" height="26"><div align="left"><span class="Estilo5">CODIGO DE BANCO DESDE : </span></div></td>
              <td width="48"><span class="Estilo5"> <input class="Estilo10" name="txtcod_banco_d" type="text" id="txtcod_banco_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_banco_d?>" size="5" maxlength="4">  </span></td>
              <td width="40"><span class="Estilo5"><input class="Estilo10" name="Catalogo_d" type="button" id="Catalogo_d" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_Bancosd.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
              <td width="451"><span class="Estilo5"><input class="Estilo10" name="txtdesc_banco_d" type="text" id="txtdesc_banco_d" size="60" maxlength="150" value="<?php echo $nombre_banco_d?>"  readonly>   </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="219" height="26"><div align="left"><span class="Estilo5">C&Oacute;DIGO DE BANCO HASTA : </span></div></td>
              <td width="46"><span class="Estilo5"> <input class="Estilo10" name="txtcod_banco_h" type="text" id="txtcod_banco_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_banco_h?>" size="5" maxlength="4">  </span></td>
              <td width="43"><span class="Estilo5"> <input class="Estilo10" name="Catalogo_h" type="button" id="Catalogo_h" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_Bancosh.php?criterio=','SIPAP','','750','500','true')" value="...">  </span></td>
              <td width="450"><span class="Estilo5"><input class="Estilo10" name="txtdesc_banco_h" type="text" id="txtdesc_banco_h" size="60" maxlength="150"  value="<?php echo $nombre_banco_h?>"  readonly>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td height="30" colspan="2"><table width="783" border="0">
            <tr>
              <td width="219"><p align="left"><span class="Estilo5">METODO DE CONCILIACION:</span></p></td>
              <td width="554"><select class="Estilo10" name="selectmetodo_conciliacion" size="1" id="selectmetodo_conciliacion">
                <option value="SEB" selected>Saldos Encontrados (Bancos)</option>
                <option value="SA">Saldos Ajustados</option>
                <option value="SEL">Saldos Encontrados (Libros)</option>
                <option value="SEBM">Saldos Encontrados (Bancos) - Beneficiario</option>
              </select></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="717" border="0">
            <tr>
              <td width="219"><p align="left"><span class="Estilo5">PERIODO :</span></p></td>
              <td width="227"><select  class="Estilo10" name="selectperiodo" size="1" id="selectperiodo">
                  <option selected>01</option>  <option>02</option>  <option>03</option>
                  <option>04</option> <option>05</option> <option>06</option>
                  <option>07</option> <option>08</option> <option>09</option>
                  <option>10</option> <option>11</option> <option>12</option>
              </select></td>
              <td width="257">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
        </tr>
		<tr>
		  <td height="19"><table width="775" border="0">
			  <tr>
				<td width="219" class="Estilo5"> TIPO DE REPORTE :</td>
				<td width="556"><span class="Estilo5"> <select  class="Estilo5" name="tipo_rep" id="tipo_rep">
				  <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select>
				</span></td>
			  </tr>
		  </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rep.options[1].selected = true;}else{document.form1.tipo_rep.options[0].selected = true;} </script>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="59" colspan="2"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Conciliacion_Banca('Rpt_Conciliacion_Banca.php');">     </div></td>
              <td><div align="center">  <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">  </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
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
