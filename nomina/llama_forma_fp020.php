<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$equipo=getenv("COMPUTERNAME"); $mcod_m="FORMA".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$cod_empleado=$_POST["txtcod_empleado"]; $mov_nuevo=$_POST["txtmov_nuevo"];  $fecha_mov=$_POST["txtfecha_mov"]; $fecha_mov_n=$_POST["txtfecha_mov_n"]; $fecha_hoy=asigna_fecha_hoy();
$mov_nuevo=substr($mov_nuevo,0,1);
?>
<html>
<head>  <title>CARGAR FORMA FP020</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Calculo(mop){ 
   if(mop=="S"){document.form2.submit(); }else {document.form3.submit(); }
}
</script>
</head>
<body>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else{ $Nom_Emp=busca_conf(); }
$error=1;$nombre="";$nacionalidad=""; $descripcion=""; $cod_jerarquia=""; $codigo_ubicacion=""; $descripcion_ubi=""; $cedula=""; $rif_empleado=""; $campo_str1="";  $campo_num1=0;
$tipo_nomina=""; $nacionalidad=""; $status=""; $fecha_ingreso=""; $fecha_ing_adm=""; $cod_categoria=""; $tipo_pago=""; $cta_empleado=""; $tipo_cuenta=""; $cod_banco=""; $nombre_banco=""; $cta_empresa=""; $calculo_grupos=""; $fecha_asigna_cargo=""; $cod_cargo=""; $cod_departam=""; $cod_tipo_personal=""; $paso=""; $grado=""; $sueldo=""; $prima=""; $compensacion=""; $otros=""; $sueldo_integral=""; $tipo_vacaciones="N"; $pago_vaciones="N"; $fecha_pago=""; $tiene_lph=""; $banco_lph=""; $cta_lph=""; $fecha_lph=""; $fecha_des_lph=""; $modif_lph=""; $tiene_dec_jurada=""; $fecha_declaracion=""; $monto_declaracion=""; $fecha_fin_con=""; $fecha_egreso=""; $motivo_egreso=""; $cont_fijo=""; $cod_cont_colec=""; $tipo_nom_ant=""; $cod_emp_ant=""; $fecha_camb_n=""; $motivo_camb_n=""; $tiene_aus_pro=""; $motivo_ausencia=""; $fecha_aus_desde=""; $fecha_aus_hasta="";  $motivo_suplen=""; $cedula_titular="";
$nombre1=""; $nombre2=""; $apellido1=""; $apellido2=""; $sexo=""; $edo_civil=""; $fecha_nacimiento=""; $edad=""; $lugar_nacimiento=""; $direccion=""; $cod_postal=""; $telefono=""; $tlf_movil=""; $correo=""; $profesion=""; $grado_inst=""; $tiempo_e=""; $poliza=""; $fecha_seguro=""; $estado=""; $ciudad=""; $municipio=""; $parroquia=""; $observacion=""; $talla_camisa=""; $talla_pantalon=""; $talla_calzado=""; $peso=""; $estatura=""; $aptdo_postal=""; $sueldo=0; 
$sql="Select * from TRABAJADORES where cod_empleado='$cod_empleado'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>=1){ $registro=pg_fetch_array($res); $error=0; $cod_empleado=$registro["cod_empleado"];  $cedula=$registro["cedula"]; $nacionalidad=$registro["nacionalidad"]; $nombre=$registro["nombre"];   $status=$registro["status"];
  $fecha_ingreso=$registro["fecha_ingreso"]; $fecha_ing_adm=$registro["fecha_ing_adm"]; $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);  $fecha_ing_adm=formato_ddmmaaaa($fecha_ing_adm); $cod_cargo=$registro["cod_cargo"]; $cod_departam=$registro["cod_departam"];
  $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; $cod_categoria=$registro["cod_categoria"]; $tipo_pago=$registro["tipo_pago"]; $cta_empleado=$registro["cta_empleado"]; $tipo_cuenta=$registro["tipo_cuenta"];
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $cta_empresa=$registro["cta_empresa"]; $calculo_grupos=$registro["calculo_grupos"]; $cod_jerarquia=$registro["cod_jerarquia"];
  $tiene_dec_jurada=$registro["tiene_dec_jurada"]; $fecha_declaracion=$registro["fecha_declaracion"]; $monto_declaracion=$registro["monto_declaracion"];  $fecha_declaracion=formato_ddmmaaaa($fecha_declaracion);
  $tiene_lph=$registro["tiene_lph"]; $banco_lph=$registro["banco_lph"]; $cta_lph=$registro["cta_lph"]; $fecha_lph=$registro["fecha_lph"]; $fecha_des_lph=$registro["fecha_des_lph"]; $modif_lph=$registro["modif_lph"]; $fecha_lph=formato_ddmmaaaa($fecha_lph); $fecha_des_lph=formato_ddmmaaaa($fecha_des_lph);
  $fecha_fin_con=$registro["fecha_fin_con"]; $fecha_egreso=$registro["fecha_egreso"]; $motivo_egreso=$registro["motivo_egreso"]; $cont_fijo=$registro["cont_fijo"];  $fecha_fin_con=formato_ddmmaaaa($fecha_fin_con);  $fecha_egreso=formato_ddmmaaaa($fecha_egreso);
  $tipo_vacaciones=$registro["tipo_vacaciones"]; $pago_vaciones=$registro["pago_vaciones"]; $fecha_pago=$registro["fecha_pago"]; $cod_jerarquia=$registro["cod_jerarquia"]; $fecha_pago=formato_ddmmaaaa($fecha_pago);
  $codigo_ubicacion=$registro["codigo_ubicacion"]; $descripcion_ubi=$registro["descripcion_ubi"]; $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $rif_empleado=$registro["rif_empleado"];
  $apellido1=$registro["apellido1"];$apellido2=$registro["apellido2"]; $direccion=$registro["direccion"];$grado_inst=$registro["grado_inst"]; $profesion=$registro["profesion"]; $campo_str1=$registro["campo_str1"];
  $sexo=$registro["sexo"]; $edo_civil=$registro["edo_civil"]; $fecha_nacimiento=$registro["fecha_nacimiento"]; $edad=$registro["edad"];  $fecha_nacimiento=formato_ddmmaaaa($fecha_nacimiento);
  $lugar_nacimiento=$registro["lugar_nacimiento"]; $cod_postal=$registro["cod_postal"]; $telefono=$registro["telefono"];  $tlf_movil=$registro["tlf_movil"];  $correo=$registro["correo"];
  $estado=$registro["estado"]; $ciudad=$registro["ciudad"]; $municipio=$registro["municipio"]; $parroquia=$registro["parroquia"]; $aptdo_postal=$registro["aptdo_postal"];
  $observacion=$registro["observacion"]; $talla_camisa=$registro["talla_camisa"]; $talla_pantalon=$registro["talla_pantalon"]; $talla_calzado=$registro["talla_calzado"];  $campo_num1=$registro["campo_num1"];
  $sueldo=$registro["sueldo"]; $compensacion=$registro["compensacion"]; $cod_cargo=$registro["cod_cargo"];  $cod_departam=$registro["cod_departam"];
}
$sueldo=formato_monto($sueldo); $compensacion=formato_monto($compensacion); $des_cargo=""; $descripcion_dep="";  $otros=0;
$sql="Select * FROM NOM004 where codigo_cargo='$cod_cargo'"; $res=pg_query($sql); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res); $des_cargo=$registro["denominacion"];  }
$sql="Select * FROM NOM005 where codigo_departamento='$cod_departam'"; $res=pg_query($sql); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res); $descripcion_dep=$registro["descripcion_dep"];  }
$cod_prima1="003"; $des_prima1=""; $prima1=0; $cod_prima2="004"; $des_prima2=""; $prima2=0; $cod_prima3="005"; $des_prima3=""; $prima3=0;
$cod_prima4="006"; $des_prima4=""; $prima4=0; $cod_prima5=""; $des_prima5=""; $prima5=0; $cod_prima6=""; $des_prima6=""; $prima6=0;

