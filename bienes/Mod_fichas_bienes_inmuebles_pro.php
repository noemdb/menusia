<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); $cod_modulo="13";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$cod_bien_inm='';}else {$cod_bien_inm=$_GET["Gcod_bien_inm"];}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Modificar Ficha de Bienes Inmuebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llama_cat_decripciones(){ var mcod_c;  mcod_c=document.form1.txtcod_clasificacion.value; 
  VentanaCentrada('Cat_descrip_bienes.php?codigo_c='+mcod_c+'&criterio=','SIPAP','','750','500','true')
}
function llama_cat_dir(mform){  var mcod_dep; var murl; mcod_dep=mform.txtcod_dependencia.value;
  murl='Cat_direcc_dep.php?cod_dependen='+mcod_dep+'&criterio=';   VentanaCentrada(murl,'SIPAP','','750','500','true');
return true;}
function llama_cat_dep(mform){  var mcod_dep; var murl;  var mcod_dir;
   mcod_dep=mform.txtcod_dependencia.value; mcod_dir=mform.txtcod_direccion.value;
  murl='Cat_departamentos.php?cod_dependen='+mcod_dep+'&cod_direccion='+mcod_dir+'&criterio=';   VentanaCentrada(murl,'SIPAP','','750','500','true');
return true;}
function chequea_fecha(mthis){var mref; var mfec;   mref=mthis.value; 
  if(mref.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7); mthis.value=mfec;}
