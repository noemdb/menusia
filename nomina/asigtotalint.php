<?include ("../class/conect.php"); include ("../class/funciones.php"); $cod_empleado=$_GET["cod_empleado"];    $total_interes=0;  $fecha_calculo="";
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="Select fecha_calculo,total_interes from NOM030 WHERE cod_empleado='$cod_empleado' order by fecha_calculo desc,num_calculo desc";
$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado);$total_interes=$registro["total_interes"]; $fecha_calculo=$registro["fecha_calculo"];}
pg_close(); $total_interes=formato_monto($total_interes);  ?>
<input class="Estilo10" name="txttotal_interes" type="text" id="txttotal_interes" size="13" maxlength="12"  style="text-align:right" value="<?echo $total_interes?>" readonly>