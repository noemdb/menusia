<?include ("../../class/fun_fechas.php"); include ("../../class/fun_numeros.php");include ("../../class/configura.inc");include ("../../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE); $php_os=PHP_OS;
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$referencia_d=$_GET["referencia_d"];$referencia_h=$_GET["referencia_h"];$tipo_asiento_d=$_GET["tipo_asiento_d"];$tipo_asiento_h=$_GET["tipo_asiento_h"];  $tipo_rep=$_GET["tipo_rep"]; $Sql="";
if($fecha_d==""){$sfecha_d="2010-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{   $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
    $Sql="SELECT ELIMINA_CON013('".$usuario_sia."','3')"; $resultado=pg_exec($conn,$Sql); $error=pg_errormessage($conn);   $error="ERROR INICIALIZANDO: ".substr($error, 0, 61);
    $Sql="SELECT RPT_FORMATO_COMP_CON013('".$usuario_sia."','3','".$sfecha_d."','".$sfecha_h."','".$referencia_d."','".$referencia_h."','".$tipo_asiento_d."','".$tipo_asiento_h."')";
    $resultado=pg_exec($conn,$Sql); $error=pg_errormessage($conn);   $error="ERROR GRABANDO: ".substr($error, 0, 61);

    $Sql= "select * from RPT_FORMATO WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='3' ORDER BY fecha, referencia, aoperacion";$sSQL = $Sql;

    if ($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Formato_Comprobante.xml");
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>"$criterio1","criterio2"=>"$criterio2"));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run();
             $aBench = $oRpt->getBenchmark();
             $iSec = $aBench["report_end"]-$aBench["report_start"];}

    if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $referencia_grupo="00000000";
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1;  global $fechaf_grupo; global $referencia_grupo;
				$this->Image('../../imagenes/logo escudo.png',12,8,13);
				$this->rect(10,5,200,260);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(130,10,'FORMATO DE COMPROBANTE CONTABLE',0,0,'C');
				$this->Ln(15);
				$this->SetFont('Arial','B',8);
			}
			function Footer(){ global $sub_total_columna1; global $sub_total_columna2; $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$sub_total_columna1=formato_monto($sub_total_columna1); $sub_total_columna2=formato_monto($sub_total_columna2); 
				$this->SetY(-20); $y=$this->GetY(); $l=$y-0.2; 
				$this->SetFont('Arial','B',9);
				$this->Line(10,$l,210,$l);	
				$this->Ln(1);  
				$this->Cell(160,4,'TOTALES:',0,0,'R');
				$this->Cell(20,4,$sub_total_columna1,0,0,'R');
				$this->Cell(20,4,$sub_total_columna2,0,1,'R');
				$x=$this->GetY()+1;
				$this->Line(170,$y,170,$x);
				$this->Line(190,$y,190,$x);
			}
		  }		  
		  $pdf=new PDF('P', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',8);
		  $i=0; $total_columna1=0; $total_columna2=0; $sub_total_columna1=0; $sub_total_columna2=0; $prev_referencia=""; 
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_comp=$registro["tipo_comp"]; $fechaf=$registro["fechaf"]; $referencia=$registro["referencia"]; 
		  $tipo_asiento=$registro["tipo_asiento"];  $descripcion=$registro["descripcion"]; $codigo_cuenta2=$registro["codigo_cuenta2"]; $nombre=$registro["nombre"];             
		  if($php_os=="WINNT"){ $nombre=$registro["nombre"];   }else{$nombre=utf8_decode($registro["nombre"]);  $descripcion=utf8_decode($registro["descripcion"]); }
                  $tipo_comp_grupo=$tipo_comp; $fechaf_grupo=$fechaf; $referencia_grupo=$referencia; $tipo_asiento_grupo=$tipo_asiento; $descripcion_grupo=$descripcion;  
		  $codigo_cuenta2_grupo=$codigo_cuenta2; $nombre_grupo=$nombre;                   

		      if($prev_referencia<>$referencia_grupo){ 
			     $pdf->SetFont('Arial','B',8); 
			     if(($sub_total_columna1>0)or($sub_total_columna2>0)){ 
					$pdf->AddPage();				
				 }
				 $pdf->rect(10,25,200,8);
                 $y=$pdf->GetY();		
				 $x=$pdf->GetX();
				 $x=$pdf->GetY()+8;
				 $pdf->Line(40,$y,40,$x);
				 $pdf->Line(170,$y,170,$x);
				 $pdf->SetFont('Arial','B',8);				 
				 $pdf->Cell(30,4,"FECHA:",0,0,'L');			 
				 $pdf->Cell(130,4,"REFERENCIA:",0,0,'C');
				 $pdf->Cell(40,4,"TIPO DE ASIENTO:",0,1,'C');
				 $pdf->SetFont('Arial','',8);	
				 $pdf->Cell(30,4,$fechaf_grupo,0,0,'L');			 
				 $pdf->Cell(130,4,$referencia_grupo,0,0,'C');
				 $pdf->Cell(40,4,$tipo_asiento_grupo,0,1,'C');
				 $pdf->SetFont('Arial','B',8);
				 $pdf->Cell(20,4,"CONCEPTO :",0,1,'L');
				 $pdf->SetFont('Arial','',8);	
                 $pdf->MultiCell(180,4,$descripcion_grupo,0);
				 $pdf->Ln(3);
				 $y=$pdf->GetY();	 $x=$pdf->GetX();
				 $pdf->Line(10,$y-0.1,210,$y-0.1);
				 $pdf->SetFont('Arial','B',8);
				 $pdf->Cell(22,4,"BENEFICIARIO:",0,0,'L');
				 $pdf->SetFont('Arial','',8);			 
				 $pdf->Cell(178,4,$codigo_cuenta2_grupo.'   '.$nombre_grupo,0,1,'L');
				 $pdf->Ln(3);
				//ENCABEZADO DE CELDAS
				 $y=$pdf->GetY();	 $x=$pdf->GetX();
				 $pdf->Line(10,$y-0.5,210,$y-0.5);
				 $pdf->SetFont('Arial','B',8);
        		 $pdf->SetFillColor(192,192,192);				    
				 $pdf->Cell(30,5,'CODIGO CUENTA','LRB',0,'C',true);
				 $pdf->Cell(130,5,'NOMBRE CUENTA','LRB',0,'C',true);	
				 $pdf->Cell(20,5,'DEBE','LRB',0,'C',true);
				 $pdf->Cell(20,5,'HABER','LRB',1,'C',true);
                 $y=$pdf->GetY();		
				 $x=$pdf->GetX();
				 $x=$pdf->GetY()+199;
				 $pdf->Line(40,$y,40,$x);
				 $pdf->Line(170,$y,170,$x);
				 $pdf->Line(190,$y,190,$x);
				 $prev_referencia=$referencia_grupo; $sub_total_columna1=0; $sub_total_columna2=0;}
		       $codigo_cuenta=$registro["cod_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"];$debe=$registro["columna1"]; $haber=$registro["columna2"]; 
			   if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"];}else{$nombre_cuenta=utf8_decode($registro["nombre_cuenta"]); }
			   $sub_total_columna1=$sub_total_columna1+$debe; $sub_total_columna2=$sub_total_columna2+$haber;
			   $total_columna1=$total_columna1+$debe; $total_columna2=$total_columna2+$haber;
			   $debe=formato_monto($debe); 	$haber=formato_monto($haber); $fechaf=formato_ddmmaaaa($fechaf);	
			   $pdf->SetFont('Arial','',8);	
		   	   $pdf->Cell(30,4,$codigo_cuenta,0,0);
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=130; 			   
			   $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,4,$debe,0,0,'R');
               $pdf->Cell(20,4,$haber,0,1,'R'); 				
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,4,$nombre_cuenta,0); 
			} 
			$pdf->Output();     
		}
		if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Formato_Comprobante.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="150" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>FORMATO DE COMPROBANTE CONTABLE</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="150" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1?></strong></font></td>
			 </tr>
			 
		  <?  $i=0; $total_columna1=0; $total_columna2=0; $sub_total_columna1=0; $sub_total_columna2=0; $prev_referencia=""; $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_comp=$registro["tipo_comp"]; $fechaf=$registro["fechaf"]; $referencia=$registro["referencia"]; 
		  $tipo_asiento=$registro["tipo_asiento"];  $descripcion=$registro["descripcion"]; $codigo_cuenta2=$registro["codigo_cuenta2"]; $nombre=$registro["nombre"];             
                  $tipo_comp_grupo=$tipo_comp; $fechaf_grupo=$fechaf; $referencia_grupo=$referencia; $tipo_asiento_grupo=$tipo_asiento; $descripcion_grupo=$descripcion;  
		  $codigo_cuenta2_grupo=$codigo_cuenta2; $nombre_grupo=$nombre;   



		      if($prev_referencia<>$referencia_grupo){ 
			    if(($sub_total_columna1>0)or($sub_total_columna2>0)){ $sub_total_columna1=formato_monto($sub_total_columna1); $sub_total_columna2=formato_monto($sub_total_columna2); 
				?>	 				 
                                   <tr>
				          <td width="100" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="100" align="right">---------------</td>
					  <td width="100" align="right">---------------</td>
				    </tr>	
				    <tr>
				          <td width="100" align="left"></td>
					  <td width="400" align="right"><strong><? echo "TOTALES: " ?></strong></td>
					  <td width="100" align="right"><strong><? echo $sub_total_columna1; ?></strong></td>
					  <td width="100" align="right"><strong><? echo $sub_total_columna2; ?></strong></td>
				    </tr>	
				    <tr>
				      <td width="150" align="left"></td>
				    </tr>	
                                <? }
				 ?>
				   <tr>
				     <td width="100" align="left"><strong>FECHA</strong></td>
				     <td width="400" align="center"><strong>REFERENCIA</strong></td>
				     <td width="100" align="left"></td>
				     <td width="100" align="center"><strong>TIPO ASIENTO</strong></td>					 
				   </tr>
				   <tr>
				     <td width="100" align="left"><? echo $fechaf_grupo; ?></td>
				     <td width="400" align="center">'<? echo $referencia_grupo; ?></td>
				     <td width="100" align="left"></td>
				     <td width="100" align="center">'<? echo $tipo_asiento_grupo; ?></td>					 
				   </tr>
				   <tr>
				       <td width="100" align="left"><strong>CONCEPTO :</strong></td>
				       <td width="400" align="left"><? echo $descripcion_grupo; ?></td>					 
				   </tr>	   
				   <tr>
				       <td width="100" align="left"><strong>BENEFICIARIO:</strong></td>
				       <td width="400" align="left"><? echo $codigo_cuenta2_grupo.'   '.$nombre_grupo; ?></td>					 
				   </tr>
				   <tr>
				       <td width="100" align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
			   	       <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre Cuenta</strong></td>
				       <td width="100" align="right" bgcolor="#99CCFF" ><strong>Debe</strong></td>
				       <td width="100" align="right" bgcolor="#99CCFF" ><strong>Haber</strong></td>
				   </tr>	
			     <? 
				 $prev_referencia=$referencia_grupo; $sub_total_columna1=0; $sub_total_columna2=0;}

		           $codigo_cuenta=$registro["cod_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"];$debe=$registro["columna1"]; $haber=$registro["columna2"]; 
			   if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"];}else{$nombre_cuenta=utf8_decode($registro["nombre_cuenta"]); }
			   $sub_total_columna1=$sub_total_columna1+$debe; $sub_total_columna2=$sub_total_columna2+$haber;
			   $total_columna1=$total_columna1+$debe; $total_columna2=$total_columna2+$haber;
			   $debe=formato_monto($debe); 	$haber=formato_monto($haber); $fechaf=formato_ddmmaaaa($fechaf);
			   $nombre_cuenta=$registro["nombre_cuenta"];$nombre_cuenta=conv_cadenas($nombre_cuenta,0);
                           
			   ?>	   
				<tr>
				   <td width="100" align="left"><? echo $codigo_cuenta; ?></td>
				   <td width="400" align="justify"><? echo $nombre_cuenta; ?></td>
				   <td width="100" align="right"><? echo $debe; ?></td>
				   <td width="100" align="right"><? echo $haber; ?></td>
				 </tr>
			   <? 		  
		  }
			    if(($sub_total_columna1>0)or($sub_total_columna2>0)){ $sub_total_columna1=formato_monto($sub_total_columna1); $sub_total_columna2=formato_monto($sub_total_columna2); 
				?>	 				 
                                   <tr>
				          <td width="100" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="100" align="right">---------------</td>
					  <td width="100" align="right">---------------</td>
				    </tr>	
				    <tr>
				          <td width="100" align="left"></td>
					  <td width="400" align="right"><strong><? echo "TOTALES: " ?></strong></td>
					  <td width="100" align="right"><strong><? echo $sub_total_columna1; ?></strong></td>
					  <td width="100" align="right"><strong><? echo $sub_total_columna2; ?></strong></td>
				    </tr>	
				    <tr>
				      <td width="150" align="left"></td>
				    </tr>	
                                <? }	


	  
		  ?></table><?
        }		  
}
?> 