return true;}
function checkrefechaac(mform){var mref; var mfec;  mref=mform.txtfecha_actualizacion.value;
  if(mform.txtfecha_actualizacion.value.length==8){mfec=mref.substring(0,6)+"20"+ mref.charAt(6)+mref.charAt(7); mform.txtfecha_actualizacion.value=mfec;}
return true;}
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function revisar(){var f=document.form1;
    if(f.txtcod_clasificacion.value==""){alert("Codigo de Clasificacion no puede estar Vacio");return false;}else{f.txtcod_clasificacion.value=f.txtcod_clasificacion.value.toUpperCase();}
    if(f.txtnum_bien.value==""){alert("Numero del Bien no puede estar Vacio"); return false; } else{f.txtnum_bien.value=f.txtnum_bien.value.toUpperCase();}
    if(f.txtcod_bien_inm.value==""){alert("Codigo del Bien no puede estar Vacio");return false;}else{f.txtcod_bien_inm.value=f.txtcod_bien_inm.value.toUpperCase();}
    if(f.txtdenominacion.value==""){alert("Denominacion no puede estar Vacia"); return false; } else{f.txtdenominacion.value=f.txtdenominacion.value.toUpperCase();}
    if(f.txtcod_dependencia.value==""){alert("Codigo Dependencia no puede estar Vacio");return false;}else{f.txtcod_dependencia.value=f.txtcod_dependencia.value.toUpperCase();}
    if(f.txtcod_direccion.value==""){alert("Codigo Direccion no puede estar Vacia");return false;}else{f.txtcod_direccion.value=f.txtcod_direccion.value.toUpperCase();}
    if(f.txtcod_departamento.value==""){alert("Codigo Departamento no puede estar Vacio");return false;}else{f.txtcod_departamento.value=f.txtcod_departamento.value.toUpperCase();}
    if(f.txtdescripcion.value==""){alert("Descripcion no puede estar Vacio");return false;}else{f.txtdescripcion.value=f.txtdescripcion.value.toUpperCase();} 
    if(f.txtarea_inmueble.value==""){alert("Area del Inmuebles no puede estar Vacio"); return false; } else{f.txtarea_inmueble.value=f.txtarea_inmueble.value.toUpperCase();}
    if(f.txtarea_terreno.value==""){alert("Area del Terreno no puede estar Vacio"); return false; } else{f.txtarea_terreno.value=f.txtarea_terreno.value.toUpperCase();}
    if(f.txtarea_construccion.value==""){alert("Area de Construccion no puede estar Vacio"); return false; } else{f.txtarea_construccion.value=f.txtarea_construccion.value.toUpperCase();}
    if(f.txtced_responsable.value==""){alert("Cedula del responsable Primario no estar Vacia"); return false; } else{f.txtced_responsable.value=f.txtced_responsable.value.toUpperCase();}
    if(f.txtdireccion.value==""){alert("Direccion no estar Vacia"); return false; } else{f.txtdireccion.value=f.txtdireccion.value.toUpperCase();}
    if(f.txtcod_region.value==""){alert("Codigo Region no puede estar Vacio"); return false; } else{f.txtcod_region.value=f.txtcod_region.value.toUpperCase();}
    if(f.txtcod_entidad.value==""){alert("Codigo de la Entidad no puede estar Vacio"); return false; } else{f.txtcod_entidad.value=f.txtcod_entidad.value.toUpperCase();}
    if(f.txtcod_municipio.value==""){alert("Codigo del Municipio no puede estar Vacio"); return false; } else{f.txtcod_municipio.value=f.txtcod_municipio.value.toUpperCase();}
    if(f.txtcod_ciudad.value==""){alert("Codigo de la Ciudad no puede estar Vacio"); return false; } else{f.txtcod_ciudad.value=f.txtcod_ciudad.value.toUpperCase();}
    if(f.txtcod_parroquia.value==""){alert("Codigo de Parroquia no puede estar Vacio"); return false; } else{f.txtcod_parroquia.value=f.txtcod_parroquia.value.toUpperCase();}
    if(f.txtsit_contable.value==""){alert("Codigo Situacion Contable no debe estar Vacia"); return false; } else{f.txtsit_contable.value=f.txtsit_contable.value.toUpperCase();}
    if(f.txtdesincorporado.value==""){alert("Valor Desincorporado no puede estar Vacio"); return false; } else{f.txtdesincorporado.value=f.txtdesincorporado.value.toUpperCase();}
    if(f.txtedo_conservacion.value==""){alert("Codigo Estado de Conservacion no puede estar Vacio"); return false; } else{f.txtedo_conservacion.value=f.txtedo_conservacion.value.toUpperCase();}
    if(f.txtced_res_verificador.value==""){alert("Cedula Responsable Verificador no puede estar Vacio"); return false; } else{f.txtced_res_verificador.value=f.txtced_res_verificador.value.toUpperCase();}
    if(f.txtfecha_verificacion.value==""){alert("Fecha de Verificacion no puede estar Vacio"); return false; } else{f.txtfecha_verificacion.value=f.txtfecha_verificacion.value.toUpperCase();}
    if(f.txttipo_incorporacion.value==""){alert("Tipo de Incorporacion no puede estar Vacio"); return false; } else{f.txttipo_incorporacion.value=f.txttipo_incorporacion.value.toUpperCase();}
    if(f.txtfecha_incorporacion.value==""){alert("Fecha de Incorporacion no puede estar Vacio"); return false; } else{f.txtfecha_incorporacion.value=f.txtfecha_incorporacion.value.toUpperCase();}
    if(f.txtvalor_incorporacion.value==""){alert("Valor de Incorporacion no puede estar Vacio"); return false; } else{f.txtvalor_incorporacion.value=f.txtvalor_incorporacion.value.toUpperCase();}
    if(f.txcodigo_tipo_incorp.value==""){alert("Codigo Tipo de Incorporacion no puede estar Vacio"); return false; } else{f.txcodigo_tipo_incorp.value=f.txcodigo_tipo_incorp.value.toUpperCase();}
    r=confirm("Desea Grabar la Ficha del Bien Inmueble ?");  if (r==true) { valido=true;} else{return false;}   
    document.form1.submit;
return true;}
</script>
<style type="text/css">
</style>
</head>
<?php 
$cod_clasificacion="";$num_bien="";$denominacion="";$cod_dependencia="";$cod_empresa="";$cod_direccion="";$cod_departamento="";$descripcion="";$area_inmueble="";$area_terreno="";$area_construccion="";$caracteristicas="";$ced_responsable="";$fecha_actualizacion="";$direccion="";$cod_region="";$cod_entidad="";$cod_municipio="";$cod_ciudad="";$cod_parroquia="";$cod_postal="";$tiene_planos="";$lindero_norte="";$lindero_sur="";$lindero_este="";$lindero_oeste="";$observacion="";$ofic_registro="";$numero="";$tomo="";$folio="";$protocolo="";$fecha_doc="";$sit_legal="";$estudio_legal="";$cod_contablea="";$cod_contabled="";$tipo_depreciacion="";$tasa_deprec="";$vida_util="";$valor_residual="";
$cod_presup_dep="";$monto_depreciado="";$desincorporado="";$fecha_desincorporado="";$sit_contable="";$edo_conservacion="";$ced_verificador="";$fecha_verificacion="";$codigo_tipo_incorp="";$tipo_incorporacion="";$cod_imp_presup="";$nom_imp_presup="";$des_imp_nopresup="";$valor_incorporacion="";$fecha_incorporacion="";$nro_oc="";$fecha_oc="";$nro_op="";$fecha_op="";$tipo_doc_cancela="";$nro_doc_cancela="";$fecha_doc_cancela="";$nro_factura="";$fecha_factura="";$ced_rif_proveedor="";$nom_proveedor=""; $descripcion_b="";  $denominacion_empresa=""; $denominacion_dependencia=""; $denominacion_dir="";$denominacion_dep="";  $nombre_res="";  $nombre_res_uso="";  $metodo_rotula="";  $nombre_res_rotu="";$nombre_region="";  $estado="";  $nombre_municipio=""; $nombre_ciudad="";  $nombre_parroquia=""; $tipo_situacion_cont="";  $tipo_situacion_legal=""; $edo_bien="";  $nombre_res_ver=""; $denomina_tipo="";
$sql="SELECT * From BIEN014 where cod_bien_inm='$cod_bien_inm'"; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); 
$cod_bien_inm=$registro["cod_bien_inm"];$cod_clasificacion=$registro["cod_clasificacion"];$num_bien=$registro["num_bien"];
$denominacion=$registro["denominacion"];$cod_dependencia=$registro["cod_dependencia"];$cod_empresa=$registro["cod_empresa"];
$cod_direccion=$registro["cod_direccion"];$cod_departamento=$registro["cod_departamento"];$descripcion=$registro["descripcion"];
$area_inmueble=$registro["area_inmueble"];$area_terreno=$registro["area_terreno"];$area_construccion=$registro["area_construccion"];
$caracteristicas=$registro["caracteristicas"];$ced_responsable=$registro["ced_responsable"];$fecha_actualizacion=$registro["fecha_actualizacion"];
$direccion=$registro["direccion"];$cod_region=$registro["cod_region"];$cod_entidad=$registro["cod_entidad"];
$cod_municipio=$registro["cod_municipio"];$cod_ciudad=$registro["cod_ciudad"];$cod_parroquia=$registro["cod_parroquia"];
$cod_postal=$registro["cod_postal"];$tiene_planos=$registro["tiene_planos"];$lindero_norte=$registro["lindero_norte"];
$lindero_sur=$registro["lindero_sur"];$lindero_este=$registro["lindero_este"];$lindero_oeste=$registro["lindero_oeste"];
$observacion=$registro["observacion"];$ofic_registro=$registro["ofic_registro"];$numero=$registro["numero"];
$tomo=$registro["tomo"];$folio=$registro["folio"];$protocolo=$registro["protocolo"];$fecha_doc=$registro["fecha_doc"];
$sit_legal=$registro["sit_legal"];$estudio_legal=$registro["estudio_legal"];$cod_contablea=$registro["cod_contablea"];$cod_contabled=$registro["cod_contabled"];
$tipo_depreciacion=$registro["tipo_depreciacion"];$tasa_deprec=$registro["tasa_deprec"];$vida_util=$registro["vida_util"];
$valor_residual=$registro["valor_residual"];$cod_presup_dep=$registro["cod_presup_dep"];$monto_depreciado=$registro["monto_depreciado"];
$desincorporado=$registro["desincorporado"];$sit_contable=$registro["sit_contable"];
$edo_conservacion=$registro["edo_conservacion"];$ced_verificador=$registro["ced_verificador"];$fecha_verificacion=$registro["fecha_verificacion"];
$codigo_tipo_incorp=$registro["codigo_tipo_incorp"];$tipo_incorporacion=$registro["tipo_incorporacion"];$cod_imp_presup=$registro["cod_imp_presup"];
$nom_imp_presup=$registro["nom_imp_presup"];$des_imp_nopresup=$registro["des_imp_nopresup"];$valor_incorporacion=$registro["valor_incorporacion"];
$fecha_incorporacion=$registro["fecha_incorporacion"]; if($fecha_incorporacion==""){$fecha_incorporacion="";}else{$fecha_incorporacion=formato_ddmmaaaa($fecha_incorporacion);}
  
