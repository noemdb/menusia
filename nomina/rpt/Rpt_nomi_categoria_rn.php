<? include ("../../class/conect.php");  require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc");  error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"];   $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist=$_GET["act_hist"]; $fecha_nom=$_GET["fecha_nom"]; $tipo_concepto=$_GET["tipo_concepto"];
   $estatus_trab_d=$_GET["estatus_trab_d"];   $ocultar_n=$_GET["ocultar_n"]; $imprimir_esp=$_GET["imprimir_esp"];   $mostrar_cant=$_GET["mostrar_cant"];  $tipo_rpt=$_GET["tipo_rpt"];
   $mostrar_saldo=$_GET["mostrar_saldo"];   $forma_pago=$_GET["forma_pago"]; $tipo_reporte=$_GET["tipo_reporte"];   $tipo_calculo=$_GET["tipo_calculo"];
   $cod_presup_catd=$_GET["cod_presup_catd"];    $cod_presup_cath=$_GET["cod_presup_cath"];$cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"];
   $salto_dep=$_GET["salto_dep"]; $esp_firma=$_GET["esp_firma"]; $rango_f=$_GET["rango_f"]; $fecha_desde=$_GET["fecha_desde"];  $fecha_hasta=$_GET["fecha_hasta"];  $cfechad=formato_aaaammdd($fecha_desde); $cfechah=formato_aaaammdd($fecha_hasta);
   $cfechan=formato_aaaammdd($fecha_nom);  $Sql="";   $date = date("d-m-Y");   $hora = date("H:i:s a");
   if($tipo_reporte=='N'){$criterio1="RELACION NOMINA POR CATEGORIA";} else{$criterio1="RELACION NOMINA POR CATEGORIA (PRE-NOMINA)";}
   $criterio="rpt_nom_cal WHERE (oculto='NO') "; $criterio3="FECHA AL ".$fecha_nom;
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (oculto='NO') ";} 
   if($rango_f=='S'){ $act_hist='S';  $mes_comp='S'; $criterio="rpt_nom_hist WHERE (fecha_p_hasta>='".$cfechad."') and (fecha_p_hasta<='".$cfechah."') and (oculto='NO')  ";   
                      $criterio3="FECHA: ".$fecha_desde." AL ".$fecha_hasta;	} 
   if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}   
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and ((concepto_vac='N') or (cod_concepto='VVV'))";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and ((concepto_vac='S') and (cod_concepto<>'VVV')) ";}   
$criterio=$criterio." and (tp_calculo='".$tipo_calculo."') and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') 
   and (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_categ>='".$cod_presup_catd."' and cod_categ<='".$cod_presup_cath."') ";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS'); </script> <?}
else{  $Nom_Emp=busca_conf(); $php_os=PHP_OS;  if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}

function muestra_cant($mop,$mtipo,$mdep,$mcod_emp){global $criterio; global $host; global $port; global $password; global $user; global $dbname;
   $conn=pg_connect("host=".$host."  port=".$port." password=".$password." user=".$user." dbname=".$dbname."");    $cant=0;
   $fsql = "SELECT count(distinct cod_empleado) as cant_trab  from ".$criterio." and (tipo_nomina='".$mtipo."')";
   if($mop==2){ $fsql = "SELECT count(distinct cod_empleado) as cant_trab  from ".$criterio." and (tipo_nomina='".$mtipo."') and (cod_departam='".$mdep."')";}
   $fres=pg_exec($conn,$fsql);$filas=pg_numrows($fres); if($filas>0){$freg=pg_fetch_array($fres); $cant=$freg["cant_trab"];} 
   return $cant;
}

  $Sql = "SELECT count(distinct cod_empleado) as cant_trab  FROM ".$criterio ;
  $res=pg_query($Sql); $filas=pg_num_rows($res); if($filas>0){ $registro=pg_fetch_array($res,0); $criterio2=$registro["cant_trab"];  }	
  $sSQL = "SELECT *  FROM ".$criterio."  order by tipo_nomina, cod_categ,cod_departam, cod_cargo, cod_empleado, cod_concepto";	  
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
	  $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"tipod"=>$tipo_nomina_d,"tipoh"=>$tipo_nomina_h,"date"=>$date,"hora"=>$hora));
	  $oRpt->run();
	  $aBench = $oRpt->getBenchmark();
  }	  
  if($tipo_rpt=="PDF"){	 $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_cat=""; $prev_den_dep=""; $prev_emp=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"];  $cod_categ=$registro["cod_categ"];  $des_departam=$registro["des_departam"]; 
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam);}
        $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam; $prev_cat=$cod_categ; $prev_den_dep=$des_departam; $prev_emp="";
	  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tipo_nomina; global $des_nomina; global $fechad; global $fechah; global $cod_departam; global $des_departam; global $cod_categ; global $rango_f; global $criterio3;
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
			//$this->Cell(140,5,"DEPARTAMENTO : ".$cod_departam." ".$des_departam,0,1,'L');
			$this->Cell(140,5,"CATEGORIA : ".$cod_categ,0,1,'L');
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
	  $totala_conc=0; $totald_conc=0; $prev_conc=""; $den_conc=""; $totala_g=0; $totald_g=0; $cant_g=0; $total_cant=0;
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; $cod_categ=$registro["cod_categ"];
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
		$denominacion=substr($denominacion,0,60);
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_cargo=utf8_decode($des_cargo);  $des_departam=utf8_decode($des_departam);  $nombre=utf8_decode($nombre); $denominacion=utf8_decode($denominacion);}
		if(($prev_emp<>$cod_empleado)or($prev_cat<>$cod_categ)or($prev_tipo<>$tipo_nomina)){
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
		  if(($prev_cat<>$cod_categ)or($prev_tipo<>$tipo_nomina)){$neto=$totala_dep-$totald_dep; $neto=formato_monto($neto);
		    $totala_dep=formato_monto($totala_dep); $totald_dep=formato_monto($totald_dep);
		    $pdf->Cell(140,2,'',0,0);
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,1,'R');			
			$pdf->Cell(130,3,'Total Categoria : '.$prev_cat,0,0);
			$pdf->Cell(10,3,$cant_dep,0,0,'C');			
			$pdf->Cell(20,3,$totala_dep,0,0,'R');
			$pdf->Cell(20,3,$totald_dep,0,0,'R');
			$pdf->Cell(20,3,$neto,0,1,'R');
			$prev_cat=$cod_categ; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $cant_dep=0; $totala_dep=0; $totald_dep=0;
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
			  //$pdf->Cell(140,5,"DEPARTAMENTO : ".$cod_departam." ".$des_departam,0,1,'L');
			  $pdf->Cell(140,5,"CATEGORIA : ".$cod_categ,0,1,'L');
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
			$pdf->Cell(130,3,'Total Categoria : '.$prev_cat,0,0);
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
	  $pdf->Output();   
    }	  
}
?>