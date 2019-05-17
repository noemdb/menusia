<?include ("../class/seguridad.inc");  include ("../class/conects.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$MControl=array (0,0,0,0,0,0,0,0,0,0);
function BUSCAR_ACTUAL($Clave, $Formato){  global $MControl;  $j=0;
  for ($i=0; $i<strlen($Formato); $i++) { if (substr($Formato,+$i, 1) == "-") {$j++;} else{$MControl[$j]++;}}
  $Ultimo=$j; $k=$MControl[0];
  for ($i=1; $i<10; $i++) {if ($MControl[$i] == 0) {$MControl[$i]=0;} else { $j=$MControl[$i]+$k; $MControl[$i]=$j+1; $k=$MControl[$i];}}
  for ($i=1; $i<10; $i++) {if ($MControl[$i] < 0) {$MControl[$i]=0;}}
  $actual=-1;
  for ($i=0; $i<10; $i++) {if (strlen($Clave) == $MControl[$i]){$actual=$i; $i=10;}}
  if ($actual==-1){?><script language="JavaScript">muestra('ERROR Longitud de la Cuenta Invalida');</script><? }
  return $actual;
}
?>
<?php
$Codigo_Cuenta=$_GET["txtCodigo_Cuenta"]; $equipo=getenv("COMPUTERNAME"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script>  <?}
 else{ $error=0;  $sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
   if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="03"; $opcion="01-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
   if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
   $opcion="02-0000010"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$Mcamino.$reg["campo617"]; } else{ $Mcamino=$Mcamino."N";}
   }$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{$error=1;} if($Mcamino{6}=="S"){$error=0;}else{$error=1;} if($error==1){?><script language="JavaScript"> muestra(' NO TIENE DERECHOS PARA EJECUTAR ESTA OPCION'); </script><?}
 }  
 if($error==0){$Formato_Cuenta="X-X-X-XX-XX-XX-XX";  $sql="Select * from SIA005 where campo501='06'";  $resultado=pg_query($sql);
  if ($registro=pg_fetch_array($resultado,0)){$Formato_Cuenta=$registro["campo504"];} $a=BUSCAR_ACTUAL($Codigo_Cuenta,$Formato_Cuenta);  $l=0;
  if ($a>=0){$error=0;}else{$error=1;} 
  if ($error==0){ if ($a>0){$l=$MControl[$a-1];}
    $sSQL="Select * from CON001 WHERE codigo_cuenta='$Codigo_Cuenta'"; $resultado=pg_query($sSQL);
    if ($registro=pg_fetch_array($resultado,0)){$descripcion=$registro["nombre_cuenta"]; $sfecha=$registro["fecha_creado"];
       if ($registro["saldo_anterior"]==0){ $error=0;
          if (($registro["debito_01"]==0)&&($registro["credito_01"]==0)&&($registro["debito_02"]==0)&&($registro["credito_02"]==0)&&($registro["debito_03"]==0)&&($registro["credito_03"]==0)&&($registro["debito_04"]==0)&&($registro["credito_04"]==0)&&($registro["debito_05"]==0)&&($registro["credito_05"]==0)&&($registro["debito_06"]==0)&&($registro["credito_06"]==0)&&($registro["debito_07"]==0)&&($registro["credito_07"]==0)&&($registro["debito_08"]==0)&&($registro["credito_08"]==0)&&($registro["debito_09"]==0)&&($registro["credito_09"]==0)&&($registro["debito_09"]==0)&&($registro["credito_09"]==0)&&($registro["debito_10"]==0)&&($registro["credito_10"]==0)&&($registro["debito_11"]==0)&&($registro["credito_11"]==0)&&($registro["debito_12"]==0)&&($registro["credito_12"]==0)){
             $sSQL="Select * from con003 WHERE cod_cuenta='$Codigo_Cuenta'";  $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado); if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA TIENE COMPROBANTES REGISTRADO');</script><? }
          }
          else{$error=1;  ?> <script language="JavaScript">  muestra('CUENTA TIENE MOVIMIENTO');  </script> <? }
       }
       else{$error=1;  ?> <script language="JavaScript">  muestra('SALDO ANTERIOR DIFERENTE DE CERO');  </script> <? }
    }
    else{$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO EXISTE');  </script> <? }
    if ($error==0){ $resultado=pg_exec($conn,"SELECT ACTUALIZA_CON001(5,'$Codigo_Cuenta','',0,'C','','','','','',0,0,'',$l,'$sfecha')");$error=pg_errormessage($conn);  $error=substr($error,0,91);
       if (!$resultado){?> <script language="JavaScript">  muestra('<? echo $error; ?>');  </script> <? } else{?> <script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE');  </script> <?
         $desc_doc="CUENTA CONTABLE :".$Codigo_Cuenta.", DESCRIPCION:".$descripcion;   $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('03','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <?}	 }
    }
  }
 }
pg_close();error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>                