<? include ("../class/ventana.php"); include ("../class/fun_fechas.php"); 
 $SIA_Definicion=$_POST["txtSIA_Definicion"];  $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"];  
 $ced_r=$_POST["txtced_r"]; $nomb_r=$_POST["txtnomb"]; $fecha_fin=$_POST["txtfecha_fin"];$Formato_Cuenta=$_POST["txtformato"]; $titulo=$_POST["txttitulo"];
 $fecha_hoy=asigna_fecha_hoy(); $fecha_c="01/01/".substr($fecha_fin,0,4);
 $mpatron="Array(2,2,2,2,2,3,2,2,2,2)";  $mpatron=arma_patron($Formato_Cuenta);
 ?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (C&oacute;ndigos/Asignaci&oacute;nn)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="Javascript" src="../class/sia.js" type="text/javascript"></script>
<script language="Javascript" type="text/Javascript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<script language="Javascript" type="text/Javascript">
var patroncodigo = new <?php echo $mpatron ?>;
function validarcod(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\-]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function revisar(){ var f=document.form1; var Valido;
    if(f.txtcod_presup.value==""){alert("Codigo Presupuestario no puede estar Vacio"); f.txtcod_presup.focus(); return false;}
    if(f.txtcod_fuente.value==""){alert("Fuente de Financiamiento no puede estar Vacio"); f.txtcod_fuente.focus(); return false;}
    if(f.txtdenominacion.value==""){alert("Denominacion del Codigo Presupuestario no puede estar Vacia"); f.txtdenominacion.focus();  return false; }  else{f.txtdenominacion.value=f.txtdenominacion.value.toUpperCase();}
    if(f.txtAplicacion.value==""){alert("Codigo de Aplicacion no puede estar Vacio"); f.txtAplicacion.focus(); return false;}
    if(f.txtAplicacion.value.length==1){f.txtAplicacion.value=f.txtAplicacion.value.toUpperCase();} else{alert("Longitud Codigo de Aplicacion Invalida"); f.txtAplicacion.focus(); return false;}
    if(f.txtasignado.value==""){alert("Asignacion Inicial no puede estar Vacio"); f.txtasignado.focus(); return false;}
    if(MontoValido(f.txtasignado.value)) {Valido=true;} else{alert("Asignacion Inicial debe tener valores numericos."); f.txtasignado.focus(); return false;}
document.form1.submit;
return true;}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 
</script>
</style>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR C&Oacute;DIGOS/ASIGNACI&Oacute;N </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="367" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="365" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_codigos.php?Gcodigo=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_codigos.php?Gcodigo=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:274px; z-index:1; top: 62px; left: 113px;">
            <form name="form1" method="post" action="Insert_codigos.php" onSubmit="return revisar()">
        <table width="861" border="0" align="center">
            <tr>
              <td>&nbsp;</td>
            </tr>
			<tr>
              <td><table width="840" border="0">
                <tr>
                  <td width="175"><span class="Estilo5">&nbsp;</span></td>
                  <td width="227"><span class="Estilo10"> <? echo $titulo; ?>    </span></td>
                  <td width="109">&nbsp;</td>
                  <td width="33"></td>
                  <td width="288"></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="840" border="0">
                <tr>
                  <td width="175"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :</span></td>
                  <td width="227"><span class="Estilo5"> <input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" size="32" maxlength="32" onFocus="encender(this); " onBlur="apagar(this);" onKeypress="return validarcod(event,this)" onkeyup="mascara(this,'-',patroncodigo,true)" >    </span></td>
                  <td width="109">&nbsp;</td>
                  <td width="33"></td>
                  <td width="288"></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="843" border="0">
                <tr>
                  <td width="198"><span class="Estilo5">FUENTE DE FINANCIAMIENTO :</span></td>
                  <td width="21"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuente" type="text" id="txtcod_fuente" size="3" maxlength="2" onFocus="encender(this); " onBlur="apagar(this);" onkeypress="return stabular(event,this)">  </span></td>
                  <td width="45"><input class="Estilo10" name="btfuente" type="button" id="btfuente" title="Abrir Catalogo Fuentes de Financiamiento" onclick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></td>
                  <td width="569"><span class="Estilo5"> <input class="Estilo10" name="txtdes_fuente" type="text" id="txtdes_fuente" size="75" readonly onkeypress="return stabular(event,this)"> </span></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="849" border="0">
                <tr>
                  <td width="108"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                  <td width="731"><textarea name="txtdenominacion" cols="84" class="Estilo10" id="txtdenominacion" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)"></textarea></td>
                </tr>
              </table>                </td>
            </tr>
            <tr>
              <td ><table width="849" border="0">
                <tr>
                  <td width="182"><span class="Estilo5">CODIGO CONTABLE GASTO:</span></td>
                  <td width="152"><span class="Estilo5"><input class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" size="25" maxlength="30" onFocus="encender(this); " onBlur="apagar(this);" onkeypress="return stabular(event,this)">   </span></td>
                  <td width="37"><input class="Estilo10" name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo Codigo de Cuentas"  onclick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></td>
                  <td width="460"><span class="Estilo5"><input class="Estilo10" name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta" size="65" maxlength="250" readonly onkeypress="return stabular(event,this)">   </span></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td ><table width="848" border="0">
                <tr>
                  <td width="112"><span class="Estilo5">TIPO DE GASTO :</span> </td>
                  <td width="176"><span class="Estilo5"> <select name="txtTipo_Gasto" size="1" id="select" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)">
                      <option selected>CORRIENTE</option> <option>INVERSION</option>    </select> </span></td>
                  <td width="90" class="Estilo5"><span class="Estilo5">APLICACI&Oacute;N :</span> </td>
                  <td width="103" class="Estilo5"><input class="Estilo10" name="txtAplicacion" type="text" id="txtAplicacion" title="Registre el Tipo de Aplicacion" size="4" maxlength="1" value="1"  onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)"></td>
                  <td width="93" class="Estilo5">ASIGNACI&Oacute;N :</td>
                  <td width="248" class="Estilo5">
                   <? IF($SIA_Definicion=="N"){?>
                       <input class="Estilo10" name="txtasignado" type="text" id="txtasignado" size="30" style="text-align:right" maxlength="30" title="Registre el Monto de Asignacion" value="0" onFocus="encender_monto(this)" onBlur="apagar(this)" onKeypress="return validarNum(event,this)" >
                    <?} else { ?>
                       <input class="Estilo10" name="txtasignado" type="text" id="txtasignado" size="30" style="text-align:right" maxlength="30" readonly value="0" onkeypress="return stabular(event,this)">
                     <?}?>
                   </td>
                </tr>
              </table></td>
            </tr>
            <tr><td >&nbsp;</td> </tr>
        </table>
        <p>&nbsp;</p>
                <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
            </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>