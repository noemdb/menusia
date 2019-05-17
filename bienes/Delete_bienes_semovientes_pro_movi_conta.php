<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$referencia=$_GET["Greferencia"];
print_r($referencia);
$fecha=$_GET["Gfecha"];
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
print_r($fecha);
$equipo = getenv("COMPUTERNAME");
$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{
  $sSQL="Select * from bien026 WHERE referencia='$referencia' and fecha='$fecha'";
  $resultado=pg_exec($conn,$sSQL);
  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DEL ACTA DE DESINCORPORACION NO EXISTE');</script><?}
   else{
     $registro=pg_fetch_array($resultado);
     $sql="Select * from bien042 WHERE referencia='$referencia' and fecha='$fecha'";
     $res=pg_query($sql);
     $total=0;$desc_cod="";
     while($registro=pg_fetch_array($res)){
       $total=$total+$registro["monto"];
     }
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DEL ACTA DE DESINCORPORACION NO EXISTE');</script><?}
   else{
     $registro=pg_fetch_array($resultado);
     $sql="Select * from con003 WHERE referencia='$referencia'";
     $res=pg_query($sql);
     }
     $sfecha=formato_aaaammdd($fecha);
     $resultado=pg_exec($conn,"SELECT actualiza_bien026(2,'','$referencia','$sfecha','','','','','$sfecha','S','','',0.00,'','')");
$error=pg_errormessage($conn);  $error=substr($error,0,91);
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><? $error=0; }
  }
}
pg_close(); if ($error==0){?><script language="JavaScript"> window.close();window.opener.location.reload(); </script> <? }?>
