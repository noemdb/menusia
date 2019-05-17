<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$periodod=$_GET["periodod"];$imprimir=$_GET["imprimir"];$tipo_rep=$_GET["tipo_rep"];$Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{ $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }  }
$cfecha=formato_ddmmaaaa($Fec_Ini_Ejer); $cfecha="01/01/".substr($cfecha,6,4); 
$sql_saldo="(BAN002.S_Inic_Libro+(BAN002.Deb_Libro01-BAN002.Cre_Libro01)";
if($periodod>="02"){ $cfecha="01/02/".substr($cfecha,6,4);  $sql_saldo=$sql_saldo."+(BAN002.Deb_Libro02-BAN002.Cre_Libro02)";}
if($periodod>="03"){ $cfecha="01/03/".substr($cfecha,6,4);  $sql_saldo=$sql_saldo."+(BAN002.Deb_Libro03-BAN002.Cre_Libro03)";}
if($periodod>="04"){ $cfecha="01/04/".substr($cfecha,6,4);  $sql_saldo=$sql_saldo."+(BAN002.Deb_Libro04-BAN002.Cre_Libro04)";}
if($periodod>="05"){ $cfecha="01/05/".substr($cfecha,6,4);  $sql_saldo=$sql_saldo."+(BAN002.Deb_Libro05-BAN002.Cre_Libro05)";}
if($periodod>="06"){ $cfecha="01/06/".substr($cfecha,6,4);  $sql_saldo=$sql_saldo."+(BAN002.Deb_Libro06-BAN002.Cre_Libro06)";}
if($periodod>="07"){ $cfecha="01/07/".substr($cfecha,6,4);  $sql_saldo=$sql_saldo."+(BAN002.Deb_Libro07-BAN002.Cre_Libro07)";}
if($periodod>="08"){ $cfecha="01/08/".substr($cfecha,6,4);  $sql_saldo=$sql_saldo."+(BAN002.Deb_Libro08-BAN002.Cre_Libro08)";}
if($periodod>="09"){ $cfecha="01/09/".substr($cfecha,6,4);  $sql_saldo=$sql_saldo."+(BAN002.Deb_Libro09-BAN002.Cre_Libro09)";}
if($periodod>="10"){ $cfecha="01/10/".substr($cfecha,6,4);  $sql_saldo=$sql_saldo."+(BAN002.Deb_Libro10-BAN002.Cre_Libro10)";}
if($periodod>="11"){ $cfecha="01/11/".substr($cfecha,6,4);  $sql_saldo=$sql_saldo."+(BAN002.Deb_Libro11-BAN002.Cre_Libro11)";}
if($periodod>="12"){ $cfecha="01/12/".substr($cfecha,6,4);  $sql_saldo=$sql_saldo."+(BAN002.Deb_Libro12-BAN002.Cre_Libro12)";}
$sql_saldo_act=$sql_saldo." ) as saldo_actual,";
$sql_criterio="AND (BAN002.cod_banco>='".$cod_banco_d."' AND BAN002.cod_banco<='".$cod_banco_h."') ";
if($imprimir=="N"){$sql_criterio=$sql_criterio." AND (".$sql_saldo.") <>0) "; }  
$fecha_d=colocar_udiames($cfecha); $criterio1="A la Fecha: ". $fecha_d; 
 $sSQL  = "SELECT BAN002.cod_banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN002.Tipo_Cuenta, BAN002.Cod_Contable,   BAN002.Num_Cheque, BAN002.S_Inic_Libro, BAN002.S_Inic_Banco,". $sql_saldo_act .                
          "BAN001.Descripcion_Tipo, BAN009.U_Conciliacion  FROM BAN001 BAN001, BAN002 BAN002 LEFT outer JOIN BAN009 BAN009 ON BAN002.cod_banco=BAN009.cod_banco     WHERE BAN001.Tipo_Cuenta = BAN002.Tipo_Cuenta ".$sql_criterio."  ORDER BY BAN002.cod_banco ";
    if($tipo_rep=="HTML"){   include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Relacion_Cuentas_Bancarias.xml");
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
              $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1,"date"=>$date,"hora"=>$hora));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run();
             $aBench = $oRpt->getBenchmark();
             $iSec   = $aBench["report_end"]-$aBench["report_start"];
	}	
	if($tipo_rep=="PDF"){	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){ global $criterio1; global $tam_logo;  
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(30);
			$this->Cell(100,10,'REPORTE DE CUENTAS BANCARIAS',1,0,'C');
			$this->Ln(17);
			$this->SetFont('Arial','B',8);
            $this->Cell(100,10,$criterio1,0,1,'L');
            $this->SetFont('Arial','B',7);			
			$this->Cell(12,5,'CODIGO',1,0);
			$this->Cell(89,5,'NOMBRE BANCO',1,0);
			$this->Cell(34,5,'NRO CUENTA',1,0,'C');
			$this->Cell(30,5,'CODIGO CONTABLE',1,0,'C');
			$this->Cell(16,5,'MES CONC.',1,0,'C');
			$this->Cell(20,5,'SALDO ACTUAL',1,1,'C');
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
	  $pdf->SetFont('Arial','',8);
	  $i=0;  $total=0; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $cod_contable=$registro["cod_contable"]; 
	       $u_conciliacion=$registro["u_conciliacion"]; $saldo_actual=$registro["saldo_actual"]; 	   $total=$total+$saldo_actual;  $saldo_actual=formato_monto($saldo_actual);
	       if($php_os=="WINNT"){$nombre_banco=$registro["nombre_banco"]; } else{$nombre_banco=utf8_decode($nombre_banco);}	 
		   $pdf->Cell(10,3,$cod_banco,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=89;
		   $pdf->SetXY($x+$n,$y);		   
		   $pdf->Cell(36,3,substr($nro_cuenta,0,21),0,0,'L'); 
		   $pdf->Cell(29,3,$cod_contable,0,0,'L');
		   $pdf->Cell(16,3,$u_conciliacion,0,0,'C');
		   $pdf->Cell(20,3,$saldo_actual,0,1,'R');
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$nombre_banco,0);  
		} $total=formato_monto($total); 
		$pdf->SetFont('Arial','B',8);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(180,3,'',0,0);
		$pdf->Cell(20,3,'===============',0,1,'R');
		$pdf->Cell(180,3,'Totales : ',0,0,'R');
		$pdf->Cell(20,3,$total,0,1,'R'); 		 
		$pdf->Output();   
    }
    if($tipo_rep=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Rpt_Relacion_Cuentas_Bancarias.xls");	
	
	?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
			<td width="100" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RELACION DE CUENTAS BANCARIAS</strong></font></td>
	     </tr>
		  <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
            <td width="400" align="center" > <strong><? echo $criterio1; ?></strong></td>
        </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CODIGO</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>NOMBRE BANCO</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>NRO. CUENTA</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>CODIGO CONTABLE</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>MES CONC.</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>MONTO</strong></font></td>
         </tr>
     <?	  
	  $i=0;  $total=0; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $cod_contable=$registro["cod_contable"]; 
	       $u_conciliacion=$registro["u_conciliacion"];  $saldo_actual=$registro["saldo_actual"];  $total=$total+$saldo_actual; 
		   $saldo_actual=formato_monto($saldo_actual); $nombre_banco=conv_cadenas($nombre_banco,0);  
	    ?>	   
	    <tr>
           <td width="100" align="left">'<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_banco; ?></td>
           <td width="400" align="justify"><? echo $nombre_banco; ?></td>
           <td width="300" align="left">'<? echo $nro_cuenta; ?></td>
           <td width="300" align="left"><? echo $cod_contable; ?></td>
           <td width="100" align="center"><? echo $u_conciliacion; ?></td>
           <td width="100" align="right"><? echo $saldo_actual; ?></td>
         </tr>
	<? } $total=formato_monto($total); ?>   
   <tr>
         <td width="100"><span class="Estilo5"></span></td>
         <td width="400"><span class="Estilo5"></span></td>
         <td width="100"><span class="Estilo5"></span></td>
         <td width="100"><span class="Estilo5"></span></td>
         <td width="100"><span class="Estilo5"><strong>TOTAL :</strong></span></td>
         <td width="100"><table width="150" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td align="right" class="Estilo5"><strong><? echo $total; ?></strong></td>
           </tr>
         </table></td> 
    </tr>
	  </table><?
	}   
?>

