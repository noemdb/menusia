<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc"); error_reporting(E_ALL); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
$codigo_mov=$_POST["txtcodigo_mov"]; $referencia_aju=$_POST["txtreferencia_aju"];$tipo_aju=$_POST["txttipo_ajuste"];
$nro_orden=$_POST["txtnro_orden"];  $tipo_causado=$_POST["txttipo_causado"]; $fecha=$_POST["txtfecha"];
$concepto=$_POST["txtconcepto"]; $equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (checkData($fecha)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if ($error==0){$sfecha=formato_aaaammdd($fecha);  $rfecha=$sfecha; $campo_str2="";
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICION ABIERTA');</script><?}
  if($error==0){ $l_cat=0; $sql="Select campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];$l_cat=strlen($formato_cat);}
    $campo502="NNNNNNNNNNNNNNNNNNNN";   $sql="Select campo502 from SIA005 where campo501='01'"; $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"];}
    $gen_ord_ret=substr($campo502,0,1); $gen_comp_ret=substr($campo502,1,1); $gen_pre_ret=substr($campo502,2,1); $ant_presup=substr($campo502,14,1); $nro_aut=substr($campo502,5,1); $fecha_aut=substr($campo502,6,1);
  }
  $sSQL="Select * from pre005 WHERE refierea='COMPROMISO'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE AJUSTE A COMPROMISO NO EXISTE');</script><?}
     else{ $registro=pg_fetch_array($resultado); $tipo_ajuste_c=$registro["tipo_ajuste"]; }
  if($error==0){$sSQL="Select * from pre005 WHERE tipo_ajuste='$tipo_aju'"; $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE AJUSTE NO EXISTE');</script><?}
  }
  if($error==0){$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
    if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)or($sfecha<$rfecha)){$error=1;?><script language="JavaScript">muestra('FECHA DE AJUSTE INVALIDA');</script><?}
  }
  if($error==0){ $sSQL="SELECT ced_rif,fecha FROM PAG001 where nro_orden='$nro_orden'";   $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('ORDEN DE PAGO A AJUSTAR NO EXISTE');</script><?}
     else{ $reg=pg_fetch_array($resultado); $ced_rif=$reg["ced_rif"]; $fecha_orden=$reg["fecha"];
       if (($sfecha<$fecha_orden)){$error=1;?><script language="JavaScript">muestra('FECHA AJUSTE MENOR A FECHA ORDEN');</script><?}
     }
  } $total=0;
  if($error==0){ $sql="Select * from CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup"; $res=pg_query($sql);
    while(($registro=pg_fetch_array($res))and($error==0)){
      $total=$total+$registro["monto"];$cod_presup=$registro["cod_presup"];$fuente_financ=$registro["fuente_financ"];
      $monto_c=$registro["monto"];$ref_imput_presu=$registro["ref_imput_presu"];$tipo_imput_presu=$registro["tipo_imput_presu"];  $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"];
      $sSQL="Select * from PRE037 WHERE (ref_imput_presu='$ref_imput_presu') and (referencia_caus='$nro_orden') and (tipo_causado='$tipo_causado') and (referencia_comp='$referencia_comp') and (tipo_compromiso='$tipo_compromiso') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";
      $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('NO EXISTE EN EL CAUSADO EL CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?>');</script><?}
       else{ $registro=pg_fetch_array($resultado);
         $compromiso=$registro["monto"]-$registro["pagado"]-$registro["ajustado"];
         if($monto_c>$compromiso){$error=1; ?> <script language="JavaScript"> muestra('MONTO AJUSTE MAYOR AL MONTO DEL CÓDIGO DEL CAUSADO POR AJUSTAR');</script><? }
      }
    }
    if($total==0){$error=1;?><script language="JavaScript">muestra('MONTO TOTAL DEL AJUSTE INVALIDO');</script><?}
  }
  if($error==0){$sql="SELECT * FROM CON008  where codigo_mov='$codigo_mov' order by debito_credito desc,cod_cuenta";    $res=pg_query($sql);  $t_debe=0; $t_haber=0;$balance=0;
    while($registro=pg_fetch_array($res)) {
      if ($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}
       if ($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;}
    }
    if ($balance==0){$error=0;}else{$error=1; echo $balance,"<br>"; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA');</script><? }
    if (($t_debe==0)or($total<>$t_debe)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DEL COMPROBANTE CONTABLE NO VALIDO');</script><? }
  }
  $rmonto = $total; $monto=($total-$t_debe); $monto=Abs($monto);
  if (($rmonto <> $t_debe) And ($monto > 0.001)) {$error=1;   ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA CON AJUSTE');</script><? }
  if (($error==0)And($nro_aut="N")){ $sql="Select nro_orden from PAG019 WHERE referencia_aju_ord='$referencia_aju'";      $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
     if ($filas>0){$error=1;?><script language="JavaScript">muestra('NÚMERO DE AJUSTE A ORDEN YA EXISTE');</script><?}
  }
  if($error==0){ $sfecha=formato_aaaammdd($fecha); $total=cambia_coma_numero($total);
     $sSQL="SELECT INCLUYE_PAG019('$codigo_mov','$referencia_aju','$tipo_aju','$nro_orden','$tipo_causado','$sfecha',$total,'N','$usuario_sia','$minf_usuario','$tipo_ajuste_c','$nro_aut','D','$ced_rif','$concepto')";
     $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error=substr($error,0,91);
     if (!$resultado){echo $sSQL; ?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;} else{ $error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?
       $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  }}
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location ='Act_ajuste_orden.php?Gcriterio=C<? echo $referencia_aju.$tipo_aju; ?>';</script> <? }
else { ?> <script language="JavaScript">history.back();</script>  <? }

 ?>