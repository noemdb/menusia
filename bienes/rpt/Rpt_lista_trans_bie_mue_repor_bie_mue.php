<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="03-0000120"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_d="01/01/1900";  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer); $cod_empresad=""; $cod_empresah="zzz"; $cod_dependenciad=""; $cod_dependenciah=""; $cod_direcciond=""; $cod_direccionh="";
$cod_bien_mued=""; $cod_bien_mueh="";   $referenciad=""; $referenciah=""; $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Reportes Listado de Transferencia Bienes Muebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="Javascript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">

function checkrefechad(mform){var mref;var mfec;  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){   mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);     mform.txtFechad.value=mfec;}
return true;}

function checkrefechah(mform){var mref;var mfec;  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){  mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);   mform.txtFechah.value=mfec;}
return true;}

function Llama_Rpt_lista_trans_bie_mue_repor_bie(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Listados de Transferencias de Bienes Muebles?");
  if (r==true){url=murl+"?&referencia_transfd="+document.form1.txtreferencia_d.value+"&referencia_transfh="+document.form1.txtreferencia_h.value+
     "&cod_bien_mued="+document.form1.txtcod_bien_mue_d.value+"&cod_bien_mueh="+document.form1.txtcod_bien_mue_h.value+
     "&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&tipo_rep="+document.form1.txttipo_rep.value;
     window.open(url,"Reporte Listados de Transferencias de Bienes Muebles");
  
  }
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}

