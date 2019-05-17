<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="01-0000010"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');
if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){ $tipo_orden=''; $p_letra='';$sql="SELECT * FROM TIPOS_ORDEN ORDER BY tipo_orden";
} else {$tipo_orden = $_GET["Gtipo_orden"]; $p_letra=substr($tipo_orden, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$tipo_orden=substr($tipo_orden,1,4);}
  $sql="Select * from TIPOS_ORDEN where tipo_orden='$tipo_orden'";
  if ($p_letra=="P"){$sql="SELECT * FROM TIPOS_ORDEN ORDER BY tipo_orden";}
  if ($p_letra=="U"){$sql="SELECT * From TIPOS_ORDEN Order by tipo_orden Desc";}
  if ($p_letra=="S"){$sql="SELECT * From TIPOS_ORDEN Where (tipo_orden>'$tipo_orden') Order by tipo_orden";}
  if ($p_letra=="A"){$sql="SELECT * From TIPOS_ORDEN Where (tipo_orden<'$tipo_orden') Order by tipo_orden Desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Tipos de Orden)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;
var Gtipo_orden=document.form1.txttipo_orden.value; murl=url+Gtipo_orden;
    if (Gtipo_orden=="") {alert("Tipo de Orden debe ser Seleccionada");}    else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_tipos_orden.php";
   if(MPos=="P"){murl="Act_tipos_orden.php?Gtipo_orden=P"}
   if(MPos=="U"){murl="Act_tipos_orden.php?Gtipo_orden=U"}
   if(MPos=="S"){murl="Act_tipos_orden.php?Gtipo_orden=S"+document.form1.txttipo_orden.value;}
   if(MPos=="A"){murl="Act_tipos_orden.php?Gtipo_orden=A"+document.form1.txttipo_orden.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url;var r;
  r=confirm("Esta seguro en Eliminar el Tipo de Orden ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Tipo de Orden ?");
    if (r==true) {url="Delete_tipo_orden.php?txttipo_orden="+document.form1.txttipo_orden.value;
       VentanaCentrada(url,'Eliminar Tipo de Orden','','400','400','true');}
    }
   else { url="Cancelado, no elimino"; }
}
</script>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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
</head>
<?$nombre_cuenta="";$cargable=""; $des_tipo_orden="";$cod_contable="";$gen_tributo="";$cod_banco="";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}
else{$encontro=false;  if ($p_letra=="A"){  $sql="SELECT * From TIPOS_ORDEN Order by tipo_orden"; $res=pg_query($sql);  if ($registro=pg_fetch_array($res,0)){$encontro=true;}}}
if($encontro=true){  $tipo_orden=$registro["tipo_orden"];  $des_tipo_orden=$registro["des_tipo_orden"];
  $cod_contable=$registro["cod_contable_t"];  $cod_banco=$registro["cod_banco_t"];  $gen_tributo=$registro["gen_tributo"];  $status_1=$registro["status_1"];
  $status_2=$registro["status_2"];  $nombre_cuenta=$registro["nombre_cuenta"];  $nombre_banco=$registro["nombre_banco"];  $inf_usuario=$registro["inf_usuario"];
}
if($gen_tributo=="S"){$gen_tributo="SI";}else{$gen_tributo="NO";}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">TIPOS DE ORDEN </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="979" height="376" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="367" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
        <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_tipos_orden.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_tipos_orden.php">Incluir</A></td>
      </tr>
          <?} if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_tipos_orden.php?Gtipo_orden=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_tipos_orden.php?Gtipo_orden=');">Modificar</A></td>
      </tr>
          <?} if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
  <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
  </tr><tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_tipos_orden.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_tipos_orden.php" class="menu">Catalogo</a></td>
  </tr>
  <?} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
  </tr>
  <?} ?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Ventana_002('/sia/pagos/ayuda/ayuda_tipos_ordenes.htm','Ayuda SIA','','1000','1000','true');";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Ventana_002('/sia/pagos/ayuda/ayuda_tipos_ordenes.htm','Ayuda SIA','','1000','1000','true');" class="menu">Ayuda </a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="883">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 61px; left: 118px;">
            <form name="form1" method="post">
              <table width="868" height="188" border="0" align="center" >
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="844" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="163"><span class="Estilo5">C&Oacute;DIGO TIPO DE ORDEN:</span></td>
                      <td width="121"><div align="left"><span class="Estilo5">
                      <input class="Estilo10" name="txttipo_orden" type="text" id="txttipo_orden" size="8" maxlength="4"   value="<?echo $tipo_orden?>" readonly>
</span></div></td>
                      <td width="204">&nbsp;</td>
                      <td width="356"><span class="Estilo5">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="834" height="20" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="190"><span class="Estilo5">DESCRIPCI&Oacute;N TIPO DE ORDEN:</span></td>
                      <td width="634"><span class="Estilo5">
                        <input class="Estilo10" name="txtdes_tipo_orden" type="text" id="txtdes_tipo_orden"  readonly value="<?echo $des_tipo_orden?>" size="95">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="843" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="135"><span class="Estilo5">C&Oacute;DIGO CONTABLE  :</span></td>
                      <td width="188"><div align="left"><span class="Estilo5">
                          <input class="Estilo10" name="txtcod_contable" type="text" id="txtcod_contable"  readonly value="<?echo $cod_contable?>" size="25">
                      </span></div></td>
                      <td width="520"><span class="Estilo5">
                        <input class="Estilo10" name="txtnombre_cuenta" type="text" id="txtnombre_cuenta"  readonly value="<?echo $nombre_cuenta?>" size="75">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td width="883" height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="843" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="135"><span class="Estilo5">C&Oacute;DIGO DE BANCO :</span></td>
                      <td width="88"><div align="left"><span class="Estilo5">
                          <input class="Estilo10" name="txtcod_banco" type="text" id="txtcod_banco"  readonly value="<?echo $cod_banco?>" size="8" maxlength="15">
                      </span></div></td>
                      <td width="620"><span class="Estilo5">
                        <input class="Estilo10" name="txtnombre_banco" type="text" id="txtnombre_banco"  readonly value="<?echo $nombre_banco?>" size="90">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="24"><table width="843" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="135" height="22"><span class="Estilo5">GENERA TRIBUTO :</span></td>
                      <td width="708"><span class="Estilo5">
                        <input class="Estilo10" name="txtgen_tributo" type="text" id="txtgen_tributo"  readonly value="<?echo $gen_tributo?>" size="8" maxlength="2">
</span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
              </table>
              <p>&nbsp;</p>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>