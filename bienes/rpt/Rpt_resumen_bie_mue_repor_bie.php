<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_dependenciad=$_GET["cod_dependenciad"]; $cod_dependenciah=$_GET["cod_dependenciah"]; $tipo_rep=$_GET["tipo_rep"]; $agrup_dep="NO";$date = date("d-m-Y");$hora = date("H:i:s a");$Sql=""; $php_os=PHP_OS; 
$criterio=" (bien015.desincorporado='N') and (bien015.cod_dependencia>='$cod_dependenciad' and bien015.cod_dependencia<='$cod_dependenciah') ";
$mordenado=" bien015.cod_dependencia,bien015.cod_clasificacion,bien015.cod_bien_mue";
IF($agrup_dep=="SI"){ $mordenado=" bien015.cod_dependencia,bien015.cod_departamento,bien015.cod_clasificacion,bien015.cod_bien_mue";}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }    
    $sSQL = "SELECT bien015.cod_bien_mue, bien015.cod_clasificacion, bien015.num_bien, bien015.denominacion, bien015.cod_dependencia,bien015.cod_direccion,bien015.cod_departamento,bien001.Denominacion_Dep, bien001.Direccion_Dep, bien015.Valor_Incorporacion, bien015.Fecha_Incorporacion, bien015.Caracteristicas, bien015.Marca, bien015.Modelo, bien015.Color, bien015.Matricula, bien015.serial1, bien015.Tipo_Clase, bien015.Dimension_Tam, bien015.accesorios, bien015.serial2, bien015.material, substr(bien015.cod_clasificacion,1,1) as grupo, substr(bien015.cod_clasificacion,3,2) as subgrupo, substr(bien015.cod_clasificacion,6,1) as seccion, bien005.denominacion_dir, bien006.denominacion_dep as denom_departamento, bien008.denominacion_C
	        FROM bien001,bien008,((bien015 LEFT JOIN bien005 ON (bien005.cod_dependencia=bien015.cod_dependencia and bien005.cod_direccion=bien015.cod_direccion)) LEFT JOIN bien006 ON (bien006.cod_departamento=bien015.cod_departamento and bien006.cod_dependencia=bien015.cod_dependencia and bien006.cod_direccion=bien015.cod_direccion)) WHERE (bien001.cod_dependencia = bien015.cod_dependencia) and (bien008.codigo_c=bien015.cod_clasificacion) and ".$criterio."  order by  ".$mordenado;
    if($Cod_Emp=="38"){
		$sSQL = "SELECT bien015.cod_bien_mue, bien015.cod_clasificacion, bien015.num_bien, bien015.denominacion, bien015.cod_dependencia,bien015.cod_direccion,bien015.cod_departamento,bien001.Denominacion_Dep, bien001.Direccion_Dep, bien015.Valor_Incorporacion, bien015.Fecha_Incorporacion, bien015.Caracteristicas, bien015.Marca, bien015.Modelo, bien015.Color, bien015.Matricula, bien015.serial1, bien015.Tipo_Clase, bien015.Dimension_Tam, bien015.accesorios, bien015.serial2, bien015.material, substr(bien015.cod_clasificacion,1,1) as grupo, substr(bien015.cod_clasificacion,3,4) as subgrupo, substr(bien015.cod_clasificacion,8,3) as seccion, bien005.denominacion_dir, bien006.denominacion_dep as denom_departamento, bien008.denominacion_C
	        FROM bien001,bien008,((bien015 LEFT JOIN bien005 ON (bien005.cod_dependencia=bien015.cod_dependencia and bien005.cod_direccion=bien015.cod_direccion)) LEFT JOIN bien006 ON (bien006.cod_departamento=bien015.cod_departamento and bien006.cod_dependencia=bien015.cod_dependencia and bien006.cod_direccion=bien015.cod_direccion)) WHERE (bien001.cod_dependencia = bien015.cod_dependencia) and (bien008.codigo_c=bien015.cod_clasificacion) and ".$criterio."  order by  ".$mordenado;
    
	}	
	if($tipo_rep=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");
            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_resumen_bie_mue_repor_bie_mue.xml");
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
	if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $cod_dependencia=""; $denominacion_dep="";  $subtotal=0; $fin=0; $prev_cod_dep=""; $direccion_dep=""; $denom_departamento=""; $cod_departamento=""; $prev_cod_cla=""; $prev_den_cla=""; $subtotalc=0;
	      $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"];  $denominacion=$registro["denominacion"]; $direccion_dep=$registro["direccion_dep"];
		  $denom_departamento=$registro["denom_departamento"]; $cod_departamento=$registro["cod_departamento"];  $prev_cod_cla=$registro["cod_clasificacion"]; $prev_den_cla=$registro["denominacion_c"]; $subtotalc=0;
		  $prev_cod_dep=$cod_dependencia; IF($agrup_dep=="SI"){$prev_cod_dep=$cod_dependencia.$cod_departamento; } 
		  if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep); $denom_departamento=utf8_decode($denom_departamento); $direccion_dep=utf8_decode($direccion_dep); } }
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $Nom_Emp; global $cod_dependencia; global $denominacion_dep; global $denom_departamento; global $direccion_dep; global $agrup_dep; global $subtotal;
                $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  			
				//$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$den_enc=$denominacion_dep;
				if($agrup_dep=="SI"){ $den_enc=$denominacion_dep." (".$denom_departamento.")"; }
				$this->rect(9.8,10,260.2,200);
			    $y=$this->GetY();$x=$this->GetX();
				$this->SetFont('Arial','B',8);
				$this->Cell(150,5,$Nom_Emp,0,1);
				$this->SetFont('Arial','B',12);
				$this->Cell(200,10,'RESUMEN POR SUB-GRUPOS DE LOS BIENES MUEBLES',0,0,'C');
				$this->SetFont('Arial','',8);
				$this->Cell(60,5,'Fecha: '.$ffechar,0,1,'R');
				$this->Cell(260,5,'Pagina: '.$this->PageNo(),0,1,'R');
				
				$this->Ln(4);
				$y=$this->GetY();$x=$this->GetX();
				//$this->Line(10,$y,270,$y);
				$this->Cell(260,4,'D E N O M I N A C I O N','TB',1,'C');
				$this->SetFont('Arial','',7);
				$this->Cell(230,3,'DEPENDENCIA O UNIDAD DE TRABAJO',0,0,'L');
				$this->Cell(30,3,'CODIGO','L',1,'L');				
				$this->Cell(230,4,$den_enc,0,0,'L');
				$this->Cell(30,4,$cod_dependencia,'L',1,'L');
				$this->SetFont('Arial','',8);
				$this->Cell(260,4,'U  B  I  C  A  C  I  O  N ','TB',1,'C');
				$this->SetFont('Arial','',7);
				$this->Cell(260,4,$direccion_dep,'B',1,'L');
				
			    $this->SetFont('Arial','B',6);
				$this->Cell(30,4,'CLASIFICACION','TB',0,'C');
                $this->SetFont('Arial','B',6); 				
				$this->Cell(210,4,'NOMBRE Y DESCRIPCION DEL GRUPO DE BIENES','TL',0,'C');
				$this->Cell(20,4,'VALOR UNITARIO','TL',1,'C');
				
				$this->SetFont('Arial','B',5);
				$this->Cell(8,3,'GRUPO','TB',0);
				$this->Cell(12,3,'SUB-GRUPO','LTB',0);
				$this->Cell(10,3,'SECCION','LTB',0);
				$this->Cell(210,3,'','BL',0,'L');
				$this->Cell(20,3,'','BL',1,'C');
				$y=$this->GetY();$x=$this->GetX();	
				$this->Line(18,$y-0.1,18,186.9); 
                $this->Line(30,$y-0.1,30,186.9);				
				$this->Line(40,$y-0.1,40,186.9);
				$this->Line(250,$y-0.1,250,186.9);
				
				if($subtotal<>0){ $tmonto=formato_monto($subtotal); 
				   $this->SetFont('Arial','',7);
				   $this->Cell(240,4,'VIENEN...',0,0,'R');
				   $this->Cell(20,4,$tmonto,0,1,'R');
				}
		    } 
			function Footer(){  global $subtotal; global $fin;
			    $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  $tmonto=formato_monto($subtotal); 
				$this->SetY(-32);	
				$y=$this->GetY();$x=$this->GetX();	
				$this->SetFont('Arial','',7);
				if(($fin==0)and($subtotal<>0)){                  
				  $this->Cell(240,3,'VAN...',0,0,'R');
				  $this->Cell(20,3,$tmonto,0,1,'R');	
                }else{ $this->Cell(20,3,'',0,1,'R');}				
				$y=$this->GetY();$x=$this->GetX();	
				$this->SetFont('Arial','',6);
				$this->Cell(20,5,'','TB',0,'C');
				$this->Cell(65,5,'PREPARACION','TB',0,'C');
				$this->Cell(65,5,'CONFORMACION','TB',0,'C');
				$this->Cell(65,5,'APROBACION','TB',0,'C');
				$this->Cell(45,5,'SELLO','TB',1,'C');
				
				$this->Cell(20,6,'NOMBRE','B',0,'C');
				$this->Cell(65,6,'','B',0,'C');
				$this->Cell(65,6,'','B',0,'C');
				$this->Cell(65,6,'','B',0,'C');
				$this->Cell(45,6,'',0,1,'C');
				
				$this->Cell(20,6,'CARGO','B',0,'C');
				$this->Cell(65,6,'','B',0,'C');
				$this->Cell(65,6,'','B',0,'C');
				$this->Cell(65,6,'','B',0,'C');
				$this->Cell(45,6,'',0,1,'C');
				$this->Cell(20,5,'FIRMA',0,0,'C');
				$this->Cell(65,6,'',0,0,'C');
				$this->Cell(65,6,'',0,0,'C');
				$this->Cell(65,6,'',0,0,'C');
				$this->Cell(45,6,'',0,1,'C');
				$this->Line(30,$y-0.1,30,$y+23);
				$this->Line(95,$y-0.1,95,$y+23);
				$this->Line(160,$y-0.1,160,$y+23);
				$this->Line(225,$y-0.1,225,$y+23);
			}
		  }		  
		  $pdf=new PDF('L', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetAutoPageBreak(true, 32);
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $totalg=0;   $c=0; 
		  while($registro=pg_fetch_array($res)){ $i=$i+1;
            $cod_clasificacion=$registro["cod_clasificacion"]; $denominacion_c=$registro["denominacion_c"];	$cod_bien_mue=$registro["cod_bien_mue"];  $num_bien=$registro["num_bien"];
		    $grupo=$registro["grupo"]; $subgrupo=$registro["subgrupo"]; $seccion=$registro["seccion"];  $direccion_dep=$registro["direccion_dep"];
			$cod_bien_mue=$registro["cod_bien_mue"]; $denominacion=$registro["denominacion"];  $denom_departamento=$registro["denom_departamento"]; $cod_departamento=$registro["cod_departamento"]; 
			$valor_incorporacion=$registro["valor_incorporacion"]; $cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"];
			if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep); $denom_departamento=utf8_decode($denom_departamento); $direccion_dep=utf8_decode($direccion_dep); }
			$cod_grupo=$cod_dependencia; if($agrup_dep=="SI"){$cod_grupo=$cod_dependencia.$cod_departamento; }
			
			if($prev_cod_cla<>$cod_clasificacion){
			  $pdf->SetFont('Arial','',7); $subtotalc=formato_monto($subtotalc);
			  $pgrupo=substr($prev_cod_cla,0,1); $psubgrupo=substr($prev_cod_cla,2,2);	$pseccion=substr($prev_cod_cla,5,1);
              if($Cod_Emp=="38"){
                $pgrupo=substr($prev_cod_cla,0,1); $psubgrupo=substr($prev_cod_cla,2,4);	$pseccion=substr($prev_cod_cla,7,3);              				  
              } 				  
			  $pdf->Cell(8,4,$pgrupo,0,0,'C');
              $pdf->Cell(12,4,$psubgrupo,0,0,'C');	
              $pdf->Cell(10,4,$pseccion,0,0,'C');
			  $x=$pdf->GetX();   $y=$pdf->GetY(); $n=210;
		      $pdf->SetXY($x+$n,$y);
		      $pdf->Cell(20,4,$subtotalc,0,0,'R');
		      $pdf->SetXY($x,$y);
		      $pdf->MultiCell($n,4,$prev_den_cla,0);  
			  $prev_cod_cla=$registro["cod_clasificacion"]; $prev_den_cla=$registro["denominacion_c"]; $subtotalc=0; 
			}
			
			
			if($prev_cod_dep<>$cod_grupo){
			  $pdf->SetFont('Arial','B',7); $subtotal=formato_monto($subtotal);
		      $pdf->Cell(240,2,'',0,0);
		      $pdf->Cell(20,2,'----------------------',0,1,'R');			  
		      $pdf->Cell(30,3,' ',0,0);			  
		      $pdf->Cell(190,3,'CANTIDAD DE BIENES : '.$c,0,0,'L');
			  $pdf->Cell(20,3,'TOTAL : ',0,0,'R');
	          $pdf->Cell(20,3,$subtotal,0,1,'R');		      
			  $prev_cod_dep=$cod_grupo; $subtotal=0; $c=0; 
			  $pdf->AddPage();
			}
			$pdf->SetFont('Arial','',7); 
			$monto=formato_monto($valor_incorporacion); $totalg=$totalg+$valor_incorporacion; $subtotal=$subtotal+$valor_incorporacion; $subtotalc=$subtotalc+$valor_incorporacion; $c=$c+1;
			
			//$pdf->Cell(8,4,$grupo,0,0,'C');
            //$pdf->Cell(12,4,$subgrupo,0,0,'C');	
            //$pdf->Cell(10,4,$seccion,0,0,'C');			
            //$pdf->Cell(15,4,$num_bien,0,0,'C');			
		    //$x=$pdf->GetX();   $y=$pdf->GetY(); $n=195;
		    //$pdf->SetXY($x+$n,$y);
		    //$pdf->Cell(20,4,$monto,0,0,'R');
		    //$pdf->SetXY($x,$y);
		    //$pdf->MultiCell($n,4,$denominacion,0);  
          }
		  $pdf->SetFont('Arial','B',7); $subtotal=formato_monto($subtotal);
		      $pdf->Cell(240,2,'',0,0);
		      $pdf->Cell(20,2,'----------------------',0,1,'R');			  
		      $pdf->Cell(30,3,' ',0,0);			  
		      $pdf->Cell(190,3,'CANTIDAD DE BIENES : '.$c,0,0,'L');
			  $pdf->Cell(20,3,'TOTAL BS. : ',0,0,'R');
	          $pdf->Cell(20,3,$subtotal,0,1,'R');
		  
		  
		  
		  $fin=1;
		  $pdf->Output();
	}
}
?>

          
