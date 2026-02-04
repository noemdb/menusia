<?php include ("../class/ventana.php"); $equipo=getenv("COMPUTERNAME");  $mcod_m="BIEN045".$usuario_sia.$equipo; 
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
function llamar_anterior(){ document.location ='Det_inc_bienes_desin.php?codigo_mov=<?php echo $codigo_mov?>'; }
function revisar(){
var f=document.form1;
var Valido=true;
   if(f.txtcod_bien_mue.value==""){alert("Codigo del Bien no puede estar Vacio");return false;}
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;} else{alert("monto debe tener valores num�ricos.");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;  font-weight: bold; color: #FFFFFF;  }
.Estilo10 {font-size: 10px}
-->
</style>
</head>
<body>
<form name="form1" method="post" action="Insert_bienes_desin.php" onSubmit="return revisar()">
  <table width="640" height="80" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="635" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR BIEN A LA DESINCORPORACION</span></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
          <tr>
            <td><table width="630">
              <tr>
                <td width="230"><span class="Estilo5">C&Oacute;DIGO DEL BIEN MUEBLES :</span></td>
                <td width="400"><span class="Estilo5"><input name="txtcod_bien_mue" type="text" id="txtcod_bien_mue" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <input name="btcod_bien" type="button" id="btcod_bien" title="Abrir Catalogo de Bienes Inmuebles" onClick="VentanaCentrada('Cat_bienes_muebles_desin.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
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
                  <td width="130"><span class="Estilo5">MONTO :</span></td>
                  <td width="500"><span class="Estilo5"><input name="txtmonto" type="text" id="txtmonto" size="25" align="right" maxlength="22" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
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
