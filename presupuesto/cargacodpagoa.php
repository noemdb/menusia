<?php include ("../class/conect.php"); include ("../class/funciones.php"); $password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];  $criterio=$_GET["criterio"]; $codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);
$referencia_pago=substr($criterio,4,8);  $tipo_pago=substr($criterio,0,4); $referencia_caus=substr($criterio,16,8);  $tipo_causado=substr($criterio,12,4); $referencia_comp=substr($criterio,28,8); $tipo_compromiso=substr($criterio,24,4);
$sql="SELECT * FROM codigos_pagos where referencia_pago='$referencia_pago' and tipo_pago='$tipo_pago' and referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and tipo_causado<>'0000' order by cod_presup";
$res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $monto=$registro["monto"]-$registro["ajustado"];
  if($monto>0){    $cod_presup=$registro["cod_presup"];    $fuente=$registro["fuente_financ"];  $cod_contable=$registro["cod_contable"];
    $fecha=date("y/m/d");  $tipo_imput_presu=$registro["tipo_imput_presu"];    $ref_imput_presu=$registro["ref_imput_presu"];
    if($tipo_imput_presu=="C"){$montoc=$monto;}else{$montoc=0;}
    $ssql="SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente','$referencia_comp','$tipo_compromiso','$referencia_caus','$tipo_causado','$referencia_pago','$tipo_pago','','0000','C','','','$cod_contable','','','$fecha','C','$tipo_imput_presu','$ref_imput_presu','$fecha',0,$monto,0,0)";
    $resultado=pg_exec($conn,$ssql); $error=pg_errormessage($conn);
  }
}
?>
<iframe src="Det_inc_ajustes_pago.php?codigo_mov=<?echo $codigo_mov?>" width="850" height="300" scrolling="auto" frameborder="1">
</iframe>
<?pg_close();?>