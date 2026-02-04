<?include ("../class/ventana.php"); include ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy();
$formato_cargo=$_POST["txtformato_cargo"];  $mpatron=arma_patron($formato_cargo);
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Definicion de Cargos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<script language="JavaScript" type="text/JavaScript">
var patroncodigo = new <?php echo $mpatron ?>;
function validarNum_s(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function quitacomas (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == ',')){str2 = str2 + ".";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9')) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;
}
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function apaga_monto(mthis){var mmonto;  
   apagar(mthis);   mmonto=mthis.value;  mmonto=camb_punto_coma(mmonto);   mthis.value=mmonto;
return true;}
function revisar(){ var f=document.form1;
    if(f.txtcodigo_cargo.value==""){alert("Codigo de Cargo no puede estar Vacio");return false;}else{f.txtcodigo_cargo.value=f.txtcodigo_cargo.value.toUpperCase();}
    if(f.txtdenominacion.value==""){alert("Descripcion del cargo estar Vacia"); return false; } else{f.txtdenominacion.value=f.txtdenominacion.value.toUpperCase();}
    if(f.txtnro_cargos.value==""){alert("Numero de cargos no puede estar Vacio"); return false; }
    if(f.txtsueldo_cargo.value==""){alert("Sueldo del cargo no puede estar Vacio"); return false; }
document.form1.submit;
return true;}
function tabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;
  if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus();
return false;} 
</script>
</head> 
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR CARGOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="406" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="403"><table width="92" height="403" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_cargo_ar.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_cargo_ar.php">Atras</a></td>
     </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
     </tr>
   </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 75px; left: 110px;">
        <form name="form1" method="post" action="Insert_cargo.php" onSubmit="return revisar()">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="866">
               <tr>
                 <td width="133" ><span class="Estilo5">C&Oacute;DIGO DEL CARGO  : </span></td>
                 <td width="733" ><span class="Estilo5"> <input class="Estilo10" name="txtcodigo_cargo" type="text" id="txtcodigo_cargo" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)" onkeyup="mascara(this,'-',patroncodigo,false)"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="143" ><span class="Estilo5">DESCRIPCI&Oacute;N DEL CARGO  : </span></td>
                 <td width="723" ><span class="Estilo5"><textarea name="txtdenominacion" cols="75" maxlength="100" id="txtdenominacion" class="Estilo10" onkeypress="return tabular(event,this)" onFocus="encender(this)" onBlur="apagar(this)" ></textarea></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="133" ><span class="Estilo5">GRADO DEL CARGO : </span></td>
                 <td width="500" ><span class="Estilo5"><input class="Estilo10" name="txtgrado" type="text" id="txtgrado" size="5" maxlength="3" onkeypress="return tabular(event,this)" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
                 <td width="133" ><span class="Estilo5">PASO DEL CARGO : </span></td>
                 <td width="100" ><span class="Estilo5"><input class="Estilo10" name="txtpaso" type="text" id="txtpaso" size="5" maxlength="3"  onkeypress="return tabular(event,this)" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
              </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="133" ><span class="Estilo5">NUMERO DE CARGOS : </span></td>
                 <td width="480" ><span class="Estilo5"><input class="Estilo10" name="txtnro_cargos" type="text" id="txtnro_cargos" size="5" maxlength="5" style="text-align:right" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event,this)"></span></td>
                 <td width="153" ><span class="Estilo5">CARGOS ASIGNADOS : </span></td>
                 <td width="100" ><span class="Estilo5"><input class="Estilo10" name="txtasignados" type="text" id="txtasignados" size="5" maxlength="5"  style="text-align:right" readonly value="0"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="133" ><span class="Estilo5">SUELDO DEL CARGO : </span></td>
                 <td width="733" ><span class="Estilo5"> <input class="Estilo10" name="txtsueldo_cargo" type="text" id="txtsueldo_cargo" size="20" maxlength="20"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" onKeypress="return validarNum(event,this)"></span></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <p>&nbsp;</p>
         <table width="859">
                <tr>
                  <td width="664">&nbsp;</td>
                  <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
                  <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
                </tr>
          </table>
        </div>
      </form>
    </td>
  </tr>
</table>
</body>
</html>