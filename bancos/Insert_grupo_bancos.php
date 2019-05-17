<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);$cod_grupob=$_POST["txtcodigo_grupo"]; $nombre_grupob=$_POST["txtdenominacion"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  $sSQL="Select * from ban022 WHERE cod_grupob='$cod_grupob'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas>0){ $error=1; ?>  <script language="JavaScript">  muestra('GRUPO DE BANCO YA EXISTE');  </script> <? }
   else{$error=0;  if($error==0){$sSQL="SELECT ACTUALIZA_BAN022(1,'$cod_grupob','$nombre_grupob')";  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);$error=substr($error, 0, 61);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}}
  }
}
pg_close();error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location='Act_Grupo_Bancos.php';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>


