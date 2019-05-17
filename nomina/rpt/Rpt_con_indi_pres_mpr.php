<? include ("../../class/conect.php");  require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php");  include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $cod_empleado_d=$_GET["cod_empleado_d"]; $cod_empleado_h=$_GET["cod_empleado_h"];    $fecha_h=$_GET["fecha_h"];   $estatus=$_GET["estatus"]; $tipo_nominad=$_GET["tipo_nominad"];  $tipo_nominah=$_GET["tipo_nominah"];   
   $detalle=$_GET["detalle"]; $tipo_rpt=$_GET["tipo_rpt"];  $Sql="";   $date=date("d-m-Y");   $hora=date("h:i:s a"); $criterio1="";
   if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;
   
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
    $criterio=" (nom006.cod_empleado=nom030.cod_empleado) and (nom006.cod_empleado>='".$cod_empleado_d."' and nom006.cod_empleado<='".$cod_empleado_h."') and (nom006.tipo_nomina>='".$tipo_nominad."' AND nom006.tipo_nomina<='".$tipo_nominah."') and nom030.fecha_calculo<='".$fecha_hasta."'";
    if (($estatus=='TODOS'))  { $criterio=$criterio; } else {  $criterio=$criterio." AND nom006.Status ='".$estatus."'";  }
    $sSQL = "SELECT nom006.nombre,nom006.cedula,nom006.fecha_ingreso,nom030.cod_empleado,nom030.fecha_calculo,nom030.num_calculo,nom030.tipo_calculo,nom030.sueldo_calculo,nom030.dias_prestaciones,nom030.c_prestaciones,nom030.sueldo_calculo_adic,nom030.dias_adicionales,nom030.c_presta_adic,nom030.monto_prestaciones,nom030.total_prestaciones,nom030.monto_adelanto,nom030.total_adelanto,
	         nom030.monto_prestamo,nom030.total_prestamo,nom030.saldo_prestaciones,nom030.interes_devengado,nom030.interes_noacum,nom030.interes_acum,nom030.interes_pagado,nom030.total_interes,nom030.tasa_interes,nom030.tiempo_variacion,nom030.acumulado_total,to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as fechai, to_char(nom030.fecha_calculo,'DD/MM/YYYY') as fechac, nom001.descripcion, nom004.denominacion  
			 FROM nom030,(nom006 left join nom001 on (nom006.tipo_nomina=nom001.tipo_nomina) ) left join nom004 on (nom004.codigo_cargo=nom006.cod_cargo) WHERE ".$criterio." ORDER BY nom030.cod_empleado,nom030.fecha_calculo,nom030.num_calculo";
    if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_con_indi_pres_mpr_re.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("$host");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();
    }
	
	
	
	if($tipo_rpt=="PDF2"){ $res=pg_query($sSQL); $filas=pg_num_rows($res); $mes=""; $periodof=""; $cod_empleado_grupo=""; 	$nombre_grupo="";  $cedula_grupo=""; $fechai_grupo=""; $prev_cod_empleado=""; 
	  if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; 
	    $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; $prev_cod_empleado=$cod_empleado; 
	    $descripcion_nomina=$registro["descripcion"]; $den_cargo=$registro["denominacion"]; $mes=substr($registro["fechac"],3,2); $periodof=Calcula_dif_fechas($fechai,$fecha_h);
	  }
	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $descripcion_nomina; global $den_cargo; global $cod_empleado_grupo; global $nombre_grupo; global $cedula_grupo; global $fechai_grupo;
		    global $fecha_h; global $periodof;
			$periodof=Calcula_dif_fechas($fechai_grupo,$fecha_h);
			$anof=substr($periodof,0,4); $mesf=substr($periodof,4,2); $diaf=substr($periodof,6,2);
			$anof=$anof*1;
			$this->Image('../../imagenes/Logo_emp.png',7,12,30);
			$this->SetFont('Arial','B',10);
			$this->Cell(100);
			$this->Cell(140,7,'CONTROL INDIVIDUAL DE PRESTACIONES E INTERESES',1,0,'C');
			$this->Ln(20);
			$this->SetFont('Arial','B',9);	
			$this->Cell(200,5,"Trabajador : ".$cod_empleado_grupo." ".$nombre_grupo,0,1,'L');	
			$this->Cell(50,5,"Cedula : ".$cedula_grupo,0,0,'L');
			$this->Cell(50,5,"Fecha Ingreso : ".$fechai_grupo,0,0,'L');
                     $this->Cell(50,5,"Fecha Corte : ".$fecha_h,0,0,'L');
			$this->Cell(100,5,"Tiempo de Trabajo : ".$anof." Años  ".$mesf." Meses  ".$diaf."  Dias",0,1,'L');
                     $this->Cell(100,5,"Cargo : ".$den_cargo,0,0,'L');
                     $this->Cell(100,5,"Nomina : ".$descripcion_nomina,0,1,'L');

			$this->Ln(4);
			$this->SetFont('Arial','B',6);	 			
			$this->Cell(15,4,'Fecha ','RTL',0,'C');
			$this->Cell(15,4,'Devengado','RT',0,'C');
			$this->Cell(15,4,'Devengado','RT',0,'C');			
			$this->Cell(15,4,'Alicuota','RT',0,'C');
			$this->Cell(15,4,'Alicuota','RT',0,'C');
			$this->Cell(15,4,'Salario','RT',0,'C');			
			$this->Cell(15,4,'Dias','RT',0,'C');
			$this->Cell(20,4,'Monto','RT',0,'C');
			$this->Cell(20,4,'Total','RT',0,'C');
			$this->Cell(20,4,'Monto ','RT',0,'C');
			$this->Cell(20,4,'Total','RT',0,'C');
			$this->Cell(20,4,'Saldo','RT',0,'C');
			$this->Cell(20,4,'Tiempo','RT',0,'C');
			$this->Cell(20,4,'(%) Interes','RT',0,'C');
			$this->Cell(20,4,'Interes','RT',0,'C');
			$this->Cell(20,4,'Interes','RT',0,'C');
			$this->Cell(20,4,'Total','RT',0,'C');
			$this->Cell(20,4,'Acumulado ','TRL',1,'C');
			
			
			
			$this->Cell(15,4,'Calculo ','BLR',0,'C');
			$this->Cell(15,4,'Periodo','BR',0,'C');			
			$this->Cell(15,4,'Diario','BR',0,'C');
			$this->Cell(15,4,'Bono Vac.','BR',0,'C');
			$this->Cell(15,4,'Utilidades','BR',0,'C');
			$this->Cell(15,4,'Integral','BR',0,'C');
			$this->Cell(15,4,'Prestac.','BR',0,'C');
			$this->Cell(20,4,'Prestaciones','BR',0,'C');
			$this->Cell(20,4,'Prestaciones','BR',0,'C');
			$this->Cell(20,4,'Adelanto ','BR',0,'C');
			$this->Cell(20,4,'Adelanto','BR',0,'C');
			$this->Cell(20,4,'Prestaciones','BR',0,'C');
			$this->Cell(20,4,'Variacion','BR',0,'C');
			$this->Cell(20,4,'Aplicado','BR',0,'C');
			$this->Cell(20,4,'Devengado','BR',0,'C');
			$this->Cell(20,4,'Pagado','BR',0,'C');
			$this->Cell(20,4,'Interes','BR',0,'C');
			$this->Cell(20,4,'Total ','BRL',1,'C');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(170,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(170,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('L', 'mm', Legal);  
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',8);
	  $i=0;


	  $prev_mes=$mes; $suma_dias=0;$suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0;
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; 
	    $descripcion_nomina=$registro["descripcion"]; $den_cargo=$registro["denominacion"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; 
		$mes=substr($registro["fechac"],3,2);		
		if(($prev_mes<>$mes)or($prev_cod_empleado<>$cod_empleado_grupo)){
		    $sfecha=$fechac; $sueldo_dia_b=$sueldo_dia;
		    $sqlb="Select * FROM nom028 where (cod_empleado='$prev_cod_empleado') and (fecha_sueldo='$sfecha')"; $resb=pg_query($sqlb);$filasb=pg_num_rows($resb);
            if($filasb==0){  $sqlb="Select * FROM nom028 where (cod_empleado='$prev_cod_empleado') and (fecha_sueldo<='$sfecha') order by fecha_sueldo desc"; $resb=pg_query($sqlb);$filasb=pg_num_rows($resb);  }			
			if($filasb>=1){ $regb=pg_fetch_array($resb,0);  $sueldo_calculo=$regb["monto_base"]; $sueldo_dia_b=$regb["campo_num4"];
			   $campo_num1=$regb["campo_num1"]; $campo_num2=$regb["campo_num2"]; $dias=$regb["campo_num3"]; 
			   $campo_num1=formato_monto($campo_num1); $campo_num2=formato_monto($campo_num2); 
			} else { $dias=0; $campo_num1=0; $campo_num2=0; }
			
		    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $sueldo_dia_b=formato_monto($sueldo_dia_b); $c_prestaciones=formato_monto($c_prestaciones);
			$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
			$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
			$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
			$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
			$suma_c_prestaciones=formato_monto($suma_c_prestaciones); $total_prestaciones=formato_monto($total_prestaciones);
		    $suma_monto_adelanto=formato_monto($suma_monto_adelanto); $suma_interes_devengado=formato_monto($suma_interes_devengado);
		    $suma_interes_pagado=formato_monto($suma_interes_pagado); $saldo_prestaciones=formato_monto($saldo_prestaciones);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,4,$fechac,0,0,'C');  
			$pdf->Cell(16,4,$sueldo_calculo,0,0,'R'); 
			$pdf->Cell(14,4,$sueldo_dia_b,0,0,'R');
			$pdf->Cell(15,4,$campo_num1,0,0,'R'); 
			$pdf->Cell(15,4,$campo_num2,0,0,'R'); 
			$pdf->Cell(15,4,$sueldo_dia,0,0,'R'); 
			
			//$pdf->Cell(15,4,$dias_prestaciones,0,0,'C'); 
			$pdf->Cell(15,4,$suma_dias,0,0,'C');
			$pdf->Cell(20,4,$suma_c_prestaciones,0,0,'R'); 
			$pdf->Cell(20,4,$total_prestaciones,0,0,'R');
			$pdf->Cell(20,4,$suma_monto_adelanto,0,0,'R');  
			$pdf->Cell(20,4,$total_adelanto,0,0,'R');
			$pdf->Cell(20,4,$saldo_prestaciones,0,0,'R');
			$pdf->Cell(20,4,$tiempo_variacion,0,0,'C');
			$pdf->Cell(20,4,$tasa_interes,0,0,'C');
			$pdf->Cell(20,4,$suma_interes_devengado,0,0,'R');
			$pdf->Cell(20,4,$suma_interes_pagado,0,0,'R');			
			$pdf->Cell(20,4,$total_interes,0,0,'R');
			$pdf->Cell(20,4,$acumulado_total,0,1,'R');
		    $prev_mes=$mes;   $suma_dias=0;$suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0;
	        if($prev_cod_empleado<>$cod_empleado_grupo){ $g_total=formato_monto($g_total);
			  $pdf->Ln(10);		  
			  $pdf->SetFont('Arial','B',8);
			  $pdf->Cell(100,4,'PRESTACIONES DE ANTIGUEDAD ART. 142 :',0,0,'L'); 
			  $pdf->Cell(25,4,$total_prestaciones,0,0,'R');
			  $pdf->Cell(30,4,'',0,0,'R');
			  $pdf->Cell(100,4,'ADELANTOS DE PRESTACIONES DE ANTIGUEDAD ART. 144 :',0,0,'L'); 
			  $pdf->Cell(25,4,$total_adelanto,0,1,'R');		  
			  $pdf->Cell(100,4,'INTERESES DE PRESTACIONES DE ANTIGUEDAD ART. 143 :',0,0,'L'); 
			  $pdf->Cell(25,4,$total_interes,0,1,'R');
			  $pdf->Cell(100,5,'TOTAL :',0,0,'R'); 
			  $pdf->Cell(25,5,$g_total,'T',1,'R');
			  $prev_cod_empleado=$cod_empleado_grupo; 
			  $pdf->AddPage();
			}	
		}
		
	    $fechac=$registro["fechac"]; $num_calculo=$registro["num_calculo"];  $sueldo_calculo=$registro["sueldo_calculo"];  $sueldo_dia=($registro["sueldo_calculo"]/30);
	    $dias_prestaciones=$registro["dias_prestaciones"]; $c_prestaciones=$registro["c_prestaciones"]; $sueldo_calculo_adic=$registro["sueldo_calculo_adic"];  $sueldo_dia_adic=($registro["sueldo_calculo_adic"]/30);
		$dias_adicionales=$registro["dias_adicionales"]; $c_presta_adic=$registro["c_presta_adic"]; $monto_prestaciones=$registro["monto_prestaciones"]; 
		$total_prestaciones=$registro["total_prestaciones"]; $monto_adelanto=$registro["monto_adelanto"]; $total_adelanto=$registro["total_adelanto"];
		$interes_devengado=$registro["interes_devengado"]; $interes_noacum=$registro["interes_noacum"]; $interes_acum=$registro["interes_acum"]; 
		$interes_pagado=$registro["interes_pagado"];  $total_interes=$registro["total_interes"]; $tasa_interes=$registro["tasa_interes"]; 
		$tiempo_variacion=$registro["tiempo_variacion"]; $acumulado_total=$registro["acumulado_total"]; $tipo_calculo=$registro["tipo_calculo"];
		$saldo_prestaciones=$registro["saldo_prestaciones"]; $g_total=$saldo_prestaciones+$total_interes;		
		$t_prestaciones=$total_prestaciones-$c_presta_adic;
		if($tipo_calculo=="P"){ $suma_dias=$suma_dias+$dias_prestaciones+$dias_adicionales; }
		$suma_c_prestaciones=$suma_c_prestaciones+$c_prestaciones+$c_presta_adic;
		$suma_monto_adelanto=$suma_monto_adelanto+$monto_adelanto;
		$suma_interes_devengado=$suma_interes_devengado+$interes_devengado;
		$suma_interes_pagado=$suma_interes_pagado+$interes_pagado;
      }
	  if($i>0){
	    $sfecha=$fechac; $sueldo_dia_b=$sueldo_dia;
		$sqlb="Select * FROM nom028 where (cod_empleado='$prev_cod_empleado') and (fecha_sueldo='$sfecha')"; $resb=pg_query($sqlb);$filasb=pg_num_rows($resb);
		if($filasb==0){  $sqlb="Select * FROM nom028 where (cod_empleado='$prev_cod_empleado') and (fecha_sueldo<='$sfecha') order by fecha_sueldo desc"; $resb=pg_query($sqlb);$filasb=pg_num_rows($resb);  }			
		if($filasb>=1){ $regb=pg_fetch_array($resb,0);  $sueldo_calculo=$regb["monto_base"]; $sueldo_dia_b=$regb["campo_num4"];
		   $campo_num1=$regb["campo_num1"]; $campo_num2=$regb["campo_num2"]; $dias=$regb["campo_num3"]; 
		   $campo_num1=formato_monto($campo_num1); $campo_num2=formato_monto($campo_num2); 
		} else { $dias=0; $campo_num1=0; $campo_num2=0; }
	    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
		$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
		$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
		$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
		$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
		$suma_c_prestaciones=formato_monto($suma_c_prestaciones);  $total_prestaciones=formato_monto($total_prestaciones);
		$suma_monto_adelanto=formato_monto($suma_monto_adelanto);	$suma_interes_devengado=formato_monto($suma_interes_devengado);
		$suma_interes_pagado=formato_monto($suma_interes_pagado);  $saldo_prestaciones=formato_monto($saldo_prestaciones);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(15,4,$fechac,0,0,'C');  
		$pdf->Cell(16,4,$sueldo_calculo,0,0,'R'); 
		$pdf->Cell(14,4,$sueldo_dia_b,0,0,'R');
		$pdf->Cell(15,4,$campo_num1,0,0,'R'); 
		$pdf->Cell(15,4,$campo_num2,0,0,'R'); 
		$pdf->Cell(15,4,$sueldo_dia,0,0,'R'); 
		//$pdf->Cell(20,4,$dias_prestaciones,0,0,'C');
              $pdf->Cell(15,4,$suma_dias,0,0,'C');		
		$pdf->Cell(20,4,$suma_c_prestaciones,0,0,'R'); 
		$pdf->Cell(20,4,$total_prestaciones,0,0,'R');
		$pdf->Cell(20,4,$suma_monto_adelanto,0,0,'R');  
		$pdf->Cell(20,4,$total_adelanto,0,0,'R');
		$pdf->Cell(20,4,$saldo_prestaciones,0,0,'R');
		$pdf->Cell(20,4,$tiempo_variacion,0,0,'C');
		$pdf->Cell(20,4,$tasa_interes,0,0,'C');
		$pdf->Cell(20,4,$suma_interes_devengado,0,0,'R');
		$pdf->Cell(20,4,$suma_interes_pagado,0,0,'R');
		
		$pdf->Cell(20,4,$total_interes,0,0,'R');
		$pdf->Cell(20,4,$acumulado_total,0,1,'R');
		$g_total=formato_monto($g_total);
		$pdf->Ln(10);		  
			  $pdf->SetFont('Arial','B',8);
			  $pdf->Cell(100,4,'PRESTACIONES DE ANTIGUEDAD ART. 142 :',0,0,'L'); 
			  $pdf->Cell(25,4,$total_prestaciones,0,0,'R');
			  $pdf->Cell(30,4,'',0,0,'R');
			  $pdf->Cell(100,4,'ADELANTOS DE PRESTACIONES DE ANTIGUEDAD ART. 144 :',0,0,'L'); 
			  $pdf->Cell(25,4,$total_adelanto,0,1,'R');		  
			  $pdf->Cell(100,4,'INTERESES DE PRESTACIONES DE ANTIGUEDAD ART. 143 :',0,0,'L'); 
			  $pdf->Cell(25,4,$total_interes,0,1,'R');
			  $pdf->Cell(100,5,'TOTAL :',0,0,'R'); 
			  $pdf->Cell(25,5,$g_total,'T',1,'R');
			  
	    $prev_cod_empleado=$cod_empleado_grupo; 
	  } 
	  $pdf->Output();  
    }
	
	
    if($tipo_rpt=="PDF"){ $res=pg_query($sSQL); $filas=pg_num_rows($res); $mes=""; $periodof=""; $cod_empleado_grupo=""; 	$nombre_grupo="";  $cedula_grupo=""; $fechai_grupo=""; $prev_cod_empleado=""; 
	  if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; 
	    $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; $prev_cod_empleado=$cod_empleado; 
		$mes=substr($registro["fechac"],3,2); $periodof=Calcula_dif_fechas($fechai,$fecha_h);
	  }
	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $cod_empleado_grupo; global $nombre_grupo; global $cedula_grupo; global $fechai_grupo;
		    global $fecha_h; global $periodof;
			$periodof=Calcula_dif_fechas($fechai_grupo,$fecha_h);
			$anof=substr($periodof,0,4); $mesf=substr($periodof,4,2); $diaf=substr($periodof,6,2);
			$anof=$anof*1;
			$this->Image('../../imagenes/Logo_emp.png',7,12,30);
			$this->SetFont('Arial','B',10);
			$this->Cell(100);
			$this->Cell(140,7,'CONTROL INDIVIDUAL DE PRESTACIONES E INTERESES',1,0,'C');
			$this->Ln(20);
			$this->SetFont('Arial','B',9);	
			$this->Cell(200,5,"Trabajador : ".$cod_empleado_grupo." ".$nombre_grupo,0,1,'L');	
			$this->Cell(50,5,"Cedula : ".$cedula_grupo,0,0,'L');
			$this->Cell(50,5,"Fecha Ingreso : ".$fechai_grupo,0,0,'L');
            $this->Cell(50,5,"Fecha Corte : ".$fecha_h,0,0,'L');
			$this->Cell(100,5,"Tiempo de Trabajo : ".$anof." Años  ".$mesf." Meses  ".$diaf."  Dias",0,1,'L');
			$this->SetFont('Arial','B',6);	 			
			$this->Cell(15,4,'Fecha ','RTL',0,'C');
			$this->Cell(15,4,'Sueldo','RT',0,'C');
			$this->Cell(15,4,'Sueldo','RT',0,'C');
			$this->Cell(20,4,'Dias','RT',0,'C');
			$this->Cell(20,4,'Monto','RT',0,'C');
			$this->Cell(20,4,'Total','RT',0,'C');
			$this->Cell(20,4,'Monto ','RT',0,'C');
			$this->Cell(20,4,'Total','RT',0,'C');
			$this->Cell(20,4,'Saldo','RT',0,'C');
			$this->Cell(20,4,'Tiempo','RT',0,'C');
			$this->Cell(20,4,'(%) Interes','RT',0,'C');
			$this->Cell(20,4,'Interes','RT',0,'C');
			$this->Cell(20,4,'Interes','RT',0,'C');
			$this->Cell(20,4,'Interes No','RT',0,'C');
			$this->Cell(20,4,'Interes','RT',0,'C');
			$this->Cell(20,4,'Total','RT',0,'C');
			$this->Cell(20,4,'Acumulado ','RT',0,'C');
			$this->Cell(15,4,'Tipo','TRL',1,'C');
			
			$this->Cell(15,4,'Calculo ','BLR',0,'C');
			$this->Cell(15,4,'','BR',0,'C');
			$this->Cell(15,4,'Diario','BR',0,'C');
			$this->Cell(20,4,'Prestaciones','BR',0,'C');
			$this->Cell(20,4,'Prestaciones','BR',0,'C');
			$this->Cell(20,4,'Prestaciones','BR',0,'C');
			$this->Cell(20,4,'Adelanto ','BR',0,'C');
			$this->Cell(20,4,'Adelanto','BR',0,'C');
			$this->Cell(20,4,'Prestaciones','BR',0,'C');
			$this->Cell(20,4,'Variacion','BR',0,'C');
			$this->Cell(20,4,'Aplicado','BR',0,'C');
			$this->Cell(20,4,'Devengado','BR',0,'C');
			$this->Cell(20,4,'Pagado','BR',0,'C');
			$this->Cell(20,4,'Capitalizado','BR',0,'C');
			$this->Cell(20,4,'Capitalizado','BR',0,'C');
			$this->Cell(20,4,'Interes','BR',0,'C');
			$this->Cell(20,4,'Total ','BR',0,'C');
			$this->Cell(15,4,'Movimiento','BRL',1,'C');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(170,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(170,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('L', 'mm', Legal);  
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',8);
	  $i=0;
	  if($detalle=="SI"){ 
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; 
	    $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; 
		if($prev_cod_empleado<>$cod_empleado_grupo){ $g_total=formato_monto($g_total);
		  $pdf->Ln(10);		  
		  $pdf->SetFont('Arial','B',9);
	      $pdf->Cell(100,4,'PRESTACIONES DE ANTIGUEDAD ART. 142 :',0,0,'L'); 
		  $pdf->Cell(25,4,$total_prestaciones,0,0,'R');
		  $pdf->Cell(30,4,'',0,0,'R');
		  $pdf->Cell(100,4,'ADELANTOS DE PRESTACIONES DE ANTIGUEDAD ART. 144 :',0,0,'L'); 
		  $pdf->Cell(25,4,$total_adelanto,0,1,'R');		  
		  $pdf->Cell(100,4,'INTERESES DE PRESTACIONES DE ANTIGUEDAD ART. 143 :',0,0,'L'); 
		  $pdf->Cell(25,4,$total_interes,0,1,'R');
		  $pdf->Cell(100,5,'TOTAL :',0,0,'R'); 
		  $pdf->Cell(25,5,$g_total,'T',1,'R');
		  $prev_cod_empleado=$cod_empleado_grupo;  $periodof=Calcula_dif_fechas($fechai,$fecha_h);
		  $pdf->AddPage();
		} 
	    $fechac=$registro["fechac"]; $num_calculo=$registro["num_calculo"];  $sueldo_calculo=$registro["sueldo_calculo"];  $sueldo_dia=($registro["sueldo_calculo"]/30);
	    $dias_prestaciones=$registro["dias_prestaciones"]; $c_prestaciones=$registro["c_prestaciones"]; $sueldo_calculo_adic=$registro["sueldo_calculo_adic"];  $sueldo_dia_adic=($registro["sueldo_calculo_adic"]/30);
		$dias_adicionales=$registro["dias_adicionales"]; $c_presta_adic=$registro["c_presta_adic"]; $monto_prestaciones=$registro["monto_prestaciones"]; 
		$total_prestaciones=$registro["total_prestaciones"]; $monto_adelanto=$registro["monto_adelanto"]; $total_adelanto=$registro["total_adelanto"];
		$interes_devengado=$registro["interes_devengado"]; $interes_noacum=$registro["interes_noacum"]; $interes_acum=$registro["interes_acum"]; 
		$interes_pagado=$registro["interes_pagado"];  $total_interes=$registro["total_interes"]; $tasa_interes=$registro["tasa_interes"]; 
		$tiempo_variacion=$registro["tiempo_variacion"]; $acumulado_total=$registro["acumulado_total"]; $tipo_calculo=$registro["tipo_calculo"];
		$saldo_prestaciones=$registro["saldo_prestaciones"]; $g_total=$saldo_prestaciones+$total_interes;
		$t_prestaciones=$total_prestaciones-$c_presta_adic; 
		$sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
		$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic);
		$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
		$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado);
		$interes_noacum=formato_monto($interes_noacum); $interes_acum=formato_monto($interes_acum);
		$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
		$t_prestaciones=formato_monto($t_prestaciones); $saldo_prestaciones=formato_monto($saldo_prestaciones); $total_prestaciones=formato_monto($total_prestaciones);
		if($tipo_calculo<>"P"){ $dias_prestaciones=0; }
        $pdf->SetFont('Arial','',8);
	    $pdf->Cell(15,4,$fechac,0,0,'C');  
	    $pdf->Cell(16,4,$sueldo_calculo,0,0,'R'); 
	    $pdf->Cell(14,4,$sueldo_dia,0,0,'R');
	    $pdf->Cell(20,4,$dias_prestaciones,0,0,'C'); 
	    $pdf->Cell(20,4,$c_prestaciones,0,0,'R'); 
	    $pdf->Cell(20,4,$t_prestaciones,0,0,'R');
	    $pdf->Cell(20,4,$monto_adelanto,0,0,'R');  
		$pdf->Cell(20,4,$total_adelanto,0,0,'R');
		$pdf->Cell(20,4,$saldo_prestaciones,0,0,'R');
		$pdf->Cell(20,4,$tiempo_variacion,0,0,'C');
		$pdf->Cell(20,4,$tasa_interes,0,0,'C');
		$pdf->Cell(20,4,$interes_devengado,0,0,'R');
		$pdf->Cell(20,4,$interes_pagado,0,0,'R');
		$pdf->Cell(20,4,$interes_noacum,0,0,'R');
		$pdf->Cell(20,4,$interes_acum,0,0,'R');
		$pdf->Cell(20,4,$total_interes,0,0,'R');
		$pdf->Cell(20,4,$acumulado_total,0,0,'R');
	    $pdf->Cell(15,4,$tipo_calculo,0,1,'C');
		if ($dias_adicionales<>0){ $monto_cero=0; $monto_cero=formato_monto($monto_cero); $c_presta_adic=formato_monto($c_presta_adic); 
		   $pdf->Cell(15,4,$fechac,0,0,'C');  
		   $pdf->Cell(16,4,$sueldo_calculo,0,0,'R'); 
		   $pdf->Cell(14,4,$sueldo_dia,0,0,'R');
		   $pdf->Cell(20,4,$dias_adicionales,0,0,'C'); 
		   $pdf->Cell(20,4,$c_presta_adic,0,0,'R'); 
		   $pdf->Cell(20,4,$total_prestaciones,0,0,'R');
		   $pdf->Cell(20,4,$monto_cero,0,0,'R');  
		   $pdf->Cell(20,4,$total_adelanto,0,0,'R');
		   $pdf->Cell(20,4,$saldo_prestaciones,0,0,'R');
		   $pdf->Cell(20,4,$monto_cero,0,0,'C');
		   $pdf->Cell(20,4,$monto_cero,0,0,'C');
		   $pdf->Cell(20,4,$monto_cero,0,0,'R');
		   $pdf->Cell(20,4,$monto_cero,0,0,'R');
		   $pdf->Cell(20,4,$interes_noacum,0,0,'R');
		   $pdf->Cell(20,4,$interes_acum,0,0,'R');
		   $pdf->Cell(20,4,$total_interes,0,0,'R');
		   $pdf->Cell(20,4,$acumulado_total,0,0,'R');
		   $pdf->Cell(15,4,$tipo_calculo,0,1,'C');
		}		
      }
	  if($i>0){ $g_total=formato_monto($g_total);
		  $pdf->Ln(10);		  
		  $pdf->SetFont('Arial','B',9);
	      $pdf->Cell(100,4,'PRESTACIONES DE ANTIGUEDAD ART. 142 :',0,0,'L'); 
		  $pdf->Cell(25,4,$total_prestaciones,0,0,'R');
		  $pdf->Cell(30,4,'',0,0,'R');
		  $pdf->Cell(100,4,'ADELANTOS DE PRESTACIONES DE ANTIGUEDAD ART. 144 :',0,0,'L'); 
		  $pdf->Cell(25,4,$total_adelanto,0,1,'R');		  
		  $pdf->Cell(100,4,'INTERESES DE PRESTACIONES DE ANTIGUEDAD ART. 143 :',0,0,'L'); 
		  $pdf->Cell(25,4,$total_interes,0,1,'R');
		  $pdf->Cell(100,5,'TOTAL :',0,0,'R'); 
		  $pdf->Cell(25,5,$g_total,'T',1,'R');
		  $prev_cod_empleado=$cod_empleado_grupo;
	  } 
	  }else{ $prev_mes=$mes; $suma_dias=0;$suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0;
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; 
	    $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; 
		$mes=substr($registro["fechac"],3,2);		
		if(($prev_mes<>$mes)or($prev_cod_empleado<>$cod_empleado_grupo)){
		    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
			$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
			$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
			$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
			$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
			$suma_c_prestaciones=formato_monto($suma_c_prestaciones); $total_prestaciones=formato_monto($total_prestaciones);
		    $suma_monto_adelanto=formato_monto($suma_monto_adelanto); $suma_interes_devengado=formato_monto($suma_interes_devengado);
		    $suma_interes_pagado=formato_monto($suma_interes_pagado); $saldo_prestaciones=formato_monto($saldo_prestaciones);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,4,$fechac,0,0,'C');  
			$pdf->Cell(16,4,$sueldo_calculo,0,0,'R'); 
			$pdf->Cell(14,4,$sueldo_dia,0,0,'R');
			$pdf->Cell(20,4,$dias_prestaciones,0,0,'C'); 
			$pdf->Cell(20,4,$suma_c_prestaciones,0,0,'R'); 
			$pdf->Cell(20,4,$total_prestaciones,0,0,'R');
			$pdf->Cell(20,4,$suma_monto_adelanto,0,0,'R');  
			$pdf->Cell(20,4,$total_adelanto,0,0,'R');
			$pdf->Cell(20,4,$saldo_prestaciones,0,0,'R');
			$pdf->Cell(20,4,$tiempo_variacion,0,0,'C');
			$pdf->Cell(20,4,$tasa_interes,0,0,'C');
			$pdf->Cell(20,4,$suma_interes_devengado,0,0,'R');
			$pdf->Cell(20,4,$suma_interes_pagado,0,0,'R');
			$pdf->Cell(20,4,$interes_noacum,0,0,'R');
			$pdf->Cell(20,4,$interes_acum,0,0,'R');
			$pdf->Cell(20,4,$total_interes,0,0,'R');
			$pdf->Cell(20,4,$acumulado_total,0,0,'R');
			$pdf->Cell(15,4,$tipo_calculo,0,1,'C');
		    $prev_mes=$mes; $suma_dias=0;$suma_c_prestaciones=0;$suma_total_prestaciones=0;$suma_monto_adelanto=0; $suma_interes_devengado=0; $suma_interes_pagado=0;
		}
		if($prev_cod_empleado<>$cod_empleado_grupo){ $g_total=formato_monto($g_total);
		  $pdf->Ln(10);		  
		  $pdf->SetFont('Arial','B',8);
	      $pdf->Cell(100,4,'PRESTACIONES DE ANTIGUEDAD ART. 142 :',0,0,'L'); 
		  $pdf->Cell(25,4,$total_prestaciones,0,0,'R');
		  $pdf->Cell(30,4,'',0,0,'R');
		  $pdf->Cell(100,4,'ADELANTOS DE PRESTACIONES DE ANTIGUEDAD ART. 144 :',0,0,'L'); 
		  $pdf->Cell(25,4,$total_adelanto,0,1,'R');		  
		  $pdf->Cell(100,4,'INTERESES DE PRESTACIONES DE ANTIGUEDAD ART. 143 :',0,0,'L'); 
		  $pdf->Cell(25,4,$total_interes,0,1,'R');
		  $pdf->Cell(100,5,'TOTAL :',0,0,'R'); 
		  $pdf->Cell(25,5,$g_total,'T',1,'R');
		  $prev_cod_empleado=$cod_empleado_grupo; 
		  $pdf->AddPage();
		} 
	    $fechac=$registro["fechac"]; $num_calculo=$registro["num_calculo"];  $sueldo_calculo=$registro["sueldo_calculo"];  $sueldo_dia=($registro["sueldo_calculo"]/30);
	    $dias_prestaciones=$registro["dias_prestaciones"]; $c_prestaciones=$registro["c_prestaciones"]; $sueldo_calculo_adic=$registro["sueldo_calculo_adic"];  $sueldo_dia_adic=($registro["sueldo_calculo_adic"]/30);
		$dias_adicionales=$registro["dias_adicionales"]; $c_presta_adic=$registro["c_presta_adic"]; $monto_prestaciones=$registro["monto_prestaciones"]; 
		$total_prestaciones=$registro["total_prestaciones"]; $monto_adelanto=$registro["monto_adelanto"]; $total_adelanto=$registro["total_adelanto"];
		$interes_devengado=$registro["interes_devengado"]; $interes_noacum=$registro["interes_noacum"]; $interes_acum=$registro["interes_acum"]; 
		$interes_pagado=$registro["interes_pagado"];  $total_interes=$registro["total_interes"]; $tasa_interes=$registro["tasa_interes"]; 
		$tiempo_variacion=$registro["tiempo_variacion"]; $acumulado_total=$registro["acumulado_total"]; $tipo_calculo=$registro["tipo_calculo"];
		$saldo_prestaciones=$registro["saldo_prestaciones"]; $g_total=$saldo_prestaciones+$total_interes;		
		$t_prestaciones=$total_prestaciones-$c_presta_adic;
		if($tipo_calculo=="P"){ $suma_dias=$suma_dias+$dias_prestaciones+$dias_adicionales; }
		$suma_c_prestaciones=$suma_c_prestaciones+$c_prestaciones+$c_presta_adic;
		$suma_monto_adelanto=$suma_monto_adelanto+$monto_adelanto;
		$suma_interes_devengado=$suma_interes_devengado+$interes_devengado;
		$suma_interes_pagado=$suma_interes_pagado+$interes_pagado;
      }
	  if($i>0){
	    $sueldo_calculo=formato_monto($sueldo_calculo); $sueldo_dia=formato_monto($sueldo_dia); $c_prestaciones=formato_monto($c_prestaciones);
		$sueldo_calculo_adic=formato_monto($sueldo_calculo_adic); $sueldo_dia_adic=formato_monto($sueldo_dia_adic); $t_prestaciones=formato_monto($t_prestaciones);
		$monto_adelanto=formato_monto($monto_adelanto); $total_adelanto=formato_monto($total_adelanto); $tasa_interes=formato_monto($tasa_interes);
		$interes_devengado=formato_monto($interes_devengado); $interes_pagado=formato_monto($interes_pagado); $interes_noacum=formato_monto($interes_noacum); 
		$interes_acum=formato_monto($interes_acum);	$total_interes=formato_monto($total_interes); $acumulado_total=formato_monto($acumulado_total);
		$suma_c_prestaciones=formato_monto($suma_c_prestaciones);  $total_prestaciones=formato_monto($total_prestaciones);
		$suma_monto_adelanto=formato_monto($suma_monto_adelanto);	$suma_interes_devengado=formato_monto($suma_interes_devengado);
		$suma_interes_pagado=formato_monto($suma_interes_pagado);  $saldo_prestaciones=formato_monto($saldo_prestaciones);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(15,4,$fechac,0,0,'C');  
		$pdf->Cell(16,4,$sueldo_calculo,0,0,'R'); 
		$pdf->Cell(14,4,$sueldo_dia,0,0,'R');
		//$pdf->Cell(20,4,$dias_prestaciones,0,0,'C');
        $pdf->Cell(20,4,$suma_dias,0,0,'C');		
		$pdf->Cell(20,4,$suma_c_prestaciones,0,0,'R'); 
		$pdf->Cell(20,4,$total_prestaciones,0,0,'R');
		$pdf->Cell(20,4,$suma_monto_adelanto,0,0,'R');  
		$pdf->Cell(20,4,$total_adelanto,0,0,'R');
		$pdf->Cell(20,4,$saldo_prestaciones,0,0,'R');
		$pdf->Cell(20,4,$tiempo_variacion,0,0,'C');
		$pdf->Cell(20,4,$tasa_interes,0,0,'C');
		$pdf->Cell(20,4,$suma_interes_devengado,0,0,'R');
		$pdf->Cell(20,4,$suma_interes_pagado,0,0,'R');
		$pdf->Cell(20,4,$interes_noacum,0,0,'R');
		$pdf->Cell(20,4,$interes_acum,0,0,'R');
		$pdf->Cell(20,4,$total_interes,0,0,'R');
		$pdf->Cell(20,4,$acumulado_total,0,0,'R');
		$pdf->Cell(15,4,$tipo_calculo,0,1,'C');
		$g_total=formato_monto($g_total);
		$pdf->Ln(10);		  
	    $pdf->SetFont('Arial','B',9);
	    $pdf->Cell(100,4,'PRESTACIONES DE ANTIGUEDAD ART. 142 :',0,0,'L'); 
	    $pdf->Cell(25,4,$total_prestaciones,0,0,'R');
	    $pdf->Cell(30,4,'',0,0,'R');
	    $pdf->Cell(100,4,'ADELANTOS DE PRESTACIONES DE ANTIGUEDAD ART. 144 :',0,0,'L'); 
	    $pdf->Cell(25,4,$total_adelanto,0,1,'R');		  
	    $pdf->Cell(100,4,'INTERESES DE PRESTACIONES DE ANTIGUEDAD ART. 143 :',0,0,'L'); 
	    $pdf->Cell(25,4,$total_interes,0,1,'R');
	    $pdf->Cell(100,5,'TOTAL :',0,0,'R'); 
	    $pdf->Cell(25,5,$g_total,'T',1,'R');
	    $prev_cod_empleado=$cod_empleado_grupo; 
	  } 
	  }
	  $pdf->Output();  
    }

}
?>
