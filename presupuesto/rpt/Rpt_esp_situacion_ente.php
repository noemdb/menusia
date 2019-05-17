<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$timestre=$_GET["timestre"];$ingresos=$_GET["ingresos"];} else { $timestre="01";$ingresos="";}  $mes_desde="01"; $mes_hasta="03"; $mdes_trim="I-TRIMESTRE";
$asig_global="N"; $equipo=getenv("COMPUTERNAME"); $cod_mov="Spre020".$usuario_sia; $php_os=PHP_OS;

if($timestre=="01"){ $mes_desde="01"; $mes_hasta="03"; $mdes_trim="I-TRIMESTRE"; }
if($timestre=="02"){ $mes_desde="04"; $mes_hasta="06"; $mdes_trim="II-TRIMESTRE";}
if($timestre=="03"){ $mes_desde="07"; $mes_hasta="09"; $mdes_trim="III-TRIMESTRE";}
if($timestre=="04"){ $mes_desde="10"; $mes_hasta="12"; $mdes_trim="IV-TRIMESTRE";}


$mcontrol = array (0,0,0,0,0,0,0,0,0,0);
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
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); } if($utf_rpt=="SI"){ $php_os="WINNT";}
   $mano=substr($Fec_Fin_Ejer,0,4);    $criterio1="Desde: ".$mesd." Hasta: ".$mesh." Ejercicio Fiscal: ".$mano;    $criterio2="";  

   $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
   $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; }
   $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2; $p=3; $h=$c+1+$p; 
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presup_d,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
   $ls=$c;  $lc=$ls+1+$p;   
   
   
   
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
   
  $StrSQL = "DELETE FROM pre020 Where (tipo_registro='S') and (nombre_usuario='".$cod_mov."')";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
  if($asig_global=="S"){$sql_Asignacion="asignado,";}
  $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'S' as tipo_registro,cod_presup,cod_fuente,denominacion,substr(cod_presup,1,".$ls.") as cod_categoria,"."'' as denomina_cat,substr(cod_presup,".$ini.",".$p.") as cod_partida,'' as denomina_par,status_dist,func_inv,ord_cord,aplicacion,cod_unidad_ejec, ";
  $StrSQL=$StrSQL.$sql_Asignacion." disponible,disp_diferida,".$sql_Compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.", "."0 as compromisom,0 as causadom, 0 as pagadom, 0 as TrasladosM, 0 as TrasladonM, 0 as AdicionM, 0 as DisminucionM, 0 as DiferidoM ";
  $StrSQL=$StrSQL." FROM PRE001 WHERE length(cod_presup)=".$l_c;
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

  $ordenar=" ORDER BY pre020.cod_partida";   
  $sSQL ="Select distinct substr(cod_presup,".$ini.",".$p.") as codigo,denominacion from pre001 where length(cod_presup)=".$h." order by codigo "; $res=pg_query($sSQL); 
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["codigo"]; $denominacion=$registro["denominacion"]; 
     $sql="update pre020 set denomina_par='$denominacion' where tipo_registro='S' and nombre_usuario='$cod_mov' and cod_partida='$cod_presup'";$resultado=pg_exec($conn,$sql); 
  }
  $temp=$sSQL;
  if($php_os=="WINNT"){$ingresos=$ingresos; }else{$ingresos=utf8_decode($ingresos); }
  
  	$sSQL = "SELECT pre020.cod_presup,pre020.cod_fuente, pre020.denominacion,pre020.cod_categoria,pre020.denomina_cat,pre020.cod_partida,pre020.denomina_par,substring(pre020.cod_partida,1,3) as partida, pre020.Asignado, pre020.Traslados, pre020.Trasladon, pre020.Adicion, 
			 pre020.disminucion, pre020.compromiso, pre020.causado, pre020.pagado, pre020.disponible, 
			(pre020.Traslados-pre020.Trasladon+pre020.Adicion-pre020.Disminucion) AS Modificaciones,(pre020.Traslados+pre020.Adicion) AS Aumentos, (pre020.Trasladon+pre020.Disminucion) AS Disminuciones,
			(pre020.Asignado+pre020.Traslados-pre020.Trasladon+pre020.Adicion-pre020.Disminucion) AS Asig_Actualizada, (pre020.Asignado+pre020.Traslados-pre020.Trasladon+pre020.Adicion-pre020.Disminucion-pre020.Compromiso) AS Disponibilidad
			 FROM pre020 WHERE tipo_registro='S' and nombre_usuario='$cod_mov' ".$ordenar;
   
	$sSQL = " SELECT substring(pre020.cod_partida,1,3) as partida, pre020.denomina_par, sum(pre020.causado) as causado FROM pre020 WHERE tipo_registro='S' and nombre_usuario='$cod_mov' group by partida,denomina_par order by partida ";
	
	require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $mdes_trim; $ffechar=date("d-m-Y");
           $this->rect(10,7,200,35); 
		   $this->SetFont('Arial','',6);
		   $this->Cell(100,4,'CODIGO PRESUPUESTARIO DEL ENTE: A 01240',0,0);
		   $this->Cell(100,4,'FECHA : '.$ffechar,0,1,'R');
		   $this->Cell(130,4,'DENOMINACION DEL ENTE: EMPRESA NOROCCIDENTAL DE MANTENIMIENTO Y OBRAS HIDRAULICAS, C.A.',0,1);
		   $this->Cell(100,4,'ORGANISMO DE ADSCRIPCION: MINISTERIO DEL PODER POPULAR PARA EL AMBIENTE',0,1);
		   $this->Ln(5);
		   $this->SetFont('Arial','B',12);
		   $this->Cell(200,4,'COMENTARIO SOBRE LA SITUACION DEL ENTE',0,1,'C');
		   $this->Ln(5);
		   $this->SetFont('Arial','',10);
		   $this->Cell(100,4,$mdes_trim,0,1);
		   $this->rect(10,45,200,225); 
		   $this->Ln(10);
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-35);
			$this->SetFont('Arial','',9);
			$this->Cell(200,10,' ',0,1,'C');		
		    $this->Cell(190,2,'__________________________________',0,1,'R');	
		    $this->Cell(190,6,'   FIRMA DE LA MAXIMA AUTORIDAD   ',0,1,'R');	
		}
	  }
	$pdf=new PDF('P', 'mm', Letter);
	$pdf->AliasNbPages();
   	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true, 35); 
	$pdf->SetFont('Arial','',9);
	
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell(100,6,'EN CUANTO A LOS INGRESOS :',0,1);
	$pdf->Ln(2);
	$pdf->SetFont('Arial','',9);
	$pdf->MultiCell(200,4,$ingresos,0);
	$pdf->Ln(10);
	
	//$pdf->MultiCell(200,4,$temp,0);
	
	
	
	$res=pg_query($sSQL); $filas=pg_num_rows($res); $total_causado=0;
	while($registro=pg_fetch_array($res)){ $causado=$registro["causado"]; $causado=round($causado,0); $total_causado=$total_causado+$causado;	}
	$total_causado=parte_entera_num($total_causado); 
	
	$pdf->SetFont('Arial','BU',10);
	$pdf->Cell(100,6,'EN CUANTO A LOS GASTOS :',0,1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(200,4,'- La ejecución de los gastos para este período alcanzó la suma de '.$total_causado.', distribuidos de la siguiente manera :',0,1);
	$pdf->Ln(2);
	
	$res=pg_query($sSQL); $filas=pg_num_rows($res);
	while($registro=pg_fetch_array($res)){ 
		$partida=$registro["partida"]; $denomina_par=$registro["denomina_par"]; $causado=$registro["causado"]; $causado=round($causado,0); $causado=parte_entera_num($causado);
		$pdf->Cell(130,6,'- '.$denomina_par,0,0);
		$pdf->Cell(20,6,$causado,0,1,'R'); 
		
	}
	$pdf->Output(); 
	
  $StrSQL = "DELETE FROM pre020 Where (tipo_registro='S') And (nombre_usuario='".$cod_mov."')";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
?>

    