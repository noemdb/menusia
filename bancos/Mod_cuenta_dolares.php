<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); 
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
if (!$_GET){$codigo_cuenta=''; $sql="SELECT * FROM BAN043 ORDER BY codigo_cuenta";} else{$codigo_cuenta=$_GET["Gcodigo_cuenta"]; $sql="Select * from BAN043 where codigo_cuenta='$codigo_cuenta'";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Tipos de Cuenta)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<SCRIPT language=JavaScript src="../class/sia.js"  type=text/javascript></SCRIPT>
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
  if(f.txtcodigo_cuenta.value==""){alert("Codigo de Cuenta no puede estar Vacio");return false;}else{f.txtcodigo_cuenta.value=f.txtcodigo_cuenta.value.toUpperCase();}
  if(f.txtdescripcion_cuenta.value==""){alert("Descripcion no puede estar Vacia"); return false; } else{f.txtdescripcion_cuenta.value=f.txtdescripcion_cuenta.value.toUpperCase();}
  document.form1.submit;
return true;}
</script>
</head>
<?
$des_codigo_cuenta="";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); $codigo_cuenta=$registro["codigo_cuenta"]; $des_codigo_cuenta=$registro["descripcion_cuenta"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR CUENTAS DOLARES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="359" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="354" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_cuentas_dolares.php?Gcodigo_cuenta=C<?echo $codigo_cuenta?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_cuentas_dolares.php?Gcodigo_cuenta=C<?echo $codigo_cuenta?>">Atras</A></td>
      </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:862px; height:343px; z-index:1; top: 70px; left: 116px;">
           <form name="form1" method="post" action="Update_cuenta_dolares.php" onSubmit="return revisar()">
              <table width="839" height="110" border="0" align="center">
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td width="830" height="24"><table width="830" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="200"><span class="Estilo5">CODIGO DE CUENTA :</span></td>
                        <td width="630"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_cuenta" type="text"  id="txtcodigo_cuenta"  readonly value="<?echo $codigo_cuenta?>"  size="30" maxlength="30">
                        </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td><table width="830" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="200"><span class="Estilo5">DESCRIPCI&Oacute;N CUENTA : </span></td>
                      <td width="630"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_cuenta" type="text"  id="txtdescripcion_cuenta"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $des_codigo_cuenta?>"  size="80" maxlength="100">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
              </table>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
            <table width="812">
              <tr>
                <td width="664">&nbsp;</td>
                <td width="88"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
                <td width="88">&nbsp;</td>
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