<?include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){$cod_presup=""; $cod_fuente="00";$codigo_mov="";$ref_imput_presu="";$ref_comp=""; $tipo_comp="0000";}
 else{ $cod_presup=$_GET["codigo"];$cod_fuente=$_GET["fuente"]; $ref_imput_presu=$_GET["ref_imput"]; $ref_comp=$_GET["ref_comp"]; $tipo_comp=$_GET["tipo_comp"];$codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Modificar Codigos de la Orden)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
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
function llamar_anterior(){document.location ='Det_inc_cod_ord.php?codigo_mov=<?echo $codigo_mov?>&bloqueada=N';}
function llamar_eliminar(codigo_mov,codigo,fuente,ref_imput,ref_comp,tipo_comp){ var murl;var r;
 if (codigo=="") {alert("Codigo debe ser Seleccionado");}
  else { murl="Esta seguro en Eliminar el Codigo:"+codigo+" Fuente:"+fuente+" de la Orden ?";   r=confirm(murl);
  if(r==true){ r=confirm("Esta Realmente seguro en Eliminar el Codigo de la Orden ?");
    if(r==true){murl="Delete_cod_ord.php?codigo_mov="+codigo_mov+"&codigo="+codigo+"&fuente="+fuente+"&ref_imput="+ref_imput+"&ref_comp="+ref_comp+"&tipo_comp="+tipo_comp; document.location=murl;}  }
   else { url="Cancelado, no elimino"; }}
}
function llamar_asociar(codigo_mov,codigo,fuente,ref_imput,ref_comp,tipo_comp){ var murl;var r;
 if (codigo=="") {alert("Codigo debe ser Seleccionado");}
  else {  murl="Asociar_cod_ord.php?codigo_mov="+codigo_mov+"&codigo="+codigo+"&fuente="+fuente+"&ref_imput="+ref_imput+"&ref_comp="+ref_comp+"&tipo_comp="+tipo_comp; document.location=murl;
 }
}
function chequea_monto(mform){
 if(mform.txttipo_imput_presu.value=="CRED. ADICIONAL"){mform.txtmonto_credito.value=mform.txtmonto.value;}
  else{mform.txtmonto_credito.value="0";}
return true;}
function encende_monto(mthis){var mmonto; encender(mthis); 
  mmonto=document.form1.txtmonto.value; mmonto=eliminapunto(mmonto); document.form1.txtmonto.value=mmonto; 
}
function apaga_monto(mthis){var mmonto; apagar(mthis);
 mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto); document.form1.txtmonto.value=mmonto;
 if(document.form1.txttipo_imput_presu.value=="CRED. ADICIONAL"){document.form1.txtmonto_credito.value=mmonto;}
  else{document.form1.txtmonto_credito.value="0";}
}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_presup.value==""){alert("Codigo Presupuestario no puede estar Vacio"); f.txtcod_presup.focus(); return false;}
   if(f.txtcod_fuente.value==""){alert("Codigo de Fuente no puede estar Vacio"); f.txtcod_presup.focus(); return false; }
   if(f.txtcod_contable.value==""){alert("Codigo Contable no puede estar Vacio"); f.txtcod_contable.focus();return false;}
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio"); f.txtmonto.focus();return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;}else{alert("monto debe tener valores numericos."); f.txtmonto.focus(); return false;}
document.form1.submit;
return true;}
</script>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$denominacion="";$des_fuente="";$cod_contable=""; $monto=0;$montoc=0;$montod=0;
$sql="SELECT * FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$cod_fuente' and ref_imput_presu='$ref_imput_presu'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){
  $denominacion=$registro["denominacion"];  $monto=$registro["monto"];     $des_fuente=$registro["des_fuente_financ"];
  $tipo_imput_presu=$registro["tipo_imput_presu"];  $montoc=$registro["monto_credito"];    $cod_contable=$registro["cod_con_g_pagar"];
  if($tipo_imput_presu=="P"){$tipo_imput_presu="PRESUPUESTO";}else{$tipo_imput_presu="CRED. ADICIONAL";}    $montod=$registro["disponible"];
}
$monto=formato_monto($monto); $montoc=formato_monto($montoc);  $montod=formato_monto($montod);
?>
<body>
<form name="form1" method="post" action="Update_cod_ord.php" onSubmit="return revisar()">
  <table width="634" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="630" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="25" align="center" bgcolor="#000066"><span class="Estilo2 Estilo6">MODIFICAR C&Oacute;DIGO DE LA ORDEN</span></td>
        </tr>
        <tr>
          <td><table width="620" border="0">
              <tr>
                <td width="168"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :</span></td>
                <td width="217"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" title="Registre el C&oacute;digo de la Cuenta" value="<? echo $cod_presup ?>"  size="32" maxlength="32" readonly>  </span></td>
                <td width="103">&nbsp;</td>
                <td width="51">&nbsp;</td>
                <td width="59">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="663" border="0">
            <tr>
              <td width="200"><span class="Estilo5">FUENTE DE FINANCIAMIENTO : </span></td>
              <td width="34"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuente" type="text" id="txtcod_fuente" value="<? echo $cod_fuente ?>" size="3" maxlength="2" readonly>  </span></td>
              <td width="10">&nbsp;</td>
              <td width="401"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuente" type="text" id="txtdes_fuente" value="<? echo $des_fuente ?>" size="55" readonly>  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="678" border="0">
              <tr>
                <td width="110"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                <td width="494"><span class="Estilo5"><textarea name="txtdenominacion" cols="65" rows="1" readonly="readonly" id="txtdenominacion" class="Estilo10"><? echo $denominacion ?></textarea>  </span></td>
              </tr>
            </table>  </td>
        </tr>
        <tr>
          <td><table width="681">
            <tr>
              <td width="121"><span class="Estilo5">IMPUTACI&Oacute;N PRESUPUESTARIA:</span></td>
              <td width="184"><span class="Estilo5"><input class="Estilo10" name="txttipo_imput_presu" type="text" id="txttipo_imput_presu"  value="<?echo $tipo_imput_presu?>" size="20" readonly></span></td>
              <td width="244"><span class="Estilo5">REFERENCIA DEL CREDITO ADICIONAL:</span></td>
              <td width="72"><span class="Estilo5"><input class="Estilo10" name="txtref_imput_presu" type="text"  id="txtref_imput_presu" value="<?echo $ref_imput_presu?>" size="12" readonly ></span></td>
              <td width="36"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="677" border="0">
            <tr>
              <td width="124"><span class="Estilo5">DISPONIBLE:</span></td>
              <td width="244"><span class="Estilo5"><input class="Estilo10" name="txtdisponible" type="text" id="txtdisponible" size="25" style="text-align:right" value="<? echo $montod ?>" readonly>  </span></td>
              <td width="124"><span class="Estilo5">MONTO :</span></td>
              <td width="167"><span class="Estilo5"><input class="Estilo10" name="txtmonto" type="text" id="txtmonto" style="text-align:right" onFocus="encende_monto(this)" onBlur="apagar(this)" value="<? echo $monto ?>" size="25" maxlength="22" onKeypress="return validarNum(event,this)" >
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="679">
            <tr>
              <td width="139"><span class="Estilo5">CODIGO CONTABLE : </span></td>
              <td width="160"><span class="Estilo5"><input class="Estilo10" name="txtcod_contable" type="text" id="txtcod_contable" size="30" maxlength="30" value="<? echo $cod_contable?>" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)" >     </span></td>
              <td width="60"><input class="Estilo10" name="btcatcta" type="button" id="btcatcta" title="Abrir Catalogo de Cuentas" onclick="VentanaCentrada('Cat_cuentasc.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></td>
              <td width="132"><span class="Estilo5">MONTO CREDITO : </span></td>
              <td width="168"><span class="Estilo5"><input class="Estilo10" name="txtmonto_credito" type="text" id="txtmonto_credito" size="25" style="text-align:right" maxlength="22"  value="<? echo $montoc ?>" readonly onkeypress="return stabular(event,this)">  </span></td>
            </tr>
          </table>  </td>
        </tr>
        <tr>
          <td><p>&nbsp;</p>
        </tr>
      </table>
        <table width="629" align="center">
          <tr>
            <td width="7"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="5"><input class="Estilo10" name="txtref_comp" type="hidden" id="txtref_comp" value="<?echo $ref_comp?>"></td>
            <td width="5"><input class="Estilo10" name="txttipo_comp" type="hidden" id="txttipo_comp" value="<?echo $tipo_comp?>"></td>
            <td width="100">&nbsp;</td>
            <td width="90" align="center" valign="middle"><input class="Estilo10" name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>			
            <td width="110" align="center"><input class="Estilo10" name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="100" align="center"><input class="Estilo10" name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar('<? echo $codigo_mov; ?>','<? echo $cod_presup; ?>','<? echo $cod_fuente; ?>','<? echo $ref_imput_presu; ?>','<? echo $ref_comp; ?>','<? echo $tipo_comp; ?>')"></td>
            <td width="100" align="center"><input class="Estilo10" name="Asociar" type="button" id="Asociar" value="Asociar" onClick="JavaScript:llamar_asociar('<? echo $codigo_mov; ?>','<? echo $cod_presup; ?>','<? echo $cod_fuente; ?>','<? echo $ref_imput_presu; ?>','<? echo $ref_comp; ?>','<? echo $tipo_comp; ?>')"></td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>
<? pg_close(); ?>
<script language="JavaScript" type="text/JavaScript">
var f=document.form1; f.txtmonto.focus();
</script>