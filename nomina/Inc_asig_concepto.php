<?include ("../class/ventana.php"); include ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy(); $fecha_exp="31/12/9999";
$tipo_nomina=$_POST["txttipo_nomina"]; $des_nomina=$_POST["txtdes_nomina"]; $cantidad=0;$monto=0;$acumulado=0;$saldo=0; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Asignaci&oacute;n de Conceptos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
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
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function daformatomonto (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){if ((monto.charAt(i) == '.')){str2 = str2 + ",";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9')) || (monto.charAt(i) == '-') || (monto.charAt(i) == ',') ) {str2 = str2 + monto.charAt(i);} } }
return str2;}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function apaga_monto(mthis){var mmonto;  apagar(mthis); mmonto=mthis.value;  mmonto=daformatomonto(mmonto);   mthis.value=mmonto; } 
function encender_monto(mthis){var mmonto; encender(mthis);   mmonto=mthis.value;  mmonto=eliminapunto(mmonto);  mthis.value=mmonto;  }
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_nomina.value; mref = Rellenarizq(mref,"0",2); mform.txttipo_nomina.value=mref;
return true;}
function chequea_concepto(mform){ var mref;
 mref=mform.txtcod_concepto.value; mref = Rellenarizq(mref,"0",3); mform.txtcod_concepto.value=mref;
return true;}
function apaga_concepto(mthis){
var mref;  var mtipo=document.form1.txttipo_nomina.value; var mcodemp=document.form1.txtcod_empleado.value;
   apagar(mthis);   mref=document.form1.txtcod_concepto.value;
   ajaxSenddoc('GET', 'codret.php?cod_concepto='+mref+'&tipo_nomina='+mtipo, 'cret', 'innerHTML');
   ajaxSenddoc('GET', 'asigfrec.php?cod_concepto='+mref+'&tipo_nomina='+mtipo, 'dfrec', 'innerHTML');
   ajaxSenddoc('GET', 'codpresup.php?cod_concepto='+mref+'&tipo_nomina='+mtipo+'&cod_empleado='+mcodemp, 'cpresup', 'innerHTML');
return true;}
function chequea_orden(mform){ var mref;
 mref=mform.txtcod_orden.value; mref = Rellenarizq(mref,"0",3);  mform.txtcod_orden.value=mref;}
