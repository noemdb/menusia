<? include ("../class/conect.php"); //include ("../class/fun_numeros.php");
$codigo_mov=$_POST["txtcodigo_mov"]; $rif_emp=$_POST["txtced_rif_emp"]; $ano=$_POST["txtano"]; $mes=$_POST["txtmes"]; $tipo_formato=$_POST["txttipo_formato"];
function elimina_comas($str){$texto="";
  for ($i=0; $i<strlen($str); $i++) { if (substr($str,$i, 1)==",") {$texto=$texto; }  else {$texto=$texto.substr($str,$i, 1);}  }
return $texto;}
function elimina_guion($str){$texto="";
  for ($i=0; $i<strlen($str); $i++) { if (substr($str,$i, 1)=="-") {$texto=$texto; }  else {$texto=$texto.substr($str,$i, 1);}  }
return $texto;}
function cambia_punto_comas($monto){  $valor="";
  for ($i=0; $i<strlen($monto); $i++) { if (substr($monto,$i, 1)==".") {$valor=$valor.","; }  else { $valor=$valor.substr($monto,$i, 1);} }
  return $valor;}  
function elimina_ceros($str){$texto=$str; $l=0; $mcontinue=0;
while ($mcontinue==0){ if(substr($texto,0, 1)=="0"){$l=strlen($texto); $texto=substr($texto,1,$l-1);}else{$mcontinue=1;}  if(strlen($texto)<=0){$mcontinue=1;}  }
return $texto;}  
$rif_emp=elimina_guion($rif_emp);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$sql="SELECT * FROM BAN029 where codigo_mov='$codigo_mov' order by nro_comprobante"; $res=pg_query($sql);
if($tipo_formato=="EXCEL"){
	header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=decla_iva.xls");	
	?><table border="0" cellspacing='0' cellpadding='0' align="left"><?	
	while($registro=pg_fetch_array($res)){ $sfechaf=$registro["fecha_factura"]; $tipo_operacion=$registro["tipo_operacion"]; $tipo_doc=$registro["tipo_documento"]; $nro_doc=$registro["nro_documento"];  $nro_con_doc=$registro["nro_con_factura"]; $nro_doc_afectado=$registro["nro_doc_afectado"]; $nro_exp=$registro["tipo_en"]; $ced_rif=$registro["ced_rif"]; $ced_rif=elimina_guion($ced_rif);
	$montop=$registro["monto_pago"]; $montoo=$registro["monto_objeto"]; $montor=$registro["monto_retencion"];  $montoe=$registro["monto2"]; $tasa=$registro["tasa"];
	if(($tipo_operacion=="03")and($montor<0)){ $montop=$montop*-1; $montoo=$montoo*-1; $montor=$montor*-1;}
	if($nro_doc_afectado==""){$nro_doc_afectado="0";}$nro_comp=$ano.$mes.$registro["nro_comprobante"].' ';
	//$montop=cambia_punto_comas($montop); $montor=cambia_punto_comas($montor); $montoe=cambia_punto_comas($montoe); $montoo=cambia_punto_comas($montoo); $tasa=cambia_punto_comas($tasa);
	if(substr($nro_con_doc,0,1)=="-"){$nro_con_doc="00".$nro_con_doc;}
?><tr>
             <td width="120" align="left"><? echo $rif_emp; ?></td>
             <td width="100" align="left"><? echo $ano.$mes; ?></td>
             <td width="100" align="left" style="mso-number-format:'@';"><? echo $sfechaf; ?></td>
             <td width="50" align="left"><? echo $tipo_operacion; ?></td>
			 <td width="50" align="left" style="mso-number-format:'@';"><? echo $tipo_doc; ?></td>
			 <td width="120" align="left"><? echo $ced_rif; ?></td>
			 <td width="150" align="left" style="mso-number-format:'@';"><? echo $nro_doc; ?></td>
			 <td width="150" align="left" style="mso-number-format:'@';"><? echo $nro_con_doc; ?></td>
			 <td width="150" align="right" style="mso-number-format:'0.00';"><? echo $montop; ?></td>
			 <td width="150" align="right" style="mso-number-format:'0.00';"><? echo $montoo; ?></td>
			 <td width="150" align="right" style="mso-number-format:'0.00';"><? echo $montor; ?></td>
			 <td width="150" align="left" style="mso-number-format:'@';"><? echo $nro_doc_afectado; ?></td>
			 <td width="150" align="left" style="mso-number-format:'@';"><? echo $nro_comp; ?></td>
			 <td width="150" align="right" style="mso-number-format:'0.00';" ><? echo $montoe; ?></td>
			 <td width="050" align="right" style="mso-number-format:'0.00';"><? echo $tasa; ?></td>
			 <td width="150" align="left" style="mso-number-format:'@';"><? echo $nro_exp; ?></td>
 </tr> <?	
	}
	?></table><?
}
if($tipo_formato=="TXT"){
    //header('Content-type: application/txt');
    //header('Content-Disposition: attachment; filename="decla_iva.txt"'); 
	$tabla="<table>";
	while($registro=pg_fetch_array($res)){ $sfechaf=$registro["fecha_factura"]; $tipo_operacion=$registro["tipo_operacion"]; $tipo_doc=$registro["tipo_documento"]; $nro_doc=$registro["nro_documento"];  $nro_con_doc=$registro["nro_con_factura"]; $nro_doc_afectado=$registro["nro_doc_afectado"]; $nro_exp=$registro["tipo_en"]; $ced_rif=$registro["ced_rif"]; $ced_rif=elimina_guion($ced_rif);
	$montop=$registro["monto_pago"]; $montoo=$registro["monto_objeto"]; $montor=$registro["monto_retencion"];  $montoe=$registro["monto2"]; $tasa=$registro["tasa"];
	if(($tipo_operacion=="03")and($montor<0)){ $montop=$montop*-1; $montoo=$montoo*-1; $montor=$montor*-1;}
	if($nro_doc_afectado==""){$nro_doc_afectado="0";}$nro_comp=$ano.$mes.$registro["nro_comprobante"];
	//$montop=cambia_punto_comas($montop); $montor=cambia_punto_comas($montor); $montoe=cambia_punto_comas($montoe); $montoo=cambia_punto_comas($montoo); $tasa=cambia_punto_comas($tasa);
	if(substr($nro_con_doc,0,1)=="-"){$nro_con_doc="00".$nro_con_doc;}
	$nro_doc=elimina_ceros($nro_doc);
	$tabla.="<tr><td>".$rif_emp."</td><td>".$ano.$mes."</td><td>".$sfechaf."</td><td>".$tipo_operacion."</td><td>".$tipo_doc."</td><td>".$ced_rif."</td><td>".$nro_doc."</td><td>".$nro_con_doc."</td><td>".$montop."</td><td>".$montoo."</td><td>".$montor."</td><td>".$nro_doc_afectado."</td><td>".$nro_comp."</td><td>".$montoe."</td><td>".$tasa."</td><td>".$nro_exp."</td></tr>";
	}
	$tabla.="</table>";
	echo $tabla;
}
if($tipo_formato=="CSV"){
	header('Content-type: application/txt');
    header('Content-Disposition: attachment; filename="decla_iva.csv"'); 
    $salto="\n";
	while($registro=pg_fetch_array($res)){ $sfechaf=$registro["fecha_factura"]; $tipo_operacion=$registro["tipo_operacion"]; $tipo_doc=$registro["tipo_documento"]; $nro_doc=$registro["nro_documento"];  $nro_con_doc=$registro["nro_con_factura"]; $nro_doc_afectado=$registro["nro_doc_afectado"]; $nro_exp=$registro["tipo_en"]; $ced_rif=$registro["ced_rif"]; $ced_rif=elimina_guion($ced_rif);
	$montop=$registro["monto_pago"]; $montoo=$registro["monto_objeto"]; $montor=$registro["monto_retencion"];  $montoe=$registro["monto2"]; $tasa=$registro["tasa"];
	if(($tipo_operacion=="03")and($montor<0)){ $montop=$montop*-1; $montoo=$montoo*-1; $montor=$montor*-1;}
	if($nro_doc_afectado==""){$nro_doc_afectado="0";}$nro_comp=$ano.$mes.$registro["nro_comprobante"];
	$montop=cambia_punto_comas($montop); $montor=cambia_punto_comas($montor); $montoe=cambia_punto_comas($montoe); $montoo=cambia_punto_comas($montoo); $tasa=cambia_punto_comas($tasa);
	if(substr($nro_con_doc,0,1)=="-"){$nro_con_doc="00".$nro_con_doc;}
	  echo $rif_emp.";".$ano.$mes.";".$sfechaf.";".$tipo_operacion.";".$tipo_doc.";".$ced_rif.";".$nro_doc.";".$nro_con_doc.";".$montop.";".$montoo.";".$montor.";".$nro_doc_afectado.";".$nro_comp.";".$montoe.";".$tasa.";".$nro_exp.$salto;
	}
}
pg_close();

?>
