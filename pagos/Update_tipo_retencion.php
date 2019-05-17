<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$tipo_retencion=$_POST["txttipo_retencion"];$descripcion_ret=$_POST["txtdescripcion_ret"];  $cod_fondo=$_POST["txtcod_fondo"];
$tasa=$_POST["txttasa"];$r_grupo=$_POST["txtret_grupo"];$cod_contable=$_POST["txtCodigo_Cuenta"];$ced_rif=$_POST["txtced_rif"]; $base_imponible=$_POST["txtbase_imponible"];
$pago_mayor=$_POST["txtpago_mayor"];$sustraendo=$_POST["txtsustraendo"];$red_operacion=$_POST["txtred_operacion"];
$status_1=$_POST["txtstatus_1"];$status_2=$_POST["txtstatus_2"];
$red_operacion=substr($red_operacion,0,1);$status_1=substr($status_1,0,1);$status_2=substr($status_2,0,1); $ret_grupo="O";
if($r_grupo=="IVA"){$ret_grupo="A";} else{   if($r_grupo=="ACT ECONOMICA"){$ret_grupo="E";} else{ $ret_grupo=substr($r_grupo,0,1); } }
$monto=formato_numero($tasa); if(is_numeric($monto)){$tasa=$monto;} else{$tasa=0;}  $cod_fondo=Rellenarcerosizq($cod_fondo,3); 
$monto=formato_numero($base_imponible);if(is_numeric($monto)){$base_imponible=$monto;} else{$base_imponible=0;}
$monto=formato_numero($pago_mayor); if(is_numeric($monto)){$pago_mayor=$monto;} else{$pago_mayor=0;}
$monto=formato_numero($sustraendo); if(is_numeric($monto)){$sustraendo=$monto;} else{$sustraendo=0;}
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a");$url="Mod_tipo_retencion.php?Gtipo_retencion=".$tipo_retencion;
echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $error=0;  $sSQL="Select * from PAG003 WHERE tipo_retencion='$tipo_retencion'";
  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);  if ($filas==0){ $error=1; ?>  <script language="JavaScript">  muestra('TIPO DE RETENCION NO EXISTE');  </script> <? }
   else{ $registro=pg_fetch_array($resultado); $adescripcion_ret=$registro["descripcion_ret"]; $acod_contable=$registro["cod_contable"];
     $sSQL="Select * from con001 WHERE codigo_cuenta='$cod_contable'"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE NO EXISTE');</script><? }
      else{$registro=pg_fetch_array($resultado);if ($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE NO ES CARGABLE');</script><?}
     }
     if($error==0){$sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";
        $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if ($filas==0){$error=1;?><script language="JavaScript">muestra('CÉDULA/RIF BENEFICIARIO NO EXISTE');</script><?}
     }
     if($error==0){$fecha=asigna_fecha_hoy(); $sfecha=formato_aaaammdd($fecha);
       $sSQL="SELECT ACTUALIZA_PAG003(2,'$tipo_retencion','$descripcion_ret','R','$ret_grupo','$cod_contable','$cod_fondo','$ced_rif',$tasa,$base_imponible,$pago_mayor,$sustraendo,'$red_operacion','$status_1','$status_2',0,0,'$MInf_Usuario')";
       $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn);$error=substr($error,0,91);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}
        else{?><script language="JavaScript">  muestra('MODIFICO EXITOSAMENTE'); </script><?}
         $desc_doc="TIPO DE RETENCION:".$tipo_retencion.", DESCRIPCION:".$adescripcion_ret.", CODIGO CUENTA:".$acod_contable;
         $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('01','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn);$error=substr($error,0,91);if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
    }
}
pg_close();error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript">history.back();</script>