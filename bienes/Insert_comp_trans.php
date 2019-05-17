<?include ("../class/conect.php");  include ("../class/funciones.php");include ("../class/configura.inc");error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"];$cod_bien_mue=$_POST["txtcod_bien_mue"];$cod_componente=$_POST["txtcod_componente"]; $cod_bien_r=$_POST["txtcod_bien_r"]; $cod_componente_r=$_POST["txtcod_componente_r"];
$fecha=asigna_fecha_hoy(); $monto_c=0;
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a"); $url="Det_inc_trans_comp_bienes.php?codigo_mov=".$codigo_mov;
echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$error=0;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else {  $sSQL="Select * from BIEN050 WHERE codigo_mov='$codigo_mov' and cod_bien='$cod_bien_mue' and campo_str1='$cod_componente'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN YA EXISTE EN LA TRANSFERENCIA');</script><? }
  if($error==0){ $sSQL="Select * from BIEN015 WHERE cod_bien_mue='$cod_bien_mue'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN EMISOR NO EXISTE');</script><? }  
	    else{  $registro=pg_fetch_array($resultado); $desincorporado=$registro["desincorporado"];  if($desincorporado=="S"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN EMISOR ESTA DESINCORPORADO');</script><?} }  }		
  if($error==0){ $sSQL="Select * from BIEN015 WHERE cod_bien_mue='$cod_bien_r'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN RECEPTOR NO EXISTE');</script><? }  
	    else{  $registro=pg_fetch_array($resultado); $desincorporado=$registro["desincorporado"];  if($desincorporado=="S"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN RECEPTOR ESTA DESINCORPORADO');</script><?} }
  }
  if($error==0){ $sSQL="Select * from BIEN053 WHERE cod_bien_mue='$cod_bien_mue' and cod_componente='$cod_componente'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO COMPONENETE NO EXISTE EN EL BIEN EMISOR ');</script><? }   
  }  
  if($error==0){ $sSQL="Select * from BIEN053 WHERE cod_bien_mue='$cod_bien_r' and cod_componente='$cod_componente_r'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
      if ($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('CODIGO COMPONENTE YA EXISTE EN EL BIEN RECEPTOR');</script><? }   
  }
  if($error==0){ if($cod_bien_mue==$cod_bien_r){ $error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN RECEPTOR NO PUEDE SER IGUAL AL EMISOR');</script><? }   }  
  if($error==0){ $sfecha=formato_aaaammdd($fecha);  $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN050(1,'$codigo_mov','$cod_componente_r','$sfecha','$cod_bien_mue','','D','',1,$monto_c,'$cod_componente','$cod_bien_r',0,0)");
      $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
    }
}  
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? } ?>