function revisar(){var f=document.form1; var Valido=true;
    if(f.txttipo_nomina.value==""){alert("Tipo de Nomina no puede estar Vacio");return false;}else{f.txttipo_nomina.value=f.txttipo_nomina.value.toUpperCase();}
    if(f.txtcod_empleado.value==""){alert("Codigo de Empleado no puede estar Vacio");return false;}else{f.txtcod_empleado.value=f.txtcod_empleado.value.toUpperCase();}
    if(f.txtdenominacion.value==""){alert("Denominacion no puede estar Vacia"); return false; } else{f.txtdenominacion.value=f.txtdenominacion.value.toUpperCase();}
    if(f.txtcod_concepto.value==""){alert("Codigo de concepto no puede estar Vacia"); return false; } else{f.txtcod_concepto.value=f.txtcod_concepto.value.toUpperCase();}
    if(f.txtfecha_ini.value==""){alert("Fecha de Inicio no puede estar Vacio");return false;}
    if(f.txtfecha_exp.value==""){alert("Fecha de Expiraci&oacute;n no puede estar Vacio");return false;}
	if(f.txtfecha_ini.value.length==10){Valido=true;}else{alert("Longitud de Fecha de Inicio Invalida");return false;}
	if(f.txtfecha_exp.value.length==10){Valido=true;}else{alert("Longitud de Fecha de Expiracion Invalida");return false;}
    document.form1.submit;
return true;}
</script>
</head>
<body>
<table width="991" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="76"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="872"><div align="center" class="Estilo2 Estilo6">INCLUIR ASIGNACI&Oacute;N DE CONCEPTOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="992" height="381" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="375"><table width="92" height="384" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_asig_concep_ar.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_asig_concep_ar.php">Atras</a></td>
     </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
     </tr>
      <tr><td>&nbsp;</td> </tr>
    </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 75px; left: 110px;">
        <form name="form1" method="post" action="Insert_asig_concepto.php" onSubmit="return revisar()">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="130"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></td>
                   <td width="60"><span class="Estilo5"> <input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="4" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_tipo(this.form);" value="<?echo $tipo_nomina?>"> </span></td>
                   <td width="50"><input class="Estilo10" name="bttiponom" type="button" id="bttiponom" title="Abrir Catalogo Tipos de Nomina"  onClick="VentanaCentrada('Cat_tipo_nomina.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="645"><span class="Estilo5"> <input class="Estilo10" name="txtdes_nomina" type="text" id="txtdes_nomina" size="100" maxlength="100" readonly value="<?echo $des_nomina?>" > </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="156"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR  : </span></td>
                   <td width="110"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                   <td width="50"><input class="Estilo10" name="bttrabajador" type="button" id="bttrabajador" title="Abrir Catalogo Trabajadores"  onClick="VentanaCentrada('Cat_trabajadores.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="550"><span class="Estilo5"> <input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="80" maxlength="80" readonly value="<?echo $nombre?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="156"><span class="Estilo5">C&Oacute;DIGO DE CONCEPTO : </span></td>
                   <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto" type="text" id="txtcod_concepto" size="4" maxlength="3" onFocus="encender(this)" onBlur="apaga_concepto(this)" onchange="chequea_concepto(this.form);"> </span></td>
                   <td width="50"><input class="Estilo10" name="btconcepto" type="button" id="btconcepto" title="Abrir Catalogo Conceptos"  onClick="VentanaCentrada('Cat_conceptos.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="100"><span class="Estilo5">DENOMINACI&Oacute;N : </span></td>
                   <td width="500"><span class="Estilo5"> <input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="75" maxlength="75" readonly> </span></td>
                 </tr>
             </table></td>
            </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="100"><span class="Estilo5">FECHA INICIO : </span></td>
                   <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ini" type="text" id="txtfecha_ini" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>"  onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                   <td width="130"><span class="Estilo5">FECHA EXPIRACI&Oacute;N : </span></td>
                   <td width="136"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_exp" type="text" id="txtfecha_exp" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_exp?>"  onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                   <td width="75"><span class="Estilo5">ACTIVO : </span></td>
                   <td width="95"><span class="Estilo5"><select class="Estilo10" name="txtactivo" size="1" id="txtactivo" onFocus="encender(this)" onBlur="apagar(this)"><option>SI</option> <option>NO</option></select>  </span></td>
                   <td width="95"><span class="Estilo5">CALCULABLE : </span></td>
                   <td width="95"><span class="Estilo5"><select class="Estilo10" name="txtcalculable" size="1" id="txtcalculable" onFocus="encender(this)" onBlur="apagar(this)"><option>SI</option> <option>NO</option></select>  </span></td>
                  </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="80"><span class="Estilo5">CANTIDAD : </span></td>
                   <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtcantidad" type="text" id="txtcantidad" style="text-align:right" size="14" maxlength="14" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $cantidad?>" onKeypress="return validarNum(event)"> </span></td>
                   <td width="70"><span class="Estilo5">MONTO : </span></td>
                   <td width="140"><span class="Estilo5"> <input class="Estilo10" name="txtmonto" type="text" id="txtmonto" style="text-align:right" size="14" maxlength="14" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $monto?>" onKeypress="return validarNum(event)"> </span></td>
                   <td width="95"><span class="Estilo5">ACUMULADO : </span></td>
                   <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtacumulado" type="text" id="txtacumulado" style="text-align:right" size="14" maxlength="14" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $acumulado?>" onKeypress="return validarNum(event)"></span></td>
                   <td width="65"><span class="Estilo5">SALDO : </span></td>
                   <td width="130"><span class="Estilo5"><input class="Estilo10" name="txtsaldo" type="text" id="txtsaldo" style="text-align:right" size="14" maxlength="14" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $saldo?>" onKeypress="return validarNum(event)"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
            <td><table width="866">
                 <tr>
                   <td width="90"><span class="Estilo5">FRECUENCIA : </span></td>
                   <td width="310"><span class="Estilo5"><div id="dfrec"><select class="Estilo10" name="txtfrecuencia" size="1" id="txtfrecuencia" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>PRIMERA QUINCENA</option> <option>SEGUNDA QUINCENA</option> <option>PRIMERA Y SEGUNDA QUINCENA</option>
                      <option>PRIMERA SEMANA</option> <option>SEGUNDA SEMANA</option> <option>TERCERA SEMANA</option> <option>CUARTA SEMANA</option>
                      <option>QUINTA SEMANA</option> <option>TODAS LAS SEMANAS</option> <option>ULTIMA SEMANA</option> </select> </div> </span></td>
                   <td width="190"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO : </span></td>
                   <td width="230"><span class="Estilo5"><div id="cpresup"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" size="35" maxlength="32"onFocus="encender(this)" onBlur="apagar(this)"> </div></span></td>
                   <td width="46"><input class="Estilo10" name="btcodpre" type="button" id="btcodpre" title="Abrir Catalogo C&oacute;digos Presupuestario"  onClick="VentanaCentrada('Cat_cod_pre.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="150" ><span class="Estilo5">AFECTA PRESUPUESTO : </span></td>
                   <td width="100"><span class="Estilo5"><select class="Estilo10" name="txtafecta_presup" size="1" id="txtafecta_presup" onFocus="encender(this)" onBlur="apagar(this)"><option>SI</option> <option>NO</option></select>  </span></td>
                   <td width="220" ><span class="Estilo5">IMPUTACI&Oacute;N PRESUPUESTARIA FIJA : </span></td>
                   <td width="100"><span class="Estilo5"><select class="Estilo10" name="txtimp_fija" size="1" id="txtimp_fija" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select>  </span></td>
                   <td width="190" ><span class="Estilo5">C&Oacute;DIGO TIPO DE RETENCI&Oacute;N : </span></td>
                   <td width="60" ><span class="Estilo5"><div id="cret"><input class="Estilo10" name="txtcod_retencion" type="text" id="txtcod_retencion" size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)"></div> </span></td>
                   <td width="46"><input class="Estilo10" name="bttiporet" type="button" id="bttiporet" title="Abrir Catalogo Tipos de Retencion"  onClick="VentanaCentrada('Cat_tipo_ret.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                  </tr>
             </table></td>
           </tr>
         </table>
         <p>&nbsp;</p>
         <table width="859">
                <tr>
                  <td width="64"><input class="Estilo10" name="txtdescripcion_ret" type="hidden" id="txtdescripcion_ret" value=""></td>
                  <td width="600">&nbsp;</td>
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