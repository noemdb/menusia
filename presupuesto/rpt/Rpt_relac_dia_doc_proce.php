<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$cod_presup_d=$_GET["cod_presupd"];  $cod_presup_h=$_GET["cod_presuph"]; $cod_fuente_d=$_GET["cod_fuented"];  $cod_fuente_h=$_GET["cod_fuenteh"]; $fecha_d=$_GET["fecha_d"]; $fecha_h=$_GET["fecha_h"];$tipo_rep=$_GET["tipo_rep"];}
   else{$tipo_rep="HTML"; $cod_presup_d=""; $cod_presup_h="";}$php_os=PHP_OS; $imp_total_g="N";

$mcontrol = array (0,0,0,0,0,0,0,0,0,0);
function buscar_control($clave, $formato){  global $mcontrol;  $j=0;
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} }  
  return $actual;
}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a"); $Rif_Emp="";
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} }
  
  $sql="Select * from SIA000 order by campo001";$resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"]; $Rif_Emp=$registro["campo007"]; }
  $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];} 
  $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;  $buscaf_ant="N"; 
 
  if($cod_emp=="71"){ $imp_total_g="S"; }
  
  $criterio1="RELACION DIARIA DE DOCUMENTOS PRESUPUESTARIOS PROCESADOS EL ".$fecha_d;  $cod_mov="pre012".$usuario_sia; $sfechad=formato_aaaammdd($fecha_d); $sfechah=formato_aaaammdd($fecha_h);
  $criterio="(cod_presup>='$cod_presup_d' and cod_presup<='$cod_presup_h') And (cod_fuente>='$cod_fuente_d' and cod_fuente<='$cod_fuente_h')";
  $criterio2="Asignacion Inicial :";  $criterio3="Asignacion Actualizada :";
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presup_d,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
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
  $pfecha=$sfechad; $sfechad=$Fec_Ini_Ejer;
  if($sfechad==$Fec_Ini_Ejer){$buscaf_ant="N";} else{$buscaf_ant="S";} 
  $res=pg_exec($conn,"SELECT ACTUALIZA_CONSOLIDADO('E','$cod_mov','O','$sfechad','$sfechah','N','$buscaf_ant','$Rif_Emp')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  
  $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_Usuario,'O' as Tipo_Registro, cod_presup, cod_fuente, denominacion,substr(cod_presup,1,".$c.") as cod_categoria,"."'' as Denomina_cat,substr(cod_presup,".$ini.",".$p.") as cod_partida,'' as Denomina_Par,Status_Dist,Func_Inv,Ord_Cord,Aplicacion,Cod_Unidad_Ejec, ";
  $StrSQL=$StrSQL."Asignado,Disponible,Disp_Diferida,0 as Compromiso,0 as Causado,0 as Pagado,0 as Traslados,0 as Trasladon,0 as Adicion,0 as Disminucion,0 as Diferido,0 as CompromisoM,0 as CausadoM,0 as PagadoM,0 as TrasladosM,0 as TrasladonM,0 as AdicionM,0 as DisminucionM,0 as DiferidoM ";
  $StrSQL=$StrSQL." FROM pre001 WHERE length(cod_presup)=".$l_c." and ".$criterio;  
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  
  $criterion="(cod_presup>='$cod_presup_d' and cod_presup<='$cod_presup_h') And (fuente_financ>='$cod_fuente_d' and fuente_financ<='$cod_fuente_h') And (fecha_doc>='$fecha_d' and fecha_doc<='$fecha_h')";
  $res=pg_exec($conn,"SELECT ACTUALIZA_CONSOLIDADO('C','$cod_mov','O','$sfechad','$sfechah','N','$buscaf_ant','$Rif_Emp')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  $res=pg_exec($conn,"SELECT ACTUALIZA_CONSOLIDADO('A','$cod_mov','O','$sfechad','$sfechah','N','$buscaf_ant','$Rif_Emp')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  $res=pg_exec($conn,"SELECT ACTUALIZA_CONSOLIDADO('P','$cod_mov','O','$sfechad','$sfechah','N','$buscaf_ant','$Rif_Emp')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  $res=pg_exec($conn,"SELECT ACTUALIZA_CONSOLIDADO('J','$cod_mov','O','$sfechad','$sfechah','N','$buscaf_ant','$Rif_Emp')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  $res=pg_exec($conn,"SELECT ACTUALIZA_CONSOLIDADO('M','$cod_mov','O','$sfechad','$sfechah','N','$buscaf_ant','$Rif_Emp')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  //$res=pg_exec($conn,"SELECT ACTUALIZA_CONSOLIDADO('S','$cod_mov','O','$sfechad','$sfechah','N','$buscaf_ant','$Rif_Emp')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){  }
  
  $res=pg_exec($conn,"SELECT ACTUALIZA_CONSOLIDADO('N','$cod_mov','O','$sfechad','$sfechah','N','$buscaf_ant','$Rif_Emp')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){  }
  
  $res=pg_exec($conn,"SELECT ACTUALIZA_CONSOLIDADO('D','$cod_mov','O','$sfechad','$sfechah','N','$buscaf_ant','$Rif_Emp')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  $sSQL = "select distinct cod_presup,fuente_financ from pre012 where (pre012.Tipo_Rep='O') and (nombre_Usuario='$cod_mov')";  $res=pg_query($sSQL);
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $asignado=0;
     $sql="Select asignado from pre001 WHERE cod_presup='$cod_presup' And cod_fuente='$fuente_financ'";
	 $resultado=pg_exec($conn,$sql); $filas=pg_numrows($resultado); if($filas>0){$reg=pg_fetch_array($resultado); $asignado=$reg["asignado"];}
     $sql="SELECT ACTUALIZA_DISP_CONS('$cod_mov','O','$cod_presup','$fuente_financ',$asignado)";$resultado=pg_exec($conn,$sql); 
	 $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  }
      $sSQL = "SELECT pre012.nombre_Usuario, pre012.Status, pre012.cod_presup,  pre001.denominacion, pre012.fuente_financ, pre095.Des_fuente_financ, pre001.Asignado,  
pre012.Tipo_Registro, pre012.fecha_doc, pre012.Referencia_Doc, pre012.Tipo_Doc,  pre012.nombre_Abrev_Doc, pre012.Referencia_Comp, pre012.Tipo_Comp, 
pre012.Referencia_Caus,  pre012.Tipo_Caus, pre012.Referencia_Pago, pre012.Tipo_Pago, SUBSTRING(pre012.descripcion_Doc,1,150) AS descripcion_Doc, pre012.Ced_Rif, pre012.Afecta, pre012.Monto, 
pre099.nombre,   pre012.Comprometido, pre012.Causado, pre012.Pagado, pre012.Traslados, pre012.Adicion,  pre012.Ajuste_Comp, pre012.Ajuste_Caus, pre012.Ajuste_Pago, (pre012.Adicion+pre012.Traslados) AS modificaciones,
pre012.Ref_Imput_Presu, pre012.disponible, pre012.asig_actualizada, to_char(pre012.fecha_doc,'DD/MM/YYYY') as fechad, pre019.cod_presup_Cat,pre019.Denominacion_Cat,SUBSTRING(pre012.cod_presup,".$ini.",".$p.") as cod_part,pre012.campo_str1, pre006.nro_documento  
FROM pre001, pre095, pre099, pre019, (pre012 left join pre006 on (pre012.referencia_comp=pre006.referencia_comp) and (pre012.tipo_comp=pre006.tipo_compromiso) ) 
WHERE pre001.cod_presup = pre012.cod_presup And pre012.fuente_financ=pre001.cod_fuente AND  pre012.Ced_Rif = pre099.Ced_Rif AND  
pre012.fuente_financ = pre095.cod_fuente_financ AND (pre012.Tipo_Rep='O') and (nombre_Usuario='$cod_mov') and SUBSTRING(pre012.cod_presup,1,".$c.")=pre019.cod_presup_Cat
ORDER BY pre012.cod_presup,pre012.fuente_financ,pre012.fecha_doc,pre012.Tipo_Registro,pre012.Referencia_Doc,pre012.ref_imput_presu,pre012.cod_presup";

      $sSQL = "SELECT pre012.nombre_Usuario, pre012.Status, pre012.cod_presup,  pre001.denominacion, pre012.fuente_financ, pre095.Des_fuente_financ, pre001.Asignado,  
pre012.Tipo_Registro, pre012.fecha_doc, pre012.Referencia_Doc, pre012.Tipo_Doc,  pre012.nombre_Abrev_Doc, pre012.Referencia_Comp, pre012.Tipo_Comp, 
pre012.Referencia_Caus,  pre012.Tipo_Caus, pre012.Referencia_Pago, pre012.Tipo_Pago, pre012.descripcion_Doc as descripcion,SUBSTRING(pre012.descripcion_Doc,1,150) AS descripcion_Doc, pre012.Ced_Rif, pre012.Afecta, pre012.Monto, 
pre099.nombre,   pre012.Comprometido, pre012.Causado, pre012.Pagado, pre012.Traslados, pre012.Adicion,  pre012.Ajuste_Comp, pre012.Ajuste_Caus, pre012.Ajuste_Pago, (pre012.Adicion+pre012.Traslados) AS modificaciones,
pre012.Ref_Imput_Presu, pre012.disponible, pre012.asig_actualizada, to_char(pre012.fecha_doc,'DD/MM/YYYY') as fechad, pre019.cod_presup_Cat,pre019.Denominacion_Cat,SUBSTRING(pre012.cod_presup,".$ini.",".$p.") as cod_part,pre012.campo_str1  
FROM pre001, pre095, pre099, pre019, pre012  
WHERE pre001.cod_presup = pre012.cod_presup And pre012.fuente_financ=pre001.cod_fuente AND  pre012.Ced_Rif = pre099.Ced_Rif AND  
pre012.fuente_financ = pre095.cod_fuente_financ AND (pre012.Tipo_Rep='O') and (nombre_Usuario='$cod_mov') and (fecha_doc>='$pfecha') and SUBSTRING(pre012.cod_presup,1,".$c.")=pre019.cod_presup_Cat
ORDER BY pre012.fecha_doc,pre012.Tipo_Registro,PRE012.tipo_doc,pre012.Referencia_Doc,pre012.ref_imput_presu,pre012.cod_presup,pre012.fuente_financ";
   
   if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_relac_dia_doc_proce.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"criterio3"=>$criterio3,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();
    } 
	if($tipo_rep=="PDF"){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $criterio1; global $registro; global $criterio2;  global $tam_logo;
		    $this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',12);
			$this->Cell(40);
			$this->Cell(180,10,$criterio1,0,0,'C');
			$this->Ln(18);
            $this->SetFont('Arial','B',5);					
			$this->Cell(12,5,'TIPO  DOC.',1,0);
			$this->Cell(14,5,'REFERENCIA',1,0);
			$this->Cell(80,5,'DESCRIPCION DEL DCUMENTO',1,0);
			$this->Cell(45,5,'BENEFICIARIO DEL DCUMENTO',1,0);
			$this->Cell(29,5,'COD. PRESUPUESTARIO',1,0,'C');
			$this->Cell(20,5,'MODIFICACIONES',1,0,'C');
			$this->Cell(20,5,'COMPROMETIDO',1,0,'C');
			$this->Cell(20,5,'CAUSADO',1,0,'C');
			$this->Cell(20,5,'PAGADO',1,1,'C');
			
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
	  $pdf->SetFont('Arial','',6);
	  $i=0;  $totalm=0; $totalc=0; $totala=0; $totalp=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $prev_clave="";  
	  while($registro=pg_fetch_array($res)){ $asignado=$registro["asignado"];		$asignado=formato_monto($asignado);  $nombre=$registro["nombre"];
		    $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"]; 
			$cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"];   $cod_part=$registro["cod_part"];  $clave=$cod_presup.$fuente_financ;			
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$nombre=utf8_decode($nombre); $denominacion_cat=utf8_decode($denominacion_cat); $denominacion=utf8_decode($denominacion);}
		    $referencia=$registro["referencia_doc"]; $fecha=$registro["fecha_doc"];  $tipo=$registro["tipo_doc"];  $nomb_abrev=$registro["nombre_abrev_doc"]; $nombre=$registro["nombre"];
			$clave=$referencia.$tipo.$nomb_abrev;			
			if($prev_clave<>$clave){ 
			    $pdf->SetFont('Arial','B',6); 
			    if(($sub_totalc>0)or($sub_totalm>0)or($sub_totala>0)or($sub_totalp>0)or($i>0)){ $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
				    $pdf->Cell(180,2,'',0,0);
					$pdf->Cell(20,2,'-------------------',0,0,'R');
					$pdf->Cell(20,2,'-------------------',0,0,'R');
					$pdf->Cell(20,2,'-------------------',0,0,'R');
					$pdf->Cell(20,2,'-------------------',0,1,'R');
					$pdf->Cell(180,4,"Total Documento : ",0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalm,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalc,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totala,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalp,0,1,'R'); 
					$i=0;
                    $pdf->Ln(2);					
				}
				$pdf->SetFont('Arial','',6);	
				$prev_clave=$clave;  $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0;
            }			
			if($Cod_Emp=="70"){if(trim($registro["campo_str1"])==""){$descripcion=$registro["descripcion"];}else{$descripcion=$registro["campo_str1"]." ".$registro["descripcion"]; }
			}else{$descripcion=$registro["descripcion"];}			
		    $modificaciones=$registro["modificaciones"]; $comprometido=$registro["comprometido"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; $disponible=$registro["disponible"];
		    $totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;
		    $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado; $fechaf=formato_ddmmaaaa($fecha);
		    $modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); 
		    if($php_os=="WINNT"){$descripcion=$descripcion; }   else{$nombre=utf8_decode($nombre); $descripcion=utf8_decode($descripcion);} $disponible=formato_monto($disponible);
		   
		   if($i==0){
		   $pdf->Cell(12,3,$tipo." ".$nomb_abrev,0,0);
           $pdf->Cell(14,3,$referencia,0,0);  
		   }else{ $pdf->Cell(26,3,"",0,0);  }		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=45; $w=80;		   
		   $pdf->SetXY($x+$w+$n,$y);
		   $pdf->Cell(29,3,$cod_presup,0,0,'L');
		   $pdf->Cell(20,3,$modificaciones,0,0,'R'); 
           $pdf->Cell(20,3,$comprometido,0,0,'R'); 
           $pdf->Cell(20,3,$causado,0,0,'R'); 
           $pdf->Cell(20,3,$pagado,0,1,'R'); 
           if($i==0){			
		   $l=strlen($descripcion); $nombre_temp=$nombre;		   
		   if ($y>=187) { $nombre_temp=substr($nombre_temp,0,56);}
		   if ($y>=190) { $nombre_temp=substr($nombre_temp,0,33);}
		   $b=strlen($nombre_temp);		   
		   if($l>65){ $pdf->SetXY($x+$w,$y);
		     if(($b>55)and ($l<120)){$nombre_temp=substr($nombre_temp,0,55);}		   
		     $pdf->MultiCell($n,3,$nombre_temp,0);  
		     $pdf->SetXY($x,$y);	
		     $pdf->MultiCell($w,3,$descripcion,0); 
		   }else{$pdf->SetXY($x,$y);	
		     $pdf->MultiCell($w,3,$descripcion,0);              
		     $pdf->SetXY($x+$w,$y);	
             $pdf->MultiCell($n,3,$nombre_temp,0);   			 
		   }
		   }
		   $i=$i+1; 
		}		
		$pdf->SetFont('Arial','B',6); 
		if(($sub_totalc>0)or($sub_totalm>0)or($sub_totala>0)or($sub_totalp>0)or($i>0)){ $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
			$pdf->Cell(180,2,'',0,0);
			$pdf->Cell(20,2,'-------------------',0,0,'R');
			$pdf->Cell(20,2,'-------------------',0,0,'R');
			$pdf->Cell(20,2,'-------------------',0,0,'R');
			$pdf->Cell(20,2,'-------------------',0,1,'R');
			$pdf->Cell(180,4,"Total Documento : ",0,0,'R'); 
			$pdf->Cell(20,4,$sub_totalm,0,0,'R'); 
			$pdf->Cell(20,4,$sub_totalc,0,0,'R'); 
			$pdf->Cell(20,4,$sub_totala,0,0,'R'); 
			$pdf->Cell(20,4,$sub_totalp,0,1,'R'); 
			$i=0;					
		}
		$totalc=formato_monto($totalc); $totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm); 
		$pdf->Ln(5);
		$pdf->Cell(180,2,'',0,0);
		$pdf->Cell(20,2,'=============',0,0,'R');
		$pdf->Cell(20,2,'=============',0,0,'R');
		$pdf->Cell(20,2,'=============',0,0,'R');
		$pdf->Cell(20,2,'=============',0,1,'R');
		$pdf->Cell(180,5,"Total General : ",0,0,'R'); 
		$pdf->Cell(20,5,$totalm,0,0,'R'); 
		$pdf->Cell(20,5,$totalc,0,0,'R'); 
		$pdf->Cell(20,5,$totala,0,0,'R'); 
		$pdf->Cell(20,5,$totalp,0,1,'R');
		$pdf->Output();   
    }	
	if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Relac_dia_doc_proce.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">			
			 <tr height="20">
				<td width="90" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1;?></strong></font></td>
			 </tr>
			 <tr height="20">
			   <td width="90" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Tipo</strong></td>
			   <td width="80" align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
			   <td width="200" align="left" bgcolor="#99CCFF"><strong>Beneficiario</strong></td>
			   <td width="150" align="right" bgcolor="#99CCFF" ><strong>Codigo Presupouestario</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Modificaciones</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Comprometido</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Causado</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Pagado</strong></td>
			   		 
			 </tr>
		  <?  $i=0;  $totalm=0; $totalc=0; $totala=0; $totalp=0; $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $prev_clave="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $asignado=$registro["asignado"];		$asignado=formato_monto($asignado);  
		       $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"]; 
			   $cod_presup_cat=$registro["cod_presup_cat"]; $denominacion_cat=$registro["denominacion_cat"];   $cod_part=$registro["cod_part"];			   
		       $denominacion=conv_cadenas($denominacion,0); $clave=$cod_presup.$fuente_financ;
			   $referencia=$registro["referencia_doc"]; $fecha=$registro["fecha_doc"];  $tipo=$registro["tipo_doc"];  $nomb_abrev=$registro["nombre_abrev_doc"];  $descripcion=$registro["campo_str1"]." ".$registro["descripcion"]; $nombre=$registro["nombre"];
			   $clave=$referencia.$tipo.$nomb_abrev;
		       if($prev_clave<>$clave){ 
			     if(($sub_totalc>0)or($sub_totalm>0)or($sub_totala>0)or($sub_totalp>0)){ $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
					?>	 				 
                    <tr>
				      <td width="90" align="left"></td>
				      <td width="80" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="200" align="left"></td>
					  <td width="150" align="left"></td>
					  <td width="120" align="right">---------------</td>
					  <td width="120" align="right">---------------</td>
					  <td width="120" align="right">---------------</td>
					  <td width="120" align="right">---------------</td>				  
				    </tr>	
					<tr>
				      <td width="90" align="left"></td>
					  <td width="80" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="150" align="left"></td>
					  <td width="200" align="right"><? echo "Total Documento : "; ?></td>
					  <td width="120" align="right"><? echo $sub_totalm; ?></td>
					  <td width="120" align="right"><? echo $sub_totalc; ?></td>
					  <td width="120" align="right"><? echo $sub_totala; ?></td>
					  <td width="120" align="right"><? echo $sub_totalp; ?></td>
				    </tr>	
					<tr>
				      <td width="90" align="left"></td>
				    </tr>	
                  <? 					
				 }
			    $prev_clave=$clave;  $sub_totalm=0; $sub_totalc=0; $sub_totala=0; $sub_totalp=0; $i=0;
			   }
		       $modificaciones=$registro["modificaciones"]; $comprometido=$registro["comprometido"];   $causado=$registro["causado"]; $pagado=$registro["pagado"]; $disponible=$registro["disponible"];
               $totalm=$totalm+$modificaciones; $totalc=$totalc+$comprometido; $sub_totalm=$sub_totalm+$modificaciones; $sub_totalc=$sub_totalc+$comprometido;
			   $totala=$totala+$causado; $totalp=$totalp+$pagado; $sub_totala=$sub_totala+$causado; $sub_totalp=$sub_totalp+$pagado;
			   $modificaciones=formato_monto($modificaciones); 	$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); $disponible=formato_monto($disponible);
			   $fechaf=formato_ddmmaaaa($fecha);  $descripcion=conv_cadenas($descripcion,0); $nombre=conv_cadenas($nombre,0);
			   if($i>0){$tipo=""; $referencia=""; $descripcion=""; $nombre="";}
			   ?>	   
				<tr>
				   <td width="90" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $tipo; ?></td>
				   <td width="80" align="left">'<? echo $referencia; ?></td>				  
				   <td width="400" align="justify"><? echo $descripcion; ?></td>
				   <td width="200" align="justify"><? echo $nombre; ?></td>	
                   <td width="150" align="left"><? echo $cod_presup; ?></td>				   
				   <td width="120" align="right"><? echo $modificaciones; ?></td>
				   <td width="120" align="right"><? echo $comprometido; ?></td>
				   <td width="120" align="right"><? echo $causado; ?></td>
				   <td width="120" align="right"><? echo $pagado; ?></td>
				   
				 </tr>
			   <? 
               $i=$i+1; 			   
		  }
		  if(($sub_totalc>0)or($sub_totalm>0)or($sub_totala>0)or($sub_totalp>0)){ $sub_totalc=formato_monto($sub_totalc);$sub_totala=formato_monto($sub_totala);  $sub_totalp=formato_monto($sub_totalp);  $sub_totalm=formato_monto($sub_totalm); 
		  ?>	 				 
			<tr>
			  <td width="90" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="200" align="left"></td>
			  <td width="150" align="left"></td>
			  <td width="120" align="right">---------------</td>
			  <td width="120" align="right">---------------</td>
			  <td width="120" align="right">---------------</td>
			  <td width="120" align="right">---------------</td>
			  
			</tr>	
			<tr>
			  <td width="90" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="150" align="left"></td>
			  <td width="200" align="right"><? echo "Totales : "; ?></td>
			  <td width="120" align="right"><? echo $sub_totalm; ?></td>
			  <td width="120" align="right"><? echo $sub_totalc; ?></td>
			  <td width="120" align="right"><? echo $sub_totala; ?></td>
			  <td width="120" align="right"><? echo $sub_totalp; ?></td>
			</tr>	
			
		  <? 					
		  }
          if($imp_total_g=="S"){
		   $totalc=formato_monto($totalc); $totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm); 
		   ?>	
            <tr height="20">
				<td width="90" align="left"></td>
			    <td width="80" align="left"></td>
			</tr>		   
			<tr>
			  <td width="90" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="200" align="left"></td>
			  <td width="150" align="left"></td>
			  <td width="120" align="right">==============</td>
			  <td width="120" align="right">==============</td>
			  <td width="120" align="right">==============</td>
			  <td width="120" align="right">==============</td>
			</tr>	
			<tr>
			  <td width="90" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="200" align="right"></td>
			  <td width="150" align="left"><? echo "Totale General : "; ?></td>
			  <td width="120" align="right"><? echo $totalm; ?></td>
			  <td width="120" align="right"><? echo $totalc; ?></td>
			  <td width="120" align="right"><? echo $totala; ?></td>
			  <td width="120" align="right"><? echo $totalp; ?></td>
			  <td width="120" align="left"></td>
			</tr>	
		  <?
		  }		  
		  ?></table><?
    }		  
   
?>

