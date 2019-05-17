<?include ("../class/conect.php");  include ("../class/funciones.php");  error_reporting(E_ALL);
$nro_planilla=$_GET["nro_planilla"];$tipo_planilla=$_GET["planilla"]; $pdesde=$_GET["pdesde"]; $phasta=$_GET["phasta"]; $fdesde=$_GET["fdesde"]; $fhasta=$_GET["fhasta"];
$cod_ret=$_GET["cod_ret"]; $nro_deposito=$_GET["deposito"]; $nom_banco=$_GET["banco"]; $fecha_ent=$_GET["fechae"];
$equipo = getenv("COMPUTERNAME");$MInf_Usuario=$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0;
$url="Det_ent_planillas.php?tipo_planilla=".$tipo_planilla."&plan_desde=".$pdesde."&plan_hasta=".$phasta."&fecha_desde=".$fdesde."&fecha_hasta=".$fhasta;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ if (checkData($fecha_ent)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA ENTERAR NO ES VALIDA');</script><? }
  if($error==0){ $sfechaf=formato_aaaammdd($fecha_ent); 
    $sSQL="SELECT * FROM BAN013 WHERE tipo_planilla='$tipo_planilla' and nro_planilla='$nro_planilla'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
    if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('NUMERO PLANILLA DE RETENCION NO ENTERADA');</script><? }
    else{ $sSQL="SELECT ACTUALIZA_BAN013(2,'$tipo_planilla','$nro_planilla','$cod_ret','$sfechaf','$nom_banco','$nro_deposito','','')";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);  $error=substr($error, 0, 61); if(!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script><? }}}
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>