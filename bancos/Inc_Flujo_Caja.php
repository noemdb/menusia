<?include ("../class/seguridad.inc");include ("../class/ventana.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Definici&oacute;n Movimiento del Flujo de Caja)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language=JavaScript src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function LlamarURL(url){  document.location = url; }
function chequea_codigo(mform){var mref;
   mref=mform.txtcod_movimiento.value;   mref = Rellenarizq(mref,"0",3);   mform.txtcod_movimiento.value=mref;
return true;}

function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function apaga_monto(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=mthis.value;  mmonto=camb_punto_coma(mmonto); mthis.value=mmonto;
 return true;}
function revisar(){var f=document.form1;
    if(f.txtcod_movimiento.value==""){alert("Codigo de Movimientono puede estar Vacio");f.txtcod_movimiento.focus();return false;}
    if(f.txtdescripcion.value==""){alert("Nombre de Movimientono no puede estar Vacia");f.txtdescripcion.focus();return false;} else{f.txtdescripcion.value=f.txtdescripcion.value.toUpperCase();}
    if(f.txtcod_titulo.value==""){alert("Codigo de Titulo puede estar Vacio");f.txtcod_titulo.focus();return false;}
	if(f.txtcod_grupo.value==""){alert("Codigo de Grupo puede estar Vacio");f.txtcod_grupo.focus();return false;}
	if(f.txtcod_movimiento.value.length==3){f.txtcod_movimiento.value=f.txtcod_movimiento.value.toUpperCase();} else{alert("Longitud Codigo de Movimientono Invalida");f.txtcod_movimiento.focus();return false;}
    if(f.txtCodigo_Cuenta.value==""){alert("Codigo Contable no puede estar Vacio");return false;}
document.form1.submit;
return true;}
</script>
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
</head>
<?
$cod_movimiento="";$denominacion=""; $denominacion_titulo=""; $linea=""; $descripcion=""; $cod_grupo=""; $operacion=""; $tipo_operacion=""; 
$activo=""; $modulo=""; $signo=""; $cod_contab=""; $cod_contable=""; $tipo_mov=""; $monto=0; $acumulado=0; $cod_titulo=""; $cargable=""; 
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR MOVIMIENTOS FLUJOS DE CAJA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="410" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="407"><table width="92" height="406" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Flujo_Caja.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="left"><a class=menu
            href="Act_Flujo_Caja.php">Atras</a></div></td>
     </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="left"><a class=menu href="menu.php">Menu</a></div></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
     </tr>
   </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>     
	 <form name="form1" method="post" action="Insert_mov_flujo_caja.php" onSubmit="return revisar()">
       <div id="Layer1" style="position:absolute; width:861px; height:408px; z-index:1; top: 70px; left: 114px;">
	     <table width="857" border="0" >
           <tr>
             <td><table width="850">
                 <tr>
                   <td width="140" height="24"><span class="Estilo5">C&Oacute;DIGO MOVIMIENTO :</span></td>
                   <td width="670"><span class="Estilo5"><input name="txtcod_movimiento" type="text" class="Estilo5" id="txtcod_movimiento"  value="<?echo $cod_movimiento?>" size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_codigo(this.form);">  </span></td>
                   <td width="40"></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
                 <tr>
                   <td width="1001"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                   <td width="750"><span class="Estilo5"><textarea name="txtdescripcion" cols="85" onFocus="encender(this)" onBlur="apagar(this)" class="headers" id="txtdescripcion"><?echo $descripcion?></textarea>
                   </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
                 <tr>
                   <td width="60"><span class="Estilo5">TITULO : </span></td>
                   <td width="60"><span class="Estilo5"><input name="txtcod_titulo" type="text" class="Estilo5" id="txtcod_titulo"  value="<?echo $cod_titulo?>" size="5" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)">    </span></td>
                   <td width="40"><span class="Estilo5"><input name="bttipo_titulo" type="button" class="Estilo5" id="bttipo_titulo" title="Abrir Catalogo Titulos" onclick="VentanaCentrada('Cat_titulos_pre_caja.php?criterio=','SIA','','750','500','true')" value="...">    </span></td>                  
				   <td width="100"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                   <td width="590"><span class="Estilo5"> <input name="txtdenominacion_titulo" type="text" class="Estilo5" id="txtdenominacion_titulo"  value="<?echo $denominacion_titulo?>" size="120" maxlength="200" readonly>   </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
                 <tr>
                   <td width="60"><span class="Estilo5">GRUPO : </span></td>
                   <td width="60"><span class="Estilo5"><input name="txtcod_grupo" type="text" class="Estilo5" id="txtcod_grupo"  value="<?echo $cod_grupo?>" size="5" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                   <td width="40"><span class="Estilo5"><input name="bttipo_titulo" type="button" class="Estilo5" id="bttipo_titulo" title="Abrir Catalogo Grupos" onclick="VentanaCentrada('Cat_grupos_pre_caja.php?criterio=','SIA','','750','500','true')" value="...">    </span></td>                  
				   <td width="100"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                   <td width="590"><span class="Estilo5"> <input name="txtdenominacion" type="text" class="Estilo5" id="txtdenominacion"  value="<?echo $denominacion?>" size="120" maxlength="200" readonly>  </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
                 <tr>
                   <td width="100"><span class="Estilo5">OPERACI&Oacute;N :</span></td>
                   <td width="240"><select name="txtoperacion" class="Estilo5" id="txtoperacion" onFocus="encender(this)" onBlur="apagar(this)"> <option>SALDO INICIAL</option>   <option>INGRESO</option>   <option>EGRESO</option>   </select> </span></td>
				 
				   <td width="120"><span class="Estilo5">TIPO OPERACI&Oacute;N : </span></td>
                   <td width="230"><select name="txttipo_operacion" class="Estilo5" id="txttipo_operacion" onFocus="encender(this)" onBlur="apagar(this)"> <option>AUTOMATICO</option>    <option>MANUAL</option>   </select> </span></td>
				   
				   <td width="70"><span class="Estilo5">ACTIVO :</span></td>
				   <td width="100"><select name="txtactivo" class="Estilo5" onFocus="encender(this)" onBlur="apagar(this)" id="txtactivo"><option>SI</option> <option>NO</option> </select> </span></td>
				 </tr>
             </table></td>
           </tr>
           <tr>
            <td><table width="850">
                 <tr>
                   <td width="170"><span class="Estilo5">M&Oacute;DULO QUE LO GENERA :</span></td>
                   <td width="340"><select name="txtmodulo" class="Estilo5" id="txtmodulo" onFocus="encender(this)" onBlur="apagar(this)">
                       <option>BANCO</option> <option>CONTABILIDAD</option><option>PRESUPUESTO</option> <option>RETENCIONES</option>
                       <option>RETENCION CANC</option> <option>RETENCION LIB</option> <option>BANCOS NO AFECT</option>
                      <option>AJUSTE PRESUP</option>    <option>GASTO FLUJO</option> </select> </td>
				   <td width="180"><span class="Estilo5">SIGNO DE LA OPERACI&Oacute;N :</span></td>
                   <td width="160"><select name="txtsigno" class="Estilo5" id="txtsigno" onFocus="encender(this)" onBlur="apagar(this)"> <option>POSITIVO</option>  <option>NEGATIVO</option> </select></td>
				 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
                 <tr>
                   <td width="150" height="24"><span class="Estilo5">C&Oacute;DIGO OPERACI&Oacute;N :</span></td>
				   <td width="200"><span class="Estilo5"><input name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" class="Estilo5"  size="30" maxlength="32" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_contable?>"></span></td>
                   <td width="200"><input name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo Codigo de Cuentas"  onClick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="..."></td>
                   <td width="50"><input name="txtNombre_Cuenta" type="hidden" id="txtNombre_Cuenta" value="" ></td>
				   <td width="150"><span class="Estilo5">TIPO MOVIMIENTO :</span></td>
                   <td width="100"><span class="Estilo5"> <input name="txttipo_mov" type="text" class="Estilo5" id="txttipo_mov"  value="<?echo $tipo_mov?>" size="5" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
                 <tr>
                   <td width="150"><span class="Estilo5">C&Oacute;DIGO CONTABLE :</span></td>
                   <td width="200"><span class="Estilo5"> <input name="txtcod_contab" type="text" class="Estilo5" id="txtcod_contab"  value="<?echo $cod_contab?>" size="30" maxlength="18" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                   <td width="40"><input name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo Codigo de Cuentas"  onClick="VentanaCentrada('Cat_contab_cargables.php?criterio=','SIA','','750','500','true')" value="..."></td>
                   <td width="5"><input name="txtNombre_Contab" type="hidden" id="txtNombre_Contab" value="" ></td>
				   <td width="60"><span class="Estilo5">MONTO : </span></td>
                   <td width="150"><span class="Estilo5"><input name="txtmonto" type="text" class="Estilo5" id="txtmonto"  style="text-align:right" value="<?echo $monto?>" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                   <td width="105"><span class="Estilo5">ACUMUMULADO :</span></td>
                   <td width="150"><span class="Estilo5"><input name="txtacumulado" type="text" class="Estilo5" id="txtacumulado" style="text-align:right" value="<?echo $acumulado?>" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                 </tr>
             </table></td>
           </tr>
         </table>
         <p>&nbsp;</p>
		 <table width="812">
              <tr>
                <td width="664">&nbsp;</td>
                <td width="88"><input name="btgrabar" type="submit" id="btgrabar"  value="Grabar"></td>
                <td width="88"><input name="btblanquear" type="reset" value="Blanquear"></td>
              </tr>
            </table>
       </div>	   
	 </form>     
    </td>
  </tr>
</table>
</body>
</html>


         
           
           
