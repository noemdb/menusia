<? include ("../class/conect.php");  include ("../class/fun_fechas.php"); //include ("../class/fun_numeros.php");
$codigo_mov=$_POST["txtcodigo_mov"]; $planilla=$_POST["txtplanilla"];  $ano=$_POST["txtano"]; $mes=$_POST["txtmes"]; $tipo_formato=$_POST["txttipo_formato"];
function elimina_comas($str){$texto=""; for ($i=0; $i<strlen($str); $i++) { if (substr($str,$i, 1)==",") {$texto=$texto; }  else {$texto=$texto.substr($str,$i, 1);}  } return $texto;}
function elimina_guion($str){$texto=""; for ($i=0; $i<strlen($str); $i++) { if (substr($str,$i, 1)=="-") {$texto=$texto; }  else {$texto=$texto.substr($str,$i, 1);}  } return $texto;}
function cambia_punto_comas($monto){ $valor=""; for ($i=0; $i<strlen($monto); $i++) { if (substr($monto,$i, 1)==".") {$valor=$valor.","; }  else { $valor=$valor.substr($monto,$i, 1);} } return $valor;}    
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$sql="SELECT  ban029.fecha_emision,ban029.nro_orden,ban029.tipo_mov,ban029.ced_rif,ban029.fecha_factura,ban029.tipo_operacion,ban029.tipo_documento,ban029.nro_documento,ban029.nro_con_factura,ban029.monto_pago,ban029.monto_objeto,ban029.monto_retencion,ban029.tasa,ban029.monto1,pre099.nombre,pag001.concepto from ban029 left join pag001 on (ban029.nro_orden=pag001.nro_orden), pre099 where ban029.ced_rif=pre099.ced_rif and  ban029.codigo_mov='$codigo_mov' order by ban029.tipo_retencion"; $res=pg_query($sql);
//if($tipo_formato=="EXCEL"){
if(($tipo_formato=="EXCEL")and($planilla<>"06")){
	header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=decla_otros.xls");	
	?><table border="0" cellspacing='0' cellpadding='0' align="left"><?	
	while($registro=pg_fetch_array($res)){ $tipo_mov=$registro["tipo_mov"]; $ced_rif=$registro["ced_rif"]; $ced_rif=elimina_guion($ced_rif);
	  $sfechae=$registro["fecha_emision"]; $sfechae=formato_ddmmaaaa($sfechae); $nro_orden=$registro["nro_orden"]; $concepto=$registro["concepto"];
	  $tipo_operacion=$registro["tipo_operacion"]; $tipo_doc=$registro["tipo_documento"]; $nro_doc=$registro["nro_documento"];  $nro_con_doc=$registro["nro_con_factura"]; $nombre=$registro["nombre"]; 
	  $montoo=$registro["monto_objeto"]; $montop=$registro["monto_pago"]; $monto1=$registro["monto1"]; $montor=$registro["monto_retencion"];  $tasa=$registro["tasa"]; $montoo=cambia_punto_comas($montoo); $tasa=cambia_punto_comas($tasa); 
	  $montop=cambia_punto_comas($montop); $montor=cambia_punto_comas($montor); $monto1=cambia_punto_comas($monto1); $tp_pago="UNICO"; $mmunic="IRIBARREN";
	/* esto es de yaracuy
	?><tr>

             <td width="300" align="left"><? echo $nombre; ?></td> 
             <td width="120" align="left"><? echo $ced_rif; ?></td>
			 <td width="100" align="left" style="mso-number-format:'@';"><? echo $nro_orden; ?></td>
			 <td width="150" align="right" style="mso-number-format:'0.00';"><? echo $montoo; ?></td>
			 <td width="150" align="right" style="mso-number-format:'0.00';"><? echo $montor; ?></td>
			 <td width="500" align="left" style="mso-number-format:'@';"><? echo $concepto; ?></td>
    </tr> <?	
	*/
	?><tr>
             <td width="100" align="center"><? echo $tipo_mov; ?></td> 
			 <td width="100" align="center"><? echo $sfechae; ?></td>   
             <td width="100" align="center" style="mso-number-format:'@';"><? echo $nro_orden; ?></td>			 
             <td width="300" align="left"><? echo $nombre; ?></td> 
             <td width="120" align="left"><? echo $ced_rif; ?></td>
			 <td width="150" align="right" style="mso-number-format:'0.00';"><? echo $monto1; ?></td>
			 <td width="150" align="right" style="mso-number-format:'0.00';"><? echo $montoo; ?></td>			 
			 <td width="150" align="right" style="mso-number-format:'0.00';"><? echo $montor; ?></td>
			 <td width="100" align="center"><? echo $tp_pago; ?></td> 
			 <td width="100" align="center"><? echo $mmunic; ?></td>   
    </tr> <?  }
	?></table><?
}
if(($tipo_formato=="EXCEL")and($planilla=="06")){
	header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=decla_otros.xls");	
	?><table border="0" cellspacing='0' cellpadding='0' align="left"><?	
	while($registro=pg_fetch_array($res)){ $tipo_mov=$registro["tipo_mov"]; $ced_rif=$registro["ced_rif"]; $ced_rif=elimina_guion($ced_rif);
	  $sfechae=$registro["fecha_emision"]; $sfechae=formato_ddmmaaaa($sfechae); $nro_orden=$registro["nro_orden"]; $concepto=$registro["concepto"];
	  $tipo_operacion=$registro["tipo_operacion"]; $tipo_doc=$registro["tipo_documento"]; $nro_doc=$registro["nro_documento"];  $nro_con_doc=$registro["nro_con_factura"]; $nombre=$registro["nombre"]; 
	  $montoo=$registro["monto_objeto"]; $montop=$registro["monto_pago"]; $monto1=$registro["monto1"]; $montor=$registro["monto_retencion"];  $tasa=$registro["tasa"]; $montoo=cambia_punto_comas($montoo);
	  $montop=cambia_punto_comas($montop); $montor=cambia_punto_comas($montor); $monto1=cambia_punto_comas($monto1); $tp_pago="UNICO"; $mmunic="IRIBARREN"; $tasa2=$tasa*100;  $tasa=cambia_punto_comas($tasa); 
    /* esto es de yaracuy
	?><tr>
             <td width="300" align="left"><? echo $nombre; ?></td> 
             <td width="120" align="left"><? echo $ced_rif; ?></td>
			 <td width="100" align="left" style="mso-number-format:'@';"><? echo $nro_orden; ?></td>
			 <td width="150" align="right" style="mso-number-format:'0.00';"><? echo $montoo; ?></td>
			 <td width="150" align="right" style="mso-number-format:'0.00';"><? echo $montor; ?></td>
			 <td width="500" align="left" style="mso-number-format:'@';"><? echo $concepto; ?></td>
    </tr> <?	
	*/
	?><tr>
             
			 <td width="100" align="center"><? echo $sfechae; ?></td>   
			 <td width="100" align="center"><? echo $nro_doc; ?></td> 
             <td width="300" align="left"><? echo $nombre; ?></td> 
			 <td width="150" align="right" style="mso-number-format:'0.00';"><? echo $tasa; ?></td>
			 <td width="150" align="right" style="mso-number-format:'0.00';"><? echo $montoo; ?></td>			 
			 <td width="150" align="right" style="mso-number-format:'0.00';"><? echo $montor; ?></td>
    </tr> <? }
	?></table><?
}
if($tipo_formato=="TXT"){
  $tabla="<table>";
  while($registro=pg_fetch_array($res)){ $tipo_mov=$registro["tipo_mov"]; $ced_rif=$registro["ced_rif"]; $ced_rif=elimina_guion($ced_rif);
	$sfechae=$registro["fecha_emision"]; $sfechae=formato_ddmmaaaa($sfechae); $nro_orden=$registro["nro_orden"];
	$tipo_operacion=$registro["tipo_operacion"]; $tipo_doc=$registro["tipo_documento"]; $nro_doc=$registro["nro_documento"];  $nro_con_doc=$registro["nro_con_factura"]; $nombre=$registro["nombre"]; 
	$montoo=$registro["monto_objeto"]; $montop=$registro["monto_pago"];  $montor=$registro["monto_retencion"];  $tasa=$registro["tasa"]; $montoo=cambia_punto_comas($montoo); $tasa=cambia_punto_comas($tasa); $montop=cambia_punto_comas($montop); $montor=cambia_punto_comas($montor);
	$tabla.="<tr><td>".$tipo_mov."</td><td>".$sfechae."</td><td>".$nro_orden."</td><td>".$nombre."</td><td>".$ced_rif."</td><td>".$montop."</td><td>".$montoo."</td><td>".$montor."</td></tr>";
  }
  $tabla.="</table>";
  //$nom_arch="decla_iva_".$ano.$mes.".xls";
  //header("Content-type: application/vnd.ms-excel");
  //header("Content-Disposition: attachment; filename=".$nom_arch);
  echo $tabla;
}
pg_close();
?>
