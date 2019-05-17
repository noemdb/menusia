<?include ("../class/conect.php");  include ("../class/funciones.php");error_reporting(E_ALL);
$referencia_desin=$_GET["Greferencia_desin"];$fecha_desin=$_GET["Gfecha_desin"]; $des_desin=$_GET["Gdes_desin"];  $statusc="D"; $ced_rif="";
$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); $descripcion="";
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from bien045 WHERE referencia_desin='$referencia_desin'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DEL ACTA DE DESINCORPORACION NO EXISTE');</script><?}
   else{  $registro=pg_fetch_array($resultado);  $tipo_desin=$registro["tipo_desin"];  $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"]; $descripcion=$registro["descripcion"];
     $fecha_desin=$registro["fecha_desin"]; $fecha_desin=formato_ddmmaaaa($fecha_desin);
	 $sql="Select * from bien046 WHERE referencia_desin='$referencia_desin'";   $res=pg_query($sql);
     $total=0;$desc_cod="";  while($registro=pg_fetch_array($res)){   $total=$total+$registro["monto"]; $desc_cod=$desc_cod.", CODIGO BIEN:".$registro["cod_bien_mue"]."  MONTO:".$registro["monto"]; }
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DEL ACTA DE DESINCORPORACION NO EXISTE');</script><?}
   else{ $sfecha=formato_aaaammdd($fecha_desin);
     $sSQL="SELECT actualiza_bien045(3,'','$referencia_desin','$sfecha','','$tipo_desin','','','','','','','','','','','','$campo_str1','$campo_str2','','$usuario_sia','$minf_usuario','',0,'$statusc','$ced_rif')";    
	 $resultado=pg_exec($conn,$sSQL);   $error=pg_errormessage($conn);  $error=substr($error,0,91);
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><? $error=0; 
	    $desc_doc="DESINCORPORACION DE BIENES MUEBLES REEFRENCIA:".$referencia_desin.", TIPO:".$des_desin.", FECHA:".$fecha_desin.", DESCRIPCION:".$descripcion.", TOTAL:".$total; $desc_doc=$desc_doc.$desc_cod;
  	    $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('13','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
        $error=pg_errormessage($conn);   $error=substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }  }
	} 
  }
}
pg_close();
if ($error==0){?><script language="JavaScript"> window.close();window.opener.location.reload(); </script> <? }
?>
