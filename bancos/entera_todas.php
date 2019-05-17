<?include ("../class/conect.php");  include ("../class/funciones.php");   error_reporting(E_ALL);
$tipo_planilla=$_GET["planilla"]; $pdesde=$_GET["pdesde"]; $phasta=$_GET["phasta"]; $fdesde=$_GET["fdesde"]; $fhasta=$_GET["fhasta"];
$cod_retencion=$_GET["cod_ret"]; $nro_deposito=$_GET["deposito"]; $nombre_banco_ent=$_GET["banco"]; $fecha_enterado=$_GET["fechae"]; $fecha_ent=formato_aaaammdd($fecha_enterado);
$equipo=getenv("COMPUTERNAME");$MInf_Usuario=$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR REGISTRANDO TODAS....","<br>";
$url="Det_ent_planillas.php?tipo_planilla=".$tipo_planilla."&plan_desde=".$pdesde."&plan_hasta=".$phasta."&fecha_desde=".$fdesde."&fecha_hasta=".$fhasta;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $error=0;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$sql="select * FROM ban012 where tipo_planilla='$tipo_planilla' and nro_planilla>='$pdesde' and nro_planilla<='$phasta' and fecha_emision>='$fdesde' and fecha_emision<='$fhasta' and nro_planilla not in (select nro_planilla from ban013 where tipo_planilla='$tipo_planilla')"; echo $sql; $res=pg_query($sql);
  while($registro=pg_fetch_array($res)){  $nro_planilla=$registro["nro_planilla"];  $sfechaf=formato_aaaammdd($fecha_enterado);
    $sSQL="SELECT ACTUALIZA_BAN013(1,'$tipo_planilla','$nro_planilla','$cod_retencion','$sfechaf','$nombre_banco_ent','$nro_deposito','','')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error,0,91);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}
  }
}pg_close(); error_reporting(E_ALL ^ E_WARNING); ?> <script language="JavaScript"> document.location ='<? echo $url; ?>';</script>