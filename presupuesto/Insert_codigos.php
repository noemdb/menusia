<?include ("../class/conect.php");  include ("../class/funciones.php"); $MControl=array(0,0,0,0,0,0,0,0,0,0);
function BUSCAR_ACTUAL($Clave,$Formato){  global $MControl;    $j=0;
  for ($i=0; $i<strlen($Formato); $i++) {if (substr($Formato,+$i,1)=="-") {$j++;} else{$MControl[$j]++;} }  $Ultimo=$j;$k=$MControl[0];
  for ($i=1; $i<10; $i++) {if ($MControl[$i]==0) {$MControl[$i]=0;} else { $j=$MControl[$i]+$k; $MControl[$i]=$j+1; $k=$MControl[$i];}}
  for ($i=1; $i<10; $i++) {if ($MControl[$i] < 0) {$MControl[$i]=0;}}  $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($Clave)==$MControl[$i]){$actual=$i; $i=10;} }
  if ($actual==-1){?><script language="JavaScript">muestra('ERROR Longitud del CODIGO Invalido');</script><? }
  return $actual;
}
function Nivel_Cta_Valido($Clave,$Formato){  $mval=0; $e=0;
  for ($i=0; $i<strlen($Clave); $i++) {    if ((substr($Clave,$i,1)=="-")  || (substr($Clave,$i,1)==".")){if (substr($Clave,$i,1)==substr($Formato,$i,1)){$e=0;} else {$mval=1;}} }
  if ($mval==1){?><script language="JavaScript">muestra('ERROR niveles del CODIGO Invalido');</script><? }
  return $mval;
}
//function FNRTD($fmonto){  $mval=floor($fmonto*100)/100;  return $mval; }
?>
<?php
$formato_presup="XX-XX-XX-XXX-XX-XX-XX";$cod_presup=$_POST["txtcod_presup"];$cod_fuente=$_POST["txtcod_fuente"]; $denominacion=$_POST["txtdenominacion"];$cod_contable=$_POST["txtCodigo_Cuenta"];
$func_inv=$_POST["txtTipo_Gasto"];$func_inv=substr($func_inv,0,1); $aplicacion=$_POST["txtAplicacion"];$status_dist="1";$asignado=0; $monto=$_POST["txtasignado"]; $monto=formato_numero($monto);
$denominacion=cambiar_car_especiales($denominacion);
echo "ESPERE POR FAVOR INCLUYENDO....","<br>";if(is_numeric($monto)){$asignado=$monto;}
If($asignado==0){$f=0;}else{$f=($asignado/12);$f=FNRTD($f);}$disponible=0;$diferido=0;$disp_diferida=0;
$asignado01=$f;$asignado02=$f;$asignado03=$f;$asignado04=$f;$asignado05=$f;$asignado06=$f;$asignado07=$f;$asignado08=$f;$asignado09=$f;$asignado10=$f;$asignado11=$f;$asignado12=$f;
$monto=$asignado01+$asignado02+$asignado03+$asignado04+$asignado05+$asignado06+$asignado07+$asignado08+$asignado09+$asignado10+$asignado11+$asignado12;
if($monto!=$asignado){ $f=round($f,2); $p=$asignado-$monto; $p=round($p,2); $f=$f+$p; $asignado12=$f;}
/* */
$monto=cambia_coma_numero($monto);$asignado01=cambia_coma_numero($asignado01);$asignado02=cambia_coma_numero($asignado02);$asignado03=cambia_coma_numero($asignado03);$asignado04=cambia_coma_numero($asignado04);$asignado05=cambia_coma_numero($asignado05);$asignado06=cambia_coma_numero($asignado06);
$asignado07=cambia_coma_numero($asignado07);$asignado08=cambia_coma_numero($asignado08);$asignado09=cambia_coma_numero($asignado09);$asignado10=cambia_coma_numero($asignado10);$asignado11=cambia_coma_numero($asignado11);$asignado12=cambia_coma_numero($asignado12);
$disponible=$asignado;$equipo=getenv("COMPUTERNAME");$minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{  $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];}
  $a=BUSCAR_ACTUAL($cod_presup,$formato_presup); $l=0;  if ($a>=0){$error=0;}else{$error=1;}
  if ($error==0){ $b=Nivel_Cta_Valido($cod_presup,$formato_presup); if ($b>0){$error=1;} }
  if ($error==0){ if ($a>0){$l=$MControl[$a-1];}
    if ($l>0){ $temp_cuenta=substr($cod_presup,0,$l);
       $sSQL="Select * from pre001 WHERE cod_presup='$temp_cuenta'";$resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);       if ($filas==0){ $error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO NIVEL ANTERIOR NO EXISTE');</script> <? }
    }
    if($error==0){ $sSQL="Select * from PRE095 WHERE cod_fuente_financ='$cod_fuente'";  $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE FUENTE NO EXISTE');</script><? }
    }
    if($error==0){$sSQL="Select * from PRE025 WHERE cod_aplicacion='$aplicacion'";    $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE APLICACION NO EXISTE');</script><? }
    }
    if(strlen($cod_presup)==strlen($formato_presup)){ $sSQL="Select * from con001 WHERE codigo_cuenta='$cod_contable'"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE DE GASTO NO EXISTE');</script><? } else{$registro=pg_fetch_array($resultado);if ($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE DE GASTO NO ES CARGABLE');</script><?}}
    }else{$cod_contable="";}
    if($error==0){$sSQL="Select * from pre001 WHERE cod_presup='$cod_presup' and cod_fuente='$cod_fuente'";$resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
      if ($filas>0){?> <script language="JavaScript">muestra('CODIGO PRESUPUESTARIO YA EXISTE');</script> <? }
       else{ $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2007-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
         $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE001(1,'$cod_presup','$cod_fuente','$denominacion','$cod_contable','$status_dist',$asignado,$disponible,$diferido,$disp_diferida,'$func_inv','O','$aplicacion','','$sfecha',$asignado01,$asignado02,$asignado03,$asignado04,$asignado05,$asignado06,$asignado07,$asignado08,$asignado09,$asignado10,$asignado11,$asignado12)");
         $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91);if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? }
      }
    }
  }
}
pg_close(); if($error==0){?><script language="JavaScript">document.location='Act_codigos.php?Gcodigo=<? echo $cod_fuente.$cod_presup; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }?>