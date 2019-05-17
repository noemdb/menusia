<? include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);
   $cod_empleado_d=$_GET["cod_empleado_d"];   $cod_empleado_h=$_GET["cod_empleado_h"]; $tipo_rpt=$_GET["tipo_rpt"];   
   $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else{ $php_os=PHP_OS; $nom_emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
        $sSQL = "SELECT cod_empleado,nombre,cedula,fecha_ingreso,fecha_Causa_Desde,fecha_Causa_Hasta,fecha_D_Desde,fecha_D_Hasta,fecha_Reincorp,fecha_Calculo_D,fecha_Calculo_H,Calcula_Nomina,
		         Dias_Habiles,Dias_No_Habiles,Dias_Bono_Vac,Monto_Bono_Vac,Dias_Disfrutados, (Dias_Habiles+Dias_No_Habiles) as dias_vac,
                 to_char(fecha_ingreso,'DD/MM/YYYY') as fechai,	to_char(fecha_Causa_Desde,'DD/MM/YYYY') as fechacd, to_char(fecha_Causa_Hasta,'DD/MM/YYYY') as fechach,
				 to_char(fecha_D_Desde,'DD/MM/YYYY') as fechadd, to_char(fecha_D_Hasta,'DD/MM/YYYY') as fechadh, to_char(fecha_Reincorp,'DD/MM/YYYY') as fechar				 
				 FROM MOV_VACACIONES where (cod_empleado>='".$cod_empleado_d."') and (cod_empleado<='".$cod_empleado_h."') order by cod_empleado,fecha_causa_hasta  ";

	if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_control_vac.xml");
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
	if($tipo_rpt=="PDF"){$res=pg_query($sSQL); $filas=pg_num_rows($res);  $cod_empleado_grupo=""; 	$nombre_grupo="";  $cedula_grupo=""; $fechai_grupo=""; $prev_cod_empleado=""; 
	  if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
	    $fechacd=$registro["fechacd"]; $fechach=$registro["fechach"]; $fechadd=$registro["fechadd"];$fechadh=$registro["fechadh"]; $fechar=$registro["fechar"]; 
	    $dias_disfrutados=$registro["dias_disfrutados"]; $dias_vac=$registro["dias_vac"]; $dias_bono_vac=$registro["dias_bono_vac"]; 
		if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; $prev_cod_empleado=$cod_empleado; 
	  }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $cod_empleado_grupo; global $nombre_grupo; global $cedula_grupo; global $fechai_grupo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,7,'CONTROL INDIVIDUAL DE VACACIONES',1,0,'C');
			$this->Ln(20);
			$this->SetFont('Arial','B',9);	
			$this->Cell(200,5,"Trabajador : ".$cod_empleado_grupo." ".$nombre_grupo,0,1,'L');	
			$this->Cell(50,5,"Cedula : ".$cedula_grupo,0,0,'L');
			$this->Cell(150,5,"Fecha Ingreso : ".$fechai_grupo,0,1,'L');				
			$this->SetFont('Arial','B',8);	 			
			$this->Cell(50,4,'Fecha Causacion','RTL',0,'C');
			$this->Cell(50,4,'Fecha Disfrute','RT',0,'C');
			$this->Cell(20,4,'Fecha','RT',0,'C');
			$this->Cell(20,4,'Dias','RT',0,'C');
			$this->Cell(20,4,'Dias','RT',0,'C');
			$this->Cell(20,4,'Dias Bono','RT',1,'C');
			$this->Cell(25,4,'Desde','BL',0,'C');
			$this->Cell(25,4,'Hasta','BR',0,'C');
			$this->Cell(25,4,'Desde','B',0,'C');
			$this->Cell(25,4,'Hasta','BR',0,'C');
			$this->Cell(20,4,'Regreso','BR',0,'C');
			$this->Cell(20,4,'Disfrutado','BR',0,'C');
			$this->Cell(20,4,'Vacaciones','BR',0,'C');
			$this->Cell(20,4,'Vacacional','BR',1,'C');
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
	  $i=0; $total_monto=0;  
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
	    $fechacd=$registro["fechacd"]; $fechach=$registro["fechach"]; $fechadd=$registro["fechadd"];$fechadh=$registro["fechadh"]; $fechar=$registro["fechar"]; 
	    $dias_disfrutados=$registro["dias_disfrutados"]; $dias_vac=$registro["dias_vac"]; $dias_bono_vac=$registro["dias_bono_vac"]; 
		if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);  }
	    $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai;		
		if($prev_cod_empleado<>$cod_empleado_grupo){    $pdf->AddPage(); $prev_cod_empleado=$cod_empleado_grupo; } 
        $pdf->SetFont('Arial','',8);
	    $pdf->Cell(25,5,$fechacd,0,0,'C');  
	    $pdf->Cell(25,5,$fechach,0,0,'C'); 
	    $pdf->Cell(25,5,$fechadd,0,0,'C'); 
	    $pdf->Cell(25,5,$fechadh,0,0,'C'); 
	    $pdf->Cell(20,5,$fechar,0,0,'C'); 
	    $pdf->Cell(20,5,$dias_disfrutados,0,0,'C');
	    $pdf->Cell(20,5,$dias_vac,0,0,'C');  
	    $pdf->Cell(20,5,$dias_bono_vac,0,1,'C');
      } 
	  $pdf->Output();  
    }
    if($tipo_rpt=="EXCEL"){
	   header("Content-type: application/vnd.ms-excel");
       header("Content-Disposition: attachment; filename=Rpt_Control_Individual_Vacaciones.xls"); 	
	   ?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    	<td width="100" align="left" ><strong></strong></td>
		    	<td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CONTROL INDIVIDUAL DE VACACIONES</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		<?  $i=0; $prev_cod_empleado="";  $res=pg_query($sSQL);
		while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
	       $fechacd=$registro["fechacd"]; $fechach=$registro["fechach"]; $fechadd=$registro["fechadd"];$fechadh=$registro["fechadh"]; $fechar=$registro["fechar"]; 
	       $dias_disfrutados=$registro["dias_disfrutados"]; $dias_vac=$registro["dias_vac"]; $dias_bono_vac=$registro["dias_bono_vac"]; 
	       $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula; $fechai_grupo=$fechai; 
		   if($prev_cod_empleado<>$cod_empleado_grupo){
				?>	
				    <tr>
				    </tr> 
                    <tr>
					  <td width="100" align="left"><strong>Trabajador: </strong></td>
					  <td width="100" align="left"><strong>'<? echo $cod_empleado_grupo; ?></strong></td>	
					  <td width="400" align="left"><strong><? echo $nombre_grupo; ?></strong></td>
				    </tr>
                    <tr>
					  <td width="100" align="left"><strong>Cedula: </strong></td>
					  <td width="100" align="left"><strong>'<? echo $cedula_grupo; ?></strong></td>	
					  <td width="400" align="left"><strong><? echo "Fecha Ingreso : ".$fechai_grupo; ?></strong></td>
				    </tr>  
                     <tr>
					  <td width="100" align="right">Fecha </td>
					  <td width="100" align="left">Causacion </td>	
					  <td width="100" align="right">Fecha </td>
					  <td width="100" align="left">Disfrute </td>
					  <td width="100" align="center">Fecha</td>
					  <td width="100" align="center">Dias</td>
					  <td width="100" align="center">Dias</td>
					  <td width="100" align="center">Dias Bono</td>	
				    </tr> 
                     <tr>
					  <td width="100" align="right">Desde</td>
					  <td width="100" align="left">Hasta</td>	
					  <td width="100" align="right">Desde</td>
					  <td width="100" align="left">Hasta</td>
					  <td width="100" align="center">Regreso</td>
					  <td width="100" align="center">Disfrutado</td>
					  <td width="100" align="center">Vacaciones</td>
					  <td width="100" align="center">Vacacional</td>	
				    </tr> 				 
                <? 
				$prev_cod_empleado=$cod_empleado_grupo; } 
		    $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; $fechacd=$registro["fechacd"]; 
		    $fechach=$registro["fechach"]; $fechadd=$registro["fechadd"];$fechadh=$registro["fechadh"]; $fechar=$registro["fechar"]; $dias_disfrutados=$registro["dias_disfrutados"]; 
		    $dias_vac=$registro["dias_vac"]; $dias_bono_vac=$registro["dias_bono_vac"]; 
		    ?> 
             <tr>
			    <td width="100" align="right">'<? echo $fechacd; ?></td>
			    <td width="100" align="left"><? echo $fechach; ?></td>	
			    <td width="100" align="right"><? echo $fechadd; ?></td>
			    <td width="100" align="left"><? echo $fechadh; ?></td>
			    <td width="100" align="center"><? echo $fechar; ?></td>
			    <td width="100" align="center"><? echo $dias_disfrutados; ?></td>
			    <td width="100" align="center"><? echo $dias_vac; ?></td>
			    <td width="100" align="center"><? echo $dias_bono_vac; ?></td>
			</tr>
			<tr>
			</tr> 
            <?			
		  } 
		  ?></table><?	
    }
    
  }
?>