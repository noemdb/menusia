<?include ("../class/seguridad.inc");include ("../class/conects.php");  include ("../class/funciones.php");include ("../class/configura.inc");
if (!$_GET){$continua="N";}else{$continua=$_GET["continua"];}  $fecha_hoy=asigna_fecha_hoy(); $equipo = getenv("COMPUTERNAME"); $mcod_m = "BAN004N".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="02-0000020"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if($SIA_Cierre=="N"){$error=0;}else{?><script language="JavaScript"> document.location='menu.php';</script><?} $fecha_fin=formato_ddmmaaaa($Fec_Fin_Ejer);  if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;}
if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICION ABIERTA'); document.location='menu.php';</script><?}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Emision Nota Debito)</title>
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
function apaga_banco(mthis){var mref; var fchq;
   apagar(mthis);
   mref=document.form1.txtcod_banco.value;  mref=Rellenarizq(mref,"0",4);  document.form1.txtcod_banco.value=mref; fchq=document.form1.txtfecha.value;
   ajaxSenddoc('GET', 'numndb.php?cod_banco='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nrondb', 'innerHTML');
   ajaxSenddoc('GET', 'versaldo.php?cod_banco='+mref+'&fecha='+fchq+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'msaldo', 'innerHTML');
return true;}
function chequea_banco(mform){var mref;
   mref=mform.txtcod_banco.value;  mref=Rellenarizq(mref,"0",4);  mform.txtcod_banco.value=mref;
   ajaxSenddoc('GET', 'numndb.php?cod_banco='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nrondb', 'innerHTML');
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
function chequea_fechachq(mform){var mref; var nndb; var fchq; var tpago; var mfechad; var mfechah;
   mref=mform.txtcod_banco.value;  mfechad=mform.txtfecha_desde.value;  mfechah=mform.txtfecha_hasta.value; nndb=mform.txtnro_ndb.value;  nndb=Rellenarizq(nndb,"0",8);  mform.txtnro_ndb.value=nndb; fchq=mform.txtfecha.value;  tpago=mform.txttipo_pago.value;
   ajaxSenddoc('GET', 'vbanndb.php?codigo_mov='+mcodigo_mov+'&cbanco='+mref+'&fechad='+mfechad+'&fechah='+mfechah+'&nndb='+nndb+'&fecha='+fchq+'&tpago='+tpago+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nnotad', 'innerHTML');
return true;}
function Cargar_Ordenes(mform){var mref; var mfechad; var mfechah; var nndb; var fchq; var tpago;
   mref=mform.txtcod_banco.value; mfechad=mform.txtfecha_desde.value;  mfechah=mform.txtfecha_hasta.value; nndb=mform.txtnro_ndb.value;  fchq=mform.txtfecha.value;  tpago=mform.txttipo_pago.value;
   if(mform.txtfecha_hasta.value.length==10){Valido=true;}  else{alert("Longitud de Fecha hasta Invalida");return false;}
   if(mform.txtfecha_desde.value.length==10){Valido=true;}  else{alert("Longitud de Fecha desde Invalida");return false;}
   ajaxSenddoc('GET', 'cargar_orden_chq.php?cod_banco='+mref+'&fechad='+mfechad+'&fechah='+mfechah+'&ncheque='+nndb+'&fecha='+fchq+'&tpago='+tpago+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'T11', 'innerHTML');
   ajaxSenddoc('GET', 'botonesndb.php?codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'criterios', 'innerHTML');
return true;}
function Emitir_notadb(){
   ajaxSenddoc('GET', 'criteriondb.php?codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'criterios', 'innerHTML');
}
function cancela_emit_ndb(){
   ajaxSenddoc('GET', 'botonesndb.php?codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'criterios', 'innerHTML');
}
function revisar(){var f=document.form1;
    if(f.txtcod_banco.value==""){alert("Codigo de Banco no puede estar Vacio");return false;}
    if(f.txtnombre_banco.value==""){alert("Nombre de Banco no puede estar Vacio");return false;} else{f.txtnombre_banco.value=f.txtnombre_banco.value.toUpperCase();}
    if(f.txtcod_banco.value.length==4){f.txtcod_banco.value=f.txtcod_banco.value.toUpperCase();} else{alert("Longitud Codigo de Banco Invalida");return false;}
        if((f.txtcant_ord.value=="0")||(f.txtcant_ord.value=="")){alert("Cantidad de Orden Invalida");return false;}
        if((f.txtmonto_ndb.value=="0")||(f.txtmonto_ndb.value=="")){alert("Monto de Nota debito Invalida");return false;}
document.form1.submit;
return true;}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 

</script>
</head>
<?
$tipo_pago="0003"; $nombre_abrev="NDB"; $cod_banco="0001"; $nro_cuenta=""; $nombre_banco=""; $nro_ndb="00000000"; $disponible=0;  $fecha=$fecha_hoy; $fecha_hasta=nextDate($fecha,30); $fecha_desde=prevDate($fecha,30);
$mconf="";  $Ssql="Select * from SIA005 where campo501='02'"; $resultado=pg_query($Ssql);if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $tipo_pago=$registro["campo507"];}
if($continua=="S"){$StrSQL="select * from ban030 where codigo_mov='$codigo_mov'"; $res=pg_query($StrSQL); $filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); $multiple=$registro["status_1"]; $cod_banco=$registro["cod_banco"]; $nro_ndb=$registro["num_cheque"]+1; $fecha=formato_ddmmaaaa($registro["fecha"]); $fecha_desde=formato_ddmmaaaa($registro["fecha_d"]); $fecha_hasta=formato_ddmmaaaa($registro["fecha_h"]);}
$sql="SELECT * FROM bancos where cod_banco='".$cod_banco."'"; $res=pg_query($sql);$filas=pg_num_rows($res); if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"];  $disponible=$registro["s_inic_libro"]; $nro_cuenta=$registro["nro_cuenta"]; $nro_ndb=$registro["num_nota"]+1; $len=strlen($nro_ndb); $nro_ndb=substr("00000000",0,8-$len).$nro_ndb;
$nmes=substr($fecha,3,2);  $m=$nmes*1; for ($i=1;$i<=$m;$i++){$spos=$i; If($i<=9){$spos="0".$spos;} $disponible=$disponible+$registro["deb_libro".$spos] - $registro["cre_libro".$spos]; }}  }
else{$resultado=pg_exec($conn,"SELECT BORRAR_PAG027('$codigo_mov')"); $merror=pg_errormessage($conn); $merror=substr($merror,0,91); $sql="SELECT * FROM bancos ORDER BY cod_banco"; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"];  $disponible=$registro["s_inic_libro"]; $nro_cuenta=$registro["nro_cuenta"]; $nro_ndb=$registro["num_nota"]+1; $len=strlen($nro_ndb); $nro_ndb=substr("00000000",0,8-$len).$nro_ndb; $nmes=substr($fecha,3, 2);  $m=$nmes*1; for ($i=1;$i<=$m;$i++){$spos=$i; If($i<=9){$spos="0".$spos;} $disponible=$disponible+$registro["deb_libro".$spos] - $registro["cre_libro".$spos]; } }
$sql="SELECT ACTUALIZA_BAN030(1,'$codigo_mov','$cod_banco','$nro_ndb','$tipo_pago','$fecha','$fecha_desde','$fecha_hasta','N','N','')"; $resultado=pg_exec($conn,$sql); $error=pg_errormessage($conn); $error=substr($error, 0, 61);}
pg_close(); $saldo=formato_monto($disponible);
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">EMISI&Oacute;N NOTA DEBITO A ORDENES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="601" border="1" id="tablacuerpo">
  <tr>
    <td width="890" height="600">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:951px; height:589px; z-index:1; top: 70px; left: 15px;">
        <form name="form1" method="post" action="Insert_ndb_orden.php" onSubmit="return revisar()">
          <table width="954" border="0" >
                <tr>
                  <td><table width="945">
                    <tr>
                      <td width="125"><span class="Estilo5">DOCUMENTO PAGO: </span></td>
                      <td width="30"><span class="Estilo5"><input class="Estilo10" name="txttipo_pago" type="text" id="txttipo_pago" readonly  value="<?echo $tipo_pago?>" size="4" maxlength="4"> </span></td>
                      <td width="70"><span class="Estilo5"><input class="Estilo10" name="txtnombre_abrev" type="text" id="txtnombre_abrev" size="5" maxlength="5"  value="<?echo $nombre_abrev?>" readonly>  </span> </td>
                      <td width="115"><span class="Estilo5">C&Oacute;DIGO BANCO:</span></td>
                      <td width="50"><span class="Estilo5"> <input class="Estilo10" name="txtcod_banco" type="text" id="txtcod_banco" size="5" maxlength="4"  value="<?echo $cod_banco?>" onFocus="encender(this)" onBlur="apaga_banco(this)" onchange="chequea_banco(this.form);" onkeypress="return stabular(event,this)">  </span> </td>
                      <td width="55"><input class="Estilo10" name="btcod_banco" type="button" id="btcod_banco" title="Abrir Catalogo de Bancos" onclick="VentanaCentrada('Cat_bancos.php?criterio=','SIA','','750','500','true')" value="..."></td>
                      <td width="100"><span class="Estilo5">NRO. CUENTA :</span></td>
                      <td width="240"><span class="Estilo5"> <input class="Estilo10" name="txtnro_cuenta" type="text" id="txtnro_cuenta" value="<?echo $nro_cuenta?>"  size="30" maxlength="25" readonly onkeypress="return stabular(event,this)"> </span></td>
					  <td width="45"><span class="Estilo5">SALDO:</span></td>
					  <td width="120"><span class="Estilo5"><div id="msaldo"> <input class="Estilo10" name="txtsaldo" type="text" id="txtsaldo" value="<?echo $saldo?>" size="15" maxlength="15" style="text-align:right" readonly onkeypress="return stabular(event,this)">  </div>   </span></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
              <table width="960" border="0">
                <tr>
                  <td><table width="949" >
                    <tr>
                      <td width="115"><span class="Estilo5"> NOMBRE BANCO :</span></span></td>
                      <td width="561"><span class="Estilo5"><input class="Estilo10" name="txtnombre_banco" type="text" id="txtnombre_banco" value="<?echo $nombre_banco?>" size="80" maxlength="80" readonly onkeypress="return stabular(event,this)">  </span></td>
                      <td width="138"><span class="Estilo5"><div id="nnotad">N&Uacute;MERO NOTA DEBITO: </div></span></td>
                      <td width="115"><span class="Estilo5"><div id="nrondb"> <input class="Estilo10" name="txtnro_ndb" type="text" id="txtnro_ndb" size="10" maxlength="8"  value="<?echo $nro_ndb?>" onFocus="encender(this)" onBlur="apaga_ndb(this)" onchange="chequea_ndb(this.form);" onkeypress="return stabular(event,this)">  </div>
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr> <td><table width="952" >
                  <tr>
                    <td width="126"><span class="Estilo5">FECHA DE EMISI&Oacute;N :  </span></td>
                    <td width="157"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text" id="txtfecha"  value="<?echo $fecha?>" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" onkeyup="mascara(this,'/',patronfecha,true)" onchange="chequea_fechachq(this.form);" onkeypress="return stabular(event,this)">    </span></td>
                    <td width="153"><span class="Estilo5">FECHA ORDENES DESDE :</span></td>
                    <td width="98"><span class="Estilo5"><input class="Estilo10" name="txtfecha_desde" type="text" id="txtfecha_desde" size="10" maxlength="10"  value="<?echo $fecha_desde?>" onFocus="encender(this)" onBlur="apagar(this)" onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return stabular(event,this)">  </span></td>
                    <td width="54"><span class="Estilo5">HASTA :</span></td>
                    <td width="207"><span class="Estilo5"><input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="10" maxlength="10"  value="<?echo $fecha_hasta?>" onFocus="encender(this)" onBlur="apagar(this)" onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return stabular(event,this)"> </span></td>
                    <td width="125"><span class="Estilo5"><input class="Estilo10" name="btcarga_ord" type="button" id="btcarga_ord" title="Cargar Ordenes de pago a Cancelar" onClick="javascript:Cargar_Ordenes(this.form)" value="Cargar Ordenes" >    </span></td>
                  </tr>
                </table></td> </tr>
          </table>
              <div id="T11" class="tab-body">
              <iframe src="Det_ordenes_canc.php?codigo_mov=<?echo $codigo_mov?>&orden=N&mostrar=S" width="940" height="350" scrolling="auto" frameborder="1"></iframe>
              </div>		
        <div id="criterios">
        <table width="957">
		   <tr> <td><table width="923" border="0"> <tr> <td height="10">&nbsp;</td> </tr> </table></td> </tr>
           <tr> <td><table width="923" border="0"> <tr> <td height="10">&nbsp;</td> </tr> </table></td> </tr>
           <tr><td><table width="923">
            <td width="329"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="100"><input name="txtconcepto" type="hidden" id="txtconcepto" value=""></td>
            <td width="193"><input name="btEmitir" type="button" id="btEmitir" value="Emitir Nota Debito" title="Emitir Nota Debito de Ordenes Seleccionadas" onclick="javascript:Emitir_notadb();"></td>
            <td width="138"><input name="Submit" type="reset" value="Blanquear"></td>
            <td width="143" valign="middle"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
          </table></td></tr>
                  <tr> <td>&nbsp;</td> </tr>
        </table>
                </div>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>