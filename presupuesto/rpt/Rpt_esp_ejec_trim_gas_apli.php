<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$timestre=$_GET["timestre"];$cod_cat=$_GET["cod_cat"];$cod_part=$_GET["cod_part"]; $cod_unidad=$_GET["cod_unidad"];  $tipo_rep=$_GET["tipo_rep"]; } 
else { $timestre="01"; $cod_cat="";$cod_unidad=""; $cod_part=""; $tipo_rep="PDF";}  $mes_desde="01"; $mes_hasta="03"; $mdes_trim="I-TRIMESTRE"; $mdes_meses="Enero-Marzo  "; 
$asig_global="S"; $equipo=getenv("COMPUTERNAME"); $cod_mov="Mpre020".$usuario_sia; $php_os=PHP_OS;
$cod_fuente_d=""; $cod_fuente_h="zz";
if($timestre=="01"){ $mes_desde="01"; $mes_hasta="03"; $mdes_trim="I TRIMESTRE"; $mdes_meses="Enero-Marzo  ";  }
if($timestre=="02"){ $mes_desde="04"; $mes_hasta="06"; $mdes_trim="II TRIMESTRE"; $mdes_meses="Abril-Junio  ";}
if($timestre=="03"){ $mes_desde="07"; $mes_hasta="09"; $mdes_trim="III TRIMESTRE"; $mdes_meses="Julio-Septiembre  "; }
if($timestre=="04"){ $mes_desde="10"; $mes_hasta="12"; $mdes_trim="IV TRIMESTRE"; $mdes_meses="Octubre-Diciembre  "; }
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
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
   $mano=substr($Fec_Fin_Ejer,0,4);    $criterio1="PRESUPUESTO: ".$mano;    $criterio2="";
   $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
   $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; }
   $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;  $h=$c+1+$p; 
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presup_d,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
   $ls=$c;  $lc=$ls+1+$p;  $criterio_s=""; $p1=3; $p2=6; $l_c1=$c+1+$p1; $l_c2=$c+1+$p2;
   $cod_presup_d=str_replace("X","?",$formato_presup); $cod_presup_h=str_replace("X","?",$formato_presup); 
   
   $sql="SELECT denominacion from pre001 where cod_presup='$cod_unidad'"; $res=pg_query($sql); $filas=pg_num_rows($res);
	if($filas>0){$registro=pg_fetch_array($res); $criterio_s=$cod_unidad." ".$registro["denominacion"];
      if(strlen($cod_unidad)==2){$criterio_s="PROYECTO: ". $criterio_s;  $cod_presup_d=$cod_unidad.substr($cod_presup_d,2,30);  } 
	  if(strlen($cod_unidad)==5){$criterio_s="ACCION: ". $criterio_s; $cod_presup_d=$cod_unidad.substr($cod_presup_d,5,30); } 
	  $cod_presup_h=$cod_presup_d;
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
   
  $StrSQL = "DELETE FROM pre020 Where (tipo_registro='M') and (nombre_usuario='".$cod_mov."')";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
  
  $sql_codigo="substr(cod_presup,".$ini.",$p)"; $sql_grupo="substr(cod_presup,".$ini.",$p),denominacion,aplicacion";  
  $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'M' as tipo_registro, ".$sql_codigo.", '',denominacion,'','','','','A','F','O',aplicacion,'', ";
  $StrSQL=$StrSQL."sum(asignado),".$sql_Asignacion."sum(disp_diferida),".$sql_Compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.",".$sql_compromisom.$sql_causadom.$sql_pagadom.$sql_TrasladosM.$sql_TrasladonM.$sql_AdicionM.$sql_DisminucionM.$sql_DiferidoM;
  $StrSQL=$StrSQL." FROM PRE001 WHERE length(Cod_Presup)=".$l_c." and ".$criterio."  group by ".$sql_grupo;  
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  
  $sql_codigo="substr(cod_presup,".$ini.",$p1)"; $sql_grupo="substr(cod_presup,".$ini.",$p1)";  
  $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'M' as tipo_registro, ".$sql_codigo.", '00','','','','','','A','F','O','','', ";
  $StrSQL=$StrSQL."sum(asignado),".$sql_Asignacion."sum(disp_diferida),".$sql_Compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.",".$sql_compromisom.$sql_causadom.$sql_pagadom.$sql_TrasladosM.$sql_TrasladonM.$sql_AdicionM.$sql_DisminucionM.$sql_DiferidoM;
  $StrSQL=$StrSQL." FROM PRE001 WHERE length(Cod_Presup)=".$l_c." and ".$criterio."  group by ".$sql_grupo;  
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  
  $sl=$l_c1;
  $sql_codigo="substr(cod_presup,".$ini.",".$p1.") as cod_partida,'00' as cod_fuente,denominacion"; $sql_grupo="cod_partida,cod_fuente,denominacion";
  $sql="SELECT ".$sql_codigo." FROM PRE001 WHERE length(cod_presup)=".$sl. "  group by ".$sql_grupo; $res=pg_query($sql); 
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_partida"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; 
	    $StrSQL="UPDATE PRE020 SET denominacion='".$denominacion."',cod_partida='".$cod_presup."',denomina_par='".$denominacion."' Where cod_presup='".$cod_presup."' and cod_fuente='".$cod_fuente."'";   $resg=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn);
  }      
  
  $sql_codigo="substr(cod_presup,".$ini.",$p2)"; $sql_grupo="substr(cod_presup,".$ini.",$p2)";  
  $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'M' as tipo_registro, ".$sql_codigo.", '00','','','','','','A','F','O','','', ";
  $StrSQL=$StrSQL."sum(asignado),".$sql_Asignacion."sum(disp_diferida),".$sql_Compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.",".$sql_compromisom.$sql_causadom.$sql_pagadom.$sql_TrasladosM.$sql_TrasladonM.$sql_AdicionM.$sql_DisminucionM.$sql_DiferidoM;
  $StrSQL=$StrSQL." FROM PRE001 WHERE length(Cod_Presup)=".$l_c." and ".$criterio."  group by ".$sql_grupo;
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  
  $sl=$l_c2;
  $sql_codigo="substr(cod_presup,".$ini.",".$p2.") as cod_partida,'00' as cod_fuente,denominacion"; $sql_grupo="cod_partida,cod_fuente,denominacion";
  $sql="SELECT ".$sql_codigo." FROM PRE001 WHERE length(cod_presup)=".$sl. "  group by ".$sql_grupo; $res=pg_query($sql); 
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_partida"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; 
	    $StrSQL="UPDATE PRE020 SET denominacion='".$denominacion."',cod_partida='".$cod_presup."',denomina_par='".$denominacion."' Where cod_presup='".$cod_presup."' and cod_fuente='".$cod_fuente."'";   $resg=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn);
  }  
  
  
  $ordenar=" ORDER BY pre020.aplicacion,pre020.cod_presup";
  $ordenar=" ORDER BY pre020.cod_presup";    
  $sSQL = "SELECT pre020.cod_presup,pre020.cod_fuente, pre020.denominacion,pre020.cod_categoria,pre020.denomina_cat,pre020.cod_partida,pre020.denomina_par,substring(pre020.cod_partida,1,3) as partida,pre020.aplicacion, pre020.asignado, pre020.traslados, pre020.trasladon, pre020.adicion, 
			 pre020.disminucion, pre020.compromiso, pre020.causado, pre020.pagado, pre020.disponible, pre020.compromisom, pre020.causadom, pre020.pagadom, pre020.diferidom,
			(pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS modificaciones,(pre020.traslados+pre020.adicion) AS aumentos, (pre020.trasladon+pre020.disminucion) AS disminuciones,
			(pre020.asignado+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS asig_actualizada, (pre020.asignado+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion-pre020.compromiso) AS disponibilidad,
			(pre020.diferidom+pre020.trasladosm-pre020.trasladonm+pre020.adicionm-pre020.disminucionm) AS asig_act_per,
			(pre020.disponible+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS asig_act_acum
			 FROM pre020 WHERE tipo_registro='M' and nombre_usuario='$cod_mov' ".$ordenar;
	
  if($tipo_rep=="PDF"){	
  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $mdes_trim; global $criterio1; global $criterio_s; global $mdes_meses;
		   $ffechar=date("d-m-Y");
           //$this->rect(10,7,260,40); 
		   $this->SetFont('Arial','',6);
		   $this->Image('../../imagenes/logo escudo.png',12,10,18);
		   $this->Image('../../imagenes/logo escudo3.png',245,10,18);
		   $this->Cell(30);
		   $this->Cell(130,4,'(1) CODIGO PRESUPUESTARIO DEL ENTE: A 01240',0,1);
		   //$this->Cell(130,4,'FECHA : '.$ffechar,0,1,'R');
		   $this->Cell(30);
		   $this->Cell(130,4,'DENOMINACION DEL ENTE: EMPRESA NOROCCIDENTAL DE MANTENIMIENTO Y OBRAS HIDRAULICAS C.A.',0,1);
		   //$this->Cell(130,4,'PAGINA : '.$this->PageNo(),0,1,'R');
		   $this->Cell(30);
		   $this->Cell(130,4,'ORGANISMO DE ADSCRIPCION: MINISTERIO DEL PODER POPULAR PARA EL AMBIENTE',0,1);
           if ($criterio_s<>''){
		       $this->Cell(30);
			   $this->Cell(150,4,$criterio_s,0,1);
			   $this->rect(10,7,260,38);                         
               $titulo='EJECUCIÓN TRIMESTRAL DE GASTO Y APLICACIONES FINANCIERA';
		   }else{ $this->rect(10,7,260,34);  
                  $titulo='EJECUCIÓN TRIMESTRAL DE GASTO Y APLICACIONES FINANCIERA (RESUMEN INSTITUCIONAL)';
           }			   
		   //$this->Cell(100,4,$criterio1,0,1);	
		   //$this->Cell(130,4,'PERIODO: '.$mdes_trim,0,1);
		   $this->Cell(30);
		   $this->Cell(100,4,'PERIODO PRESUPUESTARIO: '.$mdes_meses,0,1);
		   $this->Ln(5);
		   $this->SetFont('Arial','B',12);
		   $this->Cell(260,4,$titulo,0,1,'C');
		   $this->SetFont('Arial','B',6);
		   $this->Cell(260,4,'(En Bolivares Fuertes)',0,1,'C');
		   $this->Ln(4);		   
		   $this->SetFont('Arial','',5.1);	
           $this->SetFillColor(192,192,192);		   
		   $this->Cell(13,2,'','RLT',0,'C',true);
		   $this->Cell(60,2,'','RLT',0,'C',true);
		   $this->Cell(17,2,'','RLT',0,'C',true);
		   $this->Cell(17,2,'','RLT',0,'C',true);
		   $this->Cell(17,2,'','RLT',0,'C',true);		   
		   $this->Cell(51,2,'','T',0,'C',true);
		   $this->Cell(68,2,'','TRL',0,'C',true);
		   $this->Cell(17,2,'','TRL',1,'C',true);		   
		   $this->Cell(13,3,'','RL',0,'C',true);
		   $this->Cell(60,3,'','RL',0,'C',true);
		   $this->Cell(17,3,'','RL',0,'C',true);
		   $this->Cell(17,3,'','RL',0,'C',true);
		   $this->Cell(17,3,'','RL',0,'C',true);
		   $this->Cell(51,3,'EJECUTADO EN EL TRIMESTRE','RL',0,'C',true);
		   $this->Cell(68,3,'ACUMULADO AL TRIMESTRE','RL',0,'C',true);
		   $this->Cell(17,3,'','RL',1,'C',true);
		   $this->Cell(13,3,'PARTIDAS','RL',0,'C',true);
		   $this->Cell(60,3,'DENOMINACION','RL',0,'C',true);
		   $this->Cell(17,3,'PRESUPUESTO','RL',0,'C',true);
		   $this->Cell(17,3,'PRESUPUESTO','RL',0,'C',true);
		   $this->Cell(17,3,'PROGRAMADO','RL',0,'C',true);
		   
		    $this->Cell(51,3,'(7)','BRL',0,'C',true);
		   $this->Cell(68,3,'(8)','BRL',0,'C',true);
		   
		   $this->Cell(17,3,'DISPONIBILIDAD','RL',1,'C',true);
		   $this->Cell(13,3,'(2)','RL',0,'C',true);
		   $this->Cell(60,3,'(3)','RL',0,'C',true);
		   $this->Cell(17,3,'APROBADO','RL',0,'C',true);
		   $this->Cell(17,3,'MODIFICADO','RL',0,'C',true);
		   $this->Cell(17,3,'TRIMESTRE','RL',0,'C',true);
		   $this->Cell(17,3,'COMPROMISO','RL',0,'C',true);
		   $this->Cell(17,3,'CAUSADO','RL',0,'C',true);
		   $this->Cell(17,3,'PAGADO','RL',0,'C',true);
		   $this->Cell(17,3,'PROGRAMADO','RL',0,'C',true);
		   $this->Cell(17,3,'COMPROMISO','RL',0,'C',true);
		   $this->Cell(17,3,'CAUSADO','RL',0,'C',true);
		   $this->Cell(17,3,'PAGADO','RL',0,'C',true);
		   $this->Cell(17,3,'PRESUPUESTARIA','RL',1,'C',true);		   
		   $this->Cell(13,2,'','RLB',0,'C',true);
		   $this->Cell(60,2,'','RLB',0,'C',true);
		   $this->Cell(17,2,'(4)','RLB',0,'C',true);
		   $this->Cell(17,2,'(5)','RLB',0,'C',true);
		   $this->Cell(17,2,'(6)','RLB',0,'C',true);
		   $this->Cell(17,2,'','RLB',0,'C',true);
		   $this->Cell(17,2,'','RLB',0,'C',true);
		   $this->Cell(17,2,'','RLB',0,'C',true);
		   $this->Cell(17,2,'','RLB',0,'C',true);
		   $this->Cell(17,2,'','RLB',0,'C',true);
		   $this->Cell(17,2,'','RLB',0,'C',true);
		   $this->Cell(17,2,'','RLB',0,'C',true);
		   $this->Cell(17,2,'(9)','RLB',1,'C',true);
           $x=$this->GetX();   $y=$this->GetY();
		   $l=195-$y;
		   $this->rect(10,$y,260,$l);
           $this->Line(23,$y,23,195); 
           $this->Line(83,$y,83,195); 		   
           $this->Line(100,$y,100,195); 
           $this->Line(117,$y,117,195);
           $this->Line(134,$y,134,195);		   
           $this->Line(151,$y,151,195);
		   $this->Line(168,$y,168,195);
		   $this->Line(185,$y,185,195);
		   $this->Line(202,$y,202,195);
		   $this->Line(219,$y,219,195);
           $this->Line(236,$y,236,195); 
           $this->Line(253,$y,253,195);		   
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->Cell(260,3,'Pagina '.$this->PageNo().' de {nb}',0,0,'R');
		}
	  }
	$pdf=new PDF('L', 'mm', Letter);
	$pdf->AliasNbPages();
   	$pdf->AddPage();
	$pdf->SetFont('Arial','',5);
	$totalg=0; $totalf=0; $totald=0; $totale=0; $totalc=0; $totala=0; $totalp=0; $totalac=0;$totalcm=0; $totalam=0; $totalpm=0;
	$res=pg_query($sSQL); $filas=pg_num_rows($res); $prev_aplic="";
	while($registro=pg_fetch_array($res)){ 
	    $cod_partida=$registro["cod_partida"];  $cod_presup=$registro["cod_presup"];  $denominacion=$registro["denominacion"];  $denomina_par=$registro["denomina_par"];
		if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denomina_par=utf8_decode($denomina_par); $denominacion=utf8_decode($denominacion);}
		$modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"];
        $aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];	$disponible=$registro["disponible"];			
		$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
		$comprometidom=$registro["compromisom"];   $causadom=$registro["causadom"]; $pagadom=$registro["pagadom"]; $asig_act_per=$registro["asig_act_per"];
		$asig_act_acum=$registro["asig_act_acum"]; $dispon=$asig_actualizada-$comprometido; $aplicacion=$registro["aplicacion"];	

        /*		
		$modificaciones=round($modificaciones,0); $comprometido=round($comprometido,0); $causado=round($causado,0); $pagado=round($pagado,0);
		$aumentos=round($aumentos,0); $disminuciones=round($disminuciones,0); $disponible=round($disponible,0); $asignado=round($asignado,0);
		$asig_actualizada=round($asig_actualizada,0); $dispon=round($dispon,0); $asig_act_per=round($asig_act_per,0); $asig_act_acum=round($asig_act_acum,0);
		$comprometidom=round($comprometidom,0);  $causadom=round($causadom,0); $pagadom=round($pagadom,0); 
		*/
		$tl=strlen($cod_presup);
		if($tl==$p){
		$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $totald=$totald+$dispon; $totale=$totale+$asig_act_per; 		
		$totalc=$totalc+$comprometido; $totala=$totala+$causado; $totalp=$totalp+$pagado; $totalac=$totalac+$asig_act_acum;		
		$totalcm=$totalcm+$comprometidom; $totalam=$totalam+$causadom; $totalpm=$totalpm+$pagadom;	}
		
		
		$asignado=formato_monto($asignado); $asig_actualizada=formato_monto($asig_actualizada);
	    $asig_act_per=formato_monto($asig_act_per); $comprometidom=formato_monto($comprometidom);
	    $causadom=formato_monto($causadom); $pagadom=formato_monto($pagadom); $asig_act_acum=formato_monto($asig_act_acum); 	
		$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); $dispon=formato_monto($dispon); 
	    
		
		/*if($prev_aplic<>$aplicacion){ $mdes_apliacion="";
		  $pdf->SetFont('Arial','B',5);
		  $pdf->Cell(13,3,'',0,0);
		  $pdf->MultiCell(60,3,$mdes_apliacion,0);		   
		}*/
		
		$tl=strlen($cod_presup);
		if($tl==$p){$pdf->SetFont('Arial','',5);}else{$pdf->SetFont('Arial','B',5);}
		$mpartida=$cod_presup;
		$mpartida=$cod_presup."-00-00-00-00";
		$mpartida=substr($mpartida,0,$p);
		$pdf->Cell(13,3,$mpartida,0,0); 	
	    //$pdf->Cell(13,3,$cod_presup,0,0); 		   
		$x=$pdf->GetX();   $y=$pdf->GetY(); $n=60; 		   
		$pdf->SetXY($x+$n,$y);
		$pdf->Cell(17,3,$asignado,0,0,'R'); 
		$pdf->Cell(17,3,$asig_actualizada,0,0,'R'); 
		$pdf->Cell(17,3,$asig_act_per,0,0,'R'); 	
		$pdf->Cell(17,3,$comprometidom,0,0,'R');
		$pdf->Cell(17,3,$causadom,0,0,'R');		   
		$pdf->Cell(17,3,$pagadom,0,0,'R'); 
		$pdf->Cell(17,3,$asig_act_acum,0,0,'R');
		$pdf->Cell(17,3,$comprometido,0,0,'R');
		$pdf->Cell(17,3,$causado,0,0,'R');		   
		$pdf->Cell(17,3,$pagado,0,0,'R'); 		
		$pdf->Cell(17,3,$dispon,0,1,'R');
		$pdf->SetXY($x,$y);
		$pdf->MultiCell($n,3,$denominacion,0);
	}
	
	$totalg=formato_monto($totalg);$totalf=formato_monto($totalf);  $totald=formato_monto($totald);  $totale=formato_monto($totale); 
	$totalc=formato_monto($totalc);$totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm); 
	$totalcm=formato_monto($totalcm);$totalam=formato_monto($totalam);  $totalpm=formato_monto($totalpm); $totalac=formato_monto($totalac);
	
	$x=$pdf->GetX();   $y=$pdf->GetY(); if($y<190){$y=190;}
	$pdf->SetXY($x,$y);
	$pdf->SetFont('Arial','B',5);
	$pdf->SetFillColor(192,192,192);
	$pdf->Cell(73,5,'TOTALES (10)',1,0,'C',true);
	$pdf->Cell(17,5,$totalg,1,0,'R',true); 
	$pdf->Cell(17,5,$totalf,1,0,'R',true); 
	$pdf->Cell(17,5,$totale,1,0,'R',true); 	
	$pdf->Cell(17,5,$totalcm,1,0,'R',true);
	$pdf->Cell(17,5,$totalam,1,0,'R',true);		   
	$pdf->Cell(17,5,$totalpm,1,0,'R',true); 
	$pdf->Cell(17,5,$totalac,1,0,'R',true);
	$pdf->Cell(17,5,$totalc,1,0,'R',true);
	$pdf->Cell(17,5,$totala,1,0,'R',true);		   
	$pdf->Cell(17,5,$totalp,1,0,'R',true); 		
	$pdf->Cell(17,5,$totald,1,1,'R',true);
	$pdf->Output(); 
  }
  if($tipo_rep=="EXCEL"){	
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Ejec_trimestral_gasto.xls");
		
		if ($criterio_s<>''){   $titulo='EJECUCIÓN TRIMESTRAL DE GASTO Y APLICACIONES FINANCIERA'; }
		   else{ $titulo='EJECUCIÓN TRIMESTRAL DE GASTO Y APLICACIONES FINANCIERA (RESUMEN INSTITUCIONAL)'; }	
		?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
			<td width="140" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $titulo; ?></strong></font></td>
		 </tr>
		 <tr height="20">
		    <td width="140" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio_s; ?></strong></font></td>
		 </tr>
		 <tr height="20">
		    <td width="140" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>PERIODO PRESUPUESTARIO: <?	echo $mdes_meses; ?></strong></font></td>
		 </tr>
		 <tr height="20">
		   <td width="140" align="left" bgcolor="#BDBDBD"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Partidas</strong></td>
		   <td width="400" align="left" bgcolor="#BDBDBD"><strong>Denominacion</strong></td>
		   <td width="120" align="right" bgcolor="#BDBDBD" ><strong>Presupuesto</strong></td>
		   <td width="120" align="right" bgcolor="#BDBDBD" ><strong>Presupuesto</strong></td>
		   <td width="120" align="right" bgcolor="#BDBDBD" ><strong>Programado</strong></td>
		   <td width="120" align="right" bgcolor="#BDBDBD" ><strong>EJECUTADO</strong></td>
		   <td width="120" align="center" bgcolor="#BDBDBD" ><strong>EN EL</strong></td>
		   <td width="120" align="left" bgcolor="#BDBDBD" ><strong>TRIMESTRE</strong></td>
           <td width="120" align="right" bgcolor="#BDBDBD" ><strong></strong></td>	
		   <td width="120" align="right" bgcolor="#BDBDBD" ><strong>ACUMULADO AL</strong></td>
		   <td width="120" align="left" bgcolor="#BDBDBD" ><strong>TRIMESTRE</strong></td>
		   <td width="120" align="right" bgcolor="#BDBDBD" ><strong></strong></td>
           <td width="120" align="right" bgcolor="#BDBDBD" ><strong>Disponibilidad</strong></td> 		   
		 </tr>
		 <tr height="20">
		   <td width="140" align="left" bgcolor="#BDBDBD"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
		   <td width="400" align="left" bgcolor="#BDBDBD"><strong></strong></td>
		   <td width="120" align="right" bgcolor="#BDBDBD" ><strong>Aprobado</strong></td>
		   <td width="120" align="right" bgcolor="#BDBDBD" ><strong>Modificado</strong></td>
		   <td width="120" align="right" bgcolor="#BDBDBD" ><strong>Trimestre</strong></td>
		   <td width="120" align="right" bgcolor="#BDBDBD" ><strong>Compromiso</strong></td>
		   <td width="120" align="right" bgcolor="#BDBDBD" ><strong>Causado</strong></td>
		   <td width="120" align="right" bgcolor="#BDBDBD" ><strong>Pagado</strong></td>
           <td width="120" align="right" bgcolor="#BDBDBD" ><strong>Programado</strong></td>	
		   <td width="120" align="right" bgcolor="#BDBDBD" ><strong>Compromiso</strong></td>
		   <td width="120" align="right" bgcolor="#BDBDBD" ><strong>Causado</strong></td>
		   <td width="120" align="right" bgcolor="#BDBDBD" ><strong>Pagado</strong></td>
           <td width="120" align="right" bgcolor="#BDBDBD" ><strong>Presupuestaria</strong></td> 		   
		 </tr>
		 <?	
		 
	 $totalg=0; $totalf=0; $totald=0; $totale=0; $totalc=0; $totala=0; $totalp=0; $totalac=0;$totalcm=0; $totalam=0; $totalpm=0;
	$res=pg_query($sSQL); $filas=pg_num_rows($res); $prev_aplic="";
	while($registro=pg_fetch_array($res)){ 
	    $cod_partida=$registro["cod_partida"];  $cod_presup=$registro["cod_presup"];  $denominacion=$registro["denominacion"];  $denomina_par=$registro["denomina_par"];
		$denomina_par=conv_cadenas($denomina_par,0); $denominacion=conv_cadenas($denominacion,0);
		$modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"];
        $aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];	$disponible=$registro["disponible"];			
		$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
		$comprometidom=$registro["compromisom"];   $causadom=$registro["causadom"]; $pagadom=$registro["pagadom"]; $asig_act_per=$registro["asig_act_per"];
		$asig_act_acum=$registro["asig_act_acum"]; $dispon=$asig_actualizada-$comprometido; $aplicacion=$registro["aplicacion"];
        /*		
		$modificaciones=round($modificaciones,0); $comprometido=round($comprometido,0); $causado=round($causado,0); $pagado=round($pagado,0);
		$aumentos=round($aumentos,0); $disminuciones=round($disminuciones,0); $disponible=round($disponible,0); $asignado=round($asignado,0);
		$asig_actualizada=round($asig_actualizada,0); $dispon=round($dispon,0); $asig_act_per=round($asig_act_per,0); $asig_act_acum=round($asig_act_acum,0);
		$comprometidom=round($comprometidom,0);  $causadom=round($causadom,0); $pagadom=round($pagadom,0); */
		
		$tl=strlen($cod_presup);
		if($tl==$p){
		$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $totald=$totald+$dispon; $totale=$totale+$asig_act_per; 		
		$totalc=$totalc+$comprometido; $totala=$totala+$causado; $totalp=$totalp+$pagado; $totalac=$totalac+$asig_act_acum;		
		$totalcm=$totalcm+$comprometidom; $totalam=$totalam+$causadom; $totalpm=$totalpm+$pagadom;	}
		
		
		$asignado=formato_monto($asignado); $asig_actualizada=formato_monto($asig_actualizada);
	    $asig_act_per=formato_monto($asig_act_per); $comprometidom=formato_monto($comprometidom);
	    $causadom=formato_monto($causadom); $pagadom=formato_monto($pagadom); $asig_act_acum=formato_monto($asig_act_acum); 	
		$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); $dispon=formato_monto($dispon); 
	    
		
		/*if($prev_aplic<>$aplicacion){ $mdes_apliacion="";
		  $pdf->SetFont('Arial','B',5);
		  $pdf->Cell(13,3,'',0,0);
		  $pdf->MultiCell(60,3,$mdes_apliacion,0);		   
		}*/
		
		$tl=strlen($cod_presup);
		//if($tl==$p){$pdf->SetFont('Arial','',5);}else{$pdf->SetFont('Arial','B',5);}
		$mpartida=$cod_presup;
		$mpartida=$cod_presup."-00-00-00-00";
		$mpartida=substr($mpartida,0,$p);
		if($tl<>$p){
		?>	   
			 <tr>
			   <td width="140" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><? echo $mpartida; ?></td>
			   <td width="400" align="justify"><strong><? echo $denominacion; ?></td>				   
			   <td width="120" align="right"><strong><? echo $asignado; ?></td>
			   <td width="120" align="right"><strong><? echo $asig_actualizada; ?></td>
			   <td width="120" align="right"><strong><? echo $asig_act_per; ?></td>
			   <td width="120" align="right"><strong><? echo $comprometidom; ?></td>
			   <td width="120" align="right"><strong><? echo $causadom; ?></td>
			   <td width="120" align="right"><strong><? echo $pagadom; ?></td>
			   <td width="120" align="right"><strong><? echo $asig_act_acum; ?></td>
			   <td width="120" align="right"><strong><? echo $comprometido; ?></td>
			   <td width="120" align="right"><strong><? echo $causado; ?></td>
			   <td width="120" align="right"><strong><? echo $pagado; ?></td>
			   <td width="120" align="right"><strong><? echo $dispon; ?></strong></td>
			 </tr>
		 <?		
		}else{
		?>	   
			 <tr>
			   <td width="140" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $mpartida; ?></td>
			   <td width="400" align="justify"><? echo $denominacion; ?></td>				   
			   <td width="120" align="right"><? echo $asignado; ?></td>
			   <td width="120" align="right"><? echo $asig_actualizada; ?></td>
			   <td width="120" align="right"><? echo $asig_act_per; ?></td>
			   <td width="120" align="right"><? echo $comprometidom; ?></td>
			   <td width="120" align="right"><? echo $causadom; ?></td>
			   <td width="120" align="right"><? echo $pagadom; ?></td>
			   <td width="120" align="right"><? echo $asig_act_acum; ?></td>
			   <td width="120" align="right"><? echo $comprometido; ?></td>
			   <td width="120" align="right"><? echo $causado; ?></td>
			   <td width="120" align="right"><? echo $pagado; ?></td>
			   <td width="120" align="right"><? echo $dispon; ?></td>
			 </tr>
		 <?		
		}
	}
	
	$totalg=formato_monto($totalg);$totalf=formato_monto($totalf);  $totald=formato_monto($totald);  $totale=formato_monto($totale); 
	$totalc=formato_monto($totalc);$totala=formato_monto($totala);  $totalp=formato_monto($totalp);  $totalm=formato_monto($totalm); 
	$totalcm=formato_monto($totalcm);$totalam=formato_monto($totalam);  $totalpm=formato_monto($totalpm); $totalac=formato_monto($totalac);
	
	?>	   
			 <tr>
			   <td width="140" align="left" bgcolor="#BDBDBD"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong></td>
			   <td width="400" align="center" bgcolor="#BDBDBD"><strong>TOTALES</td>				   
			   <td width="120" align="right" bgcolor="#BDBDBD"><strong><? echo $totalg; ?></td>
			   <td width="120" align="right" bgcolor="#BDBDBD"><strong><? echo $totalf; ?></td>
			   <td width="120" align="right" bgcolor="#BDBDBD"><strong><? echo $totale; ?></td>
			   <td width="120" align="right" bgcolor="#BDBDBD"><strong><? echo $totalcm; ?></td>
			   <td width="120" align="right" bgcolor="#BDBDBD"><strong><? echo $totalam; ?></td>
			   <td width="120" align="right" bgcolor="#BDBDBD"><strong><? echo $totalpm; ?></td>
			   <td width="120" align="right" bgcolor="#BDBDBD"><strong><? echo $totalac; ?></td>
			   <td width="120" align="right" bgcolor="#BDBDBD"><strong><? echo $totalc; ?></td>
			   <td width="120" align="right" bgcolor="#BDBDBD"><strong><? echo $totala; ?></td>
			   <td width="120" align="right" bgcolor="#BDBDBD"><strong><? echo $totalp; ?></td>
			   <td width="120" align="right" bgcolor="#BDBDBD"><strong><? echo $totald; ?></strong></td>
			 </tr>
		 <?		
  }
/*	
  $StrSQL = "DELETE FROM pre020 Where (tipo_registro='M') And (nombre_usuario='".$cod_mov."')";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
  */
  
?>