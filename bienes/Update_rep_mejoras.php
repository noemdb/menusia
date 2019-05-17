<?include ("../class/conect.php");  include ("../class/funciones.php");include ("../class/configura.inc");error_reporting(E_ALL);
$cod_bien_aso=$_POST["txtcod_bien_aso"]; $denominacion=$_POST["txtdenominacion"]; $cod_bien_mue=$_POST["txtcod_bien_mue"];
 $fecha_rep=$_POST["txtfecha_rep"]; $valor_rep=$_POST["txtvalor_rep"]; $campo_str1=""; $campo_str2=""; $monto1=0; $monto2=0; $fecha=asigna_fecha_hoy();
 $valor_rep=formato_numero($valor_rep);if(is_numeric($valor_rep)){$valor_rep=$valor_rep;} else{$valor_rep=0;}
$equipo = getenv("COMPUTERNAME"); $MInf_Usuario=$equipo." ".date("d/m/y H:i a"); $url="Det_rep_mejoras.php?cod_bien_mue=".$cod_bien_mue;
echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$error=0;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else {  $sSQL="Select * from BIEN058 WHERE cod_bien_aso='$cod_bien_aso' and cod_bien_mue='$cod_bien_mue'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL COMPONENTE NO EXISTE EN EL BIEN');</script><? }
  if($error==0){ if(checkData($fecha_rep)=='1'){ $fecha_rep=formato_aaaammdd($fecha_rep); } else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? } }
  if($error==0){ if($valor_rep<=0){$error=1; ?> <script language="JavaScript">muestra('VALOR NO ES VALIDA');</script><? } }  
  if($error==0){ $sfecha=formato_aaaammdd($fecha); $sql="SELECT ACTUALIZA_BIEN058(2,'$cod_bien_mue','$cod_bien_aso','$fecha_rep',$valor_rep,'$denominacion','$campo_str2',$monto1,$monto2)";
      $resultado=pg_exec($conn,$sql); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 90);     if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      //echo $sql;
	}
  }
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? } 
?>
