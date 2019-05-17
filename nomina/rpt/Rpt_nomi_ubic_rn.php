<? include ("../../class/conect.php");  require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;  error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist="S";  $fecha_desde=$_GET["fecha_desde"];    $fecha_hasta=$_GET["fecha_hasta"]; $fecha_nom=$_GET["fecha_hasta"];    
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $tipo_concepto=$_GET["tipo_concepto"]; $tipo_rpt="PDF";
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"]; $forma_pago=$_GET["forma_pago"];
   $tipo_rpt="PDF"; $esp_firma="NO"; $salto_dep="NO"; $tipo_reporte='N'; $act_hist="N";  
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS'); </script> <?}
else{  $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";} 
   if($tipo_calculo=="T"){ $cri_tp=" and ((tp_calculo='N')or(tp_calculo='E'))  "; } else { $cri_tp=" and (tp_calculo='".$tipo_calculo."') "; }   
   $cfechan=formato_aaaammdd($fecha_nom);  $Sql="";   $date = date("d-m-Y");   $hora = date("H:i:s a");
   if($tipo_reporte=='N'){$criterio1="RELACION DE NOMINA DEFINITIVA";} else{$criterio1="RELACION DE NOMINA DEFINITIVA (PRE-NOMINA)";}
   $criterio="rpt_nom_cal WHERE (oculto='NO') ";   
   $sql="select fecha_p_hasta from nom017 where (fecha_p_hasta='".$cfechan."') and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') ".$cri_tp;
   $res=pg_query($sql); $filas=pg_num_rows($res); if($filas==0){$act_hist="S";  }   
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (oculto='NO') ";} 
   if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}   
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and ((concepto_vac='N') or (cod_concepto='VVV'))";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and ((concepto_vac='S') and (cod_concepto<>'VVV')) ";}      
   $criterio=$criterio.$cri_tp;
