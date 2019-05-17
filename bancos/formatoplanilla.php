<?include ("../class/conect.php"); $codigo=$_GET["codigo"];$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $formato="Rpt_planilla_ret.php";
$StrSQL="select* from ban011 where codigo='$codigo'"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $formato=$registro["formato_planilla"];}
pg_close();?><input name="txtformato_planilla" type="text" id="txtformato_planilla" value="<?echo $formato?>" readonly>