<?include ("../class/conect.php");  include ("../class/funciones.php");  $tipo_cuenta=$_GET["txttipo_cuenta"];$equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2008-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$error=0;  $sSQL="Select * from ban001 WHERE tipo_cuenta='$tipo_cuenta'";   $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){ $error=1; ?>  <script language="JavaScript">  muestra('TIPO DE CUENTA NO EXISTE');  </script> <? }
   else{$registro=pg_fetch_array($resultado); $adescripcion_tipo=$registro["descripcion_tipo"]; $error=0;
     if($error==0){ $sSQL="Select * from ban002 WHERE tipo_cuenta='$tipo_cuenta'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
       if ($filas>0){$error=1; ?>  <script language="JavaScript">  muestra('TIPO DE CUENTA TIENE BANCO DEFINIDO');  </script> <? }
     }
     if($error==0){$sSQL="SELECT ACTUALIZA_ban001(3,'$tipo_cuenta','','N')";$resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn);$error=substr($error,0,91);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script><?}
         $desc_doc="TIPO DE CUENTA, CODIGO:".$tipo_cuenta.", DESCRIPCION:".$adescripcion_tipo;$resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('02','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
  }
}pg_close();?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>