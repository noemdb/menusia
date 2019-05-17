<?include ("../class/conect.php");  include ("../class/funciones.php");
$tipo_nomina=$_POST["txttipo_nomina"]; $cod_concepto=$_POST["txtcod_concepto"]; $criterio=$_POST["txtcriterio"];  $opcion=$_POST["txtopcion"]; $filtro=$_POST["txtfiltro"];
if($opcion=="QUITAR FILTRO"){$tipof="0";} if($opcion=="TRABAJADOR"){$tipof="1".$filtro;} if($opcion=="CARGO"){$tipof="2".$filtro;} if($opcion=="DEPARTAMENTO"){$tipof="3".$filtro;}  if($opcion=="TIPO DE PERSONAL"){$tipof="4".$filtro;}
$criterio=$tipo_nomina.$cod_concepto.$tipof; $url="Det_carga_manual.php?criterio=".$criterio;?> <script language="JavaScript">document.location='<? echo $url; ?>';</script>
