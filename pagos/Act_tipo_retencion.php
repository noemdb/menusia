<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="01-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){   $tipo_retencion='';  $p_letra='';$sql="SELECT * FROM RETENCIONES ORDER BY tipo_retencion";
} else {  $tipo_retencion = $_GET["Gtipo_retencion"];  $p_letra=substr($tipo_retencion, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$tipo_retencion=substr($tipo_retencion,1,3);}
  $sql="Select * from RETENCIONES where tipo_retencion='$tipo_retencion'";
  if ($p_letra=="P"){$sql="SELECT * FROM RETENCIONES ORDER BY tipo_retencion";}
  if ($p_letra=="U"){$sql="SELECT * From RETENCIONES Order by tipo_retencion Desc";}
  if ($p_letra=="S"){$sql="SELECT * From RETENCIONES Where (tipo_retencion>'$tipo_retencion') Order by tipo_retencion";}
  if ($p_letra=="A"){$sql="SELECT * From RETENCIONES Where (tipo_retencion<'$tipo_retencion') Order by tipo_retencion Desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Tipos de Retenci&oacute;n)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;
var Gtipo_retencion=document.form1.txttipo_retencion.value;    murl=url+Gtipo_retencion;
    if (Gtipo_retencion=="") {alert("Tipo de Retencion debe ser Seleccionada");} else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;   murl="Act_tipo_retencion.php";
   if(MPos=="P"){murl="Act_tipo_retencion.php?Gtipo_retencion=P"}
   if(MPos=="U"){murl="Act_tipo_retencion.php?Gtipo_retencion=U"}
   if(MPos=="S"){murl="Act_tipo_retencion.php?Gtipo_retencion=S"+document.form1.txttipo_retencion.value;}
   if(MPos=="A"){murl="Act_tipo_retencion.php?Gtipo_retencion=A"+document.form1.txttipo_retencion.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url;var r;
  r=confirm("Esta seguro en Eliminar el Tipo de RetenciOn ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Tipo de Retencion ?");
    if (r==true) {url="Delete_tipo_retencion.php?txttipo_retencion="+document.form1.txttipo_retencion.value;
       VentanaCentrada(url,'Eliminar Tipo de Retencion','','400','400','true');} }
   else { url="Cancelado, no elimino"; }
}
</script>
<SCRIPT language="JavaScript" src="../class/sia.js" type="text/javascript"></SCRIPT>
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
<?
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){  if ($p_letra=="S"){$sql="SELECT * From RETENCIONES Order by tipo_retencion";}
  if ($p_letra=="A"){$sql="SELECT * From RETENCIONES Order by tipo_retencion desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);
}
$descripcion_ret="";$ret_grupo="";$cod_contable="";$ced_rif="";$tasa=0;$base_imponible=0;$pago_mayor=0;$sustraendo=0;$red_operacion="";$status_1="";$status_2="";$nombre="";$nombre_cuenta="";$inf_usuario="";
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $tipo_retencion=$registro["tipo_retencion"];  $descripcion_ret=$registro["descripcion_ret"];  $ret_anticipo=$registro["ret_anticipo"];  $ret_grupo=$registro["ret_grupo"];
  $cod_contable=$registro["cod_contable"];  $cod_fondo=$registro["cod_fondo"];  $ced_rif=$registro["ced_rif_ret"];  $tasa=$registro["tasa"];
  $base_imponible=$registro["base_imponible"];  $pago_mayor=$registro["pago_mayor"];  $sustraendo=$registro["sustraendo"];  $red_operacion=$registro["red_operacion"];
  $status_1=$registro["status_1"];  $status_2=$registro["status_2"];  $nombre=$registro["nombre"];  $nombre_cuenta=$registro["nombre_cuenta"];  $inf_usuario=$registro["inf_usuario"];
}
$tasa=formato_monto($tasa);$base_imponible=formato_monto($base_imponible);$pago_mayor=formato_monto($pago_mayor);$sustraendo=formato_monto($sustraendo);
if($ret_grupo=="O"){$ret_grupo="OTROS";}if($ret_grupo=="N"){$ret_grupo="NOMINA";}
if($ret_grupo=="I"){$ret_grupo="ISLR";}if($ret_grupo=="A"){$ret_grupo="IVA";}
if($ret_grupo=="L"){$ret_grupo="LABORAL";}if($ret_grupo=="F"){$ret_grupo="FIEL CUM.";}
if($ret_grupo=="T"){$ret_grupo="TIMBRE FISCAL";}if($ret_grupo=="R"){$ret_grupo="RESPONSABILIDAD";}
if($ret_grupo=="M"){$ret_grupo="MINERALES";} if($ret_grupo=="E"){$ret_grupo="ACT ECONOMICA";}
if($red_operacion=="S"){$red_operacion="SI";}else{$red_operacion="NO";}
if($status_1=="S"){$status_1="SI";}else{$status_1="NO";}if($status_2=="S"){$status_2="SI";}else{$status_2="NO";}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">TIPOS DE RETENCI&Oacute;N </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="386" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="383" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
    <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_tipo_retencion.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_tipo_retencion.php">Incluir</A></td>
      </tr>
          <?} if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_tipo_retencion.php?Gtipo_retencion=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Mod_tipo_retencion.php?Gtipo_retencion=');">Modificar</A></td>
      </tr>
          <?} if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
	  <tr>
  <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
  </tr><tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_tipo_retencion.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_tipo_retencion.php" class="menu">Catalogo</a></td>
  </tr>
  <?} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
  </tr>
  <?} ?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Ventana_002('/sia/pagos/ayuda/ayuda_tipos_retenciones.htm','Ayuda SIA','','1000','1000','true');";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Ventana_002('/sia/pagos/ayuda/ayuda_tipos_retenciones.htm','Ayuda SIA','','1000','1000','true');" class="menu">Ayuda </a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu </a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 60px; left: 123px;">
            <form name="form1" method="post">
              <table width="868" height="252" border="0" align="center" >
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="844" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="59"><span class="Estilo5">TIPO :</span></td>
                      <td width="93"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txttipo_retencion" type="text" id="txttipo_retencion" size="6" maxlength="3" value="<?echo $tipo_retencion?>" readonly>   </span></div></td>
                      <td width="113"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                      <td width="562"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_ret" type="text" id="txtdescripcion_ret" size="80" value="<?echo $descripcion_ret?>" readonly>   </span></td>
                      <td width="17"><img src="../imagenes/b_info.png" width="11" height="11" onClick="javascript:alert('<?echo $inf_usuario?>');"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="835" height="18" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="60"><span class="Estilo5">TASA :</span></td>
                      <td width="167"><span class="Estilo5"><input class="Estilo10" name="txttasa" type="text" id="txttasa" size="8" maxlength="6"  value="<?echo $tasa?>" style="text-align:right" readonly>  </span></td>
                      <td width="130"><span class="Estilo5">BASE IMPONIBLE :</span></td>
                      <td width="168"><span class="Estilo5"><input class="Estilo10" name="txtbase_imponible" type="text" id="txtbase_imponible" size="8" maxlength="6"  style="text-align:right" value="<?echo $base_imponible?>" readonly>   </span></td>
                      <td width="136"><span class="Estilo5">PAGOS MAYOR A :</span></td>
                      <td width="174"><span class="Estilo5"><input class="Estilo10" name="txtpago_mayor" type="text" id="txtpago_mayor" size="18" maxlength="16"  value="<?echo $pago_mayor?>" style="text-align:right" readonly>  </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="835" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="100"><span class="Estilo5">SUSTRAENDO:</span></td>
                      <td width="177"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtsustraendo" type="text" id="txtsustraendo" size="18" maxlength="15"  value="<?echo $sustraendo?>" style="text-align:right" readonly></span></div></td>
                      <td width="162"><span class="Estilo5">REDONDEA OPERACI&Oacute;N: </span></td>
                      <td width="152"><span class="Estilo5"><input class="Estilo10" name="txtred_operacion" type="text" id="txtred_operacion" size="8" maxlength="15"  value="<?echo $red_operacion?>" readonly></span></td>
                      <td width="150"><span class="Estilo5">GRUPO DE RETENCI&Oacute;N :</span></td>
                      <td width="94"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtret_grupo" type="text" id="txtret_grupo" size="18" maxlength="18"  value="<?echo $ret_grupo?>" readonly></span></div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14"><table width="843" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="134"><span class="Estilo5">C&Oacute;DIGO CONTABLE  :</span></td>
                      <td width="203"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_contable" type="text" id="txtcod_contable" size="25" maxlength="25" value="<?echo $cod_contable?>" readonly>  </span></div></td>
                      <td width="116"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                      <td width="390"><span class="Estilo5"><input class="Estilo10" name="txtnombre_cuenta" type="text" id="txtnombre_cuenta" size="60" maxlength="60"  value="<?echo $nombre_cuenta?>" readonly> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td width="883" height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td><table width="842">
                        <tr>
                          <td width="160"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                          <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="20" maxlength="15"  value="<?echo $ced_rif?>" readonly>  </span></td>
                          <td width="540"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" value="<?echo $nombre?>" size="80" readonly>   </span></td>
                        </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="24"><table width="843" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="280" height="22"><span class="Estilo5">GENERAR ASIENTO EN EL COMPROBANTE  :</span></td>
                      <td width="220"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtstatus_1" type="text" id="txtstatus_1" size="5" maxlength="5" value="<?echo $status_1?>" readonly></span></div></td>
                      <td width="150"><span class="Estilo5">RETENCI&Oacute;N PARCIAL :</span></td>
                      <td width="190"><span class="Estilo5"><input class="Estilo10" name="txtstatus_2" type="text" id="txtstatus_2" size="5" maxlength="5" value="<?echo $status_2?>" readonly></span></td>
                    </tr>
                  </table></td>
                </tr>
                                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="24"><table width="843" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="300" height="22"><span class="Estilo5">CODIGO DEL CONCEPTO DE RETENCION  :</span></td>
                       <td width="543"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_fondo" type="text" id="txtcod_fondo" size="6" maxlength="3" value="<?echo $cod_fondo?>" readonly>
                      </span></div></td>
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
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>