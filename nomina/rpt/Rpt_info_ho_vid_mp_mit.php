<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");
if (!$_GET){ $cod_empleado_d=''; $cod_empleado_h='';} else {  $cod_empleado_d= $_GET["cod_empleado_d"];$cod_empleado_h= $_GET["cod_empleado_h"];
   $tipo_nominad=$_GET["tipo_nominad"];   $tipo_nominah=$_GET["tipo_nominah"];   $cedula_d=$_GET["cedula_d"];   $cedula_h=$_GET["cedula_h"];
   $sexo=$_GET["sexo"];   $estado_civil=$_GET["estado_civil"];   $fecha_d=$_GET["fecha_d"];   $fecha_h=$_GET["fecha_h"];
   $edad_d=$_GET["edad_d"];   $edad_h=$_GET["edad_h"];   $fecha_ingreso_d=$_GET["fecha_ingreso_d"];   $fecha_ingreso_h=$_GET["fecha_ingreso_h"];
   $estatus=$_GET["estatus"];   $codigo_cargo_d=$_GET["codigo_cargo_d"];   $codigo_cargo_h=$_GET["codigo_cargo_h"];
   $codigo_departamentod=$_GET["codigo_departamentod"];   $codigo_departamentoh=$_GET["codigo_departamentoh"];  
   }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Formato Hoja de Vida)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
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
<style type="text/css">
<!--
.Estilo16 { font-family: Arial, Helvetica, sans-serif;        font-size: 18pt;}
.Estilo17 {font-size: 8pt}
.Estilo77 {font-size: 8pt; color: #000000; font-weight: bold; }
.Estilo18 {font-size: 10pt}
.Estilo88 {font-size: 10pt; color: #000000; font-weight: bold; }
.Estilo66 {font-size: 7pt}
H1.SaltoDePagina{PAGE-BREAK-AFTER: always}
-->
</style>
</head>
<body>
<? $crit_st="and sexo ='".$sexo."' and edo_civil='".$estado_civil."' and  status ='".$estatus."'"; $crit_st="";
   if($sexo<>"TODOS"){$crit_st=$crit_st."and sexo ='".$sexo."' ";}
   if($estado_civil<>"TODOS"){$crit_st=$crit_st."and edo_civil='".$estado_civil."' ";}
   if($estatus<>"TODOS"){if($estatus=="ACTIVO/VACACIONES/PERMISO"){ $crit_st=$crit_st."and (Status='ACTIVO' or Status='VACACIONES' or Status='PERMISO')";}	 else{$crit_st=$crit_st."and status='".$estatus."'";}   }
   if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';}  $fecha_desde=$ano1.$mes1.$dia1;
   if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;
   if (!(empty($fecha_ingreso_d))){$ano1=substr($fecha_ingreso_d,6,9);$mes1=substr($fecha_ingreso_d,3,2);$dia1=substr($fecha_ingreso_d,0,2);}else{$fecha_ingreso_d='';} $fecha_desde_ing=$ano1.$mes1.$dia1;
   if (!(empty($fecha_ingreso_h))){$ano1=substr($fecha_ingreso_h,6,9);$mes1=substr($fecha_ingreso_h,3,2);$dia1=substr($fecha_ingreso_h,0,2);} else{$fecha_ingreso_h='';} $fecha_hasta_ing=$ano1.$mes1.$dia1;

$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT * From TRABAJADORES where tipo_nomina>='".$tipo_nominad."' and tipo_nomina<='".$tipo_nominah."' and  cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."' and
     cedula>='".$cedula_d."' and cedula<='".$cedula_h."' and cod_cargo>='".$codigo_cargo_d."' and cod_cargo<='".$codigo_cargo_h."' and
	 cod_departam>='".$codigo_departamentod."' and cod_departam<='".$codigo_departamentoh."' and fecha_nacimiento>='".$fecha_desde."' and fecha_nacimiento<='".$fecha_hasta."'and
     edad>='".$edad_d."' and edad<='".$edad_h."' and fecha_ingreso>='".$fecha_desde_ing."' and fecha_ingreso<='".$fecha_hasta_ing."' ".$crit_st." order by cod_empleado";
				  
$cod_empleado=""; $nombre=""; $res=pg_query($sql); 
while($registro=pg_fetch_array($res)){  $cod_empleado=$registro["cod_empleado"];     
  $cedula=$registro["cedula"]; $nacionalidad=$registro["nacionalidad"]; $nombre=$registro["nombre"];   $status=$registro["status"];
  $fecha_ingreso=$registro["fecha_ingreso"]; $fecha_ing_adm=$registro["fecha_ing_adm"]; $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);  $fecha_ing_adm=formato_ddmmaaaa($fecha_ing_adm);
  $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; $cod_categoria=$registro["cod_categoria"]; $tipo_pago=$registro["tipo_pago"]; $cta_empleado=$registro["cta_empleado"]; $tipo_cuenta=$registro["tipo_cuenta"];
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $cta_empresa=$registro["cta_empresa"]; $calculo_grupos=$registro["calculo_grupos"]; $cod_jerarquia=$registro["cod_jerarquia"];
  $tiene_dec_jurada=$registro["tiene_dec_jurada"]; $fecha_declaracion=$registro["fecha_declaracion"]; $monto_declaracion=$registro["monto_declaracion"];  $fecha_declaracion=formato_ddmmaaaa($fecha_declaracion);
  $tiene_lph=$registro["tiene_lph"]; $banco_lph=$registro["banco_lph"]; $cta_lph=$registro["cta_lph"]; $fecha_lph=$registro["fecha_lph"]; $fecha_des_lph=$registro["fecha_des_lph"]; $modif_lph=$registro["modif_lph"]; $fecha_lph=formato_ddmmaaaa($fecha_lph); $fecha_des_lph=formato_ddmmaaaa($fecha_des_lph);
  $fecha_fin_con=$registro["fecha_fin_con"]; $fecha_egreso=$registro["fecha_egreso"]; $motivo_egreso=$registro["motivo_egreso"]; $cont_fijo=$registro["cont_fijo"];  $fecha_fin_con=formato_ddmmaaaa($fecha_fin_con);  $fecha_egreso=formato_ddmmaaaa($fecha_egreso);
  $tipo_vacaciones=$registro["tipo_vacaciones"]; $pago_vaciones=$registro["pago_vaciones"]; $fecha_pago=$registro["fecha_pago"]; $cod_jerarquia=$registro["cod_jerarquia"]; $fecha_pago=formato_ddmmaaaa($fecha_pago);
  $codigo_ubicacion=$registro["codigo_ubicacion"]; $descripcion_ubi=$registro["descripcion_ubi"]; $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $rif_empleado=$registro["rif_empleado"];
  $apellido1=$registro["apellido1"];$apellido2=$registro["apellido2"]; $direccion=$registro["direccion"];$grado_inst=$registro["grado_inst"]; $profesion=$registro["profesion"];
  $sexo=$registro["sexo"]; $edo_civil=$registro["edo_civil"]; $fecha_nacimiento=$registro["fecha_nacimiento"]; $edad=$registro["edad"];  $fecha_nacimiento=formato_ddmmaaaa($fecha_nacimiento);
  $lugar_nacimiento=$registro["lugar_nacimiento"]; $cod_postal=$registro["cod_postal"]; $telefono=$registro["telefono"];  $tlf_movil=$registro["tlf_movil"];  $correo=$registro["correo"];
  $estado=$registro["estado"]; $ciudad=$registro["ciudad"]; $municipio=$registro["municipio"]; $parroquia=$registro["parroquia"]; $aptdo_postal=$registro["aptdo_postal"];
  $observacion=$registro["observacion"]; $talla_camisa=$registro["talla_camisa"]; $talla_pantalon=$registro["talla_pantalon"]; $talla_calzado=$registro["talla_calzado"];
  $poliza=$registro["poliza"]; $fecha_seguro=$registro["fecha_seguro"]; $fecha_seguro=formato_ddmmaaaa($fecha_seguro);
  $tiene_aus_pro=$registro["tiene_aus_pro"]; $motivo_ausencia=$registro["motivo_ausencia"];  $fecha_aus_desde=$registro["fecha_aus_desde"]; $fecha_aus_hasta=$registro["fecha_aus_hasta"];  $fecha_aus_desde=formato_ddmmaaaa($fecha_aus_desde); $fecha_aus_hasta=formato_ddmmaaaa($fecha_aus_hasta);
  $inf_usuario=$registro["inf_usuario"]; $monto_declaracion=formato_monto($monto_declaracion); $edad=round($edad);
  
  if($tiene_dec_jurada=="S"){$tiene_dec_jurada="SI";}else{$tiene_dec_jurada="NO"; $monto_declaracion=0;} if($tiene_lph=="S"){$tiene_lph="SI";}else{$tiene_lph="NO";}
  If(($status=="INACTIVO")Or($status=="JUBILADO")Or($status=="PENSIONADO")Or($status=="RETIRADO")Or($status=="DESPEDIDO")Or($status=="RENUNCIA")Or($status=="FALLECIDO")Or($status=="AÑO SABATICO")Or($status=="VACANTE")){$egresado="S";}else{$egresado="N";}
  If($cont_fijo=="F"){$cont_fijo="FIJO";} If($cont_fijo=="C"){$cont_fijo="CONTRATADO";} If($cont_fijo=="S"){$cont_fijo="SUPLENTE";}
  if($tipo_vacaciones=="N"){$tipo_vacaciones="NO";$fecha_pago="";}else{$tipo_vacaciones="SI";} if($tiene_aus_pro=="N"){$tiene_aus_pro="NO";$fecha_aus_desde="";$fecha_aus_hasta="";}else{$tiene_aus_pro="SI";}
  $jerarquia="OTROS"; if($cod_jerarquia=="01"){$jerarquia="ADMINISTRATIVO";} if($cod_jerarquia=="02"){$jerarquia="PROFESIONALES Y TECNICOS";} if($cod_jerarquia=="03"){$jerarquia="ALTO NIVEL";} if($cod_jerarquia=="04"){$jerarquia="OBRERO";}
  
 ?> 
<table width="981" height="292" border="1" cellpadding="0" cellspacing="0">
<tr><td height="291"><table width="980" border="0"  height="291" cellpadding="0" cellspacing="0">
<?include ("encabezado_hoja_vida.php"); ?>  
</tr>
    <tr><td height="25"><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr> <td><div align="center" class="Estilo88">INFORMACION ASIGNACION DE LOS CARGOS</div></td> </tr>
    </table></td>
</tr>
<tr><td height="25"><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
         <td width="106"><span class="Estilo77">CODIGO</span></td>
         <td width="242"><span class="Estilo77">DENOMINACION CARGO</span></td>
	     <td width="86"><span class="Estilo77">CODIGO</span></td>
	     <td width="285"><span class="Estilo77">DEPARTAMENTO</span></td>
	     <td width="108"><span class="Estilo77">FECHA ASIGNACION</span></td>
		 <td width="129"><span class="Estilo77">SUELDO CARGO </span></td>
      </tr>
    </table></td>
</tr>
<?$sqlc="SELECT * FROM ASIG_CARGO  where cod_empleado='$cod_empleado' order by fecha_asigna"; $resc=pg_query($sqlc);
while($reg=pg_fetch_array($resc)){$sfecha=$reg["fecha_asigna"]; $fechaa=formato_ddmmaaaa($sfecha);  $sueldo=formato_monto($reg["sueldo"]); $monto_c=formato_monto($reg["compensacion"]);  
$cod_cargo=$reg["cod_cargo"]; $des_cargo=$reg["des_cargo"]; $cod_departamento=$reg["cod_departamento"]; $des_departamento=$reg["des_departamento"];;
?>
  <tr><td height="25"><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
         <td width="106"><span class="Estilo17"><?echo $cod_cargo ?></span></td>
         <td width="242"><span class="Estilo17"><?echo $des_cargo ?></span></td>
	     <td width="86"><span class="Estilo17"><?echo $cod_departamento ?></span></td>
	     <td width="285"><span class="Estilo17"><?echo $des_departamento ?></span></td>
	     <td width="108"><span class="Estilo17"><?echo $fechaa ?></span></td>
		 <td width="129" align="right"><span class="Estilo17"><?echo $sueldo ?></span></td>
      </tr>
    </table></td>
  </tr>
<?}
$sqlc="SELECT * FROM NOM009 where cod_empleado='$cod_empleado' order by ci_partida"; $resc=pg_query($sqlc); $filas=pg_num_rows($resc);
if($filas>=1){
?>
</tr>
    <tr><td height="25"><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr> <td><div align="center" class="Estilo88">INFORMACION FAMILIAR</div></td></tr>
    </table></td>
</tr>
<tr><td height="25"><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
         <td width="110"><span class="Estilo77">CEDULA</span></td>
         <td width="445"><span class="Estilo77">NOMBRE</span></td>
	     <td width="110"><span class="Estilo77">PARENTESO</span></td>
	     <td width="85"><span class="Estilo77">SEXO</span></td>
	     <td width="120"><span class="Estilo77">FEC.NACIMIENTO</span></td>
		 <td width="90"><span class="Estilo77">EDAD</span></td>
      </tr>
    </table></td>
</tr>
<?
while($reg=pg_fetch_array($resc)){  $sfecha=$reg["fecha_nac"];  $fecha=formato_ddmmaaaa($sfecha); ?>
   <tr><td height="25"><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
        <td width="110" align="left"><span class="Estilo17"><? echo $reg["ci_partida"]; ?></span></td>
        <td width="445" align="left"><span class="Estilo17"><? echo $reg["nombre"]; ?></span></td>
        <td width="110" align="left"><span class="Estilo17"><? echo $reg["parentesco"]; ?></span></td>
        <td width="85" align="left"><span class="Estilo17"><? echo $reg["sexo"]; ?></span></td>
        <td width="120" align="left"><span class="Estilo17"><? echo $fecha; ?></span></td>
        <td width="90" align="right"><span class="Estilo17"><? echo $reg["edad"]; ?></span></td>
     </tr>
    </table></td>
  </tr>
<?} }
$sqlc="SELECT * FROM NOM010  where cod_empleado='$cod_empleado' order by fecha_desde"; $resc=pg_query($sqlc); $filas=pg_num_rows($resc);
if($filas>=1){
?>
</tr>
  <tr><td height="25"><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr><td><div align="center" class="Estilo88">EXPERNCIA LABORAL</div></td> </tr>
  </table></td>
</tr>
<tr><td height="25"><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
         <td width="100"><span class="Estilo77">FECHA DESDE</span></td>
		 <td width="100"><span class="Estilo77">FECHA HASTA</span></td>
         <td width="300"><span class="Estilo77">NOMBRE EMPRESA</span></td>	    
	     <td width="195"><span class="Estilo77">DEPARTAMENTO</span></td>
	     <td width="175"><span class="Estilo77">ULTIMO CARGO</span></td>
		 <td width="90"><span class="Estilo77">SUELDO</span></td>
      </tr>
    </table></td>
</tr>
<?
while($reg=pg_fetch_array($resc)){  $sfecha=$reg["fecha_desde"]; $fechad=formato_ddmmaaaa($sfecha); $sfecha=$reg["fecha_hasta"]; $fechah=formato_ddmmaaaa($sfecha); $monto_s=formato_monto($reg["sueldo"]); ?>
   <tr><td height="25"><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
        <td width="100" align="left"><span class="Estilo17"><? echo $fechad; ?></span></td>
        <td width="100" align="left"><span class="Estilo17"><? echo $fechah; ?></span></td>
        <td width="300" align="left"><span class="Estilo17"><? echo $reg["empresa"]; ?></span></td>
        <td width="195" align="left"><span class="Estilo17"><? echo $reg["departamento"]; ?></span></td>
        <td width="175" align="left"><span class="Estilo17"><? echo $reg["cargo"]; ?></span></td>
        <td width="90" align="right"><span class="Estilo17"><? echo $monto_s; ?></span></td>
     </tr>
    </table></td>
  </tr>
<?} }
$sqlc="SELECT * FROM NOM014  where cod_empleado='$cod_empleado' order by fecha"; $resc=pg_query($sqlc); $filas=pg_num_rows($resc);
if($filas>=1){
?>
</tr>
  <tr><td height="25"><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr><td><div align="center" class="Estilo88">INFORMACION CURRICULAR</div></td> </tr>
  </table></td>
</tr>
<tr><td height="25"><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
         <td width="100"><span class="Estilo77">FECHA</span></td>
		 <td width="400"><span class="Estilo77">TITULO OBTENIDO/ESTUDIO</span></td>
	     <td width="200"><span class="Estilo77">NOMBRE INSTITUTO</span></td>
	     <td width="260"><span class="Estilo77">DESCRIPCION</span></td>
      </tr>
    </table></td>
</tr>
<?
while($reg=pg_fetch_array($resc)){  $sfecha=$reg["fecha"]; $fecha=formato_ddmmaaaa($sfecha); ?>
   <tr><td height="25"><table width="1006" border="1"  height="30" cellpadding="3" cellspacing="0">
    <tr>
        <td width="100" align="left"><span class="Estilo17"><? echo $fecha; ?></span></td>
        <td width="400" align="left"><span class="Estilo17"><? echo $reg["titulo"]; ?></span></td>
        <td width="200" align="left"><span class="Estilo17"><? echo $reg["instituto"]; ?></span></td>
        <td width="260" align="left"><span class="Estilo17"><? echo $reg["descripcion"]; ?></span></td>
     </tr>
    </table></td>
  </tr>
<?} }?>
</table></td></tr>
</table>
<H1 class=SaltoDePagina> </H1>  
<? }?>
</body>
</html>
<?  pg_close();?>
