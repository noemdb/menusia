<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$tipo_mov_d=$_GET["tipo_mov_d"];$tipo_mov_h=$_GET["tipo_mov_h"];$referencia_d=$_GET["referencia_d"];$referencia_h=$_GET["referencia_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"]; $tipo_rep=$_GET["tipo_rep"]; $Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");
$criterio1=""; $criterio2=""; $mcod_m="BAN08B".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';}$fecha_d=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';}$fecha_h=$ano1.$mes1.$dia1;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} } 
 $Sql="delete from ban038 where codigo_mov='".$codigo_mov."'";   $resultado=pg_exec($conn,$Sql);
 $Sql="insert into ban038 select '".$codigo_mov."',ban008.cod_banco,ban008.referencia,ban008.tipo_trans_banco,ban008.fecha_trans_banco,ban008.monto_trans_banco,ban008.mes_conciliacion,ban008.bene_mov_trans_banco,ban008.inf_usuario,ban008.monto_trans_banco,0,0,0,0,'','',ban008.des_mov_trans_banco FROM ban008,ban003 where ban008.tipo_trans_banco=ban003.tipo_movimiento AND ban003.Tipo='D'"; $resultado=pg_exec($conn,$Sql);
 $Sql="insert into ban038 select '".$codigo_mov."',ban008.cod_banco,ban008.referencia,ban008.tipo_trans_banco,ban008.fecha_trans_banco,ban008.monto_trans_banco,ban008.mes_conciliacion,ban008.bene_mov_trans_banco,ban008.inf_usuario,0,ban008.monto_trans_banco,0,0,0,'','',ban008.des_mov_trans_banco FROM ban008,ban003 where ban008.tipo_trans_banco=ban003.tipo_movimiento AND ban003.Tipo='C'"; $resultado=pg_exec($conn,$Sql);

 $sSQL = "SELECT ban038.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, ban038.Tipo_Trans_Banco, ban038.Referencia, ban038.Fecha_Trans_Banco, ban038.Monto_Trans_Banco, BAN003.Tipo, ban038.columna1, ban038.columna2,
          ban038.Bene_Mov_Trans_Banco, to_char(ban038.Fecha_Trans_Banco,'DD/MM/YYYY') as fecham  FROM BAN002, BAN003, ban038 WHERE ban038.codigo_mov='".$codigo_mov."' AND
          BAN002.Cod_Banco = ban038.Cod_Banco AND ban038.Tipo_Trans_Banco = BAN003.Tipo_Movimiento AND	 BAN002.Cod_Banco>='".$cod_banco_d."' AND BAN002.Cod_Banco<='".$cod_banco_h."' AND
          ban038.Tipo_Trans_Banco>='".$tipo_mov_d."' AND ban038.Tipo_Trans_Banco<='".$tipo_mov_h."' AND  ban038.Referencia>='".$referencia_d."' AND ban038.Referencia<='".$referencia_h."' AND
          ban038.Fecha_Trans_Banco>='".$fecha_d."' AND ban038.Fecha_Trans_Banco<='".$fecha_h."'   ORDER BY ban038.Cod_Banco, ban038.Fecha_Trans_Banco, ban038.Referencia";
             
	 if($tipo_rep=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");	 
			 $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Movimientos_Transito_Bancos.xml");
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
              $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run();
	}


    if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_banco_grupo="0000"; $nombre_banco_grupo=""; $nro_cuenta_grupo="00000000"; 
	      if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		  if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);} $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; }
		  
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $tam_logo; global $criterio1; global $cod_banco_grupo; global $nombre_banco_grupo; global $nro_cuenta_grupo; 
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(120,10,'MOVIMIENTOS EN TRANSITO BANCOS',1,0,'C');
				$this->Ln(18);
				$this->SetFont('Arial','B',9);
				$this->Cell(200,5,$criterio1,0,1,'L');				
                $this->Cell(200,5,$cod_banco_grupo." ".$nombre_banco_grupo."     ".$nro_cuenta_grupo,0,1,'L');
				$this->SetFont('Arial','B',8);
			    $this->Cell(10,5,'TIPO',1,0);
			    $this->Cell(20,5,'REFERENCIA',1,0,'C');						
			    $this->Cell(20,5,'FECHA',1,0,'C');
			    $this->Cell(110,5,'BENEFICIARIO',1,0,'L');
			    $this->Cell(20,5,'DEBITOS',1,0,'C');
			    $this->Cell(20,5,'CREDITOS',1,1,'C');	
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
		  $pdf->SetFont('Arial','',8);
		  $i=0;  $totald=0; $totalh=0; $prev_cod_banco="";  
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);}$cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; 
               $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; 
			   if($prev_cod_banco<>$cod_banco_grupo){ 
			     $pdf->SetFont('Arial','B',8); 
			     if(($totald>0)or($totalh>0)){ $totald=formato_monto($totald); $totalh=formato_monto($totalh); 						    
				    $pdf->Cell(160,2,'',0,0);
					$pdf->Cell(20,2,'------------------',0,0,'R');
					$pdf->Cell(20,2,'------------------',0,1,'R');
					$pdf->Cell(160,5,"Total : ".$prev_cod_banco,0,0,'R'); 
					$pdf->Cell(20,5,$totald,0,0,'R'); 
					$pdf->Cell(20,5,$totalh,0,1,'R'); 
					$pdf->AddPage();					
				 }			 
				 $pdf->SetFont('Arial','',8);	
				 $prev_cod_banco=$cod_banco_grupo; $totald=0; $totalh=0;
			   }

		       $tipo_trans_banco=$registro["tipo_trans_banco"]; $referencia=$registro["referencia"]; $desc_trans_libro=$registro["desc_trans_libro"]; $fecham=$registro["fecham"]; 
			   $nombre=$registro["nombre"]; $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $bene_mov_trans_banco=$registro["bene_mov_trans_banco"];
			   $columna1=$registro["columna1"]; $columna2=$registro["columna2"]; $saldo_anterior=$registro["columna3"]; $columna4=$registro["columna4"]; 
			   $totald=$totald+$columna1; $totalh=$totalh+$columna2;   $columna1=formato_monto($columna1); 	$columna2=formato_monto($columna2);  $columna4=formato_monto($columna4); 
			   if($php_os=="WINNT"){$desc_trans_libro=$registro["desc_trans_libro"]; }else{ $bene_mov_trans_banco=utf8_decode($bene_mov_trans_banco); $desc_trans_libro=utf8_decode($desc_trans_libro);}		   
			   $pdf->Cell(10,3,$tipo_trans_banco,0,0); 
			   $pdf->Cell(20,3,$referencia,0,0,'C'); 
			   $pdf->Cell(20,3,$fecham,0,0,'C'); 				   
		   	   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=110; 
		       $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,3,$columna1,0,0,'R');
               $pdf->Cell(20,3,$columna2,0,1,'R'); 
		   	   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$bene_mov_trans_banco,0);  
			} 
			$pdf->SetFont('Arial','B',8);
			if(($totald>0)or($totalh>0)){ $totald=formato_monto($totald); $totalh=formato_monto($totalh); 						    
				$pdf->Cell(160,2,'',0,0);
				$pdf->Cell(20,2,'------------------',0,0,'R');
				$pdf->Cell(20,2,'------------------',0,1,'R');
				$pdf->Cell(160,5,"Total : ".$prev_cod_banco,0,0,'R');  
				$pdf->Cell(20,5,$totald,0,0,'R'); 
				$pdf->Cell(20,5,$totalh,0,1,'R'); 
				$pdf->Ln(10);
			}			
			$pdf->Output(); 
	}
	if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_Movimientos_Transito_Bancos.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>MOVIMIENTOS EN TRANSITO BANCOS</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <strong><?	$criterio1?></strong></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Tipo</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Beneficiario</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Debitos</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Creditos</strong></td>
			 </tr>
		  <?  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_cod_banco=""; $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; $mes_mov_grupo=$mes_mov; 

			   if($prev_cod_banco<>$cod_banco_grupo){ 
			    if(($totald>0)or($totalh>0)){ $totald=formato_monto($totald); $totalh=formato_monto($totalh); 			
			     ?>	 				 
                    <tr>
			          <td width="100" align="left"></td>
					  <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="400" align="left"></td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			      </tr>	
			      <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="400" align="left"><? echo "Total: ".$prev_cod_banco; ?></td>
				      <td width="100" align="right"><? echo $totald; ?></td>
				      <td width="100" align="right"><? echo $totalh; ?></td>
			      </tr>	
			      <tr>
				  <td width="90" align="left"></td>
			      </tr>	
                <?}
			      ?>	   
			      <tr>
				    <td width="100" align="left">'<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_banco; ?></td>
				    <td width="100" align="left"></td>
			        <td width="100" align="left"></td>
				    <td width="400" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $nombre_banco."    ".$nro_cuenta; ?></td>
			      </tr>
			     <? 					 
			    $prev_cod_banco=$cod_banco_grupo; $totald=0; $totalh=0;}

		       $tipo_trans_banco=$registro["tipo_trans_banco"]; $referencia=$registro["referencia"]; $desc_trans_libro=$registro["desc_trans_libro"]; $fecham=$registro["fecham"]; 
			   $nombre=$registro["nombre"]; $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $bene_mov_trans_banco=$registro["bene_mov_trans_banco"];
			   $columna1=$registro["columna1"]; $columna2=$registro["columna2"]; $saldo_anterior=$registro["columna3"]; $columna4=$registro["columna4"]; 
			   $totald=$totald+$columna1; $totalh=$totalh+$columna2; 
			   $columna1=formato_monto($columna1); 	$columna2=formato_monto($columna2);  $columna4=formato_monto($columna4); 		   
			   $nombre=conv_cadenas($nombre,0);  $concepto=conv_cadenas($concepto,0);
			   ?>	   
				<tr>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $tipo_trans_banco; ?></td>
				   <td width="100" align="left">'<? echo $referencia; ?></td>
				   <td width="100" align="center"><? echo $fecham; ?></td>
				   <td width="400" align="justify"><? echo $bene_mov_trans_banco; ?></td>
				   <td width="100" align="right"><? echo $columna1; ?></td>
				   <td width="100" align="right"><? echo $columna2; ?></td>
				 </tr>
			   <? 		  
		  }

		  if(($totald>0)or($totalh>0)){ $totald=formato_monto($totald); $totalh=formato_monto($totalh); 
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="right">---------------</td>
			    <td width="100" align="right">---------------</td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"><? echo "Total: ".$cod_banco; ?></td>
			    <td width="100" align="right"><? echo $totald; ?></td>
			    <td width="100" align="right"><? echo $totalh; ?></td>
			</tr>	
		  <? }	  
		  ?></table><?
    }
	$Sql="delete from ban038 where codigo_mov='".$codigo_mov."'";   $resultado=pg_exec($conn,$Sql);
}
?>

