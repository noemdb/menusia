<?include ("../class/conect.php");  include ("../class/fun_numeros.php"); include ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy();  $error=0; $equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");
$fecha_hasta=$_POST["txtfecha_hasta"]; $fecha_desde=$_POST["txtfecha_desde"]; $fechad=formato_aaaammdd($fecha_desde); $fechah=formato_aaaammdd($fecha_hasta);
$conc_prest=$_POST["txtcod_concepto"]; $tipo_nomina_d=$_POST["txttipo_nomina_d"]; $tipo_nomina_h=$_POST["txttipo_nomina_h"];
$fechah1=$_POST["txtfecha_hasta"]; $fechah1=colocar_pdiames($fechah1);  $fechah1=nextano($fechah1,-1); $fechah2=nextano($fechah1,1);
$cod_concepto1="400"; $mes=substr($fecha_hasta,3,2); $mes=$mes*1; $dia=substr($fecha_hasta,0,2); $dia=$dia*1;    $diad=substr($fecha_desde,0,2); $diad=$diad*1;
$fecha_ley="19/06/1997";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");

$sSQL="Update nom011 set cantidad=0,monto=0 where cod_concepto='$conc_prest'"; $resultado=pg_exec($conn,$sSQL);
	  
$sql="select cod_empleado,nombre,fecha_ingreso,status,extract(month from fecha_ingreso) from nom006 where ((extract(month from nom006.fecha_ingreso))=$mes) and ((extract(day from nom006.fecha_ingreso))>=$diad) and ((extract(day from nom006.fecha_ingreso))<=$dia)  and ((nom006.tipo_nomina>='$tipo_nomina_d') and (nom006.tipo_nomina<='$tipo_nomina_h') ) and (nom006.status='ACTIVO' or nom006.status='REPOSO' or nom006.status='PERMISO RE' or nom006.status='VACACIONES' or nom006.status='PERMISO NO') order by nom006.cod_empleado"; 

$sql="select cod_empleado,nombre,fecha_ingreso,status,extract(month from fecha_ingreso) from nom006 where ((nom006.tipo_nomina>='$tipo_nomina_d') and (nom006.tipo_nomina<='$tipo_nomina_h') ) and (nom006.status='ACTIVO' or nom006.status='REPOSO' or nom006.status='PERMISO RE' or nom006.status='VACACIONES' or nom006.status='PERMISO NO') order by nom006.cod_empleado"; 

$res=pg_query($sql);
echo "DIAS ADICIONALES DE PRESTACIONES SOCIALES AL ".$fecha_hasta;
$tabla="<table border=1>";
$tabla.="<tr bgcolor= #cccccc><td>"."CODIGO"."</td><td>"."NOMBRE DEL TRABAJADOR"."</td><td>"."FECHA INGRESO"."</td><td>"."ANTIGUEDAD"."</td><td>"."DIAS"."</td><td>"."MONTO DIAS"."</td><td>"."ACUMULADO"."</td></tr>";
while($reg=pg_fetch_array($res)){ 
  $cod_empleado=$reg["cod_empleado"];  $fecha_ingreso=$reg["fecha_ingreso"]; $nombre=$reg["nombre"]; $fechai=formato_ddmmaaaa($reg["fecha_ingreso"]);
  $fechal=formato_aaaammdd($fecha_ley); if($fecha_ingreso<$fechal){$fechai=$fecha_ley;}
  $tdia=substr($fechai,0,2); $tmes=substr($fechai,3,2); $tmes=$tmes*1; 
  $f=diferencia_años($fechai,$fecha_hasta); $f=round($f,0);
  if($tmes==$mes){  if(($tdia>=$diad) and ($tdia<=$dia)){$f=$f;}else{$f=0;} }else{$f=0;}
  if($f>=2){ $monto_p=0; $monto_presta=0; $a=$f-1;  $d=$a*2; if($d>30){$d=30;}  
    $Ssql="select sum(monto) as monto_acum from nom018 where (cod_empleado='$cod_empleado') and (fecha_nomina>='$fechah1') and (fecha_nomina<'$fechah2') and (cod_concepto='$cod_concepto1')";
	$resultado=pg_query($Ssql);$filas=pg_num_rows($resultado); 
	if($filas>=1){$registro=pg_fetch_array($resultado); $monto_presta=$registro["monto_acum"]; }
	if ($monto_presta>0){ $monto_p=$monto_presta/60; $monto_p=round($monto_p,2); $monto_p=$monto_p*$d;
	  $fmonto_p=formato_monto($monto_p); $fmonto_presta=formato_monto($monto_presta);
	  $tabla.="<tr><td>".$cod_empleado."</td><td>".$nombre."</td><td align=center>".$fechai."</td><td align=center>".$f."</td><td align=center>".$d."</td><td align=right>".$fmonto_p."</td><td align=right>".$fmonto_presta."</td></tr>";
      //echo $cod_empleado." ".$nombre." ".$fechai." ".$f." ".$d." ".$monto_p." ".$monto_presta,"<br>";
	  $sSQL="Update nom011 set cantidad=$d,monto=$monto_p where cod_empleado='$cod_empleado' and cod_concepto='$conc_prest'"; 
	  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error,0,70);if(!$resultado){ echo "Actualiza Concepto ".$cod_empleado,"<br>"; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?  $error=1;}      
    }else{ $tabla.="<tr><td>".$cod_empleado."</td><td>".$nombre."</td><td align=center>".$fechai."</td><td align=center>".$f."</td><td align=center>".$d."</td><td align=right>"."NO LOCALIZO"."</td><td align=right>"."HISTORICO"."</td></tr>"; }
  }
}
$tabla.="</table>";
pg_close();
echo $tabla;
?>
