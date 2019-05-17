<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_bien_mued=$_GET["cod_bien_mued"];$cod_bien_mueh=$_GET["cod_bien_mueh"];$cod_dependenciad=$_GET["cod_dependenciad"]; $cod_dependenciah=$_GET["cod_dependenciah"]; 
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"]; $tipo_rep=$_GET["tipo_rep"]; $date = date("d-m-Y");$hora = date("H:i:s a");$Sql="";
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';}   $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';}   $fecha_hasta=$ano1.$mes1.$dia1;
$criterio ="(bien015.cod_bien_mue>='$cod_bien_mued' AND bien015.cod_bien_mue<='$cod_bien_mueh') And (bien015.cod_dependencia>='$cod_dependenciad' And bien015.cod_dependencia<='$cod_dependenciah') And  (bien015.fecha_incorporacion>='$fecha_desde' AND bien015.fecha_incorporacion<='$fecha_hasta')";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }     

    $sSQL = "SELECT bien015.cod_bien_mue, bien015.cod_clasificacion, bien015.num_bien, bien015.denominacion, bien015.cod_dependencia,bien015.cod_direccion,bien015.valor_incorporacion,
bien015.cod_departamento,to_char(bien015.fecha_incorporacion,'DD/MM/YYYY') as fechai, bien001.denominacion_dep, bien008.denominacion_c, bien005.denominacion_dir, bien006.denominacion_dep as denominacion_depart  
FROM bien001, bien008, ((bien015  LEFT JOIN bien005 ON (bien005.cod_dependencia=bien015.cod_dependencia And bien005.cod_direccion=bien015.cod_direccion)) LEFT JOIN bien006 ON (bien006.cod_departamento=bien015.cod_departamento And 
bien006.cod_dependencia=bien015.cod_dependencia And bien006.cod_direccion=bien015.cod_direccion)) WHERE bien001.cod_dependencia = bien015.cod_dependencia And bien008.codigo_c=bien015.cod_clasificacion AND ".$criterio."";

    if($tipo_rep=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");
	         $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_eti_bie_mue_repor_bie_mue.xml");
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
   if($tipo_rep=="PDFA"){  $res=pg_query($sSQL);
         require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $Nom_Emp;
                $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  			
				//$this->Image('../../imagenes/Logo_emp.png',7,7,20);				
				$this->SetFont('Arial','B',8);
				//$this->Cell(150,5,$Nom_Emp,0,1);				
		    } 
			function Footer(){ 
			    $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-5);
			}
		  }		  
		  $pdf=new PDF('P', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $totalg=0;   $c=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;
            $cod_clasificacion=$registro["cod_clasificacion"]; $denominacion_c=$registro["denominacion_c"];	$cod_bien_mue=$registro["cod_bien_mue"];  $num_bien=$registro["num_bien"];
		    $fechai=$registro["fechai"];$cod_bien_mue=$registro["cod_bien_mue"]; $denominacion=$registro["denominacion"];  $denominacion_depart=$registro["denominacion_depart"]; $cod_departamento=$registro["cod_departamento"]; 
			$valor_incorporacion=$registro["valor_incorporacion"]; $cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"];
			if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep); $denominacion_depart=utf8_decode($denominacion_depart);  }
			$cod_grupo=$cod_dependencia; 			
			//$temp_denominacion="DENOMINACION: ".$denominacion;
			//$temp_codigo=substr($cod_bien_mue,7,6);
			$pdf->SetFont('Arial','',6); 
			$pdf->Cell(50,5,'NUMERO: '.$temp_codigo,0,1,'L');
			$pdf->MultiCell(50,4,$temp_denominacion,0); 
           		$x=$pdf->GetX();   $y=$pdf->GetY();			
			$pdf->Cell(50,5,$fechai,0,1,'R');
			$pdf->Ln(2);
          }		 
		  $pdf->Output();   
   }  


    if($tipo_rep=="PDF"){  $res=pg_query($sSQL);
         require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $Nom_Emp;
                $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  			
				//$this->Image('../../imagenes/Logo_emp.png',7,7,20);				
				$this->SetFont('Arial','B',8);
				//$this->Cell(150,5,$Nom_Emp,0,1);				
		    } 
			function Footer(){ 
			    $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-5);
			}
		  }		  
		  $pdf=new PDF('P', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $totalg=0;   $c=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;
            $cod_clasificacion=$registro["cod_clasificacion"]; $denominacion_c=$registro["denominacion_c"];	$cod_bien_mue=$registro["cod_bien_mue"];  $num_bien=$registro["num_bien"];
		    $fechai=$registro["fechai"];$cod_bien_mue=$registro["cod_bien_mue"]; $denominacion=$registro["denominacion"];  $denominacion_depart=$registro["denominacion_depart"]; $cod_departamento=$registro["cod_departamento"]; 
			$valor_incorporacion=$registro["valor_incorporacion"]; $cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"];
			if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep); $denominacion_depart=utf8_decode($denominacion_depart);  }
			$cod_grupo=$cod_dependencia;

 			$temp_codigo=$cod_bien_mue;
			//$temp_denominacion="DENOMINACION: ".$denominacion;
			//$temp_den_dep=$denominacion_dep;
                        $temp_den_dep=$cod_departamento;
			
			$long_line=28; $part1=$temp_den_dep; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($temp_den_dep,0,$long_line); }   $lp=strlen($part1);  $c2=$lp; $care="N"; 
            if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($temp_den_dep,0,$c2); }       
            $part2=substr($temp_den_dep,$c2,$long_line);
			$pdf->SetFont('Arial','',7); 
			$x=$pdf->GetX();   $y=$pdf->GetY();
			$pdf->Image('../../imagenes/Logo_emp.png',$x+1,$y+1,15);
			$pdf->Cell(17,4,'',"LT",0,'L');
			$pdf->Cell(43,4,$part1,"TR",1,'L');
			$pdf->Cell(17,3,'',"L",0,'L');
			$pdf->Cell(43,3,$part2,"R",1,'L');
			$pdf->Cell(60,3,'',"LR",1,'L');
			$pdf->Cell(20,5,'',"L",0,'L');
			$pdf->Cell(40,5,'CODIGO: '.$temp_codigo,"R",1,'L');
                        $pdf->Cell(40,5,'DEPARTAMENTO: '.$temp_den_dep,"R",1,'L');
			//$pdf->MultiCell(60,4,$temp_denominacion,"LRB"); 
			//$pdf->MultiCell(60,4,$temp_den_dep,"LRB"); 
            	
			$pdf->Ln(4);
			$x=$pdf->GetX();   $y=$pdf->GetY();
			if($y>=237){ $pdf->AddPage();}
          }		 
		  $pdf->Output();   
   }     
   
}
?>
