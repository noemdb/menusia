<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$periodod=$_GET["periodod"];$imprimir=$_GET["imprimir"]; $tipo_rep=$_GET["tipo_rep"]; $Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{ $Nom_Emp=busca_conf();  $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
$cfecha=formato_ddmmaaaa($Fec_Ini_Ejer); $cfecha="01/".$periodod."/".substr($cfecha,6,4);  $fecha_d=$cfecha; $fecha_h=colocar_udiames($cfecha); $criterio1=$fecha_h;
if($fecha_d==""){$sfecha_d="2010-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}if($fecha_h==""){$sfecha_h="2010-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
$mcod_m="BAN023".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$Sql="SELECT RPT_MES_BAN023('".$codigo_mov."','".$sfecha_d."','".$sfecha_h."','".$cod_banco_d."','".$cod_banco_h."','".$imprimir."')";
    $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);      $error="ERROR : ".substr($error,0,91);
    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }     
    $sSQL = "SELECT cod_banco,nombre_banco,nro_cuenta,monto1,monto2,monto3,monto4,monto5,(monto1+monto2-monto3) as saldo_ini, (monto1+monto2-monto3+monto4-monto5) as saldo_act from ban023 where codigo_mov='$codigo_mov' order by ban023.cod_banco";
  
   if($tipo_rep=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");  
		  $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_Disponibilidad_Bancaria_Mensual.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("$host");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
   }
   if($tipo_rep=="PDF"){	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){ global $criterio1; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(30);
			$this->Cell(150,10,'REPORTE DISPONIBILIDAD BANCARIA MENSUAL',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(200,10,'FECHA AL: '.$criterio1,0,1,'C');	
			$this->SetFont('Arial','B',7);
			$this->Cell(11,5,'CODIGO',1,0);
			$this->Cell(77,5,'NOMBRE BANCO',1,0);
			$this->Cell(29,5,'NRO CUENTA',1,0,'L');
			$this->Cell(23,5,'SALDO ANTERIOR',1,0,'C');
			$this->Cell(20,5,'DEBE.',1,0,'C');
			$this->Cell(19,5,'HABER.',1,0,'C');
			$this->Cell(21,5,'DISPONIBILIDAD',1,1,'C');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			
			// INI NMDB 30-04-2018
	        // $this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
	        $this->Cell(100,5,' ',0,0,'R');
	        // FIN NMDB 30-04-2018
		}
	  }
	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $total=0; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $cod_contable=$registro["cod_contable"]; 
           $saldo_ini=$registro["saldo_ini"]; $monto4=$registro["monto4"]; $monto5=$registro["monto5"]; $saldo_act=$registro["saldo_act"];  $total=$total+$saldo_act; 
		   $saldo_act=formato_monto($saldo_act); $saldo_ini=formato_monto($saldo_ini); $monto4=formato_monto($monto4); $monto5=formato_monto($monto5);
	       if($php_os=="WINNT"){$nombre_banco=$registro["nombre_banco"]; } else{$nombre_banco=utf8_decode($nombre_banco);}  
		   $pdf->Cell(11,5,$cod_banco,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=77; 
		   $pdf->SetXY($x+$n,$y);		   
		   $pdf->Cell(32,5,$nro_cuenta,0,0,'L'); 
		   $pdf->Cell(20,5,$saldo_ini,0,0,'R');
		   $pdf->Cell(20,5,$monto4,0,0,'R');
		   $pdf->Cell(20,5,$monto5,0,0,'R');
		   $pdf->Cell(20,5,$saldo_act,0,1,'R');
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,5,$nombre_banco,0); 
		} $total=formato_monto($total); 
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(180,5,'',0,0);
		$pdf->Cell(20,3,'============',0,1,'R');
		$pdf->Cell(180,3,'Totales : ',0,0,'R');
		$pdf->Cell(20,3,$total,0,1,'R'); 		 
		$pdf->Output();   
    }
    if($tipo_rep=="EXCEL"){	$criterio1='FECHA AL: '.$criterio1;
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Rpt_Disponibilidad_Bancaria_Mensual.xls");	
	
	?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE DISPONIBILIDAD BANCARIA DIARIA</strong></font></td>
	     </tr>
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
            <td width="400" align="center" > <strong><? echo $criterio1; ?></strong></td>
			<td width="300" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
        </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CODIGO</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>NOMBRE BANCO</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>NRO. CUENTA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>SALDO ANTERIOR</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>DEBE</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>HEBER</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>DISPONIBILIDAD</strong></font></td>
         </tr>
     <?
	  
	  $i=0;  $total=0; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $cod_contable=$registro["cod_contable"]; 
           $saldo_ini=$registro["saldo_ini"]; $monto4=$registro["monto4"]; $monto5=$registro["monto5"]; $saldo_act=$registro["saldo_act"];   $total=$total+$saldo_act; 
		   $saldo_act=formato_monto($saldo_act); $saldo_ini=formato_monto($saldo_ini); $monto4=formato_monto($monto4); $monto5=formato_monto($monto5);   $nombre_banco=conv_cadenas($nombre_banco,0);  
	?>	   
	<tr>
           <td width="100" align="left">'<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_banco; ?></td>
           <td width="400" align="justify"><? echo $nombre_banco; ?></td>
           <td width="300" align="left">'<? echo $nro_cuenta; ?></td>
           <td width="100" align="right"><? echo $saldo_ini; ?></td>
           <td width="100" align="right"><? echo $monto4; ?></td>
           <td width="100" align="right"><? echo $monto5; ?></td>
           <td width="100" align="right"><? echo $saldo_act; ?></td>

         </tr>
	<? } $total=formato_monto($total); ?>
   
   <tr>
         <td width="100" align="left"><span class="Estilo5"></span></td>
         <td width="400" align="left"><span class="Estilo5"></span></td>
         <td width="300" align="left"><span class="Estilo5"></span></td>
         <td width="100" align="right"><span class="Estilo5"></span></td>
         <td width="100" align="right"><span class="Estilo5"></span></td>
         <td width="100"><span class="Estilo5"><strong>TOTAL :</strong></span></td>
         <td width="100"><table width="150" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td align="right" class="Estilo5"><strong><? echo $total; ?></strong></td>
           </tr>
         </table></td> 
    </tr>
	  </table><?
	}
	 $Sql="Delete from ban023 Where (codigo_mov='".$codigo_mov."')"; $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);
}   
?>
