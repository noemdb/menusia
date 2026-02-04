<?php include ("../class/seguridad.inc");include ("../class/conects.php");include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); 
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?php }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONFIGURACI&Oacute;N GENERAR ARCHIVOS</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language=JavaScript src="../class/sia.js"  type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function revisar(){ var f=document.form1; var tsql=f.txtsqle.value; var str2='';
    if(f.txtsqle.value==""){alert("Sentencia no puede estar Vacia");return false;} 
    for (i = 0; i < tsql.length; i++){if ((tsql.charAt(i)=="'")){str2=str2+";";}else{str2=str2+tsql.charAt(i);} }
	f.txtsql.value=str2;	
    if(f.txttipo_formato.value==""){alert("Formato de Archivo no puede estar Vacio");return false;} 
	else{f.txttipo_formato.value=f.txtformato.value.toUpperCase();}	
document.form1.submit;
return true;}
function LlamarURL(url) {document.location = url;}
</script> 
</head>
<?php
$sql="SELECT tablename FROM pg_tables WHERE schemaname = 'public' and substring(tablename,1,4)<>'pga_' order by tablename";
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">GENERAR ARCHIVOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="395" border="1">
  <tr>
    <td width="92"><table width="92" height="387" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick=javascript:LlamarURL('menu_u.php');
          onMouseOut="this.style.backgroundColor='#EAEAEA';" height="35"  bgColor=#EAEAEA><A class=menu href="menu_u.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA';" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Principal</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
</table></td>
    <td width="870"><div id="Layer1" style="position:absolute; width:868px; height:373px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="genera_arch.php" onSubmit="return revisar()">
        <table width="824" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> <td>&nbsp;</td> </tr>          
          <tr>
            <td width="800"><table width="800" height="19" border="0" cellpadding="0">
				<tr>
				  <td width="170"><span class="Estilo5">FORMATO DE ARCHIVO  :</span></td>
				  <td width="280"><span class="Estilo5"><Select name="txttipo_formato" size="1" onFocus="encender(this)" onBlur="apagar(this)" id="txttipo_formato"><option>ARCHIVO TXT SEPARADO</option>  <option>ARCHIVO EXCEL</option> <option>ARCHIVO SQL</option> </Select> </span></td>
				  <td width="200"><span class="Estilo5">SEPARADOR PARA ARCHIVO TXT  :</span></td>
				  <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtseparados" type="text" id="txtseparados"  size="1" maxlength="1" value=";" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
				 </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>
		  <tr>
            <td width="800"><table width="800" height="19" border="0" cellpadding="0">
				<tr>
				  <td width="250"><span class="Estilo5">INCLUIR ENCABEZADO EN EL ARCHIVO  :</span></td>
				  <td width="200"><span class="Estilo5"><Select name="txtinc_encab" size="1" onFocus="encender(this)" onBlur="apagar(this)" id="txtinc_encab"><option>SI</option>  <option>NO</option> </Select> </span></td>
			      <td width="200"><span class="Estilo5">NOMBRE DE TABLA PARA SQL  :</span></td>
				  <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtnombre_tabla" type="text" id="txtnombre_tabla"  size="15" maxlength="15" value="" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
			 </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td width="800"><table width="800" height="19" border="0" cellpadding="0">
				<tr>
				  <td width="250"><span class="Estilo5">INSTRUCCION SQL  :</span></td>
				  <td width="550"><span class="Estilo5"></span></td>
				 
				</tr>
            </table></td>
          </tr>		  
		  <tr>
			  <td><table width="800">
				  <tr>
					<td width="800"><textarea name="txtsqle" cols="100" rows="8" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" id="txtsqle"></textarea></td>
				  </tr>
			  </table></td>
		  </tr>
		  
          <tr> <td>&nbsp;</td> </tr>
		  <tr> <td>&nbsp;</td> </tr>
        </table>
        <table width="768">
          <tr>
            <td width="600">&nbsp;</td>
			<td width="5"><input name="txtsql" type="hidden" id="txtsql" value="" ></td>
             <td width="68" valign="middle"><input name="button" type="submit" id="button"  value="GENERAR ARCHIVO"></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        </form>
    </div>
  </tr>
</table>
</body>
</html>
<?php pg_close();?>
