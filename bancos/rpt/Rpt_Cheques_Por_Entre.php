<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$num_cheque_d=$_GET["num_cheque_d"];$num_cheque_h=$_GET["num_cheque_h"];$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$fecha_caducado_d=$_GET["fecha_caducado_d"];$fecha_caducado_h=$_GET["fecha_caducado_h"];$ordenado=$_GET["ordenado"];$estado=$_GET["estado"];$tipo_rep=$_GET["tipo_rep"];$Sql=""; $date = date("d-m-Y");$hora = date("H:i:s a");
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';}$fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;
$criterio1="Fecha Desde: ".$fecha_d." Hasta: ".$fecha_h; $criterios=" (BAN006.Entregado<>'S')";
if ($estado=='N'){ $criterios=" BAN006.Entregado='N' "; }
if ($estado=='P'){ $criterios=" BAN006.Entregado='P' "; }
if ($estado=='U'){ $criterios=" BAN006.Entregado='U' "; }
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else { $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} } 
    $sSQL = "SELECT BAN006.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN006.Num_Cheque,BAN006.Fecha, BAN006.Ced_Rif, PRE099.Nombre, BAN006.Nro_Orden_Pago, BAN006.Concepto,
                BAN006.Anulado, BAN006.Fecha_Anulado, BAN006.Entregado, BAN006.Fecha_Entregado, BAN006.Ced_Rif_Recib, BAN006.Nombre_Recib, BAN006.Monto_Cheque, to_char(Fecha,'DD/MM/YYYY') as fechac, 
				to_char(Fecha_Entregado,'DD/MM/YYYY') as fechae, to_char(Fecha_Anulado,'DD/MM/YYYY') as fechaa 
                FROM BAN002,BAN006,PRE099 WHERE (BAN006.Cod_Banco=BAN002.Cod_Banco) AND (BAN006.Ced_Rif=PRE099.Ced_Rif) AND (BAN006.Anulado='N') AND
                BAN006.Cod_Banco>='".$cod_banco_d."' AND BAN006.Cod_Banco<='".$cod_banco_h."' AND BAN006.Num_Cheque>='".$num_cheque_d."' AND BAN006.Num_Cheque<='".$num_cheque_h."' AND
                BAN006.Ced_Rif>='".$cedula_d."' AND BAN006.Ced_Rif<='".$cedula_h."' AND BAN006.Fecha>='".$fecha_desde."' AND BAN006.Fecha<='".$fecha_hasta."' AND  ".$criterios.
                "ORDER BY BAN006.Cod_Banco, BAN006.Fecha, ".$ordenado."";
				
	if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php"); 
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Cheques_Por_Entregar.xml");
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
    if($tipo_rep=="PDF"){ $res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_banco_grupo="0000"; $nombre_banco_grupo=""; $nro_cuenta_grupo="00000000"; 
	      if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		  if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);} $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; }
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $tam_logo;  global $criterio1; global $cod_banco_grupo; global $nombre_banco_grupo; global $nro_cuenta_grupo; global $registro;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(30);
				$this->Cell(150,10,'REPORTE CHEQUES POR ENTREGAR',1,0,'C');
				$this->Ln(18);
				$this->SetFont('Arial','B',8);
				$this->Cell(100,5,$criterio1,0,1,'L');	
				$this->SetFont('Arial','B',7);
                $this->Cell(200,5,$cod_banco_grupo." ".$nombre_banco_grupo."  ".$nro_cuenta_grupo,0,1);
				
				$this->Cell(15,3,'CHEQUE','RLT',0);	
				$this->Cell(16,3,'NUMERO','LT',0,'C');				
				$this->Cell(15,3,'','LT',0,'L');	
                $this->Cell(19,3,'','LT',0,'L');					
				$this->Cell(100,3,'','LT',0,'L');	
				$this->Cell(15,3,'FECHA','LT',0,'C');
				$this->Cell(20,3,'MONTO','RLT',1,'R');
				
				$this->Cell(15,3,'NUEMRO','LB',0);
				$this->Cell(16,3,'ORDEN','LB',0,'C');	
				$this->Cell(15,3,'ESTADO','LB',0,'C');
				$this->Cell(19,3,'CED/RIF','LB',0,'L');					
				$this->Cell(100,3,'NOMBRE','LB',0,'L');	
				$this->Cell(15,3,'EMISION','LB',0,'C');
				$this->Cell(20,3,'CHEQUE','RLB',1,'R');
			}
			function Footer(){ $ffechar=date("d-m-Y"); $fhorar=date("H:i:s a"); 
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
		  $i=0;  $total_cheque=0; $total=0; $cantidad_cheques=0; $cantidad=0; $prev_cod_banco="";  $prev_nombre_banco=""; $prev_nro_cuenta=""; 
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"];

 $nro_cuenta=$registro["nro_cuenta"]; if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);}
		       $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; 
			   if($prev_cod_banco<>$cod_banco_grupo){ 
			     $pdf->SetFont('Arial','B',7); 
			     if(($total_cheque>0)or($cantidad_cheques>0)){ $total_cheque=formato_monto($total_cheque); 					    
				    $pdf->Cell(180,2,'',0,0);
					$pdf->Cell(20,2,'-------------------',0,1,'R');
					$pdf->Cell(180,5,"Total Banco: ".$prev_cod_banco."  ".$prev_nombre_banco."  ".$prev_nro_cuenta."    ".$cantidad_cheques,0,0,'R');  
					$pdf->Cell(20,5,$total_cheque,0,1,'R'); 
					$pdf->AddPage();					
				 }				 
				 $pdf->SetFont('Arial','',7);	
				 $prev_cod_banco=$cod_banco_grupo; $prev_nombre_banco=$nombre_banco_grupo; $prev_nro_cuenta=$nro_cuenta_grupo; $total_cheque=0; $cantidad_cheques=0;
			   }
			   $num_cheque=$registro["num_cheque"]; $nro_orden_pago=$registro["nro_orden_pago"]; $ced_rif=$registro["ced_rif"]; $fechae=$registro["fechae"]; $nombre=$registro["nombre"];
			   $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
			   $monto_cheque=$registro["monto_cheque"]; $entregado=$registro["entregado"];
		       if($entregado=="S"){$entregado="ENTREGADO";}else{if(($entregado=="N")or($entregado=="C")){$entregado="CAJA";}else{if($entregado=="U"){$entregado="UNIDAD";}else{$entregado="PROCESO";}}} 
			   $total=$total+$monto_cheque; $total_cheque=$total_cheque+$monto_cheque; $monto_cheque=formato_monto($monto_cheque); $cantidad_cheques=$cantidad_cheques+1; 
			   $cantidad=$cantidad+1; if($php_os=="WINNT"){$nombre=$registro["nombre"];} else{ $nombre=utf8_decode($nombre);}			   
			   $pdf->Cell(15,3,$num_cheque,0,0); 
			   $pdf->Cell(16,3,$nro_orden_pago,0,0,'C'); 
               $pdf->Cell(15,3,$entregado,0,0,'C'); 
			   $pdf->Cell(19,3,$ced_rif,0,0,'L');				   
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=100; 
			   $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(15,3,$fechae,0,0,'C');
			   $pdf->Cell(20,3,$monto_cheque,0,1,'R');
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$nombre,0); 				
			} $total=formato_monto($total);
			$pdf->SetFont('Arial','B',7);
			if(($total_cheque>0)or($cantidad_cheques>0)){ $total_cheque=formato_monto($total_cheque);	    
				$pdf->Cell(180,2,'',0,0);
				$pdf->Cell(20,2,'----------------',0,1,'R');
				$pdf->Cell(180,5,"Total Banco: ".$prev_cod_banco."   ".$prev_nombre_banco."    ".$prev_nro_cuenta."    ".$cantidad_cheques,0,0,'R'); 
				$pdf->Cell(20,5,$total_cheque,0,1,'R'); 
				$pdf->Ln(10);
			}
			$pdf->Cell(180,2,'',0,0);
			$pdf->Cell(20,2,'==============',0,1,'R');
			$pdf->Cell(180,5,'TOTAL: '."   ".$cantidad,0,0,'R');
			$pdf->Cell(20,5,$total,0,1,'R'); 
			$pdf->Output(); 
	}
    if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_Cheques_Por_Entregar.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE CHEQUES POR ENTREGAR</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <strong><?	echo $criterio1?></strong></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Cheque Nro</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Nro Orden</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF" ><strong>Estado</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Ced/Rif</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Fecha Emision</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto Cheque</strong></td>
			 </tr>
		  <?  $i=0;  $total_cheque=0; $total=0; $cantidad_cheques=0; $cantidad=0; $prev_cod_banco=""; $prev_nombre_banco=""; $prev_nro_cuenta=""; $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; 
			   if($prev_cod_banco<>$cod_banco_grupo){ 
			    if(($total_cheque>0)or($cantidad_cheques>0)){ $total_cheque=formato_monto($total_cheque); 				
			     ?>	 				 
                  <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="right"></td>
			          <td width="400" align="left"></td>
			          <td width="100" align="right"></td>
			          <td width="100" align="right">-------------------</td>
			      </tr>	
			      <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
				       <td width="100" align="right"></td>
			          <td width="400" align="right"><? echo "Total: ".$prev_cod_banco."   ".$prev_nombre_banco."    ".$prev_nro_cuenta."    ".$cantidad_cheques; ?></td>
			          <td width="100" align="right"></td>
				      <td width="100" align="right"><? echo $total_cheque; ?></td>
			      </tr>	
			      <tr>
				  <td width="90" align="left"></td>
			      </tr>	
                  <?} ?>	   
			      <tr>
				  <td width="100" align="left" ><strong>BANCO: <? echo $cod_banco; ?></strong></td>
				  
				  <td width="100" align="left"><strong></strong></td>
				  <td width="100" align="left"><strong></strong></td>
				  <td width="100" align="left"><strong></strong></td>
				  <td width="400" align="left"><strong><? echo $nombre_banco."    ".$nro_cuenta; ?></strong></td>
			      </tr>
			     <? 					 
			    $prev_cod_banco=$cod_banco_grupo; $prev_nombre_banco=$nombre_banco_grupo; $prev_nro_cuenta=$nro_cuenta_grupo; $total_cheque=0; $cantidad_cheques=0; }
		        $num_cheque=$registro["num_cheque"]; $nro_orden_pago=$registro["nro_orden_pago"]; $ced_rif=$registro["ced_rif"]; $fechae=$registro["fechae"]; $nombre=$registro["nombre"];
			    $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
			    $monto_cheque=$registro["monto_cheque"]; $entregado=$registro["entregado"];
		        if($entregado=="S"){$entregado="ENTREGADO";}else{if($entregado=="N"){$entregado="CAJA";}else{if($entregado=="U"){$entregado="UNIDAD";}else{$entregado="PROCESO";}}} 
			    $total=$total+$monto_cheque; $total_cheque=$total_cheque+$monto_cheque; $monto_cheque=formato_monto($monto_cheque); $cantidad_cheques=$cantidad_cheques+1; 
			    $cantidad=$cantidad+1;   $nombre=conv_cadenas($nombre,0);
			   ?>	   
				<tr>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $num_cheque; ?></td>
				   <td width="100" align="left">'<? echo $nro_orden_pago; ?></td>
				   <td width="100" align="left"><? echo $entregado; ?></td>
				   <td width="100" align="left"><? echo $ced_rif; ?></td>
				   <td width="400" align="justify"><? echo $nombre; ?></td>
				   <td width="100" align="left"><? echo $fechae; ?></td>
				   <td width="100" align="right"><? echo $monto_cheque; ?></td>
				 </tr>
			   <? 		  
		  }$total=formato_monto($total);
		  if(($total_cheque>0)or($cantidad_cheques>0)){ $total_cheque=formato_monto($total_cheque);
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right">-------------------</td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right"></td>
			    <td width="100" align="right"></td>
			    <td width="400" align="right"><? echo "Total: ".$prev_cod_banco."   ".$prev_nombre_banco."    ".$prev_nro_cuenta."    ".$cantidad_cheques; ?></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right"><? echo $total_cheque; ?></td>
			</tr>	
		       <? }
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right">=============</td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right"></td>
			    <td width="100" align="right"></td>
			    <td width="400" align="right"><strong><? echo "TOTAL GENERAL : ".$cantidad; ?></strong></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right"><strong><? echo $total; ?></strong></td>
			</tr>	
		       <?					
		  		  
		  ?></table><?
        }	
			 
}
?>

