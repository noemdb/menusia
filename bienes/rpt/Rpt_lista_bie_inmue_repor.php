<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_bien_inmd=$_GET["cod_bien_inmd"];$cod_bien_inmh=$_GET["cod_bien_inmh"];$cod_empresad=$_GET["cod_empresad"];$cod_empresah=$_GET["cod_empresah"];
$cod_dependenciad=$_GET["cod_dependenciad"]; $cod_dependenciah=$_GET["cod_dependenciah"]; $cod_direcciond=$_GET["cod_direcciond"]; $cod_direccionh=$_GET["cod_direccionh"];
$cod_departamentod=$_GET["cod_departamentod"]; $cod_departamentoh=$_GET["cod_departamentoh"]; $tipo_regis=$_GET["tipo_regis"]; $denominacion=$_GET["denominacion"]; $tipo_rep=$_GET["tipo_rep"];
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"]; $ordenado=$_GET["ordenado"]; $date = date("d-m-Y");$hora = date("H:i:s a");$Sql=""; $php_os=PHP_OS; 
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';}   $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';}   $fecha_hasta=$ano1.$mes1.$dia1;
$cod_mov="bien014001".$usuario_sia;   
$criterio=" (bien014.cod_bien_inm>='$cod_bien_inmd' and bien014.cod_bien_inm<='$cod_bien_inmh') and (bien014.cod_empresa>='$cod_empresad' and bien014.cod_empresa<='$cod_empresah') AND 
  (bien014.cod_dependencia>='$cod_dependenciad' and bien014.cod_dependencia<='$cod_dependenciah') and (bien014.cod_direccion>='$cod_direcciond' and bien014.cod_direccion<='$cod_direccionh') AND
  (bien014.cod_departamento>='$cod_departamentod' and bien014.cod_departamento<='$cod_departamentoh') and (bien014.fecha_incorporacion>='$fecha_desde' and bien014.fecha_incorporacion<='$fecha_hasta')";
