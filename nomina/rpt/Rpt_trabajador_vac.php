<? include ("../../class/seguridad.inc"); include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);
   $cod_empleado_d=$_GET["cod_empleado_d"];   $cod_empleado_h=$_GET["cod_empleado_h"]; $fecha_d=$_GET["fechad"]; $fecha_h=$_GET["fechah"]; $tipo_rpt=$_GET["tipo_rpt"];      
   if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';}  $fecha_desde=$ano1.$mes1.$dia1;
   if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;
   $criterio1="Fecha a Reincorporarse  Desde: ".$fecha_d." Hasta: ".$fecha_h;   
   $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else{ $nom_emp=busca_conf(); $php_os=PHP_OS; if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} 
        $sSQL = "SELECT nom024.cod_empleado,nom006.nombre,nom006.cedula,nom006.fecha_ingreso,nom024.fecha_c_desde, nom024.fecha_C_Hasta, nom024.fecha_D_Desde, nom024.fecha_D_Hasta, nom024.fecha_reincorp,
                 to_char(fecha_ingreso,'DD/MM/YYYY') as fechai,	to_char(fecha_c_desde,'DD/MM/YYYY') as fechacd, to_char(fecha_C_Hasta,'DD/MM/YYYY') as fechach,
				 to_char(fecha_D_Desde,'DD/MM/YYYY') as fechadd, to_char(fecha_d_hasta,'DD/MM/YYYY') as fechadh, to_char(fecha_reincorp,'DD/MM/YYYY') as fechar	
             	FROM nom006,nom024 Where (nom006.cod_empleado=nom024.cod_empleado) and (nom024.cod_empleado>='".$cod_empleado_d."') and (nom024.cod_empleado<='".$cod_empleado_h."') and
                (nom024.fecha_reincorp>='".$fecha_desde."') and (nom024.fecha_reincorp<='".$fecha_hasta."') order by  fecha_d_hasta,nom024.cod_empleado";
	if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_trabajador_vac.xml");
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
    if($tipo_rpt=="PDF"){$res=pg_query($sSQL);  $cod_empleado_grupo=""; 	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $cod_empleado_grupo; global $registro;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,10,'TRABAJADORES EN VACACIONES',1,0,'C');
			$this->Ln(20);
            $this->SetFont('Arial','B',9);
            $this->Cell(200,5,$criterio1,0,1,'L');	
		    $this->Ln(5); 
            $this->SetFont('Arial','B',8);			
			$this->Cell(100,4,'','RTL',0,'R');	
			$this->Cell(40,4,'Fecha Causacion','RTL',0,'C');
			$this->Cell(40,4,'Fecha Disfrute','RTL',0,'C');
			$this->Cell(20,4,'Fecha','RTL',1,'C');
			$this->Cell(30,4,'Codigo Trabajador','BRL',0,'L');
			$this->Cell(70,4,'Nombre Trabajador','BR',0,'L');
			$this->Cell(20,4,'Desde','B',0,'C');
			$this->Cell(20,4,'Hasta','BR',0,'C');
			$this->Cell(20,4,'Desde','B',0,'C');
			$this->Cell(20,4,'Hasta','BR',0,'C');
			$this->Cell(20,4,'Regreso','BR',1,'C');
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
		$cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; $fechacd=$registro["fechacd"]; 
		$fechach=$registro["fechach"]; $fechadd=$registro["fechadd"];$fechadh=$registro["fechadh"]; $fechar=$registro["fechar"]; 
		if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
            $pdf->SetFont('Arial','',8);
	     	$pdf->Cell(30,5,$cod_empleado,0,0,'L'); 
	     	$pdf->Cell(70,5,$nombre,0,0,'L'); 
	     	$pdf->Cell(20,5,$fechacd,0,0,'C');  
	     	$pdf->Cell(20,5,$fechach,0,0,'C'); 
	     	$pdf->Cell(20,5,$fechadd,0,0,'C'); 
	     	$pdf->Cell(20,5,$fechadh,0,0,'C'); 
	     	$pdf->Cell(20,5,$fechar,0,1,'C'); 
        } 
		
		$pdf->Output();  
    }
    if($tipo_rpt=="EXCEL"){
	    header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Rpt_Trabajadores_Vacaciones.xls"); 	
		?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		   <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CONTROL INDIVIDUAL DE VACACIONES</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="left" ><strong><? echo $criterio1; ?></strong></font></td>
		 </tr>
		<tr height="20">
			 <td width="100" align="left" bgcolor="#99CCFF"></td>
			 <td width="400" align="left" bgcolor="#99CCFF"></td>
			 <td width="100" align="right" bgcolor="#99CCFF"><strong>Fecha</strong></td>
			 <td width="100" align="left" bgcolor="#99CCFF"><strong>Causacion</strong></td>
			 <td width="100" align="right" bgcolor="#99CCFF"><strong>Fecha</strong></td>
			 <td width="100" align="left" bgcolor="#99CCFF"><strong>Disfrute</strong></td>
			 <td width="100" align="center" bgcolor="#99CCFF"><strong>Fecha</strong></td>
		</tr>	
		<tr height="20">
			 <td width="100" align="left" bgcolor="#99CCFF"><strong>Codigo Trabajador</strong></td>
			 <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre Trabajador</strong></td>
			 <td width="100" align="right" bgcolor="#99CCFF"><strong>Desde</strong></td>
			 <td width="100" align="left" bgcolor="#99CCFF"><strong>Hasta</strong></td>
			 <td width="100" align="right" bgcolor="#99CCFF"><strong>Desde</strong></td>
			 <td width="100" align="left" bgcolor="#99CCFF"><strong>Hasta</strong></td>
			 <td width="100" align="center" bgcolor="#99CCFF"><strong>Regreso</strong></td>
		</tr>
		 <tr height="20">
		 </tr>
		<?  $i=0; $prev_cod_empleado="";  $res=pg_query($sSQL);
		while($registro=pg_fetch_array($res)){ $i=$i+1; 
		$cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; $fechacd=$registro["fechacd"]; 
		$fechach=$registro["fechach"]; $fechadd=$registro["fechadd"];$fechadh=$registro["fechadh"]; $fechar=$registro["fechar"]; 
		  ?> 
             <tr>
			    <td width="100" align="left"><? echo $cod_empleado; ?></td>
			    <td width="400" align="left"><? echo $nombre; ?></td>
			    <td width="100" align="right">'<? echo $fechacd; ?></td>
			    <td width="100" align="left"><? echo $fechach; ?></td>	
			    <td width="100" align="right"><? echo $fechadd; ?></td>
			    <td width="100" align="left"><? echo $fechadh; ?></td>
			    <td width="100" align="center"><? echo $fechar; ?></td>
			</tr>
            <?			
		} 
		?></table><?
	}	
}
?>