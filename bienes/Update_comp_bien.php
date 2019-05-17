<?include ("../class/conect.php");  include ("../class/funciones.php");include ("../class/configura.inc");error_reporting(E_ALL);
$cod_componente=$_POST["txtcod_componente"]; $des_componente=$_POST["txtdes_componente"]; $cod_bien_mue=$_POST["txtcod_bien_mue"];
 $marca=$_POST["txtmarca"]; $modelo=$_POST["txtmodelo"]; $serial1=$_POST["txtserial1"]; $serial2="";
//cod_bien_mue,cod_componente,des_componente,marca,modelo,serial1,serial2,
$campo_str1=""; $campo_str2=""; $monto1=0; $monto2=0; $fecha=asigna_fecha_hoy();
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a"); $url="Det_componentes_bienes.php?cod_bien_mue=".$cod_bien_mue;
echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$error=0;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else { $tipo="I";
  $sSQL="Select * from BIEN053 WHERE cod_componente='$cod_componente' and cod_bien_mue='$cod_bien_mue'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL  COMPONENTE NO EXISTE EN EL BIEN');</script><? }
  if($error==0){ $sfecha=formato_aaaammdd($fecha); $sql="SELECT ACTUALIZA_BIEN053(2,'$cod_bien_mue','$cod_componente','$des_componente','$marca','$modelo','$serial1','$serial2','$campo_str1','$campo_str2',$monto1,$monto2)";
      $resultado=pg_exec($conn,$sql); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91);     if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      echo $sql;
	}
  }
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? } 
?>

