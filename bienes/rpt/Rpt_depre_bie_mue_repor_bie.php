<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc");  error_reporting(E_ALL ^ E_NOTICE); 
$cod_bien_mued=$_GET["cod_bien_mued"];$cod_bien_mueh=$_GET["cod_bien_mueh"]; $referencia_depd=$_GET["referencia_depd"];$referencia_deph=$_GET["referencia_deph"];
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"]; $tipo_rep=$_GET["tipo_rep"]; $date = date("d-m-Y");$hora = date("H:i:s a"); $Sql="";
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';}   $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';}   $fecha_hasta=$ano1.$mes1.$dia1;
$criterio ="(bien028.referencia_dep>='$referencia_depd' AND bien028.referencia_dep<='$referencia_deph') AND  (bien028.fecha_dep>='$fecha_desde' AND bien028.fecha_dep<='$fecha_hasta') AND 
            (bien047.cod_bien_mue>='$cod_bien_mued' AND bien047.cod_bien_mue<='$cod_bien_mueh') ";			
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} } 
    $sSQL = "SELECT bien015.cod_bien_mue, bien015.denominacion, bien028.referencia_dep, bien028.fecha_dep, bien028.descripcion, bien028.met_calculo, bien028.status, 
	bien028.anulado, bien015.valor_incorporacion, bien047.monto_dep, bien015.valor_residual, bien047.saldo_dep, bien015.cod_dependencia, bien001.denominacion_dep, to_char(bien028.fecha_dep,'DD/MM/YYYY') as fechad 
	FROM bien001, bien015, bien028, bien047 WHERE bien015.cod_bien_mue = bien047.cod_bien_mue AND bien015.Cod_Dependencia = bien001.Cod_Dependencia AND bien028.referencia_dep=bien047.referencia_dep AND ".$criterio."
	ORDER BY  bien028.referencia_dep, bien028.fecha_dep, bien047.cod_bien_mue";
    if($tipo_rep=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");
            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_depre_bie_mue_repor_bie_mue.xml");
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
    if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $cod_grupo="";  $d=1;
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $criterio2; global $d;
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(30);
				$this->Cell(200,10,'REPORTE LISTADO DE DEPRECIACION BIENES MUEBLES',1,0,'C');
				$this->Ln(20);
			    $this->SetFont('Arial','B',7);
				$this->Cell(18,5,'REFERENCIA',1,0);						
				$this->Cell(17,5,'FECHA',1,0,'L');
				$this->Cell(20,5,'TIPO',1,0,'L');
				$this->Cell(205,5,'DESCRIPCION',1,1,'L');				
				if($d==0){ $this->Ln(2);				  
				  $this->Cell(20,3," ",0,0); 
				  $this->Cell(30,3,"CODIGO",'B',0); 
				  $this->Cell(150,3,"DENOMINACION",'B',0);	
				  $this->Cell(20,3,"VALOR INC.",'B',0,'R'); 			  
				  $this->Cell(20,3,"SALDO DEP.",'B',0,'R'); 			  
				  $this->Cell(20,3,"DEPRECIACION",'B',1,'L');
				}				
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
		  //$pdf->MultiCell(260,4,$sSQL,0);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;		  
            $referencia=$registro["referencia_dep"]; $fechat=$registro["fechad"];  $met_calculo=$registro["met_calculo"]; $descripcion=$registro["descripcion"];	$cod_bien_mue=$registro["cod_bien_mue"];  			
		    if($php_os=="WINNT"){$descripcion=$descripcion; }else{$descripcion=utf8_decode($descripcion); }			
			if($met_calculo=="M"){$met_calculo="MENSUAL";}else{$met_calculo="ANUAL";}			
			if($prev_referencia<>$referencia){
			  if(($subtotal<>0)or($c>=1)){ $subtotal=formato_monto($subtotal);
			    $pdf->Cell(240,2,'',0,0);
				$pdf->Cell(20,2,'---------------------',0,1,'R');
				$pdf->Cell(200,3,'CANTIDAD DE BIENES DEPRECIADOS EN EL MES : '.$c,0,0,'C');
				$pdf->Cell(40,3,'TOTAL :  ',0,0,'R');
				$pdf->Cell(20,3,$subtotal,0,1,'R');
				$pdf->Ln(5);
			  }
			  $subtotal=0;  $prev_referencia=$referencia; $c=0; $d=1;
			  $pdf->SetFont('Arial','',7);
			  $pdf->Cell(18,4,$referencia,0,0);
			  $pdf->Cell(17,4,$fechat,0,0);
			  $pdf->Cell(20,4,$met_calculo,0,0);
			  $pdf->MultiCell(205,4,$descripcion,0);
			  $pdf->Ln(2);
              $pdf->Cell(20,3," ",0,0); 
			  $pdf->Cell(30,3,"CODIGO",'B',0); 
              $pdf->Cell(150,3,"DENOMINACION",'B',0);	
              $pdf->Cell(20,3,"VALOR INC.",'B',0,'R'); 			  
              $pdf->Cell(20,3,"SALDO DEP.",'B',0,'R'); 			  
              $pdf->Cell(20,3,"DEPRECIACION",'B',1,'R');
			}
			$pdf->SetFont('Arial','',7); $d=0;
			$cod_bien_mue=$registro["cod_bien_mue"]; $codigo=$registro["cod_bien_mue"]; $monto=$registro["monto_dep"]; $denominacion=$registro["denominacion"];
	        $valor_incorporacion=$registro["valor_incorporacion"]; $saldo_dep=$registro["saldo_dep"]; $total=$total+$registro["monto_dep"]; $c=$c+1;			
			$monto_dep=formato_monto($monto);  $saldo_dep=formato_monto($saldo_dep); $valor_incorporacion=formato_monto($valor_incorporacion);  
			$totalg=$totalg+$registro["monto_dep"]; $subtotal=$subtotal+$registro["monto_dep"];
			if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion);  }			
			$pdf->Cell(20,3,'',0,0,'C');
			$pdf->Cell(30,3,$cod_bien_mue,0,0,'L'); 			   
		    $x=$pdf->GetX();   $y=$pdf->GetY(); $n=150;
		    $pdf->SetXY($x+$n,$y);
			$pdf->Cell(20,3,$valor_incorporacion,0,0,'R');
			$pdf->Cell(20,3,$saldo_dep,0,0,'R');
		    $pdf->Cell(20,3,$monto_dep,0,1,'R');
		    $pdf->SetXY($x,$y);
		    $pdf->MultiCell($n,3,$denominacion,0); 			
          }
		  if(($subtotal<>0)or($c>1)){ $subtotal=formato_monto($subtotal);
			    $pdf->Cell(240,2,'',0,0);
				$pdf->Cell(20,2,'---------------------',0,1,'R');
				$pdf->Cell(200,3,'CANTIDAD DE BIENES DEPRECIADOS EN EL MES : '.$c,0,0,'C');
				$pdf->Cell(40,3,'TOTAL DEPRECIACION DEL MES :  ',0,0,'R');
				$pdf->Cell(20,3,$subtotal,0,1,'R');
				$pdf->Ln(5);
		  }
		  $pdf->SetFont('Arial','B',7); $totalg=formato_monto($totalg);
		  $pdf->Cell(240,2,'',0,0);
		  $pdf->Cell(20,2,'=============',0,1,'R');
		  $pdf->Cell(200,3,' ',0,0,'C');
		  $pdf->Cell(40,2,'TOTAL GENERAL : ',0,0,'R');
	      $pdf->Cell(20,2,$totalg,0,1,'R');
		  $pdf->Output();
	}			
}
?>
