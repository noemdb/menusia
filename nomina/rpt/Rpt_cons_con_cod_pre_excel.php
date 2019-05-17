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
   
   $StrSQL = "delete from nom016 where (linea='000' or  linea='001') and tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."'";
   $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
    
   $sqlb="select fecha_p_hasta from nom017 WHERE (fecha_p_desde='".$cfechad."') and (fecha_p_hasta='".$cfechah."') and (tipo_nomina='".$tipo_nomina_d."')  ";
   $res=pg_query($sqlb); $filas=pg_num_rows($res);   if($filas>=1){ $act_hist="N"; }
   
   $criterio="rpt_nom_cal WHERE ((cod_concepto<>'VVV') and (oculto='NO') and (monto>0))";
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and ((cod_concepto<>'VVV') and (oculto='NO') and (monto>0)) ";      
   $criterio="rpt_nom_hist WHERE ((cod_concepto<>'VVV') and (oculto='NO') and (monto>0)) and (fecha_p_hasta>='".$cfechad."') and (fecha_p_hasta<='".$cfechah."') ";  } 
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and (concepto_vac='N') ";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and (concepto_vac='S') ";}   
   if($tipo_calculo=='T'){$criterio=$criterio;}else{$criterio=$criterio." and (tp_calculo='".$tipo_calculo."') ";}   

   $sSQL = "SELECT *  FROM ".$criterio."  and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and
	  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_concepto>='".$cod_conceptod."' AND cod_concepto<='".$cod_conceptoh."')  and
	  (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."') and (cod_categ>='".$cod_presup_catd."' and cod_categ<='".$cod_presup_cath."') Order by tipo_nomina, cod_concepto, cod_empleado";
  
   $StrSQL = "INSERT INTO nom016 select tipo_nomina, fecha_p_hasta, cod_empleado, '000', num_recibo, fecha_hasta, fecha_desde, fecha_proceso, tp_calculo, num_periodos,  cod_grupo, desc_grupo, nombre, cedula, fecha_ingreso, status_emp, cod_concepto, denominacion, cantidad, monto_orig, monto_asignacion, 
				acumulado, saldo, valore, valoru, valorq, valorw, valorx, valory, valorz, cod_concepto, denominacion, cantidad, monto_orig,  monto_deduccion, acumulado, saldo, valore, valoru, valorq, valorw, valorx, valory, valorz, monto,asignacion,oculto,tipo_asigna,asig_ded_apo, frecuencia, nro_semana, cod_cargo, 
				des_cargo, sueldo_cargo, prima_cargo, compensa_cargo, sueldo_integral,  otros, cod_departam, des_departam, cod_presup, cod_contable, tipo_pago, cta_empleado, cta_empresa, nombre_banco, afecta_presup,cod_retencion, codigo_ubicacion, descripcion_ubi, des_nomina 
			    FROM ".$criterio."  and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and
	           (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_concepto>='".$cod_conceptod."' AND cod_concepto<='".$cod_conceptoh."')  and
	           (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."') and (cod_categ>='".$cod_presup_catd."' and cod_categ<='".$cod_presup_cath."') ";
  		
					
	$temp=$StrSQL;	$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }    
        
	$StrSQL="update nom016 set monto1=monto*-1,monto2=0,linea='001' where asignacion='NO' and cod_retencion='000'";	$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }    
		
	$sSQL = "SELECT nom016.linea,nom016.tipo_nomina,nom016.des_nomina, nom016.fecha_desde, nom016.fecha_hasta, nom016.cod_concepto1 as cod_concepto, nom016.denominacion1 as denominacion, nom016.cod_empleado, nom016.nombre, nom016.asignacion, nom016.monto1 as monto_asignacion, nom016.monto2 as monto_deduccion, nom016.oculto, nom016.monto, nom016.cod_presup, nom016.cod_contable, nom016.fecha_p_Hasta, nom016.tp_calculo, nom016.desc_grupo,
            nom016.afecta_presup,nom016.cod_retencion,nom016.asig_ded_apo,to_char(nom016.fecha_p_hasta,'DD/MM/YYYY') as fechaph,to_char(nom016.fecha_hasta,'DD/MM/YYYY') as fechah,to_char(nom016.fecha_desde,'DD/MM/YYYY') as fechad, pre022.cod_presup_p, pre022.cod_fuente_p, pre022.denominacion_p
            FROM nom016 left join pre022 on (nom016.cod_presup=pre022.cod_presup_p and nom016.cod_contable=pre022.cod_fuente_p)  where (linea='000' or linea='001') and tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."' order by cod_presup,cod_contable,linea,tipo_nomina,cod_concepto";
		   
  //echo $sSQL;
      $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"];  $nombre=$registro["nombre"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];  $denominacion=conv_cadenas($denominacion,0);
		$prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp=$cod_empleado;  $prev_nombre=$nombre; 
	  }	
      header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Relacion_Concepto_Cod_Presupuestario.xls"); 	  
	  ?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    <td width="200" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RELACION CONCEPTOS/CODIGOS PRESUPUESTARIOS</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		    <td width="200" align="left" ><strong>Nomina: </strong></td>
		    <td width="400" align="left" ><strong><? echo $tipo_nomina."    ".$des_nomina; ?></strong></td>
		 </tr>
		 <tr height="20">
		    <td width="200" align="left" ><strong>Fecha: </strong></td>
		    <td width="400" align="left" ><strong><? echo $fecha_desde."  "." Al   ".$fecha_hasta; ?></strong></td>
		 </tr>
		 <tr height="20">
		   <td width="200" align="left"><strong>COD. PRESUPUESTARIO</strong></td>
		   <td width="400" align="left"><strong>DENOMINACION</strong></td>
		   <td width="100" align="right"><strong>ASIGNACION</strong></td>
		   <td width="100" align="right"><strong>DEDUCCION</strong></td>
		   <td width="100" align="right"><strong>NETO</strong></td>		   
		 </tr>
		 <tr height="20">
		 </tr>		       
		<?  
	  $i=0;  $total_monto_asignacion=0; $total_monto_deduccion=0; $total_monto=0; $sub_total_monto_asignacion=""; $sub_total_monto_deduccion=""; $sub_total_monto=""; $prev_cod_presup=""; $prev_cod_contable=""; $prev_linea=""; $prev_denominacion_p=""; $prev_cod_grupo="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_presup=$registro["cod_presup"]; $cod_contable=$registro["cod_contable"];  $denominacion_p=$registro["denominacion_p"]; $linea=$registro["linea"];
		   $denominacion_p=conv_cadenas($denominacion_p,0); $cod_presup_grupo=$cod_presup.$cod_contable;  $denominacion_p_grupo=$denominacion_p;  
		   if($prev_cod_grupo<>$cod_presup_grupo){ 
			 if(($sub_total_monto_asignacion<>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){ $sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion);	$sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto=formato_monto($sub_total_monto);				    
			 ?>		 		    			 
				<tr>
				  <td width="200" align="left"><? echo $prev_cod_presup."  ".$prev_cod_contable; ?></td>
				  <td width="400" align="left"><? echo $prev_denominacion_p; ?></td>				 
				  <td width="100" align="center"><? echo $sub_total_monto_asignacion; ?></td>
				  <td width="100" align="right"><? echo $sub_total_monto_deduccion; ?></td>
				  <td width="100" align="right"><? echo $sub_total_monto; ?></td>
				</tr>
             <?				
			 }	
			 $prev_cod_grupo=$cod_presup_grupo; $prev_cod_presup=$cod_presup; $prev_cod_contable=$cod_contable; $prev_linea=$linea; $prev_denominacion_p=$denominacion_p_grupo; $sub_total_monto_asignacion=0; $sub_total_monto_deduccion=0; $sub_total_monto=0;
		   }
		   $cod_presup=$registro["cod_presup"]; $denominacion_p=$registro["denominacion_p"]; $monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"]; 
		   $total_monto_asignacion=$total_monto_asignacion+$monto_asignacion;  $total_monto_deduccion=$total_monto_deduccion+$monto_deduccion; 
		   $total_monto=$total_monto+$monto_asignacion-$monto_deduccion;  $sub_total_monto_asignacion=$sub_total_monto_asignacion+$monto_asignacion; 
		   $sub_total_monto_deduccion=$sub_total_monto_deduccion+$monto_deduccion; $sub_total_monto=$sub_total_monto+$monto_asignacion-$monto_deduccion;
		   $monto_asignacion=formato_monto($monto_asignacion); $monto_deduccion=formato_monto($monto_deduccion); $denominacion=conv_cadenas($denominacion,0); $denominacion_p=conv_cadenas($denominacion_p,0);
		} 
		if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){ $sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion);	$sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto=formato_monto($sub_total_monto);				    
			?>		 		    			 
			<tr>
			  <td width="200" align="left"><? echo $prev_cod_presup."  ".$prev_cod_contable; ?></td>
			  <td width="400" align="left"><? echo $prev_denominacion_p; ?></td>				 
			  <td width="100" align="center"><? echo $sub_total_monto_asignacion; ?></td>
			  <td width="100" align="right"><? echo $sub_total_monto_deduccion; ?></td>
			  <td width="100" align="right"><? echo $sub_total_monto; ?></td>
			</tr>
            <?			
	    }$total_monto_asignacion=formato_monto($total_monto_asignacion);  $total_monto_deduccion=formato_monto($total_monto_deduccion); $total_monto=formato_monto($total_monto); 
		?>
		   <tr>
			  <td width="200" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="100" align="right">-----------------</td>
			  <td width="100" align="right">-----------------</td>
			  <td width="100" align="right">-----------------</td>
			</tr>	
			<tr>
			  <td width="200" align="left"></td>
			  <td width="400" align="right"><? echo "TOTAL GENERAL  : "; ?></td>
			  <td width="100" align="right"><? echo $total_monto_asignacion; ?></td>
			  <td width="100" align="right"><? echo $total_monto_deduccion; ?></td>
			  <td width="100" align="right"><? echo $total_monto; ?></td> 
			</tr>	
			<tr>
			  <td width="90" align="left"></td>
			</tr>	
		<?	  
}
?>
