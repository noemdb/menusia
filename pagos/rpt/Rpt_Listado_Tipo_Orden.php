<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$tipo_orden_d=$_GET["tipo_orden_d"];$tipo_orden_h=$_GET["tipo_orden_h"]; $tipo_rpt=$_GET["tipo_rpt"]; $Sql=""; $date = date("d-m-Y");$hora = date("H:i:s a");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?} 
else{  $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
    // LLAMAR A PHP_REPORT
    $sSQL = "SELECT * FROM TIPOS_ORDEN WHERE tipo_orden>='".$tipo_orden_d."' AND tipo_orden <='".$tipo_orden_h."'";
    if($tipo_rpt=="HTML"){	 include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Listado_Tipo_Ordenes.xml");
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1,"date"=>$date,"hora"=>$hora));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run(); 
		}
  if($tipo_rpt=="PDF"){	 
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1;  global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,10,'LISTADO DE TIPOS DE ORDEN',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(100,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',8);	
			$this->Cell(13,5,'CODIGO',1,0,'L');
			$this->Cell(157,5,'DESCRIPCION TIPO DE ORDEN',1,0,'L');
			$this->Cell(30,5,'CODIGO CONTABLE',1,1,'L');
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
		    $tipo_orden=$registro["tipo_orden"]; $des_tipo_orden=$registro["des_tipo_orden"]; $cod_contable_t=$registro["cod_contable_t"];  
            if($php_os=="WINNT"){$des_tipo_orden=$registro["des_tipo_orden"]; }else{$des_tipo_orden=utf8_decode($des_tipo_orden);}
		   $pdf->Cell(12,4,$tipo_orden,0,0,'L'); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $n=158;	   
		   $pdf->SetXY($x+$n,$y);
	   	   $pdf->Cell(30,4,$cod_contable_t,0,1,'L');
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($n,4,$des_tipo_orden,0);
        }					 
		$pdf->Output();   
    }	  
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Listado_Tipo_Orden.xls");		
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		<td width="100" align="left" ><strong></strong></td>
                <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO TIPOS DE ORDENES</strong></font></td>
	      </tr>
	      <tr height="20">
	     </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Tipos de Orden</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Codigo Contable</strong></td>
         </tr>
     <?	  
	  $i=0; $cantidad=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		$tipo_orden=$registro["tipo_orden"]; $des_tipo_orden=$registro["des_tipo_orden"]; $cod_contable_t=$registro["cod_contable_t"];  
		$des_tipo_orden=conv_cadenas($des_tipo_orden,0);  
	?>	   
	<tr>
           <td width="100" align="left">'<? echo $tipo_orden; ?></td>
           <td width="400" align="left"><? echo $des_tipo_orden; ?></td>
           <td width="100" align="left">'<? echo $cod_contable_t; ?></td>
         </tr>
	<? }  
        ?>
	   <tr>
            <td>&nbsp;</td>
           </tr>
	    
	  </table><?
	}
}  
?>
