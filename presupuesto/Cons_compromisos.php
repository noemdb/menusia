<?include ("../class/ventana.php"); include ("../class/fun_fechas.php");
  if (!$_GET){ $referencia_comp=""; $tipo_compromiso=""; $nombre_abrev_comp=""; } else { $referencia_comp=$_GET["referencia_comp"]; $tipo_compromiso=$_GET["tipo_compromiso"]; $nombre_abrev_comp=$_GET["nombre_abrev_comp"]; }
  $equipo = getenv("COMPUTERNAME");  $mcod_m = "PRE006".$equipo; $cod_tipo_comp="000000"; $des_tipo_comp="COMPROMISOS";
  $codigo_mov=substr($mcod_m,0,49);  $fecha_hoy=asigna_fecha_hoy();  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Compromisos Presupuestario)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_comp.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
function Llamar_Inc_comp(){ document.form2.submit();}
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_compromiso.value;  mref=Rellenarizq(mref,"0",4);    mform.txttipo_compromiso.value=mref;
 return true;}
function apaga_doc(mthis){var mref;
 apagar(mthis); mref=mthis.value; mref=Rellenarizq(mref,"0",4); }
function checkreferencia(mform){var mref;
   mref=mform.txtreferencia_comp.value;   mref = Rellenarizq(mref,"0",8);   mform.txtreferencia_comp.value=mref;
return true;}
function revisar(){var f=document.form1;var Valido=true;
    if(f.txtreferencia_comp.value==""){alert("Referencia no puede estar Vacio"); f.txtreferencia_comp.focus(); return false;}
    if(f.txttipo_compromiso.value==""){alert("Tipo de Compromiso no puede estar Vacio"); f.txttipo_compromiso.focus();  return false; } else{f.txttipo_compromiso.value=f.txttipo_compromiso.value.toUpperCase();}
    document.form1.submit;
return true;}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 
</script>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONSULTAR COMPROMISOS PRESUPUESTARIOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="307" border="0" id="tablacuerpo">
  <tr>
    <td><table width="92" height="305" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tablamenu">
        <td width="86">
      <td>
      <table width="92" height="305" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_compromisos.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_compromisos.php">Atras</A></td>
      </tr>      
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
           onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
      </tr>
    <tr>
       <td>&nbsp;</td>
     </tr>
    </table></td>
        </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:874px; height:300px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="consult_comp.php" onSubmit="return revisar()">
      <table width="869" >
	          <tr> <td>&nbsp;</td>  </tr>
              <tr>
                <td>
                  <table width="866" align="center">
                    <tr>
                      <td><table width="832" border="0">
                        <tr>
                          <td width="168"><span class="Estilo5">DOCUMENTO COMPROMISO:</span></td>
                          <td width="43"><input name="txttipo_compromiso" type="text"  id="txttipo_compromiso" size="6" maxlength="4" onFocus="encender(this);" onBlur="apaga_doc(this)"  onchange="chequea_tipo(this.form);" onkeypress="return stabular(event,this)" value="<?echo $tipo_compromiso?>"></td>
                          <td width="41"><span class="Estilo5"><input name="btdoc_comp" type="button" id="btdoc_comp" title="Abrir Catalogo Documentos Compromiso" onClick="VentanaCentrada('Cat_doc_comp.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">   </span></td>
                          <td width="93"><span class="Estilo5"><input name="txtnombre_abrev_comp" type="text" id="txtnombre_abrev_comp" size="6" readonly value="<?echo $nombre_abrev_comp?>" onkeypress="return stabular(event,this)">   </span></td>
                          <td width="87"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="170"><div id="refer"><input name="txtreferencia_comp" type="text" id="txtreferencia_comp" size="12" maxlength="8" onFocus="encender(this);" onBlur="apagar(this);" value="<?echo $referencia_comp?>" onchange="checkreferencia(this.form);" onkeypress="return stabular(event,this)"></div></td>
                          <td width="177"><span class="Estilo5">  </span></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>  </td>
              </tr>
			  <tr> <td>&nbsp;</td>  </tr>
			  <tr> <td>&nbsp;</td>  </tr>
          </table>
        <table width="768">
          <tr>
            <td width="664"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Buscar"></td>
            <td width="88"><input name="Submit" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>

</table>
</body>
</html>