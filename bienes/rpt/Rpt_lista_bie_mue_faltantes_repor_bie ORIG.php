<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_bien_mued=$_GET["cod_bien_mued"];$cod_bien_mueh=$_GET["cod_bien_mueh"];$cod_dependenciad=$_GET["cod_dependenciad"]; $cod_dependenciah=$_GET["cod_dependenciah"]; 
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"]; $date = date("d-m-Y");$hora = date("H:i:s a");$Sql=""; $php_os=PHP_OS;  $tipo_rep="PDF";
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';}   $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';}   $fecha_hasta=$ano1.$mes1.$dia1;
$criterio ="(BIEN015.cod_bien_mue>='$cod_bien_mued' AND BIEN015.cod_bien_mue<='$cod_bien_mueh') AND (BIEN025.Cod_Dependencia>='$cod_dependenciad' AND BIEN025.Cod_Dependencia<='$cod_dependenciah') AND
(BIEN025.fecha>='$fecha_desde' AND BIEN025.fecha<='$fecha_hasta') and (BIEN040.Tipo_Movimiento='060')";

$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }  
   
     $sSQL = "SELECT BIEN025.referencia, BIEN025.fecha, BIEN015.cod_bien_mue, BIEN015.cod_clasificacion, substr(BIEN015.Cod_Clasificacion,1,1) as grupo, substr(BIEN015.Cod_Clasificacion,3,2) as subgrupo, substr(BIEN015.Cod_Clasificacion,6,1) as seccion, BIEN015.Num_Bien, BIEN015.Denominacion,
            BIEN025.Cod_Dependencia, BIEN001.Denominacion_Dep, BIEN001.Direccion_Dep, BIEN040.Tipo_Movimiento, BIEN003.Denomina_Tipo, BIEN040.Tipo_ID, BIEN025.Descripcion, BIEN025.Anulado, BIEN040.Cantidad, BIEN040.Monto, BIEN015.Direccion, BIEN015.Valor_Incorporacion, BIEN025.Saldo_Anterior  
            FROM BIEN001, BIEN003, BIEN015, BIEN025, BIEN040  WHERE (BIEN001.Cod_Dependencia = BIEN025.Cod_Dependencia) AND (BIEN025.Fecha=BIEN040.Fecha) AND
            (BIEN015.cod_bien_mue=BIEN040.cod_bien_mue) AND  (BIEN025.referencia=BIEN040.referencia) AND (BIEN040.Tipo_Movimiento=BIEN003.Codigo) AND (BIEN025.Anulado='N') AND ".$criterio."";

    if($tipo_rep=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");	
            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_lista_bie_mue_faltantes_repor_bie_mue.xml");
            $oRpt->setUser("$user");
            $oRpt->setPassword("$password");
            $oRpt->setConnection("$host");
            $oRpt->setDatabaseInterface("postgresql");
            $oRpt->setSQL($sSQL);
            $oRpt->setDatabase("$dbname");
            $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"date1"=>$date1,"hora"=>$hora));
            $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
            $oRpt->run();
            $aBench = $oRpt->getBenchmark();
            $iSec   = $aBench["report_end"]-$aBench["report_start"];
	}		
	if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $referencia=""; $fecha=""; $cod_dependencia=""; $denominacion_dep="";  $subtotal=0; $fin=0; $prev_referencia=""; $prev_fecha=""; $direccion_dep=""; $saldo_anterior=0;
	     $filas=pg_num_rows($res); if($filas>=1){ 
		      $registro=pg_fetch_array($res,0); $referencia=$registro["referencia"]; $fecha=$registro["fecha"]; $prev_referencia=$registro["referencia"]; $prev_fecha=$registro["fecha"];
		      $cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"];  $denominacion=$registro["denominacion"]; $direccion_dep=$registro["direccion_dep"];
		  if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep);  $direccion_dep=utf8_decode($direccion_dep); } }
		  if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $Nom_Emp; global $referencia; global $fecha; global $cod_dependencia; global $denominacion_dep;  global $direccion_dep; global $mes_proceso;
                $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  
                $estado="YARACUY"; $distrito="";  $municipio="SAN FELIPE"; 	$den_enc=$denominacion_dep;				
			    $y=$this->GetY();$x=$this->GetX();
				$this->SetFont('Arial','BU',8);
				$this->Cell(260,5,'FORMULARIO BM-3',0,1,'R');
				$this->SetFont('Arial','B',8);
				$this->Cell(200,10,'RELACION DE BIENES MUEBLES FALTANTES',0,0,'C');
				$this->SetFont('Arial','',8);
				$this->Cell(60,10,'Hoja Nro.: '.$this->PageNo(),0,1,'R');
				$this->Ln(3);
				$this->SetFont('Arial','',7);
				$this->Cell(190,5,'1.ENTIDAD: ESTADO: '.$estado,'TRL',0,'L');
				$this->Cell(5,5,'',0,0,'L');
				$this->Cell(65,5,'IDENTIFICACION DEL COMPROBANTE',1,1,'C');
				
				$this->Cell(190,5,'         DISTRITO: '.$distrito,'RL',0,'L');
				$this->Cell(5,5,'',0,0,'L');
				$this->SetFont('Arial','',5);
				$this->Cell(40,5,'CODIGO CONCEPTO MOVIMIENTO',1,0,'C');
				$this->SetFont('Arial','',7);
				$this->Cell(25,5,'060',1,1,'C');
				
				$this->Cell(190,5,'         MUNICIPIO: '.$municipio,'RL',0,'L');
                $this->Cell(5,5,'',0,0,'L');
				$this->SetFont('Arial','',5);
				$this->Cell(40,5,'NUMERO DEL COMPROBANTE',1,0,'C');
				$this->SetFont('Arial','',7);
				$this->Cell(25,5,$referencia,1,1,'C');
				
                $this->Cell(190,5,'2. UNIDAD DE TRABAJO O DEPENDENCIA: '.$den_enc,'RL',0,'L');	
                $this->Cell(5,5,'',0,0,'L');
				$this->SetFont('Arial','',5);
				$this->Cell(40,5,'FECHA DE LA OPERACION',1,0,'C');
				$this->SetFont('Arial','',7);
				$this->Cell(25,5,$fecha,1,1,'C');

				
				$this->Cell(190,5,'3. UBICACION ADMINISTRATIVA : '.$direccion_dep,'RLB',1,'L');	


				
				
				$this->Ln(2);
				$y=$this->GetY();$x=$this->GetX();				
				$this->rect(9.8,55,260.2,130);
				
			    $this->SetFont('Arial','B',6);
				$this->Cell(30,4,'CODIGO','TB',0,'C');					
                $this->SetFont('Arial','B',5);
				$this->Cell(15,4,'NUMERO DE','TL',0,'C'); 
                $this->SetFont('Arial','B',6); 				
				$this->Cell(135,4,'DESCRIPCION DE LOS BIENES','TL',0,'C');					
                $this->Cell(30,4,'CANTIDAD','1',0,'C');					
                $this->Cell(20,4,'VALOR','TL',0,'C');
				$this->Cell(30,4,'DIFERENCIA','1',1,'C');


				
				$this->SetFont('Arial','B',5);
				$this->Cell(8,3,'GRUPO','TB',0);
				$this->Cell(12,3,'SUB-GRUPO','LTB',0);				
				$this->Cell(10,3,'SECCION','LTB',0);	
                $this->Cell(15,3,'IDENTIFICACION','LB',0,'C'); 
                $this->Cell(135,3,'','BL',0,'L');	
				 $this->SetFont('Arial','B',5);
				$this->Cell(15,3,'EXIST.FISICA','LB',0,'C');
				$this->Cell(15,3,'REGIS.CONTAB','LB',0,'C');
				
				$this->SetFont('Arial','B',6);							
				$this->Cell(20,3,'UNITARIO','BL',0,'C');
				$this->SetFont('Arial','B',5);	
				$this->Cell(10,3,'CANTIDAD','BL',0,'C');
				$this->Cell(20,3,'VALOR TOTAL Bs.','BL',1,'C');
				
				$y=$this->GetY();$x=$this->GetX();	
				$this->Line(18,$y-0.1,18,184.9); 
                $this->Line(30,$y-0.1,30,184.9);				
				$this->Line(40,$y-0.1,40,184.9);
				$this->Line(55,$y-0.1,55,184.9);				
				$this->Line(190,$y-0.1,190,184.9);
				$this->Line(205,$y-0.1,205,184.9);
				$this->Line(220,$y-0.1,220,184.9);
				$this->Line(240,$y-0.1,240,184.9);
				$this->Line(250,$y-0.1,250,184.9);
				
				
		    } 
			function Footer(){  global $subtotali; global $subtotald; global $fin; global $saldo_anterior; global $subtotal;
			    $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  $tmonto=formato_monto($subtotal); 
				$this->SetY(-30);	
				$this->SetFont('Arial','',6);
				$saldo_actual=$saldo_anterior+$subtotali-$subtotald;
				$smontoi=formato_monto($subtotali); $smontod=formato_monto($subtotald); 
				$smontoa=formato_monto($saldo_anterior); $smontoc=formato_monto($saldo_actual);
				if($fin==1){
					$this->Cell(138,5,'OBSERVACIONES',1,0,'L');
					$this->Cell(2,5,'',0,0,'C');
					$this->Cell(120,5,'FALTANTES DETERMINADOS POR:',1,1,'L');
					
					$this->Cell(138,5,'',1,0,'L');
					$this->Cell(2,5,'',0,0,'C');
					$this->Cell(120,5,'CARGO QUE DESEMPEÑA:',1,1,'L');
					
					$this->Cell(138,5,'',1,0,'L');
					$this->Cell(2,5,'',0,0,'C');
					$this->Cell(120,5,'DEPENDENCIA A LA CUAL ESTA ADSCRITO:',1,1,'L');
					
					$this->Cell(138,5,'',1,0,'L');
					$this->Cell(2,5,'',0,0,'C');
					$this->Cell(120,5,'JEFE DE LA UNIDAD DE TRABAJO:',1,1,'L');
				}
				
			}
		  }		  
		  $pdf=new PDF('L', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetAutoPageBreak(true, 30);
		  $pdf->SetFont('Arial','',7);
		  
		  		  
		  $i=0;  $totali=0; $totald=0;   $subtotali=0;  $subtotald=0; $c=0; $totalg=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;
            $cod_clasificacion=$registro["cod_clasificacion"]; $denominacion_c=$registro["denominacion_c"];	$referencia=$registro["referencia"]; $fecha=$registro["fecha"];
			$cod_bien_mue=$registro["cod_bien_mue"];  $num_bien=$registro["num_bien"];
		    $grupo=$registro["grupo"]; $subgrupo=$registro["subgrupo"]; $seccion=$registro["seccion"];  $direccion_dep=$registro["direccion_dep"];			
			$cod_bien_mue=$registro["cod_bien_mue"]; $denominacion=$registro["denominacion"]; $tipo_id=$registro["tipo_id"];
			$cantidad=1; $monto=$registro["monto"]; $tipo_movimiento=$registro["tipo_movimiento"]; $denomina_tipo=$registro["denomina_tipo"];			
			$cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"];
			if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep); $direccion_dep=utf8_decode($direccion_dep); }
			$cod_ref=$referencia; $cod_fecha=$fecha;
			if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
			if(($prev_referencia<>$cod_ref)or($prev_fecha<>$cod_fecha)){			  
			  $fin=1;
			  $pdf->AddPage();
			  $prev_referencia=$cod_r; $prev_fecha=$cod_fecha;
			  $subtotal=0; $subtotali=0;  $subtotald=0; $fin=0;
			}
			$pdf->SetFont('Arial','',7); 
			 
			$totalg=$totalg+$monto; $subtotal=$subtotal+$monto; $c=$c+1;
			
			if($tipo_id=="I"){ $montoi=formato_monto($monto); $totali=$totali+$monto; $subtotali=$subtotali+$monto; $montod=""; } 
			  else { $montod=formato_monto($monto); $totald=$totald+$monto; $subtotald=$subtotald+$monto; $montoi=""; }
			$monto=formato_monto($monto);
			
			
			$pdf->Cell(8,4,$grupo,0,0,'C');
            $pdf->Cell(12,4,$subgrupo,0,0,'C');	
            $pdf->Cell(10,4,$seccion,0,0,'C');	
			$pdf->Cell(15,4,$num_bien,0,0,'C');	
			 		
           		
		    $x=$pdf->GetX();   $y=$pdf->GetY(); $n=135;
		    $pdf->SetXY($x+$n,$y);
			
			$pdf->Cell(15,4,'',0,0,'C');
			$pdf->Cell(15,4,'',0,0,'C');
		    $pdf->Cell(20,4,$monto,0,0,'R');
			$pdf->Cell(10,4,$cantidad,0,0,'C');	
		    $pdf->Cell(20,4,$monto,0,1,'R');
		    $pdf->SetXY($x,$y);
		    $pdf->MultiCell($n,4,$denominacion,0);
			
          }
		  $fin=1;
		  $pdf->Output();
	}		
			
 }
?>
