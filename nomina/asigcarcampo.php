<?include ("../class/conect.php"); include ("../class/funciones.php"); $cod_campo=$_GET["cod_campo"];  $cod_arch=$_GET["cod_arch"];  $decimales_campo=0; $inicio=1; $tipo_campo="C";  $longitud_campo=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="Select * from NOM051 WHERE cod_campo='$cod_campo' and cod_arch='$cod_arch'"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_campo=$registro["tipo_campo"]; $longitud_campo=$registro["longitud_campo"];}
if(($tipo_campo=="N")and($longitud_campo>=14)){$decimales_campo=2; } pg_close();?>
<table width="830" border="0"> <tr>
<td width="40"><span class="Estilo5">TIPO: </span></td>
<td width="100"><input class="Estilo10" name="txttipo_campo" type="text" id="txttipo_campo" size="1" maxlength="1" value="<?echo $tipo_campo?>"  readonly ></span></td>
<td width="100"><span class="Estilo5">LONGITUD: </span></td>
<td width="100"><span class="Estilo5"><input class="Estilo10" name="txtlongitud_campo" type="text" id="txtlongitud_campo" size="3" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $longitud_campo?>" > </span></td>
<td width="100"><span class="Estilo5">DECIMALES: </span></td>
<td width="100"><span class="Estilo5"><input class="Estilo10" name="txtdecimales_campo" type="text" id="txtdecimales_campo" size="3" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $decimales_campo?>" > </span></td>
<td width="100"><span class="Estilo5">INICIO: </span></td>
<td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtpos_comienza" type="text" id="txtpos_comienza" size="3" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $inicio?>" > </span></td>
<td width="40"><span class="Estilo5">FIN: </span></td>
<td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtpos_finaliza" type="text" id="txtpos_finaliza" size="3" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $longitud_campo?>" > </span></td>
</tr> </table>