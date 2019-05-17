<?include ("../class/conect.php");  include ("../class/funciones.php");error_reporting(E_ALL); $referencia=$_GET["Greferencia"];  $statusc="D"; $ced_rif=""; $codigo_mov="";
$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); $descripcion=""; echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from bien043 WHERE referencia='$referencia'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA ORDEN DE SALIDA NO EXISTE');</script><?}
   else{ $registro=pg_fetch_array($resultado);   $fecha=$registro["fecha"]; $sfecha=$registro["fecha"]; $tipo_salida=$registro["tipo_salida"];
      $descripcion=$registro["descripcion"];  $cod_dependencia=$registro["cod_dependencia"]; 
      $cargo1=""; $nombre1="";$departamento1=""; $cargo2=""; $nombre2="";$departamento2=""; $num_tipo_salida="1"; $des_tipo_salida="";
   }
  if ($error==0){  $sql="Select * from bien044 WHERE referencia='$referencia'";   $res=pg_query($sql);   $total=0;$desc_cod="";
     while($registro=pg_fetch_array($res)){  $total=$total+$registro["monto"]; $desc_cod=$desc_cod.", CODIGO BIEN:".$registro["cod_bien_mue"]."  MONTO:".$registro["monto"];     }
	 $sSQL="SELECT ACTUALIZA_BIEN043(3,'$codigo_mov','$referencia','$sfecha','$cod_dependencia','$tipo_salida','N','N','$sfecha','$cargo1','$departamento1','$nombre1','$cargo2','$departamento2','$nombre2','','','','$usuario_sia','$minf_usuario','$descripcion')";  $resultado=pg_exec($conn,$sSQL);
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><? $error=0; 
	    if($fecha_transf==""){$fecha_transf="";}else{$fecha_m=formato_ddmmaaaa($fecha);}
		$desc_doc="ORDEN DE SALIDA BIENES MUEBLES REEFRENCIA:".$referencia.", FECHA:".$fecha_m.", DESCRIPCION:".$descripcion.", TOTAL:".$total; $desc_doc=$desc_doc.$desc_cod;
  	    $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('13','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
        $error=pg_errormessage($conn);   $error=substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }
	 }
  }
} pg_close(); 
if ($error==0){?><script language="JavaScript"> window.close();window.opener.location.reload(); </script> <? }
?>