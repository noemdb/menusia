<?php

function Rellenarcerosizq($str,$n){$numeroarellenar=$n-strlen($str); $texto="";
 for ($i=0; $i < $numeroarellenar; $i++){$texto=$texto."0";}
 $texto=$texto.$str; return $texto;}
function Rellenarcerosder($str,$n){ $numeroarellenar=$n-strlen($str); $texto="";
 for ($i=0; $i < $numeroarellenar; $i++){$texto=$texto."0";}
 $texto=$str.$texto; return $texto;}
function inserta_espacio($n){ $texto=""; $car="";
 for ($i=0; $i < $n; $i++){$texto=$texto." ";}  return $texto;}
 
function elimina_ceros($str){$texto=$str; $l=0; $mcontinue=0;
while ($mcontinue==0){ if(substr($texto,0, 1)=="0"){$l=strlen($texto); $texto=substr($texto,1,$l-1);}else{$mcontinue=1;}  if(strlen($texto)<=0){$mcontinue=1;}  }
return $texto;}
function elimina_esp_izq($str){$texto=$str; $l=0; $mcontinue=0;if(strlen($str)==0){$texto="";}
else{ while ($mcontinue==0){ if (substr($texto,0, 1)==" "){$l=strlen($texto); $texto=substr($texto,1,$l-1);} else{$mcontinue=1;}}}
return $texto;}
function contar_espacios($str){$texto=$str; $e=0; for($i=0;$i<strlen($str);$i++) { if(substr($str,$i,1)==" ") {$e=$e+1;} } return $e;}
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
function formato_monto($monto){
   $valor = ltrim(sprintf("%10.2f",$monto));
   $miles = ",";   $len = strlen($valor);   $NMonto = substr($valor,-2,2);
   for ($i=6; $i < $len; $i += 3){ $NMonto = substr($valor,-$i,3) . $miles . $NMonto; $miles = "."; }
   $NMonto = substr($valor,-$len,($len - ($i-3))) . $miles . $NMonto;
   if(substr($NMonto,0,2)=='-.'){$len = strlen($NMonto); $NMonto = '-'.substr($NMonto,2,$len-2);}
return $NMonto;}

function formato_monto_dec($monto){
   $valor = ltrim(sprintf("%10.3f",$monto));
   $miles = ","; $len = strlen($valor);   $NMonto = substr($valor,-3,3);
   for ($i=6; $i < $len; $i += 3){ $NMonto = substr($valor,-$i,3) . $miles . $NMonto; $miles = "."; }
   $NMonto = substr($valor,-$len,($len - ($i-2))) . $miles . $NMonto;
   if(substr($NMonto,0,3)=='-.'){$len = strlen($NMonto); $NMonto = '-'.substr($NMonto,3,$len-3);}
return $NMonto;}   


function formato_monto_decAA($monto){
   $valor = ltrim(sprintf("%12.3f",$monto));
  

   $miles = ","; $len = strlen($valor);   $NMonto = substr($valor,-3,3);
   for ($i=7; $i < $len; $i += 3){ $NMonto = substr($valor,-$i,3) . $miles . $NMonto; $miles = "."; }
   $NMonto = substr($valor,-$len,($len - ($i-3))) . $miles . $NMonto;
   if(substr($NMonto,0,3)=='-.'){$len = strlen($NMonto); $NMonto = '-'.substr($NMonto,3,$len-3);}
   
   
return $NMonto;}   
function formato_numero($monto){
  $valor="";
  for ($i=0; $i<strlen($monto); $i++) {  if (substr($monto,$i, 1) == ",") {$valor=$valor."."; }
   else {  if (substr($monto,$i, 1) == ".") {$valor=$valor.""; } else {$valor=$valor.substr($monto,$i, 1);} } }
return $valor;}

function formato_num_peq($monto){
  $valor="";
  for ($i=0; $i<strlen($monto); $i++) {  if (substr($monto,$i, 1) == ".") {$valor=$valor.","; } }
return $valor;}

