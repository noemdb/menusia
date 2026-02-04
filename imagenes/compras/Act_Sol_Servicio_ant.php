<?php include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Solicitud de Servicio)</title>
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
    <td width="836"><div align="center" class="Estilo2 Estilo6"> SOLICITUD DE SERVICIO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="615" border="1" id="tablacuerpo">
  <tr>
    <td width="98" height="609"><table width="92" height="607" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_Sol_Servicio.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Inc_Sol_Servicio.php">Incluir</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Modf_Sol_Servicio.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Modf_Sol_Servicio.php">Modificar</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cons_Sol_Servicio.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Cons_Sol_Servicio.php">Consultar</a></div></td>
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
    <td width="923">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:855px; height:586px; z-index:1; top: 68px; left: 120px;">
        <form name="form1" method="post">
          <table width="853" height="554" border="0">
                <tr>
                  <td width="847" height="24"><table width="850" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="161"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO DE SOLICITUD :</span></span></td>
                      <td width="513"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Solicitud" type="text" class="Estilo5" id="txtNro_Solicitud"  value="<?php echo $Nro_Solicitud?>" size="8" maxlength="8" readonly>
                      </span></span></td>
                      <td width="55"><span class="Estilo5"><span class="Estilo11">FECHA :</span></span></td>
                      <td width="92"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFecha" type="text" class="Estilo5" id="txtFecha"  value="<?php echo $Fecha?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="22"><img src="../pagos/b_info.png" width="11" height="11"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24"><table width="851" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="180"><span class="Estilo5"><span class="Estilo11">CATGOR&Iacute;A PROGRAMATICA  :</span></span></td>
                      <td width="92"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtUnidad" type="text" class="Estilo5" id="txtUnidad"  value="<?php echo $Unidad?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="579"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNombre_Unidad" type="text" class="Estilo5" id="txtNombre_Unidad"  value="<?php echo $Nombre_Unidad?>" size="103" maxlength="103" readonly>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="22"><table width="853" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="151"><span class="Estilo5"><span class="Estilo11">UNIDAD  SOLICITANTE   :</span></span></td>
                      <td width="672"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDep_Solicitante" type="text" class="Estilo5" id="txtDep_Solicitante"  value="<?php echo $Dep_Solicitante?>" size="127" maxlength="127" readonly>
</span></span></td>
                      <td width="30"><span class="Estilo5">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo5"><span class="Estilo10">INFORMACI&Oacute;N</span></span></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="836" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="122"><span class="Estilo5"><span class="Estilo11">OBSERVACIONES :</span></span></td>
                      <td width="714"><span class="Estilo5"><span class="Estilo11">
                      <textarea name="txtObservaciones" cols="110" readonly="readonly" class="Estilo5" id="txtObservaciones"><?php echo $Observaciones?></textarea>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="852" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="144"><span class="Estilo5"><span class="Estilo11"> SOLICITUD EXTERNA :</span></span></td>
                      <td width="92"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtExterna" type="text" class="Estilo5" id="txtExterna"  value="<?php echo $Externa?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="239"><span class="Estilo5"><span class="Estilo11">N&Uacute;MERO DE LA SOLICITUD ALTERNA :</span></span></td>
                      <td width="71"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtNro_Sol_Ext" type="text" class="Estilo5" id="txtNro_Sol_Ext"  value="<?php echo $Nro_Sol_Ext?>" size="6" maxlength="6" readonly>
                      </span></span></td>
                      <td width="190"><span class="Estilo5"><span class="Estilo11">FECHA SOLICITUD ALTERNA :</span></span></td>
                      <td width="116"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFecha_Sol_Ext" type="text" class="Estilo5" id="txtcod_par_ramo292"  value="<?php echo $Fecha_Sol_Ext?>" size="10" maxlength="10" readonly>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="839" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="107"><span class="Estilo5"><span class="Estilo11">FECHA RECIBO  :</span></span></td>
                      <td width="88"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFecha_Recibido" type="text" class="Estilo5" id="txtFecha_Recibido"  value="<?php echo $Fecha_Recibido?>" size="8" maxlength="8" readonly>
