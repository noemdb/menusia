<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); $fechab=$_GET["fechah"];  $fechah=formato_aaaammdd($fechab);  $fechad=$_GET["fechad"];  $fechad=formato_aaaammdd($fechad);
$cod_empleado_d=$_GET["codigo_d"];  $cod_empleado_h=$_GET["codigo_h"]; $tipo_nomina_d=$_GET["tipod"]; $tipo_nomina_h=$_GET["tipoh"];  $busca_hist=$_GET["busca_hist"]; $cant_dias=$_GET["cant_dias"]; $fechacb=$_GET["fechac"]; $fechac=$_GET["fechac"];  $fechac=formato_aaaammdd($fechac);
$cod_conc="150";  $cod_adic="150";  $url="Act_sueldo_prestaciones.php?Gcriterio=C".$fechab.$cod_empleado_d; $cod_empleado=$cod_empleado_d;  $cant_dias=$cant_dias*1;  $dias_vac=63; $dias_prest=100;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ 
 /*
 001 Sueldo
002 Descanso sabado y domingo
003 Tiempo de descanso articulo 169
004 Tiempo de viaje
005 Tiempo de descanso Art. 169 semana anterior
007 Domingo laborado
009 Dias feriados laborados
010 Horas Extras
011 Bono de puntualidad
012 Descanso compensatorio
013 Bono nocturno
016 Bono tunel
019 Dia de descanso laborado
020 Diferencia de sueldo
050 Bono Vacacional
051 Diferencia de bono vacaional
*/ 
   $sql_conceptos=" (cod_concepto='001' or cod_concepto='002' or cod_concepto='003'  or cod_concepto='004' or cod_concepto='005' or cod_concepto='007' or cod_concepto='009' or cod_concepto='010' or cod_concepto='011' or cod_concepto='012' or cod_concepto='013' or cod_concepto='016' or cod_concepto='019' or cod_concepto='020' or cod_concepto='050' or cod_concepto='051')";
   $sql="SELECT cod_empleado,sum(monto) as monto FROM NOM019 Where ".$sql_conceptos."  and (fecha_p_hasta>='$fechad') And (fecha_p_desde<='$fechah') And (tipo_nomina>='$tipo_nomina_d') And (tipo_nomina<='$tipo_nomina_h') And (cod_empleado>='$cod_empleado_d') And (cod_empleado<='$cod_empleado_h') group by cod_empleado order by cod_empleado";    $res=pg_query($sql); echo $sql,"<br>"; $prev_cod="";
   while($reg=pg_fetch_array($res)){ $cod_empleado=$reg["cod_empleado"];  $monto=$reg["monto"];  $des_concepto="SUELDO DE PRESTACIONES";
     $montob=$monto; $s_dia=$monto/$cant_dias; $f_vac=($s_dia*$dias_vac)/360;  $f_prest=($s_dia*$dias_prest)/360; $monto=($s_dia+$f_vac+$f_prest)*30; $monto=round($monto,2);
	 $sSQL="SELECT ACTUALIZA_NOM028(3,'$cod_empleado','$fechac',$monto,$monto,$montob,0,0,$f_vac,$f_prest,$cant_dias,$s_dia,0,0,'$minf_usuario','$cod_conc','$fechah','$des_concepto','000','$fechah','')";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?} 
	 echo $sSQL,"<br>";
	 if($cod_conc==$cod_adic){ 
	   $sSQL="SELECT ACTUALIZA_NOM028(4,'$cod_empleado','$fechac',$monto,$monto,$montob,0,0,$f_vac,$f_prest,$cant_dias,$s_dia,0,0,'$minf_usuario','$cod_conc','$fechah','','$cod_adic','$fechah','$des_concepto')";
       $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?} 
	   //echo $sSQL,"<br>";
	 }
   }
   
}pg_close();  $url="Act_sueldo_prestaciones_yac.php?Gcriterio=C".$fechacb.$cod_empleado;
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}
?>


