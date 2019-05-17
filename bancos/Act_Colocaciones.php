<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $p_letra="";
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){ $referencia=''; $sql="SELECT * FROM colocaciones ORDER BY referencia";}
else {$referencia = $_GET["Greferencia"];$p_letra=substr($referencia, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$referencia=substr($referencia,1,12);} else{$referencia=substr($referencia,0,12);}
  $sql="Select * from colocaciones where referencia='$referencia' ";
  if ($p_letra=="P"){$sql="SELECT * FROM colocaciones ORDER BY referencia";}
  if ($p_letra=="U"){$sql="SELECT * From colocaciones Order by referencia desc";}
  if ($p_letra=="S"){$sql="SELECT * From colocaciones Where (referencia>'$referencia') Order by referencia";}
  if ($p_letra=="A"){$sql="SELECT * From colocaciones Where (referencia<'$referencia') Order by referencia desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL BANCARIO (Colocaciones Bancarias)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){
var murl;
    Greferencia=document.form1.txtreferencia.value;murl=url+Greferencia;
    if (Greferencia==""){alert("referencia debe ser Seleccionada");}else {document.location = murl;}
}
function Mover_Registro(MPos){
var murl;
   murl="Act_Colocaciones.php";
   if(MPos=="P"){murl="Act_Colocaciones.php?Greferencia=P"}
   if(MPos=="U"){murl="Act_Colocaciones.php?Greferencia=U"}
   if(MPos=="S"){murl="Act_Colocaciones.php?Greferencia=S"+document.form1.txtreferencia.value;}
   if(MPos=="A"){murl="Act_Colocaciones.php?Greferencia=A"+document.form1.txtreferencia.value;}
   document.location = murl;
}
function Llama_Eliminar(){
var url; var r;
  r=confirm("Esta seguro en Eliminar la Colocación Bancaria ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Colocación Bancaria ?");
    if (r==true) { url="Delete_colocaciones.php?txtreferencia="+document.form1.txtreferencia.value;  VentanaCentrada(url,'Eliminar Colocación Bancaria','','400','400','true');}}else { url="Cancelado, no elimino"; }
}
</script>
<SCRIPT language=JavaScript src="../class/sia.js"  type="text/javascript"></SCRIPT>
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
.Estilo6 {font-size: 16pt;font-weight: bold; }
.Estilo9 {font-size: 8pt}
.Estilo10 {font-size: 12px}
-->
</style>
</head>
<?
$tipo_inv="";$cod_cuenta="";$nombre_cuenta="";$fecha_inicio="";$dias_inv=0;$fecha_vencimiento="";$tasa_inv=0;$monto_inv=0; $descripcion="";$res=pg_query($sql);$filas=pg_num_rows($res); if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From colocaciones ORDER BY referencia";} if ($p_letra=="A"){$sql="SELECT * From colocaciones ORDER BY referencia desc";} $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); $referencia=$registro["referencia"]; $tipo_inv=$registro["tipo_inv"];$cod_cuenta=$registro["cod_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"]; $fecha_inicio=$registro["fecha_inicio"]; $dias_inv=$registro["dias_inv"]; $fecha_vencimiento=$registro["fecha_vencimiento"];  $tasa_inv=$registro["tasa_inv"]; $monto_inv=$registro["monto_inv"]; $descripcion=$registro["observacion"]; }
$monto_inv=formato_monto($monto_inv); $tasa_inv=formato_monto($tasa_inv); if($fecha_inicio==""){$fecha_inicio="";}else{$fecha_inicio=formato_ddmmaaaa($fecha_inicio);} if($fecha_vencimiento==""){$fecha_vencimiento="";}else{$fecha_vencimiento=formato_ddmmaaaa($fecha_vencimiento);}
if($tipo_inv=="T"){$tipo_inv="TEMPORALES";}else{$tipo_inv="FIDECOMISO";}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">COLOCACIONES BANCARIAS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="390" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="385"><table width="92" height="383" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_Colocaciones.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Inc_Colocaciones.php">Incluir</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Mover_Registro('P');">Primero</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></div></td>
      </tr>
  <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
  </tr><tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_colocaciones.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_colocaciones.php" class="menu">Catalogo</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:858px; height:290px; z-index:1; top: 70px; left: 115px;">
        <form name="form1" method="post">
          <table width="856" border="0" cellspacing="1" cellpadding="1">
                <tr>
                 <td width="855"><table width="854" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td width="180"><span class="Estilo5">REFERENCIA DE COLOCACI&Oacute;N </span>:</span></td>
                      <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtreferencia" type="text" id="txtreferencia"  value="<?echo $referencia?>" size="10" maxlength="10" readonly> </span></td>
                      <td width="140"><span class="Estilo5">TIPO  DE INVERSI&Oacute;N </span> :</span></td>
                      <td width="300"><span class="Estilo5"> <input class="Estilo10" name="txttipo_inv" type="text" id="txttipo_inv"  value="<?echo $tipo_inv?>" size="20" maxlength="20" readonly> </span></div></td>
                      <td width="30"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td width="855"><table width="854" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td width="180"><span class="Estilo5">C&Oacute;DIGO CONTABLE :</span></td>
                      <td width="670"><span class="Estilo5"> <input class="Estilo10" name="txtCod_Contable" type="text" id="txtCod_Contable"  value="<?echo $cod_cuenta?>" size="30" maxlength="30" readonly>  </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td width="855"><table width="854" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td width="180"><span class="Estilo5">NOMBRE C&Oacute;DIGO CONTABLE :</span></td>
                      <td width="670"><span class="Estilo5"><input class="Estilo10" name="txtnombre_cuenta" type="text" id="txtnombre_cuenta"  value="<?echo $nombre_cuenta?>" size="100" maxlength="99" readonly>  </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td width="855"><table width="854" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td width="120"><span class="Estilo5">FECHA DE INICIO :</span></td>
                      <td width="180"><span class="Estilo5"><input class="Estilo10" name="txtfecha_inicio" type="text" id="txtfecha_inicio"  value="<?echo $fecha_inicio?>" size="12" maxlength="12" readonly>  </span></td>
                      <td width="100"><span class="Estilo5">PLAZO D&Iacute;AS :</span></td>
                      <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtdias_inv" type="text" id="txtdias_inv"  value="<?echo $dias_inv?>" size="10" maxlength="10" readonly>  </span></td>
                      <td width="150"><span class="Estilo5">FECHA DE VENCIMIENTO :</span></td>
                      <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtfecha_vencimiento" type="text" id="txtfecha_vencimiento"  value="<?echo $fecha_vencimiento?>" size="12" maxlength="12" readonly>  </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td width="855"><table width="854" border="0" cellspacing="1" cellpadding="1">
                    <tr>
                      <td width="80"><span class="Estilo5">TASA % :</span></td>
                      <td width="400"><span class="Estilo5"><input class="Estilo10" name="txttasa_inv" type="text" id="txttasa_inv"  value="<?echo $tasa_inv?>" size="10" maxlength="10" readonly>  </span></td>
                      <td width="200"><span class="Estilo5">MONTO DE LA COLOCACI&Oacute;N  :</span></td>
                      <td width="170"><span class="Estilo5"><input class="Estilo10" name="txtmonto_inv" type="text" id="txtmonto_inv"  value="<?echo $monto_inv?>" size="15" maxlength="15" readonly>  </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                 <td width="855"><table width="854" border="0" cellspacing="1" cellpadding="1">
                      <tr>
                        <td width="100"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                        <td width="750"><span class="Estilo5"><textarea name="txtdescripcion_banco" cols="85" readonly="readonly"  id="txtdescripcion_banco"><?echo $descripcion ?></textarea>
                        </span></td>
                      </tr>
                  </table></td>
                </tr>
          </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>