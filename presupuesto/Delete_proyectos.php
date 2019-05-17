<?include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Definci&oacute;n de Proyectos)</title>
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
        {alert("Código de Cuenta debe ser Seleccionada");}
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
.Estilo10 {
	font-size: 12px;
	font-weight: bold;
	color: #0000FF;
}
.Estilo11 {font-size: 12px}
-->
</style>
</head>

<body>
<table width="992" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ELIMINAR - DEFINICI&Oacute;N PROYECTOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="992" height="360" border="1" id="tablacuerpo">
  <tr>
    <td width="93" height="354"><table width="92" height="412" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_proyectos.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Act_proyectos.php?Gced_rif=U">Atras</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="932">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:881px; height:301px; z-index:1; top: 69px; left: 115px;">
        <form name="form1" method="post">
          <table width="880" border="0" >
                <tr>
                  <td width="850"><table width="819" border="0">
                    <tr>
                      <td width="125">
                        <p><span class="Estilo5">N&Uacute;MERO PROYECTO :</span></p></td>
                      <td width="110"><span class="Estilo5">
                        <input name="txtdoc_compromiso" type="text" id="txtdoc_compromiso" title="Registre el c&oacute;digo del documento compromiso" onChange="chequea_tipo(this.form);" size="15" maxlength="15" onFocus="encender(this); " onBlur="apagar(this);">
                      </span></td>
                      <td width="526"><span class="Estilo5">
                        <input name="Catalogo3" type="button" id="Catalogo3" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIA','','750','500','true')" value="...">
                      </span></td>
                      <? if($anulado=='S'){?>
                      <? }else{?>
                      <? }?>
                      <td width="40"><img src="../imagenes/b_info.png" width="11" height="11" onClick="javascript:alert('<?echo $inf_usuario?>');"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="810" border="0">
                    <tr>
                      <td width="106"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                      <td width="694"><textarea name="txtDescripcion" cols="77" readonly="readonly" class="headers" id="texDescripcion"><?echo $descripcion?></textarea></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
              <table width="881" height="112" border="0">
          <tr>
            <td width="883" height="108"><table width="862" border="0" dwcopytype="CopyTableCell" >
              <tr>
                <td><table width="812">
                  <tr>
                    <td width="191"><span class="Estilo5">IMPUTACI&Oacute;N PRESUPUESTARIA :</span></td>
                    <td width="217"><span class="Estilo5">
                      <input name="txtfunc_inv2" type="text" id="txtfunc_inv2"  value="<?echo $func_inv?>" size="25" readonly>
                    </span></td>
                    <td width="229"><span class="Estilo5">REFERENCIA DEL CR&Eacute;DITO ADICIONAL :</span></td>
                    <td width="155"><span class="Estilo5">
                    <input name="txtfecha_vencim" type="text" id="txtfecha_vencim" value="<?echo $fecha_vencim?>" size="12" readonly>
</span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="863">
                  <tr>
                    <td width="156"><span class="Estilo5">FUENTE FINANCIAMIENTO :</span></td>
                    <td width="124"><span class="Estilo5">
                      <input name="txttipo_compromiso2" type="text"  id="txttipo_compromiso22" value="<?echo $tipo_compromiso?>" size="15" readonly>
                    </span></td>
                    <td width="567"><span class="Estilo5">
                      <input name="txttiene_anticipo" type="text" id="txttiene_anticipo3" size="73"  value="<?echo $tiene_anticipo?>" readonly>
                    </span></td>
                  </tr>
                </table>
                  <table width="863">
                    <tr>
                      <td width="156"><span class="Estilo5">FUENTE FINANCIAMIENTO :</span></td>
                      <td width="124"><span class="Estilo5">
                        <input name="txttipo_compromiso22" type="text"  id="txttipo_compromiso23" value="<?echo $tipo_compromiso?>" size="15" readonly>
                      </span></td>
                      <td width="567"><span class="Estilo5">
                        <input name="txttiene_anticipo2" type="text" id="txttiene_anticipo4" size="73"  value="<?echo $tiene_anticipo?>" readonly>
                      </span></td>
                    </tr>
                  </table>
                  <table width="863">
                    <tr>
                      <td width="156"><span class="Estilo5">FUENTE FINANCIAMIENTO :</span></td>
                      <td width="124"><span class="Estilo5">
                        <input name="txttipo_compromiso23" type="text"  id="txttipo_compromiso24" value="<?echo $tipo_compromiso?>" size="15" readonly>
                      </span></td>
                      <td width="567"><span class="Estilo5">
                        <input name="txttiene_anticipo3" type="text" id="txttiene_anticipo5" size="73"  value="<?echo $tiene_anticipo?>" readonly>
                      </span></td>
                    </tr>
                  </table>
                  <p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><table width="423">
                  <tr>
                    <td width="148"><span class="Estilo5">MONTO DEL PROYECTO :</span></td>
                    <td width="263"><span class="Estilo5">
                      <input readonly name="txttasa_anticipo" type="text" id="txttasa_anticipo" value="<?ECHO $tasa_anticipo?>" size="20">
                    </span></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>
                    <p>&nbsp;</p>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
