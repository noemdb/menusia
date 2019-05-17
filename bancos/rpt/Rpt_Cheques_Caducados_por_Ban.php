<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$num_cheque_d=$_GET["num_cheque_d"];$num_cheque_h=$_GET["num_cheque_h"];$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$fecha_caduca_d=$_GET["fecha_anu_d"];$fecha_caduca_h=$_GET["fecha_anu_h"];$fecha_proceso=$_GET["fecha_proceso"]; $ordenado=$_GET["ordenado"];$tipo_rep=$_GET["tipo_rep"];
$Sql=""; $date = date("d-m-Y");$hora = date("h:i:s a" ); $criterio1="Fecha Desde: ".$fecha_d." Hasta: ".$fecha_h;
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else { $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} } $dias_caduca=0; 
   $sql="Select campo502,campo503,campo510,campo549 from SIA005 where campo501='02'"; $resultado=pg_query($sql);
   if($registro=pg_fetch_array($resultado,0)){$dias_caduca=$registro["campo549"]; }
	$fechap=formato_aaaammdd($fecha_proceso);	$criterio1="Fecha de Proceso: ".$fecha_proceso;
   //SELECT ban006.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, ban006.Num_Cheque, ban006.Fecha, ban006.Ced_Rif, PRE099.Nombre, ban006.Nro_Orden_Pago, ban006.Concepto, ban006.Anulado, ban006.Fecha_Anulado, ban006.Entregado, ban006.Fecha_Entregado, ban006.Ced_Rif_Recib, ban006.Nombre_Recib, ban006.Monto_Cheque  FROM BAN002 BAN002, ban006 ban006, PRE099 PRE099  WHERE ban006.Cod_Banco = BAN002.Cod_Banco AND ban006.Ced_Rif = PRE099.Ced_Rif AND ((ban006.Entregado='N') AND (ban006.Anulado='N'))  ORDER BY ban006.Cod_Banco, ban006.Num_Cheque, ban006.Fecha
   
   $sSQL = "SELECT ban006.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, ban006.Num_Cheque, ban006.fecha, ban006.fecha+$dias_caduca as fecha_caduca, ban006.Ced_Rif, PRE099.Nombre,
			ban006.Nro_Orden_Pago, ban006.Concepto, ban006.Anulado, ban006.Fecha_Anulado, ban006.Entregado, ban006.Fecha_Entregado, ban006.Ced_Rif_Recib , to_char(ban006.fecha,'DD/MM/YYYY') as fechae, to_char(ban006.fecha+$dias_caduca,'DD/MM/YYYY') as fechac,
			ban006.Nombre_Recib, ban006.Monto_Cheque, cast('".$fechap."' as date)-(ban006.fecha+$dias_caduca) as dias_cad FROM BAN002, ban006, PRE099
			WHERE ban006.Cod_Banco = BAN002.Cod_Banco AND ban006.Ced_Rif = PRE099.Ced_Rif AND ((ban006.Entregado='N') AND (ban006.Anulado='N'))  AND
			ban006.Cod_Banco>='".$cod_banco_d."' AND ban006.Cod_Banco<='".$cod_banco_h."' AND ban006.Num_Cheque>='".$num_cheque_d."' AND ban006.Num_Cheque<='".$num_cheque_h."'  AND
			ban006.Ced_Rif>='".$cedula_d."' AND ban006.Ced_Rif<='".$cedula_h."'  AND ban006.fecha>='".$fecha_desde."' AND ban006.fecha<='".$fecha_hasta."' AND
			(ban006.fecha+$dias_caduca)<'".$fechap."' ORDER BY ".$ordenado;
			
	if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php"); //ECHO  $sSQL;	
		 $oRpt = new PHPReportMaker();
		 $oRpt->setXML("Rpt_Cheques_Caducados_Por_Banco.xml");
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
    if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_banco_grupo="0000"; $nombre_banco_grupo=""; $nro_cuenta_grupo="00000000"; 
	      if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		  if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);} $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; }
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $tam_logo; global $criterio1; global $cod_banco_grupo; global $nombre_banco_grupo; global $nro_cuenta_grupo; global $registro;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(30);
				$this->Cell(150,10,'REPORTE CHEQUES CADUCADOS POR BANCOS',1,0,'C');
				$this->Ln(17);
				$this->SetFont('Arial','B',8);
				$this->Cell(100,5,$criterio1,0,1,'L');	
				$this->Cell(200,5,"BANCO: ".$cod_banco_grupo." ".$nombre_banco_grupo." ".$nro_cuenta_grupo,0,1);
				$this->SetFont('Arial','B',7);
				$this->Cell(18,3,'CHEQUE','RLT',0);	
				$this->Cell(18,3,'','LT',0,'L');					
				$this->Cell(90,3,'','LT',0,'L');	
				$this->Cell(20,3,'FECHA','LT',0,'C');
				$this->Cell(18,3,'FECHA','LT',0,'C');
				$this->Cell(20,3,'MONTO','LT',0,'R');
				$this->Cell(16,3,'DIAS ','RLT',1,'C');
				
                $this->Cell(18,3,'NUMERO','LB',0);	
				$this->Cell(18,3,'CED/RIF','LB',0,'L');					
				$this->Cell(90,3,'NOMBRE','LB',0,'L');	
				$this->Cell(20,3,' EMISION','LB',0,'C');
				$this->Cell(18,3,'CADUCA','LB',0,'C');
				$this->Cell(20,3,'CHEQUE','LB',0,'C');
				$this->Cell(16,3,'CADUCADO','RLB',1,'C');				
		
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
		  $i=0;  $total_cheque=0; $total=0; $prev_cod_banco="";  $prev_nombre_banco=""; $prev_nro_cuenta="";
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       if($php_os=="WINNT"){$nombre_banco=$nombre_banco; } else{$nombre_banco=utf8_decode($nombre_banco);}
		       $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; 
			   if($prev_cod_banco<>$cod_banco_grupo){ 
			     $pdf->SetFont('Arial','B',7); 
			     if($total_cheque>0){ $total_cheque=formato_monto($total_cheque); 					    
				    $pdf->Cell(164,2,'',0,0);
					$pdf->Cell(20,2,'--------------------',0,1,'R');
					$pdf->Cell(164,5,"Total Banco: ".$prev_cod_banco."  ".$prev_nombre_banco."  ".$prev_nro_cuenta,0,0,'R');  
					$pdf->Cell(20,5,$total_cheque,0,1,'R'); 
					$pdf->AddPage();					
				 }				 
				 $pdf->SetFont('Arial','',7);	
				 $prev_cod_banco=$cod_banco_grupo; $prev_nombre_banco=$nombre_banco_grupo; $prev_nro_cuenta=$nro_cuenta_grupo; $total_cheque=0; 
			   }
               $num_cheque=$registro["num_cheque"]; $nro_orden_pago=$registro["nro_orden_pago"]; $ced_rif=$registro["ced_rif"]; $fechae=$registro["fechae"]; $nombre=$registro["nombre"];
			   $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $fechac=$registro["fechac"];
			   $monto_cheque=$registro["monto_cheque"]; $entregado=$registro["entregado"]; $dias_cad=$registro["dias_cad"];
		       if($entregado=="S"){$entregado="ENTREGADO";}else{if($entregado=="N"){$entregado="CAJA";}else{if($entregado=="U"){$entregado="UNIDAD";}else{$entregado="PROCESO";}}} 
			   $total=$total+$monto_cheque; $total_cheque=$total_cheque+$monto_cheque; $monto_cheque=formato_monto($monto_cheque); 	
			   if($php_os=="WINNT"){$nombre=$registro["nombre"]; }else{$nombre=utf8_decode($nombre);}		   
			   $pdf->Cell(18,3,$num_cheque,0,0); 
			   $pdf->Cell(18,3,$ced_rif,0,0,'L');				   
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=90; 
			   $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,3,$fechae,0,0,'C');
			   $pdf->Cell(18,3,$fechac,0,0,'C');
			   $pdf->Cell(20,3,$monto_cheque,0,0,'R');
               $pdf->Cell(16,3,$dias_cad,0,1,'C'); 
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$nombre,0); 
			} $total=formato_monto($total);
			$pdf->SetFont('Arial','B',7);
			if($total_cheque>0){ $total_cheque=formato_monto($total_cheque); 					    
				$pdf->Cell(164,2,'',0,0);
				$pdf->Cell(20,2,'--------------------',0,1,'R');
				$pdf->Cell(164,5,"Total Banco: ".$prev_cod_banco."    ".$prev_nombre_banco."    ".$prev_nro_cuenta,0,0,'R'); 
				$pdf->Cell(20,5,$total_cheque,0,1,'R'); 
				$pdf->Ln(10);
			}
			$pdf->Cell(164,2,'',0,0);
			$pdf->Cell(20,2,'==============',0,1,'R');
			$pdf->Cell(164,5,'TOTAL GENERAL: ',0,0,'R');
			$pdf->Cell(20,5,$total,0,1,'R'); 
			$pdf->Output();  
	}
	if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_Cheques_Caducados_Por_Banco.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left"><strong></strong></td>
				<td width="100" align="left"><strong></strong></td>
				<td width="400" align="center"> <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE CHEQUES CADUCADOS POR BANCOS</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left"><strong></strong></td>
				<td width="100" align="left"><strong></strong></td>
				<td width="400" align="center"><strong><?	echo $criterio1?></strong></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Cheque Nro</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Ced/Rif</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Fecha Emision</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Fecha Caduca</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto Cheque</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Dias Caducado</strong></td>
			 </tr>
		  <?  $i=0;  $total_cheque=0; $total=0; $prev_cod_banco="";  $prev_nombre_banco=""; $prev_nro_cuenta=""; $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta;
			   if($prev_cod_banco<>$cod_banco_grupo){ 
			    if($total_cheque>0){ $total_cheque=formato_monto($total_cheque);			
			     ?>	 				 
                  <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>			          
			          <td width="400" align="left"></td>
					  <td width="100" align="left"></td>
			          <td width="100" align="right"></td>
			          <td width="100" align="right">------------------</td>
			          <td width="100" align="right"></td>
			      </tr>	
			      <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="400" align="right"><? echo "Total: ".$prev_cod_banco."   ".$prev_nombre_banco."    ".$prev_nro_cuenta; ?></td>
			          <td width="100" align="right"></td>
					  <td width="100" align="left"></td>
				      <td width="100" align="right"><? echo $total_cheque; ?></td>
				      <td width="100" align="right"></td>
			      </tr>
				  <tr height="20">
					<td width="100" align="left"><strong></strong></td>
				  </tr>
                 <?}?>	   
			      <tr>
					  <td width="100" align="left">'<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_banco; ?></td>
					  <td width="100" align="left" ><strong></strong></td>					  
					  <td width="400" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $nombre_banco."    ".$nro_cuenta; ?></td>
					  <td width="100" align="left" ><strong></strong></td>
				  </tr>
			     <? 					 
			   $prev_cod_banco=$cod_banco_grupo; $prev_nombre_banco=$nombre_banco_grupo; $prev_nro_cuenta=$nro_cuenta_grupo; $total_cheque=0;  }
               $num_cheque=$registro["num_cheque"]; $nro_orden_pago=$registro["nro_orden_pago"]; $ced_rif=$registro["ced_rif"]; $fechae=$registro["fechae"]; $nombre=$registro["nombre"];
			   $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
			   $monto_cheque=$registro["monto_cheque"]; $entregado=$registro["entregado"]; $fechac=$registro["fechac"]; $dias_cad=$registro["dias_cad"];
		       If($entregado=="S"){$entregado="ENTREGADO";}else{if($entregado=="N"){$entregado="CAJA";}else{if($entregado=="U"){$entregado="UNIDAD";}else{$entregado="PROCESO";}}} 
			   $total=$total+$monto_cheque; $total_cheque=$total_cheque+$monto_cheque; $monto_cheque=formato_monto($monto_cheque); $nombre=conv_cadenas($nombre,0);
			   ?>	   
				<tr>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $num_cheque; ?></td>
				   <td width="100" align="left"><? echo $ced_rif; ?></td>
				   <td width="400" align="justify"><? echo $nombre; ?></td>
				   <td width="100" align="center"><? echo $fechae; ?></td>
				   <td width="100" align="left"><? echo $fechac; ?></td>
				   <td width="100" align="right"><? echo $monto_cheque; ?></td>
				   <td width="100" align="center"><? echo $dias_cad; ?></td>
				 </tr>
			   <? 		  
		  }$total=formato_monto($total);

		  if($total_cheque>0){ $total_cheque=formato_monto($total_cheque); 
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>			    
			    <td width="400" align="left"></td>
				<td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right">------------------</td>
			    <td width="100" align="right"></td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="right"><? echo "Total: ".$prev_cod_banco."   ".$prev_nombre_banco."    ".$prev_nro_cuenta; ?></td>
			    <td width="100" align="left"></td>
				<td width="100" align="left"></td>
			    <td width="100" align="right"><? echo $total_cheque; ?></td>
			    <td width="100" align="right"></td>
			</tr>	
		       <? }?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="left"></td>
				<td width="100" align="left"></td>
			    <td width="100" align="right">=============</td>
			    <td width="100" align="right"></td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="right"><strong>TOTAL: </strong></td>
			    <td width="100" align="left"></td>
				<td width="100" align="left"></td>
			    <td width="100" align="right"><strong><? echo $total; ?></strong></td>
			    <td width="100" align="right"></td>
			</tr>	
		   </table><?
    }
}
?>


