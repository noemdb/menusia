<?include ("../class/ventana.php");include ("../class/fun_numeros.php"); include ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Saldo de Prestaciones)</title>
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
var patronfecha = new Array(2,2,4);
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function daformatomonto (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){if ((monto.charAt(i) == '.')){str2 = str2 + ",";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9')) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;
}
function quitacomas (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == ',')){str2 = str2 + ".";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9')) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;
}
function cambia_punto_coma (monto){var i;var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == ',')){str2 = str2 + ",";} else{if (monto.charAt(i) == '.'){str2 = str2 + ',';}else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } } }
   return str2;}   
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function apaga_monto(mthis){var mmonto;  apagar(mthis); mmonto=mthis.value;  mmonto=cambia_punto_coma(mmonto);   mthis.value=mmonto; } 
function encender_monto(mthis){var mmonto; encender(mthis);   mmonto=mthis.value;  mmonto=eliminapunto(mmonto);  mthis.value=mmonto;  }
function chequea_monto(mform){var mmonto; var minte; var madel; var mret; var mintd; var mintp; var mintn;
   mmonto=quitacomas(mform.txttotal_prestaciones.value);   
   minte=quitacomas(mform.txttotal_interes.value);     
   madel=quitacomas(txttotal_adelanto.value); 
   mintd=quitacomas(mform.txtinteres_devengado.value);  
   mintn=quitacomas(mform.txtinteres_noacum.value);     
   mintp=quitacomas(txtinteres_pagado.value);   
   mmonto=(mmonto*1); minte=(minte*1); madel=(madel*1); 
   mintp=(mintp*1);  mintd=(mintd*1);  mintn=(mintn*1); 
   // alert(mmonto); alert(minte); alert(madel);  
   minte=mintd+mintn-mintp; minte=Math.round(minte*100)/100;   
   mret=mmonto+minte-madel; mret=Math.round(mret*100)/100;     
   mform.txtacumulado_total.value=mret; 
   mform.txttotal_interes.value=minte;
    //alert('a '+mform.txtacumulado_total.value);
   mform.txtacumulado_total.value=daformatomonto(mform.txtacumulado_total.value);
   mform.txttotal_interes.value=daformatomonto(mform.txttotal_interes.value);
return true;}

