<?include ("../class/conect.php");  include ("../class/funciones.php"); $cod_empleado=$_GET["codigo"]; $fechah=$_GET["fechah"]; $error=0; $fecha_tope="30/04/2012";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$sql="Select cod_empleado,nombre,cedula,fecha_ingreso,tipo_nomina FROM NOM006 where (cod_empleado='$cod_empleado')"; $res=pg_query($sql);$filas=pg_num_rows($res);
$nombre=""; $cedula=""; $fecha_ingreso=""; $tipo_nomina="00"; if($filas>=1){ $registro=pg_fetch_array($res,0);
$nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $tipo_nomina=$registro["tipo_nomina"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso); $cod_empleado=$registro["cod_empleado"];  }
else{$error=1;?><script language="JavaScript">muestra('CODIGO DE TRABAJADOR NO LOCALIZADO');</script><? }
$m1=FDate($fechah); $m2=FDate($fecha_tope); if($m1>$m2){  echo " Fecha Calculo:".$fechah." numero:".$m1.",     Fecha Tope:".$fecha_tope." numero:".$m2; $error=1;?><script language="JavaScript">muestra('FECHA CALCULO DE PRESTACIONES INVALIDA');</script><? }
pg_close(); $url="Insert_calculo_presta.php?codigo_d=".$cod_empleado."&codigo_h=".$cod_empleado."&tipod=".$tipo_nomina."&tipoh=".$tipo_nomina."&fechah=".$fechah;
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>


