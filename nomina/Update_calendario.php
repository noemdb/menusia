<?include ("../class/conect.php");  include ("../class/funciones.php");
 $fecha=$_POST["txtfecha"]; $campo_str1=$_POST["txtdia"]; $status_feriado=$_POST["txtstatus_feriado"]; $des_feriado=$_POST["txtobservacion"];  $cant_horas=$_POST["txtcant_horas"];
 $mes=$_POST["txtmes"]; $ano=$_POST["txtano"]; $campo_num1=$_POST["txtcampo_num1"]; $status1=$_POST["txtstatus1"]; $status2=""; $status_feriado=substr($status_feriado,0,1);
$equipo = getenv("COMPUTERNAME"); $MInf_Usuario=$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Det_def_calendario.php?mes=".$mes."&ano=".$ano."&ini=N";  $cod_empleado="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ if(checkData($fecha)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? } }
 if($error==0){ $fecha_c=formato_aaaammdd($fecha);
  $sSQL="select * FROM nom049 Where (fecha_c='$fecha_c')"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('FECHa NO LOCALIZADA');</script><? }
   else{  $sSQL="SELECT ACTUALIZA_NOM049(2,'$fecha_c','$mes','$ano','$des_feriado','$status_feriado',$cant_horas,'$status1','$status2','$campo_str1',$campo_num1)"; //echo $sSQL;
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
  }
}
pg_close(); 
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}
?>