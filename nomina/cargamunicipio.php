<?include ("../class/conect.php"); include ("../class/funciones.php"); if($_GET["municipio"]){$municipio=$_GET["municipio"];$cod_estado=$_GET["cod_estado"];}else{$municipio="";$cod_estado="";}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="select cod_municipio,nombre_municipio from PRE093 where substr(cod_municipio,1,2)='".$cod_estado."'  order by cod_municipio";  $res=pg_query($StrSQL);
?><select class="Estilo10" name="txtmunicipio" id="txtmunicipio" onFocus="encender(this)" onBlur="apagar(this);" onchange="chequea_municipio(this.form)" >  <?
while($registro=pg_fetch_array($res)){$codigo=$registro["cod_municipio"];  $nombre=$registro["nombre_municipio"];
if($nombre==$municipio){ ?><option value="<? echo $codigo;?>" selected><? echo $nombre;?></option>
<?}else{?><option value="<? echo $codigo;?>"><? echo $nombre;?></option> <?}}?></select><?pg_close();?>