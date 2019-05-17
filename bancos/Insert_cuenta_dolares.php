<?include ("../class/seguridad.inc");  include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();
$MControl = array (0, 0, 0, 0, 0, 0, 0, 0, 0,0);
function BUSCAR_ACTUAL($Clave, $Formato){global $MControl;  $j=0;
  for ($i=0; $i<strlen($Formato); $i++) {if (substr($Formato,+$i, 1) == "-") {$j++;} else{$MControl[$j]++;} }
  $Ultimo=$j;  $k=$MControl[0];
  for ($i=1; $i<10; $i++) {if ($MControl[$i] == 0) {$MControl[$i]=0;} else { $j=$MControl[$i]+$k; $MControl[$i]=$j+1; $k=$MControl[$i];}}
  for ($i=1; $i<10; $i++) {if ($MControl[$i] < 0) {$MControl[$i]=0;}}
  $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($Clave) == $MControl[$i]){$actual=$i; $i=10;} }
  if ($actual==-1){?><script language="JavaScript">muestra('ERROR Longitud de la Cuenta Invalida');</script><? }
  return $actual;
}
function Nivel_Cta_Valido($Clave, $Formato){  $mval=0;  $e=0;
  for ($i=0; $i<strlen($Clave); $i++) {
     if ((substr($Clave,$i, 1) == "-")  || (substr($Clave,$i, 1) == ".")){ if (substr($Clave,$i, 1) == substr($Formato,$i, 1)){$e=0;} else {$mval=1;}}
  }
  if ($mval==1){?><script language="JavaScript">muestra('ERROR niveles de la Cuenta Invalida');</script><? }
  return $mval;
}
?>
<?php
$Formato_Cuenta="X-X-X-XX-XX-XX-XX";
$codigo_cuenta=$_POST["txtcodigo_cuenta"];$descripcion_cuenta=$_POST["txtdescripcion_cuenta"]; $Saldo_Anterior=0;  $fecha=$fecha_hoy;
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Act_cuentas_dolares.php?Gcodigo_cuenta=C".$codigo_cuenta; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
If (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{  $sql="Select * from SIA005 where campo501='06'";  $resultado=pg_query($sql);  if ($registro=pg_fetch_array($resultado,0)){$Formato_Cuenta=$registro["campo504"];}
  $a=BUSCAR_ACTUAL($codigo_cuenta,$Formato_Cuenta); $l=0; if ($a>=0){$error=0;}else{$error=1;}
  if ($error==0){ $b=Nivel_Cta_Valido($codigo_cuenta,$Formato_Cuenta); if ($b>0){$error=1;} }
  if (checkData($fecha)=='1'){$sfecha=formato_aaaammdd($fecha);} else{$error=1; ?> <script language="JavaScript"> muestra('FECHA NO ES VALIDA');</script><? }
  if ($error==0){
    if ($a>0){$l=$MControl[$a-1];}
    if ($l>0){$temp_cuenta=substr($codigo_cuenta,0,$l);
       $sSQL="Select * from BAN043 WHERE codigo_cuenta='$temp_cuenta'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
       if ($filas==0){ $error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NIVEL ANTERIOR NO EXISTE');</script> <? }	   
	   
    }
    if ($error==0){  $sSQL="Select * from BAN043 WHERE codigo_cuenta='$codigo_cuenta'";       $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
      if ($filas>0){?> <script language="JavaScript">muestra('CODIGO DE CUENTA YA EXISTE');</script> <? }
       else{
         $resultado=pg_exec($conn,"SELECT ACTUALIZA_BAN043(1,'$codigo_cuenta','$descripcion_cuenta',$Saldo_Anterior,'C',0,0,0,0,0,0,0,0,0,0,0,0,'','',0,0,'$usuario_sia','$minf_usuario',$l)");
         $error=pg_errormessage($conn);$error="ERROR GRABANDO: ".substr($error, 0, 61);if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? }
      }
    }
  }
}
pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>
