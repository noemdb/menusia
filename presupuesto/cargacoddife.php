<?php include ("../class/conect.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$password=$_GET["password"];$user=$_GET["user"]; $dbname=$_GET["dbname"]; $criterio=$_GET["criterio"]; $codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $Nom_Emp=busca_conf(); 
$resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$referencia_dife=substr($criterio,4,8); $tipo_diferido=substr($criterio,0,4);   $fecha=asigna_fecha_hoy(); $sfecha=formato_aaaammdd($fecha);
$sql="SELECT * FROM CODIGOS_DIFERIDOS where referencia_dife='$referencia_dife' and tipo_diferido='$tipo_diferido' and monto_compromiso=0 order by cod_presup";$res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $monto=$registro["monto_diferido"]-$registro["monto_compromiso"];
  if($monto>0){    $cod_presup=$registro["cod_presup"];    $fuente=$registro["fuente_financ"];    $cod_contable=$registro["cod_contable"];
    $fecha=$sfecha;     $tipo_imput_presu="P"; $ref_imput_presu="00000000"; $causado=$monto; $causc=0; $montoc=0;
    if($tipo_imput_presu=="C"){$montoc=$monto; $causc=$monto; }else{$montoc=0; $causc=0;}
    $ssql="SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente','','0000','','0000','','0000','','0000','','','','$cod_contable','','','$fecha','C','$tipo_imput_presu','$ref_imput_presu','$fecha',$causado,$monto,$causc,$montoc)";
    $resultado=pg_exec($conn,$ssql);    $error=pg_errormessage($conn);
  }
}
?>
<iframe src="Det_inc_compromisos_dife.php?codigo_mov=<?echo $codigo_mov?>" width="850" height="300" scrolling="auto" frameborder="1">
</iframe>
<?pg_close();?>