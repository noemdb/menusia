<?include ("../../class/seguridad.inc"); include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 

$cod_bien_inmd=$_GET["cod_bien_inmd"];$cod_bien_inmh=$_GET["cod_bien_inmh"];$cod_empresad=$_GET["cod_empresad"];$cod_empresah=$_GET["cod_empresah"]; $observacion=$_GET["observacion"]; $agrup_dep=$_GET["agrup_dep"];
$cod_dependenciad=$_GET["cod_dependenciad"]; $cod_dependenciah=$_GET["cod_dependenciah"]; $cod_direcciond=$_GET["cod_direcciond"]; $cod_direccionh=$_GET["cod_direccionh"];
$cod_departamentod=$_GET["cod_departamentod"]; $cod_departamentoh=$_GET["cod_departamentoh"]; $ordenado=$_GET["ordenado"];

$ced_responsabled=$_GET["ced_responsabled"];$ced_responsableh=$_GET["ced_responsableh"];$tipo_rep=$_GET["tipo_rep"]; $denominacion=$_GET["denominacion"];
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$date = date("d-m-Y");$hora = date("H:i:s a");$Sql=""; $php_os=PHP_OS; 

if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';}   $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';}   $fecha_hasta=$ano1.$mes1.$dia1;
   
$criterio=" (bien014.cod_bien_inm>='$cod_bien_inmd' and bien014.cod_bien_inm<='$cod_bien_inmh') and (bien014.cod_empresa>='$cod_empresad' and bien014.cod_empresa<='$cod_empresah') AND 
  (bien014.cod_dependencia>='$cod_dependenciad' and bien014.cod_dependencia<='$cod_dependenciah') and (bien014.cod_direccion>='$cod_direcciond' and bien014.cod_direccion<='$cod_direccionh') AND
  (bien014.cod_departamento>='$cod_departamentod' and bien014.cod_departamento<='$cod_departamentoh') and (bien014.ced_responsable>='$ced_responsabled' and bien014.ced_responsable<='$ced_responsableh') and (bien014.fecha_incorporacion>='$fecha_desde' and bien014.fecha_incorporacion<='$fecha_hasta')";
if($denominacion<>""){  $criterio=$criterio." and (bien014.denominacion Like '%".$denominacion."%')"; } 

