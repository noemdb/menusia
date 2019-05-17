<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$cod_presupd=$_GET["cod_presupd"];$cod_presuph=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuente_d"];$cod_fuente_h=$_GET["cod_fuente_h"];$doc_comp_d=$_GET["doc_comp_d"]; $doc_comp_h=$_GET["doc_comp_h"];$referencia_d=$_GET["referencia_d"];$referencia_h=$_GET["referencia_h"];$nro_doc_d=$_GET["nro_doc_d"];$nro_doc_h=$_GET["nro_doc_h"]; $fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"]; $tipo_comp_d=$_GET["tipo_comp_d"]; $tipo_comp_h=$_GET["tipo_comp_h"]; $ref_imput_presu_d=$_GET["ref_imput_presu_d"]; $ref_imput_presu_h=$_GET["ref_imput_presu_h"]; $tipo_regis=$_GET["tipo_regis"]; $tipo_rep=$_GET["tipo_rep"]; $det_rep=$_GET["det_rep"];}
else{$codigod="";$codigoh="";$fuented="";$fuenteh="";$fecha="";$tipo_rep="HTML";$det_rep="SI";} $php_os=PHP_OS;  $equipo=getenv("COMPUTERNAME"); $cod_mov="pre021".$usuario_sia;
$mcontrol=array (0,0,0,0,0,0,0,0,0,0);
function buscar_control($clave, $formato){  global $mcontrol;  $j=0;
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} }  
  return $actual;
}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } 
else { $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}}
  $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];} 
  $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;
  $cfecha_h=formato_aaaammdd($fecha_h); $cfecha_d=formato_aaaammdd($fecha_d); $criterio_est="";
  if($tipo_regis=='TO'){$nombre='TODOS';}
  if($tipo_regis=='ANU'){$nombre='ANULADOS'; $criterio_est="(pre006.anulado='S') And ";}  
  if($tipo_regis=='NOANU'){$nombre='NO ANULADOS'; $criterio_est="(pre006.anulado='N') And ";}  
  if($tipo_regis=='AJU'){$nombre='AJUSTADOS';  $criterio_est="(pre036.ajustado<>0) And ";}
  if($tipo_regis=='NANU'){$nombre='NI ANULADOS,NI AJUSTADOS'; $criterio_est="(pre006.anulado='N') And (pre036.ajustado=0) And ";}
  $criterio1="Fecha Desde : ".$fecha_d."   "."Hasta : ".$fecha_h; 
  $criterio2=$nombre;
  $criterio3="Fuente de Financiamiento : ".$cod_fuente_d."    ".$cod_fuente_h;    
  $criterio="(cod_presup>='$cod_presupd' and cod_presup<='$cod_presuph') And (tipo_compromiso>='$doc_comp_d' and tipo_compromiso<='$doc_comp_h') And (referencia_comp>='$referencia_d' and referencia_comp<='$referencia_h') And (fecha_doc>='$cfecha_d' and fecha_doc<='$cfecha_h') And (nro_documento>='$nro_doc_d' and nro_documento<='$nro_doc_h') And (fuente_financ>='$cod_fuente_d' and fuente_financ<='$cod_fuente_h') And (ced_rif>='$cedula_d' and ced_rif<='$cedula_h')";
  $criteriop="(tipo_compromiso>='$doc_comp_d' and tipo_compromiso<='$doc_comp_h') And (referencia_comp>='$referencia_d' and referencia_comp<='$referencia_h') And (fecha_doc>='$cfecha_d' and fecha_doc<='$cfecha_h') And (nro_documento>='$nro_doc_d' and nro_documento<='$nro_doc_h') And (fuente_financ>='$cod_fuente_d' and fuente_financ<='$cod_fuente_h') And (ced_rif>='$cedula_d' and ced_rif<='$cedula_h')";
  $criterio4=$criterio_est."(pre036.cod_presup>='$cod_presupd' and pre036.cod_presup<='$cod_presuph') And (pre006.tipo_compromiso>='$doc_comp_d' and pre006.tipo_compromiso<='$doc_comp_h') And (pre006.referencia_comp>='$referencia_d' and pre006.referencia_comp<='$referencia_h') And (pre006.nro_documento>='$nro_doc_d' and pre006.nro_documento<='$nro_doc_h') And (pre006.Fecha_Compromiso>='$cfecha_d' and pre006.Fecha_Compromiso<='$cfecha_h') And (pre036.fuente_financ>='$cod_fuente_d' and pre036.fuente_financ<='$cod_fuente_h') And (pre006.ced_rif>='$cedula_d' and pre006.ced_rif<='$cedula_h')";
  $criterio4=$criterio_est." (pre006.tipo_compromiso>='$doc_comp_d' and pre006.tipo_compromiso<='$doc_comp_h') and (pre006.cod_tipo_comp>='$tipo_comp_d' and pre006.cod_tipo_comp<='$tipo_comp_h') And (pre006.referencia_comp>='$referencia_d' and pre006.referencia_comp<='$referencia_h') And (pre006.nro_documento>='$nro_doc_d' and pre006.nro_documento<='$nro_doc_h') And (pre006.Fecha_Compromiso>='$cfecha_d' and pre006.Fecha_Compromiso<='$cfecha_h') And (pre006.ced_rif>='$cedula_d' and pre006.ced_rif<='$cedula_h')";
   
  $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presupd,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
  $pos=strrpos($cod_presupd,"?"); if($pos===false){$en_d=0;}else{$en_d=1;} $pos=strrpos($cod_presuph,"?"); if($pos===false){$en_h=0;}else{$en_h=1;}   
  if(($en_d==1)or($en_h==1)){$codigo_d=str_replace("?","0",$cod_presupd); $long_d=strlen($codigo_d); $codigo_h=str_replace("?","9",$cod_presuph); $long_h=strlen($codigo_h);
    if(($long_d=$long_u)and ($long_h=$long_u)){ $criterio=""; 
  	   for ($i=0; $i<10; $i++) { $m=$mcontrol[$i]; if($i==0){$a=0;}else{$a=$mcontrol[$i-1];} 
		 if ($m<>0){if($i==0){ $len_nivel=$m; $criterio=""; }else{ $mpos=1+$a;  $len_nivel=($m-$a-1); $criterio=$criterio." and "; }
			$cod_d=substr($codigo_d,$mpos,$len_nivel); $cod_h=substr($codigo_h,$mpos,$len_nivel);$mpp=$mpos+1;
			$criterio=$criterio."substring(pre036.cod_presup,".$mpp.",".$len_nivel.")>='".$cod_d."' and "; $criterio=$criterio."substring(pre036.cod_presup,".$mpp.",".$len_nivel.")<='".$cod_h."' ";  }
	   } $criterio=$criterio."and  pre036.fuente_financ>='".$cod_fuente_d."' and pre036.fuente_financ<='".$cod_fuente_h."'";
    }else{$criterio="pre036.cod_presup>='".$codigo_d."' and pre036.cod_presup<='".$codigo_h."' and  pre036.fuente_financ>='".$cod_fuente_d."' and pre036.fuente_financ<='".$cod_fuente_h."'";}
  }else{$criterio="pre036.cod_presup>='".$cod_presupd."' and pre036.cod_presup<='".$cod_presuph."' and  pre036.fuente_financ>='".$cod_fuente_d."' and pre036.fuente_financ<='".$cod_fuente_h."'";}
  $criterio4= $criterio4." and (".$criterio.")";
  $criterio4=$criterio4." and (pre036.ref_imput_presu>='$ref_imput_presu_d' and pre036.ref_imput_presu<='$ref_imput_presu_h')";
  $criteriop=$criteriop." and (ref_imput_presu>='$ref_imput_presu_d' and ref_imput_presu<='$ref_imput_presu_h')";
 $StrSQL = "DELETE FROM pre021 Where (tipo_registro='C') And (Nombre_Usuario='".$cod_mov."')";$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 