</script>
</head>
<?
//BIENES MUEBLES
$sql="SELECT MAX(cod_bien_mue) As Max_cod_bien_mue, MIN(cod_bien_mue) As Min_cod_bien_mue FROM bien015";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_bien_mued=$registro["min_cod_bien_mue"];$cod_bien_mueh=$registro["max_cod_bien_mue"];}
//TRANSFERENCIAS
$sql="SELECT MAX(referencia_transf) As Max_referencia_transf, MIN(referencia_transf) As Min_referencia_transf FROM bien036";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$referenciad=$registro["min_referencia_transf"];$referenciah=$registro["max_referencia_transf"];}
//DEPENDENCIAS
$sql="SELECT MAX(cod_dependencia) As Max_cod_dependencia, MIN(cod_dependencia) As Min_cod_dependencia FROM bien001";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_dependenciad=$registro["min_cod_dependencia"];$cod_dependenciah=$registro["max_cod_dependencia"];}
//EMPRESAS
$sql="SELECT MAX(cod_empresa) As Max_cod_empresa, MIN(cod_empresa) As Min_cod_empresa FROM bien007";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_empresad=$registro["min_cod_empresa"];$cod_empresah=$registro["max_cod_empresa"];}
$cod_empresad="000";
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE LISTADO TRANSFERENCIAS DE BIENES MUEBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="422" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="416">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:393px; z-index:1; top: 73px; left: 23px;">
        <form name="form1" method="get">
           <table width="950" height="388" border="0">
    <tr>
      <td width="958" height="384" align="center" valign="top"><table width="783" height="274" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
		<tr>
          <td height="19"><table width="850" border="0">
            <tr>
              <td width="230" height="26"><div align="right"> </div></td>
              <td width="320"><span class="Estilo13"><strong>DESDE</strong></span></td>
              <td width="300"><span class="Estilo13"><strong>HASTA</strong></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
           <tr>
             <td><table width="850">
               <tr>
                 <td width="230"><span class="Estilo5">C&Oacute;DIGO DEL BIEN MUEBLE :</span></td>
                 <td width="320"><span class="Estilo5"><input name="txtcod_bien_mue_d" type="text" class="Estilo5" id="txtcod_bien_mue_d" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" value="<?echo $cod_bien_mued?>">
                    <input name="btcat_biend" type="button" id="btcat_biend" title="Abrir Catalogo de Bienes Muebles" onClick="VentanaCentrada('Cat_bienes_mueblesd.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
                 <td width="300"><span class="Estilo5"><input name="txtcod_bien_mue_h" type="text" class="Estilo5" id="txtcod_bien_mue_h" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" value="<?echo $cod_bien_mueh?>">
                     <input name="btcat_bienh" type="button" id="btcat_bienh" title="Abrir Catalogo de Bienes Muebles" onClick="VentanaCentrada('Cat_bienes_mueblesh.php?criterio=','SIA','','750','500','true')" value="...">   </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
               <tr>
                 <td width="230"><span class="Estilo5">C&Oacute;DIGO DE DEPENDENCIA :</span></td>
                 <td width="320"><span class="Estilo5"><input name="txtcod_dependenciad" type="text" class="Estilo5" id="txtcod_dependenciad" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="4" class="Estilo5" value="<?echo $cod_dependenciad?>" >
                   <input name="btcat_depd" type="button" id="btcat_depd" title="Abrir Catalogo Dependencias" onClick="VentanaCentrada('Cat_dependenciasd.php?criterio=','SIA','','750','500','true')" value="...">    </span></td>
                 <td width="300"><span class="Estilo5"><input name="txtcod_dependenciah" type="text" class="Estilo5" id="txtcod_dependenciah" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="4" class="Estilo5" value="<?echo $cod_dependenciah?>">
                   <input name="btcat_deph" type="button" id="btcat_deph" title="Abrir Catalogo Dependencias" onClick="VentanaCentrada('Cat_dependenciash.php?criterio=','SIA','','750','500','true')" value="...">   </span></td>
                 </tr>
             </table></td>
           </tr>
		   
           <tr>
             <td><table width="850">
               <tr>
                 <td width="230"><span class="Estilo5">REFERENCIA :</span> </td>
				 <td width="320"><span class="Estilo5"> <input name="txtreferencia_d" type="text" id="txtreferencia_d" onFocus="encender(this)" onBlur="apaga_referenciad(this)" value="<?echo $referenciad?>" size="10" maxlength="8" class="Estilo5">  </span></td>
                 <td width="300"><span class="Estilo5"><input name="txtreferencia_h" type="text" id="txtreferencia_h" onFocus="encender(this)" onBlur="apaga_referenciah(this)" value="<?echo $referenciah?>" size="10" maxlength="8" class="Estilo5">  </span></td>          
				</tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
               <tr>
                 <td width="230"><span class="Estilo5">FECHA  :</span></td>
                 <td width="320"><span class="Estilo5"> <input name="txtFechad" type="text" class="Estilo5" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" class="Estilo5" onChange="checkrefechad(this.form)">
                    <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                        onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
                <td width="300"><span class="Estilo5"><input name="txtFechah" type="text" class="Estilo5" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" class="Estilo5" onChange="checkrefechah(this.form)">
                    <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                        onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
               </tr>
             </table></td>
           </tr>
		   <tr><td height="19">&nbsp;</td></tr>
		   <tr>
			  <td height="19"><table width="850" border="0">
				<tr>
				  <td width="230"><span class="Estilo5">TIPO DE REPORTE : </span></td>
				  <td width="620"><span class="Estilo5"><select name="txttipo_rep" size="1" id="txttipo_rep" onFocus="encender(this)" onBlur="apagar(this)">
				    <option value='HTML'>FORMATO HTML</option>   <option value='PDF'>FORMATO PDF</option> </select></td>	  
				</tr>
			  </table></td>
		   </tr>
           <tr><td height="19">&nbsp;</td></tr>	
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.txttipo_rep.options[1].selected = true;}else{document.form1.txttipo_rep.options[0].selected = true;} </script>
		   
            <tr><td height="19">&nbsp;</td></tr>
			<tr><td height="19">&nbsp;</td></tr>
			<tr>		      
             <td><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr align="center" valign="middle">
			     <td width="5"><input name="txtcod_empresad" type="hidden" id="txtcod_empresad" value="<?echo $cod_empresad?>" ></td>
                 <td width="5"><input name="txtcod_empresah" type="hidden" id="txtcod_empresah" value="<?echo $cod_empresah?>" ></td>
                 <td> <div align="center"><input name="btgenerar" type="button" id="btgenerar" value="GENERAR" onClick="javascript:Llama_Rpt_lista_trans_bie_mue_repor_bie('Rpt_lista_trans_bie_mue_repor_bie.php');">   </div></td>
                 <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">    </div></td> 
               </tr>
             </table></td>
           </tr>
         </table>
         <p>&nbsp;</p>
       </div>
         </form>    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<? pg_close();?>


