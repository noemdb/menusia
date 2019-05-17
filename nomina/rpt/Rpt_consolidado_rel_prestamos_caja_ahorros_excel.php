<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist="S";  $fecha_desde=$_GET["fecha_desde"]; $fecha_hasta=$_GET["fecha_hasta"]; $fecha_nom=$_GET["fecha_hasta"];    
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $tipo_concepto=$_GET["tipo_concepto"]; $tipo_personal_d=$_GET["tipo_personal_d"];   $tipo_personal_h=$_GET["tipo_personal_h"]; 
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"]; $forma_pago=$_GET["forma_pago"];
   $tipo_rpt="PDF"; $esp_firma="SI"; $salto_dep="NO"; $tipo_reporte='N'; $act_hist="N"; 
   $ordenar="  order by tipo_nomina, cod_departam,  cod_cargo, cod_empleado, cod_concepto";
   $mes_desde=substr($fecha_desde,3,2); $mes_hasta=substr($fecha_hasta,3,2); $mano=substr($fecha_hasta,6,4); 
   $cfechan=formato_aaaammdd($fecha_hasta);       $dfechan=formato_aaaammdd($fecha_desde); $hfechan=formato_aaaammdd($fecha_hasta);   
if ($mes_desde=='01'){$mesd="Enero";}elseif ($mes_desde=='02'){$mesd="Febrero";}elseif ($mes_desde=='03'){$mesd="Marzo";}elseif ($mes_desde=='04'){$mesd="Abril";}elseif ($mes_desde=='05'){$mesd="Mayo";}elseif ($mes_desde=='06'){$mesd="Junio";}elseif ($mes_desde=='07'){$mesd="Julio";}elseif ($mes_desde=='08'){$mesd="Agosto";}elseif ($mes_desde=='09'){$mesd="Septiembre";}elseif ($mes_desde=='10'){$mesd="Octubre";}elseif ($mes_desde=='11'){$mesd="Noviembre";}elseif ($mes_desde=='12'){$mesd="Diciembre";}
if ($mes_hasta=='01'){$mesh="Enero";}elseif ($mes_hasta=='02'){$mesh="Febrero";}elseif ($mes_hasta=='03'){$mesh="Marzo";}elseif ($mes_hasta=='04'){$mesh="Abril";}elseif ($mes_hasta=='05'){$mesh="Mayo";}elseif ($mes_hasta=='06'){$mesh="Junio";}elseif ($mes_hasta=='07'){$mesh="Julio";}elseif ($mes_hasta=='08'){$mesh="Agosto";}elseif ($mes_hasta=='09'){$mesh="Septiembre";}elseif ($mes_hasta=='10'){$mesh="Octubre";}elseif ($mes_hasta=='11'){$mesh="Noviembre";}elseif ($mes_hasta=='12'){$mesh="Diciembre";}
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS'); </script> <?}
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
   $criterio=$criterio." and (cod_concepto>='510' and cod_concepto<='950')";
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
        if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		$prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $prev_cedula=$cedula;
		$prev_cod_empleado=$cod_empleado; $prev_cod_cat=$cod_categ;
	  }	  
	  
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Reporte_seniat.xls"); 	
	  ?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RELACION DE PRESTAMOS CAJA DE AHORROS</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <?if($tipo_nomina_d==$tipo_nomina_h){ ?>
		 <tr height="20">
		    <td width="100" align="left" ><strong>Nomina: </strong></td>
		    <td width="400" align="left" ><strong><? echo $tipo_nomina."    ".$des_nomina; ?></strong></td>
		 </tr>
		 <?}else{ ?>
		  <tr height="20">
		     <td width="100" align="left" ><strong></strong></td>
		     <td width="400" align="left" ><strong><? echo $criterio3; ?></strong></td>
		 </tr>
		 <?} ?>
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="left" ><strong><? echo $criterio1; ?></strong></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		  <td width="100" height="40"  align="left" bgcolor="#A4A4A4"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CEDULA</strong></td>
		   <td width="400" align="left" bgcolor="#A4A4A4"><strong>NOMBRE TRABAJADOR</strong></td>
		   <td width="100" align="left" bgcolor="#A4A4A4"><strong>FECHA INGRESO</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>APORTE EMPLEADO</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>APORTE EMPRESA</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>PRESTAMO C.P.</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>PRESTAMO M.P.</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>PRESTAMO L.P.</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>ESPECIAL</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>AVALADO POR SALUD</strong></td>		   
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>REFINAN.</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>FONDO FUNERA</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>L.P. AFZADO</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>ESPECIAL AFZADO</strong></td>		   
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>MONTEPIO</strong></td>	
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>TOTAL A PAGAR</strong></td>
		 </tr>      
	  <? 
	  
      
	  $i=0; $can_conc=0; $cant_emp=0;  
	  $tot1=0; $tot2=0; $tot3=0; $tot4=0; $tot5=0;  $tot6=0; $tot7=0; $tot8=0; $tot9=0; $tot10=0; $tot11=0; $tot12=0; $tot13=0; $tot14=0; $tot15=0;
	  $conc1=0; $conc2=0; $conc3=0; $conc4=0; $conc5=0; $conc6=0; $conc7=0; $conc8=0; $conc9=0; $conc10=0; $conc11=0; $conc12=0; $conc13=0; $conc14=0; $conc15=0;
	  //$pdf->MultiCell(200,3,$sSQL,0); 
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_emp=$registro["cod_empleado"]; $tipo_nom=$registro["tipo_nomina"];	$cod_cat=$registro["cod_categ"];	
		if($prev_cod_empleado<>$cod_emp){ $cant_emp=$cant_emp+1;
		    $tot1=$tot1+$conc1; $tot2=$tot2+$conc2; $tot3=$tot3+$conc3; $tot4=$tot4+$conc4; $tot5=$tot5+$conc5; $tot6=$tot6+$conc6; $tot7=$tot7+$conc7; $tot8=$tot8+$conc8; $tot9=$tot9+$conc9; 
			$tot10=$tot10+$conc10; $tot11=$tot11+$conc11; $tot12=$tot12+$conc12; $tot13=$tot13+$conc13; $tot14=$tot14+$conc14; $tot15=$tot15+$conc15; 
			$conc1=formato_monto($conc1); $conc2=formato_monto($conc2); $conc3=formato_monto($conc3); $conc4=formato_monto($conc4); $conc5=formato_monto($conc5);
			$conc6=formato_monto($conc6); $conc7=formato_monto($conc7); $conc8=formato_monto($conc8); $conc9=formato_monto($conc9); $conc10=formato_monto($conc10);
		    $conc11=formato_monto($conc11); $conc12=formato_monto($conc12); $conc13=formato_monto($conc13);
			
			?>
		      <tr>
				  <td width="100" align="left" style="mso-number-format:'@';" ><? echo $cedula; ?></td>
				  <td width="400" align="left"><? echo $nombre; ?></td>	
                  <td width="100" align="left"><? echo $fechai; ?></td>	                     				  
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc1; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc2; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc3; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc4; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc5; ?></td>				  
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc6; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc7; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc8; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc9; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc10; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc11; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc12; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc13; ?></td>
			  </tr>
		    <? 
			$prev_cod_empleado=$cod_emp;
			$conc1=0; $conc2=0; $conc3=0; $conc4=0; $conc5=0; $conc6=0; $conc7=0; $conc8=0; $conc9=0; $conc10=0; $conc11=0; $conc12=0; $conc13=0; $conc14=0; $conc15=0;			
		}
		$tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"]; $monto=$registro["monto"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_deduccion"]; $monto_deduccion=$registro["monto_aporte"];
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		$mdia=substr($fechah,0,2);
		
		if(($cod_concepto=="510")or($cod_concepto=="560")) { $conc1=$conc1+$monto; }
		if($cod_concepto=="950") { $conc2=$conc2+$monto; }
		if($cod_concepto=="542") { $conc3=$conc3+$monto; }
	    if($cod_concepto=="544") { $conc4=$conc4+$monto; }
	    if($cod_concepto=="546") { $conc5=$conc5+$monto; }
	    if($cod_concepto=="548") { $conc6=$conc6+$monto; }
	    if($cod_concepto=="550") { $conc7=$conc7+$monto; }		   
	    if($cod_concepto=="552") { $conc8=$conc8+$monto; }
	    if($cod_concepto=="554") { $conc9=$conc9+$monto; }
	    if($cod_concepto=="564") { $conc10=$conc10+$monto; }
		if($cod_concepto=="582") { $conc11=$conc11+$monto; }
		if($cod_concepto=="584") { $conc12=$conc12+$monto; }		
		
		
		$conc13=$conc1+$conc2+$conc3+$conc4+$conc5+$conc6+$conc7+$conc8+$conc9+$conc10+$conc11+$conc12; 
	  }		
	  $tot1=$tot1+$conc1; $tot2=$tot2+$conc2; $tot3=$tot3+$conc3; $tot4=$tot4+$conc4; $tot5=$tot5+$conc5; $tot6=$tot6+$conc6; $tot7=$tot7+$conc7; $tot8=$tot8+$conc8; $tot9=$tot9+$conc9; 
		$tot10=$tot10+$conc10; $tot11=$tot11+$conc11; $tot12=$tot12+$conc12; $tot13=$tot13+$conc13; $tot14=$tot14+$conc14; $tot15=$tot15+$conc15; $cant_emp=$cant_emp+1;
		$conc1=formato_monto($conc1); $conc2=formato_monto($conc2); $conc3=formato_monto($conc3); $conc4=formato_monto($conc4); $conc5=formato_monto($conc5);
		$conc6=formato_monto($conc6); $conc7=formato_monto($conc7); $conc8=formato_monto($conc8); $conc9=formato_monto($conc9); $conc10=formato_monto($conc10);
		$conc11=formato_monto($conc11); $conc12=formato_monto($conc12); $conc13=formato_monto($conc13);
		
		?>
		      <tr>
				  <td width="100" align="left" style="mso-number-format:'@';" ><? echo $cedula; ?></td>
				  <td width="400" align="left"><? echo $nombre; ?></td>	
                  <td width="100" align="left"><? echo $fechai; ?></td>	                     				  
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc1; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc2; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc3; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc4; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc5; ?></td>				  
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc6; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc7; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc8; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc9; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc10; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc11; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc12; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc13; ?></td>
			  </tr>
		<? 
			
		
		$tot1=formato_monto($tot1); $tot2=formato_monto($tot2); $tot3=formato_monto($tot3); $tot4=formato_monto($tot4); $tot5=formato_monto($tot5);
		$tot6=formato_monto($tot6); $tot7=formato_monto($tot7); $tot8=formato_monto($tot8); $tot9=formato_monto($tot9); $tot10=formato_monto($tot10);
		$tot11=formato_monto($tot11); $tot12=formato_monto($tot12); $tot13=formato_monto($tot13);
		
		?>
		  <tr>
			  <td width="100" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="100" align="left"></td>
			  
			  <td width="100" align="right">=============</td>			
			  <td width="100" align="right">=============</td>	
			  <td width="100" align="right">=============</td>			
			  <td width="100" align="right">=============</td>	
			  <td width="100" align="right">=============</td>			
			  <td width="100" align="right">=============</td>	
			  <td width="100" align="right">=============</td>			
			  <td width="100" align="right">=============</td>	
			  <td width="100" align="right">=============</td>			
			  <td width="100" align="right">=============</td>	
			  <td width="100" align="right">=============</td>			
			  <td width="100" align="right">=============</td>	
			  <td width="100" align="right">=============</td>	
		  </tr>
		  <tr>
		      <td width="100" align="left"> </td>
			  <td width="400" align="left">NRO.TRABAJADORES : <? echo $cant_emp; ?></td>
			  <td width="100" align="left">TOTAL :</td>
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot1; ?></td>
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot2; ?></td>
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot3; ?></td>
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot4; ?></td>
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot5; ?></td>
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot6; ?></td>
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot7; ?></td>
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot8; ?></td>
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot9; ?></td>
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot10; ?></td>
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot11; ?></td>
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot12; ?></td>
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot13; ?></td>
		  </tr>
		  <tr height="20">
		  </tr>
		 <?		 
		
}
?>
