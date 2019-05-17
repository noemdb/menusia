<?include ("../class/conect.php");  include ("../class/funciones.php");  $cod_banco=$_GET["cod_banco"]; $cedrif=$_GET["cedrif"]; $tipomov=$_GET["tipomov"];  $codigo_mov=$_GET["codigo_mov"]; $password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"]; $monto=$_GET["monto"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $codc_banco="";  $deb_cre="N";
$Ssql="SELECT cod_banco,nombre_banco,nro_cuenta,descripcion_banco,tipo_cuenta,cod_contable FROM ban002 where cod_banco='".$cod_banco."'";  $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if ($filas>0){ $registro=pg_fetch_array($resultado,0); $codc_banco=$registro["cod_contable"]; }  $monto=formato_numero($monto); if(is_numeric($monto)){$monto=$monto;} else{$monto=0;}
$Ssql="SELECT * FROM ban003 Where (tipo_movimiento='".$tipomov."')"; $resultado=pg_query($Ssql);  $filas=pg_num_rows($resultado); if ($filas>0){ $registro=pg_fetch_array($resultado,0); $deb_cre=$registro["tipo"]; }
$resultado=pg_exec($conn,"SELECT INCLUYE_BAN030(1,'$codigo_mov','$cod_banco','00000000','0001','01-01-2008','01-01-2008','01-01-2008','$deb_cre','N','$cedrif','$tipomov',$monto,0,'')");
if(($deb_cre=="D")or($deb_cre=="C")){$error=0;}else{$error=1; }
if ($error==0){ $sSQL="Select * from con001 WHERE codigo_cuenta='$codc_banco'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
   if ($filas==0){$error=1; } else{$registro=pg_fetch_array($resultado); if ($registro["cargable"]=="N"){$error=1;} }
}
if ($error==0){$resultado=pg_exec($conn,"SELECT ACT_DEB_CON010('$codigo_mov','00000000','$deb_cre','$codc_banco','00000','$tipomov',$monto,'D','B','N','01','0','')"); }
 ?><iframe src="Det_inc_comp_libro.php?codigo_mov=<?echo $codigo_mov?>" width="840" height="250" scrolling="auto" frameborder="1"></iframe>