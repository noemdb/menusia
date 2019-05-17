<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_dependencia=$_GET["Gcod_dependencia"];  $equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="SELECT * From BIEN001 where cod_dependencia='$cod_dependencia'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE LA DEPENDENCIA NO EXISTE');</script> <? }
  if ($error==0){  $sSQL="SELECT * From bien005 where cod_dependencia='$cod_dependencia'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE LA DEPENDENCIA TIENE DIRECCIONES ASOCIADAS');</script> <? }	  
  }	  
  if ($error==0){  $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN001(3,'$cod_dependencia','','','','','','','','','','','','','',0,'','','','',0,0,'')"); 
     $merror=pg_errormessage($conn);  $merror=substr($merror,0,91);
     if (!$resultado){$error=1; ?> <script language="JavaScript"> muestra('<? echo $merror; ?>'); </script> <? }else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><? $error=0; }
  }
}
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>