if($denominacion<>""){ $criterio=$criterio." and (bien014.denominacion Like '%".$denominacion."%')"; } 
if ($tipo_regis=="D"){ $criterio=$criterio." and (bien014.desincorporado='S')"; }
if ($tipo_regis=="A"){ $criterio=$criterio." and (bien014.desincorporado='N')"; }
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else {  $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }  
    
	$mordenado=" bien014.cod_clasificacion,bien014.cod_bien_inm";  $num_reporte=1;
	
	if($ordenado=="N"){$mordenado=" order by bien014.num_bien,bien014.fecha_incorporacion,bien014.valor_incorporacion"; $num_reporte=2; $nombre_rpt="Rpt_lista_bie_inmue_repor_bie_mue_num.xml"; }
	
	
	$sSQL = "SELECT bien014.cod_bien_inm, bien014.cod_clasificacion, bien014.num_bien, bien014.denominacion, bien014.cod_dependencia,bien014.cod_direccion,bien014.cod_departamento,bien001.denominacion_dep, bien001.direccion_dep, bien014.valor_incorporacion, bien014.fecha_incorporacion, substr(bien014.cod_clasificacion,1,1) as grupo, substr(bien014.cod_clasificacion,3,2) as subgrupo, substr(bien014.cod_clasificacion,6,1) as seccion, bien005.denominacion_dir, bien006.denominacion_dep as denom_departamento, bien004.edo_bien, bien008.denominacion_C , to_char(bien014.fecha_incorporacion,'DD/MM/YYYY') as fechai 
	        FROM bien001,bien004, bien008,((bien014 LEFT JOIN bien005 ON (bien005.cod_dependencia=bien014.cod_dependencia and bien005.cod_direccion=bien014.cod_direccion)) LEFT JOIN bien006 ON (bien006.cod_departamento=bien014.cod_departamento and bien006.cod_dependencia=bien014.cod_dependencia and bien006.cod_direccion=bien014.cod_direccion)) WHERE (bien001.cod_dependencia = bien014.cod_dependencia) and (bien004.codigo=bien014.edo_conservacion) and (bien008.Codigo_C=bien014.cod_clasificacion) and ".$criterio."  order by  ".$mordenado;

	
	if($tipo_rep=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");	//echo $sSQL;		
            $oRpt = new PHPReportMaker();
            $oRpt->setXML($nombre_rpt);
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
	if(($tipo_rep=="PDF")and($num_reporte==1)){  $res=pg_query($sSQL); $cod_grupo="";
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $criterio2; global $tipo_regis;
			    $titulo='LISTADO DE BIENES INMUEBLES';
				if ($tipo_regis=="D"){ $titulo='LISTADO DE BIENES INMUEBLES DESINCORPORADOS'; }
                if ($tipo_regis=="A"){ $titulo='LISTADO DE BIENES INMUEBLES ACTIVOS'; }
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(150,10,$titulo,1,0,'C');
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
		  $i=0;  $totalg=0; $subtotal=0;  $prev_cod_clasificacion=""; $c=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;
            $cod_clasificacion=$registro["cod_clasificacion"]; $denominacion_c=$registro["denominacion_c"];	$cod_bien_inm=$registro["cod_bien_inm"];  
		    if($php_os=="WINNT"){$denominacion_c=$denominacion_c; }else{$denominacion_c=utf8_decode($denominacion_c); }
			if($prev_cod_clasificacion<>$cod_clasificacion){
			  if(($subtotal<>0)or($c>1)){ $subtotal=formato_monto($subtotal);
			    $pdf->Cell(160,2,'',0,0);
				$pdf->Cell(20,2,'---------------------',0,0,'R');
				$pdf->Cell(80,2,'',0,1);
				$pdf->Cell(120,3,'CANTIDAD DE BIENES : '.$c,0,0,'C');
				$pdf->Cell(40,3,'TOTAL : '.$prev_cod_clasificacion.'  ',0,0,'R');
				$pdf->Cell(20,3,$subtotal,0,1,'R');
				$pdf->Ln(5);
			  }
			  $subtotal=0;  $prev_cod_clasificacion=$cod_clasificacion; $c=0;
			  $pdf->SetFont('Arial','B',7);
			  $pdf->Cell(200,4,$cod_clasificacion.'  '.$denominacion_c,0,1);
			}
			$pdf->SetFont('Arial','',7);
			$cod_bien_inm=$registro["cod_bien_inm"]; $denominacion=$registro["denominacion"]; $fechai=$registro["fechai"]; $denom_departamento=$registro["denom_departamento"]; $cod_departamento=$registro["cod_departamento"]; 
			$valor_incorporacion=$registro["valor_incorporacion"]; $cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"];
			if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep); $denom_departamento=utf8_decode($denom_departamento); }
			$monto=formato_monto($valor_incorporacion); $totalg=$totalg+$valor_incorporacion; $subtotal=$subtotal+$valor_incorporacion; $c=$c+1;
			$pdf->Cell(25,3,$cod_bien_inm,0,0,'L'); 			   
		    $x=$pdf->GetX();   $y=$pdf->GetY(); $n=120;
		    $pdf->SetXY($x+$n,$y);
		    $pdf->Cell(15,3,$fechai,0,0,'C');
		    $pdf->Cell(20,3,$monto,0,0,'R');
		    $pdf->Cell(80,3,$cod_departamento." ".$denom_departamento,0,1,'L');  
		    $pdf->SetXY($x,$y);
		    $pdf->MultiCell($n,3,$denominacion,0);  
          }
		  if(($subtotal<>0)or($c>1)){ $subtotal=formato_monto($subtotal);
			    $pdf->Cell(160,2,'',0,0);
				$pdf->Cell(20,2,'---------------------',0,0,'R');
				$pdf->Cell(80,2,'',0,1);
				$pdf->Cell(120,3,'CANTIDAD DE BIENES : '.$c,0,0,'C');
				$pdf->Cell(40,3,'TOTAL : '.$prev_cod_clasificacion.'  ',0,0,'R');
				$pdf->Cell(20,3,$subtotal,0,1,'R');
				$pdf->Ln(5);
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
	if(($tipo_rep=="PDF")and($num_reporte==2)){  $res=pg_query($sSQL); $cod_grupo="";
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $criterio2; 
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(150,10,'LISTADO DE BIENES INMUEBLES',1,0,'C');
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
		  $i=0;  $totalg=0; $subtotal=0;  $prev_cod_clasificacion=""; $c=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;
            $cod_clasificacion=$registro["cod_clasificacion"]; $denominacion_c=$registro["denominacion_c"];	$cod_bien_inm=$registro["cod_bien_inm"];  
		    if($php_os=="WINNT"){$denominacion_c=$denominacion_c; }else{$denominacion_c=utf8_decode($denominacion_c); }
			
			$pdf->SetFont('Arial','',7);
			$cod_bien_inm=$registro["cod_bien_inm"]; $denominacion=$registro["denominacion"]; $fechai=$registro["fechai"]; $denom_departamento=$registro["denom_departamento"]; $cod_departamento=$registro["cod_departamento"]; 
			$valor_incorporacion=$registro["valor_incorporacion"]; $cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"];
			if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep); $denom_departamento=utf8_decode($denom_departamento); }
			$monto=formato_monto($valor_incorporacion); $totalg=$totalg+$valor_incorporacion; $subtotal=$subtotal+$valor_incorporacion; $c=$c+1;
			$pdf->Cell(25,3,$cod_bien_inm,0,0,'L'); 			   
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
	
	if(($tipo_rep=="PDF2")and($num_reporte==1)){  $res=pg_query($sSQL); $cod_grupo="";
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $criterio2; 
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(200,10,'LISTADO DE BIENES INMUEBLES',1,0,'C');
				$this->Ln(20);
				
			    $this->SetFont('Arial','B',6);
				$this->Cell(25,5,'CODIGO DEL BIEN',1,0);						
				$this->Cell(120,5,'DENOMINACION',1,0,'L');
				$this->Cell(25,5,'MARCA',1,0);	
				$this->Cell(25,5,'MODELO',1,0);	
				$this->Cell(30,5,'SERIAL',1,0);	
				$this->Cell(15,5,'FECHA INC.',1,0,'L');
				$this->Cell(20,5,'VALOR INCORP.',1,0,'L');
				$this->Cell(80,5,'CODIGO - DENOMINACION DEPARTAMENTO',1,1,'L');
				
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
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $totalg=0; $subtotal=0;  $prev_cod_clasificacion=""; $c=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;
            $cod_clasificacion=$registro["cod_clasificacion"]; $denominacion_c=$registro["denominacion_c"];	$cod_bien_inm=$registro["cod_bien_inm"];  
		    if($php_os=="WINNT"){$denominacion_c=$denominacion_c; }else{$denominacion_c=utf8_decode($denominacion_c); }
			if($prev_cod_clasificacion<>$cod_clasificacion){
			  if(($subtotal<>0)or($c>1)){ $subtotal=formato_monto($subtotal);
			    $pdf->Cell(240,2,'',0,0);
				$pdf->Cell(20,2,'---------------------',0,0,'R');
				$pdf->Cell(80,2,'',0,1);
				$pdf->Cell(200,3,'CANTIDAD DE BIENES : '.$c,0,0,'C');
				$pdf->Cell(40,3,'TOTAL : '.$prev_cod_clasificacion.'  ',0,0,'R');
				$pdf->Cell(20,3,$subtotal,0,1,'R');
				$pdf->Ln(5);
			  }
			  $subtotal=0;  $prev_cod_clasificacion=$cod_clasificacion; $c=0;
			  $pdf->SetFont('Arial','B',7);
			  $pdf->Cell(200,4,$cod_clasificacion.'  '.$denominacion_c,0,1);
			}
			$pdf->SetFont('Arial','',7);
			$cod_bien_inm=$registro["cod_bien_inm"]; $denominacion=$registro["denominacion"]; $fechai=$registro["fechai"]; $denom_departamento=$registro["denom_departamento"]; $cod_departamento=$registro["cod_departamento"]; 
			$valor_incorporacion=$registro["valor_incorporacion"]; $cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"];
			$marca=$registro["marca"]; $modelo=$registro["modelo"]; $serial1=$registro["serial1"]; $marca=substr($marca,0,15); $modelo=substr($modelo,0,15); $serial1=substr($serial1,0,20);
			if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep); $denom_departamento=utf8_decode($denom_departamento); $marca=utf8_decode($marca); $modelo=utf8_decode($modelo); $serial1=utf8_decode($serial1); }
			$monto=formato_monto($valor_incorporacion); $totalg=$totalg+$valor_incorporacion; $subtotal=$subtotal+$valor_incorporacion; $c=$c+1;
			$pdf->Cell(25,3,$cod_bien_inm,0,0,'L'); 			   
		    $x=$pdf->GetX();   $y=$pdf->GetY(); $n=120;
		    $pdf->SetXY($x+$n,$y);
			$pdf->Cell(25,3,$marca,0,0,'L');
			$pdf->Cell(25,3,$modelo,0,0,'L');
			$pdf->Cell(30,3,$serial1,0,0,'L');
		    $pdf->Cell(15,3,$fechai,0,0,'C');
		    $pdf->Cell(20,3,$monto,0,0,'R');
		    $pdf->Cell(80,3,$cod_departamento." ".$denom_departamento,0,1,'L');  
		    $pdf->SetXY($x,$y);
		    $pdf->MultiCell($n,3,$denominacion,0);  
          }
		  if(($subtotal<>0)or($c>1)){ $subtotal=formato_monto($subtotal);
			    $pdf->Cell(240,2,'',0,0);
				$pdf->Cell(20,2,'---------------------',0,0,'R');
				$pdf->Cell(80,2,'',0,1);
				$pdf->Cell(200,3,'CANTIDAD DE BIENES : '.$c,0,0,'C');
				$pdf->Cell(40,3,'TOTAL : '.$prev_cod_clasificacion.'  ',0,0,'R');
				$pdf->Cell(20,3,$subtotal,0,1,'R');
				$pdf->Ln(5);
		  }
		  $pdf->SetFont('Arial','B',7); $totalg=formato_monto($totalg);
		  $pdf->Cell(240,2,'',0,0);
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(80,2,'',0,1);
		  $pdf->Cell(200,3,'CANTIDAD DE BIENES : '.$i,0,0,'C');
		  $pdf->Cell(40,2,'TOTAL GENERAL : ',0,0,'R');
	      $pdf->Cell(20,2,$totalg,0,1,'R');
		  $pdf->Output();
	}
	
	if(($tipo_rep=="PDF2")and($num_reporte==2)){  $res=pg_query($sSQL); $cod_grupo="";
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $criterio2; 
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(150,10,'LISTADO DE BIENES INMUEBLES',1,0,'C');
				$this->Ln(20);				
			    $this->SetFont('Arial','B',6);
				$this->Cell(25,5,'CODIGO DEL BIEN',1,0);						
				$this->Cell(120,5,'DENOMINACION',1,0,'L');
				$this->Cell(25,5,'MARCA',1,0);	
				$this->Cell(25,5,'MODELO',1,0);	
				$this->Cell(30,5,'SERIAL',1,0);	
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
		  $pdf=new PDF('L', 'mm', Legal);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $totalg=0; $subtotal=0;  $prev_cod_clasificacion=""; $c=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;
            $cod_clasificacion=$registro["cod_clasificacion"]; $denominacion_c=$registro["denominacion_c"];	$cod_bien_inm=$registro["cod_bien_inm"];  
		    if($php_os=="WINNT"){$denominacion_c=$denominacion_c; }else{$denominacion_c=utf8_decode($denominacion_c); }			
			$pdf->SetFont('Arial','',7);
			$cod_bien_inm=$registro["cod_bien_inm"]; $denominacion=$registro["denominacion"]; $fechai=$registro["fechai"]; $denom_departamento=$registro["denom_departamento"]; $cod_departamento=$registro["cod_departamento"]; 
			$valor_incorporacion=$registro["valor_incorporacion"]; $cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"];
			$marca=$registro["marca"]; $modelo=$registro["modelo"]; $serial1=$registro["serial1"]; $marca=substr($marca,0,15); $modelo=substr($modelo,0,15); $serial1=substr($serial1,0,20);
			if($php_os=="WINNT"){$denominacion=$denominacion; } else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep); $denom_departamento=utf8_decode($denom_departamento);  $marca=utf8_decode($marca); $modelo=utf8_decode($modelo); $serial1=utf8_decode($serial1);	}
			$monto=formato_monto($valor_incorporacion); $totalg=$totalg+$valor_incorporacion; $subtotal=$subtotal+$valor_incorporacion; $c=$c+1;
			$pdf->Cell(25,3,$cod_bien_inm,0,0,'L'); 			   
		    $x=$pdf->GetX();   $y=$pdf->GetY(); $n=120;
		    $pdf->SetXY($x+$n,$y);
			$pdf->Cell(25,3,$marca,0,0,'L');
			$pdf->Cell(25,3,$modelo,0,0,'L');
			$pdf->Cell(30,3,$serial1,0,0,'L');
		    $pdf->Cell(15,3,$fechai,0,0,'C');
		    $pdf->Cell(20,3,$monto,0,0,'R');
		    $pdf->Cell(80,3,$cod_departamento." ".$denom_departamento,0,1,'L');  
		    $pdf->SetXY($x,$y);
		    $pdf->MultiCell($n,3,$denominacion,0);  
          }		  
		  $pdf->SetFont('Arial','B',7); $totalg=formato_monto($totalg);
		  $pdf->Cell(240,2,'',0,0);
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(80,2,'',0,1);
		  $pdf->Cell(200,3,'CANTIDAD DE BIENES : '.$i,0,0,'C');
		  $pdf->Cell(40,2,'TOTAL GENERAL : ',0,0,'R');
	      $pdf->Cell(20,2,$totalg,0,1,'R');
		  $pdf->Output();
	}
	
	
	if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_Listado_bienes_muebles.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO DE BIENES INMUEBLES</strong></font></td>
			 </tr>
			 
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CODIGO</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>DENOMINACION DEL BIEN</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>MARCA</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF" ><strong>MODELO</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF" ><strong>SERIAL</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF" ><strong>FECHA INC.</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>VALOR INCORP.</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF" ><strong>CODIGO - DENOMINACION DEPARTAMENTO</strong></td>
			 </tr>
		  <?  $i=0;  $totalg=0; $subtotal=0;  $prev_cod_clasificacion=""; $c=0;   $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  
		    $cod_clasificacion=$registro["cod_clasificacion"]; $denominacion_c=$registro["denominacion_c"];	$cod_bien_inm=$registro["cod_bien_inm"]; 
            $denominacion_c=conv_cadenas($denominacion_c,0); 
			if($prev_cod_clasificacion<>$cod_clasificacion){
			  if(($subtotal<>0)or($c>1)){ $subtotal=formato_monto($subtotal);			    
				?>	 				 
                   	<tr>
			          <td width="100" align="left"></td>
			          <td width="400" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
					  <td width="100" align="left"></td>
			          <td width="100" align="right"></td>
			          <td width="100" align="right">-------------------</td>
			          <td width="400" align="right"></td>
			       </tr>	
			       <tr>
			          <td width="100" align="left"></td>
			          <td width="400" align="left"></td>
					  <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
					  <td width="100" align="left"></td>
			          <td width="100" align="left">Sub-Total <? echo $prev_cod_clasificacion; ?></td>
				      <td width="100" align="right"><? echo $subtotal; ?></td>
				      <td width="400" align="right"></td>
			        </tr>	
			     <?
			  }
			  $subtotal=0;  $prev_cod_clasificacion=$cod_clasificacion; $c=0;
			  ?>
			   <tr>
			          <td width="100" align="left"><? echo $cod_clasificacion; ?></td>
			          <td width="400" align="left"><? echo $denominacion_c; ?></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
					  <td width="100" align="left"></td>
			          <td width="100" align="right"></td>
			          <td width="100" align="right"></td>
			          <td width="400" align="right"></td>
			    </tr>	
			  <?   
			}
			$cod_bien_inm=$registro["cod_bien_inm"]; $denominacion=$registro["denominacion"]; $fechai=$registro["fechai"]; $denom_departamento=$registro["denom_departamento"]; $cod_departamento=$registro["cod_departamento"]; 
			$valor_incorporacion=$registro["valor_incorporacion"]; $cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"];
			$marca=$registro["marca"]; $modelo=$registro["modelo"]; $serial1=$registro["serial1"]; $marca=substr($marca,0,15); $modelo=substr($modelo,0,15); $serial1=substr($serial1,0,20);
			$denominacion=conv_cadenas($denominacion,0); $denominacion_dep=conv_cadenas($denominacion_dep,0); $denom_departamento=conv_cadenas($denom_departamento,0); 
			$marca=conv_cadenas($marca,0);  $modelo=conv_cadenas($modelo,0);  $serial1=conv_cadenas($serial1,0); 
			$monto=formato_monto($valor_incorporacion); $totalg=$totalg+$valor_incorporacion; $subtotal=$subtotal+$valor_incorporacion; $c=$c+1;
			?>	   
				<tr>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_bien_inm; ?></td>				   
				   <td width="400" align="justify"><? echo $denominacion; ?></td>
				   <td width="100" align="left"><? echo $marca; ?></td>
				   <td width="100" align="left"><? echo $modelo; ?></td>
				   <td width="100" align="left"><? echo $serial1; ?></td>
				   <td width="100" align="center"><? echo $fechai; ?></td>
				   <td width="100" align="right"><? echo $monto; ?></td>
				   <td width="400" align="justify"><? echo $cod_departamento." ".$denom_departamento; ?></td>
				</tr>
			 <? 		  
		  }
		  if(($subtotal>0)){ $subtotal=formato_monto($subtotal);	
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
				  <td width="400" align="left"></td>
				  <td width="100" align="left"></td>
				  <td width="100" align="left"></td>
				  <td width="100" align="left"></td>
				  <td width="100" align="right"></td>
				  <td width="100" align="right">-------------------</td>
				  <td width="400" align="right"></td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
				  <td width="400" align="left"></td>
				  <td width="100" align="left"></td>
				  <td width="100" align="left"></td>
				  <td width="100" align="left"></td>
				  <td width="100" align="left">Sub-Total <? echo $prev_cod_clasificacion; ?></td>
				  <td width="100" align="right"><? echo $subtotal; ?></td>
				  <td width="400" align="right"></td>
			</tr>	
		  <? } $totalg=formato_monto($totalg);?>	 				 
			<tr>
			    <td width="100" align="left"></td>			    
			    <td width="400" align="left"></td>
				<td width="100" align="left"></td>
			    <td width="100" align="left"></td>
				<td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right">=============</td>
			    <td width="100" align="right"></td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
				<td width="100" align="left"></td>
				<td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"><strong>Totales</strong></td>
			    <td width="100" align="right"><strong><? echo $totalg; ?></strong></td>
			    <td width="400" align="right"></td>
			</tr>	
	     	
		 </table><?
    }
	
	$sql="delete from bien056 where codigo_mov='".$cod_mov."'";
	$res=pg_exec($conn,$sql); $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$res){ echo $error; } 
 }
?>