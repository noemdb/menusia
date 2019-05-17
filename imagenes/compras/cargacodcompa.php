<?php  $password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];  $criterio=$_GET["criterio"];  $codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
$resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);
$referencia_comp=substr($criterio,4,8); $tipo_compromiso=substr($criterio,0,4);
$sql="SELECT * FROM codigos_compromisos where referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso'  order by cod_presup"; $res=pg_query($sql);
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto"]-$registro["causado"]-$registro["ajustado"];
  if($monto>0){   $cod_presup=$registro["cod_presup"];    $fuente=$registro["fuente_financ"];    $cod_contable=$registro["cod_contable"];    $fecha=$registro["fecha_compromiso"];
    $tipo_imput_presu=$registro["tipo_imput_presu"];    $ref_imput_presu=$registro["ref_imput_presu"];    if($tipo_imput_presu=="C"){$montoc=$monto;}else{$montoc=0;}
    $ssql="SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente','$referencia_comp','$tipo_compromiso','','0000','','0000','','0000','','','','$cod_contable','','','$fecha','C','$tipo_imput_presu','$ref_imput_presu','$fecha',0,$monto,0,0)";
    $resultado=pg_exec($conn,$ssql);     $error=pg_errormessage($conn);
  }
}pg_close();?>
<iframe src="/sia/presupuesto/Det_inc_ajustes_comp.php?codigo_mov=<?echo $codigo_mov?>" width="850" height="300" scrolling="auto" frameborder="1">
</iframe>