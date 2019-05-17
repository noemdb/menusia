<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$referencia=$_POST["txtreferencia"]; $tipo_inv=$_POST["txttipo_inv"]; $tipo_inv=substr($tipo_inv,0,1);  $descripcion=$_POST["txtdescripcion"];
$cod_cuenta=$_POST["txtCodigo_Cuenta"]; $fecha_inicio=$_POST["txtfecha_inicio"];  $fecha_vencimiento=$_POST["txtfecha_vencimiento"];
$dias_inv=$_POST["txtdias_inv"];  if(is_numeric($dias_inv)){$dias_inv=$dias_inv;} else{$dias_inv=0;}
$tasa_inv=$_POST["txttasa_inv"]; $tasa_inv=formato_numero($tasa_inv); if(is_numeric($tasa_inv)){$tasa_inv=$tasa_inv;} else{$tasa_inv=0;}
$monto=$_POST["txtmonto_inv"]; $monto=formato_numero($monto); if(is_numeric($monto)){$monto=$monto;} else{$monto=0;}
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR INCLUYENDO....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{ if (checkData($fecha_inicio)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE INICIO NO ES VALIDA');</script><? } }
if($error==0){if (checkData($fecha_vencimiento)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE VENCIMIENTO  NO ES VALIDA');</script><? } }
if($error==0){if(strlen($referencia)==8){$error=0;} else {$error=1; ?> <script language="JavaScript"> muestra('LONGITUD DE REFERENCIA INVALIDA');</script><? } }
if(($error==0)and($monto==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DE MOVIMIENTO INVALIDO');</script><? }
if($error==0){ $sfechai=formato_aaaammdd($fecha_inicio);  $sfechav=formato_aaaammdd($fecha_vencimiento);
  $sSQL="Select * from BAN025 WHERE referencia='$referencia'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas>0){ $error=1; ?>  <script language="JavaScript">  muestra('REFERENCIA DE INVERSION YA EXISTE');  </script> <? }
   else{$error=0;  if($error==0){$sSQL="SELECT ACTUALIZA_BAN025(1,'$referencia','$tipo_inv','$cod_cuenta','$sfechai','$sfechav',$dias_inv,$tasa_inv,$monto,'S','','','$minf_usuario','','',0,0,'$descripcion')"; echo $sSQL; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);$error=substr($error, 0, 61);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}}
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING); if ($error==0){?><script language="JavaScript">document.location='Act_Colocaciones.php?Greferencia=U';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? } ?>
