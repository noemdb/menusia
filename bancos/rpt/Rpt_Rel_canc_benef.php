<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"]; $tipo_rep=$_GET["tipo_rpt"]; $det_benef=$_GET["det_benef"]; $Sql=""; $date = date("d-m-Y");$hora = date("H:i:s a");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{   $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} } 
 $sSQLb="select sum(monto_mov_libro) from ban004 where (ban004.ced_rif='$cedula_d') and (anulado='N')"; 
 $sSQLb="select ban006.ced_rif,pre099.nombre,pre099.direccion,pre099.rif,pre099.representante_legal,ban006.cod_banco,ban006.num_cheque,ban006.fecha,ban006.nro_Orden_pago,ban006.concepto,ban006.monto_cheque
      from ban006,pre099 where (ban006.ced_rif='$cedula_d') and (ban006.anulado='N') and (ban006.ced_rif=pre099.ced_rif) and (ban006.ced_rif in (select pag001.ced_rif from pag001,pag004,pag003 where (pag001.nro_orden=pag004.nro_orden_ret) and (pag004.tipo_retencion=pag003.tipo_retencion) and (pag003.ret_grupo='I' or pag003.ret_grupo='A') )) 
	   order by ban006.ced_rif,ban006.fecha";	   
 $sSQL="select ban006.ced_rif,pre099.nombre,pre099.direccion,pre099.rif,pre099.representante_legal,sum(ban006.monto_cheque) as monto_tot
      from ban006,pre099 where (ban006.ced_rif>='$cedula_d') and (ban006.ced_rif<='$cedula_h') and (ban006.anulado='N') and (ban006.ced_rif=pre099.ced_rif) and (ban006.ced_rif in (select pag001.ced_rif from pag001,pag004,pag003 where (pag001.nro_orden=pag004.nro_orden_ret) and (pag004.tipo_retencion=pag003.tipo_retencion) and (pag003.ret_grupo='I' or pag003.ret_grupo='A') )) 
	  group by ban006.ced_rif,pre099.nombre,pre099.direccion,pre099.rif,pre099.representante_legal order by ban006.ced_rif";
	  
  if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Canc_beneficiario.xml");
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run();
             $aBench = $oRpt->getBenchmark();
             $iSec   = $aBench["report_end"]-$aBench["report_start"];
    }
    if(($tipo_rep=="PDF")and($det_benef=="NO")){	 
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $tam_logo;  global $criterio1; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',10);
			$this->Cell(80);
			$this->Cell(100,10,'RELACION CANCELACION POR BENEFICIARIO',1,0,'C');
			$this->Ln(18);
			$this->SetFont('Arial','B',7);	
			$this->Cell(20,5,'CEDULA/RIF',1,0,'L');
			$this->Cell(80,5,'NOMBRE',1,0,'L');
			$this->Cell(90,5,'DIRECCION',1,0,'C');
			$this->Cell(50,5,'REPRESENTANTE LEGAL',1,0,'C');
			$this->Cell(20,5,'CANCELADO',1,1,'C');
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
	  $pdf->SetFont('Arial','',7);
	  $i=0; $cantidad=0; $total=0;
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		   $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $direccion=$registro["direccion"]; $monto_tot=$registro["monto_tot"];
		   $representante_legal=$registro["representante_legal"]; $rif=$registro["rif"]; $total=$total+$monto_tot; $monto_tot=formato_monto($monto_tot); 
           if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre); $direccion=utf8_decode($direccion); $representante_legal=utf8_decode($representante_legal);}
		   $pdf->Cell(20,4,$ced_rif,0,0,'L'); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $n=80; $m=90; $w=50;
		   $pdf->SetXY($x+$n+$m+$w,$y);
	   	   $pdf->Cell(20,4,$monto_tot,0,0,'R');
		   $pdf->SetXY($x,$y);	
		   if(strlen(trim($direccion))>strlen(trim($nombre))){	
		   $pdf->MultiCell($n,4,$nombre,0);
		   $pdf->SetXY($x+$n+$m,$y);	
		   $pdf->MultiCell($w,4,$representante_legal,0);
		   $pdf->SetXY($x+$n,$y);	
		   $pdf->MultiCell($m,4,$direccion,0); }
		   else{		   
		   $pdf->SetXY($x+$n+$m,$y);	
		   $pdf->MultiCell($w,4,$representante_legal,0);
		   $pdf->SetXY($x+$n,$y);	
		   $pdf->MultiCell($m,4,$direccion,0);
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,4,$nombre,0);		    }
      }  $total=formato_monto($total); 
	  $pdf->Cell(240,2,'',0,0);
      $pdf->Cell(20,2,'==============',0,1,'R');
	  $pdf->Cell(240,5,'TOTAL GENERAL: ',0,0,'R');
	  $pdf->Cell(20,5,$total,0,1,'R'); 				 
	  $pdf->Output(); 
	}	
	if(($tipo_rep=="PDF")and($det_benef=="SI")){
	      $res=pg_query($sSQLb); $filas=pg_num_rows($res); $ced_rif=""; $nombre=""; 
	      if($filas>=1){$registro=pg_fetch_array($res,0); $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $direccion=$registro["direccion"];
		  if($php_os=="WINNT"){$nombre=$nombre;} else{$nombre=utf8_decode($nombre);}  }
		 
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $tam_logo;  global $criterio1; global $ced_rif; global $nombre; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',10);
			$this->Cell(80);
			$this->Cell(100,10,'RELACION CANCELACION POR BENEFICIARIO',1,0,'C');
			$this->Ln(18);
			$this->SetFont('Arial','B',8);
			$this->Cell(200,5,'BENEFICIARIO : '.$ced_rif.' '.$nombre,0,1,'L');
			$this->SetFont('Arial','B',7);	
			$this->Cell(20,5,'FECHA',1,0,'L');
			$this->Cell(20,5,'COD.BANCO',1,0,'L');
			$this->Cell(20,5,'NUM.CHEQUE',1,0,'C');
			$this->Cell(20,5,'NUM.ORDEN',1,0,'C');
			$this->Cell(160,5,'CONCEPTO',1,0,'C');
			$this->Cell(20,5,'CANCELADO',1,1,'C');
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
	  $pdf->SetFont('Arial','',7);
	  $i=0; $cantidad=0; $total=0;
	  $res=pg_query($sSQLb);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		   $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $direccion=$registro["direccion"]; $monto_tot=$registro["monto_cheque"]; $num_cheque=$registro["num_cheque"]; 
		   $nro_orden_pago=$registro["nro_orden_pago"]; $concepto=$registro["concepto"]; $fechae=$registro["fecha"]; $cod_banco=$registro["cod_banco"];
		   $representante_legal=$registro["representante_legal"]; $rif=$registro["rif"]; $total=$total+$monto_tot; $monto_tot=formato_monto($monto_tot); $fechae=formato_ddmmaaaa($fechae);
           if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre); $direccion=utf8_decode($direccion); $representante_legal=utf8_decode($representante_legal);}
		   $pdf->Cell(20,4,$fechae,0,0,'L');
		   $pdf->Cell(20,4,$cod_banco,0,0,'L');
		   $pdf->Cell(20,4,$num_cheque,0,0,'L');
		   $pdf->Cell(20,4,$nro_orden_pago,0,0,'L');
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $n=160;
		   $pdf->SetXY($x+$n,$y);
	   	   $pdf->Cell(20,4,$monto_tot,0,0,'R');
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($n,4,$concepto,0);
		   
      }  $total=formato_monto($total); 
	  $pdf->Cell(240,2,'',0,0);
      $pdf->Cell(20,2,'==============',0,1,'R');
	  $pdf->Cell(240,5,'TOTAL BENEFICIARIO: ',0,0,'R');
	  $pdf->Cell(20,5,$total,0,1,'R'); 				 
	  $pdf->Output();	
	}
	if($tipo_rep=="EXCEL"){	
	     header("Content-type: application/vnd.ms-excel");
         header("Content-Disposition: attachment; filename=Rel_Cancelaciones_Beneficiario.xls");		
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RELACION CANCELACION POR BENEFICIARIO</strong></font></td>
	     </tr>
	      <tr height="20">
	     </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Cedula/Rif</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
           <td width="400" align="center" bgcolor="#99CCFF"><strong>Direccion</strong></td>
           <td width="300" align="center" bgcolor="#99CCFF"><strong>Representante</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Cancelado</strong></td>
         </tr>
     <?	  
	  $i=0; $cantidad=0; $res=pg_query($sSQL); $total=0;
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		$ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $direccion=$registro["direccion"]; $monto_tot=$registro["monto_tot"];
		$representante_legal=$registro["representante_legal"]; $rif=$registro["rif"]; $total=$total+$monto_tot; $monto_tot=formato_monto($monto_tot); 
		$nombre=conv_cadenas($nombre,0); $direccion=conv_cadenas($direccion,0);  $representante_legal=conv_cadenas($representante_legal,0); 
	?>	   
	    <tr>
           <td width="100" align="left"><? echo $ced_rif; ?></td>
           <td width="400" align="left"><? echo $nombre; ?></td>
           <td width="400" align="left"><? echo $direccion; ?></td>
           <td width="300" align="left"><? echo $representante_legal; ?></td>
           <td width="100" align="right"><? echo $monto_tot; ?></td>
         </tr>
	
	<? } ?>
	      
	  </table><?
	}
}
?>