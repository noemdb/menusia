<?include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){$cod_partida='';} else {$cod_partida=$_GET["Gpartida"];}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Eliminar Clasificador de Partidas)</title>
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
function Llamar_Ventana(nombre){var f=document.form1;var url;
    url=nombre+f.txtCodigo_Partida.value;   document.location = url;}
function revisar(){
var f=document.form1;
var Valido;
    if(f.txtCodigo_Partida.value==""){alert("Código de Partida no puede estar Vacio");return false;}
    if(f.txtNombre_Partida.value==""){alert("Denominación de Partida no puede estar Vacia"); return false; }
       else{f.txtNombre_Partida.value=f.txtNombre_Partida.value.toUpperCase();}
    if(f.txtTipo_Gasto.value=="CORRIENTE" || f.txtTipo_Gasto.value=="INVERSION") {Valido=true;}
      else{alert("Tipo de Gasto no valida");return false; }
document.form1.submit;
return true;}
</script>
<?
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$den_partida="";$aplicacion="";$func_inv="";$cod_contable="";
$sql="Select cod_partida,den_partida,aplicacion,ord_cord,func_inv,cod_contable from pre098 where cod_partida='$cod_partida'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $cod_partida=$registro["cod_partida"];$den_partida=$registro["den_partida"]; $aplicacion=$registro["aplicacion"]; $func_inv=$registro["func_inv"];$cod_contable=$registro["cod_contable"];}
if($func_inv=="I"){$func_inv="INVERSION";}else{$func_inv="CORRIENTE";}
?>
</head>
<body>
<table width="977" height="38" border="0" bgcolor="#000066" id="tablaencabezado">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ELIMINAR CLASIFICADOR DE PARTIDAS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9"> </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_clasificador.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_clasificador.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:335px; z-index:1; top: 67px; left: 112px;">
      <form name="form1" method="get" action="Delete_clasificador.php" onSubmit="return revisar()">
        <table width="865" border="0">
          <tr>
            <td><table width="825" height="235" border="0" align="center" id="tabcampos">
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="800" border="0">
                  <tr>
                    <td width="159"><span class="Estilo5">C&Oacute;DIGO DE PARTIDA :</span></td>
                    <td width="631"><span class="Estilo5">
                      <input name="txtCodigo_Partida" type="text" id="txtCodigo_Partida" title="Registre el C&oacute;digo de la Partida" size="30" maxlength="30" readonly value="<?ECHO $cod_partida?>">
                    </span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>
                  <table width="816" border="0">
                    <tr>
                      <td width="157"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                      <td width="659"><input name="txtNombre_Partida" type="text" id="txtNombre_Partida" title="Registre la denominaci&oacute;n de la Partida" size="100" value="<?ECHO $den_partida?>" maxlength="200"  readonly></td>
                    </tr>
                  </table>                  </td>
              </tr>

              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="800" border="0">
                  <tr>
                    <td width="159"><span class="Estilo5">TIPO DE GASTO :</span></td>
                    <td width="231"><span class="Estilo5">
                      <input name="txtTipo_Gasto" type="text" id="txtTipo_Gasto" size="20" maxlength="20"  value="<?ECHO $func_inv?>" readonly>
                    </span></td>
                    <td width="119"><span class="Estilo5">APLICACI&Oacute;N :</span></td>
                    <td width="273"><input name="txtAplicacion" type="text" id="txtAplicacion" title="Registre el Tipo de Aplicaciòn" size="4" maxlength="1"  value="<?ECHO $aplicacion?>" readonly></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><p class="Estilo5">&nbsp;
</p></td>
              </tr>
              <tr>
                <td><table width="800" border="0">
                  <tr>
                    <td width="159"><span class="Estilo5">CODIGO DE CUENTA :</span></td>
                    <td width="631"><input name="txtCod_Cuenta" type="text" id="txtCod_Cuenta" title="Registre el Còdigo de Cuenta" size="32" maxlength="30"  value="<?ECHO $cod_contable?>" readonly></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp; </td>
              </tr>
            </table>
            </td>
          </tr>
        </table>
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="button" type="button" id="button"  value="Eliminar" onclick="Llamar_Ventana('Delete_clasificador.php?Gpartida=')"></td>
            <td width="88">&nbsp;</td>
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
<? pg_close();?>