function formato_num_cal($monto){
  $valor="";
  for ($i=0; $i<strlen($monto); $i++) {  if (substr($monto,$i, 1) == ",") {$valor=$valor."."; } }
return $valor;}

function parte_entera($monto){ $valor=0; $l=0;
  for ($i=0; $i<strlen($monto); $i++){ if(substr($monto,$i,1)==".") {$l=$i; } }
  $valor=substr($monto,0,$l);
return $valor;}


function parte_entera_num($monto){ $valor=""; $monto=formato_monto($monto); $l=strlen($monto);
  for ($i=0; $i<$l; $i++) {  if (substr($monto,$i, 1) == ",") {$i=$l; } else{$valor=$valor.substr($monto,$i, 1);} }
return $valor;}

Function NRD($monto){
  $st=$monto; $pos=strpos($st,"."); $st=substr($st,0,$pos+3); $l=strlen($st);
  $EMonto = substr($st,0,$l-3)*1;
  $DMonto = substr($st,($l-2),2)*1;
  $DMonto = $DMonto/100;
  $valor = $EMonto+$DMonto;
return $valor;}
Function RD($monto){
  $valor=NRD($monto);  $st=$valor; $l=strlen($st);
  $d=substr($st,$l-1,1); $d=$d/100;
  $valor=$valor-$d;   $d=$d*100;
  if($d<=2){$d=0;}else{ if($d<=7){$d=0.05;}else{$d=0.10;} }
  $valor=$valor+$d;
return $valor;}
Function RDB($monto){
  $valor=NRD($monto);  $st=$valor; $l=strlen($st);
  $d=substr($st,$l-1,1); $d=$d/100;
  $valor=$valor-$d;   $d=$d*10;
  if($d<5){$d=0;}else{$d=1;}
  $valor=$valor+$d;
return $valor;}

function Conv_Num($str_valor){$cnum=0;
   If (is_numeric($str_valor)){ $cnum=$str_valor*1;}else{$cnum=0;}
return $cnum;}

function conv_cadenas($cadena,$tp){ $valor=$cadena;    
   $valor=str_replace("º","o",$valor);	$valor=str_replace("Âo","o",$valor);
   if($tp==1){$valor=str_replace("Ñ","N",$valor); $valor=str_replace("Ã‘","N",$valor);
       $valor=str_replace("Á","A",$valor);  $valor=str_replace("Ã•","A",$valor);			   
	   $valor=str_replace("É","E",$valor);  $valor=str_replace("Ã‰","E",$valor);			   
	   $valor=str_replace("Í","I",$valor);  $valor=str_replace("Ã‰","I",$valor);			   
	   $valor=str_replace("Ó","O",$valor); $valor=str_replace("Ã“","O",$valor);
	   $valor=str_replace("Ú","U",$valor); $valor=str_replace("Ãš","U",$valor);
   }else{$valor=str_replace("Ñ","&Ntilde;",$valor); $valor=str_replace("Ã‘","&Ntilde;",$valor);
       $valor=str_replace("Á","&Aacute;",$valor);  $valor=str_replace("Ã•","&Aacute;",$valor);			   
	   $valor=str_replace("É","&Eacute;",$valor);  $valor=str_replace("Ã‰","&Eacute;",$valor);			   
	   $valor=str_replace("Í","&Iacute;",$valor);  $valor=str_replace("Ã‰","&Iacute;",$valor);			   
	   $valor=str_replace("Ó","&Oacute;",$valor); $valor=str_replace("Ã“","&Oacute;",$valor);
	   $valor=str_replace("Ú","&Uacute;",$valor); $valor=str_replace("Ãš","&Uacute;",$valor);
   }
return $valor;}

function cambiar_car_especiales($val){ 
  $val=str_replace("\r\n","",$val); $val=str_replace("\n","",$val);$val=str_replace('"','',$val); $val=str_replace("'","",$val); $val=str_replace("°","o.",$val);
  $val=str_replace("Á","A",$val); $val=str_replace("É","E",$val); $val=str_replace("Í","I",$val); $val=str_replace("Ú","U",$val); $val=str_replace("Ó","O",$val); 
return $val;}


