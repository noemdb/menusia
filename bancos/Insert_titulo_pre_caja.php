<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL); $codigo_titulo=$_POST["txtcodigo_titulo"]; $denominacion=$_POST["txtdenominacion_titulo"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  $sSQL="Select * from ban018 WHERE codigo_titulo='$codigo_titulo'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas>0){ $error=1; ?>  <script language="JavaScript">  muestra('CODIGO DE TITULO YA EXISTE');  </script> <? }
   else{$error=0;  if($error==0){$sSQL="SELECT ACTUALIZA_ban018(1,'$codigo_titulo','$denominacion')";  echo $sSQL,"<br>";  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);$error=substr($error, 0, 61);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}}
  }
}
pg_close();error_reporting(E_ALL ^ E_WARNING); if ($error==0){?><script language="JavaScript">document.location='Act_Titulo_Pre_Caja.php';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>
