<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); $fecha_tope="30/04/2012"; $fechah=$_GET["fechah"]; $m1=FDate($fechah); $m2=FDate($fecha_tope);  $fechah=formato_aaaammdd($fechah);
$cod_empleado_d=$_GET["codigo_d"];  $cod_empleado_h=$_GET["codigo_h"]; $tipo_nomina_d=$_GET["tipod"]; $tipo_nomina_h=$_GET["tipoh"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $error=0;
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$url="Act_cal_prest_lott.php?Gcodigo=C".$cod_empleado_d; $cant_trab=0; $hora1=time();
if($m1<=$m2) { $error=0; ?> <script language="JavaScript">muestra('FECHA INVALIDA, FECHA DEBE SER MAYOR A: '+'<? echo $fecha_tope; ?>');   </script> <? }
if($error==0){$sql="Select * FROM CAL_PRESTA  where (cod_empleado>='$cod_empleado_d') AND (cod_empleado<='$cod_empleado_h') AND (tipo_nomina>='$tipo_nomina_d') AND (tipo_nomina<='$tipo_nomina_h') AND (fecha_calculo>='$fechah')"; $res=pg_query($sql);
while($reg=pg_fetch_array($res)){ $cod_empleado=$reg["cod_empleado"];   $fecha_c=$reg["fecha_calculo"]; $tipo_nomina=$reg["tipo_nomina"]; $tipo_calculo=$reg["tipo_calculo"];  $num_calculo=$reg["num_calculo"];
  $tprestaciones=$reg["total_prestaciones"]; $madelanto=$reg["monto_adelanto"]; $tadelanto=$reg["total_adelanto"];  $sprestaciones=$reg["saldo_prestaciones"]; $tinteres=$reg["total_interes"]; $interes_pagado=$reg["interes_pagado"];
  if(($cod_empleado>=$cod_empleado_d)and($cod_empleado<=$cod_empleado_h)and($fecha_c>=$fechah)and($tipo_nomina>=$tipo_nomina_d)and($tipo_nomina<=$tipo_nomina_h)){ $cant_trab=$cant_trab+1;
   $sSQL="SELECT ELIMINA_NOM030('$cod_empleado','$fecha_c','$num_calculo','$tipo_calculo',$tprestaciones,$madelanto,$tadelanto,$interes_pagado,$tinteres,$sprestaciones)";
   $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR ELIMINANDO: ".substr($error, 0, 61); if (!$resultado){$mgraba=1;?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?} }
   //echo $sSQL,"<br>";
}}
pg_close();
if($error==0){?><script language="JavaScript">muestra('FINALIZO ELIMINAR CALCULO, CANTIDAD MOVIMIENTOS: '+'<? echo $cant_trab; ?>');  document.location ='<? echo $url; ?>'; </script> <?} else{ ?><script language="JavaScript">document.location ='<? echo $url; ?>'; </script> <? } ?>

