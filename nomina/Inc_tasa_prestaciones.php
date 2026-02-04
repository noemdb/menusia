<?include ("../class/ventana.php"); include ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy(); $fecha_desde=$fecha_hoy;
$fecha_desde=$_POST["txtufecha"];  $numero=$_POST["txtunumero"];
$fecha_desde=nextDate($fecha_desde,1); $fecha_hasta=colocar_udiames($fecha_desde); $numero=$numero+1; if(strlen($numero)<6){ $p=strlen($numero); $p=6-$p; $rellena="000000"; $rellena=substr($rellena,0,$p); $numero=$rellena.$numero;}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Incluir Tasa Interes Prestaciones)</title>
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
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function daformatomonto (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){if ((monto.charAt(i) == '.')){str2 = str2 + ",";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9')) || (monto.charAt(i) == '-') || (monto.charAt(i) == ',') ) {str2 = str2 + monto.charAt(i);} } }
return str2;}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function quitacomas (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == ',')){str2 = str2 + ".";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9')) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;
}
function cambia_punto_coma (monto){var i;var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == ',')){str2 = str2 + ",";} else{if (monto.charAt(i) == '.'){str2 = str2 + ',';}else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } } }
   return str2;}   
function apaga_monto(mthis){var mmonto;  apagar(mthis); mmonto=mthis.value;  mmonto=daformatomonto(mmonto);   mthis.value=mmonto; } 
function encender_monto(mthis){var mmonto; encender(mthis);   mmonto=mthis.value;  mmonto=eliminapunto(mmonto);  mthis.value=mmonto;  }
function chequea_numero(mform){ var mref;
 mref=mform.txtnumero.value; mref = Rellenarizq(mref,"0",6); mform.txtnumero.value=mref;
return true;}
function revisar(){
var f=document.form1;
    if(f.txtnumero.value==""){alert("Numero de Gaceta no puede estar Vacio");return false;}else{f.txtnumero.value=f.txtnumero.value.toUpperCase();}
    if(f.txtfecha_desde.value==""){alert("Fecha desde estar Vacia"); return false; }
    if(f.txtfecha_hasta.value==""){alert("Fecha hasta no puede estar Vacio"); return false; }
    if(f.txttasa.value==""){alert("Tasa no puede estar Vacia"); return false; }
document.form1.submit;
return true;}
</script>  
</head>
<body>
<table width="978" height="52" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR TASA INTERESES DE PRESTACIONES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="348" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="348"><table width="92" height="346" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_tasa_inte_pres_ar.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_tasa_inte_pres_ar.php">Atras</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
      </tr>
      <tr><td>&nbsp;</td>  </tr>
    </table></td>
    <td width="870">       <div id="Layer1" style="position:absolute; width:833px; height:248px; z-index:1; top: 93px; left: 121px;">
      <form name="form1" method="post" action="Insert_tasa_presta.php" onSubmit="return revisar()">
        <table width="868" border="0" align="center" >
          <tr>
            <td><table width="866">
                <tr>
                  <td width="200" ><span class="Estilo5">N&Uacute;MERO DE GACETA :  </span></td>
                  <td width="666" ><span class="Estilo5"> <input class="Estilo10" name="txtnumero" type="text" id="txtnumero" size="8" maxlength="6"  onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_numero(this.form);" value="<?echo $numero?>"> </span></td>
                </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td></tr>
          <tr>
             <td><table width="866">
               <tr>
                 <td width="200" ><span class="Estilo5">FECHA DESDE : </span></td>
                 <td width="236" ><span class="Estilo5"> <input class="Estilo10" name="txtfecha_desde" type="text" id="txtfecha_desde" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_desde?>"> </span></td>
                 <td width="200" ><span class="Estilo5">FECHA HASTA : </span></td>
                 <td width="230" ><span class="Estilo5"> <input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hasta?>"> </span></td>
               </tr>
             </table></td>
          </tr>
          <tr> <td>&nbsp;</td></tr>
          <tr>
            <td><table width="866">
                <tr>
                  <td width="200" ><span class="Estilo5">TASA PROMEDIO :</span></td>
                  <td width="666" ><span class="Estilo5"> <input class="Estilo10" name="txttasa" type="text" id="txttasa" size="6" maxlength="5"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="0"  onKeypress="return validarNum(event)" > </span></td>
                </tr>
            </table></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </div>
      </form>
    </td>
  </tr>
</table>
</body>
</html>
