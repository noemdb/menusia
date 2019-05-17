<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2008-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$cod_movimiento=$_GET["txtcod_movimiento"];$equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$error=0;  $sSQL="Select * from ban015 WHERE cod_movimiento='$cod_movimiento'";   $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){ $error=1; ?>  <script language="JavaScript">  muestra('CODIGO DE MOVIMIENTO NO EXISTE');  </script> <? }
   else{$registro=pg_fetch_array($resultado); $anombre=$registro["descripcion"];  $error=0;     
     if($error==0){$sSQL="SELECT ACTUALIZA_ban015(3,'$cod_movimiento','$cod_movimiento','$anombre','','','','S','','','','','',0,0,'','S','$minf_usuario')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script><?
         $desc_doc="DEFINICION MOVIMIENTO DE FLUJP, CODIGO:".$cod_movimiento.", DESCRIPCION:".$anombre;$resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('02','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }} }
  }
}pg_close();?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>