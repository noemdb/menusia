<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);
$periodod=$_GET["periodod"];$mes=$_GET["mes"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$Sql="";$date = date("d-m-Y");$hora = date("H:i:s a"); $tipo_rpt=$_GET["tipo_rpt"];
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';}$fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;
$criterio1="Mes :  ".$mes."  "."Año : ".$periodod; 
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }  

   $sSQL="SELECT * FROM planillas_ret where tipo_planilla='04' and fecha_emision>='".$fecha_desde."' and fecha_emision<='".$fecha_hasta."'";

   if($tipo_rpt=="PDF"){ $res=pg_query($sSQL); $ano_fiscal_grupo=""; 	
      if($php_os=="WINNT"){$criterio1=$criterio1;}else{$criterio1=utf8_decode($criterio1);}
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tam_logo; global $ano_fiscal_grupo;  global $registro;
			//$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',12);
			$this->Cell(260,6,'GOBIERNO BOLIVARIANO DEL ESTADO MIRANDA',0,1,'C');
			$this->Cell(260,6,'SUPERINTENDENCIA DE ADMINISTRACIÓN TRIBUTARIA DEL ESTADO MIRANDA',0,1,'C');
			$this->Cell(260,6,'RELACIÓN MENSUAL',0,1,'C');
			$this->Cell(260,6,'IMPUESTO 1 X 1000 - ENTES PÚBLICOS',0,1,'C');
			
			$this->Ln(10);
			$this->SetFont('Arial','B',9);
			$this->Cell(40,5,'AGENTE DE RETENCION :',0,0,'L');
			$this->SetFont('Arial','',9);
			$this->Cell(130,5,'CORPORACIÓN DE SALUD DEL ESTADO MIRANDA',0,1,'L');
			$this->SetFont('Arial','B',9);
			$this->Cell(30,5,'PERIODO FISCAL :',0,0,'L');
			$this->SetFont('Arial','',9);
			$this->Cell(130,5,$criterio1,0,1,'L');				
			
			$this->Ln(3);
			$this->SetFont('Arial','B',6);			
			$this->Cell(29,3,'SELEC. TIPO DE INSTRUM.','RLT',0,'C');	
			$this->Cell(13,3,'','RLT',0,'C');			
			$this->Cell(40,3,'','RLT',0,'C');
			$this->Cell(13,3,'','RLT',0,'C');			
			$this->Cell(13,3,'','RLT',0,'C');			
			$this->Cell(80,3,'','RLT',0,'C');
			$this->Cell(15,3,'','RLT',0,'C');
			$this->Cell(20,3,'','RLT',0,'C');
			$this->Cell(17,3,'','RLT',0,'C');
            $this->Cell(20,3,'','RLT',1,'C');	
			
			$this->SetFont('Arial','B',6);
			$this->Cell(9,3,'ORDEN','RLT',0,'C');
			$this->Cell(10,3,'','RLT',0,'C');
			$this->Cell(10,3,'','RLT',0,'C');			
			$this->Cell(13,3,'NUMERO','RL',0,'C');			
			$this->Cell(40,3,'','RL',0,'C');
			$this->Cell(13,3,'','RL',0,'C');			
			$this->Cell(13,3,'NUMERO','RL',0,'C');			
			$this->Cell(80,3,'','RL',0,'C');
			$this->Cell(15,3,'','RL',0,'C');
			$this->Cell(20,3,'','RL',0,'C');
			$this->Cell(17,3,'MONTO','RL',0,'C');
            $this->Cell(20,3,'','RL',1,'C');	
			
			$this->Cell(9,3,'DE','RL',0,'C');
			$this->Cell(10,3,'','RL',0,'C');
			$this->Cell(10,3,'','RL',0,'C');			
			$this->Cell(13,3,'DE','RL',0,'C');			
			$this->Cell(40,3,'','RL',0,'C');
			$this->Cell(13,3,'','RL',0,'C');			
			$this->Cell(13,3,'DE','RL',0,'C');			
			$this->Cell(80,3,'','RL',0,'C');
			$this->Cell(15,3,'','RL',0,'C');
			$this->Cell(20,3,'','RL',0,'C');
			$this->Cell(17,3,'DEL','RL',0,'C');
            $this->Cell(20,3,'','RL',1,'C');	
			
			$this->Cell(9,3,'PAGO','RLB',0,'C');
			$this->Cell(10,3,'CHEQUE','RLB',0,'C');
			$this->Cell(10,3,'TRANSF.','RLB',0,'C');			
			$this->Cell(13,3,'INSTRUM.','RLB',0,'C');			
			$this->Cell(40,3,'BANCO','RLB',0,'C');
			$this->Cell(13,3,'FECHA','RLB',0,'C');			
			$this->Cell(13,3,'DEPOSITO','RLB',0,'C');			
			$this->Cell(80,3,'NOMBRE DEL CONTRUIBUYENTE','RLB',0,'C');
			$this->Cell(15,3,'RIF','RLB',0,'C');
			$this->Cell(20,3,'MONTO BRUTO','RLB',0,'C');
			$this->Cell(17,3,'IMPUESTO','RLB',0,'C');
            $this->Cell(20,3,'MUNICIPIO','RLB',1,'C');	


			
			
			

		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',3);
			$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $sub_total1=""; $sub_total2=""; $sub_total3=""; $sub_total4=""; $sub_total5=""; $prev_ano_fiscal=""; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
           $cod_banco=$registro["cod_banco"]; $tipo_mov=$registro["tipo_mov"]; $referencia=$registro["referencia"];
		   $sel1=""; $sel2=""; $sel3=""; if($tipo_mov=="O/P"){ $sel1="X";} if($tipo_mov=="CHQ"){ $sel2="X";} if($tipo_mov=="NDB"){ $sel3="X";}
		   $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $nombre_banco=$registro["nombre_banco"]; $fecha_emision=$registro["fecha_emision"]; 
		   $fecha_enterado=$registro["fecha_enterado"]; $nombre_banco_ent=$registro["nombre_banco_ent"]; $nro_deposito=$registro["nro_deposito"]; 
		   $monto_objeto=$registro["monto_objeto"]; $monto_retencion=$registro["monto_retencion"]; 
		   
		   $monto_objeto=formato_monto($monto_objeto); $monto_retencion=formato_monto($monto_retencion);
		   $fecha_emision=formato_ddmmaaaa($fecha_emision); if($fecha_enterado==""){$fecha_enterado="";}else{$fecha_enterado=formato_ddmmaaaa($fecha_enterado); }
		   if($php_os=="WINNT"){$nombre=$registro["nombre"];}else{$nombre=utf8_decode($registro["nombre"]);}
		   $pdf->SetFont('Arial','',6.5);
		   $h=4; if(strlen($nombre)>=80){$h=8;}
		   $pdf->Cell(9,$h,$sel1,'RL',0,'C'); 
		   $pdf->Cell(10,$h,$sel2,'RL',0,'C'); 
		   $pdf->Cell(10,$h,$sel3,'RL',0,'C'); 
		   $pdf->Cell(13,$h,$referencia,'RL',0,'C'); 		   
		   $pdf->Cell(40,$h,$nombre_banco_ent,'RL',0,'C'); 
		   $pdf->Cell(13,$h,$fecha_enterado,'RL',0,'C'); 
		   $pdf->Cell(13,$h,$nro_deposito,'RL',0,'C'); 
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=80;
		   $pdf->SetXY($x+$w,$y);
		   $pdf->Cell(15,$h,$ced_rif,'RL',0,'L'); 
		   $pdf->Cell(20,$h,$monto_objeto,'RL',0,'R'); 
		   $pdf->Cell(17,$h,$monto_retencion,'RL',0,'R'); 
		   $pdf->Cell(20,$h,'GUAICAIPURO','RL',1,'C'); 
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($w,4,$nombre,'RL');  
			
		} 
		
		$pdf->Cell(9,1,'','RLB',0,'C');
			$pdf->Cell(10,1,'','RLB',0,'C');
			$pdf->Cell(10,1,'','RLB',0,'C');			
			$pdf->Cell(13,1,'','RLB',0,'C');			
			$pdf->Cell(40,1,'','RLB',0,'C');
			$pdf->Cell(13,1,'','RLB',0,'C');			
			$pdf->Cell(13,1,'','RLB',0,'C');			
			$pdf->Cell(80,1,'','RLB',0,'C');
			$pdf->Cell(15,1,'','RLB',0,'C');
			$pdf->Cell(20,1,'','RLB',0,'C');
			$pdf->Cell(17,1,'','RLB',0,'C');
            $pdf->Cell(20,1,'','RLB',1,'C');	
		
		$pdf->Output();     
    }
	
}