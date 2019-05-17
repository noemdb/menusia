<? error_reporting(E_ALL ^ E_NOTICE);include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
   $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";$sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];}
   $long_c=strlen($formato_presup); $cp=strlen($formato_categoria)+2; $fp=strlen($formato_partida);
   
   $nro_orden_d=$_GET["nro_orden_d"];$nro_orden_h=$_GET["nro_orden_h"];$doc_causado_d=$_GET["doc_causado_d"];$doc_causado_h=$_GET["doc_causado_h"]; $tipo_rpt=$_GET["tipo_rpt"]; $tordt=$_GET["tord"]; $det_monto=$_GET["det_monto"];
   $fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$tipo_orden_d=$_GET["tipo_orden_d"];$tipo_orden_h=$_GET["tipo_orden_h"];$status_orden=$_GET["status_orden"];
   $criterio1="FECHA DESDE: ".$fecha_d." HASTA: ".$fecha_h; $date = date("d-m-Y");$hora = date("H:i:s a");    $Sql="";
   if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
   if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;   
   $sformula="";
   if ($status_orden=='I'){$criterio2="CANCELADA";  
      $sformula=" and  pag001.status='I' and  pag001.fecha_cheque<='".$fecha_hasta."' ";
	  $sformula=" and  ((substring(pag001.Tipo_Causado,1,1)<>'A') and ";
      $sformula=$sformula."(((pag001.status='I') And (pag001.fecha_Cheque<='".$fecha_hasta."'))";
      $sformula=$sformula." OR ((pag001.status='I') And (pag001.nro_orden In (SELECT nro_orden FROM PAG007 Where (fecha_Cheque<='".$fecha_hasta."') And (anulado='S') And (fecha_anulado>'".$fecha_hasta."'))))";
      $sformula=$sformula." OR ((pag001.status='N') And (pag001.nro_orden In (SELECT nro_orden FROM PAG007 Where (fecha_Cheque<='".$fecha_hasta."') And (anulado='S') And (fecha_anulado>'".$fecha_hasta."')))) ) )";
   }
   if ($status_orden=='S'){$criterio2="ANULADA"; 
      $sformula=" and (pag001.anulado='S' and pag001.fecha_anulado<='".$fecha_hasta."') ";
      $sformula=$sformula." and ((pag001.total_causado-pag001.total_retencion-pag001.total_ajuste-pag001.Monto_Am_Ant)-(pag001.Total_Pagado)>0)";
   }
   if ($status_orden=='O'){$criterio2="NO ANULADAS"; 
      $sformula=" and (pag001.anulado<>'S') ";
   }
   if ($status_orden=='N'){$criterio2="PENDIENTE"; 
      $sformula=" and pag001.status='N' and pag001.anulado='N'  ";
	  $sformula=" and ((substring(pag001.Tipo_Causado,1,1)<>'A') and ";
	  //$sformula=$sformula."((pag001.status='N') or ";	
	  $sformula=$sformula."((((pag001.status='N') and (pag001.nro_orden not in (SELECT nro_orden FROM PAG007 Where (fecha_cheque<='".$fecha_hasta."') and ((anulado='S') and (fecha_anulado>'".$fecha_hasta."')) ))) or ";	
	  $sformula=$sformula."((pag001.status='I') and ( (pag001.fecha_cheque>'".$fecha_hasta."') and (pag001.nro_orden not in (SELECT nro_orden FROM PAG007 Where (fecha_cheque<='".$fecha_hasta."') and (anulado='S') and (extract(month from fecha_cheque)<>extract(month from fecha_anulado)) ))) ) ) )";
	  $sformula=$sformula." and ((pag001.anulado='N') Or ((pag001.anulado='S') and (pag001.fecha_anulado>'".$fecha_hasta."')))";
	  $sformula=$sformula." and ((pag001.total_causado-pag001.total_retencion-pag001.total_ajuste)>0) )";
	}
   if ($status_orden=='L'){$criterio2="LIBERADA"; $sformula=" and pag001.status='L' and  pag001.fecha_cheque<='".$fecha_hasta."' ";}
   
   if ($status_orden=='A'){$criterio2="ABONADA";  $sformula=" and pag001.status='A' and  pag001.fecha_cheque<='".$fecha_hasta."' "; 
     if($tipo_rpt=="PDF"){ $tipo_rpt="PDF4"; }
   }
   if ($tordt=="P"){  $sformula=$sformula." and (pag001.orden_permanen='S')"; }
   
   if($det_monto=="SI"){
     if($tipo_rpt=="PDF"){ $tipo_rpt="PDF3"; }
	 if($tipo_rpt=="EXCEL"){ $tipo_rpt="EXCEL3"; }
   }
   
   $ctexto=""; $part1=""; $part2="";
  function muestra_st_orden($mstatus_ord,$manu,$mfecha_anu,$mfecha_chq){global $status_orden; global $fecha_hasta;
   $ret_st="PENDIENTE";  $mfecha_chq=str_replace("-","",$mfecha_chq); $mfecha_anu=str_replace("-","",$mfecha_anu);
   if (($mstatus_ord=='I')and($mfecha_chq<=$fecha_hasta)){$ret_st="CANCELADA";}
   else{
     if(($manu=='S')and($mfecha_anu<=$fecha_hasta)){$ret_st="ANULADA";}
     if(($mstatus_ord=='L')and($mfecha_chq<=$fecha_hasta)){$ret_st="LIBERADA";}
	 if(($mstatus_ord=='A')and($mfecha_chq<=$fecha_hasta)){$ret_st="ABONADA";}
   }
   if ($status_orden=='I'){$ret_st="CANCELADA";}
   if ($status_orden=='S'){$ret_st="ANULADA";}
   if ($status_orden=='N'){$ret_st="PENDIENTE";} 
   if ($status_orden=='L'){$ret_st=="LIBERADA";}
   return $ret_st;
 }

 
 
 function corta_texto($long_line){global $ctexto; global $part1; global $part2; 
    $longt=strlen($ctexto); $part1=$ctexto; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($ctexto,0,$long_line); }
    $lp=strlen($part1);  $c2=$lp; $care="N"; 
    if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($ctexto,0,$c2); }       
    $c3=$longt-$c2; if(substr($ctexto,$c2,1)==' '){ $c2=$c2+1; }
	$part2=substr($ctexto,$c2,$c3);
 }	
		
   $cant_orden=0;
   $sql = "SELECT count(pag001.nro_orden) as cant_orden FROM pag001, PRE099  WHERE pag001.Ced_Rif = PRE099.Ced_Rif and   pag001.nro_orden>='".$nro_orden_d."' and pag001.nro_orden<='".$nro_orden_h."' and  pag001.fecha>='".$fecha_desde."' and pag001.fecha<='".$fecha_hasta."'  and
          pag001.Ced_Rif>='".$cedula_d."' and pag001.Ced_Rif<='".$cedula_h."' and	pag001.tipo_causado>='".$doc_causado_d."' and pag001.tipo_causado<='".$doc_causado_h."' and  pag001.tipo_orden>='".$tipo_orden_d."' and pag001.tipo_orden<='".$tipo_orden_h."'" . $sformula ;
   $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$cant_orden=$registro["cant_orden"];}
    
   $sSQL = "SELECT pag001.nro_orden,pag001.tipo_causado,PRE099.nombre,pag001.fecha,pag001.concepto, pag001.total_causado, pag001.total_retencion, pag001.status,  pag001.fecha, (pag001.total_causado - pag001.total_retencion - pag001.total_ajuste - pag001.monto_am_ant) AS monto_orden, pag001.total_ajuste, pag001.monto_am_ant, pag001.total_pagado,  pag001.anulado, pag001.fecha_anulado, pag001.fecha_cheque 
          FROM pag001, PRE099  WHERE pag001.Ced_Rif = PRE099.Ced_Rif and   pag001.nro_orden>='".$nro_orden_d."' and pag001.nro_orden<='".$nro_orden_h."' and  pag001.fecha>='".$fecha_desde."' and pag001.fecha<='".$fecha_hasta."'  and
          pag001.Ced_Rif>='".$cedula_d."' and pag001.Ced_Rif<='".$cedula_h."' and	pag001.tipo_causado>='".$doc_causado_d."' and pag001.tipo_causado<='".$doc_causado_h."' and  pag001.tipo_orden>='".$tipo_orden_d."' and pag001.tipo_orden<='".$tipo_orden_h."'" . $sformula . " order by pag001.nro_orden,pag001.tipo_causado";
   if($tipo_rpt=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");  
		  $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_Listado_Ordenes_Pago.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("$host");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"cant_orden"=>$cant_orden,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
   }
   if($tipo_rpt=="PDF"){	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){global $criterio1; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(100,10,'LISTADO ORDENES DE PAGO',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(100,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',8);	
			$this->Cell(13,5,'ORDEN',1,0);
			$this->Cell(42,5,'NOMBRE',1,0);
			$this->Cell(70,5,'DESCRIPCION',1,0);
			$this->Cell(19,5,'BRUTO',1,0,'C');
			$this->Cell(21,5,'RETENCIONES',1,0,'C');
			$this->Cell(20,5,'NETO',1,0,'C');
			$this->Cell(15,5,'ESTATUS',1,1);
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			
			// INI NMDB 30-04-2018
	        // $this->Cell(100,5,'fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
	        $this->Cell(100,5,' ',0,0,'R');
	        // FIN NMDB 30-04-2018
		}
	  }
	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $total=0; $totaln=0; $totalr=0; $totalp=0; $totalc=0; $cantidad=0; $cb=0;
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha"]; $concepto=$registro["concepto"]; 
		   $fecha=formato_ddmmaaaa($fecha); $total_causado=$registro["total_causado"]; $status=$registro["status"]; $anulado=$registro["anulado"]; 
		   $nombre=$registro["nombre"];  $monto_ret=$registro["total_retencion"]; $monto_orden=$registro["monto_orden"]; $total_pagado=$registro["total_pagado"];
		   $fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"]; $pendiente=$monto_orden-$total_pagado;
		   $st_orden=muestra_st_orden($status,$anulado,$fecha_anulado,$fecha_cheque);	$cantidad=$cantidad+1; $cb=$cb+1;	   
		   $total=$total+$monto_orden; $totaln=$totaln+$total_causado; $totalr=$totalr+$monto_ret; $totalp=$totalp+$pendiente; $totalc=$totalc+$total_pagado;
		   $total_causado=formato_monto($total_causado); $monto_ret=formato_monto($monto_ret); $monto_orden=formato_monto($monto_orden); 
           if($php_os=="WINNT"){$concepto=$registro["concepto"]; }   else{$nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto);}
		   $pdf->Cell(13,3,$nro_orden,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=42; $w=70;		   
		   $pdf->SetXY($x+$w+$n,$y);
		   $pdf->Cell(20,3,$total_causado,0,0,'R'); 
           $pdf->Cell(20,3,$monto_ret,0,0,'R'); 		   
		   $pdf->Cell(20,3,$monto_orden,0,0,'R'); 
		   $pdf->Cell(15,3,$st_orden,0,0); 
		   if ($y>=251) { $nombre=substr($nombre,0,42);}
		   if ($y>=254) { $nombre=substr($nombre,0,22);}
		   if(strlen(trim($concepto))>strlen(trim($nombre))){		   
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$nombre,0);  
		   $pdf->SetXY($x+$n,$y);	
		   $pdf->MultiCell($w,3,$concepto,0); 
		   }else{
		   $pdf->SetXY($x+$n,$y);	
		   $pdf->MultiCell($w,3,$concepto,0); 
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$nombre,0); 
		   } 
		} $total=formato_monto($total); $totaln=formato_monto($totaln); $totalr=formato_monto($totalr);
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(125,2,'',0,0);
		$pdf->Cell(20,2,'=============',0,0,'R');
		$pdf->Cell(20,2,'============',0,0,'R');
		$pdf->Cell(20,2,'=============',0,1,'R');
		
		$pdf->Cell(30,3,'Cantidad Ordenes :',0,0,'L');
		$pdf->Cell(10,3,$cantidad,0,0,'L');
		
		$pdf->Cell(85,5,'Total Ordenes :',0,0,'R');
		$pdf->Cell(20,5,$totaln,0,0,'R'); 
		$pdf->Cell(20,5,$totalr,0,0,'R'); 
		$pdf->Cell(20,5,$total,0,0,'R'); 
		$pdf->Cell(15,5,'',0,0);		 
		$pdf->Output();   
    }
	
	if($tipo_rpt=="PDF2"){	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){global $criterio1; global $tam_logo;
			$this->rect(10,10,260,195);
			$this->Image('../../imagenes/Logo_emp.png',10,10,$tam_logo-10);
			$this->Ln(5);
			$this->SetFont('Arial','B',13);
			$this->Cell(80);
			$this->Cell(100,10,'ORDENES DE PAGO',0,1,'C');			
			$this->SetFont('Arial','B',12);
			$this->Cell(80);
			$this->Cell(100,10,$criterio1,0,1,'C');	
			$this->SetFont('Arial','B',8);	
			$this->Cell(13,3,'NUMERO','T',0,'C');
			$this->Cell(17,3,'FECHA','T',0,'C');
			$this->Cell(29,3,'CODIGO','T',0,'C');
			$this->Cell(80,3,'','T',0);
			$this->Cell(101,3,'','T',0);
			$this->Cell(20,3,'','T',1,'C');
			$this->Cell(13,5,'ORDEN','B',0,'C');
			$this->Cell(17,5,'EMISION','B',0,'C');
			$this->Cell(29,5,'PRESUPUESTARIO','B',0,'C');
			$this->Cell(80,5,'BENEFICIARIO','B',0,'C');
			$this->Cell(101,5,'CONCEPTO','B',0,'C');
			$this->Cell(20,5,'MONTO','B',1,'C');
			$y=$this->GetY();$x=$this->GetX();
			$this->Line(23,$y-8,23,205); 
			$this->Line(40,$y-8,40,205);				
			$this->Line(69,$y-8,69,205);
			$this->Line(149,$y-8,149,205);
            $this->Line(250,$y-8,250,205);			
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(130,5,'fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
	  $pdf->SetAutoPageBreak(true, 10);
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $total=0; $totaln=0; $totalr=0; $totalp=0; $totalc=0; $cantidad=0; $cb=0;
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha"]; $concepto=$registro["concepto"]; 
		   $fecha=formato_ddmmaaaa($fecha); $total_causado=$registro["total_causado"]; $status=$registro["status"]; $anulado=$registro["anulado"]; 
		   $nombre=$registro["nombre"];  $monto_ret=$registro["total_retencion"]; $monto_orden=$registro["monto_orden"]; $total_pagado=$registro["total_pagado"];
		   $fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"]; $pendiente=$monto_orden-$total_pagado;
		   $st_orden=muestra_st_orden($status,$anulado,$fecha_anulado,$fecha_cheque);	$cantidad=$cantidad+1; $cb=$cb+1;	   
		   $total=$total+$monto_orden; $totaln=$totaln+$total_causado; $totalr=$totalr+$monto_ret; $totalp=$totalp+$pendiente; $totalc=$totalc+$total_pagado;
		   $total_causado=formato_monto($total_causado); $monto_ret=formato_monto($monto_ret); $monto_orden=formato_monto($monto_orden); 
           if($php_os=="WINNT"){$concepto=$registro["concepto"]; }   else{$nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto);}
		   $partida='';
		   $linea1n=""; $linea2n=""; $linea3n=""; $linea4n=""; $linea5n=""; $linea6n=""; $linea7n=""; $linea8n=""; $linea9n=""; $linea10n="";
		   $linea1d=""; $linea2d=""; $linea3d=""; $linea4d=""; $linea5d=""; $linea6d=""; $linea7d=""; $linea8d=""; $linea9d=""; $linea10d="";
		   $linea1p=""; $linea2p=""; $linea3p=""; $linea4p=""; $linea5p=""; $linea6p=""; $linea7p=""; $linea8p=""; $linea9p=""; $linea10p="";
		   
		    //nombre - 54 descripcion - 69
		   $clong=54; 	
		   $linea1n=$nombre; $ctexto=$nombre; corta_texto($clong); $linea1n=$part1;  $linea2n=$part2;
		   if(($part2<>'')and(strlen($part2)>$clong)){ $ctexto=$part2; corta_texto($clong); $linea2n=$part1;  $linea3n=$part2; }
		   if(($part2<>'')and(strlen($part2)>$clong)){ $ctexto=$part2; corta_texto($clong); $linea3n=$part1;  $linea4n=$part2; }
		   if(($part2<>'')and(strlen($part2)>$clong)){ $ctexto=$part2; corta_texto($clong); $linea4n=$part1;  $linea5n=$part2; }
		   if(($part2<>'')and(strlen($part2)>$clong)){ $ctexto=$part2; corta_texto($clong); $linea5n=$part1;  $linea6n=$part2; }
		   if(($part2<>'')and(strlen($part2)>$clong)){ $ctexto=$part2; corta_texto($clong); $linea6n=$part1;  $linea7n=$part2; }
		   if(($part2<>'')and(strlen($part2)>$clong)){ $ctexto=$part2; corta_texto($clong); $linea7n=$part1;  $linea8n=$part2; }
		   if(($part2<>'')and(strlen($part2)>$clong)){ $ctexto=$part2; corta_texto($clong); $linea8n=$part1;  $linea9n=$part2; }
		   if(($part2<>'')and(strlen($part2)>$clong)){ $ctexto=$part2; corta_texto($clong); $linea9n=$part1;  $linea10n=$part2; }		   
		   
		   $clong=67; 	
		   $linea1d=$concepto; $ctexto=$concepto; corta_texto($clong); $linea1d=$part1;  $linea2d=$part2;
		   if(($part2<>'')and(strlen($part2)>$clong)){ $ctexto=$part2; corta_texto($clong); $linea2d=$part1;  $linea3d=$part2; }
		   if(($part2<>'')and(strlen($part2)>$clong)){ $ctexto=$part2; corta_texto($clong); $linea3d=$part1;  $linea4d=$part2; }
		   if(($part2<>'')and(strlen($part2)>$clong)){ $ctexto=$part2; corta_texto($clong); $linea4d=$part1;  $linea5d=$part2; }
		   if(($part2<>'')and(strlen($part2)>$clong)){ $ctexto=$part2; corta_texto($clong); $linea5d=$part1;  $linea6d=$part2; }
		   if(($part2<>'')and(strlen($part2)>$clong)){ $ctexto=$part2; corta_texto($clong); $linea6d=$part1;  $linea7d=$part2; }
		   if(($part2<>'')and(strlen($part2)>$clong)){ $ctexto=$part2; corta_texto($clong); $linea7d=$part1;  $linea8d=$part2; }
		   if(($part2<>'')and(strlen($part2)>$clong)){ $ctexto=$part2; corta_texto($clong); $linea8d=$part1;  $linea9d=$part2; }
		   if(($part2<>'')and(strlen($part2)>$clong)){ $ctexto=$part2; corta_texto($clong); $linea9d=$part1;  $linea10d=$part2; }		   
		   
		   $sqlp="select substring(cod_presup from ".$cp." for ".$fp.") as cod_presup, sum(monto) as monto FROM pre037 where referencia_caus='$nro_orden' and tipo_causado='$tipo_causado' group by substring(cod_presup from ".$cp." for ".$fp.") order by substring(cod_presup from ".$cp." for ".$fp.")"; $resp=pg_query($sqlp);$p=0;
	       while($regp=pg_fetch_array($resp)){ $p=$p+1; $cod_presup=$regp["cod_presup"]; $monto=$regp["monto"]; $montop=formato_monto($monto); 
		      if($p==1){ $linea1p=$cod_presup; } if($p==2){ $linea2p=$cod_presup; } if($p==3){ $linea3p=$cod_presup; } if($p==4){ $linea4p=$cod_presup; } if($p==5){ $linea5p=$cod_presup; }
		      if($p==6){ $linea6p=$cod_presup; } if($p==7){ $linea7p=$cod_presup; } if($p==8){ $linea8p=$cod_presup; } if($p==9){ $linea9p=$cod_presup; } if($p==10){ $linea10p=$cod_presup; }
		   }
		   if($p==0){ $linea1p=' SIP '; }
		   $pdf->Cell(13,4,$nro_orden,0,0,'C'); 
           $pdf->Cell(17,4,$fecha,0,0,'C'); 
           $pdf->Cell(29,4,$linea1p,0,0,'C');
		   $pdf->Cell(80,4,$linea1n,0,0,'L');
		   $pdf->Cell(101,4,$linea1d,0,0,'L');
		   $pdf->Cell(20,4,$monto_orden,0,1,'R'); 
		   if(($linea2n<>'')or($linea2d<>'')or($linea2p<>'')){
			  $pdf->Cell(13,4,'',0,0,'C'); 
			  $pdf->Cell(17,4,'',0,0,'C'); 
			  $pdf->Cell(29,4,$linea2p,0,0,'C');
			  $pdf->Cell(80,4,$linea2n,0,0,'L');
			  $pdf->Cell(101,4,$linea2d,0,0,'L');
			  $pdf->Cell(20,4,'',0,1,'R'); 
		   }
		   if(($linea3n<>'')or($linea3d<>'')or($linea3p<>'')){
			  $pdf->Cell(13,4,'',0,0,'C'); 
			  $pdf->Cell(17,4,'',0,0,'C'); 
			  $pdf->Cell(29,4,$linea3p,0,0,'C');
			  $pdf->Cell(80,4,$linea3n,0,0,'L');
			  $pdf->Cell(101,4,$linea3d,0,0,'L');
			  $pdf->Cell(20,4,'',0,1,'R'); 
		   }
		   if(($linea4n<>'')or($linea4d<>'')or($linea4p<>'')){
			  $pdf->Cell(13,4,'',0,0,'C'); 
			  $pdf->Cell(17,4,'',0,0,'C'); 
			  $pdf->Cell(29,4,$linea4p,0,0,'C');
			  $pdf->Cell(80,4,$linea4n,0,0,'L');
			  $pdf->Cell(101,4,$linea4d,0,0,'L');
			  $pdf->Cell(20,4,'',0,1,'R'); 
		   }
		   if(($linea5n<>'')or($linea5d<>'')or($linea5p<>'')){
			  $pdf->Cell(13,4,'',0,0,'C'); 
			  $pdf->Cell(17,4,'',0,0,'C'); 
			  $pdf->Cell(29,4,$linea5p,0,0,'C');
			  $pdf->Cell(80,4,$linea5n,0,0,'L');
			  $pdf->Cell(101,4,$linea5d,0,0,'L');
			  $pdf->Cell(20,4,'',0,1,'R'); 
		   }
		   if(($linea6n<>'')or($linea6d<>'')or($linea6p<>'')){
			  $pdf->Cell(13,4,'',0,0,'C'); 
			  $pdf->Cell(17,4,'',0,0,'C'); 
			  $pdf->Cell(29,4,$linea6p,0,0,'C');
			  $pdf->Cell(80,4,$linea6n,0,0,'L');
			  $pdf->Cell(101,4,$linea6d,0,0,'L');
			  $pdf->Cell(20,4,'',0,1,'R'); 
		   }
		   if(($linea7n<>'')or($linea7d<>'')or($linea7p<>'')){
			  $pdf->Cell(13,4,'',0,0,'C'); 
			  $pdf->Cell(17,4,'',0,0,'C'); 
			  $pdf->Cell(29,4,$linea7p,0,0,'C');
			  $pdf->Cell(80,4,$linea7n,0,0,'L');
			  $pdf->Cell(101,4,$linea7d,0,0,'L');
			  $pdf->Cell(20,4,'',0,1,'R'); 
		   }
		   if(($linea8n<>'')or($linea8d<>'')or($linea8p<>'')){
			  $pdf->Cell(13,4,'',0,0,'C'); 
			  $pdf->Cell(17,4,'',0,0,'C'); 
			  $pdf->Cell(29,4,$linea8p,0,0,'C');
			  $pdf->Cell(80,4,$linea8n,0,0,'L');
			  $pdf->Cell(101,4,$linea8d,0,0,'L');
			  $pdf->Cell(20,4,'',0,1,'R'); 
		   }
		   if(($linea9n<>'')or($linea9d<>'')or($linea9p<>'')){
			  $pdf->Cell(13,4,'',0,0,'C'); 
			  $pdf->Cell(17,4,'',0,0,'C'); 
			  $pdf->Cell(29,4,$linea9p,0,0,'C');
			  $pdf->Cell(80,4,$linea9n,0,0,'L');
			  $pdf->Cell(101,4,$linea9d,0,0,'L');
			  $pdf->Cell(20,4,'',0,1,'R'); 
		   }
		   if(($linea10n<>'')or($linea10d<>'')or($linea10p<>'')){
			  $pdf->Cell(13,3,'',0,0,'C'); 
			  $pdf->Cell(17,3,'',0,0,'C'); 
			  $pdf->Cell(29,3,$linea10p,0,0,'C');
			  $pdf->Cell(80,3,$linea10n,0,0,'L');
			  $pdf->Cell(101,3,$linea10d,0,0,'L');
			  $pdf->Cell(20,3,'',0,1,'R'); 
		   }
           $pdf->Cell(260,1,'','B',1);		   
		} $total=formato_monto($total); $totaln=formato_monto($totaln); $totalr=formato_monto($totalr);
		$pdf->SetFont('Arial','B',8);
		$x=$pdf->GetX();  $y=$pdf->GetY();
	    if($y<195){$t=195-$y; $pdf->ln($t);} 
		$pdf->Cell(60,5,'','T',0,'L');
		$pdf->Cell(70,5,'Cantidad Ordenes :','T',0,'R');
		$pdf->Cell(10,5,$cantidad,'T',0,'C');
		$pdf->Cell(100,5,'Total Ordenes :','T',0,'R');
		$pdf->Cell(20,5,$total,'T',1,'R'); 
		$pdf->Output();   
    }
	
	
	if($tipo_rpt=="PDF22"){	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){global $criterio1; global $tam_logo;
			$this->rect(10,10,260,190);
			$this->Image('../../imagenes/Logo_emp.png',10,10,$tam_logo-10);
			$this->Ln(5);
			$this->SetFont('Arial','B',13);
			$this->Cell(80);
			$this->Cell(100,10,'ORDENES DE PAGO',0,1,'C');
			
			$this->SetFont('Arial','B',12);
			$this->Cell(80);
			$this->Cell(100,10,$criterio1,0,1,'C');				
			
			$this->SetFont('Arial','B',8);	
			$this->Cell(13,3,'NUMERO','T',0,'C');
			$this->Cell(17,3,'FECHA','T',0,'C');
			$this->Cell(30,3,'CODIGO','T',0,'C');
			$this->Cell(80,3,'','T',0);
			$this->Cell(100,3,'','T',0);
			$this->Cell(20,3,'','T',1,'C');
			$this->Cell(13,5,'ORDEN','B',0,'C');
			$this->Cell(17,5,'EMISION','B',0,'C');
			$this->Cell(30,5,'PRESUPUESTARIO','B',0,'C');
			$this->Cell(80,5,'BENEFICIARIO','B',0,'C');
			$this->Cell(100,5,'CONCEPTO','B',0,'C');
			$this->Cell(20,5,'MONTO','B',1,'C');
			
			$y=$this->GetY();$x=$this->GetX();
			$this->Line(23,$y-8,23,200); 
			$this->Line(40,$y-8,40,200);				
			$this->Line(70,$y-8,70,200);
			$this->Line(150,$y-8,150,200);
            $this->Line(250,$y-8,250,200);			
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(130,5,'fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $total=0; $totaln=0; $totalr=0; $totalp=0; $totalc=0; $cantidad=0; $cb=0;
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha"]; $concepto=$registro["concepto"]; 
		   $fecha=formato_ddmmaaaa($fecha); $total_causado=$registro["total_causado"]; $status=$registro["status"]; $anulado=$registro["anulado"]; 
		   $nombre=$registro["nombre"];  $monto_ret=$registro["total_retencion"]; $monto_orden=$registro["monto_orden"]; $total_pagado=$registro["total_pagado"];
		   $fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"]; $pendiente=$monto_orden-$total_pagado;
		   $st_orden=muestra_st_orden($status,$anulado,$fecha_anulado,$fecha_cheque);	$cantidad=$cantidad+1; $cb=$cb+1;	   
		   $total=$total+$monto_orden; $totaln=$totaln+$total_causado; $totalr=$totalr+$monto_ret; $totalp=$totalp+$pendiente; $totalc=$totalc+$total_pagado;
		   $total_causado=formato_monto($total_causado); $monto_ret=formato_monto($monto_ret); $monto_orden=formato_monto($monto_orden); 
           if($php_os=="WINNT"){$concepto=$registro["concepto"]; }   else{$nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto);}
		   $partida='';
		   $pdf->Cell(13,4,$nro_orden,0,0,'C'); 
           $pdf->Cell(17,4,$fecha,0,0,'C'); 
           $pdf->Cell(30,4,$partida,0,0,'C'); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=80; $w=100;		   
		   $pdf->SetXY($x+$w+$n,$y);	   
		   $pdf->Cell(20,4,$monto_orden,0,1,'R'); 
		   if ($y>=251) { $nombre=substr($nombre,0,62);}
		   if ($y>=254) { $nombre=substr($nombre,0,42);}
		   if(strlen(trim($concepto))>strlen(trim($nombre))){		   
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,4,$nombre,0);  
		   $pdf->SetXY($x+$n,$y);	
		   $pdf->MultiCell($w,4,$concepto,0); 
		   }else{
		   $pdf->SetXY($x+$n,$y);	
		   $pdf->MultiCell($w,4,$concepto,0); 
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,4,$nombre,0); 
		   }
           $pdf->Cell(260,1,'','B',1);		   
		} $total=formato_monto($total); $totaln=formato_monto($totaln); $totalr=formato_monto($totalr);
		$pdf->SetFont('Arial','B',8);
		$x=$pdf->GetX();  $y=$pdf->GetY();
	    if($y<190){$t=190-$y; $pdf->ln($t);} 
		$pdf->Cell(60,5,'','T',0,'L');
		$pdf->Cell(70,5,'Cantidad Ordenes :','T',0,'R');
		$pdf->Cell(10,5,$cantidad,'T',0,'C');
		$pdf->Cell(100,5,'Total Ordenes :','T',0,'R');
		$pdf->Cell(20,5,$total,'T',1,'R'); 
		$pdf->Output();   
    }
	
	if($tipo_rpt=="PDF4"){	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){global $criterio1; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(100,10,'LISTADO ORDENES DE PAGO',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(100,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',8);	
			$this->Cell(13,5,'ORDEN',1,0);
			$this->Cell(47,5,'NOMBRE',1,0);
			$this->Cell(80,5,'DESCRIPCION',1,0);
			$this->Cell(20,5,'NETO',1,0,'C');
			$this->Cell(20,5,'CANCELADO',1,0,'C');
			$this->Cell(20,5,'PENDIENTE',1,1,'C');
			//$this->Cell(15,5,'ESTATUS',1,1);
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $total=0; $totaln=0; $totalr=0; $cantidad=0; $cb=0; $totalp=0; $totalc=0;
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha"]; $concepto=$registro["concepto"]; 
		   $fecha=formato_ddmmaaaa($fecha); $total_causado=$registro["total_causado"]; $status=$registro["status"]; $anulado=$registro["anulado"]; 
		   $nombre=$registro["nombre"];  $monto_ret=$registro["total_retencion"]; $monto_orden=$registro["monto_orden"]; $total_pagado=$registro["total_pagado"];
		   $fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"]; $pendiente=$monto_orden-$total_pagado;
		   $st_orden=muestra_st_orden($status,$anulado,$fecha_anulado,$fecha_cheque);
           if($php_os=="WINNT"){$concepto=$registro["concepto"]; }   else{$nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto);}
		   //if($pendiente<>0){
           if($pendiente>0){ 		   
		       $total=$total+$monto_orden; $totaln=$totaln+$total_causado; $totalr=$totalr+$monto_ret;  $totalp=$totalp+$pendiente; $totalc=$totalc+$total_pagado;
		       $total_causado=formato_monto($total_causado); $monto_ret=formato_monto($monto_ret); $monto_orden=formato_monto($monto_orden); 
		       $total_pagado=formato_monto($total_pagado); $pendiente=formato_monto($pendiente);
			   $cantidad=$cantidad+1; $cb=$cb+1;	
			   $pdf->Cell(13,3,$nro_orden,0,0); 		   
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=47; $w=80;		   
			   $pdf->SetXY($x+$w+$n,$y);
			   $pdf->Cell(20,3,$monto_orden,0,0,'R'); 
			   $pdf->Cell(20,3,$total_pagado,0,0,'R'); 		   
			   $pdf->Cell(20,3,$pendiente,0,0,'R'); 
			   if ($y>=251) { $nombre=substr($nombre,0,49);}
			   if ($y>=254) { $nombre=substr($nombre,0,24);}
			   if(strlen(trim($concepto))>strlen(trim($nombre))){		   
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$nombre,0);  
			   $pdf->SetXY($x+$n,$y);	
			   $pdf->MultiCell($w,3,$concepto,0); 
			   }else{
			   $pdf->SetXY($x+$n,$y);	
			   $pdf->MultiCell($w,3,$concepto,0); 
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$nombre,0); 
			   } 
			}
		   
		} $total=formato_monto($total); $totalp=formato_monto($totalp); $totalc=formato_monto($totalc);
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(140,2,'',0,0);
		$pdf->Cell(20,2,'=============',0,0,'R');
		$pdf->Cell(20,2,'============',0,0,'R');
		$pdf->Cell(20,2,'=============',0,1,'R');
		
		$pdf->Cell(30,3,'Cantidad Ordenes :',0,0,'L');
		$pdf->Cell(10,3,$cantidad,0,0,'L');
		
		$pdf->Cell(100,5,'Total Ordenes :',0,0,'R');
		$pdf->Cell(20,5,$total,0,0,'R'); 
		$pdf->Cell(20,5,$totalc,0,0,'R'); 
		$pdf->Cell(20,5,$totalp,0,1,'R'); 
		$pdf->Output();   
    }
	
	if($tipo_rpt=="PDF3"){	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){global $criterio1; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',15);
			$this->Cell(80);
			$this->Cell(100,10,'LISTADO ORDENES DE PAGO',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(100,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',8);	
			$this->Cell(13,5,'ORDEN',1,0);
			$this->Cell(52,5,'NOMBRE',1,0);
			$this->Cell(80,5,'DESCRIPCION',1,0);
			$this->Cell(19,5,'BRUTO',1,0,'C');
			$this->Cell(22,5,'RETENCIONES',1,0,'C');
			$this->Cell(20,5,'AMORT. ANT.',1,0,'C');
			$this->Cell(20,5,'AJUSTES',1,0,'C');
			$this->Cell(20,5,'NETO',1,0,'C');
			$this->Cell(15,5,'ESTATUS',1,1);
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(130,5,'fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $total=0; $totaln=0; $totalr=0; $totalp=0; $totalc=0;  $totalj=0; $totala=0; $cantidad=0; $cb=0;
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha"]; $concepto=$registro["concepto"]; 
		   $fecha=formato_ddmmaaaa($fecha); $total_causado=$registro["total_causado"]; $status=$registro["status"]; $anulado=$registro["anulado"]; 
		   $nombre=$registro["nombre"];  $monto_ret=$registro["total_retencion"]; $monto_orden=$registro["monto_orden"]; $total_pagado=$registro["total_pagado"];
		   $monto_am_ant=$registro["monto_am_ant"]; $total_ajuste=$registro["total_ajuste"]; $totalj=$totalj+$total_ajuste; $totala=$totala+$monto_am_ant;
		   $fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"]; $pendiente=$monto_orden-$total_pagado;
		   $st_orden=muestra_st_orden($status,$anulado,$fecha_anulado,$fecha_cheque);	$cantidad=$cantidad+1; $cb=$cb+1;	   
		   $total=$total+$monto_orden; $totaln=$totaln+$total_causado; $totalr=$totalr+$monto_ret; $totalp=$totalp+$pendiente; $totalc=$totalc+$total_pagado;
		   $total_causado=formato_monto($total_causado); $monto_ret=formato_monto($monto_ret); $monto_orden=formato_monto($monto_orden); 
		   $total_ajuste=formato_monto($total_ajuste); $monto_am_ant=formato_monto($monto_am_ant); 
           if($php_os=="WINNT"){$concepto=$registro["concepto"]; }   else{$nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto);}
		   $pdf->Cell(13,3,$nro_orden,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=52; $w=80;		   
		   $pdf->SetXY($x+$w+$n,$y);
		   $pdf->Cell(20,3,$total_causado,0,0,'R'); 
           $pdf->Cell(20,3,$monto_ret,0,0,'R'); 
           $pdf->Cell(20,3,$monto_am_ant,0,0,'R');
           $pdf->Cell(20,3,$total_ajuste,0,0,'R');  		   
		   $pdf->Cell(20,3,$monto_orden,0,0,'R'); 
		   $pdf->Cell(15,3,$st_orden,0,0); 		   
		   if ($y>=188) { $nombre=substr($nombre,0,49);}
		   if ($y>=191) { $nombre=substr($nombre,0,29);}		   
		   if(strlen(trim($concepto))>strlen(trim($nombre))){		   
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$nombre,0);  
		   $pdf->SetXY($x+$n,$y);	
		   $pdf->MultiCell($w,3,$concepto,0); 
		   }else{
		   $pdf->SetXY($x+$n,$y);	
		   $pdf->MultiCell($w,3,$concepto,0); 
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$nombre,0); 
		   } 
		} $total=formato_monto($total); $totaln=formato_monto($totaln); $totalr=formato_monto($totalr);  $totala=formato_monto($totala);  $totalj=formato_monto($totalj);
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(145,2,'',0,0);
		$pdf->Cell(20,2,'=============',0,0,'R');
		$pdf->Cell(20,2,'============',0,0,'R');
		$pdf->Cell(20,2,'============',0,0,'R');
		$pdf->Cell(20,2,'============',0,0,'R');
		$pdf->Cell(20,2,'=============',0,1,'R');
		$pdf->Cell(30,3,'Cantidad Ordenes :',0,0,'L');
		$pdf->Cell(10,3,$cantidad,0,0,'L');
		$pdf->Cell(105,5,'Total Ordenes :',0,0,'R');
		$pdf->Cell(20,5,$totaln,0,0,'R'); 
		$pdf->Cell(20,5,$totalr,0,0,'R'); 
		$pdf->Cell(20,5,$totala,0,0,'R'); 
		$pdf->Cell(20,5,$totalj,0,0,'R'); 
		$pdf->Cell(20,5,$total,0,0,'R'); 
		$pdf->Cell(15,5,'',0,0);		 
		$pdf->Output();   
    }
	
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Listado_Ordenes_Pago.xls");		
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="80" align="left" ><strong></strong></td>
			<td width="200" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO ORDENES DE PAGO</strong></font></td>
		 </tr>
		 <tr height="20">
		   <td width="80" align="left" ><strong></strong></td>
		   <td width="200" align="left" ><strong></strong></td>
		   <td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio1; ?></strong></font></td>
	     </tr>
         <tr height="20">
           <td width="80" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ORDEN</strong></td>
           <td width="200" align="left" bgcolor="#99CCFF"><strong>NOMBRE</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>DESCRIPCION</strong></td>
           <td width="110" align="center" bgcolor="#99CCFF"><strong>BRUTO</strong></td>
           <td width="110" align="center" bgcolor="#99CCFF"><strong>RETENCIONES</strong></td>
           <td width="110" align="center" bgcolor="#99CCFF" ><strong>NETO </strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Estatus</strong></font></td>
         </tr>
     <?	  
	  $i=0;  $total=0; $totaln=0; $totalr=0; $cantidad=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha"]; $concepto=$registro["concepto"]; 
		   $fecha=formato_ddmmaaaa($fecha); $total_causado=$registro["total_causado"]; $status=$registro["status"]; $anulado=$registro["anulado"];
		   $nombre=$registro["nombre"];  $monto_ret=$registro["total_retencion"]; $monto_orden=$registro["monto_orden"];$fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"];
		   $st_orden=muestra_st_orden($status,$anulado,$fecha_anulado,$fecha_cheque); $cantidad=$cantidad+1;
		   $total=$total+$monto_orden; $totaln=$totaln+$total_causado; $totalr=$totalr+$monto_ret;
		   $total_causado=formato_monto($total_causado); $monto_ret=formato_monto($monto_ret); $monto_orden=formato_monto($monto_orden); 
		   $nombre=conv_cadenas($nombre,0);  $concepto=conv_cadenas($concepto,0);
	?>	   
		   <tr>
           <td width="80" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $nro_orden; ?></td>
           <td width="200" align="left"><? echo $nombre; ?></td>
           <td width="400" align="justify"><? echo $concepto; ?></td>
           <td width="110" align="right"><? echo $total_causado; ?></td>
           <td width="110" align="right"><? echo $monto_ret; ?></td>
           <td width="110" align="right"><? echo $monto_orden; ?></td>
           <td width="100" align="center"><? echo $st_orden; ?></td>
         </tr>
	<? }  $total=formato_monto($total); $totaln=formato_monto($totaln); $totalr=formato_monto($totalr); ?>
	   <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td width="80"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
		<td width="200"><strong>CANTIDAD ORDENES : <? echo $cantidad; ?></strong></td>	
		<td width="400" align="right"><strong>TOTAL ORDENES:</strong></td>
		<td width="110" align="right"><strong><? echo $totaln; ?></strong></td>
		<td width="110" align="right"><strong><? echo $totalr; ?></strong></td>
		<td width="110" align="right"><strong><? echo $total; ?></strong></font></td>
      </tr>
      
	  </table><?
	}
	
	
	if($tipo_rpt=="EXCEL2"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Listado_Ordenes_Pago.xls");		
	  ?>
       <table>
	     <tr>
         <td><table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="80" align="left"></td>
			<td width="80" align="left" ><strong></strong></td>
			 <td width="80" align="left" ><strong></strong></td>
            <td width="680" colspan="3" align="left" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO ORDENES DE PAGO</strong></font></td>
		 </tr>
		 <tr height="20">
		   <td width="80" align="left" ><strong></strong></td>
		   <td width="80" align="left" ><strong></strong></td>
		   <td width="80" align="left" ><strong></strong></td>
		   <td width="600" colspan="3" align="left" > <font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio1; ?></strong></font></td>
	     </tr>
		  </table></td>
         </tr>
		 <tr>
            <td><table border="1" cellspacing='0' cellpadding='0' align="left">
         <tr height="20">
           <td width="80" align="center" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>NUMERO ORDEN</strong></td>
           <td width="80" align="center" bgcolor="#99CCFF"><strong>FECHA EMISION</strong></td>
		   <td width="80" align="center" bgcolor="#99CCFF"><strong>CODIGO PRESUPUESTARIO</strong></td>
		   <td width="200" align="center" bgcolor="#99CCFF"><strong>BENEFICIARIO</strong></td>
           <td width="400" align="center" bgcolor="#99CCFF"><strong>CONCEPTO</strong></td>
           <td width="110" align="center" bgcolor="#99CCFF" ><strong>MONTO </strong></td>
         </tr>
     <?	  
	  $i=0;  $total=0; $totaln=0; $totalr=0; $cantidad=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha"]; $concepto=$registro["concepto"]; 
		   $fecha=formato_ddmmaaaa($fecha); $total_causado=$registro["total_causado"]; $status=$registro["status"]; $anulado=$registro["anulado"];
		   $nombre=$registro["nombre"];  $monto_ret=$registro["total_retencion"]; $monto_orden=$registro["monto_orden"];$fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"];
		   $st_orden=muestra_st_orden($status,$anulado,$fecha_anulado,$fecha_cheque); $cantidad=$cantidad+1;
		   $total=$total+$monto_orden; $totaln=$totaln+$total_causado; $totalr=$totalr+$monto_ret;
		   $total_causado=formato_monto($total_causado); $monto_ret=formato_monto($monto_ret); $monto_orden=formato_monto($monto_orden); 
		   $nombre=conv_cadenas($nombre,0);  $concepto=conv_cadenas($concepto,0); $partida='';
		   $sqlp="select substring(cod_presup from ".$cp." for ".$fp.") as cod_presup, sum(monto) as monto FROM pre037 where referencia_caus='$nro_orden' and tipo_causado='$tipo_causado' group by substring(cod_presup from ".$cp." for ".$fp.") order by substring(cod_presup from ".$cp." for ".$fp.")"; $resp=pg_query($sqlp);$p=0;
	       while($regp=pg_fetch_array($resp)){ $p=$p+1; $cod_presup=$regp["cod_presup"]; $monto=$regp["monto"]; $montop=formato_monto($monto); 
		      $partida=$partida.' '.$cod_presup.' ';
		    }
			if($p==0){ $partida=' SIP '; }
			$stilo1="mso-number-format:'@';";
		   
	?>	   
		   <tr>
           <td width="80" align="left" colspan="1" rowspan="1" style="<? echo $stilo1; ?>"><? echo $nro_orden; ?></td>
           <td width="80" align="left" style="<? echo $stilo1; ?>"><? echo $fecha; ?></td>
		   <td width="80" align="center"><? echo $partida; ?></td>
		   <td width="200" align="left"><? echo $nombre; ?></td>
           <td width="400" align="justify"><? echo $concepto; ?></td>
           <td width="110" align="right"><? echo $monto_orden; ?></td>
         </tr>
	<? }  $total=formato_monto($total); $totaln=formato_monto($totaln); $totalr=formato_monto($totalr); ?>
	  <tr>
        <td width="80"><strong></strong></td>
		<td width="80" align="left" ><strong></strong></td>
		<td width="280" colspan="2" ><strong>CANTIDAD ORDENES : <? echo $cantidad; ?></strong></td>	
		<td width="400" align="right"><strong>TOTAL ORDENES:</strong></td>
		<td width="110" align="right"><strong><? echo $total; ?></strong></font></td>
      </tr>
      </table></td>
         </tr>
	  </table><?
	}
	
	
    if($tipo_rpt=="EXCEL3"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Listado_Ordenes_Pago_det.xls");		
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="80" align="left" ><strong></strong></td>
			<td width="200" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO ORDENES DE PAGO</strong></font></td>
		 </tr>
		 <tr height="20">
		   <td width="80" align="left" ><strong></strong></td>
		   <td width="200" align="left" ><strong></strong></td>
		   <td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio1; ?></strong></font></td>
	     </tr>
         <tr height="20">
           <td width="80" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ORDEN</strong></td>
           <td width="200" align="left" bgcolor="#99CCFF"><strong>NOMBRE</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>DESCRIPCION</strong></td>
           <td width="110" align="center" bgcolor="#99CCFF"><strong>BRUTO</strong></td>
           <td width="110" align="center" bgcolor="#99CCFF"><strong>RETENCIONES</strong></td>
		   <td width="110" align="center" bgcolor="#99CCFF"><strong>AMORT. ANTICIPO</strong></td>
		   <td width="110" align="center" bgcolor="#99CCFF"><strong>AJUSTES</strong></td>
           <td width="110" align="center" bgcolor="#99CCFF" ><strong>NETO </strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>ESTATUS</strong></font></td>
         </tr>
     <?	  
	  $i=0;  $total=0; $totaln=0; $totalr=0; $totala=0; $totalj=0; $cantidad=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha"]; $concepto=$registro["concepto"]; 
		   $fecha=formato_ddmmaaaa($fecha); $total_causado=$registro["total_causado"]; $status=$registro["status"]; $anulado=$registro["anulado"];
		   $nombre=$registro["nombre"];  $monto_ret=$registro["total_retencion"]; $monto_orden=$registro["monto_orden"];$fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"];
		   $monto_am_ant=$registro["monto_am_ant"]; $total_ajuste=$registro["total_ajuste"]; $totalj=$totalj+$total_ajuste; $totala=$totala+$monto_am_ant;
		   $st_orden=muestra_st_orden($status,$anulado,$fecha_anulado,$fecha_cheque); $cantidad=$cantidad+1;
		   $total=$total+$monto_orden; $totaln=$totaln+$total_causado; $totalr=$totalr+$monto_ret;
		   $total_causado=formato_monto($total_causado); $monto_ret=formato_monto($monto_ret); $monto_orden=formato_monto($monto_orden); 
		   $nombre=conv_cadenas($nombre,0);  $concepto=conv_cadenas($concepto,0); $total_ajuste=formato_monto($total_ajuste); $monto_am_ant=formato_monto($monto_am_ant); 
	?>	   
		   <tr>
           <td width="80" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $nro_orden; ?></td>
           <td width="200" align="left"><? echo $nombre; ?></td>
           <td width="400" align="justify"><? echo $concepto; ?></td>
           <td width="110" align="right"><? echo $total_causado; ?></td>
           <td width="110" align="right"><? echo $monto_ret; ?></td>
           <td width="110" align="right"><? echo $monto_am_ant; ?></td>
		   <td width="110" align="right"><? echo $total_ajuste; ?></td>
           <td width="110" align="right"><? echo $monto_orden; ?></td>
           <td width="100" align="center"><? echo $st_orden; ?></td>
         </tr>
	<? }  $total=formato_monto($total); $totaln=formato_monto($totaln); $totalr=formato_monto($totalr); $totala=formato_monto($totala);  $totalj=formato_monto($totalj); ?>
	   <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td width="80"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
		<td width="200"><strong>CANTIDAD ORDENES : <? echo $cantidad; ?></strong></td>	
		<td width="400" align="right"><strong>TOTAL ORDENES:</strong></td>
		<td width="110" align="right"><strong><? echo $totaln; ?></strong></td>
		<td width="110" align="right"><strong><? echo $totalr; ?></strong></td>
		<td width="110" align="right"><strong><? echo $totala; ?></strong></td>
		<td width="110" align="right"><strong><? echo $totalj; ?></strong></td>
		<td width="110" align="right"><strong><? echo $total; ?></strong></font></td>
      </tr>
	  </table><?
	}
} 
?>