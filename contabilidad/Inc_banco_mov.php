<? if (!$_GET){  $equipo = getenv("COMPUTERNAME"); $mcod_m = "CON02".$equipo; $codigo_mov=substr($mcod_m,0,49);}  else{  $codigo_mov=$_GET["codigo_mov"];}
include ("../class/conect.php");  include ("../class/funciones.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD FINANCIERA (Incluir Cuentas en el Comprobante)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" src="../class/sia.js"  type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_inc_mov_comp.php?codigo_mov=<?echo $codigo_mov?>'; }
function chequea_banco(mform){
var mref; var mcedrif;
   mref=mform.txtcod_banco.value;  mref=Rellenarizq(mref,"0",4);  mform.txtcod_banco.value=mref; 
 return true;}
function apaga_referencia(mthis){
var mref;
   apagar(mthis); mref=document.form1.txtreferencia.value;  mref=Rellenarizq(mref,"0",8);  document.form1.txtreferencia.value=mref;
return true;}
function apaga_monto(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto.value=mmonto;
 return true;}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_banco.value==""){alert("Código de Banco no puede estar Vacio");return false;}
    if(f.txtreferencia.value==""){alert("Referencia no puede estar Vacio");return false;}
    if(f.txtnombre_banco.value==""){alert("Nombre de Banco no puede estar Vacio");return false;} else{f.txtnombre_banco.value=f.txtnombre_banco.value.toUpperCase();}
    if(f.txtcod_banco.value.length==4){f.txtcod_banco.value=f.txtcod_banco.value.toUpperCase();} else{alert("Longitud Código de Banco Invalida");return false;}
    if((f.txttipo_movimiento.value=="")||(f.txttipo_movimiento.value=="TRC")||(f.txttipo_movimiento.value=="TRD")||(f.txttipo_movimiento.value=="CHQ")||(f.txttipo_movimiento.value=="ANU")||(f.txttipo_movimiento.value=="ANC")||(f.txttipo_movimiento.value=="AND")){alert("Tipo de Movimiento Inavlido");return false;} else{f.txttipo_movimiento.value=f.txttipo_movimiento.value.toUpperCase();}
    if(f.txtDes_A.value==""){alert("Descripcion de Asiento no puede estar Vacio"); return false; } else{f.txtDes_A.value=f.txtDes_A.value.toUpperCase();}
   if((f.txttipo_movimiento.value=="")||(f.txttipo_movimiento.value=="TRC")||(f.txttipo_movimiento.value=="TRD")||(f.txttipo_movimiento.value=="CHQ")||(f.txttipo_movimiento.value=="ANU")||(f.txttipo_movimiento.value=="ANC")||(f.txttipo_movimiento.value=="AND")){alert("Tipo de Movimiento Inavlido");return false;} else{f.txttipo_movimiento.value=f.txttipo_movimiento.value.toUpperCase();}
   if(f.txtreferencia.value=="00000000"){alert("Referencia no  Valida");return false;} 
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
<form name="form1" method="post" action="Insert_banco_mov.php" onSubmit="return revisar()">
  <table width="623" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="620" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#003399"><span class="Estilo9">INCLUIR NUEVO MOVIMIENTO DE BANCO</span></td>
        </tr>
        <tr>
          <td><table width="614" border="0">
              <tr>
			    <td width="130"><span class="Estilo5">CODIGO DE BANCO:</span></td>
                <td width="70"><span class="Estilo5"> <input name="txtcod_banco" type="text" id="txtcod_banco" size="5" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_banco(this.form);">  </span> </td>
                <td width="100"><input name="btcod_banco" type="button" id="btcod_banco" title="Abrir Catalogo de Bancos" onclick="VentanaCentrada('../bancos/Cat_bancos.php?criterio=','SIA','','750','500','true')" value="..."></td>
                <td width="124"><span class="Estilo5">NUMERO CUENTA:</span></td>
                <td width="190"><div align="left"><span class="Estilo5"><input name="txtnro_cuenta" type="text"  id="txtnro_cuenta"   size="25" maxlength="25" readonly></span></div></td>
		      </tr>
          </table></td>
        </tr>		
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="614" border="0">
              <tr>
                <td width="608"><span class="Estilo5">NOMBRE BANCO : <input name="txtnombre_banco" type="text" id="txtnombre_banco" size="74" maxlength="250" readonly>   </span></td>
              </tr>
            </table>            </td>
        </tr>
		<tr>
          <td><table width="614" border="0">
              <tr>
			    <td width="100"><span class="Estilo5">REFERENCIA  : </span></td>
                <td width="100"><span class="Estilo5"><input name="txtreferencia" type="text"  id="txtreferencia"   size="10" maxlength="8" onFocus="encender(this)" onBlur="apaga_referencia(this)"> </span></td>
                <td width="50"><span class="Estilo5">TIPO :</span></td>
                <td width="60"><span class="Estilo5"><input name="txttipo_movimiento" type="text" id="txttipo_movimiento"   size="4" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                 <td width="55"><input name="bttipo_mov" type="button" id="bttipo_mov" title="Abrir Catalogo Tipos de Movimiento" onclick="VentanaCentrada('../bancos/Cat_tipo_mov_inc.php?criterio=','SIA','','750','500','true')" value="..."></td>
			    <td width="250"><span class="Estilo5">MONTO :
                        <input name="txtmonto" type="text" id="txtmonto" size="25" align="right" maxlength="22" onFocus="encender(this)" onBlur="apaga_monto(this)">
                  </span></td>
              </tr>
          </table></td>
        </tr>       
        <tr>
          <td><table width="614" border="0">
              <tr>
                <td width="100"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                <td width="420"><textarea name="txtDes_A" cols="60" rows="2" class="headers" id="txtDes_A" onFocus="encender(this)" onBlur="apagar(this)"></textarea></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><p>&nbsp;</p></td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
			
			
            <td width="100">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="17"><input name="txtdes_tipo_mov" type="hidden" id="txtdes_tipo_mov" value=""></td>			
			<td width="100">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>