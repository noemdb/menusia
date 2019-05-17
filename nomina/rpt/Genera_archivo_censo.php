<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist="S";  $fecha_desde=$_GET["fecha_desde"]; $fecha_hasta=$_GET["fecha_hasta"]; $fecha_nom=$_GET["fecha_hasta"];    
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $tipo_concepto=$_GET["tipo_concepto"]; $tipo_personal_d=$_GET["tipo_personal_d"];   $tipo_personal_h=$_GET["tipo_personal_h"]; 
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"]; $forma_pago=$_GET["forma_pago"];
   
   $cod_empleado_d=$_GET["cod_empleado_d"]; $cod_empleado_h=$_GET["cod_empleado_h"];
   
   $tipo_rpt="EXCEL"; $esp_firma="SI"; $salto_dep="NO"; $tipo_reporte='N'; $act_hist="N"; 
   $ordenar="  order by tipo_nomina, cod_departam,  cod_empleado, cod_concepto, fecha_p_hasta";
   $mes_desde=substr($fecha_desde,3,2); $mes_hasta=substr($fecha_hasta,3,2); $mano=substr($fecha_hasta,6,4); 
   $cfechan=formato_aaaammdd($fecha_hasta);       $dfechan=formato_aaaammdd($fecha_desde); $hfechan=formato_aaaammdd($fecha_hasta);   
