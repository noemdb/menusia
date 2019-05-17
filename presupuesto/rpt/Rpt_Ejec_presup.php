<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);  $php_os=PHP_OS; 
if ($_GET){$cod_presup_d=$_GET["cod_presupd"];$cod_presup_h=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuented"];$cod_fuente_h=$_GET["cod_fuenteh"];$mes_desde=$_GET["mes_desde"];$mes_hasta=$_GET["mes_hasta"];$asig_global=$_GET["asig_global"]; $c_sub=$_GET["csubtotal"]; $cod_esp=$_GET["cod_esp"]; $cod_contab=$_GET["cod_contab"]; $tipo_rep=$_GET["tipo_rep"]; $det_modif=$_GET["det_modif"]; $most_deuda=$_GET["most_deuda"]; $det_modif=$_GET["det_modif"]; } 
else{$codigod="";$codigoh="";$fuented="";$fuenteh="";$fecha=""; $c_sub=1;  $det_modif="NO";  $tipo_rep="HTML";}   $equipo=getenv("COMPUTERNAME"); $cod_mov="pre020".$usuario_sia; 
$mdes_cat=array("NINGUNA","","","","",""); $mcontrol= array(0,0,0,0,0,0,0,0,0,0);
function buscar_control($clave,$formato){  global $mcontrol;  $j=0;
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0]; for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1; for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} }
  return $actual;}
