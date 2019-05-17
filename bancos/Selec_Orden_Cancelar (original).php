<?include ("../class/conect.php");  include ("../class/funciones.php");
error_reporting(E_ALL); $codigo_mov=$_GET["codigo_mov"]; $ced_rif=$_GET["ced_rif"]; $nro_orden=$_GET["nro_orden"]; $tipo_causado=$_GET["tipo"]; $selec=$_GET["selec"]; $orden=$_GET["orden"]; $multiple=$_GET["multiple"];  $mostrar=$_GET["mostrar"];
$url="Det_ordenes_canc.php?codigo_mov=".$codigo_mov."&orden=".$orden."&mostrar=".$mostrar;  $error=0; if ($selec=="S") { $selec="N"; } else { $selec="S"; }
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname.""); $error=0;

if($multiple=="S"){$StrSQL="select ced_rif from pag027 where seleccionada='S' and codigo_mov='$codigo_mov'";  $c_rif=$ced_rif;
$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado); $c_rif=$registro["ced_rif"];}
if($c_rif!=$ced_rif){$error=1; ?> <script language="JavaScript">  muestra('Benficiario debe ser el Mismo'); </script> <?}  }

if($error==0){$resultado=pg_exec($conn,"SELECT SELECCIONA_PAG027('$codigo_mov','$nro_orden','$tipo_causado','$selec')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <?}}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript">  document.location ='<? echo $url; ?>' </script>