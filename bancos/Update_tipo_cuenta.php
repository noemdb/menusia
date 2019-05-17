<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL); $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2008-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$tipo_cuenta=$_POST["txttipo_cuenta"]; $des_tipo_cuenta=$_POST["txtdescripcion_tipo"]; $conciliable=$_POST["txtconciliable"];  $conciliable=substr($conciliable,0,1);
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a"); $url="Act_Tipos_Cuentas.php";echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $error=0; $sSQL="Select * from ban001 WHERE tipo_cuenta='$tipo_cuenta'";   $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){ $error=1; ?>  <script language="JavaScript">  muestra('TIPO DE CUENTA NO EXISTE');  </script> <? }
   else{$registro=pg_fetch_array($resultado); $adescripcion_tipo=$registro["descripcion_tipo"];  $error=0;
     if($error==0){ $sSQL="SELECT ACTUALIZA_ban001(2,'$tipo_cuenta','$des_tipo_cuenta','$conciliable')";  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);  $error=substr($error,0,91);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?} else{?><script language="JavaScript">  muestra('MODIFICO EXITOSAMENTE'); </script><?}
         $desc_doc="TIPO DE CUENTA:".$tipo_cuenta.", DESCRIPCION:".$adescripcion_tipo; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('02','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn);$error=substr($error,0,91);if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
   }
}
pg_close();error_reporting(E_ALL ^ E_WARNING); ?><script language="JavaScript">history.back();</script>