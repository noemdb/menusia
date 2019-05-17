<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$referencia_d=$_GET["referencia_d"];$referencia_h=$_GET["referencia_h"]; $fecha_d=$_GET["fecha_d"]; $fecha_h=$_GET["fecha_h"]; $agrupa_cat=$_GET["agrupa_cat"]; $agrupa_par=$_GET["agrupa_par"]; $agrupa_fuen=$_GET["agrupa_fuen"];
$cod_presup_d=$_GET["cod_presupd"];$cod_presup_h=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuented"];$cod_fuente_h=$_GET["cod_fuenteh"]; $tipo_modif=$_GET["tipo_modif"]; $tipo_rep=$_GET["tipo_rep"];
$date = date("d-m-Y");$hora = date("H:i:s a");$Sql=""; $cod_mov="pre009".$usuario_sia;
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;
if ($tipo_modif=='TODOS'){$nombre="";} $criterio_est="";
  if($tipo_modif=='CREDITOS ADICIONALES'){$nombre='CREDITOS ADICIONALES'; $criterio_est="(pre009.tipo_modif='1') And ";}
  if($tipo_modif=='RECTIFICACIONES'){$nombre='RECTIFICACIONES';  $criterio_est="(pre009.tipo_modif='2') And ";}
  if($tipo_modif=='INSUBSITENCIA'){$nombre='INSUBSITENCIA'; $criterio_est="(pre009.tipo_modif='3') And ";}
  if($tipo_modif=='REDUCCION DE INGRESOS'){$nombre='REDUCCION DE INGRESOS'; $criterio_est="(pre009.tipo_modif='4') And ";}
  if($tipo_modif=='TRASPASOS DE CREDITOS'){$nombre='TRASPASOS DE CREDITOS'; $criterio_est="(pre009.tipo_modif='5') And ";}  
$criterio=$criterio_est."(pre009.Referencia_Modif>='$referencia_d' and pre009.Referencia_Modif<='$referencia_h') And (pre009.Fecha_Modif>='$fecha_desde' and pre009.Fecha_Modif<='$fecha_hasta') And (pre039.cod_presup>='$cod_presupd' and pre039.cod_presup<='$cod_presuph') And (pre039.Fuente_Financ>='$cod_fuente_d' and pre039.Fuente_Financ<='$cod_fuente_h')";
$criterio1="Desde :".$fecha_d."        "."Hasta : ".$fecha_h;   $criterio2=$nombre;
$criterio3="Fuente de Financiamiento : ".$cod_fuente_d."    ".$cod_fuente_h; $criterio4="USUARIO: ".$usuario_sia;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}

     $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
         if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];} 
         $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;
		 $criterio=$criterio." and (substring(pre039.cod_presup from ".$ini." for 3)='401')"; 
		 
       $sSQL = "SELECT pre009.Referencia_Modif, pre009.Fecha_Modif, pre009.Fecha_Registro, pre009.Tipo_Modif, pre009.Descripcion_Modif, pre009.Anulado, pre009.Fecha_Anu, 
          pre039.Operacion, pre039.Grupo, pre039.cod_presup, pre039.Fuente_Financ, pre039.monto, (pre039.monto*-1) as monton, pre095.Des_Fuente_Financ, pre001.Denominacion,substr(pre039.cod_presup,1,".$c.") as cod_categoria,  to_char(pre009.Fecha_Modif,'DD/MM/YYYY') as fechad
          FROM pre001,pre009, pre039, pre095 WHERE (pre001.cod_presup=pre039.cod_presup) AND (pre001.Cod_Fuente=pre039.Fuente_Financ) AND 
          (pre039.Fuente_Financ=pre095.Cod_Fuente_Financ) AND (pre009.referencia_modif=pre039.referencia_modif) and (pre009.tipo_modif=pre039.tipo_modif) AND ".$criterio."
          ORDER BY pre009.Fecha_Modif, pre009.Referencia_Modif";
         
$StrSQL = "DELETE FROM pre021 Where (Tipo_Registro='M') And (nombre_usuario='".$cod_mov."')";
$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

$StrSQL= "INSERT INTO pre021 SELECT '$cod_mov' as nombre_usuario,'M' as Tipo_Registro,pre009.Referencia_Modif,pre009.Tipo_Modif,'','','00000000' as Referencia_Caus,'0000' as Tipo_Causado,'' as Nombre_Abrev_Caus, '' as Nombre_Tipo_Caus,'00000000' as Referencia_Pago,'0000' as Tipo_Pago,'' as Nombre_Abrev_Pago,'' as Nombre_Tipo_Pago, pre039.cod_presup,pre039.Fuente_Financ,pre001.Denominacion,
pre009.Fecha_Modif as Fecha_Doc,'' as Ref_AEP,pre039.Grupo, pre009.Fecha_Modif as Fecha_AEP,'','',pre009.Anulado, pre009.Fecha_Anu AS Fecha_Anulado, substr(pre039.cod_presup,1,".$c.") as ced_rif,
'' as Nombre_Benef,pre039.monto,(pre039.monto*-1) as Comprometido,0, 0,0,pre039.Operacion,
'P','',pre001.asignado,pre009.inf_usuario,pre009.Descripcion_Modif as Descripcion_Doc FROM pre001,pre009, pre039, pre095 WHERE (pre001.cod_presup=pre039.cod_presup) AND (pre001.Cod_Fuente=pre039.Fuente_Financ) AND 
(pre039.Fuente_Financ=pre095.Cod_Fuente_Financ) AND (pre009.referencia_modif=pre039.referencia_modif) and (pre009.tipo_modif=pre039.tipo_modif) AND ".$criterio;
$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

$StrSQL= "update pre021 set ajustado=monto WHERE ((tipo_compromiso='1')or(tipo_compromiso='3')or(tipo_compromiso='5')) and (func_inv='+') and (Tipo_Registro='M') And (nombre_usuario='".$cod_mov."') ";
$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 
$StrSQL= "update pre021 set ajustado=monto WHERE ((tipo_compromiso='2')or(tipo_compromiso='4')) and (func_inv='-') and (Tipo_Registro='M') And (nombre_usuario='".$cod_mov."') ";
$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

$ordenado="ORDER BY pre021.Fecha_Doc, pre021.Referencia_Comp, pre021.Tipo_Compromiso,pre021.cod_presup";
if($agrupa_cat=="SI"){ $ordenado="ORDER BY pre021.ced_rif,pre021.Fecha_Doc, pre021.Referencia_Comp, pre021.Tipo_Compromiso,pre021.cod_presup";
   $sSQL = "Select cod_presup,denominacion from pre001 WHERE cod_presup in (select distinct ced_rif from pre021 where (Tipo_Registro='M') and (nombre_usuario='$cod_mov'))";  $res=pg_query($sSQL);
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_presup"]; $denominacion=$registro["denominacion"]; 
     $sql="update pre021 set nombre_benef='$denominacion' where Tipo_Registro='M' and nombre_usuario='$cod_mov' and ced_rif='$cod_presup'";$resultado=pg_exec($conn,$sql); 
	 $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  }}

if($agrupa_par=="SI"){ $ordenado="ORDER BY pre021.ced_rif,pre021.cod_presup,pre021.fuente_financ,pre021.Fecha_Doc, pre021.Referencia_Comp, pre021.Tipo_Compromiso";
  $StrSQL= "update pre021 set causado=monto WHERE (func_inv='+') and (Tipo_Registro='M') And (nombre_usuario='".$cod_mov."') ";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 
  $StrSQL= "update pre021 set pagado=monto WHERE (func_inv='-') and (Tipo_Registro='M') And (nombre_usuario='".$cod_mov."') ";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

  $sSQL = "Select cod_presup,denominacion from pre001 WHERE cod_presup in (select distinct ced_rif from pre021 where (Tipo_Registro='M') and (nombre_usuario='$cod_mov'))";  $res=pg_query($sSQL);
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_presup"]; $denominacion=$registro["denominacion"]; 
     $sql="update pre021 set nombre_benef='$denominacion' where Tipo_Registro='M' and nombre_usuario='$cod_mov' and ced_rif='$cod_presup'";$resultado=pg_exec($conn,$sql); 
	 $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  }
  
  if($agrupa_fuen==="SI"){
  $ordenado="ORDER BY pre021.ced_rif,pre021.cod_presup,pre021.Fecha_Doc, pre021.Referencia_Comp, pre021.Tipo_Compromiso";
  $sql="update pre021 set monto_credito=0 where Tipo_Registro='M' and nombre_usuario='$cod_mov'";$resultado=pg_exec($conn,$sql); 
  $sSQL = "Select cod_presup,denominacion,asignado from pre001 WHERE cod_presup in (select distinct cod_presup from pre021 where (Tipo_Registro='M') and (nombre_usuario='$cod_mov'))";  $res=pg_query($sSQL);
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_presup"]; $denominacion=$registro["denominacion"]; $asignado=$registro["asignado"];
     $sql="update pre021 set monto_credito=monto_credito+$asignado where Tipo_Registro='M' and nombre_usuario='$cod_mov' and cod_presup='$cod_presup'";$resultado=pg_exec($conn,$sql); 
	 $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  }
  }
  
}
  
