<? include ("../class/conect.php"); //include ("../class/fun_numeros.php");
$codigo_mov=$_POST["txtcodigo_mov"];  $ano=$_POST["txtano"]; $mes=$_POST["txtmes"]; $tipo_formato=$_POST["txttipo_formato"]; 
function elimina_comas($str){$texto=""; for ($i=0; $i<strlen($str); $i++) { if (substr($str,$i, 1)==",") {$texto=$texto; }  else {$texto=$texto.substr($str,$i, 1);}  } return $texto;}
function elimina_guion($str){$texto=""; for ($i=0; $i<strlen($str); $i++) { if (substr($str,$i, 1)=="-") {$texto=$texto; }  else {$texto=$texto.substr($str,$i, 1);}  } return $texto;}
function cambia_punto_comas($monto){ $valor="";  for ($i=0; $i<strlen($monto); $i++) { if (substr($monto,$i, 1)==".") {$valor=$valor.","; }  else { $valor=$valor.substr($monto,$i, 1);} }  return $valor;}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $m=0;
$sql="SELECT ban029.tipo_mov,ban029.fecha_emision,ban029.ced_rif,ban029.fecha_factura,tipo_operacion,tipo_documento,nro_documento,nro_con_factura,monto_objeto,monto_retencion,tasa,pre099.nombre FROM BAN029,pre099 where ban029.ced_rif=pre099.ced_rif and  ban029.codigo_mov='$codigo_mov' order by tipo_retencion"; $res=pg_query($sql);
if($tipo_formato=="EXCEL"){
	header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=decla_islr.xls");	
	?><table border="0" cellspacing='0' cellpadding='0' align="left"><?	}else{	$tabla="<table>";}
while($registro=pg_fetch_array($res)){ $m=$m+1; $tipo_mov=$registro["tipo_mov"]; $ced_rif=$registro["ced_rif"]; $ced_rif=elimina_guion($ced_rif);
$sfechaf=$registro["fecha_factura"]; $fechae=$registro["fecha_emision"]; $tipo_operacion=$registro["tipo_operacion"]; $tipo_doc=$registro["tipo_documento"]; $nro_doc=$registro["nro_documento"];  $nro_con_doc=$registro["nro_con_factura"]; $nombre=$registro["nombre"]; 
$montoo=$registro["monto_objeto"]; $montor=$registro["monto_retencion"];  $tasa=$registro["tasa"]; $montoo=cambia_punto_comas($montoo); $tasa=cambia_punto_comas($tasa);
$fechae=substr($fechae,8,2)."-".substr($fechae,5,2)."-".substr($fechae,0,4);
if($tipo_formato=="EXCEL"){ 
?><tr>
             <td width="30" align="left"><? echo $m; ?></td>
             <td width="120" align="left"><? echo $ced_rif; ?></td>
             <td width="150" align="left"><? echo $nro_doc; ?></td>
             <td width="150" align="left"><? echo $nro_con_doc; ?></td>
			 <td width="120" align="left"><? echo $fechae; ?></td>
             <td width="50" align="left"><? echo $tipo_doc; ?></td>
			 <td width="120" align="right" style="mso-number-format:'0.00';"><? echo $montoo; ?></td>
			 <td width="120" align="right" style="mso-number-format:'0.00';"><? echo $tasa; ?></td>
 </tr> <?
}
else{ $montoo=cambia_punto_comas($montoo); $tasa=cambia_punto_comas($tasa);
$tabla.="<tr><td>".$ced_rif."</td><td>".$nro_doc."</td><td>".$nro_con_doc."</td><td>".$fechae."</td><td>".$tipo_doc."</td><td>".$montoo."</td><td>".$tasa."</td><td>".$nombre."</td></tr>"; 
} }
pg_close();
if($tipo_formato=="EXCEL"){?></table><?}else{$tabla.="</table>";echo $tabla;}
?>
