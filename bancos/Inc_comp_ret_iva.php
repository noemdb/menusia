<?include ("../class/ventana.php"); include ("../class/fun_fechas.php");
 $codigo_mov=$_POST["txtcodigo_mov"];  $fecha_hoy=asigna_fecha_hoy();  $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"];
 $corr_iva_mes=$_POST["txtcorr_iva_mes"]; $nro_comprobante="00000000";  
 $fecha_fin=formato_ddmmaaaa($_POST["txtfecha_fin"]); if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;} $fecha=$fecha_hoy; $ano_fiscal=substr($fecha_hoy,6,4);  $mes_fiscal=substr($fecha_hoy,3,2);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Incluir Comprobante Retenciones IVA)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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
function chequea_mes(mform){var mref; var mano;
   mano=mform.txtano_fiscal.value;  mref=mform.txtmes_fiscal.value; mref = Rellenarizq(mref,"0",2); mform.txtmes_fiscal.value=mref;
   ajaxSenddoc('GET', 'compretiva.php?ano='+mano+'&mes='+mref+'&codigo_mov=<?echo $codigo_mov?>'+'&corr_iva_mes=<?echo $corr_iva_mes?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nrocomp', 'innerHTML');
return true;}
function checkrefecha(mform){
var mref; var mfec; mref=mform.txtfecha.value; mfec=mform.txtfecha.value;
  if(mform.txtfecha.value.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7);mform.txtfecha.value=mfec;}
return true;}
function Cargar_Ret(mform){var mref; var mcod; var mtipo;
   mref=mform.txtreferencia.value; mcod=mform.txtcod_banco.value; mtipo=mform.txttipo_movimiento.value;
   ajaxSenddoc('GET', 'cargaivamov.php?cod_banco='+mcod+'&tipo_mov='+mtipo+'&referencia='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'T11', 'innerHTML');
return true;}
function revisar(){var f=document.form1;var Valido=true;
    if(f.txtfecha_e.value==""){alert("Fecha no puede estar Vacia");return false;}
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
<table width="989" height="531" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="518" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_comp_ret_iva.php?Gcriterio=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_comp_ret_iva.php?Gcriterio=U">Atras</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
      </tr>
      <tr>
        <td><div align="center"></div></td>
      </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:876px; height:491px; z-index:1; top: 62px; left: 118px;">
        <form name="form1" method="post" action="Insert_comp_ret_iva.php" onSubmit="return revisar()">
          <table width="873" border="0" >
                <tr> <td width="872" height="14">&nbsp;</td>  </tr>
                <tr>
                  <td><table width="861" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="155"><span class="Estilo5">PERIODO FISCAL A&Ntilde;O  : </span></td>
                      <td width="80"><span class="Estilo5"> <input class="Estilo10" name="txtano_fiscal" type="text" id="txtano_fiscal" size="5" maxlength="5"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $ano_fiscal?>" ></span></td>
                      <td width="45"><span class="Estilo5">MES :</span></td>
                      <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtmes_fiscal" type="text" id="txtmes_fiscal" size="2" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $mes_fiscal?>" onchange="chequea_mes(this.form)"></span></td>
                      <td width="170"><span class="Estilo5">N&Uacute;MERO COMPROBANTE  :</span></td>
                      <td width="120"><span class="Estilo5"><div id="nrocomp"> <input class="Estilo10" name="txtnro_comprobante" type="text" id="txtnro_comprobante" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" > </div></span></td>
                      <script language="JavaScript" type="text/JavaScript"> var mref; var mano; mano=document.form1.txtano_fiscal.value;  mref=document.form1.txtmes_fiscal.value; mref = Rellenarizq(mref,"0",2); document.form1.txtmes_fiscal.value=mref; ajaxSenddoc('GET', 'compretiva.php?ano='+mano+'&mes='+mref+'&codigo_mov=<?echo $codigo_mov?>'+'&corr_iva_mes=<?echo $corr_iva_mes?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nrocomp', 'innerHTML'); </script>
                      <td width="120"><span class="Estilo5">FECHA EMISI&Oacute;N  : </span></td>
                      <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_e" type="text" id="txtfecha_e" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $fecha_hoy?>" onchange="checkrefecha(this.form)"> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td ><table width="862">
                    <tr>
                      <td width="133"><span class="Estilo5">C&Oacute;DIGO DEL BANCO:</span></td>
                      <td width="45"><span class="Estilo5"> <input class="Estilo10" name="txtcod_banco" type="text" id="txtcod_banco" size="5" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)" >  </span> </td>
                      <td width="50"><input class="Estilo10" name="btcod_banco" type="button" id="btcod_banco" title="Abrir Catalogo de Bancos" onclick="VentanaCentrada('Cat_bancos.php?criterio=','SIA','','750','500','true')" value="..."></td>
                      <td width="632"><span class="Estilo5"><input class="Estilo10" name="txtnombre_banco" type="text" id="txtnombre_banco" size="90"  readonly> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="862">
                    <tr>
                      <td width="144"><span class="Estilo5">TIPO DE MOVIMIENTO : </span></td>
                      <td width="86"><span class="Estilo5"><input class="Estilo10" name="txttipo_movimiento" type="text" id="txttipo_movimiento"  size="4" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
                      <td width="211"><span class="Estilo5">N&Uacute;MERO DE CHEQUE/NOTA DEBITO : </span></td>
                      <td width="75"><span class="Estilo5"><input class="Estilo10" name="txtreferencia" type="text" id="txtreferencia" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" onchange="checkreferencia(this.form);"> </span></td>
                      <td width="70"><input class="Estilo10" name="btmovlibro" type="button" id="btmovlibro" title="Catalogo Movimientos" onClick="VentanaCentrada('Cat_mov_chq_ndb.php?criterio=','SIA','','900','600','true')" value="..."> </td>
                      <td width="158"><span class="Estilo5">FECHA DEL MOVIMIENTO: </span></td>
                      <td width="86"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="10" maxlength="10" readonly></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="870">
                   <tr>
				      <td width="139"><span class="Estilo5"> CED./RIF BENEFICIARIO  :</span></span></td>
                      <td width="97"><span class="Estilo5"><input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                      <td width="50"><span class="Estilo5"> <input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('Cat_beneficiarios.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                      <td width="432"><span class="Estilo5"> <input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="60" readonly>                   </span></td>
                      <td width="152"><span class="Estilo5"><input type="button" name="btcarga_ret" value="Cargar Retenciones" title="Cargar Retenciones del movimiento" onClick="javascript:Cargar_Ret(this.form)" ></span></td>
                    </tr>
                    </table></td>
                </tr>
          </table>
              <div id="T11" class="tab-body">
              <iframe src="Det_inc_comp_iva.php?codigo_mov=<?echo $codigo_mov?>&agregar=S" width="870" height="310" scrolling="auto" frameborder="1"></iframe>
              </div>
         <table width="863" border="0"> <tr> <td height="5">&nbsp;</td> </tr> </table>
         <table width="812">
          <tr>
            <td width="654">&nbsp;</td>
			<td width="10"><input name="txtnro_cuenta" type="hidden" id="txtnro_cuenta" value=""></td>            
            <td width="10"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
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