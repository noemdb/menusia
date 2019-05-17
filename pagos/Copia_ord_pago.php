<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$nro_orden=$_GET["txtnro_orden"];$tipo_causado=$_GET["txttipo_causado"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR COPIANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sql="Select * from PAG001 where nro_orden='$nro_orden' and tipo_causado='$tipo_causado'";  $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('NUMERO DE ORDEN NO EXISTE');</script><?}
   else { $reg=pg_fetch_array($resultado);  $fecha_causado=$reg["fecha"]; $adescripcion=$reg["concepto"];  $status=$reg["status"]; $retencion=$reg["retencion"]; $total_ajuste=$reg["total_ajuste"];
     $cod_busca="PAG001".$usuario_sia;  $sfecha=$fecha_causado;   
	 
	 $resultado=pg_exec($conn,"SELECT COPIA_PAG001('$cod_busca','$nro_orden','$tipo_causado')"); $error=pg_errormessage($conn);$error=substr($error, 0, 61);
     if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      else{?><script language="JavaScript">muestra('COPIO EXITOSAMENTE');</script><?}
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript"> window.close(); window.opener.location.reload(); </script>

