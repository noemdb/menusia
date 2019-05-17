<?include ("../class/ventana.php"); include ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy();
$tipo_nomina=$_POST["txttipo_nomina"]; $des_nomina=$_POST["txtdes_nomina"];  $fuente="00";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Conceptos de Nomina)</title>
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
function chequea_tipo(mform){
var mref;
   mref=mform.txttipo_nomina.value; mref = Rellenarizq(mref,"0",2); mform.txttipo_nomina.value=mref;
return true;}
function chequea_concepto(mform){ var mref;
 mref=mform.txtcod_concepto.value; mref = Rellenarizq(mref,"0",3); mform.txtcod_concepto.value=mref;  mform.txtcod_orden.value=mref;
}
function chequea_orden(mform){ var mref;
 mref=mform.txtcod_orden.value; mref = Rellenarizq(mref,"0",3);  mform.txtcod_orden.value=mref;
}

function checktipoconc(mform){var mref;
   mref=mform.txttipo_concepto.value;
   if(mref=="DEDUCCION"){  mform.txtcod_retencion.value=""; }
}

function revisar(){var f=document.form1; var valido;
    if(f.txttipo_nomina.value==""){alert("Tipo de Nomina no puede estar Vacio");return false;}else{f.txttipo_nomina.value=f.txttipo_nomina.value.toUpperCase();}
    if(f.txtdenominacion.value==""){alert("Denominacion no puede estar Vacia"); return false; } else{f.txtdenominacion.value=f.txtdenominacion.value.toUpperCase();}
    if(f.txtcod_concepto.value==""){alert("Codigo de concepto no puede estar Vacia"); return false; } else{f.txtcod_concepto.value=f.txtcod_concepto.value.toUpperCase();}
    if(f.txtcod_concepto.value.length==3){valido=true;}else{alert("Longitud Codigo de Concepto Invalida");return false;}
document.form1.submit;
return true;}
function tabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;
  if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus();
