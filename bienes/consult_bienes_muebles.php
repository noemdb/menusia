<?include ("../class/conect.php");  include ("../class/funciones.php");error_reporting(E_ALL);
$num_bien=$_POST["txtnum_bien"]; $error=0; $equipo=getenv("COMPUTERNAME"); echo "ESPERE POR FAVOR BUSCANDO....","<br>";
if ($error==0){
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   if (pg_ErrorMessage($conn)) {$error=1; ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
  $sSQL="Select * from BIEN015 where num_bien='$num_bien'";  $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('NUMERO DE BIEN NO EXISTE');</script><?}
    else{ $registro=pg_fetch_array($resultado);$cod_bien_mue=$registro["cod_bien_mue"];  $cod_clasificacion=$registro["cod_clasificacion"];  $num_bien=$registro["num_bien"];  $des_desincorporado=$registro["des_desincorporado"]; $desincorporado=$registro["desincorporado"];   
	  If($desincorporado=="S"){ ?><script language="JavaScript">muestra('NUMERO DE BIEN ESTA DESINCORPORADO');</script><? }
	}
}
pg_close(); error_reporting(E_ALL ^ E_WARNING); if ($error==0){?><script language="JavaScript">document.location ='Act_fichas_bienes_muebles_pro.php?Gcod_bien_mue=<? echo $cod_bien_mue; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }  ?>