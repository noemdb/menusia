<? include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$tipo_nomina_d=$_GET["tipo_nomina_d"];$tipo_nomina_h=$_GET["tipo_nomina_h"];$cod_concepto_d=$_GET["cod_concepto_d"];$cod_concepto_h=$_GET["cod_concepto_h"]; $tipo_rpt=$_GET["tipo_rpt"]; $php_os=PHP_OS; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
    
   $sSQL = "SELECT nom011.tipo_nomina, nom001.Descripcion, nom011.cod_empleado, nom006.nombre, nom011.cod_concepto, nom002.denominacion, nom011.cantidad, nom011.Monto, nom011.Fecha_Ini, nom011.Fecha_Exp, nom011.Acumulado, nom011.Saldo, nom011.Calculable, nom011.Activo, nom011.Cod_Presup, nom011.Prestamo, nom011.Monto_Prestamo, nom011.Nro_Cuotas, nom011.Nro_Cuotas_C, nom006.Cedula, nom006.Cedula,to_char(Fecha_Ini,'DD/MM/YYYY') as fechai,to_char(Fecha_Exp,'DD/MM/YYYY') as fechae
            FROM nom001, nom002, nom006, nom011  WHERE nom011.tipo_nomina = nom001.tipo_nomina and nom011.cod_concepto = nom002.cod_concepto and
            nom011.tipo_nomina = nom002.tipo_nomina and nom011.cod_empleado = nom006.cod_empleado  and
            nom011.Prestamo = 'S' and nom011.tipo_nomina>='".$tipo_nomina_d."' and nom011.tipo_nomina<='".$tipo_nomina_h."' and
            nom011.cod_concepto>='".$cod_concepto_d."' and nom011.cod_concepto<='".$cod_concepto_h."'
            ORDER BY nom011.tipo_nomina, nom011.cod_concepto";
			
	if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Catalogo_Prestamos_Asignados.xml");
            $oRpt->setUser("$user");
            $oRpt->setPassword("$password");
            $oRpt->setConnection("localhost");
            $oRpt->setDatabaseInterface("postgresql");
            $oRpt->setSQL($sSQL);
            $oRpt->setDatabase("$dbname");
            $oRpt->setParameters(array("date"=>$date,"hora"=>$hora));
            $oRpt->run();
	}
	
	if(($tipo_rpt=="PDF")){$res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_concepto_grupo=""; 
      if($filas>=1){ $registro=pg_fetch_array($res,0); $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; 
	   if($php_os=="WINNT"){$descripcion=$registro["descripcion"]; }else{$descripcion=utf8_decode($descripcion);}}	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $cod_concepto_grupo; global $tipo_nomina;  global $descripcion;  
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(80);
			$this->Cell(100,7,'  PRESTAMOS ASIGNADOS',1,0,'C');
			$this->Ln(18);
			$this->SetFont('Arial','B',8);
			$this->Cell(140,5,"TIPO NOMINA : ".$tipo_nomina." ".$descripcion,0,1,'L');
			$this->SetFont('Arial','B',7);
			$this->Cell(15,5,'CODIGO',1,0,'L');
			$this->Cell(90,5,'NOMBRE',1,0,'L');
			$this->Cell(20,5,'FECHA INICIO',1,0,'C');
			$this->Cell(20,5,'FECHA EXPIRA',1,0,'C');
			$this->Cell(14,5,'CUOTAS',1,0,'R');
			$this->Cell(19,5,'CANCELADAS',1,0,'R');
			$this->Cell(22,5,'MONTO CUOTAS',1,0,'R');
			$this->Cell(20,5,'PRESTAMO',1,0,'R');
			$this->Cell(20,5,'ACUMULADO',1,0,'R');
			$this->Cell(20,5,'SALDO',1,1,'R');

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
	  $i=0; $cantidad=0; $total_cantidad=0; $sub_total_monto=0; $prev_cod_concepto=""; $prev_tipo="";
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; $cod_empleado=$registro["cod_empleado"];
           $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; 
		   if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }else{$denominacion=utf8_decode($denominacion); $descripcion=utf8_decode($descripcion);} 
		   $cod_concepto_grupo=$cod_concepto; $denominacion_grupo=$denominacion; $cod_empleado_grupo=$cod_empleado; 
		   $pdf->SetFont('Arial','B',7);  
		   if(($prev_cod_concepto<>$cod_concepto_grupo)or($prev_tipo<>$tipo_nomina)){
			 if($sub_total_monto>0){ $sub_total_monto=formato_monto($sub_total_monto);
				$pdf->Cell(180,2,'',0,0,'L');
			    $pdf->Cell(20,2,'-----------------',0,0,'R');
				$pdf->Cell(60,3,'',0,1,'L');
				$pdf->Cell(180,3,'Nro. Trabajadores:'.$cantidad,0,0,'L');
				$pdf->Cell(20,3,$sub_total_monto,0,0,'R');
				$pdf->Cell(60,3,'',0,1,'L');
				$pdf->Ln(4);
				if ($prev_tipo<>$tipo_nomina){ $pdf->AddPage();}
			 }
			 $pdf->Cell(240,5,"CONCEPTO: ".$cod_concepto_grupo."   ".$denominacion_grupo,0,1,'L');  
			 $prev_cod_concepto=$cod_concepto_grupo; $sub_total_monto=0; $cantidad=0; $prev_tipo=$tipo_nomina;} 


		   $cod_concepto=$registro["cod_concepto"]; $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cod_concepto=$registro["cod_concepto"];
	       $denominacion=$registro["denominacion"]; $fechai=$registro["fechai"]; $fechae=$registro["fechae"]; $nro_cuotas=$registro["nro_cuotas"]; 
		   $nro_cuotas_c=$registro["nro_cuotas_c"]; $monto=$registro["monto"]; $monto_prestamo=$registro["monto_prestamo"]; $acumulado=$registro["acumulado"]; $saldo=$registro["saldo"];
		   $cantidad=$cantidad+1; $total_cantidad=$total_cantidad+1; $sub_total_monto=$sub_total_monto+$monto;
		   $nro_cuotas=formato_monto($nro_cuotas); $nro_cuotas_c=formato_monto($nro_cuotas_c); $monto=formato_monto($monto); $monto_prestamo=formato_monto($monto_prestamo);
		   $acumulado=formato_monto($acumulado); $saldo=formato_monto($saldo); 
		   if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }else{$denominacion=utf8_decode($denominacion); $descripcion=utf8_decode($descripcion); $nombre=utf8_decode($nombre);} 
		   
		    $pdf->SetFont('Arial','',7);
	        $pdf->Cell(15,3,$cod_empleado,0,0,'L'); 				   
		    $x=$pdf->GetX();   $y=$pdf->GetY(); $n=90; 
		    $pdf->SetXY($x+$n,$y);
		    $pdf->Cell(20,3,$fechai,0,0,'C'); 
		    $pdf->Cell(20,3,$fechae,0,0,'C'); 
		    $pdf->Cell(15,3,$nro_cuotas,0,0,'C'); 
		    $pdf->Cell(20,3,$nro_cuotas_c,0,0,'C'); 
		    $pdf->Cell(20,3,$monto,0,0,'R'); 
		    $pdf->Cell(20,3,$monto_prestamo,0,0,'R');
		    $pdf->Cell(20,3,$acumulado,0,0,'R'); 
            $pdf->Cell(20,3,$saldo,0,1,'R'); 
		    $pdf->SetXY($x,$y);
		    $pdf->MultiCell($n,3,$nombre,0); 			
		  } $pdf->SetFont('Arial','B',7);
		    $sub_total_monto=formato_monto($sub_total_monto);
			$pdf->Cell(180,2,'',0,0,'L');
			$pdf->Cell(20,2,'-----------------',0,0,'R');
			$pdf->Cell(60,3,'',0,1,'L');
			$pdf->Cell(180,3,'Nro. Trabajadores:'.$cantidad,0,0,'L');
			$pdf->Cell(20,3,$sub_total_monto,0,0,'R');
			$pdf->Cell(60,3,'',0,1,'L');
			$pdf->Ln(4);
		 $x=$pdf->GetX();  $y=$pdf->GetY();
		 $pdf->Cell(100,3,'TOTAL CONCEPTOS ASIGNADOS: '.$total_cantidad,0,1,'L');	
		 $pdf->Output();  
    }
    if($tipo_rpt=="EXCEL"){$res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_concepto_grupo=""; 
      if($filas>=1){ $registro=pg_fetch_array($res,0); $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"];}
	  header("Content-type: application/vnd.ms-excel");
          header("Content-Disposition: attachment; filename=RPT_Prestamos_Asignados.xls"); 	
		?>

	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    	<td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>PRESTAMOS ASIGNADOS</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		    	<td width="100" align="left" ><strong>Tipo Nomina: </strong></td>
		    	<td width="400" align="left" ><strong>'<? echo $tipo_nomina."    ".$descripcion; ?></strong></td>
		 </tr>
		 <tr height="20">
		   <td width="100" align="left"  bgcolor="#99CCFF"><strong>Codigo</strong></td>
		   <td width="400" align="left"  bgcolor="#99CCFF"><strong>Nombre</strong></td>
		   <td width="100" align="center"  bgcolor="#99CCFF"><strong>Fecha_Inic.</strong></td>
		   <td width="100" align="center"  bgcolor="#99CCFF"><strong>Fecha_Exp.</strong></td>
		   <td width="100" align="right"  bgcolor="#99CCFF"><strong>Nro Cuotas</strong></td>
		   <td width="100" align="right"  bgcolor="#99CCFF"><strong>Cuotas Canc</strong></td>
		   <td width="100" align="right"  bgcolor="#99CCFF"><strong>Monto Cuota</strong></td>
		   <td width="100" align="right"  bgcolor="#99CCFF"><strong>Prestamo</strong></td>
		   <td width="100" align="right"  bgcolor="#99CCFF"><strong>Acumulado</strong></td>
		   <td width="100" align="right"  bgcolor="#99CCFF"><strong>Saldo</strong></td>
		 </tr>
		 <tr height="20">
		 </tr>
		<?  $i=0; $cantidad=0; $total_cantidad=0; $sub_total_monto=0; $prev_cod_concepto=""; $res=pg_query($sSQL);
		while($registro=pg_fetch_array($res)){ $i=$i+1; 
		    $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; $cod_empleado=$registro["cod_empleado"];
            $cod_concepto_grupo=$cod_concepto; $denominacion_grupo=$denominacion; $cod_empleado_grupo=$cod_empleado; 
			if($prev_cod_concepto<>$cod_concepto_grupo){
			     if($sub_total_monto>0){ $sub_total_monto=formato_monto($sub_total_monto);
				?>	   
				<tr>
           				<td width="100" align="left"></td>
           				<td width="400" align="left"></td>
           				<td width="100" align="left"></td>
           				<td width="100" align="left"></td>
           				<td width="100" align="left"></td>
           				<td width="100" align="left"></td>
           				<td width="100" align="right">=============</td>
         			</tr>
			        <tr>
           				<td width="100" align="left"></td>
           				<td width="400" align="left"><? echo 'Nro. Trabajadores:'.$cantidad; ?></td>
           				<td width="100" align="left"></td>
           				<td width="100" align="left"></td>
           				<td width="100" align="left"></td>
           				<td width="100" align="left"></td>
           				<td width="100" align="right"><? echo $sub_total_monto; ?></td>
			        </tr>
				<?}
				?>	   
				<tr>
           			<td width="100" align="left"><strong>CONCEPTO: </strong></td>
           			<td width="400" align="left"><strong><? echo $cod_concepto_grupo."   ".$denominacion_grupo; ?></strong></td>

         			</tr>
				<?
				 $prev_cod_concepto=$cod_concepto_grupo; $sub_total_monto=0; $cantidad=0;} 
		    $cod_concepto=$registro["cod_concepto"]; $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cod_concepto=$registro["cod_concepto"];
	        $denominacion=$registro["denominacion"]; $fechai=$registro["fechai"]; $fechae=$registro["fechae"]; $nro_cuotas=$registro["nro_cuotas"]; 
		    $nro_cuotas_c=$registro["nro_cuotas_c"]; $monto=$registro["monto"]; $monto_prestamo=$registro["monto_prestamo"]; $acumulado=$registro["acumulado"]; $saldo=$registro["saldo"];
		    $cantidad=$cantidad+1; $total_cantidad=$total_cantidad+1; $sub_total_monto=$sub_total_monto+$monto;
		    $nro_cuotas=formato_monto($nro_cuotas); $nro_cuotas_c=formato_monto($nro_cuotas_c); $monto=formato_monto($monto); $monto_prestamo=formato_monto($monto_prestamo);
		    $acumulado=formato_monto($acumulado); $saldo=formato_monto($saldo); 

			?>	 				 
			<tr>
			  <td width="100" align="left">'<? echo $cod_concepto; ?></td>
			  <td width="400" align="left"><? echo $nombre; ?></td>
			  <td width="100" align="center"><? echo $fechai; ?></td>
			  <td width="100" align="center"><? echo $fechae; ?></td>
			  <td width="100" align="right"><? echo $nro_cuotas; ?></td>
			  <td width="100" align="right"><? echo $nro_cuotas_c; ?></td>		
			  <td width="100" align="right"><? echo $monto; ?></td>
			  <td width="100" align="right"><? echo $monto_prestamo; ?></td>	
			  <td width="100" align="right"><? echo $acumulado; ?></td>
			  <td width="100" align="right"><? echo $saldo; ?></td>	
			</tr>
            <?  }
			if($sub_total_monto>0){ $sub_total_monto=formato_monto($sub_total_monto);
			?>	   
				<tr>
					<td width="100" align="left"></td>
					<td width="400" align="left"></td>
					<td width="100" align="left"></td>
					<td width="100" align="left"></td>
					<td width="100" align="left"></td>
					<td width="100" align="left"></td>
					<td width="100" align="right">____________</td>
				</tr>
				<tr>
					<td width="100" align="left"></td>
					<td width="400" align="left"><? echo 'Nro. Trabajadores:'.$cantidad; ?></td>
					<td width="100" align="left"></td>
					<td width="100" align="left"></td>
					<td width="100" align="left"></td>
					<td width="100" align="left"></td>
					<td width="100" align="right"><? echo $sub_total_monto; ?></td>
				</tr>
				<?}
         ?>
	     <tr>
            <td>&nbsp;</td>
          </tr>
	    <tr>
            <td width="100" align="center"></td>
		    <td width="400" align="left"><strong>TOTAL CONCEPTOS ASIGNADOS: <? echo $total_cantidad; ?></strong></td>	
        </tr>      
	  </table><?
	}
}
?>
