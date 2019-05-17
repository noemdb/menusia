<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");  include ("../class/configura.inc"); $cod_modulo="13";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$cod_bien_mue='';}else {$cod_bien_mue=$_GET["Gcod_bien_mue"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Modificar Ficha de Bienes Muebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript"  src="../class/sia.js"  type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function llama_cat_decripciones(){ var mcod_c;  mcod_c=document.form1.txtcod_clasificacion.value; 
  VentanaCentrada('Cat_descrip_bienes.php?codigo_c='+mcod_c+'&criterio=','SIA','','750','500','true')
}

function llama_cat_dir(mform){  var mcod_dep; var murl; mcod_dep=mform.txtcod_dependencia.value;
  murl='Cat_direcc_dep.php?cod_dependen='+mcod_dep+'&criterio=';   VentanaCentrada(murl,'SIA','','750','500','true');
return true;}

function llama_cat_dep(mform){  var mcod_dep; var murl;  var mcod_dir;
   mcod_dep=mform.txtcod_dependencia.value; mcod_dir=mform.txtcod_direccion.value;
   murl='Cat_departamentos.php?cod_dependen='+mcod_dep+'&cod_direccion='+mcod_dir+'&criterio=';   VentanaCentrada(murl,'SIA','','750','500','true');
return true;}

function chequea_fecha(mthis){var mref; var mfec;   mref=mthis.value; 
  if(mref.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7); mthis.value=mfec;}
return true;}
function LlamarURL(url){  document.location = url; }
function revisar(){
var f=document.form1;
    if(f.txtcod_clasificacion.value==""){alert("Codigo de Clasificacion no puede estar Vacio");return false;}else{f.txtcod_clasificacion.value=f.txtcod_clasificacion.value.toUpperCase();}
    if(f.txtnum_bien.value==""){alert("Numero del Bien no puede estar Vacio"); return false; } else{f.txtnum_bien.value=f.txtnum_bien.value.toUpperCase();}
    if(f.txtcod_bien_mue.value==""){alert("Codigo del Bien no puede estar Vacio");return false;}else{f.txtcod_bien_mue.value=f.txtcod_bien_mue.value.toUpperCase();}
    if(f.txtdenominacion.value==""){alert("Denominacion no puede estar Vacia"); return false; } else{f.txtdenominacion.value=f.txtdenominacion.value.toUpperCase();}
    if(f.txtcod_dependencia.value==""){alert("Codigo Dependencia no puede estar Vacio");return false;}else{f.txtcod_dependencia.value=f.txtcod_dependencia.value.toUpperCase();}
    if(f.txtcod_direccion.value==""){alert("Codigo Direccion no puede estar Vacia");return false;}else{f.txtcod_direccion.value=f.txtcod_direccion.value.toUpperCase();}
    if(f.txtcod_departamento.value==""){alert("Codigo Departamento no puede estar Vacio");return false;}else{f.txtcod_departamento.value=f.txtcod_departamento.value.toUpperCase();}
    if(f.txtced_responsable.value==""){alert("Cedula del responsable Primario no estar Vacia"); return false; } else{f.txtced_responsable.value=f.txtced_responsable.value.toUpperCase();}
    if(f.txtced_responsable_uso.value==""){alert("Cedula del responsable de Uso no estar Vacia");return false;}else{f.txtced_responsable_uso.value=f.txtced_responsable_uso.value.toUpperCase();}
    if(f.txtcod_metodo_rot.value==""){alert("Codigo Metodo de Rotulacion no puede estar Vacio");return false;}else{f.txtcod_metodo_rot.value=f.txtcod_metodo_rot.value.toUpperCase();}   
    if(f.txtced_rotulador.value==""){alert("Cedula del Rotulador no estar Vacia"); return false; } else{f.txtced_rotulador.value=f.txtced_rotulador.value.toUpperCase();}
    if(f.txtfecha_rotulacion.value==""){alert("Fecha de Rotulacion no estar Vacia"); return false; } else{f.txtfecha_rotulacion.value=f.txtfecha_rotulacion.value.toUpperCase();}
    if(f.txtfecha_actualizacion.value==""){alert("Fecha de Actualizacion no estar Vacia"); return false; } else{f.txtfecha_actualizacion.value=f.txtfecha_actualizacion.value.toUpperCase();}
    if(f.txtdireccion.value==""){alert("Direccion no estar Vacia"); return false; } else{f.txtdireccion.value=f.txtdireccion.value.toUpperCase();}
    if(f.txtcod_region.value==""){alert("Codigo Region no puede estar Vacio"); return false; } else{f.txtcod_region.value=f.txtcod_region.value.toUpperCase();}
    if(f.txtcod_entidad.value==""){alert("Codigo de la Entidad no puede estar Vacio"); return false; } else{f.txtcod_entidad.value=f.txtcod_entidad.value.toUpperCase();}
    if(f.txtcod_municipio.value==""){alert("Codigo del Municipio no puede estar Vacio"); return false; } else{f.txtcod_municipio.value=f.txtcod_municipio.value.toUpperCase();}
    if(f.txtcod_ciudad.value==""){alert("Codigo de la Ciudad no puede estar Vacio"); return false; } else{f.txtcod_ciudad.value=f.txtcod_ciudad.value.toUpperCase();}
    if(f.txtcod_parroquia.value==""){alert("Codigo de Parroquia no puede estar Vacio"); return false; } else{f.txtcod_parroquia.value=f.txtcod_parroquia.value.toUpperCase();}
    if(f.txtsit_contable.value==""){alert("Codigo Situacion Contable no debe estar Vacia"); return false; } else{f.txtsit_contable.value=f.txtsit_contable.value.toUpperCase();}
    if(f.txtsit_legal.value==""){alert("Codigo Situacion Legal no debe estar Vacia"); return false; } else{f.txtsit_legal.value=f.txtsit_legal.value.toUpperCase();}
    if(f.txtedo_conservacion.value==""){alert("Codigo Estado de Conservacion no puede estar Vacio"); return false; } else{f.txtedo_conservacion.value=f.txtedo_conservacion.value.toUpperCase();}
    if(f.txtced_res_verificador.value==""){alert("Cedula Responsable Verificador no puede estar Vacio"); return false; } else{f.txtced_res_verificador.value=f.txtced_res_verificador.value.toUpperCase();}
    if(f.txtfecha_verificacion.value==""){alert("Fecha de Verificacion no puede estar Vacio"); return false; } else{f.txtfecha_verificacion.value=f.txtfecha_verificacion.value.toUpperCase();}
    if(f.txttipo_incorporacion.value==""){alert("Tipo de Incorporacion no puede estar Vacio"); return false; } else{f.txttipo_incorporacion.value=f.txttipo_incorporacion.value.toUpperCase();}
    if(f.txtfecha_incorporacion.value==""){alert("Fecha de Incorporacion no puede estar Vacio"); return false; } else{f.txtfecha_incorporacion.value=f.txtfecha_incorporacion.value.toUpperCase();}
    if(f.txtvalor_incorporacion.value==""){alert("Valor de Incorporacion no puede estar Vacio"); return false; } else{f.txtvalor_incorporacion.value=f.txtvalor_incorporacion.value.toUpperCase();}
    
	r=confirm("Desea Grabar la Ficha del Bien ?");  if (r==true) { valido=true;} else{return false;} 
	document.form1.submit;
document.form1.submit;
return true;}
</script>
<style type="text/css">
</style>
</head>
<?
$cod_clasificacion=""; $num_bien="";$denominacion=""; $cod_dependencia=""; $cod_empresa=""; $cod_direccion=""; $cod_departamento=""; $ced_responsable=""; $fecha_actualizacion=""; $denomina_tipo="";
$ced_responsable_uso="";$cod_metodo_rot="";$ced_rotulador=""; $fecha_rotulacion="";$direccion=""; $cod_region=""; $cod_entidad=""; $cod_municipio=""; $cod_ciudad=""; $cod_parroquia=""; $cod_postal="";$caracteristicas="";$marca="";  $modelo="";$color="";$matricula="";$serial1="";$serial2="";$tipo_clase="";$uso="";$dimension_tam="";$material="";$codigo_alterno="";$ano=""; $antiguedad="";$cod_contablea="";$cod_contabled="";$tipo_depreciacion="";$tasa_deprec=""; $vida_util=""; $valor_residual=""; $sit_contable="";$sit_legal=""; $edo_conservacion="";$ced_verificador=""; $fecha_verificacion=""; $tipo_incorporacion=""; $cod_imp_presup=""; $nom_imp_presup="";$des_imp_nopresup=""; $fecha_incorporacion=""; $valor_incorporacion="";$garantia="";$nro_oc=""; $fecha_oc=""; $nro_op=""; $fecha_op=""; $tipo_doc_cancela=""; $nro_doc_cancela=""; $fecha_doc_cancela="";$ced_rif_proveedor=""; $codigo_tipo_incorp=""; $nom_proveedor=""; $cod_presup_dep=""; $monto_depreciado=""; $nro_factura=""; $fecha_factura=""; $desincorporado=""; $fecha_desincorporado="";$des_desincorporado="";$bien_en_salida="";$status_bien_inm=""; $usuario_sia=""; $inf_usuario="";$accesorios="";  $descripcion_b="";  $denominacion_empresa=""; $denominacion_dependencia=""; $denominacion_dir="";$denominacion_dep="";  $nombre_res="";  $nombre_res_uso="";  $metodo_rotula="";  $nombre_res_rotu="";$nombre_region="";  $estado="";  $nombre_municipio=""; $nombre_ciudad="";  $nombre_parroquia=""; $tipo_situacion_cont="";  $tipo_situacion_legal=""; $edo_bien="";  $nombre_res_ver="";

