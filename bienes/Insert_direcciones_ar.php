<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_dependen=$_POST["txtcod_dependen"]; $cod_direccion=$_POST["txtcod_direccion"];$denominacion_dir=$_POST["txtdenominacion_dir"]; $direccion_dir=$_POST["txtdireccion_dir"];$nombre_contacto_r=$_POST["txtnombre_contacto_r"];$observacion_dir=$_POST["txtobservacion_dir"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $url="Det_direcciones.php?cod_dependen=".$cod_dependen;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN005 WHERE cod_direccion='$cod_direccion' and cod_dependencia='$cod_dependen'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('EL CODIGO DIRECCION YA EXISTE'); </script> <? }
  if($error==0){$sql="SELECT cod_dependencia,denominacion_dep  FROM bien001 where cod_dependencia='$cod_dependen'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
     if($filas==0){$error=1; echo $cod_dependen; ?> <script language="JavaScript"> muestra('CODIGO DEPENDENCIA NO EXISTE');</script><? }
  }
  if($error==0){$sSQL="SELECT ACTUALIZA_BIEN005(1,'$cod_dependen','$cod_direccion','$denominacion_dir','$direccion_dir','$nombre_contacto_r','$observacion_dir','$minf_usuario')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}
  }
}pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>

