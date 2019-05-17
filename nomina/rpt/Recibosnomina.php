<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$ced_empleado=$_GET["cedula"];  $fecha_nom=$_GET["fecha_nom"]; $orden=" order by cedula,cod_concepto"; $php_os=PHP_OS; $cfechan=formato_aaaammdd($fecha_nom); $tipo_calculo=$_GET["tipo_calculo"];
$criterio=" nom019 WHERE (fecha_p_hasta='".$cfechan."') and (oculto='NO') ";


$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
$sSQL = "SELECT *  FROM ".$criterio." and (tp_calculo='".$tipo_calculo."')  and (cedula='".$ced_empleado."') ".$orden.",fecha_p_hasta desc";   


$res=pg_query($sSQL);  $cod_empleado_grupo=""; $cod_concepto_grupo="";  	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ $y=$this->GetY(); }
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  $y=$this->GetY(); }
	  }	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage(); $tipo_letra='Arial'; //$tipo_letra='Times'; 
	  $pdf->SetFont($tipo_letra,'',9); $l=0; $num_lin_pag=15; $temp_num_rec=0; $num_conc=0;
	  $i=0; $total_monto=0; $sub_total_monto_asignacion=0;  $sub_total_monto_deduccion=0; $sub_total_monto=0; $total_cantidad=0; $resultado1=0; $resultado2=0;   $resultado3=0;		 $prev_cod_empleado=""; $prev_cod_concepto=""; $prev_nombre="";   



      //$pdf->MultiCell(200,4,$sSQL,0);
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
                $pdf->SetFont($tipo_letra,'',9);				
				$pdf->Cell(156,5,'TOTAL : ',0,0,'R');
				$pdf->SetFont($tipo_letra,'B',9);
				$pdf->Cell(22,5,$sub_total_monto_asignacion,'T',0,'R');
				$pdf->Cell(22,5,$sub_total_monto_deduccion,'T',1,'R');
				$pdf->Ln(5);
				$pdf->SetFont($tipo_letra,'',10);
				$pdf->Cell(20,2,'',0,0,'R');
			    $pdf->Cell(100,2,'_____________________________',0,0,'C');
			    $pdf->Cell(58,2,'',0,0,'R');
				$pdf->Cell(22,2,'============',0,1,'R');
				$pdf->Cell(20,5,'',0,0,'R');
			    $pdf->Cell(100,5,'RECIBE CONFORME',0,0,'C');
			    $pdf->Cell(58,5,'NETO A COBRAR Bs. ==>  ',0,0,'R');
				$pdf->SetFont($tipo_letra,'B',10);
				$pdf->Cell(22,5,$sub_total_monto,0,1,'R');				
		        $pdf->SetFont($tipo_letra,'',10);
				$pdf->Ln(2);
				$y=$pdf->GetY();
				if($y<140){ $l=145-$y; $pdf->Ln($l);} else{$pdf->AddPage();}
				$l=0;				
			   } $temp_sueldo=formato_monto($sueldo_cargo_grupo);
			    $temp_num_rec=$temp_num_rec+1; $temp_rec=$temp_num_rec; $len=strlen($temp_rec); $temp_rec=substr("00000",0,5-$len).$temp_rec;
			    if($oporden<>1){ $num_recibo=$temp_rec; }
				$pdf->SetFont($tipo_letra,'B',11);
				$y=$pdf->GetY();
				//$pdf->Image('../../imagenes/Logo_emp.png',7,$y-1,32);
				//$Nom_Emp=utf8_decode($Nom_Emp);
				$pdf->Cell(160,5,$Nom_Emp,0,0,'C');
                $pdf->Cell(40,5,'RECIBO DE PAGO',0,1,'C'); 
				$pdf->Ln(3);
                $pdf->SetFont($tipo_letra,'',10);				
				$temp1=substr($des_nomina,0,55); $temp2="Periodo del " .$fechad_grupo. " al " .$fechah_grupo; if($rango_f=='S'){$temp2=$criterio1;}
				$pdf->Cell(130,5,$temp1,0,0,'L'); 
				$pdf->Cell(70,5,$temp2,0,1,'R'); 
				//$pdf->Cell(20,5,"Nro. ".$num_recibo,0,1,'R');
                $pdf->Cell(35,5,'Cedula : '.$cedula_grupo,0,0,'L');
				$pdf->Cell(135,5,'Nombre: '.$nombre_grupo,0,1,'L');  
				$pdf->Cell(155,5,'Cargo: '.$des_cargo_grupo,0,0,'L');  
				$pdf->Cell(45,5,'Fecha Ingreso: '.$fechai_grupo,0,1,'L');
				$temp1="Departamento: ".substr($des_departam_grupo,0,50); 
			    if($oporden==3){ $temp1="Codigo Categoria: ".$cod_categ_grupo;  }
			    if($oporden==4){ $temp1="Ubicacion: ".substr($descripcion_ubi,0,50);  }
				$pdf->Cell(155,5,$temp1,0,0,'L');
				$pdf->Cell(45,5,'Sueldo Mensual: '.$temp_sueldo,0,1,'L');
				if($tipo_pago=="DEPOSITO"){
				$pdf->Cell(130,5,'Deposito Banco: '.$nombre_banco_grupo,0,0,'L');  
				$pdf->Cell(70,5,'Cuenta Nro.: '.$cta_empleado_grupo,0,1,'R');}
				else{ $pdf->Cell(120,5,'Forma de Pago: '.$tipo_pago,0,1,'L'); }
				$pdf->Ln(2);
				$pdf->Cell(144,5,'Nombre del Concepto',1,0,'L');
				$pdf->Cell(15,5,'Cantidad',1,0,'R');
				$pdf->Cell(21,5,'Asignacion',1,0,'R');
				$pdf->Cell(20,5,'Deduccion',1,1,'R');
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
			$pdf->SetFont($tipo_letra,'',9);
			$pdf->Cell(156,5,'TOTAL : ',0,0,'R');
			$pdf->SetFont($tipo_letra,'B',9);
			$pdf->Cell(22,5,$sub_total_monto_asignacion,'T',0,'R');
			$pdf->Cell(22,5,$sub_total_monto_deduccion,'T',1,'R');
			$pdf->Ln(5);
			$pdf->SetFont($tipo_letra,'',10);
			$pdf->Cell(20,2,'',0,0,'R');
			$pdf->Cell(100,2,'_____________________________',0,0,'C');
			$pdf->Cell(58,2,'',0,0,'R');
			$pdf->Cell(22,2,'============',0,1,'R');			
			$pdf->Cell(20,5,'',0,0,'R');
			$pdf->Cell(100,5,'RECIBE CONFORME',0,0,'C');
			$pdf->Cell(58,5,'NETO A COBRAR Bs. ==>  ',0,0,'R');
			$pdf->SetFont($tipo_letra,'B',10);
			$pdf->Cell(22,5,$sub_total_monto,0,1,'R');				
			$pdf->SetFont($tipo_letra,'',10);
		}	
		$pdf->Output();  
?>