$sql="SELECT * From BIEN015 where cod_bien_mue='$cod_bien_mue'"; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); 
  $cod_bien_mue=$registro["cod_bien_mue"];  $cod_clasificacion=$registro["cod_clasificacion"];  $num_bien=$registro["num_bien"];
  $denominacion=$registro["denominacion"];   $cod_dependencia=$registro["cod_dependencia"];   $cod_empresa=$registro["cod_empresa"]; 
  $cod_direccion=$registro["cod_direccion"];  $cod_departamento=$registro["cod_departamento"];   $ced_responsable=$registro["ced_responsable"];
  $fecha_actualizacion=$registro["fecha_actualizacion"];  if($fecha_actualizacion==""){$fecha_actualizacion="";}else{$fecha_actualizacion=formato_ddmmaaaa($fecha_actualizacion);}
  $ced_responsable_uso=$registro["ced_responsable_uso"];  $cod_metodo_rot=$registro["cod_metodo_rot"];  $ced_rotulador=$registro["ced_rotulador"];
  $fecha_rotulacion=$registro["fecha_rotulacion"];if($fecha_rotulacion==""){$fecha_rotulacion="";}else{$fecha_rotulacion=formato_ddmmaaaa($fecha_rotulacion);}
  $direccion=$registro["direccion"];   $cod_region=$registro["cod_region"];   $cod_entidad=$registro["cod_entidad"];
  $cod_municipio=$registro["cod_municipio"];   $cod_ciudad=$registro["cod_ciudad"];   $cod_parroquia=$registro["cod_parroquia"]; 
  $cod_postal=$registro["cod_postal"];  $caracteristicas=$registro["caracteristicas"];  $marca=$registro["marca"];
  $modelo=$registro["modelo"];  $color=$registro["color"];  $matricula=$registro["matricula"];
  $serial1=$registro["serial1"];  $serial2=$registro["serial2"];  $tipo_clase=$registro["tipo_clase"];
  $uso=$registro["uso"];  $dimension_tam=$registro["dimension_tam"];   $material=$registro["material"]; 
  $codigo_alterno=$registro["codigo_alterno"];   $ano=$registro["ano"];   $antiguedad=$registro["antiguedad"]; 
  $cod_contablea=$registro["cod_contablea"];   $cod_contabled=$registro["cod_contabled"];   $tipo_depreciacion=$registro["tipo_depreciacion"]; 
  $tasa_deprec=$registro["tasa_deprec"];   $vida_util=$registro["vida_util"];  $valor_residual=$registro["valor_residual"]; 
  $sit_contable=$registro["sit_contable"];   $sit_legal=$registro["sit_legal"];  $edo_conservacion=$registro["edo_conservacion"];
  $ced_verificador=$registro["ced_verificador"];   $fecha_verificacion=$registro["fecha_verificacion"];
  if($fecha_verificacion==""){$fecha_verificacion="";}else{$fecha_verificacion=formato_ddmmaaaa($fecha_verificacion);}
  $tipo_incorporacion=$registro["tipo_incorporacion"];   $cod_imp_presup=$registro["cod_imp_presup"]; 
  $nom_imp_presup=$registro["nom_imp_presup"];  $des_imp_nopresup=$registro["des_imp_nopresup"];   
  $fecha_incorporacion=$registro["fecha_incorporacion"]; if($fecha_incorporacion==""){$fecha_incorporacion="";}else{$fecha_incorporacion=formato_ddmmaaaa($fecha_incorporacion);}
  $valor_incorporacion=$registro["valor_incorporacion"];  $garantia=$registro["garantia"];  $nro_oc=$registro["nro_oc"]; $nro_op=$registro["nro_op"]; 
  $fecha_oc=$registro["fecha_oc"]; if($fecha_oc==""){$fecha_oc="";}else{$fecha_oc=formato_ddmmaaaa($fecha_oc);}    
  $fecha_op=$registro["fecha_op"]; if($fecha_op==""){$fecha_op="";}else{$fecha_op=formato_ddmmaaaa($fecha_op);}
  $tipo_doc_cancela=$registro["tipo_doc_cancela"];  $nro_doc_cancela=$registro["nro_doc_cancela"]; 
  $fecha_doc_cancela=$registro["fecha_doc_cancela"];if($fecha_doc_cancela==""){$fecha_doc_cancela="";}else{$fecha_doc_cancela=formato_ddmmaaaa($fecha_doc_cancela);} 
  $ced_rif_proveedor=$registro["ced_rif_proveedor"];  $codigo_tipo_incorp=$registro["codigo_tipo_incorp"];  $nom_proveedor=$registro["nom_proveedor"]; 
  $cod_presup_dep=$registro["cod_presup_dep"];  $monto_depreciado=$registro["monto_depreciado"];   $nro_factura=$registro["nro_factura"]; 
  $fecha_factura=$registro["fecha_factura"]; if($fecha_factura==""){$fecha_factura="";}else{$fecha_factura=formato_ddmmaaaa($fecha_factura);}
  $des_desincorporado=$registro["des_desincorporado"]; $desincorporado=$registro["desincorporado"];   
  $fecha_desincorporado=$registro["fecha_desincorporado"];if($fecha_desincorporado==""){$fecha_desincorporado="";}else{$fecha_desincorporado=formato_ddmmaaaa($fecha_desincorporado);}
  $bien_en_salida=$registro["bien_en_salida"]; $accesorios=$registro["accesorios"];
}
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
//Responsable Uso
$Ssql="SELECT * FROM bien031 where ced_res_uso='".$ced_responsable_uso."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_res_uso=$registro["nombre_res_uso"];}
//Metodo Rotulacion
$Ssql="SELECT * FROM bien012 where codigo='".$cod_metodo_rot."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$metodo_rotula=$registro["metodo_rotula"];}
//Rotuladores
$Ssql="SELECT * FROM bien032 where ced_res_rotu='".$ced_rotulador."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_res_rotu=$registro["nombre_res_rotu"];}
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
//tIPO DE INCORPORACION
$Ssql="SELECT * FROM bien003 where codigo='".$codigo_tipo_incorp."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denomina_tipo=$registro["denomina_tipo"];}