</span></span></td>
                      <td width="109"><span class="Estilo5"><span class="Estilo11">RECIBIDO POR  :</span></span></td>
                      <td width="535"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtRecibido_Por" type="text" class="Estilo5" id="txtRecibido_Por"  value="<?php echo $Recibido_Por?>" size="96" maxlength="96" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="849" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="83"><span class="Estilo5"><span class="Estilo11">APROBADA :</span></span></td>
                      <td width="124"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtAprobada" type="text" class="Estilo5" id="txtcod_par_ramo2122"  value="<?php echo $Aprobada?>" size="8" maxlength="8" readonly>
</span></span></td>
                      <td width="144"><span class="Estilo5"><span class="Estilo11">FECHA APROBACI&Oacute;N  :</span></span></td>
                      <td width="174"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtFecha_Aprobada" type="text" class="Estilo5" id="txtFecha_Aprobada"  value="<?php echo $Fecha_Aprobada?>" size="13" maxlength="13" readonly>
</span></span></td>
                      <td width="119"><span class="Estilo5"><span class="Estilo11">ELABORADA POR  :</span></span></td>
                      <td width="205"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtUsuario_Sia" type="text" class="Estilo5" id="txtcod_par_ramo2142"  value="<?php echo $Usuario_Sia?>" size="28" maxlength="6" readonly>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="836" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="116"><span class="Estilo5"><span class="Estilo11">APROBADO POR  :</span></span></td>
                      <td width="720"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtAprobada_Por" type="text" class="Estilo5" id="txtAprobada_Por"  value="<?php echo $Aprobada_Por?>" size="134" maxlength="134" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="851" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="69"><span class="Estilo5"><span class="Estilo11">ESTATUS :</span></span></td>
                      <td width="72"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtStatus" type="text" class="Estilo5" id="txtStatus"  value="<?php echo $Status?>" size="8" maxlength="8" readonly>
                      </span></span></td>
                      <td width="710"><span class="Estilo5"><span class="Estilo11">
                      <input name="txtDes_Status" type="text" class="Estilo5" id="txtDes_Status"  value="<?php echo $Des_Status?>" size="129" maxlength="128" readonly>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo5"><span class="Estilo10">SERVICIOS</span></span></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="24"><table width="851" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="195"><span class="Estilo5"><span class="Estilo11">DESCRIPCI&Oacute;N DEL SERVICIO   :</span></span></td>
                      <td width="656"><span class="Estilo5"><span class="Estilo11">
                      <textarea name="txtDes_Servicio" cols="99" readonly="readonly" class="Estilo5" id="txtDes_Servicio"><?php echo $Des_Servicio?></textarea>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo13">SON LAS CELDAS</span></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="843" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td width="126" height="14"><span class="Estilo5"><span class="Estilo11">C&Oacute;DIGO SERVICIO </span></span></td>
                      <td width="79"><span class="Estilo5"><span class="Estilo11">CANTIDAD</span></span></td>
                      <td width="67"><span class="Estilo5"><span class="Estilo11">UNIDAD</span></span></td>
                      <td width="100"><span class="Estilo5"><span class="Estilo11">DESCRIPCI&Oacute;N</span></span></td>
                      <td width="57"><span class="Estilo5"><span class="Estilo11">MONTO</span></span></td>
                      <td width="51"><span class="Estilo5"><span class="Estilo11">TOTAL</span></span></td>
                      <td width="333"><span class="Estilo5"><span class="Estilo11">PRESUPUESTARIO</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="840" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="548">&nbsp;</td>
                      <td width="61"><span class="Estilo5"><span class="Estilo15">TOTAL : </span></span></td>
                      <td width="243"><span class="Estilo5"><span class="Estilo11">
                        <input name="txtcedula3325242222222" type="text" id="txtcedula3325242222222" size="15" maxlength="15" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><span class="Estilo5"><span class="Estilo11">
                  </span></span></td>
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