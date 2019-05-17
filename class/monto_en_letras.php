function monto_en_letras($monto_chq){
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