<? include ("../../class/conect.php");  require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php");  include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"];   $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist=$_GET["act_hist"]; $fecha_nom=$_GET["fecha_nom"]; $tipo_rpt=$_GET["tipo_rpt"];
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_concepto=$_GET["tipo_concepto"];
   $forma_pago=$_GET["forma_pago"];$tipo_reporte=$_GET["tipo_reporte"];$tipo_calculo=$_GET["tipo_calculo"];$tipo_monto=$_GET["tipo_monto"]; $num_periodos=$_GET["num_periodos"];
   $rango_f=$_GET["rango_f"]; $fecha_desde=$_GET["fecha_desde"];  $fecha_hasta=$_GET["fecha_hasta"];  $cfechad=formato_aaaammdd($fecha_desde); $cfechah=formato_aaaammdd($fecha_hasta);
   $cfechan=formato_aaaammdd($fecha_nom);  $criterio3="FECHA AL ".$fecha_nom;
   $Sql="";$date = date("d-m-Y"); $hora = date("h:i:s a"); $cfechan=formato_aaaammdd($fecha_nom);    
   if($tipo_reporte=='N'){$criterio1="RELACION DE CONCEPTOS";}   else{$criterio1="RELACION DE CONCEPTOS (PRE-NOMINA)";}   
   $criterio2="NOMINA ORDINARIA";  $criterio="rpt_nom_cal WHERE (oculto='NO') and (cod_concepto<>'VVV') ";
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (oculto='NO') and (cod_concepto<>'VVV') ";}
   if($rango_f=='S'){ $act_hist='S';  $mes_comp='S'; $criterio="rpt_nom_hist WHERE (fecha_p_hasta>='".$cfechad."') and (fecha_p_hasta<='".$cfechah."') and (oculto='NO')  ";   
                      $criterio3="FECHA: ".$fecha_desde." AL ".$fecha_hasta;	}
   if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and (concepto_vac='N') ";}   
   $nom_rpt="Rpt_rela_concep_rn.xml";   $ordenar=" order by tipo_nomina, cod_concepto,partida,cod_empleado";   
   if($tipo_monto=="PRI"){ $criterio1=$criterio1." PRIMERA QUINCENA";} if($tipo_monto=="SEG"){ $criterio1=$criterio1." SEGUNDA QUINCENA";}
   
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
    $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
    $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; $mdes_cat[1]=$registro["campo505"]; $mdes_cat[2]=$registro["campo507"]; $mdes_cat[3]=$registro["campo509"]; $mdes_cat[4]=$registro["campo511"]; $mdes_cat[5]=$registro["campo512"];}
    $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+1;
    $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria);    
	if($tipo_nomina_d<>$tipo_nomina_h){$nom_rpt="Rpt_rela_concagrup_rn.xml"; $ordenar=" order by cod_concepto,partida,cod_empleado";
	  $sql="SELECT tipo_nomina,descripcion,desc_grupo from nom001 where tipo_nomina='$tipo_nomina_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$criterio2=$registro["desc_grupo"];}
	}
  	if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and (concepto_vac='S') "; $criterio2="NOMINA DE VACACIONES";}
	
	
	$cri_tp=" and (tp_calculo='".$tipo_calculo."') ";  
    if($tipo_calculo=="E") { $cri_tp=" and ((tp_calculo='E')and(num_periodos=$num_periodos))  "; } 
    $criterio=$criterio.$cri_tp." and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and
	  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') ";
	
	$cant_vacantes=0; $monto_vacantes=0; 
	if($Cod_Emp=="02"){   $criteriob="rpt_nom_cal WHERE (oculto='NO')  ";  $tipo_rpt="PDF2";
       if($act_hist=='S'){$criteriob="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (oculto='NO')  ";}
	   $criteriob=$criteriob." and (tp_calculo='".$tipo_calculo."') and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and
	  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') ";
	  $sqlv="SELECT * FROM ".$criteriob." and (status_emp='VACANTE') " ; $resp=pg_query($sqlv); $filasb=pg_num_rows($resp);  // echo $filasb." ".$sqlv;
	  if($filasb>0){ $sqlv="SELECT count(distinct cod_empleado) as cant_vacantes  FROM ".$criteriob." and status_emp='VACANTE'" ;
		$res=pg_query($sqlv); if($reg=pg_fetch_array($res,0)){$cant_vacantes=$reg["cant_vacantes"]; } else { $cant_vacantes=0; }	
		$sqlv="SELECT sum(sueldo_cargo) as monto_vacantes  FROM ".$criteriob." and status_emp='VACANTE'" ;
		$res=pg_query($sqlv); if($reg=pg_fetch_array($res,0)){$monto_vacantes=$reg["monto_vacantes"]; } else { $monto_vacantes=0; }
		
		}
	}
	$cant_activos=0;
	$Sql = "SELECT count(distinct cod_empleado) as cant_trab  FROM ".$criterio ;
    $res=pg_query($Sql); $filas=pg_num_rows($res); if($filas>0){ $registro=pg_fetch_array($res,0); $cant_activos=$registro["cant_trab"];  }	
	
	$sSQL = "SELECT *  FROM ".$criterio.$ordenar;
   if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
      //echo $sqlv;
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
		function Header(){ global $criterio1; global $tipo_nomina; global $criterio2;  global $des_nomina; global $fechad; global $fechah; global $tipo_nomina_d; global $tipo_nomina_h; global $rango_f; global $criterio3;
			$this->Image('../../imagenes/Logo_emp.png',7,7,25);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(150,7,$criterio1,1,0,'C');
			$this->Ln(17);
			$this->SetFont('Arial','B',8);
			if($tipo_nomina_d==$tipo_nomina_h){	$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');}
			else{$this->Cell(140,5,$criterio2,0,1,'L');}
			if($rango_f=='S'){$this->Cell(140,5,$criterio3,0,1,'L');}else{$this->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');}	
			$this->Cell(12,5,'Codigo',1,0);
			$this->Cell(100,5,'Descripcion del Concepto',1,0,'L');
			$this->Cell(14,5,'Cantidad',1,0);
			$this->Cell(30,5,'Partida Presup',1,0);
			$this->Cell(22,5,'Asignaciones',1,0);
			$this->Cell(22,5,'Deducciones',1,1);
			
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
	  $i=0; $can_conc=0; $totala_nom=0; $totald_nom=0; $cant_nom=0;	$totala_dep=0; $totald_dep=0; $cant_dep=0;  $totala_emp=0; $totald_emp=0; 
	  $totala_conc=0; $totald_conc=0; $prev_conc=""; $den_conc=""; $prev_part="";$prev_grupo="";
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $partida=$registro["partida"]; $cod_presup=$registro["cod_presup"]; $afecta_presup=$registro["afecta_presup"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
		$valorz=$registro["valorz"]; $monto=$registro["monto"]; $asig_ded_apo=$registro["asig_ded_apo"];  $grupo=$cod_concepto.$partida;
		if($tipo_monto=="PRI"){  $monto_asignacion=0; $monto_deduccion=0; if($asig_ded_apo=="A"){$monto_asignacion=$valorz;} if($asig_ded_apo=="D"){$monto_deduccion=$valorz;} }
		if($tipo_monto=="SEG"){  $monto_asignacion=0; $monto_deduccion=0; if($asig_ded_apo=="A"){$monto_asignacion=$monto-$valorz;} if($asig_ded_apo=="D"){$monto_deduccion=$monto-$valorz;} }
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_cargo=utf8_decode($des_cargo);  $des_departam=utf8_decode($des_departam);  $nombre=utf8_decode($nombre); $denominacion=utf8_decode($denominacion);}
		//if($prev_conc<>$cod_concepto){
        if($prev_grupo<>$grupo){			
		  if($prev_conc<>""){$neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);}
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(12,4,$prev_conc,0,0);
			$pdf->Cell(100,4,$den_conc,0,0,'L');
			$pdf->Cell(14,4,$can_conc."  ",0,0,'R');
			$pdf->Cell(30,4,$prev_part,0,0);
			$pdf->Cell(22,4,$totala_conc,0,0,'R');
			$pdf->Cell(22,4,$totald_conc,0,1,'R'); }
		    $sql2="Select cod_concepto,denominacion from NOM002 WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto'"; $res2=pg_query($sql2);  $filas2=pg_num_rows($res2); if($filas2>0){$reg2=pg_fetch_array($res2,0); $denominacion=$reg2["denominacion"]; if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion);} }
			$prev_conc=$cod_concepto; $den_conc=$denominacion; if($afecta_presup="NO"){ $prev_part=substr($cod_presup,$ini,20);} else { $prev_part=substr($cod_presup,$ini,$p);} 	$totala_conc=0; $totald_conc=0;  $can_conc=0;
		    $prev_grupo=$grupo;
		}	
		$can_conc=$can_conc+1; $totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;		
		$totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;
		$totala_nom=$totala_nom+$monto_asignacion; $totald_nom=$totald_nom+$monto_deduccion;
		$totala_dep=$totala_dep+$monto_asignacion; $totald_dep=$totald_dep+$monto_deduccion;
      } $neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} 
	  if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);}
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(12,4,$prev_conc,0,0);
		$pdf->Cell(100,4,$den_conc,0,0,'L');
		$pdf->Cell(14,4,$can_conc."  ",0,0,'R');
		$pdf->Cell(30,4,$prev_part,0,0);
		$pdf->Cell(22,4,$totala_conc,0,0,'R');
		$pdf->Cell(22,4,$totald_conc,0,1,'R');			         
		$neto=$totala_nom-$totald_nom; $neto=formato_monto($neto);
		$totala_nom=formato_monto($totala_nom); $totald_nom=formato_monto($totald_nom);			
		$pdf->SetFont('Arial','B',8);  
		$pdf->Cell(156,2,'',0,0);
		$pdf->Cell(22,2,'=============',0,0,'R');
		$pdf->Cell(22,2,'=============',0,1,'R');						
		$pdf->Cell(156,4,' ',0,0,'R');		
		$pdf->Cell(22,4,$totala_nom,0,0,'R');
		$pdf->Cell(22,4,$totald_nom,0,1,'R');
		$pdf->SetFont('Arial','B',9);  
		$pdf->Ln(3);
		$pdf->Cell(178,2,'',0,0);
		$pdf->Cell(22,2,'=============',0,1,'R');
		$pdf->Cell(178,4,'TOTAL NETO A COBRAR : ',0,0,'R');
		$pdf->Cell(22,4,$neto,0,1,'R');

	$y=$pdf->GetY();  $t=10;
        if($y>230){$t=30; $pdf->Cell(5,4,'',0,1);  } 
        $pdf->ln($t); $y=$pdf->GetY();
	    if($y<235){$t=235-$y; $pdf->ln($t);} 
		$pdf->SetFont('Arial','',7);
        $pdf->Cell(45,4,'Elaborado por','T',0,'C');
        $pdf->Cell(5,4,'',0,0);
        $pdf->Cell(45,4,'Revisado por','T',0,'C');
        $pdf->Cell(5,4,'',0,0);
		$pdf->Cell(45,4,'Aprobado por ','T',1,'C');
        $pdf->Cell(50,3,'Lcda. María Pereza',0,0,'C'); //nmdb (20171121) Arendriz Chirinos
		$pdf->Cell(50,3,'T.S.U Arendriz Chirinos',0,0,'C'); //nmdb (20171121) Zuleima Rivas
		$pdf->Cell(50,3,'Lcdo. Jose Medina',0,0,'C');
        

	  $pdf->Output();   
    }
	
	
	
	if(($tipo_rpt=="PDF2")){$res=pg_query($sSQL); $filas=pg_num_rows($res);
      $prev_tipo=""; $prev_den_nom=""; $prev_conc=""; $den_conc=""; $prev_emp="";       $cod_empleado=""; $tipo_nomina=""; $des_nomina="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; 
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $denominacion=utf8_decode($denominacion);}
        $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_emp="";
	  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tipo_nomina; global $criterio2;  global $des_nomina; global $fechad; global $fechah; global $tipo_nomina_d; global $tipo_nomina_h; global $rango_f; global $criterio3;
			$this->Image('../../imagenes/Logo_emp.png',7,7,25);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(150,7,$criterio1,1,0,'C');
			$this->Ln(17);
			$this->SetFont('Arial','B',8);
			if($tipo_nomina_d==$tipo_nomina_h){	$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');}
			else{$this->Cell(140,5,$criterio2,0,1,'L');}
			if($rango_f=='S'){$this->Cell(140,5,$criterio3,0,1,'L');}else{$this->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');}	
			$this->Cell(12,5,'Codigo',1,0);
			$this->Cell(130,5,'Descripcion del Concepto',1,0,'L');
			$this->Cell(14,5,'Cantidad',1,0);
			$this->Cell(22,5,'Asignaciones',1,0);
			$this->Cell(22,5,'Deducciones',1,1);
			
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-7);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			//$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
	  $pdf->SetAutoPageBreak(true, 7);  
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0; $can_conc=0; $totala_nom=0; $totald_nom=0; $cant_nom=0;	$totala_dep=0; $totald_dep=0; $cant_dep=0;  $totala_emp=0; $totald_emp=0; 
	  $totala_conc=0; $totald_conc=0; $prev_conc=""; $den_conc=""; $prev_part="";$prev_grupo="";
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $partida=$registro["partida"]; $cod_presup=$registro["cod_presup"]; $afecta_presup=$registro["afecta_presup"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
		$valorz=$registro["valorz"]; $monto=$registro["monto"]; $asig_ded_apo=$registro["asig_ded_apo"];  $grupo=$cod_concepto.$partida;
		if($tipo_monto=="PRI"){  $monto_asignacion=0; $monto_deduccion=0; if($asig_ded_apo=="A"){$monto_asignacion=$valorz;} if($asig_ded_apo=="D"){$monto_deduccion=$valorz;} }
		if($tipo_monto=="SEG"){  $monto_asignacion=0; $monto_deduccion=0; if($asig_ded_apo=="A"){$monto_asignacion=$monto-$valorz;} if($asig_ded_apo=="D"){$monto_deduccion=$monto-$valorz;} }
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_cargo=utf8_decode($des_cargo);  $des_departam=utf8_decode($des_departam);  $nombre=utf8_decode($nombre); $denominacion=utf8_decode($denominacion);}
		//if($prev_conc<>$cod_concepto){
        if($prev_grupo<>$grupo){			
		  if($prev_conc<>""){$neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);}
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(12,4,$prev_conc,0,0);
			$pdf->Cell(130,4,$den_conc,0,0,'L');
			$pdf->Cell(14,4,$can_conc."  ",0,0,'R');
			$pdf->Cell(22,4,$totala_conc,0,0,'R');
			$pdf->Cell(22,4,$totald_conc,0,1,'R'); }
		    $sql2="Select cod_concepto,denominacion from NOM002 WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto'"; $res2=pg_query($sql2);  $filas2=pg_num_rows($res2); if($filas2>0){$reg2=pg_fetch_array($res2,0); $denominacion=$reg2["denominacion"]; if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion);} }
			$prev_conc=$cod_concepto; $den_conc=$denominacion; if($afecta_presup="NO"){ $prev_part=substr($cod_presup,$ini,20);} else { $prev_part=substr($cod_presup,$ini,$p);} 	$totala_conc=0; $totald_conc=0;  $can_conc=0;
		    $prev_grupo=$grupo;
		}	
		$can_conc=$can_conc+1; $totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;		
		$totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;
		$totala_nom=$totala_nom+$monto_asignacion; $totald_nom=$totald_nom+$monto_deduccion;
		$totala_dep=$totala_dep+$monto_asignacion; $totald_dep=$totald_dep+$monto_deduccion;
      } $neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} 
	  if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);}
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(12,4,$prev_conc,0,0);
		$pdf->Cell(130,4,$den_conc,0,0,'L');
		$pdf->Cell(14,4,$can_conc."  ",0,0,'R');
		$pdf->Cell(22,4,$totala_conc,0,0,'R');
		$pdf->Cell(22,4,$totald_conc,0,1,'R');			         
		$neto=$totala_nom-$totald_nom; $neto=formato_monto($neto);
		$totala_nom=formato_monto($totala_nom); $totald_nom=formato_monto($totald_nom);			
		$pdf->SetFont('Arial','B',8);  
		$pdf->Cell(156,2,'',0,0);
		$pdf->Cell(22,2,'=============',0,0,'R');
		$pdf->Cell(22,2,'=============',0,1,'R');						
		$pdf->Cell(156,4,' ',0,0,'R');		
		$pdf->Cell(22,4,$totala_nom,0,0,'R');
		$pdf->Cell(22,4,$totald_nom,0,1,'R');
		$pdf->SetFont('Arial','B',9);  
		$pdf->Ln(3);
		$pdf->Cell(178,2,'',0,0);
		$pdf->Cell(22,2,'=============',0,1,'R');
		$pdf->Cell(178,4,'TOTAL NETO A COBRAR : ',0,0,'R');
		$pdf->Cell(22,4,$neto,0,1,'R');
		
		
	   $pdf->Ln(3);
	   if($estatus_trab_d=='TODOS'){$statusr="";}else{$statusr." and (status_emp='".$estatus_trab_d."') ";}
	   if($tipo_concepto=="NOMINA"){$statusr=$statusr." and (concepto_vac='N') ";}
	   if($tipo_concepto=="VACACIONES"){$statusr=$statusr." and (concepto_vac='S') ";}   
	   if($rango_f=='S'){ $act_hist='S'; $statusr=$statusr." and (fecha_p_hasta>='".$cfechad."') and (fecha_p_hasta<='".$cfechah."')  ";   } 
	   else{ if($act_hist=='S'){$statusr=$statusr." and (fecha_p_hasta='".$cfechan."') ";}  }   
	   $statusr=$statusr." and (afecta_presup='SI') ";   
	   if($forma_pago=='TODOS'){$statusr=$statusr;}else{$statusr=$statusr." and (tipo_pago='".$forma_pago."') ";}  
		
		 $StrSQLp = "delete from nom016 where (linea='000' or  linea='001') and tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."'";
		 $resp=pg_exec($conn,$StrSQLp); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$resp){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
         if($act_hist=='S'){$sSQLp = "SELECT nom019.tipo_nomina, nom019.des_Nomina, nom019.fecha_desde, nom019.fecha_Hasta, nom019.cod_concepto, nom019.denominacion, nom019.cod_Empleado, nom019.Nombre, nom019.Asignacion, nom019.Monto_Asignacion, nom019.Monto_deduccion, nom019.Oculto, nom019.Monto, nom019.cod_presup, nom019.fecha_p_Hasta, nom019.Tp_calculo, nom019.desc_Grupo,
                   nom019.Afecta_presup,nom019.cod_Retencion,  nom019.Asig_ded_Apo,to_char(nom019.fecha_hasta,'DD/MM/YYYY') as fechah,to_char(nom019.fecha_desde,'DD/MM/YYYY') as fechad, pre022.cod_presup_p, pre022.cod_fuente_p, pre022.denominacion_p
                   FROM nom019 left join pre022 on (nom019.cod_presup=pre022.cod_presup_p and nom019.cod_contable=pre022.cod_fuente_p)
                   WHERE  ((nom019.cod_concepto<>'VVV') and (nom019.oculto='NO') and (nom019.monto>0)) and nom019.tipo_nomina>='".$tipo_nomina_d."' and nom019.tipo_nomina<='".$tipo_nomina_h."' and nom019.tp_calculo='".$tipo_calculo."' ".$statusr. " order by nom019.cod_presup, nom019.tipo_nomina, nom019.cod_concepto"; 
				$StrSQLp = "INSERT INTO nom016 select tipo_nomina, fecha_p_hasta, cod_empleado, '000', num_recibo, fecha_hasta, fecha_desde, fecha_proceso, tp_calculo, num_periodos,  cod_grupo, desc_grupo, nombre, cedula, fecha_ingreso, status_emp, cod_concepto, denominacion, cantidad, monto_orig, monto_asignacion, 
					acumulado, saldo, valore, valoru, valorq, valorw, valorx, valory, valorz, cod_concepto, denominacion, cantidad, monto_orig,  monto_deduccion, acumulado, saldo, valore, valoru, valorq, valorw, valorx, valory, valorz, monto,asignacion,oculto,tipo_asigna,asig_ded_apo, frecuencia, nro_semana, cod_cargo, 
					des_cargo, sueldo_cargo, prima_cargo, compensa_cargo, sueldo_integral,  otros, cod_departam, des_departam, cod_presup, cod_contable, tipo_pago, cta_empleado, cta_empresa, nombre_banco, afecta_presup,cod_retencion, codigo_ubicacion, descripcion_ubi, des_nomina 
					FROM nom019 WHERE  ((nom019.cod_concepto<>'VVV') and (nom019.oculto='NO') and (nom019.monto>0)) and nom019.tipo_nomina>='".$tipo_nomina_d."' and nom019.tipo_nomina<='".$tipo_nomina_h."' and nom019.Tp_calculo='".$tipo_calculo."' ".$statusr; 
				   }
		   else{ $sSQLp = "SELECT nom017.tipo_nomina, nom017.des_Nomina, nom017.fecha_desde, nom017.fecha_Hasta, nom017.cod_concepto, nom017.denominacion, nom017.cod_Empleado, nom017.Nombre, nom017.Asignacion, nom017.Monto_Asignacion, nom017.Monto_deduccion, nom017.Oculto, nom017.Monto, nom017.cod_presup, nom017.fecha_p_Hasta, nom017.Tp_calculo, nom017.desc_Grupo,
                   nom017.Afecta_presup,nom017.cod_Retencion,  nom017.Asig_ded_Apo,to_char(nom017.fecha_hasta,'DD/MM/YYYY') as fechah,to_char(nom017.fecha_desde,'DD/MM/YYYY') as fechad, pre022.cod_presup_p, pre022.cod_fuente_p, pre022.denominacion_p
                   FROM nom017 left join pre022 on (nom017.cod_presup=pre022.cod_presup_p and nom017.cod_contable=pre022.cod_fuente_p)
                   WHERE  ((nom017.cod_concepto<>'VVV') and (nom017.oculto='NO') and (nom017.monto>0)) and  nom017.tipo_nomina>='".$tipo_nomina_d."' and nom017.tipo_nomina<='".$tipo_nomina_h."' and nom017.tp_calculo='".$tipo_calculo."' ".$statusr." order by nom017.cod_presup, nom017.tipo_nomina, nom017.cod_concepto";
				$StrSQLp = "INSERT INTO nom016 select tipo_nomina, fecha_p_hasta, cod_empleado, '000', num_recibo, fecha_hasta, fecha_desde, fecha_proceso, tp_calculo, num_periodos,  cod_grupo, desc_grupo, nombre, cedula, fecha_ingreso, status_emp, cod_concepto, denominacion, cantidad, monto_orig, monto_asignacion, 
					acumulado, saldo, valore, valoru, valorq, valorw, valorx, valory, valorz, cod_concepto, denominacion, cantidad, monto_orig,  monto_deduccion, acumulado, saldo, valore, valoru, valorq, valorw, valorx, valory, valorz, monto,asignacion,oculto,tipo_asigna,asig_ded_apo, frecuencia, nro_semana, cod_cargo, 
					des_cargo, sueldo_cargo, prima_cargo, compensa_cargo, sueldo_integral,  otros, cod_departam, des_departam, cod_presup, cod_contable, tipo_pago, cta_empleado, cta_empresa, nombre_banco, afecta_presup,cod_retencion, codigo_ubicacion, descripcion_ubi, des_nomina 
					FROM nom017 WHERE  ((nom017.cod_concepto<>'VVV') and (nom017.oculto='NO') and (nom017.monto>0)) and nom017.tipo_nomina>='".$tipo_nomina_d."' and nom017.tipo_nomina<='".$tipo_nomina_h."' and nom017.Tp_calculo='".$tipo_calculo."' ".$statusr;
					}
		$temp=$StrSQLp;	$resp=pg_exec($conn,$StrSQLp); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$resp){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }    
        /* */
		$StrSQLp="update nom016 set monto1=monto*-1,monto2=0,linea='001' where asignacion='NO' and cod_retencion='000'";	$resp=pg_exec($conn,$StrSQLp); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$resp){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }    
		$sSQLp="SELECT nom016.linea,nom016.tipo_nomina,nom016.des_Nomina, nom016.fecha_desde, nom016.fecha_Hasta, nom016.cod_concepto1 as cod_concepto, nom016.denominacion1 as denominacion, nom016.cod_Empleado, nom016.Nombre, nom016.Asignacion, nom016.monto1 as monto_asignacion, nom016.monto2 as monto_deduccion, nom016.Oculto, nom016.Monto, nom016.cod_presup, nom016.cod_contable, nom016.fecha_p_Hasta, nom016.Tp_calculo, nom016.desc_Grupo,
                   nom016.Afecta_presup,nom016.cod_Retencion,nom016.Asig_ded_Apo,to_char(nom016.fecha_p_hasta,'DD/MM/YYYY') as fechaph,to_char(nom016.fecha_hasta,'DD/MM/YYYY') as fechah,to_char(nom016.fecha_desde,'DD/MM/YYYY') as fechad, pre022.cod_presup_p, pre022.cod_fuente_p, pre022.denominacion_p
                   FROM nom016 left join pre022 on (nom016.cod_presup=pre022.cod_presup_p and nom016.cod_contable=pre022.cod_fuente_p)  where (linea='000' or linea='001') and tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."' order by cod_presup,cod_contable,linea,tipo_nomina,cod_concepto,cod_empleado";
        $pdf->SetFont('Arial','B',9); 
		$pdf->Cell(50,4,'',0,0,'L');
		$pdf->Cell(50,4,'CODIGO PRESUPUESTARIO','B',0,'L');
		$pdf->Cell(25,4,'MONTO','B',1,'C');
		$pdf->SetFont('Arial','',9); 
		$i=0;  $total_monto_asignacion=0; $total_monto_deduccion=0; $total_monto=0; $sub_total_monto_asignacion=""; $sub_total_monto_deduccion=""; $sub_total_monto=""; $prev_cod_presup=""; $prev_cod_contable=""; $prev_linea=""; $prev_denominacion_p=""; $prev_cod_grupo="";
	    $resp=pg_query($sSQLp);
	    //$pdf->MultiCell(200,4,$temp,0);
	    while($regp=pg_fetch_array($resp)){ $i=$i+1; $cod_presup=$regp["cod_presup"]; $cod_contable=$regp["cod_contable"];  $denominacion_p=$regp["denominacion_p"]; $linea=$regp["linea"];
		   if($php_os=="WINNT"){$denominacion_p=$regp["denominacion_p"];}else{$denominacion_p=utf8_decode($regp["denominacion_p"]); }
		   $cod_presup_grupo=$cod_presup.$cod_contable;  $denominacion_p_grupo=$denominacion_p;  
		   if($prev_cod_grupo<>$cod_presup_grupo){ 
			 if(($sub_total_monto_asignacion<>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){ $sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion);	$sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto=formato_monto($sub_total_monto);				    
				$pdf->Cell(50,4,'',0,0,'L');
				//$pdf->Cell(50,4,$prev_cod_presup."  ".$prev_cod_contable,0,0,'L');
				$pdf->Cell(50,4,$prev_cod_presup,0,0,'L');
		   		$pdf->Cell(25,4,$sub_total_monto_asignacion,0,1,'R'); 
			 }	
			 $prev_cod_grupo=$cod_presup_grupo; $prev_cod_presup=$cod_presup; $prev_cod_contable=$cod_contable; $prev_linea=$linea; $prev_denominacion_p=$denominacion_p_grupo; $sub_total_monto_asignacion=0; $sub_total_monto_deduccion=0; $sub_total_monto=0;
		   }
		   $cod_presup=$regp["cod_presup"]; $denominacion_p=$regp["denominacion_p"]; $monto_asignacion=$regp["monto_asignacion"]; $monto_deduccion=$regp["monto_deduccion"]; 
		   $total_monto_asignacion=$total_monto_asignacion+$monto_asignacion;  $total_monto_deduccion=$total_monto_deduccion+$monto_deduccion; 
		   $total_monto=$total_monto+$monto_asignacion-$monto_deduccion;  $sub_total_monto_asignacion=$sub_total_monto_asignacion+$monto_asignacion; 
		   $sub_total_monto_deduccion=$sub_total_monto_deduccion+$monto_deduccion; $sub_total_monto=$sub_total_monto+$monto_asignacion-$monto_deduccion;
		   $monto_asignacion=formato_monto($monto_asignacion); $monto_deduccion=formato_monto($monto_deduccion); 
		   if($php_os=="WINNT"){$denominacion_p=$regp["denominacion_p"]; }   else{$denominacion_p=utf8_decode($denominacion_p); $denominacion_p=utf8_decode($denominacion_p);}
		} 
		if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){ $sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion);	$sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto=formato_monto($sub_total_monto);				    
			$pdf->Cell(50,4,'',0,0,'L');
			//$pdf->Cell(50,4,$prev_cod_presup."  ".$prev_cod_contable,0,0,'L');
			$pdf->Cell(50,4,$prev_cod_presup,0,0,'L');
		   	$pdf->Cell(25,4,$sub_total_monto_asignacion,0,1,'R'); 	
		}
		$total_monto_asignacion=formato_monto($total_monto_asignacion); $monto_vacantes=$monto_vacantes/2; $monto_vacantes=formato_monto($monto_vacantes);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(100,3,'',0,0);
		$pdf->Cell(25,3,'=============',0,1,'R');
		$pdf->Cell(100,5,'TOTAL CODIGOS : ',0,0,'R');
		$pdf->Cell(25,5,$total_monto_asignacion,0,1,'R');
		$pdf->Ln(5);
        $pdf->SetFont('Arial','B',8);
		$cant_trab=$cant_activos+$cant_vacantes;
		$pdf->Cell(40,3,'TOTAL TRABAJADORES : ',0,0);		    
		$pdf->Cell(20,3,$cant_trab,0,0);
		$pdf->Cell(30,3,'TOTAL ACTIVOS : ',0,0);		    
		$pdf->Cell(20,3,$cant_activos,0,0);
		$pdf->Cell(30,3,'TOTAL VACANTES : ',0,0);		    
		$pdf->Cell(10,3,$cant_vacantes,0,0);
		$pdf->Cell(15,3,'Monto : ',0,0);	
		$pdf->Cell(20,3,$monto_vacantes,0,1);
		
		
 //  ESTO ES PARA LA FIRMA AL FINAL
        $y=$pdf->GetY();  $t=10;
        if($y>230){$t=30; $pdf->Cell(5,4,'',0,1);  } 
        $pdf->ln($t); $y=$pdf->GetY();
	    if($y<255){$t=255-$y; $pdf->ln($t);} 
		$pdf->SetFont('Arial','',7);

	    $pdf->Cell(45,4,'Elaborado por','T',0,'C');
	    $pdf->Cell(5,4,'',0,0);
	    $pdf->Cell(45,4,'Revisado por','T',0,'C');
	    $pdf->Cell(5,4,'',0,0);
		$pdf->Cell(45,4,'Aprobado por ','T',1,'C');
		/*INI modificación: Elaborado (30-10-2017): (T.S.U Arendriz Chirinos), Revisado (Lcda. Zuleima Rivaz): nmdb */
	    $pdf->Cell(50,3,'Lcda. María Peraza',0,0,'C');
		$pdf->Cell(50,3,'T.S.U Arendriz Chirinos',0,0,'C');
		/*FIN modificación (30-10-2017): Elaborado: (T.S.U Arendriz Chirinos), Revisado (Lcda. Zuleima Rivaz): nmdb */
		$pdf->Cell(50,3,'Lcdo. Jose Medina',0,0,'C');

  		$pdf->Output();   
    }
}
?>
