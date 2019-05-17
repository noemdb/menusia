<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist="S";  $fecha_desde=$_GET["fecha_desde"]; $fecha_hasta=$_GET["fecha_hasta"]; $fecha_nom=$_GET["fecha_hasta"];    
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $tipo_concepto=$_GET["tipo_concepto"]; $tipo_personal_d=$_GET["tipo_personal_d"];   $tipo_personal_h=$_GET["tipo_personal_h"]; 
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"]; $forma_pago=$_GET["forma_pago"];
   $cod_empleado_d=$_GET["cod_empleado_d"]; $cod_empleado_h=$_GET["cod_empleado_h"]; $num_periodos=$_GET["num_periodos"]; $tipo_rpt="PDF"; $esp_firma="SI"; $salto_dep="NO"; $tipo_reporte='N'; $act_hist="N"; 
   $ordenar="  order by to_number(cedula,'999999999999'), cod_empleado, cod_concepto";
   $mes_desde=substr($fecha_desde,3,2); $mes_hasta=substr($fecha_hasta,3,2); $mano=substr($fecha_hasta,6,4); 
   $cfechan=formato_aaaammdd($fecha_hasta);       $dfechan=formato_aaaammdd($fecha_desde); $hfechan=formato_aaaammdd($fecha_hasta);   
