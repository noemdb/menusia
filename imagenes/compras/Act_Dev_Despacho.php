<?include ("../class/seguridad.inc");?>
<?include ("../class/conects.php");  include ("../class/funciones.php");
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
<title>SIA COMPRAS Y ALMAC&Eacute;N (Devoluci&oacute;n Despacho de Art&iacute;culos)</title>
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
    <td width="836"><div align="center" class="Estilo2 Estilo6"> DEVOLUCI&Oacute;N DESPACHO DE ART&Iacute;CULOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="390" border="1" id="tablacuerpo">
  <tr>
    <td width="98" height="359"><table width="92" height="381" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_Tasas.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu
            href="Inc_Dev_Despacho.php">Incluir</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Modf_Tasas.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu
            href="Cons_Dev_Despacho.php">Consultar</a></td>
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
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="menu_p.php" class="menu">Men&uacute; Proceso</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="923">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:861px; height:380px; z-index:1; top: 68px; left: 120px;">
        <form name="form1" method="post">
          <table width="862" height="265" border="0">
                <tr>
                  <td width="883" height="22"><table width="853" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="181"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO DE DEVOLUCI&Oacute;N :</span></span></td>
                      <td width="94"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Devolucion2" type="text" class="Estilo5" id="txtNro_Devolucion22"  value="<?echo $Nro_Devolucion?>" size="8" maxlength="8" readonly>
</span></span></td>
                      <td width="164"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO DE DESPACHO : </span></span></td>
                      <td width="95"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Despacho" type="text" class="Estilo5" id="txtNro_Despacho"  value="<?echo $Nro_Despacho?>" size="8" maxlength="8" readonly>
                      </span></span></td>
                      <td width="180"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO DE REQUISICI&Oacute;N :</span></span></td>
                      <td width="85"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Requisicion" type="text" class="Estilo5" id="txtNro_Requisicion"  value="<?echo $Nro_Requisicion?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="54"><img src="../pagos/b_info.png" width="11" height="11"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24"><table width="854" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="57"><span class="Estilo5"><span class="Estilo11">FECHA :</span></span></td>
                      <td width="101"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFecha" type="text" class="Estilo5" id="txtFecha"  value="<?echo $Fecha?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="136"><span class="Estilo5"><span class="Estilo11">TIPO MOVIMIENTO :</span></span></td>
                      <td width="72"><span class="Estilo5"><span class="Estilo11">
                      <input name="txcod_tipo_mov" type="text" class="Estilo5" id="txcod_tipo_mov"  value="<?echo $cod_tipo_mov?>" size="8" maxlength="8" readonly>
                      </span></span></td>
                      <td width="488"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtcod_tipo_mov" type="text" class="Estilo5" id="txtcod_tipo_mov"  value="<?echo $cod_tipo_mov?>" size="79" maxlength="76" readonly>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="851" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="132"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO ALMAC&Eacute;N :</span></span></td>
                      <td width="75"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCod_Almacen" type="text" class="Estilo5" id="txtCod_Almacen"  value="<?echo $Cod_Almacen?>" size="8" maxlength="8" readonly>
                      </span></span></td>
                      <td width="644"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDes_Almacen" type="text" class="Estilo5" id="txtDes_Almacen"  value="<?echo $Des_Almacen?>" size="111" maxlength="110" readonly>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24"><table width="850" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="103"><span class="Estilo5"><span class="Estilo11">DESCRIPCI&Oacute;N :</span></span></td>
                      <td width="747"><span class="Estilo5"><span class="Estilo11">
                      <textarea name="txtDescripcion" cols="109" readonly="readonly" class="Estilo5" id="txtDescripcion"><?echo $Descripcion?></textarea>
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
                  <td height="22"><table width="838" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td width="130" height="14"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO ART&Iacute;CULO </span></span></td>
                      <td width="138"><span class="Estilo5"><span class="Estilo11">CANT. DESPACHADA </span></span></td>
                      <td width="122"><span class="Estilo5"><span class="Estilo11">CANT. DEVUELTA </span></span></td>
                      <td width="108"><span class="Estilo5"><span class="Estilo11">COSTO ACTUAL</span></span></td>
                      <td width="62"><span class="Estilo5"><span class="Estilo11">MONTO</span></span></td>
                      <td width="252"><span class="Estilo5"><span class="Estilo11">DENOMINACI&Oacute;N DEL ART&Iacute;CULO</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="705" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td width="49" height="14"><span class="Estilo5"><span class="Estilo11">UNIDAD</span></span></td>
                      <td width="66"><span class="Estilo5"><span class="Estilo11">IMPUESTO</span></span></td>
                      <td width="48"><span class="Estilo5"><span class="Estilo11">MARCA </span></span></td>
                      <td width="55"><span class="Estilo5"><span class="Estilo11">MODELO</span></span></td>
                      <td width="25"><span class="Estilo5"><span class="Estilo11">P/A</span></span></td>
                      <td width="69"><span class="Estilo5"><span class="Estilo11">RELACI&Oacute;N</span></span></td>
                      <td width="49"><span class="Estilo5"><span class="Estilo11">COSTO</span></span></td>
                      <td width="142"><span class="Estilo5"><span class="Estilo11">COSTO PROMEDIO</span></span></td>
                      <td width="164"><span class="Estilo5"><span class="Estilo11">CANTIDAD PROMEDIO</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="837" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="635">&nbsp;</td>
                      <td width="63"><span class="Estilo5"><span class="Estilo15">TOTAL : </span></span></td>
                      <td width="154"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtTotal_Devolucion" type="text" class="Estilo5" id="txtTotal_Devolucion" size="15" maxlength="15" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
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