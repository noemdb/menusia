<?include ("../class/conect.php");  include ("../class/funciones.php");$equipo=getenv("COMPUTERNAME");
if (!$_GET){$codigo="";} else{$codigo=$_GET["Gcodigo"];} $tipo_arch_banco=substr($codigo,0,2); $cod_arch_banco=substr($codigo,2,6);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL N&Oacute;MINA Y PERSONAL (Modificar Archivo de Bancos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
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
<script language="JavaScript" type="text/JavaScript">
function revisar(){
var f=document.form1;
    if(f.txtcod_arch_banco.value==""){alert("Codigo del Archivo no puede estar Vacio");return false;}else{f.txtcod_arch_banco.value=f.txtcod_arch_banco.value.toUpperCase();}
    if(f.txtden_arch_banco.value==""){alert("Descripcion del Archivo no puede estar Vacia"); return false; } else{f.txtden_arch_banco.value=f.txtden_arch_banco.value.toUpperCase();}
    if(f.txtcod_cta_emp.value==""){alert("Numero de Cuenta no puede estar Vacia"); return false; } else{f.txtcod_cta_emp.value=f.txtcod_cta_emp.value.toUpperCase();}
    if(f.txtcod_arch_banco.value.length==6){valido=true;}else{alert("Longitud Codigo Invalida");return false;}
document.form1.submit;
return true;}
</script>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * FROM NOM045 where (tipo_arch_banco='$tipo_arch_banco') and (cod_arch_banco='$cod_arch_banco')"; $res=pg_query($sql);$filas=pg_num_rows($res);  $den_arch_banco=""; $cod_cta_emp=""; $inf_usuario="";
if($filas>=1){$registro=pg_fetch_array($res,0); $cod_arch_banco=$registro["cod_arch_banco"]; $den_arch_banco=$registro["den_arch_banco"]; $cod_cta_emp=$registro["cod_cta_emp"]; $inf_usuario=$registro["inf_usuario"];} $criterio=$cod_arch_banco;
?>
<body>
<table width="978" height="52" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR ARCHIVO DE BANCOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="304" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="300"><table width="92" height="300" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_archivo_banco.php?Gcriterio=C<?echo $cod_arch_banco?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_archivo_banco.php?Gcriterio=C<?echo $cod_arch_banco?>">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
      <tr><td>&nbsp;</td>  </tr>
    </table></td>
    <td width="870">       <div id="Layer1" style="position:absolute; width:833px; height:248px; z-index:1; top: 93px; left: 121px;">
      <form name="form1" method="post" action="Update_arch_banco.php" onSubmit="return revisar()">
        <table width="868" border="0" align="center" >
          <tr>
            <td><table width="866">
                <tr>
                  <td width="216" ><span class="Estilo5">C&Oacute;DIGO DEL ARCHIVO : </span></td>
                  <td width="650" ><span class="Estilo5"> <input class="Estilo10" name="txtcod_arch_banco" type="text" id="txtcod_arch_banco" size="10" maxlength="6"  value="<?echo $cod_arch_banco?>" readonly> </span></td>
                </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td></tr>
          <tr>
             <td><table width="866">
               <tr>
                 <td width="216" ><span class="Estilo5">DESCRIPCI&Oacute;N DEL ARCHIVO : </span></td>
                 <td width="650" ><span class="Estilo5"><textarea name="txtden_arch_banco" cols="65" maxlength="100"  id="txtden_arch_banco" class="Estilo10" onFocus="encender(this)" onBlur="apagar(this)" ><?echo $den_arch_banco?></textarea></span></td>
               </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td></tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="216"><span class="Estilo5">NUMERO CUENTA EMPRESA  :</span></td>
                 <td width="650"><span class="Estilo5"><input  class="Estilo10" name="txtcod_cta_emp" type="text" id="txtcod_cta_emp" size="30" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_cta_emp?>" > </span></td>
                </tr>
             </table></td>
           </tr>
        </table>
        <p>&nbsp;</p>
        <table width="812">
          <tr>
            <td width="612">&nbsp;</td>
            <td width="20"><input name="txttipo_arch_banco" type="hidden" id="txttipo_arch_banco" value="<?echo $tipo_arch_banco?>"></td>
            <td width="90"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
            <td width="90"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </div>
      </form>
    </td>
</tr>
</table>
</body>
</html>