$sSQL = "SELECT nombre_usuario, tipo_registro, referencia_comp, tipo_compromiso, nombre_abrev_comp, nombre_tipo_comp, referencia_caus, tipo_causado, nombre_tipo_caus, nombre_abrev_caus, referencia_pago, tipo_pago, nombre_tipo_pago, nombre_abrev_pago, cod_presup, fuente_financ, 
       substr(denominacion,1,60) as denominacion, fecha_doc, ref_aep, num_proyecto, fecha_aep, tipo_documento,nro_documento, anulado, fecha_anulado, ced_rif, nombre_benef, func_inv, substr(cod_presup,".$ini.",".$p.") as cod_partida,
       monto, comprometido, causado, pagado, ajustado, (ajustado*-1) as ajuste, func_inv, tipo_imput_presu, ref_imput_presu, monto_credito, inf_usuario, descripcion_doc, to_char(fecha_Doc,'DD/MM/YYYY') as fechad FROM pre021 WHERE (Tipo_Registro='M') And (nombre_usuario='".$cod_mov."') ".$ordenado;
  
    if($tipo_rep=="HTML"){	 include ("../../class/phpreports/PHPReportMaker.php"); 
	   $oRpt = new PHPReportMaker();
	   if($agrupa_cat=="SI"){$oRpt->setXML("Rpt_modificaciones_Subt.xml");}else{
	   
	   if($agrupa_par=="SI"){ if($agrupa_fuen==="SI"){ $oRpt->setXML("Rpt_modificaciones_part_agrup.xml");} else{$oRpt->setXML("Rpt_modificaciones_part.xml");}
	   }else{$oRpt->setXML("Rpt_modificaciones_sin.xml");} }
			
	   $oRpt->setUser("$user");
	   $oRpt->setPassword("$password");
	   $oRpt->setConnection("$host");
	   $oRpt->setDatabaseInterface("postgresql");
	   $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
	   $oRpt->setSQL($sSQL);
	   $oRpt->setDatabase("$dbname");
	   $oRpt->run();
	   $iSec   = $aBench["report_end"]-$aBench["report_start"];
	}
	if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $ced_rif=""; $fecha_doc_grupo=""; $tipo_compromiso_grupo="0000"; $referencia_comp_grupo="00000000"; 
	   require('../../class/fpdf/fpdf.php');
       if($agrupa_cat=="SI"){
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $criterio2; global $criterio4; global $registro;
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(150,10,'MODIFICACIONES',1,0,'C');
				$this->Ln(15);
				$this->SetFont('Arial','B',8);
				$this->Cell(100,10,$criterio1,0,0,'L');		
                $this->Cell(100,10,$criterio2,0,1,'R');	
			    $this->SetFont('Arial','B',7);
				$this->Cell(200,10,$criterio4,0,1,'R');	
				$this->Cell(25,5,'REFERENCIA',1,0);
				$this->Cell(15,5,'FECHA',1,0,'L');						
				$this->Cell(160,5,'DESCRIPCION',1,1,'L');
				$this->Cell(40,5,'CODIGO PRESUPUESTARIO',1,0,'L');						
				$this->Cell(140,5,'DENOMINACION CODIGO PRESUPUESTARIO',1,0,'L');
				$this->Cell(20,5,'MONTO',1,1,'R');
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
		  $i=0;  $total_ajustado=0; $sub_total_ajustado=0; $sub_total_ajustado1=0; $cantidad_ordenes=0; $prev_ced_rif=""; $prev_fecha_doc=""; $prev_tipo_compromiso=""; $prev_referencia_comp=""; 
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $fecha_doc=$registro["fecha_doc"]; $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_comp=$registro["referencia_comp"]; 				
				$ced_rif=$registro["ced_rif"]; $nombre_benef=$registro["nombre_benef"];$descripcion_doc=$registro["descripcion_doc"]; 
				$fecha_doc=formato_ddmmaaaa($fecha_doc);if($php_os=="WINNT"){$descripcion_doc=$registro["descripcion_doc"]; }else{$descripcion_doc=utf8_decode($descripcion_doc);}
				$fecha_doc_grupo=$fecha_doc; $tipo_compromiso_grupo=$tipo_compromiso; $referencia_comp_grupo=$referencia_comp; $ced_rif_grupo=$ced_rif; 
				$descripcion_doc_grupo=$descripcion_doc; $nombre_benef_grupo=$nombre_benef;
				 $pdf->SetFont('Arial','B',7); 
				if(($prev_ced_rif<>$ced_rif_grupo)or($prev_fecha_doc<>$fecha_doc_grupo)or($prev_tipo_compromiso<>$tipo_compromiso_grupo)or($prev_referencia_comp<>$referencia_comp_grupo)){
				   if($sub_total_ajustado<>0){ $sub_total_ajustado=formato_monto($sub_total_ajustado); 
						$pdf->Cell(180,2,'',0,0);
						$pdf->Cell(20,2,'------------------',0,1,'R');
						$pdf->Cell(180,3,'TOTAL '.$prev_referencia_comp." : ",0,0,'R');
						$pdf->Cell(20,3,$sub_total_ajustado,0,1,'R');
						$pdf->Ln(3); $sub_total_ajustado=0; $prev_referencia_comp="";
					}	
				} 
				if($prev_ced_rif<>$ced_rif_grupo){					
					if($sub_total_ajustado1<>0){ $sub_total_ajustado1=formato_monto($sub_total_ajustado1); 
						$pdf->Cell(180,2,'',0,0);
						$pdf->Cell(20,2,'=============',0,1,'R');
						$pdf->Cell(180,3,'TOTAL '.$prev_ced_rif."  : ",0,0,'R');
						$pdf->Cell(20,3,$sub_total_ajustado1,0,1,'R');
						$pdf->AddPage();
					}			 
					$pdf->Cell(200,5,'CATEGORIA:    '.$ced_rif_grupo.'     '.$nombre_benef_grupo,0,1,'L');  
					$prev_ced_rif=$ced_rif_grupo; $sub_total_ajustado1=0; 
				} 
				if(($prev_fecha_doc<>$fecha_doc_grupo)or($prev_tipo_compromiso<>$tipo_compromiso_grupo)or($prev_referencia_comp<>$referencia_comp_grupo)){
					 $pdf->SetFont('Arial','',7);				 
					 $pdf->Cell(25,3,$referencia_comp_grupo,0,0,'L'); 
					 $pdf->Cell(15,3,$fecha_doc_grupo,0,0,'L');
					 $x=$pdf->GetX();   $y=$pdf->GetY(); $n=160; 
					 $pdf->SetXY($x,$y);
					 $pdf->MultiCell($n,3,$descripcion_doc_grupo,0,1);   
					 $prev_fecha_doc=$fecha_doc_grupo; $prev_tipo_compromiso=$tipo_compromiso_grupo; $prev_referencia_comp=$referencia_comp_grupo; $sub_total_ajustado=0; 
				} 
			   $fecha_doc=$registro["fecha_doc"]; $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_comp=$registro["referencia_comp"]; 
			   $descripcion_doc=$registro["descripcion_doc"]; $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"];  				   $ajustado=$registro["ajustado"]; $func_inv=$registro["func_inv"]; $monto=$registro["monto"]; $comprometido=$registro["comprometido"];
			   $total_ajustado=$total_ajustado+$ajustado; $sub_total_ajustado=$sub_total_ajustado+$ajustado; $sub_total_ajustado1=$sub_total_ajustado1+$ajustado;
			   $ajustado=formato_monto($ajustado); $monto=formato_monto($monto); $comprometido=formato_monto($comprometido); $fecha_doc=formato_ddmmaaaa($fecha_doc);	
			   if($php_os=="WINNT"){$descripcion_doc=$registro["descripcion_doc"]; }else{$descripcion_doc=utf8_decode($descripcion_doc); $denominacion=utf8_decode($denominacion);}
			   if($func_inv=="+"){$resultado=$monto;}else{$resultado=$comprometido;}
			   $pdf->SetFont('Arial','',7);
			   $pdf->Cell(40,3,$cod_presup."   ".$fuente_financ,0,0,'L'); 			   
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=140; 	   
			   $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,3,$resultado,0,1,'R');
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$denominacion,0); 
			} $total_ajustado=formato_monto($total_ajustado);  
			$pdf->SetFont('Arial','B',7);
			if($sub_total_ajustado>0){ $sub_total_ajustado=formato_monto($sub_total_ajustado); 
				$pdf->Cell(180,2,'',0,0);
				$pdf->Cell(20,2,'------------------',0,1,'R');
				$pdf->Cell(180,3,'TOTAL '.$prev_referencia_comp." : ",0,0,'R');
				$pdf->Cell(20,3,$sub_total_ajustado,0,1,'R');
				$pdf->Ln(3);
			}
			if($sub_total_ajustado1>0){ $sub_total_ajustado1=formato_monto($sub_total_ajustado1); 
				$pdf->Cell(180,2,'',0,0);
				$pdf->Cell(20,2,'=============',0,1,'R');
				$pdf->Cell(180,3,'TOTAL '.$prev_ced_rif."  : ",0,0,'R');
				$pdf->Cell(20,3,$sub_total_ajustado1,0,1,'R');
				$pdf->Ln(10);
			} 
			$pdf->Cell(180,2,'',0,0);
			$pdf->Cell(20,2,'=============',0,1,'R');
			$pdf->Cell(100,5,'',0,0);
		    $pdf->Cell(80,5,'TOTAL GENERAL ',0,0,'R');
			$pdf->Cell(20,5,$total_ajustado,0,1,'R');
			$pdf->Output(); 
        }
	    else{if($agrupa_par=="SI"){
			    class PDF extends FPDF{
				function Header(){ global $criterio1; global $criterio2; global $criterio4; global $registro;
					$this->Image('../../imagenes/Logo_emp.png',7,7,20);
					$this->SetFont('Arial','B',15);
					$this->Cell(50);
					$this->Cell(150,10,'MODIFICACIONES',1,0,'C');
					$this->Ln(15);
					$this->SetFont('Arial','B',8);
					$this->Cell(100,10,$criterio1,0,0,'L');		
                    $this->Cell(100,10,$criterio2,0,1,'R');	
					$this->SetFont('Arial','B',7);
					$this->Cell(200,10,$criterio4,0,1,'R');	
					$this->Cell(120,5,'CODIGO PRESUPUESTARIO',1,0,'L');  
					$this->Cell(20,5,'ASIGNACION',1,0,'L');  
					$this->Cell(20,5,'INCREMENTOS',1,0,'C');  
					$this->Cell(20,5,'DECREMENTOS',1,0,'C');  
					$this->Cell(20,5,'ACTUAL',1,1,'C');
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
			  $i=0;  $total_ajustado=0; $total_causado=0;  $total_causado1=0; $total_pagado=0; $total_pagado1=0;  $total_monto_credito=0; $total=0; $sub_total_ajustado=0; $sub_total_causado=0; $sub_total_causado1=0; $sub_total_pagado=0; $sub_total_pagado1=0; $sub_total_monto_credito=0; $sub_total=0; $cantidad_ordenes=""; $prev_ced_rif=""; $prev_cod_presup=""; $prev_fecha_doc=""; $prev_tipo_compromiso=""; $prev_referencia_comp=""; $prev_cod_partida="";
			  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_presup=$registro["cod_presup"]; $fecha_doc=$registro["fecha_doc"]; $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_comp=$registro["referencia_comp"]; 	$ced_rif=$registro["ced_rif"]; $nombre_benef=$registro["nombre_benef"];$descripcion_doc=$registro["descripcion_doc"]; $cod_partida=$registro["cod_partida"]; $denominacion=$registro["denominacion"]; $monto_credito=$registro["monto_credito"];
				   $fuente_financ=$registro["fuente_financ"]; $fecha_doc=formato_ddmmaaaa($fecha_doc); if($php_os=="WINNT"){$descripcion_doc=$registro["descripcion_doc"]; }else{$descripcion_doc=utf8_decode($descripcion_doc);}
		           $fecha_doc_grupo=$fecha_doc; $tipo_compromiso_grupo=$tipo_compromiso; $referencia_comp_grupo=$referencia_comp; $ced_rif_grupo=$ced_rif; 
			       $descripcion_doc_grupo=$descripcion_doc; $nombre_benef_grupo=$nombre_benef; $cod_presup_grupo=$cod_presup; $cod_partida_grupo=$cod_partida; $denominacion_grupo=$denominacion; $monto_credito_grupo=$monto_credito;
                   if($agrupa_fuen==="SI"){ $cod_presup_grupo=$cod_presup;}else{ $cod_presup_grupo=$cod_presup.$fuente_financ;} 
				   if(($prev_ced_rif<>$ced_rif_grupo)or($prev_cod_presup<>$cod_presup_grupo)){
					  $pdf->SetFont('Arial','',7); 
					  if(($sub_total_monto_credito<>0)or($sub_total_causado1<>0)or($sub_total_pagado1<>0)or($sub_total<>0)){ $sub_total_monto_credito=formato_monto($sub_total_monto_credito);  $sub_total_causado1=formato_monto($sub_total_causado1); $sub_total_pagado1=formato_monto($sub_total_pagado1); $sub_total=formato_monto($sub_total);
						 $pdf->Cell(120,2,'',0,0);
						 $pdf->Cell(20,2,'------------------',0,0,'R');
						 $pdf->Cell(20,2,'------------------',0,0,'R');
						 $pdf->Cell(20,2,'------------------',0,0,'R');
						 $pdf->Cell(20,2,'------------------',0,1,'R');
						 $pdf->Cell(120,2,'TOTAL '.$prev_cod_partida.' : ',0,0,'R');
						 $pdf->Cell(20,3,$sub_total_monto_credito,0,0,'R');
						 $pdf->Cell(20,3,$sub_total_causado1,0,0,'R');
						 $pdf->Cell(20,3,$sub_total_pagado1,0,0,'R');
						 $pdf->Cell(20,3,$sub_total,0,1,'R');
						 $pdf->Ln(5); $prev_cod_presup="";
						 $sub_total_monto_credito=0; $sub_total_causado1=0; $sub_total_pagado1=0; $sub_total=0;
					  }	
				   }	  
				   if(($prev_ced_rif<>$ced_rif_grupo)){
					  $pdf->SetFont('Arial','B',7); 
					  if(($sub_total_causado<>0)or($sub_total_pagado<>0)){ $sub_total_causado=formato_monto($sub_total_causado); $sub_total_pagado=formato_monto($sub_total_pagado);
						$pdf->Cell(140,2,'',0,0);
						$pdf->Cell(20,2,'=============',0,0,'R');
						$pdf->Cell(20,2,'=============',0,0,'R');
						$pdf->Cell(20,2,'',0,1,'R');
						$pdf->Cell(120,3,'TOTAL '.$prev_ced_rif.' : ',0,0,'R');
						$pdf->Cell(20,3,'',0,0,'R');
						$pdf->Cell(20,3,$sub_total_causado,0,0,'R');
						$pdf->Cell(20,3,$sub_total_pagado,0,0,'R');
						$pdf->Cell(20,3,'',0,1,'R');
					    $pdf->AddPage();
					  }			 
					  $pdf->Cell(200,5,'CATEGORIA:    '.$ced_rif_grupo.'     '.$nombre_benef_grupo,0,1,'L');  
					  $prev_ced_rif=$ced_rif_grupo; $sub_total_causado=0; $sub_total_pagado=0;
				    } 
				 
				    if($prev_cod_presup<>$cod_presup_grupo){ $monto_credito_grupo=formato_monto($monto_credito_grupo);
					  $pdf->SetFont('Arial','',7); 
					  if($agrupa_fuen==="SI"){ $temp_part=$cod_partida_grupo; } else { $temp_part=$cod_partida_grupo."  ".$fuente_financ; }
					  $pdf->Cell(30,3,$temp_part,0,0,'L'); 
					  $x=$pdf->GetX();   $y=$pdf->GetY(); $n=90; 		   
					  $pdf->SetXY($x+$n,$y);
					  $pdf->Cell(20,3,$monto_credito_grupo,0,1,'R');
					  $pdf->SetXY($x,$y);
					  $pdf->MultiCell($n,3,$denominacion_grupo,0);
					  $prev_cod_presup=$cod_presup_grupo; $prev_cod_partida=$cod_partida_grupo; $sub_total_monto_credito=0; $sub_total_causado1=0; $sub_total_pagado1=0; $sub_total=0;
					}

				   $fecha_doc=$registro["fecha_doc"]; $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_comp=$registro["referencia_comp"]; 
				   $descripcion_doc=$registro["descripcion_doc"]; $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"];  
				   $cod_partida=$registro["cod_partida"]; $denominacion=$registro["denominacion"]; $monto_credito=$registro["monto_credito"]; $causado=$registro["causado"]; 
				   $pagado=$registro["pagado"]; 
				   $total_causado=$total_causado+$causado; $total_causado1=$total_causado1+$causado; $total_pagado=$total_pagado+$pagado; $total_pagado1=$total_pagado1+$pagado;
				   $total_monto_credito=$total_monto_credito+$monto_credito; $total=$total+$monto_credito+$causado-$pagado; $sub_total_causado=$sub_total_causado+$causado; 				   
				   $sub_total_causado1=$sub_total_causado1+$causado;$sub_total_pagado=$sub_total_pagado+$pagado; $sub_total_pagado1=$sub_total_pagado1+$pagado; 
				   $sub_total_monto_credito=$sub_total_monto_credito+$monto_credito; $sub_total=$sub_total+$monto_credito+$causado-$pagado;
				   $causado=formato_monto($causado); $pagado=formato_monto($pagado); $monto_credito=formato_monto($monto_credito); $fecha_doc=formato_ddmmaaaa($fecha_doc);	
				   if($php_os=="WINNT"){$descripcion_doc=$registro["descripcion_doc"]; }else{$descripcion_doc=utf8_decode($descripcion_doc);$denominacion=utf8_decode($denominacion);}
				   $pdf->SetFont('Arial','',7);
				   $pdf->Cell(120,3,'REFERENCIA : '.$referencia_comp.'  FECHA : '.$fecha_doc,0,0,'R'); 	
			       $pdf->Cell(20,3,'',0,0,'R'); 
				   $pdf->Cell(20,3,$causado,0,0,'R'); 
				   $pdf->Cell(20,3,$pagado,0,0,'R');
				   $pdf->Cell(20,3,'',0,1,'L'); 		    	   
					
				} $total_causado=formato_monto($total_causado);  $total_pagado=formato_monto($total_pagado); 
			    $pdf->SetFont('Arial','B',7);
			     if(($sub_total_monto_credito<>0)or($sub_total_causado1<>0)or($sub_total_pagado1<>0)or($sub_total<>0)){ $sub_total_monto_credito=formato_monto($sub_total_monto_credito);  $sub_total_causado1=formato_monto($sub_total_causado1); $sub_total_pagado1=formato_monto($sub_total_pagado1); $sub_total=formato_monto($sub_total);
					$pdf->Cell(120,2,'',0,0);
					$pdf->Cell(20,2,'------------------',0,0,'R');
					$pdf->Cell(20,2,'------------------',0,0,'R');
					$pdf->Cell(20,2,'------------------',0,0,'R');
					$pdf->Cell(20,2,'------------------',0,1,'R');
					$pdf->Cell(120,2,'TOTAL '.$prev_cod_partida.' : ',0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto_credito,0,0,'R');
					$pdf->Cell(20,3,$sub_total_causado1,0,0,'R');
					$pdf->Cell(20,3,$sub_total_pagado1,0,0,'R');
					$pdf->Cell(20,3,$sub_total,0,1,'R');
                    $pdf->Ln(5);
				 }	

			     if(($sub_total_causado<>0)or($sub_total_pagado<>0)){ $sub_total_causado=formato_monto($sub_total_causado); $sub_total_pagado=formato_monto($sub_total_pagado);
					$pdf->Cell(140,2,'',0,0);
					$pdf->Cell(20,2,'=============',0,0,'R');
					$pdf->Cell(20,2,'=============',0,0,'R');
					$pdf->Cell(20,2,'',0,1,'R');
					$pdf->Cell(120,3,'TOTAL '.$prev_ced_rif.' : ',0,0,'R');
					$pdf->Cell(20,3,'',0,0,'R');
					$pdf->Cell(20,3,$sub_total_causado,0,0,'R');
					$pdf->Cell(20,3,$sub_total_pagado,0,0,'R');
					$pdf->Cell(20,3,'',0,1,'R');
                    $pdf->Ln(10);
				}		
				$pdf->SetFont('Arial','B',7);
				$pdf->Cell(140,2,'',0,0);
				$pdf->Cell(20,2,'=============',0,0,'R');
				$pdf->Cell(20,2,'=============',0,0,'R');
				$pdf->Cell(20,2,'',0,1,'R');
				$pdf->Cell(80,5,'',0,0,'L');
				$pdf->Cell(40,5,'TOTAL GENERAL: ',0,0,'R');
				$pdf->Cell(20,5,'',0,0,'R');
				$pdf->Cell(20,5,$total_causado,0,0,'R');
				$pdf->Cell(20,5,$total_pagado,0,0,'R');
				$pdf->Cell(20,5,'',0,1,'R');
				$pdf->Output(); 
			
			
		}/*Rpt_modificaciones_sin*/
        else{
			class PDF extends FPDF{
				function Header(){ global $criterio1;  global $criterio2; global $criterio4;   global $registro;
					$this->Image('../../imagenes/Logo_emp.png',7,7,20);
					$this->SetFont('Arial','B',15);
					$this->Cell(50);
					$this->Cell(150,10,'MODIFICACIONES',1,0,'C');
					$this->Ln(20);
					$this->SetFont('Arial','B',8);
					$this->Cell(100,10,$criterio1,0,0,'L');		
                    $this->Cell(100,10,$criterio2,0,1,'R');	
					$this->SetFont('Arial','B',7);
					$this->Cell(200,10,$criterio4,0,1,'R');	
					$this->Cell(20,5,'REFERENCIA',1,0);
					$this->Cell(15,5,'FECHA',1,0,'L');						
					$this->Cell(165,5,'DESCRIPCION',1,1,'L');
					$this->Cell(40,5,'CODIGO PRESUPUESTARIO',1,0,'L');						
					$this->Cell(140,5,'DENOMINACION CODIGO PRESUPUESTARIO',1,0,'L');
					$this->Cell(20,5,'MONTO',1,1,'R');
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
			$i=0;  $total_ajustado=0; $sub_total_ajustado=0; $cantidad_ordenes=0; $prev_fecha_doc=""; $prev_tipo_compromiso=""; $prev_referencia_comp=""; 
			while($registro=pg_fetch_array($res)){ $i=$i+1;  $fecha_doc=$registro["fecha_doc"]; $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_comp=$registro["referencia_comp"]; 				$ced_rif=$registro["ced_rif"]; $nombre_benef=$registro["nombre_benef"];$descripcion_doc=$registro["descripcion_doc"]; 
				$fecha_doc=formato_ddmmaaaa($fecha_doc); 
				if($php_os=="WINNT"){$descripcion_doc=$registro["descripcion_doc"]; }else{$descripcion_doc=utf8_decode($descripcion_doc);}
		        $fecha_doc_grupo=$fecha_doc; $tipo_compromiso_grupo=$tipo_compromiso; $referencia_comp_grupo=$referencia_comp; $ced_rif_grupo=$ced_rif; 
			    $descripcion_doc_grupo=$descripcion_doc; $nombre_benef_grupo=$nombre_benef;
                $pdf->SetFont('Arial','B',7); 
			    if(($prev_fecha_doc<>$fecha_doc_grupo)or($prev_tipo_compromiso<>$tipo_compromiso_grupo)or($prev_referencia_comp<>$referencia_comp_grupo)){			      
		 		   if($sub_total_ajustado<>0){ $sub_total_ajustado=formato_monto($sub_total_ajustado); 
					  $pdf->Cell(180,2,'',0,0);
				  	  $pdf->Cell(20,2,'--------------------',0,1,'R');
					  $pdf->Cell(180,3,'TOTAL',0,0,'R');
					  $pdf->Cell(20,3,$sub_total_ajustado,0,1,'R');
                      $pdf->Ln(5);
				   }
				   $pdf->SetFont('Arial','',7); 
				   $pdf->Cell(20,4,$referencia_comp_grupo,0,0,'L'); 
				   $pdf->Cell(15,4,$fecha_doc_grupo,0,0,'L');
		   	       $x=$pdf->GetX();   $y=$pdf->GetY(); $n=165; 
		   	   	   $pdf->SetXY($x,$y);
		           $pdf->MultiCell($n,4,$descripcion_doc_grupo,0,1); 
				   $prev_fecha_doc=$fecha_doc_grupo; $prev_tipo_compromiso=$tipo_compromiso_grupo; $prev_referencia_comp=$referencia_comp_grupo; $sub_total_ajustado=0; 
				}
		       $fecha_doc=$registro["fecha_doc"]; $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_comp=$registro["referencia_comp"]; 
			   $descripcion_doc=$registro["descripcion_doc"]; $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"];  				   $ajustado=$registro["ajustado"]; $func_inv=$registro["func_inv"]; $monto=$registro["monto"]; $comprometido=$registro["comprometido"];
			   $total_ajustado=$total_ajustado+$ajustado; $sub_total_ajustado=$sub_total_ajustado+$ajustado; 
			   $ajustado=formato_monto($ajustado); $monto=formato_monto($monto); $comprometido=formato_monto($comprometido); $fecha_doc=formato_ddmmaaaa($fecha_doc);	
			   if($php_os=="WINNT"){$descripcion_doc=$registro["descripcion_doc"]; }else{$descripcion_doc=utf8_decode($descripcion_doc);$denominacion=utf8_decode($denominacion);}
			   if($func_inv=="+"){$resultado=$monto;}else{$resultado=$comprometido;}
			   $pdf->SetFont('Arial','',7);
			   $pdf->Cell(40,3,$cod_presup."   ".$fuente_financ,0,0,'L'); 			   
		   	   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=140; 	   
		       $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,3,$resultado,0,1,'R');
		   	   $pdf->SetXY($x,$y);
		       $pdf->MultiCell($n,3,$denominacion,0);  
			} $total_ajustado=formato_monto($total_ajustado);  
			$pdf->SetFont('Arial','B',7);
			if($sub_total_ajustado<>0){ $sub_total_ajustado=formato_monto($sub_total_ajustado); 
				$pdf->Cell(180,2,'',0,0);
				$pdf->Cell(20,2,'--------------------',0,1,'R');
				$pdf->Cell(180,3,'TOTAL',0,0,'R');
				$pdf->Cell(20,3,$sub_total_ajustado,0,1,'R');
				$pdf->Ln(5);
			}
			
			$pdf->Cell(180,2,'',0,0);
			$pdf->Cell(20,2,'=============',0,1,'R');
			$pdf->Cell(100,5,'',0,0,'L');
		    $pdf->Cell(80,5,'TOTAL GENERAL ',0,0,'R');
			$pdf->Cell(20,5,$total_ajustado,0,1,'R');
			$pdf->Output(); 
		  }

		}
	}
   if($tipo_rep=="EXCEL"){
	if($agrupa_cat=="SI"){
                  /*Rpt_modificaciones_Subt*/
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_modificaciones_Subt.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
			        <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE DE MODIFICACIONES</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1?></strong></font></td>
				<td width="100" align="left" ><strong></strong></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Referencia</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF" ><strong>Descripcion</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			 </tr>
			 <tr height="20">
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Codigo Presupuestario</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Denominacion Codigo Presupuestario</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>Monto</strong></td>
			 </tr>
		  <?  $i=0; $total_ajustado=0; $total_ajustado1=0; $sub_total_ajustado=0; $sub_total_ajustado1=0; $cantidad_ordenes=""; $prev_ced_rif=""; $prev_fecha_doc=""; $prev_tipo_compromiso=""; $prev_referencia_comp="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $fecha_doc=$registro["fecha_doc"]; $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_comp=$registro["referencia_comp"]; 				$ced_rif=$registro["ced_rif"]; $nombre_benef=$registro["nombre_benef"];$descripcion_doc=$registro["descripcion_doc"]; 
			$fecha_doc=formato_ddmmaaaa($fecha_doc); $cantidad_ordenes=$cantidad_ordenes+1;
			$fecha_doc_grupo=$fecha_doc; $tipo_compromiso_grupo=$tipo_compromiso; $referencia_comp_grupo=$referencia_comp; $ced_rif_grupo=$ced_rif; 
			 $descripcion_doc_grupo=$descripcion_doc; $nombre_benef_grupo=$nombre_benef;

			   if($prev_ced_rif<>$ced_rif_grupo){
			    if($sub_total_ajustado1>0){ $sub_total_ajustado1=formato_monto($sub_total_ajustado1); 		
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			           <td width="100" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			           <td width="100" align="right"><? echo $sub_total_ajustado1; ?></td>
			        </tr>	
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			      ?>	   
			      <tr>
				   <td width="100" align="left">'<? echo 'CATEGORIA:   '.$ced_rif_grupo; ?></td>
				   <td width="100" align="left"></td>
				   <td width="400" align="left"><? echo $nombre_benef_grupo; ?></td>
			      </tr>	
			     <? 					 
			    $prev_ced_rif=$ced_rif_grupo; $sub_total_ajustado1=0; }

			   if(($prev_fecha_doc<>$fecha_doc_grupo)or($prev_tipo_compromiso<>$tipo_compromiso_grupo)or($prev_referencia_comp<>$referencia_comp_grupo)){
			    if($sub_total_ajustado>0){ $sub_total_ajustado=formato_monto($sub_total_ajustado); 		
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			           <td width="100" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"><? echo 'TOTAL: '.$prev_ced_rif; ?></td>
			           <td width="100" align="right"><? echo $sub_total_ajustado; ?></td>
			        </tr>	
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			      ?>	   
			      <tr>
				   <td width="100" align="left">'<? echo $referencia_comp_grupo; ?></td>
				   <td width="100" align="left"><? echo $fecha_doc_grupo; ?></td>
				   <td width="400" align="left"><? echo $descripcion_doc_grupo; ?></td>
			      </tr>	
			     <? 					 
			    $prev_fecha_doc=$fecha_doc_grupo; $prev_tipo_compromiso=$tipo_compromiso_grupo; $prev_referencia_comp=$referencia_comp_grupo; $prev_ced_rif=$ced_rif_grupo;$sub_total_ajustado=0; }

		           $fecha_doc=$registro["fecha_doc"]; $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_comp=$registro["referencia_comp"]; 
			   $descripcion_doc=$registro["descripcion_doc"]; $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"];  				   $ajustado=$registro["ajustado"]; $func_inv=$registro["func_inv"]; $monto=$registro["monto"]; $comprometido=$registro["comprometido"];
			   $total_ajustado=$total_ajustado+$ajustado; $sub_total_ajustado=$sub_total_ajustado+$ajustado; 
			   $ajustado=formato_monto($ajustado); $monto=formato_monto($monto); $comprometido=formato_monto($comprometido); $fecha_doc=formato_ddmmaaaa($fecha_doc);	
			   if($func_inv=="+"){$resultado=$monto;}else{$resultado=$comprometido;}		   
			   $descripcion_doc=conv_cadenas($descripcion_doc,0);$denominacion=conv_cadenas($denominacion,0); 
			   ?>	   
				<tr>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_presup; ?></td>
				   <td width="100" align="left">'<? echo $fuente_financ; ?></td>
				   <td width="400" align="justify"><? echo $denominacion; ?></td>
				   <td width="100" align="right"><? echo $resultado; ?></td>
				 </tr>
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
			   <? 	

		  }$total_ajustado=formato_monto($total_ajustado);  
		     if($sub_total_ajustado>0){ $sub_total_ajustado=formato_monto($sub_total_ajustado); 		
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			           <td width="100" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			           <td width="100" align="right"><? echo $sub_total_ajustado; ?></td>
			        </tr>			
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="right">---------------</td>
			</tr>	
			<tr>
			    <td width="100" align="left"></strong></td>
			    <td width="100" align="right"></td>
			    <td width="400" align="right"><strong>TOTAL GENERAL : </strong></td>
			    <td width="100" align="right"><strong><? echo $total_ajustado; ?></strong></td>
			</tr>	
		       <? 				  
		  ?></table><?}
        else{if($agrupa_par=="SI")
	      {if($agrupa_fuen==="SI")
                  {
                  /*Rpt_modificaciones_part_agrup*/
                  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_modificaciones_part_agrup.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
			        <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE DE MODIFICACIONES</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1?></strong></font></td>
				<td width="100" align="left" ><strong></strong></td>
			 </tr>
			 <tr height="20">
			 </tr>

		  <?  $i=0; $total_ajustado=0; $total_causado=0;  $total_causado1=0; $total_pagado=0; $total_pagado1=0;  $total_monto_credito=0; $total=0; $sub_total_ajustado=0; $sub_total_causado=0; $sub_total_causado1=0; $sub_total_pagado=0; $sub_total_pagado1=0; $sub_total_monto_credito=0; $sub_total=0; $cantidad_ordenes=""; $prev_ced_rif=""; $prev_cod_presup=""; $prev_fecha_doc=""; $prev_tipo_compromiso=""; $prev_referencia_comp=""; $prev_cod_partida=""; $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_presup=$registro["cod_presup"]; $fecha_doc=$registro["fecha_doc"]; $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_comp=$registro["referencia_comp"]; 	$ced_rif=$registro["ced_rif"]; $nombre_benef=$registro["nombre_benef"];$descripcion_doc=$registro["descripcion_doc"]; $cod_partida=$registro["cod_partida"]; $denominacion=$registro["denominacion"]; $monto_credito=$registro["monto_credito"];
			$fecha_doc=formato_ddmmaaaa($fecha_doc); $cantidad_ordenes=$cantidad_ordenes+1;
			$fecha_doc_grupo=$fecha_doc; $tipo_compromiso_grupo=$tipo_compromiso; $referencia_comp_grupo=$referencia_comp; $ced_rif_grupo=$ced_rif; 
			 $descripcion_doc_grupo=$descripcion_doc; $nombre_benef_grupo=$nombre_benef; $cod_presup_grupo=$cod_presup; $cod_partida_grupo=$cod_partida; $denominacion_grupo=$denominacion; $monto_credito_grupo=$monto_credito;

			   if($prev_cod_presup<>$cod_presup_grupo){
			    if(($sub_total_monto_credito>0)or($sub_total_causado1>0)or($sub_total_pagado1>0)or($sub_total>0)){ $sub_total_monto_credito=formato_monto($sub_total_monto_credito);  $sub_total_causado1=formato_monto($sub_total_causado1); $sub_total_pagado1=formato_monto($sub_total_pagado1); $sub_total=formato_monto($sub_total);
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			    	   <td width="100" align="left"></td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			    	   <td width="100" align="left"></td>
			           <td width="100" align="right"><? echo $sub_total_monto_credito; ?></td>
			           <td width="100" align="right"><? echo $sub_total_causado1; ?></td>
			           <td width="100" align="right"><? echo $sub_total_pagado1; ?></td>
			           <td width="100" align="right"><? echo $sub_total; ?></td>
			        </tr>	
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			      ?>	   
			      <tr>
				   <td width="100" align="left">'<? echo $cod_partida_grupo; ?></td>
				   <td width="400" align="left"><? echo $denominacion_grupo; ?></td>
				   <td width="100" align="left"><? echo $monto_credito_grupo; ?></td>
			      </tr>	
			     <? 					 
			    $prev_cod_presup=$cod_presup_grupo; $prev_cod_partida=$cod_partida_grupo; $sub_total_monto_credito=0; $sub_total_causado1=0; $sub_total_pagado1=0; $sub_total=0;}

			   if(($prev_ced_rif<>$ced_rif_grupo)){
			    if(($sub_total_causado>0)or($sub_total_pagado>0)){ $sub_total_causado=formato_monto($sub_total_causado); $sub_total_pagado=formato_monto($sub_total_pagado);
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			    	   <td width="100" align="left"></td>
			           <td width="100" align="right"><? echo 'TOTAL : '.$prev_ced_rif; ?><</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right"></td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			    	   <td width="100" align="left"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"><? echo $sub_total_causado; ?></td>
			           <td width="100" align="right"><? echo $sub_total_pagado; ?></td>
			           <td width="100" align="right"></td>
			        </tr>	
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			      ?>	   
			      <tr>
				   <td width="100" align="left">'<? echo 'CATEGORIA: '.$ced_rif_grupo; ?></td>
				   <td width="400" align="left"><? echo $nombre_benef_grupo; ?></td>
			      </tr>
			      <tr height="20">
			   	   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Codigo Presupuestario</strong></td>
			   	   <td width="400" align="left" bgcolor="#99CCFF"></td>
			           <td width="100" align="left" bgcolor="#99CCFF"></td>
			           <td width="100" align="left" bgcolor="#99CCFF"><strong>Asignacion</strong></td>
			           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Incrementos</strong></td>
			           <td width="100" align="right" bgcolor="#99CCFF"><strong>Decrementos</strong></td>
			           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Actual</strong></td>
			      </tr>			
			     <? 					 
			    $prev_ced_rif=$ced_rif_grupo; $sub_total_causado=0; $sub_total_pagado=0;}

		           $fecha_doc=$registro["fecha_doc"]; $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_comp=$registro["referencia_comp"]; 
			   $descripcion_doc=$registro["descripcion_doc"]; $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"];  
                           $cod_partida=$registro["cod_partida"]; $denominacion=$registro["denominacion"]; $monto_credito=$registro["monto_credito"]; $causado=$registro["causado"]; 
			   $pagado=$registro["pagado"]; 
			   $total_causado=$total_causado+$causado; $total_causado1=$total_causado1+$causado; $total_pagado=$total_pagado+$pagado; $total_pagado1=$total_pagado1+$pagado;
                           $total_monto_credito=$total_monto_credito+$monto_credito; $total=$total+$monto_credito+$causado-$pagado; $sub_total_causado=$sub_total_causado+$causado; 				   $sub_total_causado1=$sub_total_causado1+$causado;$sub_total_pagado=$sub_total_pagado+$pagado; $sub_total_pagado1=$sub_total_pagado1+$pagado; 
                           $sub_total_monto_credito=$sub_total_monto_credito+$monto_credito; $sub_total=$sub_total+$monto_credito+$causado-$pagado;
			   $causado=formato_monto($causado); $pagado=formato_monto($pagado); $monto_credito=formato_monto($monto_credito); $fecha_doc=formato_ddmmaaaa($fecha_doc);	
			   if($func_inv=="+"){$resultado=$monto;}else{$resultado=$comprometido;}		   
			   $descripcion_doc=conv_cadenas($descripcion_doc,0);$denominacion=conv_cadenas($denominacion,0); 
			   ?>	   
				<tr>
				   <td width="100" align="left"></td>
				   <td width="400" align="left"></td>
				   <td width="100" align="left">'<? echo 'REFERENCIA : '.$referencia_comp; ?></td>
				   <td width="100" align="right"><? echo 'FECHA : '.$fecha_doc; ?></td>
				   <td width="100" align="right"><? echo $causado; ?></td>
				   <td width="100" align="right"><? echo $pagado; ?></td>
				   <td width="100" align="right"></td>
				 </tr>
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
			   <? 	

		  }$total_causado=formato_monto($total_causado);  $total_pagado=formato_monto($total_pagado); 
		     if(($sub_total_monto_credito>0)or($sub_total_causado1>0)or($sub_total_pagado1>0)or($sub_total>0)){ $sub_total_monto_credito=formato_monto($sub_total_monto_credito);  $sub_total_causado1=formato_monto($sub_total_causado1); $sub_total_pagado1=formato_monto($sub_total_pagado1); $sub_total=formato_monto($sub_total);		
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			    	   <td width="100" align="left"></td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			    	   <td width="100" align="left"></td>
			           <td width="100" align="right"><? echo $sub_total_monto_credito; ?></td>
			           <td width="100" align="right"><? echo $sub_total_causado1; ?></td>
			           <td width="100" align="right"><? echo $sub_total_pagado1; ?></td>
			           <td width="100" align="right"><? echo $sub_total; ?></td>
			        </tr>	
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>
                              <?}

		      if(($sub_total_causado>0)or($sub_total_pagado>0)){ $sub_total_causado=formato_monto($sub_total_causado); $sub_total_pagado=formato_monto($sub_total_pagado);	
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			    	   <td width="100" align="left"></td>
			           <td width="100" align="right"><? echo 'TOTAL : '.$prev_ced_rif; ?><</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right"></td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			    	   <td width="100" align="left"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"><? echo $sub_total_causado; ?></td>
			           <td width="100" align="right"><? echo $sub_total_pagado; ?></td>
			           <td width="100" align="right"></td>
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
			    <td width="100" align="right"></td>
			    <td width="100" align="right">---------------</td>
			    <td width="100" align="right">---------------</td>
			    <td width="100" align="right"></td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="400" align="right"></td>
			    <td width="100" align="right"></td>
			    <td width="100" align="right"><strong>TOTAL GENERAL : </strong></td>
			    <td width="100" align="right"><strong><? echo $total_causado; ?></strong></td>
			    <td width="100" align="right"><strong><? echo $total_pagado; ?></strong></td>
			    <td width="100" align="right"></td>
			</tr>	
		       <? 				  
		  ?></table><?} 
                  else{
		  /*Rpt_modificaciones_part*/
                 header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_modificaciones_part_agrup.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
			        <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE DE MODIFICACIONES</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1?></strong></font></td>
				<td width="100" align="left" ><strong></strong></td>
			 </tr>
			 <tr height="20">
			 </tr>

		  <?  $i=0; $total_ajustado=0; $total_causado=0;  $total_causado1=0; $total_pagado=0; $total_pagado1=0;  $total_monto_credito=0; $total=0; $sub_total_ajustado=0; $sub_total_causado=0; $sub_total_causado1=0; $sub_total_pagado=0; $sub_total_pagado1=0; $sub_total_monto_credito=0; $sub_total=0; $cantidad_ordenes=""; $prev_ced_rif=""; $prev_cod_presup=""; $prev_fecha_doc=""; $prev_tipo_compromiso=""; $prev_referencia_comp=""; $prev_cod_partida=""; $prev_fuente_financ; $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_presup=$registro["cod_presup"]; $fecha_doc=$registro["fecha_doc"]; $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_comp=$registro["referencia_comp"]; 	$ced_rif=$registro["ced_rif"]; $nombre_benef=$registro["nombre_benef"];$descripcion_doc=$registro["descripcion_doc"]; $cod_partida=$registro["cod_partida"]; $denominacion=$registro["denominacion"]; $fuente_financ=$registro["fuente_financ"];  $monto_credito=$registro["monto_credito"];
			$fecha_doc=formato_ddmmaaaa($fecha_doc); $cantidad_ordenes=$cantidad_ordenes+1;
			$fecha_doc_grupo=$fecha_doc; $tipo_compromiso_grupo=$tipo_compromiso; $referencia_comp_grupo=$referencia_comp; $ced_rif_grupo=$ced_rif; 
			 $descripcion_doc_grupo=$descripcion_doc; $nombre_benef_grupo=$nombre_benef; $cod_presup_grupo=$cod_presup; $cod_partida_grupo=$cod_partida; $denominacion_grupo=$denominacion; $monto_credito_grupo=$monto_credito; $fuente_financ_grupo=$fuente_financ;

			   if($prev_cod_presup<>$cod_presup_grupo){
			    if(($sub_total_monto_credito>0)or($sub_total_causado1>0)or($sub_total_pagado1>0)or($sub_total>0)){ $sub_total_monto_credito=formato_monto($sub_total_monto_credito);  $sub_total_causado1=formato_monto($sub_total_causado1); $sub_total_pagado1=formato_monto($sub_total_pagado1); $sub_total=formato_monto($sub_total);
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			    	   <td width="100" align="left"></td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			    	   <td width="100" align="left"></td>
			           <td width="100" align="right"><? echo $sub_total_monto_credito; ?></td>
			           <td width="100" align="right"><? echo $sub_total_causado1; ?></td>
			           <td width="100" align="right"><? echo $sub_total_pagado1; ?></td>
			           <td width="100" align="right"><? echo $sub_total; ?></td>
			        </tr>	
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			      ?>	   
			      <tr>
				   <td width="100" align="left">'<? echo $cod_partida_grupo."    ".$fuente_financ_grupo; ?></td>
				   <td width="400" align="left"><? echo $denominacion_grupo; ?></td>
				   <td width="100" align="left"><? echo $monto_credito_grupo; ?></td>
			      </tr>	
			     <? 					 
			    $prev_cod_presup=$cod_presup_grupo; $prev_cod_partida=$cod_partida_grupo;  $prev_fuente_financ=$fuente_financ_grupo; $sub_total_monto_credito=0; $sub_total_causado1=0; $sub_total_pagado1=0; $sub_total=0;}

			   if(($prev_ced_rif<>$ced_rif_grupo)){
			    if(($sub_total_causado>0)or($sub_total_pagado>0)){ $sub_total_causado=formato_monto($sub_total_causado); $sub_total_pagado=formato_monto($sub_total_pagado);
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			    	   <td width="100" align="left"></td>
			           <td width="100" align="right"><? echo 'TOTAL : '.$prev_ced_rif; ?><</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right"></td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			    	   <td width="100" align="left"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"><? echo $sub_total_causado; ?></td>
			           <td width="100" align="right"><? echo $sub_total_pagado; ?></td>
			           <td width="100" align="right"></td>
			        </tr>	
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			      ?>	   
			      <tr>
				   <td width="100" align="left">'<? echo 'CATEGORIA: '.$ced_rif_grupo; ?></td>
				   <td width="400" align="left"><? echo $nombre_benef_grupo; ?></td>
			      </tr>
			      <tr height="20">
			   	   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Codigo Presupuestario</strong></td>
			   	   <td width="400" align="left" bgcolor="#99CCFF"></td>
			           <td width="100" align="left" bgcolor="#99CCFF"></td>
			           <td width="100" align="left" bgcolor="#99CCFF"><strong>Asignacion</strong></td>
			           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Incrementos</strong></td>
			           <td width="100" align="right" bgcolor="#99CCFF"><strong>Decrementos</strong></td>
			           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Actual</strong></td>
			      </tr>			
			     <? 					 
			    $prev_ced_rif=$ced_rif_grupo; $sub_total_causado=0; $sub_total_pagado=0;}

		           $fecha_doc=$registro["fecha_doc"]; $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_comp=$registro["referencia_comp"]; 
			   $descripcion_doc=$registro["descripcion_doc"]; $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"];  
                           $cod_partida=$registro["cod_partida"]; $denominacion=$registro["denominacion"]; $monto_credito=$registro["monto_credito"]; $causado=$registro["causado"]; 
			   $pagado=$registro["pagado"]; 
			   $total_causado=$total_causado+$causado; $total_causado1=$total_causado1+$causado; $total_pagado=$total_pagado+$pagado; $total_pagado1=$total_pagado1+$pagado;
                           $total_monto_credito=$total_monto_credito+$monto_credito; $total=$total+$monto_credito+$causado-$pagado; $sub_total_causado=$sub_total_causado+$causado; 				   $sub_total_causado1=$sub_total_causado1+$causado;$sub_total_pagado=$sub_total_pagado+$pagado; $sub_total_pagado1=$sub_total_pagado1+$pagado; 
                           $sub_total_monto_credito=$sub_total_monto_credito+$monto_credito; $sub_total=$sub_total+$monto_credito+$causado-$pagado;
			   $causado=formato_monto($causado); $pagado=formato_monto($pagado); $monto_credito=formato_monto($monto_credito); $fecha_doc=formato_ddmmaaaa($fecha_doc);	
			   if($func_inv=="+"){$resultado=$monto;}else{$resultado=$comprometido;}		   
			   $descripcion_doc=conv_cadenas($descripcion_doc,0);$denominacion=conv_cadenas($denominacion,0); 
			   ?>	   
				<tr>
				   <td width="100" align="left"></td>
				   <td width="400" align="left"></td>
				   <td width="100" align="left">'<? echo 'REFERENCIA : '.$referencia_comp; ?></td>
				   <td width="100" align="right"><? echo 'FECHA : '.$fecha_doc; ?></td>
				   <td width="100" align="right"><? echo $causado; ?></td>
				   <td width="100" align="right"><? echo $pagado; ?></td>
				   <td width="100" align="right"></td>
				 </tr>
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
			   <? 	

		  }$total_causado=formato_monto($total_causado);  $total_pagado=formato_monto($total_pagado); 
		     if(($sub_total_monto_credito>0)or($sub_total_causado1>0)or($sub_total_pagado1>0)or($sub_total>0)){ $sub_total_monto_credito=formato_monto($sub_total_monto_credito);  $sub_total_causado1=formato_monto($sub_total_causado1); $sub_total_pagado1=formato_monto($sub_total_pagado1); $sub_total=formato_monto($sub_total);		
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			    	   <td width="100" align="left"></td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			    	   <td width="100" align="left"></td>
			           <td width="100" align="right"><? echo $sub_total_monto_credito; ?></td>
			           <td width="100" align="right"><? echo $sub_total_causado1; ?></td>
			           <td width="100" align="right"><? echo $sub_total_pagado1; ?></td>
			           <td width="100" align="right"><? echo $sub_total; ?></td>
			        </tr>	
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>
                              <?}

		      if(($sub_total_causado>0)or($sub_total_pagado>0)){ $sub_total_causado=formato_monto($sub_total_causado); $sub_total_pagado=formato_monto($sub_total_pagado);	
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			    	   <td width="100" align="left"></td>
			           <td width="100" align="right"><? echo 'TOTAL : '.$prev_ced_rif; ?><</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right"></td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			    	   <td width="100" align="left"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"><? echo $sub_total_causado; ?></td>
			           <td width="100" align="right"><? echo $sub_total_pagado; ?></td>
			           <td width="100" align="right"></td>
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
			    <td width="100" align="right"></td>
			    <td width="100" align="right">---------------</td>
			    <td width="100" align="right">---------------</td>
			    <td width="100" align="right"></td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="400" align="right"></td>
			    <td width="100" align="right"></td>
			    <td width="100" align="right"><strong>TOTAL GENERAL : </strong></td>
			    <td width="100" align="right"><strong><? echo $total_causado; ?></strong></td>
			    <td width="100" align="right"><strong><? echo $total_pagado; ?></strong></td>
			    <td width="100" align="right"></td>
			</tr>	
		       <? 					  
		  ?></table><?}
    	      }
              else{
                  /*Rpt_modificaciones_sin*/
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_modificaciones_sin.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
			        <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE DE MODIFICACIONES</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1?></strong></font></td>
				<td width="100" align="left" ><strong></strong></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Referencia</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF" ><strong>Descripcion</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			 </tr>
			 <tr height="20">
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Codigo Presupuestario</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Denominacion Codigo Presupuestario</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>Monto</strong></td>
			 </tr>
		  <?  $i=0; $total_ajustado=0; $sub_total_ajustado=0; $cantidad_ordenes=""; $prev_fecha_doc=""; $prev_tipo_compromiso=""; $prev_referencia_comp="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $fecha_doc=$registro["fecha_doc"]; $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_comp=$registro["referencia_comp"]; 				$ced_rif=$registro["ced_rif"]; $nombre_benef=$registro["nombre_benef"];$descripcion_doc=$registro["descripcion_doc"]; 
			$fecha_doc=formato_ddmmaaaa($fecha_doc); $cantidad_ordenes=$cantidad_ordenes+1;
			$fecha_doc_grupo=$fecha_doc; $tipo_compromiso_grupo=$tipo_compromiso; $referencia_comp_grupo=$referencia_comp; $ced_rif_grupo=$ced_rif; 
			 $descripcion_doc_grupo=$descripcion_doc; $nombre_benef_grupo=$nombre_benef;

			   if(($prev_fecha_doc<>$fecha_doc_grupo)or($prev_tipo_compromiso<>$tipo_compromiso_grupo)or($prev_referencia_comp<>$referencia_comp_grupo)){
			    if($sub_total_ajustado>0){ $sub_total_ajustado=formato_monto($sub_total_ajustado); 		
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			           <td width="100" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			           <td width="100" align="right"><? echo $sub_total_ajustado; ?></td>
			        </tr>	
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			      ?>	   
			      <tr>
				   <td width="100" align="left">'<? echo $referencia_comp_grupo; ?></td>
				   <td width="100" align="left"><? echo $fecha_doc_grupo; ?></td>
				   <td width="400" align="left"><? echo $descripcion_doc_grupo; ?></td>
			      </tr>	
			     <? 					 
			    $prev_fecha_doc=$fecha_doc_grupo; $prev_tipo_compromiso=$tipo_compromiso_grupo; $prev_referencia_comp=$referencia_comp_grupo; $sub_total_ajustado=0; }

		           $fecha_doc=$registro["fecha_doc"]; $tipo_compromiso=$registro["tipo_compromiso"]; $referencia_comp=$registro["referencia_comp"]; 
			   $descripcion_doc=$registro["descripcion_doc"]; $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"];  				   $ajustado=$registro["ajustado"]; $func_inv=$registro["func_inv"]; $monto=$registro["monto"]; $comprometido=$registro["comprometido"];
			   $total_ajustado=$total_ajustado+$ajustado; $sub_total_ajustado=$sub_total_ajustado+$ajustado; 
			   $ajustado=formato_monto($ajustado); $monto=formato_monto($monto); $comprometido=formato_monto($comprometido); $fecha_doc=formato_ddmmaaaa($fecha_doc);	
			   if($func_inv=="+"){$resultado=$monto;}else{$resultado=$comprometido;}		   
			   $descripcion_doc=conv_cadenas($descripcion_doc,0);$denominacion=conv_cadenas($denominacion,0); 
			   ?>	   
				<tr>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_presup; ?></td>
				   <td width="100" align="left">'<? echo $fuente_financ; ?></td>
				   <td width="400" align="justify"><? echo $denominacion; ?></td>
				   <td width="100" align="right"><? echo $resultado; ?></td>
				 </tr>
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
			   <? 	

		  }$total_ajustado=formato_monto($total_ajustado);  
		     if($sub_total_ajustado>0){ $sub_total_ajustado=formato_monto($sub_total_ajustado); 		
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			           <td width="100" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="right"></td>
			           <td width="100" align="right"><? echo $sub_total_ajustado; ?></td>
			        </tr>			
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="right">---------------</td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="right"></td>
			    <td width="400" align="right"><strong>TOTAL GENERAL : </strong></td>
			    <td width="100" align="right"><strong><? echo $total_ajustado; ?></strong></td>
			</tr>	
		       <? 				  
		  ?></table><?} 
    }
   }
   $StrSQL = "DELETE FROM pre021 Where (Tipo_Registro='M') And (nombre_usuario='".$cod_mov."')";$res=pg_exec($conn,$StrSQL);
}
?>
