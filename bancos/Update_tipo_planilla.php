<?include ("../class/conect.php");  include ("../class/funciones.php");  error_reporting(E_ALL);
$codigo=$_POST["txtcodigo"]; $descripcion=$_POST["txtdescripcion"]; $nro_planilla="00000000"; $formato_planilla=$_POST["txtformato_planilla"]; $formato_relacion=$_POST["txtformato_relacion"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";$error=0; $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2008-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $url="Act_Tipo_Planillas.php?Gcodigo=C".$codigo;
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  $sSQL="Select * from ban011 WHERE codigo='$codigo'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){ $error=1; ?>  <script language="JavaScript">  muestra('TIPO DE PLANILLA NO EXISTE');  </script> <? }
   else{$registro=pg_fetch_array($resultado); $adescripcion_tipo=$registro["descripcion"].", FORMATO:".$registro["formato_planilla"]; $error=0;  if($error==0){$sSQL="SELECT ACTUALIZA_BAN011(2,'$codigo','$descripcion','$nro_planilla','$formato_planilla','$formato_relacion')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);$error=substr($error,0,91);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE'); </script><?} 
         $desc_doc="TIPO DE PLANILLA:".$codigo.", DESCRIPCION:".$adescripcion_tipo; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('02','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')"); $error=pg_errormessage($conn);$error=substr($error,0,91);if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING); if ($error==0){?><script language="JavaScript">document.location='Act_Tipo_Planillas.php?Gcodigo=C<?echo $codigo?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>