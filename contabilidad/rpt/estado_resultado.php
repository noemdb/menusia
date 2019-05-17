<? include ("../../class/conect.php");include ("../../class/fun_fechas.php"); include ("../../class/fun_numeros.php");include ("../../class/configura.inc");
error_reporting(E_ALL ^ E_NOTICE); $date=date("d-m-Y"); $hora=date("H:i:s a"); $php_os=PHP_OS;
$codigo_informe=$_GET["codigo_informe"]; $periodo=$_GET["periodo"]; $frecuencia=$_GET["seleccion"]; 
$periodo_d=$periodo; $periodo_h=$periodo; if($frecuencia=="T"){ if($periodo=="01"){$periodo_h="03";} if($periodo=="02"){$periodo_d="04";$periodo_h="06";}  if($periodo=="03"){$periodo_d="07";$periodo_h="09";}  if($periodo=="04"){$periodo_d="10";$periodo_h="12";}  }
$num_per=$periodo*1; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}else{ $Nom_Emp=busca_conf(); }
$fecha_d=Armar_Fecha($periodo_d, 1, $Fec_Ini_Ejer); $fecha_h=Armar_Fecha($periodo_h,2,$Fec_Ini_Ejer); 
$criterio1="Desde ".$fecha_d." Al ".$fecha_h; $Sql="";
$fecha1=formato_aaaammdd($fecha_d); $fecha2=formato_aaaammdd($fecha_h); $fecha_d=formato_ddmmaaaa($fecha1); $fecha_h=formato_ddmmaaaa($fecha2);
$fecha_ant=$fecha_d;  $fecha_ant=nextmes($fecha_ant,-1);  $fecha_ant=colocar_udiames($fecha_ant);

