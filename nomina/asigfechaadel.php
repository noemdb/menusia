<?include ("../class/conect.php"); include ("../class/funciones.php"); $cod_empleado=$_GET["cod_empleado"];    $total_interes=0;  $fecha_calculo="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="Select fecha_calculo,total_interes from NOM030 WHERE cod_empleado='$cod_empleado' order by fecha_calculo desc,num_calculo desc";
$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado); $total_interes=$registro["total_interes"]; $fecha_calculo=$registro["fecha_calculo"];}
$StrSQL="Select fecha_adelanto from NOM031 WHERE cod_empleado='$cod_empleado' order by fecha_adelanto desc";
$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado); $fecha_calculo=$registro["fecha_adelanto"];}
pg_close();$fecha_calculo=formato_ddmmaaaa($fecha_calculo);?>
<input class="Estilo10" name="txtfecha_calculo" type="text" id="txtfecha_calculo" size="10" maxlength="10"  value="<?echo $fecha_calculo?>" readonly>