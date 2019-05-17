<?php include ("../class/conect.php"); include ("../class/funciones.php"); $tipo_nomina=$_GET["tipo_nomina"]; $tp_calculo=$_GET["tp_calculo"]; $num_periodo=$_GET["num_periodos"]; $codigo_mov=$_GET["codigo_mov"]; $password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$fecha_hoy=asigna_fecha_hoy();  $sfecha=formato_aaaammdd($fecha_hoy);
$resultado=pg_exec($conn,"SELECT ACTUALIZA_NOM072(4,'$codigo_mov','','','','','','','$sfecha')"); $error=pg_errormessage($conn); $error=substr($error,0,91);
$sql="Select DISTINCT cod_empleado,cedula,nombre,tipo_nomina,fecha_ingreso,status_calculo from NOM017 where (tipo_nomina='$tipo_nomina') and (tp_calculo='$tp_calculo') and (tp_calculo='$tp_calculo') and (num_periodos=$num_periodo) order by cod_empleado"; $res=pg_query($sql); $filas=pg_num_rows($res);
//echo $sql." ".$filas;
while($registro=pg_fetch_array($res)) { $cod_empleado=$registro["cod_empleado"]; $cedula=$registro["cedula"];$nombre=$registro["nombre"]; $tipo_nomina=$registro["tipo_nomina"]; $fecha_ingreso=$registro["fecha_ingreso"]; $nacionalidad="V"; $status="ACTIVO";
  $sSQLg="SELECT ACTUALIZA_NOM072(1,'$codigo_mov','$cod_empleado','$cedula','$nombre','$tipo_nomina','$nacionalidad','$status','$fecha_ingreso')"; 
  //echo $sSQLg,"<br>";
  $resultadog=pg_exec($conn,$sSQLg); $error=pg_errormessage($conn);}
?>
<iframe src="Det_trab_nom_ext.php?codigo_mov=<?echo $codigo_mov?>" width="925" height="350" scrolling="auto" frameborder="0"></iframe>