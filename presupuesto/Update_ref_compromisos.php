<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$referencia_comp=$_POST["txtreferencia_comp"]; $tipo_compromiso=$_POST["txttipo_compromiso"];$cod_comp=$_POST["txtcod_comp"];  $fecha_compromiso=$_POST["txtfecha"];
$referencia_comp_new=$_POST["txtreferencia_comp_new"]; $ced_rif=$_POST["txtced_rif"];$descripcion_comp=$_POST["txtDescripcion"];
$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
if (checkData($fecha_compromiso)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if ($error==0){$sfecha=formato_aaaammdd($fecha_compromiso);
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)) {$error=1; ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
  if($error==0){$sSQL="Select referencia_comp from pre006 WHERE referencia_comp='$referencia_comp_new' and tipo_compromiso='$tipo_compromiso'"; 	
	$resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas>0){$error=1;?><script language="JavaScript">muestra('REFERENCIA NUEVA DE COMPROMISO YA EXISTE');</script><?}
  }
  if($error==0){$sfecha=formato_aaaammdd($fecha_compromiso);
    $sSQL="Select * from pre006 WHERE referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and fecha_compromiso='$sfecha' and cod_comp='$cod_comp'";
    $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE COMPROMISO NO EXISTE');</script><?}
     else{ $registro=pg_fetch_array($resultado);$adescripcion=$registro["descripcion_comp"];$aced_rif=$registro["ced_rif"]; $sfecha=formato_aaaammdd($fecha_compromiso);
       $resultado=pg_exec($conn,"SELECT CAMBIA_PRE006('$referencia_comp_new','$referencia_comp','$tipo_compromiso','$cod_comp','$sfecha')");
       $merror=pg_errormessage($conn);$merror=substr($merror,0,91);        if (!$resultado){$error=1; ?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><? }
        else{?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?
           $desc_doc="CAMBIO REFERENCIA COMPROMISO, TIPO:".$tipo_compromiso.", REFERENCIA ANTERIOR:".$referencia_comp.", REFERENCIA NUEVA:".$referencia_comp_new.", CED/RIF:".$aced_rif.", DESCRIPCION:".$adescripcion;
           $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
           $merror=pg_errormessage($conn);$merror=substr($merror,0,91);if (!$resultado){$error=1; ?><script language="JavaScript"> muestra('<? echo $merror;?>');</script><?}}
     }
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING); if ($error==0){?><script language="JavaScript">document.location ='Act_compromisos.php?Gcriterio=<? echo $tipo_compromiso.$referencia_comp.$cod_comp; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }  ?>