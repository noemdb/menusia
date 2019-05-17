<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist="S";
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $tipo_concepto=$_GET["tipo_concepto"]; $tipo_rpt="PDF";
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"]; $forma_pago=$_GET["forma_pago"];   
   $cod_empleado_d=$_GET["cod_empleado_d"]; $cod_empleado_h=$_GET["cod_empleado_h"]; $codigo_cargo_d=$_GET["codigo_cargo_d"];  $codigo_cargo_h=$_GET["codigo_cargo_h"]; 
   $fecha_desde=$_GET["fecha_desde"]; $fecha_nom=$_GET["fecha_hasta"];  $fecha_hasta=$_GET["fecha_hasta"];  $cod_presup_catd=$_GET["cod_presup_catd"];  $cod_presup_cath=$_GET["cod_presup_cath"]; 
   $Sql="";$date = date("d-m-Y"); $hora = date("h:i:s a"); $cfechan=formato_aaaammdd($fecha_nom);  $cfechad=formato_aaaammdd($fecha_desde); $cfechah=formato_aaaammdd($fecha_hasta);   
   
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";}
   
   $sqlb="select fecha_p_hasta from nom017 WHERE (fecha_p_desde='".$cfechad."') and (fecha_p_hasta='".$cfechah."') and (tipo_nomina='".$tipo_nomina_d."')  ";
   $res=pg_query($sqlb); $filas=pg_num_rows($res);   if($filas>=1){ $act_hist="N"; }
   
   $criterio="rpt_nom_cal WHERE ((oculto='NO') or (oculto='SI'))";
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and ((oculto='NO') or (oculto='SI')) ";      
   $criterio="rpt_nom_hist WHERE ((oculto='NO') or (oculto='SI')) and (fecha_p_hasta>='".$cfechad."') and (fecha_p_hasta<='".$cfechah."') ";  } 
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and (concepto_vac='N') ";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and (concepto_vac='S') ";}   
   if($tipo_calculo=='T'){$criterio=$criterio;}else{$criterio=$criterio." and (tp_calculo='".$tipo_calculo."') ";}   

  $sSQL = "SELECT *  FROM ".$criterio."  and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and
	  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_concepto>='".$cod_conceptod."' AND cod_concepto<='".$cod_conceptoh."')  and
	  (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."') and (cod_categ>='".$cod_presup_catd."' and cod_categ<='".$cod_presup_cath."') Order by tipo_nomina, cod_concepto, cod_empleado";
  
  //echo $sSQL;
      $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"];  $nombre=$registro["nombre"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; $denominacion=conv_cadenas($denominacion,0);
		$prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp=$cod_empleado;  $prev_nombre=$nombre; 
	  }	
      header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Consolidado_Detalle_Concepto.xls"); 	  
	  ?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RELACION DE CONCEPTOS DETALLES</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		    <td width="100" align="left" ><strong>Nomina: </strong></td>
		    <td width="400" align="left" ><strong><? echo $tipo_nomina."    ".$des_nomina; ?></strong></td>
		 </tr>
		 <tr height="20">
		    <td width="100" align="left" ><strong>Fecha: </strong></td>
		    <td width="400" align="left" ><strong><? echo $fecha_desde."  "." Al   ".$fecha_hasta; ?></strong></td>
		 </tr>
		 <tr height="20">
		   <td width="100" align="left"><strong>Codigo</strong></td>
		   <td width="400" align="left"><strong>Nombre Trabajador</strong></td>
		   <td width="100" align="right"><strong>Cantidad</strong></td>
		   <td width="100" align="right"><strong>Asignaciones</strong></td>
		   <td width="100" align="right"><strong>Deducciones</strong></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		   <td width="100" align="left"><strong><? echo $cod_concepto; ?></strong></td>
		   <td width="400" align="left"><strong><? echo $denominacion; ?></strong></td>
		 </tr>
		<?
     	  
      
	  
	  $i=0; $can_conc=0; $totala_nom=0; $totald_nom=0; $cant_nom=0;	$totala_emp=0; $totald_emp=0; $cant_emp=0;  $totala_conc=0; $totald_conc=0;  
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; $denominacion=conv_cadenas($denominacion,0); $monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];				
		if(($prev_conc<>$cod_concepto)or($prev_tipo<>$tipo_nomina)){		
		    if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
			if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}	
            ?>		 		    			 
                    <tr>
					  <td width="100" align="left"><? echo $prev_emp; ?></td>
					  <td width="400" align="left"><? echo $prev_nombre; ?></td>				 
					  <td width="100" align="center"><? echo $can_conc; ?></td>
					  <td width="100" align="right"><? echo $totala_emp; ?></td>
					  <td width="100" align="right"><? echo $totald_emp; ?></td>
				    </tr>
            <?	
		    $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $cant_emp=$cant_emp+1; 		    
		    $totala_conc=formato_monto($totala_conc); $totald_conc=formato_monto($totald_conc); 
			?>
                   <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="100" align="right"></td>
					  <td width="100" align="right">-----------------</td>
					  <td width="100" align="right">-----------------</td>
				    </tr>	
				    <tr>
				      <td width="100" align="left"><? echo "Nro. Trabjadores : ".$cant_emp; ?></td>
					  <td width="400" align="right"><? echo "TOTAL  : ".$den_conc; ?></td>
					  <td width="100" align="left"></td>
					  <td width="100" align="right"><? echo $totala_conc; ?></td>
					  <td width="100" align="right"><? echo $totald_conc; ?></td> 
				    </tr>	
				    <tr>
				      <td width="90" align="left"></td>
				    </tr>
					<tr height="20">
		   			   <td width="100" align="left"><strong><? echo $cod_concepto; ?></strong></td>
		   			   <td width="400" align="left"><strong><? echo $denominacion; ?></strong></td>
		 		    </tr>	
			<?	
			$prev_conc=$cod_concepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0;  $cant_emp=0;$prev_tipo=$tipo_nomina;
            
		} 
		
		if($prev_emp<>$cod_empleado){		
		   if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
			if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			?>		 		    			 
                    <tr>
					  <td width="100" align="left"><? echo $prev_emp; ?></td>
					  <td width="400" align="left"><? echo $prev_nombre; ?></td>				 
					  <td width="100" align="center"><? echo $can_conc; ?></td>
					  <td width="100" align="right"><? echo $totala_emp; ?></td>
					  <td width="100" align="right"><? echo $totald_emp; ?></td>
				    </tr>
            <?		
		    $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $cant_emp=$cant_emp+1; 
		}	
		$can_conc=$can_conc+$cantidad; $totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;		
		$totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;		
		
		
      } if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
		if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
		?>		 		    			 
                    <tr>
					  <td width="100" align="left"><? echo $prev_emp; ?></td>
					  <td width="400" align="left"><? echo $prev_nombre; ?></td>				 
					  <td width="100" align="center"><? echo $can_conc; ?></td>
					  <td width="100" align="right"><? echo $totala_emp; ?></td>
					  <td width="100" align="right"><? echo $totald_emp; ?></td>
				    </tr>
            <?			
		$can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $cant_emp=$cant_emp+1; 
		
		$totala_conc=formato_monto($totala_conc); $totald_conc=formato_monto($totald_conc);
		?>
                   <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="100" align="right"></td>
					  <td width="100" align="right">-----------------</td>
					  <td width="100" align="right">-----------------</td>
				    </tr>	
				    <tr>
				      <td width="100" align="left"><? echo "Nro. Trabjadores : ".$cant_emp; ?></td>
					  <td width="400" align="right"><? echo "TOTAL  : ".$den_conc; ?></td>
					  <td width="100" align="left"></td>
					  <td width="100" align="right"><? echo $totala_conc; ?></td>
					  <td width="100" align="right"><? echo $totald_conc; ?></td> 
				    </tr>	
				    <tr>
				      <td width="90" align="left"></td>
				    </tr>
					
		<?	  
}
?>
