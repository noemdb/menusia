<?include ("../class/conect.php");  include ("../class/funciones.php"); 
if($_GET["fechad"]){$fechad=$_GET["fechad"];$fechah=$_GET["fechah"];$cod_banco=$_GET["cod_banco"];$codigo_mov=$_GET["codigo_mov"];$nro_cheque=$_GET["ncheque"]; $tipo_pago=$_GET["tpago"]; $fecha=$_GET["fecha"];}else{$fecha_hoy=asigna_fecha_hoy();$fechad=$fecha_hoy;$fechah=$fecha_hoy;$cod_banco="0000";$codigo_mov="";$nro_cheque="00000000";$tipo_pago="0001";$fecha=asigna_fecha_hoy();}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $c_banco="0000";  $Ssql="Select * from SIA005 where campo501='01'"; $resultado=pg_query($Ssql);
if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if(substr($campo502,8,1)=="S"){$c_banco=$cod_banco;} }
$sfecha=formato_aaaammdd($fecha);  $sfechad=formato_aaaammdd($fechad); $sfechah=formato_aaaammdd($fechah);  $resultado=pg_exec($conn,"SELECT CARGAR_PAG027('$codigo_mov','$c_banco','$sfechad','$sfechah','N')");
$resultado=pg_exec($conn,"SELECT ACTUALIZA_BAN030(2,'$codigo_mov','$cod_banco','$nro_cheque','$tipo_pago','$sfecha','$sfechad','$sfechah','N','N','')");  pg_close();
?><iframe src="Det_ordenes_canc.php?codigo_mov=<?echo $codigo_mov?>&orden=N&mostrar=S" width="940" height="350" scrolling="auto" frameborder="1"></iframe>