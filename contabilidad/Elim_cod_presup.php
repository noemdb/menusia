<?include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){  $cod_presup='';} else {  $cod_presup = $_GET["Gcod_presup"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD FINANCIERA (Eliminar Asociacion Contables)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
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
function revisar(){var f=document.form1; var r; var valido;
   if(f.txtcod_presup.value==""){alert("Codigo no puede estar Vacio");return false;}
   r=confirm("Desea Eliminar la Asociacion ?");  if (r==true) { valido=true;} else{return false;}  
document.form1.submit;
return true;}
</script>
<?
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
$cod_contab_asoc="";$denominacion=""; $nombre_cuenta="";
$sql="Select * from con019 where cod_presup='$cod_presup'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){ $cod_presup=$registro["cod_presup"];  $cod_contab_asoc=$registro["cod_contab_asoc"];}

$sSQL="Select * from pre001 WHERE cod_presup='$cod_presup'";
$resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
if ($registro=pg_fetch_array($resultado,0)){  $denominacion=$registro["denominacion"];}

$sSQL="Select * from con001 WHERE codigo_cuenta='$cod_contab_asoc'";      $resultado=pg_query($sSQL);   $filas=pg_num_rows($resultado);
$resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
if ($registro=pg_fetch_array($resultado,0)){  $nombre_cuenta=$registro["nombre_cuenta"];}
		
?>
</head>

<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ELIMINAR ASOCIACION CUENTAS DE ACTIVOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_asoc_activo_hacienda.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu
            href="Act_asoc_activo_hacienda.php">Atras</A></td>
      </tr>	  
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu
            href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:338px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="Delete_cod_presup.php" onSubmit="return revisar()">
        <p>&nbsp;</p>
        <table width="859" height="136" border="0" id="tabcampos">
		  <tr>
			  <td><table width="859" border="0">
				  <tr>
					<td width="159"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :</span></td>
					<td width="300"><span class="Estilo5"><input name="txtcod_presup" type="text" id="txtcod_presup" title="Registre C&oacute;digo Presupuestario"  size="30" maxlength="30" readonly value="<?echo $cod_presup?>"> </span></td>
					<td width="20"><input name="txtcod_contable" type="hidden" id="txtcod_contable"></td>
					<td width="30"><input name="txtdes_contable" type="hidden" id="txtdes_contable"></td>
					<td width="20"><input name="txtcod_fuente" type="hidden" id="txtcod_fuente"></td>
					<td width="20"><input name="txtdes_fuente" type="hidden" id="txtdes_fuente"></td>
					<td width="10"><input name="txtdisponible" type="hidden" id="txtdisponible"></td>
				  </tr>
			  </table></td>
		 </tr>
		 <tr>
          <td>
            <table width="621" border="0">
              <tr>
                <td width="110"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                <td width="494"><span class="Estilo5"><textarea name="txtdenominacion" cols="58" rows="2" readonly="readonly" id="txtdenominacion"><?echo $denominacion?></textarea>
                </span></td>
              </tr>
            </table>   
		  </td>
        </tr>
		<tr>
            <td height="14"><table width="843" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="135"><span class="Estilo5">C&Oacute;DIGO ASOCIADO :</span></td>
                  <td width="238"><span class="Estilo5"><input name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta"   readonly value="<?echo $cod_contab_asoc?>" size="25">   </span></td>
                  <td width="470"><span class="Estilo5"> <input name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta"  readonly  value="<?echo $nombre_cuenta?>" size="70">   </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
             <td><p>&nbsp;</p> </td>         
		  </tr>
		  
         
        </table>
        <div align="center">
          <p>&nbsp;</p>
          </div>
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
			<td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Eliminar"></td>
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