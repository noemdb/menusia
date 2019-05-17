<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$cod_presup_d=$_GET["cod_presupd"];$cod_presup_h=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuented"];$cod_fuente_h=$_GET["cod_fuenteh"]; $c_cat=$_GET["csubtotal"]; $tipo_rep=$_GET["tipo_rep"];}
else{$codigod="";$codigoh="";$fuented="";$fuenteh="";$fecha="";$c_cat=0;$tipo_rep="HTML";}   $equipo=getenv("COMPUTERNAME"); $cod_mov="pre020".$usuario_sia; 
$asig_global="S";$mcontrol = array (0,0,0,0,0,0,0,0,0,0);$mdes_cat=array("NINGUNA","","","","","");
function buscar_control($clave, $formato){  global $mcontrol;  $j=0;
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} }
  return $actual;}

$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? }  else{  $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} }
  $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];$mdes_cat[1]=$registro["campo505"]; $mdes_cat[2]=$registro["campo507"]; $mdes_cat[3]=$registro["campo509"]; $mdes_cat[4]=$registro["campo511"]; $mdes_cat[5]=$registro["campo512"];} 
  $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presup_d,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
  if($c_cat==0){$criterio_s=""; $ls=$c;}else{$criterio_s=$mdes_cat[$c_cat]; $ls=$mcontrol[$c_cat-1];}   
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
  
  $per_hasta=0;
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
   
   $StrSQL = "DELETE FROM pre020 Where (tipo_registro='3') And (Nombre_Usuario='".$cod_mov."')";
   $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
   if($asig_global=="S"){$sql_Asignacion="Asignado,";}
  
  $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as Nombre_Usuario,'3' as tipo_registro, cod_presup, Cod_Fuente, Denominacion,substr(cod_presup,1,".$ls.") as cod_categoria,"."'' as Denomina_cat,substr(cod_presup,".$ini.",".$p.") as cod_partida,'' as Denomina_Par,Status_Dist,Func_Inv,Ord_Cord,Aplicacion,Cod_Unidad_Ejec, ";
  $StrSQL=$StrSQL.$sql_Asignacion." disponible,disp_diferida,".$sql_Compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.", "."0 as CompromisoM,0 as CausadoM, 0 as PagadoM, 0 as TrasladosM, 0 as TrasladonM, 0 as AdicionM, 0 as DisminucionM, 0 as DiferidoM ";
  $StrSQL=$StrSQL." FROM PRE001 WHERE length(cod_presup)=".$l_c." and ".$criterio;
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  
  $ordenar=" ORDER BY pre020.cod_presup,pre020.cod_fuente";
  if($c_cat>0){ $ordenar=" ORDER BY pre020.cod_categoria,pre020.cod_presup,pre020.cod_fuente";
   $sSQL = "Select cod_presup,denominacion from pre001 WHERE cod_presup in (select distinct cod_categoria from pre020 where (tipo_registro='3') and (nombre_usuario='$cod_mov'))";  $res=pg_query($sSQL);
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_presup"]; $denominacion=$registro["denominacion"]; 
     $sql="update pre020 set denomina_cat='$denominacion' where tipo_registro='3' and nombre_usuario='$cod_mov' and cod_categoria='$cod_presup'";$resultado=pg_exec($conn,$sql); 
	 $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  }}
  
  $sSQL = "SELECT pre020.cod_presup, pre020.cod_fuente, pre020.denominacion, pre020.disponible,pre020.cod_categoria,pre020.denomina_cat FROM pre020  WHERE tipo_registro='3' and Nombre_Usuario='$cod_mov' and ".$criterio.$ordenar;
  $efiscal=substr($Fec_Fin_Ejer,0,4);   $criterio1="EJERCICIO FISCAL: ".$efiscal;
  if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
        $oRpt = new PHPReportMaker();
        $oRpt->setXML("Rpt_Disponibilidad_Actualizada.xml");
        $oRpt->setUser("$user");
        $oRpt->setPassword("$password");
        $oRpt->setConnection("$host");
        $oRpt->setDatabaseInterface("postgresql");
		$oRpt->setSQL($sSQL);
        $oRpt->setDatabase("$dbname");
		$oRpt->setParameters(array("criterio1"=>$criterio1));          
        $oRpt->run();
  }
  if($tipo_rep=="PDF"){	$res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){ $registro=pg_fetch_array($res,0); }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){ global $criterio1; global $php_os; global $registro; global $c_cat; global $criterio_s;  global $tam_logo;
            $cod_presup_cat=$registro["cod_categoria"]; $denominacion_cat=$registro["denomina_cat"];   
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denominacion_cat=utf8_decode($denominacion_cat); }
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(120,8,'DISPONIBILIDAD PRESUPUESTARIA ACTUALIZADA',1,1,'C');
			$this->Ln(10);			
			$this->SetFont('Arial','B',8);
            $this->Cell(50,5,$criterio1,0,1);
			if($c_cat>0){	
			  $this->SetFont('Arial','B',7);
              $this->MultiCell(200,4,$criterio_s.": ".$cod_presup_cat." ".$denominacion_cat,0);
			}
            $this->SetFont('Arial','B',7);			
			$this->Cell(42,5,'CODIGO',1,0);
			$this->Cell(12,5,'FUENTE',1,0);
			$this->Cell(125,5,'DENOMINACION',1,0);
			$this->Cell(21,5,'DISPONIBILIDAD',1,1,'C');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',8);
	  $i=0;  $total=0; $prev_cat=""; $sub_total=0;
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_presup=$registro["cod_presup"];  $cod_fuente=$registro["cod_fuente"];   $denominacion=$registro["denominacion"];  $cod_categoria=$registro["cod_categoria"]; $denominacion_cat=$registro["denomina_cat"]; 
		   $disponible=$registro["disponible"];  $categoria=$cod_categoria;
           if($php_os=="WINNT"){$denominacion=$denominacion; }   else{$denominacion=utf8_decode($denominacion); $denominacion_cat=utf8_decode($denominacion_cat); }
		   if(($categoria<>$prev_cat)and($c_cat>0)){ 
             if(($categoria<>$prev_cat)and($c_cat>0)and($prev_cat<>"")){  $sub_total=formato_monto($sub_total); 
			    $pdf->SetFont('Arial','B',8); 
		        $pdf->Cell(178,2,'',0,0);
		        $pdf->Cell(22,2,'________________',0,1,'R');
				$pdf->Cell(178,5,"Total ".$prev_clave." : ",0,0,'R');
				$pdf->Cell(22,5,$sub_total,0,1,'R');
                $pdf->SetFont('Arial','',8);				
				$pdf->AddPage();					
			 }
			 $prev_cat=$categoria; $sub_total=0;  
		   }
		   $total=$total+$disponible; $sub_total=$sub_total+$disponible; $disponible=formato_monto($disponible);
		   $pdf->Cell(44,4,$cod_presup,0,0);
		   $pdf->Cell(10,4,$cod_fuente,0,0,'C');  		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=126; 		   
		   $pdf->SetXY($x+$n,$y);
		   $pdf->Cell(20,4,$disponible,0,1,'R'); 
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,4,$denominacion,0);
			
		}  $total=formato_monto($total); $sub_total=formato_monto($sub_total); 
		
		$pdf->SetFont('Arial','B',8); 
		if($c_cat>0){
		$pdf->Cell(178,2,'',0,0);
		$pdf->Cell(22,2,'________________',0,1,'R');
		$pdf->Cell(178,5,"Total ".$prev_clave." : ",0,0,'R');
		$pdf->Cell(22,5,$sub_total,0,1,'R');}
		else{
		$pdf->Cell(178,2,'',0,0);
		$pdf->Cell(22,2,'=============',0,1,'R');
		$pdf->Cell(178,5,"Totales : ",0,0,'R');
		$pdf->Cell(22,5,$total,0,1,'R'); }		
		$pdf->Output();   
    }
    if($tipo_rep=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Disponibilidad_Actualizada.xls");

?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="220" align="left" ><strong></strong></td>
		    <td width="50" align="left" ><strong></strong></td>
                    <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>DISPONIBILIDAD PRESUPUESTARIA ACTUALIZADA</strong></font></td>
		 </tr>
         <tr height="20">
           <td width="220" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CODIGO</strong></td>
           <td width="50" align="left" bgcolor="#99CCFF"><strong>FUENTE</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>DENOMINACION</strong></td>
           <td width="120" align="center" bgcolor="#99CCFF"><strong>DISPONIBILIDAD</strong></td>
         </tr>
     <?	  
	  $i=0;  $total=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $cod_presup=$registro["cod_presup"];  $cod_fuente=$registro["cod_fuente"];   $denominacion=$registro["denominacion"];  
		   $disponible=$registro["disponible"]; $total=$total+$disponible; $disponible=formato_monto($disponible);           
		   $denominacion=conv_cadenas($denominacion,0);  
	?>	   
		   <tr>
           <td width="220" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $cod_presup; ?></td>
           <td width="50" align="center">'<? echo $cod_fuente; ?></td>
           <td width="400" align="justify"><? echo $denominacion; ?></td>
           <td width="120" align="right"><? echo $disponible; ?></td>
         </tr>
	<? } $total=formato_monto($total);  ?>
       <tr>
			  <td width="220" align="left"></td>
			  <td width="50" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="120" align="right">-----------------</td>
			</tr>	
			<tr>
			  <td width="220" align="left"></td>
			  <td width="50" align="left"></td>
			  <td width="400" align="right"><? echo "Totales : "; ?></td>
			  <td width="120" align="right"><? echo $total; ?></td>
			</tr>	
	
	  </table><?	  
	}
	/*
    $StrSQL = "DELETE FROM pre020 Where (tipo_registro='3') And (Nombre_Usuario='".$cod_mov."')";
   $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
   */
?>