if($cfecha_h==$Fec_Fin_Ejer){$StrSQL= "INSERT INTO pre021 SELECT '$cod_mov' as Nombre_Usuario,'C' as tipo_registro,pre006.referencia_comp,pre006.tipo_compromiso,pre002.Nombre_Abrev_Comp,pre002.Nombre_Tipo_Comp,'00000000' as Referencia_Caus,pre006.cod_comp as Tipo_Causado,'' as Nombre_Abrev_Caus, '' as Nombre_Tipo_Caus,'00000000' as Referencia_Pago,'0000' as Tipo_Pago,'' as Nombre_Abrev_Pago,'' as Nombre_Tipo_Pago, pre036.Cod_Presup,pre036.Fuente_Financ,pre001.Denominacion,
pre006.fecha_compromiso as fecha_doc,pre006.Ref_AEP,pre006.Num_Proyecto, pre006.Fecha_AEP,pre006.Tipo_Documento,pre006.Nro_Documento,pre006.Anulado,pre006.Fecha_Anu AS Fecha_Anulado, pre006.Ced_Rif,
pre099.Nombre as Nombre_Benef,pre036.Monto,pre036.Monto as Comprometido,pre036.Causado as Causado, pre036.Pagado as Pagado,pre036.Ajustado as Ajustado,pre006.Func_Inv,
pre036.Tipo_Imput_Presu,pre036.Ref_Imput_Presu, pre036.Monto_Credito,pre006.inf_usuario,pre006.Descripcion_Comp as Descripcion_Doc FROM pre001,pre002,pre006, pre036, pre099 
WHERE pre001.Cod_Presup = pre036.Cod_Presup AND pre036.Fuente_Financ=pre001.cod_fuente AND pre002.tipo_compromiso = pre006.tipo_compromiso AND pre006.tipo_compromiso = pre036.tipo_compromiso AND 
pre006.referencia_comp=pre036.referencia_comp and pre006.fecha_compromiso=pre036.fecha_compromiso AND pre006.Ced_Rif = pre099.Ced_Rif and ".$criterio4; 

}else{$StrSQL= "INSERT INTO pre021 SELECT '$cod_mov' as Nombre_Usuario,'C' as tipo_registro,pre006.referencia_comp,pre006.tipo_compromiso,pre002.Nombre_Abrev_Comp,pre002.Nombre_Tipo_Comp,'00000000' as Referencia_Caus,pre006.cod_comp as Tipo_Causado,'' as Nombre_Abrev_Caus, '' as Nombre_Tipo_Caus,'00000000' as Referencia_Pago,'0000' as Tipo_Pago,'' as Nombre_Abrev_Pago,'' as Nombre_Tipo_Pago, pre036.Cod_Presup,pre036.Fuente_Financ,pre001.Denominacion,
pre006.fecha_compromiso as fecha_doc,pre006.Ref_AEP,pre006.Num_Proyecto, pre006.Fecha_AEP,pre006.Tipo_Documento,pre006.Nro_Documento,pre006.Anulado,pre006.Fecha_Anu AS Fecha_Anulado, pre006.Ced_Rif,
pre099.Nombre as Nombre_Benef,pre036.Monto,pre036.Monto as Comprometido,0 as Causado, 0 as Pagado,0 as Ajustado,pre006.Func_Inv,
pre036.Tipo_Imput_Presu,pre036.Ref_Imput_Presu, pre036.Monto_Credito,pre006.inf_usuario,pre006.Descripcion_Comp as Descripcion_Doc FROM pre001,pre002,pre006, pre036, pre099 
WHERE pre001.Cod_Presup = pre036.Cod_Presup AND pre036.Fuente_Financ=pre001.cod_fuente AND pre002.tipo_compromiso = pre006.tipo_compromiso AND pre006.tipo_compromiso = pre036.tipo_compromiso AND 
pre006.referencia_comp = pre036.referencia_comp and pre006.fecha_compromiso=pre036.fecha_compromiso AND pre006.Ced_Rif = pre099.Ced_Rif and ".$criterio4; 

$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
$StrSQL="SELECT ACT_COMP_PRE021('P','".$cod_mov."','C','$referencia_d','$referencia_h','$doc_comp_d','$doc_comp_h','$cfecha_d','$cfecha_h')";
} 
$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
$cant_orden=0;
   $sql="SELECT count(distinct referencia_comp) as cant_orden FROM pre021 WHERE ".$criteriop." and (tipo_registro='C') And (Nombre_Usuario='".$cod_mov."')";
   $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$cant_orden=$registro["cant_orden"];}
   	
	$sSQL = "SELECT nombre_usuario, tipo_registro, referencia_comp, tipo_compromiso, nombre_abrev_comp, nombre_tipo_comp, referencia_caus, tipo_causado, nombre_tipo_caus, nombre_abrev_caus, referencia_pago, tipo_pago, nombre_tipo_pago, nombre_abrev_pago, cod_presup, fuente_financ, denominacion,
       substr(denominacion,1,45) as denom_cort, fecha_doc, ref_aep, num_proyecto, fecha_aep, tipo_documento,nro_documento, anulado, fecha_anulado, ced_rif, nombre_benef, 
       monto, comprometido, causado, pagado, ajustado, (ajustado*-1) as ajuste, func_inv, tipo_imput_presu, ref_imput_presu, monto_credito, inf_usuario, descripcion_doc, to_char(fecha_doc,'DD/MM/YYYY') as fechad FROM pre021 WHERE ".$criteriop." and (tipo_registro='C') And (Nombre_Usuario='".$cod_mov."') ORDER BY pre021.ced_rif,pre021.fecha_doc, pre021.referencia_comp, pre021.tipo_compromiso,pre021.cod_presup,pre021.fuente_financ";

	 if($tipo_rep=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");
        $oRpt = new PHPReportMaker();
		if($det_rep=="SI"){$oRpt->setXML("Rpt_compromisos_benef.xml");}else{$oRpt->setXML("Rpt_compromisos_benef_no.xml");}
        $oRpt->setUser("$user");
        $oRpt->setPassword("$password");
        $oRpt->setConnection("$host");
        $oRpt->setDatabaseInterface("postgresql");
		$oRpt->setSQL($sSQL);
        $oRpt->setDatabase("$dbname");
		$oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"criterio3"=>$criterio3,"cant_orden"=>$cant_orden));          
        $oRpt->run();
    }


    if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $fecha_doc_grupo=""; $referencia_comp_grupo="00000000"; $tipo_compromiso_grupo="0000"; 
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $criterio2; global $fecha_doc_grupo; global $referencia_comp_grupo; global $tipo_compromiso_grupo; global $registro; global $tam_logo;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(150,10,'COMPROMISOS POR BENEFICIARIOS',1,0,'C');
				$this->Ln(15);
				$this->SetFont('Arial','B',8);
				$this->Cell(100,10,$criterio1,0,0,'L');
				$this->Cell(160,10,$criterio2,0,0,'R');				
				$this->Ln(10);
			    $this->SetFont('Arial','B',6);
				$this->Cell(16,5,'REFERENCIA',1,0);						
				$this->Cell(14,5,'TIPO',1,0,'L');
				$this->Cell(4,5,'ST',1,0,'C');	
				$this->Cell(14,5,'FECHA',1,0,'L');
				$this->Cell(21,5,'NRO DOCUMENTO',1,0,'L');
				$this->Cell(191,5,'DESCRIPCION COMPROMISO',1,1,'L');
				//$this->Cell(15,5,'CEDULA/RIF',1,0,'L');
				//$this->Cell(65,5,'NOMBRE BENEFICIARIO',1,1,'L');
				$this->Cell(40,5,'CODIGO PRESUPUESTARIO',1,0,'L');						
				$this->Cell(120,5,'DENOMINACION CODIGO PRESUPUESTARIO',1,0,'L');
				$this->Cell(20,5,'COMPROMETIDO',1,0,'R');	
				$this->Cell(19,5,'AJUSTADO',1,0,'R');
				$this->Cell(22,5,'MONTO AJUSTADO',1,0,'R');
				$this->Cell(19,5,'CAUSADO',1,0,'R');
				$this->Cell(20,5,'PAGADO',1,1,'R');
		    } 
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-10);
				$this->SetFont('Arial','I',5);
				$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
				
				// INI NMDB 30-04-2018
		        // $this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		        $this->Cell(130,5,' ',0,0,'R');
		        // FIN NMDB 30-04-2018
			}
		  }		  
		  $pdf=new PDF('L', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $total_monto=0; $total_ajuste=0; $total_monto_ajustado=0; $total_causado=0; $total_pagado=0; $sub_total_monto=0; $sub_total_ajuste=0; $sub_total_monto_ajustado=0; $sub_total_causado=0; $sub_total_pagado=0; $cantidad_ordenes=0; $prev_fecha_doc=""; $prev_referencia_comp="";  $prev_tipo_compromiso=""; 
		  $prev_ced_rif=""; $rtotal_monto=0; $rtotal_ajuste=0; $rtotal_monto_ajustado=0; $rtotal_causado=0; $rtotal_pagado=0; $rcantidad=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $fecha_doc=$registro["fecha_doc"]; $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"]; $nombre_abrev_comp=$registro["nombre_abrev_comp"]; $anulado=$registro["anulado"]; 
			$nro_documento=$registro["nro_documento"]; $ced_rif=$registro["ced_rif"]; $descripcion_doc=$registro["descripcion_doc"]; $nombre_benef=$registro["nombre_benef"]; $fecha_doc=formato_ddmmaaaa($fecha_doc);
			if($php_os=="WINNT"){$descripcion_doc=$registro["descripcion_doc"]; }else{$descripcion_doc=utf8_decode($descripcion_doc);$nombre_benef=utf8_decode($nombre_benef);}
			$fecha_doc_grupo=$fecha_doc; $referencia_comp_grupo=$referencia_comp; $tipo_compromiso_grupo=$tipo_compromiso; $nombre_abrev_comp_grupo=$nombre_abrev_comp; 			         $anulado_grupo=$anulado;$nro_documento_grupo=$nro_documento;$descripcion_doc_grupo=$descripcion_doc; $ced_rif_grupo=$ced_rif;$nombre_benef_grupo=$nombre_benef;

			if(($prev_fecha_doc<>$fecha_doc_grupo)or($prev_tipo_compromiso<>$tipo_compromiso_grupo)or($prev_referencia_comp<>$referencia_comp_grupo)){  $cantidad_ordenes=$cantidad_ordenes+1;
			     $pdf->SetFont('Arial','B',7); 
			     if(($sub_total_monto<>0)or($sub_total_ajuste>0)or($sub_total_monto_ajustado>0)or($sub_total_causado>0)or($sub_total_pagado>0)){ 
				    $sub_total_monto=formato_monto($sub_total_monto); $sub_total_ajuste=formato_monto($sub_total_ajuste);
					$sub_total_ajustado=formato_monto($sub_total_ajustado); $sub_total_monto_ajustado=formato_monto($sub_total_monto_ajustado); $sub_total_causado=formato_monto($sub_total_causado);$sub_total_pagado=formato_monto($sub_total_pagado);						    
					$pdf->Cell(160,2,'',0,0);
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,1,'R');
					$pdf->Cell(160,2,'',0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto,0,0,'R');
					$pdf->Cell(20,3,$sub_total_ajuste,0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto_ajustado,0,0,'R');
					$pdf->Cell(20,3,$sub_total_causado,0,0,'R');
					$pdf->Cell(20,3,$sub_total_pagado,0,1,'R');
                    $pdf->Ln(4);
				 }		
				 
				 if($prev_ced_rif<>$ced_rif){
				    if($rcantidad>0){ 
					    $rtotal_monto=formato_monto($rtotal_monto); $rtotal_ajuste=formato_monto($rtotal_ajuste);
						$rtotal_ajustado=formato_monto($rtotal_ajustado); $rtotal_monto_ajustado=formato_monto($rtotal_monto_ajustado); $rtotal_causado=formato_monto($rtotal_causado);$rtotal_pagado=formato_monto($rtotal_pagado);						    
						$pdf->Cell(160,2,'',0,0);
						$pdf->Cell(20,2,'=============',0,0,'R');
						$pdf->Cell(20,2,'=============',0,0,'R');
						$pdf->Cell(20,2,'=============',0,0,'R');
						$pdf->Cell(20,2,'=============',0,0,'R');
						$pdf->Cell(20,2,'=============',0,1,'R');
						$pdf->Cell(100,3,'Cantidad Compromisos: '.$rcantidad,0,0,'L');
						$pdf->Cell(60,3,'TOTAL BENEFICIARIO :',0,0,'R');
						$pdf->Cell(20,3,$rtotal_monto,0,0,'R');
						$pdf->Cell(20,3,$rtotal_ajuste,0,0,'R');
						$pdf->Cell(20,3,$rtotal_monto_ajustado,0,0,'R');
						$pdf->Cell(20,3,$rtotal_causado,0,0,'R');
						$pdf->Cell(20,3,$rtotal_pagado,0,1,'R');
						$pdf->Ln(7);}
				    $nombre_temp=substr($nombre_benef_grupo,0,70);
				    $pdf->Cell(40,4,"Cedula/Rif: ".$ced_rif_grupo,0,0,'L'); 
					$pdf->Cell(220,4,"Nombre: ".$nombre_temp,0,1,'L');
					$prev_ced_rif=$ced_rif_grupo; $rtotal_monto=0; $rtotal_ajuste=0; $rtotal_monto_ajustado=0; $rtotal_causado=0; $rtotal_pagado=0; $rcantidad=0;
				 }
                 $pdf->SetFont('Arial','',7); 				 
				 $pdf->Cell(15,3,$referencia_comp_grupo,0,0,'L'); 
				 $pdf->Cell(15,3,$tipo_compromiso_grupo."  ".$nombre_abrev_comp_grupo,0,0,'L');
				 $pdf->Cell(3,3,$anulado_grupo,0,0,'C');
				 $pdf->Cell(14,3,$fecha_doc_grupo,0,0,'L');
				 $pdf->Cell(22,3,substr($nro_documento_grupo,0,14),0,0,'L');
		   	     $x=$pdf->GetX();   $y=$pdf->GetY(); $n=110; $w=65;  $n=190;
		        
				 $nombre_temp=$nombre_benef_grupo;
				 if ($y>=179) { $nombre_temp=substr($nombre_temp,0,35);}
				  //$pdf->SetXY($x+$n,$y);
			   	 //$pdf->Cell(16,3,$ced_rif_grupo,0,0,'L');
		         //$pdf->MultiCell($w,3,$nombre_temp,0,1);				 
		   	   	 $pdf->SetXY($x,$y);
		         $pdf->MultiCell($n,3,$descripcion_doc_grupo,0);  
				 $pdf->Ln(2);
				 $prev_fecha_doc=$fecha_doc_grupo; $prev_referencia_comp=$referencia_comp_grupo; $prev_tipo_compromiso=$tipo_compromiso_grupo; $sub_total_monto=0; $sub_total_ajuste=0; $sub_total_monto_ajustado=0; $sub_total_causado=0; $sub_total_pagado=0;
			     $rcantidad=$rcantidad+1;
			   } 

		       $fecha_doc=$registro["fecha_doc"]; $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"]; 
			   $nombre_abrev_comp=$registro["nombre_abrev_comp"]; $anulado=$registro["anulado"]; $nro_documento=$registro["nro_documento"]; $ced_rif=$registro["ced_rif"];  
			   $descripcion_doc=$registro["descripcion_doc"];$nombre_benef=$registro["nombre_benef"]; $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; 	 
			   $denominacion=$registro["denominacion"]; $monto=$registro["monto"]; $ajuste=$registro["ajuste"]; $ajustado=$registro["ajustado"]; $causado=$registro["causado"];		 $pagado=$registro["pagado"]; 
			   $total_monto=$total_monto+$monto; $total_ajuste=$total_ajuste+$ajuste; $total_monto_ajustado=$total_monto_ajustado+$monto-$ajustado; $total_causado=$total_causado+$causado; $total_pagado=$total_pagado+$pagado; 
			   $sub_total_monto=$sub_total_monto+$monto; $sub_total_ajuste=$sub_total_ajuste+$ajuste; $sub_total_monto_ajustado=$sub_total_monto_ajustado+$monto-$ajustado; $sub_total_causado=$sub_total_causado+$causado; $sub_total_pagado=$sub_total_pagado+$pagado;
		       $rtotal_monto=$rtotal_monto+$monto; $rtotal_ajuste=$rtotal_ajuste+$ajuste; $rtotal_monto_ajustado=$rtotal_monto_ajustado+$monto-$ajustado; $rtotal_causado=$rtotal_causado+$causado; $rtotal_pagado=$rtotal_pagado+$pagado;
		       $monto_ajus=$monto-$ajustado; $monto_ajus=formato_monto($monto_ajus);
			   $monto=formato_monto($monto); $ajuste=formato_monto($ajuste); $ajustado=formato_monto($ajustado); $causado=formato_monto($causado);
			   $pagado=formato_monto($pagado); $fecha_doc=formato_ddmmaaaa($fecha_doc);	
			   if($php_os=="WINNT"){$descripcion_doc=$registro["descripcion_doc"]; }else{$descripcion_doc=utf8_decode($descripcion_doc);$nombre_benef=utf8_decode($nombre_benef);$denominacion=utf8_decode($denominacion);}

			   if($det_rep=="SI"){ 
			   $pdf->Cell(40,3,$cod_presup."  ".$fuente_financ,0,0,'L'); 			   
		   	   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=120;
		       $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,3,$monto,0,0,'R');
			   $pdf->Cell(20,3,$ajuste,0,0,'R');
			   $pdf->Cell(20,3,$monto_ajus,0,0,'R');
			   $pdf->Cell(20,3,$causado,0,0,'R');
               $pdf->Cell(20,3,$pagado,0,1,'R');  
		   	   $pdf->SetXY($x+1,$y);
		       $pdf->MultiCell($n-1,3,$denominacion,0);  }
 	   
				
			} $total_monto=formato_monto($total_monto); $total_ajuste=formato_monto($total_ajuste); $total_monto_ajustado=formato_monto($total_monto_ajustado); $tota_monto_ajustado=formato_monto($total_monto_ajustado); $total_causado=formato_monto($total_causado);$total_pagado=formato_monto($total_pagado);
			$pdf->SetFont('Arial','B',7);
			if(($sub_total_monto<>0)or($sub_total_ajuste>0)or($sub_total_monto_ajustado>0)or($sub_total_causado>0)or($sub_total_pagado>0)){ $sub_total_monto=formato_monto($sub_total_monto); $sub_total_ajuste=formato_monto($sub_total_ajuste); $sub_total_ajustado=formato_monto($sub_total_ajustado); $sub_total_monto_ajustado=formato_monto($sub_total_monto_ajustado); $sub_total_causado=formato_monto($sub_total_causado);$sub_total_pagado=formato_monto($sub_total_pagado);						    
				$pdf->Cell(160,2,'',0,0);
				$pdf->Cell(20,2,'---------------------',0,0,'R');
				$pdf->Cell(20,2,'---------------------',0,0,'R');
				$pdf->Cell(20,2,'---------------------',0,0,'R');
				$pdf->Cell(20,2,'---------------------',0,0,'R');
				$pdf->Cell(20,2,'---------------------',0,1,'R');
				$pdf->Cell(160,2,'',0,0,'R');
				$pdf->Cell(20,3,$sub_total_monto,0,0,'R');
				$pdf->Cell(20,3,$sub_total_ajuste,0,0,'R');
				$pdf->Cell(20,3,$sub_total_monto_ajustado,0,0,'R');
				$pdf->Cell(20,3,$sub_total_causado,0,0,'R');
				$pdf->Cell(20,3,$sub_total_pagado,0,1,'R');
				$pdf->Ln(5);}
			$rtotal_monto=formato_monto($rtotal_monto); $rtotal_ajuste=formato_monto($rtotal_ajuste);
			$rtotal_ajustado=formato_monto($rtotal_ajustado); $rtotal_monto_ajustado=formato_monto($rtotal_monto_ajustado); $rtotal_causado=formato_monto($rtotal_causado);$rtotal_pagado=formato_monto($rtotal_pagado);						    
			$pdf->Cell(160,2,'',0,0);
			$pdf->Cell(20,2,'=============',0,0,'R');
			$pdf->Cell(20,2,'=============',0,0,'R');
			$pdf->Cell(20,2,'=============',0,0,'R');
			$pdf->Cell(20,2,'=============',0,0,'R');
			$pdf->Cell(20,2,'=============',0,1,'R');
			$pdf->Cell(100,3,'Cantidad Compromisos: '.$rcantidad,0,0,'L');
			$pdf->Cell(60,3,'TOTAL BENEFICIARIO :',0,0,'R');
			$pdf->Cell(20,3,$rtotal_monto,0,0,'R');
			$pdf->Cell(20,3,$rtotal_ajuste,0,0,'R');
			$pdf->Cell(20,3,$rtotal_monto_ajustado,0,0,'R');
			$pdf->Cell(20,3,$rtotal_causado,0,0,'R');
			$pdf->Cell(20,3,$rtotal_pagado,0,1,'R');
			$pdf->Ln(7);	
			$pdf->Cell(160,2,'',0,0);
			$pdf->Cell(20,2,'=============',0,0,'R');
			$pdf->Cell(20,2,'=============',0,0,'R');
			$pdf->Cell(20,2,'=============',0,0,'R');
			$pdf->Cell(20,2,'=============',0,0,'R');
			$pdf->Cell(20,2,'=============',0,1,'R');
			$pdf->Cell(100,5,'Cantidad Compromisos: '.$cantidad_ordenes,0,0,'L');
		    $pdf->Cell(60,5,'TOTAL GENERAL ',0,0,'R');
			$pdf->Cell(20,5,$total_monto,0,0,'R');
			$pdf->Cell(20,5,$total_ajuste,0,0,'R');
			$pdf->Cell(20,5,$total_monto_ajustado,0,0,'R');
			$pdf->Cell(20,5,$total_causado,0,0,'R');
			$pdf->Cell(20,5,$total_pagado,0,1,'R');
			$pdf->Output();   
	}
	
	if($tipo_rep=="EXCEL"){	
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Rpt_compromisos_benef.xls"); 
        ?>
		
		   <table border="0" cellspacing="0" cellpadding="0" align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
			        <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>COMPROMISOS POR BENEFICIARIO</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1?></strong></font></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio2?></strong></font></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Referencia</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>St</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Nr. Documento</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Descripcion Compromiso</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			 </tr>
			 <tr height="20">
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Codigo Presupuestario</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Denominacion Codigo Presupuestario</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>Comprometido</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>Ajustado</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>Monto Ajustado</strong></td>
			   <td width="400" align="right" bgcolor="#99CCFF"><strong>Causado</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>Pagado</strong></td>
			 </tr>
		  <?	$i=0; $total_monto=0; $total_ajuste=0; $total_monto_ajustado=0; $total_causado=0; $total_pagado=0; $sub_total_monto=0; $sub_total_ajuste=0; $sub_total_monto_ajustado=0; $sub_total_causado=0; $sub_total_pagado=0; $cantidad_ordenes=0; $prev_fecha_doc=""; $prev_referencia_comp="";  $prev_tipo_compromiso="";  $res=pg_query($sSQL);
		  $prev_ced_rif=""; $rtotal_monto=0; $rtotal_ajuste=0; $rtotal_monto_ajustado=0; $rtotal_causado=0; $rtotal_pagado=0; $rcantidad=0;
		  
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $fecha_doc=$registro["fecha_doc"]; $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"]; 
			$nombre_abrev_comp=$registro["nombre_abrev_comp"]; $anulado=$registro["anulado"]; $nro_documento=$registro["nro_documento"]; $ced_rif=$registro["ced_rif"];   		   				$descripcion_doc=$registro["descripcion_doc"]; $nombre_benef=$registro["nombre_benef"]; $fecha_doc=formato_ddmmaaaa($fecha_doc); 
		         $fecha_doc_grupo=$fecha_doc; $referencia_comp_grupo=$referencia_comp; $tipo_compromiso_grupo=$tipo_compromiso; $nombre_abrev_comp_grupo=$nombre_abrev_comp; 			         $anulado_grupo=$anulado;$nro_documento_grupo=$nro_documento;$descripcion_doc_grupo=$descripcion_doc; $ced_rif_grupo=$ced_rif;$nombre_benef_grupo=$nombre_benef;

			   if(($prev_fecha_doc<>$fecha_doc_grupo)or($prev_tipo_compromiso<>$tipo_compromiso_grupo)or($prev_referencia_comp<>$referencia_comp_grupo)){  $cantidad_ordenes=$cantidad_ordenes+1;
			     if(($sub_total_monto<>0)or($sub_total_ajuste>0)or($sub_total_monto_ajustado>0)or($sub_total_causado>0)or($sub_total_pagado>0)){ $sub_total_monto=formato_monto($sub_total_monto); $sub_total_ajuste=formato_monto($sub_total_ajuste); $sub_total_ajustado=formato_monto($sub_total_ajustado); $sub_total_monto_ajustado=formato_monto($sub_total_monto_ajustado); $sub_total_causado=formato_monto($sub_total_causado);$sub_total_pagado=formato_monto($sub_total_pagado);	
			     ?>	 				 
				   <tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="left"></td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="400" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			        </tr>	
				    <tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="400" align="left"></td>
			           <td width="100" align="right"><? echo $sub_total_monto; ?></td>
			           <td width="100" align="right"><? echo $sub_total_ajuste; ?></td>
			           <td width="100" align="right"><? echo $sub_total_monto_ajustado; ?></td>
			           <td width="400" align="right"><? echo $sub_total_causado; ?></td>
			           <td width="100" align="right"><? echo $sub_total_pagado; ?></td>
			        </tr>		
			        <tr>
				       <td width="90" align="left"></td>
			        </tr>	
                  <?}
				  
				  if($prev_ced_rif<>$ced_rif){
				    if($rcantidad>0){ 
					    $rtotal_monto=formato_monto($rtotal_monto); $rtotal_ajuste=formato_monto($rtotal_ajuste);
						$rtotal_ajustado=formato_monto($rtotal_ajustado); $rtotal_monto_ajustado=formato_monto($rtotal_monto_ajustado); $rtotal_causado=formato_monto($rtotal_causado);$rtotal_pagado=formato_monto($rtotal_pagado);						    
						?>	 				 
						   <tr>
							   <td width="100" align="left"></td>
							   <td width="400" align="left"></td>
							   <td width="100" align="right">=============</td>
							   <td width="100" align="right">=============</td>
							   <td width="100" align="right">=============</td>
							   <td width="400" align="right">=============</td>
							   <td width="100" align="right">=============</td>
							</tr>	
							<tr>
							   <td width="100" align="left"></td>
							   <td width="400" align="left">TOTAL BENEFICIARIO :</td>
							   <td width="100" align="right"><? echo $rtotal_monto; ?></td>
							   <td width="100" align="right"><? echo $rtotal_ajuste; ?></td>
							   <td width="100" align="right"><? echo $rtotal_monto_ajustado; ?></td>
							   <td width="400" align="right"><? echo $rtotal_causado; ?></td>
							   <td width="100" align="right"><? echo $rtotal_pagado; ?></td>
							</tr>		
							<tr>
							   <td width="100" align="left"></td>
							</tr>	
						<?}	
						?>
							<tr>
							   <td width="100" align="left">Beneficiario:</td>							   
							   <td width="400" align="left"><? echo $ced_rif_grupo." ".$nombre_benef_grupo; ?></td>
							</tr>	
                        <?	
					$prev_ced_rif=$ced_rif_grupo; $rtotal_monto=0; $rtotal_ajuste=0; $rtotal_monto_ajustado=0; $rtotal_causado=0; $rtotal_pagado=0; $rcantidad=0;
				 }
			      ?>	   
			      <tr>
				   <td width="100" align="left"><? echo $referencia_comp_grupo; ?></td>
				   <td width="400" align="left"><? echo $tipo_compromiso_grupo."  ".$nombre_abrev_comp_grupo; ?></td>
				   <td width="100" align="left"><? echo $anulado_grupo; ?></td>
				   <td width="100" align="left"><? echo $fecha_doc_grupo; ?></td>
				   <td width="100" align="left"><? echo $nro_documento_grupo; ?></td>
				   <td width="400" align="left"><? echo $descripcion_doc_grupo; ?></td>
				   <td width="100" align="left"><? echo $ced_rif_grupo; ?></td>
				   <td width="400" align="left"><? echo $nombre_benef_grupo; ?></td>
			      </tr>
			      <tr>
				  <td width="90" align="left"></td>
			      </tr>	
			     <? 					 
			    $prev_fecha_doc=$fecha_doc_grupo; $prev_referencia_comp=$referencia_comp_grupo; $prev_tipo_compromiso=$tipo_compromiso_grupo; $sub_total_monto=0; $sub_total_ajuste=0; $sub_total_monto_ajustado=0; $sub_total_causado=0; $sub_total_pagado=0; $rcantidad=$rcantidad+1;}
               $fecha_doc=$registro["fecha_doc"]; $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"]; 
			   $nombre_abrev_comp=$registro["nombre_abrev_comp"]; $anulado=$registro["anulado"]; $nro_documento=$registro["nro_documento"]; $ced_rif=$registro["ced_rif"];  
			   $descripcion_doc=$registro["descripcion_doc"];$nombre_benef=$registro["nombre_benef"]; $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; 				  
			   $denominacion=$registro["denominacion"]; $monto=$registro["monto"]; $ajuste=$registro["ajuste"]; $ajustado=$registro["ajustado"]; $causado=$registro["causado"];   $pagado=$registro["pagado"]; 
			   $total_monto=$total_monto+$monto; $total_ajuste=$total_ajuste+$ajuste; $total_monto_ajustado=$total_monto_ajustado+$monto-$ajustado; $total_causado=$total_causado+$causado; 		   $total_pagado=$total_pagado+$pagado; $sub_total_monto=$sub_total_monto+$monto; $sub_total_ajuste=$sub_total_ajuste+$ajuste; 
			   $sub_total_monto_ajustado=$sub_total_monto_ajustado+$monto-$ajustado; $sub_total_causado=$sub_total_causado+$causado; $sub_total_pagado=$sub_total_pagado+$pagado;
		       $monto_ajus=$monto-$ajustado; $monto_ajus=formato_monto($monto_ajus);    $monto=formato_monto($monto); $ajuste=formato_monto($ajuste); $ajustado=formato_monto($ajustado); $causado=formato_monto($causado);
			   $pagado=formato_monto($pagado); $fecha_doc=formato_ddmmaaaa($fecha_doc);	   
			   $descripcion_doc=conv_cadenas($descripcion_doc,0);	$nombre_benef=conv_cadenas($nombre_benef,0);   $denominacion=conv_cadenas($denominacion,0); 
			   ?>	   
				<tr>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_presup."   ".$fuente_financ; ?></td>
				   <td width="400" align="justify"><? echo $denominacion; ?></td>
				   <td width="100" align="right"><? echo $monto; ?></td>
				   <td width="100" align="right"><? echo $ajuste; ?></td>
				   <td width="100" align="right"><? echo $monto_ajus; ?></td>
				   <td width="400" align="right"><? echo $causado; ?></td>
				   <td width="100" align="right"><? echo $pagado; ?></td>
				 </tr>
			   <? 	

		  }$total_monto=formato_monto($total_monto); $total_ajuste=formato_monto($total_ajuste); $total_ajustado=formato_monto($total_ajustado); $tota_monto_ajustado=formato_monto($total_monto_ajustado); $total_causado=formato_monto($total_causado);$total_pagado=formato_monto($total_pagado);

		  if(($sub_total_monto<>0)or($sub_total_ajuste>0)or($sub_total_monto_ajustado>0)or($sub_total_causado>0)or($sub_total_pagado>0)){ $sub_total_monto=formato_monto($sub_total_monto); $sub_total_ajuste=formato_monto($sub_total_ajuste); $sub_total_ajustado=formato_monto($sub_total_ajustado); $sub_total_monto_ajustado=formato_monto($sub_total_monto_ajustado); $sub_total_causado=formato_monto($sub_total_causado);$sub_total_pagado=formato_monto($sub_total_pagado);	
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="left"></td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="400" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="400" align="left"></td>
			           <td width="100" align="right"><? echo $sub_total_monto; ?></td>
			           <td width="100" align="right"><? echo $sub_total_ajuste; ?></td>
			           <td width="100" align="right"><? echo $sub_total_monto_ajustado; ?></td>
			           <td width="400" align="right"><? echo $sub_total_causado; ?></td>
			           <td width="100" align="right"><? echo $sub_total_pagado; ?></td>
			        </tr>		
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="right">---------------</td>
			    <td width="100" align="right">---------------</td>
			    <td width="100" align="right">---------------</td>
			    <td width="400" align="right">---------------</td>
			    <td width="100" align="right">---------------</td>
			</tr>	
			<tr>
			    <td width="100" align="left">Cantidad Compromisos: <strong><? echo $cantidad_ordenes; ?></strong></td>
			    <td width="400" align="right"><strong>TOTAL GENERAL : </strong></td>
			    <td width="100" align="right"><strong><? echo $total_monto; ?></strong></td>
			    <td width="100" align="right"><strong><? echo $total_ajuste; ?></strong></td>
			    <td width="100" align="right"><strong><? echo $total_monto_ajustado; ?></strong></td>
			    <td width="400" align="right"><strong><? echo $total_causado; ?></strong></td>
			    <td width="100" align="right"><strong><? echo $total_pagado; ?></strong></td>
			</tr>	
		       <? 				  
		  ?></table><?  
    }
   $StrSQL = "DELETE FROM pre021 Where (tipo_registro='C') And (Nombre_Usuario='".$cod_mov."')";$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 
?>



