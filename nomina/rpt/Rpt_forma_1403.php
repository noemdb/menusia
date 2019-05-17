<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_empleado=$_POST["txtcod_empleado"];$cedula=$_POST["txtcedula"];$nacionalidad=$_POST["txtnacionalidad"];$fecha_ingreso=$_POST["txtfecha_ingreso"];
$nombre=$_POST["txtnombre"];$tnom_emp=$_POST["txtnom_emp"]; $nro_empresa=$_POST["txtnro_empresa"];
$num_aseg=$_POST["txtnum_aseg"]; $cod_suc=$_POST["txtcod_suc"]; $cond_trab=$_POST["txtcond_trab"];$fecha_nac=$_POST["txtfecha_nacimiento"]; $direccion=$_POST["txtdireccion"];
$cod_cent=$_POST["txtcod_cent"]; $sexo=$_POST["txtsexo"]; $zurdo=$_POST["txtzurdo"]; $ing_empresa=$_POST["txting_empresa"]; $cod_z="";
$salario_sem=$_POST["txtsalario_sem"]; $cod_ocupacion=$_POST["txtcod_ocupacion"]; $ocupacion=$_POST["txtocupacion"];  $fec_retiro=$_POST["txtfec_retiro"];


$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} 
  if($php_os=="WINNT"){$Nom_Emp=$Nom_Emp; }else{$Nom_Emp=utf8_decode($Nom_Emp); $nombre=utf8_decode($nombre); }
  $nac_v=""; $nac_e=""; if(substr($nacionalidad,0,1)=="E"){$nac_e="X";}else {$nac_v="X";}
  
  if($cond_trab=="DESPEDIDO"){$cond_d="X";} else{$cond_d=""; }
  if($cond_trab=="RENUNCIA"){$cond_r="X";} else{$cond_r=""; }
  if($cond_trab=="PENSIONADO"){$cond_p="X";} else{$cond_p=""; }
  if($cond_trab=="JUBILADO"){$cond_j="X";} else{$cond_j=""; }  
  if($cond_trab=="TRASLADO A OTRA EMPRESA"){$cond_t="X";} else{$cond_t=""; }
  if($cond_trab=="FALLECIMIENTO"){$cond_f="X";} else{$cond_f=""; } 
  
  $sexo_m=""; $sexo_f=""; if($sexo=="MASCULINO"){$sexo_m="X";}else {$sexo_f="X";} 
  $zurdo_s=""; $zurdo_n=""; if($zurdo=="SI"){$zurdo_s="X";}else {$zurdo_n="X";}  
  $dian=substr($fecha_nac,0,2); $mesn=substr($fecha_nac,3,2); $anon=substr($fecha_nac,8,2);  
  $diai=substr($ing_empresa,0,2); $mesi=substr($ing_empresa,3,2); $anoi=substr($ing_empresa,8,2);  
  $diar=substr($fec_retiro,0,2); $mesr=substr($fec_retiro,3,2); $anor=substr($fec_retiro,8,2);
  
  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $cod_empleado_grupo; global $cod_concepto_grupo; global $registro;
			$this->Image('../../imagenes/Logo ivss.jpg',7,7,18);
			$this->SetFont('Arial','B',8);
			$this->Cell(30);
			$this->Cell(70,3,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,0,'C');
			$this->Cell(90,3,'FORMA: 14-03',0,1,'R');
			$this->SetFont('Arial','',7);
			$this->Cell(30);
			$this->Cell(70,3,'MINISTERIO DEL PODER POPULAR PARA EL TRABAJO Y SEGURIDAD SOCIAL',0,1,'C');
			$this->Cell(30);
			$this->Cell(70,3,'INSTITUTO VENEZOLANO DE LOS SEGUROS SOCIALES ',0,1,'C');
			$this->Cell(30);
			$this->Cell(70,3,'DIRECCION GENERAL DE AFILIACION  Y PRESTACIONES EN DINERO ',0,1,'C');
			$this->Ln(7);
			$this->SetFont('Arial','B',12);
			$this->Cell(200,6,'PARTICIPACION DE RETIRO DEL TRABAJADOR',0,1,'C');
			$this->SetFont('Arial','',8);
            $this->Ln(2);			
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			//$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			//$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  
      $pdf->SetFont('Arial','',7); 	      	
	  $pdf->Cell(155,4,'1. RAZON SOCIAL DE LA EMPRESA O NOMBRE DEL PATRONO	',1,0,'C'); 
	  $pdf->Cell(45,4,'2. NUMERO DE EMPRESA',1,1,'C');	  
	  $pdf->Cell(155,6,$tnom_emp,1,0,'C'); 
	  $pdf->Cell(5,6,substr($nro_empresa,0,1),1,0,'C');
	  $pdf->Cell(5,6,substr($nro_empresa,2,1),1,0,'C');
	  $pdf->Cell(5,6,substr($nro_empresa,2,1),1,0,'C');
	  $pdf->Cell(5,6,substr($nro_empresa,3,1),1,0,'C');
	  $pdf->Cell(5,6,substr($nro_empresa,4,1),1,0,'C');
	  $pdf->Cell(5,6,substr($nro_empresa,5,1),1,0,'C');
	  $pdf->Cell(5,6,substr($nro_empresa,6,1),1,0,'C');
	  $pdf->Cell(5,6,substr($nro_empresa,7,1),1,0,'C');
	  $pdf->Cell(5,6,substr($nro_empresa,8,1),1,1,'C');
	  $pdf->Ln(2);
	  
	  $pdf->SetFont('Arial','',6);
	  $pdf->Cell(155,4,'3. APELLIDOS Y NOMBRES DEL TRABAJADOR',1,0,'C'); 
	  $pdf->Cell(45,4,'4. NUMERO DE ASEGURADO',1,1,'C');
	  $pdf->SetFont('Arial','',7); 
	  $pdf->Cell(155,5,$nombre,'BRL',0,'C');
      $pdf->Cell(45,5,$num_aseg,'BRL',1,'C');
      $pdf->Ln(2);
	  
	  $pdf->SetFont('Arial','',6);
	  $pdf->Cell(30,3,'5. FECHA DE INGRESO',1,0,'C');
	  $pdf->Cell(25,3,'6. SALARIO SEMANAL',1,0,'C');
	  $pdf->Cell(90,3,'7. OCUPACION U OFICIO',1,0,'C');
	  $pdf->Cell(15,3,'8. COD OCUP.',1,0,'C');	  
	  $pdf->Cell(30,3,'9. FECHA RETIRO',1,0,'C');
      $pdf->Cell(10,3,'COD',1,1,'C');
	  
	  $pdf->SetFont('Arial','',5);
	  $pdf->Cell(10,3,'DIA','RL',0,'C'); 
	  $pdf->Cell(10,3,'MES','RL',0,'C'); 
	  $pdf->Cell(10,3,'AÑO','RL',0,'C');
	  $pdf->Cell(25,3,'','RL',0,'C');
	  $pdf->Cell(90,3,'','RL',0,'C');
	  $pdf->Cell(15,3,'','RL',0,'C');
	  $pdf->Cell(10,3,'DIA','RL',0,'C'); 
	  $pdf->Cell(10,3,'MES','RL',0,'C'); 
	  $pdf->Cell(10,3,'AÑO','RL',0,'C');
	  $pdf->Cell(10,3,'','RL',1,'C');
	  
	  $pdf->SetFont('Arial','',7);
	  $pdf->Cell(10,5,$diai,'BRL',0,'C');
      $pdf->Cell(10,5,$mesi,'BRL',0,'C');
      $pdf->Cell(10,5,$anoi,'BRL',0,'C');
	  $pdf->Cell(25,5,$salario_sem,'BRL',0,'C');
	  $pdf->Cell(90,5,$ocupacion,'BRL',0,'C');
	  $pdf->Cell(15,5,$cod_ocupacion,'BRL',0,'C');	  
	  $pdf->Cell(10,5,$diar,'BRL',0,'C');
      $pdf->Cell(10,5,$mesr,'BRL',0,'C');
      $pdf->Cell(10,5,$anor,'BRL',0,'C');
	  $pdf->SetFont('Arial','B',10);
      $pdf->Cell(10,5,"13",'BRL',1,'C');
	  $pdf->SetFont('Arial','',7);	  
	  
	  $pdf->Ln(2);
	  $pdf->SetFont('Arial','',6);
	  $pdf->Cell(100,4,'10. CAUSA DEL RETIRO',1,1,'C');
      $pdf->SetFont('Arial','',7);	
	  $pdf->Cell(100,2,' ','RL',1,'C');	  
	  $pdf->Cell(39,4,'1. DESPIDO','L',0,'L');
	  $pdf->Cell(5,4,$cond_d,1,0,'L');
	  $pdf->Cell(7,3,'',0,0,'C');
	  $pdf->Cell(39,4,'4. PENSIONADO',0,0,'L');
	  $pdf->Cell(5,4,$cond_p,1,0,'L');
	  $pdf->Cell(5,4,'','R',1,'C');
	  
	  
	  $pdf->Cell(100,3,' ','RL',1,'C');	
	  
	  $pdf->Cell(39,4,'2. RENUNCIA','L',0,'L');
	  $pdf->Cell(5,4,$cond_r,1,0,'L');
	  $pdf->Cell(7,4,'',0,0,'C');
	  $pdf->Cell(39,4,'5. TRASLADO A OTRA ',0,0,'L');
	  $pdf->Cell(5,4,$cond_t,1,0,'L');
	  $pdf->Cell(5,4,'','R',1,'C');
	  
	  
	  $pdf->Cell(39,2,'','L',0,'L');
	  $pdf->Cell(5,2,'',0,0,'L');
	  $pdf->Cell(7,2,'',0,0,'C');
	  $pdf->Cell(39,2,'EMPRESA ',0,0,'L');
	  $pdf->Cell(5,2,'',0,0,'L');
	  $pdf->Cell(5,2,'','R',1,'C');
	  
	  $pdf->Cell(100,2,' ','RL',1,'C');	
	  
	  $pdf->Cell(39,4,'3. JUBILADO','L',0,'L');
	  $pdf->Cell(5,4,$cond_j,1,0,'L');
	  $pdf->Cell(7,4,'',0,0,'C');
	  $pdf->Cell(39,4,'6. FALLECIMIENTO ',0,0,'L');
	  $pdf->Cell(5,4,$cond_j,1,0,'L');
	  $pdf->Cell(5,4,'','R',1,'C');
	  
	  $pdf->Cell(100,3,' ','BRL',0,'C');
	  $pdf->Cell(10,3,'',0,0,'C');
	  $pdf->Cell(70,3,'SELLO DE LA EMPRESA Y FIRMA DEL PATRONO','T',1,'C');
	  	  
	  $pdf->Ln(2);
	  
	  $pdf->SetFont('Arial','B',7);
	  $pdf->Cell(110,5,'20. RECIBIDO EN EL IVSS',1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'C');
	  $pdf->Cell(80,5,'21. ACTA DE FISCALIZACION',1,1,'C');
	  $pdf->SetFont('Arial','',7);
	  
	  $pdf->Cell(80,5,'','LR',0,'C');
	  $pdf->Cell(30,5,'FECHA',1,0,'C');
	  $pdf->Cell(10,5,'',0,0,'C');
	  $pdf->Cell(15,5,'SIGLA',1,0,'C');
	  $pdf->Cell(15,5,'AÑO',1,0,'C');
	  $pdf->Cell(20,5,'NUMERO',1,0,'C');
	  $pdf->Cell(30,5,'FECHA',1,1,'C');
	  
	  $pdf->Cell(80,3,'','LR',0,'C');
	  $pdf->Cell(10,3,'D','LR',0,'C');
	  $pdf->Cell(10,3,'M','LR',0,'C');
	  $pdf->Cell(10,3,'A','LR',0,'C');
	  $pdf->Cell(10,3,'',0,0,'C');	  
	  $pdf->Cell(15,3,'','LR',0,'C');
	  $pdf->Cell(15,3,'','LR',0,'C');
	  $pdf->Cell(20,3,'','LR',0,'C');
	  $pdf->Cell(10,3,'D','LR',0,'C');
	  $pdf->Cell(10,3,'M','LR',0,'C');
	  $pdf->Cell(10,3,'A','LR',1,'C');
	  
	  $pdf->Cell(80,15,'','LR',0,'C');
	  $pdf->Cell(10,15,'','LR',0,'C');
	  $pdf->Cell(10,15,'','LR',0,'C');
	  $pdf->Cell(10,15,'','LR',0,'C');
	  $pdf->Cell(10,15,'',0,0,'C');
	  $pdf->Cell(15,15,'','LR',0,'C');
	  $pdf->Cell(15,15,'','LR',0,'C');
	  $pdf->Cell(20,15,'','LR',0,'C');
	  $pdf->Cell(10,15,'','LR',0,'C');
	  $pdf->Cell(10,15,'','LR',0,'C');
	  $pdf->Cell(10,15,'','LR',1,'C');
	  
	  
	  $pdf->Cell(80,3,'FIRMA Y SELLO','BLR',0,'C');
	  $pdf->Cell(10,3,'','BLR',0,'C');
	  $pdf->Cell(10,3,'','BLR',0,'C');
	  $pdf->Cell(10,3,'','BLR',0,'C');
	  $pdf->Cell(10,3,'',0,0,'C');	  
	  $pdf->Cell(15,3,'','BLR',0,'C');
	  $pdf->Cell(15,3,'','BLR',0,'C');
	  $pdf->Cell(20,3,'','BLR',0,'C');
	  $pdf->Cell(10,3,'','BLR',0,'C');
	  $pdf->Cell(10,3,'','BLR',0,'C');
	  $pdf->Cell(10,3,'','BLR',1,'C');
	  $pdf->SetFont('Arial','',5);
	  $pdf->Cell(180,3,'DOS/06.200',0,1,'R');
	  $pdf->SetFont('Arial','',7);
	  
	  $pdf->Cell(200,4,'Este Formulario está autorizado por el IVSS y válido únicamente para ser consignado en las oficinas administrativas',0,1,'C');
	  
			$pdf->Cell(200,4,'EL FORMULARIO Y SU TRAMITACION SON COMPLETAMENTE GRATUITOS',0,1,'C');
			$pdf->Cell(200,4,'www.ivss.gov.ve',0,1,'C');
	  
     $pdf->Output();  
}
?>
