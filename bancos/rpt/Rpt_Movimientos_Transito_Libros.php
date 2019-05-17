<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="03-0000035"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
$cod_banco_d="";$cod_banco_h="";$tipo_mov_d="";$tipo_mov_h="";$referencia_d="";$referencia_h="zzzzzzzz";$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$vurl;
$des_tipo_d="";$des_tipo_h=""; $nombre_banco_d="";  $nombre_banco_h=""; $fecha_d="01/01/2008";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Reporte Movimientos en Transito Libros)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
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
function Llama_Rpt_Movimientos_Transito_Lib(murl){var url;var r; 
  r=confirm("Desea Generar el Reporte Movimientos en Libro?");
  if (r==true){url=murl+"?cod_banco_d="+document.form1.txtcod_banco_d.value+"&cod_banco_h="+document.form1.txtcod_banco_h.value+"&tipo_mov_d="+document.form1.txttipo_mov_d.value+"&tipo_mov_h="+document.form1.txttipo_mov_h.value+"&referencia_d="+document.form1.txtreferencia_d.value+"&referencia_h="+document.form1.txtreferencia_h.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&tipo_rep="+document.form1.tipo_rep.value;
    window.open(url,"Reporte Movimientos en Libro")}}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

</head>
<?
$sql="SELECT MAX(cod_banco) As Max_cod_banco, MIN(cod_banco) As Min_cod_banco FROM BAN002";$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$cod_banco_d=$registro["min_cod_banco"];$cod_banco_h=$registro["max_cod_banco"];}
$sql="SELECT MAX(ced_rif) As Max_Ced_Rif, MIN(ced_rif) As Min_Ced_Rif FROM PRE099";$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$cedula_d=$registro["min_ced_rif"];$cedula_h=$registro["max_ced_rif"];}
$sql="SELECT MAX(tipo_movimiento) As Max_Tipo_Movimiento, MIN(tipo_movimiento) As Min_Tipo_Movimiento FROM BAN003"; $res=pg_query($sql);if($registro=pg_fetch_array($res,0)){$tipo_mov_d=$registro["min_tipo_movimiento"];$tipo_mov_h=$registro["max_tipo_movimiento"];}
$sql="Select nombre_banco from BAN002 where cod_banco='$cod_banco_d'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_banco_d=$registro["nombre_banco"];}
$sql="Select nombre_banco from BAN002 where cod_banco='$cod_banco_h'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_banco_h=$registro["nombre_banco"];}
$sql="Select nombre from pre099 where ced_rif='$cedula_d'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_d=$registro["nombre"];}
$sql="Select nombre from pre099 where ced_rif='$cedula_h'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_h=$registro["nombre"];}
$sql="Select descrip_tipo_mov from ban003 where tipo_movimiento='$tipo_mov_d'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$des_tipo_d=$registro["descrip_tipo_mov"];}
$sql="Select descrip_tipo_mov from ban003 where tipo_movimiento='$tipo_mov_h'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$des_tipo_h=$registro["descrip_tipo_mov"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE MOVIMIENTOS EN TRANSITO LIBROS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="440" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="435">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:387px; z-index:1; top: 65px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="430" border="0">
    <tr>
      <td width="958" height="430" align="center" valign="top"><table width="783" height="430" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="776" border="0">
            <tr>
              <td width="244" height="26"><div align="left"><span class="Estilo5">CODIGO DE BANCO DESDE : </span></div></td>
              <td width="52"><span class="Estilo5"> <input class="Estilo10" name="txtcod_banco_d" type="text" id="txtcod_banco_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_d?>" size="5" maxlength="4">  </span></td>
              <td width="35"><span class="Estilo5"><input class="Estilo10" name="Cat_codd" type="button" id="Cat_codd" title="Abrir Catalogo de Bancos" onClick="VentanaCentrada('../Cat_Bancosd.php?criterio=','SIA','','750','500','true')" value="...">   </span></td>
              <td width="427"><span class="Estilo5"><input class="Estilo10" name="txtdesc_banco_d" type="text" id="txtdesc_banco_d" size="60" maxlength="150" value="<?echo $nombre_banco_d?>" readonly>  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="245" height="26"> <div align="left"><span class="Estilo5">CODIGO DE BANCO HASTA : </span></div></td>
              <td width="51"><span class="Estilo5"><input class="Estilo10" name="txtcod_banco_h" type="text" id="txtcod_banco_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_h?>" size="5" maxlength="4">  </span></td>
              <td width="34"><span class="Estilo5"><input class="Estilo10" name="Cat_codh" type="button" id="Cat_codh" title="Abrir Catalogo de Bancos" onClick="VentanaCentrada('../Cat_Bancosh.php?criterio=','SIA','','750','500','true')" value="...">   </span></td>
              <td width="428"><span class="Estilo5"> <input class="Estilo10" name="txtdesc_banco_h" type="text" id="txtdesc_banco_h" size="60" maxlength="150" value="<?echo $nombre_banco_h?>" readonly>  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="247" height="26"><div align="left"><span class="Estilo5">TIPO DE MOVIMIENTO DESDE : </span></div></td>
              <td width="49"><span class="Estilo5"><input class="Estilo10" name="txttipo_mov_d" type="text" id="txttipo_mov_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_mov_d?>" size="5" maxlength="3">     </span></td>
              <td width="38"><span class="Estilo5"><input class="Estilo10" name="Cat_tipod" type="button" id="Cat_tipod" title="Abrir Catalogo de Tipo Movimiento" onClick="VentanaCentrada('../Cat_Tipo_Movd.php?criterio=','SIA','','750','500','true')" value="...">   </span></td>
              <td width="424"><span class="Estilo5"><input class="Estilo10" name="txtdesc_tipo_Mov_d" type="text" id="txtdesc_tipo_Mov_d" size="60" maxlength="150" value="<?echo $des_tipo_d?>"  readonly>  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="248" height="26"><div align="left"><span class="Estilo5">TIPO DE MOVIMIENTO HASTA : </span></div></td>
              <td width="50"><span class="Estilo5"><input class="Estilo10" name="txttipo_mov_h" type="text" id="txttipo_mov_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_mov_h?>" size="5" maxlength="3">   </span></td>
              <td width="35"><span class="Estilo5"><input class="Estilo10" name="Cat_tipoh" type="button" id="Cat_tipoh" title="Abrir Catalogo de Tipo Movimiento" onClick="VentanaCentrada('../Cat_Tipo_Movh.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
              <td width="425"><span class="Estilo5"><input class="Estilo10" name="txtdesc_tipo_mov_h" type="text" id="txtDesc_Tipo_Mov_D" size="60" maxlength="150" value="<?echo $des_tipo_h?>"  readonly>    </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="783" border="0">
            <tr>
              <td width="247" height="26"><p align="left"><span class="Estilo5">REFERENCIA DESDE :</span></p></td>
              <td width="167"><span class="Estilo5"> <input class="Estilo10" name="txtreferencia_d" type="text" id="txtreferencia_d" onFocus="encender(this)" onBlur="apaga_referenciad(this)" value="<?echo $referencia_d?>" size="8" maxlength="8">  </span></td>
              <td width="108"><span class="Estilo5">HASTA :</span></td>
              <td width="243"><span class="Estilo5"><input class="Estilo10" name="txtreferencia_h" type="text" id="txtreferencia_h" onFocus="encender(this)" onBlur="apaga_referenciah(this)" value="<?echo $referencia_h?>" size="8" maxlength="8">  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="247" align="left"><span class="Estilo5">FECHA MOVIMIENTO DESDE : </span></td>
              <td width="178" align="left"><span class="Estilo5"><input class="Estilo10" name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="96" align="left"><span class="Estilo5">HASTA :</span></div></td>
              <td width="262" align="left"><span class="Estilo5"><input class="Estilo10" name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
            </tr>
          </table></td>
        </tr>
		<tr><td height="19">&nbsp;</td> </tr>
		<tr>
		  <td height="19"><table width="775" border="0">
			  <tr>
				<td width="245" class="Estilo5"> TIPO DE REPORTE :</td>
				<td width="175"><span class="Estilo5"> <select class="Estilo10" name="tipo_rep" id="tipo_rep">
				  <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select>
				</span></td>
				<td width="345" align="left"></td>
			  </tr>
		  </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rep.options[1].selected = true;}else{document.form1.tipo_rep.options[0].selected = true;} </script>
        <tr><td height="19">&nbsp;</td> </tr>
        <tr>
          <td height="65"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Movimientos_Transito_Lib('Rpt_Movimientos_Transito_Lib.php');">  </div></td>
              <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">     </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
        </form>
    </div>     </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>
