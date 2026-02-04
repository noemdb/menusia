<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc"); $cod_modulo="13";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="02-0000010"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$cod_bien_mue='';$p_letra="";  $sql="SELECT * FROM BIEN015 ORDER BY cod_bien_mue";}
else {  $cod_bien_mue = $_GET["Gcod_bien_mue"];  $p_letra=substr($cod_bien_mue, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$cod_bien_mue=substr($cod_bien_mue,1,30);}  else{$cod_bien_mue=substr($cod_bien_mue,0,30);}
  $sql="Select * from BIEN015 where cod_bien_mue='$cod_bien_mue' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN015 ORDER BY cod_bien_mue";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN015 Order by cod_bien_mue desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN015 Where (cod_bien_mue>'$cod_bien_mue') Order by cod_bien_mue";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN015 Where (cod_bien_mue<'$cod_bien_mue') Order by cod_bien_mue desc";}
  //echo $sql,"<br>";
}
$inic_pantalla=0; if($Cod_Emp=="32"){ $inic_pantalla=1;}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Actualiza Ficha de Bienes Muebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
var Gcod_bien_mue = "";
function Llamar_Inc_Bien(){ document.form2.submit(); }
function Llamar_Ventana(url){var murl; var mdes;
    Gcod_bien_mue=document.form1.txtcod_bien_mue.value;    murl=url+Gcod_bien_mue;   mdes=document.form1.txtdesincorporado.value;	
    if (Gcod_bien_mue=="")   {alert("Codigo del Bien debe ser Seleccionado");}   else {document.location = murl;}
}
function Llamar_Modificar(url){var murl; var mdes;
    Gcod_bien_mue=document.form1.txtcod_bien_mue.value;    murl=url+Gcod_bien_mue;   mdes=document.form1.txtdesincorporado.value;
	if(mdes=="SI"){ alert("Codigo del Bien esta Desincorporado");}
      else{ if(Gcod_bien_mue=="")  {alert("Codigo del Bien debe ser Seleccionado");}   else {document.location = murl;} }
}
function Llamar_Activar(url){var murl; var mdes;
    Gcod_bien_mue=document.form1.txtcod_bien_mue.value;    murl=url+Gcod_bien_mue;   mdes=document.form1.txtdesincorporado.value;
	if(mdes=="NO"){ alert("Codigo del Bien No esta Desincorporado");}
      else{ if(Gcod_bien_mue=="")  {alert("Codigo del Bien debe ser Seleccionado");}   else {document.location = murl;} }
}
function Mover_Registro(MPos){var murl;
   murl="Act_fichas_bienes_muebles_pro.php";
   if(MPos=="P"){murl="Act_fichas_bienes_muebles_pro.php?Gcod_bien_mue=P"}
   if(MPos=="U"){murl="Act_fichas_bienes_muebles_pro.php?Gcod_bien_mue=U"}
   if(MPos=="S"){murl="Act_fichas_bienes_muebles_pro.php?Gcod_bien_mue=S"+document.form1.txtcod_bien_mue.value;}
   if(MPos=="A"){murl="Act_fichas_bienes_muebles_pro.php?Gcod_bien_mue=A"+document.form1.txtcod_bien_mue.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar el Bien Mueble ? ");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar el Bien Mueble ? ");
    if (r==true) {url="Delete_fichas_bienes_muebles_pro.php?Gcod_bien_mue="+document.form1.txtcod_bien_mue.value; VentanaCentrada(url,'Eliminar el Bien Mueble','','400','400','true');}}
   else { url="Cancelado, no elimino"; }
}
function Llamar_Formato(){var url;var r;
   r=confirm("Desea Generar el Formato de Bienes ?");
   if (r==true) {url="../bienes/rpt/Rpt_formato_bienes_muebles.php?Gcod_bien_mue="+document.form1.txtcod_bien_mue.value;
    window.open(url);
  }
}

function Llama_Inc_bien_lote(mcod_bien_mue,mnum_bien){var url;
   r=confirm("Desea Generar proceso de Inclusion Bienes por Lotes ?");
   if (r==true) {{url="Incluir_bienes_lotes.php?Gcod_bien_mue="+mcod_bien_mue+"&um_bien="+mnum_bien; VentanaCentrada(url,'Incluir Bienes por Lote','','800','400','true'); }}else {alert("MOVIMIENTO ESTA CONCILIADO");}
}


