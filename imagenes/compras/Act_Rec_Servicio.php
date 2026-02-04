<?php include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP COMPRAS Y ALMAC&Eacute;N (Recepci&oacute;n de Art&iacute;culos)</title>
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
    <td width="836"><div align="center" class="Estilo2 Estilo6"> RECEPCI&Oacute;N DE SERVICIOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="569" border="1" id="tablacuerpo">
  <tr>
    <td width="98" height="563"><table width="92" height="568" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_Rec_Servicio.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu
            href="Inc_Rec_Servicio.php">Incluir</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu
            href="Cons_Rec_Articulos.php">Consultar</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu
            href="javascript:Mover_Registro('P');">Primero</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
  <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
  </tr><tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_cuentas.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_act_cuentas.php" class="menu">Catalogo</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu
            href="Eliminar_Rec_Servicio.php">Eliminar</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu_p.php">Menu Proceso</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="923">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:862px; height:507px; z-index:1; top: 68px; left: 120px;">
        <form name="form1" method="post">
          <table width="862" height="469" border="0">
                <tr>
                  <td width="883" height="24"><table width="856" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="165"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO DE RECEPCI&Oacute;N :</span></span></td>
                      <td width="173"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Recepcion" type="text" class="Estilo5" id="txtNro_Recepcion"  value="<?php echo $Nro_Recepcion ?>" size="8" maxlength="8" readonly>
                      </span></span></td>
                      <td width="120"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO ORDEN : </span></span></td>
                      <td width="78"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Orden" type="text" class="Estilo5" id="txtNro_Orden"  value="<?php echo $Nro_Orden ?>" size="8" maxlength="8" readonly>
                      </span></span></td>
                      <td width="115"><span class="Estilo5">                      </span></td>
                      <td width="54"><span class="Estilo5"><span class="Estilo11">FECHA :</span></span></td>
                      <td width="101"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFecha" type="text" class="Estilo5" id="txtFecha"  value="<?php echo $Fecha ?>" size="10" maxlength="10" readonly>
</span></span></td>
                      <td width="50"><img src="../pagos/b_info.png" width="11" height="11"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="845" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="133"><span class="Estilo5"><span class="Estilo11">TIPO MOVIMIENTO  : </span></span></td>
                      <td width="106"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCod_Tipo_Mov" type="text" class="Estilo5" id="txtCod_Tipo_Mov"  value="<?php echo $Cod_Tipo_mov ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="593"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDes_Tipo_Mov" type="text" class="Estilo5" id="txtDes_Tipo_Mov"  value="<?php echo $Des_Tipo_Mov ?>" size="103" maxlength="102" readonly>
                      </span></span></td>
                      <td width="13">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24"><table width="845" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="92"><span class="Estilo5"><span class="Estilo11">PROVEEDOR : </span></span></td>
                      <td width="112"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCed_Rif" type="text" class="Estilo5" id="txtCed_Rif"  value="<?php echo $Ced_Rif ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="627"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNombre_Proveedor" type="text" class="Estilo5" id="txtNombre_Proveedor"  value="<?php echo $Nombre_Proveedor ?>" size="110" maxlength="109" readonly>
                      </span></span></td>
                      <td width="14">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24"><table width="858" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="142"><span class="Estilo5"><span class="Estilo11">TIPO DE RECEPCI&Oacute;N :</span></span></td>
                      <td width="174"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtTipo_Recepcion" type="text" class="Estilo5" id="txtNro_Orden4"  value="<?php echo $Tipo_Recepcion ?>" size="28" maxlength="27" readonly>
                      </span></span></td>
                      <td width="149"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO DE FACTURA : </span></span></td>
                      <td width="71"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Factura" type="text" class="Estilo5" id="txtNro_Orden3"  value="<?php echo $Nro_Factura ?>" size="8" maxlength="8" readonly>
</span></span></td>
                      <td width="168"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO NOTA ENTREGA :</span></span></td>
                      <td width="154"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Nota_Entrega" type="text" class="Estilo5" id="txtNro_Orden5"  value="<?php echo $Nro_Nota_Entrega ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24"><table width="830" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="134"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO ALMAC&Eacute;N :</span></span></td>
                      <td width="72"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCod_Almacen" type="text" class="Estilo5" id="txtCod_Almacen"  value="<?php echo $Cod_Almacen ?>" size="8" maxlength="8" readonly>
