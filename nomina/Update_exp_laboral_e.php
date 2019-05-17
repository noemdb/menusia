<?include ("../class/conect.php");  include ("../class/funciones.php");
$codigo_mov=$_POST["txtcodigo_mov"]; $fechad=$_POST["txtfecha_desde"]; $fechah=$_POST["txtfecha_hasta"]; $empresa=$_POST["txtempresa"]; $departamento=$_POST["txtdepartamento"]; $cargo=$_POST["txtcargo"];
$monto=formato_numero($_POST["txtsueldo"]); if(is_numeric($monto)){ $sueldo=$monto;} else{$sueldo=0;}
$equipo = getenv("COMPUTERNAME"); $MInf_Usuario=$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR MODIFICANCO....","<br>";
$url="Det_inc_exp_laboral_e.php?codigo_mov=".$codigo_mov;  $cod_empleado="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ if(checkData($fechad)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DESDE NO ES VALIDA');</script><? } }
 if($error==0){if(checkData($fechah)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA HASTA NO ES VALIDA');</script><? } }
 if($error==0){
  $sSQL="Select * from NOM070 WHERE codigo_mov='$codigo_mov' and  fecha_desde='$fechad'";
  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('EXPERIENCIA LABORAL NO EXISTE');</script><? }
   else{$sfechad=formato_aaaammdd($fechad);  $sfechah=formato_aaaammdd($fechah);
      $sSQL="SELECT ACTUALIZA_NOM070(2,'$codigo_mov','$cod_empleado','$sfechad','$sfechah','$empresa','$departamento','$cargo',$sueldo)"; echo $sSQL;
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR ACTUALIZANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
  }
}
pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>