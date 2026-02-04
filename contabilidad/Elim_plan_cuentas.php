<?include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){  $codigo_cuenta='';} else {$codigo_cuenta = $_GET["Gcodigo_cuenta"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA (Eliminar Plan de Cuentas)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
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
function Llamar_Ventana(nombre)
{
var f=document.form1;
var url;
    url="Delete_plan_cuentas.php?txtCodigo_Cuenta="+f.txtCodigo_Cuenta.value;
    VentanaCentrada(url,'Eliminar Plan Cuentas','','500','500','true');
}
</script>
<script language="JavaScript" type="text/JavaScript">
function revisar(){
var f=document.form1;
    if(f.txtCodigo_Cuenta.value==""){alert("C&oacute;digo de Cuenta no puede estar Vacio");return false;}
    if(f.txtNombre_Cuenta.value==""){alert("Denominaci&oacute;n de Cuenta no puede estar Vacia"); return false; }
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--

.Estilo9 {font-size: 8pt}
.Estilo10 {font-size: 12px}
-->
</style>
<?
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
$nombre_cuenta="";
$clasificacion="";
$tSaldo="";
$sql="Select * from con098 where codigo_cuenta='$codigo_cuenta'";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){
  $codigo_cuenta=$registro["codigo_cuenta"];
  $nombre_cuenta=$registro["nombre_cuenta"];
  $clasificacion=$registro["clasificacion"];
  $tSaldo=$registro["tsaldo"];
}
?>
</head>

<body>
<table width="977" height="38" border="0" bgcolor="#000066" id="tablaencabezado">
  <tr>
    <td><div align="center"><span class="Estilo1">ELIMINA PLAN DE CUENTAS </span> </div></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_plan_cuentas.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu
            href="Act_plan_cuentas.php">Atras</A></td>
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
        <table width="859" height="136" border="0" id="tabcampos">
          <tr>
            <td>
              <blockquote>
                <p></p>
                C&Oacute;DIGO DE CUENTA :
                <input readonly  name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" title="Registre el C&oacute;digo de la Cuenta"  value="<?ECHO $codigo_cuenta?>" size="30" maxlength="30">
            </blockquote></td>
          </tr>
          <tr>
            <td><blockquote>
                <p align="left"><span class="Estilo5">DENOMINACI&Oacute;N :</span>
                    <input readonly name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta"  value="<?ECHO $nombre_cuenta?>" size="105" maxlength="200">
                </p>
            </blockquote></td>
          </tr>
          <tr>
            <td><blockquote><span class="Estilo5">CLASIFICACI&Oacute;N :</span>
                    <input readonly name="txtClasificacion" type="text" id="txtClasificacion" value="<?ECHO $clasificacion?>" size="15">
            </blockquote></td>
          </tr>
          <tr>
            <td><blockquote>
                <p><span class="Estilo5">TIPO DE SALDO :</span>
                    <input readonly name="txtTSaldo" type="text" id="txtTSaldo" value="<?ECHO $tSaldo?>" size="15">
                </p>
            </blockquote></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table width="768">
          <tr>
            <td width="630">&nbsp;</td>
            <td width="68" valign="middle"><input name="button" type="button" id="button"  value="Eliminar" onclick="Llamar_Ventana('Delete_tipo_asiento.php')"></td>
            <td width="54">&nbsp;
            </td>
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