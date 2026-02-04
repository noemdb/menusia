<?php  include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php");
$equipo = getenv("COMPUTERNAME"); $mcod_m = "COMP008".$usuario_sia.$equipo;
if (!$_GET){ $p_letra='';$criterio=''; $tipo_compromiso=''; $nro_orden=''; $sql="SELECT * FROM ORD_COMPRA ORDER BY nro_orden desc,tipo_compromiso desc";  $codigo_mov=substr($mcod_m,0,49);}
 else {   $codigo_mov="";  $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $nro_orden=substr($criterio,1,8);  $tipo_compromiso=substr($criterio,9,4);}
   else{$nro_orden=substr($criterio,0,8);  $tipo_compromiso=substr($criterio,8,4);}
  $codigo_mov=substr($mcod_m,0,49);   $clave=$nro_orden.$tipo_compromiso;
  $sql="Select * from ORD_COMPRA where tipo_compromiso='$tipo_compromiso' and nro_orden='$nro_orden'";
  if ($p_letra=="P"){$sql="SELECT * FROM ORD_COMPRA Order by nro_orden,tipo_compromiso";}
  if ($p_letra=="U"){$sql="SELECT * From ORD_COMPRA Order by nro_orden desc,tipo_compromiso desc";}
  if ($p_letra=="S"){$sql="SELECT * From ORD_COMPRA Where (text(nro_orden)||text(tipo_compromiso)>'$clave') Order by nro_orden,tipo_compromiso";}
  if ($p_letra=="A"){$sql="SELECT * From ORD_COMPRA Where (text(nro_orden)||text(tipo_compromiso)<'$clave') Order by text(nro_orden)||text(tipo_compromiso) desc";}
  }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP COMPRAS Y ALMAC&Eacute;N (Ordenes de Compras)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;
var Gnro_orden=document.form1.txtnro_orden.value; murl=url+Gnro_orden;
    if (Gnro_orden=="") {alert("Orden debe ser Seleccionada");}  else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_Orden_Compra.php";
   if(MPos=="P"){murl="Act_Orden_Compra.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_Orden_Compra.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_Orden_Compra.php?Gcriterio=S"+document.form1.txtnro_orden.value+document.form1.txttipo_compromiso.value;}
   if(MPos=="A"){murl="Act_Orden_Compra.php?Gcriterio=A"+document.form1.txtnro_orden.value+document.form1.txttipo_compromiso.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar la Orden de Compra ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Orden de Compra ?");
    if (r==true) {url="Delete_ord_compra.php?Gcriterio="+document.form1.txtnro_orden.value+document.form1.txttipo_compromiso.value;
       VentanaCentrada(url,'Eliminar Orden de Compra','','400','400','true');}
    }
   else { url="Cancelado, no elimino"; } }
}
</script>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
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

</style>
</head>
<?php  $conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if ($codigo_mov==""){$codigo_mov="";}
else{
 $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script> <?php }
 $res=pg_exec($conn,"SELECT BORRAR_PAG028('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script> <?php }
}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ORDENES DE COMPRAS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="1066" border="1" id="tablacuerpo">
  <tr>
    <td width="98" height="974"><table width="92" height="1056" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_Orden_Compra.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Inc_Orden_Compra.php">Incluir</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Modf_Orden_Compra.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Modf_Orden_Compra.php">Modificar</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Cons_Orden_Compra.php">Consultar</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu  href="javascript:Mover_Registro('P');">Primero</a></div></td>
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
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_Act_Orden_Compra.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="Cat_Act_Orden_Compra.php" class="menu">Catalogo</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu </a></div></td>
  </tr>
  <tr>
    <td><div align="center"></div></td>
  </tr>
    </table></td>
    <td width="1020">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>      <div id="Layer1" style="position:absolute; width:857px; height:961px; z-index:1; top: 70px; left: 123px;">
        <form name="form1" method="post">
          <table width="852" height="872" border="0">
                <tr>
                  <td width="840"><table width="845" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="137"><span class="Estilo5">N&Uacute;MERO DE ORDEN  :</span></span></td>
                      <td width="168"><span class="Estilo5">
                      <input name="txtnro_orden" type="text" class="Estilo5" id="txtnro_orden"  value="<?php echo $nro_orden ?>" size="15" maxlength="15" readonly>
