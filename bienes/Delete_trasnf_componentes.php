<?include ("../class/conect.php");  include ("../class/funciones.php");error_reporting(E_ALL);
$referencia_transf=$_GET["Greferencia_transf_c"];  $statusc="D"; $ced_rif=""; $codigo_mov="";
$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); $descripcion="";
echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN054 where referencia_transf_c='$referencia_transf'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE MOVIMIENTO NO EXISTE');</script><?}
   else{ $registro=pg_fetch_array($resultado);  $sfecha=$registro["fecha_transf_c"]; $fecha_transf=$registro["fecha_transf_c"];  $tipo_transferencia=$registro["tipo_transferencia_c"]; $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"];$descripcion=$registro["descripcion"];  }
  if ($error==0){  $sql="Select * from bien057 WHERE referencia_transf_c='$referencia_transf'";   $res=pg_query($sql);   $total=0;$desc_cod="";
     while($registro=pg_fetch_array($res)){
        $desc_cod=$desc_cod.", CODIGO BIEN EMISOR:".$registro["cod_bien_mue"]."  COMPONENTE:".$registro["campo_str1"].", CODIGO BIEN RECEPTOR:".$registro["cod_bien_mue_r"];
     }
	 $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN054(3,'$codigo_mov','$referencia_transf','$sfecha','$tipo_transferencia','','','','','','','','','','$usuario_sia','$minf_usuario','$descripcion')");
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><? $error=0; 
	    if($fecha_transf==""){$fecha_transf="";}else{$fecha_transf=formato_ddmmaaaa($fecha_transf);}
		$desc_doc="TRANSFERENCIA DE COMPONENETES REFRENCIA:".$referencia_transf.", FECHA:".$fecha_transf.", DESCRIPCION:".$descripcion; $desc_doc=$desc_doc.$desc_cod;
  	    $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('13','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
        $error=pg_errormessage($conn);   $error=substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }
	 }
  }
} pg_close(); 
if ($error==0){?><script language="JavaScript"> window.close();window.opener.location.reload(); </script> <? }
?>
