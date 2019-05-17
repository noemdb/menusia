<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist="S";
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $tipo_concepto=$_GET["tipo_concepto"]; $tipo_rpt="PDF";
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"]; $forma_pago=$_GET["forma_pago"];
   $cod_presup_catd=$_GET["cod_presup_catd"];  $cod_presup_cath=$_GET["cod_presup_cath"];
   $cod_empleado_d=$_GET["cod_empleado_d"]; $cod_empleado_h=$_GET["cod_empleado_h"]; $codigo_cargo_d=$_GET["codigo_cargo_d"];  $codigo_cargo_h=$_GET["codigo_cargo_h"]; 
   $fecha_desde=$_GET["fecha_desde"]; $fecha_nom=$_GET["fecha_hasta"];  $fecha_hasta=$_GET["fecha_hasta"];
   
   $Sql="";$date = date("d-m-Y"); $hora = date("h:i:s a"); $cfechan=formato_aaaammdd($fecha_nom);  $cfechad=formato_aaaammdd($fecha_desde); $cfechah=formato_aaaammdd($fecha_hasta);
   
   $criterio="rpt_nom_cal WHERE (oculto='NO') ";
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (oculto='NO') ";} 
   
   
   $criterio="rpt_nom_hist WHERE (oculto='NO') and (fecha_p_hasta>='".$cfechad."') and (fecha_p_hasta<='".$cfechah."') ";
   
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and (concepto_vac='N') ";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and (concepto_vac='S') ";}
   
   $criterio=$criterio." and (cod_concepto>='".$cod_conceptod."' and cod_concepto<='".$cod_conceptoh."') ";
   
   
   if($tipo_calculo=='T'){$criterio=$criterio;}else{$criterio=$criterio." and (tp_calculo='".$tipo_calculo."') ";}
   
   $criterio1="LISTADO DE PRESTAMOS DE CAJA DE AHORRO";
   $orden="ORDER BY cod_categ,cod_concepto, cod_empleado";
   if($tipo_nomina_d==$tipo_nomina_h){ $orden="ORDER BY tipo_nomina,cod_categ,cod_concepto, cod_empleado";  }
   
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";}
      $sSQL="SELECT *  FROM ".$criterio."  and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and
	    (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_categ>='".$cod_presup_catd."' and cod_categ<='".$cod_presup_cath."') and
	    (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."') ".$orden;
  
      $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre=""; $prev_cod_emp=""; $prev_cod_categoria=''; $cod_categ='';
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"]; $cedula=$registro["cedula"]; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"];  $nombre=$registro["nombre"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];  $cod_categ=$registro["cod_categ"]; 			
        if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);} $prev_cod_categoria=$cod_categ;
		$prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_cod_emp=$cod_empleado; $prev_emp=$cedula;  $prev_nombre=$nombre; 
	  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tipo_nomina; global $des_nomina; global $fechad; global $fechah; global $cod_departam; global $des_departam;
		                   global $cod_concepto; global $denominacion; global $fecha_desde; global $fecha_hasta; global $tipo_letra; global $Nom_Emp;
						   global $tipo_nomina_d; global $tipo_nomina_h; global $cod_categ;
			$ffechar=date("d-m-Y");			   
			$this->SetFont($tipo_letra,'',10);
			$this->Cell(130,4,$Nom_Emp,0,0,'L');
			$this->Cell(70,4,'Fecha: '.$ffechar,0,1,'R');
			$this->Cell(130,4,'',0,0,'C');
			$this->Cell(70,4,'Pagina '.$this->PageNo(),0,1,'R');			
			$this->Ln(4);
			$this->Cell(200,4,$criterio1,0,1,'C');
			$this->Ln(2);			
			$this->SetFont($tipo_letra,'B',9);
			$this->SetFont($tipo_letra,'',10);
			if($tipo_nomina_d==$tipo_nomina_h){
			$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L'); }
			$this->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');
			$this->SetFont($tipo_letra,'',10);
			//$this->Cell(140,5,"CATEGORIA PROGRAMATICA : ".$cod_categ,0,1,'L');
			$this->SetFont($tipo_letra,'B',9);
			
			$this->Cell(25,5,'CEDULA','TB',0);
			$this->Cell(150,5,'APELLIDOS Y NOMBRES','TB',0,'L');
			$this->Cell(25,5,'MONTO','TB',1);
			
			//CEDULA APELLIDOS Y NOMBRES MONTO
			//$this->Cell(200,1,$linea_puntos,0,1,'C');
			//$this->Cell(200,5,$cod_concepto." ".$denominacion,0,1,'L');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			//$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			//$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $tipo_letra='lucon'; $tipo_letra='times'; $tipo_letra='courier'; $tipo_letra='Arial';
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',8);
	  
	  $linea_puntos="------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------";
			
	  $i=0; $can_conc=0; $totala_nom=0; $totald_nom=0; $cant_nom=0;	$totala_emp=0; $totald_emp=0; $cant_emp=0;  $totala_conc=0; $totald_conc=0;  $totala_dep=0; $totald_dep=0; $cant_emp_dep=0;
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"]; $cod_categ=$registro["cod_categ"]; 
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
		$valorz=$registro["valorz"]; $monto=$registro["monto"]; $asig_ded_apo=$registro["asig_ded_apo"];
		if($tipo_monto=="PRI"){  $monto_asignacion=0; $monto_deduccion=0; if($asig_ded_apo=="A"){$monto_asignacion=$valorz;} if($asig_ded_apo=="D"){$monto_deduccion=$valorz;} }
		if($tipo_monto=="SEG"){  $monto_asignacion=0; $monto_deduccion=0; if($asig_ded_apo=="A"){$monto_asignacion=$monto-$valorz;} if($asig_ded_apo=="D"){$monto_deduccion=$monto-$valorz;} }
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina); $nombre=utf8_decode($nombre); $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		//if(($prev_conc<>$cod_concepto)or($prev_dep<>$cod_departam)or($prev_tipo<>$tipo_nomina)){
		
		if($i==1){
		  $pdf->Cell(175,5,$cod_categ,0,1);
		  $pdf->Cell(5,4,' ',0,0);	
		  $pdf->Cell(175,4,$cod_concepto.'    '.$denominacion,0,1);	
		}	
			
		if(($prev_conc<>$cod_concepto)or($prev_cod_categoria<>$cod_categ)){
		    if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
			if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			$pdf->SetFont($tipo_letra,'',8);
			$pdf->Cell(5,4,' ',0,0);	
			$pdf->Cell(20,4,$prev_emp,0,0);
			$pdf->Cell(150,4,$prev_nombre,0,0);	
			$pdf->Cell(25,4,$totald_emp,0,1,'R');			
		    $can_conc=0;  $totala_emp=0; $totald_emp=0; $prev_cod_emp=$cod_empleado; $prev_emp=$cedula; $prev_nombre=$nombre;  $cant_emp=$cant_emp+1; $cant_emp_dep=$cant_emp_dep+1;		    
		    
			$totala_conc=formato_monto($totala_conc); $totald_conc=formato_monto($totald_conc);
			$pdf->Cell(5,1,' ',0,0);	
		    $pdf->Cell(195,1,substr($linea_puntos,0,205),0,1,'L');
			$pdf->Cell(5,4,' ',0,0);
			$pdf->Cell(35,5,'Nro. Trabjadores : '.$cant_emp,0,0);			
			$pdf->Cell(135,5,'TOTAL '.$den_conc,0,0);
		  	$pdf->Cell(25,5,$totald_conc,0,1,'R');	
            $sql2="Select cod_concepto,denominacion from NOM002 WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto'"; $res2=pg_query($sql2);  $filas2=pg_num_rows($res2); if($filas2>0){$reg2=pg_fetch_array($res2,0); $denominacion=$reg2["denominacion"]; if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion);} }
			$prev_conc=$cod_concepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0;  $cant_emp=0;$prev_tipo=$tipo_nomina;
			
			if($prev_cod_categoria<>$cod_categ){
                $pdf->ln(3);				
				$totala_dep=formato_monto($totala_dep); $totald_dep=formato_monto($totald_dep);
				$pdf->SetFont($tipo_letra,'B',8);
				$pdf->Cell(40,5,'Nro. Trabjadores : '.$cant_emp_dep,0,0);			
			    $pdf->Cell(135,5,'TOTAL CATEGORIA '.$prev_cod_categoria.' ====>   ',0,0,'R');
				$pdf->Cell(25,5,$totald_dep,0,1,'R');
				$totala_dep=0; $totald_dep=0; $cant_emp_dep=0; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_cod_categoria=$cod_categ;
				$pdf->Cell(200,1,$linea_puntos,0,1,'L');
			}
			$pdf->ln(3);
			
			if($cant_emp_dep==0){ $pdf->Cell(175,5,$cod_categ,0,1); }
			
			$pdf->Cell(5,4,' ',0,0);	
		    $pdf->Cell(175,4,$cod_concepto.'    '.$denominacion,0,1);
			//$pdf->AddPage();
		} 		
		if($prev_emp<>$cedula){		
		    if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
		    if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			$pdf->SetFont($tipo_letra,'',8);
			$pdf->Cell(5,4,' ',0,0);	
			$pdf->Cell(20,4,$prev_emp,0,0);
			$pdf->Cell(150,4,$prev_nombre,0,0);
			$pdf->Cell(25,4,$totald_emp,0,1,'R');			
		    $can_conc=0;  $totala_emp=0; $totald_emp=0; $prev_cod_emp=$cod_empleado; $prev_emp=$cedula;  $prev_nombre=$nombre; $cant_emp=$cant_emp+1;  $cant_emp_dep=$cant_emp_dep+1;
		}	
		$can_conc=$can_conc+$cantidad; $totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;		
		$totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;
        $totala_dep=$totala_dep+$monto_asignacion; $totald_dep=$totald_dep+$monto_deduccion;
		$totala_nom=$totala_nom+$monto_asignacion; $totald_nom=$totald_nom+$monto_deduccion;		
      }
	  
	    if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
		if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
		$pdf->SetFont($tipo_letra,'',8);
		$pdf->Cell(5,4,' ',0,0);
		$pdf->Cell(20,4,$prev_emp,0,0);
		$pdf->Cell(150,4,$prev_nombre,0,0);
		$pdf->Cell(25,4,$totald_emp,0,1,'R');			
		$can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cedula; $prev_nombre=$nombre;  $cant_emp=$cant_emp+1; $cant_emp_dep=$cant_emp_dep+1;
		
		$totala_conc=formato_monto($totala_conc); $totald_conc=formato_monto($totald_conc);
	     
	    $pdf->Cell(5,1,' ',0,0);	
		$pdf->Cell(195,1,substr($linea_puntos,0,205),0,1,'L');
		$pdf->Cell(5,4,' ',0,0);
		$pdf->Cell(35,5,'Nro. Trabjadores : '.$cant_emp,0,0);			
		$pdf->Cell(135,5,'TOTAL '.$den_conc,0,0);
		$pdf->Cell(25,5,$totald_conc,0,1,'R');	
		
		$pdf->ln(3);				
		$totala_dep=formato_monto($totala_dep); $totald_dep=formato_monto($totald_dep);
		$pdf->SetFont($tipo_letra,'B',8);
		$pdf->Cell(40,5,'Nro. Trabjadores : '.$cant_emp_dep,0,0);			
		$pdf->Cell(135,5,'TOTAL CATEGORIA '.$prev_cod_categoria.' ====>   ',0,0,'R');
		$pdf->Cell(25,5,$totald_dep,0,1,'R');		
         
		$pdf->ln(3); 
		$pdf->SetFont($tipo_letra,'B',8);
		$totald_nom=formato_monto($totald_nom);
		$pdf->Cell(175,2,'',0,0);
		$pdf->Cell(25,2,'=================',0,1,'R');
		$pdf->Cell(175,5,'TOTAL GENERAL  ---- ',0,0,'R');
		$pdf->Cell(25,5,$totald_nom,0,1,'R');
		
		 //  ESTO ES PARA FINAL REPORTE
        $y=$pdf->GetY();  $t=10;
        if($y>265){$t=15; $pdf->Cell(5,4,'',0,1);  } 
        $pdf->ln($t); $y=$pdf->GetY();
	    if($y<255){$t=255-$y; $pdf->ln($t);} 		
        $pdf->Cell(70,3,'Rpt_cons_cajaahorro.php',0,1,'L'); 
		
		
	  $pdf->Output();   
    
}
?>