</span></span></td>
                      <td width="383"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDes_Almacen" type="text" class="Estilo5" id="txtNro_Requisicion14"  value="<?php echo $Des_Almacen ?>" size="67" maxlength="67" readonly>
</span></span></td>
                      <td width="112"><span class="Estilo5"><span class="Estilo11">COMPROBANTE :</span></span></td>
                      <td width="129"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Comprobante" type="text" class="Estilo5" id="txtNro_Requisicion15"  value="<?php echo $Nro_Comprobante ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo5"><span class="Estilo10">ART&Iacute;CULOS A RECIBIR </span></span></td>
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
                  <td height="24"><table width="826" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td width="123" height="14"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO ART&Iacute;CULO </span></span></td>
                      <td width="106"><span class="Estilo5"><span class="Estilo11">CANT. RECIBIDA </span></span></td>
                      <td width="133"><span class="Estilo5"><span class="Estilo11">CANT. POR RECIBIR </span></span></td>
                      <td width="147"><span class="Estilo5"><span class="Estilo11">CANTIDAD DEVUELTA </span></span></td>
                      <td width="50"><span class="Estilo5"><span class="Estilo11">MONTO</span></span></td>
                      <td width="241"><span class="Estilo5"><span class="Estilo11">DENOMINACI&Oacute;N DEL ART&Iacute;CULO</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="826" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td width="49" height="14"><span class="Estilo5"><span class="Estilo11">UNIDAD</span></span></td>
                      <td width="66"><span class="Estilo5"><span class="Estilo11">IMPUESTO</span></span></td>
                      <td width="48"><span class="Estilo5"><span class="Estilo11">MARCA </span></span></td>
                      <td width="55"><span class="Estilo5"><span class="Estilo11">MODELO</span></span></td>
                      <td width="25"><span class="Estilo5"><span class="Estilo11">P/A</span></span></td>
                      <td width="69"><span class="Estilo5"><span class="Estilo11">RELACI&Oacute;N</span></span></td>
                      <td width="49"><span class="Estilo5"><span class="Estilo11">COSTO</span></span></td>
                      <td width="122"><span class="Estilo5"><span class="Estilo11">COSTO PROMEDIO</span></span></td>
                      <td width="305"><span class="Estilo5"><span class="Estilo11">CANTIDAD PROMEDIO</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="830" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="635">&nbsp;</td>
                      <td width="63"><span class="Estilo5"><span class="Estilo15">TOTAL : </span></span></td>
                      <td width="154"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtTotal_Recepcion" type="text" class="Estilo5" id="txtcedula332524222222222" size="15" maxlength="15" readonly>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo5"><span class="Estilo10">INFORMACI&Oacute;N DE LA RECEPCI&Oacute;N</span></span></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="24"><table width="846" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="121"><span class="Estilo5"><span class="Estilo11">OBSERVACIONES  :</span></span></td>
                      <td width="725"><span class="Estilo5"><span class="Estilo11">
                      <textarea name="txtObservaciones" cols="105" readonly="readonly" class="Estilo5" id="txtNro_Requisicion16"><?php echo $Observaciones ?></textarea>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="847" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="108"><span class="Estilo5"><span class="Estilo11">RECIBIDO POR  :</span></span></td>
                      <td width="739"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRecibido_Por" type="text" class="Estilo5" id="txtNro_Requisicion17"  value="<?php echo $Recibido_Por ?>" size="129" maxlength="129" readonly>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="771" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="61"><span class="Estilo5"><span class="Estilo11">CARGO :</span></span></td>
                      <td width="710"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCargo_Recibe" type="text" class="Estilo5" id="txtNro_Requisicion18"  value="<?php echo $Cargo_Recibe ?>" size="76" maxlength="75" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="787" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="114"><span class="Estilo5"><span class="Estilo11">DEPARTAMENTO :</span></span></td>
                      <td width="673"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDepart_Recibe" type="text" class="Estilo5" id="txtNro_Requisicion19"  value="<?php echo $Depart_Recibe ?>" size="65" maxlength="65" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="791" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="140"><span class="Estilo5"><span class="Estilo11">OTRA INFORMACI&Oacute;N  :</span></span></td>
                      <td width="651"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtOtra_informacion" type="text" class="Estilo5" id="txtNro_Requisicion20"  value="<?php echo $Otra_Informacion ?>" size="60" maxlength="60" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
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