<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$Gcodigo_c='';}else {$Gcodigo_c=$_GET["Gcodigo_c"];}
$num_descrip=substr($Gcodigo_c,0,8); $codigo_c=substr($Gcodigo_c,8,10); $clave=$codigo_c.$num_descrip;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Actualiza Descripcion de Bienes)</title>
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
function LlamarURL(url){  document.location = url; }
function revisar(){
var f=document.form1;
    if(f.txtcodigo_c.value==""){alert("Codigo no puede estar Vacio");return false;}else{f.txtcodigo_c.value=f.txtcodigo_c.value.toUpperCase();}
    if(f.txtnum_descrip.value==""){alert("El Numero no puede estar Vacio"); return false; } else{f.txtnum_descrip.value=f.txtnum_descrip.value.toUpperCase();}
    if(f.txtdescripcion_b.value==""){alert("Descripcion puede estar Vacio"); return false; } else{f.txtdescripcion_b.value=f.txtdescripcion_b.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
<style type="text/css">
</style>
</head>
<?
$sql="SELECT * From BIEN033 where codigo_c='$codigo_c' and num_descrip='$num_descrip'"; {$res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); $descripcion_b="";
$codigo_c=$registro["codigo_c"];$num_descrip=$registro["num_descrip"];$descripcion_b=$registro["descripcion_b"]; }
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR DESCRIPCION DE BIENES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="250" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="245"><table width="92" height="240" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_descrip_bienes_ar.php?Gcodigo_c=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_descrip_bienes_ar.php?Gcodigo_c=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
               <form name="form1" method="post" action="Update_descrip_bienes_ar.php" onSubmit="return revisar()">
       <div id="Layer1" style="position:absolute; width:825px; height:523px; z-index:1; top: 78px; left: 118px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td><table width="820">
               <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">CODIGO:</span></div></td>
                 <td width="700" scope="col"><div align="left"><span class="Estilo5"><input name="txtcodigo_c" type="text" class="Estilo5" readonly id="txtcodigo_c" size="10" maxlength="10"  value="<?echo $codigo_c?>"> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="820">
               <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO :</span></div></td>
                 <td width="700" scope="col"><div align="left"><span class="Estilo5"> <input name="txtnum_descrip" type="text" class="Estilo10" id="txtnum_descrip" size="10" maxlength="8" readonly value="<?echo $num_descrip?>"> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="820">
               <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">DENOMINACION :</span></div></td>
                 <td width="700" scope="col"><div align="left"><textarea name="txtdescripcion_b" cols="70" class="headers"  onFocus="encender(this)" onBlur="apagar(this)" id="txtdescripcion_b"><?echo $descripcion_b?></textarea>  </div></td>
               </tr>
             </table></td>
			</tr>
            <tr><td>&nbsp;</td> </tr>			
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
