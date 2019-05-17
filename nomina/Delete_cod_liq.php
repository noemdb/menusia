<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL); $equipo = getenv("COMPUTERNAME"); $mcod_m="LIQ".$usuario_sia.$equipo; $fecha=asigna_fecha_hoy();
if (!$_GET){$codigo_mov=substr($mcod_m,0,49);$cod_concepto=""; $fecha_hasta=""; } else{$codigo_mov=$_GET["codigo_mov"]; $cod_concepto=$_GET["cod_concepto"]; $fecha_hasta=$_GET["fecha_hasta"]; } 
$url="Det_inc_cal_liq.php?codigo_mov=".$codigo_mov; echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$error=0; $sfecha=formato_aaaammdd($fecha);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $error=0;
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$sSQL="Select cod_concepto from nom076 WHERE codigo_mov='$codigo_mov' and cod_concepto='$cod_concepto' ";  $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONCEPTO NO EXISTE EN LA LIQUIDACION');</script><? }
   else{ $den_concepto=""; $cod_presup=""; $cod_contable=""; $afecta_presup=""; $cod_retencion=""; $asignacion="SI"; $asig_ded_apo="A"; $cantidad=0;  $cantidad=0; $costo=0;  $total=0; 
     $sSQL="SELECT ACTUALIZA_NOM076(3,'$codigo_mov','$cod_concepto','$den_concepto','NO','$asignacion','NO','NO','O','$asig_ded_apo','0','N','N','N',0,0,0,0,0,0,0,0,0,0,$cantidad,$total,$costo,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$sfecha','$sfecha','$fecha_hasta',1,'000')";  $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); 
	 $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;} echo $sSQL;
   }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>