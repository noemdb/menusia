<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../presupuesto/Ver_dispon.php");include ("../class/configura.inc");error_reporting(E_ALL);
$formato_presup="XX-XX-XX-XXX-XX-XX-XX";$codigo_mov=$_POST["txtcodigo_mov"];$referencia_pago=$_POST["txtreferencia_pago"];
$tipo_pago=$_POST["txttipo_pago"];$referencia_caus=$_POST["txtnro_orden"];$tipo_causado="";$referencia_comp="";$tipo_compromiso="";
$fecha_pago=$_POST["txtfecha_emi"];$ced_rif=$_POST["txtced_rif"];$descripcion_pago=$_POST["txtdescripcion"];
$num_proyecto="0000000000";$refierea=$_POST["txtrefiereA"];$func_inv="CORRIENTE";$func_inv=substr($func_inv,0,1);
$genera_comprobante="N";$unidad_sol="";$cod_banco='0000';$equipo = getenv("COMPUTERNAME");
$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (checkData($fecha_pago)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if ($error==0){ $sfecha=formato_aaaammdd($fecha_pago); $rfecha=$sfecha;
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICION ABIERTA');</script><?}
  if($error==0){ $l_cat=0;  $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];$l_cat=strlen($formato_cat);}
  }
  if($error==0){$sSQL="Select * from pre004 WHERE tipo_pago='$tipo_pago'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE PAGO NO EXISTE');</script><?}
     else{if(($tipo_pago=="0000")or(substr($tipo_pago,0,1)=='A')){$error=1;?><script language="JavaScript">  muestra('DOCUMENTO DE PAGO NO VALIDO');</script><?}
      else{ $registro=pg_fetch_array($resultado);
        if($refierea==$registro["refierea"]){$error;} else{$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE PAGO NO VALIDO');</script><?}
      }}
  }
  if($error==0){
    $sql="SELECT * FROM pag001 where nro_orden='$referencia_caus' and status='N' and anulado='N'";  $res=pg_query($sql); $filas=pg_num_rows($res); 
    if($filas>=1){$registro=pg_fetch_array($res,0); $tipo_causado=$registro["tipo_causado"];  }
    else {$error=1;?><script language="JavaScript">muestra('NUMERO ORDEN DE PAGO NO VALIDA');</script><?}
  }
  if($error==0){    
    if($refierea=="CAUSADO"){
      $sSQL="Select * from pre007 WHERE referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado'";
      $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
      if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE CAUSADO NO EXISTE');</script><?}
       else{$registro=pg_fetch_array($resultado);
           $rfecha=$registro["fecha_causado"]; $ced_rif=$registro["ced_rif"];   $func_inv=$registro["func_inv"]; if($func_inv==""){$func_inv="CORRIENTE";} $func_inv=substr($func_inv,0,1);
       }
    } else { $error=1;?><script language="JavaScript">muestra('TIPO DE PAGO NO VALIDO');</script><?} 
  }
  if($error==0){
    $sSQL="Select * from pre008 WHERE tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado'";
    $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas>0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE PAGO YA EXISTE');</script><?}
  }
  if($error==0){  $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer); $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
    if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)or($sfecha<$rfecha)){$error=1;?><script language="JavaScript">muestra('FECHA DE PAGO INVALIDA');</script><?}
  }
  if($error==0){
    $sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('C�DULA/RIF BENEFICIARIO NO EXISTE');</script><?}
  }
  if($error==0){ $total=0; $sfecha=formato_aaaammdd($fecha_pago);
    $sql="Select * from CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup"; $res=pg_query($sql);
    
    while(($registro=pg_fetch_array($res))and($error==0)){
      $total=$total+$registro["monto"];$cod_presup=$registro["cod_presup"];$fuente_financ=$registro["fuente_financ"];
      $monto_c=$registro["monto"];$ref_imput_presu=$registro["ref_imput_presu"];$monto_credito=$registro["monto_credito"];
      $tipo_imput_presu=$registro["tipo_imput_presu"];  $unidad_sol=substr($cod_presup,0, $l_cat);      
      if($refierea=="CAUSADO"){ $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"];
        $sSQL="Select * from PRE037 WHERE (ref_imput_presu='$ref_imput_presu') and (referencia_caus='$referencia_caus') and (tipo_causado='$tipo_causado') and (referencia_comp='$referencia_comp') and (tipo_compromiso='$tipo_compromiso') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";
        $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
        if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('NO EXISTE EN EL CAUSADO EL CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?>');</script><?}
         else{$registro=pg_fetch_array($resultado); $compromiso=$registro["monto"]-$registro["pagado"]-$registro["ajustado"];
           if($monto_c>$compromiso){$error=1; ?> <script language="JavaScript"> muestra('MONTO A PAGAR MAYOR AL MONTO DEL C�DIGO DEL CAUSADO POR PAGAR');</script><? }
         }
      }
    }
    if($total==0){$error=1;?><script language="JavaScript">muestra('MONTO TOTAL DEL PAGO INVALIDO');</script><?}
  }
  
  if($error==0){ $sfecha=formato_aaaammdd($fecha_pago);
     $sSQL="SELECT CANCELA_ORDEN('$codigo_mov','$referencia_pago','$tipo_pago','$referencia_caus','$tipo_causado','$referencia_comp','$tipo_compromiso','$sfecha','$referencia_caus','$ced_rif','P','$func_inv','$num_proyecto','$genera_comprobante','','$minf_usuario','N','$unidad_sol','D','$cod_banco','PAG','S','$descripcion_pago')";
     $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  echo $sSQL;
     if (!$resultado){echo $error; $error=substr($error, 0, 61);?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
      else{$error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?
       $resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
       if (!$resultado){ ?> <script language="JavaScript">muestra('<? echo $error; ?>');</script><?}}
      
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location ='Cancelacion_Orden_Pago.php';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? } 
?>