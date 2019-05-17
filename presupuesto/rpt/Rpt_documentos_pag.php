<?include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php");  include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="03-0000020"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
 $tipo_pagod=""; $tipo_pagoh="zzzz"; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Reporte de Documentos Pagos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="Javascript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref;var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);     mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref;var mfec;
  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);     mform.txtFechah.value=mfec;}
return true;}
function Llama_Rpt_documentos_pa(murl){var url;var r;
  r=confirm("Desea Generar el Reporte de Documentos Pagos?");
  if (r==true) {url=murl+"?tipo_pagod="+document.form1.txttipo_pagod.value+"&tipo_pagoh="+document.form1.txttipo_pagoh.value+"&tipo_rep="+document.form1.txttipo_rep.value;
        window.open(url);
  }
}

function Llama_Menu_Rpt(murl){var url;   url="../"+murl; LlamarURL(url);}
</script>
</head>
<?
$sql="Select max(tipo_pago) As max_tipo_pago, min(tipo_pago) As min_tipo_pago from pre004"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $tipo_pagod=$registro["min_tipo_pago"];  $tipo_pagoh=$registro["max_tipo_pago"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE DE DOCUMENTOS PAGOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="275" border="1" id="tablacuerpo">
  <tr>
    <td width="992" height="270">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:952px; height:248px; z-index:1; top: 69px; left: 30px;">
        <form name="form1" method="get">
           <table width="950" height="265" border="0">
    <tr>
      <td width="958" height="260" align="center" valign="top"><table width="830" height="235" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="61" height="5">&nbsp;</td>
        </tr>
        <tr>
          <td height="40"><table width="829" border="0">
            <tr>
              <td width="211" height="26"><div align="right"> </div></td>
              <td width="328"><span class="Estilo12"><strong>DESDE</strong></span></td>
              <td width="276"><span class="Estilo12"><strong>HASTA</strong></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0">
            <tr>
			  <td width="206"><span class="Estilo5">TIPO PAGO : </span></td>              
              <td width="60"><span class="Estilo5"><input class="Estilo10" name="txttipo_pagod" type="text"  id="txttipo_pagod" size="8"  maxlength="6" onFocus="encender(this); " value="<?echo $tipo_pagod?>" onBlur="apagar(this);" class="Estilo5"></span></td>
              <td width="285"><span class="Estilo5"><input class="Estilo10" name="bttipo_pagod" type="button" id="bttipo_pagod" title="Abrir Catalogo Tipos de Compromiso" onClick="VentanaCentrada('Cat_tipo_pagod.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
              <td width="63"><span class="Estilo5"><input class="Estilo10" name="txttipo_pagoh" type="text"  id="txttipo_pagoh" size="8" maxlength="6" onFocus="encender(this); " value="<?echo $tipo_pagoh?>" onBlur="apagar(this);" class="Estilo5">   </span></td>
              <td width="194"><span class="Estilo5"> <input class="Estilo10" name="bttipo_pagoh" type="button" id="bttipo_pagoh" title="Abrir Catalogo Tipos de Compromiso" onClick="VentanaCentrada('Cat_tipo_pagoh.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
		<tr>
          <td height="19"><table width="828" border="0">
            <tr>
              <td width="203" align="right"><div align="left"><span class="Estilo5">TIPO DE REPORTE : </span></div></td>
              <td width="615"><span class="Estilo5"><select class="Estilo10" name="txttipo_rep" size="1" id="txttipo_rep" onFocus="encender(this)" onBlur="apagar(this)">
			      <option value='HTML'>FORMATO HTML</option>  <option value='PDF'>FORMATO PDF</option> <option value='EXCEL'>FORMATO EXCEL</option> </select></td>
            </tr>
          </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.txttipo_rep.options[1].selected = true;}else{document.form1.txttipo_rep.options[0].selected = true;} </script>

        <tr> <td>&nbsp;</td></tr>
        <tr>
          <td height="40"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_documentos_pa('Rpt_documentos_pa.php');">  </div></td>
              <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">  </div></td>
			</tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
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
