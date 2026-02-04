<?php include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP COMPRAS Y ALMAC&Eacute;N (Analisis Cotizaciones de Art&iacute;culos)</title>
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
.Estilo15 {font-size: 12px; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ANALISIS COTIZACIONES  ART&Iacute;CULOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="693" border="1" id="tablacuerpo">
  <tr>
    <td width="96" height="687"><table width="92" height="691" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_Analisis.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Inc_Analisis.php">Incluir</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Modf_Analisis.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Modf_Analisis.php">Modificar</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Cons_Analisis.php">Consultar</a></div></td>
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
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="menu_p.php" class="menu">Menu Proceso</a></div></td>
  </tr>
  <tr>
    <td><div align="center"></div></td>
  </tr>
    </table></td>
    <td width="902">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:861px; height:677px; z-index:1; top: 65px; left: 118px;">
        <form name="form1" method="post">
          <table width="889" border="0">
                <tr>
                  <td width="883"><table width="852" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="151"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO DE ANALISIS  :</span></span></td>
                      <td width="117"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Analisis" type="text" class="Estilo5" id="txtcod_unidad_medida2"  value="<?php echo $Nro_Analisis ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="231"><span class="Estilo5"><span class="Estilo11">FECHA SOLICITUD COTIZACIONES :</span></span></td>
                      <td width="115"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFecha_Solicitud" type="text" class="Estilo5" id="txtcod_unidad_medida3"  value="<?php echo $Fecha_Solicitud ?>" size="11" maxlength="11" readonly>
                      </span></span></td>
                      <td width="121"><span class="Estilo5"><span class="Estilo11">FECHA ANALISIS   :</span></span></td>
                      <td width="88"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFecha_Solicitud" type="text" class="Estilo5" id="txtcod_unidad_medida32"  value="<?php echo $Fecha_Solicitud ?>" size="11" maxlength="11" readonly>
                      </span></span></td>
                      <td width="29"><img src="../pagos/b_info.png" width="11" height="11"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24"><table width="852" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="85"><span class="Estilo5"><span class="Estilo11">CONCEPTO : </span></span></td>
                      <td width="767"><span class="Estilo5"><span class="Estilo11">
                      <textarea name="txtDescripcion" cols="117" readonly="readonly" class="Estilo5" id="txtcod_unidad_medida33"><?php echo $Descripcion ?></textarea>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="800" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="157"><span class="Estilo5"><span class="Estilo11">REQUISICI&Oacute;N NUMERO : </span></span></td>
                      <td width="643"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtnro_requisicion " type="text" class="Estilo5" id="txtnro_requisicion "  value="<?php echo $nro_requisicion  ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="Estilo5"><span class="Estilo10">ART&Iacute;CULOS</span></span></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="Estilo13">SON LAS CELDAS</span></td>
                </tr>
                <tr>
                  <td><table width="773" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td width="84" height="14"><span class="Estilo5"><span class="Estilo11">CODIGO</span></span></td>
                      <td width="115"><span class="Estilo5"><span class="Estilo11">DENOMINACI&Oacute;N</span></span></td>
                      <td width="79"><span class="Estilo5"><span class="Estilo11">CANTIDAD</span></span></td>
                      <td width="68"><span class="Estilo5"><span class="Estilo11">UNIDAD</span></span></td>
                      <td width="87"><span class="Estilo5"><span class="Estilo11">IMPUESTO </span></span></td>
                      <td width="66"><span class="Estilo5"><span class="Estilo11">MARCA</span></span></td>
                      <td width="244"><span class="Estilo5"><span class="Estilo11">MODELO</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo5"><span class="Estilo10">COTIZACIONES</span></span></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="837" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="92"><span class="Estilo5"><span class="Estilo11">PROVEEDOR : </span></span></td>
                      <td width="107"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCed_Rif" type="text" class="Estilo5" id="txtCed_Rif"  value="<?php echo $Ced_Rif?>" size="15" maxlength="15" readonly>
</span></span></td>
                      <td width="45"><span class="Estilo5">
                      </span></td>
                      <td width="593"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNombre_Proveedor" type="text" class="Estilo5" id="txtNombre_Proveedor"  value="<?php echo $Nombre_Proveedor ?>" size="107" maxlength="106" readonly>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="22"><table width="839" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="144"><span class="Estilo5"><span class="Estilo11">TIPO DE OPERACI&Oacute;N :</span></span></td>
                      <td width="103"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtTipo_Operacion" type="text" class="Estilo5" id="txtTipo_Operacion"  value="<?php echo $Tipo_Operacion ?>" size="15" maxlength="15" readonly>
</span></span></td>
                      <td width="104"><span class="Estilo5"><span class="Estilo11">DIAS CR&Eacute;DITO  :</span></span></td>
                      <td width="66"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDias_Credito" type="text" class="Estilo5" id="txtDias_Credito"  value="<?php echo $Dias_Credito ?>" size="6" maxlength="6" readonly>
                      </span></span></td>
                      <td width="123"><span class="Estilo5"><span class="Estilo11">TIEMPO  ENTREGA :</span></span></td>
                      <td width="67"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtTiempo_Entrega" type="text" class="Estilo5" id="txtTiempo_Entrega"  value="<?php echo $Tiempo_Entrega ?>" size="6" maxlength="6" readonly>
                      </span></span></td>
                      <td width="141"><span class="Estilo5"><span class="Estilo11">EXONERADO DE IVA : </span></span></td>
                      <td width="91"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtExon_IVA" type="text" class="Estilo5" id="txtExon_IVA"  value="<?php echo $Exon_IVA ?>" size="6" maxlength="6" readonly>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo13">SON LAS CELDAS </span></td>
                </tr>
                <tr>
                  <td height="22"><table width="851" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td width="128" height="14"><span class="Estilo5"><span class="Estilo11">CODIGO ART&Iacute;CULO</span></span></td>
                      <td width="73"><span class="Estilo5"><span class="Estilo11">CANTIDAD</span></span></td>
                      <td width="69"><span class="Estilo5"><span class="Estilo11">TASA IMP. </span></span></td>
                      <td width="54"><span class="Estilo5"><span class="Estilo11">PRECIO</span></span></td>
                      <td width="162"><span class="Estilo5"><span class="Estilo11">PRECION CON IMPUESTO </span></span></td>
                      <td width="42"><span class="Estilo5"><span class="Estilo11">TOTAL</span></span></td>
                      <td width="111"><span class="Estilo5"><span class="Estilo11">DENOMINACI&Oacute;N</span></span></td>
                      <td width="110"><span class="Estilo5"><span class="Estilo11">DIAS GARANT&Iacute;AS</span></span></td>
                      <td width="64"><span class="Estilo5"><span class="Estilo11">PUNTOS</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="852" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="24">&nbsp;</td>
                      <td width="36"><span class="Estilo5"><span class="Estilo11">1/1</span></span></td>
                      <td width="23"><span class="Estilo5"><span class="Estilo11">
                        <label><img src="../pagos/anterior.JPG" name="P_Anterior" width="12" height="16" id="P_Anterior"></label>
                      </span></span></td>
                      <td width="516"><span class="Estilo5"><span class="Estilo11"><img src="../pagos/siguiente.JPG" name="P_Siguiente" width="13" height="17" id="P_Siguiente"> </span></span></td>
                      <td width="77"><span class="Estilo5"><span class="Estilo11"><span class="Estilo15">TOTALES : </span> </span></span></td>
                      <td width="176"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtTot_Precios" type="text" class="Estilo5" id="txtcedula33252422222223" size="15" maxlength="15" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="122"><table width="853" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td height="14"><span class="Estilo5"><span class="Estilo10">RESULTADO DE ANALISIS </span></span></td>
                    </tr>
                    <tr>
                      <td height="14">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="14"><table width="846" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                        <tr>
                          <td width="172"><span class="Estilo5"><span class="Estilo11">%PARA EVALUAR PRECIO :</span></span></td>
                          <td width="355"><span class="Estilo5"><span class="Estilo11">
                            <input name="txtP_Precio" type="text" class="Estilo5" id="txtP_Precio"  value="<?php echo $P_Precio ?>" size="6" maxlength="6" readonly>
                          </span></span></td>
                          <td width="215"><span class="Estilo5"><span class="Estilo11">%PARA EVALUAR DIAS CR&Eacute;DITO :</span></span></td>
                          <td width="104"><span class="Estilo5"><span class="Estilo11">
                            <input name="txtP_Dias_Credito" type="text" class="Estilo5" id="txtP_Dias_Credito"  value="<?php echo $P_Dias_Credito ?>" size="6" maxlength="6" readonly>
                            </span></span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="14"><table width="840" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="231"><span class="Estilo5"><span class="Estilo11">%PARA EVALUAR TIEMPO ENTREGA :</span></span></td>
                            <td width="320"><span class="Estilo5"><span class="Estilo11">
                            <input name="txtP_Tiempo_Entrega" type="text" class="Estilo5" id="txtP_Tiempo_Entrega"  value="<?php echo $P_Tiempo_Entrega ?>" size="6" maxlength="6" readonly>
                            </span></span></td>
                            <td width="191"><span class="Estilo5"><span class="Estilo11"> % PARA EVALUAR GARANTIA : </span></span></td>
                            <td width="98"><span class="Estilo5"><span class="Estilo11">
                              <input name="txtP_Garantia" type="text" class="Estilo5" id="txtP_Garantia"  value="<?php echo $P_Garantia ?>" size="6" maxlength="6" readonly>
                            </span></span></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="14"><span class="Estilo13">SON LAS CELDAS </span></td>
                    </tr>
                    <tr>
                      <td height="22"><table width="847" border="0" dwcopytype="CopyTableCell">
                        <tr>
                          <td width="125" height="14"><span class="Estilo5"><span class="Estilo11">CODIGO SERVICIO </span></span></td>
                          <td width="79"><span class="Estilo5"><span class="Estilo11">PROVEEDOR</span></span></td>
                          <td width="162"><span class="Estilo5"><span class="Estilo11">PRECION CON IMPUESTO </span></span></td>
                          <td width="42"><span class="Estilo5"><span class="Estilo11">TOTAL</span></span></td>
                          <td width="64"><span class="Estilo5"><span class="Estilo11">CANTIDAD</span></span></td>
                          <td width="59"><span class="Estilo5"><span class="Estilo11">PRECIOS</span></span></td>
                          <td width="76"><span class="Estilo5"><span class="Estilo11">C&Eacute;DULA/RIF</span></span></td>
                          <td width="33"><span class="Estilo5"><span class="Estilo11">NUM.</span></span></td>
                          <td width="19"><span class="Estilo5"><span class="Estilo11">ST.</span></span></td>
                          <td width="92"><span class="Estilo5"><span class="Estilo11">DESCRIPCI&Oacute;N </span></span></td>
                          <td width="50"><span class="Estilo5"><span class="Estilo11">SELC.</span></span></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="753" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><span class="Estilo5"><span class="Estilo11">PUNTOS </span></span></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="852" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="24">&nbsp;</td>
                      <td width="36"><span class="Estilo5"></span></td>
                      <td width="23"><span class="Estilo5"><span class="Estilo11">
                        <label></label>
                      </span></span></td>
                      <td width="516"><span class="Estilo5"><span class="Estilo11"> </span></span></td>
                      <td width="77"><span class="Estilo5"><span class="Estilo11"><span class="Estilo15">TOTALES : </span> </span></span></td>
                      <td width="176"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtTot_Precios2" type="text" class="Estilo5" id="txtTot_Precios" size="15" maxlength="15" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
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