<? include ("../../class/seguridad.inc"); include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); include ("../../class/phpreports/PHPReportMaker.php");
   $tipo_nomina_d=$_GET["tipo_nomina_d"];$tipo_nomina_h=$_GET["tipo_nomina_h"];$cod_concepto_d=$_GET["cod_concepto_d"];$cod_concepto_h=$_GET["cod_concepto_h"]; $tipo_rpt=$_GET["tipo_rpt"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{  $php_os=PHP_OS;  $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}

   $sSQL = "SELECT nom048.tipo_nomina, nom001.descripcion, nom048.cod_concepto, nom002.denominacion, nom048.consecutivo, nom048.accion, nom048.rango_inicial, nom048.rango_final, nom048.Calculo1, nom048.Calculo2, nom048.CalculoFinal  
           FROM NOM001 NOM001, NOM002 NOM002, nom048 nom048  WHERE nom048.Cod_Concepto = NOM002.Cod_Concepto AND nom048.Tipo_Nomina = NOM001.Tipo_Nomina AND nom048.Tipo_Nomina = NOM002.tipo_nomina  AND
                   NOM002.Tipo_Nomina>='".$tipo_nomina_d."' AND NOM002.Tipo_Nomina<='".$tipo_nomina_h."'  AND
                   NOM002.Cod_Concepto>='".$cod_concepto_d."' AND NOM002.Cod_Concepto<='".$cod_concepto_h."'ORDER BY nom048.tipo_nomina, nom048.cod_concepto, nom048.consecutivo";

  if($tipo_rpt=="HTML"){
	  $oRpt = new PHPReportMaker();
	  $oRpt->setXML("Cat_formu_concep_ext_re.xml");
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
  if($tipo_rpt=="PDF"){	 $res=pg_query($sSQL);  $tipo_nomina_grupo=""; $cod_concepto_grupo="";
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tipo_nomina_grupo; global $cod_concepto_grupo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,10,'CATALOGO DE FORMULA EXTRAORDINARIAS',1,0,'C');
			$this->Ln(18);
			$this->SetFont('Arial','B',8);
			$this->Cell(20,5,'CONSECUTIVO',1,0,'C');
			$this->Cell(12,5,'ACCION',1,0,'C');
			$this->Cell(23,5,'RANGO INICIAL',1,0,'C');
			$this->Cell(25,5,'RANGO FINAL',1,0,'C');
			$this->Cell(120,5,'RESULTADO 1',1,1,'C');
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
	  $i=0; $cantidad=0; $total_cantidad=0; $prev_tipo_nomina=""; $prev_descripcion=""; $prev_cod_concepto="";
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		    $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];
			if($php_os=="WINNT"){$descripcion=$registro["descripcion"]; }else{$descripcion=utf8_decode($descripcion);$denominacion=utf8_decode($denominacion);}
			$tipo_nomina_grupo=$tipo_nomina; $descripcion_grupo=$descripcion; $cod_concepto_grupo=$cod_concepto; $denominacion_grupo=$denominacion;
            $pdf->SetFont('Arial','B',8);
            if($prev_tipo_nomina<>$tipo_nomina_grupo){ 
                if($cantidad>0){ $pdf->Cell(150,5,'FORMULAS DE :'.$prev_descripcion."    ".$cantidad,0,1,'L');$pdf->Ln(5); }
			    $pdf->Cell(20,5,$tipo_nomina_grupo,0,0,'C');
				$pdf->Cell(180,5,$descripcion_grupo,0,1,'L');
				$prev_tipo_nomina=$tipo_nomina_grupo; $prev_descripcion=$descripcion_grupo; $cantidad=0; }
            if($prev_cod_concepto<>$cod_concepto_grupo){ $pdf->Ln(2);
				$pdf->Cell(20,5,$cod_concepto_grupo,0,0,'C');
				$pdf->Cell(180,5,$denominacion_grupo,0,1,'L');
				$prev_cod_concepto=$cod_concepto_grupo; }  

		    $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; 
		    $consecutivo=$registro["consecutivo"]; $accion=$registro["accion"]; $rango_inicial=$registro["rango_inicial"]; $rango_final=$registro["rango_final"];  
	        $calculo1=$registro["calculo1"]; $calculo2=$registro["calculo2"]; $calculofinal=$registro["calculofinal"]; $cantidad=$cantidad+1; $total_cantidad=$total_cantidad+1;
		    $pdf->SetFont('Arial','',8); 
		    $pdf->Cell(20,3,$consecutivo,0,0,'C'); 
            $pdf->Cell(10,3,$accion,0,0,'C'); 		   
            $pdf->Cell(25,3,$rango_inicial,0,0,'R'); 
            $pdf->Cell(25,3,$rango_final,0,0,'R'); 
		    $pdf->Cell(120,3,$calculo1,0,1,'C'); 
		    $pdf->Cell(80,5,'RESULTADO 2 : ',0,0,'R');
			$pdf->Cell(120,5,$calculo2,0,1,'C');
		    $pdf->Cell(80,5,'RESULTADO FINAL : ',0,0,'R');
		    $pdf->Cell(120,5,$calculofinal,0,1,'C');
            $pdf->Ln(2);
		   } $pdf->SetFont('Arial','B',8);
            if($cantidad>0){ $pdf->Cell(200,5,'FORMULAS DE :'.$prev_descripcion."    ".$cantidad,0,1,'L');$pdf->Ln(5); }
		   	
		   $pdf->Cell(100,3,'TOTAL FORMULAS: '.$total_cantidad,0,1,'L');			 
		   $pdf->Output();   
    }	  
    if($tipo_rpt=="EXCEL"){ $res=pg_query($sSQL);  $tipo_nomina_grupo=""; $cod_concepto_grupo="";
	  header("Content-type: application/vnd.ms-excel");
          header("Content-Disposition: attachment; filename=Catalago_Formulas_Conceptos_ext.xls");		
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		        <td width="100" align="left" ><strong></strong></td>
                <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CATALOGO DE FORMULAS EXTRAORDINARIAS</strong></font></td>
	      </tr>
	      <tr height="20">
	     </tr>
             <tr height="20">
           	<td width="100" align="center" bgcolor="#99CCFF"><strong>CONSECUTIVO</strong></td>
           	<td width="400" align="center" bgcolor="#99CCFF"><strong>ACCION</strong></td>
           	<td width="100" align="center" bgcolor="#99CCFF" ><strong>RANGO INICIAL</strong></font></td>
           	<td width="100" align="center" bgcolor="#99CCFF" ><strong>RANGO FINAL</strong></font></td>
           	<td width="400" align="center" bgcolor="#99CCFF" ><strong>RESULTADO 1</strong></font></td>
        </tr>
     <?	  
	  $i=0; $cantidad=0; $total_cantidad=0; $prev_tipo_nomina=""; $prev_descripcion=""; $prev_cod_concepto="";
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		    $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];
            $tipo_nomina_grupo=$tipo_nomina; $descripcion_grupo=$descripcion; $cod_concepto_grupo=$cod_concepto; $denominacion_grupo=$denominacion;
            $descripcion=conv_cadenas($descripcion,0); $denominacion=conv_cadenas($denominacion,0); 
             if($prev_tipo_nomina<>$tipo_nomina_grupo){ 
                if($cantidad>0){ ?>	   
				    <tr>
           				<td width="100" align="left"><strong>FORMULAS DE:</strong></td>
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
				<?
				$prev_tipo_nomina=$tipo_nomina_grupo; $prev_descripcion=$descripcion_grupo; $cantidad=0; } 
                if($prev_cod_concepto<>$cod_concepto_grupo){ ?>	   
				    <tr>
				      <td width="100" align="left"></td>
			        </tr>
				    <tr>
           				<td width="100" align="left">'<? echo $cod_concepto_grupo; ?></td>
           				<td width="400" align="left"><? echo $denominacion_grupo; ?></td>

         			</tr>
			        <tr>
				      <td width="100" align="left"></td>
			        </tr>
				<?
				$prev_tipo_nomina=$tipo_nomina_grupo; $prev_descripcion=$descripcion_grupo; $cantidad=0; } 

		    $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; 
		    $consecutivo=$registro["consecutivo"]; $accion=$registro["accion"]; $rango_inicial=$registro["rango_inicial"]; $rango_final=$registro["rango_final"];  
	        $calculo1=$registro["calculo1"]; $calculo2=$registro["calculo2"]; $calculofinal=$registro["calculofinal"]; $cantidad=$cantidad+1; $total_cantidad=$total_cantidad+1;
		?>	 
			    <tr>
           			<td width="100" align="center"><? echo $consecutivo; ?></td>
           			<td width="400" align="center"><? echo $accion; ?></td>
           			<td width="100" align="center"><? echo $rango_inicial; ?></td>
           			<td width="100" align="center"><? echo $rango_final; ?></td>
           			<td width="400" align="center"><? echo $calculo1; ?></td>
         		</tr>
			   <tr>
				 <td width="100" align="left"></td>
			   </tr>
			    <tr>
           			<td width="100" align="center"></td>
           			<td width="400" align="center"></td>
           			<td width="100" align="center">RESULTADO 2</td>
           			<td width="400" align="left"><? echo $calculo2; ?></td>
           			<td width="100" align="center"></td>
         		</tr>
			   <tr>
           			<td width="100" align="center"></td>
           			<td width="400" align="center"></td>
           			<td width="100" align="center">RESULTADO FINAL</td>
           			<td width="400" align="left"><? echo $calculofinal; ?></td>
           			<td width="100" align="center"></td>
         		</tr>
		<? }
                 if($cantidad>0){ ?>	   
				    <tr>
           				<td width="100" align="left"><strong>FORMULAS DE:</strong></td>
           				<td width="400" align="left"><strong><? echo $prev_descripcion."    ".$cantidad; ?></strong></td>
         			</tr>
			        <tr>
				      <td width="100" align="left"></td>
			        </tr>
				<?}?>	
	  </table><?
	}

   }
?>
