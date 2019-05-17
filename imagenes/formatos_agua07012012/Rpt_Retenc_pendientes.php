<?include ("../../class/phpreports/PHPReportMaker.php"); error_reporting(E_ALL ^ E_NOTICE);include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc");
$tipo_retencion_d=$_GET["tipo_retencion_d"];$tipo_retencion_h=$_GET["tipo_retencion_h"];$nro_orden_d=$_GET["numero_orden_d"];$nro_orden_h=$_GET["numero_orden_h"];
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"]; $principal_canc=$_GET["principal_canc"];$tipo_rpt=$_GET["tipo_rpt"];
$codigo_presu_d=$_GET["codigo_presu_d"];$codigo_presu_h=$_GET["codigo_presu_h"];$cod_fuented="";  $cod_fuenteh="zz";
$criterio1="Fecha Desde: ".$fecha_d." Al: ".$fecha_h;$Sql=""; $date = date("d-m-Y");$hora = date("H:i:s a"); $php_os=PHP_OS; $mcontrol = array (0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;
function buscar_control($clave, $formato){  global $mcontrol;  $j=0;
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} }  
  return $actual;
}
   $criterio=""; 
   $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else{ $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){ $php_os="WINNT";}
   
     $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
     if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];} 
     $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2; 
  
     $codigo_d=$codigo_presu_d; $cod_presupd=$codigo_presu_d; $codigo_h=$codigo_presu_d; $cod_presuph=$codigo_presu_d; 
     $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presupd,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
     $pos=strrpos($cod_presupd,"?"); if($pos===false){$en_d=0;}else{$en_d=1;} $pos=strrpos($cod_presuph,"?"); if($pos===false){$en_h=0;}else{$en_h=1;}   
     if(($en_d==1)or($en_h==1)){$codigo_d=str_replace("?","0",$cod_presupd); $long_d=strlen($codigo_d); $codigo_h=str_replace("?","9",$cod_presuph); $long_h=strlen($codigo_h);
	  if(($long_d=$long_u)and ($long_h=$long_u)){ $criterio=""; 
         for ($i=0; $i<10; $i++) { $m=$mcontrol[$i]; $a=$mcontrol[$i-1]; 
		     if ($m<>0){if($i==0){ $len_nivel=$m; $criterio=""; }else{ $mpos=1+$a;  $len_nivel=($m-$a-1); $criterio=$criterio." and "; }
				$cod_d=substr($codigo_d,$mpos,$len_nivel); $cod_h=substr($codigo_h,$mpos,$len_nivel);$mpp=$mpos+1;
				$criterio=$criterio."substring(pag004.cod_presup_ret,".$mpp.",".$len_nivel.")>='".$cod_d."' and "; $criterio=$criterio."substring(pag004.cod_presup_ret,".$mpp.",".$len_nivel.")<='".$cod_h."' ";  }
	     } $criterio=$criterio."and  pag004.fuente_fin_ret>='".$cod_fuented."' and pag004.fuente_fin_ret<='".$cod_fuenteh."'";
	  }else{$criterio="pag004.cod_presup_ret>='".$codigo_d."' and pag004.cod_presup_ret<='".$codigo_h."' and  pag004.fuente_fin_ret>='".$cod_fuented."' and pag004.fuente_fin_ret<='".$cod_fuenteh."'";}
     }else{$criterio="pag004.cod_presup_ret>='".$cod_presupd."' and pag004.cod_presup_ret<='".$cod_presuph."' and  pag004.fuente_fin_ret>='".$cod_fuented."' and pag004.fuente_fin_ret<='".$cod_fuenteh."'";}

	
     $criterio = $criterio . " And  ( ((pag004.tipo_pago_r='000') and (pag004.status_r<>'L')) OR ((pag004.status_r='L') and (pag004.Fecha_Cheque_R>'".$fecha_hasta."')) OR (pag004.tipo_pago_r='O/P' AND pag004.nro_cheque_r IN (SELECT a.nro_orden FROM pag001 a WHERE ( (a.Fecha_Cheque>'".$fecha_hasta."') or (a.status='N')    )) ))";
    
     $criterio = $criterio . " And  (pag004.nro_cheque_r not in (select nro_orden FROM pag007 d Where (d.fecha_cheque<='".$fecha_hasta."') And (d.anulado='S') and (d.fecha_anulado>'".$fecha_hasta."') ) ) ";
    	
     If ($principal_canc=="S") {
        $criterio = $criterio . " And  (pag004.Aux_Orden IN (SELECT b.nro_orden FROM pag001 b WHERE ((b.status='I') and (b.Fecha_Cheque<='".$fecha_hasta."')) or ((b.anulado='N') and (b.nro_orden In (SELECT nro_orden FROM pag007 Where (Fecha_Cheque<='".$fecha_hasta."') And (anulado='S') and (Fecha_anulado>'".$fecha_hasta."')  )))  )) ";
     }
	
	$sql = "SELECT count(pag004.nro_orden_ret) as cant_orden FROM  pag001, pag003, pag004, pre099 WHERE pag004.ced_rif_r = pre099.ced_rif and  pag003.tipo_retencion = pag004.tipo_retencion and
                  pag001.nro_orden = pag004.aux_orden and pag001.tipo_causado=pag004.tipo_caus_ret and
                  pag004.tipo_retencion>='".$tipo_retencion_d."' and pag004.tipo_retencion<='".$tipo_retencion_h."' and pag004.nro_orden_ret>='".$nro_orden_d."' and pag004.nro_orden_ret<='".$nro_orden_h."' and
                  pag001.fecha>='".$fecha_desde."' and pag001.fecha<='".$fecha_hasta."'  and " . $criterio;
   $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$cant_orden=$registro["cant_orden"];}
   
       $sSQL = "SELECT pag004.nro_orden_ret, pag004.Aux_Orden, pag001.fecha, pag004.Des_Orden_Ret,pag004.Monto_Retencion, pag004.ced_rif_r, pre099.Nombre, pag004.Status_R, pag001.anulado, pag001.fecha_anulado, pag004.tipo_retencion, pag001.concepto,
				  pag004.fecha_Cheque_R, pag004.Tasa_Retencion, pag001.fecha_cheque, pag004.Monto_Objeto_Ret, pag003.Descripcion_Ret, pag001.Tipo_Causado, pag004.cod_presup_ret,pag004.fuente_fin_ret, to_char(pag001.fecha,'DD/MM/YYYY') as fechae
                  FROM pag001, pag003, pag004, pre099 WHERE pag004.ced_rif_r = pre099.ced_rif and  pag003.tipo_retencion = pag004.tipo_retencion and
                  pag001.nro_orden = pag004.aux_orden and pag001.tipo_causado=pag004.tipo_caus_ret and
                  pag004.tipo_retencion>='".$tipo_retencion_d."' and pag004.tipo_retencion<='".$tipo_retencion_h."' and pag004.nro_orden_ret>='".$nro_orden_d."' and pag004.nro_orden_ret<='".$nro_orden_h."' and
                  pag001.fecha>='".$fecha_desde."' and pag001.fecha<='".$fecha_hasta."'  and " . $criterio ."  order by pag001.fecha, pag004.nro_orden_ret";
    if($tipo_rpt=="HTML"){	  
	      //echo $sSQL;
		  $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_Retenciones_pendientes.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"cant_orden"=>$cant_orden,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
   }
   if($tipo_rpt=="PDF"){ $res=pg_query($sSQL); $ced_rif_r_grupo=""; $nombre_grupo="";	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 	
		function Header(){ global $criterio1; global $ced_rif_r_grupo; global $nombre_grupo; global $registro;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(150,10,'RETENCIONES PENDIENTES',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(50,5,$criterio1,0,0,'L');				
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(15,5,'ORDEN',1,0);
			$this->Cell(15,5,'FECHA',1,0);
			$this->Cell(10,5,'TIPO',1,0);
			$this->Cell(100,5,'CONCEPTO',1,0);
			$this->Cell(40,5,'CODIGO PRESUPUESTARIO',1,0,'C');
			$this->Cell(20,5,'MONTO',1,1,'C');
           

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
	  $i=0;  $total=0; $sub_total=""; $cantidad=0; $prev_ced_rif_r="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
	       $cod_presup_ret=$registro["cod_presup_ret"];  $fuente_fin_ret=$registro["fuente_fin_ret"]; $concepto=$registro["concepto"]; 		   
		   $aux_orden=$registro["aux_orden"]; $fecha=$registro["fecha"]; $descripcion_ret=$registro["descripcion_ret"]; $cant_ordenes=$registro["cant_ordenes"];
		   $status_r=$registro["status_r"]; $ced_rif_r=$registro["ced_rif_r"]; $nombre=$registro["nombre"]; $tipo_retencion=$registro["tipo_retencion"]; 
		   $monto_objeto_ret=$registro["monto_objeto_ret"]; $tasa_retencion=$registro["tasa_retencion"]; $monto_retencion=$registro["monto_retencion"];
		   $anulado=$registro["anulado"]; $fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque_r"];
		   $cantidad=$cantidad+1;  $total=$total+$monto_retencion; $sub_total=$sub_total+$monto_retencion; 
		   $monto_retencion=formato_monto($monto_retencion); $cant_ordenes=formato_monto($cant_ordenes); $fecha=formato_ddmmaaaa($fecha);$tasa_retencion=formato_monto($tasa_retencion);
		   $monto_objeto_ret=formato_monto($monto_objeto_ret);
		   if($php_os=="WINNT"){$nombre=$registro["nombre"];} else{$nombre=utf8_decode($nombre); $descripcion_ret=utf8_decode($descripcion_ret); $concepto=utf8_decode($concepto);} 
		   $pdf->Cell(15,3,$aux_orden,0,0); 	
           $pdf->Cell(15,3,$fecha,0,0);	 
           $pdf->Cell(10,3,$tipo_retencion,0,0);	  
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=100;		   
		   $pdf->SetXY($x+$w,$y);	
           $pdf->Cell(40,3,$cod_presup_ret."  ".$fuente_fin_ret,0,0,'C');		   
		   $pdf->Cell(20,3,$monto_retencion,0,1,'R');
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($w,3,$concepto,0); 
		} $total=formato_monto($total); $cantidad==formato_monto ($cantidad);
		$pdf->SetFont('Arial','B',7);
	    
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(180,5,'',0,0);
		$pdf->Cell(20,3,'==============',0,1,'R');
		$pdf->Cell(30,3,'Cantidad Ordenes :',0,0,'L');
		$pdf->Cell(10,3,$cantidad,0,0,'L');
		$pdf->Cell(140,3,'TOTAL GENERAL : ',0,0,'R');
		$pdf->Cell(20,3,$total,0,1,'R'); 
		$pdf->Output();   
    }
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Retenciones_pendientes.xls");	
	
	?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="80" align="left" ><strong></strong></td>
		    <td width="100" align="left" ><strong></strong></td>
			<td width="80" align="left" ><strong></strong></td>
            <td width="300" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RETENCIONES PENDIENTES</strong></font></td>
	     </tr>
	     <tr height="20">
			<td width="80" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="80" align="left" ><strong></strong></td>
			<td width="300" align="center" > <font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	$criterio1?></strong></font></td>
		</tr>
         <tr height="20">
           <td width="80" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ORDEN</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>FECHA</strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>TIPO RET</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>CONCEPTO</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>CODIGO PRESUPUESTARIO</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>MONTO</strong></td>
         </tr>
     <?
	  
	  $i=0;  $total=0; $sub_total=0;  $cantidad=0; $prev_ced_rif_r="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
	       $cod_presup_ret=$registro["cod_presup_ret"];  $fuente_fin_ret=$registro["fuente_fin_ret"]; $concepto=$registro["concepto"]; 	
		   $aux_orden=$registro["aux_orden"]; $fecha=$registro["fecha"]; $descripcion_ret=$registro["descripcion_ret"]; 
		   $status_r=$registro["status_r"]; $ced_rif_r=$registro["ced_rif_r"]; $nombre=$registro["nombre"]; $tipo_retencion=$registro["tipo_retencion"]; 
		   $monto_objeto_ret=$registro["monto_objeto_ret"]; $tasa_retencion=$registro["tasa_retencion"]; $monto_retencion=$registro["monto_retencion"];
		   $anulado=$registro["anulado"]; $fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque_r"];
		   $cantidad=$cantidad+1;  $total=$total+$monto_retencion; $sub_total=$sub_total+$monto_retencion; 
		   $monto_retencion=formato_monto($monto_retencion); $fecha=formato_ddmmaaaa($fecha);$tasa_retencion=formato_monto($tasa_retencion);
		   $monto_objeto_ret=formato_monto($monto_objeto_ret);	 $nombre=conv_cadenas($nombre,0);  $descripcion_ret=conv_cadenas($descripcion_ret,0);
		   $concepto=conv_cadenas($concepto,0);
	      ?>	   
		   <tr>
                <td width="80" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $aux_orden; ?></td>
           		<td width="100" align="left"><? echo $fecha; ?></td>
           		<td width="80" align="left"><? echo $tipo_retencion; ?></td>
           		<td width="300" align="justify"><? echo $concepto; ?></td>
           		<td width="200" align="left"><? echo $cod_presup_ret; ?></td>
           		<td width="100" align="right"><? echo $monto_retencion; ?></td>
            </tr>
	    <? 
	    }  
        $total=formato_monto($total); $cantidad==formato_monto ($cantidad);	
		    ?>	 				 
   		   <tr>
     		   <td>&nbsp;</td>
            </tr>
            <tr>
				<td width="80"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
				<td width="100" align="right"><strong></strong></td>
				<td width="80" align="right"><strong></strong></td>
				<td width="300" align="right"><strong>TOTAL ORDENES:</strong></td>
				<td width="200" align="right"><strong></strong></td>
				<td width="100" align="right"><strong><? echo $total; ?></strong></td>
			 </tr>
		</table><?
        }		  
    }

?>