$cod_dep_t=""; $nom_dep_t=""; $ced_resp_p="";  $nom_resp_p=""; $cod_pos_t=""; $cod_reg_t=""; $cod_ent_t=""; $cod_mun_t=""; $cod_ciu_t=""; $cod_parro_t=""; $direccion_t="";
$Ssql="SELECT * FROM bien001 order by cod_dependencia"; $resultado=pg_query($Ssql); 
if ($registro=pg_fetch_array($resultado,0)){$cod_dep_t=$registro["cod_dependencia"]; $nom_dep_t=$registro["denominacion_dep"]; $ced_resp_p=$registro["ci_contacto"]; $nom_resp_p=$registro["nombre_contacto"]; 
$cod_reg_t=$registro["cod_region"]; $cod_ent_t=$registro["cod_entidad"]; $cod_mun_t=$registro["cod_municipio"]; $cod_ciu_t=$registro["cod_ciudad"]; $cod_parro_t=$registro["cod_parroquia"]; $direccion_t=$registro["direccion_dep"];  $cod_pos_t=$registro["cod_postal_dep"];}

$formato_bien=""; $long_num_bien=0; $periodo="01"; $campo502=""; $doc_caus_inm=""; $doc_caus_mue=""; $doc_caus_sem=""; $num_bien_unico="S";
$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);
if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; 
$formato_bien=$registro["campo504"];$long_num_bien=$registro["campo549"];$doc_caus_inm=$registro["campo509"]; $doc_caus_mue=$registro["campo510"]; $doc_caus_sem=$registro["campo511"];}
$num_bien_unico=substr($campo502,3,1); $mod_solo_transf=substr($campo502,6,1);
$valor_incorporacion=formato_monto($valor_incorporacion); $monto_depreciado=formato_monto($monto_depreciado); 
$tasa_deprec=formato_monto($tasa_deprec);    $vida_util=formato_monto($vida_util);   $valor_residual=formato_monto($valor_residual); 
?>
<body>

