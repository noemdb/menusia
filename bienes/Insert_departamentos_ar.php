<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_dependen=$_POST["txtcod_dependen"]; $cod_direcci=$_POST["txtcod_direcci"];$cod_departamento=$_POST["txtcod_departamento"];$denominacion_dep=$_POST["txtdenominacion_dep"]; $direccion_dep=$_POST["txtdireccion_dep"];$nombre_contacto_d=$_POST["txtnombre_contacto_d"];$observacion_dep=$_POST["txtobservacion_dep"]; 
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Det_departamentos.php?cod_dependen=$cod_dependen&cod_direcci=$cod_direcci";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN006 WHERE cod_departamento='$cod_departamento' and cod_dependencia='$cod_dependen' and cod_direccion='$cod_direcci'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEPARTAMENTO YA EXISTE'); </script> <? }
  if($error==0){$sql="SELECT cod_dependencia,denominacion_dep  FROM bien001 where cod_dependencia='$cod_dependen'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
     if($filas==0){$error=1; echo $cod_dependen."dep"; ?> <script language="JavaScript"> muestra('CODIGO DEPENDENCIA NO EXISTE');</script><? }
  }
  if($error==0){$sql="SELECT cod_direccion,denominacion_dir FROM bien005 where cod_dependencia='$cod_dependen' and cod_direccion='$cod_direcci'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
     if($filas==0){$error=1; echo $cod_direcci; ?> <script language="JavaScript"> muestra('CODIGO DIRECCION NO EXISTE');</script><? }
  }
  if($error==0){$sSQL="SELECT ACTUALIZA_BIEN006(1,'$cod_dependen','$cod_direcci','$cod_departamento','$denominacion_dep','$direccion_dep','$nombre_contacto_d','$observacion_dep','$minf_usuario')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}
  }
}pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>

