<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist="S";  $fecha_desde=$_GET["fecha_desde"]; $fecha_hasta=$_GET["fecha_hasta"]; $fecha_nom=$_GET["fecha_hasta"];    
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $tipo_concepto=$_GET["tipo_concepto"]; $tipo_personal_d=$_GET["tipo_personal_d"];   $tipo_personal_h=$_GET["tipo_personal_h"]; 
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"]; $forma_pago=$_GET["forma_pago"];
   $cod_presup_catd=$_GET["cod_presup_catd"];  $cod_presup_cath=$_GET["cod_presup_cath"]; $cod_empleado_d=$_GET["cod_empleado_d"];  $cod_empleado_h=$_GET["cod_empleado_h"];
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
   $criterio=$criterio." and (cod_concepto='001' or cod_concepto='002' or cod_concepto='507' or cod_concepto='907')";
   $criterio=$criterio."  and (cod_categ>='".$cod_presup_catd."' and cod_categ<='".$cod_presup_cath."')";   
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
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tipo_nomina; global $des_nomina; global $fechad; global $fechah; global $cod_concepto; global $tipo_nomina_d; global $tipo_nomina_h;  global $criterio4; global $criterio3;
			$this->Image('../../imagenes/Logo_emp.png',7,7,40);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(150,7,"RELACION DE TESORERIA NACIONAL",0,0,'C');
			$this->Ln(17);
			$this->SetFont('Arial','B',10);
			//if($tipo_nomina_d==$tipo_nomina_h){	$this->Cell(160,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');}			else{$this->Cell(160,5,$criterio3,0,1,'L');}			
			$this->Cell(160,5,$criterio1,0,1,'L');
			$this->SetFont('Arial','B',8);
			$this->SetFillColor(192,192,192);
			$this->Cell(106,4,'','LTR',0,'L',true);
			$this->Cell(14,4,'','TR',0,'L',true);
			$this->Cell(20,4,'SUELDO +','TR',0,'C',true);
			$this->Cell(20,4,'MONTO','TR',0,'C',true);
			$this->Cell(20,4,'APORTE','TR',0,'C',true);
			$this->Cell(20,4,'TOTAL A','TR',1,'C',true);
            $this->Cell(106,4,'NOMBRE TRABAJADOR','LBR',0,'L',true);
			$this->Cell(14,4,'CEDULA','BR',0,'L',true);			
			$this->Cell(20,4,'COMPENSAC.','BR',0,'C',true);	
            $this->Cell(20,4,'RETENIDO','BR',0,'C',true);			
			$this->Cell(20,4,'PATRONAL','BR',0,'C',true);
			$this->Cell(20,4,'PAGAR','BR',1,'C',true);					   
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
	  $i=0; $can_conc=0; $cant_emp=0;  $tot1=0; $tot2=0; $tot3=0; $tot4=0; $tot5=0; $tot6=0; $conc1=0; $conc2=0; $conc3=0; $conc4=0; $conc5=0; $conc6=0;
	  $sub_tot1=0; $sub_tot2=0; $sub_tot3=0; $sub_tot4=0; $sub_tot5=0; $sub_tot6=0;
	  //$pdf->MultiCell(200,3,$sSQL,0); 
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_emp=$registro["cod_empleado"]; $tipo_nom=$registro["tipo_nomina"];	$cod_cat=$registro["cod_categ"];	
		if($prev_cod_empleado<>$cod_emp){ 
		    if($conc5<>0){$cant_emp=$cant_emp+1;
		    $tot1=$tot1+$conc1; $tot2=$tot2+$conc2; $tot3=$tot3+$conc3; $tot4=$tot4+$conc4; $tot5=$tot5+$conc5; $tot6=$tot6+$conc6; 
			$sub_tot1=$sub_tot1+$conc1; $sub_tot2=$sub_tot2+$conc2; $sub_tot3=$sub_tot3+$conc3; $sub_tot4=$sub_tot4+$conc4; $sub_tot5=$sub_tot5+$conc5; $sub_tot6=$sub_tot6+$conc6; 
			$conc1=formato_monto($conc1); $conc2=formato_monto($conc2); $conc3=formato_monto($conc3); $conc4=formato_monto($conc4); $conc5=formato_monto($conc5); $conc6=formato_monto($conc6);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(106,4,$nombre,0,0);
            $pdf->Cell(14,4,$cedula,0,0);	
			$pdf->Cell(20,4,$conc6,0,0,'R');
			$pdf->Cell(20,4,$conc3,0,0,'R');
			$pdf->Cell(20,4,$conc4,0,0,'R');
			$pdf->Cell(20,4,$conc5,0,1,'R');  }
			$prev_cod_empleado=$cod_emp;
			$conc1=0; $conc2=0; $conc3=0; $conc4=0; $conc5=0; $conc6=0; $nomb_cat="";			
		}
		$tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"]; $monto=$registro["monto"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_deduccion"]; $monto_deduccion=$registro["monto_aporte"];
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		$mdia=substr($fechah,0,2);
		if(($cod_concepto=="507")and($mdia=="15")) { $conc1=$conc1+$monto; }
		if(($cod_concepto=="507")and($mdia<>"15"))  { $conc2=$conc2+$monto; }
		if($cod_concepto=="507") { $conc3=$conc3+$monto; }
		if($cod_concepto=="907") { $conc4=$conc4+$monto; }
		if(($cod_concepto=="001")OR($cod_concepto=="002")) { $conc6=$conc6+$monto; }
		$conc5=$conc3+$conc4; 
	  }		
	  if($conc5<>0){	  
	        $tot1=$tot1+$conc1; $tot2=$tot2+$conc2; $tot3=$tot3+$conc3; $tot4=$tot4+$conc4; $tot5=$tot5+$conc5; $tot6=$tot6+$conc6; $cant_emp=$cant_emp+1;
			$sub_tot1=$sub_tot1+$conc1; $sub_tot2=$sub_tot2+$conc2; $sub_tot3=$sub_tot3+$conc3; $sub_tot4=$sub_tot4+$conc4; $sub_tot5=$sub_tot5+$conc5; $sub_tot6=$sub_tot6+$conc6; 
			$conc1=formato_monto($conc1); $conc2=formato_monto($conc2); $conc3=formato_monto($conc3); $conc4=formato_monto($conc4); $conc5=formato_monto($conc5); $conc6=formato_monto($conc6);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(106,4,$nombre,0,0);
            $pdf->Cell(14,4,$cedula,0,0);			
			$pdf->Cell(20,4,$conc6,0,0,'R');
			$pdf->Cell(20,4,$conc3,0,0,'R');
			$pdf->Cell(20,4,$conc4,0,0,'R');
			$pdf->Cell(20,4,$conc5,0,1,'R'); 
	  }		
		$pdf->Ln(2);
		$tot1=formato_monto($tot1); $tot2=formato_monto($tot2); $tot3=formato_monto($tot3); $tot4=formato_monto($tot4); $tot5=formato_monto($tot5); $tot6=formato_monto($tot6);
		$pdf->Cell(120,0.5,' ',0,0,'R');
		$pdf->Cell(20,0.5,'','T',0,'R');
		$pdf->Cell(20,0.5,'','T',0,'R');
		$pdf->Cell(20,0.5,'','T',0,'R');
		$pdf->Cell(20,0.5,'','T',1,'R');
		$pdf->Cell(20,5,'NRO.TRABAJDORES : '.$cant_emp,0,0,'L');
		$pdf->Cell(100,5,'TOTAL GENERAL : ',0,0,'R');			
		$pdf->Cell(20,5,$tot6,'T',0,'R');
		$pdf->Cell(20,5,$tot3,'T',0,'R');
		$pdf->Cell(20,5,$tot4,'T',0,'R');
		$pdf->Cell(20,5,$tot5,'T',1,'R');  
	$pdf->Output(); 
}
?>
