<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$cod_empresa='';}else {$cod_empresa=$_GET["Gcod_empresa"];}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Actualiza Empresas)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
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
function revisar(){
var f=document.form1;
    if(f.txtcod_empresa .value==""){alert("La Empresa no puede estar Vacia");return false;}else{f.txtcod_empresa .value=f.txtcod_empresa .value.toUpperCase();}
    if(f.txtdenominacion_emp.value==""){alert("Nombre de la Empresa no puede estar Vacio"); return false; } else{f.txtdenominacion_emp.value=f.txtdenominacion_emp.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
<style type="text/css">
</style>
</head>
<?
$sql="SELECT * From BIEN007 where cod_empresa='$cod_empresa'"; {$res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); 
$cod_empresa=$registro["cod_empresa"]; $denominacion_emp=$registro["denominacion_emp"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR EMPRESAS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="250" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="235"><table width="92" height="230" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_empresas_ar.php?Gcod_empresa=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_empresas_ar.php?Gcod_empresa=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
               <form name="form1" method="post" action="Update_empresas_ar.php" onSubmit="return revisar()">
       <div id="Layer1" style="position:absolute; width:825px; height:523px; z-index:1; top: 78px; left: 118px;">
         <table width="828" border="0" align="center" >

           <tr>
             <td><table width="821">
               <tr>
                 <td width="161"><div align="left"><span class="Estilo5">C&Oacute;DIGO :</span></div></td>
                 <td width="660"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_empresa" type="text" id="txtcod_empresa" size="5" maxlength="3"  value="<?echo $cod_empresa?>" >
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
            <td>&nbsp;</td>
          </tr>
           <tr>
             <td><table width="821">
               <tr>
                 <td width="161"><div align="left"><span class="Estilo5">NOMBRE DE LA EMPRESA :</span></div></td>
                 <td width="660"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_emp" type="text" id="txtdenominacion_emp" size="120" maxlength="200"  value="<?echo $denominacion_emp?>" >
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
            <td>&nbsp;</td>
          </tr>
           <tr>

        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table>
           </tr>
             </table></td>
           </tr>

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