function Rellenarcerosizq($str,$n){$numeroarellenar=$n-strlen($str); $texto=""; for ($i=0; $i < $numeroarellenar; $i++){$texto=$texto."0";} $texto=$texto.$str; return $texto;}
if ($mes_desde=="01"){$mesd="Enero";}elseif ($mes_desde=="02"){$mesd="Febrero";}elseif ($mes_desde=="03"){$mesd="Marzo";}elseif ($mes_desde=="04"){$mesd="Abril";}elseif ($mes_desde=="05"){$mesd="Mayo";}elseif ($mes_desde=="06"){$mesd="Junio";}elseif ($mes_desde=="07"){$mesd="Julio";}elseif ($mes_desde=="08"){$mesd="Agosto";}elseif ($mes_desde=="09"){$mesd="Septiembre";}elseif ($mes_desde=="10"){$mesd="Octubre";}elseif ($mes_desde=="11"){$mesd="Noviembre";}elseif ($mes_desde=="12"){$mesd="Diciembre";}
if ($mes_hasta=="01"){$mesh="Enero";}elseif ($mes_hasta=="02"){$mesh="Febrero";}elseif ($mes_hasta=="03"){$mesh="Marzo";}elseif ($mes_hasta=="04"){$mesh="Abril";}elseif ($mes_hasta=="05"){$mesh="Mayo";}elseif ($mes_hasta=="06"){$mesh="Junio";}elseif ($mes_hasta=="07"){$mesh="Julio";}elseif ($mes_hasta=="08"){$mesh="Agosto";}elseif ($mes_hasta=="09"){$mesh="Septiembre";}elseif ($mes_hasta=="10"){$mesh="Octubre";}elseif ($mes_hasta=="11"){$mesh="Noviembre";}elseif ($mes_hasta=="12"){$mesh="Diciembre";}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} }
   $criterio1="Desde: ".$mesd." Hasta: ".$mesh; $criterio2="";    $mano=substr($Fec_Fin_Ejer,0,4); 
   $criterio1="Desde: ".$mesd." Hasta: ".$mesh." Ejercicio Fiscal: ".$mano;   
   $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
   $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; $mdes_cat[1]=$registro["campo505"]; $mdes_cat[2]=$registro["campo507"]; $mdes_cat[3]=$registro["campo509"]; $mdes_cat[4]=$registro["campo511"]; $mdes_cat[5]=$registro["campo512"];}
   $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presup_d,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0;    
   
   if($c_sub==0){$criterio_s=""; $ls=$c;}else{$criterio_s=""; $ls=$mcontrol[$c_sub-1];}   

   
   $pos=strrpos($cod_presup_d,"?"); if($pos===false){$en_d=0;}else{$en_d=1;} $pos=strrpos($cod_presup_h,"?"); if($pos===false){$en_h=0;}else{$en_h=1;}   
   if(($en_d==1)or($en_h==1)){$codigo_d=str_replace("?","0",$cod_presup_d); $long_d=strlen($codigo_d); $codigo_h=str_replace("?","9",$cod_presup_h); $long_h=strlen($codigo_h);
	  if(($long_d=$long_u)and ($long_h=$long_u)){ $criterio=""; 
         for ($i=0; $i<10; $i++) { $m=$mcontrol[$i]; $a=$mcontrol[$i-1]; 
		     if ($m<>0){if($i==0){ $len_nivel=$m; $criterio=""; }else{ $mpos=1+$a;  $len_nivel=($m-$a-1); $criterio=$criterio." and "; }
				$cod_d=substr($codigo_d,$mpos,$len_nivel); $cod_h=substr($codigo_h,$mpos,$len_nivel);$mpp=$mpos+1;
				$criterio=$criterio."substring(cod_presup,".$mpp.",".$len_nivel.")>='".$cod_d."' and "; $criterio=$criterio."substring(cod_presup,".$mpp.",".$len_nivel.")<='".$cod_h."' ";  }
	     } $criterio=$criterio."and  cod_fuente>='".$cod_fuente_d."' and cod_fuente<='".$cod_fuente_h."'";
	  }else{$criterio="cod_presup>='".$codigo_d."' and cod_presup<='".$codigo_h."' and  cod_fuente>='".$cod_fuente_d."' and cod_fuente<='".$cod_fuente_h."'";}
   }else{$criterio="cod_presup>='".$cod_presup_d."' and cod_presup<='".$cod_presup_h."' and  cod_fuente>='".$cod_fuente_d."' and cod_fuente<='".$cod_fuente_h."'";}  
  if($cod_esp=="SI"){ $criterioc=" and (pre001.cod_contable='$cod_contab') ";} else {$criterioc="";}  
  $per_hasta=$mes_hasta;
  $sql_Asignacion=""; $sql_traslados=""; $sql_trasladon=""; $sql_adicion=""; $sql_disminucion=""; 
  $sql_compromiso=""; $sql_Diferido=""; $sql_causado=""; $sql_Pagado=""; $sql_Diferido ="";  
  If($per_hasta==0){ $sql_traslados="0 as traslados,";  $sql_trasladon="0 as trasladon,";  $sql_adicion="0 as adicion,";
     $sql_disminucion="0 as disminucion,"; $sql_compromiso="0 as compromiso,"; $sql_causado="0 as causado,";
     $sql_Pagado="0 as pagado,"; $sql_Asignacion="0 as asignado,"; $sql_Asignacion="asignado,";  $sql_Diferido="0 as Diferido"; }
   else{for ($i=1; $i <= $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==1){$scampo = "(traslados".$pos;  $scampo1 = "(trasladon".$pos;  $scampo2 = "(adicion".$pos;  $scampo3 = "(disminucion".$pos;  $scampo7 = "(asignado".$pos; }
       else{$scampo = "+traslados".$pos;$scampo1 = "+trasladon".$pos;$scampo2 = "+adicion".$pos;   $scampo3 = "+disminucion".$pos; $scampo7 = "+asignado".$pos; }
      $sql_traslados=$sql_traslados.$scampo;  $sql_trasladon=$sql_trasladon.$scampo1; $sql_adicion=$sql_adicion.$scampo2;
      $sql_disminucion=$sql_disminucion.$scampo3;  $sql_Asignacion=$sql_Asignacion.$scampo7; 		   
	} 
	for ($i=$mes_desde; $i <= $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==$mes_desde){$scampo4 = "(compromiso".$pos;  $scampo5 = "(causado".$pos;
           $scampo6 = "(pagado".$pos; $scampo8 = "(Diferido".$pos; }
       else{$scampo4 = "+compromiso".$pos;$scampo5 = "+causado".$pos;
           $scampo6 = "+pagado".$pos;  $scampo8 = "+Diferido".$pos;}
      $sql_compromiso=$sql_compromiso.$scampo4;$sql_causado=$sql_causado.$scampo5; $sql_Pagado=$sql_Pagado.$scampo6;$sql_Diferido=$sql_Diferido.$scampo8;		   
	} 
    $sql_traslados=$sql_traslados.") as traslados,"; $sql_trasladon=$sql_trasladon.") as trasladon,";
    $sql_adicion=$sql_adicion.") as adicion,"; $sql_disminucion=$sql_disminucion.") as disminucion,";
    $sql_compromiso=$sql_compromiso.") as compromiso,"; $sql_causado=$sql_causado.") as causado,";
    $sql_Pagado=$sql_Pagado.") as pagado,"; $sql_Asignacion=$sql_Asignacion.") as asignado,";
    $sql_Asignacion="asignado,"; $sql_Diferido=$sql_Diferido.") as Diferido";	
   }   
   $StrSQL = "DELETE FROM pre020 Where (tipo_registro='2') And (nombre_usuario='".$cod_mov."')";  $res=pg_exec($conn,$StrSQL); $merror=pg_errormessage($conn); $merror=substr($merror,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $merror; ?>'); </script> <? } 
   if($asig_global=="S"){$sql_Asignacion="asignado,";}
   $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'2' as tipo_registro,Cod_Presup,Cod_Fuente,Denominacion,substr(cod_presup,1,".$long_c.") as cod_categoria,"."'' as Denomina_cat,substr(cod_presup,".$ini.",".$p.") as cod_partida,'' as Denomina_Par,Status_Dist,Func_Inv,Ord_Cord,Aplicacion,Cod_Unidad_Ejec,";
   $StrSQL=$StrSQL.$sql_Asignacion." Disponible,Disp_Diferida,".$sql_compromiso.$sql_causado.$sql_Pagado.$sql_traslados.$sql_trasladon.$sql_adicion.$sql_disminucion.$sql_Diferido.","."0 as compromisoM,0 as causadoM,0 as PagadoM,0 as trasladosM,0 as trasladonM,0 as adicionM,0 as disminucionM,0 as DiferidoM ";
   $StrSQL=$StrSQL." FROM pre001 WHERE length(cod_presup)=".$l_c." and ".$criterio.$criterioc;  $res=pg_exec($conn,$StrSQL); $merror=pg_errormessage($conn); $merror=substr($merror,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $merror; ?>'); </script> <? }

  	$sSQL = "SELECT pre020.cod_presup,pre020.cod_fuente,pre020.denominacion,pre020.cod_categoria,pre020.denomina_cat,pre020.Asignado,pre020.traslados,pre020.trasladon,pre020.adicion,
			 pre020.disminucion,pre020.compromiso,pre020.causado,pre020.pagado,pre020.disponible,(pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS Modificaciones,
			 (pre020.traslados+pre020.adicion) AS aumentos, (pre020.trasladon+pre020.disminucion) AS disminuciones,
			(pre020.Asignado+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS Asig_Actualizada,(pre020.Asignado+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion-pre020.compromiso) AS Disponibilidad
			 FROM pre020 WHERE tipo_registro='2' and nombre_usuario='$cod_mov' and ".$criterio." ORDER BY pre020.cod_presup,pre020.cod_fuente";

    if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
        $oRpt = new PHPReportMaker();
		$oRpt->setXML("Rpt_Ejec_presup.xml");
        $oRpt->setUser("$user");
        $oRpt->setPassword("$password");
        $oRpt->setConnection("$host");
        $oRpt->setDatabaseInterface("postgresql");
		$oRpt->setSQL($sSQL);
        $oRpt->setDatabase("$dbname");
		$oRpt->setParameters(array("criterio1"=>$criterio1,"criterios"=>$criterio_s));          
        $oRpt->run();
    }
	if($tipo_rep=="PDF"){ if ($most_deuda=="SI") { $tipo_rep="PDF2"; } }
	if($tipo_rep=="PDF"){ if ($det_modif=="SI") { $tipo_rep="PDF3"; } }
	
	
	if($tipo_rep=="PDF"){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $criterio1; global $registro; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(130,10,'EJECUCION PRESUPUESTARIA',1,1,'C');
			$this->Ln(8);
			$this->SetFont('Arial','B',8);
			$this->Cell(100,5,$criterio1,0,1);
            $this->SetFont('Arial','B',6);					
			$this->Cell(38,5,'CODIGO',1,0);
			$this->Cell(82,5,'DENOMINACION',1,0);
			$this->Cell(20,5,'ASIGNACION',1,0,'C');
			$this->Cell(20,5,'MODIFICACIONES',1,0,'C');
			$this->Cell(21,5,'ASIG.ACTUALIZADA',1,0,'C');
			$this->Cell(19,5,'COMPROMETIDO',1,0,'C');
			$this->Cell(20,5,'DISPONIBLE',1,0,'C');
			$this->Cell(20,5,'CAUSADO',1,0,'C');
			$this->Cell(20,5,'PAGADO',1,1,'C');	
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',4);
			$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			// INI NMDB 30-04-2018
			// $this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			$this->Cell(130,5,' ',0,0,'R');
			// FIN NMDB 30-04-2018
		}
	  }
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $totalg=0; $totalf=0; $totalm=0; $totalc=0; $totala=0; $totalp=0; $totald=0; $totale=0;
      $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $prev_clave="";  	  
	  $cat_totalg=0; $cat_totalf=0; $cat_totalm=0; $cat_totalc=0; $cat_totala=0; $cat_totalp=0; $cat_totald=0; $cat_totale=0; $prev_cat="";
      $par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par="";	$prev_den="";	  
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  
			$cod_categoria=$registro["cod_categoria"]; $denominacion_cat=$registro["denomina_cat"];  $cod_presup=$registro["cod_presup"];     
		    $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"];  $categoria=substr($cod_presup,0,$ls);		
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
			$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];				
			if(($categoria<>$prev_cat)and($c_sub>0)){ 	
				$pdf->SetFont('Arial','B',7); 
				if(($categoria<>$prev_cat)and($c_sub>0)and($prev_cat<>"")){ 
				    $cat_totalg=formato_monto($cat_totalg);$cat_totalf=formato_monto($cat_totalf);  $cat_totald=formato_monto($cat_totald);  $cat_totale=formato_monto($cat_totale); 
				    $cat_totalc=formato_monto($cat_totalc);$cat_totala=formato_monto($cat_totala);  $cat_totalp=formato_monto($cat_totalp);  $cat_totalm=formato_monto($cat_totalm); 
				    $pdf->Cell(120,1,'',0,0);
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,1,'R');
					$pdf->Cell(120,4,"Sub-Total ".$prev_cat."  ",0,0,'C');  
					$pdf->Cell(20,4,$cat_totalg,0,0,'R'); 
					$pdf->Cell(20,4,$cat_totalm,0,0,'R'); 
					$pdf->Cell(20,4,$cat_totalf,0,0,'R'); 					
					$pdf->Cell(20,4,$cat_totalc,0,0,'R');	
					$pdf->Cell(20,4,$cat_totald,0,0,'R'); 
					$pdf->Cell(20,4,$cat_totala,0,0,'R'); 
					$pdf->Cell(20,4,$cat_totalp,0,1,'R');			
					
					$pdf->Ln(5);
                    $prev_cat=$categoria;	$cat_totalg=0; $cat_totalf=0; $cat_totalm=0; $cat_totalc=0; $cat_totala=0; $cat_totalp=0; $cat_totald=0; $cat_totale=0;				
				}
				if ($prev_cat==""){ $prev_cat=$categoria;}
				$pdf->SetFont('Arial','',7);	
				$prev_clave=$clave;   $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0;            
			}
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $sub_totalg=$sub_totalg+$asignado; $sub_totalf=$sub_totalf+$asig_actualizada;	
			$cat_totalg=$cat_totalg+$asignado; $cat_totalf=$cat_totalf+$asig_actualizada; $par_totalg=$par_totalg+$asignado; $par_totalf=$par_totalf+$asig_actualizada;			
			$totald=$totald+$disponible; $totale=$totale+$deuda; $sub_totald=$sub_totald+$disponible; $sub_totale=$sub_totale+$deuda; 
			$cat_totald=$cat_totald+$disponible; $cat_totale=$cat_totale+$deuda; $par_totald=$par_totald+$disponible; $par_totale=$par_totale+$deuda;
			$totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;  
			$cat_totalm=$cat_totalm+$modificaciones; $cat_totalc=$cat_totalc+$comprometido; $par_totalm=$par_totalm+$modificaciones; $par_totalc=$par_totalc+$comprometido;
		    
			$par_totalo=$par_totalo+$aumentos; $par_totaln=$par_totaln+$disminuciones; $totalo=$totalo+$aumentos; $totaln=$totaln+$disminuciones;
			$sub_totalo=$sub_totalo+$aumentos; $sub_totaln=$sub_totaln+$disminuciones; $cat_totalo=$cat_totalo+$aumentos; $cat_totaln=$cat_totaln+$disminuciones;
			$totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado;  
			$cat_totala=$cat_totala+$causado; $cat_totalp=$cat_totalp+$pagado; $par_totala=$par_totala+$causado; $par_totalp=$par_totalp+$pagado;		
		    $porc_comp=0;if($asig_actualizada<>0){$porc_comp=($comprometido/$asig_actualizada)*100;} $porc_comp=formato_monto($porc_comp);
			$porc_disp=0;if($asig_actualizada<>0){$porc_disp=($disponible/$asig_actualizada)*100;} $porc_disp=formato_monto($porc_disp);
			$porc_caus=0;if($comprometido<>0){$porc_caus=($causado/$comprometido)*100;} $porc_caus=formato_monto($porc_caus);
			$porc_pag=0;if($causado<>0){$porc_pag=($pagado/$causado)*100;} $porc_pag=formato_monto($porc_pag);
			$modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
		    $disponible=formato_monto($disponible); $asignado=formato_monto($asignado);  $asig_actualizada=formato_monto($asig_actualizada);   $deuda=formato_monto($deuda); 
		    $aumentos=formato_monto($aumentos); $disminuciones=formato_monto($disminuciones);
			$pdf->SetFont('Arial','',6.3);
		    $pdf->Cell(38,3,$cod_presup."  ".$cod_fuente,0,0); 		   
			$x=$pdf->GetX();   $y=$pdf->GetY(); $n=82; 		   
			$pdf->SetXY($x+$n,$y);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(20,3,$asignado,0,0,'R'); 
			$pdf->Cell(20,3,$modificaciones,0,0,'R'); 
			$pdf->Cell(20,3,$asig_actualizada,0,0,'R'); 	
			$pdf->Cell(20,3,$comprometido,0,0,'R');	
			$pdf->Cell(20,3,$disponible,0,0,'R');
			$pdf->Cell(20,3,$causado,0,0,'R'); 
			$pdf->Cell(20,3,$pagado,0,1,'R');			
			$pdf->SetFont('Arial','',7);
			$pdf->SetXY($x,$y);
			$pdf->MultiCell($n,3,$denominacion,0);
		}$par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
		$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 		
		$sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
	    $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		$pdf->SetFont('Arial','B',7); 		
		if($c_sub>0){$porc_comp=0;if($cat_totalf<>0){$porc_comp=($cat_totalc/$cat_totalf)*100;} $porc_comp=formato_monto($porc_comp);
            $porc_disp=0;if($cat_totalf<>0){$porc_disp=($cat_totald/$cat_totalf)*100;} $porc_disp=formato_monto($porc_disp);
            $porc_caus=0;if($cat_totalc<>0){$porc_caus=($cat_totala/$cat_totalc)*100;} $porc_caus=formato_monto($porc_caus);
			$cat_totalg=formato_monto($cat_totalg);$cat_totalf=formato_monto($cat_totalf);  $cat_totald=formato_monto($cat_totald);  $cat_totale=formato_monto($cat_totale); 
			$cat_totalc=formato_monto($cat_totalc);$cat_totala=formato_monto($cat_totala);  $cat_totalp=formato_monto($cat_totalp);  $cat_totalm=formato_monto($cat_totalm); 
			$pdf->Cell(120,1,'',0,0);
			$pdf->Cell(20,1,'__________________',0,0,'R');
			$pdf->Cell(20,1,'__________________',0,0,'R');
			$pdf->Cell(20,1,'__________________',0,0,'R');
			$pdf->Cell(20,1,'__________________',0,0,'R');
			$pdf->Cell(20,1,'__________________',0,0,'R');
			$pdf->Cell(20,1,'__________________',0,0,'R');
			$pdf->Cell(20,1,'__________________',0,1,'R');
			$pdf->Cell(120,4,"Sub-Total ".$prev_cat."  ",0,0,'C'); 
			$pdf->Cell(20,4,$cat_totalg,0,0,'R'); 
			$pdf->Cell(20,4,$cat_totalm,0,0,'R'); 
			$pdf->Cell(20,4,$cat_totalf,0,0,'R'); 					
			$pdf->Cell(20,4,$cat_totalc,0,0,'R');	
			$pdf->Cell(20,4,$cat_totald,0,0,'R'); 
			$pdf->Cell(20,4,$cat_totala,0,0,'R'); 
			$pdf->Cell(20,4,$cat_totalp,0,1,'R');
	        $pdf->Ln(5);
		}
		$porc_comp=0;if($totalf<>0){$porc_comp=($totalc/$totalf)*100;} $porc_comp=formato_monto($porc_comp);
		$porc_disp=0;if($totalf<>0){$porc_disp=($totald/$totalf)*100;} $porc_disp=formato_monto($porc_disp);
		$porc_caus=0;if($totalc<>0){$porc_caus=($totala/$totalc)*100;} $porc_caus=formato_monto($porc_caus);
		$porc_pag=0;if($totala<>0){$porc_pag=($totalp/$totala)*100;} $porc_pag=formato_monto($porc_pag);		
		$totalg=formato_monto($totalg);$totalf=formato_monto($totalf);  $totald=formato_monto($totald);  $totale=formato_monto($totale); 
		$totalc=formato_monto($totalc);$totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm); 
		$pdf->Cell(120,2,'',0,0);
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,1,'R');
		$pdf->Cell(120,4,"Total General : ",0,0,'R'); 
		$pdf->Cell(20,4,$totalg,0,0,'R'); 
		$pdf->Cell(20,4,$totalm,0,0,'R'); 
		$pdf->Cell(20,4,$totalf,0,0,'R'); 					
		$pdf->Cell(20,4,$totalc,0,0,'R'); 
		$pdf->Cell(20,4,$totald,0,0,'R'); 	
		$pdf->Cell(20,4,$totala,0,0,'R'); 
		$pdf->Cell(20,4,$totalp,0,1,'R'); 	
	  $pdf->Output();   
    }
	
	
	if($tipo_rep=="PDF3"){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $criterio1; global $registro; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(130,10,'EJECUCION PRESUPUESTARIA',1,1,'C');
			$this->Ln(8);
			$this->SetFont('Arial','B',8);
			$this->Cell(100,5,$criterio1,0,1);
            $this->SetFont('Arial','B',6);					
			$this->Cell(38,5,'CODIGO',1,0);
			$this->Cell(70,5,'DENOMINACION',1,0);
			$this->Cell(20,5,'ASIGNACION',1,0,'C');
			$this->Cell(16,5,'AUMENTOS',1,0,'C');
			//$this->SetFont('Arial','B',5);	
			$this->Cell(16,5,'DISMINUC.',1,0,'C');
			//$this->SetFont('Arial','B',6);	
			$this->Cell(21,5,'ASIG.ACTUALIZADA',1,0,'C');
			$this->Cell(19,5,'COMPROMETIDO',1,0,'C');
			$this->Cell(20,5,'DISPONIBLE',1,0,'C');
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
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $totalg=0; $totalf=0; $totalm=0; $totalo=0; $totaln=0; $totalc=0; $totala=0; $totalp=0; $totald=0; $totale=0;
      $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalo=0; $sub_totaln=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $prev_clave="";  	  
	  $cat_totalg=0; $cat_totalf=0; $cat_totalm=0; $cat_totalo=0; $cat_totaln=0; $cat_totalc=0; $cat_totala=0; $cat_totalp=0; $cat_totald=0; $cat_totale=0; $prev_cat="";
      $par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totalo=0; $par_totaln=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par="";	$prev_den="";	  
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  
			$cod_categoria=$registro["cod_categoria"]; $denominacion_cat=$registro["denomina_cat"];  $cod_presup=$registro["cod_presup"];     
		    $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"];  $categoria=substr($cod_presup,0,$ls);		
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"];  $aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];	
			$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];				
			if(($categoria<>$prev_cat)and($c_sub>0)){ 	
				$pdf->SetFont('Arial','B',7); 
				if(($categoria<>$prev_cat)and($c_sub>0)and($prev_cat<>"")){ 
				    $cat_totalg=formato_monto($cat_totalg);$cat_totalf=formato_monto($cat_totalf);  $cat_totald=formato_monto($cat_totald);  $cat_totale=formato_monto($cat_totale); 
				    $cat_totalc=formato_monto($cat_totalc);$cat_totala=formato_monto($cat_totala);  $cat_totalp=formato_monto($cat_totalp);  $cat_totalm=formato_monto($cat_totalm); 
				    $cat_total0=formato_monto($cat_total0);$cat_totaln=formato_monto($cat_totaln);
					$pdf->Cell(108,1,'',0,0);
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(16,1,'______________',0,0,'R');
					$pdf->Cell(16,1,'______________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,1,'R');
					$pdf->Cell(108,4,"Sub-Total ".$prev_cat."  ",0,0,'C');  
					$pdf->Cell(20,4,$cat_totalg,0,0,'R'); 
					//$pdf->Cell(20,4,$cat_totalm,0,0,'R'); 
					$pdf->Cell(16,4,$cat_totalo,0,0,'R'); 
					$pdf->Cell(16,4,$cat_totaln,0,0,'R'); 
					$pdf->Cell(20,4,$cat_totalf,0,0,'R'); 					
					$pdf->Cell(20,4,$cat_totalc,0,0,'R');	
					$pdf->Cell(20,4,$cat_totald,0,0,'R'); 
					$pdf->Cell(20,4,$cat_totala,0,0,'R'); 
					$pdf->Cell(20,4,$cat_totalp,0,1,'R');			
					
					$pdf->Ln(5);
                    $prev_cat=$categoria;	$cat_totalg=0; $cat_totalf=0; $cat_totalm=0; $cat_totalo=0; $cat_totaln=0; $cat_totalc=0; $cat_totala=0; $cat_totalp=0; $cat_totald=0; $cat_totale=0;				
				}
				if ($prev_cat==""){ $prev_cat=$categoria;}
				$pdf->SetFont('Arial','',7);	
				$prev_clave=$clave;   $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0;            
			}
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $sub_totalg=$sub_totalg+$asignado; $sub_totalf=$sub_totalf+$asig_actualizada;	
			$cat_totalg=$cat_totalg+$asignado; $cat_totalf=$cat_totalf+$asig_actualizada; $par_totalg=$par_totalg+$asignado; $par_totalf=$par_totalf+$asig_actualizada;			
			$totald=$totald+$disponible; $totale=$totale+$deuda; $sub_totald=$sub_totald+$disponible; $sub_totale=$sub_totale+$deuda; 
			$cat_totald=$cat_totald+$disponible; $cat_totale=$cat_totale+$deuda; $par_totald=$par_totald+$disponible; $par_totale=$par_totale+$deuda;
			$totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;  
			$cat_totalm=$cat_totalm+$modificaciones; $cat_totalc=$cat_totalc+$comprometido; $par_totalm=$par_totalm+$modificaciones; $par_totalc=$par_totalc+$comprometido;
		    $par_totalo=$par_totalo+$aumentos; $par_totaln=$par_totaln+$disminuciones; $totalo=$totalo+$aumentos; $totaln=$totaln+$disminuciones;
			$sub_totalo=$sub_totalo+$aumentos; $sub_totaln=$sub_totaln+$disminuciones; $cat_totalo=$cat_totalo+$aumentos; $cat_totaln=$cat_totaln+$disminuciones;
			$totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado;  
			$cat_totala=$cat_totala+$causado; $cat_totalp=$cat_totalp+$pagado; $par_totala=$par_totala+$causado; $par_totalp=$par_totalp+$pagado;		
		    $porc_comp=0;if($asig_actualizada<>0){$porc_comp=($comprometido/$asig_actualizada)*100;} $porc_comp=formato_monto($porc_comp);
			$porc_disp=0;if($asig_actualizada<>0){$porc_disp=($disponible/$asig_actualizada)*100;} $porc_disp=formato_monto($porc_disp);
			$porc_caus=0;if($comprometido<>0){$porc_caus=($causado/$comprometido)*100;} $porc_caus=formato_monto($porc_caus);
			$porc_pag=0;if($causado<>0){$porc_pag=($pagado/$causado)*100;} $porc_pag=formato_monto($porc_pag);
			$modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
		    $disponible=formato_monto($disponible); $asignado=formato_monto($asignado);  $asig_actualizada=formato_monto($asig_actualizada);   $deuda=formato_monto($deuda); 
		    $aumentos=formato_monto($aumentos); $disminuciones=formato_monto($disminuciones);
			$pdf->SetFont('Arial','',6.3);
		    $pdf->Cell(38,3,$cod_presup."  ".$cod_fuente,0,0); 		   
			$x=$pdf->GetX();   $y=$pdf->GetY(); $n=70; 		   
			$pdf->SetXY($x+$n,$y);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(20,3,$asignado,0,0,'R'); 
			$pdf->Cell(16,3,$aumentos,0,0,'R'); 
			$pdf->Cell(16,3,$disminuciones,0,0,'R'); 
			$pdf->Cell(20,3,$asig_actualizada,0,0,'R'); 	
			$pdf->Cell(20,3,$comprometido,0,0,'R');	
			$pdf->Cell(20,3,$disponible,0,0,'R');
			$pdf->Cell(20,3,$causado,0,0,'R'); 
			$pdf->Cell(20,3,$pagado,0,1,'R');			
			$pdf->SetFont('Arial','',7);
			$pdf->SetXY($x,$y);
			$pdf->MultiCell($n,3,$denominacion,0);
		}$par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
		$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 		
		$sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
	    $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		$pdf->SetFont('Arial','B',7); 		
		if($c_sub>0){$porc_comp=0;if($cat_totalf<>0){$porc_comp=($cat_totalc/$cat_totalf)*100;} $porc_comp=formato_monto($porc_comp);
            $porc_disp=0;if($cat_totalf<>0){$porc_disp=($cat_totald/$cat_totalf)*100;} $porc_disp=formato_monto($porc_disp);
            $porc_caus=0;if($cat_totalc<>0){$porc_caus=($cat_totala/$cat_totalc)*100;} $porc_caus=formato_monto($porc_caus);
			$cat_totalg=formato_monto($cat_totalg);$cat_totalf=formato_monto($cat_totalf);  $cat_totald=formato_monto($cat_totald);  $cat_totale=formato_monto($cat_totale); 
			$cat_totalc=formato_monto($cat_totalc);$cat_totala=formato_monto($cat_totala);  $cat_totalp=formato_monto($cat_totalp);  $cat_totalm=formato_monto($cat_totalm); 
			$pdf->Cell(108,1,'',0,0);
			$pdf->Cell(20,1,'__________________',0,0,'R');
			$pdf->Cell(16,1,'______________',0,0,'R');
			$pdf->Cell(16,1,'______________',0,0,'R');
			$pdf->Cell(20,1,'__________________',0,0,'R');
			$pdf->Cell(20,1,'__________________',0,0,'R');
			$pdf->Cell(20,1,'__________________',0,0,'R');
			$pdf->Cell(20,1,'__________________',0,0,'R');
			$pdf->Cell(20,1,'__________________',0,1,'R');
			$pdf->Cell(108,4,"Sub-Total ".$prev_cat."  ",0,0,'C'); 
			$pdf->Cell(20,4,$cat_totalg,0,0,'R'); 
			$pdf->Cell(16,4,$cat_totalo,0,0,'R'); 
			$pdf->Cell(16,4,$cat_totaln,0,0,'R');  
			$pdf->Cell(20,4,$cat_totalf,0,0,'R'); 					
			$pdf->Cell(20,4,$cat_totalc,0,0,'R');	
			$pdf->Cell(20,4,$cat_totald,0,0,'R'); 
			$pdf->Cell(20,4,$cat_totala,0,0,'R'); 
			$pdf->Cell(20,4,$cat_totalp,0,1,'R');
	        $pdf->Ln(5);
		}
		$porc_comp=0;if($totalf<>0){$porc_comp=($totalc/$totalf)*100;} $porc_comp=formato_monto($porc_comp);
		$porc_disp=0;if($totalf<>0){$porc_disp=($totald/$totalf)*100;} $porc_disp=formato_monto($porc_disp);
		$porc_caus=0;if($totalc<>0){$porc_caus=($totala/$totalc)*100;} $porc_caus=formato_monto($porc_caus);
		$porc_pag=0;if($totala<>0){$porc_pag=($totalp/$totala)*100;} $porc_pag=formato_monto($porc_pag);		
		$totalg=formato_monto($totalg);$totalf=formato_monto($totalf);  $totald=formato_monto($totald);  $totale=formato_monto($totale); 
		$totalc=formato_monto($totalc);$totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm);  $totalo=formato_monto($totalo); $totaln=formato_monto($totaln); 
		$pdf->Cell(108,2,'',0,0);
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(16,2,'=============',0,0,'R');
		$pdf->Cell(16,2,'=============',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,1,'R');
		$pdf->Cell(108,4,"Total General : ",0,0,'R'); 
		$pdf->Cell(20,4,$totalg,0,0,'R'); 
		$pdf->Cell(16,4,$totalo,0,0,'R'); 
		$pdf->Cell(16,4,$totaln,0,0,'R'); 
		$pdf->Cell(20,4,$totalf,0,0,'R'); 					
		$pdf->Cell(20,4,$totalc,0,0,'R'); 
		$pdf->Cell(20,4,$totald,0,0,'R'); 	
		$pdf->Cell(20,4,$totala,0,0,'R'); 
		$pdf->Cell(20,4,$totalp,0,1,'R'); 	
	  $pdf->Output();   
    }
	
	
	if($tipo_rep=="PDF2"){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $criterio1; global $registro; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(130,10,'EJECUCION PRESUPUESTARIA',1,1,'C');
			$this->Ln(8);
			$this->SetFont('Arial','B',8);
			$this->Cell(100,5,$criterio1,0,1);
            $this->SetFont('Arial','B',5.5);					
			$this->Cell(38,5,'CODIGO',1,0);
			$this->Cell(78,5,'DENOMINACION',1,0);
			
			$this->Cell(18,5,'ASIGNACION',1,0,'C');
			$this->Cell(18,5,'MODIFICACIONES',1,0,'C');
			$this->Cell(18,5,'ASIG.ACTUALIZ.',1,0,'C');
			$this->Cell(18,5,'COMPROMETIDO',1,0,'C');
			$this->Cell(18,5,'DISPONIBLE',1,0,'C');
			$this->Cell(18,5,'CAUSADO',1,0,'C');
			$this->Cell(18,5,'PAGADO',1,0,'C');	
			$this->Cell(18,5,'DEUDA',1,1,'C');
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
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $totalg=0; $totalf=0; $totalm=0; $totalc=0; $totala=0; $totalp=0; $totald=0; $totale=0;
      $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $prev_clave="";  	  
	  $cat_totalg=0; $cat_totalf=0; $cat_totalm=0; $cat_totalc=0; $cat_totala=0; $cat_totalp=0; $cat_totald=0; $cat_totale=0; $prev_cat="";
      $par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par="";	$prev_den="";	  
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  
			$cod_categoria=$registro["cod_categoria"]; $denominacion_cat=$registro["denomina_cat"];  $cod_presup=$registro["cod_presup"];     
		    $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"];  $categoria=substr($cod_presup,0,$ls);		
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
			$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];				
			if(($categoria<>$prev_cat)and($c_sub>0)){ 	
				$pdf->SetFont('Arial','B',7); 
				if(($categoria<>$prev_cat)and($c_sub>0)and($prev_cat<>"")){ 
				    $cat_totalg=formato_monto($cat_totalg);$cat_totalf=formato_monto($cat_totalf);  $cat_totald=formato_monto($cat_totald);  $cat_totale=formato_monto($cat_totale); 
				    $cat_totalc=formato_monto($cat_totalc);$cat_totala=formato_monto($cat_totala);  $cat_totalp=formato_monto($cat_totalp);  $cat_totalm=formato_monto($cat_totalm); 
				    $pdf->Cell(116,1,'',0,0);
					$pdf->Cell(18,1,'__________________',0,0,'R');
					$pdf->Cell(18,1,'__________________',0,0,'R');
					$pdf->Cell(18,1,'__________________',0,0,'R');
					$pdf->Cell(18,1,'__________________',0,0,'R');
					$pdf->Cell(18,1,'__________________',0,0,'R');
					$pdf->Cell(18,1,'__________________',0,0,'R');
					$pdf->Cell(18,1,'__________________',0,0,'R');
					$pdf->Cell(18,1,'__________________',0,0,'R');
					$pdf->Cell(18,1,'__________________',0,1,'R');
					$pdf->Cell(116,4,"Sub-Total ".$prev_cat."  ",0,0,'C');  
					$pdf->Cell(18,4,$cat_totalg,0,0,'R'); 
					$pdf->Cell(18,4,$cat_totalm,0,0,'R'); 
					$pdf->Cell(18,4,$cat_totalf,0,0,'R'); 					
					$pdf->Cell(18,4,$cat_totalc,0,0,'R');	
					$pdf->Cell(18,4,$cat_totald,0,0,'R'); 
					$pdf->Cell(18,4,$cat_totala,0,0,'R'); 
					$pdf->Cell(18,4,$cat_totalp,0,0,'R');			
					$pdf->Cell(18,4,$cat_totale,0,1,'R');
					$pdf->Ln(5);
                    $prev_cat=$categoria;	$cat_totalg=0; $cat_totalf=0; $cat_totalm=0; $cat_totalc=0; $cat_totala=0; $cat_totalp=0; $cat_totald=0; $cat_totale=0;				
				}
				if ($prev_cat==""){ $prev_cat=$categoria;}
				$pdf->SetFont('Arial','',7);	
				$prev_clave=$clave;   $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0;            
			}
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $sub_totalg=$sub_totalg+$asignado; $sub_totalf=$sub_totalf+$asig_actualizada;	
			$cat_totalg=$cat_totalg+$asignado; $cat_totalf=$cat_totalf+$asig_actualizada; $par_totalg=$par_totalg+$asignado; $par_totalf=$par_totalf+$asig_actualizada;			
			$totald=$totald+$disponible; $totale=$totale+$deuda; $sub_totald=$sub_totald+$disponible; $sub_totale=$sub_totale+$deuda; 
			$cat_totald=$cat_totald+$disponible; $cat_totale=$cat_totale+$deuda; $par_totald=$par_totald+$disponible; $par_totale=$par_totale+$deuda;
			$totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;  
			$cat_totalm=$cat_totalm+$modificaciones; $cat_totalc=$cat_totalc+$comprometido; $par_totalm=$par_totalm+$modificaciones; $par_totalc=$par_totalc+$comprometido;
		    $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado;  
			$cat_totala=$cat_totala+$causado; $cat_totalp=$cat_totalp+$pagado; $par_totala=$par_totala+$causado; $par_totalp=$par_totalp+$pagado;		
		    $porc_comp=0;if($asig_actualizada<>0){$porc_comp=($comprometido/$asig_actualizada)*100;} $porc_comp=formato_monto($porc_comp);
			$porc_disp=0;if($asig_actualizada<>0){$porc_disp=($disponible/$asig_actualizada)*100;} $porc_disp=formato_monto($porc_disp);
			$porc_caus=0;if($comprometido<>0){$porc_caus=($causado/$comprometido)*100;} $porc_caus=formato_monto($porc_caus);
			$porc_pag=0;if($causado<>0){$porc_pag=($pagado/$causado)*100;} $porc_pag=formato_monto($porc_pag);
			$modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
		    $disponible=formato_monto($disponible); $asignado=formato_monto($asignado);  $asig_actualizada=formato_monto($asig_actualizada);   $deuda=formato_monto($deuda); 
		    $pdf->SetFont('Arial','',6.3);
		    $pdf->Cell(38,3,$cod_presup."  ".$cod_fuente,0,0); 		   
			$x=$pdf->GetX();   $y=$pdf->GetY(); $n=78; 		   
			$pdf->SetXY($x+$n,$y);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(18,3,$asignado,0,0,'R'); 
			$pdf->Cell(18,3,$modificaciones,0,0,'R'); 
			$pdf->Cell(18,3,$asig_actualizada,0,0,'R'); 	
			$pdf->Cell(18,3,$comprometido,0,0,'R');	
			$pdf->Cell(18,3,$disponible,0,0,'R');
			$pdf->Cell(18,3,$causado,0,0,'R'); 
			$pdf->Cell(18,3,$pagado,0,0,'R');	
            $pdf->Cell(18,3,$deuda,0,1,'R');				
			$pdf->SetFont('Arial','',7);
			$pdf->SetXY($x,$y);
			$pdf->MultiCell($n,3,$denominacion,0);
		}$par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
		$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 		
		$sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
	    $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		$pdf->SetFont('Arial','B',7); 		
		if($c_sub>0){$porc_comp=0;if($cat_totalf<>0){$porc_comp=($cat_totalc/$cat_totalf)*100;} $porc_comp=formato_monto($porc_comp);
            $porc_disp=0;if($cat_totalf<>0){$porc_disp=($cat_totald/$cat_totalf)*100;} $porc_disp=formato_monto($porc_disp);
            $porc_caus=0;if($cat_totalc<>0){$porc_caus=($cat_totala/$cat_totalc)*100;} $porc_caus=formato_monto($porc_caus);
			$cat_totalg=formato_monto($cat_totalg);$cat_totalf=formato_monto($cat_totalf);  $cat_totald=formato_monto($cat_totald);  $cat_totale=formato_monto($cat_totale); 
			$cat_totalc=formato_monto($cat_totalc);$cat_totala=formato_monto($cat_totala);  $cat_totalp=formato_monto($cat_totalp);  $cat_totalm=formato_monto($cat_totalm); 
			$pdf->Cell(116,1,'',0,0);
			$pdf->Cell(18,1,'__________________',0,0,'R');
			$pdf->Cell(18,1,'__________________',0,0,'R');
			$pdf->Cell(18,1,'__________________',0,0,'R');
			$pdf->Cell(18,1,'__________________',0,0,'R');
			$pdf->Cell(18,1,'__________________',0,0,'R');
			$pdf->Cell(18,1,'__________________',0,0,'R');
			$pdf->Cell(18,1,'__________________',0,0,'R');
			$pdf->Cell(18,1,'__________________',0,1,'R');
			$pdf->Cell(116,4,"Sub-Total ".$prev_cat."  ",0,0,'C'); 
			$pdf->Cell(18,4,$cat_totalg,0,0,'R'); 
			$pdf->Cell(18,4,$cat_totalm,0,0,'R'); 
			$pdf->Cell(18,4,$cat_totalf,0,0,'R'); 					
			$pdf->Cell(18,4,$cat_totalc,0,0,'R');	
			$pdf->Cell(18,4,$cat_totald,0,0,'R'); 
			$pdf->Cell(18,4,$cat_totala,0,0,'R'); 
			$pdf->Cell(18,4,$cat_totalp,0,0,'R');
			$pdf->Cell(18,4,$cat_totale,0,1,'R');
	        $pdf->Ln(5);
		}
		$porc_comp=0;if($totalf<>0){$porc_comp=($totalc/$totalf)*100;} $porc_comp=formato_monto($porc_comp);
		$porc_disp=0;if($totalf<>0){$porc_disp=($totald/$totalf)*100;} $porc_disp=formato_monto($porc_disp);
		$porc_caus=0;if($totalc<>0){$porc_caus=($totala/$totalc)*100;} $porc_caus=formato_monto($porc_caus);
		$porc_pag=0;if($totala<>0){$porc_pag=($totalp/$totala)*100;} $porc_pag=formato_monto($porc_pag);		
		$totalg=formato_monto($totalg);$totalf=formato_monto($totalf);  $totald=formato_monto($totald);  $totale=formato_monto($totale); 
		$totalc=formato_monto($totalc);$totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm); 
		$pdf->Cell(116,2,'',0,0);
		$pdf->Cell(18,2,'================',0,0,'R');
		$pdf->Cell(18,2,'================',0,0,'R');
		$pdf->Cell(18,2,'================',0,0,'R');
		$pdf->Cell(18,2,'================',0,0,'R');
		$pdf->Cell(18,2,'================',0,0,'R');
		$pdf->Cell(18,2,'================',0,0,'R');
		$pdf->Cell(18,2,'================',0,0,'R');
		$pdf->Cell(18,2,'================',0,1,'R');
		$pdf->Cell(116,4,"Total General : ",0,0,'R'); 
		$pdf->Cell(18,4,$totalg,0,0,'R'); 
		$pdf->Cell(18,4,$totalm,0,0,'R'); 
		$pdf->Cell(18,4,$totalf,0,0,'R'); 					
		$pdf->Cell(18,4,$totalc,0,0,'R'); 
		$pdf->Cell(18,4,$totald,0,0,'R'); 	
		$pdf->Cell(18,4,$totala,0,0,'R'); 
		$pdf->Cell(18,4,$totalp,0,0,'R');
        $pdf->Cell(18,4,$totale,0,1,'R');		
	  $pdf->Output();   
    }
	
	if($tipo_rep=="EXCEL"){	
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Ejecucion_presupuestaria.xls");
		?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
			<td width="200" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>EJECUCION PRESUPUESTARIA</strong></font></td>
		 </tr>
		 <tr height="20">
		    <td width="200" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1; ?></strong></font></td>
		 </tr>
		 <tr height="20">
		   <td width="200" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Codigo</strong></td>
		   <td width="400" align="left" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Asignacion</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Modificaciones</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Asig.Actualizada</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Comprometido</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Disponible</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Causado</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Pagado</strong></td>	   
		 </tr>
		<?$i=0;  $totalg=0; $totalf=0; $totalm=0; $totalc=0; $totala=0; $totalp=0; $totald=0; $totale=0; $res=pg_query($sSQL);
        $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $prev_clave="";  	  
	    $cat_totalg=0; $cat_totalf=0; $cat_totalm=0; $cat_totalc=0; $cat_totala=0; $cat_totalp=0; $cat_totald=0; $cat_totale=0; $prev_cat="";
        $par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par="";	$prev_den="";	  
	    while($registro=pg_fetch_array($res)){ $i=$i+1;  
		    $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"];  
			$cod_categoria=$registro["cod_categoria"]; $denominacion_cat=$registro["denomina_cat"];     $categoria=$cod_categoria;		
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
			$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
			
			if(($categoria<>$prev_cat)and($c_sub>0)){ 
				if(($categoria<>$prev_cat)and($c_sub>0)and($prev_cat<>"")){ 
				    $porc_comp=0;if($cat_totalf<>0){$porc_comp=($cat_totalc/$cat_totalf)*100;} $porc_comp=formato_monto($porc_comp);
                    $porc_disp=0;if($cat_totalf<>0){$porc_disp=($cat_totald/$cat_totalf)*100;} $porc_disp=formato_monto($porc_disp);
                    $porc_caus=0;if($cat_totalc<>0){$porc_caus=($cat_totala/$cat_totalc)*100;} $porc_caus=formato_monto($porc_caus);
                    $porc_pag=0;if($cat_totala<>0){$porc_pag=($cat_totalp/$cat_totala)*100;} $porc_pag=formato_monto($porc_pag);
				    $cat_totalg=formato_monto($cat_totalg);$cat_totalf=formato_monto($cat_totalf);  $cat_totald=formato_monto($cat_totald);  $cat_totale=formato_monto($cat_totale); 
				    $cat_totalc=formato_monto($cat_totalc);$cat_totala=formato_monto($cat_totala);  $cat_totalp=formato_monto($cat_totalp);  $cat_totalm=formato_monto($cat_totalm); 
				    
					?>	 				 
					<tr>
					  <td width="200" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					</tr>	
					<tr>
					  <td width="200" align="left"></td>
					  <td width="400" align="right"><? echo "Total ".$criterio_s." ".$prev_cat." : "; ?></td>
					  <td width="120" align="right"><? echo $cat_totalg; ?></td>
					  <td width="120" align="right"><? echo $cat_totalm; ?></td>
					  <td width="120" align="right"><? echo $cat_totalf; ?></td> 
					  <td width="120" align="right"><? echo $cat_totalc; ?></td>
					  <td width="120" align="right"><? echo $cat_totald; ?></td>
					  <td width="120" align="right"><? echo $cat_totala; ?></td>
					  <td width="120" align="right"><? echo $cat_totalp; ?></td>
					</tr>
					<tr>
				      <td width="90" align="left"></td>
				    </tr>
					<tr>
				     <td width="200" align="left"><strong>'<? echo $categoria; ?> </strong></td>					 
				     <td width="400" align="left"><strong><? echo $denominacion_cat; ?> </strong></td>
					 <td width="120" align="left"></td>
					 <td width="120" align="left"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
				    </tr>		
					<?  
                    $prev_cat=$categoria;	$cat_totalg=0; $cat_totalf=0; $cat_totalm=0; $cat_totalc=0; $cat_totala=0; $cat_totalp=0; $cat_totald=0; $cat_totale=0;				
				}
						
				if ($prev_cat==""){ $prev_cat=$categoria;
				if($c_sub>0){
				?>	   
				   <tr>
				     <td width="200" align="left"><strong>'<? echo $categoria; ?> </strong></td>					 
				     <td width="400" align="left"><strong><? echo $denominacion_cat; ?> </strong></td>
					 <td width="120" align="left"></td>
					 <td width="120" align="left"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
				   </tr>				  
			     <? 	} }
				$prev_clave=$clave;   $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0;
            
			}
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $sub_totalg=$sub_totalg+$asignado; $sub_totalf=$sub_totalf+$asig_actualizada;	
			$cat_totalg=$cat_totalg+$asignado; $cat_totalf=$cat_totalf+$asig_actualizada; $par_totalg=$par_totalg+$asignado; $par_totalf=$par_totalf+$asig_actualizada;			
			$totald=$totald+$disponible; $totale=$totale+$deuda; $sub_totald=$sub_totald+$disponible; $sub_totale=$sub_totale+$deuda; 
			$cat_totald=$cat_totald+$disponible; $cat_totale=$cat_totale+$deuda; $par_totald=$par_totald+$disponible; $par_totale=$par_totale+$deuda;
			$totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;  
			$cat_totalm=$cat_totalm+$modificaciones; $cat_totalc=$cat_totalc+$comprometido; $par_totalm=$par_totalm+$modificaciones; $par_totalc=$par_totalc+$comprometido;
		    $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado;  
			$cat_totala=$cat_totala+$causado; $cat_totalp=$cat_totalp+$pagado; $par_totala=$par_totala+$causado; $par_totalp=$par_totalp+$pagado;
			
			$porc_comp=0;if($asig_actualizada<>0){$porc_comp=($comprometido/$asig_actualizada)*100;} $porc_comp=formato_monto($porc_comp);
			$porc_disp=0;if($asig_actualizada<>0){$porc_disp=($disponible/$asig_actualizada)*100;} $porc_disp=formato_monto($porc_disp);
			$porc_caus=0;if($comprometido<>0){$porc_caus=($causado/$comprometido)*100;} $porc_caus=formato_monto($porc_caus);
			$porc_pag=0;if($causado<>0){$porc_pag=($pagado/$causado)*100;} $porc_pag=formato_monto($porc_pag);
			$modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
		    $disponible=formato_monto($disponible); $asignado=formato_monto($asignado);  $asig_actualizada=formato_monto($asig_actualizada);   $deuda=formato_monto($deuda); 
		   ?>	   
			<tr>
			   <td width="200" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $cod_presup." ".$cod_fuente; ?></td>
			   <td width="400" align="justify"><? echo $denominacion; ?></td>				   
			   <td width="120" align="right"><? echo $asignado; ?></td>
			   <td width="120" align="right"><? echo $modificaciones; ?></td>
			   <td width="120" align="right"><? echo $asig_actualizada; ?></td>
			   <td width="120" align="right"><? echo $comprometido; ?></td>
			   
			   <td width="120" align="right"><? echo $disponible; ?></td>
			   <td width="120" align="right"><? echo $causado; ?></td>
			   <td width="120" align="right"><? echo $pagado; ?></td>
			 </tr>
			<? 
		} 
		$par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
		$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 
		
		$sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
	    $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		
		if($c_sub>0){$porc_comp=0;if($cat_totalf<>0){$porc_comp=($cat_totalc/$cat_totalf)*100;} $porc_comp=formato_monto($porc_comp);
		$porc_disp=0;if($cat_totalf<>0){$porc_disp=($cat_totald/$cat_totalf)*100;} $porc_disp=formato_monto($porc_disp);
		$porc_caus=0;if($cat_totalc<>0){$porc_caus=($cat_totala/$cat_totalc)*100;} $porc_caus=formato_monto($porc_caus);
		$porc_pag=0;if($cat_totala<>0){$porc_pag=($cat_totalp/$cat_totala)*100;} $porc_pag=formato_monto($porc_pag);
		$cat_totalg=formato_monto($cat_totalg);$cat_totalf=formato_monto($cat_totalf);  $cat_totald=formato_monto($cat_totald);  $cat_totale=formato_monto($cat_totale); 
		$cat_totalc=formato_monto($cat_totalc);$cat_totala=formato_monto($cat_totala);  $cat_totalp=formato_monto($cat_totalp);  $cat_totalm=formato_monto($cat_totalm); 
		?>	
			<tr>
			  <td width="200" align="left"></td>
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
			  <td width="200" align="left"></td>
			  <td width="400" align="right"><? echo "Total ".$criterio_s." ".$prev_cat." : "; ?></td>
			  <td width="120" align="right"><? echo $cat_totalg; ?></td>
			  <td width="120" align="right"><? echo $cat_totalm; ?></td>
			  <td width="120" align="right"><? echo $cat_totalf; ?></td> 
			  <td width="120" align="right"><? echo $cat_totalc; ?></td>
			  <td width="120" align="right"><? echo $cat_totald; ?></td>
			  <td width="120" align="right"><? echo $cat_totala; ?></td>
			  <td width="120" align="right"><? echo $cat_totalp; ?></td>
			</tr>
			<tr>
			  <td width="200" align="left"></td>
			</tr>
		<? }
		$porc_comp=0;if($totalf<>0){$porc_comp=($totalc/$totalf)*100;} $porc_comp=formato_monto($porc_comp);
		$porc_disp=0;if($totalf<>0){$porc_disp=($totald/$totalf)*100;} $porc_disp=formato_monto($porc_disp);
		$porc_caus=0;if($totalc<>0){$porc_caus=($totala/$totalc)*100;} $porc_caus=formato_monto($porc_caus);
		$porc_pag=0;if($totala<>0){$porc_pag=($totalp/$totala)*100;} $porc_pag=formato_monto($porc_pag);		
		$totalg=formato_monto($totalg);$totalf=formato_monto($totalf);  $totald=formato_monto($totald);  $totale=formato_monto($totale); 
	    $totalc=formato_monto($totalc);$totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm); 		
		?>	
		    <tr>
			  <td width="200" align="left"></td>
			</tr>
			<tr>
			  <td width="200" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="120" align="right">=============</td>
			  <td width="120" align="right">=============</td>
			  <td width="120" align="right">=============</td>
			  <td width="120" align="right">=============</td>
			  <td width="120" align="right">=============</td>
			  <td width="120" align="right">=============</td>
			  <td width="120" align="right">=============</td>
			  <td width="120" align="right">=============</td>
			</tr>	
			<tr>
			  <td width="200" align="left"></td>
			  <td width="400" align="right"><? echo "Total General : "; ?></td>
			  <td width="120" align="right"><? echo $totalg; ?></td>
			  <td width="120" align="right"><? echo $totalm; ?></td>
			  <td width="120" align="right"><? echo $totalf; ?></td> 
			  <td width="120" align="right"><? echo $totalc; ?></td>
			  <td width="120" align="right"><? echo $totald; ?></td>
			  <td width="120" align="right"><? echo $totala; ?></td>
			  <td width="120" align="right"><? echo $totalp; ?></td>
			</tr>
			
		<? 
		?></table><?
	}
	/*
    $StrSQL = "DELETE FROM pre020 Where (tipo_registro='2') And (Nombre_Usuario='".$cod_mov."')";    $res=pg_exec($conn,$StrSQL); $merror=pg_errormessage($conn); $merror=substr($merror, 0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $merror; ?>'); </script> <? } 
  */
	?>

