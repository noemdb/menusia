<?include ("../class/conect.php");  include ("../class/funciones.php"); $cod_cargo=$_GET["cod_cargo"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0; $monto_sueldo=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select * from NOM004 WHERE codigo_cargo='$cod_cargo'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas>0){ $registro=pg_fetch_array($resultado); $monto_sueldo=$registro["sueldo_cargo"];  $monto_sueldo=formato_monto($monto_sueldo); }  }
?>
<input class="Estilo10" name="txtsueldo" type="text" id="txtsueldo" size="16" maxlength="16" style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<? echo $monto_sueldo;?>"  onKeypress="return validarNum(event)">
