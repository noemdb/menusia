<?php include ("../class/seguridad.inc");include ("../class/conects.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
if (!$_GET){$continua="N";}else{$continua=$_GET["continua"];}  $fecha_hoy=asigna_fecha_hoy();
$equipo = getenv("COMPUTERNAME"); $mcod_m = "BAN0062".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="02-0000020"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); 
if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
if($SIA_Cierre=="N"){$error=0;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
$fecha_fin=formato_ddmmaaaa($Fec_Fin_Ejer);  if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;}
if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICION ABIERTA'); document.location='menu.php';</script><?php }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Emision Nota Debito)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
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
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function apaga_banco(mthis){var mref; var fchq;
   apagar(mthis);
   mref=document.form1.txtcod_banco.value;  mref=Rellenarizq(mref,"0",4);  document.form1.txtcod_banco.value=mref; fchq=document.form1.txtfecha.value;
   ajaxSenddoc('GET', 'numchq.php?cod_banco='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nrochq', 'innerHTML');
   ajaxSenddoc('GET', 'versaldo.php?cod_banco='+mref+'&fecha='+fchq+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'msaldo', 'innerHTML');
return true;}
function apaga_ndb(mthis){var mref; var nndb; var fchq; var tpago; var mfechad; var mfechah;
   apagar(mthis);
   mref=document.form1.txtcod_banco.value;  mfechad=document.form1.txtfecha_desde.value;  mfechah=document.form1.txtfecha_hasta.value; nndb=document.form1.txtnro_ndb.value;  nndb=Rellenarizq(nndb,"0",8);  document.form1.txtnro_ndb.value=nndb;    fchq=document.form1.txtfecha.value;  tpago=document.form1.txttipo_pago.value;
   ajaxSenddoc('GET', 'vbanndb.php?codigo_mov='+mcodigo_mov+'&cbanco='+mref+'&fechad='+mfechad+'&fechah='+mfechah+'&nndb='+nndb+'&fecha='+fchq+'&tpago='+tpago+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nnotad', 'innerHTML');
return true;}
function chequea_ndb(mform){var mref; var nndb; var fchq; var tpago; var mfechad; var mfechah;
   mref=mform.txtcod_banco.value;  mfechad=mform.txtfecha_desde.value;  mfechah=mform.txtfecha_hasta.value; nndb=mform.txtnro_ndb.value;  nndb=Rellenarizq(nndb,"0",8);  mform.txtnro_ndb.value=nndb; fchq=mform.txtfecha.value;  tpago=mform.txttipo_pago.value;
   ajaxSenddoc('GET', 'vbanndb.php?codigo_mov='+mcodigo_mov+'&cbanco='+mref+'&fechad='+mfechad+'&fechah='+mfechah+'&nndb='+nndb+'&fecha='+fchq+'&tpago='+tpago+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nnotad', 'innerHTML');
return true;}
function chequea_numchq(mform){var mref; var nchq;  var fchq; var tpago; var mfechad; var mfechah;
   mref=mform.txtcod_banco.value;  mfechad=mform.txtfecha.value;  mfechah=mform.txtfecha.value; nchq=mform.txtnro_ndb.value;  nchq=Rellenarizq(nchq,"0",8);  mform.txtnro_ndb.value=nchq; fchq=mform.txtfecha.value;  tpago=mform.txttipo_pago.value;
   ajaxSenddoc('GET', 'vbanchq.php?codigo_mov='+mcodigo_mov+'&cbanco='+mref+'&fechad='+mfechad+'&fechah='+mfechah+'&ncheque='+nchq+'&fecha='+fchq+'&tpago='+tpago+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'ncheque', 'innerHTML');
return true;}
function revisar(){var f=document.form1;
    if(f.txtcod_banco.value==""){alert("Codigo de Banco no puede estar Vacio");return false;}
    if(f.txtnombre_banco.value==""){alert("Nombre de Banco no puede estar Vacio");return false;} else{f.txtnombre_banco.value=f.txtnombre_banco.value.toUpperCase();}
    if(f.txtcod_banco.value.length==4){f.txtcod_banco.value=f.txtcod_banco.value.toUpperCase();} else{alert("Longitud Codigo de Banco Invalida");return false;}
    if(f.txtced_rif.value==""){alert("Cedula/Rif no puede estar Vacio");return false;}
    if(f.txtconcepto.value==""){alert("Concepto no puede estar Vacio");return false;}else{f.txtconcepto.value=f.txtconcepto.value.toUpperCase();}
    if(f.txtmonto_nota.value==""){alert("Monto no puede estar Vacio");return false;}
document.form1.submit;
return true;}
function apaga_monto(mthis){var mref; var mmonto;  var morden;
   apagar(mthis);  mref=document.form1.txtcod_banco.value;  mmonto=document.form1.txtmonto_nota.value;   morden=mform.txtnro_orden.value;
   ajaxSenddoc('GET', 'gasienchqant.php?cod_banco='+mref+'&monto='+mmonto+'&orden='+morden+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'T11', 'innerHTML');
   document.form1.txtmonto_nota.value=mmonto;
return true;}
function chequea_monto(mform){var mref; var mmonto;
   mref=mform.txtcod_banco.value;  mmonto=mform.txtmonto_nota.value;
return true;}
function Genera_comprobante(mform){var mref; var mmonto; var morden;
   mref=mform.txtcod_banco.value;   //alert(mref);
   mmonto=mform.txtmonto_nota.value; //mmonto=camb_punto_coma(mmonto); alert(mmonto);
   morden=mform.txtnro_orden.value; //alert(morden);   
   ajaxSenddoc('GET', 'gasienchqant.php?cod_banco='+mref+'&monto='+mmonto+'&orden='+morden+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'T11', 'innerHTML');
return true;}
</script>
</head>
<?php 
$nombre_benef="";  $ced_rif=""; $disponible=0; 
$tipo_pago="0002"; $nombre_abrev="NDB"; $cod_banco="0001"; $nro_cuenta=""; $nombre_banco=""; $nro_ndb="00000000"; $fecha=$fecha_hoy; $fecha_hasta=nextDate($fecha,30); $fecha_desde=prevDate($fecha,30);
$mconf="";  $Ssql="Select * from SIA005 where campo501='02'"; $resultado=pg_query($Ssql);if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $tipo_pago=$registro["campo505"];}
if($continua=="S"){$StrSQL="select * from ban030 where codigo_mov='$codigo_mov'"; $res=pg_query($StrSQL); $filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); $ced_rif=$registro["campo_str1"];  $multiple=$registro["status_1"]; $cod_banco=$registro["cod_banco"]; $nro_ndb=$registro["num_cheque"]+1; $fecha=formato_ddmmaaaa($registro["fecha"]); $fecha_desde=formato_ddmmaaaa($registro["fecha_d"]); $fecha_hasta=formato_ddmmaaaa($registro["fecha_h"]);}
$sql="SELECT * FROM bancos where cod_banco='".$cod_banco."'"; $res=pg_query($sql);$filas=pg_num_rows($res); if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $disponible=$registro["s_inic_libro"]; $nro_cuenta=$registro["nro_cuenta"]; $nro_ndb=$registro["num_nota"]+1; $len=strlen($nro_ndb); $nro_ndb=substr("00000000",0,8-$len).$nro_ndb;
$nmes=substr($fecha,3, 2);  $m=$nmes*1; for ($i=1;$i<=$m;$i++){$spos=$i; If($i<=9){$spos="0".$spos;} $disponible=$disponible+$registro["deb_libro".$spos] - $registro["cre_libro".$spos]; }}
$sSQL="SELECT nombre FROM pre099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if ($filas>=1){$registro=pg_fetch_array($resultado,0); $nombre_benef=$registro["nombre"];}}
else {$resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); $sql="SELECT * FROM bancos ORDER BY cod_banco"; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $disponible=$registro["s_inic_libro"]; $nro_cuenta=$registro["nro_cuenta"]; $nro_ndb=$registro["num_nota"]+1; $len=strlen($nro_ndb); $nro_ndb=substr("00000000",0,8-$len).$nro_ndb;
$nmes=substr($fecha,3, 2);  $m=$nmes*1; for ($i=1;$i<=$m;$i++){$spos=$i; If($i<=9){$spos="0".$spos;} $disponible=$disponible+$registro["deb_libro".$spos] - $registro["cre_libro".$spos]; }}
$sql="SELECT ACTUALIZA_BAN030(1,'$codigo_mov','$cod_banco','$nro_ndb','$tipo_pago','$fecha','$fecha_desde','$fecha_hasta','N','N','')"; $resultado=pg_exec($conn,$sql); $error=pg_errormessage($conn); $error=substr($error, 0, 61);  }
pg_close($conn); $saldo=formato_monto($disponible);
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">EMISI&Oacute;N NOTA DEBITO  A ORDEN EJERCICIO ANTERIORES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="621" border="1" id="tablacuerpo">
  <tr>
    <td width="890" height="620">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:951px; height:599px; z-index:1; top: 70px; left: 15px;">
        <form name="form1" method="post" action="Insert_ndb_per_ant.php" onSubmit="return revisar()">
          <table width="960" border="0" >
				<tr>
                  <td><table width="945">
                    <tr>
                      <td width="125"><span class="Estilo5">DOCUMENTO PAGO: </span></td>
                      <td width="30"><span class="Estilo5"><input class="Estilo10" name="txttipo_pago" type="text" id="txttipo_pago" readonly  value="<?php echo $tipo_pago?>" size="4" maxlength="4" onkeypress="return stabular(event,this)"> </span></td>
                      <td width="70"><span class="Estilo5"><input class="Estilo10" name="txtnombre_abrev" type="text" id="txtnombre_abrev" size="5" maxlength="5"  value="<?php echo $nombre_abrev?>" readonly onkeypress="return stabular(event,this)">  </span> </td>
                      <td width="115"><span class="Estilo5">C&Oacute;DIGO BANCO :</span></td>
                      <td width="50"><span class="Estilo5"> <input class="Estilo10" name="txtcod_banco" type="text" id="txtcod_banco" size="4" maxlength="4"  value="<?php echo $cod_banco?>" onFocus="encender(this)" onBlur="apaga_banco(this)" onchange="chequea_banco(this.form);" onkeypress="return stabular(event,this)">  </span> </td>
                      <td width="55"><input class="Estilo10" name="btcod_banco" type="button" id="btcod_banco" title="Abrir Catalogo de Bancos" onclick="VentanaCentrada('Cat_bancos.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                      <td width="100"><span class="Estilo5">NRO CUENTA :</span></td>
                      <td width="240"><span class="Estilo5"> <input class="Estilo10" name="txtnro_cuenta" type="text" id="txtnro_cuenta" value="<?php echo $nro_cuenta?>"  size="28" maxlength="25" readonly onkeypress="return stabular(event,this)"> </span></td>
                      <td width="45"><span class="Estilo5">SALDO:</span></td>
					  <td width="120"><span class="Estilo5"><div id="msaldo"> <input class="Estilo10" name="txtsaldo" type="text" id="txtsaldo" value="<?php echo $saldo?>" size="15" maxlength="15" style="text-align:right" readonly onkeypress="return stabular(event,this)">  </div>   </span></td>
					</tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="949" >
                    <tr>
                      <td width="115"><span class="Estilo5"> NOMBRE BANCO :</span></span></td>
                      <td width="561"><span class="Estilo5"><input name="txtnombre_banco" type="text" id="txtnombre_banco" value="<?php echo $nombre_banco?>" size="80" maxlength="80" readonly onkeypress="return stabular(event,this)"> </span></td>
                      <td width="138"><span class="Estilo5"><div id="nnotad">N&Uacute;MERO NOTA DEBITO: </div></span></td>
                      <td width="115"><span class="Estilo5"><div id="nrondb"> <input class="Estilo10" name="txtnro_ndb" type="text" id="txtnro_ndb" size="10" maxlength="8"  value="<?php echo $nro_ndb?>" onFocus="encender(this)" onBlur="apaga_ndb(this)" onchange="chequea_ndb(this.form);">  </div>
                     </tr>
                  </table></td>
                </tr>
				
				 <tr>
                  <td height="14"><table width="861" >
                    <tr>
                      <td width="144"><span class="Estilo5">N&Uacute;MERO ORDEN : </span></td>
                      <td width="71"><span class="Estilo5"><input class="Estilo10" name="txtnro_orden" type="text" id="txtnro_orden" size="10" maxlength="8" onFocus="encender(this);" onBlur="apagar(this);" onchange="checkorden(this.form);" onkeypress="return stabular(event,this)">   </span></td>
                      <td width="71"><input class="Estilo10" name="btordenes" type="button" id="btordenes" title="Catalogo Ordenes de Pago" onClick="VentanaCentrada('Cat_orden_pago_ant_ndb.php?criterio=','SIPAP','','750','500','true')" value="...">   </td>
                      <td width="153"><span class="Estilo5">DOCUMENTO CAUSADO :</span></td>
                      <td width="35"><span class="Estilo5"><input class="Estilo10" name="txttipo_causado" type="text" id="txttipo_causado" size="4" maxlength="4"  readonly onkeypress="return stabular(event,this)">   </span></td>
                      <td width="77"><span class="Estilo5"><input class="Estilo10" name="txtnombre_abrev_caus" type="text" id="txtnombre_abrev_caus" size="5" maxlength="5" readonly onkeypress="return stabular(event,this)">  </span></td>
                      <td width="274"><span class="Estilo5"></span></td>
                    </tr>
                  </table></td>
                </tr>
				
                <tr> <td><table width="860">
                  <tr>
                    <td width="100"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                    <td width="140"><span class="Estilo5"> <input name="txtced_rif" type="text"  id="txtced_rif"  value="<?php echo $ced_rif?>" size="12" maxlength="12" readonly onkeypress="return stabular(event,this)"> </span> </td>
                    <td width="100"><span class="Estilo5">BENEFICIARIO : </span></td>
                    <td width="520"><span class="Estilo5"><input name="txtnombre_benef" type="text" id="txtnombre_benef"  value="<?php echo $nombre_benef?>" size="80" maxlength="80" readonly onkeypress="return stabular(event,this)"> </span></td>
                  </tr>
                 </table></td>
                </tr>
                <tr>
                  <td><table width="860">
                    <tr>
                      <td width="90"><span class="Estilo5">CONCEPTO :</span></td>
                      <td width="760"><span class="Estilo5">  <textarea name="txtconcepto" cols="93" onFocus="encender(this); " onBlur="apagar(this);" id="txtconcepto" onkeypress="return stabular(event,this)"></textarea></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr> <td><table width="952" >
                  <tr>
                    <td width="126"><span class="Estilo5">FECHA DE EMISI&Oacute;N :  </span></td>
                    <td width="210"><span class="Estilo5"> <input name="txtfecha" type="text" id="txtfecha"  value="<?php echo $fecha?>" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)"  onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                    <td width="152"><span class="Estilo5">MONTO DE LA NOTA :</span></td>
					<!-- -->
                    <td width="230"><span class="Estilo5"><input name="txtmonto_nota" type="text" id="txtmonto_nota" size="14" maxlength="14" style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" onKeypress="return validarNum(event)"> </span></td>
                    <td width="200"><span class="Estilo5"><input class="Estilo10" name="btcarga_comp" type="button" id="btcarga_comp" title="Genera Comprobante" onClick="javascript:Genera_comprobante(this.form)" value="Genera Comprobante">
                  </tr>
                </table></td> </tr>
          </table>
          <div id="T11" class="tab-body">
              <iframe src="Det_inc_comp_chq_ant.php?codigo_mov=<?php echo $codigo_mov?>" width="940" height="300" scrolling="auto" frameborder="1"></iframe>
          </div>
        <table width="957">
         <tr> <td>&nbsp;</td> </tr>
          <tr><td><table width="923">
            <td width="429"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
            <td width="193"><input name="Grabar" type="submit" id="Grabar" title="Emitir Nota de Debito" value="Grabar Nota de Debito"></td>
            <td width="138"><input name="Submit" type="reset" value="Blanquear"></td>
            <td width="143" valign="middle"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
          </table></td></tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>