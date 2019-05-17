<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc");  error_reporting(E_ALL ^ E_NOTICE); 
$cod_bien_mued=$_GET["cod_bien_mued"];$cod_bien_mueh=$_GET["cod_bien_mueh"]; $referencia_transfd=$_GET["referencia_transfd"];$referencia_transfh=$_GET["referencia_transfh"];
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"]; $tipo_rep=$_GET["tipo_rep"]; $date = date("d-m-Y");$hora = date("H:i:s a"); $Sql="";
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';}   $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';}   $fecha_hasta=$ano1.$mes1.$dia1;
$criterio ="(bien036.referencia_transf>='$referencia_transfd' AND bien036.referencia_transf<='$referencia_transfh') AND
            (bien037.Cod_Bien_Mue>='$cod_bien_mued' AND bien037.Cod_Bien_Mue<='$cod_bien_mueh') AND  (bien036.fecha_transf>='$fecha_desde' AND bien036.fecha_transf<='$fecha_hasta')";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
    $sSQL = "SELECT bien036.referencia_transf, bien036.tipo_transferencia, to_char(bien036.fecha_transf,'DD/MM/YYYY') as fechat, bien037.Cod_Bien_Mue, bien015.Denominacion, bien015.Caracteristicas, bien015.Marca, bien015.Modelo, bien015.Color, bien015.Matricula, bien015.Serial1, bien015.Serial2, bien015.Tipo_Clase, bien015.Uso, bien015.Dimension_Tam, bien015.Antiguedad, bien015.Accesorios, bien015.Valor_Incorporacion, bien036.Cod_Dependencia_R, bien036.Cod_Empresa_R, bien036.Cod_Direccion_R, bien036.Cod_Departamento_R, bien036.Tipo_Movimiento_R, bien036.Cod_Dependencia_E, bien036.Cod_Empresa_E, bien036.Cod_Direccion_E, bien036.Cod_Departamento_E, bien036.Tipo_Movimiento_E, bien036.Departamento_E, bien036.Nombre_E,bien036.Departamento_R, bien036.Nombre_R, bien037.Monto, bien036.Descripcion  
             FROM bien001, bien015, bien036, bien037 WHERE bien015.Cod_Bien_Mue = bien037.Cod_Bien_Mue AND bien036.referencia_transf = bien037.referencia_transf AND bien001.Cod_Dependencia = bien015.Cod_Dependencia AND ".$criterio."";
    if($tipo_rep=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");
            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_lista_trans_bie_mue_repor_bie_mue.xml");
            $oRpt->setUser("$user");
            $oRpt->setPassword("$password");
            $oRpt->setConnection("$host");
            $oRpt->setDatabaseInterface("postgresql");
            $oRpt->setSQL($sSQL);
            $oRpt->setDatabase("$dbname");
            $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
            $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
            $oRpt->run();
            $aBench = $oRpt->getBenchmark();
            $iSec   = $aBench["report_end"]-$aBench["report_start"];
   }
   if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $cod_grupo="";
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $criterio2; 
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(30);
				$this->Cell(200,10,'REPORTE LISTADO DE TRANSFERENCIAS DE BIENES MUEBLES',1,0,'C');
				$this->Ln(20);
				
			    $this->SetFont('Arial','B',7);
				$this->Cell(18,5,'REFERENCIA',1,0);						
				$this->Cell(17,5,'FECHA',1,0,'L');
				$this->Cell(20,5,'TIPO',1,0,'L');
				$this->Cell(205,5,'DESCRIPCION',1,1,'L');
				
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
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $totalg=0; $subtotal=0;  $prev_referencia=""; $c=0; $total=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;		  
            $referencia=$registro["referencia_transf"]; $fechat=$registro["fechat"];  $departamento_e=$registro["departamento_e"]; $departamento_r=$registro["departamento_r"];
			$tipo_transferencia=$registro["tipo_transferencia"]; $descripcion=$registro["descripcion"];	$cod_bien_mue=$registro["cod_bien_mue"];  			
		    if($php_os=="WINNT"){$descripcion=$descripcion; }else{$descripcion=utf8_decode($descripcion); }			
			if($tipo_transferencia=="E"){$tipo_transferencia="EXTERNA";}else{$tipo_transferencia="INTERNA";}			
			if($prev_referencia<>$referencia){
			  if(($subtotal<>0)or($c>1)){ $subtotal=formato_monto($subtotal);
			    $pdf->Cell(210,2,'',0,0);
				$pdf->Cell(25,2,'---------------------',0,0,'R');
				$pdf->Cell(25,2,'',0,1);
				$pdf->Cell(170,3,'CANTIDAD DE BIENES : '.$c,0,0,'C');
				$pdf->Cell(40,3,'TOTAL :  ',0,0,'R');
				$pdf->Cell(25,3,$subtotal,0,0,'R');
				$pdf->Cell(25,3,'',0,1);
				$pdf->Ln(5);
			  }
			  $subtotal=0;  $prev_referencia=$referencia; $c=0;
			  $pdf->SetFont('Arial','',7);
			  $pdf->Cell(18,4,$referencia,0,0);
			  $pdf->Cell(17,4,$fechat,0,0);
			  $pdf->Cell(20,4,$tipo_transferencia,0,0);
			  $pdf->MultiCell(205,4,$descripcion,0);
               
			  $pdf->Cell(130,4,"UNIDAD EMISORA",0,0,'L');
			  $pdf->Cell(130,4,"UNIDAD RECEPTORA",0,1,'L');
			  $pdf->Cell(130,4,$departamento_e,0,0,'L');
			  $pdf->Cell(130,4,$departamento_r,0,1,'L');
			  $pdf->Ln(2);
              $pdf->Cell(20,3,"",0,0); 
			  $pdf->Cell(30,3,"CODIGO",'B',0); 
              $pdf->Cell(160,3,"DENOMINACION",'B',0);				  
              $pdf->Cell(25,3,"MONTO",'B',0,'R'); 			  
              $pdf->Cell(25,3,"",0,1);
 			  
			}
			$pdf->SetFont('Arial','',7);
			$cod_bien_mue=$registro["cod_bien_mue"]; $codigo=$registro["cod_bien_mue"]; $monto=$registro["monto"]; $denominacion=$registro["denominacion"];
	        $monto=formato_monto($monto);$total=$total+$registro["monto"]; $c=$c+1;
			
			$totalg=$totalg+$registro["monto"]; $subtotal=$subtotal+$registro["monto"];
			if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion);  }
			
			$pdf->Cell(20,3,'',0,0,'C');
			$pdf->Cell(30,3,$cod_bien_mue,0,0,'L'); 			   
		    $x=$pdf->GetX();   $y=$pdf->GetY(); $n=160;
		    $pdf->SetXY($x+$n,$y);
		    $pdf->Cell(25,3,$monto,0,1,'R');
		    $pdf->SetXY($x,$y);
		    $pdf->MultiCell($n,3,$denominacion,0); 
			
          }
		  if(($subtotal<>0)or($c>1)){ $subtotal=formato_monto($subtotal);
			    $pdf->Cell(210,2,'',0,0);
				$pdf->Cell(25,2,'---------------------',0,0,'R');
				$pdf->Cell(25,2,'',0,1);
				$pdf->Cell(170,3,'CANTIDAD DE BIENES : '.$c,0,0,'C');
				$pdf->Cell(40,3,'TOTAL :  ',0,0,'R');
				$pdf->Cell(25,3,$subtotal,0,0,'R');
				$pdf->Cell(25,3,'',0,1);
				$pdf->Ln(5);
		  }
		  $pdf->SetFont('Arial','B',7); $totalg=formato_monto($totalg);
		  $pdf->Cell(210,2,'',0,0);
		  $pdf->Cell(25,2,'=============',0,0,'R');
		  $pdf->Cell(25,2,'',0,1);
		  $pdf->Cell(170,3,'CANTIDAD DE BIENES : '.$i,0,0,'C');
		  $pdf->Cell(40,2,'TOTAL GENERAL : ',0,0,'R');
	      $pdf->Cell(25,2,$totalg,0,1,'R');
		  $pdf->Output();
	}	
}
?>