$sSQL="SELECT *  FROM con006 Where (con006.tipo_informe='$codigo_informe')  order by con006.tipo_informe, con006.linea";
$res=pg_query($sSQL);
require('../../class/fpdf/fpdf.php');
	  class PDF extends FPDF{
		function Header(){ global $criterio1; global $fecha_ant; global $fecha_d; global $fecha_h; global $Nom_Emp; global $periodo;			
			$this->Image('../../imagenes/Logo_emp.png',7,7,25);
			$this->SetFont('Arial','B',10);
			$this->Cell(30);
			$this->Cell(100,5,$Nom_Emp,0,1,'L');
			$this->Ln(5);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(100,10,'ESTADO DE RESULTADO',0,0,'C');
			$this->Ln(15);
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
	$pdf->SetFont('Arial','',7);
	while($registro=pg_fetch_array($res)){ $i=$i+1;  $codigo_cuenta=$registro["codigo_cuenta"];    $nombre_cuenta=$registro["nombre_cuenta"]; 
		$cod_cuenta=$registro["cod_cuenta"]; $status=$registro["status"]; $columna=$registro["columna"];	$status_linea=$registro["status_linea"]; 	  
		if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"]; }else{$nombre_cuenta=utf8_decode($nombre_cuenta); }	
		$mejecutado=0; $mhaber=0;  $mdebe=0; $mejec_acum=0; 
		if($frecuencia=="M"){
		   switch ($num_per) {
				case 1:
					$mejecutado=$registro["saldo_p01"];	$mejec_acum=$registro["acumulado_p01"];
					$mdebe=$registro["debe01"]; $mhaber=$registro["haber01"]; 
					break;
				case 2:
					$mejecutado=$registro["saldo_p02"]; $mejec_acum=$registro["acumulado_p02"];
					$mdebe=$registro["debe02"]; $mhaber=$registro["haber02"]; 
					break;
				case 3:
					$mejecutado=$registro["saldo_p03"]; $mejec_acum=$registro["acumulado_p03"];
					$mdebe=$registro["debe03"]; $mhaber=$registro["haber03"];
					break;
				case 4:
					$mejecutado=$registro["saldo_p04"]; $mejec_acum=$registro["acumulado_p04"];
					$mdebe=$registro["debe04"]; $mhaber=$registro["haber04"];
					break;
				case 5:
					$mejecutado=$registro["saldo_p05"]; $mejec_acum=$registro["acumulado_p05"];
					$mdebe=$registro["debe05"]; $mhaber=$registro["haber05"]; 
					break;
				case 6:
					$mejecutado=$registro["saldo_p06"]; $mejec_acum=$registro["acumulado_p06"];
					$mdebe=$registro["debe06"]; $mhaber=$registro["haber06"]; 
					break;	
				case 7:
					$mejecutado=$registro["saldo_p07"]; $mejec_acum=$registro["acumulado_p07"];
					$mdebe=$registro["debe07"]; $mhaber=$registro["haber07"]; 
					break;	
				case 8:
					$mejecutado=$registro["saldo_p08"]; $mejec_acum=$registro["acumulado_p08"];
					$mdebe=$registro["debe08"]; $mhaber=$registro["haber08"]; 
					break;	
				case 9:
					$mejecutado=$registro["saldo_p09"]; $mejec_acum=$registro["acumulado_p09"];
					$mdebe=$registro["debe09"]; $mhaber=$registro["haber09"]; 
					break;	
				case 10:
					$mejecutado=$registro["saldo_p10"]; $mejec_acum=$registro["acumulado_p10"];
					$mdebe=$registro["debe10"]; $mhaber=$registro["haber10"]; 
					break;	
				case 11:
					$mejecutado=$registro["saldo_p11"]; $mejec_acum=$registro["acumulado_p11"];
					$mdebe=$registro["debe11"]; $mhaber=$registro["haber11"]; 
					break;	
				case 12:
					$mejecutado=$registro["saldo_p12"]; $mejec_acum=$registro["acumulado_p12"];					
					$mdebe=$registro["debe12"]; $mhaber=$registro["haber12"]; 
					break;		
			}
			$mejecutado=$mejec_acum;
		}else{
		   switch ($num_per) {
				case 1:
					$mejec_acum=$registro["acumulado_p03"];	
					$mejecutado=$registro["saldo_p01"]+$registro["saldo_p02"]+$registro["saldo_p03"];
					$mdebe=$registro["debe01"]+$registro["debe02"]+$registro["debe03"]; 
					$mhaber=$registro["haber01"]+$registro["haber02"]+$registro["haber03"];					
					break;
				case 2:
					$mejec_acum=$registro["acumulado_p06"];	
					$mejecutado=$registro["saldo_p04"]+$registro["saldo_p05"]+$registro["saldo_p06"];
					$mdebe=$registro["debe04"]+$registro["debe05"]+$registro["debe06"]; 
					$mhaber=$registro["haber04"]+$registro["haber05"]+$registro["haber06"];					
					break;
				case 3:
					$mejec_acum=$registro["acumulado_p09"];	
					$mejecutado=$registro["saldo_p07"]+$registro["saldo_p08"]+$registro["saldo_p09"];
					$mdebe=$registro["debe07"]+$registro["debe08"]+$registro["debe09"]; 
					$mhaber=$registro["haber07"]+$registro["haber08"]+$registro["haber09"];					
					break;
				case 4:
					$mejec_acum=$registro["acumulado_p12"];	
					$mejecutado=$registro["saldo_p10"]+$registro["saldo_p11"]+$registro["saldo_p12"];
					$mdebe=$registro["debe10"]+$registro["debe11"]+$registro["debe12"]; 
					$mhaber=$registro["haber10"]+$registro["haber11"]+$registro["haber12"];
					$mprox=0;
					break;
			} 
		}
		
		//if($mejecutado==0){$mejecutado="";}else{$mejecutado=number_format($mejecutado,2,",", "."); }
		//if($mejec_acum==0){$mejec_acum="";}else{$mejec_acum=number_format($mejec_acum,2,",", "."); }
		//if($mdebe==0){$mdebe="";}else{$mdebe=number_format($mdebe,2,",", "."); }
		//if($mhaber==0){$mhaber="";}else{$mhaber=number_format($mhaber,2,",", "."); }
		if($status_linea=="0"){ if($mejecutado==0){$mejecutado="";}else{$mejecutado=formato_monto($mejecutado);} } else{$mejecutado=formato_monto($mejecutado);}
		 $mejec_acum=formato_monto($mejec_acum);		$mdebe=formato_monto($mdebe); $mhaber=formato_monto($mhaber);
		
		
		
		$mcol1=""; $mcol2="";
		if($columna=="1"){$mcol1=$mejecutado;} if($columna=="2"){$mcol2=$mejecutado;}
		$nombre_cuenta=substr($nombre_cuenta,0,100);	
        $pdf->SetFont('Arial','',8); 		
		if(($status=="2")or($status=="8")or($status=="9")){$pdf->SetFont('Arial','B',8);}	
		if($status=="3"){$pdf->SetFont('Arial','U',8);}
        if($status=="4"){$pdf->SetFont('Arial','BU',8);}		
		$pdf->Cell(25,5,$cod_cuenta,0,0);
		$pdf->Cell(125,5,$nombre_cuenta,0,0);
		$pdf->Cell(25,5,$mcol1,0,0,'R');
		$pdf->Cell(25,5,$mcol2,0,1,'R');
		$x=$pdf->GetX();   $y=$pdf->GetY(); $z=$y+0.5;
		if(($status=="5")or($status=="8")){ if($mcol1<>""){ $pdf->Line(160,$y,185,$y); } if($mcol2<>""){ $pdf->Line(185,$y,210,$y); } }
		if(($status=="6")or($status=="9")){ if($mcol1<>""){ $pdf->Line(160,$y,185,$y); $pdf->Line(160,$z,185,$z); } if($mcol2<>""){ $pdf->Line(185,$y,210,$y); $pdf->Line(185,$z,210,$z); } }
	} 
	$pdf->Output();

pg_close();
?>