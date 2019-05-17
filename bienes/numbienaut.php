<?php include ("../class/conect.php");  include ("../class/funciones.php"); $cod_clasi=$_GET["cod_clasi"];  $num_bien_unico=$_GET["num_bien_unico"]; $long=$_GET["long_num_bien"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $ult_ref="00000001";
if($num_bien_unico==="S"){$StrSQL="select max(num_bien) as referencia from bien015";}else{$StrSQL="select max(num_bien) as referencia from bien015 Where (cod_clasificacion='$cod_clasi')";} 
$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado); $ult_ref=$registro["referencia"]+1; $len=strlen($ult_ref); 
if($long>0){ $ult_ref=substr("000000000000000",0,$long-$len).$ult_ref; } } 
pg_close(); ?>
<input class="Estilo10" name="txtnum_bien" type="text" id="txtnum_bien" size="20" maxlength="<?php echo $long?>" value="<?php echo $ult_ref?>" onFocus="encender(this)" onBlur="apaga_numbien(this)" >



