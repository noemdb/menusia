<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$codigo_departamento="";} else{$codigo_departamento=$_GET["codigo"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL N&Oacute;MINA Y PERSONAL (Modificar Definici&oacute;n Departamentos)</title>
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
    if(f.txtcodigo_departamento.value==""){alert("Codigo del Departamento no puede estar Vacio");return false;}else{f.txtcodigo_departamento.value=f.txtcodigo_departamento.value.toUpperCase();}
    if(f.txtdescripcion_dep.value==""){alert("Descripcion del Departamento estar Vacia"); return false; } else{f.txtdescripcion_dep.value=f.txtdescripcion_dep.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * FROM NOM005 where codigo_departamento='$codigo_departamento'"; $res=pg_query($sql);$filas=pg_num_rows($res);
$descripcion_dep="";If($registro=pg_fetch_array($res,0)){$codigo_departamento=$registro["codigo_departamento"]; $descripcion_dep=$registro["descripcion_dep"]; }
pg_close();
?>
<body>
<table width="978" height="52" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CARGOS DEL DEPARTAMENTOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="422" border="1" id="tablacuerpo">
  <td ><tr>
    <td width="92" height="420"><table width="92" height="420" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_Departamentos.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_Departamentos.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <div id="Layer1" style="position:absolute; width:833px; height:248px; z-index:1; top: 73px; left: 121px;">
      <form name="form1" method="post" action="Update_departamento.php" onSubmit="return revisar()">
        <table width="868" border="0" align="center" >
          <tr>
            <td><table width="866">
                <tr>
                  <td width="105" ><span class="Estilo5">DEPARTAMENTO : </span></td>
                  <td width="145" ><span class="Estilo5"> <input name="txtcodigo_departamento" type="text" id="txtcodigo_departamento" size="15" maxlength="15" readonly value="<?echo $codigo_departamento?>" > </span></td>
                  <td width="615" ><span class="Estilo5"><input name="txtdescripcion_dep" type="text" id="txtdescripcion_dep" size="80" maxlength="100" readonly value="<?echo $descripcion_dep?>" ></span></td>
               </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td></tr>
        </table>
        <iframe src="Det_cargo_dep.php?Gcodigo=<?echo $codigo_departamento?>" width="850" height="350" scrolling="auto" frameborder="1">
        </iframe>

      </form>
    </div>
</tr>
</table>
</body>
</html>