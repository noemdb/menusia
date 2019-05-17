<?include ("../class/conect.php");  include ("../class/funciones.php"); ("Ver_dispon.php"); include ("../class/configura.inc");
error_reporting(E_ALL);$formato_presup="XX-XX-XX-XXX-XX-XX-XX"; $codigo_mov=$_POST["txtcodigo_mov"];
$referencia_ajuste=$_POST["txtreferencia_ajuste"];$tipo_ajuste=$_POST["txttipo_ajuste"];
$referencia_pago=$_POST["txtreferencia_pago"];$tipo_pago=$_POST["txttipo_pago"];
$referencia_caus=$_POST["txtreferencia_caus"];$tipo_causado=$_POST["txttipo_causado"];
$referencia_comp=$_POST["txtreferencia_comp"];$tipo_compromiso=$_POST["txttipo_compromiso"];
$fecha_ajuste=$_POST["txtfecha"];$ced_rif=$_POST["txtced_rif"];$descripcion_ajuste=$_POST["txtdescrip_aju"];
$refierea=$_POST["txtrefiereA"];$equipo = getenv("COMPUTERNAME");
$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
$tipo_ajuste_p="0003";$tipo_ajuste_a="0002";$tipo_ajuste_c="0001";echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (checkData($fecha_ajuste)=='1'){$error=0;}
else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if ($error==0){ $sfecha=formato_aaaammdd($fecha_ajuste);  $rfecha=$sfecha;
  $conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICIÒN ABIERTA');</script><?}
  if($error==0){    $l_cat=0;
    $sql="Select * from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];$l_cat=strlen($formato_cat); if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];} }
  }
  if($error==0){    $sSQL="Select * from pre005 WHERE tipo_ajuste='$tipo_ajuste'";    $resultado=pg_exec($conn,$sSQL);
    $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE AJUSTE NO EXISTE');</script><?}
     else{if(($tipo_ajuste=="0000")or(substr($tipo_ajuste,0,1)=='A')){$error=1;?><script language="JavaScript">  muestra('DOCUMENTO DE AJUSTE NO VALIDO');</script><?}
      else{ $registro=pg_fetch_array($resultado);
        if($refierea==$registro["refierea"]){$error;} else{ echo $refiere,' ',$registro["refierea"]; $error=1;?><script language="JavaScript">muestra('DOCUMENTO DE AJUSTE NO VALIDO');</script><?}
      }}
    $sSQL="Select * from pre005 WHERE refierea='COMPROMISO'";    $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE AJUSTE A COMPROMISO NO EXISTE');</script><?}
      else{ $registro=pg_fetch_array($resultado); $tipo_ajuste_c=$registro["tipo_ajuste"]; }
    $sSQL="Select * from pre005 WHERE refierea='CAUSADO'";    $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE AJUSTE A CAUSADO NO EXISTE');</script><?}
      else{ $registro=pg_fetch_array($resultado); $tipo_ajuste_a=$registro["tipo_ajuste"]; }
    $sSQL="Select * from pre005 WHERE refierea='PAGO'";    $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE AJUSTE A PAGO NO EXISTE');</script><?}
      else{ $registro=pg_fetch_array($resultado); $tipo_ajuste_p=$registro["tipo_ajuste"]; }
  }
  if($error==0){ $anulado="N";
    if($refierea=="COMPROMISO"){
      $sSQL="Select * from pre006 WHERE tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' and tipo_compromiso<>'0000'";
      $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
      if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE COMPROMISO NO EXISTE');</script><?}
       else{$registro=pg_fetch_array($resultado); $rfecha=$registro["fecha_compromiso"];$anulado=$registro["anulado"];
         if($anulado=='S'){$error=1;?><script language="JavaScript">muestra('COMPROMISO ESTA ANULADO');</script><?}
       }
    }
    if($refierea=="CAUSADO"){$sSQL="Select * from pre007 WHERE referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' and tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' and tipo_causado<>'0000'";
      $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
      if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE CAUSADO NO EXISTE');</script><?}
         else{ $registro=pg_fetch_array($resultado); $rfecha=$registro["fecha_causado"]; $anulado=$registro["anulado"];
           if($anulado=='S'){$error=1;?><script language="JavaScript">muestra('CAUSADO ESTA ANULADO');</script><?}
         }
    }
    if($refierea=="PAGO"){ $sSQL="Select * from pre008 WHERE tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' and tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' and tipo_pago<>'0000'";
      $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
      if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE PAGO NO EXISTE');</script><?}
         else{$registro=pg_fetch_array($resultado); $rfecha=$registro["fecha_pago"]; $anulado=$registro["anulado"];
           if($anulado=='S'){$error=1;?><script language="JavaScript">muestra('PAGO ESTA ANULADO');</script><?}
         }
    }
  }
  if($error==0){
    $sSQL="Select * from pre011 WHERE referencia_ajuste='$referencia_ajuste' and tipo_ajuste='$tipo_ajuste' and tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' and tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'";
    $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
    if ($filas>0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE AJUSTE YA EXISTE');</script><?}
  }
  if($error==0){
    $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);    $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
    if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)or($sfecha<$rfecha)){$error=1;?><script language="JavaScript">muestra('FECHA DE AJUSTE INVALIDA');</script><?}
  }
  if($error==0){$nmes=substr($fecha_ajuste,3, 2);
    if ($SIA_Periodo>$nmes){echo "Ultimo Periodo: ".$SIA_Periodo." Periodo del Ajuste: ".$nmes; $error=1;?><script language="JavaScript">muestra('FECHA DE AJUSTE MENOR A ULTIMO PERIODO CERRADO');</script><?}
  }
  if($error==0){$sql="Select * from CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup";    $res=pg_query($sql);
    $total=0;   $sfecha=formato_aaaammdd($fecha_ajuste);
    while(($registro=pg_fetch_array($res))and($error==0)){
      $total=$total+$registro["monto"];$cod_presup=$registro["cod_presup"];$fuente_financ=$registro["fuente_financ"];
      $monto_c=$registro["monto"];$ref_imput_presu=$registro["ref_imput_presu"];$tipo_imput_presu=$registro["tipo_imput_presu"];
      if($refierea=="COMPROMISO"){
        $sSQL="Select * from PRE036 WHERE (ref_imput_presu='$ref_imput_presu') and (referencia_comp='$referencia_comp') and (tipo_compromiso='$tipo_compromiso') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";
        $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
        if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('NO EXISTE EN EL COMPROMISO EL CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?>');</script><?}
         else{ $registro=pg_fetch_array($resultado);  $compromiso=$registro["monto"]-$registro["pagado"]-$registro["ajustado"]; $balance=$monto_c-$compromiso;
           if(($monto_c>$compromiso)and($balance>0.009)){$error=1; ?> <script language="JavaScript"> muestra('MONTO A PAGAR MAYOR AL MONTO DEL CÓDIGO DEL COMPROMISO POR AJUSTAR');</script><? }
         }
      }
      if($refierea=="CAUSADO"){
        $sSQL="Select * from PRE037 WHERE (ref_imput_presu='$ref_imput_presu') and (referencia_caus='$referencia_caus') and (tipo_causado='$tipo_causado') and (referencia_comp='$referencia_comp') and (tipo_compromiso='$tipo_compromiso') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";
        $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
        if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('NO EXISTE EN EL CAUSADO EL CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?>');</script><?}
         else{  $registro=pg_fetch_array($resultado);    $compromiso=$registro["monto"]-$registro["pagado"]-$registro["ajustado"]; $balance=$monto_c-$compromiso;
           if(($monto_c>$compromiso)and($balance>0.009)){$error=1; ?> <script language="JavaScript"> muestra('MONTO A PAGAR MAYOR AL MONTO DEL CÓDIGO DEL CAUSADO POR AJUSTAR');</script><? }
         }
      }
      if($refierea=="PAGO"){
        $sSQL="Select * from PRE038 WHERE (ref_imput_presu='$ref_imput_presu') and (tipo_pago='$tipo_pago') and (referencia_pago='$referencia_pago') and (referencia_caus='$referencia_caus') and (tipo_causado='$tipo_causado') and (referencia_comp='$referencia_comp') and (tipo_compromiso='$tipo_compromiso') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";
        $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
        if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('NO EXISTE EN EL CAUSADO EL CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?>');</script><?}
         else{ $registro=pg_fetch_array($resultado);  $compromiso=$registro["monto"]-$registro["ajustado"]; $balance=$monto_c-$compromiso;
           if(($monto_c>$compromiso)and($balance>0.009)){$error=1; ?> <script language="JavaScript"> muestra('MONTO A PAGAR MAYOR AL MONTO DEL CÓDIGO DEL PAGO POR AJUSTAR');</script><? }
         }
      }
    }
    if($total==0){$error=1;?><script language="JavaScript">muestra('MONTO TOTAL DEL AJUSTE INVALIDO');</script><?}
  }
  if($error==0){  $sfecha=formato_aaaammdd($fecha_ajuste);
     $sSQL="SELECT INCLUYE_PRE011('$codigo_mov','$referencia_ajuste','$tipo_ajuste','$referencia_pago','$tipo_pago','$referencia_caus','$tipo_causado','$referencia_comp','$tipo_compromiso','$sfecha','N','P','N','','','$minf_usuario','$descripcion_ajuste','N','$tipo_ajuste_p','$tipo_ajuste_a','$tipo_ajuste_c','S')";
     $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);$error=substr($error, 0, 61);
     if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
      else{ $error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?
       $resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);
       if (!$resultado){ ?> <script language="JavaScript">muestra('<? echo $error; ?>');</script><?}}
       $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')");       $error=pg_errormessage($conn); $error=substr($error, 0, 61);
       if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location ='Act_ajustes.php?Gcriterio=<? echo $tipo_ajuste.$referencia_ajuste.$tipo_pago.$referencia_pago.$tipo_causado.$referencia_caus.$tipo_compromiso.$referencia_comp; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? } ?>