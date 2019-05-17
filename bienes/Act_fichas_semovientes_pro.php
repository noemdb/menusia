<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="02-0000015"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$cod_bien_sem='';$p_letra="";
  $sql="SELECT * FROM BIEN016 ORDER BY cod_bien_sem";}
else {
  $cod_bien_sem = $_GET["Gcod_bien_sem"];
  $p_letra=substr($cod_bien_sem, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$cod_bien_sem=substr($cod_bien_sem,1,12);}
   else{$cod_bien_sem=substr($cod_bien_sem,0,12);}
  $sql="Select * from BIEN016 where cod_bien_sem='$cod_bien_sem' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN016 ORDER BY cod_bien_sem";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN016 Order by cod_bien_sem desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN016 Where (cod_bien_sem>'$cod_bien_sem') Order by cod_bien_sem";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN016 Where (cod_bien_sem<'$cod_bien_sem') Order by cod_bien_sem desc";}
  //echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Actualiza Ficha de Bienes Inmuebles)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
var Gcod_bien_sem = "";
function Llamar_Ventana(url){var murl;
    Gcod_bien_sem=document.form1.txtcod_bien_sem.value;
    murl=url+Gcod_bien_sem;
    if (Gcod_bien_sem=="")
        {alert("Codigo del Bien debe ser Seleccionado");}
        else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_fichas_semovientes_pro.php";
   if(MPos=="P"){murl="Act_fichas_semovientes_pro.php?Gcod_bien_sem=P"}
   if(MPos=="U"){murl="Act_fichas_semovientes_pro.php?Gcod_bien_sem=U"}
   if(MPos=="S"){murl="Act_fichas_semovientes_pro.php?Gcod_bien_sem=S"+document.form1.txtcod_bien_sem.value;}
   if(MPos=="A"){murl="Act_fichas_semovientes_pro.php?Gcod_bien_sem=A"+document.form1.txtcod_bien_sem.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar el Semoviente?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar el Semoviente?");
    if (r==true) {url="Delete_fichas_semovientes_pro.php?Gcod_bien_sem="+document.form1.txtcod_bien_sem.value; VentanaCentrada(url,'Eliminar el Semoviente','','400','400','true');}}
   else { url="Cancelado, no elimino"; }
}
</script>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
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
$cod_bien_sem=""; $cod_clasificacion=""; $num_bien="";$denominacion=""; $cod_dependencia=""; $cod_empresa=""; $cod_direccion=""; $cod_departamento=""; $ced_responsable=""; $fecha_actualizacion="";
$ced_responsable_uso="";$cod_metodo_rot="";$ced_rotulador=""; $fecha_rotulacion="";$direccion=""; $cod_region=""; $cod_entidad=""; $cod_municipio=""; $cod_ciudad=""; $cod_parroquia=""; $cod_postal="";$caracteristicas="";$raza=""; $color=""; $sexo=""; $uso=""; $tam_peso=""; $fecha_nacimiento=""; $edad=""; $cod_contablea="";$cod_contabled="";$tipo_depreciacion="";$tasa_deprec=""; $vida_util=""; $valor_residual=""; $sit_contable="";$sit_legal=""; $edo_conservacion="";$ced_verificador=""; $fecha_verificacion=""; $tipo_incorporacion=""; $cod_imp_presup=""; $nom_imp_presup="";$des_imp_nopresup=""; $fecha_incorporacion=""; $valor_incorporacion="";$nro_oc=""; $fecha_oc=""; $nro_op=""; $fecha_op=""; $tipo_doc_cancela=""; $nro_doc_cancela=""; $fecha_doc_cancela="";$ced_rif_proveedor=""; $codigo_tipo_incorp=""; $nom_proveedor=""; $cod_presup_dep=""; $monto_depreciado=""; $nro_factura=""; $fecha_factura=""; $desincorporado=""; $fecha_desincorporado="";$des_desincorporado="";$descripcion_b="";  $denominacion_empresa=""; $denominacion_dependencia=""; $denominacion_dir="";$denominacion_dep="";  $nombre_res="";  $nombre_res_uso="";  $metodo_rotula="";  $nombre_res_rotu="";$nombre_region="";  $estado="";  $nombre_municipio=""; $nombre_ciudad="";  $nombre_parroquia=""; $tipo_situacion_cont="";  $tipo_situacion_legal=""; $edo_bien="";  $nombre_res_ver="";$status_bien_sem=""; $usuario_sia=""; $inf_usuario="";    
$res=pg_query($sql);
$filas=pg_num_rows($res);
if ($filas==0){
  if ($p_letra=="S"){$sql="SELECT * From BIEN016 ORDER BY cod_bien_sem";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN016 ORDER BY cod_bien_sem desc";}
  $res=pg_query($sql);
  $filas=pg_num_rows($res);
}
if($filas>=1){
  $registro=pg_fetch_array($res,0);
//print_r($registro);
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
  $fecha_rotulacion=$registro["fecha_rotulaciÃ³n"];
if($fecha_rotulacion==""){$fecha_rotulacion="";}else{$fecha_rotulacion=formato_ddmmaaaa($fecha_rotulacion);}
  //$fecha_rotulacion=$registro["fecha_rotulación"];
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
    <td width="836"><div align="center" class="Estilo2 Estilo6">FICHA SEMOVIENTES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="1702" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="1696"><table width="92" height="1699" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <?if ($Mcamino{0}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_ficha_semovientes_pro.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_ficha_semovientes_pro.php">Incluir</A></td>
      </tr>
     <?} if ($Mcamino{1}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_fichas_semovientes_pro.php?Gcod_bien_sem=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_fichas_semovientes_pro.php?Gcod_bien_sem=');">Modificar</A></td>
      </tr>
     <?} if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu_a.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu_a.php">Consultar</A></td>
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_fichas_semovientes_pro.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_fichas_semovientes_pro.php" class="menu">Catalogo</a></td>
      </tr>
     <?} if ($Mcamino{3}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
      </tr>
     <?} if ($Mcamino{4}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu_a.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu_a.php">Imprimir</A></td>
      </tr>
     <?} if ($Mcamino{5}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu_a.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu_a.php">Formato</A></td>
      </tr>
     <? }?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu_a.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu_a.php">Utilidades</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu_a.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu_a.php">Ayuda</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Procesos </A></td>
      </tr>
  <tr>
    <td height="1000">&nbsp;</td>
  </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana=""; Arial=""; Helvetica=""; sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:861px; height:523px; z-index:1; top: 77px; left: 121px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DE CLACIFICACI&Oacute;N:</span></div></td>
                 <td width="200" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_clasificacion" type="text" id="txtcod_clasificacion" size="10" maxlength="10"  value="<?echo $cod_clasificacion?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre2242222224" type="button" id="bttipo_codeingre22422222244" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="725" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion" type="text" id="txtdenominacion" size="70" maxlength="250" value="<?echo $denominacion?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO DEL BIEN:</span></div></td>
                 <td width="300" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtnum_bien" type="text" id="txtnum_bien" size="20" maxlength="20" value="<?echo $num_bien?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222242" type="button" id="bttipo_codeingre224222222422" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="123...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="108" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEL BIEN INMUEBLE :</span></div></td>
                 <td width="582" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtcod_bien_sem" type="text" id="txtcod_bien_sem" size="40" maxlength="30" value="<?echo $cod_bien_sem?>" readonly class="Estilo5">
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">DENOMINACI&Oacute;N DEL BIEN :</span></div></td>
                 <td width="855" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdescripcion" type="text" id="txtdescripcion" size="90" maxlength="250" value="<?echo $denominacion?>" readonly class="Estilo5">
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
                     <input name="txtcod_empresa" type="text" id="txtcod_empresa" size="4" maxlength="3" value="<?echo $cod_empresa?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Empresas" onClick="VentanaCentrada('Cat_empresasd.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="762" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_empresa" type="text" id="txtnombre_empresa" size="75" maxlength="100" value="<?echo $denominacion_empresa?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DIRECCI&Oacute;N :</span></div></td>
                 <td width="109" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_direccion" type="text" id="txtcod_direccion" size="5" maxlength="4" value="<?echo $cod_direccion?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222245" type="button" id="bttipo_codeingre22422222247" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="758" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dir" type="text" id="txtdenominacion_dir" size="75" maxlength="100" value="<?echo $denominacion_dir?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></div></td>
                 <td width="160" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_departamento" type="text" id="txtcod_departamento" size="10" maxlength="8" value="<?echo $cod_departamento?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222246" type="button" id="bttipo_codeingre22422222248" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="714" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="70" maxlength="100"  value="<?echo $denominacion_dep?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></div></td>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4" value="<?echo $cod_dependencia?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222244" type="button" id="bttipo_codeingre22422222246" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="747" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="74" maxlength="250" value="<?echo $denominacion_dependencia?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
         </table>

         <table width="828" align="center">
           <tr>
             <td><table width="963">
               <tr>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5">C.I. RESPONSABLE PRIMARIO :</span></div></td>
                 <td width="230" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtced_responsable" type="text" id="txtced_responsable" size="15" maxlength="12"  value="<?echo $ced_responsable?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222246" type="button" id="bttipo_codeingre22422222248" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="744" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtnombre_res" type="text" id="txtnombre_res" size="65" maxlength="250"  value="<?echo $nombre_res?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5">C.I. RESPONSABLE DE USO :</span></div></td>
                 <td width="230" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtced_responsable_uso" type="text" id="txtced_responsable_uso" size="15" maxlength="12"  value="<?echo $ced_responsable_uso?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222246" type="button" id="bttipo_codeingre22422222248" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="744" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtnombre_res" type="text" id="txtnombre_res" size="65" maxlength="250"  value="<?echo $nombre_res_uso?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">METODO DE ROTULACI&Oacute;N :</span></div></td>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_metodo_rot" type="text" id="txtcod_metodo_rot" size="4" maxlength="2" value="<?echo $cod_metodo_rot?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222246" type="button" id="bttipo_codeingre22422222248" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="767" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnom_metodo_rot" type="text" id="txtnom_metodo_rot" size="75" maxlength="250" value="<?echo $metodo_rotula?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5">C&Eacute;DULA DE ROTULADOR :</span></div></td>
                 <td width="230" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtced_rotulador" type="text" id="txtced_rotulador" size="15" maxlength="12"  value="<?echo $ced_rotulador?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222246" type="button" id="bttipo_codeingre22422222248" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="744" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtnombre_res" type="text" id="txtnombre_res" size="65" maxlength="250"  value="<?echo $nombre_res_rotu?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="92" scope="col"><div align="left"><span class="Estilo5">FECHA ROTULACI&Oacute;N :</span></div></td>
                 <td width="132" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtfecha_rotulacion" type="text" id="txtfecha_rotulacion" size="20" maxlength="15" value="<?echo $fecha_rotulacion?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="105" scope="col"><div align="left"><span class="Estilo5">FECHA ULTIMA ACTUALIZACI&Oacute;N :</span></div></td>
                 <td width="614" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_actualizacion" type="text" id="txtfecha_actualizacion" size="20" maxlength="15" value="<?echo $fecha_actualizacion?>" readonly class="Estilo5">
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
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
                     <textarea name="textcod_direccion" cols="70" onFocus="encender(this)" onBlur="apagar(this)" readonly class="Estilo5" class="headers" id="textcod_direccion"><?echo $direccion?></textarea>
                 </div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">REGI&Oacute;N :</span></div></td>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_region" type="text" id="txtcod_region" size="4" maxlength="2" value="<?echo $cod_region?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre224222222432" type="button" id="bttipo_codeingre224222222432" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="798" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_region" type="text" id="txtnombre_region" size="75" maxlength="250"  value="<?echo $nombre_region?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">ENTIDAD FEDERAL :</span></div></td>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_entidad" type="text" id="txtcod_entidad" size="4" maxlength="2" value="<?echo $cod_entidad?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre224222222433" type="button" id="bttipo_codeingre224222222433" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="798" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_entidad" type="text" id="txtnombre_entidad" size="75" maxlength="250"  value="<?echo $estado?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">MUNICIPIO :</span></div></td>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_municipio" type="text" id="txtcod_municipio" size="5" maxlength="4" value="<?echo $cod_municipio?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre224222222434" type="button" id="bttipo_codeingre224222222434" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="750" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_municipio" type="text" id="txtnombre_municipio" size="75" maxlength="250" value="<?echo $nombre_municipio?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">CIUDAD :</span></div></td>
                 <td width="105" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_ciudad" type="text" id="txtcod_ciudad" size="5" maxlength="4"  value="<?echo $cod_ciudad?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre224222222435" type="button" id="bttipo_codeingre224222222435" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="784" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_ciudad" type="text" id="txtnombre_ciudad" size="75" maxlength="250" value="<?echo $nombre_ciudad?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">PARROQUIA :</span></div></td>
                 <td width="121" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_parroquia" type="text" id="txtcod_parroquia" size="7" maxlength="6" value="<?echo $cod_parroquia?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre224222222436" type="button" id="bttipo_codeingre224222222436" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="744" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_parroquia" type="text" id="txtnombre_parroquia" size="70" maxlength="250" value="<?echo $nombre_parroquia?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO POSTAL :</span></div></td>
                 <td width="891" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtcod_postal" type="text" id="txtcod_postal" size="12" maxlength="10" value="<?echo $cod_postal?>" readonly class="Estilo5"> 
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
                     <textarea name="textcaracteristicas" cols="70" readonly class="Estilo5" class="headers" id="textcaracteristicas"><?echo $caracteristicas?></textarea>
                 </div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">RAZA:</span></div></td>
                 <td width="203" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtraza" type="text" id="txtraza" size="60" maxlength="60" value="<?echo $raza?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="60" scope="col"><div align="left"><span class="Estilo5">COLOR :</span></div></td>
                 <td width="626" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtcolor" type="text" id="txtcolor" size="30" maxlength="30" value="<?echo $color?>" readonly class="Estilo5">
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">SEXO :</span></div></td>
                 <td width="350" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtsexo" type="text" id="txtsexo" size="30" maxlength="30" value="<?echo $sexo?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     </strong></strong></span>                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">USO :</span></div></td>
                 <td width="600" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtuso" type="text" id="txtuso" size="30" maxlength="30" value="<?echo $uso?>" readonly class="Estilo5">
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">TAMAÑO PESO :</span></div></td>
                 <td width="204" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txttam_peso" type="text" id="txttam_peso" size="30" maxlength="30" value="<?echo $tam_peso?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">FECHA NACIMIENTO :</span></div></td>
                 <td width="700" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_nacimiento" type="text" id="txtfecha_nacimiento" size="15" maxlength="15"  value="<?echo $fecha_nacimiento?>" readonly class="Estilo5">
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">EDAD:</span></div></td>
                 <td width="621" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtedad" type="text" id="txtedad" size="4" maxlength="4"  value="<?echo $edad?>" readonly class="Estilo5">
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
                     <input name="txtcod_contablea" type="text" id="txtcod_contablea" size="30" maxlength="25" value="<?echo $cod_contablea?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222243622" type="button" id="bttipo_codeingre22422222243622" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                     </strong></strong></span>                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="117" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO CONTABLE DEPRECIACI&Oacute;N :</span></div></td>
                 <td width="600" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtcod_contabled" type="text" id="txtcod_contabled" size="30" maxlength="25" value="<?echo $cod_contabled?>" readonly class="Estilo5">
                     <span class="Estilo10"><span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222243623" type="button" id="bttipo_codeingre22422222243623" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                     </strong></strong></span></span>                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="98" scope="col"><div align="left"><span class="Estilo5">TIPO DE DEPRECIACI&Oacute;N :</span></div></td>
                 <td width="146" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">                     <span class="menu"><strong><strong>                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                   <select name="txt_tipo_depreciacion">
                     <option>LINEA RECTA</option>
                     <option>NINGUNA</option>
                        </select> 
                   </strong></strong></span></span> </span></div></td>
                 <td width="103" scope="col"><div align="left"><span class="Estilo5">TASA DEPRECIACI&Oacute;N :</span></div></td>
                 <td width="596" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txttasa_deprec" type="text" id="txttasa_deprec" size="10" maxlength="15" value="<?echo $tasa_deprec?>" readonly class="Estilo5">
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
                     <input name="txtvida_util" type="text" id="txtvida_util" size="10" maxlength="15" value="<?echo $vida_util?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="71" scope="col"><div align="left"><span class="Estilo5">VALOR RESIDUAL :</span></div></td>
                 <td width="699" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtvalor_residual" type="text" id="txtvalor_residual" size="20" maxlength="15" value="<?echo $valor_residual?>" readonly class="Estilo5">
                     <span class="Estilo10"><span class="menu"><strong><strong>                 </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="164" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO DE DEPRECIACI&Oacute;N :</span></div></td>
                 <td width="370" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_presup_dep" type="text" id="txtcod_presup_dep" size="35" maxlength="32" value="<?echo $cod_presup_dep?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre224222222436222" type="button" id="bttipo_codeingre224222222436224" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                     </strong></strong></span>                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="85" scope="col"><div align="left"><span class="Estilo5">MONTO DEPRECIADO :</span></div></td>
                 <td width="362" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtmonto_depreciado" type="text" id="txtmonto_depreciado" size="20" maxlength="15" value="<?echo $monto_depreciado?>" readonly class="Estilo5">
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">DESINCORPORADO :</span></div></td>
                 <td width="" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>                     <select name="txt_desincorporado">
                       <option>SI</option>
                       <option>NO</option>
                     </select>
                 </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" height="27" scope="col"><div align="left"><span class="Estilo5">SITUACI&Oacute;N CONTABLE :</span></div></td>
                 <td width="97" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtsit_contable" type="text" id="txtsit_contable" size="4" maxlength="2" value="<?echo $sit_contable?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222243624" type="button" id="bttipo_codeingre22422222243624" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="777" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txttipo_situacion_cont" type="text" id="txttipo_situacion_cont" size="75" maxlength="100" value="<?echo $tipo_situacion_cont?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" height="27" scope="col"><div align="left"><span class="Estilo5">SITUACI&Oacute;N LEGAL :</span></div></td>
                 <td width="97" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtsit_legal" type="text" id="txtsit_legal" size="4" maxlength="2" value="<?echo $sit_legal?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222243624" type="button" id="bttipo_codeingre22422222243624" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="777" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txttipo_situacion_legal" type="text" id="txttipo_situacion_legal" size="75" maxlength="100" value="<?echo $tipo_situacion_legal?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="113" scope="col"><div align="left"><span class="Estilo5">C.I. RESPONSABLE VERIFICADOR :</span></div></td>
                 <td width="177" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtced_verificador " type="text" id="txtced_verificador " size="15" maxlength="12" value="<?echo $ced_verificador?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre224222222436223" type="button" id="bttipo_codeingre224222222436225" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="94" scope="col"><div align="left"><span class="Estilo5">FECHA DE VERIFICACI&Oacute;N :</span></div></td>
                 <td width="559" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_verificacion" type="text" id="txtfecha_verificacion" size="20" maxlength="15"  value="<?echo $fecha_verificacion?>" readonly class="Estilo5">
                     <span class="Estilo10"><span class="menu"><strong><strong>                 </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="93" scope="col"><div align="left"><span class="Estilo5">NOMBRE DEL VERIFICADOR :</span></div></td>
                 <td width="856" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_res_ver" type="text" id="txtnombre_res_ver" size="85" maxlength="250" value="<?echo $nombre_res_ver?>" readonly class="Estilo5">
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
                     <input name="txtcodigo_tipo_incorp" type="text" id="txtcodigo_tipo_incorp" size="5" maxlength="15" value="<?echo $codigo_tipo_incorp?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre224222222436252" type="button" id="bttipo_codeingre224222222436252" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="739" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtcode_ingre_mora2222322426232" type="text" id="txtcode_ingre_mora2222322426232" size="75" maxlength="15" value="<?echo $tipo_incorporacion?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5">TIPO DE INCORPORACI&Oacute;N :</span></div></td>
                 <td width="839" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <select name="txttipo_incorporacion">
                     <option>PRESUPUESTARIA</option>
                     <option>NO PRESUPUESTARIA</option>
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
                     <input name="txtcod_imp_presup" type="text" id="txtcod_imp_presup" size="35" maxlength="32"  value="<?echo $cod_imp_presup?>" readonly class="Estilo5">
                     <span class="Estilo10"><span class="menu"><strong><strong>
                     <input name="bttipo_codeingre2242222224362522" type="button" id="bttipo_codeingre2242222224362522" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                     </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="129" scope="col"><div align="left"><span class="Estilo5">NOMBRE IMPUTACI&Oacute;N PRESUPUESTARIA :</span></div></td>
                 <td width="820" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnom_imp_presup" type="text" id="txtnom_imp_presup" size="75" maxlength="100" value="<?echo $nom_imp_presup?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="32"><table width="961">
               <tr>
                 <td width="205" scope="col"><div align="left"><span class="Estilo5">DESCRIPCI&Oacute;N DE INCORPORACI&Oacute;N NO PRESUPUESTARIA :</span></div></td>
                 <td width="744" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdes_imp_nopresup" type="text" id="txtdes_imp_nopresup" size="75" maxlength="100" value="<?echo $des_imp_nopresup?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="111" scope="col"><div align="left"><span class="Estilo5">VALOR INCORPORACI&Oacute;N :</span></div></td>
                 <td width="159" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtvalor_incorporacion" type="text" id="txtvalor_incorporacion" size="20" maxlength="15" value="<?echo $valor_incorporacion?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5">FECHA INCORPORACI&Oacute;N :</span></div></td>
                 <td width="300" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_incorporacion" type="text" id="txtfecha_incorporacion" size="20" maxlength="15"  value="<?echo $fecha_incorporacion?>" readonly class="Estilo5">
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
                     <input name="txtnro_oc" type="text" id="txtnro_oc" size="10" maxlength="8"  value="<?echo $nro_oc?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="87" scope="col"><div align="left"><span class="Estilo5">FECHA ORDEN DE COMPRA :</span></div></td>
                 <td width="626" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_oc" type="text" id="txtfecha_oc" size="20" maxlength="15" value="<?echo $fecha_oc?>" readonly class="Estilo5">
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="962">
               <tr>
                 <td width="106" scope="col"><span class="Estilo5">DOCUMENTO QUE CANCELA :</span></td>
                 <td width="130" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">                     <span class="menu"><strong><strong><strong><strong>
                   <select name="txttipo_doc_cancela">
                     <option>CHEQUE</option>
                     <option>NOTA DEBITO</option>
                        </select>
                 </strong></strong> </strong></strong></span> </span></span></div></td>
                 <td width="86" scope="col"><span class="Estilo5">N&Uacute;MERO DOCUMENTO :</span></td>
                 <td width="129" scope="col"><div align="left"></div></td>
                 <td width="85" scope="col"><div align="left"><span class="Estilo5">FECHA DOCUMENTO :</span></div></td>
                 <td width="398" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_doc_cancela" type="text" id="txtfecha_doc_cancela size="20" maxlength="15" value="<?echo $fecha_doc_cancela?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="73" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO DE FACTURA :</span></div></td>
                 <td width="136" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtnro_factura" type="text" id="txtnro_factura" size="25" maxlength="20"   value="<?echo $nro_factura?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="64" scope="col"><div align="left"><span class="Estilo5">FECHA DE FACTURA :</span></div></td>
                 <td width="670" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_factura" type="text" id="txtfecha_factura" size="20" maxlength="15"   value="<?echo $fecha_factura?>" readonly class="Estilo5">
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="86" scope="col"><div align="left"><span class="Estilo5">CI/RIF PROVEEDOR :</span></div></td>
                 <td width="250" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtced_rif_proveedor" type="text" id="txtced_rif_proveedor" size="15" maxlength="12"  value="<?echo $ced_rif_proveedor?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre224222222436253" type="button" id="bttipo_codeingre224222222436253" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="696" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnom_proveedor" type="text" id="txtnom_proveedor" size="60" maxlength="100"   value="<?echo $nom_proveedor?>" readonly class="Estilo5">
                 </span></div></td>
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
</body>
</html>
<? pg_close();?>
