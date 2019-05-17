<?include ("../class/seguridad.inc");  include ("../class/conects.php");  include ("../class/funciones.php");
$MControl = array (0,0,0,0,0,0,0,0,0,0);
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
$Codigo_Cuenta=$_POST["txtCodigo_Cuenta"];$nombre_cuenta=$_POST["txtNombre_Cuenta"];$Clasificacion=$_POST["txtClasificacion"];$TSaldo=$_POST["txtTSaldo"];
$monto=formato_numero($_POST["txtsaldo_anterior"]); if(is_numeric($monto)){ $Saldo_Anterior=$monto;} else{$Saldo_Anterior=0;}  $fecha=$_POST["txtFecha_Creado"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$nombre_cuenta=str_replace("\r\n","",$nombre_cuenta); $nombre_cuenta=str_replace("\n","",$nombre_cuenta);
$url="Act_cuentas.php?Gcodigo_cuenta=C".$Codigo_Cuenta; 
$MClasif_Fiscal="";
if ($Clasificacion=="Activo del Tesoro") {$MClasif_Fiscal="11";};
if ($Clasificacion=="Pasivo del Tesoro") {$MClasif_Fiscal="12";};
if ($Clasificacion=="Activo de la Hacienda") {$MClasif_Fiscal="21";};
if ($Clasificacion=="Pasivo de la Hacienda") {$MClasif_Fiscal="22";};
if ($Clasificacion=="Gastos del Presupuesto") {$MClasif_Fiscal="31";};
if ($Clasificacion=="Ingresos del Presupuesto") {$MClasif_Fiscal="32";};
if ($Clasificacion=="Resultado del Presupuesto") {$MClasif_Fiscal="4";};
if ($Clasificacion=="Cuenta de Patrimonio") {$MClasif_Fiscal="5";};
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{  $sql="Select * from SIA005 where campo501='06'";  $resultado=pg_query($sql);  if ($registro=pg_fetch_array($resultado,0)){$Formato_Cuenta=$registro["campo504"];}
  $a=BUSCAR_ACTUAL($Codigo_Cuenta,$Formato_Cuenta); $l=0; if ($a>=0){$error=0;}else{$error=1;}
  if ($error==0){ $b=Nivel_Cta_Valido($Codigo_Cuenta,$Formato_Cuenta); if ($b>0){$error=1;} }
  if (checkData($fecha)=='1'){$sfecha=formato_aaaammdd($fecha);} else{$error=1; ?> <script language="JavaScript"> muestra('FECHA NO ES VALIDA');</script><? }
  if ($error==0){
    if ($a>0){$l=$MControl[$a-1];}
    if ($l>0){$temp_cuenta=substr($Codigo_Cuenta,0,$l);
       $sSQL="Select * from con001 WHERE codigo_cuenta='$temp_cuenta'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
       if ($filas==0){ $error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NIVEL ANTERIOR NO EXISTE');</script> <? }	   
	   $sSQL="Select * from con003 WHERE cod_cuenta='$temp_cuenta'";  $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
       if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NIVEL ANTERIOR TIENE COMPROBANTES REGISTRADO');</script><? }
    }
    if ($error==0){  $sSQL="Select * from con001 WHERE codigo_cuenta='$Codigo_Cuenta'";       $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
      if ($filas>0){?> <script language="JavaScript">muestra('CODIGO DE CUENTA YA EXISTE');</script> <? }
       else{ $resultado=pg_exec($conn,"SELECT ACTUALIZA_CON001(1,'$Codigo_Cuenta','$nombre_cuenta',$Saldo_Anterior,'C','$TSaldo','$MClasif_Fiscal','','','',0,0,'$minf_usuario',$l,'$sfecha')");  $error=pg_errormessage($conn);$error="ERROR GRABANDO: ".substr($error,0,91);
         if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? }
      }
    }
  }
}
pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>