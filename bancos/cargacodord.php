<?php include ("../class/conect.php");  include ("../class/funciones.php"); $password=$_GET["password"];  $user=$_GET["user"];$dbname=$_GET["dbname"]; $criterio=$_GET["criterio"]; $codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);$nro_orden=$criterio; 
$sql="SELECT * FROM pag001 where nro_orden='$nro_orden' and status='N' and anulado='N'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>=1){$registro=pg_fetch_array($res,0); $tipo_causado=$registro["tipo_causado"]; $ret_presup=$registro["genera_p_ret"]; $genera_orden_r=$registro["genera_orden_r"]; $total_retencion=$registro["total_retencion"]; $referencia_caus=$nro_orden;
    $sql="SELECT * FROM codigos_causados where referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' order by cod_presup"; $res=pg_query($sql); 
	while($registro=pg_fetch_array($res)){ $monto=$registro["monto"]-$registro["ajustado"];   $monto=$registro["monto"]-$registro["ajustado"]-$registro["pagado"];   
	  if($monto>0){    $cod_presup=$registro["cod_presup"];   $fuente=$registro["fuente_financ"]; $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"];
		$cod_contable=$registro["cod_contable"];    $fecha=$registro["fecha_causado"];     $tipo_imput_presu=$registro["tipo_imput_presu"];    $ref_imput_presu=$registro["ref_imput_presu"];  
		if(($genera_orden_r=="N") and ($ret_presup=="S")  and ($total_retencion>0)) {	$sqlr="select sum(monto_retencion) as monto_retencion from pag004 where (nro_orden_ret='$nro_orden') and (cod_presup_ret='$cod_presup') and (fuente_fin_ret='$fuente') and (status_r='N')";	 $resr=pg_query($sqlr); 
			 while($reg=pg_fetch_array($resr)){ $monto_r=$reg["monto_retencion"]; $monto=$monto-$monto_r; }  //echo $sqlr." ".$monto;
		}
		if($tipo_imput_presu=="C"){$montoc=$monto;}else{$montoc=0;}
		$ssql="SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente','$referencia_comp','$tipo_compromiso','$referencia_caus','$tipo_causado','','0000','','0000','C','','','$cod_contable','','','$fecha','C','$tipo_imput_presu','$ref_imput_presu','$fecha',$monto,$monto,$montoc,$montoc)";
		$resultado=pg_exec($conn,$ssql);     $error=pg_errormessage($conn);// echo $ssql;
	  }
	} 
}
?>
<iframe src="../presupuesto/Det_inc_pagos_caus.php?codigo_mov=<?echo $codigo_mov?>" width="950" height="300" scrolling="auto" frameborder="1">
</iframe>
<?pg_close();?>