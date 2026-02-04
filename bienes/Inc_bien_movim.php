<?php include ("../class/ventana.php"); $equipo=getenv("COMPUTERNAME");  $mcod_m="BIEN025".$usuario_sia.$equipo; 
if (!$_GET){$codigo_mov=substr($mcod_m,0,49);}else{$codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Incluir Bienes Muebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function llamar_anterior(){ document.location ='Det_inc_bienes_mue_movimientos.php?codigo_mov=<?php echo $codigo_mov?>'; }
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_bien_mue.value==""){alert("Codigo del bien no puede estar Vacio");return false;}
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;} else{alert("monto debe tener valores num�ricos.");return false;}
   if(f.txtcodigo.value==""){alert("Tipo de Movimiento no puede estar Vacio");return false;}
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
<form name="form1" method="post" action="Insert_bienes_movim.php" onSubmit="return revisar()">
  <table width="640" height="80" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="635" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR BIEN DEL MOVIMIENTO</span></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
          <tr>
            <td><table width="630">
              <tr>
                <td width="230"><span class="Estilo5">C&Oacute;DIGO DEL BIEN MUEBLES :</span></td>
                <td width="400"><span class="Estilo5"><input name="txtcod_bien_mue" type="text" id="txtcod_bien_mue" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">
                     <input class="Estilo10" name="btcod_bien" type="button" id="btcod_bien" title="Abrir Catalogo de Bienes Inmuebles" onClick="VentanaCentrada('Cat_bienes_muebles_desin.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
              </tr>
            </table></td>
          </tr>
		  <tr>
            <td>
              <table width="630" border="0">
                <tr>
                  <td width="130"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                  <td width="500"><span class="Estilo5"><textarea name="txtdenominacion" cols="58" rows="2" readonly="readonly" class="Estilo10" id="txtdenominacion"></textarea>
                  </span></td>
                </tr>
              </table>  </td>
          </tr>          
          <tr>
            <td>
              <table width="630" border="0">
                <tr>
                  <td width="130"><span class="Estilo5">MONTO :</span></td>
                  <td width="500"><span class="Estilo5"><input class="Estilo10" name="txtmonto" type="text" id="txtmonto" size="25" style="text-align:right" maxlength="22" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)" ">
                  </span></td>
                </tr>
            </table></td>
          </tr>
		  
		  <tr>
            <td><table width="630">
              <tr>
                <td width="180"><span class="Estilo5">TIPO DE MOVIMIENTO:</span></td>
                <td width="450"><span class="Estilo5"><input class="Estilo10" name="txtcodigo" type="text" id="txtcodigo" size="5" maxlength="3"  onFocus="encender(this)" onBlur="apagar(this)">
                    <input class="Estilo10" name="bttipomov" type="button" id="bttipomov" title="Abrir Catalogo Tipos de Movimiento" onClick="VentanaCentrada('Cat_movim_bienes_mueblesd.php?criterio=','SIPAP','','750','500','true')" value="...">    </div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="630">
              <tr>
                <td width="180"><span class="Estilo5">DESCRIPCION MOVIMIENTO:</span></td>
                <td width="450"><span class="Estilo5"><input class="Estilo10" name="txtdenomina_tipo" type="text" id="txtdenomina_tipo" size="80" maxlength="100"  readonly ></span></td>
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
