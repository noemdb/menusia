<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$partida_d=$_GET["partida_d"];  $partida_h=$_GET["partida_h"]; $fuente_d=$_GET["fuente_d"];  $fuente_h=$_GET["fuente_h"];$nivel=$_GET["nivel"]; $tipo_rep=$_GET["tipo_rep"];}
 else{$partida_d="";  $partida_h=""; $fuente_d="";  $fuente_h=""; $nivel="";$tipo_rep="HTML";} $php_os=PHP_OS;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{  $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
    $efiscal=substr($Fec_Fin_Ejer,0,4);   $criterio1="EJERCICIO FISCAL: ".$efiscal;      
        
	$sSQL = "select cod_presup, cod_fuente, denominacion, asignado from pre001 where cod_presup>='".$partida_d."' and cod_presup<='".$partida_h."' AND   cod_fuente>='".$fuente_d."' and cod_fuente<='".$fuente_h."'   order by cod_presup";

    if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
         $oRpt = new PHPReportMaker();
         $oRpt->setXML("asignacion_presup.xml");
         $oRpt->setUser("$user");
         $oRpt->setPassword("$password");
         $oRpt->setConnection("$host");
         $oRpt->setDatabaseInterface("postgresql");
         $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
         $oRpt->setSQL($sSQL);
         $oRpt->setDatabase("$dbname");
         $oRpt->run();
	}
   if($tipo_rep=="PDF"){	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){ global $criterio1; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(120,8,'ASIGNACION PRESUPUESTARIA POR PARTIDA',1,1,'C');
			$this->Ln(8);			
			$this->SetFont('Arial','B',8);
            $this->Cell(50,5,$criterio1,0,1);			
			$this->Cell(44,5,'CODIGO',1,0);
			$this->Cell(122,5,'DENOMINACION',1,0,'C');
			$this->Cell(13,5,'FUENTE',1,0);
			$this->Cell(21,5,'ASIGNACION',1,1,'C');
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
	  $i=0;  $total=0; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_presup=$registro["cod_presup"];  $cod_fuente=$registro["cod_fuente"];   $denominacion=$registro["denominacion"];  
		   $asignado=$registro["asignado"]; $total=$total+$asignado; $asignado=formato_monto($asignado); 
           if($php_os=="WINNT"){$denominacion=$denominacion; }   else{$denominacion=utf8_decode($denominacion); }
		   $pdf->Cell(44,4,$cod_presup,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=125; 		   
		   $pdf->SetXY($x+$n,$y);
		   $pdf->Cell(10,4,$cod_fuente,0,0,'C'); 
		   $pdf->Cell(21,4,$asignado,0,1,'R'); 
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,4,$denominacion,0);
			
		}  $total=formato_monto($total); 
       	
		$pdf->Output();   
    }
    if($tipo_rep=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Asignacion_Presupuestaria.xls");

?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="220" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ASIGNACION PRESUPUESTARIA POR PARTIDA</strong></font></td>
		 </tr>
         <tr height="20">
           <td width="220" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CODIGO</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>DENOMINACION</strong></td>
           <td width="50" align="left" bgcolor="#99CCFF"><strong>FUENTE</strong></td>
           <td width="120" align="center" bgcolor="#99CCFF"><strong>ASIGNADO</strong></td>
         </tr>
     <?	  
	  $i=0;  $total=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_presup=$registro["cod_presup"];  $cod_fuente=$registro["cod_fuente"];   $denominacion=$registro["denominacion"];  
           $denominacion=conv_cadenas($denominacion,0); $asignado=$registro["asignado"]; $total=$total+$asignado; $asignado=formato_monto($asignado); 
	?>	   
		   <tr>
           <td width="220" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $cod_presup; ?></td>
           <td width="400" align="justify"><? echo $denominacion; ?></td>
           <td width="50" align="center">'<? echo $cod_fuente; ?></td>
           <td width="120" align="right"><? echo $asignado; ?></td>
         </tr>
	<? } $total=formato_monto($total);  ?>
      
	
	  </table><?	  
	}  		 
 }
 pg_close();
?>

