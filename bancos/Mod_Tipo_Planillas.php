<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
if (!$_GET){$codigo=''; $sql="SELECT * FROM ban011 ORDER BY codigo";} else{$codigo=$_GET["Gcodigo"]; $sql="Select * from ban011 where codigo='$codigo'";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL BANCARIO (Tipos Planillas de Retenci&oacute;n)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js"  type="text/javascript"></script>
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
  if(f.txtcodigo.value==""){alert("Tipo de planilla no puede estar Vacio");return false;}else{f.txtcodigo.value=f.txtcodigo.value.toUpperCase();}
  if(f.txtdescripcion.value==""){alert("Descripción no puede estar Vacia"); return false; } else{f.txtdescripcion.value=f.txtdescripcion.value.toUpperCase();}
  document.form1.submit;
return true;}
</script>

</head>
<?
$descripcion="";$nro_planilla="";$formato_planilla="";$formato_relacion="";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); $codigo=$registro["codigo"]; $descripcion=$registro["descripcion"];$nro_planilla=$registro["nro_planilla"];$formato_planilla=$registro["formato_planilla"]; $formato_relacion=$registro["formato_relacion"]; }
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR TIPO PLANILLAS DE RETENCI&Oacute;N </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="359" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="344" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Tipo_Planillas.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu  href="Act_Tipo_Planillas.php">Atras</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:866px; height:341px; z-index:1; top: 70px; left: 116px;">
        <form name="form1" method="post" action="Update_tipo_planilla.php" onSubmit="return revisar()">
              <table width="860" height="147" border="0" align="center" >
              <tr><td>&nbsp;</td> </tr>
              <tr>
                <td><table width="850" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="200"><span class="Estilo5">TIPO DE PLANILLA :</span></td>
                      <td width="650"><span class="Estilo5">
                        <input name="txtcodigo" type="text"  id="txtcodigo"  value="<?echo $codigo?>" size="4" maxlength="2" readonly>
                      </span></td>
                    </tr>
                </table></td>
              </tr>
              <tr><td>&nbsp;</td> </tr>
              <tr>
                <td><table width="850" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="200"><span class="Estilo5">DESCRIPCI&Oacute;N TIPO PLANILLA : </span></td>
                      <td width="650"><span class="Estilo5">
                        <input name="txtdescripcion" type="text" id="txtdescripcion"  value="<?echo $descripcion?>" size="90" maxlength="100" onFocus="encender(this)" onBlur="apagar(this)" >
                      </span> </td>
                    </tr>
                </table></td>
              </tr>
              <tr><td>&nbsp;</td> </tr>
              <tr>
                <td><table width="850" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                  <tr>
                    <td width="230"><span class="Estilo5">NOMBRE FORMATO PLANILLA :</span></td>
                    <td width="620"><span class="Estilo5">
                      <input name="txtformato_planilla" type="text"  id="txtformato_planilla"  value="<?echo $formato_planilla?>" size="90" maxlength="100" onFocus="encender(this)" onBlur="apagar(this)" >
                    </span></td>
                  </tr>
                </table></td>
              </tr>
              <tr><td>&nbsp;</td> </tr>
              <tr>
                <td><table width="850" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="230"><span class="Estilo5">FORMATO PLANILLA DE RETENCI&Oacute;N :</span></td>
                      <td width="620"><span class="Estilo5">
                          <input name="txtformato_relacion" type="text"  id="txtformato_relacion"  value="<?echo $formato_relacion?>" size="90" maxlength="100" onFocus="encender(this)" onBlur="apagar(this)" >
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
                <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
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