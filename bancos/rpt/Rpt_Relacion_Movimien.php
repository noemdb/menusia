<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$tipo_mov_d=$_GET["tipo_mov_d"];$periodod=$_GET["periodod"]; $periodoh=$_GET["periodoh"]; $encab_reporte=$_GET["encab_reporte"];
$tipo_rep=$_GET["tipo_rep"]; $Sql=""; $criterio1="";  $date = date("d-m-Y");$hora = date("h:i:s a");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{ $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
    $mano=substr($Fec_Fin_Ejer,0,4);   $fecha_desde="01/".$periodod."/".$mano; $fecha_hasta="01/".$periodoh."/".$mano; 	
	$fecha_desde=colocar_pdiames($fecha_desde); $fecha_hasta=colocar_udiames($fecha_hasta); 
    if($fecha_desde==""){$fecha_d="2011-01-01";}else{$fecha_d=formato_aaaammdd($fecha_desde);}
    if($fecha_hasta==""){$fecha_h="9999-12-31";}else{$fecha_h=formato_aaaammdd($fecha_hasta);}
    $criterio1=$encab_reporte;
	$criterio2="Fecha Desde: ".$fecha_desde." Hasta: ".$fecha_hasta;  
    $cod_mov="BAN004M".$usuario_sia;
	$StrSQL = "DELETE FROM BAN036 Where (codigo_mov='".$cod_mov."')"; $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
	$res=pg_exec($conn,"SELECT INC_MOV_BAN036('$cod_mov','$cod_banco_d','$cod_banco_h','$fecha_d','$fecha_h','$tipo_mov_d')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

	
    $sSQL = "SELECT BAN002.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN002.Tipo_Cuenta, BAN002.Cod_Contable, BAN001.Descripcion_Tipo, BAN002.Tipo_Bco, BAN002.Descripcion_Banco, 
	   BAN036.Monto_Cheque,BAN036.total_causado, BAN036.total_retencion, BAN036.total_ajuste, BAN036.total_pasivos, BAN036.monto_ret1, BAN036.monto_ret2, BAN036.monto_ret3, BAN036.monto_ret4, 
	   BAN036.monto_ret5,BAN036.monto_ret6, BAN036.monto_ret7, BAN036.monto_ret8, BAN036.monto_ret9,BAN036.campo_num1,BAN036.campo_num2 	
       FROM BAN036, BAN002, BAN001 WHERE BAN001.Tipo_Cuenta = BAN002.Tipo_Cuenta AND BAN002.Cod_Banco = BAN036.Cod_Banco and BAN036.codigo_mov='".$cod_mov."' and BAN002.Cod_Banco>='".$cod_banco_d."' AND BAN002.Cod_Banco<='".$cod_banco_h."' ORDER BY BAN002.Cod_Banco";

    if($tipo_rep=="HTML"){	  include ("../../class/phpreports/PHPReportMaker.php");
	         $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Relacion_Movimientos.xml");
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run(); 
		}
    if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $tipo_bco_grupo="";	$fin=0;
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $tam_logo;  global $criterio1; global $criterio2;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
			    $this->Cell(30);
				$this->Cell(200,10,$criterio1,0,0,'C');
				$this->SetFont('Arial','B',10);
				$this->Ln(10);
				$this->Cell(260,10,$criterio2,0,0,'C');
				$this->Ln(10);
            	$this->SetFont('Arial','B',8);				
				$y=$this->GetY();$x=$this->GetX();				
				$this->rect(10,30,260.2,167.1);				
				$this->Cell(64,5,'BANCO ',1,0,'L');
            	$this->SetFont('Arial','B',6);
				$this->Cell(15,5,'ENERO',1,0,'C');
				$this->Cell(15,5,'FEBRERO',1,0,'C');
				$this->Cell(15,5,'MARZO',1,0,'C');
				$this->Cell(15,5,'ABRIL',1,0,'C');
				$this->Cell(15,5,'MAYO',1,0,'C');
				$this->Cell(15,5,'JUNIO',1,0,'C');
				$this->Cell(15,5,'JULIO',1,0,'C');
				$this->Cell(15,5,'AGOSTO',1,0,'C');
				$this->Cell(15,5,'SEPTIEMBRE',1,0,'C');
				$this->Cell(15,5,'OCTUBRE',1,0,'C');
				$this->Cell(15,5,'NOVIEMBRE',1,0,'C');
				$this->Cell(15,5,'DICIEMBRE',1,0,'C');
				$this->Cell(16,5,'TOTAL',1,1,'C');
				$y=$this->GetY();$x=$this->GetX();	
				$this->Line(74,$y-0.1,74,197); 
				$this->Line(89,$y-0.1,89,197);
				$this->Line(104,$y-0.1,104,197);
				$this->Line(119,$y-0.1,119,197);
				$this->Line(134,$y-0.1,134,197);
				$this->Line(149,$y-0.1,149,197);
				$this->Line(164,$y-0.1,164,197);
				$this->Line(179,$y-0.1,179,197);
				$this->Line(194,$y-0.1,194,197);
				$this->Line(209,$y-0.1,209,197);
				$this->Line(224,$y-0.1,224,197);
				$this->Line(239,$y-0.1,239,197);
				$this->Line(254,$y-0.1,254,197);
			}
			function Footer(){ global $total1; global $total2; global $total3; global $total4; global $total5; global $total6;
			    global $total7; global $total8; global $total9; global $total10; global $total11; global $total12; global $totalG;   
				global $fin;
			    $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-19);
				$total1=formato_monto($total1);
				$total2=formato_monto($total2);
				$total3=formato_monto($total3);
				$total4=formato_monto($total4);
				$total5=formato_monto($total5);
				$total6=formato_monto($total6);
				$total7=formato_monto($total7);
				$total8=formato_monto($total8);
				$total9=formato_monto($total9);
				$total10=formato_monto($total10);
				$total11=formato_monto($total11);
				$total12=formato_monto($total12);
				$totalG=formato_monto($totalG);
				
				$this->SetFont('Arial','B',8);
				if($fin==1){
				$this->Cell(64,5,'TOTAL GENERAL : ',1,0,'R');
				$this->SetFont('Arial','B',6);
				$this->Cell(15,5,$total1,1,0,'R'); 
				$this->Cell(15,5,$total2,1,0,'R'); 
				$this->Cell(15,5,$total3,1,0,'R'); 
				$this->Cell(15,5,$total4,1,0,'R'); 
				$this->Cell(15,5,$total5,1,0,'R'); 
				$this->Cell(15,5,$total6,1,0,'R'); 
				$this->Cell(15,5,$total7,1,0,'R'); 
				$this->Cell(15,5,$total8,1,0,'R'); 
				$this->Cell(15,5,$total9,1,0,'R'); 
				$this->Cell(15,5,$total10,1,0,'R'); 
				$this->Cell(15,5,$total11,1,0,'R'); 
				$this->Cell(15,5,$total12,1,0,'R'); 
				$this->Cell(16,5,$totalG,1,1,'R'); 
		        }else{ $this->Cell(64,5,' ',0,1,'R');}
				$this->Ln(3);
				$this->SetFont('Arial','I',5);
				$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
				$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			}
		  }		  
		  $pdf=new PDF('L', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetAutoPageBreak(true, 18);
		  $pdf->SetFont('Arial','',7); 
		  $i=0;  $total1=0; $total2=0; $total3=0; $total4=0; $total5=0; $total6=0; $total7=0; $total8=0;  $total9=0; $total10=0;  $total11=0; $total12=0; $totalG=0;
		  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_banco=$registro["cod_banco"]; 	$nombre_banco=$registro["nombre_banco"];  
			  $descripcion_tipo=$registro["descripcion_tipo"];   $nro_cuenta=$registro["nro_cuenta"]; 	 $descripcion_banco=$registro["descripcion_banco"]; 
			  if($php_os=="WINNT"){$nombre_banco=$registro["nombre_banco"]; }else{$nombre_banco=utf8_decode($nombre_banco);}
              if($php_os=="WINNT"){$descripcion_banco=$registro["descripcion_banco"]; }else{$descripcion_banco=utf8_decode($descripcion_banco);}                  
			  $monto_ret1=$registro["monto_ret1"]; $sub_total1=formato_monto($monto_ret1);
			  $monto_ret2=$registro["monto_ret2"]; $sub_total2=formato_monto($monto_ret2);
			  $monto_ret3=$registro["monto_ret3"]; $sub_total3=formato_monto($monto_ret3);
			  $monto_ret4=$registro["monto_ret4"]; $sub_total4=formato_monto($monto_ret4);
			  $monto_ret5=$registro["monto_ret5"]; $sub_total5=formato_monto($monto_ret5);
			  $monto_ret6=$registro["monto_ret6"]; $sub_total6=formato_monto($monto_ret6);
			  $monto_ret7=$registro["monto_ret7"]; $sub_total7=formato_monto($monto_ret7);
			  $monto_ret8=$registro["monto_ret8"]; $sub_total8=formato_monto($monto_ret8);
			  $monto_ret9=$registro["monto_ret9"]; $sub_total9=formato_monto($monto_ret9);				  
			  $monto_cheque=$registro["monto_cheque"]; $sub_total10=formato_monto($monto_cheque);
			  $campo_num1=$registro["campo_num1"]; $sub_total11=formato_monto($campo_num1);
			  $campo_num12=$registro["campo_num12"]; $sub_total12=formato_monto($campo_num12);
			  $total_causado=$registro["total_causado"]; $sub_totalG=formato_monto($total_causado);			  
              $total1=$total1+$monto_ret1;
              $total2=$total2+$monto_ret2;
			  $total3=$total3+$monto_ret3;
			  $total4=$total4+$monto_ret4;
              $total5=$total5+$monto_ret5;
			  $total6=$total6+$monto_ret6;
              $total7=$total7+$monto_ret7;
              $total8=$total8+$monto_ret8;
			  $total9=$total9+$monto_ret9;
              $total10=$total10+$monto_cheque;
              $total11=$total11+$campo_num1;
			  $total12=$total12+$campo_num2;
              $totalG=$totalG+$total_causado;  
				
				$x=$pdf->GetX();   $y=$pdf->GetY(); $n=64; 					   
				$pdf->SetXY($x+$n,$y);
				$pdf->SetFont('Arial','',6); 
				$pdf->Cell(15,3,$sub_total1,'T',0,'R');
				$pdf->Cell(15,3,$sub_total2,'T',0,'R');
				$pdf->Cell(15,3,$sub_total3,'T',0,'R');
				$pdf->Cell(15,3,$sub_total4,'T',0,'R');
				$pdf->Cell(15,3,$sub_total5,'T',0,'R');
				$pdf->Cell(15,3,$sub_total6,'T',0,'R');
				$pdf->Cell(15,3,$sub_total7,'T',0,'R');
				$pdf->Cell(15,3,$sub_total8,'T',0,'R');
				$pdf->Cell(15,3,$sub_total9,'T',0,'R');
				$pdf->Cell(15,3,$sub_total10,'T',0,'R');
				$pdf->Cell(15,3,$sub_total11,'T',0,'R');
				$pdf->Cell(15,3,$sub_total12,'T',0,'R');
				$pdf->Cell(16,3,$sub_totalG,'T',1,'R'); 
                $pdf->SetFont('Arial','',7);  				
				$pdf->SetXY($x,$y);
				$pdf->MultiCell($n,3,$nombre_banco,'T');     
				$x=$pdf->GetX();   $y=$pdf->GetY(); $n=64; 					   
				//$pdf->SetXY($x+$n,$y);
				$pdf->Cell(64,3,$descripcion_tipo,0,0,'L');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(16,3,'',0,1,'R'); 				
				
				
 				$x=$pdf->GetX();   $y=$pdf->GetY(); $n=64; 					   
				//$pdf->SetXY($x+$n,$y);
				$pdf->Cell(64,3,$nro_cuenta,0,0,'L');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(15,3,'',0,0,'R');
				$pdf->Cell(16,3,'',0,1,'R'); 	 				
				
			    $x=$pdf->GetX();   $y=$pdf->GetY(); $n=64; 					   
				//$pdf->SetXY($x+$n,$y);
				$pdf->Cell(64,3,$descripcion_banco,'B',0,'L');
				$pdf->Cell(15,3,'','B',0,'R');
				$pdf->Cell(15,3,'','B',0,'R');
				$pdf->Cell(15,3,'','B',0,'R');
				$pdf->Cell(15,3,'','B',0,'R');
				$pdf->Cell(15,3,'','B',0,'R');
				$pdf->Cell(15,3,'','B',0,'R');
				$pdf->Cell(15,3,'','B',0,'R');
				$pdf->Cell(15,3,'','B',0,'R');
				$pdf->Cell(15,3,'','B',0,'R');
				$pdf->Cell(15,3,'','B',0,'R');
				$pdf->Cell(15,3,'','B',0,'R');
				$pdf->Cell(15,3,'','B',0,'R');
				$pdf->Cell(16,3,'','B',1,'R'); 				
				//$pdf->SetXY($x,$y);
				//$pdf->SetFont('Arial','',7); 
				//$pdf->MultiCell($n,3,$descripcion_banco,0);	
		} 
		$fin=1;
		$pdf->Output();    
	}
	if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Relacion_Movimientos.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio1; ?></strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="400" align="center" > <font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio2; ?></strong></font></td>
			 </tr>
			 <tr height="20">
			 </tr>
			 <tr height="20">
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>BANCO</strong></td>
			   <td width="100" align="center" bgcolor="#99CCFF"><strong>ENERO</strong></td>
			   <td width="100" align="center" bgcolor="#99CCFF"><strong>FEBRERO</strong></td>
			   <td width="100" align="center" bgcolor="#99CCFF"><strong>MARZO</strong></td>
			   <td width="100" align="center" bgcolor="#99CCFF"><strong>ABRIL</strong></td>
			   <td width="100" align="center" bgcolor="#99CCFF"><strong>MAYO</strong></td>
			   <td width="100" align="center" bgcolor="#99CCFF"><strong>JUNIO</strong></td>
			   <td width="100" align="center" bgcolor="#99CCFF"><strong>JULIO</strong></td>
			   <td width="100" align="center" bgcolor="#99CCFF"><strong>AGOSTO</strong></td>
			   <td width="100" align="center" bgcolor="#99CCFF"><strong>SEPTIEMBRE</strong></td>
			   <td width="100" align="center" bgcolor="#99CCFF"><strong>OCTUBRE</strong></td>
			   <td width="100" align="center" bgcolor="#99CCFF"><strong>NOVIEMBRE</strong></td>
			   <td width="100" align="center" bgcolor="#99CCFF"><strong>DICIEMBRE</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>TOTAL</strong></td>
			 </tr>
		  <?  $i=0;  $total1=0; $total2=0; $total3=0; $total4=0; $total5=0; $total6=0; $total7=0; $total8=0;  $total9=0; $total10=0;  $total11=0; $total12=0; $totalG=0;
		  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_banco=$registro["cod_banco"]; 	$nombre_banco=$registro["nombre_banco"];  
			  $descripcion_tipo=$registro["descripcion_tipo"];   $nro_cuenta=$registro["nro_cuenta"]; 	 $descripcion_banco=$registro["descripcion_banco"]; 
			  $monto_ret1=$registro["monto_ret1"]; $sub_total1=formato_monto($monto_ret1);
			  $monto_ret2=$registro["monto_ret2"]; $sub_total2=formato_monto($monto_ret2);
			  $monto_ret3=$registro["monto_ret3"]; $sub_total3=formato_monto($monto_ret3);
			  $monto_ret4=$registro["monto_ret4"]; $sub_total4=formato_monto($monto_ret4);
			  $monto_ret5=$registro["monto_ret5"]; $sub_total5=formato_monto($monto_ret5);
			  $monto_ret6=$registro["monto_ret6"]; $sub_total6=formato_monto($monto_ret6);
			  $monto_ret7=$registro["monto_ret7"]; $sub_total7=formato_monto($monto_ret7);
			  $monto_ret8=$registro["monto_ret8"]; $sub_total8=formato_monto($monto_ret8);
			  $monto_ret9=$registro["monto_ret9"]; $sub_total9=formato_monto($monto_ret9);				  
			  $monto_cheque=$registro["monto_cheque"]; $sub_total10=formato_monto($monto_cheque);
			  $campo_num1=$registro["campo_num1"]; $sub_total11=formato_monto($campo_num1);
			  $campo_num12=$registro["campo_num12"]; $sub_total12=formato_monto($campo_num12);
			  $total_causado=$registro["total_causado"]; $sub_totalG=formato_monto($total_causado);			  
              $total1=$total1+$monto_ret1;
              $total2=$total2+$monto_ret2;
			  $total3=$total3+$monto_ret3;
			  $total4=$total4+$monto_ret4;
              $total5=$total5+$monto_ret5;
			  $total6=$total6+$monto_ret6;
              $total7=$total7+$monto_ret7;
              $total8=$total8+$monto_ret8;
			  $total9=$total9+$monto_ret9;
              $total10=$total10+$monto_cheque;
              $total11=$total11+$campo_num1;
			  $total12=$total12+$campo_num2;
              $totalG=$totalG+$total_causado;  
              ?>	 				 	
				<tr>
				  <td width="400" align="left"><? echo $nombre_banco; ?></td>
				  <td width="100" align="right"><? echo $sub_total1; ?></td>
				  <td width="100" align="right"><? echo $sub_total2; ?></td>
				  <td width="100" align="right"><? echo $sub_total3; ?></td>
				  <td width="100" align="right"><? echo $sub_total4; ?></td>
				  <td width="100" align="right"><? echo $sub_total5; ?></td>
				  <td width="100" align="right"><? echo $sub_total6; ?></td>
				  <td width="100" align="right"><? echo $sub_total7; ?></td>
				  <td width="100" align="right"><? echo $sub_total8; ?></td>
				  <td width="100" align="right"><? echo $sub_total9; ?></td>
				  <td width="100" align="right"><? echo $sub_total10; ?></td>
				  <td width="100" align="right"><? echo $sub_total11; ?></td>
				  <td width="100" align="right"><? echo $sub_total12; ?></td>
				  <td width="100" align="right"><? echo $sub_totalG; ?></td>
				</tr>
				<tr>
				  <td width="400" align="left"><? echo $descripcion_tipo; ?></td>
				</tr>
				<tr>
				  <td width="400" align="left"><? echo "'".$nro_cuenta; ?></td>
				</tr>
				<tr>
				  <td width="400" align="left"><? echo $descripcion_banco; ?></td>
				</tr>	
				    
           <?} $total1=formato_monto($total1);
				$total2=formato_monto($total2);
				$total3=formato_monto($total3);
				$total4=formato_monto($total4);
				$total5=formato_monto($total5);
				$total6=formato_monto($total6);
				$total7=formato_monto($total7);
				$total8=formato_monto($total8);
				$total9=formato_monto($total9);
				$total10=formato_monto($total10);
				$total11=formato_monto($total11);
				$total12=formato_monto($total12);
				$totalG=formato_monto($totalG)
		   ?>	
			<tr>
			  <td width="400" align="right"><strong>TOTAL GENERAL:</strong></td>
			  <td width="100" align="right"><strong><? echo $total1; ?></strong></td>
			  <td width="100" align="right"><strong><? echo $total2; ?></strong></td>
			  <td width="100" align="right"><strong><? echo $total3; ?></strong></td>
			  <td width="100" align="right"><strong><? echo $total4; ?></strong></td>
			  <td width="100" align="right"><strong><? echo $total5; ?></strong></td>
			  <td width="100" align="right"><strong><? echo $total6; ?></strong></td>
			  <td width="100" align="right"><strong><? echo $total7; ?></strong></td>
			  <td width="100" align="right"><strong><? echo $total8; ?></strong></td>
			  <td width="100" align="right"><strong><? echo $total9; ?></strong></td>
			  <td width="100" align="right"><strong><? echo $total10; ?></strong></td>
			  <td width="100" align="right"><strong><? echo $total11; ?></strong></td>
			  <td width="100" align="right"><strong><? echo $total12; ?></strong></td>
			  <td width="100" align="right"><strong><? echo $totalG; ?></strong></td>
			</tr>	
				    
		</table><?
    }
}
?>
