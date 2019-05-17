<?include ("../class/conect.php");  include ("../class/funciones.php");include ("Ver_dispon.php");
$formato_presup="XX-XX-XX-XXX-XX-XX-XX";$codigo_mov=$_POST["txtcodigo_mov"];$cod_presup=$_POST["txtcod_presup"];
$fuente_financ=$_POST["txtcod_fuente"];$monto_c=formato_numero($_POST["txtmonto"]);$monto_c=$_POST["txtmonto"];
$comprometido=$_POST["txtmonto_compromiso"];$tipo_imput_presu=$_POST["txttipo_imput_presu"];$ref_imput_presu=$_POST["txtref_imput_presu"];
$monto_credito=$_POST["txtmonto_credito"];$credito=$_POST["txtcredito"];$cod_contable=$_POST["txtcod_contable"];
$tipo_imput_presu=substr($tipo_imput_presu,0,1);$fecha=asigna_fecha_hoy();$monto_c=formato_numero($monto_c);
if(is_numeric($monto_c)){$monto=$monto_c;} else{$monto=0;} $monto_credito=formato_numero($monto_credito);
if(is_numeric($monto_credito)){$monto_credito=$monto_credito;} else{$monto_credito=0;} $comprometido=formato_numero($comprometido);
if(is_numeric($comprometido)){$comprometido=$comprometido;}else{$comprometido=0;}
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$url="Det_inc_ajustes_caus.php?codigo_mov=".$codigo_mov;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{  $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql);
  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];}  $error=0;
  $sSQL="Select * from PRE026 WHERE codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ' and ref_imput_presu='$ref_imput_presu'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO NO EXISTE EN EL AJUSTE');</script><? }
   else{   $registro=pg_fetch_array($resultado); $referencia_caus=$registro["referencia_caus"];
    $tipo_causado=$registro["tipo_causado"];$referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"];
    if($error==0){ $sSQL="Select * from PRE095 WHERE cod_fuente_financ='$fuente_financ'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE FUENTE NO EXISTE');</script><? }
    }
    if(($error==0)and($monto_c<0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO CODIGO INVALIDO');</script><? }  $monto_credito=0;
    if(($error==0)and($tipo_imput_presu=="C")){ $monto_credito=$monto; }  else{$monto_credito=0;$ref_imput_presu="00000000";$tipo_imput_presu="P";}
    if($error==0){
      $sSQL="Select * from PRE037 WHERE (referencia_caus='$referencia_caus') and (tipo_causado='$tipo_causado') and (referencia_comp='$referencia_comp') and (tipo_compromiso='$tipo_compromiso') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";
      $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO NO EXISTE EN EL CAUSADO');</script><? }
       else{  $registro=pg_fetch_array($resultado);  $compromiso=$registro["monto"]-$registro["pagado"]-$registro["ajustado"]; $balance=$monto_c-$compromiso;
         if(($monto_c>$compromiso)and($balance>0.001)){$error=1; ?> <script language="JavaScript"> muestra('MONTO A AJUSTAR MAYOR AL SALDO DEL CAUSADO');</script><? }
       }
    }
    if($error==0){ $sfecha=formato_aaaammdd($fecha);
      $resultado=pg_exec($conn,"SELECT MODIFICA_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','$referencia_caus','$tipo_causado','','0000','','0000','','','','$cod_contable','','','$sfecha','C','$tipo_imput_presu','$ref_imput_presu','$sfecha',$monto,$comprometido,$monto_credito,$credito)");
      $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61);   if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
    }
  }
}
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>