$criterio=$criterio."  and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."')";
  $Sql = "SELECT count(distinct cod_empleado) as cant_trab  FROM ".$criterio ;
  $res=pg_query($Sql); $filas=pg_num_rows($res); if($filas>0){ $registro=pg_fetch_array($res,0); $criterio2=$registro["cant_trab"];  }	
  $sSQL = "SELECT *  FROM ".$criterio."  order by tipo_nomina, codigo_ubicacion, cod_cargo, cod_empleado, cod_concepto";
  //ECHO $sSQL;
  if($tipo_rpt=="PDF"){	 $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $prev_emp=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $cod_mun=""; $des_mun=""; $prev_mun=""; $prev_den_mun="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $codigo_ubicacion=$registro["codigo_ubicacion"]; $descripcion_ubi=$registro["descripcion_ubi"]; 
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $descripcion_ubi=utf8_decode($descripcion_ubi);}
        $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$codigo_ubicacion;  $prev_den_dep=$descripcion_ubi; $prev_emp="";
		
		$cod_mun=substr($codigo_ubicacion,0,3); $des_mun="";
		switch($cod_mun){
			Case "001":
			  $des_mun="ARISTIDES BASTIDAS"; break;
			Case "002":
			 $des_mun="BOLIVAR"; break;
			Case "003":
			 $des_mun="BRUZUAL"; break;
			Case "004":
			 $des_mun="COCOROTE"; break;
			Case "005":
			 $des_mun="INDEPENDENCIA"; break;
			Case "006":
			 $des_mun="LA TRINIDAD"; break;
            Case "007":
			 $des_mun="MANUEL MONGE";	break;
            Case "008":
			 $des_mun="NIRGUA"; break;
            Case "009":
			 $des_mun="JOSE ANTONIO PAEZ";	break;
            Case "010":
			 $des_mun="PEÑA";	break;
            Case "011":
			 $des_mun="SAN FELIPE"; break;
            Case "012":
			 $des_mun="SUCRE";	break;
            Case "013":
			 $des_mun="URACHICHE"; break;
            Case "014":
			 $des_mun="VEROES";	break;		 
			default:
			 $des_mun=""; break;
		}
		$prev_mun=$cod_mun; $prev_den_mun=$des_mun;
      }
		
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tipo_nomina; global $des_nomina; global $fechad; global $fechah; 
		global $codigo_ubicacion; global $descripcion_ubi; global $cod_mun; global $des_mun;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(140,7,$criterio1,1,0,'C');
			$this->Ln(18);
			$this->SetFont('Arial','B',8);
			$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');
			$this->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');
			$this->SetFont('Arial','B',7);
			$this->Cell(50,5,'Trabajador',1,0);
			$this->Cell(10,5,'Codigo',1,0);
			$this->Cell(80,5,'Descripcion Concepto',1,0,'L');
			$this->Cell(20,5,'Asignaciones',1,0);
			$this->Cell(20,5,'Deducciones',1,0);
			$this->Cell(20,5,'Neto',1,1,'C');
			$this->Cell(200,5,$des_mun,0,1,'C');
			$this->Cell(200,5,"UBICACION : ".$codigo_ubicacion." ".$descripcion_ubi,0,1,'L');
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
	  $totala_mun=0; $totald_mun=0; $cant_mun=0;
	  $totala_conc=0; $totald_conc=0; $prev_conc=""; $den_conc=""; $totala_g=0; $totald_g=0; $cant_g=0;
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $codigo_ubicacion=$registro["codigo_ubicacion"]; $descripcion_ubi=$registro["descripcion_ubi"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
		$denominacion=substr($denominacion,0,60);
		$cod_mun=substr($codigo_ubicacion,0,3); $des_mun="";
		switch($cod_mun){
			Case "001":
			  $des_mun="ARISTIDES BASTIDAS"; break;
			Case "002":
			 $des_mun="BOLIVAR"; break;
			Case "003":
			 $des_mun="BRUZUAL"; break;
			Case "004":
			 $des_mun="COCOROTE"; break;
			Case "005":
			 $des_mun="INDEPENDENCIA"; break;
			Case "006":
			 $des_mun="LA TRINIDAD"; break;
            Case "007":
			 $des_mun="MANUEL MONGE";	break;
            Case "008":
			 $des_mun="NIRGUA"; break;
            Case "009":
			 $des_mun="JOSE ANTONIO PAEZ";	break;
            Case "010":
			 $des_mun="PEÑA";	break;
            Case "011":
			 $des_mun="SAN FELIPE"; break;
            Case "012":
			 $des_mun="SUCRE";	break;
            Case "013":
			 $des_mun="URACHICHE"; break;
            Case "014":
			 $des_mun="VEROES";	break;		 
			default:
			 $des_mun=""; break;
		}
		
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_cargo=utf8_decode($des_cargo);  $descripcion_ubi=utf8_decode($descripcion_ubi);  $nombre=utf8_decode($nombre); $denominacion=utf8_decode($denominacion);}
		if(($prev_emp<>$cod_empleado)or($prev_dep<>$codigo_ubicacion)or($prev_tipo<>$tipo_nomina)or($prev_mun<>$cod_mun)){
		  $pdf->SetFont('Arial','',7);
		  if($can_conc>0){$neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} 
			if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);}
			$pdf->Cell(50,3,'',0,0);
			$pdf->Cell(6,3,$prev_conc,0,0);
			$pdf->Cell(84,3,$den_conc,0,0,'L');
			$pdf->Cell(20,3,$totala_conc,0,0,'R');
			$pdf->Cell(20,3,$totald_conc,0,0,'R');
			$pdf->Cell(20,3,$neto,0,1,'R');
			$pdf->SetFont('Arial','B',7);
		    $prev_conc=$cod_concepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0;  
		    $neto=$totala_emp-$totald_emp; $neto=formato_monto($neto);
		    $totala_emp=formato_monto($totala_emp); $totald_emp=formato_monto($totald_emp);
		    $pdf->Cell(140,2,'',0,0);
			$pdf->Cell(20,2,'---------------------',0,0,'R');
			$pdf->Cell(20,2,'---------------------',0,0,'R');
			$pdf->Cell(20,2,'---------------------',0,1,'R');
			if($esp_firma=="SI"){
			$pdf->Cell(140,3,'Recibe Conforme:',0,0);}else{
			$pdf->Cell(140,3,'',0,0);}
			$pdf->Cell(20,3,$totala_emp,0,0,'R');
			$pdf->Cell(20,3,$totald_emp,0,0,'R');
			$pdf->Cell(20,3,$neto,0,1,'R');
			if($esp_firma=="SI"){$pdf->Ln(5);$pdf->Cell(140,3,'________________________',0,1);}
            $pdf->Ln(8); 
		  } 
		  if(($prev_dep<>$codigo_ubicacion)or($prev_tipo<>$tipo_nomina)or($prev_mun<>$cod_mun)){$neto=$totala_dep-$totald_dep; $neto=formato_monto($neto);
		    $totala_dep=formato_monto($totala_dep); $totald_dep=formato_monto($totald_dep);
		    $pdf->Cell(140,2,'',0,0);
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,1,'R');			
			$pdf->Cell(130,3,'Total : '.$prev_den_dep,0,0);
			$pdf->Cell(10,3,$cant_dep,0,0,'C');			
			$pdf->Cell(20,3,$totala_dep,0,0,'R');
			$pdf->Cell(20,3,$totald_dep,0,0,'R');
			$pdf->Cell(20,3,$neto,0,1,'R');
			$prev_dep=$codigo_ubicacion;  $prev_den_dep=$descripcion_ubi; $cant_dep=0; $totala_dep=0; $totald_dep=0;
			$s_mun=0;
			if($prev_mun<>$cod_mun){$neto=$totala_mun-$totald_mun; $neto=formato_monto($neto);
				$totala_mun=formato_monto($totala_mun); $totald_mun=formato_monto($totald_mun);
				$pdf->Ln(5);
				$pdf->Cell(140,2,'',0,0);
				$pdf->Cell(20,2,'============',0,0,'R');
				$pdf->Cell(20,2,'============',0,0,'R');
				$pdf->Cell(20,2,'============',0,1,'R');
				$pdf->Cell(130,3,'Total : '.$prev_den_mun,0,0);
				$pdf->Cell(10,3,$cant_mun,0,0,'C');			
				$pdf->Cell(20,3,$totala_mun,0,0,'R');
				$pdf->Cell(20,3,$totald_mun,0,0,'R');
				$pdf->Cell(20,3,$neto,0,1,'R');
				$prev_mun=$cod_mun; $prev_den_mun=$des_mun; $totala_mun=0; $totald_mun=0; $cant_mun=0; $s_mun=1;
			}
			
			if($prev_tipo<>$tipo_nomina){$neto=$totala_nom-$totald_nom; $neto=formato_monto($neto);
				$totala_nom=formato_monto($totala_nom); $totald_nom=formato_monto($totald_nom);
				$pdf->Ln(10);
				$pdf->Cell(140,2,'',0,0);
				$pdf->Cell(20,2,'============',0,0,'R');
				$pdf->Cell(20,2,'============',0,0,'R');
				$pdf->Cell(20,2,'============',0,1,'R');			
				$pdf->Cell(130,3,'Total : '.$prev_den_nom,0,0);
				$pdf->Cell(10,3,$cant_nom,0,0,'C');			
				$pdf->Cell(20,3,$totala_nom,0,0,'R');
				$pdf->Cell(20,3,$totald_nom,0,0,'R');
				$pdf->Cell(20,3,$neto,0,1,'R');
				$prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $cant_nom=0; $totala_nom=0; $totald_nom=0;
			}
			if($salto_dep=="SI"){$pdf->AddPage();}
			else{
			    $pdf->Ln(10);
			   if($s_mun==1){
			   $x=$pdf->GetX();   $y=$pdf->GetY(); if($y<249){ $pdf->Cell(200,5,$des_mun,0,1,'C');	}  $pdf->Ln(5); }	 
			   $x=$pdf->GetX();   $y=$pdf->GetY(); if($y<249){ $pdf->Cell(200,5,"UBICACION : ".$codigo_ubicacion." ".$descripcion_ubi,0,1,'L');	}
			}
			
		  } $sueldo_cargo=formato_monto($sueldoc); 
		  
		  $pdf->SetFont('Arial','',7);
		  $pdf->Cell(140,3,$cod_empleado." ".$nombre,0,0,'L'); 
          $pdf->Cell(20,3,$cedula,0,0,'R'); 
		  $pdf->Cell(40,3,"Fecha de Ingreso : ".$fechai,0,1,'R'); 
		  $pdf->Cell(160,3,"Cargo : ".$des_cargo,0,0,'L');
		  $pdf->Cell(40,3,"Sueldo : ".$sueldo_cargo,0,1,'R'); 
		  $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $cant_dep=$cant_dep+1; $cant_nom=$cant_nom+1; $cant_g=$cant_g+1; $cant_mun=$cant_mun+1;
		  
		}		
		if($prev_conc<>$cod_concepto){		
		  if($prev_conc<>""){$neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);}
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(50,3,'',0,0);
			$pdf->Cell(6,3,$prev_conc,0,0);
			$pdf->Cell(84,3,$den_conc,0,0,'L');
			$pdf->Cell(20,3,$totala_conc,0,0,'R');
			$pdf->Cell(20,3,$totald_conc,0,0,'R');
			$pdf->Cell(20,3,$neto,0,1,'R');}
		  $prev_conc=$cod_concepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0; 
		}	
		$can_conc=$can_conc+1; $totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;		
		$totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;
		$totala_nom=$totala_nom+$monto_asignacion; $totald_nom=$totald_nom+$monto_deduccion;
		$totala_dep=$totala_dep+$monto_asignacion; $totald_dep=$totald_dep+$monto_deduccion;
		$totala_mun=$totala_mun+$monto_asignacion; $totald_mun=$totald_mun+$monto_deduccion; 
		
		$totala_g=$totala_g+$monto_asignacion; $totald_g=$totald_g+$monto_deduccion; 
        }$neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} 
		
			if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);}
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(50,3,'',0,0);
			$pdf->Cell(6,3,$prev_conc,0,0);
			$pdf->Cell(84,3,$den_conc,0,0,'L');
			$pdf->Cell(20,3,$totala_conc,0,0,'R');
			$pdf->Cell(20,3,$totald_conc,0,0,'R');
			$pdf->Cell(20,3,$neto,0,1,'R');
			$pdf->SetFont('Arial','B',7);
            $neto=$totala_emp-$totald_emp; $neto=formato_monto($neto);
		    $totala_emp=formato_monto($totala_emp); $totald_emp=formato_monto($totald_emp);
		    $pdf->Cell(140,2,'',0,0);
			$pdf->Cell(20,2,'---------------------',0,0,'R');
			$pdf->Cell(20,2,'---------------------',0,0,'R');
			$pdf->Cell(20,2,'---------------------',0,1,'R');
			if($esp_firma=="SI"){
			$pdf->Cell(140,3,'Recibe Conforme:',0,0);}else{
			$pdf->Cell(140,3,'',0,0);}
			$pdf->Cell(20,3,$totala_emp,0,0,'R');
			$pdf->Cell(20,3,$totald_emp,0,0,'R');
			$pdf->Cell(20,3,$neto,0,1,'R');
			if($esp_firma=="SI"){$pdf->Ln(5);$pdf->Cell(140,3,'________________________',0,1);}
            $pdf->Ln(8); 
			
            $neto=$totala_dep-$totald_dep; $neto=formato_monto($neto);
		    $totala_dep=formato_monto($totala_dep); $totald_dep=formato_monto($totald_dep);
		    $pdf->Cell(140,2,'',0,0);
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,1,'R');			
			$pdf->Cell(130,2,'Total : '.$prev_den_dep,0,0);
			$pdf->Cell(10,2,$cant_dep,0,0,'C');			
			$pdf->Cell(20,2,$totala_dep,0,0,'R');
			$pdf->Cell(20,2,$totald_dep,0,0,'R');
			$pdf->Cell(20,2,$neto,0,1,'R'); 
			
			$neto=$totala_mun-$totald_mun; $neto=formato_monto($neto);
			$totala_mun=formato_monto($totala_mun); $totald_mun=formato_monto($totald_mun);
			$pdf->Ln(5);
			$pdf->Cell(140,2,'',0,0);
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,1,'R');
			$pdf->Cell(130,3,'Total : '.$prev_den_mun,0,0);
			$pdf->Cell(10,3,$cant_mun,0,0,'C');			
			$pdf->Cell(20,3,$totala_mun,0,0,'R');
			$pdf->Cell(20,3,$totald_mun,0,0,'R');
			$pdf->Cell(20,3,$neto,0,1,'R');
            $neto=$totala_nom-$totald_nom; $neto=formato_monto($neto);
			$totala_nom=formato_monto($totala_nom); $totald_nom=formato_monto($totald_nom);
			$pdf->Ln(10);
			$pdf->Cell(140,2,'',0,0);
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,1,'R');			
			$pdf->Cell(130,2,'Total : '.$prev_den_nom,0,0);
			$pdf->Cell(10,2,$cant_nom,0,0,'C');			
			$pdf->Cell(20,2,$totala_nom,0,0,'R');
			$pdf->Cell(20,2,$totald_nom,0,0,'R');
			$pdf->Cell(20,2,$neto,0,1,'R');		
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

            $pdf->Ln(10);
			$x=$pdf->GetX();   $y=$pdf->GetY(); if($y<234){$y=234;   $pdf->SetXY($x,$y);}  
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(10,5,'',0,0);
			$pdf->Cell(45,5,'Elaborado Por:',1,0,'C');
			$pdf->Cell(45,5,'Revisado Por:',1,0,'C');
			$pdf->Cell(45,5,'Conformidad Presupuestaria',1,0,'C');
			$pdf->Cell(45,5,'Aprobado Por:',1,0,'C');
			$pdf->Cell(10,5,'',0,1);			
			$pdf->Cell(10,10,'',0,0);
			$pdf->Cell(45,10,'',1,0,'C');
			$pdf->Cell(45,10,'',1,0,'C');
			$pdf->Cell(45,10,'',1,0,'C');
			$pdf->Cell(45,10,'',1,0,'C');
			$pdf->Cell(10,10,'',0,1);			
			$pdf->Cell(10,5,'',0,0);
			$pdf->Cell(45,5,'Analista de Nomina',1,0,'C');
			$pdf->Cell(45,5,'Coordinacion de Nomina',1,0,'C');
			$pdf->Cell(45,5,'Coordinacion  Administrativa',1,0,'C');
			$pdf->Cell(45,5,'Directora de Recursos Humanos',1,0,'C');
			$pdf->Cell(10,5,'',0,1);
			
	  $pdf->Output();   
    }	
}
?>