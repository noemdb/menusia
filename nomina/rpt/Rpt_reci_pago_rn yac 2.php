<? include ("../../class/seguridad.inc"); include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
   $tipo_nomina_d=$_GET["tipo_nomina_d"];   $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist=$_GET["act_hist"]; $fecha_nom=$_GET["fecha_nom"]; $tipo_concepto=$_GET["tipo_concepto"];
   $cod_empleado_d=$_GET["cod_empleado_d"]; $cod_empleado_h=$_GET["cod_empleado_h"];  $codigo_cargo_d=$_GET["codigo_cargo_d"];$codigo_cargo_h=$_GET["codigo_cargo_h"];
   $forma_pago=$_GET["forma_pago"];  $tipo_calculo=$_GET["tipo_calculo"]; $cod_departd=$_GET["cod_departamento_d"];  $cod_departh=$_GET["cod_departamento_h"];
   $tipo_rpt=$_GET["tipo_rpt"];   $php_os=PHP_OS; $cfechan=formato_aaaammdd($fecha_nom); $Sql="";   $date = date("d-m-Y");   $hora = date("H:i:s a");
   
   $criterio="rpt_nom_cal WHERE (oculto='NO') ";
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (oculto='NO') ";} 
   if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}
   
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and (concepto_vac='N') ";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and (concepto_vac='S') ";}
   
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";} $criterio3="";

    $sSQL = "SELECT *  FROM ".$criterio." and (tp_calculo='".$tipo_calculo."') and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."') and
		  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_cargo>='".$codigo_cargo_d."' and cod_cargo<='".$codigo_cargo_h."')  order by tipo_nomina, cod_departam, cod_cargo, cod_empleado, cod_concepto";
    
	/*
	$sSQL = "SELECT *  FROM ".$criterio." and (tp_calculo='".$tipo_calculo."') and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."') and
		  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_cargo>='".$codigo_cargo_d."' and cod_cargo<='".$codigo_cargo_h."')  order by tipo_nomina,cod_empleado, fecha_proceso, cod_concepto";
    */
	
	if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
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
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
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
	      $sueldo_cargo_grupo=$sueldo_cargo; $nombre_banco_grupo=$nombre_banco; 
          $cta_empleado_grupo=$cta_empleado; $fechai=formato_ddmmaaaa($fechai); $fechad=formato_ddmmaaaa($fechad); $fechah=formato_ddmmaaaa($fechah);
          if(($prev_cod_concepto<>$cod_concepto_grupo)or($prev_cod_empleado<>$cod_empleado_grupo)){ 
			 if(($total_cantidad>0)or($resultado1>0)or($resultado2>0)or($resultado3>0)){ 
			    if($total_cantidad==0){$total_cantidad="";}else{$total_cantidad=formato_monto($total_cantidad);} 
				if($resultado1==0){$resultado1="";}else{$resultado1=formato_monto($resultado1); }
				if($resultado2==0){$resultado2="";}else{$resultado2=formato_monto($resultado2); } 
				if($resultado3==0){$resultado3="";}else{$resultado3=formato_monto($resultado3);	}
				$pdf->Cell(20,3,$prev_cod_concepto,0,0,'L');
		        $x=$pdf->GetX();   $y=$pdf->GetY();  $w=100;		   
		   		$pdf->SetXY($x+$w,$y);		   
		   		$pdf->Cell(20,3,$total_cantidad,0,0,'R'); 
		   		$pdf->Cell(20,3,$resultado1,0,0,'R'); 
		   		$pdf->Cell(20,3,$resultado2,0,0,'R'); 
		   		$pdf->Cell(20,3,$resultado3,0,1,'R'); 
		  		$pdf->SetXY($x,$y);	
		   		$pdf->MultiCell($w,3,$prev_denominacion,0); 
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
				$pdf->Cell(20,4,$sub_total_monto_deduccion,0,0,'R');
				$pdf->Cell(20,4,'',0,1,'R');
				$pdf->Ln(5);
				$pdf->Cell(20,2,'',0,0,'R');
				$pdf->Cell(100,2,'_______________________________',0,0,'C');
				$pdf->Cell(40,2,'',0,0,'R');
				$pdf->Cell(20,2,'=============',0,0,'R');
				$pdf->Cell(20,2,'',0,1,'R');
				$pdf->Ln(2);
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
				$pdf->Cell(160,4,'Apellidos y Nombres: '.$nombre_grupo,0,0,'L');  
				$pdf->Cell(40,4,'Cedula : '.$cedula_grupo,0,1,'L');
				$pdf->Cell(160,4,'Cargo: '.$des_cargo_grupo,0,0,'L');  
				$pdf->Cell(40,4,'Fecha Ingreso: '.$fechai_grupo,0,1,'L');
				$pdf->Cell(160,4,'Adscripcion: '.$des_departam_grupo,0,0,'L');  
				$pdf->Cell(40,4,'Categoria: '.$cod_categ_grupo,0,1,'L');
				$pdf->Cell(160,4,'Fecha Desde: '.$fechad_grupo."   "."hasta"."   ".$fechah_grupo,0,0,'L');  
				$pdf->Cell(40,4,'Sueldo Mensual: '.$temp_sueldo,0,1,'L');
				if($tipo_pago=="DEPOSITO"){
				$pdf->Cell(120,4,'Informacion Bancaria: '.$nombre_banco_grupo,0,0,'L');  
				$pdf->Cell(80,4,'Nro. de Cuenta: '.$cta_empleado_grupo,0,1,'L');}
				else{ $pdf->Cell(120,4,'Forma de Pago: '.$tipo_pago,0,1,'L'); }
				
				$pdf->Cell(20,4,'Codigo',1,0,'L');
				$pdf->Cell(100,4,'Descripcion Concepto',1,0,'L');
				$pdf->Cell(20,4,'Cantidad',1,0,'C');
				$pdf->Cell(20,4,'Asignaciones',1,0,'R');
				$pdf->Cell(20,4,'Deducciones',1,0,'R');
				$pdf->Cell(20,4,'Saldo',1,1,'R');	
				$prev_cod_empleado=$cod_empleado_grupo; $prev_nombre=$nombre_grupo; $sub_total_monto_asignacion=0; $sub_total_monto_deduccion=0; $sub_total_monto=0; } 

		  $cod_empleado=$registro["cod_empleado"]; $cod_concepto=$registro["cod_concepto"]; $nombre=$registro["nombre"]; $denominacion=$registro["denominacion"];
		  $cedula=$registro["cedula"];  $des_cargo=$registro["des_cargo"]; $fechai=$registro["fechai"]; $des_departam=$registro["des_departam"]; $monto=$registro["monto"]; 
		  $cod_categ=$registro["cod_categ"]; $fechad=$registro["fechad"]; $fechah=$registro["fechah"]; $sueldo_cargo=$registro["sueldo_cargo"]; $saldo=$registro["saldo"]; 
		  $nombre_banco=$registro["nombre_banco"];  $cta_empleado=$registro["cta_empleado"]; $monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
          $cantidad=$registro["cantidad"]; $sub_total_monto_asignacion=$sub_total_monto_asignacion+$monto_asignacion; 
          $sub_total_monto_deduccion=$sub_total_monto_deduccion+$monto_deduccion;  $sub_total_monto=$sub_total_monto+$monto_asignacion-$monto_deduccion;
          $total_cantidad=$total_cantidad+$cantidad; $total_monto=$total_monto+$monto; 
          $resultado1=$resultado1+$monto_asignacion;$resultado2=$resultado2+$monto_deduccion;
          if($cod_concepto>="580"){$resultado3=$saldo-$total_monto;}else{$resultado3=$resultado3;}
          $monto_asignacion=formato_monto($monto_asignacion); $monto_deduccion=formato_monto($monto_deduccion); $cantidad=formato_monto($cantidad); $saldo=formato_monto($saldo);$monto=formato_monto($monto);
          $total_monto=formato_monto($total_monto);
		} 
		if(($total_cantidad>0)or($resultado1>0)or($resultado2>0)or($resultado3>0)){ 
			if($total_cantidad==0){$total_cantidad="";}else{$total_cantidad=formato_monto($total_cantidad);} 
			if($resultado1==0){$resultado1="";}else{$resultado1=formato_monto($resultado1); }
			if($resultado2==0){$resultado2="";}else{$resultado2=formato_monto($resultado2); } 
			if($resultado3==0){$resultado3="";}else{$resultado3=formato_monto($resultado3);	}
			$pdf->Cell(20,3,$prev_cod_concepto,0,0,'L');
			$x=$pdf->GetX();   $y=$pdf->GetY();  $w=100;		   
			$pdf->SetXY($x+$w,$y);		   
			$pdf->Cell(20,3,$total_cantidad,0,0,'R'); 
			$pdf->Cell(20,3,$resultado1,0,0,'R'); 
			$pdf->Cell(20,3,$resultado2,0,0,'R'); 
			$pdf->Cell(20,3,$resultado3,0,1,'R'); 
			$pdf->SetXY($x,$y);	
			$pdf->MultiCell($w,3,$prev_denominacion,0); 
		}	
		if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){ $sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion);
			$sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto=formato_monto($sub_total_monto);	
			$pdf->Cell(140,2,'',0,0,'R');			    
			$pdf->Cell(20,2,'--------------',0,0,'R');
			$pdf->Cell(20,2,'--------------',0,0,'R');
			$pdf->Cell(20,2,'',0,1,'R');			
			$pdf->Cell(140,4,'Totales : ',0,0,'R');
			$pdf->Cell(20,4,$sub_total_monto_asignacion,0,0,'R');
			$pdf->Cell(20,4,$sub_total_monto_deduccion,0,0,'R');
			$pdf->Cell(20,4,'',0,1,'R');
			$pdf->Ln(5);
			$pdf->Cell(20,2,'',0,0,'R');
			$pdf->Cell(100,2,'_______________________________',0,0,'C');
			$pdf->Cell(40,2,'',0,0,'R');
			$pdf->Cell(20,2,'=============',0,0,'R');
			$pdf->Cell(20,2,'',0,1,'R');
			$pdf->Ln(2);
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
		}	
		$pdf->Output();  
    }	
	
	if($tipo_rpt=="WORD"){  $res=pg_query($sSQL);  $cod_empleado_grupo=""; $cod_concepto_grupo="";  
	   header("Content-type: application/msword");
        header("Content-Disposition: attachment; filename=recibo.rtf");	
      ?>	    
      <table border="0" cellspacing='0' cellpadding='0' align="left">
	  <?
	  $i=0; $total_monto=0; $sub_total_monto_asignacion=0;  $sub_total_monto_deduccion=0; $sub_total_monto=0; $total_cantidad=0; $resultado1=0; $resultado2=0;   $resultado3=0;		 $prev_cod_empleado=""; $prev_cod_concepto=""; $prev_nombre="";   
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_empleado=$registro["cod_empleado"]; $cod_concepto=$registro["cod_concepto"]; $nombre=$registro["nombre"]; 
          $denominacion=$registro["denominacion"];$cedula=$registro["cedula"]; $des_cargo=$registro["des_cargo"]; $fechai=$registro["fechai"]; $des_departam=$registro["des_departam"];  
	      $cod_categ=$registro["cod_categ"]; $fechad=$registro["fechad"]; $fechah=$registro["fechah"]; $sueldo_cargo=$registro["sueldo_cargo"]; $tipo_pago=$registro["tipo_pago"];
	      $nombre_banco=$registro["nombre_banco"];      $cta_empleado=$registro["cta_empleado"]; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
		  $des_nomina=conv_cadenas($des_nomina,0);  $des_cargo=conv_cadenas($des_cargo,0); $nombre=conv_cadenas($nombre,0);
		  $nombre_banco=conv_cadenas($nombre_banco,0);  $des_departam=conv_cadenas($des_departam,0);  $denominacion=conv_cadenas($denominacion,0);
		  
		  
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
				
				?>	
               <tr><td><table width="800" border="0" cellpadding="0" cellspacing="0">				
				   <tr>
					 <td width="100" align="left"><? echo $prev_cod_concepto; ?></td>
					 <td width="300" align="left"><? echo $prev_denominacion; ?></td>
					 <td width="100" align="right"><? echo $total_cantidad; ?></td>
					 <td width="100" align="right"><? echo $resultado1; ?></td>
					 <td width="100" align="right"><? echo $resultado2; ?></td>
					 <td width="100" align="right"><? echo $resultado3; ?></td>
				   </tr>
				   </table></td>
                </tr>
	           <?
				
				
			 }	
			 $prev_cod_concepto=$cod_concepto_grupo; $prev_denominacion=$denominacion_grupo; $total_cantidad=0; $resultado1=0; $resultado2=0; $resultado3=0;}

		   if($prev_cod_empleado<>$cod_empleado_grupo){ 
			 if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){ $sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion);
                $sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto=formato_monto($sub_total_monto);	
				
				?>	 
                <tr><td><table width="800" border="0" cellpadding="0" cellspacing="0">				
				   <tr>
					 <td width="100" align="left"></td>
					 <td width="300" align="left"></td>
					 <td width="100" align="right"></td>
					 <td width="100" align="right">--------------</td>
					 <td width="100" align="right">--------------</td>
					 <td width="100" align="right"></td>
				   </tr>
				   <tr>
					 <td width="100" align="left"></td>
					 <td width="300" align="left"></td>
					 <td width="100" align="right">Totales :</td>
					 <td width="100" align="right"><? echo $sub_total_monto_asignacion; ?></td>
					 <td width="100" align="right"><? echo $sub_total_monto_deduccion; ?></td>
					 <td width="100" align="right"></td>
				   </tr>
				   <tr>
					 <td width="100" align="left"></td>
					 <td width="300" align="left"></td>				 
				   </tr>
				   <tr>
					 <td width="100" align="left"></td>
					 <td width="300" align="center">_______________________________</td>	
					 <td width="100" align="left"></td>	
					 <td width="100" align="left"></td>	
					 <td width="100" align="left">=============</td>	
					 <td width="100" align="left"></td>					 
				   </tr>
				   <tr>
					 <td width="100" align="left"></td>
					 <td width="300" align="center">RECIBE CONFORME</td>	
					 <td width="100" align="left"></td>	
					 <td width="100" align="left"></td>	
					 <td width="100" align="right"><? echo $sub_total_monto; ?></td>	
					 <td width="100" align="right"></td>					 
				   </tr>
				   <tr>
					 <td width="100" align="left"><br></td>		 
				   </tr>
				   </table></td>
                </tr>			   
	           <?
				
				
			   }	$temp_sueldo=formato_monto($sueldo_cargo_grupo);
			   ?>	
			    <tr><td><table width="800" border="0" cellpadding="0" cellspacing="0">
			      <tr>
				    <td width="600" align="left">Apellidos y Nombres: <? echo $nombre_grupo; ?></td>
				    <td width="200" align="left">Cedula : <? echo $cedula_grupo; ?></td>				 
			      </tr> 
				  <tr>
				    <td width="600" align="left">Cargo: <? echo $des_cargo_grupo; ?></td>
				    <td width="200" align="left">Fecha Ingreso : <? echo $fechai_grupo; ?></td>				 
			      </tr> 
				   <tr>
				    <td width="600" align="left">Adscripcion: <? echo $des_departam_grupo; ?></td>
				    <td width="200" align="left">Categoria : <? echo $cod_categ_grupo; ?></td>				 
			      </tr> 
				  </tr> 
				   <tr>
				    <td width="600" align="left">Fecha Desde: <? echo $fechad_grupo; ?> Hasta  <? echo $fechah_grupo; ?></td>
				    <td width="200" align="left">Sueldo Mensual: <? echo $temp_sueldo; ?></td>				 
			      </tr> 
				  </table></td>
                </tr>
				<tr>
					<td width="100" align="left"><br></td>		 
				</tr>
				<tr><td><table width="800" border="1" cellpadding="0" cellspacing="0">
				  <tr>
					 <td width="100" align="left">Codigo</td>
					 <td width="300" align="left">Descripcion Concepto</td>	
					 <td width="100" align="center">Cantidad</td>	
					 <td width="100" align="center">Asignaciones</td>	
					 <td width="100" align="center">Deducciones</td>	
					 <td width="100" align="center">Saldo</td>					 
				   </tr>
				   </table></td>
				</tr>
			   <?
				
				
				
				$prev_cod_empleado=$cod_empleado_grupo; $prev_nombre=$nombre_grupo; $sub_total_monto_asignacion=0; $sub_total_monto_deduccion=0; $sub_total_monto=0; } 

		  $cod_empleado=$registro["cod_empleado"]; $cod_concepto=$registro["cod_concepto"]; $nombre=$registro["nombre"]; $denominacion=$registro["denominacion"];
		  $cedula=$registro["cedula"];  $des_cargo=$registro["des_cargo"]; $fechai=$registro["fechai"]; $des_departam=$registro["des_departam"]; $monto=$registro["monto"]; 
		  $cod_categ=$registro["cod_categ"]; $fechad=$registro["fechad"]; $fechah=$registro["fechah"]; $sueldo_cargo=$registro["sueldo_cargo"]; $saldo=$registro["saldo"]; 
		  $nombre_banco=$registro["nombre_banco"];  $cta_empleado=$registro["cta_empleado"]; $monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
          $cantidad=$registro["cantidad"]; $sub_total_monto_asignacion=$sub_total_monto_asignacion+$monto_asignacion; 
          $sub_total_monto_deduccion=$sub_total_monto_deduccion+$monto_deduccion;  $sub_total_monto=$sub_total_monto+$monto_asignacion-$monto_deduccion;
          $total_cantidad=$total_cantidad+$cantidad; $total_monto=$total_monto+$monto; 
          $resultado1=$resultado1+$monto_asignacion;$resultado2=$resultado2+$monto_deduccion;
          if($cod_concepto>="580"){$resultado3=$saldo-$total_monto;}else{$resultado3=$resultado3;}
          $monto_asignacion=formato_monto($monto_asignacion); $monto_deduccion=formato_monto($monto_deduccion); $cantidad=formato_monto($cantidad); $saldo=formato_monto($saldo);$monto=formato_monto($monto);
          $total_monto=formato_monto($total_monto);
		}?>
	  </table><?
	}
		  
}
?>
