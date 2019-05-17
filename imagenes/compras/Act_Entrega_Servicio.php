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
<title>SIA COMPRAS Y ALMAC&Eacute;N (Entrega de Servicio)</title>
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
    <td width="836"><div align="center" class="Estilo2 Estilo6">ENTREGA DE SERVICIO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="985" height="725" border="1" id="tablacuerpo">
  <tr>
    <td width="98" height="719"><table width="92" height="709" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cons_Entrega_Servicio.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Inc_Entrega_Servicio.php">Incluir</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Modf_Entrega_Servicio.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu
            href="javascript:LlamarURL('Modf_Entrega_Servicio.php');">Modificar</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Cons_Entrega_Servicio.php">Consultar</a></div></td>
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
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="menu.php" class="menu">Menu Principal </a></div></td>
  </tr>
  <tr>
    <td><div align="center"></div></td>
  </tr>
    </table></td>
    <td width="923">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:870px; height:696px; z-index:1; top: 68px; left: 120px;">
        <form name="form1" method="post">
          <table width="862" height="272" border="0">
                <tr>
                  <td width="883" height="24"><table width="862" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="153"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO DE ENTREGA :</span></span></td>
                      <td width="180"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Entrega" type="text" class="Estilo5" id="txtNro_Entrega"  value="<?echo $Nro_Entrega ?>" size="12" maxlength="8" readonly>
</span></span></td>
                      <td width="166"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO DE SOLICITUD :</span></span></td>
                      <td width="177"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Solicitud" type="text" class="Estilo5" id="txtNro_Solicitud"  value="<?echo $Nro_Solicitud ?>" size="12" maxlength="8" readonly>
                      </span></span></td>
                      <td width="57"><span class="Estilo5"><span class="Estilo11">FECHA :</span></span></td>
                      <td width="97"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFecha" type="text" class="Estilo5" id="txtFecha"  value="<?echo $Fecha ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="32"><img src="../pagos/b_info.png" width="11" height="11"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24"><table width="830" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="179"><span class="Estilo5"><span class="Estilo11">CATGOR&Iacute;A PROGRAMATICA  :</span></span></td>
                      <td width="81"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtUnidad" type="text" class="Estilo5" id="txtUnidad"  value="<?echo $Unidad ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="570"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNombre_Unidad" type="text" class="Estilo5" id="txtNombre_Unidad"  value="<?echo $Nombre_Unidad ?>" size="105" maxlength="104" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24"><table width="836" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="198"><span class="Estilo5"><span class="Estilo11">DEPARTAMENTO  SOLICITANTE   :</span></span></td>
                      <td width="638"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDep_Solicitante" type="text" class="Estilo5" id="txtDep_Solicitante"  value="<?echo $Dep_Solicitante ?>" size="117" maxlength="117" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo5"><span class="Estilo10">SERVICIOS A ENTREGAR </span></span></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="858" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="197" height="70"><span class="Estilo5"><span class="Estilo11">DESCRIPCI&Oacute;N DEL SERVICIO :</span></span></td>
                      <td width="661"><span class="Estilo5"><span class="Estilo11">
                      <textarea name="txtDes_Servicio" cols="96" readonly="readonly" class="Estilo5" id="txtNro_Recepcion72"><?echo $Des_Servicio ?></textarea>
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
                  <td height="14"><table width="763" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td width="154" height="14"><span class="Estilo5"><span class="Estilo11">CANTIDAD SOLICITADA</span></span></td>
                      <td width="66"><span class="Estilo5"><span class="Estilo11">UNIDAD</span></span></td>
                      <td width="104"><span class="Estilo5"><span class="Estilo11">DESCRIPCI&Oacute;N</span></span></td>
                      <td width="63"><span class="Estilo5"><span class="Estilo11">MONTO</span></span></td>
                      <td width="50"><span class="Estilo5"><span class="Estilo11">TOTAL</span></span></td>
                      <td width="300"><span class="Estilo5"><span class="Estilo11">TASA IMPUESTO </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="852" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="548">&nbsp;</td>
                      <td width="61"><span class="Estilo5"><span class="Estilo15">TOTAL : </span></span></td>
                      <td width="243"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula33252422222222" type="text" class="Estilo5" id="txtcedula33252422222222" size="15" maxlength="15" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo5"><span class="Estilo10">INFORMACI&Oacute;N DE LA ENTREGA </span></span></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="862" height="279" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td height="24"><table width="835" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="119"><span class="Estilo5"><span class="Estilo11">OBSERVACIONES :</span></span></td>
                            <td width="716"><span class="Estilo5"><span class="Estilo11">
                            <textarea name="txtObservaciones" cols="109" readonly="readonly" class="Estilo5" id="txtObservaciones"><?echo $Observaciones ?></textarea>
                            </span></span></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="48"><table width="860" border="0" cellspacing="4" cellpadding="0">
                          <tr>
                            <td colspan="2"><span class="Estilo5"><span class="Estilo11"> ENTREGADO POR :</span></span></td>
                            <td colspan="3"><span class="Estilo5"><span class="Estilo11">
                            <input name="txtEntregado_Por" type="text" class="Estilo5" id="txtEntregado_Por"  value="<?echo $Entregado_Por ?>" size="127" maxlength="127" readonly>