function revisar(){
var f=document.form1;
    if(f.txtcod_empleado.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}else{f.txtcod_empleado.value=f.txtcod_empleado.value.toUpperCase();}
    if(f.txtfecha_calculo.value==""){alert("Fecha de calculo no puede estar Vacia"); return false; }
    if(f.txtacumulado_total.value==""){alert("Saldo de Prestaciones no puede estar Vacio"); return false; }
    if(f.txttotal_prestaciones.value==""){alert("Saldo de Prestaciones no puede estar Vacio"); return false; }
document.form1.submit;
return true;}
</script>
</head>   
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR SALDO DE PRESTACIONES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="406" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="403"><table width="92" height="403" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_saldo_prestaciones.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_saldo_prestaciones.php">Atras</a></td>
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
        <form name="form1" method="post" action="Insert_saldo_presta.php" onSubmit="return revisar()">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="156"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR  : </span></td>
                   <td width="110"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                   <td width="50"><input class="Estilo10" name="btconcepto" type="button" id="bttrabajador" title="Abrir Catalogo Trabajadores"  onClick="VentanaCentrada('Cat_trabajadores.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="550"><span class="Estilo5"> <input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="80" maxlength="80" readonly> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="146" ><span class="Estilo5">FECHA CALCULO : </span></td>
                 <td width="150" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_calculo" type="text" id="txtfecha_calculo" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>"></span></td>
                 <td width="130" ><span class="Estilo5">MONTO SUELDO : </span></td>
                 <td width="180" ><span class="Estilo5"><input class="Estilo10" name="txtsueldo_calculo" type="text" id="txtsueldo_calculo" size="17" maxlength="17"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="0" onKeypress="return validarNum(event)"></span></td>
                 <td width="120"><span class="Estilo5">CANTIDAD DIAS  :</span></td>
                 <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtdias_prestaciones" type="text" id="txtdias_prestaciones" size="10" maxlength="10"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="0" onKeypress="return validarNum(event)"></span></td>
              </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="216" ><span class="Estilo5">MONTO SUELDO DIAS ADICIONALES: </span></td>
                 <td width="310" ><span class="Estilo5"><input class="Estilo10" name="txtsueldo_calculo_adic" type="text" id="txtsueldo_calculo_adic" size="17" maxlength="17" style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="0" onKeypress="return validarNum(event)"></span></td>
                 <td width="200" ><span class="Estilo5">CANTIDAD DIAS ADICIONALES : </span></td>
                 <td width="140" ><span class="Estilo5"><input class="Estilo10" name="txtdias_adicionales" type="text" id="txtdias_adicionales" size="10" maxlength="10"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="0" onKeypress="return validarNum(event)"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="216" ><span class="Estilo5">TOTAL PRESTACIONES : </span></td>
                 <td width="330" ><span class="Estilo5"> <input class="Estilo10" name="txttotal_prestaciones" type="text" id="txttotal_prestaciones" size="17" maxlength="17"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="0" onKeypress="return validarNum(event)" onchange="chequea_monto(this.form);"  ></span></td>
                 <td width="140" ><span class="Estilo5">TOTAL ADELANTO : </span></td>
                 <td width="180" ><span class="Estilo5"><input class="Estilo10" name="txttotal_adelanto" type="text" id="txttotal_adelanto" size="17" maxlength="17"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="0" onKeypress="return validarNum(event)" onchange="chequea_monto(this.form);"  ></span></td>
                </tr>
             </table></td>
           </tr>           
		   <tr>
             <td><table width="866">
               <tr>
                 <td width="216" ><span class="Estilo5">INTERES CAPITALIZADO : </span></td>
                 <td width="310" ><span class="Estilo5"> <input class="Estilo10" name="txtinteres_devengado" type="text" id="txtinteres_devengado" size="17" maxlength="17"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="0" onKeypress="return validarNum(event)" onchange="chequea_monto(this.form);"  ></span></td>
                 <td width="200" ><span class="Estilo5">INTERES NO CAPITALIZADO : </span></td>
                 <td width="140" ><span class="Estilo5"><input class="Estilo10" name="txtinteres_noacum" type="text" id="txtinteres_noacum" size="17" maxlength="17"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="0" onKeypress="return validarNum(event)" onchange="chequea_monto(this.form);"  ></span></td>
                </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="866">
               <tr>
			     <td width="216" ><span class="Estilo5">INTERES PAGADO : </span></td>
                 <td width="330" ><span class="Estilo5"><input class="Estilo10" name="txtinteres_pagado" type="text" id="txtinteres_pagado" size="17" maxlength="17"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="0" onKeypress="return validarNum(event)" onchange="chequea_monto(this.form);"  ></span></td>
                 <td width="140" ><span class="Estilo5">TOTAL INTERESES : </span></td>
                 <td width="180" ><span class="Estilo5"><input class="Estilo10" name="txttotal_interes" type="text" id="txttotal_interes" size="17" maxlength="17"  style="text-align:right" readonly onKeypress="return validarNum(event)"   ></span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="866">
               <tr>
                 <td width="216" ><span class="Estilo5">SALDO PRESTACIONES : </span></td>
                 <td width="330" ><span class="Estilo5"> <input class="Estilo10" name="txtacumulado_total" type="text" id="txtacumulado_total" size="17" maxlength="17"  style="text-align:right" readonly></span></td>
                 <td width="140" ><span class="Estilo5"> </span></td>
                 <td width="180" ><span class="Estilo5"></span></td>
                </tr>
             </table></td>
           </tr>
		   <!--
           <tr>
             <td><table width="866">
               <tr>
                 <td width="216" ><span class="Estilo5">SALDO PRESTACIONES ART.668: </span></td>
                 <td width="250" ><span class="Estilo5"> <input class="Estilo10" name="txtsaldo_prestaciones668" type="text" id="txtsaldo_prestaciones668" size="17" maxlength="17"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="0" onKeypress="return validarNum(event)"  ></span></td>
                 <td width="220" ><span class="Estilo5">INTERESES PRESTACIONES ART.668: </span></td>
                 <td width="180" ><span class="Estilo5"><input class="Estilo10" name="txttotal_interes668" type="text" id="txttotal_interes668" size="17" maxlength="17"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="0" onKeypress="return validarNum(event)"  ></span></td>
                </tr>
             </table></td>
           </tr>
		    -->
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