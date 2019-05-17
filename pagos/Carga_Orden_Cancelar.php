<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL); $codigo_mov=$_GET["codigo_mov"];
$tipo_ret_d="001"; $tipo_ret_h="999"; if (isset($_GET['tipo_ret_d'])) { $tipo_ret_d=$_GET["tipo_ret_d"];}  if (isset($_GET['tipo_ret_h'])) { $tipo_ret_h=$_GET["tipo_ret_h"];} 
$url="Det_inc_opret_orden.php?codigo_mov=".$codigo_mov."&tipo_ret_d=".$tipo_ret_d."&tipo_ret_h=".$tipo_ret_h;  echo "CARGANDO ORDENES....","<br>"; $error=0; $ced_rif="";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from PAG036 WHERE codigo_mov='$codigo_mov'";    $resultado=pg_exec($conn,$sSQL);   $filas=pg_numrows($resultado);   
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CEDULA RIF NO VALIDO');</script> <? }
   else{ $registro=pg_fetch_array($resultado); $ced_rif=$registro["ced_rif"];  $tipo_ret_d=$registro["tipo_causado"];  $tipo_ret_h=$registro["cod_contable_o"];  echo $ced_rif;
     $sqlg="SELECT CARGAR_PAG038_TIPO('$codigo_mov','$ced_rif','$tipo_ret_d','$tipo_ret_h')"; ECHO $sqlg;
	  $resultado=pg_exec($conn,$sqlg);  $error=pg_errormessage($conn); $error=substr($error, 0, 91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
    }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript">  document.location ='<? echo $url; ?>' </script>