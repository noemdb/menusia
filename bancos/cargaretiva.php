<?include ("../class/conect.php");  include ("../class/funciones.php"); 
$password=$_GET["password"];$user=$_GET["user"]; $dbname=$_GET["dbname"]; $criterio=$_GET["criterio"]; $codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$resultado=pg_exec($conn,"SELECT BORRAR_BAN029('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$referencia=substr($criterio,0,8);  $tipo_mov='O/P'; $cod_banco='0000';
$sql="SELECT ced_rif,fecha,total_causado,total_retencion,total_ajuste,total_pagado,tipo_documento,nro_documento FROM PAG001 Where (nro_orden='$referencia')";
$resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);if ($filas>0){$reg=pg_fetch_array($resultado); $ced_rif=$reg["ced_rif"]; $fecha_ord=$reg["fecha"]; $tipo_d=$reg["tipo_documento"]; $nro_fact=$reg["nro_documento"]; $neto_ord=$reg["total_causado"]-$reg["total_retencion"]-$reg["total_ajuste"];} else{ $ced_rif=""; $fecha_ord=""; $tipo_d=""; $nro_fact=""; $neto_ord=0; }  $neto_ord=cambia_coma_numero($neto_ord);
$sql="SELECT pag004.nro_orden_ret,pag004.tipo_retencion,pag004.aux_orden,pag004.tasa_retencion,sum(pag004.monto_objeto_ret) as monto_objeto,sum(pag004.monto_retencion) as monto_retencion From pag004,pag003 Where (pag003.ret_Grupo='A') and (pag003.tipo_retencion=pag004.tipo_retencion) and (nro_orden_ret='$referencia') group by pag004.nro_orden_ret,pag004.tipo_retencion,pag004.aux_orden,pag004.tasa_retencion order by pag004.nro_orden_ret,pag004.tipo_retencion";
$resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);if ($filas>0){$reg=pg_fetch_array($resultado); $tasa_retencion=$reg["tasa_retencion"];} else{$tasa_retencion=0;}
$sql="SELECT nro_factura,nro_con_factura,fecha_factura,monto_factura,monto_sin_iva,monto_iva1,tasa_iva1,monto_iva1_so FROM PAG016 Where (nro_orden='$referencia')";$res=pg_query($sql); $tipo_r=0;
while($registro=pg_fetch_array($res))
{ $tipo_r=$tipo_r+1; $fecha_e=$fecha_ord; $nro_fact=$registro["nro_factura"]; $nro_d=elimina_ceros($nro_fact);  $nro_con_fac=$registro["nro_con_factura"]; if(is_numeric($nro_con_fac)){$nro_con_fac=elimina_ceros($nro_con_fac);}  $fecha_f=$registro["fecha_factura"];
  $monto_p=$registro["monto_factura"]; $monto1=$registro["monto_sin_iva"];  $tasa=$registro["tasa_iva1"];  $monto_o=$registro["monto_iva1_so"]; $monto1=$monto1-$monto_o;
  $iva_fact=$registro["monto_factura"]-$registro["monto_sin_iva"]; $monto_r=$iva_fact*($tasa_retencion/100);  $monto2=cambia_coma_numero($iva_fact); $monto3=$tasa_retencion; $monto_r=cambia_coma_numero($monto_r);  $monto1=cambia_coma_numero($monto1);
  $ssql="SELECT INCLUYE_BAN029('$codigo_mov','0000','O/P','$referencia','$tipo_r','01-REG','$ced_rif','$fecha_e','$referencia','$referencia','C','$tipo_r','01','$nro_d','$nro_con_fac','','$fecha_f','00000000','',$monto_p,$monto_o,$tasa,$monto_r,$monto1,$monto2,$monto3)";  $resultado=pg_exec($conn,$ssql); $error=pg_errormessage($conn);
}
pg_close();?><iframe src="Det_inc_comp_iva.php?codigo_mov=<?echo $codigo_mov?>&agregar=S" width="870" height="310" scrolling="auto" frameborder="1"></iframe>