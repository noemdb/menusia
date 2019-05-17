<?include ("../class/conect.php"); include ("../class/funciones.php"); $cod_campo=$_GET["cod_campo"];  $cod_arch=$_GET["cod_arch"];  $nombre_campo="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if($cod_campo!="999"){$StrSQL="Select nombre_campo from NOM051 WHERE cod_campo='$cod_campo' and cod_arch='$cod_arch'"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $nombre_campo=$registro["nombre_campo"];}  } pg_close();?>
<?if($cod_campo=="999"){?><input class="Estilo10" name="txtcar_especial" type="text" id="txtcar_especial" size="80" maxlength="80" onFocus="encender(this)" onBlur="apagar(this)"  > <?}
else{?><input class="Estilo10" name="txtcar_especial" type="text" id="txtcar_especial" size="80" maxlength="80" readonly  value="<?echo $nombre_campo?>"> <?}?>



