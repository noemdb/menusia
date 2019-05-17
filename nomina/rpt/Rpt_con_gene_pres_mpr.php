<? include ("../../class/conect.php");  require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php");  include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nominad=$_GET["tipo_nominad"]; $tipo_nominah=$_GET["tipo_nominah"];    $fecha_h=$_GET["fecha_h"];   $estatus=$_GET["estatus"];
   $dpto_esp=$_GET["dpto_esp"]; $cod_departamento=$_GET["cod_departamento"]; $tipo_reporte=$_GET["tipo_reporte"]; $tipo_rpt=$_GET["tipo_rpt"];  
   $Sql="";   $date=date("d-m-Y");   $hora=date("h:i:s a"); $criterio1="";
   if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;
   
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
    $criterio=" (nom006.cod_empleado=nom030.cod_empleado) and ((nom030.tipo_calculo='P') or (nom030.tipo_calculo='S')) and (nom006.tipo_nomina>='".$tipo_nominad."' and nom006.tipo_nomina<='".$tipo_nominah."') and nom030.fecha_calculo<='".$fecha_hasta."'";
    if (($estatus=='TODOS'))  { $criterio=$criterio; } else {  $criterio=$criterio." AND nom006.status ='".$estatus."'";  }
	if($dpto_esp=="SI"){ $criterio=$criterio." AND nom006.cod_departam ='".$cod_departamento."'"; }
    $sSQL = "SELECT nom006.nombre,nom006.cedula,nom006.fecha_ingreso,nom030.cod_empleado,nom030.fecha_calculo,nom030.num_calculo,nom030.tipo_calculo,nom030.sueldo_calculo,nom030.dias_prestaciones,nom030.c_prestaciones,nom030.sueldo_calculo_adic,nom030.dias_adicionales,nom030.c_presta_adic,nom030.monto_prestaciones,nom030.total_prestaciones,nom030.monto_adelanto,nom030.total_adelanto,
	         nom030.monto_prestamo,nom030.total_prestamo,nom030.saldo_prestaciones,nom030.interes_devengado,nom030.interes_noacum,nom030.interes_acum,nom030.interes_pagado,nom030.total_interes,nom030.tasa_interes,nom030.tiempo_variacion,nom030.acumulado_total,to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as fechai, to_char(nom030.fecha_calculo,'DD/MM/YYYY') as fechac  
			 FROM nom030,nom006 WHERE ".$criterio." ORDER BY nom030.cod_empleado,nom030.fecha_calculo,nom030.num_calculo";
			 
	
	if($tipo_rpt=="PDF"){ if($tipo_reporte=="RESUMEN DE PRESTACIONES"){ $tipo_rpt="PDF2"; } if($tipo_reporte=="RESUMEN DE INTERESES"){ $tipo_rpt="PDF3"; } }
	
    if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_con_gene_pres_mpr_re.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("$host");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"fecha_h"=>$fecha_h,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();
    }
	if($tipo_rpt=="PDF"){ $res=pg_query($sSQL); $filas=pg_num_rows($res); $mes=""; $periodof=""; $cod_empleado_grupo=""; 	$nombre_grupo="";  $cedula_grupo=""; $fechai_grupo=""; $prev_cod_empleado=""; 
	  if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; 
	    $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; $prev_cod_empleado=$cod_empleado; 
		$mes=substr($registro["fechac"],3,2); $periodof=Calcula_dif_fechas($fechai,$fecha_h);
	  }
	
	  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1;  global $fecha_h; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(60);
			$this->Cell(140,7,'CONTROL GENERAL DE PRESTACIONES E INTERESES AL '.$fecha_h,1,0,'C');
			$this->Ln(20);			
			$this->SetFont('Arial','B',7);
			$this->Cell(15,4,'Codigo ','RTL',0,'C');
			$this->Cell(55,4,'','RTL',0,'C');
			$this->Cell(15,4,'Fecha ','RTL',0,'C');
			$this->Cell(15,4,'Fecha Ult.','RTL',0,'C');
			$this->Cell(20,4,'Total','RT',0,'C');
			$this->Cell(20,4,'Total','RT',0,'C');
			$this->Cell(20,4,'Saldo','RT',0,'C');
			$this->Cell(20,4,'Interes No','RT',0,'C');
			$this->Cell(20,4,'Interes','RT',0,'C');
			$this->Cell(20,4,'Total','RT',0,'C');
			$this->Cell(20,4,'Acumulado ','RT',0,'C');
			$this->Cell(20,4,'','TRL',1,'C');
			
			$this->Cell(15,4,'Trabajador','BLR',0,'C');
			$this->Cell(55,4,'Nombre Tabajador ','BR',0,'C');
			$this->Cell(15,4,'Ingreso','BR',0,'C');
			$this->Cell(15,4,'Calculo','BR',0,'C');
			$this->Cell(20,4,'Prestaciones','BR',0,'C');
			$this->Cell(20,4,'Adelanto ','BR',0,'C');
			$this->Cell(20,4,'Prestaciones','BR',0,'C');
			$this->Cell(20,4,'Capitalizado','BR',0,'C');
			$this->Cell(20,4,'Capitalizado','BR',0,'C');
			$this->Cell(20,4,'Interes','BR',0,'C');
			$this->Cell(20,4,'Total ','BR',0,'C');
			$this->Cell(20,4,'Saldo','BRL',1,'C');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('L', 'mm', Letter);  
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',8);
	  $i=0; $cant_trab=0; $Gtotal_prest=0; $Gtotal_adelanto=0; $Gtotal_saldo_p=0; $Gtotal_interes_noacum=0; $Gtotal_interes_acum=0; $Gtotal_interes=0; $Gtotal_acumulado=0; $Gtotal_saldo=0;
	  $suma_dias=0;$suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0;
	 // $pdf->MultiCell(260,4,$sSQL,0);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_empleado_grupo=$registro["cod_empleado"];
		if($prev_cod_empleado<>$cod_empleado_grupo){  $saldo=$acumulado_total+$interes_noacum;  $prev_cod_empleado=$cod_empleado_grupo;
		    $Gtotal_prest=$Gtotal_prest+$total_prestaciones; 	$Gtotal_adelanto=$Gtotal_adelanto+$total_adelanto; 
			$Gtotal_saldo_p=$Gtotal_saldo_p+$saldo_prestaciones; $Gtotal_interes_noacum=$Gtotal_interes_noacum+$interes_noacum; 
			$Gtotal_interes_acum=$Gtotal_interes_acum+$interes_acum; 	$Gtotal_acumulado=$Gtotal_acumulado+$acumulado_total; 
			$Gtotal_interes=$Gtotal_interes+$total_interes; $Gtotal_saldo=$Gtotal_saldo+$saldo; $cant_trab=$cant_trab+1;
		    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
			$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
			$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
			$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
			$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
			$suma_c_prestaciones=formato_monto($suma_c_prestaciones); $total_prestaciones=formato_monto($total_prestaciones);
		    $suma_monto_adelanto=formato_monto($suma_monto_adelanto); $suma_interes_devengado=formato_monto($suma_interes_devengado);
		    $suma_interes_pagado=formato_monto($suma_interes_pagado); $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(14,4,$cod_empleado,0,0,'L');
			$pdf->Cell(56,4,$nombre,0,0,'L');
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,4,$fechai,0,0,'C');
			$pdf->Cell(15,4,$fechac,0,0,'C');  			
			$pdf->Cell(20,4,$total_prestaciones,0,0,'R');			
			$pdf->Cell(20,4,$total_adelanto,0,0,'R');
			$pdf->Cell(20,4,$saldo_prestaciones,0,0,'R');			
			$pdf->Cell(20,4,$interes_noacum,0,0,'R');
			$pdf->Cell(20,4,$interes_acum,0,0,'R');
			$pdf->Cell(20,4,$total_interes,0,0,'R');
			$pdf->Cell(20,4,$acumulado_total,0,0,'R');
			$pdf->Cell(20,4,$saldo,0,1,'R');
		    $prev_mes=$mes; $suma_dias=0;$suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0;
		}
		$cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $nombre=substr($nombre,0,39);
	    $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; $mes=substr($registro["fechac"],3,2);
	    $fechac=$registro["fechac"]; $num_calculo=$registro["num_calculo"];  $sueldo_calculo=$registro["sueldo_calculo"];  $sueldo_dia=($registro["sueldo_calculo"]/30);
	    $dias_prestaciones=$registro["dias_prestaciones"]; $c_prestaciones=$registro["c_prestaciones"]; $sueldo_calculo_adic=$registro["sueldo_calculo_adic"];  $sueldo_dia_adic=($registro["sueldo_calculo_adic"]/30);
		$dias_adicionales=$registro["dias_adicionales"]; $c_presta_adic=$registro["c_presta_adic"]; $monto_prestaciones=$registro["monto_prestaciones"]; 
		$total_prestaciones=$registro["total_prestaciones"]; $monto_adelanto=$registro["monto_adelanto"]; $total_adelanto=$registro["total_adelanto"];
		$interes_devengado=$registro["interes_devengado"]; $interes_noacum=$registro["interes_noacum"]; $interes_acum=$registro["interes_acum"]; 
		$interes_pagado=$registro["interes_pagado"];  $total_interes=$registro["total_interes"]; $tasa_interes=$registro["tasa_interes"]; 
		$tiempo_variacion=$registro["tiempo_variacion"]; $acumulado_total=$registro["acumulado_total"]; $tipo_calculo=$registro["tipo_calculo"];
		$saldo_prestaciones=$registro["saldo_prestaciones"];		
		$t_prestaciones=$total_prestaciones-$c_presta_adic;
		if($tipo_calculo=="P"){ $suma_dias=$suma_dias+$dias_prestaciones+$dias_adicionales; }
		$suma_c_prestaciones=$suma_c_prestaciones+$c_prestaciones+$c_presta_adic;
		$suma_monto_adelanto=$suma_monto_adelanto+$monto_adelanto;
		$suma_interes_devengado=$suma_interes_devengado+$interes_devengado;
		$suma_interes_pagado=$suma_interes_pagado+$interes_pagado;
      }
	  if($i>0){ $saldo=$acumulado_total+$interes_noacum;  
	    $Gtotal_prest=$Gtotal_prest+$total_prestaciones; 	$Gtotal_adelanto=$Gtotal_adelanto+$total_adelanto; 
		$Gtotal_saldo_p=$Gtotal_saldo_p+$saldo_prestaciones; $Gtotal_interes_noacum=$Gtotal_interes_noacum+$interes_noacum; 
		$Gtotal_interes_acum=$Gtotal_interes_acum+$interes_acum; 	$Gtotal_acumulado=$Gtotal_acumulado+$acumulado_total; 
		$Gtotal_interes=$Gtotal_interes+$total_interes; $Gtotal_saldo=$Gtotal_saldo+$saldo;  $cant_trab=$cant_trab+1;
	    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
		$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
		$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
		$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
		$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
		$suma_c_prestaciones=formato_monto($suma_c_prestaciones);  $total_prestaciones=formato_monto($total_prestaciones);
		$suma_monto_adelanto=formato_monto($suma_monto_adelanto);	$suma_interes_devengado=formato_monto($suma_interes_devengado);
		$suma_interes_pagado=formato_monto($suma_interes_pagado);  $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(14,4,$cod_empleado,0,0,'L');
		$pdf->Cell(56,4,$nombre,0,0,'L');
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(15,4,$fechai,0,0,'C');
		$pdf->Cell(15,4,$fechac,0,0,'C');  			
		$pdf->Cell(20,4,$total_prestaciones,0,0,'R');			
		$pdf->Cell(20,4,$total_adelanto,0,0,'R');
		$pdf->Cell(20,4,$saldo_prestaciones,0,0,'R');			
		$pdf->Cell(20,4,$interes_noacum,0,0,'R');
		$pdf->Cell(20,4,$interes_acum,0,0,'R');
		$pdf->Cell(20,4,$total_interes,0,0,'R');
		$pdf->Cell(20,4,$acumulado_total,0,0,'R');
		$pdf->Cell(20,4,$saldo,0,1,'R');
	  }
	  $Gtotal_prest=formato_monto($Gtotal_prest); 	$Gtotal_adelanto=formato_monto($Gtotal_adelanto); 
	  $Gtotal_saldo_p=formato_monto($Gtotal_saldo_p); $Gtotal_interes_noacum=formato_monto($Gtotal_interes_noacum); 
	  $Gtotal_interes_acum=formato_monto($Gtotal_interes_acum); 	$Gtotal_acumulado=formato_monto($Gtotal_acumulado); 
      $Gtotal_interes=formato_monto($Gtotal_interes); $Gtotal_saldo=formato_monto($Gtotal_saldo);
	  $pdf->SetFont('Arial','B',8);
	  $pdf->Cell(100,2,'',0,0);
	  $pdf->Cell(20,2,'============',0,0,'R');
	  $pdf->Cell(20,2,'============',0,0,'R');
	  $pdf->Cell(20,2,'============',0,0,'R');
	  $pdf->Cell(20,2,'============',0,0,'R');
	  $pdf->Cell(20,2,'============',0,0,'R');
	  $pdf->Cell(20,2,'============',0,0,'R');
	  $pdf->Cell(20,2,'============',0,0,'R');
      $pdf->Cell(20,2,'============',0,1,'R');
	  
	  $pdf->Cell(50,5,"Nro. Trabjadores ".$cant_trab,0,0,'L');
	  $pdf->Cell(50,5,'TOTALES :',0,0,'R');	
	  $pdf->Cell(20,5,$Gtotal_prest,0,0,'R');			
	  $pdf->Cell(20,5,$Gtotal_adelanto,0,0,'R');
	  $pdf->Cell(20,5,$Gtotal_saldo_p,0,0,'R');			
	  $pdf->Cell(20,5,$Gtotal_interes_noacum,0,0,'R');
	  $pdf->Cell(20,5,$Gtotal_interes_acum,0,0,'R');
	  $pdf->Cell(20,5,$Gtotal_interes,0,0,'R');
	  $pdf->Cell(20,5,$Gtotal_acumulado,0,0,'R');
	  $pdf->Cell(20,5,$Gtotal_saldo,0,1,'R');
	  $pdf->Output(); 
    }
	
	if($tipo_rpt=="PDF2"){ $res=pg_query($sSQL); $filas=pg_num_rows($res); $mes=""; $periodof=""; $cod_empleado_grupo=""; 	$nombre_grupo="";  $cedula_grupo=""; $fechai_grupo=""; $prev_cod_empleado=""; 
	  if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; 
	    $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; $prev_cod_empleado=$cod_empleado; 
		$mes=substr($registro["fechac"],3,2); $periodof=Calcula_dif_fechas($fechai,$fecha_h);
	  }	
	  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1;  global $fecha_h; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,7,'CONTROL GENERAL DE PRESTACIONES AL '.$fecha_h,1,0,'C');
			$this->Ln(20);			
			$this->SetFont('Arial','B',7);
			$this->Cell(15,4,'Codigo ','RTL',0,'C');
			$this->Cell(95,4,'','RTL',0,'C');
			$this->Cell(15,4,'Fecha ','RTL',0,'C');
			$this->Cell(15,4,'Fecha Ult.','RTL',0,'C');
			$this->Cell(20,4,'Total','RT',0,'C');
			$this->Cell(20,4,'Total','RT',0,'C');
			$this->Cell(20,4,'Saldo','TRL',1,'C');
			$this->Cell(15,4,'Trabajador','BLR',0,'C');
			$this->Cell(95,4,'Nombre Tabajador ','BR',0,'C');
			$this->Cell(15,4,'Ingreso','BR',0,'C');
			$this->Cell(15,4,'Calculo','BR',0,'C');
			$this->Cell(20,4,'Prestaciones','BR',0,'C');
			$this->Cell(20,4,'Adelanto ','BR',0,'C');
			$this->Cell(20,4,'Prestaciones','BRL',1,'C');
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
	  $i=0; $cant_trab=0; $Gtotal_prest=0; $Gtotal_adelanto=0; $Gtotal_saldo_p=0; $Gtotal_interes_noacum=0; $Gtotal_interes_acum=0; $Gtotal_interes=0; $Gtotal_acumulado=0; $Gtotal_saldo=0;
	  $suma_dias=0;$suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0;
	  //$pdf->MultiCell(260,4,$sSQL,0);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_empleado_grupo=$registro["cod_empleado"];
		if($prev_cod_empleado<>$cod_empleado_grupo){  $saldo=$acumulado_total+$interes_noacum;  $prev_cod_empleado=$cod_empleado_grupo;
		    $Gtotal_prest=$Gtotal_prest+$total_prestaciones; 	$Gtotal_adelanto=$Gtotal_adelanto+$total_adelanto; 
			$Gtotal_saldo_p=$Gtotal_saldo_p+$saldo_prestaciones; $Gtotal_interes_noacum=$Gtotal_interes_noacum+$interes_noacum; 
			$Gtotal_interes_acum=$Gtotal_interes_acum+$interes_acum; 	$Gtotal_acumulado=$Gtotal_acumulado+$acumulado_total; 
			$Gtotal_interes=$Gtotal_interes+$total_interes; $Gtotal_saldo=$Gtotal_saldo+$saldo; $cant_trab=$cant_trab+1;
		    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
			$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
			$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
			$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
			$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
			$suma_c_prestaciones=formato_monto($suma_c_prestaciones); $total_prestaciones=formato_monto($total_prestaciones);
		    $suma_monto_adelanto=formato_monto($suma_monto_adelanto); $suma_interes_devengado=formato_monto($suma_interes_devengado);
		    $suma_interes_pagado=formato_monto($suma_interes_pagado); $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(15,4,$cod_empleado,0,0,'L');
			$pdf->Cell(95,4,$nombre,0,0,'L');
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,4,$fechai,0,0,'C');
			$pdf->Cell(15,4,$fechac,0,0,'C');  			
			$pdf->Cell(20,4,$total_prestaciones,0,0,'R');			
			$pdf->Cell(20,4,$total_adelanto,0,0,'R');
			$pdf->Cell(20,4,$saldo_prestaciones,0,1,'R');
		    $prev_mes=$mes; $suma_dias=0;$suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0;
		}
		$cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $nombre=substr($nombre,0,75);
	    $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; $mes=substr($registro["fechac"],3,2);
	    $fechac=$registro["fechac"]; $num_calculo=$registro["num_calculo"];  $sueldo_calculo=$registro["sueldo_calculo"];  $sueldo_dia=($registro["sueldo_calculo"]/30);
	    $dias_prestaciones=$registro["dias_prestaciones"]; $c_prestaciones=$registro["c_prestaciones"]; $sueldo_calculo_adic=$registro["sueldo_calculo_adic"];  $sueldo_dia_adic=($registro["sueldo_calculo_adic"]/30);
		$dias_adicionales=$registro["dias_adicionales"]; $c_presta_adic=$registro["c_presta_adic"]; $monto_prestaciones=$registro["monto_prestaciones"]; 
		$total_prestaciones=$registro["total_prestaciones"]; $monto_adelanto=$registro["monto_adelanto"]; $total_adelanto=$registro["total_adelanto"];
		$interes_devengado=$registro["interes_devengado"]; $interes_noacum=$registro["interes_noacum"]; $interes_acum=$registro["interes_acum"]; 
		$interes_pagado=$registro["interes_pagado"];  $total_interes=$registro["total_interes"]; $tasa_interes=$registro["tasa_interes"]; 
		$tiempo_variacion=$registro["tiempo_variacion"]; $acumulado_total=$registro["acumulado_total"]; $tipo_calculo=$registro["tipo_calculo"];
		$saldo_prestaciones=$registro["saldo_prestaciones"];		
		$t_prestaciones=$total_prestaciones-$c_presta_adic;
		if($tipo_calculo=="P"){ $suma_dias=$suma_dias+$dias_prestaciones+$dias_adicionales; }
		$suma_c_prestaciones=$suma_c_prestaciones+$c_prestaciones+$c_presta_adic;
		$suma_monto_adelanto=$suma_monto_adelanto+$monto_adelanto;
		$suma_interes_devengado=$suma_interes_devengado+$interes_devengado;
		$suma_interes_pagado=$suma_interes_pagado+$interes_pagado;
      }
	  if($i>0){ $saldo=$acumulado_total+$interes_noacum;  
	    $Gtotal_prest=$Gtotal_prest+$total_prestaciones; 	$Gtotal_adelanto=$Gtotal_adelanto+$total_adelanto; 
		$Gtotal_saldo_p=$Gtotal_saldo_p+$saldo_prestaciones; $Gtotal_interes_noacum=$Gtotal_interes_noacum+$interes_noacum; 
		$Gtotal_interes_acum=$Gtotal_interes_acum+$interes_acum; 	$Gtotal_acumulado=$Gtotal_acumulado+$acumulado_total; 
		$Gtotal_interes=$Gtotal_interes+$total_interes; $Gtotal_saldo=$Gtotal_saldo+$saldo;  $cant_trab=$cant_trab+1;
	    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
		$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
		$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
		$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
		$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
		$suma_c_prestaciones=formato_monto($suma_c_prestaciones);  $total_prestaciones=formato_monto($total_prestaciones);
		$suma_monto_adelanto=formato_monto($suma_monto_adelanto);	$suma_interes_devengado=formato_monto($suma_interes_devengado);
		$suma_interes_pagado=formato_monto($suma_interes_pagado);  $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(15,4,$cod_empleado,0,0,'L');
		$pdf->Cell(95,4,$nombre,0,0,'L');
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(15,4,$fechai,0,0,'C');
		$pdf->Cell(15,4,$fechac,0,0,'C');  			
		$pdf->Cell(20,4,$total_prestaciones,0,0,'R');			
		$pdf->Cell(20,4,$total_adelanto,0,0,'R');
		$pdf->Cell(20,4,$saldo_prestaciones,0,1,'R');
	  }
	  $Gtotal_prest=formato_monto($Gtotal_prest); 	$Gtotal_adelanto=formato_monto($Gtotal_adelanto); 
	  $Gtotal_saldo_p=formato_monto($Gtotal_saldo_p); $Gtotal_interes_noacum=formato_monto($Gtotal_interes_noacum); 
	  $Gtotal_interes_acum=formato_monto($Gtotal_interes_acum); 	$Gtotal_acumulado=formato_monto($Gtotal_acumulado); 
      $Gtotal_interes=formato_monto($Gtotal_interes); $Gtotal_saldo=formato_monto($Gtotal_saldo);
	  $pdf->SetFont('Arial','B',8);
	  $pdf->Cell(140,2,'',0,0);
	  $pdf->Cell(20,2,'============',0,0,'R');
	  $pdf->Cell(20,2,'============',0,0,'R');
      $pdf->Cell(20,2,'============',0,1,'R');
	  $pdf->Cell(50,5,"Nro. Trabjadores ".$cant_trab,0,0,'L');
	  $pdf->Cell(90,5,'TOTALES :',0,0,'R');	
	  $pdf->Cell(20,5,$Gtotal_prest,0,0,'R');			
	  $pdf->Cell(20,5,$Gtotal_adelanto,0,0,'R');
	  $pdf->Cell(20,5,$Gtotal_saldo_p,0,1,'R');	
	  $pdf->Output(); 
    }
	
	if($tipo_rpt=="PDF3"){ $res=pg_query($sSQL); $filas=pg_num_rows($res); $mes=""; $periodof=""; $cod_empleado_grupo=""; 	$nombre_grupo="";  $cedula_grupo=""; $fechai_grupo=""; $prev_cod_empleado=""; 
	  if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; 
	    $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; $prev_cod_empleado=$cod_empleado; 
		$mes=substr($registro["fechac"],3,2); $periodof=Calcula_dif_fechas($fechai,$fecha_h);
	  }	
	  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1;  global $fecha_h; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,7,'CONTROL GENERAL DE INTERESES AL '.$fecha_h,1,0,'C');
			$this->Ln(20);			
			$this->SetFont('Arial','B',7);
			$this->Cell(15,4,'Codigo ','RTL',0,'C');
			$this->Cell(95,4,'','RTL',0,'C');
			$this->Cell(15,4,'Fecha ','RTL',0,'C');
			$this->Cell(15,4,'Fecha Ult.','RTL',0,'C');
			$this->Cell(20,4,'Interes No','RT',0,'C');
			$this->Cell(20,4,'Interes','RT',0,'C');
			$this->Cell(20,4,'Total','TRL',1,'C');
			
			
			$this->Cell(15,4,'Trabajador','BLR',0,'C');
			$this->Cell(95,4,'Nombre Tabajador ','BR',0,'C');
			$this->Cell(15,4,'Ingreso','BR',0,'C');
			$this->Cell(15,4,'Calculo','BR',0,'C');
			$this->Cell(20,4,'Capitalizado','BR',0,'C');
			$this->Cell(20,4,'Capitalizado','BR',0,'C');
			$this->Cell(20,4,'Interes','BRL',1,'C');
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
	  $i=0; $cant_trab=0; $Gtotal_prest=0; $Gtotal_adelanto=0; $Gtotal_saldo_p=0; $Gtotal_interes_noacum=0; $Gtotal_interes_acum=0; $Gtotal_interes=0; $Gtotal_acumulado=0; $Gtotal_saldo=0;
	  $suma_dias=0;$suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0;
	  //$pdf->MultiCell(260,4,$sSQL,0);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_empleado_grupo=$registro["cod_empleado"];
		if($prev_cod_empleado<>$cod_empleado_grupo){  $saldo=$acumulado_total+$interes_noacum;  $prev_cod_empleado=$cod_empleado_grupo;
		    $Gtotal_prest=$Gtotal_prest+$total_prestaciones; 	$Gtotal_adelanto=$Gtotal_adelanto+$total_adelanto; 
			$Gtotal_saldo_p=$Gtotal_saldo_p+$saldo_prestaciones; $Gtotal_interes_noacum=$Gtotal_interes_noacum+$interes_noacum; 
			$Gtotal_interes_acum=$Gtotal_interes_acum+$interes_acum; 	$Gtotal_acumulado=$Gtotal_acumulado+$acumulado_total; 
			$Gtotal_interes=$Gtotal_interes+$total_interes; $Gtotal_saldo=$Gtotal_saldo+$saldo; $cant_trab=$cant_trab+1;
		    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
			$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
			$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
			$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
			$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
			$suma_c_prestaciones=formato_monto($suma_c_prestaciones); $total_prestaciones=formato_monto($total_prestaciones);
		    $suma_monto_adelanto=formato_monto($suma_monto_adelanto); $suma_interes_devengado=formato_monto($suma_interes_devengado);
		    $suma_interes_pagado=formato_monto($suma_interes_pagado); $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(15,4,$cod_empleado,0,0,'L');
			$pdf->Cell(95,4,$nombre,0,0,'L');
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,4,$fechai,0,0,'C');
			$pdf->Cell(15,4,$fechac,0,0,'C');  			
			$pdf->Cell(20,4,$interes_noacum,0,0,'R');
			$pdf->Cell(20,4,$interes_acum,0,0,'R');
			$pdf->Cell(20,4,$total_interes,0,1,'R');
		    $prev_mes=$mes; $suma_dias=0;$suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0;
		}
		$cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $nombre=substr($nombre,0,75);
	    $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; $mes=substr($registro["fechac"],3,2);
	    $fechac=$registro["fechac"]; $num_calculo=$registro["num_calculo"];  $sueldo_calculo=$registro["sueldo_calculo"];  $sueldo_dia=($registro["sueldo_calculo"]/30);
	    $dias_prestaciones=$registro["dias_prestaciones"]; $c_prestaciones=$registro["c_prestaciones"]; $sueldo_calculo_adic=$registro["sueldo_calculo_adic"];  $sueldo_dia_adic=($registro["sueldo_calculo_adic"]/30);
		$dias_adicionales=$registro["dias_adicionales"]; $c_presta_adic=$registro["c_presta_adic"]; $monto_prestaciones=$registro["monto_prestaciones"]; 
		$total_prestaciones=$registro["total_prestaciones"]; $monto_adelanto=$registro["monto_adelanto"]; $total_adelanto=$registro["total_adelanto"];
		$interes_devengado=$registro["interes_devengado"]; $interes_noacum=$registro["interes_noacum"]; $interes_acum=$registro["interes_acum"]; 
		$interes_pagado=$registro["interes_pagado"];  $total_interes=$registro["total_interes"]; $tasa_interes=$registro["tasa_interes"]; 
		$tiempo_variacion=$registro["tiempo_variacion"]; $acumulado_total=$registro["acumulado_total"]; $tipo_calculo=$registro["tipo_calculo"];
		$saldo_prestaciones=$registro["saldo_prestaciones"];		
		$t_prestaciones=$total_prestaciones-$c_presta_adic;
		if($tipo_calculo=="P"){ $suma_dias=$suma_dias+$dias_prestaciones+$dias_adicionales; }
		$suma_c_prestaciones=$suma_c_prestaciones+$c_prestaciones+$c_presta_adic;
		$suma_monto_adelanto=$suma_monto_adelanto+$monto_adelanto;
		$suma_interes_devengado=$suma_interes_devengado+$interes_devengado;
		$suma_interes_pagado=$suma_interes_pagado+$interes_pagado;
      }
	  if($i>0){ $saldo=$acumulado_total+$interes_noacum;  
	    $Gtotal_prest=$Gtotal_prest+$total_prestaciones; 	$Gtotal_adelanto=$Gtotal_adelanto+$total_adelanto; 
		$Gtotal_saldo_p=$Gtotal_saldo_p+$saldo_prestaciones; $Gtotal_interes_noacum=$Gtotal_interes_noacum+$interes_noacum; 
		$Gtotal_interes_acum=$Gtotal_interes_acum+$interes_acum; 	$Gtotal_acumulado=$Gtotal_acumulado+$acumulado_total; 
		$Gtotal_interes=$Gtotal_interes+$total_interes; $Gtotal_saldo=$Gtotal_saldo+$saldo;  $cant_trab=$cant_trab+1;
	    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
		$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
		$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
		$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
		$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
		$suma_c_prestaciones=formato_monto($suma_c_prestaciones);  $total_prestaciones=formato_monto($total_prestaciones);
		$suma_monto_adelanto=formato_monto($suma_monto_adelanto);	$suma_interes_devengado=formato_monto($suma_interes_devengado);
		$suma_interes_pagado=formato_monto($suma_interes_pagado);  $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(15,4,$cod_empleado,0,0,'L');
		$pdf->Cell(95,4,$nombre,0,0,'L');
		$pdf->Cell(15,4,$fechai,0,0,'C');
		$pdf->Cell(15,4,$fechac,0,0,'C');  			
		$pdf->Cell(20,4,$interes_noacum,0,0,'R');
		$pdf->Cell(20,4,$interes_acum,0,0,'R');
		$pdf->Cell(20,4,$total_interes,0,1,'R');
	  }
	  $Gtotal_prest=formato_monto($Gtotal_prest); 	$Gtotal_adelanto=formato_monto($Gtotal_adelanto); 
	  $Gtotal_saldo_p=formato_monto($Gtotal_saldo_p); $Gtotal_interes_noacum=formato_monto($Gtotal_interes_noacum); 
	  $Gtotal_interes_acum=formato_monto($Gtotal_interes_acum); 	$Gtotal_acumulado=formato_monto($Gtotal_acumulado); 
      $Gtotal_interes=formato_monto($Gtotal_interes); $Gtotal_saldo=formato_monto($Gtotal_saldo);
	  $pdf->SetFont('Arial','B',8);
	  $pdf->Cell(140,2,'',0,0);
	  $pdf->Cell(20,2,'============',0,0,'R');
	  $pdf->Cell(20,2,'============',0,0,'R');
      $pdf->Cell(20,2,'============',0,1,'R');
	  $pdf->Cell(50,5,"Nro. Trabjadores ".$cant_trab,0,0,'L');
	  $pdf->Cell(90,5,'TOTALES :',0,0,'R');	
	  $pdf->Cell(20,5,$Gtotal_interes_noacum,0,0,'R');			
	  $pdf->Cell(20,5,$Gtotal_interes_acum,0,0,'R');
	  $pdf->Cell(20,5,$Gtotal_interes,0,1,'R');	
	  $pdf->Output(); 
    }
}
?>