$nro_oc=$registro["nro_oc"];$fecha_oc=$registro["fecha_oc"]; if($fecha_oc==""){$fecha_oc="";}else{$fecha_oc=formato_ddmmaaaa($fecha_oc);}   
$nro_op=$registro["nro_op"];$fecha_op=$registro["fecha_op"]; if($fecha_op==""){$fecha_op="";}else{$fecha_op=formato_ddmmaaaa($fecha_op);}
$fecha_desincorporado=$registro["fecha_desincorporado"];if($fecha_desincorporado==""){$fecha_desincorporado="";}else{$fecha_desincorporado=formato_ddmmaaaa($fecha_desincorporado);}
$tipo_doc_cancela=$registro["tipo_doc_cancela"];$nro_doc_cancela=$registro["nro_doc_cancela"];$fecha_doc_cancela=$registro["fecha_doc_cancela"]; if($fecha_factura==""){$fecha_factura="";}else{$fecha_factura=formato_ddmmaaaa($fecha_factura);}
$nro_factura=$registro["nro_factura"];$fecha_factura=$registro["fecha_factura"];if($fecha_factura==""){$fecha_factura="";}else{$fecha_factura=formato_ddmmaaaa($fecha_factura);}
$ced_rif_proveedor=$registro["ced_rif_proveedor"];$nom_proveedor=$registro["nom_proveedor"]; $fecha_op=$registro["fecha_op"];
}
if($fecha_actualizacion==""){$fecha_actualizacion="";}else{$fecha_actualizacion=formato_ddmmaaaa($fecha_actualizacion);}
if($fecha_doc==""){$fecha_doc="";}else{$fecha_doc=formato_ddmmaaaa($fecha_doc);}
if($fecha_verificacion==""){$fecha_verificacion="";}else{$fecha_verificacion=formato_ddmmaaaa($fecha_verificacion);}
if($fecha_op==""){$fecha_op="";}else{$fecha_op=formato_ddmmaaaa($fecha_op);}
if($fecha_doc_cancela==""){$fecha_doc_cancela="";}else{$fecha_doc_cancela=formato_ddmmaaaa($fecha_doc_cancela);} 
//Clasificacion
$Ssql="SELECT grupo_c,codigo_c,denominacion_c  FROM BIEN008 where codigo_c='".$cod_clasificacion."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$descripcion_b=$registro["denominacion_c"];}
//Empresa
$Ssql="SELECT * FROM bien007 where cod_empresa='".$cod_empresa."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_empresa=$registro["denominacion_emp"];}
//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dependencia=$registro["denominacion_dep"];}
//Direcciones
$Ssql="SELECT * FROM bien005 where cod_dependencia='".$cod_dependencia."' and cod_direccion='".$cod_direccion."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dir=$registro["denominacion_dir"];}
//Departamento
$Ssql="SELECT * FROM bien006 where cod_dependencia='".$cod_dependencia."' and cod_direccion='".$cod_direccion."' and cod_departamento='".$cod_departamento."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dep=$registro["denominacion_dep"];}
//Responsable Primario
$Ssql="SELECT * FROM bien002 where ced_responsable='".$ced_responsable."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_res=$registro["nombre_res"];}
//Regiones
$Ssql="SELECT * FROM pre092 where cod_region='".$cod_region."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_region=$registro["nombre_region"];}
//Entidad Federal
$Ssql="SELECT * FROM pre091 where cod_estado='".$cod_entidad."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$estado=$registro["estado"];}
//Municipios
$Ssql="SELECT * FROM pre093 where cod_municipio='".$cod_municipio."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_municipio=$registro["nombre_municipio"];}
//Ciudad
$Ssql="SELECT * FROM pre094 where cod_ciudad='".$cod_ciudad."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_ciudad=$registro["nombre_ciudad"];}
//Parroquia
$Ssql="SELECT * FROM pre096 where cod_parroquia='".$cod_parroquia."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_parroquia=$registro["nombre_parroquia"];}
//Situacion Contable
$Ssql="SELECT * FROM bien010 where codigo='".$sit_contable."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$tipo_situacion_cont=$registro["tipo_situacion"];}
//Situacion Legal
$Ssql="SELECT * FROM bien009 where codigo='".$sit_legal."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$tipo_situacion_legal=$registro["tipo_situacion"];}
//Estado Conservacion
$Ssql="SELECT * FROM bien004 where codigo='".$edo_conservacion."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$edo_bien=$registro["edo_bien"];}
//Verificador Responsable
$Ssql="SELECT * FROM bien030 where ced_res_verificador='".$ced_verificador."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_res_ver=$registro["nombre_res_ver"];}
//Tipo de INCORPORACION
$Ssql="SELECT * FROM bien003 where codigo='".$codigo_tipo_incorp."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denomina_tipo=$registro["denomina_tipo"];}
$valor_incorporacion=formato_monto($valor_incorporacion); $monto_depreciado=formato_monto($monto_depreciado); 
$tasa_deprec=formato_monto($tasa_deprec);    $vida_util=formato_monto($vida_util);   $valor_residual=formato_monto($valor_residual); 


