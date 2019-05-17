<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();   $error=0;
$$tipo_informe=$_GET["tipo_informe"];$linea=$_GET["linea"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $url="Det_inc_inf_contables.php?criterio=".$tipo_informe;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select * from CON006 WHERE tipo_informe='$tipo_informe' and linea='$linea'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('LINEA DE ARCHIVO NO EXISTE');</script><? }
    else{ $registro=pg_fetch_array($resultado,0); $linea=$registro["linea"]; $codigo_cuenta=$registro["codigo_cuenta"]; $cod_cuenta=$registro["cod_cuenta"];
          $calculable=$registro["calculable"];$moperacion=$registro["moperacion"]; }
   if($error==0){$sSQL="SELECT ACTUALIZA_CON006(3,'$tipo_informe','$linea','','','','','','','','')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}
	 else{ $error=0;?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><? $sfecha=formato_aaaammdd($fecha_hoy);
	    $desc_doc="DEFINICION INFORME CONTABLE, CODIGO INFORME:".$tipo_informe.", LINEA:".$linea.",  CUENTA CONTABLE :".$codigo_cuenta.", OPERACION:".$moperacion;   $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('03','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
        $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <?}
	 }
  }
}pg_close();
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>