<?include ("../class/conect.php");  include ("../class/funciones.php");
$codigo_mov=$_POST["txtcodigo_mov"]; $fecha=$_POST["txtfecha"]; $titulo=$_POST["txttitulo"]; $instituto=$_POST["txtinstituto"]; $descripcion=$_POST["txtdescripcion"];
$equipo = getenv("COMPUTERNAME"); $MInf_Usuario=$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$url="Det_inc_inf_curricular_e.php?codigo_mov=".$codigo_mov;  $cod_empleado="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $error=0;
  $sSQL="Select * from NOM067 WHERE codigo_mov='$codigo_mov' and fecha='$fecha'";
  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('INFORMACION CURRICULAR NO EXISTE');</script><? }
   else{$sfecha=formato_aaaammdd($fecha);
      $sSQL="SELECT ACTUALIZA_NOM067(2,'$codigo_mov','$cod_empleado','$sfecha','$titulo','$instituto','$descripcion')";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR MODIFICANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
  }
}
pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>