<?include ("../class/conect.php");  include ("../class/funciones.php"); $tipo_ret="01"; $prev_ced_rif=""; $i=0; $monto_o=0;  $monto_p=0;  $monto_r=0; $monto_fact=0; $iva_fact=0; 
$password=$_GET["password"];$user=$_GET["user"]; $dbname=$_GET["dbname"]; $agrupar=$_GET["agrupar"]; $codigo_mov=$_GET["codigo_mov"]; $mes=$_GET["mes"]; $ano=$_GET["ano"]; $desde=$_GET["desde"]; $hasta=$_GET["hasta"]; $desde=formato_aaaammdd($desde); $hasta=formato_aaaammdd($hasta);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $resultado=pg_exec($conn,"SELECT BORRAR_BAN029('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); 
if($agrupar=="SI"){
$sql="SELECT BAN012.tipo_planilla,BAN012.Nro_Planilla,BAN012.Ced_Rif,BAN012.tipo_documento,BAN012.Nro_Documento,BAN012.Nro_Con_Factura,BAN012.Fecha_Factura,BAN012.Monto_Pago,BAN012.Monto_Objeto,BAN012.Tasa,BAN012.Monto_Retencion,BAN012.Nro_orden,PAG003.Cod_Fondo,PAG016.Nro_Orden,PAG016.Nro_Factura,PAG016.Nro_Con_Factura AS Nro_Control,PAG016.Fecha_Factura as F_Factura,PAG016.Monto_Sin_Iva,PAG016.Monto_Iva1_So,PAG016.Tasa_Iva1,PAG016.Monto_Iva1,PAG016.Monto_Factura,PAG016.Monto_Iva4_so From (BAN012 LEFT JOIN PAG003 ON (PAG003.Tipo_Retencion=BAN012.Tipo_Retencion)) LEFT JOIN PAG016 ON (BAN012.Nro_orden=PAG016.Nro_orden) WHERE (BAN012.Monto_Retencion>0) And (BAN012.Tipo_Planilla='$tipo_ret') And (BAN012.Fecha_Emision>='$desde') And (BAN012.Fecha_Emision<='$hasta') And (BAN012.anulada='N') ORDER BY  BAN012.Ced_Rif,BAN012.Nro_Planilla"; 
$sql="SELECT BAN012.tipo_planilla,BAN012.Nro_Planilla,BAN012.Ced_Rif,BAN012.tipo_documento,BAN012.Nro_Documento,BAN012.Nro_Con_Factura,BAN012.Fecha_Factura,BAN012.Monto_Pago,BAN012.Monto_Objeto,BAN012.Tasa,BAN012.Monto_Retencion,BAN012.Nro_orden,PAG003.Cod_Fondo,PAG016.Nro_Orden,PAG016.Nro_Factura,PAG016.Nro_Con_Factura AS Nro_Control,PAG016.Fecha_Factura as F_Factura,PAG016.Monto_Sin_Iva,PAG016.Monto_Iva1_So,PAG016.Tasa_Iva1,PAG016.Monto_Iva1,PAG016.Monto_Factura,PAG016.Monto_Iva4_so From (BAN012 LEFT JOIN PAG003 ON (PAG003.Tipo_Retencion=BAN012.Tipo_Retencion))  WHERE (BAN012.Monto_Retencion>0) And (BAN012.Tipo_Planilla='$tipo_ret') And (BAN012.Fecha_Emision>='$desde') And (BAN012.Fecha_Emision<='$hasta') And (BAN012.anulada='N') ORDER BY  BAN012.Ced_Rif,BAN012.Nro_Planilla"; 
$res=pg_query($sql); 
while($registro=pg_fetch_array($res)){ if($prev_ced_rif==""){$prev_ced_rif=$registro["ced_rif"];  }
 if($prev_ced_rif!=$registro["ced_rif"]){$i=$i+1; $tipo_m=$i;  $tipo_r=Rellenarcerosizq($i,3); 
  $ssql="SELECT INCLUYE_BAN029('$codigo_mov','0000','$tipo_m','$nro_p','$tipo_p','$nro_p','$ced_rif','$fecha_e','$nro_o','$aux_o','I','$tipo_r','$tipo_d','$nro_fact','$nro_con_fac','','$fecha_f','','',$monto_p,$monto_o,$tasa,$monto_r,$monto1,$monto2,$monto3)";
  $resul=pg_exec($conn,$ssql); $error=pg_errormessage($conn);
  $monto_o=0;  $monto_p=0;  $monto_r=0; $monto_fact=0; $iva_fact=0; $prev_ced_rif=$registro["ced_rif"]; } 
 $nro_p=$registro["nro_planilla"]; $ced_rif=$registro["ced_rif"]; $fecha_e=$registro["fecha_factura"]; $nro_o=$registro["nro_orden"]; $aux_o=$registro["nro_orden"];
 $tipo_d=$registro["cod_fondo"]; $nro_d=$registro["nro_documento"]; $nro_cd=$registro["nro_con_factura"];  $tipo_p=$registro["tipo_planilla"];  $monto1=0; $monto2=0; $monto3=0;
 $nro_fact=$registro["nro_factura"]; $nro_con_fac=$registro["nro_control"]; $fecha_f=$registro["fecha_factura"]; if(is_numeric($nro_con_fac)){$nro_fact=elimina_ceros($nro_fact);} if(is_numeric($nro_con_fac)){$nro_con_fac=elimina_ceros($nro_con_fac);}  
 $tasa=$registro["tasa"]; $monto_r=$monto_r+$registro["monto_retencion"]; 
 $monto_fact=$monto_fact+$registro["monto_factura"]; $iva_fact=$iva_fact+$registro["monto_iva1"];  $monto_o=$monto_o+$registro["monto_iva4_so"]; $monto_p=$monto_p+$registro["monto_factura"];  
} 
$i=$i+1; $tipo_m=$i;  $tipo_r=Rellenarcerosizq($i,3); $ssql="SELECT INCLUYE_BAN029('$codigo_mov','0000','$tipo_m','$nro_p','$tipo_p','$nro_p','$ced_rif','$fecha_e','$nro_o','$aux_o','I','$tipo_r','$tipo_d','$nro_fact','$nro_con_fac','','$fecha_f','','',$monto_p,$monto_o,$tasa,$monto_r,$monto1,$monto2,$monto3)";
  $resul=pg_exec($conn,$ssql); $error=pg_errormessage($conn); 
  }
else{$sql="SELECT BAN012.tipo_planilla,BAN012.Nro_Planilla,BAN012.Ced_Rif,BAN012.tipo_documento,BAN012.Nro_Documento,BAN012.Nro_Con_Factura,BAN012.Fecha_Factura,BAN012.Monto_Pago,BAN012.Monto_Objeto,BAN012.Tasa,BAN012.Monto_Retencion,BAN012.Nro_orden,PAG003.Cod_Fondo,PAG016.Nro_Orden,PAG016.Nro_Factura,PAG016.Nro_Con_Factura AS Nro_Control,PAG016.Fecha_Factura as F_Factura,PAG016.Monto_Sin_Iva,PAG016.Monto_Iva1_So,PAG016.Tasa_Iva1,PAG016.Monto_Iva1,PAG016.Monto_Factura,PAG016.Monto_Iva4_so From (BAN012 LEFT JOIN PAG003 ON (PAG003.Tipo_Retencion=BAN012.Tipo_Retencion)) LEFT JOIN PAG016 ON (BAN012.Nro_orden=PAG016.Nro_orden) WHERE (BAN012.Monto_Retencion>0) And (BAN012.Tipo_Planilla='$tipo_ret') And (BAN012.Fecha_Emision>='$desde') And (BAN012.Fecha_Emision<='$hasta') And (BAN012.anulada='N') ORDER BY BAN012.Nro_Planilla"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){$i=$i+1; $tipo_m=$i; $tipo_r=Rellenarcerosizq($i,3); 
  $nro_p=$registro["nro_planilla"]; $ced_rif=$registro["ced_rif"]; $fecha_e=$registro["fecha_factura"]; $nro_o=$registro["nro_orden"]; $aux_o=$registro["nro_orden"];   
  $tipo_d=$registro["cod_fondo"]; $nro_d=$registro["nro_documento"]; $nro_cd=$registro["nro_con_factura"]; $monto_o=$registro["monto_objeto"]; $tasa=$registro["tasa"]; $monto_p=$registro["monto_pago"];   $tipo_p=$registro["tipo_planilla"];  $monto1=0; $monto2=0; $monto3=0;
  $nro_fact=$registro["nro_factura"]; $nro_con_fac=$registro["nro_control"]; $fecha_f=$registro["fecha_factura"]; $monto_fact=$registro["monto_factura"]; $iva_fact=$registro["monto_iva1"];  $monto_o=$registro["monto_iva4_so"]; $monto_p=$registro["monto_factura"];  
  
  $monto_r=$registro["monto_retencion"]; $monto_r=$monto_o*($tasa/100); if($tasa==0){ $monto_r=$registro["monto_retencion"]; }
  
  if(is_numeric($nro_con_fac)){$nro_fact=elimina_ceros($nro_fact);} if(is_numeric($nro_con_fac)){$nro_con_fac=elimina_ceros($nro_con_fac);}   
  $ssql="SELECT INCLUYE_BAN029('$codigo_mov','0000','$tipo_m','$nro_p','$tipo_p','$nro_p','$ced_rif','$fecha_e','$nro_o','$aux_o','I','$tipo_r','$tipo_d','$nro_fact','$nro_con_fac','','$fecha_f','','',$monto_p,$monto_o,$tasa,$monto_r,$monto1,$monto2,$monto3)";
  $resul=pg_exec($conn,$ssql); $error=pg_errormessage($conn);
}}
pg_close();
?>
<iframe src="Det_dec_ret_islr.php?codigo_mov=<?echo $codigo_mov?>" width="940" height="350" scrolling="auto" frameborder="1"></iframe>
