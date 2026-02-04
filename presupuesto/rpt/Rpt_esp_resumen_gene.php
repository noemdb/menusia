<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$cod_presup_d=$_GET["cod_presupd"];$cod_presup_h=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuented"];$cod_fuente_h=$_GET["cod_fuenteh"];$mes_desde=$_GET["mes_desde"];$mes_hasta=$_GET["mes_hasta"];$asig_global=$_GET["asig_global"]; $c_cat=$_GET["csubtotal"]; $mostrar=$_GET["mostrar"];$tipo_rep=$_GET["tipo_rep"]; $det_modif=$_GET["det_modif"]; } 
else{$codigod="";$codigoh="";$fuented="";$fuenteh="";$fecha=""; $cant_cat=1; $det_modif="NO"; $tipo_rep="HTML";}   $equipo=getenv("COMPUTERNAME"); $cod_mov="pre020".$usuario_sia; $php_os=PHP_OS;
//$asig_global="N";  echo $mostrar;
$mdes_cat=array("NINGUNA","","","","","");
$mcontrol = array (0, 0, 0, 0, 0, 0, 0, 0, 0,0);
function buscar_control($clave, $formato){  global $mcontrol;  $j=0;
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} } 
  return $actual;
}
function Rellenarcerosizq($str,$n){$numeroarellenar=$n-strlen($str); $texto=""; for ($i=0; $i < $numeroarellenar; $i++){$texto=$texto."0";} $texto=$texto.$str; return $texto;}
//if ($mes_desde==01){$mesd="Enero";}elseif ($mes_desde==02){$mesd="Febrero";}elseif ($mes_desde==03){$mesd="Marzo";}elseif ($mes_desde==04){$mesd="Abril";}elseif ($mes_desde==05){$mesd="Mayo";}elseif ($mes_desde==06){$mesd="Junio";}elseif ($mes_desde==07){$mesd="Julio";}elseif ($mes_desde==08){$mesd="Agosto";}elseif ($mes_desde==09){$mesd="Septiembre";}elseif ($mes_desde==10){$mesd="Octubre";}elseif ($mes_desde==11){$mesd="Noviembre";}elseif ($mes_desde==12){$mesd="Diciembre";}
//if ($mes_hasta==01){$mesh="Enero";}elseif ($mes_hasta==02){$mesh="Febrero";}elseif ($mes_hasta==03){$mesh="Marzo";}elseif ($mes_hasta==04){$mesh="Abril";}elseif ($mes_hasta==05){$mesh="Mayo";}elseif ($mes_hasta==06){$mesh="Junio";}elseif ($mes_hasta==07){$mesh="Julio";}elseif ($mes_hasta==08){$mesh="Agosto";}elseif ($mes_hasta==09){$mesh="Septiembre";}elseif ($mes_hasta==10){$mesh="Octubre";}elseif ($mes_hasta==11){$mesh="Noviembre";}elseif ($mes_hasta==12){$mesh="Diciembre";}
if ($mes_desde=='01'){$mesd="Enero";}elseif ($mes_desde=='02'){$mesd="Febrero";}elseif ($mes_desde=='03'){$mesd="Marzo";}elseif ($mes_desde=='04'){$mesd="Abril";}elseif ($mes_desde=='05'){$mesd="Mayo";}elseif ($mes_desde=='06'){$mesd="Junio";}elseif ($mes_desde=='07'){$mesd="Julio";}elseif ($mes_desde=='08'){$mesd="Agosto";}elseif ($mes_desde=='09'){$mesd="Septiembre";}elseif ($mes_desde=='10'){$mesd="Octubre";}elseif ($mes_desde=='11'){$mesd="Noviembre";}elseif ($mes_desde=='12'){$mesd="Diciembre";}
if ($mes_hasta=='01'){$mesh="Enero";}elseif ($mes_hasta=='02'){$mesh="Febrero";}elseif ($mes_hasta=='03'){$mesh="Marzo";}elseif ($mes_hasta=='04'){$mesh="Abril";}elseif ($mes_hasta=='05'){$mesh="Mayo";}elseif ($mes_hasta=='06'){$mesh="Junio";}elseif ($mes_hasta=='07'){$mesh="Julio";}elseif ($mes_hasta=='08'){$mesh="Agosto";}elseif ($mes_hasta=='09'){$mesh="Septiembre";}elseif ($mes_hasta=='10'){$mesh="Octubre";}elseif ($mes_hasta=='11'){$mesh="Noviembre";}elseif ($mes_hasta=='12'){$mesh="Diciembre";}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); } if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
   $mano=substr($Fec_Fin_Ejer,0,4);    $criterio1="Desde: ".$mesd." Hasta: ".$mesh." Ejercicio Fiscal: ".$mano;    $criterio2="";  

   if($cod_fuente_h==$cod_fuente_d){$sSQL="Select * from PRE095 WHERE cod_fuente_financ='$cod_fuente_d'"; $resultado=pg_query($sSQL); if($registro=pg_fetch_array($resultado,0)){$criterio1=$criterio1."  FUENTE : ".$registro["des_fuente_financ"];} }
   
   $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
   $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; $mdes_cat[1]=$registro["campo505"]; $mdes_cat[2]=$registro["campo507"]; $mdes_cat[3]=$registro["campo509"]; $mdes_cat[4]=$registro["campo511"]; $mdes_cat[5]=$registro["campo513"];}
   $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2; $p=3; $h=$c+1+$p; 
   
   
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presup_d,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
   if($c_cat==0){$criterio_s=""; $ls=$c;}else{$criterio_s=$mdes_cat[$c_cat]; $ls=$mcontrol[$c_cat-1];}  $lc=$ls+1+$p;   
   
   
   $pos=strrpos($cod_presup_d,"?"); if($pos===false){$en_d=0;}else{$en_d=1;} $pos=strrpos($cod_presup_h,"?"); if($pos===false){$en_h=0;}else{$en_h=1;}   
   if(($en_d==1)or($en_h==1)){$codigo_d=str_replace("?","0",$cod_presup_d); $long_d=strlen($codigo_d); $codigo_h=str_replace("?","9",$cod_presup_h); $long_h=strlen($codigo_h);
	  if(($long_d=$long_u)and ($long_h=$long_u)){ $criterio=""; 
         for ($i=0; $i<10; $i++) { $m=$mcontrol[$i]; if($i==0){$a=0;}else{$a=$mcontrol[$i-1];}
		     if ($m<>0){if($i==0){ $len_nivel=$m; $criterio=""; }else{ $mpos=1+$a;  $len_nivel=($m-$a-1); $criterio=$criterio." and "; }
				$cod_d=substr($codigo_d,$mpos,$len_nivel); $cod_h=substr($codigo_h,$mpos,$len_nivel);$mpp=$mpos+1;
				$criterio=$criterio."substring(cod_presup,".$mpp.",".$len_nivel.")>='".$cod_d."' and "; $criterio=$criterio."substring(cod_presup,".$mpp.",".$len_nivel.")<='".$cod_h."' ";  }
	     } $criterio=$criterio."and  cod_fuente>='".$cod_fuente_d."' and cod_fuente<='".$cod_fuente_h."'";
	  }else{$criterio="cod_presup>='".$codigo_d."' and cod_presup<='".$codigo_h."' and  cod_fuente>='".$cod_fuente_d."' and cod_fuente<='".$cod_fuente_h."'";}
   }else{$criterio="cod_presup>='".$cod_presup_d."' and cod_presup<='".$cod_presup_h."' and  cod_fuente>='".$cod_fuente_d."' and cod_fuente<='".$cod_fuente_h."'";}
  
   $per_hasta=$mes_hasta;
  $sql_Asignacion=""; $sql_Traslados=""; $sql_Trasladon=""; $sql_Adicion=""; $sql_Disminucion=""; 
  $sql_Compromiso=""; $sql_Diferido=""; $sql_Causado=""; $sql_Pagado=""; $sql_Diferido ="";
  If($per_hasta==0){ $sql_Traslados="0 as Traslados,";  $sql_Trasladon="0 as Trasladon,";  $sql_Adicion="0 as Adicion,";
     $sql_Disminucion="0 as Disminucion,"; $sql_Compromiso="0 as Compromiso,"; $sql_Causado="0 as Causado,";
     $sql_Pagado="0 as Pagado,"; $sql_Asignacion="0 as asignado,"; $sql_Asignacion="asignado,";  $sql_Diferido="0 as Diferido"; }
   else{for ($i=1; $i <= $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==1){$scampo = "(Traslados".$pos;  $scampo1 = "(Trasladon".$pos;  $scampo2 = "(Adicion".$pos;
           $scampo3 = "(Disminucion".$pos;  $scampo7 = "(asignado".$pos; }
       else{$scampo = "+Traslados".$pos;$scampo1 = "+Trasladon".$pos;$scampo2 = "+Adicion".$pos;
           $scampo3 = "+Disminucion".$pos; $scampo7 = "+asignado".$pos; }
      $sql_Traslados=$sql_Traslados.$scampo;  $sql_Trasladon=$sql_Trasladon.$scampo1; $sql_Adicion=$sql_Adicion.$scampo2;
      $sql_Disminucion=$sql_Disminucion.$scampo3;  $sql_Asignacion=$sql_Asignacion.$scampo7; 		   
	} 
	for ($i=$mes_desde; $i <= $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==$mes_desde){$scampo4 = "(Compromiso".$pos;  $scampo5 = "(Causado".$pos;
           $scampo6 = "(Pagado".$pos; $scampo8 = "(Diferido".$pos; }
       else{$scampo4 = "+Compromiso".$pos;$scampo5 = "+Causado".$pos;
           $scampo6 = "+Pagado".$pos;  $scampo8 = "+Diferido".$pos;}
      $sql_Compromiso=$sql_Compromiso.$scampo4;$sql_Causado=$sql_Causado.$scampo5; $sql_Pagado=$sql_Pagado.$scampo6;$sql_Diferido=$sql_Diferido.$scampo8;		   
	} 
    $sql_Traslados=$sql_Traslados.") as Traslados,"; $sql_Trasladon=$sql_Trasladon.") as Trasladon,";
    $sql_Adicion=$sql_Adicion.") as Adicion,"; $sql_Disminucion=$sql_Disminucion.") as Disminucion,";
    $sql_Compromiso=$sql_Compromiso.") as Compromiso,"; $sql_Causado=$sql_Causado.") as Causado,";
    $sql_Pagado=$sql_Pagado.") as Pagado,"; $sql_Asignacion=$sql_Asignacion.") as asignado,";
    $sql_Asignacion="asignado,"; $sql_Diferido=$sql_Diferido.") as Diferido";	
   }
   
  $StrSQL = "DELETE FROM pre020 Where (Tipo_Registro='2') And (nombre_usuario='".$cod_mov."')";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
  if($asig_global=="S"){$sql_Asignacion="asignado,";}
  $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'2' as Tipo_Registro, cod_presup, cod_fuente, Denominacion,substr(cod_presup,1,".$ls.") as cod_categoria,"."'' as Denomina_cat,substr(cod_presup,".$ini.",".$p.") as cod_partida,'' as Denomina_Par,Status_Dist,Func_Inv,Ord_Cord,Aplicacion,Cod_Unidad_Ejec, ";
  $StrSQL=$StrSQL.$sql_Asignacion." Disponible,Disp_Diferida,".$sql_Compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.", "."0 as CompromisoM,0 as CausadoM, 0 as PagadoM, 0 as TrasladosM, 0 as TrasladonM, 0 as AdicionM, 0 as DisminucionM, 0 as DiferidoM ";
  $StrSQL=$StrSQL." FROM PRE001 WHERE length(cod_presup)=".$l_c." and ".$criterio;
  //echo $StrSQL;
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

  $ordenar=" ORDER BY pre020.cod_partida";   
  $sSQL ="Select distinct substr(cod_presup,".$ini.",".$p.") as codigo,denominacion from pre001 where length(cod_presup)=".$h; $res=pg_query($sSQL); 
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["codigo"]; $denominacion=$registro["denominacion"]; 
     $sql="update pre020 set denomina_par='$denominacion' where Tipo_Registro='2' and nombre_usuario='$cod_mov' and cod_partida='$cod_presup'";$resultado=pg_exec($conn,$sql); 
  }
  if(($c_cat>0)or($mostrar=="CA")){ $ordenar=" ORDER BY pre020.cod_categoria,pre020.cod_partida";
   $sSQL = "Select cod_presup,denominacion from pre001 WHERE cod_presup in (select distinct cod_categoria from pre020 where (Tipo_Registro='2') and (nombre_usuario='$cod_mov'))";  $res=pg_query($sSQL);
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_presup"]; $denominacion=$registro["denominacion"]; 
     $sql="update pre020 set denomina_cat='$denominacion' where Tipo_Registro='2' and nombre_usuario='$cod_mov' and cod_categoria='$cod_presup'";$resultado=pg_exec($conn,$sql); 
	 $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  }}


  
  		$sSQL = "SELECT pre020.cod_presup,pre020.cod_fuente,pre020.denominacion,pre020.cod_categoria,pre020.denomina_cat,pre020.cod_partida,pre020.denomina_par,substring(pre020.cod_partida,1,3) as partida, pre020.Asignado, pre020.Traslados, pre020.Trasladon, pre020.Adicion, 
			 pre020.Disminucion, pre020.Compromiso, pre020.Causado, pre020.Pagado, pre020.Disponible, 
			(pre020.Traslados-pre020.Trasladon+pre020.Adicion-pre020.Disminucion) AS Modificaciones,(pre020.Traslados+pre020.Adicion) AS Aumentos, (pre020.Trasladon+pre020.Disminucion) AS Disminuciones,
			(pre020.Asignado+pre020.Traslados-pre020.Trasladon+pre020.Adicion-pre020.Disminucion) AS Asig_Actualizada, (pre020.Asignado+pre020.Traslados-pre020.Trasladon+pre020.Adicion-pre020.Disminucion-pre020.Compromiso) AS Disponibilidad
			 FROM pre020 WHERE Tipo_Registro='2' and nombre_usuario='$cod_mov' and ".$criterio.$ordenar;
    //echo $sSQL,"<br>";
    
	if(($tipo_rep=="PDF")and($det_modif<>"SI")){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $criterio1; global $tam_logo; global $registro; global $c_cat; global $criterio_s; global $mostrar; global $Nom_Emp; global $php_os;
            $cod_presup_cat=$registro["cod_categoria"]; $denominacion_cat=$registro["denomina_cat"];   
			if($php_os=="WINNT"){$denominacion_cat=$registro["denomina_cat"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); }
			$this->SetFont('Arial','',11);
			$this->Cell(5,5,'',0,0,'C');
			$this->Cell(260,5,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,1,'C');
			$this->Cell(5,5,'',0,0,'C');
			$this->Cell(260,5,$Nom_Emp,0,1,'C');
			$this->SetFont('Arial','B',15);
			$this->Cell(30);
			$this->Cell(200,5,'RESUMEN GENERAL DE LA EJECUCION PRESUPUESTARIA',0,1,'C');
			$this->SetFont('Arial','',9);
			$this->Cell(5,5,'',0,0,'L');
			$this->Cell(260,5,'PERIODO : '.$criterio1,0,1,'C');			
			$this->SetFont('Arial','',9);			
			if(($c_cat>0)and($mostrar<>"CA")){	
			  $this->Cell(260,4,'',0,1,'C');
              $this->Cell(260,4,$criterio_s.": ".$cod_presup_cat." ".$denominacion_cat,0,1,'C');
			}
			$this->Cell(260,5,'',0,1,'C');
			$this->SetFillColor(192,192,192);
            $this->SetFont('Arial','B',5.5);					
			$this->Cell(10,5,'CODIGO',1,0,'C',true);
			$this->Cell(90,5,'DENOMINACION',1,0,'C',true);
			$this->Cell(20,5,'ASIGNACION',1,0,'C',true);
			$this->Cell(20,5,'MODIFICACIONES',1,0,'C',true);
			$this->Cell(21,5,'ASIG. ACTUALIZADA',1,0,'C',true);
			$this->Cell(20,5,'COMPROMETIDO',1,0,'C',true);
			$this->Cell(20,5,'DISPONIBLE',1,0,'C',true);
			$this->Cell(20,5,'CAUSADO',1,0,'C',true);
			$this->Cell(20,5,'PAGADO',1,0,'C',true);			
			$this->Cell(19,5,'DEUDA',1,1,'C',true);
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
			$cod_categoria=$registro["cod_categoria"]; $denominacion_cat=$registro["denomina_cat"];   $cod_partida=$registro["cod_partida"];  $clave=$registro["partida"]; $categoria=$cod_categoria;		
		    $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["cod_fuente"]; $denominacion=$registro["denominacion"];  $denomina_par=$registro["denomina_par"];
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"];
            $aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];			
			$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
			if(($prev_clave<>$clave)or(($categoria<>$prev_cat)and($c_cat>0))){ 			    
			    if($prev_par<>""){ 
				    $par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
					$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 
					$pdf->Cell(10,5,$prev_par,'RL',0); 		   
					$x=$pdf->GetX();   $y=$pdf->GetY(); $n=90; 		   
					$pdf->SetXY($x+$n,$y);
					$pdf->Cell(20,5,$par_totalg,'RL',0,'R'); 
					$pdf->Cell(20,5,$par_totalm,'RL',0,'R'); 
					$pdf->Cell(21,5,$par_totalf,'RL',0,'R'); 	
					$pdf->Cell(20,5,$par_totalc,'RL',0,'R');
					$pdf->Cell(20,5,$par_totald,'RL',0,'R');		   
					$pdf->Cell(20,5,$par_totala,'RL',0,'R'); 
					$pdf->Cell(20,5,$par_totalp,'RL',0,'R');
					$pdf->Cell(19,5,$par_totale,'RL',1,'R');
					$pdf->SetXY($x,$y);
					$pdf->MultiCell($n,5,$prev_den,'RL');
					$par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par=$cod_partida; $prev_den=$denomina_par;
				}
				if ($prev_par==""){ $prev_par=$cod_partida; $prev_den=$denomina_par;}
				$pdf->SetFont('Arial','B',7); 
				
				if(($categoria<>$prev_cat)and($c_cat>0)and($prev_cat<>"")){ 
				    $cat_totalg=formato_monto($cat_totalg);$cat_totalf=formato_monto($cat_totalf);  $cat_totald=formato_monto($cat_totald);  $cat_totale=formato_monto($cat_totale); 
				    $cat_totalc=formato_monto($cat_totalc);$cat_totala=formato_monto($cat_totala);  $cat_totalp=formato_monto($cat_totalp);  $cat_totalm=formato_monto($cat_totalm); 
				    
					$pdf->Cell(100,5,"Total ".$criterio_s." ".$prev_cat." : ",1,0,'R'); 
					$pdf->Cell(20,5,$cat_totalg,1,0,'R'); 
					$pdf->Cell(20,5,$cat_totalm,1,0,'R'); 
					$pdf->Cell(21,5,$cat_totalf,1,0,'R'); 					
					$pdf->Cell(20,5,$cat_totalc,1,0,'R'); 
					$pdf->Cell(20,5,$cat_totald,1,0,'R'); 
					$pdf->Cell(20,5,$cat_totala,1,0,'R'); 
					$pdf->Cell(20,5,$cat_totalp,1,0,'R'); 					
					$pdf->Cell(19,5,$cat_totale,1,1,'R'); 
					$pdf->AddPage();
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
		}$par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
		$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 
		$pdf->Cell(10,5,$prev_par,'RLB',0); 		   
		$x=$pdf->GetX();   $y=$pdf->GetY(); $n=90; 		   
		$pdf->SetXY($x+$n,$y);
		$pdf->Cell(20,5,$par_totalg,'RLB',0,'R'); 
		$pdf->Cell(20,5,$par_totalm,'RLB',0,'R'); 
		$pdf->Cell(21,5,$par_totalf,'RLB',0,'R'); 	
		$pdf->Cell(20,5,$par_totalc,'RLB',0,'R');
		$pdf->Cell(20,5,$par_totald,'RLB',0,'R');		   
		$pdf->Cell(20,5,$par_totala,'RLB',0,'R'); 
		$pdf->Cell(20,5,$par_totalp,'RLB',0,'R');
		$pdf->Cell(19,5,$par_totale,'RLB',1,'R');
		$pdf->SetXY($x,$y);
		$pdf->MultiCell($n,5,$prev_den,'RLB');
		$sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
	    $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		$pdf->SetFont('Arial','B',6); 
		
		/*if($c_cat>0){
		$cat_totalg=formato_monto($cat_totalg);$cat_totalf=formato_monto($cat_totalf);  $cat_totald=formato_monto($cat_totald);  $cat_totale=formato_monto($cat_totale); 
		$cat_totalc=formato_monto($cat_totalc);$cat_totala=formato_monto($cat_totala);  $cat_totalp=formato_monto($cat_totalp);  $cat_totalm=formato_monto($cat_totalm); 
		$pdf->Cell(100,4,"Total ".$criterio_s." ".$prev_cat." : ",0,0,'R'); 
		$pdf->Cell(20,4,$cat_totalg,1,0,'R'); 
		$pdf->Cell(20,4,$cat_totalm,1,0,'R'); 
		$pdf->Cell(20,4,$cat_totalf,1,0,'R'); 					
		$pdf->Cell(20,4,$cat_totalc,1,0,'R'); 
		$pdf->Cell(20,4,$cat_totald,1,0,'R'); 
		$pdf->Cell(20,4,$cat_totala,1,0,'R'); 
		$pdf->Cell(20,4,$cat_totalp,1,0,'R'); 					
		$pdf->Cell(20,4,$cat_totale,1,1,'R'); }*/
	   
      	 
	    $pdf->SetFont('Arial','B',7); 
        $pdf->Ln(5);
		$totalg=formato_monto($totalg);$totalf=formato_monto($totalf);  $totald=formato_monto($totald);  $totale=formato_monto($totale); 
		$totalc=formato_monto($totalc);$totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm); 
		
		$pdf->Cell(100,4,"TOTALES ",0,0,'R'); 
		$pdf->Cell(20,4,$totalg,1,0,'R'); 
		$pdf->Cell(20,4,$totalm,1,0,'R'); 
		$pdf->Cell(21,4,$totalf,1,0,'R'); 					
		$pdf->Cell(20,4,$totalc,1,0,'R'); 
		$pdf->Cell(20,4,$totald,1,0,'R'); 
		$pdf->Cell(20,4,$totala,1,0,'R'); 
		$pdf->Cell(20,4,$totalp,1,0,'R'); 		
		$pdf->Cell(19,4,$totale,1,1,'R'); 	  
	  $pdf->Output();   
    }
	
  $StrSQL = "DELETE FROM pre020 Where (Tipo_Registro='2') And (nombre_usuario='".$cod_mov."')";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
?>