<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR FICHA BIENES MUEBLES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="1610" border="0" id="tablacuerpo">
  <tr>
    <td>
    <table width="92" height="1800" border="1" cellpadding="0" cellspacing="0" id="tablam">
      <td width="86">
		 <td width="92" height="1800"><table width="94" height="1800" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
		   <tr>
			<td width="89" height="27"  bgColor=#EAEAEA onClick="javascript:LlamarURL('Act_fichas_bienes_muebles_pro.php?Gcod_bien_mue=<?echo $cod_bien_mue;?>')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
			  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><A class=menu href="Act_fichas_bienes_muebles_pro.php?Gcod_bien_mue=<?echo $cod_bien_mue;?>">Atras</A></td>
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
      <div id="Layer1" style="position:absolute; width:873px; height:1992px; z-index:1; top: 78px; left: 119px;">
            <form name="form1" method="post" action="Update_fichas_bienes_muebles_pro.php" onSubmit="return revisar()">
        <table width="848" border="0" align="center" >
		  <tr>
             <td><table width="845">
               <tr>
                 <td width="180"><span class="Estilo5">C&Oacute;DIGO DE CLASIFICACI&Oacute;N :</span></td>
                 <td width="145"><span class="Estilo5"><input class="Estilo10" name="txtcod_clasificacion" type="text" id="txtcod_clasificacion" value="<?echo $cod_clasificacion?>" readonly  size="10" maxlength="10"> </span></td>
                 <td width="520"><span class="Estilo5"><input class="Estilo10" name="txtnom_clasificacion" type="text" id="txtnom_clasificacion" size="80" maxlength="250" value="<?echo $descripcion_b?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">N&Uacute;MERO DEL BIEN:</span></td>
                 <td width="250"><span class="Estilo5"><div id="numbien"> <input class="Estilo10" name="txtnum_bien" type="text" id="txtnum_bien" size="20" maxlength="20"  value="<?echo $num_bien?>" readonly></div></td>
                 <td width="220"><span class="Estilo5">C&Oacute;DIGO DEL BIEN INMUEBLE :</span></td>
                 <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtcod_bien_mue" type="text" id="txtcod_bien_mue"  size="40" maxlength="40"  value="<?echo $cod_bien_mue?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="165"><span class="Estilo5">DENOMINACI&Oacute;N DEL BIEN :</span></td>
                 <td width="640"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="110" maxlength="250" value="<?echo $denominacion?>"  onFocus="encender(this)" onBlur="apagar(this)"></div></td>
                 <td width="40"><span class="Estilo5"><input class="Estilo10" name="btclasif_bien" type="button" id="btclasif_bien" title="Abrir Catalogo Descripcion de Bienes" onClick="llama_cat_decripciones()" value="..." >  </span></td>
               </tr>
             </table></td>
           </tr>          
           <tr>
             <td><table width="845">
               <tr>
                 <td width="150"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></td>
                 <td width="65"><span class="Estilo5"><input class="Estilo10" name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4" value="<?echo $cod_dependencia?>" onFocus="encender(this)" onBlur="apagar(this)">    </span></td>
                 <td width="60"><span class="Estilo5"> <input class="Estilo10" name="btdependencia" type="button" id="btdependencia" title="Abrir Catalogo de Dependencias" onClick="VentanaCentrada('Cat_dependenciasd.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="100" maxlength="250" value="<?echo $denominacion_dependencia?>" readonly>    </span></td>
               </tr>
             </table></td>
           </tr>		   
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="150"><span class="Estilo5">C&Oacute;DIGO DIRECCI&Oacute;N :</span></td>
                 <td width="65"><span class="Estilo5"> <input class="Estilo10" name="txtcod_direccion" type="text" id="txtcod_direccion" size="5" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $cod_direccion?>" >   </span></td>
                 <td width="60"><span class="Estilo5"> <input class="Estilo10" name="btdirecciones" type="button" id="btdirecciones" title="Abrir Catalogo de Direcciones" onClick="javascript:llama_cat_dir(this.form)" value="..."> </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_dir" type="text" id="txtdenominacion_dir" size="100" maxlength="100" value="<?echo $denominacion_dir?>" readonly>   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="165"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></td>
                 <td width="70"><span class="Estilo5"><input class="Estilo10" name="txtcod_departamento" type="text" id="txtcod_departamento" size="10" maxlength="8" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_departamento?>" >   </span></td>
                 <td width="40"><span class="Estilo5"> <input class="Estilo10" name="btdepartamento" type="button" id="btdepartamento" title="Abrir Catalogo de Departamentos" onClick="javascript:llama_cat_dep(this.form)" value="..."> </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_depart" type="text" id="txtdenominacion_depart" size="100" maxlength="100"  value="<?echo $denominacion_dep?>" readonly>   </span></td>
               </tr>
             </table></td>
           </tr>        
           <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">C&Oacute;DIGO EMPRESA :</span></td>
				 <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcod_empresa" type="text" id="txtcod_empresa" size="5" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $cod_empresa?>" >   </span></td>
                 <td width="60"><span class="Estilo5"><input class="Estilo10" name="btempresa" type="button" id="btempresa" title="Abrir Catalogo de Empresas" onClick="VentanaCentrada('Cat_empresas_ed.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_emp" type="text" id="txtdenominacion_emp" size="100" maxlength="100"  value="<? echo $denominacion_empresa?>" readonly >   </span></td>
               </tr>
             </table></td>
           </tr>  
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="185"><span class="Estilo5">C.I. RESPONSABLE PRIMARIO :</span></td>
                 <td width="95"><span class="Estilo5"><input class="Estilo10" name="txtced_responsable" type="text" id="txtced_responsable" size="14" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $ced_responsable?>"  >   </span></td>
                 <td width="45"><span class="Estilo5"><input class="Estilo10" name="btresp_p" type="button" id="btresp_p" title="Abrir Catalogo Responsable Primario" onClick="VentanaCentrada('Cat_responsablesd.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
                 <td width="520"><span class="Estilo5"><input class="Estilo10" name="txtnombre_respp" type="text" id="txtnombre_respp" size="100" maxlength="250"  value="<?echo $nombre_res?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="185"><span class="Estilo5">C.I. RESPONSABLE DE USO :</span></td>
                 <td width="95"><span class="Estilo5"> <input class="Estilo10" name="txtced_responsable_uso" type="text" id="txtced_responsable_uso" size="15" maxlength="12"  value="<?echo $ced_responsable_uso?>" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                 <td width="45"><span class="Estilo5"><input class="Estilo10" name="btresp_uso" type="button" id="btresp_uso" title="Abrir Catalogo Responsable Uso" onClick="VentanaCentrada('Cat_responsablesusod.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
                 <td width="520"><span class="Estilo5"><input class="Estilo10" name="txtnombre_res_uso" type="text" id="txtnombre_res_uso" size="100" maxlength="250"  value="<?echo $nombre_res_uso?>" readonly>    </span></td>
               </tr>
             </table></td>
           </tr>          
           <tr>
             <td><table width="845">
               <tr>
                 <td width="165"><span class="Estilo5">METODO DE ROTULACI&Oacute;N :</span></td>
                 <td width="55"><span class="Estilo5"><input class="Estilo10" name="txtcod_metodo_rot" type="text" id="txtcod_metodo_rot" size="4" maxlength="2" value="<?echo $cod_metodo_rot?>" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                 <td width="45"><span class="Estilo5"><input class="Estilo10" name="btmet_rot" type="button" id="btmet_rot" title="Abrir Catalogo Metodo de Rotulacion" onClick="VentanaCentrada('Cat_metodosrotulad.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txtmetodo_rotula" type="text" id="txtmetodo_rotula" size="100" maxlength="250" value="<?echo $metodo_rotula?>" readonly>     </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">C&Eacute;DULA DE ROTULADOR :</span></td>
                 <td width="95"><span class="Estilo5"><input class="Estilo10" name="txtced_rotulador" type="text" id="txtced_rotulador" size="15" maxlength="12"  value="<?echo $ced_rotulador?>" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                 <td width="45"><span class="Estilo5"><input class="Estilo10" name="btced_rot" type="button" id="btced_rot" title="Abrir Catalogo Cedula de Rotulador" onClick="VentanaCentrada('Cat_rotuladoresd.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
                 <td width="550"><span class="Estilo5"><input class="Estilo10" name="txtnombre_res_rotu" type="text" id="txtnombre_res_rotu" size="100" maxlength="250"  value="<?echo $nombre_res_rotu?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">FECHA DE ROTULACI&Oacute;N :</span></td>
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtfecha_rotulacion" type="text" id="txtfecha_rotulacion" size="20" maxlength="10" value="<?echo $fecha_rotulacion?>" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
                 <td width="200"><span class="Estilo5">FECHA ULTIMA ACTUALIZACI&Oacute;N :</span></td>
                 <td width="290"><span class="Estilo5"><input class="Estilo10" name="txtfecha_actualizacion" type="text" id="txtfecha_actualizacion" size="20" maxlength="10" value="<?echo $fecha_actualizacion?>" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
               </tr>
             </table></td>
           </tr>		  
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">DIRECCI&Oacute;N :</span></td>
                 <td width="720"><div align="left"><textarea name="txtdireccion" onFocus="encender(this)" onBlur="apagar(this)" cols="70" onFocus="encender(this)" onBlur="apagar(this)"  class="headers" id="txtdireccion"><?echo $direccion?></textarea>  </div></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">REGI&Oacute;N :</span></td>
                 <td width="50"><span class="Estilo5"> <input class="Estilo10" name="txtcod_region" type="text" id="txtcod_region" size="4" maxlength="2" value="<?echo $cod_region?>" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                 <td width="50"><input class="Estilo10" name="btcat_reg" type="button" id="btcat_reg" title="Abrir Catalogo de Regiones" onClick="VentanaCentrada('Cat_regionesd.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
                 <td width="620"><span class="Estilo5"><input class="Estilo10" name="txtnombre_region" type="text" id="txtnombre_region" size="100" maxlength="250"  value="<?echo $nombre_region?>" readonly>   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">ENTIDAD FEDERAL :</span></td>
                 <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtcod_entidad" type="text" id="txtcod_entidad" size="4" maxlength="2" value="<?echo $cod_entidad?>" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                 <td width="50"><input class="Estilo10" name="btcat_ent" type="button" id="btcat_ent" title="Abrir Catalogo de Entidades Federal" onClick="VentanaCentrada('Cat_entidadfederald.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
				 <td width="620"><span class="Estilo5"><input class="Estilo10" name="txtestado" type="text" id="txtestado" size="100" maxlength="250"  value="<?echo $estado?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">MUNICIPIO :</span></td>
                 <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtcod_municipio" type="text" id="txtcod_municipio" size="5" maxlength="4" value="<?echo $cod_municipio?>" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                 <td width="50"><input class="Estilo10" name="btcat_mun" type="button" id="btcat_mun" title="Abrir Catalogo de Municipios" onClick="VentanaCentrada('Cat_municipiosd.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
				 <td width="620"><span class="Estilo5"><input class="Estilo10" name="txtnombre_municipio" type="text" id="txtnombre_municipio" size="100" maxlength="250" value="<?echo $nombre_municipio?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">CIUDAD :</span></td>
                 <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtcod_ciudad" type="text" id="txtcod_ciudad" size="5" maxlength="4"  value="<?echo $cod_ciudad?>" onFocus="encender(this)" onBlur="apagar(this)">    </span></td>
                 <td width="50"><input class="Estilo10" name="btcat_ciu" type="button" id="btcat_ciu" title="Abrir Catalogo de Ciudades" onClick="VentanaCentrada('Cat_ciudadesd.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
				 <td width="620"><span class="Estilo5"><input class="Estilo10" name="txtnombre_ciudad" type="text" id="txtnombre_ciudad" size="100" maxlength="250" value="<?echo $nombre_ciudad?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">PARROQUIA :</span></td>
                 <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtcod_parroquia" type="text" id="txtcod_parroquia" size="7" maxlength="6" value="<?echo $cod_parroquia?>" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                 <td width="50"><input class="Estilo10" name="btcat_parr" type="button" id="btcat_parr" title="Abrir Catalogo de Parroquias" onClick="VentanaCentrada('Cat_parroquiasd.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
				 <td width="620"><span class="Estilo5"><input class="Estilo10" name="txtnombre_parroquia" type="text" id="txtnombre_parroquia" size="100" maxlength="250" value="<?echo $nombre_parroquia?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">C&Oacute;DIGO POSTAL :</span></td>
                 <td width="720"><span class="Estilo5"><input class="Estilo10" name="txtcod_postal" type="text" id="txtcod_postal" size="12" maxlength="10" value="<?echo $cod_postal?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><span class="Estilo10"><strong>CARACTERISTICAS</strong></span></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">CARACTERISTICAS DEL BIEN MUEBLE :</span></td>
                 <td width="720"><div align="left"><textarea name="textcaracteristicas" cols="70" onFocus="encender(this)" onBlur="apagar(this)"  class="headers" id="textcaracteristicas"><?echo $caracteristicas?></textarea> </div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">MARCA :</span></td>
                 <td width="250"><span class="Estilo5"> <input class="Estilo10" name="txtmarca" type="text" id="txtmarca" size="30" maxlength="30" value="<?echo $marca?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                 <td width="150"><span class="Estilo5">MODELO :</span></td>
                 <td width="320"><span class="Estilo5"><input class="Estilo10" name="txtmodelo" type="text" id="txtmodelo" size="30" maxlength="30" value="<?echo $modelo?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">COLOR :</span></td>
                 <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtcolor" type="text" id="txtcolor" size="30" maxlength="30"  value="<?echo $color?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                 <td width="100"><span class="Estilo5"> <input class="Estilo10" name="btcolor" type="button" id="btcolor" title="Abrir Catalogo de Colores" onClick="VentanaCentrada('Cat_colord.php?criterio=','SIA','','750','500','true')" value="...">   </span></td>
				 <td width="150"><span class="Estilo5">MATRICULA :</span></td>
                 <td width="320"><span class="Estilo5"><input class="Estilo10" name="txtmatricula" type="text" id="txtmatricula" size="30" maxlength="30" value="<?echo $matricula?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">SERIAL :</span></td>
                 <td width="250"><span class="Estilo5"> <input class="Estilo10" name="txtserial1" type="text" id="txtserial1" size="30" maxlength="30" value="<?echo $serial1?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                 <td width="150"><span class="Estilo5">SERIAL 2 :</span></td>
                 <td width="320"><span class="Estilo5"><input class="Estilo10" name="txtserial2" type="text" id="txtserial2" size="30" maxlength="30"  value="<?echo $serial2?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">TIPO O CLASE :</span></td>
                 <td width="250"><span class="Estilo5"><input class="Estilo10" name="txttipo_clase" type="text" id="txttipo_clase" size="30" maxlength="30" value="<?echo $tipo_clase?>" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                 <td width="150"><span class="Estilo5">USO :</span></td>
                 <td width="320"><span class="Estilo5"><input class="Estilo10" name="txtuso" type="text" id="txtuso" size="30" maxlength="15" value="<?echo $uso?>" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">DIMENSION O TAMA&Ntilde;O :</span></td>
                 <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtdimension_tam" type="text" id="txtdimension_tam" size="30" maxlength="30"  value="<?echo $dimension_tam?>" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                 <td width="150"><span class="Estilo5">MATERIAL :</span></td>
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtmaterial" type="text" id="txtmaterial" size="30" maxlength="30" value="<?echo $material?>" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="btmaterial" type="button" id="btmaterial" title="Abrir Catalogo de Materiales" onClick="VentanaCentrada('Cat_materialesd.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
			   </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">C&Oacute;DIGO ALTERNO :</span></td>
                 <td width="240"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_alterno" type="text" id="txtcodigo_alterno" size="30" maxlength="30"  value="<?echo $codigo_alterno?>" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                 <td width="60"><span class="Estilo5">A&Ntilde;O :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtano" type="text" id="txtano" size="5" maxlength="4" value="<?echo $ano?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                 <td width="100"><span class="Estilo5">ANTIGUEDAD :</span></td>
                 <td width="170"><span class="Estilo5"><input class="Estilo10" name="txtantiguedad" type="text" id="txtantiguedad" size="10" maxlength="5" style="text-align:right" value="<?echo $antiguedad?>" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">ACCESORIOS :</span></td>
                 <td width="720"><div align="left"><textarea name="txtaccesorios" cols="70" onFocus="encender(this)" onFocus="encender(this)" onBlur="apagar(this)" class="headers" id="txtaccesorios"><?echo $accesorios?></textarea>   </div></td>
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
                 <td width="225"><span class="Estilo5"><input class="Estilo10" name="txtcod_contablea" type="text" id="txtcod_contablea" size="25" maxlength="25" value="<?echo $cod_contablea?>" onFocus="encender(this)" onBlur="apagar(this)">   
				  <input class="Estilo10" name="btcod_contaba" type="button" id="btcod_contaba" title="Abrir Catalogo Codigo Contable" onClick="VentanaCentrada('Cat_codigoscontablesa.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
                 <td width="220"><span class="Estilo5">C&Oacute;DIGO CONTABLE DEPRECIACI&Oacute;N :</span></td>
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtcod_contabled" type="text" id="txtcod_contabled" size="25" maxlength="25" value="<?echo $cod_contabled?>" onFocus="encender(this)" onBlur="apagar(this)">  
				   <input class="Estilo10" name="btcod_contabd" type="button" id="btcod_contabd" title="Abrir Catalogo Codigo Contable Depreciacion" onClick="VentanaCentrada('Cat_codigoscontablesd.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="195"><span class="Estilo5">TIPO DE DEPRECIACI&Oacute;N :</span></td>
                 <td width="250"><span class="Estilo5">  <select name="txttipo_depreciacion" onFocus="encender(this)" onBlur="apagar(this)"> <option>NINGUNA</option>    <option>LINEA RECTA</option> </select> </span></td>
                 <td width="150"><span class="Estilo5">TASA DEPRECIACI&Oacute;N :</span></td>
                 <td width="250"><span class="Estilo5"><input class="Estilo10" name="txttasa_deprec" type="text" id="txttasa_deprec" size="10" maxlength="5" style="text-align:right" value="<?echo $tasa_deprec?>" onFocus="encender(this)" onBlur="apagar(this)">    </span></td>
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
                 <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtvida_util" type="text" id="txtvida_util" size="10"  maxlength="5" style="text-align:right"  value="<?echo $vida_util?>" onFocus="encender(this)" onBlur="apagar(this)">    </span></td>
                 <td width="150"><span class="Estilo5">VALOR RESIDUAL :</span></td>
                 <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtvalor_residual" type="text" id="txtvalor_residual" size="20"  maxlength="5" style="text-align:right"  value="<?echo $valor_residual?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
               </tr>
             </table></td>
           </tr>
          
		  <tr>
             <td><table width="845">
               <tr>
                 <td width="290"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO DE DEPRECIACI&Oacute;N :</span></td>
                 <td width="280"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup_dep" type="text" id="txtcod_presup_dep" size="35" maxlength="32" value="<?echo $cod_presup_dep?>" onFocus="encender(this)" onBlur="apagar(this)">  
				  <input class="Estilo10" name="btcod_presupd" type="button" id="btcod_presupd" title="Abrir Catalogo Codigo Presupuestario Depreciacion" onClick="VentanaCentrada('Cat_codigos_presup_dep.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
                 <td width="145"><span class="Estilo5">MONTO DEPRECIADO :</span></td>
                 <td width="130"><span class="Estilo5"><input class="Estilo10" name="txtmonto_depreciado" type="text" id="txtmonto_depreciado" size="15" maxlength="15" value="<?echo $monto_depreciado?>" style="text-align:right" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
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
    if(mvalor=="S"){document.form1.txtdesincorporado.options[1].selected = true;}else{document.form1.txtdesincorporado.options[0].selected = true;}
</script>

		  <tr>
             <td><table width="845">
               <tr>
                 <td width="175"><span class="Estilo5">SITUACI&Oacute;N CONTABLE :</span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtsit_contable" type="text" id="txtsit_contable" size="4" maxlength="2" value="<?echo $sit_contable?>"  onFocus="encender(this)" onBlur="apagar(this)">   
          			<input class="Estilo10" name="btsit_contab" type="button" id="btsit_contab" title="Abrir Catalogo Situacion Contable" onClick="VentanaCentrada('Cat_situacioncontabled.php?criterio=','SIA','','750','500','true')" value="...">     </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txttipo_situacion_cont" type="text" id="txttipo_situacion_cont" size="100" maxlength="100" value="<?echo $tipo_situacion_cont?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="175"><span class="Estilo5">SITUACI&Oacute;N LEGAL :</span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtsit_legal" type="text" id="txtsit_legal" size="4" maxlength="2" value="<?echo $sit_legal?>" onFocus="encender(this)" onBlur="apagar(this)">   
				    <input class="Estilo10" name="btsit_legal" type="button" id="btsit_legal" title="Abrir Catalogo Situacion Legal del Bien" onClick="VentanaCentrada('Cat_situacionlegald.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txttipo_situacion_legal" type="text" id="txttipo_situacion_legal" size="100" maxlength="100" value="<?echo $tipo_situacion_legal?>" readonly>   </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="175"><span class="Estilo5">ESTADO DE CONSERVACI&Oacute;N :</span></td>
                 <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtedo_conservacion" type="text" id="txtedo_conservacion" size="5" maxlength="15" value="<?echo $edo_conservacion?>" onFocus="encender(this)" onBlur="apagar(this)">   
				     <input class="Estilo10" name="btedo_cons" type="button" id="btedo_cons" title="Abrir Catalogo Estado de Conservacion" onClick="VentanaCentrada('Cat_estadoconservaciond.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txtestado_bien" type="text" id="txtestado_bien" size="100" maxlength="100" value="<?echo $edo_bien?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="200"><span class="Estilo5">C.I. RESPONSABLE VERIFICADOR :</span></td>
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtced_res_verificador" type="text" id="txtced_res_verificador" size="15" maxlength="12" value="<?echo $ced_verificador?>" onFocus="encender(this)" onBlur="apagar(this)">  
				   <input class="Estilo10" name="btres_ver" type="button" id="btres_ver" title="Abrir Catalogo Responsable Verificador" onClick="VentanaCentrada('Cat_responsableverd.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
                 <td width="155"><span class="Estilo5">FECHA DE VERIFICACI&Oacute;N :</span></td>
                 <td width="290"><span class="Estilo5"><input class="Estilo10" name="txtfecha_verificacion" type="text" id="txtfecha_verificacion" size="20" maxlength="10" value="<?echo $fecha_verificacion?>" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="175"><span class="Estilo5">NOMBRE DEL VERIFICADOR :</span></td>
                 <td width="670"><span class="Estilo5"><input class="Estilo10" name="txtnombre_res_ver" type="text" id="txtnombre_res_ver" size="100" maxlength="250" value="<?echo $nombre_res_ver?>" readonly>
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
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txcodigo_tipo_incorp" type="text" id="txcodigo_tipo_incorp" size="5" maxlength="5" value="<?echo $codigo_tipo_incorp?>" onFocus="encender(this)" onBlur="apagar(this)">  
				     <input class="Estilo10" name="btcod_mov" type="button" id="btcod_mov" title="Abrir Catalogo Tipo Incorporacion" onClick="VentanaCentrada('Cat_tipoincorpd.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 <td width="450"><span class="Estilo5"><input class="Estilo10" name="txtdenomina_tipo" type="text" id="txtdenomina_tipo" size="90" maxlength="150" value="<?echo $denomina_tipo?>" readonly> </span></td>
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
                 <td width="600"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" size="40" maxlength="32"  value="<?echo $cod_imp_presup?>" onFocus="encender(this)" onBlur="apagar(this)"> 
				   <input class="Estilo10" name="btcod_presupi" type="button" id="btcod_presupi" title="Abrir Catalogo Codigo Presupuestario" onClick="VentanaCentrada('Cat_codigos_presup.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="245"><span class="Estilo5">NOMBRE IMPUTACI&Oacute;N PRESUPUESTARIA :</span></td>
                 <td width="600"><span class="Estilo5"><input class="Estilo10" name="txtdenomina_presup" type="text" id="txtdenomina_presup" size="110" maxlength="150" value="<?echo $nom_imp_presup?>" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="245"><span class="Estilo5">DESCRIPCI&Oacute;N DE INCORPORACI&Oacute;N NO PRESUPUESTARIA :</span></td>
                 <td width="600"><span class="Estilo5"><input class="Estilo10" name="txtdes_imp_nopresup" type="text" id="txtdes_imp_nopresup" size="110" maxlength="150" value="<?echo $des_imp_nopresup?>" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="165"><span class="Estilo5">VALOR INCORPORACI&Oacute;N :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtvalor_incorporacion" type="text" id="txtvalor_incorporacion" size="20" maxlength="15" style="text-align:right"  value="<?echo $valor_incorporacion?>" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                 <td width="150"><span class="Estilo5">FECHA INCORPORACI&Oacute;N :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtfecha_incorporacion" type="text" id="txtfecha_incorporacion" size="15" maxlength="10" value="<?echo $fecha_incorporacion?>" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">   </span></td>
                 <td width="90"><span class="Estilo5">GARANTIA :</span></td>
                 <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtgarantia" type="text" id="txtgarantia" size="10" maxlength="10"  style="text-align:right" value="<?echo $garantia?>" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
               </tr>
             </table></td>
           </tr>
		   <?if ($Cod_Emp=="70"){?>
		   <tr>
             <td><table width="845">
               <tr>
                 <td width="115"><span class="Estilo5">TASA IMPUESTO :</span></td>
                 <td width="85"><span class="Estilo5"><input name="txttasa_impuesto" type="text" id="txttasa_impuesto" size="5" maxlength="5" style="text-align:right" value="<?echo $tasa_impuesto?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
                 <td width="115"><span class="Estilo5">	MONTO IMPUESTO :</span></td>
                 <td width="110"><span class="Estilo5"><input name="txtvalor_impuesto" type="text" id="txtvalor_impuesto" size="12" maxlength="14" style="text-align:right" value="<?echo $valor_impuesto?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
                 <td width="105"><span class="Estilo5">TASA PRORRATA :</span></td>
                 <td width="85"><span class="Estilo5"><input name="txttasa_prorrata" type="text" id="txttasa_prorrata" size="5" maxlength="5"  style="text-align:right" value="<?echo $tasa_prorrata?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
                 <td width="115"><span class="Estilo5">MONTO PRORRATA :</span></td>
                 <td width="115"><span class="Estilo5"><input name="txtvalor_prorrata" type="text" id="txtvalor_prorrata" size="12" maxlength="14"   style="text-align:right" value="<?echo $valor_prorrata?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
               </tr>
             </table></td>
           </tr>
		   <?} else{?>
		   <tr>
             <td><table width="845">
               <tr>
                <td width="85"><span class="Estilo5"><input name="txttasa_impuesto" type="hidden" id="txttasa_impuesto" >   </span></td>
                 <td width="110"><span class="Estilo5"><input name="txtvalor_impuesto" type="hidden" id="txtvalor_impuesto" >   </span></td>
                  <td width="85"><span class="Estilo5"><input name="txttasa_prorrata" type="hidden" id="txttasa_prorrata">   </span></td>
                 <td width="115"><span class="Estilo5"><input name="txtvalor_prorrata" type="hidden" id="txtvalor_prorrata">   </span></td>
               </tr>
             </table></td>
           </tr>
		   <?}?>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="185"><span class="Estilo5">N&Uacute;MERO ORDEN DE COMPRA :</span></td>
                 <td width="170"><span class="Estilo5"><input class="Estilo10" name="txtnro_oc" type="text" id="txtnro_oc" size="10" maxlength="8"  value="<?echo $nro_oc?>" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                 <td width="170"><span class="Estilo5">FECHA ORDEN DE COMPRA :</span></td>
                 <td width="320"><span class="Estilo5"><input class="Estilo10" name="txtfecha_oc" type="text" id="txtfecha_oc" size="15" maxlength="10" value="<?echo $fecha_oc?>" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="185"><span class="Estilo5">N&Uacute;MERO ORDEN DE PAGO :</span></td>
                 <td width="170"><span class="Estilo5"><input class="Estilo10" name="txtnro_op" type="text" id="txtnro_op" size="10" maxlength="8"  value="<?echo $nro_op?>" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                 <td width="170"><span class="Estilo5">FECHA ORDEN DE COMPRA :</span></td>
                 <td width="320"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_op" type="text" id="txtfecha_op" size="15" maxlength="10" value="<?echo $fecha_op?>" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="185"><span class="Estilo5">DOCUMENTO QUE CANCELA :</span></td>
                 <td width="120"><span class="Estilo5"> <select name="txttipo_doc_cancela"> <option>CHEQUE</option><option>NOTA DEBITO</option>  </select></span></td>
                 <td width="140"><span class="Estilo5">N&Uacute;MERO DOCUMENTO :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtnro_doc_cancela" type="text" id="txtnro_doc_cancela" size="10" maxlength="8"  value="<?echo $nro_doc_cancela?>" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                 <td width="140"><span class="Estilo5">FECHA DOCUMENTO :</span></td>
                 <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtfecha_doc_cancela" type="text" id="txtfecha_doc_cancela" size="20"  maxlength="10" value="<?echo $fecha_doc_cancela?>" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">  </span></td>
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
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtnro_factura" type="text" id="txtnro_factura" size="25" maxlength="20"   value="<?echo $nro_factura?>" onFocus="encender(this)" onBlur="apagar(this)">
                     <span class="menu"><strong><strong> </strong></strong></span> </span></td>
                 <td width="180"><span class="Estilo5">FECHA DE FACTURA :</span></td>
                 <td width="320"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_factura" type="text" id="txtfecha_factura" size="15" maxlength="10" value="<?echo $fecha_factura?>" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">
                     </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="140"><span class="Estilo5">CI/RIF PROVEEDOR :</span></td>
                 <td width="155"><span class="Estilo5"><input class="Estilo10" name="txtced_rif_proveedor" type="text" id="txtced_rif_proveedor" size="15" maxlength="12" value="<?echo $ced_rif_proveedor?>" onFocus="encender(this)" onBlur="apagar(this)">   
				   <input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo Proveedores" onClick="VentanaCentrada('Cat_proveedoresd.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 <td width="550"><span class="Estilo5"><input class="Estilo10" name="txtnombre_proveedor" type="text" id="txtnombre_proveedor" size="90" maxlength="100" value="<?echo $nom_proveedor?>" onFocus="encender(this)" onBlur="apagar(this)">    </span></td>
               </tr>
             </table></td>
           </tr>
        </table>
        <table width="812">
		  <tr>
             <td width="840" height="39">&nbsp;</td>
		   </tr>
          <tr>
            <td width="627">&nbsp;</td>
			<td width="5"><input name="txtcod_fuente" type="hidden" id="txtcod_fuente" value="" ></td>
            <td width="81"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
            <td width="88"></td>
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