</span></span></td>
                          </tr>
                          <tr>
                            <td width="76"><span class="Estilo5"><span class="Estilo11">CARGO :</span></span></td>
                            <td width="51"><span class="Estilo5"><span class="Estilo11">
                            <input name="txtCargo_Entrega" type="text" class="Estilo5" id="txtCargo_Entrega"  value="<?echo $Cargo_Entrega ?>" size="10" maxlength="9" readonly>
                            </span></span></td>
                            <td width="332">&nbsp;</td>
                            <td width="107"><span class="Estilo5"><span class="Estilo11">DEPATAMENTO :</span></span></td>
                            <td width="270"><span class="Estilo5"><span class="Estilo11">
                            <input name="txtDepart_Entrega" type="text" class="Estilo5" id="txtDepart_Entrega"  value="<?echo $Depart_Entrega ?>" size="38" maxlength="37" readonly>
</span></span></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="58"><table width="860" border="0" cellspacing="4" cellpadding="0">
                        <tr>
                          <td colspan="2"><span class="Estilo5"><span class="Estilo11"> RECIBIDO POR :</span></span></td>
                          <td colspan="3"><span class="Estilo5"><span class="Estilo11">
                            <input name="txtRecibido_Por1" type="text" class="Estilo5" id="txtRecibido_Por1"  value="<?echo $Recibido_Por1 ?>" size="127" maxlength="8" readonly>
                          </span></span></td>
                        </tr>
                        <tr>
                          <td width="76"><span class="Estilo5"><span class="Estilo11">CARGO :</span></span></td>
                          <td width="51"><span class="Estilo5"><span class="Estilo11">
                            <input name="txtCargo1" type="text" class="Estilo5" id="txtCargo1"  value="<?echo $Cargo1 ?>" size="10" maxlength="9" readonly>
                          </span></span></td>
                          <td width="332">&nbsp;</td>
                          <td width="105"><span class="Estilo5"><span class="Estilo11">DEPATAMENTO :</span></span></td>
                          <td width="272"><span class="Estilo5"><span class="Estilo11">
                            <input name="txtDepartamento1" type="text" class="Estilo5" id="txtDepartamento1"  value="<?echo $Departamento1 ?>" size="38" maxlength="37" readonly>
                          </span></span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="14"><table width="860" border="0" cellspacing="4" cellpadding="0">
                        <tr>
                          <td colspan="2"><span class="Estilo5"><span class="Estilo11"> RECIBIDO POR :</span></span></td>
                          <td colspan="3"><span class="Estilo5"><span class="Estilo11">
                            <input name="txtRecibido_Por2" type="text" class="Estilo5" id="txtRecibido_Por2"  value="<?echo $Recibido_Por2 ?>" size="127" maxlength="8" readonly>
                          </span></span></td>
                        </tr>
                        <tr>
                          <td width="76"><span class="Estilo5"><span class="Estilo11">CARGO :</span></span></td>
                          <td width="51"><span class="Estilo5"><span class="Estilo11">
                            <input name="txtCargo2" type="text" class="Estilo5" id="txtCargo2"  value="<?echo $Cargo2 ?>" size="10" maxlength="9" readonly>
                          </span></span></td>
                          <td width="332">&nbsp;</td>
                          <td width="106"><span class="Estilo5"><span class="Estilo11">DEPATAMENTO :</span></span></td>
                          <td width="271"><span class="Estilo5"><span class="Estilo11">
                            <input name="txtDepartamento2" type="text" class="Estilo5" id="txtDepartamento2"  value="<?echo $Departamento2 ?>" size="38" maxlength="37" readonly>
                          </span></span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="14"><table width="860" border="0" cellspacing="4" cellpadding="0">
                        <tr>
                          <td colspan="2"><span class="Estilo5"><span class="Estilo11"> RECIBIDO POR :</span></span></td>
                          <td colspan="3"><span class="Estilo5"><span class="Estilo11">
                            <input name="txtRecibido_Por3" type="text" class="Estilo5" id="txtRecibido_Por3"  value="<?echo $Recibido_Por3 ?>" size="127" maxlength="8" readonly>
                          </span></span></td>
                        </tr>
                        <tr>
                          <td width="76"><span class="Estilo5"><span class="Estilo11">CARGO :</span></span></td>
                          <td width="51"><span class="Estilo5"><span class="Estilo11">
                            <input name="txtCargo3" type="text" class="Estilo5" id="txtCargo3"  value="<?echo $Cargo3 ?>" size="10" maxlength="9" readonly>
                          </span></span></td>
                          <td width="332">&nbsp;</td>
                          <td width="109"><span class="Estilo5"><span class="Estilo11">DEPATAMENTO :</span></span></td>
                          <td width="268"><span class="Estilo5"><span class="Estilo11">
                            <input name="txtDepartamento3" type="text" class="Estilo5" id="txtDepartamento3"  value="<?echo $Departamento3 ?>" size="37" maxlength="37" readonly>
                          </span></span></td>
                        </tr>
                      </table></td>
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
<? pg_close();?>