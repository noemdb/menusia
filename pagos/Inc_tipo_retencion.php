<?include ("../class/ventana.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Incluir Tipos de Retenci&oacute;n)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function revisar(){
var f=document.form1;
    if(f.txttipo_retencion.value==""){alert("Tipo de Retencion no puede estar Vacio");return false;}
    if(f.txtdescripcion_ret.value==""){alert("Descripción Tipo de Retenci0n no puede estar Vacia");return false; } else{f.txtdescripcion_ret.value=f.txtdescripcion_ret.value.toUpperCase();}
    if(f.txttipo_retencion.value.length==3){f.txttipo_retencion.value=f.txttipo_retencion.value.toUpperCase();} else{alert("Longitud Tipo de Retenci0n Invalida");return false;}
    if(f.txttasa.value==""){alert("Tasa no puede estar Vacio");return false;}
    if(MontoValido(f.txttasa.value)) {Valido=true;} else{alert("Tasa debe tener valores numericos.");return false;}
document.form1.submit;
return true;}
</script>
<script language="JavaScript" type="text/JavaScript">
function LlamarURL(url){  document.location = url; }
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_retencion.value;   mref = Rellenarizq(mref,"0",3);   mform.txttipo_retencion.value=mref;
return true;}
function chequea_fondo(mform){var mref;
   mref=mform.txtcod_fondo.value;   mref = Rellenarizq(mref,"0",3);   mform.txtcod_fondo.value=mref;
return true;}
</script>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR TIPOS DE RETENCIONES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="440" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="438" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_tipo_retencion.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_tipo_retencion.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
          <div id="Layer1" style="position:absolute; width:872px; height:346px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="Insert_tipo_retencion.php" onSubmit="return revisar()">
        <table width="808" height="252" border="0" align="center" >
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="844" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="59"><span class="Estilo5">TIPO :</span></td>
                  <td width="93"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txttipo_retencion" type="text" id="txttipo_retencion" size="6" maxlength="3"  onFocus="encender(this)" onBlur="apagar(this)"  onchange="chequea_tipo(this.form);">  </span></div></td>
                  <td width="113"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                  <td width="562"><span class="Estilo5"> <input class="Estilo10" name="txtdescripcion_ret" type="text" id="txtdescripcion_ret" size="80"  onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                  <td width="17">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="835" height="18" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="60"><span class="Estilo5">TASA :</span></td>
                  <td width="167"><span class="Estilo5"> <input class="Estilo10" name="txttasa" type="text" id="txttasa" size="8" maxlength="6"  onFocus="encender(this)" onBlur="apagar(this)" style="text-align:right" onKeypress="return validarNum(event)"> </span></td>
                  <td width="130"><span class="Estilo5">BASE IMPONIBLE :</span></td>
                  <td width="168"><span class="Estilo5"><input class="Estilo10" name="txtbase_imponible" type="text" id="txtbase_imponible" size="8" maxlength="6"  onFocus="encender(this)" onBlur="apagar(this)" style="text-align:right" onKeypress="return validarNum(event)">   </span></td>
                  <td width="136"><span class="Estilo5">PAGOS MAYOR A :</span></td>
                  <td width="174"><span class="Estilo5"><input class="Estilo10" name="txtpago_mayor" type="text" id="txtpago_mayor" size="18" maxlength="16"  onFocus="encender(this)" onBlur="apagar(this)" style="text-align:right" onKeypress="return validarNum(event)">  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="835" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="100"><span class="Estilo5">SUSTRAENDO:</span></td>
                  <td width="164"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtsustraendo" type="text" id="txtsustraendo" size="18" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" style="text-align:right" onKeypress="return validarNum(event)">   </span></div></td>
                  <td width="159"><span class="Estilo5">REDONDEA OPERACI&Oacute;N: </span></td>
                  <td width="95"><span class="Estilo5"> <select name="txtred_operacion" size="1" id="txtred_operacion" onFocus="encender(this)" onBlur="apagar(this)">                      
				    <option>NO</option> <option>SI</option> </select> </span></td>
                  <td width="151"><span class="Estilo5">GRUPO DE RETENCI&Oacute;N :</span></td>
                  <td width="166"><div align="left"><span class="Estilo5">
                    <select name="txtret_grupo" size="1" id="txtret_grupo" onFocus="encender(this)" onBlur="apagar(this)">
                      <option selected>OTROS</option>  <option>NOMINA</option>
                      <option>ISLR</option> <option>IVA</option>
                      <option>LABORAL</option>          <option>FIEL CUMPLIMIENTO</option>
					  <option>TIMBRE FISCAL</option>    <option>RESPONSABILIDAD</option> <option>MINERALES</option>  <option>ACT ECONOMICA</option>

                    </select>
                  </span></div></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="824" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="136"><span class="Estilo5">C&Oacute;DIGO CONTABLE :</span></td>
                  <td width="185"><span class="Estilo5"><input class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" size="25" maxlength="25"  onFocus="encender(this)" onBlur="apagar(this)">           </span></td>
                  <td width="49"><div align="left"><span class="Estilo5">  <input class="Estilo10" name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo C&oacute;digo de Cuentas"  onClick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="..."> </span></div></td>
                  <td width="454"><span class="Estilo5"> <input class="Estilo10" name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta" size="67" readonly > </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td width="883" height="14">&nbsp;</td>
          </tr>
          <tr>
            <td><table width="834">
                <tr>
                  <td width="154"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                  <td width="138"><span class="Estilo5"><input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                  </span></td>
                  <td width="52"><span class="Estilo5"><input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../presupuesto/Cat_beneficiarios.php?criterio=','SIA','','750','500','true')" value="...">
                  </span></td>
                  <td width="470"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="70" readonly> </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>  <td height="14">&nbsp;</td></tr>
          <tr>
            <td height="24"><table width="843" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="276" height="22"><span class="Estilo5">GENERAR ASIENTO EN EL COMPROBANTE :</span></td>
                  <td width="230"><div align="left"><span class="Estilo5">
                    <select name="txtstatus_1" size="1" id="txtstatus_1" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>SI</option> <option>NO</option></select>
                  </span></div></td>
                  <td width="148"><span class="Estilo5">RETENCI&Oacute;N PARCIAL :</span></td>
                  <td width="189"><span class="Estilo5">
                    <select name="txtstatus_2" size="1" id="txtstatus_2" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>NO</option><option>SI</option> </select>
                  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr><td height="14">&nbsp;</td></tr>
		  <tr>
                  <td height="24"><table width="843" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="300" height="22"><span class="Estilo5">CODIGO DEL CONCEPTO DE RETENCION  :</span></td>
                      <td width="543"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_fondo" type="text" id="txtcod_fondo" size="6" maxlength="3"  onFocus="encender(this)" onBlur="apagar(this)"  onchange="chequea_fondo(this.form);">  </span></div></td>
                    </tr>
                  </table></td>
           </tr>
          <tr><td height="14">&nbsp;</td></tr>
        </table>
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        </form>
    </div>
    </td>
  </tr>
</table>
</body>
</html>
