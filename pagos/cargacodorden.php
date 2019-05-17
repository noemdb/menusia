<?php include ("../class/conect.php");  include ("../class/funciones.php");  $password=$_GET["password"];$user=$_GET["user"]; $dbname=$_GET["dbname"]; $criterio=$_GET["criterio"]; $codigo_mov=$_GET["codigo_mov"]; $port=$_GET["port"]; $host=$_GET["host"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);
$referencia_caus=substr($criterio,4,8);  $tipo_causado=substr($criterio,0,4);
$sql="SELECT * FROM codigos_causados where referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' and tipo_causado<>'0000' order by cod_presup";$res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $monto=$registro["monto"]-$registro["pagado"]-$registro["ajustado"];
  if($monto>0){
    $cod_presup=$registro["cod_presup"]; $fuente=$registro["fuente_financ"];  $cod_contable=$registro["cod_contable"]; $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"];
    $fecha=$registro["fecha_causado"]; $tipo_imput_presu=$registro["tipo_imput_presu"]; $ref_imput_presu=$registro["ref_imput_presu"];
    if($tipo_imput_presu=="C"){$montoc=$monto;}else{$montoc=0;}
    $ssql="SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente','$referencia_comp','$tipo_compromiso','$referencia_caus','$tipo_causado','','0000','','0000','C','','','$cod_contable','','','$fecha','C','$tipo_imput_presu','$ref_imput_presu','$fecha',0,$monto,0,0)";
    $resultado=pg_exec($conn,$ssql); $error=pg_errormessage($conn);
  }
}
?><iframe src="Det_inc_ajustes_orden.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
<?pg_close();?>