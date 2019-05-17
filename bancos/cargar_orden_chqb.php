<?include ("../class/conect.php");  include ("../class/funciones.php"); 
if($_GET["fechad"]){$fechad=$_GET["fechad"];$fechah=$_GET["fechah"];$cod_banco=$_GET["cod_banco"];$codigo_mov=$_GET["codigo_mov"];$nro_cheque=$_GET["ncheque"]; $tipo_pago=$_GET["tpago"]; $fecha=$_GET["fecha"];$ced_rif=$_GET["cedrif"]; $soloret=$_GET["soloret"]; $tipo_ret_d=$_GET["tipord"];  $tipo_ret_h=$_GET["tiporh"];}
else{$fecha_hoy=asigna_fecha_hoy();$fechad=$fecha_hoy;$fechah=$fecha_hoy;$cod_banco="0000";$codigo_mov="";$nro_cheque="00000000";$tipo_pago="0001";$fecha=asigna_fecha_hoy();$ced_rif="";$soloret="SI"; $tipo_ret_d="000";  $tipo_ret_h="999";}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $c_banco="0000";  $Ssql="Select * from SIA005 where campo501='01'"; $resultado=pg_query($Ssql);
if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if(substr($campo502,8,1)=="S"){$c_banco=$cod_banco;} }
$sfechad=formato_aaaammdd($fechad); $sfechah=formato_aaaammdd($fechah);  $temp_tipo=$tipo_ret_d.$tipo_ret_h;
$resultado=pg_exec($conn,"SELECT BORRAR_PAG027('$codigo_mov')");
if($soloret=="NO"){$resultado=pg_exec($conn,"SELECT CARGARB_PAG027('$codigo_mov','$c_banco','$sfechad','$sfechah','N','$ced_rif')"); }
  $resultado=pg_exec($conn,"SELECT CARGARET_PAG027('$codigo_mov','$tipo_ret_d','$tipo_ret_h','$sfechad','$sfechah','$ced_rif')"); 
//echo "SELECT CARGARB_PAG027('$codigo_mov','$c_banco','$sfechad','$sfechah','N','$ced_rif')";
//echo "SELECT CARGARET_PAG027('$codigo_mov','000','999','$sfechad','$sfechah','$ced_rif')";
$resultado=pg_exec($conn,"SELECT INCLUYE_BAN030(1,'$codigo_mov','$cod_banco','$nro_cheque','$tipo_pago','$fecha','$fechad','$fechah','N','N','$ced_rif','$temp_tipo',0,0,'')");  pg_close();
?><iframe src="Det_ordenes_canc.php?codigo_mov=<?echo $codigo_mov?>&orden=N&mostrar=N" width="940" height="350" scrolling="auto" frameborder="1"></iframe>