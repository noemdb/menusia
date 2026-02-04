<?php include ("../class/ventana.php"); include ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy(); $equipo=getenv("COMPUTERNAME");  $mcod_m="PRE023".$equipo;
  $codigo_mov=substr($mcod_m,0,49);  $fecha_hoy=asigna_fecha_hoy();   $codigo_mov=$_POST["txtcodigo_mov"]; $fecha=$_POST["txtfechad"]; $nomb_a_dif=$_POST["txtabrev_dif"];
  $user=$_POST["txtuser"];  $password=$_POST["txtpassword"];  $dbname=$_POST["txtdbname"]; $port=$_POST["txtport"]; $host=$_POST["txthost"]; 
  $nro_aut=$_POST["txtnro_aut"];  $fecha_aut=$_POST["txtfecha_aut"];  $ref_dife=$_POST["txtref_dif"]; $tipo_dife=$_POST["txttipo_dif"]; $concepto_r=$_POST["txtconcepto_r"];

  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Diferidos Presupuestario)</title>
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
function chequea_tipo(mform){ var mref;
   mref=mform.txttipo_diferido.value;   mref = Rellenarizq(mref,"0",4);   mform.txttipo_diferido.value=mref;
   if (mref == "0001" || mref=="A001" || mref.substring(0,1)=="A"){ alert("Tipo de Diferido No Aceptado"); return false;}
return true;}
function apaga_doc(mthis){var mref; var mnro_aut='S';
 apagar(mthis);
 mref=mthis.value; mref=Rellenarizq(mref,"0",4);
 ajaxSenddoc('GET', 'cargarefdif.php?tipo_dife='+mref+'&nro_aut='+mnro_aut, 'refer', 'innerHTML');
}
function checkreferencia(mform){var mref;
   mref=mform.txtreferencia_dife.value;   mref = Rellenarizq(mref,"0",8);   mform.txtreferencia_dife.value=mref;
return true;}
function checkrefecha(mform){var mref;var mfec;
  mref=mform.txtfecha.value;
  if(mform.txtfecha.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha.value=mfec;}
return true;}

function Llamar_Pegar_Diferido(){ var murl; murl="pegar_diferido.php?codigo_mov=<?php echo $codigo_mov?>"; document.location = murl;}
function revisar(){var f=document.form1; var Valido=true; var r;
    if(f.txtfecha.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtreferencia_dife.value==""){alert("Referencia no puede estar Vacio");return false;}
    if(f.txttipo_diferido.value==""){alert("Tipo de diferido no puede estar Vacio"); return false; }   else{f.txttipo_diferido.value=f.txttipo_diferido.value.toUpperCase();}
    if(f.txtDescripcion.value==""){alert("Descripcion del Movimiento no puede estar Vacia"); return false; }  else{f.txtDescripcion.value=f.txtDescripcion.value.toUpperCase();}
    if(f.txtreferencia_dife.value.length==8){f.txtreferencia_dife.value=f.txtreferencia_dife.value.toUpperCase();}   else{alert("Longitud de Referencia Invalida");return false;}
    if(f.txtfecha.value.length==10){Valido=true;} else{alert("Longitud de Fecha Invalida");return false;}
    if(f.txttipo_diferido.value=="0001" || f.txttipo_diferido.value=="A001" ) {alert("Tipo de Diferido No Aceptado");return false; }
	r=confirm("Desea Grabar el Diferido ?");  if (r==true) { valido=true;} else{return false;} 
document.form1.submit;
return true;}
</script>

</style>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR DIFERIDOS PRESUPUESTARIOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="507" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="492" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_diferidos.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_diferidos.php">Atras</A></td>
      </tr>
     <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Pegar_Diferido();">Pegar Diferido</A></td>
     </tr>	  
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:875px; height:495px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="Insert_diferidos.php" onSubmit="return revisar()">
      <table width="867" >
              <tr>
                <td>
                  <table width="830" align="center">
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><table width="813" border="0">
                        <tr>
                          <td width="105"><p><span class="Estilo5">TIPO DIFERIDO:</span></p>                          </td>
                          <td width="59"><input name="txttipo_diferido" type="text"  id="txttipo_diferido" size="6" maxlength="4"  onFocus="encender(this); " onBlur="apaga_doc(this)"    value="<?php echo $tipo_dife?>"  onchange="chequea_tipo(this.form);"></td>
                          <td width="44"><span class="Estilo5"> <input name="bttipo_dif" type="button" id="bttipo_dif" title="Abrir Catalogo Tipos de Diferido" onclick="VentanaCentrada('Cat_tipos_dif.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
                          <td width="104"><span class="Estilo5"> <input name="txtnombre_abrev_dife" type="text" id="txtnombre_abrev_dife" size="6"  value="<?php echo $nomb_a_dif?>"  readonly> </span></td>
                          <td width="91"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="189"><div id="refer"><input name="txtreferencia_dife" type="text"  id="txtreferencia_dife" size="12" onFocus="encender(this); " onBlur="apagar(this);" value="<?php echo $ref_dife?>" onchange="checkreferencia(this.form);"></div></td>
                          <td width="68"><span class="Estilo5">FECHA :</span> </td>
                          <td width="119"><span class="Estilo5"><input name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10" onFocus="encender(this); " onBlur="apagar(this);"  value="<?php echo $fecha?>" onchange="checkrefecha(this.form)">
                          </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="810" border="0">
                        <tr>
                          <td width="106"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                          <td width="694"><textarea name="txtDescripcion" cols="85" onFocus="encender(this); " onBlur="apagar(this);" class="headers" id="textarea"><?php echo $concepto_r?></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>  </td>
              </tr>
            </table>
        <iframe src="Det_inc_diferidos.php?codigo_mov=<?php echo $codigo_mov?>" width="850" height="300" scrolling="auto" frameborder="1">
        </iframe>
        <table width="863" border="0">
          <tr> <td height="10">&nbsp;</td> </tr>
        </table>
        <table width="768">
          <tr>
            <td width="664"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>