<?include ("../../class/conect.php");  include ("../../class/funciones.php"); $error=0;
if (!$_GET){$cod_banco='';$num_cheque=''; }  else{$cod_banco=$_GET["cod_banco"];$num_cheque=$_GET["num_cheque"];}
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * from edo_cheques where cod_banco='$cod_banco' and num_cheque='$num_cheque'";
$sql="Select * from bancos where cod_banco='$cod_banco'"; $formato_cheque="Rpt_formato_chq.php"; $formato="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0);  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $formato=$registro["formato_cheque"];}
if($formato<>""){$formato_cheque=$formato;}
pg_close();
$url="/sia/bancos/rpt/".$formato_cheque."?cod_banco=".$cod_banco."&num_cheque=".$num_cheque;
//cho $url." ".$error;
if ($error==0){?><script language="JavaScript"> document.location="<?echo $url; ?>"; </script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }
?>
