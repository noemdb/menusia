<?php include ("../class/conect.php");  include ("../class/funciones.php"); $cod_banco=$_GET["cod_banco"];$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];  $fecha=$_GET["fecha"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $disponible=0;
$StrSQL="select * from ban002 where cod_banco='$cod_banco'";$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado); $disponible=$registro["s_inic_libro"];
$nmes=substr($fecha,3, 2);  $m=$nmes*1; for ($i=1;$i<=$m;$i++){$spos=$i; If($i<=9){$spos="0".$spos;} $disponible=$disponible+$registro["deb_libro".$spos] - $registro["cre_libro".$spos]; } }
$saldo=formato_monto($disponible); pg_close();?><input class="Estilo10" name="txtsaldo" type="text" id="txtsaldo" value="<?echo $saldo?>" size="15" maxlength="15" style="text-align:right" readonly>