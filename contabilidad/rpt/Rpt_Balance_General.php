<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");  include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="03"; $opcion="03-0000050"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
 $periodo='01';  $nivel='06';  $vimprimir="S";  $mcfinan=substr($SIA_Integrado,5,1);  $mcfinan="N";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD (Reporte Balance General)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
var MContab_Finan='<?php echo $mcfinan ?>';
function Llama_Rpt_Balance_General(murl){var url; var r;  var imp;  var turl;  turl=murl;
  if(document.form1.opimprimir[0].checked==true){imp="S";}
  if(document.form1.opimprimir[1].checked==true){imp="N";}
  if(document.form1.optpbalance[0].checked==true){if(MContab_Finan=="S"){turl="Rpt_Balance_Gen.php";}else{turl="Rpt_Balance_G_fis.php";}}
  if(document.form1.optpbalance[1].checked==true){if(MContab_Finan=="S"){turl="Rpt_Balance_tres.php";}else{turl="Rpt_Balance_pub.php";}}
  r=confirm("Desea Generar el Reporte Balance General ?");
  if (r==true){ url=turl+"?periodo="+document.form1.txtperiodo.value+"&nivel="+document.form1.txtnivel.value+"&vimprimir="+imp+"&tipo_rep="+document.form1.txttipo_rep.value;
    window.open(url,"Reporte Balance General")
  }
}
function Llama_Menu_Rpt(murl){var url;  url="../"+murl;  LlamarURL(url);}
</script>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE BALANCE GENERAL </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="973" height="328" border="1" id="tablacuerpo">
  <tr>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:314px; z-index:1; top: 60px; left: 18px;">
        <form name="form1" method="get">
           <table width="928" height="304" border="0">
    <tr>
      <td width="958" height="283" align="center" valign="top"><table width="783" border="0" cellspacing="0" cellpadding="0">
        <tr> <td colspan="2">&nbsp;</td></tr>
                <tr> <td colspan="2">&nbsp;</td></tr>
        <tr> <td colspan="2"><table width="773" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="118">&nbsp;</td>
            <td width="300"><span class="Estilo5">PERIODO:</span></td>
            <td width="184"><select name="txtperiodo" size="1" id="txtperiodo">
              <option selected>01</option> <option>02</option> <option>03</option> <option>04</option>
              <option>05</option><option>06</option> <option>07</option><option>08</option>
              <option>09</option> <option>10</option> <option>11</option><option>12</option> <option>00</option>
            </select></td>
            <td width="171">&nbsp;</td>
          </tr>
        </table></td></tr>

        <tr> <td colspan="2">&nbsp;</td></tr>
                <tr> <td colspan="2"><table width="773" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="118">&nbsp;</td>
            <td width="300"><span class="Estilo5">NIVEL PARA EL REPORTE:</span></td>
            <td width="184"><select name="txtnivel" size="1" id="select">
              <option>02</option> <option>03</option><option>04</option><option>05</option><option selected>06</option><option>07</option>
            </select></td>
            <td width="171">&nbsp;</td>
          </tr>
        </table></td></tr>
        <tr> <td colspan="2">&nbsp;</td></tr>
        <tr> <td colspan="2"><table width="773" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="118">&nbsp;</td>
            <td width="300"><span class="Estilo5">IMPRIMIR CUENTAS SIN MOVIMIENTOS: </span></td>
            <td width="184"><table width="120" height="30" border="1">
              <tr>
                <td width="110" valign="top"> <label><input name="opimprimir" type="radio" value="S"><span class="Estilo5"> SI </span></label>
                  <label><input type="radio" name="opimprimir" value="N" checked><span class="Estilo5">NO </span></label>
                </td>
              </tr>
            </table></td>
            <td width="171">&nbsp;</td>
          </tr>
        </table></td></tr>
       <tr> <td colspan="2">&nbsp;</td> </tr>
        <tr> <td colspan="2">&nbsp;</td></tr>
        <tr> <td colspan="2"><table width="773" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="120">&nbsp;</td>
            <td width="160"><span class="Estilo5">TIPO DE BALANCE : </span></td>
            <td width="459"><table width="421" height="30" border="1">
              <tr>
                            <? if($mcfinan=='S'){?>
                <td width="411" valign="top"> <label><input name="optpbalance" type="radio" value="S" checked> <span class="Estilo5">DOS COLUMNAS </span></label>
                  <label><input type="radio" name="optpbalance" value="N"><span class="Estilo5">TRES COLUMNAS </span></label>
                </td>
                                <? }else{?>
                                <td width="411" valign="top"> <label><input name="optpbalance" type="radio" value="S" ><span class="Estilo5"> DOS COLUMNAS </span></label>
                  <label><input type="radio" name="optpbalance" value="N"><span class="Estilo5">PUBLICACION </span></label>     <? }?>
                </td>
              </tr>
            </table></td>
            <td width="34">&nbsp;</td>
          </tr>
        </table></td></tr>
        <tr> <td colspan="2">&nbsp;</td></tr>
        <tr> <td colspan="2"><table width="773" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="120">&nbsp;</td>
            <td width="160"><span class="Estilo5">TIPO DE REPORTE :</span></td>
            <td width="459" align="left"><span class="Estilo5"><select name="txttipo_rep" size="1" id="txttipo_rep" onFocus="encender(this)" onBlur="apagar(this)">
				  <option value='HTML'>FORMATO HTML</option>  <option value='PDF'>FORMATO PDF</option> <option value='EXCEL'>FORMATO EXCEL</option> </select> </span></td>
			  
            <td width="34">&nbsp;</td>
          </tr>
        </table></td></tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.txttipo_rep.options[1].selected = true;}else{document.form1.txttipo_rep.options[0].selected = true;} </script>
		
        <tr> <td colspan="2">&nbsp;</td></tr>
        <tr> <td colspan="2">&nbsp;</td></tr>
        <tr>
          <td colspan="2"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Balance_General('Rpt_Balance_Gen.php');"></div></td>
              <td><div align="center"> <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"></div></td></tr>
          </table></td>
        </tr>
        <tr> <td colspan="2">&nbsp;</td></tr>
      </table> </td>
    </tr>
  </table>
  </form>
   </div></td>
</tr>
</table>
</body>
</html>
<? pg_close();?>
