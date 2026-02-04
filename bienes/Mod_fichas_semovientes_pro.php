<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$cod_bien_sem='';}else {$cod_bien_sem=$_GET["Gcod_bien_sem"];}

print_r($cod_bien_sem);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Actualiza Ficha de Semovientes)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
<SCRIPT language=JavaScript
src="../class/sia.js"
type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function revisar(){
var f=document.form1;
    if(f.txtcod_clasificacion.value==""){alert("El Codigo Clasificacion no puede estar Vacio");return false;}else{f.txtcod_clasificacion.value=f.txtcod_clasificacion.value.toUpperCase();}
    if(f.txtnum_bien.value==""){alert("Numero del Bien no puede estar Vacio"); return false; } else{f.txtnum_bien.value=f.txtnum_bien.value.toUpperCase();}
    if(f.txtcod_bien_sem.value==""){alert("El Codigo del Bien Inmueble no puede estar Vacio");return false;}else{f.txtcod_bien_sem.value=f.txtcod_bien_sem.value.toUpperCase();}
    if(f.txtdenominacion.value==""){alert("Denominacion no puede estar Vacia"); return false; } else{f.txtdenominacion.value=f.txtdenominacion.value.toUpperCase();}
    if(f.txtcod_empresa.value==""){alert("El Codigo de la Empresa no puede estar Vacio");return false;}else{f.txtcod_empresa.value=f.txtcod_empresa.value.toUpperCase();}
    if(f.txtcod_direccion.value==""){alert("El Codigo de la Direccion no puede estar Vacia");return false;}else{f.txtcod_direccion.value=f.txtcod_direccion.value.toUpperCase();}
    if(f.txtcod_departamento.value==""){alert("El Codigo no puede estar Vacio");return false;}else{f.txtcod_departamento.value=f.txtcod_departamento.value.toUpperCase();}
    if(f.txtcod_dependencia.value==""){alert("El Codigo no puede estar Vacio");return false;}else{f.txtcod_dependencia.value=f.txtcod_dependencia.value.toUpperCase();}
    if(f.txtced_responsable.value==""){alert("La Cedula del responsable no estar Vacia"); return false; } else{f.txtced_responsable.value=f.txtced_responsable.value.toUpperCase();}
    if(f.txtfecha_actualizacion.value==""){alert("La Fecha no estar Vacia"); return false; } else{f.txtfecha_actualizacion.value=f.txtfecha_actualizacion.value.toUpperCase();}
    if(f.txtced_res_uso.value==""){alert("La Cedula del responsable de uso no estar Vacia");return false;}else{f.txtced_res_uso.value=f.txtced_res_uso.value.toUpperCase();}
    if(f.txtcodigo_rotula.value==""){alert("El Codigo no puede estar Vacio");return false;}else{f.txtcodigo_rotula.value=f.txtcodigo_rotula.value.toUpperCase();} 
    if(f.txtced_res_rotu.value==""){alert("La Cedula del responsable no estar Vacia"); return false; } else{f.txtced_res_rotu.value=f.txtced_res_rotu.value.toUpperCase();}
    if(f.txtfecha_rotulacion.value==""){alert("La Cedula del responsable no estar Vacia"); return false; } else{f.txtfecha_rotulacion.value=f.txtfecha_rotulacion.value.toUpperCase();}
    if(f.txtdireccion.value==""){alert("La Direccion no estar Vacia"); return false; } else{f.txtdireccion.value=f.txtdireccion.value.toUpperCase();}
    if(f.txtcod_region.value==""){alert("Codigo Region no puede estar Vacio"); return false; } else{f.txtcod_region.value=f.txtcod_region.value.toUpperCase();}
    if(f.txtcod_entidad.value==""){alert("Codigo de la Entidad no puede estar Vacio"); return false; } else{f.txtcod_entidad.value=f.txtcod_entidad.value.toUpperCase();}
    if(f.txtcod_municipio.value==""){alert("Codigo del Municipio no puede estar Vacio"); return false; } else{f.txtcod_municipio.value=f.txtcod_municipio.value.toUpperCase();}
    if(f.txtcod_ciudad.value==""){alert("Codigo de la Ciudad no puede estar Vacio"); return false; } else{f.txtcod_ciudad.value=f.txtcod_ciudad.value.toUpperCase();}
    if(f.txtcod_parroquia.value==""){alert("Codigo de Parroquia no puede estar Vacio"); return false; } else{f.txtcod_parroquia.value=f.txtcod_parroquia.value.toUpperCase();}
    if(f.txtcod_postal.value==""){alert("El Codigo Postal no puede estar Vacio"); return false; } else{f.txtcod_postal.value=f.txtcod_postal.value.toUpperCase();}    
    if(f.txtraza.value==""){alert("El Codigo no puede estar Vacio");return false;}else{f.txtraza.value=f.txtraza.value.toUpperCase();}
    if(f.txtcolor.value==""){alert("Descripcion no puede estar Vacio");return false;}else{f.txtcolor.value=f.txtcolor.value.toUpperCase();} 
    if(f.txtsexo.value==""){alert("La marca no puede estar Vacio"); return false; } else{f.txtsexo.value=f.txtsexo.value.toUpperCase();}
    if(f.txtfecha_nacimiento.value==""){alert("El Modelo no puede estar Vacio"); return false; } else{f.txtfecha_nacimiento.value=f.txtfecha_nacimiento.value.toUpperCase();}
    if(f.txtedad.value==""){alert("El Color no puede estar Vacio"); return false; } else{f.txtedad.value=f.txtedad.value.toUpperCase();}
    if(f.txttam_peso.value==""){alert("La Matricula no puede estar Vacio"); return false; } else{f.txttam_peso.value=f.txttam_peso.value.toUpperCase();}
    if(f.txtuso.value==""){alert("El Material no puede estar Vacio"); return false; } else{f.txtuso.value=f.txtuso.value.toUpperCase();}
    if(f.txtcod_contablea.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtcod_contablea.value=f.txtcod_contablea.value.toUpperCase();}
    if(f.txtcod_contabled.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtcod_contabled.value=f.txtcod_contabled.value.toUpperCase();}
    if(f.txttipo_depreciacion.value==""){alert("El Tipo Depreciacion no puede estar Vacio"); return false; } else{f.txttipo_depreciacion.value=f.txttipo_depreciacion.value.toUpperCase();}
    if(f.txttasa_deprec.value==""){alert("La Tasa no puede estar Vacio"); return false; } else{f.txttasa_deprec.value=f.txttasa_deprec.value.toUpperCase();}
    if(f.txtvida_util.value==""){alert("El VIda util no puede estar Vacio"); return false; } else{f.txtvida_util.value=f.txtvida_util.value.toUpperCase();}
    if(f.txtvalor_residual.value==""){alert("El Valor Residual no puede estar Vacio"); return false; } else{f.txtvalor_residual.value=f.txtvalor_residual.value.toUpperCase();}
    if(f.txtcod_presup_dep.value==""){alert("El Valor Residual no puede estar Vacio"); return false; } else{f.txtcod_presup_dep.value=f.txtcod_presup_dep.value.toUpperCase();}
    if(f.txtmonto_depreciado.value==""){alert("El Valor Residual no puede estar Vacio"); return false; } else{f.txtmonto_depreciado.value=f.txtmonto_depreciado.value.toUpperCase();}
    if(f.txtdesincorporado.value==""){alert("El Tipo Depreciacion no puede estar Vacio"); return false; } else{f.txtdesincorporado.value=f.txtdesincorporado.value.toUpperCase();}
    if(f.txtfecha_desincorporado.value==""){alert("El Material no puede estar Vacio"); return false; } else{f.txtfecha_desincorporado.value=f.txtfecha_desincorporado.value.toUpperCase();}
    if(f.txtcodigo_situacont.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtcodigo_situacont.value=f.txtcodigo_situacont.value.toUpperCase();}
    if(f.txtcodigo_situalegal.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtcodigo_situalegal.value=f.txtcodigo_situalegal.value.toUpperCase();}
    if(f.txtced_res_verificador.value==""){alert("La Tasa no puede estar Vacio"); return false; } else{f.txtced_res_verificador.value=f.txtced_res_verificador.value.toUpperCase();}
    if(f.txtfecha_verificacion.value==""){alert("El VIda util no puede estar Vacio"); return false; } else{f.txtfecha_verificacion.value=f.txtfecha_verificacion.value.toUpperCase();}   
    if(f.txttipo_incorporacion.value==""){alert("El Material no puede estar Vacio"); return false; } else{f.txttipo_incorporacion.value=f.txttipo_incorporacion.value.toUpperCase();}
    if(f.txtcod_imp_presup.value==""){alert("El Material no puede estar Vacio"); return false; } else{f.txtcod_imp_presup.value=f.txtcod_imp_presup.value.toUpperCase();}
    if(f.txtnom_imp_presup.value==""){alert("El Material no puede estar Vacio"); return false; } else{f.txtnom_imp_presup.value=f.txtnom_imp_presup.value.toUpperCase();}
    if(f.txtdes_imp_nopresup.value==""){alert("El Tipo Depreciacion no puede estar Vacio"); return false; } else{f.txtdes_imp_nopresup.value=f.txtdes_imp_nopresup.value.toUpperCase();}    
    if(f.txtvalor_incorporacion.value==""){alert("El VIda util no puede estar Vacio"); return false; } else{f.txtvalor_incorporacion.value=f.txtvalor_incorporacion.value.toUpperCase();}
    if(f.txtfecha_incorporacion.value==""){alert("La Tasa no puede estar Vacio"); return false; } else{f.txtfecha_incorporacion.value=f.txtfecha_incorporacion.value.toUpperCase();}
    if(f.txtnro_oc.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtnro_oc.value=f.txtnro_oc.value.toUpperCase();}
    if(f.txtfecha_oc.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtfecha_oc.value=f.txtfecha_oc.value.toUpperCase();}
    if(f.txtnro_op.value==""){alert("El Tipo Depreciacion no puede estar Vacio"); return false; } else{f.txtnro_op.value=f.txtnro_op.value.toUpperCase();}
    if(f.txtfecha_op.value==""){alert("La Tasa no puede estar Vacio"); return false; } else{f.txtfecha_op.value=f.txtfecha_op.value.toUpperCase();}
    if(f.txttipo_doc_cancela.value==""){alert("El VIda util no puede estar Vacio"); return false; } else{f.txttipo_doc_cancela.value=f.txttipo_doc_cancela.value.toUpperCase();}
    if(f.txtnro_doc_cancela.value==""){alert("El Valor Residual no puede estar Vacio"); return false; } else{f.txtnro_doc_cancela.value=f.txtnro_doc_cancela.value.toUpperCase();}
    if(f.txtfecha_doc_cancela.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtfecha_doc_cancela.value=f.txtfecha_doc_cancela.value.toUpperCase();}
    if(f.txtnro_factura.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtnro_factura.value=f.txtnro_factura.value.toUpperCase();}
    if(f.txtfecha_factura.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtfecha_factura.value=f.txtfecha_factura.value.toUpperCase();}
    if(f.txtced_rif_proveedor.value==""){alert("Codigo Contable no debe estar Vacia"); return false; } else{f.txtced_rif_proveedor.value=f.txtced_rif_proveedor.value.toUpperCase();}
    if(f.txtnombre_proveedor.value==""){alert("La Tasa no puede estar Vacio"); return false; } else{f.txtnombre_proveedor.value=f.txtnombre_proveedor.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
<style type="text/css">
</style>
</head>
<?php 
$sql="SELECT * From BIEN016 where cod_bien_sem='$cod_bien_sem'"; {$res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); 
  $cod_bien_sem=$registro["cod_bien_sem"];
  $cod_clasificacion=$registro["cod_clasificacion"];
  $num_bien=$registro["num_bien"];
  $denominacion=$registro["denominacion"]; 
  $cod_dependencia=$registro["cod_dependencia"]; 
  $cod_empresa=$registro["cod_empresa"]; 
  $cod_direccion=$registro["cod_direccion"];
  $cod_departamento=$registro["cod_departamento"];  
  $ced_responsable=$registro["ced_responsable"];
  $fecha_actualizacion=$registro["fecha_actualizacion"];
if($fecha_actualizacion==""){$fecha_actualizacion="";}else{$fecha_actualizacion=formato_ddmmaaaa($fecha_actualizacion);} 
  $ced_responsable_uso=$registro["ced_responsable_uso"];
  $cod_metodo_rot=$registro["cod_metodo_rot"];
  $ced_rotulador=$registro["ced_rotulador"];
  $fecha_rotulacion=$registro["fecha_rotulación"];
if($fecha_rotulacion==""){$fecha_rotulacion="";}else{$fecha_rotulacion=formato_ddmmaaaa($fecha_rotulacion);}
print_r($fecha_rotulacion);
  //$fecha_rotulacion=$registro["fecha_rotulaci�n"];
  $direccion=$registro["direccion"]; 
  $cod_region=$registro["cod_region"]; 
  $cod_entidad=$registro["cod_entidad"];
  $cod_municipio=$registro["cod_municipio"]; 
  $cod_ciudad=$registro["cod_ciudad"]; 
  $cod_parroquia=$registro["cod_parroquia"]; 
  $cod_postal=$registro["cod_postal"];
  $caracteristicas=$registro["caracteristicas"];
  $raza=$registro["raza"]; 
  $color=$registro["color"]; 
  $sexo=$registro["sexo"]; 
  $uso=$registro["uso"]; 
  $tam_peso=$registro["tam_peso"]; 
  $fecha_nacimiento=$registro["fecha_nacimiento"];
if($fecha_nacimiento==""){$fecha_nacimiento="";}else{$fecha_nacimiento=formato_ddmmaaaa($fecha_nacimiento);} 
  $edad=$registro["edad"];
  $cod_contablea=$registro["cod_contablea"]; 
  $cod_contabled=$registro["cod_contabled"]; 
  $tipo_depreciacion=$registro["tipo_depreciacion"]; 
  $tasa_deprec=$registro["tasa_deprec"];
  $vida_util=$registro["vida_util"];
  $valor_residual=$registro["valor_residual"]; 
  $sit_contable=$registro["sit_contable"]; 
  $sit_legal=$registro["sit_legal"];
  $edo_conservacion=$registro["edo_conservacion"];
  $ced_verificador=$registro["ced_verificador"]; 
  $fecha_verificacion=$registro["fecha_verificacion"];
if($fecha_verificacion==""){$fecha_verificacion="";}else{$fecha_verificacion=formato_ddmmaaaa($fecha_verificacion);}
  $tipo_incorporacion=$registro["tipo_incorporacion"]; 
  $cod_imp_presup=$registro["cod_imp_presup"];
  $nom_imp_presup=$registro["nom_imp_presup"];
  $des_imp_nopresup=$registro["des_imp_nopresup"]; 
  $fecha_incorporacion=$registro["fecha_incorporacion"]; 
if($fecha_incorporacion==""){$fecha_incorporacion="";}else{$fecha_incorporacion=formato_ddmmaaaa($fecha_incorporacion);}
  $valor_incorporacion=$registro["valor_incorporacion"];
  $nro_oc=$registro["nro_oc"]; 
  $fecha_oc=$registro["fecha_oc"]; 
if($fecha_oc==""){$fecha_oc="";}else{$fecha_oc=formato_ddmmaaaa($fecha_oc);}
  $nro_op=$registro["nro_op"]; 
  $fecha_op=$registro["fecha_op"];
if($fecha_op==""){$fecha_op="";}else{$fecha_op=formato_ddmmaaaa($fecha_op);} 
  $tipo_doc_cancela=$registro["tipo_doc_cancela"];
  $nro_doc_cancela=$registro["nro_doc_cancela"]; 
  $fecha_doc_cancela=$registro["fecha_doc_cancela"]; 
if($fecha_doc_cancela==""){$fecha_doc_cancela="";}else{$fecha_doc_cancela=formato_ddmmaaaa($fecha_doc_cancela);}
  $ced_rif_proveedor=$registro["ced_rif_proveedor"];
  $codigo_tipo_incorp=$registro["codigo_tipo_incorp"];
  $nom_proveedor=$registro["nom_proveedor"]; 
  $cod_presup_dep=$registro["cod_presup_dep"]; 
  $monto_depreciado=$registro["monto_depreciado"]; 
  $nro_factura=$registro["nro_factura"]; 
  $fecha_factura=$registro["fecha_factura"];
if($fecha_factura==""){$fecha_factura="";}else{$fecha_factura=formato_ddmmaaaa($fecha_factura);}
  $desincorporado=$registro["desincorporado"]; 
  $fecha_desincorporado=$registro["fecha_desincorporado"];
if($fecha_desincorporado==""){$fecha_desincorporado="";}else{$fecha_desincorporado=formato_ddmmaaaa($fecha_desincorporado);}
  $des_desincorporado=$registro["des_desincorporado"]; 
  $status_bien_sem=$registro["status_bien_sem"]; 
  $usuario_sia=$registro["usuario_sia"]; 
  $inf_usuario=$registro["inf_usuario"];
}
//Clasificacion
$Ssql="SELECT * FROM bien033 where codigo_c='".$cod_clasificacion."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$descripcion_b=$registro["descripcion_b"];}
//Empresa
$Ssql="SELECT * FROM bien007 where cod_empresa='".$cod_empresa."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_empresa=$registro["denominacion_emp"];}
//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dependencia=$registro["denominacion_dep"];}
//Direcciones
$Ssql="SELECT * FROM bien005 where cod_direccion='".$cod_direccion."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dir=$registro["denominacion_dir"];}
//Departamento
$Ssql="SELECT * FROM bien006 where cod_departamento='".$cod_departamento."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dep=$registro["denominacion_dep"];}
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
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR FICHA SEMOVIENTE</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="1800" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="385"><table width="92" height="2000" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_fichas_semovientes_pro.php?Gcod_bien_sem=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_fichas_semovientes_pro.php?Gcod_bien_sem=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Archivos</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
               <form name="form1" method="post" action="Update_fichas_semovientes_pro.php" onSubmit="return revisar()">
       <div id="Layer1" style="position:absolute; width:825px; height:523px; z-index:1; top: 78px; left: 118px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DE CLACIFICACI&Oacute;N:</span></div></td>
                 <td width="200" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_clasificacion" type="text" class="Estilo5" id="txtcod_clasificacion" size="10" maxlength="10"  value="<?php echo $cod_clasificacion?>" readonly>
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre2242222224" type="button" id="bttipo_codeingre22422222244" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIPAP'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="725" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion" type="text" class="Estilo5" id="txtdenominacion" size="70" maxlength="250" value="<?php echo $descripcion_b?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO DEL BIEN:</span></div></td>
                 <td width="300" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtnum_bien" type="text" class="Estilo5" id="txtnum_bien" size="20" maxlength="20" value="<?php echo $num_bien?>" readonly>
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222242" type="button" id="bttipo_codeingre224222222422" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIPAP'="";''="";'750'="";'500'="";'true')" value="123...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="108" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEL BIEN INMUEBLE :</span></div></td>
                 <td width="582" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtcod_bien_sem" type="text" class="Estilo5" id="txtcod_bien_sem" size="40" maxlength="30" value="<?php echo $cod_bien_sem?>" >
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">DENOMINACI&Oacute;N DEL BIEN :</span></div></td>
                 <td width="855" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion" type="text" class="Estilo5" id="txtdenominacion" size="90" maxlength="250" value="<?php echo $denominacion?>" >
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><span class="Estilo5">INFORMACI&Oacute;N</span></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DE EMPRESA :</span></div></td>
                 <td width="114" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_empresa" type="text" class="Estilo5" id="txtcod_empresa" size="4" maxlength="3" value="<?php echo $cod_empresa?>" >
                     <span class="menu"><strong><strong>
                     <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Empresas" onClick="VentanaCentrada('Cat_empresasd.php?criterio=','SIPAP','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="762" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_empresa" type="text" class="Estilo5" id="txtnombre_empresa" size="75" maxlength="100" value="<?php echo $denominacion_empresa?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DIRECCI&Oacute;N :</span></div></td>
                 <td width="109" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_direccion" type="text" class="Estilo5" id="txtcod_direccion" size="5" maxlength="4" value="<?php echo $cod_direccion?>" >
                     <span class="menu"><strong><strong>
                     <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Direcciones" onClick="VentanaCentrada('Cat_direccionesd.php?criterio=','SIPAP','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="758" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dir" type="text" class="Estilo5" id="txtdenominacion_dir" size="75" maxlength="100" value="<?php echo $denominacion_dir?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></div></td>
                 <td width="160" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_departamento" type="text" class="Estilo5" id="txtcod_departamento" size="10" maxlength="8" value="<?php echo $cod_departamento?>" >
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Direcciones" onClick="VentanaCentrada('Cat_departamentosd.php?criterio=','SIPAP','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="714" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_dep" type="text" class="Estilo5" id="txtnombre_dep" size="70" maxlength="100"  value="<?php echo $denominacion_dep?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></div></td>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_dependencia" type="text" class="Estilo5" id="txtcod_dependencia" size="5" maxlength="4" value="<?php echo $cod_dependencia?>" >
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222244" type="button" id="bttipo_codeingre22422222246" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIPAP'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="747" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dep" type="text" class="Estilo5" id="txtdenominacion_dep" size="74" maxlength="250" value="<?php echo $denominacion_dependencia?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <table width="828" align="center">
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">C.I. RESPONSABLE PRIMARIOS:</span></div></td>
                <td width="200" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtced_responsable" type="text" class="Estilo5" id="txtced_responsable" size="15" maxlength="12"  value="<?php echo $ced_responsable?>">
                    <span class="menu"><strong><strong>
                               <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_responsablesd.php?criterio=','SIPAP','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="98" scope="col"><div align="left"><span class="Estilo5">FECHA DE ACTUALIZACION:</span></div></td>
                <td width="555" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtfecha_actualizacion" type="text" class="Estilo5" id="txtfecha_actualizacion" size="15" maxlength="10" value="<?php echo $fecha_actualizacion?>" onFocus="encender(this)" onBlur="apagar(this)">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="961">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">NOMBRE DEL RESPONSABLE:</span></div></td>
                <td width="858" scope="col"><div align="left"><span class="Estilo5">
                   <input name="txtnombre_responsabep" type="text" class="Estilo5" id="txtnombre_responsabep" size="50" maxlength="250" value="<?php echo $nombre_res?>" readonly>
                </span></div></td>
              </tr>
            </table></td>
          </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5">C.I. RESPONSABLE DE USO :</span></div></td>
                 <td width="230" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtced_res_uso" type="text" class="Estilo5" id="txtced_res_uso" size="15" maxlength="12"  value="<?php echo $ced_responsable_uso?>" >
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_responsablesusod.php?criterio=','SIPAP','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="744" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtnombre_res_uso" type="text" class="Estilo5" id="txtnombre_res_uso" size="65" maxlength="250"  value="<?php echo $nombre_res_uso?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">METODO DE ROTULACI&Oacute;N :</span></div></td>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcodigo_rotula" type="text" class="Estilo5" id="txtcodigo_rotula" size="4" maxlength="2" value="<?php echo $cod_metodo_rot?>" >
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Metodo de Rotulacion" onClick="VentanaCentrada('Cat_metodosrotulad.php?criterio=','SIPAP','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="767" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtmetodo_rotula" type="text" class="Estilo5" id="txtmetodo_rotula" size="75" maxlength="250" value="<?php echo $metodo_rotula?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5">C&Eacute;DULA DE ROTULADOR :</span></div></td>
                 <td width="230" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtced_res_rotu" type="text" class="Estilo5" id="txtced_res_rotu" size="15" maxlength="12"  value="<?php echo $ced_rotulador?>" >
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_rotuladoresd.php?criterio=','SIPAP','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="744" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtnombre_res_rotu" type="text" class="Estilo5" id="txtnombre_res_rotu" size="65" maxlength="250"  value="<?php echo $nombre_res_rotu?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="92" scope="col"><div align="left"><span class="Estilo5">FECHA ROTULACI&Oacute;N :</span></div></td>
                 <td width="132" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtfecha_rotulacion" type="text" class="Estilo5" id="txtfecha_rotulacion" size="20" maxlength="15" value="<?php echo $fecha_rotulacion?>" >
                     <span class="menu"><strong><strong>                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
    
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><span class="Estilo5">UBIC. GEOGRAFICA </span></td>
           </tr>
           <tr>
             <td><table width="962">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">DIRECCI&Oacute;N :</span></div></td>
                 <td width="869" scope="col"><div align="left">
                     <textarea name="txtdireccion" cols="70" onFocus="encender(this)" onBlur="apagar(this)" readonly class="headers" id="txtdireccion"><?php echo $direccion?></textarea>
                 </div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">REGI&Oacute;N :</span></div></td>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_region" type="text" class="Estilo5" id="txtcod_region" size="4" maxlength="2" value="<?php echo $cod_region?>" >
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_regionesd.php?criterio=','SIPAP','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="798" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_region" type="text" class="Estilo5" id="txtnombre_region" size="75" maxlength="250"  value="<?php echo $nombre_region?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">ENTIDAD FEDERAL :</span></div></td>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_entidad" type="text" class="Estilo5" id="txtcod_entidad" size="4" maxlength="2" value="<?php echo $cod_entidad?>" >
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_entidadfederald.php?criterio=','SIPAP','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="798" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtestado" type="text" class="Estilo5" id="txtestado" size="75" maxlength="250"  value="<?php echo $estado?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">MUNICIPIO :</span></div></td>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_municipio" type="text" class="Estilo5" id="txtcod_municipio" size="5" maxlength="4" value="<?php echo $cod_municipio?>" >
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_municipiosd.php?criterio=','SIPAP','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="750" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_municipio" type="text" class="Estilo5" id="txtnombre_municipio" size="75" maxlength="250" value="<?php echo $nombre_municipio?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">CIUDAD :</span></div></td>
                 <td width="105" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_ciudad" type="text" class="Estilo5" id="txtcod_ciudad" size="5" maxlength="4"  value="<?php echo $cod_ciudad?>" >
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_cuidadesd.php?criterio=','SIPAP','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="784" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_ciudad" type="text" class="Estilo5" id="txtnombre_ciudad" size="75" maxlength="250" value="<?php echo $nombre_ciudad?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">PARROQUIA :</span></div></td>
                 <td width="121" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_parroquia" type="text" class="Estilo5" id="txtcod_parroquia" size="7" maxlength="6" value="<?php echo $cod_parroquia?>" >
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_parroquiasd.php?criterio=','SIPAP','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="744" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_parroquia" type="text" class="Estilo5" id="txtnombre_parroquia" size="70" maxlength="250" value="<?php echo $nombre_parroquia?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO POSTAL :</span></div></td>
                 <td width="891" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtcod_postal" type="text" class="Estilo5" id="txtcod_postal" size="12" maxlength="10" value="<?php echo $cod_postal?>" > 
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><span class="Estilo12">CARACTERISTICAS</span></td>
           </tr>
           <tr>
             <td><table width="962">
               <tr>
                 <td width="118" scope="col"><div align="left"><span class="Estilo5">CARACTERISTICAS DEL SEMOVIENTE:</span></div></td>
                 <td width="832" scope="col"><div align="left">
                     <textarea name="txtcaracteristicas" cols="70" class="headers" id="txtcaracteristicas"><?php echo $caracteristicas?></textarea>
                 </div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">RAZA:</span></div></td>
                 <td width="203" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtraza" type="text" class="Estilo5" id="txtraza" size="60" maxlength="60" value="<?php echo $raza?>" >
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="60" scope="col"><div align="left"><span class="Estilo5">COLOR :</span></div></td>
                 <td width="626" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtcolor" type="text" class="Estilo5" id="txtcolor" size="30" maxlength="30" value="<?php echo $color?>" >
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">SEXO :</span></div></td>
                 <td width="350" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtsexo" type="text" class="Estilo5" id="txtsexo" size="30" maxlength="30" value="<?php echo $sexo?>" >
                     <span class="menu"><strong><strong>
                     </strong></strong></span>                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">USO :</span></div></td>
                 <td width="600" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtuso" type="text" class="Estilo5" id="txtuso" size="30" maxlength="30" value="<?php echo $uso?>">
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">TAMA�O PESO :</span></div></td>
                 <td width="204" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txttam_peso" type="text" class="Estilo5" id="txttam_peso" size="30" maxlength="30" value="<?php echo $tam_peso?>" >
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">FECHA NACIMIENTO :</span></div></td>
                 <td width="700" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_nacimiento" type="text" class="Estilo5" id="txtfecha_nacimiento" size="15" maxlength="15"  value="<?php echo $fecha_nacimiento?>" >
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">EDAD:</span></div></td>
                 <td width="621" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtedad" type="text" class="Estilo5" id="txtedad" size="4" maxlength="4"  value="<?php echo $edad?>" >
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><span class="Estilo12">DATOS CONTABLES </span></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="113" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO CONTABLE ASOCIADO :</span></div></td>
                 <td width="400" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcod_contablea" type="text" id="txtcod_contablea" size="30" maxlength="25"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_codigoscontablesd.php?criterio=','SIPAP','','750','500','true')" value="...">
                     </strong></strong></span>                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="117" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO CONTABLE DEPRECIACI&Oacute;N :</span></div></td>
                 <td width="600" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtcod_contabled" type="text" class="Estilo5" id="txtcod_contabled" size="30" maxlength="25" value="<?php echo $cod_contabled?>" >
                     <span class="Estilo10"><span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222243623" type="button" id="bttipo_codeingre22422222243623" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIPAP'="";''="";'750'="";'500'="";'true')" value="...">
                     </strong></strong></span></span>                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="98" scope="col"><div align="left"><span class="Estilo5">TIPO DE DEPRECIACI&Oacute;N :</span></div></td>
                 <td width="146" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">                     <span class="menu"><strong><strong>                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                    <select name="txttipo_depreciacion" id="txttipo_depreciacion">
                      <option value="LINEA RECTA">LINEA RECTA</option>
                      <option value="NINGUNA">NINGUNA</option>
                    </select>
                   </strong></strong></span></span> </span></div></td>
                 <td width="103" scope="col"><div align="left"><span class="Estilo5">TASA DEPRECIACI&Oacute;N :</span></div></td>
                 <td width="596" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txttasa_deprec" type="text" class="Estilo5" id="txttasa_deprec" size="10" maxlength="15" value="<?php echo $tasa_deprec?>" >
                     <span class="Estilo10"><span class="menu"><strong><strong>
                 </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">VIDA &Uacute;TIL EN A&Ntilde;OS :</span></div></td>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtvida_util" type="text" class="Estilo5" id="txtvida_util" size="10" maxlength="15" value="<?php echo $vida_util?>" >
                     <span class="menu"><strong><strong>                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="71" scope="col"><div align="left"><span class="Estilo5">VALOR RESIDUAL :</span></div></td>
                 <td width="699" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtvalor_residual" type="text" class="Estilo5" id="txtvalor_residual" size="20" maxlength="15" value="<?php echo $valor_residual?>" >
                     <span class="Estilo10"><span class="menu"><strong><strong>                 </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="164" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO DE DEPRECIACI&Oacute;N :</span></div></td>
                 <td width="370" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_presup_dep" type="text" class="Estilo5" id="txtcod_presup_dep" size="35" maxlength="32" value="<?php echo $cod_presup_dep?>" >
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre224222222436222" type="button" id="bttipo_codeingre224222222436224" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIPAP'="";''="";'750'="";'500'="";'true')" value="...">
                     </strong></strong></span>                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="85" scope="col"><div align="left"><span class="Estilo5">MONTO DEPRECIADO :</span></div></td>
                 <td width="362" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtmonto_depreciado" type="text" class="Estilo5" id="txtmonto_depreciado" size="20" maxlength="15" value="<?php echo $monto_depreciado?>">
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="121" scope="col"><div align="left"><span class="Estilo5">DESINCORPORADO :</span></div></td>
                <td width="80" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                    <select name="txtdesincorporado" size="1" id="txtdesincorporado">
                      <option value='1'>SI</option>
                      <option value='2'>NO</option>
                    </select>
                </strong></strong></span></span> </span></div></td>
                <td width="164" scope="col"><span class="Estilo5">FECHA DESINCORPORCI&Oacute;N :</span></td>
                <td width="578" scope="col"><span class="Estilo5">
                 <input name="txtfecha_desincorporado" type="text" class="Estilo5" id="txtfecha_desincorporado" size="15" maxlength="10"  value="<?php echo $fecha_desincorporado?>">
                </span></td>
              </tr>
            </table></td>
          </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" height="27" scope="col"><div align="left"><span class="Estilo5">SITUACI&Oacute;N CONTABLE :</span></div></td>
                 <td width="97" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcodigo_situacont" type="text" class="Estilo5" id="txtcodigo_situacont" size="4" maxlength="2" value="<?php echo $sit_contable?>" >
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Situacion Contable" onClick="VentanaCentrada('Cat_situacioncontabled.php?criterio=','SIPAP','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="777" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txttipo_situacion" type="text" class="Estilo5" id="txttipo_situacion" size="75" maxlength="100" value="<?php echo $tipo_situacion_cont?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" height="27" scope="col"><div align="left"><span class="Estilo5">SITUACI&Oacute;N LEGAL :</span></div></td>
                 <td width="97" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcodigo_situalegal" type="text" class="Estilo5" id="txtcodigo_situalegal" size="4" maxlength="2" value="<?php echo $sit_legal?>" >
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Situacion Contable" onClick="VentanaCentrada('Cat_situacionlegald.php?criterio=','SIPAP','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="777" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txttipo_situacion_legal" type="text" class="Estilo5" id="txttipo_situacion_legal" size="75" maxlength="100" value="<?php echo $tipo_situacion_legal?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="113" scope="col"><div align="left"><span class="Estilo5">C.I. RESPONSABLE VERIFICADOR :</span></div></td>
                 <td width="177" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtced_res_verificador" type="text" class="Estilo5" id="txtced_res_verificador" size="15" maxlength="12" value="<?php echo $ced_verificador?>" >
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_responsableverd.php?criterio=','SIPAP','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="94" scope="col"><div align="left"><span class="Estilo5">FECHA DE VERIFICACI&Oacute;N :</span></div></td>
                 <td width="559" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_verificacion" type="text" class="Estilo5" id="txtfecha_verificacion" size="20" maxlength="15"  value="<?php echo $fecha_verificacion?>" >
                     <span class="Estilo10"><span class="menu"><strong><strong>                 </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="93" scope="col"><div align="left"><span class="Estilo5">NOMBRE DEL VERIFICADOR :</span></div></td>
                 <td width="856" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_res_ver" type="text" class="Estilo5" id="txtnombre_res_ver" size="85" maxlength="250" value="<?php echo $nombre_res_ver?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><span class="Estilo12">INCORPORACI&Oacute;N</span></td>
           </tr>
            <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO MOVIMIENTO INCORPORACI&Oacute;N:</span></div></td>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcodigo_tipo_incorp" type="text" class="Estilo5" id="txtcodigo_tipo_incorp" size="5" maxlength="15" value="<?php echo $codigo_tipo_incorp?>" >
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre224222222436252" type="button" id="bttipo_codeingre224222222436252" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIPAP'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="739" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtcode_ingre_mora2222322426232" type="text" class="Estilo5" id="txtcode_ingre_mora2222322426232" size="75" maxlength="15" value="<?php echo $tipo_incorporacion?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5">TIPO DE INCORPORACI&Oacute;N :</span></div></td>
                 <td width="839" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                      <select name="txttipo_incorporacion" size="1" id="txttipo_incorporacion">
                        <option value='1'>PRESUPUESTARIA</option>
                        <option value='2'>NO PRESUPUESTARIA</option>
                      </select>
                 </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">C&Oacute;D. IMPUTACI&Oacute;N PRESUPUESTARIA :</span></div></td>
                 <td width="829" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtcod_imp_presup" type="text" class="Estilo5" id="txtcod_imp_presup" size="35" maxlength="32"  value="<?php echo $cod_imp_presup?>" >
                     <span class="Estilo10"><span class="menu"><strong><strong>
                     <input name="bttipo_codeingre2242222224362522" type="button" id="bttipo_codeingre2242222224362522" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIPAP'="";''="";'750'="";'500'="";'true')" value="...">
                     </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="129" scope="col"><div align="left"><span class="Estilo5">NOMBRE IMPUTACI&Oacute;N PRESUPUESTARIA :</span></div></td>
                 <td width="820" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnom_imp_presup" type="text" class="Estilo5" id="txtnom_imp_presup" size="75" maxlength="100" value="<?php echo $nom_imp_presup?>" >
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="32"><table width="961">
               <tr>
                 <td width="205" scope="col"><div align="left"><span class="Estilo5">DESCRIPCI&Oacute;N DE INCORPORACI&Oacute;N NO PRESUPUESTARIA :</span></div></td>
                 <td width="744" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdes_imp_nopresup" type="text" class="Estilo5" id="txtdes_imp_nopresup" size="75" maxlength="100" value="<?php echo $des_imp_nopresup?>" >
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="111" scope="col"><div align="left"><span class="Estilo5">VALOR INCORPORACI&Oacute;N :</span></div></td>
                 <td width="159" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtvalor_incorporacion" type="text" class="Estilo5" id="txtvalor_incorporacion" size="20" maxlength="15" value="<?php echo $valor_incorporacion?>" >
                     <span class="menu"><strong><strong>                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5">FECHA INCORPORACI&Oacute;N :</span></div></td>
                 <td width="300" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_incorporacion" type="text" class="Estilo5" id="txtfecha_incorporacion" size="20" maxlength="15"  value="<?php echo $fecha_incorporacion?>">
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="69" scope="col"><span class="Estilo5"></span></td>
                 <td width="311" scope="col"><span class="Estilo5">
          
                 </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="96" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO ORDEN DE COMPRA :</span></div></td>
                 <td width="134" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtnro_oc" type="text" class="Estilo5" id="txtnro_oc" size="10" maxlength="8"  value="<?php echo $nro_oc?>" >
                     <span class="menu"><strong><strong>                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="87" scope="col"><div align="left"><span class="Estilo5">FECHA ORDEN DE COMPRA :</span></div></td>
                 <td width="626" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_oc" type="text" class="Estilo5" id="txtfecha_oc" size="20" maxlength="15" value="<?php echo $fecha_oc?>" >
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="99" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO ORDEN DE PAGO :</span></div></td>
                <td width="144" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtnro_op" type="text" class="Estilo5" id="txtnro_op" size="10" maxlength="8" value="<?php echo $nro_op?>" >
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="85" scope="col"><div align="left"><span class="Estilo5">FECHA ORDEN DE PAGO :</span></div></td>
                <td width="615" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtfecha_op" type="text" class="Estilo5" id="txtfecha_op" size="15" maxlength="10" value="<?php echo $fecha_op?>" >
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
           <tr>
             <td><table width="962">
               <tr>
                 <td width="106" scope="col"><span class="Estilo5">DOCUMENTO QUE CANCELA :</span></td>
                 <td width="130" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">                     <span class="menu"><strong><strong><strong><strong>
                    <select name="txttipo_doc_cancela" id="txttipo_doc_cancela">
                      <option value="CHEQUE">CHEQUE</option>
                      <option value="NOTA DEBITO">NOTA DEBITO</option>
                    </select>
                 </strong></strong> </strong></strong></span> </span></span></div></td>
                 <td width="86" scope="col"><span class="Estilo5">N&Uacute;MERO DOCUMENTO :</span></td>
                 <td width="129" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnro_doc_cancela" type="text" class="Estilo5" id="txtnro_doc_cancela" size="10" maxlength="8"  value="<?php echo $nro_doc_cancela?>">
                 </span></div></td>
                 <td width="85" scope="col"><div align="left"><span class="Estilo5">FECHA DOCUMENTO :</span></div></td>
                 <td width="398" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_doc_cancela" type="text" class="Estilo5" id="txtfecha_doc_cancela size="20" maxlength="15" value="<?php echo $fecha_doc_cancela?>">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="73" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO DE FACTURA :</span></div></td>
                 <td width="136" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtnro_factura" type="text" class="Estilo5" id="txtnro_factura" size="25" maxlength="20"   value="<?php echo $nro_factura?>">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="64" scope="col"><div align="left"><span class="Estilo5">FECHA DE FACTURA :</span></div></td>
                 <td width="670" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_factura" type="text" class="Estilo5" id="txtfecha_factura" size="20" maxlength="15"   value="<?php echo $fecha_factura?>">
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="86" scope="col"><div align="left"><span class="Estilo5">CI/RIF PROVEEDOR :</span></div></td>
                 <td width="250" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtced_rif_proveedor" type="text" class="Estilo5" id="txtced_rif_proveedor" size="15" maxlength="12"  value="<?php echo $ced_rif_proveedor?>">
                     <span class="menu"><strong><strong>
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_proveedoresd.php?criterio=','SIPAP','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="696" scope="col"><div align="left"><span class="Estilo5">
                      <input name="txtnombre_proveedor" type="text" class="Estilo5" id="txtnombre_proveedor" size="60" maxlength="100"   value="<?php echo $nom_proveedor?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
 <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
         </table>
         <p>&nbsp;</p>
       </div>

         </form>
    </td>
  </tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>
