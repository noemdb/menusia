<?include ("../class/ventana.php"); include ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Formula Conceptos de Nomina Extraordinaria)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_nomina.value; mref = Rellenarizq(mref,"0",2); mform.txttipo_nomina.value=mref;
return true;}
function chequea_concepto(mform){ var mref;
 mref=mform.txtcod_concepto.value; mref = Rellenarizq(mref,"0",3); mform.txtcod_concepto.value=mref;  mform.txtcod_orden.value=mref;
}
function chequea_cons(mform){ var mref;
 mref=mform.txtconsecutivo.value; mref = Rellenarizq(mref,"0",3);  mform.txtconsecutivo.value=mref;
}
function revisar(){var f=document.form1; var valido;
    if(f.txttipo_nomina.value==""){alert("Tipo de Nomina no puede estar Vacio");return false;}else{f.txttipo_nomina.value=f.txttipo_nomina.value.toUpperCase();}
    if(f.txtcod_concepto.value==""){alert("Codigo de concepto no puede estar Vacia"); return false; } else{f.txtcod_concepto.value=f.txtcod_concepto.value.toUpperCase();}
    if(f.txtcod_concepto.value.length==3){valido=true;}else{alert("Longitud Codigo de Concepto Invalida");return false;}
document.form1.submit;
return true;}
function tabular(e,obj) {  tecla=(document.all) ? e.keyCode : e.which;  if(tecla!=13) return;  frm=obj.form;  
  for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }
  frm.elements[i+1].focus();
return false;} 
</script>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONSULTAR FORMULAS CONCEPTOS DE NOMINA EXTRAORDINARIA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="406" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="403"><table width="92" height="403" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_formula_ex.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_formula_ex.php">Atras</a></td>
     </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
     </tr>
   </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 75px; left: 110px;">
        <form name="form1" method="post" action="Busca_concepto_form.php" onSubmit="return revisar()">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="130"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></td>
                   <td width="60"><span class="Estilo5"> <input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="4" maxlength="2"onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_tipo(this.form);" onkeypress="return tabular(event,this)" > </span></td>
                   <td width="50"><input class="Estilo10" name="bttiponom" type="button" id="bttiponom" title="Abrir Catalogo Tipos de Nomina"  onClick="VentanaCentrada('Cat_tipo_nomina.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="645"><span class="Estilo5"> <input class="Estilo10" name="txtdes_nomina" type="text" id="txtdes_nomina" size="80" maxlength="100" readonly onkeypress="return tabular(event,this)" > </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="156"><span class="Estilo5">C&Oacute;DIGO DE CONCEPTO : </span></td>
                   <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto" type="text" id="txtcod_concepto" size="4" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_concepto(this.form);"> </span></td>
                   <td width="50"><input class="Estilo10" name="btconcepto" type="button" id="btconcepto" title="Abrir Catalogo Conceptos"  onClick="VentanaCentrada('Cat_conceptos.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="100"><span class="Estilo5">DENOMINACI&Oacute;N : </span></td>
                   <td width="500"><span class="Estilo5"> <input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="75" maxlength="75" readonly> </span></td>
                 </tr>
             </table></td>
            </tr>   
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="110" ><span class="Estilo5">CONSECUTIVO : </span></td>
                   <td width="600" ><span class="Estilo5"><input class="Estilo10" name="txtconsecutivo" type="text" id="txtconsecutivo" size="4" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)"  onchange="chequea_cons(this.form);" onkeypress="return tabular(event,this)"></span></td>
                   <td width="80" ><span class="Estilo5"></span></td>
                   <td width="76" ><span class="Estilo5"></td>
                 </tr>
             </table></td>
            </tr>
         </table>
         <p>&nbsp;</p>
         <table width="859">
                <tr>
                  <td width="64"><input name="txtdescripcion_ret" type="hidden" id="txtdescripcion_ret" value=""></td>
                  <td width="600">&nbsp;</td>
                  <td width="88"><input name="Buscar" type="submit" id="Buscar"  value="Buscar"></td>
                  <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
                </tr>
          </table>
         </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>