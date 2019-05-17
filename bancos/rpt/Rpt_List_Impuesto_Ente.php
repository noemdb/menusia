<? error_reporting(E_ALL ^ E_NOTICE);include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php");  include ("../../class/configura.inc"); 
$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$tipo_planilla_d=$_GET["tipo_planilla_d"];$tipo_planilla_h=$_GET["tipo_planilla_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$tasa_d=$_GET["tasa_d"];$tasa_h=$_GET["tasa_h"];$tipo_rpt=$_GET["tipo_rep"];$Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';}  $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';}  $fecha_hasta=$ano1.$mes1.$dia1;
$criterio1="Fecha Enterado Desde: ".$fecha_d." Al: ".$fecha_h; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
     $sSQL = "SELECT BAN013.Nro_Planilla, BAN012.Cod_Banco, BAN012.Tipo_Mov, BAN012.Referencia, BAN012.Fecha_Emision,
                BAN012.Tipo_Planilla, BAN012.Monto_Objeto, BAN012.Tasa, BAN012.Monto_Retencion, BAN013.Fecha_Enterado,
                BAN013.Nombre_Banco_Ent, BAN012.Ced_Rif, PRE099.Nombre, to_char(BAN012.Fecha_Emision,'DD/MM/YYYY') as fechae,
                to_char(BAN013.Fecha_Enterado,'DD/MM/YYYY') as fechaent FROM BAN012, BAN013, PRE099
                WHERE BAN012.Tipo_Planilla = BAN013.Tipo_Planilla AND   BAN012.Nro_Planilla = BAN013.Nro_Planilla AND
                BAN012.Ced_Rif = PRE099.Ced_Rif AND  BAN012.Ced_Rif>='".$cedula_d."' AND BAN012.Ced_Rif<='".$cedula_h."' AND
                BAN012.Tipo_Planilla>='".$tipo_planilla_d."' AND BAN012.Tipo_Planilla<='".$tipo_planilla_h."' AND
                BAN013.Fecha_Enterado>='".$fecha_desde."' AND BAN013.Fecha_Enterado<='".$fecha_hasta."' AND
                BAN012.Tasa>='".$tasa_d."' AND BAN012.Tasa<='".$tasa_h."'  ORDER BY BAN013.Fecha_Enterado, BAN013.Nro_Planilla";
    if($tipo_rpt=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Lis_Impuesto_Enterado.xml");
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
	if($tipo_rpt=="PDF"){ $res=pg_query($sSQL); $ced_rif_grupo=""; $nombre_grupo="";
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 	
		function Header(){ global $tam_logo;  global $criterio1; global $ced_rif_grupo; global $nombre_grupo; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(30);
			$this->Cell(150,10,'LISTADO DE IMPUESTO ENTERADO',1,0,'C');
			$this->Ln(18);
			$this->SetFont('Arial','B',8);
			$this->Cell(100,5,$criterio1,0,1,'L');
			$this->SetFont('Arial','B',6);
			$this->Cell(18,5,'NRO PLANILLA',1,0,'L');
			$this->Cell(10,5,'BANCO',1,0,'L');
			$this->Cell(7,5,'MOV',1,0,'L');
			$this->Cell(15,5,'REFERENCIA',1,0,'L');
			$this->Cell(18,5,'FECHA EMISION',1,0,'C');
			$this->Cell(7,5,'TIPO',1,0,'C');
			$this->Cell(20,5,'MONTO OBJETO',1,0,'R');
			$this->Cell(8,5,'TASA',1,0,'R');
			$this->Cell(22,5,'MONTO RETENCION',1,0,'R');
			$this->Cell(20,5,'FEC ENTERADO',1,0,'R');
			$this->Cell(55,5,'NOMBRE BANCO',1,1,'L');
			$this->SetFont('Arial','B',7);
            //if($ced_rif_grupo<>""){ 
			//	$this->Cell(12,5,"Ced/Rif:",0,0,'L');
            //    $this->Cell(18,5,$ced_rif_grupo,0,0,'L'); 	
			//	$this->Cell(12,5,"Nombre:",0,0,'L');
            //    $this->Cell(158,5,$nombre_grupo,0,1,'L');
			//}

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
	  $i=0;  $total=0; $sub_total1=""; $sub_total2=""; $cantidad=0; $prev_ced_rif=""; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $ced_rif=$registro["ced_rif"];  
		   if($php_os=="WINNT"){$nombre=$registro["nombre"];} else{$nombre=utf8_decode($registro["nombre"]);}
		   $ced_rif_grupo=$ced_rif;  $nombre_grupo=$nombre;  
		   if($prev_ced_rif<>$ced_rif_grupo){ 
			    $pdf->SetFont('Arial','B',7); 
			    if(($sub_total1<>0)or($sub_total2<>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2);					    
				    $pdf->Cell(75,2,'',0,0);
					$pdf->Cell(20,2,'-----------------',0,0,'R');
					$pdf->Cell(8,2,'',0,0,'R');
					$pdf->Cell(22,2,'-----------------',0,1,'R');
					
					$pdf->Cell(75,5,"SUB-TOTAL : ",0,0,'R'); 
					$pdf->Cell(20,5,$sub_total1,0,0,'R'); 
					$pdf->Cell(8,5,'',0,0,'R'); 
					$pdf->Cell(22,5,$sub_total2,0,1,'R'); 
					$pdf->Ln(5);	
					}
					$pdf->Cell(12,5,"Ced/Rif:",0,0,'L');
					$pdf->Cell(18,5,$ced_rif_grupo,0,0,'L'); 	
					$pdf->Cell(12,5,"Nombre:",0,0,'L');
					$pdf->Cell(158,5,$nombre_grupo,0,1,'L');
				 	$pdf->SetFont('Arial','',7);	
					$prev_ced_rif=$ced_rif_grupo; $sub_total1=0; $sub_total2=0;
			}
		   $nro_planilla=$registro["nro_planilla"]; $fecha_emision=$registro["fecha_emision"]; $referencia=$registro["referencia"]; $fecha_enterado=$registro["fecha_enterado"];
		   $cod_banco=$registro["cod_banco"]; $ced_rif=$registro["ced_rif"]; $tipo_mov=$registro["tipo_mov"]; $tipo_planilla=$registro["tipo_planilla"]; 
		   $nombre_banco_ent=$registro["nombre_banco_ent"]; $monto_objeto=$registro["monto_objeto"]; $tasa=$registro["tasa"]; $monto_retencion=$registro["monto_retencion"];
		   $sub_total1=$sub_total1+$monto_objeto; $sub_total2=$sub_total2+$monto_retencion;
		   $monto_retencion=formato_monto($monto_retencion); $fecha_emision=formato_ddmmaaaa($fecha_emision); $fecha_enterado=formato_ddmmaaaa($fecha_enterado);
		   $monto_objeto=formato_monto($monto_objeto); $tasa=formato_monto($tasa);
		   if($php_os=="WINNT"){$nombre=$registro["nombre"];} else{$nombre=utf8_decode($registro["nombre"]);}
		   $pdf->Cell(18,3,$nro_planilla,0,0,'L'); 	
		   $pdf->Cell(10,3,$cod_banco,0,0,'C');
		   $pdf->Cell(7,3,$tipo_mov,0,0,'C');
		   $pdf->Cell(15,3,$referencia,0,0,'C');
		   $pdf->Cell(18,3,$fecha_emision,0,0,'C');
		   $pdf->Cell(7,3,$tipo_planilla,0,0,'C');    
		   $pdf->Cell(20,3,$monto_objeto,0,0,'R');  
		   $pdf->Cell(8,3,$tasa,0,0,'R');
		   $pdf->Cell(22,3,$monto_retencion,0,0,'R');
		   $pdf->Cell(20,3,$fecha_enterado,0,0,'C');
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=55; 	
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$nombre_banco_ent,0,1); 
		   

		} 
		$pdf->SetFont('Arial','B',7);
	       if(($sub_total1<>0)or($sub_total2<>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2);						    
			$pdf->Cell(75,2,'',0,0);
			$pdf->Cell(20,2,'-----------------',0,0,'R');
			$pdf->Cell(8,2,'',0,0,'R');
			$pdf->Cell(22,2,'-----------------',0,1,'R');
			$pdf->Cell(75,5,"SUB-TOTAL  : ",0,0,'R'); 
			$pdf->Cell(20,5,$sub_total1,0,0,'R'); 
			$pdf->Cell(8,5,'',0,0,'R'); 
			$pdf->Cell(22,5,$sub_total2,0,1,'R'); 
			$pdf->Ln(10);
		}
		$pdf->Output();   
    }
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Listado_Impuesto_Enterado.xls");	
	
	?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		     <td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
            <td width="200" align="center" > <font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO DE IMPUESTO ENTERADO</strong></font></td>
	     </tr>
		  <tr height="20">
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="200" align="center" > <strong><? echo $criterio1?></strong></td>
		 </tr> 
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>NRO PLANILLA</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>BANCO</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>MOV</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>REFERENCIA</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>FECHA EMISION</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>TIPO</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>MONTO OBJETO</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>TASA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>MONTO RETENCION</strong></font></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>FECHA ENTERADO</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>NOMBRE BANCO</strong></td>
         </tr>
     <?
	  
	  $i=0;  $total=0; $sub_total1=""; $sub_total2=""; $cantidad=0; $prev_ced_rif=""; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $ced_rif=$registro["ced_rif"];   $nombre=$registro["nombre"]; $nombre=conv_cadenas($nombre,0);
		   $ced_rif_grupo=$ced_rif;  $nombre_grupo=$nombre;  
		   if($prev_ced_rif<>$ced_rif_grupo){ 
			   if(($sub_total1<>0)or($sub_total2<>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2);
			     ?>	 				 
                  <tr>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right"></td>
			          <td width="100" align="right">---------------</td>
			      </tr>	
			      <tr>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left">SUB-TOTAL</td>
				      <td width="100" align="right"><? echo $sub_total1; ?></td>
				      <td width="100" align="right"></td>
				     <td width="100" align="right"><? echo $sub_total2; ?></td>
			      </tr>	
			      <tr>
				      <td width="100" align="left"></td>
			      </tr>	
               <?}?>	   
			      <tr>
				  <td width="100" align="left">Ced/Rif :</td>
				  <td width="100" align="left"><? echo $ced_rif; ?></td>
				  <td width="100" align="left">Nombre :</td>
				  <td width="200" align="left"><? echo $nombre; ?></td>
			      </tr>
			     <? 					 
			    $prev_ced_rif=$ced_rif_grupo; $sub_total1=0; $sub_total2=0;
			}					
			    
		   $nro_planilla=$registro["nro_planilla"]; $fecha_emision=$registro["fecha_emision"]; $referencia=$registro["referencia"]; $fecha_enterado=$registro["fecha_enterado"];
		   $cod_banco=$registro["cod_banco"]; $ced_rif=$registro["ced_rif"]; $tipo_mov=$registro["tipo_mov"]; $tipo_planilla=$registro["tipo_planilla"]; 
		   $nombre_banco_ent=$registro["nombre_banco_ent"]; $monto_objeto=$registro["monto_objeto"]; $tasa=$registro["tasa"]; $monto_retencion=$registro["monto_retencion"];
		   $sub_total1=$sub_total1+$monto_objeto; $sub_total2=$sub_total2+$monto_retencion;
		   $monto_retencion=formato_monto($monto_retencion); $fecha_emision=formato_ddmmaaaa($fecha_emision); $fecha_enterado=formato_ddmmaaaa($fecha_enterado);
		   $monto_objeto=formato_monto($monto_objeto); $tasa=formato_monto($tasa); $nombre=conv_cadenas($nombre,0);  
	    ?>	   
		   <tr>
                 <td width="100" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $nro_planilla; ?></td>
           		<td width="100" align="center">'<? echo $cod_banco; ?></td>
           		<td width="100" align="center">'<? echo $tipo_mov; ?></td>
           		<td width="100" align="center">'<? echo $referencia; ?></td>
           		<td width="100" align="center"><? echo $fecha_emision; ?></td>
           		<td width="100" align="center">'<? echo $tipo_planilla; ?></td>
           		<td width="100" align="right"><? echo $monto_objeto; ?></td>
           		<td width="100" align="right"><? echo $tasa; ?></td>
           		<td width="100" align="right"><? echo $monto_retencion; ?></td>
           		<td width="100" align="center"><? echo $fecha_enterado; ?></td>
           		<td width="400" align="left"><? echo $nombre_banco_ent; ?></td>

                   </tr>
	    <? 
	    }  
        if(($sub_total1<>0)or($sub_total2<>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2);
		  ?>	 				 
                  <tr>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right"></td>
			          <td width="100" align="right">---------------</td>
			      </tr>	
			      <tr>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left">SUB-TOTAL</td>
					  <td width="100" align="right"><? echo $sub_total1; ?></td>
					  <td width="100" align="right"></td>
					  <td width="100" align="right"><? echo $sub_total2; ?></td>
			      </tr>	
		  
		<?
		}
		?>	 				 

	  </table><?
        }
}
?>

