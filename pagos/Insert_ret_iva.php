<?include ("../class/conect.php");  include ("../class/funciones.php");
$formato_presup="XX-XX-XX-XXX-XX-XX-XX"; $codigo_mov=$_POST["txtcodigo_mov"]; $tipo_retencion=$_POST["txttipo_retencion"];
$tasa_retencion=$_POST["txttasa"];$monto_objeto=0;$monto_retencion=0;
$ced_rif=$_POST["txtced_rif"]; $nombre=$_POST["txtnombre"]; $des_orden_ret=$_POST["txtdes_orden_ret"];
$tipo_compromiso="0000";$referencia_comp="00000000";$fuente_financ="00"; $cod_presup=""; $cod_part_iva="403-18-01";
$fecha=asigna_fecha_hoy();$tasa_retencion=formato_numero($tasa_retencion);
if(is_numeric($tasa_retencion)){$tasa_retencion=$tasa_retencion;} else{$tasa_retencion=0;}
$equipo = getenv("COMPUTERNAME"); $MInf_Usuario = $equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR INCLUYENDO....","<br>";$error=0;
if ($tasa_retencion==0) {$error=1; ?> <script language="JavaScript"> muestra('TASA DE LA RETENCION INVALIDA');</script><? }
$url="Det_inc_ret_orden.php?codigo_mov=".$codigo_mov."&bloqueada=N";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{  $sql="Select * from SIA005 where campo501='05'";
  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];}
  if($error==0){
  $sSQL="Delete from PAG028 WHERE codigo_mov='$codigo_mov' and tipo_retencion='$tipo_retencion'";
  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
  if($error==0){
    $sql="Select cod_presup,fuente_financ,referencia_comp,tipo_compromiso,cod_con_g_pagar,sum(monto) as monto from CODIGOS_PRE026 where (codigo_mov='$codigo_mov') and (monto>0) and (cod_presup LIKE '%$cod_part_iva%') group by cod_presup,fuente_financ,referencia_comp,tipo_compromiso,cod_con_g_pagar"; 
	$res=pg_query($sql); //echo $sql;
    while(($registro=pg_fetch_array($res))){
      $monto_objeto=$registro["monto"];  $codigo_cuenta=$registro["cod_con_g_pagar"];
      $referencia_comp=$registro["referencia_comp"];  $tipo_compromiso=$registro["tipo_compromiso"];
      $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"];
      $monto_retencion=$monto_objeto*($tasa_retencion/100); $monto_retencion=cambia_coma_numero($monto_retencion); $cod_contable="";
      $sSQL="Select * from PAG003 WHERE tipo_retencion='$tipo_retencion'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE RETENCION NO EXISTE');</script><? }
      else {$reg=pg_fetch_array($resultado); $cod_contable=$reg["cod_contable"];}
      if($error==0){ $sfecha=formato_aaaammdd($fecha);
        $sSQL="SELECT ACTUALIZA_PAG028(1,'$codigo_mov','00000000','$tipo_retencion','$referencia_comp','$tipo_compromiso','$cod_presup','$fuente_financ','00000000','0000','$cod_contable',$tasa_retencion,$monto_objeto,$monto_retencion,0,'R','$ced_rif','$nombre','S','0000','0000','$des_orden_ret')";  echo $sSQL;
        $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      }
    }
  } }
}
pg_close(); 
/* */
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }

?>