if ($mes_desde=='01'){$mesd="Enero";}elseif ($mes_desde=='02'){$mesd="Febrero";}elseif ($mes_desde=='03'){$mesd="Marzo";}elseif ($mes_desde=='04'){$mesd="Abril";}elseif ($mes_desde=='05'){$mesd="Mayo";}elseif ($mes_desde=='06'){$mesd="Junio";}elseif ($mes_desde=='07'){$mesd="Julio";}elseif ($mes_desde=='08'){$mesd="Agosto";}elseif ($mes_desde=='09'){$mesd="Septiembre";}elseif ($mes_desde=='10'){$mesd="Octubre";}elseif ($mes_desde=='11'){$mesd="Noviembre";}elseif ($mes_desde=='12'){$mesd="Diciembre";}
if ($mes_hasta=='01'){$mesh="Enero";}elseif ($mes_hasta=='02'){$mesh="Febrero";}elseif ($mes_hasta=='03'){$mesh="Marzo";}elseif ($mes_hasta=='04'){$mesh="Abril";}elseif ($mes_hasta=='05'){$mesh="Mayo";}elseif ($mes_hasta=='06'){$mesh="Junio";}elseif ($mes_hasta=='07'){$mesh="Julio";}elseif ($mes_hasta=='08'){$mesh="Agosto";}elseif ($mes_hasta=='09'){$mesh="Septiembre";}elseif ($mes_hasta=='10'){$mesh="Octubre";}elseif ($mes_hasta=='11'){$mesh="Noviembre";}elseif ($mes_hasta=='12'){$mesh="Diciembre";}
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS'); </script> <?}
else{  $Nom_Emp=busca_conf(); $php_os=PHP_OS;  if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
    
   $cfechan=formato_aaaammdd($fecha_nom);  $Sql="";   $date = date("d-m-Y");   $hora = date("H:i:s a");
   $criterio="rpt_nom_cal WHERE (oculto<>'N') ";   $cri_tp=" and ((tp_calculo='N')or(tp_calculo='E'))  ";
   $sql="select fecha_p_hasta from nom017 where (fecha_p_hasta='".$cfechan."') and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') ".$cri_tp;
   $res=pg_query($sql); $filas=pg_num_rows($res); if($filas==0){$act_hist="S";  } 

   //$act_hist="S"; 
   $tipo_calculo="E"; $cod_conceptod="851"; $cod_conceptoh="851";
   
   if($tipo_calculo=="T"){ $cri_tp=" and ((tp_calculo='N')or(tp_calculo='E'))  "; } else { $cri_tp=" and (tp_calculo='".$tipo_calculo."') "; }  
   if($tipo_calculo=="E") { $cri_tp=" and ((tp_calculo='E')and(num_periodos=$num_periodos))  "; }
   
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
  
     //echo $sSQL;
      $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre=""; $prev_cedula=""; $prev_cod_empleado=""; $prev_cod_cat="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"];  $nombre=$registro["nombre"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];  	$cedula=$registro["cedula"];	$cod_categ=$registro["cod_categ"];		
        if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		$prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $prev_cedula=$cedula;
		$prev_cod_empleado=$cod_empleado; $prev_cod_cat=$cod_categ;
	  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tipo_nomina; global $des_nomina; global $fechad; global $fechah; global $cod_concepto; global $tipo_nomina_d; global $tipo_nomina_h;  global $criterio4; global $criterio3;
			$this->Image('../../imagenes/Logo_emp.png',7,7,16);
			$this->SetFont('Arial','B',11);
			$this->Cell(50);
			$this->Cell(100,7,"GARANTIA PRESTACIONES SOCIALES ART 142",1,0,'C');
			$this->Ln(17);
			$this->SetFont('Arial','B',9);
			if($tipo_nomina_d==$tipo_nomina_h){	$this->Cell(160,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');}
			//else{$this->Cell(160,5,$criterio3,0,1,'L');}			
			$this->Cell(160,5,$criterio1,0,1,'L');			
			$this->SetFillColor(192,192,192);
			$this->SetFont('Arial','B',8);
			$this->Cell(15,4,'CEDULA',1,0,'L',true);
			$this->Cell(145,4,'NOMBRE TRABAJADOR',1,0,'L',true);
			$this->Cell(10,4,'DIAS',1,0,'C',true);
			$this->Cell(20,4,'MONTO',1,1,'C',true);	
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
	  $pdf->SetFont('Arial','',8);
	  $i=0; $can_conc=0; $cant_emp=0; $cant_emp_dep=0;  
	  $tot1=0; $tot2=0; $tot3=0; $tot4=0; $tot5=0;  $tot6=0; $tot7=0; $tot8=0; $tot9=0; $tot10=0; $tot11=0; $tot12=0; $tot13=0; $tot14=0; $tot15=0;
	  $conc1=0; $conc2=0; $conc3=0; $conc4=0; $conc5=0; $conc6=0; $conc7=0; $conc8=0; $conc9=0; $conc10=0; $conc11=0; $conc12=0; $conc13=0; $conc14=0; $conc15=0;
	  $sub_tot1=0; $sub_tot2=0; $sub_tot3=0; $sub_tot4=0; $sub_tot5=0;  $sub_tot6=0; $sub_tot7=0; $sub_tot8=0; $sub_tot9=0; $sub_tot10=0; $sub_tot11=0; $sub_tot12=0; $sub_tot13=0; $sub_tot14=0; $sub_tot15=0;
	  //$pdf->MultiCell(200,3,$tsSQL,0); 
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_emp=$registro["cod_empleado"]; $tipo_nom=$registro["tipo_nomina"];	$cod_cat=$registro["cod_categ"];	
	    $cod_dep=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
		if($prev_cod_empleado<>$cod_emp){ 
		  if($conc2>0){$cant_emp=$cant_emp+1; $cant_emp_dep=$cant_emp_dep+1;
		    $tot1=$tot1+$conc1; $tot2=$tot2+$conc2; 	$sub_tot1=$sub_tot1+$conc1; $sub_tot2=$sub_tot2+$conc2; 
			$conc1=formato_monto($conc1); $conc2=formato_monto($conc2); 
		    $pdf->SetFont('Arial','',8);
			$pdf->Cell(15,4,$cedula,0,0);			
			//$x=$pdf->GetX();   $y=$pdf->GetY(); $w=145;		   
		    //$pdf->SetXY($x+$w,$y);
			$pdf->Cell(145,4,$nombre,0,0);			
            $pdf->Cell(10,4,$conc1,0,0,'R');			
			$pdf->Cell(20,4,$conc2,0,1,'R');                
            // $pdf->SetXY($x+$n,$y);	
		    //$pdf->MultiCell($w,4,$nombre,0); 
          }			
		  $prev_cod_empleado=$cod_emp;
		  $conc1=0; $conc2=0; $conc3=0; $conc4=0; $conc5=0; $conc6=0; $conc7=0; $conc8=0; $conc9=0; $conc10=0; $conc11=0; $conc12=0; $conc13=0; $conc14=0; $conc15=0;
		}
		$tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
         $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; $paso=$registro["paso"]; $grado=$registro["grado"];
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"]; $monto=$registro["monto"];
		$valoru=$registro["valoru"]; 
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_deduccion"]; $monto_deduccion=$registro["monto_aporte"];
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		If ($cod_concepto=='851'){ $conc1=$cantidad; $conc2=$conc2+$monto; }  
		
	  }		
	  if($conc2>0){ $cant_emp=$cant_emp+1; $cant_emp_dep=$cant_emp_dep+1;
	    $tot1=$tot1+$conc1; $tot2=$tot2+$conc2; 	$sub_tot1=$sub_tot1+$conc1; $sub_tot2=$sub_tot2+$conc2; 
		$conc1=formato_monto($conc1); $conc2=formato_monto($conc2);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(15,4,$cedula,0,0);			
		//$x=$pdf->GetX();   $y=$pdf->GetY(); $w=145;		   
		//$pdf->SetXY($x+$w,$y);
		$pdf->Cell(145,4,$nombre,0,0);			
		$pdf->Cell(10,4,$conc1,0,0,'R');			
		$pdf->Cell(20,4,$conc2,0,1,'R');                
		// $pdf->SetXY($x+$n,$y);	
		//$pdf->MultiCell($w,4,$nombre,0);
	  }	
	  $sub_tot1=formato_monto($sub_tot1); $sub_tot2=formato_monto($sub_tot2); 
	  $pdf->SetFont('Arial','B',9);
	  $pdf->Ln(3);
	  $tot1=formato_monto($tot1); $tot2=formato_monto($tot2); 
	  
	  $pdf->Cell(60,5,'NRO.TRABAJADORES : '.$cant_emp,0,0,'L');
	  $pdf->Cell(100,5,'TOTAL GENERAL : ',0,0,'R');
      $pdf->Cell(10,4,'    ','T',0);				
	  $pdf->Cell(20,4,$tot2,'T',1,'R');
	  $pdf->Ln(10);
		$pdf->SetFont('Arial','B',9); 
		$pdf->Cell(50,4,'',0,0,'L');
		$pdf->Cell(50,4,'CODIGO PRESUPUESTARIO','B',0,'L');
		$pdf->Cell(25,4,'MONTO','B',1,'C');
		$pdf->SetFont('Arial','',9);
		
		$sqld="SELECT cod_presup,asig_ded_apo,sum(monto) as monto FROM ".$criterio." and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and
	           (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_concepto>='".$cod_conceptod."' AND cod_concepto<='".$cod_conceptoh."')  and
	           (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."') and (cod_tipo_personal>='".$tipo_personal_d."' and cod_tipo_personal<='".$tipo_personal_h."') group by cod_presup,asig_ded_apo order by cod_presup,asig_ded_apo";
		$dtotala_conc=0; $dtotald_conc=0; $i=0;  $prev_cod=''; $prev_monto=0; $resd=pg_query($sqld); $filasd=pg_num_rows($resd);
		while($regd=pg_fetch_array($resd)){ $dneto=""; $sd=$sd+1; if($i==0){$prev_cod=$regd["cod_presup"]; $prev_monto=0; }
		   $dcod_presup=$regd["cod_presup"]; $dmonto_pre=$regd["monto"]; $asig_ded_apo=$regd["asig_ded_apo"];
		   if($prev_cod<>$regd["cod_presup"]){
		     $prev_monto=formato_monto($prev_monto);
		     $pdf->Cell(50,4,'',0,0);
		     $pdf->Cell(50,4,$prev_cod,0,0,'L');
		     $pdf->Cell(25,4,$prev_monto,0,1,'R');
			 $prev_cod=$regd["cod_presup"]; $prev_monto=0;
		   }
		   if($asig_ded_apo=="A"){$prev_monto=$prev_monto+$dmonto_pre;} else{$prev_monto=$prev_monto-$dmonto_pre;}
		   $i=$i+1;
		}
		$prev_monto=formato_monto($prev_monto);
		$pdf->Cell(50,4,'',0,0);
		$pdf->Cell(50,4,$prev_cod,0,0,'L');
		$pdf->Cell(25,4,$prev_monto,0,1,'R');
	  
	  $y=$pdf->GetY();  $t=10;
        if($y>240){$t=10; $pdf->Cell(5,4,'',0,1);  } 
        $pdf->ln($t); $y=$pdf->GetY();
	    if($y<250){$t=250-$y; $pdf->ln($t);} 
		$pdf->SetFont('Arial','',7);
        $pdf->Cell(40,4,'Elaborado por Analista','T',0,'C');
        $pdf->Cell(10,4,'',0,0);
        $pdf->Cell(40,4,'Revisado por','T',0,'C');
        $pdf->Cell(10,4,'',0,0);
		$pdf->Cell(40,4,'Conformado por ','T',0,'C');
        $pdf->Cell(10,4,'',0,0);
        $pdf->Cell(40,4,'Aprobado por Contralor(a)','T',1,'C');
		
        $pdf->Cell(50,3,' ',0,0,'C');
		$pdf->Cell(40,3,'Dir. Recursos Humanos y Capacitacion',0,0,'C');
		$pdf->Cell(10,4,'',0,0);
        $pdf->Cell(40,3,'Dir. Administracion y Presupuesto',0,0,'C');
        $pdf->Cell(10,4,'',0,0);		
        $pdf->Cell(40,3,'Interventora de la CEBM',0,1,'C'); 
	  
	  $pdf->Output(); 
}
?>
