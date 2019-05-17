<?include ("../../class/conect.php");  include ("../../class/funciones.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); include ("../../class/phpreports/PHPReportMaker.php");
if ($_GET){$cod_presup_d=$_GET["cod_presupd"];$cod_presup_h=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuented"];$cod_fuente_h=$_GET["cod_fuenteh"];$mes=$_GET["mes"];$tipo_deuda=$_GET["tipo_deuda"];}
else{$codigod="";$codigoh="";$fuented="";$fuenteh="";$fecha="";}   $equipo=getenv("COMPUTERNAME"); $cod_mov="PRE020".$usuario_sia; 
$asig_global="N";
if ($mes==01){$mesd="Enero";}elseif ($mes==02){$mesd="Febrero";}elseif ($mes=03){$mesd="Marzo";}elseif ($mes==04){$mesd="Abril";}elseif ($mes==05){$mesd="Mayo";}elseif ($mes==06){$mesd="Junio";}elseif ($mes==07){$mesd="Julio";}elseif ($mes==08){$mesd="Agosto";}elseif ($mes==09){$mesd="Septiembre";}elseif ($mes==10){$mesd="Octubre";}elseif ($mes==11){$mesd="Noviembre";}elseif ($mes_desde==12){$mesd="Diciembre";}
//print_r($cod_presup_d);print_r($cod_presup_h);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  
  $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];} 
  $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;

  $criterio="(cod_presup>='$cod_presup_d' and cod_presup<='$cod_presup_h') and (cod_fuente>='$cod_fuente_d' and cod_fuente<='$cod_fuente_h')";
  $per_hasta=$mes;
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
   
   $StrSQL = "DELETE FROM PRE020 Where (Tipo_Registro='1') And (Nombre_Usuario='".$cod_mov."')";
   $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } 
 if($asig_global=="S"){$sql_Asignacion="Asignado,";}
  
  $StrSQL= "INSERT INTO PRE020 SELECT '".$cod_mov."' as Nombre_Usuario,'1' as Tipo_Registro, Cod_Presup, Cod_Fuente, Denominacion,substr(cod_presup,1,".$c.") as cod_categoria,"."'' as Denomina_cat,substr(cod_presup,".$ini.",".$p.") as cod_partida,'' as Denomina_Par,Status_Dist,Func_Inv,Ord_Cord,Aplicacion,Cod_Unidad_Ejec, ";
  $StrSQL=$StrSQL.$sql_Asignacion." Disponible,Disp_Diferida,".$sql_Compromiso.$sql_Causado.$sql_Pagado.$sql_Traslados.$sql_Trasladon.$sql_Adicion.$sql_Disminucion.$sql_Diferido.", "."0 as CompromisoM,0 as CausadoM, 0 as PagadoM, 0 as TrasladosM, 0 as TrasladonM, 0 as AdicionM, 0 as DisminucionM, 0 as DiferidoM ";
  $StrSQL=$StrSQL." FROM PRE001 WHERE length(Cod_Presup)=".$l_c." and ".$criterio;
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
//print_r($StrSQL);
  
        $sSQL = "SELECT PRE020.Cod_Presup, PRE020.Denominacion, PRE020.Asignado, PRE020.Traslados, PRE020.Trasladon, PRE020.Adicion, PRE020.Disminucion, PRE020.Compromiso, PRE020.Causado, 			 PRE020.Pagado, PRE020.Disponible, PRE020.TrasladosM, PRE020.TrasladonM, PRE020.AdicionM, PRE020.DisminucionM, PRE020.CompromisoM, PRE020.CausadoM, PRE020.PagadoM,
		(PRE020.Traslados-PRE020.Trasladon+PRE020.Adicion-PRE020.Disminucion) AS Modificaciones,
		(PRE020.Asignado+PRE020.Traslados-PRE020.Trasladon+PRE020.Adicion-PRE020.Disminucion) AS Asig_Actualizada, 
		(PRE020.Asignado+PRE020.Traslados-PRE020.Trasladon+PRE020.Adicion-PRE020.Disminucion-PRE020.Compromiso) AS Disponibilidad
		 FROM PRE020
		Where ".$criterio."";
        $oRpt = new PHPReportMaker();
        $oRpt->setXML("Rpt_estado_mensual_ejecucion_finc_gasto.xml");
        $oRpt->setUser("$user");
        $oRpt->setPassword("$password");
        $oRpt->setConnection("localhost");
        $oRpt->setDatabaseInterface("postgresql");
        $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
        $oRpt->setSQL($sSQL);
        $oRpt->setDatabase("$dbname");
        $oRpt->run();

?>
