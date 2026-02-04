<?php include ("../class/ventana.php"); $equipo=getenv("COMPUTERNAME");  $mcod_m="BIEN027".$equipo; 
if (!$_GET){$codigo_mov=substr($mcod_m,0,49);}else{$codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Incluir Bienes Muebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function llamar_anterior(){ document.location ='Det_inc_bienes_mue_depreciacion.php?codigo_mov=<?php echo $codigo_mov?>'; }
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_bien_mue.value==""){alert("Codigo del bien no puede estar Vacio");return false;}
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;} else{alert("monto debe tener valores numericos.");return false;}   
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;  font-weight: bold; color: #FFFFFF;  }
-->
</style>
</head>
<body>
<form name="form1" method="post" action="Insert_bienes_mue_depreciacion.php" onSubmit="return revisar()">
  <table width="790" height="80" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="785" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR BIEN MUEBLE A DEPRECIAR</span></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
          <tr>
            <td><table width="780">
              <tr>
                <td width="200"><span class="Estilo5">C&Oacute;DIGO DEL BIEN MUEBLES :</span></td>
                <td width="250"><span class="Estilo5"><input name="txtcod_bien_mue" type="text" id="txtcod_bien_mue" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5"></span></td>
                <td width="330"><span class="Estilo5"><input name="btcod_bien" type="button" id="btcod_bien" title="Abrir Catalogo de Bienes Muebles" onClick="VentanaCentrada('Cat_bienes_muebles_depreciados.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
              </tr>
            </table></td>
          </tr>
		  <tr>
            <td>
              <table width="780" border="0">
                <tr>
                  <td width="130"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                  <td width="650"><span class="Estilo5"><textarea name="txtdenominacion" cols="58" rows="2" readonly="readonly" id="txtdenominacion" class="Estilo10" ></textarea>
                  </span></td>
                </tr>
              </table>  </td>
          </tr> 
          <tr>
            <td><table width="780">
              <tr>
                <td width="130"><span class="Estilo5">VIDA &Uacute;TIL EN A&Ntilde;OS :</span></td>
                <td width="110"><span class="Estilo5"><input name="txtvida_util" type="text" id="txtvida_util" size="10"   style="text-align:right" readonly class="Estilo5"></span></td>
                <td width="110"><span class="Estilo5">VALOR RESIDUAL :</span></td>
                <td width="110"><span class="Estilo5"><input name="txtvalor_residual" type="text" id="txtvalor_residual" size="10"  style="text-align:right" readonly class="Estilo5"></span></td>
				<td width="150"><span class="Estilo5">VALOR INCORPORACION :</span></td>
				<td width="140"><span class="Estilo5"><input name="txtmonto_in" type="text" id="txtmonto_in" size="20"   style="text-align:right" readonly class="Estilo5"></span></td>
                
              </tr>
            </table></td>
          </tr>	
          <tr>
            <td><table width="780">
              <tr>
                <td width="200"><span class="Estilo5">COD. PRESUP. DEPRECIACI&Oacute;N :</span></td>
                <td width="290"><span class="Estilo5"> <input name="txtcod_presup_dep" type="text" id="txtcod_presup_dep" size="40" maxlength="32"  readonly class="Estilo5"></span></td>
                <td width="150"><span class="Estilo5">SALDO DEPRECIADO :</span></td>
                <td width="140"><span class="Estilo5"> <input name="txtmonto_depreciado" type="text" id="txtmonto_depreciado" size="20" maxlength="15" style="text-align:right" readonly class="Estilo5"></span></td>
              </tr>
            </table></td>
          </tr>	
          <tr>
            <td><table width="780">
              <tr>
                <td width="190"><span class="Estilo5">COD. CONTAB ASOCIADO :</span></td>
                <td width="200"><span class="Estilo5"><input name="txtcod_contablea" type="text" id="txtcod_contablea" size="30" maxlength="25"  readonly class="Estilo5"></span></td>
                <td width="190"><span class="Estilo5">COD. CONTAB DEPRECIACI&Oacute;N :</span></td>
                <td width="200"><span class="Estilo5"><input name="txtcod_contabled" type="text" id="txtcod_contabled" size="30" maxlength="25"  readonly class="Estilo5"></span></td>
              </tr>
            </table></td>
          </tr>		  
          <tr>
            <td>
              <table width="780" border="0">
                <tr>
                  <td width="180"><span class="Estilo5">MONTO DEPRECIACION :</span></td>
                  <td width="600"><span class="Estilo5"><input name="txtmonto" type="text" id="txtmonto" size="25" style="text-align:right" maxlength="22" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" class="Estilo5">
                  </span></td>
                </tr>
            </table></td>
          </tr>
          
        <tr>
          <td><p>&nbsp;</p></td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
            <td width="100">&nbsp;</td>
            <td width="90" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="110" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="96" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>
