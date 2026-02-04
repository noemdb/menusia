<?include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP COMPRAS Y ALMAC&Eacute;N (Ordenes de Compras)</title>
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
        {alert("C&oacute;digo de Cuenta debe ser Seleccionada");}
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
.Estilo15 {font-size: 12px; font-weight: bold; }
.Estilo17 {font-size: 12px; font-weight: bold; color: #333333; }
-->
</style>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ANULAR ORDENES DE SERVICIO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="1117" border="1" id="tablacuerpo">
  <tr>
    <td width="98" height="1111"><table width="92" height="1215" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Orden_Servicio.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu
            href="Act_Orden_Servicio.php">Atras</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu_p.php">Menu Proceso</a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="1020">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>      <div id="Layer1" style="position:absolute; width:857px; height:961px; z-index:1; top: 70px; left: 123px;">
        <form name="form1" method="post">
          <table width="852" height="872" border="0">
                <tr>
                  <td width="840"><table width="845" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="137"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO DE ORDEN  :</span></span></td>
                      <td width="168"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Orden" type="text" class="Estilo5" id="txtced_rif32343322"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15">
</span></span></td>
                      <td width="188"><span class="Estilo5"><span class="Estilo11">DOCUMENTO COMPROMISO  :</span></span></td>
                      <td width="67"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtTipo_Compromiso" type="text" class="Estilo5" id="txtCod_Articulo"  value="<?echo $Tipo_Compromiso ?>" size="6" maxlength="6" readonly>
                      </span></span></td>
                      <td width="117"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNombre_Abrev" type="text" class="Estilo5" id="txtCod_Articulo2"  value="<?echo $Nombre_Abrev ?>" size="6" maxlength="6" readonly>
                      </span></span></td>
                      <td width="54"><span class="Estilo5"><span class="Estilo11">FECHA    :</span></span></td>
                      <td width="88"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFecha" type="text" class="Estilo5" id="txtCod_Articulo3"  value="<?echo $Fecha ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="26"><img src="../pagos/b_info.png" width="11" height="11"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="Estilo5"><span class="Estilo10">INFORMACI&Oacute;N GENERAL </span></span></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="845" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="137"><span class="Estilo5"><span class="Estilo11">TIPO COMPROMISO  : </span></span></td>
                      <td width="109"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCod_Tipo_Comp" type="text" class="Estilo5" id="txtCod_Tipo_Comp"  value="<?echo $Cod_Tipo_Comp ?>" size="15" maxlength="15" readonly>
</span></span></td>
                      <td width="599"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDes_Tipo_Comp" type="text" class="Estilo5" id="txtDes_Tipo_Comp"  value="<?echo $Des_Tipo_Comp ?>" size="106" readonly>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="844" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="131"><span class="Estilo5"><span class="Estilo11">REQUISICI&Oacute;N Nro. :</span></span></td>
                      <td width="84"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Requisicion" type="text" class="Estilo5" id="txtNro_Requisicion"  value="<?echo $Nro_Requisicion ?>" size="8" maxlength="8" readonly>
                      </span></span></td>
                      <td width="148"><span class="Estilo5"><span class="Estilo11">FECHA REQUISICI&Oacute;N :</span></span></td>
                      <td width="98"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFecha_Requisicion" type="text" class="Estilo5" id="txtFecha_Requisicion"  value="<?echo $Fecha_Requisicion ?>" size="6" maxlength="6" readonly>
                      </span></span></td>
                      <td width="125"><span class="Estilo5"><span class="Estilo11">TIPO OPERACI&Oacute;N :</span></span></td>
                      <td width="110"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtTipo_Operacion" type="text" class="Estilo5" id="txtTipo_Operacion"  value="<?echo $Tipo_Operacion ?>" size="6" maxlength="6" readonly>
                      </span></span></td>
                      <td width="47"><span class="Estilo5"><span class="Estilo11">DIAS : </span></span></td>
                      <td width="101"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDias_Credito" type="text" class="Estilo5" id="txtDias_Credito"  value="<?echo $Dias_Credito ?>" size="6" maxlength="6" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24"><table width="846" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="123"><span class="Estilo5"><span class="Estilo11"> TIEMPO ENTREGA : </span></span></td>
                      <td width="42"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtTiempo_Entrega" type="text" class="Estilo5" id="txtCod_Articulo12"  value="<?echo $Tiempo_Entrega ?>" size="6" maxlength="6" readonly>
                      </span></span></td>
                      <td width="681">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="22"><table width="844" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="189"><span class="Estilo5"><span class="Estilo11">CATEGOR&Iacute;A PROGRAMATICA : </span></span></td>
                      <td width="109"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtUnidad" type="text" class="Estilo5" id="txtCod_Articulo14"  value="<?echo $Unidad ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="546"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNombre_Unidad" type="text" class="Estilo5" id="txtCod_Articulo15"  value="echo $Nombre_Unidad ?&gt;" size="95" maxlength="94" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="848" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="151"><span class="Estilo5"><span class="Estilo11">UNIDAD SOLICITANTE : </span></span></td>
                      <td width="658"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtLugar_Entrega" type="text" class="Estilo5" id="txtCod_Articulo16"  value="<?echo $Lugar_Entrega ?>" size="124" maxlength="124" readonly>
                      </span></span></td>
                      <td width="39"><span class="Estilo5">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="846" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="150"><span class="Estilo5"><span class="Estilo11">DIRECCI&Oacute;N ENTREGA  : </span></span></td>
                      <td width="696"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDireccion_Entrega" type="text" class="Estilo5" id="txtCod_Articulo17"  value="<?echo $Direccion_Entrega ?>" size="124" maxlength="124" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="26"><table width="845" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="90"><span class="Estilo5"><span class="Estilo11">PROVEEDOR : </span></span></td>
                      <td width="109"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCed_Rif" type="text" class="Estilo5" id="txtCod_Articulo18"  value="<?echo $Ced_Rif ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="632"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNombre" type="text" class="Estilo5" id="txtCod_Articulo19"  value="<?echo $Nombre ?>" size="114" maxlength="112" readonly>
                      </span></span></td>
                      <td width="14">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="845" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="82"><span class="Estilo5"><span class="Estilo11">CONCEPTO : </span></span></td>
                      <td width="763"><span class="Estilo5"><span class="Estilo11">
                      <textarea name="txtDescripcion" cols="114" readonly="readonly" class="Estilo5" id="txtCod_Articulo21"><?echo $Descripcion ?></textarea>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="846" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="160"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO DE PROYECTO  : </span></span></td>
                      <td width="110"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNum_Proyecto" type="text" class="Estilo5" id="txtCod_Articulo20"  value="<?echo $Cod_Articulo ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="576"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDes_Proyecto" type="text" class="Estilo5" id="txtCod_Articulo22"  value="<?echo $Des_Proyecto ?>" size="99" maxlength="98" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="846" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="176"><span class="Estilo5"><span class="Estilo11">FUENTE FINANCIAMIENTO  : </span></span></td>
                      <td width="108"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFuente_Financ" type="text" class="Estilo5" id="txtCod_Articulo26"  value="<?echo $Fuente_Financ ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="562"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDes_Fuente" type="text" class="Estilo5" id="txtCod_Articulo24"  value="<?echo $Des_Fuente ?>" size="96" maxlength="95" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="844" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="81"><span class="Estilo5"><span class="Estilo11">GARANT&Iacute;A :</span></span></td>
                      <td width="205"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFuente_Financ2" type="text" class="Estilo5" id="txtFuente_Financ"  value="<?echo $Fuente_Financ ?>" size="8" maxlength="8" readonly>
                      </span></span></td>
                      <td width="147"><span class="Estilo5"><span class="Estilo11">FECHA VENCIMIENTO :</span></span></td>
                      <td width="167"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFuente_Financ3" type="text" class="Estilo5" id="txtFuente_Financ2"  value="<?echo $Fuente_Financ ?>" size="8" maxlength="8" readonly>
                      </span></span></td>
                      <td width="129"><span class="Estilo5"><span class="Estilo11">APLICA IMPUESTO :</span></span></td>
                      <td width="115"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFuente_Financ4" type="text" class="Estilo5" id="txtFuente_Financ3"  value="<?echo $Fuente_Financ ?>" size="7" maxlength="7" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="844" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="251"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO PRESUPUESTARIO IMPUESTO :</span></span></td>
                      <td width="557"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCod_Pre_Impuesto" type="text" class="Estilo5" id="txtCod_Pre_Impuesto"  value="<?echo $Cod_Pre_Impuesto ?>" size="103" maxlength="101" readonly>
                      </span></span></td>
                      <td width="36"><span class="Estilo5">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="842" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="108"><span class="Estilo5"><span class="Estilo11">TIPO DE GASTO :</span></span></td>
                      <td width="330"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtTipo_Gasto" type="text" class="Estilo5" id="txtTipo_Gasto"  value="<?echo $Tipo_Gasto ?>" size="24" maxlength="23" readonly>
                      </span></span></td>
                      <td width="208"><span class="Estilo5"><span class="Estilo11">IMPUTACI&Oacute;N PRESUPUESTARIA :</span></span></td>
                      <td width="196"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtTipo_Imputacion" type="text" class="Estilo5" id="txtTipo_Imputacion"  value="<?echo $Tipo_Imputacion ?>" size="24" maxlength="23" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="847" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="229"><span class="Estilo5"><span class="Estilo11">REFERENCIA CR&Eacute;DITO ADICIONAL :</span></span></td>
                      <td width="108"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRef_Imput_Presu" type="text" class="Estilo5" id="txtCod_Articulo28"  value="<?echo $Ref_Imput_Presu ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="510"><span class="Estilo5">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo5"><span class="Estilo17">CARACTERIST&Iacute;CAS DEL BIEN </span></span></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="848" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="128"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO ALTERNO :</span></span></td>
                      <td width="126"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRef_Imput_Presu2" type="text" class="Estilo5" id="txtRef_Imput_Presu"  value="<?echo $Ref_Imput_Presu ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="74"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO</span></span> : </td>
                      <td width="121"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRef_Imput_Presu3" type="text" class="Estilo5" id="txtRef_Imput_Presu2"  value="<?echo $Ref_Imput_Presu ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="60"><span class="Estilo5"><span class="Estilo11">PLACA : </span></span></td>
                      <td width="118"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRef_Imput_Presu4" type="text" class="Estilo5" id="txtRef_Imput_Presu3"  value="<?echo $Ref_Imput_Presu ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="57"><span class="Estilo5"><span class="Estilo11">COLOR : </span></span></td>
                      <td width="164"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRef_Imput_Presu5" type="text" class="Estilo5" id="txtRef_Imput_Presu4"  value="<?echo $Ref_Imput_Presu ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="845" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="58"><span class="Estilo5"><span class="Estilo11">SERIAL :</span></span></td>
                      <td width="196"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRef_Imput_Presu8" type="text" class="Estilo5" id="txtRef_Imput_Presu7"  value="<?echo $Ref_Imput_Presu ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="74"><span class="Estilo5"><span class="Estilo11">MODELO</span></span> : </td>
                      <td width="298"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRef_Imput_Presu7" type="text" class="Estilo5" id="txtRef_Imput_Presu6"  value="<?echo $Ref_Imput_Presu ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="58"><span class="Estilo5"><span class="Estilo11">MARCA : </span></span></td>
                      <td width="161"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRef_Imput_Presu6" type="text" class="Estilo5" id="txtRef_Imput_Presu5"  value="<?echo $Ref_Imput_Presu ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo5"><span class="Estilo10">CONCEPTOS</span></span></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="851" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="195"><span class="Estilo5"><span class="Estilo11">DESCRIPCI&Oacute;N DEL SERVICIO :</span></span></td>
                      <td width="656"><span class="Estilo5"><span class="Estilo11">
                      <textarea name="txtRef_Imput_Presu72" cols="93" readonly="readonly" class="Estilo5" id="txtRef_Imput_Presu72"><?echo $Ref_Imput_Presu ?></textarea>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo13">SON LAS CELDAS</span></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="850" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td width="176" height="14"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO SERVICIO </span></span></td>
                      <td width="99"><span class="Estilo5"><span class="Estilo11">CANTIDAD</span></span></td>
                      <td width="136"><span class="Estilo5"><span class="Estilo11">UINDAD</span></span></td>
                      <td width="148"><span class="Estilo5"><span class="Estilo11">DESCRIPCI&Oacute;N</span></span></td>
                      <td width="269"><span class="Estilo5"><span class="Estilo11">MONTO</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="703" border="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="59"><span class="Estilo5"><span class="Estilo11">TOTAL</span></span></td>
                      <td width="634"><span class="Estilo5"><span class="Estilo11">TASA IMPUESTO </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="809" border="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="159"><span class="Estilo5"><span class="Estilo11">MONTO IVA </span></span></td>
                      <td width="433"><span class="Estilo5"><span class="Estilo11">TOTAL IVA </span></span></td>
                      <td width="203"><span class="Estilo5"></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo5"><span class="Estilo10">INFORMACI&Oacute;N PRESUPUESTARIA</span></span></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="22"><table width="843" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="131"><span class="Estilo5"><span class="Estilo11">TIENE LICITACI&Oacute;N :</span></span></td>
                      <td width="109"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRef_Imput_Presu22" type="text" class="Estilo5" id="txtRef_Imput_Presu22"  value="<?echo $Ref_Imput_Presu ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="127"><span class="Estilo5"><span class="Estilo11">Nro. DOCUMENTO :</span></span></td>
                      <td width="237"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRef_Imput_Presu24" type="text" class="Estilo5" id="txtRef_Imput_Presu24"  value="<?echo $Ref_Imput_Presu ?>" size="40" maxlength="40" readonly>
                      </span></span></td>
                      <td width="119"><span class="Estilo5"><span class="Estilo11">FORMA DE PAGO :</span></span></td>
                      <td width="120"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRef_Imput_Presu25" type="text" class="Estilo5" id="txtRef_Imput_Presu25"  value="<?echo $Ref_Imput_Presu ?>" size="5" maxlength="5" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="845" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="148"><span class="Estilo5"><span class="Estilo11">TIENE ANTICIPACI&Oacute;N :</span></span></td>
                      <td width="110"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRef_Imput_Presu23" type="text" class="Estilo5" id="txtRef_Imput_Presu23"  value="<?echo $Ref_Imput_Presu ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="205"><span class="Estilo5"><span class="Estilo11">PORCENTAJE DE ANTICIPO (%) :</span></span></td>
                      <td width="80"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRef_Imput_Presu27" type="text" class="Estilo5" id="txtRef_Imput_Presu28"  value="<?echo $Ref_Imput_Presu ?>" size="5" maxlength="5" readonly>
                      </span></span></td>
                      <td width="129"><span class="Estilo5"><span class="Estilo11">CUENTA ANTICIPO :</span></span></td>
                      <td width="173"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRef_Imput_Presu26" type="text" class="Estilo5" id="txtRef_Imput_Presu27"  value="<?echo $Ref_Imput_Presu ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo13">SON LAS CELDAS</span></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="29"><table width="655" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td width="180" height="14"><span class="Estilo5"><span class="Estilo11">SE-PR-PY-AC-PAR-GE-ES-SE</span></span></td>
                      <td width="56"><span class="Estilo5"><span class="Estilo11">FUENTE</span></span></td>
                      <td width="84"><span class="Estilo5"><span class="Estilo11">DISPONIBLE</span></span></td>
                      <td width="48"><span class="Estilo5"><span class="Estilo11">MONTO</span></span></td>
                      <td width="193"><span class="Estilo5"><span class="Estilo11">DENOMINACI&Oacute;N DEL C&Oacute;DIGO</span></span></td>
                      <td width="68"><span class="Estilo5"><span class="Estilo11">MONTO R</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="756" border="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="298"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO CONTABLE</span></span></td>
                      <td width="594"><span class="Estilo5"><span class="Estilo11">MONTO CR&Eacute;DITO</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="840" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="537">&nbsp;</td>
                      <td width="136"><span class="Estilo5"><span class="Estilo15">TOTAL C&Oacute;DIGOS : </span></span></td>
                      <td width="167"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula3325242222222" type="text" class="Estilo5" id="txtcedula3325242222222" size="15" maxlength="15" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="840" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="134"><span class="Estilo5"><span class="Estilo15">CANT. ART&Iacute;CULOS :</span></span></td>
                      <td width="96"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula3325242222222222" type="text" class="Estilo5" id="txtcedula3325242222222222" size="12" maxlength="15" readonly>
                      </span></span></td>
                      <td width="92"><span class="Estilo5"><span class="Estilo15">SUB-TOTAL :</span></span></td>
                      <td width="102"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula3325242222222233" type="text" class="Estilo5" id="txtcedula3325242222222234" size="12" maxlength="15" readonly>
                      </span></span></td>
                      <td width="89"><span class="Estilo5"><span class="Estilo15">IMPUESTO :</span></span></td>
                      <td width="93"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula33252422222222322" type="text" class="Estilo5" id="txtcedula33252422222222322" size="12" maxlength="15" readonly>
                      </span></span></td>
                      <td width="110"><span class="Estilo5"><span class="Estilo15">TOTAL ORDEN : </span></span></td>
                      <td width="124"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula332524222222224" type="text" class="Estilo5" id="txtcedula332524222222225" size="12" maxlength="15" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
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
        </div></td>
</tr>
</table>
</body>
</html>
<? pg_close();?>