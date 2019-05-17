<?include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);

$nomb_firma="Ing. Yetzi Machado"; $cargo_firma="Director de Recursos Humanos (E)";
$ciudade="Barquisimeto"; $mesd="Enero"; $diad="01"; $anod="2012";
$cod_empleado=$_GET["cod_empleado"]; $tipo_sueldo=$_GET["tipo_sueldo"]; $fecha_emi=$_GET["fecha_emi"];   $fecha_desde=$_GET["fecha_desde"];    $fecha_hasta=$_GET["fecha_hasta"]; $observacion=$_GET["observacion"];
$diad=substr($fecha_emi,0,2); $mes_emi=substr($fecha_emi,3,2); $anod=substr($fecha_emi,6,4); 
if ($mes_emi=='01'){$mesd="Enero";}elseif ($mes_emi=='02'){$mesd="Febrero";}elseif ($mes_emi=='03'){$mesd="Marzo";}elseif ($mes_emi=='04'){$mesd="Abril";}elseif ($mes_emi=='05'){$mesd="Mayo";}elseif ($mes_emi=='06'){$mesd="Junio";}elseif ($mes_emi=='07'){$mesd="Julio";}elseif ($mes_emi=='08'){$mesd="Agosto";}elseif ($mes_emi=='09'){$mesd="Septiembre";}elseif ($mes_emi=='10'){$mesd="Octubre";}elseif ($mes_emi=='11'){$mesd="Noviembre";}elseif ($mes_emi=='12'){$mesd="Diciembre";}
$dfechan=formato_aaaammdd($fecha_desde); $hfechan=formato_aaaammdd($fecha_hasta);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  alert('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";}

$nombre=""; $nacionalidad=""; $descripcion=""; $cod_jerarquia=""; $codigo_ubicacion=""; $descripcion_ubi=""; $cedula=""; $rif_empleado=""; $descripcion_dep=""; $des_cargo="";
$tipo_nomina=""; $nacionalidad=""; $status=""; $fecha_ingreso=""; $fecha_ing_adm=""; $cod_categoria=""; $tipo_pago=""; $cta_empleado=""; $tipo_cuenta=""; $cod_banco=""; $nombre_banco=""; $cta_empresa=""; $calculo_grupos=""; $fecha_asigna_cargo=""; $cod_cargo=""; $cod_departam=""; $cod_tipo_personal=""; $paso=""; $grado=""; $sueldo=0; $prima=""; $compensacion=""; $otros=""; $sueldo_integral=""; $tipo_vacaciones="N"; $pago_vaciones="N"; $fecha_pago=""; $tiene_lph=""; $banco_lph=""; $cta_lph=""; $fecha_lph=""; $fecha_des_lph=""; $modif_lph=""; $tiene_dec_jurada=""; $fecha_declaracion=""; $monto_declaracion=""; $fecha_fin_con=""; $fecha_egreso=""; $motivo_egreso=""; $cont_fijo=""; $cod_cont_colec=""; $tipo_nom_ant=""; $cod_emp_ant=""; $fecha_camb_n=""; $motivo_camb_n=""; $tiene_aus_pro=""; $motivo_ausencia=""; $fecha_aus_desde=""; $fecha_aus_hasta="";  $motivo_suplen=""; $cedula_titular="";
$nombre1=""; $nombre2=""; $apellido1=""; $apellido2=""; $sexo=""; $edo_civil=""; $fecha_nacimiento=""; $edad=""; $lugar_nacimiento=""; $direccion=""; $cod_postal=""; $telefono=""; $tlf_movil=""; $correo=""; $profesion=""; $grado_inst=""; $tiempo_e=""; $poliza=""; $fecha_seguro=""; $estado=""; $ciudad=""; $municipio=""; $parroquia=""; $observacion=""; $talla_camisa=""; $talla_pantalon=""; $talla_calzado=""; $peso=""; $estatura=""; $aptdo_postal=""; 
$sql="Select * from TRABAJADORES where cod_empleado='$cod_empleado'"; $res=pg_query($sql); $filas=pg_num_rows($res); $error=0;
if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $cedula=$registro["cedula"]; $nacionalidad=$registro["nacionalidad"]; $nombre=$registro["nombre"];   $status=$registro["status"];
  $fecha_ingreso=$registro["fecha_ingreso"]; $fecha_ing_adm=$registro["fecha_ing_adm"]; $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);  $fecha_ing_adm=formato_ddmmaaaa($fecha_ing_adm); $cod_cargo=$registro["cod_cargo"]; $cod_departam=$registro["cod_departam"];
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
  $sueldo=$registro["sueldo"]; $prima=$registro["prima"]; $compensacion=$registro["compensacion"]; $otros=$registro["otros"]; $sueldo_integral=$registro["sueldo_integral"];
} else { $error=1; ?> <script language="JavaScript">  alert('CODIGO DE TRABAJADOR NO LOCALIZADO'); </script>   <?}