?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR FICHA BIENES INMUEBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="1960" border="0" id="tablacuerpo">
  <tr>
    <td>
    <table width="92" height="1950" border="1" cellpadding="0" cellspacing="0" id="tablam">
      <td width="86">
		 <td width="92" height="1950"><table width="94" height="1950" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
		   <tr>
			<td width="89" height="27"  bgColor=#EAEAEA onClick="javascript:LlamarURL('Act_ficha_bienes_inmuebles_pro.php?Gcod_bien_inm=<?php echo $cod_bien_inm;?>')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
			  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><A class=menu href="Act_ficha_bienes_inmuebles_pro.php?Gcod_bien_inm=<?php echo $cod_bien_inm;?>">Atras</A></td>
		   </tr>
		   <tr>
			 <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
				  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
		   </tr>
		    <tr>
			<td >&nbsp;</td>
		  </tr>
		 </table></td>
	  </td>	 
	</table>
    <p>&nbsp;</p>    
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:1992px; z-index:1; top: 75px; left: 119px;">
            <form name="form1" method="post" action="Update_fichas_bienes_inmuebles_pro.php" onSubmit="return revisar()">
        <table width="848" border="0" align="center">
	       <tr>
             <td><table width="845">
               <tr>
                 <td width="180"><span class="Estilo5">C&Oacute;DIGO DE CLASIFICACI&Oacute;N :</span></td>
                 <td width="145"><span class="Estilo5"><input name="txtcod_clasificacion" type="text" id="txtcod_clasificacion" size="10" maxlength="10"  value="<?php echo $cod_clasificacion?>" readonly> </span></td>
                 <td width="520"><span class="Estilo5"> <input name="txtnom_clasificacion" type="text" id="txtnom_clasificacion" size="80" maxlength="250" value="<?php echo $descripcion_b?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">N&Uacute;MERO DEL BIEN:</span></td>
                 <td width="250"><span class="Estilo5"><input name="txtnum_bien" type="text" id="txtnum_bien" size="20" maxlength="20" value="<?php echo $num_bien?>" readonly></div></td>
                 <td width="220"><span class="Estilo5">C&Oacute;DIGO DEL BIEN INMUEBLE :</span></td>
                 <td width="250"><span class="Estilo5"><input name="txtcod_bien_inm" type="text" id="txtcod_bien_inm"  size="40" maxlength="30" value="<?php echo $cod_bien_inm?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="165"><span class="Estilo5">DENOMINACI&Oacute;N DEL BIEN :</span></td>
                 <td width="640"><span class="Estilo5"><input name="txtdenominacion" type="text" id="txtdenominacion" size="120" maxlength="100" value="<?php echo $denominacion?>"  onFocus="encender(this)" onBlur="apagar(this)"></div></td>
                 <td width="40"><span class="Estilo5"><input name="btclasif_bien" type="button" id="btclasif_bien" title="Abrir Catalogo Descripcion de Bienes" onClick="llama_cat_decripciones()" value="..." class="Estilo5">  </span></td>
               </tr>
             </table></td>
           </tr>          
           <tr>
             <td><table width="845">
               <tr>
                 <td width="140"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></td>
                 <td width="65"><span class="Estilo5"><input name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4" value="<?php echo $cod_dependencia?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">    </span></td>
                 <td width="70"><span class="Estilo5"> <input name="btdependencia" type="button" id="btdependencia" title="Abrir Catalogo de Dependencias" onClick="VentanaCentrada('Cat_dependenciasd.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
                 <td width="570"><span class="Estilo5"><input name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="100" maxlength="250" value="<?php echo $denominacion_dependencia?>" readonly>    </span></td>
               </tr>
             </table></td>
           </tr>		   
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="140"><span class="Estilo5">C&Oacute;DIGO DIRECCI&Oacute;N :</span></td>
                 <td width="65"><span class="Estilo5"> <input name="txtcod_direccion" type="text" id="txtcod_direccion" size="5" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)"  value="<?php echo $cod_direccion?>" class="Estilo5">   </span></td>
                 <td width="70"><span class="Estilo5"> <input name="btdirecciones" type="button" id="btdirecciones" title="Abrir Catalogo de Direcciones" onClick="javascript:llama_cat_dir(this.form)" value="..."> </span></td>
                 <td width="570"><span class="Estilo5"><input name="txtdenominacion_dir" type="text" id="txtdenominacion_dir" size="100" maxlength="100" value="<?php echo $denominacion_dir?>" readonly>   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></td>
                 <td width="100"><span class="Estilo5"><input name="txtcod_departamento" type="text" id="txtcod_departamento" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_departamento?>" class="Estilo5">   </span></td>
                 <td width="60"><span class="Estilo5"> <input name="btdepartamento" type="button" id="btdepartamento" title="Abrir Catalogo de Departamentos" onClick="javascript:llama_cat_dep(this.form)" value="..."> </span></td>
                 <td width="530"><span class="Estilo5"><input name="txtdenominacion_depart" type="text" id="txtdenominacion_depart" size="100" maxlength="100"  value="<?php echo $denominacion_dep?>" readonly>   </span></td>
               </tr>
             </table></td>
           </tr>   
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">DESCRIPCI&Oacute;N DEL INMUBLE :</span></td>
                 <td width="720"><textarea name="txtdescripcion" cols="70" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" class="headers" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" id="txtdescripcion"><?php echo $descripcion?></textarea>    </div></td>
               </tr>
             </table></td>
           </tr>		   
           <tr>
             <td><table width="845">
               <tr>
                 <td width="146"><span class="Estilo5">AREA DEL INMUEBLE M2 :</div></td>
                 <td width="135"><span class="Estilo5"><input name="txtarea_inmueble" type="text" id="txtarea_inmueble" size="10" maxlength="10" value="<?php echo $area_inmueble?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">                     </span></td>
                 <td width="140"><span class="Estilo5">AREA TERRENO M2 :</span></td>
                 <td width="140"><span class="Estilo5"><input name="txtarea_terreno" type="text" id="txtarea_terreno"size="10" maxlength="10" value="<?php echo $area_terreno?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">    </span></td>
                 <td width="149"><span class="Estilo5">AREA CONSTRUCI&Oacute;N M2 :</span></td>
                 <td width="135"><span class="Estilo5"><input name="txtarea_construccion" type="text" id="txtarea_construccion" size="10" maxlength="10" value="<?php echo $area_construccion?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">CARACTERISTICAS DEL BIEN INMUBLE :</span></td>
                 <td width="720"><textarea name="txtcaracteristicas" cols="70" maxlength="250" class="headers" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" id="txtcaracteristicas"><?php echo $caracteristicas?></textarea>
                 </div></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="180"><span class="Estilo5">C.I. RESPONSABLE PATRIMONIAL :</span></td>
                 <td width="100"><span class="Estilo5"><input name="txtced_responsable" type="text" id="txtced_responsable" size="15" maxlength="12"  value="<?php echo $ced_responsable?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">   </span></td>
                 <td width="45"><span class="Estilo5"><input name="btresp_p" type="button" id="btresp_p" title="Abrir Catalogo Responsable Primario" onClick="VentanaCentrada('Cat_responsablesd.php?criterio=','SIPAP','','750','500','true')" value="...">  </span></td>
                 <td width="520"><span class="Estilo5"><input name="txtnombre_respp" type="text" id="txtnombre_respp" size="100" maxlength="250"  value="<?php echo $nombre_res?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="200"><span class="Estilo5">FECHA ULTIMA ACTUALIZACI&Oacute;N :</span></td>
                 <td width="645"><span class="Estilo5"><input name="txtfecha_actualizacion" type="text" id="txtfecha_actualizacion" size="20" maxlength="15" value="<?php echo $fecha_actualizacion?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
               </tr>
             </table></td>
           </tr>
		   
		   
		   
           
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">DIRECCI&Oacute;N :</span></td>
                 <td width="720"><div align="left"><textarea name="txtdireccion" onFocus="encender(this)" onBlur="apagar(this)" cols="70" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)"  class="headers" id="txtdireccion"><?php echo $direccion?></textarea>  </div></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">REGI&Oacute;N :</span></td>
                 <td width="50"><span class="Estilo5"> <input name="txtcod_region" type="text" id="txtcod_region" size="4" maxlength="2" value="<?php echo $cod_region?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">   </span></td>
                 <td width="50"><input name="btcat_reg" type="button" id="btcat_reg" title="Abrir Catalogo de Regiones" onClick="VentanaCentrada('Cat_regionesd.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
                 <td width="620"><span class="Estilo5"><input name="txtnombre_region" type="text" id="txtnombre_region" size="100" maxlength="250"  value="<?php echo $nombre_region?>" readonly>   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">ENTIDAD FEDERAL :</span></td>
                 <td width="50"><span class="Estilo5"><input name="txtcod_entidad" type="text" id="txtcod_entidad" size="4" maxlength="2" value="<?php echo $cod_entidad?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">   </span></td>
                 <td width="50"><input name="btcat_ent" type="button" id="btcat_ent" title="Abrir Catalogo de Entidades Federal" onClick="VentanaCentrada('Cat_entidadfederald.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
				 <td width="620"><span class="Estilo5"><input name="txtestado" type="text" id="txtestado" size="100" maxlength="250"  value="<?php echo $estado?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">MUNICIPIO :</span></td>
                 <td width="50"><span class="Estilo5"><input name="txtcod_municipio" type="text" id="txtcod_municipio" size="5" maxlength="4" value="<?php echo $cod_municipio?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">  </span></td>
                 <td width="50"><input name="btcat_mun" type="button" id="btcat_mun" title="Abrir Catalogo de Municipios" onClick="VentanaCentrada('Cat_municipiosd.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
				 <td width="620"><span class="Estilo5"><input name="txtnombre_municipio" type="text" id="txtnombre_municipio" size="100" maxlength="250" value="<?php echo $nombre_municipio?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">CIUDAD :</span></td>
                 <td width="50"><span class="Estilo5"><input name="txtcod_ciudad" type="text" id="txtcod_ciudad" size="5" maxlength="4"  value="<?php echo $cod_ciudad?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">    </span></td>
                 <td width="50"><input name="btcat_ciu" type="button" id="btcat_ciu" title="Abrir Catalogo de Ciudades" onClick="VentanaCentrada('Cat_ciudadesd.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
				 <td width="620"><span class="Estilo5"><input name="txtnombre_ciudad" type="text" id="txtnombre_ciudad" size="100" maxlength="250" value="<?php echo $nombre_ciudad?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">PARROQUIA :</span></td>
                 <td width="50"><span class="Estilo5"><input name="txtcod_parroquia" type="text" id="txtcod_parroquia" size="7" maxlength="6" value="<?php echo $cod_parroquia?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">  </span></td>
                 <td width="50"><input name="btcat_parr" type="button" id="btcat_parr" title="Abrir Catalogo de Parroquias" onClick="VentanaCentrada('Cat_parroquiasd.php?criterio=','SIPAP','','750','500','true')" value="...">  </span></td>
				 <td width="620"><span class="Estilo5"><input name="txtnombre_parroquia" type="text" id="txtnombre_parroquia" size="100" maxlength="250" value="<?php echo $nombre_parroquia?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">C&Oacute;DIGO POSTAL :</span></td>
                 <td width="400"><span class="Estilo5"><input name="txtcod_postal" type="text" id="txtcod_postal" size="12" maxlength="10" value="<?php echo $cod_postal?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5"></span></td>
				 <td width="150"><span class="Estilo5">TIENE PLANOS :</span></div></td>
                 <td width="170"><span class="Estilo5"> <select name="txttiene_planos" id="txttiene_planos"><option value="SI">SI</option><option value="NO">NO</option></select></span></td>  
               </tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript">
