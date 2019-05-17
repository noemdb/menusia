<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist="S";  $fecha_desde=$_GET["fecha_desde"]; $fecha_hasta=$_GET["fecha_hasta"]; $fecha_nom=$_GET["fecha_hasta"];    
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $tipo_concepto=$_GET["tipo_concepto"]; $tipo_personal_d=$_GET["tipo_personal_d"];   $tipo_personal_h=$_GET["tipo_personal_h"]; 
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"]; $forma_pago=$_GET["forma_pago"];
   $tipo_rpt="PDF"; $esp_firma="SI"; $salto_dep="NO"; $tipo_reporte='N'; $act_hist="N"; 
   $ordenar="  order by tipo_nomina, cod_categ, cod_empleado, cod_concepto";
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
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."')  ";} 
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_desde>='".$dfechan."') and (fecha_p_hasta<='".$hfechan."')  ";} 
   if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}   
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and ((concepto_vac='N') or (cod_concepto='VVV'))";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and ((concepto_vac='S') and (cod_concepto<>'VVV')) ";}  
   $criterio=$criterio.$cri_tp;
   $criterio=$criterio."  and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."')";
   $criterio1="Mes : ".$mesh." Año: ".$mano;  
   
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
      header("Content-Disposition: attachment; filename=Relacion_mensual.xls"); 	
	  ?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RELACION MENSUAL DE APORTE PATRONAL POR CODIGOS PRESUPUESTARIOS</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <?if($tipo_nomina_d==$tipo_nomina_h){ ?>
		 <tr height="20">
		    <td width="100" align="left" ><strong>Nomina: </strong></td>
		    <td width="400" align="left" ><strong><? echo $tipo_nomina."    ".$des_nomina; ?></strong></td>
		 </tr>
		 <?} ?>
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="left" ><strong><? echo $criterio1; ?></strong></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		   <td width="100" align="left"><strong>Codigo</strong></td>
		   <td width="400" align="left"><strong>Nombre Trabajador</strong></td>
		   <td width="100" align="center"><strong>SSO</strong></td>
		   <td width="100" align="center"><strong>SPF</strong></td>
		   <td width="100" align="center"><strong>UTILIDADES</strong></td>
		   <td width="100" align="center"><strong>VACACIONES</strong></td>
		   <td width="100" align="center"><strong>BONO VAC</strong></td>
		 </tr>
		 
		 
      
	  <? 
	  $i=0; $can_conc=0; $cant_emp=0;  $tot1=0; $tot2=0; $tot3=0; $tot4=0; $tot5=0; $conc1=0; $conc2=0; $conc3=0; $conc4=0; $conc5=0;
	  $sub_tot1=0; $sub_tot2=0; $sub_tot3=0; $sub_tot4=0; $sub_tot5=0;
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_emp=$registro["cod_empleado"]; $tipo_nom=$registro["tipo_nomina"];	$cod_cat=$registro["cod_categ"];	
		if(($prev_cod_empleado<>$cod_emp)or($prev_cod_cat<>$cod_cat)){ $cant_emp=$cant_emp+1;
		    $tot1=$tot1+$conc1; $tot2=$tot2+$conc2; $tot3=$tot3+$conc3; $tot4=$tot4+$conc4; $tot5=$tot5+$conc5; 
			$sub_tot1=$sub_tot1+$conc1; $sub_tot2=$sub_tot2+$conc2; $sub_tot3=$sub_tot3+$conc3; $sub_tot4=$sub_tot4+$conc4; $sub_tot5=$sub_tot5+$conc5; 
			$conc1=formato_monto($conc1); $conc2=formato_monto($conc2); $conc3=formato_monto($conc3); $conc4=formato_monto($conc4); $conc5=formato_monto($conc5);
			?>
		      <tr>
				  <td width="100" align="left" style="mso-number-format:'@';" ><? echo $cod_empleado; ?></td>
				  <td width="400" align="left"><? echo $nombre; ?></td>	                  
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc1; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc2; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc3; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc4; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc5; ?></td>
			  </tr>
		    <? 
			
			
			
			$prev_cod_empleado=$cod_emp;
			$conc1=0; $conc2=0; $conc3=0; $conc4=0; $conc5=0; $nomb_cat="";
			if( $prev_cod_cat<>$cod_cat){
			  $sqlp = "SELECT denominacion FROM PRE001 WHERE (Cod_Presup='$prev_cod_cat')"; $resp=pg_query($sqlp); $filas=pg_num_rows($resp);
              if($filas>0) { $regp=pg_fetch_array($resp); $nomb_cat=$regp["denominacion"]; }	
			  $sub_tot1=formato_monto($sub_tot1); $sub_tot2=formato_monto($sub_tot2); $sub_tot3=formato_monto($sub_tot3); $sub_tot4=formato_monto($sub_tot4); $sub_tot5=formato_monto($sub_tot5);
			  ?>
			  <tr>
				  <td width="100" align="left"></td>
				  <td width="100" align="left"></td>
                  <td width="100" align="right">--------------</td>				
                  <td width="100" align="right">--------------</td>		
				  <td width="100" align="right">--------------</td>		
                  <td width="100" align="right">--------------</td>	
				  <td width="100" align="right">--------------</td>	
			  </tr>
		      <tr>
				  <td width="100" align="left"></td>
				  <td width="400" align="left"><? echo $prev_cod_cat.'  '.$nomb_cat ?></td>	                  
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $sub_tot1; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $sub_tot2; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $sub_tot3; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $sub_tot4; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $sub_tot5; ?></td>
			  </tr>
			  <tr height="20">
		      </tr>
		      <?
			  $prev_cod_cat=$cod_cat; $sub_tot1=0; $sub_tot2=0; $sub_tot3=0; $sub_tot4=0; $sub_tot5=0;
			}
		}
		$tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"]; $monto=$registro["monto"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_deduccion"]; $monto_deduccion=$registro["monto_aporte"];
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		if($cod_concepto=="900") { $conc1=$conc1+$monto; }
		if($cod_concepto=="902") { $conc2=$conc2+$monto; }
		if($cod_concepto=="211") { $conc3=$conc3+$monto; }
		if($cod_concepto=="080") { $conc4=$conc4+$monto; }
		if($cod_concepto=="213") { $conc5=$conc5+$monto; }
	  }		
	  $tot1=$tot1+$conc1; $tot2=$tot2+$conc2; $tot3=$tot3+$conc3; $tot4=$tot4+$conc4; $tot5=$tot5+$conc5; $cant_emp=$cant_emp+1;
			$sub_tot1=$sub_tot1+$conc1; $sub_tot2=$sub_tot2+$conc2; $sub_tot3=$sub_tot3+$conc3; $sub_tot4=$sub_tot4+$conc4; $sub_tot5=$sub_tot5+$conc5; 
			$conc1=formato_monto($conc1); $conc2=formato_monto($conc2); $conc3=formato_monto($conc3); $conc4=formato_monto($conc4); $conc5=formato_monto($conc5);
			?>
		      <tr>
				  <td width="100" align="left" style="mso-number-format:'@';" ><? echo $cod_empleado; ?></td>
				  <td width="400" align="left"><? echo $nombre; ?></td>	                  
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc1; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc2; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc3; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc4; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $conc5; ?></td>
			  </tr>
		    <? ;  
			$prev_cod_empleado=$cod_emp;
			$conc1=0; $conc2=0; $conc3=0; $conc4=0; $conc5=0; $nomb_cat="";
			$sqlp = "SELECT denominacion FROM PRE001 WHERE (Cod_Presup='$prev_cod_cat')"; $resp=pg_query($sqlp); $filas=pg_num_rows($resp);
            if($filas>0) { $regp=pg_fetch_array($resp); $nomb_cat=$regp["denominacion"]; }			
			  $sub_tot1=formato_monto($sub_tot1); $sub_tot2=formato_monto($sub_tot2); $sub_tot3=formato_monto($sub_tot3); $sub_tot4=formato_monto($sub_tot4); $sub_tot5=formato_monto($sub_tot5);
			  ?>
			  <tr>
				  <td width="100" align="left"></td>
				  <td width="100" align="left"></td>
                  <td width="100" align="right">--------------</td>			
                  <td width="100" align="right">--------------</td>			
				  <td width="100" align="right">--------------</td>			
                  <td width="100" align="right">--------------</td>	
				  <td width="100" align="right">--------------</td>		
			  </tr>
		      <tr>
				  <td width="100" align="left"></td>
				  <td width="400" align="left"><? echo $prev_cod_cat.'  '.$nomb_cat ?></td>	                  
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $sub_tot1; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $sub_tot2; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $sub_tot3; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $sub_tot4; ?></td>
				  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $sub_tot5; ?></td>
			  </tr>
			  <tr height="20">
		      </tr>
		      <?
			  $prev_cod_cat=$cod_cat; $sub_tot1=0; $sub_tot2=0; $sub_tot3=0; $sub_tot4=0; $sub_tot5=0;		
		$tot1=formato_monto($tot1); $tot2=formato_monto($tot2); $tot3=formato_monto($tot3); $tot4=formato_monto($tot4); $tot5=formato_monto($tot5);
		?>
		  <tr>
			  <td width="100" align="left"></td>
			  <td width="100" align="left"></td>
			  <td width="100" align="right">=============</td>			
			  <td width="100" align="right">=============</td>		
			  <td width="100" align="right">=============</td>			
			  <td width="100" align="right">=============</td>
			  <td width="100" align="right">=============</td>	
		  </tr>
		  <tr>
			  <td width="100" align="left"></td>
			  <td width="400" align="left">TOTAL GENERAL : </td>	                  
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot1; ?></td>
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot2; ?></td>
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot3; ?></td>
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot4; ?></td>
			  <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $tot5; ?></td>
		  </tr>
		  <tr height="20">
		  </tr>
		 <?
}
?>
