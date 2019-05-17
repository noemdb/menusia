<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");    include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$cod_presup_d=$_GET["cod_presupd"];$cod_presup_h=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuented"];$cod_fuente_h=$_GET["cod_fuenteh"];$mes_desde=$_GET["mes_desde"];$mes_hasta=$_GET["mes_hasta"];$asig_global=$_GET["asig_global"]; $c_cat=$_GET["csubtotal"]; $cod_esp=$_GET["cod_esp"]; $cod_contab=$_GET["cod_contab"]; $tipo_rep=$_GET["tipo_rep"]; $det_modif=$_GET["det_modif"]; $most_gen=$_GET["most_gen"]; } 
else{$codigod="";$codigoh="";$fuented="";$fuenteh="";$fecha=""; $c_cat=0; $det_modif="NO";  $tipo_rep="HTML"; $most_gen="NO";}   $equipo=getenv("COMPUTERNAME"); $cod_mov="pre020".$usuario_sia; $php_os=PHP_OS; //$asig_global="N"; 
$mdes_cat=array("NINGUNA","","","","",""); $mcontrol = array (0,0,0,0,0,0,0,0,0,0);
function buscar_control($clave, $formato){  global $mcontrol;  $j=0;
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} }  
  return $actual;
}
function Rellenarcerosizq($str,$n){$numeroarellenar=$n-strlen($str); $texto=""; for ($i=0; $i < $numeroarellenar; $i++){$texto=$texto."0";} $texto=$texto.$str; return $texto;}
//function elimina_guion($str){$texto=""; for ($i=0; $i<strlen($str); $i++) { if (substr($str,$i, 1)=="-") {$texto=$texto; }  else {$texto=$texto.substr($str,$i, 1);}  } }

if ($mes_desde=='01'){$mesd="Enero";}elseif ($mes_desde=='02'){$mesd="Febrero";}elseif ($mes_desde=='03'){$mesd="Marzo";}elseif ($mes_desde=='04'){$mesd="Abril";}elseif ($mes_desde=='05'){$mesd="Mayo";}elseif ($mes_desde=='06'){$mesd="Junio";}elseif ($mes_desde=='07'){$mesd="Julio";}elseif ($mes_desde=='08'){$mesd="Agosto";}elseif ($mes_desde=='09'){$mesd="Septiembre";}elseif ($mes_desde=='10'){$mesd="Octubre";}elseif ($mes_desde=='11'){$mesd="Noviembre";}elseif ($mes_desde=='12'){$mesd="Diciembre";}
if ($mes_hasta=='01'){$mesh="Enero";}elseif ($mes_hasta=='02'){$mesh="Febrero";}elseif ($mes_hasta=='03'){$mesh="Marzo";}elseif ($mes_hasta=='04'){$mesh="Abril";}elseif ($mes_hasta=='05'){$mesh="Mayo";}elseif ($mes_hasta=='06'){$mesh="Junio";}elseif ($mes_hasta=='07'){$mesh="Julio";}elseif ($mes_hasta=='08'){$mesh="Agosto";}elseif ($mes_hasta=='09'){$mesh="Septiembre";}elseif ($mes_hasta=='10'){$mesh="Octubre";}elseif ($mes_hasta=='11'){$mesh="Noviembre";}elseif ($mes_hasta=='12'){$mesh="Diciembre";}

