<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
   $tipo_nomina_d=$_GET["tipo_nomina_d"];   $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist=$_GET["act_hist"]; $fecha_nom=$_GET["fecha_nom"]; $tipo_concepto=$_GET["tipo_concepto"];
   $cod_empleado_d=$_GET["cod_empleado_d"]; $cod_empleado_h=$_GET["cod_empleado_h"];  $codigo_cargo_d=$_GET["codigo_cargo_d"];$codigo_cargo_h=$_GET["codigo_cargo_h"];
   $forma_pago=$_GET["forma_pago"];  $tipo_calculo=$_GET["tipo_calculo"]; $cod_departd=$_GET["cod_departamento_d"];  $cod_departh=$_GET["cod_departamento_h"];
   $tipo_rpt=$_GET["tipo_rpt"]; $num_recibo_d=$_GET["num_recibo_d"]; $num_recibo_h=$_GET["num_recibo_h"]; $orden=$_GET["orden"]; $oporden=$_GET["oporden"]; $php_os=PHP_OS; $cfechan=formato_aaaammdd($fecha_nom); $Sql="";   $date = date("d-m-Y");   $hora = date("H:i:s a");
   $rango_f=$_GET["rango_f"]; $fecha_desde=$_GET["fecha_desde"];  $fecha_hasta=$_GET["fecha_hasta"];  $cfechad=formato_aaaammdd($fecha_desde); $cfechah=formato_aaaammdd($fecha_hasta);
   $criterio="rpt_nom_cal WHERE (oculto='NO') ";  $criterio1="FECHA AL ".$fecha_nom;
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (oculto='NO') ";} 
   if($rango_f=='S'){ $act_hist='S';  $mes_comp='S'; $criterio="rpt_nom_hist WHERE (fecha_p_hasta>='".$cfechad."') and (fecha_p_hasta<='".$cfechah."') and (oculto='NO')  ";   
                      $criterio1="Fecha Desde: ".$fecha_desde." Hasta ".$fecha_hasta;	} 
   if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}   
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and (concepto_vac='N') ";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and (concepto_vac='S') ";} 
function Rellenarespder($str,$n){$numeroarellenar=$n-strlen($str); $texto=""; for ($i=0; $i < $numeroarellenar; $i++){$texto=$texto." ";} $texto=$str.$texto; return $texto;}
function Rellenarespizq($str,$n){$numeroarellenar=$n-strlen($str); $texto=""; for ($i=0; $i < $numeroarellenar; $i++){$texto=$texto." ";} $texto=$texto.$str; return $texto;}
function inserta_espacio($n){ $texto=""; $car="";  for ($i=0; $i < $n; $i++){$texto=$texto." ";}  return $texto;}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} $criterio3="";   
if($php_os=="WINNT"){$Nom_Emp=$Nom_Emp; }else{$Nom_Emp=utf8_decode($Nom_Emp);  }

