<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="03"; $opcion="03-0000035"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
 $periodo='01';  $vimprimir="S";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD (Reporte Resumen de Diario General)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_Res_Diario_G(murl){var url; var r; var imp;
  if(document.form1.opimprimir[0].checked==true){imp="S";}
  if(document.form1.opimprimir[1].checked==true){imp="N";}
  r=confirm("Desea Generar el Reporte Resumen de Diario General ?");
  if (r==true) {url=murl+"?periodo="+document.form1.txtperiodo.value+"&vimprimir="+imp+"&tipo_rep="+document.form1.txttipo_rep.value; window.open(url,"Reporte Asientos Diarios")}
}
function Llama_Menu_Rpt(murl){var url;    url="../"+murl;  LlamarURL(url);}
</script>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE RESUMEN DE DIARIO GENERAL </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="976" height="242" border="1" id="tablacuerpo">
  <tr>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:957px; height:223px; z-index:1; top: 68px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="207" border="0">
    <tr>
      <td width="958" height="203" align="center" valign="top"><table width="783" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" align="center" ><table width="681" height="21" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="167" align="center"><div align="left"><span class="Estilo5">PERIODO : </span></div></td>
              <td width="166" align="center"><div align="left"><span class="Estilo5"><select name="txtperiodo" size="1" id="txtperiodo">
                    <option selected>01</option> <option>02</option> <option>03</option>
                    <option>04</option> <option>05</option>  <option>06</option>
                    <option>07</option> <option>08</option>  <option>09</option>
                    <option>10</option> <option>11</option> <option>12</option>
                  </select>
              </span></div></td>
              <td width="68" align="center"></td>
              <td width="187" align="center"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><table width="699" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="284" align="center"><div align="left"><span class="Estilo5">IMPRIMIR CUENTAS SIN MOVIMIENTOS : </span></div></td>
              <td width="156" align="center">
                <div align="left">
                  <table width="120" height="30" border="1">
                    <tr>
                      <td width="110" valign="top"><label> <input name="opimprimir" type="radio" value="S" checked><span class="Estilo5"> SI </span></label>
                          <label><input type="radio" name="opimprimir" value="N"><span class="Estilo5"> NO </span></label></td>
                    </tr>
                  </table>
                  </div></td>
              <td width="86" align="center"></td>
              <td width="173" align="center">
                <div align="left"></td>
            </tr>
          </table></td>
        </tr>
		<tr> <td colspan="2">&nbsp;</td> </tr>
		<tr>
          <td ><table width="699" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="284" align="left"><span class="Estilo5">TIPO DE REPORTE :</span></td>
                <td width="300" align="left"><span class="Estilo5"><select name="txttipo_rep" size="1" id="txttipo_rep" onFocus="encender(this)" onBlur="apagar(this)">
				  <option value='HTML'>FORMATO HTML</option>  <option value='PDF'>FORMATO PDF</option> <option value='EXCEL'>FORMATO EXCEL</option> </select> </span></td>
			  <td width="100"></td>
              </tr>
            </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.txttipo_rep.options[1].selected = true;}else{document.form1.txttipo_rep.options[0].selected = true;} </script>
		
       <tr> <td colspan="2">&nbsp;</td> </tr> <tr>
        <tr> <td colspan="2">&nbsp;</td> </tr>
        <tr>
          <td colspan="2"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Res_Diario_G('Rpt_Resumen_Dia_G.php');">
                      </div></td>
              <td>
                    <div align="center">
                      <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                      </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="38" colspan="2">&nbsp;</td>
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