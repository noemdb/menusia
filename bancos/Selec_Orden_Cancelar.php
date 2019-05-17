<?include ("../class/conect.php");  include ("../class/funciones.php"); $tfechac=asigna_fecha_hoy(); $tfechac=formato_aaaammdd($tfechac);
error_reporting(E_ALL); $codigo_mov=$_GET["codigo_mov"]; $ced_rif=$_GET["ced_rif"]; $nro_orden=$_GET["nro_orden"]; $tipo_causado=$_GET["tipo"]; $selec=$_GET["selec"]; $orden=$_GET["orden"]; $tipo_ret=$_GET["tipo_ret"]; $multiple=$_GET["multiple"];  $mostrar=$_GET["mostrar"]; $fechac=$_GET["fechac"];
$url="Det_ordenes_canc.php?codigo_mov=".$codigo_mov."&orden=".$orden."&mostrar=".$mostrar;  $error=0; if ($selec=="S") { $selec="N"; } else { $selec="S"; }
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $error=0;
$StrSQL="select * from ban030 where codigo_mov='$codigo_mov'"; $res=pg_query($StrSQL);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); $multiple=$registro["status_1"]; $fechac=$registro["fecha"]; }
$StrSQL="select ced_rif,fecha from pag027 where nro_orden='$nro_orden' and codigo_mov='$codigo_mov'";  $c_rif=$ced_rif; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas==0){$error=1; ?> <script language="JavaScript">  muestra('Error Localizando Orden'); </script> <?}
else{$registro=pg_fetch_array($resultado); $c_rif=$registro["ced_rif"];  $fecha_e=$registro["fecha"];}
if($multiple=="S"){if($c_rif!=$ced_rif){$error=1; ?> <script language="JavaScript">  muestra('Benficiario debe ser el Mismo'); </script> <?}  }
if($error==0){ if($fechac==""){$fechac=$tfechac;} $fecha1=formato_ddmmaaaa($fechac); $fecha2=formato_ddmmaaaa($fecha_e);
  $num1=FDate($fecha1)*1; $num2=FDate($fecha2)*1;
  if($num1<$num2){ echo "Fecha Orden: ".$fecha2.", Fecha Cheque: ".$fecha1." ".$num1." ".$num2,"<br>"; $error=1; ?> <script language="JavaScript">  muestra('Fecha Cheque menor a Fecha Orden'); </script> <? }
}
if($error==0){
//$resultado=pg_exec($conn,"SELECT SELECCIONA_PAG027('$codigo_mov','$nro_orden','$tipo_causado','$selec')"); 
$resultado=pg_exec($conn,"SELECT SELECRET_PAG027('$codigo_mov','$nro_orden','$tipo_causado','$tipo_ret','$selec')"); echo "SELECT SELECRET_PAG027('$codigo_mov','$nro_orden','$tipo_causado','$tipo_ret','$selec')";
$error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <?}}
pg_close(); 
error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript">  document.location ='<? echo $url; ?>' </script>