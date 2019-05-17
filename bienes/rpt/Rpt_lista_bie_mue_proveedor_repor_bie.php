<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_bien_mued=$_GET["cod_bien_mued"];$cod_bien_mueh=$_GET["cod_bien_mueh"];$cedulad=$_GET["cedulad"];$cedulah=$_GET["cedulah"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"]; $denominacion=$_GET["denominacion"]; $tipo_rep=$_GET["tipo_rep"];
$date = date("d-m-Y");$hora = date("H:i:s a");$Sql=""; $php_os=PHP_OS; 
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';}   $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';}   $fecha_hasta=$ano1.$mes1.$dia1;
$criterio ="(bien015.cod_bien_mue>='$cod_bien_mued' AND bien015.cod_bien_mue<='$cod_bien_mueh') AND(bien015.ced_rif_proveedor>='$cedulad' AND bien015.ced_rif_proveedor<='$cedulah') AND
(bien015.fecha_incorporacion>='$fecha_desde' AND bien015.fecha_incorporacion<='$fecha_hasta')";
if($denominacion<>""){  $criterio=$criterio." and (bien015.denominacion Like '%".$denominacion."%')"; }        
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{  $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
    
	$sSQL = "SELECT bien015.cod_bien_mue, bien015.Cod_Clasificacion, bien015.Num_Bien, bien015.Denominacion, bien015.cod_dependencia, bien015.Cod_Direccion, bien015.Cod_Departamento, bien001.Denominacion_Dep, bien015.Caracteristicas, bien015.Marca, bien015.Modelo, bien015.Color, bien015.Matricula, bien015.Serial1, bien015.Serial2, bien015.Tipo_Clase, bien015.Uso, bien015.Dimension_Tam, bien015.Antiguedad, bien015.Accesorios, bien015.Valor_Incorporacion, to_char(bien015.fecha_incorporacion,'DD/MM/YYYY') as fechai, bien015.Tipo_Incorporacion, bien008.Denominacion_C, bien005.Denominacion_Dir, bien015.ced_rif_proveedor,bien015.nom_proveedor, bien006.denominacion_dep as denom_departamento FROM bien001 bien001, bien008 bien008, ((bien015 bien015  LEFT JOIN bien005 ON (bien005.cod_dependencia=bien015.cod_dependencia And bien005.Cod_Direccion=bien015.Cod_Direccion)) LEFT JOIN bien006 ON (bien006.Cod_Departamento=bien015.Cod_Departamento And bien006.cod_dependencia=bien015.cod_dependencia And bien006.Cod_Direccion=bien015.Cod_Direccion)) WHERE bien001.cod_dependencia=bien015.cod_dependencia AND bien008.Codigo_C=bien015.Cod_Clasificacion AND ".$criterio."  ORDER BY bien015.ced_rif_proveedor,bien015.cod_bien_mue";
    //echo $sSQL;
		
	if($tipo_rep=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");	
            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_lista_bie_mue_proveedor_repor_bie_mue.xml");
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
				$this->Cell(50);
				$this->Cell(150,10,'LISTADO DE BIENES MUEBLES POR PROVEEDOR',1,0,'C');
				$this->Ln(20);
				
			    $this->SetFont('Arial','B',6);
				$this->Cell(25,5,'CODIGO DEL BIEN',1,0);						
				$this->Cell(120,5,'DENOMINACION',1,0,'L');
				$this->Cell(15,5,'FECHA INC.',1,0,'L');
				$this->Cell(20,5,'VALOR INCORP.',1,0,'L');
				$this->Cell(80,5,'CODIGO - DENOMINACION DEPARTAMENTO',1,1,'L');
				
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
		  $i=0;  $totalg=0; $subtotal=0;  $prev_cod_clasificacion=""; $c=0; $prev_ced_rif="";
		  while($registro=pg_fetch_array($res)){ $i=$i+1;
            $cod_clasificacion=$registro["cod_clasificacion"]; $denominacion_c=$registro["denominacion_c"];	$cod_bien_mue=$registro["cod_bien_mue"];  
			$ced_rif_proveedor=$registro["ced_rif_proveedor"]; $nom_proveedor=$registro["nom_proveedor"];
		    if($php_os=="WINNT"){$denominacion_c=$denominacion_c; }else{$denominacion_c=utf8_decode($denominacion_c); $nom_proveedor=utf8_decode($nom_proveedor); }
			if($prev_ced_rif<>$ced_rif_proveedor){
			  $pdf->SetFont('Arial','B',7);
			  $pdf->Cell(200,4,$ced_rif_proveedor.'  '.$nom_proveedor,0,1);
			  $prev_ced_rif=$ced_rif_proveedor;
			}
			$pdf->SetFont('Arial','',7);
			$cod_bien_mue=$registro["cod_bien_mue"]; $denominacion=$registro["denominacion"]; $fechai=$registro["fechai"]; $denom_departamento=$registro["denom_departamento"]; $cod_departamento=$registro["cod_departamento"]; 
			$valor_incorporacion=$registro["valor_incorporacion"]; $cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"];
			
			if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep); $denom_departamento=utf8_decode($denom_departamento); }
			$monto=formato_monto($valor_incorporacion); $totalg=$totalg+$valor_incorporacion; $subtotal=$subtotal+$valor_incorporacion; $c=$c+1;
			$pdf->Cell(25,3,$cod_bien_mue,0,0,'L'); 			   
		    $x=$pdf->GetX();   $y=$pdf->GetY(); $n=120;
		    $pdf->SetXY($x+$n,$y);
		    $pdf->Cell(15,3,$fechai,0,0,'C');
		    $pdf->Cell(20,3,$monto,0,0,'R');
		    $pdf->Cell(80,3,$cod_departamento." ".$denom_departamento,0,1,'L');  
		    $pdf->SetXY($x,$y);
		    $pdf->MultiCell($n,3,$denominacion,0);  
          }
		  
		  $pdf->SetFont('Arial','B',7); $totalg=formato_monto($totalg);
		  $pdf->Cell(160,2,'',0,0);
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(80,2,'',0,1);
		  $pdf->Cell(120,3,'CANTIDAD DE BIENES : '.$i,0,0,'C');
		  $pdf->Cell(40,2,'TOTAL GENERAL : ',0,0,'R');
	      $pdf->Cell(20,2,$totalg,0,1,'R');
		  $pdf->Output();
	}	
}
?>
