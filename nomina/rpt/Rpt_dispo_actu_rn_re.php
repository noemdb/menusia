<?include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="03-0000109"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
 $cod_presup_d="";  $cod_presup_h="zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz"; 
 $cod_fuente_d="";  $cod_fuente_h="zz"; $des_fuente_d=""; $des_fuente_h="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Reportes Disponibilidad Actualizada)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_dispo_actu_rn(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Disponibilidad Actualizada?");
  if (r==true){url=murl+"?cod_presupd="+document.form1.txtcod_presupd.value+"&cod_presuph="+document.form1.txtcod_presuph.value+"&cod_fuented="+document.form1.txtcod_fuented.value+"&cod_fuenteh="+document.form1.txtcod_fuenteh.value+"&tipo_rpt="+document.form1.tipo_rpt.value;
  window.open(url,"Reporte Disponibilidad Actualizada")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>
</head>
<?$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"];} $l=strlen($formato_presup);
$sql="Select max(cod_presup) As max_cod_presup, min(cod_presup) As min_cod_presup from pre001 where (length(Cod_Presup)=".$l.")"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_presup_d=$registro["min_cod_presup"];  $cod_presup_h=$registro["max_cod_presup"];}
$sql="SELECT min(cod_fuente_financ) as min_fuente, max(cod_fuente_financ) as max_fuente  from pre095"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_fuente_d=$registro["min_fuente"];  $cod_fuente_h=$registro["max_fuente"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_d'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_d=$registro["des_fuente_financ"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_h'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_h=$registro["des_fuente_financ"];}
$cod_presup_d=str_replace("X","?",$formato_presup); $cod_presup_h=str_replace("X","?",$formato_presup);
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> REPORTE DE DISPONIBILIDAD ACTUALIZADA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="380" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="370"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:504px; height:340px; z-index:1; top: 81px; left: 42px;">
         <table width="828" border="0" align="center" >         
        <tr>
          <td height="19"><table width="766" border="0">
            <tr>
              <td width="325" height="26"><div align="right"> </div></td>
              <td width="223"><span class="Estilo15"><?echo $titulo?></span></td>
              <td width="204">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="30"><table width="813" border="0">
            <tr>
              <td width="326" height="26"><div align="right"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO DESDE : </span></div></td>
              <td width="221"><span class="Estilo5"><input class="Estilo10" name="txtcod_presupd" type="text" id="txtcod_presupd" size="35" maxlength="32" value="<?echo $cod_presup_d?>" onFocus="encender(this); " onBlur="apagar(this);">  </span></td>
              <td width="252"><span class="Estilo5"><input class="Estilo10" name="btCodPre" type="button" id="btCodPre" title="Abrir Catalogo Codigos Presupuestarios"  onClick="VentanaCentrada('../Cat_codigos_presupd.php?criterio=','SIA','','750','500','true')" value="...">   </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="827" border="0">
            <tr>
              <td width="223" height="26">  <div align="left"></div></td>
              <td width="98"><div align="right"><span class="Estilo5">HASTA :</span></div></td>
              <td width="222"><span class="Estilo5"><input class="Estilo10" name="txtcod_presuph" type="text" id="txtcod_presuph" size="35" maxlength="32" value="<?echo $cod_presup_h?>" onFocus="encender(this); " onBlur="apagar(this);">    </span></td>
              <td width="266"><span class="Estilo5"><input class="Estilo10" name="btCodPre2" type="button" id="btCodPre2" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onClick="VentanaCentrada('../Cat_codigos_presuph.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0">
            <tr>
              <td width="321" height="26"><div align="right"><span class="Estilo5">FUENTE DE FINANCIAMIENTO DESDE : </span></div></td>
              <td width="62"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuented" type="text" id="txtcod_fuented" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="5" value="<?echo $cod_fuente_d?>">   </span></td>
              <td width="45"><span class="Estilo5"><input class="Estilo10" name="btfuented" type="button" id="btfuented" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('../Cat_fuentesd.php?criterio=','SIA','','750','500','true')" value="...">    </span></td>
              <td width="381"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuented" type="text" id="txtdes_fuented" size="90" maxlength="90"  value="<?echo $des_fuente_d?>" readonly>  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="828" border="0">
            <tr>
              <td width="243" height="26"></td>
              <td width="75"><div align="right"><span class="Estilo5">HASTA : </span></div></td>
              <td width="61"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuenteh" type="text" id="txtcod_fuenteh" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="5" value="<?echo $cod_fuente_h?>">   </span></td>
              <td width="46"><span class="Estilo5"><input class="Estilo10" name="btfuenteh" type="button" id="btfuenteh" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('../Cat_fuentesh.php?criterio=','SIA','','750','500','true')" value="...">    </span></td>
              <td width="381"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuenteh" type="text" id="txtdes_fuenteh" size="90" maxlength="90"  value="<?echo $des_fuente_h?>" readonly>  </span></td>
            </tr>
          </table></td>
        </tr>
		<tr><td>&nbsp;</td></tr>
		   <tr>
            <td><table width="813" border="0" >
               <tr>
                 <td width="326"  align="right" class="Estilo5">TIPO SALIDA DEL REPORTE :</td>
				 <td width="474" align="left"><span class="Estilo5"><select class="Estilo10" name="tipo_rpt" id="tipo_rpt"> <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option>  </select></span></td>
              </tr>
             </table></td>
           </tr>
           <script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>
         
		<tr><td>&nbsp;</td></tr>
           <tr>
             <td><table width="905">
               <tr>
                 <th width="446" scope="col"><div align="center"> <input  name="btgenerar" type="button" id="btgenerar" value="GENERAR" onClick="javascript:Llama_Rpt_dispo_actu_rn('Rpt_dispo_actu_rn.php');">  </div></th>
                 <th width="447" scope="col"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"></th>
               </tr>
             </table></td>
           </tr>
         </table>
         <p align="left">&nbsp;</p>
       </div>
    </form>    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<? pg_close();?>
