<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL); $cod_banco=$_GET["txtcod_banco"]; $mes=$_GET["txtmes"]; $url="Conciliacion_bancaria.php?codbanco=".$cod_banco;
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $fecha_hoy=asigna_fecha_hoy(); $sfecha=formato_aaaammdd($fecha_hoy);
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{  $sql="SELECT * FROM ban009 where cod_banco='".$cod_banco."'";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$reg=pg_fetch_array($res,0); $u_mes=$reg["u_conciliacion"]; if($mes<=$u_mes){$error=1; ?>  <script language="JavaScript">  muestra('MES YA CONCILIADO, NO VALIDO');  </script> <?}
}else{$error=0; $sSQL="SELECT ACTUALIZA_BAN009('I','$cod_banco','00','01',1,'N','$sfecha')";  $resultado=pg_exec($conn,$sSQL); }
if($error==0){
 echo "ESPERE CONCILIANDO LIBROS....","<br>"; $resultado=pg_exec($conn,"SELECT CONCILIA_LIBROS('$cod_banco','$mes',$mes)"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 echo "ESPERE CONCILIANDO TRANSITO LIBROS....","<br>"; $resultado=pg_exec($conn,"SELECT CONCILIA_TRANS_LIBROS('$cod_banco','$mes',$mes)"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 echo "ESPERE CONCILIANDO TRANSITO BANCOS....","<br>"; $resultado=pg_exec($conn,"SELECT CONCILIA_TRANS_BANCOS('$cod_banco','$mes',$mes)"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 echo "ESPERE CONCILIANDO BANCOS....","<br>"; $resultado=pg_exec($conn,"SELECT CONCILIA_BANCOS('$cod_banco','$mes',$mes)"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $sql="SELECT * FROM ban010 where cod_banco='".$cod_banco."' and mes_conciliado='".$mes."'";$res=pg_query($sql);$filas=pg_num_rows($res);
 if($filas==0){ $resultado=pg_exec($conn,"SELECT INCLUYE_BAN010('$cod_banco','00000001','CHQ','$sfecha',0,'$mes','0','','')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }   }
 $sSQL="SELECT ACTUALIZA_BAN009('M','$cod_banco','$mes','$mes',$mes,'S','$sfecha')";  $resultado=pg_exec($conn,$sSQL);
 ?><script language="JavaScript">muestra('CONCILIACION FINALIZADA');</script><?
}}
pg_close();error_reporting(E_ALL ^ E_WARNING); ?><script language="JavaScript">document.location='<? echo $url; ?>';</script>