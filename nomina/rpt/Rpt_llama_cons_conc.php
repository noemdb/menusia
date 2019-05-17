<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"];  $cod_concepto_d=$_GET["cod_concepto_d"]; $cod_concepto_h=$_GET["cod_concepto_h"];   
   $forma_pago=$_GET["forma_pago"]; $tipo_calculo=$_GET["tipo_calculo"];   $cod_empleado_d=$_GET["cod_empleado_d"]; $cod_empleado_h=$_GET["cod_empleado_h"];   
   $cod_presup_catd=$_GET["cod_presup_catd"];  $cod_presup_cath=$_GET["cod_presup_cath"];  $codigo_cargo_d=$_GET["codigo_cargo_d"];  $codigo_cargo_h=$_GET["codigo_cargo_h"]; 
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $tipo_personal_d=$_GET["tipo_personal_d"];   $tipo_personal_h=$_GET["tipo_personal_h"]; $fecha_desde=$_GET["fecha_desde"];    $fecha_hasta=$_GET["fecha_hasta"];    
   $codigo_rpt=$_GET["codigo_rpt"];  $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_concepto=$_GET["tipo_concepto"]; $num_periodos=$_GET["num_periodos"]; $Sql="";$date = date("d-m-Y"); $hora = date("h:i:s a");    
   
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";} $error=0;
  $cod_reporte=""; $des_repote=""; $den_arch_rpt="";
  $StrSQL="select * from nom047 where cod_reporte='$codigo_rpt'"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
  if($filas>0){$registro=pg_fetch_array($resultado); 
  $cod_reporte=$registro["cod_reporte"]; $des_repote=$registro["des_repote"]; $den_arch_rpt=$registro["den_arch_rpt"]; }
  else{ $error=1; echo "Codigo: ".$codigo_rpt; ?> <script language="JavaScript">muestra('CODIGO REPORTES NO LOCALIZADO');</script><? }  
  
  
  $url=$den_arch_rpt."?&tipo_nomina_d=".$tipo_nomina_d."&tipo_nomina_h=".$tipo_nomina_h. "&cod_conceptod=".$cod_concepto_d."&cod_conceptoh=".$cod_concepto_h.
     "&forma_pago=".$forma_pago."&tipo_calculo=".$tipo_calculo."&cod_empleado_d=".$cod_empleado_d."&cod_empleado_h=".$cod_empleado_h."&cod_presup_catd=".$cod_presup_d."&cod_presup_cath=".$cod_presup_cath.
     "&codigo_cargo_d=".$codigo_cargo_d."&codigo_cargo_h=".$codigo_cargo_h."&cod_departd=".$cod_departd."&cod_departh=".$cod_departh."&fecha_desde=".$fecha_desde."&fecha_hasta=".$fecha_hasta.
	 "&estatus_trab_d=".$estatus_trab_d."&tipo_concepto=".$tipo_concepto."&tipo_personal_d=".$tipo_personal_d."&tipo_personal_h=".$tipo_personal_h."&num_periodos=".$num_periodos;
	 
 //echo $url;	 
}
pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}?>
