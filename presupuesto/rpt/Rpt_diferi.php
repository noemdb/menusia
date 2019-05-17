<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$tipo_diferido_d=$_GET["tipo_diferido_d"];$tipo_diferido_h=$_GET["tipo_diferido_h"];$referencia_d=$_GET["referencia_d"];$referencia_h=$_GET["referencia_h"]; $tipo_rep=$_GET["tipo_rep"];
$cod_presupd=$_GET["cod_presupd"]; $cod_presuph=$_GET["cod_presuph"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$cod_fuente_d=$_GET["cod_fuente_d"]; $cod_fuente_h=$_GET["cod_fuente_h"];
$date = date("d-m-Y");$hora = date("H:i:s a");$Sql="";
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;
  $criterio1="Fecha Desde : ".$fecha_d."  "."Hasta : ".$fecha_h;   $criterio2="";
  $criterio3="Fuente de Financiamiento : ".$cod_fuente_d."    ".$cod_fuente_h;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else { $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}  $error=0;
	$sSQL = "SELECT pre023.Referencia_Dife, pre023.Tipo_Diferido, pre024.Nombre_Abrev_Dife, pre023.Fecha_Diferido, pre023.Descripcion_Dife, pre023.anulado, pre023.Fecha_Anu, 
	    pre033.Cod_Presup, pre033.Fuente_Financ, pre001.Denominacion, pre033.Monto_Diferido,  to_char(pre023.Fecha_Diferido,'DD/MM/YYYY') as fechad   FROM pre001, pre023, pre033, pre024 
	    WHERE pre023.Referencia_Dife=pre033.Referencia_Dife and pre023.Tipo_Diferido=pre033.Tipo_Diferido and
	    pre001.Cod_Presup = pre033.Cod_Presup And pre033.Fuente_Financ=pre001.Cod_Fuente  AND  pre023.Tipo_Diferido = pre024.Tipo_Diferido and
		(pre023.Tipo_Diferido>='".$tipo_diferido_d."' and pre023.Tipo_Diferido<='".$tipo_diferido_h."') and (pre023.Referencia_Dife>='".$referencia_d."' and pre023.Referencia_Dife<='".$referencia_h."') and
		(pre023.Fecha_Diferido>='".$fecha_desde."' and pre023.Fecha_Diferido<='".$fecha_hasta."')  and
		(pre033.Cod_Presup>='".$cod_presupd."' and pre033.Cod_Presup<='".$cod_presuph."') And (pre033.Fuente_Financ>='$cod_fuente_d' and pre033.Fuente_Financ<='$cod_fuente_h') 
	    ORDER BY pre023.Fecha_Diferido, pre023.Tipo_Diferido, pre023.Referencia_Dife";
    if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
		$oRpt = new PHPReportMaker();
		$oRpt->setXML("Rpt_diferido.xml");
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
	if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $fecha_diferido_grupo=""; $referencia_dife_grupo="00000000"; $tipo_diferido_grupo="0000"; 
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $criterio2;  global $registro; global $tam_logo;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(150,10,'REPORTE DIEFERIDOS PRESUPUESTARIOS',1,0,'C');
				$this->Ln(15);
				$this->SetFont('Arial','B',8);
				$this->Cell(100,10,$criterio1,0,0,'L');			
				$this->Ln(10);
			    $this->SetFont('Arial','B',7);
				$this->Cell(18,5,'REFERENCIA',1,0);
				$this->Cell(14,5,'FECHA',1,0,'L');						
				$this->Cell(8,5,'TIPO',1,0,'L');	
				$this->Cell(10,5,'ABRV.',1,0,'C');	
				$this->Cell(150,5,'DESCRIPCION ',1,1,'L');
				$this->Cell(55,4,'CODIGO PRESUPUESTARIO',1,0,'L');						
				$this->Cell(125,4,'DENOMINACION CODIGO PRESUPUESTARIO',1,0,'L');
				$this->Cell(20,4,'MONTO',1,1,'R');
		    }
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-10);
				$this->SetFont('Arial','I',5);
				$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
				$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			}
		  }		  
		  $pdf=new PDF('P', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $total_monto=0; $sub_total_monto=0; $cantidad_ordenes=0; $prev_fecha_diferido=""; $prev_referencia_dife="";  $prev_tipo_diferido=""; 
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $fecha_diferido=$registro["fecha_diferido"]; $referencia_dife=$registro["referencia_dife"]; 
			$tipo_diferido=$registro["tipo_diferido"]; $nombre_abrev_dife=$registro["nombre_abrev_dife"]; $descripcion_dife=$registro["descripcion_dife"]; 
			$fecha_diferido=formato_ddmmaaaa($fecha_diferido); 	if($php_os=="WINNT"){$descripcion_dife=$registro["descripcion_dife"]; }else{$descripcion_dife=utf8_decode($descripcion_dife);}
		    $fecha_diferido_grupo=$fecha_diferido; $referencia_dife_grupo=$referencia_dife; $tipo_diferido_grupo=$tipo_diferido; $nombre_abrev_dife_grupo=$nombre_abrev_dife; 			         $descripcion_dife_grupo=$descripcion_dife;

			if(($prev_fecha_diferido<>$fecha_diferido_grupo)or($prev_tipo_diferido<>$tipo_diferido_grupo)or($prev_referencia_dife<>$referencia_dife_grupo)){ $cantidad_ordenes=$cantidad_ordenes+1;
			    $pdf->SetFont('Arial','B',7); 
			    if($sub_total_monto<>0){ $sub_total_monto=formato_monto($sub_total_monto); 
					$pdf->Cell(180,2,'',0,0);
					$pdf->Cell(20,2,'----------------',0,1,'R');
					$pdf->Cell(180,3,'',0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto,0,1,'R');
                    $pdf->Ln(5);
				 }		
                 $pdf->SetFont('Arial','',7);				 
				 $pdf->Cell(17,4,$referencia_dife_grupo,0,0,'L'); 
				 $pdf->Cell(15,4,$fecha_diferido_grupo,0,0,'L');
				 $pdf->Cell(8,4,$tipo_diferido_grupo,0,0,'L');
				 $pdf->Cell(10,4,$nombre_abrev_dife_grupo,0,0,'C');
		   	     $x=$pdf->GetX();   $y=$pdf->GetY(); $n=150; 
		   	   	 $pdf->SetXY($x,$y);
		         $pdf->MultiCell($n,4,$descripcion_dife_grupo,0,1);  
				 $pdf->Ln(2);
				 $prev_fecha_diferido=$fecha_diferido_grupo; $prev_referencia_dife=$referencia_dife_grupo; $prev_tipo_diferido=$tipo_diferido_grupo; $sub_total_monto=0; 
			} 
            $pdf->SetFont('Arial','',7); 
		    $fecha_diferido=$registro["fecha_diferido"]; $referencia_dife=$registro["referencia_dife"]; $tipo_diferido=$registro["tipo_diferido"]; 
			$nombre_abrev_dife=$registro["nombre_abrev_dife"]; $descripcion_dife=$registro["descripcion_dife"]; $cod_presup=$registro["cod_presup"]; 
		    $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"]; $monto_diferido=$registro["monto_diferido"];
			$total_monto=$total_monto+$monto_diferido; $sub_total_monto=$sub_total_monto+$monto_diferido; $monto_diferido=formato_monto($monto_diferido); 				   $fecha_diferido=formato_ddmmaaaa($fecha_diferido);	
			if($php_os=="WINNT"){$descripcion_dife=$registro["descripcion_dife"]; }else{$descripcion_dife=utf8_decode($descripcion_dife);$denominacion=utf8_decode($denominacion);}
			$pdf->Cell(55,3,$cod_presup."   ".$fuente_financ,0,0,'R'); 			   
		   	$x=$pdf->GetX();   $y=$pdf->GetY(); $n=125; 
		    $pdf->SetXY($x+$n,$y);
			$pdf->Cell(20,3,$monto_diferido,0,1,'R');
		   	$pdf->SetXY($x,$y);
		    $pdf->MultiCell($n,3,$denominacion,0);  
		  } $total_monto=formato_monto($total_monto);  
		  $pdf->SetFont('Arial','B',7);
			if($sub_total_monto<>0){ $sub_total_monto=formato_monto($sub_total_monto); 
					$pdf->Cell(240,2,'',0,0);
					$pdf->Cell(20,2,'----------------',0,1,'R');
					$pdf->Cell(240,2,'',0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto,0,1,'R');
                   $pdf->Ln(5);
			}
			$pdf->Cell(180,2,'',0,0);
			$pdf->Cell(20,2,'=============',0,1,'R');
			$pdf->Cell(100,5,'Cantidad Diferidos : '.$cantidad_ordenes,0,0,'L');
		    $pdf->Cell(80,5,'TOTAL GENERAL ',0,0,'R');
			$pdf->Cell(20,5,$total_monto,0,1,'R');
			$pdf->Output();   
	}
    if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_diferido.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
			        <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE DIEFERIDOS PRESUPUESTARIOS</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1?></strong></font></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="left" ><strong></strong></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Referencia</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Abrv.</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF" ><strong>Descripcion</strong></td>
			 </tr>
			 <tr height="20">
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Codigo Presupuestario</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Denominacion Codigo Presupuestario</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			   <td width="400" align="right" bgcolor="#99CCFF"><strong>Monto</strong></td>
			 </tr>
		  <?  $i=0; $total_monto=0; $sub_total_monto=0; $cantidad_ordenes=0; 
			 $prev_fecha_diferido=""; $prev_referencia_dife="";  $prev_tipo_diferido="";    $res=pg_query($sSQL);
		    while($registro=pg_fetch_array($res)){ $i=$i+1; $fecha_diferido=$registro["fecha_diferido"]; $referencia_dife=$registro["referencia_dife"]; 
			    $tipo_diferido=$registro["tipo_diferido"]; $nombre_abrev_dife=$registro["nombre_abrev_dife"]; $descripcion_dife=$registro["descripcion_dife"]; 
			    $fecha_diferido=formato_ddmmaaaa($fecha_diferido); 	$descripcion_dife_grupo=$descripcion_dife;
		        $fecha_diferido_grupo=$fecha_diferido; $referencia_dife_grupo=$referencia_dife; $tipo_diferido_grupo=$tipo_diferido; $nombre_abrev_dife_grupo=$nombre_abrev_dife; 			         

			    if(($prev_fecha_diferido<>$fecha_diferido_grupo)or($prev_tipo_diferido<>$tipo_diferido_grupo)or($prev_referencia_dife<>$referencia_dife_grupo)){ $cantidad_ordenes=$cantidad_ordenes+1;
			    if($sub_total_monto>0){ $sub_total_monto=formato_monto($sub_total_monto);	
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="400" align="left"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="400" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="400" align="left"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="400" align="right"><? echo $sub_total_monto; ?></td>
			        </tr>	
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			      ?>	   
			      <tr>
				   <td width="100" align="left">'<? echo $referencia_dife_grupo; ?></td>
				   <td width="400" align="left"><? echo $fecha_diferido_grupo; ?></td>
				   <td width="100" align="left">'<? echo $tipo_diferido_grupo; ?></td>
				   <td width="100" align="left"><? echo $nombre_abrev_dife_grupo; ?></td>
				   <td width="400" align="left"><? echo $descripcion_dife_grupo; ?></td>
			      </tr>
			      <tr>
				  <td width="90" align="left"></td>
			      </tr>	
			     <? 					 
			    $prev_fecha_diferido=$fecha_diferido_grupo; $prev_referencia_dife=$referencia_dife_grupo; $prev_tipo_diferido=$tipo_diferido_grupo; $sub_total_monto=0;  }

		       $fecha_diferido=$registro["fecha_diferido"]; $referencia_dife=$registro["referencia_dife"]; $tipo_diferido=$registro["tipo_diferido"]; 
			   $nombre_abrev_dife=$registro["nombre_abrev_dife"]; $descripcion_dife=$registro["descripcion_dife"]; $cod_presup=$registro["cod_presup"]; 
		       $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"]; $monto_diferido=$registro["monto_diferido"];
			   $total_monto=$total_monto+$monto_diferido; $sub_total_monto=$sub_total_monto+$monto_diferido; $monto_diferido=formato_monto($monto_diferido); 				   $fecha_diferido=formato_ddmmaaaa($fecha_diferido);		   
			   $descripcion_dife=conv_cadenas($descripcion_dife,0);$denominacion=conv_cadenas($denominacion,0); 
			   ?>	   
				<tr>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_presup."   ".$fuente_financ; ?></td>
				   <td width="400" align="justify"><? echo $denominacion; ?></td>
				   <td width="100" align="right"></td>
				   <td width="100" align="right"></td>
				   <td width="400" align="right"><? echo $monto_diferido; ?></td>
				 </tr>
			   <? 	

		  }$total_monto=formato_monto($total_monto);  
		     if($sub_total_monto>0){ $sub_total_monto=formato_monto($sub_total_monto);  		
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="400" align="left"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="400" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="400" align="left"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="400" align="right"><? echo $sub_total_monto; ?></td>
			        </tr>			
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="right">---------------</td>
			</tr>	
			<tr>
			    <td width="100" align="left">Cantidad Diferidos : <strong><? echo $cantidad_ordenes; ?></strong></td>
			    <td width="400" align="right"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right"><strong>TOTAL GENERAL : </strong></td>
			    <td width="400" align="right"><strong><? echo $total_monto; ?></strong></td>
			</tr>	
		       <? 				  
		  ?></table><?
    }
}
?>
