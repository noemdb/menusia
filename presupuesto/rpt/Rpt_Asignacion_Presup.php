<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$partida_d=$_GET["partida_d"];  $partida_h=$_GET["partida_h"]; $fuente_d=$_GET["fuente_d"];  $fuente_h=$_GET["fuente_h"];$nivel=$_GET["nivel"]; $tipo_rep=$_GET["tipo_rep"];}
 else{$partida_d="";  $partida_h=""; $fuente_d="";  $fuente_h=""; $nivel=""; $tipo_rep="HTML";} $php_os=PHP_OS;
 $mcontrol = array (0,0,0,0,0,0,0,0,0,0);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}  
else {   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} } }
   $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
   $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];}
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=7;
   $formato=$formato_presup; $clave=$partida_d;
   $j=0;
   for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
   for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
   for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
   for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} }
   $a=$actual;  
   $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
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
  
  
   
   $efiscal=substr($Fec_Fin_Ejer,0, 4);   $criterio1="EJERCICIO FISCAL: ".$efiscal;
   $criterio=$criterio." and (length(cod_presup)=$long_u) ";
   $sSQL = "select cod_presup, cod_fuente, denominacion, asignado from pre001 where ".$criterio." order by cod_presup, cod_fuente";
  
   if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
	   $oRpt = new PHPReportMaker();
	   $oRpt->setXML("asignacion_presup_tot.xml");
	   $oRpt->setUser("$user");
	   $oRpt->setPassword("$password");
	   $oRpt->setConnection("localhost");
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
			$this->Cell(120,8,'ASIGNACION PRESUPUESTARIA',1,1,'C');
			$this->Ln(10);			
			$this->SetFont('Arial','B',8);
            $this->Cell(50,5,$criterio1,0,1);			
			$this->Cell(44,5,'CODIGO',1,0);
			$this->Cell(123,5,'DENOMINACION',1,0);
			$this->Cell(12,5,'FUENTE',1,0,'C');
			$this->Cell(21,5,'ASIGNACION',1,1,'C');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			
			// INI NMDB 30-04-2018
			// $this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		     $this->Cell(130,5,' ',0,0,'R');
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
        $pdf->SetFont('Arial','B',8); 
		$pdf->Cell(179,2,'',0,0);
		$pdf->Cell(21,2,'===============',0,1,'R');
		$pdf->Cell(179,4,"Totales : ",0,0,'R');
		$pdf->Cell(21,4,$total,0,1,'R'); 		
		$pdf->Output();   
    }
    if($tipo_rep=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Asignacion_Presupuestaria.xls");

?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="220" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ASIGNACION PRESUPUESTARIA</strong></font></td>
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
       <tr>
			  <td width="220" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="50" align="left"></td>
			  <td width="120" align="right">-----------------</td>
			</tr>	
			<tr>
			  <td width="220" align="left"></td>
			  <td width="400" align="right"><? echo "Totales : "; ?></td>
			  <td width="50" align="left"></td>
			  <td width="120" align="right"><? echo $total; ?></td>
			</tr>	
	
	  </table><?	  
	}  
 pg_close();	
?>

