<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$referencia_comp = $_GET["txtreferencia_comp"];$tipo_compromiso = $_GET["txttipo_compromiso"]; $cod_comp = $_GET["txtcod_comp"];
$url="Act_compromisos.php?Gcriterio=C".$tipo_compromiso.$referencia_comp.$cod_comp;
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from pre006 WHERE referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_comp='$cod_comp'";
  echo $sSQL;
  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);  $fecha_hoy=asigna_fecha_hoy(); 
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE COMPROMISO NO EXISTE');</script><?}
   else{ $registro=pg_fetch_array($resultado); $fecha_compromiso=$registro["fecha_compromiso"];$adescripcion=$registro["descripcion_comp"];
    $aprobado=$registro["aprobado"];  $sfecha=formato_aaaammdd($fecha_hoy); if($aprobado=="S"){$aprobar="D";}else{$aprobar="S";}  
    if($usuario_sia==""){ $error=1;?><script language="JavaScript">muestra('USUARIO NO VALIDO');</script><? }
    else{	
     $resultado=pg_exec($conn,"SELECT APRUEBA_PRE006('$referencia_comp','$tipo_compromiso','$aprobar','$sfecha','$usuario_sia')");  $error=pg_errormessage($conn);$error=substr($error, 0, 61);
     if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      else{?><script language="JavaScript">muestra('APROBO EXITOSAMENTE');</script><? } }
  } 
}pg_close(); error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript">LlamarURL('<?echo $url;?>');</script>
