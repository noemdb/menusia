<? include ("../../class/conect.php");  require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;  error_reporting(E_ALL ^ E_NOTICE);
   
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist="S";  $tipo_reporte="N";
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $tipo_concepto=$_GET["tipo_concepto"]; $tipo_rpt="PDF";
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"]; $forma_pago=$_GET["forma_pago"];
   $cod_presup_catd="";    $cod_presup_cath="zzzzzzzzzzzzzzzzzzzz";
   $cod_empleado_d=$_GET["cod_empleado_d"]; $cod_empleado_h=$_GET["cod_empleado_h"]; $codigo_cargo_d=$_GET["codigo_cargo_d"];  $codigo_cargo_h=$_GET["codigo_cargo_h"]; 
   $fecha_desde=$_GET["fecha_desde"]; $fecha_nom=$_GET["fecha_hasta"];  $fecha_hasta=$_GET["fecha_hasta"];
    
   $cfechan=formato_aaaammdd($fecha_nom);  $cfechad=formato_aaaammdd($fecha_desde); $cfechah=formato_aaaammdd($fecha_hasta);
   
   $Sql="";   $date = date("d-m-Y");   $hora = date("H:i:s a"); $criterio2="";
   if($tipo_reporte=='N'){$criterio1="RELACION DE NOMINA";} else{$criterio1="RELACION DE NOMINA (PRE-NOMINA)";}
   $criterio="rpt_nom_cal WHERE (oculto='NO') ";
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (oculto='NO') ";} 
   $criterio="rpt_nom_hist WHERE (oculto='NO') and (fecha_p_hasta>='".$cfechad."') and (fecha_p_hasta<='".$cfechah."') ";
   
   if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and ((concepto_vac='N') or (cod_concepto='VVV'))";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and ((concepto_vac='S') and (cod_concepto<>'VVV')) ";}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else {  $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}

    function muestra_cant($mop,$mtipo,$mdep,$mcod_emp){global $criterio; global $host;  global $port; global $password; global $user; global $dbname;
	   $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");    $cant=0;
	   $fsql = "SELECT count(distinct cod_empleado) as cant_trab  from ".$criterio." and (tipo_nomina='".$mtipo."')";
	   if($mop==2){ $fsql = "SELECT count(distinct cod_empleado) as cant_trab  from ".$criterio." and (tipo_nomina='".$mtipo."') and (cod_departam='".$mdep."')";}
	   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){$freg=pg_fetch_array($fres); $cant=$freg["cant_trab"];} 
	   return $cant;
	}	
	
	$criterio=$criterio." and (tp_calculo='".$tipo_calculo."') and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and
		  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_concepto>='".$cod_conceptod."' AND cod_concepto<='".$cod_conceptoh."')  and
	  (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."')";	
	
    $Sql = "SELECT count(distinct cod_empleado) as cant_trab  FROM ".$criterio; echo $Sql;
    $res=pg_query($Sql); $filas=pg_num_rows($res); if($filas>0){ $registro=pg_fetch_array($res,0); $criterio2=$registro["cant_trab"];  }	

    $sSQL = "SELECT *  FROM ".$criterio."  ORDER BY tipo_nomina, cod_empleado, cod_concepto, fecha_p_hasta ";
	
	
	
	if($tipo_rpt=="PDF"){	 $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $prev_emp=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam);}
        $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp="";
	  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tipo_nomina; global $des_nomina; global $fechad; global $fechah; global $cod_departam; global $des_departam;
		    global $fecha_desde;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',12);
			$this->Cell(40);
			$this->Cell(140,7,$criterio1,1,0,'C');
			$this->Ln(17);
			$this->SetFont('Arial','B',8);
			$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');
			$this->Cell(140,5,"FECHA : ".$fecha_desde." AL ".$fecha_hasta,0,1,'L');
			$this->SetFont('Arial','B',7);
			$this->Cell(60,5,'Trabajador',1,0);
			$this->Cell(10,5,'Codigo',1,0);
			$this->Cell(78,5,'Descripcion Concepto',1,0,'L');
			$this->Cell(17,5,'Asignaciones',1,0);
			$this->Cell(17,5,'Deducciones',1,0);
			$this->Cell(18,5,'Neto',1,1,'C');			
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
	  $totala_conc=0; $totald_conc=0; $prev_conc=""; $den_conc=""; $total_cant=0; $totala_g=0; $totald_g=0; $cant_g=0;
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_cargo=utf8_decode($des_cargo);  $des_departam=utf8_decode($des_departam);  $nombre=utf8_decode($nombre); $denominacion=utf8_decode($denominacion);}
		if(($prev_emp<>$cod_empleado)or($prev_tipo<>$tipo_nomina)){
		  if($can_conc>0){$neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} 
			if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);} $total_cant=formato_monto($total_cant);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(60,3,'',0,0);
			$pdf->Cell(8,3,$prev_conc,0,0);
			$pdf->Cell(72,3,$den_conc,0,0,'L');
			$pdf->Cell(10,3,$total_cant,0,0,'R');
			$pdf->Cell(15,3,$totala_conc,0,0,'R');
			$pdf->Cell(15,3,$totald_conc,0,0,'R');
			$pdf->Cell(15,3,$neto,0,1,'R');
		    $prev_conc=$cod_concepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0;  $total_cant=0;
			$pdf->SetFont('Arial','B',7);
		    $neto=$totala_emp-$totald_emp; $neto=formato_monto($neto);
		    $totala_emp=formato_monto($totala_emp); $totald_emp=formato_monto($totald_emp);
		    $pdf->Cell(150,2,'',0,0);
			$pdf->Cell(15,2,'---------------------',0,0,'R');
			$pdf->Cell(15,2,'---------------------',0,0,'R');
			$pdf->Cell(20,2,'---------------------',0,1,'R');
			$pdf->Cell(150,2,'',0,0);
			$pdf->Cell(15,2,$totala_emp,0,0,'R');
			$pdf->Cell(15,2,$totald_emp,0,0,'R');
			$pdf->Cell(20,2,$neto,0,1,'R');
            $pdf->Ln(6); 
		  } 
		  $pdf->SetFont('Arial','B',7);
		  if($prev_tipo<>$tipo_nomina){$neto=$totala_nom-$totald_nom; $neto=formato_monto($neto);
				$totala_nom=formato_monto($totala_nom); $totald_nom=formato_monto($totald_nom);
				$pdf->Ln(10);
				$pdf->Cell(150,2,'',0,0);
				$pdf->Cell(15,2,'============',0,0,'R');
				$pdf->Cell(15,2,'============',0,0,'R');
				$pdf->Cell(20,2,'============',0,1,'R');			
				$pdf->Cell(140,2,'Total : '.$prev_den_nom,0,0);
				$pdf->Cell(10,2,$cant_nom,0,0,'C');			
				$pdf->Cell(15,2,$totala_nom,0,0,'R');
				$pdf->Cell(15,2,$totald_nom,0,0,'R');
				$pdf->Cell(20,2,$neto,0,1,'R');
				$prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $cant_nom=0; $totala_nom=0; $totald_nom=0;
			$pdf->AddPage();
		  } $sueldo_cargo=formato_monto($sueldoc); 
		  $pdf->SetFont('Arial','',7);
		  if($Cod_Emp=="70"){ $pdf->Cell(90,3,$cedula." ".$nombre,0,0,'L');
          $pdf->Cell(110,3,"Fecha Ingreso: ".$fechai."   Sueldo: ".$sueldo_cargo."   ".$des_cargo,0,1,'L');		  
		  }
		  else{
		  $pdf->Cell(17,3,$cod_empleado,0,0,'L');
		  $pdf->Cell(120,3,$nombre,0,0,'L'); 
          $pdf->Cell(13,3,$cedula,0,0,'L');
		  $pdf->Cell(50,3,$des_cargo,0,1,'L'); 
		  }
		  		  
		  $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $cant_dep=$cant_dep+1; $cant_nom=$cant_nom+1;	$cant_g=$cant_g+1;		  
		}		
		if($prev_conc<>$cod_concepto){		
		  if($prev_conc<>""){$neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);} $total_cant=formato_monto($total_cant);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(60,3,'',0,0);
			$pdf->Cell(10,3,$prev_conc,0,0);
			$pdf->Cell(70,3,$den_conc,0,0,'L');
			$pdf->Cell(10,3,$total_cant,0,0,'R');
			$pdf->Cell(15,3,$totala_conc,0,0,'R');
			$pdf->Cell(15,3,$totald_conc,0,0,'R');
			$pdf->Cell(20,3,$neto,0,1,'R');}
		  $prev_conc=$cod_concepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0;  $total_cant=0;
		}
        $can_conc=$can_conc+1; 	$totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;  $total_cant=$total_cant+$cantidad;	
		$totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;
		$totala_nom=$totala_nom+$monto_asignacion; $totald_nom=$totald_nom+$monto_deduccion;
		$totala_dep=$totala_dep+$monto_asignacion; $totald_dep=$totald_dep+$monto_deduccion;
        $totala_g=$totala_g+$monto_asignacion; $totald_g=$totald_g+$monto_deduccion; 	
      } $neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} 
		if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);} $total_cant=formato_monto($total_cant);
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(60,3,'',0,0);
		$pdf->Cell(10,3,$prev_conc,0,0);
		$pdf->Cell(70,3,$den_conc,0,0,'L');
		$pdf->Cell(10,3,$total_cant,0,0,'R');
		$pdf->Cell(15,3,$totala_conc,0,0,'R');
		$pdf->Cell(15,3,$totald_conc,0,0,'R');
		$pdf->Cell(20,3,$neto,0,1,'R');
		$pdf->SetFont('Arial','B',7);
		$neto=$totala_emp-$totald_emp; $neto=formato_monto($neto);
		$totala_emp=formato_monto($totala_emp); $totald_emp=formato_monto($totald_emp);
		$pdf->Cell(150,2,'',0,0);
		$pdf->Cell(15,2,'-------------------',0,0,'R');
		$pdf->Cell(15,2,'-------------------',0,0,'R');
		$pdf->Cell(20,2,'---------------------',0,1,'R');
		$pdf->Cell(150,2,'',0,0);
		$pdf->Cell(15,2,$totala_emp,0,0,'R');
		$pdf->Cell(15,2,$totald_emp,0,0,'R');
		$pdf->Cell(20,2,$neto,0,1,'R');
		$pdf->Ln(6); 
		
		$neto=$totala_nom-$totald_nom; $neto=formato_monto($neto);
		$totala_nom=formato_monto($totala_nom); $totald_nom=formato_monto($totald_nom);
		$pdf->Ln(10);
		$pdf->Cell(150,2,'',0,0);
		$pdf->Cell(15,2,'===========',0,0,'R');
		$pdf->Cell(15,2,'===========',0,0,'R');
		$pdf->Cell(20,2,'============',0,1,'R');			
		$pdf->Cell(140,2,'Total : '.$prev_den_nom,0,0);
		$pdf->Cell(10,3,$cant_nom,0,0,'C');			
		$pdf->Cell(15,3,$totala_nom,0,0,'R');
		$pdf->Cell(15,3,$totald_nom,0,0,'R');
		$pdf->Cell(20,3,$neto,0,1,'R');	
        If ($tipo_nomina_d<>$tipo_nomina_h){
		    $neto=$totala_g-$totald_g; $neto=formato_monto($neto);
			$totala_g=formato_monto($totala_g); $totald_g=formato_monto($totald_g);
			$pdf->Ln(10);
			$pdf->Cell(140,2,'',0,0);
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,1,'R');			
			$pdf->Cell(130,2,'Total General : ',0,0);
			$pdf->Cell(10,2,$cant_g,0,0,'C');			
			$pdf->Cell(20,2,$totala_g,0,0,'R');
			$pdf->Cell(20,2,$totald_g,0,0,'R');
			$pdf->Cell(20,2,$neto,0,1,'R');		 
         }			
	  $pdf->Output();   
    }
}   pg_close();
?>
