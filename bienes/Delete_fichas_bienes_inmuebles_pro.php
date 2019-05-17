<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_bien_inm=$_GET["Gcod_bien_inm"];  $equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$sSQL="SELECT * From BIEN014 where cod_bien_inm='$cod_bien_inm'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE BIEN MUEBLE NO EXISTE');</script> <? }
    else { $registro=pg_fetch_array($resultado);  $cod_clasificacion=$registro["cod_clasificacion"];  $num_bien=$registro["num_bien"]; $desincorporado=$registro["desincorporado"]; 
        $denominacion=$registro["denominacion"];   $cod_dependencia=$registro["cod_dependencia"];  $tipo_incorporacion=$registro["tipo_incorporacion"];   $cod_imp_presup=$registro["cod_imp_presup"]; 
        $valor_incorporacion=$registro["valor_incorporacion"]; $codigo_tipo_incorp=$registro["codigo_tipo_incorp"];  $fecha_incorporacion=$registro["fecha_incorporacion"]; 
        if($fecha_incorporacion==""){$fecha_incorporacion="";}else{$fecha_incorporacion=formato_ddmmaaaa($fecha_incorporacion);} }
  if ($error==0){ $sSQL="SELECT cod_bien_inm From BIEN041 where cod_bien_inm='$cod_bien_inm'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE BIEN MUEBLE TIENE MOVIMIENTOS');</script> <? }
  }
  if ($error==0){ $sSQL="SELECT cod_bien_inm From BIEN048 where cod_bien_inm='$cod_bien_inm'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE BIEN MUEBLE TIENE DEPRECIACION REGISTRADA');</script> <? }
  }
  if ($error==0){$resultado=pg_exec($conn,"SELECT ELIMINA_BIEN014 ('$cod_bien_inm')"); $error=pg_errormessage($conn);  $error=substr($error,0,91);
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><? $error=0; 
	     $sfecha=formato_aaaammdd($fecha_incorporacion);
	     $desc_doc="FICHA DE BIEN INMUEBLE:  CODIGO BIEN:".$cod_bien_inm.", DENOMINACION:".$denominacion.", FECHA INCORPORACION:".$fecha_incorporacion.", VALOR INCORPORACION:".$valor_incorporacion.", CODIGO TIPO INCORPORACION:".$codigo_tipo_incorp;
         $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('13','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn);   $error=substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
  }
}
pg_close(); if ($error==0){?><script language="JavaScript"> window.close();window.opener.location.reload(); </script> <? }?>
