<?php include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP COMPRAS Y ALMAC&Eacute;N (Despacho de Art&iacute;culos)</title>
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
    <td width="836"><div align="center" class="Estilo2 Estilo6">DESPACHO DE ART&Iacute;CULOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="829" border="1" id="tablacuerpo">
  <tr>
    <td width="98" height="823"><table width="92" height="828" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_Despacho.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu
            href="Inc_Despacho.php">Incluir</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Modf_Despacho.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu
            href="Modf_Despacho.php">Modificar</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu
            href="Cons_Despacho.php">Consultar</a></td>
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
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu_p.php">Menu Proceso</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="923">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>      <div id="Layer1" style="position:absolute; width:861px; height:746px; z-index:1; top: 69px; left: 120px;">
        <form name="form1" method="post">
          <table width="862" height="532" border="0">
                <tr>
                  <td width="883" height="22"><table width="853" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="162"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO DE DESPACHO :</span></span></td>
                      <td width="149"><span class="Estilo5"><span class="Estilo11">
                      <input name="txTNro_Despacho" type="text" class="Estilo5" id="txTNro_Despacho"  value="<?php echo $Nro_Despacho?>" size="8" maxlength="8" readonly>
</span></span></td>
                      <td width="179"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO DE REQUISICI&Oacute;N : </span></span></td>
                      <td width="195"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Requisicion" type="text" class="Estilo5" id="txtNro_Requisicion2"  value="<?php echo $Nro_Requisicion?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="55"><span class="Estilo5"><span class="Estilo11">FECHA :</span></span></td>
                      <td width="84"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFecha" type="text" class="Estilo5" id="txtFecha2"  value="<?php echo $Fecha?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="29"><img src="../pagos/b_info.png" width="11" height="11"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24"><table width="834" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="131"><span class="Estilo5"><span class="Estilo11">TIPO MOVIMIENTO :</span></span></td>
                      <td width="68"><span class="Estilo5"><span class="Estilo11">
                      <input name="txcod_tipo_mov" type="text" class="Estilo5" id="txcod_tipo_mov"  value="<?php echo $cod_tipo_mov?>" size="8" maxlength="8" readonly>
                      </span></span></td>
                      <td width="635"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtcod_tipo_mov" type="text" class="Estilo5" id="txtcod_tipo_mov"  value="<?php echo $cod_tipo_mov?>" size="118" maxlength="117" readonly>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24"><table width="830" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="180"><span class="Estilo5"><span class="Estilo11">CATGOR&Iacute;A PROGRAMATICA  :</span></span></td>
                      <td width="77"><span class="Estilo5"><span class="Estilo11">
                      <input name="txcod_tipo_mov2" type="text" class="Estilo5" id="txcod_tipo_mov2"  value="<?php echo $cod_tipo_mov?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="573"><span class="Estilo5"><span class="Estilo11">
                      <input name="txcod_tipo_mov3" type="text" class="Estilo5" id="txcod_tipo_mov3"  value="<?php echo $cod_tipo_mov?>" size="107" maxlength="107" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24"><table width="836" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="201"><span class="Estilo5"><span class="Estilo11">DEPARTAMENTO SOLICITANTE   :</span></span></td>
                      <td width="635"><span class="Estilo5"><span class="Estilo11">
                      <input name="txDep_Solicitante" type="text" class="Estilo5" id="txDep_Solicitante"  value="<?php echo $Dep_Solicitante?>" size="118" maxlength="118" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24"><table width="839" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="128"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO ALMAC&Eacute;N :</span></span></td>
                      <td width="66"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCod_Almacen" type="text" class="Estilo5" id="txtCod_Almacen2"  value="<?php echo $Cod_Almacen?>" size="8" maxlength="8" readonly>
                      </span></span></td>
                      <td width="439"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDes_Almacen" type="text" class="Estilo5" id="txtCod_Almacen3"  value="<?php echo $Des_Almacen?>" size="78" maxlength="77" readonly>
                      </span></span></td>
                      <td width="109"><span class="Estilo5"><span class="Estilo11">COMPROBANTE :</span></span></td>
                      <td width="97"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCod_Almacen3" type="text" class="Estilo5" id="txtCod_Almacen32"  value="<?php echo $Cod_Almacen?>" size="10" maxlength="10" readonly>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo5"><span class="Estilo10">ART&Iacute;CULOS A DESPACHAR </span></span></td>
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
                      <td width="138" height="14"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO ART&Iacute;CULO </span></span></td>
                      <td width="129"><span class="Estilo5"><span class="Estilo11">CANT. DESPACHADA </span></span></td>
                      <td width="118"><span class="Estilo5"><span class="Estilo11">CANT. REQUERIDA </span></span></td>
                      <td width="114"><span class="Estilo5"><span class="Estilo11">CANT. DEVUELTA </span></span></td>
                      <td width="105"><span class="Estilo5"><span class="Estilo11">COSTO ACTUAL </span></span></td>
                      <td width="51"><span class="Estilo5"><span class="Estilo11">MONTO</span></span></td>
                      <td width="141"><span class="Estilo5"><span class="Estilo11">DENOMINACI&Oacute;N</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="22"><table width="818" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td width="85" height="14"><span class="Estilo5"><span class="Estilo11">EXISTENCIA</span></span></td>
                      <td width="67"><span class="Estilo5"><span class="Estilo11">IMPUESTO</span></span></td>
                      <td width="142"><span class="Estilo5"><span class="Estilo11">UNIDAD DE MEDIDA </span></span></td>
                      <td width="47"><span class="Estilo5"><span class="Estilo11">MARCA </span></span></td>
                      <td width="54"><span class="Estilo5"><span class="Estilo11">MODELO</span></span></td>
                      <td width="135"><span class="Estilo5"><span class="Estilo11">EXISTENCIA MINIMA</span></span></td>
                      <td width="28"><span class="Estilo5"><span class="Estilo11">P/A</span></span></td>
                      <td width="82"><span class="Estilo5"><span class="Estilo11">RELACI&Oacute;N</span></span></td>
                      <td width="110"><span class="Estilo5"><span class="Estilo11">COSTO</span></span></td>
                      <td width="26">&nbsp;</td>
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
                  <td height="14"><table width="835" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="123"><span class="Estilo5"><span class="Estilo11">OBSERVACIONES :</span></span></td>
                      <td width="712"><span class="Estilo5"><span class="Estilo11">
                      <textarea name="txtObservaciones" cols="113" readonly="readonly" class="Estilo5" id="txtObservaciones"><?php echo $Observaciones?></textarea>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="835" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="132"><span class="Estilo5"><span class="Estilo11">DESPACHADO POR :</span></span></td>
                      <td width="703"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDespachado_Por" type="text" class="Estilo5" id="txtCod_Almacen5"  value="<?php echo $Despachado_Por?>" size="134" maxlength="134" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="835" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="59"><span class="Estilo5"><span class="Estilo11">CARGO :</span></span></td>
                      <td width="776"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCargo_Despacho" type="text" class="Estilo5" id="txtCod_Almacen6"  value="<?php echo $Cargo_Despacho?>" size="149" maxlength="148" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="835" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="115"><span class="Estilo5"><span class="Estilo11">DEPARTAMENTO :</span></span></td>
                      <td width="720"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDepart_Despacho" type="text" class="Estilo5" id="txtCod_Almacen7"  value="<?php echo $Depart_Despacho?>" size="138" maxlength="137" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="835" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="109"><span class="Estilo5"><span class="Estilo11">RECIBIDO POR :</span></span></td>
                      <td width="726"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRecibido_Por1" type="text" class="Estilo5" id="txtDepart_Despacho"  value="<?php echo $Recibido_Por1?>" size="139" maxlength="138" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="835" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="59"><span class="Estilo5"><span class="Estilo11">CARGO :</span></span></td>
                      <td width="776"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCargo1" type="text" class="Estilo5" id="txtDepart_Despacho2"  value="<?php echo $Cargo1?>" size="149" maxlength="149" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="835" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="115"><span class="Estilo5"><span class="Estilo11">DEPARTAMENTO :</span></span></td>
                      <td width="720"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDepartamento1" type="text" class="Estilo5" id="txtDepart_Despacho3"  value="<?php echo $Departamento1?>" size="138" maxlength="137" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="835" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="109"><span class="Estilo5"><span class="Estilo11">RECIBIDO POR :</span></span></td>
                      <td width="726"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRecibido_Por2" type="text" class="Estilo5" id="txtRecibido_Por2"  value="<?php echo $Recibido_Por2?>" size="139" maxlength="138" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="835" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="59"><span class="Estilo5"><span class="Estilo11">CARGO :</span></span></td>
                      <td width="776"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCargo2" type="text" class="Estilo5" id="txtCargo2"  value="<?php echo $Cargo2?>" size="149" maxlength="149" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="835" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="115"><span class="Estilo5"><span class="Estilo11">DEPARTAMENTO :</span></span></td>
                      <td width="720"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDepartamento2" type="text" class="Estilo5" id="txtDepart_Despacho4"  value="<?php echo $Departamento2?>" size="138" maxlength="137" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="835" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="109"><span class="Estilo5"><span class="Estilo11">RECIBIDO POR :</span></span></td>
                      <td width="726"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRecibido_Por3" type="text" class="Estilo5" id="txtRecibido_Por3"  value="<?php echo $Recibido_Por3?>" size="139" maxlength="138" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="835" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="59"><span class="Estilo5"><span class="Estilo11">CARGO :</span></span></td>
                      <td width="776"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtCargo3" type="text" class="Estilo5" id="txtCargo3"  value="<?php echo $Cargo3?>" size="149" maxlength="149" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="835" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="115"><span class="Estilo5"><span class="Estilo11">DEPARTAMENTO :</span></span></td>
                      <td width="720"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDepartamento3" type="text" class="Estilo5" id="txtDepart_Despacho42"  value="<?php echo $Departamento3?>" size="138" maxlength="137" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
              <table width="864" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><table width="852" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="160" class="Estilo11">CANTIDAD EXISTENCIA :</td>
                      <td width="485"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula33252422222222" type="text" class="Estilo5" id="txtcedula33252422222222" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="59"><span class="Estilo5"><span class="Estilo15">TOTAL : </span></span></td>
                      <td width="148"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtTotal_Neto" type="text" class="Estilo5" id="txtTotal_Neto" size="15" maxlength="15" readonly>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
              <p>&nbsp;</p>
        </form>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    </div>    </td>
</tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>