</span></span></td>
                      <td width="188"><span class="Estilo5">DOCUMENTO COMPROMISO  :</span></span></td>
                      <td width="67"><span class="Estilo5">
                      <input name="txttipo_compromiso" type="text" class="Estilo5" id="txttipo_compromiso"  value="<?php echo $tipo_compromiso ?>" size="6" maxlength="6" readonly>
                      </span></span></td>
                      <td width="117"><span class="Estilo5">
                      <input name="txtNombre_Abrev" type="text" class="Estilo5" id="txtCod_Articulo2"  value="<?php echo $Nombre_Abrev ?>" size="6" maxlength="6" readonly>
                      </span></span></td>
                      <td width="54"><span class="Estilo5">FECHA    :</span></span></td>
                      <td width="88"><span class="Estilo5">
                      <input name="txtFecha" type="text" class="Estilo5" id="txtCod_Articulo3"  value="<?php echo $Fecha ?>" size="10" maxlength="10" readonly>
                      </span></span></td>
                      <td width="26"><img src="../imagenes/b_info.png" width="11" height="11"></td>
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
                      <td width="137"><span class="Estilo5">TIPO COMPROMISO  : </span></span></td>
                      <td width="109"><span class="Estilo5">
                      <input name="txtCod_Tipo_Comp" type="text" class="Estilo5" id="txtCod_Tipo_Comp"  value="<?php echo $Cod_Tipo_Comp ?>" size="15" maxlength="15" readonly>
