<?include ("../class/conect.php");  include ("../class/funciones.php"); $cod_concepto=$_GET["cod_concepto"]; $tipo_nomina=$_GET["tipo_nomina"];  $cod_retencion="000"; $frec="1";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $StrSQL="Select * from NOM002 WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto'";
$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado); $cod_retencion=$registro["cod_retencion"]; $frec=$registro["frecuencia"];} pg_close();?>
<input name="txtcod_retencion" type="text" id="txtcod_retencion" size="4" maxlength="3" value="<?echo $cod_retencion?>" onFocus="encender(this)" onBlur="apagar(this)">