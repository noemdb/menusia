<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$num_cheque_d=$_GET["num_cheque_d"];$num_cheque_h=$_GET["num_cheque_h"];$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];
$ordenado=$_GET["ordenado"];$tipo_rep=$_GET["tipo_rep"]; $Sql=""; $date = date("d-m-Y");$hora = date("H:i:s a"); $equipo=getenv("COMPUTERNAME"); $cod_mov="BAN006".$usuario_sia;
$criterio1="Fecha Desde: ".$fecha_d." Hasta: ".$fecha_h;if($fecha_d==""){$sfecha_d="2010-01-01";}if($fecha_h==""){$sfecha_h="9999-12-31";}
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';}$fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;
$criterios=" (BAN006.Anulado='N') ";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{  $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} 
   $StrSQL = "DELETE FROM BAN036 Where (codigo_mov='".$cod_mov."')"; $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
    $res=pg_exec($conn,"SELECT INCLUYE_BAN036('$cod_mov','$cod_banco_d','$cod_banco_h','$fecha_d','$fecha_h','$num_cheque_d','$num_cheque_h','$cedula_d','$cedula_h')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

       $sSQL = "SELECT BAN036.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN036.num_cheque, BAN006.Fecha, BAN006.Ced_Rif, PRE099.Nombre, BAN006.Nro_Orden_Pago, BAN006.Concepto,
                BAN006.Anulado, BAN006.Fecha_Anulado, BAN006.Entregado, BAN006.Fecha_Entregado, BAN006.Ced_Rif_Recib, BAN006.Nombre_Recib, BAN006.Monto_Cheque, BAN036.Nro_Orden, BAN036.campo_str1, BAN036.campo_str2,
				BAN036.total_causado, BAN036.total_retencion, BAN036.total_ajuste, BAN036.total_pasivos, BAN036.monto_ret1, BAN036.monto_ret2, BAN036.monto_ret3, BAN036.monto_ret4, BAN036.monto_ret5,
				BAN036.monto_ret6, BAN036.monto_ret7, BAN036.monto_ret8, BAN036.monto_ret9,	substring(BAN036.campo_str2,1,100) as campo2, 
				(BAN036.monto_ret4+BAN036.monto_ret5+BAN036.monto_ret6+BAN036.monto_ret7+BAN036.monto_ret8+BAN036.monto_ret9) as monto_otros,
                (BAN036.total_causado-BAN036.total_ajuste+BAN036.total_pasivos) as monto_ord, 
                (BAN036.total_causado-BAN036.total_ajuste+BAN036.total_pasivos-BAN036.total_retencion) as monto_ban, 				
				to_char(BAN006.Fecha,'DD/MM/YYYY') as fechac, to_char(BAN006.Fecha_Entregado,'DD/MM/YYYY') as fechae, to_char(BAN006.Fecha_Anulado,'DD/MM/YYYY') as fechaa
                FROM BAN036,BAN002,BAN006,PRE099 WHERE (BAN036.codigo_mov='".$cod_mov."') AND
                (BAN006.Cod_Banco=BAN036.Cod_Banco) AND (BAN006.num_cheque=BAN036.num_cheque) AND
				(BAN006.Cod_Banco=BAN002.Cod_Banco) AND (BAN006.Ced_Rif=PRE099.Ced_Rif) AND (BAN006.Anulado='N') AND
                BAN006.Cod_Banco>='".$cod_banco_d."' AND BAN006.Cod_Banco<='".$cod_banco_h."' AND
                BAN006.num_cheque>='".$num_cheque_d."' AND BAN006.num_cheque<='".$num_cheque_h."' AND
                BAN006.Ced_Rif>='".$cedula_d."' AND BAN006.Ced_Rif<='".$cedula_h."' AND
                BAN006.Fecha>='".$fecha_desde."' AND BAN006.Fecha<='".$fecha_hasta."' AND  ".$criterios.				
                "ORDER BY BAN036.Cod_Banco, BAN006.Fecha, substring(ban036.num_cheque,3,6), BAN006.num_cheque ";
				
				
    if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php"); 
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Cheques_Retenciones.xml");
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("localhost");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1));
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
			function Header(){ global $tam_logo;  global $criterio1; global $cod_banco_grupo; global $nombre_banco_grupo; global $nro_cuenta_grupo;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(150,10,'REPORTE RELACION CHEQUES/RETENCIONES',1,0,'C');
				$this->Ln(20);
				$this->SetFont('Arial','B',8);
				$this->Cell(100,5,$criterio1,0,1,'L');				
				$this->Cell(260,5,"BANCO: ".$cod_banco_grupo." ".$nombre_banco_grupo."  ".$nro_cuenta_grupo,0,1,'L');
				$this->SetFont('Arial','B',7);
				$this->Cell(15,5,'FECHA',1,0);
				$this->Cell(15,5,'CHEQUE',1,0,'C');
				$this->Cell(15,5,'ORDEN',1,0,'C');	
				$this->Cell(95,5,'BENEFICIARIO',1,0,'L');					
				$this->Cell(20,5,'MONTO',1,0,'R');
				$this->Cell(20,5,'RET. ISLR',1,0,'R');	
				$this->Cell(20,5,'RET. IVA',1,0,'R');
				$this->Cell(20,5,'RET. 1X1000',1,0,'R');			
				$this->Cell(20,5,'RET OTROS',1,0,'R');
				$this->Cell(20,5,'IMP. BANCOS',1,1,'R');	
		
			}
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-10);
				$this->SetFont('Arial','I',5);
				$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
				$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			}
		  }		  
		  $pdf=new PDF('L', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $total1=0; $total2=0; $total3=0; $total4=0; $total5=0; $total6=0; $prev_cod_banco=""; 
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $nombre_banco=utf8_decode($registro["nombre_banco"]); $nro_cuenta=$registro["nro_cuenta"];
		       $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta;
			   if($prev_cod_banco<>$cod_banco_grupo){ 
			     $pdf->SetFont('Arial','B',7); 
			     if(($total1>0)or($total2>0)or($total3>0)or($total4>0)or($total5>0)or($total6>0)){ $total1=formato_monto($total1); $total2=formato_monto($total2); $total3=formato_monto($total3); $total4=formato_monto($total4); $total5=formato_monto($total5); $total6=formato_monto($total6);				    
				    $pdf->Cell(140,2,'',0,0);
					$pdf->Cell(20,2,'--------------------',0,0,'R');
					$pdf->Cell(20,2,'--------------------',0,0,'R');
					$pdf->Cell(20,2,'--------------------',0,0,'R');
					$pdf->Cell(20,2,'--------------------',0,0,'R');
					$pdf->Cell(20,2,'--------------------',0,0,'R');
					$pdf->Cell(20,2,'--------------------',0,1,'R');
					$pdf->Cell(140,5,"Total : ",0,0,'R');
					$pdf->Cell(20,5,$total1,0,0,'R');
					$pdf->Cell(20,5,$total2,0,0,'R');
					$pdf->Cell(20,5,$total3,0,0,'R');
					$pdf->Cell(20,5,$total4,0,0,'R');
					$pdf->Cell(20,5,$total5,0,0,'R');   
					$pdf->Cell(20,5,$total6,0,1,'R'); 
					$pdf->AddPage();					
				 }			 
				 $pdf->SetFont('Arial','',7);	
				 $prev_cod_banco=$cod_banco_grupo; $total1=0; $total2=0; $total3=0; $total4=0; $total5=0; $total6=0; 
			   }

		       $num_cheque=$registro["num_cheque"]; $nro_orden=$registro["nro_orden"]; $ced_rif=$registro["ced_rif"]; $fechae=$registro["fechae"]; $nombre=$registro["nombre"];
			   $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
			   $entregado=$registro["entregado"]; $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"];
			   $monto_ord=$registro["monto_ord"]; $monto_ret1=$registro["monto_ret1"]; $monto_ret2=$registro["monto_ret2"]; $monto_ret3=$registro["monto_ret3"];
			   $monto_otros=$registro["monto_otros"]; $monto_ban=$registro["monto_ban"];
			   $total1=$total1+$monto_ord; $total2=$total2+$monto_ret1; $total3=$total3+$monto_ret2; $total4=$total4+$monto_ret3; $total5=$total5+$monto_otros; 
			   $total6=$total6+$monto_ban; $monto_ord=formato_monto($monto_ord); $monto_ret1=formato_monto($monto_ret1); $monto_ret2=formato_monto($monto_ret2); 				   $monto_ret3=formato_monto($monto_ret3); $monto_otros=formato_monto($monto_otros); $monto_ban=formato_monto($monto_ban);
			   if($php_os=="WINNT"){$nombre=$registro["nombre"]; }   else{$nombre=utf8_decode($nombre);}
			   $pdf->Cell(15,3,$fechae,0,0); 
			   $pdf->Cell(15,3,$num_cheque,0,0,'C'); 
			   $pdf->Cell(15,3,$nro_orden,0,0,'C');				   
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=95; 			   
			   $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,3,$monto_ord,0,0,'R');
			   $pdf->Cell(20,3,$monto_ret1,0,0,'R');
			   $pdf->Cell(20,3,$monto_ret2,0,0,'R');
			   $pdf->Cell(20,3,$monto_ret3,0,0,'R');
			   $pdf->Cell(20,3,$monto_otros,0,0,'R');
			   $pdf->Cell(20,3,$monto_ban,0,1,'R'); 
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$nombre."  ".$campo_str1."  ".$campo_str2,0); 
				
			} 
			$pdf->SetFont('Arial','B',7);
		        if(($total1>0)or($total2>0)or($total3>0)or($total4>0)or($total5>0)or($total6>0)){ $total1=formato_monto($total1); $total2=formato_monto($total2); $total3=formato_monto($total3); $total4=formato_monto($total4); $total5=formato_monto($total5); $total6=formato_monto($total6);	    
				$pdf->Cell(140,2,'',0,0);
				$pdf->Cell(20,2,'--------------------',0,0,'R');
				$pdf->Cell(20,2,'--------------------',0,0,'R');
				$pdf->Cell(20,2,'--------------------',0,0,'R');
				$pdf->Cell(20,2,'--------------------',0,0,'R');
				$pdf->Cell(20,2,'--------------------',0,0,'R');
				$pdf->Cell(20,2,'--------------------',0,1,'R');
				$pdf->Cell(140,5,"Total : ",0,0,'R'); 
				$pdf->Cell(20,5,$total1,0,0,'R'); 
				$pdf->Cell(20,5,$total2,0,0,'R'); 
				$pdf->Cell(20,5,$total3,0,0,'R'); 
				$pdf->Cell(20,5,$total4,0,0,'R'); 
				$pdf->Cell(20,5,$total5,0,0,'R'); 
				$pdf->Cell(20,5,$total6,0,1,'R'); 
				$pdf->Ln(10);
			}
			$pdf->Output();   
		}
    if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_Cheques_Retenciones.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE RELACION CHEQUES/RETENCIONES</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <strong><?	echo $criterio1?></strong></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Fecha</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Nro Cheque</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Nro Orden</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Beneficiario</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Ret. Islr</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Ret. Iva</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Ret. 1X1000</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Ret. Otros</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Imp. Banco</strong></td>
			 </tr>
		  <?  $i=0; $total1=0; $total2=0; $total3=0; $total4=0; $total5=0; $total6=0; $prev_cod_banco="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta;
			   if($prev_cod_banco<>$cod_banco_grupo){ 
			    if(($total1>0)or($total2>0)or($total3>0)or($total4>0)or($total5>0)or($total6>0)){ $total1=formato_monto($total1); $total2=formato_monto($total2); $total3=formato_monto($total3); $total4=formato_monto($total4); $total5=formato_monto($total5); $total6=formato_monto($total6);			
			     ?>	 				 
                   <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="right"></td>
			          <td width="400" align="left"></td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			      </tr>	
			      <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="400" align="right"><? echo "Total: "; ?></td>
					  <td width="100" align="right"><? echo $total1; ?></td>
					  <td width="100" align="right"><? echo $total2; ?></td>
					  <td width="100" align="right"><? echo $total3; ?></td>
					  <td width="100" align="right"><? echo $total4; ?></td>
					  <td width="100" align="right"><? echo $total5; ?></td>
					  <td width="100" align="right"><? echo $total6; ?></td>
			      </tr>	
			      <tr>
				      <td width="90" align="left"></td>
			      </tr>	
                  <?}  ?>	   
			      <tr>
				  <td width="100" align="left">'<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_banco; ?></td>
				  <td width="100" align="left" ><strong></strong></td>
				  <td width="100" align="left" ><strong></strong></td>
				  <td width="400" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $nombre_banco."    ".$nro_cuenta; ?></td>
			      </tr>
			     <? 					 
			    $prev_cod_banco=$cod_banco_grupo; $total1=0; $total2=0; $total3=0; $total4=0; $total5=0; $total6=0; }
		       $num_cheque=$registro["num_cheque"]; $nro_orden=$registro["nro_orden"]; $ced_rif=$registro["ced_rif"]; $fechae=$registro["fechae"]; $nombre=$registro["nombre"];
			   $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
			   $entregado=$registro["entregado"]; $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"];
			   $monto_ord=$registro["monto_ord"]; $monto_ret1=$registro["monto_ret1"]; $monto_ret2=$registro["monto_ret2"]; $monto_ret3=$registro["monto_ret3"];
			   $monto_otros=$registro["monto_otros"]; $monto_ban=$registro["monto_ban"];
			   $total1=$total1+$monto_ord; $total2=$total2+$monto_ret1; $total3=$total3+$monto_ret2; $total4=$total4+$monto_ret3; $total5=$total5+$monto_otros; 
			   $total6=$total6+$monto_ban; $monto_ord=formato_monto($monto_ord); $monto_ret1=formato_monto($monto_ret1); $monto_ret2=formato_monto($monto_ret2); 				   $monto_ret3=formato_monto($monto_ret3); $monto_otros=formato_monto($monto_otros); $monto_ban=formato_monto($monto_ban);
			   $nombre=conv_cadenas($nombre,0);
			   ?>	   
				<tr>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $fechae; ?></td>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $num_cheque; ?></td>
				   <td width="100" align="left">'<? echo $nro_orden; ?></td>
				   <td width="400" align="justify"><? echo $nombre."   ".$campo_str1."   ".$campo_str2; ?></td>
				   <td width="100" align="right"><? echo $monto_ord; ?></td>
				   <td width="100" align="right"><? echo $monto_ret1; ?></td>
				   <td width="100" align="right"><? echo $monto_ret2; ?></td>
				   <td width="100" align="right"><? echo $monto_ret3; ?></td>
				   <td width="100" align="right"><? echo $monto_otros; ?></td>
				   <td width="100" align="right"><? echo $monto_ban; ?></td>
				 </tr>
			   <? 		  
		  }
		  if(($total1>0)or($total2>0)or($total3>0)or($total4>0)or($total5>0)or($total6>0)){ $total1=formato_monto($total1); $total2=formato_monto($total2); $total3=formato_monto($total3); $total4=formato_monto($total4); $total5=formato_monto($total5); $total6=formato_monto($total6);	    
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="right">---------------</td>
			    <td width="100" align="right">---------------</td>
			    <td width="100" align="right">---------------</td>
			    <td width="100" align="right">---------------</td>
			    <td width="100" align="right">---------------</td>
			    <td width="100" align="right">---------------</td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right"></td>
			    <td width="400" align="right"><? echo "Total: "; ?></td>
			    <td width="100" align="right"><? echo $total1; ?></td>
			    <td width="100" align="right"><? echo $total2; ?></td>
			    <td width="100" align="right"><? echo $total3; ?></td>
			    <td width="100" align="right"><? echo $total4; ?></td>
			    <td width="100" align="right"><? echo $total5; ?></td>
			    <td width="100" align="right"><? echo $total6; ?></td>
			</tr>	
		  <? }					  
		  ?></table><?
    }
	$StrSQL = "DELETE FROM BAN036 Where (codigo_mov='".$cod_mov."')"; $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn);
}
?>