if ($mes_desde=='01'){$mesd="Enero";}elseif ($mes_desde=='02'){$mesd="Febrero";}elseif ($mes_desde=='03'){$mesd="Marzo";}elseif ($mes_desde=='04'){$mesd="Abril";}elseif ($mes_desde=='05'){$mesd="Mayo";}elseif ($mes_desde=='06'){$mesd="Junio";}elseif ($mes_desde=='07'){$mesd="Julio";}elseif ($mes_desde=='08'){$mesd="Agosto";}elseif ($mes_desde=='09'){$mesd="Septiembre";}elseif ($mes_desde=='10'){$mesd="Octubre";}elseif ($mes_desde=='11'){$mesd="Noviembre";}elseif ($mes_desde=='12'){$mesd="Diciembre";}
if ($mes_hasta=='01'){$mesh="Enero";}elseif ($mes_hasta=='02'){$mesh="Febrero";}elseif ($mes_hasta=='03'){$mesh="Marzo";}elseif ($mes_hasta=='04'){$mesh="Abril";}elseif ($mes_hasta=='05'){$mesh="Mayo";}elseif ($mes_hasta=='06'){$mesh="Junio";}elseif ($mes_hasta=='07'){$mesh="Julio";}elseif ($mes_hasta=='08'){$mesh="Agosto";}elseif ($mes_hasta=='09'){$mesh="Septiembre";}elseif ($mes_hasta=='10'){$mesh="Octubre";}elseif ($mes_hasta=='11'){$mesh="Noviembre";}elseif ($mes_hasta=='12'){$mesh="Diciembre";}
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{  $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";} 
   if($tipo_calculo=="T"){ $cri_tp=" and ((tp_calculo='N')or(tp_calculo='E'))  "; } else { $cri_tp=" and (tp_calculo='".$tipo_calculo."') "; }   
   $cfechan=formato_aaaammdd($fecha_nom);  $Sql="";   $date = date("d-m-Y");   $hora = date("H:i:s a");
   $criterio="rpt_nom_cal WHERE (oculto<>'NN') ";   
   $sql="select fecha_p_hasta from nom017 where (fecha_p_hasta='".$cfechan."') and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') ".$cri_tp;
   $res=pg_query($sql); $filas=pg_num_rows($res); if($filas==0){$act_hist="S";  }   
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_desde>='".$dfechan."') and (fecha_p_hasta<='".$hfechan."')  ";} 
   if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}   
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and ((concepto_vac='N') or (cod_concepto='VVV'))";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and ((concepto_vac='S') and (cod_concepto<>'VVV')) ";}  
   
   $criterio=$criterio.$cri_tp;
   $criterio=$criterio."  and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."')";
   $criterio1="Mes : ".$mesh." Año: ".$mano;  
   $criterio1="FECHA : ".$fecha_desde." AL ".$fecha_hasta;
   $criterio3="";
   if($tipo_nomina_d<>$tipo_nomina_h){ 
	  $sql="SELECT tipo_nomina,descripcion,desc_grupo from nom001 where tipo_nomina='$tipo_nomina_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$criterio3=$registro["desc_grupo"];}
   }
   $sSQL = "SELECT *  FROM ".$criterio."  and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and
	  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_concepto>='".$cod_conceptod."' AND cod_concepto<='".$cod_conceptoh."')  and
	  (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."') and (cod_tipo_personal>='".$tipo_personal_d."' and cod_tipo_personal<='".$tipo_personal_h."') ".$ordenar;
  
      $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre=""; $prev_cedula=""; $prev_cod_empleado=""; $prev_cod_cat="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"];  $nombre=$registro["nombre"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];  	$cedula=$registro["cedula"];	$cod_categ=$registro["cod_categ"];	
		$status_calculo=$registro["status_calculo"]; $fecha_p_hasta=$registro["fecha_p_hasta"]; $fecha_ing=$registro["fecha_ingreso"]; $fecha_ingreso=formato_ddmmaaaa($fecha_ing);
		$nombre1=$nombre; $nombre2=""; $apellido1=""; $apellido2=""; $nacionalidad=substr($status_calculo,1,1); $sexo=substr($status_calculo,3,1);		
		$StrSQL6="SELECT * From TRABAJADORES Where (cod_empleado='$cod_empleado')";$result6=pg_query($StrSQL6);
		if($registro6=pg_fetch_array($result6,0)){ $fecha_nac=$registro6["fecha_nacimiento"]; $nacionalidad=$registro6["nacionalidad"]; $nacionalidad=substr($nacionalidad,0,1); $sexo=$registro6["sexo"]; $tipo_cuenta=$registro6["tipo_cuenta"]; $edo_civil=$registro6["edo_civil"];
		 $nombre1=$registro6["nombre1"]; $nombre2=$registro6["nombre2"]; $apellido1=$registro6["apellido1"]; $apellido2=$registro6["apellido2"]; $edad=$registro6["edad"];  $fecha_ing_adm=$registro6["fecha_ing_adm"]; $paso=$registro6["paso"]; $grado=$registro6["grado"]; }

		//if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		 $denominacion=conv_cadenas($denominacion,0);  $nombre1=conv_cadenas($nombre1,0); $nombre2=conv_cadenas($nombre2,0); $apellido1=conv_cadenas($apellido1,0); $apellido2=conv_cadenas($apellido2,0);
		$prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $prev_cedula=$cedula;
		$prev_cod_empleado=$cod_empleado; $prev_cod_cat=$cod_categ;
		
		$periodof=Calcula_dif_fechas($fecha_ingreso,$fecha_hasta);     $ant_ano=substr($periodof,0,4); $ant_mes=substr($periodof,4,2); $ant_dia=substr($periodof,6,2);
		
		$tantiguendad=$ant_ano."-".$ant_mes."-".$ant_dia;
	  }	  
	  
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Reporte_censo.xls"); 	
	  ?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="100" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE ARCHIVO PLANO PARA EL CENCSO</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong><? echo $criterio1; ?></strong></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		   <td width="100" height="60" align="left" bgcolor="#99CCFF"><strong>NACIONALIDAD</strong></td>
		   <td width="100" align="left" bgcolor="#99CCFF"><strong>CEDULA</strong></td>
		   <td width="300" align="left" bgcolor="#99CCFF"><strong>APELLIDO 1</strong></td>
		   <td width="300" align="left" bgcolor="#99CCFF"><strong>APELIDO 2</strong></td>
		   <td width="300" align="left" bgcolor="#99CCFF"><strong>NOMBRE 1</strong></td>
		   <td width="300" align="left" bgcolor="#99CCFF"><strong>NOMBRE 2</strong></td>		   
		   <td width="100" align="left" bgcolor="#99CCFF"><strong>SEXO</strong></td>
		   <td width="100" align="left" bgcolor="#99CCFF"><strong>ANTIGUEDAD</strong></td>		   
		   <td width="100" align="left" bgcolor="#99CCFF"><strong>FECHA INGRESO</strong></td>
		   <td width="100" align="left" bgcolor="#99CCFF"><strong>CODIGO NOMINA</strong></td>
		   <td width="200" align="left" bgcolor="#99CCFF"><strong>CARGO</strong></td>   
		   <td width="100" align="center" bgcolor="#99CCFF"><strong>TIPO DE PERSONAL</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF"><strong>CATEGORIA DEL PERSONAL</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF"><strong>FECHA CORTE</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF"><strong>SUELDO BASE</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF"><strong>PRIMA DE PROFESIONALIZACION</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF"><strong>PRIMA DE ANTIGUEDAD</strong></td>
		 </tr>
      
	  <? 
	$i=0; $can_conc=0; $cant_emp=0;  
	  $tot1=0; $tot2=0; $tot3=0; $tot4=0; $tot5=0;  $tot6=0; $tot7=0; $tot8=0; $tot9=0; $tot10=0; 
	  $conc1=0; $conc2=0; $conc3=0; $conc4=0; $conc5=0; $conc6=0; $conc7=0; $conc8=0; $conc9=0; 
	  $sub_tot1=0; $sub_tot2=0; $sub_tot3=0; $sub_tot4=0; $sub_tot5=0;  $sub_tot6=0; $sub_tot7=0;
	  $desc_con1=""; $desc_con2=""; $desc_con3=""; $desc_con4=""; $desc_con5=""; $desc_con6=""; $desc_con7=""; $desc_con8="";
	  //echo $sSQL;
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_emp=$registro["cod_empleado"]; $tipo_nom=$registro["tipo_nomina"];	$cod_cat=$registro["cod_categ"];	
	    $cod_dep=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
		if($prev_cod_empleado<>$cod_emp){ $cant_emp=$cant_emp+1;
		    $tot1=$tot1+$conc1; $tot2=$tot2+$conc2; $tot3=$tot3+$conc3; $tot4=$tot4+$conc4; $tot5=$tot5+$conc5; $tot6=$tot6+$conc6; $tot7=$tot7+$conc7; 
			$sub_tot1=$sub_tot1+$conc1; $sub_tot2=$sub_tot2+$conc2; $sub_tot3=$sub_tot3+$conc3; $sub_tot4=$sub_tot4+$conc4; $sub_tot5=$sub_tot5+$conc5; $sub_tot6=$sub_tot6+$conc6;  $sub_tot7=$sub_tot7+$conc7; 
			$conc1=formato_monto($conc1); $conc2=formato_monto($conc2); $conc3=formato_monto($conc3); $conc4=formato_monto($conc4); $conc5=formato_monto($conc5);
			$conc6=formato_monto($conc6); $conc7=formato_monto($conc7); $sueldoc=formato_monto($sueldoc); $temp="";			
			?>
		      <tr>
			      <td width="100" align="left"><? echo $nacionalidad; ?></td>	
				  <td width="100" align="left" style="mso-number-format:'@';" ><? echo $cedula; ?></td>
				  <td width="300" align="left"><? echo $apellido1; ?></td>	
				  <td width="300" align="left"><? echo $apellido2; ?></td>
				  <td width="300" align="left"><? echo $nombre1; ?></td>
				  <td width="300" align="left"><? echo $nombre2; ?></td>
				  <td width="100" align="left"><? echo $sexo; ?></td>	
				  <td width="100" align="left" style="mso-number-format:'@';"><? echo $tantiguendad; ?></td>	
				  <td width="100" align="left"><? echo $fecha_ingreso; ?></td>
                  <td width="100" align="left" style="mso-number-format:'@';"><? echo $tipo_nomina; ?></td>
                  <td width="200" align="left"><? echo $des_cargo; ?></td>					  
                  <td width="100" align="left"><? echo $temp; ?></td>
                  <td width="100" align="left"><? echo $temp; ?></td>
				  <td width="100" align="left"><? echo $fecha_hasta; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc1; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc2; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc3; ?></td>
				  <td width="100" align="left"><? echo $desc_con4; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc4; ?></td>
				  <td width="100" align="left"><? echo $desc_con5; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc5; ?></td>
				  <td width="100" align="left"><? echo $desc_con6; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc6; ?></td>
				  <td width="100" align="left"><? echo $desc_con7; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc7; ?></td>
				  <td width="100" align="left"><? echo $desc_con8; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc8; ?></td>
			  </tr>
		    <? 
			$prev_cod_empleado=$cod_emp; $conc1=0; $conc2=0; $conc3=0; $conc4=0; $conc5=0; $conc6=0; $conc7=0; $conc8=0;	$desc_con1=""; $desc_con2=""; $desc_con3=""; $desc_con4=""; $desc_con5=""; $desc_con6="";	$desc_con7="";	$desc_con8="";
		}
		$tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"]; $monto=$registro["monto"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_deduccion"]; $monto_deduccion=$registro["monto_aporte"];
		$status_calculo=$registro["status_calculo"]; $fecha_p_hasta=$registro["fecha_p_hasta"]; $fecha_ing=$registro["fecha_ingreso"]; $fecha_ingreso=formato_ddmmaaaa($fecha_ing);
		$nombre1=$nombre; $nombre2=""; $apellido1=""; $apellido2=""; $nacionalidad=substr($status_calculo,1,1); $sexo=substr($status_calculo,3,1);		
		$StrSQL6="SELECT * From TRABAJADORES Where (cod_empleado='$cod_empleado')";$result6=pg_query($StrSQL6);
		if($registro6=pg_fetch_array($result6,0)){ $fecha_nac=$registro6["fecha_nacimiento"]; $nacionalidad=$registro6["nacionalidad"]; $nacionalidad=substr($nacionalidad,0,1); $sexo=$registro6["sexo"]; $tipo_cuenta=$registro6["tipo_cuenta"]; $edo_civil=$registro6["edo_civil"];
		 $nombre1=$registro6["nombre1"]; $nombre2=$registro6["nombre2"]; $apellido1=$registro6["apellido1"]; $apellido2=$registro6["apellido2"]; $edad=$registro6["edad"];  $fecha_ing_adm=$registro6["fecha_ing_adm"]; $paso=$registro6["paso"]; $grado=$registro6["grado"]; }
        //if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_cargo=utf8_decode($des_cargo); $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		 $denominacion=conv_cadenas($denominacion,0); $nombre1=conv_cadenas($nombre1,0); $nombre2=conv_cadenas($nombre2,0); $apellido1=conv_cadenas($apellido1,0); $apellido2=conv_cadenas($apellido2,0);
		if($cod_concepto=="001") { $desc_con1=$denominacion; $conc1=$conc1+($monto/2); }
		if($cod_concepto=="094") { $desc_con2=$denominacion; $conc2=$conc2+$monto; }
		if($cod_concepto=="095") { $desc_con3=$denominacion; $conc3=$conc3+$monto; }
		if($cod_concepto=="010") { $desc_con4=$denominacion; $conc4=$conc4+$monto; }
		if($cod_concepto=="012") { $desc_con5=$denominacion; $conc5=$conc5+$monto; }
		if($cod_concepto=="050") { $desc_con6=$denominacion; $conc6=$conc6+$monto; }
		if($cod_concepto=="184") { $desc_con7=$denominacion; $conc7=$conc7+$monto; }
        if($cod_concepto=="307") { $desc_con8=$denominacion; $conc8=$conc8+$monto; }		
		$periodof=Calcula_dif_fechas($fecha_ingreso,$fecha_hasta);     $ant_ano=substr($periodof,0,4); $ant_mes=substr($periodof,4,2); $ant_dia=substr($periodof,6,2);
	    $tantiguendad=$ant_ano."-".$ant_mes."-".$ant_dia;		
	  }		
	  $tot1=$tot1+$conc1; $tot2=$tot2+$conc2; $tot3=$tot3+$conc3; $tot4=$tot4+$conc4; $tot5=$tot5+$conc5; $cant_emp=$cant_emp+1;
			$sub_tot1=$sub_tot1+$conc1; $sub_tot2=$sub_tot2+$conc2; $sub_tot3=$sub_tot3+$conc3; $sub_tot4=$sub_tot4+$conc4; $sub_tot5=$sub_tot5+$conc5; 
			$conc1=formato_monto($conc1); $conc2=formato_monto($conc2); $conc3=formato_monto($conc3); $conc4=formato_monto($conc4); $conc5=formato_monto($conc5);
			?>
		      <tr>
				  <td width="100" align="left"><? echo $nacionalidad; ?></td>	
				  <td width="100" align="left" style="mso-number-format:'@';" ><? echo $cedula; ?></td>
				  <td width="300" align="left"><? echo $apellido1; ?></td>	
				  <td width="300" align="left"><? echo $apellido2; ?></td>
				  <td width="300" align="left"><? echo $nombre1; ?></td>
				  <td width="300" align="left"><? echo $nombre2; ?></td>
				  <td width="100" align="left"><? echo $sexo; ?></td>	
				  <td width="100" align="left"><? echo $tantiguendad; ?></td>	
				  <td width="100" align="left"><? echo $fecha_ingreso; ?></td>
                  <td width="100" align="left" style="mso-number-format:'@';"><? echo $tipo_nomina; ?></td>
                  <td width="200" align="left"><? echo $des_cargo; ?></td>					  
                  <td width="100" align="left"><? echo $temp; ?></td>
                  <td width="100" align="left"><? echo $temp; ?></td>
				  <td width="100" align="left"><? echo $fecha_hasta; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc1; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc2; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc3; ?></td>				  
				  <td width="100" align="left"><? echo $desc_con4; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc4; ?></td>
				  <td width="100" align="left"><? echo $desc_con5; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc5; ?></td>
				  <td width="100" align="left"><? echo $desc_con6; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc6; ?></td>
				  <td width="100" align="left"><? echo $desc_con7; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc7; ?></td>
				  <td width="100" align="left"><? echo $desc_con8; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc8; ?></td>
				 
			  </tr>
		    <? ;  
			$prev_cod_empleado=$cod_emp;
			$conc1=0; $conc2=0; $conc3=0; $conc4=0; $conc5=0; $conc6=0; $conc7=0; $conc8=0;
		$tot1=formato_monto($tot1); $tot2=formato_monto($tot2); $tot3=formato_monto($tot3); $tot4=formato_monto($tot4); $tot5=formato_monto($tot5);
		
}
?>

