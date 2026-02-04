<?php include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP COMPRAS Y ALMAC&Eacute;N (Proveedores)</title>
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
        {alert("Codigo de Cuenta debe ser Seleccionada");}
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
.Estilo13 {font-size: 12px; font-weight: bold; color: #FF0000; }
-->
</style>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> PROVEEDORES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="969" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="963"><table width="92" height="959" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_Proveedores.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Inc_Proveedores.php">Incluir</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Modf_Proveedores.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Modf_Proveedores.php">Modificar</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu
            href="javascript:Mover_Registro('P');">Primero</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></div></td>
      </tr>
  <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
  </tr><tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_cuentas.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="Cat_act_cuentas.php" class="menu">Catalogo</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu_a.php">Menu Archivo</a></div></td>
  </tr>
  <tr>
    <td><div align="center"></div></td>
  </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:862px; height:936px; z-index:1; top: 69px; left: 115px;">
        <form name="form1" method="post">
          <table width="861" border="0" >
                <tr>
                  <td width="850" height="14"><table width="852" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="97"><span class="Estilo5"><span class="Estilo11">CED&Uacute;LA/R.I.F : </span></span></td>
                      <td width="242"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCed_Rif" type="text" class="Estilo5" id="txtcod_unidad_medida2"  value="<?php echo $Ced_Rif ?>" size="15" maxlength="15" readonly>
</span></span></td>
                      <td width="44"><span class="Estilo5"><span class="Estilo11">R.I.F :
                      </span></span></td>
                      <td width="262"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRif" type="text" class="Estilo5" id="txtcod_unidad_medida3"  value="<?php echo $Rif ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="45"><span class="Estilo5"><span class="Estilo11">N.I.T :</span></span></td>
                      <td width="156"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNit" type="text" class="Estilo5" id="txtcod_unidad_medida32"  value="<?php echo $Nit ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
              <table width="859" border="0">
                <tr>
                  <td width="883" height="19"><table width="848" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="69"><span class="Estilo5"><span class="Estilo11">NOMBRE :</span></span></td>
                      <td width="779"><span class="Estilo5"><span class="Estilo11">
                      <textarea name="txtNombre" cols="117" readonly="readonly" class="Estilo5" id="txtcod_unidad_medida33"><?php echo $Nombre ?></textarea>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="Estilo5"><span class="Estilo10">DATOS BASICOS</span></span></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="19"><table width="851" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="84" height="17"><span class="Estilo5"><span class="Estilo11">DIRECCI&Oacute;N   :</span></span></td>
                      <td width="767"><span class="Estilo5"><span class="Estilo11">
                      <textarea name="txtDireccion" cols="115" readonly="readonly" class="Estilo5" id="txtcod_unidad_medida34"><?php echo $Direccion ?></textarea>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="851" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="79"><span class="Estilo5"><span class="Estilo11">TELEFONO  : </span></span></td>
                      <td width="277"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtTelefonos" type="text" class="Estilo5" id="txtcod_unidad_medida35"  value="<?php echo $Telefonos ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="39"><span class="Estilo5"><span class="Estilo11">FAX :</span></span></td>
                      <td width="207"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFax" type="text" class="Estilo5" id="txtcod_unidad_medida36"  value="<?php echo $Fax ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="118"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO POSTAL   :</span></span></td>
                      <td width="131"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCod_Postal" type="text" class="Estilo5" id="txtCod_Postal"  value="<?php echo $Cod_Postal ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24"><table width="850" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="133"><span class="Estilo5"><span class="Estilo11">APARTADO POSTAL   : </span></span></td>
                      <td width="382"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtAptd_Postal" type="text" class="Estilo5" id="txtAptd_Postal"  value="<?php echo $Aptd_Postal ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="127"><span class="Estilo5"><span class="Estilo11">TIPO PROVEEDOR   :</span></span></td>
                      <td width="208"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtTipo_Proveedor" type="text" class="Estilo5" id="txtTipo_Proveedor"  value="<?php echo $Tipo_Proveedor ?>" size="26" maxlength="25" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="850" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="163"><span class="Estilo5"><span class="Estilo11">CORREO ELECTRONICO   : </span></span></td>
                      <td width="359"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtEmail" type="text" class="Estilo5" id="txtcod_unidad_medida3652"  value="<?php echo $Email ?>" size="25" maxlength="25" readonly>
</span></span></td>
                      <td width="93"><span class="Estilo5"><span class="Estilo11">P&Aacute;GINA WEB   :</span></span></td>
                      <td width="235"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtWeb_Site" type="text" class="Estilo5" id="txtWeb_Site"  value="<?php echo $Web_Site ?>" size="31" maxlength="30" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="850" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="144"><span class="Estilo5"><span class="Estilo11">PERSONA CONTACTO   : </span></span></td>
                      <td width="706"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtPersona_Contacto" type="text" class="Estilo5" id="txtPersona_Contacto"  value="<?php echo $Persona_Contacto ?>" size="125" maxlength="125" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="850" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="111"><span class="Estilo5"><span class="Estilo11">RAMOS VENTAS  : </span></span></td>
                      <td width="739"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRamo_Ventas" type="text" class="Estilo5" id="txtcod_unidad_medida369"  value="<?php echo $Ramo_Ventas ?>" size="132" maxlength="132" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="Estilo5"><span class="Estilo10">INFORMACI&Oacute;N LEGAL</span></span></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><table width="845" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="97"><span class="Estilo5"><span class="Estilo11">CED&Uacute;LA/R.I.F : </span></span></td>
                      <td width="110"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCed_Rif_Rep_Legal" type="text" class="Estilo5" id="txtcod_unidad_medida3610"  value="<?php echo $Ced_Rif_Rep_Legal ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="355">&nbsp;</td>
                      <td width="126"><span class="Estilo5"><span class="Estilo11">TELEFONO MOVIL : </span></span></td>
                      <td width="157"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtTelefono_Movil" type="text" class="Estilo5" id="txtcod_unidad_medida3611"  value="<?php echo $Telefono_Movil ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="848" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="69"><span class="Estilo5"><span class="Estilo11">NOMBRE :</span></span></td>
                      <td width="779"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNombre_Rep" type="text" class="Estilo5" id="txtcod_unidad_medida3612"  value="<?php echo $Nombre_Rep ?>" size="139" maxlength="138" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="850" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="121"><span class="Estilo5"><span class="Estilo11">CAPITAL INICIAL  : </span></span></td>
                      <td width="166"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCapital_Suscrito" type="text" class="Estilo5" id="txtcod_unidad_medida3613"  value="<?php echo $Capital_Suscrito ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="120"><span class="Estilo5"><span class="Estilo11">CAPITAL ACTUAL  :</span></span></td>
                      <td width="186"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCapital_Pagado" type="text" class="Estilo5" id="txtcod_unidad_medida3614"  value="<?php echo $Capital_Pagado ?>" size="10" maxlength="10" readonly>
</span></span></td>
                      <td width="121"><span class="Estilo5"><span class="Estilo11">FECHA REGISTRO :</span></span></td>
                      <td width="136"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFecha_Registro" type="text" class="Estilo5" id="txtcod_unidad_medida3615"  value="<?php echo $Fecha_Registro ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="851" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="133"><span class="Estilo5"><span class="Estilo11">CIRCUNSCRIPCI&Oacute;N : </span></span></td>
                      <td width="472"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCircunscripcion" type="text" class="Estilo5" id="txtcod_unidad_medida3619"  value="<?php echo $Circunscripcion ?>" size="65" maxlength="64" readonly>
                      </span></span></td>
                      <td width="109"><span class="Estilo5"><span class="Estilo11">Nro. REGISTRO :</span></span></td>
                      <td width="137"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Registro" type="text" class="Estilo5" id="txtcod_unidad_medida3616"  value="<?php echo $Nro_Registro ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="853" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="111"><span class="Estilo5"><span class="Estilo11">TOMO N&Uacute;MERO  : </span></span></td>
                      <td width="494"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtTomo" type="text" class="Estilo5" id="txtcod_unidad_medida3618"  value="<?php echo $Tomo ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="109"><span class="Estilo5"><span class="Estilo11">FOLIO N&Uacute;MERO:</span></span></td>
                      <td width="139"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFolio" type="text" class="Estilo5" id="txtcod_unidad_medida3617"  value="<?php echo $Folio ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="853" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="106"><span class="Estilo5"><span class="Estilo11">OBSERVACI&Oacute;N : </span></span></td>
                      <td width="747"><span class="Estilo5"><span class="Estilo11">
                      <textarea name="txtObservacion" cols="109" readonly="readonly" class="Estilo5" id="txtcod_unidad_medida3620"><?php echo $Observacion ?></textarea>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="Estilo5"><span class="Estilo10">INSCRIPCIONES</span></span></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><table width="854" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="205"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO ISNCRIPCI&Oacute;N I.V.S.S  : </span></span></td>
                      <td width="282"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_IVSS" type="text" class="Estilo5" id="txtcod_unidad_medida3621"  value="<?php echo $Nro_IVSS ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="191"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO ISNCRIPCI&Oacute;N INCE :</span></span></td>
                      <td width="176"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_INCE" type="text" class="Estilo5" id="txtcod_unidad_medida3622"  value="<?php echo $Nro_INCE ?>" size="16" maxlength="15" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="854" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="179"><span class="Estilo5"><span class="Estilo11">TIENE INSCRIPCI&Oacute;N S.N.C  : </span></span></td>
                      <td width="167"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtIns_Ocei" type="text" class="Estilo5" id="txtcod_unidad_medida3623"  value="<?php echo $Ins_Ocei ?>" size="10" maxlength="10" readonly>
</span></span></td>
                      <td width="70"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO :</span></span></td>
                      <td width="151"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_OCEI" type="text" class="Estilo5" id="txtcod_unidad_medida3624"  value="<?php echo $Nro_OCEI ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="142"><span class="Estilo5"><span class="Estilo11">MONTO FINANCIERO  :</span></span></td>
                      <td width="145"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtcod_unidad_medida3624" type="text" class="Estilo5" id="txtcod_unidad_medida3625"  value="<?php echo $cod_unidad_medida ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="854" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="237"><span class="Estilo5"><span class="Estilo11">TIENE INSCRIPCI&Oacute;N GOBERNACI&Oacute;N : </span></span></td>
                      <td width="109"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtIns_Gobernacion" type="text" class="Estilo5" id="txtcod_unidad_medida3626"  value="<?php echo $Ins_Gobernacion ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="70"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO :</span></span></td>
                      <td width="223"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Gobernacion" type="text" class="Estilo5" id="txtcod_unidad_medida3627"  value="<?php echo $Nro_Gobernacion ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="68"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO :</span></span></td>
                      <td width="147"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtcod_unidad_medida3627" type="text" class="Estilo5" id="txtcod_unidad_medida3628"  value="<?php echo $cod_unidad_medida ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="854" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="206"><span class="Estilo5"><span class="Estilo11">TIENE INSCRIPCI&Oacute;N ALCALD&Iacute;A : </span></span></td>
                      <td width="433"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtIns_Alcaldia" type="text" class="Estilo5" id="txtcod_unidad_medida3632"  value="<?php echo $Ins_Alcaldia ?>" size="10" maxlength="10" readonly>
</span></span></td>
                      <td width="67"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO :</span></span></td>
                      <td width="148"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Alcaldia" type="text" class="Estilo5" id="txtcod_unidad_medida3629"  value="<?php echo $Nro_Alcaldia ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="854" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="180"><span class="Estilo5"><span class="Estilo11">INSCRIPCI&Oacute;N EXONERADA : </span></span></td>
                      <td width="109"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtExon_Inscripcion" type="text" class="Estilo5" id="txtcod_unidad_medida3633"  value="<?php echo $Exon_Inscripcion ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="125"><span class="Estilo5"><span class="Estilo11">LICITACI&Oacute;N EXO. :</span></span></td>
                      <td width="145"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtExon_Licitacion" type="text" class="Estilo5" id="txtNro_Alcaldia"  value="<?php echo $Exon_Licitacion ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="146"><span class="Estilo5"><span class="Estilo11">EXO. LICITACI&Oacute;N IVA :</span></span></td>
                      <td width="149"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtExon_Iva" type="text" class="Estilo5" id="txtcod_unidad_medida3630"  value="<?php echo $Exon_Iva ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="Estilo5"><span class="Estilo10">RAMOS DE VENTAS</span></span></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><table width="853" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="203"><span class="Estilo5"><span class="Estilo11">RAMOS DE VENTAS PRINCIPAL  : </span></span></td>
                      <td width="650"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtcod_unidad_medida3633" type="text" class="Estilo5" id="txtcod_unidad_medida3634"  value="<?php echo $cod_unidad_medida ?>" size="110" maxlength="109" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="854" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td width="86" height="14"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO</span></span></td>
                      <td width="91"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO</span></span></td>
                      <td width="631"><span class="Estilo5"><span class="Estilo11">DESCRIPCI&Oacute;N RAMOS DE VENTAS </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo5"><span class="Estilo10">SOLVENCIAS</span></span></td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo13">SON LAS CELDAS</span></td>
                </tr>
                <tr>
                  <td height="14"><table width="852" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td width="57" height="14"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO</span></span></td>
                      <td width="260"><span class="Estilo5"><span class="Estilo11">DESCRIPCI&Oacute;N REQUISITOS/SOLVENCIAS</span></span></td>
                      <td width="55"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO</span></span></td>
                      <td width="108"><span class="Estilo5"><span class="Estilo11">FECHA EMISI&Oacute;N</span></span></td>
                      <td width="94"><span class="Estilo5"><span class="Estilo11">FECHA VENCE</span></span></td>
                      <td width="252"><span class="Estilo5"><span class="Estilo11">OBSERVACI&Oacute;N</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
          </table>
              <p>&nbsp;</p>
        </form>
    </div>    </td>
</tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>