<?php include ("../class/ventana.php"); $equipo=getenv("COMPUTERNAME"); $grupo="01";
if (!$_GET){$mcod_m="INGRE007".$equipo;$codigo_mov=substr($mcod_m,0,49);}else{$codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Incluir C�digos en el Traspaso)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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
function llamar_anterior(){ document.location ='Det_inc_traspasos.php?codigo_mov=<?php echo $codigo_mov?>'; }
function apaga_monto(mthis){var mmonto;
 apagar(mthis); mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto.value=mmonto;} 
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_presup.value==""){alert("Codigo Presupuestario no puede estar Vacio"); f.txtcod_presup.focus(); return false;}
   if(f.txtcod_fuente.value==""){alert("Codigo de Fuente no puede estar Vacio"); f.txtcod_fuente.focus(); return false; }
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio"); f.txtmonto.focus(); return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;}else{alert("monto debe tener valores numericos.");return false;}
document.form1.submit;
return true;}
</script>
</head>
<body>
<form name="form1" method="post" action="Insert_cod_tras.php" onSubmit="return revisar()">
  <table width="654" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="651" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo2 Estilo6">INCLUIR NUEVO C&Oacute;DIGO EN EL TRASPASO</span></td>
        </tr>
        <tr>
          <td><table width="640" border="0">
              <tr>
                <td width="70"><span class="Estilo5">GRUPO :</span></td>
                <td width="130"><span class="Estilo5"><input class="Estilo10" name="txtgrupo" type="text" id="txtgrupo" size="4" maxlength="2" onFocus="encender(this); " onBlur="apagar(this);" value="<?php echo $grupo?>" onkeypress="return stabular(event,this)">  </span></td>
                <td width="200"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :</span></td>
                <td width="180"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" title="Registre el C&oacute;digo del TRaspaso"  size="34" maxlength="34" onFocus="encender(this); " onBlur="apagar(this);" onKeypress="return stabular(event,this)"> </span></td>
                <td width="60"><input class="Estilo10" name="btCodPre" type="button" id="btCodPre" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onclick="VentanaCentrada('Cat_codigos_presup_comp.php?criterio=','SIPAP','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="639" border="0">
            <tr>
              <td width="206"><span class="Estilo5">FUENTE DE FINANCIAMIENTO : </span></td>
              <td width="36"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuente" type="text" id="txtcod_fuente" size="3" maxlength="2" onFocus="encender(this); " onBlur="apagar(this);" onkeypress="return stabular(event,this)">    </span></td>
              <td width="28"><input class="Estilo10" name="btfuente" type="button" id="btfuente" title="Abrir Catalogo Fuentes de Financiamiento" onclick="VentanaCentrada('Cat_fuentes.php?criterio=','SIPAP','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></td> 
			  <td width="351"><input class="Estilo10" name="txtdes_fuente" type="text" id="txtdes_fuente" size="50" readonly onkeypress="return stabular(event,this)"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="621" border="0">
              <tr>
                <td width="110"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                <td width="494"><span class="Estilo5"><textarea name="txtdenominacion" class="Estilo10" cols="58" rows="2" readonly="readonly" id="txtdenominacion" onkeypress="return stabular(event,this)"></textarea>
                </span></td>
              </tr>
            </table>            </td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="628" border="0">
                <tr>
                  <td width="110"><span class="Estilo5">DISPONIBLE:</span></td>
                  <td width="233"><span class="Estilo5"><input class="Estilo10" name="txtdisponible" type="text" id="txtdisponible" size="25" style="text-align:right" readonly onkeypress="return stabular(event,this)">  </span></td>
                  <td width="91"><span class="Estilo5">OPERACI&Oacute;N :</span></td>
                  <td width="168"><span class="Estilo5"><select name="txtoperacion" size="1" id="select" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_tipo(this.form)" onkeypress="return stabular(event,this)">
                      <option>+</option> <option>-</option> </select></span></td>
                </tr>
            </table></td>
        </tr>
        <tr>
          <td><table width="631">
            <tr>
              <td width="110"><span class="Estilo5">MONTO : </span></td>
              <td width="195"><span class="Estilo5"><input class="Estilo10" name="txtmonto" type="text" id="txtmonto" size="25" style="text-align:right" maxlength="22" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" onKeypress="return validarNum(event,this)">   </span></td>
              <td width="152">&nbsp;</td>
              <td width="155">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><p>&nbsp;</p></td>
        </tr>
      </table>
        <table width="594" align="center">
          <tr>
            <td width="18"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
            <td width="52"><input name="txtcod_contable" type="hidden" id="txtcod_contable"></td>
            <td width="69"><input name="txtdes_contable" type="hidden" id="txtdes_contable2"></td>
            <td width="95" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="110" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="91" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="127">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>