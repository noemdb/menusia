<?php include ("../class/fun_fechas.php"); include ("../class/ventana.php");
if (!$_GET){$cod_banco='';$tipo_mov='';$referencia=''; $monto_mov=0;}  else{$cod_banco=$_GET["cod_banco"];$tipo_mov=$_GET["tipo_mov"];$referencia=$_GET["referencia"]; $monto_mov=$_GET["monto_mov"];}
$fecha_hoy=asigna_fecha_hoy(); $url="Act_Mov_Libros.php?Gcod_banco=C".$cod_banco.$referencia.$tipo_mov;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Anular Movimientos en Libros)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefecha(mform){var mref; var mfec;
  mref=mform.txtfecha_anu.value;
  if(mform.txtfecha_anu.value.length==8){mfec=mref.substring(0,6)+ "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha_anu.value=mfec;}
return true;}
function apaga_ref_dep(mthis){var mref;
   apagar(mthis); mref=document.form1.txtref_dep.value;    mref=Rellenarizq(mref,"0",8);     document.form1.txtref_dep.value=mref;
return true;}

function apaga_ref_nota(mthis){var mref;
   apagar(mthis); mref=document.form1.txtref_nota.value;    mref=Rellenarizq(mref,"0",8);     document.form1.txtref_nota.value=mref;
return true;}

function apaga_monto(mthis){ var mmonto;  
   apagar(mthis);   mmonto=document.form1.txtmonto_nota.value;  mmonto=camb_punto_coma(mmonto);  document.form1.txtmonto_nota.value=mmonto;
 return true;}
function apaga_bancoA(mthis){
var mref; 
   apagar(mthis);
   mref=document.form1.txtcod_bancoA.value;  mref=Rellenarizq(mref,"0",4);  document.form1.txtcod_bancoA.value=mref; 
return true;}
function revisar(){ var f=document.form1; var r;
var Valido=true;
    if(f.txtfecha_anu.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtdescrip_anu.value==""){alert("Descripcion  no puede estar Vacia"); return false; }  else{f.txtdescrip_anu.value=f.txtdescrip_anu.value.toUpperCase();}
    if(f.txtfecha_anu.value.length==10){Valido=true;}  else{alert("Longitud de Fecha Invalida");return false;}
    if(f.txtref_dep.value==""){alert("Referencia Deposito no puede estar Vacio");return false;}
    
	if(f.txttipo_mov.value=="DEP. OTRO BANCO"){
	  if(f.txtcod_bancoA.value==""){alert("Codigo banco Deposito no puede estar Vacio");return false;}    }
	else{
	if(f.txtref_nota.value==""){alert("Referencia Nota no puede estar Vacio");return false;}
    if(f.txtmonto_nota.value==""){alert("Monto no puede estar Vacio");return false;} }  	
	if(f.txtCodigo_Cuenta.value==""){alert("Codigo de Cuenta no puede estar Vacia"); return false; }  else{f.txtdescrip_anu.value=f.txtdescrip_anu.value.toUpperCase();}
    r=confirm("Esta seguro en Procesar el Movimiento ?");    
	if (r==true) {r=confirm("Esta Realmente seguro en Procesar el Movimiento ?");
    if (r==true) {Valido=true;} else {return false;}  }
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;  font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Rev_dep_nota.php" onSubmit="return revisar()">
  <table width="714" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="707" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MOVIMIENTO MULTIPLES - DEPOSITOS</span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="680" border="0" align="center">
              <tr>
                <td width="140"><span class="Estilo5">FECHA : </span></td>
                <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtfecha_anu" type="text" id="txtfecha_anu" size="12" value="<?php echo $fecha_hoy?>"  onchange="checkrefecha(this.form)" onFocus="encender(this)" onBlur="apagar(this)"> </span> </td>
				<td width="150"><span class="Estilo5">REFERENCIA DEPOSITO : </span></td>
                <td width="130"><span class="Estilo5"><input class="Estilo10" name="txtref_dep" type="text"  id="txtref_dep"   size="10" maxlength="8" onFocus="encender(this)" onBlur="apaga_ref_dep(this)"> </span></td>
              </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td> </tr>
          <tr>
            <td><span class="Estilo5"> </span>
                <table width="680" border="0" align="center">
                  <tr>
                    <td width="110"><span class="Estilo5">CONCEPTO : </span></td>
                    <td width="494"><span class="Estilo5"><textarea name="txtdescrip_anu" cols="65" rows="2" onFocus="encender(this)" onBlur="apagar(this)"  id="txtdescrip_anu"></textarea>   </span></td>
                  </tr>
              </table></td>
          </tr>
		  <tr><td>&nbsp;</td> </tr>
		  <tr>
            <td><table width="680" border="0" align="center">
              <tr>
                <td width="140"><span class="Estilo5">TIPO MOVIMIENTO : </span></td>
				<td width="250"><span class="Estilo5"><select name="txttipo_mov" size="1" id="txttipo_mov" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>NOTA DEBITO</option> <option>NOTA CREDITO</option> <option>DEP. OTRO BANCO</option> </select>  </span></td>              
                <td width="150"><span class="Estilo5">REFERENCIA NOTA : </span></td>
                <td width="130"><span class="Estilo5"><input class="Estilo10" name="txtref_nota" type="text"  id="txtref_nota"   size="10" maxlength="8" onFocus="encender(this)" onBlur="apaga_ref_nota(this)"> </span></td>
              </tr>
            </table></td>
          </tr>
		  <tr>  <td>&nbsp;</td> </tr>
		  <tr>
           <td><table width="680" border="0" align="center">
              <tr>
                <td width="140"><span class="Estilo5">MONTO DE LA NOTA :</span></td>
                <td width="250"><span class="Estilo5"> <input class="Estilo10" name="txtmonto_nota"  align="right"  type="text"  id="txtmonto_nota"  size="17" maxlength="16" onFocus="encender(this)" onBlur="apaga_monto(this)"> </span></td>
				<td width="280"><span class="Estilo5"></span></td>
              </tr>
            </table></td>
          </tr>
          <tr>  <td>&nbsp;</td> </tr>
		  <tr>
			  <td><table width="680" border="0" align="center">
				<tr>
				  <td width="250"><span class="Estilo5">C&Oacute;DIGO CONTABLE DE ANULACION :</span></td>
				  <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta"  size="30" maxlength="32" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
				  <td width="180"><input class="Estilo10" name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo C&oacute;digo de Cuentas"  onClick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
				</tr>
			  </table></td>
		  </tr>
		  <tr> <td>&nbsp;</td></tr>
		  <tr>
			  <td><table width="680" border="0" align="center">
				<tr>
				  <td width="200"><span class="Estilo5">NOMBRE C&Oacute;DIGO CONTABLE :</span></td>
				  <td width="480"><span class="Estilo5"><input class="Estilo10" name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta"  size="70" maxlength="80" readonly> </span></td>
				</tr>
			  </table></td>
		  </tr>
		  <tr> <td>&nbsp;</td></tr>
		  <tr>
                <td><table width="680" border="0" align="center">
                    <tr>
                      <td width="160"><span class="Estilo5">C&Oacute;DIGO BANCO DEPOSITO:</span></td>
                       <td width="60"><span class="Estilo5"> <input class="Estilo10" name="txtcod_bancoA" type="text" id="txtcod_bancoA" size="5" maxlength="4"  onFocus="encender(this)" onBlur="apaga_bancoA(this)" onchange="chequea_bancoA(this.form);">  </span> </td>
                      <td width="60"><input class="Estilo10" name="btcod_bancoA" type="button" id="btcod_bancoA" title="Abrir Catalogo de Bancos" onclick="VentanaCentrada('Cat_bancosA.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                      <td width="140"><span class="Estilo5">N&Uacute;MERO DE CUENTA:</span></td>
                      <td width="160"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtnro_cuentaA" type="text"  id="txtnro_cuentaA"   size="25" maxlength="25" readonly></span></div></td>
                    </tr>
                  </table></td>
          </tr>
		  <tr>
                <td><table width="680" border="0" align="center">
                      <tr>
                        <td width="160"><span class="Estilo5">NOMBRE DEL BANCO : </span></td>
                        <td width="520"><span class="Estilo5">  <input class="Estilo10" name="txtnombre_bancoA" type="text"  id="txtnombre_bancoA"   size="60" maxlength="60" readonly></span></td>
                      </tr>
                  </table></td>
          </tr>	
		  <tr> <td>&nbsp;</td></tr>
          <tr>
          <td><table width="680" border="0" align="center"> <tr>
            <td width="40"><input name="txtcod_banco" type="hidden" id="txtcod_banco" value="<?php echo $cod_banco?>"></td>
            <td width="40"><input name="txttipo_movimiento" type="hidden" id="txttipo_movimiento" value="<?php echo $tipo_mov?>"></td>
            <td width="40"><input name="txtreferencia" type="hidden" id="txtreferencia" value="<?php echo $referencia?>"></td>
			<td width="40"><input name="txtmonto_dep" type="hidden" id="txtmonto_dep" value="<?php echo $monto_mov?>"></td>
          </tr></table></td>
          </tr>
          <tr><td>&nbsp;</td> </tr>
          <tr>
            <td><table width="660" align="center">
              <tr>
                <td width="182">&nbsp;</td>
                <td width="127" align="center" valign="middle"><input name="Procesar" type="submit" id="Procesar"  value="Procesar"></td>
                <td width="10" align="center">&nbsp;</td>
                <td width="136" align="center"><input name="Retornar" type="button" id="Retornar" value="Retornar" onClick="JavaScript:document.location ='<?php  echo $url; ?>';"></td>
                <td width="181">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td> </tr>
        </table>
          </td>
    </tr>
  </table>
</form>
</body>
</html>