<? include ("../../class/seguridad.inc"); include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); include ("../../class/phpreports/PHPReportMaker.php");
   $tipo_nomina_d=$_GET["tipo_nomina_d"];   $cod_conceptod=$_GET["cod_conceptod"];   $fecha_d=$_GET["fecha_d"]; $tipo_rpt=$_GET["tipo_rpt"];   $php_os=PHP_OS; 
   $Sql="";   $date = date("d-m-Y");   $hora = date("H:i:s a");
   if($fecha_d==""){$sfecha_d="2007-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
   if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} $criterio3="";
      $sSQL = "SELECT NOM018.Tipo_Nomina, NOM001.Descripcion, NOM018.Cod_Empleado, NOM018.Cod_Concepto, NOM018.Fecha_Nomina, NOM018.Nombre_Empleado,
               NOM018.Des_Concepto, NOM018.Asig_Ded_Apo, NOM018.Tipo_Asigna, NOM018.Monto, NOM018.Monto_Diario, to_char(nom018.Fecha_Nomina,'DD/MM/YYYY') as fechan
               FROM NOM001, NOM018  WHERE NOM001.Tipo_Nomina = NOM018.Tipo_Nomina  AND  NOM018.Tipo_Nomina = '".$tipo_nomina_d."'  AND
               NOM018.Cod_Concepto='".$cod_conceptod."' AND  NOM018.Fecha_Nomina='".$fecha_desde."' ORDER BY NOM018.Cod_Concepto, NOM018.Fecha_Nomina";
    if($tipo_rpt=="HTML"){
          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_lista_histo_rn_re.xml");
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
	
	if($tipo_rpt=="PDF"){$res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_concepto_grupo="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"];  $cod_concepto=$registro["cod_concepto"];$des_concepto=$registro["des_concepto"];
	    $fecha_nomina=$registro["fecha_nomina"]; $fecha_nomina=formato_ddmmaaaa($fecha_nomina); if($php_os=="WINNT"){$descripcion=$descripcion; }else{$descripcion=utf8_decode($descripcion); $des_concepto=utf8_decode($des_concepto); }	 }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $des_concepto; global $cod_concepto; global $tipo_nomina;  global $descripcion;  global $fecha_nomina;  
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(120,7,'LISTADO HISTORICO DE CONCEPTOS',1,0,'C');
			$this->Ln(20);
			$this->SetFont('Arial','B',8);
			$this->Cell(140,5,"TIPO NOMINA : ".$tipo_nomina." ".$descripcion,0,1,'L');
			$this->Cell(140,5,"CONCEPTO : ".$cod_concepto." ".$des_concepto,0,0,'L');
			$this->Cell(60,5,"PERIODO : ".$fecha_nomina,0,1,'L');
			$this->Cell(20,5,'CODIGO',1,0,'L');
			$this->Cell(160,5,'NOMBRE DEL TRABAJADOR',1,0,'L');
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
	  $pdf->SetFont('Arial','',8);
	  $i=0; $sub_total_monto=0; $prev_cod_concepto=""; $prev_des_concepto="";
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_empleado=$registro["cod_empleado"]; $nombre_empleado=$registro["nombre_empleado"]; $cod_concepto=$registro["cod_concepto"];
	      $des_concepto=$registro["des_concepto"]; $fecha_nomina=$registro["fecha_nomina"];$monto=$registro["monto"];
		   if($php_os=="WINNT"){$nombre_empleado=$nombre_empleado; }else{$nombre_empleado=utf8_decode($nombre_empleado); }
           $cod_empleado_grupo=$cod_empleado; $cod_concepto_grupo=$cod_concepto; $nombre_empleado_grupo=$nombre_empleado; $des_concepto_grupo=$des_concepto; 
	       $fecha_nomina_grupo=$fecha_nomina; $fecha_nomina=formato_ddmmaaaa($fecha_nomina); $sub_total_monto=$sub_total_monto+$monto; $monto=formato_monto($monto);
	       $pdf->Cell(20,3,$cod_empleado,0,0,'L'); 		   
		    $x=$pdf->GetX();   $y=$pdf->GetY(); $n=160; 
		    $pdf->SetXY($x+$n,$y);
             $pdf->Cell(20,3,$monto,0,1,'R'); 
		    $pdf->SetXY($x,$y);
		    $pdf->MultiCell($n,3,$nombre_empleado,0); 
			
	   } $sub_total_monto=formato_monto($sub_total_monto);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(180,2,'',0,0,'L');
		$pdf->Cell(20,2,'-----------------',0,1,'R');
		$pdf->Cell(180,3,'TOTAL:  ',0,0,'R');
		$pdf->Cell(20,3,$sub_total_monto,0,1,'R');
		$pdf->Output();  
    }
	
	if($tipo_rpt=="EXCEL"){$res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_concepto_grupo="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; $descripcion=$registro["descripcion"];  $cod_concepto=$registro["cod_concepto"];$des_concepto=$registro["des_concepto"];
	    $fecha_nomina=$registro["fecha_nomina"]; $fecha_nomina=formato_ddmmaaaa($fecha_nomina);}
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=RPT_Listado_Historico_Conceptos.xls"); 	
		?>

	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO HISTORICO DE CONCEPTOS</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		    <td width="100" align="left" ><strong>Tipo Nomina: </strong></td>
		    <td width="400" align="left" ><strong><? echo $tipo_nomina."    ".$descripcion; ?></strong></td>
		 </tr>
		<tr>
		  <td width="100" align="left"><strong>'<? echo $cod_concepto; ?></strong></td>
		  <td width="400" align="left"><strong><? echo $des_concepto; ?></strong></td>
		  <td width="200" align="right"><strong><? echo 'Periodo  '.$fecha_nomina; ?></strong></td>
		</tr>
		 <tr height="20">
		   <td width="100" align="left"><strong>Codigo Trab</strong></td>
		   <td width="400" align="left"><strong>Nombre</strong></td>
		   <td width="200" align="right"><strong>Monto</strong></td>
		 </tr>
		<?  $i=0; $sub_total_monto=0; $prev_cod_concepto=""; $prev_des_concepto=""; $res=pg_query($sSQL);
		while($registro=pg_fetch_array($res)){ $i=$i+1; 
		   $cod_empleado=$registro["cod_empleado"]; $nombre_empleado=$registro["nombre_empleado"]; $cod_concepto=$registro["cod_concepto"];
	  	   $des_concepto=$registro["des_concepto"]; $fecha_nomina=$registro["fecha_nomina"];
           $cod_empleado_grupo=$cod_empleado; $cod_concepto_grupo=$cod_concepto; $nombre_empleado_grupo=$nombre_empleado; $des_concepto_grupo=$des_concepto; 
	  	   $fecha_nomina_grupo=$fecha_nomina; $fecha_nomina=formato_ddmmaaaa($fecha_nomina); $monto=$registro["monto"];
		   $sub_total_monto=$sub_total_monto+$monto; $monto=formato_monto($monto); ?>	 				 
           <tr>
			  <td width="100" align="left"><? echo $cod_empleado; ?></td>
			  <td width="400" align="left"><? echo $nombre_empleado; ?></td>
			  <td width="200" align="right"><? echo $monto; ?></td>	
			</tr>
		<? }?>	 				 
		<tr>
		  <td width="100" align="left"></td>
		  <td width="400" align="right"></td>
		  <td width="200" align="right">==============</td>
		</tr>
		 <tr>
		  <td width="100" align="left"></td>
		  <td width="400" align="right"><strong><? echo 'TOTAL:  '?></strong></td>	
		  <td width="200" align="right"><strong><? echo $sub_total_monto; ?></strong></td>
		</tr>
		</table><?
	}
 }
?>
