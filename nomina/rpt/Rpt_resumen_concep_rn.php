<? include ("../../class/conect.php");  require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php");  include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"];   $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist=$_GET["act_hist"]; $fecha_nom=$_GET["fecha_nom"]; $tipo_rpt=$_GET["tipo_rpt"];
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_concepto=$_GET["tipo_concepto"]; $tipo_resumen=$_GET["tipo_resumen"]; 
   $forma_pago=$_GET["forma_pago"];$tipo_reporte=$_GET["tipo_reporte"];$tipo_calculo=$_GET["tipo_calculo"];$tipo_monto=$_GET["tipo_monto"];  $num_periodos=$_GET["num_periodos"];
   $Sql="";$date = date("d-m-Y"); $hora = date("h:i:s a"); $cfechan=formato_aaaammdd($fecha_nom);  
   if($tipo_reporte=='N'){$criterio1="RELACION DE CONCEPTOS";}   else{$criterio1="RELACION DE CONCEPTOS (PRE-NOMINA)";}   
   $criterio2="NOMINA ORDINARIA";
   $criterio="rpt_nom_cal WHERE (cod_concepto<>'VVV') ";
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (cod_concepto<>'VVV') ";} 
   if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and (concepto_vac='N') ";}   
   
   $criterio1="RESUMEN DE NOMINA";
   if($tipo_resumen=="A"){$criterio=$criterio." and ((oculto='NO') and (asig_ded_apo='A')) ";  $criterio1="RESUMEN DE ASIGNACIONES";}
   if($tipo_resumen=="D"){$criterio=$criterio." and ((oculto='NO') and (asig_ded_apo='D')) ";  $criterio1="RESUMEN DE DEDUCCIONES";}   
   if($tipo_resumen=="P"){$criterio=$criterio." and ((oculto='SI') and (asig_ded_apo='P')) ";  $criterio1="RESUMEN DE APORTES";}
   if($tipo_resumen=="T"){$criterio=$criterio." and (oculto='NO') ";}
   
   
   $cri_tp=" and (tp_calculo='".$tipo_calculo."') ";  
   if($tipo_calculo=="E") { $cri_tp=" and ((tp_calculo='E')and(num_periodos=$num_periodos))  "; } 
   $criterio=$criterio.$cri_tp." and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."')  ";
   
   
   $nom_rpt="Rpt_resu_concep_rn.xml";   $ordenar=" order by tipo_nomina, cod_concepto, cod_empleado";   
   if($tipo_monto=="PRI"){ $criterio1=$criterio1." PRIMERA QUINCENA";} if($tipo_monto=="SEG"){ $criterio1=$criterio1." SEGUNDA QUINCENA";}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}

    $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
    $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; $mdes_cat[1]=$registro["campo505"]; $mdes_cat[2]=$registro["campo507"]; $mdes_cat[3]=$registro["campo509"]; $mdes_cat[4]=$registro["campo511"]; $mdes_cat[5]=$registro["campo512"];}
    $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+1;
    $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); 
   
	if($tipo_nomina_d<>$tipo_nomina_h){$nom_rpt="Rpt_resu_concagrup_rn.xml"; $ordenar=" order by cod_concepto, cod_empleado";
	  $sql="SELECT tipo_nomina,descripcion,desc_grupo from nom001 where tipo_nomina='$tipo_nomina_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$criterio2=$registro["desc_grupo"];}
	}
  	if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and (concepto_vac='S') "; $criterio2="NOMINA DE VACACIONES";}
	$sSQL = "SELECT *  FROM ".$criterio." and (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') ".$ordenar;
   if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
	  $oRpt = new PHPReportMaker();
	  $oRpt->setXML($nom_rpt);
	  $oRpt->setUser("$user");
	  $oRpt->setPassword("$password");
	  $oRpt->setConnection("localhost");
	  $oRpt->setDatabaseInterface("postgresql");
	  $oRpt->setSQL($sSQL);
	  $oRpt->setDatabase("$dbname");
	  $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"monto"=>$monto,"date"=>$date,"hora"=>$hora));
	  $oRpt->run();
	  $aBench = $oRpt->getBenchmark();
   }
   if(($tipo_rpt=="PDF")){$res=pg_query($sSQL); $filas=pg_num_rows($res);
      $prev_tipo=""; $prev_den_nom=""; $prev_conc=""; $den_conc=""; $prev_emp="";       $cod_empleado=""; $tipo_nomina=""; $des_nomina="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; 
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $denominacion=utf8_decode($denominacion);}
        $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_emp="";
	  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tipo_nomina; global $criterio2;  global $des_nomina; global $fechad; global $fechah; global $tipo_nomina_d; global $tipo_nomina_h; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(130,7,$criterio1,1,0,'C');
			$this->Ln(17);
			$this->SetFont('Arial','B',8);
			if($tipo_nomina_d==$tipo_nomina_h){	$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');}
			else{$this->Cell(140,5,$criterio2,0,1,'L');}
			$this->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');
			$this->Cell(12,5,'Codigo',1,0);
			$this->Cell(135,5,'Descripcion del Concepto',1,0,'L');
			$this->Cell(27,5,'Cant.Beneficiarios',1,0);
			$this->Cell(25,5,'Monto',1,1);
			
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
	  $i=0; $can_conc=0; $totala_nom=0; $totalm_nom=0; $totald_nom=0; $cant_nom=0;	$totala_dep=0; $totald_dep=0; $cant_dep=0;  $totala_emp=0; $totald_emp=0; 
	  $totala_conc=0; $totald_conc=0; $totalm_conc=0; $prev_conc=""; $den_conc=""; $prev_part="";
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"];  $cod_presup=$registro["cod_presup"]; 
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
		$valorz=$registro["valorz"]; $monto=$registro["monto"]; $asig_ded_apo=$registro["asig_ded_apo"];
		if($tipo_monto=="PRI"){  $monto_asignacion=0; $monto_deduccion=0; if($asig_ded_apo=="A"){$monto_asignacion=$valorz; $monto=$valorz;} if($asig_ded_apo=="D"){$monto_deduccion=$valorz; $monto=$valorz;} }
		if($tipo_monto=="SEG"){  $monto_asignacion=0; $monto_deduccion=0; if($asig_ded_apo=="A"){$monto_asignacion=$monto-$valorz; $monto=$monto-$valorz;} if($asig_ded_apo=="D"){$monto_deduccion=$monto-$valorz; $monto=$monto-$valorz;} }
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_cargo=utf8_decode($des_cargo);  $des_departam=utf8_decode($des_departam);  $nombre=utf8_decode($nombre); $denominacion=utf8_decode($denominacion);}
		if($prev_conc<>$cod_concepto){		
		  if($prev_conc<>""){ $totalm_conc=formato_monto($totalm_conc);
		    if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);}
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(12,5,$prev_conc,0,0);
			$pdf->Cell(143,5,$den_conc,0,0,'L');
			$pdf->Cell(20,5,$can_conc."  ",0,0,'R');
			$pdf->Cell(25,5,$totalm_conc,0,1,'R'); }
		  $prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_part=substr($cod_presup,$ini,$p);	$totala_conc=0; $totald_conc=0;  $can_conc=0; $totalm_conc=0;
		}	
		$can_conc=$can_conc+1; $totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;		
		$totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;
		$totala_nom=$totala_nom+$monto_asignacion; $totald_nom=$totald_nom+$monto_deduccion;
		$totala_dep=$totala_dep+$monto_asignacion; $totald_dep=$totald_dep+$monto_deduccion;
		$totalm_conc=$totalm_conc+$monto; $totalm_nom=$totalm_nom+$monto;
      } $neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} 
	    if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);} $totalm_conc=formato_monto($totalm_conc);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(12,5,$prev_conc,0,0);
		$pdf->Cell(143,5,$den_conc,0,0,'L');
		$pdf->Cell(20,5,$can_conc."  ",0,0,'R');
		$pdf->Cell(25,5,$totalm_conc,0,1,'R');		         
		$neto=$totala_nom-$totald_nom; $neto=formato_monto($neto); $totalm_nom=formato_monto($totalm_nom);
		$totala_nom=formato_monto($totala_nom); $totald_nom=formato_monto($totald_nom);			
		$pdf->SetFont('Arial','B',9);  
		$pdf->Cell(175,2,'',0,0);
		$pdf->Cell(25,2,'=============',0,1,'R');						
		$pdf->Cell(175,4,' ',0,0,'R');	
		$pdf->Cell(25,4,$totalm_nom,0,1,'R');
		$pdf->SetFont('Arial','B',9);  
		
	  $pdf->Output();   
    }
}
?>