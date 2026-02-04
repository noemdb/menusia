<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); $error=0; $sfecha=formato_aaaammdd($fecha_hoy);   
$codigo_mov=$_POST["txtcodigo_mov"]; $criterio=$_POST["txtcriterio"]; $cod_estructura=$_POST["txtcod_estructura"]; $tp_calculo=$_POST["txttipo_calculo"];  
$fecha_hasta=$_POST["txtfecha_hasta"]; $fecha_desde=$_POST["txtfecha_desde"]; $cod_concepto=$_POST["txtcod_concepto_a"];  $ref_comp=$_POST["txtref_comp"];
$tipo_arch_banco=substr($criterio,0,2); $cod_arch_banco=substr($criterio,2,6);
$mformula=""; $fechad=formato_aaaammdd($fecha_desde); $fechah=formato_aaaammdd($fecha_hasta);
$referencia_comp="00000000"; $tipo_compromiso="0000";  $ref_imput_presu="00000000";  $tipo_imput_presu="P";
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR GENERANDO ESTRUCTURA....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{ $resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");
$criterio=$tp_calculo.$cod_estructura."T".$fechad.$fechah.$cod_concepto; $url="Mostrar_est_aporte.php?criterio=".$criterio;
$sql="SELECT NOM046.tipo_nomina,NOM001.descripcion FROM NOM046,NOM001 Where (NOM046.tipo_nomina=NOM001.tipo_nomina) And (Cod_Arch_Banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco')"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $tipo=$registro["tipo_nomina"]; if($mformula!=""){$mformula=$mformula." or ";}  $mformula=$mformula."(tipo_nomina='$tipo')";}
if($mformula==""){$error=1;?> <script language="JavaScript">muestra('NO EXISTEN NOMINAS SELECCIONADAS');</script><? }
if($error==0){$mformula="(".$mformula.")";  if($tp_calculo=="T"){$mformula=$mformula;}else{$mformula=$mformula." and (Tp_Calculo='$tp_calculo')";} }
if($error==0){$sql="SELECT * FROM pag009 WHERE (cod_estructura='$cod_estructura')"; $res=pg_query($sql); $filas=pg_num_rows($res);
  if($filas>0){$reg=pg_fetch_array($res); if($ref_comp=="SI"){$referencia_comp=$reg["ref_comp_est"]; $tipo_compromiso=$reg["tipo_comp_est"];  $ref_imput_presu=$reg["ref_imput_presu"]; $tipo_imput_presu=$reg["tipo_imput_presu"];} }
    else{$error=1;?> <script language="JavaScript">muestra('CODIGO DE ESTRUCTURA NO LOCALIZDA');</script><? } }

if($error==0){  //$mformula=$mformula." and ((fecha_proceso>='$fechad') and (fecha_proceso<='$fechah'))";
$mformula=$mformula." and ((fecha_p_hasta>='$fechad') and (fecha_p_hasta<='$fechah'))";
$sql="SELECT cod_presup,cod_contable,sum(monto) as monto_c FROM NOM017 Where (NOM017.cod_concepto='$cod_concepto') and  ". $mformula ." group by cod_presup,cod_contable order by cod_presup,cod_contable";   $res=pg_query($sql);
//echo $sql,"<br>";
while($reg=pg_fetch_array($res)){ $cod_presup=$reg["cod_presup"]; $monto_c=$reg["monto_c"]; $cod_fuente="00"; $cod_fuente=$reg["cod_contable"];
$resultado=pg_exec($conn,"SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$cod_fuente','$referencia_comp','$tipo_compromiso','','0000','','0000','','0000','','','','','','','$sfecha','F','$tipo_imput_presu','$ref_imput_presu','$sfecha',$monto_c,0,0,0)"); $error=pg_errormessage($conn); $error="ERROR GRABANDO 1: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }}

$sql="SELECT cod_presup,cod_contable,sum(monto) as monto_c FROM NOM019 Where (NOM019.cod_concepto='$cod_concepto') and  ". $mformula ." group by cod_presup,cod_contable order by cod_presup,cod_contable";   $res=pg_query($sql);
//echo $sql,"<br>";
while($reg=pg_fetch_array($res)){ $cod_presup=$reg["cod_presup"]; $monto_c=$reg["monto_c"]; $cod_fuente="00"; $cod_fuente=substr($reg["cod_contable"],0,2);
$sSQL="SELECT monto FROM PRE026 where codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$cod_fuente' and ref_imput_presu='$ref_imput_presu' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso'";  $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
if($filas>0){ $registro=pg_fetch_array($resultado); $monto=$registro["monto"]+$monto_c; $monto=cambia_coma_numero($monto);
$resultado=pg_exec($conn,"SELECT MOD_MONTO_PRE026('$codigo_mov','$cod_presup','$cod_fuente','$referencia_comp','$tipo_compromiso','$ref_imput_presu',$monto,0)"); $error=pg_errormessage($conn); $error="ERROR GRABANDO 3: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } }
else{$sqlg="SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$cod_fuente','$referencia_comp','$tipo_compromiso','','0000','','0000','','0000','','','','','','','$sfecha','F','$tipo_imput_presu','$ref_imput_presu','$sfecha',$monto_c,0,0,0)"; $resultado=pg_exec($conn,$sqlg); $error=pg_errormessage($conn); $error="ERROR GRABANDO 4: ".substr($error, 0, 91); if (!$resultado){echo $sqlg,"<br>"; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } } }
} }
pg_close(); 
/* */
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}
else{?><script language="JavaScript">history.back();</script><?}

?>