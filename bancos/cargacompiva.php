<?include ("../class/conect.php");  include ("../class/funciones.php"); 
$password=$_GET["password"];$user=$_GET["user"]; $dbname=$_GET["dbname"];$codigo_mov=$_GET["codigo_mov"]; $mes=$_GET["mes"]; $ano=$_GET["ano"]; $desde=$_GET["desde"]; $hasta=$_GET["hasta"]; $tipo_comp=$_GET["tipo_comp"]; $desde=formato_aaaammdd($desde); $hasta=formato_aaaammdd($hasta);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); 
$sql="SELECT CARGA_BAN029('$codigo_mov','$ano','$mes','$desde','$hasta')"; if($tipo_comp==="ORDEN CANCELADA"){ $sql="SELECT CARGA_BAN029_CANC('$codigo_mov','$ano','$mes','$desde','$hasta')";  } if($tipo_comp==="CHEQUE ENTREGADO"){ $sql="SELECT CARGA_BAN029_ENT('$codigo_mov','$ano','$mes','$desde','$hasta')";  }
$resultado=pg_exec($conn,$sql); $error=pg_errormessage($conn); $error=substr($error, 0, 61); pg_close();?>
<iframe src="Det_dec_ret_iva.php?codigo_mov=<?echo $codigo_mov?>" width="940" height="350" scrolling="auto" frameborder="1"></iframe>
