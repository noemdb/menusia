<?include ("../class/conect.php");  include ("../class/funciones.php");$fecha_hoy=asigna_fecha_hoy();   $error=0;
$cod_arch_banco=$_POST["txtcod_arch_banco"]; $tipo_arch_banco=$_POST["txttipo_arch_banco"]; $den_arch_banco=$_POST["txtden_arch_banco"]; $cod_cta_emp=$_POST["txtcod_cta_emp"]; 
$cod_arch_banco_new=$_POST["txtcod_arch_banco_new"]; $den_arch_banco_new=$_POST["txtden_arch_banco_new"];  $url=$_POST["txturl"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  //$url="Act_archivo_banco.php?Gcriterio=C".$cod_arch_banco;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select * from NOM045 WHERE cod_arch_banco='$cod_arch_banco' and tipo_arch_banco='$tipo_arch_banco'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE ARCHIVO NO EXISTE');</script><? }
  if($filas==0){  $sSQL="Select * from NOM045 WHERE cod_arch_banco='$cod_arch_banco' and tipo_arch_banco='$tipo_arch_banco'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
    if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE ARCHIVO NUEVO YA EXISTE');</script><? } }  
  if($error==0){if(strlen($cod_arch_banco)==6){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD CODIGO DE ARCHIVO INVALIDA');</script><?} }
  if($error==0){$sfecha=formato_aaaammdd($fecha_hoy); $sSQL="SELECT COPIAR_NOM045('$cod_arch_banco','$cod_arch_banco_new','$tipo_arch_banco','$den_arch_banco_new','','','$cod_cta_emp','','','','','','','','','','','$minf_usuario')";  echo $sSQL;
    $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror="ERROR GRABANDO: ".substr($merror, 0, 91); if (!$resultado){$error=1;?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('COPIO EXITOSAMENTE');</script><?}
  }
}pg_close(); 
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}
?>