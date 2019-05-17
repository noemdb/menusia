<? include ("../../class/conect.php");  require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php");  include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
 
 $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"];  $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"];   
   $forma_pago=$_GET["forma_pago"]; $tipo_calculo=$_GET["tipo_calculo"];   $cod_empleado_d=$_GET["cod_empleado_d"]; $cod_empleado_h=$_GET["cod_empleado_h"];   
   $cod_presup_catd=$_GET["cod_presup_catd"];  $cod_presup_cath=$_GET["cod_presup_cath"];  $codigo_cargo_d=$_GET["codigo_cargo_d"];  $codigo_cargo_h=$_GET["codigo_cargo_h"]; 
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"];  $fecha_desde=$_GET["fecha_desde"];    $fecha_hasta=$_GET["fecha_hasta"];    
   $codigo_rpt=$_GET["codigo_rpt"];   $Sql=""; $date=date("d-m-Y"); $hora=date("h:i:s a"); $mes_comp="S"; $act_hist="N"; $fecha_nom=$fecha_hasta;
   $cfechan=formato_aaaammdd($fecha_hasta);      $php_os=PHP_OS;   $tipo_rpt="PDF"; $estatus_trab_d='TODOS';
   $criterio1="RELACION DE CONCEPTOS/CONTABILIDAD";
   $criterio2="NOMINA ORDINARIA";  $ordenar=" order by tipo_nomina, cod_concepto, cod_empleado";   
   
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";}
   
   if($tipo_calculo=="T"){$temp="N";  }
   $sql="SELECT fecha_p_hasta FROM nom017 where tipo_nomina='".$tipo_nomina_d."' and tp_calculo='".$temp."'"; $res=pg_query($sql); $filas=pg_num_rows($res);
   if($filas>0){$registro=pg_fetch_array($res);  $fecha_nomina=$registro["fecha_p_hasta"];   $fecha_nomina=formato_ddmmaaaa($fecha_nomina);
   if($fecha_hasta<>$fecha_nomina){ $act_hist="S";} }   
   $criterio="rpt_nom_cal WHERE (oculto='NO') and (cod_concepto<>'VVV') ";
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (oculto='NO') and (cod_concepto<>'VVV') ";} 
   if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}   
   if($tipo_calculo=="T"){ $criterio=$criterio." and ((tp_calculo='N')or(tp_calculo='E')) "; }    else { $criterio=$criterio." and (tp_calculo='".$tipo_calculo."') "; }   
  	$l=strlen($cod_presup_cath); $p=$l+1;
	
	$criterio=$criterio." and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."') and
		  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_cargo>='".$codigo_cargo_d."' and cod_cargo<='".$codigo_cargo_h."') and
		  (substring(cod_presup,1,$l)>='".$cod_presup_catd."' and substring(cod_presup,1,$l)<='".$cod_presup_cath."')  and (cod_concepto>='".$cod_conceptod."' and cod_concepto<='".$cod_conceptoh."') ";
   $sSQL = "SELECT *  FROM ".$criterio.$ordenar;
   
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
			$this->Cell(120,7,$criterio1,1,0,'C');
			$this->Ln(17);
			$this->SetFont('Arial','B',8);
			if($tipo_nomina_d==$tipo_nomina_h){	$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');}
			else{$this->Cell(140,5,$criterio2,0,1,'L');}
			$this->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');
			$this->Cell(11,5,'Codigo',1,0);
			$this->Cell(93,5,'Descripcion del Concepto',1,0,'L');
			$this->Cell(28,5,'Cod. Partida',1,0);
			$this->Cell(28,5,'Cod. Cotable',1,0);
			$this->Cell(20,5,'Asignaciones',1,0);
			$this->Cell(20,5,'Deducciones',1,1);
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
	  //$pdf->MultiCell(200,4,$sSQL ,0);
	  $i=0; $can_conc=0; $totala_nom=0; $totald_nom=0; $cant_nom=0;	$totala_dep=0; $totald_dep=0; $cant_dep=0;  $totala_emp=0; $totald_emp=0; 
	  $totala_conc=0; $totald_conc=0; $prev_conc=""; $den_conc=""; $prev_part=""; $prev_cod_ret=""; $prev_cod_contab="";
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
		$cod_presup=$registro["cod_presup"]; $asig_ded_apo=$registro["asig_ded_apo"]; $cod_fuente=$registro["cod_contable"]; $cod_retencion=$registro["cod_retencion"]; 
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_cargo=utf8_decode($des_cargo);  $des_departam=utf8_decode($des_departam);  $nombre=utf8_decode($nombre); $denominacion=utf8_decode($denominacion);}
		if($prev_conc<>$cod_concepto){		
		  if($prev_conc<>""){$neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);}
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(10,4,$prev_conc,0,0);
			$pdf->Cell(94,4,$den_conc,0,0,'L');
			$pdf->Cell(28,4,$prev_part,0,0,'L');
			$pdf->Cell(28,4,$prev_cod_contab,0,0,'L');
			$pdf->Cell(20,4,$totala_conc,0,0,'R');
			$pdf->Cell(20,4,$totald_conc,0,1,'R');}
		    $prev_conc=$cod_concepto; $den_conc=$denominacion;	$prev_part=substr($cod_presup,$p,24); $prev_cod_ret=$cod_retencion; 		  
		    $totala_conc=0; $totald_conc=0; $prev_cod_contab=$asig_ded_apo; 
			if($asig_ded_apo=="A"){		   
			   $sqlp="Select cod_contable from pre001 where cod_presup='$cod_presup' and cod_fuente='$cod_fuente'"; $resp=pg_query($sqlp); $filasp=pg_num_rows($resp);
               if($filasp>0){$regp=pg_fetch_array($resp);  $prev_cod_contab=$regp["cod_contable"];  }		   
		    }else{ $sqlp="Select cod_contable from pag003 where tipo_retencion='$cod_retencion' "; $resp=pg_query($sqlp); $filasp=pg_num_rows($resp);
                if($filasp>0){$regp=pg_fetch_array($resp);  $prev_cod_contab=$regp["cod_contable"];  }
		    }
		}	
		$can_conc=$can_conc+1; $totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;		
		$totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;
		$totala_nom=$totala_nom+$monto_asignacion; $totald_nom=$totald_nom+$monto_deduccion;
		$totala_dep=$totala_dep+$monto_asignacion; $totald_dep=$totald_dep+$monto_deduccion;
      } $neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} 
			if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);}
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(10,4,$prev_conc,0,0);
			$pdf->Cell(94,4,$den_conc,0,0,'L');
			$pdf->Cell(28,4,$prev_part,0,0,'L');
			$pdf->Cell(28,4,$prev_cod_contab,0,0,'L');
			$pdf->Cell(20,4,$totala_conc,0,0,'R');
			$pdf->Cell(20,4,$totald_conc,0,1,'R');
			$pdf->SetFont('Arial','B',8);           
            $neto=$totala_nom-$totald_nom; $neto=formato_monto($neto);
			$totala_nom=formato_monto($totala_nom); $totald_nom=formato_monto($totald_nom);
			$pdf->Cell(160,2,'',0,0);
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,1,'R');			
			$pdf->Cell(160,4,'Total : ',0,0,'R');		
			$pdf->Cell(20,4,$totala_nom,0,0,'R');
			$pdf->Cell(20,4,$totald_nom,0,1,'R');
            $pdf->Ln(30);	
			$pdf->SetFont('Arial','',6);
            $pdf->Cell(60,3,'Elaborado Por :',0,0,'L');
            $pdf->Cell(60,3,'Revisado Por :',0,0,'L');
            $pdf->Cell(60,3,'Aprobado Por :',0,1,'L');			
	  $pdf->Output();   
    }
	

}
?>
