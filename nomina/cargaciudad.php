<?include ("../class/conect.php"); include ("../class/funciones.php"); $ciudad=$_GET["ciudad"];$cod_estado=$_GET["cod_estado"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="select cod_ciudad,nombre_ciudad from PRE094 where substr(cod_ciudad,1,2)='".$cod_estado."' order by cod_ciudad";  $res=pg_query($StrSQL);
//echo $cod_estado.$StrSQL;
?><select class="Estilo10" name="txtciudad" id="txtciudad" onFocus="encender(this)" onBlur="apagar(this);">  <?
while($registro=pg_fetch_array($res)){$codigo=$registro["cod_ciudad"];  $nombre=$registro["nombre_ciudad"];
if($nombre==$ciudad){?><option value="<? echo $nombre;?>" selected><? echo $nombre;?></option>
<?}else{?><option value="<? echo $nombre;?>"><? echo $nombre;?></option> <?}}?></select><?pg_close();?>