var mvalor='<?php echo $tipo_depreciacion ?>';
    if(mvalor=="SI"){document.form1.txttiene_planos.options[0].selected = true;}else{document.form1.txttiene_planos.options[1].selected = true;}
</script>
          <tr>
            <td><table width="845">
              <tr>
                <td width="120"><span class="Estilo5">LINDERO NORTE :</span></div></td>
                <td width="725"><textarea name="txtlindero_norte" cols="70" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" class="headers" id="txtlindero_norte"><?php echo $lindero_norte?></textarea>  </div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="845">
              <tr>
                <td width="120"><span class="Estilo5">LINDERO SUR :</span></div></td>
                <td width="725"><textarea name="txtlindero_sur" cols="70" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" class="headers" id="txtlindero_sur"><?php echo $lindero_sur?></textarea>   </div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="845">
              <tr>
                <td width="120"><span class="Estilo5">LINDERO ESTE :</span></div></td>
                <td width="725"><textarea name="txtlindero_este" cols="70" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" class="headers" id="txtlindero_este"><?php echo $lindero_este?></textarea>   </div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="845">
              <tr>
                <td width="120"><span class="Estilo5">LINDERO OESTE :</span></div></td>
                <td width="725"><textarea name="txtlindero_oeste" cols="70" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" class="headers" id="txtlindero_oeste"><?php echo $lindero_oeste?></textarea>  </div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="845">
              <tr>
                <td width="120"><span class="Estilo5">OBSERVACI&Oacute;N :</span></div></td>
                <td width="725"><textarea name="txtobservacion" cols="70" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" class="headers" id="txtobservacion"><?php echo $observacion?></textarea> </div></td>
              </tr>
            </table></td>
          </tr>
		  
		  
		  <tr>
             <td><span class="Estilo10"><strong>DATOS DEL DOCUMENTO</strong></span></td>
           </tr>            
           <tr>
             <td><table width="845">
               <tr>
                 <td width="145"><span class="Estilo5">OFICINA DE REGISTRO :</span></td>
                 <td width="700"><span class="Estilo5"><input name="txtofic_registro" type="text" id="txtofic_registro" size="100" maxlength="150"  onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $ofic_registro?>" class="Estilo5">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="120"><span class="Estilo5">N&Uacute;MERO :</span></td>
                 <td width="175"><span class="Estilo5"> <input name="txtnumero" type="text" id="txtnumero" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $numero?>" class="Estilo5"></span></td>
                 <td width="100"><span class="Estilo5">TOMO :</span></td>
                 <td width="150"><span class="Estilo5"><input name="txttomo" type="text" id="txttomo" size="15" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tomo?>" class="Estilo5">  </span></td>
                 <td width="100"><span class="Estilo5">FOLIO :</span></td>
                 <td width="200"><span class="Estilo5"><input name="txtfolio" type="text" id="txtfolio" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $folio?>" class="Estilo5">  </span></td>
               </tr>
             </table></td>
           </tr>
		   
           <tr>
             <td><table width="845">
               <tr>
                 <td width="120"><span class="Estilo5">PROTOCOLO :</span></td>
                 <td width="400"><span class="Estilo5"><input name="txtprotocolo" type="text" id="txtprotocolo" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $protocolo?>"  class="Estilo5"> </span></td>
                 <td width="125"><span class="Estilo5">FECHA DEL DOCUMENTO :</span></td>
                 <td width="200"><span class="Estilo5"><input name="txtfecha_doc" type="text" id="txtfecha_doc" size="15" maxlength="15" value="<?php echo $fecha_doc?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">  </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">SITUACI&Oacute;N LEGAL :</span></td>
                 <td width="100"><span class="Estilo5"><input name="txtsit_legal" type="text" id="txtsit_legal" size="4" maxlength="2" value="<?php echo $sit_legal?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">   
				    <input name="btsit_legal" type="button" id="btsit_legal" title="Abrir Catalogo Situacion Legal del Bien" onClick="VentanaCentrada('Cat_situacionlegald.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
                 <td width="620"><span class="Estilo5"><input name="txttipo_situacion_legal" type="text" id="txttipo_situacion_legal" size="100" maxlength="100" value="<?php echo $tipo_situacion_legal?>" readonly>   </span></td>
               </tr>
             </table></td>
           </tr>
		        
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">ESTUDIO LEGAL DE LA PROPIEDAD :</span></td>
                 <td width="700"><textarea name="txtestudio_legal" cols="70" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" onBlur="apagar(this)" class="headers" id="txtestudio_legal"><?php echo $estudio_legal?></textarea>    </div></td>
               </tr>
             </table></td>
           </tr>
		   
		   <tr>
             <td><span class="Estilo10"><strong>DATOS CONTABLES</strong></span></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="200"><span class="Estilo5">C&Oacute;DIGO CONTABLE ASOCIADO :</span></td>
                 <td width="225"><span class="Estilo5"><input name="txtcod_contablea" type="text" id="txtcod_contablea" size="30" maxlength="25" value="<?php echo $cod_contablea?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">   
				  <input name="btcod_contaba" type="button" id="btcod_contaba" title="Abrir Catalogo Codigo Contable" onClick="VentanaCentrada('Cat_codigoscontablesa.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
                 <td width="220"><span class="Estilo5">C&Oacute;DIGO CONTABLE DEPRECIACI&Oacute;N :</span></td>
                 <td width="200"><span class="Estilo5"><input name="txtcod_contabled" type="text" id="txtcod_contabled" size="30" maxlength="25" value="<?php echo $cod_contabled?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">  
				   <input name="btcod_contabd" type="button" id="btcod_contabd" title="Abrir Catalogo Codigo Contable Depreciacion" onClick="VentanaCentrada('Cat_codigoscontablesd.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="195"><span class="Estilo5">TIPO DE DEPRECIACI&Oacute;N :</span></td>
                 <td width="250"><span class="Estilo5">  <select name="txttipo_depreciacion" onFocus="encender(this)" onBlur="apagar(this)"> <option>NINGUNA</option>    <option>LINEA RECTA</option> </select> </span></td>
                 <td width="150"><span class="Estilo5">TASA DEPRECIACI&Oacute;N :</span></td>
                 <td width="250"><span class="Estilo5"><input name="txttasa_deprec" type="text" id="txttasa_deprec" size="10" maxlength="5" align="rigth" value="<?php echo $tasa_deprec?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">    </span></td>
               </tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript">