</script>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>
<?
$cod_bien_mue=""; $cod_clasificacion=""; $num_bien="";$denominacion=""; $cod_dependencia=""; $cod_empresa=""; $cod_direccion=""; $cod_departamento=""; $ced_responsable=""; $fecha_actualizacion=""; $denomina_tipo="";
$ced_responsable_uso="";$cod_metodo_rot="";$ced_rotulador=""; $fecha_rotulacion="";$direccion=""; $cod_region=""; $cod_entidad=""; $cod_municipio=""; $cod_ciudad=""; $cod_parroquia=""; $cod_postal="";$caracteristicas="";$marca="";  $modelo="";$color="";$matricula="";$serial1="";$serial2="";$tipo_clase="";$uso="";$dimension_tam="";$material="";$codigo_alterno="";$ano=""; $antiguedad="";$cod_contablea="";$cod_contabled="";$tipo_depreciacion="";$tasa_deprec=""; $vida_util=""; $valor_residual=""; $sit_contable="";$sit_legal=""; $edo_conservacion="";$ced_verificador=""; $fecha_verificacion=""; $tipo_incorporacion=""; $cod_imp_presup=""; $nom_imp_presup="";$des_imp_nopresup=""; $fecha_incorporacion=""; $valor_incorporacion="";$garantia="";$nro_oc=""; $fecha_oc=""; $nro_op=""; $fecha_op=""; $tipo_doc_cancela=""; $nro_doc_cancela=""; $fecha_doc_cancela="";$ced_rif_proveedor=""; $codigo_tipo_incorp=""; $nom_proveedor=""; $cod_presup_dep=""; $monto_depreciado=""; $nro_factura=""; $fecha_factura=""; $desincorporado=""; $fecha_desincorporado="";$des_desincorporado="";$bien_en_salida="";$status_bien_inm=""; $usuario_sia=""; $inf_usuario="";$accesorios="";  $descripcion_b="";  $denominacion_emp=""; $denominacion_dependencia=""; $denominacion_dir="";$denominacion_dep="";  $nombre_res="";  $nombre_res_uso="";  $metodo_rotula="";  $nombre_res_rotu="";$nombre_region="";  $estado="";  $nombre_municipio=""; $nombre_ciudad="";  $nombre_parroquia=""; $tipo_situacion_cont="";  $tipo_situacion_legal=""; $edo_bien="";  $nombre_res_ver="";
$tasa_impuesto=0;$valor_impuesto=0;$tasa_prorrata=0;$valor_prorrata=0;$valor_depreciar=0; $denominacion_emp="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){  if ($p_letra=="S"){$sql="SELECT * From BIEN015 ORDER BY cod_bien_mue";}  if ($p_letra=="A"){$sql="SELECT * From BIEN015 ORDER BY cod_bien_mue desc";}  $res=pg_query($sql);  $filas=pg_num_rows($res);}
if($filas>=1){  $registro=pg_fetch_array($res,0);
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
$Ssql="SELECT * FROM bien007 where cod_empresa='".$cod_empresa."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_emp=$registro["denominacion_emp"];}
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
//Tipo de INCORPORACION
$Ssql="SELECT * FROM bien003 where codigo='".$codigo_tipo_incorp."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denomina_tipo=$registro["denomina_tipo"];}

$cod_dep_t=""; $nom_dep_t=""; $ced_resp_p="";  $nom_resp_p=""; $cod_pos_t=""; $cod_reg_t=""; $cod_ent_t=""; $cod_mun_t=""; $cod_ciu_t=""; $cod_parro_t=""; $direccion_t="";
$Ssql="SELECT * FROM bien001 order by cod_dependencia"; $resultado=pg_query($Ssql); 
if ($registro=pg_fetch_array($resultado,0)){$cod_dep_t=$registro["cod_dependencia"]; $nom_dep_t=$registro["denominacion_dep"]; $ced_resp_p=$registro["ci_contacto"]; $nom_resp_p=$registro["nombre_contacto"]; 
$cod_reg_t=$registro["cod_region"]; $cod_ent_t=$registro["cod_entidad"]; $cod_mun_t=$registro["cod_municipio"]; $cod_ciu_t=$registro["cod_ciudad"]; $cod_parro_t=$registro["cod_parroquia"]; $direccion_t=$registro["direccion_dep"];  $cod_pos_t=$registro["cod_postal_dep"];}
$sql="Select * from SIA000 order by campo001"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){ $ced_rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }
$formato_bien=""; $long_num_bien=0; $periodo="01"; $campo502=""; $doc_caus_inm=""; $doc_caus_mue=""; $doc_caus_sem=""; $num_bien_unico="S"; $nombre_parroquia_t=""; $nombre_ciudad_t=""; $nombre_municipio_t=""; $estado_t=""; $nombre_region_t="";$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);
if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; $formato_bien=$registro["campo504"];$long_num_bien=$registro["campo549"];$doc_caus_inm=$registro["campo509"]; $doc_caus_mue=$registro["campo510"]; $doc_caus_sem=$registro["campo511"];}
$num_bien_unico=substr($campo502,3,1);  $mod_solo_transf=substr($campo502,6,1);
//Regiones
$Ssql="SELECT * FROM pre092 where cod_region='".$cod_reg_t."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_region_t=$registro["nombre_region"];}
//Entidad Federal
$Ssql="SELECT * FROM pre091 where cod_estado='".$cod_ent_t."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$estado_t=$registro["estado"];}
//Municipios
$Ssql="SELECT * FROM pre093 where cod_municipio='".$cod_mun_t."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_municipio_t=$registro["nombre_municipio"];}
//Ciudad
$Ssql="SELECT * FROM pre094 where cod_ciudad='".$cod_ciu_t."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_ciudad_t=$registro["nombre_ciudad"];}
//Parroquia
$Ssql="SELECT * FROM pre096 where cod_parroquia='".$cod_parro_t."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_parroquia_t=$registro["nombre_parroquia"];}
$valor_incorporacion=formato_monto($valor_incorporacion); $monto_depreciado=formato_monto($monto_depreciado); 
$tasa_deprec=formato_monto($tasa_deprec);    $vida_util=formato_monto($vida_util);   $valor_residual=formato_monto($valor_residual); 
if($desincorporado=="S"){$desincorporado="SI";}else{$desincorporado="NO";} $cod_emp_t="001"; $nom_emp_t="";
$sql="SELECT cod_empresa,denominacion_emp  FROM BIEN007 order by cod_empresa"; $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$cod_emp_t=$registro["cod_empresa"]; $nom_emp_t=$registro["denominacion_emp"]; }

$fecha_hoy=asigna_fecha_hoy();

