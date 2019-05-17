<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$timestre=$_GET["timestre"];$cod_cat=$_GET["cod_cat"];$cod_part=$_GET["cod_part"]; $cod_unidad=$_GET["cod_unidad"]; $tipo_rep=$_GET["tipo_rep"]; $solo_part=$_GET["solo_part"]; } 
else { $timestre="01"; $cod_cat="";$cod_unidad=""; $cod_part=""; $tipo_rep="PDF"; $solo_part="NO"; }  $mes_desde="01"; $mes_hasta="03"; $mdes_trim="I-TRIMESTRE";
$asig_global="S"; $equipo=getenv("COMPUTERNAME"); $cod_mov="Mpre020".$usuario_sia; $php_os=PHP_OS;
$cod_fuente_d=""; $cod_fuente_h="zz";
if($timestre=="01"){ $mes_desde="01"; $mes_hasta="03"; $mdes_trim="I TRIMESTRE"; }
if($timestre=="02"){ $mes_desde="04"; $mes_hasta="06"; $mdes_trim="II TRIMESTRE";}
if($timestre=="03"){ $mes_desde="07"; $mes_hasta="09"; $mdes_trim="III TRIMESTRE";}
if($timestre=="04"){ $mes_desde="10"; $mes_hasta="12"; $mdes_trim="IV TRIMESTRE";}
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
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} }
   $mano=substr($Fec_Fin_Ejer,0,4);    $criterio1="PRESUPUESTO: ".$mano;    $criterio2="";
   
   $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX"; $cant_cat=3; $cant_par=4;
   $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; $mdes_cat[1]=$registro["campo505"]; $mdes_cat[2]=$registro["campo507"]; $mdes_cat[3]=$registro["campo509"]; $mdes_cat[4]=$registro["campo511"]; $mdes_cat[5]=$registro["campo512"]; $cant_cat=$registro["campo550"]; $cant_par=$registro["campo551"];}
   $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2; $h=$c+1+$p; 
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presup_d,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
   $ls=$c;  $lc=$ls+1+$p;  $criterio_s=""; 
   $cod_presup_d=str_replace("X","?",$formato_presup); $cod_presup_h=str_replace("X","?",$formato_presup);  
   $msector=""; $den_sector=""; $mprograma=""; $msub_programa=""; $muni_ejec="";  

   $tls=$mcontrol[0]; $tlp=$mcontrol[1]; $tlsp=$mcontrol[2];
   $msector=substr($cod_unidad,0,$tls); $mprograma=substr($cod_unidad,0,$tlp); $msub_programa=substr($cod_unidad,0,$tlsp);   
    $sql="SELECT cod_presup,denominacion from pre001 where cod_presup='$msector'"; 
	if($msector=="??"){  $sql="SELECT cod_presup,denominacion from pre001 order by cod_presup"; }
	$res=pg_query($sql); $filas=pg_num_rows($res);
	if($filas>0){$registro=pg_fetch_array($res); $msector=$registro["cod_presup"]." ".$registro["denominacion"];
	  $cod_presup_d=$registro["cod_presup"].substr($cod_presup_d,$tls,30);  $cod_presup_h=$cod_presup_d;
	}else{ $msector=""; $den_sector="";}	
	$sql="SELECT cod_presup,denominacion from pre001 where cod_presup='$mprograma'"; $res=pg_query($sql); $filas=pg_num_rows($res);
	if($filas>0){$registro=pg_fetch_array($res); $mprograma=$registro["cod_presup"]." ".$registro["denominacion"];
	  $cod_presup_d=$registro["cod_presup"].substr($cod_presup_d,$tlp,30);  $cod_presup_h=$cod_presup_d;
	}else{ $mprograma=""; $den_programa="";}	
	$sql="SELECT cod_presup,denominacion from pre001 where cod_presup='$msub_programa'"; $res=pg_query($sql); $filas=pg_num_rows($res);
	if($filas>0){$registro=pg_fetch_array($res); $msub_programa=$registro["cod_presup"]." ".$registro["denominacion"];
	  $cod_presup_d=$registro["cod_presup"].substr($cod_presup_d,$tlsp,30);  $cod_presup_h=$cod_presup_d;
	}else{ $msub_programa=""; $den_sub_programa="";}

	
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
     $sql_Disminucion="0 as Disminucion,"; $sql_Compromiso="0 as compromiso,"; $sql_Causado="0 as Causado,";
     $sql_Pagado="0 as Pagado,"; $sql_Asignacion="0 as asignado,"; $sql_Asignacion="asignado,";  $sql_Diferido="0 as Diferido"; 
	 $sql_TrasladosM="0 as TrasladosM,";  $sql_TrasladonM="0 as TrasladonM,";  $sql_AdicionM="0 as adicionM,";
     $sql_DisminucionM="0 as DisminucionM,"; $sql_compromisom="0 as compromisom,"; $sql_causadom="0 as causadom,";
     $sql_pagadom="0 as pagadom,"; $sql_DiferidoM="0 as DiferidoM"; $sql_Disp_Diferida="0 as disp_diferida,";	 
	 }
   else{for ($i=1; $i <= $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==1){$scampo = "(sum(Traslados".$pos.")";  $scampo1 = "(sum(Trasladon".$pos.")";  $scampo2 = "(sum(adicion".$pos.")";
           $scampo3 = "(sum(Disminucion".$pos.")";  $scampo7 = "(sum(asignado".$pos.")"; $scampo4 = "(sum(compromiso".$pos.")";  $scampo5 = "(sum(Causado".$pos.")";
           $scampo6 = "(sum(Pagado".$pos.")"; $scampo8 = "(sum(Diferido".$pos.")";}
       else{$scampo = "+sum(Traslados".$pos.")" ; $scampo1 = "+sum(Trasladon".$pos.")";$scampo2 = "+sum(adicion".$pos.")";
           $scampo3 = "+sum(Disminucion".$pos.")"; $scampo7 = "+sum(asignado".$pos.")"; $scampo4 = "+sum(compromiso".$pos.")";$scampo5 = "+sum(Causado".$pos.")";
           $scampo6 = "+sum(Pagado".$pos.")";  $scampo8 = "+sum(Diferido".$pos.")";}
      $sql_Traslados=$sql_Traslados.$scampo;  $sql_Trasladon=$sql_Trasladon.$scampo1; $sql_Adicion=$sql_Adicion.$scampo2;
      $sql_Disminucion=$sql_Disminucion.$scampo3;  $sql_Asignacion=$sql_Asignacion.$scampo7; 	
      $sql_compromiso=$sql_compromiso.$scampo4;$sql_Causado=$sql_Causado.$scampo5; $sql_Pagado=$sql_Pagado.$scampo6;$sql_Diferido=$sql_Diferido.$scampo8;	  
	} 
    $sql_Traslados=$sql_Traslados.") as Traslados,"; $sql_Trasladon=$sql_Trasladon.") as Trasladon,";
    $sql_Adicion=$sql_Adicion.") as adicion,"; $sql_Disminucion=$sql_Disminucion.") as Disminucion,";
    $sql_compromiso=$sql_compromiso.") as compromiso,"; $sql_Causado=$sql_Causado.") as Causado,";
    $sql_Pagado=$sql_Pagado.") as Pagado,"; $sql_Asignacion=$sql_Asignacion.") as asignado,";
    $sql_Diferido=$sql_Diferido.") as Diferido";	
	
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
   }   
   $sql_Asignacion="sum(asignado),";   
  $StrSQL = "DELETE FROM pre020 Where (tipo_registro='M') and (nombre_usuario='".$cod_mov."')";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
  $sql_codigo="substr(cod_presup,".$ini.",".$p."),cod_fuente"; $sql_grupo="substr(cod_presup,".$ini.",".$p."),cod_fuente";
  $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'M' as tipo_registro, ".$sql_codigo.",'','','','','','A','F','O','T','', ";
  $StrSQL=$StrSQL."sum(asignado),".$sql_Asignacion."sum(disp_diferida),".$sql_compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.",".$sql_compromisom.$sql_causadom.$sql_pagadom.$sql_TrasladosM.$sql_TrasladonM.$sql_AdicionM.$sql_DisminucionM.$sql_DiferidoM;
  $StrSQL=$StrSQL." FROM PRE001 WHERE length(Cod_Presup)=".$l_c." and ".$criterio."  group by ".$sql_grupo;    //echo $StrSQL,"<br>";  
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

  
  /*  VERIFICAR  
  
  
  */
  for ($i=1; $i<=$cant_par-3; $i++) { $pa=$cant_cat+$i-1;
     $m=$mcontrol[$pa]-$ls-1; 
	 $sql_codigo="substr(cod_presup,".$ini.",".$m."),cod_fuente"; $sql_grupo="substr(cod_presup,".$ini.",".$m."),cod_fuente";
	 if($i<$cant_par) { $sql_codigo="substr(cod_presup,".$ini.",".$m."),'00'"; $sql_grupo="substr(cod_presup,".$ini.",".$m.")";}	 
     $StrSQL= "INSERT INTO pre020 SELECT '".$cod_mov."' as nombre_usuario,'M' as tipo_registro, ".$sql_codigo.", '','','','','','A','F','O','T','', ";
     $StrSQL=$StrSQL.$sql_Asignacion."sum(disponible),sum(disp_diferida),".$sql_compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.",".$sql_compromisom.$sql_causadom.$sql_pagadom.$sql_TrasladosM.$sql_TrasladonM.$sql_AdicionM.$sql_DisminucionM.$sql_DiferidoM;
     $StrSQL=$StrSQL." FROM PRE001 WHERE length(cod_presup)=".$l_c." and ".$criterio.$criterioc." group by ".$sql_grupo;
     //echo $StrSQL,"<br>";
	 $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
     $sl=$mcontrol[$pa];
	 $sql_codigo="substr(cod_presup,".$ini.",".$m.") as cod_partida,cod_fuente,denominacion"; $sql_grupo="cod_partida,cod_fuente,denominacion";
	 if($i<$cant_par) { $sql_codigo="substr(cod_presup,".$ini.",".$m.") as cod_partida,'00' as cod_fuente,denominacion"; $sql_grupo="cod_partida,cod_fuente,denominacion";}
	 $sql="SELECT ".$sql_codigo." FROM PRE001 WHERE length(cod_presup)=".$sl. "  group by ".$sql_grupo; $res=pg_query($sql);
	 while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_partida"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; 
	    $StrSQL="UPDATE PRE020 SET denominacion='".$denominacion."',cod_partida='".$cod_presup."',denomina_par='".$denominacion."' Where cod_presup='".$cod_presup."' and cod_fuente='".$cod_fuente."'"; $resg=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn);
	 }      
   }
   $sqld="";
  if ($solo_part=="SI"){
	 $sqld="DELETE FROM  PRE020 WHERE (length(cod_partida)<>3) and (tipo_registro='M') and (nombre_usuario='".$cod_mov."')"; $resg=pg_exec($conn,$sqld); $error=pg_errormessage($conn);  
     if($tipo_rep=="PDF"){ $tipo_rep="PDF2"; } if($tipo_rep=="EXCEL"){ $tipo_rep="EXCEL2"; }
  }	  
  
  if ($solo_part=="CONS"){
	 $sqld="DELETE FROM  PRE020 WHERE (length(cod_partida)<>3) and (tipo_registro='M') and (nombre_usuario='".$cod_mov."')"; $resg=pg_exec($conn,$sqld); $error=pg_errormessage($conn);  
     if($tipo_rep=="PDF"){ $tipo_rep="PDF3"; } if($tipo_rep=="EXCEL"){ $tipo_rep="EXCEL3"; }
  }	 
   
  $ordenar=" ORDER BY pre020.cod_partida"; 
  $sSQL ="Select distinct substr(cod_presup,".$ini.",".$p.") as codigo,denominacion from pre001 where length(cod_presup)=".$h; $res=pg_query($sSQL); 
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["codigo"]; $denominacion=$registro["denominacion"]; 
     $sql="update pre020 set denomina_par='$denominacion',denominacion='$denominacion',cod_partida=cod_presup where tipo_registro='M' and nombre_usuario='$cod_mov' and cod_presup='$cod_presup'";$resultado=pg_exec($conn,$sql); 
  }  
  	$sSQL = "SELECT pre020.cod_presup,pre020.cod_fuente, pre020.denominacion,pre020.cod_categoria,pre020.denomina_cat,pre020.cod_partida,pre020.denomina_par,substring(pre020.cod_partida,1,3) as partida, pre020.Asignado, pre020.Traslados, pre020.Trasladon, pre020.Adicion, 
			 pre020.disminucion, pre020.compromiso, pre020.causado, pre020.pagado, pre020.disponible, pre020.compromisom, pre020.causadom, pre020.pagadom, pre020.diferidom,
			(pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS Modificaciones,(pre020.Traslados+pre020.Adicion) AS Aumentos, (pre020.Trasladon+pre020.Disminucion) AS Disminuciones,
			(pre020.asignado+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS Asig_Actualizada, (pre020.Asignado+pre020.Traslados-pre020.Trasladon+pre020.Adicion-pre020.Disminucion-pre020.compromiso) AS Disponibilidad,
			(pre020.diferidom+pre020.trasladosm-pre020.trasladonm+pre020.adicionm-pre020.disminucionm) AS asig_act_per,
			(pre020.disponible+pre020.traslados-pre020.trasladon+pre020.adicion-pre020.disminucion) AS asig_act_acum
			 FROM pre020 WHERE tipo_registro='M' and nombre_usuario='$cod_mov' ".$ordenar;
			 
  if($tipo_rep=="PDF"){		 
  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $mdes_trim; global $criterio1; global $criterio_s; global $Nom_Emp;   global $msector; global $mprograma; global $msub_programa; global $muni_ejec;
		   
		   $ffechar=date("d-m-Y");
		   $this->SetFont('Arial','B',12);
		   $this->Cell(260,4,'EJECUCIÓN FINANCIERA TRIMESTRAL DEL PRESUPUESTO DE GASTOS',0,1,'C');
		   $this->SetFont('Arial','',8);
		   $this->Cell(260,4,$criterio1." ".'PERIODO: '.$mdes_trim,0,1,'C');
		   $this->Ln(5);		  
		   $this->Cell(160,4,'ORGANISMO DE ADSCRIPCION: GOBERNACION DEL ESTADO MIRANDA',0,1);
		   //$this->Cell(100,4,'FECHA : '.$ffechar,0,1,'R');
		   $this->Cell(160,4,'3. SECTOR : '.$msector,0,1);
		   //$this->Cell(100,4,'PAGINA : '.$this->PageNo(),0,1,'R');
		   $this->Cell(160,4,'4. PROGRAMA : '.$mprograma,0,1);
		   $this->Cell(160,4,'5. SUB-PROGRAMA : '.$msub_programa,0,1);
		   $this->Cell(160,4,'6. UNIDAD EJECUTORA : '.$muni_ejec,0,1);
		   $this->Cell(160,4,'7. ORGANISMO: '.$Nom_Emp,0,1);
		   $this->Ln(5);		   
		   $y=$this->GetY();	$x=$this->GetX();
		   $this->rect(10,$y,260,204-$y);		   
		   $this->SetFont('Arial','',6);
			$this->Cell(38,4,'8.CODIGO PRESUPUESTARIO','TLR',0,'C');
			$this->Cell(72,4,'','TLR',0,'C');
			$this->Cell(15,4,'','TLR',0,'C');
            $this->Cell(15,4,'','TLR',0,'C');
            $this->Cell(15,4,'','TLR',0,'C');
            $this->Cell(15,4,'','TLR',0,'C');
            $this->Cell(15,4,'','TLR',0,'C');
            $this->Cell(15,4,'','TLR',0,'C');
            $this->Cell(15,4,'','TLR',0,'C');
            $this->Cell(15,4,'','TLR',0,'C');			
			$this->Cell(15,4,'','TLR',1,'C');

            $this->Cell(7,3,' ','TLR',0,'C');
			$this->SetFont('Arial','',6);
			$this->Cell(25,3,'SUB-PARTIDAS ','TLR',0,'C');
			$this->Cell(6,3,'','TLR',0,'C');
			$this->SetFont('Arial','',5);
			$this->Cell(72,3,'','LR',0,'C');
			$this->Cell(15,3,'10. ASIGNACIÓN','LR',0,'C');
            $this->Cell(15,3,'11. AUMENTOS','LR',0,'C');
			$this->Cell(15,3,'12. DISMINU-','LR',0,'C');
			$this->Cell(15,3,'13. ASIGNACIÓN','LR',0,'C');
			$this->Cell(15,3,'14. COMPRO-','LR',0,'C');
			$this->Cell(15,3,'15. SALDO POR','LR',0,'C');
			$this->Cell(15,3,'16. MONTO','LR',0,'C');
			$this->Cell(15,3,'17. MONTO POR','LR',0,'C');
			$this->Cell(15,3,'18. MONTO','LR',0,'C');		
			$this->Cell(15,3,'19. MONTO POR','LR',1,'C');

            $this->SetFont('Arial','',6);
			$this->Cell(7,4,'PART.','LR',0,'C');
			$this->Cell(6,4,'GEN.','TLR',0,'C');
			$this->Cell(6,4,'ESP.','TLR',0,'C');
			$this->Cell(6,4,'S/ESP','TLR',0,'C');
			$this->Cell(7,4,'SUB-1','TLR',0,'C');
            $this->Cell(6,4,'','LR',0,'C');			
			
			$this->Cell(72,4,'9. DENOMINACION','LR',0,'C');
			$this->SetFont('Arial','',5);
			$this->Cell(15,4,'ORIGINAL','LR',0,'C');
            $this->Cell(15,4,'','LR',0,'C');
			$this->Cell(15,4,'CIONES','LR',0,'C');
			$this->Cell(15,4,'MODIFICADA','LR',0,'C');
			$this->Cell(15,4,'MISOS','LR',0,'C');
			$this->Cell(15,4,'COMPROMETER','LR',0,'C');
			$this->Cell(15,4,'CAUSADO','LR',0,'C');
			$this->Cell(15,4,'CAUSAR','LR',0,'C');
			$this->Cell(15,4,'PAGADO','LR',0,'C');			
			$this->Cell(15,4,'PAGAR','LR',1,'C');
		   
           $x=$this->GetX();   $y=$this->GetY();
		   $l=198-$y;
		   $this->rect(10,$y,260,$l);
           $this->Line(17,$y,17,198);
           $this->Line(23,$y,23,198);
           $this->Line(29,$y,29,198);
           $this->Line(35,$y,35,198);
		   $this->Line(42,$y,42,198);
		   $this->Line(48,$y,48,198);		   
           $this->Line(120,$y,120,198);
           $this->Line(135,$y,135,198); 
           $this->Line(150,$y,150,198); 
           $this->Line(165,$y,165,198); 
           $this->Line(180,$y,180,198);
           $this->Line(195,$y,195,198);		   
           $this->Line(210,$y,210,198);	
           $this->Line(225,$y,225,198);	 
           $this->Line(240,$y,240,198);
           $this->Line(255,$y,255,198);		   
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
		   global $totalg; global $totalf; global $totald; global $totale; global $totalc; global $totala; global $totalp; global $totalac; global $totalcm; global $totalam; global $totalpm; global $totalau; global $totaldi; global $totaldc; global $totaldp;
			$stotalg=formato_monto($totalg);   $stotalf=formato_monto($totalf);  $stotald=formato_monto($totald);  $stotale=formato_monto($totale); 
			$stotalc=formato_monto($totalc);   $stotala=formato_monto($totala);  $stotalp=formato_monto($totalp);  $stotalm=formato_monto($totalm); 
			$stotalcm=formato_monto($totalcm); $stotalam=formato_monto($totalam);  $stotalpm=formato_monto($totalpm); $stotalac=formato_monto($totalac);
			$stotalau=formato_monto($totalau); $stotaldi=formato_monto($totaldi);
			$stotaldc=formato_monto($totaldc); $stotaldp=formato_monto($totaldp); 			
			$this->SetY(-17);			
			$this->SetFont('Arial','B',5);	
			$this->Cell(38,5,'',0,0); 
			$this->Cell(72,5,'TOTALES',0,0,'C');
			$this->Cell(15,5,$stotalg,0,0,'R'); 
			$this->Cell(15,5,$stotalau,0,0,'R'); 
			$this->Cell(15,5,$stotaldi,0,0,'R'); 
			$this->Cell(15,5,$stotalf,0,0,'R');
			$this->Cell(15,5,$stotalc,0,0,'R');	
			$this->Cell(15,5,$stotald,0,0,'R'); 
			$this->Cell(15,5,$stotala,0,0,'R');
			$this->Cell(15,5,$stotaldc,0,0,'R');
			$this->Cell(15,5,$stotalp,0,0,'R');			
			$this->Cell(15,5,$stotaldp,0,1,'R');
		}
	  }
	$pdf=new PDF('L', 'mm', Letter);
	$pdf->AliasNbPages();
   	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true, 17);
	$pdf->SetFont('Arial','',6);
	$totalg=0; $totalf=0; $totald=0; $totale=0; $totalc=0; $totala=0; $totalp=0; $totalac=0;$totalcm=0; $totalam=0; $totalpm=0; $totalau=0; $totaldi=0; $totaldc=0; $totaldp=0;
	$res=pg_query($sSQL); $filas=pg_num_rows($res); 
	while($registro=pg_fetch_array($res)){ 
	    $cod_partida=$registro["cod_partida"];  $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"];  $denomina_par=$registro["denomina_par"];
		if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denomina_par=utf8_decode($denomina_par); $denominacion=utf8_decode($denominacion);}
		$modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"];
        $aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];	$disponible=$registro["disponible"];			
		$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
		$comprometidom=$registro["compromisom"];   $causadom=$registro["causadom"]; $pagadom=$registro["pagadom"]; $asig_act_per=$registro["asig_act_per"];
		$asig_act_acum=$registro["asig_act_acum"]; $dispon=$asig_actualizada-$comprometido;  $deudac=$registro["compromiso"]-$registro["causado"];
		$deuda=$registro["causado"]-$registro["pagado"];		
		/*
		$modificaciones=round($modificaciones,0); $comprometido=round($comprometido,0); $causado=round($causado,0); $pagado=round($pagado,0);
		$aumentos=round($aumentos,0); $disminuciones=round($disminuciones,0); $disponible=round($disponible,0); $asignado=round($asignado,0);
		$asig_actualizada=round($asig_actualizada,0); $dispon=round($dispon,0); $asig_act_per=round($asig_act_per,0); $asig_act_acum=round($asig_act_acum,0);
		$comprometidom=round($comprometidom,0);  $causadom=round($causadom,0); $pagadom=round($pagadom,0); 
		*/		
		if(strlen($cod_partida)==15){$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $totald=$totald+$dispon; $totale=$totale+$asig_act_per; 		
		$totalc=$totalc+$comprometido; $totala=$totala+$causado; $totalp=$totalp+$pagado; $totalac=$totalac+$asig_act_acum;	$totaldc=$totaldc+$deudac; $totaldp=$totaldp+$deuda;	
		$totalcm=$totalcm+$comprometidom; $totalam=$totalam+$causadom; $totalpm=$totalpm+$pagadom;	$totalau=$totalau+$aumentos; $totaldi=$totaldi+$disminuciones;}
		$porc1=0; if($asig_act_per>0){ $porc1=($causadom*100)/$asig_act_per;  }		$porc2=0; if($asig_act_per>0){ $porc2=($pagadom*100)/$asig_act_per;  }		
		$asignado=formato_monto($asignado); $asig_actualizada=formato_monto($asig_actualizada); $deudac=formato_monto($deudac);
	    $asig_act_per=formato_monto($asig_act_per); $comprometidom=formato_monto($comprometidom); $deuda=formato_monto($deuda);
	    $causadom=formato_monto($causadom); $pagadom=formato_monto($pagadom); $asig_act_acum=formato_monto($asig_act_acum); 	
		$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); $dispon=formato_monto($dispon); 
	    $porc1=formato_monto($porc1);  $porc2=formato_monto($porc2);  $aumentos=formato_monto($aumentos);  $disminuciones=formato_monto($disminuciones);
		$mpartida=$cod_presup."-00-00-00-00"; 	$mpartida=substr($mpartida,0,$p);
		$mpart=substr($mpartida,0,3); $mgen=substr($mpartida,4,2); $mesp=substr($mpartida,7,2); $msub=substr($mpartida,10,2);  $msub_e=substr($mpartida,13,2);
        $mfue=$cod_fuente;
		if(strlen($cod_partida)==15){ $mfue=$cod_fuente; if($mfue=="00"){ $mfue="PO";}else{$mfue="DEC";}  } else{ $mfue="N/A";}		
		if(strlen($cod_partida)<=9){$pdf->SetFont('Arial','BU',5);} else {$pdf->SetFont('Arial','',5);}
		$pdf->Cell(7,3,$mpart,0,0,'C');
		$pdf->Cell(6,3,$mgen,0,0,'C');
		$pdf->Cell(6,3,$mesp,0,0,'C');
		$pdf->Cell(7,3,$msub,0,0,'C');
		$pdf->Cell(6,3,$msub_e,0,0,'C');
		$pdf->Cell(7,3,$mfue,0,0,'C');	    		   
		$x=$pdf->GetX();   $y=$pdf->GetY(); $n=71; 		   
		$pdf->SetXY($x+$n,$y);
		$pdf->Cell(15,3,$asignado,0,0,'R');
        $pdf->Cell(15,3,$aumentos,0,0,'R');  		
		$pdf->Cell(15,3,$disminuciones,0,0,'R');
		$pdf->Cell(15,3,$asig_actualizada,0,0,'R');			
		$pdf->Cell(15,3,$comprometido,0,0,'R');
        $pdf->Cell(15,3,$dispon,0,0,'R');  		
		$pdf->Cell(15,3,$causado,0,0,'R');
		$pdf->Cell(15,3,$deudac,0,0,'R');	
		$pdf->Cell(15,3,$pagado,0,0,'R');
		$pdf->Cell(15,3,$deuda,0,1,'R');
		$pdf->SetXY($x,$y);
		$pdf->MultiCell($n,3,$denomina_par,0);
	}
	$porc1=0; if($totale>0){ $porc1=($totalam*100)/$totale;  }
	$porc2=0; if($totale>0){ $porc2=($totalpm*100)/$totale;  }	
	$pdf->Output(); 
  }
  
 
  if($tipo_rep=="PDF2"){		 
  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $mdes_trim; global $criterio1; global $criterio_s; global $Nom_Emp;   global $msector; global $mprograma; global $msub_programa; global $muni_ejec;
		   
		   $ffechar=date("d-m-Y");
		   $this->SetFont('Arial','B',12);
		   $this->Cell(260,4,'EJECUCIÓN FINANCIERA TRIMESTRAL DEL PRESUPUESTO DE GASTOS',0,1,'C');
		   $this->SetFont('Arial','',8);
		   $this->Cell(260,4,$criterio1." ".'PERIODO: '.$mdes_trim,0,1,'C');
		   $this->Ln(5);		  
		   $this->Cell(160,4,'ORGANISMO DE ADSCRIPCION: GOBERNACION DEL ESTADO MIRANDA',0,1);
		   $this->Cell(160,4,'1. SECTOR : '.$msector,0,1);
		   $this->Cell(160,4,'   PROGRAMA : '.$mprograma,0,1);
		   $this->Cell(160,4,'   SUB-PROGRAMA : '.$msub_programa,0,1);
		   $this->Cell(160,4,'   UNIDAD EJECUTORA : '.$muni_ejec,0,1);
		   $this->Ln(5);		   
		   $y=$this->GetY();	$x=$this->GetX();
		   $this->rect(10,$y,260,204-$y);		   
		   $this->SetFont('Arial','',6);			
            $this->Cell(8,3,' ','TLR',0,'C');
			$this->SetFont('Arial','',6);
			$this->Cell(24,3,'SUB-PARTIDAS ','TLR',0,'C');
			$this->SetFont('Arial','',5);
			$this->Cell(66,3,'','LR',0,'C');
			$this->Cell(18,3,'4. PRESUPUESTO','LR',0,'C');
            $this->Cell(18,3,'','LR',0,'C');
			$this->Cell(54,3,'6. EJECUTADO','LR',0,'C');
			$this->Cell(18,3,'7. % COMPRO-','LR',0,'C');
			$this->Cell(18,3,'','LR',0,'C');	
			$this->Cell(36,3,'9. DISPONIBILIDAD','LR',1,'C');
            $this->SetFont('Arial','',6);
			$this->Cell(8,4,'PART.','LR',0,'C');
			$this->Cell(8,4,'GEN.','TLR',0,'C');
			$this->Cell(8,4,'ESP.','TLR',0,'C');
			$this->Cell(8,4,'S/ESP','TLR',0,'C');			
			$this->Cell(66,4,'3. DENOMINACION','LR',0,'C');
			$this->SetFont('Arial','',5);
			$this->Cell(18,4,'ANUAL','LR',0,'C');
            $this->Cell(18,4,'5.PROGRAMADO','LR',0,'C');
			$this->Cell(18,4,'COMPROMISO','LR',0,'C');
			$this->Cell(18,4,'CAUSADO','LR',0,'C');
			$this->Cell(18,4,'PAGADO','LR',0,'C');
			$this->Cell(18,4,'METIDO','LR',0,'C');
			$this->Cell(18,4,'8.% CAUSADO','LR',0,'C');
			$this->Cell(18,4,'TRIM.ANTERIOR','LR',0,'C');			
			$this->Cell(18,4,'A LA FECHA','LR',1,'C');		   
           $x=$this->GetX();   $y=$this->GetY();
		   $l=198-$y;
		   $this->rect(10,$y,260,$l);
           $this->Line(18,$y,18,198);
           $this->Line(26,$y,26,198);
           $this->Line(34,$y,34,198);
		   $this->Line(42,$y,42,198);	   
           $this->Line(108,$y,108,198);
           $this->Line(126,$y,126,198); 
           $this->Line(144,$y,144,198); 
           $this->Line(162,$y,162,198); 
           $this->Line(180,$y,180,198);	   
           $this->Line(198,$y,198,198);	
           $this->Line(216,$y,216,198);	 
           $this->Line(234,$y,234,198);
           $this->Line(252,$y,252,198);		   
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
		   global $totalg; global $totalf; global $totald; global $totalda; global $totale; global $totalc; global $totala; global $totalp; global $totalac; global $totalcm; global $totalam; global $totalpm; global $totalau; global $totaldi; global $totaldc; global $totaldp;
			$stotalg=formato_monto($totalg);   $stotalf=formato_monto($totalf);  $stotald=formato_monto($totald);  $stotale=formato_monto($totale); 
			$stotalc=formato_monto($totalc);   $stotala=formato_monto($totala);  $stotalp=formato_monto($totalp);  $stotalm=formato_monto($totalm); 
			$stotalcm=formato_monto($totalcm); $stotalam=formato_monto($totalam);  $stotalpm=formato_monto($totalpm); $stotalac=formato_monto($totalac);
			$stotalau=formato_monto($totalau); $stotaldi=formato_monto($totaldi);
			$stotaldc=formato_monto($totaldc); $stotaldp=formato_monto($totaldp);  $stotalda=formato_monto($totalda); 
            $porc1=0; if($totale>0){ $porc1=($totalcm*100)/$totale;  }		$porc2=0; if($totale>0){ $porc2=($totalam*100)/$totale;  }
            $porc1=formato_monto($porc1);  $porc2=formato_monto($porc2);			
			$this->SetY(-17);			
			$this->SetFont('Arial','B',6);	
			$this->Cell(32,5,'',0,0); 
			$this->Cell(66,5,'TOTALES',0,0,'C');
			$this->Cell(18,5,$stotalg,0,0,'R'); 
			$this->Cell(18,5,$stotale,0,0,'R');
			$this->Cell(18,5,$stotalcm,0,0,'R'); 
			$this->Cell(18,5,$stotalam,0,0,'R');			
			$this->Cell(18,5,$stotalpm,0,0,'R');
			$this->Cell(18,5,$porc1,0,0,'R'); 
			$this->Cell(18,5,$porc2,0,0,'R');
			$this->Cell(18,5,$stotalda,0,0,'R');		
			$this->Cell(18,5,$stotald,0,1,'R');
		}
	  }
	$pdf=new PDF('L', 'mm', Letter);
	$pdf->AliasNbPages();
   	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true, 17);
	$pdf->SetFont('Arial','',6);
	$totalg=0; $totalf=0; $totald=0; $totalda=0; $totale=0; $totalc=0; $totala=0; $totalp=0; $totalac=0;$totalcm=0; $totalam=0; $totalpm=0; $totalau=0; $totaldi=0; $totaldc=0; $totaldp=0;
	$res=pg_query($sSQL); $filas=pg_num_rows($res); 
	while($registro=pg_fetch_array($res)){ 
	    $cod_partida=$registro["cod_partida"];  $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"];  $denomina_par=$registro["denomina_par"];
		if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denomina_par=utf8_decode($denomina_par); $denominacion=utf8_decode($denominacion);}
		$modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"];
        $aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];	$disponible=$registro["disponible"];			
		$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
		$comprometidom=$registro["compromisom"];   $causadom=$registro["causadom"]; $pagadom=$registro["pagadom"]; $asig_act_per=$registro["asig_act_per"];
		$asig_act_acum=$registro["asig_act_acum"]; $dispon=$asig_actualizada-$comprometido;  $deudac=$registro["compromiso"]-$registro["causado"];
		$deuda=$registro["causado"]-$registro["pagado"];	$asignado_trim=$asignado/4;	$dispona=0;
		if($timestre=="01"){ $dispona=0; }
		else{ $dispona=$asig_actualizada-($comprometido-$comprometidom);  }
		/*
		$modificaciones=round($modificaciones,0); $comprometido=round($comprometido,0); $causado=round($causado,0); $pagado=round($pagado,0);
		$aumentos=round($aumentos,0); $disminuciones=round($disminuciones,0); $disponible=round($disponible,0); $asignado=round($asignado,0);
		$asig_actualizada=round($asig_actualizada,0); $dispon=round($dispon,0); $asig_act_per=round($asig_act_per,0); $asig_act_acum=round($asig_act_acum,0);
		$comprometidom=round($comprometidom,0);  $causadom=round($causadom,0); $pagadom=round($pagadom,0); 
		*/		
		if(strlen($cod_partida)==15){ }		
		$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $totald=$totald+$dispon; $totale=$totale+$asignado_trim; 	$totalda=$totalda+$dispona;	
		$totalc=$totalc+$comprometido; $totala=$totala+$causado; $totalp=$totalp+$pagado; $totalac=$totalac+$asig_act_acum;	$totaldc=$totaldc+$deudac; $totaldp=$totaldp+$deuda;	
		$totalcm=$totalcm+$comprometidom; $totalam=$totalam+$causadom; $totalpm=$totalpm+$pagadom;	$totalau=$totalau+$aumentos; $totaldi=$totaldi+$disminuciones;
		$porc1=0; if($asignado_trim>0){ $porc1=($comprometidom*100)/$asignado_trim;  }		$porc2=0; if($asignado_trim>0){ $porc2=($causadom*100)/$asignado_trim;  }
        $asignado=formato_monto($asignado); $asig_actualizada=formato_monto($asig_actualizada); $deudac=formato_monto($deudac); $asignado_trim=formato_monto($asignado_trim);
	    $asig_act_per=formato_monto($asig_act_per); $comprometidom=formato_monto($comprometidom); $deuda=formato_monto($deuda);
	    $causadom=formato_monto($causadom); $pagadom=formato_monto($pagadom); $asig_act_acum=formato_monto($asig_act_acum); 	
		$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); $dispon=formato_monto($dispon);  $dispona=formato_monto($dispona); 
	    $porc1=formato_monto($porc1);  $porc2=formato_monto($porc2);  $aumentos=formato_monto($aumentos);  $disminuciones=formato_monto($disminuciones);
		$mpartida=$cod_presup."-00-00-00-00"; 	$mpartida=substr($mpartida,0,$p);
		$mpart=substr($mpartida,0,3); $mgen=substr($mpartida,4,2); $mesp=substr($mpartida,7,2); $msub=substr($mpartida,10,2);  $msub_e=substr($mpartida,13,2);
        $mfue=$cod_fuente;
		
		//$pdf->Cell(200,5,$asig_actualizada." ".$asignado_trim." ".$comprometido." ".$comprometidom,0,1,'L');
		
		$pdf->Cell(8,5,$mpart,0,0,'C');
		$pdf->Cell(8,5,$mgen,0,0,'C');
		$pdf->Cell(8,5,$mesp,0,0,'C');
		$pdf->Cell(8,5,$msub,0,0,'C');	   
		$x=$pdf->GetX();   $y=$pdf->GetY(); $n=66; 		   
		$pdf->SetXY($x+$n,$y);
		$pdf->Cell(18,5,$asignado,0,0,'R');
        $pdf->Cell(18,5,$asignado_trim,0,0,'R'); 
		$pdf->Cell(18,5,$comprometidom,0,0,'R');
		$pdf->Cell(18,5,$causadom,0,0,'R');
		$pdf->Cell(18,5,$pagadom,0,0,'R');	
        $pdf->Cell(18,5,$porc1,0,0,'R');  		
		$pdf->Cell(18,5,$porc2,0,0,'R');
		$pdf->Cell(18,5,$dispona,0,0,'R');	
		$pdf->Cell(18,5,$dispon,0,1,'R');
		$pdf->SetXY($x,$y);
		$pdf->MultiCell($n,5,$denomina_par,0);
	}
	
	$pdf->Output(); 
  }
  
  if($tipo_rep=="PDF3"){		 
  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){global $mdes_trim; global $criterio1; global $criterio_s; global $Nom_Emp;   global $msector; global $mprograma; global $msub_programa; global $muni_ejec;
		   
		   $ffechar=date("d-m-Y");
		   $this->SetFont('Arial','B',12);
		   $this->Cell(260,4,'CONSOLIDADO  EJECUCIÓN FINANCIERA PRESUPUESTO DE GASTO ',0,1,'C');
		   $this->SetFont('Arial','',8);
		   $this->Cell(260,4,$criterio1." ".'PERIODO: '.$mdes_trim,0,1,'C');
		   $this->Ln(5);		  
		   $this->Cell(160,4,'ORGANISMO DE ADSCRIPCION: GOBERNACION DEL ESTADO MIRANDA',0,1);
		   $this->Cell(160,4,'1. SECTOR : '.$msector,0,1);
		   $this->Cell(160,4,'   PROGRAMA : '.$mprograma,0,1);
		   $this->Cell(160,4,'   SUB-PROGRAMA : '.$msub_programa,0,1);
		   $this->Cell(160,4,'   UNIDAD EJECUTORA : '.$muni_ejec,0,1);
		   $this->Ln(5);		   
		   $y=$this->GetY();	$x=$this->GetX();
		   $this->rect(10,$y,260,204-$y);		   
		   $this->SetFont('Arial','',5);	
		   
            $this->Cell(10,3,' ','TLR',0,'C');			
			$this->Cell(52,3,'','TLR',0,'C');
			$this->Cell(18,3,'4. PRESUPUESTO','TLR',0,'C');
            $this->Cell(18,3,'5. PRESUPUESTO','TLR',0,'C');
			$this->Cell(18,3,'7. PROGRAMADO','TLR',0,'C');			
			$this->Cell(54,3,'7. EJECUTADO EN EL TRIMESTRE','TLR',0,'C');
			$this->Cell(72,3,'8. ACUMULADO EN EL TRIMESTRE','TLR',0,'C');
			$this->Cell(18,3,'9. PROGRAMADO','LR',1,'C');
			
			
			
            $this->SetFont('Arial','',6);
			$this->Cell(10,4,'PARTIDA','LR',0,'C');		
			$this->Cell(52,4,'3. DENOMINACION','LR',0,'C');
			
			$this->SetFont('Arial','',5);
			$this->Cell(18,4,'APRBADO','LR',0,'C');
            $this->Cell(18,4,'MODIFICADO','LR',0,'C');
			 $this->Cell(18,4,'TRIMESTRE','LR',0,'C');
			
			$this->Cell(18,4,'COMPROMISO','TLR',0,'C');
			$this->Cell(18,4,'CAUSADO','TLR',0,'C');
			$this->Cell(18,4,'PAGADO','TLR',0,'C');
			
			$this->Cell(18,4,'PROGRAMADO','TLR',0,'C');
			$this->Cell(18,4,'COMPROMISO','TLR',0,'C');
			$this->Cell(18,4,'CAUSADO','TLR',0,'C');
			$this->Cell(18,4,'PAGADO','TLR',0,'C');		
			$this->Cell(18,4,'PROX.TRIMESTRE','LR',1,'C');	

			
           $x=$this->GetX();   $y=$this->GetY();
		   $l=198-$y;
		   $this->rect(10,$y,260,$l);
           $this->Line(20,$y,20,198);
           $this->Line(72,$y,72,198);
           $this->Line(90,$y,90,198);   
           $this->Line(108,$y,108,198);
           $this->Line(126,$y,126,198); 
           $this->Line(144,$y,144,198); 
           $this->Line(162,$y,162,198); 
           $this->Line(180,$y,180,198);	   
           $this->Line(198,$y,198,198);	
           $this->Line(216,$y,216,198);	 
           $this->Line(234,$y,234,198);
           $this->Line(252,$y,252,198);		   
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
		   global $totalg; global $totalf; global $totalat; global $totald; global $totalda; global $totale; global $totalc; global $totala; global $totalp; global $totalac; global $totalcm; global $totalam; global $totalpm; global $totalau; global $totaldi; global $totaldc; global $totaldp;
			$stotalg=formato_monto($totalg);   $stotalf=formato_monto($totalf);  $stotald=formato_monto($totald);  $stotale=formato_monto($totale); 
			$stotalc=formato_monto($totalc);   $stotala=formato_monto($totala);  $stotalp=formato_monto($totalp);  $stotalm=formato_monto($totalm); 
			$stotalcm=formato_monto($totalcm); $stotalam=formato_monto($totalam);  $stotalpm=formato_monto($totalpm); $stotalac=formato_monto($totalac);
			$stotalau=formato_monto($totalau); $stotaldi=formato_monto($totaldi); $stotalat=formato_monto($totalat);
			$stotaldc=formato_monto($totaldc); $stotaldp=formato_monto($totaldp);  $stotalda=formato_monto($totalda); 
            $porc1=0; $porc2=0;    
			$this->SetY(-17);			
			$this->SetFont('Arial','B',6);	
			$this->Cell(10,5,'',0,0); 
			$this->Cell(52,5,'TOTALES',0,0,'C');
			$this->Cell(18,5,$stotalg,0,0,'R'); 
			$this->Cell(18,5,$stotalf,0,0,'R');
			$this->Cell(18,5,$stotale,0,0,'R');
			$this->Cell(18,5,$stotalcm,0,0,'R'); 
			$this->Cell(18,5,$stotalam,0,0,'R');			
			$this->Cell(18,5,$stotalpm,0,0,'R');
			$this->Cell(18,5,$stotalat,0,0,'R'); 
			$this->Cell(18,5,$stotalc,0,0,'R');
			$this->Cell(18,5,$stotala,0,0,'R');		
			$this->Cell(18,5,$stotalp,0,0,'R');
			$this->Cell(18,5,$stotale,0,1,'R');
		}
	  }
	$pdf=new PDF('L', 'mm', Letter);
	$pdf->AliasNbPages();
   	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true, 17);
	$pdf->SetFont('Arial','',6);
	$totalg=0; $totalf=0; $totalat=0; $totald=0; $totalda=0; $totale=0; $totalc=0; $totala=0; $totalp=0; $totalac=0;$totalcm=0; $totalam=0; $totalpm=0; $totalau=0; $totaldi=0; $totaldc=0; $totaldp=0;
	$res=pg_query($sSQL); $filas=pg_num_rows($res); 
	while($registro=pg_fetch_array($res)){ 
	    $cod_partida=$registro["cod_partida"];  $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"];  $denomina_par=$registro["denomina_par"];
		if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denomina_par=utf8_decode($denomina_par); $denominacion=utf8_decode($denominacion);}
		$modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"];
        $aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];	$disponible=$registro["disponible"];			
		$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
		$comprometidom=$registro["compromisom"];   $causadom=$registro["causadom"]; $pagadom=$registro["pagadom"]; $asig_act_per=$registro["asig_act_per"];
		$asig_act_acum=$registro["asig_act_acum"]; $dispon=$asig_actualizada-$comprometido;  $deudac=$registro["compromiso"]-$registro["causado"];
		$deuda=$registro["causado"]-$registro["pagado"];	$asignado_trim=$asignado/4;	$dispona=0; $asignado_trim_acum=$asignado_trim; $mt=$timestre*1;
		if($timestre=="01"){ $dispona=0; }
		else{ $dispona=$asig_actualizada-($comprometido-$comprometidom);  $asignado_trim_acum=$asignado_trim*$mt;   }
		/*
		$modificaciones=round($modificaciones,0); $comprometido=round($comprometido,0); $causado=round($causado,0); $pagado=round($pagado,0);
		$aumentos=round($aumentos,0); $disminuciones=round($disminuciones,0); $disponible=round($disponible,0); $asignado=round($asignado,0);
		$asig_actualizada=round($asig_actualizada,0); $dispon=round($dispon,0); $asig_act_per=round($asig_act_per,0); $asig_act_acum=round($asig_act_acum,0);
		$comprometidom=round($comprometidom,0);  $causadom=round($causadom,0); $pagadom=round($pagadom,0); 
		*/		
		if(strlen($cod_partida)==15){ }		
		$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $totald=$totald+$dispon; $totale=$totale+$asignado_trim; 	$totalda=$totalda+$dispona;	 $totalat=$totalat+$asignado_trim_acum;
		$totalc=$totalc+$comprometido; $totala=$totala+$causado; $totalp=$totalp+$pagado; $totalac=$totalac+$asig_act_acum;	$totaldc=$totaldc+$deudac; $totaldp=$totaldp+$deuda;	
		$totalcm=$totalcm+$comprometidom; $totalam=$totalam+$causadom; $totalpm=$totalpm+$pagadom;	$totalau=$totalau+$aumentos; $totaldi=$totaldi+$disminuciones;
		$porc1=0; if($asignado_trim>0){ $porc1=($comprometidom*100)/$asignado_trim;  }		$porc2=0; if($asignado_trim>0){ $porc2=($causadom*100)/$asignado_trim;  }
        $asignado=formato_monto($asignado); $asig_actualizada=formato_monto($asig_actualizada); $deudac=formato_monto($deudac); $asignado_trim=formato_monto($asignado_trim);
	    $asig_act_per=formato_monto($asig_act_per); $comprometidom=formato_monto($comprometidom); $deuda=formato_monto($deuda);
	    $causadom=formato_monto($causadom); $pagadom=formato_monto($pagadom); $asig_act_acum=formato_monto($asig_act_acum); 	
		$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); $dispon=formato_monto($dispon);  $dispona=formato_monto($dispona); 
	    $porc1=formato_monto($porc1);  $porc2=formato_monto($porc2);  $aumentos=formato_monto($aumentos);  $disminuciones=formato_monto($disminuciones);
		$mpartida=$cod_presup."-00-00-00-00"; 	$mpartida=substr($mpartida,0,$p);
		$mpart=substr($mpartida,0,3); $mgen=substr($mpartida,4,2); $mesp=substr($mpartida,7,2); $msub=substr($mpartida,10,2);  $msub_e=substr($mpartida,13,2);
        $mfue=$cod_fuente;
		
		//$pdf->Cell(200,5,$asig_actualizada." ".$asignado_trim." ".$comprometido." ".$comprometidom,0,1,'L');
		
		$pdf->Cell(10,5,$mpart,0,0,'C');
		$x=$pdf->GetX();   $y=$pdf->GetY(); $n=52; 		   
		$pdf->SetXY($x+$n,$y);
		$pdf->Cell(18,5,$asignado,0,0,'R');
		$pdf->Cell(18,5,$asig_actualizada,0,0,'R');
        $pdf->Cell(18,5,$asignado_trim,0,0,'R'); 
		$pdf->Cell(18,5,$comprometidom,0,0,'R');
		$pdf->Cell(18,5,$causadom,0,0,'R');
		$pdf->Cell(18,5,$pagadom,0,0,'R');	
        $pdf->Cell(18,5,$asignado_trim_acum,0,0,'R');  		
		$pdf->Cell(18,5,$comprometido,0,0,'R');
		$pdf->Cell(18,5,$causado,0,0,'R');	
		$pdf->Cell(18,5,$pagado,0,o,'R');
		$pdf->Cell(18,5,$asignado_trim,0,1,'R');
		$pdf->SetXY($x,$y);
		$pdf->MultiCell($n,5,$denomina_par,0);
	}
	
	$pdf->Output(); 
  }
  
  
  if($tipo_rep=="EXCEL"){	
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Ejec_presup_finan_trim.xls");
		?>
	   <table>
	     <tr>
         <td><table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="500" align="center" colspan="5"  > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>EJECUCIÓN FINANCIERA TRIMESTRAL DEL PRESUPUESTO DE GASTOS</strong></font></td>
		 </tr>
		 <tr height="20">
		    <td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="500" align="center" colspan="5"  > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1." ".'PERIODO: '.$mdes_trim; ?></strong></font></td>
		 </tr>
		 <tr>
			<td width="70" align="left"></td>
		 </tr>	
		 <tr>
			<td  colspan="7" align="left">ORGANISMO DE ADSCRIPCION: GOBERNACION DEL ESTADO MIRANDA</td>
		 </tr>
         <tr>
			<td  colspan="7" align="left">3. SECTOR : <? echo $msector; ?></td>
		 </tr>
         <tr>
			<td  colspan="7" align="left">4. PROGRAMA : <? echo $mprograma; ?></td>
		 </tr>	
         <tr>
			<td  colspan="7" align="left">5. SUB-PROGRAMA : <? echo $msub_programa; ?></td>
		 </tr>
         <tr>
			<td  colspan="7" align="left">6. UNIDAD EJECUTORA : <? echo $muni_ejec; ?></td>
		 </tr>	
         <tr>
			<td  colspan="7" align="left">7.  ORGANISMO : <? echo $Nom_Emp; ?></td>
		 </tr>			 
         <tr>
			<td width="70" align="left"></td>
		 </tr>			 
		  </table></td>
         </tr>
		 
		 <tr>
            <td><table border="1" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		   <td  colspan="6" align="center" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>8. Codigos Presupuestarios</strong></td>
		   <td width="500" rowspan="3" align="center" bgcolor="#99CCFF"><strong>9. Denominacion</strong></td>
		   <td width="150" rowspan="3" align="center" bgcolor="#99CCFF" ><strong>10. Asignacion Original</strong></td>
		   <td width="150" rowspan="3" align="center" bgcolor="#99CCFF" ><strong>11. Aumentos</strong></td>
		   <td width="150" rowspan="3" align="center" bgcolor="#99CCFF" ><strong>12. Disminuciones</strong></td>
		   <td width="150" rowspan="3" align="center" bgcolor="#99CCFF" ><strong>13. Asignacion Modificada</strong></td>
		   <td width="150" rowspan="3" align="center" bgcolor="#99CCFF" ><strong>14. Compromiso</strong></td>
		   <td width="150" rowspan="3" align="center" bgcolor="#99CCFF" ><strong>15. Saldo Por Comprometer</strong></td>
		   <td width="150" rowspan="3" align="center" bgcolor="#99CCFF" ><strong>16. Monto Causado</strong></td>
		   <td width="150" rowspan="3" align="center" bgcolor="#99CCFF" ><strong>17. Monto Por Causar</strong></td> 	
		   <td width="150" rowspan="3" align="center" bgcolor="#99CCFF" ><strong>18. Monto Pagado</strong></td> 
           <td width="150" rowspan="3" align="center" bgcolor="#99CCFF" ><strong>19. Monto Por Pagar</strong></td> 		   
		 </tr>
		 
		 <tr height="20">
		   <td  colspan="1" rowspan="2" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Part</strong></td>
		   <td  colspan="4" align="left" bgcolor="#99CCFF"><strong>Sub-Partidas</strong></td>
		   <td width="70"  rowspan="2" align="left" bgcolor="#99CCFF"><strong></strong></td>
		 </tr>
		  <tr height="20">
		   <td width="70" align="left" bgcolor="#99CCFF"><strong>Gen.</strong></td>	
		   <td width="70" align="left" bgcolor="#99CCFF"><strong>Esp.</strong></td>	
		   <td width="70" align="left" bgcolor="#99CCFF"><strong>S/Esp.</strong></td>	
		   <td width="70" align="left" bgcolor="#99CCFF"><strong>Sub-1</strong></td>   
		 </tr>
		
		
	   
		<?	
		$totalg=0; $totalf=0; $totald=0; $totale=0; $totalc=0; $totala=0; $totalp=0; $totalac=0;$totalcm=0; $totalam=0; $totalpm=0; $totalau=0; $totaldi=0; $totaldc=0; $totaldp=0;
		$res=pg_query($sSQL); $filas=pg_num_rows($res); 
		while($registro=pg_fetch_array($res)){ 
			$cod_partida=$registro["cod_partida"];  $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"];  $denomina_par=$registro["denomina_par"];
			if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denomina_par=utf8_decode($denomina_par); $denominacion=utf8_decode($denominacion);}
			$modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"];
			$aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];	$disponible=$registro["disponible"];			
			$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
			$comprometidom=$registro["compromisom"];   $causadom=$registro["causadom"]; $pagadom=$registro["pagadom"]; $asig_act_per=$registro["asig_act_per"];
			$asig_act_acum=$registro["asig_act_acum"]; $dispon=$asig_actualizada-$comprometido;  $deudac=$registro["compromiso"]-$registro["causado"];
			$deuda=$registro["causado"]-$registro["pagado"];		
			/*
			$modificaciones=round($modificaciones,0); $comprometido=round($comprometido,0); $causado=round($causado,0); $pagado=round($pagado,0);
			$aumentos=round($aumentos,0); $disminuciones=round($disminuciones,0); $disponible=round($disponible,0); $asignado=round($asignado,0);
			$asig_actualizada=round($asig_actualizada,0); $dispon=round($dispon,0); $asig_act_per=round($asig_act_per,0); $asig_act_acum=round($asig_act_acum,0);
			$comprometidom=round($comprometidom,0);  $causadom=round($causadom,0); $pagadom=round($pagadom,0); 
			*/		
			if(strlen($cod_partida)==15){$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $totald=$totald+$dispon; $totale=$totale+$asig_act_per; 		
			$totalc=$totalc+$comprometido; $totala=$totala+$causado; $totalp=$totalp+$pagado; $totalac=$totalac+$asig_act_acum;	$totaldc=$totaldc+$deudac; $totaldp=$totaldp+$deuda;	
			$totalcm=$totalcm+$comprometidom; $totalam=$totalam+$causadom; $totalpm=$totalpm+$pagadom;	$totalau=$totalau+$aumentos; $totaldi=$totaldi+$disminuciones;}
			$porc1=0; if($asig_act_per>0){ $porc1=($causadom*100)/$asig_act_per;  }		$porc2=0; if($asig_act_per>0){ $porc2=($pagadom*100)/$asig_act_per;  }		
			$asignado=formato_monto($asignado); $asig_actualizada=formato_monto($asig_actualizada); $deudac=formato_monto($deudac);
			$asig_act_per=formato_monto($asig_act_per); $comprometidom=formato_monto($comprometidom); $deuda=formato_monto($deuda);
			$causadom=formato_monto($causadom); $pagadom=formato_monto($pagadom); $asig_act_acum=formato_monto($asig_act_acum); 	
			$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); $dispon=formato_monto($dispon); 
			$porc1=formato_monto($porc1);  $porc2=formato_monto($porc2);  $aumentos=formato_monto($aumentos);  $disminuciones=formato_monto($disminuciones);
			$mpartida=$cod_presup."-00-00-00-00"; 	$mpartida=substr($mpartida,0,$p);
			$mpart=substr($mpartida,0,3); $mgen=substr($mpartida,4,2); $mesp=substr($mpartida,7,2); $msub=substr($mpartida,10,2);  $msub_e=substr($mpartida,13,2);
			$mfue=$cod_fuente;
			if(strlen($cod_partida)==15){ $mfue=$cod_fuente; if($mfue=="00"){ $mfue="PO";}else{$mfue="DEC";}  } else{ $mfue="N/A";}		
			$stilo1="mso-number-format:'@';";
			
			?>	   
			<tr>
			   <td width="70" align="center" style="<? echo $stilo1; ?>"><? echo $mpart; ?></td>
			   <td width="70" align="center" style="<? echo $stilo1; ?>"><? echo $mgen; ?></td>
			   <td width="70" align="center" style="<? echo $stilo1; ?>"><? echo $mesp; ?></td>
			   <td width="70" align="center" style="<? echo $stilo1; ?>"><? echo $msub; ?></td>
			   <td width="70" align="center"  style="<? echo $stilo1; ?>"><? echo $msub_e; ?></td>
			   <td width="70" align="center"><? echo $mfue; ?></td>	
			   <td width="500" align="justify"><? echo $denomina_par; ?></td>				   
			   <td width="150" align="right"><? echo $asignado; ?></td>
			   <td width="150" align="right"><? echo $aumentos; ?></td>
			   <td width="150" align="right"><? echo $disminuciones; ?></td>
			   <td width="150" align="right"><? echo $asig_actualizada; ?></td>
			   <td width="150" align="right"><? echo $comprometido; ?></td>
			   <td width="150" align="right"><? echo $dispon; ?></td>
			   <td width="150" align="right"><? echo $causado; ?></td>
			   <td width="150" align="right"><? echo $deudac; ?></td>
			   <td width="150" align="right"><? echo $pagado; ?></td>
			   <td width="150" align="right"><? echo $deuda; ?></td>
			 </tr>
			<? 			
		}
        $stotalg=formato_monto($totalg);   $stotalf=formato_monto($totalf);  $stotald=formato_monto($totald);  $stotale=formato_monto($totale); 
		$stotalc=formato_monto($totalc);   $stotala=formato_monto($totala);  $stotalp=formato_monto($totalp);  $stotalm=formato_monto($totalm); 
		$stotalcm=formato_monto($totalcm); $stotalam=formato_monto($totalam);  $stotalpm=formato_monto($totalpm); $stotalac=formato_monto($totalac);
		$stotalau=formato_monto($totalau); $stotaldi=formato_monto($totaldi);  $stotaldc=formato_monto($totaldc); $stotaldp=formato_monto($totaldp);
		?>
		<tr>
			   <td width="70" align="center"><strong></strong></td>
			   <td width="70" align="center"><strong></strong></td>
			   <td width="70" align="center"><strong></strong></td>
			   <td width="70" align="center"><strong></strong></td>
			   <td width="70" align="center"><strong></strong></td>
			   <td width="70" align="center"><strong></strong></td>		   
			   <td width="500" align="justify"><strong>TOTALES</strong></td>				   
			   <td width="150" align="right"><strong><? echo $stotalg; ?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalau;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotaldi;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalf;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalc;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotald;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotala;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotaldc;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalp;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotaldp; ?></strong></td>
			 </tr>
		</table></td>
         </tr>				
		 </table>
		<?  
  }


  if($tipo_rep=="EXCEL2"){	
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Ejec_presup_finan_trim.xls");
		?>
	   <table>
	     <tr>
         <td><table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="500" align="center" colspan="5"  > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>EJECUCIÓN FINANCIERA TRIMESTRAL DEL PRESUPUESTO DE GASTOS</strong></font></td>
		 </tr>
		 <tr height="20">
		    <td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="70" align="left" ><strong></strong></td>
			<td width="500" align="center" colspan="5"  > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1." ".'PERIODO: '.$mdes_trim; ?></strong></font></td>
		 </tr>
		 <tr>
			<td width="70" align="left"></td>
		 </tr>	
		 <tr>
			<td  colspan="7" align="left">ORGANISMO DE ADSCRIPCION: GOBERNACION DEL ESTADO MIRANDA</td>
		 </tr>
         <tr>
			<td  colspan="7" align="left">1. SECTOR : <? echo $msector; ?></td>
		 </tr>
         <tr>
			<td  colspan="7" align="left"> PROGRAMA : <? echo $mprograma; ?></td>
		 </tr>	
         <tr>
			<td  colspan="7" align="left"> SUB-PROGRAMA : <? echo $msub_programa; ?></td>
		 </tr>
         <tr>
			<td  colspan="7" align="left"> UNIDAD EJECUTORA : <? echo $muni_ejec; ?></td>
		 </tr>	
         	 
         <tr>
			<td width="70" align="left"></td>
		 </tr>			 
		  </table></td>
         </tr>
		 
		 <tr>
            <td><table border="1" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		   <td width="70"  align="left" bgcolor="#99CCFF"><strong>Part.</strong></td>	
		   <td width="70"  align="left" bgcolor="#99CCFF"><strong>Gen.</strong></td>	
		   <td width="70"  align="left" bgcolor="#99CCFF"><strong>Esp.</strong></td>	
		   <td width="70"  align="left" bgcolor="#99CCFF"><strong>S/Esp.</strong></td>	
		   <td width="500"  align="center" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
		   <td width="150"  align="center" bgcolor="#99CCFF" ><strong>Presupuesto Anual</strong></td>
		   <td width="150"  align="center" bgcolor="#99CCFF" ><strong>Programado</strong></td>
		   <td width="150"  align="center" bgcolor="#99CCFF" ><strong> Compromiso</strong></td>
		   <td width="150"  align="center" bgcolor="#99CCFF" ><strong> Causado</strong></td>
		   <td width="150"  align="center" bgcolor="#99CCFF" ><strong> Pagado</strong></td>
		   <td width="150"  align="center" bgcolor="#99CCFF" ><strong> % Compromiso</strong></td>
		   <td width="150"  align="center" bgcolor="#99CCFF" ><strong> % Causado</strong></td>
		   <td width="150"  align="center" bgcolor="#99CCFF" ><strong>Disponibilidad Trim Anterior</strong></td> 
           <td width="150"  align="center" bgcolor="#99CCFF" ><strong>Disponibilidad a la Fecha</strong></td> 		   
		 </tr>
		
                  
		
		<?$totalg=0; $totalf=0; $totald=0; $totalda=0; $totale=0; $totalc=0; $totala=0; $totalp=0; $totalac=0;$totalcm=0; $totalam=0; $totalpm=0; $totalau=0; $totaldi=0; $totaldc=0; $totaldp=0;
		$res=pg_query($sSQL); $filas=pg_num_rows($res); 
		while($registro=pg_fetch_array($res)){ 
			$cod_partida=$registro["cod_partida"];  $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"];  $denomina_par=$registro["denomina_par"];
			//if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denomina_par=utf8_decode($denomina_par); $denominacion=utf8_decode($denominacion);}
			$modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"];
			$aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];	$disponible=$registro["disponible"];			
			$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
			$comprometidom=$registro["compromisom"];   $causadom=$registro["causadom"]; $pagadom=$registro["pagadom"]; $asig_act_per=$registro["asig_act_per"];
			$asig_act_acum=$registro["asig_act_acum"]; $dispon=$asig_actualizada-$comprometido;  $deudac=$registro["compromiso"]-$registro["causado"];
			$deuda=$registro["causado"]-$registro["pagado"];	$asignado_trim=$asignado/4;	$dispona=0;
			if($timestre=="01"){ $dispona=0; }
			else{ $dispona=$asig_actualizada-($comprometido-$comprometidom);  }
			/*
			$modificaciones=round($modificaciones,0); $comprometido=round($comprometido,0); $causado=round($causado,0); $pagado=round($pagado,0);
			$aumentos=round($aumentos,0); $disminuciones=round($disminuciones,0); $disponible=round($disponible,0); $asignado=round($asignado,0);
			$asig_actualizada=round($asig_actualizada,0); $dispon=round($dispon,0); $asig_act_per=round($asig_act_per,0); $asig_act_acum=round($asig_act_acum,0);
			$comprometidom=round($comprometidom,0);  $causadom=round($causadom,0); $pagadom=round($pagadom,0); 
			*/		
			if(strlen($cod_partida)==15){ }		
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $totald=$totald+$dispon; $totale=$totale+$asignado_trim; 	$totalda=$totalda+$dispona;	
			$totalc=$totalc+$comprometido; $totala=$totala+$causado; $totalp=$totalp+$pagado; $totalac=$totalac+$asig_act_acum;	$totaldc=$totaldc+$deudac; $totaldp=$totaldp+$deuda;	
			$totalcm=$totalcm+$comprometidom; $totalam=$totalam+$causadom; $totalpm=$totalpm+$pagadom;	$totalau=$totalau+$aumentos; $totaldi=$totaldi+$disminuciones;
			$porc1=0; if($asignado_trim>0){ $porc1=($comprometidom*100)/$asignado_trim;  }		$porc2=0; if($asignado_trim>0){ $porc2=($causadom*100)/$asignado_trim;  }
			$asignado=formato_monto($asignado); $asig_actualizada=formato_monto($asig_actualizada); $deudac=formato_monto($deudac); $asignado_trim=formato_monto($asignado_trim);
			$asig_act_per=formato_monto($asig_act_per); $comprometidom=formato_monto($comprometidom); $deuda=formato_monto($deuda);
			$causadom=formato_monto($causadom); $pagadom=formato_monto($pagadom); $asig_act_acum=formato_monto($asig_act_acum); 	
			$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); $dispon=formato_monto($dispon); 
			$porc1=formato_monto($porc1);  $porc2=formato_monto($porc2);  $aumentos=formato_monto($aumentos);  $disminuciones=formato_monto($disminuciones);
			$mpartida=$cod_presup."-00-00-00-00"; 	$mpartida=substr($mpartida,0,$p);
			$mpart=substr($mpartida,0,3); $mgen=substr($mpartida,4,2); $mesp=substr($mpartida,7,2); $msub=substr($mpartida,10,2);  $msub_e=substr($mpartida,13,2);
			$mfue=$cod_fuente;
			$stilo1="mso-number-format:'@';";			
			?>	   
			<tr>
			   <td width="70" align="center" style="<? echo $stilo1; ?>"><? echo $mpart; ?></td>
			   <td width="70" align="center" style="<? echo $stilo1; ?>"><? echo $mgen; ?></td>
			   <td width="70" align="center" style="<? echo $stilo1; ?>"><? echo $mesp; ?></td>
			   <td width="70" align="center" style="<? echo $stilo1; ?>"><? echo $msub; ?></td>
			  		   
			   <td width="500" align="justify"><? echo $denomina_par; ?></td>				   
			   <td width="150" align="right"><? echo $asignado; ?></td>
			   <td width="150" align="right"><? echo $asignado_trim; ?></td>
			   <td width="150" align="right"><? echo $comprometidom; ?></td>
			   <td width="150" align="right"><? echo $causadom; ?></td>
			   <td width="150" align="right"><? echo $pagadom; ?></td>
			   <td width="150" align="right"><? echo $porc1; ?></td>
			   <td width="150" align="right"><? echo $porc2; ?></td>
			   <td width="150" align="right"><? echo $dispona; ?></td>
			   <td width="150" align="right"><? echo $dispon; ?></td>
			 </tr>
			<? 			
		}
		 $porc1=0; if($totale>0){ $porc1=($totalcm*100)/$totale;  }		$porc2=0; if($totale>0){ $porc2=($totalam*100)/$totale;  }
            $porc1=formato_monto($porc1);  $porc2=formato_monto($porc2);	    
        $stotalg=formato_monto($totalg);   $stotalf=formato_monto($totalf);  $stotald=formato_monto($totald);  $stotale=formato_monto($totale); 
		$stotalc=formato_monto($totalc);   $stotala=formato_monto($totala);  $stotalp=formato_monto($totalp);  $stotalm=formato_monto($totalm); 
		$stotalcm=formato_monto($totalcm); $stotalam=formato_monto($totalam);  $stotalpm=formato_monto($totalpm); $stotalac=formato_monto($totalac);
		$stotalau=formato_monto($totalau); $stotaldi=formato_monto($totaldi);  $stotaldc=formato_monto($totaldc); $stotaldp=formato_monto($totaldp); $stotalda=formato_monto($totalda); 
		?>
		<tr>
			   <td width="70" align="center"><strong></strong></td>
			   <td width="70" align="center"><strong></strong></td>
			   <td width="70" align="center"><strong></strong></td>
			   <td width="70" align="center"><strong></strong></td>   
			   <td width="500" align="justify"><strong>TOTALES</strong></td>				   
			   <td width="150" align="right"><strong><? echo $stotalg; ?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotale;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalcm;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalam;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalpm;?></strong></td>
			   <td width="150" align="right"><strong><? echo $porc1;?></strong></td>
			   <td width="150" align="right"><strong><? echo $porc2;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalda;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotald; ?></strong></td>
			 </tr>
		</table></td>
         </tr>				
		 </table>
		<?  
  }  
  
  
  if($tipo_rep=="EXCEL3"){	
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Cons_ejec_finan_trim.xls");
		?>
	   <table>
	     <tr>
         <td><table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
			<td width="70" align="left" ><strong></strong></td>
			<td width="500" align="center" colspan="5"  > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CONSOLIDADO EJECUCIÓN FINANCIERA PRESUPUESTO DE GASTO </strong></font></td>
		 </tr>
		 <tr height="20">
		    <td width="70" align="left" ><strong></strong></td>
			<td width="500" align="center" colspan="5"  > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1." ".'PERIODO: '.$mdes_trim; ?></strong></font></td>
		 </tr>
		 <tr>
			<td width="70" align="left"></td>
		 </tr>	
		 <tr>
			<td  colspan="7" align="left">ORGANISMO DE ADSCRIPCION: GOBERNACION DEL ESTADO MIRANDA</td>
		 </tr>
         <tr>
			<td  colspan="7" align="left">1. SECTOR : <? echo $msector; ?></td>
		 </tr>
         <tr>
			<td  colspan="7" align="left"> PROGRAMA : <? echo $mprograma; ?></td>
		 </tr>	
         <tr>
			<td  colspan="7" align="left"> SUB-PROGRAMA : <? echo $msub_programa; ?></td>
		 </tr>
         <tr>
			<td  colspan="7" align="left"> UNIDAD EJECUTORA : <? echo $muni_ejec; ?></td>
		 </tr>	         		 
         <tr>
			<td width="70" align="left"></td>
		 </tr>			 
		  </table></td>
         </tr>
		 
		 <tr>
            <td><table border="1" cellspacing='0' cellpadding='0' align="left">
		 
		 <tr height="20">
		   <td width="70"   rowspan="2" align="left" bgcolor="#99CCFF"><strong>PARTIDAS</strong></td>
		   <td width="500"  rowspan="2" align="center" bgcolor="#99CCFF"><strong>DENOMINACION</strong></td>
		   <td width="150"  rowspan="2" align="center" bgcolor="#99CCFF" ><strong>PRESUPUESTO APROBADO</strong></td>
		   <td width="150"  rowspan="2" align="center" bgcolor="#99CCFF" ><strong>PRESUPUESTO MODIFICADO</strong></td>
		   <td width="150"  rowspan="2" align="center" bgcolor="#99CCFF" ><strong>PROGRAMADO EN EL TRIMESTRE</strong></td>
		   <td colspan="3"  align="center" bgcolor="#99CCFF" ><strong> EJECUTADO EN EL TRIMESTRE </strong></td>
		   <td colspan="4"  align="center" bgcolor="#99CCFF" ><strong> ACUMULADO AL TRIMESTRE</strong></td>
           <td width="150"  rowspan="2" align="center" bgcolor="#99CCFF" ><strong>PROGRAMADO PROXIMO TRIMESTRE</strong></td> 		   
		 </tr>
		 
		 
		 <tr height="20">		  
		   <td width="150"  align="center" bgcolor="#99CCFF" ><strong> COMPROMISO</strong></td>
		   <td width="150"  align="center" bgcolor="#99CCFF" ><strong> CAUSADO</strong></td>
		   <td width="150"  align="center" bgcolor="#99CCFF" ><strong> PAGADO</strong></td>
		   <td width="150"  align="center" bgcolor="#99CCFF" ><strong>PROGRAMADO</strong></td>
		   <td width="150"  align="center" bgcolor="#99CCFF" ><strong> COMPROMISO</strong></td>
		   <td width="150"  align="center" bgcolor="#99CCFF" ><strong> CAUSADO</strong></td>
		   <td width="150"  align="center" bgcolor="#99CCFF" ><strong> PAGADO</strong></td> 
		 </tr>
		
                  
		
		<?$totalg=0; $totalf=0; $totalat=0; $totald=0; $totalda=0; $totale=0; $totalc=0; $totala=0; $totalp=0; $totalac=0;$totalcm=0; $totalam=0; $totalpm=0; $totalau=0; $totaldi=0; $totaldc=0; $totaldp=0;
		$res=pg_query($sSQL); $filas=pg_num_rows($res); 
		while($registro=pg_fetch_array($res)){ 
			$cod_partida=$registro["cod_partida"];  $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"];  $denomina_par=$registro["denomina_par"];
			//if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }   else{$denomina_par=utf8_decode($denomina_par); $denominacion=utf8_decode($denominacion);}
			$modificaciones=$registro["modificaciones"]; $comprometido=$registro["compromiso"];   $causado=$registro["causado"]; $pagado=$registro["pagado"];
			$aumentos=$registro["aumentos"]; $disminuciones=$registro["disminuciones"];	$disponible=$registro["disponible"];			
			$disponible=$registro["disponibilidad"];  $asignado=$registro["asignado"];  $asig_actualizada=$registro["asig_actualizada"]; $deuda=$registro["causado"]-$registro["pagado"];	
			$comprometidom=$registro["compromisom"];   $causadom=$registro["causadom"]; $pagadom=$registro["pagadom"]; $asig_act_per=$registro["asig_act_per"];
			$asig_act_acum=$registro["asig_act_acum"]; $dispon=$asig_actualizada-$comprometido;  $deudac=$registro["compromiso"]-$registro["causado"];
			$deuda=$registro["causado"]-$registro["pagado"];	$asignado_trim=$asignado/4;	$dispona=0; $asignado_trim_acum=$asignado_trim; $mt=$timestre*1;
			if($timestre=="01"){ $dispona=0; }
			else{ $dispona=$asig_actualizada-($comprometido-$comprometidom);  $asignado_trim_acum=$asignado_trim*$mt;   }
			/*
			$modificaciones=round($modificaciones,0); $comprometido=round($comprometido,0); $causado=round($causado,0); $pagado=round($pagado,0);
			$aumentos=round($aumentos,0); $disminuciones=round($disminuciones,0); $disponible=round($disponible,0); $asignado=round($asignado,0);
			$asig_actualizada=round($asig_actualizada,0); $dispon=round($dispon,0); $asig_act_per=round($asig_act_per,0); $asig_act_acum=round($asig_act_acum,0);
			$comprometidom=round($comprometidom,0);  $causadom=round($causadom,0); $pagadom=round($pagadom,0); 
			*/		
			if(strlen($cod_partida)==15){ }		
			$totalg=$totalg+$asignado; $totalf=$totalf+$asig_actualizada; $totald=$totald+$dispon; $totale=$totale+$asignado_trim; 	$totalda=$totalda+$dispona;	 $totalat=$totalat+$asignado_trim_acum;
			$totalc=$totalc+$comprometido; $totala=$totala+$causado; $totalp=$totalp+$pagado; $totalac=$totalac+$asig_act_acum;	$totaldc=$totaldc+$deudac; $totaldp=$totaldp+$deuda;	
			$totalcm=$totalcm+$comprometidom; $totalam=$totalam+$causadom; $totalpm=$totalpm+$pagadom;	$totalau=$totalau+$aumentos; $totaldi=$totaldi+$disminuciones;
			$porc1=0; if($asignado_trim>0){ $porc1=($comprometidom*100)/$asignado_trim;  }		$porc2=0; if($asignado_trim>0){ $porc2=($causadom*100)/$asignado_trim;  }
			$asignado=formato_monto($asignado); $asig_actualizada=formato_monto($asig_actualizada); $deudac=formato_monto($deudac); $asignado_trim=formato_monto($asignado_trim);
			$asig_act_per=formato_monto($asig_act_per); $comprometidom=formato_monto($comprometidom); $deuda=formato_monto($deuda);
			$causadom=formato_monto($causadom); $pagadom=formato_monto($pagadom); $asig_act_acum=formato_monto($asig_act_acum); 	
			$comprometido=formato_monto($comprometido);  $causado=formato_monto($causado); 	$pagado=formato_monto($pagado); $dispon=formato_monto($dispon);  $dispona=formato_monto($dispona); 
			$porc1=formato_monto($porc1);  $porc2=formato_monto($porc2);  $aumentos=formato_monto($aumentos);  $disminuciones=formato_monto($disminuciones);
			$mpartida=$cod_presup."-00-00-00-00"; 	$mpartida=substr($mpartida,0,$p);
			$mpart=substr($mpartida,0,3); $mgen=substr($mpartida,4,2); $mesp=substr($mpartida,7,2); $msub=substr($mpartida,10,2);  $msub_e=substr($mpartida,13,2);
			$mfue=$cod_fuente;
			$stilo1="mso-number-format:'@';";			
			?>	   
			<tr>
			   <td width="70" align="center" style="<? echo $stilo1; ?>"><? echo $mpart; ?></td>			  		   
			   <td width="500" align="justify"><? echo $denomina_par; ?></td>				   
			   <td width="150" align="right"><? echo $asignado; ?></td>
			   <td width="150" align="right"><? echo $asig_actualizada; ?></td>
			   <td width="150" align="right"><? echo $asignado_trim; ?></td>
			   <td width="150" align="right"><? echo $comprometidom; ?></td>
			   <td width="150" align="right"><? echo $causadom; ?></td>
			   <td width="150" align="right"><? echo $pagadom; ?></td>
			   <td width="150" align="right"><? echo $asignado_trim_acum; ?></td>
			   <td width="150" align="right"><? echo $comprometido; ?></td>
			   <td width="150" align="right"><? echo $causado; ?></td>
			   <td width="150" align="right"><? echo $pagado; ?></td>
			   <td width="150" align="right"><? echo $asignado_trim; ?></td>
			 </tr>
			<? 			
		}
		 $porc1=0; 	$porc2=0; 
        $stotalg=formato_monto($totalg);   $stotalf=formato_monto($totalf);  $stotald=formato_monto($totald);  $stotale=formato_monto($totale); 
		$stotalc=formato_monto($totalc);   $stotala=formato_monto($totala);  $stotalp=formato_monto($totalp);  $stotalm=formato_monto($totalm); 
		$stotalcm=formato_monto($totalcm); $stotalam=formato_monto($totalam);  $stotalpm=formato_monto($totalpm); $stotalac=formato_monto($totalac); $stotalat=formato_monto($totalat);
		$stotalau=formato_monto($totalau); $stotaldi=formato_monto($totaldi);  $stotaldc=formato_monto($totaldc); $stotaldp=formato_monto($totaldp); $stotalda=formato_monto($totalda); 
		?>
		<tr>
			   <td width="70" align="center"><strong></strong></td>
			   <td width="500" align="justify"><strong>TOTALES</strong></td>				   
			   <td width="150" align="right"><strong><? echo $stotalg; ?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalf;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotale;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalcm;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalam;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalpm;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalat;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalc;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotala;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotalp;?></strong></td>
			   <td width="150" align="right"><strong><? echo $stotale; ?></strong></td>
			 </tr>
		</table></td>
         </tr>				
		 </table>
		<?  
  }  
  
  $StrSQL = "DELETE FROM pre020 Where (tipo_registro='M') And (nombre_usuario='".$cod_mov."')";
  /*  */
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
 
?>