var mvalor='<?php echo $tipo_depreciacion ?>';
    if(mvalor=="NINGUNA"){document.form1.txttipo_depreciacion.options[0].selected = true;}else{document.form1.txttipo_depreciacion.options[1].selected = true;}
</script>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="195"><span class="Estilo5">VIDA &Uacute;TIL EN A&Ntilde;OS :</span></td> 
                 <td width="250"><span class="Estilo5"><input name="txtvida_util" type="text" id="txtvida_util" size="10"  maxlength="5" align="rigth"  value="<?php echo $vida_util?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">    </span></td>
                 <td width="150"><span class="Estilo5">VALOR RESIDUAL :</span></td>
                 <td width="250"><span class="Estilo5"><input name="txtvalor_residual" type="text" id="txtvalor_residual" size="20"  maxlength="5" align="rigth"  value="<?php echo $valor_residual?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5"> </span></td>
               </tr>
             </table></td>
           </tr>
          
		  <tr>
             <td><table width="845">
               <tr>
                 <td width="300"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO DE DEPRECIACI&Oacute;N :</span></td>
                 <td width="250"><span class="Estilo5"><input name="txtcod_presup_dep" type="text" id="txtcod_presup_dep" size="35" maxlength="32" value="<?php echo $cod_presup_dep?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">  
				  <input name="btcod_presupd" type="button" id="btcod_presupd" title="Abrir Catalogo Codigo Presupuestario Depreciacion" onClick="VentanaCentrada('Cat_codigos_presup_dep.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
                 <td width="145"><span class="Estilo5">MONTO DEPRECIADO :</span></td>
                 <td width="150"><span class="Estilo5"><input name="txtmonto_depreciado" type="text" id="txtmonto_depreciado" size="20" maxlength="15" value="<?php echo $monto_depreciado?>" align="rigth" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">  </span></td>
               </tr>
             </table></td>
           </tr>

          <tr>
            <td><table width="845">
              <tr>
                <td width="145" ><span class="Estilo5">DESINCORPORADO :</span></div></td>
                <td width="700" ><span class="Estilo5"><select name="txtdesincorporado" size="1" id="txtdesincorporado" readonly > <option >NO</option> <option >SI</option>  </select>
                </span></td>
              </tr>
            </table></td>
          </tr>
