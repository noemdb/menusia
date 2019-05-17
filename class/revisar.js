function revisar(){var f=document.form1; var i; var Str;
  Str=f.txtusuario.value;for (i = 0; i <= Str.length - 1; i++) {if ((Str.charAt(i)== "'") || (Str.charAt(i) == '-') ) { alert("Valor Login Invalido"); return false;} }
Str=f.txtclave.value;for (i = 0; i <= Str.length - 1; i++) {if ((Str.charAt(i)== "'") || (Str.charAt(i) == '-') ) { alert("Valor Clave Invalida"); return false;} }
  if(f.txtempresa.value==""){alert("Empresa no puede estar Vacio");return false;}  else{f.txtempresa.value=f.txtempresa.value.toUpperCase();}
  if(f.txtclave.value==""){alert("Clave no puede estar Vacia");return false;}  else{f.txtclave.value=f.txtclave.value.toUpperCase();}
  if(f.txtusuario.value==""){alert("Login de Usuario no puede estar Vacio");return false; } else{f.txtusuario.value=f.txtusuario.value.toUpperCase();}
document.form1.submit;
return true;}