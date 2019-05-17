<?include ("../class/seguridad.inc");include ("../class/conects.php");  include ("../class/funciones.php");
if (!$_GET){$continua="N";}else{$continua=$_GET["continua"];}  $fecha_hoy=asigna_fecha_hoy();
$equipo = getenv("COMPUTERNAME"); $mcod_m = "PRE008N".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="02-0000020"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); 
if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Cancelacion Ordenes de Pago)</title>
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
function checkreferencia(mform){var mref;
   mref=mform.txtreferencia_pago.value; mref = Rellenarizq(mref,"0",8);  mform.txtreferencia_pago.value=mref;
return true;}
function checkrefecha(mform){var mref; var mfec;  mref=mform.txtfecha.value;
  if(mform.txtfecha.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);    mform.txtfecha.value=mfec;}
return true;}
function Cargar_Cod_Caus(mform){var mref;  mref=mform.txtnro_orden.value; 
   ajaxSenddoc('GET', 'cargacodord.php?criterio='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'codcaus', 'innerHTML');
   ajaxSenddoc('GET', 'cargadesord.php?criterio='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'desp', 'innerHTML');
 return true;}
function revisar(){var f=document.form1; var Valido=true; var r;
    if(f.txtfecha_emi.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtreferencia_pago.value==""){alert("Referencia no puede estar Vacia");return false;}
     else{f.txtreferencia_pago.value=f.txtreferencia_pago.value;}
    if(f.txtdescripcion.value==""){alert("Descripción del pago no puede estar Vacia"); return false; }
      else{f.txtdescripcion.value=f.txtdescripcion.value.toUpperCase();}
    if(f.txtreferencia_pago.value.length==8){f.txtreferencia_pago.value=f.txtreferencia_pago.value.toUpperCase();f.txtreferencia_pago.value=f.txtreferencia_pago.value;}
      else{alert("Longitud de Referencia Invalida");return false;}
    if(f.txtfecha_emi.value.length==10){Valido=true;}
      else{alert("Longitud de Fecha Invalida");return false;}
    if(f.txttipo_pago.value=="0000" || f.txttipo_pago.value=="A000" ) {alert("Tipo de pago No Aceptado");return false; }
    if(f.txtnro_orden.value==""){alert("Numero de Orden no puede estar Vacio");return false;}
      else{f.txtnro_orden.value=f.txtnro_orden.value;}
	r=confirm("Desea Registrar la Cancelacion de la Orden de Pago ?");  if (r==true) { valido=true;} else{return false;}   
document.form1.submit;
return true;}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 

