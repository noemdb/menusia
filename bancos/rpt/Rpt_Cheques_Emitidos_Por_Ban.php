<?include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$num_cheque_d=$_GET["num_cheque_d"];$num_cheque_h=$_GET["num_cheque_h"];$ult_cheque_d=$_GET["ult_cheque_d"];$ult_cheque_h=$_GET["ult_cheque_h"]; $tipochq=$_GET["tipochq"];
$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$monto_cheque_d=$_GET["monto_cheque_d"];$monto_cheque_h=$_GET["monto_cheque_h"]; $clasificacion_d=$_GET["clasificacion_d"];$clasificacion_h=$_GET["clasificacion_h"];
$cheques_nulos=$_GET["cheques_nulos"];$imprimir_cheques_anulados=$_GET["imp_chq_anulados"];$cantidad_cheques=$_GET["cantidad_cheques"];$ordenar=$_GET["ordenar"]; $tipo_rep=$_GET["tipo_rep"]; $most_con=$_GET["most_con"]; $Sql=""; $date = date("d-m-Y");$hora = date("H:i:s a");
$criterio1="Fecha Desde: ".$fecha_d." Hasta: ".$fecha_h;
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';}        $fecha_hasta=$ano1.$mes1.$dia1;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{   $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} } 

    if ($imprimir_cheques_anulados=='N'){$sformula= " and (ban006.anulado='N') "; } else{$sformula=" ";}   
    if($tipochq=="N"){ $sformula=" and ( text(ban006.cod_banco)||text(ban006.num_cheque)||text(ban006.tipo_pago) not in (SELECT text(cod_banco)||text(referencia_pago)||text(tipo_pago) from pre008) ) "; }
	if($tipochq=="P"){ $sformula=" and ( text(ban006.cod_banco)||text(ban006.num_cheque)||text(ban006.tipo_pago) in (SELECT text(cod_banco)||text(referencia_pago)||text(tipo_pago) from pre008) ) "; }
	
	 $sSQL = "SELECT ban006.cod_banco, ban002.Nombre_Banco, ban002.Nro_Cuenta, ban006.num_cheque, ban006.Fecha,    text (to_char(EXTRACT(day from ban006.fecha),'09'))||text('/')||text (to_char(EXTRACT(month from ban006.fecha),'09'))||text('/')||text (to_char(EXTRACT(year from ban006.fecha),'0009')) as fechae,
                ban006.Ced_Rif, pre099.Nombre, ban006.Nro_Orden_Pago, ban006.Concepto, ban006.anulado,  ban006.fecha_anulado, ban006.entregado, ban006.fecha_entregado, ban006.Ced_Rif_Recib,
                ban006.Nombre_Recib, ban006.monto_cheque   FROM ban002, ban006, pre099    WHERE ban006.cod_banco = ban002.cod_banco AND ban006.Ced_Rif = pre099.Ced_Rif AND
                ban006.cod_banco>='".$cod_banco_d."' AND ban006.cod_banco<='".$cod_banco_h."' AND  ban006.num_cheque>='".$num_cheque_d."' AND ban006.num_cheque<='".$num_cheque_h."' AND
				substring(ban006.num_cheque,3,6)>='".$ult_cheque_d."' AND substring(ban006.num_cheque,3,6)<='".$ult_cheque_h."' AND
                ban006.Ced_Rif>='".$cedula_d."' AND ban006.Ced_Rif<='".$cedula_h."' AND   ban006.Fecha>='".$fecha_desde."' AND ban006.Fecha<='".$fecha_hasta."' AND
                ban006.monto_cheque>='".$monto_cheque_d."' AND ban006.monto_cheque<='".$monto_cheque_h."' AND pre099.clasificacion >='".$clasificacion_d."' AND pre099.clasificacion <='".$clasificacion_h."' ".$sformula." order by ".$ordenar."";
	
	
    if ($most_con=="S"){$nomb_rpt="Rpt_Cheques_Emitidos_Por_Banco_Detalle.xml";}else{$nomb_rpt="Rpt_Cheques_Emitidos_Por_Banco.xml";}
	if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
	         //echo $sSQL;
	         $oRpt = new PHPReportMaker();
             $oRpt->setXML($nomb_rpt);
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1));
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
			function Header(){ global $tam_logo;  global $criterio1; global $cod_banco_grupo; global $nombre_banco_grupo; global $nro_cuenta_grupo; global $registro;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(30);
				$this->Cell(150,10,'REPORTE CHEQUES EMITIDOS POR BANCOS',1,0,'C');
				$this->Ln(17);
				$this->SetFont('Arial','B',8);
				$this->Cell(100,5,$criterio1,0,1,'L');	
				$this->Cell(200,5,"BANCO: ".$cod_banco_grupo." ".$nombre_banco_grupo." ".$nro_cuenta_grupo,0,1);
				$this->SetFont('Arial','B',7);	
				$this->Cell(18,3,'CHEQUE','RLT',0);	
				$this->Cell(18,3,'NUMERO','LT',0,'C');				
				$this->Cell(18,3,'','LT',0,'L');					
				$this->Cell(90,3,'','LT',0,'L');	
				$this->Cell(20,3,'FECHA','LT',0,'C');
				$this->Cell(20,3,'MONTO','LT',0,'R');
				$this->Cell(16,3,'DIAS ','RLT',1,'C');
                $this->Cell(18,3,'NUMERO','LB',0);	
				$this->Cell(18,3,'ORDEN','LB',0,'C');				
				$this->Cell(18,3,'CED/RIF','LB',0,'L');					
				$this->Cell(90,3,'NOMBRE','LB',0,'L');	
				$this->Cell(20,3,' EMISION','LB',0,'C');
				$this->Cell(20,3,'CHEQUE','LB',0,'C');
				$this->Cell(16,3,'ESTADO','RLB',1,'C');	
		
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
		  $i=0;  $total_cheque=0; $total=0; $prev_cod_banco="";  $prev_nombre_banco=""; $prev_nro_cuenta=""; $cantidad=0; $tot_cant=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       if($php_os=="WINNT"){$nombre_banco=$nombre_banco; } else{$nombre_banco=utf8_decode($nombre_banco);}
		       $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; 
			   if($prev_cod_banco<>$cod_banco_grupo){ 
			     $pdf->SetFont('Arial','B',7); 
			     if($total_cheque<>0){ $total_cheque=formato_monto($total_cheque); 					    
				    $pdf->Cell(164,2,'',0,0);
					$pdf->Cell(20,2,'---------------------',0,1,'R');
					$pdf->Cell(34,3,'Cantidad Cheques : '.$cantidad,0,0,'L');
					$pdf->Cell(130,5,"Total Banco: ".$prev_cod_banco."  ".$prev_nombre_banco."  ".$prev_nro_cuenta,0,0,'R');  
					$pdf->Cell(20,5,$total_cheque,0,1,'R'); 
					$pdf->AddPage();					
				 }				 
				 $pdf->SetFont('Arial','',7);	
				 $prev_cod_banco=$cod_banco_grupo; $prev_nombre_banco=$nombre_banco_grupo; $prev_nro_cuenta=$nro_cuenta_grupo; $total_cheque=0; 
			   }
               $num_cheque=$registro["num_cheque"]; $nro_orden_pago=$registro["nro_orden_pago"]; $ced_rif=$registro["ced_rif"]; $fechae=$registro["fechae"]; $nombre=$registro["nombre"];
			   $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
			   $monto_cheque=$registro["monto_cheque"]; $entregado=$registro["entregado"]; $concepto=$registro["concepto"]; $anulado=$registro["anulado"]; $fecha_anulado=$registro["fecha_anulado"];
		       if($entregado=="S"){$entregado="ENTREGADO";}else{if(($entregado=="N")or($entregado=="C")){$entregado="CAJA";}else{if($entregado=="U"){$entregado="UNIDAD";}else{$entregado="PROCESO";}}} 
			   if($anulado=="S"){$entregado="ANULADO"; if($cheques_nulos=="S"){$monto_cheque=0;} }
			   
 			   $total=$total+$monto_cheque; $total_cheque=$total_cheque+$monto_cheque; $monto_cheque=formato_monto($monto_cheque); 	
			   if($php_os=="WINNT"){$nombre=$registro["nombre"]; }else{$nombre=utf8_decode($nombre);  $concepto=utf8_decode($concepto);}	$cantidad=$cantidad+1;	$tot_cant=$tot_cant+1;   
			   $pdf->Cell(18,3,$num_cheque,0,0); 
			   $pdf->Cell(18,3,$nro_orden_pago,0,0,'C'); 
			   $pdf->Cell(18,3,$ced_rif,0,0,'L');				   
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=90; 
			   $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,3,$fechae,0,0,'C');
			   $pdf->Cell(20,3,$monto_cheque,0,0,'R');
               $pdf->Cell(16,3,$entregado,0,1,'C'); 
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$nombre,0); 
			   if ($most_con=="S"){ 
			      $pdf->MultiCell(164,3,$concepto,0); 
				  $pdf->Ln(2);
			   }
			} $total=formato_monto($total);
			$pdf->SetFont('Arial','B',7);
			if($total_cheque<>0){ $total_cheque=formato_monto($total_cheque); 					    
				$pdf->Cell(164,2,'',0,0);
				$pdf->Cell(20,2,'---------------------',0,1,'R');
				$pdf->Cell(34,3,'Cantidad Cheques : '.$cantidad,0,0,'L');
				$pdf->Cell(130,5,"Total Banco: ".$prev_cod_banco."    ".$prev_nombre_banco."    ".$prev_nro_cuenta,0,0,'R'); 
				$pdf->Cell(20,5,$total_cheque,0,1,'R'); 
				$pdf->Ln(10);
			}
			$pdf->Cell(164,2,'',0,0);
			$pdf->Cell(20,2,'==============',0,1,'R');
			$pdf->Cell(34,3,'CANTIDAD CHEQUES : '.$cantidad,0,0,'L');
			$pdf->Cell(130,5,'TOTAL GENERAL: ',0,0,'R');
			$pdf->Cell(20,5,$total,0,1,'R'); 
			$pdf->Output();  
	}
    if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_Cheques_Emitidos_Por_Banco.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE CHEQUES EMITIDOS POR BANCOS</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <strong><?	echo $criterio1?></strong></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Cheque Nro</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Nro Orden</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Ced/Rif</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Fecha Emision</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto Cheque</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Estado</strong></td>
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
			          <td width="100" align="left"></td>
			          <td width="400" align="left"></td>
			          <td width="100" align="right"></td>
			          <td width="100" align="right">------------------</td>
			          <td width="100" align="right"></td>
			      </tr>	
			      <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="400" align="right"><? echo "Total: ".$prev_cod_banco."   ".$prev_nombre_banco."    ".$prev_nro_cuenta; ?></td>
			          <td width="100" align="right"></td>
				      <td width="100" align="right"><? echo $total_cheque; ?></td>
				      <td width="100" align="right"></td>
			      </tr>
                 <?}?>	   
			      <tr>
					  <td width="100" align="left">'<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_banco; ?></td>
					  <td width="100" align="left" ><strong></strong></td>
					  <td width="100" align="left" ><strong></strong></td>
					  <td width="400" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $nombre_banco."    ".$nro_cuenta; ?></td>
					  
				  </tr>
			     <? 					 
			   $prev_cod_banco=$cod_banco_grupo; $prev_nombre_banco=$nombre_banco_grupo; $prev_nro_cuenta=$nro_cuenta_grupo; $total_cheque=0;  }
               $num_cheque=$registro["num_cheque"]; $nro_orden_pago=$registro["nro_orden_pago"]; $ced_rif=$registro["ced_rif"]; $fechae=$registro["fechae"]; $nombre=$registro["nombre"];
			   $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
			   $monto_cheque=$registro["monto_cheque"]; $entregado=$registro["entregado"];
		       If($entregado=="S"){$entregado="ENTREGADO";}else{if($entregado=="N"){$entregado="CAJA";}else{if($entregado=="U"){$entregado="UNIDAD";}else{$entregado="PROCESO";}}} 
			   $total=$total+$monto_cheque; $total_cheque=$total_cheque+$monto_cheque; $monto_cheque=formato_monto($monto_cheque); $nombre=conv_cadenas($nombre,0);
			   ?>	   
				<tr>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $num_cheque; ?></td>
				   <td width="100" align="left">'<? echo $nro_orden_pago; ?></td>
				   <td width="100" align="left"><? echo $ced_rif; ?></td>
				   <td width="400" align="justify"><? echo $nombre; ?></td>
				   <td width="100" align="center"><? echo $fechae; ?></td>
				   <td width="100" align="right"><? echo $monto_cheque; ?></td>
				   <td width="100" align="center"><? echo $entregado; ?></td>
				 </tr>
			   <? 		  
		  }$total=formato_monto($total);

		  if($total_cheque>0){ $total_cheque=formato_monto($total_cheque); 
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right">------------------</td>
			    <td width="100" align="right"></td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right"></td>
			    <td width="400" align="right"><? echo "Total: ".$prev_cod_banco."   ".$prev_nombre_banco."    ".$prev_nro_cuenta; ?></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right"><? echo $total_cheque; ?></td>
			    <td width="100" align="right"></td>
			</tr>	
		       <? }?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right">=============</td>
			    <td width="100" align="right"></td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right"></td>
			    <td width="400" align="right"><strong>TOTAL: </strong></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right"><strong><? echo $total; ?></strong></td>
			    <td width="100" align="right"></td>
			</tr>	
		   </table><?
    }
}

?>
