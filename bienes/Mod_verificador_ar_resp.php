<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$ced_res_verificador='';}else {$ced_res_verificador=$_GET["Gced_res_verificador"];}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Actualiza Verificador)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="Javascript" src="../class/sia.js" type="text/javascript"></script>
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
    if(f.txtced_res_verificador.value==""){alert("Cedula del Verificador no puede estar Vacia");return false;}else{f.txtced_res_verificador.value=f.txtced_res_verificador.value.toUpperCase();}
    if(f.txtnombre_res_ver.value==""){alert("Nombre del Verificador no puede estar Vacio"); return false; } else{ f.txtnombre_res_ver.value=f.txtnombre_res_ver.value.toUpperCase(); }
   document.form1.submit;
return true;}
</script>
<style type="text/css">
</style>
</head>
<?
$sql="SELECT * From BIEN030 where ced_res_verificador='$ced_res_verificador'"; {$res=pg_query($sql);$filas=pg_num_rows($res);} if($filas>=1){$registro=pg_fetch_array($res,0); 
$ced_res_verificador=$registro["ced_res_verificador"]; $nombre_res_ver=$registro["nombre_res_ver"]; $observaciones_ver=$registro["observaciones_ver"]; }
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR RESPONSABLE VERIFICADOR</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="250" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="245"><table width="92" height="240" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_verificador_ar_resp.php?Gced_res_verificador=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_verificador_ar_resp.php?Gced_res_verificador=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
               <form name="form1" method="post" action="Update_verificador_ar_resp.php" onSubmit="return revisar()">
       <div id="Layer1" style="position:absolute; width:825px; height:523px; z-index:1; top: 78px; left: 118px;">
         <table width="828" border="0" align="center" >

           <tr>
             <td><table width="820">
               <tr>
                 <td width="140" scope="col"><div align="left"><span class="Estilo5">C&Eacute;DULA DE IDENTIDAD:</span></div></td>
                 <td width="680" scope="col"><div align="left"><span class="Estilo5"><input name="txtced_res_verificador" type="text" class="Estilo10" id="txtced_res_verificador" size="15" maxlength="12"  value="<?echo $ced_res_verificador?>" readonly >   </span></div></td>
               </tr>
             </table></td>
           </tr>
		   <tr><td height="10">&nbsp;</td></tr> 
           <tr>
             <td><table width="820">
               <tr>
                 <td width="140" scope="col"><div align="left"><span class="Estilo5">NOMBRE :</span></div></td>
                 <td width="680" scope="col"><div align="left"><span class="Estilo5"><input name="txtnombre_res_ver" type="text" class="Estilo10" id="txtnombre_res_ver" size="100" maxlength="100" onFocus="encender(this)" onBlur="apagar(this)"   value="<?echo $nombre_res_ver?>" >  </span></div></td>
               </tr>
             </table></td>
           </tr>
		   <tr><td height="10">&nbsp;</td></tr> 
           <tr>
             <td><table width="820">
               <tr>
                 <td width="140" scope="col"><div align="left"><span class="Estilo5">OBSERVACI&Oacute;N :</span></div></td>
                 <td width="680" scope="col"><div align="left"><textarea name="txtobservaciones_ver" cols="80" onFocus="encender(this)" onBlur="apagar(this)"  class="Estilo10" id="txtobservaciones_ver"><?echo $observaciones_ver?></textarea>    </div></td>
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
