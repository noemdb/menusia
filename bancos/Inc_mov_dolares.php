<?include ("../class/ventana.php"); include ("../class/fun_fechas.php"); $codigo_mov=$_POST["txtcodigo_mov"];  $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"];  $ced_rif=$_POST["txtced_r"]; $nombre_benef=$_POST["txtnomb"]; $tasa_cambio=$_POST["txttasa_c"]; $fecha_hoy=asigna_fecha_hoy(); 
$fecha_fin=formato_ddmmaaaa($_POST["txtfecha_fin"]); if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;} $fecha=$fecha_hoy;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Movimientos Cuentas en Dolares)</title>
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
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function quitacomas (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == ',')){str2 = str2 + ".";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9')) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;
}
function apaga_banco(mthis){var mref; var mcedrif;
   apagar(mthis);
   mref=document.form1.txtcod_banco.value;  mref=Rellenarizq(mref,"0",4);  document.form1.txtcod_banco.value=mref; mcedrif=document.form1.txtced_rif.value;
return true;}
function chequea_banco(mform){var mref; var mcedrif;
   mref=mform.txtcod_banco.value;  mref=Rellenarizq(mref,"0",4);  mform.txtcod_banco.value=mref; mcedrif=document.form1.txtced_rif.value;
  return true;}
function apaga_referencia(mthis){var mref;
   apagar(mthis); mref=document.form1.txtreferencia.value;  mref=Rellenarizq(mref,"0",8);  document.form1.txtreferencia.value=mref;
return true;}
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function apaga_monto(mthis){var mmonto;  
   apagar(mthis);   mmonto=mthis.value;  mmonto=camb_punto_coma(mmonto);   mthis.value=mmonto;
return true;}
function apaga_monto_mov(mthis){var mmonto; var mtasa; var smonto=mthis.value; 
   apagar(mthis); smonto=camb_punto_coma(smonto); mthis.value=smonto;   
   mmonto=quitacomas(mthis.value); mtasa=quitaformatomonto(document.form1.txttasa_cambio.value);
   mmonto=(mmonto*1); mtasa=(mmonto*mtasa);   mtasa=Math.round(mtasa*100)/100;
   document.form1.txtmonto_bs.value=mtasa; document.form1.txtmonto_bs.value=daformatomonto(document.form1.txtmonto_bs.value);
return true;}

