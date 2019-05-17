<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist="S";  $fecha_desde=$_GET["fecha_desde"]; $fecha_hasta=$_GET["fecha_hasta"]; $fecha_nom=$_GET["fecha_hasta"];    
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $tipo_concepto=$_GET["tipo_concepto"]; $tipo_personal_d=$_GET["tipo_personal_d"];   $tipo_personal_h=$_GET["tipo_personal_h"]; 
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"]; $forma_pago=$_GET["forma_pago"];
   $tipo_rpt="PDF"; $esp_firma="SI"; $salto_dep="NO"; $tipo_reporte='N'; $act_hist="N"; 
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
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (oculto='NO') ";} 
   if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}   
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and ((concepto_vac='N') or (cod_concepto='VVV'))";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and ((concepto_vac='S') and (cod_concepto<>'VVV')) ";}   
   $criterio=$criterio.$cri_tp;
   $criterio=$criterio."  and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."')";
   $criterio1="Mes : ".$mesh." Año: ".$mano;  
   $criterio1="DEL : ".$fecha_desde." AL ".$fecha_hasta;
   $sSQL = "SELECT *  FROM ".$criterio."  and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and
	  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_concepto>='".$cod_conceptod."' AND cod_concepto<='".$cod_conceptoh."')  and
	  (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."') and (cod_tipo_personal>='".$tipo_personal_d."' and cod_tipo_personal<='".$tipo_personal_h."') Order by tipo_nomina, cod_empleado, cod_concepto";
  
    $res=pg_query($sSQL);  $cod_empleado_grupo=""; $cod_concepto_grupo="";  $num_recibo="";	 $filas=pg_num_rows($res);
    if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"]; $num_recibo=$registro["num_recibo"]; $fechah=$registro["fechah"];   }
	  $tipo_letra='Arial'; $tipo_letra='Times'; 
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $num_recibo; global $tipo_letra; 
			$this->Ln(10);
			$this->SetFont($tipo_letra,'',8); 
			$this->Cell(100,5,'',0,0,'C');
			$this->Cell(70,5,$criterio1,0,0,'L');
			$this->Cell(30,5,$num_recibo,0,1,'L');
			$this->Ln(5);
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
		    global $sub_total_monto_asignacion; global $sub_total_monto_deduccion; global $sub_total_monto;
			global $fechah; global $nombre_banco_grupo; global $cta_empleado_grupo;
			$this->SetY(-130);
			$this->SetFont($tipo_letra,'',8); 
			$this->Ln(5);
			$this->Cell(130,4,'',0,0,'L');
		   	$this->Cell(20,4,$sub_total_monto_asignacion,0,0,'R'); 
			$this->Cell(5,4,'',0,0,'L');
		   	$this->Cell(20,4,$sub_total_monto_deduccion,0,1,'R'); 
			
			$this->Cell(155,4,'',0,0,'L');
		   	$this->Cell(20,4,$sub_total_monto,0,1,'R'); 
			$this->Ln(5);
			$this->Cell(10,4,'',0,0,'L');
			$this->Cell(90,4,$nombre_banco_grupo,0,0,'L');
			$this->Cell(60,4,$cta_empleado_grupo,0,0,'L');
			$this->Cell(40,4,$fechah,0,1,'L');
			
			$this->Ln(5);
			$this->Cell(200,4,'Trabajar en equipo no es una virtud, es una elección consciente y voluntaria que surge de los lazos de confianza ',0,1,'C');
			$this->Cell(200,4,'basados en la vulnerabilidad humana de los integrantes del equipo, ante errores, temores y dificultades.',0,1,'C');
		}
	  }	  
	  //$pdf = new FPDF('P', 'mm', array(215,180)); //tamaño pagina
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont($tipo_letra,'',8); 
	   $pdf->SetAutoPageBreak(true, 130); 
	  $i=0; $total_monto=0; $sub_total_monto_asignacion=0;  $sub_total_monto_deduccion=0; $sub_total_monto=0; $total_cantidad=0; $resultado1=0; $resultado2=0;   $resultado3=0;		 $prev_cod_empleado=""; $prev_cod_concepto=""; $prev_nombre="";   
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_empleado=$registro["cod_empleado"]; $cod_concepto=$registro["cod_concepto"]; $nombre=$registro["nombre"]; $num_recibo=$registro["num_recibo"];
          $denominacion=$registro["denominacion"];$cedula=$registro["cedula"]; $des_cargo=$registro["des_cargo"]; $fechai=$registro["fechai"]; $des_departam=$registro["des_departam"];  
	      $cod_categ=$registro["cod_categ"]; $fechad=$registro["fechad"]; $fechah=$registro["fechah"]; $sueldo_cargo=$registro["sueldo_cargo"]; $tipo_pago=$registro["tipo_pago"];
	      $nombre_banco=$registro["nombre_banco"];      $cta_empleado=$registro["cta_empleado"]; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
		  if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_cargo=utf8_decode($des_cargo); $nombre_banco=utf8_decode($nombre_banco);  $des_departam=utf8_decode($des_departam);  $nombre=utf8_decode($nombre); $denominacion=utf8_decode($denominacion);}
		  $cod_empleado_grupo=$cod_empleado; $cod_concepto_grupo=$cod_concepto; $nombre_grupo=$nombre; $denominacion_grupo=$denominacion; $cedula_grupo=$cedula; 
          $des_cargo_grupo=$des_cargo;  $fechai_grupo=$fechai;$des_departam_grupo=$des_departam; $cod_categ_grupo=$cod_categ; $fechad_grupo=$fechad; $fechah_grupo=$fechah; 
	      $sueldo_cargo_grupo=$sueldo_cargo;
           //$fechai=formato_ddmmaaaa($fechai); $fechad=formato_ddmmaaaa($fechad); $fechah=formato_ddmmaaaa($fechah);
          if(($prev_cod_concepto<>$cod_concepto_grupo)or($prev_cod_empleado<>$cod_empleado_grupo)){ 
			 if(($total_cantidad>0)or($resultado1>0)or($resultado2>0)or($resultado3>0)){ 
			    if($total_cantidad==0){$total_cantidad="";}else{$total_cantidad=formato_monto($total_cantidad);} 
				if($resultado1==0){$resultado1="";}else{$resultado1=formato_monto($resultado1); }
				if($resultado2==0){$resultado2="";}else{$resultado2=formato_monto($resultado2); } 
				if($resultado3==0){$resultado3="";}else{$resultado3=formato_monto($resultado3);	}
				$pdf->Cell(12,3,'',0,0,'L');
				$pdf->Cell(13,3,$prev_cod_concepto,0,0,'L');
		        $x=$pdf->GetX();   $y=$pdf->GetY();  $w=80;		   
		   		$pdf->SetXY($x+$w,$y);		   
		   		$pdf->Cell(20,3,$total_cantidad,0,0,'R'); 
				$pdf->Cell(5,3,'',0,0,'L');
		   		$pdf->Cell(20,3,$resultado1,0,0,'R'); 
				$pdf->Cell(5,3,'',0,0,'L');
		   		$pdf->Cell(20,3,$resultado2,0,1,'R'); 
		  		$pdf->SetXY($x,$y);	
		   		$pdf->MultiCell($w,3,$prev_denominacion,0); 
			 }	
			 $prev_cod_concepto=$cod_concepto_grupo; $prev_denominacion=$denominacion_grupo; $total_cantidad=0; $resultado1=0; $resultado2=0; $resultado3=0;}

		   if($prev_cod_empleado<>$cod_empleado_grupo){ 
			 if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){ $sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion);
                $sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto=formato_monto($sub_total_monto);	
				
				
				
                $pdf->AddPage();
			   }	$temp_sueldo=formato_monto($sueldo_cargo_grupo);
			   $pdf->Cell(10,3,'',0,0,'L');
			   $pdf->Cell(30,4,$cedula_grupo,0,0,'L');
			   $pdf->Cell(90,4,$nombre_grupo,0,0,'L');
			   $pdf->Cell(70,4,$des_cargo_grupo,0,1,'L');
			   $pdf->Ln(3);
			   $pdf->Cell(20,3,'',0,0,'L');
			   $pdf->Cell(80,4,$des_departam_grupo,0,0,'L');
			   $pdf->Cell(30,3,'',0,0,'L');
			   $pdf->Cell(20,4,$fechai_grupo,0,0,'L');
			   $pdf->Cell(50,4,$temp_sueldo,0,1,'L');	
			   $prev_cod_empleado=$cod_empleado_grupo; $prev_nombre=$nombre_grupo; $sub_total_monto_asignacion=0; $sub_total_monto_deduccion=0; $sub_total_monto=0; } 

		  $cod_empleado=$registro["cod_empleado"]; $cod_concepto=$registro["cod_concepto"]; $nombre=$registro["nombre"]; $denominacion=$registro["denominacion"];
		  $cedula=$registro["cedula"];  $des_cargo=$registro["des_cargo"]; $fechai=$registro["fechai"]; $des_departam=$registro["des_departam"]; $monto=$registro["monto"]; 
		  $cod_categ=$registro["cod_categ"]; $fechad=$registro["fechad"]; $fechah=$registro["fechah"]; $sueldo_cargo=$registro["sueldo_cargo"]; $saldo=$registro["saldo"]; 
		  $nombre_banco=$registro["nombre_banco"];  $cta_empleado=$registro["cta_empleado"]; $monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
          $cantidad=$registro["cantidad"]; $sub_total_monto_asignacion=$sub_total_monto_asignacion+$monto_asignacion; 
          $sub_total_monto_deduccion=$sub_total_monto_deduccion+$monto_deduccion;  $sub_total_monto=$sub_total_monto+$monto_asignacion-$monto_deduccion;
          $total_cantidad=$total_cantidad+$cantidad; $total_monto=$total_monto+$monto; 
          $resultado1=$resultado1+$monto_asignacion;$resultado2=$resultado2+$monto_deduccion;
          $nombre_banco_grupo=$nombre_banco; $cta_empleado_grupo=$cta_empleado;
          $monto_asignacion=formato_monto($monto_asignacion); $monto_deduccion=formato_monto($monto_deduccion); $cantidad=formato_monto($cantidad); $saldo=formato_monto($saldo);$monto=formato_monto($monto);
          $total_monto=formato_monto($total_monto);
		} 
		if(($total_cantidad>0)or($resultado1>0)or($resultado2>0)or($resultado3>0)){ 
			if($total_cantidad==0){$total_cantidad="";}else{$total_cantidad=formato_monto($total_cantidad);} 
			if($resultado1==0){$resultado1="";}else{$resultado1=formato_monto($resultado1); }
			if($resultado2==0){$resultado2="";}else{$resultado2=formato_monto($resultado2); } 
			if($resultado3==0){$resultado3="";}else{$resultado3=formato_monto($resultado3);	}
			$pdf->Cell(12,3,'',0,0,'L');
			$pdf->Cell(13,3,$prev_cod_concepto,0,0,'L');
			$x=$pdf->GetX();   $y=$pdf->GetY();  $w=80;		   
			$pdf->SetXY($x+$w,$y);		   
			$pdf->Cell(20,3,$total_cantidad,0,0,'R'); 
			$pdf->Cell(5,3,'',0,0,'L');
			$pdf->Cell(20,3,$resultado1,0,0,'R'); 
			$pdf->Cell(5,3,'',0,0,'L');
			$pdf->Cell(20,3,$resultado2,0,1,'R'); 
			$pdf->SetXY($x,$y);	
			$pdf->MultiCell($w,3,$prev_denominacion,0);  
		}	
		if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){ $sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion);
			$sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto=formato_monto($sub_total_monto);	
			
		}	
		$pdf->Output();  
	  
	  
}
?>