<script language="JavaScript" type="text/JavaScript">
var mvalor='<?php echo $desincorporado ?>';
    if(mvalor=="N"){document.form1.txtdesincorporado.options[0].selected = true;}else{document.form1.txtdesincorporado.options[1].selected = true;}
</script>

		  <tr>
             <td><table width="845">
               <tr>
                 <td width="175"><span class="Estilo5">SITUACI&Oacute;N CONTABLE :</span></td>
                 <td width="100"><span class="Estilo5"><input name="txtsit_contable" type="text" id="txtsit_contable" size="4" maxlength="2" value="<?php echo $sit_contable?>"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">   
          			<input name="btsit_contab" type="button" id="btsit_contab" title="Abrir Catalogo Situacion Contable" onClick="VentanaCentrada('Cat_situacioncontabled.php?criterio=','SIPAP','','750','500','true')" value="...">     </span></td>
                 <td width="570"><span class="Estilo5"><input name="txttipo_situacion_cont" type="text" id="txttipo_situacion_cont" size="100" maxlength="100" value="<?php echo $tipo_situacion_cont?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>		   
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="175"><span class="Estilo5">ESTADO DE CONSERVACI&Oacute;N :</span></td>
                 <td width="100"><span class="Estilo5"> <input name="txtedo_conservacion" type="text" id="txtedo_conservacion" size="5" maxlength="15" value="<?php echo $edo_conservacion?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">   
				     <input name="btedo_cons" type="button" id="btedo_cons" title="Abrir Catalogo Estado de Conservacion" onClick="VentanaCentrada('Cat_estadoconservaciond.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
                 <td width="570"><span class="Estilo5"><input name="txtestado_bien" type="text" id="txtestado_bien" size="100" maxlength="100" value="<?php echo $edo_bien?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="200"><span class="Estilo5">C.I. RESPONSABLE VERIFICADOR :</span></td>
                 <td width="200"><span class="Estilo5"><input name="txtced_res_verificador" type="text" id="txtced_res_verificador" size="15" maxlength="12" value="<?php echo $ced_verificador?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">  
				   <input name="btres_ver" type="button" id="btres_ver" title="Abrir Catalogo Responsable Verificador" onClick="VentanaCentrada('Cat_responsableverd.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
                 <td width="155"><span class="Estilo5">FECHA DE VERIFICACI&Oacute;N :</span></td>
                 <td width="290"><span class="Estilo5"><input name="txtfecha_verificacion" type="text" id="txtfecha_verificacion" size="20" maxlength="10" value="<?php echo $fecha_verificacion?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="175"><span class="Estilo5">NOMBRE DEL VERIFICADOR :</span></td>
                 <td width="670"><span class="Estilo5"><input name="txtnombre_res_ver" type="text" id="txtnombre_res_ver" size="100" maxlength="250" value="<?php echo $nombre_res_ver?>" readonly>
                 </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><span class="Estilo10"><strong>INCORPORACI&Oacute;N</strong></span></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="245"><span class="Estilo5">C&Oacute;DIGO MOVIMIENTO INCORPORACI&Oacute;N:</span></td>
                 <td width="100"><span class="Estilo5"><input name="txcodigo_tipo_incorp" type="text" id="txcodigo_tipo_incorp" size="5" maxlength="5" value="<?php echo $codigo_tipo_incorp?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">  
				     <input name="btcod_mov" type="button" id="btcod_mov" title="Abrir Catalogo Tipo Incorporacion" onClick="VentanaCentrada('Cat_tipoincorpd.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
                 <td width="500"><span class="Estilo5"><input name="txtdenomina_tipo" type="text" id="txtdenomina_tipo" size="100" maxlength="150" value="<?php echo $denomina_tipo?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="195"><span class="Estilo5">TIPO DE INCORPORACI&Oacute;N :</span></td>
                 <td width="650"><span class="Estilo5"><select name="txttipo_incorporacion" onFocus="encender(this)" onBlur="apagar(this)"><option>PRESUPUESTARIA</option><option>NO PRESUPUESTARIA</option></select></span></td>
               </tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript">