function revisar(){var f=document.form1; var valido=true; var r;
    if(f.txtcod_banco.value==""){alert("Codigo de Banco no puede estar Vacio");return false;}
    if(f.txtreferencia.value==""){alert("Referencia no puede estar Vacio");return false;}
    if(f.txtreferencia.value.length==8){f.txtreferencia.value=f.txtreferencia.value.toUpperCase();} else{alert("Longitud Referencia Invalida");return false;}
    if(f.txtnombre_banco.value==""){alert("Nombre de Banco no puede estar Vacio");return false;} else{f.txtnombre_banco.value=f.txtnombre_banco.value.toUpperCase();}
    if(f.txtcod_banco.value.length==4){f.txtcod_banco.value=f.txtcod_banco.value.toUpperCase();} else{alert("Longitud Codigo de Banco Invalida");return false;}
    if(f.txtced_rif.value==""){alert("Cedula/Rif del beneficiario no puede estar Vacio");return false;}else{f.txtced_rif.value=f.txtced_rif.value.toUpperCase();}
    if(f.txtnombre_benef.value==""){alert("Nombre del Beneficiario no puede estar Vacio"); return false; } else{f.txtnombre_benef.value=f.txtnombre_benef.value.toUpperCase();}
    if((f.txttipo_movimiento.value=="")||(f.txttipo_movimiento.value=="TRC")||(f.txttipo_movimiento.value=="TRD")||(f.txttipo_movimiento.value=="CHQ")||(f.txttipo_movimiento.value=="ANU")||(f.txttipo_movimiento.value=="ANC")||(f.txttipo_movimiento.value=="AND")){alert("Tipo de Movimiento Inavlido");return false;} else{f.txttipo_movimiento.value=f.txttipo_movimiento.value.toUpperCase();}
    if(f.txtmonto_mov_libro.value==""){alert("Monto no puede estar Vacio");return false;}
	if(f.txtcod_cta_flujo.value==""){alert("Cuenta de Flujo no puede estar Vacio");return false;}
    if(f.txtdescripcion.value==""){alert("Descripcion no puede estar Vacio");return false;}else{f.txtdescripcion.value=f.txtdescripcion.value.toUpperCase();}
	r=confirm("Desea Grabar el Movimiento Cuentas en Dolares ?");  if (r==true) { valido=true;} else{return false;} 
document.form1.submit;
return true;}
</script>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR MOVIMIENTOS CUENTAS EN DOLARES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="430" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="425"><table width="92" height="423" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Mov_cta_dolares.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_Mov_cta_dolares.php">Atras</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>      <div id="Layer1" style="position:absolute; width:870px; height:419px; z-index:1; top: 70px; left: 115px;">
        <form name="form1" method="post" action="Insert_mov_dolares.php" onSubmit="return revisar()">
          <table width="868" border="0" >
                <tr>
                  <td width="862"><table width="860">
                    <tr>
                      <td width="126"><span class="Estilo5">C&Oacute;DIGO BANCO:</span></td>
                       <td width="71"><span class="Estilo5"> <input class="Estilo10" name="txtcod_banco" type="text" id="txtcod_banco" size="5" maxlength="4"  onFocus="encender(this)" onBlur="apaga_banco(this)" onchange="chequea_banco(this.form);">  </span> </td>
                      <td width="90"><input class="Estilo10" name="btcod_banco" type="button" id="btcod_banco" title="Abrir Catalogo de Bancos" onclick="VentanaCentrada('Cat_bancos_dolares.php?criterio=','SIA','','750','500','true')" value="..."></td>
                      <td width="142"><span class="Estilo5">N&Uacute;MERO DE CUENTA:</span></td>
                      <td width="405"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtnro_cuenta" type="text"  id="txtnro_cuenta"   size="55" maxlength="55" readonly></span></div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="860">
                      <tr>
                        <td width="126"><span class="Estilo5">NOMBRE DEL BANCO  : </span></td>
                        <td width="717"><span class="Estilo5">  <input class="Estilo10" name="txtnombre_banco" type="text"  id="txtnombre_banco"   size="110" maxlength="100" readonly></span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="860">
                      <tr>
                        <td width="100"><span class="Estilo5"><div id="rmov">REFERENCIA  : </div> </span></td>
                        <td width="115"><span class="Estilo5"><input class="Estilo10" name="txtreferencia" type="text"  id="txtreferencia"   size="10" maxlength="8" onFocus="encender(this)" onBlur="apaga_referencia(this)"> </span></td>
                        <td width="125"><span class="Estilo5">TIPO MOVIMIENTO :</span></td>
                        <td width="60"><span class="Estilo5"><input class="Estilo10" name="txttipo_movimiento" type="text" id="txttipo_movimiento"   size="4" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                        <td width="45"><input class="Estilo10" name="bttipo_mov" type="button" id="bttipo_mov" title="Abrir Catalogo Tipos de Movimiento" onclick="VentanaCentrada('Cat_tipo_mov_inc.php?criterio=','SIA','','750','500','true')" value="..."></td>
                        <td width="410"><span class="Estilo5"><input class="Estilo10" name="txtdes_tipo_mov" type="text" id="txtdes_tipo_mov"   size="57" maxlength="57" readonly> </span></td>
                      </tr>
                  </table></td>
                </tr>
          <tr>
            <td><table width="860">
              <tr>
                <td width="100"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                <td width="115"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif" type="text"  id="txtced_rif"  value="<?echo $ced_rif?>" size="12" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)"> </span> </td>
                <td width="45"><input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiario" onclick="VentanaCentrada('Cat_benef_chq.php?criterio=','SIA','','750','500','true')" value="..."></td>
                <td width="100"><span class="Estilo5">BENEFICIARIO : </span></td>
                <td width="500"><span class="Estilo5"><input class="Estilo10" name="txtnombre_benef" type="text" id="txtnombre_benef"  value="<?echo $nombre_benef?>" size="70" maxlength="70" readonly> </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td ><table width="860">
              <tr>
                <td width="100"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                <td width="750"><span class="Estilo5"> <textarea name="txtdescripcion" cols="90" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" id="txtdescripcion"><?echo $descripcion?></textarea>
                </span> </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="860">
              <tr>
                <td width="100"><span class="Estilo5">FECHA :</span></td>
                <td width="330"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text"  id="txtfecha"  value="<?echo $fecha?>" size="12" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                <td width="130"><span class="Estilo5">MONTO DOLARES :</span></td>
                <td width="300"><span class="Estilo5"> <input class="Estilo10" name="txtmonto_mov_libro"  style="text-align:right" type="text"  id="txtmonto_mov_libro"  size="17" maxlength="16" onFocus="encender_monto(this)" onBlur="apaga_monto_mov(this)" onKeypress="return validarNum(event)"> </span></td>
              </tr>
            </table></td>
          </tr>
		  <tr>
            <td><table width="860">
              <tr>
                <td width="130"><span class="Estilo5">TASA DE CAMBIO :</span></td>
                <td width="300"><span class="Estilo5"><input class="Estilo10" name="txttasa_cambio"  style="text-align:right" type="text"  id="txttasa_cambio" value="<?echo $tasa_cambio?>" size="12" maxlength="10" readonly></span></td>
                <td width="130"><span class="Estilo5">MONTO BOLIVARES :</span></td>
                <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtmonto_bs"  style="text-align:right"  type="text"  id="txtmonto_bs"  value="<?echo $monto_bs?>" size="17" maxlength="16" readonly> </span></td>
              </tr>
            </table></td>
          </tr>
		  <tr>
			  <td width="860"><table width="860" >
				<tr>
				   <td width="130" class="Estilo5"><span class="Estilo5">CUENTA DE FLUJO  :</span></td>
				   <td width="170"><span class="Estilo5"><input class="Estilo10" name="txtcod_cta_flujo" type="text" id="txtcod_cta_flujo" value="<?echo $cod_cta_flujo?>" size="25" onFocus="encender(this)" onBlur="apagar(this)"></td>
				   <td width="50"><input name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo Cuentas en Dolares"  onClick="VentanaCentrada('Cat_cuentas_dolares.php?criterio=','SIA','','750','500','true')" value="..."></td>
                   <td width="510"><span class="Estilo5"> <input name="txtnombre_cta_flujo" type="text" id="txtnombre_cta_flujo"  size="75" maxlength="200" readonly>  </span></td>
                      
				</tr>
			  </table>  </td>
		  </tr>
          <tr>  <td>&nbsp;</td> </tr>
        </table>
        
        <table width="812">
          <tr>  <td>&nbsp;</td> </tr>
          <tr>
            <td width="50"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
            <td width="50"><input name="txtcod_bancoA" type="hidden" id="txtcod_bancoA" value="0000"></td>
            <td width="50"><input name="txtreferenciaA" type="hidden" id="txtreferenciaA" value="00000000"></td>
            <td width="514">&nbsp;</td>
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