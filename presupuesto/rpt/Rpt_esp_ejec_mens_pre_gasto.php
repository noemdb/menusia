<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$mes=$_GET["mes"];$cod_cat=$_GET["cod_cat"];$cod_part=$_GET["cod_part"]; $cod_unidad=$_GET["cod_unidad"]; $acum=$_GET["acum"];} 
else { $mes="01"; $cod_cat="";$cod_unidad=""; $cod_part=""; $acum="N"; }  $mes_desde=$mes; $mes_hasta=$mes; 
$asig_global="S"; $equipo=getenv("COMPUTERNAME"); $cod_mov="Mpre020".$usuario_sia; $php_os=PHP_OS;
$cod_fuente_d=""; $cod_fuente_h="zz";

$mcontrol = array (0,0,0,0,0,0,0,0,0,0);
function buscar_control($clave, $formato){  global $mcontrol;  $j=0;
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} } 
  return $actual;
}
function Rellenarcerosizq($str,$n){$numeroarellenar=$n-strlen($str); $texto=""; for ($i=0; $i < $numeroarellenar; $i++){$texto=$texto."0";} $texto=$texto.$str; return $texto;}
if ($mes_desde=='01'){$mesd="ENERO";}elseif ($mes_desde=='02'){$mesd="FEBRERO";}elseif ($mes_desde=='03'){$mesd="MARZO";}elseif ($mes_desde=='04'){$mesd="ABRIL";}elseif ($mes_desde=='05'){$mesd="MAYO";}elseif ($mes_desde=='06'){$mesd="JUNIO";}elseif ($mes_desde=='07'){$mesd="JULIO";}elseif ($mes_desde=='08'){$mesd="AGOSTO";}elseif ($mes_desde=='09'){$mesd="SEPTIEMBRE";}elseif ($mes_desde=='10'){$mesd="OCTUBRE";}elseif ($mes_desde=='11'){$mesd="NOVIEMBRE";}elseif ($mes_desde=='12'){$mesd="DICIEMBRE";}
if ($mes_hasta=='01'){$mesh="ENERO";}elseif ($mes_hasta=='02'){$mesh="FEBRERO";}elseif ($mes_hasta=='03'){$mesh="MARZO";}elseif ($mes_hasta=='04'){$mesh="ABRIL";}elseif ($mes_hasta=='05'){$mesh="MAYO";}elseif ($mes_hasta=='06'){$mesh="JUNIO";}elseif ($mes_hasta=='07'){$mesh="JULIO";}elseif ($mes_hasta=='08'){$mesh="AGOSTO";}elseif ($mes_hasta=='09'){$mesh="SEPTIEMBRE";}elseif ($mes_hasta=='10'){$mesh="OCTUBRE";}elseif ($mes_hasta=='11'){$mesh="NOVIEMBRE";}elseif ($mes_hasta=='12'){$mesh="DICIEMBRE";}
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
   $mano=substr($Fec_Fin_Ejer,0,4);    $criterio1="PRESUPUESTO: ".$mano;    $criterio2="";
   $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
   $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; }
   $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2; $h=$c+1+$p; 
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presup_d,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
   $ls=$c;  $lc=$ls+1+$p;  $criterio_s="";
   $cod_presup_d=str_replace("X","?",$formato_presup); $cod_presup_h=str_replace("X","?",$formato_presup);   
    $sql="SELECT denominacion from pre001 where cod_presup='$cod_unidad'"; $res=pg_query($sql); $filas=pg_num_rows($res);
	if($filas>0){$registro=pg_fetch_array($res); $criterio_s=$cod_unidad." ".$registro["denominacion"];
      if(strlen($cod_unidad)==2){$criterio_s="PROYECTO: ". $criterio_s;  $cod_presup_d=$cod_unidad.substr($cod_presup_d,2,30);  } 
	  if(strlen($cod_unidad)==5){$criterio_s="ACCION: ". $criterio_s; $cod_presup_d=$cod_unidad.substr($cod_presup_d,5,30); } 
	  $cod_presup_h= $cod_presup_d;
	}
	
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
  $sql_Asignacion=""; $sql_Traslados=""; $sql_Trasladon=""; $sql_Adicion=""; $sql_Disminucion=""; 
  $sql_Compromiso=""; $sql_Diferido=""; $sql_Causado=""; $sql_Pagado=""; $sql_Diferido="";
  $sql_TrasladosM=""; $sql_TrasladonM=""; $sql_AdicionM=""; $sql_DisminucionM=""; 
  $sql_compromisom=""; $sql_DiferidoM=""; $sql_causadom=""; $sql_pagadom=""; $sql_Disp_Diferida="";
  If($per_hasta==0){ $sql_Traslados="0 as Traslados,";  $sql_Trasladon="0 as Trasladon,";  $sql_Adicion="0 as adicion,";
     $sql_Disminucion="0 as Disminucion,"; $sql_Compromiso="0 as Compromiso,"; $sql_Causado="0 as Causado,";
     $sql_Pagado="0 as Pagado,"; $sql_Asignacion="0 as asignado,"; $sql_Asignacion="sum(asignado),";  $sql_Diferido="0 as Diferido"; 
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
    	
	
	for ($i=$mes_desde; $i <= $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==$mes_desde){$scampo = "(sum(Traslados".$pos.")";  $scampo1 = "(sum(Trasladon".$pos.")";  $scampo2 = "(sum(adicion".$pos.")";
           $scampo3 = "(sum(Disminucion".$pos.")";  $scampo7 = "(sum(asignado".$pos.")"; $scampo4 = "(sum(compromiso".$pos.")";  $scampo5 = "(sum(Causado".$pos.")";
           $scampo6 = "(sum(Pagado".$pos.")"; $scampo8 = "(sum(Diferido".$pos.")"; }
       else{$scampo = "+sum(Traslados".$pos.")" ; $scampo1 = "+sum(Trasladon".$pos.")";$scampo2 = "+sum(adicion".$pos.")";
           $scampo3 = "+sum(Disminucion".$pos.")"; $scampo7 = "+sum(asignado".$pos.")"; $scampo4 = "+sum(compromiso".$pos.")";$scampo5 = "+sum(Causado".$pos.")";
           $scampo6 = "+sum(Pagado".$pos.")";  $scampo8 = "+sum(Diferido".$pos.")";}	
	  $sql_TrasladosM=$sql_TrasladosM.$scampo;  $sql_TrasladonM=$sql_TrasladonM.$scampo1; $sql_AdicionM=$sql_AdicionM.$scampo2; $sql_DisminucionM=$sql_DisminucionM.$scampo3;  
      $sql_compromisom=$sql_compromisom.$scampo4;$sql_causadom=$sql_causadom.$scampo5; $sql_pagadom=$sql_pagadom.$scampo6; $sql_DiferidoM=$sql_DiferidoM.$scampo7;
	}  
    $sql_TrasladosM=$sql_TrasladosM.") as TrasladosM,"; $sql_TrasladonM=$sql_TrasladonM.") as TrasladonM,";
    $sql_AdicionM=$sql_AdicionM.") as adicionM,"; $sql_DisminucionM=$sql_DisminucionM.") as DisminucionM,";
    $sql_compromisom=$sql_compromisom.") as compromisom,"; $sql_causadom=$sql_causadom.") as causadom,";
    $sql_pagadom=$sql_pagadom.") as pagadom,";   $sql_DiferidoM=$sql_DiferidoM.") as DiferidoM";

	$sql_Diferido="";
    for ($i=1; $i < $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==1){$scampo = "(sum(asignado+traslados".$pos."+adicion".$pos."-trasladon".$pos."-disminucion".$pos."-compromiso".$pos.")"; }
       else{$scampo = "+sum(traslados".$pos."+adicion".$pos."-trasladon".$pos."-disminucion".$pos."-compromiso".$pos.")"; }
      $sql_Diferido=$sql_Diferido.$scampo;  
	} 
	IF($sql_Diferido==""){$sql_Diferido="0 as Diferido";}else{$sql_Diferido=$sql_Diferido.") as Diferido";}	
   }   
   
  $StrSQL = "DELETE FROM pre020 Where (tipo_registro='M') and (nombre_usuario='".$cod_mov."')";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
  
  $sql_codigo="substr(cod_presup,".$ini.",".$p."),''"; $sql_grupo="substr(cod_presup,".$ini.",".$p.")";
  $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'M' as tipo_registro, ".$sql_codigo.", '','','','','','A','F','O','T','', ";
  $StrSQL=$StrSQL."sum(asignado),".$sql_Asignacion."sum(disp_diferida),".$sql_Compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.",".$sql_compromisom.$sql_causadom.$sql_pagadom.$sql_TrasladosM.$sql_TrasladonM.$sql_AdicionM.$sql_DisminucionM.$sql_DiferidoM;
  $StrSQL=$StrSQL." FROM PRE001 WHERE length(cod_presup)=".$l_c." and ".$criterio."  group by ".$sql_grupo;
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

  //echo $StrSQL;
  
  $ordenar=" ORDER BY pre020.cod_partida"; 
  $sSQL ="Select distinct substr(cod_presup,".$ini.",".$p.") as codigo,denominacion from pre001 where length(cod_presup)=".$h; $res=pg_query($sSQL); 
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["codigo"]; $denominacion=$registro["denominacion"]; 
     $sql="update pre020 set denomina_par='$denominacion',denominacion='$denominacion',cod_partida=cod_presup where tipo_registro='M' and nombre_usuario='$cod_mov' and cod_presup='$cod_presup'";$resultado=pg_exec($conn,$sql); 
  }
  
  	$sSQL = "SELECT pre020.cod_presup,pre020.cod_fuente, pre020.denominacion,pre020.cod_categoria,pre020.denomina_cat,pre020.cod_partida,pre020.denomina_par,substring(pre020.cod_partida,1,3) as partida, pre020.Asignado, pre020.Traslados, pre020.Trasladon, pre020.Adicion, 
			 pre020.disminucion, pre020.compromiso, pre020.causado, pre020.pagado, pre020.disponible, pre020.compromisom, pre020.causadom, pre020.pagadom, pre020.diferidom, pre020.diferido,
			(pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS Modificaciones,(pre020.Traslados+pre020.Adicion) AS Aumentos, (pre020.Trasladon+pre020.Disminucion) AS Disminuciones,
			(pre020.asignado+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS asig_actualizada, (pre020.Asignado+pre020.Traslados-pre020.Trasladon+pre020.Adicion-pre020.Disminucion-pre020.Compromiso) AS Disponibilidad,
			(pre020.diferidom+pre020.trasladosm-pre020.trasladonm+pre020.adicionm-pre020.disminucionm) AS asig_act_per,
			(pre020.disponible+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS asig_act_acum
			 FROM pre020 WHERE tipo_registro='M' and nombre_usuario='$cod_mov' ".$ordenar;
			 
			 
	
  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $mesd; global $criterio1; global $criterio_s; global $acum;
		   $ffechar=date("d-m-Y");
		   $this->SetFont('Arial','',6);
		   $this->Cell(130,4,'CODIGO PRESUPUESTARIO DEL ENTE: A 01240',0,0);
		   $this->Cell(130,4,'FECHA : '.$ffechar,0,1,'R');
		   $this->Cell(130,4,'DENOMINACION DEL ENTE: EMPRESA NOROCCIDENTAL DE MANTENIMIENTO Y OBRAS HIDRAULICAS C.A.',0,0);
		   $this->Cell(130,4,'PAGINA : '.$this->PageNo(),0,1,'R');
		   $this->Cell(130,4,'ORGANISMO DE ADSCRIPCION: MINISTERIO DEL PODER POPULAR PARA EL AMBIENTE',0,1);		   
		   if ($criterio_s<>''){
			   $this->Cell(150,4,$criterio_s,0,1);
			   $this->rect(10,7,260,40); 
		   }else{ $this->rect(10,7,260,36);  }
		   $this->Cell(100,4,$criterio1,0,1);	
		   $this->Cell(130,4,'MES: '.$mesd,0,1);
		   $this->Ln(5);
		   $this->SetFont('Arial','B',12);
		   $this->Cell(260,4,'EJECUCION FINANCIERA MENSUAL DEL PRESUPUESTO DE GASTOS',0,1,'C');
		   $this->Ln(8);
		   
		   $this->SetFont('Arial','',6);					
		   $this->Cell(15,2,'','RLT',0,'C');
		   $this->Cell(60,2,'','RLT',0,'C');
		   $this->Cell(20,2,'','RLT',0,'C');
		   $this->Cell(20,2,'','RLT',0,'C');
		   $this->Cell(60,2,'','T',0,'C');
		   $this->Cell(17,2,'','RLT',0,'C');		   
		   $this->Cell(14,2,'','RLT',0,'C');
		   $this->Cell(14,2,'','RLT',0,'C');
		   $this->Cell(40,2,'','TRL',1,'C');


		   $this->Cell(15,3,'','RL',0,'C');
		   $this->Cell(60,3,'','RL',0,'C');
		   $this->Cell(20,3,'PRESUPUESTO','RL',0,'C');
		   $this->Cell(20,3,'','RL',0,'C');	
		   $this->Cell(60,3,'EJECUTADO','BRL',0,'C');
		   $this->Cell(17,3,'%','RL',0,'C');
		   $this->Cell(14,3,'%','RL',0,'C');
		   $this->Cell(14,3,'%','RL',0,'C');
		   $this->Cell(40,3,'DISPONIBILIDAD PRESUPUESTARIA','BRL',1,'C');
		   
		   
		   
		   $this->Cell(15,3,'PARTIDA','RL',0,'C');
		   $this->Cell(60,3,'DENOMINACION','RL',0,'C');
		   $this->Cell(20,3,'ANUAL','RL',0,'C');
		   $this->Cell(20,3,'PROGRAMADO','RL',0,'C');		
		   $this->Cell(20,3,'COMPROMISO','RL',0,'C');
		   $this->Cell(20,3,'CAUSADO','RL',0,'C');
		   $this->Cell(20,3,'PAGADO','RL',0,'C');
		   $this->Cell(17,3,'COMPROMISO','RL',0,'C');
		   $this->Cell(14,3,'CAUSADO','RL',0,'C');
		   $this->Cell(14,3,'PAGADO','RL',0,'C');
		   $this->Cell(20,3,'MES ANTERIOR','RL',0,'C');
		   $this->Cell(20,3,'A LA FECHA','RL',1,'C');
		   
		   
		   $this->Cell(15,2,'','RLB',0,'C');
		   $this->Cell(60,2,'','RLB',0,'C');
		   $this->Cell(20,2,'','RLB',0,'C');
		   $this->Cell(20,2,'','RLB',0,'C');
		   $this->Cell(20,2,'','RLB',0,'C');
		   $this->Cell(20,2,'','RLB',0,'C');
		   $this->Cell(20,2,'','RLB',0,'C');
		   $this->Cell(17,2,'','RLB',0,'C');
		   $this->Cell(14,2,'','RLB',0,'C');
		   $this->Cell(14,2,'','RLB',0,'C');
		   $this->Cell(20,2,'','RLB',0,'C');
		   $this->Cell(20,2,'','RLB',1,'C');	
           $x=$this->GetX();   $y=$this->GetY();
		   $l=198-$y;
		   $this->rect(10,$y,260,$l);
           $this->Line(25,$y,25,198); 
           $this->Line(85,$y,85,198);
           $this->Line(105,$y,105,198); 
           $this->Line(125,$y,125,198); 
           $this->Line(145,$y,145,198); 
           $this->Line(165,$y,165,198); 
           $this->Line(185,$y,185,198);
		   
           $this->Line(202,$y,202,198); 
           $this->Line(216,$y,216,198);	
           $this->Line(230,$y,230,198);	 
           $this->Line(250,$y,250,198);			   
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
		}
	  }
	$pdf=new PDF('L', 'mm', Letter);
	$pdf->AliasNbPages();
   	$pdf->AddPage();
	$pdf->SetFont('Arial','',6);
	$totalg=0; $totalf=0; $totald=0; $totale=0; $totalc=0; $totala=0; $totalp=0; $totalac=0;$totalcm=0; $totalam=0; $totalpm=0; $totalau=0; $totaldi=0;
	$res=pg_query($sSQL); $filas=pg_num_rows($res); 
	while($registro=pg_fetch_array($res)){ 
	    $cod_partida=$registro["cod_partida"];  $cod_presup=$registro["cod_presup"];  $denominacion=$registro["denominacion"];  $denomina_par=$registro["denomina_par"];
		if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denomina_par=utf8_decode($denomina_par); $denominacion=utf8_decode($denominacion);}
		$modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"];
        $aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];	$disponible=$registro["disponible"];			
		$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
		$comprometidom=$registro["compromisom"];   $causadom=$registro["causadom"]; $pagadom=$registro["pagadom"]; $diferido=$registro["diferido"];
		$asig_act_acum=$registro["asig_act_acum"]; $asig_act_per=$registro["asig_act_per"]; $dispon=$asig_actualizada-$comprometido;
		
		$modificaciones=round($modificaciones,0); $comprometido=round($comprometido,0); $causado=round($causado,0); $pagado=round($pagado,0);
		$aumentos=round($aumentos,0); $disminuciones=round($disminuciones,0); $disponible=round($disponible,0); $asignado=round($asignado,0);
		$asig_actualizada=round($asig_actualizada,0); $dispon=round($dispon,0); $asig_act_per=round($asig_act_per,0); $asig_act_acum=round($asig_act_acum,0);
		$comprometidom=round($comprometidom,0);  $causadom=round($causadom,0); $pagadom=round($pagadom,0);  $diferido=round($diferido,0); 
		if($acum=="S"){ $comprometidom=$comprometido; $causadom=$causado; $pagadom=$pagado; $asig_act_per=$asig_actualizada;	}
		$totalg=$totalg+$asignado; $totalf=$totalf+$asig_act_per; $totald=$totald+$dispon; $totale=$totale+$diferido; 		
		$totalc=$totalc+$comprometido; $totala=$totala+$causado; $totalp=$totalp+$pagado; $totalac=$totalac+$asig_act_acum;		
		$totalcm=$totalcm+$comprometidom; $totalam=$totalam+$causadom; $totalpm=$totalpm+$pagadom;	$totalau=$totalau+$aumentos; $totaldi=$totaldi+$disminuciones;	
		
		$porc1=0; if($asig_act_per>0){ $porc1=($comprometidom*100)/$asig_act_per;  }
		$porc2=0; if($asig_act_per>0){ $porc2=($causadom*100)/$asig_act_per;  }
		$porc3=0; if($asig_act_per>0){ $porc3=($pagadom*100)/$asig_act_per;  }			
		$asignado=parte_entera_num($asignado); $asig_actualizada=parte_entera_num($asig_actualizada);
	    $diferido=parte_entera_num($diferido); $comprometidom=parte_entera_num($comprometidom);
	    $causadom=parte_entera_num($causadom); $pagadom=parte_entera_num($pagadom); $asig_act_acum=parte_entera_num($asig_act_acum); $asig_act_per=parte_entera_num($asig_act_per); 
		$comprometido=parte_entera_num($comprometido);  $causado=parte_entera_num($causado); 	$pagado=parte_entera_num($pagado); $dispon=parte_entera_num($dispon); 
	    $porc1=parte_entera_num($porc1);  $porc2=parte_entera_num($porc2); $porc3=parte_entera_num($porc3); $aumentos=parte_entera_num($aumentos);  $disminuciones=parte_entera_num($disminuciones); 
		$pdf->SetFont('Arial','',6);
	    $pdf->Cell(15,3,$cod_partida,0,0); 		   
		$x=$pdf->GetX();   $y=$pdf->GetY(); $n=60; 		   
		$pdf->SetXY($x+$n,$y);
		$pdf->Cell(20,3,$asignado,0,0,'R');
        $pdf->Cell(20,3,$asig_act_per,0,0,'R');
		$pdf->Cell(20,3,$comprometidom,0,0,'R');
        $pdf->Cell(20,3,$causadom,0,0,'R'); 		
		$pdf->Cell(20,3,$pagadom,0,0,'R');
		$pdf->Cell(17,3,$porc1,0,0,'R');
		$pdf->Cell(14,3,$porc2,0,0,'R');
		$pdf->Cell(14,3,$porc3,0,0,'R');		
		$pdf->Cell(20,3,$diferido,0,0,'R');	
		$pdf->Cell(20,3,$dispon,0,1,'R');
		$pdf->SetXY($x,$y);
		$pdf->MultiCell($n,3,$denomina_par,0);
	}
	$porc1=0; if($totalf>0){ $porc1=($totalcm*100)/$totalf;  }
	$porc2=0; if($totalf>0){ $porc2=($totalam*100)/$totalf;  }
    $porc3=0; if($totalf>0){ $porc2=($totalpm*100)/$totalf;  }			
	$totalg=parte_entera_num($totalg);$totalf=parte_entera_num($totalf);  $totald=parte_entera_num($totald);  $totale=parte_entera_num($totale); 
	$totalc=parte_entera_num($totalc);$totala=parte_entera_num($totala);  $totalp=parte_entera_num($totalp);  $totalm=parte_entera_num($totalm); 
	$totalcm=parte_entera_num($totalcm);$totalam=parte_entera_num($totalam);  $totalpm=parte_entera_num($totalpm); $totalac=parte_entera_num($totalac);
	$totalau=parte_entera_num($totalau); $totaldi=parte_entera_num($totaldi); $porc1=parte_entera_num($porc1);  $porc2=parte_entera_num($porc2); $porc3=parte_entera_num($porc3);
	$x=$pdf->GetX();   $y=$pdf->GetY(); if($y<190){$y=190;}
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',6);	
	$pdf->Cell(15,5,'','T',0); 
	$pdf->Cell(60,5,'TOTALES','T',0,'C');
	$pdf->Cell(20,5,$totalg,'T',0,'R'); 
	$pdf->Cell(20,5,$totalf,'T',0,'R'); 
	$pdf->Cell(20,5,$totalcm,'T',0,'R'); 
	$pdf->Cell(20,5,$totalam,'T',0,'R');
	$pdf->Cell(20,5,$totalpm,'T',0,'R');
	$pdf->Cell(17,5,$porc1,'T',0,'R'); 
	$pdf->Cell(14,5,$porc2,'T',0,'R');
	$pdf->Cell(14,5,$porc3,'T',0,'R');
    $pdf->Cell(20,5,$totale,'T',0,'R'); 	
	$pdf->Cell(20,5,$totald,'T',1,'R');
	$pdf->Output(); 
	
  $StrSQL = "DELETE FROM pre020 Where (tipo_registro='M') And (nombre_usuario='".$cod_mov."')";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
  
 
?>