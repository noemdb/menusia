<?include ("../class/seguridad.inc");include ("../class/ventana.php"); include ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy(); $fecha=$fecha_hoy; $descripcion="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Movimientos en Transito Bancos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_ban.js" type="text/javascript"></script>
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
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 

function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function apaga_banco(mthis){var mref;
   apagar(mthis);
   mref=document.form1.txtcod_banco.value;  mref=Rellenarizq(mref,"0",4);  document.form1.txtcod_banco.value=mref;
return true;}
function chequea_banco(mform){var mref;
   mref=mform.txtcod_banco.value;  mref=Rellenarizq(mref,"0",4);  mform.txtcod_banco.value=mref;
 return true;}
function apaga_referencia(mthis){var mref;
   apagar(mthis); mref=document.form1.txtreferencia.value;  mref=Rellenarizq(mref,"0",8);  document.form1.txtreferencia.value=mref;
return true;}
function apaga_monto(mthis){var mref; var mmonto;
  apagar(mthis);   mmonto=document.form1.txtmonto_mov_banco.value;  mmonto=camb_punto_coma(mmonto);   document.form1.txtmonto_mov_banco.value=mmonto;
return true;}
function revisar(){var f=document.form1;
    if(f.txtcod_banco.value==""){alert("Código de Banco no puede estar Vacio");return false;}
    if(f.txtreferencia.value==""){alert("Referencia no puede estar Vacio");return false;}
    if(f.txtnombre_banco.value==""){alert("Nombre de Banco no puede estar Vacio");return false;} else{f.txtnombre_banco.value=f.txtnombre_banco.value.toUpperCase();}
    if(f.txtcod_banco.value.length==4){f.txtcod_banco.value=f.txtcod_banco.value.toUpperCase();} else{alert("Longitud Código de Banco Invalida");return false;}
    if(f.txttipo_movimiento.value==""){alert("Tipo de Movimiento Inavlido");return false;} else{f.txttipo_movimiento.value=f.txttipo_movimiento.value.toUpperCase();}
    if(f.txtmonto_mov_banco.value==""){alert("Monto no puede estar Vacio");return false;}
    if(f.txtdescripcion.value==""){alert("Descripcion no puede estar Vacio");return false;}else{f.txtdescripcion.value=f.txtdescripcion.value.toUpperCase();}
document.form1.submit;
return true;}
</script>

</head>


<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR MOVIMIENTO EN TRANSITO BANCOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="383" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="377"><table width="92" height="376" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Mov_Trans_Banco.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_Mov_Trans_Banco.php">Atras</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>      <div id="Layer1" style="position:absolute; width:870px; height:305px; z-index:1; top: 70px; left: 115px;">
        <form name="form1" method="post" action="Insert_trans_banco.php" onSubmit="return revisar()">
          <table width="868" border="0" >
                <tr>
                  <td width="867"><table width="863" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="127"><span class="Estilo5">C&Oacute;DIGO BANCO:</span></td>
                      <td width="72"><span class="Estilo5"> <input class="Estilo10" name="txtcod_banco" type="text" id="txtcod_banco" size="5" maxlength="4"  onFocus="encender(this)" onBlur="apaga_banco(this)" onchange="chequea_banco(this.form);" onkeypress="return stabular(event,this)">  </span> </td>
                      <td width="91"><input class="Estilo10" name="btcod_banco" type="button" id="btcod_banco" title="Abrir Catalogo de Bancos" onclick="VentanaCentrada('Cat_bancos.php?criterio=','SIA','','750','500','true')" value="..."></td>
                      <td width="144"><span class="Estilo5">N&Uacute;MERO DE CUENTA:</span></td>
                      <td width="419"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtnro_cuenta" type="text"  id="txtnro_cuenta"   size="55" maxlength="55" readonly onkeypress="return stabular(event,this)"></span></div></td>

                    </tr>
                  </table></td>
                </tr>
                <tr>  <td>&nbsp;</td> </tr>
                <tr>
                  <td><table width="863" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="126"><span class="Estilo5">NOMBRE DEL BANCO  : </span></td>
                        <td width="617"><span class="Estilo5">  <input class="Estilo10" name="txtnombre_banco" type="text"  id="txtnombre_banco"   size="100" maxlength="100" readonly onkeypress="return stabular(event,this)"></span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>  <td>&nbsp;</td> </tr>
                <tr>
                  <td><table width="864">
                    <tr>
                        <td width="100"><span class="Estilo5"><div id="rmov">REFERENCIA  : </div> </span></td>
                        <td width="115"><span class="Estilo5"><input class="Estilo10" name="txtreferencia" type="text"  id="txtreferencia"   size="10" maxlength="8" onFocus="encender(this)" onBlur="apaga_referencia(this)" onkeypress="return stabular(event,this)"> </span></td>
                        <td width="125"><span class="Estilo5">TIPO MOVIMIENTO :</span></td>
                        <td width="60"><span class="Estilo5"><input class="Estilo10" name="txttipo_movimiento" type="text" id="txttipo_movimiento"   size="4" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)"></span></td>
                        <td width="45"><input class="Estilo10" name="bttipo_mov" type="button" id="bttipo_mov" title="Abrir Catalogo Tipos de Movimiento" onclick="VentanaCentrada('Cat_tipo_mov_inc.php?criterio=','SIA','','750','500','true')" value="..."></td>
                        <td width="410"><span class="Estilo5"><input class="Estilo10" name="txtdes_tipo_mov" type="text" id="txtdes_tipo_mov"   size="57" maxlength="57" readonly onkeypress="return stabular(event,this)"> </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>  <td>&nbsp;</td> </tr>
                <tr>
                <td><table width="854" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="100"><span class="Estilo5">BENEFICIARIO : </span></td>
                    <td width="750"><span class="Estilo5"> <input class="Estilo10" name="txtbeneficiario" type="text" id="txtbeneficiario"  size="110" maxlength="110" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)"> </span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>  <td>&nbsp;</td> </tr>
          <tr>
            <td ><table width="864" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="100"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                <td width="750"><span class="Estilo5"> <textarea name="txtdescripcion" cols="90" class="Estilo10" onFocus="encender(this)" onBlur="apagar(this)" id="txtdescripcion" onkeypress="return stabular(event,this)"><?echo $descripcion?></textarea> </span> </td>
              </tr>
            </table></td>
          </tr>
                  <tr>  <td>&nbsp;</td> </tr>
          <tr>
            <td><table width="864" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="100"><span class="Estilo5">FECHA :</span></td>
                <td width="390"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text"  id="txtfecha"  value="<?echo $fecha?>" size="12" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return stabular(event,this)"></span></td>
                <td width="69"><span class="Estilo5">MONTO :</span></td>
                <td width="300"><span class="Estilo5"> <input class="Estilo10" name="txtmonto_mov_banco"  type="text"  id="txtmonto_mov_banco"  size="17" maxlength="16" style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" onKeypress="return validarNum(event,this)"> </span></td>
              </tr>
            </table></td>
          </tr>
                  <tr>  <td>&nbsp;</td> </tr>
        </table>
        <table width="812">
          <tr>
            <td width="50"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
            <td width="50"><input name="txtcod_bancoA" type="hidden" id="txtcod_bancoA" value="0000"></td>
            <td width="50"><input name="txtreferenciaA" type="hidden" id="txtreferenciaA" value="00000000"></td>
            <td width="100"><input name="txtbenef_mov_banco" type="hidden" id="txtbenef_mov_banco" value=""></td>
            <td width="414">&nbsp;</td>
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