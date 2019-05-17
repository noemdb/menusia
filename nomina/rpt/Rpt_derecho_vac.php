<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nominad=$_GET["tipo_nominad"]; $tipo_nominah=$_GET["tipo_nominah"];  $codigo_departamento_d=$_GET["codigo_departamento_d"];   $codigo_departamento_h=$_GET["codigo_departamento_h"]; 
   $cod_empleado_d=$_GET["cod_empleado_d"];  $cod_empleado_h=$_GET["cod_empleado_h"];   $fecha_d=$_GET["fechad"]; $fecha_h=$_GET["fechah"];   $tipo_rpt=$_GET["tipo_rpt"];
   if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';}  $fecha_desde=$ano1.$mes1.$dia1;
   if (!(empty($fecha_h))){$ano2=substr($fecha_h,6,9);$mes2=substr($fecha_h,3,2);$dia2=substr($fecha_h,0,2);}else{$fecha_h='';} $fecha_hasta=$ano2.$mes2.$dia2;
   $criterio1="Fecha Proceso  Desde: ".$fecha_d." Hasta: ".$fecha_h; 
   $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else{ $nom_emp=busca_conf(); $php_os=PHP_OS; if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
   
        $criterio2="";
		if($codigo_departamento_d==$codigo_departamento_h){ 
		   $sql="SELECT descripcion_dep FROM NOM005 where codigo_departamento='$codigo_departamento_d'"; $res=pg_query($sql); 
		   if($registro=pg_fetch_array($res,0)){$criterio2=$registro["descripcion_dep"];}
		}	
        $criterio3="";
		if($tipo_nominad==$tipo_nominah){ 
		   $sql="SELECT tipo_nomina,descripcion,desc_grupo from nom001 where tipo_nomina='$tipo_nominad'"; $res=pg_query($sql); 
		   if($registro=pg_fetch_array($res,0)){$criterio3=$registro["descripcion"];}
		}			
        $criterio=" (nom006.cod_empleado>='".$cod_empleado_d."' AND nom006.cod_empleado<='".$cod_empleado_h."') and (nom006.tipo_nomina>='".$tipo_nominad."' and nom006.tipo_nomina<='".$tipo_nominah."') 
	      and (nom006.cod_departam>='".$codigo_departamento_d."' and nom006.cod_departam<='".$codigo_departamento_h."' ) ";
	   
	   
        $sSQL = "SELECT nom006.cod_empleado,nom006.nombre,nom006.cedula,nom006.fecha_ingreso,nom006.status, to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as fechai, date_part('year', fecha_ingreso), date_part('month', fecha_ingreso), date_part('day', fecha_ingreso)
             	FROM nom006 Where (date_part('day', fecha_ingreso)>=".$dia1." and date_part('month', fecha_ingreso)>=".$mes1.") and (date_part('day', fecha_ingreso)<=".$dia2." and date_part('month', fecha_ingreso)<=".$mes2.") and
                (NOM006.Status='ACTIVO' or NOM006.Status='PERMISO RE' or NOM006.Status='VACACIONES' or NOM006.Status='REPOSO') and ".$criterio." order by date_part('month', fecha_ingreso),date_part('year', fecha_ingreso),nom006.cod_empleado";
		
	if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_derecho_vac.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("$host");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"monto"=>$monto,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();
    
    }
	
	if(($tipo_rpt=="PDF")){$res=pg_query($sSQL);  $cod_empleado_grupo=""; 	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $cod_empleado_grupo; global $registro; global $criterio3; global $tipo_nominad; global $tipo_nominah; 
		    global $codigo_departamento_d; global $codigo_departamento_h; global $criterio2;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,10,'TRABAJADORES DERECHO A VACACIONES',1,0,'C');
			$this->Ln(20);
            $this->SetFont('Arial','B',9);
            $this->Cell(200,5,$criterio1,0,1,'L');
            if($tipo_nominad==$tipo_nominah){	$this->Cell(200,5,"NOMINA : ".$tipo_nominad." ".$criterio3,0,1,'L');}
			if($codigo_departamento_d==$codigo_departamento_h){	$this->Cell(200,5,"DEPARTAMENTO : ".$codigo_departamento_d." ".$criterio2,0,1,'L');}
			
		    $this->Ln(5); 	
            $this->SetFont('Arial','B',8); 			
			$this->Cell(30,5,'Codigo Trabajador',1,0,'L');
			$this->Cell(130,5,'Nombre Trabajador',1,0,'L');
			$this->Cell(20,5,'Fecha Ingreso',1,0,'C');
			$this->Cell(20,5,'Estatus',1,1,'C');
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
	  $i=0; $total_monto=0;  $prev_cod_empleado=""; 
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		   $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $fechai=$registro["fechai"]; $status=$registro["status"]; 
            $pdf->SetFont('Arial','',8);
	     	$pdf->Cell(30,5,$cod_empleado,0,0,'L'); 
	     	$pdf->Cell(130,5,$nombre,0,0,'L'); 
	     	$pdf->Cell(20,5,$fechai,0,0,'C');  
	     	$pdf->Cell(20,5,$status,0,1,'C'); 
		
      } 
	  $pdf->Output();  
    }
    if($tipo_rpt=="EXCEL"){
	    header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Rpt_Trabajadores_derecho_vacaciones.xls"); 	
		?>

	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>TRABAJADORES DERECHO A VACACIONES</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="left" ><strong><? echo $criterio1; ?></strong></font></td>
		 </tr>
		<tr height="20">
			 <td width="100" align="left" bgcolor="#99CCFF"><strong>Codigo Trabajador</strong></td>
			 <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre Trabajador</strong></td>
			 <td width="100" align="center" bgcolor="#99CCFF"><strong>Fecha Ingreso</strong></td>
			 <td width="100" align="center" bgcolor="#99CCFF"><strong>Estatus</strong></td>
		</tr>
		 <tr height="20">
		 </tr>
		<?  $i=0; $prev_cod_empleado="";  $res=pg_query($sSQL);
		while($registro=pg_fetch_array($res)){ $i=$i+1; 
		   $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $fechai=$registro["fechai"]; $status=$registro["status"]; 
		  ?> 
             <tr>
			    <td width="100" align="left">'<? echo $cod_empleado; ?></td>
			    <td width="400" align="left"><? echo $nombre; ?></td>
			    <td width="100" align="center"><? echo $fechai; ?></td>
			    <td width="100" align="center"><? echo $status; ?></td>
			</tr>
             <?			
		} 
		?></table><?
	}
  }
?>