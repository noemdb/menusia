<?include ("../class/conect.php");  include ("../class/funciones.php");error_reporting(E_ALL);
$referencia=$_GET["Greferencia"];$fecha=$_GET["Gfecha"];  $statusc="D"; $ced_rif="";
$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); $descripcion="";
echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from bien025 WHERE referencia='$referencia' and fecha='$fecha'";
  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE MOVIMIENTO NO EXISTE');</script><?}
   else{  $registro=pg_fetch_array($resultado); $cod_dependencia=$registro["cod_dependencia"]; $gen_comp=$registro["gen_comp"];
       $descripcion=$registro["descripcion"]; $sfecha=$registro["fecha"]; $status=$registro["status"]; }
  if ($error==0){ if($status=="D"){ $error=1;?><script language="JavaScript">muestra('MOVIMIENTO DEBE SER ELIMINADO POR DESINCORPORACION');</script><? } }
  if ($error==0){ 
     $sql="Select * from bien040 WHERE referencia='$referencia' and fecha='$fecha'";   $res=pg_query($sql);   $total=0;$desc_cod="";
     while($registro=pg_fetch_array($res)){
       $total=$total+$registro["monto"]; $desc_cod=$desc_cod.", CODIGO BIEN:".$registro["cod_bien_mue"]."  MONTO:".$registro["monto"]." TIPO MOVIMIENTO:".$registro["tipo_movimiento"];
     }
     $sfecha=formato_aaaammdd($fecha);
     $resultado=pg_exec($conn,"SELECT actualiza_bien025(3,'','$referencia','$sfecha','$cod_dependencia','$gen_comp','N','N','$sfecha',0,'$minf_usuario','$descripcion','$statusc','$ced_rif')"); $error=pg_errormessage($conn);  $error=substr($error,0,91);
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><? $error=0; 
	    $desc_doc="MOVIMIENTO DE BIENES MUEBLES REEFRENCIA:".$referencia.", FECHA:".$fecha_desin.", DESCRIPCION:".$descripcion.", TOTAL:".$total; $desc_doc=$desc_doc.$desc_cod;
  	    $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('13','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
        $error=pg_errormessage($conn);   $error=substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }
	 }
  }
}
pg_close(); if ($error==0){?><script language="JavaScript"> window.close();window.opener.location.reload(); </script> <? }?>
