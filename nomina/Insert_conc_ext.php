<?include ("../class/conect.php");  include ("../class/funciones.php");
$codigo_mov=$_POST["txtcodigo_mov"]; $cod_concepto=$_POST["txtcod_concepto"];  $url="Det_conc_nom_ext.php?codigo_mov=".$codigo_mov;
$equipo = getenv("COMPUTERNAME"); $MInf_Usuario=$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$sSQL="Select * from NOM071 WHERE codigo_mov='$codigo_mov'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO EXISTE');</script><? }
  else{$registro=pg_fetch_array($resultado,0);   $tipo_nomina=$registro["cod_empleado"]; }
  if($error==0){$sSQL="Select * from NOM002 WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
   if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CONCEPTO NO EXISTE');</script><? }
   else{$registro=pg_fetch_array($resultado,0); $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];
    $cod_partida=$registro["cod_partida"]; $cod_cat_alter=$registro["cod_cat_alter"]; $asignacion=$registro["asignacion"]; $tipo_a=$registro["tipo_asigna"]; $frec=$registro["frecuencia"];
    $asig_ded_apo=$registro["asig_ded_apo"]; $activo=$registro["activo"]; $inicializable=$registro["inicializable"]; $inicializable_c=$registro["inicializable_c"];  $cod_aporte=$registro["cod_aporte"];
    $oculto=$registro["oculto"]; $acumula=$registro["acumula"]; $tipo_grupo=$registro["tipo_grupo"]; $afecta_presup=$registro["afecta_presup"]; $cod_retencion=$registro["cod_retencion"];
    $grupo_retencion=$registro["grupo_retencion"]; $prestamo=$registro["prestamo"]; $status=$registro["status"]; $cod_orden=$registro["cod_orden"];}  }
 if($error==0){ $sSQL="Select * from NOM066 WHERE codigo_mov='$codigo_mov' and cod_concepto='$cod_concepto'";
  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CONCEPTO YA EXISTE EN EL CALCULO');</script><? }
   else{$sSQL="SELECT ACTUALIZA_NOM066(1,'$codigo_mov','$cod_concepto','$denominacion','$cod_partida','$cod_cat_alter','','$asignacion','$tipo_a','$asig_ded_apo','$activo','$inicializable','$inicializable_c','$oculto','$acumula','$tipo_grupo','$frec','$afecta_presup','$cod_retencion','$grupo_retencion','$prestamo','$status','$cod_orden','$cod_aporte')";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }}}
}  echo $sSQL;pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>


