<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist=$_GET["act_hist"]; $fecha_nom=$_GET["fecha_nom"];  $tipo_concepto=$_GET["tipo_concepto"]; $num_periodos=$_GET["num_periodos"];
   $forma_pago=$_GET["forma_pago"]; $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"];
   $rango_f=$_GET["rango_f"]; $fecha_desde=$_GET["fecha_desde"];  $fecha_hasta=$_GET["fecha_hasta"];  $cfechad=formato_aaaammdd($fecha_desde); $cfechah=formato_aaaammdd($fecha_hasta);
   $cfechan=formato_aaaammdd($fecha_nom);  $criterio3="FECHA AL ".$fecha_nom;
   $Sql="";$date = date("d-m-Y"); $hora = date("h:i:s a"); $cfechan=formato_aaaammdd($fecha_nom);  $criterio2=""; $tipo_rpt=$_GET["tipo_rpt"]; $php_os=PHP_OS;
   
   $criterio="rpt_nom_cal WHERE (oculto='NO') ";
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (oculto='NO') ";} 
   if($rango_f=='S'){ $act_hist='S';  $mes_comp='S'; $criterio="rpt_nom_hist WHERE (fecha_p_hasta>='".$cfechad."') and (fecha_p_hasta<='".$cfechah."') and (oculto='NO')  ";   
                      $criterio3="FECHA: ".$fecha_desde." AL ".$fecha_hasta;	}
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}
   
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and ((concepto_vac='N') or (cod_concepto='VVV'))";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and ((concepto_vac='S') and (cod_concepto<>'VVV')) ";}
   
   $cri_tp=" and (tp_calculo='".$tipo_calculo."') ";  
   if($tipo_calculo=="E") { $cri_tp=" and ((tp_calculo='E')and(num_periodos=$num_periodos))  "; } 
   $criterio=$criterio.$cri_tp." and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."')  ";
   
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
      $Sql = "SELECT count(distinct cod_empleado) as cant_trab  FROM ".$criterio."  and (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (monto>0)";
	  $Sql = "SELECT count(distinct cod_empleado) as cant_trab  FROM ".$criterio."  and (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."')";
      $res=pg_query($Sql); $filas=pg_num_rows($res); if($filas>0){ $registro=pg_fetch_array($res,0); $criterio2=$registro["cant_trab"];  }
	
	  $sSQL = "SELECT *  FROM ".$criterio." and (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') ORDER BY tipo_nomina, cod_empleado, cod_concepto";
    if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_resu_rela_nomi_rn_re.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();
	}
	
	if(($tipo_rpt=="PDF")){$res=pg_query($sSQL); $filas=pg_num_rows($res); $prev_tipo_nomina="";  $prev_des_nomina="";  $tipo_nomina=""; $des_nomina="";  
      if($filas>=1){ $registro=pg_fetch_array($res,0); $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);}
        $prev_tipo=$tipo_nomina; $prev_des_nomina=$des_nomina; 
	  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tipo_nomina; global $criterio2;  global $des_nomina; global $fechad; global $fechah; global $rango_f; global $criterio3;  
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(160,7,"RESUMEN RELACION DE NOMINA",1,0,'C');
			$this->Ln(18);
			$this->SetFont('Arial','B',8);
			$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');
			if($rango_f=='S'){$this->Cell(140,5,$criterio3,0,1,'L');}else{$this->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');}
			$this->Cell(20,5,'Codigo',1,0,'L');
			$this->Cell(85,5,'Nombre Trabajador',1,0,'L');
			$this->Cell(80,5,'Descripcion del Cargo',1,0,'C');
			$this->Cell(15,5,'Cedula',1,0,'C');
			$this->Cell(20,5,'Asignaciones',1,0,'C');
			$this->Cell(20,5,'Deducciones',1,0,'C');
			$this->Cell(20,5,'Neto',1,1,'R');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0; $cant_emp=0; $total_monto=0; $total_monto1=0; $sub_total_monto=0; $sub_total_monto_asignacion=0; $sub_total_monto_deduccion=0; $cant_conc=0;
	  $totala_nom=0; $totald_nom=0; $totaln_nom=0; $cant_nom=0; $prev_tipo_nomina=""; $prev_cod_empleado=""; $prev_nombre=""; $prev_des_cargo="";  $prev_cedula="";  
	  while($registro=pg_fetch_array($res)){  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	       $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; 
           $des_cargo=$registro["des_cargo"]; $cedula=$registro["cedula"]; $monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];  
		   if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina); $nombre=utf8_decode($nombre); $des_cargo=utf8_decode($des_cargo);}   
		   if(($prev_cod_empleado<>$cod_empleado)or ($prev_tipo_nomina<>$tipo_nomina)){
			 if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)or($cant_conc>0)){$sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion); $sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion);  $sub_total_monto=formato_monto($sub_total_monto);
				$pdf->SetFont('Arial','',7);
				$pdf->Cell(20,3,$prev_cod_empleado,0,0,'L');
				$pdf->Cell(85,3,$prev_nombre,0,0,'L');
				$pdf->Cell(80,3,$prev_des_cargo,0,0,'L');
				$pdf->Cell(15,3,$prev_cedula,0,0,'R');
				$pdf->Cell(20,3,$sub_total_monto_asignacion,0,0,'R');
				$pdf->Cell(20,3,$sub_total_monto_deduccion,0,0,'R');
				$pdf->Cell(20,3,$sub_total_monto,0,1,'R');
				$cant_nom=$cant_nom+1;  $cant_conc=0;
			 }	
             if($prev_tipo_nomina<>$tipo_nomina){ 
			   if($cant_nom>0){$neto=$totala_nom-$totald_nom; $neto=formato_monto($neto); $totala_nom=formato_monto($totala_nom); $totald_nom=formato_monto($totald_nom);
			   $pdf->SetFont('Arial','B',8);
			   $pdf->Cell(200,2,'',0,0);
			   $pdf->Cell(20,2,'-----------------',0,0,'R');
			   $pdf->Cell(20,2,'-----------------',0,0,'R');
			   $pdf->Cell(20,2,'-----------------',0,1,'R');
			   $pdf->Cell(100,5,'No. Trabajadores: '.$cant_nom,0,0,'L');
			   $pdf->Cell(100,5,'TOTAL NOMINA ',0,0,'R');
			   $pdf->Cell(20,5,$totala_nom,0,0,'R');
			   $pdf->Cell(20,5,$totald_nom,0,0,'R');
			   $pdf->Cell(20,5,$neto,0,1,'R');
			   $pdf->AddPage(); }
			   $totala_nom=0; $totald_nom=0; $totaln_nom=0; $cant_nom=0; $prev_tipo_nomina=$tipo_nomina;
             }			 
			 $prev_cod_empleado=$cod_empleado; $prev_nombre=$nombre; $prev_des_cargo=substr($des_cargo,0,55); $prev_cedula=$cedula; $sub_total_monto_asignacion=0; $sub_total_monto_deduccion=0; $sub_total_monto=0; $cant_emp=$cant_emp+1; } 
           $monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"]; 
		   $sub_total_monto_asignacion=$sub_total_monto_asignacion+$monto_asignacion; $sub_total_monto_deduccion=$sub_total_monto_deduccion+$monto_deduccion;
		   $sub_total_monto=$sub_total_monto_asignacion-$sub_total_monto_deduccion;  $cant_conc=$cant_conc+1;
		   $totala_nom=$totala_nom+$monto_asignacion; $totald_nom=$totald_nom+$monto_deduccion; 
           $total_monto1=$total_monto1+$monto_asignacion;  $total_monto2=$total_monto2+$monto_deduccion; $total_monto=$total_monto+$monto_asignacion-$monto_deduccion;
		   $monto_asignacion=formato_monto($monto_asignacion); $monto_deduccion=formato_monto($monto_deduccion); 

			
		} $total_monto1=formato_monto($total_monto1); $total_monto2=formato_monto($total_monto2); $total_monto=formato_monto($total_monto); 
		 if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){$sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion); $sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion);  $sub_total_monto=formato_monto($sub_total_monto);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(20,3,$prev_cod_empleado,0,0,'L');
			$pdf->Cell(85,3,$prev_nombre,0,0,'L');
			$pdf->Cell(80,3,$prev_des_cargo,0,0,'L');
			$pdf->Cell(15,3,$prev_cedula,0,0,'R');
			$pdf->Cell(20,3,$sub_total_monto_asignacion,0,0,'R');
			$pdf->Cell(20,3,$sub_total_monto_deduccion,0,0,'R');
			$pdf->Cell(20,3,$sub_total_monto,0,1,'R');
			$cant_nom=$cant_nom+1;
		 }	
		$pdf->SetFont('Arial','B',8);
		$neto=$totala_nom-$totald_nom; $neto=formato_monto($neto); $totala_nom=formato_monto($totala_nom); $totald_nom=formato_monto($totald_nom);
		$pdf->Cell(200,2,'',0,0);
	    $pdf->Cell(20,2,'-----------------',0,0,'R');
	    $pdf->Cell(20,2,'-----------------',0,0,'R');
	    $pdf->Cell(20,2,'-----------------',0,1,'R');
	    $pdf->Cell(100,5,'No. Trabajadores: '.$cant_nom,0,0,'L');
	    $pdf->Cell(100,5,'TOTAL NOMINA ',0,0,'R');
	    $pdf->Cell(20,5,$totala_nom,0,0,'R');
	    $pdf->Cell(20,5,$totald_nom,0,0,'R');
	    $pdf->Cell(20,5,$neto,0,1,'R');
		$pdf->Ln(8);	   
		$pdf->Cell(200,2,'',0,0);
		$pdf->Cell(20,2,'=============',0,0,'R');
		$pdf->Cell(20,2,'=============',0,0,'R');
		$pdf->Cell(20,2,'=============',0,1,'R');
		$pdf->Cell(100,5,'No. Trabajadores:'.$cant_emp,0,0,'L');
		$pdf->Cell(100,5,'TOTAL GENERAL ',0,0,'R');
		$pdf->Cell(20,5,$total_monto1,0,0,'R');
		$pdf->Cell(20,5,$total_monto2,0,0,'R');
		$pdf->Cell(20,5,$total_monto,0,1,'R');
		$pdf->Output();  
    }
    if($tipo_rpt=="EXCEL"){$res=pg_query($sSQL); $filas=pg_num_rows($res); $prev_tipo_nomina="";  $prev_des_nomina=""; $tipo_nomina=""; $des_nomina=""; 
      if($filas>=1){ $registro=pg_fetch_array($res,0); $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; 
        $prev_tipo=$tipo_nomina; $prev_des_nomina=$des_nomina; 
	  }
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=RPT_Resumen_Relacion_Nomina.xls"); 	
	  ?><table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RESUMEN RELACION DE NOMINA</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		    <td width="100" align="left" ><strong>Nomina: </strong></td>
		    <td width="400" align="left" ><strong><? echo $tipo_nomina."    ".$des_nomina; ?></strong></td>
		 </tr>
		 <tr height="20">
		    <td width="100" align="left" ><strong>Fecha: </strong></td>
		    <td width="400" align="left" ><strong><? echo $fechad."  "." Al   ".$fechah; ?></strong></td>
		 </tr>
		 <tr height="20">
		   <td width="100" align="left"><strong>Cod. Trabajador</strong></td>
		   <td width="400" align="left"><strong>Nombre</strong></td>
		   <td width="400" align="left"><strong>Descripcion del Cargo</strong></td>
		   <td width="100" align="center"><strong>Cedula</strong></td>
		   <td width="100" align="right"><strong>Asignaciones</strong></td>
		   <td width="100" align="right"><strong>Deducciones</strong></td>
		   <td width="100" align="right"><strong>Neto</strong></td>
		 </tr>
		 
		<?  $i=0;$cant_emp=0; $total_monto=0; $total_monto1=0; $sub_total_monto=0; $sub_total_monto_asignacion=0; $sub_total_monto_deduccion=0; $cant_conc=0;
		$totala_nom=0; $totald_nom=0; $totaln_nom=0; $cant_nom=0; $prev_tipo_nomina=""; $prev_cod_empleado=""; $prev_nombre=""; $prev_des_cargo="";  $prev_cedula="";   $res=pg_query($sSQL);
		while($registro=pg_fetch_array($res)){ $i=$i+1; 
		   $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	       $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; 
           $des_cargo=$registro["des_cargo"]; $cedula=$registro["cedula"]; $monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"]; 
           if(($prev_cod_empleado<>$cod_empleado)or($prev_tipo_nomina<>$tipo_nomina)){
			    if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)or($cant_conc>0)){$sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion); $sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion);  $sub_total_monto=formato_monto($sub_total_monto);
				?>	 				 
                    <tr>
					  <td width="100" align="left"><? echo $prev_cod_empleado; ?></td>
					  <td width="400" align="left"><? echo $prev_nombre; ?></td>	
					  <td width="400" align="left"><? echo $prev_des_cargo; ?></td>					 
					  <td width="100" align="center"><? echo $prev_cedula; ?></td>
					  <td width="100" align="right"><? echo $sub_total_monto_asignacion; ?></td>
					  <td width="100" align="right"><? echo $sub_total_monto_deduccion; ?></td>
					  <td width="100" align="right"><? echo $sub_total_monto; ?></td>
				    </tr>
                 <? $cant_nom=$cant_nom+1;  $cant_conc=0;
				 }		
                if($prev_tipo_nomina<>$tipo_nomina){ $neto=$totala_nom-$totald_nom; $neto=formato_monto($neto); $totala_nom=formato_monto($totala_nom); $totald_nom=formato_monto($totald_nom);
				if($cant_nom>0){?>
				  <tr>
					<td width="100" align="left"></td>
					<td width="400" align="left"></td>
					<td width="400" align="left"></td>
					<td width="100" align="left"></td>
					<td width="100" align="right">____________</td>
					<td width="100" align="right">____________</td>
					<td width="100" align="right">_____________</td>
			      </tr>	
                  <tr>
					<td width="100" align="left"></td>
					<td width="400" align="left"><? echo "No. Trabajadores: ".$cant_nom; ?></td>
					<td width="400" align="left"></td>
					<td width="100" align="right"><strong>TOTAL NOMINA</strong></td>
					<td width="100" align="right"><strong><? echo $totala_nom; ?></strong></td>
					<td width="100" align="right"><strong><? echo $totald_nom; ?></strong></td>
					<td width="100" align="right"><strong><? echo $neto; ?></strong></td>
				  </tr>	
				  <tr height="20">
				 </tr>
				 <tr height="20">
					<td width="100" align="left" ><strong>Nomina: </strong></td>
					<td width="400" align="left" ><strong><? echo $tipo_nomina."    ".$des_nomina; ?></strong></td>
				 </tr>			  
				 <? } $totala_nom=0; $totald_nom=0; $totaln_nom=0; $cant_nom=0; $prev_tipo_nomina=$tipo_nomina; 
                }				
				 $prev_cod_empleado=$cod_empleado; $prev_nombre=$nombre; $prev_des_cargo=$des_cargo; $prev_cedula=$cedula; $cant_conc=0; $sub_total_monto_asignacion=0; $sub_total_monto_deduccion=0; $sub_total_monto=0; $cant_emp=$cant_emp+1; 
				 
			} 
		   $monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"]; 
		   $sub_total_monto_asignacion=$sub_total_monto_asignacion+$monto_asignacion; $sub_total_monto_deduccion=$sub_total_monto_deduccion+$monto_deduccion;
		   $sub_total_monto=$sub_total_monto_asignacion-$sub_total_monto_deduccion; $cant_conc=$cant_conc+1;
		   $totala_nom=$totala_nom+$monto_asignacion; $totald_nom=$totald_nom+$monto_deduccion; 
           $total_monto1=$total_monto1+$monto_asignacion;  $total_monto2=$total_monto2+$monto_deduccion; $total_monto=$total_monto+$monto_asignacion-$monto_deduccion;
		   $monto_asignacion=formato_monto($monto_asignacion); $monto_deduccion=formato_monto($monto_deduccion); 			
		  } $total_monto1=formato_monto($total_monto1); $total_monto2=formato_monto($total_monto2); $total_monto=formato_monto($total_monto); 
		    $neto=$totala_nom-$totald_nom; $neto=formato_monto($neto); $totala_nom=formato_monto($totala_nom); $totald_nom=formato_monto($totald_nom);
			
			    if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)or($cant_conc>0)){$cant_nom=$cant_nom+1; $sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion); $sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion);  $sub_total_monto=formato_monto($sub_total_monto);
				?>	 				 
                    <tr>
					  <td width="100" align="left"><? echo $prev_cod_empleado; ?></td>
					  <td width="400" align="left"><? echo $prev_nombre; ?></td>	
					  <td width="400" align="left"><? echo $prev_des_cargo; ?></td>					 
					  <td width="100" align="center"><? echo $prev_cedula; ?></td>
					  <td width="100" align="right"><? echo $sub_total_monto_asignacion; ?></td>
					  <td width="100" align="right"><? echo $sub_total_monto_deduccion; ?></td>
					  <td width="100" align="right"><? echo $sub_total_monto; ?></td>
				    </tr>
                 <? }?>
			 <tr height="20"> </tr> 	 
			 <tr>
				<td width="100" align="left"></td>
				<td width="400" align="left"></td>
				<td width="400" align="left"></td>
				<td width="100" align="left"></td>
				<td width="100" align="right">____________</td>
				<td width="100" align="right">____________</td>
				<td width="100" align="right">_____________</td>
			  </tr>	
			  <tr>
				<td width="100" align="left"></td>
				<td width="400" align="left"><? echo "No. Trabajadores: ".$cant_nom; ?></td>
				<td width="400" align="left"></td>
				<td width="100" align="right"><strong>TOTAL NOMINA</strong></td>
				<td width="100" align="right"><strong><? echo $totala_nom; ?></strong></td>
				<td width="100" align="right"><strong><? echo $totald_nom; ?></strong></td>
				<td width="100" align="right"><strong><? echo $neto; ?></strong></td>
			  </tr>	
			<tr height="20"> </tr>  
            <tr>
				<td width="100" align="left"></td>
				<td width="400" align="left"></td>
				<td width="400" align="left"></td>
				<td width="100" align="left"></td>
				<td width="100" align="right">____________</td>
				<td width="100" align="right">____________</td>
				<td width="100" align="right">_____________</td>
			</tr>	
			<tr>
				<td width="100" align="left"></td>
				<td width="400" align="left"><? echo "No. Trabajadores: ".$cant_emp; ?></td>
				<td width="400" align="left"></td>
				<td width="100" align="right"><strong>TOTAL GENERAL</strong></td>
				<td width="100" align="right"><strong><? echo $total_monto1; ?></strong></td>
				<td width="100" align="right"><strong><? echo $total_monto2; ?></strong></td>
				<td width="100" align="right"><strong><? echo $total_monto; ?></strong></td>
			</tr>	
			
		     <?
		  ?></table><?
	} 
}
?>
