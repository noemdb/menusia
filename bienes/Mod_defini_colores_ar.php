<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$cod_color='';}else {$cod_color=$_GET["Gcod_color"];}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Actualiza Colores)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script><script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function LlamarURL(url){  document.location = url; }
function revisar(){
var f=document.form1;
    if(f.txtcod_color.value==""){alert("Codigo no puede estar Vacio");return false;}else{f.txtcod_color.value=f.txtcod_color.value.toUpperCase();}
    if(f.txtdes_color.value==""){alert("Descripcion no puede estar Vacio"); return false; } else{f.txtdes_color.value=f.txtdes_color.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
<style type="text/css">
</style>
</head>
<?
$sql="SELECT * From BIEN034 where cod_color='$cod_color'"; {$res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); 
$cod_color=$registro["cod_color"]; $des_color=$registro["des_color"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR COLORES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="200" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="195"><table width="92" height="190" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_defini_colores_ar.php?Gcod_color=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_defini_colores_ar.php?Gcod_color=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
  </table></td> 
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
               <form name="form1" method="post" action="Update_defini_colores_ar.php" onSubmit="return revisar()">
       <div id="Layer1" style="position:absolute; width:825px; height:523px; z-index:1; top: 78px; left: 118px;">
         <table width="828" border="0" align="center" >

           <tr>
             <td><table width="820">
               <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO :</span></div></td>
                 <td width="700" scope="col"><div align="left"><span class="Estilo5"> <input name="txtcod_color" type="text" class="Estilo10" id="txtcod_color" size="5" maxlength="4" readonly value="<?echo $cod_color?>" >
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
		   <tr><td height="10">&nbsp;</td></tr>
           <tr>
             <td><table width="820">
               <tr>
                 <td width="170" scope="col"><div align="left"><span class="Estilo5">DENOMINACI&Oacute;N DEL COLOR  :</span></div></td>
                 <td width="650" scope="col"><div align="left"><span class="Estilo5"><input name="txtdes_color" type="text" class="Estilo10" id="txtdes_color" size="100" maxlength="60"  value="<?echo $des_color?>" >
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr><td height="10">&nbsp;</td></tr>

        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table>
           

         </table>
         <p>&nbsp;</p>
       </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>