</span></span></td>
                      <td width="599"><span class="Estilo5">
                      <input name="txtDes_Tipo_Comp" type="text" class="Estilo5" id="txtDes_Tipo_Comp"  value="<?php echo $Des_Tipo_Comp ?>" size="106" readonly>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="844" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="131"><span class="Estilo5">REQUISICI&Oacute;N NRO. :</span></span></td>
                      <td width="84"><span class="Estilo5">
                      <input name="txtNro_Requisicion" type="text" class="Estilo5" id="txtnro_requisicion"  value="<?php echo $Nro_Requisicion ?>" size="8" maxlength="8" readonly>
                      </span></span></td>
                      <td width="148"><span class="Estilo5">FECHA REQUISICI&Oacute;N :</span></span></td>
                      <td width="98"><span class="Estilo5">
                      <input name="txtFecha_Requisicion" type="text" class="Estilo5" id="txtFecha_Requisicion"  value="<?php echo $Fecha_Requisicion ?>" size="6" maxlength="6" readonly>
                      </span></span></td>
                      <td width="125"><span class="Estilo5">TIPO OPERACI&Oacute;N :</span></span></td>
                      <td width="110"><span class="Estilo5">
                      <input name="txtTipo_Operacion" type="text" class="Estilo5" id="txtTipo_Operacion"  value="<?php echo $Tipo_Operacion ?>" size="6" maxlength="6" readonly>
                      </span></span></td>
                      <td width="47"><span class="Estilo5">DIAS : </span></span></td>
                      <td width="101"><span class="Estilo5">
                      <input name="txtDias_Credito" type="text" class="Estilo5" id="txtDias_Credito"  value="<?php echo $Dias_Credito ?>" size="6" maxlength="6" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="24"><table width="846" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="123"><span class="Estilo5"> TIEMPO ENTREGA : </span></span></td>
                      <td width="42"><span class="Estilo5">
                      <input name="txtTiempo_Entrega" type="text" class="Estilo5" id="txtCod_Articulo12"  value="<?php echo $Tiempo_Entrega ?>" size="6" maxlength="6" readonly>
                      </span></span></td>
                      <td width="681">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="22"><table width="844" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="189"><span class="Estilo5">CATEGOR&Iacute;A PROGRAMATICA : </span></span></td>
                      <td width="109"><span class="Estilo5">
                      <input name="txtUnidad" type="text" class="Estilo5" id="txtCod_Articulo14"  value="<?php echo $Unidad ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="546"><span class="Estilo5">
                      <input name="txtNombre_Unidad" type="text" class="Estilo5" id="txtCod_Articulo15"  value="echo $Nombre_Unidad ?&gt;" size="95" maxlength="94" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="848" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="151"><span class="Estilo5">UNIDAD SOLICITANTE : </span></span></td>
                      <td width="658"><span class="Estilo5">
                      <input name="txtLugar_Entrega" type="text" class="Estilo5" id="txtCod_Articulo16"  value="<?php echo $Lugar_Entrega ?>" size="124" maxlength="124" readonly>
                      </span></span></td>
                      <td width="39"><span class="Estilo5">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="846" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="150"><span class="Estilo5">DIRECCI&Oacute;N ENTREGA  : </span></span></td>
                      <td width="696"><span class="Estilo5">
                      <input name="txtDireccion_Entrega" type="text" class="Estilo5" id="txtCod_Articulo17"  value="<?php echo $Direccion_Entrega ?>" size="124" maxlength="124" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="26"><table width="845" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="90"><span class="Estilo5">PROVEEDOR : </span></span></td>
                      <td width="109"><span class="Estilo5">
                      <input name="txtCed_Rif" type="text" class="Estilo5" id="txtCod_Articulo18"  value="<?php echo $Ced_Rif ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="632"><span class="Estilo5">
                      <input name="txtNombre" type="text" class="Estilo5" id="txtCod_Articulo19"  value="<?php echo $Nombre ?>" size="114" maxlength="112" readonly>
                      </span></span></td>
                      <td width="14">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="845" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="82"><span class="Estilo5">CONCEPTO : </span></span></td>
                      <td width="763"><span class="Estilo5">
                      <textarea name="txtDescripcion" cols="114" readonly="readonly" class="Estilo5" id="txtCod_Articulo21"><?php echo $Descripcion ?></textarea>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="846" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="160"><span class="Estilo5">N&Uacute;MERO DE PROYECTO  : </span></span></td>
                      <td width="110"><span class="Estilo5">
                      <input name="txtNum_Proyecto" type="text" class="Estilo5" id="txtCod_Articulo20"  value="<?php echo $Cod_Articulo ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="576"><span class="Estilo5">
                      <input name="txtDes_Proyecto" type="text" class="Estilo5" id="txtCod_Articulo22"  value="<?php echo $Des_Proyecto ?>" size="99" maxlength="98" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="846" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="176"><span class="Estilo5">FUENTE FINANCIAMIENTO  : </span></span></td>
                      <td width="108"><span class="Estilo5">
                      <input name="txtFuente_Financ" type="text" class="Estilo5" id="txtCod_Articulo26"  value="<?php echo $Fuente_Financ ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="562"><span class="Estilo5">
                      <input name="txtDes_Fuente" type="text" class="Estilo5" id="txtCod_Articulo24"  value="<?php echo $Des_Fuente ?>" size="96" maxlength="95" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="840" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="146"><span class="Estilo5">FECHA VENCIMIENTO :</span></span></td>
                      <td width="461"><span class="Estilo5">
                      <input name="txtFecha_Vencim" type="text" class="Estilo5" id="txtFecha_Vencim"  value="<?php echo $Fecha_Vencim ?>" size="8" maxlength="8" readonly>
                      </span></span></td>
                      <td width="133"><span class="Estilo5">APLICA IMPUESTO :</span></span></td>
                      <td width="100"><span class="Estilo5">
                      <input name="txtAplica_Impuesto" type="text" class="Estilo5" id="txtAplica_Impuesto"  value="<?php echo $Aplica_Impuesto ?>" size="5" maxlength="4" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="844" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="251"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO IMPUESTO :</span></span></td>
                      <td width="549"><span class="Estilo5">
                      <input name="txtCod_Pre_Impuesto" type="text" class="Estilo5" id="txtCod_Pre_Impuesto"  value="<?php echo $Cod_Pre_Impuesto ?>" size="103" maxlength="101" readonly>
                      </span></span></td>
                      <td width="44"><span class="Estilo5">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="842" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="108"><span class="Estilo5">TIPO DE GASTO :</span></span></td>
                      <td width="330"><span class="Estilo5">
                      <input name="txtTipo_Gasto" type="text" class="Estilo5" id="txtTipo_Gasto"  value="<?php echo $Tipo_Gasto ?>" size="24" maxlength="23" readonly>
                      </span></span></td>
                      <td width="208"><span class="Estilo5">IMPUTACI&Oacute;N PRESUPUESTARIA :</span></span></td>
                      <td width="196"><span class="Estilo5">
                      <input name="txtTipo_Imputacion" type="text" class="Estilo5" id="txtTipo_Imputacion"  value="<?php echo $Tipo_Imputacion ?>" size="24" maxlength="23" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="847" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="229"><span class="Estilo5">REFERENCIA CR&Eacute;DITO ADICIONAL :</span></span></td>
                      <td width="108"><span class="Estilo5">
                      <input name="txtRef_Imput_Presu" type="text" class="Estilo5" id="txtCod_Articulo28"  value="<?php echo $Ref_Imput_Presu ?>" size="15" maxlength="15" readonly>
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
                  <td height="14"><span class="Estilo5"><span class="Estilo10">ART&Iacute;CULOS</span></span></td>
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
                  <td height="14"><table width="614" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td width="126" height="14"><span class="Estilo5">C&Oacute;DIGO ART&Iacute;CULO </span></span></td>
                      <td width="118"><span class="Estilo5">CANT. ORDENADA</span></span></td>
                      <td width="102"><span class="Estilo5">COSTO ACTUAL </span></span></td>
                      <td width="54"><span class="Estilo5">MONTO</span></span></td>
                      <td width="192"><span class="Estilo5">DESCRIPCI&Oacute;N DEL ART&Iacute;CULO </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="703" border="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="214"><span class="Estilo5">TASA IMP. </span></span></td>
                      <td width="644"><span class="Estilo5">SE-PR-PY-AC-PAR-GE-ES-SE</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="585" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td width="53" height="14"><span class="Estilo5">FUENTE</span></span></td>
                      <td width="189"><span class="Estilo5">DENOMINACI&Oacute;N DEL C&Oacute;DIGO </span></span></td>
                      <td width="49"><span class="Estilo5">UNIDAD</span></span></td>
                      <td width="133"><span class="Estilo5">CANTIDAD RECIBIDA </span></span></td>
                      <td width="139"><span class="Estilo5">CANTIDAD AJUSTADA</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="759" border="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="113"><span class="Estilo5">CANT. DEVUELTA </span></span></td>
                      <td width="49"><span class="Estilo5">MARCA</span></span></td>
                      <td width="116"><span class="Estilo5">MONTO IVA </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="122" border="0" dwcopytype="CopyTableCell">
                    <tr>
                      <td width="116" height="14"><span class="Estilo5">TOTAL IVA </span></span></td>
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
                      <td width="131"><span class="Estilo5">TIENE LICITACI&Oacute;N  :</span></span></td>
                      <td width="78"><span class="Estilo5">
                      <input name="txtCod_Articulo284" type="text" class="Estilo5" id="txtCod_Articulo284"  value="<?php echo $Cod_Articulo ?>" size="8" maxlength="8" readonly>
