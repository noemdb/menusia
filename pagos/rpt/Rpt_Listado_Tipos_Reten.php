<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$tipo_retencion_d=$_GET["tipo_retencion_d"];$tipo_retencion_h=$_GET["tipo_retencion_h"]; $tipo_rpt=$_GET["tipo_rpt"];
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="03-0000054"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}

       // LLAMAR A PHP_REPORT
       $sSQL = "SELECT PAG003.Tipo_Retencion, PAG003.Descripcion_Ret, PAG003.Cod_Contable, CON001.Nombre_Cuenta, PAG003.Tasa  FROM CON001, PAG003
                WHERE PAG003.Cod_Contable = CON001.Codigo_Cuenta AND PAG003.Tipo_Retencion>='".$tipo_retencion_d."' AND PAG003.Tipo_Retencion<='".$tipo_retencion_h."' order by PAG003.Tipo_Retencion";

  if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
	  $oRpt = new PHPReportMaker();
	  $oRpt->setXML("Rpt_Listado_Tipos_Retencion.xml");
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
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,10,'LISTADO DE TIPOS DE RETENCION',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(100,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',8);	
			$this->Cell(10,5,'TIPO',1,0,'L');
			$this->Cell(80,5,'DESCRIPCION RETENCION',1,0,'L');
			$this->Cell(25,5,'CONDIGO',1,0,'C');
			$this->Cell(75,5,'NOMBRE CUENTA',1,0,'L');
			$this->Cell(10,5,'TASA',1,1,'R');
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
		   $tipo_retencion=$registro["tipo_retencion"]; $descripcion_ret=$registro["descripcion_ret"]; $cod_contable=$registro["cod_contable"];  $nombre_cuenta=$registro["nombre_cuenta"];
		   $tasa=$registro["tasa"];
		   if($php_os=="WINNT"){$descripcion_ret=$registro["descripcion_ret"]; }else{$descripcion_ret=utf8_decode($descripcion_ret);}
		   if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"]; }else{$nombre_cuenta=utf8_decode($nombre_cuenta);}
		   $pdf->Cell(10,4,$tipo_retencion,0,0,'C'); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $n=80;	$w=75;	$c=25;
           $pdf->SetXY($x+$n,$y);  
           $pdf->Cell(25,4,$cod_contable,0,0,'C');
		   $pdf->SetXY($x+$n+$w+$c,$y);
	   	   $pdf->Cell(10,4,$tasa,0,1,'R');
		   
		   if(strlen(trim($nombre_cuenta))>strlen(trim($descripcion_ret))){	
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($n,4,$descripcion_ret,0);
		   $pdf->SetXY($x+$n+$c,$y);
		   $pdf->MultiCell($w,4,$nombre_cuenta,0);}
		   else{$pdf->SetXY($x+$n+$c,$y);
		   $pdf->MultiCell($w,4,$nombre_cuenta,0);
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($n,4,$descripcion_ret,0);
		   }
      } 
		$pdf->Output();   
    }	  
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Catalago_Asientos.xls");		
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		<td width="100" align="left" ><strong></strong></td>
                <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO TIPOS DE RETENCION</strong></font></td>
	      </tr>
	      <tr height="20">
	     </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Tipos de REtencion</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Codigo Contable</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre Cuenta</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF"><strong>Tasa</strong></td>
         </tr>
     <?	  
	  $i=0; $cantidad=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		$tipo_retencion=$registro["tipo_retencion"]; $descripcion_ret=$registro["descripcion_ret"]; $cod_contable=$registro["cod_contable"];  $nombre_cuenta=$registro["nombre_cuenta"];
                $tasa=$registro["tasa"];
		$descripcion_ret=conv_cadenas($descripcion_ret,0);  $nombre_cuenta=conv_cadenas($nombre_cuenta,0);
	?>	   
	<tr>
           <td width="100" align="left">'<? echo $tipo_retencion; ?></td>
           <td width="400" align="left"><? echo $descripcion_ret; ?></td>
           <td width="100" align="center">'<? echo $cod_contable; ?></td>
           <td width="400" align="left"><? echo $nombre_cuenta; ?></td>
           <td width="100" align="right">'<? echo $tasa; ?></td>
         </tr>
	<? }  
        ?>
	   <tr> <td>&nbsp;</td>  </tr>	     
	  </table><?
	}
}  
?>

