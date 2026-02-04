<?include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){  $Tipo_Asiento='';} else {  $Tipo_Asiento = $_GET["GTipo_Asiento"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA (Eliminar Tipos de Asientos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"   rel="stylesheet">
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
function Llamar_Ventana(nombre){var f=document.form1;var url;
    url="Delete_tipo_asiento.php?txtTipo_Asiento="+f.txtTipo_Asiento.value;        VentanaCentrada(url,'Test','','500','500','true');}
</script>
<script language="JavaScript" type="text/JavaScript">
function revisar(){var f=document.form1;
   if(f.txtTipo_Asiento.value==""){alert("Tipo de Asiento no puede estar Vacio");return false;}
    if(f.txtDes_Tipo_Asi.value==""){alert("Descripcion de Asiento no puede estar Vacia");return false; }
         else{f.txtDes_Tipo_Asi.value=f.txtDes_Tipo_Asi.value.toUpperCase();}
        if(f.txtTipo_Asiento.value.length==3){
          f.txtTipo_Asiento.value=f.txtTipo_Asiento.value.toUpperCase();}
        else{alert("Longitud Tipo de Asiento Invalida");return false;}
document.form1.submit;
return true;}
</script>

<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$Des_Asiento="";$sql="Select * from con009 where tipo_asiento='$Tipo_Asiento'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $Tipo_Asiento=$registro["tipo_asiento"];  $Des_Asiento=$registro["descrip_tipo_asiento"];}
?>
</head>

<body>
<table width="977" height="38" border="0" bgcolor="#000066" id="tablaencabezado">
  <tr>
    <td><div align="center"><span class="Estilo1">ELIMINA TIPOS DE ASIENTOS</span> </div></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_tipo_asiento.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu
            href="Act_tipo_asiento.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu
            href="menu.php">Menu Principal</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:338px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="Delete_tipo_asiento.php" onSubmit="return revisar()">
        <p>&nbsp;</p>
        <table width="859" height="136" border="0" id="tabcampos">
          <tr>
            <td> <blockquote></p>
                          <p class="Estilo5">TIPO DE ASIENTO :
                            <input readOnly size="10" value="<?ECHO $Tipo_Asiento?>" name="txtTipo_Asiento">
                  </p> <p>&nbsp;                          </p>
            </blockquote></td>
          </tr>
          <tr>
            <td><blockquote>
              <p align="left"><span class="Estilo5">DESCRIPCI&Oacute;N TIPO DE ASIENTO :</span>
                <input readonly name="txtDes_Tipo_Asi" type="text" value="<?ECHO $Des_Asiento?>" id="txtDes_Tipo_Asi" size="80" >
              </p>
            </blockquote></td>
          </tr>
          <tr>
            <td><p>&nbsp;</p>
              </td>
          </tr>
        </table>
        <div align="center">
          <p>&nbsp;</p>
          </div>
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="button" type="button" id="button"  value="Eliminar" onclick="Llamar_Ventana('Delete_tipo_asiento.php')"></td>
            <td width="88">
            &nbsp;</td>
          </tr>
        </table>
        <div align="right"></div>
        <div align="right"></div>
        <p>&nbsp;</p>
        </form>
    </div>

   </tr>
</table>
</body>
</html>