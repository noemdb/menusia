<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$mcontrol=array (0,0,0,0,0,0,0,0,0,0); $fuente_d="00"; $fuente_h="99"; $fuente_d=$_GET["cod_fuented"];  $fuente_h=$_GET["cod_fuenteh"];
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$num_cheque_d=$_GET["num_cheque_d"];$num_cheque_h=$_GET["num_cheque_h"];$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$tipo_rep=$_GET["tipo_rep"];$Sql="";
$cod_presup_d=$_GET["cod_presup_d"]; $cod_presup_h=$_GET["cod_presup_h"];$criterio1="Fecha Desde: ".$fecha_d." Hasta: ".$fecha_h; $criterio2=""; $date = date("d-m-Y");$hora = date("H:i:s a");
if($fecha_d==""){$sfecha_d="2010-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{  $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} } 
   $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
   $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];}
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=7;   $formato=$formato_presup; $clave=$formato_presup;   $j=0;
   for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
   for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
   for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
   for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} }
   $a=$actual;  $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
   $pos=strrpos($cod_presup_d,"?"); if($pos===false){$en_d=0;}else{$en_d=1;} $pos=strrpos($cod_presup_h,"?"); if($pos===false){$en_h=0;}else{$en_h=1;}   
   if(($en_d==1)or($en_h==1)){$codigo_d=str_replace("?","0",$cod_presup_d); $long_d=strlen($codigo_d); $codigo_h=str_replace("?","9",$cod_presup_h); $long_h=strlen($codigo_h);
	  if(($long_d=$long_u)and ($long_h=$long_u)){ $criterio=""; 
         for ($i=0; $i<10; $i++) { $m=$mcontrol[$i]; if($i==0){$a=0;}else{$a=$mcontrol[$i-1];}
		     if ($m<>0){if($i==0){ $len_nivel=$m; $criterio=""; }else{ $mpos=1+$a;  $len_nivel=($m-$a-1); $criterio=$criterio." and "; }
				$cod_d=substr($codigo_d,$mpos,$len_nivel); $cod_h=substr($codigo_h,$mpos,$len_nivel);$mpp=$mpos+1;
				$criterio=$criterio."substring(cod_presup,".$mpp.",".$len_nivel.")>='".$cod_d."' and "; $criterio=$criterio."substring(cod_presup,".$mpp.",".$len_nivel.")<='".$cod_h."' ";  }
	     } $criterio=$criterio."and  fuente_financ>='".$fuente_d."' and fuente_financ<='".$fuente_h."'";
	  }else{$criterio="cod_presup>='".$codigo_d."' and cod_presup<='".$codigo_h."' and  fuente_financ>='".$fuente_d."' and fuente_financ<='".$fuente_h."'";}
   }else{$criterio="cod_presup>='".$cod_presup_d."' and cod_presup<='".$cod_presup_h."' and  fuente_financ>='".$fuente_d."' and fuente_financ<='".$fuente_h."'";}
  
  
       $sSQL = "SELECT BAN004.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN004.Referencia, BAN004.Tipo_Mov_Libro, BAN004.Fecha_Mov_Libro, BAN004.Descrip_Mov_Libro, BAN004.Anulado, BAN004.Monto_Mov_Libro*-1 as monto_mov_anu,
                BAN004.Fecha_Anulado, BAN004.Monto_Mov_Libro, PRE008.Tipo_Pago, PRE038.Cod_Presup, PRE038.fuente_financ, PRE022.Denominacion_P, PRE038.Monto, PRE099.Ced_Rif, PRE099.Nombre, to_char(BAN004.Fecha_Mov_Libro,'DD/MM/YYYY') as fecham, text(BAN004.Referencia)||text(BAN004.Tipo_Mov_Libro) as ref_grupo
                FROM BAN002, BAN004, PRE022, PRE008, PRE038, PRE099
                WHERE (BAN004.Cod_Banco = BAN002.Cod_Banco) AND (PRE022.Cod_Presup_P = PRE038.Cod_Presup) AND (PRE022.cod_fuente_p=PRE038.fuente_financ) AND
                (PRE008.Ced_Rif = PRE099.Ced_Rif) AND (BAN004.Referencia = PRE008.Referencia_Pago) AND (BAN004.Fecha_Mov_Libro = PRE008.Fecha_Pago) AND
                (BAN004.Cod_Banco = PRE008.Cod_Banco) AND (BAN004.Tipo_Mov_Libro=PRE008.Tipo_pago_b) AND (pre038.referencia_pago=pre008.referencia_pago) AND (pre038.tipo_pago=pre008.tipo_pago) AND
				(pre008.referencia_comp=pre038.referencia_comp) and (pre008.tipo_compromiso=pre038.tipo_compromiso) and (pre008.referencia_caus=pre038.referencia_caus) and (pre008.tipo_causado=pre038.tipo_causado) and
                (pre038.Cod_Banco = PRE008.Cod_Banco) AND ((BAN004.Tipo_Mov_Libro='CHQ') OR (BAN004.Tipo_Mov_Libro='ANU'))  AND (PRE038.Monto<>0) AND 
				BAN004.Cod_Banco>='".$cod_banco_d."' AND  BAN004.Cod_Banco<='".$cod_banco_h."'  AND BAN004.Referencia>='".$num_cheque_d."' AND BAN004.Referencia<='".$num_cheque_h."' AND PRE008.Ced_Rif>='".$cedula_d."' AND PRE008.Ced_Rif<='".$cedula_h."'   AND 
				BAN004.Fecha_Mov_Libro>='".$sfecha_d."' AND BAN004.Fecha_Mov_Libro<='".$sfecha_h."'  AND  ".$criterio."  ORDER BY BAN004.Cod_Banco, BAN004.Fecha_Mov_Libro, BAN004.Referencia, BAN004.Tipo_Mov_Libro desc";
				
		//PRE038.Cod_Presup>='".$cod_presup_d."' AND PRE038.Cod_Presup<='".$cod_presup_h."'
               
	if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Relacion_Cheque_Cod_Presup.xml");
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
			function Header(){ global $tam_logo;  global $criterio1; global $cod_banco_grupo; global $nombre_banco_grupo; global $nro_cuenta_grupo; global $criterio1; 
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(30);
				$this->Cell(150,10,'RELACION CHEQUES / CODIGOS PRESUPUESTARIO',1,0,'C');
				$this->Ln(18);
				$this->SetFont('Arial','B',8);		
				$this->Cell(200,5,$criterio1,0,1,'L');				
                $this->Cell(200,5,$cod_banco_grupo." ".$nombre_banco_grupo."     ".$nro_cuenta_grupo,0,1,'L');
				$this->SetFont('Arial','B',7);
				$this->Cell(15,5,'CHEQUE',1,0);
				$this->Cell(15,5,'FECHA',1,0,'C');	
				$this->Cell(150,5,'BENEFICIARIO',1,0,'L');
				$this->Cell(20,5,'MONTO',1,1,'R');   
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
		  $i=0;  $totalm=0; $totalc=0; $sub_total1=0;  $sub_total2=0;  $prev_cod_banco="";  $prev_nombre_banco=""; $prev_nro_cuenta=""; $prev_referencia=""; 
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"];  $nro_cuenta=$registro["nro_cuenta"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"];
		       $referencia=$registro["referencia"]; $fecham=$registro["fecham"];   $monto_mov_libro=$registro["monto_mov_libro"]; $descrip_mov_libro=$registro["descrip_mov_libro"]; $ref_grupo=$registro["ref_grupo"];
			   if($php_os=="WINNT"){$nombre_banco=$nombre_banco; }	 else{ $nombre_banco=utf8_decode($nombre_banco); $descrip_mov_libro=utf8_decode($descrip_mov_libro); $nombre_banco=utf8_decode($nombre_banco); }	
		       $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; $referencia_grupo=$referencia; $fecham_grupo=$fecham; 
		       $descrip_mov_libro_grupo=$descrip_mov_libro; $monto_mov_libro_grupo=$monto_mov_libro; 
			   $nombre_grupo=$nombre; $ced_rif_grupo=$ced_rif; 

			   if($prev_cod_banco<>$cod_banco_grupo){ 
			     $pdf->SetFont('Arial','B',7); 
			     if(($sub_total1>0)or($sub_total2>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2);						    
				    $pdf->Cell(160,2,'',0,0);
					$pdf->Cell(20,2,'--------------------',0,0,'R');
					$pdf->Cell(20,2,'--------------------',0,1,'R');
					$pdf->Cell(160,5,"Total Banco: ".$prev_cod_banco."    ".$prev_nombre_banco."    ".$prev_nro_cuenta,0,0,'R'); 
					$pdf->Cell(20,5,$sub_total1,0,0,'R'); 
					$pdf->Cell(20,5,$sub_total2,0,1,'R'); 
					$pdf->AddPage();					
				 }		 
				 $pdf->SetFont('Arial','',7);	$prev_referencia=""; 
				 $prev_cod_banco=$cod_banco_grupo; $prev_nombre_banco=$nombre_banco_grupo;  $prev_nro_cuenta=$nro_cuenta_grupo; $sub_total1=0; $sub_total2=0;
			   }
			   if($prev_referencia<>$ref_grupo){ $monto_mov_libro_grupo=$registro["monto_mov_libro"];  if($registro["tipo_mov_libro"]=="CHQ"){$monto_mov_libro_grupo=$monto_mov_libro_grupo;}else{$monto_mov_libro_grupo=$monto_mov_libro_grupo*-1;} 
			      $sub_total2=$sub_total2+$monto_mov_libro_grupo; $totalm=$totalm+$monto_mov_libro_grupo;  $monto_mov_libro_grupo=formato_monto($monto_mov_libro_grupo);
				  if($prev_referencia<>''){$pdf->Ln(2);}
				  $pdf->Cell(15,3,$referencia_grupo,0,0);
				  $pdf->Cell(15,3,$fecham_grupo,0,0,'C');
			      $x=$pdf->GetX();   $y=$pdf->GetY(); $n=150;
				  $pdf->SetXY($x+$n,$y);
				  $pdf->Cell(20,3,$monto_mov_libro_grupo,0,1,'R'); 
			      $pdf->SetXY($x,$y);
			      $pdf->MultiCell($n,3,$ced_rif_grupo.' '.$nombre_grupo,0);
				  $pdf->MultiCell(200,3,$descrip_mov_libro_grupo,0);
                  $pdf->Cell(5,3,'',0,0);				  
				  $pdf->Cell(35,3,'Codigo Presupuestario',0,0,'L');
				  $pdf->Cell(120,3,'Denominacion',0,0,'L');
				  $pdf->Cell(20,3,'Monto',0,0,'R');
				  $pdf->Cell(20,3,'',0,1);
				  $pdf->Cell(5,3,'',0,0);
				  $pdf->Cell(90,2,'-------------------------------------------------------------------------------------------------------------------------------',0,0,'L');
				  $pdf->Cell(80,2,'----------------------------------------------------------------------------------------------------------',0,1,'L');
				  $pdf->SetFont('Arial','',7);	
				  $prev_referencia=$ref_grupo; 
			   }
		       $descrip_mov_libro=$registro["descrip_mov_libro"]; $num_cheque=$registro["referencia"];  
			   $nombre=$registro["nombre"]; $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $fecham=$registro["fecham"]; $referencia=$registro["referencia"]; $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion_p=$registro["denominacion_p"]; 
		       $monto_mov_libro=$registro["monto_mov_libro"]; $monto=$registro["monto"];  $sub_total1=$sub_total1+$monto; $totalc=$totalc+$monto; 
			   $monto=formato_monto($monto);  $monto_mov_libro=formato_monto($monto_mov_libro);
			   if($php_os=="WINNT"){$denominacion_p=$denominacion_p; }else{$denominacion_p=utf8_decode($denominacion_p);} 
               $pdf->Cell(5,3,'',0,0);	 			   
			   $pdf->Cell(40,3,$cod_presup." ".$fuente_financ,0,0,'L'); 				   
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=120; 
			   $pdf->SetXY($x+$n,$y);
               $pdf->Cell(20,3,$monto,0,0,'R'); 
               $pdf->Cell(15,3,'',0,1,'');
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$denominacion_p,0); 
				
			} $totalm=formato_monto($totalm); $totalc=formato_monto($totalc);
			$pdf->SetFont('Arial','B',7);
			if(($sub_total1>0)or($sub_total2>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2);				    
				$pdf->Cell(160,2,'',0,0);
				$pdf->Cell(20,2,'--------------------',0,0,'R');
				$pdf->Cell(20,2,'--------------------',0,1,'R');
				$pdf->Cell(160,5,"Total Banco: ".$cod_banco_grupo."    ".$nombre_banco."    ",0,0,'R'); 
				$pdf->Cell(20,5,$sub_total1,0,0,'R');
				$pdf->Cell(20,5,$sub_total2,0,1,'R');  
				$pdf->Ln(10);
			} 
			$pdf->Cell(160,2,'',0,0);
			$pdf->Cell(20,2,'==============',0,0,'R');
			$pdf->Cell(20,2,'==============',0,1,'R');
			$pdf->Cell(160,5,'TOTAL GENERAL: ',0,0,'R');
			$pdf->Cell(20,5,$totalc,0,0,'R'); 
			$pdf->Cell(20,5,$totalm,0,1,'R'); 
			$pdf->Output();   
		}
    if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_Relacion_Cheque_Cod_Presup.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="200" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RELACION CHEQUES / CODIGOS PRESUPUESTARIO</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="200" align="left" ><strong></strong></td>
				<td width="400" align="center" > <strong><?	echo $criterio1?></strong></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Cheque</strong></td>
			   <td width="200" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong></strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto</strong></td>
			 </tr>
		  <?  $i=0;   $totalm=0; $totalc=0; $sub_total1=0;  $sub_total2=0;  $prev_cod_banco="";  $prev_referencia="";  $prev_nombre_banco=""; $prev_nro_cuenta=""; $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $referencia=$registro["referencia"]; $fecham=$registro["fecham"]; $descrip_mov_libro=$registro["descrip_mov_libro"]; 
		       $monto_mov_libro=$registro["monto_mov_libro"]; $ref_grupo=$registro["ref_grupo"]; $nombre_banco=conv_cadenas($nombre_banco,0); $descrip_mov_libro=conv_cadenas($descrip_mov_libro,0); 
		       $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; $referencia_grupo=$referencia; $fecham_grupo=$fecham; 
		       $descrip_mov_libro_grupo=$descrip_mov_libro; $monto_mov_libro_grupo=$monto_mov_libro; 
			   if($prev_cod_banco<>$cod_banco_grupo){ 
			    if(($sub_total1>0)or($sub_total2>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2);	
			     ?>	 				 
                   	<tr>
			          <td width="100" align="left"></td>
				      <td width="200" align="left"></td>
			          <td width="400" align="left"></td>
				      <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			      </tr>	
			      <tr>
			          <td width="100" align="left"></td>
				      <td width="200" align="left"></td>
			          <td width="400" align="right"><? echo "Total Banco: ".$prev_cod_banco."    ".$prev_nombre_banco."    ".$prev_nro_cuenta; ?></td>
				      <td width="100" align="right"><? echo $sub_total1; ?></td>
				      <td width="100" align="right"><? echo $sub_total2; ?></td>
			      </tr>	
			      <tr>
				      <td width="100" align="left"></td>
			      </tr>	
                  <?} ?>	   
			      <tr>
				  <td width="100" align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>'<? echo $cod_banco; ?></strong></td>
				  <td width="200" align="left"></td>
		          <td width="400" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $nombre_banco."    ".$nro_cuenta; ?></strong></td>
			      </tr>
			     <? 					 
			    $prev_cod_banco=$cod_banco_grupo; $prev_nombre_banco=$nombre_banco_grupo; $prev_nro_cuenta=$nro_cuenta_grupo; $sub_total1=0; $sub_total2=0; $prev_referencia=""; }

			   if($prev_referencia<>$ref_grupo){ $monto_mov_libro_grupo=$registro["monto_mov_libro"];  if($registro["tipo_mov_libro"]=="CHQ"){$monto_mov_libro_grupo=$monto_mov_libro_grupo;}else{$monto_mov_libro_grupo=$monto_mov_libro_grupo*-1;} 
			      $sub_total2=$sub_total2+$monto_mov_libro_grupo; $totalm=$totalm+$monto_mov_libro_grupo; $monto_mov_libro_grupo=formato_monto($monto_mov_libro_grupo);
			      ?>
                  <tr>
				      <td width="100" align="left"></td>
			      </tr>					  
			      <tr>
					  <td width="100" align="left">'<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $referencia; ?></td>
					  <td width="200" align="left"><? echo $fecham; ?></td>
					  <td width="400" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $descrip_mov_libro; ?></td>
					  <td width="100" align="left"></td>
					  <td width="100" align="right"><? echo $monto_mov_libro; ?></td>
			      </tr>	
			      <tr>
					<td width="100" align="right"><strong></strong></td>
					<td width="200" align="left"><strong>Codigo Presupuestario</strong></td>
					<td width="400" align="left"><strong>Denominacion</strong></td>
					<td width="100" align="right"><strong>Monto</strong></td>
			      </tr>	
			     <? 					 
			    $prev_referencia=$ref_grupo;}
			    $descrip_mov_libro=$registro["descrip_mov_libro"]; $num_cheque=$registro["referencia"];  
			    $nombre=$registro["nombre"]; $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		        $fecham=$registro["fecham"]; $referencia=$registro["referencia"]; $cod_presup=$registro["cod_presup"]; $denominacion_p=$registro["denominacion_p"]; 
		        $monto_mov_libro=$registro["monto_mov_libro"]; $monto=$registro["monto"];   $sub_total1=$sub_total1+$monto; $totalc=$totalc+$monto; 
			    $monto=formato_monto($monto);   $denominacion_p=conv_cadenas($denominacion_p,0);		   
			   
			   ?>	   
				<tr>
				   <td width="100" align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"></td>
				   <td width="200" align="left"><? echo $cod_presup." ".$fuente_financ; ?></td>
				   <td width="400" align="justify"><? echo $denominacion_p; ?></td>
				   <td width="100" align="right"><? echo $monto; ?></td>
				 </tr>
			      
			   <? 		  
		  }
		  if(($sub_total1>0)or($sub_total2>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2);
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="200" align="left"></td>
			    <td width="400" align="left"></td>
		        <td width="100" align="right">---------------</td>
			    <td width="100" align="right">---------------</td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="200" align="left"></td>
			    <td width="400" align="right"><? echo "Total Banco: ".$prev_cod_banco."    ".$prev_nombre_banco."    ".$prev_nro_cuenta; ?></td>
			    <td width="100" align="right"><? echo $sub_total1; ?></td>
			    <td width="100" align="right"><? echo $sub_total2; ?></td>
			</tr>	
		   <? } ?>
		   <tr>
				<td width="100" align="left"></td>
		   </tr>
		   <tr>
			    <td width="100" align="left"></td>
			    <td width="200" align="left"></td>
			    <td width="400" align="left"></td>
		        <td width="100" align="right">=============</td>
			    <td width="100" align="right">=============</td>
			</tr>
            <tr>
			    <td width="100" align="left"></td>
			    <td width="200" align="left"></td>
			    <td width="400" align="right"><strong>TOTAL GENERAL</strong></td>
			    <td width="100" align="right"><? echo $totalc; ?></td>
			    <td width="100" align="right"><? echo $totalm; ?></td>
			</tr>				
		  
		  </table><?
    }
}
?>