return false;} 
</script>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR CONCEPTOS DE NOMINA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="406" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="403"><table width="92" height="403" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_concep_ar.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_concep_ar.php">Atras</a></td>
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
        <form name="form1" method="post" action="Insert_concepto.php" onSubmit="return revisar()">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="130"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></td>
                   <td width="60"><span class="Estilo5"> <input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="4" maxlength="2"onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_tipo(this.form);" value="<?echo $tipo_nomina?>" onkeypress="return tabular(event,this)"> </span></td>
                   <td width="50"><input class="Estilo10" name="bttiponom" type="button" id="bttiponom" title="Abrir Catalogo Tipos de Nomina"  onClick="VentanaCentrada('Cat_tipo_nomina.php?criterio=','SIA','','750','500','true')" value="..."  onkeypress="return tabular(event,this)"> </span></td>
                   <td width="645"><span class="Estilo5"> <input class="Estilo10" name="txtdes_nomina" type="text" id="txtdes_nomina" size="80" maxlength="100" readonly value="<?echo $des_nomina?>"  onkeypress="return tabular(event,this)"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="156"><span class="Estilo5">C&Oacute;DIGO DE CONCEPTO : </span></td>
                   <td width="90"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto" type="text" id="txtcod_concepto" size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_concepto(this.form);"  onkeypress="return tabular(event,this)"> </span></td>
                   <td width="100"><span class="Estilo5">DENOMINACI&Oacute;N : </span></td>
                   <td width="520"><span class="Estilo5"> <input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="65" maxlength="80" onFocus="encender(this)" onBlur="apagar(this)"  onkeypress="return tabular(event,this)"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="150"><span class="Estilo5">C&Oacute;DIGO DE PARTIDA : </span></td>
                   <td width="145"><span class="Estilo5"> <input class="Estilo10" name="txtcod_partida" type="text" id="txtcod_partida" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)"  onkeypress="return tabular(event,this)"> </span></td>
                   <td width="40"><input class="Estilo10" name="btcodpart" type="button" id="btcodpart" title="Abrir Catalogo Partidas"  onClick="VentanaCentrada('Cat_codigos_par.php?criterio=','SIA','','750','500','true')" value="..."  onkeypress="return tabular(event,this)"> </span></td>
                   <td width="121"><span class="Estilo5">FUENTE : <span class="Estilo5"><input class="Estilo10" name="txtfuente" type="text" id="txtfuente" size="2" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fuente?>" onkeypress="return tabular(event,this)">  </span></td>
				   <td width="210"><span class="Estilo5">CODIGO DE CATEGORIA ALTERNA : </span></td>
                   <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtcod_cat_alter" type="text" id="txtcod_cat_alter" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)"  onkeypress="return tabular(event,this)"> </span></td>
                   <td width="50"><input class="Estilo10" name="btcodcat" type="button" id="btcodcat" title="Abrir Catalogo Categorias"  onClick="VentanaCentrada('Cat_codigos_cat.php?criterio=','SIA','','750','500','true')" value="..."  onkeypress="return tabular(event,this)"> </span></td>

                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="150"><span class="Estilo5">TIPO DE CONCEPTO : </span></td>
                   <td width="366"><span class="Estilo5"><select class="Estilo10" name="txttipo_concepto" size="1" id="txttipo_concepto" onFocus="encender(this)" onBlur="apagar(this)" onchange="checktipoconc(this.form);" onkeypress="return tabular(event,this)">
                      <option>ASIGNACION</option> <option>DEDUCCION</option> <option>APORTE</option> </select>  </span></td>
                   <td width="150"><span class="Estilo5">TIPO DE ASIGNACI&Oacute;N : </span></td>
                   <td width="200"><span class="Estilo5"><select class="Estilo10" name="txttipo_asigna" size="1" id="txttipo_asigna" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)">
                      <option>SUELDO</option> <option>COMPENSACION</option> <option>PRIMA</option> <option>OTRO</option> </select>  </span></td>

                  </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="216" ><span class="Estilo5">CONCEPTO AFECTA PRESUPUESTO : </span></td>
                   <td width="110"><span class="Estilo5"><select class="Estilo10" name="txtafecta_presup" size="1" id="txtafecta_presup" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><option>SI</option> <option>NO</option></select>  </span></td>
                   <td width="180" ><span class="Estilo5">C&Oacute;DIGO TIPO DE RETENCI&Oacute;N : </span></td>
                   <td width="60" ><span class="Estilo5"><input class="Estilo10" name="txtcod_retencion" type="text" id="txtcod_retencion" size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" value="000"  onkeypress="return tabular(event,this)"> </span></td>
                   <td width="60"><input class="Estilo10" name="bttiporet" type="button" id="bttiporet" title="Abrir Catalogo Tipos de Retencion"  onClick="VentanaCentrada('Cat_tipo_ret.php?criterio=','SIA','','750','500','true')" value="..."  onkeypress="return tabular(event,this)"> </span></td>
                   <td width="150"><span class="Estilo5">C&Oacute;DIGO DE APORTE : </span></td>
                   <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtcod_aporte" type="text" id="txtcod_aporte" size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_aporte(this.form);"   value="000"  onkeypress="return tabular(event,this)"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="75"><span class="Estilo5">ACTIVO : </span></td>
                   <td width="105"><span class="Estilo5"><select class="Estilo10" name="txtactivo" size="1" id="txtactivo" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><option>SI</option> <option>NO</option></select>  </span></td>
                   <td width="75"><span class="Estilo5">OCULTO : </span></td>
                   <td width="105"><span class="Estilo5"><select class="Estilo10" name="txtoculto" size="1" id="txtoculto" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><option>NO</option> <option>SI</option></select>  </span></td>
                   <td width="155" ><span class="Estilo5">MONTO INICIALIZABLE : </span></td>
                   <td width="105"><span class="Estilo5"><select class="Estilo10" name="txtinicializable" size="1" id="txtinicializable" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><option>NO</option> <option>SI</option></select>  </span></td>
                   <td width="166" ><span class="Estilo5">CANTIDAD INICIALIZABLE : </span></td>
                   <td width="80"><span class="Estilo5"><select class="Estilo10" name="txtinicializable_c" size="1" id="txtinicializable_c" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><option>NO</option> <option>SI</option></select>  </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="150"><span class="Estilo5">ACUMULA HISTORICO : </span></td>
                   <td width="100"><span class="Estilo5"><select class="Estilo10" name="txtacumula" size="1" id="txtacumula" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><option>SI</option> <option>NO</option></select>  </span></td>
                   <td width="260"><span class="Estilo5">INTERVIENE EN CALCULO DE VACACIONES : </span></td>
                   <td width="100"><span class="Estilo5"><select class="Estilo10" name="txtcal_vac" size="1" id="txtcal_vac" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><option>SI</option> <option>NO</option></select>  </span></td>
                   <td width="120" ><span class="Estilo5">TIPO DE GRUPO : </span></td>
                   <td width="80" ><span class="Estilo5"> <input class="Estilo10" name="txttipo_grupo" type="text" id="txttipo_grupo" size="4" maxlength="1" onFocus="encender(this)" onBlur="apagar(this)" value="1" onkeypress="return tabular(event,this)"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
            <td><table width="866">
                 <tr>
                   <td width="90"><span class="Estilo5">FRECUENCIA : </span></td>
                   <td width="310"><span class="Estilo5"><select class="Estilo10" name="txtfrecuencia" size="1" id="txtfrecuencia" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)">
                      <option>PRIMERA QUINCENA</option> <option>SEGUNDA QUINCENA</option> <option>PRIMERA Y SEGUNDA QUINCENA</option>
                      <option>PRIMERA SEMANA</option> <option>SEGUNDA SEMANA</option> <option>TERCERA SEMANA</option> <option>CUARTA SEMANA</option>
                      <option>QUINTA SEMANA</option>  <option>TODAS LAS SEMANAS</option> <option>ULTIMA SEMANA</option> </select>  </span></td>
                   <td width="166"><span class="Estilo5">CONCEPTO DE PRESTAMO : </span></td>
                   <td width="90"><span class="Estilo5"><select class="Estilo10" name="txtprestamo" size="1" id="txtprestamo" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><option>NO</option> <option>SI</option></select>  </span></td>
                   <td width="130"><span class="Estilo5">ORDEN DE C&Aacute;LCULO : </span></td>
                   <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtcod_orden" type="text" id="txtcod_orden" size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_orden(this.form);" onkeypress="return tabular(event,this)"></span></td>
                 </tr>
             </table></td>
           </tr>
         </table>
         <p>&nbsp;</p>
         <table width="859">
                <tr>
                  <td width="64"><input class="Estilo10" name="txtdescripcion_ret" type="hidden" id="txtdescripcion_ret" value=""></td>
                  <td width="600">&nbsp;</td>
                  <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
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