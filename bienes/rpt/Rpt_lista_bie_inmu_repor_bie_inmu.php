<?php include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="Javascript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="03-0000150"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="Javascript"> document.location='../menu.php';</script><?php }
$cod_bien_inmd=""; $cod_bien_inmh="";   $cod_empresad=""; $cod_empresah="zzz"; $cod_dependenciad=""; $cod_dependenciah=""; $cod_direcciond=""; $cod_direccionh=""; $cod_departamentod=""; $cod_departamentoh=""; 
$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer); $fecha_d="01/01/1900";  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Reportes Listado De Bienes Inmuebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="Javascript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="Javascript" type="text/Javascript">
function checkrefechad(mform){var mref;var mfec;  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){   mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);     mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref;var mfec;  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){  mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);   mform.txtFechah.value=mfec;}
return true;}
function Llama_Rpt_lista_bie_mue_repor(murl){var url;var r; var tipo; var tord;
  if(document.form1.oporden[0].checked==true){tord="C";}  if(document.form1.oporden[1].checked==true){tord="N";}
  if(document.form1.bttipobien[0].checked==true){tipo="T";}  if(document.form1.bttipobien[1].checked==true){tipo="A";}  if(document.form1.bttipobien[2].checked==true){tipo="D";}
  r=confirm("Desea Generar el Reporte Listados Bienes Inmuebles?");
  if (r==true){url=murl+"?&cod_bien_inmd="+document.form1.txtcod_bien_inm_d.value+"&cod_bien_inmh="+document.form1.txtcod_bien_inm_h.value+
	"&cod_empresad="+document.form1.txtcod_empresad.value+"&cod_empresah="+document.form1.txtcod_empresah.value+"&cod_dependenciad="+document.form1.txtcod_dependenciad.value+"&cod_dependenciah="+document.form1.txtcod_dependenciah.value+
	"&cod_direcciond="+document.form1.txtcod_direcciond.value+"&cod_direccionh="+document.form1.txtcod_direccionh.value+"&cod_departamentod="+document.form1.txtcod_departamentod.value+"&cod_departamentoh="+document.form1.txtcod_departamentoh.value+
	"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&tipo_regis="+tipo+"&denominacion="+document.form1.txtdenominacion.value+"&tipo_rep="+document.form1.txttipo_rep.value+"&ordenado="+tord;
  window.open(url,"Reporte Listados Bienes Inmuebles")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

</head>
<?php 
//BIENES INMUEBLES
$sql="SELECT MAX(cod_bien_inm) As Max_cod_bien_inm, MIN(cod_bien_inm) As Min_cod_bien_inm FROM bien014";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_bien_inmd=$registro["min_cod_bien_inm"];$cod_bien_inmh=$registro["max_cod_bien_inm"];}
//EMPRESAS
$sql="SELECT MAX(cod_empresa) As Max_cod_empresa, MIN(cod_empresa) As Min_cod_empresa FROM bien007";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_empresad=$registro["min_cod_empresa"];$cod_empresah=$registro["max_cod_empresa"];}
$cod_empresad="000";
//DEPENDENCIAS
$sql="SELECT MAX(cod_dependencia) As Max_cod_dependencia, MIN(cod_dependencia) As Min_cod_dependencia FROM bien001";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_dependenciad=$registro["min_cod_dependencia"];$cod_dependenciah=$registro["max_cod_dependencia"];}
//DIRECCIONES
$sql="SELECT MAX(cod_direccion) As Max_cod_direccion, MIN(cod_direccion) As Min_cod_direccion FROM bien005";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_direcciond=$registro["min_cod_direccion"];$cod_direccionh=$registro["max_cod_direccion"];}
//DEPARTAMENTOS
$sql="SELECT MAX(cod_departamento) As Max_cod_departamento, MIN(cod_departamento) As Min_cod_departamento FROM bien006";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_departamentod=$registro["min_cod_departamento"];$cod_departamentoh=$registro["max_cod_departamento"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE LISTADO DE BIENES INMUEBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="442" border="1" id="tablacuerpo">
  <tr>
    <td width="970" height="436">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:856px; height:393px; z-index:1; top: 50px; left: 33px;">
        <form name="form1" method="get">
           <table width="950" height="408" border="0">
    <tr>
      <td width="950" height="404" align="center" valign="top"><table width="850" height="374" border="0" cellpadding="0" cellspacing="0">
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
                 <td width="230"><span class="Estilo5">C&Oacute;DIGO DEL BIEN INMUEBLE :</span></td>
                 <td width="320"><span class="Estilo5"><input name="txtcod_bien_inm_d" type="text" class="Estilo5" id="txtcod_bien_inm_d" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" value="<?php echo $cod_bien_inmd?>">
                    <input name="btcat_biend" type="button" id="btcat_biend" title="Abrir Catalogo de Bienes Muebles" onClick="VentanaCentrada('Cat_bienes_inmueblesd.php?criterio=','SIPAP','','750','500','true')" value="...">  </span></td>
                 <td width="300"><span class="Estilo5"><input name="txtcod_bien_inm_h" type="text" class="Estilo5" id="txtcod_bien_inm_h" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" value="<?php echo $cod_bien_inmh?>">
                     <input name="btcat_bienh" type="button" id="btcat_bienh" title="Abrir Catalogo de Bienes Muebles" onClick="VentanaCentrada('Cat_bienes_inmueblesh.php?criterio=','SIPAP','','750','500','true')" value="...">   </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
               <tr>
                 <td width="230"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></td>
                 <td width="320"><span class="Estilo5"><input name="txtcod_dependenciad" type="text" class="Estilo5" id="txtcod_dependenciad" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="4" class="Estilo10" value="<?php echo $cod_dependenciad?>" >
                   <input name="btcat_depd" type="button" id="btcat_depd" title="Abrir Catalogo Dependencias" onClick="VentanaCentrada('Cat_dependenciasd.php?criterio=','SIPAP','','750','500','true')" value="...">    </span></td>
                 <td width="300"><span class="Estilo5"><input name="txtcod_dependenciah" type="text" class="Estilo5" id="txtcod_dependenciah" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="4" class="Estilo10" value="<?php echo $cod_dependenciah?>">
                   <input name="btcat_deph" type="button" id="btcat_deph" title="Abrir Catalogo Dependencias" onClick="VentanaCentrada('Cat_dependenciash.php?criterio=','SIPAP','','750','500','true')" value="...">   </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
               <tr>
                 <td width="230"><span class="Estilo5">C&Oacute;DIGO DIRECCI&Oacute;N :</span></td>
                 <td width="320"><span class="Estilo5"><input name="txtcod_direcciond" type="text" class="Estilo5" id="txtcod_direcciond" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="4" class="Estilo10" value="<?php echo $cod_direcciond?>" >
                   <input name="btcod_dird" type="button" id="btcod_dird" title="Abrir Catalogo Direcciones" onClick="VentanaCentrada('Cat_direcciond.php?criterio=','SIPAP','','750','500','true')" value="...">  </span></td>
                 <td width="300"><span class="Estilo5"><input name="txtcod_direccionh" type="text" class="Estilo5" id="txtcod_direccionh" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="4" class="Estilo10" value="<?php echo $cod_direccionh?>" >
                   <input name="btcod_dirh" type="button" id="btcod_dirh" title="Abrir Catalogo Direcciones" onClick="VentanaCentrada('Cat_direccionh.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
               <tr>
                 <td width="230"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></td>
                 <td width="320"><span class="Estilo5"><input name="txtcod_departamentod" type="text" class="Estilo5" id="txtcod_departamentod" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" value="<?php echo $cod_departamentod?>">
                      <input name="btcod_depd" type="button" id="btcod_depd" title="Abrir Catalogo Departamentos" onClick="VentanaCentrada('Cat_departamentod.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
                 <td width="300"><span class="Estilo5">  <input name="txtcod_departamentoh" type="text" class="Estilo5" id="txtcod_departamentoh" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" value="<?php echo $cod_departamentoh?>">
                     <input name="btcod_deph" type="button" id="btcod_deph" title="Abrir Catalogo Departamentos" onClick="VentanaCentrada('Cat_departamentoh.php?criterio=','SIPAP','','750','500','true')" value="...">  </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="850">
               <tr>
                 <td width="230"><span class="Estilo5">C&Oacute;DIGO EMPRESA :</span></td>
                 <td width="320"><span class="Estilo5"><input name="txtcod_empresad" type="text" class="Estilo5" id="txtcod_empresad" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" value="<?php echo $cod_empresad?>">
                      <input name="btcod_depd" type="button" id="btcod_depd" title="Abrir Catalogo Empresas" onClick="VentanaCentrada('Cat_empresasd.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
                 <td width="300"><span class="Estilo5">  <input name="txtcod_empresah" type="text" class="Estilo5" id="txtcod_empresah" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" value="<?php echo $cod_empresah?>">
                     <input name="btcod_deph" type="button" id="btcod_deph" title="Abrir Catalogo Empresas" onClick="VentanaCentrada('Cat_empresash.php?criterio=','SIPAP','','750','500','true')" value="...">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
               <tr>
                 <td width="230"><span class="Estilo5">FECHA DE INCORPORACI&Oacute;N :</span></td>
                 <td width="320"><span class="Estilo5"> <input name="txtFechad" type="text" class="Estilo5" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_d?>" size="12" maxlength="10" class="Estilo5" onChange="checkrefechad(this.form)">
                    <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                        onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
                <td width="300"><span class="Estilo5"><input name="txtFechah" type="text" class="Estilo5" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_h?>" size="12" maxlength="10" class="Estilo5" onChange="checkrefechah(this.form)">
                    <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                        onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="19"><table width="850">
               <tr>
                 <td width="230"><span class="Estilo5">FILTRO DE DESCRIPCI&Oacute;N DEL BIEN :</span></div></td>
                 <td width="620"><span class="Estilo5"> <input name="txtdenominacion" type="text" class="Estilo5" id="txtdenominacion" size="70" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="19"><table width="850" border="0" cellspacing="1" cellpadding="1" >
			   <tr>
			       <td width="230"><span class="Estilo5">ESTATUS DEL BIEN :</span></div></td>                
				   <td width="620"><table width="500" border="1" cellspacing="0" cellpadding="0" >
				   <tr>
					 <td width="150"><div align="center"><span class="Estilo5"> <input name="bttipobien" type="radio" value="T" checked> TODOS</span></div></td>
					 <td width="150"><div align="center"><span class="Estilo5"><input name="bttipobien" type="radio" value="A"> ACTIVOS</span></div>  </td>
					 <td width="200"><div align="center"><span class="Estilo5"><input name="bttipobien" type="radio" value="D">DESINCORPORADOS </span> </div> </td>
				   </tr>
				 </table></td>
			   </tr>
             </table></td>
           </tr>
		   <tr><td height="19">&nbsp;</td></tr>
		   <tr>
			  <td height="19"><table width="850" border="0">
				<tr>
				  <td width="230"><span class="Estilo5">TIPO DE REPORTE : </span></td>
				  <td width="200"><span class="Estilo5"><select name="txttipo_rep" size="1" id="txttipo_rep" onFocus="encender(this)" onBlur="apagar(this)">
				         <option value='PDF'>FORMATO PDF</option> <option value='PDF2'>FORMATO PDF2</option> <option value='EXCEL'>FORMATO EXCEL</option></select></td>						 
				  <td width="140"><span class="Estilo5">ORDENADO POR :</span></td>
			      <td width="280"><table width="255" height="30" border="1">				  
				    <tr>  
				      <td width="250">
					      <table width="255" height="30" border="0">
						  <tr>
							<td width="125" valign="top"><span class="Estilo5"><input name="oporden" type="radio" value="C" checked> CODIGO </span></td>
							<td width="125" valign="top"><span class="Estilo5"><input name="oporden" type="radio" value="N"> NUMERO </span></td>
						  </tr>
					  </table></td>
					</tr> 
				   </table></td>			 
				</tr>
			  </table></td>
		   </tr>
<script language="Javascript" type="text/Javascript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.txttipo_rep.options[0].selected = true;}else{document.form1.txttipo_rep.options[1].selected = true;} </script>
            <tr><td height="19">&nbsp;</td></tr>
			<tr><td height="19">&nbsp;</td></tr>
           <tr>		      
             <td><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr align="center" valign="middle">
			     <td> <div align="center"><input name="btgenerar" type="button" id="btgenerar" value="GENERAR" onClick="javascript:Llama_Rpt_lista_bie_mue_repor('Rpt_lista_bie_inmue_repor.php');">   </div></td>
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
<?php  pg_close($conn);?>
