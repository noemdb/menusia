<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$timestre=$_GET["timestre"];} else { $timestre="01";}  $mes_desde="01"; $mes_hasta="03"; $mdes_trim="I-TRIMESTRE";
$asig_global="S"; $equipo=getenv("COMPUTERNAME"); $cod_mov="Mpre020".$usuario_sia; $php_os=PHP_OS;
if($timestre=="01"){ $mes_desde="01"; $mes_hasta="03"; $mdes_trim="I TRIMESTRE"; }
if($timestre=="02"){ $mes_desde="04"; $mes_hasta="06"; $mdes_trim="II TRIMESTRE";}
if($timestre=="03"){ $mes_desde="07"; $mes_hasta="09"; $mdes_trim="III TRIMESTRE";}
if($timestre=="04"){ $mes_desde="10"; $mes_hasta="12"; $mdes_trim="IV TRIMESTRE";}
$cod_proy="678"; $den_proy="Construcción del Sistema Hidraulico Yacambu Quibor";
$ano_inicio="1974"; $unidad_proy="Sistema";
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
   $mano=substr($Fec_Fin_Ejer,0,4);    $criterio1="Desde: ".$mesd." Hasta: ".$mesh." Ejercicio Fiscal: ".$mano;    $criterio2=""; 
   $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
   $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; }
   $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2; $p=3; $h=$c+1+$p; 
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presup_d,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
   $ls=$c;  $lc=$ls+1+$p;    $per_hasta=$mes_hasta;  
  $sql_Asignacion=""; $sql_Traslados=""; $sql_Trasladon=""; $sql_Adicion=""; $sql_Disminucion=""; 
  $sql_Compromiso=""; $sql_Diferido=""; $sql_Causado=""; $sql_Pagado=""; $sql_Diferido="";
  $sql_TrasladosM=""; $sql_TrasladonM=""; $sql_AdicionM=""; $sql_DisminucionM=""; 
  $sql_compromisom=""; $sql_DiferidoM=""; $sql_causadom=""; $sql_pagadom=""; $sql_Disp_Diferida="";
  If($per_hasta==0){ $sql_Traslados="0 as Traslados,";  $sql_Trasladon="0 as Trasladon,";  $sql_Adicion="0 as adicion,";
     $sql_Disminucion="0 as Disminucion,"; $sql_Compromiso="0 as Compromiso,"; $sql_Causado="0 as Causado,";
     $sql_Pagado="0 as Pagado,"; $sql_Asignacion="0 as asignado,"; $sql_Asignacion="asignado,";  $sql_Diferido="0 as Diferido"; 
	 
	 $sql_TrasladosM="0 as TrasladosM,";  $sql_TrasladonM="0 as TrasladonM,";  $sql_AdicionM="0 as adicionM,";
     $sql_DisminucionM="0 as DisminucionM,"; $sql_compromisom="0 as compromisom,"; $sql_causadom="0 as causadom,";
     $sql_pagadom="0 as pagadom,"; $sql_DiferidoM="0 as DiferidoM"; $sql_Disp_Diferida="0 as disp_diferida,";
	 
	 }
   else{for ($i=1; $i <= $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==1){$scampo = "(sum(Traslados".$pos.")";  $scampo1 = "(sum(Trasladon".$pos.")";  $scampo2 = "(sum(adicion".$pos.")";
           $scampo3 = "(sum(Disminucion".$pos.")";  $scampo7 = "(sum(asignado".$pos.")"; $scampo4 = "(sum(Compromiso".$pos.")";  $scampo5 = "(sum(Causado".$pos.")";
           $scampo6 = "(sum(Pagado".$pos.")"; $scampo8 = "(sum(Diferido".$pos.")";}
       else{$scampo = "+sum(Traslados".$pos.")" ; $scampo1 = "+sum(Trasladon".$pos.")";$scampo2 = "+sum(adicion".$pos.")";
           $scampo3 = "+sum(Disminucion".$pos.")"; $scampo7 = "+sum(asignado".$pos.")"; $scampo4 = "+sum(Compromiso".$pos.")";$scampo5 = "+sum(Causado".$pos.")";
           $scampo6 = "+sum(Pagado".$pos.")";  $scampo8 = "+sum(Diferido".$pos.")";}
      $sql_Traslados=$sql_Traslados.$scampo;  $sql_Trasladon=$sql_Trasladon.$scampo1; $sql_Adicion=$sql_Adicion.$scampo2;
      $sql_Disminucion=$sql_Disminucion.$scampo3;  $sql_Asignacion=$sql_Asignacion.$scampo7; 	
      $sql_Compromiso=$sql_Compromiso.$scampo4;$sql_Causado=$sql_Causado.$scampo5; $sql_Pagado=$sql_Pagado.$scampo6;$sql_Diferido=$sql_Diferido.$scampo8;	  
	} 
    $sql_Traslados=$sql_Traslados.") as Traslados,"; $sql_Trasladon=$sql_Trasladon.") as Trasladon,";
    $sql_Adicion=$sql_Adicion.") as adicion,"; $sql_Disminucion=$sql_Disminucion.") as Disminucion,";
    $sql_Compromiso=$sql_Compromiso.") as Compromiso,"; $sql_Causado=$sql_Causado.") as Causado,";
    $sql_Pagado=$sql_Pagado.") as Pagado,"; $sql_Asignacion=$sql_Asignacion.") as asignado,";
    $sql_Diferido=$sql_Diferido.") as Diferido";	
	
	for ($i=$mes_desde; $i <= $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==$mes_desde){$scampo = "(sum(Traslados".$pos.")";  $scampo1 = "(sum(Trasladon".$pos.")";  $scampo2 = "(sum(adicion".$pos.")";
           $scampo3 = "(sum(Disminucion".$pos.")";  $scampo7 = "(sum(asignado".$pos.")"; $scampo4 = "(sum(Compromiso".$pos.")";  $scampo5 = "(sum(Causado".$pos.")";
           $scampo6 = "(sum(Pagado".$pos.")"; $scampo8 = "(sum(Diferido".$pos.")"; }
       else{$scampo = "+sum(Traslados".$pos.")" ; $scampo1 = "+sum(Trasladon".$pos.")";$scampo2 = "+sum(adicion".$pos.")";
           $scampo3 = "+sum(Disminucion".$pos.")"; $scampo7 = "+sum(asignado".$pos.")"; $scampo4 = "+sum(Compromiso".$pos.")";$scampo5 = "+sum(Causado".$pos.")";
           $scampo6 = "+sum(Pagado".$pos.")";  $scampo8 = "+sum(Diferido".$pos.")";}	
	  $sql_TrasladosM=$sql_TrasladosM.$scampo;  $sql_TrasladonM=$sql_TrasladonM.$scampo1; $sql_AdicionM=$sql_AdicionM.$scampo2; $sql_DisminucionM=$sql_DisminucionM.$scampo3;  
      $sql_compromisom=$sql_compromisom.$scampo4;$sql_causadom=$sql_causadom.$scampo5; $sql_pagadom=$sql_pagadom.$scampo6; $sql_DiferidoM=$sql_DiferidoM.$scampo7;
	}  
    $sql_TrasladosM=$sql_TrasladosM.") as TrasladosM,"; $sql_TrasladonM=$sql_TrasladonM.") as TrasladonM,";
    $sql_AdicionM=$sql_AdicionM.") as adicionM,"; $sql_DisminucionM=$sql_DisminucionM.") as DisminucionM,";
    $sql_compromisom=$sql_compromisom.") as compromisom,"; $sql_causadom=$sql_causadom.") as causadom,";
    $sql_pagadom=$sql_pagadom.") as pagadom,";   $sql_DiferidoM=$sql_DiferidoM.") as DiferidoM";	
	
	
   }
   //if($asig_global=="S"){$sql_Asignacion="sum(asignado),";}  
   
  $StrSQL = "DELETE FROM pre020 Where (tipo_registro='M') and (nombre_usuario='".$cod_mov."')";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
  
  $sql_codigo="substr(cod_presup,".$ini.",3),''"; $sql_grupo="substr(cod_presup,".$ini.",3)";
  $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'M' as tipo_registro, ".$sql_codigo.", '','','','','','A','F','O','T','', ";
  $StrSQL=$StrSQL."sum(asignado),".$sql_Asignacion."sum(disp_diferida),".$sql_Compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.",".$sql_compromisom.$sql_causadom.$sql_pagadom.$sql_TrasladosM.$sql_TrasladonM.$sql_AdicionM.$sql_DisminucionM.$sql_DiferidoM;
  $StrSQL=$StrSQL." FROM PRE001 WHERE length(cod_presup)=".$l_c."  group by ".$sql_grupo;
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  $ordenar=" ORDER BY pre020.cod_partida";   
  	$sSQL = "SELECT pre020.cod_presup,pre020.cod_fuente, pre020.denominacion,pre020.cod_categoria,pre020.denomina_cat,pre020.cod_partida,pre020.denomina_par,substring(pre020.cod_partida,1,3) as partida, pre020.Asignado, pre020.Traslados, pre020.Trasladon, pre020.Adicion, 
			 pre020.disminucion, pre020.compromiso, pre020.causado, pre020.pagado, pre020.disponible, pre020.causadom, 
			(pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS Modificaciones,(pre020.Traslados+pre020.Adicion) AS Aumentos, (pre020.Trasladon+pre020.Disminucion) AS Disminuciones,
			(pre020.asignado+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS Asig_Actualizada, (pre020.Asignado+pre020.Traslados-pre020.Trasladon+pre020.Adicion-pre020.Disminucion-pre020.Compromiso) AS Disponibilidad,
			(pre020.diferidom+pre020.trasladosm-pre020.trasladonm+pre020.adicionm-pre020.disminucionm) AS asig_act_per,
			(pre020.disponible+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS asig_act_acum
			 FROM pre020 WHERE tipo_registro='M' and nombre_usuario='$cod_mov' ".$ordenar;  
		
	require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $mdes_trim; $ffechar=date("d-m-Y");
           $this->rect(10,7,260,35); 
		   $this->SetFont('Arial','',6);
		   $this->Cell(130,4,'CODIGO PRESUPUESTARIO DEL ENTE: A678',0,0);
		   $this->Cell(130,4,'FECHA : '.$ffechar,0,1,'R');
		   $this->Cell(130,4,'DENOMINACION DEL ENTE: SISTEMA HIDRAULICO YACAMBU QUIBOR C.A.',0,1);
		   $this->Cell(130,4,'ORGANISMO DE ADSCRIPCION: MINISTERIO DEL PODER POPULAR PARA EL AMBIENTE',0,1);
		   $this->Cell(130,4,'PERIODO: '.$mdes_trim,0,1);
		   $this->Ln(5);
		   $this->SetFont('Arial','B',12);
		   $this->Cell(260,4,'EJECUCIÓN FISICA DE LAS METAS DEL PROYECTO',0,1,'C');
		   $this->Ln(10);		   
		   $this->SetFont('Arial','',6);					
		   $this->Cell(13,2,'','RLT',0,'C');
		   $this->Cell(83,2,'','RLT',0,'C');
		   $this->Cell(17,2,'','RLT',0,'C');
		   $this->Cell(17,2,'','RLT',0,'C');
		   $this->Cell(10,2,'','RLT',0,'C');
		   $this->Cell(20,2,'','T',0,'C');
		   $this->Cell(20,2,'','T',0,'C');
		   $this->Cell(40,2,'','TRL',0,'C');
		   $this->Cell(40,2,'','TRL',1,'C');		   
		   $this->Cell(13,3,'','RL',0,'C');
		   $this->Cell(83,3,'','RL',0,'C');
		   $this->Cell(17,3,'AÑO DE INICIO','RL',0,'C');
		   $this->Cell(17,3,'AÑO DE','RL',0,'C');
		   $this->Cell(10,3,'UNIDAD','RL',0,'C');
		   $this->Cell(20,3,'PRESUPUESTO',0,0,'C');
		   $this->Cell(20,3,'PRESUPUESTO',0,0,'C');
		   $this->Cell(40,3,$mdes_trim,'RL',0,'C');
		   $this->Cell(40,3,'ACUMULADO A '.$mdes_trim,'RL',1,'C');  
		   $this->Cell(13,3,'CODIGO','RL',0,'C');
		   $this->Cell(83,3,'DENOMINACION','RL',0,'C');
		   $this->Cell(17,3,'DEL','RL',0,'C');
		   $this->Cell(17,3,'CULMINACION','RL',0,'C');
		   $this->Cell(10,3,'DE','RL',0,'C');
		   $this->Cell(20,3,'APROBADO','B',0,'C');
		   $this->Cell(20,3,'MODIFICADO','B',0,'C');
		   $this->Cell(40,3,'','BRL',0,'C');
		   $this->Cell(40,3,'','BRL',1,'C');
		   $this->Cell(13,3,'','RL',0,'C');
		   $this->Cell(83,3,'','RL',0,'C');
		   $this->Cell(17,3,'PROYECTO','RL',0,'C');
		   $this->Cell(17,3,'PROYECTO','RL',0,'C');
		   $this->Cell(10,3,'MEDIDA','RL',0,'C');
		   $this->Cell(20,3,'CANTIDAD','RL',0,'C');
		   $this->Cell(20,3,'CANTIDAD','RL',0,'C');
		   $this->Cell(20,3,'CANTIDAD','RL',0,'C');
		   $this->Cell(20,3,'CANTIDAD','RL',0,'C');
		   $this->Cell(20,3,'CANTIDAD','RL',0,'C');
		   $this->Cell(20,3,'CANTIDAD','RL',1,'C');		   
		   $this->Cell(13,3,'','RLB',0,'C');
		   $this->Cell(83,3,'','RLB',0,'C');
		   $this->Cell(17,3,'','RLB',0,'C');
		   $this->Cell(17,3,'','RLB',0,'C');
		   $this->Cell(10,3,'','RLB',0,'C');
		   $this->Cell(20,3,'','RLB',0,'C');
		   $this->Cell(20,3,'','RLB',0,'C');
		   $this->Cell(20,3,'PROGRAMADA','RLB',0,'C');
		   $this->Cell(20,3,'EJECUTADA','RLB',0,'C');
		   $this->Cell(20,3,'PROGRAMADA','RLB',0,'C');
		   $this->Cell(20,3,'EJECUTADA','RLB',1,'C');		   
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
		}
	  }
	$pdf=new PDF('L', 'mm', Letter);
	$pdf->AliasNbPages();
   	$pdf->AddPage();
	$pdf->SetFont('Arial','',7);
	$res=pg_query($sSQL); $filas=pg_num_rows($res); $total_causado=0; $total_causadom=0; $total_asignado=0; $total_asig_act=0; 
	$total_disponible=0; $total_asig_act_per=0; $total_asig_act_acum=0;
	while($registro=pg_fetch_array($res)){ 
	  $causado=$registro["causado"]; $causado=round($causado,0);  $causadom=$registro["causadom"]; $causadom=round($causadom,0);	  
	  $asignado=$registro["asignado"]; $asignado=round($asignado,0);  $asig_actualizada=$registro["asig_actualizada"]; $asig_actualizada=round($asig_actualizada,0);
	  $asig_act_per=$registro["asig_act_per"]; $asig_act_per=round($asig_act_per,0);  $asig_act_acum=$registro["asig_act_acum"]; $asig_act_acum=round($asig_act_acum,0);
	  $total_causado=$total_causado+$causado; $total_causadom=$total_causadom+$causadom;	
	  $total_asignado=$total_asignado+$asignado;  $total_asig_act=$total_asig_act+$asig_actualizada;	  
	  $total_asig_act_per=$total_asig_act_per+$asig_act_per;	  $total_asig_act_acum=$total_asig_act_acum+$asig_act_acum;
      $total_disponible=$total_disponible+$registro["disponible"];
	}
	$total_causado=parte_entera_num($total_causado); $total_causadom=parte_entera_num($total_causadom);
	$total_asignado=parte_entera_num($total_asignado); $total_asig_act=parte_entera_num($total_asig_act);
	$total_asig_act_per=parte_entera_num($total_asig_act_per); $total_asig_act_acum=parte_entera_num($total_asig_act_acum);	
	$pdf->Cell(13,8,$cod_proy,1,0,'C');
    $pdf->Cell(83,8,$den_proy,1,0,'C');
    $pdf->Cell(17,8,$ano_inicio,1,0,'C');
    $pdf->Cell(17,8,$mano,1,0,'C');
    $pdf->Cell(10,8,$unidad_proy,1,0,'C');
    $pdf->Cell(20,8,$total_asignado,1,0,'R');
    $pdf->Cell(20,8,$total_asig_act,1,0,'R');
    $pdf->Cell(20,8,$total_asig_act_per,1,0,'R');
    $pdf->Cell(20,8,$total_causadom,1,0,'R');
    $pdf->Cell(20,8,$total_asig_act_acum,1,0,'R');
    $pdf->Cell(20,8,$total_causado,1,1,'R');		   
	$pdf->Output(); 	
    $StrSQL = "DELETE FROM pre020 Where (tipo_registro='M') And (nombre_usuario='".$cod_mov."')";
    $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
  ?>