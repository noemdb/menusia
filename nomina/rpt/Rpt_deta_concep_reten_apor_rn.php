<?include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);

   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist=$_GET["act_hist"]; $fecha_nom=$_GET["fecha_nom"]; $rango_f=$_GET["rango_f"]; $agrup_nom=$_GET["agrup_nom"];
   $cod_concepto_r=$_GET["cod_concepto_r"]; $cod_concepto_a=$_GET["cod_concepto_a"]; $mes_comp=$_GET["mes_comp"]; $agrup_dep=$_GET["agrup_dep"]; $fecha_desde=$_GET["fecha_desde"];  $fecha_hasta=$_GET["fecha_hasta"];
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"]; $tipo_rpt=$_GET["tipo_rpt"];
   $Sql="";$date = date("d-m-Y"); $hora = date("h:i:s a"); $cfechan=formato_aaaammdd($fecha_nom);   $cfechad=formato_aaaammdd($fecha_desde); $cfechah=formato_aaaammdd($fecha_hasta);   $php_os=PHP_OS;
   $criterio="rpt_nom_cal WHERE "; $nom_rpt="Rpt_deta_concep_reten_apor_rn_re_detalle.xml"; $criterio1=""; $criterio2=""; $criterio3="";
   $ordenar="  order by tipo_nomina, cod_empleado, cod_concepto"; $nro_pdf=1;
   if($act_hist=='S'){  $criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."')  and "; 
      if($mes_comp=='S'){ $fecha_d=$fecha_nom; $fecha_d=colocar_pdiames($fecha_d); $dfechan=formato_aaaammdd($fecha_d); $criterio="rpt_nom_hist WHERE (fecha_p_desde>='".$dfechan."') and (fecha_p_hasta<='".$cfechan."')  and ";  
        $nom_rpt="Rpt_deta_concep_reten_apor_rn_re_agrup.xml"; $nro_pdf=1; $criterio1="Fecha: ".$fecha_d." al ".$fecha_nom;	  		
        if($agrup_dep=='S'){$nom_rpt="Rpt_deta_concep_reten_apor_rn_re_dept.xml"; $nro_pdf=3; $ordenar="  order by cod_departam, cod_concepto, cod_empleado"; } }  } 
   else{ $mes_comp='N'; $agrup_dep='N'; }	
   if($rango_f=='S'){  $criterio="rpt_nom_hist WHERE (fecha_p_hasta>='".$cfechad."') and (fecha_p_hasta<='".$cfechah."')  and "; $nro_pdf=2;  $criterio1="Fecha: ".$fecha_desde." al ".$fecha_hasta;	}
   
   
   if($agrup_nom=='S'){$nro_pdf=4;  $nom_rpt="Rpt_deta_concep_reten_apor_rn_nomina.xml"; }
   
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." (status_emp='".$estatus_trab_d."') and ";}
   if($tipo_calculo=="T"){ $criterio=$criterio." ((tp_calculo='N')or(tp_calculo='E')) and "; } else { $criterio=$criterio." (tp_calculo='".$tipo_calculo."') and "; }
   $criterio=$criterio." (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and
		  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_concepto='".$cod_concepto_r."' or cod_concepto='".$cod_concepto_a."') ";
   
   
   
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}

   if($Cod_Emp=="02"){    if(($tipo_rpt=="PDF")and ($nro_pdf==1)){ $tipo_rpt="PDF2";} }
   
   function muestra_cant($mop,$mtipo,$mdep,$mcod_emp){global $criterio; global $host; global $port; global $password; global $user; global $dbname;
     $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");    $cant=0;
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
   
   $criterio4="";
   $sql="SELECT tipo_nomina,cod_concepto,denominacion from nom002 where tipo_nomina='$tipo_nomina_d' and cod_concepto='$cod_concepto_r'"; $res=pg_query($sql); 
   if($registro=pg_fetch_array($res,0)){$criterio4=$criterio4.$registro["cod_concepto"]." ".$registro["denominacion"];}
   
   $sql="SELECT tipo_nomina,cod_concepto,denominacion from nom002 where tipo_nomina='$tipo_nomina_d' and cod_concepto='$cod_concepto_a'"; $res=pg_query($sql); 
   if($registro=pg_fetch_array($res,0)){$criterio4=$criterio4." - ".$registro["cod_concepto"]." ".$registro["denominacion"];}
   
   $sSQL = "SELECT *  FROM ".$criterio.$ordenar;   
   if($tipo_rpt=="HTML"){  include ("../../class/phpreports/PHPReportMaker.php");
         //echo $sSQL;
          $oRpt = new PHPReportMaker();
          $oRpt->setXML($nom_rpt);
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"criterio4"=>$criterio4,"criterio3"=>$criterio3,"monto"=>$monto,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark(); 
	}
    if(($tipo_rpt=="PDF")and ($nro_pdf==1)){	 $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre=""; $prev_cedula="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"];  $nombre=$registro["nombre"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];  	$cedula=$registro["cedula"];		
        if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		$prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $prev_cedula=$cedula;
	  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $criterio4; global $mes_comp; global $tipo_nomina; global $des_nomina; global $fechad; global $fechah; global $cod_concepto; global $tipo_nomina_d; global $tipo_nomina_h;  global $denominacion; global $criterio3;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',12);
			$this->Cell(40);
			$this->Cell(130,7,"RELACION DE CONCEPTOS DETALLE RETENCION/APORTE",1,0,'C');
			$this->Ln(17);
			$this->SetFont('Arial','B',8);
			if($tipo_nomina_d==$tipo_nomina_h){	$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');}
			else{$this->Cell(140,5,$criterio3,0,1,'L');}
			if($mes_comp=='S'){ $this->Cell(140,5,$criterio1,0,1,'L');
			}else{$this->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');}
			//$this->Cell(140,5,$denominacion,0,1,'L');
			$this->Cell(140,5,$criterio4,0,1,'L');	
			$this->Cell(18,3,'Codigo','RLT',0,'L');
			$this->Cell(120,3,'','RT',0,'L');
			$this->Cell(13,3,'','RT',0,'C');
			$this->Cell(16,3,'Retencion','RT',0,'C');
			$this->Cell(16,3,'Aporte','RT',0,'C');	
            $this->Cell(16,3,'','RT',1,'C');				
			$this->Cell(18,4,'Trabajador','LB',0,'L');
			$this->Cell(120,4,'Nombre Trabajador','LB',0,'L');
			$this->Cell(13,4,'Cedula','LB',0,'C');
			$this->Cell(16,4,'Trabajador','LB',0,'C');
			$this->Cell(16,4,'Empresa','RLB',0,'C');
            $this->Cell(16,4,'Total','RLB',1,'C');				
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
	  //$pdf->MultiCell(200,3,$sSQL,0); 
	  $i=0; $can_conc=0; $totala_nom=0; $totald_nom=0; $cant_nom=0;	$totala_emp=0; $totald_emp=0; $cant_emp=0;  $totala_conc=0; $totald_conc=0;  
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];
		$monto_asignacion=$registro["monto_deduccion"]; $monto_deduccion=$registro["monto_aporte"];
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina); $nombre=utf8_decode($nombre); $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		if(($prev_tipo<>$tipo_nomina)and($mes_comp=='N')){		$total_emp=$totala_emp+$totald_emp;	$total_emp=formato_monto($total_emp);	
		    if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
			if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(18,4,$prev_emp,0,0);
			$pdf->Cell(120,4,$prev_nombre,0,0);			
			$pdf->Cell(13,4,$prev_cedula,0,0,'C');
			$pdf->Cell(16,4,$totala_emp,0,0,'R');
			$pdf->Cell(16,4,$totald_emp,0,0,'R');
            $pdf->Cell(16,4,$total_emp,0,1,'R');				
		    $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $prev_cedula=$cedula; $cant_emp=$cant_emp+1; 
		    
			$total_conc=$totala_conc+$totald_conc;	$total_conc=formato_monto($total_conc);
		    $totala_conc=formato_monto($totala_conc); $totald_conc=formato_monto($totald_conc);
			$pdf->SetFont('Arial','B',8);
		    $pdf->Cell(138,2,'',0,0);
			$pdf->Cell(13,2,'',0,0,'R');
			$pdf->Cell(16,2,'---------------',0,0,'R');
			$pdf->Cell(16,2,'---------------',0,0,'R');
			$pdf->Cell(16,2,'---------------',0,1,'R');
			$pdf->Cell(60,4,'Nro. Trabjadores : '.$cant_emp,0,0);			
			$pdf->Cell(91,4,'TOTAL '.$den_conc,0,0);
			$pdf->Cell(16,4,$totala_conc,0,0,'R');
			$pdf->Cell(16,4,$totald_conc,0,0,'R');
            $pdf->Cell(16,4,$total_conc,0,1,'R');			
			$prev_conc=$cod_concepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0;  $cant_emp=0;$prev_tipo=$tipo_nomina;
			$pdf->AddPage();
            
		} 
		
		if($prev_emp<>$cod_empleado){	$total_emp=$totala_emp+$totald_emp;	$total_emp=formato_monto($total_emp);	
		   if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
			if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(18,4,$prev_emp,0,0);
			$pdf->Cell(120,4,$prev_nombre,0,0);			
			$pdf->Cell(13,4,$prev_cedula,0,0,'C');
			$pdf->Cell(16,4,$totala_emp,0,0,'R');
			$pdf->Cell(16,4,$totald_emp,0,0,'R');
            $pdf->Cell(16,4,$total_emp,0,1,'R');			
		    $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $prev_cedula=$cedula; $cant_emp=$cant_emp+1; 
		}	
		$can_conc=$can_conc+$cantidad; $totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;		
		$totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;		
		
		
      } $total_emp=$totala_emp+$totald_emp;	$total_emp=formato_monto($total_emp);
	    if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
		if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(18,4,$prev_emp,0,0);
		$pdf->Cell(120,4,$prev_nombre,0,0);			
		$pdf->Cell(13,4,$prev_cedula,0,0,'C');
		$pdf->Cell(16,4,$totala_emp,0,0,'R');
		$pdf->Cell(16,4,$totald_emp,0,0,'R');
        $pdf->Cell(16,4,$total_emp,0,1,'R');		
		$can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $cant_emp=$cant_emp+1; 
		
		$totala_nom=$totala_nom+$totala_conc; $totald_nom=$totald_nom+$totald_conc;
		$total_conc=$totala_conc+$totald_conc;	$total_conc=formato_monto($total_conc);
		$totala_conc=formato_monto($totala_conc); $totald_conc=formato_monto($totald_conc);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(138,2,'',0,0);
		$pdf->Cell(13,2,'',0,0,'R');
		$pdf->Cell(16,2,'---------------',0,0,'R');
		$pdf->Cell(16,2,'---------------',0,0,'R');
		$pdf->Cell(16,2,'---------------',0,1,'R');
		
		$pdf->Cell(60,4,'Nro. Trabjadores : '.$cant_emp,0,0);			
		if($mes_comp=='S'){ $pdf->Cell(91,4,'TOTAL GENERAL ',0,0); }
		else{ $pdf->Cell(91,4,'TOTAL '.$den_conc,0,0);}
		$pdf->Cell(16,4,$totala_conc,0,0,'R');
		$pdf->Cell(16,4,$totald_conc,0,0,'R');	
		$pdf->Cell(16,4,$total_conc,0,1,'R');	
	  $pdf->Output();   
    }
	
	if(($tipo_rpt=="PDF2")and ($nro_pdf==1)){	 $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre=""; $prev_cedula="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"];  $nombre=$registro["nombre"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];  	$cedula=$registro["cedula"];		
        if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		$prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $prev_cedula=$cedula;
	  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $criterio4; global $mes_comp; global $tipo_nomina; global $des_nomina; global $fechad; global $fechah; global $cod_concepto; global $tipo_nomina_d; global $tipo_nomina_h;  global $denominacion; global $criterio3;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',12);
			$this->Cell(40);
			$this->Cell(130,7,"RELACION DE CONCEPTOS DETALLE RETENCION/APORTE",1,0,'C');
			$this->Ln(17);
			$this->SetFont('Arial','B',8);
			if($tipo_nomina_d==$tipo_nomina_h){	$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');}
			else{$this->Cell(140,5,$criterio3,0,1,'L');}
			if($mes_comp=='S'){ $this->Cell(140,5,$criterio1,0,1,'L');
			}else{$this->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');}
			//$this->Cell(140,5,$denominacion,0,1,'L');
			$this->Cell(140,5,$criterio4,0,1,'L');	
			$this->Cell(20,3,'Codigo','RLT',0,'L');
			$this->Cell(120,3,'','RT',0,'L');
			$this->Cell(20,3,'Retencion','RT',0,'C');
			$this->Cell(20,3,'Aporte','RT',0,'C');	
            $this->Cell(20,3,'','RT',1,'C');

			
			$this->Cell(20,4,'Trabajador','LB',0,'L');
			$this->Cell(120,4,'Nombre Trabajador','LB',0,'L');
			$this->Cell(20,4,'Trabajador','LB',0,'C');
			$this->Cell(20,4,'Empresa','RLB',0,'C');
            $this->Cell(20,4,'Total','RLB',1,'C');				
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-7);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
	  $pdf->SetAutoPageBreak(true, 7);  
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',8);
	  //$pdf->MultiCell(200,3,$sSQL,0); 
	  $i=0; $can_conc=0; $totala_nom=0; $totald_nom=0; $cant_nom=0;	$totala_emp=0; $totald_emp=0; $cant_emp=0;  $totala_conc=0; $totald_conc=0;  
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];
		$monto_asignacion=$registro["monto_deduccion"]; $monto_deduccion=$registro["monto_aporte"];
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina); $nombre=utf8_decode($nombre); $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		if(($prev_tipo<>$tipo_nomina)and($mes_comp=='N')){		$total_emp=$totala_emp+$totald_emp;	$total_emp=formato_monto($total_emp);	
		    if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
			if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(20,4,$prev_cedula,0,0);
			$pdf->Cell(120,4,$prev_nombre,0,0);	
			$pdf->Cell(20,4,$totala_emp,0,0,'R');
			$pdf->Cell(20,4,$totald_emp,0,0,'R');
            $pdf->Cell(20,4,$total_emp,0,1,'R');				
		    $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $prev_cedula=$cedula; $cant_emp=$cant_emp+1; 
		    
			$total_conc=$totala_conc+$totald_conc;	$total_conc=formato_monto($total_conc);
		    $totala_conc=formato_monto($totala_conc); $totald_conc=formato_monto($totald_conc);
			$pdf->SetFont('Arial','B',8);
		    $pdf->Cell(160,2,'',0,0);
			$pdf->Cell(20,2,'---------------',0,0,'R');
			$pdf->Cell(20,2,'---------------',0,0,'R');
			$pdf->Cell(20,2,'---------------',0,1,'R');
			$pdf->Cell(60,4,'Nro. Trabjadores : '.$cant_emp,0,0);			
			$pdf->Cell(100,4,'TOTAL '.$den_conc,0,0);
			$pdf->Cell(16,4,$totala_conc,0,0,'R');
			$pdf->Cell(16,4,$totald_conc,0,0,'R');
            $pdf->Cell(16,4,$total_conc,0,1,'R');			
			$prev_conc=$cod_concepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0;  $cant_emp=0;$prev_tipo=$tipo_nomina;
			$pdf->AddPage();
            
		} 
		
		if($prev_emp<>$cod_empleado){	$total_emp=$totala_emp+$totald_emp;	$total_emp=formato_monto($total_emp);	
		   if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
			if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(20,4,$prev_cedula,0,0);
			$pdf->Cell(120,4,$prev_nombre,0,0);	
			$pdf->Cell(20,4,$totala_emp,0,0,'R');
			$pdf->Cell(20,4,$totald_emp,0,0,'R');
            $pdf->Cell(20,4,$total_emp,0,1,'R');				
		    $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $prev_cedula=$cedula; $cant_emp=$cant_emp+1; 
		}	
		$can_conc=$can_conc+$cantidad; $totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;		
		$totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;		
		
		
      } $total_emp=$totala_emp+$totald_emp;	$total_emp=formato_monto($total_emp);
	    if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
		if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(20,4,$prev_cedula,0,0);
		$pdf->Cell(120,4,$prev_nombre,0,0);	
		$pdf->Cell(20,4,$totala_emp,0,0,'R');
		$pdf->Cell(20,4,$totald_emp,0,0,'R');
		$pdf->Cell(20,4,$total_emp,0,1,'R');		
		$can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $cant_emp=$cant_emp+1; 
		
		$totala_nom=$totala_nom+$totala_conc; $totald_nom=$totald_nom+$totald_conc;
		$total_conc=$totala_conc+$totald_conc;	$total_conc=formato_monto($total_conc);
		$totala_conc=formato_monto($totala_conc); $totald_conc=formato_monto($totald_conc);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(160,2,'',0,0);
		$pdf->Cell(20,2,'---------------',0,0,'R');
		$pdf->Cell(20,2,'---------------',0,0,'R');
		$pdf->Cell(20,2,'---------------',0,1,'R');
		
		$pdf->Cell(60,4,'Nro. Trabjadores : '.$cant_emp,0,0);			
		if($mes_comp=='S'){ $pdf->Cell(100,4,'TOTAL GENERAL ',0,0); }
		else{ $pdf->Cell(100,4,'TOTAL '.$den_conc,0,0);}
		$pdf->Cell(20,4,$totala_conc,0,0,'R');
		$pdf->Cell(20,4,$totald_conc,0,0,'R');	
		$pdf->Cell(20,4,$total_conc,0,1,'R');

        $y=$pdf->GetY();  $t=10;
        if($y>255){$t=30; $pdf->Cell(5,4,'',0,1);  } 
        $pdf->ln($t); $y=$pdf->GetY();
	    if($y<250){$t=250-$y; $pdf->ln($t);} 
		$pdf->SetFont('Arial','',7);
        $pdf->Cell(60,4,'Elaborado por Analista','T',0,'C');
        $pdf->Cell(10,4,'',0,0);
        $pdf->Cell(60,4,'Revisado por','T',0,'C');
        $pdf->Cell(10,4,'',0,0);
		$pdf->Cell(60,4,'Conformado por Administracion','T',1,'C');
		
        $pdf->Cell(70,3,' ',0,0,'C');
		$pdf->Cell(60,3,'Dir. Recursos Humanos y Capacitacion',0,0,'C');
		$pdf->Cell(10,3,'',0,0,'C');
        $pdf->Cell(60,3,'',0,1,'C');  		 			
	  $pdf->Output();   
    }
	
	if(($tipo_rpt=="PDF")and ($nro_pdf==2)){	 $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre=""; $prev_cedula="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"];  $nombre=$registro["nombre"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];  	$cedula=$registro["cedula"];		
        if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		$prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $prev_cedula=$cedula;
	  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $criterio4; global $mes_comp; global $tipo_nomina; global $des_nomina; global $fechad; global $fechah; global $cod_concepto; global $tipo_nomina_d; global $tipo_nomina_h;  global $denominacion; global $criterio3;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',12);
			$this->Cell(40);
			$this->Cell(130,7,"RELACION DE CONCEPTOS DETALLE RETENCION/APORTE",1,0,'C');
			$this->Ln(17);
			$this->SetFont('Arial','B',8);	
			
			if($mes_comp=='N'){$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');	}		
			$this->Cell(140,5,$criterio1,0,1,'L');
			
			//$this->Cell(140,5,$denominacion,0,1,'L');
			$this->Cell(140,5,$criterio4,0,1,'L');	
			
			$this->Cell(18,3,'Codigo','RLT',0,'L');
			$this->Cell(110,3,'','RT',0,'L');
			$this->Cell(12,3,'','RT',0,'L');
			$this->Cell(20,3,'','RT',0,'C');
			$this->Cell(20,3,'Retencion','RT',0,'C');
			$this->Cell(20,3,'Aporte','RT',1,'C');			
			$this->Cell(18,4,'Trabajador','LB',0,'L');
			$this->Cell(110,4,'Nombre Trabajador','LB',0,'L');
			$this->Cell(12,4,'Cedula','LB',0,'C');
			$this->Cell(20,4,'Trabajador','LB',0,'C');
			$this->Cell(20,4,'Empresa','LB',0,'C');
            $this->Cell(20,4,'Total','RLB',1,'C');			
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
	  //$pdf->MultiCell(200,3,$sSQL,0); 
	  $i=0; $can_conc=0; $totala_nom=0; $totald_nom=0; $cant_nom=0;	$totala_emp=0; $totald_emp=0; $cant_emp=0;  $totala_conc=0; $totald_conc=0;  
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"];
		
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];
		$monto_asignacion=$registro["monto_deduccion"]; $monto_deduccion=$registro["monto_aporte"];
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina); $nombre=utf8_decode($nombre); $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		
		if(($prev_tipo<>$tipo_nomina)and($mes_comp=='N')){	$total_emp=$totala_emp+$totald_emp;	$total_emp=formato_monto($total_emp);
		    if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
			if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(18,4,$prev_emp,0,0);
			$pdf->Cell(110,4,$prev_nombre,0,0);
            $pdf->Cell(12,3,$prev_cedula,0,0,'C');			
			$pdf->Cell(20,4,$totala_emp,0,0,'R');
			$pdf->Cell(20,4,$totald_emp,0,0,'R');
			$pdf->Cell(20,4,$total_emp,0,1,'R');			
		    $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $prev_cedula=$cedula; $cant_emp=$cant_emp+1; 
		    
			
			$totala_nom=$totala_nom+$totala_conc; $totald_nom=$totald_nom+$totald_conc;
			$total_conc=$totala_conc+$totald_conc;	$total_conc=formato_monto($total_conc);
		    $totala_conc=formato_monto($totala_conc); $totald_conc=formato_monto($totald_conc);
			$pdf->SetFont('Arial','B',8);
		    $pdf->Cell(140,2,'',0,0);
			$pdf->Cell(20,2,'--------------------',0,0,'R');
			$pdf->Cell(20,2,'--------------------',0,0,'R');
			$pdf->Cell(20,2,'--------------------',0,1,'R');
			$pdf->Cell(60,4,'Nro. Trabjadores : '.$cant_emp,0,0);			
			$pdf->Cell(80,4,'TOTAL '.$den_conc,0,0);
			$pdf->Cell(20,4,$totala_conc,0,0,'R');
			$pdf->Cell(20,4,$totald_conc,0,0,'R');
            $pdf->Cell(20,4,$total_conc,0,1,'R');			
			$prev_conc=$cod_concepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0;  $cant_emp=0;$prev_tipo=$tipo_nomina;
			$pdf->AddPage();
            
		} 
		
		if($prev_emp<>$cod_empleado){		$total_emp=$totala_emp+$totald_emp;	//$total_emp=formato_monto($total_emp);
		   if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
			if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(18,4,$prev_emp,0,0);
			$pdf->Cell(110,4,$prev_nombre,0,0);
            $pdf->Cell(12,3,$prev_cedula,0,0,'C');	
			$pdf->Cell(20,4,$totala_emp,0,0,'R');
			$pdf->Cell(20,4,$totald_emp,0,0,'R');
            $pdf->Cell(20,4,$total_emp,0,1,'R');				
		    $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $prev_cedula=$cedula; $cant_emp=$cant_emp+1; 
		}	
		$can_conc=$can_conc+$cantidad; $totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;		
		$totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;		
		
		
      } $total_emp=$totala_emp+$totald_emp;	$total_emp=formato_monto($total_emp);
	    if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
		if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(18,4,$prev_emp,0,0);
		$pdf->Cell(110,4,$prev_nombre,0,0);
        $pdf->Cell(12,3,$prev_cedula,0,0,'C');	
		$pdf->Cell(20,4,$totala_emp,0,0,'R');
		$pdf->Cell(20,4,$totald_emp,0,0,'R');
        $pdf->Cell(20,4,$total_emp,0,1,'R');			
		$can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $cant_emp=$cant_emp+1; 
		
		$totala_nom=$totala_nom+$totala_conc; $totald_nom=$totald_nom+$totald_conc;
		$total_conc=$totala_conc+$totald_conc;	$total_conc=formato_monto($total_conc);
		$totala_conc=formato_monto($totala_conc); $totald_conc=formato_monto($totald_conc);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(140,2,'',0,0);
		$pdf->Cell(20,2,'--------------------',0,0,'R');
		$pdf->Cell(20,2,'--------------------',0,0,'R');
		$pdf->Cell(20,2,'--------------------',0,1,'R');
		$pdf->Cell(60,4,'Nro. Trabjadores : '.$cant_emp,0,0);			
		if($mes_comp=='S'){ $pdf->Cell(80,4,'TOTAL GENERAL ',0,0); }
		else{ $pdf->Cell(80,4,'TOTAL '.$den_conc,0,0);}
		$pdf->Cell(20,4,$totala_conc,0,0,'R');
		$pdf->Cell(20,4,$totald_conc,0,0,'R');	
		$pdf->Cell(20,4,$total_conc,0,1,'R');
        $pdf->Ln(5);
		
		$total_nom=$totala_nom+$totald_nom; $total_nom=formato_monto($total_nom);
		$totala_nom=formato_monto($totala_nom); $totald_nom=formato_monto($totald_nom);
		$pdf->Cell(140,2,'',0,0);
		$pdf->Cell(20,2,'===============',0,0,'R');
		$pdf->Cell(20,2,'===============',0,0,'R');
		$pdf->Cell(20,2,'===============',0,1,'R');
		$pdf->Cell(60,4,'',0,0);
		$pdf->Cell(80,4,'TOTAL GENERAL ',0,0);
		$pdf->Cell(20,4,$totala_nom,0,0,'R');
		$pdf->Cell(20,4,$totald_nom,0,0,'R');	
		$pdf->Cell(20,4,$total_nom,0,1,'R');
		
		if($Cod_Emp=="02"){
		    $y=$pdf->GetY();  $t=10;
			if($y>255){$t=30; $pdf->Cell(5,4,'',0,1);  } 
			$pdf->ln($t); $y=$pdf->GetY();
			if($y<250){$t=250-$y; $pdf->ln($t);} 
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(60,4,'Elaborado por Analista','T',0,'C');
			$pdf->Cell(10,4,'',0,0);
			$pdf->Cell(60,4,'Revisado por','T',0,'C');
			$pdf->Cell(10,4,'',0,0);
			$pdf->Cell(60,4,'Conformado por Administracion','T',1,'C');
			
			$pdf->Cell(70,3,' ',0,0,'C');
			$pdf->Cell(60,3,'Dir. Recursos Humanos y Capacitacion',0,0,'C');
			$pdf->Cell(10,3,'',0,0,'C');
			$pdf->Cell(60,3,'',0,1,'C');  		
			
		}	
		
	  $pdf->Output();   
    }
    if(($tipo_rpt=="PDF")and ($nro_pdf==3)){$res=pg_query($sSQL); $filas=pg_num_rows($res); $tipo_nomina_grupo=""; $cod_empleado_grupo=""; $cod_departam_grupo="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"]; $fechapd=$registro["fechapd"]; $fechaph=$registro["fechaph"]; $denominacion=$registro["denominacion"]; $cod_concepto=$registro["cod_concepto"];
	   if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $denominacion=utf8_decode($denominacion);} 	}	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $criterio3; global $criterio4; global $tipo_nomina_grupo; global $cod_empleado_grupo; global $cod_departam_grupo; global $tipo_nomina;  global $denominacion; global $des_nomina; global $fechapd; global $fechaph; global $descripcion; global $tipo_nomina_d; global $tipo_nomina_h;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(30);
			$this->Cell(150,7,"RELACION DE CONCEPTOS RETENCION/APORTE POR DEPARTAMENTO",1,0,'C');
			$this->Ln(20);
			$this->SetFont('Arial','B',9);
			if($tipo_nomina_d==$tipo_nomina_h){	$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');}
			else{$this->Cell(140,5,$criterio3,0,1,'L');}
			$this->Cell(200,5,$criterio1,0,1,'L');
			//$this->Cell(200,5,$denominacion,0,1,'L');
			$this->Cell(200,5,$criterio4,0,1,'L');
			$this->SetFont('Arial','B',8);
			$this->Cell(21,3,'Codigo','RLT',0,'L');
			$this->Cell(99,3,'','RT',0,'L');
			$this->Cell(20,3,'Cantidad','RT',0,'C');
			$this->Cell(20,3,'Retencion','RT',0,'C');
			$this->Cell(20,3,'Aporte','RT',0,'C');
			$this->Cell(20,3,'','RT',1,'R');
			
			$this->Cell(21,4,'Departamento','LB',0,'L');
			$this->Cell(99,4,'Denominacion','LB',0,'L');
			$this->Cell(20,4,'Trabajadores','LB',0,'C');
			$this->Cell(20,4,'Trabajador','LB',0,'C');
			$this->Cell(20,4,'Empresa','LB',0,'C');
			$this->Cell(20,4,'Total','RLB',1,'C');
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
	  $i=0; $cantidad=0; $total_cantidad=0; $sub_total_monto_deduccion=0;  $total_monto_deduccion=0; $sub_total_monto_aporte=0; $total_monto_aporte=0; $sub_total=0; $sub_total=0; $total=0;
	  $prev_cod_departam=""; $prev_des_departam="";  $prev_tipo_nomina=""; $prev_cod_empleado="";   
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"]; $denominacion=$registro["denominacion"]; $cod_concepto=$registro["cod_concepto"];
	      $fechapd=$registro["fechapd"]; $fechaph=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
          $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $monto_deduccion=$registro["monto_deduccion"]; $monto_aporte=$registro["monto_aporte"]; 
		  if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina); $nombre=utf8_decode($nombre); $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);} 	
          $cod_departam_grupo=$cod_departam; $des_departam_grupo=$des_departam; $tipo_nomina_grupo=$tipo_nomina; $des_nomina_grupo=$des_nomina; $denominacion_grupo=$denominacion; 
          $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula;

		  if($prev_cod_departam<>$cod_departam_grupo){
			     if(($sub_total_monto_deduccion>0)or($sub_total_monto_aporte>0)or($sub_total>0)){ $sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto_aporte=formato_monto($sub_total_monto_aporte); $sub_total=formato_monto($sub_total);
					$pdf->SetFont('Arial','',8);
		   			$pdf->Cell(20,4,$prev_cod_departam,0,0); 		   
		   			$x=$pdf->GetX();   $y=$pdf->GetY(); $n=100; 		   
		   			$pdf->SetXY($x+$n,$y);
		   			$pdf->Cell(20,4,$total_cantidad,0,0,'C');
					$pdf->Cell(20,4,$sub_total_monto_deduccion,0,0,'R');
					$pdf->Cell(20,4,$sub_total_monto_aporte,0,0,'R');
					$pdf->Cell(20,4,$sub_total,0,1,'R');
                   	$pdf->SetXY($x,$y);
		   			$pdf->MultiCell($n,4,$prev_des_departam,0);}
		  $prev_cod_departam=$cod_departam_grupo; $prev_des_departam=$des_departam_grupo; $sub_total_monto_deduccion=0; $sub_total_monto_aporte=0; $sub_total=0; $total_cantidad=0; $prev_cod_empleado=""; }
          $monto_deduccion=$registro["monto_deduccion"]; $monto_aporte=$registro["monto_aporte"];
          $sub_total_monto_deduccion=$sub_total_monto_deduccion+$monto_deduccion; $sub_total_monto_aporte=$sub_total_monto_aporte+$monto_aporte; 
          $sub_total=$sub_total+$monto_deduccion+$monto_aporte; 
		  $total_monto_deduccion=$total_monto_deduccion+$monto_deduccion; $total_monto_aporte=$total_monto_aporte+$monto_aporte;
          $total=$total+$monto_deduccion+$monto_aporte; 
          $monto_deduccion=formato_monto($monto_deduccion);  $monto_aporte=formato_monto($monto_aporte); 
		  if(($prev_cod_empleado<>$cod_empleado)and($cod_concepto_a==$cod_concepto)){ $total_cantidad=$total_cantidad+1; $prev_cod_empleado=$cod_empleado;    }
		} $total_monto_deduccion=formato_monto($total_monto_deduccion); $total_monto_aporte=formato_monto($total_monto_aporte); $total=formato_monto($total);
		if(($sub_total_monto_deduccion>0)or($sub_total_monto_aporte>0)){ $sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto_aporte=formato_monto($sub_total_monto_aporte);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(20,4,$prev_cod_departam,0,0); 		   
			$x=$pdf->GetX();   $y=$pdf->GetY(); $n=100; 		   
			$pdf->SetXY($x+$n,$y);
			$pdf->Cell(20,4,$total_cantidad,0,0,'C');
			$pdf->Cell(20,4,$sub_total_monto_deduccion,0,0,'R');
			$pdf->Cell(20,4,$sub_total_monto_aporte,0,0,'R');
			$pdf->Cell(20,4,$sub_total,0,1,'R');
			$pdf->SetXY($x,$y);
			$pdf->MultiCell($n,4,$prev_des_departam,0);}
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(140,2,'',0,0);
		$pdf->Cell(20,2,'----------------',0,0,'R');
		$pdf->Cell(20,2,'----------------',0,0,'R');
		$pdf->Cell(20,2,'----------------',0,1,'R');
		$pdf->Cell(40,4,'Nro. Trabjadores : '.$criterio2,0,0,'L');			
		$pdf->Cell(100,4,'TOTAL GENERAL:',0,0,'R');
		$pdf->Cell(20,4,$total_monto_deduccion,0,0,'R');
		$pdf->Cell(20,4,$total_monto_aporte,0,0,'R');	
		$pdf->Cell(20,4,$total,0,1,'R');

        if($Cod_Emp=="02"){
		    $y=$pdf->GetY();  $t=10;
			if($y>255){$t=30; $pdf->Cell(5,4,'',0,1);  } 
			$pdf->ln($t); $y=$pdf->GetY();
			if($y<250){$t=250-$y; $pdf->ln($t);} 
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(60,4,'Elaborado por Analista','T',0,'C');
			$pdf->Cell(10,4,'',0,0);
			$pdf->Cell(60,4,'Revisado por','T',0,'C');
			$pdf->Cell(10,4,'',0,0);
			$pdf->Cell(60,4,'Conformado por Administracion','T',1,'C');
			
			$pdf->Cell(70,3,' ',0,0,'C');
			$pdf->Cell(60,3,'Dir. Recursos Humanos y Capacitacion',0,0,'C');
			$pdf->Cell(10,3,'',0,0,'C');
			$pdf->Cell(60,3,'',0,1,'C');  		
			
		}			
	    $pdf->Output();
	}	
	
	
	if(($tipo_rpt=="PDF")and ($nro_pdf==4)){$res=pg_query($sSQL); $filas=pg_num_rows($res); $tipo_nomina_grupo=""; $cod_empleado_grupo=""; $cod_departam_grupo="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"]; $fechapd=$registro["fechapd"]; $fechaph=$registro["fechaph"]; $denominacion=$registro["denominacion"]; $cod_concepto=$registro["cod_concepto"];
	   if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $denominacion=utf8_decode($denominacion);} 	}	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $criterio3; global $criterio4; global $tipo_nomina_grupo; global $cod_empleado_grupo; global $cod_departam_grupo; global $tipo_nomina;  global $denominacion; global $des_nomina; global $fechapd; global $fechaph; global $descripcion; global $tipo_nomina_d; global $tipo_nomina_h;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(30);
			$this->Cell(150,7,"RESUMEN RELACION DE CONCEPTOS RETENCION/APORTE POR NOMINA",1,0,'C');
			$this->Ln(20);
			$this->SetFont('Arial','B',9);
			$this->Cell(200,5,$criterio1,0,1,'L');
			$this->Cell(200,5,$criterio4,0,1,'L');
			$this->SetFont('Arial','B',8);
			$this->Cell(15,4,'Tipo de','RLT',0,'L');
			$this->Cell(105,4,'','RT',0,'L');
			$this->Cell(20,4,'Cantidad','RT',0,'C');
			$this->Cell(20,4,'Retencion','RT',0,'C');
			$this->Cell(20,4,'Aporte','RT',0,'C');
			$this->Cell(20,4,'','RT',1,'R');
			
			$this->Cell(15,4,'Nomina','LB',0,'L');
			$this->Cell(105,4,'Denominacion','LB',0,'L');
			$this->Cell(20,4,'Trabajadores','LB',0,'C');
			$this->Cell(20,4,'Trabajador','LB',0,'C');
			$this->Cell(20,4,'Empresa','LB',0,'C');
			$this->Cell(20,4,'Total','RLB',1,'C');
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
	  $i=0; $cantidad=0; $total_cantidad=0; $sub_total_monto_deduccion=0;  $total_monto_deduccion=0; $sub_total_monto_aporte=0; $total_monto_aporte=0; $sub_total=0; $sub_total=0; $total=0;
	  $prev_cod_departam=""; $prev_des_departam="";  $prev_tipo_nomina="";   $prev_des_nomina=""; $prev_cod_empleado="";   
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"]; $denominacion=$registro["denominacion"]; $cod_concepto=$registro["cod_concepto"];
	      $fechapd=$registro["fechapd"]; $fechaph=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
          $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $monto_deduccion=$registro["monto_deduccion"]; $monto_aporte=$registro["monto_aporte"]; 
		  if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina); $nombre=utf8_decode($nombre); $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);} 	
          $cod_departam_grupo=$cod_departam; $des_departam_grupo=$des_departam; $tipo_nomina_grupo=$tipo_nomina; $des_nomina_grupo=$des_nomina; $denominacion_grupo=$denominacion; 
          $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula;

		  if($prev_tipo_nomina<>$tipo_nomina_grupo){
			     if(($sub_total_monto_deduccion>0)or($sub_total_monto_aporte>0)or($sub_total>0)){ $sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto_aporte=formato_monto($sub_total_monto_aporte); $sub_total=formato_monto($sub_total);
					$pdf->SetFont('Arial','',8);
		   			$pdf->Cell(15,4,$prev_tipo_nomina,0,0); 		   
		   			$x=$pdf->GetX();   $y=$pdf->GetY(); $n=105; 		   
		   			$pdf->SetXY($x+$n,$y);
		   			$pdf->Cell(20,4,$total_cantidad,0,0,'C');
					$pdf->Cell(20,4,$sub_total_monto_deduccion,0,0,'R');
					$pdf->Cell(20,4,$sub_total_monto_aporte,0,0,'R');
					$pdf->Cell(20,4,$sub_total,0,1,'R');
                   	$pdf->SetXY($x,$y);
		   			$pdf->MultiCell($n,4,$prev_des_nomina,0);}
		  $prev_tipo_nomina=$tipo_nomina_grupo; $prev_des_nomina=$des_nomina_grupo; $sub_total_monto_deduccion=0; $sub_total_monto_aporte=0; $sub_total=0; $total_cantidad=0; $prev_cod_empleado=""; }
          $monto_deduccion=$registro["monto_deduccion"]; $monto_aporte=$registro["monto_aporte"];
          $sub_total_monto_deduccion=$sub_total_monto_deduccion+$monto_deduccion; $sub_total_monto_aporte=$sub_total_monto_aporte+$monto_aporte; 
          $sub_total=$sub_total+$monto_deduccion+$monto_aporte; 
		  $total_monto_deduccion=$total_monto_deduccion+$monto_deduccion; $total_monto_aporte=$total_monto_aporte+$monto_aporte;
          $total=$total+$monto_deduccion+$monto_aporte; 
          $monto_deduccion=formato_monto($monto_deduccion);  $monto_aporte=formato_monto($monto_aporte); 
		  if(($prev_cod_empleado<>$cod_empleado)and($cod_concepto_a==$cod_concepto)){ $total_cantidad=$total_cantidad+1; $prev_cod_empleado=$cod_empleado;    }
		} $total_monto_deduccion=formato_monto($total_monto_deduccion); $total_monto_aporte=formato_monto($total_monto_aporte); $total=formato_monto($total);
		if(($sub_total_monto_deduccion>0)or($sub_total_monto_aporte>0)){ $sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto_aporte=formato_monto($sub_total_monto_aporte); $sub_total=formato_monto($sub_total);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(15,4,$prev_tipo_nomina,0,0); 		   
			$x=$pdf->GetX();   $y=$pdf->GetY(); $n=105; 		   
			$pdf->SetXY($x+$n,$y);
			$pdf->Cell(20,4,$total_cantidad,0,0,'C');
			$pdf->Cell(20,4,$sub_total_monto_deduccion,0,0,'R');
			$pdf->Cell(20,4,$sub_total_monto_aporte,0,0,'R');
			$pdf->Cell(20,4,$sub_total,0,1,'R');
			$pdf->SetXY($x,$y);
			$pdf->MultiCell($n,4,$prev_des_nomina,0);}
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(140,2,'',0,0);
		$pdf->Cell(20,2,'----------------',0,0,'R');
		$pdf->Cell(20,2,'----------------',0,0,'R');
		$pdf->Cell(20,2,'----------------',0,1,'R');
		$pdf->Cell(40,4,'Nro. Trabjadores : '.$criterio2,0,0,'L');			
		$pdf->Cell(100,4,'TOTAL GENERAL:',0,0,'R');
		$pdf->Cell(20,4,$total_monto_deduccion,0,0,'R');
		$pdf->Cell(20,4,$total_monto_aporte,0,0,'R');	
		$pdf->Cell(20,4,$total,0,1,'R');

        if($Cod_Emp=="02"){
		    $y=$pdf->GetY();  $t=10;
			if($y>255){$t=30; $pdf->Cell(5,4,'',0,1);  } 
			$pdf->ln($t); $y=$pdf->GetY();
			if($y<250){$t=250-$y; $pdf->ln($t);} 
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(60,4,'Elaborado por Analista','T',0,'C');
			$pdf->Cell(10,4,'',0,0);
			$pdf->Cell(60,4,'Revisado por','T',0,'C');
			$pdf->Cell(10,4,'',0,0);
			$pdf->Cell(60,4,'Conformado por Administracion','T',1,'C');
			
			$pdf->Cell(70,3,' ',0,0,'C');
			$pdf->Cell(60,3,'Dir. Recursos Humanos y Capacitacion',0,0,'C');
			$pdf->Cell(10,3,'',0,0,'C');
			$pdf->Cell(60,3,'',0,1,'C');  		
			
		}			
	    $pdf->Output();
	}
}
?>
