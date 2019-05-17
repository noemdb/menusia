<?include ("../class/conect.php"); include ("../class/funciones.php"); $cod_empleado=$_GET["cod_empleado"];    $saldo_prestaciones=0;  $fecha_calculo="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="Select fecha_calculo,saldo_prestaciones from NOM030 WHERE cod_empleado='$cod_empleado' order by fecha_calculo desc,num_calculo desc";
$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado);$saldo_prestaciones=$registro["saldo_prestaciones"]; $fecha_calculo=$registro["fecha_calculo"];}
$StrSQL="Select sum(monto_adelanto) as monto_a from NOM031 WHERE cod_empleado='$cod_empleado'";
$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado); $monto_a=$registro["monto_a"]; $saldo_prestaciones=$saldo_prestaciones-$monto_a; }
pg_close(); $saldo_prestaciones=formato_monto($saldo_prestaciones); ?>
<input class="Estilo10" name="txtsaldo_prestaciones" type="text" id="txtsaldo_prestaciones" size="13" maxlength="12"  style="text-align:right" value="<?echo $saldo_prestaciones?>" readonly>