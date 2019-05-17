<?include ("../../class/conect.php");  include ("../../class/funciones.php"); $nro_linea=1; 
$fecha=$_POST["txtfecha"]; $referencia=$_POST["txtreferencia"];
$codigo_mov=$_POST["txtcodigo_mov"]; $tipo_asiento=$_POST["txttipo_asiento"];
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a"); 
$url="Det_inc_comp_rpt.php?codigo_mov=".$codigo_mov; echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");  

if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
   else{ if (checkData($fecha)=='1'){$error=0; $sfecha=formato_aaaammdd($fecha);}else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
      if ($error==0){ $sSQL="Select referencia from con018 WHERE codigo_mov='$codigo_mov' and referencia='$referencia' and tipo_asiento='$tipo_asiento' and fecha='$sfecha'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
       if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('COMPROBANTE YA EXISTE EN LA LISTA');</script><? } }
      if ($error==0){ $sSQL="SELECT INCLUYE_CON018('$codigo_mov','$referencia','$sfecha','00000','$tipo_asiento','N','N','','',0,0,'')";
	  $resultado=pg_exec($conn,$sSQL); echo $sSQL; $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61);if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{ $error=0;}
      }
} pg_close(); 
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}
?>