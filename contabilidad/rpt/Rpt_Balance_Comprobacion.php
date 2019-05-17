<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); 
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="03"; $opcion="03-0000060"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$codigocuentad="";$codigocuentah="9-9-999-99-99-9999";$periodo="";$nivel="";$vimprimir="S";$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD (Reporte Balance de Comprobacion)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_Balance_Comp(murl){var url;var r;var st="N";
  if(document.form1.opcomprob[0].checked==true){st="S";}
  if(document.form1.opcomprob[1].checked==true){st="N";}
  r=confirm("Desea Generar el Reporte Diario General?");
  if (r==true) {url=murl+"?codigocuentad="+document.form1.txtCodigo_Cuentad.value+"&codigocuentah="+document.form1.txtCodigo_Cuentah.value+"&periodo="+document.form1.txtperiodo.value+"&nivel="+document.form1.txtnivel.value+"&vimprimir="+st+"&tipo_rep="+document.form1.txttipo_rep.value+"&bal_cierre="+document.form1.txtbal_cierre.value;
  window.open(url,"Reporte Diario General")
  }
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>
</head>
<?
$sql="SELECT MAX(Referencia) As Max_Referencia, MIN(Referencia) As Min_Referencia,MAX(Tipo_Asiento) As Max_Tipo,MIN(Tipo_Asiento) As Min_Tipo FROM CON002";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$referencia_d=$registro["min_referencia"];$referencia_h=$registro["max_referencia"];$tipo_asiento_d=$registro["min_tipo"];$tipo_asiento_h=$registro["max_tipo"];}
$sql="SELECT MAX(codigo_cuenta) As max_codigo_cuenta, MIN(codigo_cuenta) As min_codigo_cuenta FROM con001";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$codigocuentad=$registro["min_codigo_cuenta"];$codigocuentah=$registro["max_codigo_cuenta"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE BALANCE DE COMPROBACION </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="976" height="328" border="1" id="tablacuerpo">
  <tr>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:313px; z-index:1; top: 68px; left: 15px;">
        <form name="form1" method="get">
           <table width="948" height="298" border="0">
    <tr>
      <td width="942" align="center" valign="top"><table width="783" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1273" colspan="3" align="center" ">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="center" ><table width="748" height="20" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="48">&nbsp;</td>
              <td width="222">&nbsp;</td>
              <td width="86"><span class="Estilo5">DESDE </span></td>
              <td width="153"></td>
              <td width="122"><span class="Estilo5">HASTA</span></td>
              <td width="117">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="3" align="center"  ><table width="741" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="93">&nbsp;</td>
              <td width="173"><span class="Estilo5">CODIGO CUENTA : </span></td>
              <td width="152"><span class="Estilo5"><input name="txtCodigo_Cuentad" class="Estilo5" type="text" id="txtCodigo_Cuentad" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="32" value="<?echo $codigocuentad?>">   </span></td>
              <td width="88"><span class="Estilo5"><input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentasd.php?criterio=','SIA','','750','500','true')" value="...">   </span></td>
              <td width="148"><span class="Estilo5"><input name="txtCodigo_Cuentah" class="Estilo5" type="text" id="txtCodigo_Cuentah" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="32" value="<?echo $codigocuentah?>">  </span></td>
              <td width="87"><span class="Estilo5"><input name="Catalogo2" type="button" id="Catalogo22" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentash.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="center"><table width="741" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="93">&nbsp;</td>
              <td width="173"><span class="Estilo5">PERIODO :</span>  </td>
              <td width="172"><select name="txtperiodo" class="Estilo5" size="1" id="select2">
                <option selected>01</option> <option>02</option>  <option>03</option>
                <option>04</option><option>05</option> <option>06</option>
                <option>07</option><option>08</option> <option>09</option>
                <option>10</option> <option>11</option><option>12</option> <option>00</option>
              </select></td>
              <td width="68"><span class="Estilo5"> </span></td>
              <td width="148">&nbsp;</td>
              <td width="87">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="center"><table width="741" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="93">&nbsp;</td>
              <td width="173"><span class="Estilo5">NIVEL PARA EL REPORTE :</span></td>
              <td width="172"><select name="txtnivel" size="1" id="select3">
                <option>01</option> <option>02</option> <option>03</option>
                <option>04</option>  <option>05</option>   <option selected>06</option>
                <option>07</option>
              </select></td>
              <td width="68"><span class="Estilo5"> </span></td>
              <td width="148">&nbsp;</td>
              <td width="87">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr><tr>
          <td colspan="3" align="center"><table width="741" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="92">&nbsp;</td>
              <td width="258"><span class="Estilo5">IMPRIMIR CUENTAS SIN MOVIMIENTOS:</span></td>
              <td width="289"><table width="116" height="28" border="1">
                <tr>
                  <td width="106" height="10" valign="center">                    
                    <input type="radio" name="opcomprob" value="A">
                    <span class="Estilo5">SI</span>
                    <input type="radio" name="opcomprob" value="D" checked>
                    <span class="Estilo5"> NO</span>
                  </td>
                </tr>
              </table></td>
              <td width="17"><span class="Estilo5"> </span></td>
              <td width="43">&nbsp;</td>
              <td width="42">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
		<tr> <td colspan="2">&nbsp;</td></tr>
		<tr>
          <td colspan="3" align="center"><table width="741" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="93">&nbsp;</td>
              <td width="173"><span class="Estilo5">TIPO DE REPORTE :</span></td>
              <td width="227"><span class="Estilo5"><select name="txttipo_rep" size="1" id="txttipo_rep" onFocus="encender(this)" onBlur="apagar(this)">
				  <option value='HTML'>FORMATO HTML</option>  <option value='PDF'>FORMATO PDF</option> <option value='EXCEL'>FORMATO EXCEL</option> </select> </span></td>
				  
			<td width="148"><span class="Estilo5">BALANCE DE CIERRE :</span></td>
			<td width="100" align="left"><span class="Estilo5"><select name="txtbal_cierre" size="1" id="txtbal_cierre" onFocus="encender(this)" onBlur="apagar(this)">
				  <option value='NO'>NO</option>  <option value='SI'>SI</option> </select> </span></td>
			
            </tr>
          </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.txttipo_rep.options[1].selected = true;}else{document.form1.txttipo_rep.options[0].selected = true;} </script>

        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Balance_Comp('Rpt_Balance_Comp.php');">   </div></td>
              <td><div align="center"> <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">  </div></td>
			</tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="3">&nbsp;</td>
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
