<?php include ("../class/seguridad.inc");?>
<?php include ("../class/conects.php");  include ("../class/funciones.php");
if (!$_GET){
  $codigo_cuenta='';
  $p_letra='';
  $sql="SELECT * FROM CON001 ORDER BY codigo_cuenta";
} else {
  $codigo_cuenta = $_GET["Gcodigo_cuenta"];
  $p_letra=substr($codigo_cuenta, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$codigo_cuenta=substr($codigo_cuenta,1,20);}
  $sql="Select * from con001 where codigo_cuenta='$codigo_cuenta'";
  if ($p_letra=="P"){$sql="SELECT * FROM CON001 ORDER BY codigo_cuenta";}
  if ($p_letra=="U"){$sql="SELECT * From CON001 Order by Codigo_Cuenta Desc";}
  if ($p_letra=="S"){$sql="SELECT * From CON001 Where (Codigo_Cuenta>'$codigo_cuenta') Order by Codigo_Cuenta";}
  if ($p_letra=="A"){$sql="SELECT * From CON001 Where (Codigo_Cuenta<'$codigo_cuenta') Order by Codigo_Cuenta Desc";}
}
?>
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
    <td width="836"><div align="center" class="Estilo2 Estilo6">  DEVOLUCI&Oacute;N RECEPCI&Oacute;N DE ART&Iacute;CULOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="470" border="1" id="tablacuerpo">
  <tr>
    <td width="98" height="446"><table width="92" height="462" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_Dev_Recepcion.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu
            href="Inc_Dev_Recepcion.php">Incluir</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu
            href="Cons_Dev_Recepcion.php">Consultar</a></td>
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
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu_a.php">Menu Archivo</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="923">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:862px; height:449px; z-index:1; top: 70px; left: 120px;">
        <form name="form1" method="post">
          <table width="862" height="287" border="0">
                <tr>
                  <td width="883" height="22"><table width="856" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="155"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO DEVOLUCI&Oacute;N :</span></span></td>
                      <td width="76"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Devolucion" type="text" class="Estilo5" id="txtNro_Devolucion"  value="<?php echo $Nro_Devolucion ?>" size="8" maxlength="8" readonly>
</span></span></td>
                      <td width="144"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO RECEPCI&Oacute;N : </span></span></td>
                      <td width="56"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Recepcion" type="text" class="Estilo5" id="txtCod_Articulo"  value="<?php echo $Cod_Articulo ?>" size="8" maxlength="8" readonly>
                      </span></span></td>
                      <td width="62"><span class="Estilo5">
                      </span></td>
                      <td width="53"><span class="Estilo5"><span class="Estilo11">
                      FECHA :
                    </span></span></td>
                      <td width="83"><span class="Estilo5"><span class="Estilo11"> 
                      <input name="txtFecha" type="text" class="Estilo5" id="txtCod_Articulo2"  value="<?php echo $Fecha ?>" size="10" maxlength="10" readonly>
                      </span>
                      </span></td>
                      <td width="118"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO ORDEN :</span></span></td>
                      <td width="88"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Orden" type="text" class="Estilo5" id="txtCod_Articulo3"  value="<?php echo $Nro_Orden ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="21"><img src="../pagos/b_info.png" width="11" height="11"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="856" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="130"><span class="Estilo5"><span class="Estilo11">TIPO MOVIMIENTO  : </span></span></td>
                      <td width="53"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCod_Tipo_Mov" type="text" class="Estilo5" id="txtCod_Articulo4"  value="<?php echo $Cod_Tipo_Mov ?>" size="3" maxlength="2" readonly>
                      </span></span></td>
                      <td width="673"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDes_Tipo_Mov" type="text" class="Estilo5" id="txtCod_Articulo5"  value="<?php echo $Des_Tipo_Mov ?>" size="123" maxlength="122" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="22"><table width="856" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="149"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO DE FACTURA : </span></span></td>
                      <td width="431"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Factura" type="text" class="Estilo5" id="txtNro_Factura"  value="<?php echo $Nro_Factura ?>" size="8" maxlength="8" readonly>
</span></span></td>
                      <td width="167"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO NOTA ENTREGA  :</span></span></td>
                      <td width="109"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Factura" type="text" class="Estilo5" id="txtNro_Factura"  value="<?php echo $Nro_Factura ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24"><table width="858" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="128"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO ALMAC&Eacute;N :</span></span></td>
                      <td width="75"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCod_Almacen" type="text" class="Estilo5" id="txtCod_Articulo842"  value="<?php echo $Cod_Almacen ?>" size="8" maxlength="8" readonly>
                      </span></span></td>
                      <td width="434"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDes_Almacen" type="text" class="Estilo5" id="txtCod_Articulo86"  value="<?php echo $Des_Almacen ?>" size="78" maxlength="78" readonly>
</span></span></td>
                      <td width="109"><span class="Estilo5"><span class="Estilo11">COMPROBANTE :</span></span></td>
                      <td width="112"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCod_Articulo83" type="text" class="Estilo5" id="txtCod_Articulo83"  value="<?php echo $Cod_Articulo ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="850" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="100"><span class="Estilo5"><span class="Estilo11">DESCRIPCI&Oacute;N :</span></span></td>
                      <td width="750"><span class="Estilo5"><span class="Estilo11">
                      <textarea name="txtDescripcion" cols="116" readonly="readonly" class="Estilo5" id="txtCod_Articulo88"><?php echo $Descripcion ?></textarea>
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
                      <input name="txtTotal_Devolucion" type="text" class="Estilo5" id="txtcedula332524222222222" size="15" maxlength="15" readonly>
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