function Rellecerosizq($str,$n){$numeroarellenar=$n-strlen($str); $texto="";
 for ($i=0; $i < $numeroarellenar; $i++){$texto=$texto."0";}
 $texto=$texto.$str; return $texto;}

function monto_letras($monto_chq){
$Numero1=array(" ","UNO ","DOS ","TRES ","CUATRO ","CINCO ","SEIS ","SIETE ","OCHO ","NUEVE ");
$NumeroR=array("DIEZ ","ONCE ","DOCE ","TRECE ","CATORCE ","QUINCE ","DIECISEIS ","DIECISIETE ","DIECIOCHO ","DIECINUEVE ");
$Numero10=array(" ","DIEZ ","VEINTE ","TREINTA ","CUARENTA ","CINCUENTA ","SESENTA ","SETENTA ","OCHENTA ","NOVENTA ");
$Numero100=array(" ","CIENTO ","DOSCIENTOS ","TRESCIENTOS ","CUATROCIENTOS ","QUINIENTOS ","SEISCIENTOS ","SETECIENTOS ","OCHOCIENTOS ","NOVECIENTOS ");
$St5 = "";$St4 = "";$St3 = "";$St2 = ""; $St1 = "";
$Nro_Puntos=0;$Nro_Puntos_Temp=0;
$Decimal= ""; $MontoEsc="";
$St=$monto_chq;$l=strlen($St);
$Decimal= "CON ".substr($St,$l-2,2)."/CTMS***"; $St=substr($St,0,$l-3);
for ($i=0; $i<$l; $i++) { if (substr($St,$i, 1) == ".") {$Nro_Puntos=$Nro_Puntos + 1; } }
$Nro_Puntos_Temp=$Nro_Puntos;
If ($Nro_Puntos_Temp==3){
   for ($i=0; $i<$l; $i++) {if (substr($St,$i, 1) != "."){$St4=$St4.substr($St,$i, 1);}
          if (substr($St,$i, 1) == "."){$St=substr($St,$i+1,11); $i=$l; $Nro_Puntos_Temp= $Nro_Puntos_Temp - 1;}}
}
If ($Nro_Puntos_Temp==2){
   for ($i=0; $i<$l; $i++) { if (substr($St,$i, 1) != "."){$St3=$St3.substr($St,$i, 1);}
          if (substr($St,$i, 1) == "."){$St=substr($St,$i+1,7); $i=$l; $Nro_Puntos_Temp= $Nro_Puntos_Temp - 1;} }
}
If ($Nro_Puntos_Temp==1){
   for ($i=0; $i<$l; $i++) {if (substr($St,$i, 1) != "."){$St2=$St2.substr($St,$i, 1);}
          if (substr($St,$i, 1) == "."){$St=substr($St,$i+1,3); $i=$l; $Nro_Puntos_Temp= $Nro_Puntos_Temp - 1;} }
}
$St1=$St;
$St5=Rellenarcerosizq($St5,3);$St4=Rellenarcerosizq($St4,3);$St3=Rellenarcerosizq($St3,3);$St2=Rellenarcerosizq($St2,3);$St1=Rellenarcerosizq($St1,3);
If($St3!="000"){ 
  If ((substr($St3,0, 1)== "1")){ $k=substr($St3,0,1); $c=substr($St3,2,1);
    if(substr($St3,1,1)== "0"){ $MontoEsc=$MontoEsc.$Numero100[$k].$Numero1[$c]; }
		else{$MontoEsc=$MontoEsc.$Numero100[$k].$NumeroR[$c];} }
   else{
     If ($St3=="100"){ $MontoEsc=$MontoEsc."CIEN "; }
       else{ 	   
	     $k=substr($St3,0,1)+1; $c=substr($St3,1,1); $MontoEsc=$MontoEsc.$Numero10[$c]; }
         If ((substr($St3,1, 1)== "0")or(substr($St3,2, 1)== "0")){
            if(substr($St3,2, 1)=="1"){ $MontoEsc=$MontoEsc."UN ";} else{ $k=substr($St3,2,1); $MontoEsc=$MontoEsc.$Numero1[$k];}
         }else{
            if(substr($St3,2, 1)=="1"){ $MontoEsc=$MontoEsc."Y UN ";} else{ $k=substr($St3,2,1); $MontoEsc=$MontoEsc."Y ".$Numero1[$k];}
         }		 
   }
   if(substr($St3,0, 3)== "001"){$MontoEsc=$MontoEsc."MILLON ";} else{$MontoEsc=$MontoEsc."MILLONES ";}
}
If($St2!="000"){
  If ((substr($St2,1, 1)== "1")){ $k=substr($St2,0,1); $c=substr($St2,2,1);
     $MontoEsc=$MontoEsc.$Numero100[$k].$NumeroR[$c]; }
   else{
     If ($St2=="100"){ $MontoEsc=$MontoEsc."CIEN "; }
       else{ $k=substr($St2,0,1); $c=substr($St2,1,1); $MontoEsc=$MontoEsc.$Numero100[$k].$Numero10[$c]; }
         If ((substr($St2,1, 1)== "0")or(substr($St2,2, 1)== "0")){
            if(substr($St2,2, 1)=="1"){ $MontoEsc=$MontoEsc."UN ";} else{ $k=substr($St2,2,1); $MontoEsc=$MontoEsc.$Numero1[$k];}
         }else{
            if(substr($St2,2, 1)=="1"){ $MontoEsc=$MontoEsc."Y UN ";} else{ $k=substr($St2,2,1); $MontoEsc=$MontoEsc."Y ".$Numero1[$k];}
         }
   }
   $MontoEsc=$MontoEsc."MIL ";
}
If($St1!="000"){
  If ((substr($St1,1, 1)== "1")){ $k=substr($St1,0,1); $c=substr($St1,2,1);
     $MontoEsc=$MontoEsc.$Numero100[$k].$NumeroR[$c]; }
   else{
     If ($St1=="100"){ $MontoEsc=$MontoEsc."CIEN "; }
       else{ $k=substr($St1,0,1); $c=substr($St1,1,1); $MontoEsc=$MontoEsc.$Numero100[$k].$Numero10[$c]; }

         If ((substr($St1,1, 1)== "0")or(substr($St1,2, 1)== "0")){
            $k=substr($St1,2,1); $MontoEsc=$MontoEsc.$Numero1[$k];}
         else{
            $k=substr($St1,2,1); $MontoEsc=$MontoEsc."Y ".$Numero1[$k];}

   }
}
$MontoEsc="***".$MontoEsc."BOLIVARES " .$Decimal;
$MontoEsc=str_replace('DIEZ Y UN', 'ONCE', $MontoEsc);
$MontoEsc=str_replace('DIEZ Y DOS', 'DOCE', $MontoEsc);
$MontoEsc=str_replace('DIEZ Y TRES', 'TRECE', $MontoEsc);
$MontoEsc=str_replace('DIEZ Y CUATRO', 'CATORCE', $MontoEsc);
$MontoEsc=str_replace('DIEZ Y CINCO', 'QUINCE', $MontoEsc);
$MontoEsc=str_replace('VEINTE Y UNO', 'VEINTIUNO', $MontoEsc);
$MontoEsc=str_replace('VEINTE Y DOS', 'VEINTIDOS', $MontoEsc);
$MontoEsc=str_replace('VEINTE Y TRES', 'VEINTITRES', $MontoEsc);
$MontoEsc=str_replace('VEINTE Y CUATRO', 'VEINTICUATRO', $MontoEsc);
$MontoEsc=str_replace('VEINTE Y CINCO', 'VEINTICINCO', $MontoEsc);
$MontoEsc=str_replace('VEINTE Y SEIS', 'VEINTISEIS', $MontoEsc);
$MontoEsc=str_replace('VEINTE Y SIETE', 'VEINTISIETE', $MontoEsc);
$MontoEsc=str_replace('VEINTE Y OCHO', 'VEINTIOCHO', $MontoEsc);
$MontoEsc=str_replace('VEINTE Y NUEB', 'VEINTINUEVE', $MontoEsc);
return $MontoEsc;}
?>