<?php include ("../class/seguridad.inc");include ("../class/ventana.php");  include ("../class/fun_fechas.php"); 
$codigo_mov=$_POST["txtcodigo_mov2"];  $user=$_POST["txtuser2"]; $password=$_POST["txtpassword2"]; $dbname=$_POST["txtdbname2"];  $ced_rif=$_POST["txtced_r2"]; $nombre_benef=$_POST["txtnomb2"]; $fecha_hoy=asigna_fecha_hoy(); 
$fecha_fin=formato_ddmmaaaa($_POST["txtfecha_fin2"]); if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;} $fecha=$fecha_hoy; $descripcion="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Movimientos en Libros)</title>
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
function apaga_banco(mthis){
var mref; var mcedrif;
   apagar(mthis);
   mref=document.form1.txtcod_banco.value;  mref=Rellenarizq(mref,"0",4);  document.form1.txtcod_banco.value=mref; mcedrif=document.form1.txtced_rif.value;
   ajaxSenddoc('GET', 'refmov.php?cod_banco='+mref+'&cedrif='+mcedrif+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'rmov', 'innerHTML');
return true;}
function chequea_banco(mform){
var mref; var mcedrif;
   mref=mform.txtcod_banco.value;  mref=Rellenarizq(mref,"0",4);  mform.txtcod_banco.value=mref; mcedrif=document.form1.txtced_rif.value;
return true;}
function apaga_referencia(mthis){
var mref;
   apagar(mthis); mref=document.form1.txtreferencia.value;  mref=Rellenarizq(mref,"0",8);  document.form1.txtreferencia.value=mref; document.form1.txtreferenciaA.value=mref;
return true;}
function apaga_bancoA(mthis){
var mref; 
   apagar(mthis);
   mref=document.form1.txtcod_bancoA.value;  mref=Rellenarizq(mref,"0",4);  document.form1.txtcod_bancoA.value=mref; 
return true;}
function chequea_bancoA(mform){
var mref; 
   mref=mform.txtcod_bancoA.value;  mref=Rellenarizq(mref,"0",4);  mform.txtcod_bancoA.value=mref; 
return true;}
function apaga_referenciaA(mthis){
var mref;
   apagar(mthis); mref=document.form1.txtreferenciaA.value;  mref=Rellenarizq(mref,"0",8);  document.form1.txtreferenciaA.value=mref;
return true;}
function apaga_monto(mthis){
var mref; var mmonto;  var mcedrif; var mtipomov; var mrefa;
   apagar(mthis);  mref=document.form1.txtcod_banco.value; mrefa=document.form1.txtcod_bancoA.value;  mmonto=document.form1.txtmonto_mov_libro.value;  mcedrif=document.form1.txtced_rif.value; mtipomov=document.form1.txttipo_movimiento.value;
   ajaxSenddoc('GET', 'gasientrans.php?cod_banco='+mref+'&cod_bancoa='+mrefa+'&monto='+mmonto+'&cedrif='+mcedrif+'&tipomov='+mtipomov+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'T11', 'innerHTML');
return true;}
function revisar(){
var f=document.form1;
    if(f.txtcod_banco.value==""){alert("Codigo de Banco no puede estar Vacio");return false;}
    if(f.txtreferencia.value==""){alert("Referencia no puede estar Vacio");return false;}
    if(f.txtnombre_banco.value==""){alert("Nombre de Banco no puede estar Vacio");return false;} else{f.txtnombre_banco.value=f.txtnombre_banco.value.toUpperCase();}
    if(f.txtcod_banco.value.length==4){f.txtcod_banco.value=f.txtcod_banco.value.toUpperCase();} else{alert("Longitud Codigo de Banco Invalida");return false;}
    if(f.txtced_rif.value==""){alert("Cedula/Rif del beneficiario no puede estar Vacio");return false;}else{f.txtced_rif.value=f.txtced_rif.value.toUpperCase();}
    if(f.txtnombre_benef.value==""){alert("Nombre del Beneficiario no puede estar Vacio"); return false; } else{f.txtnombre_benef.value=f.txtnombre_benef.value.toUpperCase();}
    if((f.txttipo_movimiento.value=="")||(f.txttipo_movimiento.value=="TRD")||(f.txttipo_movimiento.value=="CHQ")||(f.txttipo_movimiento.value=="ANU")||(f.txttipo_movimiento.value=="AND")){alert("Tipo de Movimiento Inavlido");return false;} else{f.txttipo_movimiento.value=f.txttipo_movimiento.value.toUpperCase();}
    if(f.txtmonto_mov_libro.value==""){alert("Monto no puede estar Vacio");return false;}
    if(f.txtdescripcion.value==""){alert("Descripcion no puede estar Vacio");return false;}else{f.txtdescripcion.value=f.txtdescripcion.value.toUpperCase();}
	if(f.txtcod_bancoA.value==""){alert("Codigo de Banco Emisor no puede estar Vacio");return false;}
    if(f.txtreferenciaA.value==""){alert("Referencia Emisor no puede estar Vacio");return false;}
document.form1.submit;
return true;}
</script>

