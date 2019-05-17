<?include ("../class/conect.php"); include ("../class/funciones.php");  $tipo_nomina=$_GET["tipo_nomina"]; $tp_calculo=$_GET["tp_calculo"]; $num_periodos=$_GET["num_periodos"]; $codigo_mov=$_GET["codigo_mov"]; $password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"]; $fecha_desde=""; $fecha_hasta="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if($tp_calculo=="N"){ $num_periodos=1; }
$StrSQL="select fecha_p_desde,fecha_p_hasta from nom017 where (tipo_nomina='$tipo_nomina') and (tp_calculo='$tp_calculo') and (num_periodos=$num_periodos)  order by fecha_p_desde"; $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $fecha_desde=$registro["fecha_p_desde"]; $fecha_hasta=$registro["fecha_p_hasta"];  $fecha_desde=formato_ddmmaaaa($fecha_desde); $fecha_hasta=formato_ddmmaaaa($fecha_hasta);  }
pg_close();    ?>
<table width="946"><tr>
 <td width="190"><span class="Estilo5">FECHA PROCESO DESDE : </span></td>
 <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtfecha_desde" type="text" id="txtfecha_desde"  size="10" maxlength="10" readonly value="<?echo $fecha_desde?>"> </span></td>
 <td width="190"><span class="Estilo5">FECHA PROCESO HASTA : </span></td>
 <td width="250"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta"  size="10" maxlength="10" readonly value="<?echo $fecha_hasta?>"> </span></td>
</tr> </table>