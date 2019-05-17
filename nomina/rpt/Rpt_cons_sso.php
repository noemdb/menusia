<?include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);

   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"];  $cod_conceptod=$_GET["cod_concepto_d"]; $cod_conceptoh=$_GET["cod_concepto_h"];   
   $forma_pago=$_GET["forma_pago"]; $tipo_calculo=$_GET["tipo_calculo"];   $cod_empleado_d=$_GET["cod_empleado_d"]; $cod_empleado_h=$_GET["cod_empleado_h"];   
   $cod_presup_catd=$_GET["cod_presup_catd"];  $cod_presup_cath=$_GET["cod_presup_cath"];  $codigo_cargo_d=$_GET["codigo_cargo_d"];  $codigo_cargo_h=$_GET["codigo_cargo_h"]; 
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"];  $fecha_desde=$_GET["fecha_desde"];    $fecha_hasta=$_GET["fecha_hasta"];    
   $codigo_rpt=$_GET["codigo_rpt"];   $Sql=""; $date=date("d-m-Y"); $hora=date("h:i:s a"); $mes_comp="S";
   $cfechan=formato_aaaammdd($fecha_hasta);      $php_os=PHP_OS;
   
  	  
   
   $dfechan=formato_aaaammdd($fecha_desde); $hfechan=formato_aaaammdd($fecha_hasta);
   
   $criterio="rpt_nom_cal WHERE ";  $criterio1=""; $criterio2=""; $criterio3=""; $criterio4="";
   $criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."')  and ";   
   $criterio="rpt_nom_hist WHERE (fecha_p_desde>='".$dfechan."') and (fecha_p_hasta<='".$hfechan."') and ";   
   $ordenar="  order by tipo_nomina, cod_empleado, cod_concepto";
   $cod_concepto_r="500"; $cod_concepto_a="900";
   $criterio1="Fecha: ".$fecha_desde." al ".$fecha_hasta;
   
   $criterio4="Codigo Concepto Retencion: ".$cod_concepto_r."     "."Codigo Concepto Aporte: ".$cod_concepto_a;
   
      
  // if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." (status_emp='".$estatus_trab_d."') and ";}   
   if($tipo_calculo=="T"){ $criterio=$criterio." ((tp_calculo='N')or(tp_calculo='E')) and "; } else { $criterio=$criterio." (tp_calculo='".$tipo_calculo."') and "; }
   if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}
   
   $criterio=$criterio." (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."') and
		  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_cargo>='".$codigo_cargo_d."' and cod_cargo<='".$codigo_cargo_h."') and
		  (substring(cod_presup,1,8)>='".$cod_presup_catd."' and substring(cod_presup,1,8)<='".$cod_presup_cath."')  and (cod_concepto='".$cod_concepto_r."' or cod_concepto='".$cod_concepto_a."') ";
   
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";}
   
   function muestra_cant($mop,$mtipo,$mdep,$mcod_emp){global $criterio; global $host; global $password; global $user; global $dbname;
     $conn=pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");    $cant=0;
     $fsql = "SELECT count(distinct cod_empleado) as cant_trab  from ".$criterio." and (tipo_nomina='".$mtipo."')";	
     if($mop==2){ $fsql = "SELECT count(distinct cod_empleado) as cant_trab  from ".$criterio." and (tipo_nomina='".$mtipo."') and (cod_departam='".$mdep."')";}
     if($mop==3){ $fsql = "SELECT count(distinct cod_empleado) as cant_trab  from ".$criterio." and (cod_departam='".$mdep."')";}    	 
     $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){$freg=pg_fetch_array($fres); $cant=$freg["cant_trab"];} 
     return $cant;
   }
   $criterio3="";
   if($tipo_nomina_d<>$tipo_nomina_h){ 
	  $sql="SELECT tipo_nomina,descripcion,desc_grupo from nom001 where tipo_nomina='$tipo_nomina_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$criterio3=$registro["desc_grupo"];}
   }
   $Sql = "SELECT count(distinct cod_empleado) as cant_trab  FROM ".$criterio;
   $res=pg_query($Sql); $filas=pg_num_rows($res); if($filas>0){ $registro=pg_fetch_array($res,0); $criterio2=$registro["cant_trab"];  }	
   $sSQL = "SELECT *  FROM ".$criterio.$ordenar;  
   
  
      $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre=""; $prev_cedula="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"];  $nombre=$registro["nombre"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];  	$cedula=$registro["cedula"];		
        if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		$prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $prev_cedula=$cedula;
	  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tipo_nomina; global $des_nomina; global $fechad; global $fechah; global $cod_concepto; global $tipo_nomina_d; global $tipo_nomina_h;  global $criterio4; global $criterio3;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',11);
			$this->Cell(40);
			$this->Cell(150,7,"RELACION RETENCION/APORTE SEGURO SOCIAL OBLIGATORIO",1,0,'C');
			$this->Ln(17);
			$this->SetFont('Arial','B',8);
			if($tipo_nomina_d==$tipo_nomina_h){	$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');}
			else{$this->Cell(140,5,$criterio3,0,1,'L');}			
			$this->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');
			$this->Cell(140,5,$criterio4,0,1,'L');			
			$this->Cell(18,3,'Codigo','RLT',0,'L');
			$this->Cell(122,3,'','RT',0,'L');
			$this->Cell(20,3,'','RT',0,'C');
			$this->Cell(20,3,'Retencion','RT',0,'C');
			$this->Cell(20,3,'Aporte','RT',1,'C');			
			$this->Cell(18,4,'Trabajador','LB',0,'L');
			$this->Cell(122,4,'Nombre Trabajador','LB',0,'L');
			$this->Cell(20,4,'Cedula','LB',0,'C');
			$this->Cell(20,4,'Trabajador','LB',0,'C');
			$this->Cell(20,4,'Empresa','RLB',1,'C');
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
	  $i=0; $can_conc=0; $totala_nom=0; $totald_nom=0; $cant_nom=0;	$totala_emp=0; $totald_emp=0; $cant_emp=0;  $totala_conc=0; $totald_conc=0; 
	  //$pdf->MultiCell(200,3,$sSQL,0); 
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_deduccion"]; $monto_deduccion=$registro["monto_aporte"];
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		if($prev_emp<>$cod_empleado){		
		   if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
			if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(18,3,$prev_emp,0,0);
			$pdf->Cell(122,3,$prev_nombre,0,0);			
			$pdf->Cell(20,3,$prev_cedula,0,0,'C');
			$pdf->Cell(20,3,$totala_emp,0,0,'R');
			$pdf->Cell(20,3,$totald_emp,0,1,'R');			
		    $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $prev_cedula=$cedula; $cant_emp=$cant_emp+1; 
		}	
		$can_conc=$can_conc+$cantidad; $totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;		
		$totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;
      } if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
		if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(18,3,$prev_emp,0,0);
		$pdf->Cell(122,3,$prev_nombre,0,0);			
		$pdf->Cell(20,3,$prev_cedula,0,0,'C');
		$pdf->Cell(20,3,$totala_emp,0,0,'R');
		$pdf->Cell(20,3,$totald_emp,0,1,'R');			
		$can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $cant_emp=$cant_emp+1; 
		
		$totala_conc=formato_monto($totala_conc); $totald_conc=formato_monto($totald_conc);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(140,2,'',0,0);
		$pdf->Cell(20,2,'',0,0,'R');
		$pdf->Cell(20,2,'--------------------',0,0,'R');
		$pdf->Cell(20,2,'--------------------',0,1,'R');
		$pdf->Cell(60,4,'Nro. Trabjadores : '.$cant_emp,0,0);			
		if($mes_comp=='S'){ $pdf->Cell(100,4,'TOTAL GENERAL ',0,0); }
		else{ $pdf->Cell(100,4,'TOTAL '.$den_conc,0,0);}
		$pdf->Cell(20,4,$totala_conc,0,0,'R');
		$pdf->Cell(20,4,$totald_conc,0,0,'R');	
	  $pdf->Output();   
    
    	
}
?>
