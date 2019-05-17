<? include ("../../class/conect.php");  require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php");  include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $cod_empleado_d=$_GET["cod_empleado_d"];   $cod_empleado_h=$_GET["cod_empleado_h"];   $fecha_d=$_GET["fecha_d"];  $fecha_h=$_GET["fecha_h"]; 
   $tipo_rpt=$_GET["tipo_rpt"];  $Sql="";   $date=date("d-m-Y");   $hora=date("h:i:s a"); $criterio1="";
   if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
   if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;
   
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}


      $sSQL = "SELECT nom030.cod_empleado, nom006.nombre, nom006.cedula, nom006.fecha_Ingreso, nom030.fecha_calculo, nom030.tipo_calculo, nom030.Sueldo_calculo, nom030.Dias_Prestaciones,
               nom030.monto_Prestaciones, nom030.total_Prestaciones, nom030.monto_Adelanto, nom030.total_Adelanto, nom030.monto_Prestamo, nom030.total_Prestamo, nom030.Saldo_Prestaciones,
               nom030.interes_Devengado, nom030.interes_NoAcum, nom030.interes_Acum, nom030.interes_Pagado, nom030.total_interes, nom030.Tasa_interes, nom030.Tiempo_Variacion, nom030.Acumulado_Total,
			   to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as fechai, to_char(nom030.fecha_calculo,'DD/MM/YYYY') as fechac FROM nom006, nom030
               WHERE nom006.cod_empleado = nom030.cod_empleado AND ((nom030.tipo_calculo<>'C' And nom030.tipo_calculo<>'P')) AND
               nom030.cod_empleado>='".$cod_empleado_d."' AND nom030.cod_empleado<='".$cod_empleado_h."' AND
               nom030.fecha_calculo>='".$fecha_desde."' AND nom030.fecha_calculo<='".$fecha_hasta."'
               ORDER BY nom030.cod_empleado, nom030.fecha_calculo, nom030.num_calculo";

	if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php"); 
          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_lis_movi_pres_inte_mpr_re.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("$host");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"monto"=>$monto,"monto"=>$monto,"date"=>$date,"hora"=>$hora,"fecha_d"=>$fecha_d,"fecha_h"=>$fecha_h));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();

    }
	if($tipo_rpt=="PDF"){ $res=pg_query($sSQL); $filas=pg_num_rows($res); 
	  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1;  global $fecha_d; global $fecha_h; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(120,7,'LISTADO  MOVIMIENTOS  DE  PRESTACIONES  E  INTERESES',1,0,'C');
			$this->Ln(20);	
            $this->SetFont('Arial','B',9); 	
            $this->Cell(50,5,"Fecha de Proceso Desde : ".$fecha_d." Hasta : ".$fecha_h,0,1,'L');			
			$this->SetFont('Arial','B',7);
			$this->Cell(15,4,'Codigo ','RTL',0,'C');
			$this->Cell(15,4,'','RTL',0,'C');
			$this->Cell(115,4,'','RTL',0,'C');
			$this->Cell(15,4,'Fecha','RTL',0,'C');
			$this->Cell(20,4,'Monto','RT',0,'C');
			$this->Cell(20,4,'Pago de','TRL',1,'C');
			$this->Cell(15,3,'Trabajador','BLR',0,'C');
			$this->Cell(15,3,'Cedula','BR',0,'C');
			$this->Cell(115,3,'Nombre Tabajador ','BR',0,'C');
			$this->Cell(15,3,'Movimiento','BR',0,'C');
			$this->Cell(20,3,'Anticipo','BR',0,'C');
			$this->Cell(20,3,'Intereses','BRL',1,'C');
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
	  $i=0; $cant_trab=0; $suma_monto_adelanto=0;  $suma_interes_pagado=0; 
	  //$pdf->MultiCell(200,4,$sSQL,0);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
	    $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $nombre=substr($nombre,0,75);
	    $fecha_ingreso=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fecha_ingreso); if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
		$fechac=$registro["fechac"]; $num_calculo=$registro["num_calculo"];  $monto_adelanto=$registro["monto_adelanto"]; $interes_pagado=$registro["interes_pagado"];
		$suma_monto_adelanto=$suma_monto_adelanto+$monto_adelanto; $suma_interes_pagado=$suma_interes_pagado+$interes_pagado;
		$monto_adelanto=formato_monto($monto_adelanto); $interes_pagado=formato_monto($interes_pagado);
		
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(15,4,$cod_empleado,0,0,'L');
		$pdf->Cell(15,4,$cedula,0,0,'L');
		$pdf->Cell(115,4,$nombre,0,0,'L');
		$pdf->Cell(15,4,$fechac,0,0,'R');  	
		$pdf->Cell(20,4,$monto_adelanto,0,0,'R');
		$pdf->Cell(20,4,$interes_pagado,0,1,'R');
	  }
	  $suma_monto_adelanto=formato_monto($suma_monto_adelanto);	$suma_interes_pagado=formato_monto($suma_interes_pagado);  
	  $pdf->SetFont('Arial','B',8);
	  $pdf->Cell(160,2,'',0,0);
	  $pdf->Cell(20,2,'============',0,0,'R');
      $pdf->Cell(20,2,'============',0,1,'R');
	  $pdf->Cell(160,5,'TOTALES :',0,0,'R');	
	  $pdf->Cell(20,5,$suma_monto_adelanto,0,0,'R');	
	  $pdf->Cell(20,5,$suma_interes_pagado,0,1,'R');
	  
	  $pdf->Output(); 
	}
	
	
}
?>
