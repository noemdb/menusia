<?include ("../class/conect.php");  include ("../class/funciones.php");  $cod_banco=$_GET["cod_banco"];$codigo_mov=$_GET["codigo_mov"];  $orden=$_GET["orden"]; $_GET["monto"];  $monto=formato_numero($monto); if(is_numeric($monto)){$monto=$monto;} else{$monto=0;}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");

$resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");

$Ssql="SELECT cod_banco,nombre_banco,nro_cuenta,descripcion_banco,tipo_cuenta,cod_contable FROM ban002 where cod_banco='".$cod_banco."'";  $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado);
if ($filas>0){ $registro=pg_fetch_array($resultado,0); $codc_banco=$registro["cod_contable"]; 
$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','00000000','C','$codc_banco','00000','',$monto,'D','B','N','01','0','')"); }

$Ssql="Select * from ORD_PAGO_ANT where  nro_orden='$orden'"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado);
if ($filas>0){ $registro=pg_fetch_array($resultado,0); $codc_orden=$registro["cod_contable_o"]; 
$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','00000000','D','$codc_orden','00000','',$monto,'D','B','N','01','0','')"); }


 ?><iframe src="Det_inc_comp_chq_fin.php?codigo_mov=<?echo $codigo_mov?>" width="940" height="300" scrolling="auto" frameborder="1"></iframe>