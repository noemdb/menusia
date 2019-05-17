<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);  $cod_grupob=$_GET["txtcodigo_grupo"]; $nombre_grupob="";
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a");  echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0; $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2008-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  $sSQL="Select * from ban022 WHERE cod_grupob='$cod_grupob'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){ $error=1; ?>  <script language="JavaScript">  muestra('GRUPO DE BANCO NO EXISTE');  </script> <? }
   else{$registro=pg_fetch_array($resultado); $adescripcion_tipo=$registro["nombre_grupob"];  $error=0;
     if($error==0){ $sSQL="Select * from ban002 WHERE campo_str2='$cod_grupob'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
       if ($filas>0){$error=1; ?>  <script language="JavaScript">  muestra('GRUPO DE BANCO TIENE BANCO DEFINIDO');  </script> <? }
     }
     if($error==0){ $sSQL="SELECT ACTUALIZA_BAN022(3,'$cod_grupob','$nombre_grupob')";  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);$error=substr($error,0,91);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE'); </script><?}
         $desc_doc="GRUPO DE BANCO:".$cod_grupob.", DENOMINACION:".$adescripcion_tipo; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('02','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')"); $error=pg_errormessage($conn);$error=substr($error,0,91);if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>