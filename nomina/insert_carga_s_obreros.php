<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); $fechab=$_GET["fechah"];  $fechah=formato_aaaammdd($fechab);  $fechad=$_GET["fechad"];  $fechad=formato_aaaammdd($fechad);
$cod_empleado_d=$_GET["codigo_d"];  $cod_empleado_h=$_GET["codigo_h"]; $tipo_nomina_d=$_GET["tipod"]; $tipo_nomina_h=$_GET["tipoh"];  $busca_hist=$_GET["busca_hist"]; $cant_dias=$_GET["cant_dias"];
$cod_conc=$_GET["conceptos"];  $cod_adic=$_GET["conceptoa"];  $url="Act_sueldo_prestaciones.php?Gcriterio=C".$fechab.$cod_empleado_d; $cod_empleado=$cod_empleado_d;  $cant_dias=$cant_dias*1;  $dias_vac=63; $dias_prest=100;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ if($tipo_nomina_d=="21"){ $dias_vac=40; $dias_prest=90;}
   $sql="SELECT cod_empleado,des_concepto,monto FROM NOM018 Where (cod_concepto='$cod_conc') And (fecha_nomina='$fechah') And (tipo_nomina>='$tipo_nomina_d') And (tipo_nomina<='$tipo_nomina_h') And (cod_empleado>='$cod_empleado_d') And (cod_empleado<='$cod_empleado_h') order by cod_empleado,cod_concepto"; 
   if($busca_hist=="NOM"){ $sql="SELECT cod_empleado,denominacion,sum(monto) as monto FROM NOM019 Where (cod_concepto='$cod_conc') And (fecha_p_hasta>='$fechad') And (fecha_p_desde<='$fechah') And (tipo_nomina>='$tipo_nomina_d') And (tipo_nomina<='$tipo_nomina_h') And (cod_empleado>='$cod_empleado_d') And (cod_empleado<='$cod_empleado_h') group by cod_empleado,denominacion order by cod_empleado"; }
   $res=pg_query($sql); echo $sql,"<br>"; $prev_cod="";
   while($reg=pg_fetch_array($res)){ $cod_empleado=$reg["cod_empleado"];  $monto=$reg["monto"]; if($busca_hist=="NOM"){ $des_concepto=$reg["denominacion"]; } else { $des_concepto=$reg["des_concepto"];}
     $montob=$monto; $s_dia=$monto/$cant_dias; $f_vac=($s_dia*$dias_vac)/360;  $f_prest=($s_dia*$dias_prest)/360; $monto=($s_dia+$f_vac+$f_prest)*30; $monto=round($monto,2);
	 $sSQL="SELECT ACTUALIZA_NOM028(3,'$cod_empleado','$fechah',$monto,$monto,$montob,0,0,$f_vac,$f_prest,$cant_dias,$s_dia,0,0,'$minf_usuario','$cod_conc','$fechah','$des_concepto','000','$fechah','')";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?} 
	 echo $sSQL,"<br>";
	 if($cod_conc==$cod_adic){ 
	   $sSQL="SELECT ACTUALIZA_NOM028(4,'$cod_empleado','$fechah',$monto,$monto,$montob,0,0,$f_vac,$f_prest,$cant_dias,$s_dia,0,0,'$minf_usuario','$cod_conc','$fechah','','$cod_adic','$fechah','$des_concepto')";
       $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?} 
	   //echo $sSQL,"<br>";
	 }
   }
   if($cod_conc<>$cod_adic){
     $sql="SELECT cod_empleado,des_concepto,monto FROM NOM018 Where (cod_concepto='$cod_adic') And (fecha_nomina='$fechah') And (tipo_nomina>='$tipo_nomina_d') And (tipo_nomina<='$tipo_nomina_h') And (cod_empleado>='$cod_empleado_d') And (cod_empleado<='$cod_empleado_h') order by cod_empleado,cod_concepto"; 
	 if($busca_hist=="NOM"){ $sql="SELECT cod_empleado,denominacion,sum(monto) as monto FROM NOM019 Where (cod_concepto='$cod_adic') And (fecha_p_hasta>='$fechad') And (fecha_p_desde<='$fechah') And (tipo_nomina>='$tipo_nomina_d') And (tipo_nomina<='$tipo_nomina_h') And (cod_empleado>='$cod_empleado_d') And (cod_empleado<='$cod_empleado_h') group by cod_empleado,denominacion order by cod_empleado"; }
     $res=pg_query($sql);
     while($reg=pg_fetch_array($res)){ $cod_empleado=$reg["cod_empleado"]; $des_concepto=$reg["des_concepto"]; $monto=$reg["monto"]; $sSQL="SELECT ACTUALIZA_NOM028(4,'$cod_empleado','$fechah',$monto,$monto,0,0,0,0,0,0,0,0,0,'$minf_usuario','$cod_conc','$fechah','','$cod_adic','$fechah','$des_concepto')";
       $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}}
    }
}pg_close();  $url="Act_sueldo_prestaciones.php?Gcriterio=C".$fechab.$cod_empleado;
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}
?>


