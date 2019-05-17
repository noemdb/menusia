<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$periodod=$_GET["periodod"]; $tipo_rep=$_GET["tipo_rep"];  $imprimir=$_GET["imprimir"]; $Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{ $Nom_Emp=busca_conf();  $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
$cfecha=formato_ddmmaaaa($Fec_Ini_Ejer); $cfecha="01/".$periodod."/".substr($cfecha,6,4);  $fecha_d=$cfecha; $fecha_h=colocar_udiames($cfecha); $criterio1=$fecha_h;
if($fecha_d==""){$sfecha_d="2010-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);} if($fecha_h==""){$sfecha_h="2010-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
      $sql_libro=" ban002.s_inic_libro as s_libro"; $sql_banco="ban002.s_inic_banco as s_banco";
      if ($periodod=='01'){$sql_libro=" ban002.s_inic_libro+(ban002.deb_libro01-ban002.cre_libro01) as s_libro"; $sql_banco="ban002.s_inic_banco+(ban002.deb_banco01- ban002.cre_banco01) as s_banco";}
      if ($periodod=='02'){$sql_libro=" ban002.s_inic_libro+(ban002.deb_libro01-ban002.cre_libro01)+(ban002.deb_libro02-ban002.cre_libro02) as s_libro"; $sql_banco="ban002.s_inic_banco+(ban002.deb_banco01-ban002.cre_banco01)+(ban002.deb_banco02-ban002.cre_banco02) as s_banco";}
      if ($periodod=='03'){$sql_libro=" ban002.s_inic_libro+(ban002.deb_libro01-ban002.cre_libro01)+(ban002.deb_libro02-ban002.cre_libro02)+(ban002.deb_libro03-ban002.cre_libro03) as s_libro"; $sql_banco="ban002.s_inic_banco+(ban002.deb_banco01-ban002.cre_banco01)+(ban002.deb_banco02-ban002.cre_banco02)+(ban002.deb_banco03-ban002.cre_banco03) as s_banco";}
      if ($periodod=='04'){$sql_libro=" ban002.s_inic_libro+(ban002.deb_libro01-ban002.cre_libro01)+(ban002.deb_libro02-ban002.cre_libro02)+(ban002.deb_libro03-ban002.cre_libro03)+(ban002.deb_libro04-ban002.cre_libro04) as s_libro"; $sql_banco="ban002.s_inic_banco+(ban002.deb_banco01-ban002.cre_banco01)+(ban002.deb_banco02-ban002.cre_banco02)+(ban002.deb_banco03-ban002.cre_banco03)+(ban002.deb_banco04-ban002.cre_banco04) as s_banco";}
      if ($periodod=='05'){$sql_libro=" ban002.s_inic_libro+(ban002.deb_libro01-ban002.cre_libro01)+(ban002.deb_libro02-ban002.cre_libro02)+(ban002.deb_libro03-ban002.cre_libro03)+(ban002.deb_libro04-ban002.cre_libro04)+(ban002.deb_libro05-ban002.cre_libro05) as s_libro"; $sql_banco="ban002.s_inic_banco+(ban002.deb_banco01-ban002.cre_banco01)+(ban002.deb_banco02-ban002.cre_banco02)+(ban002.deb_banco03-ban002.cre_banco03)+(ban002.deb_banco04-ban002.cre_banco04)+(ban002.deb_banco05-ban002.cre_banco05) as s_banco";}
      if ($periodod=='06'){$sql_libro=" ban002.s_inic_libro+(ban002.deb_libro01-ban002.cre_libro01)+(ban002.deb_libro02-ban002.cre_libro02)+(ban002.deb_libro03-ban002.cre_libro03)+(ban002.deb_libro04-ban002.cre_libro04)+(ban002.deb_libro05-ban002.cre_libro05)+(ban002.deb_libro06-ban002.cre_libro06) as s_libro"; $sql_banco="ban002.s_inic_banco+(ban002.deb_banco01-ban002.cre_banco01)+(ban002.deb_banco02-ban002.cre_banco02)+(ban002.deb_banco03-ban002.cre_banco03)+(ban002.deb_banco04-ban002.cre_banco04)+(ban002.deb_banco05-ban002.cre_banco05)+(ban002.deb_banco06-ban002.cre_banco06) as s_banco";}
      if ($periodod=='07'){$sql_libro=" ban002.s_inic_libro+(ban002.deb_libro01-ban002.cre_libro01)+(ban002.deb_libro02-ban002.cre_libro02)+(ban002.deb_libro03-ban002.cre_libro03)+(ban002.deb_libro04-ban002.cre_libro04)+(ban002.deb_libro05-ban002.cre_libro05)+(ban002.deb_libro06-ban002.cre_libro06)+(ban002.deb_libro07-ban002.cre_libro07) as s_libro"; 
	                     $sql_banco=" ban002.s_inic_banco+(ban002.deb_banco01-ban002.cre_banco01)+(ban002.deb_banco02-ban002.cre_banco02)+(ban002.deb_banco03-ban002.cre_banco03)+(ban002.deb_banco04-ban002.cre_banco04)+(ban002.deb_banco05-ban002.cre_banco05)+(ban002.deb_banco06-ban002.cre_banco06)+(ban002.deb_banco07-ban002.cre_banco07) as s_banco";}

      if ($periodod=='08'){$sql_libro=" ban002.s_inic_libro+(ban002.deb_libro01-ban002.cre_libro01)+(ban002.deb_libro02-ban002.cre_libro02)+(ban002.deb_libro03-ban002.cre_libro03)+(ban002.deb_libro04-ban002.cre_libro04)+(ban002.deb_libro05-ban002.cre_libro05)+(ban002.deb_libro06-ban002.cre_libro06)+(ban002.deb_libro07-ban002.cre_libro07)+(ban002.deb_libro08-ban002.cre_libro08) as s_libro"; 
	                     $sql_banco=" ban002.s_inic_banco+(ban002.deb_banco01-ban002.cre_banco01)+(ban002.deb_banco02-ban002.cre_banco02)+(ban002.deb_banco03-ban002.cre_banco03)+(ban002.deb_banco04-ban002.cre_banco04)+(ban002.deb_banco05-ban002.cre_banco05)+(ban002.deb_banco06-ban002.cre_banco06)+(ban002.deb_banco07-ban002.cre_banco07)+(ban002.deb_banco08-ban002.cre_banco08) as s_banco";}
						 
      if ($periodod=='09'){$sql_libro=" ban002.s_inic_libro+(ban002.deb_libro01-ban002.cre_libro01)+(ban002.deb_libro02-ban002.cre_libro02)+(ban002.deb_libro03-ban002.cre_libro03)+(ban002.deb_libro04-ban002.cre_libro04)+(ban002.deb_libro05-ban002.cre_libro05)+(ban002.deb_libro06-ban002.cre_libro06)+(ban002.deb_libro07-ban002.cre_libro07)+(ban002.deb_libro08-ban002.cre_libro08)+(ban002.deb_libro09-ban002.cre_libro09) as s_libro"; 
	                     $sql_banco=" ban002.s_inic_banco+(ban002.deb_banco01-ban002.cre_banco01)+(ban002.deb_banco02-ban002.cre_banco02)+(ban002.deb_banco03-ban002.cre_banco03)+(ban002.deb_banco04-ban002.cre_banco04)+(ban002.deb_banco05-ban002.cre_banco05)+(ban002.deb_banco06-ban002.cre_banco06)+(ban002.deb_banco07-ban002.cre_banco07)+(ban002.deb_banco08-ban002.cre_banco08)+(ban002.deb_banco09-ban002.cre_banco09) as s_banco";}
						 
	  if ($periodod=='10'){$sql_libro=" ban002.s_inic_libro+(ban002.deb_libro01-ban002.cre_libro01)+(ban002.deb_libro02-ban002.cre_libro02)+(ban002.deb_libro03-ban002.cre_libro03)+(ban002.deb_libro04-ban002.cre_libro04)+(ban002.deb_libro05-ban002.cre_libro05)+(ban002.deb_libro06-ban002.cre_libro06)+(ban002.deb_libro07-ban002.cre_libro07)+(ban002.deb_libro08-ban002.cre_libro08)+(ban002.deb_libro09-ban002.cre_libro09)+(ban002.deb_libro10-ban002.cre_libro10) as s_libro"; 
	                     $sql_banco=" ban002.s_inic_banco+(ban002.deb_banco01-ban002.cre_banco01)+(ban002.deb_banco02-ban002.cre_banco02)+(ban002.deb_banco03-ban002.cre_banco03)+(ban002.deb_banco04-ban002.cre_banco04)+(ban002.deb_banco05-ban002.cre_banco05)+(ban002.deb_banco06-ban002.cre_banco06)+(ban002.deb_banco07-ban002.cre_banco07)+(ban002.deb_banco08-ban002.cre_banco08)+(ban002.deb_banco09-ban002.cre_banco09)+(ban002.deb_banco10-ban002.cre_banco10) as s_banco";}
		
	  if ($periodod=='11'){$sql_libro=" ban002.s_inic_libro+(ban002.deb_libro01-ban002.cre_libro01)+(ban002.deb_libro02-ban002.cre_libro02)+(ban002.deb_libro03-ban002.cre_libro03)+(ban002.deb_libro04-ban002.cre_libro04)+(ban002.deb_libro05-ban002.cre_libro05)+(ban002.deb_libro06-ban002.cre_libro06)+(ban002.deb_libro07-ban002.cre_libro07)+(ban002.deb_libro08-ban002.cre_libro08)+(ban002.deb_libro09-ban002.cre_libro09)+(ban002.deb_libro10-ban002.cre_libro10)+(ban002.deb_libro11-ban002.cre_libro11) as s_libro"; 
	                     $sql_banco=" ban002.s_inic_banco+(ban002.deb_banco01-ban002.cre_banco01)+(ban002.deb_banco02-ban002.cre_banco02)+(ban002.deb_banco03-ban002.cre_banco03)+(ban002.deb_banco04-ban002.cre_banco04)+(ban002.deb_banco05-ban002.cre_banco05)+(ban002.deb_banco06-ban002.cre_banco06)+(ban002.deb_banco07-ban002.cre_banco07)+(ban002.deb_banco08-ban002.cre_banco08)+(ban002.deb_banco09-ban002.cre_banco09)+(ban002.deb_banco10-ban002.cre_banco10)+(ban002.deb_banco11-ban002.cre_banco11) as s_banco";}
		
	  if ($periodod=='12'){$sql_libro=" ban002.s_inic_libro+(ban002.deb_libro01-ban002.cre_libro01)+(ban002.deb_libro02-ban002.cre_libro02)+(ban002.deb_libro03-ban002.cre_libro03)+(ban002.deb_libro04-ban002.cre_libro04)+(ban002.deb_libro05-ban002.cre_libro05)+(ban002.deb_libro06-ban002.cre_libro06)+(ban002.deb_libro07-ban002.cre_libro07)+(ban002.deb_libro08-ban002.cre_libro08)+(ban002.deb_libro09-ban002.cre_libro09)+(ban002.deb_libro10-ban002.cre_libro10)+(ban002.deb_libro11-ban002.cre_libro11)+(ban002.deb_libro12-ban002.cre_libro12) as s_libro"; 
	                     $sql_banco=" ban002.s_inic_banco+(ban002.deb_banco01-ban002.cre_banco01)+(ban002.deb_banco02-ban002.cre_banco02)+(ban002.deb_banco03-ban002.cre_banco03)+(ban002.deb_banco04-ban002.cre_banco04)+(ban002.deb_banco05-ban002.cre_banco05)+(ban002.deb_banco06-ban002.cre_banco06)+(ban002.deb_banco07-ban002.cre_banco07)+(ban002.deb_banco08-ban002.cre_banco08)+(ban002.deb_banco09-ban002.cre_banco09)+(ban002.deb_banco10-ban002.cre_banco10)+(ban002.deb_banco11-ban002.cre_banco11)+(ban002.deb_banco12-ban002.cre_banco12) as s_banco";}
		
       // LLAMAR A PHP_REPORT
       $sSQL = "SELECT ban002.cod_banco, ban002.nombre_banco, ban002.nro_cuenta, ban002.tipo_cuenta, ban002.cod_contable,
                ban002.s_inic_libro, ban002.s_inic_banco, ban001.descripcion_tipo, ban002.tipo_bco, ban002.descripcion_banco, ".$sql_libro.", ".$sql_banco."
                FROM ban001, ban002  WHERE ban002.tipo_cuenta = ban001.tipo_cuenta and ban002.cod_banco>='".$cod_banco_d."' and ban002.cod_banco<='".$cod_banco_h."'  ORDER BY ban002.tipo_bco,ban002.cod_banco";
	if($tipo_rep=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php"); 
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Rel_Saldo_Bancario.xml");
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("localhost");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run();
             $aBench = $oRpt->getBenchmark();
             $iSec   = $aBench["report_end"]-$aBench["report_start"];
    }
	
	if($tipo_rep=="PDF"){	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){ global $tam_logo; global $criterio1; global $Nom_Emp;
			$this->Image('../../imagenes/Logo_emp.png',7,10,$tam_logo);
			$this->SetFont('Arial','B',12);
			$this->Cell(230,7,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,1,'C');			
			$this->Cell(230,5,$Nom_Emp,0,1,'C');
			$this->Cell(230,5,'RELACION DE SALDOS BANCARIOS',0,1,'C');
			$this->SetFont('Arial','B',8);
			$this->Cell(230,7,'FECHA AL: '.$criterio1,0,1,'C');	
			$this->Ln(5);
			$this->Cell(70,5,'NOMBRE BANCO',1,0);
			$this->Cell(35,5,'TIPO',1,0);
			$this->Cell(35,5,'NRO CUENTA',1,0,'L');
			$this->Cell(60,5,'DENOMINACION',1,0);
            $this->SetFont('Arial','B',7);			
			$this->Cell(20,5,'SALDO BANCO',1,0,'C');
			$this->Cell(20,5,'SALDO LIBRO',1,0,'C');
			$this->Cell(20,5,'DIFERENCIA',1,1,'C');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'SIA Control Bancario ',0,0,'L');
			$this->Cell(60,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $total1=0; $total2=0; $total3=0; $total4=0; $sub_total1=0; $sub_total2=0; $sub_total3=0; $sub_total4=0; $prev_tipo="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $tipo_cuenta=$registro["tipo_cuenta"]; 
		   $descripcion_tipo=$registro["descripcion_tipo"]; $descripcion_banco=$registro["descripcion_banco"]; $tipo_bco=$registro["tipo_bco"]; 
           $s_inic_libro=$registro["s_inic_libro"]; $s_inic_banco=$registro["s_inic_banco"]; $s_libro=$registro["s_libro"]; $s_banco=$registro["s_banco"];  
		   if($tipo_bco=="1"){$tipo_bco="GASTOS CORRIENTES";} if($tipo_bco=="2"){$tipo_bco="RECAUDACION";} if($tipo_bco=="3"){$tipo_bco="FONDOS DE TERCEROS";} if($tipo_bco=="4"){$tipo_bco="FIDEICOMISOS-FIDES";} if($tipo_bco=="5"){$tipo_bco="FIDEICOMISOS-LAEE";} if($tipo_bco=="6"){$tipo_bco="FIEM";} if($tipo_bco=="7"){$tipo_bco="OTROS FIDEICOMISOS";} if($tipo_bco=="8"){$tipo_bco="PENDIENTE POR CANCELAR";} if($tipo_bco=="9"){$tipo_bco="OTROS";} if($tipo_bco=="0"){$tipo_bco="";}
          
		   if($prev_tipo<>$tipo_bco){ $prev_tipo=$tipo_bco; $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2); $sub_total3=formato_monto($sub_total3); 
		     if($i>1){ $pdf->SetFont('Arial','B',7);
				$pdf->Cell(200,5,'SUB-TOTAL  ',1,0,'R');
				$pdf->Cell(20,5,$sub_total1,1,0,'R');
				$pdf->Cell(20,5,$sub_total2,1,0,'R');
				$pdf->Cell(20,5,$sub_total3,1,1,'R'); 
			 }
			$sub_total1=0; $sub_total2=0; $sub_total3=0; 
		   }
		   $diferencia=$s_banco-$s_libro; $sub_total1=$sub_total1+$s_libro;  $sub_total2=$total2+$s_banco;  $sub_total3=$sub_total3+$diferencia;
		   $total1=$total1+$s_libro;  $total2=$total2+$s_banco;  $total3=$total3+$diferencia;  $diferencia=formato_monto($diferencia);
           $continua=0;		   
		   if(($imprimir=='N')and($s_libro==0)and($s_banco==0)and($diferencia==0)){ $continua=1; }
		   if(($imprimir=='N')and($diferencia==0)){ $continua=1; }
		   if($continua==0){
			   $s_banco=formato_monto($s_banco); $s_inic_libro=formato_monto($s_inic_libro); $s_inic_banco=formato_monto($s_inic_banco); $s_libro=formato_monto($s_libro);
			   if($php_os=="WINNT"){$nombre_banco=$registro["nombre_banco"]; } else{$nombre_banco=utf8_decode($nombre_banco); $descripcion_banco=utf8_decode($descripcion_banco);}  
			   $descripcion_banco=substr($descripcion_banco,0,38);
			   $pdf->SetFont('Arial','',7);
			   $long=strlen($nombre_banco);
			  // if($long>44){ 
			 //    $x=$pdf->GetX();   $y=$pdf->GetY(); $n=70; 
			 //    $pdf->SetXY($x+$n,$y);
			  // } else{ 
			  $pdf->Cell(70,5,substr($nombre_banco,0,43),'L',0); 
			 // }
			 
			   $pdf->Cell(35,5,$tipo_bco,0,0); 
			   $pdf->Cell(35,5,$nro_cuenta,0,0); 		   
			   $pdf->Cell(60,5,$descripcion_banco,0,0); 
			   $pdf->Cell(20,5,$s_libro,0,0,'R');
			   $pdf->Cell(20,5,$s_banco,0,0,'R');
			   $pdf->Cell(20,5,$diferencia,'R',1,'R');
			   //if($long>44){
			   //  $pdf->SetXY($x,$y);
			   //  $pdf->MultiCell($n,5,$nombre_banco,'L');
			   //}
           }		   
		} $total1=formato_monto($total1); $total2=formato_monto($total2); $total3=formato_monto($total3); $total4=formato_monto($total4); 
		$pdf->SetFont('Arial','B',7);
		$pdf->Cell(200,5,'SUB-TOTAL  ',1,0,'R');
		$pdf->Cell(20,5,$sub_total1,1,0,'R');
		$pdf->Cell(20,5,$sub_total2,1,0,'R');
		$pdf->Cell(20,5,$sub_total3,1,1,'R');
		$pdf->Cell(200,5,'TOTAL GENERAL ',1,0,'R');
		$pdf->Cell(20,5,$total1,1,0,'R');
		$pdf->Cell(20,5,$total2,1,0,'R');
		$pdf->Cell(20,5,$total3,1,1,'R'); 		 
		$pdf->Output();   
    }
	
}
?>

