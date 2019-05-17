<?  error_reporting(E_ALL ^ E_NOTICE); include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); 
$partida_d=$_GET["partida_d"];   $partida_h=$_GET["partida_h"];   $fuente_d=$_GET["fuente_d"];  $fuente_h=$_GET["fuente_h"]; $tipo_rep=$_GET["tipo_rep"]; $det_modif=$_GET["det_modif"]; $php_os=PHP_OS;
$sSQL1="(traslados01+traslados02+traslados03+traslados04+traslados05+traslados06+traslados07+traslados08+traslados09+traslados10+traslados11+traslados12)";
$sSQL2="(trasladon01+trasladon02+trasladon03+trasladon04+trasladon05+trasladon06+trasladon07+trasladon08+trasladon09+trasladon10+trasladon11+trasladon12)";
$sSQL3="(adicion01+adicion02+adicion03+adicion04+adicion05+adicion06+adicion07+adicion08+adicion09+adicion10+adicion11+adicion12)";
$sSQL4="(disminucion01+disminucion02+disminucion03+disminucion04+disminucion05+disminucion06+disminucion07+disminucion08+disminucion09+disminucion10+disminucion11+disminucion12)";
$mcontrol = array (0,0,0,0,0,0,0,0,0,0);
function buscar_control($clave, $formato){  global $mcontrol;  $j=0;
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} }
  return $actual;
}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
   else{ $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} } } 
   
   $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
   $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];}
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($partida_d,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
   $pos=strrpos($partida_d,"?"); if($pos===false){$en_d=0;}else{$en_d=1;} $pos=strrpos($partida_h,"?"); if($pos===false){$en_h=0;}else{$en_h=1;}   
   if(($en_d==1)or($en_h==1)){$codigo_d=str_replace("?","0",$partida_d); $long_d=strlen($codigo_d); $codigo_h=str_replace("?","9",$partida_h); $long_h=strlen($codigo_h);
	  if(($long_d=$long_u)and ($long_h=$long_u)){ $criterio=""; 
         for ($i=0; $i<10; $i++) { $m=$mcontrol[$i]; $a=$mcontrol[$i-1]; 
		     if ($m<>0){if($i==0){ $len_nivel=$m; $criterio=""; }else{ $mpos=1+$a;  $len_nivel=($m-$a-1); $criterio=$criterio." and "; }
				$cod_d=substr($codigo_d,$mpos,$len_nivel); $cod_h=substr($codigo_h,$mpos,$len_nivel);$mpp=$mpos+1;
				$criterio=$criterio."substring(cod_presup,".$mpp.",".$len_nivel.")>='".$cod_d."' and "; $criterio=$criterio."substring(cod_presup,".$mpp.",".$len_nivel.")<='".$cod_h."' ";  }
	     } $criterio=$criterio."and  cod_fuente>='".$fuente_d."' and cod_fuente<='".$fuente_h."'";
	  }else{$criterio="cod_presup>='".$codigo_d."' and cod_presup<='".$codigo_h."' and  cod_fuente>='".$fuente_d."' and cod_fuente<='".$fuente_h."'";}
   }else{$criterio="cod_presup>='".$partida_d."' and cod_presup<='".$partida_h."' and  cod_fuente>='".$fuente_d."' and cod_fuente<='".$fuente_h."'";}
  
   $efiscal=substr($Fec_Fin_Ejer,0,4);   $criterio1="EJERCICIO FISCAL: ".$efiscal;
   $criterio=$criterio." and (length(cod_presup)=$long_u) ";   
   $sSQL = "select cod_presup, cod_fuente, denominacion, asignado, ((".$sSQL1." - ".$sSQL2.") + (".$sSQL3." - ".$sSQL4.")) as modificacion,
   (".$sSQL2." + ".$sSQL4.") as disminuciones, (".$sSQL1." + ".$sSQL3.") as aumentos,
   (asignado+((".$sSQL1." - ".$sSQL2.") + (".$sSQL3." - ".$sSQL4."))) as actualizada from pre001 where ".$criterio." order by cod_presup, cod_fuente";
   
   $nomb_rpt="asignacion_presup_actu_tot.xml";
   if($det_modif=="SI"){ if($tipo_rep=="PDF"){$tipo_rep="PDF2";} else{ $nomb_rpt="asignacion_presup_actu_tot.xml";}  }
   if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
	   $oRpt = new PHPReportMaker();
	   $oRpt->setXML($nomb_rpt);
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
			$this->Cell(120,8,'ASIGNACION PRESUPUESTARIA ACTUALIZADA',1,1,'C');
			$this->Ln(10);			
			$this->SetFont('Arial','B',8);
            $this->Cell(50,5,$criterio1,0,1,'L');
			$this->SetFont('Arial','B',7);
			$this->Cell(40,5,'CODIGO',1,0);
			$this->Cell(84,5,'DENOMINACION',1,0);
			$this->Cell(12,5,'FUENTE',1,0,'C');
			$this->Cell(20,5,'ASIGNACION',1,0,'C');
			$this->Cell(22,5,'MODIFICACIONES',1,0,'C');
			$this->Cell(22,5,'ACTUALIZADA',1,1,'C');
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
	  $i=0;  $total=0; $total_modif=0; $total_actua=0;
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_presup=$registro["cod_presup"];  $cod_fuente=$registro["cod_fuente"];   $denominacion=$registro["denominacion"];  
		   $asignado=$registro["asignado"]; $modificacion=$registro["modificacion"]; $actualizada=$registro["actualizada"];$total=$total+$asignado; $asignado=formato_monto($asignado); 
		   $total_modif=$total_modif+$modificacion; $modificacion=formato_monto($modificacion); $total_actua=$total_actua+$actualizada; $actualizada=formato_monto($actualizada); 
           if($php_os=="WINNT"){$denominacion=$denominacion; }   else{$denominacion=utf8_decode($denominacion); }
		   $pdf->Cell(40,4,$cod_presup,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=86; 		   
		   $pdf->SetXY($x+$n,$y);
		   $pdf->Cell(10,4,$cod_fuente,0,0,'C'); 
		   $pdf->Cell(21,4,$asignado,0,0,'R'); 
		   $pdf->Cell(21,4,$modificacion,0,0,'R'); 
		   $pdf->Cell(22,4,$actualizada,0,1,'R'); 
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,4,$denominacion,0);
			
		}  $total=formato_monto($total); $total_modif=formato_monto($total_modif); $total_actua=formato_monto($total_actua);
        	$pdf->SetFont('Arial','B',8); 
		$pdf->Cell(136,2,'',0,0);
		$pdf->Cell(21,2,'=============',0,0,'R');
		$pdf->Cell(21,2,'=============',0,0,'R');
		$pdf->Cell(22,2,'=============',0,1,'R');
		$pdf->Cell(136,4,"Totales : ",0,0,'R');
		$pdf->Cell(21,4,$total,0,0,'R'); 
		$pdf->Cell(21,4,$total_modif,0,0,'R'); 
		$pdf->Cell(22,4,$total_actua,0,1,'R'); 		
		$pdf->Output();   
    }
	if($tipo_rep=="PDF2"){	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){ global $criterio1; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(120,8,'ASIGNACION PRESUPUESTARIA ACTUALIZADA',1,1,'C');
			$this->Ln(10);			
			$this->SetFont('Arial','B',8);
            $this->Cell(50,5,$criterio1,0,1,'L');
			$this->SetFont('Arial','B',7);
			$this->Cell(34,5,'CODIGO',1,0);
			$this->Cell(79,5,'DENOMINACION',1,0);
			$this->Cell(11,5,'FUENTE',1,0,'C');
			$this->Cell(19,5,'ASIGNACION',1,0,'C');
			$this->Cell(19,5,'AUMENTO',1,0,'C');
			$this->Cell(19,5,'DISMINUCION',1,0,'C');
			$this->Cell(19,5,'ACTUALIZADA',1,1,'C');
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
	  $i=0;  $total=0; $total_modif=0; $total_actua=0; $total_aum=0; $total_dism=0;
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_presup=$registro["cod_presup"];  $cod_fuente=$registro["cod_fuente"];   $denominacion=$registro["denominacion"];  
		   $asignado=$registro["asignado"]; $modificacion=$registro["modificacion"]; $actualizada=$registro["actualizada"];
		   $disminuciones=$registro["disminuciones"]; $aumentos=$registro["aumentos"]; $total_aum=$total_aum+$aumentos; $total_dism=$total_dism+$disminuciones;
		   $total=$total+$asignado; $asignado=formato_monto($asignado); $aumentos=formato_monto($aumentos);  $disminuciones=formato_monto($disminuciones); 
		   $total_modif=$total_modif+$modificacion; $modificacion=formato_monto($modificacion); $total_actua=$total_actua+$actualizada; $actualizada=formato_monto($actualizada); 
           if($php_os=="WINNT"){$denominacion=$denominacion; }   else{$denominacion=utf8_decode($denominacion); }
		   $pdf->Cell(33,4,$cod_presup,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=82; 		   
		   $pdf->SetXY($x+$n,$y);
		   $pdf->Cell(9,4,$cod_fuente,0,0,'C'); 
		   $pdf->Cell(19,4,$asignado,0,0,'R'); 
		   $pdf->Cell(19,4,$aumentos,0,0,'R'); 
		   $pdf->Cell(19,4,$disminuciones,0,0,'R'); 
		   $pdf->Cell(19,4,$actualizada,0,1,'R'); 
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,4,$denominacion,0);
			
		}  $total=formato_monto($total); $total_modif=formato_monto($total_modif); $total_actua=formato_monto($total_actua);
		$total_aum=formato_monto($total_aum); $total_dism=formato_monto($total_dism);
        $pdf->SetFont('Arial','B',7); 
		$pdf->Cell(124,2,'',0,0);
		$pdf->Cell(19,2,'=============',0,0,'R');
		$pdf->Cell(19,2,'=============',0,0,'R');
		$pdf->Cell(19,2,'=============',0,0,'R');
		$pdf->Cell(19,2,'=============',0,1,'R');
		$pdf->Cell(124,4,"Totales : ",0,0,'R');
		$pdf->Cell(19,4,$total,0,0,'R'); 
		$pdf->Cell(19,4,$total_aum,0,0,'R'); 
		$pdf->Cell(19,4,$total_dism,0,0,'R'); 
		$pdf->Cell(19,4,$total_actua,0,1,'R'); 		
		$pdf->Output();   
    }
    if($tipo_rep=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Asignacion_Presup_Actualizada.xls");
?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="220" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ASIGNACION PRESUPUESTARIA ACTUALIZADA</strong></font></td>
		 </tr>
		 <tr height="20">
		    <td width="220" align="left" ><strong><? echo $criterio1; ?></strong></td>
            <td width="400" align="center" > <strong></font></td>
		 </tr>
         <tr height="20">
           <td width="220" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CODIGO</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>DENOMINACION</strong></td>
           <td width="50" align="left" bgcolor="#99CCFF"><strong>FUENTE</strong></td>
           <td width="120" align="center" bgcolor="#99CCFF"><strong>ASIGNACION</strong></td>
           <td width="120" align="center" bgcolor="#99CCFF"><strong>MODIFICACIONES</strong></td>
           <td width="120" align="center" bgcolor="#99CCFF"><strong>ASIGNACION ACTUALIZADA</strong></td>
         </tr>
     <?	  
	  $i=0; $total=0; $total_modif=0; $total_actua=0; $total_aum=0; $total_dism=0;$res=pg_query($sSQL); 
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_presup=$registro["cod_presup"];  $cod_fuente=$registro["cod_fuente"];   $denominacion=$registro["denominacion"];  $disminuciones=$registro["disminuciones"]; $aumentos=$registro["aumentos"];
		   $asignado=$registro["asignado"]; $modificacion=$registro["modificacion"]; $actualizada=$registro["actualizada"];
		   $disminuciones=$registro["disminuciones"]; $aumentos=$registro["aumentos"]; $total_aum=$total_aum+$aumentos; $total_dism=$total_dism+$disminuciones;
		   $total=$total+$asignado; $asignado=formato_monto($asignado); $aumentos=formato_monto($aumentos);  $disminuciones=formato_monto($disminuciones); 
		   $total_modif=$total_modif+$modificacion; $modificacion=formato_monto($modificacion); $total_actua=$total_actua+$actualizada; $actualizada=formato_monto($actualizada);            
		   $denominacion=conv_cadenas($denominacion,0);  
	?>	   
		   <tr>
           <td width="220" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $cod_presup; ?></td>
           <td width="400" align="justify"><? echo $denominacion; ?></td>
           <td width="50" align="center">'<? echo $cod_fuente; ?></td>
           <td width="120" align="right"><? echo $asignado; ?></td>
           <td width="120" align="right"><? echo $modificacion; ?></td>
           <td width="120" align="right"><? echo $actualizada; ?></td>
         </tr>
	<? } $total=formato_monto($total);  ?>
       <tr>
			  <td width="220" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="50" align="left"></td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			</tr>	
			<tr>
			  <td width="220" align="left"></td>
			  <td width="400" align="right"><? echo "Totales : "; ?></td>
			  <td width="50" align="left"></td>
			  <td width="120" align="right"><? echo $total; ?></td>
			  <td width="120" align="right"><? echo $total_modif; ?></td>
			  <td width="120" align="right"><? echo $total_actua; ?></td>
			</tr>	
	
	  </table><?	  
	}	
 pg_close();
?>

