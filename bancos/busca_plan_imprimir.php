<? include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else { $Nom_Emp=busca_conf(); }
$cod_banco=$_GET["cod_banco"]; $num_cheque=$_GET["num_cheque"]; $referencia=$_GET["referencia"]; $tipo_mov=$_GET["tipo_mov"]; $tipo_p=$_GET["tipo"];
$error=0; $ano_fiscal="2014";$mes_fiscal="01";$nro_comprobante="";$nro_orden="";
$sql="SELECT * FROM BAN012 where referencia='$referencia' and tipo_mov='$tipo_mov' and cod_banco='$cod_banco' order by tipo_retencion,nro_planilla";  $res=pg_query($sql); $filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res); $nro_orden=$registro["nro_orden"]; $aux_o=$registro["aux_orden"];} 
$nombre_planilla="Rpt_planilla_ret.php";   
$StrSQL="select* from ban011 where codigo='$tipo_p'"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $nombre_planilla=$registro["formato_planilla"];}
pg_close(); $url="../pagos/rpt/".$nombre_planilla."?orden=".$nro_orden.'&tipo='.$tipo_p; //echo $url;
IF($error==0){?> <script language="JavaScript"> document.location ='<? echo $url; ?>'; </script> <?} else{?> <script language="JavaScript"> window.close();  </script><?}
?>