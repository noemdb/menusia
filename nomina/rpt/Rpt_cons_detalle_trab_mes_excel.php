<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist="S";
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $tipo_concepto=$_GET["tipo_concepto"]; $tipo_rpt="PDF";
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"]; $forma_pago=$_GET["forma_pago"];
   $cod_empleado_d=$_GET["cod_empleado_d"]; $cod_empleado_h=$_GET["cod_empleado_h"]; $codigo_cargo_d=$_GET["codigo_cargo_d"];  $codigo_cargo_h=$_GET["codigo_cargo_h"]; 
   $fecha_desde=$_GET["fecha_desde"]; $fecha_nom=$_GET["fecha_hasta"];  $fecha_hasta=$_GET["fecha_hasta"];
   $Sql="";$date = date("d-m-Y"); $hora = date("h:i:s a"); $cfechan=formato_aaaammdd($fecha_nom);  $cfechad=formato_aaaammdd($fecha_desde); $cfechah=formato_aaaammdd($fecha_hasta);
   $criterio="rpt_nom_cal WHERE (oculto='NO') ";
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (oculto='NO') ";} 
   $criterio="rpt_nom_hist WHERE (oculto='NO') and (fecha_p_desde>='".$cfechad."') and (fecha_p_desde<='".$cfechah."') ";
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and (concepto_vac='N') ";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and (concepto_vac='S') ";}
   if($tipo_calculo=='T'){$criterio=$criterio;}else{$criterio=$criterio." and (tp_calculo='".$tipo_calculo."') ";}
   
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";}
  $sSQL = "SELECT *  FROM ".$criterio."  and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and
	  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_concepto>='".$cod_conceptod."' AND cod_concepto<='".$cod_conceptoh."')  and
	  (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."') ORDER BY cod_empleado, fecha_p_desde, cod_concepto";
  
      $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_mes=""; $prev_den_dep=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre=""; $prev_perido="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"];  $nombre=$registro["nombre"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; 
		$fecha_p_desde=$registro["fecha_p_desde"]; $mes=substr($fecha_p_desde,5,2); $ano=substr($fecha_p_desde,0,4); $periodo=$mes."-".$ano; $prev_perido=$periodo;			
        if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		$prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp=$cod_empleado;  $prev_nombre=$nombre; 
	  }	 

      header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Consolidado_Conceptos_Trabajador.xls"); 		  
     ?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="100" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RELACION DE CONCEPTOS POR TRABAJADOR</strong></font></td>
		 </tr>
		 
		 <tr height="20">
		    <td width="100" align="left" ><strong>Trabajador: </strong></td>
		    <td width="100" align="left" ><strong><? echo $cod_empleado; ?></strong></td>
			<td width="100" align="left" ><strong><? echo $nombre; ?></strong></td>
		 </tr>
		 <tr height="20">
		   <td width="100" align="left"><strong>Fecha</strong></td>
		   <td width="100" align="right"><strong>Sueldo</strong></td>
		   <td width="100" align="right"><strong>Descanso Legal</strong></td>
		   <td width="100" align="right"><strong>Art. 169</strong></td>
		   <td width="100" align="right"><strong>Tiempo Viaje</strong></td>
		   <td width="100" align="right"><strong>Dia Feriado Laborado</strong></td>
		   <td width="100" align="right"><strong>Domingo Laboral</strong></td>
		   <td width="100" align="right"><strong>Bono Puntualidad</strong></td>
		   <td width="100" align="right"><strong>Bono Nocturno</strong></td>
		   <td width="100" align="right"><strong>Bono Tunel</strong></td>
		   <td width="100" align="right"><strong>Descanso Compensatorio</strong></td>
		   <td width="100" align="right"><strong>Cambio de Frente</strong></td>
		   <td width="100" align="right"><strong>Dia Desc. Laborado</strong></td>
		   <td width="100" align="right"><strong>Total</strong></td>
		 </tr>		
	  <?
	  $i=0; $can_conc=0; $totala_nom=0; $totald_nom=0; $cant_nom=0;	$totala_emp=0; $totald_emp=0; $cant_emp=0;  $totala_conc=0; $totald_conc=0; 
      $concepto1=0;	 $concepto2=0;	 $concepto3=0;	$concepto4=0;	$concepto5=0;	$concepto6=0; $concepto7=0; $concepto8=0; $concepto9=0; $concepto10=0; $concepto11=0; $concepto12=0;
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"];  $cantidad=$registro["cantidad"]; $monto=$registro["monto"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
		$fecha_p_desde=$registro["fecha_p_desde"]; $mes=substr($fecha_p_desde,5,2); $ano=substr($fecha_p_desde,0,4); $periodo=$mes."-".$ano; 		
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		
		if(($prev_emp<>$cod_empleado)or($prev_perido<>$periodo)){ 
		     $concepto20=$concepto1+$concepto2+$concepto3+$concepto4+$concepto5+$concepto6+$concepto7+$concepto8+$concepto9+$concepto10+$concepto11+$concepto12;	
		     $concepto1=formato_monto($concepto1); $concepto2=formato_monto($concepto2); $concepto3=formato_monto($concepto3);  $concepto4=formato_monto($concepto4);
		     $concepto5=formato_monto($concepto5);  $concepto6=formato_monto($concepto6);  $concepto7=formato_monto($concepto7);  $concepto8=formato_monto($concepto8);
			 $concepto9=formato_monto($concepto9);  $concepto10=formato_monto($concepto10); $concepto11=formato_monto($concepto11); $concepto12=formato_monto($concepto12); $concepto20=formato_monto($concepto20);
            ?>		 		    			 
				<tr>
				  <td width="100" align="left"><? echo $prev_perido; ?></td>			 
				  <td width="100" align="right"><? echo $concepto1; ?></td>
				  <td width="100" align="right"><? echo $concepto2; ?></td>
				  <td width="100" align="right"><? echo $concepto3; ?></td>
				  <td width="100" align="right"><? echo $concepto4; ?></td>
				  <td width="100" align="right"><? echo $concepto5; ?></td>
				  <td width="100" align="right"><? echo $concepto6; ?></td>
				  <td width="100" align="right"><? echo $concepto7; ?></td>
				  <td width="100" align="right"><? echo $concepto8; ?></td>
				  <td width="100" align="right"><? echo $concepto9; ?></td>
				  <td width="100" align="right"><? echo $concepto10; ?></td>
				  <td width="100" align="right"><? echo $concepto11; ?></td>
				  <td width="100" align="right"><? echo $concepto12; ?></td>
				  <td width="100" align="right"><? echo $concepto20; ?></td>
				</tr>
            <?	
		    $can_conc=0;     $prev_perido=$periodo;
			$concepto1=0;	 $concepto2=0;	 $concepto3=0;	$concepto4=0;	$concepto5=0;	$concepto6=0; $concepto7=0; $concepto8=0; $concepto9=0; $concepto10=0; $concepto11=0; $concepto12=0;
	    	
			if($prev_emp<>$cod_empleado){ 
			$prev_emp=$cod_empleado;  $prev_nombre=$nombre; $cant_emp=$cant_emp+1;	$totala_emp=0; $totald_emp=0; $totala_conc=0; $totald_conc=0;  $cant_emp=0;$prev_tipo=$tipo_nomina; 
             ?>
				 <tr height="20">
				 </tr>		
				 <tr height="20">
					<td width="100" align="left" ><strong>Trabajador: </strong></td>
					<td width="100" align="left" ><strong><? echo $cod_empleado; ?></strong></td>
					<td width="100" align="left" ><strong><? echo $nombre; ?></strong></td>
				 </tr>
		     <?
			}			
		} 
		If ($cod_concepto=='001'){ $concepto1=$concepto1+$monto;  }
		If ($cod_concepto=='002'){ $concepto2=$concepto2+$monto;  }
		If ($cod_concepto=='003'){ $concepto3=$concepto3+$monto;  }
		If ($cod_concepto=='004'){ $concepto4=$concepto4+$monto;  }
		If ($cod_concepto=='009'){ $concepto5=$concepto5+$monto;  }
		If ($cod_concepto=='007'){ $concepto6=$concepto6+$monto;  }
		If ($cod_concepto=='011'){ $concepto7=$concepto7+$monto;  }
		If ($cod_concepto=='013'){ $concepto8=$concepto8+$monto;  }
		If ($cod_concepto=='016'){ $concepto9=$concepto9+$monto;  }
		If ($cod_concepto=='012'){ $concepto10=$concepto10+$monto;  }
		If ($cod_concepto=='022'){ $concepto11=$concepto11+$monto;  }	
        If ($cod_concepto=='019'){ $concepto12=$concepto12+$monto;  }			
		$can_conc=$can_conc+$cantidad; $totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;		
		$totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;	
      }
	  $concepto20=$concepto1+$concepto2+$concepto3+$concepto4+$concepto5+$concepto6+$concepto7+$concepto8+$concepto9+$concepto10+$concepto11+$concepto12;			     
	  $concepto1=formato_monto($concepto1); $concepto2=formato_monto($concepto2); $concepto3=formato_monto($concepto3);  $concepto4=formato_monto($concepto4);
	  $concepto5=formato_monto($concepto5);  $concepto6=formato_monto($concepto6);  $concepto7=formato_monto($concepto7);  $concepto8=formato_monto($concepto8);
	  $concepto9=formato_monto($concepto9);  $concepto10=formato_monto($concepto10); $concepto11=formato_monto($concepto11); $concepto12=formato_monto($concepto12);
	  $concepto20=formato_monto($concepto20);
       ?>		 		    			 
			<tr>
			  <td width="100" align="left"><? echo $prev_perido; ?></td>			 
			  <td width="100" align="right"><? echo $concepto1; ?></td>
			  <td width="100" align="right"><? echo $concepto2; ?></td>
			  <td width="100" align="right"><? echo $concepto3; ?></td>
			  <td width="100" align="right"><? echo $concepto4; ?></td>
			  <td width="100" align="right"><? echo $concepto5; ?></td>
			  <td width="100" align="right"><? echo $concepto6; ?></td>
			  <td width="100" align="right"><? echo $concepto7; ?></td>
			  <td width="100" align="right"><? echo $concepto8; ?></td>
			  <td width="100" align="right"><? echo $concepto9; ?></td>
			  <td width="100" align="right"><? echo $concepto10; ?></td>
			  <td width="100" align="right"><? echo $concepto11; ?></td>
			  <td width="100" align="right"><? echo $concepto12; ?></td>
			  <td width="100" align="right"><? echo $concepto20; ?></td>
			</tr>
		<?		  
    
}
?>
