<?php include ("../class/ventana.php"); include ("../class/fun_fechas.php");
 $codigo_mov=$_POST["txtcodigo_mov"];  $fecha_hoy=asigna_fecha_hoy();  $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"];
 $corr_iva_mes=$_POST["txtcorr_iva_mes"]; $nro_comprobante="00000000";  
 $fecha_fin=formato_ddmmaaaa($_POST["txtfecha_fin"]); if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;} $fecha=$fecha_hoy; $ano_fiscal=substr($fecha_hoy,6,4);  $mes_fiscal=substr($fecha_hoy,3,2);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Incluir Comprobante Retenciones IVA)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<link href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></SCRIPT>
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function apaga_monto(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto.value=mmonto;
return true;}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function chequea_mes(mform){var mref; var mano; 
   mano=mform.txtano_fiscal.value;  mref=mform.txtmes_fiscal.value; mref = Rellenarizq(mref,"0",2); mform.txtmes_fiscal.value=mref;
   ajaxSenddoc('GET', 'compretiva.php?ano='+mano+'&mes='+mref+'&codigo_mov=<?php echo $codigo_mov?>'+'&corr_iva_mes=<?php echo $corr_iva_mes?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nrocomp', 'innerHTML');
return true;}
function checkrefecha(mform){var mref;var mfec;
  mref=mform.txtfecha_e.value;   mfec=mform.txtfecha_e.value;
  if(mform.txtfecha_e.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha_e.value=mfec;}
return true;}
function checkorden(mform){var mref;
   mref=mform.txtnro_orden.value; mref = Rellenarizq(mref,"0",8);  mform.txtnro_orden.value=mref;
return true;}
function Cargar_Ret(mform){var mref; var Valido=true;
   mref=mform.txtnro_orden.value;
   if(mform.txtfecha_e.value==""){alert("Fecha no puede estar Vacia");return false;}
   if(mform.txtced_rif.value==""){alert("Cedula/Rif no puede estar Vacio");return false;}
   if(Valido==true){ ajaxSenddoc('GET', 'cargaretiva.php?criterio='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'T11', 'innerHTML'); }
return true;}
function revisar(){var f=document.form1; var Valido=true;
    if(f.txtfecha_e.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtced_rif.value==""){alert("Cedula/Rif no puede estar Vacio");return false;}
    if(f.txtnro_comprobante.value==""){alert("Numero de Comprobante no puede estar Vacio");return false;}
      else{f.txtnro_orden.value=f.txtnro_orden.value;}
  document.form1.submit;
return true;}
</script>
</head>
<body>
<table width="989" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR COMPROBANTE RETENCI&Oacute;N IVA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="989" height="530" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="525" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_comp_ret_iva.php?Gcriterio=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_comp_ret_iva.php?Gcriterio=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <tr>
    <td><div align="center"></div></td>
  </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:876px; height:491px; z-index:1; top: 62px; left: 118px;">
        <form name="form1" method="post" action="Insert_comp_ret_iva.php" onSubmit="return revisar()">
          <table width="856" border="0" >
                <tr> <td width="850" height="14">&nbsp;</td>  </tr>
                <tr>
                  <td height="14"><table width="861" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="155"><span class="Estilo5">PERIODO FISCAL A&Ntilde;O  : </span></td>
                      <td width="80"><span class="Estilo5"> <input class="Estilo10" name="txtano_fiscal" type="text" id="txtano_fiscal" size="5" maxlength="5"  onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $ano_fiscal?>" ></span></td>
                      <td width="45"><span class="Estilo5">MES :</span></td>
                      <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtmes_fiscal" type="text" id="txtmes_fiscal" size="2" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $mes_fiscal?>" onchange="chequea_mes(this.form)"></span></td>
                      <td width="170"><span class="Estilo5">N&Uacute;MERO COMPROBANTE  :</span></td>
                      <td width="120"><span class="Estilo5"><div id="nrocomp"> <input class="Estilo10" name="txtnro_comprobante" type="text" id="txtnro_comprobante" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" > </div></span></td>
                      <script language="JavaScript" type="text/JavaScript"> var mref; var mano; mano=document.form1.txtano_fiscal.value;  mref=document.form1.txtmes_fiscal.value; mref = Rellenarizq(mref,"0",2); document.form1.txtmes_fiscal.value=mref; ajaxSenddoc('GET', 'compretiva.php?ano='+mano+'&mes='+mref+'&codigo_mov=<?php echo $codigo_mov?>'+'&corr_iva_mes=<?php echo $corr_iva_mes?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nrocomp', 'innerHTML'); </script>
                      <td width="120"><span class="Estilo5">FECHA EMISI&Oacute;N  : </span></td>
                      <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_e" type="text" id="txtfecha_e" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?php echo $fecha_hoy?>" onchange="checkrefecha(this.form)"> </span></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
              <table width="889" border="0">
                <tr>
                  <td width="883"><table width="861" >
                    <tr>
                      <td width="95" height="24"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                      <td width="110"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="14" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)" > </span></td>
                      <td width="55"><span class="Estilo5"> <input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('Cat_beneficiarios.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
                      <td width="75"><span class="Estilo5"> NOMBRE :</span></td>
                      <td width="515"><span class="Estilo5">  <input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="90"  readonly>  </span></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
          <table width="889" border="0" >
                <tr>
                  <td width="883" height="14"><table width="861">
                    <tr>
                      <td width="150"><span class="Estilo5">N&Uacute;MERO DE ORDEN : </span></td>
                      <td width="84"><span class="Estilo5"><input class="Estilo10" name="txtnro_orden" type="text" id="txtnro_orden" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" onchange="checkorden(this.form);"> </span></td>
                      <td width="90"><input class="Estilo10" name="btordenes" type="button" id="btordenes" title="Catalogo Ordenes de Pago" onClick="VentanaCentrada('Cat_ord_pago.php?criterio=','SIPAP','','750','500','true')" value="..."> </td>
                      <td width="92"><span class="Estilo5">FECHA ORDEN:</span></td>
                      <td width="279"><span class="Estilo5"> <input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="10" maxlength="10" readonly></span></td>
                      <td width="187"><span class="Estilo5"> <input type="button" name="btcarga_ret" value="Cargar Retenciones" title="Cargar Retenciones de la Orden de pago" onClick="javascript:Cargar_Ret(this.form)" > </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td> </tr>
          </table>
              <div id="T11" class="tab-body">
              <iframe src="Det_inc_comp_iva.php?codigo_mov=<?php echo $codigo_mov?>&agregar=S" width="870" height="310" scrolling="auto" frameborder="1"></iframe>
              </div>
         <table width="863" border="0"> <tr> <td height="5">&nbsp;</td> </tr> </table>
         <table width="812">
          <tr>
            <td width="654">&nbsp;</td>
			<td width="10"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
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