<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$cod_documento=$_POST["txtcod_documento"];$tipo_documento=$_POST["txttipo_documento"];$equipo = getenv("COMPUTERNAME");
$minf_usuario = $equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  $sSQL="Select * from PAG017 WHERE cod_documento='$cod_documento'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if ($filas>0){ $error=1; ?>  <script language="JavaScript">  muestra('TIPO DE DOCUMENTO YA EXISTE');  </script> <? }
   else{ $error=0;
     if($error==0){$sSQL="SELECT ACTUALIZA_PAG017(1,'$cod_documento','$tipo_documento')";$resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);$error=substr($error,0,91);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}}
  }
}
pg_close();
error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location ='Act_tipo_documento.php?';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>