var mvalor='<?php echo $tipo_incorporacion  ?>';
    if(mvalor=="PRESUPUESTARIA"){document.form1.txttipo_incorporacion.options[0].selected = true;}else{document.form1.txttipo_incorporacion.options[1].selected = true;}
</script>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="245"><span class="Estilo5">C&Oacute;D. IMPUTACI&Oacute;N PRESUPUESTARIA :</span></td>
                 <td width="600"><span class="Estilo5"><input name="txtcod_presup" type="text" id="txtcod_presup" size="40" maxlength="32"  value="<?php echo $cod_imp_presup?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5"> 
				   <input name="btcod_presupi" type="button" id="btcod_presupi" title="Abrir Catalogo Codigo Presupuestario" onClick="VentanaCentrada('Cat_codigos_presup.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="245"><span class="Estilo5">NOMBRE IMPUTACI&Oacute;N PRESUPUESTARIA :</span></td>
                 <td width="600"><span class="Estilo5"><input name="txtdenomina_presup" type="text" id="txtdenomina_presup" size="130" maxlength="150" value="<?php echo $nom_imp_presup?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="245"><span class="Estilo5">DESCRIPCI&Oacute;N DE INCORPORACI&Oacute;N NO PRESUPUESTARIA :</span></td>
                 <td width="600"><span class="Estilo5"><input name="txtdes_imp_nopresup" type="text" id="txtdes_imp_nopresup" size="130" maxlength="150" value="<?php echo $des_imp_nopresup?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="165"><span class="Estilo5">VALOR INCORPORACI&Oacute;N :</span></td>
                 <td width="150"><span class="Estilo5"><input name="txtvalor_incorporacion" type="text" id="txtvalor_incorporacion" size="20" maxlength="15" align="rigth"  value="<?php echo $valor_incorporacion?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">   </span></td>
                 <td width="150"><span class="Estilo5">FECHA INCORPORACI&Oacute;N :</span></td>
                 <td width="150"><span class="Estilo5"><input name="txtfecha_incorporacion" type="text" id="txtfecha_incorporacion" size="15" maxlength="10" value="<?php echo $fecha_incorporacion?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">   </span></td>
                 <td width="230"><span class="Estilo5"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="185"><span class="Estilo5">N&Uacute;MERO ORDEN DE COMPRA :</span></td>
                 <td width="170"><span class="Estilo5"><input name="txtnro_oc" type="text" id="txtnro_oc" size="10" maxlength="8"  value="<?php echo $nro_oc?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">   </span></td>
                 <td width="170"><span class="Estilo5">FECHA ORDEN DE COMPRA :</span></td>
                 <td width="320"><span class="Estilo5"><input name="txtfecha_oc" type="text" id="txtfecha_oc" size="15" maxlength="10" value="<?php echo $fecha_oc?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="185"><span class="Estilo5">N&Uacute;MERO ORDEN DE PAGO :</span></td>
                 <td width="170"><span class="Estilo5"><input name="txtnro_op" type="text" id="txtnro_op" size="10" maxlength="8"  value="<?php echo $nro_op?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">   </span></td>
                 <td width="170"><span class="Estilo5">FECHA ORDEN ORDEN DE PAGO :</span></td>
                 <td width="320"><span class="Estilo5"> <input name="txtfecha_op" type="text" id="txtfecha_op" size="15" maxlength="10" value="<?php echo $fecha_op?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="185"><span class="Estilo5">DOCUMENTO QUE CANCELA :</span></td>
                 <td width="120"><span class="Estilo5"> <select name="txttipo_doc_cancela"> <option>CHEQUE</option><option>NOTA DEBITO</option>  </select></span></td>
                 <td width="140"><span class="Estilo5">N&Uacute;MERO DOCUMENTO :</span></td>
                 <td width="120"><span class="Estilo5"><input name="txtnro_doc_cancela" type="text" id="txtnro_doc_cancela" size="10" maxlength="8"  value="<?php echo $nro_doc_cancela?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">  </span></td>
                 <td width="140"><span class="Estilo5">FECHA DOCUMENTO :</span></td>
                 <td width="140"><span class="Estilo5"><input name="txtfecha_doc_cancela" type="text" id="txtfecha_doc_cancela" size="20"  maxlength="10" value="<?php echo $fecha_doc_cancela?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
               </tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript">
var mvalor='<?php echo $tipo_doc_cancela  ?>';
    if(mvalor=="CHEQUE"){document.form1.txttipo_doc_cancela.options[0].selected = true;}else{document.form1.txttipo_doc_cancela.options[1].selected = true;}
</script>		   
           <tr>
             <td><table width="845">
               <tr>
                 <td width="145"><span class="Estilo5">N&Uacute;MERO DE FACTURA :</span></td>
                 <td width="200"><span class="Estilo5"><input name="txtnro_factura" type="text" id="txtnro_factura" size="25" maxlength="20"   value="<?php echo $nro_factura?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong> </strong></strong></span> </span></td>
                 <td width="180"><span class="Estilo5">FECHA DE FACTURA :</span></td>
                 <td width="320"><span class="Estilo5"> <input name="txtfecha_factura" type="text" id="txtfecha_factura" size="15" maxlength="10" value="<?php echo $fecha_factura?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">
                     </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="145"><span class="Estilo5">CI/RIF PROVEEDOR :</span></td>
                 <td width="150"><span class="Estilo5"><input name="txtced_rif_proveedor" type="text" id="txtced_rif_proveedor" size="15" maxlength="12" value="<?php echo $ced_rif_proveedor?>" onFocus="encender(this)" onBlur="apagar(this)"class="Estilo5">   
				   <input name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo Proveedores" onClick="VentanaCentrada('Cat_proveedoresd.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
                 <td width="550"><span class="Estilo5"><input name="txtnombre_proveedor" type="text" id="txtnombre_proveedor" size="100" maxlength="100" value="<?php echo $nom_proveedor?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">    </span></td>
               </tr>
             </table></td>
           </tr>
           
        </table>  
        <table width="812">
		  <tr>
             <td width="840" height="39">&nbsp;</td>
		   </tr>
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>
