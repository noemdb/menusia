<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");
$cod_empleado=$_POST["txtcod_empleado"]; $grupo=$_POST["txtgrupo"]; echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$error=0; $sSQL="Select * from NOM006 WHERE  cod_empleado='$cod_empleado'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><? }
   else{ $registro=pg_fetch_array($resultado,0);  $tipo_nomina=$registro["tipo_nomina"]; $cod_categoria=$registro["cod_categoria"];  $fecha_ing=$registro["fecha_ingreso"];      $calculo_grupos=$registro["calculo_grupos"];
      $sSQL="SELECT ASIGNA_CONCEPTO_EMPLEADO('$cod_empleado','$tipo_nomina','$fecha_ing','$cod_categoria','$grupo','$minf_usuario')";   echo $sSQL;
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ACTUALIZANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ASIGNO EXITOSAMENTE'); </script><?
	    $sSQL="Update nom006 set calculo_grupos='$grupo' WHERE  cod_empleado='$cod_empleado'"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
	  }
  }
}
pg_close();  if($error==0){?><script language="JavaScript">window.close(); window.opener.location.reload(); </script> <?}else{?><script language="JavaScript">history.back();</script><?}?>