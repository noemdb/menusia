<?include ("../class/conect.php");  include ("../class/funciones.php");$fecha_hoy=asigna_fecha_hoy(); $fechah=formato_aaaammdd($fecha_hoy);
$codigo_mov=$_POST["txtcodigo_mov"]; $cedula=$_POST["txtcedula"]; $nombre=$_POST["txtnombre"]; $parentesco=$_POST["txtparentesco"]; $sexo=$_POST["txtsexo"]; $status=$_POST["txtstatus"];
$fecha_nac=$_POST["txtfecha_nac"]; $edad=$_POST["txtedad"]; $edad=formato_numero($edad); if(is_numeric($edad)){ $edad=$edad;} else{$edad=0;}
$equipo = getenv("COMPUTERNAME"); $MInf_Usuario=$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$url="Det_inc_inf_familiar_e.php?codigo_mov=".$codigo_mov;  $cod_empleado=""; $status=substr($status,0,1); $campo_str1=''; $campo_num1=0;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ if(checkData($fecha_nac)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA NACIMIENTO NO ES VALIDA');</script><? } }
 if($error==0){$sfecha=formato_aaaammdd($fecha_nac); if ($sfecha>$fechah){ $error=1; ?> <script language="JavaScript">muestra('FECHA NACIMIENTO MAYOR A FECHA DE HOY');</script><? }  }
 if($error==0){
  $sSQL="Select * from NOM069 WHERE codigo_mov='$codigo_mov' and ci_partida='$cedula'";
  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('INFORMACION FAMILIAR NO EXISTE');</script><? }
   else{$sfecha=formato_aaaammdd($fecha_nac);
      $sSQL="SELECT ACTUALIZA_NOM069(2,'$codigo_mov','$cod_empleado','$cedula','$nombre','$sexo','$sfecha',$edad,'$parentesco','$status','$campo_str1',$campo_num1)";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
  }
}
pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>