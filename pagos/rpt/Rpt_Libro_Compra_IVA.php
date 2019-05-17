<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc"); 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="03-0000090"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
 $periodod='2012';$periodoh='01'; $fecha_hoy=asigna_fecha_hoy(); $periodod=substr($fecha_hoy,6,4);  $periodoh=substr($fecha_hoy,3,2);
 $nombre_rpt="Rpt_Libro_Compra.php";  if($Cod_Emp=="71"){$nombre_rpt="Rpt_Libro_Compra_yac.php";};
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Reporte Libro de Compras IVA)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<SCRIPT language="JavaScript" src="../../class/sia.js" type="text/javascript"></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function checkrefechad(mform){var mref;var mfec;  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref;var mfec;  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechah.value=mfec;}
return true;}

function Llama_Rpt_Libro_Compra(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Libro de Compras ?");
  if (r==true) {  url=murl+"?periodod="+document.form1.txtperiodo_d.value+"&periodoh="+document.form1.txtperiodo_h.value+"&tipo_rpt="+document.form1.tipo_rpt.value+"&excedente="+document.form1.txtexcedente.value;
    window.open(url,"Reporte Libro de Compras");}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE LIBRO DE COMPRAS IVA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="289" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="283">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:256px; z-index:1; top: 75px; left: 18px;">
        <form name="form1" method="get"><table width="950" height="250" border="0">
    <tr>
      <td width="958" height="246" align="center" valign="top"><table width="783" height="236" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="783">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" align="center" class="Estilo16"><table width="776" border="0">
            <tr>
              <td width="257" height="26" class="Estilo5"> <div align="right">PERIODO FISCAL MES : </div></td>
              <td width="82"><span class="Estilo5"><input class="Estilo10" name="txtperiodo_h" type="text" id="txtperiodo_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $periodoh?>" size="5" maxlength="4" class="Estilo5">
              </span></td>
              <td width="128" class="Estilo5"><div align="right">A&Ntilde;O  : </div></td>
              <td width="291"><span class="Estilo5"><input class="Estilo10" name="txtperiodo_d" type="text" id="txtperiodo_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $periodod?>" size="12" maxlength="10" class="Estilo5">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td width="783">&nbsp;</td>
        </tr>
		<?if($Cod_Emp=="71"){?>
        <tr>
		  <td height="19"><table width="782" border="0">
			  <tr>
				<td width="240" class="Estilo5" align="right"> TIPO DE REPORTE : </td>
				<td width="220"><span class="Estilo5"> <select class="Estilo10" name="tipo_rpt" id="tipo_rpt">
				  <option value='PDF'>FORMATO PDF</option>
				  <option value='PDF2'>FORMATO PDF EXTRA</option><option value='EXCEL'>FORMATO EXCEL</option> </select>
				</span></td>
				<td width="172" class="Estilo5"> EXCEDENTE MES ANTERIOR : </td>
			    <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtexcedente" type="text" id="txtexcedente"  size="15" maxlength="15"  style="text-align:right" onFocus="encender(this)" onBlur="apagar(this)" value="0" onKeypress="return validarNum(event)"> </span></td>
		
			  </tr>
			</table></td>
        </tr>
		<?} else {?>
		<tr>
		  <td height="19"><table width="782" border="0">
			  <tr>
				<td width="257" class="Estilo5" align="right"> TIPO DE REPORTE : </td>
				<td width="520"><span class="Estilo5"> <select class="Estilo10" name="tipo_rpt" id="tipo_rpt">
				  <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option>
				  <option value='PDF2'>FORMATO PDF EXTRA</option><option value='EXCEL'>FORMATO EXCEL</option> </select>
				</span></td>
				 <td width="5"><input class="Estilo10" name="txtexcedente" type="hidden" id="txtexcedente" value="0" ></td>
			  </tr>
		  </table></td>
        </tr> 
		<?} ?>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>
        <tr> <td height="18" colspan="3">&nbsp;</td>  </tr> 		 
        <tr>
          <td><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Libro_Compra('<?echo $nombre_rpt?>');">  </div></td>
              <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">   </div></td>
			</tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
        </form>
    </div>
    <div align="left"></div></td>
</tr>
</table>
</body>
</html>

<? pg_close();?>
