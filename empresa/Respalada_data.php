<?include ("../class/seguridad.inc");include ("../class/conects.php");include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); 
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{?><script language="JavaScript"> document.location='menu.php';</script><?}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONFIGURACI&Oacute;N GENERAR ARCHIVOS</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../class/sia.js"  type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function revisar(){ var f=document.form1; var mmodulos="";
    if(f.checkbox1.checked==true){mmodulos=mmodulos+"S";}else{mmodulos=mmodulos+"N";}
    if(f.checkbox2.checked==true){mmodulos=mmodulos+"S";}else{mmodulos=mmodulos+"N";}
    if(f.checkbox3.checked==true){mmodulos=mmodulos+"S";}else{mmodulos=mmodulos+"N";}
    if(f.checkbox4.checked==true){mmodulos=mmodulos+"S";}else{mmodulos=mmodulos+"N";}
    if(f.checkbox5.checked==true){mmodulos=mmodulos+"S";}else{mmodulos=mmodulos+"N";}
    if(f.checkbox6.checked==true){mmodulos=mmodulos+"S";}else{mmodulos=mmodulos+"N";}
    if(f.checkbox7.checked==true){mmodulos=mmodulos+"S";}else{mmodulos=mmodulos+"N";}
    if(f.checkbox8.checked==true){mmodulos=mmodulos+"S";}else{mmodulos=mmodulos+"N";}
    if(f.checkbox9.checked==true){mmodulos=mmodulos+"S";}else{mmodulos=mmodulos+"N";}
	f.txtmodulos.value=mmodulos;
    r=confirm("Desea Generar el Respaldo ?");  if (r==true) {valido=true;} else{return false;}
document.form1.submit;
return true;}
function LlamarURL(url) {document.location = url;}


</script> 
</head>
<?php
$sql="SELECT tablename FROM pg_tables WHERE schemaname = 'public' and substring(tablename,1,4)<>'pga_' order by tablename";
$nchk='checked';
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">RESPALDAR BASE DE DATOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="295" border="1">
  <tr>
    <td width="92"><table width="92" height="287" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick=javascript:LlamarURL('menu_u.php');
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu_u.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Principal</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
</table></td>
    <td width="870"><div id="Layer1" style="position:absolute; width:868px; height:373px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="respalda_arch.php" onSubmit="return revisar()">
        <table width="824" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> <td>&nbsp;</td> </tr>          
          <tr>
            <td width="800"><table width="800" height="19" border="0" cellpadding="0">
				<tr>
				  <td width="170"><span class="Estilo5">TIPO DE RESPALDO  :</span></td>
				  <td width="280"><span class="Estilo5"><Select name="txttipo_resp" size="1" onFocus="encender(this)" onBlur="apagar(this)" id="txttipo_resp"><option>TOTAL</option>  <option>MODULOS ESPECIFICOS</option></Select> </span></td>
				  <td width="350"><span class="Estilo5"></span></td>
				  </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>
		  <tr>
            <td width="800"><table width="800" height="19" border="0" cellpadding="0">
				<tr>
				  <td width="200"><span class="Estilo5">ESPECIFIQUE MODULOS A RESPALDAR  :</span></td>
			</tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td width="800"><table width="800" height="19" border="1" cellspacing="1" cellpadding="1">
				<tr>
				  <td width="160"><input class="Estilo5" name="checkbox1" type="checkbox" id="1" value="checkbox" <? echo $nchk; ?>>
                      <span class="Estilo5">PRESUPUESTO </span> </td>
				  <td width="160"><input class="Estilo5" name="checkbox2" type="checkbox" id="1" value="checkbox" <? echo $nchk; ?>>
                      <span class="Estilo5">CONTABILIDAD </span> </td>
				  <td width="160"><input class="Estilo5" name="checkbox3" type="checkbox" id="1" value="checkbox" <? echo $nchk; ?>>
                      <span class="Estilo5">BANCOS </span> </td>
				  <td width="160"><input class="Estilo5" name="checkbox4" type="checkbox" id="1" value="checkbox" <? echo $nchk; ?>>
                      <span class="Estilo5">ORDEN PAGOS </span> </td>	
                  <td width="160"><input class="Estilo5" name="checkbox5" type="checkbox" id="1" value="checkbox" <? echo $nchk; ?>>
                      <span class="Estilo5">COMPRAS </span> </td>						  
				</tr>
				<tr>
				  <td width="160"><input class="Estilo5" name="checkbox6" type="checkbox" id="1" value="checkbox" <? echo $nchk; ?>>
                      <span class="Estilo5">INGRESOS </span> </td>
				  <td width="160"><input class="Estilo5" name="checkbox7" type="checkbox" id="1" value="checkbox" <? echo $nchk; ?>>
                      <span class="Estilo5">BIENES </span> </td>
				  <td width="160"><input class="Estilo5" name="checkbox8" type="checkbox" id="1" value="checkbox" <? echo $nchk; ?>>
                      <span class="Estilo5">NOMINA </span> </td>
				  <td width="160"><input class="Estilo5" name="checkbox9" type="checkbox" id="1" value="checkbox" <? echo $nchk; ?>>
                      <span class="Estilo5">EMPRESA</span> </td>	
                  <td width="160"> <span class="Estilo5"> </span> </td>						  
				</tr>
            </table></td>
          </tr>		  
		  
		  <tr> <td>&nbsp;</td> </tr>
          <tr> <td>&nbsp;</td> </tr>
		  <tr> <td>&nbsp;</td> </tr>
        </table>
        <table width="768">
          <tr>
            <td width="600">&nbsp;</td>
			<td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
			 <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
			 <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
			 <td width="5"><input name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
			 <td width="5"><input name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>
			<td width="5"><input name="txtmodulos" type="hidden" id="txtmodulos" value="NNNNNNNNNN" ></td>
             <td width="68" valign="middle"><input name="button" type="submit" id="button"  value="GENERAR RESPALDO"></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        </form>
    </div>
  </tr>
</table>
</body>
</html>
<?pg_close();?>
