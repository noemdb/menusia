<?include ("../class/ventana.php"); $equipo=getenv("COMPUTERNAME");  $mcod_m="BIEN054".$usuario_sia.$equipo; 
if (!$_GET){$codigo_mov=substr($mcod_m,0,49);}else{$codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Incluir Bienes Muebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<SCRIPT language="JavaScript" src="../class/sia.js" type="text/javascript"></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_inc_trans_comp_bienes.php?codigo_mov=<?echo $codigo_mov?>'; }

function llamar_cat_componenetes(){ var f=document.form1; var mcod_bien=f.txtcod_bien_mue.value; var url;
  url='Cat_componentes_bienes_muebles?criterio=&cod_bien_mue='+mcod_bien;
  VentanaCentrada(url,'SIA','','750','500','true')
}

function apaga_comp(mthis){var mref;
 apagar(mthis); mref=mthis.value; document.form1.txtcod_componente_r.value=mref;
}


function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_bien_mue.value==""){alert("Codigo del Bien no puede estar Vacio");return false;}
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;} else{alert("monto debe tener valores numéricos.");return false;}
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
<form name="form1" method="post" action="Insert_comp_trans.php" onSubmit="return revisar()">
  <table width="640" height="80" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="635" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR BIEN A LA TRANSFERENCIA</span></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
          <tr>
            <td><table width="630">
              <tr>
                <td width="200"><span class="Estilo5">C&Oacute;DIGO BIEN MUEBLE EMISOR :</span></td>
                <td width="430"><span class="Estilo5"><input name="txtcod_bien_mue" type="text" id="txtcod_bien_mue" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <input name="btcod_bien" type="button" id="btcod_bien" title="Abrir Catalogo de Bienes Inmuebles" onClick="VentanaCentrada('Cat_bienes_muebles_desin.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
              </tr>
            </table></td>
          </tr>
		  <tr>
            <td>
              <table width="630" border="0">
                <tr>
                  <td width="130"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                  <td width="500"><span class="Estilo5"><textarea name="txtdenominacion" cols="58" rows="2" readonly="readonly" id="txtdenominacion"></textarea>
                  </span></td>
                </tr>
              </table>  </td>
          </tr>
			<tr>
			  <td>
				  <table width="630" border="0">
					<tr>
					  <td width="100"><span class="Estilo5">COMPONENTE :</span></td>
					  <td width="130"><span class="Estilo5"><input name="txtcod_componente" type="text" id="txtcod_componente" size="6" maxlength="5"  onFocus="encender(this)" onBlur="apaga_comp(this)" class="Estilo5">
						 <input name="btcod_bien" type="button" id="btcod_bien" title="Abrir Catalogo de Bienes Inmuebles" onClick="JavaScript:llamar_cat_componenetes()" value="..."></span></td>
					  <td width="400"><span class="Estilo5"><input name="txtdes_componente" type="text" id="txtdes_componente" size="90"  maxlength="100" readonly class="Estilo5"></span></td>
					</tr>
				</table></td>
			</tr>
			<tr>
			  <td>
				  <table width="630" border="0">
					<tr>
					  <td width="70"><span class="Estilo5">MARCA :</span></td>
					  <td width="133"><span class="Estilo5"><input name="txtmarca" type="text" id="txtmarca" size="22"  maxlength="30" readonly class="Estilo5">  </span></td>
					  <td width="75"><span class="Estilo5">MODELO :</span></td>
					  <td width="135"><span class="Estilo5"><input name="txtmodelo" type="text" id="txtmodelo" size="22"  maxlength="30" readonly class="Estilo5">  </span></td>
					  <td width="72"><span class="Estilo5">SERIAL :</span></td>
					  <td width="143"><span class="Estilo5"><input name="txtserial" type="text" id="txtserial" size="25"  maxlength="30" readonly class="Estilo5">  </span></td>
					</tr>
				</table></td>
			</tr>
			<tr>
            <td><table width="630">
              <tr>
                <td width="170"><span class="Estilo5">C&Oacute;DIGO BIEN RECEPTOR :</span></td>
                <td width="230"><span class="Estilo5"><input name="txtcod_bien_r" type="text" id="txtcod_bien_r" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <input name="btcod_bien" type="button" id="btcod_bien" title="Abrir Catalogo de Bienes Inmuebles" onClick="VentanaCentrada('Cat_bienes_muebles_r.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
                <td width="100"><span class="Estilo5">COMPONENTE :</span></td>
					  <td width="130"><span class="Estilo5"><input name="txtcod_componente_r" type="text" id="txtcod_componente_r" size="6" maxlength="5"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5"></span></td>
			   </tr>
            </table></td>
          </tr>
        <tr>
          <td><p>&nbsp;</p></td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="12"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
			<td width="5"><input name="txtmonto" type="hidden" id="txtmonto" value="0"></td>
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
