<?php include ("../class/fun_fechas.php"); include ("../class/ventana.php");
 $codigo_mov=$_POST["txtcodigo_mov"];  $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"];  
 $ced_r=$_POST["txtced_r"]; $nomb_r=$_POST["txtnomb"]; $tipo_asiento="AJC";$fecha_hoy=asigna_fecha_hoy(); 
 $fecha_fin=formato_ddmmaaaa($_POST["txtfecha_fin"]);  if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha=$fecha_fin;}else{$fecha=$fecha_hoy;} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD FISCAL (Incluir Coprobantes Contables)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<SCRIPT language="javascript"  src="../class/sia.js"  type="text/javascript"></script>
<script language="javascript" src="../class/cal2.js"></script>
<script language="javascript" src="../class/cal_conf2.js"></script>
<script language="javascript" src="ajax_comp.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
function LlamarURL(url){  document.location = url; }
function checkreferencia(mform){ var mref;
   mref=mform.txtReferencia.value;    mref = Rellenarizq(mref,"0",8);     mform.txtReferencia.value=mref;
return true;}
function checkrefecha(mform){var mref; var mfec;  mref=mform.txtFecha.value;
  if(mform.txtFecha.value.length==8){mfec=mref.substring(0,6)+"20"+ mref.charAt(6)+mref.charAt(7); mform.txtFecha.value=mfec;}
return true;}
function apaga_tipo(mthis){var mtipop; var mfec;  
   mtipop=document.form1.txttipo_asiento.value; mfec=document.form1.txtFecha.value;
   ajaxSenddoc('GET', 'numcomp.php?fecha='+mfec+'&tipo='+mtipop+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'rdoc', 'innerHTML');
apagar(mthis);  }
function revisar(){var f=document.form1; var Valido=true;
    if(f.txtFecha.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtReferencia.value==""){alert("Referencia no puede estar Vacio");return false;}
    if(f.txtDescripcion.value==""){alert("Descripcion del Comprobante no puede estar Vacia"); return false; }    else{f.txtDescripcion.value=f.txtDescripcion.value.toUpperCase();}
    if(f.txttipo_asiento.value==""){alert("Tipo de Asiento no puede estar Vacio"); return false; } else{f.txttipo_asiento.value=f.txttipo_asiento.value.toUpperCase();}
    if(f.txtced_rif.value==""){alert("Cedula/Rif del Beneficiario no puede estar Vacia"); return false; }  else{f.txtced_rif.value=f.txtced_rif.value.toUpperCase();}
    if(f.txtReferencia.value.length==8){f.txtReferencia.value=f.txtReferencia.value.toUpperCase();}  else{alert("Longitud de Referencia Invalida");return false;}
    if(f.txtFecha.value.length==10){Valido=true;} else{alert("Longitud de Fecha Invalida");return false;}
    if(f.txttipo_asiento.value=="ANU" || f.txttipo_asiento.value=="ANC" || f.txttipo_asiento.value=="AND") {alert("Tipo de Asiento No Aceptado");return false; }
	r=confirm("Desea Grabar el Comprobante Contable ?");  if (r==true) {valido=true;} else{return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 10px}
-->
</style>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR COMPROBANTES CONTABLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="535" border="1">
  <tr>
    <td width="92"><table width="92" height="525" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_comprobantes.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="Act_comprobantes.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="menu.php">Menu Principal</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:355px; z-index:1; top: 70px; left: 116px;">
      <form name="form1" method="post" action="Insert_comprobantes.php" onSubmit="return revisar()">
        <table width="858" border="0">
          <tr>
            <td width="157"><span class="Estilo5">FECHA : <input class="Estilo10" name="txtFecha" type="text" id="txtFecha" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha?>" size="12" maxlength="10" onchange="checkrefecha(this.form)"> </span> </td>
            <td width="125"><img src="../imagenes/img_cal.png" width="20" height="14" id="calendario3" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha" onmouseover="this.style.background='blue';" onmouseout="this.style.background=''"  onClick="javascript:showCal('Calendario3')"  /></td>
            <td width="170"><span class="Estilo5">TIPO ASIENTO:</span>
              <input class="Estilo10" name="txttipo_asiento" id="txttipo_asiento" size="5" maxlength="3" onFocus="encender(this)" onBlur="apaga_tipo(this)" value="<?echo $tipo_asiento?>" ></td>
            <td width="110"><input type="button" name="Submit" value="..." title="Abrir Catalogo Tipos de Asientos" onclick="VentanaCentrada('Cat_tipo_asiento.php?criterio=','SIA','','650','500','true')"></td>
			<td width="100"><span class="Estilo5">REFERENCIA :</span></td>
			<td width="174"><span class="Estilo5"> <div id="rdoc"><input class="Estilo10" name="txtReferencia" type="text"  id="txtReferencia" size="10" maxlength="8" onFocus="encender(this)" onBlur="apagar(this)"  onchange="checkreferencia(this.form)"></div> </span></td>
        
          </tr>
        </table>
		<script language="JavaScript" type="text/JavaScript">
		    mtipop=document.form1.txttipo_asiento.value; mfec=document.form1.txtFecha.value;
            ajaxSenddoc('GET', 'numcomp.php?fecha='+mfec+'&tipo='+mtipop+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'rdoc', 'innerHTML');
        </script>
        <table width="854">
          <tr>
            <td width="155"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
            <td width="101"><span class="Estilo5"> <div id="drif"><input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="15" onFocus="encender(this); " onBlur="apagar(this);" onchange="checkcedrif(this.form);" value="<?echo $ced_r?>"> </div> </span></td>
            <td width="44"><span class="Estilo5"><input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('Cat_Benef_comp.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
            <td width="529"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="84" readonly value="<?echo $nomb_r?>"> </span></td>
          </tr>
        </table>
        <table width="859" border="0">
          <tr>
            <td width="141"><span class="Estilo5">DESCRIPCION :</span></td>
            <td width="708"><textarea name="txtDescripcion" cols="80" id="txtDescripcion" onFocus="encender(this)" onBlur="apagar(this)"  maxlength="500"></textarea></td>
          </tr>
        </table>
        <table width="863" border="0">
          <tr>
            <td height="10">&nbsp;</td>
            </tr>
        </table>
        <iframe src="Det_inc_comprobantes.php?codigo_mov=<?echo $codigo_mov?>"  width="850" height="300" scrolling="auto" frameborder="1">
        </iframe>
        <table width="863" border="0">
          <tr>
            <td height="10">&nbsp;</td>
            </tr>
        </table>
        <table width="768">
          <tr>
            <td width="664"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </form>
    </div>
  </tr>
</table>
</body>
</html>