<?php include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Conciliaci&oacute;n Bancaria)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url)
{
var murl;
var Gcodigo_cuenta=document.form1.txtCodigo_Cuenta.value;
    murl=url+Gcodigo_cuenta;
    if (Gcodigo_cuenta=="")
        {alert("C�digo de Cuenta debe ser Seleccionada");}
        else {document.location = murl;}
}
function Mover_Registro(MPos)
{
var murl;
   murl="Act_cuentas.php";
   if(MPos=="P"){murl="Act_cuentas.php?Gcodigo_cuenta=P"}
   if(MPos=="U"){murl="Act_cuentas.php?Gcodigo_cuenta=U"}
   if(MPos=="S"){murl="Act_cuentas.php?Gcodigo_cuenta=S"+document.form1.txtCodigo_Cuenta.value;}
   if(MPos=="A"){murl="Act_cuentas.php?Gcodigo_cuenta=A"+document.form1.txtCodigo_Cuenta.value;}
   document.location = murl;
}
function Llama_Eliminar(){
var url;
var r;
  if (document.form1.txtCargable.value=="CARGABLE"){
  r=confirm("Esta seguro en Eliminar la Cuenta ?");
  if (r==true) {
    r=confirm("Esta Realmente seguro en Eliminar la Cuenta ?");
    if (r==true) {
       url="Delete_cuentas.php?txtCodigo_Cuenta="+document.form1.txtCodigo_Cuenta.value;
       VentanaCentrada(url,'Eliminar Plan Cuentas','','400','400','true');}
    }
   else { url="Cancelado, no elimino"; }
  }
  else { alert("CUENTA NO ES CARGABLE, NO PUEDE SER ELIMINADA"); }
}
</script>
<SCRIPT language=JavaScript
src="../class/sia.js"
type=text/javascript></SCRIPT>
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
<style type="text/css">
<!--
.Estilo5 {font-size: 10px}
.Estilo2 {color: #FFFFFF}
.Estilo6 {
        font-size: 16pt;
        font-weight: bold;
}
.Estilo9 {font-size: 8pt}
.Estilo12 {font-size: 12px}
.Estilo10 {	font-size: 12px;
	font-weight: bold;
	color: #0000FF;
}
.Estilo14 {font-size: 10px; color: #FF0000; }
.Estilo17 {font-size: 10px; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONCILIACI&Oacute;N BANCARIA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="346" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="340"><table width="92" height="342" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Conciliacion.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu
            href="Act_Conciliacion.php">Atras</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>      <div id="Layer1" style="position:absolute; width:870px; height:324px; z-index:1; top: 70px; left: 115px;">
        <form name="form1" method="post">
          <table width="856" height="132" border="0" >
                <tr>
                  <td width="850"><table width="830" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="109" height="22"><span class="Estilo12"><span class="Estilo5">C&Oacute;DIGO BANCO</span> :</span></td>
                      <td width="118"><span class="Estilo12">
                      <span class="Estilo5">
                      <input name="txtCod_Banco" type="text" id="txtCod_Banco" size="13" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></span></td>
                      <td width="236"><span class="Estilo12"><span class="Estilo5">
                      </span><span class="Estilo5">
                      <input name="bttipo_orden" type="button" id="bttipo_orden" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIPAP','','750','500','true')" value="...">
                      
                      </span> </span></td>
                      <td width="125"><span class="Estilo12"><span class="Estilo5">N&Uacute;MERO DE CUENTA </span> :</span></td>
                      <td width="135"><div align="left"><span class="Estilo12">
                      <span class="Estilo5">
                      <input name="txtNro_Cuenta" type="text" id="txtcod_titulo" size="20" maxlength="19"  value="<?php echo $Nro_Cuenta?>" readonly>
                      </span></span></div></td>
                      <td width="12">&nbsp;</td>
                      <td width="95"><img src="b_info.png" width="11" height="11"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="840" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="130"><span class="Estilo5">NOMBRE DEL BANCO  : </span></td>
                        <td width="672"><span class="Estilo5">
                        <span class="Estilo12">
                        <input name="txtNombre_Banco" type="text" id="txtcod_titulo32" size="96" maxlength="91"  value="<?php echo $Nombre_Banco?>" readonly>
                        </span></span></td>
                        <td width="38">&nbsp;</td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="32"><table width="640" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="167">&nbsp;</td>
                      <td width="33"><div align="center"><span class="Estilo5">1</span></div></td>
                      <td width="34"><div align="center"><span class="Estilo5">2</span></div></td>
                      <td width="29"><div align="center"><span class="Estilo5">3</span></div></td>
                      <td width="36"><div align="center"><span class="Estilo5">4</span></div></td>
                      <td width="33"><div align="center"><span class="Estilo5">5</span></div></td>
                      <td width="35"><div align="center"><span class="Estilo5">6</span></div></td>
                      <td width="34"><div align="center"><span class="Estilo5">7</span></div></td>
                      <td width="37"><div align="center"><span class="Estilo5">8</span></div></td>
                      <td width="40"><div align="center"><span class="Estilo5">9</span></div></td>
                      <td width="34"><div align="center"><span class="Estilo5">10</span></div></td>
                      <td width="42"><div align="center"><span class="Estilo5">11</span></div></td>
                      <td width="29"><div align="center"><span class="Estilo5">12</span></div></td>
                      <td width="57">&nbsp;</td>
                    </tr>
                    <tr>
                      <td><span class="Estilo5">PERIODOS CONCILIADOS :</span></td>
                      <td><div align="center">
                        <input type="checkbox" name="checkbox" value="checkbox">
                      </div></td>
                      <td><div align="center">
                        <input type="checkbox" name="checkbox2" value="checkbox">
                      </div></td>
                      <td><div align="center">
                        <input type="checkbox" name="checkbox22" value="checkbox">
                      </div></td>
                      <td><div align="center">
                        <input type="checkbox" name="checkbox23" value="checkbox">
                      </div></td>
                      <td><div align="center">
                        <input type="checkbox" name="checkbox24" value="checkbox">
                      </div></td>
                      <td><div align="center">
                        <input type="checkbox" name="checkbox25" value="checkbox">
                      </div></td>
                      <td><div align="center">
                        <input type="checkbox" name="checkbox26" value="checkbox">
                      </div></td>
                      <td><div align="center">
                        <input type="checkbox" name="checkbox27" value="checkbox">
                      </div></td>
                      <td><div align="center">
                        <input type="checkbox" name="checkbox28" value="checkbox">
                      </div></td>
                      <td><div align="center">
                        <input type="checkbox" name="checkbox29" value="checkbox">
                      </div></td>
                      <td><div align="center">
                        <input type="checkbox" name="checkbox210" value="checkbox">
                      </div></td>
                      <td> <div align="center">
                        <input type="checkbox" name="checkbox211" value="checkbox">                        
                      </div></td>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="282" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="147"><span class="Estilo5">MES DE CONCILIACI&Oacute;N :</span></td>
                      <td width="135"><span class="Estilo5"><span class="Estilo12">
                        <select name="select">
                          <option>01</option>
                          <option>02</option>
                          <option>03</option>
                          <option>04</option>
                          <option>05</option>
                          <option>06</option>
                          <option>07</option>
                          <option>09</option>
                          <option>10</option>
                          <option>11</option>
                          <option>12</option>
                        </select>
                      </span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24">&nbsp;</td>
                </tr>
          </table>
              <table width="871" height="142" border="0">
          <tr>
            <td width="885">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
            <p>&nbsp;</p>
        </form>
        </div></td>
</tr>
</table>
</body>
</html>
