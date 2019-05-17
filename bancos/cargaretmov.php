<?include ("../class/conect.php");  include ("../class/funciones.php"); 
$password=$_GET["password"];$user=$_GET["user"]; $dbname=$_GET["dbname"]; $cod_banco=$_GET["cod_banco"]; $tipo_mov=$_GET["tipo_mov"]; $fecha_mov=$_GET["fecha_mov"]; $referencia=$_GET["referencia"]; $codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$resultado=pg_exec($conn,"SELECT BORRAR_BAN029('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 91);
$resultado=pg_exec($conn,"delete from ban029 where referencia='$referencia'"); $error=pg_errormessage($conn); $error=substr($error, 0, 91);
$fecha_mov=formato_aaaammdd($fecha_mov);
$sql="SELECT * FROM BAN012 where referencia='$referencia' and tipo_mov='$tipo_mov' and cod_banco='$cod_banco' order by tipo_retencion,nro_planilla"; $res=pg_query($sql); $filas=pg_num_rows($res);
//echo $sql." ".$filas,"<br>";
while($registro=pg_fetch_array($res)){ $tipo_p=$registro["tipo_planilla"]; $nro_p=$registro["nro_planilla"]; $ced_rif=$registro["ced_rif"]; $fecha_e=$registro["fecha_emision"]; $nro_o=$registro["nro_orden"]; $aux_o=$registro["aux_orden"]; $tipo_r=$registro["tipo_retencion"]; $tipo_d=$registro["tipo_documento"]; $nro_d=$registro["nro_documento"]; $nro_cd=$registro["nro_con_factura"];
  $fecha_f=$registro["fecha_factura"]; $nro_c=$registro["nro_comprobante"]; $tipo_e=$registro["tipo_en"]; $monto_p=$registro["monto_pago"]; $monto_o=$registro["monto_objeto"]; $tasa=$registro["tasa"]; $monto_r=$registro["monto_retencion"]; $monto1=$registro["monto1"]; $monto2=$registro["monto2"]; $monto3=$registro["monto3"];
  $ssql="SELECT INCLUYE_BAN029('$codigo_mov','$cod_banco','$tipo_mov','$referencia','$tipo_p','$nro_p','$ced_rif','$fecha_e','$nro_o','$aux_o','A','$tipo_r','$tipo_d','$nro_d','$nro_cd','','$fecha_f','$nro_c','$tipo_e',$monto_p,$monto_o,$tasa,$monto_r,$monto1,$monto2,$monto3)";
  $resultado=pg_exec($conn,$ssql); $error=pg_errormessage($conn);  $error=substr($error, 0, 91);
}
$sql="SELECT * FROM BAN012 where referencia in (SELECT nro_orden FROM PAG001 Where (cod_banco='$cod_banco') and (nro_cheque='$referencia') and (tipo_pago='$tipo_mov')) and tipo_mov='O/P' and cod_banco='0000' order by tipo_retencion,nro_planilla"; $res=pg_query($sql); $filas=pg_num_rows($res);
//echo $sql." ".$filas,"<br>";
while($registro=pg_fetch_array($res)){ $tipo_p=$registro["tipo_planilla"]; $nro_p=$registro["nro_planilla"]; $ced_rif=$registro["ced_rif"]; $fecha_e=$registro["fecha_emision"]; $nro_o=$registro["nro_orden"]; $aux_o=$registro["aux_orden"]; $tipo_r=$registro["tipo_retencion"]; $tipo_d=$registro["tipo_documento"]; $nro_d=$registro["nro_documento"]; $nro_cd=$registro["nro_con_factura"];
  $fecha_f=$registro["fecha_factura"]; $nro_c=$registro["nro_comprobante"]; $tipo_e=$registro["tipo_en"]; $monto_p=$registro["monto_pago"]; $monto_o=$registro["monto_objeto"]; $tasa=$registro["tasa"]; $monto_r=$registro["monto_retencion"]; $monto1=$registro["monto1"]; $monto2=$registro["monto2"]; $monto3=$registro["monto3"];
  $ssql="SELECT INCLUYE_BAN029('$codigo_mov','$cod_banco','$tipo_mov','$referencia','$tipo_p','$nro_p','$ced_rif','$fecha_e','$nro_o','$aux_o','A','$tipo_r','$tipo_d','$nro_d','$nro_cd','','$fecha_f','$nro_c','$tipo_e',$monto_p,$monto_o,$tasa,$monto_r,$monto1,$monto2,$monto3)";
  $resultado=pg_exec($conn,$ssql); $error=pg_errormessage($conn);  $error=substr($error, 0, 91);
} 
$sql="SELECT nro_orden,ced_rif,fecha,total_causado,total_retencion,total_ajuste,total_pagado,tipo_documento,nro_documento FROM PAG001 Where (cod_banco='$cod_banco') and (nro_cheque='$referencia') and (tipo_pago='$tipo_mov')"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado); 
//echo $sql." ".$filas,"<br>";
while($reg=pg_fetch_array($resultado)){ $nro_orden=$reg["nro_orden"]; $ced_rif=$reg["ced_rif"]; $fecha_ord=$reg["fecha"]; $tipo_d=$reg["tipo_documento"]; $nro_fact=$reg["nro_documento"]; $neto_ord=$reg["total_causado"]-$reg["total_retencion"]-$reg["total_ajuste"];  $neto_ord=cambia_coma_numero($neto_ord);
  $sql="SELECT nro_factura,nro_con_factura,fecha_factura,monto_factura,monto_iva1 FROM PAG016 Where (nro_orden='$nro_orden')" ; $res=pg_exec($conn,$sql);  $filas=pg_numrows($res);
  if($filas>0){$registro=pg_fetch_array($res); $nro_fact=$registro["nro_factura"]; $nro_con_fac=$registro["nro_con_factura"]; $fecha_f=$registro["fecha_factura"]; $monto_fact=$registro["monto_factura"]; $iva_fact=$registro["monto_iva1"]; $tipo_d="FACTURA";}else{$nro_con_fac="";$fecha_f=$fecha_ord;$monto_fact=0;$iva_fact=0;}
  $sql="SELECT pag004.nro_orden_ret,pag004.tipo_retencion,pag004.aux_orden,pag004.tasa_retencion,sum(pag004.monto_objeto_ret) as monto_objeto,sum(pag004.monto_retencion) as monto_retencion From pag004,pag003 Where (pag003.ret_Grupo<>'A') and (pag003.tipo_retencion=pag004.tipo_retencion) and (nro_orden_ret='$nro_orden') And (text(pag004.nro_orden_ret)||text(pag004.tipo_retencion) not in (select text(nro_orden)||text(tipo_retencion) from ban029 where codigo_mov='$codigo_mov'))  group by pag004.nro_orden_ret,pag004.tipo_retencion,pag004.aux_orden,pag004.tasa_retencion order by pag004.nro_orden_ret,pag004.tipo_retencion";
  $res=pg_query($sql); $filas=pg_numrows($res); $nro_d=elimina_ceros($nro_fact); $nro_con_fac=elimina_ceros($nro_con_fac);
  //echo $sql." ".$filas,"<br>";
  while($registro=pg_fetch_array($res)){ $tipo_p="00"; $nro_p="00000000"; $fecha_e=$fecha_ord; $nro_o=$registro["nro_orden_ret"]; $aux_o=$registro["aux_orden"]; $tipo_r=$registro["tipo_retencion"];
    $nro_c="00000000"; $tipo_e=""; $monto_p=$neto_ord; $monto_o=$registro["monto_objeto"]; $tasa=$registro["tasa_retencion"]; $monto_r=$registro["monto_retencion"]; $monto1=$monto_fact; $monto2=$iva_fact; $monto3=0;
    $ssql="SELECT INCLUYE_BAN029('$codigo_mov','$cod_banco','$tipo_mov','$referencia','$tipo_p','$nro_p','$ced_rif','$fecha_mov','$nro_o','$aux_o','A','$tipo_r','$tipo_d','$nro_d','$nro_con_fac','','$fecha_f','$nro_c','$tipo_e',$monto_p,$monto_o,$tasa,$monto_r,$monto1,$monto2,$monto3)";
    $resul=pg_exec($conn,$ssql); $error=pg_errormessage($conn);  $error=substr($error, 0, 91);
  }
}
?><iframe src="Det_ret_planillas.php?codigo_mov=<?echo $codigo_mov?>"  width="940" height="350" scrolling="auto" frameborder="1"> </iframe>
<?pg_close();?>