$fecha_fin=formato_ddmmaaaa($Fec_Fin_Ejer);  if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">FICHA BIENES MUEBLES

    <!-- INI nmdb 02-03-2018 -->
    <?php if (($Mcamino{7} == "S") and ($desincorporado == "SI")) { ?> 
      <br>
      <font size="-2" color="red">El bien está desincorporado</font>
    <?php }?>
    <!-- INI nmdb 02-03-2018 -->

    </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="976" height="1640" border="0" id="tablacuerpo">
  <tr>  
   <td>
    <table width="92" height="1640" border="1" cellpadding="0" cellspacing="0" id="tablam">
      <td width="86">
	    <td width="92" height="1635"><table width="92" height="1635" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
		 <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
		  <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_Bien()";
					onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_Bien()">Incluir</A></td>
		  </tr>
		 <?} if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
		  <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Modificar('Mod_fichas_bienes_muebles_pro.php?Gcod_bien_mue=')";
					onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Modificar('Mod_fichas_bienes_muebles_pro.php?Gcod_bien_mue=');">Modificar</A></td>
		  </tr>
		  <?if (($Cod_Emp=="70")or($Cod_Emp=="71")){?>
		  <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Modificar('Mod_componentes_pro.php?Gcod_bien_mue=')";
					onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Modificar('Mod_componentes_pro.php?Gcod_bien_mue=');">Componentes</A></td>
		  </tr>
		  <?}if (($Cod_Emp=="71")){?>
		  <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Modificar('Mod_rep_mejoras_pro.php?Gcod_bien_mue=')";
					onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Modificar('Mod_rep_mejoras_pro.php?Gcod_bien_mue=');">Reparaciones y Mejoras</A></td>
		  </tr>
		  
		  <?}if (($Cod_Emp=="332")){?>
		  <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
				  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Inc_bien_lote('<?echo $cod_bien_mue?>','<? echo $num_bien?>');" class="menu">Incluir Bienes por Lote</a></div></td>
		  </tr>
		  <?} ?>
		 <?} if ($Mcamino{2}=="S"){?>
		   <tr>
            <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cons_bien_inmuebles.php?Gcod_bien_mue=<?echo $cod_bien_mue?>&Gnum_bien=<?echo $num_bien?>')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cons_bien_inmuebles.php?Gcod_bien_mue=<?echo $cod_bien_mue?>&Gnum_bien=<?echo $num_bien?>" class="menu">Consultar por Numero Bien</a></td>
          </tr>	
		  <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
				   onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
		  </tr>
		  <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
					  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
		  </tr>
		  <tr>
			<td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
					  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
		  </tr>
		  <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
							  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
		  </tr>
		  <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_fichas_bienes_muebles_pro.php')";
							  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_fichas_bienes_muebles_pro.php" class="menu">Catalogo</a></td>
		  </tr>
		 <?} if ($Mcamino{6}=="S"){?>
		  <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
				   onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
		  </tr>
		 <?} if (($Mcamino{7}=="S")and($desincorporado=="SI")){?> 
		  <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Activar('Activar_fichas_bienes_muebles.php?Gcod_bien_mue=')";
					onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Activar('Activar_fichas_bienes_muebles.php?Gcod_bien_mue=');">Activar Bien Desincorporado</A></td>
		  </tr>
		 <?} if (($Mcamino{4}=="S")and($SIA_Cierre=="N")){?>
			<tr>
			  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
			  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Formato();" class="menu">Formato</a></td>
			</tr> 
		 <?} ?>		  
		  <tr>
			<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
				  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
		  </tr>
		  <tr>
			<td >&nbsp;</td>
		  </tr>
		</table></td>
	</table>
    <p>&nbsp;</p></td>
    <td width="868"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
    <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:861px; height:523px; z-index:1; top: 74px; left: 121px;">
         <table width="848" border="0" align="center" >
           <tr>
             <td><table width="845">
               <tr>
                 <td width="180"><span class="Estilo5">C&Oacute;DIGO DE CLASIFICACI&Oacute;N :</span></td>
                 <td width="145"><span class="Estilo5"><input class="Estilo10" name="txtcod_clasificacion" type="text" id="txtcod_clasificacion" size="10" maxlength="10"  value="<?echo $cod_clasificacion?>" readonly> </span></td>
                 <td width="520"><span class="Estilo5"> <input class="Estilo10" name="txtnom_clasificacion" type="text" id="txtnom_clasificacion" size="80" maxlength="250" value="<?echo $descripcion_b?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">N&Uacute;MERO DEL BIEN:</span></td>
                 <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtnum_bien" type="text" id="txtnum_bien" size="20" maxlength="20" value="<?echo $num_bien?>" readonly></div></td>
                 <td width="220"><span class="Estilo5">C&Oacute;DIGO DEL BIEN INMUEBLE :</span></td>
                 <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtcod_bien_mue" type="text" id="txtcod_bien_mue"  size="40" maxlength="30" value="<?echo $cod_bien_mue?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="165"><span class="Estilo5">DENOMINACI&Oacute;N DEL BIEN :</span></td>
                 <td width="680"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="120" maxlength="250" value="<?echo $denominacion?>" readonly></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="150"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></td>
                 <td width="125"><span class="Estilo5"><input class="Estilo10" name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4" value="<?echo $cod_dependencia?>" readonly>    </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="100" maxlength="250" value="<?echo $denominacion_dependencia?>" readonly>    </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="150"><span class="Estilo5">C&Oacute;DIGO DIRECCI&Oacute;N :</span></td>
                 <td width="125"><span class="Estilo5"> <input class="Estilo10" name="txtcod_direccion" type="text" id="txtcod_direccion" size="5" maxlength="4" value="<?echo $cod_direccion?>" readonly>   </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_dir" type="text" id="txtdenominacion_dir" size="100" maxlength="100" value="<?echo $denominacion_dir?>" readonly>   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtcod_departamento" type="text" id="txtcod_departamento" size="20" maxlength="200" value="<?echo $cod_departamento?>" readonly>   </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="100" maxlength="100"  value="<?echo $denominacion_dep?>" readonly>   </span></td>
               </tr>
             </table></td>
           </tr>   
           <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">C&Oacute;DIGO EMPRESA :</span></td>
				 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtcod_empresa" type="text" id="txtcod_empresa" size="5" maxlength="3"  value="<?echo $cod_empresa?>" readonly>   </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_emp" type="text" id="txtdenominacion_emp" size="100" maxlength="100"  value="<?echo $denominacion_emp?>" readonly>   </span></td>
               </tr>
             </table></td>
           </tr>  		   
           <tr>
             <td><table width="845">
               <tr>
                 <td width="180"><span class="Estilo5">C.I. RESPONSABLE PRIMARIO :</span></td>
                 <td width="145"><span class="Estilo5"><input class="Estilo10" name="txtced_responsable" type="text" id="txtced_responsable" size="15" maxlength="12"  value="<?echo $ced_responsable?>" readonly>   </span></td>
                 <td width="520"><span class="Estilo5"><input class="Estilo10" name="txtnombre_respp" type="text" id="txtnombre_respp" size="100" maxlength="250"  value="<?echo $nombre_res?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="180"><span class="Estilo5">C.I. RESPONSABLE DE USO :</span></td>
                 <td width="145"><span class="Estilo5"> <input class="Estilo10" name="txtced_responsable_uso" type="text" id="txtced_responsable_uso" size="15" maxlength="12"  value="<?echo $ced_responsable_uso?>" readonly>   </span></td>
                 <td width="520"><span class="Estilo5"><input class="Estilo10" name="txtnombre_res" type="text" id="txtnombre_res" size="100" maxlength="250"  value="<?echo $nombre_res_uso?>" readonly>    </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="165"><span class="Estilo5">METODO DE ROTULACI&Oacute;N :</span></td>
                 <td width="110"><span class="Estilo5"><input class="Estilo10" name="txtcod_metodo_rot" type="text" id="txtcod_metodo_rot" size="4" maxlength="2" value="<?echo $cod_metodo_rot?>" readonly>   </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txtnom_metodo_rot" type="text" id="txtnom_metodo_rot" size="100" maxlength="250" value="<?echo $metodo_rotula?>" readonly>     </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">C&Eacute;DULA DE ROTULADOR :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtced_rotulador" type="text" id="txtced_rotulador" size="15" maxlength="12"  value="<?echo $ced_rotulador?>" readonly>   </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txtnombre_res" type="text" id="txtnombre_res" size="100" maxlength="250"  value="<?echo $nombre_res_rotu?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">FECHA DE ROTULACI&Oacute;N :</span></td>
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtfecha_rotulacion" type="text" id="txtfecha_rotulacion" size="20" maxlength="15" value="<?echo $fecha_rotulacion?>" readonly>  </span></td>
                 <td width="200"><span class="Estilo5">FECHA ULTIMA ACTUALIZACI&Oacute;N :</span></td>
                 <td width="290"><span class="Estilo5"><input class="Estilo10" name="txtfecha_actualizacion" type="text" id="txtfecha_actualizacion" size="20" maxlength="15" value="<?echo $fecha_actualizacion?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">DIRECCI&Oacute;N :</span></td>
                 <td width="720"><div align="left"><textarea name="txtdireccion" cols="70" onFocus="encender(this)" onBlur="apagar(this)" readonly  class="headers" id="txtdireccion"><?echo $direccion?></textarea>  </div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">REGI&Oacute;N :</span></td>
                 <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtcod_region" type="text" id="txtcod_region" size="4" maxlength="2" value="<?echo $cod_region?>" readonly>   </span></td>
                 <td width="620"><span class="Estilo5"><input class="Estilo10" name="txtnombre_region" type="text" id="txtnombre_region" size="100" maxlength="250"  value="<?echo $nombre_region?>" readonly>   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">ENTIDAD FEDERAL :</span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtcod_entidad" type="text" id="txtcod_entidad" size="4" maxlength="2" value="<?echo $cod_entidad?>" readonly>   </span></td>
                 <td width="620"><span class="Estilo5"><input class="Estilo10" name="txtnombre_entidad" type="text" id="txtnombre_entidad" size="100" maxlength="250"  value="<?echo $estado?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">MUNICIPIO :</span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtcod_municipio" type="text" id="txtcod_municipio" size="5" maxlength="4" value="<?echo $cod_municipio?>" readonly>  </span></td>
                 <td width="620"><span class="Estilo5"><input class="Estilo10" name="txtnombre_municipio" type="text" id="txtnombre_municipio" size="100" maxlength="250" value="<?echo $nombre_municipio?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">CIUDAD :</span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtcod_ciudad" type="text" id="txtcod_ciudad" size="5" maxlength="4"  value="<?echo $cod_ciudad?>" readonly>    </span></td>
                 <td width="620"><span class="Estilo5"><input class="Estilo10" name="txtnombre_ciudad" type="text" id="txtnombre_ciudad" size="100" maxlength="250" value="<?echo $nombre_ciudad?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">PARROQUIA :</span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtcod_parroquia" type="text" id="txtcod_parroquia" size="7" maxlength="6" value="<?echo $cod_parroquia?>" readonly>  </span></td>
                 <td width="620"><span class="Estilo5"><input class="Estilo10" name="txtnombre_parroquia" type="text" id="txtnombre_parroquia" size="100" maxlength="250" value="<?echo $nombre_parroquia?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">C&Oacute;DIGO POSTAL :</span></td>
                 <td width="720"><span class="Estilo5"><input class="Estilo10" name="txtcod_postal" type="text" id="txtcod_postal" size="12" maxlength="10" value="<?echo $cod_postal?>" readonly></span></td>
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
                 <td width="720"><div align="left"><textarea name="textcaracteristicas" cols="70" readonly  class="headers" id="textcaracteristicas"><?echo $caracteristicas?></textarea> </div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">MARCA :</span></td>
                 <td width="250"><span class="Estilo5"> <input class="Estilo10" name="txtmarca" type="text" id="txtmarca" size="30" maxlength="30" value="<?echo $marca?>" readonly></span></td>
                 <td width="150"><span class="Estilo5">MODELO :</span></td>
                 <td width="320"><span class="Estilo5"><input class="Estilo10" name="txtmodelo" type="text" id="txtmodelo" size="30" maxlength="30" value="<?echo $modelo?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">COLOR :</span></td>
                 <td width="250"><span class="Estilo5"> <input class="Estilo10" name="txtcolor" type="text" id="txtcolor" size="30" maxlength="30" value="<?echo $color?>" readonly> </span></td>
                 <td width="150"><span class="Estilo5">MATRICULA :</span></td>
                 <td width="320"><span class="Estilo5"><input class="Estilo10" name="txtmatricula" type="text" id="txtmatricula" size="30" maxlength="30" value="<?echo $matricula?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">SERIAL :</span></td>
                 <td width="250"><span class="Estilo5"> <input class="Estilo10" name="txtserial1" type="text" id="txtserial1" size="30" maxlength="30" value="<?echo $serial1?>" readonly> </span></td>
                 <td width="150"><span class="Estilo5">SERIAL 2 :</span></td>
                 <td width="320"><span class="Estilo5"><input class="Estilo10" name="txtserial2" type="text" id="txtserial2" size="30" maxlength="30"  value="<?echo $serial2?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">TIPO O CLASE :</span></td>
                 <td width="250"><span class="Estilo5"><input class="Estilo10" name="txttipo_clase" type="text" id="txttipo_clase" size="30" maxlength="30" value="<?echo $tipo_clase?>" readonly>  </span></td>
                 <td width="150"><span class="Estilo5">USO :</span></td>
                 <td width="320"><span class="Estilo5"><input class="Estilo10" name="txtuso" type="text" id="txtuso" size="30" maxlength="15" value="<?echo $uso?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">DIMENSION O TAMA&Ntilde;O :</span></td>
                 <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtdimension_tam" type="text" id="txtdimension_tam" size="30" maxlength="30" value="<?echo $dimension_tam?>" readonly>   </span></td>
                 <td width="150"><span class="Estilo5">MATERIAL :</span></td>
                 <td width="320"><span class="Estilo5"><input class="Estilo10" name="txtmaterial" type="text" id="txtmaterial" size="30" maxlength="30" value="<?echo $material?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">C&Oacute;DIGO ALTERNO :</span></td>
                 <td width="240"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_alterno" type="text" id="txtcodigo_alterno" size="30" maxlength="30"  value="<?echo $codigo_alterno?>" readonly>   </span></td>
                 <td width="60"><span class="Estilo5">A&Ntilde;O :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtano" type="text" id="txtano" size="5" maxlength="14" value="<?echo $ano?>" readonly> </span></td>
                 <td width="100"><span class="Estilo5">ANTIGUEDAD :</span></td>
                 <td width="170"><span class="Estilo5"><input class="Estilo10" name="txtantiguedad" type="text" id="txtantiguedad" size="10" maxlength="15" value="<?echo $antiguedad?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">ACCESORIOS :</span></td>
                 <td width="720"><div align="left"><textarea name="txtaccesorios" cols="70" onFocus="encender(this)" readonly class="headers" id="txtaccesorios"><?echo $accesorios?></textarea>   </div></td>
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
                 <td width="225"><span class="Estilo5"><input class="Estilo10" name="txtcod_contablea" type="text" id="txtcod_contablea" size="30" maxlength="25" value="<?echo $cod_contablea?>" readonly>   </span></td>
                 <td width="220"><span class="Estilo5">C&Oacute;DIGO CONTABLE DEPRECIACI&Oacute;N :</span></td>
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtcod_contabled" type="text" id="txtcod_contabled" size="30" maxlength="25" value="<?echo $cod_contabled?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="195"><span class="Estilo5">TIPO DE DEPRECIACI&Oacute;N :</span></td>
				 <td width="250"><span class="Estilo5"><input class="Estilo10" name="txttipo_depreciacion" type="text" id="txttipo_depreciacion" size="15" maxlength="15" value="<?echo $tipo_depreciacion ?>" readonly></span></td>
                 <td width="150"><span class="Estilo5">TASA DEPRECIACI&Oacute;N :</span></td>
                 <td width="250"><span class="Estilo5"><input class="Estilo10" name="txttasa_deprec" type="text" id="txttasa_deprec" style="text-align:right"  size="10" maxlength="15" value="<?echo $tasa_deprec?>" readonly>    </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="195"><span class="Estilo5">VIDA &Uacute;TIL EN A&Ntilde;OS :</span></td>
                 <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtvida_util" type="text" id="txtvida_util" style="text-align:right"  size="10" maxlength="15" value="<?echo $vida_util?>" readonly>    </span></td>
                 <td width="150"><span class="Estilo5">VALOR RESIDUAL :</span></td>
                 <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtvalor_residual" type="text" id="txtvalor_residual" style="text-align:right"  size="20" maxlength="15" value="<?echo $valor_residual?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="300"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO DE DEPRECIACI&Oacute;N :</span></td>
                 <td width="220"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup_dep" type="text" id="txtcod_presup_dep" size="35" maxlength="32" value="<?echo $cod_presup_dep?>" readonly>  </span></td>
                 <td width="145"><span class="Estilo5">MONTO DEPRECIADO :</span></td>
                 <td width="180"><span class="Estilo5"><input class="Estilo10" name="txtmonto_depreciado" type="text" id="txtmonto_depreciado" style="text-align:right"  size="20" maxlength="15" value="<?echo $monto_depreciado?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>

           <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">DESINCORPORADO :</span></td>
				 <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtdesincorporado" type="text" id="txtdesincorporado" size="4" maxlength="2" value="<?echo $desincorporado?>" readonly>   </span></td>                 
                 <?if($desincorporado=="SI"){?>
				 <td width="200"><span class="Estilo5">FECHA DESINCORPORACI&Oacute;N :</span></td>
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtfecha_desincorporado" type="text" id="txtfecha_desincorporado" size="20" maxlength="15"  value="<?echo $fecha_desincorporado?>" readonly> </span></td>
				 <?}else{?>
				 <td width="400"><span class="Estilo5"></span></td>
				 <?}?>
               </tr>
             </table></td>
           </tr>

           <tr>
             <td><table width="845">
               <tr>
                 <td width="175"><span class="Estilo5">SITUACI&Oacute;N CONTABLE :</span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtsit_contable" type="text" id="txtsit_contable" size="4" maxlength="2" value="<?echo $sit_contable?>" readonly>    </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txttipo_situacion_cont" type="text" id="txttipo_situacion_cont" size="100" maxlength="100" value="<?echo $tipo_situacion_cont?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="175"><span class="Estilo5">SITUACI&Oacute;N LEGAL :</span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtsit_legal" type="text" id="txtsit_legal" size="4" maxlength="2" value="<?echo $sit_legal?>" readonly>   </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txttipo_situacion_legal" type="text" id="txttipo_situacion_legal" size="100" maxlength="100" value="<?echo $tipo_situacion_legal?>" readonly>   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="175"><span class="Estilo5">ESTADO DE CONSERVACI&Oacute;N :</span></td>
                 <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtedo_conservacion" type="text" id="txtedo_conservacion" size="5" maxlength="15" value="<?echo $edo_conservacion?>" readonly>   </span></td>
                 <td width="570"><span class="Estilo5"><input class="Estilo10" name="txtedo_bien" type="text" id="txtedo_bien" size="100" maxlength="100" value="<?echo $edo_bien?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="200"><span class="Estilo5">C.I. RESPONSABLE VERIFICADOR :</span></td>
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtced_verificador " type="text" id="txtced_verificador " size="15" maxlength="12" value="<?echo $ced_verificador?>" readonly>  </span></td>
                 <td width="155"><span class="Estilo5">FECHA DE VERIFICACI&Oacute;N :</span></td>
                 <td width="290"><span class="Estilo5"><input class="Estilo10" name="txtfecha_verificacion" type="text" id="txtfecha_verificacion" size="20" maxlength="15"  value="<?echo $fecha_verificacion?>" readonly>  </span></td>
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
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txcodigo_tipo_incorp" type="text" id="txtcodigo_tipo_incorp" size="5" maxlength="5" value="<?echo $codigo_tipo_incorp?>" readonly>  </span></td>
                 <td width="500"><span class="Estilo5"><input class="Estilo10" name="txtdenomina_tipo" type="text" id="txtdenomina_tipo" size="100" maxlength="150" value="<?echo $denomina_tipo?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="195"><span class="Estilo5">TIPO DE INCORPORACI&Oacute;N :</span></td>
                 <td width="650"><span class="Estilo5"><input class="Estilo10" name="txttipo_incorporacion" type="text" id="txttipo_incorporacion" size="30" maxlength="30" value="<?echo $tipo_incorporacion ?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="245"><span class="Estilo5">C&Oacute;D. IMPUTACI&Oacute;N PRESUPUESTARIA :</span></td>
                 <td width="600"><span class="Estilo5"><input class="Estilo10" name="txtcod_imp_presup" type="text" id="txtcod_imp_presup" size="35" maxlength="32"  value="<?echo $cod_imp_presup?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="245"><span class="Estilo5">NOMBRE IMPUTACI&Oacute;N PRESUPUESTARIA :</span></td>
                 <td width="600"><span class="Estilo5"><input class="Estilo10" name="txtnom_imp_presup" type="text" id="txtnom_imp_presup" size="110" maxlength="150" value="<?echo $nom_imp_presup?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="245"><span class="Estilo5">DESCRIPCI&Oacute;N DE INCORPORACI&Oacute;N NO PRESUPUESTARIA :</span></td>
                 <td width="600"><span class="Estilo5"><input class="Estilo10" name="txtdes_imp_nopresup" type="text" id="txtdes_imp_nopresup" size="110" maxlength="150" value="<?echo $des_imp_nopresup?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="165"><span class="Estilo5">VALOR INCORPORACI&Oacute;N :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtvalor_incorporacion" type="text" id="txtvalor_incorporacion" style="text-align:right"  size="20" maxlength="15" value="<?echo $valor_incorporacion?>" readonly>   </span></td>
                 <td width="150"><span class="Estilo5">FECHA INCORPORACI&Oacute;N :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtfecha_incorporacion" type="text" id="txtfecha_incorporacion" size="15" maxlength="15"  value="<?echo $fecha_incorporacion?>" readonly>   </span></td>
                 <td width="90"><span class="Estilo5">GARANTIA :</span></td>
                 <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtgarantia" type="text" id="txtgarantia" size="10" maxlength="15" value="<?echo $garantia?>" readonly>   </span></td>
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
                 <td width="85"><span class="Estilo5"><input name="txttasa_prorrata" type="text" id="txttasa_prorrata" size="5" maxlength="5"  style="text-align:right" value="<?echo $tasa_prorrata?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">   </span></td>
                 <td width="115"><span class="Estilo5">MONTO PRORRATA :</span></td>
                 <td width="115"><span class="Estilo5"><input name="txtvalor_prorrata" type="text" id="txtvalor_prorrata" size="12" maxlength="14"   style="text-align:right" value="<?echo $valor_prorrata?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
               </tr>
             </table></td>
           </tr>
		   <?}?>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="185"><span class="Estilo5">N&Uacute;MERO ORDEN DE COMPRA :</span></td>
                 <td width="170"><span class="Estilo5"><input class="Estilo10" name="txtnro_oc" type="text" id="txtnro_oc" size="10" maxlength="8"  value="<?echo $nro_oc?>" readonly>   </span></td>
                 <td width="170"><span class="Estilo5">FECHA ORDEN DE COMPRA :</span></td>
                 <td width="320"><span class="Estilo5"><input class="Estilo10" name="txtfecha_oc" type="text" id="txtfecha_oc" size="15" maxlength="15" value="<?echo $fecha_oc?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="185"><span class="Estilo5">N&Uacute;MERO ORDEN DE PAGO :</span></td>
                 <td width="170"><span class="Estilo5"><input class="Estilo10" name="txtnro_op" type="text" id="txtnro_op" size="10" maxlength="8"  value="<?echo $nro_op?>" readonly>   </span></td>
                 <td width="170"><span class="Estilo5">FECHA ORDEN DE PAGO :</span></td>
                 <td width="320"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_op" type="text" id="txtfecha_op" size="15" maxlength="15" value="<?echo $fecha_op?>" readonly>   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="185"><span class="Estilo5">DOCUMENTO QUE CANCELA :</span></td>
				 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txttipo_doc_cancela" type="text" id="txttipo_doc_cancela" size="10" maxlength="10" value="<?echo $tipo_doc_cancela ?>" readonly></span></td>
                 <td width="140"><span class="Estilo5">N&Uacute;MERO DOCUMENTO :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtnro_doc_cancela" type="text" id="txtnro_doc_cancela" size="10" maxlength="8"  value="<?echo $nro_doc_cancela?>" readonly>  </span></td>
                 <td width="140"><span class="Estilo5">FECHA DOCUMENTO :</span></td>
                 <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtfecha_doc_cancela" type="text" id="txtfecha_doc_cancela" size="20" maxlength="15" value="<?echo $fecha_doc_cancela?>" readonly>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="145"><span class="Estilo5">N&Uacute;MERO DE FACTURA :</span></td>
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtnro_factura" type="text" id="txtnro_factura" size="25" maxlength="20"   value="<?echo $nro_factura?>" readonly>
                     <span class="menu"><strong><strong> </strong></strong></span> </span></td>
                 <td width="180"><span class="Estilo5">FECHA DE FACTURA :</span></td>
                 <td width="320"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_factura" type="text" id="txtfecha_factura" size="15" maxlength="10"   value="<?echo $fecha_factura?>" readonly>
                     </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="145"><span class="Estilo5">CI/RIF PROVEEDOR :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtced_rif_proveedor" type="text" id="txtced_rif_proveedor" size="15" maxlength="12"  value="<?echo $ced_rif_proveedor?>" readonly>   </span></td>
                 <td width="550"><span class="Estilo5"><input class="Estilo10" name="txtnom_proveedor" type="text" id="txtnom_proveedor" size="100" maxlength="100" value="<?echo $nom_proveedor?>" readonly>    </span></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <p>&nbsp;</p>
       </div>
      </form>
    </td>
  </tr>
