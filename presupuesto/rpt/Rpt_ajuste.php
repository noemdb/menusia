<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$tipo_ajuste_d=$_GET["tipo_ajuste_d"];$tipo_ajuste_h=$_GET["tipo_ajuste_h"];$referencia_d=$_GET["referencia_d"];$referencia_h=$_GET["referencia_h"]; $fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"]; $tipo_rep=$_GET["tipo_rep"];
$cod_presupd=$_GET["cod_presupd"]; $cod_presuph=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuented"]; $cod_fuente_h=$_GET["cod_fuenteh"];$date = date("d-m-Y");$hora = date("H:i:s a");$Sql="";
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;
$criteriop="(pre011.Tipo_Ajuste>='$tipo_ajuste_d' and pre011.Tipo_Ajuste<='$tipo_ajuste_h') And (pre011.Referencia_Ajuste>='$referencia_d' and pre011.Referencia_Ajuste<='$referencia_h') And (pre011.Fecha_Ajuste>='$fecha_desde' and pre011.Fecha_Ajuste<='$fecha_hasta')";
$criterio1="Fecha Desde : ".$fecha_d."  "."Hasta : ".$fecha_h; $criterio2="";
$criterio3="Fuente de Financiamiento : ".$cod_fuente_d."    ".$cod_fuente_h; $mcontrol=array (0,0,0,0,0,0,0,0,0,0);
function buscar_control($clave, $formato){  global $mcontrol;  $j=0;
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} }  
  return $actual;
}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else { $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
   $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";   if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];} 
   $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presupd,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
	$pos=strrpos($cod_presupd,"?"); if($pos===false){$en_d=0;}else{$en_d=1;} $pos=strrpos($cod_presuph,"?"); if($pos===false){$en_h=0;}else{$en_h=1;}   
	if(($en_d==1)or($en_h==1)){$codigo_d=str_replace("?","0",$cod_presupd); $long_d=strlen($codigo_d); $codigo_h=str_replace("?","9",$cod_presuph); $long_h=strlen($codigo_h);
		if(($long_d=$long_u)and ($long_h=$long_u)){ $criterio=""; 
		   for ($i=0; $i<10; $i++) { $m=$mcontrol[$i]; if($i==0){$a=0;}else{$a=$mcontrol[$i-1];} 
			 if ($m<>0){if($i==0){ $len_nivel=$m; $criterio=""; }else{ $mpos=1+$a;  $len_nivel=($m-$a-1); $criterio=$criterio." and "; }
				$cod_d=substr($codigo_d,$mpos,$len_nivel); $cod_h=substr($codigo_h,$mpos,$len_nivel);$mpp=$mpos+1;
				$criterio=$criterio."substring(pre031.cod_presup,".$mpp.",".$len_nivel.")>='".$cod_d."' and "; $criterio=$criterio."substring(pre031.cod_presup,".$mpp.",".$len_nivel.")<='".$cod_h."' ";  }
		   } $criterio=$criterio."and  pre031.fuente_financ>='".$cod_fuente_d."' and pre031.fuente_financ<='".$cod_fuente_h."'";
		}else{$criterio="pre031.cod_presup>='".$codigo_d."' and pre031.cod_presup<='".$codigo_h."' and  pre031.fuente_financ>='".$cod_fuente_d."' and pre031.fuente_financ<='".$cod_fuente_h."'";}
	}else{$criterio="pre031.cod_presup>='".$cod_presupd."' and pre031.cod_presup<='".$cod_presuph."' and  pre031.fuente_financ>='".$cod_fuente_d."' and pre031.fuente_financ<='".$cod_fuente_h."'";}
	$criteriop=$criteriop." and (".$criterio.")";

	$sSQL = "SELECT pre011.Referencia_Ajuste, pre011.Fecha_Ajuste, pre011.Tipo_Ajuste,pre005.Nombre_Abrev_Ajuste, pre011.Anulado, pre011.Referencia_pago, 
	   pre011.Tipo_Pago, pre011.Referencia_Caus, pre011.Tipo_Causado,pre011.Referencia_Comp, pre011.Tipo_Compromiso, pre011.Descripcion,
	   pre031.Cod_Presup, pre031.Fuente_Financ, pre001.Denominacion, pre031.Monto, (pre031.Monto*-1) as montod, to_char(pre011.Fecha_Ajuste,'DD/MM/YYYY') as fechad   FROM pre001, pre005, pre011, pre031
	   WHERE pre001.Cod_Presup = pre031.Cod_Presup And pre031.Fuente_Financ=pre001.Cod_Fuente AND pre005.Tipo_Ajuste = pre011.Tipo_Ajuste AND
	   (pre011.referencia_ajuste=pre031.referencia_ajuste) and (pre011.tipo_ajuste=pre031.tipo_ajuste) and (pre011.tipo_pago=pre031.tipo_pago) and (pre011.referencia_pago=pre031.referencia_pago) and (pre011.tipo_causado=pre031.tipo_causado) and (pre011.referencia_caus=pre031.referencia_caus) and (pre011.tipo_compromiso=pre031.tipo_compromiso) and (pre011.referencia_comp=pre031.referencia_comp) and (pre031.Tipo_Ajuste=pre005.Tipo_Ajuste) AND ".$criteriop."
	   ORDER BY pre011.Fecha_Ajuste, pre011.Referencia_Ajuste, pre011.Tipo_Ajuste";
	   
    if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_ajustes.xml");
            $oRpt->setUser("$user");
            $oRpt->setPassword("$password");
            $oRpt->setConnection("$host");
            $oRpt->setDatabaseInterface("postgresql");
            $oRpt->setSQL($sSQL);
            $oRpt->setDatabase("$dbname");
            $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
            $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
            $oRpt->run();
            $aBench = $oRpt->getBenchmark();
            $iSec   = $aBench["report_end"]-$aBench["report_start"];
	}
	 if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $fecha_ajuste_grupo=""; $referencia_ajuste_grupo="00000000"; $tipo_ajuste_grupo="0000"; 
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $criterio2; global $tam_logo;  global $fecha_ajuste_grupo; global $referencia_ajuste_grupo; global $tipo_ajuste_grupo; global $registro;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(150,10,'REPORTE DE AJUSTES',1,0,'C');
				$this->Ln(20);
				$this->SetFont('Arial','B',8);
				$this->Cell(100,10,$criterio1,0,0,'L');			
				$this->Ln(10);
			    $this->SetFont('Arial','B',6);
				$this->Cell(16,5,'REFERENCIA',1,0);
				$this->Cell(14,5,'FECHA',1,0,'L');						
				$this->Cell(15,5,'TIPO',1,0,'L');	
				$this->Cell(5,5,'ST',1,0,'C');	
				$this->Cell(20,5,'REF. COMPROM.',1,0,'L');
				$this->Cell(8,5,'TIPO',1,0,'L');
				$this->Cell(18,5,'REF. CAUSADO',1,0,'L');
				$this->Cell(7,5,'TIPO',1,0,'L');
				$this->Cell(15,5,'REF. PAGO',1,0,'L');
				$this->Cell(7,5,'TIPO',1,0,'L');
				$this->Cell(135,5,'DESCRIPCION ',1,1,'L');
				$this->Cell(50,5,'          CODIGO PRESUPUESTARIO',1,0,'L');						
				$this->Cell(190,5,'DENOMINACION CODIGO PRESUPUESTARIO',1,0,'L');
				$this->Cell(20,5,'MONTO',1,1,'R');
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
		  $i=0;  $total_monto=0; $sub_total_monto=0; $cantidad_ordenes=0;  $prev_fecha_ajuste=""; $prev_referencia_ajuste="";  $prev_tipo_ajuste=""; 
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $fecha_ajuste=$registro["fecha_ajuste"]; $referencia_ajuste=$registro["referencia_ajuste"]; 
			$tipo_ajuste=$registro["tipo_ajuste"]; $nombre_abrev_ajuste=$registro["nombre_abrev_ajuste"]; $anulado=$registro["anulado"]; $referencia_comp=$registro["referencia_comp"];
			$tipo_compromiso=$registro["tipo_compromiso"]; $referencia_caus=$registro["referencia_caus"]; $tipo_causado=$registro["tipo_causado"]; 
			$referencia_pago=$registro["referencia_pago"];$tipo_pago=$registro["tipo_pago"]; $descripcion=$registro["descripcion"]; 
			$fecha_ajuste=formato_ddmmaaaa($fecha_ajuste); 
			if($php_os=="WINNT"){$descripcion=$registro["descripcion"]; }else{$descripcion=utf8_decode($descripcion);}
		    $fecha_ajuste_grupo=$fecha_ajuste; $referencia_ajuste_grupo=$referencia_ajuste; $tipo_ajuste_grupo=$tipo_ajuste; $nombre_abrev_ajuste_grupo=$nombre_abrev_ajuste; 			         $anulado_grupo=$anulado;$referencia_comp_grupo=$referencia_comp; $tipo_compromiso_grupo=$tipo_compromiso; $referencia_caus_grupo=$referencia_caus; 
			$tipo_causado_grupo=$tipo_causado; $referencia_pago_grupo=$referencia_pago; $tipo_pago_grupo=$tipo_pago;$descripcion_grupo=$descripcion;
			if($tipo_compromiso_grupo=="0000"){$tipo_compromiso_grupo="";}else{$tipo_compromiso_grupo=$tipo_compromiso_grupo;}
		         if($referencia_caus_grupo=="0000"){$referencia_caus_grupo="";}else{$referencia_caus_grupo=$referencia_caus_grupo;}
                         if($tipo_causado_grupo=="0000"){$tipo_causado_grupo="";}else{$tipo_causado_grupo=$tipo_causado_grupo;}	
                         if($referencia_pago_grupo=="0000"){$referencia_pago_grupo="";}else{$referencia_pago_grupo=$referencia_pago_grupo;}
                         if($tipo_pago_grupo=="0000"){$tipo_pago_grupo="";}else{$tipo_pago_grupo=$tipo_pago_grupo;}

			if(($prev_fecha_ajuste<>$fecha_ajuste_grupo)or($prev_tipo_ajuste<>$tipo_ajuste_grupo)or($prev_referencia_ajuste<>$referencia_ajuste_grupo)){ 	$cantidad_ordenes=$cantidad_ordenes+1;
			     $pdf->SetFont('Arial','B',7); 
			     if($sub_total_monto<>0){ $sub_total_monto=formato_monto($sub_total_monto); 
					$pdf->Cell(240,2,'',0,0);
					$pdf->Cell(20,2,'------------------',0,1,'R');
					$pdf->Cell(240,2,'',0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto,0,1,'R');
                    $pdf->Ln(3);
				 }	
                 $pdf->SetFont('Arial','',7);				 
				 $pdf->Cell(15,3,$referencia_ajuste_grupo,0,0,'L'); 
				 $pdf->Cell(15,3,$fecha_ajuste_grupo,0,0,'L');
				 $pdf->Cell(15,3,$tipo_ajuste_grupo."   ".$nombre_abrev_ajuste,0,0,'L');
				 $pdf->Cell(5,3,$anulado_grupo,0,0,'C');
				 $pdf->Cell(20,3,$referencia_comp_grupo,0,0,'L');
				 $pdf->Cell(8,3,$tipo_compromiso_grupo,0,0,'L');
				 $pdf->Cell(18,3,$referencia_caus_grupo,0,0,'L');
				 $pdf->Cell(7,3,$tipo_causado_grupo,0,0,'L');
				 $pdf->Cell(15,3,$referencia_pago_grupo,0,0,'L');
				 $pdf->Cell(7,3,$tipo_pago_grupo,0,0,'L');
				 $x=$pdf->GetX();   $y=$pdf->GetY(); $n=135; 
			     $pdf->SetXY($x,$y);
				 $pdf->MultiCell($n,3,$descripcion_grupo,0,1);  
				 $pdf->Ln(3);
				 $prev_fecha_ajuste=$fecha_ajuste_grupo; $prev_referencia_ajuste=$referencia_ajuste_grupo; $prev_tipo_ajuste=$tipo_ajuste_grupo; $sub_total_monto=0; } 


		       $fecha_ajuste=$registro["fecha_ajuste"]; $referencia_ajuste=$registro["referencia_ajuste"]; $tipo_ajuste=$registro["tipo_ajuste"]; 
			   $nombre_abrev_ajuste=$registro["nombre_abrev_ajuste"]; $anulado=$registro["anulado"]; $referencia_comp=$registro["referencia_comp"];
			   $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_caus=$registro["referencia_caus"]; $tipo_causado=$registro["tipo_causado"]; 
			   $referencia_pago=$registro["referencia_pago"];$tipo_pago=$registro["tipo_pago"]; $descripcion=$registro["descripcion"]; $cod_presup=$registro["cod_presup"]; 
		       $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"]; $montod=$registro["montod"];
			   $total_monto=$total_monto+$montod; $sub_total_monto=$sub_total_monto+$montod; $montod=formato_monto($montod); $fecha_ajuste=formato_ddmmaaaa($fecha_ajuste);	
			   if($php_os=="WINNT"){$descripcion=$registro["descripcion"]; }else{$descripcion=utf8_decode($descripcion);$denominacion=utf8_decode($denominacion);}

			   $pdf->Cell(50,3,$cod_presup."   ".$fuente_financ,0,0,'R'); 			   
		   	   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=190; 		   
		       $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,3,$montod,0,1,'R');
		   	   $pdf->SetXY($x,$y);		           
			   $pdf->MultiCell($n,3,$denominacion,0); 
				
			} $total_monto=formato_monto($total_monto);  
			$pdf->SetFont('Arial','B',7);
			     if($sub_total_monto<>0){ $sub_total_monto=formato_monto($sub_total_monto); 
					$pdf->Cell(240,2,'',0,0);
					$pdf->Cell(20,2,'----------------',0,1,'R');
					$pdf->Cell(240,2,'',0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto,0,1,'R');
                    $pdf->Ln(5);}
			$pdf->Cell(240,2,'',0,0);
			$pdf->Cell(20,2,'=============',0,1,'R');
			$pdf->Cell(100,5,'Cantidad Ajustes: '.$cantidad_ordenes,0,0,'L');
		    $pdf->Cell(140,5,'TOTAL GENERAL ',0,0,'R');
			$pdf->Cell(20,5,$total_monto,0,1,'R');
			$pdf->Output();   
		}
    if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_ajustes.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
			        <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE DE AJUSTES</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1?></strong></font></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>

			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Referencia</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>St</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Ref. Comp.</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Ref. Caus</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF" ><strong>Tipo</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF" ><strong>Ref. Pago</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF" ><strong>Tipo</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF" ><strong>Descripcion</strong></td>
			 </tr>
			 <tr height="20">
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Codigo Presupuestario</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Denominacion Codigo Presupuestario</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			   <td width="400" align="right" bgcolor="#99CCFF"><strong>Monto</strong></td>
			 </tr>
		  <?  $i=0; $total_monto=0; $sub_total_monto=0; $cantidad_ordenes=0; 
			 $prev_fecha_ajuste=""; $prev_referencia_ajuste="";  $prev_tipo_ajuste="";   $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $fecha_ajuste=$registro["fecha_ajuste"]; $referencia_ajuste=$registro["referencia_ajuste"]; 
			$tipo_ajuste=$registro["tipo_ajuste"]; $nombre_abrev_ajuste=$registro["nombre_abrev_ajuste"]; $anulado=$registro["anulado"]; $referencia_comp=$registro["referencia_comp"];
			$tipo_compromiso=$registro["tipo_compromiso"]; $referencia_caus=$registro["referencia_caus"]; $tipo_causado=$registro["tipo_causado"]; 
			$referencia_pago=$registro["referencia_pago"];$tipo_pago=$registro["tipo_pago"]; $descripcion=$registro["descripcion"]; 
			$fecha_ajuste=formato_ddmmaaaa($fecha_ajuste); 
		        $fecha_ajuste_grupo=$fecha_ajuste; $referencia_ajuste_grupo=$referencia_ajuste; $tipo_ajuste_grupo=$tipo_ajuste; $nombre_abrev_ajuste_grupo=$nombre_abrev_ajuste; 			        $anulado_grupo=$anulado;$referencia_comp_grupo=$referencia_comp; $tipo_compromiso_grupo=$tipo_compromiso; $referencia_caus_grupo=$referencia_caus; 
			$tipo_causado_grupo=$tipo_causado; $referencia_pago_grupo=$referencia_pago; $tipo_pago_grupo=$tipo_pago;$descripcion_grupo=$descripcion;
			 if($tipo_compromiso_grupo=="0000"){$tipo_compromiso_grupo="";}else{$tipo_compromiso_grupo=$tipo_compromiso_grupo;}
		         if($referencia_caus_grupo=="0000"){$referencia_caus_grupo="";}else{$referencia_caus_grupo=$referencia_caus_grupo;}
                         if($tipo_causado_grupo=="0000"){$tipo_causado_grupo="";}else{$tipo_causado_grupo=$tipo_causado_grupo;}	
                         if($referencia_pago_grupo=="0000"){$referencia_pago_grupo="";}else{$referencia_pago_grupo=$referencia_pago_grupo;}
                         if($tipo_pago_grupo=="0000"){$tipo_pago_grupo="";}else{$tipo_pago_grupo=$tipo_pago_grupo;}

			   if(($prev_fecha_ajuste<>$fecha_ajuste_grupo)or($prev_tipo_ajuste<>$tipo_ajuste_grupo)or($prev_referencia_ajuste<>$referencia_ajuste_grupo)){ 	$cantidad_ordenes=$cantidad_ordenes+1;
			    if($sub_total_monto<>0){ $sub_total_monto=formato_monto($sub_total_monto);  		
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="400" align="left"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="400" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="400" align="left"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="400" align="right"><? echo $sub_total_monto; ?></td>
			        </tr>	
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			      ?>	   
			      <tr>
				   <td width="100" align="left">'<? echo $referencia_ajuste_grupo; ?></td>
				   <td width="400" align="left"><? echo $fecha_ajuste_grupo; ?></td>
				   <td width="100" align="left">'<? echo $tipo_ajuste_grupo."   ".$nombre_abrev_ajuste; ?></td>
				   <td width="100" align="left"><? echo $anulado_grupo; ?></td>
				   <td width="100" align="left">'<? echo $referencia_comp_grupo; ?></td>
				   <td width="100" align="left">'<? echo $tipo_compromiso_grupo; ?></td>
				   <td width="100" align="left">'<? echo $referencia_caus_grupo; ?></td>
				   <td width="100" align="left">'<? echo $tipo_causado_grupo; ?></td>
				   <td width="100" align="left">'<? echo $referencia_pago_grupo; ?></td>
				   <td width="100" align="left">'<? echo $tipo_pago_grupo; ?></td>
				   <td width="400" align="left"><? echo $descripcion_grupo; ?></td>
			      </tr>
			      <tr>
				  <td width="90" align="left"></td>
			      </tr>	
			     <? 					 
			    $prev_fecha_ajuste=$fecha_ajuste_grupo; $prev_referencia_ajuste=$referencia_ajuste_grupo; $prev_tipo_ajuste=$tipo_ajuste_grupo; $sub_total_monto=0; }

		           $fecha_ajuste=$registro["fecha_ajuste"]; $referencia_ajuste=$registro["referencia_ajuste"]; $tipo_ajuste=$registro["tipo_ajuste"]; 
			   $nombre_abrev_ajuste=$registro["nombre_abrev_ajuste"]; $anulado=$registro["anulado"]; $referencia_comp=$registro["referencia_comp"];
			   $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_caus=$registro["referencia_caus"]; $tipo_causado=$registro["tipo_causado"]; 
			   $referencia_pago=$registro["referencia_pago"];$tipo_pago=$registro["tipo_pago"]; $descripcion=$registro["descripcion"]; $cod_presup=$registro["cod_presup"]; 
		           $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"]; $montod=$registro["montod"];
			   $total_monto=$total_monto+$montod; $sub_total_monto=$sub_total_monto+$montod; $montod=formato_monto($montod); $fecha_ajuste=formato_ddmmaaaa($fecha_ajuste);		   
			   $descripcion=conv_cadenas($descripcion,0);$denominacion=conv_cadenas($denominacion,0); 
			   ?>	   
				<tr>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_presup."   ".$fuente_financ; ?></td>
				   <td width="400" align="justify"><? echo $denominacion; ?></td>
				   <td width="100" align="right"></td>
				   <td width="100" align="right"></td>
				   <td width="100" align="right"></td>
				   <td width="100" align="right"></td>
				   <td width="100" align="right"></td>
				   <td width="100" align="right"></td>
				   <td width="100" align="right"></td>
				   <td width="100" align="right"></td>
				   <td width="400" align="right"><? echo $montod; ?></td>
				 </tr>
			   <? 	

		  }$total_monto=formato_monto($total_monto);  
		     if($sub_total_monto>0){ $sub_total_monto=formato_monto($sub_total_monto);  		
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="400" align="left"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="400" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="400" align="left"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="400" align="right"><? echo $sub_total_monto; ?></td>
			        </tr>			
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="right">---------------</td>
			</tr>	
			<tr>
			    <td width="100" align="left">Cantidad Ajustes: <strong><? echo $cantidad_ordenes; ?></strong></td>
			    <td width="400" align="right"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
v			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right"><strong>TOTAL GENERAL : </strong></td>
			    <td width="400" align="right"><strong><? echo $total_monto; ?></strong></td>
			</tr>	
		       <? 				  
		  ?></table><?
        }
}
?>
