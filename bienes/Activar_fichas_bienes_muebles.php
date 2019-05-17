<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");  include ("../class/configura.inc"); $cod_modulo="13";
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{  $Nom_Emp=busca_conf(); }
if (!$_GET){$cod_bien_mue='';}else {$cod_bien_mue=$_GET["Gcod_bien_mue"];} $fecha_hoy=asigna_fecha_hoy(); 
$fecha_fin=formato_ddmmaaaa($Fec_Fin_Ejer);  if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Modificar Ficha de Bienes Muebles)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
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

$sql="SELECT * From BIEN015 where cod_bien_mue='$cod_bien_mue'"; {$res=pg_query($sql);$filas=pg_num_rows($res);}
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
$fecha_in=$fecha_hoy;
$sqlb="Select * from BIEN055 where cod_bien_mue='$cod_bien_mue' "; $resb=pg_query($sqlb);$filasb=pg_num_rows($resb);
if($filasb>=1){$registrob=pg_fetch_array($resb,0); $error=0; } 
else { $error=1; $valor_incorporacion=""; $fecha_in=""; ?> <script language="JavaScript"> muestra('CODIGO DE BIEN NO EXISTE EN DESINCORPORACION POR CORRECCION'); </script> <?}
?>
<body>

<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ACTIVAR FICHA BIENES MUEBLES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="510" border="0" id="tablacuerpo">
  <tr>
    <td>
    <table width="92" height="500" border="1" cellpadding="0" cellspacing="0" id="tablam">
      <td width="86">
		 <td width="92" height="500"><table width="94" height="500" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
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
      <div id="Layer1" style="position:absolute; width:873px; height:500px; z-index:1; top: 78px; left: 119px;">
            <form name="form1" method="post" action="Update_activa_fichas_bienes_muebles.php" onSubmit="return revisar()">
        <table width="848" border="0" align="center" >
		  <tr>
             <td><table width="845">
               <tr>
                 <td width="180"><span class="Estilo5">C&Oacute;DIGO DE CLASIFICACI&Oacute;N :</span></td>
                 <td width="145"><span class="Estilo5"><input name="txtcod_clasificacion" type="text" id="txtcod_clasificacion" value="<?echo $cod_clasificacion?>" readonly  size="10" maxlength="10"  class="Estilo5"> </span></td>
                 <td width="520"><span class="Estilo5"><input name="txtnom_clasificacion" type="text" id="txtnom_clasificacion" size="100" maxlength="250" value="<?echo $descripcion_b?>" readonly class="Estilo5"></span></td>
               </tr>
             </table></td>
           </tr>
            <tr>
             <td><table width="845">
               <tr>
                 <td width="125"><span class="Estilo5">N&Uacute;MERO DEL BIEN:</span></td>
                 <td width="250"><span class="Estilo5"><input name="txtnum_bien" type="text" id="txtnum_bien" size="20" maxlength="20" value="<?echo $num_bien?>" readonly class="Estilo5"></div></td>
                 <td width="220"><span class="Estilo5">C&Oacute;DIGO DEL BIEN INMUEBLE :</span></td>
                 <td width="250"><span class="Estilo5"><input name="txtcod_bien_mue" type="text" id="txtcod_bien_mue"  size="40" maxlength="30" value="<?echo $cod_bien_mue?>" readonly class="Estilo5"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="165"><span class="Estilo5">DENOMINACI&Oacute;N DEL BIEN :</span></td>
                 <td width="680"><span class="Estilo5"><input name="txtdenominacion" type="text" id="txtdenominacion" size="120" maxlength="250" value="<?echo $denominacion?>" readonly class="Estilo5"></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="140"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></td>
                 <td width="135"><span class="Estilo5"><input name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4" value="<?echo $cod_dependencia?>" readonly class="Estilo5">    </span></td>
                 <td width="570"><span class="Estilo5"><input name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="100" maxlength="250" value="<?echo $denominacion_dependencia?>" readonly class="Estilo5">    </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="140"><span class="Estilo5">C&Oacute;DIGO DIRECCI&Oacute;N :</span></td>
                 <td width="135"><span class="Estilo5"> <input name="txtcod_direccion" type="text" id="txtcod_direccion" size="5" maxlength="4" value="<?echo $cod_direccion?>" readonly class="Estilo5">   </span></td>
                 <td width="570"><span class="Estilo5"><input name="txtdenominacion_dir" type="text" id="txtdenominacion_dir" size="100" maxlength="100" value="<?echo $denominacion_dir?>" readonly class="Estilo5">   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="155"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></td>
                 <td width="120"><span class="Estilo5"><input name="txtcod_departamento" type="text" id="txtcod_departamento" size="10" maxlength="8" value="<?echo $cod_departamento?>" readonly class="Estilo5">   </span></td>
                 <td width="570"><span class="Estilo5"><input name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="100" maxlength="100"  value="<?echo $denominacion_dep?>" readonly class="Estilo5">   </span></td>
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
                 <td width="100"><span class="Estilo5"><input name="txcodigo_tipo_incorp" type="text" id="txcodigo_tipo_incorp" size="5" maxlength="5" value="<?echo $codigo_tipo_incorp?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">  
				     <input name="btcod_mov" type="button" id="btcod_mov" title="Abrir Catalogo Tipo Incorporacion" onClick="VentanaCentrada('Cat_tipoincorpd.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 <td width="500"><span class="Estilo5"><input name="txtdenomina_tipo" type="text" id="txtdenomina_tipo" size="100" maxlength="150" value="<?echo $denomina_tipo?>" readonly class="Estilo5"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="845">
               <tr>
                 <td width="175"><span class="Estilo5">VALOR INCORPORACI&Oacute;N :</span></td>
                 <td width="250"><span class="Estilo5"><input name="txtvalor_incorporacion" type="text" id="txtvalor_incorporacion" size="20" maxlength="15" align="rigth"  value="<?echo $valor_incorporacion?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">   </span></td>
                 <td width="170"><span class="Estilo5">FECHA INCORPORACI&Oacute;N :</span></td>
				  <?if ($error==0) {?>	
				 <td width="250"><span class="Estilo5"><input name="txtfecha_incorporacion" type="text" id="txtfecha_incorporacion" size="15" maxlength="10" value="<?echo $fecha_in?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">   </span></td>
                  <?}else{?>
                 <td width="250"><span class="Estilo5"><input name="txtfecha_incorporacion" type="text" id="txtfecha_incorporacion" size="15" maxlength="10" value="<?echo $fecha_in?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" onchange="chequea_fecha(this)" onkeyup="mascara(this,'/',patronfecha,true)">   </span></td>
                  <?}?>                
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
			 <?if ($error==0) {?>			 
			<td width="81"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
			<?}?>			
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