</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR TRANSFERENCIA EN LIBROS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="580" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="575"><table width="92" height="573" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Mov_Libros.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_Mov_Libros.php">Atras</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>      <div id="Layer1" style="position:absolute; width:870px; height:519px; z-index:1; top: 70px; left: 115px;">
        <form name="form1" method="post" action="Insert_mov_lib.php" onSubmit="return revisar()">
          <table width="868" border="0" >
                <tr>
                  <td width="862"><table width="860">
                    <tr>
                      <td width="172"><span class="Estilo5">C&Oacute;DIGO BANCO RECEPTOR:</span></td>
                       <td width="51"><span class="Estilo5"> <input name="txtcod_banco" type="text" id="txtcod_banco" size="5" maxlength="4"  onFocus="encender(this)" onBlur="apaga_banco(this)" onchange="chequea_banco(this.form);">  </span> </td>
                      <td width="69"><input class="Estilo10" name="btcod_banco" type="button" id="btcod_banco" title="Abrir Catalogo de Bancos" onclick="VentanaCentrada('Cat_bancos.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                      <td width="137"><span class="Estilo5">N&Uacute;MERO DE CUENTA:</span></td>
                      <td width="405"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtnro_cuenta" type="text"  id="txtnro_cuenta"   size="57" maxlength="57" readonly></span></div></td>
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
                        <td width="60"><span class="Estilo5"><input class="Estilo10" name="txttipo_movimiento" type="text" id="txttipo_movimiento"  value="TRC" size="4" maxlength="4" readonly></span></td>
                        <td width="450"><span class="Estilo5"><input class="Estilo10" name="txtdes_tipo_mov" type="text" id="txtdes_tipo_mov" value="TRANSFERENCIA CREDITO"  size="63" maxlength="63" readonly> </span></td>
                      </tr>
                  </table></td>
                </tr>
          <tr>
            <td><table width="860">
              <tr>
                <td width="100"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                <td width="115"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif" type="text"  id="txtced_rif"  value="<?php echo $ced_rif?>" size="12" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)"> </span> </td>
                <td width="45"><input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiario" onclick="VentanaCentrada('Cat_benef_chq.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                <td width="100"><span class="Estilo5">BENEFICIARIO : </span></td>
                <td width="500"><span class="Estilo5"><input class="Estilo10" name="txtnombre_benef" type="text" id="txtnombre_benef"  value="<?php echo $nombre_benef?>" size="70" maxlength="70" readonly> </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td ><table width="860">
              <tr>
                <td width="100"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                <td width="750"><span class="Estilo5"> <textarea name="txtdescripcion" cols="90" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" id="txtdescripcion"><?php echo $descripcion?></textarea> </span> </td>
              </tr>
            </table></td>
          </tr>
		  <tr>
                  <td width="862"><table width="860">
                    <tr>
                      <td width="172"><span class="Estilo5">C&Oacute;DIGO BANCO EMISOR:</span></td>
                       <td width="51"><span class="Estilo5"> <input class="Estilo10" name="txtcod_bancoA" type="text" id="txtcod_bancoA" size="5" maxlength="4"  onFocus="encender(this)" onBlur="apaga_bancoA(this)" onchange="chequea_bancoA(this.form);">  </span> </td>
                      <td width="69"><input class="Estilo10" name="btcod_bancoA" type="button" id="btcod_bancoA" title="Abrir Catalogo de Bancos" onclick="VentanaCentrada('Cat_bancosA.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                      <td width="137"><span class="Estilo5">N&Uacute;MERO DE CUENTA:</span></td>
                      <td width="405"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtnro_cuentaA" type="text"  id="txtnro_cuentaA"   size="57" maxlength="57" readonly></span></div></td>
                    </tr>
                  </table></td>
          </tr>
		  <tr>
                  <td><table width="860">
                      <tr>
                        <td width="126"><span class="Estilo5">NOMBRE DEL BANCO  : </span></td>
                        <td width="717"><span class="Estilo5">  <input class="Estilo10" name="txtnombre_bancoA" type="text"  id="txtnombre_bancoA"   size="110" maxlength="100" readonly></span></td>
                      </tr>
                  </table></td>
          </tr>	
		  <tr>
                  <td><table width="860">
                      <tr>
                        <td width="100"><span class="Estilo5">REFERENCIA  : </span></td>
                        <td width="115"><span class="Estilo5"><input class="Estilo10" name="txtreferenciaA" type="text"  id="txtreferenciaA"   size="10" maxlength="8" onFocus="encender(this)" onBlur="apaga_referenciaA(this)"> </span></td>
                        <td width="125"><span class="Estilo5">TIPO MOVIMIENTO :</span></td>
                        <td width="60"><span class="Estilo5"><input class="Estilo10" name="txttipo_movimientoA" type="text" id="txttipo_movimientoA"  value="TRD" size="4" maxlength="4" readonly></span></td>
                        <td width="450"><span class="Estilo5"><input class="Estilo10" name="txtdes_tipo_movA" type="text" id="txtdes_tipo_movA" value="TRANSFERENCIA DEBITO"  size="63" maxlength="63" readonly> </span></td>
                      </tr>
                  </table></td>
                </tr>		
		  <tr>	
            <td><table width="860">
              <tr>
                <td width="100"><span class="Estilo5">FECHA :</span></td>
                <td width="390"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text"  id="txtfecha"  value="<?php echo $fecha?>" size="12" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                <td width="69"><span class="Estilo5">MONTO :</span></td>
                <td width="300"><span class="Estilo5"> <input class="Estilo10" name="txtmonto_mov_libro"  align="right"  type="text"  id="txtmonto_mov_libro" style="text-align:right"   size="17" maxlength="16" onFocus="encender(this)" onBlur="apaga_monto(this)" onKeypress="return validarNum(event)"> </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>  <td>&nbsp;</td> </tr>
        </table>
        <div id="T11" class="tab-body">
              <iframe src="Det_inc_trans_libro.php?codigo_mov=<?php echo $codigo_mov?>" width="840" height="150" scrolling="auto" frameborder="1"></iframe>
        </div>

        <table width="812">
          <tr>  <td>&nbsp;</td> </tr>
          <tr>
            <td width="50"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>" ></td>
            <td width="614">&nbsp;</td>
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