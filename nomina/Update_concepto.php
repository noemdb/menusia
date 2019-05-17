<?include ("../class/conect.php");  include ("../class/funciones.php"); $frecuencia="1";
$tipo_nomina=$_POST["txttipo_nomina"]; $cod_concepto=$_POST["txtcod_concepto"]; $denominacion=$_POST["txtdenominacion"]; $cod_partida=$_POST["txtcod_partida"];
$cod_cat_alter=$_POST["txtcod_cat_alter"]; $tipo_concepto=$_POST["txttipo_concepto"]; $tipo_asigna=$_POST["txttipo_asigna"]; $fuente=$_POST["txtfuente"];
$afecta_presup=$_POST["txtafecta_presup"]; $cod_retencion=$_POST["txtcod_retencion"]; $activo=$_POST["txtactivo"]; $oculto=$_POST["txtoculto"];
$inicializable=$_POST["txtinicializable"]; $inicializable_c=$_POST["txtinicializable_c"]; $acumula=$_POST["txtacumula"];  $cal_vac=$_POST["txtcal_vac"];
$tipo_grupo=$_POST["txttipo_grupo"]; $frec=$_POST["txtfrecuencia"]; $prestamo=$_POST["txtprestamo"]; $cod_orden=$_POST["txtcod_orden"];  $cod_aporte=$_POST["txtcod_aporte"];
if($frec=="PRIMERA QUINCENA"){$frecuencia="1";} if($frec=="SEGUNDA QUINCENA"){$frecuencia="2";} if($frec=="PRIMERA Y SEGUNDA QUINCENA"){$frecuencia="3";}
if($frec=="PRIMERA SEMANA"){$frecuencia="4";} if($frec=="SEGUNDA SEMANA"){$frecuencia="5";} if($frec=="TERCERA SEMANA"){$frecuencia="6";}
if($frec=="CUARTA SEMANA"){$frecuencia="7";} if($frec=="QUINTA SEMANA"){$frecuencia="8";} if($frec=="TODAS LAS SEMANAS"){$frecuencia="9";} if($frec=="ULTIMA SEMANA"){$frecuencia="0";}
$tipo_c="D"; $asignacion="NO";  if($tipo_concepto=="ASIGNACION"){$tipo_c="A";$asignacion="SI"; } if($tipo_concepto=="DEDUCCION"){$tipo_c="D";}else{$cod_aporte="000";} if($tipo_concepto=="APORTE"){$tipo_c="P";}
$prestamo=substr($prestamo,0,1); $asig_ded_apo=substr($tipo_c,0,1);   $fecha_hoy=asigna_fecha_hoy(); $status=substr($cal_vac,0,1);
IF($tipo_asigna=="CESTATICKET"){$tipo_asigna="T";}ELSE{$tipo_asigna=substr($tipo_asigna,0,1); }
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$url="Act_concep_ar.php?Gcodigo=C".$tipo_nomina.$cod_concepto;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select * from NOM002 WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
   if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CONCEPTO NO EXISTE');</script><? }
   else{ $registro=pg_fetch_array($resultado); $adescrip=$registro["denominacion"];  $mact=$registro["activo"]; $mini=$registro["inicializable"]; $minic=$registro["inicializable_c"]; $mocul=$registro["oculto"]; $mpres=$registro["prestamo"];  $mcod_par=$registro["cod_partida"]; $sfecha=formato_aaaammdd($fecha_hoy); }
   if($error==0){ if ($gnomina=="00"){$error=0;} else {  if($tipo_nomina<>$gnomina) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO ACTIVA PARA EL USUARIO');</script><?}  } } 
   if($error==0){ $sSQL="SELECT ACTUALIZA_NOM002(2,'$tipo_nomina','$cod_concepto','$denominacion','$cod_partida','$cod_cat_alter','$fuente','$asignacion','$tipo_asigna','$asig_ded_apo','$activo','$inicializable','$inicializable_c','$oculto','$acumula','$tipo_grupo','$frecuencia','$afecta_presup','$cod_retencion','00','$prestamo','$status','$cod_orden','$cod_aporte','$minf_usuario')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?
    $desc_doc="CONCEPTO, TIPO NOMINA:".$tipo_nomina.", CODIGO CONCEPTO:".$cod_concepto.", DENOMINACION:".$adescrip.", ACTIVO:".$mact.", COD.PARTIDA:".$mcod_par.", MONTO INICIALIZABLE:".$mini.", CANTIDAD INICIALIZABLE:".$minic.", OCULTO:".$mocul.", PRESTAMO:".$mpres; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
      $error=pg_errormessage($conn); $error=substr($error,0,91);  if(!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><?}}
  }
}
pg_close();if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>