if(($tipo_rpt=="PDF")and(($Cod_Emp=="58")or($Cod_Emp=="84")or($Cod_Emp=="87")or($Cod_Emp=="37")or($Cod_Emp=="12"))){ $tipo_rpt="PDF2";}	
if(($tipo_rpt=="PDF")and(($Cod_Emp=="88"))){ $tipo_rpt="PDF3";}	
    $sSQL = "SELECT *  FROM ".$criterio." and (tp_calculo='".$tipo_calculo."') and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."') and
		  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_cargo>='".$codigo_cargo_d."' and cod_cargo<='".$codigo_cargo_h."') and (num_recibo>='".$num_recibo_d."' and num_recibo<='".$num_recibo_h."') ".$orden.",fecha_p_hasta desc";    
	if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php"); // echo $sSQL;
		  $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_reci_pago_rn_re.xml");
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
    if($tipo_rpt=="PDF"){  $res=pg_query($sSQL);  $cod_empleado_grupo=""; $cod_concepto_grupo="";  	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $cod_empleado_grupo; global $cod_concepto_grupo; global $registro;
			$this->Image('../../imagenes/Logo_emp.png',7,7,15);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,10,'RECIBO DE PAGO',1,0,'C');
			$this->Ln(18);
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf = new FPDF('P', 'mm', array(215,137)); //media pagina
	  //$pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',8);
	  $i=0; $total_monto=0; $sub_total_monto_asignacion=0;  $sub_total_monto_deduccion=0; $sub_total_monto=0; $total_cantidad=0; $resultado1=0; $resultado2=0;   $resultado3=0;		 $prev_cod_empleado=""; $prev_cod_concepto=""; $prev_nombre="";   
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_empleado=$registro["cod_empleado"]; $cod_concepto=$registro["cod_concepto"]; $nombre=$registro["nombre"]; 
          $denominacion=$registro["denominacion"];$cedula=$registro["cedula"]; $des_cargo=$registro["des_cargo"]; $fechai=$registro["fechai"]; $des_departam=$registro["des_departam"];  
	      $cod_categ=$registro["cod_categ"]; $fechad=$registro["fechad"]; $fechah=$registro["fechah"]; $sueldo_cargo=$registro["sueldo_cargo"]; $tipo_pago=$registro["tipo_pago"];
	      $nombre_banco=$registro["nombre_banco"];      $cta_empleado=$registro["cta_empleado"]; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
		  if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_cargo=utf8_decode($des_cargo); $nombre_banco=utf8_decode($nombre_banco);  $des_departam=utf8_decode($des_departam);  $nombre=utf8_decode($nombre); $denominacion=utf8_decode($denominacion);}
		  $cod_empleado_grupo=$cod_empleado; $cod_concepto_grupo=$cod_concepto; $nombre_grupo=$nombre; $denominacion_grupo=$denominacion; $cedula_grupo=$cedula; 
          $des_cargo_grupo=$des_cargo;  $fechai_grupo=$fechai;$des_departam_grupo=$des_departam; $cod_categ_grupo=$cod_categ; $fechad_grupo=$fechad; $fechah_grupo=$fechah; 
	      $paso_grupo=$registro["paso"];$grado_grupo=$registro["grado"];
		  $sueldo_cargo_grupo=$sueldo_cargo; $nombre_banco_grupo=$nombre_banco; 
          $cta_empleado_grupo=$cta_empleado; $fechai=formato_ddmmaaaa($fechai); $fechad=formato_ddmmaaaa($fechad); $fechah=formato_ddmmaaaa($fechah);
          if(($prev_cod_concepto<>$cod_concepto_grupo)or($prev_cod_empleado<>$cod_empleado_grupo)){ 
			 if(($total_cantidad>0)or($resultado1>0)or($resultado2>0)or($resultado3>0)){ 
			    if($total_cantidad==0){$total_cantidad="";}else{$total_cantidad=formato_monto($total_cantidad);} 
				if($resultado1==0){$resultado1="";}else{$resultado1=formato_monto($resultado1); }
				if($resultado2==0){$resultado2="";}else{$resultado2=formato_monto($resultado2); } 
				if($resultado3==0){$resultado3="";}else{$resultado3=formato_monto($resultado3);	}
				$pdf->Cell(15,4,$prev_cod_concepto,0,0,'L');
		        $x=$pdf->GetX();   $y=$pdf->GetY();  $w=130;		   
		   		$pdf->SetXY($x+$w,$y);		   
		   		$pdf->Cell(15,4,$total_cantidad,0,0,'R'); 
		   		$pdf->Cell(20,4,$resultado1,0,0,'R'); 
		   		$pdf->Cell(20,4,$resultado2,0,1,'R'); 
		  		$pdf->SetXY($x,$y);	
		   		$pdf->MultiCell($w,4,$prev_denominacion,0); 
			 }	
			 $prev_cod_concepto=$cod_concepto_grupo; $prev_denominacion=$denominacion_grupo; $total_cantidad=0; $resultado1=0; $resultado2=0; $resultado3=0;}

		   if($prev_cod_empleado<>$cod_empleado_grupo){ 
			 if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){ $sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion);
                $sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto=formato_monto($sub_total_monto);	
				$pdf->Cell(140,2,'',0,0,'R');			    
				$pdf->Cell(20,2,'--------------',0,0,'R');
				$pdf->Cell(20,2,'--------------',0,0,'R');
				$pdf->Cell(20,2,'',0,1,'R');			
				$pdf->Cell(140,4,'Totales : ',0,0,'R');
				$pdf->Cell(20,4,$sub_total_monto_asignacion,0,0,'R');
				$pdf->Cell(20,4,$sub_total_monto_deduccion,0,1,'R');
				$pdf->Ln(5);
				$pdf->Cell(20,2,'',0,0,'R');
				$pdf->Cell(100,2,'_______________________________',0,0,'C');
				$pdf->Cell(40,2,'',0,0,'R');
				$pdf->Cell(20,2,'=============',0,1,'R');
				$pdf->Ln(4);
				$pdf->Cell(20,3,'',0,0,'R');
				$pdf->Cell(100,3,'RECIBE CONFORME',0,0,'C');
		        $pdf->SetFont('Arial','B',8);
				$pdf->Cell(40,3,'NETO EN BOLIVARES: ',0,0,'C');
				$pdf->Cell(20,3,$sub_total_monto,0,0,'R');
				$pdf->Cell(20,3,'',0,1,'R');
				$pdf->Cell(20,3,'',0,0,'R');
		        $pdf->SetFont('Arial','',8);
				$pdf->Cell(100,3,$prev_nombre,0,0,'C');
				$pdf->Cell(80,3,'',0,1,'R');
                $pdf->AddPage();
			   }	$temp_sueldo=formato_monto($sueldo_cargo_grupo);
			   
			    /*  para colocar logo y encabezado de recibo */
				
				//$pdf->Image('../../imagenes/Logo_emp.png',7,7,13);
			        $pdf->SetFont('Arial','B',11);
			        $pdf->Cell(20);
				//$Nom_Emp=utf8_decode($Nom_Emp);
				$pdf->Cell(100,5,utf8_decode($Nom_Emp),0,0,'L');
			    $pdf->Cell(70,10,'RECIBO DE PAGO',0,1,'C');
		   	    $pdf->Ln(4);			
			    $pdf->SetFont('Arial','',9);
				$pdf->Cell(160,4,$tipo_nomina.' '.$des_nomina,0,0,'L');  
				$pdf->Cell(40,4,'Codigo : '.$cod_empleado_grupo,0,1,'L');
				$pdf->Cell(160,4,'Apellidos y Nombres: '.$nombre_grupo,0,0,'L');  
				$pdf->Cell(40,4,'Cedula : '.$cedula_grupo,0,1,'L');
				$pdf->Cell(120,4,'Cargo: '.$des_cargo_grupo,0,0,'L'); 
                $pdf->Cell(40,4,'Paso: '.$paso_grupo.' Grado:'.$grado_grupo,0,0,'L'); 				
				$pdf->Cell(40,4,'Fecha Ingreso: '.$fechai_grupo,0,1,'L');
				$pdf->Cell(160,4,'Adscripcion: '.$des_departam_grupo,0,0,'L');  
				$pdf->Cell(40,4,'Categoria: '.$cod_categ_grupo,0,1,'L');
				if($rango_f=='S'){$pdf->Cell(160,4,$criterio1,0,1,'L');}else{ $pdf->Cell(160,4,'Fecha Desde: '.$fechad_grupo."   "."hasta"."   ".$fechah_grupo,0,0,'L'); } 
				$pdf->Cell(40,4,'Sueldo Mensual: '.$temp_sueldo,0,1,'L');
				if($tipo_pago=="DEPOSITO"){
				$pdf->Cell(130,4,'Informacion Bancaria: '.$nombre_banco_grupo,0,0,'L');  
				$pdf->Cell(70,4,'Nro. de Cuenta: '.$cta_empleado_grupo,0,1,'L');}
				else{ $pdf->Cell(120,4,'Forma de Pago: '.$tipo_pago,0,1,'L'); }
				$pdf->Ln(4);
				$pdf->Cell(15,4,'Codigo',1,0,'L');
				$pdf->Cell(130,4,'Descripcion Concepto',1,0,'L');
				$pdf->Cell(15,4,'Cantidad',1,0,'C');
				$pdf->Cell(20,4,'Asignaciones',1,0,'R');
				$pdf->Cell(20,4,'Deducciones',1,1,'R');
				$prev_cod_empleado=$cod_empleado_grupo; $prev_nombre=$nombre_grupo; $sub_total_monto_asignacion=0; $sub_total_monto_deduccion=0; $sub_total_monto=0; } 

		  $cod_empleado=$registro["cod_empleado"]; $cod_concepto=$registro["cod_concepto"]; $nombre=$registro["nombre"]; $denominacion=$registro["denominacion"];
		  $cedula=$registro["cedula"];  $des_cargo=$registro["des_cargo"]; $fechai=$registro["fechai"]; $des_departam=$registro["des_departam"]; $monto=$registro["monto"]; 
		  $cod_categ=$registro["cod_categ"]; $fechad=$registro["fechad"]; $fechah=$registro["fechah"]; $sueldo_cargo=$registro["sueldo_cargo"]; $saldo=$registro["saldo"]; 
		  $nombre_banco=$registro["nombre_banco"];  $cta_empleado=$registro["cta_empleado"]; $monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
          $cantidad=$registro["cantidad"]; $sub_total_monto_asignacion=$sub_total_monto_asignacion+$monto_asignacion; 
          $sub_total_monto_deduccion=$sub_total_monto_deduccion+$monto_deduccion;  $sub_total_monto=$sub_total_monto+$monto_asignacion-$monto_deduccion;
          $total_cantidad=$total_cantidad+$cantidad; $total_monto=$total_monto+$monto; 
          $resultado1=$resultado1+$monto_asignacion;$resultado2=$resultado2+$monto_deduccion;
          //if($cod_concepto>="580"){$resultado3=$saldo-$total_monto;}else{$resultado3=$resultado3;}
          $monto_asignacion=formato_monto($monto_asignacion); $monto_deduccion=formato_monto($monto_deduccion); $cantidad=formato_monto($cantidad); $saldo=formato_monto($saldo);$monto=formato_monto($monto);
          $total_monto=formato_monto($total_monto);
		} 
		if(($total_cantidad>0)or($resultado1>0)or($resultado2>0)or($resultado3>0)){ 
			if($total_cantidad==0){$total_cantidad="";}else{$total_cantidad=formato_monto($total_cantidad);} 
			if($resultado1==0){$resultado1="";}else{$resultado1=formato_monto($resultado1); }
			if($resultado2==0){$resultado2="";}else{$resultado2=formato_monto($resultado2); } 
			if($resultado3==0){$resultado3="";}else{$resultado3=formato_monto($resultado3);	}
			$pdf->Cell(15,4,$prev_cod_concepto,0,0,'L');
			$x=$pdf->GetX();   $y=$pdf->GetY();  $w=130;		   
			$pdf->SetXY($x+$w,$y);		   
			$pdf->Cell(15,4,$total_cantidad,0,0,'R'); 
			$pdf->Cell(20,4,$resultado1,0,0,'R'); 
			$pdf->Cell(20,4,$resultado2,0,1,'R'); 
			$pdf->SetXY($x,$y);	
			$pdf->MultiCell($w,4,$prev_denominacion,0); 
		}	
		if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){ $sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion);
			$sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto=formato_monto($sub_total_monto);	
			$pdf->Cell(140,2,'',0,0,'R');			    
			$pdf->Cell(20,2,'--------------',0,0,'R');
			$pdf->Cell(20,2,'--------------',0,1,'R');
			$pdf->Cell(140,4,'Totales : ',0,0,'R');
			$pdf->Cell(20,4,$sub_total_monto_asignacion,0,0,'R');
			$pdf->Cell(20,4,$sub_total_monto_deduccion,0,1,'R');
			$pdf->Ln(5);
			$pdf->Cell(20,2,'',0,0,'R');
			$pdf->Cell(100,2,'_______________________________',0,0,'C');
			$pdf->Cell(40,2,'',0,0,'R');
			$pdf->Cell(20,2,'=============',0,1,'R');
			$pdf->Ln(4);
			$pdf->Cell(20,3,'',0,0,'R');
			$pdf->Cell(100,3,'RECIBE CONFORME',0,0,'C');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(40,3,'NETO EN BOLIVARES: ',0,0,'C');
			$pdf->Cell(20,3,$sub_total_monto,0,0,'R');
			$pdf->Cell(20,3,'',0,1,'R');
			$pdf->Cell(20,3,'',0,0,'R');
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(100,3,$prev_nombre,0,0,'C');
			$pdf->Cell(80,3,'',0,1,'R');
		}	
		$pdf->Output();  
    }	
	if($tipo_rpt=="PDF2"){  $res=pg_query($sSQL);  $cod_empleado_grupo=""; $cod_concepto_grupo="";  	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ $y=$this->GetY(); }
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  $y=$this->GetY(); }
	  }	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage(); $tipo_letra='Arial'; $tipo_letra='Times'; 
	  $pdf->SetFont($tipo_letra,'',9); $l=0; $num_lin_pag=15; $temp_num_rec=0; $num_conc=0;
	  $i=0; $total_monto=0; $sub_total_monto_asignacion=0;  $sub_total_monto_deduccion=0; $sub_total_monto=0; $total_cantidad=0; $resultado1=0; $resultado2=0;   $resultado3=0;		 $prev_cod_empleado=""; $prev_cod_concepto=""; $prev_nombre="";   
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_empleado=$registro["cod_empleado"]; $cod_concepto=$registro["cod_concepto"]; $nombre=$registro["nombre"];  $num_recibo=$registro["num_recibo"]; 
          $denominacion=$registro["denominacion"];$cedula=$registro["cedula"]; $des_cargo=$registro["des_cargo"]; $fechai=$registro["fechai"]; $des_departam=$registro["des_departam"];  
	      $cod_categ=$registro["cod_categ"]; $fechad=$registro["fechad"]; $fechah=$registro["fechah"]; $sueldo_cargo=$registro["sueldo_cargo"]; $tipo_pago=$registro["tipo_pago"];
	      $nombre_banco=$registro["nombre_banco"];      $cta_empleado=$registro["cta_empleado"]; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"]; $descripcion_ubi=$registro["descripcion_ubi"];
		  if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_cargo=utf8_decode($des_cargo); $nombre_banco=utf8_decode($nombre_banco);  $des_departam=utf8_decode($des_departam);  $nombre=utf8_decode($nombre); $denominacion=utf8_decode($denominacion); $descripcion_ubi=utf8_decode($descripcion_ubi);}
		  $cod_empleado_grupo=$cod_empleado; $cod_concepto_grupo=$cod_concepto; $nombre_grupo=$nombre; $denominacion_grupo=$denominacion; $cedula_grupo=$cedula; 
          $des_cargo_grupo=$des_cargo;  $fechai_grupo=$fechai;$des_departam_grupo=$des_departam; $cod_categ_grupo=$cod_categ; $fechad_grupo=$fechad; $fechah_grupo=$fechah; 
	      $sueldo_cargo_grupo=$sueldo_cargo; $nombre_banco_grupo=$nombre_banco; 
          $cta_empleado_grupo=$cta_empleado; $fechai=formato_ddmmaaaa($fechai); $fechad=formato_ddmmaaaa($fechad); $fechah=formato_ddmmaaaa($fechah);
		  if(($prev_cod_concepto<>$cod_concepto_grupo)or($prev_cod_empleado<>$cod_empleado_grupo)){ 
			 if(($total_cantidad>0)or($resultado1>0)or($resultado2>0)or($resultado3>0)){  $num_conc=$num_conc+1;
			    if($total_cantidad==0){$total_cantidad="";}else{$total_cantidad=formato_monto($total_cantidad);} 
				if($resultado1==0){$resultado1="";}else{$resultado1=formato_monto($resultado1); }
				if($resultado2==0){$resultado2="";}else{$resultado2=formato_monto($resultado2); } 
				if($resultado3==0){$resultado3="";}else{$resultado3=formato_monto($resultado3);	}
				$temp1=substr($prev_denominacion,0,100); $pdf->SetFont($tipo_letra,'',9);
				if($num_conc<=$num_lin_pag){ 
				$pdf->Cell(150,4,$temp1,0,0,'L');
				$pdf->Cell(10,4,$total_cantidad,0,0,'R');
		   		$pdf->Cell(20,4,$resultado1,0,0,'R'); 
		   		$pdf->Cell(20,4,$resultado2,0,1,'R'); }
			 }	
			 $prev_cod_concepto=$cod_concepto_grupo; $prev_denominacion=$denominacion_grupo; $total_cantidad=0; $resultado1=0; $resultado2=0; $resultado3=0;}
		   if($prev_cod_empleado<>$cod_empleado_grupo){ 
			  if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){ $sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion);
                $sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto=formato_monto($sub_total_monto);				
				$pdf->Cell(156,5,'TOTAL : ','T',0,'R');
				$pdf->Cell(22,5,$sub_total_monto_asignacion,'T',0,'R');
				$pdf->Cell(22,5,$sub_total_monto_deduccion,'T',1,'R');
				$pdf->Ln(4);
				$pdf->SetFont($tipo_letra,'B',10);
				$pdf->Cell(178,2,'',0,0,'R');
				$pdf->Cell(22,2,'============',0,1,'R');
				$pdf->Cell(178,5,'NETO A COBRAR Bs. ==>  ',0,0,'R');
				$pdf->Cell(22,5,$sub_total_monto,0,1,'R');				
		        $pdf->SetFont($tipo_letra,'',10);
				$pdf->Ln(4);
				$y=$pdf->GetY();
				if($y<140){ $l=145-$y; $pdf->Ln($l);} else{$pdf->AddPage();}
				$l=0;				
			   } $temp_sueldo=formato_monto($sueldo_cargo_grupo);
			    $temp_num_rec=$temp_num_rec+1; $temp_rec=$temp_num_rec; $len=strlen($temp_rec); $temp_rec=substr("00000",0,5-$len).$temp_rec;
			    if($oporden<>1){ $num_recibo=$temp_rec; }
				//$Nom_Emp=utf8_decode($Nom_Emp);
				$pdf->SetFont($tipo_letra,'B',11);				
				$pdf->Cell(160,5,$Nom_Emp,0,0,'C');
                $pdf->Cell(40,5,'RECIBO DE PAGO',0,1,'C'); 
                $pdf->SetFont($tipo_letra,'',10);				
				$temp1=substr($des_nomina,0,30); $temp2="Periodo del " .$fechad_grupo. " al " .$fechah_grupo; if($rango_f=='S'){$temp2=$criterio1;}
				$pdf->Cell(80,5,$temp1,0,0,'L'); 
				$pdf->Cell(80,5,$temp2,0,0,'L'); 
				$pdf->Cell(40,5,"Nro. ".$num_recibo,0,1,'R'); 
				$pdf->Cell(40,5,'Cedula : '.$cedula_grupo,0,0,'L');
				$pdf->Cell(160,5,'Nombre: '.$nombre_grupo,0,1,'L');  
				$pdf->Cell(160,5,'Cargo: '.$des_cargo_grupo,0,0,'L');  
				$pdf->Cell(40,5,'Fecha Ingreso: '.$fechai_grupo,0,1,'L');
				$temp1="Departamento: ".substr($des_departam_grupo,0,50); 
			    if($oporden==3){ $temp1="Codigo Categoria: ".$cod_categ_grupo;  }
			    if($oporden==4){ $temp1="Ubicacion: ".substr($descripcion_ubi,0,50);  }
				$pdf->Cell(160,5,$temp1,0,0,'L');
				$pdf->Cell(40,5,'Sueldo Mensual: '.$temp_sueldo,0,1,'L');
				if($tipo_pago=="DEPOSITO"){
				$pdf->Cell(130,5,'Deposito Banco: '.$nombre_banco_grupo,0,0,'L');  
				$pdf->Cell(70,5,'Cuenta Nro.: '.$cta_empleado_grupo,0,1,'R');}
				else{ $pdf->Cell(120,5,'Forma de Pago: '.$tipo_pago,0,1,'L'); }
				$pdf->Cell(144,5,'Nombre del Concepto',1,0,'L');
				$pdf->Cell(15,5,'Cantidad',1,0,'R');
				$pdf->Cell(21,5,'Asignaciones',1,0,'R');
				$pdf->Cell(20,5,'Deducciones',1,1,'R');
				$num_conc=0; $prev_cod_empleado=$cod_empleado_grupo; $prev_nombre=$nombre_grupo; $sub_total_monto_asignacion=0; $sub_total_monto_deduccion=0; $sub_total_monto=0; } 

		  $cod_empleado=$registro["cod_empleado"]; $cod_concepto=$registro["cod_concepto"]; $nombre=$registro["nombre"]; $denominacion=$registro["denominacion"];
		  $cedula=$registro["cedula"];  $des_cargo=$registro["des_cargo"]; $fechai=$registro["fechai"]; $des_departam=$registro["des_departam"]; $monto=$registro["monto"]; 
		  $cod_categ=$registro["cod_categ"]; $fechad=$registro["fechad"]; $fechah=$registro["fechah"]; $sueldo_cargo=$registro["sueldo_cargo"]; $saldo=$registro["saldo"]; 
		  $nombre_banco=$registro["nombre_banco"];  $cta_empleado=$registro["cta_empleado"]; $monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
          $cantidad=$registro["cantidad"]; $sub_total_monto_asignacion=$sub_total_monto_asignacion+$monto_asignacion; 
          $sub_total_monto_deduccion=$sub_total_monto_deduccion+$monto_deduccion;  $sub_total_monto=$sub_total_monto+$monto_asignacion-$monto_deduccion;
          $total_cantidad=$total_cantidad+$cantidad; $total_monto=$total_monto+$monto; 
          $resultado1=$resultado1+$monto_asignacion;$resultado2=$resultado2+$monto_deduccion;
          $monto_asignacion=formato_monto($monto_asignacion); $monto_deduccion=formato_monto($monto_deduccion); $cantidad=formato_monto($cantidad); $saldo=formato_monto($saldo);$monto=formato_monto($monto);
          $total_monto=formato_monto($total_monto);
		} 
		if(($total_cantidad>0)or($resultado1>0)or($resultado2>0)or($resultado3>0)){ $num_conc=$num_conc+1;
			if($total_cantidad==0){$total_cantidad="";}else{$total_cantidad=formato_monto($total_cantidad);} 
			if($resultado1==0){$resultado1="";}else{$resultado1=formato_monto($resultado1); }
			if($resultado2==0){$resultado2="";}else{$resultado2=formato_monto($resultado2); } 
			if($resultado3==0){$resultado3="";}else{$resultado3=formato_monto($resultado3);	}
			$temp1=substr($prev_denominacion,0,100); $pdf->SetFont($tipo_letra,'',9);
			if($num_conc<=$num_lin_pag){
			$pdf->Cell(150,4,$temp1,0,0,'L');
			$pdf->Cell(10,4,$total_cantidad,0,0,'R');
		    $pdf->Cell(20,4,$resultado1,0,0,'R'); 
		   	$pdf->Cell(20,4,$resultado2,0,1,'R'); }
		}	
		if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){ $sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion);
			$sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto=formato_monto($sub_total_monto);	
			$pdf->Cell(156,5,'TOTAL : ','T',0,'R');
			$pdf->Cell(22,5,$sub_total_monto_asignacion,'T',0,'R');
			$pdf->Cell(22,5,$sub_total_monto_deduccion,'T',1,'R');
			$pdf->Ln(4);
			$pdf->SetFont($tipo_letra,'B',10);
			$pdf->Cell(178,2,'',0,0,'R');
			$pdf->Cell(22,2,'============',0,1,'R');
			$pdf->Cell(178,5,'NETO A COBRAR Bs. ==>  ',0,0,'R');
			$pdf->Cell(22,5,$sub_total_monto,0,1,'R');				
			$pdf->SetFont($tipo_letra,'',10);
		}	
		$pdf->Output();  
    }	
	
	if($tipo_rpt=="PDF3"){  $res=pg_query($sSQL);  $cod_empleado_grupo=""; $cod_concepto_grupo="";  	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ $y=$this->GetY(); }
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  $y=$this->GetY(); }
	  }	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage(); $tipo_letra='Arial'; $tipo_letra='Times'; 
	  $pdf->SetFont($tipo_letra,'',9); $l=0; $num_lin_pag=15; $temp_num_rec=0; $num_conc=0;
	  $i=0; $total_monto=0; $sub_total_monto_asignacion=0;  $sub_total_monto_deduccion=0; $sub_total_monto=0; $total_cantidad=0; $resultado1=0; $resultado2=0;   $resultado3=0;		 $prev_cod_empleado=""; $prev_cod_concepto=""; $prev_nombre="";   
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_empleado=$registro["cod_empleado"]; $cod_concepto=$registro["cod_concepto"]; $nombre=$registro["nombre"];  $num_recibo=$registro["num_recibo"]; 
          $denominacion=$registro["denominacion"];$cedula=$registro["cedula"]; $des_cargo=$registro["des_cargo"]; $fechai=$registro["fechai"]; $des_departam=$registro["des_departam"];  
	      $cod_categ=$registro["cod_categ"]; $fechad=$registro["fechad"]; $fechah=$registro["fechah"]; $sueldo_cargo=$registro["sueldo_cargo"]; $tipo_pago=$registro["tipo_pago"];
	      $nombre_banco=$registro["nombre_banco"];      $cta_empleado=$registro["cta_empleado"]; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"]; $descripcion_ubi=$registro["descripcion_ubi"];
		  if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_cargo=utf8_decode($des_cargo); $nombre_banco=utf8_decode($nombre_banco);  $des_departam=utf8_decode($des_departam);  $nombre=utf8_decode($nombre); $denominacion=utf8_decode($denominacion); $descripcion_ubi=utf8_decode($descripcion_ubi);}
		  $cod_empleado_grupo=$cod_empleado; $cod_concepto_grupo=$cod_concepto; $nombre_grupo=$nombre; $denominacion_grupo=$denominacion; $cedula_grupo=$cedula; 
          $des_cargo_grupo=$des_cargo;  $fechai_grupo=$fechai;$des_departam_grupo=$des_departam; $cod_categ_grupo=$cod_categ; $fechad_grupo=$fechad; $fechah_grupo=$fechah; 
	      $sueldo_cargo_grupo=$sueldo_cargo; $nombre_banco_grupo=$nombre_banco; 
          $cta_empleado_grupo=$cta_empleado; $fechai=formato_ddmmaaaa($fechai); $fechad=formato_ddmmaaaa($fechad); $fechah=formato_ddmmaaaa($fechah);
		  if(($prev_cod_concepto<>$cod_concepto_grupo)or($prev_cod_empleado<>$cod_empleado_grupo)){ 
			 if(($total_cantidad>0)or($resultado1>0)or($resultado2>0)or($resultado3>0)){  $num_conc=$num_conc+1;
			    if($total_cantidad==0){$total_cantidad="";}else{$total_cantidad=formato_monto($total_cantidad);} 
				if($resultado1==0){$resultado1="";}else{$resultado1=formato_monto($resultado1); }
				if($resultado2==0){$resultado2="";}else{$resultado2=formato_monto($resultado2); } 
				if($resultado3==0){$resultado3="";}else{$resultado3=formato_monto($resultado3);	}
				$temp1=substr($prev_denominacion,0,100); $pdf->SetFont($tipo_letra,'',9);
				if($num_conc<=$num_lin_pag){ 
				$pdf->Cell(150,4,$temp1,'L',0,'L');
				$pdf->Cell(10,4,$total_cantidad,0,0,'R');
		   		$pdf->Cell(20,4,$resultado1,0,0,'R'); 
		   		$pdf->Cell(20,4,$resultado2,'R',1,'R'); }
			 }	
			 $prev_cod_concepto=$cod_concepto_grupo; $prev_denominacion=$denominacion_grupo; $total_cantidad=0; $resultado1=0; $resultado2=0; $resultado3=0;}
		   if($prev_cod_empleado<>$cod_empleado_grupo){ 
			  if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){ $sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion);
                $sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto=formato_monto($sub_total_monto);	
                $pdf->SetFont($tipo_letra,'B',9);				
				$pdf->Cell(156,5,'TOTAL : ','T',0,'R');
				$pdf->Cell(22,5,$sub_total_monto_asignacion,'T',0,'R');
				$pdf->Cell(22,5,$sub_total_monto_deduccion,'T',1,'R');
				$pdf->Ln(4);
				$pdf->SetFont($tipo_letra,'B',10);
				$pdf->Cell(178,2,'',0,0,'R');
				$pdf->Cell(22,2,'============',0,1,'R');
				$pdf->Cell(178,5,'NETO A COBRAR Bs. ==>  ',0,0,'R');
				$pdf->Cell(22,5,$sub_total_monto,0,1,'R');				
		        $pdf->SetFont($tipo_letra,'',10);
				$pdf->Ln(4);
				$y=$pdf->GetY();
				if($y<140){ $l=145-$y; $pdf->Ln($l);} else{$pdf->AddPage();}
				$l=0;				
			   } $temp_sueldo=formato_monto($sueldo_cargo_grupo);
			    $temp_num_rec=$temp_num_rec+1; $temp_rec=$temp_num_rec; $len=strlen($temp_rec); $temp_rec=substr("00000",0,5-$len).$temp_rec;
			    if($oporden<>1){ $num_recibo=$temp_rec; }
				$pdf->SetFont($tipo_letra,'B',11);
				$y=$pdf->GetY();
				$pdf->Image('../../imagenes/Logo_emp.png',7,$y-1,32);
				//$Nom_Emp=utf8_decode($Nom_Emp);
				$pdf->Cell(160,5,$Nom_Emp,0,0,'C');
                $pdf->Cell(40,5,'RECIBO DE PAGO',0,1,'C'); 
                $pdf->SetFont($tipo_letra,'',10);				
				$temp1=substr($des_nomina,0,45); $temp2="Periodo del " .$fechad_grupo. " al " .$fechah_grupo; if($rango_f=='S'){$temp2=$criterio1;}
				$pdf->Cell(35,5,'',0,0);
				$pdf->Cell(105,5,$temp1,0,0,'L'); 
				$pdf->Cell(60,5,$temp2,0,1,'R'); 
				//$pdf->Cell(20,5,"Nro. ".$num_recibo,0,1,'R');
                $pdf->Cell(35,5,'',0,0);			
				$pdf->Cell(30,5,'Cedula : '.$cedula_grupo,0,0,'L');
				$pdf->Cell(135,5,'Nombre: '.$nombre_grupo,0,1,'L');  
				$pdf->Cell(160,5,'Cargo: '.$des_cargo_grupo,0,0,'L');  
				$pdf->Cell(40,5,'Fecha Ingreso: '.$fechai_grupo,0,1,'L');
				$temp1="Departamento: ".substr($des_departam_grupo,0,50); 
			    if($oporden==3){ $temp1="Codigo Categoria: ".$cod_categ_grupo;  }
			    if($oporden==4){ $temp1="Ubicacion: ".substr($descripcion_ubi,0,50);  }
				$pdf->Cell(160,5,$temp1,0,0,'L');
				$pdf->Cell(40,5,'Sueldo Mensual: '.$temp_sueldo,0,1,'L');
				if($tipo_pago=="DEPOSITO"){
				$pdf->Cell(130,5,'Deposito Banco: '.$nombre_banco_grupo,0,0,'L');  
				$pdf->Cell(70,5,'Cuenta Nro.: '.$cta_empleado_grupo,0,1,'R');}
				else{ $pdf->Cell(120,5,'Forma de Pago: '.$tipo_pago,0,1,'L'); }
				$pdf->Cell(144,5,'Nombre del Concepto',1,0,'L');
				$pdf->Cell(15,5,'Cantidad',1,0,'R');
				$pdf->Cell(21,5,'Asignaciones',1,0,'R');
				$pdf->Cell(20,5,'Deducciones',1,1,'R');
				$num_conc=0; $prev_cod_empleado=$cod_empleado_grupo; $prev_nombre=$nombre_grupo; $sub_total_monto_asignacion=0; $sub_total_monto_deduccion=0; $sub_total_monto=0; } 

		  $cod_empleado=$registro["cod_empleado"]; $cod_concepto=$registro["cod_concepto"]; $nombre=$registro["nombre"]; $denominacion=$registro["denominacion"];
		  $cedula=$registro["cedula"];  $des_cargo=$registro["des_cargo"]; $fechai=$registro["fechai"]; $des_departam=$registro["des_departam"]; $monto=$registro["monto"]; 
		  $cod_categ=$registro["cod_categ"]; $fechad=$registro["fechad"]; $fechah=$registro["fechah"]; $sueldo_cargo=$registro["sueldo_cargo"]; $saldo=$registro["saldo"]; 
		  $nombre_banco=$registro["nombre_banco"];  $cta_empleado=$registro["cta_empleado"]; $monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
          $cantidad=$registro["cantidad"]; $sub_total_monto_asignacion=$sub_total_monto_asignacion+$monto_asignacion; 
          $sub_total_monto_deduccion=$sub_total_monto_deduccion+$monto_deduccion;  $sub_total_monto=$sub_total_monto+$monto_asignacion-$monto_deduccion;
          $total_cantidad=$total_cantidad+$cantidad; $total_monto=$total_monto+$monto; 
          $resultado1=$resultado1+$monto_asignacion;$resultado2=$resultado2+$monto_deduccion;
          $monto_asignacion=formato_monto($monto_asignacion); $monto_deduccion=formato_monto($monto_deduccion); $cantidad=formato_monto($cantidad); $saldo=formato_monto($saldo);$monto=formato_monto($monto);
          $total_monto=formato_monto($total_monto);
		} 
		if(($total_cantidad>0)or($resultado1>0)or($resultado2>0)or($resultado3>0)){ $num_conc=$num_conc+1;
			if($total_cantidad==0){$total_cantidad="";}else{$total_cantidad=formato_monto($total_cantidad);} 
			if($resultado1==0){$resultado1="";}else{$resultado1=formato_monto($resultado1); }
			if($resultado2==0){$resultado2="";}else{$resultado2=formato_monto($resultado2); } 
			if($resultado3==0){$resultado3="";}else{$resultado3=formato_monto($resultado3);	}
			$temp1=substr($prev_denominacion,0,100); $pdf->SetFont($tipo_letra,'',9);
			if($num_conc<=$num_lin_pag){
			$pdf->Cell(150,4,$temp1,'L',0,'L');
			$pdf->Cell(10,4,$total_cantidad,0,0,'R');
		    $pdf->Cell(20,4,$resultado1,0,0,'R'); 
		   	$pdf->Cell(20,4,$resultado2,'R',1,'R'); }
		}	
		if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){ $sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion);
			$sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto=formato_monto($sub_total_monto);	
			$pdf->SetFont($tipo_letra,'B',9);
			$pdf->Cell(156,5,'TOTAL : ','T',0,'R');
			$pdf->Cell(22,5,$sub_total_monto_asignacion,'T',0,'R');
			$pdf->Cell(22,5,$sub_total_monto_deduccion,'T',1,'R');
			$pdf->Ln(4);
			$pdf->SetFont($tipo_letra,'B',10);
			$pdf->Cell(178,2,'',0,0,'R');
			$pdf->Cell(22,2,'============',0,1,'R');
			$pdf->Cell(178,5,'NETO A COBRAR Bs. ==>  ',0,0,'R');
			$pdf->Cell(22,5,$sub_total_monto,0,1,'R');				
			$pdf->SetFont($tipo_letra,'',10);
		}	
		$pdf->Output();  
    }	
	if($tipo_rpt=="TXT"){  $res=pg_query($sSQL);  $cod_empleado_grupo=""; $cod_concepto_grupo="";  
	   header('Content-type: application/txt');
       header("Content-Disposition: attachment; filename=recibo.txt");	
      $salto="\n"; $l=0; $num_lin_pag=32; $temp_num_rec=0;
	  $i=0; $total_monto=0; $sub_total_monto_asignacion=0;  $sub_total_monto_deduccion=0; $sub_total_monto=0; $total_cantidad=0; $resultado1=0; $resultado2=0;   $resultado3=0;	$prev_num_recibo="";	 $prev_cod_empleado=""; $prev_cod_concepto=""; $prev_nombre="";   
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_empleado=$registro["cod_empleado"]; $cod_concepto=$registro["cod_concepto"]; $nombre=$registro["nombre"]; $num_recibo=$registro["num_recibo"]; 
          $denominacion=$registro["denominacion"];$cedula=$registro["cedula"]; $des_cargo=$registro["des_cargo"]; $fechai=$registro["fechai"]; $des_departam=$registro["des_departam"];  
	      $cod_categ=$registro["cod_categ"]; $fechad=$registro["fechad"]; $fechah=$registro["fechah"]; $sueldo_cargo=$registro["sueldo_cargo"]; $tipo_pago=$registro["tipo_pago"];
	      $nombre_banco=$registro["nombre_banco"];      $cta_empleado=$registro["cta_empleado"]; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"]; $descripcion_ubi=$registro["descripcion_ubi"];
		  $cod_empleado_grupo=$cod_empleado; $cod_concepto_grupo=$cod_concepto; $nombre_grupo=$nombre; $denominacion_grupo=$denominacion; $cedula_grupo=$cedula; 
          $des_cargo_grupo=$des_cargo;  $fechai_grupo=$fechai;$des_departam_grupo=$des_departam; $cod_categ_grupo=$cod_categ; $fechad_grupo=$fechad; $fechah_grupo=$fechah; 
	      $sueldo_cargo_grupo=$sueldo_cargo; $nombre_banco_grupo=$nombre_banco; 
          $cta_empleado_grupo=$cta_empleado; $fechai=formato_ddmmaaaa($fechai); $fechad=formato_ddmmaaaa($fechad); $fechah=formato_ddmmaaaa($fechah);
          if($prev_cod_concepto<>$cod_concepto_grupo){ 
			if(($total_cantidad>0)or($resultado1>0)or($resultado2>0)or($resultado3>0)){ 
			    if($total_cantidad==0){$total_cantidad="";}else{$total_cantidad=formato_monto($total_cantidad);} 
				if($resultado1==0){$resultado1="";}else{$resultado1=formato_monto($resultado1); }
				if($resultado2==0){$resultado2="";}else{$resultado2=formato_monto($resultado2); } 
				if($resultado3==0){$resultado3="";}else{$resultado3=formato_monto($resultado3);	}				
				$temp1=Rellenarespizq($resultado1,17); $temp2=Rellenarespizq($resultado2,17);
				$temp3=substr($prev_denominacion,0,40); $temp3=Rellenarespder($temp3,40);
				echo $temp3." " .$temp1." ".$temp2.$salto; $l=$l+1;
			}	
			$prev_cod_concepto=$cod_concepto_grupo; $prev_denominacion=$denominacion_grupo; $total_cantidad=0; $resultado1=0; $resultado2=0; $resultado3=0;}

		    if($prev_cod_empleado<>$cod_empleado_grupo){ 
			 if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){ 
			    $sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion);
                $sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto=formato_monto($sub_total_monto);	
				$temp1="----------------------------------------------------------------------------- ";
			    echo $temp1.$salto;
				$temp1=Rellenarespizq($sub_total_monto_asignacion,17); $temp2=Rellenarespizq($sub_total_monto_deduccion,17);
				$temp3="                             TOTAL "; $temp3=Rellenarespder($temp3,40);
				echo $temp3." " .$temp1." ".$temp2.$salto; $l=$l+1;
				echo " ".$salto; $l=$l+1;
				$temp3="                                   NETO A COBRAR Bs. ==> "; $temp3=Rellenarespder($temp3,57);
				$temp2=Rellenarespizq($sub_total_monto,17);
				echo $temp3."  ".$temp2.$salto; $l=$l+1;
				for ($i=$l; $i < $num_lin_pag; $i++){echo " ".$salto;}
				$l=0;
			   }	$temp_sueldo=formato_monto($sueldo_cargo_grupo);
			   $temp_num_rec=$temp_num_rec+1; $temp_rec=$temp_num_rec; $len=strlen($temp_rec); $temp_rec=substr("00000",0,5-$len).$temp_rec;
			   if($oporden<>1){ $num_recibo=$temp_num_rec; }                			   
			   echo $Nom_Emp."   RECIBO DE PAGO Nro. ".$num_recibo.$salto; $l=$l+1;
			   $temp2="Periodo del " .$fechad_grupo. " al " .$fechah_grupo; if($rango_f=='S'){$temp2=$criterio1;}
			   echo substr($des_nomina,0,20)."          ".$temp2.$salto; $l=$l+1;
			   $temp1="Cedula: ".$cedula_grupo; $temp2="Nombre: ".$nombre_grupo;
			   $temp1=Rellenarespder($temp1,18); $temp2=Rellenarespder($temp2,56);
			   echo $temp1." ".$temp2.$salto; $l=$l+1;
			   $temp1="Cargo: ".substr($des_cargo_grupo,0,40); $temp2="Fecha Ingreso: ".$fechai_grupo;
			   $temp1=Rellenarespder($temp1,49); $temp2=Rellenarespder($temp2,28);
			   echo $temp1." ".$temp2.$salto; $l=$l+1;
			   $temp1="Departamento: ".substr($des_departam_grupo,0,40); 
			   if($oporden==3){ $temp1="Codigo Categoria: ".$cod_categ_grupo;  }
			   if($oporden==4){ $temp1="Ubicacion: ".substr($descripcion_ubi,0,40);  }
			   $temp1=Rellenarespder($temp1,49);	$temp2="Sueldo: ".$temp_sueldo;
			   echo $temp1." ".$temp2.$salto; $l=$l+1;
			   $temp1=Rellenarespder($temp1,50); $temp2=Rellenarespder($temp2,28);
			   if($tipo_pago=="DEPOSITO"){
			      $temp1="Deposito Banco: ".substr($nombre_banco_grupo,0,30);  $temp2="Cta.Nro: ".$cta_empleado_grupo;
				  $temp1=Rellenarespder($temp1,48); $temp2=Rellenarespder($temp2,30);
			      echo $temp1." ".$temp2.$salto; $l=$l+1;
			   }
			   $temp1="------------------------------------------------------------------------------ ";
			   echo $temp1.$salto; $l=$l+1;
			   $temp1="NOMBRE DEL CONCEPTO                          ASIGNACIONES         DEDUCCIONES";
			   echo $temp1.$salto; $l=$l+1;
			   $temp1="------------------------------------------------------------------------------ ";
			   echo $temp1.$salto; $l=$l+1;
			   $prev_cod_empleado=$cod_empleado_grupo; $prev_nombre=$nombre_grupo; $sub_total_monto_asignacion=0; $sub_total_monto_deduccion=0; $sub_total_monto=0; 
			} 

		  $cod_empleado=$registro["cod_empleado"]; $cod_concepto=$registro["cod_concepto"]; $nombre=$registro["nombre"]; $denominacion=$registro["denominacion"];
		  $cedula=$registro["cedula"];  $des_cargo=$registro["des_cargo"]; $fechai=$registro["fechai"]; $des_departam=$registro["des_departam"]; $monto=$registro["monto"]; 
		  $cod_categ=$registro["cod_categ"]; $fechad=$registro["fechad"]; $fechah=$registro["fechah"]; $sueldo_cargo=$registro["sueldo_cargo"]; $saldo=$registro["saldo"]; 
		  $nombre_banco=$registro["nombre_banco"];  $cta_empleado=$registro["cta_empleado"]; $monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
          $cantidad=$registro["cantidad"]; $sub_total_monto_asignacion=$sub_total_monto_asignacion+$monto_asignacion; 
          $sub_total_monto_deduccion=$sub_total_monto_deduccion+$monto_deduccion;  $sub_total_monto=$sub_total_monto+$monto_asignacion-$monto_deduccion;
          $total_cantidad=$total_cantidad+$cantidad; $total_monto=$total_monto+$monto; 
          $resultado1=$resultado1+$monto_asignacion;$resultado2=$resultado2+$monto_deduccion;
          $monto_asignacion=formato_monto($monto_asignacion); $monto_deduccion=formato_monto($monto_deduccion); $cantidad=formato_monto($cantidad); $saldo=formato_monto($saldo);$monto=formato_monto($monto);
          $total_monto=formato_monto($total_monto);
		}
		if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){ 
			$sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion);
			$sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto=formato_monto($sub_total_monto);	
			$temp1="------------------------------------------------------------------------------- ";
			echo $temp1.$salto; $l=$l+1;
			$temp1=Rellenarespizq($sub_total_monto_asignacion,17); $temp2=Rellenarespizq($sub_total_monto_deduccion,17);
			$temp3="                             TOTAL "; $temp3=Rellenarespder($temp3,40);
			echo $temp3." " .$temp1." ".$temp2.$salto; $l=$l+1;
			echo " ".$salto; $l=$l+1;
			$temp3="                                   NETO A COBRAR Bs. ==> "; $temp3=Rellenarespder($temp3,57);
			$temp2=Rellenarespizq($sub_total_monto,17);
			echo $temp3."  ".$temp2.$salto; $l=$l+1;
		}
	}
		  
}
?>
