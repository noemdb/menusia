<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL); $criterio=$_GET["criterio"]; $nro_comprobante=substr($criterio,6,8);  $ano_fiscal=substr($criterio,0,4);  $mes_fiscal=substr($criterio,4,2);
echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;  $equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2014-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sql="Select nro_comprobante from BAN027 where ano_fiscal='$ano_fiscal' and  mes_fiscal='$mes_fiscal' and nro_comprobante='$nro_comprobante'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
   if ($filas==0){$error=1; echo $sql; ?> <script language="JavaScript"> muestra('NUMERO DE COMPROBANTE NO EXISTE');</script><? }
    else{$sSQL="SELECT ELIMINA_BAN027('$ano_fiscal','$mes_fiscal','$nro_comprobante')";  $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error="ERROR ELIMINANDO: ".substr($error,0,91);
        if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?
		  $desc_doc="COMPROBANTE RETENCION IVA, NRO COMPROBANTE:".$nro_comprobante.", MES:".$mes_fiscal.", PERIODO:".$ano_fiscal; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('02','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
          $Merror=pg_errormessage($conn); $Merror=substr($error,0,91);  if (!$resultado){$error=1;?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }
		}
    }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>