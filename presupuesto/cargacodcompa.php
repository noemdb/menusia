<?php  include ("../class/conect.php"); include ("../class/funciones.php"); $password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];  $criterio=$_GET["criterio"];  $codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX"; $campo502=""; 
$sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];  $campo502=$registro["campo502"];}
$long_c=strlen($formato_presup); $c=strlen($formato_categoria)+2; $p=strlen($formato_partida); $g_comprobante=substr($campo502,3,1); $aprueba_comp=substr($campo502,15,1);
$resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error,0,91);
$referencia_comp=substr($criterio,4,8); $tipo_compromiso=substr($criterio,0,4);
$sql="SELECT * FROM codigos_compromisos where referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso'  and (tipo_compromiso<>'0000') and (tipo_compromiso<>'A000')order by cod_presup"; 
if($aprueba_comp=="S"){$sql="SELECT * FROM codigos_compromisos where (monto-causado-ajustado>0) and (tipo_compromiso<>'0000') and (tipo_compromiso<>'A000') and (referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso') and (text(referencia_comp)||text(tipo_compromiso) not in ( select text(referencia_comp)||text(tipo_compromiso) from pre006 where (anulado='S') )) order by cod_presup"; }
$res=pg_query($sql); 
while($registro=pg_fetch_array($res)){ $monto=$registro["monto"]-$registro["causado"]-$registro["ajustado"];
  if($monto>0){   $cod_presup=$registro["cod_presup"];    $fuente=$registro["fuente_financ"];
    $cod_contable=$registro["cod_contable"];    $fecha=$registro["fecha_compromiso"];
    $tipo_imput_presu=$registro["tipo_imput_presu"];    $ref_imput_presu=$registro["ref_imput_presu"];
    if($tipo_imput_presu=="C"){$montoc=$monto;}else{$montoc=0;}
    $ssql="SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente','$referencia_comp','$tipo_compromiso','','0000','','0000','','0000','','','','$cod_contable','','','$fecha','C','$tipo_imput_presu','$ref_imput_presu','$fecha',0,$monto,0,0)";
    $resultado=pg_exec($conn,$ssql);     $error=pg_errormessage($conn);
  }
}
?>
<iframe src="/sia/presupuesto/Det_inc_ajustes_comp.php?codigo_mov=<?echo $codigo_mov?>" width="850" height="300" scrolling="auto" frameborder="1">
</iframe>
<?pg_close();?>