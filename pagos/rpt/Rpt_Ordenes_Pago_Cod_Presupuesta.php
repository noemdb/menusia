<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS; error_reporting(E_ALL ^ E_NOTICE);
$nro_orden_d=$_GET["nro_orden_d"];$nro_orden_h=$_GET["nro_orden_h"];$doc_causado_d=$_GET["doc_causado_d"];$doc_causado_h=$_GET["doc_causado_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"]; $ref_comp_d=$_GET["ref_comp_d"]; $ref_comp_h=$_GET["ref_comp_h"];
$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$tipo_orden_d=$_GET["tipo_orden_d"];$tipo_orden_h=$_GET["tipo_orden_h"];$codigo_presu_d=$_GET["codigo_presu_d"];$codigo_presu_h=$_GET["codigo_presu_h"];$cod_fuented=$_GET["cod_fuented"];  $cod_fuenteh=$_GET["cod_fuenteh"];
$status_orden=$_GET["status_orden"];$Sql=""; $tipo_rpt=$_GET["tipo_rpt"];
$criterio1="FECHA DESDE: ".$fecha_d." HASTA: ".$fecha_h;
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}  else{$fecha_d='';}$fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}  else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;
$date = date("d-m-Y");$hora = date("H:i:s a");$sformula="";  $mcontrol=array (0,0,0,0,0,0,0,0,0,0);

   if ($status_orden=='I'){$criterio2="CANCELADA";  
      $sformula=" and  pag001.status='I' and  pag001.fecha_cheque<='".$fecha_hasta."' ";
	  $sformula=" and  ((substring(pag001.Tipo_Causado,1,1)<>'A') and ";
      $sformula=$sformula."(((pag001.status='I') and (pag001.fecha_Cheque<='".$fecha_hasta."'))";
      $sformula=$sformula." OR ((pag001.status='I') and (pag001.nro_orden in (SELECT nro_orden FROM pag007 Where (fecha_Cheque<='".$fecha_hasta."') and (anulado='S') and (fecha_anulado>'".$fecha_hasta."'))))";
      $sformula=$sformula." OR ((pag001.status='N') and (pag001.nro_orden in (SELECT nro_orden FROM pag007 Where (fecha_Cheque<='".$fecha_hasta."') and (anulado='S') and (fecha_anulado>'".$fecha_hasta."')))) ) )";
 
   }
   if ($status_orden=='S'){$criterio2="ANULADA"; 
      $sformula=" and (pag001.anulado='S' and pag001.fecha_anulado<='".$fecha_hasta."') ";
      $sformula=$sformula." and ((pag001.total_causado-pag001.total_retencion-pag001.total_ajuste-pag001.Monto_Am_Ant)-(pag001.Total_pagado)>0)";
   }
   if ($status_orden=='N'){$criterio2="PENDIENTE"; 
      $sformula=" and pag001.status='N' and pag001.anulado='N'  ";
	  $sformula=" and ((substring(pag001.Tipo_Causado,1,1)<>'A') and ";
	  //$sformula=$sformula."((pag001.status='N') or ";	
	  $sformula=$sformula."( (((pag001.status='N') and (pag001.nro_orden not in (SELECT nro_orden FROM pag007 Where (fecha_cheque<='".$fecha_hasta."') and ((anulado='S') and (fecha_anulado>'".$fecha_hasta."')) ))) or ";	
	  $sformula=$sformula."((pag001.status='I') and ( (pag001.fecha_cheque>'".$fecha_hasta."') and (pag001.nro_orden not in (SELECT nro_orden FROM pag007 Where (fecha_cheque<='".$fecha_hasta."') and (anulado='S') and (extract(month from fecha_cheque)<>extract(month from fecha_anulado)) ))) ) ) )";
	  $sformula=$sformula." and ((pag001.anulado='N') Or ((pag001.anulado='S') and (pag001.fecha_anulado>'".$fecha_hasta."')))";
	  $sformula=$sformula." and ((pag001.total_causado-pag001.total_retencion-pag001.total_ajuste)>0) )";
	}
   if ($status_orden=='L'){$criterio2="LIBERADA"; $sformula=" and pag001.status='L' and  pag001.fecha_cheque<='".$fecha_hasta."' ";}
   
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
 
 function buscar_control($clave, $formato){  global $mcontrol;  $j=0;
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} }  
  return $actual;
}
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS'); </script> <?}
else{$php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} } }
     $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
     if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];} 
     $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2; 
  
     $codigo_d=$codigo_presu_d; $cod_presupd=$codigo_presu_d; $codigo_h=$codigo_presu_h; $cod_presuph=$codigo_presu_h; 
     $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presupd,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
     $pos=strrpos($cod_presupd,"?"); if($pos===false){$en_d=0;}else{$en_d=1;} $pos=strrpos($cod_presuph,"?"); if($pos===false){$en_h=0;}else{$en_h=1;}   
     if(($en_d==1)or($en_h==1)){$codigo_d=str_replace("?","0",$cod_presupd); $long_d=strlen($codigo_d); $codigo_h=str_replace("?","9",$cod_presuph); $long_h=strlen($codigo_h);
	  if(($long_d=$long_u)and ($long_h=$long_u)){ $criterio=""; 
         for ($i=0; $i<10; $i++) { $m=$mcontrol[$i]; if($i==0){$a=0;}else{$a=$mcontrol[$i-1];} 
		     if ($m<>0){if($i==0){ $len_nivel=$m; $criterio=""; }else{ $mpos=1+$a;  $len_nivel=($m-$a-1); $criterio=$criterio." and "; }
				$cod_d=substr($codigo_d,$mpos,$len_nivel); $cod_h=substr($codigo_h,$mpos,$len_nivel);$mpp=$mpos+1;
				$criterio=$criterio."substring(pre037.cod_presup,".$mpp.",".$len_nivel.")>='".$cod_d."' and "; $criterio=$criterio."substring(pre037.cod_presup,".$mpp.",".$len_nivel.")<='".$cod_h."' ";  }
	     } $criterio=$criterio."and  pre037.fuente_financ>='".$cod_fuented."' and pre037.fuente_financ<='".$cod_fuenteh."'";
	  }else{$criterio="pre037.cod_presup>='".$codigo_d."' and pre037.cod_presup<='".$codigo_h."' and  pre037.fuente_financ>='".$cod_fuented."' and pre037.fuente_financ<='".$cod_fuenteh."'";}
     }else{$criterio="pre037.cod_presup>='".$cod_presupd."' and pre037.cod_presup<='".$cod_presuph."' and  pre037.fuente_financ>='".$cod_fuented."' and pre037.fuente_financ<='".$cod_fuenteh."'";}

     $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
     $sSQL = "SELECT  pag001.nro_orden, pag001.ced_rif, pag001.fecha, pre099.nombre, pag001.concepto, pre037.referencia_comp, pre037.tipo_compromiso, pre037.cod_presup, pre037.fuente_financ, pre037.monto, pag001.status, pag001.campo_str2, pag001.anulado, pag001.fecha_anulado, pag001.fecha_cheque, pag001.cod_banco, pag001.nro_cheque, pag001.tipo_pago, to_char(fecha,'DD/MM/YYYY') as fechae 
                FROM pag001,pre037,pre002,pre099
                WHERE pag001.Ced_Rif = pre099.Ced_Rif and pag001.nro_orden = pre037.Referencia_Caus and pag001.Tipo_Causado = pre037.Tipo_Causado and pre037.tipo_compromiso = pre002.tipo_compromiso and
                pag001.nro_orden>='".$nro_orden_d."' and pag001.nro_orden<='".$nro_orden_h."' and pag001.fecha>='".$fecha_desde."' and pag001.fecha<='".$fecha_hasta."' and
                pag001.Ced_Rif>='".$cedula_d."' and pag001.Ced_Rif<='".$cedula_h."' and	pag001.tipo_causado>='".$doc_causado_d."' and pag001.tipo_causado<='".$doc_causado_h."' and
                pag001.tipo_orden>='".$tipo_orden_d."' and pag001.tipo_orden<='".$tipo_orden_h."'" . $sformula ." and  pre037.referencia_comp>='".$ref_comp_d."' and  pre037.referencia_comp<='".$ref_comp_h."' and ".
				$criterio." order by pag001.nro_orden,pag001.tipo_causado"; 

		  
    if($tipo_rpt=="HTML"){	 
	      include ("../../class/phpreports/PHpreportMaker.php");
		  $oRpt = new PHpreportMaker();
          $oRpt->setXML("Rpt_Orden_pago_Cod_presupuestario.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("$host");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
   }
   if($tipo_rpt=="PDF"){ $res=pg_query($sSQL); $nro_orden_grupo=""; $fecha_grupo=""; $ced_rif_grupo=""; $nombre_grupo=""; $concepto_grupo=""; $status_grupo="";	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $nro_orden_grupo; global $fecha_grupo; global $tam_logo; global $des_pagado;
		    global $ced_rif_grupo; global $nombre_grupo; global $concepto_grupo; global $status_grupo;	global $registro;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',12);
			$this->Cell(40);
			$this->Cell(140,10,'ORDENES DE PAGO POR CODIGO PRESUPUESTARIO',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(40);
			$this->Cell(50,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(12,5,'ORDEN',1,0);
			$this->Cell(13,5,'FECHA',1,0);
			$this->Cell(40,5,'BENEFICIARIO',1,0);
			$this->Cell(65,5,'CONCEPTO',1,0);
			$this->Cell(40,5,'CODIGO PRESUPUESTARIO',1,0,'0');
			$this->Cell(15,5,'MONTO',1,0,'C');
			$this->Cell(15,5,'ESTATUS',1,1);
			$this->SetFont('Arial','',6); 	
            if(($nro_orden_grupo<>"")and ($nro_orden_grupo=="00000000")){				
                $this->Cell(12,4,$nro_orden_grupo,0,0,'L'); 	
                $this->Cell(13,4,$fecha_grupo,0,0,'L');
				$x=$this->GetX();   $y=$this->GetY(); $n=40; $w=70;
		        $this->SetXY($x+$w+$n,$y);
		        $this->Cell(35,4,$des_pagado,0,0,'R'); 		   
		        $this->Cell(15,4,'',0,0,'R'); 
		        $this->Cell(15,4,$status_grupo,0,1);
                if(strlen(trim($concepto_grupo))>strlen(trim($ced_rif_grupo." ".$nombre_grupo))){ 				
		        $this->SetXY($x,$y);
		        $this->MultiCell($n,4,$ced_rif_grupo." ".$nombre_grupo,0);  
		        $this->SetXY($x+$n,$y);	
		        $this->MultiCell($w,4,$concepto_grupo,0);}
				else{$this->SetXY($x+$n,$y);	
		        $this->MultiCell($w,4,$concepto_grupo,0);
				$this->SetXY($x,$y);
		        $this->MultiCell($n,4,$ced_rif_grupo." ".$nombre_grupo,0);}				
			}			
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'pagina '.$this->pageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbpages();
   	  $pdf->Addpage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $total=0; $sub_total=""; $cantidad=0; $prev_nro_orden="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $nro_orden=$registro["nro_orden"]; $fecha=$registro["fecha"];  $ced_rif=$registro["ced_rif"];  $concepto=$registro["concepto"]; 
	       $nombre=$registro["nombre"];   $status=$registro["status"]; $anulado=$registro["anulado"]; $fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"];
		   $cod_banco=$registro["cod_banco"];  $nro_cheque=$registro["nro_cheque"];  $tipo_pago=$registro["tipo_pago"];  $des_pagado="";
		   if($status=="I"){$des_pagado=" PAGADO: ".$tipo_pago." ".$nro_cheque;}
		   
		   $st_orden=muestra_st_orden($status,$anulado,$fecha_anulado,$fecha_cheque);	$fecha=formato_ddmmaaaa($fecha);	
		   if($php_os=="WINNT"){$concepto=$registro["concepto"]; }   else{$nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto);}
		   $nro_orden_grupo=$nro_orden; $fecha_grupo=$fecha; $ced_rif_grupo=$ced_rif; $nombre_grupo=$nombre; $concepto_grupo=$concepto; $status_grupo=$st_orden;
		   if($prev_nro_orden<>$nro_orden_grupo){ 
			     $pdf->SetFont('Arial','B',7); 
			     if(($sub_total<>0)){ $sub_total=formato_monto($sub_total);					    
				    $pdf->Cell(170,2,'',0,0);
					$pdf->Cell(15,2,'-------------------',0,1,'R');
					$pdf->Cell(170,4,"",0,0,'R'); 
					$pdf->Cell(15,4,$sub_total,0,0,'R'); 
					$pdf->Cell(15,4,'',0,1,'R');
                    $pdf->Ln(5);					
				 }	
				 $pdf->SetFont('Arial','',7);	
				 $pdf->Cell(12,4,$nro_orden_grupo,0,0,'L');
                 $pdf->Cell(13,4,$fecha_grupo,0,0,'L');
				 $x=$pdf->GetX();   $y=$pdf->GetY(); $n=40; $w=70;
		         $pdf->SetXY($x+$w+$n,$y);
		         $pdf->Cell(35,4,$des_pagado,0,0); 		   
		         $pdf->Cell(15,4,'',0,0); 
		         $pdf->Cell(15,4,$status_grupo,0,1);
				 $nombre_temp=$ced_rif_grupo." ".$nombre_grupo;
				 if ($y>=251) { $nombre_temp=substr($nombre_temp,0,42);}
		         if ($y>=254) { $nombre_temp=substr($nombre_temp,0,24);}
				 if(strlen(trim($concepto_grupo))>strlen(trim($nombre_temp))){  
                 $pdf->SetXY($x,$y);
		         $pdf->MultiCell($n,4,$nombre_temp,0);  
		         $pdf->SetXY($x+$n,$y);	
		         $pdf->MultiCell($w,4,$concepto_grupo,0);}
				 else{$pdf->SetXY($x+$n,$y);	
		         $pdf->MultiCell($w,4,$concepto_grupo,0);
				 $pdf->SetXY($x,$y);
		         $pdf->MultiCell($n,4,$nombre_temp,0);  
				 }
				 $prev_nro_orden=$nro_orden_grupo; $sub_total=0; $cantidad=$cantidad+1;
			}
		   $nro_orden=$registro["nro_orden"];$fecha=$registro["fecha"]; $ced_rif=$registro["ced_rif"]; $fuente_financ=$registro["fuente_financ"];
		   $cod_presup=$registro["cod_presup"]; $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_comp=$registro["referencia_comp"]; $status=$registro["status"]; 
           $monto=$registro["monto"]; $total=$total+$monto; $sub_total=$sub_total+$monto;  $monto=formato_monto($monto); $fecha=formato_ddmmaaaa($fecha); 
		   $pdf->Cell(100,4,'',0,0,'C'); 
		   $pdf->Cell(70,4,$tipo_compromiso."  ".$referencia_comp."  ".$cod_presup."  ".$fuente_financ,0,0,'C'); 		   
		   $pdf->Cell(15,4,$monto,0,0,'R'); 
		   $pdf->Cell(15,4,'',0,1);	
		} $total=formato_monto($total); $cantidad=formato_monto ($cantidad);
		$pdf->SetFont('Arial','B',7);
	    if(($sub_total<>0)){ $sub_total=formato_monto($sub_total); 						    
			$pdf->Cell(170,2,'',0,0);
			$pdf->Cell(15,2,'-------------------',0,1,'R');
			$pdf->Cell(170,4,'',0,0,'R');
			$pdf->Cell(15,4,$sub_total,0,1,'R'); 
			$pdf->Ln(5);		
		} 
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();		
		$pdf->Cell(170,5,'',0,0); 
		$pdf->Cell(15,5,'==============',0,1,'R');
		$pdf->Cell(30,4,'Cantidad Ordenes :',0,0,'L');
		$pdf->Cell(10,4,$cantidad,0,0,'L');		
		$pdf->Cell(120,4,'Total Ordenes :',0,0,'R');
		$pdf->Cell(10,4,'',0,0,'L');	
		$pdf->Cell(15,4,$total,0,1,'R'); 		 
		$pdf->Output();   
    }
	
	if($tipo_rpt=="PDF2"){ $res=pg_query($sSQL); $nro_orden_grupo=""; $fecha_grupo=""; $ced_rif_grupo=""; $nombre_grupo=""; $concepto_grupo=""; $status_grupo="";	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $nro_orden_grupo; global $fecha_grupo; global $tam_logo;
		    global $ced_rif_grupo; global $nombre_grupo; global $concepto_grupo; global $status_grupo;	global $registro;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',12);
			$this->Cell(40);
			$this->Cell(140,10,'ORDENES DE PAGO POR CODIGO PRESUPUESTARIO',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(40);
			$this->Cell(50,10,$criterio1,0,0,'L');				
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(12,5,'ORDEN',1,0);
			$this->Cell(13,5,'FECHA',1,0);
			$this->Cell(40,5,'BENEFICIARIO',1,0);
			$this->Cell(65,5,'CONCEPTO',1,0);
			$this->Cell(40,5,'CODIGO PRESUPUESTARIO',1,0,'0');
			$this->Cell(15,5,'MONTO',1,0,'C');
			$this->Cell(15,5,'ESTATUS',1,1);
			$this->SetFont('Arial','',6); 	
            if(($nro_orden_grupo<>"")and ($nro_orden_grupo=="00000000")){				
                $this->Cell(12,4,$nro_orden_grupo,0,0,'L'); 	
                $this->Cell(13,4,$fecha_grupo,0,0,'L');
				$x=$this->GetX();   $y=$this->GetY(); $n=40; $w=70;
		        $this->SetXY($x+$w+$n,$y);
		        $this->Cell(35,4,'',0,0,'R'); 		   
		        $this->Cell(15,4,'',0,0,'R'); 
		        $this->Cell(15,4,$status_grupo,0,1);
                if(strlen(trim($concepto_grupo))>strlen(trim($ced_rif_grupo." ".$nombre_grupo))){ 				
		        $this->SetXY($x,$y);
		        $this->MultiCell($n,4,$ced_rif_grupo." ".$nombre_grupo,0);  
		        $this->SetXY($x+$n,$y);	
		        $this->MultiCell($w,4,$concepto_grupo,0);}
				else{$this->SetXY($x+$n,$y);	
		        $this->MultiCell($w,4,$concepto_grupo,0);
				$this->SetXY($x,$y);
		        $this->MultiCell($n,4,$ced_rif_grupo." ".$nombre_grupo,0);}				
			}			
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'pagina '.$this->pageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbpages();
   	  $pdf->Addpage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $total=0; $sub_total=""; $cantidad=0; $prev_nro_orden="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $nro_orden=$registro["nro_orden"]; $fecha=$registro["fecha"];  $ced_rif=$registro["ced_rif"];  $concepto=$registro["concepto"]; 
	       $nombre=$registro["nombre"];   $status=$registro["status"]; $anulado=$registro["anulado"]; $fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"];
		   $st_orden=muestra_st_orden($status,$anulado,$fecha_anulado,$fecha_cheque);	$fecha=formato_ddmmaaaa($fecha);	
		   if($php_os=="WINNT"){$concepto=$registro["concepto"]; }   else{$nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto);}
		   $nro_orden_grupo=$nro_orden; $fecha_grupo=$fecha; $ced_rif_grupo=$ced_rif; $nombre_grupo=$nombre; $concepto_grupo=$concepto; $status_grupo=$st_orden;
		   if($prev_nro_orden<>$nro_orden_grupo){ 
			     $pdf->SetFont('Arial','B',7); 
			     if(($sub_total<>0)){ $sub_total=formato_monto($sub_total);					    
				    $pdf->Cell(170,2,'',0,0);
					$pdf->Cell(15,2,'-------------------',0,1,'R');
					$pdf->Cell(170,4,"",0,0,'R'); 
					$pdf->Cell(15,4,$sub_total,0,0,'R'); 
					$pdf->Cell(15,4,'',0,1,'R');
                    $pdf->Ln(5);					
				 }	
				 $pdf->SetFont('Arial','',7);	
				 $pdf->Cell(12,4,$nro_orden_grupo,0,0,'L');
                 $pdf->Cell(13,4,$fecha_grupo,0,0,'L');
				 $x=$pdf->GetX();   $y=$pdf->GetY(); $n=40; $w=70;
		         $pdf->SetXY($x+$w+$n,$y);
		         $pdf->Cell(35,4,'',0,0); 		   
		         $pdf->Cell(15,4,'',0,0); 
		         $pdf->Cell(15,4,$status_grupo,0,1);
				 $nombre_temp=$ced_rif_grupo." ".$nombre_grupo;
				 if ($y>=251) { $nombre_temp=substr($nombre_temp,0,42);}
		         if ($y>=254) { $nombre_temp=substr($nombre_temp,0,24);}
				 if(strlen(trim($concepto_grupo))>strlen(trim($nombre_temp))){  
                 $pdf->SetXY($x,$y);
		         $pdf->MultiCell($n,4,$nombre_temp,0);  
		         $pdf->SetXY($x+$n,$y);	
		         $pdf->MultiCell($w,4,$concepto_grupo,0);}
				 else{$pdf->SetXY($x+$n,$y);	
		         $pdf->MultiCell($w,4,$concepto_grupo,0);
				 $pdf->SetXY($x,$y);
		         $pdf->MultiCell($n,4,$nombre_temp,0);  
				 }
				 $prev_nro_orden=$nro_orden_grupo; $sub_total=0; $cantidad=$cantidad+1;
			}
		   $nro_orden=$registro["nro_orden"];$fecha=$registro["fecha"]; $ced_rif=$registro["ced_rif"]; $fuente_financ=$registro["fuente_financ"];
		   $cod_presup=$registro["cod_presup"]; $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_comp=$registro["referencia_comp"]; $status=$registro["status"]; 
           $monto=$registro["monto"]; $total=$total+$monto; $sub_total=$sub_total+$monto;  $monto=formato_monto($monto); $fecha=formato_ddmmaaaa($fecha); 
		   $pdf->Cell(100,4,'',0,0,'C'); 
		   $pdf->Cell(70,4,$tipo_compromiso."  ".$referencia_comp."  ".$cod_presup."  ".$fuente_financ,0,0,'C'); 		   
		   $pdf->Cell(15,4,$monto,0,0,'R'); 
		   $pdf->Cell(15,4,'',0,1);	
		} $total=formato_monto($total); $cantidad=formato_monto ($cantidad);
		$pdf->SetFont('Arial','B',7);
	    if(($sub_total<>0)){ $sub_total=formato_monto($sub_total); 						    
			$pdf->Cell(170,2,'',0,0);
			$pdf->Cell(15,2,'-------------------',0,1,'R');
			$pdf->Cell(170,4,'',0,0,'R');
			$pdf->Cell(15,4,$sub_total,0,1,'R'); 
			$pdf->Ln(5);		
		} 
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();		
		$pdf->Cell(170,5,'',0,0); 
		$pdf->Cell(15,5,'==============',0,1,'R');
		$pdf->Cell(30,4,'Cantidad Ordenes :',0,0,'L');
		$pdf->Cell(10,4,$cantidad,0,0,'L');		
		$pdf->Cell(120,4,'Total Ordenes :',0,0,'R');
		$pdf->Cell(10,4,'',0,0,'L');	
		$pdf->Cell(15,4,$total,0,1,'R'); 		 
		$pdf->Output();   
    }
	
	
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Ordenes_pago_Cod_presupuestario.xls");
	?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="80" align="left" ><strong></strong></td>
			<td width="80" align="left" ><strong></strong></td>
			<td width="200" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ORDENES DE PAGO POR CODIGO PRESUPUESTARIO</strong></font></td>
		 </tr>
	     <tr height="20">
		    <td width="80" align="left" ><strong></strong></td>
		    <td width="80" align="left" ><strong></strong></td>
		    <td width="200" align="left" ><strong></strong></td>
		    <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	$criterio1?></strong></font></td>
	     </tr>
         <tr height="20">
           <td width="80" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ORDEN</strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>FECHA</strong></td>
           <td width="200" align="left" bgcolor="#99CCFF"><strong>BENEFICIARIO</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>CONCEPTO</strong></td>
           <td width="300" align="center" bgcolor="#99CCFF"><strong>CODIGO PRESUPUESTARIO</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>MONTO </strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>ESTATUS</strong></font></td>
         </tr>
     <?
	  
	  $i=0;  $total=0; $sub_total=0;  $cantidad=0; $prev_nro_orden="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $nro_orden=$registro["nro_orden"]; $fecha=$registro["fecha"]; $fecha=formato_ddmmaaaa($fecha); $ced_rif=$registro["ced_rif"];  
	        $nombre=$registro["nombre"]; $concepto=$registro["concepto"]; $status=$registro["status"]; $anulado=$registro["anulado"]; $fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"];
		    $st_orden=muestra_st_orden($status,$anulado,$fecha_anulado,$fecha_cheque);   $nombre=conv_cadenas($nombre,0); $concepto=conv_cadenas($concepto,0);
		    $nro_orden_grupo=$nro_orden; $fecha_grupo=$fecha; $ced_rif_grupo=$ced_rif; $nombre_grupo=$nombre; $concepto_grupo=$concepto; $status_grupo=$st_orden;    
			if($prev_nro_orden<>$nro_orden_grupo){ 
			     if(($sub_total<>0)){ $sub_total=formato_monto($sub_total); 
			     ?>	 				 
                   	 <tr>
			          <td width="80" align="left"></td>
				      <td width="80" align="left"></td>
			          <td width="200" align="left"></td>
				      <td width="400" align="left"></td>
			          <td width="300" align="left"></td>
			          <td width="100" align="right">---------------</td>
				      <td width="100" align="left"></td>
			         </tr>	
			         <tr>
			          <td width="80" align="left"></td>
				      <td width="80" align="left"></td>
			          <td width="200" align="left"></td>
				      <td width="400" align="left"></td>
			          <td width="300" align="left"></td>
				      <td width="100" align="right"><? echo $sub_total; ?></td>
			          <td width="100" align="left"></td>
			        </tr>	
			        <tr>
				      <td width="80" align="left"></td>
			        </tr>	
                 <?  }
			     ?>	   
			      <tr>
					  <td width="80" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $nro_orden; ?></td>
					  <td width="80" align="left"><? echo $fecha; ?></td>
					  <td width="200" align="left"><? echo $ced_rif."  ".$nombre; ?></td>
					  <td width="400" align="left"><? echo $concepto; ?></td>
					  <td width="300" align="left"></td>
					  <td width="100" align="left"></td>
					  <td width="100" align="left"><? echo $status_grupo; ?></td>
			      </tr>
			     <? 					 
			    $prev_nro_orden=$nro_orden_grupo; $sub_total=0;; $cantidad=$cantidad+1;
			}

		   $nro_orden=$registro["nro_orden"];$fecha=$registro["fecha"]; $concepto=$registro["concepto"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; 
		   $cod_presup=$registro["cod_presup"]; $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_comp=$registro["referencia_comp"]; $status=$registro["status"]; 
           $monto=$registro["monto"]; $total=$total+$monto; $sub_total=$sub_total+$monto; 
		   $monto=formato_monto($monto);  $fecha=formato_ddmmaaaa($fecha);  $nombre=conv_cadenas($nombre,0);  $concepto=conv_cadenas($concepto,0);	
		   ?>	   
			 <tr>
			   <td width="80" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"></td>
			   <td width="80" align="left"></td>
			   <td width="200" align="left"></td>
			   <td width="400" align="justify"></td>
			   <td width="300" align="center"><? echo $tipo_compromiso."   ".$referencia_comp."   ".$cod_presup; ?></td>
			   <td width="100" align="right"><? echo $monto; ?></td>
			   <td width="100" align="center"></td>
			 </tr>
		   <? 
	   }  
        if(($sub_total<>0)){ $sub_total=formato_monto($sub_total); 
		  ?>	 				 
			 <tr>
			  <td width="80" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="200" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="300" align="left"></td>
			  <td width="100" align="right">---------------</td>
			  <td width="100" align="left"></td>
			 </tr>	
			 <tr>
			  <td width="80" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="200" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="300" align="left"></td>
			  <td width="100" align="right"><? echo $sub_total; ?></td>
			  <td width="100" align="left"></td>
			</tr>	
			<tr>
			  <td width="80" align="left"></td>
			</tr>	
		 <? }$total=formato_monto($total); $cantidad==formato_monto ($cantidad);	
		 ?>	 				 
   		    <tr>
     		   <td>&nbsp;</td>
            </tr>
			<tr>
				<td width="80"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
				<td width="80"></td>
				<td width="200"><strong>CANTIDAD ORDENES : <? echo $cantidad; ?></strong></td>	
				<td width="400" align="right"></td>
				<td width="300" align="right"><strong>TOTAL ORDENES:</strong></td>
				<td width="100" align="right"><strong><? echo $total; ?></strong></td>
				<td width="100" align="right"></td>
			 </tr>			 
		</table><?
    }	
?>
