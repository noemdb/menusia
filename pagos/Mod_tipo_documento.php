<?include ("../class/conect.php");  include ("../class/funciones.php"); 
if (!$_GET){$cod_documento=''; $sql="SELECT * FROM PAG017 ORDER BY cod_documento";}
else {$cod_documento = $_GET["Gdocumento"];  $sql="Select * from PAG017 where cod_documento='$cod_documento'";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Modificar Tipos Documento)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
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
    if(f.txtcod_documento.value==""){alert("Codigo no puede estar Vacio");return false;}
    if(f.txttipo_documento.value==""){alert("Tipo de Documento no puede estar Vacia");return false; }
       else{f.txttipo_documento.value=f.txttipo_documento.value.toUpperCase();}
    if(f.txtcod_documento.value.length==2){f.txtcod_documento.value=f.txtcod_documento.value.toUpperCase();}
       else{alert("Longitud de Codigo Invalida");return false;}
document.form1.submit;
return true;}
</script>
<script language="JavaScript" type="text/JavaScript">
function LlamarURL(url){  document.location = url; }
function chequea_tipo(mform){var mref;
   mref=mform.txtcod_documento.value;   mref = Rellenarizq(mref,"0",2);   mform.txtcod_documento.value=mref;
return true;}
</script>

</head>
<?
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$res=pg_query($sql);$filas=pg_num_rows($res);$des_tipo_orden="";
if($filas>=1){  $registro=pg_fetch_array($res,0);  $cod_documento=$registro["cod_documento"];  $tipo_documento=$registro["tipo_documento"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR TIPO DE DOCUMENTO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="357" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="355" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_tipo_documento.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_tipo_documento.php">Atras</A></td>
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
      <form name="form1" method="post" action="Update_tipo_documento.php" onSubmit="return revisar()">
        <table width="867" height="204" border="0" align="center" >
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="844" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="190"><span class="Estilo5">C&Oacute;DIGO TIPO DOCUMENTO:</span></td>
                  <td width="140"><div align="left"><span class="Estilo5">
                      <input class="Estilo10" name="txtcod_documento" type="text" id="txtcod_documento" size="5" maxlength="2"  readonly value="<?echo $cod_documento?>" >
                  </span></div></td>
                  <td width="204">&nbsp;</td>
                  <td width="310"><span class="Estilo5"> </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="848" height="20" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="190"><span class="Estilo5">TIPO DE DOCUMENTO:</span></td>
                  <td width="658"><span class="Estilo5">
                    <input class="Estilo10" name="txttipo_documento" type="text" id="txttipo_documento"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_documento?>" size="100">
                  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td width="883" height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="24">&nbsp;</td>
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