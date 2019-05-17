<? include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$criterio=$_GET["Gcriterio"]; $nro_orden=substr($criterio,0,8);  $tipo_causado=substr($criterio,8,4); $codigo_mov=$_GET["codigo_mov"];
$clave=$nro_orden.$tipo_causado;
$sql="SELECT * From ORD_PAGO Where (text(nro_orden)||text(tipo_causado)<'$clave') Order by text(nro_orden)||text(tipo_causado) desc";
$res=pg_query($sql); $filas=pg_num_rows($res); echo $sql.' '.$filas,"<br>";
if($filas>0){$registro=pg_fetch_array($res);  $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"]; }
$url="Modifica_ord_pago.php?codigo_mov=".$codigo_mov."&txtnro_orden=".$nro_orden."&txttipo_causado=".$tipo_causado;
// echo $url,"<br>";
pg_close();
?><script language="JavaScript">document.location='<? echo $url; ?>'</script> <?