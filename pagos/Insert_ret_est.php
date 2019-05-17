<?include ("../class/conect.php");  include ("../class/funciones.php"); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
$codigo_mov=$_POST["txtcodigo_mov"]; $tipo_retencion=$_POST["txttipo_retencion"];$tasa_retencion=$_POST["txttasa"]; $monto_objeto=$_POST["txtmonto_objeto"];
$monto_retencion=$_POST["txtmonto_retencion"]; $cod_ret=$_POST["txtcod_ret"];$ced_rif=$_POST["txtced_rif"];$nombre=$_POST["txtnombre"]; $des_orden_ret=$_POST["txtdes_orden_ret"];
$tipo_compromiso=substr($cod_ret,0,4); $referencia_comp=substr($cod_ret,5,8);$fuente_financ=substr($cod_ret,14,2);$cod_presup=substr($cod_ret,17,32); $fecha=asigna_fecha_hoy();
$tasa_retencion=formato_numero($tasa_retencion); if(is_numeric($tasa_retencion)){$tasa_retencion=$tasa_retencion;} else{$tasa_retencion=0;}
$monto_objeto=formato_numero($monto_objeto); if(is_numeric($monto_objeto)){$monto_objeto=$monto_objeto;} else{$monto_objeto=0;}
$monto_retencion=formato_numero($monto_retencion);if(is_numeric($monto_retencion)){$monto_retencion=$monto_retencion;} else{$monto_retencion=0;}
$equipo = getenv("COMPUTERNAME"); $MInf_Usuario = $equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Det_inc_ret_est.php?codigo_mov=".$codigo_mov;  $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql);  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];}
  $sSQL="Select * from PAG028 WHERE codigo_mov='$codigo_mov' and tipo_retencion='$tipo_retencion' and ref_comp_ret='$referencia_comp' and tipo_comp_ret='$tipo_compromiso' and cod_presup_ret='$cod_presup' and fuente_fin_ret='$fuente_financ'";
  $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('RETENCION YA EXISTE EN LA ESTRUCTURA');</script><? }
   else{ $sSQL="Select * from PRE026 WHERE codigo_mov='$codigo_mov' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ'";
    $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
    if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO PRESUPUESTARIO NO EXISTE EN LA ESTRUCTURA');</script><? }
    if($error==0){$sSQL="Select * from PRE099 WHERE ced_rif='$ced_rif'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CEDULA/RIF DE BENEFICIARIO NO EXISTE');</script><? }
       else{$registro=pg_fetch_array($resultado); $nombre=$registro["nombre"];}
    }
    if($error==0){$sSQL="Select * from PAG003 WHERE tipo_retencion='$tipo_retencion'";
      $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE RETENCION NO EXISTE');</script><? }
    }
    if($error==0){$sfecha=formato_aaaammdd($fecha);  $sSQL="SELECT ACTUALIZA_PAG028(1,'$codigo_mov','00000000','$tipo_retencion','$referencia_comp','$tipo_compromiso','$cod_presup','$fuente_financ','00000000','0000','',$tasa_retencion,$monto_objeto,$monto_retencion,0,'R','$ced_rif','$nombre','S','0000','0000','$des_orden_ret')";
      $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);$error="ERROR GRABANDO: ".substr($error, 0, 61);if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } }
  }
}
pg_close();if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? } ?>