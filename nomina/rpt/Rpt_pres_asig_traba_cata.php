<? include ("../../class/seguridad.inc"); include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$tipo_nomina_d=$_GET["tipo_nomina_d"];$tipo_nomina_h=$_GET["tipo_nomina_h"];$cod_empleado_d=$_GET["cod_empleado_d"];$cod_empleado_h=$_GET["cod_empleado_h"];$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$Sql=""; $tipo_rpt=$_GET["tipo_rpt"];
$date = date("d-m-Y");$hora = date("h:i:s a");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{ $php_os=PHP_OS;  $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
 
    $sSQL = "SELECT nom011.tipo_nomina, nom001.descripcion, nom011.cod_empleado, nom006.nombre, nom011.cod_concepto, nom002.denominacion, nom011.cantidad, nom011.monto, nom011.fecha_ini, nom011.fecha_exp, nom011.acumulado, nom011.saldo, nom011.calculable, nom011.activo, nom011.cod_presup, nom011.prestamo, nom011.monto_Prestamo, nom011.nro_Cuotas, nom011.nro_Cuotas_C, nom006.cedula,to_char(fecha_Ini,'DD/MM/YYYY') as fechai,to_char(fecha_Exp,'DD/MM/YYYY') as fechae
            FROM nom001, nom002, nom006, nom011 nom011
            WHERE nom011.tipo_nomina = nom001.tipo_nomina and nom011.cod_concepto = nom002.cod_concepto and
            nom011.tipo_nomina = nom002.tipo_nomina and   nom011.cod_empleado = nom006.cod_empleado  and
            nom011.Prestamo = 'S' and   nom011.tipo_nomina>='".$tipo_nomina_d."' and nom011.tipo_nomina<='".$tipo_nomina_h."'
            ORDER BY nom011.cod_empleado, nom011.cod_concepto";

    if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
	  $oRpt = new PHPReportMaker();
	  $oRpt->setXML("Catalogo_Prestamos_Asignados_Trabajador.xml");
	  $oRpt->setUser("$user");
	  $oRpt->setPassword("$password");
	  $oRpt->setConnection("localhost");
	  $oRpt->setDatabaseInterface("postgresql");
	  $oRpt->setSQL($sSQL);
	  $oRpt->setDatabase("$dbname");
	  $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"monto"=>$monto,"date"=>$date,"hora"=>$hora));
	  $oRpt->run();
	  $aBench = $oRpt->getBenchmark();
    }

	 if(($tipo_rpt=="PDF")){$res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_empleado_grupo=""; 
      if($filas>=1){ $registro=pg_fetch_array($res,0); $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; 
	    if($php_os=="WINNT"){$descripcion=$registro["descripcion"]; }else{$descripcion=utf8_decode($descripcion);}}	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $cod_empleado_grupo; global $tipo_nomina;  global $descripcion;  
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(80);
			$this->Cell(100,7,'PRESTAMOS ASIGNADOS A TRABAJADORES',1,0,'C');
			$this->Ln(20);
			$this->SetFont('Arial','B',8);
			$this->Cell(140,5,"TIPO NOMINA : ".$tipo_nomina." ".$descripcion,0,1,'L');
			$this->SetFont('Arial','B',7);
			$this->Cell(10,5,'CODIGO',1,0,'L');
			$this->Cell(95,5,'DENOMINACION',1,0,'L');
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
	  $i=0; $cantidad=0; $total_cantidad=0;  $prev_cod_empleado=""; $prev_nombre=""; $prev_tipo="";
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cod_concepto=$registro["cod_concepto"]; 
            $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cod_concepto_grupo=$cod_concepto; 
			$pdf->SetFont('Arial','B',7); 
			if($prev_cod_empleado<>$cod_empleado_grupo){
			    if($cantidad>0){ 
				   $pdf->Cell(200,3,'CONCEPTOS DE:  '.$prev_nombre.'  :  '.$cantidad,0,1,'L');
				   $pdf->Ln(4);
			    }  
				$pdf->Cell(240,5,"TRABAJADOR:   ".$cod_empleado_grupo."   ".$nombre_grupo,0,1,'L');  
				$prev_cod_empleado=$cod_empleado_grupo; $prev_nombre=$nombre_grupo;  $cantidad=0;} 


		    $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; $nombre=$registro["nombre"]; $cod_empleado=$registro["cod_empleado"];
	        $fechai=$registro["fechai"]; $fechae=$registro["fechae"]; $nro_cuotas=$registro["nro_cuotas"]; $nro_cuotas_c=$registro["nro_cuotas_c"]; 
		    $monto=$registro["monto"];   $monto_prestamo=$registro["monto_prestamo"]; $acumulado=$registro["acumulado"]; $saldo=$registro["saldo"];
		    $cantidad=$cantidad+1; $total_cantidad=$total_cantidad+1;
		    $nro_cuotas=formato_monto($nro_cuotas); $nro_cuotas_c=formato_monto($nro_cuotas_c); $monto=formato_monto($monto); $monto_prestamo=formato_monto($monto_prestamo);
		    $acumulado=formato_monto($acumulado); $saldo=formato_monto($saldo); 
		    $pdf->SetFont('Arial','',7);
	        $pdf->Cell(10,3,$cod_concepto,0,0,'L'); 				   
		    $x=$pdf->GetX();   $y=$pdf->GetY(); $n=95; 
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
		    $pdf->MultiCell($n,3,$denominacion,0);
		  } $pdf->SetFont('Arial','B',7);
		$pdf->Cell(200,3,'CONCEPTOS DE:  '.$prev_nombre.'  :  '.$cantidad,0,1,'L'); $pdf->Ln(4);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(100,3,'TOTAL CONCEPTOS ASIGNADOS: '.$total_cantidad,0,1,'L');	
		$pdf->Output();  
    }
    if($tipo_rpt=="EXCEL"){$res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_empleado_grupo=""; 
       if($filas>=1){ $registro=pg_fetch_array($res,0); $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"];}
	   header("Content-type: application/vnd.ms-excel");
       header("Content-Disposition: attachment; filename=RPT_Prestamos_Asignados_Por_Trabajador.xls"); 	
		?>

	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>PRESTAMOS ASIGNADOS A TRABAJADORES</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		    	<td width="100" align="left" ><strong>Tipo Nomina: </strong></td>
		    	<td width="400" align="left" ><strong><? echo $tipo_nomina."    ".$descripcion; ?></strong></td>
		 </tr>
		 <tr height="20">
		   <td width="100" align="left"  bgcolor="#99CCFF"><strong>Codigo</strong></td>
		   <td width="400" align="left"  bgcolor="#99CCFF"><strong>Denominacion</strong></td>
		   <td width="100" align="center"  bgcolor="#99CCFF"><strong>fecha_Inic.</strong></td>
		   <td width="100" align="center"  bgcolor="#99CCFF"><strong>fecha_Exp.</strong></td>
		   <td width="100" align="right"  bgcolor="#99CCFF"><strong>Nro Cuotas</strong></td>
		   <td width="100" align="right"  bgcolor="#99CCFF"><strong>Cuotas Canc</strong></td>
		   <td width="100" align="right"  bgcolor="#99CCFF"><strong>Monto Cuota</strong></td>
		   <td width="100" align="right"  bgcolor="#99CCFF"><strong>Prestamo</strong></td>
		   <td width="100" align="right"  bgcolor="#99CCFF"><strong>Acumulado</strong></td>
		   <td width="100" align="right"  bgcolor="#99CCFF"><strong>Saldo</strong></td>
		 </tr>
		<?  $i=0; $cantidad=0; $total_cantidad=0;  $prev_cod_empleado=""; $prev_nombre=""; $res=pg_query($sSQL);
		while($registro=pg_fetch_array($res)){ $i=$i+1; 
		   $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cod_concepto=$registro["cod_concepto"]; 
            $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cod_concepto_grupo=$cod_concepto; 
			  if($prev_cod_empleado<>$cod_empleado_grupo){
			    if($cantidad>0){ 
				?>	   
			        <tr>
           				<td width="100" align="left">CONCEPTOS DE: </td>
           				<td width="400" align="left"><? echo $prev_nombre.'  :  '.$cantidad; ?></td>
			        </tr>
		 		<tr height="20">
		 		</tr>
				<?}
				?>	   
				<tr>
           			<td width="100" align="left"><strong>TRABAJADOR:   </strong></td>
           			<td width="400" align="left"><strong><? echo $cod_empleado_grupo."   ".$nombre_grupo; ?></strong></td>
         		</tr>
				<?
				 $prev_cod_empleado=$cod_empleado_grupo; $prev_nombre=$nombre_grupo;  $cantidad=0;} 

		   $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; $nombre=$registro["nombre"]; $cod_empleado=$registro["cod_empleado"];
	       $fechai=$registro["fechai"]; $fechae=$registro["fechae"]; $nro_cuotas=$registro["nro_cuotas"]; $nro_cuotas_c=$registro["nro_cuotas_c"]; 
		   $monto=$registro["monto"];   $monto_prestamo=$registro["monto_prestamo"]; $acumulado=$registro["acumulado"]; $saldo=$registro["saldo"];
		   $cantidad=$cantidad+1; $total_cantidad=$total_cantidad+1;
		   $nro_cuotas=formato_monto($nro_cuotas); $nro_cuotas_c=formato_monto($nro_cuotas_c); $monto=formato_monto($monto); $monto_prestamo=formato_monto($monto_prestamo);
		   $acumulado=formato_monto($acumulado); $saldo=formato_monto($saldo); 

				?>	 				 
                    <tr>
					  <td width="100" align="left"><? echo $cod_concepto; ?></td>
					  <td width="400" align="left"><? echo $denominacion; ?></td>
					  <td width="100" align="center"><? echo $fechai; ?></td>
					  <td width="100" align="center"><? echo $fechae; ?></td>
					  <td width="100" align="right"><? echo $nro_cuotas; ?></td>
					  <td width="100" align="right"><? echo $nro_cuotas_c; ?></td>		
					  <td width="100" align="right"><? echo $monto; ?></td>
					  <td width="100" align="right"><? echo $monto_prestamo; ?></td>	
					  <td width="100" align="right"><? echo $acumulado; ?></td>
					  <td width="100" align="right"><? echo $saldo; ?></td>	
				    </tr>
                <?  
			
		  }
			 if($cantidad>0){ 
				?>	   
			        <tr>
           				<td width="100" align="left">CONCEPTOS DE: </td>
           				<td width="400" align="left"><? echo $prev_nombre.'  :  '.$cantidad; ?></td>
			        </tr>
		 		<tr height="20">
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
