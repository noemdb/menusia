<?php include ("../class/seguridad.inc");include ("../class/ventana.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Definci&oacute;n de Bancos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel=stylesheet>
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
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function apaga_monto(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=mthis.value;  mmonto=camb_punto_coma(mmonto); mthis.value=mmonto;
 return true;}
function revisar(){var f=document.form1;
    if(f.txtcod_banco.value==""){alert("Codigo de Banco no puede estar Vacio");return false;}
    if(f.txtnombre_banco.value==""){alert("Nombre de Banco no puede estar Vacia");return false;} else{f.txtnombre_banco.value=f.txtnombre_banco.value.toUpperCase();}
    if(f.txtcod_banco.value.length==4){f.txtcod_banco.value=f.txtcod_banco.value.toUpperCase();} else{alert("Longitud Codigo de Banco Invalida");return false;}
    if(f.txtCodigo_Cuenta.value==""){alert("Codigo Contable no puede estar Vacio");return false;}
document.form1.submit;
return true;}
function LlamarURL(url){  document.location = url; }
function chequea_codigo(mform){var mref;
   mref=mform.txtcod_banco.value; mref = Rellenarizq(mref,"0",4); mform.txtcod_banco.value=mref;
return true;}
</script>
</head>
<body>
<table width="992" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR DEFINICI&Oacute;N DE BANCOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="992" height="640" border="1" id="tablacuerpo">
  <tr>
    <td width="93" height="638"><table width="92" height="635" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_bancos.php?Gcod_banco=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_bancos.php?Gcod_banco=U">Atras</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="932">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:882px; height:636px; z-index:1; top: 73px; left: 117px;">
        <form name="form1" method="post" action="Insert_banco.php" onSubmit="return revisar()">
          <table width="880" border="0" >
                        <tr>
                  <td width="868"><table width="868" >
                      <tr>
                        <td width="110" height="24"><span class="Estilo5">C&Oacute;DIGO BANCO :</span></td>
                        <td width="70"><span class="Estilo5"><input name="txtcod_banco" type="text" id="txtcod_banco"  size="5" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_codigo(this.form);">  </span></td>
                        <td width="70"><span class="Estilo5">NOMBRE:</span></td>
                        <td width="500"><span class="Estilo5"><input name="txtnombre_banco" type="text"  id="txtnombre_banco" size="94" maxlength="150" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td></tr>
                <tr>
                  <td width="868"><table width="868" >
                      <tr>
                        <td width="110"><span class="Estilo5">TIPO DE CUENTA : </span></td>
                        <td width="50"><span class="Estilo5"> <input name="txttipo_cuenta" type="text" id="txttipo_cuenta"  size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                        <td width="50"><input name="btTipo_Cuenta" type="button" id="bttipo_cuenta" title="Abrir Catalogo Tipos de Cuenta" onclick="VentanaCentrada('Cat_tipo_cuenta.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                        <td width="630"><span class="Estilo5"><input name="txtdes_tipo_cuenta" type="text" id="txtdes_tipo_cuenta"   size="100" maxlength="100" readonly>  </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td></tr>
                <tr>
                  <td width="868"><table width="868" >
                    <tr>
                      <td width="135"><span class="Estilo5">N&Uacute;MERO DE CUENTA :</span></td>
                      <td width="275"><span class="Estilo5"><input name="txtnro_cuenta" type="text" id="txtnro_cuenta"  size="30" maxlength="25" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                      <td width="135"><span class="Estilo5">C&Oacute;DIGO CONTABLE :</span></td>
                      <td width="250"><span class="Estilo5"><input name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta"  size="30" maxlength="32" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                      <td width="50"><input name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo Codigo de Cuentas"  onClick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                    </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td></tr>
                <tr>
                  <td width="868"><table width="868" >
                    <tr>
                      <td width="190"><span class="Estilo5">NOMBRE C&Oacute;DIGO CONTABLE :</span></td>
                      <td width="670"><span class="Estilo5"><input name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta"  size="100" maxlength="99" readonly>   </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td></tr>
                <tr>
                  <td><table width="869">
                      <tr>
                        <td width="168"><span class="Estilo5">DESCRIPCI&Oacute;N DE BANCO :</span></td>
                        <td width="700"><span class="Estilo5"> <textarea name="txtdescripcion_banco" cols="80"  id="txtdescripcion_banco" onFocus="encender(this)" onBlur="apagar(this)"></textarea>   </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                 <td><table width="865" >
                  <tr>
                    <td width="140"><span class="Estilo5">TIPO DE BANCO :</span></td>
                    <td width="720"><span class="Estilo5"><select name="txttipo_bco" id="txttipo_bco">
                        <option>GASTOS CORRIENTES</option> <option>RECAUDACION</option> <option>FONDOS DE TERCEROS</option> <option>FIDEICOMISOS-FIDES</option>
                        <option>FIDEICOMISOS-LAEE</option>  <option>FIEM</option> <option>OTROS FIDEICOMISOS</option>  <option>PENDIENTE POR CANCELAR</option>  <option>OTROS</option>
                      </select> </span></td>
                  </tr>
                 </table></td>
                </tr>
                <tr> <td>&nbsp;</td></tr>
                 <tr>
                 <td><table width="865">
                    <tr>
                      <td width="145"><span class="Estilo5">FORMATO DE CHEQUE :</span></td>
                      <td width="710"><span class="Estilo5"><input name="txtformato_cheque" type="text"  id="txtformato_cheque"  onFocus="encender(this)" onBlur="apagar(this)" size="100" maxlength="120" value="Rpt_formato_chq.php">  </span> </td>
                    </tr>
                 </table></td>
               </tr>
               <tr> <td>&nbsp;</td></tr>
               <tr>
                <td><table width="868">
                  <tr>
                    <td width="140"><span class="Estilo5">GRUPO DE BANCO : </span></td>
                    <td width="59"><span class="Estilo5"><input name="txtgrupo_banco" type="text" id="txtgrupo_banco"  size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                   <td width="50"><input name="btgrupo_banco" type="button" id="btgrupo_banco" title="Abrir Catalogo Grupo de Banco" onclick="VentanaCentrada('Cat_grupo_banco.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                   <td width="618"><span class="Estilo5"><input name="txtnombre_grupob" type="text" id="txtnombre_grupob"   size="90" maxlength="100" readonly>   </span></td>
                 </tr>
                </table></td>
              </tr>
              <tr><td>&nbsp;</td> </tr>
              <tr>
               <td><table width="868">
                 <tr>
                   <td width="110"><span class="Estilo5">TASA I.D.B (%) :</span></td>
                   <td width="255"><span class="Estilo5"><input name="txttasa_idb" type="text" id="txttasa_idb"  size="6" maxlength="5" style="text-align:right" onFocus="encender(this)" onBlur="apaga_monto(this)" value="0" onKeypress="return validarNum(event)">  </span></td>
                   <td width="200"><span class="Estilo5">C&Oacute;DIGO CONTABLE I.D.B (%) : </span></td>
                   <td width="300"><span class="Estilo5"><input name="txtcod_contable_idb" type="text"id="txtcod_contable_idb" size="30" maxlength="32" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                 </tr>
               </table></td>
             </tr>
             <tr><td>&nbsp;</td> </tr>
             <tr> <td><table width="868">
                <tr>
                  <td width="170"><span class="Estilo5">SALDO ANTERIOR LIBRO : </span></td>
                  <td width="230"><span class="Estilo5"><input name="txts_inic_libro" type="text"  id="txts_inic_libro" style="text-align:right" size="20" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="0" onKeypress="return validarNum(event)">  </span></td>
                  <td width="170"><span class="Estilo5">SALDO ANTERIOR BANCO : </span></td>
                  <td width="230"><span class="Estilo5"><input name="txts_inic_banco" type="text" id="txts_inic_banco" style="text-align:right" size="20" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="0" onKeypress="return validarNum(event)">  </span></td>
                </tr>
              </table></td></tr>
			  <tr><td>&nbsp;</td> </tr>
          </table>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table>
                </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
