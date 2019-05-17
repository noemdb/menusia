<?include ("../class/conect.php");  include ("../class/funciones.php"); 
if (!$_GET){  $tipo_orden='';  $sql="SELECT * FROM TIPOS_ORDEN ORDER BY tipo_orden";}
else {  $tipo_orden = $_GET["Gtipo_orden"];  $sql="Select * from TIPOS_ORDEN where tipo_orden='$tipo_orden'";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Modificar Tipos de Orden)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function revisar(){
var f=document.form1;
    if(f.txttipo_orden.value==""){alert("Tipo de Orden no puede estar Vacio");return false;}
    if(f.txtdes_tipo_orden.value==""){alert("Descripción Tipo de Orden no puede estar Vacia");return false; }
       else{f.txtdes_tipo_orden.value=f.txtdes_tipo_orden.value.toUpperCase();}
    if(f.txttipo_orden.value.length==4){f.txttipo_orden.value=f.txttipo_orden.value.toUpperCase();}
       else{alert("Longitud Tipo de Orden Invalida");return false;}
    if(f.txtcod_contable.value==""){alert("Código Contable no puede estar Vacio");return false;}
document.form1.submit;
return true;}
</script>
<script language="JavaScript" type="text/JavaScript">
function LlamarURL(url){  document.location = url; }
function chequea_tipo(mform){
var mref;
   mref=mform.txttipo_orden.value;
   mref = Rellenarizq(mref,"0",4);
   mform.txttipo_orden.value=mref;
return true;}
</script>

</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$res=pg_query($sql);$filas=pg_num_rows($res);$des_tipo_orden="";$cod_contable="";$gen_tributo="";$cod_banco="";
if($filas>=1){  $registro=pg_fetch_array($res,0);  $tipo_orden=$registro["tipo_orden"];  $des_tipo_orden=$registro["des_tipo_orden"];
  $cod_contable=$registro["cod_contable_t"];  $cod_banco=$registro["cod_banco_t"];  $gen_tributo=$registro["gen_tributo"];  $status_1=$registro["status_1"];
  $status_2=$registro["status_2"];  $nombre_cuenta=$registro["nombre_cuenta"];  $nombre_banco=$registro["nombre_banco"];  $inf_usuario=$registro["inf_usuario"];
}
if($gen_tributo=="S"){$gen_tributo="SI";}else{$gen_tributo="NO";}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR TIPOS DE ORDEN </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="397" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="395" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_tipos_orden.php?Gtipo_orden=<? echo $tipo_orden; ?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_tipos_orden.php?Gtipo_orden=<? echo $tipo_orden; ?>">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
          <div id="Layer1" style="position:absolute; width:872px; height:346px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="Update_tipo_orden.php" onSubmit="return revisar()">
        <table width="867" height="188" border="0" align="center" >
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="844" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="163"><span class="Estilo5">C&Oacute;DIGO TIPO DE ORDEN:</span></td>
                  <td width="121"><div align="left"><span class="Estilo5">
                      <input class="Estilo10" name="txttipo_orden" type="text" id="txttipo_orden" readonly value="<?echo $tipo_orden?>" size="8" maxlength="4">
                  </span></div></td>
                  <td width="204">&nbsp;</td>
                  <td width="356"><span class="Estilo5"> </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="848" height="20" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="190"><span class="Estilo5">DESCRIPCI&Oacute;N TIPO DE ORDEN:</span></td>
                  <td width="634"><span class="Estilo5">
                    <input class="Estilo10" name="txtdes_tipo_orden" type="text" id="txtdes_tipo_orden"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $des_tipo_orden?>" size="100">
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
                  <td width="135"><span class="Estilo5">C&Oacute;DIGO CONTABLE :</span></td>
                  <td width="188"><span class="Estilo5">
                    <input class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_contable?>" size="25">
                  </span></td>
                  <td width="50"><div align="left"><span class="Estilo10"><span class="Estilo5">
                    <input class="Estilo10" name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo C&oacute;digo de Cuentas"  onClick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
                  </span>
                  </span></div></td>
                  <td width="470"><span class="Estilo5">
                    <input class="Estilo10" name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta" value="<?echo $nombre_cuenta?>"  size="70"  readonly>
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
                      <input class="Estilo10" name="txtcod_banco" type="text" id="txtcod_banco"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco?>"size="8" maxlength="15">
                  </span></div></td>
                                  <td width="50"><div align="left"><span class="Estilo10"><span class="Estilo5">
                    <input class="Estilo10" name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo C&oacute;digo de Bancos"  onClick="VentanaCentrada('Cat_bancos.php?criterio=','SIA','','750','500','true')" value="...">
                  </span>
                  <td width="570"><span class="Estilo5">
                    <input class="Estilo10" name="txtnombre_banco" type="text" id="txtnombre_banco" value="<?echo $nombre_banco?>" size="80"  readonly>
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
<script language="JavaScript" type="text/JavaScript">
function asig_gen_tributo(mvalor){
var f=document.form1;
    if(mvalor=="SI"){document.form1.txtstatus_1.options[0].selected = true;}else{document.form1.txtstatus_1.options[1].selected = true;}
}
</script>
                  <td width="135" height="22"><span class="Estilo5">GENERA TRIBUTO :</span></td>
                                  <td width="354"><span class="Estilo5"><span class="Estilo10">
                    <select name="txtgen_tributo" size="1" id="txtgen_tributo" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>NO</option>
                      <option>SI</option>
                    </select>
<script language="JavaScript" type="text/JavaScript"> asig_gen_tributo('<?echo $gen_tributo;?>');</script>
                  </span>
                  </span></td>
                  <td width="354"><input class="Estilo10" name="txtnro_cuenta" type="hidden" id="txtnro_cuenta"></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
        </table>
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88">&nbsp;</td>
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