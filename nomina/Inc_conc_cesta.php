<?include ("../class/conect.php");  include ("../class/funciones.php");
$codigo_mov=$_GET["codigo_mov"]; $url="Det_conc_nom_ext.php?codigo_mov=".$codigo_mov;
$equipo = getenv("COMPUTERNAME"); $MInf_Usuario=$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$sSQL="Select * from NOM071 WHERE codigo_mov='$codigo_mov'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO EXISTE');</script><? }
  else{$registro=pg_fetch_array($resultado,0);   $tipo_nomina=$registro["cod_empleado"]; }
  if($error==0){$sSQL="Select * from NOM002 WHERE tipo_nomina='$tipo_nomina' and tipo_asigna='T'"; $res=pg_query($sSQL);  $filas=pg_num_rows($res);
    while($registro=pg_fetch_array($res)) {$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];
      $cod_partida=$registro["cod_partida"]; $cod_cat_alter=$registro["cod_cat_alter"]; $asignacion=$registro["asignacion"]; $tipo_a=$registro["tipo_asigna"]; $frec=$registro["frecuencia"];
      $asig_ded_apo=$registro["asig_ded_apo"]; $activo=$registro["activo"]; $inicializable=$registro["inicializable"]; $inicializable_c=$registro["inicializable_c"];  $cod_aporte=$registro["cod_aporte"];
      $oculto=$registro["oculto"]; $acumula=$registro["acumula"]; $tipo_grupo=$registro["tipo_grupo"]; $afecta_presup=$registro["afecta_presup"]; $cod_retencion=$registro["cod_retencion"];
      $grupo_retencion=$registro["grupo_retencion"]; $prestamo=$registro["prestamo"]; $status=$registro["status"]; $cod_orden=$registro["cod_orden"]; 
	  $sSQLg="SELECT ACTUALIZA_NOM066(1,'$codigo_mov','$cod_concepto','$denominacion','$cod_partida','$cod_cat_alter','','$asignacion','$tipo_a','$asig_ded_apo','$activo','$inicializable','$inicializable_c','$oculto','$acumula','$tipo_grupo','$frec','$afecta_presup','$cod_retencion','$grupo_retencion','$prestamo','$status','$cod_orden','$cod_aporte')";
      $resg=pg_exec($conn,$sSQLg); $error=pg_errormessage($conn);
	}
  }
}  pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>