<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$referencia_comp=$_POST["txtreferencia_comp"]; $tipo_compromiso=$_POST["txttipo_compromiso"];$cod_comp="0000";  $cod_comp=$_POST["txtcodigo_comp"];  $fecha_compromiso=$_POST["txtfecha"];$unidad_sol=$_POST["txtunidad_sol"];
$cod_tipo_comp=$_POST["txtcod_tipo_comp"];$ced_rif=$_POST["txtced_rif"];$descripcion_comp=$_POST["txtDescripcion"];$nro_documento=$_POST["txtnro_documento"];
$fecha_vencim=$_POST["txtfecha_vencim"];$num_proyecto=$_POST["txtnum_proyecto"];$func_inv=$_POST["txtfunc_inv"];$func_inv=substr($func_inv,0,1);
$tiene_anticipo=$_POST["txttiene_anticipo"];$tiene_anticipo=substr($tiene_anticipo,0,1);$tasa_anticipo=$_POST["txttasa_anticipo"];$cod_con_anticipo=$_POST["txtCodigo_Cuenta"];
$tasa_anticipo=formato_numero($tasa_anticipo);if(is_numeric($tasa_anticipo)){$tasa_anticipo=$tasa_anticipo;} else{$tasa_anticipo=0;}
$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
if (checkData($fecha_compromiso)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if ($error==0){$sfecha=formato_aaaammdd($fecha_compromiso);
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)) {$error=1; ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
  if($error==0){$sSQL="SELECT tipo_comp FROM pre016 WHERE tipo_comp='$cod_tipo_comp'";$resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('CODIGO TIPO DE COMPROMISO NO EXISTE');</script><?}
  }
  if($error==0){ $sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";$resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('CEDULA/RIF BENEFICIARIO NO EXISTE');</script><?}
  }
  if(($error==0)and($tiene_anticipo=="S")){ $sSQL="Select * from con001 WHERE codigo_cuenta='$cod_con_anticipo'";$resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE DE ANTICIPO NO EXISTE');</script><? }
      else{$registro=pg_fetch_array($resultado);
        if ($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE DE ANTICIPO NO ES CARGABLE');</script><?}
      }
  }else{$cod_con_anticipo="";$tasa_anticipo=0;}
  if($error==0){$sfecha=formato_aaaammdd($fecha_compromiso);
    $sSQL="Select * from pre006 WHERE referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and fecha_compromiso='$sfecha' and cod_comp='$cod_comp'";
    $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE COMPROMISO NO EXISTE');</script><?}
     else{ $registro=pg_fetch_array($resultado);$adescripcion=$registro["descripcion_comp"];$aced_rif=$registro["ced_rif"]; $sfecha=formato_aaaammdd($fecha_compromiso);$fechav=formato_aaaammdd($fecha_vencim);
       $resultado=pg_exec($conn,"SELECT MODIFICA_PRE006('$referencia_comp','$tipo_compromiso','$cod_comp','$sfecha','$cod_tipo_comp','','$nro_documento','$ced_rif','$fechav','$tiene_anticipo','$cod_con_anticipo',0,$tasa_anticipo,0,'P','$descripcion_comp','$minf_usuario')");
       $error=pg_errormessage($conn);$error=substr($error, 0, 61);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
        else{?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?
           $desc_doc="MOV.COMPROMISO: TIPO:".$tipo_compromiso.", REFERENCIA:".$referencia_comp.", CED/RIF:".$aced_rif.", DESCRIPCION:".$adescripcion;
           $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
           $error=pg_errormessage($conn);$error=substr($error, 0, 61);if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error;?>');</script><?}}
     }
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING); if ($error==0){?><script language="JavaScript">document.location ='Act_compromisos.php?Gcriterio=<? echo $tipo_compromiso.$referencia_comp.$cod_comp; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }  ?>