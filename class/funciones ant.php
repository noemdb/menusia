<?include ("conect.php"); include ("ventana.php");
function Rellenarcerosizq($str,$n){$numeroarellenar=$n-strlen($str); $texto="";
 for ($i=0; $i < $numeroarellenar; $i++){$texto=$texto."0";}
 $texto=$texto.$str; return $texto;}
function Rellenarcerosder($str,$n){ $numeroarellenar=$n-strlen($str); $texto="";
 for ($i=0; $i < $numeroarellenar; $i++){$texto=$texto."0";}
 $texto=$str.$texto; return $texto;}
function inserta_espacio($n){ $texto=""; $car="";
 for ($i=0; $i < $n; $i++){$texto=$texto." ";}  return $texto;}
function formato_monto($monto){ $valor=ltrim(sprintf("%10.2f",$monto));
   $miles=",";   $len=strlen($valor);    $NMonto=substr($valor,-2,2);for ($i=6; $i < $len; $i += 3){  $NMonto=substr($valor,-$i,3).$miles.$NMonto;  $miles="."; }
   $NMonto=substr($valor,-$len,($len-($i-3))).$miles.$NMonto;  if(substr($NMonto,0,2)=='-.'){$len=strlen($NMonto); $NMonto='-'.substr($NMonto,2,$len-2);}
   return $NMonto;}
function formato_numero($monto){$valor="";
  for ($i=0; $i<strlen($monto); $i++) { if (substr($monto,$i, 1)==",") {$valor=$valor."."; }
   else {if (substr($monto,$i, 1)==".") {$valor=$valor.""; } else {$valor=$valor.substr($monto,$i, 1);}  }  }
  return $valor;}
function elimina_ceros($str){$texto=$str; $l=0; $mcontinue=0;
while ($mcontinue==0){ if (substr($texto,0, 1)=="0") {$l=strlen($texto); $texto=substr($texto,1,$l-1); } else{$mcontinue=1;} }
return $texto;}
function elimina_esp_izq($str){$texto=$str; $l=0; $mcontinue=0;if(strlen($str)==0){$texto="";}
else{ while ($mcontinue==0){ if (substr($texto,0, 1)==" "){$l=strlen($texto); $texto=substr($texto,1,$l-1);} else{$mcontinue=1;}}}
return $texto;}
function elimina_esp_der($str){$texto=$str; $l=0; $mcontinue=0;if(strlen($str)==0){$texto="";}
else{ while ($mcontinue==0){ $l=strlen($texto); if (substr($texto,$l-1, 1)==" "){ $texto=substr($texto,0,$l-1);} else{$mcontinue=1;}}}
return $texto;}
function elimina_cero_izq($str){$texto=$str; $l=0; $mcontinue=0;if(strlen($str)==0){$texto="";}
else{ while ($mcontinue==0){ if (substr($texto,0, 1)=="0"){$l=strlen($texto); $texto=substr($texto,1,$l-1);} else{$mcontinue=1;}}}
return $texto;}
function elimina_cero_der($str){$texto=$str; $l=0; $mcontinue=0;if(strlen($str)==0){$texto="";}
else{ while ($mcontinue==0){ $l=strlen($texto); if (substr($texto,$l-1, 1)=="0"){ $texto=substr($texto,0,$l-1);} else{$mcontinue=1;}}}
return $texto;}
function cambia_coma_numero($monto){$valor="";
  for ($i=0; $i<strlen($monto); $i++) {  if (substr($monto,$i,1)==",") {$valor=$valor.".";} else {$valor=$valor.substr($monto,$i,1);}  }
  return $valor;}
function cambia_punto_comas($monto){  $valor="";
  for ($i=0; $i<strlen($monto); $i++) { if (substr($monto,$i, 1)==".") {$valor=$valor.","; }  else { $valor=$valor.substr($monto,$i, 1);} }
  return $valor;}
function elimina_guion($str){$texto="";
  for ($i=0; $i<strlen($str); $i++) { if (substr($str,$i, 1)=="-") {$texto=$texto; }  else {$texto=$texto.substr($str,$i, 1);}  }
return $texto;}
function elimina_comas($str){$texto="";
  for ($i=0; $i<strlen($str); $i++) { if (substr($str,$i, 1)==",") {$texto=$texto; }  else {$texto=$texto.substr($str,$i, 1);}  }
return $texto;}
function elimina_puntos($str){  $texto="";
  for ($i=0; $i<strlen($str); $i++) { if (substr($str,$i, 1)==".") {$texto=$texto; }  else {$texto=$texto.substr($str,$i, 1);}  }
return $texto;}
function elimina_estapacios($str){  $texto="";
  for ($i=0; $i<strlen($str); $i++) { if (substr($str,$i, 1)==" ") {$texto=$texto; }  else {$texto=$texto.substr($str,$i, 1);}  }
return $texto;}
function eliminarblancos($cadena){ $cadena=trim($cadena);
  $cadena=preg_replace('/\s(?=\s)/', '', $cadena); $cadena=preg_replace('/[\n\r\t]/', ' ', $cadena);
return $cadena;}
function parte_entera($monto){ $valor=0; $l=0;
  for ($i=0; $i<strlen($monto); $i++){ if(substr($monto,$i,1)==".") {$l=$i; } }
  $valor=substr($monto,0,$l);
return $valor;} 
Function NRD($monto){$st=$monto; $pos=strpos($st,"."); $st=substr($st,0,$pos+3); $l=strlen($st);
  $EMonto=substr($st,0,$l-3)*1;  $DMonto=substr($st,($l-2),2)*1;  $DMonto=$DMonto/100;
  $valor=$EMonto+$DMonto; return $valor;}
Function RD($monto){ $valor=NRD($monto);  $st=$valor; $l=strlen($st);
  $d=substr($st,$l-1,1); $d=$d/100; $valor=$valor-$d;   $d=$d*100;
  if($d<=2){$d=0;}else{ if($d<=7){$d=0.05;}else{$d=0.10;} }
  $valor=$valor+$d;return $valor;}
Function RDB($monto){$valor=NRD($monto);  $st=$valor; $l=strlen($st);
  $d=substr($st,$l-1,1); $d=$d/100; $valor=$valor-$d;   $d=$d*10;
  if($d<5){$d=0;}else{$d=1;}$valor=$valor+$d; return $valor;}
?>
<?include ("fun_fechas.php");
//error_reporting(0);
error_reporting(E_ALL ^ E_WARNING);
?>