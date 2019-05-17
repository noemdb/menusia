<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$tipo_cuenta=$_POST["txttipo_cuenta"]; $des_tipo_cuenta=$_POST["txtdescripcion_tipo"]; $conciliable=$_POST["txtconciliable"];  $conciliable=substr($conciliable,0,1);
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR INCLUYENDO....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  $sSQL="Select * from ban001 WHERE tipo_cuenta='$tipo_cuenta'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas>0){ $error=1; ?>  <script language="JavaScript">  muestra('TIPO DE CUENTA YA EXISTE');  </script> <? }
   else{$error=0;  if($error==0){$sSQL="SELECT ACTUALIZA_BAN001(1,'$tipo_cuenta','$des_tipo_cuenta','$conciliable')";  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);$error=substr($error, 0, 61);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}}
  }
}
pg_close();
error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location='Act_Tipos_Cuentas.php?Gtipo_cuenta=U';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>