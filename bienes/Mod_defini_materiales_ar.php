<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$cod_material='';}else {$cod_material=$_GET["Gcod_material"];}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Actualiza Materiales)</title>
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
function LlamarURL(url){  document.location = url; }
function revisar(){var f=document.form1;
    if(f.txtcod_material.value==""){alert("Codigo no puede estar Vacio");return false;}else{f.txtcod_material.value=f.txtcod_material.value.toUpperCase();}
    if(f.txtdes_material.value==""){alert("Descripcion no puede estar Vacio"); return false; } else{f.txtdes_material.value=f.txtdes_material.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
<style type="text/css">
</style>
</head>
<?php 
$sql="SELECT * From BIEN035 where cod_material='$cod_material'"; {$res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); $cod_material=$registro["cod_material"]; $des_material=$registro["des_material"];}
?>
<body>

<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR DEFINICI&Oacute;N DE MATERIALES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="193" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="191"><table width="92" height="190" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_defini_materiales_ar.php?Gcod_material=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_defini_materiales_ar.php?Gcod_material=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td >&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:832px; height:74px; z-index:1; top: 89px; left: 127px;">
            <form name="form1" method="post" action="Update_defini_materiales_ar.php" onSubmit="return revisar()">
        <table width="828" border="0" align="center" >
          <tr>
            <td>
              <table width="820">
                <tr>
                  <td width="120" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO :</span></div></td>
                  <td width="700" scope="col"><div align="left"><span class="Estilo5"><input name="txtcod_material" type="text" id="txtcod_material" size="5" maxlength="4"  value="<?php echo $cod_material?>" readonly class="Estilo10">
                  </span></div></td>
                </tr>
              </table></td>
          </tr>
		  <tr><td height="10">&nbsp;</td></tr>
          <tr>
            <td><table width="820">
              <tr>
                <td width="200" scope="col"><div align="left"><span class="Estilo5">DENOMINACI&Oacute;N DE MATERIALES :</span></div></td>
                <td width="620" scope="col"><div align="left"><span class="Estilo5"><input name="txtdes_material" type="text" id="txtdes_material" size="80" maxlength="60"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?php echo $des_material?>" class="Estilo10">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr><td height="10">&nbsp;</td></tr>
        </table>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
            </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>

<?php  pg_close($conn);?>
