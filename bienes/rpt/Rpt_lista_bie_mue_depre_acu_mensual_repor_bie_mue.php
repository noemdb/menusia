<?php include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="03-0000132"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?php }
$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_d="01/01/1900";  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer); $cod_dependenciah=""; $cod_direcciond=""; 
$cod_bien_mued=""; $cod_bien_mueh="";   $referenciad=""; $referenciah=""; $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
//echo $fecha_d." ".$fecha_h;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Reportes Depreciacion Acumulada Mensual)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref; var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){  mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7);    mform.txtFechad.value=mfec; }  
return true;}
function Llama_Rpt_lista_bie_mue_depre_acu_mensual_repor_bie(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Listados Bienes Muebles?");
  if (r==true){url=murl+"?&fecha_d="+document.form1.txtFechad.value+"&acum="+document.form1.txtacum.value+"&subt_mes="+document.form1.txtsubt_mes.value+"&dep_mes="+document.form1.txtdep_mes.value;
  window.open(url,"Reporte Listados Bienes Muebles")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>
</head>
<?php 
//BIENES MUEBLES
$sql="SELECT MAX(cod_bien_mue) As Max_cod_bien_mue, MIN(cod_bien_mue) As Min_cod_bien_mue FROM bien015";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_bien_mued=$registro["min_cod_bien_mue"];$cod_bien_mueh=$registro["max_cod_bien_mue"];}
//DEPENDENCIAS
$sql="SELECT MAX(cod_dependencia) As Max_cod_dependencia, MIN(cod_dependencia) As Min_cod_dependencia FROM bien001";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_dependenciad=$registro["min_cod_dependencia"];$cod_dependenciah=$registro["max_cod_dependencia"];}
//REFERENCIAS
$sql="SELECT MAX(fecha_dep) As max_fecha_dep, MIN(fecha_dep) As min_fecha_dep FROM bien028";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$fecha_h=$registro["max_fecha_dep"]; if($fecha_h==""){$fecha_h=$fecha_d;}else{$fecha_h=formato_ddmmaaaa($fecha_h);}}

?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE DEPRECIACI&Oacute;N ACUMULADA MENSUAL</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="282" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="276">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:393px; z-index:1; top: 53px; left: 23px;">
        <form name="form1" method="get">
           <table width="950" height="388" border="0">
    <tr>
      <td width="958" height="384" align="center" valign="top"><table width="783" height="274" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
           <tr>
             <td><table width="850">
               <tr>
                 <td width="230"><span class="Estilo5">FECHA DEPRECIACION :</span></td>
                 <td width="320"><span class="Estilo5"> <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                    <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                        onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
                <td width="300"></td>
               </tr>
             </table></td>
           </tr>
		    <tr>
             <td height="19">&nbsp;</td>
           </tr>
		   <tr>
			  <td height="19"><table width="850" border="0">
				<tr>
				  <td width="230"><span class="Estilo5">MOSTRAR DEPRECIACION MENSUAL : </span></td>
				  <td width="620"><span class="Estilo5"><select name="txtdep_mes" size="1" id="txtdep_mes" onFocus="encender(this)" onBlur="apagar(this)">
				    <option value='NO'>NO</option>   <option value='SI'>SI</option> </select></td>	  
				</tr>
			  </table></td>
		   </tr>
		   <tr>
             <td height="19">&nbsp;</td>
           </tr>
		   <tr>
			  <td height="19"><table width="850" border="0">
				<tr>
				  <td width="230"><span class="Estilo5">ACUMULADO POR CLASIFICACION : </span></td>
				  <td width="620"><span class="Estilo5"><select name="txtacum" size="1" id="txtacum" onFocus="encender(this)" onBlur="apagar(this)">
				    <option value='NO'>NO</option>   <option value='SI'>SI</option> </select></td>	  
				</tr>
			  </table></td>
		   </tr>
		   <tr>
             <td height="19">&nbsp;</td>
           </tr>
		   <tr>
			  <td height="19"><table width="850" border="0">
				<tr>
				  <td width="230"><span class="Estilo5">SUBTOTAL POR MES : </span></td>
				  <td width="620"><span class="Estilo5"><select name="txtsubt_mes" size="1" id="txtsubt_mes" onFocus="encender(this)" onBlur="apagar(this)">
				    <option value='NO'>NO</option>   <option value='SI'>SI</option> </select></td>	  
				</tr>
			  </table></td>
		   </tr>
		   <tr>
             <td height="19">&nbsp;</td>
           </tr>
           <tr>
             <td><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr align="center" valign="middle">
                 <td> <div align="center"><input name="btgenerar" type="button" id="btgenerar" value="GENERAR" onClick="javascript:Llama_Rpt_lista_bie_mue_depre_acu_mensual_repor_bie('Rpt_cuad_dep_mensual_mue.php');">   </div></td>
                 <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">   </div></td>
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
<?php  pg_close($conn);?>