if($error==0){ $con_sue_bas=""; $con_compen=""; $con_sue_int=""; $con_sue_tot=""; 
  $sql="Select * from NOM001 where tipo_nomina='$tipo_nomina'";  $res=pg_query($sql); $filas=pg_num_rows($res);
  if($filas>=1){ $registro=pg_fetch_array($res,0); $con_sue_bas=$registro["con_sue_bas"]; $con_compen=$registro["con_compen"]; 
   $con_sue_int=$registro["con_sue_int"]; $con_sue_tot=$registro["con_sue_tot"]; }   
  $sql="SELECT * FROM NOM005 where codigo_departamento='$cod_departam'";  $res=pg_query($sql); $filas=pg_num_rows($res);
  if($filas>=1){ $registro=pg_fetch_array($res,0); $descripcion_dep=$registro["descripcion_dep"]; }  
  $sql="SELECT * FROM NOM004 where codigo_cargo='$cod_cargo'";  $res=pg_query($sql); $filas=pg_num_rows($res);
  if($filas>=1){ $registro=pg_fetch_array($res,0); $des_cargo=$registro["denominacion"]; }
$sueldo_basico=formato_monto($sueldo);  $sueldo_int=formato_monto($sueldo_integral);  //$sueldo_int=formato_monto($sueldo_integral*30);
$ciudadano="el ciudadano"; $cantidad_letra=monto_letras($sueldo_basico);
if($sexo=="MASCULINO"){$ciudadano="el ciudadano ";}else{$ciudadano="la ciudadana ";}
$texto="";
$texto1="     El suscrito, Director de Recursos Humanos (E) de SISTEMA HIDRAÚLICO YACAMBÚ QUIBOR C.A., por medio de la presente se hace constar que ".$ciudadano.$nombre.", titular de la Cédula de Identidad No. ".$cedula.", presta sus servicios en esta empresa desde el ".$fecha_ingreso.", desempeñandose en el cargo de ".$des_cargo.",  adscrito a la Unidad de ".$descripcion_dep.", devengando un sueldo básico mensual de ".$cantidad_letra." (Bs.".$sueldo_basico.").";
if($tipo_sueldo=="SUELDO INTEGRAL"){ $sueldo_integral=0;
if($sueldo_integral==0){  $sql= "SELECT cod_empleado,monto FROM NOM018 Where (cod_empleado='$cod_empleado') and (cod_concepto='$con_sue_int') and (fecha_nomina>='$dfechan') and (fecha_nomina<='$hfechan') order by fecha_nomina desc"; $res=pg_query($sql);  $filas=pg_num_rows($res);
 if($filas>=1){ $registro=pg_fetch_array($res,0); $sueldo_integral=$registro["monto"]; }  $sueldo_int=formato_monto($sueldo_integral);
} 
$cantidad_letra=monto_letras($sueldo_int);
$texto1="     El suscrito, Director de Recursos Humanos (E) de SISTEMA HIDRAÚLICO YACAMBÚ; QUIBOR C.A., por medio de la presente se hace constar que ".$ciudadano.$nombre.", titular de la Cédula de Identidad No. ".$cedula.", presta sus servicios en esta empresa desde el ".$fecha_ingreso.", desempeñandose en el cargo de ".$des_cargo.", adscrito a la Unidad de ".$descripcion_dep.", devengando un sueldo integral mensual de ".$cantidad_letra." (Bs.".$sueldo_int.").";
}
if($tipo_sueldo=="SUELDO BASICO PROMEDIO"){ $sueldop=0; $cant_m=0;
$sql= "SELECT cod_empleado,monto FROM NOM018 Where (cod_empleado='$cod_empleado') and (cod_concepto='$con_sue_bas') and (fecha_nomina>='$dfechan') and (fecha_nomina<='$hfechan') order by fecha_nomina"; $res=pg_query($sql);  
while($registro=pg_fetch_array($res)){ $monto=$registro["monto"]; $sueldop=$sueldop+$monto; $cant_m=$cant_m+1; }
if(($sueldop<>0)and($cant_m<>0)){ $sueldop=$sueldop/$cant_m; }  
$sueldo_prom=formato_monto($sueldop); $cantidad_letra=monto_letras($sueldo_prom);
$texto1="     El suscrito, Director de Recursos Humanos (E) de SISTEMA HIDRAÚLICO YACAMBÚ QUIBOR C.A., por medio de la presente se hace constar que ".$ciudadano.$nombre.", titular de la Cédula de Identidad No. ".$cedula.", presta sus servicios en esta empresa desde el ".$fecha_ingreso.", desempeñandose en el cargo de ".$des_cargo.",  adscrito a la Unidad de  ".$descripcion_dep.", devengando un sueldo basico promedio de ".$cantidad_letra." (Bs.".$sueldo_prom.").";
										        
}
if($tipo_sueldo=="SUELDO INTEGRAL PROMEDIO"){ $sueldop=0; $cant_m=0;
$sql= "SELECT cod_empleado,monto FROM NOM018 Where (cod_empleado='$cod_empleado') and (cod_concepto='$con_sue_int') and (fecha_nomina>='$dfechan') and (fecha_nomina<='$hfechan') order by fecha_nomina"; $res=pg_query($sql);  
while($registro=pg_fetch_array($res)){ $monto=$registro["monto"]; $sueldop=$sueldop+$monto; $cant_m=$cant_m+1; }
if(($sueldop<>0)and($cant_m<>0)){ $sueldop=$sueldop/$cant_m; }  
$sueldo_prom=formato_monto($sueldop); $cantidad_letra=monto_letras($sueldo_prom);
$texto1="     El suscrito, Director de Recursos Humanos (E) de SISTEMA HIDRAÚLICO YACAMBÚ QUIBOR C.A., por medio de la presente se hace constar que ".$ciudadano.$nombre.", titular de la Cédula de Identidad No. ".$cedula.", presta sus servicios en esta empresa desde el ".$fecha_ingreso.", desempeñandose en el cargo de ".$des_cargo.",  adscrito a la Unidad de ".$descripcion_dep.", devengando un sueldo integral promedio de ".$cantidad_letra." (Bs.".$sueldo_prom.").";
}
$texto2="     Constancia que se expide a petición de la parte interesada en ".$ciudade." a los ".$diad." días del mes de ".$mesd." del Año ".$anod;
}

if($error==0){ require('../../class/fpdf/fpdf.php');
    class PDF extends FPDF{
		function Header(){ global $Nom_Emp;
			$this->SetFont('Arial','B',12);
			$this->Ln(7);
			$this->SetFont('Arial','B',12);
			$this->Cell(86);
			$this->Cell(28,4,'CONSTANCIA','B',1,'C');
			$this->Ln(10);
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	}	  
	$pdf=new PDF('P', 'mm', Letter);
	$pdf->AliasNbPages();
   	$pdf->AddPage();
	$pdf->SetFont('Arial','',10);
	
		
	$pdf->Cell(20);
	$pdf->MultiCell(160,4,$texto1,0); 
	$pdf->Ln(5);
	$pdf->Cell(20);
	$pdf->MultiCell(160,4,$texto2,0); 
	if($observacion<>""){$pdf->Ln(5); $pdf->MultiCell(160,4,$observacion,0); }
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',9);

	$pdf->Ln(10);
	$pdf->Cell(200,4,$nomb_firma,0,1,'C');
       $pdf->Cell(200,4,$cargo_firma,0,1,'C');	
	$pdf->Cell(200,4,'YM/MYS',0,1,'L');
	$pdf->Output();

}
}

?>