</table>

<form name="form2" method="post" action="Inc_fichas_bienes_muebles_pro.php">
<table width="100">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtformato_bien" type="hidden" id="txtformato_bien" value="<?echo $formato_bien?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtlong_num_bien" type="hidden" id="txtlong_num_bien" value="<?echo $long_num_bien?>" ></td>
     <td width="5"><input class="Estilo10" name="txtnum_bien_unico" type="hidden" id="txtnum_bien_unico" value="<?echo $num_bien_unico?>" ></td> 
	 <td width="5"><input class="Estilo10" name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input class="Estilo10" name="txtcod_emp" type="hidden" id="txtcod_emp" value="<?echo $Cod_Emp?>" ></td> 
	 
	 

	 <?if ($inic_pantalla==0){?>
     <td width="5"><input class="Estilo10" name="txtcod_dep" type="hidden" id="txtcod_dep" value="<?echo $cod_dep_t?>" ></td>
     <td width="5"><input class="Estilo10" name="txtnom_dep" type="hidden" id="txtnom_dep" value="<?echo $nom_dep_t?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtc_empresa" type="hidden" id="txtc_empresa" value="<?echo $cod_emp_t?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtn_empresa" type="hidden" id="txtn_empresa" value="<?echo $nom_emp_t?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtced_resp_p" type="hidden" id="txtced_resp_p" value="<?echo $ced_resp_p?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtnomb_resp_p" type="hidden" id="txtnomb_resp_p" value="<?echo $nom_resp_p?>" ></td>
	 
	 <td width="5"><input class="Estilo10" name="txtdireccion_t" type="hidden" id="txtdireccion_t" value="<?echo $direccion_t?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcod_pos_t" type="hidden" id="txtcod_pos_t" value="<?echo $cod_pos_t?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcod_reg_t" type="hidden" id="txtcod_reg_t" value="<?echo $cod_reg_t?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcod_ent_t" type="hidden" id="txtcod_ent_t" value="<?echo $cod_ent_t?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcod_mun_t" type="hidden" id="txtcod_mun_t" value="<?echo $cod_mun_t?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcod_ciu_t" type="hidden" id="txtcod_ciu_t" value="<?echo $cod_ciu_t?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcod_parro_t" type="hidden" id="txtcod_parro_t" value="<?echo $cod_parro_t?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtnombre_region_t" type="hidden" id="txtnombre_region_t" value="<?echo $nombre_region_t?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtestado_t" type="hidden" id="txtestado_t" value="<?echo $estado_t?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtnombre_municipio_t" type="hidden" id="txtnombre_municipio_t" value="<?echo $nombre_municipio_t?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtnombre_ciudad_t" type="hidden" id="txtnombre_ciudad_t" value="<?echo $nombre_ciudad_t?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtnombre_parroquia_t" type="hidden" id="txtnombre_parroquia_t" value="<?echo $nombre_parroquia_t?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_rot" type="hidden" id="txtfecha_rot" value="<?echo $fecha_hoy?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_act" type="hidden" id="txtfecha_act" value="<?echo $fecha_hoy?>" ></td>	
	 
	 
	 <td width="5"><input class="Estilo10" name="txtcod_clasf" type="hidden" id="txtcod_clasf" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtnom_clasf" type="hidden" id="txtnom_clasf" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtdenom" type="hidden" id="txtdenom" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtcod_dir" type="hidden" id="txtcod_dir" value="" ></td>
     <td width="5"><input class="Estilo10" name="txtnom_dir" type="hidden" id="txtnom_dir" value="" ></td>	
	 <td width="5"><input class="Estilo10" name="txtcod_depart" type="hidden" id="txtcod_depart" value="" ></td>
     <td width="5"><input class="Estilo10" name="txtnom_depart" type="hidden" id="txtnom_depart" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtced_resp_u" type="hidden" id="txtced_resp_u" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtnomb_resp_u" type="hidden" id="txtnomb_resp_u" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtcod_metodo_r" type="hidden" id="txtcod_metodo_r" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtmetodo_rot" type="hidden" id="txtmetodo_rot" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtced_rot" type="hidden" id="txtced_rot" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtnombre_res_r" type="hidden" id="txtnombre_res_r" value="" ></td>	
	 
	 
	 <td width="5"><input class="Estilo10" name="txtcaract" type="hidden" id="txtcaract" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtmarcat" type="hidden" id="txtmarcat" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtmodelot" type="hidden" id="txtmodelot" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtcolort" type="hidden" id="txtcolort" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtmatrict" type="hidden" id="txtmatrict" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtserial1t" type="hidden" id="txtserial1t" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtserial2t" type="hidden" id="txtserial2t" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txttipo_claset" type="hidden" id="txttipo_claset" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtusot" type="hidden" id="txtusot" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtdimension_t" type="hidden" id="txtdimension_t" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtmaterialt" type="hidden" id="txtmaterialt" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtcod_alt" type="hidden" id="txtcod_alt" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtanot" type="hidden" id="txtanot" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtantigt" type="hidden" id="txtantigt" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtaccest" type="hidden" id="txtaccest" value="" ></td>	
	 
	 <td width="5"><input class="Estilo10" name="txtcod_conta" type="hidden" id="txtcod_conta" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txttasa_dep" type="hidden" id="txttasa_dep" value="0" ></td>	
	 <td width="5"><input class="Estilo10" name="txtcod_contd" type="hidden" id="txtcod_contd" value="" ></td>	
	 <td width="5"><input class="Estilo10" name="txtvida_u" type="hidden" id="txtvida_u" value="0" ></td>
	 <td width="5"><input class="Estilo10" name="txtvalor_res" type="hidden" id="txtvalor_res" value="0" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtcod_presup_d" type="hidden" id="txtcod_presup_d" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtmonto_dep" type="hidden" id="txtmonto_dep" value="0" ></td>

	 
	 <td width="5"><input class="Estilo10" name="txtdesinc" type="hidden" id="txtdesinc" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtfecha_desin" type="hidden" id="txtfecha_desin" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtsit_c" type="hidden" id="txtsit_c" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txttipo_sit_c" type="hidden" id="txttipo_sit_c" value="" ></td>	
     <td width="5"><input class="Estilo10" name="txtsit_l" type="hidden" id="txtsit_l" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txttipo_sit_l" type="hidden" id="txttipo_sit_l" value="" ></td>		 
	 <td width="5"><input class="Estilo10" name="txtedo_con" type="hidden" id="txtedo_con" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtedo_b" type="hidden" id="txtedo_b" value="" ></td> 
	 <td width="5"><input class="Estilo10" name="txtced_ver" type="hidden" id="txtced_ver" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtfecha_ver" type="hidden" id="txtfecha_ver" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtnombre_res_v" type="hidden" id="txtnombre_res_v" value="" ></td>

	 
     <td width="5"><input class="Estilo10" name="txtcodigo_tipo_i" type="hidden" id="txtcodigo_tipo_i" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtdenomina_t" type="hidden" id="txtdenomina_t" value="" ></td>	

     <td width="5"><input class="Estilo10" name="txttipo_inc" type="hidden" id="txttipo_inc" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtcod_imp_p" type="hidden" id="txtcod_imp_p" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtnom_imp_p" type="hidden" id="txtnom_imp_p" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtdes_imp_n" type="hidden" id="txtdes_imp_n" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtvalor_in" type="hidden" id="txtvalor_in" value="" ></td>
     <td width="5"><input class="Estilo10" name="txtfecha_i" type="hidden" id="txtfecha_i" value="" ></td>
     <td width="5"><input class="Estilo10" name="txtgarantia" type="hidden" id="txtgarantia" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtnro_oct" type="hidden" id="txtnro_oct" value="" ></td>
     <td width="5"><input class="Estilo10" name="txtfecha_oct" type="hidden" id="txtfecha_oct" value="" ></td>
     <td width="5"><input class="Estilo10" name="txtnro_opt" type="hidden" id="txtnro_opt" value="" ></td>
     <td width="5"><input class="Estilo10" name="txtfecha_opt" type="hidden" id="txtfecha_opt" value="" ></td>	 
	 <td width="5"><input class="Estilo10" name="txttipo_doc_c" type="hidden" id="txttipo_doc_c" value="" ></td>
     <td width="5"><input class="Estilo10" name="txtnro_doc_c" type="hidden" id="txtnro_doc_c" value="" ></td>
     <td width="5"><input class="Estilo10" name="txtfecha_doc_c" type="hidden" id="txtfecha_doc_c" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtnro_fact" type="hidden" id="txtnro_fact" value="" ></td>
     <td width="5"><input class="Estilo10" name="txtfecha_fact" type="hidden" id="txtfecha_fact" value="" ></td>
	 <td width="5"><input class="Estilo10" name="txtced_rif_prov" type="hidden" id="txtced_rif_prov" value="" ></td>
     <td width="5"><input class="Estilo10" name="txtnom_prov" type="hidden" id="txtnom_prov" value="" ></td>	 
	 
     <?}else{?>
    
	 <td width="5"><input class="Estilo10" name="txtcod_dep" type="hidden" id="txtcod_dep" value="<?echo $cod_dependencia?>" ></td>
     <td width="5"><input class="Estilo10" name="txtnom_dep" type="hidden" id="txtnom_dep" value="<?echo $denominacion_dependencia?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtc_empresa" type="hidden" id="txtc_empresa" value="<?echo $cod_empresa?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtn_empresa" type="hidden" id="txtn_empresa" value="<?echo $denominacion_emp?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtced_resp_p" type="hidden" id="txtced_resp_p" value="<?echo $ced_responsable?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtnomb_resp_p" type="hidden" id="txtnomb_resp_p" value="<?echo $nombre_res?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtcod_clasf" type="hidden" id="txtcod_clasf" value="<?echo $cod_clasificacion?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtnom_clasf" type="hidden" id="txtnom_clasf" value="<?echo $descripcion_b?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtdenom" type="hidden" id="txtdenom" value="<?echo $denominacion?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcod_dir" type="hidden" id="txtcod_dir" value="<?echo $cod_direccion?>" ></td>
     <td width="5"><input class="Estilo10" name="txtnom_dir" type="hidden" id="txtnom_dir" value="<?echo $denominacion_dir?>" ></td>	
	 <td width="5"><input class="Estilo10" name="txtcod_depart" type="hidden" id="txtcod_depart" value="<?echo $cod_departamento?>" ></td>
     <td width="5"><input class="Estilo10" name="txtnom_depart" type="hidden" id="txtnom_depart" value="<?echo $denominacion_dep?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtced_resp_u" type="hidden" id="txtced_resp_u" value="<?echo $ced_responsable_uso?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtnomb_resp_u" type="hidden" id="txtnomb_resp_u" value="<?echo $nombre_res_uso?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtcod_metodo_r" type="hidden" id="txtcod_metodo_r" value="<?echo $cod_metodo_rot?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtmetodo_rot" type="hidden" id="txtmetodo_rot" value="<?echo $metodo_rotula?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtced_rot" type="hidden" id="txtced_rot" value="<?echo $ced_rotulador?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtnombre_res_r" type="hidden" id="txtnombre_res_r" value="<?echo $nombre_res_rotu?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtfecha_rot" type="hidden" id="txtfecha_rot" value="<?echo $fecha_hoy?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_act" type="hidden" id="txtfecha_act" value="<?echo $fecha_hoy?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtdireccion_t" type="hidden" id="txtdireccion_t" value="<?echo $direccion?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtcod_pos_t" type="hidden" id="txtcod_pos_t" value="<?echo $cod_postal?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcod_reg_t" type="hidden" id="txtcod_reg_t" value="<?echo $cod_region?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcod_ent_t" type="hidden" id="txtcod_ent_t" value="<?echo $cod_entidad?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcod_mun_t" type="hidden" id="txtcod_mun_t" value="<?echo $cod_municipio?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcod_ciu_t" type="hidden" id="txtcod_ciu_t" value="<?echo $cod_ciudad?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcod_parro_t" type="hidden" id="txtcod_parro_t" value="<?echo $cod_parroquia?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtnombre_region_t" type="hidden" id="txtnombre_region_t" value="<?echo $nombre_region?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtestado_t" type="hidden" id="txtestado_t" value="<?echo $estado?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtnombre_municipio_t" type="hidden" id="txtnombre_municipio_t" value="<?echo $nombre_municipio?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtnombre_ciudad_t" type="hidden" id="txtnombre_ciudad_t" value="<?echo $nombre_ciudad?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtnombre_parroquia_t" type="hidden" id="txtnombre_parroquia_t" value="<?echo $nombre_parroquia?>" ></td>	
	 <td width="5"><input class="Estilo10" name="txtcaract" type="hidden" id="txtcaract" value="<?echo $caracteristicas?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtmarcat" type="hidden" id="txtmarcat" value="<?echo $marca?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtmodelot" type="hidden" id="txtmodelot" value="<?echo $modelo?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcolort" type="hidden" id="txtcolort" value="<?echo $color?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtmatrict" type="hidden" id="txtmatrict" value="<?echo $matricula?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtserial1t" type="hidden" id="txtserial1t" value="<?echo $serial1?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtserial2t" type="hidden" id="txtserial2t" value="<?echo $serial2?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txttipo_claset" type="hidden" id="txttipo_claset" value="<?echo $tipo_clase?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtusot" type="hidden" id="txtusot" value="<?echo $uso?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtdimension_t" type="hidden" id="txtdimension_t" value="<?echo $dimension_tam?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtmaterialt" type="hidden" id="txtmaterialt" value="<?echo $material?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtcod_alt" type="hidden" id="txtcod_alt" value="<?echo $codigo_alterno?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtanot" type="hidden" id="txtanot" value="<?echo $ano?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtantigt" type="hidden" id="txtantigt" value="<?echo $antiguedad?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtaccest" type="hidden" id="txtaccest" value="<?echo $accesorios?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtcod_conta" type="hidden" id="txtcod_conta" value="<?echo $cod_contablea?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcod_contd" type="hidden" id="txtcod_contd" value="<?echo $cod_contabled?>" ></td>	
	 <td width="5"><input class="Estilo10" name="txttasa_dep" type="hidden" id="txttasa_dep" value="<?echo $tasa_deprec?>" ></td>		  
	 <td width="5"><input class="Estilo10" name="txtvida_u" type="hidden" id="txtvida_u" value="<?echo $vida_util?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtvalor_res" type="hidden" id="txtvalor_res" value="<?echo $valor_residual?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtcod_presup_d" type="hidden" id="txtcod_presup_d" value="<?echo $cod_presup_dep?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtmonto_dep" type="hidden" id="txtmonto_dep" value="<?echo $monto_depreciado?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtdesinc" type="hidden" id="txtdesinc" value="<?echo $desincorporado?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtfecha_desin" type="hidden" id="txtfecha_desin" value="<?echo $fecha_desincorporado?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtsit_c" type="hidden" id="txtsit_c" value="<?echo $sit_contable?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txttipo_sit_c" type="hidden" id="txttipo_sit_c" value="<?echo $tipo_situacion_cont?>" ></td>	
     <td width="5"><input class="Estilo10" name="txtsit_l" type="hidden" id="txtsit_l" value="<?echo $sit_legal?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txttipo_sit_l" type="hidden" id="txttipo_sit_l" value="<?echo $tipo_situacion_legal?>" ></td>		 
	 <td width="5"><input class="Estilo10" name="txtedo_con" type="hidden" id="txtedo_con" value="<?echo $edo_conservacion?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtedo_b" type="hidden" id="txtedo_b" value="<?echo $edo_bien?>" ></td> 
	 <td width="5"><input class="Estilo10" name="txtced_ver" type="hidden" id="txtced_ver" value="<?echo $ced_verificador?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtfecha_ver" type="hidden" id="txtfecha_ver" value="<?echo $fecha_verificacion?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtnombre_res_v" type="hidden" id="txtnombre_res_v" value="<?echo $nombre_res_ver?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcodigo_tipo_i" type="hidden" id="txtcodigo_tipo_i" value="<?echo $codigo_tipo_incorp?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtdenomina_t" type="hidden" id="txtdenomina_t" value="<?echo $denomina_tipo?>" ></td>
	 <td width="5"><input class="Estilo10" name="txttipo_inc" type="hidden" id="txttipo_inc" value="<?echo $tipo_incorporacion?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtcod_imp_p" type="hidden" id="txtcod_imp_p" value="<?echo $cod_imp_presup?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtnom_imp_p" type="hidden" id="txtnom_imp_p" value="<?echo $nom_imp_presup?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txtdes_imp_n" type="hidden" id="txtdes_imp_n" value="<?echo $des_imp_nopresup?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtvalor_in" type="hidden" id="txtvalor_in" value="<?echo $valor_incorporacion?>" ></td>
     <td width="5"><input class="Estilo10" name="txtfecha_i" type="hidden" id="txtfecha_i" value="<?echo $fecha_incorporacion?>" ></td>
     <td width="5"><input class="Estilo10" name="txtgarantia" type="hidden" id="txtgarantia" value="<?echo $garantia?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtnro_oct" type="hidden" id="txtnro_oct" value="<?echo $nro_oc?>" ></td>
     <td width="5"><input class="Estilo10" name="txtfecha_oct" type="hidden" id="txtfecha_oct" value="<?echo $fecha_oc?>" ></td>
     <td width="5"><input class="Estilo10" name="txtnro_opt" type="hidden" id="txtnro_opt" value="<?echo $nro_op?>" ></td>
     <td width="5"><input class="Estilo10" name="txtfecha_opt" type="hidden" id="txtfecha_opt" value="<?echo $fecha_op?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txttipo_doc_c" type="hidden" id="txttipo_doc_c" value="<?echo $tipo_doc_cancela?>" ></td>
     <td width="5"><input class="Estilo10" name="txtnro_doc_c" type="hidden" id="txtnro_doc_c" value="<?echo $nro_doc_cancela?>" ></td>
     <td width="5"><input class="Estilo10" name="txtfecha_doc_c" type="hidden" id="txtfecha_doc_c" value="<?echo $fecha_doc_cancela?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtnro_fact" type="hidden" id="txtnro_fact" value="<?echo $nro_factura?>" ></td>
     <td width="5"><input class="Estilo10" name="txtfecha_fact" type="hidden" id="txtfecha_fact" value="<?echo $fecha_factura?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtced_rif_prov" type="hidden" id="txtced_rif_prov" value="<?echo $ced_rif_proveedor?>" ></td>
     <td width="5"><input class="Estilo10" name="txtnom_prov" type="hidden" id="txtnom_prov" value="<?echo $nom_proveedor?>" ></td>
	 <?}?>	 
  </tr>
</table>
</form>


</body>
</html>
<? pg_close();?>
