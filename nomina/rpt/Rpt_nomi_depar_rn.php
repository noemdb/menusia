<? include ("../../class/conect.php");  require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc");  error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"];   $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist=$_GET["act_hist"]; $fecha_nom=$_GET["fecha_nom"]; $tipo_concepto=$_GET["tipo_concepto"];
   $estatus_trab_d=$_GET["estatus_trab_d"];   $ocultar_n=$_GET["ocultar_n"]; $imprimir_esp=$_GET["imprimir_esp"];   $mostrar_cant=$_GET["mostrar_cant"];  $tipo_rpt=$_GET["tipo_rpt"];
   $mostrar_saldo=$_GET["mostrar_saldo"];   $forma_pago=$_GET["forma_pago"]; $tipo_reporte=$_GET["tipo_reporte"];   $tipo_calculo=$_GET["tipo_calculo"]; $num_periodos=$_GET["num_periodos"];
   $cod_presup_catd=$_GET["cod_presup_catd"];    $cod_presup_cath=$_GET["cod_presup_cath"];$cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"];
   $salto_dep=$_GET["salto_dep"]; $esp_firma=$_GET["esp_firma"]; $rango_f=$_GET["rango_f"]; $fecha_desde=$_GET["fecha_desde"];  $fecha_hasta=$_GET["fecha_hasta"];  $cfechad=formato_aaaammdd($fecha_desde); $cfechah=formato_aaaammdd($fecha_hasta);
   $cfechan=formato_aaaammdd($fecha_nom);  $Sql="";   $date=date("d-m-Y");   $hora=date("H:i:s a");
   if($tipo_reporte=='N'){$criterio1="RELACION NOMINA POR DEPARTAMENTO ";} else{$criterio1="RELACION NOMINA POR DEPARTAMENTO (PRE-NOMINA)";}
   $criterio="rpt_nom_cal WHERE (oculto='NO') ";  $criterio3="FECHA AL ".$fecha_nom;
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (oculto='NO') ";} 
   if($rango_f=='S'){ $act_hist='S';  $mes_comp='S'; $criterio="rpt_nom_hist WHERE (fecha_p_hasta>='".$cfechad."') and (fecha_p_hasta<='".$cfechah."') and (oculto='NO')  ";   
                      $criterio3="FECHA: ".$fecha_desde." AL ".$fecha_hasta;	} 
   if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}   
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and ((concepto_vac='N') or (cod_concepto='VVV'))";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and ((concepto_vac='S') and (cod_concepto<>'VVV')) ";}    
  
  $cri_tp=" and (tp_calculo='".$tipo_calculo."') ";  
  if($tipo_calculo=="E") { $cri_tp=" and ((tp_calculo='E')and(num_periodos=$num_periodos))  "; } 
  $criterio=$criterio.$cri_tp." and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') 
   and (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_categ>='".$cod_presup_catd."' and cod_categ<='".$cod_presup_cath."') ";
   
   
   
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS'); </script> <?}
else{  $Nom_Emp=busca_conf(); $php_os=PHP_OS;  if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}

