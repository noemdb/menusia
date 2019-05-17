<?include ("../class/conect.php");  include ("../class/funciones.php");error_reporting(E_ALL);
$referencia_transf=$_GET["Greferencia_transf"];  $statusc="D"; $ced_rif=""; $codigo_mov="";
$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); $descripcion="";
echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from bien036 WHERE referencia_transf='$referencia_transf'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE MOVIMIENTO NO EXISTE');</script><?}
   else{ $registro=pg_fetch_array($resultado);   $fecha_transf=$registro["fecha_transf"]; $sfecha=$registro["fecha_transf"];
		$tipo_transferencia=$registro["tipo_transferencia"];  $cod_dependencia_r=$registro["cod_dependencia_r"]; $cod_empresa_r=$registro["cod_empresa_r"]; $cod_direccion_r=$registro["cod_direccion_r"]; 
		$cod_departamento_r=$registro["cod_departamento_r"]; $tipo_movimiento_r=$registro["tipo_movimiento_r"];  $cod_dependencia_e=$registro["cod_dependencia_e"];$cod_empresa_e=$registro["cod_empresa_e"]; 
		$cod_direccion_e=$registro["cod_direccion_e"];  $cod_departamento_e=$registro["cod_departamento_e"];  $tipo_movimiento_e=$registro["tipo_movimiento_e"]; $ced_responsable=$registro["ced_responsable"]; 
		$ced_responsable_uso=$registro["ced_responsable_uso"]; $ced_rotulador=$registro["ced_rotulador"]; $ced_verificador=$registro["ced_verificador"]; $departamento_r=$registro["departamento_r"]; 
		$nombre_r=$registro["nombre_r"]; $departamento_e=$registro["departamento_e"]; $nombre_e=$registro["nombre_e"]; $cargo1=$registro["cargo1"];$departamento1=$registro["departamento1"];  $nombre1=$registro["nombre1"]; 
		$referencia_mov_e=$registro["referencia_mov_e"]; $referencia_mov_r=$registro["referencia_mov_r"]; $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"];$observacion=$registro["observacion"]; 
		$inf_usuario=$registro["inf_usuario"];$descripcion=$registro["descripcion"];   
  }
  if ($error==0){  $sql="Select * from bien037 WHERE referencia_transf='$referencia_transf'";   $res=pg_query($sql);   $total=0;$desc_cod="";
     while($registro=pg_fetch_array($res)){
       $total=$total+$registro["monto"]; $desc_cod=$desc_cod.", CODIGO BIEN:".$registro["cod_bien_mue"]."  MONTO:".$registro["monto"];
     }
     $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN036(3,'$codigo_mov','$referencia_transf','$sfecha','$tipo_transferencia','$cod_dependencia_r','$cod_empresa_r','$cod_direccion_r','$cod_departamento_r','$tipo_movimiento_r','$cod_dependencia_e','$cod_empresa_e','$cod_direccion_e','$cod_departamento_e','$tipo_movimiento_e','$ced_responsable','$ced_responsable_uso','','','$departamento_r','$nombre_r','$departamento_e','$nombre_e','','$departamento1','$nombre1','00000000','00000000','','','','$usuario_sia','$inf_usuario','$descripcion','$statusc','$ced_rif')");
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><? $error=0; 
	    if($fecha_transf==""){$fecha_transf="";}else{$fecha_transf=formato_ddmmaaaa($fecha_transf);}
		$desc_doc="TRANSFERENCIA DE BIENES MUEBLES REEFRENCIA:".$referencia_transf.", FECHA:".$fecha_transf.", DESCRIPCION:".$descripcion.", TOTAL:".$total; $desc_doc=$desc_doc.$desc_cod;
  	    $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('13','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
        $error=pg_errormessage($conn);   $error=substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }
	 }
  }
} pg_close(); 
if ($error==0){?><script language="JavaScript"> window.close();window.opener.location.reload(); </script> <? }
?>
