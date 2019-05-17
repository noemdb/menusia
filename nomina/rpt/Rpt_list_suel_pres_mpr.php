<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);
   $cod_empleado_d=$_GET["cod_empleado_d"];  $cod_empleado_h=$_GET["cod_empleado_h"];  $fecha_d=$_GET["fecha_d"];   $fecha_h=$_GET["fecha_h"]; $tipo_rpt=$_GET["tipo_rpt"];  
   $tipo_nominad=$_GET["tipo_nominad"];  $tipo_nominah=$_GET["tipo_nominah"];   
   $date = date("d-m-Y");   $hora = date("H:i:s a");   $Sql="";       
   if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
   if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;
  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $nom_emp=busca_conf(); $php_os=PHP_OS;  if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
         
	$criterio3="";
    if($tipo_nominad==$tipo_nominah){ 
	   $sql="SELECT tipo_nomina,descripcion,desc_grupo from nom001 where tipo_nomina='$tipo_nominad'"; $res=pg_query($sql); 
	   if($registro=pg_fetch_array($res,0)){$criterio3=$registro["descripcion"];}
    }	 
    $sSQL = "SELECT nom006.Cod_Empleado, nom006.Nombre, nom006.Cedula, nom006.tipo_nomina,nom028.Fecha_Sueldo, nom028.Monto_Sueldo, nom028.Monto_Sueldo_Adic, to_char(nom028.Fecha_Sueldo,'DD/MM/YYYY') as fechas
                  FROM nom006, nom028  WHERE nom006.Cod_Empleado = nom028.Cod_Empleado AND  nom006.Cod_Empleado>='".$cod_empleado_d."' AND nom006.Cod_Empleado<='".$cod_empleado_h."' AND
                  nom006.tipo_nomina>='".$tipo_nominad."' AND nom006.tipo_nomina<='".$tipo_nominah."' AND nom028.Fecha_Sueldo>='".$fecha_desde."' AND nom028.Fecha_Sueldo<='".$fecha_hasta."'  ORDER BY nom006.Cod_Empleado, nom028.Fecha_Sueldo";

    if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
	       $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_list_suel_pres_mpr_re.xml");
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
	
	if(($tipo_rpt=="PDF")){$res=pg_query($sSQL); $filas=pg_num_rows($res); 
      if($filas>=1){ $registro=pg_fetch_array($res,0); $tipo_nomina=$registro["tipo_nomina"];  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1;  global $tipo_nomina;  global $criterio3; global $tipo_nominad; global $tipo_nominah; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,7,'LISTADO SUELDOS DE PRESTACIONES',1,0,'C');
			$this->Ln(20);
			$this->SetFont('Arial','B',8);
			if($tipo_nominad==$tipo_nominah){	$this->Cell(200,5,"NOMINA : ".$tipo_nomina." ".$criterio3,0,1,'L');}
			//else{$this->Cell(140,5,$criterio3,0,1,'L');}
			
			$this->Cell(20,5,'Codigo',1,0,'L');
			$this->Cell(15,5,'Cedula',1,0,'C');
			$this->Cell(95,5,'Nombre Trabajador',1,0,'L');
			$this->Cell(20,5,'Fecha Sueldo',1,0,'C');
			$this->Cell(25,5,'Sueldo Antigueda',1,0,'R');
			$this->Cell(25,5,'Sueldo Dias Adic.',1,1,'R');

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
	  $i=0; $prev_cod_empleado="";
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		$cod_empleado=$registro["cod_empleado"]; $cedula=$registro["cedula"]; $nombre=$registro["nombre"]; $fecha_sueldo=$registro["fecha_sueldo"];   
		$monto_sueldo=$registro["monto_sueldo"]; $monto_sueldo_adic=$registro["monto_sueldo_adic"]; $fecha_sueldo=formato_ddmmaaaa($fecha_sueldo);
		if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
		$monto_sueldo=formato_monto($monto_sueldo); $monto_sueldo_adic=formato_monto($monto_sueldo_adic); 
		$pdf->SetFont('Arial','',8);
		if($prev_cod_empleado<>$cod_empleado){ $prev_cod_empleado=$cod_empleado;
		   $pdf->Ln(2);
	       $pdf->Cell(20,4,$cod_empleado,0,0,'L'); 
	       $pdf->Cell(15,4,$cedula,0,0,'L'); 				   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=95; 			   
		   $pdf->SetXY($x+$n,$y);
		   $pdf->Cell(20,4,$fecha_sueldo,0,0,'C'); 
		   $pdf->Cell(25,4,$monto_sueldo,0,0,'R'); 
           $pdf->Cell(25,4,$monto_sueldo_adic,0,1,'R'); 				
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,4,$nombre,0);
        }else{
           $pdf->Cell(130,4,'',0,0,'L'); 
		   $pdf->Cell(20,4,$fecha_sueldo,0,0,'C'); 
		   $pdf->Cell(25,4,$monto_sueldo,0,0,'R'); 
           $pdf->Cell(25,4,$monto_sueldo_adic,0,1,'R'); 	
        }		
	  }
	  $pdf->Output();  
    }
    if($tipo_rpt=="EXCEL"){      
	      header("Content-type: application/vnd.ms-excel");
          header("Content-Disposition: attachment; filename=RPT_Listado_Sueldo_Prestaciones.xls"); 	
		?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO SUELDOS DE PRESTACIONES</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		   <td width="100" align="left"  bgcolor="#99CCFF"><strong>Codigo Trab.</strong></td>
		   <td width="100" align="center"  bgcolor="#99CCFF"><strong>Cedula</strong></td>
		   <td width="400" align="left"  bgcolor="#99CCFF"><strong>Nombre</strong></td>
		   <td width="100" align="center"  bgcolor="#99CCFF"><strong>Fecha Sueldo</strong></td>
		   <td width="100" align="right"  bgcolor="#99CCFF"><strong>Sueldo Antiguedad</strong></td>
		   <td width="100" align="right"  bgcolor="#99CCFF"><strong>Sueldo Dias Adic.</strong></td>
		 </tr>
		<?  $i=0; $cantidad=0; $total_cantidad=0;  $prev_cod_empleado=""; $prev_nombre=""; $res=pg_query($sSQL);
		while($registro=pg_fetch_array($res)){ $i=$i+1; 
		   $cod_empleado=$registro["cod_empleado"]; $cedula=$registro["cedula"]; $nombre=$registro["nombre"]; $fecha_sueldo=$registro["fecha_sueldo"];   
		   $monto_sueldo=$registro["monto_sueldo"]; $monto_sueldo_adic=$registro["monto_sueldo_adic"]; 
		   $monto_sueldo=formato_monto($monto_sueldo); $monto_sueldo_adic=formato_monto($monto_sueldo_adic); 
		   if($prev_cod_empleado<>$cod_empleado){ $prev_cod_empleado=$cod_empleado;
			?>	 				 
             <tr>
				<td width="100" align="left">'<? echo $cod_empleado; ?></td>
				<td width="100" align="center">'<? echo $cedula; ?></td>
				<td width="400" align="left"><? echo $nombre; ?></td>
				<td width="100" align="center"><? echo $fecha_sueldo; ?></td>	
				<td width="100" align="right"><? echo $monto_sueldo; ?></td>
				<td width="100" align="right"><? echo $monto_sueldo_adic; ?></td>	
			 </tr>
            <?
            }else{
			?>	 				 
             <tr>
				<td width="100" align="left"></td>
				<td width="100" align="center"></td>
				<td width="400" align="left"></td>
				<td width="100" align="center"><? echo $fecha_sueldo; ?></td>	
				<td width="100" align="right"><? echo $monto_sueldo; ?></td>
				<td width="100" align="right"><? echo $monto_sueldo_adic; ?></td>	
			 </tr>
            <?
            }			
		}
       ?>	   
	  </table><?
	}
	
}
?>
