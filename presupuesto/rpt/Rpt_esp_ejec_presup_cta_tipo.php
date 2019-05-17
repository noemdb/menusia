<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$cod_presup_d=$_GET["cod_presupd"];$cod_presup_h=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuented"];$cod_fuente_h=$_GET["cod_fuenteh"];$mes_desde=$_GET["mes_desde"];$mes_hasta=$_GET["mes_hasta"];$asig_global=$_GET["asig_global"]; $tipo_rep=$_GET["tipo_rep"];  } 
else{$codigod="";$codigoh="";$fuented="";$fuenteh="";$fecha=""; $tipo_rep="HTML";}   $equipo=getenv("COMPUTERNAME"); $cod_mov="pre020".$usuario_sia; $php_os=PHP_OS;
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
if ($mes_desde=='01'){$mesd="Enero";}elseif ($mes_desde=='02'){$mesd="Febrero";}elseif ($mes_desde=='03'){$mesd="Marzo";}elseif ($mes_desde=='04'){$mesd="Abril";}elseif ($mes_desde=='05'){$mesd="Mayo";}elseif ($mes_desde=='06'){$mesd="Junio";}elseif ($mes_desde=='07'){$mesd="Julio";}elseif ($mes_desde=='08'){$mesd="Agosto";}elseif ($mes_desde=='09'){$mesd="Septiembre";}elseif ($mes_desde=='10'){$mesd="Octubre";}elseif ($mes_desde=='11'){$mesd="Noviembre";}elseif ($mes_desde=='12'){$mesd="Diciembre";}
if ($mes_hasta=='01'){$mesh="Enero";}elseif ($mes_hasta=='02'){$mesh="Febrero";}elseif ($mes_hasta=='03'){$mesh="Marzo";}elseif ($mes_hasta=='04'){$mesh="Abril";}elseif ($mes_hasta=='05'){$mesh="Mayo";}elseif ($mes_hasta=='06'){$mesh="Junio";}elseif ($mes_hasta=='07'){$mesh="Julio";}elseif ($mes_hasta=='08'){$mesh="Agosto";}elseif ($mes_hasta=='09'){$mesh="Septiembre";}elseif ($mes_hasta=='10'){$mesh="Octubre";}elseif ($mes_hasta=='11'){$mesh="Noviembre";}elseif ($mes_hasta=='12'){$mesh="Diciembre";}
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
   $mano=substr($Fec_Fin_Ejer,0,4);    $criterio1="DESDE EL MES DE: ".$mesd." HASTA: ".$mesh." DEL: ".$mano;    $criterio2="";  
   $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
   $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; $mdes_cat[1]=$registro["campo505"]; $mdes_cat[2]=$registro["campo507"]; $mdes_cat[3]=$registro["campo509"]; $mdes_cat[4]=$registro["campo511"]; $mdes_cat[5]=$registro["campo513"];}
   $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2; $p=3; $h=$c+1+$p; 
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presup_d,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
   $ls=$c; $lc=$ls+1+$p;  
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
  
  $per_hasta=$mes_hasta;
  $cat_desde=substr($cod_presup_d,0,$c); $cat_hasta=substr($cod_presup_h,0,$c); $criterio_s="";
  if($cat_desde==$cat_hasta){
    $sql="SELECT denominacion from pre001 where cod_presup='$cat_desde'"; $res=pg_query($sql); $filas=pg_num_rows($res);
	if($filas>0){$registro=pg_fetch_array($res); $criterio_s=$cat_desde." ".$registro["denominacion"]; }
  }
  
  $sql_Asignacion=""; $sql_Traslados=""; $sql_Trasladon=""; $sql_Adicion=""; $sql_Disminucion=""; 
  $sql_Compromiso=""; $sql_Diferido=""; $sql_Causado=""; $sql_Pagado=""; $sql_Diferido ="";
  $sql_compromisom=""; $sql_causadom=""; $sql_pagadom="";
  If($per_hasta==0){ $sql_Traslados="0 as Traslados,";  $sql_Trasladon="0 as Trasladon,";  $sql_Adicion="0 as Adicion,";
     $sql_Disminucion="0 as Disminucion,"; $sql_Compromiso="0 as Compromiso,"; $sql_Causado="0 as Causado,";
     $sql_Pagado="0 as Pagado,"; $sql_Asignacion="0 as asignado,"; $sql_Asignacion="asignado,";  $sql_Diferido="0 as Diferido"; 
	 $sql_compromisom="0 as compromisom,"; $sql_causadom="0 as causadom,";  $sql_pagadom="0 as pagadom,";}
   else{for ($i=1; $i <= $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==1){$scampo = "(Traslados".$pos;  $scampo1 = "(Trasladon".$pos;  $scampo2 = "(Adicion".$pos;
           $scampo3 = "(Disminucion".$pos;  $scampo7 = "(asignado".$pos; $scampo4 = "(Compromiso".$pos;  
		   $scampo5 = "(Causado".$pos;   $scampo6 = "(Pagado".$pos;}
       else{$scampo = "+Traslados".$pos;$scampo1 = "+Trasladon".$pos;$scampo2 = "+Adicion".$pos;
           $scampo3 = "+Disminucion".$pos; $scampo7 = "+asignado".$pos; $scampo4 = "+Compromiso".$pos;$scampo5 = "+Causado".$pos;
           $scampo6 = "+Pagado".$pos;}
      $sql_Traslados=$sql_Traslados.$scampo;  $sql_Trasladon=$sql_Trasladon.$scampo1; $sql_Adicion=$sql_Adicion.$scampo2;
      $sql_Disminucion=$sql_Disminucion.$scampo3;  $sql_Asignacion=$sql_Asignacion.$scampo7; 
      $sql_compromisom=$sql_compromisom.$scampo4;$sql_causadom=$sql_causadom.$scampo5; $sql_pagadom=$sql_pagadom.$scampo6;	  
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
    $sql_compromisom=$sql_compromisom.") as compromisom,"; $sql_causadom=$sql_causadom.") as causadom,";
    $sql_pagadom=$sql_pagadom.") as pagadom,";	
   }
   
  $StrSQL = "DELETE FROM pre020 Where (tipo_registro='9') And (nombre_usuario='".$cod_mov."')";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
  if($asig_global=="S"){$sql_Asignacion="asignado,";}
  $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'9' as tipo_registro, cod_presup, cod_fuente, denominacion,substr(cod_presup,1,".$ls.") as cod_categoria,"."'' as denomina_cat,substr(cod_presup,".$ini.",".$p.") as cod_partida,'' as denomina_Par,Status_Dist,Func_Inv,Ord_Cord,Aplicacion,Cod_Unidad_Ejec, ";
  $StrSQL=$StrSQL.$sql_Asignacion." Disponible,Disp_Diferida,".$sql_Compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.",".$sql_compromisom.$sql_causadom.$sql_pagadom." 0 as TrasladosM, 0 as TrasladonM, 0 as AdicionM, 0 as DisminucionM, 0 as DiferidoM ";
  $StrSQL=$StrSQL." FROM PRE001 WHERE length(cod_presup)=".$l_c." and ".$criterio;
  //echo $StrSQL;
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

  $ordenar=" ORDER BY pre020.cod_fuente,pre020.cod_partida";   
  $sSQL ="Select distinct substr(cod_presup,".$ini.",".$p.") as codigo,denominacion from pre001 where length(cod_presup)=".$h; $res=pg_query($sSQL); 
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["codigo"]; $denominacion=$registro["denominacion"]; 
     $sql="update pre020 set denomina_par='$denominacion' where tipo_registro='9' and nombre_usuario='$cod_mov' and cod_partida='$cod_presup'";$resultado=pg_exec($conn,$sql); 
  }
  
  $sSQL = "Select cod_presup,denominacion from pre001 WHERE cod_presup in (select distinct cod_categoria from pre020 where (tipo_registro='2') and (nombre_usuario='$cod_mov'))";  $res=pg_query($sSQL);
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_presup"]; $denominacion=$registro["denominacion"]; 
     $sql="update pre020 set denomina_cat='$denominacion' where tipo_registro='9' and nombre_usuario='$cod_mov' and cod_categoria='$cod_presup'";$resultado=pg_exec($conn,$sql); 
	 $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  }
  
  	$sSQL = "SELECT pre020.cod_presup,pre020.cod_fuente, pre020.denominacion,pre020.cod_categoria,pre020.denomina_cat,pre020.cod_partida,pre020.denomina_par,substring(pre020.cod_partida,1,3) as partida, pre020.asignado, pre020.traslados, pre020.trasladon, pre020.adicion, 
			 pre020.disminucion, pre020.compromiso, pre020.causado, pre020.pagado, pre020.disponible, pre095.des_fuente_financ, pre020.compromisom, pre020.causadom, pre020.pagadom, 
			(pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS Modificaciones,(pre020.traslados+pre020.adicion) AS Aumentos, (pre020.trasladon+pre020.disminucion) AS Disminuciones,
			(pre020.asignado+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS Asig_Actualizada, (pre020.asignado+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion-pre020.compromiso) AS Disponibilidad
			 FROM pre020 left join pre095 on (pre095.cod_fuente_financ=pre020.cod_fuente) WHERE tipo_registro='9' and nombre_usuario='$cod_mov' and ".$criterio.$ordenar;
    
	
	if($tipo_rep=="PDF"){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $criterio1; global $criterio_s; global $Nom_Emp;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(160,6,'EJECUCION POR CUENTA Y TIPO DE RECURSO',0,1,'C');
			$this->Cell(50);
			$this->Cell(160,6,$criterio1,0,1,'C');
			$this->Ln(8);
			$this->SetFont('Arial','B',8);
			if ($criterio_s<>''){
			   $this->Cell(150,5,$criterio_s,0,1);
			   $this->Ln(2);
			}			
            $this->SetFont('Arial','B',6);					
			$this->Cell(12,5,'CUENTA','TLR',0,'C');
			$this->Cell(122,5,'DENOMINACION','TLR',0,'C');
			$this->Cell(42,5,'COMPROMISOS',1,0,'C');
			$this->Cell(42,5,'CAUSADOS',1,0,'C');
            $this->Cell(42,5,'PAGOS',1,1,'C');			
			$this->Cell(12,5,'','BLR',0,'C');
			$this->Cell(122,5,'','BLR',0,'C');
			$this->Cell(21,5,'PERIODO',1,0,'C');
			$this->Cell(21,5,'ACUMULADO',1,0,'C');
			$this->Cell(21,5,'PERIODO',1,0,'C');
			$this->Cell(21,5,'ACUMULADO',1,0,'C');
			$this->Cell(21,5,'PERIODO',1,0,'C');
			$this->Cell(21,5,'ACUMULADO',1,1,'C');
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
	  $par_totalcm=0; $par_totalam=0; $par_totalpm=0; $totalcm=0; $totalam=0; $totalpm=0; 
	    while($registro=pg_fetch_array($res)){ $i=$i+1;  
			$cod_categoria=$registro["cod_categoria"]; $denominacion_cat=$registro["denomina_cat"];   $cod_partida=$registro["cod_partida"];  $clave=$registro["cod_fuente"]; $categoria=$cod_categoria;		
		    $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"];  $denomina_par=$registro["denomina_par"];   $denomina_fuen=$registro["des_fuente_financ"];  
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion); $denomina_fuen=utf8_decode($denomina_fuen); }
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"];
            $aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"]; $compromisom=$registro["compromisom"];   $causadom=$registro["causadom"]; $pagadom=$registro["pagadom"];			
			$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
			$modificaciones=round($modificaciones,0); $comprometido=round($comprometido,0); $causado=round($causado,0); $pagado=round($pagado,0);
			$aumentos=round($aumentos,0); $disminuciones=round($disminuciones,0); $disponible=round($disponible,0); $asignado=round($asignado,0);
			$asig_actualizada=round($asig_actualizada,0); $deuda=round($deuda,0); 
			$compromisom=round($compromisom,0);  $causadom=round($causadom,0); $pagadom=round($pagadom,0); 
			if($prev_clave<>$clave){ 			    
			    if($prev_clave<>""){ 
				    $par_totalg=parte_entera_num($par_totalg);$par_totalf=parte_entera_num($par_totalf);  $par_totald=parte_entera_num($par_totald);  $par_totale=parte_entera_num($par_totale); 
					$par_totalc=parte_entera_num($par_totalc);$par_totala=parte_entera_num($par_totala);  $par_totalp=parte_entera_num($par_totalp);  $par_totalm=parte_entera_num($par_totalm); 
					$par_totalcm=parte_entera_num($par_totalcm);$par_totalam=parte_entera_num($par_totalam);  $par_totalpm=parte_entera_num($par_totalpm);
					$pdf->Cell(12,5,$prev_clave,'LR',0); 		   
					$x=$pdf->GetX();   $y=$pdf->GetY(); $n=122; 		   
					$pdf->SetXY($x+$n,$y);
					$pdf->Cell(21,5,$par_totalc,'LR',0,'R'); 
					$pdf->Cell(21,5,$par_totalcm,'LR',0,'R'); 	
					$pdf->Cell(21,5,$par_totala,'LR',0,'R');	   
					$pdf->Cell(21,5,$par_totalam,'LR',0,'R'); 
					$pdf->Cell(21,5,$par_totalp,'LR',0,'R');
					$pdf->Cell(21,5,$par_totalpm,'LR',1,'R');
					$pdf->SetXY($x,$y);
					$pdf->MultiCell($n,5,$prev_den,'LR');
					$par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $par_totalcm=0; $par_totalam=0; $par_totalpm=0;
				}
				$prev_clave=$clave; $prev_den=$denomina_fuen;
				$pdf->SetFont('Arial','B',7); 
			}
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $sub_totalg=$sub_totalg+$asignado; $sub_totalf=$sub_totalf+$asig_actualizada;	
			$cat_totalg=$cat_totalg+$asignado; $cat_totalf=$cat_totalf+$asig_actualizada; $par_totalg=$par_totalg+$asignado; $par_totalf=$par_totalf+$asig_actualizada;			
			$totald=$totald+$disponible; $totale=$totale+$deuda; $sub_totald=$sub_totald+$disponible; $sub_totale=$sub_totale+$deuda; 
			$cat_totald=$cat_totald+$disponible; $cat_totale=$cat_totale+$deuda; $par_totald=$par_totald+$disponible; $par_totale=$par_totale+$deuda;
			$totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;  
			$cat_totalm=$cat_totalm+$modificaciones; $cat_totalc=$cat_totalc+$comprometido; $par_totalm=$par_totalm+$modificaciones; $par_totalc=$par_totalc+$comprometido;
		    $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado;  
			$cat_totala=$cat_totala+$causado; $cat_totalp=$cat_totalp+$pagado; $par_totala=$par_totala+$causado; $par_totalp=$par_totalp+$pagado;
			$par_totalcm=$par_totalcm+$compromisom; $par_totalam=$par_totalam+$causadom; $par_totalpm=$par_totalpm+$pagadom;
			$totalcm=$totalcm+$compromisom; $totalam=$totalam+$causadom; $totalpm=$totalpm+$pagadom;
			
		}$par_totalg=parte_entera_num($par_totalg);$par_totalf=parte_entera_num($par_totalf);  $par_totald=parte_entera_num($par_totald);  $par_totale=parte_entera_num($par_totale); 
		$par_totalc=parte_entera_num($par_totalc);$par_totala=parte_entera_num($par_totala);  $par_totalp=parte_entera_num($par_totalp);  $par_totalm=parte_entera_num($par_totalm); 
		$par_totalcm=parte_entera_num($par_totalcm);$par_totalam=parte_entera_num($par_totalam);  $par_totalpm=parte_entera_num($par_totalpm);
		$pdf->Cell(12,5,$prev_clave,'LR',0); 		   
		$x=$pdf->GetX();   $y=$pdf->GetY(); $n=122; 		   
		$pdf->SetXY($x+$n,$y);
		$pdf->Cell(21,5,$par_totalc,'LR',0,'R'); 
		$pdf->Cell(21,5,$par_totalcm,'LR',0,'R'); 	
		$pdf->Cell(21,5,$par_totala,'LR',0,'R');	   
		$pdf->Cell(21,5,$par_totalam,'LR',0,'R'); 
		$pdf->Cell(21,5,$par_totalp,'LR',0,'R');
		$pdf->Cell(21,5,$par_totalpm,'LR',1,'R');
		$pdf->SetXY($x,$y);
		$pdf->MultiCell($n,5,$prev_den,'LR');
		$sub_totalg=parte_entera_num($sub_totalg);$sub_totalf=parte_entera_num($sub_totalf);  $sub_totald=parte_entera_num($sub_totald);  $sub_totale=parte_entera_num($sub_totale); 
	    $sub_totalc=parte_entera_num($sub_totalc);$sub_totala=parte_entera_num($sub_totala);  $sub_totalp=parte_entera_num($sub_totalp);  $sub_totalm=parte_entera_num($sub_totalm); 
		
      	 
	    $pdf->SetFont('Arial','B',7); 
		$totalg=parte_entera_num($totalg);$totalf=parte_entera_num($totalf);  $totald=parte_entera_num($totald);  $totale=parte_entera_num($totale); 
		$totalc=parte_entera_num($totalc);$totala=parte_entera_num($totala);  $totalp=parte_entera_num($totalp);  $totalm=parte_entera_num($totalm); 
		$totalcm=parte_entera_num($totalcm);$totalam=parte_entera_num($totalam);  $totalpm=parte_entera_num($totalpm);
		$pdf->Cell(134,5,"TOTAL GENERAL ",1,0,'R'); 
		$pdf->Cell(21,5,$totalc,1,0,'R');
		$pdf->Cell(21,5,$totalcm,1,0,'R'); 					
		$pdf->Cell(21,5,$totala,1,0,'R'); 
		$pdf->Cell(21,5,$totalam,1,0,'R'); 
		$pdf->Cell(21,5,$totalp,1,0,'R'); 		
		$pdf->Cell(21,5,$totalpm,1,1,'R'); 	  
	  $pdf->Output();   
    }
	
  $StrSQL = "DELETE FROM pre020 Where (tipo_registro='9') And (nombre_usuario='".$cod_mov."')";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
  
?>

