<? error_reporting(E_ALL ^ E_NOTICE); include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc");   
if ($_GET){$cod_presup_d=$_GET["cod_presupd"];$cod_presup_h=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuented"];$cod_fuente_h=$_GET["cod_fuenteh"];$fecha=$_GET["fecha"]; $tipo_rpt=$_GET["tipo_rpt"];}
else{$codigod="";$codigoh="";$fuented="";$fuenteh="";$fecha="";$tipo_rpt="HTML";}  $equipo=getenv("COMPUTERNAME"); $cod_mov="PRE020".$usuario_sia; $fecha_hoy=asigna_fecha_hoy(); $sfecha=formato_aaaammdd($fecha);
$asig_global="N";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} }
  
  $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];} 
  $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;

  $criterio1="A LA FECHA : ".$fecha; $criterio2="USUARIO: ".$usuario_sia; $mes=substr($sfecha,5,2);
  $criterio=" (cod_presup>='$cod_presup_d' and cod_presup<='$cod_presup_h') and (cod_fuente>='$cod_fuente_d' and cod_fuente<='$cod_fuente_h')";
  $criterio=$criterio." and (substring(cod_presup from ".$ini." for 3)='401')";  
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
  $res=pg_exec($conn,"SELECT ACTUALIZA_PRE020('E','$cod_mov','1','$sfecha','$sfecha')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  
  $StrSQL= "INSERT INTO PRE020 SELECT '".$cod_mov."' as Nombre_Usuario,'1' as Tipo_Registro, Cod_Presup, Cod_Fuente, Denominacion,substr(cod_presup,1,".$c.") as cod_categoria,"."'' as Denomina_cat,substr(cod_presup,".$ini.",".$p.") as cod_partida,'' as Denomina_Par,Status_Dist,Func_Inv,Ord_Cord,Aplicacion,Cod_Unidad_Ejec, ";
  $StrSQL=$StrSQL.$sql_Asignacion." Disponible,Disp_Diferida,".$sql_Compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.", "."0 as CompromisoM,0 as CausadoM, 0 as PagadoM, 0 as TrasladosM, 0 as TrasladonM, 0 as AdicionM, 0 as DisminucionM, 0 as DiferidoM ";
  $StrSQL=$StrSQL." FROM PRE001 WHERE length(Cod_Presup)=".$l_c." and ".$criterio;
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE020('C','$cod_mov','1','$Fec_Ini_Ejer','$sfecha')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE020('A','$cod_mov','1','$Fec_Ini_Ejer','$sfecha')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE020('P','$cod_mov','1','$Fec_Ini_Ejer','$sfecha')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE020('D','$cod_mov','1','$Fec_Ini_Ejer','$sfecha')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE020('J','$cod_mov','1','$Fec_Ini_Ejer','$sfecha')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE020('M','$cod_mov','1','$Fec_Ini_Ejer','$sfecha')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  
  		$sSQL = "SELECT PRE020.Nombre_Usuario,PRE020.Tipo_Registro,PRE020.Cod_Presup,PRE020.Cod_Fuente,PRE020.Denominacion,PRE020.cod_partida,
                PRE020.Asignado,PRE020.Compromiso,PRE020.Causado,PRE020.Pagado,PRE020.Traslados,PRE020.Trasladon,PRE020.Adicion,
                PRE020.Disminucion,PRE020.Diferido,PRE019.Cod_Presup_Cat,PRE019.Denominacion_Cat,
                (PRE020.Adicion+PRE020.Traslados-PRE020.Trasladon-PRE020.Disminucion) AS Modificaciones,
                (PRE020.Asignado+PRE020.Adicion+PRE020.Traslados-PRE020.Trasladon-PRE020.Disminucion) AS Asig_Actualizada,
                (PRE020.Asignado-PRE020.Compromiso+PRE020.Traslados+PRE020.Adicion-PRE020.Trasladon-PRE020.Disminucion) AS Saldo,
                (PRE020.Causado-PRE020.Pagado) AS Deuda 
                FROM PRE020, PRE019 WHERE Tipo_Registro='1' and Nombre_Usuario='$cod_mov' and PRE020.cod_categoria=PRE019.Cod_Presup_Cat ORDER BY PRE019.Cod_Presup_Cat,PRE020.Cod_Presup";

    if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
        $oRpt = new PHPReportMaker();
        $oRpt->setXML("Rpt_Disponibilidad_Diaria.xml");
        $oRpt->setUser("$user");
        $oRpt->setPassword("$password");
        $oRpt->setConnection("$host");
        $oRpt->setDatabaseInterface("postgresql");
		$oRpt->setSQL($sSQL);
        $oRpt->setDatabase("$dbname");
		$oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2));          
        $oRpt->run();
    }
	if($tipo_rpt=="PDF"){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $criterio1; global $criterio2; global $registro;
		    $denominacion=$registro["denominacion"]; $cod_part=$registro["cod_part"]; 
			$cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"];   
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(130,8,'DISPONIBILIDAD DIARIA',1,1,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',7);
			$this->Cell(130,5,$criterio1,0,0);
			$this->Cell(130,5,$criterio2,0,1,'R');
            $this->Cell(200,4,$cod_presup_cat." ".$denominacion_cat,0,1);
            $this->SetFont('Arial','B',6);					
			$this->Cell(17,5,'CODIGO',1,0);
			$this->Cell(83,5,'DENOMINACION',1,0);
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
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  
		    $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"]; 
			$cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"];   $cod_partida=$registro["cod_partida"];  $clave=$cod_presup_cat;			
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    if($prev_clave<>$clave){ 
			    $pdf->SetFont('Arial','B',6); 
			    if(($sub_totalg>0)or($sub_totalf>0)or($sub_totalc>0)or($sub_totalm>0)or($sub_totala>0)or($sub_totalp>0)or($sub_totald>0)){ 
				   $sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
				   $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
				    $pdf->Cell(100,2,'',0,0);
					$pdf->Cell(20,2,'-------------------',0,0,'R');
					$pdf->Cell(20,2,'-------------------',0,0,'R');
					$pdf->Cell(20,2,'-------------------',0,0,'R');
					$pdf->Cell(20,2,'-------------------',0,0,'R');
					$pdf->Cell(20,2,'-------------------',0,0,'R');
					$pdf->Cell(20,2,'-------------------',0,0,'R');
					$pdf->Cell(20,2,'-------------------',0,0,'R');
					$pdf->Cell(20,2,'-------------------',0,1,'R');
					$pdf->Cell(100,4,"Totales : ",0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalg,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalm,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalf,0,0,'R'); 					
					$pdf->Cell(20,4,$sub_totalc,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totala,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalp,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totald,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totale,0,1,'R'); 
					$pdf->AddPage();					
				}
					
				$prev_clave=$clave;   $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0;
            }
			$modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
			$disponible=$registro["saldo"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["deuda"];	
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $sub_totalg=$sub_totalg+$asignado; $sub_totalf=$sub_totalf+$asig_actualizada;			
			$totald=$totald+$disponible; $totale=$totale+$deuda; $sub_totald=$sub_totald+$disponible; $sub_totale=$sub_totale+$deuda;
			 
		    $totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;
		    $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado; 
		    $modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
		    $disponible=formato_monto($disponible); $asignado=formato_monto($asignado);  $asig_actualizada=formato_monto($asig_actualizada);   $deuda=formato_monto($deuda); 
		   $pdf->SetFont('Arial','',6);
		   $pdf->Cell(17,3,$cod_partida,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=83; 		   
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
		$pdf->Cell(20,2,'-------------------',0,0,'R');
		$pdf->Cell(20,2,'-------------------',0,0,'R');
		$pdf->Cell(20,2,'-------------------',0,0,'R');
		$pdf->Cell(20,2,'-------------------',0,0,'R');
		$pdf->Cell(20,2,'-------------------',0,0,'R');
		$pdf->Cell(20,2,'-------------------',0,0,'R');
		$pdf->Cell(20,2,'-------------------',0,0,'R');
		$pdf->Cell(20,2,'-------------------',0,1,'R');
		$pdf->Cell(100,4,"Totales : ",0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalg,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalm,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalf,0,0,'R'); 					
		$pdf->Cell(20,4,$sub_totalc,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totala,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalp,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totald,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totale,0,1,'R'); 
		$pdf->Output();   
    }
	$res=pg_exec($conn,"SELECT ACTUALIZA_PRE020('E','$cod_mov','1','$sfecha','$sfecha')");  $error=pg_errormessage($conn);
	
?>

