<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$clasificacion_d=$_GET["clasificacion_d"];$clasificacion_h=$_GET["clasificacion_h"];$ordenado=$_GET["ordenado"];$detallado=$_GET["detallado"];$Sql="";$date = date("d-m-Y");$hora = date("H:i:s a"); $tipo_rpt=$_GET["tipo_rpt"];
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';}$fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;
 $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$date = date("d-m-Y");$hora = date("H:i:s a"); $php_os=PHP_OS;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
         $sSQL = "select ced_rif,nombre,cedula,rif,nit,tipo_benef,clasificacion,telefono,direccion,ciudad,fax,estado from pre099  where ced_rif>='".$cedula_d."' and  ced_rif<='".$cedula_h."' and clasificacion>='".$clasificacion_d."' and clasificacion<='".$clasificacion_h."' order by ".$ordenado."";
if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
	  $oRpt = new PHPReportMaker();
   if($detallado=="S"){ $oRpt->setXML("Rpt_Listado_Beneficiario_Detallado.xml");}   else{$oRpt->setXML("Rpt_Listado_Beneficiario.xml");}
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
  if($tipo_rpt=="PDF"){	 
      require('../../class/fpdf/fpdf.php');
   if($detallado=="S"){
      class PDF extends FPDF{
		function Header(){ global $tam_logo;  global $criterio1; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,10,'LISTADO DE BENEFICIARIOS DETALLADO',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(100,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',8);	
			$this->Cell(20,5,'CEDULA/RIF',1,0,'L');
			$this->Cell(120,5,'NOMBRE',1,0,'L');
			$this->Cell(20,5,'RIF',1,0,'C');
			$this->Cell(20,5,'NIT',1,0,'C');
			$this->Cell(20,5,'TIPO BENEF',1,1,'C');
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
	  $i=0; $cantidad=0; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		$ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $rif=$registro["rif"]; $nif=$registro["nif"]; $tipo_benef=$registro["tipo_benef"];
                $direccion=$registro["direccion"]; $ciudad=$registro["ciudad"]; $telefono=$registro["telefono"]; $fax=$registro["fax"]; $estado=$registro["estado"];
                if($php_os=="WINNT"){$nombre=$registro["nombre"]; }else{$nombre=utf8_decode($nombre);$direccion=utf8_decode($direccion);}
		   $pdf->Ln(2);
		   $pdf->Cell(20,3,$ced_rif,0,0,'L'); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $n=120;	   
		   $pdf->SetXY($x+$n,$y);
	   	   $pdf->Cell(20,3,$rif,0,0,'C');
	   	   $pdf->Cell(20,3,$nif,0,0,'C');
	   	   $pdf->Cell(20,3,$tipo_benef,0,1,'C');
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($n,3,$nombre,0);

		   $pdf->Cell(140,3,'DIRECCION:   '.$direccion,0,0,'L'); 	
		   $pdf->Cell(60,3,'CIUDAD:   '.$ciudad,0,1,'L'); 

		   $pdf->Cell(140,3,'TELEFONO:   '.$telefono.'   '.$fax,0,0,'L'); 	
		   $pdf->Cell(60,3,'ESTADO:   '.$estado,0,1,'L');
         	   } 
		$pdf->Cell(200,3,'',0,1,'L');	
		$pdf->Cell(50,3,'',0,0,'L');			 
		$pdf->Output(); }
else{
      class PDF extends FPDF{
		function Header(){ global $tam_logo;  global $criterio1; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,10,'LISTADO DE BENEFICIARIOS',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(100,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',7);	
			$this->Cell(20,5,'Cedula/Rif',1,0,'L');
			$this->Cell(120,5,'Nombre',1,0,'L');
			$this->Cell(20,5,'Rif',1,0,'C');
			$this->Cell(19,5,'Nit',1,0,'C');
			$this->Cell(21,5,'Tipo Beneficiario',1,1,'C');
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
	  $i=0; $cantidad=0; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		$ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $rif=$registro["rif"]; $nif=$registro["nif"]; $tipo_benef=$registro["tipo_benef"];
        if($php_os=="WINNT"){$nombre=$registro["nombre"]; }else{$nombre=utf8_decode($nombre); $direccion=utf8_decode($direccion);}
		   $pdf->Ln(2);
		   $pdf->Cell(20,3,$ced_rif,0,0,'L'); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $n=120;	   
		   $pdf->SetXY($x+$n,$y);
	   	   $pdf->Cell(20,3,$rif,0,0,'C');
	   	   $pdf->Cell(20,3,$nif,0,0,'C');
	   	   $pdf->Cell(20,3,$tipo_benef,0,1,'C');
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($n,3,$nombre,0);
      } 
				 
		$pdf->Output(); }
  }	  
if($tipo_rep=="EXCEL"){	
     header("Content-type: application/vnd.ms-excel");
     header("Content-Disposition: attachment; filename=Catalogo_Beneficiarios_Detallado.xls");		
   if($detallado=="S"){
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CATALOGO BENEFICIARIOS DETALLADO</strong></font></td>
	      </tr>
	      <tr height="20">
	     </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Ced_Rif</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Cedula</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Rit</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Tipo Beneficiario</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Clasificacion</strong></td>
         </tr>
     <?	  
	  $i=0; $cantidad=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		$ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $rif=$registro["rif"]; $cedula=$registro["cedula"]; $tipo_benef=$registro["tipo_benef"];
        $clasificacion=$registro["clasificacion"]; $direccion=$registro["direccion"];  $telefono=$registro["telefono"]; 
		$nombre=conv_cadenas($nombre,0);  $direccion=conv_cadenas($direccion,0); 
	?>	   
	     <tr>
           <td width="100" align="left">'<? echo $ced_rif; ?></td>
           <td width="400" align="left"><? echo $nombre; ?></td>
           <td width="100" align="center">'<? echo $cedula; ?></td>
           <td width="100" align="center">'<? echo $rit; ?></td>
           <td width="100" align="center"><? echo $tipo_benef; ?></td>
           <td width="100" align="center"><? echo $clasificacion; ?></td>
         </tr>
	     <tr>
           <td width="100" align="left">Direccion: </td>
           <td width="400" align="left"><? echo $direccion; ?></td>
           <td width="100" align="center"></td>
           <td width="100" align="left">Telefono: </td>
           <td width="100" align="left"><? echo $telefono.'   '.$fax; ?></td>
         </tr>
	 <tr height="20">
	 </tr>
	<? }  
        ?>
	   <tr><td>&nbsp;</td></tr>
	   <tr>
           <td width="100" align="center"></td>
		   <td width="400" align="left"><strong></strong></td>	
       </tr>      
	  </table><?}
   else{ ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
             <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO BENEFICIARIOS</strong></font></td>
	      </tr>
	      <tr height="20">
	     </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Ced_Rif</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Cedula</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Rit</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Tipo Beneficiario</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Clasificacion</strong></td>
         </tr>
     <?	  
	  $i=0; $cantidad=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		$ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $rif=$registro["rif"]; $cedula=$registro["cedula"]; $tipo_benef=$registro["tipo_benef"];
        $clasificacion=$registro["clasificacion"]; $direccion=$registro["direccion"];  $telefono=$registro["telefono"]; 
		$nombre=conv_cadenas($nombre,0); $direccion=conv_cadenas($direccion,0);  
	?>	   
	    <tr>
           <td width="100" align="left">'<? echo $ced_rif; ?></td>
           <td width="400" align="left"><? echo $nombre; ?></td>
           <td width="100" align="center">'<? echo $cedula; ?></td>
           <td width="100" align="center">'<? echo $rit; ?></td>
           <td width="100" align="center"><? echo $tipo_benef; ?></td>
           <td width="100" align="center"><? echo $clasificacion; ?></td>
        </tr>
	<? } ?>
	   <tr>
            <td>&nbsp;</td>
       </tr>
	  <tr>
        <td width="100" align="center"></td>
		<td width="400" align="left"><strong></strong></td>	
      </tr>      
	  </table><?}
	}
}
?>

