<?include ("../class/conect.php");  include ("../class/funciones.php");$cod_informe=$_GET["txtcod_informe"]; echo "ESPERE POR FAVOR ELIMINANDO....";  $fecha_hoy=asigna_fecha_hoy();
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script>  <?}
 else{  $sSQL="Select * from con005 WHERE cod_informe='$cod_informe'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){?> <script language="JavaScript">  muestra('CODIGO DE NO EXISTE'); </script> <? }
   else{  $registro=pg_fetch_array($resultado,0); $cod_informe=$registro["cod_informe"]; $nombre_informe=$registro["nombre_informe"];    
     $resultado=pg_exec($conn,"SELECT ACTUALIZA_CON005(3,'$cod_informe','','')");   $error=pg_errormessage($conn);     $error=substr($error,0,91);
     if (!$resultado){?><script language="JavaScript">  muestra('<? echo $error; ?>');  </script><? }  
	 else{  ?><script language="JavaScript"> muestra('ELIMINO EXITOSAMENTE'); </script>  <? $sfecha=formato_aaaammdd($fecha_hoy);
	    $desc_doc="DEFINICION INFORME CONTABLE, CODIGO INFORME:".$tipo_informe.", DESCRPCION:".$nombre_informe;   $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('03','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
        $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <?}
	 }
  }
}
pg_close();?><script language="JavaScript">window.close(); window.opener.location.reload();</script>