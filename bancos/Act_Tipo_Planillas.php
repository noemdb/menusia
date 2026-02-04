<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{$Nom_Emp=busca_conf();}
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="01-0000040"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); 
if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){ $codigo=''; $sql="SELECT * FROM ban011 ORDER BY codigo"; $p_letra=""; }
else {$codigo = $_GET["Gcodigo"];$p_letra=substr($codigo, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$codigo=substr($codigo,1,12);} else{$codigo=substr($codigo,0,12);}
  $sql="Select * from ban011 where codigo='$codigo' ";
  if ($p_letra=="P"){$sql="SELECT * FROM ban011 ORDER BY codigo";}
  if ($p_letra=="U"){$sql="SELECT * From ban011 Order by codigo desc";}
  if ($p_letra=="S"){$sql="SELECT * From ban011 Where (codigo>'$codigo') Order by codigo";}
  if ($p_letra=="A"){$sql="SELECT * From ban011 Where (codigo<'$codigo') Order by codigo desc";}
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Tipos Planillas de Retenci&oacute;n)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"   rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){
var murl; var Gcodigo;
    Gcodigo=document.form1.txtcodigo.value; murl=url+Gcodigo;
    if(Gcodigo==""){alert("Tipo de Planilla no puede Modificar");} else{document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_Tipo_Planillas.php";
   if(MPos=="P"){murl="Act_Tipo_Planillas.php?Gcodigo=P"}
   if(MPos=="U"){murl="Act_Tipo_Planillas.php?Gcodigo=U"}
   if(MPos=="S"){murl="Act_Tipo_Planillas.php?Gcodigo=S"+document.form1.txtcodigo.value;}
   if(MPos=="A"){murl="Act_Tipo_Planillas.php?Gcodigo=A"+document.form1.txtcodigo.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;var Gcodigo;
  Gcodigo=document.form1.txtcodigo.value;
  if(Gcodigo==""){alert("Tipo de Planilla no puede Eliminar");}
  else{ r=confirm("Esta seguro en Eliminar el Tipo de Planilla ?");
      if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Tipo de Planilla ?");
      if (r==true) {url="Delete_tipo_planilla.php?txtcodigo="+document.form1.txtcodigo.value;  VentanaCentrada(url,'Eliminar Tipo de Planilla','','400','400','true');}}else { url="Cancelado, no elimino"; }
  }
}
</script>
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
</head>
<?
$descripcion="";$nro_planilla="";$formato_planilla="";$formato_relacion="";$res=pg_query($sql);$filas=pg_num_rows($res); if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From ban011 ORDER BY codigo";} if ($p_letra=="A"){$sql="SELECT * From ban011 ORDER BY codigo desc";} $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); $codigo=$registro["codigo"]; $descripcion=$registro["descripcion"];$nro_planilla=$registro["nro_planilla"];$formato_planilla=$registro["formato_planilla"]; $formato_relacion=$registro["formato_relacion"]; }
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">TIPO PLANILLAS DE RETENCI&Oacute;N </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="979" height="358" border="1" id="tablacuerpo">
  <tr>
    <td height="352"><table width="92" height="344" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
        <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
		<tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_Tipo_Planillas.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Inc_Tipo_Planillas.php">Incluir</a></div></td>
        </tr>
        <?} if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
		<tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_Tipo_Planillas.php?Gcodigo=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu  href="javascript:Llamar_Ventana('Mod_Tipo_Planillas.php?Gcodigo=')">Modificar</a></div></td>
        </tr>
		<?}if ($Mcamino{2}=="S"){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu  href="javascript:Mover_Registro('P');">Primero</a></div></td>
        </tr>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></div></td>
        </tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
        </tr><tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
        </tr>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_tipo_planilla.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_act_tipo_planilla.php" class="menu">Catalogo</a></div></td>
        </tr>
		<?} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></div></td>
        </tr>
		<?}?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></div></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
    </table></td>
    <td width="870"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
        <div id="Layer1" style="position:absolute; width:866px; height:272px; z-index:1; top: 70px; left: 116px;">
          <form name="form1" method="post">
            <table width="860" height="147" border="0" align="center" >
              <tr><td>&nbsp;</td> </tr>
              <tr>
                <td><table width="850" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="200"><span class="Estilo5">TIPO DE PLANILLA :</span></td>
                      <td width="650"><span class="Estilo5"><input name="txtcodigo" type="text"  id="txtcodigo"  value="<?echo $codigo?>" size="4" maxlength="2" readonly>  </span></td>
                    </tr>
                </table></td>
              </tr>
              <tr><td>&nbsp;</td> </tr>
              <tr>
                <td><table width="850" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="200"><span class="Estilo5">DESCRIPCI&Oacute;N TIPO PLANILLA : </span></td>
                      <td width="650"><span class="Estilo5"> <input name="txtdescripcion" type="text" id="txtdescripcion"  value="<?echo $descripcion?>" size="90" maxlength="100" readonly>   </span> </td>
                    </tr>
                </table></td>
              </tr>
              <tr><td>&nbsp;</td> </tr>
              <tr>
                <td><table width="850" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                  <tr>
                    <td width="230"><span class="Estilo5">NOMBRE FORMATO PLANILLA :</span></td>
                    <td width="620"><span class="Estilo5"><input name="txtformato_planilla" type="text"  id="txtformato_planilla"  value="<?echo $formato_planilla?>" size="90" maxlength="100" readonly>   </span></td>
                  </tr>
                </table></td>
              </tr>
              <tr><td>&nbsp;</td> </tr>
              <tr>
                <td><table width="850" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="230"><span class="Estilo5">NOMBRE RELACION PLANILLA :</span></td>
                      <td width="620"><span class="Estilo5"><input name="txtformato_relacion" type="text"  id="txtformato_relacion"  value="<?echo $formato_relacion?>" size="90" maxlength="100" readonly>
                      </span></td>
                    </tr>
                </table></td>
              </tr>
              <tr><td>&nbsp;</td> </tr>
            </table>
            <p>&nbsp;</p>
          </form>
      </div></td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>