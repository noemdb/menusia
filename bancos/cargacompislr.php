<?include ("../class/conect.php");  include ("../class/funciones.php"); $tipo_ret="01"; $prev_ced_rif=""; $prev_tipo=""; $i=0; $monto_o=0;  $monto_p=0;  $monto_r=0; $monto_fact=0; $iva_fact=0; 
$password=$_GET["password"];$user=$_GET["user"]; $dbname=$_GET["dbname"]; $agrupar=$_GET["agrupar"]; $agtipo=$_GET["agtipo"]; $codigo_mov=$_GET["codigo_mov"]; $mes=$_GET["mes"]; $ano=$_GET["ano"]; $desde=$_GET["desde"]; $hasta=$_GET["hasta"]; $tipo_comp=$_GET["tipo_comp"]; $desde=formato_aaaammdd($desde); $hasta=formato_aaaammdd($hasta);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $resultado=pg_exec($conn,"SELECT BORRAR_BAN029('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); 
$criterio_s="  (BAN012.fecha_emision>='$desde') And (BAN012.fecha_emision<='$hasta') ";
if($tipo_comp==="ORDEN CANCELADA") { $criterio_s="  BAN012.fecha_emision<='$hasta' and BAN012.tipo_mov='O/P' and BAN012.referencia in (select nro_orden  from pag001 where status='I' and fecha_cheque>='$desde' and fecha_cheque<='$hasta') ";}
if($tipo_comp==="CHEQUE ENTREGADO"){ $criterio_s="  BAN012.fecha_emision<='$hasta' and BAN012.tipo_mov='O/P' and ((BAN012.referencia='00000000' and BAN012.fecha_emision>='$desde' AND BAN012.fecha_emision<='$hasta') OR (BAN012.referencia in (select nro_orden  from pag001 where Status='I' and text(cod_banco)||text(nro_cheque) in (select text(cod_banco)||text(num_cheque) from ban006 where entregado='S' and fecha_entregado>='$desde' and fecha_entregado<='$hasta') )) )"; }
if($agrupar=="SI"){
$sql="SELECT BAN012.tipo_planilla,BAN012.nro_planilla,BAN012.Ced_Rif,BAN012.tipo_documento,BAN012.Nro_Documento,BAN012.Nro_Con_Factura,BAN012.Fecha_Factura,BAN012.Monto_Pago,BAN012.Monto_Objeto,BAN012.Tasa,BAN012.Monto_Retencion,BAN012.Nro_orden,PAG003.Cod_Fondo,PAG016.Nro_Orden,PAG016.Nro_Factura,PAG016.Nro_Con_Factura AS Nro_Control,PAG016.Fecha_Factura as F_Factura,PAG016.Monto_Sin_Iva,PAG016.Monto_Iva1_So,PAG016.Tasa_Iva1,PAG016.Monto_Iva1,PAG016.Monto_Factura,PAG016.Monto_Iva4_so From (BAN012 LEFT JOIN PAG003 ON (PAG003.Tipo_Retencion=BAN012.Tipo_Retencion)) LEFT JOIN PAG016 ON (BAN012.Nro_orden=PAG016.Nro_orden) WHERE (BAN012.Monto_Retencion>0) And (BAN012.Tipo_Planilla='$tipo_ret') And (BAN012.fecha_emision>='$desde') And (BAN012.fecha_emision<='$hasta') And (BAN012.anulada='N') ORDER BY  BAN012.Ced_Rif,BAN012.nro_planilla"; 
$sql="SELECT BAN012.tipo_planilla,BAN012.nro_planilla,BAN012.fecha_emision,BAN012.Ced_Rif,BAN012.tipo_documento,BAN012.Nro_Documento,BAN012.Nro_Con_Factura,BAN012.Fecha_Factura,BAN012.Monto_Pago,BAN012.Monto_Objeto,BAN012.Tasa,BAN012.Monto_Retencion,BAN012.Nro_orden,BAN012.monto1,BAN012.monto2,PAG003.Cod_Fondo From (BAN012 LEFT JOIN PAG003 ON (PAG003.Tipo_Retencion=BAN012.Tipo_Retencion))  WHERE (BAN012.Monto_Retencion>0) And (BAN012.Tipo_Planilla='$tipo_ret')  And (BAN012.anulada='N') and (BAN012.Ced_Rif<>'') and ".$criterio_s." ORDER BY  BAN012.Ced_Rif,PAG003.Cod_Fondo,BAN012.nro_planilla"; 
$res=pg_query($sql); $tipo_m=""; $nro_p=""; $nro_o=""; $ced_rif=""; $tipo_p=""; $tipo_d=""; $monto1=0; $monto2=0; $monto3=0; $tasa=0;$aux_o=""; $nro_fact="";$nro_con_fac="";
while($registro=pg_fetch_array($res)){ if($prev_ced_rif==""){$prev_ced_rif=$registro["ced_rif"];} if($prev_tipo==""){$prev_tipo=$registro["cod_fondo"];} $corte=0;
 if($prev_ced_rif!=$registro["ced_rif"]){ $corte=1; } else { if(($agtipo=="SI")and($prev_tipo!=$registro["cod_fondo"])){ $corte=1; } }
 //echo $prev_ced_rif." ".$registro["ced_rif"]." ".$corte,"<br>";  
if($corte==1){$i=$i+1; $tipo_m=$i;  $tipo_r=Rellenarcerosizq($i,3); 
  $ssql="SELECT INCLUYE_BAN029('$codigo_mov','0000','$tipo_m','$nro_p','$tipo_p','$nro_p','$ced_rif','$fecha_e','$nro_o','$aux_o','I','$tipo_r','$tipo_d','$nro_fact','$nro_con_fac','','$fecha_f','','',$monto_p,$monto_o,$tasa,$monto_r,$monto1,$monto2,$monto3)";
  $resul=pg_exec($conn,$ssql); $error=pg_errormessage($conn);
  $monto_o=0;  $monto_p=0;  $monto_r=0; $monto_fact=0; $iva_fact=0; $prev_ced_rif=$registro["ced_rif"];  $prev_tipo=$registro["cod_fondo"]; } 
   $nro_p=$registro["nro_planilla"];  $ced_rif=$registro["ced_rif"]; $fecha_e=$registro["fecha_emision"]; $nro_o=$registro["nro_orden"]; $aux_o=$registro["nro_orden"];
  $tipo_d=$registro["cod_fondo"]; $nro_d=$registro["nro_documento"]; $nro_cd=$registro["nro_con_factura"];  $tipo_p=$registro["tipo_planilla"];  $monto1=0; $monto2=0; $monto3=0;
  $nro_fact=$registro["nro_documento"]; $nro_con_fac=$registro["nro_con_factura"];  $fecha_f=$registro["fecha_factura"];
  $monto_fact=$monto_fact+($registro["monto1"]+$registro["monto2"]); $iva_fact=$iva_fact+$registro["monto2"]; $monto_o=$monto_o+$registro["monto_objeto"]; $monto_p=$monto_p+($registro["monto1"]+$registro["monto2"]);
   //$nro_fact=$registro["nro_factura"]; $nro_con_fac=$registro["nro_control"]; $fecha_f=$registro["fecha_factura"]; if(is_numeric($nro_con_fac)){$nro_fact=elimina_ceros($nro_fact);} if(is_numeric($nro_con_fac)){$nro_con_fac=elimina_ceros($nro_con_fac);}  
  //$monto_fact=$monto_fact+$registro["monto_factura"]; $iva_fact=$iva_fact+$registro["monto_iva1"];  $monto_o=$monto_o+$registro["monto_iva4_so"]; $monto_p=$monto_p+$registro["monto_factura"];  
  $caracter=' '; $nro_fact=trim($nro_fact); $posicion=strpos($nro_fact,$caracter);
  if ($posicion === false) {$l=0;} else {$l=$posicion; $nro_fact=substr($nro_fact,0,$l); }
  $tasa=$registro["tasa"]; $monto_r=$monto_r+$registro["monto_retencion"];   
   //echo $registro["ced_rif"]." ".$nro_p." ".$monto_p." ".$monto_o." ".$tasa." ".$monto_r,"<br>"; 
 } 
$i=$i+1; $tipo_m=$i;  $tipo_r=Rellenarcerosizq($i,3); 
if($ced_rif<>""){$ssql="SELECT INCLUYE_BAN029('$codigo_mov','0000','$tipo_m','$nro_p','$tipo_p','$nro_p','$ced_rif','$fecha_e','$nro_o','$aux_o','I','$tipo_r','$tipo_d','$nro_fact','$nro_con_fac','','$fecha_f','','',$monto_p,$monto_o,$tasa,$monto_r,$monto1,$monto2,$monto3)";  $resul=pg_exec($conn,$ssql); $error=pg_errormessage($conn);}
}
else{$sql="SELECT BAN012.tipo_planilla,BAN012.nro_planilla,BAN012.fecha_emision,BAN012.Ced_Rif,BAN012.tipo_documento,BAN012.Nro_Documento,BAN012.Nro_Con_Factura,BAN012.Fecha_Factura,BAN012.Monto_Pago,BAN012.Monto_Objeto,BAN012.Tasa,BAN012.Monto_Retencion,BAN012.Nro_orden,PAG003.Cod_Fondo,PAG003.sustraendo,PAG016.Nro_Orden,PAG016.Nro_Factura,PAG016.Nro_Con_Factura AS Nro_Control,PAG016.Fecha_Factura as F_Factura,PAG016.Monto_Sin_Iva,PAG016.Monto_Iva1_So,PAG016.Tasa_Iva1,PAG016.Monto_Iva1,PAG016.Monto_Factura,PAG016.Monto_Iva4_so From (BAN012 LEFT JOIN PAG003 ON (PAG003.Tipo_Retencion=BAN012.Tipo_Retencion)) LEFT JOIN PAG016 ON (BAN012.Nro_orden=PAG016.Nro_orden) WHERE (BAN012.Monto_Retencion>0) And (BAN012.Tipo_Planilla='$tipo_ret') And (BAN012.anulada='N') and (BAN012.Ced_Rif<>'') and ".$criterio_s." ORDER BY BAN012.Ced_Rif,BAN012.nro_planilla"; $res=pg_query($sql);
$prev_nro_planilla=""; //echo $sql;
while($registro=pg_fetch_array($res)){$i=$i+1; $tipo_m=$i; $tipo_r=Rellenarcerosizq($i,3); 
  $nro_p=$registro["nro_planilla"]; $ced_rif=$registro["ced_rif"]; $fecha_e=$registro["fecha_emision"]; $nro_o=$registro["nro_orden"]; $aux_o=$registro["nro_orden"];   
  $tipo_d=$registro["cod_fondo"]; $nro_d=$registro["nro_documento"]; $nro_cd=$registro["nro_con_factura"]; $monto_o=$registro["monto_objeto"]; $tasa=$registro["tasa"]; $monto_p=$registro["monto_pago"];   $tipo_p=$registro["tipo_planilla"];  $monto1=0; $monto2=0; $monto3=0;
  $nro_fact=$registro["nro_factura"]; $nro_con_fac=$registro["nro_control"]; $fecha_f=$registro["fecha_factura"]; $monto_fact=$registro["monto_factura"]; $iva_fact=$registro["monto_iva1"];  $monto_o=$registro["monto_iva4_so"]; $monto_p=$registro["monto_factura"];  
  $monto_r=$registro["monto_retencion"]; if($monto_o==0){ $monto_o=$registro["monto_objeto"];}
  $monto_r=$monto_o*($tasa/100); $monto_r=$monto_r-$registro["sustraendo"]; if($tasa==0){ $monto_r=$registro["monto_retencion"]; } 
  //if($prev_nro_planilla<>$nro_p){ $monto_r=$registro["monto_retencion"]; $prev_nro_planilla=$nro_p; } else {$monto_r=0; }
  if(is_numeric($nro_con_fac)){$nro_fact=elimina_ceros($nro_fact);} if(is_numeric($nro_con_fac)){$nro_con_fac=elimina_ceros($nro_con_fac);}   
  $ssql="SELECT INCLUYE_BAN029('$codigo_mov','0000','$tipo_m','$nro_p','$tipo_p','$nro_p','$ced_rif','$fecha_e','$nro_o','$aux_o','I','$tipo_r','$tipo_d','$nro_fact','$nro_con_fac','','$fecha_f','','',$monto_p,$monto_o,$tasa,$monto_r,$monto1,$monto2,$monto3)";
  $resul=pg_exec($conn,$ssql); $error=pg_errormessage($conn);
}}
pg_close();
?>
<iframe src="Det_dec_ret_islr.php?codigo_mov=<?echo $codigo_mov?>" width="940" height="350" scrolling="auto" frameborder="1"></iframe>
