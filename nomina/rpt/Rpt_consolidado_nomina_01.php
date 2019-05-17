<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist="S";  $fecha_desde=$_GET["fecha_desde"]; $fecha_hasta=$_GET["fecha_hasta"]; $fecha_nom=$_GET["fecha_hasta"];    
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $tipo_concepto=$_GET["tipo_concepto"]; $tipo_rpt="PDF";
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"]; $forma_pago=$_GET["forma_pago"];
   $tipo_rpt="PDF"; $esp_firma="SI"; $salto_dep="NO"; $tipo_reporte='N'; $act_hist="N"; 
  // $tipo_nomina_d="01"; $tipo_nomina_h="01";
  $mes_desde=substr($fecha_desde,3,2); $mes_hasta=substr($fecha_hasta,3,2); $mano=substr($fecha_hasta,6,4);  
if ($mes_desde=='01'){$mesd="Enero";}elseif ($mes_desde=='02'){$mesd="Febrero";}elseif ($mes_desde=='03'){$mesd="Marzo";}elseif ($mes_desde=='04'){$mesd="Abril";}elseif ($mes_desde=='05'){$mesd="Mayo";}elseif ($mes_desde=='06'){$mesd="Junio";}elseif ($mes_desde=='07'){$mesd="Julio";}elseif ($mes_desde=='08'){$mesd="Agosto";}elseif ($mes_desde=='09'){$mesd="Septiembre";}elseif ($mes_desde=='10'){$mesd="Octubre";}elseif ($mes_desde=='11'){$mesd="Noviembre";}elseif ($mes_desde=='12'){$mesd="Diciembre";}
if ($mes_hasta=='01'){$mesh="Enero";}elseif ($mes_hasta=='02'){$mesh="Febrero";}elseif ($mes_hasta=='03'){$mesh="Marzo";}elseif ($mes_hasta=='04'){$mesh="Abril";}elseif ($mes_hasta=='05'){$mesh="Mayo";}elseif ($mes_hasta=='06'){$mesh="Junio";}elseif ($mes_hasta=='07'){$mesh="Julio";}elseif ($mes_hasta=='08'){$mesh="Agosto";}elseif ($mes_hasta=='09'){$mesh="Septiembre";}elseif ($mes_hasta=='10'){$mesh="Octubre";}elseif ($mes_hasta=='11'){$mesh="Noviembre";}elseif ($mes_hasta=='12'){$mesh="Diciembre";}
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS'); </script> <?}
else{  $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";} 
   if($tipo_calculo=="T"){ $cri_tp=" and ((tp_calculo='N')or(tp_calculo='E'))  "; } else { $cri_tp=" and (tp_calculo='".$tipo_calculo."') "; }   
   $cfechan=formato_aaaammdd($fecha_nom);  $Sql="";   $date = date("d-m-Y");   $hora = date("H:i:s a");
   $criterio="rpt_nom_cal WHERE (oculto='NO') ";   
   $sql="select fecha_p_hasta from nom017 where (fecha_p_hasta='".$cfechan."') and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') ".$cri_tp;
   $res=pg_query($sql); $filas=pg_num_rows($res); if($filas==0){$act_hist="S";  } 
   
   //$act_hist="S";   
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (oculto='NO') ";} 
   
   if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}   
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and ((concepto_vac='N') or (cod_concepto='VVV'))";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and ((concepto_vac='S') and (cod_concepto<>'VVV')) ";}   
   $criterio=$criterio.$cri_tp;
   $criterio=$criterio."  and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."')";
   $criterio1="Mes : ".$mesh." Año: ".$mano;  
  $sSQL = "SELECT *  FROM ".$criterio."  and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and
	  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_concepto>='".$cod_conceptod."' AND cod_concepto<='".$cod_conceptoh."')  and
	  (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."') ORDER BY tipo_nomina, cod_departam, cod_cargo, cod_empleado, cod_concepto";
  
      $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre=""; $prev_cod_empleado="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"];  $nombre=$registro["nombre"];
		$prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp=$cod_empleado;  $prev_nombre=$nombre; 
	    $prev_cod_empleado=$cod_empleado;
	  }	  
	  
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Consolidado_nomina_01.xls"); 	
	  ?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CONSOLIDADO NOMINA 01</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		    <td width="100" align="left" ><strong>Nomina: </strong></td>
		    <td width="400" align="left" ><strong><? echo $tipo_nomina."    ".$des_nomina; ?></strong></td>
		 </tr>
		 <tr height="20">
		    <td width="100" align="left" ><strong><? echo "Mes : ".$mesh; ?></strong></td>
			<td width="400" align="left" ><strong><? echo " Año: ".$mano; ?></strong></td>
		 </tr>
		 <tr height="20">
		   <td width="100" align="left"><strong>Cedula</strong></td>
		   <td width="400" align="left"><strong>Nombre Trabajador</strong></td>
		   <td width="100" align="left"><strong>Fecha Ingreso</strong></td>
		   <td width="100" align="left"><strong>Cod. Cargo</strong></td>
		   <td width="200" align="left"><strong>Cargo</strong></td>
		   <td width="100" align="left"><strong>Cod. Departamento</strong></td>
		   <td width="200" align="left"><strong>Departamento</strong></td>
		   <td width="200" align="left"><strong>Codigo Presupuestario</strong></td>		   
		   <td width="100" align="right"><strong>Sueldo</strong></td>
		   <td width="100" align="right"><strong>Compensacion</strong></td>
		   <td width="100" align="right"><strong>Profesionalizacion</strong></td>
		   <td width="100" align="right"><strong>Jerarquia</strong></td>
		   <td width="100" align="right"><strong>Antiguedad</strong></td>
		   <td width="100" align="right"><strong>Transportes</strong></td>
		   <td width="100" align="right"><strong>Ant. Profes.</strong></td>
		   <td width="100" align="right"><strong>Hogar</strong></td>
		   <td width="100" align="right"><strong>Hijos</strong></td>
		   <td width="100" align="right"><strong>Eficiencia</strong></td>
		   <td width="100" align="right"><strong>Jerarq. Resp. Cargo</strong></td>		   
		   <td width="100" align="right"><strong>Bono Vacci</strong></td>		   
		   <td width="100" align="right"><strong>Resp. Cargo</strong></td>
		   <td width="100" align="right"><strong>Gastos de Represen</strong></td>
		   <td width="100" align="right"><strong>Hijos Excep.</strong></td>
		   <td width="100" align="right"><strong>Prima de Movilidad</strong></td>
		   <td width="100" align="right"><strong>Dif. Sueldo Encarg.</strong></td>
		   <td width="100" align="right"><strong>Bono Product.</strong></td>
		   <td width="100" align="right"><strong>Sueldo Integral</strong></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 
		<?  $tot1=0; $tot2=0; $tot3=0; $tot4=0; $tot5=0; $tot6=0; $tot7=0; $tot8=0; $tot9=0; $tot10=0; $tot11=0; $tot12=0; $tot13=0; $tot14=0; $tot15=0; $tot16=0; $tot17=0; $tot18=0; $tot19=0; $tot20=0;
		$conc1=0; $conc2=0; $conc3=0; $conc4=0; $conc5=0; $conc6=0; $conc7=0; $conc8=0; $conc9=0; $conc10=0; $conc11=0; $conc12=0; $conc13=0; $conc14=0; $conc15=0; $conc16=0; $conc17=0; $conc18=0; $conc19=0; $conc20=0;
		$i=0;$cant_emp=0; $total_monto=0; $total_monto1=0; $sub_total_monto=0; $sub_total_monto_asignacion=0; $sub_total_monto_deduccion=0; $cant_conc=0;
		while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_emp=$registro["cod_empleado"]; $tipo_nom=$registro["tipo_nomina"];		
		   if($prev_cod_empleado<>$cod_emp){ $cant_emp=$cant_emp+1;
		      $tot1=$tot1+$conc1; $tot2=$tot2+$conc2; $tot3=$tot3+$conc3; $tot4=$tot4+$conc4; $tot5=$tot5+$conc5; $tot6=$tot6+$conc6; $tot7=$tot7+$conc7; $tot8=$tot8+$conc8; $tot9=$tot9+$conc9; 
			  $tot10=$tot10+$conc10; $tot11=$tot11+$conc11; $tot12=$tot12+$conc12; $tot13=$tot13+$conc13; $tot14=$tot14+$conc14; $tot15=$tot15+$conc15; $tot16=$tot16+$conc16; $tot17=$tot17+$conc17; 
			  $tot18=$tot18+$conc18; $tot19=$tot19+$conc19;		   
		    ?>
		      <tr>
				  <td width="100" align="left" style="mso-number-format:'@';" ><? echo $cedula; ?></td>
				  <td width="400" align="left"><? echo $nombre; ?></td>	
                  <td width="100" align="left"><? echo $fechai; ?></td>		
                  <td width="100" align="left"><? echo $cod_cargo; ?></td>	
                  <td width="200" align="left"><? echo $des_cargo; ?></td>	
                  <td width="100" align="left"><? echo $cod_departam; ?></td>	
                  <td width="200" align="left"><? echo $des_departam; ?></td>	
                  <td width="200" align="left"><? echo $cod_presup; ?></td>	
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
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc14; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc15; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc16; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc17; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc18; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc19; ?></td>
				  
			  </tr>
		    <? $prev_cod_empleado=$cod_emp;
			$conc1=0; $conc2=0; $conc3=0; $conc4=0; $conc5=0; $conc6=0; $conc7=0; $conc8=0; $conc9=0; $conc10=0; $conc11=0; $conc12=0; $conc13=0; $conc14=0; $conc15=0; $conc16=0; $conc17=0; $conc18=0; $conc19=0; $conc20=0;
		  }
		   
		   $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];$cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
	       $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $fechai=$registro["fechai"]; 
           $des_cargo=$registro["des_cargo"]; $cod_cargo=$registro["cod_cargo"]; $cedula=$registro["cedula"]; $monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"]; 
           $cod_presup=$registro["cod_presup"]; $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];  	$monto=$registro["monto"];
			
		   if($cod_concepto=="001") { $conc1=$conc1+$monto; }
		   if($cod_concepto=="002") { $conc2=$conc2+$monto; }
		   if($cod_concepto=="003") { $conc3=$conc3+$monto; }
		   if($cod_concepto=="004") { $conc4=$conc4+$monto; }
		   if($cod_concepto=="005") { $conc5=$conc5+$monto; }
		   if($cod_concepto=="006") { $conc6=$conc6+$monto; }
		   if($cod_concepto=="007") { $conc7=$conc7+$monto; }
		   if($cod_concepto=="008") { $conc8=$conc8+$monto; }
		   if($cod_concepto=="009") { $conc9=$conc9+$monto; }
		   if($cod_concepto=="010") { $conc10=$conc10+$monto; }
		   if($cod_concepto=="011") { $conc11=$conc11+$monto; }
		   if($cod_concepto=="012") { $conc12=$conc12+$monto; }		   
		   if($cod_concepto=="015") { $conc13=$conc13+$monto; }
		   if($cod_concepto=="016") { $conc14=$conc14+$monto; }
		   if($cod_concepto=="022") { $conc15=$conc15+$monto; }
		   if($cod_concepto=="027") { $conc16=$conc16+$monto; }
		   if($cod_concepto=="050") { $conc17=$conc17+$monto; }
		   if($cod_concepto=="113") { $conc18=$conc18+$monto; }
		   if($cod_concepto=="200") { $conc19=$conc19+$monto; }
		}  

     
        $tot1=$tot1+$conc1; $tot2=$tot2+$conc2; $tot3=$tot3+$conc3; $tot4=$tot4+$conc4; $tot5=$tot5+$conc5; $tot6=$tot6+$conc6; $tot7=$tot7+$conc7; $tot8=$tot8+$conc8; $tot9=$tot9+$conc9; 
			  $tot10=$tot10+$conc10; $tot11=$tot11+$conc11; $tot12=$tot12+$conc12; $tot13=$tot13+$conc13; $tot14=$tot14+$conc14; $tot15=$tot15+$conc15; $tot16=$tot16+$conc16; $tot17=$tot17+$conc17; 
			  $tot18=$tot18+$conc18; $tot19=$tot19+$conc19;		   
		    ?>
		      <tr>
				  <td width="100" align="left" style="mso-number-format:'@';" ><? echo $cedula; ?></td>
				  <td width="400" align="left"><? echo $nombre; ?></td>	
                  <td width="100" align="left"><? echo $fechai; ?></td>		
                  <td width="100" align="left"><? echo $cod_cargo; ?></td>	
                  <td width="200" align="left"><? echo $des_cargo; ?></td>	
                  <td width="100" align="left"><? echo $cod_departam; ?></td>	
                  <td width="200" align="left"><? echo $des_departam; ?></td>	
                  <td width="200" align="left"><? echo $cod_presup; ?></td>	
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
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc14; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc15; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc16; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc17; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc18; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc19; ?></td>
				  
		</tr>
		<tr>
		  <td width="100" align="left"></td>
		  <td width="400" align="left"></td>
		  <td width="100" align="left"></td>
		  <td width="100" align="left"></td>
		  <td width="200" align="left"></td>
		  <td width="100" align="left"></td>
		  <td width="200" align="left"></td>
		  <td width="200" align="left"></td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		</tr>	
		<tr>
		  <td width="100" align="left"></td>
		  <td width="400" align="left"><? echo "Nro. Trabjadores : ".$cant_emp; ?></td>
		  <td width="100" align="left"></td>
		  <td width="100" align="left"></td>
		  <td width="200" align="left"></td>
		  <td width="100" align="left"></td>
		  <td width="200" align="left"></td>
		  <td width="200" align="right"><? echo "TOTAL  : "; ?></td>
		  
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
		  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot14; ?></td>
		  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot15; ?></td>
		  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot16; ?></td>
		  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot17; ?></td>
		  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot18; ?></td>
		  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot19; ?></td>
		</tr>	
		
		</table><?
		
      
}
?>
