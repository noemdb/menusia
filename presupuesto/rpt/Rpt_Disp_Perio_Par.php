<?include ("../../class/conect.php");  include ("../../class/funciones.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); include ("../../class/phpreports/PHPReportMaker.php");
if ($_GET){$cod_presup_d=$_GET["cod_presupd"];$cod_presup_h=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuented"];$cod_fuente_h=$_GET["cod_fuenteh"];$mes_desde=$_GET["mes_desde"];$mes_hasta=$_GET["mes_hasta"];$asig_global=$_GET["asig_global"]; $c_cat=$_GET["csubtotal"];} 
else{$codigod="";$codigoh="";$fuented="";$fuenteh="";$fecha=""; $cant_cat=1;}   $equipo=getenv("COMPUTERNAME"); $cod_mov="PRE020".$usuario_sia; 
//$asig_global="N"; 
$mdes_cat=array("NINGUNA","","","","","");
$mcontrol = array (0, 0, 0, 0, 0, 0, 0, 0, 0,0);
function buscar_control($clave, $formato){  global $mcontrol;  $j=0;
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} }
  if ($actual==-1){?><script language="JavaScript">muestra('ERROR Longitud del Código Invalido');</script><? }
  return $actual;
}
if ($mes_desde==01){$mesd="Enero";}elseif ($mes_desde==02){$mesd="Febrero";}elseif ($mes_desde==03){$mesd="Marzo";}elseif ($mes_desde==04){$mesd="Abril";}elseif ($mes_desde==05){$mesd="Mayo";}elseif ($mes_desde==06){$mesd="Junio";}elseif ($mes_desde==07){$mesd="Julio";}elseif ($mes_desde==08){$mesd="Agosto";}elseif ($mes_desde==09){$mesd="Septiembre";}elseif ($mes_desde==10){$mesd="Octubre";}elseif ($mes_desde==11){$mesd="Noviembre";}elseif ($mes_desde==12){$mesd="Diciembre";}
if ($mes_hasta==01){$mesh="Enero";}elseif ($mes_hasta==02){$mesh="Febrero";}elseif ($mes_hasta==03){$mesh="Marzo";}elseif ($mes_hasta==04){$mesh="Abril";}elseif ($mes_hasta==05){$mesh="Mayo";}elseif ($mes_hasta==06){$mesh="Junio";}elseif ($mes_hasta==07){$mesh="Julio";}elseif ($mes_hasta==08){$mesh="Agosto";}elseif ($mes_hasta==09){$mesh="Septiembre";}elseif ($mes_hasta==10){$mesh="Octubre";}elseif ($mes_hasta==11){$mesh="Noviembre";}elseif ($mes_hasta==12){$mesh="Diciembre";}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  
   $criterio1="Desde: ".$mesd." Hasta: ".$mesh; $criterio2="";   
   $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
   $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"]; $mdes_cat[1]=$registro["campo505"]; $mdes_cat[2]=$registro["campo507"]; $mdes_cat[3]=$registro["campo509"]; $mdes_cat[4]=$registro["campo511"]; $mdes_cat[5]=$registro["campo512"];}
   $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presup,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
   
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
  
   $per_hasta=$mes_hasta;
  $sql_Asignacion=""; $sql_Traslados=""; $sql_Trasladon=""; $sql_Adicion=""; $sql_Disminucion=""; 
  $sql_Compromiso=""; $sql_Diferido=""; $sql_Causado=""; $sql_Pagado=""; $sql_Diferido ="";
  If($per_hasta==0){ $sql_Traslados="0 as Traslados,";  $sql_Trasladon="0 as Trasladon,";  $sql_Adicion="0 as Adicion,";
     $sql_Disminucion="0 as Disminucion,"; $sql_Compromiso="0 as Compromiso,"; $sql_Causado="0 as Causado,";
     $sql_Pagado="0 as Pagado,"; $sql_Asignacion="0 as asignado,"; $sql_Asignacion="asignado,";  $sql_Diferido="0 as Diferido"; }
   else{for ($i=$mes_desde; $i <= $per_hasta; $i++){ $pos=$i; $pos=Rellenarcerosizq($pos,2);
      If($i==1){$scampo = "(Traslados".$pos;  $scampo1 = "(Trasladon".$pos;  $scampo2 = "(Adicion".$pos;
           $scampo3 = "(Disminucion".$pos;  $scampo4 = "(Compromiso".$pos;  $scampo5 = "(Causado".$pos;
           $scampo6 = "(Pagado".$pos;  $scampo7 = "(asignado".$pos; $scampo8 = "(Diferido".$pos; }
       else{$scampo = "+Traslados".$pos;$scampo1 = "+Trasladon".$pos;$scampo2 = "+Adicion".$pos;
           $scampo3 = "+Disminucion".$pos; $scampo4 = "+Compromiso".$pos;$scampo5 = "+Causado".$pos;
           $scampo6 = "+Pagado".$pos; $scampo7 = "+asignado".$pos; $scampo8 = "+Diferido".$pos;}
      $sql_Traslados=$sql_Traslados.$scampo;  $sql_Trasladon=$sql_Trasladon.$scampo1; $sql_Adicion=$sql_Adicion.$scampo2;
      $sql_Disminucion=$sql_Disminucion.$scampo3;  $sql_Compromiso=$sql_Compromiso.$scampo4;
      $sql_Causado=$sql_Causado.$scampo5; $sql_Pagado=$sql_Pagado.$scampo6;
      $sql_Asignacion=$sql_Asignacion.$scampo7; $sql_Diferido=$sql_Diferido.$scampo8;		   
	} 
    $sql_Traslados=$sql_Traslados.") as Traslados,"; $sql_Trasladon=$sql_Trasladon.") as Trasladon,";
    $sql_Adicion=$sql_Adicion.") as Adicion,"; $sql_Disminucion=$sql_Disminucion.") as Disminucion,";
    $sql_Compromiso=$sql_Compromiso.") as Compromiso,"; $sql_Causado=$sql_Causado.") as Causado,";
    $sql_Pagado=$sql_Pagado.") as Pagado,"; $sql_Asignacion=$sql_Asignacion.") as asignado,";
    $sql_Asignacion="asignado,"; $sql_Diferido=$sql_Diferido.") as Diferido";	
   }
   
   $StrSQL = "DELETE FROM PRE020 Where (Tipo_Registro='2') And (Nombre_Usuario='".$cod_mov."')";
   $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
   if($asig_global=="S"){$sql_Asignacion="asignado,";}
  
  
  
  $StrSQL= "INSERT INTO PRE020 SELECT '".$cod_mov."' as Nombre_Usuario,'2' as Tipo_Registro, Cod_Presup, Cod_Fuente, Denominacion,substr(cod_presup,1,".$ls.") as cod_categoria,"."'' as Denomina_cat,substr(cod_presup,".$ini.",".$p.") as cod_partida,'' as Denomina_Par,Status_Dist,Func_Inv,Ord_Cord,Aplicacion,Cod_Unidad_Ejec, ";
  $StrSQL=$StrSQL.$sql_Asignacion." Disponible,Disp_Diferida,".$sql_Compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.", "."0 as CompromisoM,0 as CausadoM, 0 as PagadoM, 0 as TrasladosM, 0 as TrasladonM, 0 as AdicionM, 0 as DisminucionM, 0 as DiferidoM ";
  $StrSQL=$StrSQL." FROM PRE001 WHERE length(Cod_Presup)=".$l_c." and ".$criterio;
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

  $ordenar=" ORDER BY PRE020.cod_partida";
  if($c_cat>0){ $ordenar=" ORDER BY PRE020.cod_categoria,PRE020.cod_partida";
   $sSQL = "Select cod_presup,denominacion from pre001 WHERE cod_presup in (select distinct cod_categoria from pre020 where (Tipo_Registro='2') and (Nombre_Usuario='$cod_mov'))";  $res=pg_query($sSQL);
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_presup"]; $denominacion=$registro["denominacion"]; 
     $sql="update pre020 set denomina_cat='$denominacion' where Tipo_Registro='2' and Nombre_Usuario='$cod_mov' and cod_categoria='$cod_presup'";$resultado=pg_exec($conn,$sql); 
	 $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  }}
  
  		$sSQL = "SELECT PRE020.Cod_Presup,PRE020.cod_fuente, PRE020.Denominacion,PRE020.cod_categoria,PRE020.denomina_cat,PRE020.cod_partida, substring(PRE020.cod_partida,1,3) as partida, PRE020.Asignado, PRE020.Traslados, PRE020.Trasladon, PRE020.Adicion, 
			 PRE020.Disminucion, PRE020.Compromiso, PRE020.Causado, PRE020.Pagado, PRE020.Disponible, 
			(PRE020.Traslados-PRE020.Trasladon+PRE020.Adicion-PRE020.Disminucion) AS Modificaciones,
			(PRE020.Asignado+PRE020.Traslados-PRE020.Trasladon+PRE020.Adicion-PRE020.Disminucion) AS Asig_Actualizada, 
			(PRE020.Asignado+PRE020.Traslados-PRE020.Trasladon+PRE020.Adicion-PRE020.Disminucion-PRE020.Compromiso) AS Disponibilidad
			 FROM PRE020 WHERE Tipo_Registro='2' and Nombre_Usuario='$cod_mov' and ".$criterio.$ordenar;


        $oRpt = new PHPReportMaker();
		if($c_cat==0){$oRpt->setXML("Rpt_Disponibilidad_Per_Par.xml");}else{$oRpt->setXML("Rpt_Disponibilidad_Per_Par_Subt.xml");}
        $oRpt->setUser("$user");
        $oRpt->setPassword("$password");
        $oRpt->setConnection("localhost");
        $oRpt->setDatabaseInterface("postgresql");
		$oRpt->setSQL($sSQL);
        $oRpt->setDatabase("$dbname");
		$oRpt->setParameters(array("criterio1"=>$criterio1,"criterios"=>$criterio_s));          
        $oRpt->run();

?>

