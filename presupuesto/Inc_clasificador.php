<?php include ("../class/seguridad.inc"); include ("../class/ventana.php"); include ("../class/fun_fechas.php"); 
 $Formato_Cuenta="XXX-XX-XX-XX-XXX"; $fecha_hoy=asigna_fecha_hoy(); $fecha_c="01/01/".substr($fecha_hoy,0,4);
 $mpatron="Array(4,2,2,2,2,0,0,0,0,0)";  $mpatron=arma_patron($Formato_Cuenta);
 ?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Incluir Clasificador de Partidas)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="Javascript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
var patroncodigo = new <?php echo $mpatron ?>;
function validarcod(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\-]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function LlamarURL(url){  document.location = url; }
function revisar(){var f=document.form1;var Valido;
    if(f.txtCodigo_Partida.value==""){alert("Codigo de Partida no puede estar Vacio");return false;}
    if(f.txtNombre_Partida.value==""){alert("Denominacion de Partida no puede estar Vacia"); return false; }
       else{f.txtNombre_Partida.value=f.txtNombre_Partida.value.toUpperCase();}
    if(f.txtTipo_Gasto.value=="CORRIENTE" || f.txtTipo_Gasto.value=="INVERSION") {Valido=true;}
      else{alert("Tipo de Gasto no valida");return false; }
document.form1.submit;
return true;}
</script>

</head>

<body>
<table width="977" height="38" border="0" bgcolor="#000066" id="tablaencabezado">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR CLASIFICADOR DE PARTIDAS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9"> </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_clasificador.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_clasificador.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:335px; z-index:1; top: 67px; left: 112px;">
      <form name="form1" method="post" action="Insert_clasificador.php" onSubmit="return revisar()">
        <table width="865" border="0">
          <tr>
            <td><table width="825" height="235" border="0" align="center" id="tabcampos">
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="800" border="0">
                  <tr>
                    <td width="159"><span class="Estilo5">C&Oacute;DIGO DE PARTIDA :</span></td>
                    <td width="631"><span class="Estilo5"><input class="Estilo10" name="txtCodigo_Partida" type="text" id="txtCodigo_Partida" title="Registre el Codigo de la Partida" size="30" maxlength="30" onFocus="encender(this);" onBlur="apagar(this);" onKeypress="return validarcod(event)" onkeyup="mascara(this,'-',patroncodigo,true)">  </span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>
                  <table width="816" border="0">
                    <tr>
                      <td width="157"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                      <td width="659"><input class="Estilo10" name="txtNombre_Partida" type="text" id="txtNombre_Partida" title="Registre la denominacion de la Partida" size="105" maxlength="200"  onFocus="encender(this)" onBlur="apagar(this)"></td>
                    </tr>
                  </table>                  </td>
              </tr>

              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="800" border="0">
                  <tr>
                    <td width="159"><span class="Estilo5">TIPO DE GASTO :</span></td>
                    <td width="231"><span class="Estilo5"> <select name="txtTipo_Gasto" size="1" id="select" onFocus="encender(this)" onBlur="apagar(this)"> <option selected>CORRIENTE</option><option>INVERSION</option></select></span></td>
                    <td width="119"><span class="Estilo5">APLICACI&Oacute;N :</span></td>
                    <td width="273"><input class="Estilo10" name="txtAplicacion" type="text" id="txtAplicacion" title="Registre el Tipo de Aplicacion" size="4" maxlength="1"  onFocus="encender(this)" onBlur="apagar(this)" value="1"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="800" border="0">
                  <tr>
                    <td width="159"><span class="Estilo5">CODIGO DE CUENTA :</span></td>
                    <td width="150"><input class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" title="Registre el Codigo de Cuenta" size="30" maxlength="30"   onFocus="encender(this)" onBlur="apagar(this)"></td>
                    <td width="35"><input class="Estilo10" name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo Codigo de Cuentas"  onclick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=6-1','SIPAP','','750','500','true')" value="..."></td>
                    <td width="460"><input class="Estilo10" name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta" size="70" maxlength="250"  readonly></td>
				  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp; </td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        <div align="right"></div>
        <div align="right"></div>
        <p>&nbsp;</p>
        </form>
    </div>

  </tr>
</table>
</body>
</html>