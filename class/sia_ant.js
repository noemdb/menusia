<!--
var color_con_foco = '#CCFFFF';
var color_sin_foco = '#ffffff';
function encender( elemento ) {
	if (!document.layers) elemento.style.background = color_con_foco
 	return true
}
function apagar( elemento ) {
	if (!document.layers)elemento.style.background = color_sin_foco
	return true
}
function muestra(mensaje)
{
   alert(mensaje);
}
function insertaChr (s1, chr, num){
   var lenstr1 = s1.length;
   var cantChr = Math.floor ((lenstr1 - 1) / num);
   var str2 = "";
   while (cantChr > 0){
      str2 = chr + s1.substring (lenstr1 - num, lenstr1) + str2;
      lenstr1 = lenstr1 - num;
      cantChr--;
   }
   str2 = s1.substring (0, lenstr1) + str2;
   return str2;
}
function formateaMonto (monto){
   var smonto = monto.substring (0, monto.length - 3) + monto.substring (monto.length - 2, monto.length + 1);
   var str2 = insertaChr ((smonto.substring (0, smonto.length - 2)), '.', 3);
   str2 = str2 + "," + smonto.substring (smonto.length - 2, smonto.length + 1);
   return str2;
}
function MontoValido (monto){
var mdec=0;
var mnum=0;
    for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == '.') || (monto.charAt(i) == ',')){mdec=mdec+1;}
	   else{
		   if ((monto.charAt(i) == '0') || (monto.charAt(i) == '1') || (monto.charAt(i) == '2') || (monto.charAt(i) == '3') || (monto.charAt(i) == '4') || (monto.charAt(i) == '5') || (monto.charAt(i) == '6')  || (monto.charAt(i) == '7') || (monto.charAt(i) == '8') || (monto.charAt(i) == '9'))
		   {mnum=mnum+1;}
		   else{return false;}
	   }
   }
   return true;
}
function EsNumero(Str){
	var i;
	var j;
	for (i = 0; i <= Str.length - 1; i++) { 
		if ((Str.charAt(i) >= '0') && (Str.charAt(i) <= '9') ) {j=i;}
		else{return false;}
	}
	return true;	
}
function SuprimirEspacios(str)
{
		var strnew, i
		strnew = ""
		for (i = 0; i <= str.length - 1; i++) {
			if (str.charAt(i) != " " ) strnew = strnew + str.charAt(i)
		}
		return (strnew)
}
function EsAlphaNumerico(Str)
{
	var i, Result
	Result = TodosEspacios (Str)
	if (Result)  return(false)
	for (i = 0; i <= Str.length - 1; i++) {
		if ((Str.charCodeAt(i) >= 48 && Str.charCodeAt(i) <= 57)||(Str.charCodeAt(i) >= 65 && Str.charCodeAt(i) <= 90)||(Str.charCodeAt(i) >= 97 && Str.charCodeAt(i) <= 122) ) continue
		else return(false)
	}
	return(true)	
}

function TodosEspacios(str)
{
	var i
	for (i = 0; i <= str.length - 1; i++) {
		if (str.charAt(i) == " " ) continue
		else return (false)
	}
	return (true)
}

function Rellenar(Str,car,n)
{
	var NumeroaRellenar
	var Texto
	NumeroaRellenar = Math.abs (Str.length - n)
	Texto = ""
	for (i = 0; i < NumeroaRellenar; i++) {
		Texto = Texto + car
	}
	Texto = Str + Texto
	return(Texto)	
}

function Rellenarizq(Str,car,n)
{
	var NumeroaRellenar
	var Texto
	NumeroaRellenar = Math.abs (Str.length - n)
	Texto = ""
	for (i = 0; i < NumeroaRellenar; i++) {
		Texto = Texto + car
	}
	Texto =  Texto + Str;
	return(Texto)	
}

function TieneCaracter(caracter, cadena) 
{
		return caracter.test(cadena)
}

// -->	

