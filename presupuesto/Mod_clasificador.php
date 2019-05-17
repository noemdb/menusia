<?include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){$cod_partida='';} else {$cod_partida=$_GET["Gpartida"];}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd"> 
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Modificar Clasificador de Partidas)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
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
function revisar(){var f=document.form1;var Valido;
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
$den_partida="";$aplicacion="";$func_inv="";$cod_contable=""; $nombre_cuenta="";
$sql="Select cod_partida,den_partida,aplicacion,ord_cord,func_inv,cod_contable from pre098 where cod_partida='$cod_partida'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $cod_partida=$registro["cod_partida"];$den_partida=$registro["den_partida"];  $aplicacion=$registro["aplicacion"];$func_inv=$registro["func_inv"];  $cod_contable=$registro["cod_contable"];}
$sSQL="Select * from con001 WHERE codigo_cuenta='$cod_contable'";  $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
if ($filas>0){$registro=pg_fetch_array($resultado); $nombre_cuenta=$registro["nombre_cuenta"];}
?>
</head>
<body>
<script language="JavaScript" type="text/JavaScript">
function asig_tgasto(mvalor){var f=document.form1;
    if(mvalor=="C"){f.txtTipo_Gasto.options[0].selected = true;}
    if(mvalor=="I"){f.txtTipo_Gasto.options[1].selected = true;}
}
</script>
<table width="977" height="38" border="0" bgcolor="#000066" id="tablaencabezado">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR CLASIFICADOR DE PARTIDAS</div></td>
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
      <form name="form1" method="post" action="Update_clasificador.php" onSubmit="return revisar()">
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
                    <td width="631"><span class="Estilo5"><input class="Estilo10" name="txtCodigo_Partida" type="text" id="txtCodigo_Partida" title="Registre el C&oacute;digo de la Partida" size="30" maxlength="30" readonly value="<?echo $cod_partida?>"></span></td>
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
                      <td width="659"><input class="Estilo10" name="txtNombre_Partida" type="text" id="txtNombre_Partida" title="Registre la denominaci&oacute;n de la Partida" size="100" value="<?echo $den_partida?>" maxlength="200"  onFocus="encender(this)" onBlur="apagar(this)"></td>
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
                    <td width="231"><span class="Estilo5"> <select class="Estilo10" name="txtTipo_Gasto" size="1" id="txtTipo_Gasto" onFocus="encender(this)" onBlur="apagar(this)"><option selected>CORRIENTE</option>   <option>INVERSION</option></select>
                      <script language="JavaScript" type="text/JavaScript"> asig_tgasto('<?echo $func_inv;?>');</script>
                    </span></td>
                    <td width="119"><span class="Estilo5">APLICACI&Oacute;N :</span></td>
                    <td width="273"><input class="Estilo10" name="txtAplicacion" type="text" id="txtAplicacion" title="Registre el Tipo de Aplicacion" size="4" maxlength="1"  value="<?echo $aplicacion?>" onFocus="encender(this)" onBlur="apagar(this)"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="800" border="0">
                  <tr>
                    <td width="159"><span class="Estilo5">CODIGO DE CUENTA :</span></td>
                    <td width="150"><input class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" title="Registre el Codigo de Cuenta" size="30" maxlength="30"  value="<?echo $cod_contable?>" onFocus="encender(this)" onBlur="apagar(this)"></td>
                    <td width="35"><input class="Estilo10" name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo Codigo de Cuentas"  onclick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=6-1','SIA','','750','500','true')" value="..."></td>
                    <td width="460"><input class="Estilo10" name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta" size="70" maxlength="250" value="<?echo $nombre_cuenta?>" readonly></td>
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
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
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