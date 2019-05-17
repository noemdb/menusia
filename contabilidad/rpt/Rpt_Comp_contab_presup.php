<? include ("../../class/fun_fechas.php"); include ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); 
include ("../../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE);  $php_os=PHP_OS; $Sql=""; $col_ac_n="N";
$fecha_d=$_GET["fecha_d"]; $fecha_h=$_GET["fecha_h"]; $ced_rif_d=""; $ced_rif_h="zzzzzzzzzzzz";
$cod_cuenta_d=$_GET["cod_cuenta_d"];$cod_cuenta_h=$_GET["cod_cuenta_h"]; $tipo_asiento_d=$_GET["tipo_asiento_d"];$tipo_asiento_h=$_GET["tipo_asiento_h"];
$ordenar=""; $imprimir=$_GET["imprimir"]; $tipo_rep=$_GET["tipo_rep"]; $inc_benef="N";
$criterio1="Desde ".$fecha_d." Al ".$fecha_h; if($fecha_d==""){$sfecha_d="2012-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
//cambiar formato a la fecha
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';}$fecha_desde=$ano1."/".$mes1."/".$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';}$fecha_hasta=$ano1."/".$mes1."/".$dia1;
$date = date("d-m-Y");$hora = date("H:i:s a");

$nombre_rep="Comparativo_contab_presup.xml";

$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{ $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}  $fecha_i=formato_ddmmaaaa($Fec_Ini_Ejer);
    $sql="Select * from SIA000 order by campo001";$resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"]; $Rif_Emp=$registro["campo007"]; }
  
	$campo502=""; $g_comprobante="N"; $cod_con_g_pagar=""; $status="";
    $l_cat=0; $sql="Select campo502,campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"]; $campo502=$registro["campo502"];
	    $l_cat=strlen($formato_cat); if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}}		
	$g_comprobante=substr($campo502,3,1);
	$Sql="SELECT ELIMINA_CON013('".$usuario_sia."','8')";  $resultado=pg_exec($conn,$Sql);   $error=pg_errormessage($conn);    $error="ERROR INICIALIZANDO: ".substr($error, 0, 61);
    $Sql="SELECT RPT_MAYOR_A_CON013('".$usuario_sia."','8','".$fecha_d."','".$sfecha_h."','".$cod_cuenta_d."','".$cod_cuenta_h."','".$tipo_asiento_d."','".$tipo_asiento_h."','".$ordenar."','".$imprimir."')";
    $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);      $error="ERROR GRABANDO: ".substr($error, 0, 61);
    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
     else{  
	 
	 $Sql="update CON013 set columna5=columna1 WHERE columna1<>0 and nombre_usuario='".$usuario_sia."' AND tipo_registro='8'";  $resultado=pg_exec($conn,$Sql);   $error=pg_errormessage($conn);
	 
	 $Sql="update CON013 set columna5=columna2 WHERE columna2<>0 and nombre_usuario='".$usuario_sia."' AND tipo_registro='8'";  $resultado=pg_exec($conn,$Sql);   $error=pg_errormessage($conn);
	 
	 $nro_linea=1;
	 $sql="SELECT MAX(nro_linea) As max_nro_linea  FROM con013 WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='8'";$res=pg_query($sql);
	 if ($registro=pg_fetch_array($res,0)){$nro_linea=$registro["max_nro_linea"];}
	 
	

	if($g_comprobante=="S"){ 
	 //select pre036.referencia_comp,pre036.tipo_compromiso,pre036.cod_comp,pre036.fecha_compromiso,pre036.cod_presup,pre036.fuente_financ,pre036.tipo_imput_presu,pre036.ref_imput_presu,pre036.monto,pre036.causado,pre036.pagado,pre036.ajustado,pre036.monto_credito,pre006.ced_rif,pre006.tipo_documento,pre006.nro_documento,pre006.tiene_anticipo,pre006.cod_con_anticipo,pre006.monto_anticipo,pre006.tasa_anticipo,pre006.amort_anticipo,pre006.tipo_anticipo,pre006.genera_comprobante,pre006.cod_con_g_pagar,pre006.aprobado,pre001.denominacion,pre001.cod_contable,pre095.des_fuente_financ from ((pre036 left join pre001 on (pre001.cod_presup=pre036.cod_presup) and (pre001.cod_fuente=pre036.fuente_financ)) left join pre095 on (pre095.cod_fuente_financ=pre036.fuente_financ)), pre006 where (pre036.tipo_compromiso=pre006.tipo_compromiso) and (pre036.referencia_comp=pre006.referencia_comp) and (pre036.cod_comp=pre006.cod_comp) and (pre036.fecha_compromiso=pre006.fecha_compromiso)
     $Sql="select * FROM codigos_compromisos where tipo_compromiso<>'0000' and tipo_compromiso<>'A000' and fecha_compromiso>='$fecha_d' and fecha_compromiso<='$sfecha_h' and cod_presup in (select cod_presup from pre001 where cod_contable='$cod_cuenta_d')";  $res=pg_query($Sql); 
     while($registro=pg_fetch_array($res)){
		$referencia_comp=$registro["referencia_comp"]; $cod_comp=$registro["cod_comp"]; 
		$fecha=$registro["fecha_compromiso"];  $tipo_compromiso=$registro["tipo_compromiso"]; 
		$ced_rif=$registro["ced_rif"]; $cod_presup=$registro["cod_presup"];
		$descripcion="Codigo Presupuestario:".$cod_presup." ".$registro["descripcion_comp"]; $monto=$registro["monto"];		
		$referencia=$referencia_comp;
		$tipo_comp='P'.$tipo_compromiso; $letra=substr($tipo_compromiso,0,1); if($letra=="A"){ $monto=$registro["monto"]*-1;	 $referencia="A".substr($referencia_comp,1,7); $tipo_comp='P0'.substr($tipo_compromiso,1,3); }
		$sqlr="Select * FROM CON013 WHERE nombre_usuario='".$usuario_sia."' and tipo_registro='8' and referencia='$referencia' And fecha='$fecha' And tipo_comp='$tipo_comp'";
		$resr=pg_exec($conn,$sqlr);  $filasr=pg_numrows($resr);
		if ($filasr==0){ $nro_linea=$nro_linea+1;
		  $sqlg="INSERT INTO con013(nombre_usuario,tipo_registro,nro_linea,referencia,fecha,debito_credito,cod_cuenta,tipo_comp,tipo_asiento,aoperacion,doperacion,status,codigo_cuenta,nombre_cuenta,tsaldo,codigo_cuenta2,nombre_cuenta2,tsaldo2,columna1,columna2,columna3,columna4,columna5,columna6,columna7,columna8,columna9,columna10,descripcion,descripcion_a)
                   VALUES ('$usuario_sia','8',$nro_linea,'$referencia_comp','$fecha','D','$cod_cuenta_d','$tipo_comp','COM','0','0','','$cod_cuenta_d','','','','','',0,0,0,0,0,$monto,0,0,0,0,'$descripcion','$descripcion');";
		}else{ $sqlg="update CON013 set columna6=columna6+$monto WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='8' and referencia='$referencia' And fecha='$fecha' And tipo_comp='$tipo_comp'";  }
		//echo $sqlg,"<br>";
		$resg=pg_exec($conn, $sqlg);
	 }
	 $Sql="select pre031.referencia_ajuste,pre031.tipo_ajuste,pre031.referencia_pago,pre031.tipo_pago,pre031.referencia_caus,pre031.tipo_causado,pre031.referencia_comp,pre031.tipo_compromiso,pre031.cod_presup,pre031.fuente_financ,pre031.ref_imput_presu,pre031.monto,pre011.fecha_ajuste,pre011.modulo,pre011.descripcion from pre031,pre011 where pre031.tipo_ajuste in (select tipo_ajuste from pre005 where refierea='COMPROMISO') and pre031.referencia_ajuste=pre011.referencia_ajuste and pre031.tipo_ajuste=pre011.tipo_ajuste and pre031.referencia_pago=pre011.referencia_pago and pre031.tipo_pago=pre011.tipo_pago and pre031.referencia_caus=pre011.referencia_caus and pre031.tipo_causado=pre011.tipo_causado and pre031.referencia_comp=pre011.referencia_comp and pre031.tipo_compromiso=pre011.tipo_compromiso and  pre011.fecha_ajuste>='$fecha_d' and pre011.fecha_ajuste<='$sfecha_h' and pre031.cod_presup in (select cod_presup from pre001 where cod_contable='$cod_cuenta_d')";  $res=pg_query($Sql);
     //echo $Sql,"<br>";
	 while($registro=pg_fetch_array($res)){ $nro_linea=$nro_linea+1;
	   $referencia_ajuste=$registro["referencia_ajuste"]; $tipo_ajuste=$registro["tipo_ajuste"]; 
		$fecha=$registro["fecha_ajuste"];  $ced_rif=$Rif_Emp; $cod_presup=$registro["cod_presup"]; $modulo=$registro["modulo"];
		$descripcion="Ajuste Preupuestario; Codigo Presupuestario:".$cod_presup." ".$registro["descripcion"]; $monto=$registro["monto"]*-1;		
		$referencia=$referencia_ajuste; $tipo_comp=$modulo.$tipo_causado;
		$sqlg="INSERT INTO con013(nombre_usuario,tipo_registro,nro_linea,referencia,fecha,debito_credito,cod_cuenta,tipo_comp,tipo_asiento,aoperacion,doperacion,status,codigo_cuenta,nombre_cuenta,tsaldo,codigo_cuenta2,nombre_cuenta2,tsaldo2,columna1,columna2,columna3,columna4,columna5,columna6,columna7,columna8,columna9,columna10,descripcion,descripcion_a)
                   VALUES ('$usuario_sia','8',$nro_linea,'$referencia_ajuste','$fecha','D','$cod_cuenta_d','$tipo_comp','AJU','0','0','','$cod_cuenta_d','','','','','',0,0,0,0,0,$monto,0,0,0,0,'$descripcion','$descripcion');";
		$resg=pg_exec($conn, $sqlg);
	 }
	 
	 //FALTAN CAUSADOS Y PAGOS DIRECTOS
	 
	 
    }else{
	  $Sql="select pre037.referencia_caus,pre037.tipo_causado,pre037.referencia_comp,pre037.tipo_compromiso,pre037.fecha_causado,pre037.cod_presup,pre037.fuente_financ,pre037.tipo_imput_presu,pre037.ref_imput_presu,pre037.monto,pre037.pagado,pre037.ajustado,pre037.amort_anticipo,pre037.monto_credito,pre007.modulo,pre007.ced_rif,pre007.genera_comprobante,pre007.descripcion_caus FROM pre037,pre007 where pre037.referencia_caus=pre007.referencia_caus and pre037.tipo_causado=pre007.tipo_causado and pre037.referencia_comp=pre007.referencia_comp  and pre037.tipo_compromiso=pre007.tipo_compromiso and pre037.fecha_causado=pre007.fecha_causado and pre007.tipo_causado<>'0000' and pre007.tipo_causado<>'A000' and  pre037.fecha_causado>='$fecha_d' and pre037.fecha_causado<='$sfecha_h' and pre037.cod_presup in (select cod_presup from pre001 where cod_contable='$cod_cuenta_d')";  $res=pg_query($Sql); 
      while($registro=pg_fetch_array($res)){
	    $referencia_caus=$registro["referencia_caus"]; $tipo_causado=$registro["tipo_causado"]; 
		$fecha=$registro["fecha_causado"];  $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"]; 
		$ced_rif=$registro["ced_rif"]; $cod_presup=$registro["cod_presup"]; $modulo=$registro["modulo"]; $genera_comprobante=$registro["genera_comprobante"];
		$descripcion="Codigo Presupuestario:".$cod_presup." ".$registro["descripcion_caus"]; $monto=$registro["monto"];		
		$referencia=$referencia_caus;
		
		$tipo_comp=$modulo.$tipo_causado; $letra=substr($tipo_causado,0,1); if($letra=="A"){ $monto=$registro["monto"]*-1;	 $referencia="A".substr($referencia_caus,1,7); $tipo_comp=$modulo.'0'.substr($tipo_causado,1,3); }
		
		$sqlr="Select * FROM CON013 WHERE nombre_usuario='".$usuario_sia."' and tipo_registro='8' and referencia='$referencia' And fecha='$fecha' And tipo_comp='$tipo_comp'";
		$resr=pg_exec($conn,$sqlr);  $filasr=pg_numrows($resr);
		if ($filasr==0){ $nro_linea=$nro_linea+1;
		  $sqlg="INSERT INTO con013(nombre_usuario,tipo_registro,nro_linea,referencia,fecha,debito_credito,cod_cuenta,tipo_comp,tipo_asiento,aoperacion,doperacion,status,codigo_cuenta,nombre_cuenta,tsaldo,codigo_cuenta2,nombre_cuenta2,tsaldo2,columna1,columna2,columna3,columna4,columna5,columna6,columna7,columna8,columna9,columna10,descripcion,descripcion_a)
                   VALUES ('$usuario_sia','8',$nro_linea,'$referencia_caus','$fecha','D','$cod_cuenta_d','$tipo_comp','CAU','0','0','','$cod_cuenta_d','','','','','',0,0,0,0,0,$monto,0,0,0,0,'$descripcion','$descripcion');";
		}else{ $sqlg="update CON013 set columna6=columna6+$monto WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='8' and referencia='$referencia' And fecha='$fecha' And tipo_comp='$tipo_comp'";  }
		
		
	  }
	  
	  $Sql="select pre031.referencia_ajuste,pre031.tipo_ajuste,pre031.referencia_pago,pre031.tipo_pago,pre031.referencia_caus,pre031.tipo_causado,pre031.referencia_comp,pre031.tipo_compromiso,pre031.cod_presup,pre031.fuente_financ,pre031.ref_imput_presu,pre031.monto,pre011.fecha_ajuste from pre031,pre011 where pre031.tipo_ajuste in (select tipo_ajuste from pre005 where refierea='CAUSADO') and pre031.referencia_ajuste=pre011.referencia_ajuste and pre031.tipo_ajuste=pre011.tipo_ajuste and pre031.referencia_pago=pre011.referencia_pago and pre031.tipo_pago=pre011.tipo_pago and pre031.referencia_caus=pre011.referencia_caus and pre031.tipo_causado=pre011.tipo_causado and pre031.referencia_comp=pre011.referencia_comp and pre031.tipo_compromiso=pre011.tipo_compromiso and pre011.fecha_ajuste>='$fecha_d' and pre011.fecha_ajuste<='$sfecha_h' and pre031.cod_presup in (select cod_presup from pre001 where cod_contable='$cod_cuenta_d')";  $res=pg_query($Sql);
      while($registro=pg_fetch_array($res)){ $nro_linea=$nro_linea+1;
	   $referencia_ajuste=$registro["referencia_ajuste"]; $tipo_ajuste=$registro["tipo_ajuste"]; 
		$fecha=$registro["fecha_ajuste"];  $ced_rif=$Rif_Emp; $cod_presup=$registro["cod_presup"]; $modulo=$registro["modulo"];
		$descripcion="Ajuste Preupuestario; Codigo Presupuestario:".$cod_presup." ".$registro["descripcion"]; $monto=$registro["monto"]*-1;		
		$referencia=$referencia_ajuste; $tipo_comp=$modulo.$tipo_causado;
		$sqlg="INSERT INTO con013(nombre_usuario,tipo_registro,nro_linea,referencia,fecha,debito_credito,cod_cuenta,tipo_comp,tipo_asiento,aoperacion,doperacion,status,codigo_cuenta,nombre_cuenta,tsaldo,codigo_cuenta2,nombre_cuenta2,tsaldo2,columna1,columna2,columna3,columna4,columna5,columna6,columna7,columna8,columna9,columna10,descripcion,descripcion_a)
                   VALUES ('$usuario_sia','8',$nro_linea,'$referencia_ajuste','$fecha','D','$cod_cuenta_d','$tipo_comp','AJU','0','0','','$cod_cuenta_d','','','','','',0,0,0,0,0,$monto,0,0,0,0,'$descripcion','$descripcion');";
		$resg=pg_exec($conn, $sqlg);
	  }
	  
	  
	  //FALTAN PAGOS DIRECTOS
	}	
	 
	 $Sql= "select * from RPT_MAYOR_A WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='8'  AND  fecha>='".$fecha_desde."' ORDER BY Cod_Cuenta, Fecha,nombre_cuenta2,AOperacion, substring(referencia,3,6), DOperacion";
       // $Sql= "select * from RPT_MAYOR_A WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='8'  AND  fecha>='".$fecha_desde."' ORDER BY Cod_Cuenta, Fecha,referencia";
       $sSQL = $Sql; 
		if($tipo_rep=="HTML"){	 include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML($nombre_rep);
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1,"col_ac_n"=>$col_ac_n,"date"=>$date,"hora"=>$hora));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run();
		}
        if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $cta_enc="00000000";	$nomb_cta_enc=""; $anterior=0;
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $cta_enc; global $nomb_cta_enc; global $anterior;
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(130,10,'COMPARATIVO CONTABILIDAD PRESUPUESTO',1,0,'C');
				$this->Ln(10);
				$this->SetFont('Arial','B',9);
				$this->Cell(50);
				$this->Cell(100,10,$criterio1,0,0,'C');				
				$this->Ln(10);
				$this->SetFont('Arial','B',7);
				$this->Cell(15,5,'Fecha',1,0);
				$this->Cell(15,5,'Referencia',1,0);	
                $this->Cell(10,5,'Tipo',1,0);					
				$this->Cell(100,5,'Decripcion',1,0);
				$this->Cell(20,5,'Contabilidad',1,0,'C');
				$this->Cell(20,5,'Presupuesto',1,0,'C');
				$this->Cell(20,5,'Diferencia',1,1,'C');
                		
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
		  $i=0;  $totald=0; $totalh=0; $totals=0; $sub_totald=0; $sub_totalh=0; $prev_cta="";  $cant_mov=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $codigo_cuenta=$registro["codigo_cuenta"];    $nombre_cuenta=$registro["nombre_cuenta"]; 
			   if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"]; }   else{$nombre_cuenta=utf8_decode($nombre_cuenta); }	
		       $cta_enc=$codigo_cuenta;  $nomb_cta_enc=$nombre_cuenta; 
		       $referencia=$registro["referencia"]; $fecha=$registro["fecha"];  $tipo_asiento=$registro["tipo_asiento"];  $descripcion=$registro["descripcion"]; $nombre=$registro["nombre"];
			   $debe=$registro["columna5"]; $haber=$registro["columna6"]; $anterior=$registro["columna3"]; $saldo=$registro["columna5"]-$registro["columna6"]; 
			   $totald=$totald+$debe; $totalh=$totalh+$haber; $totals=$totals+$saldo; $sub_totald=$sub_totald+$debe; $sub_totalh=$sub_totalh+$haber; $cant_mov=$cant_mov+1;
			   $debe=formato_monto($debe); 	$haber=formato_monto($haber); $fechaf=formato_ddmmaaaa($fecha);	$saldo=formato_monto($saldo); 
			   if($php_os=="WINNT"){$descripcion=$descripcion; }   else{$descripcion=utf8_decode($descripcion); }			   
			   $pdf->Cell(15,3,$fechaf,0,0); 
			   $pdf->Cell(15,3,$referencia,0,0); 
               $pdf->Cell(10,3,$tipo_asiento,0,0); 				   
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=100; 			   
			   $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,3,$debe,0,0,'R');
               $pdf->Cell(20,3,$haber,0,0,'R'); 
               $pdf->Cell(20,3,$saldo,0,1,'R'); 
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$descripcion,0); 				
			} $totald=formato_monto($totald); $totalh=formato_monto($totalh); $totals=formato_monto($totals); 
			$pdf->SetFont('Arial','B',7);
			
			$pdf->Cell(140,2,'',0,0);
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,1,'R');
			$pdf->Cell(140,5,'TOTAL GENERAL : ',0,0,'R');
			$pdf->Cell(20,5,$totald,0,0,'R'); 
			$pdf->Cell(20,5,$totalh,0,0,'R'); 
			$pdf->Cell(20,5,$totals,0,1,'R'); 
			$pdf->Output();   
		}
		if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Comparativo_contab_presup.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="90" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>COMPARATIVO CONTABILIDAD PRESUPUESTO</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="90" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?echo	$criterio1?></strong></font></td>
			 </tr>
			 <tr height="20">
			   <td width="90" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Fecha</strong></td>
			   <td width="80" align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
			   <td width="80" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Contabilidad</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Presupuesto</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Diferencia</strong></td>
			 </tr>
		  <?  $i=0;  $totald=0; $totalh=0; $totals=0;  $sub_totald=0; $sub_totalh=0; $prev_cta="";  $cant_mov=0; $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $codigo_cuenta=$registro["codigo_cuenta"];  $nombre_cuenta=$registro["nombre_cuenta"]; 
		       $nombre_cuenta=conv_cadenas($nombre_cuenta,0); $cta_enc=$codigo_cuenta;  $nomb_cta_enc=$nombre_cuenta;  
		       $referencia=$registro["referencia"]; $fecha=$registro["fecha"];  $tipo_asiento=$registro["tipo_asiento"];  $descripcion=$registro["descripcion"]; $nombre=$registro["nombre"];
			   $debe=$registro["columna5"]; $haber=$registro["columna6"]; $anterior=$registro["columna3"]; $saldo=$registro["columna5"]-$registro["columna6"];
			   $totald=$totald+$debe; $totalh=$totalh+$haber; $totals=$totals+$saldo; $sub_totald=$sub_totald+$debe; $sub_totalh=$sub_totalh+$haber; $cant_mov=$cant_mov+1;
			   $debe=formato_monto($debe); 	$haber=formato_monto($haber); $fechaf=formato_ddmmaaaa($fecha);	$saldo=formato_monto($saldo); 			   
			   $descripcion=conv_cadenas($descripcion,0);
			   ?>	   
				<tr>
				   <td width="90" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $fechaf; ?></td>
				   <td width="80" align="left">'<? echo $referencia; ?></td>
				   <td width="80" align="left"><? echo $tipo_asiento; ?></td>
				   <td width="400" align="justify"><? echo $descripcion; ?></td>
				   <td width="120" align="right"><? echo $debe; ?></td>
				   <td width="120" align="right"><? echo $haber; ?></td>
				   <td width="120" align="right"><? echo $saldo; ?></td>
				 </tr>
			   <? 		  
		  }
		   $totald=formato_monto($totald); $totalh=formato_monto($totalh); $totals=formato_monto($totals); 
			?>	 				 
			<tr>
			  <td width="90" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="120" align="right">---------------</td>
			  <td width="120" align="right">---------------</td>
			  <td width="120" align="right">---------------</td>
			</tr>	
			<tr>
			  <td width="90" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="400" align="right"><? echo "Total General  : "; ?></td>
			  <td width="120" align="right"><? echo $totald; ?></td>
			  <td width="120" align="right"><? echo $totalh; ?></td>
			  <td width="120" align="right"><? echo $totals; ?></td>
			</tr>	
			
		  <? 					
		  	  
		  ?></table><?
        }		  
    }
}
?>