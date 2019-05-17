<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$cod_presup_d=$_GET["cod_presupd"];$cod_presup_h=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuented"];$cod_fuente_h=$_GET["cod_fuenteh"];$categoria_d=$_GET["categoria_d"];$categoria_h=$_GET["categoria_h"];$fecha=$_GET["fecha"];$tipo_rep=$_GET["tipo_rep"]; $det_modif=$_GET["det_modif"]; $disp_dif=$_GET["disp_dif"]; }
else{$codigod="";$codigoh="";$fuented="";$fuenteh="";$fecha="";$tipo_rep="HTML"; $det_modif="NO"; }  $equipo=getenv("COMPUTERNAME"); $cod_mov="pre020".$usuario_sia; $fecha_hoy=asigna_fecha_hoy(); $sfecha=formato_aaaammdd($fecha);
$asig_global="N"; $php_os=PHP_OS; $imp_total_g="N";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date=date("d-m-Y"); $hora=date("H:i:s a");
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} }
  $sql="Select * from SIA000 order by campo001";$resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"]; $Rif_Emp=$registro["campo007"]; }
  $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];} 
  $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;
  if($cod_emp=="71"){ $imp_total_g="S"; }
  $criterio1="A LA FECHA : ".$fecha; $criterio2=""; $mes=substr($sfecha,5,2);
  $criterio=" (cod_presup>='$cod_presup_d' and cod_presup<='$cod_presup_h') and (cod_fuente>='$cod_fuente_d' and cod_fuente<='$cod_fuente_h')";
  $per_hasta=$mes-1; $per_hasta=0;
  $sql_Asignacion=""; $sql_Traslados=""; $sql_Trasladon=""; $sql_Adicion=""; $sql_Disminucion=""; 
  $sql_Compromiso=""; $sql_Diferido=""; $sql_Causado=""; $sql_Pagado=""; $sql_Diferido ="";
  If($per_hasta==0){ $sql_Traslados="0 as Traslados,";  $sql_Trasladon="0 as Trasladon,";  $sql_Adicion="0 as Adicion,";
     $sql_Disminucion="0 as Disminucion,"; $sql_Compromiso="0 as Compromiso,"; $sql_Causado="0 as Causado,";
     $sql_Pagado="0 as Pagado,"; $sql_Asignacion="0 as Asignado,"; $sql_Asignacion="Asignado,";  $sql_Diferido="0 as Diferido"; }
   else{for ($i=1; $i <= $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==1){$scampo = "(Traslados".$pos;  $scampo1 = "(Trasladon".$pos;  $scampo2 = "(Adicion".$pos;
           $scampo3 = "(Disminucion".$pos;  $scampo4 = "(Compromiso".$pos;  $scampo5 = "(Causado".$pos;
           $scampo6 = "(Pagado".$pos;  $scampo7 = "(Asignado".$pos; $scampo8 = "(Diferido".$pos; }
       else{$scampo = "+Traslados".$pos;$scampo1 = "+Trasladon".$pos;$scampo2 = "+Adicion".$pos;
           $scampo3 = "+Disminucion".$pos; $scampo4 = "+Compromiso".$pos;$scampo5 = "+Causado".$pos;
           $scampo6 = "+Pagado".$pos; $scampo7 = "+Asignado".$pos; $scampo8 = "+Diferido".$pos;}
      $sql_Traslados=$sql_Traslados.$scampo;  $sql_Trasladon=$sql_Trasladon.$scampo1; $sql_Adicion=$sql_Adicion.$scampo2;
      $sql_Disminucion=$sql_Disminucion.$scampo3;  $sql_Compromiso=$sql_Compromiso.$scampo4;
      $sql_Causado=$sql_Causado.$scampo5; $sql_Pagado=$sql_Pagado.$scampo6;
      $sql_Asignacion=$sql_Asignacion.$scampo7; $sql_Diferido=$sql_Diferido.$scampo8;		   
	} 
    $sql_Traslados=$sql_Traslados.") as Traslados,"; $sql_Trasladon=$sql_Trasladon.") as Trasladon,";
    $sql_Adicion=$sql_Adicion.") as Adicion,"; $sql_Disminucion=$sql_Disminucion.") as Disminucion,";
    $sql_Compromiso=$sql_Compromiso.") as Compromiso,"; $sql_Causado=$sql_Causado.") as Causado,";
    $sql_Pagado=$sql_Pagado.") as Pagado,"; $sql_Asignacion=$sql_Asignacion.") as Asignado,";
    $sql_Asignacion="Asignado,"; $sql_Diferido=$sql_Diferido.") as Diferido";	
   }
   
  if($asig_global=="S"){$sql_Asignacion="Asignado,"; }
  $res=pg_exec($conn,"SELECT ACTUALIZA_pre020('E','$cod_mov','1','$sfecha','$sfecha')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  
  $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'1' as tipo_registro, cod_presup, cod_fuente, denominacion,substr(cod_presup,1,".$c.") as cod_categoria,"."'' as Denomina_cat,substr(cod_presup,".$ini.",".$p.") as cod_partida,'' as Denomina_Par,Status_Dist,Func_Inv,Ord_Cord,Aplicacion,Cod_Unidad_Ejec, ";
  $StrSQL=$StrSQL.$sql_Asignacion." disponible,Disp_Diferida,".$sql_Compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.", "."0 as CompromisoM,0 as CausadoM, 0 as PagadoM, 0 as TrasladosM, 0 as TrasladonM, 0 as AdicionM, 0 as DisminucionM, 0 as DiferidoM ";
  $StrSQL=$StrSQL." FROM pre001 WHERE (length(cod_presup)=".$l_c.") and (substr(cod_presup,1,".$c.")>='$categoria_d' and substr(cod_presup,1,".$c.")<='$categoria_h') and ".$criterio;
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_pre020('C','$cod_mov','1','$Fec_Ini_Ejer','$sfecha')");  $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_pre020('A','$cod_mov','1','$Fec_Ini_Ejer','$sfecha')");  $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_pre020('P','$cod_mov','1','$Fec_Ini_Ejer','$sfecha')");  $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_pre020('D','$cod_mov','1','$Fec_Ini_Ejer','$sfecha')");  $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_pre020('J','$cod_mov','1','$Fec_Ini_Ejer','$sfecha')");  $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_pre020('M','$cod_mov','1','$Fec_Ini_Ejer','$sfecha')");  $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  
	$sSQL = "SELECT pre020.nombre_usuario,pre020.tipo_registro,pre020.cod_presup,pre020.cod_fuente,pre020.denominacion,pre020.cod_partida,
			pre020.asignado,pre020.compromiso,pre020.causado,pre020.pagado,pre020.traslados,pre020.trasladon,pre020.adicion,
			pre020.disminucion,pre020.diferido,pre019.cod_presup_cat,pre019.denominacion_cat,
			(pre020.adicion+pre020.traslados-pre020.trasladon-pre020.disminucion) as modificaciones,
			(pre020.adicion-pre020.disminucion) as adic_dism,
			(pre020.asignado+pre020.adicion+pre020.traslados-pre020.trasladon-pre020.disminucion) as asig_actualizada,
			(pre020.asignado-pre020.compromiso+pre020.traslados+pre020.adicion-pre020.trasladon-pre020.disminucion) as saldo,
			(pre020.asignado-pre020.compromiso+pre020.traslados+pre020.adicion-pre020.trasladon-pre020.disminucion-pre020.diferido) as saldod,
			(pre020.causado-pre020.pagado) as deuda 
			from pre020,pre019 WHERE tipo_registro='1' and nombre_usuario='$cod_mov' and pre020.cod_categoria=pre019.cod_presup_cat order by pre019.cod_presup_Cat,pre020.cod_presup,pre020.cod_fuente";
 
 
 if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php"); $nomb_rpt="Rpt_Disponibilidad_Diaria.xml"; 
        if($det_modif=="SI"){ $nomb_rpt="Rpt_Disponibilidad_Diaria_Detalle.xml";}
		if($disp_dif=="SI"){ $nomb_rpt="Rpt_Disponibilidad_Diaria_Dif.xml";}
        $oRpt = new PHPReportMaker();
        $oRpt->setXML($nomb_rpt);
        $oRpt->setUser("$user");
        $oRpt->setPassword("$password");
        $oRpt->setConnection("$host");
        $oRpt->setDatabaseInterface("postgresql");
		$oRpt->setSQL($sSQL);
        $oRpt->setDatabase("$dbname");
		$oRpt->setParameters(array("criterio1"=>$criterio1));          
        $oRpt->run();
  }
  if(($tipo_rep=="PDF")and($det_modif=="SI")){ $tipo_rep="PDF2"; }
  if(($tipo_rep=="PDF")and($disp_dif=="SI")){ $tipo_rep="PDF3"; }
  if(($tipo_rep=="EXCEL")and($det_modif=="SI")){ $tipo_rep="EXCEL2"; }
  if(($tipo_rep=="EXCEL")and($disp_dif=="SI")){ $tipo_rep="EXCEL3"; }
  
  
  if(($tipo_rep=="PDF")and($Cod_Emp<>"71")){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); 
        $cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"]; $cod_unidad_ejec=$registro["cod_unidad_ejec"]; $nombre_unidad_ejec=$registro["nombre_unidad_ejec"]; $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; $cod_partida=$registro["cod_partida"];  		
		if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion); $nombre_unidad_ejec=utf8_decode($nombre_unidad_ejec);}
	  }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $criterio1; global $cod_presup_cat; global $denominacion_cat;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(130,8,'DISPONIBILIDAD DIARIA',1,1,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(100,4,$criterio1,0,1);
            $this->MultiCell(200,4,$cod_presup_cat." ".$denominacion_cat,0,1);
            $this->SetFont('Arial','B',6);					
			$this->Cell(19,5,'CODIGO',1,0);
			$this->Cell(81,5,'DENOMINACION',1,0);
			$this->Cell(20,5,'ASIGNACION',1,0,'C');
			$this->Cell(20,5,'MODIFICACIONES',1,0,'C');
			$this->Cell(21,5,'ASIG.ACTUALIZADA',1,0,'C');
			$this->Cell(19,5,'COMPROMETIDO',1,0,'C');
			$this->Cell(20,5,'CAUSADO',1,0,'C');
			$this->Cell(20,5,'PAGADO',1,0,'C');
			$this->Cell(20,5,'DISPONIBLE',1,0,'C');
			$this->Cell(20,5,'DEUDA',1,1,'C');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',4);
			$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',6);
	  $i=0;  $totalg=0; $totalf=0; $totalm=0; $totalc=0; $totala=0; $totalp=0; $totald=0; $totale=0;
      $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $prev_clave="";  
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  $clave=$registro["cod_presup_cat"];
		    if($prev_clave<>$clave){ 
			    $pdf->SetFont('Arial','B',6); 
			    if(($sub_totalg>0)or($sub_totalf>0)or($sub_totalc>0)or($sub_totalm>0)or($sub_totala>0)or($sub_totalp>0)or($sub_totald>0)){ 
				   $sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
				   $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
				    $pdf->Cell(100,2,'',0,0);
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,1,'R');
					$pdf->Cell(100,4,"Totales : ",0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalg,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalm,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalf,0,0,'R'); 					
					$pdf->Cell(20,4,$sub_totalc,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totala,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalp,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totald,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totale,0,1,'R'); 
					$cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; 	$cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"];   $cod_partida=$registro["cod_partida"];  
			        if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    
					$pdf->AddPage();					
				}
					
				$prev_clave=$clave;   $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0;
            }
			$cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; 	$cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"];   $cod_partida=$registro["cod_partida"];  
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
			$disponible=$registro["saldo"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["deuda"];	
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $sub_totalg=$sub_totalg+$asignado; $sub_totalf=$sub_totalf+$asig_actualizada;			
			$totald=$totald+$disponible; $totale=$totale+$deuda; $sub_totald=$sub_totald+$disponible; $sub_totale=$sub_totale+$deuda;
			 
		    $totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;
		    $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado; 
		    $modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
		    $disponible=formato_monto($disponible); $asignado=formato_monto($asignado);  $asig_actualizada=formato_monto($asig_actualizada);   $deuda=formato_monto($deuda); 
		   $pdf->SetFont('Arial','',6);
		   $pdf->Cell(19,3,$cod_partida,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=81; 		   
		   $pdf->SetXY($x+$n,$y);
		   $pdf->Cell(20,3,$asignado,0,0,'R'); 
		   $pdf->Cell(20,3,$modificaciones,0,0,'R'); 
		   $pdf->Cell(20,3,$asig_actualizada,0,0,'R'); 	
           $pdf->Cell(20,3,$comprometido,0,0,'R'); 
           $pdf->Cell(20,3,$causado,0,0,'R'); 
           $pdf->Cell(20,3,$pagado,0,0,'R'); 			   
		   $pdf->Cell(20,3,$disponible,0,0,'R');
		   $pdf->Cell(20,3,$deuda,0,1,'R');
           $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$denominacion,0);
			
		}$sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
	    $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		$pdf->SetFont('Arial','B',6); 
		$pdf->Cell(100,2,'',0,0);
		$pdf->Cell(20,2,'---------------------',0,0,'R');
		$pdf->Cell(20,2,'---------------------',0,0,'R');
		$pdf->Cell(20,2,'---------------------',0,0,'R');
		$pdf->Cell(20,2,'---------------------',0,0,'R');
		$pdf->Cell(20,2,'---------------------',0,0,'R');
		$pdf->Cell(20,2,'---------------------',0,0,'R');
		$pdf->Cell(20,2,'---------------------',0,0,'R');
		$pdf->Cell(20,2,'---------------------',0,1,'R');
		$pdf->Cell(100,4,"Totales : ",0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalg,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalm,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalf,0,0,'R'); 					
		$pdf->Cell(20,4,$sub_totalc,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totala,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalp,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totald,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totale,0,1,'R'); 
		if($imp_total_g=="S"){
		  $totalc=formato_monto($totalc); $totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm);
          $totalg=formato_monto($totalg); $totalf=formato_monto($totalf); $totald=formato_monto($totald);	$totale=formato_monto($totale);	  
		  $pdf->Ln(10);
		  $pdf->Cell(100,2,'',0,0);
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,1,'R');
		  $pdf->Cell(100,5,"Total General : ",0,0,'R'); 
		  $pdf->Cell(20,5,$totalg,0,0,'R');
          $pdf->Cell(20,5,$totalm,0,0,'R');
          $pdf->Cell(20,5,$totalf,0,0,'R');		  
		  $pdf->Cell(20,5,$totalc,0,0,'R'); 
		  $pdf->Cell(20,5,$totala,0,0,'R'); 
		  $pdf->Cell(20,5,$totalp,0,0,'R');
          $pdf->Cell(20,5,$totald,0,0,'R'); 
		  $pdf->Cell(20,5,$totale,0,1,'R');		  
		}
		$pdf->Output();   
    }
	if(($tipo_rep=="PDF")and($Cod_Emp=="71")){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); 
        $cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"]; $cod_unidad_ejec=$registro["cod_unidad_ejec"]; $nombre_unidad_ejec=$registro["nombre_unidad_ejec"]; $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; $cod_partida=$registro["cod_partida"];  		
		if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion); $nombre_unidad_ejec=utf8_decode($nombre_unidad_ejec);}
	  }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $criterio1; global $cod_presup_cat; global $denominacion_cat;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(130,8,'DISPONIBILIDAD '.$criterio1,1,1,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(200,4,$cod_presup_cat." ".$denominacion_cat,0,1);
            $this->SetFont('Arial','B',6);					
			$this->Cell(15,5,'CODIGO',1,0);
			$this->Cell(75,5,'DENOMINACION',1,0);
			$this->Cell(10,5,'FUENTE',1,0);
			$this->Cell(20,5,'ASIGNACION',1,0,'C');
			$this->Cell(20,5,'MODIFICACIONES',1,0,'C');
			$this->Cell(21,5,'ASIG.ACTUALIZADA',1,0,'C');
			$this->Cell(19,5,'COMPROMETIDO',1,0,'C');
			$this->Cell(20,5,'DISPONIBLE',1,0,'C');
			$this->Cell(20,5,'CAUSADO',1,0,'C');
			$this->Cell(20,5,'PAGADO',1,0,'C');
			$this->Cell(20,5,'DEUDA',1,1,'C');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',4);
			$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',6);
	  $i=0;  $totalg=0; $totalf=0; $totalm=0; $totalc=0; $totala=0; $totalp=0; $totald=0; $totale=0;
      $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $prev_clave="";  
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $clave=$registro["cod_presup_cat"]; 
		    if($prev_clave<>$clave){ 
			    $pdf->SetFont('Arial','B',6); 
			    if(($sub_totalg>0)or($sub_totalf>0)or($sub_totalc>0)or($sub_totalm>0)or($sub_totala>0)or($sub_totalp>0)or($sub_totald>0)){ 
				   $sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
				   $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
				    $pdf->Cell(100,2,'',0,0);
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,1,'R');
					$pdf->Cell(100,4,"Totales : ",0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalg,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalm,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalf,0,0,'R'); 					
					$pdf->Cell(20,4,$sub_totalc,0,0,'R');
                    $pdf->Cell(20,4,$sub_totald,0,0,'R'); 					
					$pdf->Cell(20,4,$sub_totala,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalp,0,0,'R'); 					
					$pdf->Cell(20,4,$sub_totale,0,1,'R');
                    $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; 	$cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"];   $cod_partida=$registro["cod_partida"];  
			        if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    					
					$pdf->AddPage();					
				}
					
				$prev_clave=$clave;   $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0;
            }
			$cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; 	$cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"];   $cod_partida=$registro["cod_partida"];  
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    
			$modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
			$disponible=$registro["saldo"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["deuda"];	
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $sub_totalg=$sub_totalg+$asignado; $sub_totalf=$sub_totalf+$asig_actualizada;			
			$totald=$totald+$disponible; $totale=$totale+$deuda; $sub_totald=$sub_totald+$disponible; $sub_totale=$sub_totale+$deuda;
			 
		    $totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;
		    $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado; 
		    $modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
		    $disponible=formato_monto($disponible); $asignado=formato_monto($asignado);  $asig_actualizada=formato_monto($asig_actualizada);   $deuda=formato_monto($deuda); 
		   $pdf->SetFont('Arial','',6);
		   $pdf->Cell(15,3,$cod_partida,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=75; 		   
		   $pdf->SetXY($x+$n,$y);
		   $pdf->Cell(10,3,$cod_fuente,0,0,'C');
		   $pdf->Cell(20,3,$asignado,0,0,'R'); 
		   $pdf->Cell(20,3,$modificaciones,0,0,'R'); 
		   $pdf->Cell(20,3,$asig_actualizada,0,0,'R'); 	
           $pdf->Cell(20,3,$comprometido,0,0,'R'); 
		   $pdf->Cell(20,3,$disponible,0,0,'R');
           $pdf->Cell(20,3,$causado,0,0,'R'); 
           $pdf->Cell(20,3,$pagado,0,0,'R'); 
		   $pdf->Cell(20,3,$deuda,0,1,'R');
           $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$denominacion,0);
			
		}$sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
	    $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		$pdf->SetFont('Arial','B',6); 
		$pdf->Cell(100,2,'',0,0);
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,1,'R');
		$pdf->Cell(100,4,"Totales : ",0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalg,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalm,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalf,0,0,'R'); 					
		$pdf->Cell(20,4,$sub_totalc,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totald,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totala,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalp,0,0,'R'); 		
		$pdf->Cell(20,4,$sub_totale,0,1,'R'); 
		if($imp_total_g=="S"){
		  $totalc=formato_monto($totalc); $totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm);
          $totalg=formato_monto($totalg); $totalf=formato_monto($totalf); $totald=formato_monto($totald);	$totale=formato_monto($totale);	  
		  $pdf->Ln(10);
		  $pdf->Cell(100,2,'',0,0);
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,1,'R');
		  $pdf->Cell(100,5,"Total General : ",0,0,'R'); 
		  $pdf->Cell(20,5,$totalg,0,0,'R');
          $pdf->Cell(20,5,$totalm,0,0,'R');
          $pdf->Cell(20,5,$totalf,0,0,'R');		  
		  $pdf->Cell(20,5,$totalc,0,0,'R');
          $pdf->Cell(20,5,$totald,0,0,'R'); 		  
		  $pdf->Cell(20,5,$totala,0,0,'R'); 
		  $pdf->Cell(20,5,$totalp,0,0,'R');          
		  $pdf->Cell(20,5,$totale,0,1,'R');		  
		}
		$pdf->Output();   
    }
	
	//if(($tipo_rep=="PDF3")and($Cod_Emp=="71")){	
	if(($tipo_rep=="PDF3")){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); 
        $cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"]; $cod_unidad_ejec=$registro["cod_unidad_ejec"]; $nombre_unidad_ejec=$registro["nombre_unidad_ejec"]; $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; $cod_partida=$registro["cod_partida"];  		
		if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion); $nombre_unidad_ejec=utf8_decode($nombre_unidad_ejec);}
	  }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $criterio1; global $cod_presup_cat; global $denominacion_cat;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(130,8,'DISPONIBILIDAD '.$criterio1,1,1,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(200,4,$cod_presup_cat." ".$denominacion_cat,0,1);
            $this->SetFont('Arial','B',6);					
			$this->Cell(15,5,'CODIGO',1,0);
			$this->Cell(75,5,'DENOMINACION',1,0);
			$this->Cell(10,5,'FUENTE',1,0);
			$this->Cell(20,5,'ASIGNACION',1,0,'C');
			$this->Cell(20,5,'MODIFICACIONES',1,0,'C');
			$this->Cell(21,5,'ASIG.ACTUALIZADA',1,0,'C');
			$this->Cell(19,5,'COMPROMETIDO',1,0,'C');
			$this->Cell(20,5,'DIFERIDO',1,0,'C');
			$this->Cell(20,5,'DISPON.DIF.',1,0,'C');
			$this->Cell(20,5,'CAUSADO',1,0,'C');
			$this->Cell(20,5,'PAGADO',1,1,'C');
			
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',4);
			$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',6);
	  $i=0;  $totalg=0; $totalf=0; $totalm=0; $totalc=0; $totala=0; $totalp=0; $totald=0; $totale=0;  $totali=0;
      $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $sub_totali=0; $prev_clave="";  
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $clave=$registro["cod_presup_cat"]; 
		    if($prev_clave<>$clave){ 
			    $pdf->SetFont('Arial','B',6); 
			    if(($sub_totalg>0)or($sub_totalf>0)or($sub_totalc>0)or($sub_totalm>0)or($sub_totala>0)or($sub_totalp>0)or($sub_totald>0)){ 
				   $sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
				   $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); $sub_totali=formato_monto($sub_totali);
				    $pdf->Cell(100,2,'',0,0);
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,1,'R');
					$pdf->Cell(100,4,"Totales : ",0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalg,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalm,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalf,0,0,'R'); 					
					$pdf->Cell(20,4,$sub_totalc,0,0,'R');
					$pdf->Cell(20,4,$sub_totali,0,0,'R'); 
                    $pdf->Cell(20,4,$sub_totald,0,0,'R'); 					
					$pdf->Cell(20,4,$sub_totala,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalp,0,1,'R');
                    $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; 	$cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"];   $cod_partida=$registro["cod_partida"];  
			        if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    		$pdf->AddPage();					
				}
					
				$prev_clave=$clave;   $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $sub_totali=0;
            }
			$cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; 	$cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"];   $cod_partida=$registro["cod_partida"];  
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
			$disponible=$registro["saldod"]; $diferido=$registro["diferido"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["deuda"];	
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $sub_totalg=$sub_totalg+$asignado; $sub_totalf=$sub_totalf+$asig_actualizada;			
			$totald=$totald+$disponible; $totale=$totale+$deuda; $sub_totald=$sub_totald+$disponible; $sub_totale=$sub_totale+$deuda; $totali=$totali+$diferido; $sub_totali=$sub_totali+$diferido;
			 
		    $totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;
		    $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado; 
		    $modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
		    $disponible=formato_monto($disponible); $asignado=formato_monto($asignado);  $asig_actualizada=formato_monto($asig_actualizada);   $deuda=formato_monto($deuda); $diferido=formato_monto($diferido);
		   $pdf->SetFont('Arial','',6);
		   $pdf->Cell(15,3,$cod_partida,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=75; 		   
		   $pdf->SetXY($x+$n,$y);
		   $pdf->Cell(10,3,$cod_fuente,0,0,'C');
		   $pdf->Cell(20,3,$asignado,0,0,'R'); 
		   $pdf->Cell(20,3,$modificaciones,0,0,'R'); 
		   $pdf->Cell(20,3,$asig_actualizada,0,0,'R'); 	
           $pdf->Cell(20,3,$comprometido,0,0,'R'); 
		   $pdf->Cell(20,3,$diferido,0,0,'R');
		   $pdf->Cell(20,3,$disponible,0,0,'R');
           $pdf->Cell(20,3,$causado,0,0,'R'); 
           $pdf->Cell(20,3,$pagado,0,1,'R'); 
           $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$denominacion,0);
			
		}$sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
	    $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); $sub_totali=formato_monto($sub_totali);
		$pdf->SetFont('Arial','B',6); 
		$pdf->Cell(100,2,'',0,0);
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,1,'R');
		$pdf->Cell(100,4,"Totales : ",0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalg,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalm,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalf,0,0,'R'); 					
		$pdf->Cell(20,4,$sub_totalc,0,0,'R');
        $pdf->Cell(20,4,$sub_totali,0,0,'R'); 		
		$pdf->Cell(20,4,$sub_totald,0,0,'R'); 		
		$pdf->Cell(20,4,$sub_totala,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalp,0,1,'R'); 		
		
		if($imp_total_g=="S"){
		  $totalc=formato_monto($totalc); $totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm);
          $totalg=formato_monto($totalg); $totalf=formato_monto($totalf); $totald=formato_monto($totald);	$totale=formato_monto($totale);	  $totali=formato_monto($totali);	
		  $pdf->Ln(10);
		  $pdf->Cell(100,2,'',0,0);
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,1,'R');
		  $pdf->Cell(100,5,"Total General : ",0,0,'R'); 
		  $pdf->Cell(20,5,$totalg,0,0,'R');
          $pdf->Cell(20,5,$totalm,0,0,'R');
          $pdf->Cell(20,5,$totalf,0,0,'R');		  
		  $pdf->Cell(20,5,$totalc,0,0,'R');
		  $pdf->Cell(20,5,$totali,0,0,'R');	
          $pdf->Cell(20,5,$totald,0,0,'R'); 		  
		  $pdf->Cell(20,5,$totala,0,0,'R'); 
		  $pdf->Cell(20,5,$totalp,0,1,'R');          
		  	  
		}
		$pdf->Output();   
    }
	if(($tipo_rep=="PDF2")){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); 
        $cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"]; $cod_unidad_ejec=$registro["cod_unidad_ejec"]; $nombre_unidad_ejec=$registro["nombre_unidad_ejec"]; $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; $cod_partida=$registro["cod_partida"];  		
		if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion); $nombre_unidad_ejec=utf8_decode($nombre_unidad_ejec);}
	  }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $criterio1; global $cod_presup_cat; global $denominacion_cat;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(280,8,'DISPONIBILIDAD '.$criterio1,1,1,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(200,4,$cod_presup_cat." ".$denominacion_cat,0,1);
            $this->SetFont('Arial','B',6);					
			$this->Cell(18,5,'CODIGO',1,0);
			$this->Cell(110,5,'DENOMINACION',1,0);
			$this->Cell(10,5,'FUENTE',1,0);
			$this->Cell(20,5,'ASIGNACION',1,0,'C');
			$this->Cell(19,5,'TRASPASOS(+)',1,0,'C');
			$this->Cell(19,5,'TRASPASOS(-)',1,0,'C');
			$this->Cell(22,5,'ADICION/DISMINUC.',1,0,'C');
			$this->Cell(22,5,'ASIG.ACTUALIZADA',1,0,'C');
			$this->Cell(20,5,'COMPROMETIDO',1,0,'C');
			$this->Cell(20,5,'CAUSADO',1,0,'C');
			$this->Cell(20,5,'PAGADO',1,0,'C');
			$this->Cell(20,5,'DISPONIBLE',1,0,'C');
			$this->Cell(20,5,'DEUDA',1,1,'C');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',4);
			$this->Cell(170,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(170,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('L', 'mm', Legal);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $totalg=0; $totalf=0; $totalm=0; $totalc=0; $totala=0; $totalp=0; $totald=0; $totale=0; $totalts=0; $totaltn=0; $totalad=0;
      $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $sub_totalts=0; $sub_totaltn=0; $sub_totalad=0; $prev_clave="";  
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  $clave=$registro["cod_presup_cat"];
		    if($prev_clave<>$clave){ 
			    $pdf->SetFont('Arial','B',6); 
			    if(($sub_totalg>0)or($sub_totalf>0)or($sub_totalc>0)or($sub_totalm>0)or($sub_totala>0)or($sub_totalp>0)or($sub_totald>0)){ 
				   $sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
				   $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
				   $sub_totalts=formato_monto($sub_totalts); $sub_totaltn=formato_monto($sub_totaltn); $sub_totalad=formato_monto($sub_totalad); 
					$pdf->Cell(138,2,'',0,0);
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(19,2,'-----------------------',0,0,'R');
					$pdf->Cell(19,2,'-----------------------',0,0,'R');
					$pdf->Cell(22,2,'-----------------------',0,0,'R');
					$pdf->Cell(22,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,0,'R');
					$pdf->Cell(20,2,'-----------------------',0,1,'R');
					$pdf->Cell(138,4,"Totales : ",0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalg,0,0,'R'); 
					$pdf->Cell(19,4,$sub_totalts,0,0,'R'); 
					$pdf->Cell(19,4,$sub_totaltn,0,0,'R'); 
					$pdf->Cell(22,4,$sub_totalad,0,0,'R'); 
					$pdf->Cell(22,4,$sub_totalf,0,0,'R'); 					
					$pdf->Cell(20,4,$sub_totalc,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totala,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalp,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totald,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totale,0,1,'R'); 
					$cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; 	$cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"];   $cod_partida=$registro["cod_partida"];  
			        if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		            $pdf->AddPage();					
				}
				$prev_clave=$clave;   $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $sub_totalts=0; $sub_totaltn=0; $sub_totalad=0;
            }
			$cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; 	$cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"];   $cod_partida=$registro["cod_partida"];  
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
			$disponible=$registro["saldo"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["deuda"];
			$traslados=$registro["traslados"]; $trasladon=$registro["trasladon"]; $adicion=$registro["adicion"];  $disminucion=$registro["disminucion"]; $adic_dism=$registro["adic_dism"];
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $sub_totalg=$sub_totalg+$asignado; $sub_totalf=$sub_totalf+$asig_actualizada;			
			$totald=$totald+$disponible; $totale=$totale+$deuda; $sub_totald=$sub_totald+$disponible; $sub_totale=$sub_totale+$deuda;			 
			$sub_totalts=$sub_totalts+$traslados; $sub_totaltn=$sub_totaltn+$trasladon; $sub_totalad=$sub_totalad+$adic_dism; $totalts=$totalts+$traslados; $totaltn=$totaltn+$trasladon; $totalad=$totalad+$adic_dism;
			$totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;
		    $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado; 
		    $modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
		    $disponible=formato_monto($disponible); $asignado=formato_monto($asignado);  $asig_actualizada=formato_monto($asig_actualizada);   $deuda=formato_monto($deuda); 
		    $traslados=formato_monto($traslados); $trasladon=formato_monto($trasladon); $adic_dism=formato_monto($adic_dism);
		   $pdf->SetFont('Arial','',6);
		   $pdf->Cell(18,3,$cod_partida,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=110; 		   
		   $pdf->SetXY($x+$n,$y);
		   $pdf->Cell(10,3,$cod_fuente,0,0,'C');
		   $pdf->Cell(20,3,$asignado,0,0,'R'); 
		   $pdf->Cell(19,3,$traslados,0,0,'R'); 
		   $pdf->Cell(19,3,$trasladon,0,0,'R'); 
		   $pdf->Cell(22,3,$adic_dism,0,0,'R'); 
		   $pdf->Cell(22,3,$asig_actualizada,0,0,'R'); 	
           $pdf->Cell(20,3,$comprometido,0,0,'R'); 
           $pdf->Cell(20,3,$causado,0,0,'R'); 
           $pdf->Cell(20,3,$pagado,0,0,'R'); 			   
		   $pdf->Cell(20,3,$disponible,0,0,'R');
		   $pdf->Cell(20,3,$deuda,0,1,'R');
           $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$denominacion,0);
			
		}$sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
	    $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		$sub_totalts=formato_monto($sub_totalts); $sub_totaltn=formato_monto($sub_totaltn); $sub_totalad=formato_monto($sub_totalad); 
		$pdf->SetFont('Arial','B',6); 
		$pdf->Cell(138,2,'',0,0);
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(19,2,'-----------------------',0,0,'R');
		$pdf->Cell(19,2,'-----------------------',0,0,'R');
		$pdf->Cell(22,2,'-----------------------',0,0,'R');
		$pdf->Cell(22,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,0,'R');
		$pdf->Cell(20,2,'-----------------------',0,1,'R');
		$pdf->Cell(138,4,"Totales : ",0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalg,0,0,'R'); 
		$pdf->Cell(19,4,$sub_totalts,0,0,'R'); 
		$pdf->Cell(19,4,$sub_totaltn,0,0,'R'); 
		$pdf->Cell(22,4,$sub_totalad,0,0,'R'); 
		$pdf->Cell(22,4,$sub_totalf,0,0,'R'); 					
		$pdf->Cell(20,4,$sub_totalc,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totala,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalp,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totald,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totale,0,1,'R'); 
		if($imp_total_g=="S"){
		  $totalc=formato_monto($totalc); $totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm);
          $totalg=formato_monto($totalg); $totalf=formato_monto($totalf); $totald=formato_monto($totald);	$totale=formato_monto($totale);	
          $totalts=formato_monto($totalts); $totaltn=formato_monto($totaltn); $totalad=formato_monto($totalad); 		  
		  $pdf->Ln(10);
		  $pdf->Cell(138,2,'',0,0);
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(19,2,'=============',0,0,'R');
		  $pdf->Cell(19,2,'=============',0,0,'R');
		  $pdf->Cell(22,2,'=============',0,0,'R');
		  $pdf->Cell(22,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,0,'R');
		  $pdf->Cell(20,2,'=============',0,1,'R');
		  $pdf->Cell(138,5,"Total General : ",0,0,'R'); 
		  $pdf->Cell(20,5,$totalg,0,0,'R');
          $pdf->Cell(19,5,$totalts,0,0,'R');
		  $pdf->Cell(19,5,$totaltn,0,0,'R');
		  $pdf->Cell(22,5,$totalad,0,0,'R');
          $pdf->Cell(22,5,$totalf,0,0,'R');		  
		  $pdf->Cell(20,5,$totalc,0,0,'R'); 
		  $pdf->Cell(20,5,$totala,0,0,'R'); 
		  $pdf->Cell(20,5,$totalp,0,0,'R');
          $pdf->Cell(20,5,$totald,0,0,'R'); 
		  $pdf->Cell(20,5,$totale,0,1,'R');		  
		}
		$pdf->Output();   
    }
	if($tipo_rep=="EXCEL"){	
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Disponibilidad_Diaria.xls");
		?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
			<td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>DISPONIBILIDAD DIARIA</strong></font></td>
		 </tr>
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1; ?></strong></font></td>
		 </tr>
		 <tr height="20">
		   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Codigo</strong></td>
		   <td width="400" align="left" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Asignacion</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Modificaciones</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Asig.Actualizada</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Comprometido</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Causado</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Pagado</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Disponible</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Deuda</strong></td> 		   
		 </tr>
		<?  $i=0;  $totalg=0; $totalf=0; $totalm=0; $totalc=0; $totala=0; $totalp=0; $totald=0; $totale=0; $totalts=0; $totaltn=0; $totalad=0;
		$sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $sub_totalts=0; $sub_totaltn=0; $sub_totalad=0;
		$prev_clave="";  $res=pg_query($sSQL);
		while($registro=pg_fetch_array($res)){ $i=$i+1; 
		    $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; 
			$cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"];   $cod_partida=$registro["cod_partida"];  $clave=$cod_presup_cat;		   
		    $denominacion=conv_cadenas($denominacion,0); $clave=$cod_presup_cat;	
		    if($prev_clave<>$clave){ 
			    if(($sub_totalg>0)or($sub_totalf>0)or($sub_totalc>0)or($sub_totalm>0)or($sub_totala>0)or($sub_totalp>0)or($sub_totald>0)){ 
				   $sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
				   $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
				   $sub_totalts=formato_monto($sub_totalts); $sub_totaltn=formato_monto($sub_totaltn); $sub_totalad=formato_monto($sub_totalad); 
				   ?>	 				 
                    <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
				    </tr>	
					<tr>
				      <td width="100" align="left"></td>
					  <td width="400" align="right"><? echo "Totales : "; ?></td>
					  <td width="120" align="right"><? echo $sub_totalg; ?></td>
					  <td width="120" align="right"><? echo $sub_totalm; ?></td>
					  <td width="120" align="right"><? echo $sub_totalf; ?></td> 
					  <td width="120" align="right"><? echo $sub_totalc; ?></td>
					  <td width="120" align="right"><? echo $sub_totala; ?></td>
					  <td width="120" align="right"><? echo $sub_totalp; ?></td>
					  <td width="120" align="right"><? echo $sub_totald; ?></td>
					  <td width="120" align="right"><? echo $sub_totale; ?></td>
				    </tr>	
					<tr>
				      <td width="90" align="left"></td>
				    </tr>	
                  <? 					
				 }
				 ?>	   
				   <tr>
				     <td width="100" align="left"><strong><? echo $cod_presup_cat; ?></strong></td>					 
				     <td width="400" align="left"><strong><? echo $denominacion_cat; ?></strong></td>
					 <td width="120" align="left"></td>
					 <td width="120" align="left"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
				   </tr>				  
			     <? 					 
			    $prev_clave=$clave;  $prev_clave=$clave;   $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $sub_totalts=0; $sub_totaltn=0; $sub_totalad=0;
			}
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
			$disponible=$registro["saldo"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["deuda"];	
			$traslados=$registro["traslados"]; $trasladon=$registro["trasladon"]; $adicion=$registro["adicion"];  $disminucion=$registro["disminucion"]; $adic_dism=$registro["adic_dism"];
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $sub_totalg=$sub_totalg+$asignado; $sub_totalf=$sub_totalf+$asig_actualizada;			
			$totald=$totald+$disponible; $totale=$totale+$deuda; $sub_totald=$sub_totald+$disponible; $sub_totale=$sub_totale+$deuda;
			$sub_totalts=$sub_totalts+$traslados; $sub_totaltn=$sub_totaltn+$trasladon; $sub_totalad=$sub_totalad+$adic_dism;
			$totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;
		    $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado; 
		    $modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
		    $disponible=formato_monto($disponible); $asignado=formato_monto($asignado);  $asig_actualizada=formato_monto($asig_actualizada);   $deuda=formato_monto($deuda); 
		    $traslados=formato_monto($traslados); $trasladon=formato_monto($trasladon); $adic_dism=formato_monto($adic_dism);
		    ?>	   
			<tr>
			   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $cod_partida; ?></td>
			   <td width="400" align="justify"><? echo $denominacion; ?></td>				   
			   <td width="120" align="right"><? echo $asignado; ?></td>
			   <td width="120" align="right"><? echo $modificaciones; ?></td>
			   <td width="120" align="right"><? echo $asig_actualizada; ?></td>
			   <td width="120" align="right"><? echo $comprometido; ?></td>
			   <td width="120" align="right"><? echo $causado; ?></td>
			   <td width="120" align="right"><? echo $pagado; ?></td>
			   <td width="120" align="right"><? echo $disponible; ?></td>
			   <td width="120" align="right"><? echo $deuda; ?></td>
			 </tr>
		    <? 		  
		  }
		  if(($sub_totalg>0)or($sub_totalf>0)or($sub_totalc>0)or($sub_totalm>0)or($sub_totala>0)or($sub_totalp>0)or($sub_totald>0)){ 
				$sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
				$sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		        $sub_totalts=formato_monto($sub_totalts); $sub_totaltn=formato_monto($sub_totaltn); $sub_totalad=formato_monto($sub_totalad); 					
		  ?>	 				 
			<tr>
			  <td width="100" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			</tr>	
			<tr>
			  <td width="100" align="left"></td>
			  <td width="400" align="right"><? echo "Totales : "; ?></td>
			  <td width="120" align="right"><? echo $sub_totalg; ?></td>
			  <td width="120" align="right"><? echo $sub_totalm; ?></td>
			  <td width="120" align="right"><? echo $sub_totalf; ?></td> 
			  <td width="120" align="right"><? echo $sub_totalc; ?></td>
			  <td width="120" align="right"><? echo $sub_totala; ?></td>
			  <td width="120" align="right"><? echo $sub_totalp; ?></td>
			  <td width="120" align="right"><? echo $sub_totald; ?></td>
			  <td width="120" align="right"><? echo $sub_totale; ?></td>
			</tr>	
			
		  <? 					
		  }		  
		  ?></table><?
	}

   if($tipo_rep=="EXCEL3"){	
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Disponibilidad_Diaria.xls");
		?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
			<td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>DISPONIBILIDAD DIARIA</strong></font></td>
		 </tr>
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1; ?></strong></font></td>
		 </tr>
		 <tr height="20">
		   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Codigo</strong></td>
		   <td width="400" align="left" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Asignacion</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Modificaciones</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Asig.Actualizada</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Comprometido</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Diferido</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Dispon.Diferida</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Causado</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Pagado</strong></td>		   
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Deuda</strong></td> 		   
		 </tr>
		<?  $i=0;  $totalg=0; $totalf=0; $totalm=0; $totalc=0; $totala=0; $totalp=0; $totald=0; $totale=0; $totali=0; $totalts=0; $totaltn=0; $totalad=0;
		$sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $sub_totali=0; $sub_totalts=0; $sub_totaltn=0; $sub_totalad=0;
		$prev_clave="";  $res=pg_query($sSQL);
		while($registro=pg_fetch_array($res)){ $i=$i+1; 
		    $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; 
			$cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"];   $cod_partida=$registro["cod_partida"];  $clave=$cod_presup_cat;		   
		    $denominacion=conv_cadenas($denominacion,0); $clave=$cod_presup_cat;	
		    if($prev_clave<>$clave){ 
			    if(($sub_totalg>0)or($sub_totalf>0)or($sub_totalc>0)or($sub_totalm>0)or($sub_totala>0)or($sub_totalp>0)or($sub_totald>0)){ 
				   $sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
				   $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
				   $sub_totalts=formato_monto($sub_totalts); $sub_totaltn=formato_monto($sub_totaltn); $sub_totalad=formato_monto($sub_totalad); $sub_totali=formato_monto($sub_totali); 
				   ?>	 				 
                    <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
				    </tr>	
					<tr>
				      <td width="100" align="left"></td>
					  <td width="400" align="right"><? echo "Totales : "; ?></td>
					  <td width="120" align="right"><? echo $sub_totalg; ?></td>
					  <td width="120" align="right"><? echo $sub_totalm; ?></td>
					  <td width="120" align="right"><? echo $sub_totalf; ?></td> 
					  <td width="120" align="right"><? echo $sub_totalc; ?></td>
					  <td width="120" align="right"><? echo $sub_totali; ?></td>
					  <td width="120" align="right"><? echo $sub_totald; ?></td>
					  <td width="120" align="right"><? echo $sub_totala; ?></td>
					  <td width="120" align="right"><? echo $sub_totalp; ?></td>					  
					  <td width="120" align="right"><? echo $sub_totale; ?></td>
				    </tr>	
					<tr>
				      <td width="90" align="left"></td>
				    </tr>	
                  <? 					
				 }
				 ?>	   
				   <tr>
				     <td width="100" align="left"><strong><? echo $cod_presup_cat; ?></strong></td>					 
				     <td width="400" align="left"><strong><? echo $denominacion_cat; ?></strong></td>
					 <td width="120" align="left"></td>
					 <td width="120" align="left"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
				   </tr>				  
			     <? 					 
			    $prev_clave=$clave;  $prev_clave=$clave;   $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0;  $sub_totali=0; $sub_totalts=0; $sub_totaltn=0; $sub_totalad=0;
			}
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
			$disponible=$registro["saldod"]; $diferido=$registro["diferido"]; $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["deuda"];	
			$traslados=$registro["traslados"]; $trasladon=$registro["trasladon"]; $adicion=$registro["adicion"];  $disminucion=$registro["disminucion"]; $adic_dism=$registro["adic_dism"];
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $sub_totalg=$sub_totalg+$asignado; $sub_totalf=$sub_totalf+$asig_actualizada;			
			$totald=$totald+$disponible; $totale=$totale+$deuda; $sub_totald=$sub_totald+$disponible; $sub_totale=$sub_totale+$deuda; $sub_totali=$sub_totali+$diferido; $totali=$totali+$diferido; 
			$sub_totalts=$sub_totalts+$traslados; $sub_totaltn=$sub_totaltn+$trasladon; $sub_totalad=$sub_totalad+$adic_dism;
			$totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;
		    $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado; 
		    $modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
		    $disponible=formato_monto($disponible); $asignado=formato_monto($asignado);  $asig_actualizada=formato_monto($asig_actualizada);   $deuda=formato_monto($deuda); 
		    $traslados=formato_monto($traslados); $trasladon=formato_monto($trasladon); $adic_dism=formato_monto($adic_dism); $diferido=formato_monto($diferido);
		    ?>	   
			<tr>
			   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $cod_partida; ?></td>
			   <td width="400" align="justify"><? echo $denominacion; ?></td>				   
			   <td width="120" align="right"><? echo $asignado; ?></td>
			   <td width="120" align="right"><? echo $modificaciones; ?></td>
			   <td width="120" align="right"><? echo $asig_actualizada; ?></td>
			   <td width="120" align="right"><? echo $comprometido; ?></td>
			   <td width="120" align="right"><? echo $diferido; ?></td>
			   <td width="120" align="right"><? echo $disponible; ?></td>
			   <td width="120" align="right"><? echo $causado; ?></td>
			   <td width="120" align="right"><? echo $pagado; ?></td>			   
			   <td width="120" align="right"><? echo $deuda; ?></td>
			 </tr>
		    <? 		  
		  }
		  if(($sub_totalg>0)or($sub_totalf>0)or($sub_totalc>0)or($sub_totalm>0)or($sub_totala>0)or($sub_totalp>0)or($sub_totald>0)){ 
				$sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
				$sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		        $sub_totalts=formato_monto($sub_totalts); $sub_totaltn=formato_monto($sub_totaltn); $sub_totalad=formato_monto($sub_totalad); 	$sub_totali=formato_monto($sub_totali);				
		  ?>	 				 
			<tr>
			  <td width="100" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			</tr>	
			<tr>
			  <td width="100" align="left"></td>
			  <td width="400" align="right"><? echo "Totales : "; ?></td>
			  <td width="120" align="right"><? echo $sub_totalg; ?></td>
			  <td width="120" align="right"><? echo $sub_totalm; ?></td>
			  <td width="120" align="right"><? echo $sub_totalf; ?></td> 
			  <td width="120" align="right"><? echo $sub_totalc; ?></td>
			  <td width="120" align="right"><? echo $sub_totali; ?></td>
			  <td width="120" align="right"><? echo $sub_totald; ?></td>
			  <td width="120" align="right"><? echo $sub_totala; ?></td>
			  <td width="120" align="right"><? echo $sub_totalp; ?></td>			  
			  <td width="120" align="right"><? echo $sub_totale; ?></td>
			</tr>	
			
		  <? 					
		  }		  
		  ?></table><?
	}	

   if($tipo_rep=="EXCEL2"){	
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Disponibilidad_Diaria.xls");
		?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
			<td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>DISPONIBILIDAD DIARIA</strong></font></td>
		 </tr>
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1; ?></strong></font></td>
		 </tr>
		 <tr height="20">
		   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Codigo</strong></td>
		   <td width="400" align="left" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Asignacion</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Traspasos (+)</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Traspasos (-)</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Adicion/Disminucion</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Asig.Actualizada</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Comprometido</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Causado</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Pagado</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Disponible</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Deuda</strong></td> 		   
		 </tr>
		<?  $i=0; $totalg=0; $totalf=0; $totalm=0; $totalc=0; $totala=0; $totalp=0; $totald=0; $totale=0; $totalts=0; $totaltn=0; $totalad=0;
		$sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $sub_totalts=0; $sub_totaltn=0; $sub_totalad=0;
		$prev_clave="";  $res=pg_query($sSQL);
		while($registro=pg_fetch_array($res)){ $i=$i+1; 
		    $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; 
			$cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"];   $cod_partida=$registro["cod_partida"];  $clave=$cod_presup_cat;		   
		    $denominacion=conv_cadenas($denominacion,0); $clave=$cod_presup_cat;	
		    if($prev_clave<>$clave){ 
			    if(($sub_totalg>0)or($sub_totalf>0)or($sub_totalc>0)or($sub_totalm>0)or($sub_totala>0)or($sub_totalp>0)or($sub_totald>0)){ 
				   $sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
				   $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
				   $sub_totalts=formato_monto($sub_totalts); $sub_totaltn=formato_monto($sub_totaltn); $sub_totalad=formato_monto($sub_totalad); 
				   ?>	 				 
                    <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
				    </tr>	
					<tr>
				      <td width="100" align="left"></td>
					  <td width="400" align="right"><? echo "Totales : "; ?></td>
					  <td width="120" align="right"><? echo $sub_totalg; ?></td>
					  <td width="120" align="right"><? echo $sub_totalts; ?></td>
					  <td width="120" align="right"><? echo $sub_totaltn; ?></td>
					  <td width="120" align="right"><? echo $sub_totalad; ?></td>
					  <td width="120" align="right"><? echo $sub_totalf; ?></td> 
					  <td width="120" align="right"><? echo $sub_totalc; ?></td>
					  <td width="120" align="right"><? echo $sub_totala; ?></td>
					  <td width="120" align="right"><? echo $sub_totalp; ?></td>
					  <td width="120" align="right"><? echo $sub_totald; ?></td>
					  <td width="120" align="right"><? echo $sub_totale; ?></td>
				    </tr>	
					<tr>
				      <td width="90" align="left"></td>
				    </tr>	
                  <? 					
				 }
				 ?>	   
				   <tr>
				     <td width="100" align="left"><strong><? echo $cod_presup_cat; ?></strong></td>					 
				     <td width="400" align="left"><strong><? echo $denominacion_cat; ?></strong></td>
					 <td width="120" align="left"></td>
					 <td width="120" align="left"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="left"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
				   </tr>				  
			     <? 					 
			    $prev_clave=$clave;  $prev_clave=$clave;   $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $sub_totalts=0; $sub_totaltn=0; $sub_totalad=0;
			}
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
			$disponible=$registro["saldo"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["deuda"];	
			$traslados=$registro["traslados"]; $trasladon=$registro["trasladon"]; $adicion=$registro["adicion"];  $disminucion=$registro["disminucion"]; $adic_dism=$registro["adic_dism"];
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $sub_totalg=$sub_totalg+$asignado; $sub_totalf=$sub_totalf+$asig_actualizada;			
			$totald=$totald+$disponible; $totale=$totale+$deuda; $sub_totald=$sub_totald+$disponible; $sub_totale=$sub_totale+$deuda;
			$sub_totalts=$sub_totalts+$traslados; $sub_totaltn=$sub_totaltn+$trasladon; $sub_totalad=$sub_totalad+$adic_dism;
			$totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;
		    $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado; 
		    $modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
		    $disponible=formato_monto($disponible); $asignado=formato_monto($asignado);  $asig_actualizada=formato_monto($asig_actualizada);   $deuda=formato_monto($deuda); 
		    $traslados=formato_monto($traslados); $trasladon=formato_monto($trasladon); $adic_dism=formato_monto($adic_dism);
		    ?>	   
			<tr>
			   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $cod_partida; ?></td>
			   <td width="400" align="justify"><? echo $denominacion; ?></td>				   
			   <td width="120" align="right"><? echo $asignado; ?></td>
			   <td width="120" align="right"><? echo $traslados; ?></td>
			   <td width="120" align="right"><? echo $trasladon; ?></td>
			   <td width="120" align="right"><? echo $adic_dism; ?></td>
			   <td width="120" align="right"><? echo $asig_actualizada; ?></td>
			   <td width="120" align="right"><? echo $comprometido; ?></td>
			   <td width="120" align="right"><? echo $causado; ?></td>
			   <td width="120" align="right"><? echo $pagado; ?></td>
			   <td width="120" align="right"><? echo $disponible; ?></td>
			   <td width="120" align="right"><? echo $deuda; ?></td>
			 </tr>
		    <? 		  
		  }
		  if(($sub_totalg>0)or($sub_totalf>0)or($sub_totalc>0)or($sub_totalm>0)or($sub_totala>0)or($sub_totalp>0)or($sub_totald>0)){ 
				$sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
				$sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		        $sub_totalts=formato_monto($sub_totalts); $sub_totaltn=formato_monto($sub_totaltn); $sub_totalad=formato_monto($sub_totalad); 					
		  ?>	 				 
			<tr>
			  <td width="100" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			</tr>	
			<tr>
			  <td width="100" align="left"></td>
			  <td width="400" align="right"><? echo "Totales : "; ?></td>
			  <td width="120" align="right"><? echo $sub_totalg; ?></td>
			  <td width="120" align="right"><? echo $sub_totalts; ?></td>
			  <td width="120" align="right"><? echo $sub_totaltn; ?></td>
			  <td width="120" align="right"><? echo $sub_totalad; ?></td>
			  <td width="120" align="right"><? echo $sub_totalf; ?></td> 
			  <td width="120" align="right"><? echo $sub_totalc; ?></td>
			  <td width="120" align="right"><? echo $sub_totala; ?></td>
			  <td width="120" align="right"><? echo $sub_totalp; ?></td>
			  <td width="120" align="right"><? echo $sub_totald; ?></td>
			  <td width="120" align="right"><? echo $sub_totale; ?></td>
			</tr>	
			
		  <? 					
		  }		  
		  ?></table><?
	}	
    $res=pg_exec($conn,"SELECT ACTUALIZA_pre020('E','$cod_mov','1','$sfecha','$sfecha')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  
?>

