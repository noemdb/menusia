<?include ("../class/conect.php"); include ("../class/funciones.php");
error_reporting(E_ALL); $codigo_mov=$_GET["codigo_mov"]; $nro_fact=$_GET["nro_fact"]; $selec=$_GET["selec"];
$url="Det_inc_facret_orden.php?codigo_mov=".$codigo_mov; echo "SELECCIONANDO FACTURA....","<br>"; $error=0;
if ($selec=="S") { $selec="N"; } else { $selec="S"; } echo $selec;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$resultado=pg_exec($conn,"SELECT SELECCIONA_PAG039('$codigo_mov','$nro_fact','$selec')");
  $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript">  document.location ='<? echo $url; ?>' </script>