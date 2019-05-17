<? include ("../../class/conect.php");  require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php");  include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nominad=$_GET["tipo_nomina_d"]; $tipo_nominah=$_GET["tipo_nomina_h"];  $codigo_departamento_d=$_GET["codigo_departamento_d"];   $codigo_departamento_h=$_GET["codigo_departamento_h"]; 
   $mes=$_GET["mes"]; $ano=$_GET["ano"]; $categoria=$_GET["categoria"]; $tipo_rpt=$_GET["tipo_rpt"]; $most_reporte=$_GET["most_reporte"]; $montos_cero=$_GET["montos_cero"]; $Sql="";   $date=date("d-m-Y");   $hora=date("h:i:s a"); $criterio1="";
   $fecha_d="01/".$mes."/".$ano;  $fecha_h=colocar_udiames($fecha_d); $mcod_part="-401-01-08-01";   
   if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
   if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;   
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
    $criterio=" (nom006.cod_empleado=nom030.cod_empleado) and ((nom030.tipo_calculo='P') or (nom030.tipo_calculo='S') ) and (nom006.tipo_nomina>='".$tipo_nominad."' and nom006.tipo_nomina<='".$tipo_nominah."') 
	   and (nom030.fecha_calculo>='".$fecha_desde."' and nom030.fecha_calculo<='".$fecha_hasta."') and (nom006.cod_departam>='".$codigo_departamento_d."' and nom006.cod_departam<='".$codigo_departamento_h."' ) ";
    $nomb_rpt="Rpt_rela_di_suel_depo_mpr_re.xml";
	$ordenar=" ORDER BY nom030.cod_empleado,nom030.fecha_calculo,nom030.num_calculo";
	if ($categoria=='SI'){ $nomb_rpt="Rpt_rela_di_suel_depo_mpr_re_categoria.xml"; 	$ordenar=" ORDER BY nom006.cod_categoria,nom030.cod_empleado,nom030.fecha_calculo,nom030.num_calculo";   if($tipo_rpt=="PDF"){ $tipo_rpt="PDF3"; } }
	if ($categoria=='PARTIDAS'){ $nomb_rpt="Rpt_rela_di_suel_depo_mpr_re_categoria.xml"; 	$ordenar=" ORDER BY nom006.cod_categoria,nom030.cod_empleado,nom030.fecha_calculo,nom030.num_calculo";   if($tipo_rpt=="PDF"){ $tipo_rpt="PDF4"; } }
	if($most_reporte=="P"){ if($tipo_rpt=="PDF"){ $tipo_rpt="PDF5"; }} if($most_reporte=="A"){ if($tipo_rpt=="PDF"){ $tipo_rpt="PDF6"; }}
	$criterio3="";
    if($tipo_nominad==$tipo_nominah){ 
	   $sql="SELECT tipo_nomina,descripcion,desc_grupo from nom001 where tipo_nomina='$tipo_nominad'"; $res=pg_query($sql); 
	   if($registro=pg_fetch_array($res,0)){$criterio3=$registro["descripcion"];}
    }		
	$sSQL = "SELECT nom006.nombre,nom006.cedula,nom006.fecha_ingreso,nom006.tipo_nomina,nom030.cod_empleado,nom030.fecha_calculo,nom030.num_calculo,nom030.tipo_calculo,nom030.sueldo_calculo,nom030.dias_prestaciones,nom030.c_prestaciones,nom030.sueldo_calculo_adic,nom030.dias_adicionales,nom030.c_presta_adic,nom030.monto_prestaciones,nom030.total_prestaciones,nom030.monto_adelanto,nom030.total_adelanto,
	         nom030.monto_prestamo,nom030.total_prestamo,nom030.saldo_prestaciones,nom030.interes_devengado,nom030.interes_noacum,nom030.interes_acum,nom030.interes_pagado,nom030.total_interes,nom030.tasa_interes,nom030.tiempo_variacion,nom030.acumulado_total,to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as fechai, to_char(nom030.fecha_calculo,'DD/MM/YYYY') as fechac,nom006.cod_departam,nom006.cod_categoria,pre019.denominacion_cat 
			 FROM nom030,nom006 left join pre019 on (nom006.cod_categoria=pre019.cod_presup_cat) WHERE ".$criterio.$ordenar;
	
	if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php"); 
          $oRpt = new PHPReportMaker();
          $oRpt->setXML($nomb_rpt);
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("$host");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"date"=>$date,"hora"=>$hora,"fecha_d"=>$fecha_d,"fecha_h"=>$fecha_h));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();
    }
	
	if($tipo_rpt=="PDFF"){ $res=pg_query($sSQL); $filas=pg_num_rows($res); $mes=""; $periodof=""; $cod_empleado_grupo=""; 	$nombre_grupo="";  $cedula_grupo=""; $fechai_grupo=""; $prev_cod_empleado=""; 
	  if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $tipo_nomina=$registro["tipo_nomina"]; 
	    $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; $prev_cod_empleado=$cod_empleado; 
		$mes=substr($registro["fechac"],3,2); $periodof=Calcula_dif_fechas($fechai,$fecha_h);
	  }	
	  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1;  global $fecha_d; global $fecha_h; global $tipo_nomina;  global $criterio3; global $tipo_nominad; global $tipo_nominah; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,30);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,7,'RELACION  DIAS DE SUELDOS A DEPOSITAR',1,0,'C');
			$this->Ln(20);	
			$this->SetFont('Arial','B',8); 	
			if($tipo_nominad==$tipo_nominah){	$this->Cell(200,5,"NOMINA : ".$tipo_nomina." ".$criterio3,0,1,'L');}
            $this->SetFont('Arial','B',9); 	
            $this->Cell(50,5,"Fecha de Proceso Desde : ".$fecha_d." Hasta : ".$fecha_h,0,1,'L');			
			$this->SetFont('Arial','B',7);
			$this->Cell(17,3,'Codigo ','RTL',0,'C');
			$this->Cell(98,3,'','RTL',0,'C');
			$this->Cell(15,3,'Fecha ','RTL',0,'C');			
			$this->Cell(8,3,'','RTL',0,'C');
			$this->Cell(18,3,'Monto','RTL',0,'C');			
			$this->Cell(8,3,'Dias','RTL',0,'C');
			$this->Cell(18,3,'Monto Dias','RTL',0,'C');
			$this->Cell(18,3,'Monto','TRL',1,'C');
			
			$this->Cell(17,4,'Trabajador','BLR',0,'C');
			$this->Cell(98,4,'Nombre Tabajador ','BR',0,'C');
			$this->Cell(15,4,'Ingreso','BR',0,'C');			
			$this->Cell(8,4,'Dias','BR',0,'C');
			$this->Cell(18,4,'Prestaciones','BR',0,'C');			
			$this->Cell(8,4,'Adic.','BR',0,'C');
			$this->Cell(18,4,'Adicionales','BR',0,'C');
			$this->Cell(18,4,'Deposito','BRL',1,'C');
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
	  $i=0; $cant_trab=0; $Gtotal_prest=0; $Gtotal_adelanto=0; $Gtotal_saldo_p=0; $Gtotal_interes_noacum=0; $Gtotal_c_presta_adic=0; $Gtotal_c_prestaciones=0; $Gtotal_acumulado=0; $Gtotal_saldo=0;
	  $suma_dias=0;$suma_prestaciones=0;$suma_c_presta_adic=0;  $suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0; 
	  //$pdf->MultiCell(260,4,$sSQL,0);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_empleado_grupo=$registro["cod_empleado"]; 
		if($prev_cod_empleado<>$cod_empleado_grupo){  $saldo=$suma_c_prestaciones+$suma_interes_devengado;  $prev_cod_empleado=$cod_empleado_grupo; $temp_monto=$suma_c_prestaciones;
		    $Gtotal_prest=$Gtotal_prest+$suma_c_prestaciones; 	$Gtotal_interes=$Gtotal_interes+$suma_interes_devengado; $Gtotal_saldo=$Gtotal_saldo+$saldo; 
			$Gtotal_c_presta_adic=$Gtotal_c_presta_adic+$suma_c_presta_adic; $Gtotal_c_prestaciones=$Gtotal_c_prestaciones+$suma_prestaciones;
		    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
			$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
			$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
			$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
			$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
			$suma_c_prestaciones=formato_monto($suma_c_prestaciones); $total_prestaciones=formato_monto($total_prestaciones);
		    $suma_monto_adelanto=formato_monto($suma_monto_adelanto); $suma_interes_devengado=formato_monto($suma_interes_devengado);
		    $suma_interes_pagado=formato_monto($suma_interes_pagado); $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
			$suma_prestaciones=formato_monto($suma_prestaciones); $suma_c_presta_adic=formato_monto($suma_c_presta_adic);
			$pdf->SetFont('Arial','',8);
			$impimir="S";
			if(($montos_cero=="NO")and($temp_monto==0)){$impimir="N";}
			if($impimir=="S"){ $cant_trab=$cant_trab+1;
			$pdf->Cell(17,4,$cod_empleado,0,0,'L');
			$pdf->Cell(98,4,$nombre,0,0,'L');
			$pdf->Cell(15,4,$fechai,0,0,'L');
            $pdf->Cell(8,4,$dias_prestaciones,0,0,'C');
			$pdf->Cell(18,4,$suma_prestaciones,0,0,'R');			  		
            $pdf->Cell(8,4,$dias_adicionales,0,0,'C');
			$pdf->Cell(18,4,$suma_c_presta_adic,0,0,'R');
			$pdf->Cell(18,4,$suma_c_prestaciones,0,1,'R');	}
		    $prev_mes=$mes; $suma_dias=0;$suma_prestaciones=0;$suma_c_presta_adic=0; $suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0;
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
		if(($tipo_calculo=="P")or($tipo_calculo=="S")){ $suma_dias=$suma_dias+$dias_prestaciones+$dias_adicionales; }
		$suma_prestaciones=$suma_prestaciones+$c_prestaciones;
		$suma_c_presta_adic=$suma_c_presta_adic+$c_presta_adic; 
		$suma_c_prestaciones=$suma_c_prestaciones+$monto_prestaciones;
		$suma_monto_adelanto=$suma_monto_adelanto+$monto_adelanto;
		$suma_interes_devengado=$suma_interes_devengado+$interes_devengado;
		$suma_interes_pagado=$suma_interes_pagado+$interes_pagado;
      }
	  if($i>0){ $saldo=$suma_c_prestaciones+$suma_interes_devengado; 
	    $Gtotal_prest=$Gtotal_prest+$suma_c_prestaciones; 	$Gtotal_interes=$Gtotal_interes+$suma_interes_devengado; $Gtotal_saldo=$Gtotal_saldo+$saldo; 
		$Gtotal_c_presta_adic=$Gtotal_c_presta_adic+$suma_c_presta_adic; $Gtotal_c_prestaciones=$Gtotal_c_prestaciones+$suma_prestaciones; $temp_monto=$suma_c_prestaciones;
	    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
		$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
		$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
		$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
		$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
		$suma_c_prestaciones=formato_monto($suma_c_prestaciones);  $total_prestaciones=formato_monto($total_prestaciones);
		$suma_monto_adelanto=formato_monto($suma_monto_adelanto);	$suma_interes_devengado=formato_monto($suma_interes_devengado);
		$suma_interes_pagado=formato_monto($suma_interes_pagado);  $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
		$suma_prestaciones=formato_monto($suma_prestaciones); $suma_c_presta_adic=formato_monto($suma_c_presta_adic);
		$impimir="S";
		if(($montos_cero=="NO")and($temp_monto==0)){$impimir="N";}
		if($impimir=="S"){ $cant_trab=$cant_trab+1;
		$pdf->Cell(17,4,$cod_empleado,0,0,'L');
		$pdf->Cell(98,4,$nombre,0,0,'L');
		$pdf->Cell(15,4,$fechai,0,0,'L');
        $pdf->Cell(8,4,$dias_prestaciones,0,0,'C');
		$pdf->Cell(18,4,$suma_prestaciones,0,0,'R');  
		$pdf->Cell(8,4,$dias_adicionales,0,0,'C');
	    $pdf->Cell(18,4,$suma_c_presta_adic,0,0,'R');  
		$pdf->Cell(18,4,$suma_c_prestaciones,0,1,'R');	}
	  }
	  $Gtotal_prest=formato_monto($Gtotal_prest); 	$Gtotal_adelanto=formato_monto($Gtotal_adelanto); 
	  $Gtotal_saldo_p=formato_monto($Gtotal_saldo_p); $Gtotal_interes_noacum=formato_monto($Gtotal_interes_noacum); 
	  $Gtotal_interes_acum=formato_monto($Gtotal_interes_acum); 	$Gtotal_acumulado=formato_monto($Gtotal_acumulado); 
      $Gtotal_interes=formato_monto($Gtotal_interes); $Gtotal_saldo=formato_monto($Gtotal_saldo);
	  $Gtotal_c_presta_adic=formato_monto($Gtotal_c_presta_adic); $Gtotal_c_prestaciones=formato_monto($Gtotal_c_prestaciones);
	  $pdf->SetFont('Arial','B',8);
	  $pdf->Cell(130,2,'',0,0);
	  $pdf->Cell(6,2,'',0,0);
      $pdf->Cell(20,2,'============',0,0,'R');
	  $pdf->Cell(6,2,'',0,0);
	  $pdf->Cell(20,2,'============',0,0,'R');
	  $pdf->Cell(18,2,'==========',0,1,'R');
	  $pdf->Cell(50,5,"Nro. Trabjadores ".$cant_trab,0,0,'L');
	  $pdf->Cell(80,5,'TOTALES :',0,0,'R');	
	  $pdf->Cell(6,5,'',0,0);
	  $pdf->Cell(20,5,$Gtotal_c_prestaciones,0,0,'R');
	  $pdf->Cell(6,5,'',0,0);
	  $pdf->Cell(20,5,$Gtotal_c_presta_adic,0,0,'R');
	  $pdf->Cell(18,5,$Gtotal_prest,0,1,'R');
	  $pdf->Output(); 
    }
	
	if($tipo_rpt=="PDF5"){ $res=pg_query($sSQL); $filas=pg_num_rows($res); $mes=""; $periodof=""; $cod_empleado_grupo=""; 	$nombre_grupo="";  $cedula_grupo=""; $fechai_grupo=""; $prev_cod_empleado=""; 
	  if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $tipo_nomina=$registro["tipo_nomina"]; 
	    $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; $prev_cod_empleado=$cod_empleado; 
		$mes=substr($registro["fechac"],3,2); $periodof=Calcula_dif_fechas($fechai,$fecha_h);
	  }	
	  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1;  global $fecha_d; global $fecha_h; global $tipo_nomina;  global $criterio3; global $tipo_nominad; global $tipo_nominah; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,30);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,7,'RELACION  DIAS DE SUELDOS A DEPOSITAR',1,0,'C');
			$this->Ln(20);	
			$this->SetFont('Arial','B',8); 	
			if($tipo_nominad==$tipo_nominah){	$this->Cell(200,5,"NOMINA : ".$tipo_nomina." ".$criterio3,0,1,'L');}
            $this->SetFont('Arial','B',9); 	
            $this->Cell(50,5,"Fecha de Proceso Desde : ".$fecha_d." Hasta : ".$fecha_h,0,1,'L');			
			$this->SetFont('Arial','B',7);
			$this->Cell(17,3,'Codigo ','RTL',0,'C');
			$this->Cell(120,3,'','RTL',0,'C');
			$this->Cell(15,3,'Fecha ','RTL',0,'C');	
			$this->Cell(20,3,'Sueldo','RTL',0,'C');
			$this->Cell(8,3,'','RTL',0,'C');
			$this->Cell(20,3,'Monto','TRL',1,'C');
			$this->Cell(17,4,'Trabajador','BLR',0,'C');
			$this->Cell(120,4,'Nombre Tabajador ','BR',0,'C');
			$this->Cell(15,4,'Ingreso','BR',0,'C');
            $this->Cell(20,4,'Prestaciones','BR',0,'C');			
			$this->Cell(8,4,'Dias','BR',0,'C');
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
	  $i=0; $cant_trab=0; $Gtotal_prest=0; $Gtotal_adelanto=0; $Gtotal_saldo_p=0; $Gtotal_interes_noacum=0; $Gtotal_c_presta_adic=0; $Gtotal_c_prestaciones=0; $Gtotal_acumulado=0; $Gtotal_saldo=0;
	  $suma_dias=0;$suma_prestaciones=0;$suma_c_presta_adic=0;  $suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0; 
	  //$pdf->MultiCell(260,4,$sSQL,0);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_empleado_grupo=$registro["cod_empleado"]; 
		if($prev_cod_empleado<>$cod_empleado_grupo){  $saldo=$suma_c_prestaciones+$suma_interes_devengado;  $prev_cod_empleado=$cod_empleado_grupo; $temp_monto=$suma_prestaciones;
		    $Gtotal_prest=$Gtotal_prest+$suma_c_prestaciones; 	$Gtotal_interes=$Gtotal_interes+$suma_interes_devengado; $Gtotal_saldo=$Gtotal_saldo+$saldo; 
			$Gtotal_c_presta_adic=$Gtotal_c_presta_adic+$suma_c_presta_adic; $Gtotal_c_prestaciones=$Gtotal_c_prestaciones+$suma_prestaciones;
		    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
			$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
			$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
			$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
			$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
			$suma_c_prestaciones=formato_monto($suma_c_prestaciones); $total_prestaciones=formato_monto($total_prestaciones);
		    $suma_monto_adelanto=formato_monto($suma_monto_adelanto); $suma_interes_devengado=formato_monto($suma_interes_devengado);
		    $suma_interes_pagado=formato_monto($suma_interes_pagado); $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
			$suma_prestaciones=formato_monto($suma_prestaciones); $suma_c_presta_adic=formato_monto($suma_c_presta_adic);
			$pdf->SetFont('Arial','',8);
			$impimir="S";
			if(($montos_cero=="NO")and($temp_monto==0)){$impimir="N";}
			if($impimir=="S"){ $cant_trab=$cant_trab+1;
			$pdf->Cell(17,4,$cod_empleado,0,0,'L');
			$pdf->Cell(120,4,$nombre,0,0,'L');
			$pdf->Cell(15,4,$fechai,0,0,'L');        
			$pdf->Cell(20,4,$sueldo_calculo,0,0,'R');  
			$pdf->Cell(8,4,$dias_prestaciones,0,0,'C');
		    $pdf->Cell(20,4,$suma_prestaciones,0,1,'R');	}
		    $prev_mes=$mes; $suma_dias=0;$suma_prestaciones=0;$suma_c_presta_adic=0; $suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0;
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
		$suma_prestaciones=$suma_prestaciones+$c_prestaciones;
		$suma_c_presta_adic=$suma_c_presta_adic+$c_presta_adic; 
		$suma_c_prestaciones=$suma_c_prestaciones+$monto_prestaciones;
		$suma_monto_adelanto=$suma_monto_adelanto+$monto_adelanto;
		$suma_interes_devengado=$suma_interes_devengado+$interes_devengado;
		$suma_interes_pagado=$suma_interes_pagado+$interes_pagado;
      }
	  if($i>0){ $saldo=$suma_c_prestaciones+$suma_interes_devengado; 
	    $Gtotal_prest=$Gtotal_prest+$suma_c_prestaciones; 	$Gtotal_interes=$Gtotal_interes+$suma_interes_devengado; $Gtotal_saldo=$Gtotal_saldo+$saldo; 
		$Gtotal_c_presta_adic=$Gtotal_c_presta_adic+$suma_c_presta_adic; $Gtotal_c_prestaciones=$Gtotal_c_prestaciones+$suma_prestaciones; $temp_monto=$suma_prestaciones;
	    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
		$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
		$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
		$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
		$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
		$suma_c_prestaciones=formato_monto($suma_c_prestaciones);  $total_prestaciones=formato_monto($total_prestaciones);
		$suma_monto_adelanto=formato_monto($suma_monto_adelanto);	$suma_interes_devengado=formato_monto($suma_interes_devengado);
		$suma_interes_pagado=formato_monto($suma_interes_pagado);  $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
		$suma_prestaciones=formato_monto($suma_prestaciones); $suma_c_presta_adic=formato_monto($suma_c_presta_adic);
		$impimir="S"; if(($montos_cero=="NO")and($temp_monto==0)){$impimir="N";}
		if($impimir=="S"){ $cant_trab=$cant_trab+1;
		$pdf->Cell(17,4,$cod_empleado,0,0,'L');
		$pdf->Cell(120,4,$nombre,0,0,'L');
		$pdf->Cell(15,4,$fechai,0,0,'L');        
		$pdf->Cell(20,4,$sueldo_calculo,0,0,'R'); 
        $pdf->Cell(8,4,$dias_prestaciones,0,0,'C');
		$pdf->Cell(20,4,$suma_prestaciones,0,1,'R');	}
	  }
	  $Gtotal_prest=formato_monto($Gtotal_prest); 	$Gtotal_adelanto=formato_monto($Gtotal_adelanto); 
	  $Gtotal_saldo_p=formato_monto($Gtotal_saldo_p); $Gtotal_interes_noacum=formato_monto($Gtotal_interes_noacum); 
	  $Gtotal_interes_acum=formato_monto($Gtotal_interes_acum); 	$Gtotal_acumulado=formato_monto($Gtotal_acumulado); 
      $Gtotal_interes=formato_monto($Gtotal_interes); $Gtotal_saldo=formato_monto($Gtotal_saldo);
	  $Gtotal_c_presta_adic=formato_monto($Gtotal_c_presta_adic); $Gtotal_c_prestaciones=formato_monto($Gtotal_c_prestaciones);
	  $pdf->SetFont('Arial','B',8);
	  $pdf->Cell(180,2,'',0,0);
	  $pdf->Cell(20,2,'==============',0,1,'R');
	  $pdf->Cell(100,5,"Nro. Trabjadores ".$cant_trab,0,0,'L');
	  $pdf->Cell(80,5,'TOTALES :',0,0,'R');	
	  $pdf->Cell(20,5,$Gtotal_c_prestaciones,0,1,'R');
	  $pdf->Output(); 
    }
	if($tipo_rpt=="PDF6"){ $res=pg_query($sSQL); $filas=pg_num_rows($res); $mes=""; $periodof=""; $cod_empleado_grupo=""; 	$nombre_grupo="";  $cedula_grupo=""; $fechai_grupo=""; $prev_cod_empleado=""; 
	  if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $tipo_nomina=$registro["tipo_nomina"]; 
	    $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; $prev_cod_empleado=$cod_empleado; 
		$mes=substr($registro["fechac"],3,2); $periodof=Calcula_dif_fechas($fechai,$fecha_h);
	  }	
	  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1;  global $fecha_d; global $fecha_h; global $tipo_nomina;  global $criterio3; global $tipo_nominad; global $tipo_nominah; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,30);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,7,'RELACION  DIAS DE SUELDOS A DEPOSITAR',1,0,'C');
			$this->Ln(20);	
            $this->SetFont('Arial','B',8); 	
			if($tipo_nominad==$tipo_nominah){	$this->Cell(200,5,"NOMINA : ".$tipo_nomina." ".$criterio3,0,1,'L');}
			$this->SetFont('Arial','B',9);
            $this->Cell(50,5,"Fecha de Proceso Desde : ".$fecha_d." Hasta : ".$fecha_h,0,1,'L');			
			$this->SetFont('Arial','B',7);
			$this->Cell(17,3,'Codigo ','RTL',0,'C');
			$this->Cell(120,3,'','RTL',0,'C');
			$this->Cell(15,3,'Fecha ','RTL',0,'C');	
			$this->Cell(20,3,'Sueldo','RTL',0,'C');
			$this->Cell(8,3,'Dias','RTL',0,'C');
			$this->Cell(20,3,'Monto Dias','TRL',1,'C');
			$this->Cell(17,4,'Trabajador','BLR',0,'C');
			$this->Cell(120,4,'Nombre Tabajador ','BR',0,'C');
			$this->Cell(15,4,'Ingreso','BR',0,'C');
            $this->Cell(20,4,'Dias Adic.','BR',0,'C');			
			$this->Cell(8,4,'Adic','BR',0,'C');
			$this->Cell(20,4,'Adicionales','BRL',1,'C');
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
	  $i=0; $cant_trab=0; $Gtotal_prest=0; $Gtotal_adelanto=0; $Gtotal_saldo_p=0; $Gtotal_interes_noacum=0; $Gtotal_c_presta_adic=0; $Gtotal_c_prestaciones=0; $Gtotal_acumulado=0; $Gtotal_saldo=0;
	  $suma_dias=0;$suma_prestaciones=0;$suma_c_presta_adic=0;  $suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0; 
	  //$pdf->MultiCell(260,4,$sSQL,0);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_empleado_grupo=$registro["cod_empleado"]; 
		if($prev_cod_empleado<>$cod_empleado_grupo){  $saldo=$suma_c_prestaciones+$suma_interes_devengado;  $prev_cod_empleado=$cod_empleado_grupo; $temp_monto=$suma_c_presta_adic;
		    $Gtotal_prest=$Gtotal_prest+$suma_c_prestaciones; 	$Gtotal_interes=$Gtotal_interes+$suma_interes_devengado; $Gtotal_saldo=$Gtotal_saldo+$saldo; 
			$Gtotal_c_presta_adic=$Gtotal_c_presta_adic+$suma_c_presta_adic; $Gtotal_c_prestaciones=$Gtotal_c_prestaciones+$suma_prestaciones;
		    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
			$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
			$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
			$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
			$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
			$suma_c_prestaciones=formato_monto($suma_c_prestaciones); $total_prestaciones=formato_monto($total_prestaciones);
		    $suma_monto_adelanto=formato_monto($suma_monto_adelanto); $suma_interes_devengado=formato_monto($suma_interes_devengado);
		    $suma_interes_pagado=formato_monto($suma_interes_pagado); $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
			$suma_prestaciones=formato_monto($suma_prestaciones); $suma_c_presta_adic=formato_monto($suma_c_presta_adic);
			$pdf->SetFont('Arial','',8);$impimir="S";
			if(($montos_cero=="NO")and($temp_monto==0)){$impimir="N";}
			if($impimir=="S"){ $cant_trab=$cant_trab+1;
			$pdf->Cell(17,4,$cod_empleado,0,0,'L');
			$pdf->Cell(120,4,$nombre,0,0,'L');
			$pdf->Cell(15,4,$fechai,0,0,'L');        
			$pdf->Cell(20,4,$sueldo_calculo,0,0,'R');  
			$pdf->Cell(8,4,$dias_adicionales,0,0,'C');
		    $pdf->Cell(20,4,$suma_c_presta_adic,0,1,'R');	}
		    $prev_mes=$mes; $suma_dias=0;$suma_prestaciones=0;$suma_c_presta_adic=0; $suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0;
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
		$suma_prestaciones=$suma_prestaciones+$c_prestaciones;
		$suma_c_presta_adic=$suma_c_presta_adic+$c_presta_adic; 
		$suma_c_prestaciones=$suma_c_prestaciones+$monto_prestaciones;
		$suma_monto_adelanto=$suma_monto_adelanto+$monto_adelanto;
		$suma_interes_devengado=$suma_interes_devengado+$interes_devengado;
		$suma_interes_pagado=$suma_interes_pagado+$interes_pagado;
      }
	  if($i>0){ $saldo=$suma_c_prestaciones+$suma_interes_devengado; 
	    $Gtotal_prest=$Gtotal_prest+$suma_c_prestaciones; 	$Gtotal_interes=$Gtotal_interes+$suma_interes_devengado; $Gtotal_saldo=$Gtotal_saldo+$saldo; 
		$Gtotal_c_presta_adic=$Gtotal_c_presta_adic+$suma_c_presta_adic; $Gtotal_c_prestaciones=$Gtotal_c_prestaciones+$suma_prestaciones; $temp_monto=$suma_c_presta_adic;
	    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
		$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
		$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
		$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
		$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
		$suma_c_prestaciones=formato_monto($suma_c_prestaciones);  $total_prestaciones=formato_monto($total_prestaciones);
		$suma_monto_adelanto=formato_monto($suma_monto_adelanto);	$suma_interes_devengado=formato_monto($suma_interes_devengado);
		$suma_interes_pagado=formato_monto($suma_interes_pagado);  $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
		$suma_prestaciones=formato_monto($suma_prestaciones); $suma_c_presta_adic=formato_monto($suma_c_presta_adic);
		$impimir="S";if(($montos_cero=="NO")and($temp_monto==0)){$impimir="N";}
		if($impimir=="S"){ $cant_trab=$cant_trab+1;
		$pdf->Cell(17,4,$cod_empleado,0,0,'L');
		$pdf->Cell(120,4,$nombre,0,0,'L');
		$pdf->Cell(15,4,$fechai,0,0,'L');        
		$pdf->Cell(20,4,$sueldo_calculo,0,0,'R');  
		$pdf->Cell(8,4,$dias_adicionales,0,0,'C');
		$pdf->Cell(20,4,$suma_c_presta_adic,0,1,'R');	}
	  }
	  $Gtotal_prest=formato_monto($Gtotal_prest); 	$Gtotal_adelanto=formato_monto($Gtotal_adelanto); 
	  $Gtotal_saldo_p=formato_monto($Gtotal_saldo_p); $Gtotal_interes_noacum=formato_monto($Gtotal_interes_noacum); 
	  $Gtotal_interes_acum=formato_monto($Gtotal_interes_acum); 	$Gtotal_acumulado=formato_monto($Gtotal_acumulado); 
      $Gtotal_interes=formato_monto($Gtotal_interes); $Gtotal_saldo=formato_monto($Gtotal_saldo);
	  $Gtotal_c_presta_adic=formato_monto($Gtotal_c_presta_adic); $Gtotal_c_prestaciones=formato_monto($Gtotal_c_prestaciones);
	  $pdf->SetFont('Arial','B',8);
	  $pdf->Cell(180,2,'',0,0);
	  $pdf->Cell(20,2,'==============',0,1,'R');
	  $pdf->Cell(100,5,"Nro. Trabjadores ".$cant_trab,0,0,'L');
	  $pdf->Cell(80,5,'TOTALES :',0,0,'R');	
	  $pdf->Cell(20,5,$Gtotal_c_presta_adic,0,1,'R');
	  $pdf->Output(); 
    }
	if($tipo_rpt=="PDF"){ $res=pg_query($sSQL); $filas=pg_num_rows($res); $mes=""; $periodof=""; $cod_empleado_grupo=""; 	$nombre_grupo="";  $cedula_grupo=""; $fechai_grupo=""; $prev_cod_empleado=""; 
	  if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $tipo_nomina=$registro["tipo_nomina"]; 
	    $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; $prev_cod_empleado=$cod_empleado; 
		$mes=substr($registro["fechac"],3,2); $periodof=Calcula_dif_fechas($fechai,$fecha_h);
	  }	
	  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1;  global $fecha_d; global $fecha_h; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,30);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,7,'RELACION  DIAS DE SUELDOS A DEPOSITAR',1,0,'C');
			$this->Ln(20);	
            $this->SetFont('Arial','B',9); 	
            $this->Cell(50,5,"Fecha de Proceso Desde : ".$fecha_d." Hasta : ".$fecha_h,0,1,'L');			
			$this->SetFont('Arial','B',7);
			$this->Cell(17,3,'Codigo ','RTL',0,'C');
			$this->Cell(98,3,'','RTL',0,'C');
			$this->Cell(15,3,'Fecha ','RTL',0,'C');
			$this->Cell(18,3,'Sueldo','RTL',0,'C');
			$this->Cell(8,3,'','RTL',0,'C');
			$this->Cell(18,3,'Sueldo Dias','RTL',0,'C');
			$this->Cell(8,3,'Dias','RTL',0,'C');
			$this->Cell(18,3,'Monto','TRL',1,'C');			
			$this->Cell(17,4,'Trabajador','BLR',0,'C');
			$this->Cell(98,4,'Nombre Tabajador ','BR',0,'C');
			$this->Cell(15,4,'Ingreso','BR',0,'C');
			$this->Cell(18,4,'Prestaciones','BR',0,'C');
			$this->Cell(8,4,'Dias','BR',0,'C');
			$this->Cell(18,4,'Adicionales','BR',0,'C');
			$this->Cell(8,4,'Adic.','BR',0,'C');
			$this->Cell(18,4,'Deposito','BRL',1,'C');
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
		if($prev_cod_empleado<>$cod_empleado_grupo){  $saldo=$suma_c_prestaciones+$suma_interes_devengado;  $prev_cod_empleado=$cod_empleado_grupo;
		    $Gtotal_prest=$Gtotal_prest+$suma_c_prestaciones; 	$Gtotal_interes=$Gtotal_interes+$suma_interes_devengado; $Gtotal_saldo=$Gtotal_saldo+$saldo; $temp_monto=$suma_c_prestaciones;
			$sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
			$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
			$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
			$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
			$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
			$suma_c_prestaciones=formato_monto($suma_c_prestaciones); $total_prestaciones=formato_monto($total_prestaciones);
		    $suma_monto_adelanto=formato_monto($suma_monto_adelanto); $suma_interes_devengado=formato_monto($suma_interes_devengado);
		    $suma_interes_pagado=formato_monto($suma_interes_pagado); $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
			$pdf->SetFont('Arial','',8); $impimir="S";
			if(($montos_cero=="NO")and($temp_monto==0)){$impimir="N";}
			if($impimir=="S"){ $cant_trab=$cant_trab+1;
			$pdf->Cell(17,4,$cod_empleado,0,0,'L');
			$pdf->Cell(98,4,$nombre,0,0,'L');
			$pdf->Cell(15,4,$fechai,0,0,'L');
			$pdf->Cell(18,4,$sueldo_calculo,0,0,'R');  		
            $pdf->Cell(8,4,$dias_prestaciones,0,0,'C');
			$pdf->Cell(18,4,$sueldo_calculo_adic,0,0,'R');  		
            $pdf->Cell(8,4,$dias_adicionales,0,0,'C');
			$pdf->Cell(18,4,$suma_c_prestaciones,0,1,'R'); }	
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
		$suma_c_prestaciones=$suma_c_prestaciones+$monto_prestaciones;
		$suma_monto_adelanto=$suma_monto_adelanto+$monto_adelanto;
		$suma_interes_devengado=$suma_interes_devengado+$interes_devengado;
		$suma_interes_pagado=$suma_interes_pagado+$interes_pagado;
      }
	  if($i>0){ $saldo=$suma_c_prestaciones+$suma_interes_devengado; 
	    $Gtotal_prest=$Gtotal_prest+$suma_c_prestaciones; 	$Gtotal_interes=$Gtotal_interes+$suma_interes_devengado; $Gtotal_saldo=$Gtotal_saldo+$saldo; $temp_monto=$suma_c_prestaciones;
	    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
		$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
		$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
		$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
		$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
		$suma_c_prestaciones=formato_monto($suma_c_prestaciones);  $total_prestaciones=formato_monto($total_prestaciones);
		$suma_monto_adelanto=formato_monto($suma_monto_adelanto);	$suma_interes_devengado=formato_monto($suma_interes_devengado);
		$suma_interes_pagado=formato_monto($suma_interes_pagado);  $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
		$impimir="S"; if(($montos_cero=="NO")and($temp_monto==0)){$impimir="N";}
		if($impimir=="S"){ $cant_trab=$cant_trab+1;
		$pdf->Cell(17,4,$cod_empleado,0,0,'L');
		$pdf->Cell(98,4,$nombre,0,0,'L');
		$pdf->Cell(15,4,$fechai,0,0,'L');
		$pdf->Cell(18,4,$sueldo_calculo,0,0,'R');  		
        $pdf->Cell(8,4,$dias_prestaciones,0,0,'C');
	    $pdf->Cell(18,4,$sueldo_calculo_adic,0,0,'R');  		
        $pdf->Cell(8,4,$dias_adicionales,0,0,'C');
		$pdf->Cell(18,4,$suma_c_prestaciones,0,1,'R'); }	
	  }
	  $Gtotal_prest=formato_monto($Gtotal_prest); 	$Gtotal_adelanto=formato_monto($Gtotal_adelanto); 
	  $Gtotal_saldo_p=formato_monto($Gtotal_saldo_p); $Gtotal_interes_noacum=formato_monto($Gtotal_interes_noacum); 
	  $Gtotal_interes_acum=formato_monto($Gtotal_interes_acum); 	$Gtotal_acumulado=formato_monto($Gtotal_acumulado); 
      $Gtotal_interes=formato_monto($Gtotal_interes); $Gtotal_saldo=formato_monto($Gtotal_saldo);
	  $pdf->SetFont('Arial','B',8);
	  $pdf->Cell(180,2,'',0,0);
      $pdf->Cell(20,2,'============',0,1,'R');
	  $pdf->Cell(50,5,"Nro. Trabjadores ".$cant_trab,0,0,'L');
	  $pdf->Cell(130,5,'TOTALES :',0,0,'R');	
	  $pdf->Cell(20,5,$Gtotal_prest,0,1,'R');
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
		function Header(){ global $criterio1;  global $fecha_d; global $fecha_h; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,30);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,7,'RELACION  DIAS DE SUELDOS A DEPOSITAR',1,0,'C');
			$this->Ln(20);	
            $this->SetFont('Arial','B',9); 	
            $this->Cell(50,5,"Fecha de Proceso Desde : ".$fecha_d." Hasta : ".$fecha_h,0,1,'L');			
			$this->SetFont('Arial','B',7);
			$this->Cell(15,3,'Codigo ','RTL',0,'C');
			$this->Cell(120,3,'','RTL',0,'C');
			$this->Cell(15,3,'Fecha ','RTL',0,'C');
			$this->Cell(18,3,'Sueldo','RTL',0,'C');
			$this->Cell(8,3,'','RTL',0,'C');
			$this->Cell(20,3,'Monto','RTL',0,'C');
			$this->Cell(18,3,'Sueldo Dias','RTL',0,'C');
			$this->Cell(8,3,'Dias','RTL',0,'C');
			$this->Cell(20,3,'Monto Dias','RTL',0,'C');
			$this->Cell(18,3,'Monto','TRL',1,'C');			
			$this->Cell(15,4,'Trabajador','BLR',0,'C');
			$this->Cell(120,4,'Nombre Tabajador ','BR',0,'C');
			$this->Cell(15,4,'Ingreso','BR',0,'C');
			$this->Cell(18,4,'Prestaciones','BR',0,'C');
			$this->Cell(8,4,'Dias','BR',0,'C');
			$this->Cell(20,4,'Prestaciones','BR',0,'C');
			$this->Cell(18,4,'Adicionales','BR',0,'C');
			$this->Cell(8,4,'Adic.','BR',0,'C');
			$this->Cell(20,4,'Adicionales','BR',0,'C');
			$this->Cell(18,4,'Deposito','BRL',1,'C');
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
	  //$pdf->MultiCell(260,4,$sSQL,0);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_empleado_grupo=$registro["cod_empleado"]; 
		if($prev_cod_empleado<>$cod_empleado_grupo){  $saldo=$suma_c_prestaciones+$suma_interes_devengado;  $prev_cod_empleado=$cod_empleado_grupo;
		    $Gtotal_prest=$Gtotal_prest+$suma_c_prestaciones; 	$Gtotal_interes=$Gtotal_interes+$suma_interes_devengado; $Gtotal_saldo=$Gtotal_saldo+$saldo; $cant_trab=$cant_trab+1;
			$sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones); $c_presta_adic=formato_monto($c_presta_adic);
			$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
			$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
			$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
			$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
			$suma_c_prestaciones=formato_monto($suma_c_prestaciones); $total_prestaciones=formato_monto($total_prestaciones);
		    $suma_monto_adelanto=formato_monto($suma_monto_adelanto); $suma_interes_devengado=formato_monto($suma_interes_devengado);
		    $suma_interes_pagado=formato_monto($suma_interes_pagado); $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,4,$cod_empleado,0,0,'L');
			$pdf->Cell(120,4,$nombre,0,0,'L');
			$pdf->Cell(15,4,$fechai,0,0,'L');
			$pdf->Cell(18,4,$sueldo_calculo,0,0,'R');  		
            $pdf->Cell(8,4,$dias_prestaciones,0,0,'C');
			$pdf->Cell(20,4,$c_prestaciones,0,0,'R');
			$pdf->Cell(18,4,$sueldo_calculo_adic,0,0,'R');  		
            $pdf->Cell(8,4,$dias_adicionales,0,0,'C');
			$pdf->Cell(20,4,$c_presta_adic,0,0,'R');
			$pdf->Cell(18,4,$suma_c_prestaciones,0,1,'R');	
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
		$suma_c_prestaciones=$suma_c_prestaciones+$monto_prestaciones;
		$suma_monto_adelanto=$suma_monto_adelanto+$monto_adelanto;
		$suma_interes_devengado=$suma_interes_devengado+$interes_devengado;
		$suma_interes_pagado=$suma_interes_pagado+$interes_pagado;
      }
	  if($i>0){ $saldo=$suma_c_prestaciones+$suma_interes_devengado; 
	    $Gtotal_prest=$Gtotal_prest+$suma_c_prestaciones; 	$Gtotal_interes=$Gtotal_interes+$suma_interes_devengado; $Gtotal_saldo=$Gtotal_saldo+$saldo; $cant_trab=$cant_trab+1;
	    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
		$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
		$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
		$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
		$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
		$suma_c_prestaciones=formato_monto($suma_c_prestaciones);  $total_prestaciones=formato_monto($total_prestaciones);
		$suma_monto_adelanto=formato_monto($suma_monto_adelanto);	$suma_interes_devengado=formato_monto($suma_interes_devengado);
		$suma_interes_pagado=formato_monto($suma_interes_pagado);  $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
		$pdf->Cell(15,4,$cod_empleado,0,0,'L');
		$pdf->Cell(120,4,$nombre,0,0,'L');
		$pdf->Cell(15,4,$fechai,0,0,'L');
		$pdf->Cell(18,4,$sueldo_calculo,0,0,'R');  		
		$pdf->Cell(8,4,$dias_prestaciones,0,0,'C');
		$pdf->Cell(20,4,$c_prestaciones,0,0,'R');
		$pdf->Cell(18,4,$sueldo_calculo_adic,0,0,'R');  		
		$pdf->Cell(8,4,$dias_adicionales,0,0,'C');
		$pdf->Cell(20,4,$c_presta_adic,0,0,'R');
		$pdf->Cell(18,4,$suma_c_prestaciones,0,1,'R');		
	  }
	  $Gtotal_prest=formato_monto($Gtotal_prest); 	$Gtotal_adelanto=formato_monto($Gtotal_adelanto); 
	  $Gtotal_saldo_p=formato_monto($Gtotal_saldo_p); $Gtotal_interes_noacum=formato_monto($Gtotal_interes_noacum); 
	  $Gtotal_interes_acum=formato_monto($Gtotal_interes_acum); 	$Gtotal_acumulado=formato_monto($Gtotal_acumulado); 
      $Gtotal_interes=formato_monto($Gtotal_interes); $Gtotal_saldo=formato_monto($Gtotal_saldo);
	  $pdf->SetFont('Arial','B',8);
	  $pdf->Cell(240,2,'',0,0);
      $pdf->Cell(20,2,'============',0,1,'R');
	  $pdf->Cell(50,5,"Nro. Trabjadores ".$cant_trab,0,0,'L');
	  $pdf->Cell(190,5,'TOTALES :',0,0,'R');	
	  $pdf->Cell(20,5,$Gtotal_prest,0,1,'R');
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
		function Header(){ global $criterio1;  global $fecha_d; global $fecha_h; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,30);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,7,'RELACION  DIAS DE SUELDOS A DEPOSITAR',1,0,'C');
			$this->Ln(20);	
            $this->SetFont('Arial','B',9); 	
            $this->Cell(50,5,"Fecha de Proceso Desde : ".$fecha_d." Hasta : ".$fecha_h,0,1,'L');			
			$this->SetFont('Arial','B',7);
			$this->Cell(15,4,'Codigo ','RTL',0,'C');
			$this->Cell(120,4,'','RTL',0,'C');
			$this->Cell(15,4,'Fecha ','RTL',0,'C');
			$this->Cell(20,4,'Sueldo','RTL',0,'C');
			$this->Cell(10,4,'','RTL',0,'C');
			$this->Cell(20,4,'Monto','TRL',1,'C');
			$this->Cell(15,4,'Trabajador','BLR',0,'C');
			$this->Cell(120,4,'Nombre Tabajador ','BR',0,'C');
			$this->Cell(15,4,'Ingreso','BR',0,'C');
			$this->Cell(20,4,'Prestaciones','BR',0,'C');
			$this->Cell(10,4,'Dias','BR',0,'C');
			$this->Cell(20,4,'Deposito','BRL',1,'C');
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
	  $suma_dias=0;$suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0; $prev_categoria="";
	  $subt_categoria=0;
	  //$pdf->MultiCell(260,4,$sSQL,0);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_empleado_grupo=$registro["cod_empleado"]; $cod_categoria=$registro["cod_categoria"]; $denominacion_cat=$registro["denominacion_cat"]; 
	    if($prev_cod_empleado<>$cod_empleado_grupo){  $saldo=$suma_c_prestaciones+$suma_interes_devengado;  $prev_cod_empleado=$cod_empleado_grupo;
		    $Gtotal_prest=$Gtotal_prest+$suma_c_prestaciones; 	$Gtotal_interes=$Gtotal_interes+$suma_interes_devengado; $Gtotal_saldo=$Gtotal_saldo+$saldo; $cant_trab=$cant_trab+1;
			$subt_categoria=$subt_categoria+$suma_c_prestaciones;
		    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
			$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
			$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
			$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
			$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
			$suma_c_prestaciones=formato_monto($suma_c_prestaciones); $total_prestaciones=formato_monto($total_prestaciones);
		    $suma_monto_adelanto=formato_monto($suma_monto_adelanto); $suma_interes_devengado=formato_monto($suma_interes_devengado);
		    $suma_interes_pagado=formato_monto($suma_interes_pagado); $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,4,$cod_empleado,0,0,'L');
			$pdf->Cell(120,4,$nombre,0,0,'L');
			$pdf->Cell(15,4,$fechai,0,0,'L');
			$pdf->Cell(20,4,$sueldo_calculo,0,0,'R');  		
            $pdf->Cell(10,4,$suma_dias,0,0,'C');
			$pdf->Cell(20,4,$suma_c_prestaciones,0,1,'R');	
		    $prev_mes=$mes; $suma_dias=0;$suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0;
		}
		if($cod_categoria<>$prev_categoria){
		  $pdf->SetFont('Arial','B',8);
		  if($i>1){ $subt_categoria=formato_monto($subt_categoria);
		    $pdf->Cell(180,2,'',0,0);
			$pdf->Cell(20,2,'----------------',0,1,'R');
			$pdf->Cell(180,5,'Total Categoria '.$prev_categoria.' :',0,0,'R');	
			$pdf->Cell(20,5,$subt_categoria,0,1,'R');
			$pdf->Ln(4);
		  }
		  $pdf->Cell(150,4,"Categoria: ".$cod_categoria." ".$denominacion_cat,0,1,'L');
		  $prev_categoria=$cod_categoria; $subt_categoria=0;
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
		$suma_c_prestaciones=$suma_c_prestaciones+$monto_prestaciones;
		$suma_monto_adelanto=$suma_monto_adelanto+$monto_adelanto;
		$suma_interes_devengado=$suma_interes_devengado+$interes_devengado;
		$suma_interes_pagado=$suma_interes_pagado+$interes_pagado;
      }
	  if($i>0){ $saldo=$suma_c_prestaciones+$suma_interes_devengado; 
	    $Gtotal_prest=$Gtotal_prest+$suma_c_prestaciones; 	$Gtotal_interes=$Gtotal_interes+$suma_interes_devengado; $Gtotal_saldo=$Gtotal_saldo+$saldo; $cant_trab=$cant_trab+1;
	    $subt_categoria=$subt_categoria+$suma_c_prestaciones;
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
		$pdf->Cell(120,4,$nombre,0,0,'L');
		$pdf->Cell(15,4,$fechai,0,0,'L');
		$pdf->Cell(20,4,$sueldo_calculo,0,0,'R');  		
		$pdf->Cell(10,4,$suma_dias,0,0,'C');
		$pdf->Cell(20,4,$suma_c_prestaciones,0,1,'R');	
	  }
	  $Gtotal_prest=formato_monto($Gtotal_prest); 	$Gtotal_adelanto=formato_monto($Gtotal_adelanto); 
	  $Gtotal_saldo_p=formato_monto($Gtotal_saldo_p); $Gtotal_interes_noacum=formato_monto($Gtotal_interes_noacum); 
	  $Gtotal_interes_acum=formato_monto($Gtotal_interes_acum); 	$Gtotal_acumulado=formato_monto($Gtotal_acumulado); 
      $Gtotal_interes=formato_monto($Gtotal_interes); $Gtotal_saldo=formato_monto($Gtotal_saldo);
	  $subt_categoria=formato_monto($subt_categoria);
	  $pdf->SetFont('Arial','B',8);
	  $pdf->Cell(180,2,'',0,0);
	  $pdf->Cell(20,2,'----------------',0,1,'R');
	  $pdf->Cell(180,5,'Total Categoria '.$prev_categoria.' :',0,0,'R');		
	  $pdf->Cell(20,5,$subt_categoria,0,1,'R');
	  $pdf->Ln(4);
	  
	  $pdf->Cell(180,2,'',0,0);
      $pdf->Cell(20,2,'============',0,1,'R');
	  $pdf->Cell(50,5,"Nro. Trabjadores ".$cant_trab,0,0,'L');
	  $pdf->Cell(130,5,'TOTALES :',0,0,'R');	
	  $pdf->Cell(20,5,$Gtotal_prest,0,1,'R');
	  $pdf->Output(); 
    }
   
   
   if($tipo_rpt=="PDF4"){ $res=pg_query($sSQL); $filas=pg_num_rows($res); $mes=""; $periodof=""; $cod_empleado_grupo=""; 	$nombre_grupo="";  $cedula_grupo=""; $fechai_grupo=""; $prev_cod_empleado=""; 
	  if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; 
	    $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; $prev_cod_empleado=$cod_empleado; 
		$mes=substr($registro["fechac"],3,2); $periodof=Calcula_dif_fechas($fechai,$fecha_h);
	  }	
	  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1;  global $fecha_d; global $fecha_h; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,30);
			$this->SetFont('Arial','B',10);
			$this->Cell(30);
			$this->Cell(140,7,'DISTRIBUCION PRESUPUESTARIA DIAS A DEPOSITAR PRESTACIONES',1,0,'C');
			$this->Ln(20);	
            $this->SetFont('Arial','B',9); 	
            $this->Cell(50,5,"Fecha de Proceso Desde : ".$fecha_d." Hasta : ".$fecha_h,0,1,'L');			
			$this->Ln(10);	
			
			$this->Cell(30,6,'',0,0,'C');
			$this->Cell(50,6,'Codigo Presupuestario ',1,0,'C');
			$this->Cell(25,6,'Monto',1,1,'C');
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
	  $suma_dias=0;$suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0; $prev_categoria="";
	  $subt_categoria=0;
	  //$pdf->MultiCell(260,4,$sSQL,0);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_empleado_grupo=$registro["cod_empleado"]; $cod_categoria=$registro["cod_categoria"]; $denominacion_cat=$registro["denominacion_cat"];  $tipo_nomina=$registro["tipo_nomina"];
	    //$mcod_part="-401-01-08-01";   
		if($tipo_nomina=="01"){$mcod_part="-401-01-08-01";}
		//if(($tipo_nominad=="04")and($cod_categoria=="03-01-010")){$cod_categoria="03-01-008";}
		//if($tipo_nominad=="32"){$cod_categoria="03-01-015";   $mcod_part="-401-01-08-02";   }
		if($prev_cod_empleado<>$cod_empleado_grupo){  $saldo=$suma_c_prestaciones+$suma_interes_devengado;  $prev_cod_empleado=$cod_empleado_grupo;
		    $Gtotal_prest=$Gtotal_prest+$suma_c_prestaciones; 	$Gtotal_interes=$Gtotal_interes+$suma_interes_devengado; $Gtotal_saldo=$Gtotal_saldo+$saldo; $cant_trab=$cant_trab+1;
			$subt_categoria=$subt_categoria+$suma_c_prestaciones;
		    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
			$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
			$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
			$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
			$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
			$suma_c_prestaciones=formato_monto($suma_c_prestaciones); $total_prestaciones=formato_monto($total_prestaciones);
		    $suma_monto_adelanto=formato_monto($suma_monto_adelanto); $suma_interes_devengado=formato_monto($suma_interes_devengado);
		    $suma_interes_pagado=formato_monto($suma_interes_pagado); $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
			$pdf->SetFont('Arial','',8);
				
		    $prev_mes=$mes; $suma_dias=0;$suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0;
		}
		if($cod_categoria<>$prev_categoria){
		  $pdf->SetFont('Arial','',9);
		  if($i>1){ $subt_categoria=formato_monto($subt_categoria); 
		    $mcodigo=$prev_categoria.$mcod_part;  
		    $pdf->Cell(30,6,'',0,0);
			$pdf->Cell(50,6,$mcodigo,'L',0);			
			$pdf->Cell(25,6,$subt_categoria,'R',1,'R');
		  }
		  $prev_categoria=$cod_categoria; $subt_categoria=0;
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
		$suma_c_prestaciones=$suma_c_prestaciones+$monto_prestaciones;
		$suma_monto_adelanto=$suma_monto_adelanto+$monto_adelanto;
		$suma_interes_devengado=$suma_interes_devengado+$interes_devengado;
		$suma_interes_pagado=$suma_interes_pagado+$interes_pagado;
      }
	  if($i>0){ $saldo=$suma_c_prestaciones+$suma_interes_devengado; 
	    $Gtotal_prest=$Gtotal_prest+$suma_c_prestaciones; 	$Gtotal_interes=$Gtotal_interes+$suma_interes_devengado; $Gtotal_saldo=$Gtotal_saldo+$saldo; $cant_trab=$cant_trab+1;
	    $subt_categoria=$subt_categoria+$suma_c_prestaciones;
		$sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
		$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
		$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
		$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
		$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
		$suma_c_prestaciones=formato_monto($suma_c_prestaciones);  $total_prestaciones=formato_monto($total_prestaciones);
		$suma_monto_adelanto=formato_monto($suma_monto_adelanto);	$suma_interes_devengado=formato_monto($suma_interes_devengado);
		$suma_interes_pagado=formato_monto($suma_interes_pagado);  $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
			
	  }
	  $Gtotal_prest=formato_monto($Gtotal_prest); 	$Gtotal_adelanto=formato_monto($Gtotal_adelanto); 
	  $Gtotal_saldo_p=formato_monto($Gtotal_saldo_p); $Gtotal_interes_noacum=formato_monto($Gtotal_interes_noacum); 
	  $Gtotal_interes_acum=formato_monto($Gtotal_interes_acum); 	$Gtotal_acumulado=formato_monto($Gtotal_acumulado); 
      $Gtotal_interes=formato_monto($Gtotal_interes); $Gtotal_saldo=formato_monto($Gtotal_saldo);
	  $subt_categoria=formato_monto($subt_categoria);
	  $pdf->SetFont('Arial','',9);
	  $mcodigo=$prev_categoria.$mcod_part;
	  $pdf->Cell(30,6,'',0,0);
	  $pdf->Cell(50,6,$mcodigo,'L',0);			
	  $pdf->Cell(25,6,$subt_categoria,'R',1,'R');
	  
	  $pdf->SetFont('Arial','B',9);
	  $pdf->Cell(30,6,'',0,0);      
	  $pdf->Cell(50,6,'TOTALES :','LTB',0,'R');	
	  $pdf->Cell(25,6,$Gtotal_prest,'RTB',1,'R');
	  $pdf->Output(); 
    }
	
	if($tipo_rpt=="PDF5"){ $res=pg_query($sSQL); $filas=pg_num_rows($res); $mes=""; $periodof=""; $cod_empleado_grupo=""; 	$nombre_grupo="";  $cedula_grupo=""; $fechai_grupo=""; $prev_cod_empleado=""; 
	  if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; 
	    $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; $prev_cod_empleado=$cod_empleado; 
		$mes=substr($registro["fechac"],3,2); $periodof=Calcula_dif_fechas($fechai,$fecha_h);
	  }	
	  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1;  global $fecha_d; global $fecha_h; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,30);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,7,'RELACION  DIAS DE SUELDOS A DEPOSITAR',1,0,'C');
			$this->Ln(20);	
            $this->SetFont('Arial','B',9); 	
            $this->Cell(50,5,"Fecha de Proceso Desde : ".$fecha_d." Hasta : ".$fecha_h,0,1,'L');			
			$this->SetFont('Arial','B',7);
			$this->Cell(15,4,'Codigo ','RTL',0,'C');
			$this->Cell(120,4,'','RTL',0,'C');
			$this->Cell(15,4,'Fecha ','RTL',0,'C');
			$this->Cell(20,4,'Sueldo','RTL',0,'C');
			$this->Cell(10,4,'','RTL',0,'C');
			$this->Cell(20,4,'Monto','TRL',1,'C');
			$this->Cell(15,4,'Trabajador','BLR',0,'C');
			$this->Cell(120,4,'Nombre Tabajador ','BR',0,'C');
			$this->Cell(15,4,'Ingreso','BR',0,'C');
			$this->Cell(20,4,'Prestaciones','BR',0,'C');
			$this->Cell(10,4,'Dias','BR',0,'C');
			$this->Cell(20,4,'Deposito','BRL',1,'C');
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
		if($prev_cod_empleado<>$cod_empleado_grupo){  $saldo=$suma_c_prestaciones+$suma_interes_devengado;  $prev_cod_empleado=$cod_empleado_grupo;
		    $Gtotal_prest=$Gtotal_prest+$suma_c_prestaciones; 	$Gtotal_interes=$Gtotal_interes+$suma_interes_devengado; $Gtotal_saldo=$Gtotal_saldo+$saldo; $cant_trab=$cant_trab+1;
			
		    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
			$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
			$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
			$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
			$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
			$suma_c_prestaciones=formato_monto($suma_c_prestaciones); $total_prestaciones=formato_monto($total_prestaciones);
		    $suma_monto_adelanto=formato_monto($suma_monto_adelanto); $suma_interes_devengado=formato_monto($suma_interes_devengado);
		    $suma_interes_pagado=formato_monto($suma_interes_pagado); $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,4,$cod_empleado,0,0,'L');
			$pdf->Cell(120,4,$nombre,0,0,'L');
			$pdf->Cell(15,4,$fechai,0,0,'L');
			$pdf->Cell(20,4,$sueldo_calculo,0,0,'R');  		
            $pdf->Cell(10,4,$suma_dias,0,0,'C');
			$pdf->Cell(20,4,$suma_c_prestaciones,0,1,'R');	
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
		$suma_c_prestaciones=$suma_c_prestaciones+$monto_prestaciones;
		$suma_monto_adelanto=$suma_monto_adelanto+$monto_adelanto;
		$suma_interes_devengado=$suma_interes_devengado+$interes_devengado;
		$suma_interes_pagado=$suma_interes_pagado+$interes_pagado;
      }
	  if($i>0){ $saldo=$suma_c_prestaciones+$suma_interes_devengado; 
	    $Gtotal_prest=$Gtotal_prest+$suma_c_prestaciones; 	$Gtotal_interes=$Gtotal_interes+$suma_interes_devengado; $Gtotal_saldo=$Gtotal_saldo+$saldo; $cant_trab=$cant_trab+1;
	    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
		$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
		$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
		$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
		$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
		$suma_c_prestaciones=formato_monto($suma_c_prestaciones);  $total_prestaciones=formato_monto($total_prestaciones);
		$suma_monto_adelanto=formato_monto($suma_monto_adelanto);	$suma_interes_devengado=formato_monto($suma_interes_devengado);
		$suma_interes_pagado=formato_monto($suma_interes_pagado);  $saldo_prestaciones=formato_monto($saldo_prestaciones); $saldo=formato_monto($saldo);
		$pdf->Cell(15,4,$cod_empleado,0,0,'L');
		$pdf->Cell(120,4,$nombre,0,0,'L');
		$pdf->Cell(15,4,$fechai,0,0,'L');
		$pdf->Cell(20,4,$sueldo_calculo,0,0,'R');  		
		$pdf->Cell(10,4,$suma_dias,0,0,'C');
		$pdf->Cell(20,4,$suma_c_prestaciones,0,1,'R');	
	  }
	  $Gtotal_prest=formato_monto($Gtotal_prest); 	$Gtotal_adelanto=formato_monto($Gtotal_adelanto); 
	  $Gtotal_saldo_p=formato_monto($Gtotal_saldo_p); $Gtotal_interes_noacum=formato_monto($Gtotal_interes_noacum); 
	  $Gtotal_interes_acum=formato_monto($Gtotal_interes_acum); 	$Gtotal_acumulado=formato_monto($Gtotal_acumulado); 
      $Gtotal_interes=formato_monto($Gtotal_interes); $Gtotal_saldo=formato_monto($Gtotal_saldo);
	  $pdf->SetFont('Arial','B',8);
	  $pdf->Cell(180,2,'',0,0);
      $pdf->Cell(20,2,'============',0,1,'R');
	  $pdf->Cell(50,5,"Nro. Trabjadores ".$cant_trab,0,0,'L');
	  $pdf->Cell(130,5,'TOTALES :',0,0,'R');	
	  $pdf->Cell(20,5,$Gtotal_prest,0,1,'R');
	  $pdf->Output(); 
    }
   
}
?>
