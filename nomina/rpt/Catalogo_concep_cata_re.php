<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$tipo_nomina_d=$_GET["tipo_nomina_d"];$tipo_nomina_h=$_GET["tipo_nomina_h"];$cod_concepto_d=$_GET["cod_concepto_d"];$cod_concepto_h=$_GET["cod_concepto_h"]; $tipo_rpt=$_GET["tipo_rpt"]; $php_os=PHP_OS; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}

  $sSQL = "SELECT nom002.tipo_nomina, nom001.descripcion, nom002.cod_concepto, nom002.denominacion, nom002.Cod_Partida, nom002.Asignacion,
            nom002.Activo, nom002.Inicializable, nom002.Tipo_Grupo, nom002.Oculto, nom002.Acumula, nom002.Frecuencia, nom002.Cod_Cat_Alter,
            nom002.Cod_Contable, nom002.Tipo_Asigna, nom002.Asig_Ded_Apo, nom002.Inicializable_C, nom002.Afecta_Presup, nom002.Cod_Retencion,
            nom002.Grupo_Retencion, nom002.Status  FROM nom001, nom002
            WHERE nom001.tipo_nomina = nom002.tipo_nomina and nom002.tipo_nomina>='".$tipo_nomina_d."' and nom002.tipo_nomina<='".$tipo_nomina_h."'  and
            nom002.cod_concepto>='".$cod_concepto_d."' and nom002.cod_concepto<='".$cod_concepto_h."' ORDER BY nom002.tipo_nomina,nom002.cod_concepto";
	  
  if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
	  $oRpt = new PHPReportMaker();
	  $oRpt->setXML("Catalogo_concep_cata_re.xml");
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
  if($tipo_rpt=="PDF"){	 $res=pg_query($sSQL);  $tipo_nomina_grupo=""; 
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tipo_nomina;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(200,10,'CATALOGO DE CONCEPTOS',1,0,'C');
			$this->Ln(18);
			$this->SetFont('Arial','B',7);
			$this->Cell(15,5,'CODIGO',1,0,'L');
			$this->Cell(100,5,'DENOMINACION CONCEPTO',1,0,'L');
			$this->Cell(25,5,'CODIGO PARTIDA',1,0,'C');
			$this->Cell(15,5,'COD. RET.',1,0,'C');
			$this->Cell(15,5,'ASIGNAC.',1,0,'C');
			$this->Cell(15,5,'ACTIVO',1,0,'C');
			$this->Cell(15,5,'INICIAL.',1,0,'C');
			$this->Cell(15,5,'GRUPO',1,0,'C');
			$this->Cell(15,5,'OCULTO',1,0,'C');
			$this->Cell(15,5,'ACUMULA',1,0,'C');
			$this->Cell(15,5,'FRECUEN',1,1,'C');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',8);
	  $i=0; $cantidad=0; $total_cantidad=0; $prev_tipo_nomina=""; $prev_descripcion=""; $prev_cod_concepto="";
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		    $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; $cod_concepto=$registro["cod_concepto"];
            if($php_os=="WINNT"){$descripcion=$registro["descripcion"]; }else{$descripcion=utf8_decode($descripcion);}
            $tipo_nomina_grupo=$tipo_nomina; $descripcion_grupo=$descripcion; $cod_concepto_grupo=$cod_concepto;
            $pdf->SetFont('Arial','B',8);
            if($prev_tipo_nomina<>$tipo_nomina_grupo){ 
              if($cantidad>0){$pdf->Cell(240,5,'CONCEPTOS DE : '.$prev_descripcion."    ".$cantidad,0,1,'L');$pdf->Ln(5); }
			  $pdf->Cell(240,5,$tipo_nomina_grupo."    ".$descripcion_grupo,0,1,'L');
			  $prev_tipo_nomina=$tipo_nomina_grupo; $prev_descripcion=$descripcion_grupo; $cantidad=0; } 

		    $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; 
		    $cod_partida=$registro["cod_partida"]; $cod_retencion=$registro["cod_retencion"]; $asignacion=$registro["asignacion"]; $activo=$registro["activo"];  
	        $inicializable=$registro["inicializable"]; $tipo_grupo=$registro["tipo_grupo"]; $oculto=$registro["oculto"]; $acumula=$registro["acumula"];  
		    $frecuencia=$registro["frecuencia"]; $cantidad=$cantidad+1; $total_cantidad=$total_cantidad+1;
            if($php_os=="WINNT"){$descripcion=$registro["descripcion"]; }else{$descripcion=utf8_decode($descripcion);$denominacion=utf8_decode($denominacion);}
		    $pdf->SetFont('Arial','',8); 
		    $pdf->Cell(15,3,$cod_concepto,0,0,'L'); 		   
		    $x=$pdf->GetX();   $y=$pdf->GetY();  $w=100;		   
		    $pdf->SetXY($x+$w,$y);
		    $pdf->Cell(25,3,$cod_partida,0,0,'C'); 
            $pdf->Cell(15,3,$cod_retencion,0,0,'C'); 		   
		    $pdf->Cell(15,3,$asignacion,0,0,'C'); 
		    $pdf->Cell(15,3,$activo,0,0,'C'); 
		    $pdf->Cell(15,3,$inicializable,0,0,'C'); 
		    $pdf->Cell(15,3,$tipo_grupo,0,0,'C'); 
		    $pdf->Cell(15,3,$oculto,0,0,'C'); 
		    $pdf->Cell(15,3,$acumula,0,0,'C'); 
		    $pdf->Cell(15,3,$frecuencia,0,1,'C'); 
		    $pdf->SetXY($x,$y);	
		    $pdf->MultiCell($w,3,$denominacion,0); 
		   } 
		    $pdf->SetFont('Arial','B',8); 
            if($cantidad>0){$pdf->Cell(240,5,'CONCEPTOS DE : '.$prev_descripcion."    ".$cantidad,0,1,'L'); $pdf->Ln(5);}
		    $pdf->Cell(200,3,'',0,1,'L');	
		    $pdf->Cell(50,3,'TOTAL CONCEPTOS :  '.$total_cantidad,0,0,'L');			 
		    $pdf->Output();   
    }	  
    if($tipo_rpt=="EXCEL"){ $res=pg_query($sSQL);  $tipo_nomina_grupo=""; 
	      header("Content-type: application/vnd.ms-excel");
          header("Content-Disposition: attachment; filename=Catalago_Conceptos.xls");		
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		        <td width="100" align="left" ><strong></strong></td>
                <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CATALOGO DE CONCEPTOS</strong></font></td>
	      </tr>
	      <tr height="20">
	      </tr>
          <tr height="20">
           	<td width="100" align="left" bgcolor="#99CCFF"><strong>CODIGO</strong></td>
           	<td width="400" align="left" bgcolor="#99CCFF"><strong>DENOMINACION</strong></td>
           	<td width="100" align="center" bgcolor="#99CCFF" ><strong>CODIGO PARTIDA</strong></font></td>
           	<td width="100" align="center" bgcolor="#99CCFF" ><strong>COD. RET.</strong></font></td>
           	<td width="100" align="center" bgcolor="#99CCFF" ><strong>ASIG.</strong></font></td>
           	<td width="100" align="center" bgcolor="#99CCFF" ><strong>ACT</strong></font></td>
           	<td width="100" align="center" bgcolor="#99CCFF" ><strong>INIC</strong></font></td>
           	<td width="100" align="center" bgcolor="#99CCFF" ><strong>TIPO</strong></font></td>
           	<td width="100" align="center" bgcolor="#99CCFF" ><strong>OCULTO</strong></font></td>
           	<td width="100" align="center" bgcolor="#99CCFF" ><strong>ACUM</strong></font></td>
           	<td width="100" align="center" bgcolor="#99CCFF" ><strong>FREC</strong></font></td>
           </tr>
     <?	  
	  $i=0; $cantidad=0;  $total_cantidad=0; $prev_tipo_nomina=""; $prev_descripcion=""; $prev_cod_concepto="";
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		    $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; $cod_concepto=$registro["cod_concepto"];
            $tipo_nomina_grupo=$tipo_nomina; $descripcion_grupo=$descripcion; $cod_concepto_grupo=$cod_concepto;
            $descripcion=conv_cadenas($descripcion,0); 
            if($prev_tipo_nomina<>$tipo_nomina_grupo){ 
                if($cantidad>0){ ?>	   
				<tr>
           			<td width="100" align="left"><strong>CONCEPTOS DE:</strong></td>
           			<td width="400" align="left"><strong><? echo $prev_descripcion."    ".$cantidad; ?></strong></td>
                </tr>
			    <tr>
				  <td width="100" align="left"></td>
			     </tr>
				<?}?>	   
				<tr>
           			<td width="100" align="left"><strong>'<? echo $tipo_nomina_grupo; ?></strong></td>
           			<td width="400" align="left"><strong><? echo $descripcion_grupo; ?></strong></td>
         		</tr>
			    <tr>
				  <td width="100" align="left"></td>
			     </tr>
			<?$prev_tipo_nomina=$tipo_nomina_grupo; $prev_descripcion=$descripcion_grupo; $cantidad=0; } 
			$tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; 
			$cod_partida=$registro["cod_partida"]; $cod_retencion=$registro["cod_retencion"]; $asignacion=$registro["asignacion"]; $activo=$registro["activo"];  
			$inicializable=$registro["inicializable"]; $tipo_grupo=$registro["tipo_grupo"]; $oculto=$registro["oculto"]; $acumula=$registro["acumula"];  
			$frecuencia=$registro["frecuencia"]; $cantidad=$cantidad+1; $total_cantidad=$total_cantidad+1;$denominacion=conv_cadenas($denominacion,0);  
			?>	 
			<tr>
           			<td width="100" align="left">'<? echo $cod_concepto; ?></td>
           			<td width="400" align="left"><? echo $denominacion; ?></td>
           			<td width="100" align="center"><? echo $cod_partida; ?></td>
           			<td width="100" align="center"><? echo $cod_retencion; ?></td>
           			<td width="100" align="center"><? echo $asignacion; ?></td>
           			<td width="100" align="center"><? echo $activo; ?></td>
           			<td width="100" align="center"><? echo $inicializable; ?></td>
           			<td width="100" align="center"><? echo $tipo_grupo; ?></td>
           			<td width="100" align="center"><? echo $oculto; ?></td>
           			<td width="100" align="center"><? echo $acumula; ?></td>
           			<td width="100" align="center"><? echo $frecuencia; ?></td>
         	</tr>
		<? }
            if($cantidad>0){ ?>	   
				<tr>
					<td width="100" align="left"><strong>CONCEPTOS DE:</strong></td>
					<td width="400" align="left"><strong><? echo $prev_descripcion."    ".$cantidad; ?></strong></td>
         		</tr>
			   <tr>
				  <td width="100" align="left"></td>
			    </tr>
			<?}  ?>
	       <tr>
              <td>&nbsp;</td>
           </tr>
	        <tr>
                <td width="100" align="center"></td>
		       <td width="400" align="left"><strong>TOTAL CONCEPTOS: : <? echo $total_cantidad; ?></strong></td>	
            </tr>      
	  </table><?
	}

}
?>
