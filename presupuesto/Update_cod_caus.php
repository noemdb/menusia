<?include ("../class/conect.php");  include ("../class/funciones.php");?>
<?include ("Ver_dispon.php");
$formato_presup="XX-XX-XX-XXX-XX-XX-XX";
$codigo_mov=$_POST["txtcodigo_mov"];
$cod_presup=$_POST["txtcod_presup"];
$fuente_financ=$_POST["txtcod_fuente"];
$monto_c=formato_numero($_POST["txtmonto"]);
$monto_c=$_POST["txtmonto"];
$tipo_imput_presu=$_POST["txttipo_imput_presu"];
$ref_imput_presu=$_POST["txtref_imput_presu"];
$monto_credito=$_POST["txtmonto_credito"];
$cod_contable=$_POST["txtcod_contable"];
$tipo_imput_presu=substr($tipo_imput_presu,0,1);
$fecha=asigna_fecha_hoy();
$monto_c=formato_numero($monto_c);
if(is_numeric($monto_c)){$monto=$monto_c;} else{$monto=0;}
$monto_credito=formato_numero($monto_credito);
if(is_numeric($monto_credito)){$monto_credito=$monto_credito;} else{$monto_credito=0;}
$equipo = getenv("COMPUTERNAME");
$MInf_Usuario = $equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$url="Det_inc_causados.php?codigo_mov=".$codigo_mov;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{
  $sql="Select * from SIA005 where campo501='05'";
  $resultado=pg_query($sql);
  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];}
  $error=0;
  $sSQL="Select * from PRE026 WHERE codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ' and ref_imput_presu='$ref_imput_presu'";
  $resultado=pg_query($sSQL);
  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO PRESUPUESTARIO NO EXISTE EN EL CAUSADO');</script><? }
   else{
    if(strlen($cod_presup)==strlen($formato_presup)){
      if (verifica_disponibilidad($conn,$cod_presup,$fuente_financ,$fecha,$monto_c)==0){$error=0;}else{$error=1;}}
    else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD DE CÓDIGO PRESUPUESTARIO INVALIDA');</script><? }
    if($error==0){
      $sSQL="Select * from PRE095 WHERE cod_fuente_financ='$fuente_financ'";
      $resultado=pg_query($sSQL);
      $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE FUENTE NO EXISTE');</script><? }
    }
    if(($error==0)and($monto_c==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO CODIGO INVALIDO');</script><? }
    $monto_credito=0;
    if(($error==0)and($tipo_imput_presu=="C")){ $monto_credito=$monto;
      if($monto_credito>$monto_c){ $error=1; ?> <script language="JavaScript"> muestra('MONTO CREDITO INVALIDO');</script><? }
    }
    else{$monto_credito=0;$ref_imput_presu="00000000";$tipo_imput_presu="P";}
    if(($error==0)and($tipo_imput_presu=="C")){
      $sSQL="Select * from PRE010 WHERE (referencia_adicion='$ref_imput_presu') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";
      $resultado=pg_query($sSQL);
      $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO NO EXISTE EN LA EJECUCIÓN DEL CREDITO ADICIONAL');</script><? }
       else{
         $registro=pg_fetch_array($resultado);
         if($registro["disponible"]<$monto_credito) {$error=1; $dispon=$registro["disponible"]; $dispon=formato_monto($dispon); ?> <script language="JavaScript"> muestra('Monto Mayor que Disponibilidad del Crédito Adicional, Disponibilidad: <? echo $dispon; ?> ');</script><? }
       }
    }
    if($error==0){
      $sfecha=formato_aaaammdd($fecha);
      $resultado=pg_exec($conn,"SELECT MODIFICA_PRE026('$codigo_mov','$cod_presup','$fuente_financ','','0000','','0000','','0000','','0000','','','','$cod_contable','','','$sfecha','C','$tipo_imput_presu','$ref_imput_presu','$sfecha',$monto,0,$monto_credito,0)");
      $error=pg_errormessage($conn);
      $error="ERROR GRABANDO: ".substr($error, 0, 61);
      if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
    }
  }
}
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }?>