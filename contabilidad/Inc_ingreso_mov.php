<? include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){  $equipo = getenv("COMPUTERNAME"); 
$mcod_m = "CON02".$equipo; $codigo_mov=substr($mcod_m,0,49);}  else{  $codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD FINANCIERA (Incluir Cuentas en el Comprobante)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" src="../class/sia.js"  type=text/javascript></SCRIPT>
<script language="javascript" src="ajax_comp.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function llamar_anterior(){ document.location ='Det_inc_mov_comp.php?codigo_mov=<?echo $codigo_mov?>'; }
function apaga_referencia(mthis){var mref;
   apagar(mthis); mref=document.form1.txtreferencia.value;  mref=Rellenarizq(mref,"0",8);  document.form1.txtreferencia.value=mref;
return true;}
function apaga_monto(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto.value=mmonto;
 return true;}
function revisar(){var f=document.form1; var Valido=true; 
   if(f.txtcod_presup.value==""){alert("Codigo Presupuestario no puede estar Vacio");return false;}
   if(f.txtreferencia.value==""){alert("Referencia no puede estar Vacio");return false;}
   if(f.txtreferencia.value=="00000000"){alert("Referencia no puede Valida");return false;}
   if(f.txtDes_A.value==""){alert("Descripcion de Asiento no puede estar Vacio"); return false; } else{f.txtDes_A.value=f.txtDes_A.value.toUpperCase();}
   if(f.txtmonto.value==""){alert("Monto no puede estar Vacio");return false;}
   if(MontoValido(f.txtmonto.value)) {Valido=true;}else{alert("monto debe tener valores numericos.");return false;}   
 document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
.Estilo9 { font-size: 16px; font-weight: bold;  color: #FFFFFF;  }
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Insert_ing_mov.php" onSubmit="return revisar()">
  <table width="623" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="620" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#003399"><span class="Estilo9">INCLUIR NUEVO MOVIMIENTO DE INGRESO</span></td>
        </tr>
        <tr>
          <td><table width="614" border="0">
              <tr>
			    <td width="168"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :</span></td>
				<td width="260"><span class="Estilo5"> <input name="txtcod_presup" type="text" id="txtcod_presup" size="30" maxlength="30" onFocus="encender(this); " onBlur="apagar(this);"> </span></td>
                <td width="180"><input name="btCatcuentas" type="button" id="btCatcuentas" title="Abrir Catalogo Codigo de Ingresos"  onclick="VentanaCentrada('Cat_codigo_ing.php?criterio=','SIA','','750','500','true')" value="..."></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="614" border="0">
              <tr>
                <td width="608"><span class="Estilo5">DENOMINACION : <input name="txtdenominacion" type="text" id="txtdenominacion" size="74" maxlength="250" readonly>
                </span></td>
              </tr>
            </table>            </td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="614" border="0">
                <tr>
				  <td width="124"><span class="Estilo5">REFERENCIA : </span></td>
                  <td width="200"><span class="Estilo5"><div id="rmov"><input name="txtreferencia" type="text"  id="txtreferencia"   size="10" maxlength="8" onFocus="encender(this)" onBlur="apaga_referencia(this)"></div> </span></td>
                  <td width="90"><span class="Estilo5">MONTO :</span></td>
                  <td width="300"><span class="Estilo5"><div id="montcod"><input name="txtmonto" type="text" id="txtmonto" size="16" align="right" maxlength="22" onFocus="encender(this)" onBlur="apaga_monto(this)"  onchange="chequea_monto(this.form);">
                  </div></span></td>
                </tr>
            </table></td>
        </tr>
		<script language="JavaScript" type="text/JavaScript">
		   ajaxSenddoc('GET', 'refingaut.php?password='+mpassword+'&user='+muser+'&dbname='+mdbname+'&codigo_mov='+mcodigo_mov, 'rmov', 'innerHTML');                   
        </script>
        <tr>
          <td><table width="614" border="0">
              <tr>
                <td width="100"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                <td width="428"><textarea name="txtDes_A" cols="60" rows="2" class="headers" id="txtDes_A" onFocus="encender(this)" onBlur="apagar(this)"></textarea></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><p>&nbsp;</p></td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="7"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
			<td width="10"><input name="txtcod_contable" type="hidden" id="txtcod_contable" value=""></td>
			
            <td width="100">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>