<?include ("../class/conect.php"); include ("../class/funciones.php");
$MControl = array (0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
function BUSCAR_ACTUAL($Clave, $Formato){global $MControl;  $j=0;
  for ($i=0; $i<10; $i++) {$MControl[$i]=0;}
  for ($i=0; $i<strlen($Formato); $i++) {if (substr($Formato,+$i, 1) == "-") {$j++;} else{$MControl[$j]++;} }$Ultimo=$j;$k=$MControl[0];
  for ($i=1; $i<10; $i++) {if ($MControl[$i] == 0) {$MControl[$i]=0;} else { $j=$MControl[$i]+$k; $MControl[$i]=$j+1; $k=$MControl[$i];}}
  for ($i=1; $i<10; $i++) {if ($MControl[$i] < 0) {$MControl[$i]=0;}}  $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($Clave) == $MControl[$i]){$actual=$i; $i=10;} }
  if ($actual==-1){?><script language="JavaScript">muestra('ERROR Longitud del Código Invalido');</script><? }
  return $actual;
}
 $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  $error=0;
   $sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="04-0000010"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{ $error=1; }
  
  if($error==0){ echo "ESPERE ACTUALIZANDO ASIGNACION INICIAL....","<br>"; 
  $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql);
  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];}
  $cod_presup=$formato_presup; $a=BUSCAR_ACTUAL($cod_presup,$formato_presup); $cod_presup=$formato_categoria; $b=BUSCAR_ACTUAL($cod_presup,$formato_presup);
  $l=strlen($formato_presup);  $c=strlen($formato_categoria);  $p=strlen($formato_partida);
  $resultado=pg_exec($conn,"SELECT GRABA_COD_PRESUP($l,$c)"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } $r=0;
  if($a>0){
    for ($i=$a-1; $i>=0; $i--) { $str_C = $MControl[$i]; $str_L = $MControl[$i+1];       //echo $MControl[$i],"<br>";
       $resultado=pg_exec($conn,"SELECT REACT_SALDOS_PRESUP($str_C,$str_L)"); $error=pg_errormessage($conn);$error=substr($error, 0, 61);
       if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
    }
  }
  ?> <script language="JavaScript">  muestra('PROCESO FINALIZADO'); </script> <?
  }
}pg_close(); ?><script language="JavaScript">javascript:window.close();</script>