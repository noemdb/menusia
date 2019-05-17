<?include ("../class/conect.php");  include ("../class/fun_numeros.php"); include ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy();  $error=0; $equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");
$fecha_hasta=$_POST["txtfecha_hasta"]; $fecha_desde=$_POST["txtfecha_desde"]; $fechad=formato_aaaammdd($fecha_desde); $fechah=formato_aaaammdd($fecha_hasta);
$conc_prest=$_POST["txtcod_concepto"]; $tipo_nomina_d=$_POST["txttipo_nomina_d"]; $tipo_nomina_h=$_POST["txttipo_nomina_h"];

$cod_concepto1="102"; $cod_concepto2="300"; $cod_concepto3="510"; $cod_ch="507"; $cod_fh="510"; $cod_rem="300"; $cod_retbv="102" ;$cod_post="103"; $monto_presta=0; 
$dias_bono_vac=52; $dias_bonf=120; $cant_ano=360; $cod_partida="401-08-01-00";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$prev_cod=""; $prev_fecha=""; $prev_nombre=""; $prev_tipo="";  $prev_presup=""; $monto_p=0; $monto_s=0; $monto_vac=0; $monto_bonf=0; $cant_trab=0; $tot_trab=0;
$sql="SELECT * FROM nom019 Where ((nom019.cod_concepto>='$cod_concepto1') and (nom019.cod_concepto<='$cod_concepto3')) and ((nom019.tipo_nomina>='$tipo_nomina_d') and (nom019.tipo_nomina<='$tipo_nomina_h') ) and ((nom019.fecha_proceso>='$fechad') and (nom019.fecha_proceso<='$fechah')) order by nom019.cod_empleado,nom019.cod_concepto"; $res=pg_query($sql);
//echo $sql,"<br>";
while($reg=pg_fetch_array($res)){ 
  $cod_empleado=$reg["cod_empleado"];  $fecha_ingreso=$reg["fecha_ingreso"]; $nombre=$reg["nombre"]; $tipo_nomina=$reg["tipo_nomina"]; $cod_presup=$reg["cod_presup"];
  if($prev_cod==""){ $prev_cod=$cod_empleado; $prev_nombre=$nombre; $prev_tipo=$tipo_nomina; $prev_fecha=$fecha_ingreso; $prev_presup=$cod_presup; }
  $cod_concepto=$reg["cod_concepto"];  $monto=$reg["monto"]; $cantidad=$reg["cantidad"];
  
  if($prev_cod<>$cod_empleado){ $temp_f=formato_ddmmaaaa($prev_fecha); $f=diferencia_meses($temp_f,$fecha_hasta);
    if($f>=4){ $monto_s=$monto_presta/30; $monto_a=$monto_presta*12;	
	  $monto_vac=$monto_s*$dias_bono_vac;  $monto_sb=($monto_a+$monto_vac)/360;	  
	  $monto_bonf=$monto_sb*$dias_bonf;
	  $dias_vac=($monto_vac/$cant_ano); 
	  $monto_p=($monto_s+$dias_vac+$dias_bonf)*5;
	  $monto_p=($monto_a+$monto_vac+$monto_bonf)/360;  $monto_p=$monto_p*5;
	  $monto_p=round($monto_p,2); $monto_bonf=round($monto_bonf,2);
	  $cod_cat=substr($prev_presup,0,9);  $cod_pre=$cod_cat.$cod_partida; $cant_trab=$cant_trab+1; $tot_trab=$tot_trab+$monto_p;
	  
	 //echo $prev_cod." ".$prev_nombre." ".$prev_fecha." ".$cod_pre." ".$monto_p." ".$monto_presta." ". $monto_a." ".$monto_vac." ".$monto_sb." ".$monto_bonf,"<br>";
	  echo $prev_cod." ".$prev_nombre." ".$prev_fecha." ".$cod_pre." ".$monto_p." ".$monto_presta,"<br>";
	  $sSQL="Update nom011 set cantidad=0,monto=$monto_p,cod_presup='$cod_pre' where tipo_nomina='$prev_tipo' and cod_empleado='$prev_cod' and cod_concepto='$conc_prest'"; 
	  $sSQL="Update nom011 set cantidad=0,monto=$monto_p where cod_empleado='$prev_cod' and cod_concepto='$conc_prest'"; 
	  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error,0,70);if(!$resultado){ echo "Actualiza Concepto ".$cod_empleado,"<br>"; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?  $error=1;}      
    }  
    $prev_cod=$cod_empleado; $prev_nombre=$nombre; $prev_tipo=$tipo_nomina; $prev_fecha=$fecha_ingreso; $prev_presup=$cod_presup; $monto_presta=0;}
  if(($cod_concepto==$cod_ch)or($cod_concepto==$cod_fh)or($cod_concepto==$cod_rem)or($cod_concepto==$cod_post)){
    $monto_presta=$monto_presta+$monto; 
  }	
  if($cod_concepto==$cod_retbv){
    $monto_presta=$monto_presta-$monto; 
  }
}
if($monto_presta>0){ $f=diferencia_meses($prev_fecha,$fecha_hasta);
    if($f>=4){ $monto_s=$monto_presta/30; $monto_a=$monto_presta*12;	
	  $monto_vac=$monto_s*$dias_bono_vac;  $monto_sb=($monto_a+$monto_vac)/360;	  
	  $monto_bonf=$monto_sb*$dias_bonf;
	  $dias_vac=($monto_vac/$cant_ano); 
	  $monto_p=($monto_s+$dias_vac+$dias_bonf)*5;
	  $monto_p=($monto_a+$monto_vac+$monto_bonf)/360;  $monto_p=$monto_p*5;
	  $monto_p=round($monto_p,2); $monto_bonf=round($monto_bonf,2);
	  $cod_cat=substr($prev_presup,0,9);  $cod_pre=$cod_cat.$cod_partida; $cant_trab=$cant_trab+1; $tot_trab=$tot_trab+$monto_p;
	 //echo $prev_cod." ".$prev_nombre." ".$prev_fecha." ".$cod_pre." ".$monto_p." ".$monto_presta." ". $monto_a." ".$monto_vac." ".$monto_sb." ".$monto_bonf,"<br>";
	  echo $prev_cod." ".$prev_nombre." ".$prev_fecha." ".$cod_pre." ".$monto_p." ".$monto_presta,"<br>";
	  $sSQL="Update nom011 set cantidad=0,monto=$monto_p,cod_presup='$cod_pre' where tipo_nomina='$prev_tipo' and cod_empleado='$prev_cod' and cod_concepto='$conc_prest'"; 
	  $sSQL="Update nom011 set cantidad=0,monto=$monto_p where cod_empleado='$prev_cod' and cod_concepto='$conc_prest'"; 
	  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error,0,70);if(!$resultado){ echo "Actualiza Concepto ".$cod_empleado,"<br>"; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?  $error=1;}      
    }
}
echo "CANTIDAD TRABAJADORES : ".$cant_trab." MONTO TOTAL : ".$tot_trab;
	
?>
