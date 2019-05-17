<?include ("../class/conect.php"); include ("../class/funciones.php");
$MControl = array (0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
function BUSCAR_ACTUAL($Clave, $Formato){  global $MControl;  $j=0;
  for ($i=0; $i<10; $i++) {$MControl[$i]=0;}
  for ($i=0; $i<strlen($Formato); $i++) {if (substr($Formato,+$i, 1) == "-") {$j++;} else{$MControl[$j]++;} }  $Ultimo=$j;$k=$MControl[0];
  for ($i=1; $i<10; $i++) {if ($MControl[$i] == 0) {$MControl[$i]=0;} else { $j=$MControl[$i]+$k; $MControl[$i]=$j+1; $k=$MControl[$i];}}
  for ($i=1; $i<10; $i++) {if ($MControl[$i] < 0) {$MControl[$i]=0;}}  $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($Clave) == $MControl[$i]){$actual=$i; $i=10;} }
  if ($actual==-1){?><script language="JavaScript">muestra('ERROR Longitud del Codigo Invalido');</script><? }
  return $actual;
}
echo "ESPERE ACTUALIZANDO MAESTRO....","<br>";$formato_presup="XX-XX-XX-XXX-XX-XX-XX";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];}
  $cod_presup=$formato_presup; $a=BUSCAR_ACTUAL($cod_presup,$formato_presup);  $cod_presup=$formato_categoria;  $b=BUSCAR_ACTUAL($cod_presup,$formato_presup);
  $l=strlen($formato_presup);   $c=strlen($formato_categoria);  $p=strlen($formato_partida);
  $resultado=pg_exec($conn,"SELECT INICALIZA_ACT_PRESUP()");   $merror=pg_errormessage($conn); $terror=$merror; $merror=substr($merror, 0, 150);
  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $merror." INIC "; ?>'); </script> <? }
  echo "ESPERE ACTUALIZANDO DIFERIDOS....","<br>";
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_MAESTRO(6)");   $merror=pg_errormessage($conn); $terror=$merror;  $merror=substr($merror, 0, 150);
  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $merror." DIF "; ?>'); </script> <? }
  echo "ESPERE ACTUALIZANDO MODIFICACIONES....","<br>";
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_MAESTRO(5)");   $merror=pg_errormessage($conn); $terror=$merror;  $merror=substr($merror, 0, 150);
  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $merror." MOD "; ?>'); </script> <? }
  echo "ESPERE ACTUALIZANDO COMPROMISOS....","<br>";
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_MAESTRO(1)");  $merror=pg_errormessage($conn);  $merror=substr($merror, 0, 150);
  if (!$resultado){ echo $merror; ?> <script language="JavaScript">  muestra('<? echo $merror." COMP "; ?>'); </script> <? }
  echo "ESPERE ACTUALIZANDO CAUSADOS....","<br>";
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_MAESTRO(2)"); $merror=pg_errormessage($conn); $terror=$merror; $merror=substr($merror, 0, 150);
  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $merror." CAUS "; ?>'); </script> <? }
  echo "ESPERE ACTUALIZANDO PAGOS....","<br>";
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_MAESTRO(3)");   $merror=pg_errormessage($conn); $terror=$merror;  $merror=substr($merror, 0, 150);
  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $merror." PAG "; ?>'); </script> <? }
  echo "ESPERE ACTUALIZANDO AJUSTES....","<br>";
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_MAESTRO(4)");  $merror=pg_errormessage($conn); $terror=$merror;  $merror=substr($merror, 0, 150);
  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $merror." AJU "; ?>'); </script> <? }
  echo "ESPERE ACTUALIZANDO CREDITOS ADICIONALES....","<br>";
  $resultado=pg_exec($conn,"SELECT REACTUALIZA_CREDITO_ADIC(1)"); $merror=pg_errormessage($conn);$terror=$merror; $merror=substr($merror, 0, 150);
  if (!$resultado){ echo $merror,"<br>"; ?> <script language="JavaScript">  muestra('<? echo $merror." CRED. ADIC "; ?>'); </script> <? }
  if($a>0){   echo "ESPERE ACTUALIZANDO ASIGNACION INICIAL....","<br>";
    for ($i=$a-1; $i>=0; $i--) {$str_C = $MControl[$i]; $str_L = $MControl[$i+1];   //echo $MControl[$i];
        $resultado=pg_exec($conn,"SELECT REACT_SALDOS_PRESUP($str_C,$str_L)"); $merror=pg_errormessage($conn);  $terror=$merror; $merror=substr($merror, 0, 100);
        if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $merror; ?>'); </script> <? }
    }
  }
  echo "ESPERE VERIFICANDO STATUS ORDENES CANCELADAS....","<br>";
  $resultado=pg_exec($conn,"UPDATE PAG001 set status='I' WHERE status<>'I' and anulado='N' and total_pagado>=total_causado-total_retencion-total_ajuste");  $merror=pg_errormessage($conn);  $merror=substr($merror, 0, 150);
  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $merror; ?>'); </script> <? }  
  echo "ESPERE VERIFICANDO DISPONIBILIDAD....","<br>";
  $sql="SELECT cod_presup,cod_fuente,denominacion,disponible,disp_diferida FROM PRE001 Where ((disponible<0) Or (disp_diferida<0)) and (length(cod_presup)=".$l.") order by cod_presup";
  $resultado=pg_query($sql); $filas=pg_num_rows($resultado); 
  while($registro=pg_fetch_array($resultado)){$cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"];$disponible=$registro["disponible"]; $disp_diferida=$registro["disp_diferida"];
    if($registro["disponible"]<0){ echo "Disponible: ".$registro["disponible"]."Codigo: ".$cod_presup." ".$cod_fuente,"<br>"; ?> <script language="JavaScript"> muestra('Error en Disponibilidad del Codigo: <? echo $cod_presup; ?> Fuente: <? echo $cod_fuente; ?>' );</script><?}
    else{if($registro["disp_diferida"]<0){  ?> <script language="JavaScript"> muestra('Error en Disponibilidad Diferida del Codigo: <? echo $cod_presup; ?> Fuente: <? echo $cod_fuente; ?>' );</script><?}}
  }
  /*
  echo "ESPERE ACTUALIZANDO EJECUCION DE METAS....","<br>";
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_MAESTRO_METAS(1)");   $merror=pg_errormessage($conn); $terror=$merror;  $merror=substr($merror, 0, 150);
  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $merror." METAS "; ?>'); </script> <? }
  */
  ?> <script language="JavaScript">  muestra('PROCESO FINALIZADO'); </script> <?
 }
?> <script language="JavaScript">javascript:window.close();</script>
