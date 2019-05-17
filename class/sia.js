<!--
var color_con_foco = '#CCFFFF';var color_sin_foco = '#ffffff'; var patronfecha = new Array(2,2,4);
function muestra(mensaje){ alert(mensaje); }
function encender( elemento ) {	if (!document.layers) elemento.style.background = color_con_foco; 	return true}
function apagar( elemento ) {if (!document.layers)elemento.style.background = color_sin_foco;	return true}
function Rellenarizq(Str,car,n){var NumeroaRellenar;var Texto;	var i;	NumeroaRellenar = Math.abs (Str.length - n);	Texto = "";	for (i = 0; i < NumeroaRellenar; i++) {	Texto = Texto + car;}	Texto =  Texto + Str;	return Texto;}
function MontoValido (monto){var mdec=0;var mnum=0;var i; 
    for (i = 0; i < monto.length; i++){if ((monto.charAt(i) == '.') || (monto.charAt(i) == '-') || (monto.charAt(i) == ',')){mdec=mdec+1;}
	   else{
		   if ((monto.charAt(i) == '0') || (monto.charAt(i) == '1') || (monto.charAt(i) == '2') || (monto.charAt(i) == '3') || (monto.charAt(i) == '4') || (monto.charAt(i) == '5') || (monto.charAt(i) == '6')  || (monto.charAt(i) == '7') || (monto.charAt(i) == '8') || (monto.charAt(i) == '9'))
		   {mnum=mnum+1;}
		   else{ return false;}
	   }
   }
   return true;}
function Rellenar(Str,car,n){var NumeroaRellenar;var Texto;	var i;NumeroaRellenar = Math.abs (Str.length - n);	Texto = "";for (i = 0; i < NumeroaRellenar; i++) {Texto = Texto + car; }Texto = Str + Texto;return Texto;}
function mascara(z,separador,cadena,nums){
if(z.valant != z.value){ temp = z.value; largo = temp.length; temp = temp.split(separador); temp2 = '';
	for(i=0;i<temp.length;i++){ temp2 += temp[i] }
	if(nums){for(j=0;j<temp2.length;j++){if(isNaN(temp2.charAt(j))){
				letra = new RegExp(temp2.charAt(j),"g")
				temp2 = temp2.replace(letra,"")} } };	temp = '';	temp3 = new Array();
	for(x=0; x<cadena.length; x++){temp3[x] = temp2.substring(0,cadena[x]); temp2 = temp2.substr(cadena[x]) }
	for(y=0;y<temp3.length; y++){ if(y ==0){temp = temp3[y]}
		else{ if(temp3[y] != ""){ temp += separador + temp3[y]}} }
	z.value = temp
	z.valant = temp	}
}
function SoloNumero(Str){var i;var j;
  for (i = 0; i <= Str.length - 1; i++) {if ((Str.charAt(i) >= '0') && (Str.charAt(i) <= '9') ) {j=i;} else{return false;} }
  return true;}
function quitaformatomonto (monto){var i;var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == ',')){str2 = str2 + ".";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;}

function camb_punto_coma (monto){var i;var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == ',')){str2 = str2 + ",";} else{if (monto.charAt(i) == '.'){str2 = str2 + ',';}else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } } }
   return str2;}   
 
 
//funcion para crear el promt del mensaje
function validatePrompt (Ctrl, PromptStr) {	alert (PromptStr);	Ctrl.focus();	return; } 

// -->	