$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} }
   $mano=substr($Fec_Fin_Ejer,0,4);    $criterio1="Desde: ".$mesd." Hasta: ".$mesh." Ejercicio Fiscal: ".$mano;    $criterio2="";  

   if($cod_fuente_h==$cod_fuente_d){$sSQL="Select * from PRE095 WHERE cod_fuente_financ='$cod_fuente_d'";  $resultado=pg_query($sSQL); if($registro=pg_fetch_array($resultado,0)){$criterio1=$criterio1."  FUENTE : ".$registro["des_fuente_financ"];}
   }else{ if($cod_fuente_d=="01"){ $criterio1=$criterio1." "; }    }
   
   $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
   $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; $mdes_cat[1]=$registro["campo505"]; $mdes_cat[2]=$registro["campo507"]; $mdes_cat[3]=$registro["campo509"]; $mdes_cat[4]=$registro["campo511"]; $mdes_cat[5]=$registro["campo512"];}
   $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presup_d,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
   if($c_cat==0){$criterio_s=""; $ls=$c;}else{$criterio_s=$mdes_cat[$c_cat]; $ls=$mcontrol[$c_cat-1];}    
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
  
  if($cod_esp=="SI"){ $criterioc=" and (pre001.cod_contable='$cod_contab') ";} else {$criterioc="";}  $per_hasta=$mes_hasta;
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
   
   $StrSQL = "DELETE FROM pre020 Where (tipo_registro='2') And (nombre_usuario='".$cod_mov."')";
   $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
   if($asig_global=="S"){$sql_Asignacion="asignado,";}
  
  $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'2' as tipo_registro, cod_presup, cod_fuente, Denominacion,substr(cod_presup,1,".$ls.") as cod_categoria,"."'' as Denomina_cat,substr(cod_presup,".$ini.",".$p.") as cod_partida,'' as Denomina_Par,Status_Dist,Func_Inv,Ord_Cord,Aplicacion,Cod_Unidad_Ejec, ";
  $StrSQL=$StrSQL.$sql_Asignacion." Disponible,Disp_Diferida,".$sql_Compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.", "."0 as CompromisoM,0 as CausadoM, 0 as PagadoM, 0 as TrasladosM, 0 as TrasladonM, 0 as AdicionM, 0 as DisminucionM, 0 as DiferidoM ";
  
  $StrSQL=$StrSQL." FROM PRE001 WHERE length(cod_presup)=".$l_c." and ".$criterio.$criterioc;
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

  $ordenar=" ORDER BY pre020.cod_partida";
  if(($c_cat>0)or($tipo_rep=="EXCEL2")){ $ordenar=" ORDER BY pre020.cod_categoria,pre020.cod_partida,pre020.cod_fuente";
   $sSQL = "Select cod_presup,denominacion from pre001 WHERE cod_presup in (select distinct cod_categoria from pre020 where (tipo_registro='2') and (nombre_usuario='$cod_mov'))";  $res=pg_query($sSQL);
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_presup"]; $denominacion=$registro["denominacion"]; 
     $sql="update pre020 set denomina_cat='$denominacion' where tipo_registro='2' and nombre_usuario='$cod_mov' and cod_categoria='$cod_presup'";$resultado=pg_exec($conn,$sql); 
	 $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  }}
  
  //If($tipo_rep=="EXCEL2"){ $ordenar=" ORDER BY pre020.cod_categoria,pre020.cod_partida,pre020.cod_fuente"; }
  
  		$sSQL = "SELECT pre020.cod_presup,pre020.cod_fuente, pre020.denominacion,pre020.cod_categoria,pre020.denomina_cat,pre020.cod_partida, substring(pre020.cod_partida,1,3) as partida, substring(pre020.cod_partida,1,6) as generica, pre020.Asignado, pre020.Traslados, pre020.Trasladon, pre020.Adicion, 
			 pre020.disminucion, pre020.compromiso, pre020.causado, pre020.pagado, pre020.disponible, 
			(pre020.Traslados-pre020.Trasladon+pre020.Adicion-pre020.Disminucion) AS Modificaciones, (pre020.Traslados+pre020.Adicion) AS Aumentos, (pre020.Trasladon+pre020.Disminucion) AS Disminuciones,
			(pre020.Asignado+pre020.Traslados-pre020.Trasladon+pre020.Adicion-pre020.Disminucion) AS Asig_Actualizada, (pre020.Asignado+pre020.Traslados-pre020.Trasladon+pre020.Adicion-pre020.Disminucion-pre020.Compromiso) AS Disponibilidad
			 FROM pre020 WHERE tipo_registro='2' and nombre_usuario='$cod_mov' and ".$criterio.$ordenar;

    if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
	    if($c_cat==0){$nomb_rpt="Rpt_Ejec_Pre_Par.xml"; if($det_modif=="SI"){$nomb_rpt="Rpt_Ejec_Pre_Par_Modif.xml";} }
		  else{$nomb_rpt="Rpt_Ejec_Pre_Par_Subt.xml"; if($det_modif=="SI"){$nomb_rpt="Rpt_Ejec_Pre_Par_Subt_Modif.xml";} }
		
        $oRpt = new PHPReportMaker();
		$oRpt->setXML($nomb_rpt);
        $oRpt->setUser("$user");
        $oRpt->setPassword("$password");
        $oRpt->setConnection("$host");
        $oRpt->setDatabaseInterface("postgresql");
		$oRpt->setSQL($sSQL);
        $oRpt->setDatabase("$dbname");
		$oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"criterios"=>$criterio_s));          
        $oRpt->run();
    }
    if(($tipo_rep=="PDF")and($det_modif<>"SI")){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $criterio1; global $registro; global $c_cat; global $criterio_s; global $php_os;  global $tam_logo;
            $cod_presup_cat=$registro["cod_categoria"]; $denominacion_cat=$registro["denomina_cat"];   
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); }
		    		
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(130,10,'EJECUCION PRESUPUESTARIA POR PARTIDA',1,1,'C');
			$this->Ln(8);
			$this->SetFont('Arial','B',8);
			$this->Cell(100,5,$criterio1,0,1);
            if($c_cat>0){	
			  $this->SetFont('Arial','B',7);
              $this->MultiCell(260,4,$criterio_s.": ".$cod_presup_cat." ".$denominacion_cat,0,1);
			}
            $this->SetFont('Arial','B',6);					
			$this->Cell(15,5,'CODIGO',1,0);
			$this->Cell(85,5,'DENOMINACION',1,0);
			$this->Cell(20,5,'ASIGNACION',1,0,'C');
			$this->Cell(20,5,'MODIFICACIONES',1,0,'C');
			$this->Cell(20,5,'ACTUALIZADA',1,0,'C');
			$this->Cell(20,5,'COMPROMETIDO',1,0,'C');
			$this->Cell(20,5,'DISPONIBLE',1,0,'C');
			$this->Cell(20,5,'CAUSADO',1,0,'C');
			$this->Cell(20,5,'PAGADO',1,0,'C');			
			$this->Cell(20,5,'DEUDA',1,1,'C');
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
	  $pdf->SetFont('Arial','',5);
	  $i=0;  $totalg=0; $totalf=0; $totalm=0; $totalc=0; $totala=0; $totalp=0; $totald=0; $totale=0;
      $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $prev_clave="";  	  
	  $cat_totalg=0; $cat_totalf=0; $cat_totalm=0; $cat_totalc=0; $cat_totala=0; $cat_totalp=0; $cat_totald=0; $cat_totale=0; $prev_cat="";
      $par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par="";	$prev_den="";	
	  $gen_totalg=0; $gen_totalf=0; $gen_totalm=0; $gen_totalc=0; $gen_totala=0; $gen_totalp=0; $gen_totald=0; $gen_totale=0;  $prev_gen="";
	  //$pdf->MultiCell($n,3,$sSQL,0);	  
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  
		    $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["cod_fuente"]; $denominacion=$registro["denominacion"];  
			$cod_categoria=$registro["cod_categoria"]; $denominacion_cat=$registro["denomina_cat"];   $cod_partida=$registro["cod_partida"];  $clave=$registro["partida"]; $categoria=$cod_categoria;		
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; $clave_g=$registro["generica"];
			$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
			//if(($prev_clave<>$clave)or($prev_gen<>$clave_g)or(($categoria<>$prev_cat)and($c_cat>0))){ 
            //if(($prev_clave<>$clave)or($prev_gen<>$clave_g)){ 			    
			if(($prev_clave<>$clave)){ 			    
			    			
			    if($prev_par<>""){ 
				    $par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
					$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 
					$pdf->Cell(15,3,$prev_par,0,0); 		   
					$x=$pdf->GetX();   $y=$pdf->GetY(); $n=85; 		   
					$pdf->SetXY($x+$n,$y);
					$pdf->Cell(20,3,$par_totalg,0,0,'R'); 
					$pdf->Cell(20,3,$par_totalm,0,0,'R'); 
					$pdf->Cell(20,3,$par_totalf,0,0,'R'); 	
					$pdf->Cell(20,3,$par_totalc,0,0,'R');
					$pdf->Cell(20,3,$par_totald,0,0,'R');		   
					$pdf->Cell(20,3,$par_totala,0,0,'R'); 
					$pdf->Cell(20,3,$par_totalp,0,0,'R');
					$pdf->Cell(20,3,$par_totale,0,1,'R');
					$pdf->SetXY($x,$y);
					$pdf->MultiCell($n,3,$prev_den,0);
					$par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par=$cod_partida; $prev_den=$denominacion;
				}
				if ($prev_par==""){ $prev_par=$cod_partida; $prev_den=$denominacion;}
				$pdf->SetFont('Arial','B',5); 
				if(($prev_gen<>$clave_g)and($prev_gen<>"")and($most_gen=="SI")){ 
				    $gen_totalg=formato_monto($gen_totalg);$gen_totalf=formato_monto($gen_totalf);  $gen_totald=formato_monto($gen_totald);  $gen_totale=formato_monto($gen_totale); 
				    $gen_totalc=formato_monto($gen_totalc);$gen_totala=formato_monto($gen_totala);  $gen_totalp=formato_monto($gen_totalp);  $gen_totalm=formato_monto($gen_totalm); 
				    $pdf->Cell(100,1,'',0,0);
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,1,'R');
					$pdf->Cell(100,4,"Total ".$prev_gen." :",0,0,'R'); 
					$pdf->Cell(20,4,$gen_totalg,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totalm,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totalf,0,0,'R'); 					
					$pdf->Cell(20,4,$gen_totalc,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totald,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totala,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totalp,0,0,'R'); 					
					$pdf->Cell(20,4,$gen_totale,0,1,'R'); 
					$pdf->Ln(4);			
                    $prev_gen=$clave_g;   $gen_totalg=0; $gen_totalf=0; $gen_totalm=0; $gen_totalc=0; $gen_totala=0; $gen_totalp=0; $gen_totald=0; $gen_totale=0;					
				}
				if ($prev_gen==""){ $prev_gen=$clave_g; }
				
				if(($prev_clave<>$clave)and($prev_clave<>"")){ 
				    $sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
				    $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
				    $pdf->Cell(100,1,'',0,0);
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,1,'R');
					$pdf->Cell(100,4,"Total ".$prev_clave." :",0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalg,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalm,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalf,0,0,'R'); 					
					$pdf->Cell(20,4,$sub_totalc,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totald,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totala,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalp,0,0,'R'); 					
					$pdf->Cell(20,4,$sub_totale,0,1,'R'); 
					$pdf->Ln(4);			
                    $prev_clave=$clave;   $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0;					
				}
				if ($prev_clave==""){ $prev_clave=$clave;}
				if(($categoria<>$prev_cat)and($c_cat>0)and($prev_cat<>"")){ 
				    $cat_totalg=formato_monto($cat_totalg);$cat_totalf=formato_monto($cat_totalf);  $cat_totald=formato_monto($cat_totald);  $cat_totale=formato_monto($cat_totale); 
				    $cat_totalc=formato_monto($cat_totalc);$cat_totala=formato_monto($cat_totala);  $cat_totalp=formato_monto($cat_totalp);  $cat_totalm=formato_monto($cat_totalm); 
				    $pdf->Cell(100,1,'',0,0);
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,1,'R');
					$pdf->Cell(100,4,"Total ".$criterio_s." ".$prev_cat." : ",0,0,'R'); 
					$pdf->Cell(20,4,$cat_totalg,0,0,'R'); 
					$pdf->Cell(20,4,$cat_totalm,0,0,'R'); 
					$pdf->Cell(20,4,$cat_totalf,0,0,'R'); 					
					$pdf->Cell(20,4,$cat_totalc,0,0,'R'); 
					$pdf->Cell(20,4,$cat_totald,0,0,'R'); 
					$pdf->Cell(20,4,$cat_totala,0,0,'R'); 
					$pdf->Cell(20,4,$cat_totalp,0,0,'R'); 					
					$pdf->Cell(20,4,$cat_totale,0,1,'R'); 
					$pdf->AddPage();
                    $prev_cat=$categoria;	$cat_totalg=0; $cat_totalf=0; $cat_totalm=0; $cat_totalc=0; $cat_totala=0; $cat_totalp=0; $cat_totald=0; $cat_totale=0;				
				}
				if ($prev_cat==""){ $prev_cat=$categoria;}
				$pdf->SetFont('Arial','',5);	
				
            
			}
		    if(($prev_par<>$cod_partida)){
			    $par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
				$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 
				$pdf->Cell(15,3,$prev_par,0,0); 		   
				$x=$pdf->GetX();   $y=$pdf->GetY(); $n=85; 		   
				$pdf->SetXY($x+$n,$y);
				$pdf->Cell(20,3,$par_totalg,0,0,'R'); 
				$pdf->Cell(20,3,$par_totalm,0,0,'R'); 
				$pdf->Cell(20,3,$par_totalf,0,0,'R'); 	
				$pdf->Cell(20,3,$par_totalc,0,0,'R');
				$pdf->Cell(20,3,$par_totald,0,0,'R');		   
				$pdf->Cell(20,3,$par_totala,0,0,'R'); 
				$pdf->Cell(20,3,$par_totalp,0,0,'R');
				$pdf->Cell(20,3,$par_totale,0,1,'R');
				$pdf->SetXY($x,$y);
				$pdf->MultiCell($n,3,$prev_den,0);
				$par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par=$cod_partida; $prev_den=$denominacion;
			}	
			
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $sub_totalg=$sub_totalg+$asignado; $sub_totalf=$sub_totalf+$asig_actualizada;	
			$cat_totalg=$cat_totalg+$asignado; $cat_totalf=$cat_totalf+$asig_actualizada; $par_totalg=$par_totalg+$asignado; $par_totalf=$par_totalf+$asig_actualizada;			
			$totald=$totald+$disponible; $totale=$totale+$deuda; $sub_totald=$sub_totald+$disponible; $sub_totale=$sub_totale+$deuda; 
			$cat_totald=$cat_totald+$disponible; $cat_totale=$cat_totale+$deuda; $par_totald=$par_totald+$disponible; $par_totale=$par_totale+$deuda;
			$totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;  
			$cat_totalm=$cat_totalm+$modificaciones; $cat_totalc=$cat_totalc+$comprometido; $par_totalm=$par_totalm+$modificaciones; $par_totalc=$par_totalc+$comprometido;
		    $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado;  
			$cat_totala=$cat_totala+$causado; $cat_totalp=$cat_totalp+$pagado; $par_totala=$par_totala+$causado; $par_totalp=$par_totalp+$pagado;			
			$gen_totalg=$gen_totalg+$asignado; $gen_totalf=$gen_totalf+$asig_actualizada; $gen_totald=$gen_totald+$disponible; $gen_totale=$gen_totale+$deuda; 
		    $gen_totalm=$gen_totalm+$modificaciones; $gen_totalc=$gen_totalc+$comprometido; $gen_totala=$gen_totala+$causado; $gen_totalp=$gen_totalp+$pagado; 			
			if($c_cat==100){
			    $modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
		        $disponible=formato_monto($disponible); $asignado=formato_monto($asignado);  $asig_actualizada=formato_monto($asig_actualizada);   $deuda=formato_monto($deuda); 
		        $pdf->Cell(15,3,$cod_partida,0,0); 		   
				$x=$pdf->GetX();   $y=$pdf->GetY(); $n=85; 		   
				$pdf->SetXY($x+$n,$y);
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
				$par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par=$cod_partida; $prev_den=$denominacion;
			}				
		}$par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
		$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 
		$pdf->Cell(15,3,$prev_par,0,0); 		   
		$x=$pdf->GetX();   $y=$pdf->GetY(); $n=85; 		   
		$pdf->SetXY($x+$n,$y);
		$pdf->Cell(20,3,$par_totalg,0,0,'R'); 
		$pdf->Cell(20,3,$par_totalm,0,0,'R'); 
		$pdf->Cell(20,3,$par_totalf,0,0,'R'); 	
		$pdf->Cell(20,3,$par_totalc,0,0,'R');
		$pdf->Cell(20,3,$par_totald,0,0,'R');		   
		$pdf->Cell(20,3,$par_totala,0,0,'R'); 
		$pdf->Cell(20,3,$par_totalp,0,0,'R');
		$pdf->Cell(20,3,$par_totale,0,1,'R');
		$pdf->SetXY($x,$y);
		$pdf->MultiCell($n,3,$prev_den,0);
		$pdf->SetFont('Arial','B',5); 
		if($most_gen=="SI"){ 
				    $gen_totalg=formato_monto($gen_totalg);$gen_totalf=formato_monto($gen_totalf);  $gen_totald=formato_monto($gen_totald);  $gen_totale=formato_monto($gen_totale); 
				    $gen_totalc=formato_monto($gen_totalc);$gen_totala=formato_monto($gen_totala);  $gen_totalp=formato_monto($gen_totalp);  $gen_totalm=formato_monto($gen_totalm); 
				    $pdf->Cell(100,1,'',0,0);
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,1,'R');
					$pdf->Cell(100,4,"Total ".$prev_gen." :",0,0,'R'); 
					$pdf->Cell(20,4,$gen_totalg,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totalm,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totalf,0,0,'R'); 					
					$pdf->Cell(20,4,$gen_totalc,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totald,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totala,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totalp,0,0,'R'); 					
					$pdf->Cell(20,4,$gen_totale,0,1,'R'); 
					$pdf->Ln(4);			
        }
				
		$sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
	    $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		$pdf->SetFont('Arial','B',5); 
		$pdf->Cell(100,1,'',0,0);
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,1,'R');		
		$pdf->Cell(100,4,"Total ".$prev_clave." : ",0,0,'R');
		$pdf->Cell(20,4,$sub_totalg,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalm,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalf,0,0,'R'); 					
		$pdf->Cell(20,4,$sub_totalc,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totald,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totala,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalp,0,0,'R'); 		
		$pdf->Cell(20,4,$sub_totale,0,1,'R'); 
		$pdf->Ln(5);
		if($c_cat>0){
		$cat_totalg=formato_monto($cat_totalg);$cat_totalf=formato_monto($cat_totalf);  $cat_totald=formato_monto($cat_totald);  $cat_totale=formato_monto($cat_totale); 
		$cat_totalc=formato_monto($cat_totalc);$cat_totala=formato_monto($cat_totala);  $cat_totalp=formato_monto($cat_totalp);  $cat_totalm=formato_monto($cat_totalm); 
		$pdf->Cell(100,1,'',0,0);
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,1,'R');
		$pdf->Cell(100,4,"Total ".$criterio_s." ".$prev_cat." : ",0,0,'R'); 
		$pdf->Cell(20,4,$cat_totalg,0,0,'R'); 
		$pdf->Cell(20,4,$cat_totalm,0,0,'R'); 
		$pdf->Cell(20,4,$cat_totalf,0,0,'R'); 					
		$pdf->Cell(20,4,$cat_totalc,0,0,'R'); 
		$pdf->Cell(20,4,$cat_totald,0,0,'R'); 
		$pdf->Cell(20,4,$cat_totala,0,0,'R'); 
		$pdf->Cell(20,4,$cat_totalp,0,0,'R'); 					
		$pdf->Cell(20,4,$cat_totale,0,1,'R'); 
		$pdf->Ln(5);}
		$totalg=formato_monto($totalg);$totalf=formato_monto($totalf);  $totald=formato_monto($totald);  $totale=formato_monto($totale); 
	    $totalc=formato_monto($totalc);$totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm); 
		$pdf->Cell(100,2,'',0,0);
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,1,'R');
		$pdf->Cell(100,4,"Total General : ",0,0,'R'); 
		$pdf->Cell(20,4,$totalg,0,0,'R'); 
		$pdf->Cell(20,4,$totalm,0,0,'R'); 
		$pdf->Cell(20,4,$totalf,0,0,'R'); 					
		$pdf->Cell(20,4,$totalc,0,0,'R'); 
		$pdf->Cell(20,4,$totald,0,0,'R'); 
		$pdf->Cell(20,4,$totala,0,0,'R'); 
		$pdf->Cell(20,4,$totalp,0,0,'R'); 		
		$pdf->Cell(20,4,$totale,0,1,'R'); 
		$pdf->Output();   
    }
	if(($tipo_rep=="PDF")and($det_modif=="SI")){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $criterio1; global $registro; global $c_cat; global $criterio_s; global $tam_logo;
            $cod_presup_cat=$registro["cod_categoria"]; $denominacion_cat=$registro["denomina_cat"];   
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); }
		    		
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(130,10,'EJECUCION PRESUPUESTARIA POR PARTIDA',1,1,'C');
			$this->Ln(8);
			$this->SetFont('Arial','B',8);
			$this->Cell(100,5,$criterio1,0,1);
            if($c_cat>0){	
			  $this->SetFont('Arial','B',7);
              $this->Cell(200,4,$criterio_s.": ".$cod_presup_cat." ".$denominacion_cat,0,1);
			}
            $this->SetFont('Arial','B',6);					
			$this->Cell(15,5,'CODIGO',1,0);
			$this->Cell(80,5,'DENOMINACION',1,0);
			$this->Cell(20,5,'ASIGNACION',1,0,'C');
			$this->Cell(15,5,'AUMENTOS',1,0,'C');
			$this->SetFont('Arial','B',5);	
			$this->Cell(15,5,'DISMINUCIONES',1,0,'C');
			$this->SetFont('Arial','B',6);	
			$this->Cell(20,5,'ACTUALIZADA',1,0,'C');
			$this->Cell(20,5,'COMPROMETIDO',1,0,'C');
			$this->Cell(20,5,'DISPONIBLE',1,0,'C');
			$this->Cell(20,5,'CAUSADO',1,0,'C');
			$this->Cell(20,5,'PAGADO',1,0,'C');			
			$this->Cell(15,5,'DEUDA',1,1,'C');
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
	  $pdf->SetFont('Arial','',5);
	  $i=0;  $totalg=0; $totalf=0; $totalm=0; $totaln=0; $totalo=0;  $totalc=0; $totala=0; $totalp=0; $totald=0; $totale=0;
      $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totaln=0; $sub_totalo=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $prev_clave="";  	  
	  $cat_totalg=0; $cat_totalf=0; $cat_totalm=0; $cat_totaln=0; $cat_totalo=0; $cat_totalc=0; $cat_totala=0; $cat_totalp=0; $cat_totald=0; $cat_totale=0; $prev_cat="";
      $par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totaln=0; $par_totalo=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par="";	$prev_den="";	  
	  $gen_totalg=0; $gen_totalf=0; $gen_totalm=0; $gen_totalc=0; $gen_totala=0; $gen_totalp=0; $gen_totald=0; $gen_totale=0; $gen_totalo=0; $gen_totaln=0; $prev_gen="";
	  while($registro=pg_fetch_array($res)){ $i=$i+1;  
		    $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"];  
			$cod_categoria=$registro["cod_categoria"]; $denominacion_cat=$registro["denomina_cat"];   $cod_partida=$registro["cod_partida"];  $clave=$registro["partida"]; $clave_g=$registro["generica"]; $categoria=$cod_categoria;		
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; $aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];	
			$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
			
			if(($prev_clave<>$clave)or($prev_gen<>$clave_g)or(($categoria<>$prev_cat)and($c_cat>0))){ 			    
			    if($prev_par<>""){ 
				    $par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
					$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 
					$par_totaln=formato_monto($par_totaln); $par_totalo=formato_monto($par_totalo); 
					$pdf->Cell(15,3,$prev_par,0,0); 		   
					$x=$pdf->GetX();   $y=$pdf->GetY(); $n=80; 		   
					$pdf->SetXY($x+$n,$y);
					$pdf->Cell(20,3,$par_totalg,0,0,'R'); 
					$pdf->Cell(15,3,$par_totalo,0,0,'R'); 
					$pdf->Cell(15,3,$par_totaln,0,0,'R'); 
					$pdf->Cell(20,3,$par_totalf,0,0,'R'); 	
					$pdf->Cell(20,3,$par_totalc,0,0,'R');
					$pdf->Cell(20,3,$par_totald,0,0,'R');		   
					$pdf->Cell(20,3,$par_totala,0,0,'R'); 
					$pdf->Cell(20,3,$par_totalp,0,0,'R');
					$pdf->Cell(15,3,$par_totale,0,1,'R');
					$pdf->SetXY($x,$y);
					$pdf->MultiCell($n,3,$prev_den,0);
					$par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totaln=0; $par_totalo=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par=$cod_partida; $prev_den=$denominacion;
				}
				if ($prev_par==""){ $prev_par=$cod_partida; $prev_den=$denominacion;}
				$pdf->SetFont('Arial','B',5); 
				if(($prev_gen<>$clave_g)and($prev_gen<>"")and($most_gen=="SI")){ 
				    $gen_totalg=formato_monto($gen_totalg);$gen_totalf=formato_monto($gen_totalf);  $gen_totald=formato_monto($gen_totald);  $gen_totale=formato_monto($gen_totale); 
				    $gen_totalc=formato_monto($gen_totalc);$gen_totala=formato_monto($gen_totala);  $gen_totalp=formato_monto($gen_totalp);  $gen_totalm=formato_monto($gen_totalm); 
					$gen_totalo=formato_monto($gen_totalo);  $gen_totaln=formato_monto($gen_totaln); 
				    $pdf->Cell(95,1,'',0,0);
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(15,1,'__________________',0,0,'R');
					$pdf->Cell(15,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(15,1,'__________________',0,1,'R');
					$pdf->Cell(95,4,"Total ".$prev_gen." :",0,0,'R'); 
					$pdf->Cell(20,4,$gen_totalg,0,0,'R'); 
					$pdf->Cell(15,4,$gen_totalo,0,0,'R'); 
					$pdf->Cell(15,4,$gen_totaln,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totalf,0,0,'R'); 					
					$pdf->Cell(20,4,$gen_totalc,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totald,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totala,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totalp,0,0,'R'); 					
					$pdf->Cell(15,4,$gen_totale,0,1,'R'); 
					$pdf->Ln(4);			
                    $prev_gen=$clave_g;   $gen_totalg=0; $gen_totalf=0; $gen_totalm=0; $gen_totalo=0; $gen_totaln=0; $gen_totalc=0; $gen_totala=0; $gen_totalp=0; $gen_totald=0; $gen_totale=0;					
				}
				if ($prev_gen==""){ $prev_gen=$clave_g; }
				
				if(($prev_clave<>$clave)and($prev_clave<>"")){ 
				    $sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
				    $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
				    $sub_totaln=formato_monto($sub_totaln);$sub_totalo=formato_monto($sub_totalo); 
					$pdf->Cell(95,1,'',0,0);
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(15,1,'__________________',0,0,'R');
					$pdf->Cell(15,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(15,1,'__________________',0,1,'R');
					$pdf->Cell(95,4,"Total ".$prev_clave." :",0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalg,0,0,'R'); 
					$pdf->Cell(15,4,$sub_totalo,0,0,'R'); 
					$pdf->Cell(15,4,$sub_totaln,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalf,0,0,'R'); 					
					$pdf->Cell(20,4,$sub_totalc,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totald,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totala,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalp,0,0,'R'); 					
					$pdf->Cell(15,4,$sub_totale,0,1,'R'); 
					$pdf->Ln(4);	
                    $prev_clave=$clave;   $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totaln=0; $sub_totalo=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0;
     					
				}
				if ($prev_clave==""){ $prev_clave=$clave;}
				
				if(($categoria<>$prev_cat)and($c_cat>0)and($prev_cat<>"")){ 
				    $cat_totalg=formato_monto($cat_totalg);$cat_totalf=formato_monto($cat_totalf);  $cat_totald=formato_monto($cat_totald);  $cat_totale=formato_monto($cat_totale); 
				    $cat_totalc=formato_monto($cat_totalc);$cat_totala=formato_monto($cat_totala);  $cat_totalp=formato_monto($cat_totalp);  $cat_totalm=formato_monto($cat_totalm); 
				    $cat_totaln=formato_monto($cat_totaln);$cat_totalo=formato_monto($cat_totalo); 
					$pdf->Cell(95,1,'',0,0);
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(15,1,'__________________',0,0,'R');
					$pdf->Cell(15,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(15,1,'__________________',0,1,'R');
					$pdf->Cell(95,4,"Total ".$criterio_s." ".$prev_cat." : ",0,0,'R'); 
					$pdf->Cell(20,4,$cat_totalg,0,0,'R'); 
					$pdf->Cell(15,4,$cat_totalo,0,0,'R'); 
					$pdf->Cell(15,4,$cat_totaln,0,0,'R'); 
					$pdf->Cell(20,4,$cat_totalf,0,0,'R'); 					
					$pdf->Cell(20,4,$cat_totalc,0,0,'R'); 
					$pdf->Cell(20,4,$cat_totald,0,0,'R'); 
					$pdf->Cell(20,4,$cat_totala,0,0,'R'); 
					$pdf->Cell(20,4,$cat_totalp,0,0,'R'); 					
					$pdf->Cell(15,4,$cat_totale,0,1,'R'); 
					$pdf->AddPage();
                    $prev_cat=$categoria;	$cat_totalg=0; $cat_totalf=0; $cat_totalm=0; $cat_totaln=0; $cat_totalo=0; $cat_totalc=0; $cat_totala=0; $cat_totalp=0; $cat_totald=0; $cat_totale=0;				
				}
				if ($prev_cat==""){ $prev_cat=$categoria;}
				$pdf->SetFont('Arial','',5);	
				       
			}
		    if(($prev_par<>$cod_partida)){
			    $par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
				$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 
				$par_totaln=formato_monto($par_totaln); $par_totalo=formato_monto($par_totalo); 
				$pdf->Cell(15,3,$prev_par,0,0); 		   
				$x=$pdf->GetX();   $y=$pdf->GetY(); $n=80; 		   
				$pdf->SetXY($x+$n,$y);
				$pdf->Cell(20,3,$par_totalg,0,0,'R'); 
				$pdf->Cell(15,3,$par_totalo,0,0,'R'); 
		        $pdf->Cell(15,3,$par_totaln,0,0,'R'); 
				$pdf->Cell(20,3,$par_totalf,0,0,'R'); 	
				$pdf->Cell(20,3,$par_totalc,0,0,'R');
				$pdf->Cell(20,3,$par_totald,0,0,'R');		   
				$pdf->Cell(20,3,$par_totala,0,0,'R'); 
				$pdf->Cell(20,3,$par_totalp,0,0,'R');
				$pdf->Cell(15,3,$par_totale,0,1,'R');
				$pdf->SetXY($x,$y);
				$pdf->MultiCell($n,3,$prev_den,0);
				$par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totaln=0; $par_totalo=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par=$cod_partida; $prev_den=$denominacion;
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
			$gen_totalg=$gen_totalg+$asignado; $gen_totalf=$gen_totalf+$asig_actualizada; $gen_totald=$gen_totald+$disponible; $gen_totale=$gen_totale+$deuda; 
		    $gen_totalm=$gen_totalm+$modificaciones; $gen_totalc=$gen_totalc+$comprometido; $gen_totala=$gen_totala+$causado; $gen_totalp=$gen_totalp+$pagado;
		    $gen_totalo=$gen_totalo+$aumentos; $gen_totaln=$gen_totaln+$disminuciones;
			
			if($c_cat==100){
			    $modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
		        $disponible=formato_monto($disponible); $asignado=formato_monto($asignado);  $asig_actualizada=formato_monto($asig_actualizada);   $deuda=formato_monto($deuda); 
		        $aumentos=formato_monto($aumentos); $disminuciones=formato_monto($disminuciones);
				$pdf->Cell(15,3,$cod_partida,0,0); 		   
				$x=$pdf->GetX();   $y=$pdf->GetY(); $n=80; 		   
				$pdf->SetXY($x+$n,$y);
				$pdf->Cell(20,3,$asignado,0,0,'R'); 
				$pdf->Cell(15,3,$aumentos,0,0,'R'); 
				$pdf->Cell(15,3,$disminuciones,0,0,'R'); 
				$pdf->Cell(20,3,$asig_actualizada,0,0,'R'); 	
				$pdf->Cell(20,3,$comprometido,0,0,'R');
				$pdf->Cell(20,3,$disponible,0,0,'R');		   
				$pdf->Cell(20,3,$causado,0,0,'R'); 
				$pdf->Cell(20,3,$pagado,0,0,'R');
				$pdf->Cell(15,3,$deuda,0,1,'R');
				$pdf->SetXY($x,$y);
				$pdf->MultiCell($n,3,$denominacion,0);
				$par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totaln=0; $par_totalo=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par=$cod_partida; $prev_den=$denominacion;
			}				
		}$par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
		$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 
		$par_totaln=formato_monto($par_totaln); $par_totalo=formato_monto($par_totalo); 
		$pdf->Cell(15,3,$prev_par,0,0); 		   
		$x=$pdf->GetX();   $y=$pdf->GetY(); $n=80; 		   
		$pdf->SetXY($x+$n,$y);
		$pdf->Cell(20,3,$par_totalg,0,0,'R'); 
		$pdf->Cell(15,3,$par_totalo,0,0,'R'); 
		$pdf->Cell(15,3,$par_totaln,0,0,'R'); 
		$pdf->Cell(20,3,$par_totalf,0,0,'R'); 	
		$pdf->Cell(20,3,$par_totalc,0,0,'R');
		$pdf->Cell(20,3,$par_totald,0,0,'R');		   
		$pdf->Cell(20,3,$par_totala,0,0,'R'); 
		$pdf->Cell(20,3,$par_totalp,0,0,'R');
		$pdf->Cell(15,3,$par_totale,0,1,'R');
		$pdf->SetXY($x,$y);
		$pdf->MultiCell($n,3,$prev_den,0);
		
		$pdf->SetFont('Arial','B',5); 
		if(($most_gen=="SI")){ 
				    $gen_totalg=formato_monto($gen_totalg);$gen_totalf=formato_monto($gen_totalf);  $gen_totald=formato_monto($gen_totald);  $gen_totale=formato_monto($gen_totale); 
				    $gen_totalc=formato_monto($gen_totalc);$gen_totala=formato_monto($gen_totala);  $gen_totalp=formato_monto($gen_totalp);  $gen_totalm=formato_monto($gen_totalm); 
					$gen_totalo=formato_monto($gen_totalo);  $gen_totaln=formato_monto($gen_totaln); 
				    $pdf->Cell(95,1,'',0,0);
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(15,1,'__________________',0,0,'R');
					$pdf->Cell(15,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(20,1,'__________________',0,0,'R');
					$pdf->Cell(15,1,'__________________',0,1,'R');
					$pdf->Cell(95,4,"Total ".$prev_gen." :",0,0,'R'); 
					$pdf->Cell(20,4,$gen_totalg,0,0,'R'); 
					$pdf->Cell(15,4,$gen_totalo,0,0,'R'); 
					$pdf->Cell(15,4,$gen_totaln,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totalf,0,0,'R'); 					
					$pdf->Cell(20,4,$gen_totalc,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totald,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totala,0,0,'R'); 
					$pdf->Cell(20,4,$gen_totalp,0,0,'R'); 					
					$pdf->Cell(15,4,$gen_totale,0,1,'R'); 
					$pdf->Ln(4);			
        }
		$sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
	    $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		$sub_totaln=formato_monto($sub_totaln);$sub_totalo=formato_monto($sub_totalo); 
		$pdf->SetFont('Arial','B',5); 
		$pdf->Cell(95,1,'',0,0);
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(15,1,'__________________',0,0,'R');
		$pdf->Cell(15,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(15,1,'__________________',0,1,'R');		
		$pdf->Cell(95,4,"Total ".$prev_clave." : ",0,0,'R');
		$pdf->Cell(20,4,$sub_totalg,0,0,'R'); 
		$pdf->Cell(15,4,$sub_totalo,0,0,'R'); 
		$pdf->Cell(15,4,$sub_totaln,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalf,0,0,'R'); 					
		$pdf->Cell(20,4,$sub_totalc,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totald,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totala,0,0,'R'); 
		$pdf->Cell(20,4,$sub_totalp,0,0,'R'); 		
		$pdf->Cell(15,4,$sub_totale,0,1,'R'); 
		$pdf->Ln(5);
		if($c_cat>0){
		$cat_totalg=formato_monto($cat_totalg);$cat_totalf=formato_monto($cat_totalf);  $cat_totald=formato_monto($cat_totald);  $cat_totale=formato_monto($cat_totale); 
		$cat_totalc=formato_monto($cat_totalc);$cat_totala=formato_monto($cat_totala);  $cat_totalp=formato_monto($cat_totalp);  $cat_totalm=formato_monto($cat_totalm); 
		$cat_totaln=formato_monto($cat_totaln); $cat_totalo=formato_monto($cat_totalo); 
		$pdf->Cell(95,1,'',0,0);
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(15,1,'__________________',0,0,'R');
		$pdf->Cell(15,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(20,1,'__________________',0,0,'R');
		$pdf->Cell(15,1,'__________________',0,1,'R');	
		$pdf->Cell(95,4,"Total ".$criterio_s." ".$prev_cat." : ",0,0,'R'); 
		$pdf->Cell(20,4,$cat_totalg,0,0,'R'); 
		$pdf->Cell(15,4,$cat_totalo,0,0,'R'); 
		$pdf->Cell(15,4,$cat_totaln,0,0,'R'); 
		$pdf->Cell(20,4,$cat_totalf,0,0,'R'); 					
		$pdf->Cell(20,4,$cat_totalc,0,0,'R'); 
		$pdf->Cell(20,4,$cat_totald,0,0,'R'); 
		$pdf->Cell(20,4,$cat_totala,0,0,'R'); 
		$pdf->Cell(20,4,$cat_totalp,0,0,'R'); 					
		$pdf->Cell(15,4,$cat_totale,0,1,'R'); 
		$pdf->Ln(5);}
		$totalg=formato_monto($totalg);$totalf=formato_monto($totalf);  $totald=formato_monto($totald);  $totale=formato_monto($totale); 
	    $totalc=formato_monto($totalc);$totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm); 
		$totaln=formato_monto($totaln);$totalo=formato_monto($totalo); 
		$pdf->Cell(95,2,'',0,0);
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(15,2,'================',0,0,'R');
		$pdf->Cell(15,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(20,2,'================',0,0,'R');
		$pdf->Cell(15,2,'================',0,1,'R');
		$pdf->Cell(95,4,"Total General : ",0,0,'R'); 
		$pdf->Cell(20,4,$totalg,0,0,'R'); 
		$pdf->Cell(15,4,$totalo,0,0,'R');
        $pdf->Cell(15,4,$totaln,0,0,'R');		
		$pdf->Cell(20,4,$totalf,0,0,'R'); 					
		$pdf->Cell(20,4,$totalc,0,0,'R'); 
		$pdf->Cell(20,4,$totald,0,0,'R'); 
		$pdf->Cell(20,4,$totala,0,0,'R'); 
		$pdf->Cell(20,4,$totalp,0,0,'R'); 		
		$pdf->Cell(15,4,$totale,0,1,'R'); 
		$pdf->Output();   
    }
	if($tipo_rep=="EXCEL"){	
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Ejecucion_pre_partida.xls");
		?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
			<td width="140" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>EJECUCION PRESUPUESTARIA POR PARTIDA</strong></font></td>
		 </tr>
		 <tr height="20">
		    <td width="140" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1; ?></strong></font></td>
		 </tr>
		 <tr height="20">
		   <td width="140" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Codigo</strong></td>
		   <td width="400" align="left" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Asignacion</strong></td>		   
		   <?if($det_modif=="SI"){?><td width="120" align="right" bgcolor="#99CCFF" ><strong>Aumentos</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Disminuciones</strong></td>
		   <?}else{?><td width="120" align="right" bgcolor="#99CCFF" ><strong>Modificaciones</strong></td><?}?>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Asig.Actualizada</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Comprometido</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Disponible</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Causado</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Pagado</strong></td>		  
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Deuda</strong></td> 		   
		 </tr>
		<?$i=0;  $totalg=0; $totalf=0; $totalm=0; $totaln=0; $totalo=0;  $totalc=0; $totala=0; $totalp=0; $totald=0; $totale=0;
        $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totaln=0; $sub_totalo=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $prev_clave="";  	  
	    $cat_totalg=0; $cat_totalf=0; $cat_totalm=0; $cat_totaln=0; $cat_totalo=0; $cat_totalc=0; $cat_totala=0; $cat_totalp=0; $cat_totald=0; $cat_totale=0; $prev_cat="";
        $par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totaln=0; $par_totalo=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par="";	$prev_den="";	  
	    $gen_totalg=0; $gen_totalf=0; $gen_totalm=0; $gen_totalc=0; $gen_totala=0; $gen_totalp=0; $gen_totald=0; $gen_totale=0;  $prev_gen="";
	  
		$res=pg_query($sSQL); $filas=pg_num_rows($res); 
		while($registro=pg_fetch_array($res)){ $i=$i+1;  
		    $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"];  
			$cod_categoria=$registro["cod_categoria"]; $denominacion_cat=$registro["denomina_cat"];   $cod_partida=$registro["cod_partida"];    $clave=$registro["partida"]; $clave_g=$registro["generica"]; $categoria=$cod_categoria;	
			$denominacion=conv_cadenas($denominacion,0); $denominacion_cat=conv_cadenas($denominacion_cat,0); 
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
			$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
			$aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];	
			if(($prev_clave<>$clave)or($prev_gen<>$clave_g)or(($categoria<>$prev_cat)and($c_cat>0))){ 			    
			    if($prev_par<>""){ 
				    $par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
					$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 
					$par_totaln=formato_monto($par_totaln); $par_totalo=formato_monto($par_totalo); 
			    ?>	   
					<tr>
					   <td width="140" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $prev_par; ?></td>
					   <td width="400" align="justify"><? echo $prev_den; ?></td>				   
					   <td width="120" align="right"><? echo $par_totalg; ?></td>
					   <?if($det_modif=="SI"){?><td width="120" align="right"><? echo $par_totalo; ?></td>
					   <td width="120" align="right"><? echo $par_totaln; ?></td>
					   <?}else{?><td width="120" align="right"><? echo $par_totalm; ?></td><?}?>
					   <td width="120" align="right"><? echo $par_totalf; ?></td>
					   <td width="120" align="right"><? echo $par_totalc; ?></td>
					   <td width="120" align="right"><? echo $par_totald; ?></td>
					   <td width="120" align="right"><? echo $par_totala; ?></td>
					   <td width="120" align="right"><? echo $par_totalp; ?></td>
					   <td width="120" align="right"><? echo $par_totale; ?></td>
					 </tr>
					<? 
					$par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totaln=0; $par_totalo=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par=$cod_partida; $prev_den=$denominacion;
				}
				if ($prev_par==""){ $prev_par=$cod_partida; $prev_den=$denominacion;}
				if(($prev_gen<>$clave_g)and($prev_gen<>"")and($most_gen=="SI")){ 
				    $gen_totalg=formato_monto($gen_totalg);$gen_totalf=formato_monto($gen_totalf);  $gen_totald=formato_monto($gen_totald);  $gen_totale=formato_monto($gen_totale); 
				    $gen_totalc=formato_monto($gen_totalc);$gen_totala=formato_monto($gen_totala);  $gen_totalp=formato_monto($gen_totalp);  $gen_totalm=formato_monto($gen_totalm); 
					$gen_totalo=formato_monto($gen_totalo);  $gen_totaln=formato_monto($gen_totaln); 
				    ?>	 				 
					<tr>
					  <td width="140" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="120" align="right">-----------------</td>
					  <?if($det_modif=="SI"){?><td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <?}else{?><td width="120" align="right">-----------------</td><?}?>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					</tr>	
					<tr>
					  <td width="140" align="left"></td>
					  <td width="400" align="right"><? echo "Total ".$prev_gen." :"; ?></td>
					  <td width="120" align="right"><? echo $gen_totalg; ?></td>
					  <?if($det_modif=="SI"){?><td width="120" align="right"><? echo $gen_totalo; ?></td>
					  <td width="120" align="right"><? echo $gen_totaln; ?></td>
					  <?}else{?><td width="120" align="right"><? echo $gen_totalm; ?></td><?}?>
					  <td width="120" align="right"><? echo $gen_totalf; ?></td> 
					  <td width="120" align="right"><? echo $gen_totalc; ?></td>
					  <td width="120" align="right"><? echo $gen_totald; ?></td>
					  <td width="120" align="right"><? echo $gen_totala; ?></td>
					  <td width="120" align="right"><? echo $gen_totalp; ?></td>			  
					  <td width="120" align="right"><? echo $gen_totale; ?></td>
					</tr>
				    <?
					
                    $prev_gen=$clave_g;   $gen_totalg=0; $gen_totalf=0; $gen_totalm=0; $gen_totalo=0; $gen_totaln=0; $gen_totalc=0; $gen_totala=0; $gen_totalp=0; $gen_totald=0; $gen_totale=0;					
				}
				if ($prev_gen==""){ $prev_gen=$clave_g; }
				
				if(($prev_clave<>$clave)and($prev_clave<>"")){ 
				    $sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
				    $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
				    $sub_totaln=formato_monto($sub_totaln);$sub_totalo=formato_monto($sub_totalo); 
				   ?>	 				 
					<tr>
					  <td width="140" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="120" align="right">-----------------</td>
					  <?if($det_modif=="SI"){?><td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <?}else{?><td width="120" align="right">-----------------</td><?}?>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					</tr>	
					<tr>
					  <td width="140" align="left"></td>
					  <td width="400" align="right"><? echo "Total ".$prev_clave." :"; ?></td>
					  <td width="120" align="right"><? echo $sub_totalg; ?></td>
					  <?if($det_modif=="SI"){?><td width="120" align="right"><? echo $sub_totalo; ?></td>
					  <td width="120" align="right"><? echo $sub_totaln; ?></td>
					  <?}else{?><td width="120" align="right"><? echo $sub_totalm; ?></td><?}?>
					  <td width="120" align="right"><? echo $sub_totalf; ?></td> 
					  <td width="120" align="right"><? echo $sub_totalc; ?></td>
					  <td width="120" align="right"><? echo $sub_totald; ?></td>
					  <td width="120" align="right"><? echo $sub_totala; ?></td>
					  <td width="120" align="right"><? echo $sub_totalp; ?></td>			  
					  <td width="120" align="right"><? echo $sub_totale; ?></td>
					</tr>
					<tr height="20">
					    <td width="140" align="left"><strong></strong></td>
					    <td width="400" align="center"> </td>
				    </tr>
				    <?
                    $prev_clave=$clave;   $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totaln=0; $sub_totalo=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0;
      					
				}
				if ($prev_clave==""){ $prev_clave=$clave; }
				if(($categoria<>$prev_cat)and($c_cat>0)and($prev_cat<>"")){ 
				    $cat_totalg=formato_monto($cat_totalg);$cat_totalf=formato_monto($cat_totalf);  $cat_totald=formato_monto($cat_totald);  $cat_totale=formato_monto($cat_totale); 
				    $cat_totalc=formato_monto($cat_totalc);$cat_totala=formato_monto($cat_totala);  $cat_totalp=formato_monto($cat_totalp);  $cat_totalm=formato_monto($cat_totalm); 
				    $cat_totaln=formato_monto($cat_totaln);$cat_totalo=formato_monto($cat_totalo); 
					?>	 				 
					<tr>
					  <td width="140" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="120" align="right">-----------------</td>
					  <?if($det_modif=="SI"){?><td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <?}else{?><td width="120" align="right">-----------------</td><?}?>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					</tr>	
					<tr>
					  <td width="140" align="left"></td>
					  <td width="400" align="right"><? echo "Total ".$criterio_s." ".$prev_cat." : "; ?></td>
					  <td width="120" align="right"><? echo $cat_totalg; ?></td>
					  <?if($det_modif=="SI"){?><td width="120" align="right"><? echo $cat_totalo; ?></td>
					  <td width="120" align="right"><? echo $cat_totaln; ?></td>
					  <?}else{?><td width="120" align="right"><? echo $cat_totalm; ?></td><?}?>
					  <td width="120" align="right"><? echo $cat_totalf; ?></td> 
					  <td width="120" align="right"><? echo $cat_totalc; ?></td>
					  <td width="120" align="right"><? echo $cat_totald; ?></td>
					  <td width="120" align="right"><? echo $cat_totala; ?></td>
					  <td width="120" align="right"><? echo $cat_totalp; ?></td>			  
					  <td width="120" align="right"><? echo $cat_totale; ?></td>
					</tr>
					<tr>
				      <td width="90" align="left"></td>
				    </tr>
					<tr>
				     <td width="140" align="left"><strong>'<? echo $categoria; ?> </strong></td>					 
				     <td width="400" align="left"><strong><? echo $denominacion_cat; ?> </strong></td>
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
                    $prev_cat=$categoria;	$cat_totalg=0; $cat_totalf=0; $cat_totalm=0; $cat_totaln=0; $cat_totalo=0; $cat_totalc=0; $cat_totala=0; $cat_totalp=0; $cat_totald=0; $cat_totale=0;				
				}
						
				if ($prev_cat==""){ $prev_cat=$categoria;
				if($c_cat>0){
				?>	   
				   <tr>
				     <td width="140" align="left"><strong>'<? echo $categoria; ?> </strong></td>					 
				     <td width="400" align="left"><strong><? echo $denominacion_cat; ?> </strong></td>
					 <td width="120" align="left"></td>
					 <td width="120" align="left"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
					 <td width="120" align="right"></td>
				   </tr>				  
			     <? 	} }
				      
			}
		    if(($prev_par<>$cod_partida)){
			    $par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
				$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 
				$par_totaln=formato_monto($par_totaln); $par_totalo=formato_monto($par_totalo); 
			    ?>	   
				<tr>
				   <td width="140" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $prev_par; ?></td>
				   <td width="400" align="justify"><? echo $prev_den; ?></td>				   
				   <td width="120" align="right"><? echo $par_totalg; ?></td>
				   <?if($det_modif=="SI"){?><td width="120" align="right"><? echo $par_totalo; ?></td>
				   <td width="120" align="right"><? echo $par_totaln; ?></td>
				   <?}else{?><td width="120" align="right"><? echo $par_totalm; ?></td><?}?>
				   <td width="120" align="right"><? echo $par_totalf; ?></td>
				   <td width="120" align="right"><? echo $par_totalc; ?></td>
				   <td width="120" align="right"><? echo $par_totald; ?></td>
				   <td width="120" align="right"><? echo $par_totala; ?></td>
				   <td width="120" align="right"><? echo $par_totalp; ?></td>
				   <td width="120" align="right"><? echo $par_totale; ?></td>
				 </tr>
				<? 		  
				$par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totaln=0; $par_totalo=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par=$cod_partida; $prev_den=$denominacion;
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
            $gen_totalg=$gen_totalg+$asignado; $gen_totalf=$gen_totalf+$asig_actualizada; $gen_totald=$gen_totald+$disponible; $gen_totale=$gen_totale+$deuda; 
		    $gen_totalm=$gen_totalm+$modificaciones; $gen_totalc=$gen_totalc+$comprometido; $gen_totala=$gen_totala+$causado; $gen_totalp=$gen_totalp+$pagado;
		    $gen_totalo=$gen_totalo+$aumentos; $gen_totaln=$gen_totaln+$disminuciones;	 	
		} 
		$par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
		$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 
		$par_totaln=formato_monto($par_totaln); $par_totalo=formato_monto($par_totalo); 
		?>	   
		<tr>
		   <td width="140" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $prev_par; ?></td>
		   <td width="400" align="justify"><? echo $prev_den; ?></td>				   
		   <td width="120" align="right"><? echo $par_totalg; ?></td>
		   <?if($det_modif=="SI"){?><td width="120" align="right"><? echo $par_totalo; ?></td>
		   <td width="120" align="right"><? echo $par_totaln; ?></td>
		   <?}else{?><td width="120" align="right"><? echo $par_totalm; ?></td><?}?>
		   <td width="120" align="right"><? echo $par_totalf; ?></td>
		   <td width="120" align="right"><? echo $par_totalc; ?></td>
		   <td width="120" align="right"><? echo $par_totald; ?></td>
		   <td width="120" align="right"><? echo $par_totala; ?></td>
		   <td width="120" align="right"><? echo $par_totalp; ?></td>
		   <td width="120" align="right"><? echo $par_totale; ?></td>
		 </tr>
		<? 
		$sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
	    $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		$sub_totaln=formato_monto($sub_totaln);$sub_totalo=formato_monto($sub_totalo); 
		
		if($most_gen=="SI"){ 
				    $gen_totalg=formato_monto($gen_totalg);$gen_totalf=formato_monto($gen_totalf);  $gen_totald=formato_monto($gen_totald);  $gen_totale=formato_monto($gen_totale); 
				    $gen_totalc=formato_monto($gen_totalc);$gen_totala=formato_monto($gen_totala);  $gen_totalp=formato_monto($gen_totalp);  $gen_totalm=formato_monto($gen_totalm); 
					$gen_totalo=formato_monto($gen_totalo);  $gen_totaln=formato_monto($gen_totaln); 
				    ?>	 				 
					<tr>
					  <td width="140" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="120" align="right">-----------------</td>
					  <?if($det_modif=="SI"){?><td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <?}else{?><td width="120" align="right">-----------------</td><?}?>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					  <td width="120" align="right">-----------------</td>
					</tr>	
					<tr>
					  <td width="140" align="left"></td>
					  <td width="400" align="right"><? echo "Total ".$prev_gen." :"; ?></td>
					  <td width="120" align="right"><? echo $gen_totalg; ?></td>
					  <?if($det_modif=="SI"){?><td width="120" align="right"><? echo $gen_totalo; ?></td>
					  <td width="120" align="right"><? echo $gen_totaln; ?></td>
					  <?}else{?><td width="120" align="right"><? echo $gen_totalm; ?></td><?}?>
					  <td width="120" align="right"><? echo $gen_totalf; ?></td> 
					  <td width="120" align="right"><? echo $gen_totalc; ?></td>
					  <td width="120" align="right"><? echo $gen_totald; ?></td>
					  <td width="120" align="right"><? echo $gen_totala; ?></td>
					  <td width="120" align="right"><? echo $gen_totalp; ?></td>			  
					  <td width="120" align="right"><? echo $gen_totale; ?></td>
					</tr>
				    <?
		}
		?>	 				 
		<tr>
		  <td width="140" align="left"></td>
		  <td width="400" align="left"></td>
		  <td width="120" align="right">-----------------</td>
		  <?if($det_modif=="SI"){?><td width="120" align="right">-----------------</td>
		  <td width="120" align="right">-----------------</td>
		  <?}else{?><td width="120" align="right">-----------------</td><?}?>
		  <td width="120" align="right">-----------------</td>
		  <td width="120" align="right">-----------------</td>
		  <td width="120" align="right">-----------------</td>
		  <td width="120" align="right">-----------------</td>
		  <td width="120" align="right">-----------------</td>
		  <td width="120" align="right">-----------------</td>
		</tr>	
		<tr>
		  <td width="140" align="left"></td>
		  <td width="400" align="right"><? echo "Total ".$prev_clave." :"; ?></td>
		  <td width="120" align="right"><? echo $sub_totalg; ?></td>
		  <?if($det_modif=="SI"){?><td width="120" align="right"><? echo $sub_totalo; ?></td>
		  <td width="120" align="right"><? echo $sub_totaln; ?></td>
		  <?}else{?><td width="120" align="right"><? echo $sub_totalm; ?></td><?}?>
		  <td width="120" align="right"><? echo $sub_totalf; ?></td> 
		  <td width="120" align="right"><? echo $sub_totalc; ?></td>
		  <td width="120" align="right"><? echo $sub_totald; ?></td>
		  <td width="120" align="right"><? echo $sub_totala; ?></td>
		  <td width="120" align="right"><? echo $sub_totalp; ?></td>			  
		  <td width="120" align="right"><? echo $sub_totale; ?></td>
		</tr>
	    <?if($c_cat>0){
		$cat_totalg=formato_monto($cat_totalg);$cat_totalf=formato_monto($cat_totalf);  $cat_totald=formato_monto($cat_totald);  $cat_totale=formato_monto($cat_totale); 
		$cat_totalc=formato_monto($cat_totalc);$cat_totala=formato_monto($cat_totala);  $cat_totalp=formato_monto($cat_totalp);  $cat_totalm=formato_monto($cat_totalm); 
		$cat_totaln=formato_monto($cat_totaln);$cat_totalo=formato_monto($cat_totalo); 
		?>	
			<tr>
			  <td width="140" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="120" align="right">-----------------</td>
			  <?if($det_modif=="SI"){?><td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <?}else{?><td width="120" align="right">-----------------</td><?}?>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			  <td width="120" align="right">-----------------</td>
			</tr>	
			<tr>
			  <td width="140" align="left"></td>
			  <td width="400" align="right"><? echo "Total ".$criterio_s." ".$prev_cat." : "; ?></td>
			  <td width="120" align="right"><? echo $cat_totalg; ?></td>
			  <?if($det_modif=="SI"){?><td width="120" align="right"><? echo $cat_totalo; ?></td>
			  <td width="120" align="right"><? echo $cat_totaln; ?></td>
			  <?}else{?><td width="120" align="right"><? echo $cat_totalm; ?></td><?}?>
			  <td width="120" align="right"><? echo $cat_totalf; ?></td> 
			  <td width="120" align="right"><? echo $cat_totalc; ?></td>
			  <td width="120" align="right"><? echo $cat_totald; ?></td>
			  <td width="120" align="right"><? echo $cat_totala; ?></td>
			  <td width="120" align="right"><? echo $cat_totalp; ?></td>			  
			  <td width="120" align="right"><? echo $cat_totale; ?></td>
			</tr>
			<tr>
			  <td width="140" align="left"></td>
			</tr>
		<? }
		$totalg=formato_monto($totalg);$totalf=formato_monto($totalf);  $totald=formato_monto($totald);  $totale=formato_monto($totale); 
	    $totalc=formato_monto($totalc);$totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm); 
		$totaln=formato_monto($totaln);$totalo=formato_monto($totalo); 
		?>	
		    <tr>
			  <td width="140" align="left"></td>
			</tr>
			<tr>
			  <td width="140" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="120" align="right">=============</td>
			  <?if($det_modif=="SI"){?><td width="120" align="right">=============</td>
			  <td width="120" align="right">=============</td>
			  <?}else{?><td width="120" align="right">=============</td><?}?>
			  <td width="120" align="right">=============</td>
			  <td width="120" align="right">=============</td>
			  <td width="120" align="right">=============</td>
			  <td width="120" align="right">=============</td>
			  <td width="120" align="right">=============</td>
			  <td width="120" align="right">=============</td>
			</tr>	
			<tr>
			  <td width="140" align="left"></td>
			  <td width="400" align="right"><? echo "Total General : "; ?></td>
			  <td width="120" align="right"><? echo $totalg; ?></td>
			  <?if($det_modif=="SI"){?><td width="120" align="right"><? echo $totalo; ?></td>
			  <td width="120" align="right"><? echo $totaln; ?></td>
			  <?}else{?><td width="120" align="right"><? echo $totalm; ?></td><?}?>
			  <td width="120" align="right"><? echo $totalf; ?></td> 
			  <td width="120" align="right"><? echo $totalc; ?></td>
			  <td width="120" align="right"><? echo $totald; ?></td>
			  <td width="120" align="right"><? echo $totala; ?></td>
			  <td width="120" align="right"><? echo $totalp; ?></td>			  
			  <td width="120" align="right"><? echo $totale; ?></td>
			</tr>
			
		<? 
		?></table><?
	}
	
	
	if($tipo_rep=="EXCEL2"){	
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Ejecucion_presupuestaria.xls");
		?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 
		 <tr height="20">
		   <td width="140" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Codigo programatico</strong></td>
		   <td width="140" align="left" bgcolor="#99CCFF"><strong>Codigo Partida</strong></td>
		   <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Original</strong></td>		   
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Aumentos</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Disminuciones</strong></td>		   
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Reserva</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Comprometido</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Causado</strong></td>
		   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Pagado</strong></td>		  
           <td width="200" align="right" bgcolor="#99CCFF" ><strong>Nombre Programatico</strong></td> 		   
		 </tr>
		<?$i=0;  $totalg=0; $totalf=0; $totalm=0; $totaln=0; $totalo=0;  $totalc=0; $totala=0; $totalp=0; $totald=0; $totale=0;
        $sub_totalg=0; $sub_totalf=0; $sub_totalm=0; $sub_totaln=0; $sub_totalo=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $sub_totald=0; $sub_totale=0; $prev_clave="";  	  
	    $cat_totalg=0; $cat_totalf=0; $cat_totalm=0; $cat_totaln=0; $cat_totalo=0; $cat_totalc=0; $cat_totala=0; $cat_totalp=0; $cat_totald=0; $cat_totale=0; $prev_cat=""; $prev_den_cat="";
        $par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totaln=0; $par_totalo=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; $prev_par="";	$prev_den="";	  
	    $gen_totalg=0; $gen_totalf=0; $gen_totalm=0; $gen_totalc=0; $gen_totala=0; $gen_totalp=0; $gen_totald=0; $gen_totale=0;  $prev_gen=""; $par_totalr=0;
	  
		$res=pg_query($sSQL); $filas=pg_num_rows($res); 
		while($registro=pg_fetch_array($res)){ $i=$i+1;  
		    $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"];  
			$cod_categoria=$registro["cod_categoria"]; $denominacion_cat=$registro["denomina_cat"];   $cod_partida=$registro["cod_partida"];    $clave=$registro["partida"]; $clave_g=$registro["generica"]; $categoria=$cod_categoria;	
			$denominacion=conv_cadenas($denominacion,0); $denominacion_cat=conv_cadenas($denominacion_cat,0); $clavep=$registro["cod_presup"];
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; 
			$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
			$aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];	
			if(($prev_clave<>$clavep)){ 			    
			    if($prev_clave<>""){   $mcat=elimina_guion($prev_cat); $mpartida=elimina_guion($prev_par); $mcat="11".substr($mcat,0,4)."00".substr($mcat,4,2);
				    $par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
					$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 
					$par_totaln=formato_monto($par_totaln); $par_totalo=formato_monto($par_totalo); 
			    ?>	   
					<tr>
					   <td width="140" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $mcat; ?></td>
					   <td width="140" align="left"><? echo $mpartida; ?></td>
					   <td width="400" align="justify"><? echo $prev_den; ?></td>				   
					   <td width="120" align="right"><? echo $par_totalg; ?></td>
					   <td width="120" align="right"><? echo $par_totalo; ?></td>
					   <td width="120" align="right"><? echo $par_totaln; ?></td>
					   <td width="120" align="right"><? echo $par_totalr; ?></td>
					   <td width="120" align="right"><? echo $par_totalc; ?></td>
					   <td width="120" align="right"><? echo $par_totala; ?></td>
					   <td width="120" align="right"><? echo $par_totalp; ?></td>
					   <td width="200" align="left"><? echo $prev_den_cat; ?></td>
					 </tr>
					<? 
					$par_totalg=0; $par_totalf=0; $par_totalm=0; $par_totaln=0; $par_totalo=0; $par_totalc=0; $par_totala=0; $par_totalp=0; $par_totald=0; $par_totale=0; 
					$prev_clave=$clavep; $prev_par=$cod_partida; $prev_den=$denominacion; $prev_cat=$cod_categoria; $prev_den_cat=$denominacion_cat; $prev_clave=$clavep;
				}
				if ($prev_clave==""){ $prev_clave=$clavep; $prev_par=$cod_partida; $prev_den=$denominacion; $prev_cat=$cod_categoria; $prev_den_cat=$denominacion_cat; $prev_clave=$clavep; }
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
            $gen_totalg=$gen_totalg+$asignado; $gen_totalf=$gen_totalf+$asig_actualizada; $gen_totald=$gen_totald+$disponible; $gen_totale=$gen_totale+$deuda; 
		    $gen_totalm=$gen_totalm+$modificaciones; $gen_totalc=$gen_totalc+$comprometido; $gen_totala=$gen_totala+$causado; $gen_totalp=$gen_totalp+$pagado;
		    $gen_totalo=$gen_totalo+$aumentos; $gen_totaln=$gen_totaln+$disminuciones;	 	
		} 
		$par_totalg=formato_monto($par_totalg);$par_totalf=formato_monto($par_totalf);  $par_totald=formato_monto($par_totald);  $par_totale=formato_monto($par_totale); 
		$par_totalc=formato_monto($par_totalc);$par_totala=formato_monto($par_totala);  $par_totalp=formato_monto($par_totalp);  $par_totalm=formato_monto($par_totalm); 
		$par_totaln=formato_monto($par_totaln); $par_totalo=formato_monto($par_totalo); 
		$mcat=elimina_guion($prev_cat); $mpartida=elimina_guion($prev_par);
		?>	   
		<tr>
		   <td width="140" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $mcat; ?></td>
		   <td width="140" align="left"><? echo $mpartida; ?></td>
		   <td width="400" align="justify"><? echo $prev_den; ?></td>				   
		   <td width="120" align="right"><? echo $par_totalg; ?></td>
		   <td width="120" align="right"><? echo $par_totalo; ?></td>
		   <td width="120" align="right"><? echo $par_totaln; ?></td>
		   <td width="120" align="right"><? echo $par_totalr; ?></td>
		   <td width="120" align="right"><? echo $par_totalc; ?></td>
		   <td width="120" align="right"><? echo $par_totala; ?></td>
		   <td width="120" align="right"><? echo $par_totalp; ?></td>
		   <td width="200" align="left"><? echo $prev_den_cat; ?></td>
		 </tr>
		<? 
		$sub_totalg=formato_monto($sub_totalg);$sub_totalf=formato_monto($sub_totalf);  $sub_totald=formato_monto($sub_totald);  $sub_totale=formato_monto($sub_totale); 
	    $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		$sub_totaln=formato_monto($sub_totaln);$sub_totalo=formato_monto($sub_totalo); 
		
		
		?></table><?
	}
	
	$StrSQL = "DELETE FROM pre020 Where (tipo_registro='2') And (nombre_usuario='".$cod_mov."')";
   /* 
   $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
   */
   ?>