$sql="SELECT * FROM CONCEPTOS_ASIGNADOS where cod_empleado='$cod_empleado' and cod_concepto='$cod_prima1'"; $res=pg_query($sql);
$filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res); $des_prima1=$registro["denominacion"];  $prima1=formato_monto($registro["monto"]); }

$sql="SELECT * FROM CONCEPTOS_ASIGNADOS where cod_empleado='$cod_empleado' and cod_concepto='$cod_prima2'"; $res=pg_query($sql);
$filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res); $des_prima2=$registro["denominacion"];  $prima2=formato_monto($registro["monto"]); }

$sql="SELECT * FROM CONCEPTOS_ASIGNADOS where cod_empleado='$cod_empleado' and cod_concepto='$cod_prima3'"; $res=pg_query($sql);
$filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res); $des_prima3=$registro["denominacion"];  $prima3=formato_monto($registro["monto"]); }

$sql="SELECT * FROM CONCEPTOS_ASIGNADOS where cod_empleado='$cod_empleado' and cod_concepto='$cod_prima4'"; $res=pg_query($sql);
$filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res); $des_prima4=$registro["denominacion"];  $prima4=formato_monto($registro["monto"]); }

$ubc_geografica="Estado Bolivariano de Miranda"; $lugar_pag="Los Teques"; $cod_ent_fed="1201"; $observacion=""; $elaborado_por=""; $fecha_elab=$fecha_hoy;
$revisado_por=""; $fecha_rev=$fecha_hoy; $autorizado_por=""; $fecha_auto=$fecha_hoy; $movimiento="INGRESO"; $horario1="08:00AM a 12:00PM"; $horario2="01:00PM a 04:00PM"; $hora_sem="35"; 


