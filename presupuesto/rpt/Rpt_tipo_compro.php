<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc");  error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$tipo_comp_d=$_GET["tipo_comp_d"];$tipo_comp_h=$_GET["tipo_comp_h"];$tipo_rep=$_GET["tipo_rep"];}else{$tipo_comp_d="";$tipo_comp_h="zzzz";$tipo_rep="HTML";} $php_os=PHP_OS;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} 
   $sSQL = "select tipo_comp, des_tipo_Comp, cod_Contable, cod_part_iva, func_inv_tpcomp, c_imp_unico from pre016 where pre016.tipo_comp>='".$tipo_comp_d."' and pre016.tipo_comp<='".$tipo_comp_h."' order by tipo_comp";

if($tipo_rep=="HTML"){	 include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Catalogo_tipo_compromiso.xml");
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
if($tipo_rep=="PDF"){	 
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(150,10,'CATALOGO DE DOCUMENTOS DE COMPROMISOS',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(12,3,'','LT',0,'L');
			$this->Cell(108,3,'','T',0,'L');				
			$this->Cell(20,3,'CODIGO','T',0,'L');
			$this->Cell(20,3,'PARTIDA','T',0,'L');
			$this->Cell(20,3,'TIPO','T',0,'C');
			$this->Cell(20,3,'PARTIDA','RT',1,'C');

			$this->Cell(12,4,'TIPO','LB',0,'L');
			$this->Cell(108,4,'NOMBRE TIPO','B',0,'L');				
			$this->Cell(20,4,'CONTABLE','B',0,'L');
			$this->Cell(20,4,'IVA','B',0,'L');
			$this->Cell(20,4,'GASTO','B',0,'C');
			$this->Cell(20,4,'IVA FIJA','RB',1,'C');
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
		$tipo_comp=$registro["tipo_comp"]; $des_tipo_comp=$registro["des_tipo_comp"]; $cod_contable=$registro["cod_contable"]; $cod_part_iva=$registro["cod_part_iva"]; $func_inv_tpcomp=$registro["func_inv_tpcomp"]; $c_imp_unico=$registro["c_imp_unico"];
                if($php_os=="WINNT"){$des_tipo_comp=$registro["des_tipo_comp"]; }else{$des_tipo_comp=utf8_decode($des_tipo_comp);}
		   $pdf->Ln(2);
		   $pdf->Cell(12,3,$tipo_comp,0,0,'L'); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $n=108;	   
		   $pdf->SetXY($x+$n,$y);
	   	   $pdf->Cell(20,3,$cod_contable,0,0,'L');
	   	   $pdf->Cell(20,3,$cod_part_iva,0,0,'L');
	   	   $pdf->Cell(20,3,$func_inv_tpcomp,0,0,'C');
	   	   $pdf->Cell(20,3,$c_imp_unico,0,1,'C');
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($n,3,$des_tipo_comp,0);
         	   } 
		$pdf->Cell(200,3,'',0,1,'L');	
		$pdf->Cell(50,3,'',0,0,'L');			 
		$pdf->Output();   
    }	  
if($tipo_rep=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Catalogo_Tipos_Compromisos.xls");		
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		<td width="100" align="left" ><strong></strong></td>
                <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CATALOGO TIPOS DE COMPROMISO</strong></font></td>
	      </tr>
	      <tr height="20">
	     </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>TIPO</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>NOMBRE DOCUMENTO</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>COD. CONTABLE</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>PARTIDA IVA</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>TIPO GASTO</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>PARTIDA IVA FIJA</strong></td>
         </tr>
     <?	  
	  $i=0; $cantidad=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		$tipo_comp=$registro["tipo_comp"]; $des_tipo_comp=$registro["des_tipo_comp"]; $cod_contable=$registro["cod_contable"]; $cod_part_iva=$registro["cod_part_iva"]; $func_inv_tpcomp=$registro["func_inv_tpcomp"]; $c_imp_unico=$registro["c_imp_unico"];
		$des_tipo_comp=conv_cadenas($des_tipo_comp,0);  
	?>	   
	<tr>
           <td width="100" align="left">'<? echo $tipo_comp; ?></td>
           <td width="400" align="left"><? echo $des_tipo_comp; ?></td>
           <td width="100" align="left">'<? echo $cod_contable; ?></td>
           <td width="100" align="left">'<? echo $cod_part_iva; ?></td>
           <td width="100" align="left">'<? echo $func_inv_tpcomp; ?></td>
           <td width="100" align="left">'<? echo $c_imp_unico; ?></td>
         </tr>
	<? }  
        ?>
	   <tr>
            <td>&nbsp;</td>
           </tr>
	  <tr>
                <td width="100" align="center"></td>
		<td width="400" align="left"><strong></strong></td>	
            </tr>      
	  </table><?
	}

   }
?>