$mordenado=" bien014.cod_dependencia,bien014.cod_bien_inm"; if($ordenado=="N"){$mordenado=" bien014.cod_dependencia,bien014.num_bien"; }
IF($agrup_dep=="SI"){ $mordenado=" bien014.cod_dependencia,bien014.cod_departamento,bien014.cod_bien_inm"; if($ordenado=="N"){$mordenado=" bien014.cod_dependencia,bien014.cod_departamento,bien014.num_bien"; }}
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";}     
         
		$sSQL = "SELECT bien014.cod_bien_inm, bien014.cod_clasificacion, bien014.num_bien, bien014.denominacion, bien014.cod_dependencia,bien014.cod_direccion,bien014.cod_departamento,bien001.denominacion_dep, bien001.direccion_dep, bien014.valor_incorporacion, bien014.fecha_incorporacion, substr(bien014.cod_clasificacion,1,1) as grupo, substr(bien014.cod_clasificacion,3,2) as subgrupo, substr(bien014.cod_clasificacion,6,1) as seccion, bien005.denominacion_dir, bien006.denominacion_dep as denom_departamento, bien004.edo_bien  
	        FROM bien001,bien004,((bien014 LEFT JOIN bien005 ON (bien005.cod_dependencia=bien014.cod_dependencia and bien005.cod_direccion=bien014.cod_direccion)) LEFT JOIN bien006 ON (bien006.cod_departamento=bien014.cod_departamento and bien006.cod_dependencia=bien014.cod_dependencia and bien006.cod_direccion=bien014.cod_direccion)) WHERE (bien001.cod_dependencia = bien014.cod_dependencia) and (bien004.codigo=bien014.edo_conservacion) and ".$criterio."  order by  ".$mordenado;

	
	      $res=pg_query($sSQL); $cod_dependencia=""; $denominacion_dep="";  $subtotal=0; $fin=0; $prev_cod_dep=""; $direccion_dep=""; $denom_departamento=""; $cod_departamento="";
	      $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"];  $denominacion=$registro["denominacion"]; $direccion_dep=$registro["direccion_dep"];
		  $denom_departamento=$registro["denom_departamento"]; $cod_departamento=$registro["cod_departamento"];  $prev_cod_dep=$cod_dependencia; IF($agrup_dep=="SI"){$prev_cod_dep=$cod_dependencia.$cod_departamento; } 
		  if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep); $denom_departamento=utf8_decode($denom_departamento); $direccion_dep=utf8_decode($direccion_dep); } }
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $Nom_Emp; global $cod_dependencia; global $denominacion_dep; global $denom_departamento; global $direccion_dep; global $agrup_dep; global $subtotal;
                $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  
                $estado="YARACUY"; $distrito="";  $municipio="SAN FELIPE"; 				
				//$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$den_enc=$denominacion_dep;
				if($agrup_dep=="SI"){ $den_enc=$denominacion_dep." (".$denom_departamento.")"; }
				//$this->rect(9.8,10,260.2,200);
			    $y=$this->GetY();$x=$this->GetX();
				$this->SetFont('Arial','BU',8);
				$this->Cell(260,5,'FORMULARIO BM-1',0,1,'R');
				$this->SetFont('Arial','B',12);
				$this->Cell(200,10,'INVENTARIO DE BIENES MUEBLES',0,0,'C');
				$this->SetFont('Arial','',8);
				$this->Cell(60,10,'Hoja Nro.: '.$this->PageNo(),0,1,'R');
				$this->Ln(3);
				$this->Cell(200,5,'1. ENTIDAD PROPIETARIA: '.$Nom_Emp,0,0,'L');
				$this->Cell(60,5,'2. SERVICIO: ',0,1,'L');
				
				$this->Cell(260,5,'3. UNIDAD DE TRABAJO O DEPENDENCIA: '.$den_enc,0,1,'L');
				
				$this->Cell(90,5,'4. ESTADO: '.$estado,0,0,'L');
				$this->Cell(90,5,'5. DISTRITO: ',0,0,'L');
				$this->Cell(80,5,'6. MUNICIPIO: '.$municipio,0,1,'L');
				
				$this->Cell(260,5,'7. DIRECCION O LUGAR: '.$direccion_dep,0,1,'L');
				
				$this->Ln(2);
				$y=$this->GetY();$x=$this->GetX();
				
				$this->rect(9.8,50,260.2,140);
				
				
				
			    $this->SetFont('Arial','B',6);
				$this->Cell(30,4,'CLASIFICACION','TB',0,'C');
                $this->SetFont('Arial','B',5);	
                $this->Cell(8,4,'CANTI-','TL',0,'C');				
                $this->Cell(15,4,'NUMERO DE','TL',0,'C'); 
                $this->SetFont('Arial','B',6); 				
				$this->Cell(170,4,'NOMBRE Y DESCRIPCION DE LOS ELEMENTOS','TL',0,'C');				
				$this->Cell(17,4,'VALOR','TL',0,'C');
				$this->Cell(20,4,'VALOR ','TL',1,'C');
				
				$this->SetFont('Arial','B',5);
				$this->Cell(8,3,'GRUPO','TB',0);
				$this->Cell(12,3,'SUB-GRUPO','LTB',0);
				$this->Cell(10,3,'SECCION','LTB',0);
				$this->Cell(8,3,'DAD','LB',0,'C');
				$this->Cell(15,3,'IDENTIFICACION','LB',0,'C');
				
				
				$this->SetFont('Arial','B',6);
				$this->Cell(170,3,'','BL',0,'L');				
				$this->Cell(17,3,'UNITARIO Bs.','BL',0,'C');
				$this->Cell(20,3,'TOTAL Bs.','BL',1,'C');
				$y=$this->GetY();$x=$this->GetX();	
				$this->Line(18,$y-0.1,18,189.9); 
                $this->Line(30,$y-0.1,30,189.9);				
				$this->Line(40,$y-0.1,40,189.9);
				$this->Line(48,$y-0.1,48,189.9);
				$this->Line(63,$y-0.1,63,189.9);
				$this->Line(233,$y-0.1,233,189.9);
				$this->Line(250,$y-0.1,250,189.9);
				
				if($subtotal<>0){ $tmonto=formato_monto($subtotal); 
				   $this->SetFont('Arial','',7);
				   $this->Cell(240,4,'VIENEN...',0,0,'R');
				   $this->Cell(20,4,$tmonto,0,1,'R');
				}
		    } 
			function Footer(){ global $observacion; global $subtotal; global $fin;
			    $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  $tmonto=formato_monto($subtotal); 
				$this->SetY(-30);	
				$this->SetFont('Arial','',7);
				if(($fin==0)and($subtotal<>0)){                  
				  $this->Cell(240,2,'VAN...',0,0,'R');
				  $this->Cell(20,2,$tmonto,0,1,'R');	
                }else{ $this->Cell(20,2,'',0,1,'R');}				
				$y=$this->GetY();$x=$this->GetX();					
				$this->Ln(8);
				$this->SetFont('Arial','',7);
				$this->Cell(260,5,'Firma: del Jefe de la Unidad de Trabajo: ______________________',0,1,'R');	
			}
		  }		  
		  $pdf=new PDF('L', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetAutoPageBreak(true, 30);
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $totalg=0;   $c=0;
		  //$pdf->MultiCell(200,4,$sSQL,0);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;
            $cod_clasificacion=$registro["cod_clasificacion"]; $denominacion_c=$registro["denominacion_c"];	$cod_bien_inm=$registro["cod_bien_inm"];  $num_bien=$registro["num_bien"];
		    $grupo=$registro["grupo"]; $subgrupo=$registro["subgrupo"]; $seccion=$registro["seccion"];  $direccion_dep=$registro["direccion_dep"];
			$cod_bien_inm=$registro["cod_bien_inm"]; $denominacion=$registro["denominacion"]; $edo_bien=$registro["edo_bien"]; $denom_departamento=$registro["denom_departamento"]; $cod_departamento=$registro["cod_departamento"]; 
			$valor_incorporacion=$registro["valor_incorporacion"]; $cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"];
			if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep); $denom_departamento=utf8_decode($denom_departamento); $direccion_dep=utf8_decode($direccion_dep); }
			$cod_grupo=$cod_dependencia; if($agrup_dep=="SI"){$cod_grupo=$cod_dependencia.$cod_departamento; } $cantidad=1;
			
			if($prev_cod_dep<>$cod_grupo){
			  $pdf->SetFont('Arial','B',7); $subtotal=formato_monto($subtotal);
		      $pdf->Cell(240,2,'',0,0);
		      $pdf->Cell(20,2,'----------------------',0,1,'R');
		      $pdf->Cell(220,3,'SUB-TOTAL : ',0,0,'R');
		      $pdf->Cell(20,2,'',0,0,'R');
	          $pdf->Cell(20,2,$subtotal,0,1,'R');
		      
			  $prev_cod_dep=$cod_grupo; $subtotal=0;
			  $pdf->AddPage();
			}
			$pdf->SetFont('Arial','',7); 
			$monto=formato_monto($valor_incorporacion); $totalg=$totalg+$valor_incorporacion; $subtotal=$subtotal+$valor_incorporacion; $c=$c+1;
			$pdf->Cell(8,4,$grupo,0,0,'C');
            $pdf->Cell(12,4,$subgrupo,0,0,'C');	
            $pdf->Cell(10,4,$seccion,0,0,'C');
            $pdf->Cell(8,4,$cantidad,0,0,'C');			
            $pdf->Cell(15,4,$num_bien,0,0,'C');			
		    $x=$pdf->GetX();   $y=$pdf->GetY(); $n=170;
		    $pdf->SetXY($x+$n,$y);
		    $pdf->Cell(17,4,$monto,0,0,'R');
		    $pdf->Cell(20,4,$monto,0,0,'R');
		    $pdf->SetXY($x,$y);
		    $pdf->MultiCell($n,4,$denominacion,0);  
          }
		  
		  if ($cod_dependenciad<>$cod_dependenciah){
		  $pdf->SetFont('Arial','B',7); $subtotal=formato_monto($subtotal);
		  $pdf->Cell(240,2,'',0,0);
		  $pdf->Cell(20,2,'----------------------',0,1,'R');
		  $pdf->Cell(220,3,'SUB-TOTAL : ',0,0,'R');
		  $pdf->Cell(20,2,'',0,0,'R');
	      $pdf->Cell(20,2,$subtotal,0,1,'R'); }
		  
		  $pdf->Ln(3);
		  $totalg=formato_monto($totalg);
		  $pdf->Cell(240,2,'',0,0);
		  $pdf->Cell(20,2,'============',0,1,'R');
		  $pdf->Cell(220,3,'TOTAL GENERAL : ',0,0,'R');
		  $pdf->Cell(20,2,'',0,0,'R');
	      $pdf->Cell(20,2,$totalg,0,1,'R');
		  
		  $fin=1;
		  $pdf->Output();
	
}
?>
