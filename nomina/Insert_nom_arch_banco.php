<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();   $error=0;
$cod_arch_banco=$_POST["txtcod_arch_banco"]; $tipo_arch_banco=$_POST["txttipo_arch_banco"];   $tipo_nomina=$_POST["txttipo_nomina"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $url="Det_nomina_arch_banco.php?criterio=".$tipo_arch_banco.$cod_arch_banco;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select tipo_nomina from NOM046 WHERE cod_arch_banco='$cod_arch_banco' and tipo_arch_banco='$tipo_arch_banco' and tipo_nomina='$tipo_nomina'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA YA EXISTE EN LA DEFINCION DE ARCHIVO');</script><? }
  if($error==0){$sSQL="Select tipo_nomina from NOM001 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
    if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO EXISTE');</script><? } }
  if($error==0){$sSQL="SELECT ACTUALIZA_NOM046(1,'$cod_arch_banco','$tipo_arch_banco','$tipo_nomina')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61);
    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}
  }
}pg_close();
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>