</span></span></td>
                      <td width="127"><span class="Estilo5">Nro. DOCUMENTO  :</span></span></td>
                      <td width="238"><span class="Estilo5">
                      <input name="txtCod_Articulo26" type="text" class="Estilo5" id="txtCod_Articulo30"  value="<?php echo $Cod_Articulo ?>" size="40" maxlength="40" readonly>
</span></span></td>
                      <td width="120"><span class="Estilo5">FORMA DE PAGO :</span></span></td>
                      <td width="149"><span class="Estilo5">
                      <input name="txtCod_Articulo282" type="text" class="Estilo5" id="txtCod_Articulo282"  value="<?php echo $Cod_Articulo ?>" size="12" maxlength="12" readonly>
</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="841" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="148"><span class="Estilo5">TIENE ANTICIPACI&Oacute;N :</span></span></td>
                      <td width="110"><span class="Estilo5">
                      <input name="txtCod_Articulo283" type="text" class="Estilo5" id="txtCod_Articulo283"  value="<?php echo $Cod_Articulo ?>" size="15" maxlength="15" readonly>
                      </span></span></td>
                      <td width="205"><span class="Estilo5">PORCENTAJE DE ANTICIPO (%) :</span></span></td>
                      <td width="85"><span class="Estilo5">
                      <input name="txtCod_Articulo27" type="text" class="Estilo5" id="txtCod_Articulo31"  value="<?php echo $Cod_Articulo ?>" size="5" maxlength="5" readonly>
                      </span></span></td>
                      <td width="132"><span class="Estilo5">CUENTA ANTICIPO  :</span></span></td>
                      <td width="161"><span class="Estilo5">
                      <input name="txtCod_Articulo28" type="text" class="Estilo5" id="txtCod_Articulo32"  value="<?php echo $Cod_Articulo ?>" size="15" maxlength="15" readonly>
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
                      <td width="180" height="14"><span class="Estilo5">SE-PR-PY-AC-PAR-GE-ES-SE</span></span></td>
                      <td width="56"><span class="Estilo5">FUENTE</span></span></td>
                      <td width="84"><span class="Estilo5">DISPONIBLE</span></span></td>
                      <td width="48"><span class="Estilo5">MONTO</span></span></td>
                      <td width="193"><span class="Estilo5">DENOMINACI&Oacute;N DEL C&Oacute;DIGO</span></span></td>
                      <td width="68"><span class="Estilo5">MONTO R</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="756" border="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="298"><span class="Estilo5">C&Oacute;DIGO CONTABLE</span></span></td>
                      <td width="594"><span class="Estilo5">MONTO CR&Eacute;DITO</span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="840" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="537">&nbsp;</td>
                      <td width="136"><span class="Estilo5"><span class="Estilo15">TOTAL C&Oacute;DIGOS : </span></span></td>
                      <td width="167"><span class="Estilo5">
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
                      <td width="96"><span class="Estilo5">
                        <input name="txtcedula3325242222222222" type="text" class="Estilo5" id="txtcedula3325242222222222" size="12" maxlength="15" readonly>
                      </span></span></td>
                      <td width="92"><span class="Estilo5"><span class="Estilo15">SUB-TOTAL :</span></span></td>
                      <td width="102"><span class="Estilo5">
                        <input name="txtcedula3325242222222233" type="text" class="Estilo5" id="txtcedula3325242222222234" size="12" maxlength="15" readonly>
                      </span></span></td>
                      <td width="89"><span class="Estilo5"><span class="Estilo15">IMPUESTO :</span></span></td>
                      <td width="93"><span class="Estilo5">
                        <input name="txtcedula33252422222222322" type="text" class="Estilo5" id="txtcedula33252422222222322" size="12" maxlength="15" readonly>
                      </span></span></td>
                      <td width="110"><span class="Estilo5"><span class="Estilo15">TOTAL ORDEN : </span></span></td>
                      <td width="124"><span class="Estilo5">
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
<?php  pg_close($conn);?>