$temp_fecha=$fecha_mov; $mdia=substr($temp_fecha,0,2); $temp_fecha=operacion_mes($temp_fecha,-1); 

$fecha_desde=colocar_pdiames($temp_fecha);  $fecha_hasta=colocar_udiames($temp_fecha); 
$dfechan=formato_aaaammdd($fecha_desde); $hfechan=formato_aaaammdd($fecha_hasta); $hdia=substr($fecha_hasta,0,2); $ddia=substr($fecha_desde,0,2);

$conc1=0;  $conc2=0;  $conc3=0;  $conc4=0;  $conc5=0; 
$sqlb="select * FROM rpt_nom_hist WHERE (oculto<>'N') and (tipo_nomina='$tipo_nomina') and (cod_empleado='$cod_empleado') and (fecha_p_desde>='".$dfechan."') and (fecha_p_hasta<='".$hfechan."')"; $res=pg_query($sqlb);
while($registro=pg_fetch_array($res)){$cod_concepto=$registro["cod_concepto"];   $cantidad=$registro["cantidad"]; $monto=$registro["monto"]; $monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
	If ($cod_concepto==$cod_prima1){ $conc1=$conc1+$monto; }  	If ($cod_concepto==$cod_prima2){ $conc2=$conc2+$monto; }  
	If ($cod_concepto==$cod_prima3){ $conc3=$conc3+$monto; } 	If ($cod_concepto==$cod_prima4){ $conc4=$conc4+$monto; } 
}
if($conc1>0){ $prima1=$conc1; } if($conc2>0){ $prima2=$conc2; } if($conc3>0){ $prima3=$conc3; } if($conc4>0){ $prima4=$conc4; }
$prima1=formato_monto($prima1); $prima2=formato_monto($prima2); $prima3=formato_monto($prima3); $prima4=formato_monto($prima4);
?>
<form name="form2" method="post" action="/sia/nomina/rpt/Datos_forma_fp020.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	
	 <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>	 
     <td width="5"><input name="txtcod_empleado" type="hidden" id="txtcod_empleado" value="<?echo $cod_empleado?>" ></td>
	 <td width="5"><input name="txtfecha_mov" type="hidden" id="txtfecha_mov" value="<?echo $fecha_mov?>" ></td>
	 <td width="5"><input name="txtmov_nuevo" type="hidden" id="txtmov_nuevo" value="<?echo $mov_nuevo?>" ></td>
	 <td width="5"><input name="txtmovimiento" type="hidden" id="txtmovimiento" value="<?echo $movimiento?>" ></td>
	 
	 <td width="5"><input name="txthorario1" type="hidden" id="txthorario1" value="<?echo $horario1?>" ></td>
	 <td width="5"><input name="txthorario2" type="hidden" id="txthorario2" value="<?echo $horario2?>" ></td>
	 <td width="5"><input name="txthora_sem" type="hidden" id="txthora_sem" value="<?echo $hora_sem?>" ></td>
	 
	 
	 <td width="5"><input name="txtcedula" type="hidden" id="txtcedula" value="<?echo $cedula?>" ></td>
	 <td width="5"><input name="txtfecha_ingreso" type="hidden" id="txtfecha_ingreso" value="<?echo $fecha_ingreso?>" ></td>
	 <td width="5"><input name="txtnombre" type="hidden" id="txtnombre" value="<?echo $nombre?>" ></td>
	 <td width="5"><input name="txtnacionalidad" type="hidden" id="txtnacionalidad" value="<?echo $nacionalidad?>"></td>	 
	 <td width="5"><input name="txtfecha_nacimiento" type="hidden" id="txtfecha_nacimiento" value="<?echo $fecha_nacimiento?>" ></td>
	 <td width="5"><input name="txtedad" type="hidden" id="txtedad" value="<?echo $edad?>"></td>
	 <td width="5"><input name="txtsexo" type="hidden" id="txtsexo" value="<?echo $sexo?>"></td>
	 <td width="5"><input name="txtedo_civil" type="hidden" id="txtedo_civil" value="<?echo $edo_civil?>"></td>	 
	 <td width="5"><input name="txgrado_inst" type="hidden" id="txgrado_inst" value="<?echo $grado_inst?>"></td>
	 <td width="5"><input name="txtprofesion" type="hidden" id="txtprofesion" value="<?echo $profesion?>"></td>	 	 
	 <td width="5"><input name="txtdireccion" type="hidden" id="txtdireccion" value="<?echo $direccion?>"></td>	 
	 <td width="5"><input name="txtcod_cargo" type="hidden" id="txtcod_cargo" value="<?echo $cod_cargo?>"></td>
	 <td width="5"><input name="txtdes_cargo" type="hidden" id="txtdes_cargo" value="<?echo $des_cargo?>"></td>	
	 <td width="5"><input name="txtcod_departam" type="hidden" id="txtcod_departam" value="<?echo $cod_departam?>"></td>
	 <td width="5"><input name="txtdes_departam" type="hidden" id="txtdes_departam" value="<?echo $descripcion_dep?>"></td>	 
	 <td width="5"><input name="txtsueldo" type="hidden" id="txtsueldo" value="<?echo $sueldo?>"></td>
	 <td width="5"><input name="txtcompensacion" type="hidden" id="txtcompensacion" value="<?echo $compensacion?>"></td>
	 <td width="5"><input name="txtotros" type="hidden" id="txtotros" value="<?echo $otros?>"></td>	 
	 <td width="5"><input name="txtcod_prima1" type="hidden" id="txtcod_prima1" value="<?echo $cod_prima1?>"></td>
	 <td width="5"><input name="txtdes_prima1" type="hidden" id="txtdes_prima1" value="<?echo $des_prima1?>"></td>
	 <td width="5"><input name="txtprima1" type="hidden" id="txtprima1" value="<?echo $prima1?>"></td>	 
	 <td width="5"><input name="txtcod_prima2" type="hidden" id="txtcod_prima2" value="<?echo $cod_prima2?>"></td>
	 <td width="5"><input name="txtdes_prima2" type="hidden" id="txtdes_prima2" value="<?echo $des_prima2?>"></td>
	 <td width="5"><input name="txtprima2" type="hidden" id="txtprima2" value="<?echo $prima2?>"></td>	 
	 <td width="5"><input name="txtcod_prima3" type="hidden" id="txtcod_prima3" value="<?echo $cod_prima3?>"></td>
	 <td width="5"><input name="txtdes_prima3" type="hidden" id="txtdes_prima3" value="<?echo $des_prima3?>"></td>
	 <td width="5"><input name="txtprima3" type="hidden" id="txtprima3" value="<?echo $prima3?>"></td>	 
	 <td width="5"><input name="txtcod_prima4" type="hidden" id="txtcod_prima4" value="<?echo $cod_prima4?>"></td>
	 <td width="5"><input name="txtdes_prima4" type="hidden" id="txtdes_prima4" value="<?echo $des_prima4?>"></td>
	 <td width="5"><input name="txtprima4" type="hidden" id="txtprima4" value="<?echo $prima4?>"></td>	 
	 <td width="5"><input name="txtcod_prima5" type="hidden" id="txtcod_prima5" value="<?echo $cod_prima5?>"></td>
	 <td width="5"><input name="txtdes_prima5" type="hidden" id="txtdes_prima5" value="<?echo $des_prima5?>"></td>
	 <td width="5"><input name="txtprima5" type="hidden" id="txtprima5" value="<?echo $prima5?>"></td>	 
	 <td width="5"><input name="txtubc_geografica" type="hidden" id="txtubc_geografica" value="<?echo $ubc_geografica?>"></td>
	 <td width="5"><input name="txtlugar_pag" type="hidden" id="txtlugar_pag" value="<?echo $lugar_pag?>"></td>
	 <td width="5"><input name="txtcod_ent_fed" type="hidden" id="txtcod_ent_fed" value="<?echo $cod_ent_fed?>"></td>	 
	 <td width="5"><input name="txtobservacion" type="hidden" id="txtobservacion" value="<?echo $observacion?>"></td>	 
	 <td width="5"><input name="txtelaborado_por" type="hidden" id="txtelaborado_por" value="<?echo $elaborado_por?>"></td>
	 <td width="5"><input name="txtfecha_elab" type="hidden" id="txtfecha_elab" value="<?echo $fecha_elab?>"></td>	 
	 <td width="5"><input name="txtrevisado_por" type="hidden" id="txtrevisado_por" value="<?echo $revisado_por?>"></td>
	 <td width="5"><input name="txtfecha_rev" type="hidden" id="txtfecha_rev" value="<?echo $fecha_rev?>"></td>	 
	 <td width="5"><input name="txtautorizado_por" type="hidden" id="txtautorizado_por" value="<?echo $autorizado_por?>"></td>
	 <td width="5"><input name="txtfecha_auto" type="hidden" id="txtfecha_auto" value="<?echo $fecha_auto?>"></td>	 
  </tr>
</table>
</form>

<form name="form3" method="post" action="/sia/nomina/rpt/llama_mod_forma_fp020.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>	 
     <td width="5"><input name="txtcod_empleado" type="hidden" id="txtcod_empleado" value="<?echo $cod_empleado?>" ></td>	 
	 <td width="5"><input name="txtfecha_mov_n" type="hidden" id="txtfecha_mov_n" value="<?echo $fecha_mov_n?>" ></td>	 
  </tr>
</table>
</form>

</body>
</html>
<?pg_close();
/* */
if ($error==0){?><script language="JavaScript">Llamar_Inc_Calculo('<?echo $mov_nuevo?>');</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? }

?>