$cant_vacantes=0; 
/*  */
if($Cod_Emp=="02"){  $tipo_rpt="PDF2";
  $sqlv="SELECT * FROM ".$criterio." and status_emp='VACANTE'" ; $resp=pg_query($sqlv); $filasb=pg_num_rows($resp);  // echo $filasb." ".$sqlv;
  if($filasb>0){ $sqlv="SELECT count(distinct cod_empleado) as cant_vacantes  FROM ".$criterio." and status_emp='VACANTE'" ;
    $res=pg_query($sqlv); if($reg=pg_fetch_array($res,0)){$cant_vacantes=$reg["cant_vacantes"]; } else { $cant_vacantes=0; }	}
}

	
function muestra_cant($mop,$mtipo,$mdep,$mcod_emp){global $criterio; global $host; global $port; global $password; global $user; global $dbname;
   $conn=pg_connect("host=".$host."  port=".$port." password=".$password." user=".$user." dbname=".$dbname."");    $cant=0;
   $fsql = "SELECT count(distinct cod_empleado) as cant_trab  from ".$criterio." and (tipo_nomina='".$mtipo."')";
   if($mop==2){ $fsql = "SELECT count(distinct cod_empleado) as cant_trab  from ".$criterio." and (tipo_nomina='".$mtipo."') and (cod_departam='".$mdep."')";}
   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){$freg=pg_fetch_array($fres); $cant=$freg["cant_trab"];} 
   return $cant;
}

  $Sql = "SELECT count(distinct cod_empleado) as cant_trab  FROM ".$criterio ;
  $res=pg_query($Sql); $filas=pg_num_rows($res); if($filas>0){ $registro=pg_fetch_array($res,0); $criterio2=$registro["cant_trab"];  }	
  $sSQL = "SELECT *  FROM ".$criterio."  order by tipo_nomina, cod_departam, cod_cargo, cod_empleado, cod_concepto";
  if($Cod_Emp=="02"){ 
    $sSQL = "SELECT *  FROM ".$criterio."  order by tipo_nomina, cod_departam, cod_empleado, cod_concepto";
  }
  if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
      //echo $sSQL;
	  $oRpt = new PHPReportMaker();
	  $oRpt->setXML("Rpt_nomi_depar_rn_re.xml");
	  $oRpt->setUser("$user");
	  $oRpt->setPassword("$password");
	  $oRpt->setConnection("$host");
	  $oRpt->setDatabaseInterface("postgresql");
	  $oRpt->setSQL($sSQL);
	  $oRpt->setDatabase("$dbname");
	  $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"criterio3"=>$criterio3,"tipod"=>$tipo_nomina_d,"tipoh"=>$tipo_nomina_h,"date"=>$date,"hora"=>$hora));
	  $oRpt->run();
	  $aBench = $oRpt->getBenchmark();
  }	  
  if($tipo_rpt=="PDF"){	 $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $prev_emp=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam);}
        $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp="";
	  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){global $criterio1; global $tipo_nomina; global $des_nomina; global $fechad; global $fechah; global $prev_dep; global $prev_den_dep; global $rango_f; global $criterio3;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(140,7,$criterio1,1,0,'C');
			$this->Ln(18);
			$this->SetFont('Arial','B',8);
			$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');
			if($rango_f=='S'){$this->Cell(140,5,$criterio3,0,1,'L');}else{$this->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');}
			$this->SetFont('Arial','B',7);
			$this->Cell(50,5,'Trabajador',1,0);
			$this->Cell(10,5,'Codigo',1,0);
			$this->Cell(80,5,'Descripcion Concepto',1,0,'L');
			$this->Cell(20,5,'Asignaciones',1,0);
			$this->Cell(20,5,'Deducciones',1,0);
			$this->Cell(20,5,'Neto',1,1,'C');
			$this->Cell(140,5,"DEPARTAMENTO : ".$prev_dep." ".$prev_den_dep,0,1,'L');
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
	  $totala_conc=0; $totald_conc=0; $prev_conc=""; $den_conc=""; $totala_g=0; $totald_g=0; $cant_g=0; $total_cant=0; $prev_prestamo=""; $prev_valore=0; $prev_valorq=0; $prev_valoru=0;
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"]; 
		$prestamo=$registro["prestamo"]; $valore=$registro["valore"]; $valorq=$registro["valorq"]; $valoru=$registro["valoru"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
		$denominacion=substr($denominacion,0,60);
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_cargo=utf8_decode($des_cargo);  $des_departam=utf8_decode($des_departam);  $nombre=utf8_decode($nombre); $denominacion=utf8_decode($denominacion);}
		if(($prev_emp<>$cod_empleado)or($prev_dep<>$cod_departam)or($prev_tipo<>$tipo_nomina)){
		  $pdf->SetFont('Arial','',7);
		  if($can_conc>0){$neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} 
			if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);}  $total_cant=formato_monto($total_cant);
			$pdf->Cell(50,3,'',0,0);
			$pdf->Cell(6,3,$prev_conc,0,0);
			$pdf->Cell(78,3,$den_conc,0,0,'L');
			$pdf->Cell(6,3,$total_cant,0,0,'R');
			$pdf->Cell(20,3,$totala_conc,0,0,'R');
			$pdf->Cell(20,3,$totald_conc,0,0,'R');
			$pdf->Cell(20,3,$neto,0,1,'R');
			$pdf->SetFont('Arial','B',7);
		    $prev_conc=$cod_concepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0;  $total_cant=0;
			$prev_prestamo=$prestamo; $prev_valore=$valore; $prev_valorq=$valorq; $prev_valoru=$valoru;
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
		  if(($prev_dep<>$cod_departam)or($prev_tipo<>$tipo_nomina)){$neto=$totala_dep-$totald_dep; $neto=formato_monto($neto);
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
			$prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $cant_dep=0; $totala_dep=0; $totald_dep=0;
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
			if($salto_dep=="SI"){$pdf->AddPage();}else{$pdf->Ln(10);
			  $pdf->Cell(140,5,"DEPARTAMENTO : ".$cod_departam." ".$des_departam,0,1,'L');
			}
		  } $sueldo_cargo=formato_monto($sueldoc); 
		  $pdf->SetFont('Arial','',7);
		  $pdf->Cell(140,3,$cod_empleado." ".$nombre,0,0,'L'); 
          $pdf->Cell(20,3,$cedula,0,0,'R'); 
		  $pdf->Cell(40,3,"Fecha de Ingreso : ".$fechai,0,1,'R'); 
		  $pdf->Cell(160,3,"Cargo : ".$des_cargo,0,0,'L');
		  $pdf->Cell(40,3,"Sueldo : ".$sueldo_cargo,0,1,'R'); 
		  $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $cant_dep=$cant_dep+1; $cant_nom=$cant_nom+1; $cant_g=$cant_g+1;
		  
		}		
		if($prev_conc<>$cod_concepto){		
		  if($prev_conc<>""){$neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);} $total_cant=formato_monto($total_cant);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(50,3,'',0,0);
			$pdf->Cell(6,3,$prev_conc,0,0);
			$pdf->Cell(78,3,$den_conc,0,0,'L');
			$pdf->Cell(6,3,$total_cant,0,0,'R');
			$pdf->Cell(20,3,$totala_conc,0,0,'R');
			$pdf->Cell(20,3,$totald_conc,0,0,'R');
			$pdf->Cell(20,3,$neto,0,1,'R');}
		  $prev_conc=$cod_concepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0; $total_cant=0;
		}	
		$can_conc=$can_conc+1; $totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;	$total_cant=$total_cant+$cantidad;	
		$totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;
		$totala_nom=$totala_nom+$monto_asignacion; $totald_nom=$totald_nom+$monto_deduccion;
		$totala_dep=$totala_dep+$monto_asignacion; $totald_dep=$totald_dep+$monto_deduccion;
		$totala_g=$totala_g+$monto_asignacion; $totald_g=$totald_g+$monto_deduccion; 
      } $neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} 
			if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);} $total_cant=formato_monto($total_cant);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(50,3,'',0,0);
			$pdf->Cell(6,3,$prev_conc,0,0);
			$pdf->Cell(78,3,$den_conc,0,0,'L');
			$pdf->Cell(6,3,$total_cant,0,0,'R');
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
 		 //  ESTO ES PARA LA FIRMA AL FINAL
        $y=$pdf->GetY();  $t=10;
        if($y>245){$t=10; $pdf->Cell(5,4,'',0,1);  } 
        $pdf->ln($t); $y=$pdf->GetY();
	    if($y<250){$t=250-$y; $pdf->ln($t);} 
        $pdf->Cell(60,4,'Elaborado por','T',0,'C');
        $pdf->Cell(5,4,'',0,0);
        $pdf->Cell(65,4,'Revisado por','T',0,'C');
        $pdf->Cell(5,4,'',0,0);
        $pdf->Cell(65,4,'Autorizado por','T',1,'C');
        $pdf->Cell(60,3,' ',0,0,'C');
        $pdf->Cell(70,3,' ',0,0,'C');
        $pdf->Cell(70,3,' ',0,1,'C');  		 
	    $pdf->Output();		
	  $pdf->Output();   
    }	

    if($tipo_rpt=="PDF2"){	 $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $prev_emp=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam);}
        $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp="";
	  }	  
	  $tipo_en=1;
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $tipo_en; global $criterio1; global $tipo_nomina; global $des_nomina; global $fechad; global $fechah; global $prev_dep; global $prev_den_dep; global $rango_f; global $criterio3;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			if($tipo_en==2){ $this->Cell(140,7,'RESUMEN DE CONCEPTOS POR DEPARTAMENTO',1,0,'C'); }
			else{$this->Cell(140,7,$criterio1,1,0,'C');}
			$this->Ln(18);
			$this->SetFont('Arial','B',8);
			$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');
			if($rango_f=='S'){$this->Cell(140,5,$criterio3,0,1,'L');}else{$this->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');}			
			$this->Cell(140,5,"DEPARTAMENTO : ".$prev_dep." ".$prev_den_dep,0,1,'L');
			
			
			
			if($tipo_en==2){
			$this->Cell(12,5,'Codigo',1,0);
			$this->Cell(122,5,'Descripcion Concepto',1,0,'L');
			$this->Cell(22,5,'Asignaciones',1,0);
			$this->Cell(22,5,'Deducciones',1,0);
			$this->Cell(22,5,'',1,1,'C');
			}else{ $this->SetFont('Arial','B',7);
			$this->Cell(50,5,'Trabajador',1,0);
			$this->Cell(10,5,'Codigo',1,0);
			$this->Cell(80,5,'Descripcion Concepto',1,0,'L');
			$this->Cell(20,5,'Asignaciones',1,0);
			$this->Cell(20,5,'Deducciones',1,0);
			$this->Cell(20,5,'Neto',1,1,'C');
			}
			
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			//$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0; $can_conc=0; $totala_nom=0; $totald_nom=0; $cant_nom=0;	$totala_dep=0; $totald_dep=0; $cant_dep=0;  $totala_emp=0; $totald_emp=0; $cant_dep_a=0; $cant_dep_v=0; $monto_dep_v=0;
	  $totala_conc=0; $totald_conc=0; $prev_conc=""; $den_conc=""; $totala_g=0; $totald_g=0; $cant_g=0; $total_cant=0; $prev_prestamo=""; $prev_valore=0; $prev_valorq=0; $prev_valoru=0;
	  //$pdf->MultiCell(200,3,$sSQL,0);	  
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"]; $status_emp=$registro["status_emp"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$tipo_pago=$registro["tipo_pago"]; $nombre_banco=$registro["nombre_banco"]; $cta_empleado=$registro["cta_empleado"]; $cta_empresa=$registro["cta_empresa"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"];
		$prestamo=$registro["prestamo"]; $valore=$registro["valore"]; $valorq=$registro["valorq"]; $valoru=$registro["valoru"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
		$denominacion=substr($denominacion,0,60);
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_cargo=utf8_decode($des_cargo);  $nombre_banco=utf8_decode($nombre_banco);  $des_departam=utf8_decode($des_departam);  $nombre=utf8_decode($nombre); $denominacion=utf8_decode($denominacion);}
		if(($prev_emp<>$cod_empleado)or($prev_dep<>$cod_departam)or($prev_tipo<>$tipo_nomina)){
		  $pdf->SetFont('Arial','',7);
		  if($can_conc>0){$neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} 
			if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);}  $total_cant=formato_monto($total_cant);
			$pdf->Cell(50,3,'',0,0); 
			if($prev_conc=='VVV'){$pdf->Cell(6,3,'',0,0); $pdf->Cell(78,3,'',0,0); $pdf->Cell(6,3,'',0,0);
			
			}else{$pdf->Cell(6,3,$prev_conc,0,0);
			$pdf->Cell(78,3,$den_conc,0,0,'L');
			//$pdf->Cell(6,3,$total_cant,0,0,'R');
			if(($prev_prestamo=="S")and($prev_valoru>0)){ $txt_prestamo=round($prev_valoru,0).'/'.round($prev_valorq,0); $pdf->Cell(6,3,$txt_prestamo,0,0,'R');   }else{$pdf->Cell(6,3,$total_cant,0,0,'R');}
		    }
			$pdf->Cell(20,3,$totala_conc,0,0,'R');
			$pdf->Cell(20,3,$totald_conc,0,0,'R');
			$pdf->Cell(20,3,$neto,0,1,'R');
			$pdf->SetFont('Arial','B',7);
		    $prev_conc=$cod_concepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0;  $total_cant=0;
			$prev_prestamo=$prestamo; $prev_valore=$valore; $prev_valorq=$valorq; $prev_valoru=$valoru;
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
		  if(($prev_dep<>$cod_departam)or($prev_tipo<>$tipo_nomina)){$neto=$totala_dep-$totald_dep; $neto=formato_monto($neto);
		    $totala_dep=formato_monto($totala_dep); $totald_dep=formato_monto($totald_dep);
			/*
		    $pdf->Cell(140,2,'',0,0);
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,1,'R');			
			$pdf->Cell(130,3,'Total : '.$prev_den_dep,0,0);
			//$pdf->Cell(10,3,$cant_dep,0,0,'C');
            $pdf->Cell(10,3,'',0,0,'C');			
			$pdf->Cell(20,3,$totala_dep,0,0,'R');
			$pdf->Cell(20,3,$totald_dep,0,0,'R');
			$pdf->Cell(20,3,$neto,0,1,'R');
			*/
			
			$tipo_en=2;	$sd=0;		
			/**/
			if($salto_dep=="SI"){$pdf->AddPage();}else{$pdf->Ln(10); }			
			$pdf->SetFont('Arial','',8);
			$sqld="SELECT cod_concepto,denominacion,asig_ded_apo,sum(monto_asignacion) as monto_asignacion,sum(monto_deduccion) as monto_deduccion FROM ".$criterio." and (tp_calculo='".$tipo_calculo."') and (tipo_nomina='".$prev_tipo."' and  cod_departam='".$prev_dep."' and cod_concepto<>'VVV') group by cod_concepto,denominacion,asig_ded_apo order by asig_ded_apo,cod_concepto";
			$dtotala_conc=0; $dtotald_conc=0;  $resd=pg_query($sqld); $filasd=pg_num_rows($resd);
		    while($regd=pg_fetch_array($resd)){ $dneto=""; $sd=$sd+1;
			   $dcod_concepto=$regd["cod_concepto"]; $ddenominacion=$regd["denominacion"];$dmonto_asignacion=$regd["monto_asignacion"]; $dmonto_deduccion=$regd["monto_deduccion"];
			   $dtotala_conc=$dtotala_conc+$dmonto_asignacion; $dtotald_conc=$dtotald_conc+$dmonto_deduccion; 
			   if($dmonto_asignacion==0){$dmonto_asignacion="";}else{$dmonto_asignacion=formato_monto($dmonto_asignacion);} if($dmonto_deduccion==0){$dmonto_deduccion="";}else{$dmonto_deduccion=formato_monto($dmonto_deduccion);}
			   $pdf->Cell(12,4,$dcod_concepto,0,0);
			   $pdf->Cell(122,4,$ddenominacion,0,0,'L');
			   $pdf->Cell(22,4,$dmonto_asignacion,0,0,'R');
			   $pdf->Cell(22,4,$dmonto_deduccion,0,0,'R');
			   $pdf->Cell(22,4,$dneto,0,1,'R');	
			
			}
			if($sd>0){
				$dtotala_conc=formato_monto($dtotala_conc); $dtotald_conc=formato_monto($dtotald_conc);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(134,2,'',0,0);
				$pdf->Cell(22,2,'============',0,0,'R');
				$pdf->Cell(22,2,'============',0,1,'R');
				$pdf->Cell(134,5,'Total : '.$prev_den_dep,0,0);
				$pdf->Cell(22,5,$dtotala_conc,0,0,'R');
				$pdf->Cell(22,5,$dtotald_conc,0,0,'R');
				$pdf->Cell(20,5,$neto,0,1,'R');
			}			
			$pdf->Ln(10);
		    $pdf->SetFont('Arial','B',9); 
		    $pdf->Cell(50,4,'',0,0,'L');
		    $pdf->Cell(50,4,'CODIGO PRESUPUESTARIO','B',0,'L');
		    $pdf->Cell(25,4,'MONTO','B',1,'C');
			$pdf->SetFont('Arial','',8);
			$sqld="SELECT cod_presup,sum(monto) as monto FROM ".$criterio." and (tp_calculo='".$tipo_calculo."') and  (asig_ded_apo='A') and (tipo_nomina='".$prev_tipo."' and  cod_departam='".$prev_dep."' and cod_concepto<>'VVV') group by cod_presup order by cod_presup";
			$dtotala_conc=0; $dtotald_conc=0;  $resd=pg_query($sqld); $filasd=pg_num_rows($resd);
		    while($regd=pg_fetch_array($resd)){ $dneto=""; $sd=$sd+1;
			   $dcod_presup=$regd["cod_presup"]; $dmonto_pre=$regd["monto"]; 
			   $dtotala_conc=$dtotala_conc+$dmonto_pre;  $dmonto_pre=formato_monto($dmonto_pre);
			   $pdf->Cell(50,4,'',0,0);
			   $pdf->Cell(50,4,$dcod_presup,0,0,'L');
			   $pdf->Cell(25,4,$dmonto_pre,0,1,'R');
			}
			if($sd>0){				
				$total_monto_asignacion=formato_monto($dtotala_conc);
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(100,3,'',0,0);
				$pdf->Cell(25,3,'=============',0,1,'R');
				$pdf->Cell(100,5,'TOTAL CODIGOS : ',0,0,'R');
				$pdf->Cell(25,5,$total_monto_asignacion,0,1,'R');
			}	
			$monto_dep_v=formato_monto($monto_dep_v);
			$pdf->Ln(5);
			$pdf->SetFont('Arial','B',8);
			$cant_dep_trab=$cant_dep_a+$cant_dep_v;
			$pdf->Cell(40,3,'TOTAL TRABAJADORES : ',0,0);		    
			$pdf->Cell(20,3,$cant_dep_trab,0,0);
			$pdf->Cell(30,3,'TOTAL ACTIVOS : ',0,0);		    
			$pdf->Cell(20,3,$cant_dep_a,0,0);
			$pdf->Cell(30,3,'TOTAL VACANTES : ',0,0);		    
			$pdf->Cell(10,3,$cant_dep_v,0,0);
			$pdf->Cell(15,3,'Monto : ',0,0);	
			$pdf->Cell(20,3,$monto_dep_v,0,1);
			
			$tipo_en=1;
			//if($salto_dep=="SI"){$pdf->AddPage();}else{$pdf->Ln(10); }
			$prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $cant_dep=0; $totala_dep=0; $totald_dep=0; $cant_dep_a=0; $cant_dep_v=0; $monto_dep_v=0;
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
			if($salto_dep=="SI"){$pdf->AddPage();}else{$pdf->Ln(10);
			  $pdf->Cell(140,5,"DEPARTAMENTO : ".$cod_departam." ".$des_departam,0,1,'L');
			}
		  } $sueldo_cargo=formato_monto($sueldoc); $temp_sueldo=$sueldoc/2;
		  $pdf->SetFont('Arial','',7);
		  $pdf->Cell(160,3,$cedula." ".$nombre,0,0,'L'); 
          //$pdf->Cell(20,3,$cedula,0,0,'R'); 
		  $pdf->Cell(40,3,"Fecha de Ingreso : ".$fechai,0,1,'R'); 
		  $pdf->Cell(160,3,"Cargo : ".$des_cargo,0,0,'L');
		  $pdf->Cell(40,3,"Sueldo Base : ".$sueldo_cargo,0,1,'R'); 
		  
		  if($tipo_pago=="DEPOSITO"){
			$pdf->Cell(130,5,'Deposito Banco: '.$nombre_banco,0,0,'L');  
			$pdf->Cell(70,5,'Cuenta Trabajdor Nro.: '.$cta_empleado,0,1,'R');
		  }else{ $pdf->Cell(120,5,'Forma de Pago: '.$tipo_pago,0,1,'L'); }
				
		  $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $cant_dep=$cant_dep+1; $cant_nom=$cant_nom+1; $cant_g=$cant_g+1;
		  if($status_emp=='VACANTE'){$cant_dep_v=$cant_dep_v+1;  $monto_dep_v=$monto_dep_v+$temp_sueldo; }else{$cant_dep_a=$cant_dep_a+1;}
		  
		}		
		if($prev_conc<>$cod_concepto){		
		  if($prev_conc<>""){$neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);} $total_cant=formato_monto($total_cant);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(50,3,'',0,0);
			if($prev_conc=='VVV'){$pdf->Cell(6,3,'',0,0);}else{$pdf->Cell(6,3,$prev_conc,0,0);}
			$pdf->Cell(78,3,$den_conc,0,0,'L');
			if(($prev_prestamo=="S")and($prev_valoru>0)){ $txt_prestamo=round($prev_valoru,0).'/'.round($prev_valorq,0); $pdf->Cell(6,3,$txt_prestamo,0,0,'R');   }else{$pdf->Cell(6,3,$total_cant,0,0,'R');}
			$pdf->Cell(20,3,$totala_conc,0,0,'R');
			$pdf->Cell(20,3,$totald_conc,0,0,'R');
			$pdf->Cell(20,3,$neto,0,1,'R');}
		  $prev_conc=$cod_concepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0; $total_cant=0;
		  $prev_prestamo=$prestamo; $prev_valore=$valore; $prev_valorq=$valorq; $prev_valoru=$valoru;
		}	
		$can_conc=$can_conc+1; $totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;	$total_cant=$total_cant+$cantidad;	
		$totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;
		$totala_nom=$totala_nom+$monto_asignacion; $totald_nom=$totald_nom+$monto_deduccion;
		$totala_dep=$totala_dep+$monto_asignacion; $totald_dep=$totald_dep+$monto_deduccion;
		$totala_g=$totala_g+$monto_asignacion; $totald_g=$totald_g+$monto_deduccion; 
      } $neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} 
			if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);} $total_cant=formato_monto($total_cant);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(50,3,'',0,0);
			if($prev_conc=='VVV'){$pdf->Cell(6,3,'',0,0);}else{$pdf->Cell(6,3,$prev_conc,0,0);}
			$pdf->Cell(78,3,$den_conc,0,0,'L');
			//$pdf->Cell(6,3,$total_cant,0,0,'R');
			if(($prev_prestamo=="S")and($prev_valoru>0)){ $txt_prestamo=round($prev_valoru,0).'/'.round($prev_valorq,0); $pdf->Cell(6,3,$txt_prestamo,0,0,'R');   }else{$pdf->Cell(6,3,$total_cant,0,0,'R');}
			
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
			/*
		    $pdf->Cell(140,2,'',0,0);
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,1,'R');			
			$pdf->Cell(130,2,'Total : '.$prev_den_dep,0,0);
			//$pdf->Cell(10,2,$cant_dep,0,0,'C');
            $pdf->Cell(10,2,'',0,0,'C');			
			$pdf->Cell(20,2,$totala_dep,0,0,'R');
			$pdf->Cell(20,2,$totald_dep,0,0,'R');
			$pdf->Cell(20,2,$neto,0,1,'R'); 
			*/
			
			$tipo_en=2;	$sd=0;	/**/
			if($salto_dep=="SI"){$pdf->AddPage();}else{$pdf->Ln(10); }			
			$pdf->SetFont('Arial','',8);
			$sqld="SELECT cod_concepto,denominacion,asig_ded_apo,sum(monto_asignacion) as monto_asignacion,sum(monto_deduccion) as monto_deduccion FROM ".$criterio." and (tp_calculo='".$tipo_calculo."') and (tipo_nomina='".$prev_tipo."' and  cod_departam='".$prev_dep."' and cod_concepto<>'VVV') group by cod_concepto,denominacion,asig_ded_apo order by asig_ded_apo,cod_concepto";
			$dtotala_conc=0; $dtotald_conc=0;  $resd=pg_query($sqld); $filasd=pg_num_rows($resd);
		    while($regd=pg_fetch_array($resd)){ $dneto=""; $sd=$sd+1;
			   $dcod_concepto=$regd["cod_concepto"]; $ddenominacion=$regd["denominacion"];$dmonto_asignacion=$regd["monto_asignacion"]; $dmonto_deduccion=$regd["monto_deduccion"];
			   $dtotala_conc=$dtotala_conc+$dmonto_asignacion; $dtotald_conc=$dtotald_conc+$dmonto_deduccion; 
			   if($dmonto_asignacion==0){$dmonto_asignacion="";}else{$dmonto_asignacion=formato_monto($dmonto_asignacion);} if($dmonto_deduccion==0){$dmonto_deduccion="";}else{$dmonto_deduccion=formato_monto($dmonto_deduccion);}
			   $pdf->Cell(12,4,$dcod_concepto,0,0);
			   $pdf->Cell(122,4,$ddenominacion,0,0,'L');
			   $pdf->Cell(22,4,$dmonto_asignacion,0,0,'R');
			   $pdf->Cell(22,4,$dmonto_deduccion,0,0,'R');
			   $pdf->Cell(22,4,$dneto,0,1,'R');				
			}
			if($sd>0){
				$dtotala_conc=formato_monto($dtotala_conc); $dtotald_conc=formato_monto($dtotald_conc);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(134,2,'',0,0);
				$pdf->Cell(22,2,'============',0,0,'R');
				$pdf->Cell(22,2,'============',0,1,'R');
				$pdf->Cell(134,5,'Total : '.$prev_den_dep,0,0);
				$pdf->Cell(22,5,$dtotala_conc,0,0,'R');
				$pdf->Cell(22,5,$dtotald_conc,0,0,'R');
				$pdf->Cell(20,5,$neto,0,1,'R');
			}			
			$pdf->Ln(10);
		    $pdf->SetFont('Arial','B',9); 
		    $pdf->Cell(50,4,'',0,0,'L');
		    $pdf->Cell(50,4,'CODIGO PRESUPUESTARIO','B',0,'L');
		    $pdf->Cell(25,4,'MONTO','B',1,'C');
			$pdf->SetFont('Arial','',8);
			$sqld="SELECT cod_presup,sum(monto) as monto FROM ".$criterio." and (tp_calculo='".$tipo_calculo."') and  (asig_ded_apo='A') and (tipo_nomina='".$prev_tipo."' and  cod_departam='".$prev_dep."' and cod_concepto<>'VVV') group by cod_presup order by cod_presup";
			$dtotala_conc=0; $dtotald_conc=0;  $resd=pg_query($sqld); $filasd=pg_num_rows($resd);
		    while($regd=pg_fetch_array($resd)){ $dneto=""; $sd=$sd+1;
			   $dcod_presup=$regd["cod_presup"]; $dmonto_pre=$regd["monto"]; 
			   $dtotala_conc=$dtotala_conc+$dmonto_pre;  $dmonto_pre=formato_monto($dmonto_pre);
			   $pdf->Cell(50,4,'',0,0);
			   $pdf->Cell(50,4,$dcod_presup,0,0,'L');
			   $pdf->Cell(25,4,$dmonto_pre,0,1,'R');
			}
			if($sd>0){				
				$total_monto_asignacion=formato_monto($dtotala_conc);
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(100,3,'',0,0);
				$pdf->Cell(25,3,'=============',0,1,'R');
				$pdf->Cell(100,5,'TOTAL CODIGOS : ',0,0,'R');
				$pdf->Cell(25,5,$total_monto_asignacion,0,1,'R');
			}	
			$monto_dep_v=formato_monto($monto_dep_v);
			$pdf->Ln(5);
			$pdf->SetFont('Arial','B',8);
			$cant_dep_trab=$cant_dep_a+$cant_dep_v;
			$pdf->Cell(40,3,'TOTAL TRABAJADORES : ',0,0);		    
			$pdf->Cell(20,3,$cant_dep_trab,0,0);
			$pdf->Cell(30,3,'TOTAL ACTIVOS : ',0,0);		    
			$pdf->Cell(20,3,$cant_dep_a,0,0);
			$pdf->Cell(30,3,'TOTAL VACANTES : ',0,0);		    
			$pdf->Cell(10,3,$cant_dep_v,0,0);
			$pdf->Cell(15,3,'Monto : ',0,0);	
			$pdf->Cell(20,3,$monto_dep_v,0,1);			
			$tipo_en=1;
			//if($salto_dep=="SI"){$pdf->AddPage();}else{$pdf->Ln(10); }
			/*
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
            $cant_activos=$cant_g;
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
                $cant_activos=$cant_g;				
            } 
			$pdf->Ln(5);
            $pdf->SetFont('Arial','B',8);
			$cant_trab=$cant_activos+$cant_vacantes;
			$pdf->Cell(40,3,'TOTAL TRABAJADORES : ',0,0);		    
		    $pdf->Cell(20,3,$cant_trab,0,0);
			$pdf->Cell(30,3,'TOTAL ACTIVOS : ',0,0);		    
		    $pdf->Cell(20,3,$cant_activos,0,0);
            $pdf->Cell(30,3,'TOTAL VACANTES : ',0,0);		    
		    $pdf->Cell(20,3,$cant_vacantes,0,1);	
            */

			
		
	  $pdf->Output();   
    }	
}
?>