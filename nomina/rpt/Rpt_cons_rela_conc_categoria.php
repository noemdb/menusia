<? include ("../../class/conect.php");  require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php");  include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist="S";  $fecha_desde=$_GET["fecha_desde"]; $fecha_hasta=$_GET["fecha_hasta"]; $fecha_nom=$_GET["fecha_hasta"];    
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $tipo_concepto=$_GET["tipo_concepto"]; $tipo_personal_d=$_GET["tipo_personal_d"];   $tipo_personal_h=$_GET["tipo_personal_h"]; 
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"]; $forma_pago=$_GET["forma_pago"];
   $cod_presup_catd=$_GET["cod_presup_catd"];  $cod_presup_cath=$_GET["cod_presup_cath"]; $cod_empleado_d=$_GET["cod_empleado_d"];  $cod_empleado_h=$_GET["cod_empleado_h"];
   $tipo_rpt="PDF"; $esp_firma="SI"; $salto_dep="NO"; $tipo_reporte='N'; $act_hist="N"; $rango_f="N"; $cfechad=formato_aaaammdd($fecha_desde); $cfechah=formato_aaaammdd($fecha_hasta);
   
   $cfechan=formato_aaaammdd($fecha_nom);  $criterio3="FECHA AL ".$fecha_nom;
   $Sql="";$date = date("d-m-Y"); $hora = date("h:i:s a");  $criterio1="RELACION DE CONCEPTOS POR CATEGORIA";

   
   
   
   
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
    $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
    $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; $mdes_cat[1]=$registro["campo505"]; $mdes_cat[2]=$registro["campo507"]; $mdes_cat[3]=$registro["campo509"]; $mdes_cat[4]=$registro["campo511"]; $mdes_cat[5]=$registro["campo512"];}
    $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+1;
    $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria);    
	
	$sql="select fecha_p_hasta from nom017 where (fecha_p_hasta='".$cfechan."') and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') ".$cri_tp;
    $res=pg_query($sql); $filas=pg_num_rows($res); if($filas==0){$act_hist="S";  }   
	
	
	$criterio="rpt_nom_cal WHERE ( ((oculto='NO') and (cod_concepto<>'VVV')) or (asig_ded_apo='P') ) ";
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and ( ((oculto='NO') and (cod_concepto<>'VVV')) or (asig_ded_apo='P') ) ";}   
   if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and (concepto_vac='N') ";}   
   $ordenar=" order by tipo_nomina,cod_categ,asig_ded_apo,cod_concepto,partida,cod_empleado";   
   
   
	$sSQL = "SELECT *  FROM ".$criterio." and (tp_calculo='".$tipo_calculo."') and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and
	  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') ".$ordenar;
   
   if(($tipo_rpt=="PDF")){$res=pg_query($sSQL); $filas=pg_num_rows($res);
      $prev_tipo=""; $prev_den_nom=""; $prev_conc=""; $den_conc=""; $prev_emp="";   $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_cod_categoria=''; $cod_categ='';
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; $cod_categ=$registro["cod_categ"];
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $denominacion=utf8_decode($denominacion);}
        $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_cod_categoria=$cod_categ;
	  }	  
      require('../../class/fpdf/fpdf.php');
	  
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tipo_nomina; global $criterio2;  global $des_nomina; global $fechad; global $fechah; global $tipo_nomina_d; global $tipo_nomina_h; global $rango_f; global $criterio3; global $cod_categ;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(150,7,$criterio1,1,0,'C');
			$this->Ln(17);
			$this->SetFont('Arial','B',8);
			$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');
			$this->Cell(140,5,"CATEGORIA PROGRAMATICA : ".$cod_categ,0,1,'L');
			$this->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');	
			$this->Cell(30,5,'Partida Presup',1,0);
			$this->Cell(104,5,'Descripcion del Concepto',1,0,'L');					
			$this->Cell(22,5,'Asignaciones',1,0);
			$this->Cell(22,5,'Deducciones',1,0);
			$this->Cell(22,5,'Aporte',1,1);
			
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
	  $i=0; $can_conc=0; $totala_nom=0; $totald_nom=0; $totalp_nom=0; $cant_nom=0;	$totala_dep=0; $totald_dep=0; $totalp_dep=0; $cant_dep=0;  $totala_emp=0; $totald_emp=0; $totalp_emp=0;
	  $totala_conc=0; $totald_conc=0; $totalp_conc=0; $prev_conc=""; $den_conc=""; $prev_part="";$prev_grupo="";
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"]; $cod_categ=$registro["cod_categ"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $partida=$registro["partida"]; $cod_presup=$registro["cod_presup"]; $afecta_presup=$registro["afecta_presup"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"]; $monto_aporte=$registro["monto_aporte"];
		$valorz=$registro["valorz"]; $monto=$registro["monto"]; $asig_ded_apo=$registro["asig_ded_apo"];  $grupo=$cod_concepto.$partida;
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_cargo=utf8_decode($des_cargo);  $des_departam=utf8_decode($des_departam);  $nombre=utf8_decode($nombre); $denominacion=utf8_decode($denominacion);}
		//if($prev_conc<>$cod_concepto){
		if(($prev_cod_categoria<>$cod_categ)or($prev_tipo<>$tipo_nomina)){	
		    if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);} if($totalp_conc==0){$totalp_conc="";}else{$totalp_conc=formato_monto($totalp_conc);}
		    $pdf->SetFont('Arial','',8);
			$pdf->Cell(30,4,$prev_part,0,0);
			$pdf->Cell(104,4,$den_conc,0,0,'L');
			$pdf->Cell(22,4,$totala_conc,0,0,'R');
			$pdf->Cell(22,4,$totald_conc,0,0,'R');
            $pdf->Cell(22,4,$totalp_conc,0,1,'R');	
		    $sql2="Select cod_concepto,denominacion from NOM002 WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto'"; $res2=pg_query($sql2);  $filas2=pg_num_rows($res2); if($filas2>0){$reg2=pg_fetch_array($res2,0); $denominacion=$reg2["denominacion"]; if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion);} }
		    $prev_conc=$cod_concepto; $den_conc=$denominacion; if($afecta_presup="NO"){ $prev_part=substr($cod_presup,$ini,20);} else { $prev_part=substr($cod_presup,$ini,$p);} 	$totala_conc=0; $totald_conc=0; $totalp_conc=0;  $can_conc=0;
		    $prev_grupo=$grupo;
		
		    $neto=$totala_dep-$totald_dep; $neto=formato_monto($neto); $imp_encabezado=0;
		    $totala_dep=formato_monto($totala_dep); $totald_dep=formato_monto($totald_dep);  $totalp_dep=formato_monto($totalp_dep);
			$pdf->SetFont('Arial','B',8);
		    $pdf->Cell(134,2,'',0,0);
			$pdf->Cell(22,2,'------------------',0,0,'R');
			$pdf->Cell(22,2,'------------------',0,0,'R');
			$pdf->Cell(22,2,'------------------',0,1,'R');			
			$pdf->Cell(134,4,'Total Categoria : '.$prev_cod_categoria,0,0);
			$pdf->Cell(22,4,$totala_dep,0,0,'R');
			$pdf->Cell(22,4,$totald_dep,0,0,'R');
			$pdf->Cell(22,4,$totalp_dep,0,1,'R');
			$pdf->Cell(134,2,'',0,0);
			$pdf->Cell(22,2,'',0,0,'R');
			$pdf->Cell(22,2,'============',0,0,'R');
			$pdf->Cell(22,2,'',0,1,'R');			
			$pdf->Cell(134,4,'',0,0);
			$pdf->Cell(22,4,'',0,0,'R');
			$pdf->Cell(22,4,$neto,0,1,'R');
			$pdf->Ln(10);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');
			$pdf->Cell(140,5,"CATEGORIA PROGRAMATICA : ".$cod_categ,0,1,'L');
			$pdf->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');	
			$pdf->Cell(30,5,'Partida Presup',1,0);
			$pdf->Cell(104,5,'Descripcion del Concepto',1,0,'L');					
			$pdf->Cell(22,5,'Asignaciones',1,0);
			$pdf->Cell(22,5,'Deducciones',1,0);
			$pdf->Cell(22,5,'Aporte',1,1);
			 
			$prev_cod_categoria=$cod_categ; $cant_dep=0; $totala_dep=0; $totald_dep=0; $totalp_dep=0; $camb_nomina=0;
		  if($prev_tipo<>$tipo_nomina){$neto=$totala_nom-$totald_nom; $neto=formato_monto($neto);
				$totala_nom=formato_monto($totala_nom); $totald_nom=formato_monto($totald_nom); $totalp_nom=formato_monto($totalp_nom);
				$pdf->Ln(5);
				$pdf->Cell(134,2,'',0,0);
				$pdf->Cell(22,2,'============',0,0,'R');
				$pdf->Cell(22,2,'============',0,0,'R');
				$pdf->Cell(22,2,'============',0,1,'R');			
				$pdf->Cell(134,2,'Total Nomina : '.$prev_den_nom,0,0);
				$pdf->Cell(22,2,$totala_nom,0,0,'R');
				$pdf->Cell(22,2,$totald_nom,0,0,'R');
				$pdf->Cell(22,2,$totalp_nom,0,1,'R');
				$pdf->Cell(134,2,'',0,0);
				$pdf->Cell(22,2,'',0,0,'R');
				$pdf->Cell(22,2,'============',0,0,'R');
				$pdf->Cell(22,2,'',0,1,'R');			
				$pdf->Cell(134,4,'',0,0);
				$pdf->Cell(22,4,'',0,0,'R');
				$pdf->Cell(22,4,$neto,0,1,'R');
				$prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $cant_nom=0; $totala_nom=0; $totald_nom=0; $totalp_nom=0;
			    $pdf->AddPage();
		  } 	
		}  
        if($prev_grupo<>$grupo){			
		  if($prev_conc<>""){$neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);} if($totalp_conc==0){$totalp_conc="";}else{$totalp_conc=formato_monto($totalp_conc);}
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(30,4,$prev_part,0,0);
			$pdf->Cell(104,4,$den_conc,0,0,'L');
			$pdf->Cell(22,4,$totala_conc,0,0,'R');
			$pdf->Cell(22,4,$totald_conc,0,0,'R');
            $pdf->Cell(22,4,$totalp_conc,0,1,'R');			
		  }		  
		  $sql2="Select cod_concepto,denominacion from NOM002 WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto'"; $res2=pg_query($sql2);  $filas2=pg_num_rows($res2); if($filas2>0){$reg2=pg_fetch_array($res2,0); $denominacion=$reg2["denominacion"]; if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion);} }
		  $prev_conc=$cod_concepto; $den_conc=$denominacion; if($afecta_presup="NO"){ $prev_part=substr($cod_presup,$ini,20);} else { $prev_part=substr($cod_presup,$ini,$p);} 	$totala_conc=0; $totald_conc=0; $totalp_conc=0;  $can_conc=0;
		  $prev_grupo=$grupo;
		}
        	
		$can_conc=$can_conc+1; $totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion; $totalp_conc=$totalp_conc+$monto_aporte;		
		$totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion; $totalp_emp=$totalp_conc+$monto_aporte;
		$totala_nom=$totala_nom+$monto_asignacion; $totald_nom=$totald_nom+$monto_deduccion; $totalp_nom=$totalp_conc+$monto_aporte;
		$totala_dep=$totala_dep+$monto_asignacion; $totald_dep=$totald_dep+$monto_deduccion; $totalp_dep=$totalp_conc+$monto_aporte;
      } $neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);} if($totalp_conc==0){$totalp_conc="";}else{$totalp_conc=formato_monto($totalp_conc);}
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(30,4,$prev_part,0,0);
		$pdf->Cell(104,4,$den_conc,0,0,'L');
		$pdf->Cell(22,4,$totala_conc,0,0,'R');
		$pdf->Cell(22,4,$totald_conc,0,0,'R');
		$pdf->Cell(22,4,$totalp_conc,0,1,'R');				         
				
		$pdf->SetFont('Arial','B',8);  
		$neto=$totala_dep-$totald_dep; $neto=formato_monto($neto); $imp_encabezado=0;
		$totala_dep=formato_monto($totala_dep); $totald_dep=formato_monto($totald_dep);  $totalp_dep=formato_monto($totalp_dep);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(134,2,'',0,0);
		$pdf->Cell(22,2,'------------------',0,0,'R');
		$pdf->Cell(22,2,'------------------',0,0,'R');
		$pdf->Cell(22,2,'------------------',0,1,'R');			
		$pdf->Cell(134,4,'Total Categoria : '.$prev_cod_categoria,0,0);
		$pdf->Cell(22,4,$totala_dep,0,0,'R');
		$pdf->Cell(22,4,$totald_dep,0,0,'R');
		$pdf->Cell(22,4,$totalp_dep,0,1,'R');
		$pdf->Cell(134,2,'',0,0);
			$pdf->Cell(22,2,'',0,0,'R');
			$pdf->Cell(22,2,'============',0,0,'R');
			$pdf->Cell(22,2,'',0,1,'R');			
			$pdf->Cell(134,4,'',0,0);
			$pdf->Cell(22,4,'',0,0,'R');
			$pdf->Cell(22,4,$neto,0,1,'R');
		
		$neto=$totala_nom-$totald_nom; $neto=formato_monto($neto);
		$totala_nom=formato_monto($totala_nom); $totald_nom=formato_monto($totald_nom);	$totalp_nom=formato_monto($totalp_nom);
		$pdf->Ln(5);
		$pdf->Cell(134,2,'',0,0);
		$pdf->Cell(22,2,'============',0,0,'R');
		$pdf->Cell(22,2,'============',0,0,'R');
		$pdf->Cell(22,2,'============',0,1,'R');			
		$pdf->Cell(134,4,'Total Nomina : '.$prev_den_nom,0,0);
		$pdf->Cell(22,4,$totala_nom,0,0,'R');
		$pdf->Cell(22,4,$totald_nom,0,0,'R');
		$pdf->Cell(22,4,$totalp_nom,0,1,'R');
		$pdf->Cell(134,2,'',0,0);
			$pdf->Cell(22,2,'',0,0,'R');
			$pdf->Cell(22,2,'============',0,0,'R');
			$pdf->Cell(22,2,'',0,1,'R');			
			$pdf->Cell(134,4,'',0,0);
			$pdf->Cell(22,4,'',0,0,'R');
			$pdf->Cell(22,4,$neto,0,1,'R');
	  $pdf->Output();   
    }
}
?>
