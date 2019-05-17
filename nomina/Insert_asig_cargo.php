<?include ("../class/conect.php");  include ("../class/funciones.php");
$codigo_mov=$_POST["txtcodigo_mov"]; $fecha=$_POST["txtfecha_asigna"]; $cod_cargo=$_POST["txtcodigo_cargo"]; $des_cargo=$_POST["txtdenominacion"];
$cod_departamento=$_POST["txtcodigo_departamento"]; $des_departamento=$_POST["txtdescripcion_dep"]; $cod_tipo_personal=$_POST["txtcod_tipo_personal"];
$paso=$_POST["txtpaso"];  $grado=$_POST["txtgrado"];$sueldo=$_POST["txtsueldo"];$prima=$_POST["txtprima"];  $compensacion=$_POST["txtcompensacion"]; $cod_empleado=""; $observacion="";
$sueldo=formato_numero($sueldo); if(is_numeric($sueldo)){$sueldo=$sueldo;}else{$sueldo=0;}
$prima=formato_numero($prima); if(is_numeric($prima)){$prima=$prima;}else{$prima=0;}

$compensacion=formato_numero($compensacion); if(is_numeric($compensacion)){$compensacion=$compensacion;}else{$compensacion=0;}
$equipo = getenv("COMPUTERNAME"); $MInf_Usuario=$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Det_inc_asig_cargo.php?codigo_mov=".$codigo_mov;  $cod_empleado="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ if(checkData($fecha)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? } }
 if($error==0){$sSQL="Select * from NOM004 WHERE codigo_cargo='$cod_cargo'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CARGO NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado); $des_cargo=$registro["denominacion"];}}
 if($error==0){$sSQL="Select * from NOM015 WHERE cod_tipo_personal='$cod_tipo_personal'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO TIPO DE PERSONAL NO EXISTE');</script><?}}
 if($error==0){$sSQL="Select * from NOM005 WHERE codigo_departamento='$cod_departamento'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);if($filas==0){$error=1; ECHO $sSQL; ?> <script language="JavaScript"> muestra('CODIGO DE DEPARTAMENTO NO EXISTE');</script><?}else{$registro=pg_fetch_array($resultado); $des_departamento=$registro["descripcion_dep"];} }
 /*
 if($error==0){if($sueldo==0){$error=1; ?> <script language="JavaScript">muestra('MONTO SUELDO NO ES VALID0');</script><?} }  */
 $sfecha=formato_aaaammdd($fecha); 
 if($error==0){ $sSQL="Select * from NOM068 WHERE codigo_mov='$codigo_mov' and cod_empleado='$cod_empleado' and fecha_asigna='$sfecha'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas>=1){$error=1;  ?> <script language="JavaScript"> muestra('ASIGNACION DE CARGO YA EXISTE');</script><? }
   else{$sfecha=formato_aaaammdd($fecha);
      $sSQL="SELECT ACTUALIZA_NOM068(1,'$codigo_mov','$cod_empleado','$sfecha','$cod_cargo','$cod_departamento','$des_cargo','$des_departamento','$cod_tipo_personal','$paso','$grado','$observacion',$sueldo,$prima,$compensacion,0,0)";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){echo $sSQL; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
  }
}
pg_close();if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>