</script>
</head>
<?
$tipo_pago="0003"; $nombre_abrev="NDB"; $cod_banco="0001"; $nro_cuenta=""; $nombre_banco=""; $nro_ndb="00000000"; $fecha=$fecha_hoy; $fecha_hasta=nextDate($fecha,30); $fecha_desde=prevDate($fecha,30);
$mconf="";  $Ssql="Select * from SIA005 where campo501='02'"; $resultado=pg_query($Ssql);if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $tipo_pago=$registro["campo507"];}
$res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
pg_close();
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CANCELACI&Oacute;N ORDENES DE PAGO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="601" border="1" id="tablacuerpo">
  <tr>
    <td width="890" height="600">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:951px; height:589px; z-index:1; top: 70px; left: 15px;">
        <form name="form1" method="post" action="Insert_canc_orden.php" onSubmit="return revisar()">
          <table width="954" border="0" >
                <tr>
                  <td><table width="945">
                    <tr>
                      <td width="125"><span class="Estilo5">DOCUMENTO PAGO: </span></td>
                      <td width="30"><span class="Estilo5"><input class="Estilo10" name="txttipo_pago" type="text" id="txttipo_pago" readonly  value="<?echo $tipo_pago?>" size="4" maxlength="4" onkeypress="return stabular(event,this)"> </span></td>
                      <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtnombre_abrev" type="text" id="txtnombre_abrev" size="5" maxlength="5"  value="<?echo $nombre_abrev?>" readonly onkeypress="return stabular(event,this)">  </span> </td>
                      <td width="118"><span class="Estilo5">REFERENCIA :</span> </td>
                      <td width="172"><div id="refpago"><input class="Estilo10" name="txtreferencia_pago" type="text"  id="txtreferencia_pago" size="12" maxlength="8" onFocus="encender(this); " onBlur="apagar(this);"  onchange="checkreferencia(this.form);" onkeypress="return stabular(event,this)"></div></td>
                      <td width="135"><span class="Estilo5">FECHA :</span> </td>
                      <td width="249"><span class="Estilo5"><input class="Estilo10" name="txtfecha_emi" type="text" id="txtfecha_emi" size="12" maxlength="10" onFocus="encender(this); " onBlur="apagar(this);"  value="<?echo $fecha_hoy?>" onchange="checkrefecha(this.form)"  onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return stabular(event,this)">                          </span></td>
						  
					            </tr>
                  </table></td>
                </tr>
				<tr>
                  <td width="883" height="14"><table width="861">
                    <tr>
                      <td width="156"><span class="Estilo5">N&Uacute;MERO DE ORDEN : </span></td>
                      <td width="77"><span class="Estilo5"><input class="Estilo10" name="txtnro_orden" type="text" id="txtnro_orden" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" onchange="checkorden(this.form);" onkeypress="return stabular(event,this)"> </span></td>
                      <td width="91"><input class="Estilo10" name="btordenes" type="button" id="btordenes" title="Catalogo Ordenes de Pago" onClick="VentanaCentrada('../pagos/Cat_ord_pago.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"> </td>
                      <td width="92"><span class="Estilo5">FECHA ORDEN:</span></td>
                      <td width="279"><span class="Estilo5"> <input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="10" maxlength="10" readonly onkeypress="return stabular(event,this)"></span></td>
                      <td width="187"><span class="Estilo5"> <input type="button" name="btcarga_ret" value="Cargar Codigos de la Orden" title="Cargar Codigos de la Orden de pago" onClick="javascript:Cargar_Cod_Caus(this.form)" onkeypress="return stabular(event,this)"> </span></td>
                    </tr>
                  </table></td>
                </tr>
				 <tr>
                      <td><table width="845">
                        <tr>
                          <td width="160"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                          <td width="120"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="15" readonly onkeypress="return stabular(event,this)">  </span></td>
                          <td width="550"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="90" readonly onkeypress="return stabular(event,this)"></span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="827" border="0">
                        <tr>
                          <td width="106"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                          <td width="694"><div id="desp"><textarea name="txtdescripcion" cols="85" onFocus="encender(this); " onBlur="apagar(this);" class="headers" id="txtdescripcion" onkeypress="return stabular(event,this)"></textarea> </div></td>
                        </tr>
                      </table></td>
                    </tr>
          </table>
          <div id="codcaus">
             <iframe src="../presupuesto/Det_inc_pagos_caus.php?codigo_mov=<?echo $codigo_mov?>" width="950" height="300" scrolling="auto" frameborder="1" >
             </iframe>
          </div>
                <div id="criterios">
        <table width="957">
                  <tr> <td><table width="923" border="0"> <tr> <td height="10">&nbsp;</td> </tr> </table></td> </tr>
                  <tr> <td><table width="923" border="0"> <tr> <td height="10">&nbsp;</td> </tr> </table></td> </tr>
          <tr><td><table width="923">
            <td width="229"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="100"><input name="txtconcepto" type="hidden" id="txtconcepto" value=""></td>
			<td width="100"><input name="txtrefiereA" type="hidden" id="txtrefiereA" value="CAUSADO"></td>
			<td width="193" valign="middle"><input name="button" type="submit" id="button"  value="Registrar Cancelacion" title="Registrar Cancelacion de Orden"></td>
            <td width="138"><input name="Submit" type="reset" value="Blanquear"></td>
            <td width="143" valign="middle"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
          </table></td></tr>
        </table>
                </div>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>