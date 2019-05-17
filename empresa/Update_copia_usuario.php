<?include ("../class/conect.php"); include ("../class/funciones.php"); $login=$_POST["txtLogin"]; $clave="";
$nombre=$_POST["txtNombre"];$loginf=$_POST["txtLogin_fuente"]; $error=0;
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{$sSQL="Select * from SIA001 WHERE campo101='$login'";   $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?> <script language="JavaScript"> muestra('USUARIO NO EXISTE'); </script>  <? }
  $sSQL="Select * from SIA001 WHERE campo101='$loginf'";   $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?> <script language="JavaScript"> muestra('USUARIO FUENTE NO EXISTE'); </script>  <? }  
   if($error==0){ 
      $sql="delete from sia006 where campo601='$login'";     $resultado=pg_exec($conn,$sql);       
      $sql="INSERT into sia006 select '".$login."',campo602,campo603,campo605,campo606,campo607,campo608,campo609,campo610,campo611,campo612,campo613,campo614,campo615,campo616,campo617,campo618,campo619,campo620,campo621,campo622,campo623,campo624,campo625,campo626 from sia006 where campo601='$loginf'";
      $resultado=pg_exec($conn,$sql); echo $sql;
      $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
      else{?><script language="JavaScript">muestra('COPIO EXITOSAMENTE');</script><? }
    }
}
pg_close();?>
<script language="JavaScript">history.back();</script>